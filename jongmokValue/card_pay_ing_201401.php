<?php
/*
2014년 1월, 결제방식 변경. 1개는 1+1 , 10개는 3만원 고정. 어윤학
2015년 8월 27일, 결제방식 다시 변경. 1+1 폐지. 이진숙 과장 지시. 어윤학.
*/
/**********************************************************************************************
*
* 파일명 : AGS_pay_ing.php
* 최종수정일자 : 2006/08/03
*
* 올더게이트 플러그인에서 리턴된 데이타를 받아서 소켓결제요청을 합니다.
*
* Copyright 2005-2006 AEGISHYOSUNG.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/

/** Function Library **/ 
require "aegis_Func.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/**************************************************************************************
*
* [1] 올더게이트 결제시 사용할 로컬 통신서버 IP/Port 번호
*
* $IsDebug		: 올더게이트와 주고받는 전문을 웹 브라우저에 출력 (1:출력, 0:미출력(기본값)) 
* $LOCALADDR	: PG서버와 통신을 담당하는 암호화Process가 위치해 있는 IP
* $LOCALPORT	: 포트
* $ENCRYPT		: 0:안심클릭,일반결제 2:ISP
* $CONN_TIMEOUT : 암호화 데몬과 접속 Connect타임아웃 시간(초)
* $READ_TIMEOUT : 데이터 수신 타임아웃 시간(초)
* 
***************************************************************************************/

$IsDebug = 0;
$LOCALADDR = "121.133.126.1";
$LOCALPORT = "29760";
$ENCTYPE = 0;
$CONN_TIMEOUT = 10;
$READ_TIMEOUT = 30;


/****************************************************************************
*
* [2] AGS_pay.html 로 부터 넘겨받을 데이타
*
****************************************************************************/

/*공통사용*/
$AuthTy		= trim($_POST["AuthTy"]);			//결제형태
$SubTy 		= trim($_POST["SubTy"]);			//서브결제형태
$StoreId 	= trim($_POST["StoreId"]);			//상점아이디
$OrdNo 		= trim($_POST["OrdNo"]);			//주문번호	(stBoard테이블의 idx값)//이거한번확인
$Amt 		= trim($_POST["Amt"]);				//금액	//mgf[price] //이거한번확인
$UserEmail	= trim($_POST["UserEmail"]);		//주문자이메일
$ProdNm 	= trim($_POST["ProdNm"]);			//상품명
/*신용카드&가상계좌사용*/
$MallUrl 	= trim($_POST["MallUrl"]);			//MallUrl(무통장입금) - 상점 도메인 가상계좌추가//http://www.502.co.kr
$UserId 	= trim($_POST["UserId"]);			//회원아이디


/*신용카드사용*/
$OrdNm 		= trim($_POST["OrdNm"]);			//주문자명
$OrdPhone	= trim($_POST["OrdPhone"]);			//주문자연락처
$OrdAddr 	= trim($_POST["OrdAddr"]);			//주문자주소 가상계좌추가
$RcpNm 		= trim($_POST["RcpNm"]);			//수신자명
$RcpPhone	= trim($_POST["RcpPhone"]);			//수신자연락처
$DlvAddr	= trim($_POST["DlvAddr"]);			//배송지주소
$Remark 	= trim($_POST["Remark"]);			//비고
$DeviId 	= trim($_POST["DeviId"]);			//단말기아이디
$AuthYn 	= trim($_POST["AuthYn"]);			//인증여부
$Instmt 	= trim($_POST["Instmt"]);			//할부개월수
$UserIp 	= $_SERVER["REMOTE_ADDR"];			//회원 IP
$expert_idx = trim($_POST["expert_idx"]);		//전문가 idx값(한승주 추가)
$mem_idx	= trim($_POST["mem_idx"]);			//회원 idx값(한승주 추가)
$jokmok		= trim($_POST["jokmok"]);

/*신용카드(ISP)*/
$partial_mm 		= trim($_POST["partial_mm"]);	//일반할부기간
$noIntMonth 		= trim($_POST["noIntMonth"]);	//무이자할부기간
$KVP_CURRENCY 		= trim($_POST["KVP_CURRENCY"]);	//KVP_통화코드
$KVP_CARDCODE 		= trim($_POST["KVP_CARDCODE"]);	//KVP_카드사코드
$KVP_SESSIONKEY 	= $_POST["KVP_SESSIONKEY"];		//KVP_SESSIONKEY
$KVP_ENCDATA 		= $_POST["KVP_ENCDATA"];		//KVP_ENCDATA
$KVP_CONAME 		= trim($_POST["KVP_CONAME"]);	//KVP_카드명
$KVP_NOINT 			= trim($_POST["KVP_NOINT"]);	//KVP_무이자=1 일반=0
$KVP_QUOTA 			= trim($_POST["KVP_QUOTA"]);	//KVP_할부개월

/*신용카드(안심)*/
$CardNo 			= trim($_POST["CardNo"]);		//카드번호
$MPI_CAVV 			= $_POST["MPI_CAVV"];			//MPI_CAVV
$MPI_ECI 			= $_POST["MPI_ECI"];			//MPI_ECI
$MPI_MD64 			= $_POST["MPI_MD64"];			//MPI_MD64

/*신용카드(일반)*/
$ExpMon 	= trim($_POST["ExpMon"]);				//유효기간(월)
$ExpYear 	= trim($_POST["ExpYear"]);				//유효기간(년)
$Passwd 	= trim($_POST["Passwd"]);				//비밀번호
$SocId 		= trim($_POST["SocId"]);				//주민등록번호/사업자등록번호

/*계좌이체사용*/
$ICHE_OUTBANKNAME	= trim($_POST["ICHE_OUTBANKNAME"]);		//이체은행명
$ICHE_OUTACCTNO 	= trim($_POST["ICHE_OUTACCTNO"]);		//이체계좌번호
$ICHE_OUTBANKMASTER = trim($_POST["ICHE_OUTBANKMASTER"]);	//이체계좌소유주
$ICHE_AMOUNT 		= trim($_POST["ICHE_AMOUNT"]);			//이체금액

/*핸드폰사용*/
$HP_SERVERINFO 		= trim($_POST["HP_SERVERINFO"]);		//SERVER_INFO(핸드폰결제)
$HP_HANDPHONE 		= trim($_POST["HP_HANDPHONE"]);			//HANDPHONE(핸드폰결제)
$HP_COMPANY 		= trim($_POST["HP_COMPANY"]);			//COMPANY(핸드폰결제)
$HP_ID 				= trim($_POST["HP_ID"]);				//HP_ID(핸드폰결제)
$HP_SUBID 			= trim($_POST["HP_SUBID"]);				//HP_SUBID(핸드폰결제)
$HP_UNITType 		= trim($_POST["HP_UNITType"]);			//HP_UNITType(핸드폰결제)
$HP_IDEN 			= trim($_POST["HP_IDEN"]);				//HP_IDEN(핸드폰결제)
$HP_IPADDR 			= trim($_POST["HP_IPADDR"]);			//HP_IPADDR(핸드폰결제)

/*가상계좌사용*/
$VIRTUAL_CENTERCD	= trim($_POST["VIRTUAL_CENTERCD"]);		//은행코드(가상계좌)
$VIRTUAL_DEPODT 	= trim($_POST["VIRTUAL_DEPODT"]);		//입금예정일(가상계좌)
$ZuminCode 			= trim($_POST["ZuminCode"]);			//주민번호(가상계좌)
$MallPage 			= trim($_POST["MallPage"]);				//상점 입/출금 통보 페이지(가상계좌)
$VIRTUAL_NO 		= trim($_POST["VIRTUAL_NO"]);			//가상계좌번호(가상계좌)

/*우리에스크로사용*/
$mTId 				= trim($_POST["mTId"]);					//우리에스크로 주문번호



$leader			= trim($_POST["leader"]);	//기수
$leader_level	= trim($_POST["leader_level"]);	//종류
$userNickname	= trim($_POST["userNickname"]);	//닉네임




/****************************************************************************
*
* [3] 데이타의 유효성을 검사합니다.
*
****************************************************************************/
if($_SESSION['b'.$jokmok] != $Amt ){ ?>
	<script>
		alert("결제금액과 상이합니다.");
		history.back(-1);
	</script>
	<?
	exit();
}

$ERRMSG = "";

if( empty( $StoreId ) || $StoreId == "" )
{
	$ERRMSG .= "상점아이디 입력여부 확인요망 <br>";		//상점아이디
}

if( empty( $OrdNo ) || $OrdNo == "" )
{
	$ERRMSG .= "주문번호 입력여부 확인요망 <br>";		//주문번호
}

if( empty( $ProdNm ) || $ProdNm == "" )
{
	$ERRMSG .= "상품명 입력여부 확인요망 <br>";			//상품명
}

if( empty( $Amt ) || $Amt == "" )
{
	$ERRMSG .= "금액 입력여부 확인요망 <br>";			//금액
}

if( empty( $DeviId ) || $DeviId == "" )
{
	$ERRMSG .= "단말기아이디 입력여부 확인요망 <br>";	//단말기아이디
}

if( empty( $AuthYn ) || $AuthYn == "" )
{
	$ERRMSG .= "인증여부 입력여부 확인요망 <br>";		//인증여부
}



if( strlen($ERRMSG) == 0 )
{
	/****************************************************************************
	* ※ 결제 형태 변수의 값에 따른 결제 구분
	*
	* ＊ AuthTy  = "card"		신용카드결제
	*	 - SubTy = "isp"		안전결제ISP
	*	 - SubTy = "visa3d"		안심클릭
	*	 - SubTy = "normal"		일반결제
	*
	* ＊ AuthTy  = "iche"		일반-계좌이체
	* 
	* ＊ AuthTy  = "eiche"		에스크로-계좌이체
	*
	* ＊ AuthTy  = "virtual"		일반-가상계좌(무통장입금)
	* 
	* ＊ AuthTy  = "evirtual"	에스크로-가상계좌(무통장입금)
	* 
	* ＊ AuthTy  = "hp"			핸드폰결제
	*
	****************************************************************************/
	
	if( strcmp( $AuthTy, "card" ) == 0 )
	{
		if( strcmp( $SubTy, "isp" ) == 0 )
		{
			/****************************************************************************
			*
			* [4] 신용카드결제 - ISP
			* 
			* -- 이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
			* 가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
			* -- 데이터 길이는 매뉴얼 참고
			* 
			* -- 승인 요청 전문 포멧
			* + 데이터길이(6) + ISP구분코드(1) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 한다.)
			* 결제종류(6)		| 업체ID(20)		| 회원ID(20)	 		| 결제금액(12)		| 
			* 주문번호(40)	| 단말기번호(10)	| 수신인(40)			| 수신인전화(21)		| 
			* 배송지(100)	| 주문자명(40)	| 주문자연락처(100)	| 기타요구사항(350)	|
			* 상품명(300)	| 통화코드(3)	 	| 일반할부기간(2)		| 무이자할부기간(2)	| 
			* KVP카드코드(22)	| 세션키(256)	| 암호화데이터(2048) 	| 카드명(50)	 		|
			* 회원 IP(20)	| 회원 Email(50)	|
			* 
			* -- 승인 응답 전문 포멧
			* + 데이터길이(6) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 한다.
			* 업체ID(20)		| 전문코드(4)		| 거래고유번호(6)		| 승인번호(8)		| 
			* 거래금액(12)	| 성공여부(1)	 	| 실패사유(20)		| 승인시각(14)	| 
			* 카드사코드(4)	|
			*    
			* ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
			*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
			****************************************************************************/
			
			$ENCTYPE = 2;
			
			/****************************************************************************
			* 
			* 전송 전문 Make
			* 
			****************************************************************************/
			
			$sDataMsg = $ENCTYPE.
				"plug15"."|".
				$StoreId."|".
				$UserId."|".
				$Amt."|".
				$OrdNo."|".
				$DeviId."|".
				$RcpNm."|".
				$RcpPhone."|".
				$DlvAddr."|".
				$OrdNm."|".
				$OrdPhone."|".
				$Remark."|".
				$ProdNm."|".
				$KVP_CURRENCY."|".
				$partial_mm."|".
				$noIntMonth."|".
				$KVP_CARDCODE."|".
				$KVP_SESSIONKEY."|".
				$KVP_ENCDATA."|".
				$KVP_CONAME."|".
				$UserIp."|".
				$UserEmail."|";
	
			$sSendMsg = sprintf( "%06d%s", strlen( $sDataMsg ), $sDataMsg );
			
			/****************************************************************************
			* 
			* 전송 메세지 프린트
			* 
			****************************************************************************/
			
			if( $IsDebug == 1 )
			{
				print $sSendMsg."<br>";
			}
	
			/****************************************************************************
			* 
			* 암호화Process와 연결을 하고 승인 데이터 송수신
			* 
			****************************************************************************/
			
			$fp = fsockopen( $LOCALADDR, $LOCALPORT , $errno, $errstr, $CONN_TIMEOUT );
			
			if( !$fp )
			{
				/** 연결 실패로 인한 승인실패 메세지 전송 **/
				
				$rSuccYn = "n";
				$rResMsg = "연결 실패로 인한 승인실패";
			}
			else 
			{
				/** 연결에 성공하였으므로 데이터를 받는다. **/
				
				$rResMsg = "연결에 성공하였으므로 데이터를 받는다.";
				
				
				/** 승인 전문을 암호화Process로 전송 **/
				
				fputs( $fp, $sSendMsg );
				
				socket_set_timeout($fp, $READ_TIMEOUT);
				
				/** 최초 6바이트를 수신해 데이터 길이를 체크한 후 데이터만큼만 받는다. **/
				
				$sRecvLen = fgets( $fp, 7 );
				$sRecvMsg = fgets( $fp, $sRecvLen + 1 );

				//$sRecvLen = fgets( $fp, 6 );
				//$sRecvMsg = fgets( $fp, $sRecvLen );
			
				/****************************************************************************
				*
				* 데이터 값이 정상적으로 넘어가지 않을 경우 이부분을 수정하여 주시기 바랍니다.
				* PHP 버전에 따라 수신 데이터 길이 체크시 페이지오류가 발생할 수 있습니다
				* 에러메세지:수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패
				* 데이터 길이 체크 오류시 아래와 같이 변경하여 사용하십시오
				* $sRecvLen = fgets( $fp, 6 );
				* $sRecvMsg = fgets( $fp, $sRecvLen );
				*
				****************************************************************************/
				
				/** 소켓 close **/
				
				fclose( $fp );
			}
			
			/****************************************************************************
			* 
			* 수신 메세지 프린트
			* 
			****************************************************************************/
			
			if( $IsDebug == 1 )	
			{
				print $sRecvMsg."<br>";
			}
			
			if( strlen( $sRecvMsg ) == $sRecvLen )
			{
				/** 수신 데이터(길이) 체크 정상 **/
				
				$RecvValArray = array();
				$RecvValArray = explode( "|", $sRecvMsg );
			
				/** null 또는 NULL 문자, 0 을 공백으로 변환
				for( $i = 0; $i < sizeof( $RecvValArray); $i++ )
				{
					$RecvValArray[$i] = trim( $RecvValArray[$i] );
					
					if( !strcmp( $RecvValArray[$i], "null" ) || !strcmp( $RecvValArray[$i], "NULL" ) )
					{
						$RecvValArray[$i] = "";
					}
					
					if( IsNumber( $RecvValArray[$i] ) )
					{
						if( $RecvValArray[$i] == 0 ) $RecvValArray[$i] = "";
					}
				} **/
				
				$rStoreId = $RecvValArray[0];
				$rBusiCd = $RecvValArray[1];
				$rOrdNo = $OrdNo;
				$rDealNo = $RecvValArray[2];
				$rApprNo = $RecvValArray[3];
				$rProdNm = $ProdNm;
				$rAmt = $RecvValArray[4];
				$rInstmt = $KVP_QUOTA;
				$rSuccYn = $RecvValArray[5];
				$rResMsg = $RecvValArray[6];
				$rApprTm = $RecvValArray[7];
				$rCardCd = $RecvValArray[8];
				
				/****************************************************************************
				*
				* 신용카드결제(ISP) 결과가 정상적으로 수신되었으므로 DB 작업을 할 경우 
				* 결과페이지로 데이터를 전송하기 전 이부분에서 하면된다.
				*
				* 여기서 DB 작업을 해 주세요.
				* 주의) $rSuccYn 값이 'y' 일경우 신용카드승인성공
				* 주의) $rSuccYn 값이 'n' 일경우 신용카드승인실패
				* DB 작업을 하실 경우 $rSuccYn 값이 'y' 또는 'n' 일경우에 맞게 작업하십시오. 
				*
				****************************************************************************/
if($rSuccYn=="y"){
	$price = $rAmt;
	$buy_no=$mem_idx."-".date("ymdHis");
	$state = '3'; //신용카드 승인
	

	$SQL="INSERT INTO jongmokValueChargeInfo (
	memIdx,
	price,
	buy_no,
	state,
	signdate,
	paydate,
	cardName,
	cardNumber,
	bank,
	j_mobile,
	jongmok,
	b_name,
	settletype
	) 
	VALUES (
	'".$mem_idx."',
	'".$price."',
	'".$buy_no."',
	'".$state."',
	now(),
	now(),
	'".$OrdNm."',
	'".$rApprNo."',
	'',
	'".$OrdPhone."',
	'".$jokmok."',
	'',
	'1'
	);
	";

	mysql_query($SQL) or die(mysql_error());
	$insert_id=mysql_insert_id();
	
	//잔여 검색 카운트 증가 20140107 평택촌놈 어윤학 수정
	/*
	price가 11000, 30000 2개로 나뉨
	*/
	if($price == 11000)
	{
		$rCnt = 1;
	}
	else if ($price == 30000) {
		$rCnt = 10;		
	}
	$sql = "UPDATE Member SET jongmokCnt = jongmokCnt + $rCnt WHERE idx = $mem_idx";
	mysql_query($sql) or die(mysql_error());

}







			}
			else
			{
				/** 수신 데이터(길이) 체크 에러시 통신오류에 의한 승인 실패로 간주 **/
				
				$rSuccYn = "n";
				$rResMsg = "수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패";
			}
		}
		else if( ( strcmp( $SubTy, "visa3d" ) == 0 ) || ( strcmp( $SubTy, "normal" ) == 0 ) )
		{
			/****************************************************************************
			* 
			* [5] 신용카드결제 - VISA3D, 일반
			* 
			* -- 이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
			* 가장 핵심이 되는 부분이므로 수정후에는 실제 서비스전까지 적절한 테스트를 하여야 한다.
			* -- 데이터 길이는 매뉴얼 참고
			* 
			* -- 승인 요청 전문 포멧
			* + 데이터길이(6) + 암호화여부(1) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 하며 카드번호,유효기간,비밀번호,주민번호는 암호화된다.)
			* 결제종류(6)			| 업체ID(20)					| 회원ID(20)			| 결제금액(12)	| 주문번호(40)	|
			* 단말기번호(10)		| 카드번호(16)				| 유효기간(6)			| 할부기간(4)		| 인증유무(1)		| 
			* 카드비밀번호(2)		| 주민등록번호/사업자번호(10)	| 수신인(40)			| 수신인전화(21)	| 배송지(100)	|
			* 주문자명(40)		| 주문자연락처(100)			| 기타요구사항(350)	| 상품명(300)	|
			* 
			* -- 승인 응답 전문 포멧
			* + 데이터길이(6) + 데이터
			* + 데이터 포멧(데이터 구분은 "|"로 하며 암호화Process에서 해독된후 실데이터를 수신하게 된다.
			* 업체ID(20)		| 전문코드(4)		 | 주문번호(40)	| 승인번호(8)		| 거래금액(12)  |
			* 성공여부(1)		| 실패사유(20)	 | 카드사명(20) 	| 승인시각(14)	| 카드사코드(4)	|
			* 가맹점번호(15)	| 매입사코드(4)	 | 매입사명(20)	| 전표번호(6)		|
			* 
			* ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
			*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
			****************************************************************************/
			
			$ENCTYPE = 0;
			
			/****************************************************************************
			* 
			* 전송 전문 Make
			* 
			****************************************************************************/
			
			$sDataMsg = $ENCTYPE.
				"plug15"."|".
				$StoreId."|".
				$UserId."|".
				$Amt."|".
				$OrdNo."|".
				$DeviId."|".
				encrypt_aegis($CardNo)."|".
				encrypt_aegis($ExpYear.$ExpMon)."|".
				$Instmt."|".
				$AuthYn."|".
				encrypt_aegis($Passwd)."|".
				encrypt_aegis($SocId)."|".
				$RcpNm."|".
				$RcpPhone."|".
				$DlvAddr."|".
				$OrdNm."|".
				$UserIp.";".$OrdPhone."|".
				$UserEmail.";".$Remark."|".
				$ProdNm."|".
				$MPI_CAVV."|".
				$MPI_MD64."|".
				$MPI_ECI."|";
			
			$sSendMsg = sprintf( "%06d%s", strlen( $sDataMsg ), $sDataMsg );
			
			/****************************************************************************
			* 
			* 전송 메세지 프린트
			* 
			****************************************************************************/
			
			if( $IsDebug == 1 )
			{
				print $sSendMsg."<br>";
			}
	
			/****************************************************************************
			* 
			* 암호화Process와 연결을 하고 승인 데이터 송수신
			* 
			****************************************************************************/
			
			$fp = fsockopen( $LOCALADDR, $LOCALPORT , $errno, $errstr, $CONN_TIMEOUT );
			
			
			if( !$fp )
			{
				/** 연결 실패로 인한 승인실패 메세지 전송 **/
				
				$rSuccYn = "n";
				$rResMsg = "연결 실패로 인한 승인실패";
			}
			else 
			{
				/** 승인 전문을 암호화Process로 전송 **/
				
				fputs( $fp, $sSendMsg );
		
				socket_set_timeout($fp, $READ_TIMEOUT);
		
				/** 최초 6바이트를 수신해 데이터 길이를 체크한 후 데이터만큼만 받는다. **/
				
				$sRecvLen = fgets( $fp, 7 );
				$sRecvMsg = fgets( $fp, $sRecvLen + 1 );

				/****************************************************************************
				*
				* 데이터 값이 정상적으로 넘어가지 않을 경우 이부분을 수정하여 주시기 바랍니다.
				* PHP 버전에 따라 수신 데이터 길이 체크시 페이지오류가 발생할 수 있습니다
				* 에러메세지:수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패
				* 데이터 길이 체크 오류시 아래와 같이 변경하여 사용하십시오
				* $sRecvLen = fgets( $fp, 6 );
				* $sRecvMsg = fgets( $fp, $sRecvLen );
				*
				****************************************************************************/

				
				/** 소켓 close **/
				
				fclose( $fp );
			}
		
			/****************************************************************************
			* 
			* 수신 메세지 프린트
			* 
			****************************************************************************/
			
			if( $IsDebug == 1 )	
			{
				print $sRecvMsg."<br>";
			}
			
			if( strlen( $sRecvMsg ) == $sRecvLen )
			{
				/** 수신 데이터(길이) 체크 정상 **/
				
				$RecvValArray = array();
				$RecvValArray = explode( "|", $sRecvMsg );
			
				/** null 또는 NULL 문자, 0 을 공백으로 변환
				for( $i = 0; $i < sizeof( $RecvValArray); $i++ )
				{
					$RecvValArray[$i] = trim( $RecvValArray[$i] );
					
					if( !strcmp( $RecvValArray[$i], "null" ) || !strcmp( $RecvValArray[$i], "NULL" ) )
					{
						$RecvValArray[$i] = "";
					}
					
					if( IsNumber( $RecvValArray[$i] ) )
					{
						if( $RecvValArray[$i] == 0 ) $RecvValArray[$i] = "";
					}
				} **/
				
				$rStoreId = $RecvValArray[0];
				$rBusiCd = $RecvValArray[1];
				$rOrdNo = $RecvValArray[2];
				$rApprNo = $RecvValArray[3];
				$rInstmt = $Instmt;
				$rAmt = $RecvValArray[4];
				$rSuccYn = $RecvValArray[5];
				$rResMsg = $RecvValArray[6];
				$rCardNm = $RecvValArray[7];
				$rApprTm = $RecvValArray[8];
				$rCardCd = $RecvValArray[9];
				$rMembNo = $RecvValArray[10];
				$rAquiCd = $RecvValArray[11];
				$rAquiNm = $RecvValArray[12];
				$rBillNo = $RecvValArray[13];
				
				/****************************************************************************
				*
				* 신용카드결제(안심클릭, 일반결제) 결과가 정상적으로 수신되었으므로 DB 작업을 할 경우 
				* 결과페이지로 데이터를 전송하기 전 이부분에서 하면된다.
				*
				* 여기서 DB 작업을 해 주세요.
				* 주의) $rSuccYn 값이 'y' 일경우 신용카드승인성공
				* 주의) $rSuccYn 값이 'n' 일경우 신용카드승인실패
				* DB 작업을 하실 경우 $rSuccYn 값이 'y' 또는 'n' 일경우에 맞게 작업하십시오. 
				*
				****************************************************************************/

if($rSuccYn=="y"){
	$price = $rAmt;
	$buy_no=$mem_idx."-".date("ymdHis");
	$state = '3'; //신용카드 승인
	
	$SQL="INSERT INTO jongmokValueChargeInfo (
	memIdx,
	price,
	buy_no,
	state,
	signdate,
	paydate,
	cardName,
	cardNumber,
	bank,
	j_mobile,
	jongmok,
	b_name,
	settletype
	) 
	VALUES (
	'".$mem_idx."',
	'".$price."',
	'".$buy_no."',
	'".$state."',
	now(),
	now(),
	'".$OrdNm."',
	'".$rApprNo."',
	'',
	'".$OrdPhone."',
	'".$jokmok."',
	'',
	'1'
	);
	";
	mysql_query($SQL) or die(mysql_error());
	$insert_id=mysql_insert_id();
	
	//잔여 검색 카운트 증가 20140107 평택촌놈 어윤학 수정
	/*
	price가 11000, 30000 2개로 나뉨
	*/
	if($price == 11000)
	{
		$rCnt = 1;
	}
	else if ($price == 30000) {
		$rCnt = 10;		
	}
	$sql = "UPDATE Member SET jongmokCnt = jongmokCnt + $rCnt WHERE idx = $mem_idx";
	mysql_query($sql) or die(mysql_error());
}




			}
			else
			{
				/** 수신 데이터(길이) 체크 에러시 통신오류에 의한 승인 실패로 간주 **/
				
				$rSuccYn = "n";
				$rResMsg = "수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패";
			}
		}
	}
	else if( strcmp( $AuthTy, "iche" ) == 0 )
	{
		/****************************************************************************
		* 
		* [6] 계좌이체완료
		* 
		* 계좌이체는 올더게이트 플러그인에서 이체완료후 결과값만을 반환합니다.
		* 그러므로 현재 페이지에서는 올더게이트 소켓과 통신할 필요가 없습니다.
		* 계좌이체 결과내역을 DB에 저장하시려면 이부분에서 작업하십시오.
   		* 
		* 계좌이체를 사용하지않는 상점은 AGS_pay.html에서 지불방법을 꼭 신용카드(전용)으로 설정해 놓으시기 바랍니다.
		*  
		* ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
		*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
		****************************************************************************/
	
		$rStoreId = $StoreId;
		$rOrdNo = $OrdNo;
		$rProdNm = $ProdNm;
		$rAmt = $Amt;
		
		/****************************************************************************
		*
		* 여기서 DB 작업을 해 주세요.
		* 주의) 계좌이체의 경우 계좌이체성공일경우 본 페이지를 수행하도록 되어 있습니다.
		* ※ 필수처리변수 :	ICHE_OUTBANKNAME	: 이체은행명
		*					ICHE_OUTBANKMASTER	: 이체계좌예금주
		*					ICHE_AMOUNT			: 이체금액
		*
		****************************************************************************/







	}
	else if( strcmp( $AuthTy, "eiche" ) == 0 )
	{
		/****************************************************************************
		* 
		* [7] 에스크로-계좌이체완료
		* 
		* 계좌이체는 올더게이트 플러그인에서 이체완료후 결과값만을 반환합니다.
		* 그러므로 현재 페이지에서는 올더게이트 소켓과 통신할 필요가 없습니다.
		* 결좌이체 결과내역을 DB에 저장하시려면 이부분에서 작업하십시오.
		*  
		* 계좌이체를 사용하지않는 상점은 AGS_pay.html에서 지불방법을 꼭 신용카드(전용) 으로 설정해놓으시기 바랍니다.
		*
		* ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
		*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
		****************************************************************************/
	
		$rStoreId = $StoreId;
		$rOrdNo = $OrdNo;
		$rProdNm = $ProdNm;
		$rAmt = $Amt;
		//$mTId
		
		/****************************************************************************
		*
		* 여기서 DB 작업을 해 주세요.
		* 주의) 계좌이체의 경우 계좌이체성공일경우 본 페이지를 수행하도록 되어 있습니다.
		* ※ 필수처리변수 :	ICHE_OUTBANKNAME	: 이체은행명
		*					ICHE_AMOUNT			: 이체금액
		*					OrdNm				: 주문자명
		*					mTId				: 에스크로주문번호
		*
		****************************************************************************/







	}
    	else if( strcmp( $AuthTy, "virtual" ) == 0 ) //가상계좌추가
	{
		/****************************************************************************
		*
		* [8] 가상계좌 결제
		* 
		* -- 이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
		* 가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
		* -- 데이터 길이는 매뉴얼 참고
		* 
		* -- 승인 요청 전문 포멧
		* + 데이터길이(6) + 암호화 구분(1) + 데이터
		* + 데이터 포멧(데이터 구분은 "|"로 한다.)
		* 결제종류(10)		| 업체ID(20)		| 주문번호(40)	 	| 은행코드(4)			| 가상계좌번호(20) |
		* 거래금액(13)		| 입금예정일(8)	| 구매자명(20)		| 주민번호(13)		| 
		* 이동전화(21)		| 이메일(50)		| 구매자주소(100)		| 수신자명(20)		|
		* 수신자연락처(21)	| 배송지주소(100)	| 상품명(100)		| 기타요구사항(300)	| 상점 도메인(50)	 |	상점 페이지(100)|
		* 
		* -- 승인 응답 전문 포멧
		* + 데이터길이(6) + 암호화 구분(1) + 데이터
		* + 데이터 포멧(데이터 구분은 "|"로 한다.
		* 결제종류(10)	| 업체ID(20)		| 승인일자(14)	| 가상계좌번호(20)	| 결과코드(1)		| 결과메시지(100)	 | 
		*
		* 가상계좌 일반 : vir_n 유클릭 : vir_u 에스크로 : vir_s   
		* 가상계좌번호 및 상품명 추가 2005-11-10
		*
		* ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
		*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
		*
		****************************************************************************/
		
		$ENCTYPE = "V";
		
		/****************************************************************************
		* 
		* 전송 전문 Make
		* 
		****************************************************************************/
		
		$sDataMsg = $ENCTYPE.
			/* $AuthTy."|". */
			"vir_n|".
			$StoreId."|".
			$OrdNo."|".
			$VIRTUAL_CENTERCD."|".
			$VIRTUAL_NO."|". 
			$Amt."|".
			$VIRTUAL_DEPODT."|".
			$OrdNm."|".
			$ZuminCode."|".
			$OrdPhone."|".
			$UserEmail."|".
			$OrdAddr."|".
			$RcpNm."|".
			$RcpPhone."|".
			$DlvAddr."|".
			$ProdNm."|".
			$Remark."|".
			$MallUrl."|".
			$MallPage."|";
			
		$sSendMsg = sprintf( "%06d%s", strlen( $sDataMsg ), $sDataMsg );
		
		/****************************************************************************
		* 
		* 전송 메세지 프린트
		* 
		****************************************************************************/
		
		if( $IsDebug == 1 )
		{
			print $sSendMsg."<br>";
		}
		
		/****************************************************************************
		* 
		* 암호화Process와 연결을 하고 승인 데이터 송수신
		* 
		****************************************************************************/
		
		$fp = fsockopen( $LOCALADDR, $LOCALPORT , $errno, $errstr, $CONN_TIMEOUT );
		
		if( !$fp )
		{
			/** 연결 실패로 인한 승인실패 메세지 전송 **/
			
			$rSuccYn = "n";
			$rResMsg = "연결 실패로 인한 승인실패";
		}
		else 
		{
			/** 연결에 성공하였으므로 데이터를 받는다. **/
			
			$rResMsg = "연결에 성공하였으므로 데이터를 받는다.";
			
			/** 승인 전문을 암호화Process로 전송 **/
			
			fputs( $fp, $sSendMsg );
			
			socket_set_timeout($fp, $READ_TIMEOUT);
			
			/** 최초 6바이트를 수신해 데이터 길이를 체크한 후 데이터만큼만 받는다. **/
			
			$sRecvLen = fgets( $fp, 7 );
			$sRecvMsg = fgets( $fp, $sRecvLen + 1 );
			
			/****************************************************************************
			*
			* 데이터 값이 정상적으로 넘어가지 않을 경우 이부분을 수정하여 주시기 바랍니다.
			* PHP 버전에 따라 수신 데이터 길이 체크시 페이지오류가 발생할 수 있습니다
			* 에러메세지:수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패
			* 데이터 길이 체크 오류시 아래와 같이 변경하여 사용하십시오
			* $sRecvLen = fgets( $fp, 6 );
			* $sRecvMsg = fgets( $fp, $sRecvLen );
			*
			****************************************************************************/
			
			/** 소켓 close **/
			
			fclose( $fp );
		}
		
		/****************************************************************************
		* 
		* 수신 메세지 프린트
		* 
		****************************************************************************/
		
		if( $IsDebug == 1 )	
		{
			print $sRecvMsg."<br>";
		}
		
		if( strlen( $sRecvMsg ) == $sRecvLen )
		{
			/** 수신 데이터(길이) 체크 정상 **/
			
			$RecvValArray = array();
			$RecvValArray = explode( "|", $sRecvMsg );
			
			/** null 또는 NULL 문자, 0 을 공백으로 변환
			for( $i = 0; $i < sizeof( $RecvValArray); $i++ )
			{
			$RecvValArray[$i] = trim( $RecvValArray[$i] );
			
			if( !strcmp( $RecvValArray[$i], "null" ) || !strcmp( $RecvValArray[$i], "NULL" ) )
			{
			$RecvValArray[$i] = "";
			}
			
			if( IsNumber( $RecvValArray[$i] ) )
			{
			if( $RecvValArray[$i] == 0 ) $RecvValArray[$i] = "";
			}
			} **/
			
			$rAuthTy    = $RecvValArray[0];
			$rStoreId   = $RecvValArray[1];
			$rApprTm    = $RecvValArray[2];
			$rVirNo     = $RecvValArray[3];
			$rSuccYn    = $RecvValArray[4];
			$rResMsg    = $RecvValArray[5];
			
			$rOrdNo = $OrdNo;
			$rProdNm = $ProdNm;
			$rAmt = $Amt;
			
			/****************************************************************************
			*
			* 가상계좌배포 결과가 정상적으로 수신되었으므로 DB 작업을 할 경우 
			* 결과페이지로 데이터를 전송하기 전 이부분에서 하면된다.
			*
			* 여기서 DB 작업을 해 주세요.
			* 주의) $rSuccYn 값이 'y' 일경우 일반가상계좌결제승인성공
			* 주의) $rSuccYn 값이 'n' 일경우 일반가상계좌결제승인실패
			* DB 작업을 하실 경우 $rSuccYn 값이 'y' 또는 'n' 일경우에 맞게 작업하십시오. 
			*
			****************************************************************************/







		}
		else
		{
			/** 수신 데이터(길이) 체크 에러시 통신오류에 의한 승인 실패로 간주 **/
			
			$rSuccYn = "n";
			$rResMsg = "수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패";
		}
      }
      else if( strcmp( $AuthTy, "evirtual" ) == 0 )
	{
		/****************************************************************************
		* 
		*  [9] 에스크로-가상계좌(무통장입금)완료
		*
		*  가상계좌(무통장입금)는 올더게이트 플러그인에서 이체완료후 결과값만을 반환합니다.
		*  그러므로 현재 페이지에서는 올더게이트 소켓과 통신할 필요가 없습니다.
		*  결좌이체 결과내역을 DB에 저장하시려면 이부분에서 작업하십시오.
		* 
		*  가상계좌(무통장입금)를 사용하지않는 상점은 AGS_pay.html에서 지불방법을 꼭 신용카드(전용) 으로 설정해놓으시기 바랍니다.
		*
		*  ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
		*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
		****************************************************************************/

		$rStoreId = $StoreId;
		$rOrdNo = $OrdNo;
		$rProdNm = $ProdNm;
		$rAmt = $Amt;
		$rVirNo = $VIRTUAL_NO;
		/** $mTId **/
		
		/****************************************************************************
		*
		*  여기서 DB 작업을 해 주세요.
		*  주의) 가상계좌(무통장입금)의 경우 가상계좌(무통장입금)성공일경우 본 페이지를 수행하도록 되어 있습니다.
		*  ※ 필수처리변수 :	rVirNo				: 가상계좌번호
		*					VIRTUAL_CENTERCD	: 입금은행코드
		*					mTId				: 에스크로주문번호
		*
		****************************************************************************/







	}
	else if( strcmp( $AuthTy, "hp" ) == 0 )
	{
		/****************************************************************************
		* 
		* [7] 핸드폰 결제
		*
		*  핸드폰 결제를 사용하지않는 상점은 AGS_pay.html에서 지불방법을 꼭 신용카드(전용)으로 설정해 놓으시기 바랍니다.
		* 
		*  이부분은 승인 처리를 위해 암호화Process와 Socket통신하는 부분이다.
		*  가장 핵심이 되는 부분이므로 수정후에는 테스트를 하여야 한다.
		*  -- 승인 요청 전문 포멧
		*  + 데이터길이(6) + 핸드폰구분코드(1) + 데이터
		*  + 데이터 포멧(데이터 구분은 "|"로 한다.)
		* 
		*  -- 승인 응답 전문 포멧
		*  + 데이터길이(6) + 데이터
		*  + 데이터 포멧(데이터 구분은 "|"로 한다.
		*
		*  ※ "|" 값은 저희쪽에서 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
		*    결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
		****************************************************************************/
			
		$ENCTYPE = h;
		$StrSubTy = Bill;
		
		/****************************************************************************
		* 
		* 전송 전문 Make
		* 
		****************************************************************************/
		
		$sDataMsg = $ENCTYPE.
			$StrSubTy."|".
			$StoreId."|".
			$HP_SERVERINFO."|".
			$HP_ID."|".
			$HP_SUBID."|".
			$OrdNo."|".
			$Amt."|".
			$HP_UNITType."|".
			$HP_HANDPHONE."|".
			$HP_COMPANY."|".
			$HP_IDEN."|".
			$UserId."|".
			$UserEmail."|".
			$HP_IPADDR."|".
			$ProdNm."|";

		$sSendMsg = sprintf( "%06d%s", strlen( $sDataMsg ), $sDataMsg );

		/****************************************************************************
		* 
		* 전송 메세지 프린트
		* 
		****************************************************************************/
		
		if( $IsDebug == 1 )
		{
			print $sSendMsg."<br>";
		}

		/****************************************************************************
		* 
		* 암호화Process와 연결을 하고 승인 데이터 송수신
		* 
		****************************************************************************/
		
		$fp = fsockopen( $LOCALADDR, $LOCALPORT , $errno, $errstr, $CONN_TIMEOUT );
		
		
		if( !$fp )
		{
			/** 연결 실패로 인한 승인실패 메세지 전송 **/
			
			$rSuccYn = "n";
			$rResMsg = "연결 실패로 인한 승인실패";
		}
		else 
		{
			/** 승인 전문을 암호화Process로 전송 **/
			
			fputs( $fp, $sSendMsg );
			
			socket_set_timeout($fp, $READ_TIMEOUT);
			
			/** 최초 6바이트를 수신해 데이터 길이를 체크한 후 데이터만큼만 받는다. **/
			
			$sRecvLen = fgets( $fp, 7 );
			$sRecvMsg = fgets( $fp, $sRecvLen + 1 );
		
			/****************************************************************************
			*
			* 데이터 값이 정상적으로 넘어가지 않을 경우 이부분을 수정하여 주시기 바랍니다.
			* PHP 버전에 따라 수신 데이터 길이 체크시 페이지오류가 발생할 수 있습니다
			* 에러메세지:수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패
			* 데이터 길이 체크 오류시 아래와 같이 변경하여 사용하십시오
			* $sRecvLen = fgets( $fp, 6 );
			* $sRecvMsg = fgets( $fp, $sRecvLen );
			*
			****************************************************************************/
	
			/** 소켓 close **/
			
			fclose( $fp );
		}
		
		/****************************************************************************
		* 
		* 수신 메세지 프린트
		* 
		****************************************************************************/
		
		if( $IsDebug == 1 )	
		{
			print $sRecvMsg."<br>";
		}
		
		if( strlen( $sRecvMsg ) == $sRecvLen )
		{
			/** 수신 데이터(길이) 체크 정상 **/
			
			$RecvValArray = array();
			$RecvValArray = explode( "|", $sRecvMsg );
		
			/** null 또는 NULL 문자, 0 을 공백으로 변환
			for( $i = 0; $i < sizeof( $RecvValArray); $i++ )
			{
				$RecvValArray[$i] = trim( $RecvValArray[$i] );
				
				if( !strcmp( $RecvValArray[$i], "null" ) || !strcmp( $RecvValArray[$i], "NULL" ) )
				{
					$RecvValArray[$i] = "";
				}
				
				if( IsNumber( $RecvValArray[$i] ) )
				{
					if( $RecvValArray[$i] == 0 ) $RecvValArray[$i] = "";
				}
			} **/
			
			$rStoreId = $RecvValArray[0];	
			$rSuccYn = $RecvValArray[1];
			$rResMsg = $RecvValArray[2];
			$rHP_DATE = $RecvValArray[3];
			$rHP_TID = $RecvValArray[4];
			$rAmt = $Amt;
			$rOrdNo = $OrdNo;
			
			/****************************************************************************
			*
			* 핸드폰결제 결과가 정상적으로 수신되었으므로 DB 작업을 할 경우 
			* 결과페이지로 데이터를 전송하기 전 이부분에서 하면된다.
			*
			* 여기서 DB 작업을 해 주세요.
			* 주의) $rSuccYn 값이 'y' 일경우 핸드폰결제승인성공
			* 주의) $rSuccYn 값이 'n' 일경우 핸드폰결제승인실패
			* DB 작업을 하실 경우 $rSuccYn 값이 'y' 또는 'n' 일경우에 맞게 작업하십시오. 
			*
			****************************************************************************/







		}
		else
		{
			/** 수신 데이터(길이) 체크 에러시 통신오류에 의한 승인 실패로 간주 **/
			
			$rSuccYn = "n";
			$rResMsg = "수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패";
		}
	}
}
else
{
	$rSuccYn = "n";
	$rResMsg = $ERRMSG;
}
echo $ERRMSG;
?>
<html>
<head>
</head>
<body onload="javascript:frmAGS_pay_ing.submit();"> 
<form name=frmAGS_pay_ing method=post action="/lani/jongmokValue/card_pay_result.html">

<!-- 각 결제 공통 사용 변수 -->
<input type=hidden name=AuthTy value="<?=$AuthTy?>">		<!-- 결제형태 -->
<input type=hidden name=SubTy value="<?=$SubTy?>">			<!-- 서브결제형태 -->
<input type=hidden name=rStoreId value="<?=$rStoreId?>">	<!-- 상점아이디 -->
<input type=hidden name=rOrdNo value="<?=$rOrdNo?>">		<!-- 주문번호 -->
<input type=hidden name=rProdNm value="<?=$ProdNm?>">		<!-- 상품명 -->
<input type=hidden name=rAmt value="<?=$rAmt?>">			<!-- 결제금액 -->
<input type=hidden name=rOrdNm value="<?=$OrdNm?>">			<!-- 주문자명 -->
<input type=hidden name=rOrdPhone value="<?=$OrdPhone?>">	<!-- 연락처 -->
<input type=hidden name=rbookVolume value="<?=$bookVolume?>">	<!-- 수량 -->
<input type=hidden name=rzipcode value="<?=$zipcode?>">		<!-- 우편번호 -->
<input type=hidden name=raddress value="<?=$address?>">		<!-- 주소 -->



<input type=hidden name=rSuccYn value="<?=$rSuccYn?>">		<!-- 성공여부 -->
<input type=hidden name=rResMsg value="<?=$rResMsg?>">		<!-- 결과메시지 -->
<input type=hidden name=rApprTm value="<?=$rApprTm?>">		<!-- 결제시간 -->

<!-- 신용카드 결제 사용 변수 -->
<input type=hidden name=rBusiCd value="<?=$rBusiCd?>">		<!-- (신용카드공통)전문코드 -->
<input type=hidden name=rApprNo value="<?=$rApprNo?>">		<!-- (신용카드공통)승인번호 -->
<input type=hidden name=rCardCd value="<?=$rCardCd?>">		<!-- (신용카드공통)카드사코드 -->

<input type=hidden name=rCardNm value="<?=$rCardNm?>">		<!-- (안심클릭,일반사용)카드사명 -->
<input type=hidden name=rMembNo value="<?=$rMembNo?>">		<!-- (안심클릭,일반사용)가맹점번호 -->
<input type=hidden name=rAquiCd value="<?=$rAquiCd?>">		<!-- (안심클릭,일반사용)매입사코드 -->
<input type=hidden name=rAquiNm value="<?=$rAquiNm?>">		<!-- (안심클릭,일반사용)매입사명 -->
<input type=hidden name=rBillNo value="<?=$rBillNo?>">		<!-- (안심클릭,일반사용)전표번호 -->

<input type=hidden name=rDealNo value="<?=$rDealNo?>">		<!-- (ISP사용)거래고유번호 -->

<!-- 계좌이체 결제 사용 변수 -->
<input type=hidden name=ICHE_OUTBANKNAME value="<?=$ICHE_OUTBANKNAME?>">		<!-- 이체은행명 -->
<input type=hidden name=ICHE_OUTBANKMASTER value="<?=$ICHE_OUTBANKMASTER?>">	<!-- 이체계좌예금주 -->
<input type=hidden name=ICHE_AMOUNT value="<?=$ICHE_AMOUNT?>">					<!-- 이체금액 -->

<!-- 핸드폰 결제 사용 변수 -->
<input type=hidden name=rHP_HANDPHONE value="<?=$HP_HANDPHONE?>">				<!-- 핸드폰번호 -->
<input type=hidden name=rHP_COMPANY value="<?=$HP_COMPANY?>">					<!-- 통신사명(SKT,KTF,LGT) -->
<input type=hidden name=rHP_TID value="<?=$rHP_TID?>">							<!-- 결제TID -->
<input type=hidden name=rHP_DATE value="<?=$rHP_DATE?>">						<!-- 결제일자 -->

<!-- 가상계좌 결제 사용 변수 -->
<input type=hidden name=rVirNo value="<?=$rVirNo?>">							<!-- 가상계좌번호 -->
<input type=hidden name=VIRTUAL_CENTERCD value="<?=$VIRTUAL_CENTERCD?>">		<!-- 입금가상계좌은행코드(우리은행:20) -->

<!-- 우리에스크로 결제 사용 변수 -->
<input type=hidden name=mTId value="<?=$mTId?>">								<!-- 에스크로주문번호 -->

<!-- 추가변수 chargeContentsInfo테이블 insert idx값 (한승주) -->
<INPUT TYPE="HIDDEN" NAME="insert_id" value="<?=$insert_id?>">

<INPUT TYPE="HIDDEN" NAME="jokmok" value="<?=$jokmok?>">



</form>
</body>
</html>
