<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//step1
//�Ļ� ȸ������ ������ ù �ε��� ����
//2017.1.26 ���� �Ļ�ȸ���� ���� �����ϴ�.
//

?>
<html>
<head>
<title>2017�� 1�� 26�� �ε��� �ڷ�</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

</head>

<body oncontextmenu='return false' ondragstart='return false' onselectstart='return false'>
<font size='4.8'>
*2017�� 1�� 26�� ���� �Ļ�ȸ���� �Ʒ��� �ڷᰡ ���Դϴ�.<br>

<br>
�ѱ� ���� �Ʒ� ��ũ���� �ٿ� �����մϴ�.<br>

<a href="http://www.hancom.com/cs_center/csDownload.do" target="_blank">[�ѱ� ��� �ٿ�ε�]</a><br><br>


PDF ���� �Ʒ� ��ũ���� �ٿ� �����մϴ�.<br>
<br>
<a href="https://acrobat.adobe.com/kr/ko/acrobat/pdf-reader.html"  target="_blank">[Acrobat Reader DC �ٿ�ε�]</a>
<br>
</font>
<?
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

//�Ļ�ȸ�� ����� üũ
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