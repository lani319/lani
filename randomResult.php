<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* 충전금액과 잔고 가져오기 */

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$numStart = $txtStart;
$numEnd = $txtEnd;
$numCount = $txtCnt;

/*
echo $numStart;

echo "<br>";

echo $numEnd;
echo "<br>";
echo "<br>";
echo getRandNum($numStart,$numEnd);

*/


$result[0] = $txt01;
$result[1] = $txt02;
$result[2] = $txt03;
$result[3] = $txt04;
$result[4] = $txt05;

$result[5] = $txt06;
$result[6] = $txt07;
$result[7] = $txt08;
$result[8] = $txt09;
$result[9] = $txt10;

function getRandNum($numStart,$numEnd)
{
	return rand($numStart,$numEnd);
}

$trueFlag = 0;
$tmpResult = 0;

for($i=0 ; $i<$numCount ; $i++){
	
	do{
		$tmpResult = getRandNum($numStart,$numEnd);
		for($j = 0 ; $j < 10 ; $j++){
			if($tmpResult != $result[$j])
			{
				$trueFlag = 1;
				
			}
		}
		
	}while($trueFlag == 0);
	
	echo $tmpResult;
	echo "<br>";
}









?>