<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



//회원 필명을 인자로 받는다.
//$userNickname

$sql = "SELECT A.userId,A.userName,A.userNickname,B.kind,B.issueDate,B.usedDate,B.expiredDate,B.STATUS,A.jongmokCnt,C.idx as couponIdx,C.kind as kindDetail
FROM Member A
INNER JOIN 502Coupon B ON A.idx = B.memIdx
INNER JOIN 502CouponKind C ON B.kind = C.idx 
WHERE A.userNickname='$userNickname' or A.userName='$userNickname'

ORDER BY B.memIdx ASc, B.issueDate DESC";

//echo $sql;

$tmpRs = mysql_query($sql);
?>
<link rel= "stylesheet" href="/css/502style.css" type="text/css">
<table border="0" width="95%" cellpadding="0" cellspacing="0">
<tr bgcolor="skyblue">
<td>회원정보</td>
<td>쿠폰종류</td>
<td>발행일</td>
<td>사용일</td>
<td>만료일</td>
<td>쿠폰상태</td>
</tr>
<tr bgcolor="Gray"><td height="1"  colspan="10"></td></tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)){
	
	$memInfo = $rs[userName]."($rs[userNickname])";
	
	switch ($rs["STATUS"])		//쿠폰 상태 
	{
		case "0":
			$couponStatus = "미사용";
		break;		
		case "1":
			$couponStatus = "사용완료";
		break;
		case "2":
			$couponStatus = "기간만료";
		break;
	}
	
	$expiredDate = $rs[expiredDate];
	
	if($rs[couponIdx]==17)
	{
		$couponStatus = $rs[jongmokCnt]."개 남음";
		$expiredDate = "무기한";
	}
	?>
<tr>
<td><?=$memInfo?></td>
<td><?=$rs[kindDetail]?></td>
<td><?=$rs[issueDate]?></td>
<td><?=$rs[usedDate]?></td>
<td><?=$expiredDate?></td>
<td><?=$couponStatus?></td>
</tr>
<tr bgcolor="Gray"><td height="1"  colspan="10"></td></tr>
	
	<?php
	
}
?>
</table>
*투자의 정석 시청권은 쿠폰 발행 당일부터 시청할 수 있습니다. 
<?php
exit;
?>


