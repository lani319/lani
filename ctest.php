

<?php

//qbs ���� üũ�� �ϱ����� �׽�Ʈ������


include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


	$memIdx=$_COOKIE['_CKE_USER_UID'];	
	$couponNo = 15;
	$expiredDate = 365*86400;
		
	//���� ���� �˻�	
	$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx and status=1";
	$tmpRs = mysql_query($sql);	
	if(mysql_num_rows($tmpRs) == 0)  //�̹� �����ؼ� ����ϰ� �ִ� ������ ������
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,status,usedDate) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx,1,now())";		
		mysql_query($sql);
		
		//QBS VOD�� ���� ����� �� �Ǿ�����.. ����� �ϰ� ���� ���¸� 1�� �ٲ��ش�.
		for($i=1 ; $i<=12 ; $i++)
		{
			$sql = "insert into Member_expert(mem_idx,regDate,service_orderID,settle_mode)values('".$memIdx."',now(),$i,'QBS')";
			mysql_query($sql);			
		}
								
		echo "<script>showPop('popVOD.png');</script>"; //���⿡ ������ ����Ǿ��ٴ� �˾��� �����ش�.
	}

?>