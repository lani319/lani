<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

?>
<html>
<head>
<title>�����ְ� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>
<script language="javascript" src="http://www.allthegate.com/plugin/AGSWallet.js"></script>
<script language="JavaScript" src="/card/basic_script.js"></script>
<script type="text/javascript">
<!--
	function pay_type_check(){
	var form=document.pay_form;
		if(form.pay_type[0].checked==true){		
			document.getElementById("bankName").style.display="block";
			document.getElementById("bankAccount").style.display="block";
			document.getElementById("bankmobile").style.display="block";
		}else{
			document.getElementById("bankName").style.display="none";
			document.getElementById("bankAccount").style.display="none";
			document.getElementById("bankmobile").style.display="none";
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

	function priceCk(price,value){
		document.getElementById('price').value = price;
		document.pay_form.ProdNm.value = value+'����';
	}

	function pay_check(){
		var form=document.pay_form;
		if(form.pay_type[0].checked==true){		
			if(form.bank_name.value==''){
				alert('�Ա������� �����ϼ���');
				return false;
			}

			if(form.mobile1.value=='' || form.mobile2.value=='' || form.mobile3.value==''){
				alert('��ȭ��ȣ�� �Է��ϼ���');
				form.mobile1.focus();
				return false;
			}
		
		}else if(form.pay_type[3].checked==true){
			if(form.jokmok[2].checked==true){
				alert('100000�� �̻��� �޴������� ������ �Ұ����մϴ�.');
				return false;
			}
		}

		var t_price = document.getElementById('price').value;
		if(confirm('�����ݾ� '+t_price+'�� �����Ͻðڽ��ϱ�?')){
			if(form.pay_type[0].checked==true){
				form.action="/lani/jongmokValue/bank_pay_ing.php";
				form.submit();
				return true;
			}else if(form.pay_type[1].checked==true){
				form.action="/lani/jongmokValue/ars_pay_ing.php";
				form.submit();
				return true;
			}else if(form.pay_type[2].checked==true){
				form.action="/lani/jongmokValue/card_pay_ing.php";
				form.Amt.value = t_price;
				Pay(document.pay_form);
				return true;
			}else if(form.pay_type[3].checked==true){
				form.action="/lani/jongmokValue/mobile_pay_ing.php";
				form.submit();
				return true;
			}

		}

	}

//-->
</script>
<link rel="stylesheet" type="text/css" href="css/jongmokValueStyle.css">
</head>
<?

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"mobile");
$mobile=explode("-",$meminfo[mobile]);
?>
<!-- 
������ �Ա�, �ſ�ī��, ARSī�����, �ڵ��� �̷��� 4���� ��������� �����ϴ� ������ �Դϴ�. 

1) ������� ����
2) �����ݾ� ����


�������)
�������Ա�, �ſ�ī��, ARSī����� , �ڵ��� ����

�����ݾ�)
1���� -  11,000��
5���� -  55,000��
10���� - 110,000��

*�ΰ��� ���� �ݾ��Դϴ�. 

database
���̺� �̸� : jongmokValueChargeInfo
Į�� : 
idx : index, �ڵ�����
memIdx : ������ idx
price : ��������
buy_no : ���Ź�ȣ (���Ź�ȣ ���� ������ ���� �Է�)
state : �������� (������ �ԱݿϷ�, �ſ�ī�� ��� ���)
signdate : ���� ��û��¥�� �ð�
paydate : ���� �Ϸᳯ¥�� �ð�
cardName : �ſ�ī���� ��� ī���̸�
cardNumber : �ſ�ī�� ���ι�ȣ
-->
<body topmargin=0 leftmargin=0 onload="javascript:Enable_Flag(pay_form);">
<div style="width:760px; border:1px solid;">
	<form name="pay_form" method="post">
		<input type="hidden" name="price" id="price" value="11000">
		<input type="hidden" name="mem_idx" id="mem_idx" value="<?php echo $_COOKIE['_CKE_USER_UID']; ?>">
		<input type="hidden" name="bank" id="bank" value="">
		<input type="hidden" name="b_name" id="b_name" value="">

		<!-- ī������� �ʿ��� ���� ���� -->
		<INPUT TYPE="HIDDEN" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="HIDDEN" NAME="StoreNm" value="�����̳�">
		<INPUT TYPE="HIDDEN" NAME="OrdNo" value="<?=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");?>">  <!-- service_kind���̺��� orderID -->
		<INPUT TYPE="HIDDEN" NAME="ProdNm" value="1">
		<INPUT TYPE="HIDDEN" NAME="Amt" value="11000">
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
		<table width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr>
				<td width="15%">��������)</td>
				<td><input type="radio" name="pay_type"  value="1" onclick="pay_type_check();">�������Ա�&nbsp;&nbsp;&nbsp;<input type="radio" name="pay_type" value="2" onclick="pay_type_check();">ARS&nbsp;&nbsp;&nbsp;<input type="radio" name="pay_type" value="3" onclick="pay_type_check();" checked>�ſ�ī��&nbsp;&nbsp;&nbsp; <input type="radio" name="pay_type" value="4" onclick="pay_type_check();">�޴���&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td>�����ݾ�)</td>
				<td>
					<input type="radio" name="jokmok" id="jokmok" value="1" onclick="priceCk('11000',this.value)" checked>1���� - 11,000��<br>
					<!--
					<input type="radio" name="jokmok" id="jokmok" value="5" onclick="priceCk('55000',this.value)">5���� - 55,000��<br>
					-->
					<input type="radio" name="jokmok" id="jokmok" value="10" onclick="priceCk('30000',this.value)">10���� - 30,000��<br>
				</td>
			</tr>
			<tr id="bankName" style="display:none;">
				<td>�Ա�����)</td>
				<td>&nbsp;
					<select name='bank_name' onChange='view_bank_num();'>
						<option value=''>���༱��</option>
						<option value='�츮����'>�츮����</option>
					</select>
				</select>		
				</td>
			</tr>
			<tr id="bankAccount" style="display:none;">
				<td>���¹�ȣ</td>
				<td><div name="bank_num" id="bank_num">&nbsp;�Ա��Ͻ� ������ �����ϼ���</div></td>
			</tr>
			<tr id="bankmobile" style="display:none;">
				<td>��ȭ��ȣ<br>(���ݿ���������)</td>
				<td>
					&nbsp;
					<input name="mobile1" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[0]?>">
					&nbsp;-&nbsp;
					<input name="mobile2" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[1]?>">
					&nbsp;-&nbsp;
					<input name="mobile3" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[2]?>"><br>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><b><a href="#" onclick="pay_check(); return false;">�����ϱ�</a></b></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>