<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

if($orderid!='' && $orderidYN=='Y'){
	$orderidR = explode('_',$orderid);
	$primiumGubun = $orderidR[0];
	$orderid = $orderidR[1];
}

$sql = "update 502CouponKind set kind = '".addslashes($txtCouponKind)."',dcValue = ".$txtDcValue.",dcType = ".$rdDcType.",regDate= now(), priceLinkage = '".$priceLinkage."', orderid = '".$orderid."'
										,expert_idx='".$expert_idx."', coupon_month = '".$coupon_month."', primiumGubun = '".$primiumGubun."', orderidYN = '".$orderidYN."' where idx=$txtIdx";
mysql_query($sql);
?>
<script type="text/javascript">
alert('수정 되었습니다.');
parent.location.href = 'm8_couponKind_list.html'
</script>