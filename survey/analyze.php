<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$userID = $_COOKIE["_CKE_USER_ID"];






$sql = "select count(idx) as cnt from 2011Survey where q1!=''";
$tmpRs = mysql_query($sql);
$rs= mysql_fetch_array($tmpRs);
$totalCnt = $rs[cnt];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/502style.css" />
</head>
<body>
<br><br>
<b>*�������� ���� ��� ���� <font color="Blue">[<?=$totalCnt?>��]</font> ���� - 2��28�ϱ��� ���� ����</b><br><br>
<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">1. �����̳�[502]�� �˰� �� ������?</td>
<td bgcolor="#FFFFCC">TV</td>
<td bgcolor="#FFFFCC">��б��</td>
<td bgcolor="#FFFFCC">���μҰ�</td>
<td bgcolor="#FFFFCC">���ͳݰ˻�</td>
</tr>
<tr align="center">

<?php 
//1�� ���� �м�
$sql = "select count(idx) as cnt from 2011Survey where q1 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q1 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q1 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q1 = '4'";


$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">2. ������ ������ ��� �ǽʴϱ�?</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">����</td>
</tr>
<tr align="center">

<?php 
//2�� ���� �м�
$sql = "select count(idx) as cnt from 2011Survey where q2 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q2 = '2'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">3. ������ ���ɴ�� ��� �ǽʴϱ�?</td>
<td bgcolor="#FFFFCC">10~19</td>
<td bgcolor="#FFFFCC">20~29</td>
<td bgcolor="#FFFFCC">30~39</td>
<td bgcolor="#FFFFCC">40~49</td>
<td bgcolor="#FFFFCC">50~59</td>
<td bgcolor="#FFFFCC">60~69</td>
<td bgcolor="#FFFFCC">70�̻�</td>
</tr>
<tr align="center">

<?php 
//3�� ���� �м�
$sql = "select count(idx) as cnt from 2011Survey where q3 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '5'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '6'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '7'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>
<!-- 
�迭 3�� ����
8
7
5

-->
<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px">4. ������ ������ ��� �ǽʴϱ�?</td>
<?php

//q4 ��� �����͸� �����ϱ� ���� �迭�� �����Ѵ�.
$arrq4_1 = array(0,0,0,0,0,0,0,0); //8
$arrq4_2 = array(0,0,0,0,0,0,0); //7
$arrq4_3 = array(0,0,0,0,0); //5

//4�� ���� �м�
$sql = "select q4 from 2011Survey";
$tmpRs = mysql_query($sql);
while ($rs= mysql_fetch_array($tmpRs)) 
{
	//���⿡ q4 �м� ����� ����.
	$tmpStr = explode("^",$rs[q4]);
	switch ($tmpStr[0])
	{
		case 1:
			$arrq4_1[0] += 1;
		break;
		case 2:
			$arrq4_1[1] += 1;
		break;
		case 3:
			$arrq4_1[2] += 1;
		break;
		case 4:
			$arrq4_1[3] += 1;
		break;
		case 5:
			$arrq4_1[4] += 1;
		break;
		case 6:
			$arrq4_1[5] += 1;
		break;
		case 7:
			$arrq4_1[6] += 1;
		break;
		case 8:
			$arrq4_1[7] += 1;
		break;
	}
	
	switch ($tmpStr[1])
	{
		case 1:
			$arrq4_2[0] += 1;
		break;
		case 2:
			$arrq4_2[1] += 1;
		break;
		case 3:
			$arrq4_2[2] += 1;
		break;
		case 4:
			$arrq4_2[3] += 1;
		break;
		case 5:
			$arrq4_2[4] += 1;
		break;
		case 6:
			$arrq4_2[5] += 1;
		break;
		case 7:
			$arrq4_2[6] += 1;
		break;
	}
	switch ($tmpStr[2])
	{
		case 1:
			$arrq4_3[0] += 1;
		break;
		case 2:
			$arrq4_3[1] += 1;
		break;
		case 3:
			$arrq4_3[2] += 1;
		break;
		case 4:
			$arrq4_3[3] += 1;
		break;
		case 5:
			$arrq4_3[4] += 1;
		break;
		case 6:
			$arrq4_3[5] += 1;
		break;
		case 7:
			$arrq4_3[6] += 1;
		break;
	}
}
?>
<td valign="top">
	<table>
	<tr>
	<td>�����,������ü</td>
	<td><?=$arrq4_1[0]?>&nbsp;&nbsp;[<?=round($arrq4_1[0]/$totalCnt*100,2)?>]%</td>
	
	</tr>
	<tr>
	<td>������	</td>
	<td><?=$arrq4_1[1]?>&nbsp;&nbsp;[<?=round($arrq4_1[1]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>������	</td>
	<td><?=$arrq4_1[2]?>	&nbsp;&nbsp;[<?=round($arrq4_1[2]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>������	</td>
	<td><?=$arrq4_1[3]?>	&nbsp;&nbsp;[<?=round($arrq4_1[3]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>��а�	</td>
	<td><?=$arrq4_1[4]?>	&nbsp;&nbsp;[<?=round($arrq4_1[4]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>�Ƿ��	</td>
	<td><?=$arrq4_1[5]?>&nbsp;&nbsp;[<?=round($arrq4_1[5]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>�Ϲݱ����(ȸ���)</td>
	<td><?=$arrq4_1[6]?>	&nbsp;&nbsp;[<?=round($arrq4_1[6]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>������</td>
	<td><?=$arrq4_1[7]?>	&nbsp;&nbsp;[<?=round($arrq4_1[7]/$totalCnt*100,2)?>]%</td>
	</tr>
	</table>
</td>
<td valign="top">
	<table>
	<tr>
	<td>�Ǽ�</td>
	<td><?=$arrq4_2[0]?>	&nbsp;&nbsp;[<?=round($arrq4_2[0]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>����,�����	</td>
	<td><?=$arrq4_2[1]?>	&nbsp;&nbsp;[<?=round($arrq4_2[1]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>���,�Ӿ�,�����,����	</td>
	<td><?=$arrq4_2[2]?>	&nbsp;&nbsp;[<?=round($arrq4_2[2]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>���Ҹ�,������	</td>
	<td><?=$arrq4_2[3]?>	&nbsp;&nbsp;[<?=round($arrq4_2[3]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>�ε���,�Ӵ�,���μ���	</td>
	<td><?=$arrq4_2[4]?>	&nbsp;&nbsp;[<?=round($arrq4_2[4]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>����,���ľ�,���,â��,��ž�	</td>
	<td><?=$arrq4_2[5]?>	&nbsp;&nbsp;[<?=round($arrq4_2[5]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>����,����,����,������</td>
	<td><?=$arrq4_2[6]?>	&nbsp;&nbsp;[<?=round($arrq4_2[6]/$totalCnt*100,2)?>]%</td>
	</tr>	
	</table>
</td>
<td valign="top">
	<table>
	<tr>
	<td>����������</td>
	<td><?=$arrq4_3[0]?>	&nbsp;&nbsp;[<?=round($arrq4_3[0]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>�ֺ�	</td>
	<td><?=$arrq4_3[1]?>	&nbsp;&nbsp;[<?=round($arrq4_3[1]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>�л�	</td>
	<td><?=$arrq4_3[2]?>	&nbsp;&nbsp;[<?=round($arrq4_3[2]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>����������	</td>
	<td><?=$arrq4_3[3]?>	&nbsp;&nbsp;[<?=round($arrq4_3[3]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>��Ÿ/�ش����	</td>
	<td><?=$arrq4_3[4]?>	&nbsp;&nbsp;[<?=round($arrq4_3[4]/$totalCnt*100,2)?>]%</td>
	</tr>
	</table>
</td>
</tr>
</table>



<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">5. ���� ���ڱ��� ��� �ǽʴϱ�?</td>
<td bgcolor="#FFFFCC">5�� �ʰ�</td>
<td bgcolor="#FFFFCC">3��~5��</td>
<td bgcolor="#FFFFCC">1��~3��</td>
<td bgcolor="#FFFFCC">5000��~1��</td>
<td bgcolor="#FFFFCC">2000��~5000��</td>
<td bgcolor="#FFFFCC">2000�� ����</td>
</tr>
<tr align="center">
<?php 
//5�� ���� �м�
$sql = "select count(idx) as cnt from 2011Survey where q5 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '5'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '6'";


$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">6.�����̳�[502]�� �� ��� �󸶳� �̿��Ͻʴϱ�?</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">�� 5ȸ �̻�</td>
<td bgcolor="#FFFFCC">�� 3 ~ 4ȸ</td>
<td bgcolor="#FFFFCC">�� 1 ~ 2ȸ</td>
<td bgcolor="#FFFFCC">�� 1ȸ �̸�</td>
</tr>
<tr align="center">
<?php 
//6�� ���� �м�
$sql = "select count(idx) as cnt from 2011Survey where q6 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '5'";



$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<!-- ������ʹ� ���� ���� �Խ���,,����Ϸ��� �׾���..�Ф� -->

<?php
$arr7 = array(
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0
);

$arr8 = array(
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0
);


$sql = "select q7 from 2011Survey";
$tmpRs = mysql_query($sql);
while ($rs= mysql_fetch_array($tmpRs)) 
{
	//���⿡ q7 �м� ����� ����.
	$tmpStr = explode("^",$rs[q7]);
	
	//echo sizeof($arr7);
	
	for($i=0 ; $i < sizeof($arr7) ; $i++)
	{
		if($tmpStr[0] == $i+1)
		{
			$arr7[$i] += 1; 
			//echo $tmpStr[0]."<br>";			
		}
		if($tmpStr[1] == $i+1)
		{
			$arr7[$i] += 1; 
			//echo $tmpStr[1]."<br>";			
		}
		if($tmpStr[2] == $i+1)
		{
			$arr7[$i] += 1; 
			//echo $tmpStr[2]."<br>";			
		}
	}	
}
?>

<br>
<table cellpadding="0" cellspacing="0" border="1" width="1200px">
<tr align="center">
<td width="300px">7.�����̳�[502]���� ���� ���� �̿��ϴ� �Խ�����?</td>
<td>
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td align="left" valign="top">
	<img src="img/sub1.jpg" border="0"><!--���ͳݹ��--><br>	
	��������ȳ�&nbsp;&nbsp; <?=$arr7[0]?>�� &nbsp;&nbsp; [<?=round($arr7[0]/$totalCnt*100,2)?>]%<br>
	��۵��𺸱�&nbsp;&nbsp; <?=$arr7[1]?>��  &nbsp;&nbsp; [<?=round($arr7[1]/$totalCnt*100,2)?>]%<br>
	����ü���û&nbsp;&nbsp; <?=$arr7[2]?>��  &nbsp;&nbsp; [<?=round($arr7[2]/$totalCnt*100,2)?>]%<br>
	��۽�û�ı�&nbsp;&nbsp; <?=$arr7[3]?>��  &nbsp;&nbsp; [<?=round($arr7[3]/$totalCnt*100,2)?>]%<br>
	��ȭ��ۺ���&nbsp;&nbsp; <?=$arr7[4]?>��  &nbsp;&nbsp; [<?=round($arr7[4]/$totalCnt*100,2)?>]%<br>
	�����̾��Ӻ�&nbsp;&nbsp; <?=$arr7[5]?>��  &nbsp;&nbsp; [<?=round($arr7[5]/$totalCnt*100,2)?>]%<br>
	�Ϲ�ȸ���Ӻ�&nbsp;&nbsp; <?=$arr7[6]?>��  &nbsp;&nbsp; [<?=round($arr7[6]/$totalCnt*100,2)?>]%<br>
	�ֽİ���VOD&nbsp;&nbsp; <?=$arr7[7]?>��  &nbsp;&nbsp; [<?=round($arr7[7]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub2.jpg" border="0"><!--VIP--><br>
	�����̾�&nbsp;&nbsp; <?=$arr7[8]?>��   &nbsp;&nbsp; [<?=round($arr7[8]/$totalCnt*100,2)?>]%<br>
	����Ŭ��&nbsp;&nbsp; <?=$arr7[9]?>��   &nbsp;&nbsp; [<?=round($arr7[9]/$totalCnt*100,2)?>]%<br>
	502TMS&nbsp;&nbsp; <?=$arr7[10]?>��   &nbsp;&nbsp;&nbsp; [<?=round($arr7[10]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub3.jpg" border="0"><!--��������--><br>
	������ ��������&nbsp;&nbsp; <?=$arr7[11]?>��   &nbsp;&nbsp; [<?=round($arr7[11]/$totalCnt*100,2)?>]%<br>
	1��� �м���&nbsp;&nbsp; <?=$arr7[12]?>��  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr7[12]/$totalCnt*100,2)?>]%<br>
	�����̳� Į�� &nbsp;&nbsp; <?=$arr7[13]?>��  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr7[13]/$totalCnt*100,2)?>]%<br>
	�ɺô� ������õ&nbsp;&nbsp; <?=$arr7[14]?>��  &nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr7[14]/$totalCnt*100,2)?>]%<br>
	502����&nbsp;&nbsp; <?=$arr7[15]?>��   &nbsp; [<?=round($arr7[15]/$totalCnt*100,2)?>]%<br>
	502����ƼĿ&nbsp;&nbsp; <?=$arr7[16]?>��   &nbsp;&nbsp; [<?=round($arr7[16]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub4.jpg" border="0"><!--������н�--><br>
	������õ ž10 &nbsp;&nbsp; <?=$arr7[17]?>��    &nbsp;&nbsp; [<?=round($arr7[17]/$totalCnt*100,2)?>]%<br>
	������õ&nbsp;&nbsp; <?=$arr7[18]?>��     &nbsp;&nbsp; [<?=round($arr7[18]/$totalCnt*100,2)?>]%<br>
	��������(�ڽ���)&nbsp;&nbsp; <?=$arr7[19]?>��     &nbsp;&nbsp; [<?=round($arr7[19]/$totalCnt*100,2)?>]%<br>
	��������(�ڽ���)&nbsp;&nbsp; <?=$arr7[20]?>��     &nbsp;&nbsp; [<?=round($arr7[20]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	<tr><td colspan="4" align="center" height="20px"></td></tr>
	<tr valign="top">
	<td align="left">
	<img src="img/sub5.jpg" border="0"><!--�Ÿ��򰡽�--><br>
	�ֽĸŸ�����&nbsp;&nbsp; <?=$arr7[21]?>��     &nbsp;&nbsp; [<?=round($arr7[21]/$totalCnt*100,2)?>]%<br>
	�����Ÿ����� &nbsp;&nbsp; <?=$arr7[22]?>��    &nbsp;&nbsp; [<?=round($arr7[22]/$totalCnt*100,2)?>]%<br>
	�Ÿų��Ͽ�&nbsp;&nbsp; <?=$arr7[23]?>��     &nbsp;&nbsp; [<?=round($arr7[23]/$totalCnt*100,2)?>]%<br>
	���ͷ��Խ��� &nbsp;&nbsp; <?=$arr7[24]?>��    &nbsp;&nbsp; [<?=round($arr7[24]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub6.jpg" border="0"><!--���̻����--><br> 
	502������ &nbsp;&nbsp; <?=$arr7[25]?>��    &nbsp;&nbsp; [<?=round($arr7[25]/$totalCnt*100,2)?>]%<br>
	�������̾߱�&nbsp;&nbsp; <?=$arr7[26]?>��     &nbsp;&nbsp; [<?=round($arr7[26]/$totalCnt*100,2)?>]%<br>
	�ֽİ��ι� &nbsp;&nbsp; <?=$arr7[27]?>��    &nbsp;&nbsp; [<?=round($arr7[27]/$totalCnt*100,2)?>]%<br>
	������&nbsp;&nbsp; <?=$arr7[28]?>��     &nbsp;&nbsp; [<?=round($arr7[28]/$totalCnt*100,2)?>]%<br>
	�⼮üũ &nbsp;&nbsp; <?=$arr7[29]?>��    &nbsp;&nbsp; [<?=round($arr7[29]/$totalCnt*100,2)?>]%<br>
	��ŷ,���� &nbsp;&nbsp; <?=$arr7[30]?>��    &nbsp;&nbsp; [<?=round($arr7[30]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub7.jpg" border="0"><!--������--><br>
	�������� &nbsp;&nbsp; <?=$arr7[31]?>��    &nbsp;&nbsp; [<?=round($arr7[31]/$totalCnt*100,2)?>]%<br>
	������ �亯 &nbsp;&nbsp; <?=$arr7[32]?>��    &nbsp;&nbsp; [<?=round($arr7[32]/$totalCnt*100,2)?>]%<br>
	���� �̿�ȳ� &nbsp;&nbsp; <?=$arr7[33]?>��    &nbsp;&nbsp; [<?=round($arr7[33]/$totalCnt*100,2)?>]%<br>
	����Ʈ �̿�ȳ� &nbsp;&nbsp; <?=$arr7[34]?>��   &nbsp;&nbsp; [<?=round($arr7[34]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub8.jpg" border="0"><!--FIRST--><br>
	FIRST &nbsp;&nbsp; <?=$arr7[35]?>��    &nbsp;&nbsp; [<?=round($arr7[35]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>	
<?php

$sql = "select q8 from 2011Survey";
$tmpRs = mysql_query($sql);
while ($rs= mysql_fetch_array($tmpRs)) 
{
	$tmpStr = explode("^",$rs[q8]);
	
	for($i=0 ; $i < sizeof($arr8) ; $i++)
	{
		if($tmpStr[0] == $i+1)
		{
			$arr8[$i] += 1; 
		}
		if($tmpStr[1] == $i+1)
		{
			$arr8[$i] += 1; 			
		}
		if($tmpStr[2] == $i+1)
		{
			$arr8[$i] += 1; 
		}
	}	
}
?>


<br>
<table cellpadding="0" cellspacing="0" border="1" width="1200px">
<tr align="center">
<td width="300px">8.�����̳𿡼� ���� ���� �̿����� �ʴ� �Խ�����?</td>
<td align="center">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td align="left" valign="top">
	<img src="img/sub1.jpg" border="0"><!--���ͳݹ��--><br>	
	��������ȳ�&nbsp;&nbsp; <?=$arr8[0]?>�� &nbsp;&nbsp; [<?=round($arr8[0]/$totalCnt*100,2)?>]%<br>
	��۵��𺸱�&nbsp;&nbsp; <?=$arr8[1]?>��  &nbsp;&nbsp; [<?=round($arr8[1]/$totalCnt*100,2)?>]%<br>
	����ü���û&nbsp;&nbsp; <?=$arr8[2]?>��  &nbsp;&nbsp; [<?=round($arr8[2]/$totalCnt*100,2)?>]%<br>
	��۽�û�ı�&nbsp;&nbsp; <?=$arr8[3]?>��  &nbsp;&nbsp; [<?=round($arr8[3]/$totalCnt*100,2)?>]%<br>
	��ȭ��ۺ���&nbsp;&nbsp; <?=$arr8[4]?>��  &nbsp;&nbsp; [<?=round($arr8[4]/$totalCnt*100,2)?>]%<br>
	�����̾��Ӻ�&nbsp;&nbsp; <?=$arr8[5]?>��  &nbsp;&nbsp; [<?=round($arr8[5]/$totalCnt*100,2)?>]%<br>
	�Ϲ�ȸ���Ӻ�&nbsp;&nbsp; <?=$arr8[6]?>��  &nbsp;&nbsp; [<?=round($arr8[6]/$totalCnt*100,2)?>]%<br>
	�ֽİ���VOD&nbsp;&nbsp; <?=$arr8[7]?>��  &nbsp;&nbsp; [<?=round($arr8[7]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub2.jpg" border="0"><!--VIP--><br>
	�����̾�&nbsp;&nbsp; <?=$arr8[8]?>��   &nbsp;&nbsp; [<?=round($arr8[8]/$totalCnt*100,2)?>]%<br>
	����Ŭ��&nbsp;&nbsp; <?=$arr8[9]?>��   &nbsp;&nbsp; [<?=round($arr8[9]/$totalCnt*100,2)?>]%<br>
	502TMS&nbsp;&nbsp; <?=$arr8[10]?>��   &nbsp;&nbsp;&nbsp; [<?=round($arr8[10]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub3.jpg" border="0"><!--��������--><br>
	������ ��������&nbsp;&nbsp; <?=$arr8[11]?>��   &nbsp;&nbsp; [<?=round($arr8[11]/$totalCnt*100,2)?>]%<br>
	1��� �м���&nbsp;&nbsp; <?=$arr8[12]?>��  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr8[12]/$totalCnt*100,2)?>]%<br>
	�����̳� Į�� &nbsp;&nbsp; <?=$arr8[13]?>��  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr8[13]/$totalCnt*100,2)?>]%<br>
	�ɺô� ������õ&nbsp;&nbsp; <?=$arr8[14]?>��  &nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr8[14]/$totalCnt*100,2)?>]%<br>
	502����&nbsp;&nbsp; <?=$arr8[15]?>��   &nbsp; [<?=round($arr8[15]/$totalCnt*100,2)?>]%<br>
	502����ƼĿ&nbsp;&nbsp; <?=$arr8[16]?>��   &nbsp;&nbsp; [<?=round($arr8[16]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub4.jpg" border="0"><!--������н�--><br>
	������õ ž10 &nbsp;&nbsp; <?=$arr8[17]?>��    &nbsp;&nbsp; [<?=round($arr8[17]/$totalCnt*100,2)?>]%<br>
	������õ&nbsp;&nbsp; <?=$arr8[18]?>��     &nbsp;&nbsp; [<?=round($arr8[18]/$totalCnt*100,2)?>]%<br>
	��������(�ڽ���)&nbsp;&nbsp; <?=$arr8[19]?>��     &nbsp;&nbsp; [<?=round($arr8[19]/$totalCnt*100,2)?>]%<br>
	��������(�ڽ���)&nbsp;&nbsp; <?=$arr8[20]?>��     &nbsp;&nbsp; [<?=round($arr8[20]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	<tr><td colspan="4" align="center" height="20px"></td></tr>
	<tr valign="top">
	<td align="left">
	<img src="img/sub5.jpg" border="0"><!--�Ÿ��򰡽�--><br>
	�ֽĸŸ�����&nbsp;&nbsp; <?=$arr8[21]?>��     &nbsp;&nbsp; [<?=round($arr8[21]/$totalCnt*100,2)?>]%<br>
	�����Ÿ����� &nbsp;&nbsp; <?=$arr8[22]?>��    &nbsp;&nbsp; [<?=round($arr8[22]/$totalCnt*100,2)?>]%<br>
	�Ÿų��Ͽ�&nbsp;&nbsp; <?=$arr8[23]?>��     &nbsp;&nbsp; [<?=round($arr8[23]/$totalCnt*100,2)?>]%<br>
	���ͷ��Խ��� &nbsp;&nbsp; <?=$arr8[24]?>��    &nbsp;&nbsp; [<?=round($arr8[24]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub6.jpg" border="0"><!--���̻����--><br> 
	502������ &nbsp;&nbsp; <?=$arr8[25]?>��    &nbsp;&nbsp; [<?=round($arr8[25]/$totalCnt*100,2)?>]%<br>
	�������̾߱�&nbsp;&nbsp; <?=$arr8[26]?>��     &nbsp;&nbsp; [<?=round($arr8[26]/$totalCnt*100,2)?>]%<br>
	�ֽİ��ι� &nbsp;&nbsp; <?=$arr8[27]?>��    &nbsp;&nbsp; [<?=round($arr8[27]/$totalCnt*100,2)?>]%<br>
	������&nbsp;&nbsp; <?=$arr8[28]?>��     &nbsp;&nbsp; [<?=round($arr8[28]/$totalCnt*100,2)?>]%<br>
	�⼮üũ &nbsp;&nbsp; <?=$arr8[29]?>��    &nbsp;&nbsp; [<?=round($arr8[29]/$totalCnt*100,2)?>]%<br>
	��ŷ,���� &nbsp;&nbsp; <?=$arr8[30]?>��    &nbsp;&nbsp; [<?=round($arr8[30]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub7.jpg" border="0"><!--������--><br>
	�������� &nbsp;&nbsp; <?=$arr8[31]?>��    &nbsp;&nbsp; [<?=round($arr8[31]/$totalCnt*100,2)?>]%<br>
	������ �亯 &nbsp;&nbsp; <?=$arr8[32]?>��    &nbsp;&nbsp; [<?=round($arr8[32]/$totalCnt*100,2)?>]%<br>
	���� �̿�ȳ� &nbsp;&nbsp; <?=$arr8[33]?>��    &nbsp;&nbsp; [<?=round($arr8[33]/$totalCnt*100,2)?>]%<br>
	����Ʈ �̿�ȳ� &nbsp;&nbsp; <?=$arr8[34]?>��   &nbsp;&nbsp; [<?=round($arr8[34]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub8.jpg" border="0"><!--FIRST--><br>
	FIRST &nbsp;&nbsp; <?=$arr8[35]?>��    &nbsp;&nbsp; [<?=round($arr8[35]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>	


<br>

<table cellpadding="0" cellspacing="0" border="1" width="1200px">
<tr align="center">
<td width="300px" rowspan="2">9.�����̳�[502]�� ���μ��񽺸� �˰� �ִ�</td>
<td bgcolor="#FFFFCC">�� �˰� �ְ� ����غ��� �ִ�</td>
<td bgcolor="#FFFFCC">�˰������� ����غ��� ����</td>
<td bgcolor="#FFFFCC">������. �����ε� ����غ� �ǻ簡 ����</td>
<td bgcolor="#FFFFCC">�������� ���� ����� �ǻ簡 �ִ�</td>
</tr>
<tr align="center">
<?php 
//9�� ���� �м�
$sql = " select count(idx) as cnt from 2011Survey where q9 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q9 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q9 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q9 = '4'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">10.�����̳�[502]�� �����̾� ��۰� 502Ŭ���� �������� �˰� �ִ�. </td>
<td bgcolor="#FFFFCC">�� �˰� �ִ�</td>
<td bgcolor="#FFFFCC">���� �˰� �ִ�</td>
<td bgcolor="#FFFFCC">502Ŭ���� �˰� �ִ�</td>
<td bgcolor="#FFFFCC">�����̾��� �˰� �ִ�</td>
<td bgcolor="#FFFFCC">�� �𸥴�</td>
</tr>
<tr align="center">

<?php 
//10�� ���� �м�
$sql = " select count(idx) as cnt from 2011Survey where q10 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '5'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">11. Ȩ���������� �����ϴ� ������ �ֽ����� ���� ���뿡 ���� ��� �����Ͻʴϱ�?</td>
<td bgcolor="#FFFFCC">�ſ츸��</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">�Ҹ���</td>
</tr>
<tr align="center">
<?php 
//11�� ���� �м�
$sql = " select count(idx) as cnt from 2011Survey where q11 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q11 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q11 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q11 = '4'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">12. ����Ʈ�� �޴������̳� ��ü���� ��ġ�� ���� ���ϰ� ���� �Ǿ� �ֽ��ϱ�?</td>
<td bgcolor="#FFFFCC">�ſ츸��</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">�Ҹ���</td>
</tr>
<tr align="center">
<?php 
//12�� ���� �м�
$sql = " select count(idx) as cnt from 2011Survey where q12 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q12 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q12 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q12 = '4'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">13. ���ÿ� �̿����� Ÿ �ֽ����� ����Ʈ�� �ֽ��ϱ�?</td>
<td bgcolor="#FFFFCC">�Ž���</td>
<td bgcolor="#FFFFCC">��ũǮ</td>
<td bgcolor="#FFFFCC">���̸�ġ</td>
<td bgcolor="#FFFFCC">���丶��</td>
<td bgcolor="#FFFFCC">�Ϳ��</td>
<td bgcolor="#FFFFCC">�ŵ�Ӵ�</td>
<td bgcolor="#FFFFCC">502���̿�</td>
</tr>
<tr align="center">
<?php 
//13�� ���� �м�
$sql = " select count(idx) as cnt from 2011Survey where q13 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '4'"; //568
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '5'"; //568
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '6'"; //568
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '8'"; //568

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center" >
<td width="300px" rowspan="2">14. �̿����� Ÿ ����Ʈ�� ���� ��������?</td>
<td bgcolor="#FFFFCC">�ſ츸��</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">����</td>
<td bgcolor="#FFFFCC">�Ҹ���</td>
</tr>
<tr align="center">
<?php 
//14�� ���� �м�
$sql = " select count(idx) as cnt from 2011Survey where q14 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q14 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q14 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q14 = '4'"; 

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>
<br>
<br>
<br>
�ְ��� �亯 ���� (ȸ������ 502 ����Ʈ�� ���� �ǰ��� �����ϰ� ��� �;� �Ҹ�� ���� ���͸��� ���� �����Դϴ�.)
<br>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lani/survey/analyzeText.php";
?>
<!--
<iframe name="invFrame" src="/lani/survey/analyzeText.php" width="1100" height="100%"></iframe>
-->

</body>
</html>

