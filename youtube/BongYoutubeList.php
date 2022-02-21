<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>



<table width="690" height="2000" background="http://www.502.co.kr/upload_file/WImgPost/2019/05/1559085452511.jpg" border="0" cellpadding="0"  cellspacing="0">
<tbody><tr height="600">
<td></td>
</tr>
<tr>
<td valign="top">

<table width="685"  border="0" cellpadding="0" cellspacing="0" src="" cessspacing="0">
<tr>
<td width="30px"></td>
<td width="100px">DATE</td>
<td>NAME</td>
<td>URL</td>
</tr>

<?php

$sql = "select left(date,10) as date,name,url from YoutubeList order by idx desc limit 30";
$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs)){
	
	
	?>
	
	<tr height="30px"> 
	<td></td>
	<td><?=$rs[0]?></td>
	<td><?=$rs[1]?></td>
	<td><a href="<?=$rs[2]?>" target="_blank"><?=$rs[2]?></a></td>
	<tr>
	
	<?php
	
	
}

?>


</table>


</td>
</tr>
</tbody></table>