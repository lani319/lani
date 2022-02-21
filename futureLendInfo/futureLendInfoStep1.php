<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//step1
//파생 회원에게 보내는 첫 부동산 정보
//2017.1.26 기준 파생회원만 열람 가능하다.
//

?>
<html>
<head>
<title>2017년 1월 26일 부동산 자료</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

</head>

<body oncontextmenu='return false' ondragstart='return false' onselectstart='return false'>
<font size='4.8'>
*2017년 1월 26일 기준 파생회원만 아래에 자료가 보입니다.<br>

<br>
한글 뷰어는 아래 링크에서 다운 가능합니다.<br>

<a href="http://www.hancom.com/cs_center/csDownload.do" target="_blank">[한글 뷰어 다운로드]</a><br><br>


PDF 뷰어는 아래 링크에서 다운 가능합니다.<br>
<br>
<a href="https://acrobat.adobe.com/kr/ko/acrobat/pdf-reader.html"  target="_blank">[Acrobat Reader DC 다운로드]</a>
<br>
</font>
<?
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

//파생회원 대상자 체크
$c_userId = $_COOKIE['_CKE_USER_ID'];
$sql = "select count(idx) as idx from future_lendinfo where userId= '$c_userId' and step1 = 'T' ";
//echo $sql;
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
if($rs[idx]>0){
//	echo $rs[idx];
	
	$sql="select content from NaraBoard_del_data where idx=5248";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	echo $rs[content];
	
	$sql="update future_lendinfo set cnt=1, regDate=now() where userId= '$c_userId' and step1 = 'T' ";
	//echo $sql;
	mysql_query($sql);
}
?>
</body>
</html>