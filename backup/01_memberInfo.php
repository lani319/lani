<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "desc Member";
$tmpRs = mysql_query($sql);

?>
회원정보<br><br>
<table cellpadding="0" cellspacing="0" border="1">

<tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)) {
?>
<td><?=$rs[0]?></td>	 
<?php
}
?>
</tr>
<?php

$sql = "select * from Member order by idx ASC limit 8001,2000"; //8822박평길

$tmpRs = mysql_query($sql);


while ($rs = mysql_fetch_array($tmpRs)) {
 $cols = mysql_num_fields($tmpRs);
 ?>
 <tr>
 <?php
 for($i=0 ; $i<$cols; $i++){
	 ?>
	 	 
<td><?=$rs[$i]?></td>	 
	 <?php
 }
	?>
</tr>
	<?php
}
?>
</table>