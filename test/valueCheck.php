<?php
include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);

$value1 = $v1;
$value2 = $v2;
$value3 = $v3;
$value4 = $v4;


if ($v1 != 0 && $v2 != 0 && $v3 != 0){
//적정 시가총액
$v3 = $v3 * $v4;

//적정 비율
$v2 = $v3/$v2;

//적정주가
$v1 = $v2 * $v1;

echo "<script>alert('".number_format($v1,0) . "원')</script>";

?>
<script type="text/javascript">
parent.location.href="value.html";
</script>
<?php
}
?>