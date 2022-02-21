<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


//502쿠폰 유료강연회 참석권을 적정주가 3회 이용 쿠폰으로 처리


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
1. 대상자를 가져온다.
2. Member에서 jongmokCnt 업데이트한다.
3. 502Coupon에 발급 된 것 처럼 처리한다.
4. jongmokValueChargeInfo 결제 내역 테이블에 집어 넣는다. 
*/

$jongmokCnt = 3;

$cnt = 0;

//1. 대상자 가져오기
$sql = "SELECT memIdx FROM 502Coupon WHERE kind=14";
//$sql = "SELECT idx FROM Member WHERE userId in('ayh318','ayh319','lani319'); ";

$tmpRs = mysql_query($sql);
while ($rs = mysql_fetch_array($tmpRs)) {
	
	$couponKind = "$jongmokCnt 개";
	$memIdx = $rs[0];
	
	//2. Member에서 업데이트	
	$sql = "update Member set jongmokCnt = jongmokCnt + $jongmokCnt where idx=$memIdx";
	mysql_query($sql);
		
	//3. 502Coupon에 발급 된 것 처럼 처리한다.			
	$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values(17,now(),'2013-12-31 23:59:59',$memIdx,'$couponKind')";			
	mysql_query($sql);
		
		$price = $jongmokCnt*11000;	
		$buy_no=$memIdx."-".date("ymdHis",$now_time);
		$state = 6; //임의적용		
		$bank="502쿠폰(적정주가 이용권)";
		$jongmok=$jongmokCnt; //입력한 갯수
		$settleType=3; //임의적용
	
	//4. jongmokValueChargeInfo 결제 내역 테이블에 집어 넣는다. 
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
	
	$cnt++;	
}
echo $cnt . " 갱신 ";
?>