<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
최근 10년치 자본총계를 가져와서 갱신한다. 

URL
http://www.itooza.com/vclub/y10_page.php?cmp_cd=009540&mode=db&ss=10&sv=1&lsmode=1&accmode=1&lkmode=1

1. node-142 로 검색해서 3번째
2. 매월 말일 29 30 31 중에 하루 걸리면 그날 종가와 시가총액 추출
3. 2번 말일 날짜 추출해서 그 날짜대비 6개월 수급 추출
4. 2번 말일 날짜 추출해서 그 날짜기준 업종/주가 지수 산출
5. 과거 시점의 적정주가 산출
6. 해당 적정주가와 종목 가격 비교

*/



//여기에 로그인 처리 2015 09 07

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

<!-- TEST용, 임시.
<table cellpadding="0" cellspacing="0" border="1">
<tr><td>종목명</td><td>종목코드</td><td>자본총계(억)</td></tr>
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
	
	//3번째꺼가 자본총계
	//0 1 2 3 4
	
	
	$txt = "<!--".$test[2]."-->"; //개별기준
	
	echo $txt;
	exit;
		
	$test = explode("</tr>",$txt);
	
	$txt = $test[0]."-->";
	
	
	
	//여기까지 테스트
	$test = explode("</td>",$txt);	
	
	$txt = $test[2]; //최신 자본총계	
	
	
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
alert("추출 완료");
</script>