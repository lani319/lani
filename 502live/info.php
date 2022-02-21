<!--
테스트용 
방번호 = 전문가 인데스
평택촌놈 = 34904
김태희 = 26439

http://www.502.co.kr/lani/502live/info.php?room_code = 34904

-->
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/board_prn_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$expert_idx = $room_code;		//room_code == 전문가 번호

$broadcast_time=mktime(0,0,0,date("m"),date("d"),date("Y"));
$sql = "select * from BroadCast WHERE cast_state!='T' and edate_mktime >= '$broadcast_time' and step_meeting='N' and expert_idx='".$expert_idx."' order by sdate_mktime asc limit 1";
$result = mysql_query($sql) or die(mysql_error());
$num_rows=mysql_num_rows($result);
	
if($num_rows){
	$cast_info=mysql_fetch_array($result);
	$sdate_time=substr($cast_info[sdate_time],0,2).":".substr($cast_info[sdate_time],2,2)."~".substr($cast_info[edate_time],0,2).":".substr($cast_info[edate_time],2,2);
	
	}
		


//$expert_idx = '34904';  //전문가 고유번호

	if($expert_idx=="34904"){
		$user_nick["userNickname"] = "평택촌놈";

	}else if($expert_idx=="12"){
		$user_nick["userNickname"] = " 502스쿨 야간방송";

	}else{
		$user_nick = get_meminfo($expert_idx,"userNickname, userID");
	}
		
?>

<html>
<title>전문가 정보</title>
<head>
<style type='text/css'>
body {
	margin-left : 0px;
	margin-top : 0px;
	margin-right : 0px;
	margin-bottom : 0px;	
}
</style>
</head>
<body>
<table width="160px" height="160px" cellpadding="0" cellspacing="0" border="1">
<tr>
<td align="center"> 
<font color="#995A00"><b><?=$user_nick["userNickname"]?></b></font>
</td>
</tr>
<tr>
<td><font color="#000000" size="2"><b><?=$cast_info[1]?></b><br><?=$cast_info[2]?><br><?=$sdate_time?></font></td></tr>
</tr>
<tr><td colspan="2" align="center">
<img src="image/join.gif" style="cursor:hand"></td></tr>

</table>

</body>
</html>




