<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


//502���� ���ᰭ��ȸ �������� �����ְ� 3ȸ �̿� �������� ó��


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
1. ����ڸ� �����´�.
2. Member���� jongmokCnt ������Ʈ�Ѵ�.
3. 502Coupon�� �߱� �� �� ó�� ó���Ѵ�.
4. jongmokValueChargeInfo ���� ���� ���̺� ���� �ִ´�. 
*/

$jongmokCnt = 3;

$cnt = 0;

//1. ����� ��������
$sql = "SELECT memIdx FROM 502Coupon WHERE kind=14";
//$sql = "SELECT idx FROM Member WHERE userId in('ayh318','ayh319','lani319'); ";

$tmpRs = mysql_query($sql);
while ($rs = mysql_fetch_array($tmpRs)) {
	
	$couponKind = "$jongmokCnt ��";
	$memIdx = $rs[0];
	
	//2. Member���� ������Ʈ	
	$sql = "update Member set jongmokCnt = jongmokCnt + $jongmokCnt where idx=$memIdx";
	mysql_query($sql);
		
	//3. 502Coupon�� �߱� �� �� ó�� ó���Ѵ�.			
	$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values(17,now(),'2013-12-31 23:59:59',$memIdx,'$couponKind')";			
	mysql_query($sql);
		
		$price = $jongmokCnt*11000;	
		$buy_no=$memIdx."-".date("ymdHis",$now_time);
		$state = 6; //��������		
		$bank="502����(�����ְ� �̿��)";
		$jongmok=$jongmokCnt; //�Է��� ����
		$settleType=3; //��������
	
	//4. jongmokValueChargeInfo ���� ���� ���̺� ���� �ִ´�. 
	$sql = "insert into jongmokValueChargeInfo(memIdx,price,buy_no,state,signdate,paydate,bank,jongmok,settletype) values(
		$memIdx,
		$price,
		'$buy_no',
		$state,
		now(),
		now(),
		'$bank',
		$jongmok,
		$settleType	
		)";
	mysql_query($sql);
	
	$cnt++;	
}
echo $cnt . " ���� ";
?>