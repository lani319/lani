<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<link rel="stylesheet" type="text/css" href="/css/502style.css">



<script type="text/javascript">
function setMember()
{
	var x=document.getElementsByName("chkMember");
	var tstr = "";	  
	  for(i=0 ; i<x.length;i++)
	  {
	  	if(x[i].checked == true)
	  	{
	  		tstr = tstr+x[i].value+',';
	  	}
	  }
	  tstr = tstr.substring(0,tstr.length-1);
	  opener.form1.log_target.value = tstr;
	  self.close();
}
</script>

<table width="280px" cellpadding="0" cellspacing="0">
<tr><td align="center">업무보고 대상자를 지정 해 주세요</td></tr>
<tr><td align="center" height="15px"></td></tr>
<tr><td>
<?php
$sql = "select writer,idx from Business_log_level";
$tmpRs = mysql_query($sql);
$cnt=1;
while($rs = mysql_fetch_array($tmpRs))
{
	echo "<input type='checkBox' name='chkMember' value='$rs[idx]'>$rs[writer]&nbsp;&nbsp;";
	if(($cnt % 4) == 0)
	{
		echo "<br><br>";
	}
	$cnt++;
}
?>
</td></tr>
<tr><td align="center" height="15px"></td></tr>
<tr>
<td align="center">
<img src="../img/apply.png" border="0" onclick="setMember();" style="cursor:hand;">
</td>
</tr>
</table>