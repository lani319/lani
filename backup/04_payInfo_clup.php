<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$totalCount = 1;
?>
502Ŭ�� �������� 1<br><br>  
 
 
 <TABLE width="100%" cellpadding=0 cellspacing=0 border=0>
			<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
			<tr height=1><td bgcolor='#FFFFFF' colspan=21></td></tr>
			<TR HEIGHT=27 bgcolor='#DDE3F3' align='center'>
				<td width=45>��ȣ</td>
				<td width="100">������</td>
				<td>���̵�</td>
				<td width=80>�̸�</td>
				<td width=80>��������</td>
				<td width=130>ó������</td>
				<td width=80>�����ݾ�</td>
				<td width=120>��û����</td>
				<td width=120>ó������</td>
			</tr>
<?
if($totalCount){
	$today=date("Y-m-d");
	$num=$totalCount - $start_p;
	$sql = "
	select C.*, M.userID , M.userName  , M.mobile
	from investment_union_chargeInfo C
	inner join Member M
		on M.idx = C.uidx
	$addwhere 
	order by idx desc 
	limit 1000,1000";
	
	echo $sql;  
	
	$result = mysql_query($sql) or die(mysql_error());
	while($rs = mysql_fetch_array($result)){
		unset($goods, $expert_search_view);

		if($rs["expert_investment"]){
			if($rs['signdate'] < '2014-10-22 00:00:00') $goods = "[".$_EXPERT_NICKNAME[$rs["expert_investment"]]." ����Ŭ��]";
			else $goods = "[".$_EXPERT_NICKNAME[$rs["expert_investment"]]." �Ļ�SMS]";
		}	

		if($rs["expert_tiker"]){
			if($goods) $goods.="<br>";
			$goods .= "[".$_EXPERT_NICKNAME[$rs["expert_tiker"]]." 502SMS]";
		}
		
		$idx_link="<a href='/admin/m4_investment_single_chargeinfo_view.php?idx=".$rs[idx]."&page=".$page.$searchSet."'>".$rs[buy_no]."</a>";
		
		$idx_link = $rs[buy_no];
		
		$userid_link="<a href='/admin/m4_investment_single_chargeinfo_view.php?idx=".$rs[idx]."&page=".$page.$searchSet."'>".$rs[userID]."</a>";
		
		$userid_link = $rs[userID];

		if($rs['isUseCoin'] == 'Y' && $rs['reprice'] != 0){
			$use_coin = "(".number_format($rs['reprice'])." Point)";
		}
		else{
			unset($use_coin);
		}
		
		$price = "<B>".number_format($rs['price'])."</B>&nbsp;��".$expert_search_view.$use_coin;

		if($rs['isEvent'] == 'Y' && $rs['eventPrice'] != 0){
			$price = "<B><strike>".number_format($rs['price'])."</strike></B>&nbsp;��<font color='red'><b>".number_format($rs['eventPrice'])."</b></font>&nbsp;��".$use_coin;
		}
		if($rs['couponIdx'] > 0)	{
			$price = $price."(���� ".number_format($rs['couponUsedPrice']).")";
		}
		

		$state = $_CHARGE_RESULT_INFO[$rs['state']];
		if($rs['options'] != ""){
			$state = $state."".$rs['options'];
		}

?>

			<tr height="36" align='center'>
				<td><?=$num--?></td>
				<td><?=$goods?></td>
				<td><?=$userid_link?></td>
				<td><?=$rs[userName]?></td>
				<td><?=$_CHARGE_SETTLETYPE[$rs['settletype']]?></td>
				<td><?=$state?></td>
				<td align=right><?=$price ?></td>
				<td><? echo $rs['signdate']; ?></td>
				<td><? echo $rs['paydate']; ?></td>
			</tr>
<?
	}// end while
} // end if

if(!$totalCount){
?>
			<tr height=50>
				<td colspan=21 bgcolor='#ffffff' align='center'><font color='red'>��ϵ� ���������� �����ϴ�.</font></td>
			</tr>
			<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
<?
}
?>
			</TABLE>