<?php
/**
 * @file
 * php5 이상에서만 작동 됨
 */




/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');

$f_nLimit = 10;

$strConsumerId = "{lani319}";
$strConsumerKey = "{dUxpSim7rhlcP2DbLCvg}";
$strConsumerSecret = "{VEuZhi6H4snEylav1LKL73SLLg7qW7i6JJHtiSrYWgE}";

$connection = new TwitterOAuth($strConsumerKey,$strConsumerSecret);

$rsProfile = $connection -> get('users/show',array('screen_name' => $strConsumerId));

$arrayFeed = $connection->get('statuses/user_timeline',array('screen_name' => $strConsumerId, 'count' => $f_nLimit));


foreach ($arrayFeed as $rsFeed){
	$strFeedText = k_iconv("UE",makeClickableLinks($rsFeed -> text));
}

?>

