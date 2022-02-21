<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$uidx = $_COOKIE[_CKE_USER_UID];


$meminfo = get_meminfo($uidx,"userId,userName,address1,address2,mobile");

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

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


function chkPrice(){
	
	var cnt1 = document.getElementById('txtCupSelect1').value;
	var cnt2 = document.getElementById('txtCupSelect2').value;
	
	var price = (cnt1*15000)+(cnt2*15000);
	
	document.getElementById('txtPrice').value = price;
	
	
}

</script>
</head>
<body>

<form name='form1' action='/502school/coffeeCupPay.php' method='POST'>
<table width=690px>
<tr>
<td>
<img src="http://www.502.co.kr/upload_file/WImgPost/2020/01/1578024688429.jpg" border=0>
</td>
</tr>
<tr>
<td>
<table width=100%>
<tr>
<td width=150px>받는사람 ::</td>
<td><input name="txtName" id="txtName" type="text" size=10 value="<?=$meminfo[userName]?>">
*주문자와 수신자가 다를 경우 수정해 주세요. 
</td>
</tr>

<tr>
<td>주소 ::</td>
<td><input name="txtAddress" id="txtAddress" type="text" size=80 value="<?=$meminfo[address1]?>&nbsp;<?=$meminfo[address2]?>">

</td>
</tr>

<tr>
<td>연락처 ::</td>
<td>
<input name="txtMobile" id="txtMobile" type="text" size=12 value="<?=$meminfo[mobile]?>">
</td>
</tr>

<tr>
<td>머그잔 선택 ::</td>
<td>
<select name="txtCupSelect1" id="txtCupSelect1" style="width:200px;height:30px;" onChange="chkPrice();">
<option value="0">사진 머그잔
<option value="0">구매안함
<option value="1">1개
<option value="2">2개
<option value="3">3개
<option value="4">4개
<option value="5">5개
<option value="6">6개
<option value="7">7개
<option value="8">8개
<option value="9">9개
<option value="10">10개
</select>
<select name="txtCupSelect2" id="txtCupSelect2" style="width:200px;height:30px;" onChange="chkPrice();">
<option value="0">로고 머그잔
<option value="0">구매안함
<option value="1">1개
<option value="2">2개
<option value="3">3개
<option value="4">4개
<option value="5">5개
<option value="6">6개
<option value="7">7개
<option value="8">8개
<option value="9">9개
<option value="10">10개
</select>
</select>
<br><font color=red>*머그잔 수량을 선택해 주세요. 
</td>
</tr>
<tr><td>가격 : </td><td><input type="text" readonly name="txtPrice" id="txtPrice" size=10 value=0>원</td></tr>
<!--
<tr>
<td>결제수단 : </td>
<td>
<input type="radio" name="chk_payType" value="bank" checked>무통장 입금
<input type="radio" name="chk_payType" value="card">신용카드결제
</td>
</tr>
-->
</table>

</td>
</tr>


<tr><td height="50"></td></tr>
<tr><td align="center"><input type="button" value="구매하기" style="width:200px;height:50px;" onClick="chkForm();"></td></tr>
<tr><td height="150"></td></tr>
</table>

</form>

</body>

</html>