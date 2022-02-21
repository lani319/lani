<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//id,pwd를 파라미터로 받는다
//$article,$memIdx

$sql = "insert into 502SNS (article,memIdx,regDate,displayFlag) values('$article','$memIdx',now(),'1')";
//echo $sql;

mysql_query($sql) or die(mysql_error());
echo "TRUE";

exit;
?>