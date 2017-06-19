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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO promoters (name, `desc`, phone, login, password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE promoters SET name=%s, `desc`=%s, phone=%s, login=%s, password=%s, blockuser=%s WHERE spid=%s",
                       GetSQLValueString($_POST['name2'], "text"),
                       GetSQLValueString($_POST['desc2'], "text"),
                       GetSQLValueString($_POST['phone2'], "text"),
                       GetSQLValueString($_POST['login2'], "text"),
                       GetSQLValueString($_POST['password2'], "text"),
                       GetSQLValueString(isset($_POST['blockuser']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['spid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

mysql_select_db($database_eventscon, $eventscon);
$query_promoterRs = "SELECT spid, name FROM promoters ORDER BY name ASC";
$promoterRs = mysql_query($query_promoterRs, $eventscon) or die(mysql_error());
$row_promoterRs = mysql_fetch_assoc($promoterRs);
$totalRows_promoterRs = mysql_num_rows($promoterRs);
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
        <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>VIEW REPORTS </span></td>
      </tr>
      <tr>
        <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
      </tr>
    </table>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr>
        <td valign="middle" bgcolor="#CCCCCC"><form id="form1" name="form1" method="post" action="">
          <div align="center">
            <select name="promoterlist" id="promoterlist" onchange="submit()" style="width:300px">
                <option value="">Select Promoter</option>
              <?php
do {  
?>
              <option value="<?php echo $row_promoterRs['spid']?>"<?php if (!(strcmp($_POST["promoterlist"], $row_promoterRs['spid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_promoterRs['name']?></option>
              <?php
} while ($row_promoterRs = mysql_fetch_assoc($promoterRs));
  $rows = mysql_num_rows($promoterRs);
  if($rows > 0) {
      mysql_data_seek($promoterRs, 0);
	  $row_promoterRs = mysql_fetch_assoc($promoterRs);
  }
?>
            </select>
            </div>
        </form></td>
      </tr>
      
      <tr>
        <td>
<?php
$colname_salesRs = "-1";
if ((isset($_POST["promoterlist"]))&&($_POST["promoterlist"]!="")) {
  $colname_salesRs = (get_magic_quotes_gpc()) ? $_POST["promoterlist"] : addslashes($_POST["promoterlist"]);
$query_events = sprintf("SELECT tid, title FROM events WHERE promoter = %s ORDER BY title ASC", $colname_salesRs);
} else {
$query_events = sprintf("SELECT tid, title FROM events ORDER BY promoter, title ASC", $colname_salesRs);
}

//echo $query_events."<br>";
$events = mysql_query($query_events, $eventscon) or die(mysql_error());
$row_events = mysql_fetch_assoc($events);
$totalRows_events = mysql_num_rows($events);
?><br>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <?php $a = 0; ?>
  <?php do { ?>
  <?php $tsold=0; $totsales=0; ?>
  <?php if($a==1) { $trbgcolor=" bgcolor='#ffffff'"; $a--;} else { $trbgcolor=""; $a++;}  ?>
    <tr<?php echo $trbgcolor; ?>>
      <td width="20%" valign="top" bgcolor="#CCCCCC" class="eventVenue"><span class="footer style1">-</span><?php echo $row_events['title']; ?></td>
      <td width="80%">
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid;border-width: 1px 5px 10px 20px solid;border-color:#CCCCCC">
<?php 
$query_priceRs = "SELECT price, tickets FROM event_prices WHERE tid = ".$row_events['tid']." order by price desc";
//echo $query_priceRs;
$priceRs = mysql_query($query_priceRs, $eventscon) or die(mysql_error());
$row_priceRs = mysql_fetch_assoc($priceRs);
$totalRows_priceRs = mysql_num_rows($priceRs);
?>
      <tr>
        <td bgcolor="#CCCCCC"><div align="center"><strong>Ticket Prices </strong></div></td>
        <td bgcolor="#CCCCCC"><div align="center"><strong>Total Tickets</strong></div></td>
        <td bgcolor="#CCCCCC"><div align="center"><strong>Tickets sold </strong></div></td>
        <td bgcolor="#CCCCCC"><div align="center"><strong>Total Amount </strong></div></td>
      </tr>
  <?php do { ?>
      <tr>
      <td width="25%" bgcolor="#E9E9E9"><div align="right"><?php echo $row_priceRs['price']; ?></div></td>
      <td width="25%" bgcolor="#E9E9E9"><div align="right"><?php echo $row_priceRs['tickets']; ?></div></td>
<?php 
$query_salesRs = sprintf("SELECT count(tickets) ticketsold FROM ticket_orders WHERE tid=%s and ticket_price = %s ", $row_events['tid'],$row_priceRs['price']);
//echo $query_salesRs;
$salesRs = mysql_query($query_salesRs, $eventscon) or die(mysql_error());
$row_salesRs = mysql_fetch_assoc($salesRs);
$totalRows_salesRs = mysql_num_rows($salesRs);
?>
    <td width="25%" bgcolor="#E9E9E9"><div align="right"><?php echo $row_salesRs['ticketsold']; $tsold += $row_salesRs['ticketsold']; ?></div></td>
    <td width="25%" bgcolor="#E9E9E9"><div align="right"><?php echo $row_salesRs['ticketsold']*$row_priceRs['price']; $totsales +=$row_salesRs['ticketsold']*$row_priceRs['price']; ?></div></td>
    </tr>
    <?php } while ($row_priceRs = mysql_fetch_assoc($priceRs)); ?>
</table></td>
    </tr>
    <tr<?php echo $trbgcolor ?>>
      <td width="20%" align="right" bgcolor="#CCCCCC"><div align="center"><strong>Total</strong></div></td>
      <td width="80%"><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td width="25%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
          <td width="25%" bgcolor="#CCCCCC"><div align="right"><?php echo $tsold; ?></div></td>
          <td width="25%" bgcolor="#CCCCCC"><div align="right"><?php echo $totsales; ?></div></td>
        </tr>
      </table></td>
    </tr>
    <tr<?php echo $trbgcolor; ?>>
      <td colspan="2" align="right"><hr /></td>
    </tr>
    <?php } while ($row_events = mysql_fetch_assoc($events)); ?>
</table>
  <?php
mysql_free_result($salesRs);

mysql_free_result($priceRs);

mysql_free_result($events);
?>		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($promoterRs);
?>
