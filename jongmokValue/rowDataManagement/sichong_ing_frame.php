<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";
?>

<html>
<head>
<script type="text/javascript">
function setData()
{
	var f = document.form1;	
	location.href = "sichong_ing_auto.php";	
}
</script>
</head>
<body>
<form name="form1" src="sichong_ing_auto.php" target="_top" method="POST">
<br><br>
<input type="button" value="U P D A T E" onclick="setData();" style="width:300px;height:40px;"><br><br>
<font color="Red">(�� 5�� ���� �ҿ�˴ϴ�. )</font>
<?php

/*  ���⼭ �ð��Ѿ� : �����׿��� ����Ѵ� */
    
    $rowNum = 1;    
    $sql = "select A.*,B.value,B.adjustValue,B.type from jongmokSichong A inner join jongmokValue B 
    on right(A.code,6) = B.code
    where A.earndValue/A.marketValue > 2
    and B.outFlag = 'F'
    order by A.earndValue/A.marketValue desc;
    ";
    $tmpRs = mysql_query($sql);
    echo "<table width=680px cellpadding=0 cellspacing=0 border=1>
    <tr bgcolor='skyblue' align=center>
    <td>����</td><td>�����</td><td>���簡</td><td>�����ְ�</td><td>�ð��Ѿ�:�����׿���</td><td>����</td>
    </tr>";
    
    while($rs = mysql_fetch_array($tmpRs))
    {    	
    	$value = number_format($rs[value]+($rs[value]*$rs[adjustValue]));
    	$ratio = number_format($rs[earndValue]/$rs[marketValue],2);
    	$cValue = number_format($rs[currentValue]);
    	echo "<tr align='center'><td>$rowNum</td><td>$rs[name]</td><td>$cValue</td><td>$value</td><td>$ratio</td><td>$rs[type]</td></tr>";
    	$rowNum++; 
    }
     echo "</tr></table>";

?>
</form>


</body>

</html>