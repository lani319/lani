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
	<td width="30%" bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">���̵�</font></b></td>
	<td><?=$row[userID]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">�̸�</font></b></td>
	<td><?=$row[userName]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">�г���(�ʸ�)</font></b></td>
	<td>	<?=$row[userNickname]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">���</font></b></td>
<td>	<?=$row[gradeLevel]?>���</td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">��������Ʈ</font></b></td>
	<td>	<?=number_format(($row[total_point] - $row[changed_point]))?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">��ȯ����Ʈ(����->����Ʈ)</font></b></td>
	<td><?=$row[changed_point] ?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">��������</font></b></td>
	<td><?=$row[pure_coin]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">��ȯ���� (����Ʈ->����)</font></b></td>
	<td><?=$row[changed_coin]?></td>							
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">�ֹι�ȣ</font></b></td>
	<td><? echo substr($usernum,0,6)." - *******"; ?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">�̸����ּ�</font></b></td>
	<td>
				<?=$email_header?>@<?=$email_footer?>
	</td>
</tr>								
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">�ּ� *</font></b></td>
	<td>
		<?=$zipcode[0]?>	-<?=$zipcode[1]?><br>
		<?=$row[address1]?><br>
		<?=$row[address2]?>
	</td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">�Ϲ���ȭ��ȣ *</font></b></td>
	<td>	<?=$phone[0]?>-<?=$phone[1]?>-<?=$phone[2]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr>
	<td bgcolor="e2eefa" style="padding: 0 0 0 10"><b><font color="#4F4F30">�޴���ȭ��ȣ</font></b></td>
	<td><?=$mobile[0]?>-<?=$mobile[1]?>-<?=$mobile[2]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">���ڱ���</font></b></td>
	<td>
	<? if($row[bond]=="H") echo "����"; ?>
	&nbsp; &nbsp;
	<? if($row[bond]=="S") echo "����"; ?>
	&nbsp; &nbsp;
	<? if($row[bond]=="T") echo "����+����"; ?>								
	</td>
</tr>
<tr>
<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">���ڼ���</font></b></td>
<td><?=$row["invest_trend"]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">���Ӱ��</font></b></td>
	<td><?=$row["join_path"]?></td>
</tr>
<tr>
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">������</font></b></td>
	<td><?=$row[signdate]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">�����̾�ȸ���Ⱓ</font></b></td>
	<td><?=premium_date_lib($idx)?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">��������</font></b></td>
	<td>
	<?
	if($row[login_time]){
		echo date("Y-m-d H:i:s",$row[login_time]);
	}else{
		echo "Ȩ������ ���� �� �α���� ����";
	}
	?>
	</td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">����Ƚ��</font></b></td>
	<td>
	<?
		if($row[login_counter]==0){
		echo "Ȩ������ ���� �� �α���� ����";
		}else{
		echo number_format($row[login_counter])."ȸ";
		}
	?>
</td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">�������� IP</font></b></td>
	<td><?=$row[last_user_ip]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>
<tr> 
	<td bgcolor="e2eefa" style="padding: 0 0 0 10" height="25"><b><font color="#4F4F30">�ֱ����� IP</font></b></td>
	<td><?=$row[recent_user_ip]?></td>
</tr>
<tr> 
	<td bgcolor="#FFFFFF" height=1 colspan=2></td>
</tr>

</table>
<br><br><br><br><br><br><br><br>
<table>
						<tr>
							<td height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">�����̾� ��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td width="180">���񽺱Ⱓ</td>
									<td width="2"></td>
									<td>���񽺸�</td>
									<td width="2"></td>
									<td width="60">�������</td>
									<td width="2"></td>
									<td width="90">�����ݾ�</td>
									<td width="2"></td>
									<td width="100">���</td>
									<td width="2"></td>
									<td width="75">������</td>
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
		$service_name="��������(".$_EXPERT_NICKNAME[$charge_info["expert_idx"]].")";
		
		if($charge_info[freeFlag]=="T")
		{
			$service_name="�߰��Ⱓ����(".$_EXPERT_NICKNAME[$charge_info["expert_idx"]].")";
		}
	}

	if($charge_info[options]){
		$options="<br>(".$charge_info[options].")";
	}else{
		unset($options);
	}

	if($charge_info[weeks_use]=="Y"){
		$term_sub = $charge_info[months]."��";
	}else{
		$term_sub = $charge_info[months]."����";
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
									<td align=right><B><?=number_format($charge_info['price'])?></B>��&nbsp;&nbsp;</td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">502Ŭ�� ��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="35" height="30">��ȣ</td>
						<td width="1"></td>
						<td width="180">���񽺱Ⱓ</td>
						<td width="1"></td>
						<td>���񽺸�</td>
						<td width="1"></td>
						<td width="55">�������</td>
						<td width="1"></td>
						<td width="80">�����ݾ�</td>
						<td width="1"></td>
						<td width="90">���</td>
						<td width="1"></td>
						<td width="60">������</td>
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
		$service_name = "��������";
	}

	if($charge_info["expert_investment"]){
		$service_name.="<br>[".$_EXPERT_NICKNAME[$charge_info["expert_investment"]]." ����Ŭ��]";
		$service_date = "����Ŭ��: ".date("Y-m-d",$charge_info[startdate_investment])."~".date("Y-m-d",$charge_info[enddate_investment]);
	}

	if($charge_info["expert_tiker"]){
		if($charge_info["expert_investment"]){
			$service_name.="+[".$_EXPERT_NICKNAME[$charge_info["expert_tiker"]]." 502ƼĿ]";
			$service_date .= "<br>502ƼĿ: ".date("Y-m-d",$charge_info[startdate_tiker])."~".date("Y-m-d",$charge_info[enddate_tiker]);
		}else{
			$service_name.="<br>[".$_EXPERT_NICKNAME[$charge_info["expert_tiker"]]." 502ƼĿ]";
			$service_date .= "502ƼĿ: ".date("Y-m-d",$charge_info[startdate_tiker])."~".date("Y-m-d",$charge_info[enddate_tiker]);
		}
	}

	if($charge_info[options]){
		$options="<br>(".$charge_info[options].")";
	}
	

	$price = "<b>".number_format($charge_info['price'])."</b>��&nbsp;&nbsp;";
	if($charge_info['isUseCoin'] == 'Y'){
		$price .= "<br>(".number_format($charge_info['reprice'])." Coin)"; 
	}

?>
								<tr align="center" height="30">
									<td><?=$num--?></td>
									<td></td>
									<td>
									<?=$charge_info[months]?>����
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
							<td width="120" height="40" style="padding: 0 0 0 10"><nobr><b><font color="#4F4F30">�ɺô� ������õ ��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="13" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td align=center>������</td>
									<td width="2"></td>
									<td width="80">�������</td>
									<td width="2"></td>
									<td width="80">�����ݾ�</td>
									<td width="2"></td>
									<td width="80">����/����Ʈ</td>
									<td width="2"></td>
									<td width="120">���</td>
									<td width="2"></td>
									<td width="75">������</td>
								</tr>
								<tr> 
									<td bgcolor="#C1C1B6" colspan="13" height="1"></td>
								</tr>
								<tr> 
									<td bgcolor="#F5F5F5" colspan="13" height="3"></td>
								</tr>


<?
$_INVEST_BOARD_ARRAY=array(
"st"=>"�����̳� ��������",
"100"=>"������õ",
"ars"=>"ARS�Ӻ�"
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
									<td><?=$_INVEST_BOARD_ARRAY[$charge_info['bn']]?>:<?=$charge_info['bidx']?> �� �Խù�</td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>��</td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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


						<!-- ����Ŭ�� ���� -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">����Ŭ�� ��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td width="180">���񽺱Ⱓ</td>
									<td width="2"></td>
									<td>���񽺸�</td>
									<td width="2"></td>
									<td width="60">�������</td>
									<td width="2"></td>
									<td width="90">�����ݾ�</td>
									<td width="2"></td>
									<td width="100">���</td>
									<td width="2"></td>
									<td width="75">������</td>
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
		$service_name="��������";
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
									<td><?=$charge_info[months]?>���� / <?=date("Y-m-d",$charge_info[startdate])?>~<?=date("Y-m-d",$charge_info[enddate])?></td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>��&nbsp;&nbsp;</td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
						<!-- ����Ŭ�� ���� -->



						<!-- ƼĿ���� -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">ƼĿ��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td width="180">�Ⱓ</td>
									<td width="2"></td>
									<td>���񽺸�</td>
									<td width="2"></td>
									<td width="60">�������</td>
									<td width="2"></td>
									<td width="90">�����ݾ�</td>
									<td width="2"></td>
									<td width="100">���</td>
									<td width="2"></td>
									<td width="75">������</td>
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
		$service_name="��������(".$_EXPERT_NICKNAME[$charge_info[expert_idx]].")";
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
									<td><?=$charge_info[months]?>���� / <?=date("Y-m-d",$charge_info[startdate])?>~<?=date("Y-m-d",$charge_info[enddate])?></td>
									<td></td>
									<td><?=$service_name?></td>
									<td></td>
									<td><?=$_CHARGE_SETTLETYPE[$charge_info['settletype']]?></td>
									<td></td>
									<td align=right><B><?=number_format($charge_info['price'])?></B>��&nbsp;&nbsp;</td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
						<!-- ƼĿ���� -->


						<!-- VOD���� -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">VOD��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td>���񽺸�</td>
									<td width="2"></td>
									<td width="80">�������</td>
									<td width="2"></td>
									<td width="90">�����ݾ�</td>
									<td width="2"></td>
									<td width="80">����/����Ʈ</td>
									<td width="2"></td>
									<td width="120">���</td>
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
		$service_name="����������";
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
									<td align=right><B><?=number_format($charge_info['price'])?></B>��&nbsp;&nbsp;</td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
						<!-- VOD���� -->
						
						
						
						
<!-- FIRST ���� -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">PC��� FIRST<br>��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td align=center>��ǰ�̸�</td>
									<td width="2"></td>
									<td width="40">����</td>
									<td width="2"></td>
									<td width="80">����</td>
									<td width="2"></td>
									<td width="80">�������</td>
									<td width="2"></td>
									<td width="80">�����ݾ�</td>
									<td width="2"></td>									
									<td width="75">������û��</td>
									<td width="2"></td>									
									<td width="75">�Ա�Ȯ����</td>
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
		$stateStr = "��������Ա�";
	}
	else if($charge_info[state]==1)
	{
		$stateStr = "�������ԱݿϷ�";
	}
	else if($charge_info[state]==2)
	{
		$stateStr = "�ſ�ī��ó�����";
	}
	else if($charge_info[state]==3)
	{
		$stateStr = "�ſ�ī������Ϸ�";
	}
	else 
	{
		$stateStr = "Ȯ�κҰ�";
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
									<td><b><?=number_format($charge_info[price]);?>��</b></td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
						<!-- FIRST ���� -->		
						
						
						<!-- FIRST2 ���� -->
						<tr>
							<td width="120" height="40" style="padding: 0 0 0 10"><b><font color="#4F4F30">�ڵ���� FIRST<br>��������</font></b></td>
							<td>&nbsp; </td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="700" border="0" cellspacing="0" cellpadding="0">
								<tr> 
									<td bgcolor="#C1C1B6" colspan="15" height="3"></td>
								</tr>
								<tr align="center"> 
									<td width="40" height="30">��ȣ</td>
									<td width="2"></td>
									<td align=center>��ǰ�̸�</td>
									<td width="2"></td>
									<td width="40">����</td>
									<td width="2"></td>
									<td width="80">����</td>
									<td width="2"></td>
									<td width="80">�������</td>
									<td width="2"></td>
									<td width="80">�����ݾ�</td>
									<td width="2"></td>									
									<td width="75">������û��</td>
									<td width="2"></td>									
									<td width="75">�Ա�Ȯ����</td>
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
		$stateStr = "��������Ա�";
	}
	else if($charge_info[state]==1)
	{
		$stateStr = "�������ԱݿϷ�";
	}
	else if($charge_info[state]==2)
	{
		$stateStr = "�ſ�ī��ó�����";
	}
	else if($charge_info[state]==3)
	{
		$stateStr = "�ſ�ī������Ϸ�";
	}
	else 
	{
		$stateStr = "Ȯ�κҰ�";
	}	
	
	
	
		//������ ��ǰ ���� ��������
	//��ǰ ���� ���
$purchasedInfo = "";
$arrSysInfo = explode("$",$charge_info[purchasedInfo]);
for($i=0 ; $i<sizeof($arrSysInfo)-1; $i++)
{
	$arrDetailInfo = explode("^",$arrSysInfo[$i]);	
	
	//echo $arrDetailInfo[0]; //��ǰ idx	
	//echo $arrDetailInfo[1]; //��ǰ ��� ����
	
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
	
	$purchasedInfo = $purchasedInfo.$pName." ".$arrDetailInfo[1]."��� <br>";
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
									<td><b><?=number_format($charge_info[totalPrice]);?>��</b></td>
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
								<tr><td height="100" align="center" colspan="15">���� ������ �������� �ʽ��ϴ�</td></tr>
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
						<!-- FIRST2 ���� -->	
						
										
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

