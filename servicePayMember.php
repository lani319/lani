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
���� Ư�� ȸ������ ����Ⱓ �ִ� ��
//����ȸ���� ȸ���������� ó��
*/


$service_adddate = 5; //���� �ְ� ���� ��¥



$memberId = array('ayh318','kcslife');

$startdate=mktime(); //�������� ����
$enddate = mktime(23, 59, 59, date("m"), date("d") + intval($service_adddate - 1), date("Y"));	//������
$edate = $enddate;

$months=0;
$settletype=3; //��������
$service_type="";
$price="";
$reprice="";
$b_name="";
$bank="";
$c_name="";
$card="";
$state=6; //��������
$signdate="";
$paydate="";
$expert_idx = "34904"; //���� �������� ������ ���̵�
$service_reason = "170603����ȸ"; //�������� ����

if($expert_idx=="34904"){
	$settle_mode="great_stock";
}else{
	$settle_mode="cast";
}

/*
for($i=0 ; $i<2;$i++){ //�迭 ���̸�ŭ

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
where B.gradeLevel > 1";  //����ȸ���� 5�� �Ⱓ �ο� , ����ȸ���� ������ üũ�ؼ� �������� 5�� + 5�� 10�� ��� ��

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

echo $cnt." ��";







?>














