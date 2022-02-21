<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "INSERT INTO 502CouponKind(kind,dcValue,dcType,regDate) VALUES('$txtCouponKind',$txtDcValue,$rdDcType,NOW())";
mysql_query($sql);
?>
<script type="text/javascript">
alert('등록되었습니다.');
parent.location.href = 'm8_couponKind_list.html'
</script>