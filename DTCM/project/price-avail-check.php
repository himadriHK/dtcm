<?php
session_start();
if( !isset($_SESSION["softix_token"]) ){
require_once 'softix-token.php';
}
$url = 'https://api.etixdubai.com/performances/ETES3EL/availabilities?channel=W&sellerCode=AELAB1';
//$url = 'https://api.etixdubai.com/performances/ETES3EL/prices?channel=W&sellerCode=AELAB1';
$accesstoken = '165c91e5bf2649c98c6e106e2d94fb1f';


//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
 //curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//execute post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
header('Content-Type: application/json');

echo $result;

//close connection
curl_close($ch);
?>