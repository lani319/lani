<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";



/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
종목명, 가격, 수정비율을 갱신한다. 
data[0] = 종목 이름
data[1] = 종목 코드
data[2] = 종목 가격
data[3] = 종목 수정비율
data[4] = 현재가 
data[5] = 업종 //20180221 평택촌놈 어윤학 추가
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    	$file = $_FILES[csv][tmp_name]; 
    	$handle = fopen($file,"r"); 
	$rowCnt = 0; //첫 행은 설명이 들어있기 때문에 무시한다. 
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
    echo $changeCnt." 종목 갱신 완료";

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
적정주가를 갱신합니다. 파일을 선택 해 주세요. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  파일은 *.csv 형식이며 다음의 양식을 따릅니다.  
 종목명| 코드    | 적정주가 | 수정비율 | 현재가 | 업종(, 포함)
  
  
  </pre>
  
</form> 

</body> 
</html> 