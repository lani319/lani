<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


if(!$_COOKIE["_CKE_USER_ID"])
{
	echo "로그인해!!";
	exit;
}





//$commentMode = $_POST["commentMode"];

if($commentMode == "submit")
{
	$movieIdx = $_POST["movieIdx"];
	
	$sql = "insert into First_edu_comment(userID,movieIdx,comment,regdate) values('".$_COOKIE["_CKE_USER_ID"]."','".$movieIdx."','".$_POST["txtCommnet"]."',now())";
	//echo $sql;
	mysql_query($sql);	
	//exit;
	echo "<script>alert('댓글이 등록 되었습니다.');location.href='edu_comment.php?movieIdx=$movieIdx';</script>";
	
	exit;
}
else if($commentMode == "del")
{
	$sql = "delete from First_edu_comment where idx=$idx";
	mysql_query($sql);	
	echo "<script>alert('댓글이 삭제 되었습니다.');location.href='edu_comment.php';</script>";
}
else 
{
	
	/* 총 게시물수 구하기 */
	if(!$page){ $page = 1 ; }
	$pagePerNum = 20; // 한 페이지당 레코드 갯수
	$indexPerPage = 10; // 한페이지에 표시될 인덱스 갯수
	$searchSet ="&in_mode=$in_mode&year=$year&month=$month&day=$day&service_gubun=$service_gubun";
	$optionSet ="";
	$pageURL = "";
	
	
	
	$query = "select COUNT(idx) as num from First_edu_comment where movieIdx=$movieIdx";
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$totalCount = $row[num];
	$totalPage = ceil($totalCount/$pagePerNum) ;
	$start_p = $pagePerNum*($page-1);
	$repImgPath = "/naraboard/skin/test_skin/image/ico_wordlist.gif";
	
	
?>
<script type="text/javascript">
function delReply(idx)
{
	location.href = "edu_comment.php?commentMode=del&idx="+idx;
}
</script>
<link rel="stylesheet" type="text/css" href="/css/502style.css">

        <table width="813" cellpadding="0" cellspacing="0">
          <tr>
            <td height="6"><img src="/images/vod/txt_top.gif" width="813" height="6"></td>
          </tr>
          <tr>
            <td align="center" background="/images/vod/txt_bg.gif">
            <?php
	$pageSize = 20;
	
	$sql = "select * from First_edu_comment where movieIdx=$movieIdx order by idx desc limit $start_p,$pagePerNum ";
	
	//echo $sql;
	
	$tmpRs = mysql_query($sql);
	while($rs = mysql_fetch_array($tmpRs))
	{
		$userID = $rs[userID];
		$comment = $rs[comment];
		$regdate = $rs[regdate];		
	?>          
             <table width="98%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="18" height="20" align="left"><img src="/images/vod/icon.gif" width="12" height="15"></td>
                <td width="80" align="left"><?=$userID?></td>
                <td>
	             <?=$comment?>
			
                </td>
                <td width="25" align="right">
                <?php
			if($userID == $_COOKIE["_CKE_USER_ID"])
			{
				echo "<img src='/images/vod/btn_x.gif' width='11' height='11' border=0 onClick=delReply($rs[idx]); style='cursor:hand;'>";
			}
			?>
                </td>
                <td width="67" align="right" class="k11"><?=$regdate?></td>
              </tr>             
            </table>
            <?php
	}
	?>
            </td>
          </tr>
          <tr>
            <td height="20" align="center" background="/images/vod/txt_bg.gif">페이징</td>
          </tr>
          <tr>
            <td height="6"><img src="/images/vod/txt_foot.gif" width="813" height="6"></td>
          </tr>
        </table>
	
	
	
<?php
}
?>