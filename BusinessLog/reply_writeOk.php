<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$memIdx =  $_COOKIE["_CKE_USER_UID"];

switch ($mode)
{
	case "reg":
		$sql = "insert into Business_log_reply(parentIdx,writer,contents,regDate) values('$parentIdx','$memIdx','$txtReply',now())";		
		mysql_query($sql);
		break;
	
	case "mod":
		
		$sql = "update Business_log_reply set contents = '$txtReply',regDate=now() where idx=$delidx";		
		mysql_query($sql);
		break;
	case "del":
		$sql = "delete from Business_log_reply where idx=$delidx";
		mysql_query($sql);
		break;
}
?>
<script type="text/javascript">
 parent.location.href = "reply.php?parentIdx=<?=$parentIdx?>";
</script>