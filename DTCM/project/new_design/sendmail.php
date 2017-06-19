<?php

mysql_select_db($database_eventscon, $eventscon);

$query_orderRS = sprintf("SELECT * FROM `ticket_orders` WHERE oid = %s", $_SESSION['orderid']);

//echo $query_orderRS."<br>";

$orderRs = mysql_query($query_orderRS, $eventscon) or die(mysql_error());

$row_orderRs = mysql_fetch_assoc($orderRs);

//print_r($row_orderRs);echo "<br>";

$totalRows_orderRs = mysql_num_rows($orderRs);

//echo $query_orderRS;



mysql_select_db($database_eventscon, $eventscon);

$query_custRS = sprintf("SELECT * FROM `customers` WHERE cust_id = %s", $_SESSION['custid']);

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

$query_priceRS = sprintf("SELECT * FROM `event_prices` WHERE pid = %s", $row_orderRs['pid']);

$priceRs = mysql_query($query_priceRS, $eventscon) or die(mysql_error());

$row_priceRs = mysql_fetch_assoc($priceRs);

$totalRows_priceRs = mysql_num_rows($priceRs);

//echo $query_priceRS;



$zonetime = 3600*4;

$today = gmdate("l dS \of F Y h:i:s A", time() + $zonetime);





$body = "Event Ticket Ordered\n";

$body .= "---------------------\n";

$body .= "Customer Name: ".$row_custRs['lname']." ".$row_custRs['fname']."\n";

$body .= "Mobile: ".$row_custRs['mobile']."\n";

$body .= "Email: ".$row_custRs['email']."\n";

$body .= "City: ".$row_custRs['city']."\n";

$body .= "Country: ".$row_custRs['country']."\n\n";

$body .= "Address: ".$row_custRs['address']."\n\n";

//$body .= "Delivery Region: ".$_POST['regions']."\n";

$body .= "Event\n";

$body .= "------\n";

$body .= "Title: ".$row_eventRs['title']."\n";

$body .= "Order Date: ".$today."\n";

$body .= "Session Date: ".$row_orderRs['event_date']."\n";

$body .= "Ticket Adult Price: ".$row_priceRs['price']."\n";

$body .= "Ticket Child Price: ".$row_priceRs['cprice']."\n";

$body .= "Adult Tickets Ordered: ".$row_orderRs['tickets']."\n";

$body .= "Child Tickets Ordered: ".$row_orderRs['ctickets']."\n";

$tt = (($row_priceRs['price']*$row_orderRs['tickets'])+($row_priceRs['cprice']*$row_orderRs['ctickets']));

$body .= "Total Amount: ".$tt."\n";

$body .= "---------------------\n";


//echo $body;exit;


$to = $row_custRs['email'];

$subject = "Event Ticket Ordered at TicketMasters.me on ".$today;



$headers = "From: Ticket Masters <nasser@ticketmasters.me>\n";

$headers .= "Reply-To: Ticket Masters <nasser@ticketmasters.me>\n";

$headers .= "Cc: Ticket Masters <nasser@ticketmasters.me>\n";

$headers .= "MIME-Version: 1.0\n";



$mail_sent = @mail( $to, $subject, $body, $headers );

?>