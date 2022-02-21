<html>
<head> 
<meta charset="UTF-8">
</head>
<body>
<form name="frmMain" target="invframe" method="post" action="SenMemberServiceAdd_ok.php">
<table class="type03">
<tr>
<td> 이름 </td>
<td> <input type='text' name='txtUserName' value="senTestName"></td>
</tr>
<tr>
<td> 아이디 </td>
<td> <input type='text' name='txtUserId' value="senTestId"></td>
</tr>
<tr>
<td> 필명 </td>
<td> <input type='text' name='txtNickName' value="senTestNickName"></td>
</tr>
<tr>
<td> 핸드폰번호 </td>
<td> 
<input type='text' name='mobile1'  value="010">-
<input type='text' name='mobile2'  value="2223">-
<input type='text' name='mobile3' value="4278">
</td>
</tr>
<tr>
<td> 상품 구분 </td>
<td> 
<select name='type'>
<option value="">선택</option>
<option value="1" selected>통합방송</option>
<option value="2">현물전용SMS</option>
<option value="3">파생전용SMS</option>
</select>
</td>
</tr>
<tr>
<td> 서비스기간 </td>
<td> 
<input type='text' name='serviceDay' value="30">
</td>
</tr>

<tr>
<td colspan=5> 
<a href="#" onclick="submitForm();" class="btn btn-concrete">확 인</a>
</td>
</tr>
</table>	
</form>
<script type="text/javascript">
function submitForm(){
		document.frmMain.submit();		
}
</script>


<iframe name="invframe"  width="100%" height="100%" frameborder=0>

</iframe>
</body>
</html>