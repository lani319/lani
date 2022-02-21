<link rel="stylesheet" type="text/css" href="/css/502style.css">
<table width="150px" cellpadding="0" cellspacing="0" border="0">
<tr></tr>
<td valign="top"><img src="/admin/images/icon_cyan.gif">&nbsp;&nbsp;<a href="./notice.php">직원 공지사항</td>
</tr>
<tr>
<td valign="bottom"><img src="/admin/images/icon_cyan.gif"><a href="./businesslog.php?mode=all">&nbsp;&nbsp;개인별 업무</a></td>
</tr>
<tr>
<td valign="top" style="padding-left:10px;">
<?php
$sql = "select idx,writer,level from Business_log_level where idx >=4";
$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs))
{
?>
<li><a href='./businesslog.php?mode=list&idx=<?=$rs[idx]?>'>
<?php
if($idx==$rs[idx])
{
	echo "<font color='green'><b>".$rs[writer]."</b></font>";
}
else 
{
	echo $rs[writer];
}
?>
</a></li>
<?php

}
?>
</td>
</tr>
<?php
if($_COOKIE["_CKE_USER_ID"] == "seodh0070" || $_COOKIE["_CKE_USER_ID"] == "ayh319")
{
?>
<tr>
<td valign="bottom" align="left"><img src="/admin/images/icon_cyan.gif" border="0">&nbsp;&nbsp;<a href="./businesslist.php?mode=list&flag=P">개인별 업무관리</a></td>
</tr>

<tr>
<?php
}
?>

<tr>
<td valign="bottom" align="left"><img src="/admin/images/icon_cyan.gif" border="0">&nbsp;&nbsp;<a href="./guide.php">시스템 이용안내</a></td>
</tr>

</table>