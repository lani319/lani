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
	echo "<script>alert('신청이 완료되었습니다. 당첨자는 12월 7일 저녁 6시까지 개별 연락합니다.');parent.top.location.href='http://www.502.co.kr/notice/'</script>;";
}
else 
{
	echo "<script>alert('신청과정에서 오류가 발생하였습니다.다시 신청 부탁드립니다.');history.back(-1);'</script>;";
}


?>