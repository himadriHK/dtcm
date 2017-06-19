<?php require_once('../Connections/eventscon.php'); ?>
<?php
mysql_select_db($database_eventscon, $eventscon);
$query_leftAdvertRs = "SELECT advtid, picture, advtlink FROM adverts WHERE `position` = 'Left'";
$leftAdvertRs = mysql_query($query_leftAdvertRs, $eventscon) or die(mysql_error());
$row_leftAdvertRs = mysql_fetch_assoc($leftAdvertRs);
$totalRows_leftAdvertRs = mysql_num_rows($leftAdvertRs);

mysql_select_db($database_eventscon, $eventscon);
$query_rightAdverts = "SELECT advtid, picture, advtlink FROM adverts WHERE `position` = 'Right'";
$rightAdverts = mysql_query($query_rightAdverts, $eventscon) or die(mysql_error());
$row_rightAdverts = mysql_fetch_assoc($rightAdverts);
$totalRows_rightAdverts = mysql_num_rows($rightAdverts);

$colname_updateAdvt = "-1";
if (isset($_GET['adid'])) {
  $colname_updateAdvt = (get_magic_quotes_gpc()) ? $_GET['adid'] : addslashes($_GET['adid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_updateAdvt = sprintf("SELECT * FROM adverts WHERE advtid = %s", $colname_updateAdvt);
$updateAdvt = mysql_query($query_updateAdvt, $eventscon) or die(mysql_error());
$row_updateAdvt = mysql_fetch_assoc($updateAdvt);
$totalRows_updateAdvt = mysql_num_rows($updateAdvt);

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

if ((isset($_GET['advtid'])) && ($_GET['advtid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM adverts WHERE advtid=%s",
                       GetSQLValueString($_GET['advtid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($deleteSQL, $eventscon) or die(mysql_error());
  header("Location:manage_adverts.php");
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

$picture = $_POST['picture'];
$xpic = "newpicture";

 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){

require("upload.php");
 
uploadimg($xpic, "N", "N", 0, 0, 0, 0);
$picture = $_FILES[$xpic]['name'];
}

  $updateSQL = sprintf("UPDATE adverts SET name=%s, picture=%s, advtlink=%s, `position`=%s, disable_advt=%s WHERE advtid=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($picture, "text"),
					   GetSQLValueString($_POST['advertlink'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['disable_advt'], "text"),
                       GetSQLValueString($_POST['advtid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());

    header("Location:manage_adverts.php");
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


$picture = "";
$xpic = "picture";
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
 
require("upload.php");
 
uploadimg($xpic, "N", "N", 0, 0, 0, 0);
$picture = $_FILES[$xpic]['name'];
}

  $insertSQL = sprintf("INSERT INTO adverts (name, picture, advtlink, `position`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($picture, "text"),
                       GetSQLValueString($_POST['advertlink'], "text"),
                       GetSQLValueString($_POST['position'], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());

  header("Location:manage_adverts.php");
}
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
  </tr>
  <tr>
    <td width="160" valign="top"><?php require("contents.php"); ?></td>
    <td valign="top" bgcolor="#222222"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#222222">
      <tr>
        <td width="206" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="../images/g-dot.jpg" width="7" height="7" /></td>
            </tr>
              <?php do { ?>
                <tr>
                  <td align="center"><?php if ($row_leftAdvertRs['advtlink']!=""){ ?><a href="<?php echo $row_leftAdvertRs['advtlink']; ?>" target="_blank"><img src="../data/<?php echo $row_leftAdvertRs['picture']; ?>" border="0" /></a><?php } else { ?><img src="../data/<?php echo $row_leftAdvertRs['picture']; ?>" border="0" /><?php } ?></td>
                </tr>
                <tr>
                  <td align="center"><a href="manage_adverts.php?adid=<?php echo $row_leftAdvertRs['advtid']; ?>" class="eventHeader">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_adverts.php?advtid=<?php echo $row_leftAdvertRs['advtid']; ?>" class="eventHeader">Delete</a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <?php } while ($row_leftAdvertRs = mysql_fetch_assoc($leftAdvertRs)); ?>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table>
          <p>&nbsp;</p></td>
        <td width="10"><img src="../images/fasel-inbetween.png" width="2" height="3" /></td>
        <td width="353" valign="top" bgcolor="#222222">
		<?php if (!isset($_GET["adid"])){ ?>
		<form method="post" name="form1" action="manage_adverts.php" enctype="multipart/form-data">
          <table width="100%" align="center">
            <tr valign="baseline">
              <th colspan="2" nowrap class="eventHeader">Add Advert Banners </th>
              </tr>
            <tr valign="baseline">
              <td nowrap align="right">Name:</td>
              <td><input type="text" name="name" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Picture:</td>
              <td><input name="picture" type="file" class="formField" id="picture" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Link: </td>
              <td><input name="advertlink" type="text" id="advertlink" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Position:</td>
              <td><select name="position">
                  <option value="Left">Left</option>
                  <option value="Right">Right</option>
                  <option value="Top">Top</option>
                </select>              </td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Add Advert"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
          <?php }else{?>
          <form method="post" name="form2" action="manage_adverts.php" enctype="multipart/form-data">
            <table width="100%" align="center">
              <tr valign="baseline">
                <th colspan="2" nowrap><span class="eventHeader">Update Advert Banners </span></th>
                </tr>
              <tr valign="baseline">
                <td nowrap align="right">Name:</td>
                <td><input type="text" name="name" value="<?php echo $row_updateAdvt['name']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Picture:</td>
                <td><a href="../data/<?php echo $row_updateAdvt['picture']; ?>" target="_blank"><?php echo $row_updateAdvt['picture']; ?></a>
                  <input name="picture" type="hidden" id="picture" value="<?php echo $row_updateAdvt['picture']; ?>" />
                  <br />
                  <input name="newpicture" type="file" class="formField" id="newpicture" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Link: </td>
                <td valign="baseline"><input name="advertlink" type="text" id="advertlink" value="<?php echo $row_updateAdvt['advtlink']; ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Position:</td>
                <td width="100%" valign="baseline"><table cellpadding="3">
                    <tr>
                      <td><input type="radio" name="position" value="Left" <?php if (!(strcmp($row_updateAdvt['position'],"Left"))) {echo "CHECKED";} ?>>
                        Left</td>
                      <td><input type="radio" name="position" value="Right" <?php if (!(strcmp($row_updateAdvt['position'],"Right"))) {echo "CHECKED";} ?>>
                        Right</td>
                      <td><input type="radio" name="position" value="Top" <?php if (!(strcmp($row_updateAdvt['position'],"Top"))) {echo "CHECKED";} ?>>
                        Top</td>
                    </tr>
                </table></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Disable_advt:</td>
                <td><input type="checkbox" name="disable_advt" value=""  <?php if (!(strcmp($row_updateAdvt['disable_advt'],"Yes"))) {echo "@@checked@@";} ?>></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Update Advert"></td>
              </tr>
            </table>
            <input type="hidden" name="advtid" value="<?php echo $row_updateAdvt['advtid']; ?>">
            <input type="hidden" name="MM_update" value="form2">
          </form>
          <?php } ?></td>
        <td width="10"><img src="../images/fasel-inbetween1.png" width="2" height="3" /></td>
        <td width="206" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="../images/g-dot.jpg" width="7" height="7" /></td>
          </tr>
          <?php do { ?>
          <tr>
            <td align="center"><?php if ($row_rightAdverts['advtlink']!=""){ ?><a href="<?php echo $row_rightAdverts['advtlink']; ?>" target="_blank"><img src="../data/<?php echo $row_rightAdverts['picture']; ?>" border="0" /></a><?php } else { ?><img src="../data/<?php echo $row_rightAdverts['picture']; ?>" border="0" /><?php } ?></td>
          </tr>
          <tr>
            <td align="center"><a href="manage_adverts.php?adid=<?php echo $row_rightAdverts['advtid']; ?>" class="eventHeader">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_adverts.php?advtid=<?php echo $row_rightAdverts['advtid']; ?>" class="eventHeader">Delete</a></td>
          </tr>
          <?php } while ($row_rightAdverts = mysql_fetch_assoc($rightAdverts)); ?>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($leftAdvertRs);

mysql_free_result($rightAdverts);

mysql_free_result($updateAdvt);
?>
