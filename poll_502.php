<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$sql = "select take_uidx from nara_poll
where pidx=114";

$tmpRs = mysql_query($sql);

$rs = mysql_fetch_array($tmpRs);

$result = str_replace("|",",",$rs[0]);

//echo $result;

$y20 = 0;
$y30 = 0;
$y40 = 0;
$y50 = 0;
$y60 = 0;


$sql = "select 117-left(userNum_sub,2) from Member where idx in ($result);";
$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs)){
	switch((substr($rs[0],0,1)))
	{
		case 2:
		$y20 += 1;
		break;
		
		case 3:
		$y30 += 1;
		break;
		
		case 4:
		$y40 += 1;
		break;
		
		case 5:
		$y50 += 1;
		break;
		
		case 6:
		$y60 += 1;
		break;
		
		case 7:
		$y60 += 1;
		break;
		
		case 8:
		$y60 += 1;
		break;
		
		case 9:
		$y60 += 1;
		break;
		
	}

}
echo "<b>���ɴ뺰 ������ �� <br>";
echo "20�� : ". $y20."��";
echo "<br>";
echo "30�� : ". $y30."��";
echo "<br>";
echo "40�� : ". $y40."��";
echo "<br>";
echo "50�� : ". $y50."��";
echo "<br>";
echo "60�� �̻� : ". $y60."��";






?>