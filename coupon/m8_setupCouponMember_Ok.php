
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
ȸ���������� �ٷ� ���� �����ϱ�
*/

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$arrIdx = explode(",",$txtCouponIdx);
$expiredDate = $selExpiredDate*86400;

for($i = 0 ; $i <sizeof($arrIdx); $i++)
{
	$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx) values($arrIdx[$i],now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$txtMemIdx)";
	echo $sql;
	echo "<br>";
	mysql_query($sql);
}

?>
<script type="text/javascript">
alert('������ �߱޵Ǿ����ϴ�');
parent.top.location.reload();
</script>