<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


?>

<!--
2014.04.03 �����̳� ������ 

�ð��Ѿ� : �����׿���
1 : 2
�̻��� ���� ã�� ��

�� ���Ͽ����� ������ �����͸� �޾ƿͼ� DB�� �ִ´�.
�׸��� �ð��Ѿ� : �����׿��� ������ 1:2 �̻� ���̳��� ������ Table�� �ѷ��ش�.

db : jongmokSichong

idx      ����, cell 0
name      �����, cell 1
code      �����ڵ� (A~~), cell 2
currentValue           ���簡, cell 3
marketValue           �ð��Ѿ�, cell 4
earndValue                �����׿��� (�Ѵ޿� 1ȸ ����), cell 5
earndUpdateDate     �����׿��� ���ų�¥ (�̰� Ȥ�� ���� ����), cell 6
type �ڽ���/�ڽ���


Ǯ��� �� ����
1. ���簡, �ð��Ѿ��� �ڵ����� �޾ƿ��� ��
2. �����׿����� �ڵ����� �޾ƿ��� �� 

�켱�� 1�� ���� �ذ�����. 
-->


<?php

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    $rowCnt = 0; //ù ���� ������ ����ֱ� ������ �����Ѵ�. 
        
    //loop through the csv file and insert into database 
    do { 
        if ($data[0] && $rowCnt > 1) {        	//null�� ���� �� ���� loop ����        	
        	$code = addslashes(trim($data[2]));
        	$currentValue = addslashes(trim($data[3]));
        	$marketValue = addslashes(trim($data[4]));       
        	
        		$sql="update jongmokSichong set currentValue = $currentValue, marketValue=$marketValue where code='$code'";
        		echo $sql."<br>";
        		
        		mysql_query($sql);
        	
        } 
        
        $rowCnt++;        	
        
    } while ($data = fgetcsv($handle,1000,",","'")); 
    
    echo $rowCnt . " ���� �Ϸ�";

/*  ���⼭ �ð��Ѿ� : �����׿��� ����Ѵ� */
    
    $rowNum = 1;    
    $sql = "select A.*,B.value,B.adjustValue,B.type from jongmokSichong A inner join jongmokValue B 
    on right(A.code,6) = B.code
    where A.earndValue/A.marketValue > 2
    order by A.earndValue/A.marketValue desc;
    ";
    $tmpRs = mysql_query($sql);
    
    echo "<table width=100% cellpadding=0 cellspacing=0 border=1>
    <tr bgcolor='skyblue'>
    <td>����</td><td>�����</td><td>�����ڵ�</td><td>���簡</td><td>�����ְ�</td><td>�ð��Ѿ�:�����׿���</td>
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
    <td>����</td><td>�����</td><td>�����ڵ�</td><td>���簡</td><td>�����ְ�</td><td>�ð��Ѿ�:�����׿���</td>
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
������ ���� �� �ּ���. <br>

  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
  <br><br>
  <pre>
  ������ *.csv �����̸� ������ ����� �����ϴ�.
  
  ���� | ����� | �����ڵ� | ���簡 | �ð��Ѿ�
  
  </pre>
  
</form> 

</body> 
</html> 