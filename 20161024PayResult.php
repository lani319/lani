<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//2016�� 10�� 24�� ���� ������, ���� �ݾ׿� ���� ����

/*
2016. 11. 2, �׷���� ��ǥ�� ����

10�� 24�� ���� ���� �����ڵ鸸 ������� �ľ�/�Ŵ� �ۼ��ؼ� �÷���. 
  

1�� 1õ�� �� �̻� ������ ����~~~~~~ 1�� �ʸ�, ����, �ݾ�/2��....

2�� 1õ�� �� �̸�~5�鸸 �� �̻� ~~~~~~ 1��       //

3�� 5�鸸 �� �̸� ~~~~~~~~~ 1��      ///
  

������ ������ ����� �켱������.
�� ���� �Ⱓ�̳� �����ݾ� ����, ���� �̰����� �ڻ���� �������� 

* ���� 1�� 1�Ϻ��� �ڻ������ ���� ī�䳪 �츮 ����Ʈ ���� �Խ��� ����
11�� �߿� ���� �������� �����. ������ �Ҽ������� �ڻ������ ����.
������ʹ� ������ �Ļ������� �����Ѵ�. ö���ϰ� ����ȭ �������� ����.

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
<b><2016�� 10�� 24�� ���� ���� ������(2016/12/31����)></b>
</td></tr>
<tr align='center' bgcolor="DDDDDD" height="50px" style='font-weight:bold'>
<td>����</td>
<td>���̵�</td>
<td>�ʸ�(�̸�)</td>
<td>�����ݾ� (����)</td>
<td>���� ������¥</td>

</tr>
<?php
//���� �������� �����ͼ� 2���� �迭�� ���� �ִ´�.
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
<b><2016�� 10�� 24�� ���� �Ļ� ������></b>
</td></tr>

<?php
echo "<br>";
//�Ļ� �������� �����ͼ� 2���� �迭�� ���� �ִ´�.
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















