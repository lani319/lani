<?php
//chargeInfo		//�����̾� (������)
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$sql = "SELECT A.userId,A.userName,A.userNickname,A.mobile,A.phone,A.userEmail,A.signdate,A.login_time_check,
B.startdate,B.enddate,B.paydate,B.expert_idx,B.price
FROM  Member A INNER JOIN chargeInfo B ON A.idx = B.uidx
WHERE B.price > 0
ORDER BY B.idx DESC
LIMIT 0,30000
";

$tmpRs = mysql_query($sql);
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">

<?php
echo "<tr>";
	
	echo "<td><td>���̵�</td>";
	
	echo "<td>�̸�</td>";
	
	echo "<td>�ʸ�</td>";
	
	echo "<td>�ڵ���</td>";
	
	echo "<td>��ȭ��ȣ</td>";
	
	echo "<td>�̸���</td>";
	
	echo "<td>������</td>";
	
	echo "<td>�ֱ�������</td>";
	
	echo "<td>������</td>";
	
	echo "<td>������</td>";	
	
	echo "<td>������</td>";
	
	echo "<td>������ idx</td>";
	
	echo "<td>����</td>";
	
	echo "</tr>";
	
while($rs = mysql_fetch_array($tmpRs))
{
	echo "<tr>";
	
	echo "<td><td>$rs[userId]</td>";
	
	echo "<td>$rs[userName]</td>";
	
	echo "<td>$rs[userNickname]</td>";
	
	echo "<td>$rs[mobile]</td>";
	
	echo "<td>$rs[phone]</td>";
	
	echo "<td>$rs[userEmail]</td>";
	
	echo "<td>$rs[signdate]</td>";
	
	echo "<td>$rs[login_time_check]</td>";
	
	echo "<td>".date('Y-m-d',$rs[startdate])."</td>";
	
	echo "<td>".date('Y-m-d',$rs[enddate])."</td>";	
	
	echo "<td>$rs[paydate]</td>";
	
	echo "<td>$rs[expert_idx]</td>";
	
	echo "<td>$rs[price]</td>";
	
	echo "</tr>";
}

?>