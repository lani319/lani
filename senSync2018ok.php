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

$senId=$txtUserId;

$senNick = $txtUserNickName;


/*

1. �����ͺ��̽� ���̺� ���� (senMemberSync201812)
2. 
idx, userSenId, userSenNickname, userPtIdx,agreeDate, agreeFlag
3. 
sen ���̵�� sen �ʸ��� ������� �� / A���̺� ������ ������ ��. ������ ����
4. 
a���̺� �ִ� ���̵�� 502�� Member ���̺��� ���̵� �Ǵ� �г����� ������ ������ �����ͼ� ������
���̵� / �ʸ� / �̸� / ������� ���ڸ� ������
5. 
�� �߿� ������ üũ, ������ �Է��϶�� �ȳ�
6. 
�������� ȸ�� ����ȭ ���� ���� (�Ⱓ�� ���� �ȳ�) �ϰ� �����ϰ� ��

*/

$sql = "select count(idx) from senMemberSync2018 where userSenId='$senId'";

//echo $sql;

$tmpRs = mysql_query($sql);
$rs = mysql_fetch_row($tmpRs);

if($rs[0] == 0){
	echo "�������TV ���̵� �ٽ� Ȯ���� �ּ���";
	exit;
}

$sql = "select count(idx),agreeDate from senMemberSync2018 where userSenId='$senId'
and userPtIdx > 0 group by idx";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_row($tmpRs);

if($rs[0] > 0){
	echo $rs[1]."�� ����ȭ�� �����ϼ̽��ϴ�.";
	exit;
}

$sql = "select idx, userID, userNickname, userName, right(mobile,4), left(userNum_sub,6) from Member
where userId = '$senId'";

//echo $sql;

$tmpRs = mysql_query($sql);
$ptMemberCnt = mysql_num_rows($tmpRs);
?>

<form name="frmMain" method="post" onkeydown="return captureReturnKey(event)">
<table border=1 cellpadding="0" cellspacing="0" class="type07">
<tr height="50px">
<th>�����̳� ���̵�</th>
<th>�����̳� �г���</th>
<th>�̸�</th>
<th>�ڵ��� ���ڸ�</th>
<th>�������</th>
<th>������ ������ üũ�� �ּ���</th>
</tr>


<?
if($ptMemberCnt == 0)
{
	?>

<tr height="50px">
<td colspan = "10" align='Left'>
<br><br>
�����̳� ������Ʈ���� ���� ������ ã�� �� �����ϴ�.
<br>
<font color=red>
<a href="http://www.502.co.kr" target="_blank">�����̳� ������Ʈ(www.502.co.kr)</a>�� ����ȸ�� ������ �ٽ� �õ��� �ּ���. 
<br>
������ �ߴٸ�, �����̳� ������Ʈ�� ������ ���̵� �Է��� �ּ���. <br>
</font>
<br>

<div class="textbox">
  <label for="ex_input">�����̳� ���̵�</label>
  <input type="text" name="txtPtUserId" onkeypress='keycheck();'>

</div>
<!--
�����̳� ���̵� : <input type="text" name="txtPtUserId" size="20">
<input type="button" value="Ȯ��" onclick="submitForm();">
-->
<br>
<br>
</td>
</tr>

<?php
}
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
?>
<tr valign="center">
<td colspan="10">
<br>
SENPLUS�ܿ� ����ȸ�� �Ⱓ�� (��)�����̳� ������Ʈ�� �����ϴ� ������ �����Ͻʴϱ�?<br>
<input type="radio" name="rdAgree" value="true" style="width:30px;height:30px" onclick="setAgree(0);"><font color=red>����</font>
&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdAgree" value="false" style="width:30px;height:30px" onclick="setAgree(1);" >���Ǿ���
<br>
</td>
</tr>
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
<tr>
<td colspan="10">
*ȸ�� ����ȭ ���� : 031-651-5023 / ���� ���� 8�� ~ ���� 5�ñ���
</td>
</tr>

<!--
<tr>
<td colspan="10">
<br>
<font color='red'>*2018�� 12�� ������ ȸ���� �������TV SENPLUS���� ������� �Ͻø� �˴ϴ�.</font>
<br>
*���̵� ����ȭ�� �����ϸ� 2018�� 12�� 28�� ���� ���Ⱑ �����ִ� ȸ���� �����̳𿡼� ���� ��� ������ �����մϴ�. <br>
*�����ϱ����� �����̳� ������Ʈ���� ��� ��û �����մϴ�. (����, �Ļ� ���� ����)<br>
��)A��� ȸ���� 2019�� 1�� 25�� ������, �����̳� ������Ʈ���� 1�� 25�ϱ��� ��� ���� ����<br>
<br>

</td>
</tr>
-->
</table>

<input type="hidden" id="agree" name="agree" value="">
<input type="hidden" id="idx" name="idx" value="">
<input type="hidden" id="senid" name="senid" value="<?=$senId?>">

</form>
</body>
<script type="text/javascript">

function setAgree(_value){	
	document.getElementById('agree').value = _value;
}

function setIdx(_value){
	document.getElementById('idx').value = _value;
}

function submitForm(){

	var agreeFlag = document.getElementById('agree').value;
	var idx = document.getElementById('idx').value;
	
	

	if(agreeFlag == 1)
	{
		alert('�������� ������ 2019�� 1�����ʹ� ��� ��û�� �Ұ����մϴ�. \nȯ���� �������TV �����ͷ� �����ϼ���\n ������)1577-7451');
	
	}else{
		
		document.frmMain.action="senSync2018Submit.php";
		document.frmMain.submit();
		
	}
	
}


function captureReturnKey(e) {
 if(e.keyCode==13 && e.srcElement.type != 'textarea')
 return false;
}

</script>






















