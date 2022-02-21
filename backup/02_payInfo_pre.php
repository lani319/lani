<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "select C.*, M.userID , M.userName , M.mobile from chargeInfo C inner join Member M 
on M.idx = C.uidx order by idx ASC LIMIT 8000,3000"; //
$tmpRs = mysql_query($sql);

?>
프리미엄 결제정보<br><br>
<table cellpadding="0" cellspacing="0" border="1">
<tr>
<td>idx</td>	
<td>uidx</td>	
<td>buy_no</td>
	<td>settletype</td>	
	<td>service_type</td>	
	<td>price</td>	
	<td>reprice</td>	
	<td>startdate</td>
	<td>enddate</td>
	<td>months</td>
	<td>b_name</td>
	<td>bank</td>	
	<td>c_name</td>
	<td>card</td>
	<td>state</td>	
	<td>signdate</td>
	<td>paydate</td>	
	<td>expert_idx</td>	
	<td>options</td>
	<td>weeks_use</td>	
	<td>multiple_service</td>
	<td>m_name</td>
	<td>mobile</td>	
	<td>leading_broadcast</td>
	<td>over_settle_check</td>
	<td>over_settle_idx</td>
	<td>freeFlag</td>
	<td>isEvent</td>
	<td>eventPrice</td>
	<td>couponIdx</td>
	<td>isUsePoint</td>	
	<td>couponUsedPrice</td>
	<td>couponOriPrice</td>
	<td>gd_idx</td>
	<td>userID</td>
	<td>userName</td>
	<td>mobile</td>
</tr>

<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	echo "<tr>";
	for($i=0;$i<35;$i++){
	?>
	<td><?=$rs[$i]?></td>
	<?php
	}
	echo "</tr>";
}
?>

</table>

