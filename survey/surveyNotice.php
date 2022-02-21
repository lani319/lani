<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$userID = $_COOKIE["_CKE_USER_ID"];

$sql = "select count(idx) as cnt from 2011Survey where userId = '$userID'";
$tmpRs = mysql_query($sql);
$rs= mysql_fetch_array($tmpRs);
if($rs[cnt] != 0)
{
	echo "<script>alert('이미 응모하셨습니다. 당첨자는 3월 7일 발표됩니다.');location.href='/index.html';</script>";
	exit;
}

?>

<html>
<script>
function goSurvey()
{
	location.href='/lani/survey/2011_survey.html';
}
</script>

<body style="margin-left:0px;margin-top:0px">
<table cellpadding="0" cellspacing="0" border="0" style="margin-left:0px;margin-top:0px;" width="693" height="937">
	<tr>
		<td style="margin-top:0px;margin-left:0px">
			<img src="/lani/survey/img/popSurvey.jpg" border="0" style="cursor:hand;" onclick="goSurvey();">
		</td>
	</tr>	
</table>
</body>
</html>

