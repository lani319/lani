<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$_HOST_NAME='211.172.241.7';
$_USER_NAME='co502';
$_DB='co502';
$_PASSWORD='@%^*&#';

$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$sql = "SELECT A.userNickname,B.* from Member A inner join commentST B on A.idx = B.uidx
	
	where B.bidx = $idx

	ORDER BY B.idx ASC
	
	";

$tmpRs = mysql_query($sql);
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
while($rs = mysql_fetch_array($tmpRs))
{
	?>
	<tr>
	<td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan="2"><font size="3"><?=$rs[content]?></font></td></tr>
	<tr><td width="20%"><font color="Gray" size="2"><?=$rs[userNickname]?></font></td><td><font color="Gray" size="2"><?=$rs[signdate]?></font></td></tr>
	</table>
	</td>
	</tr>
	<tr><td height="1px" bgcolor="Black"></td></tr>
	<?php
}
?>
	
</table>