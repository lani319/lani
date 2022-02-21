<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$sql = "
SELECT A.userId,A.gradeLevel, B.uidx,
B.settletype, B.state, B.price, B.months,B.paydate,
DATEDIFF(FROM_UNIXTIME(B.enddate),FROM_UNIXTIME(B.startdate))+1 AS day,B.options
FROM chargeInfo B INNER Join Member A
on A.idx = B.uidx
WHERE
B.expert_idx = 34904
AND
B.paydate > '2018-12-26 00:00:01'
AND
B.paydate <= '2019-12-31 23:59:59'

ORDER BY A.userId ASC

";

$tmpRs = mysql_query($sql);

?>

<table>
<tr><td colspan=20>통합방송 </td></tr>
<tr>
<td> 아이디 </td>
<td> 등급 </td>
<td> 회원번호 </td>
<td> 결제구분 </td>
<td> 결제상태 </td>
<td> 가격 </td>
<td> 개월 </td>
<td> 결제일 </td>
<td> 기간 </td>
<td> 메모 </td>
</tr>	
<?php

while($rs = mysql_fetch_array($tmpRs)){
	?>
	
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[4]?></td>
<td><?=$rs[5]?></td>
<td><?=$rs[6]?></td>
<td><?=$rs[7]?></td>
<td><?=$rs[8]?></td>
<td><?=$rs[9]?></td>

</tr>	
	<?php
}

?>
</table>



<?php
$sql = "
SELECT A.userId,A.gradeLevel,
B.uidx, B.settletype, B.state, B.price, B.months,B.paydate,
DATEDIFF(FROM_UNIXTIME(B.enddate_tiker),FROM_UNIXTIME(B.startdate_tiker))+1 as day,B.options
FROM stock_sms_chargeInfo B INNER Join Member A
on A.idx = B.uidx
WHERE
B.expert_tiker = 34904
AND
B.paydate > '2018-12-26 00:00:01'
AND
B.paydate <= '2019-12-31 23:59:59'

AND B.price > 900000
ORDER BY A.userId ASC

";

$tmpRs = mysql_query($sql);

?>

<table>
<tr><td colspan=20>파생SMS </td></tr>
<tr>
<td> 아이디 </td>
<td> 등급 </td>
<td> 회원번호 </td>
<td> 결제구분 </td>
<td> 결제상태 </td>
<td> 가격 </td>
<td> 개월 </td>
<td> 결제일 </td>
<td> 기간 </td>
<td> 메모 </td>
</tr>	
<?php

while($rs = mysql_fetch_array($tmpRs)){
	?>
	
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[4]?></td>
<td><?=$rs[5]?></td>
<td><?=$rs[6]?></td>
<td><?=$rs[7]?></td>
<td><?=$rs[8]?></td>
<td><?=$rs[9]?></td>

</tr>	
	<?php
}

?>
</table>

<?php
$sql = "
SELECT A.userId,A.gradeLevel,
B.uidx, B.settletype, B.state, B.price, B.months,B.paydate,
DATEDIFF(FROM_UNIXTIME(B.enddate_investment),FROM_UNIXTIME(B.startdate_investment))+1 as day,B.options
FROM investment_union_chargeInfo B INNER Join Member A
on A.idx = B.uidx
WHERE
B.expert_investment = 34904
AND
B.paydate > '2018-12-26 00:00:01'
AND
B.paydate <= '2019-12-31 23:59:59'

ORDER BY A.userId ASC

";

$tmpRs = mysql_query($sql);

?>

<table>
<tr><td colspan=20>개별파생 </td></tr>
<tr>
<td> 아이디 </td>
<td> 등급 </td>
<td> 회원번호 </td>
<td> 결제구분 </td>
<td> 결제상태 </td>
<td> 가격 </td>
<td> 개월 </td>
<td> 결제일 </td>
<td> 기간 </td>
<td> 메모 </td>
</tr>	
<?php

while($rs = mysql_fetch_array($tmpRs)){
	?>
	
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[4]?></td>
<td><?=$rs[5]?></td>
<td><?=$rs[6]?></td>
<td><?=$rs[7]?></td>
<td><?=$rs[8]?></td>
<td><?=$rs[9]?></td>

</tr>	
	<?php
}

?>
</table>

