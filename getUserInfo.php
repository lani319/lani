<?php


include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$sql = " 

select userId,userName,userNickname from Member

where userId in (

'mic681',
'soiiman',
'haha0104',
'whbyun2',
'darkmoonjs',
'haha0104',
'mjlyrical ',
'521213',
'황실',
'톨스토이',
'gnious',
'newdryun',
'neoartmaker',
'daewoongma',
'bak2suk',
'seung000',
'Kksi1130',
'faithjin',
'ksh9630',
'Kipanl',
'bicqm01',
'gnrlsh',
'jm0268',
'a0254798',
'whbyun2',
'jameskims',
'cjh199',
'moonjs3927',
'wto001',
'Youngjk03',
'Youngjk03',
'mjlyrical ',
'ptc016',
'ha0302',
'tery1993',
'sis4640 ',
'bongo1899',
'ilandee33',
'ohs6310',
'ohs6310',
'zeve78',
'enrico11',
'jjsk844',
'th8116178',
'dskwjw',
'fosran',
'zenxpert',
'bizroom'
)

";


$tmpRs = mysql_query($sql);


?>

<table cellpadding="0" cellspacing="0" border="1">
<?php

while ($rs = mysql_fetch_array($tmpRs)) {

	?>
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
</tr>	
	<?php
}
?>
</table>