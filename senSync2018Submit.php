<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>  <!--����Ʈ ���� -->		
		<link href="senSync.css" rel="stylesheet" type="text/css"/>		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:700' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
//txtPtUserId �������� �Ѿ�� 502���̵�


if($idx){
	$sql = "update senMemberSync2018 set userPtIdx=$idx,agreeDate=now() where
	userSenId='$senid'";

	mysql_query($sql);

	echo "����ȭ �۾��� �Ϸ�Ǿ����ϴ�.";
	exit;
	
}else if($idx == "" && $txtPtUserId) { //502���� ��ȸ�ؼ� ������ �ٽ� �����ְ� ����, ������ ȸ������ �ȳ�

$sql = "select idx, userID, userNickname, userName, right(mobile,4), left(userNum_sub,6) from Member
where userId ='$txtPtUserId'";

//echo $sql;

$tmpRs = mysql_query($sql);
$ptMemberCnt = mysql_num_rows($tmpRs);

if($ptMemberCnt == 0)
{

echo "�����̳� ������Ʈ ���� ������ �����ϴ�. �ٽ� Ȯ���� �ּ���";
exit;

}else{
?>

	<table class="type07">
	<tr height="50px">
	<td>�����̳� ���̵�</td>
	<td>�����̳� �г���</td>
	<td>�̸�</td>
	<td>�ڵ��� ���ڸ�</td>
	<td>�������</td>
	<td>������ ������ üũ�� �ּ���</td>
	</tr>

<?php
		while ($rs = mysql_fetch_array($tmpRs)) {
		?>
		<tr valign="center">
		<td><?=$rs[1]?></td>
		<td><?=$rs[2]?></td>
		<td><?=$rs[3]?></td>
		<td><?=$rs[4]?></td>
		<td>
		<?php
		echo substr($rs[5],0,2)."��";
		echo substr($rs[5],2,2)."��";
		echo substr($rs[5],4,2)."��";
		?>
		</td>
		<td>
		<input type="radio" name="rdIdx" value="<?=$rs[1]?>" style="width:30px;height:30px" 
		onclick="setIdx('<?=$rs[0]?>');">

		<font color='red'>������ ������ üũ���ּ���</font>
		</td>
		</tr>
		<?php
		}
	}

}
?>
<tr valign="center">
<td colspan="10" height="50px" align="center">
<div class="row">
        <div class="col three">             
            <a href="#" onclick="submitForm();" class="btn btn-concrete">Ȯ ��</a>
		</div>
</div>
<!--
<input type="button" value="Ȯ��" onclick="submitForm();">
-->
</td>
</tr>
</table>
*ȸ�� ����ȭ ���� : 031-651-5023 / ���� 8�� ~ ����5�ñ���
<form name="frmMain" Method="POST" >
<input type="hidden" id="idx" name="idx" value="">
<input type="hidden" id="senid" name="senid" value="<?=$senid?>">
</form>
</body>


<script type="text/javascript">
function setIdx(_value){
	document.getElementById('idx').value = _value;
}

function submitForm(){

	var idx = document.getElementById('idx').value;
		
	document.frmMain.action="senSync2018Submit.php";
	document.frmMain.submit();
		

	
}
</script>