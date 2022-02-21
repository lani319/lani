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


//회원 정보를 가져온다.
//이름,필명,연락처,주소

$userIdx = $_COOKIE['_CKE_USER_UID'];


$sql = "select idx, userName,userNickname,mobile,address1,address2 from Member where idx = $userIdx and gradeLevel IN (0,1)";

$tmpRs = mysql_query($sql);

$rs = mysql_fetch_array($tmpRs);

if ($rs[idx]==null){ 
	popupMsg("유료 회원만 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

$mobile1 = substr($rs[mobile],0,3);
$mobile2 = substr($rs[mobile],4,4);
$mobile3 = substr($rs[mobile],9,4);

$mobile = $mobile1."-".$mobile2."-".$mobile3;

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}
?>


<html>
<title> ::: 서비스 신청 페이지 ::: </title>
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
// 올더게이트 플러그인 설치를 확인합니다.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

StartSmartUpdate();  

function Pay(form){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MakePayMessage() 가 호출되면 올더게이트 플러그인이 화면에 나타나며 Hidden 필드
	// 에 리턴값들이 채워지게 됩니다.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(form.Flag.value == "enable"){
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 입력된 데이타의 유효성을 검사합니다.
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if(Check_Common(form) == true){
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// 올더게이트 플러그인 설치가 올바르게 되었는지 확인합니다.
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if(document.AGSPay == null || document.AGSPay.object == null){
				alert("플러그인 설치 후 다시 시도 하십시오.");
			}else{
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// 올더게이트 플러그인 설정값을 동적으로 적용하기 JavaScript 코드를 사용하고 있습니다.
				// 상점설정에 맞게 JavaScript 코드를 수정하여 사용하십시오.
				//
				// [1] 일반/무이자 결제여부
				// [2] 일반결제시 할부개월수
				// [3] 무이자결제시 할부개월수 설정
				// [4] 인증여부
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [1] 일반/무이자 결제여부를 설정합니다.
				//
				// 할부판매의 경우 구매자가 이자수수료를 부담하는 것이 기본입니다. 그러나,
				// 상점과 올더게이트간의 별도 계약을 통해서 할부이자를 상점측에서 부담할 수 있습니다.
				// 이경우 구매자는 무이자 할부거래가 가능합니다.
				//
				// 예제)
				// 	(1) 일반결제로 사용할 경우
				// 	form.DeviId.value = "9000400001";
				//
				// 	(2) 무이자결제로 사용할 경우
				// 	form.DeviId.value = "9000400002";
				//
				// 	(3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
				// 	if(parseInt(form.Amt.value) < 100000)
				//		form.DeviId.value = "9000400001";
				// 	else
				//		form.DeviId.value = "9000400002";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				form.DeviId.value = "9000400001";
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [2] 일반 할부기간을 설정합니다.
				// 
				// 일반 할부기간은 2 ~ 12개월까지 가능합니다.
				// 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
				// 
				// 예제)
				// 	(1) 할부기간을 일시불만 가능하도록 사용할 경우
				// 	form.QuotaInf.value = "0";
				//
				// 	(2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
				//		form.QuotaInf.value = "0:3:4:5:6:7:8:9:10:11:12";
				//
				// 	(3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
				// 	if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
				// 		form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				// 	else
				// 		form.QuotaInf.value = "0";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//결제금액이 5만원 미만건을 할부결제로 요청할경우 결제실패
				if(parseInt(form.Amt.value) < 50000)
					form.QuotaInf.value = "0";
				else
					form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [3] 무이자 할부기간을 설정합니다.
				// (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
				// 
				// 무이자 할부기간은 2 ~ 12개월까지 가능하며, 
				// 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
				// 
				// 100:BC
				// 200:국민
				// 300:외환
				// 400:삼성
				// 500:엘지
				// 600:신한
				// 800:현대
				// 900:롯데
				// 
				// 예제)
				// 	(1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
				// 	form.NointInf.value = "ALL";
				//
				// 	(2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6";
				//
				// 	(3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "300-2:3:4:5:6";
				//
				// 	(4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6,300-2:3:4:5:6";
				//	
				//	(5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
				//	form.NointInf.value = "NONE";
				//
				//	(6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
				//	form.NointInf.value = "100-2:3:6,200-2:3:6,300-2:3:6,400-2:3:6,500-2:3:6,600-2:3:6,800-2:3:6,900-2:3:6";
				//
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				if(form.DeviId.value == "9000400002")
					form.NointInf.value = "ALL";
				   
				if(MakePayMessage(form) == true){
					Disable_Flag(form);
					
					var openwin = window.open("AGS_progress.html","popup","width=300,height=160"); //"지불처리중"이라는 팝업창연결 부분
					
					form.submit();
				}else{
					alert("지불에 실패하였습니다.");// 취소시 이동페이지 설정부분
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
		alert("상점아이디를 입력하십시오.");
		return false;
	}
	else if(form.StoreNm.value == ""){
		alert("상점명을 입력하십시오.");
		return false;
	}
	else if(form.OrdNo.value == ""){
		alert("주문번호를 입력하십시오.");
		return false;
	}
	else if(form.ProdNm.value == ""){
		alert("상품명을 입력하십시오.");
		return false;
	}
	else if(form.Amt.value == ""){
		alert("금액을 입력하십시오.");
		return false;
	}
	else if(form.MallUrl.value == ""){
		alert("상점URL을 입력하십시오.");
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
function showDiv(idMyDiv){ //2차선택을 보여주는것

	hideDiv();

     var objDiv = document.getElementById(idMyDiv);

     if(objDiv.style.display=="block"){ objDiv.style.display = "none"; }
     else{ objDiv.style.display = "block"; }
}


function hideDiv() { //2차 선택을 숨기는 것
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
		//급지별 가격을 보여줌
		var form = document.frmAGS_pay;
		document.getElementById('price').value=0;
		document.getElementById('price').value=value;
		form.Amt.value = value; //카드 결제를 위한 가격
	}
}



function chkForm()
{
	var form = document.frmAGS_pay;
	
	if(document.getElementById("mobile1").value==""){alert("연락처를 입력해 주세요");return false;}
	if(document.getElementById("mobile2").value==""){alert("연락처를 입력해 주세요");return false;}
	if(document.getElementById("mobile3").value==""){alert("연락처를 입력해 주세요");return false;}
	
	if(document.getElementById("address1").value==""){alert("주소를 입력해 주세요");return false;}
	if(document.getElementById("address2").value==""){alert("주소를 입력해 주세요");return false;}
		
	if(document.getElementById("selectArea1").value==""){alert("지역을 선택해 주세요.");return false;}
	
	if(document.getElementById("agreeTrue").checked==""){alert("결제전 참고사항에 동의하지 않으면,서비스 이용이 불가능합니다.");return false;}
	
	//현금 영수증 체크
	if(document.getElementById("rdReceipt01").checked){
		if(document.getElementById("receipt").value==""){
			alert("현금영수증 등록을 위해 번호를 입력해 주세요");			
			return false;
		}
	}
	if(document.getElementById("rdReceipt02").checked){
		if(document.getElementById("receipt").value==""){
			alert("현금영수증 등록을 위해 번호를 입력해 주세요");
			
			return false;
		}
	}
	
	form.ProdNm.value = "1일 서비스";
	
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
		<INPUT TYPE="HIDDEN" NAME="OrdPhone" value="<?=$mobile?>">
		<INPUT TYPE="HIDDEN" NAME="OrdAddr" value="없음">
		<INPUT TYPE="HIDDEN" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="RcpPhone" value="<?=$mobile?>">
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
		
		
<table class="t_ex2">
<tr>
<th class="c1" width="100px">회원정보</td>
<td><b><?=$rs[userName]?>(<?=$rs[userNickname]?>)</b></td>
</tr>

<tr>
<th class="c1">연락처</td>
<td>
<input type="text" name="mobile1" id="mobile1" size=3 style="font-size:18px;" value="<?=$mobile1?>" maxlength=3>
-
<input type="text" name="mobile2" id="mobile2" size=4 style="font-size:18px;" value="<?=$mobile2?>" maxlength=4>
-
<input type="text" name="mobile3" id="mobile3" size=4 style="font-size:18px;" value="<?=$mobile3?>" maxlength=4>
<b>연락처 수정이 필요하면 입력 해 주세요.
</td>
</tr>

<tr>
<th class="c1">지역선택</td>
</td>
<td>
	<table>
	<tr>
	<td>
	<select style="width:150px;font-size:20px;" name="selectArea1" id="selectArea1" onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='100000'>서울특별시</option>
	<option value='150000'>광주광역시</option>
	<option value='150000'>대구광역시</option>
	<option value='100000'>대전광역시</option>
	<option value='200000'>부산광역시</option>
	<option value='100000'>세종특별자치시</option>
	<option value='200000'>울산광역시</option>
	<option value='100000'>인천광역시</option>
	<option></option>
	<option value='area1'>경기도</option>
	<option value='area2'>강원도</option>
	<option value='area3'>충청남도</option>
	<option value='area4'>충청북도</option>
	<option value='area5'>전라북도</option>
	<option value='area6'>전라남도</option>
	<option value='area7'>경상북도</option>
	<option value='area8'>경상남도</option>
	</select>
	</td>
	<td>
	<div id="area0">
	<select style="width:150px;font-size:18px">
	<option>----</option>
	</select>
	</div>
	
	<!-- 경기도 -->
	<div id="area1"style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea2" onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='130000'>가평군</option>
	<option value='130000'>고양시</option>
	<option value='100000'>과천시</option>
	<option value='130000'>광명시</option>
	<option value='100000'>광주시</option>
	<option value='130000'>구리시</option>
	<option value='100000'>군포시</option>
	<option value='130000'>김포시</option>
	<option value='130000'>남양주시</option>
	<option value='130000'>동두천시</option>
	<option value='130000'>부천시</option>
	<option value='100000'>성남시</option>
	<option value='100000'>수원시</option>
	<option value='130000'>시흥시</option>
	<option value='100000'>안산시</option>
	<option value='100000'>안성시</option>
	<option value='100000'>안양시</option>
	<option value='130000'>양주시</option>
	<option value='130000'>양평군</option>
	<option value='130000'>여주시</option>
	<option value='130000'>연천군</option>
	<option value='100000'>오산시</option>
	<option value='100000'>용인시</option>
	<option value='100000'>의왕시</option>
	<option value='130000'>의정부시</option>
	<option value='130000'>이천시</option>
	<option value='130000'>파주시</option>
	<option value='100000'>평택시</option>
	<option value='130000'>포천시</option>
	<option value='130000'>하남시</option>
	<option value='100000'>화성시</option>
	</select>
	</div>

	<!-- 강원도 -->
	<div id="area2"style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea3" onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='150000'>강릉시</option>
	<option value='180000'>고성군</option>
	<option value='180000'>동해시</option>
	<option value='180000'>삼척시</option>
	<option value='180000'>속초시</option>
	<option value='150000'>양구군</option>
	<option value='180000'>양양군</option>
	<option value='130000'>영월군</option>
	<option value='130000'>원주시</option>
	<option value='150000'>인제군</option>
	<option value='150000'>정선군</option>
	<option value='130000'>철원군</option>
	<option value='130000'>춘천시</option>
	<option value='150000'>태백시</option>
	<option value='130000'>평창군</option>
	<option value='130000'>홍천군</option>
	<option value='150000'>화천군</option>
	<option value='130000'>횡성군</option>
	</select>
	</div>

	<!-- 충청남도 -->
	<div id="area3" style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea4"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='130000'>계룡시</option>
	<option value='130000'>공주시</option>
	<option value='130000'>금산군</option>
	<option value='130000'>논산시</option>
	<option value='100000'>당진시</option>
	<option value='130000'>보령시</option>
	<option value='130000'>부여군</option>
	<option value='130000'>서산시</option>
	<option value='130000'>서천군</option>
	<option value='100000'>아산시</option>
	<option value='100000'>예산군</option>
	<option value='100000'>천안시</option>
	<option value='130000'>청양군</option>
	<option value='130000'>태안군</option>
	<option value='130000'>홍성군</option>
	</select>
	</div>

	<!-- 충청북도 -->
	<div id="area4"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea5"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='130000'>괴산군</option>
	<option value='130000'>단양군</option>
	<option value='130000'>보은군</option>
	<option value='130000'>영동군</option>
	<option value='130000'>옥천군</option>
	<option value='100000'>음성군</option>
	<option value='130000'>제천시</option>
	<option value='100000'>증평군</option>
	<option value='100000'>진천군</option>
	<option value='100000'>청주시</option>
	<option value='130000'>충주시</option>
	</select>
	</div>

	<!-- 전라북도 -->
	<div id="area5" style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea6"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='150000'>고창군</option>
	<option value='130000'>군산시</option>
	<option value='130000'>김제시</option>
	<option value='150000'>남원시</option>
	<option value='130000'>무주군</option>
	<option value='130000'>부안군</option>
	<option value='150000'>순창군</option>
	<option value='130000'>완주군</option>
	<option value='130000'>익산시</option>
	<option value='130000'>임실군</option>
	<option value='150000'>장수군</option>
	<option value='130000'>전주시</option>
	<option value='150000'>정읍시</option>
	<option value='130000'>진안군</option>
	</select>
	</div>

	<!-- 전라남도 -->
	<div id="area6"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea7"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='200000'>강진군</option>
	<option value='200000'>고흥군</option>
	<option value='150000'>곡성군</option>
	<option value='180000'>광양시</option>
	<option value='150000'>구례군</option>
	<option value='180000'>나주시</option>
	<option value='150000'>담양군</option>
	<option value='180000'>목포시</option>
	<option value='180000'>무안군</option>
	<option value='200000'>보성군</option>
	<option value='180000'>순천시</option>
	<option value='180000'>여수시</option>
	<option value='150000'>영광군</option>
	<option value='180000'>영암군</option>
	<option value='200000'>완도군</option>
	<option value='150000'>장성군</option>
	<option value='200000'>장흥군</option>
	<option value='180000'>진도군</option>
	<option value='180000'>함평군</option>
	<option value='200000'>해남군</option>
	<option value='180000'>화순군</option>	
	</select>
	</div>

	<!-- 경상북도 -->
	<div id="area7"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea8"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='150000'>경산시</option>
	<option value='180000'>경주시</option>
	<option value='150000'>고령군</option>
	<option value='150000'>구미시</option>
	<option value='150000'>군위군</option>
	<option value='130000'>김천시</option>
	<option value='130000'>문경시</option>
	<option value='150000'>봉화군</option>
	<option value='130000'>상주시</option>
	<option value='150000'>성주군</option>
	<option value='150000'>안동시</option>
	<option value='150000'>영덕군</option>
	<option value='150000'>영양군</option>
	<option value='130000'>영주시</option>
	<option value='180000'>영천시</option>
	<option value='150000'>예천군</option>
	<option value='150000'>울진군</option>
	<option value='150000'>의성군</option>
	<option value='180000'>청도군</option>
	<option value='150000'>청송군</option>
	<option value='150000'>칠곡군</option>
	<option value='180000'>포항시</option>
	</select>
	</div>

	<!-- 경상남도 -->
	<div id="area8"  style="display:none">
	<select style="width:150px;font-size:20px" name="selectArea9"  onchange="showPrice(this.value);">
	<option value="">----</option>
	<option value='180000'>거제시</option>
	<option value='150000'>거창군</option>
	<option value='180000'>고성군</option>
	<option value='180000'>김해시</option>
	<option value='200000'>남해군</option>
	<option value='180000'>밀양시</option>
	<option value='180000'>사천시</option>
	<option value='150000'>산청군</option>
	<option value='200000'>양산시</option>
	<option value='180000'>의령군</option>
	<option value='180000'>진주시</option>
	<option value='150000'>창녕군</option>
	<option value='180000'>창원시</option>
	<option value='180000'>통영시</option>
	<option value='180000'>하동군</option>
	<option value='180000'>함안군</option>
	<option value='150000'>함양군</option>
	<option value='150000'>합천군</option>
	</select>
	</div>
	</td>
	</td>
	</table>	
	
</td>
</tr>

<tr>
<th class="c1">가격</td>
<td>
<input type="TEXT" id="price" name="price" value=0 style="width:80px;font-size:18px;align:right;" readonly>원
</td>
</tr>

<tr>
<th class="c1">주소</td>
<td>
<input type="text" name="address1" id="address1" style="width:300px;font-size:18px;" value="<?=$rs[address1]?>">
<input type="text" name="address2" id="address2" style="width:200px;font-size:18px;" value="<?=$rs[address2]?>">
<br><b>장소 수정이 필요하면 입력해 주세요.</b>
</td>
</tr>

<tr>
<th class="c1">희망날짜1</td>
<td>
<select name="month1" style="width:80px;font-size:18px;">
<?php
for($i=0;$i<11;$i++){
	$monthSelect = "";
if($todayMonth == $i+1)	{
	$monthSelect=" selected";
}
?>
<option value="<?=$i+1?>" <?=$monthSelect?>><?=$i+1?>월</option>
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
<option value="<?=$i+1?>"  <?=$daySelect?>><?=$i+1?>일</option>
<?php
}
?>
</select>
<select name="time1" style="width:80px;font-size:18px;">
<?php
for($i=9;$i<17;$i++){	
?>
<option value="<?=$i+1?>"><?=$i+1?>시</option> 
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th class="c1">희망날짜2</td>
<td>
<select name="month2" style="width:80px;font-size:18px;">
<?php
for($i=0;$i<11;$i++){	
	$monthSelect = "";
if($todayMonth == $i+1)	{
	$monthSelect=" selected";
}
?>
<option value="<?=$i+1?>" <?=$monthSelect?>><?=$i+1?>월</option>
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
<option value="<?=$i+1?>" <?=$daySelect?>><?=$i+1?>일</option>
<?php
}
?>
</select>
<select name="time2" style="width:80px;font-size:18px;">
<?php
for($i=9;$i<17;$i++){	
?>
<option value="<?=$i+1?>"><?=$i+1?>시</option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th class="c1">결제 전 <br>참고사항</td>
<td>

1. 신청자와 운영자 간의 요구사항 조율이 안 되면 취소할 수 있습니다.<br>
 *취소 수수료는 없습니다.<br>
<br>
2. 본 상품은 투자 조언은 절대로 불가능합니다.<br>
<br>
3. 본 상품은 저작권에 어긋나는 유/무료 S/W 설치를 포함하지 않습니다.<br>
<br>
4. 신청자와 운영자 간의 모든 대화 내용은 녹음하여 보관됩니다.<br>
<br>
5. 카드결제취소 시 처리 기간은 최대 일주일 소요될 수 있습니다.<br>
<br>
6. 무통장 입금 취소는 담당자 출근 시 바로 처리됩니다.<br>
<br>
7. 본 상품은 평일만 이용 가능합니다.<br>
<br>
8. 신청 후 24시간 이내에 운영자가 확인차 연락드립니다.<br>

</td>
</tr>
<tr>
<th class="c1">동의여부</td>
<td><b>결제 전 참고사항에 동의 하십니까?</b>
<br>
<input type="radio" name="agree" id="agreeTrue" value="True">네. 동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="agree" value="False" checked>아니요. 동의하지 않습니다.&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<tr>
<th class="c1">결제수단</td>
<td>
<input type="radio" name="payMethod" onclick="chkPay('CARD');" value="CARD" checked>신용카드
<input type="radio" name="payMethod" onclick="chkPay('ARS');" value="ARS">ARS 카드결제
<input type="radio" name="payMethod" onclick="chkPay('BANK');" value="BANK">무통장
<br>
<div id="payReceipt"  style="display:none;">
<br>
<b>현금영수증</b> <br>

 <input type="radio" name="rdReceipt" id="rdReceipt01" value="01">개인 소득공제용:&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdReceipt" id="rdReceipt02" value="02">사업자 지출증빙용: &nbsp;&nbsp;&nbsp;
<input type="radio" name="rdReceipt" value="none" checked>현금영수증 안함 : 
<br>
<input type="number" name="receiptNumber" id="receipt" size=20 style="font-size:18px;" value="">
<br>
*소득공제용 : 핸드폰번호, 현금영수증 카드번호<br>
*지출증빙용 : 사업자 등록번호
</div>
</td>
</tr>
<tr>
<td colspan=2 align="center">
<input type="button" onclick=chkForm(); value="서비스 신청" style="width:300px;height=100px;font-size:20px;">
</td>
</tr>
</table>

</form>
</body>
</html>