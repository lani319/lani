<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//�α��� ���� Ȯ��
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> history.back(); </script>";
	exit();
}

$payflag = 0;

if($_COOKIE['_CKE_USER_ID']=='admin1' || 
$_COOKIE['_CKE_USER_ID']=='ayh319' || 
$_COOKIE['_CKE_USER_ID']=='noba81' || 
$_COOKIE['_CKE_USER_ID']=='coylwh'){
	
	$payflag = 1;
	
}

//�Ⱓ ���Ҵ��� üũ
$memIdx = $_COOKIE['_CKE_USER_UID'];

$sql = "select count(idx) from Member_expert where mem_idx = '$memIdx'
and enddate >='1555686000'";

$result=mysql_query($sql) or die(mysql_error());
$count=mysql_fetch_array($result); 
if($count[0]>0){
	$payflag = 1;
}


//echo $payflag;

if ($payflag == 1){
		
?>

<a href="http://naver.me/5MujmeWq" target="_blank">[����ȸ�� �¼� ��û�ϱ�]</a>
<br><br>
<?php
}
?>












