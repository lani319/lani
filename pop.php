<script>
function openPop()
{
	var win = window.open("/pop/charged_edu.php","pop","width=400,height=438,top=0,left=0, directories=no, location=no, menubar=no, resizable=no, scrollbars=no, status=no, titlebar=no, toolbar=no");
}
</script>

<a href="#" onclick="openPop();">click</a>


<?php

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


$ip = getRealIpAddr();

echo $ip;

?>