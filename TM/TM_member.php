<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//���� ����
$tmpStr = "";


//TM_customer�� ��� �� ��� ��ü �� , �׸��� 1�� ���� �� ȸ�� ��, 2�� ���� �� ȸ�� ��, 3���̻� ���� �� ȸ�� ����
// �� ���� ���� �����ϱ�
$tmpAdmin = "";
$sql = "SELECT adminIdx, COUNT(idx) as cnt  FROM TM_customer GROUP BY adminIdx order by adminIdx ASC";
$cntAdmin = 0; //admin�� ��
$arrCntAdmin = array();

$arrAdmin = array();

$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs))
{
	
	$arrCntAdmin[] = $rs[cnt];
	$tmpAdmin = $tmpAdmin."$rs[adminIdx]".",";
	
	$arrAdmin[$cntAdmin][0] = $rs[adminIdx];		//adminIdx,1����ȭ/2����ȭ/3����ȭ/4���̻���ȭ
	$arrAdmin[$cntAdmin][1] = 0;		//adminIdx,1����ȭ/2����ȭ/3����ȭ/4���̻���ȭ
	$arrAdmin[$cntAdmin][2] = 0;		//adminIdx,1����ȭ/2����ȭ/3����ȭ/4���̻���ȭ
	$arrAdmin[$cntAdmin][3] = 0;		//adminIdx,1����ȭ/2����ȭ/3����ȭ/4���̻���ȭ
	$arrAdmin[$cntAdmin][4] = 0;		//adminIdx,1����ȭ/2����ȭ/3����ȭ/4���̻���ȭ
	
	
	$cntAdmin++;
}

$tmpAdmin = substr($tmpAdmin,0,strlen($tmpAdmin)-1);

$sql = "SELECT adminIdx,COUNT(userIdx) as cnt FROM TM_info WHERE adminIdx IN ($tmpAdmin) AND counselKind LIKE ('%5%') GROUP BY userIdx";

$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs))
{
	for($i=0 ; $i<$cntAdmin ; $i++)
	{
		if($rs[adminIdx]==$arrAdmin[$i][0])
		{
			
			switch ($rs[cnt])
			{
				case 1:
					$arrAdmin[$i][1]++;
					break;
				case 2:
					$arrAdmin[$i][2]++;
					break;					
				case 3:
					$arrAdmin[$i][3]++;
					break;		
				default:
					$arrAdmin[$i][4]++;
					break;															
			}
		}

	}
}



function getAdminName($adminCode)
{
	$sql = "select userName,userNickname from Member where idx=$adminCode";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	
	return $rs[userNickname]."($rs[userName])";
}



//���⿡ ������ ��� ��踦 �����ش�
?>
<html>
<head>
<link rel="stylesheet" href="table.css" type="text/css" />
<link rel="stylesheet" href="/css/502style.css" type="text/css" />
</head>
<body>
<br><br>
<table width="100%">
<tr>
<td width="110px"><?php include_once $_SERVER['DOCUMENT_ROOT']."/lani/TM/TM_menu.html"; ?></td>
<td><form name="form1" method="POST" action="TM_member_modOk.php">
<pre>
1. 2010�� 1��1��~7��31�ϱ��� ���� �� ȸ��
2. �ѹ��� ���� �� ���� ���� ���� ȸ��
3. ����� �����ͺ��̽��� ��� �� �� �ű� ȸ��

��� 3���� ������ �����ϸ� �Ʒ� ǥ���� �˴ϴ�. 
(������ ����ϸ�, 8��25�� ���Ŀ� ���� �� ���� ȸ�� �Դϴ�)

</pre>

<img src="images/titleTmMemberTop.gif">
<table cellpadding="0" cellspacing="0" border="0" width="800">
<tr align="center"  bgcolor="84b4b0">
<td style="color:FFFFFF;font-weight:bold;">����</td>
<td style="color:FFFFFF;font-weight:bold;">��ü����</td>
<td style="color:FFFFFF;font-weight:bold;">1ȸ��ȭ</td>
<td style="color:FFFFFF;font-weight:bold;">2ȸ��ȭ</td>
<td style="color:FFFFFF;font-weight:bold;">3ȸ��ȭ</td>
<td style="color:FFFFFF;font-weight:bold;">4ȸ�̻���ȭ</td>
</tr>
<tr><td colspan="10" height="1" bgcolor="skyblue"></td></tr>
<?php
for($i=0 ; $i<$cntAdmin ; $i++)
{
	?>
<tr align="center">
	<td><?=getAdminName($arrAdmin[$i][0])?></td>
	<td><?=$arrCntAdmin[$i]?></td>
	<td><?=$arrAdmin[$i][1]?></td>
	<td><?=$arrAdmin[$i][2]?></td>
	<td><?=$arrAdmin[$i][3]?></td>
	<td><?=$arrAdmin[$i][4]?></td>
</tr>	
	<tr><td colspan="10" background="images/line.gif"></td></tr>
	<?php
}
?>
<tr><td colspan="10" height="15" bgcolor="84b4b0"></td></tr>
</table>

<?php


/*
����
�������� ���� �ű� ȸ�����

������㳻���� ���� ����(���,�����������̾�,����Ŭ��,TMS)�� ���ϰ� Ż��/���� ȸ���� �ƴ� ���

*/

$sql = "SELECT A.idx,A.userId,A.signdate FROM Member A WHERE (LEFT(A.signdate,10) >= '2010-01-01' AND LEFT(A.signdate,10) <= '2010-07-31') AND A.Level > 1 AND A.member_state='Y'
AND (
    A.idx NOT IN (SELECT uidx FROM chargeInfo WHERE LEFT(paydate,10) >= '2010-01-01' ORDER BY idx DESC)
AND A.idx NOT IN (SELECT uidx FROM chargeContentsInfo WHERE LEFT(paydate,10) >= '2010-01-01' ORDER BY idx DESC)
AND A.idx NOT IN (SELECT uidx FROM tiker_charge WHERE LEFT(paydate,10) >= '2010-01-01' ORDER BY idx DESC)
AND A.idx NOT IN (SELECT uidx FROM investment_chargeInfo WHERE LEFT(paydate,10) >= '2010-01-01' ORDER BY idx DESC)
AND A.idx NOT IN (SELECT userIdx FROM TM_info ORDER BY idx DESC)
) order by A.idx DESC limit 0,10;
";


/*
$today = date("Y-m-d");
$today = "2010-05-01";
//2010�� 1��1�� ���Ŀ� ������ ��� �� , ��� ��� ����� �� �� ������� �����´�
$sql = "SELECT A.idx,A.userId,A.userName,A.userNickname,A.signdate FROM Member A WHERE (LEFT(A.signdate,10) >= '2010-01-01' AND LEFT(A.signdate,10) <= '2010-07-31')  AND A.Level > 1 AND A.member_state='Y'
AND ( 
    A.idx NOT IN (SELECT userIdx FROM TM_customer ORDER BY idx DESC)
) ORDER BY A.idx DESC";
//echo $sql;
//echo "<br>";
//echo "<br>";
*/
?>

<br>
<br>
<br>
<img src="images/titleTmMemberMiddle.gif">
<table cellpadding="0" cellspacing="0" border="0" width="800px">
<tr align="center"  bgcolor="84b4b0">
<td style="color:FFFFFF;font-weight:bold;">����</td>
<td style="color:FFFFFF;font-weight:bold;">ȸ�����̵�</td>
<td style="color:FFFFFF;font-weight:bold;">������</td>
<td style="color:FFFFFF;font-weight:bold;">�����</td>
</tr>
<tr><td colspan="10" height="1" bgcolor="skyblue"></td></tr>
<?php
$tmpRs = mysql_query($sql);
$rowCnt = mysql_num_rows($tmpRs);
$num = 1;
if($rowCnt>0)
{
	while($rs = mysql_fetch_array($tmpRs))
	{
		$sql2 = "SELECT uidx FROM chargeInfo WHERE LEFT(paydate,10) >= '$today' and uidx = $rs[idx]";
		$tmpRs2 = mysql_query($sql2);
		$rowCnt2 = mysql_num_rows($tmpRs2);
		
		$sql3 = "SELECT uidx FROM chargeContentsInfo WHERE LEFT(paydate,10) >= '$today' and uidx = $rs[idx]";
		$tmpRs3 = mysql_query($sql3);
		$rowCnt3 = mysql_num_rows($tmpRs3);
		
		$sql4 = "SELECT uidx FROM tiker_charge WHERE LEFT(paydate,10) >= '$today' and uidx = $rs[idx]";
		$tmpRs4 = mysql_query($sql4);
		$rowCnt4 = mysql_num_rows($tmpRs4);
		
		$sql5 = "SELECT uidx FROM investment_chargeInfo WHERE LEFT(paydate,10) >= '$today' and uidx = $rs[idx]";
		$tmpRs5 = mysql_query($sql5);
		$rowCnt5 = mysql_num_rows($tmpRs5);
		
		$sumRowCnt = $rowCnt2+$rowCnt3+$rowCnt4+$rowCnt5;
		
		if($sumRowCnt == 0) //��¥ �ѹ��� ���� ���� ȸ��
		{
			?>
	<tr><td colspan="10" height="1" bgcolor="AAAAAA"></td></tr>			
<tr align="center">
<td><?=$num++?></td>
<td><?=$rs[userName]?>  [<?=$rs[userNickname]?>]</td>
<td><?=$rs[signdate]?></td>
<td>
<?php
$sql = "select A.userName,A.userNickname,A.userId,A.idx from Member A inner join TM_admin B on A.userId = B.adminID order by B.idx desc";
	$tmpRs_tm = mysql_query($sql);
	echo "<select name='selTmAdmin' id = 'selTmAdmin'>";
	while($rs_tm = mysql_fetch_array($tmpRs_tm))
	{
		echo "<option value='$rs[idx]^$rs_tm[idx]^$rs[userId]'>$rs_tm[userName]</option>";
	}
	echo "</select>";
?>
</td>
</tr>
<tr><td colspan="10" background="images/line.gif"></td></tr>			
			
			<?php
		}
	}
}
if($num==1)
{
	echo "<tr><td colspan=10 align='center'>�߰� ��� ȸ���� �����ϴ�</td></tr>";
}

?>
<tr><td colspan="10" height="15" bgcolor="84b4b0"></td></tr>
<tr><td colspan="10" align="center"><input type="button" onclick="chkForm();" value="SUBMIT"></td></tr>

</table>
<?php
	$sql = "select A.idx from Member A inner join TM_admin B on A.userId = B.adminID order by B.idx desc";
	$tmpRs_tm = mysql_query($sql);
	while($rs = mysql_fetch_array($tmpRs_tm))
	{
	?>
	<input type="hidden" name="txt<?=$rs[idx]?>" id="txt<?=$rs[idx]?>" size="100"> <br>
	<?php
	}
	?>
<script type="text/javascript">
function chkForm()
{
	var x = document.getElementsByName("selTmAdmin");
	var cnt = x.length;
	//alert(cnt);
	var tStr = new Array();
	var i=0;
	
	var tName = "";
	
	for(i=0 ; i<cnt ; i++)
	{
		tStr = x[i].value.split('^');
		tName = "txt"+tStr[1];
		document.getElementById(tName).value = "";
	}
	
	for(i=0 ; i<cnt ; i++)
	{
		tStr = x[i].value.split('^');
		tName = "txt"+tStr[1];
		//alert(tName);
		
		document.getElementById(tName).value += x[i].value+"$";
		
		if(document.getElementById("txtParam").value.indexOf(tName) == -1)
		{
			document.getElementById("txtParam").value += tName+"^";
		}
		
	}
	
	var f = document.form1;
	f.submit();
}
</script>
<input type="hidden" name="txtParam" id="txtParam" value="" size="100">
</form></td>
</tr>
</table>
</body>
</html>