<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$sql = "insert into 502bookTest(mName,mobile,area,period,investType,uidx,regDate,userId) values('$txtName','$txtMobile1-$txtMobile2-$txtMobile3','$selArea','$selPeriod','$selinvestType','$_COOKIE[_CKE_USER_UID]',now(),'$_COOKIE[_CKE_USER_ID]')";

mysql_query($sql);

$sql = "select count(idx) as cnt from 502bookTest where uidx=$_COOKIE[_CKE_USER_UID] and regDate >= '2011-11-27 00:00:00'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);

if ($rs[cnt] >= 1)
{
	echo "<script>alert('��û�� �Ϸ�Ǿ����ϴ�. ��÷�ڴ� 12�� 7�� ���� 6�ñ��� ���� �����մϴ�.');parent.top.location.href='http://www.502.co.kr/notice/'</script>;";
}
else 
{
	echo "<script>alert('��û�������� ������ �߻��Ͽ����ϴ�.�ٽ� ��û ��Ź�帳�ϴ�.');history.back(-1);'</script>;";
}


?>