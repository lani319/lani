<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
1. ȸ�� ����� �����´�.
2. ���� ������ �����´�. (���ͳݹ��, SMS, �Ļ�)
3. ������ ��޿� ���� ����� �����ش�.

4. ������
4-1) ���� ����ȸ��

3/6/12 ���� ����� �����´�. 

3/6/12 ���� ����� ������, ��Ÿ �� ��޿� ���� ����� �����ش�.

3/6/12 ���� ����� ������, �ش� ����� �����ش�.


4-2) ���� ����ȸ��
3/6/12 ���� ����� �����´�. 

3/6/12 ���� ����� ������, ��Ÿ �� ��޿� ���� ����� �����ش�.

3/6/12 ���� ����� ������, �ش� ��ݰ� ��Ÿ �� ��޿� ���� ����� ���Ͽ� �� ������ ���� �����ش�. 

*/




?>

<?php

//ȸ�� ��� ��ȸ / �����δ� ��Ű������ �Ķ���ͷ� �Ѱ��ֱ�
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


//echo $rs[1]."ȸ������ ����� ".$gradeLevel." �Դϴ�.<br><br>";
echo "<b><font size=4>".$rs[1]." ȸ������ ���� ������ ��ǰ�� �Ʒ��� �����ϴ�.</b></font><br><br>";


//���� ���� ��ȸ
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
//echo "����Ƚ��".$rowCount;



//����ȸ�� ��޿� ���� ��޺� ���
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




	
//���� ������ ������ ��޿� ���� ��ǰ�� �ȳ�
if($rowCount=='')
{	
	//��޿� ���� ��ǰ ���� ���� ���� �ȳ�
	
	$result = "3���� ��ǰ�� ".number_format($gradePrice3)."���� ���� �����մϴ�.<br><br>";
	
	$result .= "6���� ��ǰ�� ".number_format($gradePrice6)."���� ���� �����մϴ�.<br><br>";
	
	$result .= "12���� ��ǰ�� ������ �Ұ����մϴ�.<br><br>";

	
	echo "<b><font size=4>".$result."</b></font>";
}
else
{
	//���� ������ ������ 1��ް� 2~7��޿� ���� ����� ����Ͽ� �����ش�. 
	
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
			
			
			//�Ĺ�Ȩ ����� ������ ���� �����뼱
			$cutPrice3 = 1320000;
			$cutPrice6 = 2640000;
			$cutPrice12 = 5280000;
			
			//���� ��� ���ϱ� ���� �ӽ� ����
			$minPrice3 = 100000000;
			$minPrice6 = 100000000;
			$minPrice12 = 100000000;
			
			//���� ���
			$finalPrice3 = 0;
			$finalPrice6 = 0;
			$finalPrice12 = 0;
			
			//���� ������ ���, 0�̸� �ش� �� ��ǰ�� ���� ���� ����
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
				�ش��ϴ� �� ����� ���� ����� ����Ѵ�
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
			
			//������ ���� ���� ����ش�.
			//echo "��) ���� ������ 3���� ���� �����".$minPrice3." �Դϴ�.<br><br>";
			//echo "��) ���� ������ 6���� ���� �����".$minPrice6." �Դϴ�.<br><br>";
			//echo "��) ���� ������ 12���� ���� �����".$minPrice12." �Դϴ�.<br><br>";
			
	
			switch($gradeLevel)
			{
				case 1: //1��� �̸�
				
				
				//���Ⱑ 2016�� ���� Ȯ��, ���Ⱑ 2016���� ����� ����� Ȯ�� �����մϴ�
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
						echo "<b><font size=4>ȸ������ 2017�� ���� ���� ��ǰ�� ���ԵǾ� �ֽ��ϴ�. ���� ����� �ƴմϴ�.</b></font>";
					}
					else
					{
						//���� �����Ͽ� �̿����� ��ǰ�� �� �������� �˾ƾ� ��.
						//1. ���� ��¥ ����
						//2. ������ ��ǰ�߿� ���� �����ϰ� ������ ���̰� ���� ��¥�� ��ǰ ����
						//3. �ش� ��ǰ�� �Ⱓ�� ���� �ݾ� ����
						
						//���� �̿����� ��ǰ�� ���� �Ⱓ�� �ݾ��� �����´�.
						$curMonths = 0;		//���� �̿����� ��ǰ�� ��
						$curPrice = 0;		//���� �̿����� ��ǰ�� ����
						$curServiceName = 0;		//���� �̿����� ��ǰ�� �̸�
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
					
						//echo "ȸ������ ���� ".$curMonths."���� ".$curPrice."(".$enddate.")������  ".str_replace("<br>","&nbsp;&nbsp;&nbsp;",$curServiceName)."��ǰ �̿����Դϴ�.";
						
						//3����
						if($servicePrice3 == 0)	//3���� ��ǰ ���� ������ ������
						{
							$finalPrice3 = $gradePrice3;
							
							$result3 = "3���� ��ǰ�� ".number_format($finalPrice3)."���� ���� �����մϴ�.<br><br>";
						}
						else		//3���� ��ǰ ���� ������ ������
						{
							if($curMonths==3){		//���� ������ �ش� ��ǰ ����� �״�� �� �� �ִ�.
								$finalPrice3 = $curPrice; 	//������ �̿����� ���
								$result3 = "3���� ��ǰ�� ".number_format($finalPrice3)."���� ���� �����մϴ�.<br><br>";
							}
							else
							{ //���� 3���� ���� ������ ������, ������ �ƴҶ�. ��޿� ���� ����� ǥ��
														
								//3���� ��ǰ ���� ������ ������, ��� ������� ���Ͽ� ������ ����� ����Ѵ�.
									$finalPrice3 = $gradePrice3; //��� ����� ���� ������� �Ѵ�.
									
									//�������� ĿƮ���� ��ݰ� üũ
									if($finalPrice3 < $cutPrice3){	//����, ���� 3���� ����� ĿƮ���� ��ݺ��� �θ�
										$finalPrice3 = $cutPrice3;
									}
							}
								
								
							$result3 = "3���� ��ǰ�� ".number_format($finalPrice3)."���� ���� �����մϴ�.<br><br>";
							
						}
					
					
						//6����
						if($servicePrice6 == 0)	//6���� ��ǰ ���� ������ ������
						{
							$finalPrice6 = $gradePrice6;
							
							$result6 = "6���� ��ǰ�� ".number_format($finalPrice6)."���� ���� �����մϴ�.<br><br>";
						}
						else		//6���� ��ǰ ���� ������ ������
						{
							if($curMonths==6)
							{		//���� ������ �ش� ��ǰ ����� �״�� �� �� �ִ�.
								$finalPrice6 = $curPrice; 	//������ �̿����� ���
								$result6 = "6���� ��ǰ�� ".number_format($finalPrice6)."���� ���� �����մϴ�.<br><br>";
							}
							else
							{
								//���� ������ �ƴϰ�, ���ſ� 6���� ���� ������ ���� ��							
								
								//3���� ��ǰ ���� ������ ������, ��� ������� ���Ͽ� ������ ����� ����Ѵ�.
								
									$finalPrice6 = $gradePrice6; //��� ����� ���� ������� �Ѵ�.
								
																	
									//�������� ĿƮ���� ��ݰ� üũ
									if($finalPrice6 < $cutPrice6){	//����, ���� 6���� ����� ĿƮ���� ��ݺ��� �θ�
										$finalPrice6 = $cutPrice6;
									}
															
								$result6 = "6���� ��ǰ�� ".number_format($finalPrice6)."���� ���� �����մϴ�.<br><br>";
							}
						}					
				
						//12����
						if($servicePrice12 == 0)	//12���� ��ǰ ���� ������ ������
						{
							$result12 = "12���� ��ǰ�� ���� �Ұ����մϴ�.<br><br>";
						}
						else		//12���� ��ǰ ���� ������ ������
						{
							if($curMonths==12){		//���� ������ �ش� ��ǰ ����� �״�� �� �� �ִ�.
								$finalPrice12 = $curPrice; 	//������ �̿����� ���
								$result12 = "12���� ��ǰ�� ".number_format($finalPrice12)."���� ���� �����մϴ�.<br><br>";
							}
							else{
														
								//�ٸ� ��ǰ ���ý�
								//���� 6���� ���µ� 3���� �����ϰ� �Ǹ�, ���� ������ 3���� �ݾװ� ��� �ݾ��� ��
								
								//3���� ��ǰ ���� ������ ������, ��� ������� ���Ͽ� ������ ����� ����Ѵ�.
								
								$finalPrice12 = $minPrice12; //12���� ���� ���� ����� �켱 ����
									
								//�������� ĿƮ���� ��ݰ� üũ
								if($finalPrice12 < $cutPrice12){	//����, ���� 12���� ����� ĿƮ���� ��ݺ��� �� ����
									$finalPrice12 = $cutPrice12;
								}
								$result12 = "12���� ��ǰ�� ".number_format($finalPrice12)."���� ���� �����մϴ�.<br><br>";
							}
						}
					}						
				break;
				
				//2~7��� ȸ���� ���� ���� ������ ������, �Ĺ�Ȩ ��ݰ� ��
				default:
				//3����
					if($servicePrice3 == 0)	//3���� ��ǰ ���� ������ ������
					{
						$finalPrice3 = $gradePrice3;
						
						$result3 = "3���� ��ǰ�� ".number_format($finalPrice3)."���� ���� �����մϴ�.<br><br>";
					}
					else		//3���� ��ǰ ���� ������ ������
					{
						 //���� 3���� ���� ������ ������, ������ �ƴҶ�.
														
							//3���� ��ǰ ���� ������ ������, ��� ������� ���Ͽ� ������ ����� ����Ѵ�.
							if($minPrice3 > $gradePrice3) //���� ���� ���� ����� ��� ��ݺ��� ��� ��
							{
								$finalPrice3 = $gradePrice3; //��� ����� ���� ������� �Ѵ�.
							}
							else
							{
								$finalPrice3 = $minPrice3; //���� ���� ���� ����� ��� ��ݺ��� �θ� ��� ������� �Ѵ�.
								
								//�������� ĿƮ���� ��ݰ� üũ
								if($finalPrice3 < $cutPrice3){	//����, ���� 3���� ����� ĿƮ���� ��ݺ��� �θ�
									$finalPrice3 = $cutPrice3;
								}
							}	
							
							$result3 = "3���� ��ǰ�� ".number_format($finalPrice3)."���� ���� �����մϴ�.<br><br>";
					}
					
					
				//6����
					if($servicePrice6 == 0)	//3���� ��ǰ ���� ������ ������
					{
						$finalPrice6 = $gradePrice6;
						
						$result6 = "6���� ��ǰ�� ".number_format($finalPrice6)."���� ���� �����մϴ�.<br><br>";
					}
					else		//3���� ��ǰ ���� ������ ������
					{
						 //���� 3���� ���� ������ ������, ������ �ƴҶ�.
														
							//3���� ��ǰ ���� ������ ������, ��� ������� ���Ͽ� ������ ����� ����Ѵ�.
							if($minPrice6 > $gradePrice6) //���� ���� ���� ����� ��� ��ݺ��� ��� ��
							{
								$finalPrice6 = $gradePrice6; //��� ����� ���� ������� �Ѵ�.
							}
							else
							{
								$finalPrice6 = $minPrice6; //���� ���� ���� ����� ��� ��ݺ��� �θ� ��� ������� �Ѵ�.
								
								//�������� ĿƮ���� ��ݰ� üũ
								if($finalPrice6 < $cutPrice6){	//����, ���� 3���� ����� ĿƮ���� ��ݺ��� �θ�
									$finalPrice6 = $cutPrice6;
								}
							}	
							
							$result6 = "6���� ��ǰ�� ".number_format($finalPrice6)."���� ���� �����մϴ�.<br><br>";
					}

				//12����
					if($servicePrice12 == 0)	//12���� ��ǰ ���� ������ ������
					{
						$result12 = "12���� ��ǰ�� ���� �Ұ����մϴ�.<br><br>";
					}
					else		//12���� ��ǰ ���� ������ ������
					{
							$finalPrice12 = $minPrice12; //12���� ���� ���� ����� �켱 ����
								
							//�������� ĿƮ���� ��ݰ� üũ
							if($finalPrice12 < $cutPrice12){	//����, ���� 12���� ����� ĿƮ���� ��ݺ��� �� ����
								$finalPrice12 = $cutPrice12;
							}
							$result12 = "12���� ��ǰ�� ".number_format($finalPrice12)."���� ���� �����մϴ�.<br><br>";						
					}					
				break;
			}

			//��� ����Ѵ�
			echo "<b><font size=4>".$result3."</font></b>";
			echo "<b><font size=4>".$result6."</font></b>";
			echo "<b><font size=4>".$result12."</font></b>";
			
	
	}

?>

<b><font size=4>SMS ��ǰ�� �����ͷ� ���� �ٶ��ϴ�.<br><br>


</table>