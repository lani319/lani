<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



//ȸ�� �ʸ��� ���ڷ� �޴´�.
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
<td>ȸ������</td>
<td>��������</td>
<td>������</td>
<td>�����</td>
<td>������</td>
<td>��������</td>
</tr>
<tr bgcolor="Gray"><td height="1"  colspan="10"></td></tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)){
	
	$memInfo = $rs[userName]."($rs[userNickname])";
	
	switch ($rs["STATUS"])		//���� ���� 
	{
		case "0":
			$couponStatus = "�̻��";
		break;		
		case "1":
			$couponStatus = "���Ϸ�";
		break;
		case "2":
			$couponStatus = "�Ⱓ����";
		break;
	}
	
	$expiredDate = $rs[expiredDate];
	
	if($rs[couponIdx]==17)
	{
		$couponStatus = $rs[jongmokCnt]."�� ����";
		$expiredDate = "������";
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
*������ ���� ��û���� ���� ���� ���Ϻ��� ��û�� �� �ֽ��ϴ�. 
<?php
exit;
?>


