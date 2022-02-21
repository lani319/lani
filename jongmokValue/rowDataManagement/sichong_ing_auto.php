<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



?>

<!--
2014.04.03 평택촌놈 어윤학 

시가총액 : 이익잉여금
1 : 2
이상인 종목 찾는 것

본 파일에서는 다음 주식 사이트를 연계하여 실시간 데이터를 받아온다. 작업 소요시간은 약 10분 정도 걸린다. 

그리고 시가총액 : 이익잉여금 비율이 1:2 이상 차이나는 종목을 Table로 뿌려준다.

db : jongmokSichong

idx      순번, cell 0
name      종목명, cell 1
code      종목코드 (A~~), cell 2
currentValue           현재가, cell 3
marketValue           시가총액, cell 4
earndValue                이익잉여금 (한달에 1회 갱신), cell 5
earndUpdateDate     이익잉여금 갱신날짜 (이건 혹시 몰라서 만듬), cell 6
type 코스피/코스닥

-->


<?php

include 'Snoopy-1.2.4/Snoopy.class.php';


$start = '0';
//$sql = "select name,right(code,6) as code from jongmokSichong order by idx asc limit 0,10";
$sql = "select name,right(code,6) as code from jongmokSichong order by idx asc";
$tmpRs = mysql_query($sql);
$code = "";

echo "작업 시작 : ". date("Y-m-d H:i:s")."<br>"; 

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
		
		$value = Trim(str_replace(",","",$value)); //,제거
		
		
		//echo $test[1];
		//<dd title='시가총액순위'>
		
		$txt = $test[1];				
		$test = explode("<dd title='시가총액순위'>",$txt); //2
		$txt = "<!--".$test[1]."-->";
		$test = explode("<span",$txt);
		$txt = $test[0];
		
		$marketValue = str_replace("<!--"," ",$txt); 
		$marketValue = Trim(str_replace(",","",$marketValue)); //,제거
		$marketValue = $marketValue*100;
		
		
		//echo $name."  ".$code."    ".$value."     $marketValue <br>";
		
		$sql="update jongmokSichong set currentValue = $value, marketValue=$marketValue where code='A$code'";
        		//echo $sql."<br>";
        		
        		mysql_query($sql);
	}
	
	echo date("Y-m-d H:i:s")."<br>"; 

?>

<script type="text/javascript">
alert('완료');
top.location.href='sichong_ing_frame.php';
</script>
