<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//txtReservationTime
if($nonMemberFlag) //��ȸ���̸�
{
	$sql = "insert into TM_info_NonMember (userIdx,adminIdx,recentDate,reserveDate,recentEndDate,processResult,memo,counselKind,counselKindDetail,counselTime,counselTimebyNumber,nonMemberName,nonMemberMobile,nonMemberSSN,blackList,reservationTime) values('$userIdx','$adminIdx','$recentDate','$reserveDate',now(),'$processResult','$memo','$counselKind','$counselKindDetail','$counselTime','$counselTimebyNumber','$nonMemberName','$nonMemberMobile','$nonMemberSSN','$txtBlackList','$txtReservationTime')";
	echo $sql;
}
else //ȸ���̸�
{
	$sql = "insert into TM_info (userIdx,adminIdx,recentDate,reserveDate,recentEndDate,processResult,memo,counselKind,counselKindDetail,counselTime,counselTimebyNumber,blackList,reservationTime) values('$userIdx','$adminIdx','$recentDate','$reserveDate',now(),'$processResult','$memo','$counselKind','$counselKindDetail','$counselTime','$counselTimebyNumber','$txtBlackList','$txtReservationTime')";
		
	if($txtReserveHour)
	{
		if($reserveDate)
		{
			$reserveDate = $reserveDate; //���� ��¥
		}
		else 
		{
			$reserveDate = date("Y-m-d");	 //���� ��¥
		}			
			$reserveCallHour = $txtReserveHour; //���� �ð�
			$reserveCallMinute = $txtReserveMin; //���� ��
			
			$sql2 = "insert into TM_reserveHour (reserveDate,reserveHour,reserveMinute,userIdx,callFlag,callTime) values('$reserveDate','$reserveCallHour','$reserveCallMinute','$userIdx','N','$txtReservationTime')";
			
			mysql_query($sql2);
	}
	
	//���⿡ ������ ��ȭ ���� ���� �ִ� �ڵ� �ۼ� 20100928 ������
	
	if($txtUserGrade != 4)
	{
		$sql3 = "UPDATE TM_customer SET userGrade = $txtUserGrade,lastInfo='$counselKind' WHERE userIdx  = $userIdx";
		mysql_query($sql3);
	}
}

	mysql_query($sql);
?>

<script>
alert('��� �Ǿ����ϴ�.');
parent.top.location.href = "_counsel.html";
</script>