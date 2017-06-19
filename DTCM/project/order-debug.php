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

$orderid = 718;
$custid = '604';
$order_query= sprintf("select * from ticket_orders WHERE oid = %s",$orderid);
	$order_result = mysql_query($order_query, $eventscon) or die(mysql_error());
	
	
echo 'where is the error';
	
	if(mysql_num_rows($order_result)>0)
	{
	$order=mysql_fetch_assoc($order_result);
	echo 'where is the error1\n';
	var_dump($order);
	//file_put_contents("test1.json",json_encode($order));
	$transaction_code = '019176856212';
	$query_update = sprintf("UPDATE ticket_orders SET ccapproved = 'Yes',payment_status ='paid',transaction_code=%s WHERE oid = %s", GetSQLValueString($transaction_code, "text"),$orderid);
echo 'where is the error1\n';
$Result1 = mysql_query($query_update, $eventscon) or die(mysql_error());
echo 'where is the error1\n';
$query_custRS = sprintf("SELECT * FROM customers WHERE 'cust_id' = %s", $custid);
echo 'where is the error2\n';
var_dump($query_custRS);
$custRs = mysql_query($query_custRS, $eventscon) or die(mysql_error());
echo 'where is the error1\n';
$row_custRs = mysql_fetch_assoc($custRs);
var_dump($row_custRs);

$query_eventRS = sprintf("SELECT * FROM events WHERE tid = %s", $order['tid']);

$eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);
var_dump($row_eventRs);

$query_categoryRS = sprintf("SELECT * FROM category WHERE id = %s", $row_eventRs['category']);

$categoryRs = mysql_query($query_categoryRS, $eventscon) or die(mysql_error());

$row_categoryRs = mysql_fetch_assoc($categoryRs);
var_dump($row_categoryRs);

$query_priceRS = sprintf("SELECT * FROM `event_prices` WHERE tid in (%s)", $order['tid']);

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

	$tickets_data .= "Child Tickets: ".$ticket_arr['ctickets'][$row_priceRs['pid']];

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
 $html = file_get_contents('http://www.tktrush.com/ticketsample.html');
$replace_arr = array(
'%%EventDate%%'=>date('Y-m-d',strtotime($order['event_date'])),
'%%PurchaseDate%%'=>date('Y-m-d',strtotime($order['order_date'])),
'%%TransactionNumber%%'=>$transaction_code,
'%%EventName%%'=>$row_eventRs['title'],
'%%EventLoc%%'=>$row_eventRs['venue'],
'%%AgeLimit%%'=>$row_eventRs['age_limit'],
'%%FaceValue%%'=>($order['ticket_price']-$row_eventRs['service_charge']-(($row_eventRs['credit_charge']*$order['ticket_price'])/100)),
'%%TicketCategory%%'=>$row_categoryRs['name'],
'%%ServiceCharge%%'=>$row_eventRs['service_charge'],
'%%SeatNumber%%'=>'',
'%%CCCharge%%'=>($row_eventRs['credit_charge']*$order['ticket_price'])/100,
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
include("sendmail.php");
	}

?>