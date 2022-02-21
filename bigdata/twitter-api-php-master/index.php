<?php
ini_set('display_errors', 1);

require_once("TwitterAPIExchange.php");


include $_SERVER['DOCUMENT_ROOT']."/lani/bigdata/twitter-api-php-master/TwitterAPIExchange.php";

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    "oauth_access_token" => "130038549-El7YuMmfGyBI9QVk36jz7G19d0jmJISl3Cyg97ri",
    "oauth_access_token_secret" => "bS9wS2MCAdFv1SEdUtN64nvXGpGrQlWu56mhs3vxN0XEp",
    "consumer_key" => "dUxpSim7rhlcP2DbLCvg",
    "consumer_secret" => "VEuZhi6H4snEylav1LKL73SLLg7qW7i6JJHtiSrYWgE"
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

$requestMethod = "GET";

$getfield = "?screen_name=lani319&count=20";

$twitter = new TwitterAPIExchange($settings);


echo $url;
echo "<br>";
echo $requestMethod;

exit;
/*
echo $twitter->setGetfield($getfield)
                  ->buildOauth($url, $requestMethod)
                  ->performRequest();
*/

?>