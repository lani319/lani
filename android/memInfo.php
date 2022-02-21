<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$_HOST_NAME='211.172.241.7';
$_USER_NAME='co502';
$_DB='co502';
$_PASSWORD='@%^*&#';

$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$sql = "SELECT userId,userName,userNickname,gradeLevel 
	from Member where idx=$userIdx";

$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);

echo "ÇÊ ¸í : ".$rs[userNickname];

?>
