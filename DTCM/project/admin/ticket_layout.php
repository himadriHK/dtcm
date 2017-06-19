<?php 
//require("access.php"); 
include("../config.php"); 
include("../functions.php");
require_once('../Connections/eventscon.php'); 
require_once('../model_function.php');
$seat_type_arr=get_set_type();
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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

if($_POST['layout']==''){$error=1;}

if(!$error)
{
$updateSQL = sprintf("UPDATE ticket_layout SET  layout=%s WHERE id=1",
GetSQLValueString($_POST['layout'], "text"));
mysql_select_db($database_eventscon, $eventscon);
$Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}

}
mysql_select_db($database_eventscon, $eventscon);

mysql_select_db($database_eventscon, $eventscon);
$query_eventsRs = sprintf("SELECT * FROM ticket_layout WHERE id = 1");
$eventsRs = mysql_query($query_eventsRs, $eventscon) or die(mysql_error());
$row_eventsRs = mysql_fetch_assoc($eventsRs);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="events.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/jquery-1.8.2.js"></script>
<script language="javascript" src="datepicker.js"></script>
<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#desc",
    theme:"modern",
    plugins: [
              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars code fullscreen",
              "insertdatetime media nonbreaking save table contextmenu directionality",
              "emoticons template paste textcolor colorpicker textpattern"
          ],
          toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
          toolbar2: "print preview media | forecolor backcolor emoticons",
 });
</script>

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
<td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top">
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td height="25" bgcolor="#333333"><div align="center" class="eventHeader">UPDATE TICKET LAYOUT</div></td>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText">

<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Ticket Layout:</td>
<td bgcolor="#EAFFB7"><textarea name="layout" cols="50" rows="20" id="desc"><?php echo $row_eventsRs['layout']; ?></textarea></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">&nbsp;</td>
<td bgcolor="#EAFFB7"><input type="submit" value="Update Layout"></td>
</tr>
</table>

<input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p></td>
<td width="5" valign="top">&nbsp;</td>
<td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
</table>

</td>
</tr>

</table></td>
</tr>
</table>

</body>
</html>