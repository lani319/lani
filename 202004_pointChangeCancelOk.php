<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.",1);
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$memIdx = $_COOKIE['_CKE_USER_UID'];

	$sql = "delete from 2020PointChange where uIdx = $memIdx";

	mysql_query($sql) or die($sql);

	

?>
	<script>
		alert("���������� ��ҵǾ����ϴ�.\n\n���� ������ ���Ͻø� �ٽ� ��û���ּ���.");
		history.back();
	</script>