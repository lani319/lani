<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
/* //���� ���� ���� �ִ� �����..
$sql = "SELECT A.userID,A.userName,A.userNickname,A.gradeLevel,A.total_point,A.signdate,B.*, SUM(C.price) AS sumPrice
	FROM Member A 
	INNER JOIN 502bookTest B 
		ON A.idx = B.uidx
	INNER JOIN chargeInfo C
		ON A.idx = C.uidx
	WHERE C.state IN (1,3,10,12)
	GROUP BY C.uidx";
*/

//Cnt
$sql = "SELECT count(B.idx) as cnt
	FROM Member A 
	INNER JOIN 502bookTest B 
		ON A.idx = B.uidx where B.regDate >= '2011-11-27 00:00:00'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);

echo "��û�� : <font color='red'>".$rs[cnt]."</font> �� [���� �����ݾװ� �Խù� ���� �ӵ��� ���ϵǾ� ������ ������, �������� ���̵��� �� ����]";

$sql = "SELECT A.userID,A.userName,A.userNickname,A.gradeLevel,A.total_point,A.signdate,A.userNum,B.*
	FROM Member A 
	INNER JOIN 502bookTest B 
		ON A.idx = B.uidx where B.regDate >= '2011-11-27 00:00:00' order by idx desc";

$tmpRs = mysql_query($sql);

?>
<table width="1024px" border="0">
<tr bgcolor="4a4a4a" align="center">
<td style="color:FFFFFF;">ȸ������</td>
<td style="color:FFFFFF;">����</td>
<td style="color:FFFFFF;">����</td>
<td style="color:FFFFFF;">���</td>
<td style="color:FFFFFF;">����Ʈ</td>
<td style="color:FFFFFF;">����Ʈ������</td>
<td style="color:FFFFFF;">��û�� ����</td>
<td style="color:FFFFFF;">��û�� ����ó</td>
<td style="color:FFFFFF;">������</td>
<td style="color:FFFFFF;">���ڱⰣ</td>
<td style="color:FFFFFF;">���ڱ���</td>
<td style="color:FFFFFF;">��û��</td>
<td style="color:FFFFFF;">����Ʈ���������ݾ�</td>
<td style="color:FFFFFF;">����Ʈ�Խù���</td>
</tr>
<?php
while($rs = mysql_fetch_array($tmpRs))
{	
	$sex = substr(numDec($rs[userNum]),6,1);
	$age = 112-substr(numDec($rs[userNum]),0,2);		
	if ($sex == 1)
	{
		$sex = "��";
	}
	else 
	{
		$sex = "��";
	}
	?>
	<tr align="center">
		<td><?=$rs['userName']?> (<?=$rs['userNickname']?>) </td>
		<td><?=$sex?></td>
		<td><?=$age?></td>
		<td><?=$rs['gradeLevel']?></td>
		<td><?=$rs['total_point']?></td>
		<td><?=substr($rs['signdate'],0,10)?></td>
		<td><?=$rs['mName']?></td>
		<td><?=$rs['mobile']?></td>
		<td><?=$rs['area']?></td>
		<td><?=$rs['period']?></td>
		<td><?=$rs['investType']?></td>
		<td><?=$rs['regDate']?></td>
		<td>
		
		<?php
		
			$sumPrice = 0;
			$sql3 = "select sum(price) as price from chargeInfo where uidx = $rs[uidx] and state in (1,3,10,12)";
			$tmpRs3 = mysql_query($sql3);
			
			while($rs3 = mysql_fetch_array($tmpRs3))
			{
				$sumPrice = $sumPrice+ $rs3[price];
			}
			
			echo number_format($sumPrice);
		
		?>
		</td>
		<td>
		
		<?php
		/*
		$sumBoardCnt = 0;
			$sql2 = "SELECT COUNT(idx) AS cnt FROM NaraBoard_talkoflife WHERE userID='$rs[userID]'";
			$sql2 .= "UNION ";
			$sql2 .= "SELECT COUNT(idx) FROM NaraBoard_jqna WHERE userID='$rs[userID]' ";
			$sql2 .= "UNION  ";
			$sql2 .= "SELECT COUNT(idx) FROM NaraBoard_firstclass WHERE userID='$rs[userID]' ";
			echo $sql2;
			$tmpRs2 = mysql_query($sql2);
			while($rs2 = mysql_fetch_array($tmpRs2))
			{
				$sumBoardCnt = $sumBoardCnt + $rs2[cnt];
			}
			echo $sumBoardCnt;
		*/
			?>
			
		</td>
	</tr>	
	<?php
}
?>



</tr>
<tr><td colspan="20" height="10" bgcolor="CCCCCC"></td></tr>	
</table>

<!-- �Ʒ��� ����Ʈ ������� ���� �ִ� �����.. -->
