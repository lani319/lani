<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

$pay_contents_idx		= trim($_POST["pay_contents_idx"]);	//게시물 idx
$srv_code				= trim($_POST["srv_code"]);			//전문가 코드
?>
<html>
<head>
<title>유료컨텐츠 결제</title>
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
	popupMsg("필수 입력 값이 누락되었습니다.");
	echo "<script> window.close(); </script>";
	exit();
}

if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//전문가 idx 복호화
$expert_idx = usrCrypt(URLdecode($srv_code),0);


$sql="select bn, price , title from stBoard where idx='".$pay_contents_idx."'";
$mqf=mysql_fetch_array(mysql_query($sql));

$contents_name="유료컨텐츠 : ".$_PAY_BOARD_KIND_ARRAY[$mqf['bn']]." (".$pay_contents_idx."번)";
$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"idx, mobile, phone, total_coin");
if(!$meminfo[idx]){
	popupMsg(" 회원정보가 존재 하지 않습니다. \r\n 다시한번 로그인후 재시도 해주세요");
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
		alert("결제자 이름을 입력 해주세요");
		form.username.focus();
		return false;
	}
	
	if(form.mobile1.value=="" || form.mobile2.value=="" || form.mobile3.value==""){
		alert("전화번호를 입력 해주세요");
		form.mobile1.focus();
		return false;
	}
	if(form.pay_type[1].checked==true && mobile_limit_price < form.price.value){
		alert(mobile_limit_price + "원 이상은 핸드폰 결제가 불가능 합니다.");
		return false;
	}

	if(form.spend_point.checked==true){
		form.use_point.value = Number(Math.round(form.use_point.value*0.002)*500);
		var sub_price = Number(form.use_point.value*10);

		if(form.use_point.value < min_settle_point){
			alert("코인은 "+min_settle_point+"코인 이상부터 사용이 가능합니다.");
			form.use_point.select();
			return false;
		}

		if(form.use_point.value > max_settle_point){
			alert("코인은 "+max_settle_point+"코인 까지만 사용이 가능합니다.");
			form.use_point.select();
			return false;
		}
		
		/*
		if(form.use_point.value > possible_point){
			alert("한달에 사용가능한 코인보다 높습니다.\n\n사용가능 코인: "+possible_point+" Coin");
			form.use_point.select();
			return false;
		}
		*/

		if(form.use_point.value > user_point){
			alert("가용코인보다 높습니다.");
			form.use_point.select();
			return false;
		}

		if(sub_price > contents_price){
			alert("결제금액보다 많습니다.");
			form.use_point.select();
			return false;
		}

		if(sub_price < contents_price && form.use_point.value <= max_settle_point){
			var re_price = contents_price - sub_price;
			form.price.value=re_price;							//핸드폰결제에서 사용하는 가격
			form.Amt.value=re_price;							//카드에서 사용하는 가격
			form.sub_price.value = sub_price;

		}else if(sub_price == contents_price){
			var re_price = contents_price - sub_price;
			form.price.value=re_price;							//핸드폰결제에서 사용하는 가격
			form.Amt.value=re_price;							//카드에서 사용하는 가격

			form.sub_price.value = sub_price;
			if(confirm("결제금액: "+form.price.value+"원\n사용코인: "+form.use_point.value+"Coin\n\n결제 하시겠습니까?")){
				form.action="/include/charge_contents_process_point.php";
				form.submit();
			}
			
			return false;
		}	
	}

	if(form.use_point.value){
		var point_msg = "사용코인: "+form.use_point.value+"Coin\n";
	}else{
		var point_msg = "";
	}

	if(form.pay_type[0].checked==true){
		if(confirm("결제금액: "+form.price.value+"원\n"+point_msg+"\n결제 하시겠습니까?")){
			form.action="/include/AGS_pay_ing.php";
			Pay(document.pay_form);
		}
	}
	else if(form.pay_type[1].checked==true){
		if(form.price.value < mobile_min_price){
			alert("최소결제금액은 1000원 이상입니다");
			form.use_point.select();
			return false;
		}

		if(confirm("결제금액: "+form.price.value+"원\n"+point_msg+"\n결제 하시겠습니까?")){
			form.action="/include/charge_contents_process.php";
			form.submit();
			return true;
		}
	}
	else{
		if(confirm("결제금액: "+form.price.value+"원\n"+point_msg+"\n결제 하시겠습니까?")){
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
		alert("가용코인를 넘었습니다");
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


		<!-- 카드결제에 필요한 변수 시작 -->
		<INPUT TYPE="HIDDEN" NAME="StoreId" value="<?=$_CARD_StoreId?>">
		<INPUT TYPE="HIDDEN" NAME="StoreNm" value="평택촌놈">
		<INPUT TYPE="HIDDEN" NAME="OrdNo" value="<?=$pay_contents_idx?>">  <!-- stBoard테이블의 idx값 -->
		<INPUT TYPE="HIDDEN" NAME="ProdNm" value="<?=$contents_name?>">
		<INPUT TYPE="HIDDEN" NAME="Amt" value="<?=$mqf[price]?>">
		<INPUT TYPE="HIDDEN" NAME="MallUrl" value="http://www.502.co.kr">
		<INPUT TYPE="HIDDEN" NAME="Remark" value="없음">
		<INPUT TYPE="HIDDEN" NAME="Job" value="onlycard">
		<INPUT TYPE="HIDDEN" NAME="UserId" value="<?=$_COOKIE['_CKE_USER_ID']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="OrdPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="OrdAddr" value="없음">
		<INPUT TYPE="HIDDEN" NAME="RcpNm" value="<?=$_COOKIE['_CKE_USER_NAME']?>">
		<INPUT TYPE="HIDDEN" NAME="RcpPhone" value="<?=$rs[mobile]?>">
		<INPUT TYPE="HIDDEN" NAME="DlvAddr" value="없음">
		<INPUT TYPE="HIDDEN" NAME="UserEmail" value="<?=$_COOKIE['_CKE_USER_EMAIL']?>">


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
          <TD WIDTH="83" align="center" class="darkbrown"><strong>결제자</strong></TD>
          <TD width=8></TD>
          <TD width="250"><INPUT TYPE="TEXT" name="username" value="<?=$_COOKIE['_CKE_USER_NAME']?>" class="input01" style="width:120"></TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <TR height=26>
          <TD WIDTH="83" align="center" class="darkbrown"><strong>전화번호</strong></TD>
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
          <TD align="center" WIDTH="83"><strong>결제방법</strong></TD>
          <TD width=8></TD>
          <TD><INPUT TYPE="RADIO" name="pay_type" value="1">카드결제
            <INPUT TYPE="RADIO" name="pay_type" value="2" checked>핸드폰결제
            <INPUT TYPE="RADIO" name="pay_type" value="3">ARS카드결제</TD>
        </TR>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><strong>결제상품</strong></td>
          <TD width=8></TD>
          <TD><?=$contents_name?></TD>
        </tr>
        <tr>
          <td bgcolor="#EAEAEA" height=1 colspan=3></td>
        </tr>
        <tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><strong>결제금액</strong></td>
          <TD width=8></TD>
          <TD><?=number_format($mqf[price]);?>
            원</TD>
        </tr>

        <tr>
          <td bgcolor="#D5D2CD" height=1 colspan=3></td>
        </tr>

		<tr height=26>
          <td colspan=3 class="darkbrown" style="padding-left:10px"><strong>최소:<?=Number_format($_COIN_USE_MIN)?> Coin</strong>, <strong>최대:<?=Number_format($max_coin)?> Coin</strong> 결제가능<br> <strong>500 Coin단위</strong>로 결제</td>
        </tr>
		
		<tr>
          <td bgcolor="#D5D2CD" height=1 colspan=3></td>
        </tr>

		<tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><strong>가용코인</strong></td>
          <TD width=8></TD>
          <TD>
			<?=number_format($meminfo[total_coin])?> Coin &nbsp;(1Coin=10원)
		  </TD>
        </tr>
		<tr height=26>
          <td WIDTH="83" align="center" class="darkbrown"><input type="checkbox" name="spend_point" value="Y" onclick="Javascript:point_use(this.checked)" <? if($meminfo[total_coin] < $_COIN_USE_MIN || !month_by_point_check($_COOKIE[_CKE_USER_UID])) echo "disabled"; ?>><strong>사용하기</strong></td>
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