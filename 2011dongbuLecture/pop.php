<?php
$txtMemID = $_COOKIE[_CKE_USER_ID];

if ($txtMemID == null)
{
	echo "<script>alert('로그인 후 이용 해 주세요. 비 회원은 031-651-5023 으로 신청 부탁드립니다.');</script>";
	echo "<script>self.close();</script>";
}

?>

<!-- 2차 강연회 -->
<html>
<head>
	<title>평택촌놈 7월16일 동부증권 강연회 안내</title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link rel="stylesheet" type="text/css" href="/css/502style.css">
	<style type="text/css">
	body 
	{
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	</style>

	<script>
	function getCookie(name) 
	{
	   var from_idx = document.cookie.indexOf(name+'=');
	   if (from_idx != -1) { 
		  from_idx += name.length + 1
		  to_idx = document.cookie.indexOf(';', from_idx) 
	
		  if (to_idx == -1) {
				to_idx = document.cookie.length
		  }
		  return unescape(document.cookie.substring(from_idx, to_idx))
	   }
	}
	
	function setCookie(name, value, expDays) 
	{
	var exp = new Date(); 
	exp.setTime(exp.getTime() + (expDays*24*60*60*1000));
	var expire_date = new Date(exp);
		
	document.cookie = name + "=" + escape(value) + ";path=/; expires=" + expire_date.toGMTString(); 
	
	}

		
		function close_popup(days) //1일 동안 안 띄우기 (자동으로 안 띄우기)
		{
			setCookie("2011DongbuThird", "dongbu" , days);			
			self.close();
		}
		
		
		
function regOK()
{
	var f = document.form1;	
	f.submit();
}
	</script>
	
	
</head>

<body>
<form name="form1" method="POST" action="/lani/2011dongbuLecture/popRegOK.php" target="invFrame">

<table cellpadding="0" cellspacing="0" border="0" style="margin-left:0px;margin-top:0px;">
<tr>
<td align="center">
<br>
<font color="green" size="3"><b>※ 신청하기 클릭 시 바로 신청이 되므로, <br>신중하게 클릭하시길 바랍니다.</b></font>
</td>
</tr>

	<tr>
		<td style="margin-top:0px;margin-left:0px">
			<img src="/img/pop/pop_0716.jpg" border="0" style="cursor:hand;" onclick="regOK();">
		</td>
	</tr>
	<tr bgcolor='#E3E3E3' align=right height=26>
		<td>
			[<span style="cursor:pointer" onclick="Javascript:close_popup(1);">오늘하루 열지않기</span>]
			&nbsp;&nbsp;
			[<span style="cursor:pointer" onclick="Javascript:close_popup(3);">3일동안 열지않기</span>]
		</td>
	</tr>
</table>
</form>
</body>
<iframe name="invFrame" width="0" height="0"></iframe>
</html>