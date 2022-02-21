<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$code = "005490";

	$s = new Snoopy;

	
		$s->fetch("http://finance.daum.net/item/quote_avg_yyyymmdd_sub2.daum?code=$code");
		
		$txt = $s->results;
		
		$txt=iconv("UTF-8","euc-kr",$txt);
	
		$txt = str_replace("<!--"," ",$txt);
		$txt = str_replace("-->"," ",$txt);
		$txt = "<!--".$txt."-->";
		$txt =  str_replace('"',"'",$txt);
		
		$test = explode("<table id='bbsList",$txt); //2
		$txt = "<!--".$test[1]."-->";
		
		
		$test = explode("datetime2",$txt);
		
		$txt = $test[1];
		
		$test = explode("<td class='num'>",$txt); //2
		
		
		
		$txt01 = $test[1]; //종가		
		$txt02 = $test[5]; //20일선
		$txt03 = $test[6]; //60일선
		$txt04 = $test[7]; //120일선
		
		$txt01 = str_replace("</td>"," ",$txt01);	
		$txt02 = str_replace("</td>"," ",$txt02);	
		$txt03 = str_replace("</td>"," ",$txt03);	
		$txt04 = str_replace("</td>"," ",$txt04);	
		
		$txt01 = str_replace("</span>"," ",$txt01);	
		$txt02 = str_replace("</span>"," ",$txt02);	
		$txt03 = str_replace("</span>"," ",$txt03);	
		$txt04 = str_replace("</span>"," ",$txt04);	

		$txt01 = str_replace("<span class='cUp'>"," ",$txt01);	
		$txt02 = str_replace("<span class='cUp'>"," ",$txt02);	
		$txt03 = str_replace("<span class='cUp'>"," ",$txt03);	
		$txt04 = str_replace("<span class='cUp'>"," ",$txt04);	

		$txt01 = str_replace("<span class='cDn'>"," ",$txt01);	
		$txt02 = str_replace("<span class='cDn'>"," ",$txt02);	
		$txt03 = str_replace("<span class='cDn'>"," ",$txt03);	
		$txt04 = str_replace("<span class='cDn'>"," ",$txt04);							
		
		$txt01 = str_replace(",","",$txt01);	
		$txt02 = str_replace(",","",$txt02);	
		$txt03 = str_replace(",","",$txt03);	
		$txt04 = str_replace(",","",$txt04);							
		
			
		
		$test = explode("</tr>",$txt04); //2
		$txt04 = $test[0];
		
		
		echo "Cvalue ".$txt01." / ";
		echo "20 ".$txt02." / ";
		echo "60 ".$txt03." / ";
		echo "120 ".$txt04." / ";
		
		
		//echo number_format($txt01-$txt02);
		
		
		if(number_format($txt01) > number_format($txt02)){
			echo "Short UP"."<br>";
		}else{
			echo "Short DN"."<br>";
		}
		
		if(number_format($txt03) > number_format($txt04)){
			echo "Middle UP"."<br>";
		}else{
			echo "Middle DN"."<br>";
		}
		
		exit;		
	
	
	//echo date("Y-m-d H:i:s")."<br>"; 
?>


