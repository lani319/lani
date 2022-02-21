<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//id,pwd를 파라미터로 받는다

$sql = "select A.*,B.userName,userNickname from 502SNS A inner join Member B on A.memIdx=B.idx where A.idx=$param";



$tmpRs = mysql_query($sql) or die(mysql_error());

$rs = mysql_fetch_array($tmpRs);

?>

<html>
<head></head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="600">
<tr bgcolor="olive">
<td><?=$rs["userNickname"]?></td>
<td><?=$rs["regDate"]?></td>
</tr>
<tr>
<td colspan="2">
<?=$rs[article]?>
</td>
</tr>
</table>
</body>
</html>