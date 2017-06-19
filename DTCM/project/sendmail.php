<?php
mysql_select_db($database_eventscon, $eventscon);
$query_orderRS = sprintf("SELECT * FROM `ticket_orders` WHERE oid = %s", $orderid);
//echo $query_orderRS."<br>";
$orderRs = mysql_query($query_orderRS, $eventscon) or die(mysql_error());
$row_orderRs = mysql_fetch_assoc($orderRs);
//print_r($row_orderRs);echo "<br>";
$totalRows_orderRs = mysql_num_rows($orderRs);
//echo $query_orderRS;
mysql_select_db($database_eventscon, $eventscon);
$query_custRS = sprintf("SELECT * FROM `customers` WHERE cust_id = %s", $custid);
$custRs = mysql_query($query_custRS, $eventscon) or die(mysql_error());
$row_custRs = mysql_fetch_assoc($custRs);
//print_r($row_custRs);echo "<br>";
$totalRows_custRs = mysql_num_rows($custRs);
//echo $query_custRS;
mysql_select_db($database_eventscon, $eventscon);
$query_eventRS = sprintf("SELECT tid, title FROM events WHERE tid = %s", $row_orderRs['tid']);
$eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());
$row_eventRs = mysql_fetch_assoc($eventRs);
//print_r($row_eventRs);echo "<br>";
$totalRows_eventRs = mysql_num_rows($eventRs);
//echo $query_eventRS;
mysql_select_db($database_eventscon, $eventscon);
$query_priceRS = sprintf("SELECT * FROM `event_prices` WHERE tid in (%s)", $row_orderRs['tid']);
$priceRs = mysql_query($query_priceRS, $eventscon) or die(mysql_error());
$totalRows_priceRs = mysql_num_rows($priceRs);
$zonetime = 3600*4;
$today = gmdate("l dS \of F Y h:i:s A", time() + $zonetime);
$seat_type_arr=get_set_type();
$body = "Event Ticket Ordered\n";
$body .= "---------------------\n";
$body .= "Order Number: ".$row_orderRs['order_number']."\n";
$body .= "Customer Name: ".$row_custRs['lname']." ".$row_custRs['fname']."\n";
$body .= "Mobile: ".$row_custRs['mobile']."\n";
$body .= "Email: ".$row_custRs['email']."\n";
$body .= "City: ".$row_custRs['city']."\n";
$body .= "Country: ".$row_custRs['country']."\n\n";
$body .= "Address: ".$row_custRs['address']."\n\n";
$body .= "Event\n";
$body .= "------\n";
$body .= "Title: ".$row_eventRs['title']."\n";
$body .= "Order Date: ".$today."\n";
$body .= "Session Date: ".$row_orderRs['event_date']."\n";
if( $row_orderRs['tid'] != 161){
if($totalRows_priceRs>0)
{
 $ticket_arr=unserialize($row_orderRs['selected_seats']);
while($row_priceRs = mysql_fetch_assoc($priceRs)){
	if($ticket_arr['tickets'][$row_priceRs['pid']] || $ticket_arr['ctickets'][$row_priceRs['pid']]){
	$body .="\n";
	$body .= "------------------------------------\n";
	$body .="Seat Type: ".$seat_type_arr[$row_priceRs['stand']]."\n";
	$body .= "------------------------------------\n";
	$body .= "Ticket Adult Price: ".$row_priceRs['price']."\n";
	
	$body .= "Ticket Child Price: ".$row_priceRs['cprice']."\n";
	
	$body .= "Adult Tickets Ordered: ".(($ticket_arr['tickets'][$row_priceRs['pid']])?$ticket_arr['tickets'][$row_priceRs['pid']]:'0')."\n";
	
	$body .= "Child Tickets Ordered: ".(($ticket_arr['ctickets'][$row_priceRs['pid']])?$ticket_arr['ctickets'][$row_priceRs['pid']]:'0')."\n";
	}
}
}
}else{
    $body .="\n";
	$body .= "------------------------------------\n";
	$body .="Seat Type: General \n";
	$body .= "------------------------------------\n";
	$body .= "Ticket Adult Price: ".$row_orderRs['ticket_price']."\n";
	
	$body .= "Adult Tickets Ordered: ".$row_orderRs['tickets']."\n";
	
	
}
//$tt = (($row_priceRs['price']*$row_orderRs['tickets'])+($row_priceRs['cprice']*$row_orderRs['ctickets']));
$body .= "------------------------------------\n";
$body .="\n";
$body .= "Total Adult Tickets: ".$row_orderRs['tickets']."\n";
//$body .= "Total Child Tickets: ".$row_orderRs['ctickets']."\n";
$body .= "Delivery Charges: ".$row_orderRs['charges']."\n";
$body .= "Total Amount: ".$row_orderRs['ticket_price']."\n";
//echo $body;exit;
$to = $row_custRs['email'];
$subject = "Event Ticket Ordered at Tktrush.com on ".$today;
$headers = "From: Ticket Rush <tickets@tktrush.com>\n";
$headers .= "Reply-To: Ticket Rush <tickets@tktrush.com>\n";
$headers .= "Cc: Ticket Rush <info@tktrush.com>\n";
$headers .= "MIME-Version: 1.0\n";
$file = dirname(__FILE__).'/vouchers/eventticket_'.$row_orderRs['order_number'].".pdf";
$file_size = filesize($file);
$handle = fopen($file, "r");
$content = fread($handle, $file_size);
fclose($handle);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($file);
$headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$headers .= "This is a multi-part message in MIME format.\r\n";
$headers .= "--".$uid."\r\n";
$headers .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$headers .= $body."\r\n\r\n";
$headers .= "--".$uid."\r\n";
$headers .= "Content-Type: application/pdf; name=\"eventticket_".$row_orderRs['order_number'].".pdf\"\r\n"; // use different content types here
$headers .= "Content-Transfer-Encoding: base64\r\n";
$headers .= "Content-Disposition: attachment; filename=\"eventticket_".$row_orderRs['order_number'].".pdf\"\r\n\r\n";
$headers .= $content."\r\n\r\n";
$headers .= "--".$uid."--";
$mail_sent = @mail( $to, $subject, '', $headers );
?>