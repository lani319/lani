<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
���� ���� �� �� csv ������ ���ε��ؼ� ��ģ��.
data[0] = �ڽ���,�ڽ��� ����. KOSPI, KOSDAQ
data[1] = ����,���� �̸�. ���������� ��� ��
data[2] = ���� �ڵ�. ���񿡼��� ��� ��
data[3] = ���� ��. ��ü ������ �⺻���� �� �־�� ��. ������ �����ؾ� �� ���� ������ �߰�. 

�˰���)
1. ��� ������ ���� ������ �ʱ�ȭ �Ѵ�. 
2. ������ �о�´�. 
3. ������ �ڽ���,�ڽ������� �����Ѵ�. 
4. ������ ���� �ִ´�. 
5. ���� �̿ܿ� ���� �� ������ ������ ���� �ڵ忡 ���� ���� �����Ѵ�. 
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //ù ���� ������ ����ֱ� ������ �����Ѵ�. 
    
    //�ʱ�ȭ, ���� ���� �ʱ�ȭ �Ѵ�. 
    $sql = "update jongmokValue set adjustValue=0";
    echo $sql."<br>";
    mysql_query($sql);
     
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {
        	if(!$data[2]){ //�ڵ尡 ������ ��, �����̸�
        		$sql="update jongmokValue set adjustValue=".addslashes(trim($data[3]))." where industry='".addslashes(trim($data[1]))."' and type='".addslashes(trim($data[0]))."'";
        		echo $sql."<br>";
        		mysql_query($sql);
        	}
        	else{ //�����̸�
       		$sql="update jongmokValue set adjustValue=".addslashes(trim($data[3]))." where code='".addslashes(trim($data[2]))."'";
	        	echo $sql."<br>";
	        	mysql_query($sql);
        	}
        } 
        
        $rowCnt++;
    } while ($data = fgetcsv($handle,1000,",","'")); 
    // 

    //redirect 
    //header('Location: import.php?success=1'); die; 
    echo $rowCnt+"�� ���� �����ְ� ���� �Ϸ�";

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
  
  ��   �� | �̸�       |  �ڵ�   | ��    
  KOSPI | �Ǽ�       |           | 0.125 (������ ���)
  KOSPI | �Ｚ���� | 005930 | 0.25 (������ ���)  
  
  </pre>
  
</form> 

</body> 
</html> 