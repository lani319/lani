<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

//1, 11,12,13,14,15

$PageSize = 1000;

if($nextNum == "")
{
	$startNum = 0;
}
else 
{
	$startNum = $nextNum;
}

$nextNum = $startNum + $PageSize;

//1번 문항
$strTbl = "q1";
//SELECT q1 FROM 2011Survey WHERE q1 NOT IN (1,2,3,4)  GROUP BY q1 ORDER BY idx DESC LIMIT 0,50;
$sql1 = "select $strTbl from 2011Survey WHERE q1 NOT IN (1,2,3,4) GROUP BY q1 ORDER BY idx DESC limit $startNum,$PageSize";

//echo $sql1;
//echo "<br>";


//11번 문항
$strTbl = "q11";
$sql11 = "select $strTbl from 2011Survey WHERE q11 NOT IN (1,2,3,4) GROUP BY q11 ORDER BY idx DESC limit $startNum,$PageSize";

//echo $sql11;
//echo "<br>";


//12번 문항
$strTbl = "q12";
$sql12 = "select $strTbl from 2011Survey WHERE q12 NOT IN (1,2,3,4) GROUP BY q12 ORDER BY idx DESC limit $startNum,$PageSize";

//echo $sql12;
//echo "<br>";

//13번 문항
$strTbl = "q13";
$sql13 = "select $strTbl from 2011Survey WHERE q13 NOT IN (1,2,3,4,5,6,8) GROUP BY q13 ORDER BY idx DESC limit $startNum,$PageSize";

//echo $sql13;
//echo "<br>";

//14번 문항
$strTbl = "q14";
$sql14 = "select $strTbl from 2011Survey WHERE q14 NOT IN (1,2,3,4,6) GROUP BY q14 ORDER BY idx DESC limit $startNum,$PageSize";

//echo $sql14;
//echo "<br>";


//15번 문항
//SELECT q15 FROM 2011Survey WHERE q15 <> '' GROUP BY q15 ORDER BY idx DESC LIMIT 0,50;
$sql15 = "SELECT A.userId,A.userName,A.userMobile,A.q15,B.userNickname FROM Member B INNER JOIN 2011Survey A ON B.userId = A.userId

WHERE A.q15 <> '' GROUP BY A.q15 ORDER BY A.idx DESC LIMIT 0,1000";



//echo "<br>";
//echo $sql15;
//echo "<br>";
?>
<link rel="stylesheet" type="text/css" href="/css/502style.css" />

<table cellpadding="0" cellspacing="0" width="900px" border="1">
<tr bgcolor="#FFFFCC">
<td colspan="2">1번에 대한 주관식 답변 [가입경로]
</td>
</tr>
<?php
$tmpRs = mysql_query($sql1);
$num = startNum+1;
if(mysql_num_rows($tmpRs) == 0)
{
	echo "<tr><td colspan='2' align='center'>결과가 없습니다</td></tr>";
}
else 
{
	while($rs = mysql_fetch_array($tmpRs))
	{
	?>
	<tr>
	<td><?=$num++?></td>
	<td><?=$rs[q1]?></td>
	</tr>
	<tr>
	<td colspan="2" height="1" bgcolor="Gray"></td>
	</tr>
	<?php
	}
}
?>

</table>

<br>

<table cellpadding="0" cellspacing="0" width="900px" border="1">
<tr bgcolor="#FFFFCC">
<td colspan="2">11번에 대한 주관식 답변[홈페이지에서 제공하는 유무료 주식정보 서비스 내용에 대해 어떻게 생각하십니까]</td>
</tr>
<?php
$tmpRs = mysql_query($sql11);
$num = startNum+1;
//echo mysql_num_rows($tmpRs);

if(mysql_num_rows($tmpRs) == 0)
{
	echo "<tr><td colspan='2' align='center'>결과가 없습니다</td></tr>";
}
else 
{
	while($rs = mysql_fetch_array($tmpRs))
	{
	?>
	<tr>
	<td><?=$num++?></td>
	<td><?=$rs[q11]?></td>
	</tr>
	<tr>
	<td colspan="2" height="1" bgcolor="Gray"></td>
	</tr>
	<?php
	}
}
?>
</table>


<br>

<table cellpadding="0" cellspacing="0" width="900px" border="1">
<tr bgcolor="#FFFFCC">
<td colspan="2">12번에 대한 주관식 답변 [사이트의 메뉴구성이나 전체적인 배치는 쉽고 편리하게 구성 되어 있습니까]</td>
</tr>
<?php
$tmpRs = mysql_query($sql12);
$num = startNum+1;
if(mysql_num_rows($tmpRs) == 0)
{
	echo "<tr><td colspan='2' align='center'>결과가 없습니다</td></tr>";
}
else 
{
	while($rs = mysql_fetch_array($tmpRs))
	{
	?>
	<tr>
	<td><?=$num++?></td>
	<td><?=$rs[q12]?></td>
	</tr>
	<tr>
	<td colspan="2" height="1" bgcolor="Gray"></td>
	</tr>
	<?php
	}
}
?>
</table>


<br>

<table cellpadding="0" cellspacing="0" width="900px" border="1">
<tr bgcolor="#FFFFCC">
<td colspan="2">13번에 대한 주관식 답변 [동시에 이용중인 타 사이트]</td>
</tr>
<?php
$tmpRs = mysql_query($sql13);
$num = startNum+1;
if(mysql_num_rows($tmpRs) == 0)
{
	echo "<tr><td colspan='2' align='center'>결과가 없습니다</td></tr>";
}
else 
{
	while($rs = mysql_fetch_array($tmpRs))
	{
	?>
	<tr>
	<td><?=$num++?></td>
	<td><?=$rs[q13]?></td>
	</tr>
	<tr>
	<td colspan="2" height="1" bgcolor="Gray"></td>
	</tr>
	<?php
	}
}
?>
</table>


<br>

<table cellpadding="0" cellspacing="0" width="900px" border="1">
<tr bgcolor="#FFFFCC">
<td colspan="2">14번에 대한 주관식 답변 [이용중인 타 사이트에 대한 만족도]</td>
</tr>
<?php
$tmpRs = mysql_query($sql14);
$num = startNum+1;
if(mysql_num_rows($tmpRs) == 0)
{
	echo "<tr><td colspan='2' align='center'>결과가 없습니다</td></tr>";
}
else 
{
	while($rs = mysql_fetch_array($tmpRs))
	{
	?>
	<tr>
	<td><?=$num++?></td>
	<td><?=$rs[q14]?></td>
	</tr>
	<tr>
	<td colspan="2" height="1" bgcolor="Gray"></td>
	</tr>
	<?php
	}
}
?>
</table>


<br>

<?php
$userID = $_COOKIE["_CKE_USER_ID"];
//echo $userID;

if($userID == 'ayh319' || $userID == 'tndls5' || $userID == 'copgaz' || $userID == 'jinsuk930' || $userID == 'ivyiny' || $userID == 'mc2452' || $userID == 'ar48621')
{
?>
	<table cellpadding="0" cellspacing="0" width="900px" border="1">
	<tr bgcolor="#FFFFCC">
	<td colspan="4">15번에 대한 주관식 답변 [502.co.kr에 대해 바라는점]</td>
	</tr>
	<?php
	$tmpRs = mysql_query($sql15);
	$num = startNum+1;
	if(mysql_num_rows($tmpRs) == 0)
	{
		echo "<tr><td colspan='2' align='center'>결과가 없습니다</td></tr>";
	}
	else 
	{
		while($rs = mysql_fetch_array($tmpRs))
		{
		?>
		<tr>
		<td align="center"><?=$num++?></td>
		<td align="center"><?=$rs[userNickname]?><br>(<?=$rs[userId]?>)</td> <!-- 이름/필명 -->
		<td width="100" align="center"><?=$rs[userMobile]?></td> <!-- 연락처 -->		
		<td><?=$rs[q15]?></td>
		</tr>
		<?php
		}
	}
	?>
	</table>

<?php
}
?>

