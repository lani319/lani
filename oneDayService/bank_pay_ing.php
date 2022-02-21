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

$bank 			= trim($_POST["bank"]);			//계좌번호
$b_name			= trim($_POST["b_name"]);			//은행이름
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


//현금영수증 처리

$receiptGubun = trim(Request('rdReceipt'));
$receiptNumber = trim(Request('receiptNumber'));

if($b_name == '')
{
	$b_name="우리은행";
	$bank = "1005-301-453395 (주)평택촌놈";
}

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
"0"=>"무통장미입금",
"1"=>"무통장입금완료",
"2"=>"신용카드미처리",
"3"=>"신용카드완료",
"4"=>"환불처리중",
"5"=>"환불완료",
"6"=>"신용카드취소",
"7"=>"핸드폰미처리",
"8"=>"핸드폰승인",
"9"=>"포인트결제완료",
"10"=>"502포인트결제완료",
"14"=>"502포인트환불",
"11"=>"ARS카드결제신청",
"12"=>"ARS카드결제완료",
"13"=>"ARS카드결제취소",
"14"=>"ARS카드결제환불처리중",
"15"=>"ARS카드결제환불완료"
*/
$settleType=0; //무통장
$state=0; //무통장미입금
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
