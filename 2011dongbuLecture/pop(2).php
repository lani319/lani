<html>
<head>
	<title>평택촌놈 강연회 안내</title>
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
	var odC = getCookie(name)+'';
	
	document.cookie = name + "=" + odC +","+ escape(value) + ";path=/; expires=" + expire_date.toGMTString(); 
	
	}

		
		function close_popup(days) //1일 동안 안 띄우기 (자동으로 안 띄우기)
		{
			setCookie("2011Dongbu", "dongbu" , days);
			//alert('cookie');
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
		<td style="margin-top:0px;margin-left:0px">
			<img src="/img/pop/lecture_pop03.jpg" border="0" style="cursor:hand;" onclick="regOK();">
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