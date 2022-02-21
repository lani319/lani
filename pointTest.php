<?
include_once "/home/co502/public_html/_config/db.connect.php";
include_once "/home/co502/public_html/_config/sys.config.php";
include_once "/home/co502/public_html/_libs/base_lib.php";
include_once "/home/co502/public_html/_libs/common_lib.php";

function member_perm_imglib_member_list3($memtype,$gradelevel,$mem_idx,$point){
	if($memtype=="1"){//프리미엄회원 or 특별등급
		$p_img="Y";
	}else if($memtype=="2"){//전문가 프리미엄
		$p_img="Y";
	}else{
		if(service_settle_check("12", $mem_idx, "invest_tiker") || service_settle_check_no_expert($mem_idx, "investment")){
			$p_img="Y";
		}else if(tiker_settle_check_no_expert($mem_idx)){
			$p_img="Y";
		}else{
			$p_img="N";
		}
	}
	return $p_img;
}



$freeCount = 0;
$member_count = 0;



/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$query = "select idx,total_point,grade_3_1,grade_3_2,grade_5,grade_6,level,gradeLevel,grade_point from Member where member_state='Y' and userId in ('lani319','ayh318','ayh319','ayh0319','tndls5','copgaz','tjscorb') order by idx";

$result = mysql_query($query);

for($i=0;$i<mysql_num_rows($result);$i++){
	
	/*변수들 초기화*/
	$level = 0;		//수정 될 level
	$memType = 0;	//수정 될 등급
	$total_point = 0;
	$total_price = 0;
	$gpoint1 = 0;
	$gpoint2 = 0;
	$tmp_level = 0;
	
	
	$row=mysql_fetch_array($result);
//7 8 9 10 (7 특별, 8 예전 프리미엄, 9 현재 유료회원, 10 일반) 을 대상으로 결제 여부를 판단한다.
	if($row[level] > 7){
		$sql="select enddate from Member_expert where mem_idx='".$row[idx]."' and exp_idx!='12' and (settle_mode='cast' || settle_mode='great_stock' || settle_mode='investment' || settle_mode='tiker') and enddate > ".mktime();
		$res=mysql_query($sql) or die(mysql_error());
		$rs=mysql_fetch_array($res);
		if($rs[enddate]){	//유료회원 기간이 남아있으면
			$level="9";
			$memType="2";

		}
		else{	//남아있지 않거나 없으면 일반회원으로 바꾼다.
			$level=10;
			$memType="0";
		}
	}else{ //일반 관리자, 콜센터, 전문가, 특별회원은 그대로 유지한다.
		if($row[level]=="0" || $row[level]=="3" || $row[level]=="4" || $row[level]=="7"){
			$level=$row[level];
			$memType="1";

		}
	}
	//유료회원인지 체크 끝
	
	echo "<br>";
	echo "쿼리 => ".$sql;
	echo "<br>";
	echo "수정 될 레벨 =>".$level;
	echo "<br>";
	echo "수정 될 회원구분 =>".$memType; //0 : 일반, 1:관리자 등 특별,  2:유료회원
	
	
	
	//일반회원에게만 포인트 적용
	//if (member_perm_imglib_member_list3($memType, $row['gradeLevel'],$row['idx'],$row['grade_point'])=="N"){
	if($level == 10 && $memType == 0)
	{
		$total_point = $row['total_point'];
		
		// 인터넷방송 결제
		$p_query = "select if(sum(price) is null, 0, sum(price)) as total_price from chargeInfo where uidx=$row[idx] and state in(1, 3, 10, 12)";
		$presult = mysql_query($p_query);
		$prow = mysql_fetch_array($presult);
		
		$total_price += $prow['total_price'];
		
//		echo $p_query . "<br>";
		
		// 502클럽 결제
		$p_query = "select if(sum(price) is null, 0, sum(price)) as total_price from investment_union_chargeInfo where uidx=$row[idx] and state in(1, 3, 10, 12)";
		$presult = mysql_query($p_query);
		$prow = mysql_fetch_array($presult);
		
		$total_price += $prow['total_price'];
		
//		echo $p_query . "<br>";
		
		// 심봤다, 투자전략 결제
		$p_query = "select if(sum(price) is null, 0, sum(price)) as total_price from chargeContentsInfo where uidx=$row[idx] and state in(1, 3, 8, 12)";
		$presult = mysql_query($p_query);
		$prow = mysql_fetch_array($presult);
		
		$total_price += $prow['total_price'];
		
//		echo $p_query . "<br>";

		// VOD결제
		$p_query = "select if(sum(price) is null, 0, sum(price)) as total_price from vod_charge where uidx=$row[idx] and state in(1, 3, 8, 12)";
		$presult = mysql_query($p_query);
		$prow = mysql_fetch_array($presult);
		
		$total_price += $prow['total_price'];
		
//		echo $p_query . "<br>";
		
		
		
		

		if($total_point <= 300){
			$gpoint1 = 0;
		}else if($total_point > 300 && $total_point <= 500){
			$gpoint1 = 40;
		}else if($total_point > 500 && $total_point <= 800){
			$gpoint1 = 80;
		}else if($total_point > 800 && $total_point <= 1000){
			$gpoint1 = 120;
		}else if($total_point > 1000 && $total_point <= 1500){
			$gpoint1 = 160;
		}else if($total_point > 1500 && $total_point <= 2000){
			$gpoint1 = 200;
		}else if($total_point > 2000 && $total_point <= 2500){
			$gpoint1 = 240;
		}else if($total_point > 2500 && $total_point <= 3000){
			$gpoint1 = 280;
		}else if($total_point > 3000 && $total_point <= 3500){
			$gpoint1 = 320;
		}else if($total_point > 3500 && $total_point <= 4000){
			$gpoint1 = 360;
		}else if($total_point > 4000 && $total_point <= 4500){
			$gpoint1 = 400;
		}else if($total_point > 4500 && $total_point <= 5000){
			$gpoint1 = 440;
		}else if($total_point > 5000 && $total_point <= 6000){
			$gpoint1 = 480;
		}else if($total_point > 6000 && $total_point <= 7000){
			$gpoint1 = 520;
		}else if($total_point > 7000 && $total_point <= 8000){
			$gpoint1 = 560;
		}else if($total_point > 8000){
			$gpoint1 = 600;
		}

		if($total_price == 0){
			$gpoint2 = 0;
		}else if($total_price > 0  && $total_price <= 200000){
			$gpoint2 = 100;
		}else if($total_price > 200000  && $total_price <= 1000000){
			$gpoint2 = 150;
		}else if($total_price > 1000000  && $total_price <= 3000000){
			$gpoint2 = 200;
		}else if($total_price > 3000000  && $total_price <= 5000000){
			$gpoint2 = 250;
		}else if($total_price > 8000000  && $total_price <= 8000000){
			$gpoint2 = 300;
		}else if($total_price > 10000000  && $total_price <= 10000000){
			$gpoint2 = 350;
		}else if($total_price > 10000000){
			$gpoint2 = 400;
		}
		
//		echo "활동 ".$gpoint1."<br>";
		
//		echo "구매 ".$gpoint2."<br>";

			
		$grade_point = $gpoint1+$gpoint2;

		if ($grade_point <= 50){//7등급
			$tmp_level = 7;
		} elseif ($grade_point > 50 && $grade_point <= 100){//6등급
			$tmp_level = 6;
		} elseif ($grade_point > 100 && $grade_point <= 300){//5등급
			$tmp_level = 5;
		} elseif ($grade_point > 300 && $grade_point <= 500){//4등급
			$tmp_level = 4;
		} elseif ($grade_point > 500 && $grade_point <= 700){//3등급
			$tmp_level = 3;
		} elseif ($grade_point > 700){//2등급
			$tmp_level = 2;
		}

//point_spend_check($writter_idx, "board_recommended", "P", 5, $idx, $db);

		$grade_query = "update Member set grade_point=$grade_point, gradeLevel=$tmp_level, memType=$memType, level=$level where idx=$row[idx]";
		mysql_query($grade_query);		

		if ($tmp_level == 6){//6등급
			if($row['grade_6'] == ""){
				$query1 = "update Member set grade_6='Y',total_point=total_point+300 where idx=$row[idx]";
				mysql_query($query1);
				point_spend_check($row[idx], "upgrade_6", "P", 300, "", "");
//				echo "Lv6 =>".$query1."<br>";
				
			}
		} elseif ($tmp_level == 5){//5등급
			if($row['grade_6'] == ""){
				$query1 = "update Member set grade_6='Y',total_point=total_point+300 where idx=$row[idx]";
				mysql_query($query1);
				point_spend_check($row[idx], "upgrade_6", "P", 300, "", "");
//				echo "Lv6-1 =>".$query1."<br>";
			}
			if($row['grade_5'] == ""){
				$query2 = "update Member set grade_5='".date('Y-m-d')."' where idx=$row[idx]";
				mysql_query($query2);
//				echo "Lv5-1 =>".$query2;
			}
		} elseif ($tmp_level == 2 || $tmp_level == 3){//2,3등급
			if($row['grade_6'] == ""){
				$query1 = "update Member set grade_6='Y',total_point=total_point+300 where idx=$row[idx]";
				mysql_query($query1);
				point_spend_check($row[idx], "upgrade_6", "P", 300, "", "");
				
//				echo "Lv6-2 =>".$query1;
			}
			if($row['grade_5'] == ""){
				$query2 = "update Member set grade_5='".date('Y-m-d')."' where idx=$row[idx]";
				mysql_query($query2);
				
//				echo "Lv5-2 =>".$query2;
			}
			if($row['grade_3_1'] == ""){
				$query3 = "update Member set grade_3_1='30',total_point=total_point+500 where idx=$row[idx]";
				mysql_query($query3);
				point_spend_check($row[idx], "upgrade_3", "P", 500, "", "");
				
//				echo "Lv3-2 =>".$query3;
			}
			if($row['grade_3_2'] != "Y"){
				$query5 = "update Member set grade_3_2='N' where idx=$row[idx]";
				mysql_query($query5);
				
//				echo "Lv3-3 =>".$query5;
			}
		}
		
		
		
		$freeCount++;
	} else {
//echo "유료회원<br>";
		
		
		$grade_query = "update Member set grade_point=1000, gradeLevel=1, memType=$memType, level=$level  where idx=$row[idx]";
		echo "유료 1등급 =>". $grade_query;
		mysql_query($grade_query);
		$member_count++;
	}
	
	echo "<br>";
	echo "수정 될 회원등급 =>".$tmp_level; //0 : 일반, 1:관리자 등 특별,  2:유료회원
	echo "<br>";
	echo "mType".$memType."<br>";
	echo "mLevel".$level."<br>";
		
	echo "<br>Free =>".$freeCount . "Mem =>".$member_count."<br>";
	echo "<br><br>---------------------------------------------------------<br><br>";
}

echo "끝";
?>
