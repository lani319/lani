<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
1. 회원 등급을 가져온다.
2. 과거 결제를 가져온다. (인터넷방송, SMS, 파생)
3. 없으면 등급에 따른 요금을 보여준다.

4. 있으면
4-1) 현재 유료회원

3/6/12 과거 요금을 가져온다. 

3/6/12 과거 요금이 없으면, 스타 옆 등급에 따른 요금을 보여준다.

3/6/12 과거 요금이 있으면, 해당 요금을 보여준다.


4-2) 현재 무료회원
3/6/12 과거 요금을 가져온다. 

3/6/12 과거 요금이 없으면, 스타 옆 등급에 따른 요금을 보여준다.

3/6/12 과거 요금이 있으면, 해당 요금과 스타 옆 등급에 따른 요금을 비교하여 더 저렴한 것을 보여준다. 

*/




?>

<?php

//회원 등급 조회 / 실제로는 쿠키값으로 파라미터로 넘겨주기
$sql = "select gradeLevel,userNickname,idx,memType from Member where userId = '".$userId."'";

$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
$gradeLevel = $rs[0];


if($gradeLevel=='1'){
	$change_level = setUserGLevel2($rs['idx']);
}else{
	$change_level = '';
}

if($change_level!='')
{ 
	$secondLevel =  $change_level; 
}
else
{
	$secondLevel = 7;
}


//echo $rs[1]."회원님의 등급은 ".$gradeLevel." 입니다.<br><br>";
echo "<b><font size=4>".$rs[1]." 회원님의 가입 가능한 상품은 아래와 같습니다.</b></font><br><br>";


//과거 결제 조회
$sql ="
select count(C.service_price) as price 
FROM 
(Member A INNER JOIN chargeInfo B ON A.idx = B.uidx) 
INNER JOIN service_kind C ON B.service_type = C.service_orderID

WHERE (B.expert_idx = 34904 OR B.expert_idx = 12)
AND B.state IN (1,3,10,12)
AND B.months IN (3,6,12)
AND A.userId = '".$userId."'
group by C.service_price
";


$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
$rowCount = $rs[0];
//echo "결제횟수".$rowCount;



//무료회원 등급에 따른 등급별 요금
switch($gradeLevel)
{
	case 1:
		switch($secondLevel)
		{
			case 2:
			$gradePrice3 =  1386000;
			$gradePrice6 = 2541000;
			break;
					
			case 3:
			$gradePrice3 = 1386000;
			$gradePrice6 = 2541000;
			break;
					
			case 4:
			$gradePrice3 = 1386000;
			$gradePrice6 = 2541000;
			break;
					
			case 5:
			$gradePrice3 = 1617000;
			$gradePrice6 = 3003000;
			break;
					
			case 6:
			$gradePrice3 = 1617000;
			$gradePrice6 = 3003000;
			break;
					
			case 7:
			$gradePrice3 = 1617000;
			$gradePrice6 = 3003000;
			break;
		}
	
	break;
	
	case 2:
	$gradePrice3 =  1386000;
	$gradePrice6 = 2541000;
	break;
			
	case 3:
	$gradePrice3 = 1386000;
	$gradePrice6 = 2541000;
	break;
			
	case 4:
	$gradePrice3 = 1386000;
	$gradePrice6 = 2541000;
	break;
			
	case 5:
	$gradePrice3 = 1617000;
	$gradePrice6 = 3003000;
	break;
			
	case 6:
	$gradePrice3 = 1617000;
	$gradePrice6 = 3003000;
	break;
			
	case 7:
	$gradePrice3 = 1617000;
	$gradePrice6 = 3003000;
	break;
}




	
//결제 내역이 없으면 등급에 따른 상품을 안내
if($rowCount=='')
{	
	//등급에 따라 상품 가입 가능 가격 안내
	
	$result = "3개월 상품은 ".number_format($gradePrice3)."원에 가입 가능합니다.<br><br>";
	
	$result .= "6개월 상품은 ".number_format($gradePrice6)."원에 가입 가능합니다.<br><br>";
	
	$result .= "12개월 상품은 가입이 불가능합니다.<br><br>";

	
	echo "<b><font size=4>".$result."</b></font>";
}
else
{
	//결제 내역이 있으면 1등급과 2~7등급에 대해 요금을 계산하여 보여준다. 
	
	$sql = "SELECT 
			A.userId,  
			A.userName,
			A.userNickname,
			A.gradeLevel,
			B.months,
			C.service_price,
			B.price AS realprice,
			B.reprice*10 AS couponPrice,
			B.state AS payResult,
			B.paydate AS payDate,
			C.service_name

			FROM 
			(Member A INNER JOIN chargeInfo B ON A.idx = B.uidx) 
			INNER JOIN service_kind C ON B.service_type = C.service_orderID

			WHERE (B.expert_idx = 34904 OR B.expert_idx = 12)
			AND B.state IN (1,3,10,12)
			AND B.months IN (3,6,12)			
			AND A.userId = '".$userId."'
			ORDER BY A.idx ASC,B.idx DESC, B.couponOriPrice ASC
			";
			
			
			//컴백홈 요금제 적용한 최저 마지노선
			$cutPrice3 = 1320000;
			$cutPrice6 = 2640000;
			$cutPrice12 = 5280000;
			
			//최저 요금 비교하기 위한 임시 변수
			$minPrice3 = 100000000;
			$minPrice6 = 100000000;
			$minPrice12 = 100000000;
			
			//최종 요금
			$finalPrice3 = 0;
			$finalPrice6 = 0;
			$finalPrice12 = 0;
			
			//과거 결제한 요금, 0이면 해당 월 상품은 가입 내역 없음
			$servicePrice3 = 0;
			$servicePrice6 = 0;
			$servicePrice12 = 0;


			$tmpRs = mysql_query($sql);
			while($rs = mysql_fetch_array($tmpRs)) 
			{
				$gradeLevel = $rs[gradeLevel];	 
				$months = $rs[months];
				$name = $rs[userName];
				
				/*
				해당하는 월 요금의 최저 요금을 계산한다
				*/
				
				switch($months){
					case 3:
					if($rs[service_price]<$minPrice3){
						$minPrice3 = $rs[service_price];
					}
					
					$servicePrice3 = $rs[service_price];	
					break;
					
					case 6:
					if($rs[service_price]<$minPrice6){
						$minPrice6 = $rs[service_price];
					}
					$servicePrice6 = $rs[service_price];	
					break;
					
					case 12:
					if($rs[service_price]<$minPrice12){
						$minPrice12 = $rs[service_price];
					}
					$servicePrice12 = $rs[service_price];	
					break;
				}
				
			}
			
			//검증을 위한 값을 찍어준다.
			//echo "검) 과거 결제한 3개월 최저 요금은".$minPrice3." 입니다.<br><br>";
			//echo "검) 과거 결제한 6개월 최저 요금은".$minPrice6." 입니다.<br><br>";
			//echo "검) 과거 결제한 12개월 최저 요금은".$minPrice12." 입니다.<br><br>";
			
	
			switch($gradeLevel)
			{
				case 1: //1등급 이면
				
				
				//만기가 2016년 인지 확인, 만기가 2016년인 사람만 요금제 확인 가능합니다
				$sql = "
				SELECT 
				COUNT(B.months) AS cnt
				

				FROM 
				(Member A INNER JOIN chargeInfo B ON A.idx = B.uidx) 
				INNER JOIN service_kind C ON B.service_type = C.service_orderID
				WHERE (B.expert_idx = 34904 OR B.expert_idx = 12)
				AND B.state IN (1,3,10,12)
				AND B.months IN (1,3,6,12)			
				AND A.userId = '".$userId."'		
				AND FROM_UNIXTIME(B.enddate) > '2017-01-01 00:00:01'
		
				GROUP BY B.months
				LIMIT 0,1
				";
				
				
				$tmpRs = mysql_query($sql);
					$rs = mysql_fetch_array($tmpRs);
					if($rs[cnt])
					{
						echo "<b><font size=4>회원님은 2017년 이후 만기 상품에 가입되어 있습니다. 결제 대상이 아닙니다.</b></font>";
					}
					else
					{
						//현재 가입하여 이용중인 상품이 몇 개월인지 알아야 함.
						//1. 현재 날짜 추출
						//2. 결제한 상품중에 서비스 시작일과 종료일 사이가 현재 날짜인 상품 추출
						//3. 해당 상품의 기간과 서비스 금액 추출
						
						//현재 이용중인 상품의 서비스 기간과 금액을 가져온다.
						$curMonths = 0;		//현재 이용중인 상품의 월
						$curPrice = 0;		//현재 이용중인 상품의 가격
						$curServiceName = 0;		//현재 이용중인 상품의 이름
						$enddate = "";
						
						$sql = "SELECT 
							B.months,
							C.service_price,
							FROM_UNIXTIME(B.enddate) as enddate,
							C.service_name

							FROM 
							(Member A INNER JOIN chargeInfo B ON A.idx = B.uidx) 
							INNER JOIN service_kind C ON B.service_type = C.service_orderID
							WHERE (B.expert_idx = 34904 OR B.expert_idx = 12)
							AND B.state IN (1,3,10,12)
							AND B.months IN (1,3,6,12)			
							AND A.userId = '".$userId."'
							AND FROM_UNIXTIME(B.startdate) < NOW() AND FROM_UNIXTIME(B.enddate) > NOW()";
					
							$tmpRs = mysql_query($sql);
							while($rs = mysql_fetch_array($tmpRs)) 
							{
								
								$curMonths = $rs[months];
								$curPrice = $rs[service_price];
								$curServiceName = $rs[service_name];												
								$enddate =  $rs[enddate];
							}
					
						//echo "회원님은 현재 ".$curMonths."개월 ".$curPrice."(".$enddate.")만기인  ".str_replace("<br>","&nbsp;&nbsp;&nbsp;",$curServiceName)."상품 이용중입니다.";
						
						//3개월
						if($servicePrice3 == 0)	//3개월 상품 결제 내역이 없으면
						{
							$finalPrice3 = $gradePrice3;
							
							$result3 = "3개월 상품은 ".number_format($finalPrice3)."원에 가입 가능합니다.<br><br>";
						}
						else		//3개월 상품 결제 내역이 있으면
						{
							if($curMonths==3){		//연장 결제시 해당 상품 요금을 그대로 쓸 수 있다.
								$finalPrice3 = $curPrice; 	//기존에 이용중인 요금
								$result3 = "3개월 상품은 ".number_format($finalPrice3)."원에 연장 가능합니다.<br><br>";
							}
							else
							{ //과거 3개월 결제 내역은 있지만, 연장은 아닐때. 등급에 따른 요금제 표출
														
								//3개월 상품 결제 내역이 있으면, 등급 요금제와 비교하여 저렴한 요금을 출력한다.
									$finalPrice3 = $gradePrice3; //등급 요금을 최종 요금으로 한다.
									
									//마지막은 커트라인 요금과 체크
									if($finalPrice3 < $cutPrice3){	//만약, 최종 3개월 요금이 커트라인 요금보다 싸면
										$finalPrice3 = $cutPrice3;
									}
							}
								
								
							$result3 = "3개월 상품은 ".number_format($finalPrice3)."원에 가입 가능합니다.<br><br>";
							
						}
					
					
						//6개월
						if($servicePrice6 == 0)	//6개월 상품 결제 내역이 없으면
						{
							$finalPrice6 = $gradePrice6;
							
							$result6 = "6개월 상품은 ".number_format($finalPrice6)."원에 가입 가능합니다.<br><br>";
						}
						else		//6개월 상품 결제 내역이 있으면
						{
							if($curMonths==6)
							{		//연장 결제시 해당 상품 요금을 그대로 쓸 수 있다.
								$finalPrice6 = $curPrice; 	//기존에 이용중인 요금
								$result6 = "6개월 상품은 ".number_format($finalPrice6)."원에 연장 가능합니다.<br><br>";
							}
							else
							{
								//연장 결제는 아니고, 과거에 6개월 결제 내역이 있을 때							
								
								//3개월 상품 결제 내역이 있으면, 등급 요금제와 비교하여 저렴한 요금을 출력한다.
								
									$finalPrice6 = $gradePrice6; //등급 요금을 최종 요금으로 한다.
								
																	
									//마지막은 커트라인 요금과 체크
									if($finalPrice6 < $cutPrice6){	//만약, 최종 6개월 요금이 커트라인 요금보다 싸면
										$finalPrice6 = $cutPrice6;
									}
															
								$result6 = "6개월 상품은 ".number_format($finalPrice6)."원에 가입 가능합니다.<br><br>";
							}
						}					
				
						//12개월
						if($servicePrice12 == 0)	//12개월 상품 결제 내역이 없으면
						{
							$result12 = "12개월 상품은 가입 불가능합니다.<br><br>";
						}
						else		//12개월 상품 결제 내역이 있으면
						{
							if($curMonths==12){		//연장 결제시 해당 상품 요금을 그대로 쓸 수 있다.
								$finalPrice12 = $curPrice; 	//기존에 이용중인 요금
								$result12 = "12개월 상품은 ".number_format($finalPrice12)."원에 연장 가능합니다.<br><br>";
							}
							else{
														
								//다른 상품 선택시
								//만약 6개월 쓰는데 3개월 결제하게 되면, 과거 결제한 3개월 금액과 등급 금액을 비교
								
								//3개월 상품 결제 내역이 있으면, 등급 요금제와 비교하여 저렴한 요금을 출력한다.
								
								$finalPrice12 = $minPrice12; //12개월 과거 최저 요금을 우선 설정
									
								//마지막은 커트라인 요금과 체크
								if($finalPrice12 < $cutPrice12){	//만약, 최종 12개월 요금이 커트라인 요금보다 쌀 때만
									$finalPrice12 = $cutPrice12;
								}
								$result12 = "12개월 상품은 ".number_format($finalPrice12)."원에 가입 가능합니다.<br><br>";
							}
						}
					}						
				break;
				
				//2~7등급 회원이 과거 결제 내역이 있으면, 컴백홈 요금과 비교
				default:
				//3개월
					if($servicePrice3 == 0)	//3개월 상품 결제 내역이 없으면
					{
						$finalPrice3 = $gradePrice3;
						
						$result3 = "3개월 상품은 ".number_format($finalPrice3)."원에 가입 가능합니다.<br><br>";
					}
					else		//3개월 상품 결제 내역이 있으면
					{
						 //과거 3개월 결제 내역은 있지만, 연장은 아닐때.
														
							//3개월 상품 결제 내역이 있으면, 등급 요금제와 비교하여 저렴한 요금을 출력한다.
							if($minPrice3 > $gradePrice3) //과거 최저 결제 요금이 등급 요금보다 비쌀 때
							{
								$finalPrice3 = $gradePrice3; //등급 요금을 최종 요금으로 한다.
							}
							else
							{
								$finalPrice3 = $minPrice3; //과거 최저 결제 요금이 등급 요금보다 싸면 등급 요금으로 한다.
								
								//마지막은 커트라인 요금과 체크
								if($finalPrice3 < $cutPrice3){	//만약, 최종 3개월 요금이 커트라인 요금보다 싸면
									$finalPrice3 = $cutPrice3;
								}
							}	
							
							$result3 = "3개월 상품은 ".number_format($finalPrice3)."원에 가입 가능합니다.<br><br>";
					}
					
					
				//6개월
					if($servicePrice6 == 0)	//3개월 상품 결제 내역이 없으면
					{
						$finalPrice6 = $gradePrice6;
						
						$result6 = "6개월 상품은 ".number_format($finalPrice6)."원에 가입 가능합니다.<br><br>";
					}
					else		//3개월 상품 결제 내역이 있으면
					{
						 //과거 3개월 결제 내역은 있지만, 연장은 아닐때.
														
							//3개월 상품 결제 내역이 있으면, 등급 요금제와 비교하여 저렴한 요금을 출력한다.
							if($minPrice6 > $gradePrice6) //과거 최저 결제 요금이 등급 요금보다 비쌀 때
							{
								$finalPrice6 = $gradePrice6; //등급 요금을 최종 요금으로 한다.
							}
							else
							{
								$finalPrice6 = $minPrice6; //과거 최저 결제 요금이 등급 요금보다 싸면 등급 요금으로 한다.
								
								//마지막은 커트라인 요금과 체크
								if($finalPrice6 < $cutPrice6){	//만약, 최종 3개월 요금이 커트라인 요금보다 싸면
									$finalPrice6 = $cutPrice6;
								}
							}	
							
							$result6 = "6개월 상품은 ".number_format($finalPrice6)."원에 가입 가능합니다.<br><br>";
					}

				//12개월
					if($servicePrice12 == 0)	//12개월 상품 결제 내역이 없으면
					{
						$result12 = "12개월 상품은 가입 불가능합니다.<br><br>";
					}
					else		//12개월 상품 결제 내역이 있으면
					{
							$finalPrice12 = $minPrice12; //12개월 과거 최저 요금을 우선 설정
								
							//마지막은 커트라인 요금과 체크
							if($finalPrice12 < $cutPrice12){	//만약, 최종 12개월 요금이 커트라인 요금보다 쌀 때만
								$finalPrice12 = $cutPrice12;
							}
							$result12 = "12개월 상품은 ".number_format($finalPrice12)."원에 가입 가능합니다.<br><br>";						
					}					
				break;
			}

			//결과 출력한다
			echo "<b><font size=4>".$result3."</font></b>";
			echo "<b><font size=4>".$result6."</font></b>";
			echo "<b><font size=4>".$result12."</font></b>";
			
	
	}

?>

<b><font size=4>SMS 상품은 고객센터로 문의 바랍니다.<br><br>


</table>