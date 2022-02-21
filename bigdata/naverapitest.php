<?php
phpinfo();

/*
include $_SERVER['DOCUMENT_ROOT']."/lani/jongmokValue/rowDataManagement/Snoopy-1.2.4/Snoopy.class.php";


header("Content-Type: text/html; charset=UTF-8");

$query = "HTML";

$query = iconv("euc-kr","utf-8",$query);

$key = "397ba214b40ef9f054eeb2925982a235"; //ayh319 아이디 키

//$key = "c1b406b32dbbbbeee5f2a36ddc14067f"; //TEST 위한 키

$url = "http://openapi.naver.com/search?key=$key&query=$query&target=news&start=1&display=10";

echo $url;


//여기 아래는 RSS 구조를 출력하는거
$s = new Snoopy;
	
$s->fetch($url);
	
$txt = $s->results;

//$txt=iconv("UTF-8","euc-kr",$txt);


echo "<br>";
echo "<br>";
echo "<br>";

echo $txt;

echo "<br>";
echo "<br>";
*/
?>

<a href="<?=$url?>"> 사이트 이동 </a>


