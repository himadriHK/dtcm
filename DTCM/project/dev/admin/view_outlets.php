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

if ((isset($_GET['outid'])) && ($_GET['outid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM outlets WHERE outid=%s",
                       GetSQLValueString($_GET['outid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($deleteSQL, $eventscon) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

$picture = "";
$xpic = "picture";
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
 
require("upload.php");
 
uploadimg($xpic, "N", "N", 0, 0, 0, 0);
$picture = $_FILES[$xpic]['name'];
}

  $insertSQL = sprintf("INSERT INTO outlets (outlet, heading, city1, address1, city2, address2, city3, address3, city4, address4, city5, address5, picture) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['outlet'], "text"),
                       GetSQLValueString($_POST['heading'], "text"),
                       GetSQLValueString($_POST['city1'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['city2'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['city3'], "text"),
                       GetSQLValueString($_POST['address3'], "text"),
                       GetSQLValueString($_POST['city4'], "text"),
                       GetSQLValueString($_POST['address4'], "text"),
                       GetSQLValueString($_POST['city5'], "text"),
                       GetSQLValueString($_POST['address5'], "text"),
                       GetSQLValueString($_POST['picture'], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

$picture = $_POST['picture'];
$xpic = "newpicture";

 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){

require("upload.php");
 
uploadimg($xpic, "N", "N", 0, 0, 0, 0);
$picture = $_FILES[$xpic]['name'];
}

  $updateSQL = sprintf("UPDATE outlets SET outlet=%s, heading=%s, city1=%s, address1=%s, city2=%s, address2=%s, city3=%s, address3=%s, city4=%s, address4=%s, city5=%s, address5=%s, picture=%s WHERE outid=%s",
                       GetSQLValueString($_POST['outlet'], "text"),
                       GetSQLValueString($_POST['heading'], "text"),
                       GetSQLValueString($_POST['city1'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['city2'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['city3'], "text"),
                       GetSQLValueString($_POST['address3'], "text"),
                       GetSQLValueString($_POST['city4'], "text"),
                       GetSQLValueString($_POST['address4'], "text"),
                       GetSQLValueString($_POST['city5'], "text"),
                       GetSQLValueString($_POST['address5'], "text"),
                       GetSQLValueString($picture, "text"),
                       GetSQLValueString($_POST['outid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

mysql_select_db($database_eventscon, $eventscon);
$query_outletsRs = "SELECT outid, outlet FROM outlets ORDER BY outlet ASC";
$outletsRs = mysql_query($query_outletsRs, $eventscon) or die(mysql_error());
$row_outletsRs = mysql_fetch_assoc($outletsRs);
$totalRows_outletsRs = mysql_num_rows($outletsRs);

$colname_updateoutletRs = "-1";
if (isset($_GET['outid'])) {
  $colname_updateoutletRs = (get_magic_quotes_gpc()) ? $_GET['outid'] : addslashes($_GET['outid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_updateoutletRs = sprintf("SELECT * FROM outlets WHERE outid = %s", $colname_updateoutletRs);
$updateoutletRs = mysql_query($query_updateoutletRs, $eventscon) or die(mysql_error());
$row_updateoutletRs = mysql_fetch_assoc($updateoutletRs);
$totalRows_updateoutletRs = mysql_num_rows($updateoutletRs);

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
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="200" valign="top"><?php require("contents.php"); ?></td>
          <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>VIEW OUTLETS</span></td>
            </tr>
            <tr>
              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              
              <?php if($totalRows_outletsRs>0){ do { ?>
                <tr>
                  <td height="20" bgcolor="#E9E9E9"><a href="manage_outlets.php?outid=<?php echo $row_outletsRs['outid']; ?>" class="eventVenue">-<?php echo $row_outletsRs['outlet']; ?></a></td>
                  <td width="70" height="20" bgcolor="#E9E9E9"><div align="center"><a href="manage_outlets.php?outid=<?php echo $row_outletsRs['outid']; ?>" class="headeradmin">Edit</a></div></td>
                  <td width="70" height="20" bgcolor="#E9E9E9"><div align="center"><a href="view_outlets.php?outid=<?php echo $row_outletsRs['outid']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="headeradmin">Delete</a></div></td>
                </tr>
                <tr>
                  <td colspan="3" background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
                <?php } while ($row_outletsRs = mysql_fetch_assoc($outletsRs)); } ?>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($outletsRs);

mysql_free_result($updateoutletRs);
?>
