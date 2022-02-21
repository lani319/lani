<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//$start = '1648';
//$sql = "select name,code from jongmokValue order by idx asc limit $start, 200";	//오리지날 코드

//이익잉여금(결손금) 이렇게 되어있는것 필터링 2차코드

$sql = "select code from jongmokValue order by idx asc";



$tmpRs = mysql_query($sql);
$code = "";

echo mysql_num_rows($tmpRs);
?>
<table border="1" cellpadding="0" cellspacing="0">
<tr>
<td width="150">CODE</td><td width="250">NAME</td><td width="150">CurVal</td><td width="150">Sichong(백만원)</td>
</tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	$code = $rs['code'];

	$s = new Snoopy;
	
	$s->fetch("http://stock.daum.net/item/main.daum?code=$code");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//종목명
	$test = explode("document.title = '",$txt); //오리지날 코드	
	
	$txt = "<!--".$test[1]."-->";	
	
	$test = explode(".trim()",$txt);
	
	$jongmokNametmp = explode(":",$test[0]);
	$jongmokName = str_replace("<!--","",$jongmokNametmp[0]);	
	$curVal = str_replace("-->","",$jongmokNametmp[1]);
	$curVal = str_replace("'","",$curVal);
	$curVal = Trim(str_replace(",","",$curVal));
	
	
//	echo $jongmokName;
//	echo $curVal;
	
	
	
	//시가총액
	$txt = "<!--".$test[3]."-->";
	
	$test = explode("<dd title='시가총액순위'>",$txt);
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("<span",$txt);
	
	$txt = "<!--".$test[0]."-->";	
	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = str_replace(",","",$txt);
	
	$sichong = Trim($txt)."00";
	
	//echo "<br>".$code."   ".$jongmokName."   ".$curVal."   ".$sichong."<br>";
?>
<tr>
<td>A<?=$code?></td><td><?=$jongmokName?></td><td><?=number_format($curVal)?></td><td><?=number_format($sichong)?></td>
</tr>
<?php
}
?>


</table>
<script >
alert("추출 완료");
</script>