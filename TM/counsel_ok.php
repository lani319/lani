<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//txtReservationTime
if($nonMemberFlag) //비회원이면
{
	$sql = "insert into TM_info_NonMember (userIdx,adminIdx,recentDate,reserveDate,recentEndDate,processResult,memo,counselKind,counselKindDetail,counselTime,counselTimebyNumber,nonMemberName,nonMemberMobile,nonMemberSSN,blackList,reservationTime) values('$userIdx','$adminIdx','$recentDate','$reserveDate',now(),'$processResult','$memo','$counselKind','$counselKindDetail','$counselTime','$counselTimebyNumber','$nonMemberName','$nonMemberMobile','$nonMemberSSN','$txtBlackList','$txtReservationTime')";
	echo $sql;
}
else //회원이면
{
	$sql = "insert into TM_info (userIdx,adminIdx,recentDate,reserveDate,recentEndDate,processResult,memo,counselKind,counselKindDetail,counselTime,counselTimebyNumber,blackList,reservationTime) values('$userIdx','$adminIdx','$recentDate','$reserveDate',now(),'$processResult','$memo','$counselKind','$counselKindDetail','$counselTime','$counselTimebyNumber','$txtBlackList','$txtReservationTime')";
		
	if($txtReserveHour)
	{
		if($reserveDate)
		{
			$reserveDate = $reserveDate; //예약 날짜
		}
		else 
		{
			$reserveDate = date("Y-m-d");	 //예약 날짜
		}			
			$reserveCallHour = $txtReserveHour; //예약 시간
			$reserveCallMinute = $txtReserveMin; //예약 분
			
			$sql2 = "insert into TM_reserveHour (reserveDate,reserveHour,reserveMinute,userIdx,callFlag,callTime) values('$reserveDate','$reserveCallHour','$reserveCallMinute','$userIdx','N','$txtReservationTime')";
			
			mysql_query($sql2);
	}
	
	//여기에 마지막 전화 차수 집어 넣는 코드 작성 20100928 어윤학
	
	if($txtUserGrade != 4)
	{
		$sql3 = "UPDATE TM_customer SET userGrade = $txtUserGrade,lastInfo='$counselKind' WHERE userIdx  = $userIdx";
		mysql_query($sql3);
	}
}

	mysql_query($sql);
?>

<script>
alert('등록 되었습니다.');
parent.top.location.href = "_counsel.html";
</script>