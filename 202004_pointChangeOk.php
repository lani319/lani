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



$sql = "select count(idx) as cnt, regDate from 2020PointChange where uIdx = $memIdx group by idx";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_row($tmpRs);
if($rs[0] > 0){
	?>
	<script>
	alert("<?=$rs[1]?>�� ��û�ϼ̽��ϴ�.\n\n�� Ȩ������ ���� �� ����˴ϴ�. ");
	history.back();
	</script>
	<?php
	exit;
}
else
{

	$sql = "insert into 2020PointChange(uidx,userId,anal,regDate) values($memIdx,'$userId',$analSelect,now());";


	mysql_query($sql) or die($sql);
?>
	<script>
	alert("���������� ��û�Ǿ����ϴ�.\n\n �� Ȩ������ ���� �� �ٷ� ����˴ϴ�. ");
	history.back();
	</script>
<?php
}

?>



