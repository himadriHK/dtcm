<?php

require_once('Connections/eventscon.php'); ?>

<?php include("functions.php"); ?>

<?php
if(isset($_POST['hidTid']))
{
	$eventId=$_POST['hidTid'];
}
if(isset($_POST['fname']))
{
	$fname=$_POST['fname'];
}
if(isset($_POST['lname']))
{
	$lname=$_POST['lname'];
}
if(isset($_POST['mobile']))
{
	$mobile=$_POST['mobile'];
}
if(isset($_POST['email']))
{
	$email=$_POST['email'];
}
if(isset($_POST['noGuest']))
{
	$noGuest=$_POST['noGuest'];
}

$insertSQL = "INSERT INTO event_customer (fname, lname, mobile, email,tid,noGuest,dateAdded) VALUES ('".$fname."', '".$lname."', '".$mobile."', '".$email."', '".$eventId."','".$noGuest."','".date('Y-m-d')."')";


  mysql_select_db($database_eventscon, $eventscon);

  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());


?>
<script>window.location.replace("regThanks.php");</script>