<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


/*
502 ����ȸ�� ����ó ���� ���
���� ������ ���Ϸ� ����
���� �������� �� �Ѹ������� ���� ������ �뵵
*/

$signdate = $date;

//���� ���� ���
$sql1 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND (B.settle_mode = 'great_stock')
AND B.exp_idx= 34904 order by B.enddate ASC";

//���� ��������
$sql5 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'tiker'
AND B.exp_idx= 34904 order by B.enddate ASC";

//���� �Ļ�
$sql2 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'investment'
AND B.exp_idx= 34904 order by B.enddate ASC";


//�Ļ� ��������
$sql3 = "
SELECT A.userId,A.userName,A.userNickname, A.mobile, B.mem_idx, from_unixtime(B.enddate) FROM Member A INNER join Member_expert B ON A.idx = B.mem_idx
WHERE B.enddate > UNIX_TIMESTAMP(NOW()) AND B.settle_mode = 'stock'
AND B.exp_idx= 34904 order by B.enddate ASC";


//���߼���
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
<td colspan=5>�����̳� �������� + ��������SMS (�� Ȩ������ ���չ��)</td>
</tr>
<?php

$resultTxt += "�����̳� �������� + ��������SMS\n";

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
<td colspan=5>��������SMS</td>
</tr>
<?php

$resultTxt += "��������SMS\n";

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
<td colspan=5>�����̳� ���� �Ļ�</td>
</tr>
<?php
$resultTxt += "�����̳� �����Ļ�\n";
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
<td colspan=5>�����̳� �Ļ� ��������</td>
</tr>
<?php
$resultTxt += "�����̳� �Ļ���������\n";
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
<td colspan=5>���߼���</td>
</tr>
<?php
$resultTxt += "���߼���\n";
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















