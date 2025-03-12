<?php
date_default_timezone_set('Asia/Kolkata');
$baseurl = "http://smsjust.com/sms/user/balance_check.php";
$user = htmlspecialchars("beautyparlor");
$password = htmlspecialchars("beautyparlor@123");
$response_separator = "Your Balance is ";
$response_value_separator = ":";
$response_chunk_separator = "<BR/>";
 $url = $baseurl."?username=$user&pass=$password";

//http://smsjust.com/sms/user/balance_check.php?username=beyondcg&pass=welcome@123
$response = file_get_contents($url);
//echo $response;
$arr = explode($response_separator, $response);
//echo $arr;
$res_arr =  explode($response_value_separator, $arr[1]);

$fin_arr =  explode($response_chunk_separator, $res_arr[1]);
echo $fin_arr[0];
?>