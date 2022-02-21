<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//공지사항 글쓴이 번호
$sql = "select idx from Business_log_level where writer = '".$_COOKIE["_CKE_USER_NAME"]."'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
$userIdx = $rs[idx];

$memIdx = $_COOKIE["_CKE_USER_UID"];

if($_COOKIE["_CKE_USER_NAME"]=='서동훈')
{
	$userIdx = "2";
}

if($mode == "reg")
{
	$sql = "insert into Business_log(writer,subject,contents,viewLevel,regDate,flag,memIdx) values('$userIdx','$txtSubject','$FCKeditor1','A',now(),'3','$memIdx')";
	mysql_query($sql);
	
	echo "<script>	alert('등록되었습니다.');parent.location.href = './notice.php'; </script>";
}
else 
{
	
	$sql1 = "update Business_log set subject = '$txtSubject', contents = '$FCKeditor1',regDate=now() where idx=$idx";
		
	mysql_query($sql1);	

	echo "<script>	alert('수정되었습니다.');parent.location.href = './notice.php?mode=view&idx=$idx'; </script>";
}
?>




