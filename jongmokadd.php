<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
$sql = "select * from jongmok_Code order by idx desc";
$tmpRs = mysql_query($sql);

while($rs = mysql_fetch_array($tmpRs))
{
	echo $rs["jongmok_code"]." | ".$rs["jongmok_name"]."|"."<br>";
}
*/
//0928 추가

$sql="insert into cosdaq_Code(jongmok_code,jongmok_name) values('054800','아이디스')"; mysql_query($sql);
$sql="insert into cosdaq_Code(jongmok_code,jongmok_name) values('131390','피앤이솔루션')"; mysql_query($sql);







echo "등록 완료!";

?>