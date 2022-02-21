

<?php

//qbs 쿠폰 체크를 하기위한 테스트페이지


include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


	$memIdx=$_COOKIE['_CKE_USER_UID'];	
	$couponNo = 15;
	$expiredDate = 365*86400;
		
	//발행 쿠폰 검사	
	$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx and status=1";
	$tmpRs = mysql_query($sql);	
	if(mysql_num_rows($tmpRs) == 0)  //이미 발행해서 사용하고 있는 쿠폰이 없으면
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,status,usedDate) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx,1,now())";		
		mysql_query($sql);
		
		//QBS VOD에 쿠폰 등록이 안 되었으면.. 등록을 하고 쿠폰 상태를 1로 바꿔준다.
		for($i=1 ; $i<=12 ; $i++)
		{
			$sql = "insert into Member_expert(mem_idx,regDate,service_orderID,settle_mode)values('".$memIdx."',now(),$i,'QBS')";
			mysql_query($sql);			
		}
								
		echo "<script>showPop('popVOD.png');</script>"; //여기에 쿠폰이 발행되었다는 팝업을 보여준다.
	}

?>