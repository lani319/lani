<?
/*
2014�� 1��, ������� ����. 1���� 1+1 , 10���� 3���� ����. ������
*/

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


$_SESSION['b1'] = '11000';
$_SESSION['b10'] = '30000';

?>
<html>
<head>
<title>�����ְ� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="css/jongmokValueStyle.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

<script language="javascript" src="http://www.allthegate.com/plugin/AGSWallet.js"></script>
<script language="JavaScript" src="/card/basic_script.js"></script>
<?

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$contents_name="502����Ʈ ����";
$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"idx, mobile, phone, total_point");
if(!$meminfo[idx]){
	popupMsg(" ȸ�������� ���� ���� �ʽ��ϴ�. \r\n �ٽ��ѹ� �α����� ��õ� ���ּ���");
	echo "<script> opener.location.href='/include/logout.php' </script>";
	echo "<script> window.close(); </script>";
	exit();
}
if($meminfo['mobile'] != '' && str_replace('-', '', $meminfo['mobile']) != ''){
	$mobile = explode('-', $meminfo['mobile']);
}
else if($meminfo['phone'] != '' && str_replace('-', '', $meminfo['phone']) != ''){
	$mobile = explode('-', $meminfo['phone']);
}
$orderid=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");


?>

</head>
<body topmargin=0 leftmargin=0 onload="javascript:Enable_Flag(pay_form);">

<SCRIPT>

function pay_type_check(){
	var form=document.pay_form;
	if(form.pay_type[0].checked==true){		
		document.getElementById("bankName").style.display="block";
		document.getElementById("bankAccount").style.display="block";
		
	}else{
		document.getElementById("bankName").style.display="none";
		document.getElementById("bankAccount").style.display="none";
	}
}

function pay_form_check(){
	var form=document.pay_form;
	//var mobile_limit_price=100000;
	//var mobile_min_price=1000;
	
	if(form.username.value==""){
		alert("������ �̸��� �Է� ���ּ���");
		form.username.focus();
		return false;
	}
	if(form.mobile1.value=="" || form.mobile2.value=="" || form.mobile3.value==""){
		alert("��ȭ��ȣ�� �Է� ���ּ���");
		form.mobile1.focus();
		return false;
	}
	
	if(form.cash.value == ''){
		alert("���� �ݾ��� �����ϼ���.");
		return false;
	}
	//ȯ�ұ��� üũ �߰� , �����̳� ������ 1028
	if(!document.getElementById('chkRefund').checked)
	{
		alert("ȯ�� ������ �����ؾ� ������ �����մϴ�.");
		return false;
	}
	
	else{
		
			form.price.value = form.cash.value;
			form.Amt.value = form.cash.value;
		
			var priceVal = form.price.value;
			
			if(priceVal=='11000'){
				form.jokmok.value = '1';
				form.ProdNm.value = '1����';			
			}else{
				form.jokmok.value='10';
				form.ProdNm.value = '10����';
			}
		
	}	
	
	if(form.pay_type[0].checked==true){
		if(form.bank_name.value != "�츮����"){
			alert("�Ա��Ͻ� ������ �����ϼ���");
			return false;
		}

		if(confirm("�����ݾ�: "+form.price.value+"�� ���� �Ͻðڽ��ϱ�?")){
			form.action="/lani/jongmokValue/bank_pay_ing.php";
			form.submit();
			return true;
		}
	}
	else if(form.pay_type[1].checked==true){
		if(confirm("�����ݾ�: "+form.price.value+"�� ���� �Ͻðڽ��ϱ�?")){
			form.action="/lani/jongmokValue/card_pay_ing_201401.php"; //������ �ӽ÷� ���ϸ� ���� 20140106
			Pay(document.pay_form);
		}
	}
	else if(form.pay_type[2].checked==true){
		
		if(confirm("�����ݾ�: "+form.price.value+"�� ���� �Ͻðڽ��ϱ�?")){
			form.action="/lani/jongmokValue/ars_pay_ing.php";
			form.submit();
			return true;
		}
	}else{
		if(form.cash.value=='110000'){
			alert('100000�� �̻��� �޴������� ������ �Ұ����մϴ�.');
			return false;
		}else{
			form.action="/lani/jongmokValue/mobile_pay_ing_new_201401.php";
			form.submit();
		}

	}
}

function view_bank_num(){
	var val = document.getElementById('bank_name').value;
	var value;

	if(val=="�츮����"){
		value="1005-301-453395 (��)�����̳�";
		document.getElementById('b_name').value = val;
		document.getElementById('bank').value = value;
	}else{
		value="�Ա��Ͻ� ������ �����ϼ���";
		document.getElementById('b_name').value = '';
		document.getElementById('bank').value = '';
	}
	document.getElementById('bank_num').innerHTML=value;
}

</SCRIPT>
<table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="15px"> </td>
</tr>
<tr>
<td style="border-color:#FFFFFF"> <img src="img/title_beforepay.gif"> </td>
</tr>
<tr>
<td style="border-color:#FFFFFF">
 <img src="img/notice_refund2014.jpg">
</td>
</tr>
</table>
<p></p>
 
<table width="350" border="0" align="center" cellpadding="0" cellspacing="0" style="border-color:#FCF1D4">
  <tr>
    <td style="border-color:#FFFFFF"><img src="img/title_pay.gif" ></td>
  </tr>
  <tr><td height="10px"></td></tr>
  <tr>
    <td><TABLE width=98% border=0 align="center" cellpadding=0 CELLSPACING=0 class="table01">
      <FORM NAME="pay_form" METHOD="POST">
        <input type="hidden" name="price" id="price" value="">
		<input type="hidden" name="mem_idx" id="mem_idx" value="<?php echo $_COOKIE['_CKE_USER_UID']; ?>">
		<input type="hidden" name="bank" id="bank" value="">
		<input type="hidden" name="b_name" id="b_name" value="">
		<input type="hidden" name="jokmok" id="jokmok" value="">

		<!-- ī������� �ʿ��� ���� ���� -->
		<INPUT TYPE="HIDDEN" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="HIDDEN" NAME="StoreNm" value="�����̳�">
		<INPUT TYPE="HIDDEN" NAME="OrdNo" value="<?=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");?>">  <!-- service_kind���̺��� orderID -->
		<INPUT TYPE="HIDDEN" NAME="ProdNm" value="">
		<INPUT TYPE="HIDDEN" NAME="Amt" value="">
		<INPUT TYPE="HIDDEN" NAME="MallUrl" value="http://www.502.co.kr">
		<INPUT TYPE="HIDDEN" NAME="Remark" value="">
		<INPUT TYPE="HIDDEN" NAME="Job" value="onlycard">
		<INPUT TYPE="HIDDEN" NAME="UserId" value="<?=$_COOKIE['_CKE_USER_ID']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdPhone" value="<?=$meminfo[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="OrdAddr" value="����">
		<INPUT TYPE="HIDDEN" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="RcpPhone" value="<?=$meminfo[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="DlvAddr" value="����">
		<INPUT TYPE="HIDDEN" NAME="UserEmail" value="<?=$_COOKIE['_CKE_USER_EMAIL']?>">
		<!-- <input type="HIDDEN" style="width:300px" name="SubjectData" value="��ȣ��;��ǰ��;�����ݾ�;������~�����������;"> -->


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



		<TR height=26>
          <TD WIDTH="83" height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>������</strong></TD>
          <TD width=8></TD>
          <TD width="250"><INPUT TYPE="TEXT" name="username" value="<?=$_COOKIE['_CKE_USER_NAME']?>" class="input01" style="width:120" readonly></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD WIDTH="83"  height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>��ȭ��ȣ</strong></TD>
          <TD width=8></TD>
          <TD>
			<input name="mobile1" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[0]?>">
			&nbsp;-&nbsp;
            <input name="mobile2" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[1]?>">
            &nbsp;-&nbsp;
            <input name="mobile3" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[2]?>"><br>
			<font color="red">�ع����� �Ա� �� ���ݿ����� ��û�� ��ȣ�Է�</font></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD align="center" WIDTH="83" height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>�������</strong></TD>
          <TD width=8></TD>
          <TD><INPUT TYPE="RADIO" name="pay_type" value="1" onclick="pay_type_check();">�������Ա�
            &nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="RADIO" name="pay_type" value="2" onclick="pay_type_check();" checked>ī�����<br>
            <INPUT TYPE="RADIO" name="pay_type" value="3" onclick="pay_type_check();">ARSī�����
			&nbsp;<INPUT TYPE="RADIO" name="pay_type" value="4" onclick="pay_type_check();">�޴���
		  </TD>
        </TR>
		<tr height=26 id="bankName" style="display:none;">
		  <td WIDTH="83" align="center" class="darkbrown"><strong>�Ա�����</strong></td>
          <TD width=8></TD>
          <td>
			<select name='bank_name' onChange='view_bank_num();'>
				<option value=''>���༱��</option>
				<option value='�츮����'>�츮����</option>
			</select>		  
		  </td>
		</tr>
		<tr height=26 id="bankAccount" style="display:none;">
		  <td WIDTH="83" align="center" class="darkbrown"><strong>���¹�ȣ</strong></td>
		  <TD width=8></TD>
		  <td><div name="bank_num" id="bank_num">�Ա��Ͻ� ������ �����ϼ���</div></td>
		</tr>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83"  height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>������ǰ</strong></td>
          <TD width=8></TD>
          <TD>�����ְ�</TD> 
        </tr>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83"  height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>�����ݾ�</strong></td>
          <TD width=8></TD>
          <TD>
			<select name="cash">
				<option value="">�ݾ��� �����ϼ���
				<option value="11000">1���� - 11,000��								
				<option value="30000">10���� - 30,000��
				
			</select>
			<br><font color='red'>&nbsp;&nbsp;&nbsp;* �ΰ��� ���� �ݾ��Դϴ�.
		  </TD>
        </tr>
        		
      </FORM>
    </TABLE></td>
  </tr>  
  <tr>
  <td align="center" colspan="10" height="30px">
<input type="checkbox" value="T" name="chkRefund" id="chkRefund">ȯ�ұ��� ����
  </td>
  </tr>
  
  <tr>
  <td align="center" colspan="10" height="30px">
<IMG SRC="/images/btn/btn_pay_ok.gif" align="absmiddle" style="cursor:hand" border=0 onClick="pay_form_check();">&nbsp;&nbsp;<IMG SRC="/images/btn/btn_pay_cancel.gif" align="absmiddle" style="cursor:hand" border=0 onClick="window.close()">		
  </td>
  </tr>
</table>


</body>
</html>