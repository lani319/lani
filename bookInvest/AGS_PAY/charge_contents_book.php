<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

$pay_contents_idx		= trim($_POST["pay_contents_idx"]);	//�Խù� idx
$srv_code				= trim($_POST["srv_code"]);			//������ �ڵ�
?>
<html>
<head>
<title>���������� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

<script language="javascript" src="http://www.allthegate.com/plugin/AGSWallet.js"></script>
<script language="JavaScript" src="/card/basic_script.js"></script>

<?
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

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//������ idx ��ȣȭ
$expert_idx = usrCrypt(URLdecode($srv_code),0);


$sql="select bn, price , title from stBoard where idx='".$pay_contents_idx."'";
$mqf=mysql_fetch_array(mysql_query($sql));

$contents_name="���������� : ".$_PAY_BOARD_KIND_ARRAY[$mqf['bn']]." (".$pay_contents_idx."��)";
$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"idx, mobile, phone, total_coin");
if(!$meminfo[idx]){
	popupMsg(" ȸ�������� ���� ���� �ʽ��ϴ�. \r\n �ٽ��ѹ� �α����� ��õ� ���ּ���");
	echo "<script> opener.location.href='/include/logout.php' </script>";
	echo "<script> window.close(); </script>";
	exit();
}
$mobile=explode("-",$meminfo[mobile]);
$orderid=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");


if($mqf[price] <= $_COIN_SEPRATE){
	$max_coin = $mqf[price] * $_COIN_MAGNIFICATION[0];
}
else{
	$max_coin = $mqf[price] * $_COIN_MAGNIFICATION[1];
}

if($meminfo['mobile'] != '' && str_replace('-', '', $meminfo['mobile']) != ''){
	$mobile = explode('-', $meminfo['mobile']);
}
else if($meminfo['phone'] != '' && str_replace('-', '', $meminfo['phone']) != ''){
	$mobile = explode('-', $meminfo['phone']);
}
?>

</head>
<body topmargin=0 leftmargin=0 onload="javascript:Enable_Flag(pay_form);">
<img src="../img/pop/charge_contents_top.gif" width="400" height="38">
<br>


<SCRIPT>

var user_point = <?=$meminfo[total_coin] ?>;
var contents_price = <?=$mqf[price] ?>;
var max_settle_point = <?=$max_coin ?>;
var min_settle_point = <?=$_COIN_USE_MIN ?>;

function pay_type_check(){
	var form=document.pay_form;
	if(form.pay_type[0].checked==true){
		/*
		document.getElementById("mobile_area").style.display="none";
		document.getElementById("card_area").style.display="block";
		*/
	}else{
		/*
		document.getElementById("mobile_area").style.display="block";
		document.getElementById("card_area").style.display="none";
		*/
	}
}

function pay_form_check(){
	var form=document.pay_form;
	var mobile_limit_price=100000;
	var mobile_min_price=1000;
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
	if(form.pay_type[1].checked==true && mobile_limit_price < form.price.value){
		alert(mobile_limit_price + "�� �̻��� �ڵ��� ������ �Ұ��� �մϴ�.");
		return false;
	}

	if(form.spend_point.checked==true){
		form.use_point.value = Number(Math.round(form.use_point.value*0.002)*500);
		var sub_price = Number(form.use_point.value*10);

		if(form.use_point.value < min_settle_point){
			alert("������ "+min_settle_point+"���� �̻���� ����� �����մϴ�.");
			form.use_point.select();
			return false;
		}

		if(form.use_point.value > max_settle_point){
			alert("������ "+max_settle_point+"���� ������ ����� �����մϴ�.");
			form.use_point.select();
			return false;
		}
		
		/*
		if(form.use_point.value > possible_point){
			alert("�Ѵ޿� ��밡���� ���κ��� �����ϴ�.\n\n��밡�� ����: "+possible_point+" Coin");
			form.use_point.select();
			return false;
		}
		*/

		if(form.use_point.value > user_point){
			alert("�������κ��� �����ϴ�.");
			form.use_point.select();
			return false;
		}

		if(sub_price > contents_price){
			alert("�����ݾ׺��� �����ϴ�.");
			form.use_point.select();
			return false;
		}

		if(sub_price < contents_price && form.use_point.value <= max_settle_point){
			var re_price = contents_price - sub_price;
			form.price.value=re_price;							//�ڵ����������� ����ϴ� ����
			form.Amt.value=re_price;							//ī�忡�� ����ϴ� ����
			form.sub_price.value = sub_price;

		}else if(sub_price == contents_price){
			var re_price = contents_price - sub_price;
			form.price.value=re_price;							//�ڵ����������� ����ϴ� ����
			form.Amt.value=re_price;							//ī�忡�� ����ϴ� ����

			form.sub_price.value = sub_price;
			if(confirm("�����ݾ�: "+form.price.value+"��\n�������: "+form.use_point.value+"Coin\n\n���� �Ͻðڽ��ϱ�?")){
				form.action="/include/charge_contents_process_point.php";
				form.submit();
			}
			
			return false;
		}	
	}

	if(form.use_point.value){
		var point_msg = "�������: "+form.use_point.value+"Coin\n";
	}else{
		var point_msg = "";
	}

	if(form.pay_type[0].checked==true){
		if(confirm("�����ݾ�: "+form.price.value+"��\n"+point_msg+"\n���� �Ͻðڽ��ϱ�?")){
			form.action="/include/AGS_pay_ing.php";
			Pay(document.pay_form);
		}
	}
	else if(form.pay_type[1].checked==true){
		if(form.price.value < mobile_min_price){
			alert("�ּҰ����ݾ��� 1000�� �̻��Դϴ�");
			form.use_point.select();
			return false;
		}

		if(confirm("�����ݾ�: "+form.price.value+"��\n"+point_msg+"\n���� �Ͻðڽ��ϱ�?")){
			form.action="/include/charge_contents_process.php";
			form.submit();
			return true;
		}
	}
	else{
		if(confirm("�����ݾ�: "+form.price.value+"��\n"+point_msg+"\n���� �Ͻðڽ��ϱ�?")){
			form.action="/include/charge_contents_process_ars_card.php";
			form.submit();
			return true;
		}
	}
}

function point_use(checked){
	var form = document.pay_form;
	if(checked){
		form.use_point.disabled=false;
		form.use_point.style.background="white";
	}else{
		form.use_point.value="";
		form.use_point.disabled=true;
		form.use_point.style.background="silver";
	}
}

function point_check(val){
	if(val > user_point){
		alert("�������θ� �Ѿ����ϴ�");
		document.pay_form.use_point.value="";
		document.pay_form.use_point.focus();
		return false;
	}
}
</SCRIPT>
<table width="350" border="0" align="center" cellpadding="0" cellspacing="0" background="../img/pop/box350_bg.gif">
  <tr>
    <td><img src="../img/pop/box350_top.gif" width="350" height="8"></td>
  </tr>
  <tr>
    <td><TABLE width=98% border=0 align="center" cellpadding=0 CELLSPACING=0 style="border-width:0px; border-color:rgb(204,204,204); border-style:solid;">
      <FORM NAME="pay_form" METHOD="POST">
        <INPUT TYPE="HIDDEN" name="price" value="<?=$mqf[price]?>">
        <INPUT TYPE="HIDDEN" name="conidx" value="<?=$pay_contents_idx?>">
		<INPUT TYPE="HIDDEN" name="expert_idx" value="<?=$expert_idx?>">
		<INPUT TYPE="HIDDEN" name="mem_idx" value="<?=$_COOKIE['_CKE_USER_UID']?>">
		<INPUT TYPE="HIDDEN" name="sub_price">


		<!-- ī������� �ʿ��� ���� ���� -->
		<INPUT TYPE="HIDDEN" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="HIDDEN" NAME="StoreNm" value="�����̳�">
		<INPUT TYPE="HIDDEN" NAME="OrdNo" value="<?=$pay_contents_idx?>">  <!-- stBoard���̺��� idx�� -->
		<INPUT TYPE="HIDDEN" NAME="ProdNm" value="<?=$contents_name?>">
		<INPUT TYPE="HIDDEN" NAME="Amt" value="<?=$mqf[price]?>">
		<INPUT TYPE="HIDDEN" NAME="MallUrl" value="http://www.502.co.kr">
		<INPUT TYPE="HIDDEN" NAME="Remark" value="����">
		<INPUT TYPE="HIDDEN" NAME="Job" value="onlycard">
		<INPUT TYPE="HIDDEN" NAME="UserId" value="<?=$_COOKIE['_CKE_USER_ID']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="OrdAddr" value="����">
		<INPUT TYPE="HIDDEN" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="RcpPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="DlvAddr" value="����">
		<INPUT TYPE="HIDDEN" NAME="UserEmail" value="<?=$_COOKIE['_CKE_USER_EMAIL']?>">


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
          <TD WIDTH="83" align="center" class="darkbrown"><strong>������</strong></TD>
          <TD width=8></TD>
          <TD width="250"><INPUT TYPE="TEXT" name="username" value="<?=$_COOKIE['_CKE_USER_NAME']?>" class="input01" style="width:120"></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD WIDTH="83" align="center" class="darkbrown"><strong>��ȭ��ȣ</strong></TD>
          <TD width=8></TD>
          <TD>
		    <input name="mobile1" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[0]?>">
			&nbsp;-&nbsp;
            <input name="mobile2" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[1]?>">
            &nbsp;-&nbsp;
            <input name="mobile3" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[2]?>"></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD align="center" WIDTH="83"><strong>�������</strong></TD>
          <TD width=8></TD>
          <TD><INPUT TYPE="RADIO" name="pay_type" value="1">ī�����
            <INPUT TYPE="RADIO" name="pay_type" value="2" checked>�ڵ�������
            <INPUT TYPE="RADIO" name="pay_type" value="3">ARSī�����</TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><strong>������ǰ</strong></td>
          <TD width=8></TD>
          <TD><?=$contents_name?></TD>
        </tr>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><strong>�����ݾ�</strong></td>
          <TD width=8></TD>
          <TD><?=number_format($mqf[price]);?>
            ��</TD>
        </tr>

        <tr>
          <td bgcolor="#D5D2CD" height=1 colspan=3></td>
        </tr>

		<tr height=26>
          <td colspan=3 class="darkbrown" style="padding-left:10px"><strong>�ּ�:<?=Number_format($_COIN_USE_MIN)?> Coin</strong>, <strong>�ִ�:<?=Number_format($max_coin)?> Coin</strong> ��������<br> <strong>500 Coin����</strong>�� ����</td>
        </tr>
		
		<tr>
          <td bgcolor="#D5D2CD" height=1 colspan=3></td>
        </tr>

		<tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><strong>��������</strong></td>
          <TD width=8></TD>
          <TD>
			<?=number_format($meminfo[total_coin])?> Coin &nbsp;(1Coin=10��)
		  </TD>
        </tr>
		<tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><input type="checkbox" name="spend_point" value="Y" onclick="Javascript:point_use(this.checked)" <? if($meminfo[total_coin] < $_COIN_USE_MIN || !month_by_point_check($_COOKIE[_CKE_USER_UID])) echo "disabled"; ?>><strong>����ϱ�</strong></td>
          <TD width=8></TD>
          <TD>
				<input type="text" name="use_point" size="14" onKeyPress="onlyNumber()" maxlength="6" class="input01" disabled onKeyup="Javascript:point_check(this.value);" style="background:silver">
		  </TD>
        </tr>
	</TABLE></td>
  </tr>
  <tr>
    <td><img src="../img/pop/box350_btm.gif" width="350" height="8"></td>
  </tr>
</table>
<TABLE CELLSPACING=0 cellpadding=0 border=0 width=100%>
<TR>
	<TD align=center>&nbsp;</TD>
</TR>
<TR height=40 align=center>
	<TD>
		<IMG SRC="/images/btn/btn_pay_ok.gif" align="absmiddle" style="cursor:hand" border=0 onClick="pay_form_check()">&nbsp;&nbsp;<IMG SRC="/images/btn/btn_pay_cancel.gif" align="absmiddle" style="cursor:hand" border=0 onClick="window.close()">
		
	</TD>
</TR>
</TABLE>
</body>
</html>