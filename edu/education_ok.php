<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$currentMovie = $currentMovie;
$latestMovie = $latestMovie;
$currentLevel = $memberLevel;

$uidx = $_COOKIE["_CKE_USER_UID"];
$sql = "select showCnt$currentMovie as point from First_education_info where userIdx='".$uidx."'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);

if($rs[point] < 2)
{
	$sql = "update First_education_info set currentMovie='".$currentMovie."', latestMovie='". $latestMovie."',showCnt$currentMovie = (showCnt$currentMovie+1) where userIdx='".$uidx."'";	
}
else 
{
	$sql = "update First_education_info set currentMovie='".$currentMovie."' where userIdx='".$uidx."'";
}
mysql_query($sql);
?>

<script type="text/javascript">

location.href = "test.html?currentMovie=<?=$currentMovie+1?>";

</script>