<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header1.php";


include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "SELECT userName,mobile FROM Member WHERE LEVEL > 1 AND member_state='O' ";

$tmpRs = mysql_query($sql);

while($rs = mysql_fetch_array($tmpRs))
{
	echo $rs["userName"]."|".$rs["mobile"]."<br>";
}