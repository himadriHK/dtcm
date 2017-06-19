<?php

include("orderentry.php");

if($_POST["paytype"]=="spot"){

mysql_select_db($database_eventscon, $eventscon);

$query_update = sprintf("UPDATE ticket_orders SET ccapproved = 'Yes' WHERE oid = %s", $_SESSION['orderid']);

$update = mysql_query($query_update, $eventscon) or die(mysql_error());
$orderid=$_SESSION['orderid'];
$custid=$_SESSION['custid'];
include("sendmail.php");



	header("Location:events_confirm.php");



	exit();

}

// functionality to update payment values for partner login
if($_POST["paytype"]=="pt_spot" ){

    $customer_data = array();
    if(isset($_POST['email'])){
        $customer_data['fname'] = $_POST['fname'];
        $customer_data['lname'] = $_POST['lname'];
        $customer_data['address'] = $_POST['address'];
        $customer_data['mobile'] = $_POST['address'];
        $customer_data['email'] = $_POST['email'];
        $customer_data['city'] = $_POST['city'];
        $customer_data['country'] = $_POST['country'];

    }

    mysql_select_db($database_eventscon, $eventscon);

    $query_update = sprintf("UPDATE ticket_orders SET partner_id = ".$_SESSION['PP_UserId'].",ccapproved = 'Yes', payment_status = 'paid',customer_info = '".serialize($customer_data)."' WHERE oid = %s", $_SESSION['orderid']);

    $update = mysql_query($query_update, $eventscon) or die(mysql_error());
    $orderid=$_SESSION['orderid'];
    $custid=$_SESSION['custid'];
    if(isset($_SESSION['PP_UserId'])){
        header("Location:download_tickets.php");
    } else {
        header("Location:events_confirm.php");
    }

    exit();

}
//End of partner functionality

##Hashing algorithm
function SignData($post_data,$secretKey,$fieldList) 
{
	$signatureParams = explode(',', $fieldList);
	$signatureString = $secretKey;
	foreach ($signatureParams as $param) {
		if (array_key_exists($param, $post_data)) {
			$signatureString .= ':' . trim($post_data[$param]);
		} else {
			$signatureString .= ':';
		}
	}
	return sha1($signatureString);
}
##End of hashing algorithm
$gatewayUrl = "https://secure.innovatepayments.com/gateway/index.html";
$secret_key='zVRZ$h77s';
$store_id='12778';
$test=1; //  0 for live
$post_data = array(
  'ivp_store' => $store_id,
  'ivp_amount'     => $total_price,
  'ivp_currency'  => 'AED',
  'ivp_test' => $test,
  'ivp_timestamp' => time(),
  'ivp_cart' => $_SESSION['orderid'].'-'.$_SESSION['custid'],
  'ivp_desc' => trim($row_eventRs['title']),
  'ivp_extra' => 'return',
  'return_cb_auth'=>$domain.'auth_success.php',
  'return_cb_decl'=>$domain.'auth_cancel.php',
  'return_cb_can'=>$domain.'auth_cancel.php',
  'return_auth'=>$domain.'events_confirm.php',
  'return_decl'=>$domain.'events_cancelled.php',
  'return_can'=>$domain.'events_cancelled.php',
  );

  $post_data['ivp_signature']=SignData($post_data,$secret_key,
'ivp_store,ivp_amount,ivp_currency,ivp_test,ivp_timestamp,ivp_cart,ivp_desc,ivp_extra');
$post_data['return_signature']=SignData($post_data,$secret_key,
'return_cb_auth,return_cb_decl,return_cb_can,return_auth,return_decl,return_can,ivp_signature');
  
        echo "<html>\n";
        echo "<head><title>Processing Payment...</title>";
        echo "<meta http-equiv=\"content-type\" content=\"text/html charset=UTF-8\" />";
        echo "</head>\n";
        echo "<body onLoad=\"document.forms['gateway_form'].submit();\" ><br/><br/>\n";
        echo "<p style=\"text-align:center;width:100%;\"><img src=\"/images/innovate_logo.gif\" /></p><p style=\"text-align:center;width:100%;\">";
        echo " </p>\n";
        echo "<p style=\"width:100%;text-align:center;\"><br/><img src=\"/images/loading42.gif\" alt=\"Please wait..\"</p>";
        echo "<form method=\"POST\" name=\"gateway_form\" ";
        echo "action=\"" . $gatewayUrl . "\">\n";

        foreach ($post_data as $k => $v) {
			echo "<input type=\"hidden\" name=\"" . $k . "\" value=\"" . htmlspecialchars($v) . "\">";
		}
        
        echo "<p style=\"text-align:center;\"><br/>";
        echo "If it is not automatically redirected";
        echo "...";
        echo "<br/><br/>\n";
        echo "<input type=\"submit\" value=\"Click Here\"></p>\n";

        echo "</form>\n";
        echo "</body></html>\n";
		exit;
/*
$_POST["vpc_Version"]="1";



$_POST["vpc_Command"]="pay";



$_POST["vpc_Locale"]="en";



$_POST["vpc_Merchant"]="TEST800454";



$_POST["vpc_AccessCode"]="7B5D8012";



$_POST["vpc_MerchTxnRef"]=$_SESSION['orderid'];



$_POST["vpc_ReturnURL"]="http://www.ticketmasters.me/new_design/events_confirm.php";

*/

////events_confirm"events_confirm.php";vpc_php_serverhost_dr.php