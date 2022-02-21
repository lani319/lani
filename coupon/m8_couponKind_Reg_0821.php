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
			<TD valign="bottom" align="right"><img src="/admin/images/icon_location.gif" align="absmiddle"> 외부사이트관리 &gt; 쿠폰종류등록&nbsp;</TD>
		</TR>
		</TABLE>
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="650px" height="400px">
<tr>
<td align="left">*쿠폰 종류 신규발행</td>
<td align="left"><a href="m8_couponKind_list.html">[목록]</a></td>
</tr>
<tr>
<td>쿠폰종류</td>
<td><input type="text" size="50" name="txtCouponKind" id="txtCouponKind" tabindex="1"></td>
</tr>

<tr><td colspan="2" bgcolor="AAAAAA" height="1px"></td></tr>
<tr>
<td>할인종류</td>
<td>
<input type="radio" name="rdDcType" value="1">%(퍼센트)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdDcType" value="2">원(가격)
</td>
</tr>
<tr><td colspan="2" bgcolor="AAAAAA" height="1px"></td></tr>
<tr>
<td>할인비율 / 할인금액</td>
<td><input type="text" size="10" name="txtDcValue" tabindex="2">&nbsp;&nbsp;&nbsp;(% / 원)</td>
</tr>
</tr>
<tr><td colspan="2" align="center"><img src="img/submit.gif" style="cursor:hand;" onclick="reg();"></td></tr>
</table>
</body>
<iframe name="invFrame" width="0px" height="0px"></iframe>
</html>