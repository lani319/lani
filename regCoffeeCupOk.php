<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$uidx = $_COOKIE[_CKE_USER_UID];


//이벤트 기간내 결제여부 확인

$sql = "SELECT COUNT(idx) AS cnt FROM chargeInfo 
WHERE state IN (1,3,12) AND expert_idx = 34904 and months in (3,6,12)
AND paydate > '2020-01-13 00:00:01' AND paydate < '2020-01-31 23:59:59'
AND uidx = $uidx
UNION all

SELECT COUNT(idx) AS cnt FROM investment_union_chargeInfo 
WHERE state IN (1,3,12) AND (expert_tiker = 34904 OR expert_investment = 34904)
and months in (3,6,12)
AND paydate > '2020-01-13 00:00:01' AND paydate < '2020-01-31 23:59:59'
AND uidx = $uidx";

$tmpRs = mysql_query($sql);
$sumCnt = 0;
while($rs = mysql_fetch_array($tmpRs)){
	$sumCnt = $sumCnt + $rs[cnt];
}

$sumCnt2 = 0;
$sql = "SELECT sum(months) AS cnt FROM stock_sms_chargeInfo
WHERE state IN (1,3,12)
AND paydate > '2020-01-13 00:00:01' AND paydate < '2020-01-31 23:59:59'
AND uidx = $uidx";

while($rs = mysql_fetch_array($tmpRs)){
	$sumCnt2 = $sumCnt2 + $rs[cnt];
}

if($sumCnt < 1){
	if($sumCnt2 < 3){
	popupMsg("이벤트 신청 대상이 아닙니다.",1);	
	exit;
	}
}


$userName = "'".$txtName."'";
$address = "'".$txtAddress."'";
$mobile = "'".$txtMobile."'";
$cnt1 = $txtCupSelect1;
$cnt2 = $txtCupSelect2;
$price = 0;
$memo = "'"."20년 1월 이벤트"."'";

$sql = "insert into 2020coffeeCup(uidx,userName,address,mobile,cnt1,cnt2,price,memo,regDate,state) values(
$uidx,
$userName,
$address,
$mobile,
$cnt1,
$cnt2,
$price,
$memo,
now(),
6
)";

//echo $sql;

mysql_query($sql) or die("ERROR ".$sql);

?>
<script type="text/javascript">
alert('신청이 완료되었습니다.');
history.back();
</script>




