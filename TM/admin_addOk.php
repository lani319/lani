<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


echo $txtUserName;
echo "<br>";
echo $txtUserID;
echo "<br>";
echo $txtUserPassword;
echo "<br>";

$sql = "insert into TM_admin(adminName,adminID,adminPassword,regDate,userCnt) values('$txtUserName','$txtUserID','$txtUserPassword',now(),0)";

mysql_query($sql);


?>

<script>
alert('등록되었습니다.');
parent.top.location.href = "sub01.html?mode=list";
</script>