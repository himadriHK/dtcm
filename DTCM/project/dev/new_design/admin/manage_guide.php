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

$subcat = "";
if(isset($_POST["subcatid"])){
$subcat=$_POST["subcatid"];
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
require("upload.php");

$logo = "";
$xpic = "logo";
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350, 0,0);
$logo = $_FILES[$xpic]['name'];
}

for($i=1;$i<11;$i++){
$pic[$i] = "";
$xpic = "pic".$i;
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350, 0,0);
$pic[$i] = $_FILES[$xpic]['name'];
}
}

  $insertSQL = sprintf("INSERT INTO guide (cid, name, logo, address, city, phone, catid, subcatid, website, email, information, pic1, pic2, pic3, pic4, pic5, pic6, pic7, pic8, pic9, pic10) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cid'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($logo, "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['catid'], "int"),
                       GetSQLValueString($subcat, "int"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['info'], "text"),
                       GetSQLValueString($pic[1], "text"),
                       GetSQLValueString($pic[2], "text"),
                       GetSQLValueString($pic[3], "text"),
                       GetSQLValueString($pic[4], "text"),
                       GetSQLValueString($pic[5], "text"),
                       GetSQLValueString($pic[6], "text"),
                       GetSQLValueString($pic[7], "text"),
                       GetSQLValueString($pic[8], "text"),
                       GetSQLValueString($pic[9], "text"),
                       GetSQLValueString($pic[10], "text"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
require("upload.php");

$logo = $_POST["logos"];
$xpic = "logo";
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350, 0,0);
$logo = $_FILES[$xpic]['name'];
}

for($i=1;$i<11;$i++){
$pic[$i] = $_POST["pics".$i];
$xpic = "pic".$i;
 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350, 0,0);
$pic[$i] = $_FILES[$xpic]['name'];
}
}


  $updateSQL = sprintf("UPDATE guide SET cid=%s, name=%s, logo=%s, address=%s, city=%s, phone=%s, catid=%s, subcatid=%s, website=%s, email=%s, information=%s, pic1=%s, pic2=%s, pic3=%s, pic4=%s, pic5=%s, pic6=%s, pic7=%s, pic8=%s, pic9=%s, pic10=%s WHERE gid=%s",
                       GetSQLValueString($_POST['cid'], "int"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($logo, "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['catid'], "int"),
                       GetSQLValueString($subcat, "int"),
                       GetSQLValueString($_POST['website'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['info'], "text"),
                       GetSQLValueString($pic[1], "text"),
                       GetSQLValueString($pic[2], "text"),
                       GetSQLValueString($pic[3], "text"),
                       GetSQLValueString($pic[4], "text"),
                       GetSQLValueString($pic[5], "text"),
                       GetSQLValueString($pic[6], "text"),
                       GetSQLValueString($pic[7], "text"),
                       GetSQLValueString($pic[8], "text"),
                       GetSQLValueString($pic[9], "text"),
                       GetSQLValueString($pic[10], "text"),
                       GetSQLValueString($_POST['gid'], "int"));

  mysql_select_db($database_eventscon, $eventscon);
  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

mysql_select_db($database_eventscon, $eventscon);
$query_categoryRs = "SELECT * FROM guide_cat ORDER BY name ASC";
$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());
$row_categoryRs = mysql_fetch_assoc($categoryRs);
$totalRows_categoryRs = mysql_num_rows($categoryRs);

mysql_select_db($database_eventscon, $eventscon);
$query_countryRs = "SELECT * FROM countries ORDER BY country ASC";
$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
$row_countryRs = mysql_fetch_assoc($countryRs);
$totalRows_countryRs = mysql_num_rows($countryRs);

mysql_select_db($database_eventscon, $eventscon);
$query_guideRs = "SELECT gid, name FROM guide ORDER BY name ASC";
$guideRs = mysql_query($query_guideRs, $eventscon) or die(mysql_error());
$row_guideRs = mysql_fetch_assoc($guideRs);
$totalRows_guideRs = mysql_num_rows($guideRs);

if(isset($_GET["guideid"])){
mysql_select_db($database_eventscon, $eventscon);
$query_sub_categoryRs = "SELECT * FROM guide_sub_cat where catid=".$_GET["guideid"]." ORDER BY name ASC";
$sub_categoryRs = mysql_query($query_sub_categoryRs, $eventscon) or die(mysql_error());
$row_sub_categoryRs = mysql_fetch_assoc($sub_categoryRs);
$totalRows_sub_categoryRs = mysql_num_rows($sub_categoryRs);
}

$colname_updateguideRs = "-1";
if (isset($_GET['guideid'])) {
  $colname_updateguideRs = (get_magic_quotes_gpc()) ? $_GET['guideid'] : addslashes($_GET['guideid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_updateguideRs = sprintf("SELECT * FROM guide WHERE gid = %s", $colname_updateguideRs);
$updateguideRs = mysql_query($query_updateguideRs, $eventscon) or die(mysql_error());
$row_updateguideRs = mysql_fetch_assoc($updateguideRs);
$totalRows_updateguideRs = mysql_num_rows($updateguideRs);
?>
<?php require("access.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<script src="selectuser.js"></script>
<link href="events.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.headeradmin {color: #C31600}
-->
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="200" valign="top"><?php require("contents.php"); ?>
          <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
          <td valign="top"><?php if (!isset($_GET["guideid"])){ ?>
            <form action="manage_guide.php" method="post" enctype="multipart/form-data" name="form2">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">ADD GUIDE </span></td>
                </tr>
                <tr>
                  <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
              </table>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Country:</td>
                  <td bgcolor="#E9E9E9"><select name="cid">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_countryRs['cid']?>" ><?php echo $row_countryRs['country']?></option>
                      <?php
} while ($row_countryRs = mysql_fetch_assoc($countryRs));
?>
                    </select>
                  </td>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Category:</td>
                  <td bgcolor="#E9E9E9"><select name="catid" onchange="showSubCat(this.value)">
                      <option>Select Category</option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_categoryRs['catid']?>" ><?php echo $row_categoryRs['name']?></option>
                      <?php
} while ($row_categoryRs = mysql_fetch_assoc($categoryRs));
?>
                    </select>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Sub Category:</td>
                  <td bgcolor="#E9E9E9"><div id="subcat"></div></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Name:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="name" value="" size="40"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" valign="top" nowrap bgcolor="#CCCCCC">Logo: </td>
                  <td bgcolor="#E9E9E9"><input name="logo" type="file" id="logo" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" valign="top" nowrap bgcolor="#CCCCCC">Address:</td>
                  <td bgcolor="#E9E9E9"><textarea name="address" cols="30" rows="4"></textarea>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">City:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="city" value="" size="40"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Phone:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="phone" value="" size="40"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Website: </td>
                  <td bgcolor="#E9E9E9"><input name="website" type="text" id="website" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Email: </td>
                  <td bgcolor="#E9E9E9"><input name="email" type="text" id="email" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Info: </td>
                  <td bgcolor="#E9E9E9"><input name="info" type="text" id="info" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Pictures: </td>
                  <td bgcolor="#E9E9E9"><label for="file">1. </label>
                    <input type="file" name="pic1" id="pic1" />
                    <label for="label"><br />
                    2. </label>
                    <input type="file" name="pic2" id="label" />
                    <br />
                    <label for="label2">3. </label>
                    <input type="file" name="pic3" id="label2" />
                    <br />
                    <label for="file">4. </label>
                    <input type="file" name="pic4" id="pic4" />
                    <label for="label5"><br />
                    5. </label>
                    <input type="file" name="pic5" id="label5" />
                    <br />
                    <label for="label6">6. </label>
                    <input type="file" name="pic6" id="label6" />
                    <br />
                    <label for="file">7. </label>
                    <input type="file" name="pic7" id="pic7" />
                    <label for="label7"><br />
                    8. </label>
                    <input type="file" name="pic8" id="label7" />
                    <br />
                    <label for="label8">9. </label>
                    <input type="file" name="pic9" id="label8" />
                    <br />
                    <label for="file">10. </label>
                    <input type="file" name="pic10" id="pic10" />
                    <label for="label9"></label></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input type="submit" value="Add Guide"></td>
                </tr>
              </table>
              <input type="hidden" name="MM_insert" value="form1">
            </form>
            <?php }else{?>
            <form action="manage_guide.php" method="post" enctype="multipart/form-data" name="form1">
              <table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">EDIT GUIDE </span></td>
                </tr>
                <tr>
                  <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
                </tr>
              </table>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Country:</td>
                  <td bgcolor="#E9E9E9"><select name="cid">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_updateguideRs['cid']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
                      <?php
} while ($row_countryRs = mysql_fetch_assoc($countryRs));
?>
                    </select>                  </td>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Category:</td>
                  <td bgcolor="#E9E9E9"><select name="catid" onchange="showSubCat(this.value)">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_categoryRs['catid']?>" <?php if (!(strcmp($row_categoryRs['catid'], $row_updateguideRs['catid']))) {echo "SELECTED";} ?>><?php echo $row_categoryRs['name']?></option>
                      <?php
} while ($row_categoryRs = mysql_fetch_assoc($categoryRs));
?>
                    </select></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Sub Category:</td>
                  <td bgcolor="#E9E9E9"><div id="subcat"><script language="javascript">showSubCat(<?=$row_updateguideRs['catid']?>);</script></div></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Name:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="name" value="<?php echo $row_updateguideRs['name']; ?>" size="40"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" valign="top" nowrap="nowrap" bgcolor="#CCCCCC">Logo: </td>
                  <td bgcolor="#E9E9E9"><input name="logo" type="file" id="logo" /> <?php echo $row_updateguideRs['logo']; ?>
                  <input name="logos" type="hidden" id="logos" value="<?php echo $row_updateguideRs['logo']; ?>" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Address:</td>
                  <td bgcolor="#E9E9E9"><textarea name="address" cols="30" rows="4"><?php echo $row_updateguideRs['address']; ?></textarea></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">City:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="city" value="<?php echo $row_updateguideRs['city']; ?>" size="40"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">Phone:</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="phone" value="<?php echo $row_updateguideRs['phone']; ?>" size="40"></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Website: </td>
                  <td bgcolor="#E9E9E9"><input name="website" type="text" id="website" value="<?php echo $row_updateguideRs['website']; ?>" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Email: </td>
                  <td bgcolor="#E9E9E9"><input name="email" type="text" id="email" value="<?php echo $row_updateguideRs['email']; ?>" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Info: </td>
                  <td bgcolor="#E9E9E9"><input name="info" type="text" id="info" value="<?php echo $row_updateguideRs['information']; ?>" size="40" /></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Pictures: </td>
                  <td bgcolor="#E9E9E9"><table width="600" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><label for="file">1.
                          <input type="file" name="pic1" id="pic1" />
                          </label>
                        <?php echo $row_updateguideRs['pic1']; ?>
                        <input name="pics" type="hidden" id="pics" value="<?php echo $row_updateguideRs['pic1']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="label4">2.
                          <input type="file" name="pic2" />
                        </label>
                          <?php echo $row_updateguideRs['pic2']; ?>
                          <input name="pics2" type="hidden" id="pics2" value="<?php echo $row_updateguideRs['pic2']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="label3">3.
                          <input type="file" name="pic3" />
                          </label>
                          <?php echo $row_updateguideRs['pic3']; ?>
                          <input name="pics3" type="hidden" id="pics3" value="<?php echo $row_updateguideRs['pic3']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="file">4.
                            <input type="file" name="pic4" id="pic4" />
                          </label>
                        <?php echo $row_updateguideRs['pic4']; ?>
                        <input name="pics4" type="hidden" id="pics4" value="<?php echo $row_updateguideRs['pic4']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="label4">5.
                            <input type="file" name="pic5" />
                        </label>
                          <?php echo $row_updateguideRs['pic5']; ?>
                          <input name="pics5" type="hidden" id="pics5" value="<?php echo $row_updateguideRs['pic5']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="label3">6.
                            <input type="file" name="pic6" />
                          </label>
                        <?php echo $row_updateguideRs['pic6']; ?>
                        <input name="pics6" type="hidden" id="pics6" value="<?php echo $row_updateguideRs['pic6']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="file">7.
                            <input type="file" name="pic7" id="pic7" />
                          </label>
                        <?php echo $row_updateguideRs['pic7']; ?>
                        <input name="pics7" type="hidden" id="pics7" value="<?php echo $row_updateguideRs['pic7']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="label4">8.
                            <input type="file" name="pic8" />
                        </label>
                          <?php echo $row_updateguideRs['pic8']; ?>
                          <input name="pics8" type="hidden" id="pics8" value="<?php echo $row_updateguideRs['pic8']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="label3">9.
                            <input type="file" name="pic9" />
                          </label>
                        <?php echo $row_updateguideRs['pic9']; ?>
                        <input name="pics9" type="hidden" id="pics9" value="<?php echo $row_updateguideRs['pic9']; ?>" /></td>
                      </tr>
                      <tr>
                        <td><label for="file">10.
                            <input type="file" name="pic10" id="pic10" />
                          </label>
                        <?php echo $row_updateguideRs['pic10']; ?>
                        <input name="pics10" type="hidden" id="pics10" value="<?php echo $row_updateguideRs['pic10']; ?>" /></td>
                      </tr>
                    </table>
                    . </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input type="submit" value="Update Guide"></td>
                </tr>
              </table>
              <input type="hidden" name="gid" value="<?php echo $row_updateguideRs['gid']; ?>">
              <input type="hidden" name="MM_update" value="form2">
            </form>
            <?php }?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
