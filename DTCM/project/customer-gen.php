<?php
require_once('Connections/eventscon.php'); 
 include("functions.php");
require_once('dtcm_api.php');
 include("config.php");
require_once('model_function.php');
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

switch ($theType) {

case "text":

$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

break;    

case "long":

case "int":

$theValue = ($theValue != "") ? intval($theValue) : "0";

break;

case "double":

$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

break;

case "date":

$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

break;

case "defined":

$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

break;

}

return $theValue;

}
//extract data from the post
//set POST variables
$url = 'https://api.etixdubai.com/customers?sellerCode=AELAB1';
 //\ -H ‚Accept: application/vnd.softix.api-v1.0+json‛ \ -H ‚Accept-Language: en_US‛ \ -u ‚{client}:{secret}‛ \ -d ‚grant_type=client_credentials‛
 $username = '193908c0ac0149f190c678827dab218c';
 $password = '3182134e601a4d2496f5b6fed9b39aa3';
 $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands_obj->PriceTypeCode = 'Q';
$demands_obj->Quantity = 1;
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

$fields_string = json_encode($fields);
//var_dump($fields_string);
//var_dump('{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES3EL","Area":"SGA","autoReduce": false,"holdcode":"","Demand":[{"PriceTypeCode":"Q","Quantity":1,"Admits":1,"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}],"Fees":[{"Type":"5","Code":"W"}]}');
$fields_string = '{"salutation":"-","firstname":"ajilan","lastname":"A ","nationality":"IN","email":"unknown@unknow.com","dateofbirth":"4-23-2015","internationalcode":"971","areacode":"unknown","phonenumber":"507156120","addressline1":"-","addressline2":"-","addressline3":"-","city":"dubai","state":"dubai","countrycode":"AE"}';
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);

 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer 12dafe1598d2467cbbd294fe262ff993'));

curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
$result = curl_exec($ch);
var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);
$insertSQL = sprintf("UPDATE ticket_orders SET customer_info='$result' WHERE oid='732'");
$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
var_dump($Result1);
?>