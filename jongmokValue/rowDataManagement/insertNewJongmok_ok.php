<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//신규 종목의 적정주가를 등록하는 화면입니다. 



 
 
$txtName=$_POST['txtName'];
$txtCode=$_POST['txtCode'];
$cmbTypeKospi=$_POST['cmbTypeKospi'];
$cmbTypeKosdaq=$_POST['cmbTypeKosdaq'];
$txtCurrentPrice=$_POST['txtCurrentPrice'];
$txtStockAmount=$_POST['txtStockAmount'];
$txtStockAmount=$txtStockAmount*1000;
$txtCurrentJachong=$_POST['txtCurrentJachong'];
$txtMajorAmount=$_POST['txtMajorAmount'];
$txtForeignAmount=$_POST['txtForeignAmount'];
$cmbStockDirection=$_POST['cmbStockDirection'];
$cmbTypeDirection=$_POST['cmbTypeDirection'];
$cmbType=$_POST['cmbType'];

/*
$txtName  = "삼성전자";
$txtCode  = "005930";
$cmbTypeKospi ="전기전자";
$cmbTypeKosdaq ;
$txtCurrentPrice ="1338000"; //현재가
$txtStockAmount ="147299000"; //발행주식총수
$txtCurrentJachong ="1739366"; //자본총계
$txtMajorAmount ="1"; //기관수급
$txtForeignAmount="0";  //외인수급
$cmbStockDirection="0.125";  //지수추세
$cmbTypeDirection="-0.125" ; //업종추세
$cmbType ="KOSPI"; //시장 구분
*/

echo  $txtName ."<br>";
echo   $txtCode  ."<br>";
 echo  $cmbTypeKospi  ."<br>";
 echo  $cmbTypeKosdaq  ."<br>";
 echo  $txtCurrentPrice  ."<br>";
 echo  $txtStockAmount  ."<br>";
 echo  $txtCurrentJachong  ."<br>";
 echo  $txtMajorAmount  ."<br>";
 echo  $txtForeignAmount ."<br>";
 echo  $cmbStockDirection ."<br>";
 echo  $cmbTypeDirection  ."<br>";
 echo  $cmbType ;
 
 
 echo "<br><br><br>";
 
 
 $val1 = 0;
 
 $stockType = "";
 
 if($cmbType=="KOSPI"){	//코스피일 경우 자총 * 1.5
	$val1 = 1.5;
	$stockType = $cmbTypeKospi;
 }
 else{
	$val1 = 2.5; //코스피일 경우 자총 * 2.5
	$stockType = $cmbTypeKosdaq;
 } 
	 $SVal = round(($txtCurrentJachong * $val1) /(($txtCurrentPrice*$txtStockAmount)*0.00000001),2) ;
	 echo $SVal."<br>";
	 
	 $SVal = round($SVal * $txtCurrentPrice,0);
	 echo $SVal."<br>";
	 
	 
	 //지수와 업종 추세 값
	 $modiValue1 = $cmbStockDirection + $cmbTypeDirection;
	 
	 echo $modiValue1."<br>";	 
	 
	 //수급 반영 값
	 $modiValue2 = 0;	 	 
	 
	 if($modiValue1 == 0.25){ //지수와 업종이 모두 상승일때
		 if($txtMajorAmount>$txtForeignAmount){
		 $modiValue2 = -0.125;
		}
		else{
			$modiValue2 =0;
		}
	 }else if($modiValue1 == -0.25){//지수와 업종이 모두 하락일때
	 
		 if($txtMajorAmount>$txtForeignAmountAmount){
		 $modiValue2 = +0.125;
		}
		else{
			$modiValue2 =0;
		}
	 }
	 
	 echo $modiValue2."<br>";
	 
	 
	 
	 $finalModivalue = $modiValue1+$modiValue2;
	 $code = str_replace("A","",$txtCode);

	$sql="insert into jongmokValue(code,name,value,type,updateDate,adjustValue,freeFlag,industry) 
		values('$code','$txtName',$SVal,'$cmbType',now(),$finalModivalue,'F','$stockType')";
	echo $sql."<br>";
        		


				
	mysql_query($sql); 
		
	//여기에 투자전략에 들어갈 내용이 삽입된다.
    echo "종목 추가 완료";
			
?>
