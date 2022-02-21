<html>
<head></head>
<body>
<table cellpadding="0px" cellspacing="0px" width="700px" height="800px" border="0">
<tr>
<td>
<CENTER><A href="http://www.502.co.kr/index.html"><IMG border=0 src="http://www.502.co.kr/img/top/logo.gif" width=199 height=57></A></CENTER>
<P align=center><STRONG><FONT style="BACKGROUND-COLOR: #ffffff" color=#ff0004 size=3>&nbsp;가족과 친구에게 제공하는 투자정보</FONT></STRONG><br>
<STRONG><FONT style="BACKGROUND-COLOR: #ffffff" color=#028000 size=3>&nbsp; 여러분의 소중한 가정을 지켜 드리겠습니다. </FONT></STRONG><br>
<STRONG><FONT style="BACKGROUND-COLOR: #ffffff" color=#4042be size=3>&nbsp; 노력하는 전문가와 진실한 회원이 만드는 공원입니다.</FONT></STRONG></P>
<P>&nbsp;</P>
<P align=left style="padding 0 0 0 0;">
<img src="image/notiTop.png"> 
</P>
<P align=left style="padding : 0 0 0 50"><STRONG><FONT style="BACKGROUND-COLOR: #dbe300" color=#000000 size=4><img src="image/noti7days.png" border="0"></FONT></STRONG></P>
<br>
<img src="image/noti_1_2.png" border="0">
<BR>
<IMG style="CURSOR: hand" id=imgBtnPT src="image/btnPC.gif" onclick="showFee(0);" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<IMG style="CURSOR: hand" id=imgBtnETC src="image/btnSosok2.gif"  onclick="showFee(1);">
<DIV align=left>&nbsp;</DIV>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr id="trPT">
<td>
<img src="image/feePT_LIVE.png"><br>
<img src="image/feePT_TMS.png">
</td>
</tr>
<tr id="trEtc" style="display:none;">
<td>
<img src="image/feeSosok_LIVE.png"><br>
<img src="image/feeSosok_TMS.png">
</td>
</tr>
</table>
<br>
<img src="image/noti_3_4.png" border="0">
<BR>
<script type="text/javascript">
function showFee(type)
{
	switch(type)
	{
		case 0:
		document.getElementById("trPT").style.display = "block";
		document.getElementById("trEtc").style.display = "none";
		document.getElementById("imgBtnPT").src = "image/btnPC.gif"
		document.getElementById("imgBtnETC").src = "image/btnSosok2.gif"
		break;
		
		case 1:
		document.getElementById("trPT").style.display = "none";
		document.getElementById("trEtc").style.display = "block";
		document.getElementById("imgBtnPT").src = "image/btnPC2.gif"
		document.getElementById("imgBtnETC").src = "image/btnSosok.gif"
		break;
	}
}
</script>
</body>
</html>