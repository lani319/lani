<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$contact = $txtMobile1."-".$txtMobile2."-".$txtMobile3;
$txtName;


$txtMemID = $_COOKIE[_CKE_USER_ID];
if ($txtMemID == null)
{
	echo "<script>alert('로그인 후 이용 해 주세요. 비 회원은 031-651-5023 으로 신청 부탁드립니다.');</script>";
	exit;
}

if ($txtMode == "member") //회원
{
	$sql = "select idx,regDate from 2011dongbuLecture where memID='$txtMemID'";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	
	if($rs["idx"] != "")
	{
		$tmpDate = $rs["regDate"];
		echo "<script>alert('회원님께서는 이미 신청하셨습니다.');</script>";
		exit;
	}
	else 
	{
		$sql = "insert into 2011dongbuLecture(memID,regDate) values('$txtMemID',now());";		
		mysql_query($sql);
		echo "<script>alert('신청이 완료 되었습니다.');</script>";
		exit;
	}
}


?>

<script type="text/javascript">
	function getCookie(name) 
	{
	   var from_idx = document.cookie.indexOf(name+'=');
	   if (from_idx != -1) { 
		  from_idx += name.length + 1
		  to_idx = document.cookie.indexOf(';', from_idx) 
	
		  if (to_idx == -1) {
				to_idx = document.cookie.length
		  }
		  return unescape(document.cookie.substring(from_idx, to_idx))
	   }
	}
	
	function setCookie(name, value, expDays) 
	{
	var exp = new Date(); 
	exp.setTime(exp.getTime() + (expDays*24*60*60*1000));
	var expire_date = new Date(exp);
	var odC = getCookie(name)+'';
	
	document.cookie = name + "=" + odC +","+ escape(value) + ";path=/; expires=" + expire_date.toGMTString(); 
	
	}

		
	function close_popup(days) //1일 동안 안 띄우기 (자동으로 안 띄우기)
	{
		setCookie("2011Dongbu", "dongbu" , days);
	}
		
close_popup(30);
top.parent.self.close();
</script>