<?php 
@extract($_GET);
@extract($_POST);
@extract($_SERVER);

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";

//   CP ���� �����ؾ� �� �κ�. 
// 
// * $Input  : ID, PWD, ItemType, ItemCount, ItemInfo 
// * $Traget : Return �ɼ� �ִ� CPCGI.php3�� ��ü ��� 
// 
// 
//   ���� ���� 
// * $Input ���� ��ҹ��� ���� 
// * $Target���� 'http://xxx.xxx.xxx.xxx/CPCGI.php3' ������ ��ü ��θ� �� ��. 
// 
// Parameter ���� : $Input, $Target
//$Input= "ID=test;PWD=test;ItemType=Amount;ItemCount =1;ItemInfo = 1|0|1|1270000000|test"; 
//$Target= "http://211.42.165.54/TEST/CPCGI.php3"; 
//$Buffer = "�ƹ��ų� ������."; 


$ErrorFlag = 0; 
/* DB Connection */

$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
?>
<html>
<head>
	<title> Ready </title>
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
<?
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�ʼ� �Է� ���� ���� �Ǿ����ϴ�.");
	echo "<script> window.close(); </script>";
	exit;
}
$user_uid=$_COOKIE['_CKE_USER_UID'];
$user_id=$_COOKIE['_CKE_USER_ID'];
$Input	= "ID=".$_MOBILE_PAY_CPID.";PWD=".$_MOBILE_PAY_PASSWORD.";ItemType=Amount;ItemCount=1;ItemInfo=1|$price|1|".$_MOBILE_PAY_PID."|".$_MOBILE_PAY_PASSWORD;
$Target= "http://".$_SERVER['SERVER_NAME']."/lani/jongmokValue/CPCGI.php3"; 
$Buffer = $buy_no."|".$insert_id."|".$price."|".$_COOKIE['_CKE_USER_UID']."|".$_COOKIE['_CKE_USER_ID']."|".$jokmok;

//echo $Input;
// RegistItem ���� 
exec("./RegistItem '$Input'",$a,$b); 
$Results	= Parsor("\n",$a); 
$Result 	= $Results[Result]; 
$ServerInfo 	= $Results[ServerInfo];	// Result �� 0�� ���  
$ErrorMessage 	= $Results[ErrMsg];	// Result �� 0�� �ƴ� ��� 

print_r($Results);
echo $ServerInfo.'<br>';
echo $Target.'<br>';
echo $Buffer.'<br>';

exit();
if($Result == 0){ // ���������� ó���Ǿ��� ���. 
?> 
	<form name="ReadyForm" action="http://web.teledit.com/teledit/Start.php3" method="post">
	<input type="hidden" name="ServerInfo" value="<?php echo("$ServerInfo");?>">
	<input type="hidden" name="Target"     value="<?php echo("$Target");  ?>">
	<input type="hidden" name="Buffer"     value="<?php echo("$Buffer");  ?>">
	<!--			<input type= submit value= '����'> 	<!-- -->
	</form>
<?
}else if( $Result == -1 ){ // ���������� ó������ �ʾ��� ���. 
	$ErrorMessage = "���� ���� �Դϴ�.<br> Input �� �� �Ķ���͵��� �� Ȯ���Ͽ� �ּ���.<br>" . $ErrorMessage; 
	$ErrorFlag = 1; 
}else{ 
	$ErrorFlag = 1; 
} 
if ($ErrorFlag == 1){

?>
	<p></p>
	<div align="center"> 
	<table border="1" width="450" cellspacing="0" cellpadding="0" bordercolorlight="#000000" bordercolordark="#ffffff">
	<CENTER class=main>
	<tr bgcolor="#ffcc00"> 
		<td valign="center" align="middle" height="30" width="420"> 
			<p><font color="#ffffff"><font color="#000000"><span style="FONT-SIZE: 10pt">&lt;�޴����� �̿��� ����� ���� �ý���</font><b>
			<font color="#006633">Teledit</font></b>
			<font color="#000000">&gt;</SPAN></font></font></p>
		</td>
	</tr>
	<tr bgcolor="#ffffff"> 
		<td><p><br>
			<p align=center> 
			<font size=2 color="#ff00ff"> <span style="BACKGROUND-COLOR: #ffffff">Error&nbsp;Information</span></font>   </p>  
			<p align=center><span class="main"><?php echo("$ErrorMessage"); ?><font color="#000000"> </font></span><br></p> 
			<p align="center">
				<INPUT type="button" value=" �� �� " onclick="history.go(-1);" style="font-family:����; background-color:rgb(226,229,255); border-style:groove;"  id=button1 name=button1>
			</p>  
			<p>
		</td>
	</tr> 
	</CENTER>  
	</table> 
	<p>&nbsp;</p>
	</div>
<?php
} 
?>
</body>
</html>
<script language="javascript">
document.ReadyForm.submit();
</script>
<!-- -->

<!-- Debug Info
<?php 
echo("$a[0]\n");
echo("$a[1]\n");
echo("$a[2]\n"); 
echo $Result.",";
echo $ServerInfo.",";
echo $ErrorMessage.",";
?>
-->