<?php 

require_once('Connections/eventscon.php'); ?>



<?php include("functions.php"); 



require_once('model_function.php');



//if($_GET['vpc_Message']=="Approved"){

$msg = "You have successfully ordered your ticket.";



//} else { $msg ="Your ticket could not be ordered. Please try again or call customer support.";}



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title><?php //echo $row_eventRs['title']; ?></title>



<link href="events.css" rel="stylesheet" type="text/css" />



</head>



<body>



<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">



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



        <td width="10" height="300">&nbsp;</td>



        <td align="center" valign="top"><p>&nbsp;</p>
            <?php
            $name = '';
            if(isset($_SESSION['Customer']['lname'])){
                $name = $_SESSION['Customer']['lname']." ".$_SESSION['Customer']['fname'];
            }
            if(isset($_SESSION['PP_UserId'])){
                $name = $_SESSION['PP_Username'];
            }
            ?>

          <p>Dear <?php echo $name ?>,<br />

            
<?php 		$order_query= sprintf("select * from ticket_orders WHERE oid = %s",$_SESSION['orderid']);
	$order_result = mysql_query($order_query, $eventscon) or die(mysql_error());
	
	$order=mysql_fetch_assoc($order_result);
        if(empty($order['basket_id'])){
            echo 'Something went wrong, please report to admin.';
        }else {
            echo $msg;
        } ?>

		</p></td>



        <td width="10">&nbsp;</td>



      </tr>



      <tr>



        <td colspan="3" background="images/g-dot.jpg"><img src="images/g-dot.jpg" width="7" height="7" /></td>



        </tr>



    </table></td>



  </tr>



</table>

<script type="text/javascript">



var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");



document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));



</script>



<script type="text/javascript">



try {



var pageTracker = _gat._getTracker("UA-11947961-2");



pageTracker._trackPageview();



} catch(err) {}</script>

</body>



</html>