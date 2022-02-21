<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$memIdx = $_COOKIE["_CKE_USER_UID"]; //회원 인덱스

/*
과거에 결제했던 내역이 있는지 가져온다. 

결제했던 내역이 있으면, 적정주가가 갱신 되었는지 알려준다. 

//sameFlag는 3가지이다. 
//1. 처음 조회 0 jongmokValueHistory insert
//2. 재 조회 (가격 변동 없음) 1
//3. 재 조회 (가격 변동 있음) 2 jongmokValueHistory insert
*/



$sql = "

SELECT A.name,A.updateDate as recentUpdateDate,B.code,date(B.searchDate) as searchDate,A.value,A.adjustValue,B.updateDate as lastUpdateDate,B.value as historyValue

FROM jongmokValue A INNER JOIN jongmokValueHistory B ON A.code = B.code

WHERE B.memIdx=$memIdx and B.code='$jongmokCode' order by searchDate desc limit 0,1; 
";

$tmpRs = mysql_query($sql);

if(mysql_num_rows($tmpRs))	//과거 조회했던 내역이 있는가? 0 1 2
{
	$rs = mysql_fetch_array($tmpRs);
	
	$value = round($rs["value"]+($rs["value"]*$rs["adjustValue"]),-1); //현재 기준 적정주가 데이터베이스에서 가져온 가격	
	
	
	$gap = 	($value-$rs['historyValue'])/($rs['historyValue'])*100;
			
	if( $gap  > 12.5  || $gap < -12.5  ) //가격 차이가 +- 12.5% 이상 차이나면 변동 된 것으로 간주한다.
	{
		$gapFlag = "2"; //변동
	}else {		
		$gapFlag = "1"; //변동 없음
	}
	
}
else { //처음 조회이면
	$gapFlag = "0";
}
//echo $gapFlag;

//echo $jongmokCode ."  | ".$name."  | ". $freeFlag."  | ". $adminFlag."  | ". $gapFlag;

//exit;

?>
<script type="text/javascript">
parent.chkMain('<?=$jongmokCode?>','<?=$name?>','<?=$freeFlag?>','<?=$adminFlag?>','<?=$gapFlag?>');
</script>