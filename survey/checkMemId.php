<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$name = trim($txtMemName);
$ssn1 = trim($txtMemSSN1);
$ssn2 = trim($txtMemSSN2);



$usernum_enc=numEnc($ssn1.$ssn2);


$query = "select userID from Member where userName='$name' and userNum = '$usernum_enc'";

$tmpRs = mysql_query($query);
$rs = mysql_fetch_array($tmpRs);
$memId =  $rs["userID"];

if ($memId != "" )
{
?>

<script type="text/javascript">
alert("귀하의 아이디는 <?= $memId?> 입니다.");
 parent.opener.form1.txtMemId.value = "<?=$memId?>";
 parent.opener.form1.txtMemName.value = "<?=$name?>";
 parent.opener.form1.txtMemSSN.value = "<?=$ssn1?>";
 parent.opener.form1.txtMemMobile1.focus();
 parent.self.close();
</script>

<?php
}
else 
{
	?>
<script type="text/javascript">
alert("성명과 비밀번호를 다시 확인 해 주세요");
</script>	
<?php
}
?>