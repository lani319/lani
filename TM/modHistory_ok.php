<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$txtIdx;
$txtMode;
$txtHistory;


switch ($txtMode)
{
	case "mod":
		$sql = "update TM_info set memo='$txtHistory' where idx=$txtIdx";
		break;
	case "del":
		$sql = "delete from TM_info where idx=$txtIdx";
		break;
}

mysql_query($sql);
?>

<script type="text/javascript">

parent.opener.location.reload();
parent.close();
</script>