<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$_HOST_NAME='211.172.241.7';
$_USER_NAME='co502';
$_DB='co502';
$_PASSWORD='@%^*&#';

$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$sql = "SELECT B.idx,LEFT(B.title,50) AS title,A.userNickname AS writer,B.signdate FROM stBoard B INNER JOIN Member A
	
	WHERE A.idx = B.expert_Idx
	
	and B.delFlag=0

	ORDER BY B.idx DESC 
	
	LIMIT 0,20
	";

$tmpRs = mysql_query($sql);

$xmlList.="<?xml version='1.0' encoding='euc-kr' ?>";
$num = 0;
while($rs = mysql_fetch_array($tmpRs))
{
	$sTitle = trim(strip_tags($rs[title]));
	//$sContent = strip_tags($rs[content]);
	$sTitle = strip_tags($rs[title]);
	$sContent = str_replace("<br>","&#10;","$rs[content]");
	
	$num++;
	$title = "title_".$num;
		
	$xmlList.="
	<item>
		<idx>$rs[idx]</idx>			
		<title><![CDATA[ $sTitle ]]> </title>		
		<pubDate>$rs[signdate]</pubDate>
		<author><![CDATA[ $rs[writer] ]]></author>
		<description><![CDATA[ $rs[idx] ]]></description>
	</item>";
}
echo $xmlList;
?>