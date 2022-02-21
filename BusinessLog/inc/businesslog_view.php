<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
//mode=view&idx=9&regDate=2010-06-23

$sql = "select * from Business_list where charge=$idx and status = 'R'"; //R = running , P = Personal(개인지시사항)
$tmpRs = mysql_query($sql);
$orderList = "";
while($rs = mysql_fetch_array($tmpRs))
{
	$orderList = $orderList.nl2br($rs[contents]);
}

if($orderList=="")
{
	$orderList = "지시사항이 없습니다.";
}
$targetDate = substr($targetDate,0,10);

//echo $parentIdx;

$sql = "select A.*,B.writer from Business_log A inner join Business_log_level B on A.writer = B.idx where left(A.targetDate,10) = '$targetDate' and A.writer=$idx and A.flag = '0'";
$tmpRs = mysql_query($sql);
//echo $sql;
while($rs = mysql_fetch_array($tmpRs))
{
	$todayList = $todayList.$rs[contents]."<br>";
	$writer = $rs[writer];
	$regDate = $rs[regDate];
	$logMemIdx = $rs[memIdx];
}
?>


<script type="text/javascript">
function goList()
{
	location.href = "./businesslog.php?mode=list&idx=<?=$idx?>";
}

function goDel()
{
	location.href = "./businesslog.php?mode=del&idx=<?=$idx?>&targetDate=<?=$targetDate?>";
}

function goModify()
{
	location.href = "./businesslog.php?mode=mod&idx=<?=$idx?>&targetDate=<?=$targetDate?>";
}
</script>
<table cellpadding="0" cellspacing="0" width="100%" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">		
		<tr>
			<td align="center" style="border-right:solid;border-type:thin;border-width:1px;borderf-color:skyblue;">업무일지 날짜 :</td>
			<td align="center" bgcolor="FFFFFF"style="border-right:solid;border-type:thin;border-width:1px;borderf-color:skyblue;"><?=$targetDate?></td>
			<td align="center"style="border-right:solid;border-type:thin;border-width:1px;borderf-color:skyblue;">작성자 :</td>
			<td align="center" bgcolor="FFFFFF" style="border-right:solid;border-type:thin;border-width:1px;borderf-color:skyblue;"><?=$writer?></td>
			<td  align="center" style="border-right:solid;border-type:thin;border-width:1px;borderf-color:skyblue;">작성날짜 :</td>
			<td align="center" bgcolor="FFFFFF"><?=$regDate?></td>
		</tr>
</table>
		<br>
<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#FFFFFF">
<tr>
<td width="150px" height="200px" align="center" style="border-right:solid;border-bottom:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">지시사항</td>
<td valign="center" align="left" style="border-bottom:solid;border-type:thin;border-width:1px;border-color:skyblue;padding-left:15px"><?=$orderList?></td>
</tr>
<tr>
<td height="500px" align="center" style="border-right:solid;border-bottom:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e6e6fa">업무일지</td>
<td valign="top" style="border-bottom:solid;border-type:thin;border-width:1px;borderf-color:skyblue;padding-left:15px;padding-top:15px;"><?=$todayList?></td>
</tr>

<tr>
<td colspan="2" align="right">
<?php
$memIdx = $_COOKIE["_CKE_USER_UID"];

if($logMemIdx == $memIdx)
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
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
<iframe name="invReply" width="900" height="450" frameborder="0" src="/lani/BusinessLog/reply.php?parentIdx=<?=$parentIdx?>">
</iframe>
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%" border="0">		
<tr>
<td>
<?php //include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/businesslog_list_sub.php"; ?>
</td>
</tr>
</table>