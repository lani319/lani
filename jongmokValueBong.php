<?php
/*
���� �̷��� �����ְ� ��������
������ : 2013 10 10
������ : ������
������ : �����ʹ� 2013 10 7�� �������� ������. 
*/
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
�˻� ����� �����ִ� ���
*/

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$paramJongmok = $jongmokName;
$type = "�ڽ���";

?>
<html>
<title>�����ְ� ��������</title>
<head>
<script type="text/javascript">
function getValue()
{
	param = document.getElementById("jongmokName").value;
	url = "http://www.502.co.kr/lani/jongmokValueBong.php?jongmokName="+param;
	location.href = url;
}

function window::onload() {
   document.getElementById('jongmokName').focus();
}
</script>
</head>
<body> 
�����ڵ� �Ǵ� �����̸� : <input type="text" size="20" name="jongmokName" id="jongmokName"><input type = "submit" onclick="getValue();" value="�˻�" size="15" onkeydown="javascript:if(event.keyCode==13){getValue();}">

<?php
if ($paramJongmok!=null)
{
	$sql = "select * from jongmokValue where code like '%$paramJongmok' or name like '$paramJongmok%' order by type DESC";
	$tmpRs = mysql_query($sql);
	
?>
<table border="0" cellpadding="0" cellspacing="0" width="600px">
<tr align="center" bgcolor="skyblue">
<td width="150px">�����</td>
<td width="100px">�����ڵ�</td>
<td>�����ְ�</td>
<td width="80px">����</td>
</tr>
	
<?php
	while($rs = mysql_fetch_array($tmpRs))
	{
	
?>
<tr align="center">
<td><?=$rs[2]?></td>
<td><?=$rs[1]?></td>
<td><?=number_format($rs[3])?></td>
<td><?=$rs['type']?></td></tr>
<tr><td height="1" colspan="10" bgcolor="skyblue"></td></tr>
			
<?php
	}
}
?>
<tr><td colspan="10">*2013�� 10�� 10�� ���� �����ְ� �Դϴ�.<br>�ű������� �����п��� �˷��ּ���. </td></tr>
</table>
</body>
</html>