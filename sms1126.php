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
//스탁911, 정석투자 접속하면 문자 보내는거. 당분간 지속. 로그인 처리하는 페이지에 삽입 되어 있음. 

$r_ip=$_SERVER['REMOTE_ADDR'];

if($ip == "125.179.179"){
	$SQL="insert into uds_msg (msg_type, request_time, send_time, dest_phone, dest_name, send_phone, send_name , msg_body, etc1, etc2, etc3) values (0, now(), now(), '010-3157-7772', '회사','031-651-5023','회사', '정석 $r_ip 로그인', '000', '12', 'sms')";
	
	mysql_query($SQL) or die(mysql_error());
}else if($ip == "119.192.20"){
	$SQL="insert into uds_msg (msg_type, request_time, send_time, dest_phone, dest_name, send_phone, send_name , msg_body, etc1, etc2, etc3) values (0, now(), now(), '010-3157-7772', '회사','031-651-5023','회사', '스탁 $r_ip 로그인', '000', '12', 'sms')";

	mysql_query($SQL) or die(mysql_error());
}
//echo $SQL;
exit;
?>