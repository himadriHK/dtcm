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
  $insertSQL = sprintf("INSERT INTO guide_cat (name) VALUES (%s)",
                       GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE guide_cat SET name=%s WHERE catid=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['catid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

$colname_categoryRs = "-1";
if (isset($_GET['catid'])) {
  $colname_categoryRs = (get_magic_quotes_gpc()) ? $_GET['catid'] : addslashes($_GET['catid']);
mysql_select_db($database_eventscon, $eventscon);
$query_categoryRs = sprintf("SELECT * FROM guide_cat WHERE catid = %s", $colname_categoryRs);
$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());
$row_categoryRs = mysql_fetch_assoc($categoryRs);
$totalRows_categoryRs = mysql_num_rows($categoryRs);
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
    <td valign="top"><?php if (!isset($_GET["catid"])){ ?>
            <form method="post" name="form1" action="manage_guide_categories.php">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>ADD GUIDE CATEGORY </span></td>
                </tr>
                <tr>
                  <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
              </table>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                
                <tr valign="baseline">
                  <td height="20" align="right" nowrap bgcolor="#CCCCCC">Category:</td>
                  <td height="20" bgcolor="#E9E9E9"><input type="text" name="name" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td height="20" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                  <td height="20" bgcolor="#E9E9E9"><input name="submit" type="submit" value="Add Category" /></td>
                </tr>
              </table>
              <input type="hidden" name="MM_insert" value="form1" />
            </form>
            <?php } else {?>
            <form method="post" name="form2" action="manage_guide_categories.php">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>UPDATE GUIDE CATEGORY </span></td>
                </tr>
                <tr>
                  <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
              </table>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                
                <tr valign="baseline">
                  <td height="20" align="right" nowrap bgcolor="#CCCCCC">Name:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="name" value="<?php echo $row_categoryRs['name']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td height="20" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input type="submit" value="Update Category"></td>
                </tr>
              </table>
              <input type="hidden" name="catid" value="<?php echo $row_categoryRs['catid']; ?>">
              <input type="hidden" name="MM_update" value="form2">
            </form>
          <?php } ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($categoryRs);
?>
