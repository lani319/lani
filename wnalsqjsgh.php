<?
ob_start();
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* 로그인정보 추출 */
if(!isInterCheckIt(0)){
	popupMsg("관리자만이 이용 가능 합니다. 관리자 로그인을 해주세요.");
	redirect("/admin/logout.php");
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$sql = "select userNum from Member where userId='$memId'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
		$usernum=numDec($rs[userNum]);		
		$usernum1 = substr($usernum,0,6);
		$usernum2 = substr($usernum,6,7);
		
		echo $memId . "=". $usernum1 . "-" . $usernum2;

?>