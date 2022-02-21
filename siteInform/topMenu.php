<?php
	$bgcolor = "#861050";
	$bgcolor2 = "#d7d7d7";
?>
<html>
<style type="text/css">
body
{
	background-color:<?=$bgcolor2?>;
}
</style>
<script type="text/javascript">
function changeImg(id,name)
{
	document.getElementById(id).src = "images/"+name;
}

</script>
<div style="position:absolute;top:0px;left:0px;width:1027px;height:60px;background-color:<?=$bgcolor?>">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr valign="bottom">
	<td><a href="profile.html" target="_top"><img id="1"  src="images/topMenuGeneral_10.gif" onmouseover="changeImg(this.id,'topMenuSelect_10.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_10.gif');" style="cursor:hand;" border="0"></a></td>
	<td><a href="stockInfo.html" target="_top"><img id="2"  src="images/topMenuGeneral_11.gif" onmouseover="changeImg(this.id,'topMenuSelect_11.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_11.gif');" style="cursor:hand;" border="0"></a></td>
	<td><a href="stockqna.html" target="_top"><img id="3"  src="images/topMenuGeneral_12.gif" onmouseover="changeImg(this.id,'topMenuSelect_12.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_12.gif');" style="cursor:hand;" border="0"></a></td>
	<td><a href="sarang.html" target="_top"><img id="4"  src="images/topMenuGeneral_13.gif" onmouseover="changeImg(this.id,'topMenuSelect_13.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_13.gif');" style="cursor:hand;" border="0"></a></td>
	<td><a href="502school.html" target="_top"><img id="5"  src="images/topMenuGeneral_14.gif" onmouseover="changeImg(this.id,'topMenuSelect_14.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_14.gif');" style="cursor:hand;" border="0"></a></td>
	<td><a href="customer.html" target="_top"><img id="6"  src="images/topMenuGeneral_15.gif" onmouseover="changeImg(this.id,'topMenuSelect_15.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_15.gif');" style="cursor:hand;" border="0"></a></td>
	<td><a href="mypage.html" target="_top"><img id="7"  src="images/topMenuGeneral_16.gif" onmouseover="changeImg(this.id,'topMenuSelect_16.gif');" onmouseout="changeImg(this.id,'topMenuGeneral_16.gif');" style="cursor:hand;" border="0"></a></td>

</tr>
</table>
</div>