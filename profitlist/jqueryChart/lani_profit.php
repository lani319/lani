<?
include_once $_SERVER['DOCUMENT_ROOT']."/include/in_top_header.html";
?>
<body onLoad="MM_preloadImages('/img/strategy/left_menu_11.gif','/img/strategy/left_menu_21.gif','/img/strategy/left_menu_31.gif','/img/charged/left_menu_11.gif','/img/charged/left_menu_21.gif','/img/charged/left_menu_31.gif')">
<?
$login_rtnurl="/charged/index.html";
include_once $_SERVER['DOCUMENT_ROOT']."/include/in_top.html";
?>
<table width="940" border="0" align="center" cellpadding="0" cellspacing="0" id="body">
<tr>
	<td width="172" valign="top">
      <? include_once $_SERVER['DOCUMENT_ROOT']."/include/in_left_counsel.html" ?>
      <? include_once $_SERVER['DOCUMENT_ROOT']."/include/in_left_bn.html" ?>
	</td>
	<td width="768" valign="top">
		<table width="768" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="411" height="29" background="/img/strategy/title_bg.gif"><table border="0" cellpadding="0" cellspacing="0" background="/img/sub/title_bg.gif">
          <tr>
            <td class="k16b"><img src="/img/sub/title_left.gif" width="15" height="29" align="absmiddle">수익률게시판<img src="/img/sub/title_r.gif" width="18" height="29" align="absmiddle"></td>
          </tr>
        </table></td>
			<td width="340" align="right" background="/img/strategy/title_bg.gif"><img src="/img/strategy/title_navi.gif" width="4" height="29" align="absmiddle">&nbsp;&nbsp;&nbsp;<b><a href="http://www.502.co.kr" class="white">홈</a> <span class="white">&gt;</span> <a href="/counsel/index.html" class="white">매매평가실</a> <span class="white">&gt; 수익률게시판<span></b></td>
			<td width="17" align="right" background="/img/strategy/title_bg.gif"><img src="/img/strategy/title_end.gif" width="3" height="29"></td>
		</tr>
		<tr>
			<td height="14"> </td>
			<td height="14" align="right"> </td>
			<td height="14" align="right"> </td>
		</tr>
		</table>
		<table width="768" border="0" cellpadding="0" cellspacing="0" background="/img/moneyf/box_bg_l.gif">
		<tr>
			<td align="center" valign="top" bgcolor="#FFFFFF"><img src="/img/moneyf/box_top_l.gif" width="768" height="9" ></td>
		</tr>
		<tr>
			<td height="20" align="center">



<?

/* get/post */
/* ######################################################################## */
$page                = trim(Request("page"));
/* ######################################################################## */

/* SEARCH */
//$where = " where regdate > '".date("Y-m")."'";
$where = " where (regdate > '".date("Y-m")."' or sell_mode='Y' or sell_date > '".date("Y-m")."') and expert_idx!=31412";


if($term_select){
	$mktime = mktime(0,0,0,date("m"),date("d")-$term_select,date("Y"));
	
	$where = " where regdate > '".date("Y-m-d",$mktime)."' ";
}

if($year && $month){
	$where = " where regdate like '".$year."-".$month."%' ";
}

if($srv_code){
	//전문가 idx 복호화
	$expert_idx = usrCrypt(URLdecode($srv_code),0);
	$where .= " and expert_idx='".$expert_idx."' ";
}

if($order_by=="rate"){
	$orderby="order by profit_rate desc, profit desc ";

}else if($order_by=="profit"){
	$orderby="order by profit desc, profit_rate desc ";

}else if($order_by=="sell_date"){
	$orderby="order by sell_mode asc, sell_date desc, profit desc, profit_rate desc ";

}else{
	$orderby="order by profit desc, profit_rate desc ";
}

$totalProfit = 0; //수익금 토탈(현물)
$totalProfitFutures = 0; //수익금 토탈 (선물)

/* 페이징 기본설정 */
if(!$page){ $page = 1 ; }
$pagePerNum = 40; // 한 페이지당 레코드 갯수
$indexPerPage = 10; // 한페이지에 표시될 인덱스 갯수
$searchSet ="&in_mode=$in_mode&srv_code=$srv_code&term_select=$term_select&year=$year&month=$month&search_mode=$search_mode";
$optionSet ="";
$pageURL = "";

/* 총 게시물수 구하기 */
// ▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧
/*
if($term_select){
	$query="select count(*) as num, sum(profit) as profit_sum from recommend_jongmok ".$where." ".$orderby." limit 40";
}else{
	$query="select count(*) as num, sum(profit) as profit_sum from recommend_jongmok ".$where;
}
*/
$query="select count(*) as num, sum(profit) as profit_sum from recommend_jongmok ".$where." ".$orderby." limit 40";
$result = mysql_query($query) or die(mysql_error());
$rs = mysql_fetch_array($result, MYSQL_ASSOC);
$totalCount = $rs[num];
$profit_sum = number_format($rs[profit_sum]);
$totalPage = ceil($totalCount/$pagePerNum) ; // 전체 회원(검색 회원)수
$start_p = $pagePerNum*($page-1); // 처음 시작페이지 지정

/*  카운터 추출 */
// ▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧▧
if($in_mode=="Y"){
	$counterWord = "<font style='color:red'>검색수 : $totalCount 개 &nbsp;,&nbsp; 현재 $page/$totalPage page</font>";
}else{
	$counterWord = "전체 : $totalCount 개 &nbsp;,&nbsp; 현재 $page/$totalPage page";
}

?>

		<TABLE width='750' cellpadding="0" cellspacing="0" border="0">
		<TR>
			<TD style='padding: 0 0 0 20' align=left>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="80px" valign="top"><img src="/img/profit/txtStock.gif"></td>

			
			<?php
			$sql = "SELECT A.userNickname,A.idx FROM Member A INNER JOIN recommend_jongmok B ON A.idx = B.expert_idx where A.idx not in 
				(12,
				 4143,
				 15384,
				 31412,
				 33813
				) GROUP BY B.expert_idx ORDER BY B.expert_idx ASC";
			$tmpRs = mysql_query($sql);
			while ($rs = mysql_fetch_array($tmpRs))
			{			 	
			?>
			<td align="left" valign="top" width="120px">
				<table id="<?=$rs[idx]?>" cellpadding="0" cellspacing="0" width="100%" border="0">
				<tr>
				<td align="left" valign="center" style='padding:0 0 0 20'>
					<img src="/img/profile/<?=$rs[idx]?>.gif" border="0" onclick="chkMem('cmbStock_<?=$rs[idx]?>')" onmouseover="this.style.cursor = 'hand'"><br>
					<input type="checkbox" name="cmbStock" id="cmbStock_<?=$rs[idx]?>" value="<?=$rs[idx]?>" <?php if (strstr($sMem,$rs[idx].",")!=""){echo " checked style='background-color:red;'";}?> disabled><?=$rs[userNickname]?> &nbsp; &nbsp;							
				</td>
				</tr>
				</table>			
			</td>
			<?php
			}
			?>
			<td></td>
</tr>
</table>			
			</td>
		</tr>
		<tr>
		<td height="10px"></td>
		</tr>
<!-- 현물과 선물 전문가 구분하는것 -->
		<tr>
		<td width="100%" height="1">
			<table width="100%" height="1px" cellpadding="0" cellspacing="0" border="0" background="/img/profit/bgLine.gif">
			<tr><td width="30px" height="1px"></td></tr>
			</table>
		</td>
		</tr>
<!-- 현물과 선물 전문가 구분하는것 -->		
		<tr>
		<td height="10px"></td>
		</tr>
		<TR>
			<TD style='padding: 0 0 0 20' align="left">
				
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="80px" valign="top"><img src="/img/profit/txtFutures.gif"></td>
			
			<?php
			$sql = "SELECT A.userNickname,A.idx FROM Member A INNER JOIN recommend_jongmok2 B ON A.idx = B.expert_idx where A.idx not in 
				(12,
				 4143,
				 15384,
				 31412,
				 33813,
				 34904
				) GROUP BY B.expert_idx ORDER BY B.expert_idx ASC";
			$tmpRs = mysql_query($sql);
			while ($rs = mysql_fetch_array($tmpRs))
			{
			?>
			<td align="left" valign="top" width="120px">
				<table id="<?=$rs[idx]?>" cellpadding="0" cellspacing="0" width="120" height="110">
				<tr>
				<td align="left" valign="top" style='padding:0 0 0 20'>
					<img src="/img/profile/<?=$rs[idx]?>.gif" border="0" onclick="chkMem('cmbFutures_<?=$rs[idx]?>')" onmouseover="this.style.cursor = 'hand'"><br>
					<input type="checkbox" name="cmbFutures" id="cmbFutures_<?=$rs[idx]?>" value="<?=$rs[idx]?>" <?php if (strstr($fMem,$rs[idx].",")!=""){echo " checked style='background-color:red;'";}?> disabled><?=$rs[userNickname]?> &nbsp; &nbsp;				
				</td>
				</tr>
				</table>			
			</td>
			<?php
			}			
			?>
			<td></td>
</tr>
</table>			
			</td>
		</tr>		
		


		<TR id="trPeriodShort">
			<TD style='padding: 0 0 0 20' align="left">
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr align="left">
			<td width="110px"><a href="javascript:getProfit('7','S')"><img src="/img/profit/01_1w.gif" hsrc="/img/profit/01_1w_s.gif" border="0"></a></td>
			<td width="110px"><a href="javascript:getProfit('30','S')"><img src="/img/profit/02_1m.gif" hsrc="/img/profit/02_1m_s.gif" border="0"></a></td>
			<td width="110px"><a href="javascript:getProfit('90','S')"><img src="/img/profit/03_3m.gif" hsrc="/img/profit/03_3m_s.gif" border="0"></a></td>
			<td width="110px"><a href="javascript:getProfit('180','S')"><img src="/img/profit/04_6m.gif" hsrc="/img/profit/04_6m_s.gif" border="0"></a></td>
			<td width="110px"><a href="javascript:getProfit('365','S')"><img src="/img/profit/05_1y.gif" hsrc="/img/profit/05_1y_s.gif" border="0"></a></td>
			<td></td>
			</tr>
			<tr><td colspan="6" height="20px"></td></tr>
			<TR>
			<TD colspan="6" align="left" valign="top">
			<select name="periodYear" id="periodYear" style="width:100px;height:50px;font-size:18px;font-weight:bold;">
			<option value="2011">2011
			<option value="2010">2010
			<option value="2009">2009			
			</select><img src="/img/profit/txtYear.gif" border="0">
			<select name="periodMonth" id="periodMonth" style="width:50px;height:50px;font-size:18px;font-weight:bold;">
			<option value="01">1
			<option value="02">2
			<option value="03">3
			<option value="04">4
			<option value="05">5
			<option value="06">6
			<option value="07">7
			<option value="08">8
			<option value="09">9
			<option value="10">10
			<option value="11">11
			<option value="12">12			
			</select><img src="/img/profit/txtMonth.gif" border="0">
			&nbsp;
			~
			&nbsp;
			<select name="periodYear2" id="periodYear2" style="width:100px;height:50px;font-size:18px;font-weight:bold;">
			<option value="2011">2011
			<option value="2010">2010
			<option value="2009">2009			
			</select><img src="/img/profit/txtYear.gif" border="0">
			<select name="periodMonth2" id="periodMonth2" style="width:50px;height:50px;font-size:18px;font-weight:bold;">
			<option value="01">1
			<option value="02">2
			<option value="03">3
			<option value="04">4
			<option value="05">5
			<option value="06">6
			<option value="07">7
			<option value="08">8
			<option value="09">9
			<option value="10">10
			<option value="11">11
			<option value="12">12			
			</select><img src="/img/profit/txtMonth.gif" border="0">
			&nbsp;
			<a href="javascript:getProfit('00','L')"><img src="/img/profit/periodSearch.gif" hsrc="/img/profit/periodSearch_s.gif" border="0"></a>
			
			</td>
		</tr>
		<tr><td colspan="6" height="20px"></td></tr>
			</table>			
			
			</td>
		</tr>
		

		</table>
		
			</td>
		</tr>
		<tr>
		<td>
<!-- 여기부터 그래프 시작 -->
<br>
<iframe name="invFrame" src="examples/502ProfitChart.html?sMem=<?=$sMem?>&fMem=<?=$fMem?>&searchMode=<?=$searchMode?>&sPeriod=<?=$sPeriod?>&lStart=<?=$LStart?>&lend=<?=$LEnd?>" width="740px" height="290px" frameborder="0"></iframe>
<br>
<!-- 여기부터 그래프 끝 -->
		</td>
		</tr>
		<tr>
			<td valign="top">
				<table width="100%" height="15" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>					
					<?php
					$stockMember = substr($sMem,0,strlen($sMem)-1);
					$futuresMember = substr($fMem,0,strlen($fMem)-1);
					$searchPeriod = $sPeriod;
					$searchStart = $LStart;
					$searchEnd = $LEnd;
					
					//전문가 선택 안 했을 때 
					if($sMem == "" && $fMem=="")
					{
					?>
					
					
						
					<?php
					
						
					}
					else 
					{
					?>
					
					<?php

					//전문가 선택 안 햇을 때
					
					
					//현물,선물 간편 검색 쿼리
					if($searchMode=="S")
					{
					//현물
					$sql = 
					"					
					SELECT A.userNickname,B.expert_idx,B.jongmok,B.recommend_price,B.sell_date,B.sell_price,B.gravity,B.profit,B.profit_rate,B.regdate,B.method,B.sell_mode 
					FROM Member A INNER JOIN recommend_jongmok B
					ON A.idx = B.expert_idx
					WHERE B.expert_idx IN ($stockMember) AND B.regdate BETWEEN DATE_SUB('$nowDate', INTERVAL $searchPeriod DAY) AND '$nowDate'
					order by B.regdate desc
					";
					//echo $sql;				
										
					//선물
					$sql2 = "
					select A.userNickname,B.expert_idx,B.buy_date,B.sell_date,B.profit_point,B.profit,B.method,B.regdate from Member A inner join recommend_jongmok2 B
					ON A.idx = B.expert_idx
					where B.expert_idx in ($futuresMember) 
					AND B.regdate BETWEEN DATE_SUB('$nowDate', INTERVAL $searchPeriod DAY) AND '$nowDate'
					Order by B.regdate DESC
					";
					
					
					?>
						<table width='740' cellpadding="0" cellspacing="0" border="0">
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<tr height=1><td bgcolor='#FFFFFF' colspan=21></td></tr>
						<tr align="center">
						<td>전문가</td>
						<td>추천주</td>
						<td>추천일</td>
						<td>추천가격</td>
						<td>매도일</td>
						<td>매도가격<br>(현재가)</td>
						<td>비중</td>
						<td>수익률<br>(수수료포함)</td>
						<td>수익금</td>
						<td>비고</td>
						</tr>
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<?php
						$tmpRs = mysql_query($sql);
						if(mysql_num_rows($tmpRs) == 0)
						{
							echo "<tr><td colspan='21' align='center' height='50'>등록 된 현물 수익률이 없습니다</td></tr>";
							echo "<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>";
						}
						else 
						{
							while ($rs = mysql_fetch_array($tmpRs)) 
							{
								if($rs[sell_mode]=="Y"){
									$sell_date="보유중";
									$sell_price="*****";
								}else{
									$sell_date=str_replace("-",".",substr($rs[sell_date],2,8));
									$sell_price=number_format($rs[sell_price]);
								}			
								if($rs[profit] > 0){
									$font_color="<font color='red'>";
									$font_color2="</font>";
						
								}else if($rs[profit]==0){
									$font_color="";
									$font_color2="";
						
								}else{
									$font_color="<font color='blue'>";
									$font_color2="</font>";
								}		
								?>
								<tr align="center">	
								<td><?=$rs[userNickname]?></td>
								<td><?=$rs[jongmok]?></td>
								<td><?=str_replace("-",".",substr($rs[regdate],2,8))?></td>
								<td><?=number_format($rs[recommend_price])?>원</td>
								<td><?=$sell_date?></td>
								<td><?=$sell_price?>원</td>
								<td><?=$rs[gravity]?>%</td>
								<td><?=$font_color.$rs[profit_rate]?>%<?=$font_color2?></td>
								<td><?=$font_color.number_format($rs[profit])?>원<?=$font_color2?></td>
								<td><?=$_PROFIT_RECOMMEND_METHOD[$rs[method]]?></td>
								</tr>
								<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
									<?php
									$totalProfit += $rs[profit];
							}
						}
						?>
						<tr align="center">
						<td colspan="8"><b>합  계 : </b></td>
						<td colspan="2"><b><?=number_format($totalProfit)?>원 (<?=number_format($totalProfit/100000000*100)?>%)</b></td>
						</tr>
						<tr height=2><td bgcolor='#C0C0C0' colspan=21></td></tr>
						</table>					
					
					<!-- 여기부터는 선물 -->
					<?php
					if($fMem)
					{
					?>
						<table width='740' cellpadding="0" cellspacing="0" border="0">
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<tr height=1><td bgcolor='#FFFFFF' colspan=21></td></tr>
						<tr align="center">
						<td>전문가</td>
						<td>수익포인트</td>
						<td>진입일</td>
						<td>청산일</td>
						<td>비중5계약</td>
						<td>수익금(만원)</td>
						<td>비고</td>
						</tr>
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<?php		
						$tmpRs = mysql_query($sql2);
						if(mysql_num_rows($tmpRs) == 0)
						{
							echo "<tr><td colspan='21' align='center' height='50'>등록 된 선물 수익률이 없습니다</td></tr>";
							echo "<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>";
						}
						else 
						{
							while ($rs = mysql_fetch_array($tmpRs)) 
							{
								if($rs[sell_mode]=="Y"){
									$sell_date="보유중";
								}else{
									$sell_date=str_replace("-",".",substr($rs[sell_date],2,8));
								}
						
								if($rs[profit] > 0){
									$font_color="<font color='red'>";
									$font_color2="</font>";
						
								}else if($rs[profit]==0){
									$font_color="";
									$font_color2="";
						
								}else{
									$font_color="<font color='blue'>";
									$font_color2="</font>";
								}
						
								if($count == 1){
									$num_color="<img src='/img/etc/icon_gold.gif' border='0' align='absmiddle'>";
						
								}else if($count == 2){
									$num_color="<img src='/img/etc/icon_silver.gif' border='0' align='absmiddle'>";
						
								}else if($count == 3){
									$num_color="<img src='/img/etc/icon_bronze.gif' border='0' align='absmiddle'>";
						
								}else{
									$num_color=$count;
								}				
							?>
							<tr align="center">	
							<td><?=$rs[userNickname]?></td>
							<td><?=$rs[profit_point]?></td>
							<td><?=str_replace("-",".",substr($rs[buy_date],2,8))?></td>
							<td><?=$sell_date?></td>
							<td>5</td>
							<td align="right" style="padding-right:10px"><?=$font_color.$rs[profit].$font_color2?></td>
							<td><?=$_PROFIT_RECOMMEND_METHOD[$rs[method]]?></td>
							</tr>
							<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
								<?php
								$totalProfitFutures += ($rs[profit]*10000);
							}
						}
						?>
						<tr align="center">
						<td colspan="8"><b>합  계 : </b></td>
						<td colspan="2"><b><?=number_format($totalProfitFutures)?>원 (<?=number_format($totalProfitFutures/100000000*100)?>%)</b></td>
						</tr>
						<tr height=2><td bgcolor='#C0C0C0' colspan=21></td></tr>
						</table>
					<!-- 여기까지는 선물 -->
					
					<?php		
						} //선물 전문가 선택하면 나온다
					}
					else 
					{					
					//현물 상세 검색 쿼리					
					$sql = "
					SELECT A.userNickname,B.expert_idx,B.jongmok,B.recommend_price,B.sell_date,B.sell_price,B.gravity,B.profit,B.profit_rate,B.regdate,B.method,B.sell_mode 
					FROM Member A INNER JOIN recommend_jongmok B
					ON A.idx = B.expert_idx
					where B.expert_idx in ($stockMember) 
					AND B.regdate BETWEEN '$searchStart' and '$searchEnd'
					Order by B.regdate desc
					";					
//					echo "<br>";
//					echo "<br>";
//					echo $sql;
//					echo "<br>";
//					echo "<br>";

					
					//선물
					$sql2 = "
					select A.userNickname,B.expert_idx,B.buy_date,B.sell_date,B.profit_point,B.profit,B.method,B.regdate from Member A inner join recommend_jongmok2 B
					ON A.idx = B.expert_idx
					where B.expert_idx in ($futuresMember) 
					AND B.regdate BETWEEN '$searchStart' and '$searchEnd'";
					
					
//					echo "<br>";
//					echo "<br>";
					
					if($sMem)
					{
					?>
						<table width='740' cellpadding="0" cellspacing="0" border="0">
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<tr height=1><td bgcolor='#FFFFFF' colspan=21></td></tr>
						<tr align="center">
						<td>전문가</td>
						<td>추천주</td>
						<td>추천일</td>
						<td>추천가격</td>
						<td>매도일</td>
						<td>매도가격<br>(현재가)</td>
						<td>비중</td>
						<td>수익률<br>(수수료포함)</td>
						<td>수익금</td>
						<td>비고</td>
						</tr>
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<?php
						$tmpRs = mysql_query($sql);
						if(mysql_num_rows($tmpRs) == 0)
						{
							echo "<tr><td colspan='21' align='center' height='50'>등록 된 현물 수익률이 없습니다</td></tr>";
							echo "<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>";
						}
						else 
						{
							while ($rs = mysql_fetch_array($tmpRs)) 
							{
							if($rs[sell_mode]=="Y"){
								$sell_date="보유중";
								$sell_price="*****";
							}else{
								$sell_date=str_replace("-",".",substr($rs[sell_date],2,8));
								$sell_price=number_format($rs[sell_price]);
							}			
							if($rs[profit] > 0){
								$font_color="<font color='red'>";
								$font_color2="</font>";
					
							}else if($rs[profit]==0){
								$font_color="";
								$font_color2="";
					
							}else{
								$font_color="<font color='blue'>";
								$font_color2="</font>";
							}		
							?>
							<tr align="center">	
							<td><?=$rs[userNickname]?></td>
							<td><?=$rs[jongmok]?></td>
							<td><?=str_replace("-",".",substr($rs[regdate],2,8))?></td>
							<td><?=number_format($rs[recommend_price])?>원</td>
							<td><?=$sell_date?></td>
							<td><?=$sell_price?>원</td>
							<td><?=$rs[gravity]?>%</td>
							<td><?=$font_color.$rs[profit_rate]?>%<?=$font_color2?></td>
							<td><?=$font_color.number_format($rs[profit])?>원<?=$font_color2?></td>
							<td><?=$_PROFIT_RECOMMEND_METHOD[$rs[method]]?></td>
							</tr>
							<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
								<?php
								$totalProfit += $rs[profit];
							}
						}
						?>
						<tr align="center">
						<td colspan="8"><b>합  계 : </b></td>
						<td colspan="2"><b><?=number_format($totalProfit)?>원 (<?=number_format($totalProfit/100000000*100)?>%)</b></td>
						</tr>
						</table>					
					<?php
					}
					?>
					<?php
					if($fMem)
					{
					?>
					<!-- 여기부터는 선물 -->
						<table width='740' cellpadding="0" cellspacing="0" border="0">
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<tr height=1><td bgcolor='#FFFFFF' colspan=21></td></tr>
						<tr align="center">
						<td>전문가</td>
						<td>수익포인트</td>
						<td>진입일</td>
						<td>청산일</td>
						<td>비중5계약</td>
						<td>수익금(만원)</td>
						<td>비고</td>
						</tr>
						<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
						<?php		
						$tmpRs = mysql_query($sql2);
						if(mysql_num_rows($tmpRs) == 0)
						{
							echo "<tr><td colspan='21' align='center' height='50'>등록 된 선물 수익률이 없습니다</td></tr>";
							echo "<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>";
						}
						else 
						{
							while ($rs = mysql_fetch_array($tmpRs)) 
							{
								if($rs[sell_mode]=="Y"){
									$sell_date="보유중";
								}else{
									$sell_date=str_replace("-",".",substr($rs[sell_date],2,8));
								}
						
								if($rs[profit] > 0){
									$font_color="<font color='red'>";
									$font_color2="</font>";
						
								}else if($rs[profit]==0){
									$font_color="";
									$font_color2="";
						
								}else{
									$font_color="<font color='blue'>";
									$font_color2="</font>";
								}
						
								if($count == 1){
									$num_color="<img src='/img/etc/icon_gold.gif' border='0' align='absmiddle'>";
						
								}else if($count == 2){
									$num_color="<img src='/img/etc/icon_silver.gif' border='0' align='absmiddle'>";
						
								}else if($count == 3){
									$num_color="<img src='/img/etc/icon_bronze.gif' border='0' align='absmiddle'>";
						
								}else{
									$num_color=$count;
								}				
							?>
							<tr align="center">	
							<td><?=$rs[userNickname]?></td>
							<td><?=$rs[profit_point]?></td>
							<td><?=str_replace("-",".",substr($rs[buy_date],2,8))?></td>
							<td><?=$sell_date?></td>
							<td>5</td>
							<td align="right" style="padding-right:10px"><?=$font_color.$rs[profit].$font_color2?></td>
							<td><?=$_PROFIT_RECOMMEND_METHOD[$rs[method]]?></td>
							</tr>
							<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
								<?php
								$totalProfitFutures += ($rs[profit]*10000);
							}
						}
						?>
						<tr align="center">
						<td colspan="8"><b>합  계 : </b></td>
						<td colspan="2"><b><?=number_format($totalProfitFutures)?>원 (<?=number_format($totalProfitFutures/100000000*100)?>%)</b></td>
						</tr>
						</table>
					<!-- 여기까지는 선물 -->
					<?php
					}
					}
					}
					?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><img src="/img/moneyf/box_btm_l.gif" width="768" height="9"></td>
		</tr>
		</table>
	</td>
</tr>

<tr>
	<td height="16" colspan="2" valign="top"> </td>
	<td width="150" height="16" align="right" valign="top"> </td>
</tr>
</table>

<? include_once $_SERVER['DOCUMENT_ROOT']."/include/in_foot.html" ?>


<form name="form1" method="POST" target="_self" action="lani_profit.php">
<input type="hidden" name="sMem" id="sMem" size="20" value="<?=$sMem?>"><br>
<input type="hidden" name="fMem" id="fMem" size="20" value="<?=$fMem?>"><br>
<input type="hidden" name="sPeriod" id="sPeriod" size="20" value="<?=$sPeriod?>"><br>
<input type="hidden" name="LStart" id="LStart" size="20" value="<?=$LStart?>"><br>
<input type="hidden" name="LEnd" id="LEnd" size="20" value="<?=$LEnd?>"><br>
<input type="hidden" name="searchMode" id="searchMode" size="20" value="<?=$searchMode?>"><br>
</form>

<script type="text/javascript">
<!--
			function init() {
			if (!document.getElementById) return
			var imgOriginSrc;
			var imgTemp = new Array();
			var imgarr = document.getElementsByTagName('img');
			for (var i = 0; i < imgarr.length; i++) {
			if (imgarr[i].getAttribute('hsrc')) {
			imgTemp[i] = new Image();
			imgTemp[i].src = imgarr[i].getAttribute('hsrc');
			imgarr[i].onmouseover = function() {
			imgOriginSrc = this.getAttribute('src');
			this.setAttribute('src',this.getAttribute('hsrc')) }
			imgarr[i].onmouseout = function() {
			this.setAttribute('src',imgOriginSrc) }
			    }
			  }
			}
			onload=init;

		function chkMem(id)
		{
			var c = document.getElementById(id);
			if(c.checked)
			{
				c.checked = false;
				c.style.backgroundColor = "white";
				
			}
			else
			{
				c.checked = true;
				c.style.backgroundColor = "red";
			}
			
		}

function getProfit(value,mode)
{
	//현물 선물 전문가를 가져온다
	var S = document.getElementsByName("cmbStock");
	var F = document.getElementsByName("cmbFutures");
	var stockCnt = 0;
	var futuresCnt = 0;
	var sMem = "";
	var fMem = "";
	var period = 0;
	
	//현물 전문가 가져오기
	for(var i = 0 ; i < S.length ; i++)
	{
		if(S[i].checked)
		{
			sMem += S[i].value+",";
			stockCnt++;
		}
	}
	
	//선물 전문가 가져오기
	for(var i = 0 ; i < F.length ; i++)
	{
		if(F[i].checked)
		{
			fMem += F[i].value+",";
			futuresCnt++;
		}
	}
	
	//전문가 선택 했는지 체크
	if(stockCnt == 0 && futuresCnt == 0)
	{
		alert('전문가를 선택 해 주세요');
		return;		
	}
	
	if(mode == "S") //간단 검색
	{
		document.getElementById("sMem").value = sMem;
		document.getElementById("fMem").value = fMem;
		
		document.getElementById("sPeriod").value = value;
		
		document.getElementById("LStart").value = "";
		document.getElementById("LEnd").value = "";
		document.getElementById("searchMode").value = "S";
	}
	else //상세 검색
	{
		document.getElementById("sPeriod").value = "";
		
		document.getElementById("sMem").value = sMem;
		document.getElementById("fMem").value = fMem;
		document.getElementById("LStart").value = document.getElementById("periodYear").value+"-"+document.getElementById("periodMonth").value+"-01";
		document.getElementById("LEnd").value = document.getElementById("periodYear2").value+"-"+document.getElementById("periodMonth2").value+"-31";
		document.getElementById("searchMode").value = "L";
	}	
	
	var f = document.form1;
	f.submit();
-->	
}
</script>


</body>
</html>