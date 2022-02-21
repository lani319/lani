<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "select name,code from jongmokValue order by idx asc limit $start, $end";
$tmpRs = mysql_query($sql);
$code = "";

echo mysql_num_rows($tmpRs);
?>
<table cellpadding="0" cellspacing="0" border="1">
<tr><td>종목명</td><td>종목코드</td><td>종목자본총계</td></tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)) {
	$code = $rs['code'];
	$name = $rs['name'];

	$s = new Snoopy;
	
	$s->fetch("http://media.kisline.com/fininfo/mainFininfo.nice?paper_stock=$code&nav=4&header=N");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	
	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	$test = explode("<th scope='row'>자본총계</th>",$txt); //2
	
	$txt = "<!--".$test[3]."-->";
	
	$test = explode("</tr>",$txt);
	
	$txt = "<!--".$test[0]."-->";
	
	
	$test = explode("</td>",$txt);
	
	$txt = $test[4];
	$txt = str_replace("<td class='rgt'>","",$txt);
	$txt = str_replace(",","",$txt);
	$value = number_format($txt);
	$msg.= "<br>".$name."  ".$code."  ".$value;

?>
<tr><td><?=$name?></td><td><?=$code?></td><td><?=$value?></td></tr>
<?php
}
?>
</table>