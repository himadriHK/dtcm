<?php require_once('Connections/eventscon.php'); ?>
<?php
$colname_salesRs = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_salesRs = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}

mysql_select_db($database_eventscon, $eventscon);
$query_events = sprintf("SELECT tid, title FROM events WHERE promoter = %s ORDER BY title ASC", $_SESSION['MM_UserId']);
//echo $query_events."<br>";
$events = mysql_query($query_events, $eventscon) or die(mysql_error());
$row_events = mysql_fetch_assoc($events);
$totalRows_events = mysql_num_rows($events);
?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td height="30" bgcolor="#CCCCCC"><span class="eventHeader">Welcome <? echo $_SESSION['MM_Username']; ?>,</span></td>
  </tr>

</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <?php $a = 0; ?>
  <?php do { ?>
  <?php $tsold=0; $totsales=0; ?>
  <?php if($a==1) { $trbgcolor=" bgcolor='#101010'"; $a--;} else { $trbgcolor=""; $a++;}  ?>
    <tr<?php echo $trbgcolor; ?>>
      <td width="150" valign="top" bgcolor="#CCCCCC" class="eventHeader"><?php echo $row_events['title']; ?></td>
      <td>
        <table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid;border-width: 1px 5px 10px 20px solid;border-color:#CCCCCC">
<?php 
$query_priceRs = "SELECT price, tickets FROM event_prices WHERE tid = '".$row_events['tid']."' order by price desc";
//echo $query_priceRs;
$priceRs = mysql_query($query_priceRs, $eventscon) or die(mysql_error());
$row_priceRs = mysql_fetch_assoc($priceRs);

$totalRows_priceRs = mysql_num_rows($priceRs);
?>
      <tr>
        <td height="20" bgcolor="#E8E8E8" class="style1">Ticket Prices </td>
        <td height="20" bgcolor="#E8E8E8"><span class="style1">Total Tickets</span></td>
        <td height="20" bgcolor="#E8E8E8" class="style1">Tickets sold </td>
        <td height="20" bgcolor="#E8E8E8" class="style1">Total Amount </td>
      </tr>
  <?php while ($row_priceRs = mysql_fetch_assoc($priceRs)) { ?>
      <tr>
      <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_priceRs['price']; ?></td>
      <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_priceRs['tickets']; ?></td>
<?php 
$query_salesRs = sprintf("SELECT count(tickets) ticketsold FROM ticket_orders WHERE tid=%s and ticket_price=%s ", $row_events['tid'],$row_priceRs['price']);
//echo $query_salesRs;
$salesRs = mysql_query($query_salesRs, $eventscon) or die(mysql_error());
$row_salesRs = mysql_fetch_assoc($salesRs);
$totalRows_salesRs = mysql_num_rows($salesRs);
?>
    <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_salesRs['ticketsold']; $tsold += $row_salesRs['ticketsold']; ?></td>
    <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_salesRs['ticketsold']*$row_priceRs['price']; $totsales +=$row_salesRs['ticketsold']*$row_priceRs['price']; ?></td>
    </tr>
    <?php } ?>
</table></td>
    </tr>
    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Total</div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          <td width="25%" bgcolor="#CCCCCC" class="style1"><?php echo $tsold; ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1"><?php echo $totsales; ?></td>
        </tr>
      </table></td>
    </tr>
    
    <?php } while ($row_events = mysql_fetch_assoc($events)); ?>
</table>
  <?php

//mysql_free_result($salesRs);

//mysql_free_result($priceRs);

//mysql_free_result($events);
?>