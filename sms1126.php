<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$ip=$_SERVER['REMOTE_ADDR'];
$ip = explode(".",$ip);
$ip = $ip[0].".".$ip[1].".".$ip[2];

//$memId = $_COOKIE['_CKE_USER_ID'];
//��Ź911, �������� �����ϸ� ���� �����°�. ��а� ����. �α��� ó���ϴ� �������� ���� �Ǿ� ����. 

$r_ip=$_SERVER['REMOTE_ADDR'];

if($ip == "125.179.179"){
	$SQL="insert into uds_msg (msg_type, request_time, send_time, dest_phone, dest_name, send_phone, send_name , msg_body, etc1, etc2, etc3) values (0, now(), now(), '010-3157-7772', 'ȸ��','031-651-5023','ȸ��', '���� $r_ip �α���', '000', '12', 'sms')";
	
	mysql_query($SQL) or die(mysql_error());
}else if($ip == "119.192.20"){
	$SQL="insert into uds_msg (msg_type, request_time, send_time, dest_phone, dest_name, send_phone, send_name , msg_body, etc1, etc2, etc3) values (0, now(), now(), '010-3157-7772', 'ȸ��','031-651-5023','ȸ��', '��Ź $r_ip �α���', '000', '12', 'sms')";

	mysql_query($SQL) or die(mysql_error());
}
//echo $SQL;
exit;
?>