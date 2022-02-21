<?php

include_once $_SERVER['DOCUMENT_ROOT']."/_config/db.connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_config/sys.config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/base_lib.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_libs/common_lib.php";

include 'Snoopy-1.2.4/Snoopy.class.php';

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);


//여기에 로그인 처리 2015 09 07
/*
$s=new Snoopy;

$s->httpmethod = "POST";

$memInfo = array('userid'=>'ayh319','userpass'=>'fksl7132');

$memInfo['userid'] = "ayh319";
$memInfo['userpass'] = "fksl7132";
$memInfo['format'] = "php";

$url="http://www.502.co.kr/include/login_ok.php";

$s->submit($url,$memInfo);
$response = unserialize($s->results);
$memInfo['lgtoken'] = $response[login][token];


$s->setcookies();

$s->cookies["SessionID"] = "ayh319";
$s->referer = "http://www.502.co.kr";

$s->fetch("http://www.502.co.kr/board.php?db=expert_sm&mode=view&idx=2634");

$txt = $s->results;

print_r($txt);

//exit;

*/


$snoopy = new Snoopy;
//$snoopy->curl_path="/usr/bin/curl";
//$wikiroot = "http://www.502.co.kr";
$wikiroot = "http://login.itooza.com";  
//http://www.itooza.com/member/login_process.php
$wikiroot = "http://www.itooza.com/member";  
//$api_url = $wikiroot . "/include/login_ok.php";
$api_url = $wikiroot . "/login_process.php"; 

# Login via api.php
$login_vars['action'] = "login";
$login_vars['txtUserId'] = "ayh319";
$login_vars['txtPassword'] = "fksl4278";
$login_vars['format'] = "php";
## First part
$snoopy->submit($api_url,$login_vars);
$response = unserialize($snoopy->results);  


$login_vars['lgtoken'] = $response[login][token];
$snoopy->cookies["wiki_session"] = $response[login][sessionid]; // You may have to change 'wiki_session' to something else on your Wiki
## Second part, now that we have the token
$snoopy->submit($api_url,$login_vars);
$snoopy->setcookies();

# Fetch the page
$login_vars['action'] = "render";
$urlpart=$argv[1];

$targetUrl = "http://www.itooza.com/vclub/y10_page.php?cmp_cd=006910&mode=db&ss=10&sv=1&lsmode=1&accmode=1&lkmode=1";

$snoopy->submit($wikiroot, $login_vars);
 print($snoopy->results);

?>