#! /usr/bin/php -q
<?
include_once "/home/co502/public_html/_config/db.connect.php";
include_once "/home/co502/public_html/_config/sys.config.php";
include_once "/home/co502/public_html/_libs/base_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$sql = "select hit,idx from NaraBoard_pt_column where delFlag = 0";
$tmpRs = mysql_query($sql);  

while($rs = mysql_fetch_array($tmpRs))
{
	$hitNum = 0;
	if($rs[0]<=100)
	{
		$hitNum = rand(1,3);
	}
	else if($rs[0]>100 && $rs[0] <= 200)
	{
		$hitNum = rand(3,5);
	}
	else if($rs[0]>200 && $rs[0] <= 300)
	{
		$hitNum = rand(5,7);
	}
	else if($rs[0]>300 && $rs[0] <= 400)
	{
		$hitNum = rand(5,8);
	}
	else if($rs[0]>500)
	{
		$hitNum = rand(5,15);
	}
	else {
		$hitNum = rand(1,2);
	}
	
	$sql = "update NaraBoard_pt_column set hit = hit+$hitNum where idx = $rs[1]";
	mysql_query($sql);
}
?>