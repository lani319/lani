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

$g_userId = $_COOKIE['_CKE_USER_ID'];

$sql = "update 2019FutureFreeMember set regDate = now() where userId='$g_userId'";
mysql_query($sql) or die($sql);
echo "���� ��û�Ǿ����ϴ�.";
?>
