<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$idx = substr($memIdx,0,strlen($memIdx)-1);


$sql = "DELETE FROM 2011dongbuLecture WHERE idx IN (".$idx.")";

mysql_query($sql);

?>

<script type="text/javascript">
alert("�����Ǿ����ϴ�.");
parent.top.location.reload();
</script>