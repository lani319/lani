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



$sql = "SELECT A.userNickname as writer,B.* from Member A inner join commentST B on A.idx = B.uidx
	
	where B.bidx = $idx

	ORDER BY B.idx ASC
	
		
	";

$tmpRs = mysql_query($sql);

$xmlList.="<?xml version='1.0' encoding='euc-kr' ?>";
$num = 0;
while($rs = mysql_fetch_array($tmpRs))
{
	$sTitle = "$rs[content]";
		
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