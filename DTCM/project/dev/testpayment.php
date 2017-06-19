<?php
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
$domain='https://www.tktrush.com/';
$post_data = array(
  'ivp_store' => 12778,
  'ivp_amount'     => 1,
  'ivp_currency'  => 'AED',
  'ivp_test' => 'Test',
  'ivp_timestamp' => time(),
  'ivp_cart' => mt_rand(100000, 999999),
  'ivp_desc' => 'Test',
  'ivp_extra' => 'return',
  'return_cb_auth'=>$domain.'auth_success.php',
  'return_cb_decl'=>$domain.'auth_cancel.php',
  'return_cb_can'=>$domain.'auth_cancel.php',
  'return_auth'=>$domain.'payment_success.php',
  'return_decl'=>$domain.'payment_cancel.php',
  'return_can'=>$domain.'payment_cancel.php',
  );

  $post_data['ivp_signature']=SignData($post_data,$secret_key,
'ivp_store,ivp_amount,ivp_currency,ivp_test,ivp_timestamp,ivp_cart,ivp_desc,ivp_extra');
$post_data['return_signature']=SignData($post_data,$secret_key,
'return_cb_auth,return_cb_decl,return_cb_can,return_auth,return_decl,return_can,ivp_signature');
  
        echo "<html>\n";
        echo "<head><title>Processing Payment...</title>";
        echo "<meta http-equiv=\"content-type\" content=\"text/html charset=UTF-8\" />";
        echo "</head>\n";
        echo "<body  ><br/><br/>\n";
        echo "<p style=\"text-align:center;width:100%;\"><img src=\"/themes/css/default/innovate_logo.gif\" /></p><p style=\"text-align:center;width:100%;\">";
        echo " </p>\n";
        echo "<p style=\"width:100%;text-align:center;\"><br/><img src=\"/themes/css/default/loading42.gif\" alt=\"Please wait..\"</p>";
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
?>