<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* �����ݾװ� �ܰ� �������� */



if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}
/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$admin_level = $_COOKIE['_CKE_USER_LEVEL'];

$memIdx = $_COOKIE["_CKE_USER_UID"]; //ȸ�� �ε���
$remainCnt = 0; //�ܿ� �˻��Ǽ�
$sumPrice = 0; //ȸ���� ���� �����ݾ�

//echo "A : ".$admin_level."<br>";

if($admin_level!=0 && $admin_level!=4) { 	
	/*
	//�����ݾ� ��������
	$sql = "select sum(price) as price from jongmokValueChargeInfo where memIdx = $memIdx and state in (1,3,6,10,12)";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$sumPrice = $rs[0];
	
	//echo $sumPrice."<br>";
	
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx = $memIdx and freeFlag = 'F' "; //�����ݾ� ���� ����˻� �����丮 db���� �Ǽ� x 11000���� �ؼ� ���Ѵ�. 
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = ($sumPrice - $rs[0]*11000)/11000;
	
	//echo $remainCnt."<br>";
	*/
	
	$sql = "select jongmokCnt from Member where idx = $memIdx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = $rs[jongmokCnt];
	
	if($remainCnt<0) {
		$remainCnt = 0;
	}
}



 ?>
 <html>
<head>
<link rel="stylesheet" type="text/css" href="css/top_menu.css">
<script type="text/javascript">
function goRecharge() 
{
	//top.parent.main01.contents.location.href='pay_test.php';
	//var win = window.open('pay.html','pay','width=430px,height=800px,top=0,left=300,location=no,menubar=no,status=no,toolbar=no')
	var win = window.open('pay_201401.php','pay','width=470px,height=700px,top=0,left=300,location=no,menubar=no,status=no,toolbar=no')
}

function getCnt(num){
	top.topFrame.document.getElementById("txtRemainCnt").value = num;
	//top.topFrame.document.getElementById("txtRemainCnt").value = 50;
}

</script>
</head>
<body style="margin:0 0 0 0">
 <table width="100%" height="120px" class="tableMypage">
 <tr><th height="5px"></th></tr>
 <tr align="center" class="thRemain" valign="top" style="margin:0 10 0 0 ">
 <th align="center" style="font-size:15px"><b>���� ���� �� <font color="#FF4500"><?=number_format($remainCnt)?>��</b></font></th>
 </tr>
 <!--
 <tr>
 <th align="center" class="thRemain">
 <table>
 <tr> <th align="right"><li></th><th align="right">1��</th></th><th align="right">11,000��</th> </tr> 
 <tr> <th><li></th><th>10��</th></th><th>30,000��</th> </tr>

 </tr>
 </table>
 
 </th>
 </tr>
 -->
 <tr>
 
 <th align="center"> <input type="button" class="btnRecharge" onclick="goRecharge();"> </th>
 
 <!--
 <th align="center"> <input type="button" class="btnRecharge" onclick="alert('���� �̺�Ʈ ���Դϴ�.')"> </th>
  </tr>
  -->
  <tr><th height="5px"></th></tr>
  
</table>
<script type="text/javascript">
	getCnt(<?=$remainCnt?>);
</script>
 </body>
 </html>