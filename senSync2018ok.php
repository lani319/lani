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

$senId=$txtUserId;

$senNick = $txtUserNickName;


/*

1. 데이터베이스 테이블 생성 (senMemberSync201812)
2. 
idx, userSenId, userSenNickname, userPtIdx,agreeDate, agreeFlag
3. 
sen 아이디랑 sen 필명을 적으라고 함 / A테이블에 정보가 있으면 끝. 없으면 다음
4. 
a테이블에 있는 아이디랑 502쪽 Member 테이블에서 아이디 또는 닉네임이 유사한 정보를 가져와서 보여줌
아이디 / 필명 / 이름 / 생년월일 앞자리 까지만
5. 
그 중에 있으면 체크, 없으면 입력하라고 안내
6. 
마지막에 회원 동기화 이후 절차 (기간에 대한 안내) 하고 동의하고 끝

*/

$sql = "select count(idx) from senMemberSync2018 where userSenId='$senId'";

//echo $sql;

$tmpRs = mysql_query($sql);
$rs = mysql_fetch_row($tmpRs);

if($rs[0] == 0){
	echo "서울경제TV 아이디를 다시 확인해 주세요";
	exit;
}

$sql = "select count(idx),agreeDate from senMemberSync2018 where userSenId='$senId'
and userPtIdx > 0 group by idx";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_row($tmpRs);

if($rs[0] > 0){
	echo $rs[1]."에 동기화를 진행하셨습니다.";
	exit;
}

$sql = "select idx, userID, userNickname, userName, right(mobile,4), left(userNum_sub,6) from Member
where userId = '$senId'";

//echo $sql;

$tmpRs = mysql_query($sql);
$ptMemberCnt = mysql_num_rows($tmpRs);
?>

<form name="frmMain" method="post" onkeydown="return captureReturnKey(event)">
<table border=1 cellpadding="0" cellspacing="0" class="type07">
<tr height="50px">
<th>평택촌놈 아이디</th>
<th>평택촌놈 닉네임</th>
<th>이름</th>
<th>핸드폰 뒷자리</th>
<th>생년월일</th>
<th>본인이 맞으면 체크해 주세요</th>
</tr>


<?
if($ptMemberCnt == 0)
{
	?>

<tr height="50px">
<td colspan = "10" align='Left'>
<br><br>
평택촌놈 웹사이트에서 가입 정보를 찾을 수 없습니다.
<br>
<font color=red>
<a href="http://www.502.co.kr" target="_blank">평택촌놈 웹사이트(www.502.co.kr)</a>에 무료회원 가입후 다시 시도해 주세요. 
<br>
가입을 했다면, 평택촌놈 웹사이트에 가입한 아이디를 입력해 주세요. <br>
</font>
<br>

<div class="textbox">
  <label for="ex_input">평택촌놈 아이디</label>
  <input type="text" name="txtPtUserId" onkeypress='keycheck();'>

</div>
<!--
평택촌놈 아이디 : <input type="text" name="txtPtUserId" size="20">
<input type="button" value="확인" onclick="submitForm();">
-->
<br>
<br>
</td>
</tr>

<?php
}
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
?>
<tr valign="center">
<td colspan="10">
<br>
SENPLUS잔여 유료회원 기간을 (주)평택촌놈 웹사이트로 이전하는 과정에 동의하십니까?<br>
<input type="radio" name="rdAgree" value="true" style="width:30px;height:30px" onclick="setAgree(0);"><font color=red>동의</font>
&nbsp;&nbsp;&nbsp;
<input type="radio" name="rdAgree" value="false" style="width:30px;height:30px" onclick="setAgree(1);" >동의안함
<br>
</td>
</tr>
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
<tr>
<td colspan="10">
*회원 동기화 문의 : 031-651-5023 / 평일 오전 8시 ~ 오후 5시까지
</td>
</tr>

<!--
<tr>
<td colspan="10">
<br>
<font color='red'>*2018년 12월 만기인 회원은 서울경제TV SENPLUS에서 연장결제 하시면 됩니다.</font>
<br>
*아이디 동기화를 진행하면 2018년 12월 28일 이후 만기가 남아있는 회원은 평택촌놈에서 장중 방송 접속이 가능합니다. <br>
*만기일까지는 평택촌놈 웹사이트에서 방송 시청 가능합니다. (현물, 파생 각각 적용)<br>
예)A라는 회원이 2019년 1월 25일 만기라면, 평택촌놈 웹사이트에서 1월 25일까지 방송 접속 가능<br>
<br>

</td>
</tr>
-->
</table>

<input type="hidden" id="agree" name="agree" value="">
<input type="hidden" id="idx" name="idx" value="">
<input type="hidden" id="senid" name="senid" value="<?=$senId?>">

</form>
</body>
<script type="text/javascript">

function setAgree(_value){	
	document.getElementById('agree').value = _value;
}

function setIdx(_value){
	document.getElementById('idx').value = _value;
}

function submitForm(){

	var agreeFlag = document.getElementById('agree').value;
	var idx = document.getElementById('idx').value;
	
	

	if(agreeFlag == 1)
	{
		alert('동의하지 않으면 2019년 1월부터는 방송 시청이 불가능합니다. \n환불은 서울경제TV 고객센터로 문의하세요\n 고객센터)1577-7451');
	
	}else{
		
		document.frmMain.action="senSync2018Submit.php";
		document.frmMain.submit();
		
	}
	
}


function captureReturnKey(e) {
 if(e.keyCode==13 && e.srcElement.type != 'textarea')
 return false;
}

</script>






















