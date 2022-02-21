<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//로그인 여부 확인
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> history.back(); </script>";
	exit();
}

$g_userId = $_COOKIE['_CKE_USER_ID'];

$sql = "update 2019FutureFreeMember set regDate = now() where userId='$g_userId'";
mysql_query($sql) or die($sql);
echo "정상 신청되었습니다.";
?>
