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

$picture = "";
$xpic = "pictures";
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
 
require("upload.php");
 
uploadimg($xpic, "N", "N", 0, 0, 0, 0);
$picture = $_FILES[$xpic]['name'];
}

  $insertSQL = sprintf("INSERT INTO outlets (outlet, heading, city1, address1, city2, address2, city3, address3, city4, address4, city5, address5, picture, area1, area2, area3, area4, area5, country1, country2, country3, country4, country5) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['area1'], "text"),
                       GetSQLValueString($_POST['area2'], "text"),
                       GetSQLValueString($_POST['area3'], "text"),
                       GetSQLValueString($_POST['area4'], "text"),
                       GetSQLValueString($_POST['area5'], "text"),
                       GetSQLValueString($_POST['country1'], "text"),
                       GetSQLValueString($_POST['country2'], "text"),
                       GetSQLValueString($_POST['country3'], "text"),
                       GetSQLValueString($_POST['country4'], "text"),
                       GetSQLValueString($_POST['country5'], "text"));

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

  $updateSQL = sprintf("UPDATE outlets SET outlet=%s, heading=%s, city1=%s, address1=%s, city2=%s, address2=%s, city3=%s, address3=%s, city4=%s, address4=%s, city5=%s, address5=%s, picture=%s,area1=%s,area2=%s,area3=%s,area4=%s,area5=%s,country1=%s,country2=%s,country3=%s,country4=%s,country5=%s WHERE outid=%s",
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
                       GetSQLValueString($_POST['area1'], "text"),
                       GetSQLValueString($_POST['area2'], "text"),
                       GetSQLValueString($_POST['area3'], "text"),
                       GetSQLValueString($_POST['area4'], "text"),
                       GetSQLValueString($_POST['area5'], "text"),
                       GetSQLValueString($_POST['country1'], "int"),
                       GetSQLValueString($_POST['country2'], "int"),
                       GetSQLValueString($_POST['country3'], "int"),
                       GetSQLValueString($_POST['country4'], "int"),
                       GetSQLValueString($_POST['country5'], "int"),
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
$query_countryRs = "SELECT * FROM countries ORDER BY cid ASC";

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
        <td valign="top"><?php if (!isset($_GET["outid"])){ ?>
          <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>ADD OUTLETS </span></td>
              </tr>
              <tr>
                <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
              </tr>
            </table>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
              
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Outlet:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="outlet" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Outlet Logo :</td>
                <td bgcolor="#E9E9E9"><input name="pictures" type="file" id="pictures" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Heading:</td>
                <td bgcolor="#E9E9E9"><textarea name="heading" cols="32" rows="4"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country1:</td>
                <td bgcolor="#E9E9E9"><select name="country1">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" ><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">City1:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city1" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area1:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area1" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Address1:</td>
                <td bgcolor="#E9E9E9"><textarea name="address1" cols="32" rows="4"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country2:</td>
                <td bgcolor="#E9E9E9"><select name="country2">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" ><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">City2:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city2" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area2:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area2" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Address2:</td>
                <td bgcolor="#E9E9E9"><textarea name="address2" cols="32" rows="4"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country3:</td>
                <td bgcolor="#E9E9E9"><select name="country3">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" ><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">City3:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city3" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area3:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area3" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Address3:</td>
                <td bgcolor="#E9E9E9"><textarea name="address3" cols="32" rows="4"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country4:</td>
                <td bgcolor="#E9E9E9"><select name="country4">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" ><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">City4:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city4" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area4:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area4" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Address4:</td>
                <td bgcolor="#E9E9E9"><textarea name="address4" cols="32" rows="4"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country5:</td>
                <td bgcolor="#E9E9E9"><select name="country5">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" ><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">City5:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city5" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area5:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area5" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Address5:</td>
                <td bgcolor="#E9E9E9"><textarea name="address5" cols="32" rows="4"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventVenue">&nbsp;</td>
                <td bgcolor="#E9E9E9"><input name="submit" type="submit" value="Add Outlet" /></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          <p>
            <? } else {?>
          </p>
          <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form2">
            <table width="100%" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td height="35" bgcolor="#C31600"><span class="eventHeader"><span class="headeradmin">-</span>UPDATE OUTLETS </span></td>
              </tr>
              <tr>
                <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
              </tr>
            </table>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
              
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Outlet:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="outlet" value="<?php echo $row_updateoutletRs['outlet']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap="nowrap" bgcolor="#CCCCCC" class="eventText">Outlet Logo: </td>
                <td bgcolor="#E9E9E9"><a href="../data/<?php echo $row_updateoutletRs['picture']; ?>" target="_blank"><?php echo $row_updateoutletRs['picture']; ?>
                      <input name="picture" type="hidden" id="picture" value="<?php echo $row_updateoutletRs['picture']; ?>" />
                      <br />
                      <input name="newpicture" type="file" id="newpicture" />
                </a></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Heading:</td>
                <td bgcolor="#E9E9E9"><textarea name="heading" cols="32" rows="4"><?php echo $row_updateoutletRs['heading']; ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country1:</td>
                <td bgcolor="#E9E9E9"><select name="country1">
                <option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_updateoutletRs['country1']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">City1:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city1" value="<?php echo $row_updateoutletRs['city1']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area1:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area1" value="<?php echo $row_updateoutletRs['area1']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Address1:</td>
                <td bgcolor="#E9E9E9"><textarea name="address1" cols="32" rows="4"><?php echo $row_updateoutletRs['address1']; ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country2:</td>
                <td bgcolor="#E9E9E9"><select name="country2">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs); 
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_updateoutletRs['country2']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">City2:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city2" value="<?php echo $row_updateoutletRs['city2']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area2:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area2" value="<?php echo $row_updateoutletRs['area2']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Address2:</td>
                <td bgcolor="#E9E9E9"><textarea name="address2" cols="32" rows="4"><?php echo $row_updateoutletRs['address2']; ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country3:</td>
                <td bgcolor="#E9E9E9"><select name="country3">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs); 
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_updateoutletRs['country3']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">City3:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city3" value="<?php echo $row_updateoutletRs['city3']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area3:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area3" value="<?php echo $row_updateoutletRs['area3']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Address3:</td>
                <td bgcolor="#E9E9E9"><textarea name="address3" cols="32" rows="4"><?php echo $row_updateoutletRs['address3']; ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country4:</td>
                <td bgcolor="#E9E9E9"><select name="country4">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs); 
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_updateoutletRs['country4']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">City4:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city4" value="<?php echo $row_updateoutletRs['city4']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area4:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area4" value="<?php echo $row_updateoutletRs['area4']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Address4:</td>
                <td bgcolor="#E9E9E9"><textarea name="address4" cols="32" rows="4"><?php echo $row_updateoutletRs['address4']; ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Country5:</td>
                <td bgcolor="#E9E9E9"><select name="country5">
					<option value=''>Select Country</option>
					<?php 
					$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
					$row_countryRs = mysql_fetch_assoc($countryRs);
					do {  
					?>
					<option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_updateoutletRs['country5']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
					<?php
					} while ($row_countryRs = mysql_fetch_assoc($countryRs));
					?>
					</select>
				</td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">City5:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="city5" value="<?php echo $row_updateoutletRs['city5']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap bgcolor="#CCCCCC" class="eventText">Area5:</td>
                <td bgcolor="#E9E9E9"><input type="text" name="area5" value="<?php echo $row_updateoutletRs['area5']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventText">Address5:</td>
                <td bgcolor="#E9E9E9"><textarea name="address5" cols="32" rows="4"><?php echo $row_updateoutletRs['address5']; ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap bgcolor="#CCCCCC" class="eventVenue">&nbsp;</td>
                <td bgcolor="#E9E9E9"><input type="submit" value="Update Outlet"></td>
              </tr>
            </table>
            <input type="hidden" name="outid" value="<?php echo $row_updateoutletRs['outid']; ?>">
            <input type="hidden" name="MM_update" value="form2">
            <? } ?>
          </form>
          </td>
        </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($outletsRs);

mysql_free_result($updateoutletRs);
?>
