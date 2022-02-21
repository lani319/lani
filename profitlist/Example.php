<?php
	//Include Class
	require_once('GoogleGraph.php');

	//Create Object
	$graph = new GoogleGraph();
	
	//Graph
	$graph->Graph->setType('bar');
	$graph->Graph->setSubtype('vertical_grouped');
	$graph->Graph->setSize(500, 500);
	$graph->Graph->setAxis(); //no arguments means all on
	$graph->Graph->setGridLines(20, 50, 1, 0);
	
	//Title
	$graph->Graph->setTitle('This is a test', '#FF0000', 50);	
	
	//Background
	$graph->Graph->addFill('chart', '#000000', 'solid');
	$graph->Graph->addFill('background', '#FFFFFF', 'gradient', '#000000', 90, 0.5, 0);
	
	//Axis Labels
	$graph->Graph->addAxisLabel(array('Jan', 'July', 'Jan', 'July', 'Jan'));
	$graph->Graph->addAxisLabel(array('0','100'));
	$graph->Graph->addAxisLabel(array('A', 'B', 'C'));
	$graph->Graph->addAxisLabel(array('2005', '2006', '2007'));	
	$graph->Graph->addLabelPosition(array(1, 10, 37, 75));
	$graph->Graph->addLabelPosition(array(2, 0, 1, 2, 4));		
	$graph->Graph->setAxisRange(array(0, 200, 300, 400));
	$graph->Graph->addAxisStyle(array(0, '#0000dd', 10));
	$graph->Graph->addAxisStyle(array(3, '#0000dd', 12, 1));	
	
	//Lines
	$graph->Graph->setLineColors(array('#FF0000', '#00FF00', '#0000FF'));
	$graph->Graph->addLineStyle(array(3, 6, 3));
	$graph->Graph->addLineStyle(array(1, 1, 0));
	
	//Shapes
	$graph->Graph->addShapeMarker(array('cross', '#FF0000', 0, 1, 20));
	$graph->Graph->addShapeMarker(array('diamond', '#80C65A', 0, 2, 20));	
	
	//Data	
	$graph->Data->addData(array(5, 10, 58, 95));
	$graph->Data->addData(array(5, 30, 8, 63));
	$graph->Data->addData(array(3, 17, 90, 4));
	
	//Output Graph
	$graph->printGraph();
?>