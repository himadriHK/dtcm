<?php
require("connection3.php");


if(isset($_REQUEST['cid']))
{
	$cid=$_REQUEST['cid'];
}
//echo $eid;
$sql="DELETE FROM `event_customer` WHERE eventCustomerId=".$cid;

 mysql_query($sql);
 
 @session_start();
 $_SESSION['loadTime']=1;
?>
<script>window.location.replace("eventCustomer.php");</script>