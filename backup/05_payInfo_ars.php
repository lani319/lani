<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$totalCount = 1;
?>
ARS 결제정보 1<br><br>  

<TABLE width="100%" cellpadding=0 cellspacing=0 border=0>
			<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
			<tr height=1><td bgcolor='#FFFFFF' colspan=21></td></tr>
			<TR HEIGHT=27 bgcolor='#DDE3F3' align='center'>
				<td width=45>번호</td>

				<td width=80>결제코드</td>

				<td width=80>아이디</td>

				<td width=100>이름</td>

				<td>서비스명</td>

				<td width=120>서비스종류</td>

				<td width=80>처리상태</td>

				<td width=100>결제금액</td>

				<td width=115>신청일자</td>
				
				<td width=115>처리일자</td>
			</tr>
			<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
<?
if($totalCount){
	
	$today=date("Y-m-d");
	$num=$totalCount - $start_p;
	$sql = "
	select C.*, M.userID , M.userName
	from ars_card_info C
	inner join Member M
		on M.idx = C.uidx
	$addwhere 
	order by idx desc 
	limit 2000";
	$result = mysql_query($sql) or die("여기야: ".mysql_error());
	while($rs = mysql_fetch_array($result)){
		$couponprice = ""; //쿠폰 적용하면 쿠폰값 출력
		$pay_num = $rs['type'].'-'.$rs['idx'];
		$view_link = "<a href='/admin/m4_arscard_view.php?idx=$rs[idx]&page=$page'>";
		if($rs["isUsePoint"] == 'Y'){
			$use_point="(-".number_format($rs["point"])."P)&nbsp;&nbsp;";
		}
		else{
			$use_point= '';
		}
		if($use_point == ''){
			$type = $rs['type'];
			if($type == 'invest' || $type == 'tms' || $type == 'union' ||  $type == 'sms'){
				$SQL = "SELECT * FROM investment_union_chargeInfo WHERE idx='".$rs['pidx']."'";
				$mqf = mysql_fetch_array(mysql_query($SQL));

				if($mqf['isUseCoin'] == 'Y'){
					$use_point="(-".number_format($mqf["reprice"])."P)&nbsp;&nbsp;";
				}
				else{
					$use_point= '';
				}
				
				if($mqf['couponIdx']>0){
					$couponprice = $price."(쿠폰 ".number_format($mqf['couponUsedPrice']).")";
				}
				
				
				
			}
			else if($type == 'cast'){
				$SQL="select * from chargeInfo where idx='".$rs['pidx']."'";
				$mqf = mysql_fetch_array(mysql_query($SQL));

				if($mqf['isUsePoint'] == 'Y'){
					$use_point="(-".number_format($mqf["reprice"])."P)&nbsp;&nbsp;";
				}
				else{
					$use_point= '';
				}
			}
			else if($type == 'stboard'){
				$SQL="select * from chargeContentsInfo where idx='".$rs['pidx']."'";
				$mqf = mysql_fetch_array(mysql_query($SQL));

				if($mqf['isUseCoin'] == 'Y'){
					$use_point="(-".number_format($mqf["reprice"])."P)&nbsp;&nbsp;";
				}
				else{
					$use_point= '';
				}
			}
			else if($type == 'vod'){
				$SQL="select * from vod_charge where idx='".$rs['pidx']."'";
				$mqf = mysql_fetch_array(mysql_query($SQL));

				if($mqf['isUseCoin'] == 'Y'){
					$use_point="(-".number_format($mqf["reprice"])."P)&nbsp;&nbsp;";
				}
				else{
					$use_point= '';
				}
			}
		}
?>
			<tr bgcolor="ffffff"  height="26" align='center'>			
				
				<td><?=$num?></td>
				
				<td><?=$view_link ?><?=$pay_num ?></a></td>
				
				<td><?=$rs['userID']?></td>
				
				<td><?=$rs['userName']?></td>
				
				<td><?=$view_link ?><?=$rs['content']?></a></td>
				
				<td><?=$_ARS_PAY_SERVICE[$rs['type']]?></td>
				
				<td><?=$_ARS_PAY_STATE[$rs['state']]?></td>
				
				<td align=right><B>
				<? echo number_format($rs['price']); ?></B>&nbsp;원&nbsp;&nbsp;<?=$use_point?><?=$couponprice?>
				</td>
				
				<td><? echo $rs['regdate']; ?></td>
				
				<td><? echo $rs['paydate']; ?></td>
			</tr>
<?
		$num--;
	}// end while
} // end if

if(!$totalCount){
?>
			<tr height=30>
				<td colspan=21 bgcolor='#ffffff' align='center'><font color='red'>등록된 결제내역이 없습니다. </font></td>
			</tr>
			<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
<?
}
?>
			</TABLE>