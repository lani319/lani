<?php
/*
종목 이론적 적정주가 가져오기
갱신일 : 2013 10 10
갱신자 : 어윤학
기준일 : 데이터는 2013 10 7일 종가기준 데이터. 
*/
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
검색 결과를 보여주는 기능
*/

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$paramJongmok = $jongmokName;
$type = "코스피";

?>
<html>
<title>적정주가 가져오기</title>
<head>
<script type="text/javascript">
function getValue()
{
	param = document.getElementById("jongmokName").value;
	url = "http://www.502.co.kr/lani/jongmokValueBong.php?jongmokName="+param;
	location.href = url;
}

function window::onload() {
   document.getElementById('jongmokName').focus();
}
</script>
</head>
<body> 
종목코드 또는 종목이름 : <input type="text" size="20" name="jongmokName" id="jongmokName"><input type = "submit" onclick="getValue();" value="검색" size="15" onkeydown="javascript:if(event.keyCode==13){getValue();}">

<?php
if ($paramJongmok!=null)
{
	$sql = "select * from jongmokValue where code like '%$paramJongmok' or name like '$paramJongmok%' order by type DESC";
	$tmpRs = mysql_query($sql);
	
?>
<table border="0" cellpadding="0" cellspacing="0" width="600px">
<tr align="center" bgcolor="skyblue">
<td width="150px">종목명</td>
<td width="100px">종목코드</td>
<td>적정주가</td>
<td width="80px">구분</td>
</tr>
	
<?php
	while($rs = mysql_fetch_array($tmpRs))
	{
	
?>
<tr align="center">
<td><?=$rs[2]?></td>
<td><?=$rs[1]?></td>
<td><?=number_format($rs[3])?></td>
<td><?=$rs['type']?></td></tr>
<tr><td height="1" colspan="10" bgcolor="skyblue"></td></tr>
			
<?php
	}
}
?>
<tr><td colspan="10">*2013년 10월 10일 기준 적정주가 입니다.<br>신규종목은 어윤학에게 알려주세요. </td></tr>
</table>
</body>
</html>