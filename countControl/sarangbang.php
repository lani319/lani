<?php

include_once "../../_config/db.connect.php";
include_once "../../_config/sys.config.php";
include_once "../../_libs/base_lib.php";
include_once "../../_libs/common_lib.php";
include_once "../../_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$cnt = 0;

$sql = "SELECT idx,hit,regDate FROM NaraBoard_expert_sm order by idx desc limit 0,5";

$tmpRs = mysql_query($sql);

while($rs = mysql_fetch_array($tmpRs))
{
	if ($rs[hit] <= 100)
	{
		$query = "update NaraBoard_expert_sm set hit=hit+13 where idx=$rs[idx]";
		mysql_query($query);
	}
	else 
	{
		$cnt++;
	}
}

echo $cnt;
?>