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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cities SET name=%s,cid=%s WHERE id=%s",
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['country'], "int"),
                       GetSQLValueString($_POST['cityid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

$colname_shiplist = "-1";
if (isset($_GET['cityid'])) {
  $colname_shiplist = (get_magic_quotes_gpc()) ? $_GET['cityid'] : addslashes($_GET['cityid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_shiplist = sprintf("SELECT * FROM cities WHERE id= %s", $colname_shiplist);
$shiplist = mysql_query($query_shiplist, $eventscon) or die(mysql_error());
$row_shiplist = mysql_fetch_assoc($shiplist);
$totalRows_shiplist = mysql_num_rows($shiplist);
$sql="select * from shippingrates";
$countryQuery= mysql_query($sql, $eventscon) or die(mysql_error());

?>
<html>
<head>
<title><?php require"title.php"; ?></title>
<link href="events.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td width="200" valign="top" bgcolor=<?php echo"$contentbg"; ?>><?php require("contents.php"); ?></td> 
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3"></td>
    <td width="850" height="22" align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">UPDATE CITY </span></td>
            </tr>
            <tr>
              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
            </tr>
          </table>
      <form name="form1" enctype=multipart/form-data method="POST" action="<?php echo $editFormAction; ?>">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F5F5F5">
          <tr bgcolor="#C0C0C0" align="center"> 
            <td colspan="2" valign="top" height="25"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#CC3300">UPDATE 
              CITY </font></b></font></td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Country</font></td>
           <td width="69%"> 
            
              <select name="country">
              <?php 
              while($country=mysql_fetch_assoc($countryQuery)){
                ?>
              <option value="<?php echo $country['countryid']; ?>" <?php if($row_shiplist['cid']==$country['countryid']){echo "selected";} ?>><?php echo $country['name']; ?></option>
               <?php 
               }
              ?>
              </select>            </td>
          </tr>
          <tr> 
            <td width="31%" valign="top" bgcolor="#C0C0C0"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#CC3300">Add City</font></td>
            <td width="69%"> 
              <input type="text" name="city" id="city" value="<?php echo $row_shiplist['name']; ?>"/>           </td>
          </tr>
          <tr> 
            <td align="center" valign="top">&nbsp;</td>
            <td valign="top"><input type="submit" name="save" value="Save">
              <input type="reset" name="Submit2" value="Clear"></td>
          </tr>
          <tr align="center" valign="bottom"> 
            <td colspan="2" height="30"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="view_city.php"><font color="#CC3300">View Cities 
              <input name="cityid" type="hidden" id="cityid" value="<?php echo $colname_shiplist?>">
            </font></a></font></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1">
      </form>    </td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($shiplist);
?>
