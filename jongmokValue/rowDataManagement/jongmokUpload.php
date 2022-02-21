<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
신규종목의 적정주가를 입력합니다.
data[0] = 종목 코드
data[1] = 종목 이름
data[2] = 적정주가
data[3] = 코스피,코스닥구분 (KOSPI,KOSDAQ)
data[4] = 수정적정주가(0.125??)
data[5] = 무료종목여부(T,F)
data[6] = 업종
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //첫 행은 설명이 들어있기 때문에 무시한다. 
        
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {        	
        	$name = addslashes(trim($data[0]));
        	$code = addslashes(trim($data[1]));
        	$value = addslashes(trim($data[2]));
        	$industry = addslashes(trim($data[3]));        	
        	$adjustValue = addslashes(trim($data[4]));
        	$type = addslashes(trim($data[5]));        	
        	$freeFlag = "F"; //20170822 어윤학 작업
        	
        		$sql="insert into jongmokValue(code,name,value,type,updateDate,adjustValue,freeFlag,industry) values('$code','$name',$value,'$type',now(),$adjustValue,'$freeFlag','$industry')";
        		echo $sql."<br>";
        		
        		mysql_query($sql);
        	
        } 
        
        $rowCnt++;
    } while ($data = fgetcsv($handle,1000,",","'")); 
    // 

    //redirect 
    //header('Location: import.php?success=1'); die; 
    echo " 종목 추가 완료";

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
종목을 추가합니다. 파일을 선택 해 주세요. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  파일은 *.csv 형식이며 다음의 양식을 따릅니다.
  
  종목       | 코드    |  적정주가  | 업종       | 수정적정주가 | 구분
  삼성전자 | 005930 | 1650000    | 전기전자 |   0.025           | KOSPI
  
  </pre>
  
</form> 

</body> 
</html> 