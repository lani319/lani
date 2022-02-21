<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
//mode=view&idx=9&regDate=2010-06-23

$sql = "select A.*,B.writer from Business_log A inner join Business_log_level B on A.writer = B.idx where A.idx=$idx";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
$logMemIdx = $rs[memIdx];
?>


<script type="text/javascript">
function goList()
{
	location.href = "./notice.php";
}

function goDel()
{
	location.href = "./notice.php?mode=del&idx=<?=$idx?>";
}

function goModify()
{
	location.href = "./notice.php?mode=mod&idx=<?=$idx?>";
}
</script>


<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#FFFFFF">
<tr>
<td width="150px" height="25px" align="center" style="border-right:solid;border-bottom:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">제목</td>
<td valign="center" align="left" style="border-bottom:solid;border-type:thin;border-width:1px;border-color:skyblue;padding-left:15px"><?=$rs[subject]?></td>
</tr>
<tr>
<td height="500px" align="center" style="border-right:solid;border-bottom:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e6e6fa">공지내용</td>
<td valign="top" style="border-bottom:solid;border-type:thin;border-width:1px;borderf-color:skyblue;padding-left:15px;padding-top:15px;"><?=$rs[contents]?></td>
</tr>

<tr>
<td colspan="2" align="right">
<?php
$memIdx = $_COOKIE["_CKE_USER_UID"];

if($logMemIdx == $memIdx || $memIdx = "39115")
{
?>
<img src="img/mod.png" border="0" onclick="goModify();" style="cursor:hand">
<img src="img/del.png" border="0" onclick="goDel();" style="cursor:hand">
<?php
}
?>
<img src="img/list.png" border="0" onclick="goList();" style="cursor:hand">
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%" border="1">		
<tr>
<td>
</td>
</tr>
</table>