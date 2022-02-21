

<?php

//
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


	
$sql = "SELECT request_time, msg_body, dest_phone FROM uds_log_201508
WHERE etc2 = 26439 
 order by request_time desc
 limit 0,100";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."   |   ".$rs[1]."   |   ".$rs[2]."<br>"; 
	}
	
	//echo "<br><br><br><br><br><br><br><br><br><br><br><br>";

?>