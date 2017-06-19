<?php
require_once('Connections/eventscon.php');
$custid = 612;
$cus_quer = sprintf("SELECT * FROM customers WHERE cust_id = %s", $custid);
$cus_quer_res = mysql_query($cus_quer, $eventscon) or die(mysql_error());
var_dump($cus_quer_res);
//echo 'where is the error1\n';
$cus_quer_details = mysql_fetch_assoc($cus_quer_res);
var_dump($cus_quer_details);
$dtcm_c_data = $cus_quer_details['dtcm_id'];


?>