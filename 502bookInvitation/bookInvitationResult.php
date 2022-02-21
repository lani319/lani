<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
/* //유료 결제 경험 있는 사람만..
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

echo "신청자 : <font color='red'>".$rs[cnt]."</font> 명 [누적 결제금액과 게시물 수는 속도가 저하되어 공지를 내리고, 마지막에 보이도록 할 예정]";

$sql = "SELECT A.userID,A.userName,A.userNickname,A.gradeLevel,A.total_point,A.signdate,A.userNum,B.*
	FROM Member A 
	INNER JOIN 502bookTest B 
		ON A.idx = B.uidx where B.regDate >= '2011-11-27 00:00:00' order by idx desc";

$tmpRs = mysql_query($sql);

?>
<table width="1024px" border="0">
<tr bgcolor="4a4a4a" align="center">
<td style="color:FFFFFF;">회원정보</td>
<td style="color:FFFFFF;">성별</td>
<td style="color:FFFFFF;">나이</td>
<td style="color:FFFFFF;">등급</td>
<td style="color:FFFFFF;">포인트</td>
<td style="color:FFFFFF;">사이트가입일</td>
<td style="color:FFFFFF;">신청자 성명</td>
<td style="color:FFFFFF;">신청자 연락처</td>
<td style="color:FFFFFF;">거주지</td>
<td style="color:FFFFFF;">투자기간</td>
<td style="color:FFFFFF;">투자구분</td>
<td style="color:FFFFFF;">신청일</td>
<td style="color:FFFFFF;">사이트누적결제금액</td>
<td style="color:FFFFFF;">사이트게시물수</td>
</tr>
<?php
while($rs = mysql_fetch_array($tmpRs))
{	
	$sex = substr(numDec($rs[userNum]),6,1);
	$age = 112-substr(numDec($rs[userNum]),0,2);		
	if ($sex == 1)
	{
		$sex = "남";
	}
	else 
	{
		$sex = "여";
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

<!-- 아래는 사이트 유료결제 경험 있는 사람만.. -->
