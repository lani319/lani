<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$pay_contents_idx		= trim($_POST["pay_contents_idx"]);	//게시물 idx
$srv_code				= trim($_POST["srv_code"]);			//전문가 코드

$pay_contents_idx		= 5;	//게시물 idx
$srv_code				= "12";			//전문가 코드

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
	popupMsg("필수 입력 값이 누락되었습니다.");
	echo "<script> window.close(); </script>";
	exit();
}

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}




//전문가 idx 복호화
$expert_idx = usrCrypt(URLdecode($srv_code),0);


$sql="select service_orderID as bn,service_name as title,service_price as price from service_goods where idx='".$pay_contents_idx."'";
$mqf=mysql_fetch_array(mysql_query($sql));

$contents_name=$mqf['title'];

$orderid=$_COOKIE['_CKE_USER_UID']."-".date("ymdHis");

?>
<html>
<head>
<title>투자의 정석 결제</title>
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

	if(form.pay_type[1].checked==true){ //신용카드
		if(confirm("결제금액: "+form.price.value+"원\n"+point_msg+"\n결제 하시겠습니까?")){
			form.action="/include/AGS_pay_ing.php";
			Pay(document.pay_form);
		}
	}
	else if(form.pay_type[2].checked==true){ //ARS
		if(confirm("결제금액: "+form.price.value+"원\n"+point_msg+"\n결제 하시겠습니까?")){
			form.action="/include/charge_contents_process_ars_card.php";
			form.submit();
			return true;
		}
	}
	else{ //무통장

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


		<!-- 카드결제에 필요한 변수 시작 -->
		<INPUT TYPE="TEXT" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="TEXT" NAME="StoreNm" value="평택촌놈">
		<INPUT TYPE="TEXT" NAME="OrdNo" value="<?=$pay_contents_idx?>">  <!-- stBoard테이블의 idx값 -->
		<INPUT TYPE="TEXT" NAME="ProdNm" value="<?=$contents_name?>">
		<INPUT TYPE="TEXT" NAME="Amt" value="<?=$mqf[price]?>">
		<INPUT TYPE="TEXT" NAME="MallUrl" value="http://www.502.co.kr">
		<INPUT TYPE="TEXT" NAME="Remark" value="없음">
		<INPUT TYPE="TEXT" NAME="Job" value="onlycard">
		<INPUT TYPE="TEXT" NAME="UserId" value="<?=$_COOKIE['_CKE_USER_ID']?>">
		<INPUT TYPE="TEXT" NAME="OrdNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="TEXT" NAME="OrdPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="TEXT" NAME="OrdAddr" value="없음">
		<INPUT TYPE="TEXT" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="TEXT" NAME="RcpPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="TEXT" NAME="DlvAddr" value="없음">
		<INPUT TYPE="TEXT" NAME="UserEmail" value="<?=$_COOKIE['_CKE_USER_EMAIL']?>">


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
	<td height="30px" style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">상품명</td>
	<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">판매가</td>
	<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">수량</td>
	<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;font-weight:bold;">배송료</td>
	<td style="border-bottom:1px solid #000000;font-weight:bold;">합계금액</td>
	</tr>
	<tr align="center" height=100px style="border:1px solid #000000;">
	<td width="320px" style="border-right:1px solid #000000;">[책]투자의 정석 - 입문편 <br>+<br>[VOD]QBS 투자의 정석 다시보기 이용권</td>
	<td width="100px" style="border-right:1px solid #000000;">
	<!--
	<input type="text" style="width:95px;height:23px;text-align:right;font-size:14px;" value="46,000" id="txtEachPrice" name="txtEachPrice">원
	-->
	46,000원
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
	1 세트
	</td>
	<td width="100px" style="border-right:1px solid #000000;">3,000원</td>
	<td>
	<!--
	<input type="text" style="width:100px;height:23px;text-align:right;font-size:14px;" value="49,000" name="txtTotalPrice" id="txtTotalPrice">원
	-->
	49,000원
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
	<td width="120px" valign="top"><img src="img/order/dot.gif">이름 : </td>
	<td><input type="text" name="txtMemName" id="txtMemName" style="width:100px;" value="<?=$mName?>"></td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">연락처 : </td>
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
	<td width="120px" valign="top"><img src="img/order/dot.gif">이름 : </td>
	<td><input type="text" name="txtMemNameD" id="txtMemNameD" style="width:100px;" value="<?=$mName?>"></td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">연락처 : </td>
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
	<td><img src="img/order/dot.gif">우편번호 : </td>
	<td valign="bottom">
	<input type="text" name="zipcode1" id="txtMemPost1D" style="width:35px;" maxlength="3" readonly>
	-
	<input type="text" name="zipcode2" id="txtMemPost2D" style="width:35px;" maxlength="4" readonly>
	<img src="img/imgPostCode.gif" border="0" style="cursor:hand;" onclick="getPost();">
	</td>
	</tr>
	<tr><td colspan="2" height="5px"></td></tr>
	<tr>
	<td><img src="img/order/dot.gif">주소 : </td>
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
	<td  valign="top"><input type="radio" name="pay_type" value="bank" checked onclick="document.getElementById('txtPaymethod').value = this.value;">무통장 입금</td>
	<td  valign="top"><input type="radio" name="pay_type" value="card" onclick="document.getElementById('txtPaymethod').value = this.value;">신용카드</td>
	<!--
	<td width="100px" valign="top"><input type="radio" name="pay_type" value="mobile" onclick="document.getElementById('txtPaymethod').value = this.value;">핸드폰</td>
	<td width="100px" valign="top"><input type="radio" name="pay_type" value="coin" onclick="document.getElementById('txtPaymethod').value = this.value;">502코인</td>
	<td width="120px" valign="top"><input type="radio" name="pay_type" value="realBank" onclick="document.getElementById('txtPaymethod').value = this.value;">실시간 계좌이체</td>
	-->
	<td  valign="top"><input type="radio" name="pay_type" value="ARS" onclick="document.getElementById('txtPaymethod').value = this.value;">ARS카드결제</td>	
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