<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$futureSms = "Y";
$txtFutureSms = "33"; //기간 (1월 31일까지)

$cnt = 0;

/*파생단독SMS 기간 추가 부분 시작*/


$memArr = array(
12182,
56403,
55069,
54321,
51830,
54358,
52903,
9143,
55446
);

foreach($memArr as $item)
{
	$uidx = $item;
	$cnt = $cnt+1;

	$meminfo = get_meminfo($uidx,"userName");

	if($futureSms=="Y" && $txtFutureSms){
		$sql="select enddate from Member_expert where settle_mode='stock' and exp_idx='34904' and mem_idx='".$uidx."' and enddate > ".mktime()." order by enddate desc";
		$res=mysql_query($sql);
		$rs=mysql_fetch_array($res);
		if($rs[enddate]){
			$startdate=mktime(0,0,0,date("m",$rs[enddate]),date("d",$rs[enddate])+1,date("Y",$rs[enddate]));
			$enddate = intval(86400*$txtFutureSms)+$rs[enddate];
		}else{
			$sql="
			SELECT max(enddate_tiker) as enddate
			FROM stock_sms_chargeInfo 
			where uidx='".$uidx."' and expert_tiker='34904' 
				and enddate_tiker >= '".mktime()."' and state in ('1', '3', '6', '10','12')";
			$res=mysql_query($sql);
			$rs=mysql_fetch_array($res) or die(mysql_error());
			if($rs[enddate_tiker]){
				$startdate=mktime(0,0,0,date("m",$rs[enddate_tiker]),date("d",$rs[enddate_tiker])+1,date("Y",$rs[enddate_tiker]));
				$enddate = intval(86400*$txtFutureSms)+$rs[enddate_tiker];
			}
			else{
				$startdate=mktime();
				$enddate = mktime(23,59,59,date("m"),date("d")+intval($txtFutureSms-1),date("Y"));
			}
		}

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
		$options="파생 무료 이벤트";

		$SERVICE_ADD_SQL="INSERT INTO stock_sms_chargeInfo(uidx , buy_no , settletype , service_type , price , startdate_tiker , enddate_tiker , months , state , signdate , paydate, options,expert_tiker) VALUES ";
		$SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$state."' , now() , now(), '".$options."' ,34904)";
		
		echo $SERVICE_ADD_SQL."<br>";
		
		//mysql_query($SERVICE_ADD_SQL) or die(mysql_error());

		//expert_settle("34904", $uidx, "", $enddate, "stock");
		
		echo $cnt."  ".$meminfo["userName"]."  ".$txtFutureSms."일 적용완료<br>";
		
	}
}//foreach
/*파생단독SMS 기간 추가 부분 끝*/

?>