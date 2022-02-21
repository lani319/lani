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

	function priceCk(price,value){
		document.getElementById('price').value = price;
		document.pay_form.ProdNm.value = value+'종목';
	}

	function pay_check(){
		var form=document.pay_form;
		if(form.pay_type[0].checked==true){		
			if(form.bank_name.value==''){
				alert('입금은행을 선택하세요');
				return false;
			}

			if(form.mobile1.value=='' || form.mobile2.value=='' || form.mobile3.value==''){
				alert('전화번호를 입력하세요');
				form.mobile1.focus();
				return false;
			}
		
		}else if(form.pay_type[3].checked==true){
			if(form.jokmok[2].checked==true){
				alert('100000원 이상은 휴대폰으로 결제가 불가능합니다.');
				return false;
			}
		}

		var t_price = document.getElementById('price').value;
		if(confirm('결제금액 '+t_price+'원 결제하시겠습니까?')){
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
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"mobile");
$mobile=explode("-",$meminfo[mobile]);
?>
<!-- 
무통장 입금, 신용카드, ARS카드결제, 핸드폰 이렇게 4가지 결제방식을 선택하는 페이지 입니다. 

1) 결제방법 선택
2) 결제금액 선택


결제방법)
무통장입금, 신용카드, ARS카드결제 , 핸드폰 결제

결제금액)
1종목 -  11,000원
5종목 -  55,000원
10종목 - 110,000원

*부가세 포함 금액입니다. 

database
테이블 이름 : jongmokValueChargeInfo
칼럼 : 
idx : index, 자동증가
memIdx : 결제자 idx
price : 결제가격
buy_no : 구매번호 (구매번호 생성 로직에 따라 입력)
state : 결제상태 (무통장 입금완료, 신용카드 취소 등등)
signdate : 결제 신청날짜와 시각
paydate : 결제 완료날짜와 시각
cardName : 신용카드일 경우 카드이름
cardNumber : 신용카드 승인번호
-->
<body topmargin=0 leftmargin=0 onload="javascript:Enable_Flag(pay_form);">
<div style="width:760px; border:1px solid;">
	<form name="pay_form" method="post">
		<input type="hidden" name="price" id="price" value="11000">
		<input type="hidden" name="mem_idx" id="mem_idx" value="<?php echo $_COOKIE['_CKE_USER_UID']; ?>">
		<input type="hidden" name="bank" id="bank" value="">
		<input type="hidden" name="b_name" id="b_name" value="">

		<!-- 카드결제에 필요한 변수 시작 -->
		<INPUT TYPE="HIDDEN" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="HIDDEN" NAME="StoreNm" value="평택촌놈">
		<INPUT TYPE="HIDDEN" NAME="OrdNo" value="<?=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");?>">  <!-- service_kind테이블의 orderID -->
		<INPUT TYPE="HIDDEN" NAME="ProdNm" value="1">
		<INPUT TYPE="HIDDEN" NAME="Amt" value="11000">
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
		<table width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr>
				<td width="15%">결제수단)</td>
				<td><input type="radio" name="pay_type"  value="1" onclick="pay_type_check();">무통장입금&nbsp;&nbsp;&nbsp;<input type="radio" name="pay_type" value="2" onclick="pay_type_check();">ARS&nbsp;&nbsp;&nbsp;<input type="radio" name="pay_type" value="3" onclick="pay_type_check();" checked>신용카드&nbsp;&nbsp;&nbsp; <input type="radio" name="pay_type" value="4" onclick="pay_type_check();">휴대폰&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td>결제금액)</td>
				<td>
					<input type="radio" name="jokmok" id="jokmok" value="1" onclick="priceCk('11000',this.value)" checked>1종목 - 11,000원<br>
					<!--
					<input type="radio" name="jokmok" id="jokmok" value="5" onclick="priceCk('55000',this.value)">5종목 - 55,000원<br>
					-->
					<input type="radio" name="jokmok" id="jokmok" value="10" onclick="priceCk('30000',this.value)">10종목 - 30,000원<br>
				</td>
			</tr>
			<tr id="bankName" style="display:none;">
				<td>입금은행)</td>
				<td>&nbsp;
					<select name='bank_name' onChange='view_bank_num();'>
						<option value=''>은행선택</option>
						<option value='우리은행'>우리은행</option>
					</select>
				</select>		
				</td>
			</tr>
			<tr id="bankAccount" style="display:none;">
				<td>계좌번호</td>
				<td><div name="bank_num" id="bank_num">&nbsp;입금하실 은행을 선택하세요</div></td>
			</tr>
			<tr id="bankmobile" style="display:none;">
				<td>전화번호<br>(현금영수증관련)</td>
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
				<td colspan="2" align="center"><b><a href="#" onclick="pay_check(); return false;">결제하기</a></b></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>