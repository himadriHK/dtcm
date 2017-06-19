<?php
//extract data from the post
//set POST variables
if( !isset($_SESSION["softix_token"]) ){
require_once 'softix-token.php';
}
$url = 'https://api.etixdubai.com/baskets';
 //\ -H ‚Accept: application/vnd.softix.api-v1.0+json‛ \ -H ‚Accept-Language: en_US‛ \ -u ‚{client}:{secret}‛ \ -d ‚grant_type=client_credentials‛
 $username = '193908c0ac0149f190c678827dab218c';
 $password = '3182134e601a4d2496f5b6fed9b39aa3';
 $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands_obj->PriceTypeCode = 'Q';
$demands_obj->Quantity = 2;
$demands_obj->Admits = 1;
$demands_obj->offerCode = '';
$demands_obj->qualifierCode = '';
$demands_obj->entitlement = '';
$demands_obj->Customer = $cus_obj;
 $demands = array($demands_obj);
 $fee_obj = new stdClass();
 $fee_obj->Type = "5";
 $fee_obj->Code = 'W';
$fields = array(
	'Channel' => 'W',
	'Seller' => 'AELAB1',
	'Performancecode' => 'ETES3EL',
	'Area' => 'SGA',	
	'autoReduce' =>  false,
		"holdcode"=>"",
	'Demand' => $demands,
	'Fees' => array($fee_obj)

);
//var_dump($fields);

//url-ify the data for the POST
$quan = 2;
$fields_string = json_encode($fields);
//var_dump($fields_string);
//var_dump('{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES3EL","Area":"SGA","autoReduce": false,"holdcode":"","Demand":[{"PriceTypeCode":"Q","Quantity":'.$quan.',"Admits":'.$quan.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}],"Fees":[{"Type":"5","Code":"W"}]}');
$fields_string = '{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES3EL","Area":"SGA","autoReduce": false,"holdcode":"","Demand":[{"PriceTypeCode":"Q","Quantity":'.$quan.',"Admits":'.$quan.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}],"Fees":[{"Type":"5","Code":"W"}]}';
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);

 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));

curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch , CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);
$result_ar = json_decode($result);
$car_id = $result_ar->Id;
//var_dump($car_id);
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);
?>