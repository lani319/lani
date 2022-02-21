<script type="text/javascript">
function goSubmit()
{
	var f = document.formReply;
	if(f.txtReply.value != "")
	{
		f.formReply.submit();
		return;
	}
	else
	{
		alert('댓글을 입력 해 주세요');
		f.txtReply.focus();
		return;
	}
}
</script>
<form name="formReply" method="POST" action="./reply_writeOk.php" target="invFrame">
<table cellpadding="0" cellspacing="0" border="0" width="100%" >
<tr>
<td><?=$_COOKIE["_CKE_USER_NAME"]?></td>
<td>
<textarea name="txtReply" rows="3" cols="50"></textarea>
</td>
<td>
<img src="/naraboard/skin/test_skin/image/btn_comment.gif" onclick="goSubmit()" style="cursor:hand;">
</td>
</tr>
</table>
<input type="hidden" name="parentIdx" value="<?=$idx?>">
<input type="hidden" name="mode" value="<?=$mode?>">
</form>

<iframe name="invFrame" width="600" height="400"></iframe>