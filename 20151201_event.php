<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

/*201512월 운영자를 이겨라, 필명으로 승자 정보 추출하는 기능. 평택촌놈 어윤학 팀장 작성]*/

$sql = "SELECT userId,userName,userNickname,mobile FROM Member WHERE userNickname in (
'제주에서살기',
'존슨즈베이비로션',
'종각seven',
'주승',
'주지자',
'죽곡LP',
'지식정보',
'지영*~',
'知行',
'지혜향기',
'진일보',
'천부성',
'천청부지',
'칼라맨',
'포스란',
'푸르름',
'푸른안개',
'풀빛사랑',
'한마음',
'함안수박',
'해피투데이',
'행복을위하여',
'행운의별',
'허쨔',
'헤개모니',
'홍군',
'황실'
)
order by userNickname ASC
";
echo $sql;
$tmpRs = mysql_query($sql);
echo "<table width=600px border=1>";
echo "<tr><td>아이디</td><td>이름</td><td>필명</td><td>연락처</td></tr>";
while ($rs = mysql_fetch_array($tmpRs)) {
	?>
	<tr><td><?=$rs[userId]?></td><td><?=$rs[userName]?></td><td><?=$rs[userNickname]?></td><td><?=$rs[mobile]?></td></tr>
	<?
}
?>