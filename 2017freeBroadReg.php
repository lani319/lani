<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";


/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);



?>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<script>
function invest_reg(){
	document.invest_frm.ok.value="Y";
	document.invest_frm.submit();
	return true;
}
</script>
<html>
<head>
<title>����ü�� ���� ��û</title>
<br>
<form name="invest_frm" method="post" action="_2017freeBroadRegOk.php">
<input type="hidden" name="ok" value="N" />
<input type=hidden name="month" value="2">
<table width="350" border="0" align="center" cellpadding="0" cellspacing="0" background="../img/pop/box350_bg.gif" >
  <tr>
    <td colspan="3"><img src="../img/pop/box350_top.gif" width="350" height="8"></td>
  </tr>
	<tr>
		<td align="center" colspan="3" style="font-size:12px;"><br><b>�����̳� ���ͳݹ�� <br>����ü�� ���� ��û�Ͻðڽ��ϱ�?</b><br><font color="red">(��û�ϱ� ��ư�� ������ �ٷ� ����˴ϴ�)</font><br><br></td>
	</tr>
	<tr height="5">
		<td></td>
	</tr>	
	<tr>
		<td align="center" colspan="3"><a href="#" onclick="invest_reg(); return false;"><img src="/images/btn/btn_pay_01.gif" border="0"></a>&nbsp;
		<!--
		<a href="#" onclick="window.close(); return false;"><img src="/images/btn/btn_pay_02.gif" border="0"></a>		
		-->
		</td>
		
	</tr>
	<tr>
        <td colspan="3"><img src="../img/pop/box350_btm.gif" width="350" height="8"></td>
    </tr>
</table>

</form>