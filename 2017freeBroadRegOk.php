<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



popupMsg("체험 방송 신청은 4월 3일(월)부터 가능합니다."); 
	echo "<script> history.back();</script>";
	exit();



//로그인 여부 확인
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> history.back(); </script>";
	exit();
}

$dayofweek = date('w');

if($dayofweek==0 || $dayofweek==5 || $dayofweek==6 ){
	popupMsg("체험 방송 신청은 월요일 ~ 목요일만 가능합니다.");
	echo "<script> history.back();</script>";
	exit();
}

//무료회원인지 검출 (등급 설정)
$SQL1 = "SELECT count(*) as num  FROM `Member` where  level='10' and member_state='Y' AND gradeLevel = '2'  AND userID='".$_COOKIE['_CKE_USER_ID']."'";
//echo $SQL1;
$Result = mysql_query($SQL1) or die(mysql_error());
$Rs = mysql_fetch_array($Result);
if($Rs['num'] <= 0 ){
	popupMsg("2등급 회원만 신청 가능합니다.");
	echo "<script> history.back();</script>";
	exit();
}


//기존 신청 회원인지 검출
$SQL="select count(*) from chargeInfo where uidx='".$_COOKIE['_CKE_USER_UID']."'  and leading_broadcast='Y' " ;
$result=mysql_query($SQL) or die(mysql_error());
$count=mysql_fetch_array($result);
if($count[0]>0){
	popupMsg("이번 달은 이미 체험하셨습니다. 다음달에 다시 신청해 주세요.");
	echo "<script> history.back();</script>";
	exit();
}



//신청 팝업(free_experience_new.php)을 거치지 않고 접근시 접근거부
if($_POST['ok']=="N" || $_POST['ok']==""){
	popupMsg("잘못된 접근 방법입니다.");
	echo "<script> window.close(); </script>";
	exit();
}



$month = date("m");
$day = date("d");




//회원정보 취득
$SQL="select * from Member where userID='".$_COOKIE['_CKE_USER_ID']."'";
$result=mysql_query($SQL) or die(mysql_error());
$Member=mysql_fetch_array($result);

	$uidx = $_COOKIE['_CKE_USER_UID'];
	$months=0;
	$buy_no=$uidx."-".date("ymdHis");
	$settletype=3; //임의적용
	$service_type="";
	$price="";
	$reprice="";
	$b_name="";
	$bank="";
	$c_name="";
	$card="";
	$state=6; //임의적용
	$signdate="";
	$paydate="";
	$exp_idx = 34904;
	$leading_broadcast = "Y";
	$startdate=mktime(0,0,0,$month,$day,2017);
	$enddate = mktime(23,59,59,$month,$day+1,2017);
	$options = "방송 2일 체험";
	
	if($exp_idx=="34904"){
		$settle_mode="great_stock";
	}else{
		$settle_mode="cast";
	}
	
/*	
echo $startdate;
echo "<br>";
echo $enddate;	
echo "<br>";
echo "<br>";
echo date("Y-m-d H:i:s",$startdate);
echo "<br>";
echo date("Y-m-d H:i:s",$enddate);
*/


$SERVICE_ADD_SQL="INSERT INTO chargeInfo (uidx , buy_no , settletype , service_type , price , reprice , startdate , enddate , months , b_name , bank , c_name , card , state , signdate , paydate, expert_idx, options,freeFlag,leading_broadcast) VALUES ";
		$SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$reprice."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$b_name."' , '".$bank."' , '".$c_name."' , '".$card."' , '".$state."' , now() , now() , '".$exp_idx."', '".$options."','".$freeFlag."','".$leading_broadcast."')";

echo "<br>";
echo "<br>";
//echo $SERVICE_ADD_SQL;
mysql_query($SERVICE_ADD_SQL) or die(mysql_error());

expert_settle($exp_idx, $uidx, "", $enddate, $settle_mode);

$sql = "update Member set receivePremiumHP = 1 where idx = $uidx";
mysql_query($sql) or die(mysql_error());

popupMsg("신청이 완료됐습니다. 다시 로그인 해 주세요."); 
echo "<script> window.close(); </script>";
exit();
?>


