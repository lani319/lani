<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/*
2015�� 8��, �����ְ� �̺�Ʈ
��� ȸ������ +3�� ���� ����

1. �ֱ� 1�� �����ڸ� ��޿� ������� ���� �����´�.
2. ���� ���鼭 3���� ������ �����Ѵ�. 
3. ��.

//�����ְ� 3�� ���� idx�� 17
*/


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$expiredDate = $selExpiredDate*86400;

$expiredDate = mktime(23,59,59,$month,$day,$year);

//���⼭ ȸ�������� �ҷ��ͼ� ���� ����

		$couponKind = "$jongmokCnt ��";
		
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values(17,now(),FROM_UNIXTIME($expiredDate),$txtMemIdx,'$couponKind')";
			
		mysql_query($sql);
		
		$price = $jongmokCnt*11000;
	
		$memIdx = $txtMemIdx;	
		$buy_no=$memIdx."-".date("ymdHis",$now_time);
		$state = 6; //��������		
		$bank="502����(�����ְ� �̿��)";
		$jongmok=$jongmokCnt; //�Է��� ����
		$settleType=3; //��������
	
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
	
		$sql = "update Member set jongmokCnt = jongmokCnt + $jongmokCnt where idx=$memIdx";
		mysql_query($sql);



?>
<script type="text/javascript">
alert('������ �߱޵Ǿ����ϴ�');
parent.location.reload();
</script>