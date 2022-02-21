<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>  <!--뷰포트 설정 -->		
		<link href="senSync.css" rel="stylesheet" type="text/css"/>		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:700' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
//txtPtUserId 수동으로 넘어온 502아이디


if($idx){
	$sql = "update senMemberSync2018 set userPtIdx=$idx,agreeDate=now() where
	userSenId='$senid'";

	mysql_query($sql);

	echo "동기화 작업이 완료되었습니다.";
	exit;
	
}else if($idx == "" && $txtPtUserId) { //502에서 조회해서 있으면 다시 보여주고 갱신, 없으면 회원가입 안내

$sql = "select idx, userID, userNickname, userName, right(mobile,4), left(userNum_sub,6) from Member
where userId ='$txtPtUserId'";

//echo $sql;

$tmpRs = mysql_query($sql);
$ptMemberCnt = mysql_num_rows($tmpRs);

if($ptMemberCnt == 0)
{

echo "평택촌놈 웹사이트 가입 정보가 없습니다. 다시 확인해 주세요";
exit;

}else{
?>

	<table class="type07">
	<tr height="50px">
	<td>평택촌놈 아이디</td>
	<td>평택촌놈 닉네임</td>
	<td>이름</td>
	<td>핸드폰 뒷자리</td>
	<td>생년월일</td>
	<td>본인이 맞으면 체크해 주세요</td>
	</tr>

<?php
		while ($rs = mysql_fetch_array($tmpRs)) {
		?>
		<tr valign="center">
		<td><?=$rs[1]?></td>
		<td><?=$rs[2]?></td>
		<td><?=$rs[3]?></td>
		<td><?=$rs[4]?></td>
		<td>
		<?php
		echo substr($rs[5],0,2)."년";
		echo substr($rs[5],2,2)."월";
		echo substr($rs[5],4,2)."일";
		?>
		</td>
		<td>
		<input type="radio" name="rdIdx" value="<?=$rs[1]?>" style="width:30px;height:30px" 
		onclick="setIdx('<?=$rs[0]?>');">

		<font color='red'>본인이 맞으면 체크해주세요</font>
		</td>
		</tr>
		<?php
		}
	}

}
?>
<tr valign="center">
<td colspan="10" height="50px" align="center">
<div class="row">
        <div class="col three">             
            <a href="#" onclick="submitForm();" class="btn btn-concrete">확 인</a>
		</div>
</div>
<!--
<input type="button" value="확인" onclick="submitForm();">
-->
</td>
</tr>
</table>
*회원 동기화 문의 : 031-651-5023 / 평일 8시 ~ 오후5시까지
<form name="frmMain" Method="POST" >
<input type="hidden" id="idx" name="idx" value="">
<input type="hidden" id="senid" name="senid" value="<?=$senid?>">
</form>
</body>


<script type="text/javascript">
function setIdx(_value){
	document.getElementById('idx').value = _value;
}

function submitForm(){

	var idx = document.getElementById('idx').value;
		
	document.frmMain.action="senSync2018Submit.php";
	document.frmMain.submit();
		

	
}
</script>