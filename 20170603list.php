<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "select A.*,B.userNickName,B.gradeLevel,B.signDate,B.userID, B.mobile,B.userName from Member B inner join lecture_20170603 A on B.idx = A.mem_idx

 order by B.userName ASC

";

	//echo $sql;


	$result=mysql_query($sql);
	$cnt = 0;
	?>
	<table border=1>
	<tr>
	<td>
	순번
	</td>
	<td>
	이름
	</td>
	<td>
	필명
	</td>
	<td>
	연락처
	</td>	
	</tr>
	
	<?php
	while($row=mysql_fetch_array($result)){
		
		$mobile01 = substr($row[mobile],0,3);
		$mobile02 = substr($row[mobile],4,4);
		$mobile = $mobile01."-****-".$mobile02;
		$mobile = $row[mobile];
		$cnt++;	
		?>
	<tr>
	<td>
	<?=$cnt?>
	</td>
	<td>
	<?=$row[userName]?>
	</td>
	<td>
	<?=$row[userNickName]?>
	</td>
	<td>
	<?=$mobile?>
	</td>	
	</tr>
		<?php
		
	}

?>
</table>