<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



echo $mode;

if($regDate == "")
{
	$regDate = date("Y-m-d H:i:s");
	$targetDate = date("Y-m-d");
}
else 
{
	
	$targetDate = $regDate;	
}


$userIdx = "";
$subject = $targetDate." 업무지시";

//관리자 번호
//$sql = "select idx from Business_log_level where writer = '".$_COOKIE["_CKE_USER_NICK_NAME"]."'";
//$tmpRs = mysql_query($sql);
//$rs = mysql_fetch_array($tmpRs);
//$userIdx = $rs[idx];
$userIdx = 2;

if($mode == "reg")
{
	//지시업무 추가	
	$sql = "insert into Business_list(writer,charge,contents,flag,regDate,targetDate,status) values('$userIdx','$selCharge','$FCKeditor1','$flag',now(),'$targetDate','R')";	
	
	if($flag = "N")
	{
	//업무보고
	$sql = "insert into Business_log(writer,subject,contents,viewLevel,regDate,flag) values('$userIdx','$txtSubject','$FCKeditor1','A',now(),'3')";
	}
	
	

	mysql_query($sql);
	//mysql_query($sql1);	
	
	echo "<script>	alert('등록되었습니다.');parent.location.href = './businesslist.php?mode=list&flag=$flag'; </script>";
}
else 
{
	$sql = "update Business_list set contents = '$FCKeditor1',charge='$selCharge',flag='$flag' where charge=$selCharge and status='R'";
		
//	$sql1 = "update Business_log set contents = '$FCKeditor2' where writer = $userIdx and left(regDate,10) = '$targetDate' and flag=0";	
	
	
	mysql_query($sql);
//	mysql_query($sql1);	

	echo "<script>	alert('수정되었습니다.');parent.location.href = './businesslist.php?mode=list&flag=$flag'; </script>";	
}
?>




