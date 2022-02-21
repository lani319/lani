<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



$userNick = $_COOKIE["_CKE_USER_NAME"];




?>

<script type="text/javascript">
function goWrite(userNick)
{
	location.href = './businesslog.php?mode=reg&userNickname='+userNick;
}
</script>


<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0" >
<tr align="center">
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">작성자</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">제목</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">등록일</td>
</tr>

<?php

$addwhere = "";
if($idx!="")
{
	$addwhere = " where A.writer = $idx";
}
$orderBy = " order by idx desc";

/* 총 게시물수 구하기 */
	if(!$page){ $page = 1 ; }
	$pagePerNum = 20; // 한 페이지당 레코드 갯수
	$indexPerPage = 10; // 한페이지에 표시될 인덱스 갯수
	$searchSet ="&mode=$mode&idx=$idx";
	$optionSet ="";
	$pageURL = "";
	
	
	$query = "select count(idx) as num from Business_log A $addwhere";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$totalCount = $row[num];
	$totalPage = ceil($totalCount/$pagePerNum) ;
	$start_p = $pagePerNum*($page-1);
	$repImgPath = "/naraboard/skin/test_skin/image/ico_wordlist.gif";

	if($totalCount==0)
	{
		echo "<tr><td colspan='4' align='center' height='150'>등록 된 업무일지가 없습니다.</td></tr>";
		
	}
	else 
	{

		$sql = "select A.idx,B.writer,A.writer as writerIdx,A.subject,Left(A.regDate,10) as regDate,A.targetDate from Business_log A inner join Business_log_level B on A.writer = B.idx $addwhere group by A.subject $orderBy limit $start_p, $pagePerNum";
		
		$tmpRs = mysql_query($sql);
		while($rs = mysql_fetch_array($tmpRs))
		{
			$subject = "<a href='businesslog.php?mode=view&idx=".$rs[writerIdx]."&targetDate=".$rs[targetDate]."'>".$rs[subject]."</a>";
			
			?>
			<tr><td colspan="4" height="1" background="img/bottom.gif"></td></tr>
			<tr align="center" height = "25px">
			<td><?=$rs[writer]?></td>
			<td><?=$subject?></td>
			<td><?=$rs[regDate]?></td>
			</tr>
			<?php
		}
	}
?>
</table>


