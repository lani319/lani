<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
502 유료회원 연락처 추출 기능
매일 돌려서 파일로 저장
서버 망가졌을 때 뿌리오에서 문자 보내는 용도
*/

$signdate = $date;

//통합 현물 방송
$sql1 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND (B.settle_mode = 'great_stock')
AND B.exp_idx= 34904 order by B.enddate ASC";

//현물 문자전용
$sql5 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'tiker'
AND B.exp_idx= 34904 order by B.enddate ASC";

//통합 파생
$sql2 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'investment'
AND B.exp_idx= 34904 order by B.enddate ASC";


//파생 문자전용
$sql3 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'stock'
AND B.exp_idx= 34904 order by B.enddate ASC";


//봉추선생
$sql4 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'cast'
AND B.exp_idx= 42872 order by B.enddate ASC";

$tmpRs1 = mysql_query($sql1);
$tmpRs2 = mysql_query($sql2);
$tmpRs3 = mysql_query($sql3);
$tmpRs4 = mysql_query($sql4);
$tmpRs5 = mysql_query($sql5);


$resultTxt = "";
?>
<table cellpadding=0 cellspacing=0>
<tr>
<td colspan=5>평택촌놈 통합현물 + 현물전용SMS (새 홈페이지 통합방송)</td>
</tr>
<?php

$resultTxt += "평택촌놈 통합현물 + 현물전용SMS\n";

while ($rs = mysql_fetch_array($tmpRs1)) {
?>
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
</tr>
<?php
$resultTxt += $rs[1]."\n";
}
$resultTxt += "\n\n\n\n\n";
?>
<tr>
<td height=100 colspan=5></td>
</tr>

<tr>
<td colspan=5>현물전용SMS</td>
</tr>
<?php

$resultTxt += "현물전용SMS\n";

while ($rs = mysql_fetch_array($tmpRs5)) {
?>
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
</tr>
<?php
$resultTxt += $rs[1]."\n";
}
$resultTxt += "\n\n\n\n\n";
?>
<tr>
<td height=100 colspan=5></td>
</tr>


<tr>
<td colspan=5>평택촌놈 통합 파생</td>
</tr>
<?php
$resultTxt += "평택촌놈 통합파생\n";
while ($rs = mysql_fetch_array($tmpRs2)) {
?>
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
</tr>

<?php
$resultTxt += $rs[1]."\n";
}
$resultTxt += "\n\n\n\n\n";
?>

<tr>
<td height=100 colspan=5></td>
</tr>
<tr>
<td colspan=5>평택촌놈 파생 문자전용</td>
</tr>
<?php
$resultTxt += "평택촌놈 파생문자전용\n";
while ($rs = mysql_fetch_array($tmpRs3)) {
?>
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
</tr>
<?php
$resultTxt += $rs[1]."\n";
}
$resultTxt += "\n\n\n\n\n";
?>

<tr>
<td height=100 colspan=5></td>
</tr>
<tr>
<td colspan=5>봉추선생</td>
</tr>
<?php
$resultTxt += "봉추선생\n";
while ($rs = mysql_fetch_array($tmpRs4)) {
?>
<tr>
<td><?=$rs[0]?></td>
<td><?=$rs[1]?></td>
<td><?=$rs[2]?></td>
<td><?=$rs[3]?></td>
<td><?=$rs[5]?></td>
</tr>
<?php
$resultTxt += $rs[1]."\n";
}
$resultTxt += "\n\n\n\n\n";
?>
<tr>
<td height=100 colspan=5></td>
</tr>
<?php

?>















