<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


?>

<!--
2014.04.03 평택촌놈 어윤학 

시가총액 : 이익잉여금
1 : 2
이상인 종목 찾는 것

본 파일에서는 엑셀로 데이터를 받아와서 DB에 넣는다.
그리고 시가총액 : 이익잉여금 비율이 1:2 이상 차이나는 종목을 Table로 뿌려준다.

db : jongmokSichong

idx      순번, cell 0
name      종목명, cell 1
code      종목코드 (A~~), cell 2
currentValue           현재가, cell 3
marketValue           시가총액, cell 4
earndValue                이익잉여금 (한달에 1회 갱신), cell 5
earndUpdateDate     이익잉여금 갱신날짜 (이건 혹시 몰라서 만듬), cell 6
type 코스피/코스닥


풀어야 할 과제
1. 현재가, 시가총액을 자동으로 받아오는 것
2. 이익잉여금을 자동으로 받아오는 것 

우선은 1번 부터 해결하자. 
-->


<?php

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //첫 행은 설명이 들어있기 때문에 무시한다. 
        
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {        	//null을 만날 때 까지 loop 돈다        	
        	$code = addslashes(trim($data[2]));
        	$currentValue = addslashes(trim($data[3]));
        	$marketValue = addslashes(trim($data[4]));       
        	
        		$sql="update jongmokSichong set currentValue = $currentValue, marketValue=$marketValue where code='$code'";
        		echo $sql."<br>";
        		
        		mysql_query($sql);
        	
        } 
        
        $rowCnt++;        	
        
    } while ($data = fgetcsv($handle,1000,",","'")); 
    
    echo $rowCnt . " 갱신 완료";

/*  여기서 시가총액 : 이익잉여금 계산한다 */
    
    $rowNum = 1;    
    $sql = "select A.*,B.value,B.adjustValue,B.type from jongmokSichong A inner join jongmokValue B 
    on right(A.code,6) = B.code
    where A.earndValue/A.marketValue > 2
    order by A.earndValue/A.marketValue desc;
    ";
    $tmpRs = mysql_query($sql);
    
    echo "<table width=100% cellpadding=0 cellspacing=0 border=1>
    <tr bgcolor='skyblue'>
    <td>순번</td><td>종목명</td><td>종목코드</td><td>현재가</td><td>적정주가</td><td>시가총액:이익잉여금</td>
    </tr>";
    
    while($rs = mysql_fetch_array($tmpRs))
    {    	
    	$value = $rs[value]+($rs[value]*$rs[adjustValue]);
    	$ratio = $rs[earndValue]/$rs[marketValue];
    	
    	echo "<tr><td>$rowNum</td><td>$rs[name]</td><td>$rs[code]</td><td>$rs[currentValue]</td><td>$value</td><td>$ratio</td></tr>";
    	$rowNum++; 
    }
     echo "</tr>></table>";
} 

/*
    $rowNum = 1;    
    $sql = "select A.*,B.value,B.adjustValue,B.type from jongmokSichong A inner join jongmokValue B 
    on right(A.code,6) = B.code
    where A.earndValue/A.marketValue > 2
    order by A.earndValue/A.marketValue desc;
    ";
    $tmpRs = mysql_query($sql);
    echo "<table width=780px cellpadding=0 cellspacing=0 border=1>
    <tr bgcolor='skyblue' align=center>
    <td>순번</td><td>종목명</td><td>종목코드</td><td>현재가</td><td>적정주가</td><td>시가총액:이익잉여금</td>
    </tr>";
    
    while($rs = mysql_fetch_array($tmpRs))
    {    	
    	$value = number_format($rs[value]+($rs[value]*$rs[adjustValue]));
    	$ratio = number_format($rs[earndValue]/$rs[marketValue],2);
    	$cValue = number_format($rs[currentValue]);
    	echo "<tr align='center'><td>$rowNum</td><td>$rs[name]</td><td>$rs[code]</td><td>$cValue</td><td>$value</td><td>$ratio</td></tr>";
    	$rowNum++; 
    }
     echo "</tr></table>";
     */
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
파일을 선택 해 주세요. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  파일은 *.csv 형식이며 다음의 양식을 따릅니다.
  
  순번 | 종목명 | 종목코드 | 현재가 | 시가총액
  
  </pre>
  
</form> 

</body> 
</html> 