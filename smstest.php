

<?php

//
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

	
		
	//
	$sql = "SELECT msg_body FROM uds_log_201102
WHERE etc2 = '312'
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
		$sql = "SELECT msg_body FROM uds_log_201102
WHERE etc2 in('26439','312','17365')
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
	
	
	$sql = "SELECT msg_body FROM uds_log_201103
WHERE etc2 in('26439','312','17365')
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
	
		$sql = "SELECT msg_body FROM uds_log_201209
WHERE etc2 in('26439','312','17365')
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
	
			$sql = "SELECT msg_body FROM uds_log_201308
WHERE etc2 in('26439','312','17365')
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
	
				$sql = "SELECT msg_body FROM uds_log_201211
WHERE etc2 in('26439','312','17365')
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
	
				$sql = "SELECT msg_body FROM uds_log_201106
WHERE etc2 in('26439','312','17365')
group by msg_body
 LIMIT 0,1000";
	$tmpRs = mysql_query($sql);	
	
	while($rs = mysql_fetch_array($tmpRs)){
		echo $rs[0]."<br>";
	}
	
	echo "<br><br><br><br><br><br><br><br><br><br><br><br>";

?>