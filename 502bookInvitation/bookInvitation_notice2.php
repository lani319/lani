<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
//���̵� üũ
if ($_COOKIE[_CKE_USER_ID] == "")
{
	echo "<script>alert('�α��� �� �̿� �� �ּ���');parent.top.location.href='/index.html';</script>";
}
else 
{
	$sql = "select count(idx) as cnt from 502bookTest where uidx=$_COOKIE[_CKE_USER_UID] and regDate >= '2011-11-27 00:00:00'";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	
	if ($rs[cnt] >= 1)
	{
		echo "<script>alert('ȸ������ �̹� ��û�ϼ̽��ϴ�. ��÷�ڴ� 12�� 7�� ���� 6�ñ��� ���� �����մϴ�.'); parent.top.location.href='/index.html'; this.self.close();</script>;";
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
			alert('�������� ���� �� �ּ���');			
			return;
		}
		if (v2.value == "")
		{
			alert('���ڱ����� ���� �� �ּ���');			
			return;
		}
		if (v3.value == "")
		{
			alert('���ڱⰣ�� ���� �� �ּ���');
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

		
	function close_popup(days) //1�� ���� �� ���� (�ڵ����� �� ����)
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
	<td>��û��</td>
	<td><input type="text" id="txtName" name="txtName" size="6" tabindex="1" value="<?=$_COOKIE[_CKE_USER_NAME]?>"></td>
	<td>����ó</td>
	<td>
		<input type="text" id="txtMobile1" name="txtMobile1" size="4" maxlength="3" value="010" tabindex="2">-
		<input type="text" id="txtMobile2" name="txtMobile2" size="5" maxlength="4" tabindex="3">-
		<input type="text" id="txtMobile3" name="txtMobile3" size="5" maxlength="4" tabindex="4">
	</td>
	</tr>
	<tr>
	<td>������</td>
	<td>
		<select name="selArea">
		<option value="">--
		<option value="����">����
		<option value="���">���(��õ,��õ,����,����,�д� ��)
		<option value="���">���
		<option value="�泲">�泲
		<option value="����">����
		<option value="����">����
		<option value="����">����
		<option value="����">����
		<option value="��Ÿ/�ؿ�">��Ÿ/�ؿ�
		</select>
	</td>
	<td>���ڱ���</td>
	<td>
		<select name="selinvestType">
		<option value="">--
		<option value="����">����
		<option value="������">������
		<option value="��������">��������		
		</select>
	</td>	
	</tr>
	<tr>
	<td>���ڱⰣ</td>
	<td colspan="3">
		<select name="selPeriod">
		<option value="">--
		<option value="1">1�� ����		
		<option value="2">2�� ����
		<option value="3">3�� ����
		<option value="4">4�� ����
		<option value="5">5�� ����
		<option value="6">6�� ����
		<option value="7">7�� ����
		<option value="8">8�� ����
		<option value="9">9�� ����
		<option value="10">10�� �̻�
		</select>
	</td>	
	</tr>
	<tr>
		<td colspan="10" align="center">		
		
		<img src="/images/btnBookInvitationSubmit.gif" style="cursor:hand;" onclick="regOk();">				
		<!--
		��û�� �����Ǿ����ϴ�. ��÷�ڴ� 12��7�� ������ ����6�ñ��� ���� �����մϴ�.
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