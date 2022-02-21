<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$memUid = $_COOKIE["_CKE_USER_UID"];
$memId = $_COOKIE["_CKE_USER_ID"];
$memName = $_COOKIE["_CKE_USER_NAME"];

$mobile = $txtMemPhone01."-".$txtMemPhone02."-".$txtMemPhone03;


//회원 번호 / 신청자 이름 / 어른 수 / 어린이 수 / 연락처 / 최종 참석 여부 / 등록 시각

$sql = "insert into 502Mountain(midx,mName,mNumAdult,mNumChild,mPhone,mConfirm,regDate,mLunchFlag) values('$memUid','$txtMemName','$mNumAdult','$mNumChild','$mobile','N',now(),'$rdLunch')";
echo $sql;

//exit;
mysql_query($sql);
?>


<script>
parent.location.href = 'regResult.html';
</script>