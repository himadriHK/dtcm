<?php require_once('../Connections/eventscon.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysql_select_db($database_eventscon, $eventscon);
$query_partnerRs = "SELECT spid, name FROM partners ORDER BY name ASC";
$partnerRs = mysql_query($query_partnerRs, $eventscon) or die(mysql_error());
$row_partnerRs = mysql_fetch_assoc($partnerRs);

$totalRows_partnerRs = mysql_num_rows($partnerRs);
if(empty($_POST["partnerlist"])){
    $_POST["partnerlist"] = $row_partnerRs['spid'];
    //echo '<pre>'; print_r($row_partnerRs); exit;
}
?>
<?php require("access.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="events.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #CCCCCC}
.headeradmin {color: #C31600}
-->
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td width="200" valign="top"><?php require("contents.php"); ?></td>
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
    <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>VIEW PARTNER REPORTS </span></td>
      </tr>
      <tr>
        <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
      </tr>
    </table>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr>
        <td valign="middle" bgcolor="#CCCCCC"><form id="form1" name="form1" method="post" action="">
          <div align="center">
            <select name="partnerlist" id="partnerlist" onchange="submit()" style="width:300px">
                <option value="">Select Partner</option>
              <?php
do {  
?>
              <option value="<?php echo $row_partnerRs['spid']?>"<?php if (!(strcmp($_POST["partnerlist"], $row_partnerRs['spid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_partnerRs['name']?></option>
              <?php
} while ($row_partnerRs = mysql_fetch_assoc($partnerRs));
  $rows = mysql_num_rows($partnerRs);
  if($rows > 0) {
      mysql_data_seek($partnerRs, 0);
	  $row_partnerRs = mysql_fetch_assoc($partnerRs);
  }
?>
            </select>
            </div>
        </form></td>
      </tr>
      
      <tr>
        <td>
<?php
$ticketIds = 0;
$colname_salesRs = "-1";
if ((isset($_POST["partnerlist"]))&&($_POST["partnerlist"]!="")) {
//functionality to get events by partner id
    $sql = "SELECT tid FROM ticket_orders WHERE partner_id = ".$_POST["partnerlist"];
    $result = mysql_query($sql, $eventscon) or die(mysql_error());
    $eventTicketIds = array();
    if (mysql_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysql_fetch_assoc($result)) {
            $eventTicketIds[$row["tid"]] = $row["tid"];
        }
    }
    if(count($eventTicketIds)>0){
        $ticketIds = implode(',',$eventTicketIds);
    } else {
        $ticketIds = 0;
    }

//End of functionality
//functionality to fetch partners details
    $partnerDetails = array();
    $partnerSql = "SELECT name FROM partners WHERE spid = ".$_POST["partnerlist"];
    $partnerResult = mysql_query($partnerSql, $eventscon) or die(mysql_error());
    if (mysql_num_rows($partnerResult) > 0) {
        // output data of each row
        while ($row = mysql_fetch_assoc($partnerResult)) {
            $partnerDetails['name'] = $row["name"];
        }
    }

//end of Partners details
  $colname_salesRs = (get_magic_quotes_gpc()) ? $_POST["partnerlist"] : addslashes($_POST["partnerlist"]);
$query_events = sprintf("SELECT tid, title,dtcm,commission, partner_commission FROM events WHERE tid IN (".$ticketIds.") ORDER BY title ASC");
} else {
$query_events = sprintf("SELECT tid, title, dtcm, commission, partner_commission FROM events tid IN (".$ticketIds.") ORDER BY partner, title ASC", $colname_salesRs);
}

//echo $query_events."<br>";
$events = mysql_query($query_events, $eventscon) or die(mysql_error());
$row_events = mysql_fetch_assoc($events);
$totalRows_events = mysql_num_rows($events);

?><br>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
    <?php if($totalRows_events <=0 ) {?>
        <tr>
            <td></td>
            <td>No Tickets found for selected Partner</td>
        </tr>
    <?php } else {?>
    <?php $a = 0; ?>
    <?php do { ?>
        <?php $tsold = 0;
        $totsales = 0; ?>
        <?php if ($a == 1) {
            $trbgcolor = " bgcolor='#ffffff'";
            $a--;
        } else {
            $trbgcolor = "";
            $a++;
        }
            $totalPartnerCommission = 0;?>
        <?php $commissionDtcmAdd = $row_events['commission'] + $row_events['dtcm']; ?>
        <tr<?php echo $trbgcolor; ?>>
            <td width="20%" valign="top" bgcolor="#CCCCCC" class="eventVenue">
                <table style="border: 1px solid;border-width: 1px 5px 10px 20px solid;border-color:#CCCCCC">
                    <!--<tr><td>Event Title</td></tr>-->
                    <tr><td><span class="footer style1">-</span><?php echo $row_events['title']; ?></td></tr>
                </table>
            </td>
            <td width="80%">
                <table width="100%" border="0" cellspacing="1" cellpadding="0"
                       style="border: 1px solid;border-width: 1px 5px 10px 20px solid;border-color:#CCCCCC">
                    <?php


                    $queryOrder = "SELECT * FROM ticket_orders WHERE tid = " . $row_events['tid'] . " AND  partner_id = " . $_POST["partnerlist"];
                    //echo $query_priceRs;
                    $orders = mysql_query($queryOrder, $eventscon) or die(mysql_error());
                    $ordersList = mysql_fetch_assoc($orders);
                    $totalOrders = mysql_num_rows($orders);

                    ?>
                    <tr>
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Order ID</strong></div>
                        </td>
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Sold By</strong></div>
                        </td>
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Buyer Info</strong></div>
                        </td>
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Ticket Prices </strong></div>
                        </td>
                        <!--<td bgcolor="#CCCCCC">
                            <div align="center"><strong>Total Tickets</strong></div>
                        </td>-->
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Tickets sold </strong></div>
                        </td>


                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Total Amount </strong></div>
                        </td>
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>Partner Commission</strong></div>
                        </td>
                        <td bgcolor="#CCCCCC">
                            <div align="center"><strong>TktRush Amount</strong></div>
                        </td>
                    </tr>
                    <?php
                    do {
                        $buyerInfo = null;
                        $selectedSeats = unserialize($ordersList['selected_seats']);
                        $ticketsQty = 0;
                        $cTicketsQty = 0;
                        foreach($selectedSeats['tickets'] as $key=>$qty){
                            $purchasedTickets[$key] = $key;
                            $ticketsQty +=$qty;
                        }
                        foreach($selectedSeats['ctickets'] as $key=>$cQty){
                            //$purchasedTickets[$key] = $key;
                            $cTicketsQty +=$cQty;
                        }

                        $query_priceRs = "SELECT price, cprice,tickets FROM event_prices WHERE tid = " . $row_events['tid'] . " AND pid IN(".implode(',',$purchasedTickets).") order by price desc";
                        //echo $query_priceRs;
                        $priceRs = mysql_query($query_priceRs, $eventscon) or die(mysql_error());
                        $row_priceRs = mysql_fetch_assoc($priceRs);
                        $totalRows_priceRs = mysql_num_rows($priceRs);

                        do {
                            //echo '<pre>'; print_r(unserialize($ordersList['customer_info']));
                            if(isset($ordersList['customer_info'])){
                                $buyerInfo = unserialize($ordersList['customer_info']);
                            } else {
                                $buyerInfo = null;
                           }
                            ?>
                            <tr>
                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php echo $ordersList['order_number']; ?></div>
                                </td>
                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php echo $partnerDetails['name']; ?></div>
                                </td>
                                <td width="23%" bgcolor="#E9E9E9">
                                    <div align="left">
                                        <?php
                                       // if($buyerInfo['email']) {
                                            echo $buyerInfo['fname'] . ' ' . $buyerInfo['fname'] . ',<br/>';
                                            echo $buyerInfo['email'] . ',<br/>';
                                            echo $buyerInfo['city'] . ',<br/>';
                                            echo $buyerInfo['country'] . '.';
                                       // } else {
                                            echo '-';
                                        //}
                                        ?></div>
                                </td>

                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php echo 'Adult:'.$row_priceRs['price'].'<br/>Child:'.$row_priceRs['cprice']; ?></div>
                                </td>
                                <!--<td width="25%" bgcolor="#E9E9E9">
                                <div align="right"><?php /*echo $row_priceRs['tickets']; */ ?></div>
                            </td>-->
                                <?php
                                /*$query_salesRs = sprintf("SELECT count(tickets) ticketsold FROM ticket_orders WHERE tid=%s and ticket_price = %s ", $row_events['tid'], $row_priceRs['price']);

                                $salesRs = mysql_query($query_salesRs, $eventscon) or die(mysql_error());
                                $row_salesRs = mysql_fetch_assoc($salesRs);
                                $totalRows_salesRs = mysql_num_rows($salesRs);*/
                                $row_salesRs['ticketsold'] = $ticketsQty + $cTicketsQty;
                                ?>
                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php //echo $row_salesRs['ticketsold'];
                                        echo 'Adult:'.$ticketsQty.'<br/>Child:'.$cTicketsQty;
                                        $tsold += $ticketsQty+$cTicketsQty; ?></div>
                                </td>


                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php
                                        if (!empty($ticketsQty)) {
                                            //echo ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice']) - $commissionDtcmAdd + $ordersList['charges'];
                                            echo ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice']) + $ordersList['charges'];
                                            $totsales += ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice'])  + $ordersList['charges'];
                                            $totsalesAmount = ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice'])  + $ordersList['charges'];
                                        } else {
                                            echo ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice']) + $ordersList['charges'];
                                            $totsales += ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice']) + $ordersList['charges'];
                                            $totsalesAmount = ($ticketsQty * $row_priceRs['price']) + ($cTicketsQty * $row_priceRs['cprice']) + $ordersList['charges'];
                                        }

                                       /* if (!empty($row_salesRs['ticketsold'])) {
                                            echo ($row_salesRs['ticketsold'] * $row_priceRs['price']) - $commissionDtcmAdd;
                                            $totsales += ($row_salesRs['ticketsold'] * $row_priceRs['price']) - $commissionDtcmAdd;
                                            $totsalesAmount = ($row_salesRs['ticketsold'] * $row_priceRs['price']) - $commissionDtcmAdd;
                                        } else {
                                            echo $row_salesRs['ticketsold'] * $row_priceRs['price'];
                                            $totsales += $row_salesRs['ticketsold'] * $row_priceRs['price'];
                                            $totsalesAmount = $row_salesRs['ticketsold'] * $row_priceRs['price'];
                                        }*/
                                        ?></div>
                                </td>
                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php
                                        $partnerCommission = 0;
                                        $partnerCommission = ($row_events['partner_commission'] / 100) * $totsalesAmount;
                                        $totalPartnerCommission += ($row_events['partner_commission'] / 100) * $totsalesAmount;

                                        echo $partnerCommission . ' <br/>(At ' . $row_events['partner_commission'] . '%)'; ?></div>
                                </td>
                                <td width="11%" bgcolor="#E9E9E9">
                                    <div align="right"><?php echo $totsalesAmount - $partnerCommission; ?></div>
                                </td>

                            </tr>
                        <?php
                        } while ($row_priceRs = mysql_fetch_assoc($priceRs));

                    }while ($ordersList = mysql_fetch_assoc($orders));?>
                </table>
            </td>
        </tr>
        <tr<?php echo $trbgcolor ?>>
            <td width="20%" align="right" bgcolor="#CCCCCC">
                <div align="center"><strong>Total</strong></div>
            </td>
            <td width="80%">
                <table width="100%" border="0" cellspacing="1" cellpadding="0"
                       style="border: 1px solid; border-color:#CCCCCC">
                    <tr>
                        <td width="11%">&nbsp;</td>
                        <td width="11%">&nbsp;</td>
                        <td width="23%">&nbsp;</td>
                        <td width="11%">&nbsp;</td>
                        <td width="11%" bgcolor="#CCCCCC">
                            <div align="right"><?php echo $tsold; ?></div>
                        </td>
                        <td width="11%" bgcolor="#CCCCCC">
                            <div align="right"><?php echo $totsales; ?></div>
                        </td>
                        <td width="11%" bgcolor="#CCCCCC">
                            <div align="right"><?php echo $totalPartnerCommission; ?></div>
                        </td>
                        <td width="11%" bgcolor="#CCCCCC">
                            <div align="right"><?php echo $totsales- $totalPartnerCommission; ?></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr<?php echo $trbgcolor; ?>>
            <td colspan="2" align="right">
                <hr/>
            </td>
        </tr>
    <?php } while ($row_events = mysql_fetch_assoc($events)); }?>
</table>
        <?php
        if($totalRows_events >0 ) {
            //mysql_free_result($salesRs);

            mysql_free_result($priceRs);

            mysql_free_result($events);
        }

?>		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($partnerRs);
?>
