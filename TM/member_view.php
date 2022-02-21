<?


include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$searchSet ="?idx=$idx&page=$page&in_mode=$in_mode&search_by=$search_by&keyword=$keyword&orderby=$orderby&memType=$memType&gradeLevel=$gradeLevel&year=$year&month=$month&day=$day";

$query = "select * from Member  where idx='".$idx."'"; 
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result, MYSQL_ASSOC);

$zipcode=explode("-",$row[zipcode]);

$userEmail=explode("@",$row[userEmail]);
$email_header=$userEmail[0];
$email_footer=$userEmail[1];

$mobile=explode("-",$row[mobile]);
$phone=explode("-",$row[phone]);
$phonePremium=explode("-",$row[phonePremium]);
$mobilePremium=explode("-",$row[mobilePremium]);
$usernum=numDec($row[userNum]);

$sql2="select enddate from chargeInfo where uidx='".$idx."' order by idx desc limit 1";
$res2=mysql_query($sql2);
$rs2=mysql_fetch_array($res2);
?>


<link rel="stylesheet" href="/css/502style.css" type="text/css" />
<table width="600px" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="30%" bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">아이디</font></b></td>
	<td><?=$row[userID]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">이름</font></b></td>
	<td><?=$row[userName]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">닉네임(필명)</font></b></td>
	<td>	<?=$row[userNickname]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">등급</font></b></td>
<td>	<?=$row[gradeLevel]?>등급</td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">기존포인트</font></b></td>
	<td>	<?=number_format(($row[total_point] - $row[changed_point]))?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">전환포인트(코인->포인트)</font></b></td>
	<td><?=$row[changed_point] ?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">충전코인</font></b></td>
	<td><?=$row[pure_coin]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">전환코인 (포인트->코인)</font></b></td>
	<td><?=$row[changed_coin]?></td>							
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">주민번호</font></b></td>
	<td><? echo substr($usernum,0,6)." - *******"; ?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">이메일주소</font></b></td>
	<td>
				<?=$email_header?>@<?=$email_footer?>
	</td>
</tr>								
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">주소 *</font></b></td>
	<td>
		<?=$zipcode[0]?>	-<?=$zipcode[1]?><br>
		<?=$row[address1]?><br>
		<?=$row[address2]?>
	</td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">일반전화번호 *</font></b></td>
	<td>	<?=$phone[0]?>-<?=$phone[1]?>-<?=$phone[2]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">휴대전화번호</font></b></td>
	<td><?=$mobile[0]?>-<?=$mobile[1]?>-<?=$mobile[2]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">투자구분</font></b></td>
	<td>
	<? if($row[bond]=="H") echo "현물"; ?>
	&nbsp; &nbsp;
	<? if($row[bond]=="S") echo "선물"; ?>
	&nbsp; &nbsp;
	<? if($row[bond]=="T") echo "현물+선물"; ?>								
	</td>
</tr>
<tr>
<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">투자성향</font></b></td>
<td><?=$row["invest_trend"]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">접속경로</font></b></td>
	<td><?=$row["join_path"]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">가입일</font></b></td>
	<td><?=$row[signdate]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">프리미엄회원기간</font></b></td>
	<td><?=premium_date_lib($idx)?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">최종접속</font></b></td>
	<td>
	<?
	if($row[login_time]){
		echo date("Y-m-d H:i:s",$row[login_time]);
	}else{
		echo "홈페이지 개편 후 로긴사항 없음";
	}
	?>
	</td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">접속횟수</font></b></td>
	<td>
	<?
		if($row[login_counter]==0){
		echo "홈페이지 개편 후 로긴사항 없음";
		}else{
		echo number_format($row[login_counter])."회";
		}
	?>
</td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">지난접속 IP</font></b></td>
	<td><?=$row[last_user_ip]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">최근접속 IP</font></b></td>
	<td><?=$row[recent_user_ip]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>

</table>
<br><br><br><br><br><br><br><br>
<table>
						<tr>
							<td height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">프리미엄 결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td width="180">서비스기간</td>
									<td width="2"></td>
									<td>서비스명</td>
									<td width="2"></td>
									<td width="60">결제방식</td>
									<td width="2"></td>
									<td width="90">결제금액</td>
									<td width="2"></td>
									<td width="100">결과</td>
									<td width="2"></td>
									<td width="75">결제일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?

$sql="select * from chargeInfo where uidx='".$idx."' order by idx desc";
$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){
	unset($service_name);
	$service_sql="select * from service_kind where service_orderID='".$charge_info[service_type]."'";
	$service_result=mysql_query($service_sql);
	$service_info=mysql_fetch_array($service_result);
	
	if($service_info[service_name]){
		if($charge_info["multiple_service"]=="Y"){
			$chg_sql="select expert_idx,freeFlag from chargeInfo where buy_no='".$charge_info[buy_no]."'";
			$chg_res=mysql_query($chg_sql);
			while($chg_rs=mysql_fetch_array($chg_res)){
				$sql="select userNickname from Member where idx='".$chg_rs[expert_idx]."' and level < 7";
				$expinfo=mysql_fetch_array(mysql_query($sql));
				if($service_name) $service_name.=" + ";
				$service_name .= $expinfo[userNickname];
			}
			$service_name="(".$service_name.")";
		}else{
			$service_name=$service_info[service_name];
		}
	}else{
		$service_name="임의적용(".$_EXPERT_NICKNAME[$charge_info["expert_idx"]].")";
		
		if($charge_info[freeFlag]=="T")
		{
			$service_name="추가기간적용(".$_EXPERT_NICKNAME[$charge_info["expert_idx"]].")";
		}
	}

	if($charge_info[options]){
		$options="<br>(".$charge_info[options].")";
	}else{
		unset($options);
	}

	if($charge_info[weeks_use]=="Y"){
		$term_sub = $charge_info[months]."주";
	}else{
		$term_sub = $charge_info[months]."개월";
	}
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$term_sub?> / <?=date("Y-m-d",$charge_info[startdate])?>~<?=date("Y-m-d",$charge_info[enddate])?></td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td>
									
									<?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?>
									
									</td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>원&nbsp;&nbsp;</td>
									<td></td>
									<td><?=$_CHARGE_RESULT_INFO[$charge_info['state']].$options?></td>
									<td></td>
									<td><?=substr($charge_info['paydate'],0,10)?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>



						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">502클럽 결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="35" height="30">번호</td>
						<td width="1"></td>
						<td width="180">서비스기간</td>
						<td width="1"></td>
						<td>서비스명</td>
						<td width="1"></td>
						<td width="55">결제방식</td>
						<td width="1"></td>
						<td width="80">결제금액</td>
						<td width="1"></td>
						<td width="90">결과</td>
						<td width="1"></td>
						<td width="60">결제일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?
$sql="select * from investment_union_chargeInfo where uidx='".$idx."' order by idx desc";
$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){
	unset($service_name, $service_date, $options);

	if($charge_info[service_type]){
		$service_sql="select service_name from investment_union_service_kind where service_orderID='".$charge_info[service_type]."'";
		$service_result=mysql_query($service_sql);
		$service_info=mysql_fetch_array($service_result);
		
		$service_name=$service_info[service_name];
	}else{
		$service_name = "임의적용";
	}

	if($charge_info["expert_investment"]){
		$service_name.="<br>[".$_EXPERT_NICKNAME[$charge_info["expert_investment"]]." 투자클럽]";
		$service_date = "투자클럽: ".date("Y-m-d",$charge_info[startdate_investment])."~".date("Y-m-d",$charge_info[enddate_investment]);
	}

	if($charge_info["expert_tiker"]){
		if($charge_info["expert_investment"]){
			$service_name.="+[".$_EXPERT_NICKNAME[$charge_info["expert_tiker"]]." 502티커]";
			$service_date .= "<br>502티커: ".date("Y-m-d",$charge_info[startdate_tiker])."~".date("Y-m-d",$charge_info[enddate_tiker]);
		}else{
			$service_name.="<br>[".$_EXPERT_NICKNAME[$charge_info["expert_tiker"]]." 502티커]";
			$service_date .= "502티커: ".date("Y-m-d",$charge_info[startdate_tiker])."~".date("Y-m-d",$charge_info[enddate_tiker]);
		}
	}

	if($charge_info[options]){
		$options="<br>(".$charge_info[options].")";
	}
	

	$price = "<b>".number_format($charge_info['price'])."</b>원&nbsp;&nbsp;";
	if($charge_info['isUseCoin'] == 'Y'){
		$price .= "<br>(".number_format($charge_info['reprice'])." Coin)"; 
	}

?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td>
									<?=$charge_info[months]?>개월
									<br>
									<?=$service_date?>
									</td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><?=$price ?>&nbsp;&nbsp;</td>
									<td></td>
									<td><?=$_CHARGE_RESULT_INFO[$charge_info['state']].$options?></td>
									<td></td>
									<td><?=substr($charge_info['paydate'],0,10)?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>
						
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><nobr><b><font color="#4F4F30">심봤다 종목추천 결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="13" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td align=center>컨텐츠</td>
									<td width="2"></td>
									<td width="80">결제방식</td>
									<td width="2"></td>
									<td width="80">결제금액</td>
									<td width="2"></td>
									<td width="80">코인/포인트</td>
									<td width="2"></td>
									<td width="120">결과</td>
									<td width="2"></td>
									<td width="75">결제일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="13" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="13" height="3"></td>
								</tr>


<?
$_INVEST_BOARD_ARRAY=array(
"st"=>"평택촌놈 투자전략",
"100"=>"종목추천",
"ars"=>"ARS속보"
);
$sql="select * from chargeContentsInfo where uidx='".$idx."' order by idx desc";
$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){
	
	$service_sql="select * from service_kind where service_orderID='".$charge_info[service_type]."'";
	$service_result=mysql_query($service_sql);
	$service_info=mysql_fetch_array($service_result);
	
	if($service_info[service_name]){
		$service_name=$service_info[service_name];
	}

	if($charge_info[reprice]){
		if($charge_info['isUseCoin'] == 'Y'){
			$use_point =  "-".number_format($charge_info['reprice'])." Coin"; 
		}
		else{
			$sql="select gubun, point from point_spend_state where state='stboard_view' and bidx='".$charge_info[idx]."'";
			$res=mysql_query($sql);
			$rs=mysql_fetch_array($res);

			if($rs[gubun]=="P"){
				$use_point="+";
			}else{
				$use_point="-";
			}

			$use_point .= Number_format($rs[point])." Point";
		}
	}else{
		unset($use_point);
	}

	if($charge_info[state]=="1" || $charge_info[state]=="3" || $charge_info[state]=="8" || $charge_info[state]=="9"){
		$paydate = substr($charge_info[paydate],0,10);
	}else{
		$paydate = substr($charge_info[signdate],0,10);
	}
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$_INVEST_BOARD_ARRAY[$charge_info['bn']]?>:<?=$charge_info['bidx']?> 번 게시물</td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>원</td>
									<td></td>
									<td align=right><?=$use_point?></td>
									<td></td>
									<td><?=$_CHARGE_RESULT_CONTENT_INFO[$charge_info['state']]?></td>
									<td></td>
									<td><?=$paydate?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="13" height="1"></td>
								</tr>
<?
}
if(!$charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="13" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>


						<!-- 투자클럽 결제 -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">투자클럽 결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td width="180">서비스기간</td>
									<td width="2"></td>
									<td>서비스명</td>
									<td width="2"></td>
									<td width="60">결제방식</td>
									<td width="2"></td>
									<td width="90">결제금액</td>
									<td width="2"></td>
									<td width="100">결과</td>
									<td width="2"></td>
									<td width="75">결제일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?

$sql="select * from investment_chargeInfo where uidx='".$idx."' order by idx desc";
$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){
	
	$service_sql="select service_name from investment_service_kind where service_orderID='".$charge_info[service_type]."'";
	$service_result=mysql_query($service_sql);
	$service_info=mysql_fetch_array($service_result);
	
	if($service_info[service_name]){
		$service_name=$service_info[service_name];
	}else{
		$service_name="임의적용";
	}

	if($charge_info[options]){
		$options="<br>(".$charge_info[options].")";
	}else{
		unset($options);
	}
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$charge_info[months]?>개월 / <?=date("Y-m-d",$charge_info[startdate])?>~<?=date("Y-m-d",$charge_info[enddate])?></td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>원&nbsp;&nbsp;</td>
									<td></td>
									<td><?=$_CHARGE_RESULT_INFO[$charge_info['state']].$options?></td>
									<td></td>
									<td><?=substr($charge_info['paydate'],0,10)?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>
						<!-- 투자클럽 결제 -->



						<!-- 티커결제 -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">티커결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td width="180">기간</td>
									<td width="2"></td>
									<td>서비스명</td>
									<td width="2"></td>
									<td width="60">결제방식</td>
									<td width="2"></td>
									<td width="90">결제금액</td>
									<td width="2"></td>
									<td width="100">결과</td>
									<td width="2"></td>
									<td width="75">결제일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?

$sql="select * from tiker_charge where uidx='".$idx."' order by idx desc";
$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$tiker_charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){
	
	$service_sql="select * from tiker_service_kind where service_orderID='".$charge_info[service_type]."'";
	$service_result=mysql_query($service_sql);
	$service_info=mysql_fetch_array($service_result);
	
	if($service_info[service_name]){
		$service_name=$service_info[service_name];
	}else{
		$service_name="임의적용(".$_EXPERT_NICKNAME[$charge_info[expert_idx]].")";
	}

	if($charge_info[options]){
		$options="<br>(".$charge_info[options].")";
	}else{
		unset($options);
	}
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$charge_info[months]?>개월 / <?=date("Y-m-d",$charge_info[startdate])?>~<?=date("Y-m-d",$charge_info[enddate])?></td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>원&nbsp;&nbsp;</td>
									<td></td>
									<td><?=$_CHARGE_RESULT_INFO[$charge_info['state']].$options?></td>
									<td></td>
									<td><?=substr($charge_info['paydate'],0,10)?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$tiker_charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>
						<!-- 티커결제 -->


						<!-- VOD결제 -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">VOD결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td>서비스명</td>
									<td width="2"></td>
									<td width="80">결제방식</td>
									<td width="2"></td>
									<td width="90">결제금액</td>
									<td width="2"></td>
									<td width="80">코인/포인트</td>
									<td width="2"></td>
									<td width="120">결과</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?

$sql="select * from vod_charge where uidx='".$idx."' order by idx desc";
$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$vod_charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){
	
	$service_sql="select * from vod_service_kind where service_orderID='".$charge_info[service_type]."'";
	$service_result=mysql_query($service_sql);
	$service_info=mysql_fetch_array($service_result);
	
	if($service_info[service_name]){
		$service_name=$service_info[service_name];
	}else{
		$service_name="개별컨텐츠";
	}
	
	$use_point = 0;
	if($charge_info['reprice']){
		if($charge_info['isUseCoin'] == 'N'){
			$sql="select gubun, point from point_spend_state where state='vod_view' and bidx='".$charge_info[idx]."'";
			$res=mysql_query($sql);
			$rs=mysql_fetch_array($res);

			if($rs[gubun]=="P"){
				$use_point="+";
			}else{
				$use_point="-";
			}

			$use_point .= Number_format($rs[point])." Point";
		}
		else{
			$use_point = '-'.Number_format($charge_info['reprice'])." Coin";
		}
	}
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>원&nbsp;&nbsp;</td>
									<td></td>
									<td><?=$use_point ?></td>
									<td></td>
									<td><?=$_CHARGE_RESULT_INFO[$charge_info['state']]?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$vod_charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>
						<!-- VOD결제 -->
						
						
						
						
<!-- FIRST 결제 -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">PC기반 FIRST<br>결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td align=center>상품이름</td>
									<td width="2"></td>
									<td width="40">개월</td>
									<td width="2"></td>
									<td width="80">계좌</td>
									<td width="2"></td>
									<td width="80">결제방식</td>
									<td width="2"></td>
									<td width="80">결제금액</td>
									<td width="2"></td>									
									<td width="75">결제신청일</td>
									<td width="2"></td>									
									<td width="75">입금확인일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?
$sql="select A.*,B.* from First_chargeInfo A inner join UCS_kind B on A.service_type = B.idx where A.uidx='".$idx."' order by A.idx desc limit 0,20";
//echo $sql;

$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){	
	if($charge_info[state]==0)
	{
		$stateStr = "무통장미입금";
	}
	else if($charge_info[state]==1)
	{
		$stateStr = "무통장입금완료";
	}
	else if($charge_info[state]==2)
	{
		$stateStr = "신용카드처리대기";
	}
	else if($charge_info[state]==3)
	{
		$stateStr = "신용카드결제완료";
	}
	else 
	{
		$stateStr = "확인불가";
	}	
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$charge_info[ucs_name]?></td>
									<td></td>
									<td><?=$charge_info[months]?></td>
									<td></td>
									<td><?=$charge_info[accCnt]?></td>
									<td></td>
									<td><?=$stateStr?></td>
									<td></td>
									<td><b><?=number_format($charge_info[price]);?>원</b></td>
									<td></td>									
									<td><?=$charge_info[signdate]?></td>
									<td></td>									
									<td><?=$charge_info[paydate]?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>
						<!-- FIRST 결제 -->		
						
						
						<!-- FIRST2 결제 -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">자동운용 FIRST<br>결제내역</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">번호</td>
									<td width="2"></td>
									<td align=center>상품이름</td>
									<td width="2"></td>
									<td width="40">개월</td>
									<td width="2"></td>
									<td width="80">계좌</td>
									<td width="2"></td>
									<td width="80">결제방식</td>
									<td width="2"></td>
									<td width="80">결제금액</td>
									<td width="2"></td>									
									<td width="75">결제신청일</td>
									<td width="2"></td>									
									<td width="75">입금확인일</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="15" height="3"></td>
								</tr>
<?
$sql="select * from First_purchasedInfo where memIdx='".$idx."' order by idx desc limit 0,20";

$charge_result=mysql_query($sql);
$num=mysql_num_rows($charge_result);
$charge_count=mysql_num_rows($charge_result);
while($charge_info=mysql_fetch_array($charge_result)){	
	if($charge_info[state]==0)
	{
		$stateStr = "무통장미입금";
	}
	else if($charge_info[state]==1)
	{
		$stateStr = "무통장입금완료";
	}
	else if($charge_info[state]==2)
	{
		$stateStr = "신용카드처리대기";
	}
	else if($charge_info[state]==3)
	{
		$stateStr = "신용카드결제완료";
	}
	else 
	{
		$stateStr = "확인불가";
	}	
	
	
	
		//구매한 상품 정보 가져오기
	//상품 종류 계산
$purchasedInfo = "";
$arrSysInfo = explode("$",$charge_info[purchasedInfo]);
for($i=0 ; $i<sizeof($arrSysInfo)-1; $i++)
{
	$arrDetailInfo = explode("^",$arrSysInfo[$i]);	
	
	//echo $arrDetailInfo[0]; //상품 idx	
	//echo $arrDetailInfo[1]; //상품 계약 수량
	
	switch($arrDetailInfo[0])
	{
		case 4:				
		$pName = "FIRST1";
		break;
				
		case 5:				
		$pName = "FIRST2";
		break;
				
		case 6:				
		$pName = "FIRST3";
		break;
				
		case 7:				
		$pName = "FIRST4";
		break;
				
		case 8:				
		$pName = "FIRST5";
		break;
				
		case 9:				
		$pName = "FIRST6";
		break;
	}
	
	$purchasedInfo = $purchasedInfo.$pName." ".$arrDetailInfo[1]."계약 <br>";
}
?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td><?=$purchasedInfo?></td>
									<td></td>
									<td><?=$charge_info[period]?></td>
									<td></td>
									<td><?=$charge_info[totalCnt]?></td>
									<td></td>
									<td><?=$stateStr?></td>
									<td></td>
									<td><b><?=number_format($charge_info[totalPrice]);?>원</b></td>
									<td></td>									
									<td><?=$charge_info[purchasedTime]?></td>
									<td></td>									
									<td><?=$charge_info[paydate]?></td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="1"></td>
								</tr>
<?
}
if(!$charge_count){
?>
								<tr><td height="100" align="center" colspan="15">결제 내역이 존재하지 않습니다</td></tr>
								<tr> 
									<td bgcolor="#DADAD4" colspan="15" height="2"></td>
								</tr>
<?
}
?>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"   bgcolor="#AEAE9F" height="3"></td>
						</tr>
						<!-- FIRST2 결제 -->	
						
										
						</table>
						</form>
					
					
					
					</td>
				</tr>
				</table>


			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

