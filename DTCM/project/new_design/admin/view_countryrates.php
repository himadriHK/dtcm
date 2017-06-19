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

if ((isset($_GET["act"])) && ($_GET["act"] == "del")) {
  $updateSQL = sprintf("delete from shippingrates WHERE countryid=%s",
                       GetSQLValueString($_GET['countryid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

mysql_select_db($database_eventscon, $eventscon);
$query_shiplist = "SELECT * FROM shippingrates ORDER BY name ASC";
$shiplist = mysql_query($query_shiplist, $eventscon) or die(mysql_error());
$row_shiplist = mysql_fetch_assoc($shiplist);
$totalRows_shiplist = mysql_num_rows($shiplist);


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
.headeradmin {color: #C31600}
-->
</style>
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
              <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">VIEW COUNTRIES AND RATES </span></td>
            </tr>
            <tr>
              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
            
              <?php do { ?>
                <tr>
                  <td bgcolor="#E9E9E9"><a href="manage_guide_categories.php?countryid=<?php echo $row_shiplist['countryid']; ?>" class="eventText"><?php echo $row_shiplist['name']; ?></a></td>
                  <td bgcolor="#E9E9E9"><?php echo $row_shiplist['rate']; ?></td>
                  <td width="60" bgcolor="#E9E9E9"><div align="center"><a href="manage_countryrates.php?countryid=<?php echo $row_shiplist['countryid']; ?>" class="headeradmin">Edit</a></div></td>
                  <td width="60" bgcolor="#E9E9E9"><div align="center"><a href="view_countryrates.php?countryid=<?php echo $row_shiplist['countryid']; ?>&amp;act=del" onclick="return confirm('Are you sure you want to delete?')" class="headeradmin">Delete</a></div></td>
                </tr>
                <?php } while ($row_shiplist = mysql_fetch_assoc($shiplist)); ?>
        </table>          </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($shiplist);
?>
