<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



?>

<!--
2014.04.03 �����̳� ������ 

�ð��Ѿ� : �����׿���
1 : 2
�̻��� ���� ã�� ��

�� ���Ͽ����� ���� �ֽ� ����Ʈ�� �����Ͽ� �ǽð� �����͸� �޾ƿ´�. �۾� �ҿ�ð��� �� 10�� ���� �ɸ���. 

�׸��� �ð��Ѿ� : �����׿��� ������ 1:2 �̻� ���̳��� ������ Table�� �ѷ��ش�.

db : jongmokSichong

idx      ����, cell 0
name      �����, cell 1
code      �����ڵ� (A~~), cell 2
currentValue           ���簡, cell 3
marketValue           �ð��Ѿ�, cell 4
earndValue                �����׿��� (�Ѵ޿� 1ȸ ����), cell 5
earndUpdateDate     �����׿��� ���ų�¥ (�̰� Ȥ�� ���� ����), cell 6
type �ڽ���/�ڽ���

-->


<?php

include 'Snoopy-1.2.4/Snoopy.class.php';


$start = '0';
//$sql = "select name,right(code,6) as code from jongmokSichong order by idx asc limit 0,10";
$sql = "select name,right(code,6) as code from jongmokSichong order by idx asc";
$tmpRs = mysql_query($sql);
$code = "";

echo "�۾� ���� : ". date("Y-m-d H:i:s")."<br>"; 

	$s = new Snoopy;

	while ($rs = mysql_fetch_array($tmpRs)) {
	
		$code = $rs['code'];
		$name = $rs['name'];
	
		$s->fetch("http://stock.daum.net/item/main.daum?code=$code");
		
		$txt = $s->results;
		
		$txt=iconv("UTF-8","euc-kr",$txt);
	
		$txt = str_replace("<!--"," ",$txt);
		$txt = str_replace("-->"," ",$txt);
		$txt = "<!--".$txt."-->";
		$txt =  str_replace('"',"'",$txt);
		
		$test = explode("<em class='curPrice",$txt); //2
		$txt = "<!--".$test[1]."-->";
				
		
		$test = explode("</em>",$txt);
		
		$txt = $test[0];
		
		
		$value = str_replace("<!-- down'>"," ",$txt);	
		$value = str_replace("<!-- up'>"," ",$value);	
		$value = str_replace("<!-- keep'>"," ",$value);	
		
		$value = Trim(str_replace(",","",$value)); //,����
		
		
		//echo $test[1];
		//<dd title='�ð��Ѿ׼���'>
		
		$txt = $test[1];				
		$test = explode("<dd title='�ð��Ѿ׼���'>",$txt); //2
		$txt = "<!--".$test[1]."-->";
		$test = explode("<span",$txt);
		$txt = $test[0];
		
		$marketValue = str_replace("<!--"," ",$txt); 
		$marketValue = Trim(str_replace(",","",$marketValue)); //,����
		$marketValue = $marketValue*100;
		
		
		//echo $name."  ".$code."    ".$value."     $marketValue <br>";
		
		$sql="update jongmokSichong set currentValue = $value, marketValue=$marketValue where code='A$code'";
        		//echo $sql."<br>";
        		
        		mysql_query($sql);
	}
	
	echo date("Y-m-d H:i:s")."<br>"; 

?>

<script type="text/javascript">
alert('�Ϸ�');
top.location.href='sichong_ing_frame.php';
</script>
