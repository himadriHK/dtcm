<?php
  class Dtcm {
	public static  $dtcm_client_id = '193908c0ac0149f190c678827dab218c';
public static  $dtcm_secret = '3182134e601a4d2496f5b6fed9b39aa3';
 public static  $seller_code = 'AELAB1';
//Sandbox
//$dtcm_url = 'https://api.sandbox.etixdubai.com';
//live
public static $dtcm_url = 'https://api.etixdubai.com';
 
static function get_code() {
//include_once('dtcm_config.php');
$URL=self::$dtcm_url.'/oauth2/accesstoken';
$user = self::$dtcm_client_id;
$pwd= self::$dtcm_secret;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.softix.api-v1.0+json', 'Content-Type: application/x-ww-form-urlencoded'));
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "$user:$pwd");
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_setopt($ch,CURLOPT_POST,1); 
//echo http_build_query(array('grant_type'=>'client_credentials'));
curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query(array('grant_type'=>'client_credentials'))); 
  $result=curl_exec ($ch);
if($result === false)
{
	//return '';
    echo 'Curl error: ' . curl_error($ch);
    
}else {
	return $data_arr = json_decode($result,true);
// $token = $data_arr['access_token'];
}
curl_close ($ch);
}

static function get_prices($access_token,$eventcode) {
//include_once('dtcm_config.php');
$URL=self::$dtcm_url.'/performances/'.$eventcode.'/prices/?channel=W&sellerCode='.self::$seller_code;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$access_token));
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//curl_setopt($ch, CURLOPT_USERPWD, "$dtcm_client_id:$dtcm_secret");
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
//curl_setopt($ch,CURLOPT_POST,1); 
//echo http_build_query(array('grant_type'=>'client_credentials'));
//curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query(array('grant_type'=>'client_credentials'))); 
 $result=curl_exec ($ch);
if($result === false)
{print_r(curl_getinfo($ch));
	//return '';
    echo 'Curl error: ' . curl_error($ch);
    
}else {return $result;
	//$data_arr = json_decode($data,true);
//return $token = $data_arr['access_token'];
}
curl_close ($ch);
}

  static function performance_availability($access_token,$eventcode) {
//include_once('dtcm_config.php');
$URL=self::$dtcm_url.'/performances/'.$eventcode.'/availabilities/?channel=W&sellerCode='.self::$seller_code;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$access_token));
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//curl_setopt($ch, CURLOPT_USERPWD, "$dtcm_client_id:$dtcm_secret");
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
//curl_setopt($ch,CURLOPT_POST,1); 
//echo http_build_query(array('grant_type'=>'client_credentials'));
//curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query(array('grant_type'=>'client_credentials'))); 
 $result=curl_exec ($ch);
if($result === false)
{print_r(curl_getinfo($ch));
	//return '';
    echo 'Curl error: ' . curl_error($ch);
    
}else {return $result;
	//$data_arr = json_decode($data,true);
//return $token = $data_arr['access_token'];
}
curl_close ($ch);
} 

  static function addToBasket($access_token,$basket_info) {
//include_once('dtcm_config.php');
$URL=self::$dtcm_url.'/baskets/';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$access_token));
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//curl_setopt($ch, CURLOPT_USERPWD, "$dtcm_client_id:$dtcm_secret");
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_setopt($ch,CURLOPT_POST,1); 
//echo http_build_query(array('grant_type'=>'client_credentials'));
curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);  echo json_encode($basket_info);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($basket_info)); 
 $result=curl_exec ($ch);
if($result === false)
{//print_r(curl_getinfo($ch));
	//return '';
    echo 'Curl error: ' . curl_error($ch);
    
}else {
	return $result;
	
}
curl_close ($ch);
}

}


 //$access_token = Dtcm::get_code();
//if($access_token)
 //$prices = Dtcm::get_prices($access_token);
 //echo $sections = Dtcm::get_sections($access_token);
 //print_r(json_decode($sections));
?>