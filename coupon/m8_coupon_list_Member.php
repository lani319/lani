<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

if($searchflag == "")
{
	$searchflag = 1;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<LINK HREF="/css/style.css" REL="STYLESHEET" TYPE="TEXT/CSS" />
<script type="text/javascript">
function del()
{
	var f = document.form1;
	var c = document.getElementsByName("chkIdx");
	var len = c.length;
	
	
	
	var t = document.getElementById("txtIdx");
	t.value = "";
	
	for(var i = 0 ; i<len ; i++)
	{
	 	if(c[i].checked)
	 	{
	 		t.value += c[i].value+",";
	 	}
	}
	if(t.value=="")
	{
		alert('���� �� ������ ���� �� �ּ���');
		return;
	}
	var str = t.value;
	
	t.value = str.substring(0, str.length-1);

	f.submit();
}
</script>

</head>
<body>
<br><br>
<form name="form1" method="POST" action="m8_coupon_list_delOK.php" target="invFrame">
<input type="hidden" name="txtIdx">
<table width="920" cellpadding=0 cellspacing=0 border=0>
<tr>
<td align="left">
<img src="img/delCoupon.gif" style="cursor:hand;" onclick="del()">
</td>
</tr>
</table>

<?php

	
	//��ü �߱� ���� Ȯ��
	$sql = "SELECT A.idx,A.issueDate,A.usedDate,A.expiredDate,A.memIdx,A.STATUS,B.kind,B.dcValue,B.dcType
	FROM 502Coupon A INNER JOIN 502CouponKind B ON A.kind = B.idx
	INNER JOIN Member C ON A.memIdx = C.idx 
	where A.memIdx=$idx  
	ORDER BY A.idx DESC";	

$tmpRs = mysql_query($sql);
$couponListCount = mysql_num_rows($tmpRs);
$rowCnt  = 1;
?>
<table width="920" cellpadding=0 cellspacing=0 border=0>
<tr><td colspan="20">�� ���� ���� �� : <?=$couponListCount?>��</td></tr>
<tr bgcolor="AAAAAA" align="center">
<td></td>
<td height="25px" style="color:FFFFFF">����</td>
<td height="25px" style="color:FFFFFF">����</td>
<td height="25px" style="color:FFFFFF">������</td>
<td height="25px" style="color:FFFFFF">������</td>
<td height="25px" style="color:FFFFFF">������/���αݾ�</td>
<td height="25px" style="color:FFFFFF">���α���</td>
<td height="25px" style="color:FFFFFF">��������</td>
</tr>
<?php
while ($rs = mysql_fetch_array($tmpRs))
{
	switch ($rs[dcType])		//���� ���� ����  %�� ���� �� ��, �ݾ����� ���� �� ��
	{
		case "1":
			$dcType = "%";
		break;
		case "2":
			$dcType = "��";
		break;
	}
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
?>
<tr align="center">
<td><input type="checkbox" value="<?=$rs["idx"]?>" name="chkIdx"></td>
<td height="25px"><?=$rowCnt++?></td>
<td height="25px"><?=$rs["kind"]?></td>
<td height="25px"><?=$rs["issueDate"]?></td>
<td height="25px"><?=$rs["expiredDate"]?></td>
<td height="25px"><?=$rs["dcValue"]?></td>
<td height="25px"><?=$dcType?></td>
<td height="25px"><?=$couponStatus?></td>
</tr>	
<tr><td colspan="21" height="1" bgcolor="AAAAAA"></td></tr>
<?php
}
?>
</table>
</form>
</body>
<iframe name="invFrame" width="0px" height="0px"></iframe>
</html>