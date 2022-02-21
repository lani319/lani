<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$_HOST_NAME='211.172.241.7';
$_USER_NAME='co502';
$_DB='co502';
$_PASSWORD='@%^*&#';

$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//$idx= 3614;

//$userIdx='ayh319';
//$teacherIdx = "34904";

//$userIdx = "39115";

$sql = "
	SELECT exp_idx 
	FROM Member_expert 
	WHERE (settle_mode = 'cast' or settle_mode = 'great_stock')
		and mem_idx = '$userIdx'
		and enddate >= '".mktime(0, 0, 0, date('m'), date('d'), date('Y'))."'	
		and exp_idx = '$teacherIdx'	
	";

//echo $sql;

$tmpRs = mysql_query($sql);

$rs = mysql_fetch_array($tmpRs);

if($teacherIdx == $rs[exp_idx]) {	
	/* 관리자/전문가/방송회원/특별회원/문자회원/투자클럽회원/무료회원 구분*/
	$result = 1;	
}else{
	$result = 0;
}


if ($userIdx == '41608' || $userIdx == '34904' || $userIdx == '970' || $userIdx == '39115' || $userIdx == '12' || $userIdx == '26439' || $userIdx == '42872' || $userIdx == '30904' || $userIdx == '3622' || $userIdx == '42409' || $userIdx == '42828' || $userIdx == '42873' || $userIdx == '846')
{
	$result = 1;
}

echo $result;
?>