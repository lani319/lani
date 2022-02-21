<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//echo $mode;

//공지사항
if($mode == "mod")
{
	$sql = "select A.*,B.writer as memName from Business_log A inner join Business_log_level B on A.writer = B.idx where A.idx=$idx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	
	$writer = $rs[memName];
	$subject = $rs[subject];
	$contents = $rs[contents];
	$regDate = $rs[regDate];
}
else if($mode == "reg")
{
	$writer = $_COOKIE["_CKE_USER_NAME"];
	$subject = "";
	$contents = "";
	$regDate = "";
}


?>

<script type="text/javascript">
function frmCheck()
{
	var f = document.form1;

	f.action = "./notice_writeOk.php";
	f.target = "invFrame";
	f.submit();
}

function goDel(idx)
{
	
}
</script>


<!-- 여기부터는 text에디터 -->
<script type="text/javascript" src="http://www.502.co.kr/lani/BusinessLog/fckeditor/fckeditor.js"></script>
	<script type="text/javascript">
 
window.onload = function()
{
	// Automatically calculates the editor base path based on the _samples directory.
	// This is usefull only for these samples. A real application should use something like this:
	// oFCKeditor.BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
	var sBasePath = "http://www.502.co.kr/lani/BusinessLog/fckeditor/"
		
	var oFCKeditor = new FCKeditor( 'FCKeditor1' ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.Height = '600';	
	oFCKeditor.ReplaceTextarea() ;
	
	
	/*			
	var oFCKeditor = new FCKeditor( 'FCKeditor2' ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.Height = '600';
	oFCKeditor.ReplaceTextarea() ;
	
	
	var oFCKeditor = new FCKeditor( 'FCKeditor3' ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.ReplaceTextarea() ;
	
	var oFCKeditor = new FCKeditor( 'FCKeditor4' ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.ReplaceTextarea() ;
	*/
}
 
	</script>

<!-- 여기까지는 text에디터 -->


<form name="form1" method="POST">
<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
<tr>
	<td colspan="2">
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td align="center"style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">작성자 :</td>
			<td><?=$writer?></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
<td width="120px" align="center" style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">제목</td>
<td valign="top" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
<input type="text" name="txtSubject" size="50" style="width:450px;border-type:thin;border-style:solid;border-color:skyblue;border-width:1px" value="<?=$subject?>"></td>
</tr>	

<tr>
<td width="120px" align="center"style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">공지사항</td>
<td valign="top"><textarea name="FCKeditor1"><?=$contents?></textarea></td>
</tr>


<tr>
<td style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff"></td>
<td align="center" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
<?php
if($mode == "reg")
{
?>
<img src="img/submit_bar.png" border="0" onclick="frmCheck();" style="cursor:hand;">
<?php
}
else 
{
?>
<img src="img/modify_bar.png" border="0" onclick="frmCheck();" style="cursor:hand;">
<?php
}
?>
</td>
</tr>
</table>

<input type="hidden" name="writer" value="<?=$_COOKIE["_CKE_USER_NICK_NAME"]?>">
<input type="hidden" name="mode" value="<?=$mode?>">
<input type="hidden" name="idx" value="<?=$idx?>">
<iframe name="invFrame" width="600" height="0"></iframe>
</form>