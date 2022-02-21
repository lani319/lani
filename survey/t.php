<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//6412251929421

$userNum=numEnc(6412251929421);

echo $userNum;

?>

