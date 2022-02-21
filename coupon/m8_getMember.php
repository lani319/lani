<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$param = $memInfo;

//echo $param;

$sql = "select idx,userID,userName,userNickname,mobile from Member where (userID = '$param' or userName = '$param' or userNickname like '%$param%') ";
//echo $sql;
$tmpRs = mysql_query($sql);

$cnt = 1;
?>
<html>
<head>
<script type="text/javascript">
function getMemInfo(idx)
{
	opener.form1.txtMemIdx.value = idx;
	this.self.close();
}
</script>
</head>
<body>
<table cellpadding="0" cellspacing="0" width="600px">
<tr bgcolor="AAAAAA">
<td style="color:FFFFFF">순번</td>
<td style="color:FFFFFF">아이디</td>
<td style="color:FFFFFF">이름</td>
<td style="color:FFFFFF">닉네임</td>
<td style="color:FFFFFF">연락처</td>
<td></td>
</tr>
<tr><td colspan="10" height="1" bgcolor="AAAAAA"></td></tr>
<?php
while ($rs = mysql_fetch_array($tmpRs)) 
{
?>
<tr>
<td><?=$cnt++?></td>
<td><?=$rs["userID"]?></td>
<td><?=$rs["userName"]?></td>
<td><?=$rs["userNickname"]?></td>
<td><?=$rs["mobile"]?></td>
<td><input type="button" value="SELECT" onclick="getMemInfo(<?=$rs[idx]?>);"></td>
</tr>	
<tr><td colspan="10" height="1" bgcolor="AAAAAA"></td></tr>
<?php
}
?>
</table>
</body>
</html>