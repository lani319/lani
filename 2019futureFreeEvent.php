<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);





/*
2019년 파생 결제자 중에서 이벤트 대상자 여부 표시
*/

//로그인 여부 확인
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("로그인후 이용이 가능합니다.");
	echo "<script> history.back(); </script>";
	exit();
}

//$userId = $_COOKIE['_CKE_USER_ID'];

$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"gradeLevel,userId,userName,userNickname");

if($meminfo[gradeLevel] == "1" && $meminfo[userId] != 'ayh319')
{
	echo "<font color=red>회원님은 2020년 1월 2일에 이용중인 서비스에 추가일이 적용됩니다.</font>";
	exit;
	
}else
{

	$sql = "
	select * from 2019FutureFreeMember where userId = '".$meminfo[userId]."'
	";

	$tmpRs = mysql_query($sql);
	while($rs = mysql_fetch_array($tmpRs)){
		
		if($rs[eventDay] > 0)
		{
			echo "회원님은 ".$rs[eventDay]."일 파생SMS 서비스 이벤트 대상 입니다.
			
			<br><br>
			무료 파생SMS 서비스 혜택을 받길 원하시면 
			<br><br>
			아래 신청하기 버튼을 눌러주세요. 
			<br><br>
			";
			?>
			<a href="#" onClick="setReg();">
			<img src="http://www.502.co.kr/upload_file/WImgPost/2019/12/1575603668522.jpg">
			</a>
			<?php
		}		
	}
}
?>

<script>

function setReg(){
	var f = document.myForm;
	f.action = "setFutureFreeMemberRegOk.php";
	f.submit();
	
}

</script>

<form name="myForm" metho="POST">

</form>



