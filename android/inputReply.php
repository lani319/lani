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

/*
파라미터
1. bidx -> 부모 글 번호
2. uidx -> 회원 인덱스
3. type -> 무료 투자전략/ 유료 투자전략 / 시청후기 / 심봤다 구분
4. proIdx -> 전문가 번호 (유료 투자전략일 경우에만 해당)

0 - 무료 투자전략
1 - 유료 투자전략
2 - 시청후기
3 - 심봤다


*/

//TEST Parameter
//$bidx = 3643;
//$uidx = 39245;
$type = 0;
$proIdx = "" ;
//$content = "THANK YOU!!!";

if ($type == 0){
$sql = "insert into commentST(uidx,bidx,content,signdate) values('$uidx','$bidx','$content',now());";
}

//echo $sql;

$result = mysql_query($sql);
if(!$result){
	die("mysql error");
}
else {
	$sql="UPDATE stBoard set commentcount = commentcount + 1 where idx='".$bidx."'";
	mysql_query($sql) or die(mysql_error());

	echo "1";
	//echo $sql;
}


?>