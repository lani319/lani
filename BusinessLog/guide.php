<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header3.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<br>
<table width="1100" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="155px" valign="top">
<?php include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/menu_left.php"; ?>
</td>
<td>
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
		<pre>
		*���� ��������
		  - �� �����鿡�� �˸��� �����Դϴ�. �� ����� ��� ����� �����ϸ�, ����� ����Ը� �����մϴ�.
		</pre>
		
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*ȸ�� ���� ����
		  - ȸ���������� �����ϴ� ���� �Դϴ�. �� ����� ��� ����� �����ϸ�, ����� ����Ը� �����մϴ�.
		</pre>
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*���κ� ����
		  - �� �������� �����ؾ� �� ���� �Դϴ�. �� ����� ��� ����� �����ϸ�, ���� ���ô� ����Ը� �����մϴ�.
		</pre>
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*���κ� ��������
		  - ������� �� ���κ��� �������ø� �ϱ� ���� �޴��Դϴ�.
		</pre>
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*ȸ�� ��������
		  - ������� ȸ���������� �����ϴ� ������ �ۼ��ϱ����� �޴��Դϴ�.
		</pre>
		</td>
	</tr>
	</table>
</td>
</tr>
</table>