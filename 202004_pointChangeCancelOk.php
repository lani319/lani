<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.",1);
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$memIdx = $_COOKIE['_CKE_USER_UID'];

	$sql = "delete from 2020PointChange where uIdx = $memIdx";

	mysql_query($sql) or die($sql);

	

?>
	<script>
		alert("정상적으로 취소되었습니다.\n\n서비스 변경을 원하시면 다시 신청해주세요.");
		history.back();
	</script>