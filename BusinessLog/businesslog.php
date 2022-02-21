<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header3.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<br>
<table width="1100" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="155px" valign="top">
<?php include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/menu_left.php"; ?>
</td>
<td>

<?php 

if($mode == 'view')
{
	include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/businesslog_view.php";
}
else if($mode == "mod" || $mode == "reg")
{
	include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/businesslog_write.php";
}
else if($mode == "del")
{
	$sql = "delete from Business_log where writer=$idx and left(targetDate,10) = '$targetDate'";
	
	mysql_query($sql);
	
	echo "<script>alert('삭제되었습니다.');location.href='/lani/BusinessLog/businesslog.php?idx=$idx'</script>";
}
else if($mode == "list")
{
	
		//$sql = "select * from Business_list where charge=$idx and status='R'";
		$sql = "select A.contents,B.writer from Business_list A inner join Business_log_level B on A.charge=B.idx where charge=$idx and status='R'";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		$orderReport = $rs[contents];
?>
		<table cellpadding="0" cellspacing="0" width="100%" height="15px" border="0">		
		<tr>
		<td align="right">
		<img src="/admin/images/icon_location.gif"> 게시물관리 > 직원업무일지 > <?=$rs[writer]?>
		</td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" width="100%" height="150px" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
		<tr>
		<td width="120px"align="center" style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">서동훈 부장 지시사항</td>
		<td style="padding-left:15px;" style="padding-left:15px;background-color:#FFFFFF">
		<div style="height: 150px; overflow-y: scroll; scrollbar-arrow-color: 
		blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color: #888888">
		<?=$orderReport?>
		</div>
		</td>
		</tr>
		</table>
		<br>
<?php
}
else if($mode == "Biz")
{
		//$sql = "select A.contents,B.writer from Business_list A inner join Business_log_level B on A.charge=B.idx where charge=$idx and status='R'";
		$sql = "select * from Business_list where flag='B' and status='R'";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		$orderReport = $rs[contents];
		$msg = "<font color='red'><b>*현재 회사 차원에서 진행 중인 업무내역입니다.</b></font><br><br>";
		$orderReport = $msg.$orderReport;
?>
		<table cellpadding="0" cellspacing="0" width="100%" height="15px" border="0">		
		<tr>
		<td align="right">
		
		<img src="/admin/images/icon_location.gif"> 게시물관리 > 직원업무일지 > 회사 진행 업무
		</td>
		</tr>
		</table>
		<table cellpadding="0" cellspacing="0" width="100%" height="450px" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
		<tr>
		<td width="120px"align="center" style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">회사진행업무</td>
		<td style="padding-left:15px;" style="padding-left:15px;background-color:#FFFFFF">
		<div style="height: 450px; overflow-y: scroll; scrollbar-arrow-color: 
		blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color: #888888">
		<?=$orderReport?>
		</div>
		</td>
		</tr>
		</table>
		<br>
<?php		
}
else 
{	
		$sql = "select A.contents,B.writer from Business_list A inner join Business_log_level B on A.charge=B.idx where status='R'";
		$tmpRs = mysql_query($sql);
		while($rs = mysql_fetch_array($tmpRs))
		{
			if($rs[contents]!="")
			{
				$orderReport = $orderReport."<font color='blue'>".$rs[writer]."</font><font color='red'>".$rs[contents]."</font><br/>";	
			}
			else 
			{
				$orderReport = $orderReport."<font color='blue'>".$rs[writer]."</font></br>지시사항이 없습니다.</br></br>";					
			}
			
		}
		?>
		<table cellpadding="0" cellspacing="0" width="100%" height="15px" border="0">		
		<tr>
		<td align="right">
		<img src="/admin/images/icon_location.gif"> 게시물관리 > 직원업무일지 > <?=$rs[writer]?>
		</td>
		</tr>
		</table>				
		<table cellpadding="0" cellspacing="0" width="100%" height="150px" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
	<tr>
	<td width="120px"align="center" style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">서동훈 부장 지시사항</td>
	<td style="padding-left:15px;background-color:#FFFFFF">
	<div style="height: 350px; overflow-y: scroll; scrollbar-arrow-color: 
	blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color: 
		#888888">
		<?=$orderReport?>
		</div>
		</td>
		</tr>
		</table>
		<br>
		<?php
}
	?>
	
	<?php
	if($mode != "Biz")
	{
		include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/businesslog_list.php";
	}


?>
</td>
</tr>
</table>