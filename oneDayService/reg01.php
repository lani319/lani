<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$todayMonth = date('n');
$todayDay = date('d');
$monthSelect = "";
$daySelect = "";


//ȸ�� ������ �����´�.
//�̸�,�ʸ�,����ó,�ּ�

$userIdx = $_COOKIE['_CKE_USER_UID'];


$sql = "select idx, userName,userNickname,mobile,address1,address2 from Member where idx = $userIdx and gradeLevel IN (0,1)";

$tmpRs = mysql_query($sql);

$rs = mysql_fetch_array($tmpRs);

if ($rs[idx]==null){ 
	popupMsg("���� ȸ���� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

$mobile1 = substr($rs[mobile],0,3);
$mobile2 = substr($rs[mobile],4,4);
$mobile3 = substr($rs[mobile],9,4);

$mobile = $mobile1."-".$mobile2."-".$mobile3;

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}
?>


<html>
<title> ::: ���� ��û ������ ::: </title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
<link rel="stylesheet" type="text/css" href="http://www.502.co.kr/css/nara.css">
-->



<style type="text/css">
/*<![CDATA[*/
table.t_ex2 {background:#FFFFFF; width:700px; margin:0 auto; text-align:left}
.t_ex2 td, .t_ex2 th {border:1px solid #AAAAAA;padding:10px}
.t_ex2 th {background:#DCDCDC; color:#5C5C5C; text-align:center}
table.t_ex2 .c1 {text-align:center}
table.t_ex2 .c2 {text-align:left}

table.t_ex0 {background:#FFFFFF; width:700px; margin:0 auto; text-align:left;border=0;}

/*]]>*/
</style>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

<script language="javascript" src="http://www.allthegate.com/plugin/AGSWallet.js"></script>

<script language=javascript>
<!--
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// �ô�����Ʈ �÷����� ��ġ�� Ȯ���մϴ�.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

StartSmartUpdate();  

function Pay(form){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MakePayMessage() �� ȣ��Ǹ� �ô�����Ʈ �÷������� ȭ�鿡 ��Ÿ���� Hidden �ʵ�
	// �� ���ϰ����� ä������ �˴ϴ�.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(form.Flag.value == "enable"){
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// �Էµ� ����Ÿ�� ��ȿ���� �˻��մϴ�.
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if(Check_Common(form) == true){
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// �ô�����Ʈ �÷����� ��ġ�� �ùٸ��� �Ǿ����� Ȯ���մϴ�.
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if(document.AGSPay == null || document.AGSPay.object == null){
				alert("�÷����� ��ġ �� �ٽ� �õ� �Ͻʽÿ�.");
			}else{
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// �ô�����Ʈ �÷����� �������� �������� �����ϱ� JavaScript �ڵ带 ����ϰ� �ֽ��ϴ�.
				// ���������� �°� JavaScript �ڵ带 �����Ͽ� ����Ͻʽÿ�.
				//
				// [1] �Ϲ�/������ ��������
				// [2] �Ϲݰ����� �Һΰ�����
				// [3] �����ڰ����� �Һΰ����� ����
				// [4] ��������
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [1] �Ϲ�/������ �������θ� �����մϴ�.
				//
				// �Һ��Ǹ��� ��� �����ڰ� ���ڼ����Ḧ �δ��ϴ� ���� �⺻�Դϴ�. �׷���,
				// ������ �ô�����Ʈ���� ���� ����� ���ؼ� �Һ����ڸ� ���������� �δ��� �� �ֽ��ϴ�.
				// �̰�� �����ڴ� ������ �Һΰŷ��� �����մϴ�.
				//
				// ����)
				// 	(1) �Ϲݰ����� ����� ���
				// 	form.DeviId.value = "9000400001";
				//
				// 	(2) �����ڰ����� ����� ���
				// 	form.DeviId.value = "9000400002";
				//
				// 	(3) ���� ���� �ݾ��� 100,000�� �̸��� ��� �Ϲ��Һη� 100,000�� �̻��� ��� �������Һη� ����� ���
				// 	if(parseInt(form.Amt.value) < 100000)
				//		form.DeviId.value = "9000400001";
				// 	else
				//		form.DeviId.value = "9000400002";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				form.DeviId.value = "9000400001";
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [2] �Ϲ� �ҺαⰣ�� �����մϴ�.
				// 
				// �Ϲ� �ҺαⰣ�� 2 ~ 12�������� �����մϴ�.
				// 0:�Ͻú�, 2:2����, 3:3����, ... , 12:12����
				// 
				// ����)
				// 	(1) �ҺαⰣ�� �ϽúҸ� �����ϵ��� ����� ���
				// 	form.QuotaInf.value = "0";
				//
				// 	(2) �ҺαⰣ�� �Ͻú� ~ 12�������� ����� ���
				//		form.QuotaInf.value = "0:3:4:5:6:7:8:9:10:11:12";
				//
				// 	(3) �����ݾ��� ���������ȿ� ���� ��쿡�� �Һΰ� �����ϰ� �� ���
				// 	if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
				// 		form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				// 	else
				// 		form.QuotaInf.value = "0";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//�����ݾ��� 5���� �̸����� �Һΰ����� ��û�Ұ�� ��������
				if(parseInt(form.Amt.value) < 50000)
					form.QuotaInf.value = "0";
				else
					form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [3] ������ �ҺαⰣ�� �����մϴ�.
				// (�Ϲݰ����� ��쿡�� �� ������ ������� �ʽ��ϴ�.)
				// 
				// ������ �ҺαⰣ�� 2 ~ 12�������� �����ϸ�, 
				// �ô�����Ʈ���� ������ �Һ� ������������ �����ؾ� �մϴ�.
				// 
				// 100:BC
				// 200:����
				// 300:��ȯ
				// 400:�Ｚ
				// 500:����
				// 600:����
				// 800:����
				// 900:�Ե�
				// 
				// ����)
				// 	(1) ��� �Һΰŷ��� �����ڷ� �ϰ� ���������� ALL�� ����
				// 	form.NointInf.value = "ALL";
				//
				// 	(2) ����ī�� Ư���������� �����ڸ� �ϰ� ������� ����(2:3:4:5:6����)
				// 	form.NointInf.value = "200-2:3:4:5:6";
				//
				// 	(3) ��ȯī�� Ư���������� �����ڸ� �ϰ� ������� ����(2:3:4:5:6����)
				// 	form.NointInf.value = "300-2:3:4:5:6";
				//
				// 	(4) ����,��ȯī�� Ư���������� �����ڸ� �ϰ� ������� ����(2:3:4:5:6����)
				// 	form.NointInf.value = "200-2:3:4:5:6,300-2:3:4:5:6";
				//	
				//	(5) ������ �ҺαⰣ ������ ���� ���� ��쿡�� NONE�� ����
				//	form.NointInf.value = "NONE";
				//
				//	(6) ��ī��� Ư���������� �����ڸ� �ϰ� �������(2:3:6����)
				//	form.NointInf.value = "100-2:3:6,200-2:3:6,300-2:3:6,400-2:3:6,500-2:3:6,600-2:3:6,800-2:3:6,900-2:3:6";
				//
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				if(form.DeviId.value == "9000400002")
					form.NointInf.value = "ALL";
				   
				if(MakePayMessage(form) == true){
					Disable_Flag(form);
					
					var openwin = window.open("AGS_progress.html","popup","width=300,height=160"); //"����ó����"�̶�� �˾�â���� �κ�
					
					form.submit();
				}else{
					alert("���ҿ� �����Ͽ����ϴ�.");// ��ҽ� �̵������� �����κ�
				}
			}
		}
	}
}

function Enable_Flag(form){
        form.Flag.value = "enable"
}

function Disable_Flag(form){
        form.Flag.value = "disable"
}

function Check_Common(form){
	if(form.StoreId.value == ""){
		alert("�������̵� �Է��Ͻʽÿ�.");
		return false;
	}
	else if(form.StoreNm.value == ""){
		alert("�������� �Է��Ͻʽÿ�.");
		return false;
	}
	else if(form.OrdNo.value == ""){
		alert("�ֹ���ȣ�� �Է��Ͻʽÿ�.");
		return false;
	}
	else if(form.ProdNm.value == ""){
		alert("��ǰ���� �Է��Ͻʽÿ�.");
		return false;
	}
	else if(form.Amt.value == ""){
		alert("�ݾ��� �Է��Ͻʽÿ�.");
		return false;
	}
	else if(form.MallUrl.value == ""){
		alert("����URL�� �Է��Ͻʽÿ�.");
		return false;
	}
	return true;
}

function Display(form){
	if(form.Job.value == "onlycard" || form.TempJob.value == "onlycard"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyhp" || form.TempJob.value == "onlyhp"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyvirtual" || form.TempJob.value == "onlyvirtual" ||
			 form.Job.value == "onlyvirtualself" || form.TempJob.value == "onlyvirtualself"){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "";
	}else if(form.Job.value == "onlyiche" || form.TempJob.value == "onlyiche" || 
			 form.Job.value == "onlyicheself" || form.TempJob.value == "onlyicheself" || 
			 form.Job.value == "onlyichewoori" || form.TempJob.value == "onlyichewoori" || 
			 form.Job.value == "onlyvirtualwoori" || form.TempJob.value == "onlyvirtualwoori"){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else{
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "";
	}
}
-->
</script>

<script type="text/javascript">
function showDiv(idMyDiv){ //2�������� �����ִ°�

	hideDiv();

     var objDiv = document.getElementById(idMyDiv);

     if(objDiv.style.display=="block"){ objDiv.style.display = "none"; }
     else{ objDiv.style.display = "block"; }
}


function hideDiv() { //2�� ������ ����� ��
	var objDiv = document.getElementById('area0')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area1')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area2')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area3')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area4')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area5')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area6')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area7')
	objDiv.style.display = "none";
	
	var objDiv = document.getElementById('area8')
	objDiv.style.display = "none";
	
	
}


function showPrice(value){

	if(value=='area1'||value=='area2'||value=='area3'||value=='area4'||value=='area5'||value=='area6'||value=='area7'||value=='area8')
	{
		showDiv(value);
	}
	else{
		//������ ������ ������
		var form = document.frmAGS_pay;
		document.getElementById('price').value=0;
		document.getElementById('price').value=value;
		form.Amt.value = value; //ī�� ������ ���� ����
	}
}



function chkForm()
{
	var form = document.frmAGS_pay;
	
	if(document.getElementById("mobile1").value==""){alert("����ó�� �Է��� �ּ���");return false;}
	if(document.getElementById("mobile2").value==""){alert("����ó�� �Է��� �ּ���");return false;}
	if(document.getElementById("mobile3").value==""){alert("����ó�� �Է��� �ּ���");return false;}
	
	if(document.getElementById("address1").value==""){alert("�ּҸ� �Է��� �ּ���");return false;}
	if(document.getElementById("address2").value==""){alert("�ּҸ� �Է��� �ּ���");return false;}
		
	if(document.getElementById("selectArea1").value==""){alert("������ ������ �ּ���.");return false;}
	
	if(document.getElementById("agreeTrue").checked==""){alert("������ ������׿� �������� ������,���� �̿��� �Ұ����մϴ�.");return false;}
	
	//���� ������ üũ
	if(document.getElementById("rdReceipt01").checked){
		if(document.getElementById("receipt").value==""){
			alert("���ݿ����� ����� ���� ��ȣ�� �Է��� �ּ���");			
			return false;
		}
	}
	if(document.getElementById("rdReceipt02").checked){
		if(document.getElementById("receipt").value==""){
			alert("���ݿ����� ����� ���� ��ȣ�� �Է��� �ּ���");
			
			return false;
		}
	}
	
	form.ProdNm.value = "1�� ����";
	
	var payMethod = document.getElementById("payMethod").value;
	
	if(payMethod == "CARD"){
		form.action = "card_pay_ing.php";				
		Pay(document.frmAGS_pay); 
	}else if(payMethod == "ARS"){
		form.action = "ars_pay_ing.php";		
		form.submit();
	}else if(payMethod == "BANK"){
		form.action = "bank_pay_ing.php";		
		form.submit();
	}
	
}

function chkPay(value){
	document.getElementById("payMethod").value = value;
	if(value == "BANK"){		
	document.getElementById('payReceipt').style.display = "block";
	}else{
		document.getElementById('payReceipt').style.display = "none";
		document.getElementById('payReceipt').style.display = "none";
	}
	
}
</script>



</head>
<body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0 onload="javascript:Enable_Flag(frmAGS_pay);">
<form name=frmAGS_pay method=post action=AGS_pay_ing.php>
<input type="hidden" name="userName" value=<?=$rs[userName]?>>
<input type="hidden" name="userNickname" value=<?=$rs[userNickname]?>>
<input type="hidden" name="userIdx" value=<?=$userIdx?>>
<input type="hidden" name="payMethod" id="payMethod" value="CARD">


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
		<INPUT TYPE="HIDDEN" NAME="OrdPhone" value="<?=$mobile?>">
		<INPUT TYPE="HIDDEN" NAME="OrdAddr" value="����">
		<INPUT TYPE="HIDDEN" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="RcpPhone" value="<?=$mobile?>">
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
		
		
<table class="t_ex2">
<tr>
<th class="c1" width="100px">ȸ������</td>
<td><b><?=$rs[userName]?>(<?=$rs[userNickname]?>)</b></td>
</tr>

<tr>
<th class="c1">����ó</td>
<td>
<input type="text" name="mobile1" id="mobile1" size=3 style="font-size:18px;" value="<?=$mobile1?>" maxlength=3>
-
<input type="text" name="mobile2" id="mobile2" size=4 style="font-size:18px;" value="<?=$mobile2?>" maxlength=4>
-
<input type="text" name="mobile3" id="mobile3" size=4 style="font-size:18px;" value="<?=$mobile3?>" maxlength=4>
<b>����ó ������ �ʿ��ϸ� �Է� �� �ּ���.
</td>
</tr>

<tr>
<th class="c1">��������</td>
</td>
<td>
	<table>
	<tr>
	<td>
	<select style="width:150px;font-size:20px;" name="selectArea1" id="selectArea1" onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='100000'>����Ư����</option>
	<option value='150000'>���ֱ�����</option>
	<option value='150000'>�뱸������</option>
	<option value='100000'>����������</option>
	<option value='200000'>�λ걤����</option>
	<option value='100000'>����Ư����ġ��</option>
	<option value='200000'>��걤����</option>
	<option value='100000'>��õ������</option>
	<option></option>
	<option value='area1'>��⵵</option>
	<option value='area2'>������</option>
	<option value='area3'>��û����</option>
	<option value='area4'>��û�ϵ�</option>
	<option value='area5'>����ϵ�</option>
	<option value='area6'>���󳲵�</option>
	<option value='area7'>���ϵ�</option>
	<option value='area8'>��󳲵�</option>
	</select>
	</td>
	<td>
	<div id="area0">
	<select style="width:150px;font-size:18px">
	<option>----</option>
	</select>
	</div>
	
	<!-- ��⵵ -->
	<div id="area1"style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea2" onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='130000'>����</option>
	<option value='130000'>����</option>
	<option value='100000'>��õ��</option>
	<option value='130000'>�����</option>
	<option value='100000'>���ֽ�</option>
	<option value='130000'>������</option>
	<option value='100000'>������</option>
	<option value='130000'>������</option>
	<option value='130000'>�����ֽ�</option>
	<option value='130000'>����õ��</option>
	<option value='130000'>��õ��</option>
	<option value='100000'>������</option>
	<option value='100000'>������</option>
	<option value='130000'>�����</option>
	<option value='100000'>�Ȼ��</option>
	<option value='100000'>�ȼ���</option>
	<option value='100000'>�Ⱦ��</option>
	<option value='130000'>���ֽ�</option>
	<option value='130000'>����</option>
	<option value='130000'>���ֽ�</option>
	<option value='130000'>��õ��</option>
	<option value='100000'>�����</option>
	<option value='100000'>���ν�</option>
	<option value='100000'>�ǿս�</option>
	<option value='130000'>�����ν�</option>
	<option value='130000'>��õ��</option>
	<option value='130000'>���ֽ�</option>
	<option value='100000'>���ý�</option>
	<option value='130000'>��õ��</option>
	<option value='130000'>�ϳ���</option>
	<option value='100000'>ȭ����</option>
	</select>
	</div>

	<!-- ������ -->
	<div id="area2"style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea3" onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='150000'>������</option>
	<option value='180000'>����</option>
	<option value='180000'>���ؽ�</option>
	<option value='180000'>��ô��</option>
	<option value='180000'>���ʽ�</option>
	<option value='150000'>�籸��</option>
	<option value='180000'>��籺</option>
	<option value='130000'>������</option>
	<option value='130000'>���ֽ�</option>
	<option value='150000'>������</option>
	<option value='150000'>������</option>
	<option value='130000'>ö����</option>
	<option value='130000'>��õ��</option>
	<option value='150000'>�¹��</option>
	<option value='130000'>��â��</option>
	<option value='130000'>ȫõ��</option>
	<option value='150000'>ȭõ��</option>
	<option value='130000'>Ⱦ����</option>
	</select>
	</div>

	<!-- ��û���� -->
	<div id="area3" style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea4"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='130000'>����</option>
	<option value='130000'>���ֽ�</option>
	<option value='130000'>�ݻ걺</option>
	<option value='130000'>����</option>
	<option value='100000'>������</option>
	<option value='130000'>���ɽ�</option>
	<option value='130000'>�ο���</option>
	<option value='130000'>�����</option>
	<option value='130000'>��õ��</option>
	<option value='100000'>�ƻ��</option>
	<option value='100000'>���걺</option>
	<option value='100000'>õ�Ƚ�</option>
	<option value='130000'>û�籺</option>
	<option value='130000'>�¾ȱ�</option>
	<option value='130000'>ȫ����</option>
	</select>
	</div>

	<!-- ��û�ϵ� -->
	<div id="area4"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea5"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='130000'>���걺</option>
	<option value='130000'>�ܾ籺</option>
	<option value='130000'>������</option>
	<option value='130000'>������</option>
	<option value='130000'>��õ��</option>
	<option value='100000'>������</option>
	<option value='130000'>��õ��</option>
	<option value='100000'>����</option>
	<option value='100000'>��õ��</option>
	<option value='100000'>û�ֽ�</option>
	<option value='130000'>���ֽ�</option>
	</select>
	</div>

	<!-- ����ϵ� -->
	<div id="area5" style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea6"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='150000'>��â��</option>
	<option value='130000'>�����</option>
	<option value='130000'>������</option>
	<option value='150000'>������</option>
	<option value='130000'>���ֱ�</option>
	<option value='130000'>�ξȱ�</option>
	<option value='150000'>��â��</option>
	<option value='130000'>���ֱ�</option>
	<option value='130000'>�ͻ��</option>
	<option value='130000'>�ӽǱ�</option>
	<option value='150000'>�����</option>
	<option value='130000'>���ֽ�</option>
	<option value='150000'>������</option>
	<option value='130000'>���ȱ�</option>
	</select>
	</div>

	<!-- ���󳲵� -->
	<div id="area6"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea7"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='200000'>������</option>
	<option value='200000'>���ﱺ</option>
	<option value='150000'>���</option>
	<option value='180000'>�����</option>
	<option value='150000'>���ʱ�</option>
	<option value='180000'>���ֽ�</option>
	<option value='150000'>��籺</option>
	<option value='180000'>������</option>
	<option value='180000'>���ȱ�</option>
	<option value='200000'>������</option>
	<option value='180000'>��õ��</option>
	<option value='180000'>������</option>
	<option value='150000'>������</option>
	<option value='180000'>���ϱ�</option>
	<option value='200000'>�ϵ���</option>
	<option value='150000'>�强��</option>
	<option value='200000'>���ﱺ</option>
	<option value='180000'>������</option>
	<option value='180000'>����</option>
	<option value='200000'>�س���</option>
	<option value='180000'>ȭ����</option>	
	</select>
	</div>

	<!-- ���ϵ� -->
	<div id="area7"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea8"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='150000'>����</option>
	<option value='180000'>���ֽ�</option>
	<option value='150000'>��ɱ�</option>
	<option value='150000'>���̽�</option>
	<option value='150000'>������</option>
	<option value='130000'>��õ��</option>
	<option value='130000'>�����</option>
	<option value='150000'>��ȭ��</option>
	<option value='130000'>���ֽ�</option>
	<option value='150000'>���ֱ�</option>
	<option value='150000'>�ȵ���</option>
	<option value='150000'>������</option>
	<option value='150000'>���籺</option>
	<option value='130000'>���ֽ�</option>
	<option value='180000'>��õ��</option>
	<option value='150000'>��õ��</option>
	<option value='150000'>������</option>
	<option value='150000'>�Ǽ���</option>
	<option value='180000'>û����</option>
	<option value='150000'>û�۱�</option>
	<option value='150000'>ĥ�</option>
	<option value='180000'>���׽�</option>
	</select>
	</div>

	<!-- ��󳲵� -->
	<div id="area8"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea9"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='180000'>������</option>
	<option value='150000'>��â��</option>
	<option value='180000'>����</option>
	<option value='180000'>���ؽ�</option>
	<option value='200000'>���ر�</option>
	<option value='180000'>�о��</option>
	<option value='180000'>��õ��</option>
	<option value='150000'>��û��</option>
	<option value='200000'>����</option>
	<option value='180000'>�Ƿɱ�</option>
	<option value='180000'>���ֽ�</option>
	<option value='150000'>â�籺</option>
	<option value='180000'>â����</option>
	<option value='180000'>�뿵��</option>
	<option value='180000'>�ϵ���</option>
	<option value='180000'>�Ծȱ�</option>
	<option value='150000'>�Ծ籺</option>
	<option value='150000'>��õ��</option>
	</select>
	</div>
	</td>
	</td>
	</table>	
	
</td>
</tr>

<tr>
<th class="c1">����</td>
<td>
<input type="TEXT" id="price" name="price" value=0 style="width:80px;font-size:18px;align:right;" readonly>��
</td>
</tr>

<tr>
<th class="c1">�ּ�</td>
<td>
<input type="text" name="address1" id="address1" style="width:300px;font-size:18px;" value="<?=$rs[address1]?>">
<input type="text" name="address2" id="address2" style="width:200px;font-size:18px;" value="<?=$rs[address2]?>">
<br><b>��� ������ �ʿ��ϸ� �Է��� �ּ���.</b>
</td>
</tr>

<tr>
<th class="c1">�����¥1</td>
<td>
<select name="month1" style="width:80px;font-size:18px;">
<?php
for($i=0;$i<11;$i++){
	$monthSelect = "";
if($todayMonth == $i+1)	{
	$monthSelect=" selected";
}
?>
<option value="<?=$i+1?>" <?=$monthSelect?>><?=$i+1?>��</option>
<?php
}
?>
</select>

<select name="day1" style="width:80px;font-size:18px;">
<?php
for($i=0;$i<30;$i++){	
	$daySelect = "";	
if($todayDay == $i+1)	{
	$daySelect=" selected";
}
?>
<option value="<?=$i+1?>"  <?=$daySelect?>><?=$i+1?>��</option>
<?php
}
?>
</select>
<select name="time1" style="width:80px;font-size:18px;">
<?php
for($i=9;$i<17;$i++){	
?>
<option value="<?=$i+1?>"><?=$i+1?>��</option> 
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th class="c1">�����¥2</td>
<td>
<select name="month2" style="width:80px;font-size:18px;">
<?php
for($i=0;$i<11;$i++){	
	$monthSelect = "";
if($todayMonth == $i+1)	{
	$monthSelect=" selected";
}
?>
<option value="<?=$i+1?>" <?=$monthSelect?>><?=$i+1?>��</option>
<?php
}
?>
</select>

<select name="day2" style="width:80px;font-size:18px;">
<?php
for($i=0;$i<30;$i++){	
	$daySelect = "";	
if($todayDay == $i+1)	{
	$daySelect=" selected";
}
?>
<option value="<?=$i+1?>" <?=$daySelect?>><?=$i+1?>��</option>
<?php
}
?>
</select>
<select name="time2" style="width:80px;font-size:18px;">
<?php
for($i=9;$i<17;$i++){	
?>
<option value="<?=$i+1?>"><?=$i+1?>��</option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th class="c1">���� �� <br>�������</td>
<td>

1. ��û�ڿ� ��� ���� �䱸���� ������ �� �Ǹ� ����� �� �ֽ��ϴ�.<br>
 *��� ������� �����ϴ�.<br>
<br>
2. �� ��ǰ�� ���� ������ ����� �Ұ����մϴ�.<br>
<br>
3. �� ��ǰ�� ���۱ǿ� ��߳��� ��/���� S/W ��ġ�� �������� �ʽ��ϴ�.<br>
<br>
4. ��û�ڿ� ��� ���� ��� ��ȭ ������ �����Ͽ� �����˴ϴ�.<br>
<br>
5. ī�������� �� ó�� �Ⱓ�� �ִ� ������ �ҿ�� �� �ֽ��ϴ�.<br>
<br>
6. ������ �Ա� ��Ҵ� ����� ��� �� �ٷ� ó���˴ϴ�.<br>
<br>
7. �� ��ǰ�� ���ϸ� �̿� �����մϴ�.<br>
<br>
8. ��û �� 24�ð� �̳��� ��ڰ� Ȯ���� �����帳�ϴ�.<br>

</td>
</tr>
<tr>
<th class="c1">���ǿ���</td>
<td><b>���� �� ������׿� ���� �Ͻʴϱ�?</b>
<br>
<input type="radio" name="agree" id="agreeTrue" value="True">��. �����մϴ�.&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="agree" value="False" checked>�ƴϿ�. �������� �ʽ��ϴ�.&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr>
<th class="c1">��������</td>
<td>
<input type="radio" name="payMethod" onclick="chkPay('CARD');" value="CARD" checked>�ſ�ī��
<input type="radio" name="payMethod" onclick="chkPay('ARS');" value="ARS">ARS ī�����
<input type="radio" name="payMethod" onclick="chkPay('BANK');" value="BANK">������
<br>
<div id="payReceipt"  style="display:none;">
<br>
<b>���ݿ�����</b> <br>

 <input type="radio" name="rdReceipt" id="rdReceipt01" value="01">���� �ҵ������:&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdReceipt" id="rdReceipt02" value="02">����� ����������: &nbsp;&nbsp;&nbsp;
<input type="radio" name="rdReceipt" value="none" checked>���ݿ����� ���� : 
<br>
<input type="number" name="receiptNumber" id="receipt" size=20 style="font-size:18px;" value="">
<br>
*�ҵ������ : �ڵ�����ȣ, ���ݿ����� ī���ȣ<br>
*���������� : ����� ��Ϲ�ȣ
</div>
</td>
</tr>
<tr>
<td colspan=2 align="center">
<input type="button" onclick=chkForm(); value="���� ��û" style="width:300px;height=100px;font-size:20px;">
</td>
</tr>
</table>

</form>
</body>
</html>