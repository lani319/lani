<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "SELECT * FROM recommend_jongmok 
           WHERE expert_idx = 3622 AND sell_mode = 'Y'
           ORDER BY idx ASC";


/*
expert_idx,jongmok,regdate,recommend_price,sell_price,gravity,profit,profit_rate
*/

$tmpRs = mysql_query($sql);

$memIdx = $_COOKIE["_CKE_USER_UID"];

$memLevel = $_COOKIE["_CKE_USER_LEVEL"];

if ($memLevel == 0 || $memLevel == 4){
	$sql2 = "SELECT count(idx) as cnt FROM Member_expert WHERE exp_idx = 3622 
	AND enddate > TIMESTAMP(NOW())";
}else {
	$sql2 = "SELECT count(idx) as cnt FROM Member_expert WHERE exp_idx = 3622 
	AND enddate > TIMESTAMP(NOW())
	and mem_idx = $memIdx";
}
$tmpRs2 = mysql_query($sql2);

$rs2 = mysql_fetch_array($tmpRs2);

if ($rs2[cnt] < 1)
{
	echo "열람 권한이 없습니다.";
	exit;
}


?>
<table cellpadding="0" cellspacing="0" width="700" border="0">
<tr align="center">
<td>종목</td>
<td>추천일</td>
<td>추천매수가격</td>
<td>비중</td>
</tr>
<tr><td colspan="10" height="1" bgcolor="Gray"></td></tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	?>
<tr><td colspan="10" height="1" bgcolor="Gray"></td></tr>
<tr align="center">
<td><?=$rs['jongmok']?></td>
<td><?=substr($rs['regdate'],0,10)?></td>
<td><?=number_format($rs['recommend_price'],0)?>원</td>
<td><?=$rs['gravity']?>%</td>
</tr>

	<?php
}
?>
<tr><td colspan="10" height="1" bgcolor="Gray"></td></tr>
<tr><td colspan="10" height="1" bgcolor="Gray"></td></tr>
</table>
