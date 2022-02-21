<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//���ͳ� ��۸� �������� 

//���ͳ� ��� + �������� + �Ļ���ǰ 

$sql1 = "
		select A.userName,A.userNickname,A.userId,A.gradeLevel, t.uidx, sum(t.price) as price
		from 
		(
		select uidx, sum(price) as price from chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx

		union all

		select uidx, sum(price) as price from investment_chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx

		union all

		select uidx, sum(price) as price from investment_union_chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx
		
		union all
		
		select uidx, sum(price) as price from stock_sms_chargeInfo where state in (1,3,10,12) 
		and paydate < '2018-11-24 23:59:59'
		group by uidx
		
		) t

		inner Join Member A on A.idx = t.uidx

		group by t.uidx
		order by A.gradeLevel ASC, price DESC

		";

echo $sql;

$result = mysql_query($sql1) or die(mysql_error());



?>

<table border=1 cellpadding=0 cellspacing=0 width="90%">
<tr>
<td colspan="10">
<br><br>
<font color=red>2018.11.11 �����̳� ����Ʈ �������� (��Ʈ��+F ������ �˻�)</font><br><br>
*���ͳݹ�� + SMS����(TMS) + �Ļ�(�ֽļ���SMS����)<br><br>
<pre>
1. �����̳� ���� ����ȸ�� (2018�� 6�� 6�� 00�� ����)

1����ȸ�� ���� 5,000�� �� �ʰ� ������ : 10�� ��
2����ȸ�� ���� 3,000�� �� �ʰ� ~ 5,000�� �� ���� ������ : 50�� ��
3����ȸ�� ���� 2,000�� �� �ʰ� ~ 3,000�� �� ���� ������ : 100�� ��
4����ȸ�� ���� 1,000�� �� �ʰ� ~ 2,000�� �� ���� ������ : 150�� ��
5����ȸ�� ���� 750�� �� �ʰ� ~ 1,000�� �� ���� ������ : 200�� ��
6����ȸ�� ���� 750�� �� �̸� ������ : 250�� ��
7����ȸ�� ���� 500�� �� �̸� ������ : 300�� ��

2. �����̳� ���� ����ȸ�� (2018�� 6�� 6�� 00�� ����)

1����ȸ�� ���� 5,000�� �� �ʰ� ������ : 20�� ��
2����ȸ�� ���� 3,000�� �� �ʰ� ~ 5,000�� �� ���� ������ : 100�� ��
3����ȸ�� ���� 2,000�� �� �ʰ� ~ 3,000�� �� ���� ������ : 200�� ��
4����ȸ�� ���� 2,000�� �� ���� ������ : 300�� ��

Ư���Ȳ
���� �����̳� �Ǵ� ���÷��� ����ȸ�� �ƴ� ��� ���� ����ȸ�� ����

3. ���÷��� ���� ����ȸ�� (2018�� 6�� 6�� 00�� ����)
1����ȸ�� ���� 1,000�� �� �ʰ� ������ : 50�� ��
2����ȸ�� ���� 750�� �� �ʰ�~1,000�� �� ���� ������ : 100�� ��
3����ȸ�� ���� 500�� �� �ʰ�~750�� �� ���� ������ : 150�� ��
4����ȸ�� ���� 250�� �� �ʰ�~500�� �� ���� ������ : 200�� ��
5����ȸ�� ���� 125�� �� �ʰ�~250�� �� ���� ������ : 250�� ��
6����ȸ�� ���� 125�� �� ���� ������ : 300�� ��

Ư�����
���� ���÷��� ����ȸ���� ���� �����̳� ����ȸ�� �������� ������
���� ���÷��� ����ȸ�� �� �����̳� �ֽļ��� �������� ����

4. ������ ��� ����ȸ���� 400�� ��
</pre>
</td>
</tr>
<tr align='center'>
<td>�̸�</td>
<td>�ʸ�</td>
<td>���̵�</td>
<td>���<br>(1���=����)</td>
<td>���� �����ݾ�</td>
<td>���� �����ݾ�</td>
</tr>

<?php
while($charge_info=mysql_fetch_array($result)){
	$sumTotalPrice = 0;	
	$finalPrice = 0;	
		
	
	$sumTotalPrice = $charge_info[price];
			
		if($charge_info[gradeLevel] == 1){ //���� ����ȸ��
			if($sumTotalPrice > 50000000){
				$finalPrice = 110000;
			}else if($sumTotalPrice > 30000000 && $sumTotalPrice <= 50000000){
				$finalPrice = 550000;
				
			}else if($sumTotalPrice > 20000000 && $sumTotalPrice <= 30000000){
				$finalPrice = 1100000;
				
			}else if($sumTotalPrice > 10000000 && $sumTotalPrice <= 20000000){
				$finalPrice = 1650000;
				
			}
			else if($sumTotalPrice > 7500000 && $sumTotalPrice <= 10000000){
				$finalPrice = 2200000;
				
			}else if($sumTotalPrice >= 5000000 && $sumTotalPrice <= 7500000){
				$finalPrice = 2750000;
				
			}
			else if($sumTotalPrice < 5000000){
				$finalPrice = 3300000;
			}
			
	
		}else{ //���� ����ȸ��
			if($sumTotalPrice > 50000000){ 
				$finalPrice = 220000;
			}else if($sumTotalPrice > 30000000 && $sumTotalPrice <= 50000000){
				$finalPrice = 1100000;
				
			}else if($sumTotalPrice > 20000000 && $sumTotalPrice <= 30000000){
				$finalPrice = 2200000;
			}else if($sumTotalPrice <= 20000000){
				$finalPrice = 3300000;
			}
		}
	
?>
<tr align='center'>
<td><?=$charge_info[userName]?>(<?=$charge_info[uidx]?>)</td>
<td><?=$charge_info[userNickname]?></td>
<td><?=$charge_info[userId]?></td>
<td><?=$charge_info[gradeLevel]?></td>
<td><?=number_format($sumTotalPrice)?></td>

<td><font color='red'><?=number_format($finalPrice)?></td>
</tr>
<?php
	//���⿡ ���� ���
}	



?>