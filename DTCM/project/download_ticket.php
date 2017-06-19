<?php
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
//echo '<pre>'; print_r($_SESSION); exit;
$downloadStatus = 0;
if(isset($_SESSION['PP_UserId']))
{

	//$transaction_code=$resdata['auth_tranref'];
	//$cart_data=explode('-',$resdata['cart_id']);
	$orderid=$_SESSION['orderid'];

   // $custid=$_SESSION['PP_UserId'];

    //$amount=$resdata['tran_amount'];
	$order_query= sprintf("select * from ticket_orders WHERE oid = %s",$orderid);
	$order_result = mysql_query($order_query, $eventscon) or die(mysql_error());
	
	

	
	if(mysql_num_rows($order_result)>0) {
        $order = mysql_fetch_assoc($order_result);
        if ($order['partner_id'] == $_SESSION['PP_UserId']) {
            $amount = $order['ticket_price'];
            //file_put_contents("test1.json",json_encode($order));
            //$query_update = sprintf("UPDATE ticket_orders SET ccapproved = 'Yes',payment_status ='paid',transaction_code=%s WHERE oid = %s", GetSQLValueString($transaction_code, "text"),$orderid);

//$Result1 = mysql_query($query_update, $eventscon) or die(mysql_error());

//$query_custRS = sprintf("SELECT * FROM `customers` WHERE cust_id = %s", $custid);

//$custRs = mysql_query($query_custRS, $eventscon) or die(mysql_error());

//$row_custRs = mysql_fetch_assoc($custRs);
            $row_custRs = unserialize($order['customer_info']);
//echo '<pre>'; print_r($order); echo '############';
            //print_r($row_custRs); exit;
            $query_eventRS = sprintf("SELECT * FROM events WHERE tid = %s", $order['tid']);

            $eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());

            $row_eventRs = mysql_fetch_assoc($eventRs);

            $query_categoryRS = sprintf("SELECT * FROM category WHERE id = %s", $row_eventRs['category']);

            $categoryRs = mysql_query($query_categoryRS, $eventscon) or die(mysql_error());

            $row_categoryRs = mysql_fetch_assoc($categoryRs);

            $query_priceRS = sprintf("SELECT * FROM `event_prices` WHERE tid in (%s)", $order['tid']);

            $priceRs = mysql_query($query_priceRS, $eventscon) or die(mysql_error());
            $totalRows_priceRs = mysql_num_rows($priceRs);
//file_put_contents("test2.txt",$totalRows_priceRs);
            $tickets_data = '';
            $t = 0;
            $seat_type_arr = get_set_type();
//file_put_contents("test3.json",json_encode($seat_type_arr));
            if ($totalRows_priceRs > 0) {

                $ticket_arr = unserialize($order['selected_seats']);


                while ($row_priceRs = mysql_fetch_assoc($priceRs)) {

                    if ($ticket_arr['tickets'][$row_priceRs['pid']] || $ticket_arr['ctickets'][$row_priceRs['pid']]) {
                        $tickets_data .= "<tr>";


                        $tickets_data .= '<td style="padding: 5px 10px;">';

                        $tickets_data .= "Seat Type: " . $seat_type_arr[$row_priceRs['stand']] . "</td>";

                        $tickets_data .= '<td style="padding: 5px 10px;">';


                        if ($ticket_arr['tickets'][$row_priceRs['pid']]) {

                            $tickets_data .= "Adult Tickets: " . $ticket_arr['tickets'][$row_priceRs['pid']] . " ";

                        }
                        if ($ticket_arr['ctickets'][$row_priceRs['pid']]) {

                            $tickets_data .= "Child Tickets: " . $ticket_arr['ctickets'][$row_priceRs['pid']];

                        }
                        $tickets_data .= "</td></tr>";
                    }

                }

            }
            $sponsor_logos = '';
            if ($row_eventRs['sponsor_logo1'] != '')
                $sponsor_logos .= '<img src="http://www.tktrush.com/data/' . $row_eventRs['sponsor_logo1'] . '" alt="" width="70" height="72" style="margin-left:2px;" />';
            if ($row_eventRs['sponsor_logo2'] != '')
                $sponsor_logos .= '<img src="http://www.tktrush.com/data/' . $row_eventRs['sponsor_logo2'] . '" alt="" width="70" height="72" style="margin-left:2px;" />';
            if ($row_eventRs['sponsor_logo3'] != '')
                $sponsor_logos .= '<img src="http://www.tktrush.com/data/' . $row_eventRs['sponsor_logo3'] . '" alt="" width="70" height="72" style="margin-left:2px;" />';
            if ($row_eventRs['sponsor_logo4'] != '')
                $sponsor_logos .= '<img src="http://www.tktrush.com/data/' . $row_eventRs['sponsor_logo4'] . '" alt="" width="70" height="72" style="margin-left:2px;" />';
//file_put_contents("test4.txt",$tickets_data);
            include_once "dompdf/dompdf_config.inc.php";
            $html = file_get_contents('http://www.tktrush.com/ticketsample.html');
            $replace_arr = array(
                '%%EventDate%%' => date('Y-m-d', strtotime($order['event_date'])),
                '%%PurchaseDate%%' => date('Y-m-d', strtotime($order['order_date'])),
                '%%TransactionNumber%%' => $transaction_code,
                '%%EventName%%' => $row_eventRs['title'],
                '%%EventLoc%%' => $row_eventRs['venue'],
                '%%AgeLimit%%' => $row_eventRs['age_limit'],
                '%%FaceValue%%' => ($order['ticket_price'] - $row_eventRs['service_charge'] - (($row_eventRs['credit_charge'] * $order['ticket_price']) / 100)),
                '%%TicketCategory%%' => $row_categoryRs['name'],
                '%%ServiceCharge%%' => $row_eventRs['service_charge'],
                '%%SeatNumber%%' => '',
                '%%CCCharge%%' => ($row_eventRs['credit_charge'] * $order['ticket_price']) / 100,
                '%%TicketNumber%%' => $order['order_number'],
                '%%TotalAmount%%' => $order['ticket_price'],
                '%%Name%%' => $row_custRs['lname'] . " " . $row_custRs['fname'],
                '%%code%%' => $order['order_number'],
                '%%EventPicture%%' => 'http://www.tktrush.com/data/' . $row_eventRs['pic'],
                '%%Tickets%%' => $tickets_data,
                '%%EventSponser%%' => $sponsor_logos,
                '%%VoucherAdvert1%%' => (($row_eventRs['voucher_advert1'] != '') ? 'http://www.tktrush.com/data/' . $row_eventRs['voucher_advert1'] : 'http://www.tktrush.com/images/controed1.png'),
                '%%VoucherAdvert2%%' => (($row_eventRs['voucher_advert2'] != '') ? 'http://www.tktrush.com/data/' . $row_eventRs['voucher_advert2'] : 'http://www.tktrush.com/images/controed2.png'),
            );
            //file_put_contents("test5.json",json_encode($replace_arr));
            foreach ($replace_arr as $key => $val) {
                $html = str_replace($key, $val, $html);
            }
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            //$dompdf->output();
            // exit;
            //if ($stream) {
            //$dompdf->stream(dirname(__FILE__)."/eventticket.pdf");
            /*} else {
                return $dompdf->output();
            }*/
            $pdf = $dompdf->output();
            $file_location = dirname(__FILE__) . "/tickets/eventticket_" . $order['order_number'] . ".pdf";
            file_put_contents($file_location, $pdf);
            $downloadStatus = 1;


//include("sendmail.php");
        } else {
            $downloadStatus = 0;
            echo 'You are not authorised to download the Ticket';
        }
    }
}
else
{
    $downloadStatus = 0;
	echo 'You are not authorised to download the Ticket';

}
if($downloadStatus == 1) {
?>

    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family: sans-serif;">
        <tr>
            <td height="45" background="images/fasel-middle.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="10">&nbsp;</td>
                        <td width="36" height="45">&nbsp;</td>
                        <td width="15">&nbsp;</td>
                        <td class="eventHeader" style="color:#eee;">Event Ticket Ordered </td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td><table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="3" background="images/g-dot.jpg"><img src="images/g-dot.jpg" width="7" height="7" /></td>
                    </tr>
                    <tr>
                        <td colspan="3"><img src="http://www.tktrush.com/images/logoin.png" alt="logo"/></td>
                    </tr>
                    <tr>
                        <td width="10" height="300">&nbsp;</td>

                        <td align="center" valign="top"><p>&nbsp;</p>
                            <?php
                            $name = '';
                            if(isset($_SESSION['PP_UserId'])){
                                $name = $_SESSION['PP_Username'];
                            }
                            ?>
                            <p class="ticket_message" style="text-transform: uppercase; font-weight: 600; line-height: 2;">Dear <?php echo $name ?>,<br />
                                THANK YOU FOR CHOOSING TICKET RUSH, YOUR PURCHASE IS CONFIRMED, YOU WILL RECEIVE AN EMAIL WITH YOUR TICKET DETAILS.
                                OR
                                YOU CAN DOWNLOAD YOUR TICKET HERE
                              <?php //echo $msg;?>
                            </p>
                            <div style="width: 100%; text-align: center; text-transform: uppercase;"><a style="padding: 10px; background-color: #363636;color: #FFFFFF!important; text-decoration: none;" href="http://www.tktrush.com/tickets/eventticket_<?php echo $order['order_number']; ?>.pdf">DOWNLOAD YOUR TICKET</a></div>
                        </td>
                        <td width="10">&nbsp;</td>

                    </tr>

                    <tr>
                        <td colspan="3" background="images/g-dot.jpg"><img src="images/g-dot.jpg" width="7" height="7" /></td>
                    </tr>
                </table></td>
        </tr>
    </table>
<?php } ?>