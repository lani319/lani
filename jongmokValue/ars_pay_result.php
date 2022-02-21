<?
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
?>
<INPUT TYPE="HIDDEN" NAME="price" value="<?=$price?>">
<INPUT TYPE="HIDDEN" NAME="buy_no" value="<?=$buy_no?>">
<INPUT TYPE="HIDDEN" NAME="jokmok" value="<?=$jokmok?>">
<input type="hidden" name="bank" value="<?=$bank?>">
<INPUT TYPE="HIDDEN" name="b_name" value="<?=$b_name?>">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>적정주가 결제결과</title>
<link rel="stylesheet" type="text/css" href="/css/502style.css">
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/cate_xml_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/base_util_script.js"></SCRIPT>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="/_js/web_script.js"></SCRIPT>
<script language="JavaScript" src="/_js/Embed.js"></script>
</head>


<body topmargin=0 leftmargin=0>
<img src="/img/pop/charge_contents_top.gif" width="400" height="38">
<br>
<table width="281" style="margin-top:5px" border="0" align="center" cellpadding="0" cellspacing="0" background="/img/pop/box01_bg.gif">
  <tr>
    <td><img src="/img/pop/box01_top.gif" width="281" height="6"></td>
  </tr>
  <tr>
    <td>
	<TABLE width=95% border=0 align="center" cellpadding=0 CELLSPACING=0 style="border-width:0px; border-color:rgb(204,204,204); border-style:solid;">
	  <TR height=26>
        <TD WIDTH="73" height="22" align="center" class="darkbrown"><strong>결제자</strong></TD>
        <TD width=3 height="22"></TD>
        <TD width="191" height="22">&nbsp;<?=$buy_no?> (<?=$_COOKIE['_CKE_USER_ID']?>)</td>
	  </tr>
      <tr class="darkbrown">
        <td height=1 colspan=3> </td>
      </tr>
	  <TR height=26>
        <TD WIDTH="73" height="22" align="center" class="darkbrown"><strong>결제상품</strong></TD>
        <TD width=3 height="22"></TD>
        <TD width="191" height="22">&nbsp;<?=$_JONGMOK_PRESENT[$jokmok]?></td>
	  </tr>
      <tr class="darkbrown">
        <td height=1 colspan=3> </td>
      </tr>
	  <TR height=26>
        <TD WIDTH="73" height="22" align="center" class="darkbrown"><strong>결제금액</strong></TD>
        <TD width=3 height="22"></TD>
        <TD width="191" height="22">&nbsp;<?=number_format($price)?> 원</td>
	  </tr>
      <tr class="darkbrown">
        <td height=1 colspan=3> </td>
      </tr>
	  <TR height=26>
        <TD WIDTH="73" height="22" align="center" class="darkbrown"><strong>결제번호</strong></TD>
        <TD width=3 height="22"></TD>
        <TD width="191" height="22">&nbsp;<?=$pay_num?></td>
	  </tr>        
	</table>
	</td>
  </tr>
  <tr>
    <td><img src="/img/pop/box01_btm.gif" width="281" height="6"></td>
  </tr>
</table>
<table width="281" border="0" align="center" cellpadding="0" cellspacing="0">
<TR>
	<td colspan="3" style="padding:7 0 7 15">
		<span style="font-size:12">
		<br><br>
		<b><font color="red">10분 후 </font><font color="blue">ARS결제 전용전화 02-3490-4421</font></b><br><br>으로 연락 후
		<b><font color="red">본인 핸드폰 번호를 입력</font></b>하시고 <b><font color="red"><br><br>안내멘트 따라서 결제를 진행</font></b>해주시기 바랍니다. <br><br><font color="blue">(국민, 농협카드 불가  / 평일 업무시간만 가능 )</font><br><br>
		</span> 
		</span>
	</td>
</tr>
</table>

<table width="281" height="7" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> </td>
  </tr>
</table>
<table cellspacing=0 cellpadding=0 border=0 width="281" align=center>
<tr>
	<TD class="brown" align=center>
		결제내역은 [<a href="/mypage/02.html" target="_blank">마이페이지</a>]에서 
		<br>
		다시 확인하실 수 있습니다.
	 </TD>
</tr>
<tr height=35>
	<td align=center><img src='/img/sub/btn_bd_close.gif' align=absmiddle onClick="window.close();" style="cursor:hand"></td>
</tr>
</table>
<script>
var SP2 = (window.navigator.userAgent.indexOf("SV1") != -1);

function winResize(){
	window.resizeTo(320, document.body.scrollHeight + 80);
}

window.onload = function(){
	 winResize();
	 window.setTimeout("winResize();", 500);
	 window.setTimeout("winResize();", 1000);
}
</script>
</body>
</html>