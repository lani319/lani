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

$userName = trim(Request('userName'));
$userNickname = trim(Request('userNickname'));
$mem_idx = trim(Request('userIdx'));
$mobile1 = trim(Request('mobile1'));
$mobile2 = trim(Request('mobile2'));
$mobile3 = trim(Request('mobile3'));
$selectArea1 = trim(Request('selectArea1'));
$selectArea2 = trim(Request('selectArea2'));
$selectArea3 = trim(Request('selectArea3'));
$selectArea4 = trim(Request('selectArea4'));
$selectArea5 = trim(Request('selectArea5'));
$selectArea6 = trim(Request('selectArea6'));
$selectArea7 = trim(Request('selectArea7'));
$selectArea8 = trim(Request('selectArea8'));
$selectArea9 = trim(Request('selectArea9'));
$price = trim(Request('price'));
$address1 = trim(Request('address1'));
$address2 = trim(Request('address2'));
$month1 = trim(Request('month1'));
$day1 = trim(Request('day1'));
$time1 = trim(Request('time1'));
$month2 = trim(Request('month2'));
$day2 = trim(Request('day2'));
$time2 = trim(Request('time2'));

$mobile = $mobile1."-".$mobile2."-".$mobile3;

if($selectArea2!=""){
	$region = $selectArea2;
}
if($selectArea3!=""){
	$region = $selectArea3;
}
if($selectArea4!=""){
	$region = $selectArea4;
}
if($selectArea5!=""){
	$region = $selectArea5;
}
if($selectArea6!=""){
	$region = $selectArea6;
}
if($selectArea7!=""){
	$region = $selectArea7;
}
if($selectArea8!=""){
	$region = $selectArea8;
}
if($selectArea9!=""){
	$region = $selectArea9;
}

$address = $address1." ".$address2;

$schedule1 = $month1."/".$day1."/".$time1;
$schedule2 = $month2."/".$day2."/".$time2;


$now_time=mktime();
$buy_no=$mem_idx."-".date("ymdHis",$now_time);

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);




$now_time=mktime();
$buy_no=$mem_idx."-".date("ymdHis",$now_time);


/*
State code
"0"=>"��������Ա�",
"1"=>"�������ԱݿϷ�",
"2"=>"�ſ�ī���ó��",
"3"=>"�ſ�ī��Ϸ�",
"4"=>"ȯ��ó����",
"5"=>"ȯ�ҿϷ�",
"6"=>"�ſ�ī�����",
"7"=>"�ڵ�����ó��",
"8"=>"�ڵ�������",
"9"=>"����Ʈ�����Ϸ�",
"10"=>"502����Ʈ�����Ϸ�",
"14"=>"502����Ʈȯ��",
"11"=>"ARSī�������û",
"12"=>"ARSī������Ϸ�",
"13"=>"ARSī��������",
"14"=>"ARSī�����ȯ��ó����",
"15"=>"ARSī�����ȯ�ҿϷ�"
*/

$settleType=6; //ARS������û
$state=11; //ARS������û��

$SQL="INSERT INTO oneDayServiceChargeInfo (
memIdx,
mobile,
address,
schedule1,
schedule2,
price,
buy_no,
state,
signDate,
payDate,
cardName,
cardNumber,
bank,
b_name,
settleType
) 
VALUES (
'".$mem_idx."',
'".strip_tags($mobile)."',
'".strip_tags($address)."',
'".$schedule1."',
'".$schedule2."',
'".$price."',
'".$buy_no."',
'".$state."',
now(),
'',
'',
'',
'".$bank."',
'".$b_name."',
'".$settleType."'
);
";
	
$result=mysql_query($SQL);

$type = "Visit";
$pidx = mysql_insert_id();
$content="ã�ư��� ����";

	$SQL = "
	insert into ars_card_info(uidx, pidx, type, price, regdate, content, phone, isUsePoint, point)
	values('".$_COOKIE['_CKE_USER_UID']."', '".$pidx."', '".$type."', '".$price."', now(), '".$content."', '".$mobile."', 'N', '0')
	";

	mysql_query($SQL) or die(mysql_error()); 


// ������ȣ
$pay_num = $type.'-'.mysql_insert_id();

$ars_msg = "ARSī����� - �����ڵ�:".$pay_num." �̸�:".$_COOKIE['_CKE_USER_NAME']." ��ȭ��ȣ:".$mobile;
foreach($_ARS_PAY_CHARGE as $name => $mobile_adm){
	$SQL="INSERT INTO uds_msg (msg_type, request_time, dest_phone, dest_name, send_phone, send_name , msg_body, etc1, etc2, etc3) 
	VALUES (0, now(), '".$mobile_adm."', '".$name."', '".$_ARS_PAY_CALL."', '".$_ARS_PAY_CALL_NAME."', '".$ars_msg."', '', '12', 'jongmok')";

	mysql_query($SQL) or die(mysql_error());

	
}


?>

<FORM NAME="pay_form_mobile" METHOD="POST" ACTION="/lani/oneDayService/ars_pay_result.html">
<INPUT TYPE="HIDDEN" NAME="price" value="<?=$price?>">
<INPUT TYPE="HIDDEN" NAME="buy_no" value="<?=$buy_no?>">
<input type="hidden" name="pay_num" value="<?=$pay_num?>">
</FORM>
</body>
</html>

<script>
//opener.location.reload();
document.pay_form_mobile.submit();
</script>