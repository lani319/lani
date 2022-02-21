<script type="text/javascript">
	function showPop(fileName)
	{
		var width = 600;
		var height = 467;
		
		document.getElementById("couponPop").style.top = ((screen.height-height)/2)-100;
		document.getElementById("couponPop").style.left = (screen.width-width)/2;
		document.getElementById("couponPop").style.display = "inline";
		document.getElementById("imgPop").src = "/lani/coupon/img/"+fileName;
		return;
	}
	function hidePop()
	{
		document.getElementById("couponPop").style.display = "none";
		return;
	}
	
	
</script>
<div id="couponPop" style="position:absolute;top:0;left:0;width:600;height:467;display:none;border:#000000 solid 5px;background-color:#FFFFFF">
<img id="imgPop" src="/lani/coupon/img/pop5dc.png" border="0" onclick="hidePop();" style="cursor:hand;">
</div>

<?php
//QBS 투자의 정석 1년 시청권 신규발행, 20140806 쿠폰 삭제
/*
function couponQbsVod()
{
	$memIdx=$_COOKIE['_CKE_USER_UID'];	
	$couponNo = 15;
	$expiredDate = 365*86400;
		
	//발행 쿠폰 검사	
	$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx and status=1";
	$tmpRs = mysql_query($sql);	
	if(mysql_num_rows($tmpRs) == 0)  //이미 발행해서 사용하고 있는 쿠폰이 없으면 등록을 하고 쿠폰 상태를 1로 바꿔준다.
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,status,usedDate) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx,1,now())";		
		mysql_query($sql);
		
		for($i=1 ; $i<=12 ; $i++)
		{
			$sql = "insert into Member_expert(mem_idx,regDate,service_orderID,settle_mode)values('".$memIdx."',now(),$i,'QBS')";
			mysql_query($sql);			
		}
								
		echo "<script>showPop('popVOD.png');</script>"; //여기에 쿠폰이 발행되었다는 팝업을 보여준다.
	}
	
	return true;
}
*/

//유료 강연회 1회 참석쿠폰 신규발행, 20140806 쿠폰 삭제
/*
function couponSeminaFree()
{
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 14;
	$expiredDate = 365*86400;
	//coupon kind no 15
	
	//발행 쿠폰 검사
	//$sql = "select idx,status from 502Coupon where kind=$couponNo and status in (0,1) and memIdx=$memIdx";		
	$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx";		
	$tmpRs = mysql_query($sql);
	
	if(mysql_num_rows($tmpRs) == 0)  //이미 발행해서 사용하고 있는 쿠폰이 없으면
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx)";
		mysql_query($sql);
		echo "<script>showPop('popSeminaFree.png');</script>"; //여기에 쿠폰이 발행되었다는 팝업을 보여준다.
	}
}
*/



//인터넷 방송 5% 할인 쿠폰 발행
//회원 등급이 2등급이고, 5%할인 쿠폰 발행이 안되었으면 발행을 해준다.
//유효기간 1년
function couponReg5percent()
{
	$MemLV = 2;
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 13;
	$expiredDate = 365*86400;
	//coupon kind no 15
	
	//발행 쿠폰 검사
	if ($MemLV == 2)
	{
		$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx";
		$tmpRs = mysql_query($sql);
		
		if(mysql_num_rows($tmpRs) == 0)  //이미 발행해서 사용하고 있는 쿠폰이 없으면
		{
			$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx)";
			mysql_query($sql);
			echo "<script>showPop('pop5dc.png');</script>"; //여기에 쿠폰이 발행되었다는 팝업을 보여준다.
		}
	}
}

//인터넷 방송 5% 할인쿠폰 적용하기
//파라미터로 요금을 받는다
//리턴값으로 요금을 리턴한다.
//쿠폰사용했다는 흔적을 남긴다 (구매번호를 기록한다.)
//결제페이지에서 사유에 쿠폰적용여부를 남겨야한다.

//무통장 : mypage/bank_pay.html
//ARS:mypage/ars_card_pay.php
//카드:mypage/settle_broadcast.html

//가격을 파라미터로 받아서 5%할인 쿠폰이 있는지 확인하고, 다시 값을 리턴해준다.
function couponUse5percent()
{
	$MemLV = 2;
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 13;
	if ($MemLV == 2)
	{
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	}
}


//가격을 파라미터로 받아서 20%할인 쿠폰이 있는지 확인하고, 다시 값을 리턴해준다.
function couponUse20percent()
{
	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 19;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	
}


//가격을 파라미터로 받아서 김태희 35%할인 쿠폰이 있는지 확인하고, 다시 값을 리턴해준다. 20140212
function couponUse35percentTh()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 23;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	
}

//가격을 파라미터로 받아서 평택촌놈 50%할인 쿠폰이 있는지 확인하고, 다시 값을 리턴해준다. 20140212
function couponUse50percentPt()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 22;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	
}

//가격을 파라미터로 받아서 50%할인 쿠폰이 있는지 확인하고, 다시 값을 리턴해준다. 20140326
function couponUse50percent()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 24;
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	
}

//인터넷방송 10% 1회 사용쿠폰 20140619 어윤학
function couponUse10percentBroadCast()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 25;
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	
}


//SMS 10% 1회 사용쿠폰 20140619 어윤학
function couponUse10percentSMS()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 26;
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //발행되었고, 사용된 쿠폰이 없으면
		{
			return $rs[idx];
		}
	
}


//신용카드, 무통장 , ARS 입금완료처리가 되면 쿠폰을 사용했다고 갱신해줘야한다.
function setCouponUsed5percent($idx)
{
	$couPonIdx = $idx;
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$sql = "select couponIdx from chargeInfo where uidx=$memIdx and couponIdx=$couPonIdx";
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[couponIdx] == $couPonIdx)
	{
		$sql = "update 502Coupon set status=1 where idx=$couPonIdx";
		mysql_query($sql);
		
		echo "<script>alert('쿠폰 사용이 정상적으로 처리되었습니다.')</script>";
	}
	else 
	{
		echo "<script>alert('발행 된 쿠폰이 없습니다.')</script>";
	}
}

//5% 할인 쿠폰을 갖고 있는지 체크한다.
//가격을 파라미터로 받아서 5%할인 쿠폰을 적용하고, 다시 값을 리턴해준다.
function couponCheck5percent($memidx)
{
	$MemLV = 2;
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 13;
	if ($MemLV == 2)
	{
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if($rs[idx]!= "")  //발행되었고, 사용된 쿠폰이 없으면
		{
			return "true";
		}
		else 
		{
			return "false";
		}
	}
}

//김태희 35% 할인 쿠폰을 갖고 있는지 체크한다.
function couponCheck35percentTh($memidx){
	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 23;
	
	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";		
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //발행되었고, 사용된 쿠폰이 없으면
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//50% 할인 쿠폰을 갖고 있는지 체크한다.
function couponCheck50percentPt($memidx)
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 22;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //발행되었고, 사용된 쿠폰이 없으면
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//50% 할인 쿠폰을 갖고 있는지 체크한다., 유효기간도 체크
function couponCheck50percent($memidx)
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 24;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //발행되었고, 사용된 쿠폰이 없으면
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//인터넷방송 10% 1회 할인 쿠폰을 갖고 있는지 체크한다. 20140619 어윤학
function couponCheck10percentBroadCast()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 25;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //발행되었고, 사용된 쿠폰이 없으면
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//SMS 10% 1회 할인 쿠폰을 갖고 있는지 체크한다. 20140619 어윤학
function couponCheck10percentSMS()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 26;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	//echo $sql;
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //발행되었고, 사용된 쿠폰이 없으면
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}



//적정주가 3회 이용권 (N번 이용을 파라미터로 받는다), /index.html에서 호출한다.
function setCouponJongmokValue($memIdx,$num)
{
	/*
		db : jongmokValueChargeInfo
		필드 : memIdx,price,buy_no,state,signdate,paydate,bank,jongmok,settletype
		*/
		$now_time=mktime();
				
		$price = $num*11000;	
		$buy_no=$memIdx."-".date("ymdHis",$now_time);
		$state = 6; //임의적용		
		$bank="502쿠폰(적정주가 3회 이용권)";
		$jongmok=$num; //3개월
		$settleType=3; //임의적용
		$couponKind = "$num 개";
		
		$sql = "select idx from 502Coupon where kind=17 and memIdx=$memIdx";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if($rs[idx]== "")  //발행되었고, 사용된 쿠폰이 없으면
		{
			//회원정보에서 갱신
			$sql = "update Member set jongmokCnt = jongmokCnt + $num where idx=$memIdx";
			//echo $sql;
			mysql_query($sql) or die($sql);
			
			
			//3. 502Coupon에 발급 된 것 처럼 처리한다.			
			$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values(17,now(),'2024-12-31 23:59:59',$memIdx,'$couponKind')";			
			
			//echo $sql;
			mysql_query($sql) or die($sql);
			
			
			
			//4. jongmokValueChargeInfo 결제 내역 테이블에 집어 넣는다. 
			$sql = "insert into jongmokValueChargeInfo(memIdx,price,buy_no,state,signdate,paydate,bank,jongmok,settletype) values(
			$memIdx,
			$price,
			'$buy_no',
			$state,
			now(),
			now(),
			'$bank',
			$jongmok,
			$settleType	
			)";
			
			
			//echo $sql;
			mysql_query($sql) or die($sql);
			
			echo "<script>showPop('popJongmok.png');</script>"; //여기에 쿠폰이 발행되었다는 팝업을 보여준다.
			//exit;
			
			//echo $msg;
			
		
		}
}

//couponQbsVod();

//couponSeminaFree();

//couponReg5percent();


//20% 할인 쿠폰을 갖고 있는지 체크한다.
function couponCheck20percent($memidx)
{
	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 19;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if($rs[idx]!= "")  //발행되었고, 사용된 쿠폰이 없으면
		{
			return "true";
		}
		else 
		{
			return "false";
		}
}

?>
