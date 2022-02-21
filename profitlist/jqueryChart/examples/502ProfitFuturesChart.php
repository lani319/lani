<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/* SEARCH */
$where = " where sell_date >= '".date("Y-m")."' and  sell_mode='N' and expert_idx in(26439,3622)";

if($term_select){
	$mktime = mktime(0,0,0,date("m"),date("d")-$term_select,date("Y"));
	
	$where = " where sell_date >= '".date("Y-m-d",$mktime)."' and expert_idx in(26439,3622) and sell_mode='N'";
}

if($year && $month){
	$where = " where date_format(sell_date, '%Y-%m') = '".$year."-".$month."' and expert_idx in (26439,3622) and sell_mode='N'";
}

if($srv_code){
	//전문가 idx 복호화
	$expert_idx = usrCrypt(URLdecode($srv_code),0);
	$where .= " and expert_idx='".$expert_idx."' ";
}

$orderby = " order by sell_date ASC";

/* 페이징 기본설정 */
if(!$page){ $page = 1 ; }
$pagePerNum = 40; // 한 페이지당 레코드 갯수
$indexPerPage = 10; // 한페이지에 표시될 인덱스 갯수
$searchSet ="&in_mode=$in_mode&srv_code=$srv_code&term_select=$term_select&year=$year&month=$month&search_mode=$search_mode";
$optionSet ="";
$pageURL = "";

if($term_select == 30 || ($year && $month)){
	$sql="select (profit_point * 50) as profit, sell_date from recommend_jongmok2 ".$where." ".$orderby." limit 40";
}
else{
	$sql = "
	select sum(profit_point * 50) as profit,
		CASE FLOOR((DATE_FORMAT(sell_date, '%e') - 1) / 10)
			WHEN 0 THEN DATE_FORMAT(sell_date, '%Y-%m-01')
			WHEN 1 THEN DATE_FORMAT(sell_date, '%Y-%m-11')
			ELSE DATE_FORMAT(sell_date, '%Y-%m-21')
		END as sell_date
	from recommend_jongmok2
	$where
	group by sell_date
	$orderby";
}
//echo $sql;

$tmpRs = mysql_query($sql);
$yVal= "";
$xVal = "";
$num = 1; //가로축 순서
$totalProfit = 0;
$sellDate = "";
$divNum = 0; //나머지 구하는 번호

$rowNum = mysql_num_rows($tmpRs);
$divNum = ceil($rowNum / 10);

while($rs = mysql_fetch_array($tmpRs)){
	//데이터 렌더링 하는 부분  2011-06-16 어윤학 작업시작
	$totalProfit = $totalProfit + $rs[profit]; //단위 만원
	$yVal = $yVal."[$num,$totalProfit],";		//세로축에 표시되는 값

	$sellDate = substr($rs[sell_date],0,10);
	
	if ($sellDate == "0000-00-00" ){
		$sellDate = date("Y-m-d",time(0));
	}
	$num++;	
	if ($num%$divNum == 0){
		$xVal = $xVal."'$sellDate',";		//가로축에 표시되는 값
	}
	else{
		$xVal = $xVal."' ',";		//가로축에 표시되는 값    		
	}   
}
    	
$yVal = substr($yVal,0,strlen($yVal)-1);		//yValue
$xVal = substr($xVal,0,strlen($xVal)-1);		//xValue  
    	
    	    	
$expertImg = "profitChartTitle_all.gif";
switch ($expert_idx)
{
	case "312":
		$expertImg = "profitChartTitle_312.gif";
		break;
	case "26439":
		$expertImg = "profitChartTitle_26439.gif";
		break;
	case "17365":
		$expertImg = "profitChartTitle_17365.gif";
		break;
	case "3622":
		$expertImg = "profitChartTitle_3622.gif";
		break;
	case "29681":
		$expertImg = "profitChartTitle_29681.gif";
		break;								
}
?>
    
    
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Test 3</title>
		
		<!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
		  
		<link rel="stylesheet" type="text/css" href="../jquery.jqplot.css" />
  <link rel="stylesheet" type="text/css" href="examples.css" />
		
		<!-- BEGIN: load jquery -->
		<script language="javascript" type="text/javascript" src="../jquery-1.3.2.min.js"></script>
		<!-- END: load jquery -->
		
		<!-- BEGIN: load jqplot -->
		<script language="javascript" type="text/javascript" src="../jquery.jqplot.js"></script>
		<script language="javascript" type="text/javascript" src="../plugins/jqplot.categoryAxisRenderer.js"></script>
		<script language="javascript" type="text/javascript" src="../plugins/jqplot.barRenderer.js"></script>
		<!-- END: load jqplot -->

    
	<script type="text/javascript" language="javascript">
	/*
	[1,40] <- X 순서 , Y 값
	
	*/  
	
	
	$(document).ready(function(){
    line1 = [<?=$yVal?>]; 
    plot1 = $.jqplot('chart', [line1], {    
        series: [{label: '1st Qtr'}],
        axes: {
            xaxis: {
                ticks:[<?=$xVal?>],
                renderer: $.jqplot.CategoryAxisRenderer
            }
        }
    });
});

	</script>

	</head>
	<body style="padding : 0 0 0 0;">
	<table cellpadding="0" cellspacing="0" width="740" height="400">
	<tr>
		<td align="center" valign="top"><img src="/img/profit/<?=$expertImg?>">
    		
		</td>
	</tr>
	<tr>
		<td align="center">
			<div id="chart" style="margin-top:20px; margin-left:20px; width:700px; height:300px;"></div>    		
		</td>
	</tr>
	</table>
	</body>
</html>