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
//QBS ������ ���� 1�� ��û�� �űԹ���, 20140806 ���� ����
/*
function couponQbsVod()
{
	$memIdx=$_COOKIE['_CKE_USER_UID'];	
	$couponNo = 15;
	$expiredDate = 365*86400;
		
	//���� ���� �˻�	
	$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx and status=1";
	$tmpRs = mysql_query($sql);	
	if(mysql_num_rows($tmpRs) == 0)  //�̹� �����ؼ� ����ϰ� �ִ� ������ ������ ����� �ϰ� ���� ���¸� 1�� �ٲ��ش�.
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,status,usedDate) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx,1,now())";		
		mysql_query($sql);
		
		for($i=1 ; $i<=12 ; $i++)
		{
			$sql = "insert into Member_expert(mem_idx,regDate,service_orderID,settle_mode)values('".$memIdx."',now(),$i,'QBS')";
			mysql_query($sql);			
		}
								
		echo "<script>showPop('popVOD.png');</script>"; //���⿡ ������ ����Ǿ��ٴ� �˾��� �����ش�.
	}
	
	return true;
}
*/

//���� ����ȸ 1ȸ �������� �űԹ���, 20140806 ���� ����
/*
function couponSeminaFree()
{
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 14;
	$expiredDate = 365*86400;
	//coupon kind no 15
	
	//���� ���� �˻�
	//$sql = "select idx,status from 502Coupon where kind=$couponNo and status in (0,1) and memIdx=$memIdx";		
	$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx";		
	$tmpRs = mysql_query($sql);
	
	if(mysql_num_rows($tmpRs) == 0)  //�̹� �����ؼ� ����ϰ� �ִ� ������ ������
	{
		$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx)";
		mysql_query($sql);
		echo "<script>showPop('popSeminaFree.png');</script>"; //���⿡ ������ ����Ǿ��ٴ� �˾��� �����ش�.
	}
}
*/



//���ͳ� ��� 5% ���� ���� ����
//ȸ�� ����� 2����̰�, 5%���� ���� ������ �ȵǾ����� ������ ���ش�.
//��ȿ�Ⱓ 1��
function couponReg5percent()
{
	$MemLV = 2;
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 13;
	$expiredDate = 365*86400;
	//coupon kind no 15
	
	//���� ���� �˻�
	if ($MemLV == 2)
	{
		$sql = "select idx,status from 502Coupon where kind=$couponNo and memIdx=$memIdx";
		$tmpRs = mysql_query($sql);
		
		if(mysql_num_rows($tmpRs) == 0)  //�̹� �����ؼ� ����ϰ� �ִ� ������ ������
		{
			$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx) values($couponNo,now(),FROM_UNIXTIME(UNIX_TIMESTAMP()+$expiredDate),$memIdx)";
			mysql_query($sql);
			echo "<script>showPop('pop5dc.png');</script>"; //���⿡ ������ ����Ǿ��ٴ� �˾��� �����ش�.
		}
	}
}

//���ͳ� ��� 5% �������� �����ϱ�
//�Ķ���ͷ� ����� �޴´�
//���ϰ����� ����� �����Ѵ�.
//��������ߴٴ� ������ ����� (���Ź�ȣ�� ����Ѵ�.)
//�������������� ������ �������뿩�θ� ���ܾ��Ѵ�.

//������ : mypage/bank_pay.html
//ARS:mypage/ars_card_pay.php
//ī��:mypage/settle_broadcast.html

//������ �Ķ���ͷ� �޾Ƽ� 5%���� ������ �ִ��� Ȯ���ϰ�, �ٽ� ���� �������ش�.
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
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	}
}


//������ �Ķ���ͷ� �޾Ƽ� 20%���� ������ �ִ��� Ȯ���ϰ�, �ٽ� ���� �������ش�.
function couponUse20percent()
{
	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 19;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	
}


//������ �Ķ���ͷ� �޾Ƽ� ������ 35%���� ������ �ִ��� Ȯ���ϰ�, �ٽ� ���� �������ش�. 20140212
function couponUse35percentTh()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 23;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	
}

//������ �Ķ���ͷ� �޾Ƽ� �����̳� 50%���� ������ �ִ��� Ȯ���ϰ�, �ٽ� ���� �������ش�. 20140212
function couponUse50percentPt()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 22;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	
}

//������ �Ķ���ͷ� �޾Ƽ� 50%���� ������ �ִ��� Ȯ���ϰ�, �ٽ� ���� �������ش�. 20140326
function couponUse50percent()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 24;
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	
}

//���ͳݹ�� 10% 1ȸ ������� 20140619 ������
function couponUse10percentBroadCast()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 25;
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	
}


//SMS 10% 1ȸ ������� 20140619 ������
function couponUse10percentSMS()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 26;
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if(mysql_num_rows($tmpRs) > 0)  //����Ǿ���, ���� ������ ������
		{
			return $rs[idx];
		}
	
}


//�ſ�ī��, ������ , ARS �ԱݿϷ�ó���� �Ǹ� ������ ����ߴٰ� ����������Ѵ�.
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
		
		echo "<script>alert('���� ����� ���������� ó���Ǿ����ϴ�.')</script>";
	}
	else 
	{
		echo "<script>alert('���� �� ������ �����ϴ�.')</script>";
	}
}

//5% ���� ������ ���� �ִ��� üũ�Ѵ�.
//������ �Ķ���ͷ� �޾Ƽ� 5%���� ������ �����ϰ�, �ٽ� ���� �������ش�.
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
		if($rs[idx]!= "")  //����Ǿ���, ���� ������ ������
		{
			return "true";
		}
		else 
		{
			return "false";
		}
	}
}

//������ 35% ���� ������ ���� �ִ��� üũ�Ѵ�.
function couponCheck35percentTh($memidx){
	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 23;
	
	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";		
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //����Ǿ���, ���� ������ ������
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//50% ���� ������ ���� �ִ��� üũ�Ѵ�.
function couponCheck50percentPt($memidx)
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 22;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //����Ǿ���, ���� ������ ������
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//50% ���� ������ ���� �ִ��� üũ�Ѵ�., ��ȿ�Ⱓ�� üũ
function couponCheck50percent($memidx)
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 24;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //����Ǿ���, ���� ������ ������
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//���ͳݹ�� 10% 1ȸ ���� ������ ���� �ִ��� üũ�Ѵ�. 20140619 ������
function couponCheck10percentBroadCast()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 25;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //����Ǿ���, ���� ������ ������
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}

//SMS 10% 1ȸ ���� ������ ���� �ִ��� üũ�Ѵ�. 20140619 ������
function couponCheck10percentSMS()
{	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 26;

	$sql = "select count(idx) from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
	//echo $sql;
	
	$tmpRs = mysql_query($sql);
	$rs = mysql_fetch_array($tmpRs);
	if($rs[0]== 1)  //����Ǿ���, ���� ������ ������
	{
		return "true";
	}
	else 
	{
		return "false";
	}	
}



//�����ְ� 3ȸ �̿�� (N�� �̿��� �Ķ���ͷ� �޴´�), /index.html���� ȣ���Ѵ�.
function setCouponJongmokValue($memIdx,$num)
{
	/*
		db : jongmokValueChargeInfo
		�ʵ� : memIdx,price,buy_no,state,signdate,paydate,bank,jongmok,settletype
		*/
		$now_time=mktime();
				
		$price = $num*11000;	
		$buy_no=$memIdx."-".date("ymdHis",$now_time);
		$state = 6; //��������		
		$bank="502����(�����ְ� 3ȸ �̿��)";
		$jongmok=$num; //3����
		$settleType=3; //��������
		$couponKind = "$num ��";
		
		$sql = "select idx from 502Coupon where kind=17 and memIdx=$memIdx";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if($rs[idx]== "")  //����Ǿ���, ���� ������ ������
		{
			//ȸ���������� ����
			$sql = "update Member set jongmokCnt = jongmokCnt + $num where idx=$memIdx";
			//echo $sql;
			mysql_query($sql) or die($sql);
			
			
			//3. 502Coupon�� �߱� �� �� ó�� ó���Ѵ�.			
			$sql = "insert into 502Coupon(kind,issueDate,expiredDate,memIdx,etc) values(17,now(),'2024-12-31 23:59:59',$memIdx,'$couponKind')";			
			
			//echo $sql;
			mysql_query($sql) or die($sql);
			
			
			
			//4. jongmokValueChargeInfo ���� ���� ���̺� ���� �ִ´�. 
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
			
			echo "<script>showPop('popJongmok.png');</script>"; //���⿡ ������ ����Ǿ��ٴ� �˾��� �����ش�.
			//exit;
			
			//echo $msg;
			
		
		}
}

//couponQbsVod();

//couponSeminaFree();

//couponReg5percent();


//20% ���� ������ ���� �ִ��� üũ�Ѵ�.
function couponCheck20percent($memidx)
{
	
	$memIdx=$_COOKIE['_CKE_USER_UID'];
	$couponNo = 19;
	
		$sql = "select idx from 502Coupon where kind=$couponNo and status = 0 and memIdx=$memIdx and expiredDate >= now()";
		$tmpRs = mysql_query($sql);
		$rs = mysql_fetch_array($tmpRs);
		if($rs[idx]!= "")  //����Ǿ���, ���� ������ ������
		{
			return "true";
		}
		else 
		{
			return "false";
		}
}

?>
