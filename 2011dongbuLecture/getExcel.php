<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



 $today = date("Y-m-d").'dongbuList';
 header( "Content-type: application/vnd.ms-excel" ); 
 header( "Content-Disposition: attachment; filename=". $today. ".xls"); 
 header( "Content-Description: PHP4 Generated Data" ); 
?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr"> 
<html>
<head>
<title></title>
</head>
<body>
 
<table cellpadding="0" cellspacing="0" border="0" width="900" border="1">
<tr><td colspan="10" height="5px" align="left"><b>ȸ��</b></td></tr>
<tr align="center"><!--  ȸ�� -->
	<td bgcolor="gray" style="color:FFFFFF;">����</td>
	<td bgcolor="gray" style="color:FFFFFF;">�̸�</td>
	<td bgcolor="gray" style="color:FFFFFF;">�ʸ�</td>
	<td bgcolor="gray" style="color:FFFFFF;">���̵�</td>
	<td bgcolor="gray" style="color:FFFFFF;">����ó</td>
	<td bgcolor="gray" style="color:FFFFFF;">��û��</td>
	<td bgcolor="gray" style="color:FFFFFF;">��������</td>	
</tr>
<?php
$query = "select A.userName,A.userNickname,A.mobile,A.userId,B.regDate from Member A inner join 2011dongbuLecture B on A.userId = B.memID where B.regDate > '2011-07-01 00:00:00' order by B.regDate ASC";
$tmpRs = mysql_query($query);
$cnt = 1;
while($rs = mysql_fetch_array($tmpRs))
{
	$mName = $rs["userName"];
	$mNickName = $rs["userNickname"];
	$mMobile = $rs["mobile"];
	$mId = $rs["userId"];
	$mRegDate = $rs["regDate"];
?>
<tr align="center"><!--  ȸ�� -->
	<td><?=$cnt?></td>
	<td><?=$mName?></td>
	<td><?=$mNickName?></td>
	<td><?=$mId?></td>
	<td><?=$mMobile?></td>
	<td><?=$mRegDate?></td>
	<td></td>	
</tr>

<?php
	$cnt++;
}
?>
</table>

</body>
</html>

