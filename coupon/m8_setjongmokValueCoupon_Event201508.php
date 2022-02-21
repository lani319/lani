<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/*
2015년 8월, 적정주가 이벤트
모든 회원에게 +3개 쿠폰 발행

1. 최근 1년 접속자를 등급에 상관없이 전부 가져온다.
2. 루프 돌면서 3개씩 쿠폰을 지급한다. 
3. 끝.

//적정주가 3개 쿠폰 idx는 17
*/


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$expiredDate = $selExpiredDate*86400;

$expiredDate = mktime(23,59,59,$month,$day,$year);

//여기서 회원정보를 불러와서 루프 돈다

		$couponKind = "$jongmokCnt 개";
		
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values(17,now(),FROM_UNIXTIME($expiredDate),$txtMemIdx,'$couponKind')";
			
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



?>
<script type="text/javascript">
alert('쿠폰이 발급되었습니다');
parent.location.reload();
</script>