<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$pay_contents_idx		= trim($_POST["pay_contents_idx"]);	//�Խù� idx
$srv_code				= trim($_POST["srv_code"]);			//������ �ڵ�

$pay_contents_idx		= 5;	//�Խù� idx
$srv_code				= "12";			//������ �ڵ�

$mIdx = $_COOKIE['_CKE_USER_UID'];
$mName =  "";
$mMobileArr = "";
$mPostArr = "";
$mPost1 = "";
$mPost2 = "";
$mAddr1 = "";
$mAddr2 = "";

$mMobile1 = "";
$mMobile2 = "";
$mMobile3 = "";

if($mIdx)
{
	$sql = "select userName,zipcode,address1,address2,mobile from Member where idx=$mIdx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$mName = $rs["userName"];
	$mMobileArr = explode("-",$rs["mobile"]);
	$mPostArr = explode("-",$rs["zipcode"]);
	$mPost1 = $mPostArr[0];
	$mPost2 = $mPostArr[1];
	$mAddr1 = $rs["address1"];
	$mAddr2 = $rs["address2"];
	
	$mMobile1 = $mMobileArr[0];
	$mMobile2 = $mMobileArr[1];
	$mMobile3 = $mMobileArr[2];

}

if(!$pay_contents_idx || !$srv_code){
	popupMsg("�ʼ� �Է� ���� �����Ǿ����ϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}




//������ idx ��ȣȭ
$expert_idx = usrCrypt(URLdecode($srv_code),0);


$sql="select service_orderID as bn,service_name as title,service_price as price from service_goods where idx='".$pay_contents_idx."'";
$mqf=mysql_fetch_array(mysql_query($sql));

$contents_name=$mqf['title'];

$orderid=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");

?>
<html>
<head>
<title>������ ���� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

<script language="javascript" src="http://www.allthegate.com/plugin/AGSWallet.js"></script>
<script language="JavaScript" src="/card/basic_script.js"></script>
<script type="text/javascript">
<!--
function calcPayment(num)
{
	var cnt = num;
	document.getElementById('txtEachPrice').value = commaSplit(46000*num);
	document.getElementById('txtTotalPrice').value = commaSplit(46000*num+3000);
	
	document.getElementById('txtCnt').value = num;
	document.getElementById('txtPrice').value = 46000*num+3000;
}

function commaSplit(srcNumber) { 
var txtNumber = '' + srcNumber; 

var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])'); 
var arrNumber = txtNumber.split('.'); 
arrNumber[0] += '.'; 
do { 
arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2'); 
} 
while (rxSplit.test(arrNumber[0])); 
	if (arrNumber.length > 1) 
	{ 
		return arrNumber.join(''); 
	} 
	else 
	{ 
		return arrNumber[0].split('.')[0]; 
	} 
}

function getPost()
{	
	var win = window.open('/include/find_zipcode.php','dd','width=350px,height=400,toolbar=no,status=no,location=no,menubar=no,scrollbars=no,resizable=no,left=0,top=0');
}

var contents_price = <?=$mqf[price] ?>;


function pay_form_check(){
	var form=document.pay_form;

	if(form.pay_type[1].checked==true){ //�ſ�ī��
		if(confirm("�����ݾ�: "+form.price.value+"��\n"+point_msg+"\n���� �Ͻðڽ��ϱ�?")){
			form.action="/include/AGS_pay_ing.php";
			Pay(document.pay_form);
		}
	}
	else if(form.pay_type[2].checked==true){ //ARS
		if(confirm("�����ݾ�: "+form.price.value+"��\n"+point_msg+"\n���� �Ͻðڽ��ϱ�?")){
			form.action="/include/charge_contents_process_ars_card.php";
			form.submit();
			return true;
		}
	}
	else{ //������

	}
}
-->
</SCRIPT>


</head>
<body topmargin=0 leftmargin=0 onload="javascript:Enable_Flag(pay_form);">
      <FORM NAME="pay_form" METHOD="POST">
        <INPUT TYPE="TEXT" name="price" value="<?=$mqf[price]?>">
        <INPUT TYPE="TEXT" name="conidx" value="<?=$pay_contents_idx?>">
		<INPUT TYPE="TEXT" name="expert_idx" value="<?=$expert_idx?>">
		<INPUT TYPE="TEXT" name="mem_idx" value="<?=$_COOKIE['_CKE_USER_UID']?>">
		<INPUT TYPE="TEXT" name="sub_price">


		<!-- ī������� �ʿ��� ���� ���� -->
		<INPUT TYPE="TEXT" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="TEXT" NAME="StoreNm" value="�����̳�">
		<INPUT TYPE="TEXT" NAME="OrdNo" value="<?=$pay_contents_idx?>">  <!-- stBoard���̺��� idx�� -->
		<INPUT TYPE="TEXT" NAME="ProdNm" value="<?=$contents_name?>">
		<INPUT TYPE="TEXT" NAME="Amt" value="<?=$mqf[price]?>">
		<INPUT TYPE="TEXT" NAME="MallUrl" value="http://www.502.co.kr">
		<INPUT TYPE="TEXT" NAME="Remark" value="����">
		<INPUT TYPE="TEXT" NAME="Job" value="onlycard">
		<INPUT TYPE="TEXT" NAME="UserId" value="<?=$_COOKIE['_CKE_USER_ID']?>">
		<INPUT TYPE="TEXT" NAME="OrdNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="TEXT" NAME="OrdPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="TEXT" NAME="OrdAddr" value="����">
		<INPUT TYPE="TEXT" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="TEXT" NAME="RcpPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="TEXT" NAME="DlvAddr" value="����">
		<INPUT TYPE="TEXT" NAME="UserEmail" value="<?=$_COOKIE['_CKE_USER_EMAIL']?>">


		<!-- ��ũ��Ʈ �� �÷����ο��� ���� �����ϴ� Hidden �ʵ�  !!������ �Ͻðų� �������� ���ʽÿ�-->

		<!-- �� ���� ���� ��� ���� -->
		<input type=hidden name=Flag value="">				<!-- ��ũ��Ʈ������뱸���÷��� -->
		<input type=hidden name=AuthTy value="">			<!-- �������� -->
		<input type=hidden name=SubTy value="">				<!-- ����������� -->

		<!-- �ſ�ī�� ���� ��� ���� -->
		<input type=hidden name=DeviId value="">			<!-- (�ſ�ī�����)		�ܸ�����̵� -->
		<input type=hidden name=QuotaInf value="0">			<!-- (�ſ�ī�����)		�Ϲ��Һΰ����������� -->
		<input type=hidden name=NointInf value="NONE">		<!-- (�ſ�ī�����)		�������Һΰ����������� -->
		<input type=hidden name=AuthYn value="">			<!-- (�ſ�ī�����)		�������� -->
		<input type=hidden name=Instmt value="">			<!-- (�ſ�ī�����)		�Һΰ����� -->
		<input type=hidden name=partial_mm value="">		<!-- (ISP���)			�Ϲ��ҺαⰣ -->
		<input type=hidden name=noIntMonth value="">		<!-- (ISP���)			�������ҺαⰣ -->
		<input type=hidden name=KVP_RESERVED1 value="">		<!-- (ISP���)			RESERVED1 -->
		<input type=hidden name=KVP_RESERVED2 value="">		<!-- (ISP���)			RESERVED2 -->
		<input type=hidden name=KVP_RESERVED3 value="">		<!-- (ISP���)			RESERVED3 -->
		<input type=hidden name=KVP_CURRENCY value="">		<!-- (ISP���)			��ȭ�ڵ� -->
		<input type=hidden name=KVP_CARDCODE value="">		<!-- (ISP���)			ī����ڵ� -->
		<input type=hidden name=KVP_SESSIONKEY value="">	<!-- (ISP���)			��ȣȭ�ڵ� -->
		<input type=hidden name=KVP_ENCDATA value="">		<!-- (ISP���)			��ȣȭ�ڵ� -->
		<input type=hidden name=KVP_CONAME value="">		<!-- (ISP���)			ī��� -->
		<input type=hidden name=KVP_NOINT value="">			<!-- (ISP���)			������/�Ϲݿ���(������=1, �Ϲ�=0) -->
		<input type=hidden name=KVP_QUOTA value="">			<!-- (ISP���)			�Һΰ��� -->
		<input type=hidden name=CardNo value="">			<!-- (�Ƚ�Ŭ��,�Ϲݻ��)	ī���ȣ -->
		<input type=hidden name=MPI_CAVV value="">			<!-- (�Ƚ�Ŭ��,�Ϲݻ��)	��ȣȭ�ڵ� -->
		<input type=hidden name=MPI_ECI value="">			<!-- (�Ƚ�Ŭ��,�Ϲݻ��)	��ȣȭ�ڵ� -->
		<input type=hidden name=MPI_MD64 value="">			<!-- (�Ƚ�Ŭ��,�Ϲݻ��)	��ȣȭ�ڵ� -->
		<input type=hidden name=ExpMon value="">			<!-- (�Ϲݻ��)			��ȿ�Ⱓ(��) -->
		<input type=hidden name=ExpYear value="">			<!-- (�Ϲݻ��)			��ȿ�Ⱓ(��) -->
		<input type=hidden name=Passwd value="">			<!-- (�Ϲݻ��)			��й�ȣ -->
		<input type=hidden name=SocId value="">				<!-- (�Ϲݻ��)			�ֹε�Ϲ�ȣ/����ڵ�Ϲ�ȣ -->

		<!-- ������ü ���� ��� ���� -->
		<input type=hidden name=ICHE_OUTBANKNAME value="">	<!-- ��ü��������� -->
		<input type=hidden name=ICHE_OUTACCTNO value="">	<!-- ��ü���¿������ֹι�ȣ -->
		<input type=hidden name=ICHE_OUTBANKMASTER value=""><!-- ��ü���¿����� -->
		<input type=hidden name=ICHE_AMOUNT value="">		<!-- ��ü�ݾ� -->

		<!-- �ڵ��� ���� ��� ���� -->
		<input type=hidden name=HP_SERVERINFO value="">		<!-- �������� -->
		<input type=hidden name=HP_HANDPHONE value="">		<!-- �ڵ�����ȣ -->
		<input type=hidden name=HP_COMPANY value="">		<!-- ��Ż��(SKT,KTF,LGT) -->
		<input type=hidden name=HP_IDEN value="">			<!-- �����û�� -->
		<input type=hidden name=HP_IPADDR value="">			<!-- ���������� -->

		<!-- ������� ���� ��� ���� -->
		<input type=hidden name=ZuminCode value="">			<!-- ��������Ա����ֹι�ȣ -->
		<input type=hidden name=VIRTUAL_CENTERCD value="">	<!-- ������������ڵ� -->
		<input type=hidden name=VIRTUAL_DEPODT value="">	<!-- ��������Աݿ����� -->
		<input type=hidden name=VIRTUAL_NO value="">		<!-- ������¹�ȣ -->

		<!-- �츮����ũ�� ���� ��� ���� -->
		<input type=hidden name=mTId value="">				<!-- ����ũ���ֹ���ȣ -->

		<!-- ��ũ��Ʈ �� �÷����ο��� ���� �����ϴ� Hidden �ʵ�  !!������ �Ͻðų� �������� ���ʽÿ�-->
		<!-- ī������� �ʿ��� ���� �� -->




<table width="1020px" cellpadding="0" cellspacing="0" border="0">
<tr>
<td colspan="5" align="left" width="100%">
<img src="img/order/top.gif" border="0">
</td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
<tr>
<td width="300px" align="left" style="padding:0 0 0 0;" valign="top">
<img src="img/order/left01.gif" border="0">
</td>
<td>
	<table width="700px" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #4a4a4a;">	
	<tr align="center" bgcolor="#cfebfd">
	<td height="30px" style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">��ǰ��</td>
	<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">�ǸŰ�</td>
	<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">����</td>
	<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">��۷�</td>
	<td style="border-bottom:1px solid #000000;font-weight:bold;">�հ�ݾ�</td>
	</tr>
	<tr align="center" height=100px style="border:1px solid #000000;">
	<td width="320px" style="border-right:1px solid #000000;">[å]������ ���� - �Թ��� <br>+<br>[VOD]QBS ������ ���� �ٽú��� �̿��</td>
	<td width="100px" style="border-right:1px solid #000000;">
	<!--
	<input type="text" style="width:95px;height:23px;text-align:right;font-size:14px;" value="46,000" id="txtEachPrice" name="txtEachPrice">��
	-->
	46,000��
	</td>
	<td width="50px" style="border-right:1px solid #000000;">
	<!--
	<select name="selCnt" id="selCnt" onchange="calcPayment(this.value);">
	<option value="1" selected>1</option>
	<option value="2" >2</option>
	<option value="3" >3</option>
	<option value="4" >4</option>
	<option value="5" >5</option>
	</select>
	-->
	1 ��Ʈ
	</td>
	<td width="100px" style="border-right:1px solid #000000;">3,000��</td>
	<td>
	<!--
	<input type="text" style="width:100px;height:23px;text-align:right;font-size:14px;" value="49,000" name="txtTotalPrice" id="txtTotalPrice">��
	-->
	49,000��
	</td>
	</tr>
	</table>
</td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
<tr>
<td align="left" style="padding:0 0 0 0;" valign="top">
<img src="img/order/left02.gif" border="0">
</td>
<td>
	<table width="700px" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #6a8fb1;">
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td width="120px" valign="top"><img src="img/order/dot.gif">�̸� : </td>
	<td><input type="text" name="txtMemName" id="txtMemName" style="width:100px;" value="<?=$mName?>"></td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">����ó : </td>
	<td>
	<input type="text" name="txtMemPhone1" id="txtMemPhone1" style="width:35px;" maxlength="3" value="<?=$mMobile1?>">
	-
	<input type="text" name="txtMemPhone2" id="txtMemPhone2" style="width:40px;" maxlength="4" value="<?=$mMobile2?>">
	-
	<input type="text" name="txtMemPhone2" id="txtMemPhone3" style="width:40px;" maxlength="4" value="<?=$mMobile3?>">	
	</td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>

	</table>
</td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
<tr>
<td align="left" style="padding:0 0 0 0;" valign="top">
<img src="img/order/left03.gif" border="0">
</td>
<td>
<table width="700px" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #6a8fb1;">
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td width="120px" valign="top"><img src="img/order/dot.gif">�̸� : </td>
	<td><input type="text" name="txtMemNameD" id="txtMemNameD" style="width:100px;" value="<?=$mName?>"></td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">����ó : </td>
	<td>
	<input type="text" name="txtMemPhone1D" id="txtMemPhone1D" style="width:35px;" maxlength="3" value="<?=$mMobile1?>">
	-
	<input type="text" name="txtMemPhone2D" id="txtMemPhone2D" style="width:40px;" maxlength="4" value="<?=$mMobile2?>">
	-
	<input type="text" name="txtMemPhone2D" id="txtMemPhone3D" style="width:40px;" maxlength="4" value="<?=$mMobile3?>">	
	</td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">�����ȣ : </td>
	<td valign="bottom">
	<input type="text" name="zipcode1" id="txtMemPost1D" style="width:35px;" maxlength="3" readonly>
	-
	<input type="text" name="zipcode2" id="txtMemPost2D" style="width:35px;" maxlength="4" readonly>
	<img src="img/imgPostCode.gif" border="0" style="cursor:hand;" onclick="getPost();">
	</td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">�ּ� : </td>
	<td>
	<input type="text" name="address1" id="txtMemAddr1D" style="width:350px;" >
	<br>
	<input type="text" name="address2" id="txtMemAddr2D" style="width:350px;" >
	</td>
	</tr>	
	<tr><td colspan="2" height="5px"></td></tr>
	</table>
</td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
<tr>
<td align="left" style="padding:0 0 0 0;">
<img src="img/order/left04.gif" border="0">
</td>
<td>
	<table width="700px" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #6a8fb1;">
	<tr><td colspan="2" height="5px"></td></tr>
	<tr align="center">
	<td  valign="top"><input type="radio" name="pay_type" value="bank" checked onclick="document.getElementById('txtPaymethod').value = this.value;">������ �Ա�</td>
	<td  valign="top"><input type="radio" name="pay_type" value="card" onclick="document.getElementById('txtPaymethod').value = this.value;">�ſ�ī��</td>
	<!--
	<td width="100px" valign="top"><input type="radio" name="pay_type" value="mobile" onclick="document.getElementById('txtPaymethod').value = this.value;">�ڵ���</td>
	<td width="100px" valign="top"><input type="radio" name="pay_type" value="coin" onclick="document.getElementById('txtPaymethod').value = this.value;">502����</td>
	<td width="120px" valign="top"><input type="radio" name="pay_type" value="realBank" onclick="document.getElementById('txtPaymethod').value = this.value;">�ǽð� ������ü</td>
	-->
	<td  valign="top"><input type="radio" name="pay_type" value="ARS" onclick="document.getElementById('txtPaymethod').value = this.value;">ARSī�����</td>	
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	</tr>
	</table>
</td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
<tr>
<td colspan="5" align="center"><img src="img/order/btnPaySubmit.gif" style="cursor:hand;" onclick="goPay();"></td>
</tr>
</table>

<input type="hidden" id="txtCnt" name="txtCnt" value="1">
<input type="hidden" id="txtPrice" name="txtPrice" value="49000">
<input type="text" id="txtPayMethod" name="txtPayMethod" value="bank">

</body>
</html>