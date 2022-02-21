<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//echo $mode;

if($mode=="mod") //수정이면
{
	//지시사항
	$sql = "select * from Business_list where charge=$idx and status='R'";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$orderReport = $rs[contents];
	
	$sql = "select * from Business_log where writer=$idx and left(targetDate,10) = '$targetDate' and flag=0"; //금일 실시사항
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$todayReport = $rs[contents];
}
else 
{
	//
	
	$mode = "reg";
	$sql = "select * from Business_list where charge=(select idx from Business_log_level where writer='$userNickname') and status='R'";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$orderReport = $rs[contents];
	$todayReport = "<font color='blue'><b>*금일실시사항</b></font><br><br><br><br><br><br><font color='blue'><b>*진행사항</b></font><br><br><br><br><br><br><font color='blue'><b>*내일예정사항</b></font><br><br><br><br><br><br>";
}

?>
 <link type="text/css" href="/lani/BusinessLog/jquery/development-bundle/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="./jquery/development-bundle/jquery-1.4.2.js"></script>
<script type="text/javascript" src="./jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="./jquery/development-bundle/ui/jquery.effects.core.js"></script>
<script type="text/javascript" src="./jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>

<SCRIPT type=text/javascript>     
 $(function() 
 { 
     $("#datepicker").datepicker({showOn: 'button', buttonImage: '/lani/BusinessLog/jquery/development-bundle/demos/datepicker/images/calendar.gif', buttonImageOnly: true, changeMonth: true, changeYear: true, showMonthAfterYear:false}); 
     $('#datepicker').datepicker('option', {dateFormat: 'yy-mm-dd'});      
     $("#anim").change(function() { $('#datepicker').datepicker('option', {showAnim: $(this).val()}); });
 }); 
 </SCRIPT> 


<script type="text/javascript">
var f = document.form1;

function frmCheck()
{
	var f = document.form1;
	/*
	if(f.FCKeditor1.value == "")
	{
		alert('지시사항을 작성 해 주세요');
		f.txt01.focus();
		return;
	}
	*/
	if(f.FCKeditor2.value == "")
	{
		alert('업무일지를 작성 해 주세요');
		f.txt02.focus();
		return;
	}
	/*
	if(f.FCKeditor3.value == "")
	{
		alert('업무 진행사항을 작성 해 주세요');
		f.txt03.focus();
		return;
	}
	if(f.FCKeditor4.value == "")
	{
		alert('내일 예정사항을 작성 해 주세요');
		f.txt04.focus();
		return;
	}
	*/
	f.action = "./businesslog_writeOk.php";
	f.target = "invFrame";
	f.submit();
	
}

function setColor(name)
{
	document.getElementById("txt01").style.background.color = "red";
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
	oFCKeditor.Height = '250';	
	oFCKeditor.ReplaceTextarea() ;
	
	
	
	var oFCKeditor = new FCKeditor( 'FCKeditor2' ) ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.Height = '600';
	oFCKeditor.ReplaceTextarea() ;
	
	/*			
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

<script type="text/javascript">
function getMember(status)
{
	if(status == true)
	{
		var win = window.open('./inc/businesslog_member.php','','width=400,height=250');
	}
	else
	{
		document.form1.log_target.value = "";
	}
}
</script>


<form name="form1" method="POST">
<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
<tr>
	<td colspan="2">	
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
			<td align="center" style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">작성날짜 :</td>
			<td >
			<INPUT id=datepicker type=text name="regDate">&nbsp;&nbsp;&nbsp; *달력을 눌러  주세요
			</td>
			<td align="center" style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">작성자 :</td>
			<td align="center"><?=$_COOKIE["_CKE_USER_NAME"]?></td>
		</tr>
		</table>	
	</td>
</tr>
<tr>
<td width="120px" align="center" style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">지시사항</td>
<td valign="top" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff"><textarea name="FCKeditor1"><?=$orderReport?></textarea></td>
</tr>


<tr>
<td align="center" style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">업무일지</td>
<td valign="top" height="600"><textarea name="FCKeditor2" style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff"><?=$todayReport?>  </textarea> </td>
</tr>



<!--
<tr>
<td align="center" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;">
&nbsp;
</td>
<td align="left" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;">
<input type="checkbox" onclick="getMember(this.checked)">업무보고 대상자 설정 (미 설정시 전체공개)
</td>
-->
<tr>
<td align="center" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;">
&nbsp;
</td>
<td align="center" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;">
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

<input type="hidden" name="log_target" value="">

<iframe name="invFrame" width="600" height="0"></iframe>
</form>