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
<script src="../js/jquery-1.8.2.js" type="text/javascript">
</script>
<script src="../js/jquery.validate.js" type="text/javascript"></script>
</head>
<body>
 <form action="../upload.php?type=catadd" method="post" enctype="multipart/form-data" id="validate_category" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td width="200" valign="top"><?php require("contents.php"); ?></td>
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td height="35" style="width:334px;" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">VIEW CITIES</span></td>
            
              <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">Country</span></td>
            </tr>
            <tr>
              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
             
                <tr>
                  <td bgcolor="#E9E9E9">Category Name</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="name" class="required"/></td>
                </tr>
                 <tr>
                  <td bgcolor="#E9E9E9">Category Short Name</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="ename" class="required"/></td>
                </tr>
                <tr>
                  <td bgcolor="#E9E9E9">Category Description</td>
                  <td bgcolor="#E9E9E9"><input type="text" name="desc" class="required"/></td>
                </tr>
                <tr>
                  <td bgcolor="#E9E9E9">Category Image</td>
                  <td bgcolor="#E9E9E9"><input type="file" name="fileToUpload" class="required"/></td>
                </tr>
                
                <tr>
                  <td bgcolor="#E9E9E9">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input type="submit" value="Save"/></td>
                </tr>
              
        </table>          </tr>
      </table></td>
  </tr>
</table>
 </form>
<script>
$(document).ready(function(e) {
    $("#validate_category").validate();
});

</script>
</body>
</html>
<?php
mysql_free_result($shiplist);
?>
