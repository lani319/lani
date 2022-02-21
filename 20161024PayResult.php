<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//2016년 10월 24일 이후 결제자, 결제 금액에 따라서 추출

/*
2016. 11. 2, 그룹웨어 대표님 지시

10월 24일 이후 연장 결제자들만 대상으로 파악/매달 작성해서 올려라. 
  

1군 1천만 원 이상 결제자 순서~~~~~~ 1번 필명, 본명, 금액/2번....

2군 1천만 원 미만~5백만 원 이상 ~~~~~~ 1번       //

3군 5백만 원 미만 ~~~~~~~~~ 1번      ///
  

앞으로 보답할 사람들 우선순위야.
그 전에 기간이나 결제금액 무시, 오직 이것으로 자산관리 정보전달 

* 내년 1월 1일부터 자산관리는 별도 카페나 우리 사이트 별도 게시판 전달
11월 중에 내가 공지사항 만든다. 어차피 소수정예로 자산관리를 들어간다.
내년부터는 온전한 파생정보만 전달한다. 철저하게 차별화 전략으로 간다.

*/

$sql1 = "

select A.userId,A.userName,A.userNickname,TotalPriceA, paydate

from Member A
inner join (
select uidx, sum(price) as TotalPriceA , paydate from 
chargeInfo
where paydate > '2016-10-24 00:00:01' and paydate < '2016-12-31 23:59:59'
and state in (1,3,12)
group by uidx
) as Stock
on A.idx = Stock.uidx
order by A.userId ASC
";


$sql2="
select A.userId,A.userName,A.userNickname,TotalPriceB, paydate
from Member A
inner join (
select uidx, sum(price) as TotalPriceB, paydate from 
investment_union_chargeInfo
where paydate > '2016-10-24 00:00:01' and paydate < '2016-12-31 23:59:59'
and state in (1,3,12)
group by uidx
) as Future
on A.idx = Future.uidx
order by A.userId ASC
";

$cntStock=0;
$cntFuture=0;


//$result = array[num,3];

?>

<Table width="700px" align="center" border=1 cellpadding=0 cellspacing=0>
<tr align=center><td colspan=10>
<b><2016년 10월 24일 이후 현물 결제자(2016/12/31까지)></b>
</td></tr>
<tr align='center' bgcolor="DDDDDD" height="50px" style='font-weight:bold'>
<td>순번</td>
<td>아이디</td>
<td>필명(이름)</td>
<td>결제금액 (현물)</td>
<td>최초 결제날짜</td>

</tr>
<?php
//현물 결제내역 가져와서 2차원 배열에 값을 넣는다.
$tmpRs = mysql_query($sql1);
$numStock = mysql_num_rows($tmpRs);
while($rs = mysql_fetch_array($tmpRs)){	
	$resultStock[$cntStock]['userId']= $rs[userId];
	$resultStock[$cntStock]['userInfo']= $rs[userNickname]."(".$rs[userName].")";
	$resultStock[$cntStock]['sumprice']= $rs[TotalPriceA];
//	echo $resultStock[$cntStock]['userId'];
	?>
		<tr height="30px" align=center>
		<td><?=$cntStock+1?></td>		
		<td><?=$rs[userId]?></td>		
		<td><?=$rs[userNickname]."(".$rs[userName].")"?></td>		
		<td><?=number_format($rs[TotalPriceA])?></td>
		<td><?=$rs[paydate]?></td>
		
		</tr>
		<?php
		$cntStock++;		
}

?>

<tr align=center><td colspan=10>
<b><2016년 10월 24일 이후 파생 결제자></b>
</td></tr>

<?php
echo "<br>";
//파생 결제내역 가져와서 2차원 배열에 값을 넣는다.
$tmpRs = mysql_query($sql2);
$numFuture = mysql_num_rows($tmpRs);
while($rs = mysql_fetch_array($tmpRs)){ 
	
	$resultFuture[$cntFuture]['userId']= $rs[userId];
	$resultFuture[$cntFuture]['userInfo']= $rs[userNickname]."(".$rs[userName].")";
	$resultFuture[$cntFuture]['sumprice']= $rs[TotalPriceB];
	
//	echo $resultFuture[$cntFuture]['userId'];
	
	?>
	
		<tr height="30px" align=center>
		<td><?=$cntFuture+1?></td>		
		<td><?=$rs[userId]?></td>		
		<td><?=$rs[userNickname]."(".$rs[userName].")"?></td>		
		<td><?=number_format($rs[TotalPriceB])?></td>
		<td><?=$rs[paydate]?></td>
		</tr>
	
	<?php
	$cntFuture++;
}
?>
</table>















