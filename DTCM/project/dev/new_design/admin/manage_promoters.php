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
  $insertSQL = sprintf("INSERT INTO promoters (name, `desc`, phone, login, password, fax, email, website) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['desc'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['website'], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE promoters SET name=%s, `desc`=%s, phone=%s, login=%s, password=%s, blockuser=%s, fax=%s, email=%s, website=%s WHERE spid=%s",
                       GetSQLValueString($_POST['name2'], "text"),
                       GetSQLValueString($_POST['desc2'], "text"),
                       GetSQLValueString($_POST['phone2'], "text"),
                       GetSQLValueString($_POST['login2'], "text"),
                       GetSQLValueString($_POST['password2'], "text"),
                       GetSQLValueString(isset($_POST['blockuser']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['spid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

$colname_promoterRs = "-1";
if (isset($_GET['proid'])) {
  $colname_promoterRs = (get_magic_quotes_gpc()) ? $_GET['proid'] : addslashes($_GET['proid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_promoterRs = sprintf("SELECT * FROM promoters WHERE spid = %s ORDER BY name ASC", $colname_promoterRs);
$promoterRs = mysql_query($query_promoterRs, $eventscon) or die(mysql_error());
$row_promoterRs = mysql_fetch_assoc($promoterRs);
$totalRows_promoterRs = mysql_num_rows($promoterRs);

mysql_select_db($database_eventscon, $eventscon);
$query_proupdateRs = "SELECT spid, name FROM promoters ORDER BY name ASC";
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
    <td valign="top"><?php if (!isset($_GET["proid"])){ ?>
<form method="post" name="form1" action="manage_promoters.php">
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>ADD PROMOTERS</span></td>
              </tr>
              <tr>
                <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
              </tr>
            </table>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                
                <tr valign="baseline">
                  <td width="150" align="right" nowrap bgcolor="#CCCCCC">Name:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="name" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap bgcolor="#CCCCCC">Address:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="desc" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap bgcolor="#CCCCCC">Phone:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="phone" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Fax: </td>
                  <td bgcolor="#E9E9E9"><input name="fax" type="text" id="fax" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Email: </td>
                  <td bgcolor="#E9E9E9"><input name="email" type="text" id="email" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Website: </td>
                  <td bgcolor="#E9E9E9"><input name="website" type="text" id="website" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap bgcolor="#CCCCCC">Login:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="login" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap bgcolor="#CCCCCC" class="eventText">Password:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="password" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input type="submit" value="Add Promoter"></td>
                </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
      </form>
            <?php }else{?>
          <form action="manage_promoters.php" method="post" name="form2" id="form2">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">UPDATE PROMOTERS</span></td>
                </tr>
                <tr>
                  <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
              </table>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Name:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="name2" value="<?php echo $row_promoterRs['name']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Address:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="desc2" value="<?php echo $row_promoterRs['desc']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Phone:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="phone2" value="<?php echo $row_promoterRs['phone']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Fax: </td>
                  <td bgcolor="#E9E9E9"><input name="fax" type="text" id="fax" value="<?php echo $row_promoterRs['fax']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Email: </td>
                  <td bgcolor="#E9E9E9"><input name="email" type="text" id="email" value="<?php echo $row_promoterRs['email']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Website: </td>
                  <td bgcolor="#E9E9E9"><input name="website" type="text" id="website" value="<?php echo $row_promoterRs['website']; ?>" size="32" /></td>
                </tr>
                
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Login:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="login2" value="<?php echo $row_promoterRs['login']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Password:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="password2" value="<?php echo $row_promoterRs['password']; ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Block</td>
                  <td bgcolor="#E9E9E9"><input <?php if (!(strcmp($row_promoterRs['blockuser'],"Yes"))) {echo "checked=\"checked\"";} ?> name="blockuser" type="checkbox" id="blockuser" value="Yes" /></td>
                </tr>
                <tr valign="baseline">
                  <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input name="submit" type="submit" value="Update Promoter" /></td>
                </tr>
            </table>
              <input type="hidden" name="spid" value="<?php echo $row_promoterRs['spid']; ?>" />
              <input type="hidden" name="MM_update" value="form2" />
      </form>
    <?php } ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($promoterRs);
mysql_free_result($proupdateRs);
?>
