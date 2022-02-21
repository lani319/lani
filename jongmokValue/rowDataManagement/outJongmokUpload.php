<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//초기화
$sql = "update jongmokValue set outFlag='F'";
mysql_query($sql);


	$s = new Snoopy;
	
//코스피 관리종목
	$s->fetch("http://stock.daum.net/quote/attention.daum?type=M&stype=P");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//자본총계 필터링
	$test = explode("투자유의</h3>",$txt); //오리지날 코드
	
	/*키워드
	  1. 투자유의	 
	  이 사이에 있는 것 중에서 필터링
	  2. 현재가
	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("현재가</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //여기에서 찾을 것
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}	
	
	
		//echo "<br>////////////////////////////////////////	<br>";
		
//코스 관리종목
	$s->fetch("http://stock.daum.net/quote/attention.daum?stype=Q&type=M");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//자본총계 필터링
	$test = explode("투자유의</h3>",$txt); //오리지날 코드
	
	/*키워드
	  1. 투자유의	 
	  이 사이에 있는 것 중에서 필터링
	  2. 현재가
	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("현재가</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //여기에서 찾을 것
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}			
	
	
//코스피 거래정지 종목	
	$s->fetch("http://stock.daum.net/quote/attention.daum?type=S&stype=P");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//투자유의 라는 키워드로 필터링
	$test = explode("투자유의</h3>",$txt); //오리지날 코드
	
	/*
	키워드
	  1. 투자유의	 
	      이 사이에 있는 것 중에서 필터링
	  2. 현재가	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("현재가</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //여기에서 찾을 것
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}
	
	
//코스닥 거래정지 종목	
	$s->fetch("http://stock.daum.net/quote/attention.daum?stype=Q&type=S");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//투자유의 라는 키워드로 필터링
	$test = explode("투자유의</h3>",$txt); //오리지날 코드
	
	/*
	키워드
	  1. 투자유의	 
	      이 사이에 있는 것 중에서 필터링
	  2. 현재가	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("현재가</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //여기에서 찾을 것
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}	
	
	
	
	//가격이 0원인 종목들 무료로 설정하는거 추가 / 2016.5.30 어윤학
	$sql = "UPDATE jongmokValue SET freeFlag = 'T' WHERE VALUE=0";
	mysql_query($sql);	
	
?>


</table>
<script >
alert("추출 완료");
</script>