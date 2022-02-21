<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//여기에서 강연회 참석자 체크
//참석자가 로그인해서 페이지 들어오면 아이프레임으로 보여준다.
//참석자 아니면 안 보여준다.
//<iframe width="640" height="1500" src="http://502.co.kr/lani/2017SeoulLectureNote.php" frameborder="0"></iframe>

?>
<html>
<head>
<title>2017년 1월 21일 강연회 자료</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>

</head>

<body oncontextmenu='return false' ondragstart='return false' onselectstart='return false'>
<?
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> window.close(); </script>";
	exit();
}

//강연회 참석여부 체크
$c_userId = $_COOKIE['_CKE_USER_ID'];
$sql = "select count(idx) as idx from lectureNote_20170121 where userId= '$c_userId'";
//echo $sql;
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
if($rs[idx]>0){
//	echo $rs[idx];
	
	$sql="select content from NaraBoard_del_data where idx=5246";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	echo $rs[content];
	
	$sql="update lectureNote_20170121 set cnt=cnt+1, regDate=now() where userId='$c_userId'";;
	//echo $sql;
	mysql_query($sql);
}
?>
</body>
</html>