<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
�˻� ����� �����ִ� ���
*/

//���������� ���� ��������
$admin_level = $_COOKIE['_CKE_USER_LEVEL'];



if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("�α����� �̿��� �����մϴ�.");
	echo "<script> window.close(); </script>";
	exit();
}

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$code = $searchKeyword; //�����ڵ�
$memIdx = $_COOKIE["_CKE_USER_UID"]; //ȸ�� �ε���
$searchIP = $_SERVER['REMOTE_ADDR']; //ȸ�� ���� ������
//$freeFlag = "F"; //�������� ����, �⺻���� F�� ����.
$remainCnt = 0; //�ܿ� �˻��Ǽ�
$sumPrice = 0; //ȸ���� ���� �����ݾ�
$value = 0; //�����ְ�

/* 
//�ش� ������ �������� �����̸� �׳� ����
$sql = "select freeFlag from jongmokValue where code = '$searchKeyword'";
$tmpRs = mysql_query($sql);
$rs = mysql_fetch_array($tmpRs);
if($rs['freeFlag']=="T") {
	$freeFlag = "T";
}


//���⿡�� ���� �����̸鼭 �����ڰ� �ƴϸ� �ܿ� �˻��Ǽ��� �ִ��� �˻�, �ܰ��� ������ ��� �����ش�.
//�ܰ��� ������ ���â �����ְ� ����������� �Ѿ��.
if($freeFlag=="F" && !$admin_level) { 	
	//�����ݾ� ��������
	$sql = "select sum(price) as price from jongmokValueChargeInfo where memIdx = $memIdx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$sumPrice = $rs[0];
	
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx = $memIdx and freeFlag = 'F' "; //�����ݾ� ���� ����˻� �����丮 db���� �Ǽ� x 11000���� �ؼ� ���Ѵ�. 
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$remainCnt = ($sumPrice - $rs[0]*11000)/11000;
	
	if ($remainCnt < 1){
		echo "<script>alert('�����ݾ��� �����մϴ�. ���� �� �̿��� �ּ���');location.href='pay.php';</script>";
		exit;
		}

}
*/		



//Ű���带 �̿��ؼ� �����ְ��� �˻��Ѵ�. 
$sql = "select * from jongmokValue where code = '$searchKeyword'  ";
$tmpRs = mysql_query($sql);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/table02.css">

<script type="text/javascript">
function remainCntReload()
{		
	parent.frmright.location.reload(); //main01	
}

function goSearch(name)
{
	parent.parent.topFrame.document.getElementById("searchKeyword").value = name;
	parent.parent.topFrame.goSearch();
}
</script>
</head>
<body  leftmargin="50px">
<img src="img/title03.gif">
<table border="0" cellpadding="0" cellspacing="0" width="650px" class="table01">
<tr class="thSearch01">
<td width="150px" height="35px" class="white">�����</td>
<td width="100px" class="white">�����ڵ�</td>
<td width="50px" class="white">����</td>
<td class="white">�����ְ�</td>
<td class="white">�����ְ� ������</td>
</tr>
<?php
	while($rs = mysql_fetch_array($tmpRs))
	{
	
	$updateDate = $rs['updateDate'];
	$value = round( $rs["value"]+($rs["value"]*$rs["adjustValue"]),-1); //���� ���� �����ְ�
?>
	<tr align="center">
	<td height="80px"><?=$rs["name"]?></td>
	<td><?=$rs["code"]?></td>
	<td><?=$rs["type"]?></td>
	<td style="color:#FF4500;size:20px;font-weight:bold;"><?=number_format($value)?>��</td>
	<td><?=$rs['updateDate']?></td>
	</tr>			
<?php
	}
?>
<tr><td  colspan="10" ><img src="img/notice_result.gif"></td></tr>
</table>
<br>
<br>
<br>

<?php
//�˻������� DB�� �����ϴ� ���,HISTORY
//db:jongmokValueHistory
/*
idx
code
memIdx
searchDate
searchIP
searchKeyword = searchKeywordOld
*/

if($sameFlag <> 1)	//
{
	//�ߺ� ������ �������� ���� ��¥�� �ش� ������ �˻��� ������ �ִ��� ���캻��. 
	$sql = "select count(idx) as cnt from jongmokValueHistory where memIdx='$memIdx' and code='$code' and date(searchDate)=date(now())";
	//echo $sql;
	//echo "<br>";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[cnt]==0){		
		
		//������ �˻��ߴ� ������ ������ ���� ������ ���� �������� �ٲ۴�.
		$sql = "update jongmokValueHistory set newFlag=1 where code='$code' and memIdx = '$memIdx'";
		mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
		
		$sql = "insert into jongmokValueHistory(code,memIdx,searchDate,searchIP,searchKeyword,freeFlag,updateDate,value) values('$code','$memIdx',now(),'$searchIP','$searchKeywordOld','$freeFlag','$updateDate',$value)";
		//echo $sql;
		mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
		//echo "���� ����";
		
		if($admin_level != 0 && $admin_level != 4) // �����ڳ� �������� �ƴϸ� ����, ������ �۾� �� ���� ī��Ʈ �����ϸ� �ȵǴϱ� �̰͵� if ó��
		{
			//���� �˻� ī��Ʈ ����
			$sql = "update jongmokValue set cnt=cnt+1 where code = '$code'";
			mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
			//echo $sql;
			//echo "<br><br>���� ����";
			
			if($freeFlag=="F")
			{
				//Member ���̺����� �ܿ� ����˻��Ǽ� -1
				$sql = "update Member set jongmokCnt = jongmokCnt-1 where idx = '$memIdx'";
				mysql_query($sql) or die("ERROR. �������ͷ� �����ּ���");
			}
		}
	}
}
	
//���⿡ ���� �˻��ߴ� ���� �ֱ� ��¥ �������� Top10�� �����´�. 
$sql = "
SELECT A.name,A.updateDate as recentUpdateDate,B.code,date(B.searchDate) as searchDate,B.updateDate as lastUpdateDate,B.value as historyValue,A.value as currentValue,A.adjustValue,B.freeFlag,B.newFlag

FROM jongmokValue A INNER JOIN jongmokValueHistory B ON A.code = B.code

WHERE B.memIdx=$memIdx order by B.idx desc limit 0,10;
";


$tmpRs = mysql_query($sql);	
?>
<img src="img/title04.gif">
		<table border="0" cellpadding="0" cellspacing="0" width="650px" class="table01">	
		<tr class="thSearch01">
			<td height="30px"class="white">��ȸ��¥</td>
			<td class="white">����</td>
			<td class="white">��ȸ��� <br><br>�����ְ�</td>
			<td  class="white">�����ְ�  <br><br> ���ſ���</td>
		</tr>
	<?php	
	if(mysql_num_rows($tmpRs)>0)
	{
		$tdHeight = 150 / mysql_num_rows($tmpRs);

		if($tdHeight < 50)
		{
			$tdHeight = 20;
		}	
			
		$num = 0;
		
		while($rs = mysql_fetch_array($tmpRs))
		{
			if($num%2 == 0){
				$class = "odd";
			}else {
				$class="";
			}
			
			
			$value = round( $rs["currentValue"]+($rs["currentValue"]*$rs["adjustValue"]),-1 ); //���� ���� �����ְ�
			
			//��ȸ��� �����ְ��� ���� �����ְ� ����
			$gap = 	($value-$rs['historyValue'])/($rs['historyValue'])*100;
			
				if( ($gap  > 12.5  || $gap < -12.5)   && $rs['newFlag']== 0) //���� ���̰� +- 12.5% �̻� ���̳��� �� �����̸� ���� �� ������ �����Ѵ�.
				{
					$gapFlag = "T";
				}else {
					$gapFlag = "F";
				}
				//$gapFlag = "T";
				
				//echo $rs[name]."  ".$gap." ".$rs[lastUpdateDate]." ".$rs[recentUpdateDate]."   ".$value."   ".$rs[historyValue];
		?>
			<tr class="<?=$class?>" onclick="goSearch('<?=$rs[name]?>')" style="cursor:hand">
			<th height="<?=$tdHeight?>"><?=$rs['searchDate']?></th>
			<th><?php if($gapFlag=="T"){echo "<img src='img/new.gif'>";}?>&nbsp;&nbsp;<b><?=$rs['name']?>
			<?php
			/*
			if($rs['freeFlag']=='T'){
				echo "<font color='blue' size=2>(��)</font>";
			}else {
				echo "<font color='red' size=2>(��)</font>";
			}
			*/
			?>
			</b></th>
			<th><?=number_format($rs['historyValue'])?>��</th>
			<th>
			<?php
				if($gapFlag=="T"){
					echo "����";
				}else {
					echo "����";
				}
				?>
			</th>			
			</tr>					
		<?php
		$num++;
		}
		?>
		<tr><td colspan="5"><img src="img/notice_recharge.gif"></td></tr>
		</table>		
		
	<?php	
	}
	else { //�ֱ� �˻��� ������ ������
	?>
		<tr>
			<th height="100px" colspan="10"><font size="4" >�ֱ� ��ȸ ������ �����ϴ�.</font>  </th>
		</tr>
		</table>
	<?php
	}
	

?>
<script>
remainCntReload();
</script>
</body>
</html>