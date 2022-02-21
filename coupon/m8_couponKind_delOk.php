<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

echo $txtIdx;

$sql = "delete from 502CouponKind where idx=$txtIdx";
mysql_query($sql);

?>

<script type="text/javascript">
alert('삭제되었습니다.');
parent.location.reload();
</script>