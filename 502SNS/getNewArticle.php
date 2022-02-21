<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//id,pwd를 파라미터로 받는다

$sql = "select idx from 502SNS order by idx desc limit 0,1";


$tmpRs = mysql_query($sql) or die(mysql_error());

$result = mysql_fetch_array($tmpRs);

echo $result["idx"];
exit;
?>