<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



/*
가격 수정 할 때 csv 파일을 업로드해서 고친다.
data[0] = 코스피,코스닥 구분. KOSPI, KOSDAQ
data[1] = 업종,종목 이름. 업종에서만 사용 됨
data[2] = 종목 코드. 종목에서만 사용 됨
data[3] = 수정 값. 전체 업종은 기본으로 다 넣어야 함. 종목은 수정해야 할 것이 있으면 추가. 

알고리즘)
1. 모든 종목의 조정 가격을 초기화 한다. 
2. 파일을 읽어온다. 
3. 업종이 코스피,코스닥인지 구분한다. 
4. 업종별 값을 넣는다. 
5. 업종 이외에 수정 할 종목이 있으면 종목 코드에 따라 값을 수정한다. 
*/

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //첫 행은 설명이 들어있기 때문에 무시한다. 
    
    //초기화, 기존 값을 초기화 한다. 
    $sql = "update jongmokValue set adjustValue=0";
    echo $sql."<br>";
    mysql_query($sql);
     
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {
        	if(!$data[2]){ //코드가 없으면 즉, 업종이면
        		$sql="update jongmokValue set adjustValue=".addslashes(trim($data[3]))." where industry='".addslashes(trim($data[1]))."' and type='".addslashes(trim($data[0]))."'";
        		echo $sql."<br>";
        		mysql_query($sql);
        	}
        	else{ //종목이면
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
    echo $rowCnt+"개 수정 적정주가 갱신 완료";

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
적정주가를 수정합니다. 파일을 선택 해 주세요. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  파일은 *.csv 형식이며 다음의 양식을 따릅니다.
  
  구   분 | 이름       |  코드   | 값    
  KOSPI | 건설       |           | 0.125 (업종일 경우)
  KOSPI | 삼성전자 | 005930 | 0.25 (종목일 경우)  
  
  </pre>
  
</form> 

</body> 
</html> 