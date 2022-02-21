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

$sql = "SELECT content from stBoard where idx = $idx	"; //무료 투자전략
//$sql="select * from NaraBoard_expert_sm where idx=1259"; //유료회원 (유료회원 체크하는 기능 필요)

$tmpRs = mysql_query($sql);

$rs = mysql_fetch_array($tmpRs);
echo $rs[content];
?>