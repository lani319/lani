<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";



/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
�����, ����, ���������� �����Ѵ�. 
data[0] = ���� �̸�
data[1] = ���� �ڵ�
data[2] = ���� ����
data[3] = ���� ��������
data[4] = ���簡 
data[5] = ���� //20180221 �����̳� ������ �߰�
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    	$file = $_FILES[csv][tmp_name]; 
    	$handle = fopen($file,"r"); 
	$rowCnt = 0; //ù ���� ������ ����ֱ� ������ �����Ѵ�. 
	$changeCnt = 0;        
        		
    //loop through the csv file and insert into database 
    do { 
    	
        if ($data[0] && $rowCnt > 1) {
        	
        	$name = addslashes(trim($data[0]));
        	$code = addslashes(trim($data[1]));
			$code = addslashes(str_replace("A","",$code));
        	$value = addslashes(trim($data[2]));
        	$adjustValue = addslashes(trim($data[3]));
		$currentValue = addslashes(trim($data[4]));	
		$industry = addslashes(trim($data[5]));			
        	
        	
        		$sql="update jongmokValue set name = '$name', value = '$value', adjustValue = '$adjustValue', currentValue='$currentValue', industry='$industry', currentDate = now() where code='$code' ";
        		echo $sql."<br>";
				
				
				//exit;
				
        		mysql_query($sql);
        		echo mysql_affected_rows()."<br>";
        		
        		if(mysql_affected_rows() == 1)
        		{
        			$sql = "update jongmokValue set updateDate = now() where code='$code'";
        			mysql_query($sql);        			
        			$changeCnt++;	
        			
        		}
        } 
        $rowCnt++;
        
    } while ($data = fgetcsv($handle,1000,",","'")); 
    // 

    //redirect 
    //header('Location: import.php?success=1'); die; 
    echo $changeCnt." ���� ���� �Ϸ�";

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
�����ְ��� �����մϴ�. ������ ���� �� �ּ���. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  ������ *.csv �����̸� ������ ����� �����ϴ�.  
 �����| �ڵ�    | �����ְ� | �������� | ���簡 | ����(, ����)
  
  
  </pre>
  
</form> 

</body> 
</html> 