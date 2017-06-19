<?php require_once('../Connections/eventscon.php'); ?>

<?php

mysql_select_db($database_eventscon, $eventscon);

if($_POST){

	$oid=$_POST['oid'];

	$value=$_POST['value'];

	$sql="UPDATE ticket_orders set payment_status='{$value}' where oid={$oid}";

	mysql_query($sql, $eventscon) or die(mysql_error());
	
	
	if($value=='paid')
	{
		include_once('../sendvoucherlink.php');
	}

	exit;

}



include_once("../Pagination/Pagination.class.php");	

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

$offset=0;

$limit=20;



$order_sql = "SELECT tkt.*,cust.fname,cust.lname,cust.email,evn.title FROM ticket_orders as tkt left JOIN customers as cust on tkt.cust_id=cust.cust_id  left JOIN events as evn on tkt.tid=evn.tid ORDER BY tkt.oid desc";

$order_query = mysql_query($order_sql, $eventscon) or die(mysql_error());

$totalRows_order = mysql_num_rows($order_query);

$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

if($page>1){

	$offset=round(20*($page));

}

    $pagination = (new Pagination());

    $pagination->setCurrent($page);

    $pagination->setTotal($totalRows_order);

if($totalRows_order>0)

{

	$order_sql = "SELECT tkt.*,cust.fname,cust.lname,cust.email,evn.title FROM ticket_orders as tkt left JOIN customers as cust on tkt.cust_id=cust.cust_id  left JOIN events as evn on tkt.tid=evn.tid ORDER BY tkt.oid desc LIMIT {$offset},{$limit}";

	$order_query = mysql_query($order_sql, $eventscon) or die(mysql_error());

}

    // grab rendered/parsed pagination markup


 require("access.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Ticket Master</title>

<link href="events.css" rel="stylesheet" type="text/css" />



<style type="text/css">

<!--

.headeradmin {color: #C31600}

.paginator ul{

	list-style:none;

	font-size:14px;

	font-weight:bold;

	display:inline-flex;

	display:-moz-box;

}

.paginator ul li{

	padding:0px 7px;

}

.paginator .active{

	background:#EEE;

}

-->

</style>

<script src="../js/jquery-1.8.2.js" type="text/javascript"></script>

<script>

function change_status(id,value)

{

	var con=confirm("Do you want to change the payment status of this ticket?");

	if(con)

	{

		$.ajax({

			type:"POST",

			url:"ticket_orders.php",

			data:"oid="+id+"&value="+value,

			success:function(msg){
			window.location.reload();

			}

		});

	}

}

</script>

</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><?php require("head.php"); ?></td>

  </tr>

</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

  

  <tr>

    <td width="200" valign="top"><?php require("contents.php"); ?></td>

    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>

    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">

        <tr>

          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">

            <tr>

              <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">VIEW TICKET ORDERS</span></td>

            </tr>

            <tr>

              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>

            </tr>

          </table>

          <?php if($totalRows_order>0){$i=1;?>

            <table width="100%" border="0" cellspacing="1" cellpadding="3">

            <tr> <th>#ID</th> <th>Order Number</th> <!--<th>Transaction Code</th>--> <th>Customer Name(Email)</th> <th>Event title</th> <th>Order date</th><th>Ticket qty</th> <th>Ticket Price</th> <th>Payment Type</th><th>Payment status</th></tr>

              <?php while ($row_order = mysql_fetch_assoc($order_query)) { 

			  ?>

                <tr>

                <td width="10" bgcolor="#E9E9E9"><?php echo $i++ ?></td>

                <td width="10" bgcolor="#E9E9E9"><?php echo $row_order['order_number']; ?></td>

                  <!--<td width="10" bgcolor="#E9E9E9"><?php //echo $row_order['transaction_code']; ?></td>-->

                  <td width="20" bgcolor="#E9E9E9"><?php echo $row_order['fname'];?>&nbsp;<?php echo $row_order['fname'];?>(<?php echo $row_order['email'];?>)</td>

                  <td width="60" bgcolor="#E9E9E9"><?php echo $row_order['title'];?></td>

                  <td width="60" bgcolor="#E9E9E9"><?php echo $row_order['order_date'];?></td>

                  <td width="60" bgcolor="#E9E9E9"><?php echo $row_order['tickets'];?></td>

                  <td width="60" bgcolor="#E9E9E9"><?php echo $row_order['ticket_price'];?></td>

                  <td width="60" bgcolor="#E9E9E9"><?php echo $row_order['payment_type'];?></td>

                  <td width="60" bgcolor="#E9E9E9">

                  <?php if($row_order['payment_status']!=='paid'){?>

                  <select name="approved" onchange="change_status(<?php echo $row_order['oid']; ?>,this.value);">

                  <option value="unpaid" <?php echo ($row_order['payment_status']=='unpaid')?"selected":'';?>>Unpaid</option>

                   <option value="paid" <?php echo ($row_order['payment_status']=='paid')?"selected":'';?>>Paid</option>

                   <option value="cancelled" <?php echo ($row_order['payment_status']=='cancelled')?"selected":'';?>>Cancelled</option>

                  </select>

                  <?php }else{?>

                  <span>Paid</span>

                  <?php }?>

                  </td>

                </tr>

                <?php

				 }  ?>

        </table>

        <?php if($totalRows_order>$limit){?>

        <tr><td style="text-align:right;" class="paginator"><?php echo $markup = $pagination->parse();?></td></tr> 

        <?php } } ?>

           </tr>

      </table></td>

  </tr>

</table>

</body>

</html>

<?php

mysql_free_result($order_query);

?>

