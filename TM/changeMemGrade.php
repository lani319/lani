<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "update TM_customer set userGrade = $memGrade where userIdx=$memIdx";

mysql_query($sql);


?>

<script>
alert('<?=$memGrade?>������� ���� �Ǿ����ϴ�.');
parent.opener.location.reload();
parent.self.close();
</script>