<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "select count(idx) from jongmokValue";
$tmpRs = mysql_query($sql);
$rs=mysql_fetch_row($tmpRs);

$count = $rs[0];


//echo $count;

$num = round($count/200);

$start = 0;

for($i=1 ; $i<=$num+1 ; $i++)
{
	$startNum = $start * 200;
	
	$endNum = ($i * 200) - 1;
		
	$start++;
	
	?>
	<a href="#" onclick="goJachong('<?=$startNum?>','<?=$endNum?>');"><?=$startNum?> ~ <?=$endNum?></a> <br><br>
	<?php
}
?>
<html>
<head>

<script type="text/javascript">
function goJachong(t1,t2){
	
	var url = "updateJachong_ok.php?start="+t1+"&end="+t2;
		
	document.getElementById("invFrame").src = url;
	
}

//alert('asldfkasdlf');
</script>

</head>

<body>
<form name="f" method="POST">
<iframe name="invFrame" id="invFrame" width="100%" height="100%" frameborder="1"></iframe>
</form>

</body>
</html>