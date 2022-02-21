<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//echo $txtParam;

$arrParam = explode("^",$txtParam);

/*
echo $arrParam[0];
echo $arrParam[1];

echo "<br>";

echo $_POST[$arrParam[0]];
echo "<br>";
echo $_POST[$arrParam[1]];

//echo $txt30904;
*/


for($i=0 ; $i<sizeof($arrParam)-1 ; $i++)
{
	$memInfo = explode("$",$_POST[$arrParam[$i]]);
	
	for($j=0 ; $j<sizeof($memInfo)-1 ; $j++)
	{
		$memInfo2 = explode('^',$memInfo[$j]);
		
		
		$sql = "select count(idx) as cnt from TM_customer where userIdx = $memInfo2[0]";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if($rs[cnt] == 0)
		{
		$sql = "insert into TM_customer(userIdx,userId,adminIdx) values('$memInfo2[0]','$memInfo2[2]','$memInfo2[1]')";	
		mysql_query($sql);
//		echo $sql;
//		echo "<br>";
		}
	}	
}


?>

<script>
alert('등록되었습니다.');
location.href = "TM_member.php";
</script>