<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/*201512�� ��ڸ� �̰ܶ�, �ʸ����� ���� ���� �����ϴ� ���. �����̳� ������ ���� �ۼ�]*/

$sql = "SELECT userId,userName,userNickname,mobile FROM Member WHERE userNickname in (
'���ֿ������',
'������̺�μ�',
'����seven',
'�ֽ�',
'������',
'�װ�LP',
'��������',
'����*~',
'���',
'�������',
'���Ϻ�',
'õ�μ�',
'õû����',
'Į���',
'������',
'Ǫ����',
'Ǫ���Ȱ�',
'Ǯ�����',
'�Ѹ���',
'�Ծȼ���',
'����������',
'�ູ�����Ͽ�',
'����Ǻ�',
'��¹',
'�찳���',
'ȫ��',
'Ȳ��'
)
order by userNickname ASC
";
echo $sql;
$tmpRs = mysql_query($sql);
echo "<table width=600px border=1>";
echo "<tr><td>���̵�</td><td>�̸�</td><td>�ʸ�</td><td>����ó</td></tr>";
while ($rs = mysql_fetch_array($tmpRs)) {
	?>
	<tr><td><?=$rs[userId]?></td><td><?=$rs[userName]?></td><td><?=$rs[userNickname]?></td><td><?=$rs[mobile]?></td></tr>
	<?
}
?>