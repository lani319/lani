<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//인터넷 방송만 전용으로 

//인터넷 방송 + 문자전용 + 파생상품 

$sql1 = "
		select A.userName,A.userNickname,A.userId,A.gradeLevel, t.uidx, sum(t.price) as price
		from 
		(
		select uidx, sum(price) as price from chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx

		union all

		select uidx, sum(price) as price from investment_chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx

		union all

		select uidx, sum(price) as price from investment_union_chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx
		
		union all
		
		select uidx, sum(price) as price from stock_sms_chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx
		
		) t

		inner Join Member A on A.idx = t.uidx

		group by t.uidx
		order by A.gradeLevel ASC, price DESC

		";

echo $sql;

$result = mysql_query($sql1) or die(mysql_error());



?>

<table border=1 cellpadding=0 cellspacing=0 width="90%">
<tr>
<td colspan="10">
<br><br>
<font color=red>2018.11.11 평택촌놈 사이트 결제내역 (컨트롤+F 눌러서 검색)</font><br><br>
*인터넷방송 + SMS전용(TMS) + 파생(주식선물SMS포함)<br><br>
<pre>
1. 평택촌놈 현재 유료회원 (2018년 6월 6일 00시 기준)

1순위회원 누적 5,000만 원 초과 결제자 : 10만 원
2순위회원 누적 3,000만 원 초과 ~ 5,000만 원 이하 결제자 : 50만 원
3순위회원 누적 2,000만 원 초과 ~ 3,000만 원 이하 결제자 : 100만 원
4순위회원 누적 1,000만 원 초과 ~ 2,000만 원 이하 결제자 : 150만 원
5순위회원 누적 750만 원 초과 ~ 1,000만 원 이하 결제자 : 200만 원
6순위회원 누적 750만 원 미만 결제자 : 250만 원
7순위회원 누적 500만 원 미만 결제자 : 300만 원

2. 평택촌놈 과거 유료회원 (2018년 6월 6일 00시 기준)

1순위회원 누적 5,000만 원 초과 결제자 : 20만 원
2순위회원 누적 3,000만 원 초과 ~ 5,000만 원 이하 결제자 : 100만 원
3순위회원 누적 2,000만 원 초과 ~ 3,000만 원 이하 결제자 : 200만 원
4순위회원 누적 2,000만 원 이하 결제자 : 300만 원

특기사황
현재 평택촌놈 또는 센플러스 유료회원 아닌 경우 과거 유료회원 적용

3. 센플러스 현재 유료회원 (2018년 6월 6일 00시 기준)
1순위회원 누적 1,000만 원 초과 결제자 : 50만 원
2순위회원 누적 750만 원 초과~1,000만 원 이하 결제자 : 100만 원
3순위회원 누적 500만 원 초과~750만 원 이하 결제자 : 150만 원
4순위회원 누적 250만 원 초과~500만 원 이하 결제자 : 200만 원
5순위회원 누적 125만 원 초과~250만 원 이하 결제자 : 250만 원
6순위회원 누적 125만 원 이하 결제자 : 300만 원

특기사항
현재 센플러스 유료회원은 과거 평택촌놈 유료회원 결제내역 불인정
현재 센플러스 유료회원 중 평택촌놈 주식선물 결제내역 인정

4. 나머지 모든 무료회원은 400만 원
</pre>
</td>
</tr>
<tr align='center'>
<td>이름</td>
<td>필명</td>
<td>아이디</td>
<td>등급<br>(1등급=유료)</td>
<td>누적 결제금액</td>
<td>교육 결제금액</td>
</tr>

<?php
while($charge_info=mysql_fetch_array($result)){
	$sumTotalPrice = 0;	
	$finalPrice = 0;	
		
	
	$sumTotalPrice = $charge_info[price];
			
		if($charge_info[gradeLevel] == 1){ //현재 유료회원
			if($sumTotalPrice > 50000000){
				$finalPrice = 110000;
			}else if($sumTotalPrice > 30000000 && $sumTotalPrice <= 50000000){
				$finalPrice = 550000;
				
			}else if($sumTotalPrice > 20000000 && $sumTotalPrice <= 30000000){
				$finalPrice = 1100000;
				
			}else if($sumTotalPrice > 10000000 && $sumTotalPrice <= 20000000){
				$finalPrice = 1650000;
				
			}
			else if($sumTotalPrice > 7500000 && $sumTotalPrice <= 10000000){
				$finalPrice = 2200000;
				
			}else if($sumTotalPrice >= 5000000 && $sumTotalPrice <= 7500000){
				$finalPrice = 2750000;
				
			}
			else if($sumTotalPrice < 5000000){
				$finalPrice = 3300000;
			}
			
	
		}else{ //현재 무료회원
			if($sumTotalPrice > 50000000){ 
				$finalPrice = 220000;
			}else if($sumTotalPrice > 30000000 && $sumTotalPrice <= 50000000){
				$finalPrice = 1100000;
				
			}else if($sumTotalPrice > 20000000 && $sumTotalPrice <= 30000000){
				$finalPrice = 2200000;
			}else if($sumTotalPrice <= 20000000){
				$finalPrice = 3300000;
			}
		}
	
?>
<tr align='center'>
<td><?=$charge_info[userName]?>(<?=$charge_info[uidx]?>)</td>
<td><?=$charge_info[userNickname]?></td>
<td><?=$charge_info[userId]?></td>
<td><?=$charge_info[gradeLevel]?></td>
<td><?=number_format($sumTotalPrice)?></td>

<td><font color='red'><?=number_format($finalPrice)?></td>
</tr>
<?php
	//여기에 내역 출력
}	



?>