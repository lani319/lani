<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
�˻� ����� �����ִ� ���
*/

//���������� ���� �������� 20170818 �� ��� ����ȸ���� �� �� �ְ� ����
$admin_level = $_COOKIE['_CKE_USER_LEVEL'];



if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



//20170818 ����ȸ�� + �����ڴ� ���� ������ ����
$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"gradeLevel");
$gLevel = $meminfo[gradeLevel];
//gLevel =1 �̸� �� ���δ�. 


$code = $searchKeyword; //�����ڵ�
$memIdx = $_COOKIE["_CKE_USER_UID"]; //ȸ�� �ε���
$searchIP = $_SERVER['REMOTE_ADDR']; //ȸ�� ���� ������
//$freeFlag = "F"; //�������� ����, �⺻���� F�� ����.
$remainCnt = 0; //�ܿ� �˻��Ǽ�
$sumPrice = 0; //ȸ���� ���� �����ݾ�
$value = 0; //�����ְ�


//�ش� ������ �������� �����̸� �׳� ����
$sql = "select freeFlag from jongmokValue where code = '$searchKeyword'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
if($rs['freeFlag']=="T") {
	$freeFlag = "T";
}


//���⿡�� ���� �����̸鼭 �����ڰ� �ƴϸ� �ܿ� �˻��Ǽ��� �ִ��� �˻�, �ܰ��� ������ ��� �����ش�.
//�ܰ��� ������ ���â �����ְ� ����������� �Ѿ��.
if($freeFlag=="F" && $gLevel<>1) { 	
	/*
	//�����ݾ� ��������
	$sql = "select sum(price) as price from jongmokValueChargeInfo where memIdx = $memIdx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$sumPrice = $rs[0];
	
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx = $memIdx and freeFlag = 'F' "; //�����ݾ� ���� ����˻� �����丮 db���� �Ǽ� x 11000���� �ؼ� ���Ѵ�. 
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = ($sumPrice - $rs[0]*11000)/11000;
	*/
	//20170828 ������ ����. Member�� ī��Ʈ �����´�.
	$sql = "select jongmokCnt as cnt from Member where idx = ".$memIdx; //�����ݾ� ���� ����˻� �����丮 db���� �Ǽ� x 11000���� �ؼ� ���Ѵ�. 
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = $rs[0];
	
	if ($remainCnt < 1){
		echo "<script>alert('�����ݾ��� �����մϴ�. ���� �� �̿��� �ּ���');location.href='pay.php';</script>";
		exit;
		}

}




//Ű���带 �̿��ؼ� �����ְ��� �˻��Ѵ�. 
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
<td width="150px" height="35px" class="white">�����</td>
<td width="100px" class="white">�����ڵ�</td>
<td width="50px" class="white">����</td>
<td class="white">�����ְ�</td>
<td class="white">�����ְ� ������</td>
</tr>
<?php
	while($rs = mysql_fetch_array($tmpRs))
	{
	
	$updateDate = $rs['updateDate'];
	$value = round( $rs["value"]+($rs["value"]*$rs["adjustValue"]),-1); //���� ���� �����ְ�
	$jongmokCode = "A".$rs["code"];
?>
	<tr align="center">
	<td height="80px"><?=$rs["name"]?></td>
	<td><?=$rs["code"]?></td>
	<td><?=$rs["type"]?></td>
	<td style="color:#FF4500;size:20px;font-weight:bold;"><?=number_format($value)?>��</td>
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
//�˻������� DB�� �����ϴ� ���,HISTORY
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
	//�ߺ� ������ �������� ���� ��¥�� �ش� ������ �˻��� ������ �ִ��� ���캻��. 
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx='$memIdx' and code='$code' and date(searchDate)=date(now())";
	//echo $sql;
	//echo "<br>";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[cnt]==0){		
		
		//������ �˻��ߴ� ������ ������ ���� ������ ���� �������� �ٲ۴�.
		$sql = "update jongmokValueHistory set newFlag=1 where code='$code' and memIdx = '$memIdx'";
		mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
		
		$sql = "insert into jongmokValueHistory(code,memIdx,searchDate,searchIP,searchKeyword,freeFlag,updateDate,value) values('$code','$memIdx',now(),'$searchIP','$searchKeywordOld','$freeFlag','$updateDate',$value)";
		//echo $sql;
		mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
		//echo "���� ����";
		
		
		//���� �˻� ī��Ʈ ����
			$sql = "update jongmokValue set cnt=cnt+1 where code = '$code'";
			mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
			//echo $sql;
			//echo "<br><br>���� ����";
			
		
		if($gLevel <> 1) // ������ �Ǵ� ����ȸ���� �ƴϸ� ����
		{	
			if($freeFlag=="F")
			{
				//Member ���̺����� �ܿ� ����˻��Ǽ� -1
				$sql = "update Member set jongmokCnt = jongmokCnt-1 where idx = '$memIdx'";
				//echo $sql;
				mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
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