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
$ErrorMessage 	= $Results[ErrMsg];		// Result �� 0�� �ƴ� ���  
$TotalAmount	= $Results[TotalAmount];	// Result �� 0�̰� �������� ���  
$Cap		= $Results[Cap];		// Result �� 0�̰� �������� ���  
$TID		= $Results[TID];		// ������ ������ȣ  
$ErrorFlag = 0;  


if( $Result == 0 ){
	$Input2 = sprintf("ServerInfo=%s;", $ServerInfo);  
	exec("./Bill '$Input2'",$a2,$b2);  
	$Results	= Parsor("\n",$a2);  
	$Result 	= $Results[Result];  
	$ErrorMessage 	= $Results[ErrMsg];		// Result �� 0�� �ƴ� ���  
	
	if(strcmp($Result, "0") == 0){  
		$ErrorFlag = 0;
	}else if(strcmp($Result, "-1") == 0){  
		$ErrorMessage = "(Bill) ���� ���� �Դϴ�.<br>" . $ErrorMessage;  
		$ErrorFlag = 1;  
	}else{
		$ErrorMessage = "(Bill)" . $ErrorMessage;  
		$ErrorFlag = 1;  
	}
}else if( $Result == "-1" ){  
	$ErrorMessage = "(Confirm) ���� ���� �Դϴ�. �Ķ���͵��� �� Ȯ���Ͽ� �ּ���.<br>" . $ErrorMessage;  
	$ErrorFlag = 1;  
}else{
	$ErrorMessage = "(Confirm)" . $ErrorMessage;  
	$ErrorFlag = 1;  
}
if ($ErrorFlag == 0){  
	/* ���� �߰� */
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
		echo("<script>window.alert('���������� ���� ������� �� �������� �����ϼ̰ų� ������ �����߽��ϴ�. �����ڿ��� ������ �ּ���.');self.close();</script>");
		exit;
	}
	
	/* ���� ���� ó�� */
	/*
	TID : 122213132640257850
	5945-0612221311|244|349|500|5945|hanomana|01997251181
	349 || 5945 || 5945 || || 244 
	*/
	
	$SQL="SELECT * from jongmokValueChargeInfo where idx='".$val[1]."'";
	$charge_info=mysql_fetch_array(mysql_query($SQL));
	
	//echo $charge_info[idx]." || ".$_COOKIE['_CKE_USER_UID']." || ".$charge_info[uidx]." || ".$conidx." || ".$charge_info[bidx];
	
	if(!$charge_info[idx] || $_COOKIE['_CKE_USER_UID']!=$charge_info[memIdx]){
		popupMsg("�߸��� ���� ������ ��� �Խ��ϴ�. �����ڿ��� ������ �ּ���.");
		echo "<script> window.close(); </script>";
		exit();
	}

	
	$SQL="UPDATE jongmokValueChargeInfo set state = '10' , paydate = now()  WHERE idx='".$val[1]."'";
	mysql_query($SQL);	



	
	/* ���� ���� ó�� */
	//////////////////////////////////////////////////////////////////////////  
	//////////////////////////////////////////////////////////////////////////  
	//								//  
	//    �������� ���� ó���� ���⿡ ���翡 ���õ� CP�� php �ڵ带 ����.			//  
	//							//
	//							//
	//////////////////////////////////////////////////////////////////////////  
	//////////////////////////////////////////////////////////////////////////  
	// Buffer�� Ȱ���� �ּ���  
	// Buffer="Ready ���������� �Է��� ��|�޴�����ȣ"  
	//////////////////////////////////////////////////////////////////////////  
	//������ �׽�Ʈ�� ���� ������ �Դϴ�.   
	//��ġ�� �Ϸ�Ǹ� ���Ͻô� �������� �̵��Ͻð� 
	//�̵��Ͻ� ���������� DB�۾��� ���ֽʽÿ�.
	
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
<!-- Error �� ó�� 	-->
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