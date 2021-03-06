<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
검색 결과를 보여주는 기능
*/

//관리자인지 여부 가져오기 20170818 이 기능 유료회원도 볼 수 있게 수정
$admin_level = $_COOKIE['_CKE_USER_LEVEL'];



if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



//20170818 유료회원 + 관리자는 차감 없도록 수정
$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"gradeLevel");
$gLevel = $meminfo[gradeLevel];
//gLevel =1 이면 다 보인다. 


$code = $searchKeyword; //종목코드
$memIdx = $_COOKIE["_CKE_USER_UID"]; //회원 인덱스
$searchIP = $_SERVER['REMOTE_ADDR']; //회원 접속 아이피
//$freeFlag = "F"; //무료종목 여부, 기본값은 F로 유료.
$remainCnt = 0; //잔여 검색건수
$sumPrice = 0; //회원의 누적 결제금액
$value = 0; //적정주가


//해당 종목이 무료제공 종목이면 그냥 진행
$sql = "select freeFlag from jongmokValue where code = '$searchKeyword'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
if($rs['freeFlag']=="T") {
	$freeFlag = "T";
}


//여기에서 유료 종목이면서 관리자가 아니면 잔여 검색건수가 있는지 검사, 잔고가 있으면 결과 보여준다.
//잔고가 없으면 경고창 보여주고 결제기능으로 넘어간다.
if($freeFlag=="F" && $gLevel<>1) { 	
	/*
	//결제금액 가져오기
	$sql = "select sum(price) as price from jongmokValueChargeInfo where memIdx = $memIdx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$sumPrice = $rs[0];
	
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx = $memIdx and freeFlag = 'F' "; //결제금액 빼기 종목검색 히스토리 db에서 건수 x 11000원을 해서 비교한다. 
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = ($sumPrice - $rs[0]*11000)/11000;
	*/
	//20170828 어윤학 수정. Member의 카운트 가져온다.
	$sql = "select jongmokCnt as cnt from Member where idx = ".$memIdx; //결제금액 빼기 종목검색 히스토리 db에서 건수 x 11000원을 해서 비교한다. 
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = $rs[0];
	
	if ($remainCnt < 1){
		echo "<script>alert('충전금액이 부족합니다. 결제 후 이용해 주세요');location.href='pay.php';</script>";
		exit;
		}

}




//키워드를 이용해서 적정주가를 검색한다. 
//$sql = "select * from jongmokValue where code = '$searchKeyword'  ";
$sql = "select * from jongmokValue where code like '%$searchKeyword' or  name like  '%$searchKeyword' ";
$tmpRs = mysql_query($sql);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/table02.css">

<script type="text/javascript">
function remainCntReload()
{		
	parent.frmright.location.reload(); //main01	
}

function goSearch(name)
{
	parent.parent.topFrame.document.getElementById("searchKeyword").value = name;
	parent.parent.topFrame.goSearch();
}
</script>
</head>
<body  leftmargin="50px">
<img src="img/title03.gif">
<table border="0" cellpadding="0" cellspacing="0" width="650px" class="table01">
<tr class="thSearch01">
<td width="150px" height="35px" class="white">종목명</td>
<td width="100px" class="white">종목코드</td>
<td width="50px" class="white">구분</td>
<td class="white">적정주가</td>
<td class="white">적정주가 기준일</td>
</tr>
<?php
	while($rs = mysql_fetch_array($tmpRs))
	{
	
	$updateDate = $rs['updateDate'];
	$value = round( $rs["value"]+($rs["value"]*$rs["adjustValue"]),-1); //현재 기준 적정주가
	$jongmokCode = "A".$rs["code"];
?>
	<tr align="center">
	<td height="80px"><?=$rs["name"]?></td>
	<td><?=$rs["code"]?></td>
	<td><?=$rs["type"]?></td>
	<td style="color:#FF4500;size:20px;font-weight:bold;"><?=number_format($value)?>원</td>
	<td><?=$rs['updateDate']?></td>
	</tr>			
<?php
	}
?>
<tr><td  colspan="10" ><img src="img/notice_result.gif"></td></tr>
</table>
<br>
<br>
<br>
<!--
<iframe width=650px height=480px frameborder=0  src = "../2016jongmokValue/ptcn_chart.php?code=<?=$jongmokCode?>"></iframe>
-->

<?php
//검색내역을 DB에 저장하는 기능,HISTORY
//db:jongmokValueHistory
/*
idx
code
memIdx
searchDate
searchIP
searchKeyword = searchKeywordOld
*/

if($sameFlag <> 1)	//
{
	//중복 삽입을 막기위해 같은 날짜에 해당 종목을 검색한 내역이 있는지 살펴본다. 
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx='$memIdx' and code='$code' and date(searchDate)=date(now())";
	//echo $sql;
	//echo "<br>";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[cnt]==0){		
		
		//기존에 검색했던 종목이 있으면 동일 종목을 과거 종목으로 바꾼다.
		$sql = "update jongmokValueHistory set newFlag=1 where code='$code' and memIdx = '$memIdx'";
		mysql_query($sql) or die("ERROR. 고객센터로 연락주세요");
		
		$sql = "insert into jongmokValueHistory(code,memIdx,searchDate,searchIP,searchKeyword,freeFlag,updateDate,value) values('$code','$memIdx',now(),'$searchIP','$searchKeywordOld','$freeFlag','$updateDate',$value)";
		//echo $sql;
		mysql_query($sql) or die("ERROR. 고객센터로 연락주세요");
		//echo "삽입 성공";
		
		
		//종목 검색 카운트 증가
			$sql = "update jongmokValue set cnt=cnt+1 where code = '$code'";
			mysql_query($sql) or die("ERROR. 고객센터로 연락주세요");
			//echo $sql;
			//echo "<br><br>갱신 성공";
			
		
		if($gLevel <> 1) // 관리자 또는 유료회원이 아니면 차감
		{	
			if($freeFlag=="F")
			{
				//Member 테이블에서 잔여 종목검색건수 -1
				$sql = "update Member set jongmokCnt = jongmokCnt-1 where idx = '$memIdx'";
				//echo $sql;
				mysql_query($sql) or die("ERROR. 고객센터로 연락주세요");
			}
		}
	}
}
	
?>

<script>
remainCntReload();
</script>
</body>
</html>