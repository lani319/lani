<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include '../lani/jongmokValue/rowDataManagement/Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//$start = '1648';
//$sql = "select name,code from jongmokValue order by idx asc limit $start, 200";	//�������� �ڵ�

//�����׿���(��ձ�) �̷��� �Ǿ��ִ°� ���͸� 2���ڵ�

$sql = "select name,code from jongmokValue 	

where type='KOSDAQ'

order by idx asc

";

$tmpRs = mysql_query($sql);
$code = "";

echo mysql_num_rows($tmpRs);
?>

<table cellpadding="0" cellspacing="0" border="1">
<tr><td rowspan="2" width="150px">�����</td><td rowspan="2" width="150px">�����ڵ�</td><td colspan="5" width="300px">����</td></tr>
<tr><td>2009</td><td>2010</td><td>2011</td><td>2012</td><td>2013</td></tr>

<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	$code = $rs['code'];
	$name = $rs['name'];

	$s = new Snoopy;
	
	//$s->fetch("http://wisefn.stock.daum.net/company/cF1001.aspx?cmp_cd=$code&finGubun=MAIN");
	
	$s->fetch("http://media.kisline.com/investinfo/mainInvestinfo.nice?paper_stock=$code&nav=3&header=N&comp=daishin");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	
	
	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
		
	$test = explode("��缺��(%)",$txt); //�������� �ڵ�
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("//��系��",$txt); //�������� �ڵ�
	
	$txt = $test[0]."-->";
	
	
	$txt = str_replace("</th>","",$txt);
	$txt = str_replace("</tbody>","",$txt);
	$txt = str_replace("colspan='2'","",$txt);
	$txt = str_replace("</table>","",$txt);
	$txt = str_replace("<!--","",$txt);
	$txt = str_replace("-->","",$txt);
	
	$txt = "<tr><td>$name</td><td>A$code</td>".$txt."";
	

?>
<?=$txt?>
<?php
}
?>
</table>
<script >
alert("���� �Ϸ�");
</script>