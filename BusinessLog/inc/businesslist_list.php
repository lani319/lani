<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$userNick = $_COOKIE["_CKE_USER_NICK_NAME"];

?>

<script type="text/javascript">
function goWrite(flag)
{
	location.href = './businesslist.php?mode=reg&flag='+flag;
}
</script>

<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
<tr align="center">
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">�����</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">����</td>

</tr>

<?php

$addwhere = " where flag = '$flag'";
if($idx!="")
{
	$addwhere = " where A.charge = $idx and flag='$flag'";
}
$orderBy = " order by B.idx ASC";

/* �� �Խù��� ���ϱ� */
	if(!$page){ $page = 1 ; }
	$pagePerNum = 20; // �� �������� ���ڵ� ����
	$indexPerPage = 10; // ���������� ǥ�õ� �ε��� ����
	$searchSet ="&mode=$mode&idx=$idx";
	$optionSet ="";
	$pageURL = "";
	
	
	$query = "select count(idx) as num from Business_list A $addwhere";
	
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$totalCount = $row[num];
	$totalPage = ceil($totalCount/$pagePerNum) ;
	$start_p = $pagePerNum*($page-1);
	$repImgPath = "/naraboard/skin/test_skin/image/ico_wordlist.gif";

	if($totalCount==0)
	{
		echo "<tr><td colspan='4' align='center' height='150'>��� �� �������ð� �����ϴ�.</td></tr>";
		
	}
	else 
	{
		if($flag!="B")
		{
		//���ξ�����
		$sql = "select Left(A.contents,30) as contents,B.writer,B.idx from Business_list A inner join Business_log_level B on A.charge = B.idx  $addwhere  $orderBy limit $start_p, $pagePerNum";
		}
		else if($flag == 'B')
		{
		//���������
		$sql = "select contents,'502' as writer,writer as idx from Business_list where flag='B' order by idx desc";
			
		}
		else if($flag == "N") //���������̸�
		{
			$sql = "select Left(A.contents,30) as contents,B.writer,B.idx,B.subject from Business_list A inner join Business_log_level B on A.charge = B.idx  $addwhere  $orderBy limit $start_p, $pagePerNum";
		}
		//echo $sql;
		
		$tmpRs = mysql_query($sql);
		while($rs = mysql_fetch_array($tmpRs))
		{
			//$subject = "<a href='businesslog.php?mode=view&idx=".$rs[writerIdx]."&regDate=".$rs[regDate]."'>".$rs[subject]."</a>";
			
			?>
			<tr><td colspan="4" height="1" background="img/bottom.gif"></td></tr>
			<tr align="center" height = "25px">
			<td><?=$rs[writer]?></td>
			<td><a href="./businesslist.php?mode=mod&idx=<?=$rs[idx]?>&flag=<?=$flag?>"><?=$rs[writer]?> ��������</a></td>			
			</tr>
			<?php
		}
	}
?>

<tr><td colspan="4" align="center" height="1px" bgcolor="AAAAAA"></td></tr>
<tr><td colspan="4" align="center" height="1px" bgcolor="AAAAAA"></td></tr>

<tr><td colspan="4" align="center" height="300px"></td></tr>
<tr>
<td colspan="4" align="right">
<img src="img/submit.png" border="0" onclick="goWrite('<?=$flag?>');" style="cursor:hand">
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td colspan="4" align="center">
<? if($totalCount) pagSet('page',$page,$totalPage,$indexPerPage,$pageURL,$searchSet,$optionSet); ?>
</td>
</tr>
</table>


