<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//id,pwd를 파라미터로 받는다

$sql = "select A.*,B.userName,userNickname from 502SNS A inner join Member B on A.memIdx=B.idx order by idx desc limit 0,100";



$tmpRs = mysql_query($sql) or die(mysql_error());


?>

<html>
<head></head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="580">
<?php
while($rs = mysql_fetch_array($tmpRs))
{
?>
    <tr bgcolor="olive" style="color: white;">
        <td><?=$rs["userNickname"]?></td>
        <td><?=$rs["regDate"]?></td>
    </tr>
    <tr>
    <td colspan="2">
        <?=$rs[article]?>
    </td>
    </tr>
    
<?php
}
?>
</table>
</body>
</html>