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
  $insertSQL = sprintf("INSERT INTO partners (name, `desc`, phone, login, password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE partners SET name=%s, `desc`=%s, phone=%s, login=%s, password=%s, blockuser=%s WHERE spid=%s",
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

if ((isset($_GET['proid'])) && ($_GET['proid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM partners WHERE spid=%s",
                       GetSQLValueString($_GET['proid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($deleteSQL, $eventscon) or die(mysql_error());
}

$colname_partnerRs = "-1";
if (isset($_GET['proid'])) {
  $colname_partnerRs = (get_magic_quotes_gpc()) ? $_GET['proid'] : addslashes($_GET['proid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_partnerRs = sprintf("SELECT * FROM partners WHERE spid = %s ORDER BY name ASC", $colname_partnerRs);
$partnerRs = mysql_query($query_partnerRs, $eventscon) or die(mysql_error());
$row_partnerRs = mysql_fetch_assoc($partnerRs);
$totalRows_partnerRs = mysql_num_rows($partnerRs);

mysql_select_db($database_eventscon, $eventscon);
$query_proupdateRs = "SELECT spid, name, `desc`, phone, fax, email, website FROM partners ORDER BY name ASC";
$proupdateRs = mysql_query($query_proupdateRs, $eventscon) or die(mysql_error());
$row_proupdateRs = mysql_fetch_assoc($proupdateRs);
$totalRows_proupdateRs = mysql_num_rows($proupdateRs);
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
    <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>VIEW PARTNERS</span></td>
      </tr>
      <tr>
        <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                  <tr>
                    <td height="25" bgcolor="#999999" class="eventVenue"><div align="center">Partners</div></td>
                    <td bgcolor="#999999" class="eventVenue"><div align="center">Address</div></td>
                    <td bgcolor="#999999" class="eventVenue"><div align="center">Phone</div></td>
                    <td bgcolor="#999999" class="eventVenue"><div align="center">Fax</div></td>
                    <td bgcolor="#999999" class="eventVenue"><div align="center">Email</div></td>
                    <td align="center" bgcolor="#999999" class="eventVenue"><div align="center"></div></td>
                    <td align="center" bgcolor="#999999" class="eventVenue"><div align="center"></div></td>
                  </tr>
              <? $a = 0; ?>
              <?php do { ?>
                <tr<?php if ($a==1) {echo ' bgcolor="#CCCCCC"'; $a=0;}else { $a=1;} ?>>
                  <td height="18"><?php echo $row_proupdateRs['name']; ?></td>
                  <td><?php echo $row_proupdateRs['desc']; ?></td>
                  <td><div align="center"><?php echo $row_proupdateRs['phone']; ?></div></td>
                  <td><div align="center"><?php echo $row_proupdateRs['fax']; ?></div></td>
                  <td><div align="center"><?php echo $row_proupdateRs['email']; ?></div></td>
                  <td width="50" align="center"><a href="manage_partners.php?proid=<?php echo $row_proupdateRs['spid']; ?>" class="headeradmin">Edit</a></td>
                  <td width="50" align="center"><a href="view_partners.php?proid=<?php echo $row_proupdateRs['spid']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="headeradmin">Delete</a></td>
                </tr>
                <?php } while ($row_proupdateRs = mysql_fetch_assoc($proupdateRs)); ?>
            </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($partnerRs);
mysql_free_result($proupdateRs);
?>
