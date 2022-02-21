<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
2014년 3월 이벤트, 관리자 페이지에서 선택한 사람들의 파라미터를 받아서 쿠폰을 발급해 주는 기능

파라미터는 회원정보^회원정보(김태희 쿠폰인지 평택촌놈 쿠폰인지)  2가지가 붙어서 있다.


샘플 ) 

12345^34904,12346^26439,12344^34904,

*/



$meminfoOri = "";
if(is_Array($idx)) {
	
	$num = count($idx);
	$i = 0;
	while($num > $i)
	{
		$memInfoOri = $memInfoOri.$idx[$i].",";
		$i++;
	}
}
else {
	echo "선택한 사람이 없습니다. 다시 선택 해 주세요. ";
	exit;
}

/*
$memInfoOri = "
39667^34904,
39115^26439,
39245^34904
";
*/
function setEventCoupon($memInfo)
{
	/*	
	1. 회원정보를 explode로 나눈다.
	2. loop 돌면서 insert로 쿠폰 발행한다.
	*/
	$num = 0;
	$str1 = array();	
	$str1 = explode(",",$memInfo);
	
	$str2 = array();
	
	
	//echo "sizeof array ==>".count($str1)."<br>";
	
	while ($num < count($str1)-1) {
		$str2 = explode("^",$str1[$num]);
	//	echo $str2[0]."_______".$str2[1]."<br>";
	if($str2[1] == '34904')
	{
		$kind = "22";
	}
	else {
		$kind = "23";
	}
		
		$sql = "INSERT INTO 502Coupon(kind,issueDate,expiredDate,memIdx,STATUS) VALUES($kind,NOW(),'2014-03-31 23:59:59',$str2[0],0);";
		mysql_query($sql);
		//echo $sql."<br>";
		$sql = "update 03_event set couponSubmitDate = now() where uidx = $str2[0]";
		mysql_query($sql);
		$num++;
		
	}
	
	
	return true;
}


if(setEventCoupon($memInfoOri) == true)
{
	echo "<script>alert('쿠폰 발급 완료');location.href='/admin/m8_admin_03_event.php';</script>";
}
else {
	echo "<script>alert('발급 에러');location.href='/admin/m8_admin_03_event.php';</script>";
}

?>