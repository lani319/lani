

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
��û�ı�
�ı� ���� + 2017����� ��
-------------
*/


?>

<table cellpadding=0 cellspacing=0 border=1>
<tr>
<td>����</td>
<td>�ۼ��� ���̵�</td>
<td>�̸�</td>
<td>����</td>
<td>����</td>
<td>��¥</td>
</tr>

<?php

$sql = "SELECT userId,NAME,subject,content,regdate from NaraBoard_broadafter

where regdate > '2015-01-01'

ORDER BY idx DESC"
;

$tmpRs = mysql_query($sql);

$cnt=1;

while ($rs = mysql_fetch_array($tmpRs)) {
	
	?>
	<tr>
	<td><?=$cnt?></td>
	<td><?=$rs[0]?></td>
	<td><?=$rs[1]?></td>
	<td><?=$rs[2]?></td>
	<td><?=$rs[3]?></td>
	<td><?=$rs[4]?></td>
	</tr>
	<?php
	$cnt = $cnt+1;
	
}


?>
