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


<table cellpadding="0" cellspacing="0" width="100%" height="100%" border="0">
<tr align="center">
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">작성자</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">제목</td>
<td bgcolor="AAAAAA" style="color:FFFFFF;font-weight:bold;">등록일</td>
</tr>

<?php

$addwhere = "";
if($idx!="")
{
	$addwhere = " where A.writer = $idx and flag in (0,1,2)";
}
else 
{
	$addwhere = " where flag in (0,1,2)";
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

		
		$sql = "select A.idx,B.writer,A.writer as writerIdx,A.subject,Left(A.regDate,10) as regDate,A.targetDate from Business_log A inner join Business_log_level B on A.writer = B.idx $addwhere $orderBy limit $start_p, $pagePerNum";

		$tmpRs = mysql_query($sql);
		while($rs = mysql_fetch_array($tmpRs))
		{
			$sql2 = "select count(idx) as cnt from Business_log_reply where parentIdx=$rs[idx]";
			$tmpRs2 = mysql_query($sql2);
			$rs2 = mysql_fetch_array($tmpRs2);
			$replyCnt = $rs2[cnt];
			
			if($replyCnt>0)
			{
				$subject = "<a href='businesslog.php?mode=view&idx=".$rs[writerIdx]."&targetDate=".$rs[targetDate]."&parentIdx=$rs[idx]'>".$rs[subject]."<font color='red'>  [$replyCnt]</font></a>";
			}
			else 
			{
				$subject = "<a href='businesslog.php?mode=view&idx=".$rs[writerIdx]."&targetDate=".$rs[targetDate]."&parentIdx=$rs[idx]'>".$rs[subject]."</a>";
			}
			
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
<tr><td colspan="4" height="1" bgcolor="AAAAAA"></td></tr>
<tr><td colspan="4" height="1" bgcolor="AAAAAA"></td></tr>
<tr><td colspan="4" height="15" bgcolor="FFFFFF"></td></tr>
<tr><td colspan="4" align="center">
<? if($totalCount) pagSet('page',$page,$totalPage,$indexPerPage,$pageURL,$searchSet,$optionSet); ?>
</td></tr>
<tr>
<td colspan="4" align="right">
*이미지 업로드 가능합니다.<br>
<img src="img/submit.png" border="0" onclick="goWrite('<?=$userNick?>');" style="cursor:hand">
</td>
</tr>
</table>


