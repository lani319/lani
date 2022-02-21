<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ip = getRealIpAddr();

$query = "select count(idx) as cnt from Member where userId='$txtMemId' and Left(userNum_sub,6) = '$txtMemSSN'";
$tmpRs = mysql_query($query);
$rs = mysql_fetch_array($tmpRs);

if($rs["cnt"]!=0)
{
	$query2 = "select count(idx) as cnt from 2011Survey where userId='$txtMemId'";
	$tmpRs2 = mysql_query($query2);
	$rs2 = mysql_fetch_array($tmpRs2);
	
	if($rs2["cnt"]!=0)	
	{		
		echo "<script>alert('$txtMemName 님 께서는 이미 설문에 응답하셨습니다. 설문은 1번만 응모가 가능합니다.');parent.location.href='/index.html';</script>";
		exit;
	}
	else 
	{	
		$arrQ1 = explode("$",$txtDetail1);
		
		$q1 = $arrQ1[0];
		$q2 = $arrQ1[1];
		$q3 = $arrQ1[2];
		$q4 = $arrQ1[3];
		$q5 = $arrQ1[4];
		
		$arrQ2 = explode("$",$txtDetail2);
		$q6 = $arrQ2[0];
		$q7 = $arrQ2[1];
		$q8 = $arrQ2[2];
		$q9 = $arrQ2[3];
		$q10 = $arrQ2[4];
		
		$arrQ3 = explode("$",$txtDetail3);
		$q11 = $arrQ3[0];
		$q12 = $arrQ3[1];
		$q13 = $arrQ3[2];
		$q14 = $arrQ3[3];
		$q15 = $arrQ3[4];
		
		$query = "insert into 2011Survey(userId,userName,userSSN,userMobile,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15,regDate,userIP) values('$txtMemId','$txtMemName','$txtMemSSN','$txtMemMobile1-$txtMemMobile2-$txtMemMobile3','$q1','$q2','$q3','$q4','$q5','$q6','$q7','$q8','$q9','$q10','$q11','$q12','$q13','$q14','$q15',now(),'$ip')";
		echo $query;
		mysql_query($query);
		echo "<script>alert('설문 응답이 완료 되었습니다. 참여 해 주셔서 감사합니다.');</script>";
		echo "<script>parent.top.location.href = '2011_surveyThankyou.html';</script>";	
		exit;
	}
}
else 
{
	echo "<script>alert('회원정보가 정확하지 않습니다. 아이디 및 개인정보를 다시 확인 해 주세요 ');</script>";
	exit;
}



?>