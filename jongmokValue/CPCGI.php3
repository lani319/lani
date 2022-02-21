<html>
<head>
<title> CPCGI </title>
</head>
<body> 
<?php  
function Parsor($explode, $String) {  
	$tmp = explode($explode,$String);  
	$cnt = count($String);  
	for ( $i=0;$i<$cnt;$i++ ) {  
		$token = explode("=",$String[$i]);  
		$name = trim($token[0]);  
		$value = trim($token[1]);  
		$Out[$name] = $value;  
	}  
	return $Out;
}

?>
<p>
<?php
$Input1 = sprintf("ServerInfo=%s; EncodedTID=%s", $ServerInfo, $EncodedTID);  
exec("./Confirm '$Input1'",$a1,$b1);  
$Results	= Parsor("\n",$a1);  
$Result 	= $Results[Result];  
$ErrorMessage 	= $Results[ErrMsg];		// Result 가 0이 아닐 경우  
$TotalAmount	= $Results[TotalAmount];	// Result 가 0이고 정액제인 경우  
$Cap		= $Results[Cap];		// Result 가 0이고 정률제인 경우  
$TID		= $Results[TID];		// 결제의 고유번호  
$ErrorFlag = 0;  


if( $Result == 0 ){
	$Input2 = sprintf("ServerInfo=%s;", $ServerInfo);  
	exec("./Bill '$Input2'",$a2,$b2);  
	$Results	= Parsor("\n",$a2);  
	$Result 	= $Results[Result];  
	$ErrorMessage 	= $Results[ErrMsg];		// Result 가 0이 아닐 경우  
	
	if(strcmp($Result, "0") == 0){  
		$ErrorFlag = 0;
	}else if(strcmp($Result, "-1") == 0){  
		$ErrorMessage = "(Bill) 내부 오류 입니다.<br>" . $ErrorMessage;  
		$ErrorFlag = 1;  
	}else{
		$ErrorMessage = "(Bill)" . $ErrorMessage;  
		$ErrorFlag = 1;  
	}
}else if( $Result == "-1" ){  
	$ErrorMessage = "(Confirm) 내부 오류 입니다. 파라메터들을 을 확인하여 주세요.<br>" . $ErrorMessage;  
	$ErrorFlag = 1;  
}else{
	$ErrorMessage = "(Confirm)" . $ErrorMessage;  
	$ErrorFlag = 1;  
}
if ($ErrorFlag == 0){  
	/* 유저 추가 */
	include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";
	
	/* DB Connection */
	
	$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
	
	/*
	$val[0]:$order_no, $val[1]:$order_name, $val[2]:$phone, $val[3]:$order_email, $val[4]:$price, $val[5]:$price_mf, $val[6]:$vat, $val[7]:$user_uid, $val[8]:$user_uid
	*/
	
	$val=explode("|",$Buffer);
	if(!$val[0] || !$val[1] || !$val[2] || !$val[3] || !$val[4]){
		echo("<script>window.alert('정상적이지 않은 방법으로 본 페이지에 접속하셨거나 결제가 실패했습니다. 관리자에게 문의해 주세요.');self.close();</script>");
		exit;
	}
	
	/* 결제 승인 처리 */
	/*
	TID : 122213132640257850
	5945-0612221311|244|349|500|5945|hanomana|01997251181
	349 || 5945 || 5945 || || 244 
	*/
	
	$SQL="SELECT * from jongmokValueChargeInfo where idx='".$val[1]."'";
	$charge_info=mysql_fetch_array(mysql_query($SQL));
	
	//echo $charge_info[idx]." || ".$_COOKIE['_CKE_USER_UID']." || ".$charge_info[uidx]." || ".$conidx." || ".$charge_info[bidx];
	
	if(!$charge_info[idx] || $_COOKIE['_CKE_USER_UID']!=$charge_info[memIdx]){
		popupMsg("잘못된 결제 정보가 들어 왔습니다. 관리자에게 문의해 주세요.");
		echo "<script> window.close(); </script>";
		exit();
	}

	
	$SQL="UPDATE jongmokValueChargeInfo set state = '10' , paydate = now()  WHERE idx='".$val[1]."'";
	mysql_query($SQL);	



	
	/* 결제 승인 처리 */
	//////////////////////////////////////////////////////////////////////////  
	//////////////////////////////////////////////////////////////////////////  
	//								//  
	//    정상적인 수행 처리시 여기에 결재에 관련된 CP의 php 코드를 삽입.			//  
	//							//
	//							//
	//////////////////////////////////////////////////////////////////////////  
	//////////////////////////////////////////////////////////////////////////  
	// Buffer를 활용해 주세요  
	// Buffer="Ready 페이지에서 입력한 값|휴대폰번호"  
	//////////////////////////////////////////////////////////////////////////  
	//다음은 테스트를 위한 페이지 입니다.   
	//설치가 완료되면 원하시는 페이지로 이동하시고 
	//이동하신 페이지에서 DB작업을 해주십시오.
	
?> 

<form name="SucessForm" action="/lani/jongmokValue/mobile_pay_result.html" method="post">
<input type="hidden" name="order_id" value="<?=$val[0]?>">
<input type="hidden" name="insert_id" value="<?=$val[1]?>">
</form>
<script language="javascript">
opener.location.reload();
document.SucessForm.submit();
</script>
<p>
<?php  
}else{
	$Debug = sprintf("\nConfirm Input = %s\n Bill Input = %s\n a1[0] = %s\n a1[1] = %s\n a1[2] = %s\n a2[0] = %s\n a2[1] = %s\n a2[2] = %s\n",  
	$Input1,  
	$Input2,  
	$a1[0],  
	$a1[1],  
	$a1[2],  
	$a2[0],  
	$a2[1],  
	$a2[2]);  
?>  
<!-- Error 시 처리 	-->
<form name="ErrorForm" action="http://web.teledit.com/teledit/Error.php3" method="post">
<input type="hidden" name ="ErrorMessage"	value="<?php echo("$ErrorMessage"); ?>">
<input type="hidden" name ="Debug"		value="<?php echo("$Debug"); ?>">
</form>
<script language="javascript">
	document.ErrorForm.submit();
</script>
<!-- -->
<p>
<?php 
}
?>
</body>
</html>
<!-- Debug Info -->