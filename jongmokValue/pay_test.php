<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

?>
<html>
<head>
<title>적정주가 결제</title>
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
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$contents_name="502포인트 충전";
$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"idx, mobile, phone, total_point");
if(!$meminfo[idx]){
	popupMsg(" 회원정보가 존재 하지 않습니다. \r\n 다시한번 로그인후 재시도 해주세요");
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
		alert("결제자 이름을 입력 해주세요");
		form.username.focus();
		return false;
	}
	if(form.mobile1.value=="" || form.mobile2.value=="" || form.mobile3.value==""){
		alert("전화번호를 입력 해주세요");
		form.mobile1.focus();
		return false;
	}
	
	if(form.cash.value == ''){
		alert("결제 금액을 선택하세요.");
		return false;
	}
	//환불규정 체크 추가 , 평택촌놈 어윤학 1028
	if(!document.getElementById('chkRefund').checked)
	{
		alert("환불 규정에 동의해야 결제가 가능합니다.");
		return false;
	}
	
	else{
		
			form.price.value = form.cash.value;
			form.Amt.value = form.cash.value;
		
			var priceVal = form.price.value;
			
			if(priceVal=='11000'){
				form.jokmok.value = '1';
				form.ProdNm.value = '1종목';
			}else if(priceVal=='55000'){
				form.jokmok.value = '5';
				form.ProdNm.value = '5종목';
			}else{
				form.jokmok.value='10';
				form.ProdNm.value = '10종목';
			}
		
	}	
	
	if(form.pay_type[0].checked==true){
		if(form.bank_name.value != "우리은행"){
			alert("입금하실 은행을 선택하세요");
			return false;
		}

		if(confirm("결제금액: "+form.price.value+"원 결제 하시겠습니까?")){
			form.action="/lani/jongmokValue/bank_pay_ing.php";
			form.submit();
			return true;
		}
	}
	else if(form.pay_type[1].checked==true){
		if(confirm("결제금액: "+form.price.value+"원 결제 하시겠습니까?")){
			form.action="/lani/jongmokValue/card_pay_ing.php";
			Pay(document.pay_form);
		}
	}
	else if(form.pay_type[2].checked==true){
		
		if(confirm("결제금액: "+form.price.value+"원 결제 하시겠습니까?")){
			form.action="/lani/jongmokValue/ars_pay_ing.php";
			form.submit();
			return true;
		}
	}else{
		if(form.cash.value=='110000'){
			alert('100000원 이상은 휴대폰으로 결제가 불가능합니다.');
			return false;
		}else{
			form.action="/lani/jongmokValue/mobile_pay_ing_new.php";
			form.submit();
		}

	}
}

function view_bank_num(){
	var val = document.getElementById('bank_name').value;
	var value;

	if(val=="우리은행"){
		value="1005-301-453395 (주)평택촌놈";
		document.getElementById('b_name').value = val;
		document.getElementById('bank').value = value;
	}else{
		value="입금하실 은행을 선택하세요";
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
 <img src="img/notice_refund.jpg">
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

		<!-- 카드결제에 필요한 변수 시작 -->
		<INPUT TYPE="HIDDEN" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="HIDDEN" NAME="StoreNm" value="평택촌놈">
		<INPUT TYPE="HIDDEN" NAME="OrdNo" value="<?=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");?>">  <!-- service_kind테이블의 orderID -->
		<INPUT TYPE="HIDDEN" NAME="ProdNm" value="">
		<INPUT TYPE="HIDDEN" NAME="Amt" value="">
		<INPUT TYPE="HIDDEN" NAME="MallUrl" value="http://www.502.co.kr">
		<INPUT TYPE="HIDDEN" NAME="Remark" value="">
		<INPUT TYPE="HIDDEN" NAME="Job" value="onlycard">
		<INPUT TYPE="HIDDEN" NAME="UserId" value="<?=$_COOKIE['_CKE_USER_ID']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdPhone" value="<?=$meminfo[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="OrdAddr" value="없음">
		<INPUT TYPE="HIDDEN" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="RcpPhone" value="<?=$meminfo[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="DlvAddr" value="없음">
		<INPUT TYPE="HIDDEN" NAME="UserEmail" value="<?=$_COOKIE['_CKE_USER_EMAIL']?>">
		<!-- <input type="HIDDEN" style="width:300px" name="SubjectData" value="상호명;상품명;결제금액;결제일~서비스종료시점;"> -->


		<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

		<!-- 각 결제 공통 사용 변수 -->
		<input type=hidden name=Flag value="">				<!-- 스크립트결제사용구분플래그 -->
		<input type=hidden name=AuthTy value="">			<!-- 결제형태 -->
		<input type=hidden name=SubTy value="">				<!-- 서브결제형태 -->

		<!-- 신용카드 결제 사용 변수 -->
		<input type=hidden name=DeviId value="">			<!-- (신용카드공통)		단말기아이디 -->
		<input type=hidden name=QuotaInf value="0">			<!-- (신용카드공통)		일반할부개월설정변수 -->
		<input type=hidden name=NointInf value="NONE">		<!-- (신용카드공통)		무이자할부개월설정변수 -->
		<input type=hidden name=AuthYn value="">			<!-- (신용카드공통)		인증여부 -->
		<input type=hidden name=Instmt value="">			<!-- (신용카드공통)		할부개월수 -->
		<input type=hidden name=partial_mm value="">		<!-- (ISP사용)			일반할부기간 -->
		<input type=hidden name=noIntMonth value="">		<!-- (ISP사용)			무이자할부기간 -->
		<input type=hidden name=KVP_RESERVED1 value="">		<!-- (ISP사용)			RESERVED1 -->
		<input type=hidden name=KVP_RESERVED2 value="">		<!-- (ISP사용)			RESERVED2 -->
		<input type=hidden name=KVP_RESERVED3 value="">		<!-- (ISP사용)			RESERVED3 -->
		<input type=hidden name=KVP_CURRENCY value="">		<!-- (ISP사용)			통화코드 -->
		<input type=hidden name=KVP_CARDCODE value="">		<!-- (ISP사용)			카드사코드 -->
		<input type=hidden name=KVP_SESSIONKEY value="">	<!-- (ISP사용)			암호화코드 -->
		<input type=hidden name=KVP_ENCDATA value="">		<!-- (ISP사용)			암호화코드 -->
		<input type=hidden name=KVP_CONAME value="">		<!-- (ISP사용)			카드명 -->
		<input type=hidden name=KVP_NOINT value="">			<!-- (ISP사용)			무이자/일반여부(무이자=1, 일반=0) -->
		<input type=hidden name=KVP_QUOTA value="">			<!-- (ISP사용)			할부개월 -->
		<input type=hidden name=CardNo value="">			<!-- (안심클릭,일반사용)	카드번호 -->
		<input type=hidden name=MPI_CAVV value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
		<input type=hidden name=MPI_ECI value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
		<input type=hidden name=MPI_MD64 value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
		<input type=hidden name=ExpMon value="">			<!-- (일반사용)			유효기간(월) -->
		<input type=hidden name=ExpYear value="">			<!-- (일반사용)			유효기간(년) -->
		<input type=hidden name=Passwd value="">			<!-- (일반사용)			비밀번호 -->
		<input type=hidden name=SocId value="">				<!-- (일반사용)			주민등록번호/사업자등록번호 -->

		<!-- 계좌이체 결제 사용 변수 -->
		<input type=hidden name=ICHE_OUTBANKNAME value="">	<!-- 이체계좌은행명 -->
		<input type=hidden name=ICHE_OUTACCTNO value="">	<!-- 이체계좌예금주주민번호 -->
		<input type=hidden name=ICHE_OUTBANKMASTER value=""><!-- 이체계좌예금주 -->
		<input type=hidden name=ICHE_AMOUNT value="">		<!-- 이체금액 -->

		<!-- 핸드폰 결제 사용 변수 -->
		<input type=hidden name=HP_SERVERINFO value="">		<!-- 서버정보 -->
		<input type=hidden name=HP_HANDPHONE value="">		<!-- 핸드폰번호 -->
		<input type=hidden name=HP_COMPANY value="">		<!-- 통신사명(SKT,KTF,LGT) -->
		<input type=hidden name=HP_IDEN value="">			<!-- 인증시사용 -->
		<input type=hidden name=HP_IPADDR value="">			<!-- 아이피정보 -->

		<!-- 가상계좌 결제 사용 변수 -->
		<input type=hidden name=ZuminCode value="">			<!-- 가상계좌입금자주민번호 -->
		<input type=hidden name=VIRTUAL_CENTERCD value="">	<!-- 가상계좌은행코드 -->
		<input type=hidden name=VIRTUAL_DEPODT value="">	<!-- 가상계좌입금예정일 -->
		<input type=hidden name=VIRTUAL_NO value="">		<!-- 가상계좌번호 -->

		<!-- 우리에스크로 결제 사용 변수 -->
		<input type=hidden name=mTId value="">				<!-- 에스크로주문번호 -->

		<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->
		<!-- 카드결제에 필요한 변수 끝 -->



		<TR height=26>
          <TD WIDTH="83" height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>결제자</strong></TD>
          <TD width=8></TD>
          <TD width="250"><INPUT TYPE="TEXT" name="username" value="<?=$_COOKIE['_CKE_USER_NAME']?>" class="input01" style="width:120" readonly></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD WIDTH="83"  height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>전화번호</strong></TD>
          <TD width=8></TD>
          <TD>
			<input name="mobile1" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[0]?>">
			&nbsp;-&nbsp;
            <input name="mobile2" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[1]?>">
            &nbsp;-&nbsp;
            <input name="mobile3" type="text" class="input01" maxlength="4" style="width: 50" onKeyPress="onlyNumber()" value="<?=$mobile[2]?>"><br>
			<font color="red">※무통장 입금 시 현금영수증 신청할 번호입력</font></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD align="center" WIDTH="83" height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>결제방법</strong></TD>
          <TD width=8></TD>
          <TD><INPUT TYPE="RADIO" name="pay_type" value="1" onclick="pay_type_check();">무통장입금
            &nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="RADIO" name="pay_type" value="2" onclick="pay_type_check();" checked>카드결제<br>
            <INPUT TYPE="RADIO" name="pay_type" value="3" onclick="pay_type_check();">ARS카드결제
			&nbsp;<INPUT TYPE="RADIO" name="pay_type" value="4" onclick="pay_type_check();">휴대폰
		  </TD>
        </TR>
		<tr height=26 id="bankName" style="display:none;">
		  <td WIDTH="83" align="center" class="darkbrown"><strong>입금은행</strong></td>
          <TD width=8></TD>
          <td>
			<select name='bank_name' onChange='view_bank_num();'>
				<option value=''>은행선택</option>
				<option value='우리은행'>우리은행</option>
			</select>		  
		  </td>
		</tr>
		<tr height=26 id="bankAccount" style="display:none;">
		  <td WIDTH="83" align="center" class="darkbrown"><strong>계좌번호</strong></td>
		  <TD width=8></TD>
		  <td><div name="bank_num" id="bank_num">입금하실 은행을 선택하세요</div></td>
		</tr>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83"  height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>결제상품</strong></td>
          <TD width=8></TD>
          <TD>적정주가</TD>
        </tr>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83"  height="35px" style="background:#FFF8E8; BORDER-RIGHT: #FFCA5E 1px solid;text-align:center;"><strong>결제금액</strong></td>
          <TD width=8></TD>
          <TD>
			<select name="cash">
				<option value="">금액을 선택하세요
				<option value="11000">1종목 - 11,000원
				<option value="55000">5종목 - 55,000원
				<option value="110000">10종목 - 110,000원
			</select>
			<br><font color='red'>&nbsp;&nbsp;&nbsp;* 부가세 포함 금액입니다.
		  </TD>
        </tr>
        		
      </FORM>
    </TABLE></td>
  </tr>  
  <tr>
  <td align="center" colspan="10" height="30px">
<input type="checkbox" value="T" name="chkRefund" id="chkRefund">환불규정 동의
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