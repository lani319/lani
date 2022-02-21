<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/*
무료 특정 회원들을 유료기간 주는 것
//유료회원은 회원관리에서 처리
*/


$service_adddate = 5; //서비스 주고 싶은 날짜



$memberId = array('ayh318','kcslife');

$startdate=mktime(); //시작일은 지금
$enddate = mktime(23, 59, 59, date("m"), date("d") + intval($service_adddate - 1), date("Y"));	//만료일
$edate = $enddate;

$months=0;
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
$expert_idx = "34904"; //서비스 적용해줄 전문가 아이디
$service_reason = "170603강연회"; //임의적용 이유

if($expert_idx=="34904"){
	$settle_mode="great_stock";
}else{
	$settle_mode="cast";
}

/*
for($i=0 ; $i<2;$i++){ //배열 길이만큼

	$sql = "select idx from Member where userId='$memberId[$i]'";

	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_row($tmpRs);
	$uidx = $rs[0];
	$mem_idx = $uidx;

	$buy_no=$uidx."-".date("ymdHis");
	$rOrdNo = $buy_no;


	$SERVICE_ADD_SQL="INSERT INTO chargeInfo (uidx , buy_no , settletype , service_type , price , reprice , startdate , enddate , months , b_name , bank , c_name , card , state , signdate , paydate, expert_idx, options) VALUES ";
	
	$SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$reprice."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$b_name."' , '".$bank."' , '".$c_name."' , '".$card."' , '".$state."' , now() , now() , '".$expert_idx."', '".$service_reason."')";
		
		
	echo $SERVICE_ADD_SQL."<br>";
	
	mysql_query($SERVICE_ADD_SQL);
	
	
	expert_settle($expert_idx, $mem_idx, $rOrdNo, $edate, $settle_mode);

}
*/




$cnt = 1;

$sql = "select B.idx, B.userID from Member B 
inner join lecture_20170603 A on B.idx = A.mem_idx
where B.gradeLevel > 1";  //무료회원은 5일 기간 부여 , 유료회원은 일일이 체크해서 임의적용 5일 + 5일 10일 줘야 함

$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_row($tmpRs))
{
	$uidx = $rs[0];
	$mem_idx = $uidx;

	$buy_no=$uidx."-".date("ymdHis");
	$rOrdNo = $buy_no;


	$SERVICE_ADD_SQL="INSERT INTO chargeInfo (uidx , buy_no , settletype , service_type , price , reprice , startdate , enddate , months , b_name , bank , c_name , card , state , signdate , paydate, expert_idx, options) VALUES ";
		
	$SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$reprice."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$b_name."' , '".$bank."' , '".$c_name."' , '".$card."' , '".$state."' , now() , now() , '".$expert_idx."', '".$service_reason."')";
			
			
	echo $SERVICE_ADD_SQL."<br>";
		
	mysql_query($SERVICE_ADD_SQL);
		
		
	expert_settle($expert_idx, $mem_idx, $rOrdNo, $edate, $settle_mode);

	$cnt++;
	
}

echo $cnt." 끝";







?>














