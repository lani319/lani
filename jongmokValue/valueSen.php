<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/*
업종별 적정주가
width = 790 최대사이즈
*/
/*
if(!$_COOKIE['_CKE_USER_ID']){
	popupMsg("평택촌놈 적정주가는 로그인후 이용이 가능합니다. 회원가입 후 이용 바랍니다.");
	echo "<script> top.location.href='http://www.502.co.kr/member' </script>";
	exit();
}
*/

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
?>
<html>
<title>평택촌놈 적정주가</title>
<head>
<link rel="stylesheet" type="text/css" href="css/table02.css">
<script type="text/javascript">
function goSearch(name)
{
	parent.parent.topFrame.document.getElementById("searchKeyword").value = name;
	parent.parent.topFrame.goSearch();
}

function window::onload() {
   parent.parent.topFrame.document.getElementById("searchKeyword").value = "";
   parent.parent.topFrame.document.getElementById("searchKeyword").focus();	
      
}

</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr valign="top">
<td width="250px" style="border-color:#FFFFFF">

<div id="intro">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table01">
<caption>KOSPI</caption>

<thead>	
	<tr><th><font color="FFFFFF">종목명</font></th><th><font color="FFFFFF">적정주가</font></th></tr>	
	</thead>
	<tbody>
	<?php
	$sql = "select * from jongmokValue where type='KOSPI' and freeFlag='T' order by idx ASC ";
	$tmpRs = mysql_query($sql);
	while ($rs=mysql_fetch_array($tmpRs)) {
		?>		
		<tr class="odd" align="center"><td height="25px"><b><?=$rs[name]?></b></td><td bgcolor="white"  onmouseover="this.style.color='#FF8c00';" onmouseout="this.style.color='#777777'" style="cursor:hand;"> <b><?=number_format($rs[value])?></b></td></tr>
		<?php
	}
	?>
	</tbody>
		
</table>
</div>





<td style="border-color:#FFFFFF">
<div id="intro">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table01">
<caption>KOSDAQ</caption>
<!--
<font color='red' size="4"><b>Ctrl+F (컨트롤+F)눌러서 종목명 검색하세요</b></font>
-->
<thead>
<tr><th><font color="FFFFFF">종목명</font></th><th><font color="FFFFFF">적정주가</font></th></th>

<!--
<th><font color="FFFFFF">종목명</font></th><th><font color="FFFFFF">적정주가</font></th>
-->

</tr>
</thead>
</div>
<?php
	$sql = "select * from jongmokValue where type='KOSDAQ' and freeFlag='T'  order by idx ASC ";
	$tmpRs = mysql_query($sql);
	$i=1;
	while ($rs=mysql_fetch_array($tmpRs)) {
		if($i%2 == 1){		//나머지가 1이면 줄 바꿈 시작
		echo "<tr class='odd'>";
		}
		?>		
		<td height="25px"><b><?=$rs[name]?></b></td><td bgcolor="white"  onmouseover="this.style.color='#FF8c00';" onmouseout="this.style.color='#777777'" style="cursor:hand;"><b><?=number_format($rs[value])?></</a></td>
		<?php
		/*
		if($i%2 == 0){		//나머지가 0이면 줄 바꿈 끝. (실제 줄 바뀜)
		echo "</tr>";
		}
		$i++;
*/		
	}
	
	?>
	<td></td><td bgcolor="#FFFFFF"></td>
	</tr>
<tr>
<td colspan="10" height="80px" style="color:#000000">
<img src="img/freenotice.gif">
</td>
</tr>		
</table>

</td>


</tr>
</table>
</body>
</html>


