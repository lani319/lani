<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
?>
<script type="text/javascript">
function goWrite(flag)
{
	location.href = './notice.php?mode=reg';
}
</script>

<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
<tr align="center">
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;" height="25px">�ۼ���</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">����</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">�����</td>
</tr>

<?php



	$addwhere = " where flag = 3";

$orderBy = " order by idx desc";

/* �� �Խù��� ���ϱ� */
	if(!$page){ $page = 1 ; }
	$pagePerNum = 20; // �� �������� ���ڵ� ����
	$indexPerPage = 10; // ���������� ǥ�õ� �ε��� ����
	$searchSet ="&mode=$mode&idx=$idx";
	$optionSet ="";
	$pageURL = "";
	
	
	$query = "select count(idx) as num from Business_log $addwhere";	
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$totalCount = $row[num];	
	$totalPage = ceil($totalCount/$pagePerNum) ;
	$start_p = $pagePerNum*($page-1);
	$repImgPath = "/naraboard/skin/test_skin/image/ico_wordlist.gif";

	if($totalCount==0)
	{
		echo "<tr><td colspan='4' align='center' height='150'>��� �� ���������� �����ϴ�.</td></tr>";
		
	}
	else 
	{

		$sql = "select * from Business_log $addwhere $orderBy limit $start_p, $pagePerNum";
		$tmpRs = mysql_query($sql);
		while($rs = mysql_fetch_array($tmpRs))
		{
			$subject = "<a href='./businessnotice.php?mode=view&idx=$rs[idx]'>".$rs[subject]."</a>";			
			?>
			<tr><td colspan="4" height="1" background="img/bottom.gif"></td></tr>
			<tr align="center" height = "25px">
			<td>������</td>
			<td><?=$subject?></td>
			<td><?=$rs[regDate]?></td>
			</tr>
			<?php
		}
	}
?>
<tr><td colspan="4" height="1" bgcolor="AAAAAA"></td></tr>
<tr><td colspan="4" height="1" bgcolor="AAAAAA"></td></tr>


<tr>
<td colspan="4" align="right">
<img src="img/submit.png" border="0" onclick="goWrite();" style="cursor:hand">
</td>
</tr>
<tr><td colspan="4" height="15" bgcolor="FFFFFF"></td></tr>
<tr><td colspan="4" align="center">
<? if($totalCount) pagSet('page',$page,$totalPage,$indexPerPage,$pageURL,$searchSet,$optionSet); ?>
</td></tr>
</table>


