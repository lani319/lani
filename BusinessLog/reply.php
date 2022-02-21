<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



if($mode == "")
{
	$mode = "reg";
}
else if($mode == "mod")
{
	$sql = "select * from Business_log_reply where idx=$idx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	$contents = $rs[contents];
}
?>
<script type="text/javascript">
function goSubmit(mode)
{
	var f = document.formReply;
	if(f.txtReply.value != "")
	{
		
		f.mode.value = mode;		
		f.submit();
		return;
	}
	else
	{
		alert('댓글을 입력 해 주세요');
		f.txtReply.focus();
		return;
	}
	
}

function goDel(idx)
{
	var f = document.formReply;
	f.delidx.value = idx;
	f.mode.value = "del";
	f.submit();
}
function goMod(idx)
{
	location.href = 'reply.php?parentIdx=<?=$parentIdx?>&mode=mod&idx='+idx;
}

function goModify(mode,idx)
{
	var f = document.formReply;
	f.mode.value = mode;
	f.delidx.value = idx;
	f.submit();
	return;
}
</script>
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<form name="formReply" method="POST" action="./reply_writeOk.php" target="invFrame">
<table cellpadding="0" cellspacing="0" border="0" width="95%" >
<?php
$sql = "select A.userName,B.* from Member A inner join Business_log_reply B on A.idx = B.writer where parentIdx=$parentIdx order by idx desc";
$tmpRs = mysql_query($sql);
$memIdx = $_COOKIE["_CKE_USER_UID"];
while($rs = mysql_fetch_array($tmpRs))
{
	if($rs[idx] != "")
	{
		if($memIdx == $rs[writer])
		{
			$strMsg = "<img src='/naraboard/skin/test_skin/image/ico_wordlist.gif' onClick='goDel($rs[idx]);' style='cursor:hand;'>";
			$strMsg = $strMsg."&nbsp;<img src='/naraboard/skin/test_skin/image/ico_wordlist_edit.gif' onClick='goMod($rs[idx]);' style='cursor:hand;'>";
		}
		
		echo "<tr><td width='150px' align='center'>$rs[userName]</td><td align='left'>$rs[contents]</td><td width='150px' align='center'>$rs[regDate]&nbsp;$strMsg</td></tr>";
		echo "<tr><td colspan='3' height='3px'></td></tr>";
		echo "<tr><td background='img/bottom.gif' colspan='3'></td></tr>";
		echo "<tr><td colspan='3' height='3px'></td></tr>";
	}
	else 
	{
		echo "<tr><td colspan='3' align='center'>*등록 된 댓글이 없습니다.</td></td>";
		echo "<tr><td background='img/bottom.gif' colspan='3'></td></tr>";
		echo "<tr><td colspan='3' height='10px'></td></tr>";
		
	}
}

?>
<tr>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="95%" >
<tr>
<td width="150px" align="center"><?=$_COOKIE["_CKE_USER_NAME"]?></td>
<td>
<textarea name="txtReply" rows="3" cols="80" style="border-style:thin;border-type:solid;border-color:AAAAAA;border-width:1px;"><?=$contents?></textarea>
</td>
<td align="center">
<?php
if($mode=="reg")
{
?>
<img src="/naraboard/skin/test_skin/image/btn_comment.gif" onclick="goSubmit('<?=$mode?>')" style="cursor:hand;">
<?php
}
else 
{
?>
<img src="/naraboard/skin/test_skin/image/btn_comment.gif" onclick="goModify('<?=$mode?>','<?=$idx?>')" style="cursor:hand;">	
<?php
}
?>
</td>
</tr>
</table>
<input type="hidden" name="parentIdx" value="<?=$parentIdx?>">
<input type="hidden" name="mode" value="<?=$mode?>">
<input type="hidden" name="delidx" value="0">

<iframe name="invFrame" width="600" height="0"></iframe>
</form>



<table>
<tr>

</tr>
</table>

