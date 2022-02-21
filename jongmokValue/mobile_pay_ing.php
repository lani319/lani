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
$jokmok			= trim($_POST["jokmok"]);			//상품종목구분



if($price=='' || $mem_idx=='' || $jokmok==''){
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





$buy_no=$mem_idx."-".date("ymdHis",$now_time);

$settletype=2;
$state=9; //핸드폰 미처리
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
$insert_id=mysql_insert_id();

?>
<FORM NAME="pay_form_mobile" METHOD="POST" ACTION="/teledit/Ready2.php3">
<INPUT TYPE="HIDDEN" NAME="price" value="<?=$price?>">
<INPUT TYPE="HIDDEN" NAME="mem_idx" value="<?=$mem_idx?>">
<INPUT TYPE="HIDDEN" NAME="buy_no" value="<?=$buy_no?>">
<INPUT TYPE="HIDDEN" NAME="insert_id" value="<?=$insert_id?>">
<INPUT TYPE="HIDDEN" NAME="jokmok" value="<?=$jokmok?>">
</FORM>
</body>
</html>

<script>
var SP2 = (window.navigator.userAgent.indexOf("SV1") != -1); 
function winResize(){
	if(SP2)
		window.resizeTo(295, 395);
	else
		window.resizeTo(295, 415);
}
winResize();
document.pay_form_mobile.submit();
</script>