<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//echo $mode;

	//���û���
if($mode!="reg")	
{
	if($flag == "P") //���ξ���
	{
		$sql = "select * from Business_list where charge=$idx and status='R'";
	}
	else //�������
	{
		$sql = "select * from Business_list where flag='B' and status='R'";
	}
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		$orderReport = $rs[contents];
	
}
else  //���
{
	if($flag == 'P') //���ξ���
	{
		$orderReport = "*�ű� �����ڰ� �������� '�������� ���' ����� ��� �� �ּ��� <br/>";
	}
	else  //�������
	{
		$orderReport = "";
	}
}
?>

<script type="text/javascript">
function frmCheck()
{
	var f = document.form1;

	f.action = "./businesslist_writeOk.php";
	f.target = "invFrame";
	f.submit();
}

function goDel(idx)
{
	
}
</script>


<!-- ������ʹ� text������ -->
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

<!-- ��������� text������ -->


<form name="form1" method="POST">
<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0" style="border-style:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
<tr>
	<td colspan="2">
		<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<tr>
		<?php
		if($flag =="P") //���ξ���
		{
		?>
			<td align="center"style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff"> ���� �����:</td>
			<td style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
			<select name="selCharge" style="width:150px">
			<?php
			if($mode=="reg")
			{
				$sql = "select idx,writer from Business_log_level where level not in('P','R') and idx not in (select charge from Business_list)";
			}
			else 
			{
				$sql = "select idx,writer from Business_log_level where level not in('P','R')";
			}
			$tmpRs = mysql_query($sql);
			while ($rs = mysql_fetch_array($tmpRs)) 
			{
				if($idx==$rs[idx])
				{
					echo "<option value='$rs[idx]' selected>$rs[writer]</option>";
				}
				else 
				{
					echo "<option value='$rs[idx]'>$rs[writer]</option>";
				}
			}
			?>
			</select>
			</td>
			<?php
		}
		else if($flag=="B") //�������
		{
			?>
			<input type="hidden" name="selCharge" value="502">
			<?php
		}
			?>
			<td align="center"style="border-right:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">�ۼ��� :</td>
			<td><?=$_COOKIE["_CKE_USER_NAME"]?></td>
		</tr>
		</table>
	</td>
</tr>
<?php
if($flag == "N")//��������
{
?>
<tr>
<td width="120px" align="center" style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">����</td>
<td valign="top" style="border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">
<input type="text" name="txtSubject" size="50" style="width:450px;border-type:thin;border-style:solid;border-color:skyblue;border-width:1px"></td>
</tr>	
<?php
}
?>
<tr>
<td width="120px" align="center"style="border-right:solid;border-top:solid;border-type:thin;border-width:1px;border-color:skyblue;background-color:#e0ffff">���û���</td>
<td valign="top"><textarea name="FCKeditor1"><?=$orderReport?></textarea></td>
</tr>


<!--
<tr>
<td align="center">��������</td>
<td valign="top" height="600"><textarea name="FCKeditor2"><?=$orderReport?>  </textarea> </td>
</tr>


<tr>
<td>���� �������</td>
<td>
<textarea name="FCKeditor3" rows="10" cols="80" style="width: 100%; height: 300px">  </textarea>
</td>
</tr>
<tr>
<td>���� ��������</td>
<td><textarea name="FCKeditor4" rows="10" cols="80" style="width: 100%; height: 300px">  </textarea></td>
</tr>
-->
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
<input type="hidden" name="flag" value="<?=$flag?>">
<iframe name="invFrame" width="600" height="0"></iframe>
</form>