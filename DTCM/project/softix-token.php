<?php

$url = 'https://api.etixdubai.com/oauth2/accesstoken';
 //\ -H â€šAccept: application/vnd.softix.api-v1.0+jsonâ€› \ -H â€šAccept-Language: en_USâ€› \ -u â€š{client}:{secret}â€› \ -d â€šgrant_type=client_credentialsâ€›
 $username = '193908c0ac0149f190c678827dab218c';
 $password = '3182134e601a4d2496f5b6fed9b39aa3';

 
$fields = array(
	'grant_type' => urlencode('client_credentials'),
);

//url-ify the data for the POST
$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.softix.api-v1.0+json', 'Accept-Language:en_US'));
 curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);

$token = json_decode($result);
$token = $token->access_token;
$_SESSION["softix_token"] = $token;
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);

?>