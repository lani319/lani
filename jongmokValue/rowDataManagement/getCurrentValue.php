<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$start = '0';
$sql = "select name,right(code,6) as code from jongmokSichong";
$tmpRs = mysql_query($sql);
$code = "";

//echo mysql_num_rows($tmpRs);

echo date("Y-m-d H:i:s")."<br>"; 

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
		
		
		//echo $test[1];
		//<dd title='시가총액순위'>
		
		$txt = $test[1];				
		$test = explode("<dd title='시가총액순위'>",$txt); //2
		$txt = "<!--".$test[1]."-->";
		$test = explode("<span",$txt);
		$txt = $test[0];
		
		$marketValue = str_replace("<!--"," ",$txt);
		$marketValue = Trim(str_replace(",","",$marketValue));
		$marketValue = number_format($marketValue*100);
		
		
		echo $name."  ".$code."    ".$value."     $marketValue <br>";
	}
	
	echo date("Y-m-d H:i:s")."<br>"; 
?>


