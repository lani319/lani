<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//id,pwd를 파라미터로 받는다

$memID = $MemberID;
$memPwd = $MemberPWD;

$sql = "select count(idx) as cnt from Member where userId='$memID' and userPass = '$memPwd' and memType=1 and gradeLevel=1";

//http://www.502.co.kr/lani/502SNS/loginCheck.php?MemberID=lani319&MemberPWD=fksl4278

$tmpRs = mysql_query($sql) or die(mysql_error());


$result = mysql_fetch_array($tmpRs);


if ($result["cnt"] == 1)
{
	echo "TRUE";
}
else
{
	echo "FALSE";
}

exit;
?>