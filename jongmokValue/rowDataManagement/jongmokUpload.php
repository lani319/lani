<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
�ű������� �����ְ��� �Է��մϴ�.
data[0] = ���� �ڵ�
data[1] = ���� �̸�
data[2] = �����ְ�
data[3] = �ڽ���,�ڽ��ڱ��� (KOSPI,KOSDAQ)
data[4] = ���������ְ�(0.125??)
data[5] = �������񿩺�(T,F)
data[6] = ����
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //ù ���� ������ ����ֱ� ������ �����Ѵ�. 
        
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {        	
        	$name = addslashes(trim($data[0]));
        	$code = addslashes(trim($data[1]));
        	$value = addslashes(trim($data[2]));
        	$industry = addslashes(trim($data[3]));        	
        	$adjustValue = addslashes(trim($data[4]));
        	$type = addslashes(trim($data[5]));        	
        	$freeFlag = "F"; //20170822 ������ �۾�
        	
        		$sql="insert into jongmokValue(code,name,value,type,updateDate,adjustValue,freeFlag,industry) values('$code','$name',$value,'$type',now(),$adjustValue,'$freeFlag','$industry')";
        		echo $sql."<br>";
        		
        		mysql_query($sql);
        	
        } 
        
        $rowCnt++;
    } while ($data = fgetcsv($handle,1000,",","'")); 
    // 

    //redirect 
    //header('Location: import.php?success=1'); die; 
    echo " ���� �߰� �Ϸ�";

} 

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
������ �߰��մϴ�. ������ ���� �� �ּ���. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  ������ *.csv �����̸� ������ ����� �����ϴ�.
  
  ����       | �ڵ�    |  �����ְ�  | ����       | ���������ְ� | ����
  �Ｚ���� | 005930 | 1650000    | �������� |   0.025           | KOSPI
  
  </pre>
  
</form> 

</body> 
</html> 