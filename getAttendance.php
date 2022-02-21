<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$cnt = 0;

$sql = "select login_uidx from login_counter where login_date between '2011-02-02' and '2011-02-14'";

$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs))
{
	$arStr = explode("|",$rs[login_uidx]);
	$cnt += sizeof($arStr);
}
echo $cnt;
echo "<br>";
echo $cnt/14;

?>