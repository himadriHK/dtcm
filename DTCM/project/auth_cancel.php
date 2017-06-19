<?php
$resdata=$_POST;

file_put_contents("cancel.json",json_encode($resdata));
require_once('Connections/eventscon.php'); 
 include("functions.php");

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
?>