<?php 

require_once('Connections/eventscon.php'); 
require_once('dtcm_api.php');
include("functions.php"); 
include("config.php"); 

require_once('model_function.php');

if(empty($_SESSION['Customer']))



{



	$_SESSION['referer']=$_SERVER['REQUEST_URI'];



	header("location:signin.php");exit;



}

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
function getDtcmPriceVal($id,$ticket_prices){
	foreach ($ticket_prices['TicketPrices']['Prices'] as $price){
		if($price['PriceId']==$id) {
			return $price;
		}
	}
	return '';
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

/*$insertSQL = sprintf("INSERT INTO customers (fname, lname, mobile, email, city, country, address) VALUES (%s, %s, %s, %s, %s, %s, %s)",

GetSQLValueString($_POST['fname'], "text"),

GetSQLValueString($_POST['lname'], "text"),

GetSQLValueString($_POST['mobile'], "text"),

GetSQLValueString($_POST['email'], "text"),

GetSQLValueString($_POST['city'], "text"),

GetSQLValueString($_POST['country'], "text"),

GetSQLValueString($_POST['address'], "text"));

mysql_select_db($database_eventscon, $eventscon);

$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());*/

/*  if($Result1){

$_SESSION['custid'] = mysql_insert_id();

}*/



##Update customer data

$cust_sql="UPDATE customers set country='".$_POST['country']."', city='".$_POST['city']."', mobile='".$_POST['mobile']."', fname='".$_POST['fname']."', lname='".$_POST['lname']."', address='".$_POST['address']."' where cust_id='".$_SESSION['Customer']['cust_id']."'";

mysql_query($cust_sql);

$cust_sql="select * from customers where cust_id=".$_SESSION['Customer']['cust_id'];

$restult=mysql_query($cust_sql);

$customers=mysql_fetch_assoc($restult);

unset($_SESSION['Customer']);

$_SESSION['Customer']=$customers;

##End of update customer data

$eventid = $_POST['eid'];

$query_eventRs = sprintf("SELECT events.* FROM events WHERE events.tid=%s", $eventid);

$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

$_SESSION['custid']=$_SESSION['Customer']['cust_id'];

if($row_eventRs['voucher_image']!='')

{

$uniquecode=uniqid();

$verifycode=getRandomCode();

}

else

{

	$uniquecode='';

	$verifycode='';

}

$pids=array();

$tot_tickets=0;

$tot_ctickets=0;

$total_price=0;
if($_SERVER['REMOTE_ADDR']=='106.220.145.16'){
	$row_eventRs['dtcm_approved']='Yes';
	$row_eventRs['dtcm_code'] = 'ETES3EL';
}
if($row_eventRs['dtcm_approved']=='Yes' && $row_eventRs['dtcm_code']!='' ) {
	$eventcode = $row_eventRs['dtcm_code'];
if(isset($_SESSION['access_token']) && (time()-$_SESSION['token_addtime'])<$_SESSION['token_lifetime']){
	//if(isset($_SESSION['access_token'])){
		$access_token = $_SESSION['access_token'];
} else{
$code_details = Dtcm::get_code();
if($code_details['access_token']!=''){
$access_token=$code_details['access_token'];
$_SESSION['access_token']=$access_token;
$_SESSION['token_lifetime']=$code_details['expires'];
$_SESSION['token_addtime']=time();
}
}
if($access_token){
$prices = Dtcm::get_prices($access_token,$eventcode);
$ticket_prices = json_decode($prices,true);
}
$basket_info=array();
$b=1;
$pcats=array();
foreach($_POST['tickets'] as $key=>$val)

	{
		$tot_tickets=$tot_tickets+$val;
		if($val){

			$pids[$key]=$key;

			

			$price_values = getDtcmPriceVal($key,$ticket_prices);

			$total_price=$total_price+($price_values['PriceNet']*$val);
			$pcats[$price_values['PriceCategoryCode']][]=$price_values;
		}
	}
	$total_price=$total_price+$_POST['charges'];

$pids=implode(",",$pids);
if(!empty($pcats)){
	foreach($pcats as $catcode => $price_data){
		$basket_info['channel']='W';
		$basket_info['seller']=Dtcm::$seller_code;
		$basket_info['performancecode']=$eventcode;
		$basket_info['area']='@0';
		$basket_info['autoReduce']=false;
		foreach ($price_data as $p){
			$basket_info['demand'][]=array(
								'priceTypeCode'=>$p['PriceTypeCode'],
								'quantity'=>$_POST['tickets'][$p['PriceId']],
								'admits'=>$_POST['tickets'][$p['PriceId']],
								'offerCode'=>'',
								'qualifierCode'=>'',
								'entitlement'=>'',
								'Customer'=> array()
			);
		}
	}
}
if(!empty($basket_info)){
	if(isset($_SESSION['access_token']) && (time()-$_SESSION['token_addtime'])<$_SESSION['token_lifetime']){
	//if(isset($_SESSION['access_token'])){
		$access_token = $_SESSION['access_token'];
	} else{
	$code_details = Dtcm::get_code();
		if($code_details['access_token']!=''){
			$access_token=$code_details['access_token'];
			$_SESSION['access_token']=$access_token;
			$_SESSION['token_lifetime']=$code_details['expires'];
			$_SESSION['token_addtime']=time();
		}
	}print_r($basket_info);
	$basket_details = Dtcm::addToBasket($access_token,$basket_info);
	print_r($basket_details);exit;
	$basket_id = $basket_details['originBasketId'];
	$seat_arr['tickets']=$_POST['tickets'];
	
	$seat_arr['ctickets']=$_POST['ctickets'];
	
	$selected_seats=serialize($seat_arr);
	
	$sessiondate = $_POST["sessiondate"];
	$order_number=mt_rand(100000, 999999);
	if($sessiondate=="Ongoing"){ $sessiondate = date("Y-m-d"); }
	
	$insertSQL = sprintf("INSERT INTO ticket_orders (order_number,cust_id, tid,selected_seats, pid, ticket_price,charges,order_date, event_date, payment_type, tickets, ctickets,uniquecode,verifycode,basket_id) VALUES (%s,%s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s,%s)",
	
	GetSQLValueString($order_number, "text"),
	
	GetSQLValueString($_SESSION['custid'], "int"),
	
	GetSQLValueString($_POST['eid'], "int"),
	
	GetSQLValueString($selected_seats, "text"),
	
	GetSQLValueString($pids, "text"),
	
	GetSQLValueString($total_price, "text"),
	
	GetSQLValueString($_POST['charges'], "text"),
	
	GetSQLValueString(date("Y-m-d"), "date"),
	
	GetSQLValueString($sessiondate, "date"),
	
	GetSQLValueString($_POST['paytype'], "text"),
	
	GetSQLValueString($tot_tickets, "int"),
	
	GetSQLValueString($tot_ctickets, "int"),
	
	GetSQLValueString($uniquecode, "text"),
	GetSQLValueString($verifycode, "text"),
	GetSQLValueString($basket_id, "text"));
	
	
	
	$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
	
	if($Result1){
	
	$_SESSION['orderid'] = mysql_insert_id();
	
	}
}
} else {
if($_POST['tickets'])

{

	foreach($_POST['tickets'] as $key=>$val)

	{

		$tot_tickets=$tot_tickets+$val;

		if($val){

			$pids[$key]=$key;

			$sql="select * from event_prices where pid=$key";

			$price_query = mysql_query($sql, $eventscon) or die(mysql_error());

			$prive_values = mysql_fetch_assoc($price_query);

			$total_price=$total_price+($prive_values['price']*$val);

		}

	}

	foreach($_POST['ctickets'] as $key=>$val)

	{

		$tot_ctickets=$tot_ctickets+$val;

		if($val){

			$pids[$key]=$key;

			$sql="select * from event_prices where pid=$key";

			$price_query = mysql_query($sql, $eventscon) or die(mysql_error());

			$prive_values = mysql_fetch_assoc($price_query);

			$total_price=$total_price+($prive_values['cprice']*$val);

		}

	}

}

$total_price=$total_price+$_POST['charges'];

$pids=implode(",",$pids);



$seat_arr['tickets']=$_POST['tickets'];

$seat_arr['ctickets']=$_POST['ctickets'];

$selected_seats=serialize($seat_arr);

$sessiondate = $_POST["sessiondate"];
$order_number=mt_rand(100000, 999999);
if($sessiondate=="Ongoing"){ $sessiondate = date("Y-m-d"); }

$insertSQL = sprintf("INSERT INTO ticket_orders (order_number,cust_id, tid,selected_seats, pid, ticket_price,charges,order_date, event_date, payment_type, tickets, ctickets,uniquecode,verifycode) VALUES (%s,%s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s)",

GetSQLValueString($order_number, "text"),

GetSQLValueString($_SESSION['custid'], "int"),

GetSQLValueString($_POST['eid'], "int"),

GetSQLValueString($selected_seats, "text"),

GetSQLValueString($pids, "text"),

GetSQLValueString($total_price, "text"),

GetSQLValueString($_POST['charges'], "text"),

GetSQLValueString(date("Y-m-d"), "date"),

GetSQLValueString($sessiondate, "date"),

GetSQLValueString($_POST['paytype'], "text"),

GetSQLValueString($tot_tickets, "int"),

GetSQLValueString($tot_ctickets, "int"),

GetSQLValueString($uniquecode, "text"),

GetSQLValueString($verifycode, "text"));



$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());

if($Result1){

$_SESSION['orderid'] = mysql_insert_id();

}
}
}