<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header8.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//�ʱ�ȭ
$sql = "update jongmokValue set outFlag='F'";
mysql_query($sql);


	$s = new Snoopy;
	
//�ڽ��� ��������
	$s->fetch("http://stock.daum.net/quote/attention.daum?type=M&stype=P");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//�ں��Ѱ� ���͸�
	$test = explode("��������</h3>",$txt); //�������� �ڵ�
	
	/*Ű����
	  1. ��������	 
	  �� ���̿� �ִ� �� �߿��� ���͸�
	  2. ���簡
	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("���簡</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //���⿡�� ã�� ��
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}	
	
	
		//echo "<br>////////////////////////////////////////	<br>";
		
//�ڽ� ��������
	$s->fetch("http://stock.daum.net/quote/attention.daum?stype=Q&type=M");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);
	

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//�ں��Ѱ� ���͸�
	$test = explode("��������</h3>",$txt); //�������� �ڵ�
	
	/*Ű����
	  1. ��������	 
	  �� ���̿� �ִ� �� �߿��� ���͸�
	  2. ���簡
	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("���簡</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //���⿡�� ã�� ��
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}			
	
	
//�ڽ��� �ŷ����� ����	
	$s->fetch("http://stock.daum.net/quote/attention.daum?type=S&stype=P");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//�������� ��� Ű����� ���͸�
	$test = explode("��������</h3>",$txt); //�������� �ڵ�
	
	/*
	Ű����
	  1. ��������	 
	      �� ���̿� �ִ� �� �߿��� ���͸�
	  2. ���簡	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("���簡</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //���⿡�� ã�� ��
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}
	
	
//�ڽ��� �ŷ����� ����	
	$s->fetch("http://stock.daum.net/quote/attention.daum?stype=Q&type=S");
	
	$txt = $s->results;
	
	$txt=iconv("UTF-8","euc-kr",$txt);

	$txt = str_replace("<!--"," ",$txt);
	$txt = str_replace("-->"," ",$txt);
	$txt = "<!--".$txt."-->";
	$txt =  str_replace('"',"'",$txt);
	
	
	//�������� ��� Ű����� ���͸�
	$test = explode("��������</h3>",$txt); //�������� �ڵ�
	
	/*
	Ű����
	  1. ��������	 
	      �� ���̿� �ִ� �� �߿��� ���͸�
	  2. ���簡	  
	 */
	
	$txt = "<!--".$test[1]."-->";
	
	$test = explode("���簡</a>",$txt);
	
	$txt = "<!--".$test[0]."-->"; //���⿡�� ã�� ��
	
	
	//echo $txt;
	
	//echo substr_count($txt,"/item/main.daum?code");
	
	$cnt = substr_count($txt,"/item/main.daum?code");
			
	$test = explode("/item/main.daum?code=",$txt);

	for($i=1 ; $i<=$cnt;$i++)
	{
		$code = substr($test[$i],0,6);
		
		$sql = "update jongmokValue set outFlag='T' where code='$code' ";
		mysql_query($sql);
		
		echo $sql;
		echo "<br>";
	}	
	
	
	
	//������ 0���� ����� ����� �����ϴ°� �߰� / 2016.5.30 ������
	$sql = "UPDATE jongmokValue SET freeFlag = 'T' WHERE VALUE=0";
	mysql_query($sql);	
	
?>


</table>
<script >
alert("���� �Ϸ�");
</script>