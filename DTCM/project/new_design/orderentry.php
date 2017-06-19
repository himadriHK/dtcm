<?php 
require_once('Connections/eventscon.php'); ?>
<?php include("functions.php"); ?>
<?php include("config.php"); ?>
<?php

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {



  $insertSQL = sprintf("INSERT INTO customers (fname, lname, mobile, email, city, country, address) VALUES (%s, %s, %s, %s, %s, %s, %s)",

                       GetSQLValueString($_POST['fname'], "text"),

                       GetSQLValueString($_POST['lname'], "text"),

                       GetSQLValueString($_POST['mobile'], "text"),

                       GetSQLValueString($_POST['email'], "text"),

                       GetSQLValueString($_POST['city'], "text"),

                       GetSQLValueString($_POST['country'], "text"),
					   
					   GetSQLValueString($_POST['address'], "text"));



  mysql_select_db($database_eventscon, $eventscon);

  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());

  if($Result1){

  	$_SESSION['custid'] = mysql_insert_id();

  }



$sessiondate = $_POST["sessiondate"];

if($sessiondate=="Ongoing"){ $sessiondate = date("Y-m-d"); }



  $insertSQL = sprintf("INSERT INTO ticket_orders (cust_id, tid, pid, order_date, event_date, payment_type, tickets, ctickets) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",

                       GetSQLValueString($_SESSION['custid'], "int"),

                       GetSQLValueString($_POST['eid'], "int"),

                       GetSQLValueString($_POST['prices'], "int"),

                       GetSQLValueString(date("Y-m-d"), "date"),

                       GetSQLValueString($sessiondate, "date"),

                       GetSQLValueString($_POST['paytype'], "text"),

                       GetSQLValueString($_POST['tickets'], "int"),

                       GetSQLValueString($_POST['ctickets'], "int"));



  mysql_select_db($database_eventscon, $eventscon);

  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());

  if($Result1){

  	$_SESSION['orderid'] = mysql_insert_id();

  }

  }

?>

