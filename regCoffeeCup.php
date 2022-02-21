<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$uidx = $_COOKIE[_CKE_USER_UID];


$meminfo = get_meminfo($uidx,"userId,userName,address1,address2,mobile");
?>

<html>
<head>

<script type="text/javascript">

function chkForm(){
	
	 
	
	var f = document.form1;
	
	var txtName = document.getElementById('txtName');
	var txtAdd = document.getElementById('txtAddress');
	var txtMobile = document.getElementById('txtMobile');
	var txtCup1 = document.getElementById('txtCupSelect1');
	var txtCup2 = document.getElementById('txtCupSelect2');
	
	if(txtName.value == '')
	{
		alert('이름을 확인해 주세요');
		return false;
	}
	if(txtAdd.value == '')
	{
		alert('주소를 확인해 주세요');
		return false;
	}
	if(txtMobile.value == '')
	{
		alert('연락처를 확인해 주세요');
		return false;
	}
	
	if(txtCup1.value == '0' && txtCup2.value == '0')
	{
		alert('머그잔을 선택해 주세요');
		return false;
	}
	
	f.submit();
	
}

</script>
</head>
<body>

<form name='form1' action='regCoffeeCupOk.php' method='POST'>
<table width=690px>
<tr>
<td>
<img src="http://www.502.co.kr/upload_file/WImgPost/2020/01/1578013016564.jpg" border=0>
</td>
</tr>
<tr>
<td>
<table width=100%>
<tr>
<td width=150px>받는사람</td>
<td><input name="txtName" id="txtName" type="text" size=10 value="<?=$meminfo[userName]?>"></td>
</tr>

<tr>
<td>주소</td>
<td><input name="txtAddress" id="txtAddress" type="text" size=80 value="<?=$meminfo[address1]?>&nbsp;<?=$meminfo[address2]?>"></td>
</tr>

<tr>
<td>연락처</td>
<td>
<input name="txtMobile" id="txtMobile" type="text" size=12 value="<?=$meminfo[mobile]?>">
</td>
</tr>

<tr>
<td>머그잔 선택</td>
<td>
<select name="txtCupSelect1" id="txtCupSelect1" style="width:200px;height:30px;">
<option value="0">얼굴 머그잔</option>
<option value="1">1개</option> 
<option value="2">2개</option>
</select>

<select name="txtCupSelect2" id="txtCupSelect2"  style="width:200px;height:30px;">
<option value="0">로고 머그잔</option>
<option value="1">1개</option>
<option value="2">2개</option>
</select>
</td>
</tr>
</table>
</td>
</tr>  
<tr><td height="50">
<font color=red>
*이벤트 기간내 3개월 서비스 신청자는 1개<br> 
*6개월 서비스 신청자는 2개까지 신청 가능합니다.</font><br>
<font color=black>*이벤트 대상이 아닐경우 발송되지 않습니다.</font>
</td></tr>
<tr><td align="center"><input type="button" value="신청하기" style="width:200px;height:50px;" onClick="chkForm();"></td></tr>



<tr><td height="150"></td></tr>
</table>

</form>

</body>

</html>