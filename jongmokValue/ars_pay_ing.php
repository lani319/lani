<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>
</head>
<body topmargin=0 leftmargin=0>
<?
$price 			= trim($_POST["price"]);			//����
$mem_idx 		= trim($_POST["mem_idx"]);			//ȸ��idx
$jokmok			= trim($_POST["jokmok"]);			//��ǰ���񱸺�
$mobile1			= trim($_POST["mobile1"]);		//�ڵ���
$mobile2			= trim($_POST["mobile2"]);
$mobile3			= trim($_POST["mobile3"]);


if($price=='' || $mem_idx=='' || $jokmok==''){
	popupMsg("�ʼ� �Է� ���� �����Ǿ����ϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);




$now_time=mktime();
$buy_no=$mem_idx."-".date("ymdHis",$now_time);


$settletype=6; //ARSī�����
$state=11; //ARSī�������û
$SQL="INSERT INTO jongmokValueChargeInfo (
memIdx,
price,
buy_no,
state,
signdate,
paydate,
cardName,
cardNumber,
bank,
j_mobile,
jongmok,
b_name,
settletype
) 
VALUES (
'".$mem_idx."',
'".$price."',
'".$buy_no."',
'".$state."',
now(),
'',
'',
'',
'',
'',
'".$jokmok."',
'',
'".$settletype."'
);
";
$result=mysql_query($SQL);

$mobile = $mobile1."-".$mobile2."-".$mobile3;

$type = "jongmok";
$pidx = mysql_insert_id();


$sql = "
insert into ars_card_info(uidx, pidx, type, price, regdate, content, phone, isUsePoint, point)
values('".$_COOKIE['_CKE_USER_UID']."', '".$pidx."', '".$type."', '".$price."', now(), '".$_JONGMOK_PRESENT[$jokmok]."', '".$mobile."', 'N', '0')
";
mysql_query($sql) or die(mysql_error());

// ������ȣ
$pay_num = $type.'-'.mysql_insert_id();

$ars_msg = "ARSī����� - �����ڵ�:".$pay_num." �̸�:".$_COOKIE['_CKE_USER_NAME']." ��ȭ��ȣ:".$mobile;
foreach($_ARS_PAY_CHARGE as $name => $mobile_adm){
	$SQL="INSERT INTO uds_msg (msg_type, request_time, dest_phone, dest_name, send_phone, send_name , msg_body, etc1, etc2, etc3) VALUES (0, now(), '".$mobile_adm."', '".$name."', '".$_ARS_PAY_CALL."', '".$_ARS_PAY_CALL_NAME."', '".$ars_msg."', '', '12', 'jongmok')";

	mysql_query($SQL) or die(mysql_error());
}


?>

<FORM NAME="pay_form_mobile" METHOD="POST" ACTION="/lani/jongmokValue/ars_pay_result.php">
<INPUT TYPE="HIDDEN" NAME="price" value="<?=$price?>">
<INPUT TYPE="HIDDEN" NAME="buy_no" value="<?=$buy_no?>">
<INPUT TYPE="HIDDEN" NAME="jokmok" value="<?=$jokmok?>">
<input type="hidden" name="pay_num" value="<?=$pay_num?>">
</FORM>
</body>
</html>

<script>
//opener.location.reload();
document.pay_form_mobile.submit();
</script>