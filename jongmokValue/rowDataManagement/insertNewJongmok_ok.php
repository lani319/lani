<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//�ű� ������ �����ְ��� ����ϴ� ȭ���Դϴ�. 



 
 
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
$txtName  = "�Ｚ����";
$txtCode  = "005930";
$cmbTypeKospi ="��������";
$cmbTypeKosdaq ;
$txtCurrentPrice ="1338000"; //���簡
$txtStockAmount ="147299000"; //�����ֽ��Ѽ�
$txtCurrentJachong ="1739366"; //�ں��Ѱ�
$txtMajorAmount ="1"; //�������
$txtForeignAmount="0";  //���μ���
$cmbStockDirection="0.125";  //�����߼�
$cmbTypeDirection="-0.125" ; //�����߼�
$cmbType ="KOSPI"; //���� ����
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
 
 if($cmbType=="KOSPI"){	//�ڽ����� ��� ���� * 1.5
	$val1 = 1.5;
	$stockType = $cmbTypeKospi;
 }
 else{
	$val1 = 2.5; //�ڽ����� ��� ���� * 2.5
	$stockType = $cmbTypeKosdaq;
 } 
	 $SVal = round(($txtCurrentJachong * $val1) /(($txtCurrentPrice*$txtStockAmount)*0.00000001),2) ;
	 echo $SVal."<br>";
	 
	 $SVal = round($SVal * $txtCurrentPrice,0);
	 echo $SVal."<br>";
	 
	 
	 //������ ���� �߼� ��
	 $modiValue1 = $cmbStockDirection + $cmbTypeDirection;
	 
	 echo $modiValue1."<br>";	 
	 
	 //���� �ݿ� ��
	 $modiValue2 = 0;	 	 
	 
	 if($modiValue1 == 0.25){ //������ ������ ��� ����϶�
		 if($txtMajorAmount>$txtForeignAmount){
		 $modiValue2 = -0.125;
		}
		else{
			$modiValue2 =0;
		}
	 }else if($modiValue1 == -0.25){//������ ������ ��� �϶��϶�
	 
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
		
	//���⿡ ���������� �� ������ ���Եȴ�.
    echo "���� �߰� �Ϸ�";
			
?>
