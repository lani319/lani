<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$memIdx = $_COOKIE["_CKE_USER_UID"]; //ȸ�� �ε���

/*
���ſ� �����ߴ� ������ �ִ��� �����´�. 

�����ߴ� ������ ������, �����ְ��� ���� �Ǿ����� �˷��ش�. 

//sameFlag�� 3�����̴�. 
//1. ó�� ��ȸ 0 jongmokValueHistory insert
//2. �� ��ȸ (���� ���� ����) 1
//3. �� ��ȸ (���� ���� ����) 2 jongmokValueHistory insert
*/



$sql = "

SELECT A.name,A.updateDate as recentUpdateDate,B.code,date(B.searchDate) as searchDate,A.value,A.adjustValue,B.updateDate as lastUpdateDate,B.value as historyValue

FROM jongmokValue A INNER JOIN jongmokValueHistory B ON A.code = B.code

WHERE B.memIdx=$memIdx and B.code='$jongmokCode' order by searchDate desc limit 0,1; 
";

$tmpRs = mysql_query($sql);

if(mysql_num_rows($tmpRs))	//���� ��ȸ�ߴ� ������ �ִ°�? 0 1 2
{
	$rs = mysql_fetch_array($tmpRs);
	
	$value = round($rs["value"]+($rs["value"]*$rs["adjustValue"]),-1); //���� ���� �����ְ� �����ͺ��̽����� ������ ����	
	
	
	$gap = 	($value-$rs['historyValue'])/($rs['historyValue'])*100;
			
	if( $gap  > 12.5  || $gap < -12.5  ) //���� ���̰� +- 12.5% �̻� ���̳��� ���� �� ������ �����Ѵ�.
	{
		$gapFlag = "2"; //����
	}else {		
		$gapFlag = "1"; //���� ����
	}
	
}
else { //ó�� ��ȸ�̸�
	$gapFlag = "0";
}
//echo $gapFlag;

//echo $jongmokCode ."  | ".$name."  | ". $freeFlag."  | ". $adminFlag."  | ". $gapFlag;

//exit;

?>
<script type="text/javascript">
parent.chkMain('<?=$jongmokCode?>','<?=$name?>','<?=$freeFlag?>','<?=$adminFlag?>','<?=$gapFlag?>');
</script>