<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
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

$bank 			= trim($_POST["bank"]);			//���¹�ȣ
$b_name			= trim($_POST["b_name"]);			//�����̸�
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


//���ݿ����� ó��

$receiptGubun = trim(Request('rdReceipt'));
$receiptNumber = trim(Request('receiptNumber'));

if($b_name == '')
{
	$b_name="�츮����";
	$bank = "1005-301-453395 (��)�����̳�";
}

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
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
$settleType=0; //������
$state=0; //��������Ա�
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
bank,
b_name,
settleType,
receiptGubun,
receiptNumber
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
'".$bank."',
'".$b_name."',
'".$settleType."',
'".$receiptGubun."',
'".strip_tags($receiptNumber)."'
);
";

mysql_query($SQL) or die(mysql_error());

?>


<FORM NAME="pay_form_bank" METHOD="POST" ACTION="/lani/oneDayService/bank_pay_result.html">
<INPUT TYPE="HIDDEN" NAME="price" value="<?=$price?>">
<INPUT TYPE="HIDDEN" NAME="buy_no" value="<?=$buy_no?>">
<input type="hidden" name="bank" value="<?=$bank?>">
<INPUT TYPE="HIDDEN" name="b_name" value="<?=$b_name?>">
</FORM>
</body>
</html>
<script>
document.pay_form_bank.submit();
</script>
