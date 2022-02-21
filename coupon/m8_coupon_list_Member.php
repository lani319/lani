<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

if($searchflag == "")
{
	$searchflag = 1;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<LINK HREF="/css/style.css" REL="STYLESHEET" TYPE="TEXT/CSS" />
<script type="text/javascript">
function del()
{
	var f = document.form1;
	var c = document.getElementsByName("chkIdx");
	var len = c.length;
	
	
	
	var t = document.getElementById("txtIdx");
	t.value = "";
	
	for(var i = 0 ; i<len ; i++)
	{
	 	if(c[i].checked)
	 	{
	 		t.value += c[i].value+",";
	 	}
	}
	if(t.value=="")
	{
		alert('삭제 할 쿠폰을 선택 해 주세요');
		return;
	}
	var str = t.value;
	
	t.value = str.substring(0, str.length-1);

	f.submit();
}
</script>

</head>
<body>
<br><br>
<form name="form1" method="POST" action="m8_coupon_list_delOK.php" target="invFrame">
<input type="hidden" name="txtIdx">
<table width="920" cellpadding=0 cellspacing=0 border=0>
<tr>
<td align="left">
<img src="img/delCoupon.gif" style="cursor:hand;" onclick="del()">
</td>
</tr>
</table>

<?php

	
	//전체 발급 쿠폰 확인
	$sql = "SELECT A.idx,A.issueDate,A.usedDate,A.expiredDate,A.memIdx,A.STATUS,B.kind,B.dcValue,B.dcType
	FROM 502Coupon A INNER JOIN 502CouponKind B ON A.kind = B.idx
	INNER JOIN Member C ON A.memIdx = C.idx 
	where A.memIdx=$idx  
	ORDER BY A.idx DESC";	

$tmpRs = mysql_query($sql);
$couponListCount = mysql_num_rows($tmpRs);
$rowCnt  = 1;
?>
<table width="920" cellpadding=0 cellspacing=0 border=0>
<tr><td colspan="20">총 발행 쿠폰 수 : <?=$couponListCount?>매</td></tr>
<tr bgcolor="AAAAAA" align="center">
<td></td>
<td height="25px" style="color:FFFFFF">순번</td>
<td height="25px" style="color:FFFFFF">종류</td>
<td height="25px" style="color:FFFFFF">발행일</td>
<td height="25px" style="color:FFFFFF">만료일</td>
<td height="25px" style="color:FFFFFF">할인율/할인금액</td>
<td height="25px" style="color:FFFFFF">할인구분</td>
<td height="25px" style="color:FFFFFF">쿠폰상태</td>
</tr>
<?php
while ($rs = mysql_fetch_array($tmpRs))
{
	switch ($rs[dcType])		//쿠폰 할인 종류  %로 할인 할 지, 금액으로 할인 할 지
	{
		case "1":
			$dcType = "%";
		break;
		case "2":
			$dcType = "원";
		break;
	}
	switch ($rs["STATUS"])		//쿠폰 상태 
	{
		case "0":
			$couponStatus = "미사용";
		break;		
		case "1":
			$couponStatus = "사용완료";
		break;
		case "2":
			$couponStatus = "기간만료";
		break;
	}
?>
<tr align="center">
<td><input type="checkbox" value="<?=$rs["idx"]?>" name="chkIdx"></td>
<td height="25px"><?=$rowCnt++?></td>
<td height="25px"><?=$rs["kind"]?></td>
<td height="25px"><?=$rs["issueDate"]?></td>
<td height="25px"><?=$rs["expiredDate"]?></td>
<td height="25px"><?=$rs["dcValue"]?></td>
<td height="25px"><?=$dcType?></td>
<td height="25px"><?=$couponStatus?></td>
</tr>	
<tr><td colspan="21" height="1" bgcolor="AAAAAA"></td></tr>
<?php
}
?>
</table>
</form>
</body>
<iframe name="invFrame" width="0px" height="0px"></iframe>
</html>