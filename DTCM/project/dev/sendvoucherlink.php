<?php


$query_orderRS = sprintf("SELECT * FROM `ticket_orders` WHERE oid = %s", $oid);

//echo $query_orderRS."<br>";

$orderRs = mysql_query($query_orderRS, $eventscon) or die(mysql_error());

$row_orderRs = mysql_fetch_assoc($orderRs);

//print_r($row_orderRs);echo "<br>";

$totalRows_orderRs = mysql_num_rows($orderRs);

//echo $query_orderRS;




$query_custRS = sprintf("SELECT * FROM `customers` WHERE cust_id = %s", $row_orderRs['cust_id']);

$custRs = mysql_query($query_custRS, $eventscon) or die(mysql_error());

$row_custRs = mysql_fetch_assoc($custRs);

//print_r($row_custRs);echo "<br>";

$totalRows_custRs = mysql_num_rows($custRs);

//echo $query_custRS;




$query_eventRS = sprintf("SELECT tid,voucher_image FROM events WHERE tid = %s", $row_orderRs['tid']);

$eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

//print_r($row_eventRs);echo "<br>";

$totalRows_eventRs = mysql_num_rows($eventRs);

//echo $query_eventRS;



if($row_eventRs['voucher_image']!='')
{

//echo $query_priceRS;



$zonetime = 3600*4;

$today = gmdate("l dS \of F Y h:i:s A", time() + $zonetime);

$pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";

  $pageURL .= $_SERVER["SERVER_NAME"].'/tktrush';



$body = "Hi ".$row_custRs['lname']." ".$row_custRs['fname']."\n";

$body .= "---------------------\n";

$body .= "Congratulations You have got a free voucher. Please check the following information for the voucher"."\n";

$body .= "URL: ".$pageURL.'/getvoucher.php?code='.$row_orderRs['uniquecode']."\n";

$body .= "Verification Code: ".$row_orderRs['verifycode']."\n";



$body .= "---------------------\n";


//echo $body;exit;


 $to = $row_custRs['email'];

 $subject = "Free Voucher from Tktrush.com";



$headers = "From: Tickets Rush <nasser@ticketmasters.me>\n";

$headers .= "Reply-To: Tickets Rush <nasser@ticketmasters.me>\n";

//$headers .= "Cc: Ticket Rush <nasser@ticketmasters.me>\n";

$headers .= "MIME-Version: 1.0\n";



$mail_sent = @mail( $to, $subject, $body, $headers );
}
?>