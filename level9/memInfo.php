<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$sql = "select idx,userID,userName,userNickname,mobile from Member where level = 9";

$tmpRs = mysql_query($sql);


if($_COOKIE["_CKE_USER_ID"] == "ayh319" || $_COOKIE["_CKE_USER_ID"] == "tnldk6")
{
	
}
else
{
	echo "허가 된 관리자만 볼 수 있습니다.";
	exit;
}

%>
<link rel="stylesheet" type="text/css" href="/css/502style.css">

<style type="text/css">
.t1
{
	font-size:15px;
	font-weight:bold;
	background-color:AAAAAA;
	color : FFFFFF;
}

.t2
{
	font-size:15px;	
	background-color:FFFFFF;
	color : 000000;
}

.b1
{
	font-size:15px;		
	color : 000000;
}
</style>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h1>*LEVEL 9 회원 목록</h1>

<table width="700px" cellpadding="0" cellspacing="0">
<tr align="center">
<td class="t1">회원번호</td>
<td class="t1">아이디</td>
<td class="t1">이름</td>
<td class="t1">필명</td>
<td class="t1">연락처</td>
<td class="t1"></td>
</tr>

<?php
while($rs = mysql_fetch_array($tmpRs))
{
?>

<tr align="center">
<td class="t2"><?=$rs[idx]?></td>
<td class="t2"><?=$rs[userID]?></td>
<td class="t2"><?=$rs[userName]?></td>
<td class="t2"><?=$rs[userNickname]?></td>
<td class="t2"><?=$rs[mobile]?></td>
<td class="t2"><input type="button" value="결제내역" class="b1" id="btn<?=$rs[idx]?>" onclick="getMemInfo(this.id,<?=$rs[idx]?>);"></td>
</tr>
<tr><td colspan="10" height="5"></td></tr>
<?php
}
?>
</table>
<script type="text/javascript">
function getMemInfo(id,idx)
{
	document.getElementById(id).style.color = 'red';
	var param = "level9_memInfo.html?idx="+idx;
	
	var win = window.open(param,'','location=no, directories=no,resizable=no,status=no,toolbar=no,menubar=no, width=800,height=800,left=0, top=0, scrollbars=yes');
}
</script>