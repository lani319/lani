<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


$totalCount = 1;
?>
�ɺô� ��������<br><br>

<TABLE width="100%" cellpadding=0 cellspacing=0 border=0>
			<tr height=1><td bgcolor='#C0C0C0' colspan=25></td></tr>
			<tr height=1><td bgcolor='#FFFFFF' colspan=25></td></tr>
			<TR HEIGHT=27 bgcolor='#DDE3F3' align='center'>
				<TD width=1></TD>
				<td >���Ź�ȣ</td>
				<TD width=1></TD>
				<td width=115>������</td>
				<TD width=1></TD>
				<td width=100>���̵�</td>
				<TD width=1></TD>
				<td width=80>�̸�</td>
				<TD width=1></TD>
				<td width=80>��������</td>
				<TD width=1></TD>
				<td width=115>ó������</td>
				<TD width=1></TD>
				<td width=80>�����ݾ�</td>
				<TD width=1></TD>
				<td width=90>��û����</td>
				<TD width=1></TD>
				<td width=90>ó������</td>
				<TD width=1></TD>
				<td width=100>����</td>
			</tr>
			<tr height=1><td bgcolor='#C0C0C0' colspan=25></td></tr>
<?
if($totalCount){
	$today=date("Y-m-d");
	$num=$totalCount - $start_p;
	$sql = "
	select C.*, M.userID , M.userName 
	from chargeContentsInfo C
	inner join Member M
		on M.idx = C.uidx
	$addwhere 
	order by idx desc ";
	
	
	echo $sql;
	
	$result = mysql_query($sql) or die("�����: ".mysql_error());
	while($rs = mysql_fetch_array($result)){
		unset($use_point);
		if($rs["reprice"]){
			if($rs['isUseCoin'] == 'N'){
				$use_point="<br>(-".number_format($rs["reprice"])."P)";
			}
			else{
				$use_point="<br>(-".number_format($rs["reprice"])."C)";
			}
		
		}
		$payKind = "";
		switch ($rs['bn'])
		{
			case "100":
				$payKind = "�ɺô�";
				break;
			case "st":
				$payKind = "��������";
				break;
		}
		
		$sql="select userNickname from Member where idx='".$rs[expert_idx]."'";
		$expinfo=mysql_fetch_array(mysql_query($sql));
?>
			<tr bgcolor="ffffff"  height="26" align='center'>								
				<TD width=1></TD>
				<td><?=$rs[buy_no]?></td>
				<TD width=1></TD>
				<td><?=$expinfo[userNickname]?></td>
				<TD width=1></TD>
				<td><?=$rs[userID]?></td>
				<TD width=1></TD>
				<td><?=$rs[userName]?></td>
				<TD width=1></TD>
				<td><?=$_CHARGE_SETTLETYPE[$rs['settletype']]?></td>
				<TD width=1></TD>
				<td><?=$_CHARGE_RESULT_CONTENT_INFO[$rs['state']]?></td>
				<TD width=1></TD>
				<td align=right><B><? echo number_format($rs['price']); ?></B>&nbsp;��<?=$use_point?>&nbsp;&nbsp;</td>
				<TD width=1></TD>
				<td><? echo $rs['signdate']; ?></td>
				<TD width=1></TD>
				<td><? echo $rs['paydate']; ?></td>
				<TD width=1></TD>
				<td><? echo $payKind ?><br><?=$_PAY_BOARD_KIND_ARRAY[$rs[bn]]?>&nbsp;&nbsp; , <?=$rs[bidx]?> �� ������</td>
			</tr>
			<tr height=1><td bgcolor='#C0C0C0' colspan=25></td></tr>
<?
		$num--;
	}// end while
} // end if

if(!$totalCount){
?>
			<tr height=30>
				<td colspan=21 bgcolor='#ffffff' align='center'><font color='red'>��ϵ� ���������� �����ϴ�. </font></td>
			</tr>
			<tr height=1><td bgcolor='#C0C0C0' colspan=21></td></tr>
<?
}
?>
			</TABLE>