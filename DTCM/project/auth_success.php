<?php
session_start();
//error_reporting(E_ALL);
$resdata=$_POST;

//file_put_contents("sucess.json",json_encode($resdata));
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
if($resdata['auth_status']=='A' || $resdata['auth_status']=='H')
{

	$transaction_code=$resdata['auth_tranref'];
	$cart_data=explode('-',$resdata['cart_id']);
	$orderid=$cart_data[0];
	$custid=$cart_data[1];
	$amount=$resdata['tran_amount'];
	$order_query= sprintf("select * from ticket_orders WHERE oid = %s",$orderid);
	$order_result_quan = mysql_query($order_query, $eventscon) or die(mysql_error());
	
	$order_quan=mysql_fetch_assoc($order_result_quan);
    $quan = (int)$order_quan['tickets'];
    $quanc = (int)$order_quan['ctickets'];
    $c_data = (int)$order_quan['customer_info'];
    $quanccomp = (int)$order_quan['ccomp'];
    $quanzcomp = (int)$order_quan['zcomp'];
    mysql_free_result($order_quan);
    
    file_put_contents('quan_test.txt',$quan);
    //require_once 'basket-gen.php';
    //
    //
    //
    //
    if( !isset($_SESSION["softix_token"]) ){
require_once 'softix-token.php';
}

$url = 'https://api.etixdubai.com/baskets';
 //\ -H ‚Accept: application/vnd.softix.api-v1.0+json? \ -H ‚Accept-Language: en_US? \ -u ‚{client}:{secret}? \ -d ‚grant_type=client_credentials?
 $username = '193908c0ac0149f190c678827dab218c';
 $password = '3182134e601a4d2496f5b6fed9b39aa3';
 $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands_obj->PriceTypeCode = 'A';
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
	'Performancecode' => 'ETES2016983G',
	'Area' => 'SGA',	
	'autoReduce' =>  false,
		"holdcode"=>"",
	'Demand' => $demands,
	'Fees' => array($fee_obj)

);
//var_dump($fields);

//url-ify the data for the POST
$quan = $quan;
$quan_type = gettype($quan);
$quanc_type = gettype($quan);
$quanccomp_type = gettype($quan);
$quanzcomp_type = gettype($quan);
file_put_contents('allquan_test.txt',$quan.'x'.$quan_type.'x'.$quanc.'x'.$quanc_type.'x'.$quanccomp.'x'.$quanccomp_type.'x'.$quanzcomp.'x'.$quanzcomp_type);
$fields_string = json_encode($fields);
//var_dump($fields_string);
//var_dump('{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES2016983G","Area":"SGA","autoReduce": false,"holdcode":"","Demand":[{"PriceTypeCode":"Q","Quantity":'.$quan.',"Admits":'.$quan.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}],"Fees":[{"Type":"5","Code":"W"}]}');
if($quan > 0 && $quanc <= 0){
    $dem = '{"PriceTypeCode":"A","Quantity":'.$quan.',"Admits":'.$quan.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}';
}else if($quan > 0 && $quanc > 0){
    $dem = '{"PriceTypeCode":"A","Quantity":'.$quan.',"Admits":'.$quan.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}},'
            . '{"PriceTypeCode":"V","Quantity":'.$quanc.',"Admits":'.$quanc.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}';
}else if($quan <= 0 && $quanc > 0){
    $dem = '{"PriceTypeCode":"V","Quantity":'.$quanc.',"Admits":'.$quanc.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}';
}

file_put_contents('dem_test.txt',$dem);
$fields_string = '{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES2016983G","Area":"SGA","autoReduce": false,"holdcode":"","Demand":['.$dem.'],"Fees":[{"Type":"5","Code":"W"}]}';
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
file_put_contents('car_cre_res.txt',$result);
file_put_contents('car_cre_hed.txt',curl_getinfo($ch));
$result_ar = json_decode($result);
$car_id = $result_ar->Id;
file_put_contents('vcar.txt',$car_id);
//var_dump($car_id);
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);

//die('died here');

////////////////////////////
//
//Comp adding basket
///////////////////////////


if($quanccomp > 0 && $quanzcomp <= 0){
    $comp_dem = '{"PriceTypeCode":"C","Quantity":'.$quanccomp.',"Admits":'.$quanccomp.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}';
}else if($quanccomp > 0 && $quanzcomp > 0){
    $comp_dem = '{"PriceTypeCode":"C","Quantity":'.$quanccomp.',"Admits":'.$quanccomp.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}},'
            . '{"PriceTypeCode":"Z","Quantity":'.$quanzcomp.',"Admits":'.$quanzcomp.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}';
}else if($quanccomp <= 0 && $quanzcomp > 0){
    $comp_dem = '{"PriceTypeCode":"Z","Quantity":'.$quanzcomp.',"Admits":'.$quanzcomp.',"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}';
}
file_put_contents('comp_details.txt',$quanccomp.'/'.$quanzcomp.'/'.$comp_dem);
if($comp_dem){
	$comp_fields_string = '{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES2016983G","Area":"SGA","autoReduce": false,"holdcode":"","Demand":['.$comp_dem.'],"Fees":[{"Type":"5","Code":"W"}]}';
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);

 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));

curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $comp_fields_string);
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch , CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);
$result_ar = json_decode($result);
$comp_car_id = $result_ar->Id;
file_put_contents('ccar.txt',$comp_car_id);
//file_put_contents('car.txt',$car_id);
//var_dump($car_id);
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);
}
    //////////////////////////
    //
    //Basket Purchase
    //////////////////////////
    //extract data from the post
//set POST variables
//

$url = 'https://api.etixdubai.com/performances/ETES2016983G/prices?channel=W&sellerCode=AELAB1';
$accesstoken = '165c91e5bf2649c98c6e106e2d94fb1f';


//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//execute post
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$result = json_decode($result);
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//var_dump($_SESSION["softix_token"]);
//var_dump($result->TicketPrices->Prices);
//var_dump(count($result->TicketPrices->Prices));
for($i=0; $i<=count($result->TicketPrices->Prices); $i++){
	if($result->TicketPrices->Prices[$i]->PriceCategoryCode == '3' && $result->TicketPrices->Prices[$i]->PriceTypeCode == 'A'){
		$single_price = $result->TicketPrices->Prices[$i]->PriceNet;
	}
        
        	if($result->TicketPrices->Prices[$i]->PriceCategoryCode == '3' && $result->TicketPrices->Prices[$i]->PriceTypeCode == 'V'){
		$ano_price = $result->TicketPrices->Prices[$i]->PriceNet;
	}
}
//var_dump($single_price);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);
//require_once 'softix-ticket-price.php';
////////
///////
//////
$cus_quer = sprintf("SELECT * FROM customers WHERE cust_id = %s", $custid);
//echo 'where is the error2\n';
//var_dump($query_custRS);
$cus_quer_res = mysql_query($cus_quer, $eventscon) or die(mysql_error());
//echo 'where is the error1\n';
$cus_quer_details = mysql_fetch_assoc($cus_quer_res);

file_put_contents('price.txt',$single_price);
$url = 'https://api.etixdubai.com/Baskets/'.$car_id.'/purchase';
 //\ -H ‚Accept: application/vnd.softix.api-v1.0+json? \ -H ‚Accept-Language: en_US? \ -u ‚{client}:{secret}? \ -d ‚grant_type=client_credentials?
 $username = '193908c0ac0149f190c678827dab218c';
 $password = '3182134e601a4d2496f5b6fed9b39aa3';
 $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands_obj->PriceTypeCode = 'A';
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
	'Performancecode' => 'ETES2016983G',
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
$amt = ($single_price*$quan)+($ano_price*$quanc);
file_put_contents('amount.txt',$amt);
$dtcm_c_data = $cus_quer_details['dtcm_id'];
//var_dump('{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES2016983G","Area":"SGA","autoReduce": false,"holdcode":"","Demand":[{"PriceTypeCode":"Q","Quantity":1,"Admits":1,"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}],"Fees":[{"Type":"5","Code":"W"}]}');
$fields_string = '{"Seller":"AELAB1","customer":'.$dtcm_c_data.',"Payments":[{"Amount":'.$amt.',"MeansOfPayment":"EXTERNAL"}]}';
file_put_contents('fields_str.txt',$fields_string);
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);

 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));

curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
$result = curl_exec($ch);
file_put_contents('order_result.txt',$result);
$result_a = json_decode($result);
$order_idd = $result_a->OrderId;
file_put_contents('reg_purchase.txt',$result,FILE_APPEND);
file_put_contents('order.txt',$order_idd);
file_put_contents('vorder.txt',$order_idd);
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);
$query_update_b_id = sprintf("UPDATE ticket_orders SET basket_id = '$order_idd' WHERE oid = %s",$orderid);
mysql_query($query_update_b_id, $eventscon) or die(mysql_error());
$value_order_id = $order_idd;
///////////////////////
/////
//// Comp Basket purchase
//////////////////////
if($comp_dem){
	$url = 'https://api.etixdubai.com/Baskets/'.$comp_car_id.'/purchase';
 //\ -H ‚Accept: application/vnd.softix.api-v1.0+json? \ -H ‚Accept-Language: en_US? \ -u ‚{client}:{secret}? \ -d ‚grant_type=client_credentials?
 $username = '193908c0ac0149f190c678827dab218c';
 $password = '3182134e601a4d2496f5b6fed9b39aa3';
 $cus_obj = new stdClass();
$demands_obj = new stdClass();
$demands_obj->PriceTypeCode = 'A';
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
	'Performancecode' => 'ETES2016983G',
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
$amt = 0;
//file_put_contents('amount.txt',$amt);
$dtcm_c_data = $cus_quer_details['dtcm_id'];
//var_dump('{"Channel":"W","Seller":"AELAB1","Performancecode":"ETES2016983G","Area":"SGA","autoReduce": false,"holdcode":"","Demand":[{"PriceTypeCode":"Q","Quantity":1,"Admits":1,"offerCode":"","qualifierCode":"","entitlement":"","Customer":{}}],"Fees":[{"Type":"5","Code":"W"}]}');
$fields_string = '{"Seller":"AELAB1","customer":'.$dtcm_c_data.',"Payments":[{"Amount":'.$amt.',"MeansOfPayment":"EXTERNAL"}]}';
//file_put_contents('fields_str.txt',$fields_string);
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);

 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization: Bearer '.$_SESSION["softix_token"]));

curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//curl_setopt ($ch, CURLOPT_CAINFO, "C:\wamp64/cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
$result = curl_exec($ch);
file_put_contents('order_result.txt',$result);
$result_a = json_decode($result);
$order_idd = $result_a->OrderId;
file_put_contents('comp_purchase.txt',$result,FILE_APPEND);
file_put_contents('order.txt',$order_idd);
file_put_contents('corder.txt',$order_idd);
//var_dump($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch));
//close connection
curl_close($ch);
$query_update_b_id = sprintf("UPDATE ticket_orders SET c_basket_id = '$order_idd' WHERE oid = %s",$orderid);
mysql_query($query_update_b_id, $eventscon) or die(mysql_error());
}
		$order_query= sprintf("select * from ticket_orders WHERE oid = %s",$orderid);
	$order_result = mysql_query($order_query, $eventscon) or die(mysql_error());
	
	$order=mysql_fetch_assoc($order_result);
	if(mysql_num_rows($order_result)>0)
	//if(mysql_num_rows($order_result)>0)
	{
        file_put_contents('inside_order_d.txt',$order);
        file_put_contents('inside_or.txt','or');
        
	//echo 'where is the error1\n';
	//file_put_contents("test1.json",json_encode($order));
	//$transaction_code = '019176856212';
	$query_update = sprintf("UPDATE ticket_orders SET ccapproved = 'Yes',payment_status ='paid',transaction_code=%s WHERE oid = %s", GetSQLValueString($transaction_code, "text"),$orderid);
//echo 'where is the error1\n';
$Result1 = mysql_query($query_update, $eventscon) or die(mysql_error());
//echo 'where is the error1\n';
$query_custRS = sprintf("SELECT * FROM customers WHERE 'cust_id' = %s", $custid);
//echo 'where is the error2\n';
//var_dump($query_custRS);
$custRs = mysql_query($query_custRS, $eventscon) or die(mysql_error());
//echo 'where is the error1\n';
$row_custRs = mysql_fetch_assoc($custRs);
//var_dump($row_custRs);
file_put_contents('inside_c.txt','c');
$query_eventRS = sprintf("SELECT * FROM events WHERE tid = %s", $order['tid']);
file_put_contents('inside_equery.txt',$query_eventRS);
$eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());
file_put_contents('inside_equery_ex.txt',$eventRS);
$row_eventRs = mysql_fetch_assoc($eventRs);
//var_dump($row_eventRs);
file_put_contents('inside_e.txt','e');
$query_categoryRS = sprintf("SELECT * FROM category WHERE id = %s", $row_eventRs['category']);

$categoryRs = mysql_query($query_categoryRS, $eventscon) or die(mysql_error());

$row_categoryRs = mysql_fetch_assoc($categoryRs);
//var_dump($row_categoryRs);
file_put_contents('inside_cc.txt','cc');
$query_priceRS = sprintf("SELECT * FROM event_prices WHERE tid in (%s)", $order['tid']);

$priceRs = mysql_query($query_priceRS, $eventscon) or die(mysql_error());
$totalRows_priceRs = mysql_num_rows($priceRs);
//file_put_contents("test2.txt",$totalRows_priceRs);
$tickets_data='';
$t=0;
$seat_type_arr=get_set_type();
//file_put_contents("test3.json",json_encode($seat_type_arr));
	if($totalRows_priceRs>0)

{

 $ticket_arr=unserialize($order['selected_seats']);



while($row_priceRs = mysql_fetch_assoc($priceRs)){

	if($ticket_arr['tickets'][$row_priceRs['pid']] || $ticket_arr['ctickets'][$row_priceRs['pid']]){
		$tickets_data.="<tr>";
	
	

	$tickets_data .= '<td style="padding: 5px 10px;">';

	$tickets_data .="Seat Type: ".$seat_type_arr[$row_priceRs['stand']]."</td>";

	$tickets_data .= '<td style="padding: 5px 10px;">';

	
	if($ticket_arr['tickets'][$row_priceRs['pid']]){

	$tickets_data .= "Adult Tickets: ".$ticket_arr['tickets'][$row_priceRs['pid']]." ";

	}
	if($ticket_arr['ctickets'][$row_priceRs['pid']]){

	$tickets_data .= "ELAB Tickets: ".$ticket_arr['ctickets'][$row_priceRs['pid']];

	}
	$tickets_data .= "</td></tr>";
	}

	}

}
$sponsor_logos='';
if($row_eventRs['sponsor_logo1']!='')
$sponsor_logos.='<img src="http://www.tktrush.com/data/'.$row_eventRs['sponsor_logo1'].'" alt="" width="70" height="72" style="margin-left:2px;" />';
if($row_eventRs['sponsor_logo2']!='')
$sponsor_logos.='<img src="http://www.tktrush.com/data/'.$row_eventRs['sponsor_logo2'].'" alt="" width="70" height="72" style="margin-left:2px;" />';
if($row_eventRs['sponsor_logo3']!='')
$sponsor_logos.='<img src="http://www.tktrush.com/data/'.$row_eventRs['sponsor_logo3'].'" alt="" width="70" height="72" style="margin-left:2px;" />';
if($row_eventRs['sponsor_logo4']!='')
$sponsor_logos.='<img src="http://www.tktrush.com/data/'.$row_eventRs['sponsor_logo4'].'" alt="" width="70" height="72" style="margin-left:2px;" />';
//file_put_contents("test4.txt",$tickets_data);
include_once "dompdf/dompdf_config.inc.php";
ob_start();
require_once 'ticketsample.php';
$html = ob_get_clean();
 
$replace_arr = array(
'%%EventDate%%'=>date('Y-m-d',strtotime($order['event_date'])),
'%%PurchaseDate%%'=>date('Y-m-d',strtotime($order['order_date'])),
'%%TransactionNumber%%'=>$transaction_code,
'%%EventName%%'=>$row_eventRs['title'],
'%%EventLoc%%'=>$row_eventRs['venue'],
'%%AgeLimit%%'=>$row_eventRs['age_limit'],
'%%FaceValue%%'=>(( ($order['ticket_price']-2) / (5+100) )*100),
'%%TicketCategory%%'=>$row_categoryRs['name'],
'%%ServiceCharge%%'=>$row_eventRs['service_charge'],
'%%SeatNumber%%'=>'',
'%%CCCharge%%'=>(($order['ticket_price']-2)-(( ($order['ticket_price']-2) / (5+100) )*100)),
'%%TicketNumber%%'=>$order['order_number'],
'%%TotalAmount%%'=>$order['ticket_price'],
'%%Name%%'=>$row_custRs['lname']." ".$row_custRs['fname'],
'%%code%%'=>$order['order_number'],
'%%EventPicture%%'=>'http://www.tktrush.com/data/'.$row_eventRs['pic'],
'%%Tickets%%'=>$tickets_data,
'%%EventSponser%%'=>$sponsor_logos,
'%%VoucherAdvert1%%'=>(($row_eventRs['voucher_advert1']!='')?'http://www.tktrush.com/data/'.$row_eventRs['voucher_advert1']:'http://www.tktrush.com/images/controed1.png'),
'%%VoucherAdvert2%%'=>(($row_eventRs['voucher_advert2']!='')?'http://www.tktrush.com/data/'.$row_eventRs['voucher_advert2']:'http://www.tktrush.com/images/controed2.png'),
);
	//file_put_contents("test5.json",json_encode($replace_arr));
    foreach($replace_arr as $key => $val){
    	$html = str_replace($key,$val,$html);
    }
    $dompdf = new DOMPDF() ;
    $dompdf->load_html($html);
    $dompdf->render();
    //if ($stream) {
       //$dompdf->stream(dirname(__FILE__)."/eventticket.pdf");
    /*} else {
        return $dompdf->output();
    }*/
    $pdf=$dompdf->output();
       $file_location = dirname(__FILE__)."/vouchers/eventticket_".$order['order_number'].".pdf";
       file_put_contents($file_location,$pdf);
       if(!empty($order['basket_id'])){
include("sendmail.php");
       }
	}
}
else
{
	$transaction_code=$resdata['auth_tranref'];
	$cart_data=explode('-',$resdata['cart_id']);
	$orderid=$cart_data[0];
	$custid=$cart_data[1];
	$amount=$resdata['tran_amount'];
	$order_query= sprintf("select * from ticket_orders WHERE oid = %s",$orderid);
	$order_result = mysql_query($order_query, $eventscon) or die(mysql_error());
	if(mysql_num_rows($order_result)>0)
	{
	$order=mysql_fetch_assoc($order_result);
	$query_update = sprintf("UPDATE ticket_orders SET payment_status ='cancelled',transaction_code=%s WHERE oid = %s", GetSQLValueString($transaction_code, "text"),$orderid);

$Result1 = mysql_query($query_update, $eventscon) or die(mysql_error());
	}
}
?>