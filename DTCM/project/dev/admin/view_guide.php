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

if (($_GET['act']=="delguide") && (isset($_GET['guideid'])) && ($_GET['guideid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM guide WHERE gid=%s",
                       GetSQLValueString($_GET['guideid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($deleteSQL, $eventscon) or die(mysql_error());
}
/*
mysql_select_db($database_eventscon, $eventscon);
$query_countryRs = "SELECT * FROM countries ORDER BY country ASC";
$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
$row_countryRs = mysql_fetch_assoc($countryRs);
$totalRows_countryRs = mysql_num_rows($countryRs);
*/
mysql_select_db($database_eventscon, $eventscon);
$query_categoryRs = "SELECT * FROM guide_cat ORDER BY name ASC";
$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());
$row_categoryRs = mysql_fetch_assoc($categoryRs);
$totalRows_categoryRs = mysql_num_rows($categoryRs);

mysql_select_db($database_eventscon, $eventscon);
$query_guideRs = "SELECT gid, name FROM guide ORDER BY name ASC";
$colname_updateguideRs = "-1";
if (isset($_POST['catid'])) {
  $colname_updateguideRs = (get_magic_quotes_gpc()) ? $_POST['catid'] : addslashes($_POST['catid']);
$query_guideRs = sprintf("SELECT gid, name FROM guide WHERE catid = %s ORDER BY name ASC", $colname_updateguideRs);
}
$guideRs = mysql_query($query_guideRs, $eventscon) or die(mysql_error());
$row_guideRs = mysql_fetch_assoc($guideRs);
$totalRows_guideRs = mysql_num_rows($guideRs);
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
<!--<script src="selectuser.js"></script> -->
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="200" valign="top"><?php require("contents.php"); ?><td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">GUIDE</span></td>
            </tr>
            <tr>
              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
            </tr>
          </table>
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                  <tr valign="middle">
                    <td width="150" align="right" valign="middle" nowrap="nowrap">Category:</td>
                    <td valign="middle"><form id="form1" name="form1" method="post" action="view_guide.php">
					<select name="catid">
                        <option>Select Category</option>
                        <?php 
do {  
?>
                        <option value="<?php echo $row_categoryRs['catid']?>" <?php if (!(strcmp($row_categoryRs['catid'], $colname_updateguideRs))) {echo "SELECTED";} ?>><?php echo $row_categoryRs['name']?></option>
                        <?php
} while ($row_categoryRs = mysql_fetch_assoc($categoryRs));
?>
                    </select>
					<input name="submit" type="submit" id="submit" value="Go" />
                    </form></td>
                  </tr>
                  <!--<tr valign="baseline">
                    <td width="150" align="right" nowrap="nowrap" bgcolor="#CCCCCC">Sub Category:</td>
                    <td><div id="subcat">
                      <? /*if($colname_updateguideRs!=){ ?>
                        <script language="JavaScript" type="text/javascript">showSubCat(<?=$colname_updateguideRs?>);</script>
                        <? } */ ?>
                    </div></td>
                  </tr> -->
                </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <?php if($totalRows_guideRs>0){ do { ?>
            <tr>
              <td bgcolor="#E9E9E9"><a href="manage_guide.php?guideid=<?php echo $row_guideRs['gid']; ?>" class="eventText"><?php echo $row_guideRs['name']; ?></a></td>
              <td width="70" bgcolor="#E9E9E9"><div align="center"><a href="manage_guide.php?guideid=<?php echo $row_guideRs['gid']; ?>" class="headeradmin">Edit</a></div></td>
              <td width="70" bgcolor="#E9E9E9"><div align="center"><a href="view_guide.php?act=delguide&amp;guideid=<?php echo $row_guideRs['gid']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="headeradmin">Delete</a></div></td>
            </tr>
            <?php } while ($row_guideRs = mysql_fetch_assoc($guideRs)); } ?>
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($categoryRs);

mysql_free_result($countryRs);

mysql_free_result($guideRs);

mysql_free_result($updateguideRs);
?>
