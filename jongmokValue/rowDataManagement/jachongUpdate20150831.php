<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//$start = '1648';
$sql = "select name,code from jongmokValue order by idx ASC";
//$sql = "select name,code from jongmokValue where code = 005930 order by idx ASC";
$tmpRs = mysql_query($sql);
$code = "";

echo mysql_num_rows($tmpRs);
?>

<table cellpadding="0" cellspacing="0" border="1">
<tr><td>�����</td><td>�����ڵ�</td><td>�ں��Ѱ�(��)</td></tr>

<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	$code = $rs['code'];
	$name = $rs['name'];

	$s = new Snoopy;
	
	$s->fetch("http://media.kisline.com/highlight/mainHighlight.nice?paper_stock=$code&nav=1&header=N&comp=daishin");
	
	
	$txt = $s->results;
		
	$txt=iconv("UTF-8","euc-kr",$txt);
	
		
	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = str_replace("//"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt); 
		
	
	$test = explode("�ں��Ѱ�(���)</th>",$txt); //2 
	
	//$txt = "<!--".$test[4]."-->"; //�������
	$txt = "<!--".$test[1]."-->"; //�������� 
	
	
		
	$test = explode("</tr>",$txt);
	
	$txt = $test[0]."-->";
	
	
	
	//������� �׽�Ʈ
	$test = explode("</td>",$txt);	
	
	$txt = $test[2]; //�ֽ� �ں��Ѱ�	
	
	
	$txt = str_replace("<td>","",$txt);
	$txt = str_replace(",","",$txt);
	$value = number_format($txt);
	$msg.= "<br>".$name."  ".$code."  ".$value;

?>
<tr><td><?=$name?></td><td>A<?=$code?></td><td><?=$value?></td></tr>
<?php
}
?>
</table>
<script >
alert("���� �Ϸ�");
</script>