<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
������ �����ְ�
width = 790 �ִ������
*/
/*
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�����̳� �����ְ��� �α����� �̿��� �����մϴ�. ȸ������ �� �̿� �ٶ��ϴ�.");
	echo "<script> top.location.href='http://www.502.co.kr/member' </script>";
	exit();
}
*/

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
?>
<html>
<title>�����̳� �����ְ�</title>
<head>
<link rel="stylesheet" type="text/css" href="css/table02.css">
<script type="text/javascript">
function goSearch(name)
{
	parent.parent.topFrame.document.getElementById("searchKeyword").value = name;
	parent.parent.topFrame.goSearch();
}

function window::onload() {
   parent.parent.topFrame.document.getElementById("searchKeyword").value = "";
   parent.parent.topFrame.document.getElementById("searchKeyword").focus();	
      
}

</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr valign="top">
<td width="250px" style="border-color:#FFFFFF">

<div id="intro">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table01">
<caption>KOSPI</caption>

<thead>	
	<tr><th><font color="FFFFFF">�����</font></th><th><font color="FFFFFF">�����ְ�</font></th></tr>	
	</thead>
	<tbody>
	<?php
	$sql = "select * from jongmokValue where type='KOSPI' and freeFlag='T' order by idx ASC ";
	$tmpRs = mysql_query($sql);
	while ($rs=mysql_fetch_array($tmpRs)) {
		?>		
		<tr class="odd" align="center"><td height="25px"><b><?=$rs[name]?></b></td><td bgcolor="white"  onmouseover="this.style.color='#FF8c00';" onmouseout="this.style.color='#777777'" style="cursor:hand;"> <b><?=number_format($rs[value])?></b></td></tr>
		<?php
	}
	?>
	</tbody>
		
</table>
</div>





<td style="border-color:#FFFFFF">
<div id="intro">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table01">
<caption>KOSDAQ</caption>
<!--
<font color='red' size="4"><b>Ctrl+F (��Ʈ��+F)������ ����� �˻��ϼ���</b></font>
-->
<thead>
<tr><th><font color="FFFFFF">�����</font></th><th><font color="FFFFFF">�����ְ�</font></th></th>

<!--
<th><font color="FFFFFF">�����</font></th><th><font color="FFFFFF">�����ְ�</font></th>
-->

</tr>
</thead>
</div>
<?php
	$sql = "select * from jongmokValue where type='KOSDAQ' and freeFlag='T'  order by idx ASC ";
	$tmpRs = mysql_query($sql);
	$i=1;
	while ($rs=mysql_fetch_array($tmpRs)) {
		if($i%2 == 1){		//�������� 1�̸� �� �ٲ� ����
		echo "<tr class='odd'>";
		}
		?>		
		<td height="25px"><b><?=$rs[name]?></b></td><td bgcolor="white"  onmouseover="this.style.color='#FF8c00';" onmouseout="this.style.color='#777777'" style="cursor:hand;"><b><?=number_format($rs[value])?></</a></td>
		<?php
		/*
		if($i%2 == 0){		//�������� 0�̸� �� �ٲ� ��. (���� �� �ٲ�)
		echo "</tr>";
		}
		$i++;
*/		
	}
	
	?>
	<td></td><td bgcolor="#FFFFFF"></td>
	</tr>
<tr>
<td colspan="10" height="80px" style="color:#000000">
<img src="img/freenotice.gif">
</td>
</tr>		
</table>

</td>


</tr>
</table>
</body>
</html>

