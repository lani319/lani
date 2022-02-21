<?php

/**
 * @author 
 * @copyright 2010
 */


include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "SELECT A.mobile,A.userId,A.userName,A.userNickname FROM 201908Lectures B INNER join Member A 

ON B.uidx = A.idx

WHERE B.state IN (1,3)";


		$tmpRs=mysql_query($sql) or die(mysql_error());
		
		?>
		
		<table border=1 cellpadding=0 cellspacing=0>
		<tr>
		<td>핸드폰</td>
		<td>아이디</td>
		<td>이름</td>
		<td>필명</td>
		</tr>
		
		<?php
		
		while($rs=mysql_fetch_array($tmpRs))
		{
?>
<tr>
		<td><?=$rs[0]?></td>
		<td><?=$rs[1]?></td>
		<td><?=$rs[2]?></td>
		<td><?=$rs[3]?></td>
		</tr>
<?php		
		
		
		}
		
	

?>