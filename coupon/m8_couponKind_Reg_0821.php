<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
?>
<html>
<head>
<script type="text/javascript">
function reg()
{
	var f = document.form1;
	f.submit();
}
</script>
</head>
<body onload="document.getElementById('txtCouponKind').focus();">
<form name="form1" method="POST" action = "m8_couponKind_regOK.php" target="invFrame">
<TABLE width="920" cellpadding=0 cellspacing=0 border=0>
<tr height=10><td></td></tr>
<tr>
	<td>
		<TABLE width="100%" cellpadding=0 cellspacing=0 border=0>
		<TR>
			<TD></TD>
			<TD valign="bottom" align="right"><img src="/admin/images/icon_location.gif" align="absmiddle"> �ܺλ���Ʈ���� &gt; �����������&nbsp;</TD>
		</TR>
		</TABLE>
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="650px" height="400px">
<tr>
<td align="left">*���� ���� �űԹ���</td>
<td align="left"><a href="m8_couponKind_list.html">[���]</a></td>
</tr>
<tr>
<td>��������</td>
<td><input type="text" size="50" name="txtCouponKind" id="txtCouponKind" tabindex="1"></td>
</tr>

<tr><td colspan="2" bgcolor="AAAAAA" height="1px"></td></tr>
<tr>
<td>��������</td>
<td>
<input type="radio" name="rdDcType" value="1">%(�ۼ�Ʈ)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdDcType" value="2">��(����)
</td>
</tr>
<tr><td colspan="2" bgcolor="AAAAAA" height="1px"></td></tr>
<tr>
<td>���κ��� / ���αݾ�</td>
<td><input type="text" size="10" name="txtDcValue" tabindex="2">&nbsp;&nbsp;&nbsp;(% / ��)</td>
</tr>
</tr>
<tr><td colspan="2" align="center"><img src="img/submit.gif" style="cursor:hand;" onclick="reg();"></td></tr>
</table>
</body>
<iframe name="invFrame" width="0px" height="0px"></iframe>
</html>