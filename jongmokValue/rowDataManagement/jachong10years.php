<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
�ֱ� 10��ġ �ں��Ѱ踦 �����ͼ� �����Ѵ�. 

URL
http://www.itooza.com/vclub/y10_page.php?cmp_cd=009540&mode=db&ss=10&sv=1&lsmode=1&accmode=1&lkmode=1

1. node-142 �� �˻��ؼ� 3��°
2. �ſ� ���� 29 30 31 �߿� �Ϸ� �ɸ��� �׳� ������ �ð��Ѿ� ����
3. 2�� ���� ��¥ �����ؼ� �� ��¥��� 6���� ���� ����
4. 2�� ���� ��¥ �����ؼ� �� ��¥���� ����/�ְ� ���� ����
5. ���� ������ �����ְ� ����
6. �ش� �����ְ��� ���� ���� ��

*/



//���⿡ �α��� ó�� 2015 09 07

$s=new Snoopy;

$s->httpmethod = "POST";

$memInfo = array('txtUserId'=>'ayh319','txtPassword'=>'fksl4278');

$url="https://login.itooza.com/login_process.php?data=";

$auth['txtUserId'] = 'ayh319';
$auth['txtPassword'] = 'fksl4278';

$s->submit($url,$auth);
$s->setcookies();



$s->fetch("http://www.itooza.com/vclub/y10_page.php?cmp_cd=006910&mode=db&ss=10&sv=1&lsmode=1&accmode=1&lkmode=1");

$txt = $s->results;

print_r($txt);

exit;



//$start = '1648';
$sql = "select name,code from jongmokValue order by idx ASC";
$sql = "select name,code from jongmokValue where code = 005930 order by idx ASC";
$tmpRs = mysql_query($sql);
$code = "";

echo mysql_num_rows($tmpRs);
?>

<!-- TEST��, �ӽ�.
<table cellpadding="0" cellspacing="0" border="1">
<tr><td>�����</td><td>�����ڵ�</td><td>�ں��Ѱ�(��)</td></tr>
-->

<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	$code = $rs['code'];
	$name = $rs['name'];

	//$s = new Snoopy;
	
	//$s->fetch("http://www.itooza.com/vclub/y10_page.php?cmp_cd=$code&mode=db&ss=10&sv=1&lsmode=1&accmode=1&lkmode=1");
	$s->fetch("http://www.itooza.com/vclub/y10_page.php?cmp_cd=006910&mode=db&ss=10&sv=1&lsmode=1&accmode=1&lkmode=1");
	
		
	$txt = $s->results;
	
	echo $txt;
	exit;
		
	$txt=iconv("UTF-8","euc-kr",$txt);
	
			
	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = str_replace("//"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt); 
		

	
	
	
	$test = explode("node-142",$txt); //2 
	
	//3��°���� �ں��Ѱ�
	//0 1 2 3 4
	
	
	$txt = "<!--".$test[2]."-->"; //��������
	
	echo $txt;
	exit;
		
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