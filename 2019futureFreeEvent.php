<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);





/*
2019�� �Ļ� ������ �߿��� �̺�Ʈ ����� ���� ǥ��
*/

//�α��� ���� Ȯ��
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> history.back(); </script>";
	exit();
}

//$userId = $_COOKIE['_CKE_USER_ID'];

$meminfo=get_meminfo($_COOKIE['_CKE_USER_UID'],"gradeLevel,userId,userName,userNickname");

if($meminfo[gradeLevel] == "1" && $meminfo[userId] != 'ayh319')
{
	echo "<font color=red>ȸ������ 2020�� 1�� 2�Ͽ� �̿����� ���񽺿� �߰����� ����˴ϴ�.</font>";
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
			echo "ȸ������ ".$rs[eventDay]."�� �Ļ�SMS ���� �̺�Ʈ ��� �Դϴ�.
			
			<br><br>
			���� �Ļ�SMS ���� ������ �ޱ� ���Ͻø� 
			<br><br>
			�Ʒ� ��û�ϱ� ��ư�� �����ּ���. 
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



