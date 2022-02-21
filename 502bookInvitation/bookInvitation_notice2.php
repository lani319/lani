<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
//아이디 체크
if ($_COOKIE[_CKE_USER_ID] == "")
{
	echo "<script>alert('로그인 후 이용 해 주세요');parent.top.location.href='/index.html';</script>";
}
else 
{
	$sql = "select count(idx) as cnt from 502bookTest where uidx=$_COOKIE[_CKE_USER_UID] and regDate >= '2011-11-27 00:00:00'";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	
	if ($rs[cnt] >= 1)
	{
		echo "<script>alert('회원님은 이미 신청하셨습니다. 당첨자는 12월 7일 저녁 6시까지 개별 연락합니다.'); parent.top.location.href='/index.html'; this.self.close();</script>;";
	}
}


?>

<html>
<head>
<link href="/css/502style.css">
<script type="text/javascript">
	function regOk()
	{
		var f = document.form1;
		var v1 = document.getElementById('selArea');
		var v2 = document.getElementById('selinvestType');
		var v3 = document.getElementById('selPeriod');
		
		if (v1.value == "")
		{
			alert('거주지를 선택 해 주세요');			
			return;
		}
		if (v2.value == "")
		{
			alert('투자구분을 선택 해 주세요');			
			return;
		}
		if (v3.value == "")
		{
			alert('투자기간을 선택 해 주세요');
			return;
		}
		
		f.submit();
	}
	

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
		setCookie("2011BookFirst", "Book" , days);			
		self.close();
	}
			
</script>
</head>
<body style="margin:0 0 0 0">
<form name="form1" method="POST" action="regOk_notice.php">
<table border="0" width="700px" height="900px" style="background-image: url('/images/bookInvitation2.jpg'); background-repeat: no-repeat;">
<tr>
<td height="760px">&nbsp;</td>
</tr>
<tr>
<td height="140px" align="center">
	<table width="90%" border="0" >
	<tr>
	<td>신청자</td>
	<td><input type="text" id="txtName" name="txtName" size="6" tabindex="1" value="<?=$_COOKIE[_CKE_USER_NAME]?>"></td>
	<td>연락처</td>
	<td>
		<input type="text" id="txtMobile1" name="txtMobile1" size="4" maxlength="3" value="010" tabindex="2">-
		<input type="text" id="txtMobile2" name="txtMobile2" size="5" maxlength="4" tabindex="3">-
		<input type="text" id="txtMobile3" name="txtMobile3" size="5" maxlength="4" tabindex="4">
	</td>
	</tr>
	<tr>
	<td>거주지</td>
	<td>
		<select name="selArea">
		<option value="">--
		<option value="서울">서울
		<option value="경기">경기(인천,과천,수원,성남,분당 등)
		<option value="충북">충북
		<option value="충남">충남
		<option value="전북">전북
		<option value="전남">전남
		<option value="강원">강원
		<option value="제주">제주
		<option value="기타/해외">기타/해외
		</select>
	</td>
	<td>투자구분</td>
	<td>
		<select name="selinvestType">
		<option value="">--
		<option value="전업">전업
		<option value="직장인">직장인
		<option value="간접투자">간접투자		
		</select>
	</td>	
	</tr>
	<tr>
	<td>투자기간</td>
	<td colspan="3">
		<select name="selPeriod">
		<option value="">--
		<option value="1">1년 이하		
		<option value="2">2년 이하
		<option value="3">3년 이하
		<option value="4">4년 이하
		<option value="5">5년 이하
		<option value="6">6년 이하
		<option value="7">7년 이하
		<option value="8">8년 이하
		<option value="9">9년 이하
		<option value="10">10년 이상
		</select>
	</td>	
	</tr>
	<tr>
		<td colspan="10" align="center">		
		
		<img src="/images/btnBookInvitationSubmit.gif" style="cursor:hand;" onclick="regOk();">				
		<!--
		신청이 마감되었습니다. 당첨자는 12월7일 수요일 오후6시까지 개별 연락합니다.
		-->
		</td>
	</tr>
	</table>
</td>
</tr>
</table>
</form>
</body>

</html>