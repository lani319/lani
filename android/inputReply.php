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
�Ķ����
1. bidx -> �θ� �� ��ȣ
2. uidx -> ȸ�� �ε���
3. type -> ���� ��������/ ���� �������� / ��û�ı� / �ɺô� ����
4. proIdx -> ������ ��ȣ (���� ���������� ��쿡�� �ش�)

0 - ���� ��������
1 - ���� ��������
2 - ��û�ı�
3 - �ɺô�


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