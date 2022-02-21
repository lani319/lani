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

$price 			= trim($_POST["price"]);			//가격
$mem_idx 		= trim($_POST["mem_idx"]);			//회원idx
$bank 			= trim($_POST["bank"]);			//계좌번호
$b_name			= trim($_POST["b_name"]);			//은행이름
$jokmok			= trim($_POST["jokmok"]);			//상품종목구분
$mobile1			= trim($_POST["mobile1"]);		//핸드폰
$mobile2			= trim($_POST["mobile2"]);
$mobile3			= trim($_POST["mobile3"]);


$now_time=mktime();
$buy_no=$mem_idx."-".date("ymdHis",$now_time);
$mobile = $mobile1."-".$mobile2."-".$mobile3;

if($b_name == '')
{
	$b_name="우리은행";
	$bank = "1005-301-453395 (주)평택촌놈";
}

if($jokmok=='' || $price=='' || $mem_idx=='' || $b_name=='' || $bank=='' || $mobile==''){

	//popupMsg("$jokmok $price $mem_idx $b_name $bank $mobile" );
	popupMsg("필수 입력 값이 누락되었습니다.");
	echo "<script> window.close(); </script>";
	exit();
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
$settletype=0; //무통장
$state=0; //무통장미입금
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
'".$bank."',
'".$mobile."',
'".$jokmok."',
'".$b_name."',
'".$settletype."'
);
";
$result=mysql_query($SQL);

?>


<FORM NAME="pay_form_bank" METHOD="POST" ACTION="/lani/jongmokValue/bank_pay_result.html">
<INPUT TYPE="HIDDEN" NAME="price" value="<?=$price?>">
<INPUT TYPE="HIDDEN" NAME="buy_no" value="<?=$buy_no?>">
<INPUT TYPE="HIDDEN" NAME="jokmok" value="<?=$jokmok?>">
<input type="hidden" name="bank" value="<?=$bank?>">
<INPUT TYPE="HIDDEN" name="b_name" value="<?=$b_name?>">
</FORM>
</body>
</html>
<script>
document.pay_form_bank.submit();
</script>
