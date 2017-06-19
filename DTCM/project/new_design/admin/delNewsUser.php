<?php
require("connection3.php");


if(isset($_REQUEST['eid']))
{
	$eid=$_REQUEST['eid'];
}
//echo $eid;
$sql="DELETE FROM `ticketma_ticketdbff_emails_table` WHERE e_id=".$eid;

 mysql_query($sql);
 
 @session_start();
 $_SESSION['loadTime']=1;
?>
<script>window.location.replace("newsletter.php");</script>