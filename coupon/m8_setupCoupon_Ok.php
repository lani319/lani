<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$arrIdx = explode(",",$txtCouponIdx);
$expiredDate = $selExpiredDate*86400;

$expiredDate = mktime(23,59,59,$month,$day,$year);


for($i = 0 ; $i <sizeof($arrIdx); $i++)
{	
	if($arrIdx[$i] == 17) //적정주가 3회 이용권이면, 결제 내역에 추가한다.
	{
		$couponKind = "$jongmokCnt 개";
		
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values($arrIdx[$i],now(),FROM_UNIXTIME($expiredDate),$txtMemIdx,'$couponKind')";
			
		mysql_query($sql);
		
		$price = $jongmokCnt*11000;
	
		$memIdx = $txtMemIdx;	
		$buy_no=$memIdx."-".date("ymdHis",$now_time);
		$state = 6; //임의적용		
		$bank="502쿠폰(적정주가 이용권)";
		$jongmok=$jongmokCnt; //입력한 갯수
		$settleType=3; //임의적용
	
	$sql = "insert into jongmokValueChargeInfo(memIdx,price,buy_no,state,signdate,paydate,bank,jongmok,settletype) values(
		$memIdx,
		$price,
		'$buy_no',
		$state,
		now(),
		now(),
		'$bank',
		$jongmok,
		$settleType	
		)";
	mysql_query($sql);
	
		$sql = "update Member set jongmokCnt = jongmokCnt + $jongmokCnt where idx=$memIdx";
		mysql_query($sql);
	}
	else 
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx) values($arrIdx[$i],now(),FROM_UNIXTIME($expiredDate),$txtMemIdx)";
	//echo $sql;
	//echo "<br>";
		mysql_query($sql);
	}
}

?>
<script type="text/javascript">
alert('쿠폰이 발급되었습니다');
parent.location.reload();
</script>