<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/*평택촌놈 통합상품 현물 추가*/


$memType = 2;
$expert_sel = 34904;
$uidx = 57065; //테스트용 고정 // 방태식 사원
$premium_adddate = 30; //1개월 고정 

if(($memType=="1" || $memType=="2") && $premium_adddate > 0){
    if($memType=="1"){
        $exp_idx="12";

    }else if($memType=="2"){
        if(!$expert_sel){
            popupMsg("전문가를 선택하셔야 합니다","1");
            exit();
        }
        $exp_idx=$expert_sel;
    }

    if($exp_idx=="34904"){
        $settle_mode="great_stock";
    }else{
        $settle_mode="cast";
    }

    $sql="select enddate from Member_expert where settle_mode='".$settle_mode."' and exp_idx='".$exp_idx."' and mem_idx='".$uidx."' and enddate > ".mktime()." order by enddate desc";
    $res=mysql_query($sql);
    $rs=mysql_fetch_array($res);
    if($rs[enddate]){
        $startdate=mktime(0,0,0,date("m",$rs[enddate]),date("d",$rs[enddate])+1,date("Y",$rs[enddate]));
        $enddate = intval(86400*$premium_adddate)+$rs[enddate];
    }else{
        $sql="
        SELECT max(enddate) as enddate
        FROM `chargeInfo`
        where uidx='".$uidx."' and expert_idx='".$exp_idx."'
            and enddate >= '".mktime()."' and state in ('1', '3', '6', '10', '12')";
        $res=mysql_query($sql);
        $rs=mysql_fetch_array($res) or die(mysql_error());
        if($rs[enddate]){
            $startdate=mktime(0,0,0,date("m",$rs[enddate]),date("d",$rs[enddate])+1,date("Y",$rs[enddate]));
            $enddate = intval(86400*$premium_adddate)+$rs[enddate];
        }
        else{
            $startdate=mktime();
            $enddate = mktime(23,59,59,date("m"),date("d")+intval($premium_adddate-1),date("Y"));
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
	$options = "Event";
    
    //무료적용 추가
    $freeFlag = "F";
    
    if($freeFlag == "on")
    {
        $freeFlag = "T";
    }
    else
    {
        $freeFlag = "F";        
    }
    
//    echo $freeFlag;
    
//    exit;
    
    if($exp_idx=="34904"){
        $over_settle_idx = over_settle_idx($uidx);
        $SERVICE_ADD_SQL="INSERT INTO chargeInfo (uidx , buy_no , settletype , service_type , price , reprice , startdate , enddate , months , b_name , bank , c_name , card , state , signdate , paydate, expert_idx, options, over_settle_idx,freeFlag) VALUES ";
        $SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$reprice."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$b_name."' , '".$bank."' , '".$c_name."' , '".$card."' , '".$state."' , now() , now() , '".$exp_idx."', '".$options."', '".$over_settle_idx."','".$freeFlag."')";
    }else{
        $SERVICE_ADD_SQL="INSERT INTO chargeInfo (uidx , buy_no , settletype , service_type , price , reprice , startdate , enddate , months , b_name , bank , c_name , card , state , signdate , paydate, expert_idx, options,freeFlag) VALUES ";
        $SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$reprice."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$b_name."' , '".$bank."' , '".$c_name."' , '".$card."' , '".$state."' , now() , now() , '".$exp_idx."', '".$options."','".$freeFlag."')";
    }

	echo $SERVICE_ADD_SQL;

    mysql_query($SERVICE_ADD_SQL) or die(mysql_error());

    expert_settle($exp_idx, $uidx, "", $enddate, $settle_mode);
}




echo "<br>";

/*통합상품 파생 추가*/


$expert_invest_sel = "34904"; // 전문가 34904
$invest_service = "Y"; // 파생 선택 여부 Y
$invest_term = 30; //몇일 

if($invest_service=="Y" && $expert_invest_sel && $invest_term){
    $sql="select enddate from Member_expert where settle_mode='investment' and exp_idx='".$expert_invest_sel."' and mem_idx='".$uidx."' and enddate > ".mktime()." order by enddate desc";
    $res=mysql_query($sql);
    $rs=mysql_fetch_array($res);
    if($rs[enddate]){
        $startdate=mktime(0,0,0,date("m",$rs[enddate]),date("d",$rs[enddate])+1,date("Y",$rs[enddate]));
        $enddate = intval(86400*$invest_term)+$rs[enddate];
    }else{
        $sql="
        SELECT max(enddate_investment) as enddate
        FROM investment_union_chargeInfo
        where uidx='".$uidx."' and expert_investment='".$expert_invest_sel."'
            and enddate_investment >= '".mktime()."' and state in ('1', '3', '6', '10', '12')";
        $res=mysql_query($sql); 
        $rs=mysql_fetch_array($res) or die(mysql_error());
        if($rs[enddate]){
            $startdate=mktime(0,0,0,date("m",$rs[enddate]),date("d",$rs[enddate])+1,date("Y",$rs[enddate]));
            $enddate = intval(86400*$invest_term)+$rs[enddate];
        }
        else{
            $startdate=mktime();
            $enddate = mktime(23,59,59,date("m"),date("d")+intval($invest_term-1),date("Y"));
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
	$options = "Event";
    
    //    investment_chargeInfo    예전 투자클럽 결제테이블 // 20181220 파생회원 등록
    $SERVICE_ADD_SQL="INSERT INTO investment_union_chargeInfo(uidx , buy_no , settletype , service_type , price , startdate_investment , enddate_investment , months , state , signdate , paydate, options, expert_investment) VALUES ";
    $SERVICE_ADD_SQL.="('".$uidx."' , '".$buy_no."' , '".$settletype."' , '".$service_type."' , '".$price."' , '".$startdate."' , '".$enddate."' , '".$months."' , '".$state."' , now() , now(), '".$options."', '".$expert_invest_sel."')";
    
	echo $SERVICE_ADD_SQL;
	
	mysql_query($SERVICE_ADD_SQL) or die(mysql_error());

    expert_settle($expert_invest_sel, $uidx, "", $enddate, "investment");
}

echo "July Event Added";

?>
