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
	include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/notice_view.php";
}
else if($mode == "mod" || $mode == "reg")
{
	include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/notice_write.php";
}
else if($mode == "del")
{
	$sql = "delete from Business_log where idx=$idx";
	
	mysql_query($sql);
	
	echo "<script>alert('�����Ǿ����ϴ�.');location.href='/lani/BusinessLog/notice.php?idx=$idx'</script>";
}
else 
{	
?>
		<table cellpadding="0" cellspacing="0" width="100%" height="15px" border="0">		
		<tr>
		<td align="right">
		<img src="/admin/images/icon_location.gif"> ����Ʈ���� > ����������� > ���� ��������
		</td>
		</tr>
		</table>	
		<?php
}

		include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/notice_list.php";
?>
</td>
</tr>
</table>