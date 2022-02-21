<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$userID = $_COOKIE["_CKE_USER_ID"];






$sql = "select count(idx) as cnt from 2011Survey where q1!=''";
$tmpRs = mysql_query($sql);
$rs= mysql_fetch_array($tmpRs);
$totalCnt = $rs[cnt];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/502style.css" />
</head>
<body>
<br><br>
<b>*설문조사 응답 결과 현재 <font color="Blue">[<?=$totalCnt?>명]</font> 응답 - 2월28일까지 진행 예정</b><br><br>
<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">1. 평택촌놈[502]을 알게 된 경위는?</td>
<td bgcolor="#FFFFCC">TV</td>
<td bgcolor="#FFFFCC">언론기사</td>
<td bgcolor="#FFFFCC">지인소개</td>
<td bgcolor="#FFFFCC">인터넷검색</td>
</tr>
<tr align="center">

<?php 
//1번 문항 분석
$sql = "select count(idx) as cnt from 2011Survey where q1 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q1 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q1 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q1 = '4'";


$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">2. 귀하의 성별은 어떻게 되십니까?</td>
<td bgcolor="#FFFFCC">남성</td>
<td bgcolor="#FFFFCC">여성</td>
</tr>
<tr align="center">

<?php 
//2번 문항 분석
$sql = "select count(idx) as cnt from 2011Survey where q2 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q2 = '2'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">3. 귀하의 연령대는 어떻게 되십니까?</td>
<td bgcolor="#FFFFCC">10~19</td>
<td bgcolor="#FFFFCC">20~29</td>
<td bgcolor="#FFFFCC">30~39</td>
<td bgcolor="#FFFFCC">40~49</td>
<td bgcolor="#FFFFCC">50~59</td>
<td bgcolor="#FFFFCC">60~69</td>
<td bgcolor="#FFFFCC">70이상</td>
</tr>
<tr align="center">

<?php 
//3번 문항 분석
$sql = "select count(idx) as cnt from 2011Survey where q3 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '5'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '6'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q3 = '7'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>
<!-- 
배열 3개 선언
8
7
5

-->
<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px">4. 귀하의 직종은 어떻게 되십니까?</td>
<?php

//q4 결과 데이터를 저장하기 위한 배열을 선언한다.
$arrq4_1 = array(0,0,0,0,0,0,0,0); //8
$arrq4_2 = array(0,0,0,0,0,0,0); //7
$arrq4_3 = array(0,0,0,0,0); //5

//4번 문항 분석
$sql = "select q4 from 2011Survey";
$tmpRs = mysql_query($sql);
while ($rs= mysql_fetch_array($tmpRs)) 
{
	//여기에 q4 분석 결과가 들어간다.
	$tmpStr = explode("^",$rs[q4]);
	switch ($tmpStr[0])
	{
		case 1:
			$arrq4_1[0] += 1;
		break;
		case 2:
			$arrq4_1[1] += 1;
		break;
		case 3:
			$arrq4_1[2] += 1;
		break;
		case 4:
			$arrq4_1[3] += 1;
		break;
		case 5:
			$arrq4_1[4] += 1;
		break;
		case 6:
			$arrq4_1[5] += 1;
		break;
		case 7:
			$arrq4_1[6] += 1;
		break;
		case 8:
			$arrq4_1[7] += 1;
		break;
	}
	
	switch ($tmpStr[1])
	{
		case 1:
			$arrq4_2[0] += 1;
		break;
		case 2:
			$arrq4_2[1] += 1;
		break;
		case 3:
			$arrq4_2[2] += 1;
		break;
		case 4:
			$arrq4_2[3] += 1;
		break;
		case 5:
			$arrq4_2[4] += 1;
		break;
		case 6:
			$arrq4_2[5] += 1;
		break;
		case 7:
			$arrq4_2[6] += 1;
		break;
	}
	switch ($tmpStr[2])
	{
		case 1:
			$arrq4_3[0] += 1;
		break;
		case 2:
			$arrq4_3[1] += 1;
		break;
		case 3:
			$arrq4_3[2] += 1;
		break;
		case 4:
			$arrq4_3[3] += 1;
		break;
		case 5:
			$arrq4_3[4] += 1;
		break;
		case 6:
			$arrq4_3[5] += 1;
		break;
		case 7:
			$arrq4_3[6] += 1;
		break;
	}
}
?>
<td valign="top">
	<table>
	<tr>
	<td>공기업,공공단체</td>
	<td><?=$arrq4_1[0]?>&nbsp;&nbsp;[<?=round($arrq4_1[0]/$totalCnt*100,2)?>]%</td>
	
	</tr>
	<tr>
	<td>공무원	</td>
	<td><?=$arrq4_1[1]?>&nbsp;&nbsp;[<?=round($arrq4_1[1]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>교육계	</td>
	<td><?=$arrq4_1[2]?>	&nbsp;&nbsp;[<?=round($arrq4_1[2]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>금융계	</td>
	<td><?=$arrq4_1[3]?>	&nbsp;&nbsp;[<?=round($arrq4_1[3]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>언론계	</td>
	<td><?=$arrq4_1[4]?>	&nbsp;&nbsp;[<?=round($arrq4_1[4]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>의료계	</td>
	<td><?=$arrq4_1[5]?>&nbsp;&nbsp;[<?=round($arrq4_1[5]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>일반기업직(회사원)</td>
	<td><?=$arrq4_1[6]?>	&nbsp;&nbsp;[<?=round($arrq4_1[6]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>전문직</td>
	<td><?=$arrq4_1[7]?>	&nbsp;&nbsp;[<?=round($arrq4_1[7]/$totalCnt*100,2)?>]%</td>
	</tr>
	</table>
</td>
<td valign="top">
	<table>
	<tr>
	<td>건설</td>
	<td><?=$arrq4_2[0]?>	&nbsp;&nbsp;[<?=round($arrq4_2[0]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>금융,보험업	</td>
	<td><?=$arrq4_2[1]?>	&nbsp;&nbsp;[<?=round($arrq4_2[1]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>농업,임업,수산업,광업	</td>
	<td><?=$arrq4_2[2]?>	&nbsp;&nbsp;[<?=round($arrq4_2[2]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>도소매,수리업	</td>
	<td><?=$arrq4_2[3]?>	&nbsp;&nbsp;[<?=round($arrq4_2[3]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>부동산,임대,개인서비스	</td>
	<td><?=$arrq4_2[4]?>	&nbsp;&nbsp;[<?=round($arrq4_2[4]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>숙박,음식업,운수,창고,통신업	</td>
	<td><?=$arrq4_2[5]?>	&nbsp;&nbsp;[<?=round($arrq4_2[5]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>전기,가스,수도,제조업</td>
	<td><?=$arrq4_2[6]?>	&nbsp;&nbsp;[<?=round($arrq4_2[6]/$totalCnt*100,2)?>]%</td>
	</tr>	
	</table>
</td>
<td valign="top">
	<table>
	<tr>
	<td>정년퇴직자</td>
	<td><?=$arrq4_3[0]?>	&nbsp;&nbsp;[<?=round($arrq4_3[0]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>주부	</td>
	<td><?=$arrq4_3[1]?>	&nbsp;&nbsp;[<?=round($arrq4_3[1]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>학생	</td>
	<td><?=$arrq4_3[2]?>	&nbsp;&nbsp;[<?=round($arrq4_3[2]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>전업투자자	</td>
	<td><?=$arrq4_3[3]?>	&nbsp;&nbsp;[<?=round($arrq4_3[3]/$totalCnt*100,2)?>]%</td>
	</tr>
	<tr>
	<td>기타/해당없음	</td>
	<td><?=$arrq4_3[4]?>	&nbsp;&nbsp;[<?=round($arrq4_3[4]/$totalCnt*100,2)?>]%</td>
	</tr>
	</table>
</td>
</tr>
</table>



<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">5. 현재 투자금은 어떻게 되십니까?</td>
<td bgcolor="#FFFFCC">5억 초과</td>
<td bgcolor="#FFFFCC">3억~5억</td>
<td bgcolor="#FFFFCC">1억~3억</td>
<td bgcolor="#FFFFCC">5000만~1억</td>
<td bgcolor="#FFFFCC">2000만~5000만</td>
<td bgcolor="#FFFFCC">2000만 이하</td>
</tr>
<tr align="center">
<?php 
//5번 문항 분석
$sql = "select count(idx) as cnt from 2011Survey where q5 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '5'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q5 = '6'";


$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2">6.평택촌놈[502]을 주 평균 얼마나 이용하십니까?</td>
<td bgcolor="#FFFFCC">매일</td>
<td bgcolor="#FFFFCC">주 5회 이상</td>
<td bgcolor="#FFFFCC">주 3 ~ 4회</td>
<td bgcolor="#FFFFCC">주 1 ~ 2회</td>
<td bgcolor="#FFFFCC">주 1회 미만</td>
</tr>
<tr align="center">
<?php 
//6번 문항 분석
$sql = "select count(idx) as cnt from 2011Survey where q6 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q6 = '5'";



$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<!-- 여기부터는 자주 쓰는 게시판,,계산하려면 죽었네..ㅠㅠ -->

<?php
$arr7 = array(
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0
);

$arr8 = array(
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0
);


$sql = "select q7 from 2011Survey";
$tmpRs = mysql_query($sql);
while ($rs= mysql_fetch_array($tmpRs)) 
{
	//여기에 q7 분석 결과가 들어간다.
	$tmpStr = explode("^",$rs[q7]);
	
	//echo sizeof($arr7);
	
	for($i=0 ; $i < sizeof($arr7) ; $i++)
	{
		if($tmpStr[0] == $i+1)
		{
			$arr7[$i] += 1; 
			//echo $tmpStr[0]."<br>";			
		}
		if($tmpStr[1] == $i+1)
		{
			$arr7[$i] += 1; 
			//echo $tmpStr[1]."<br>";			
		}
		if($tmpStr[2] == $i+1)
		{
			$arr7[$i] += 1; 
			//echo $tmpStr[2]."<br>";			
		}
	}	
}
?>

<br>
<table cellpadding="0" cellspacing="0" border="1" width="1200px">
<tr align="center">
<td width="300px">7.평택촌놈[502]에서 가장 많이 이용하는 게시판은?</td>
<td>
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td align="left" valign="top">
	<img src="img/sub1.jpg" border="0"><!--인터넷방송--><br>	
	방송일정안내&nbsp;&nbsp; <?=$arr7[0]?>명 &nbsp;&nbsp; [<?=round($arr7[0]/$totalCnt*100,2)?>]%<br>
	방송데모보기&nbsp;&nbsp; <?=$arr7[1]?>명  &nbsp;&nbsp; [<?=round($arr7[1]/$totalCnt*100,2)?>]%<br>
	무료체험신청&nbsp;&nbsp; <?=$arr7[2]?>명  &nbsp;&nbsp; [<?=round($arr7[2]/$totalCnt*100,2)?>]%<br>
	방송시청후기&nbsp;&nbsp; <?=$arr7[3]?>명  &nbsp;&nbsp; [<?=round($arr7[3]/$totalCnt*100,2)?>]%<br>
	녹화방송보기&nbsp;&nbsp; <?=$arr7[4]?>명  &nbsp;&nbsp; [<?=round($arr7[4]/$totalCnt*100,2)?>]%<br>
	프리미엄속보&nbsp;&nbsp; <?=$arr7[5]?>명  &nbsp;&nbsp; [<?=round($arr7[5]/$totalCnt*100,2)?>]%<br>
	일반회원속보&nbsp;&nbsp; <?=$arr7[6]?>명  &nbsp;&nbsp; [<?=round($arr7[6]/$totalCnt*100,2)?>]%<br>
	주식강의VOD&nbsp;&nbsp; <?=$arr7[7]?>명  &nbsp;&nbsp; [<?=round($arr7[7]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub2.jpg" border="0"><!--VIP--><br>
	프리미엄&nbsp;&nbsp; <?=$arr7[8]?>명   &nbsp;&nbsp; [<?=round($arr7[8]/$totalCnt*100,2)?>]%<br>
	투자클럽&nbsp;&nbsp; <?=$arr7[9]?>명   &nbsp;&nbsp; [<?=round($arr7[9]/$totalCnt*100,2)?>]%<br>
	502TMS&nbsp;&nbsp; <?=$arr7[10]?>명   &nbsp;&nbsp;&nbsp; [<?=round($arr7[10]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub3.jpg" border="0"><!--투자정보--><br>
	전문가 투자전략&nbsp;&nbsp; <?=$arr7[11]?>명   &nbsp;&nbsp; [<?=round($arr7[11]/$totalCnt*100,2)?>]%<br>
	1등급 분석실&nbsp;&nbsp; <?=$arr7[12]?>명  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr7[12]/$totalCnt*100,2)?>]%<br>
	평택촌놈 칼럼 &nbsp;&nbsp; <?=$arr7[13]?>명  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr7[13]/$totalCnt*100,2)?>]%<br>
	심봤다 종목추천&nbsp;&nbsp; <?=$arr7[14]?>명  &nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr7[14]/$totalCnt*100,2)?>]%<br>
	502뉴스&nbsp;&nbsp; <?=$arr7[15]?>명   &nbsp; [<?=round($arr7[15]/$totalCnt*100,2)?>]%<br>
	502무료티커&nbsp;&nbsp; <?=$arr7[16]?>명   &nbsp;&nbsp; [<?=round($arr7[16]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub4.jpg" border="0"><!--종목토론실--><br>
	종목추천 탑10 &nbsp;&nbsp; <?=$arr7[17]?>명    &nbsp;&nbsp; [<?=round($arr7[17]/$totalCnt*100,2)?>]%<br>
	종목추천&nbsp;&nbsp; <?=$arr7[18]?>명     &nbsp;&nbsp; [<?=round($arr7[18]/$totalCnt*100,2)?>]%<br>
	종목질문(코스피)&nbsp;&nbsp; <?=$arr7[19]?>명     &nbsp;&nbsp; [<?=round($arr7[19]/$totalCnt*100,2)?>]%<br>
	종목질문(코스닥)&nbsp;&nbsp; <?=$arr7[20]?>명     &nbsp;&nbsp; [<?=round($arr7[20]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	<tr><td colspan="4" align="center" height="20px"></td></tr>
	<tr valign="top">
	<td align="left">
	<img src="img/sub5.jpg" border="0"><!--매매평가실--><br>
	주식매매일지&nbsp;&nbsp; <?=$arr7[21]?>명     &nbsp;&nbsp; [<?=round($arr7[21]/$totalCnt*100,2)?>]%<br>
	선물매매일지 &nbsp;&nbsp; <?=$arr7[22]?>명    &nbsp;&nbsp; [<?=round($arr7[22]/$totalCnt*100,2)?>]%<br>
	매매노하우&nbsp;&nbsp; <?=$arr7[23]?>명     &nbsp;&nbsp; [<?=round($arr7[23]/$totalCnt*100,2)?>]%<br>
	수익률게시판 &nbsp;&nbsp; <?=$arr7[24]?>명    &nbsp;&nbsp; [<?=round($arr7[24]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub6.jpg" border="0"><!--평촌사랑방--><br> 
	502사진방 &nbsp;&nbsp; <?=$arr7[25]?>명    &nbsp;&nbsp; [<?=round($arr7[25]/$totalCnt*100,2)?>]%<br>
	세상사는이야기&nbsp;&nbsp; <?=$arr7[26]?>명     &nbsp;&nbsp; [<?=round($arr7[26]/$totalCnt*100,2)?>]%<br>
	주식공부방 &nbsp;&nbsp; <?=$arr7[27]?>명    &nbsp;&nbsp; [<?=round($arr7[27]/$totalCnt*100,2)?>]%<br>
	종교방&nbsp;&nbsp; <?=$arr7[28]?>명     &nbsp;&nbsp; [<?=round($arr7[28]/$totalCnt*100,2)?>]%<br>
	출석체크 &nbsp;&nbsp; <?=$arr7[29]?>명    &nbsp;&nbsp; [<?=round($arr7[29]/$totalCnt*100,2)?>]%<br>
	랭킹,순위 &nbsp;&nbsp; <?=$arr7[30]?>명    &nbsp;&nbsp; [<?=round($arr7[30]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub7.jpg" border="0"><!--고객센터--><br>
	공지사항 &nbsp;&nbsp; <?=$arr7[31]?>명    &nbsp;&nbsp; [<?=round($arr7[31]/$totalCnt*100,2)?>]%<br>
	질문과 답변 &nbsp;&nbsp; <?=$arr7[32]?>명    &nbsp;&nbsp; [<?=round($arr7[32]/$totalCnt*100,2)?>]%<br>
	결제 이용안내 &nbsp;&nbsp; <?=$arr7[33]?>명    &nbsp;&nbsp; [<?=round($arr7[33]/$totalCnt*100,2)?>]%<br>
	사이트 이용안내 &nbsp;&nbsp; <?=$arr7[34]?>명   &nbsp;&nbsp; [<?=round($arr7[34]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub8.jpg" border="0"><!--FIRST--><br>
	FIRST &nbsp;&nbsp; <?=$arr7[35]?>명    &nbsp;&nbsp; [<?=round($arr7[35]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>	
<?php

$sql = "select q8 from 2011Survey";
$tmpRs = mysql_query($sql);
while ($rs= mysql_fetch_array($tmpRs)) 
{
	$tmpStr = explode("^",$rs[q8]);
	
	for($i=0 ; $i < sizeof($arr8) ; $i++)
	{
		if($tmpStr[0] == $i+1)
		{
			$arr8[$i] += 1; 
		}
		if($tmpStr[1] == $i+1)
		{
			$arr8[$i] += 1; 			
		}
		if($tmpStr[2] == $i+1)
		{
			$arr8[$i] += 1; 
		}
	}	
}
?>


<br>
<table cellpadding="0" cellspacing="0" border="1" width="1200px">
<tr align="center">
<td width="300px">8.평택촌놈에서 가장 많이 이용하지 않는 게시판은?</td>
<td align="center">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td align="left" valign="top">
	<img src="img/sub1.jpg" border="0"><!--인터넷방송--><br>	
	방송일정안내&nbsp;&nbsp; <?=$arr8[0]?>명 &nbsp;&nbsp; [<?=round($arr8[0]/$totalCnt*100,2)?>]%<br>
	방송데모보기&nbsp;&nbsp; <?=$arr8[1]?>명  &nbsp;&nbsp; [<?=round($arr8[1]/$totalCnt*100,2)?>]%<br>
	무료체험신청&nbsp;&nbsp; <?=$arr8[2]?>명  &nbsp;&nbsp; [<?=round($arr8[2]/$totalCnt*100,2)?>]%<br>
	방송시청후기&nbsp;&nbsp; <?=$arr8[3]?>명  &nbsp;&nbsp; [<?=round($arr8[3]/$totalCnt*100,2)?>]%<br>
	녹화방송보기&nbsp;&nbsp; <?=$arr8[4]?>명  &nbsp;&nbsp; [<?=round($arr8[4]/$totalCnt*100,2)?>]%<br>
	프리미엄속보&nbsp;&nbsp; <?=$arr8[5]?>명  &nbsp;&nbsp; [<?=round($arr8[5]/$totalCnt*100,2)?>]%<br>
	일반회원속보&nbsp;&nbsp; <?=$arr8[6]?>명  &nbsp;&nbsp; [<?=round($arr8[6]/$totalCnt*100,2)?>]%<br>
	주식강의VOD&nbsp;&nbsp; <?=$arr8[7]?>명  &nbsp;&nbsp; [<?=round($arr8[7]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub2.jpg" border="0"><!--VIP--><br>
	프리미엄&nbsp;&nbsp; <?=$arr8[8]?>명   &nbsp;&nbsp; [<?=round($arr8[8]/$totalCnt*100,2)?>]%<br>
	투자클럽&nbsp;&nbsp; <?=$arr8[9]?>명   &nbsp;&nbsp; [<?=round($arr8[9]/$totalCnt*100,2)?>]%<br>
	502TMS&nbsp;&nbsp; <?=$arr8[10]?>명   &nbsp;&nbsp;&nbsp; [<?=round($arr8[10]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub3.jpg" border="0"><!--투자정보--><br>
	전문가 투자전략&nbsp;&nbsp; <?=$arr8[11]?>명   &nbsp;&nbsp; [<?=round($arr8[11]/$totalCnt*100,2)?>]%<br>
	1등급 분석실&nbsp;&nbsp; <?=$arr8[12]?>명  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr8[12]/$totalCnt*100,2)?>]%<br>
	평택촌놈 칼럼 &nbsp;&nbsp; <?=$arr8[13]?>명  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr8[13]/$totalCnt*100,2)?>]%<br>
	심봤다 종목추천&nbsp;&nbsp; <?=$arr8[14]?>명  &nbsp;&nbsp;&nbsp;&nbsp; [<?=round($arr8[14]/$totalCnt*100,2)?>]%<br>
	502뉴스&nbsp;&nbsp; <?=$arr8[15]?>명   &nbsp; [<?=round($arr8[15]/$totalCnt*100,2)?>]%<br>
	502무료티커&nbsp;&nbsp; <?=$arr8[16]?>명   &nbsp;&nbsp; [<?=round($arr8[16]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub4.jpg" border="0"><!--종목토론실--><br>
	종목추천 탑10 &nbsp;&nbsp; <?=$arr8[17]?>명    &nbsp;&nbsp; [<?=round($arr8[17]/$totalCnt*100,2)?>]%<br>
	종목추천&nbsp;&nbsp; <?=$arr8[18]?>명     &nbsp;&nbsp; [<?=round($arr8[18]/$totalCnt*100,2)?>]%<br>
	종목질문(코스피)&nbsp;&nbsp; <?=$arr8[19]?>명     &nbsp;&nbsp; [<?=round($arr8[19]/$totalCnt*100,2)?>]%<br>
	종목질문(코스닥)&nbsp;&nbsp; <?=$arr8[20]?>명     &nbsp;&nbsp; [<?=round($arr8[20]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	<tr><td colspan="4" align="center" height="20px"></td></tr>
	<tr valign="top">
	<td align="left">
	<img src="img/sub5.jpg" border="0"><!--매매평가실--><br>
	주식매매일지&nbsp;&nbsp; <?=$arr8[21]?>명     &nbsp;&nbsp; [<?=round($arr8[21]/$totalCnt*100,2)?>]%<br>
	선물매매일지 &nbsp;&nbsp; <?=$arr8[22]?>명    &nbsp;&nbsp; [<?=round($arr8[22]/$totalCnt*100,2)?>]%<br>
	매매노하우&nbsp;&nbsp; <?=$arr8[23]?>명     &nbsp;&nbsp; [<?=round($arr8[23]/$totalCnt*100,2)?>]%<br>
	수익률게시판 &nbsp;&nbsp; <?=$arr8[24]?>명    &nbsp;&nbsp; [<?=round($arr8[24]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub6.jpg" border="0"><!--평촌사랑방--><br> 
	502사진방 &nbsp;&nbsp; <?=$arr8[25]?>명    &nbsp;&nbsp; [<?=round($arr8[25]/$totalCnt*100,2)?>]%<br>
	세상사는이야기&nbsp;&nbsp; <?=$arr8[26]?>명     &nbsp;&nbsp; [<?=round($arr8[26]/$totalCnt*100,2)?>]%<br>
	주식공부방 &nbsp;&nbsp; <?=$arr8[27]?>명    &nbsp;&nbsp; [<?=round($arr8[27]/$totalCnt*100,2)?>]%<br>
	종교방&nbsp;&nbsp; <?=$arr8[28]?>명     &nbsp;&nbsp; [<?=round($arr8[28]/$totalCnt*100,2)?>]%<br>
	출석체크 &nbsp;&nbsp; <?=$arr8[29]?>명    &nbsp;&nbsp; [<?=round($arr8[29]/$totalCnt*100,2)?>]%<br>
	랭킹,순위 &nbsp;&nbsp; <?=$arr8[30]?>명    &nbsp;&nbsp; [<?=round($arr8[30]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub7.jpg" border="0"><!--고객센터--><br>
	공지사항 &nbsp;&nbsp; <?=$arr8[31]?>명    &nbsp;&nbsp; [<?=round($arr8[31]/$totalCnt*100,2)?>]%<br>
	질문과 답변 &nbsp;&nbsp; <?=$arr8[32]?>명    &nbsp;&nbsp; [<?=round($arr8[32]/$totalCnt*100,2)?>]%<br>
	결제 이용안내 &nbsp;&nbsp; <?=$arr8[33]?>명    &nbsp;&nbsp; [<?=round($arr8[33]/$totalCnt*100,2)?>]%<br>
	사이트 이용안내 &nbsp;&nbsp; <?=$arr8[34]?>명   &nbsp;&nbsp; [<?=round($arr8[34]/$totalCnt*100,2)?>]%<br>
	</td>
	<td align="left">
	<img src="img/sub8.jpg" border="0"><!--FIRST--><br>
	FIRST &nbsp;&nbsp; <?=$arr8[35]?>명    &nbsp;&nbsp; [<?=round($arr8[35]/$totalCnt*100,2)?>]%<br>
	</td>
	</tr>
	</table>
</td>
</tr>
</table>	


<br>

<table cellpadding="0" cellspacing="0" border="1" width="1200px">
<tr align="center">
<td width="300px" rowspan="2">9.평택촌놈[502]의 코인서비스를 알고 있다</td>
<td bgcolor="#FFFFCC">잘 알고 있고 사용해본적 있다</td>
<td bgcolor="#FFFFCC">알고있지만 사용해본적 없다</td>
<td bgcolor="#FFFFCC">몰랐다. 앞으로도 사용해볼 의사가 없다</td>
<td bgcolor="#FFFFCC">몰랐지만 추후 사용할 의사가 있다</td>
</tr>
<tr align="center">
<?php 
//9번 문항 분석
$sql = " select count(idx) as cnt from 2011Survey where q9 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q9 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q9 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q9 = '4'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">10.평택촌놈[502]의 프리미엄 방송과 502클럽의 차이점을 알고 있다. </td>
<td bgcolor="#FFFFCC">잘 알고 있다</td>
<td bgcolor="#FFFFCC">얼추 알고 있다</td>
<td bgcolor="#FFFFCC">502클럽만 알고 있다</td>
<td bgcolor="#FFFFCC">프리미엄만 알고 있다</td>
<td bgcolor="#FFFFCC">잘 모른다</td>
</tr>
<tr align="center">

<?php 
//10번 문항 분석
$sql = " select count(idx) as cnt from 2011Survey where q10 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '4'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q10 = '5'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>


<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">11. 홈페이지에서 제공하는 유무료 주식정보 서비스 내용에 대해 어떻게 생각하십니까?</td>
<td bgcolor="#FFFFCC">매우만족</td>
<td bgcolor="#FFFFCC">만족</td>
<td bgcolor="#FFFFCC">보통</td>
<td bgcolor="#FFFFCC">불만족</td>
</tr>
<tr align="center">
<?php 
//11번 문항 분석
$sql = " select count(idx) as cnt from 2011Survey where q11 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q11 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q11 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q11 = '4'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">12. 사이트의 메뉴구성이나 전체적인 배치는 쉽고 편리하게 구성 되어 있습니까?</td>
<td bgcolor="#FFFFCC">매우만족</td>
<td bgcolor="#FFFFCC">만족</td>
<td bgcolor="#FFFFCC">보통</td>
<td bgcolor="#FFFFCC">불만족</td>
</tr>
<tr align="center">
<?php 
//12번 문항 분석
$sql = " select count(idx) as cnt from 2011Survey where q12 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q12 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q12 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q12 = '4'";

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center">
<td width="300px" rowspan="2" align="left">13. 동시에 이용중인 타 주식정보 사이트가 있습니까?</td>
<td bgcolor="#FFFFCC">팍스넷</td>
<td bgcolor="#FFFFCC">싱크풀</td>
<td bgcolor="#FFFFCC">하이리치</td>
<td bgcolor="#FFFFCC">이토마토</td>
<td bgcolor="#FFFFCC">와우넷</td>
<td bgcolor="#FFFFCC">매드머니</td>
<td bgcolor="#FFFFCC">502만이용</td>
</tr>
<tr align="center">
<?php 
//13번 문항 분석
$sql = " select count(idx) as cnt from 2011Survey where q13 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '4'"; //568
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '5'"; //568
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '6'"; //568
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q13 = '8'"; //568

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>

<br>

<table cellpadding="0" cellspacing="0" border="1" width="900px">
<tr align="center" >
<td width="300px" rowspan="2">14. 이용중인 타 사이트에 대한 만족도는?</td>
<td bgcolor="#FFFFCC">매우만족</td>
<td bgcolor="#FFFFCC">만족</td>
<td bgcolor="#FFFFCC">보통</td>
<td bgcolor="#FFFFCC">불만족</td>
</tr>
<tr align="center">
<?php 
//14번 문항 분석
$sql = " select count(idx) as cnt from 2011Survey where q14 = '1'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q14 = '2'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q14 = '3'";
$sql .= "union All  ";
$sql .= "select count(idx) as cnt from 2011Survey where q14 = '4'"; 

$tmpRs = mysql_query($sql);

while ($rs= mysql_fetch_array($tmpRs)) 
{
?>
<td><?=$rs["cnt"]?>&nbsp;&nbsp;[<?=round($rs["cnt"]/$totalCnt*100,2)?>]%</td>
<?php
}
?>
</tr>
</table>
<br>
<br>
<br>
주관식 답변 모음 (회원들의 502 사이트에 대한 의견을 진솔하게 듣고 싶어 불만등에 대한 필터링을 안할 예정입니다.)
<br>
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lani/survey/analyzeText.php";
?>
<!--
<iframe name="invFrame" src="/lani/survey/analyzeText.php" width="1100" height="100%"></iframe>
-->

</body>
</html>

