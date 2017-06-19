<?php require_once('../Connections/eventscon.php'); ?>
<?php
mysql_select_db($database_eventscon, $eventscon);
$query_categoryRs = "SELECT * FROM guide_cat ORDER BY name ASC";
$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());
$row_categoryRs = mysql_fetch_assoc($categoryRs);
$totalRows_categoryRs = mysql_num_rows($categoryRs);

$colname_guideRs = "-1";
if (isset($_GET['guideid'])) {
  $colname_guideRs = (get_magic_quotes_gpc()) ? $_GET['guideid'] : addslashes($_GET['guideid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_guideRs = sprintf("SELECT * FROM guide WHERE gid = %s ORDER BY name ASC", $colname_guideRs);
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
<link href="../events.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="765" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
  </tr>
  <tr>
    <td><table width="765" border="0" cellpadding="0" cellspacing="0" bgcolor="#101010">
      <tr>
        <td width="206" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="../images/g-dot.jpg" width="7" height="7" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
              <tr>
                  <td background="guide.php?guideid=<?php echo $row_categoryRs['catid']; ?>"><?php echo $row_categoryRs['name']; ?></td>
              </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              <?php } while ($row_categoryRs = mysql_fetch_assoc($categoryRs)); ?>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
        <td><img src="../images/fasel-inbetween.png" width="2" height="3" /></td>
        <td width="353" bgcolor="#222222">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php do { ?>
    <tr>
      <td height="45" background="../images/fasel-middle.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10">&nbsp;</td>
            <td width="36" height="45"><div align="center"><img src="../images/sol.png" width="36" height="33" /></div></td>
            <td width="15">&nbsp;</td>
            <td class="eventHeader"><?php echo $row_guideRs['name']; ?></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10">&nbsp;</td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10" valign="top">&nbsp;</td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="25" class="eventVenue">Address: <?php echo $row_guideRs['address']; ?></td>
                  </tr>
                <tr>
                  <td height="25" class="eventText">City: <?php echo $row_guideRs['city']; ?></td>
                  </tr>
                <tr>
                  <td height="25" class="eventText">Phone: <?php echo $row_guideRs['phone']; ?></td>
                  </tr>
                
                </table></td>
            </tr>
          </table></td>
        <td width="10">&nbsp;</td>
      </tr>
        <tr>
          <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
        </table></td>
    </tr>
    <?php } while ($row_guideRs = mysql_fetch_assoc($guideRs)); ?>
          
</table>
		</td>
        <td><img src="../images/fasel-inbetween1.png" width="2" height="3" /></td>
        <td width="206">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
  </tr>
  <tr>
    <td><?php require("footer.php"); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($categoryRs);

mysql_free_result($guideRs);
?>
