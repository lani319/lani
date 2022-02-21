<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/*
가격 수정 할 때 csv 파일을 업로드해서 고친다.
data[0] = 종목 코드
data[1] = 종목이름

알고리즘)
종목코드에 매칭되는 종목이름을 바꾼다.
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //첫 행은 설명이 들어있기 때문에 무시한다. 
    
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {
     //종목이면
       		$sql="update jongmokValue set name='".addslashes(trim($data[1]))."' where code='".addslashes(trim($data[0]))."'";
	        	echo $sql."<br>";
	        	mysql_query($sql);
        } 
        
        $rowCnt++;
    } while ($data = fgetcsv($handle,1000,",","'")); 
    //  

    //redirect 
    //header('Location: import.php?success=1'); die; 
    echo $rowCnt+"개 수정 적정주가 이름 수정 완료";

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
종목이름을 수정합니다. 파일을 선택 해 주세요. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  파일은 *.csv 형식이며 다음의 양식을 따릅니다.
  
  코드    |  이름   |
  
  005930 | 삼성전자 | 
  
  </pre>
  
</form> 

</body> 
</html> 