<?php
include_once $_SERVER['DOCUMENT_ROOT']."/admin/header3.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

?>
<br>
<table width="1100" cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="155px" valign="top">
<?php include_once $_SERVER['DOCUMENT_ROOT']."/lani/BusinessLog/inc/menu_left.php"; ?>
</td>
<td>
	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td>
		<pre>
		*직원 공지사항
		  - 전 직원들에게 알리는 내용입니다. 글 보기는 모든 사람이 가능하며, 쓰기는 부장님만 가능합니다.
		</pre>
		
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*회사 진행 업무
		  - 회사차원에서 추진하는 업무 입니다. 글 보기는 모든 사람이 가능하며, 쓰기는 부장님만 가능합니다.
		</pre>
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*개인별 업무
		  - 각 직원별로 진행해야 할 업무 입니다. 글 보기는 모든 사람이 가능하며, 업무 지시는 부장님만 가능합니다.
		</pre>
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*개인별 업무관리
		  - 부장님이 각 개인별로 업무지시를 하기 위한 메뉴입니다.
		</pre>
		</td>
	</tr>
	<tr>
		<td>
		<pre>
		*회사 업무관리
		  - 부장님이 회사차원에서 진행하는 업무를 작성하기위한 메뉴입니다.
		</pre>
		</td>
	</tr>
	</table>
</td>
</tr>
</table>