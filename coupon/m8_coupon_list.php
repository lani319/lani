<?
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

if($searchflag == "")
{
	$searchflag = 1;
}
?>
<html>
<head>
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
	
	alert(t.value);
	
	if(t.value=="")
	{
		alert('삭제 할 쿠폰을 선택 해 주세요');
		return;
	}
	var str = t.value;
	
	t.value = str.substring(0, str.length-1);
	
	alert(t.value);
	

	f.submit();
}


function goUserNickname()
{
	var param = document.getElementById("txtUserNickname").value;
	var url = "http://www.502.co.kr/lani/coupon/m8_coupon_MemberView.php?userNickname="+param;
	var newWindow = open(url,"search","height=800,width=1000,top=0,left=0,location=false,menubar=false,directories=false");
		
}
</script>

</head>
<body>
<br><br>
<form name="form1" method="POST" action="m8_coupon_list_delOK.php" target="invFrame">
<input type="hidden" name="txtIdx">

<TABLE width="920" cellpadding=0 cellspacing=0 border=0>
<tr height=10><td></td></tr>
<tr>
	<td>
		<TABLE width="100%" cellpadding=0 cellspacing=0 border=0>
		<TR>
			<TD></TD>
			<TD valign="bottom" align="right"><img src="/admin/images/icon_location.gif" align="absmiddle"> 외부사이트관리 &gt; 발행쿠폰목록&nbsp;</TD>
		</TR>
		</TABLE>
	</td>
</tr>
</table>
<table width="920" cellpadding=0 cellspacing=0 border=0>
<tr>
<td align="left">
<img src="img/newCoupon.gif" style="cursor:hand;" onclick="location.href = 'm8_couponSetup.html'">
&nbsp;&nbsp;
<img src="img/delCoupon.gif" style="cursor:hand;" onclick="del()">
&nbsp;&nbsp;
<img src="img/newCouponKind.gif" style="cursor:hand;" onclick="location.href = 'm8_couponKind_list.html'">
</td>
<td align="right">
<input type="radio" onclick="javascript:location.href='m8_coupon_list.php?searchflag=1'" <? if($searchflag==1){echo " checked";}?>>전체쿠폰
<input type="radio" onclick="javascript:location.href='m8_coupon_list.php?searchflag=2'" <? if($searchflag==2){echo " checked";}?>>미 사용 쿠폰
<input type="radio" onclick="javascript:location.href='m8_coupon_list.php?searchflag=4'" <? if($searchflag==4){echo " checked";}?>>사용 완료 쿠폰
<input type="radio" onclick="javascript:location.href='m8_coupon_list.php?searchflag=3'" <? if($searchflag==3){echo " checked";}?>>기간 만료 쿠폰
</td>
</tr>
</table>

<?php
switch ($searchflag)
{
	case "1": //전체
	//전체 발급 쿠폰 확인
	$sql = "SELECT A.idx,A.issueDate,A.usedDate,A.expiredDate,A.memIdx,A.STATUS,A.etc,B.idx as couponIdx,B.kind,B.dcValue,B.dcType,C.userId,C.userName,C.userNickname, C.jongmokCnt
	FROM 502Coupon A INNER JOIN 502CouponKind B ON A.kind = B.idx
	INNER JOIN Member C ON A.memIdx = C.idx
	ORDER BY A.idx DESC";	
	break;
	
	case "2": //만기일 남아있고 미사용 쿠폰
	//만기일 남아있고 미사용 쿠폰 확인
	$sql = "SELECT A.idx,A.issueDate,A.usedDate,A.expiredDate,A.memIdx,A.STATUS,A.etc,B.idx as couponIdx,B.kind,B.dcValue,B.dcType,C.userId,C.userName ,C.userNickname, C.jongmokCnt 
	FROM 502Coupon A INNER JOIN 502CouponKind B ON A.kind = B.idx
	INNER JOIN Member C ON A.memIdx = C.idx
	WHERE A.expiredDate >= FROM_UNIXTIME(UNIX_TIMESTAMP()) and A.status = 0  and B.idx <> 17
	ORDER BY A.issueDate DESC";	
	break;
	
	case "3":
	//만료 된 쿠폰 확인
	$sql = "SELECT A.idx,A.issueDate,A.usedDate,A.expiredDate,A.memIdx,A.STATUS,A.etc,B.idx as couponIdx,B.kind,B.dcValue,B.dcType,C.userId,C.userName ,C.userNickname, C.jongmokCnt 
	FROM 502Coupon A INNER JOIN 502CouponKind B ON A.kind = B.idx
	INNER JOIN Member C ON A.memIdx = C.idx
	WHERE A.expiredDate < FROM_UNIXTIME(UNIX_TIMESTAMP()) and A.status = 0   and B.idx <> 17
	ORDER BY A.expiredDate DESC";		
	break;
	
	case "4":
	//사용 완료 쿠폰
	$sql = "SELECT A.idx,A.issueDate,A.usedDate,A.expiredDate,A.memIdx,A.STATUS,A.etc,B.idx as couponIdx,B.kind,B.dcValue,B.dcType,C.userId,C.userName ,C.userNickname, C.jongmokCnt 
	FROM 502Coupon A INNER JOIN 502CouponKind B ON A.kind = B.idx
	INNER JOIN Member C ON A.memIdx = C.idx
	WHERE A.status = 1  and B.idx <> 17
	ORDER BY A.usedDate DESC";
	break;	
}

//echo $sql;

$tmpRs = mysql_query($sql);
$couponListCount = mysql_num_rows($tmpRs);
$rowCnt  = 1;
?>
<table width="920" cellpadding=0 cellspacing=0 border=0>
<tr><td colspan="5">총 발행 쿠폰 수 : <?=$couponListCount?>매</td>
<td colspan="15">
<input type="text" id="txtUserNickname" name="txtUseNickname" size="20" ><a href="#" onclick="goUserNickname();" > 검색</a>
</td>  
</tr>
<tr bgcolor="AAAAAA" align="center">
<td></td>
<td height="25px" style="color:FFFFFF">순번</td>
<td height="25px" style="color:FFFFFF">회원정보</td>
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
	
	$expiredDate = $rs[expiredDate];
	$dcValue = $rs[dcValue];
	
	//적정주가
	if($rs[couponIdx]==17)
	{
		$couponStatus = $rs[jongmokCnt]."개 남음";
		$expiredDate = "무기한";
		$dcValue = "";
		$dcType = "";
	}

?>
<tr align="center">
<td><input type="checkbox" value="<?=$rs["idx"]?>" name="chkIdx">
<?=$rs["idx"]?>
</td>
<td height="25px"><?=$rowCnt++?></td>
<td height="25px"><?=$rs[userName]?>[<?=$rs[userNickname]?>]</td>
<td height="25px"><?=$rs["kind"]?><br><font color="red"><?=$rs['etc']?></font></td>
<td height="25px"><?=$rs["issueDate"]?></td>
<td height="25px"><?=$expiredDate?></td>
<td height="25px"><?=$dcValue?></td>
<td height="25px"><?=$dcType?></td>
<td height="25px">
<?php
if($rs['STATUS']==1){
	$couponStatus = $couponStatus."<br>(".$rs['usedDate'].")";
}
?>

<?=$couponStatus?>

</td>
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