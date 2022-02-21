<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/board.config.php";

include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/admin_libs.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */

$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
$sql = "SELECT * FROM jongmokValue2016 where code ='A$code'";


$tmpRs = mysql_query($sql);
while($rs = mysql_fetch_array($tmpRs) ) { 
	
	$jongmokValue = "['".$rs["month1"]."',".$rs["value1"]."],['".$rs["month2"]."',".$rs["value2"]."],['".$rs["month3"]."',".$rs["value3"]."],['".$rs["month4"]."',".$rs["value4"]."],['".$rs["month5"]."',".$rs["value5"]."]";
	
	//$jongmokValue = "[1,".$rs["value1"]."],[2,".$rs["value2"]."],[3,".$rs["value3"]."],[4,".$rs["value4"]."],[5,".$rs["value5"]."]";
	
	
	
}



  $strTitle = iconv("UTF-8", "EUC-KR", "적정주가 추이");  
  $strOption1 = iconv("UTF-8", "EUC-KR", "월");
  $strOption2 = iconv("UTF-8", "EUC-KR", "적정주가(월)");  
  
  //['15/06',9070,15400],['15/06',9070,15400],['15/06',9070,15400]
  
// echo $jongmokValue; 
?>
  
  <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
		google.charts.setOnLoadCallback(drawCrosshairs);

      function drawCrosshairs() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', '<?=$code?>');      

      data.addRows([
        <?=$jongmokValue?>
      ]);

      var options = {
        hAxis: {
          title: ''
        },
        vAxis: {
          title: ''
        },
        colors: ['#a52714', '#097138'],
        crosshair: {
          color: '#000',
          trigger: 'selection'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
      chart.setSelection([{row: 38, column: 1}]);

    }
    </script>
  </head>
  <body style="topmargin=0; leftmargin=0;" align="left">
     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div" style="width: 640px; height: 400px; topmargin=0;leftmargin=0" ></div>
  </body>
</html>