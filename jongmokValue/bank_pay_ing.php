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

$price 			= trim($_POST["price"]);			//����
$mem_idx 		= trim($_POST["mem_idx"]);			//ȸ��idx
$bank 			= trim($_POST["bank"]);			//���¹�ȣ
$b_name			= trim($_POST["b_name"]);			//�����̸�
$jokmok			= trim($_POST["jokmok"]);			//��ǰ���񱸺�
$mobile1			= trim($_POST["mobile1"]);		//�ڵ���
$mobile2			= trim($_POST["mobile2"]);
$mobile3			= trim($_POST["mobile3"]);


$now_time=mktime();
$buy_no=$mem_idx."-".date("ymdHis",$now_time);
$mobile = $mobile1."-".$mobile2."-".$mobile3;

if($b_name == '')
{
	$b_name="�츮����";
	$bank = "1005-301-453395 (��)�����̳�";
}

if($jokmok=='' || $price=='' || $mem_idx=='' || $b_name=='' || $bank=='' || $mobile==''){

	//popupMsg("$jokmok $price $mem_idx $b_name $bank $mobile" );
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
$settletype=0; //������
$state=0; //��������Ա�
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
