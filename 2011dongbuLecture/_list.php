<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


?>
<html>
<head>
<script type="text/javascript">
function getExcel()
{
	location.href = 'getExcel.php';
}

function del()
{
	var chk = document.getElementsByName("chk[]");
	
	var idx = "";
	
	var i = 0;	
	for(i = 0 ; i < chk.length ; i++)
	{
		if(chk[i].checked)
		{
			idx += chk[i].value + ",";
		}
	}
	if(idx == "")
	{
		alert('삭제할 데이터를 선택 해 주세요');
		return;
	}
	
	document.getElementById("memIdx").value = idx;
	document.form1.submit();
	
}
</script>
</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="900" border="1">
<tr><td colspan="10" height="5px" align="right">
<input type="button" value="EXCEL" onclick="getExcel();">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="DEL" onclick="del();">

</td></tr>
<tr><td colspan="10" height="5px" align="left"><b>회원</b></td></tr>
<tr align="center"><!--  회원 -->
<td></td>
	<td bgcolor="gray" style="color:FFFFFF;">순번</td>
	<td bgcolor="gray" style="color:FFFFFF;">이름(필명)</td>
	<td bgcolor="gray" style="color:FFFFFF;">아이디</td>
	<td bgcolor="gray" style="color:FFFFFF;">연락처</td>
	<td bgcolor="gray" style="color:FFFFFF;">신청일</td>
	<td bgcolor="gray" style="color:FFFFFF;">참석여부</td>	
</tr>
<?php
$query = "select A.userName,A.userNickname,A.mobile,A.userId,B.regDate,B.idx from Member A inner join 2011dongbuLecture B on A.userId = B.memID order by B.regDate ASC";
$tmpRs = mysql_query($query);
$cnt = 1;
while($rs = mysql_fetch_array($tmpRs))
{
	$mName = $rs["userName"];
	$mNickName = $rs["userNickname"];
	$mMobile = $rs["mobile"];
	$mId = $rs["userId"];
	$mRegDate = $rs["regDate"];
?>
<tr align="center"><!--  회원 -->
	<td><input type="checkbox" name="chk[]" value="<?=$rs[idx]?>"></td>
	<td><?=$cnt?></td>
	<td><?=$mName?>     [<?=$mNickName?>]</td>
	<td><?=$mId?></td>
	<td><?=$mMobile?></td>
	<td><?=$mRegDate?></td>
	<td></td>	
</tr>
<tr><td colspan="10" height="5px"></td></tr>
<?php
	$cnt++;
}
?>
<tr><td colspan="10" height="5px" bgcolor="Gray"></td></tr>
</table>

<br>
<br><br><br><br><br><br>

<form name="form1" method="POST" action="delOK.php" target="invFrame">
<input type="hidden" name="memIdx" id="memIdx">
</form>

</body>

<iframe name="invFrame" width="600" height="400"></iframe>
</html>