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

//$userId='ayh319';
//$userPass = "fksl7132";

$sql = "SELECT count(idx) as cnt,idx, userId,userNickname,gradeLevel,memType,level,now() as loginDate from Member where userID='$userId' and userPass='$userPass' group by idx";

//echo $sql;

$tmpRs = mysql_query($sql);

$rs = mysql_fetch_array($tmpRs);

$memberCnt = $rs[cnt];

if($memberCnt == 1) {
	
	/* ������/������/���ȸ��/Ư��ȸ��/����ȸ��/����Ŭ��ȸ��/����ȸ�� ����*/
	$result = $rs[idx];
	
}else{
	$result = 0;
}


echo $result;
?>