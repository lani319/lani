<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



echo $mode;





if($regDate == "")
{
	$regDate = date("Y-m-d H:i:s");
	$targetDate = date("Y-m-d");
}
else 
{
	
	$targetDate = $regDate;	
}


$userIdx = "";
$subject = $targetDate." ��������";

//������ ��ȣ
$sql = "select idx from Business_log_level where writer = '".$_COOKIE["_CKE_USER_NAME"]."'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
$userIdx = $rs[idx];

$memIdx = $_COOKIE["_CKE_USER_UID"];

if($mode == "reg")
{
//���ϳ�¥ ���� �ִ��� �˻��Ѵ�.	
	$sql = "select regDate from Business_log where writer = $userIdx and left(targetDate,10) = '$targetDate'";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[regDate]!= "")
	{
		$msg = $targetDate."��������� �̹� $rs[regDate]�� ��ϵǾ����ϴ�.";
		echo "<script>alert('$msg');</script>";
		exit;
	}
		
	//���þ��� �߰�	
	//$sql = "insert into Business_list(writer,charge,contents,flag,regDate,targetDate,status) values('$userIdx','$userIdx','$FCKeditor1','P',now(),'$targetDate','R')";	
	$sql = "update Business_list set contents = '$FCKeditor1' where charge=$userIdx and status='R'";
	
	//��������
	$sql1 = "insert into Business_log(writer,subject,contents,viewLevel,regDate,flag,targetDate,memIdx,readMember) values('$userIdx','$subject','$FCKeditor2','A',now(),'0','$targetDate','$memIdx','$log_target')";		
	
	

	mysql_query($sql);
	mysql_query($sql1);	
	
	echo "<script>	alert('��ϵǾ����ϴ�.');parent.location.href = './businesslog.php?idx=$userIdx'; </script>";
}
else 
{
	$sql = "update Business_list set contents = '$FCKeditor1' where charge=$userIdx and status='R'";
	$sql1 = "update Business_log set contents = '$FCKeditor2',regDate=now() where writer = $userIdx and left(targetDate,10) = '$targetDate' and flag=0";	
	
	//echo $sql1;
	//exit;
	
	mysql_query($sql);
	mysql_query($sql1);	

	echo "<script>	alert('�����Ǿ����ϴ�.');parent.location.href = './businesslog.php?idx=$userIdx'; </script>";	
}
?>




