<?php require("access.php"); ?>
<?php include("../config.php"); ?>
<? include("../functions.php");?>

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



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {

  $updateSQL = sprintf("UPDATE event_prices SET tid=%s, price=%s, cprice=%s, currency=%s, stand=%s, tickets=%s, ctickets=%s WHERE pid=%s",

                       GetSQLValueString($_POST['title'], "int"),

                       GetSQLValueString($_POST['price'], "double"),

					   GetSQLValueString($_POST['cprice'], "double"),

                       GetSQLValueString($_POST['currency'], "text"),

                       GetSQLValueString($_POST['stand'], "text"),

                       GetSQLValueString($_POST['tickets'], "int"),

                       GetSQLValueString($_POST['ctickets'], "int"),

                       GetSQLValueString($_POST['pid'], "int"));



  mysql_select_db($database_eventscon, $eventscon);

  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());

}



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {



require("upload.php");



$picture = $_POST["upicture"];

$xpic = "picture";

 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){

 	if ($_POST["hot"]=="Yes"){

		uploadimg($xpic, "N", "N", 500, 350, 470, 165);

	} else {

		uploadimg($xpic, "N", "N", 500, 350, 125, 100);	

	}

$picture = $_FILES[$xpic]['name'];

}



$locmap = $_POST["ulocmap"];

$xpic = "locmap";

 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){

uploadimg($xpic, "N", "N", 500, 350,0,0);

$locmap = $_FILES[$xpic]['name'];

}



$floorplan = $_POST["ufloorplan"];

$xpic = "floorplan";

 if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){

uploadimg($xpic, "N", "N", 500, 350,0,0);

$floorplan = $_FILES[$xpic]['name'];

}



if ($_POST['date_start']==""){

	$datestart = "";

} else { $datestart = getpdate($_POST['date_start']); }





if ($_POST['date_end']==""){

	$dateend = "";

} else {$dateend = getpdate($_POST['date_end']);}





if ($_POST['sale_date']==""){

	$saledate = "2007-10-01";

} else {$saledate = getpdate($_POST['sale_date']);}





$eventdesc = str_replace("\n", "<br>", $_POST['desc']);

  $updateSQL = sprintf("UPDATE events SET title=%s, `desc`=%s, thumb=%s, pic=%s, date_start=%s, date_end=%s, venue=%s, dress=%s, age_limit=%s, restaurant=%s, rest_room=%s, hot=%s, country=%s, promoter=%s, loc_map=%s, floorplan=%s, ongoing=%s, session_hour=%s, doors_open=%s, sale_date=%s, time_start=%s, time_end= %s, time_start_part=%s, time_end_part=%s WHERE tid=%s",

                       GetSQLValueString($_POST['title'], "text"),

                       GetSQLValueString($eventdesc, "text"),

                       GetSQLValueString("t_".$picture, "text"),

                       GetSQLValueString($picture, "text"),

                       GetSQLValueString($datestart, "date"),

                       GetSQLValueString($dateend, "date"),

                       GetSQLValueString($_POST['venue'], "text"),

                       GetSQLValueString($_POST['dress'], "text"),

                       GetSQLValueString($_POST['age_limit'], "text"),

                       GetSQLValueString(isset($_POST['restaurant']) ? "true" : "", "defined","'Yes'","'No'"),

                       GetSQLValueString(isset($_POST['rest_room']) ? "true" : "", "defined","'Yes'","'No'"),

                       GetSQLValueString(isset($_POST['hot']) ? "true" : "", "defined","'Yes'","'No'"),

                       GetSQLValueString($_POST['country'], "int"),

                       GetSQLValueString($_POST['promoter'], "int"),

                       GetSQLValueString($locmap, "text"),

                       GetSQLValueString($floorplan, "text"),

                       GetSQLValueString($_POST['ongoing'], "int" ),#? "true" : "", "defined","'Yes'","'No'"

                       GetSQLValueString($_POST['session_hour'], "date"),

                       GetSQLValueString($_POST['doors_open'], "date"),

                       GetSQLValueString($saledate, "date"),

                       		   
					   GetSQLValueString($_POST['time_start'], "date"),
					   
					   GetSQLValueString($_POST['time_end'], "date"),
					   
					   GetSQLValueString($_POST['drpTimeStartPart'], "text"),
					   
					   GetSQLValueString($_POST['drpTimeEndPart'], "text"),
					   
					   GetSQLValueString($_POST['tid'], "int"));

//echo $updateSQL;

  mysql_select_db($database_eventscon, $eventscon);

  $Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());

}



mysql_select_db($database_eventscon, $eventscon);

$query_promotersRs = "SELECT spid, name FROM promoters ORDER BY name ASC";

$promotersRs = mysql_query($query_promotersRs, $eventscon) or die(mysql_error());

$row_promotersRs = mysql_fetch_assoc($promotersRs);

$totalRows_promotersRs = mysql_num_rows($promotersRs);



mysql_select_db($database_eventscon, $eventscon);

$query_countryRs = "SELECT * FROM countries ORDER BY country ASC";

$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());

$row_countryRs = mysql_fetch_assoc($countryRs);

$totalRows_countryRs = mysql_num_rows($countryRs);



$colname_eventsRs = "-1";

if (isset($_GET['tid'])) {

  $colname_eventsRs = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);

}

mysql_select_db($database_eventscon, $eventscon);

$query_eventsRs = sprintf("SELECT * FROM events WHERE tid = %s", $colname_eventsRs);

$eventsRs = mysql_query($query_eventsRs, $eventscon) or die(mysql_error());

$row_eventsRs = mysql_fetch_assoc($eventsRs);

$totalRows_eventsRs = mysql_num_rows($eventsRs);



$colname_priceRs = "-1";

if (isset($_GET['tid'])) {

  $colname_priceRs = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);

}

mysql_select_db($database_eventscon, $eventscon);

$query_priceRs = sprintf("SELECT * FROM event_prices WHERE tid = %s", $colname_priceRs);

$priceRs = mysql_query($query_priceRs, $eventscon) or die(mysql_error());

//$row_priceRs = mysql_fetch_assoc($priceRs);

$totalRows_priceRs = mysql_num_rows($priceRs);



mysql_select_db($database_eventscon, $eventscon);

$query_alleventsRs = "SELECT * FROM events ORDER BY title ASC";

$alleventsRs = mysql_query($query_alleventsRs, $eventscon) or die(mysql_error());

$row_alleventsRs = mysql_fetch_assoc($alleventsRs);

$totalRows_alleventsRs = mysql_num_rows($alleventsRs);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Ticket Master</title>

<link href="events.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="datepicker.js"></script>

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

          <td valign="top"><form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">

              <table width="100%" border="0" cellspacing="1" cellpadding="0">

                <tr>

                  <td height="25" bgcolor="#333333"><div align="center" class="eventHeader">UPDATE EVENTS</div></td>

                </tr>

              </table>

              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText">

                

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Title:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="title" value="<?php echo $row_eventsRs['title']; ?>" size="32"></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Desc:</td>

                  <td bgcolor="#EAFFB7"><textarea name="desc" cols="32" rows="4"><?php echo $row_eventsRs['desc']; ?></textarea></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Pic:</td>

                  <td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['pic']; ?>" target="_blank"><?php echo $row_eventsRs['pic']; ?>

                    <input name="upicture" type="hidden" id="upicture" value="<?php echo $row_eventsRs['pic']; ?>" />

                    <br />

                    <input name="picture" type="file" class="formField" id="picture" />

                    </a></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Date_start:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="date_start" value="<?php if($row_eventsRs['date_start']!=""){ echo getddate($row_eventsRs['date_start']); } ?>" size="32" readonly>

                    <a href="javascript:NewCal('date_start','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Date_end:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="date_end" value="<?php if($row_eventsRs['date_end']!=""){ echo getddate($row_eventsRs['date_end']); } ?>" size="32">

                    <a href="javascript:NewCal('date_end','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Venue:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="venue" value="<?php echo $row_eventsRs['venue']; ?>" size="32"></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Dress:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="dress" value="<?php echo $row_eventsRs['dress']; ?>" size="32"></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Age_limit:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="age_limit" value="<?php echo $row_eventsRs['age_limit']; ?>" size="32"></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Restaurant:</td>

                  <td bgcolor="#EAFFB7"><input type="checkbox" name="restaurant" value="Yes"  <?php if (!(strcmp($row_eventsRs['restaurant'],"Yes"))) {echo "checked=\"checked\"";} ?>></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Rest_room:</td>

                  <td bgcolor="#EAFFB7"><input type="checkbox" name="rest_room" value="Yes"  <?php if (!(strcmp($row_eventsRs['rest_room'],"Yes"))) {echo "checked=\"checked\"";} ?>></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Hot:</td>

                  <td bgcolor="#EAFFB7"><input type="checkbox" name="hot" value="Yes" <?php if (!(strcmp($row_eventsRs['hot'],"Yes"))) {echo "checked=\"checked\"";} ?>></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Country:</td>

                  <td bgcolor="#EAFFB7"><select name="country">

                      <?php 

do {  

?>

                      <option value="<?php echo $row_countryRs['cid']?>" <?php if (!(strcmp($row_countryRs['cid'], $row_eventsRs['country']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>

                      <?php

} while ($row_countryRs = mysql_fetch_assoc($countryRs));

?>

                    </select>                  </td>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Promoter:</td>

                  <td bgcolor="#EAFFB7"><select name="promoter">

                      <?php 

do {  

?>

                      <option value="<?php echo $row_promotersRs['spid']?>" <?php if (!(strcmp($row_promotersRs['spid'], $row_eventsRs['promoter']))) {echo "SELECTED";} ?>><?php echo $row_promotersRs['name']?></option>

                      <?php

} while ($row_promotersRs = mysql_fetch_assoc($promotersRs));

?>

                    </select>                  </td>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Loc_map:</td>

                  <td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['loc_map']; ?>" target="_blank"><?php echo $row_eventsRs['loc_map']; ?>

                    <input name="ulocmap" type="hidden" id="ulocmap" value="<?php echo $row_eventsRs['loc_map']; ?>" />

                    <br />

                    <input name="locmap" type="file" class="formField" id="locmap" />

                  </a></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Floorplan:</td>

                  <td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['floorplan']; ?>" target="_blank"><?php echo $row_eventsRs['floorplan']; ?>

                    <input name="ufloorplan" type="hidden" id="ufloorplan" value="<?php echo $row_eventsRs['floorplan']; ?>" />

                    <br />

                    <input name="floorplan" type="file" class="formField" id="floorplan" />

                    </a></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Event:</td>

                  <td bgcolor="#EAFFB7"><!--<input type="checkbox" name="ongoing" value="Yes"  <?php //if (!(strcmp($row_eventsRs['ongoing'],"Yes"))) {echo "checked=\"checked\"";} ?>>-->
				  <select name="ongoing" class="formField" >
				  <?php
				  $ongoingValue=$row_eventsRs['ongoing'];
				  if($ongoingValue == ONGOING )
				  {
				  ?>
				  	<option value="<?php echo ONGOING?>" selected="selected">On Going</option>
					<option value="<?php echo UPCOMING?>">Up Coming</option>
					<option value="<?php echo GUEST?>">Guest List</option>
				  <?php	
				  }
				  else if ($ongoingValue == UPCOMING )
				  {
				  ?>
				  	<option value="<?php echo ONGOING?>">On Going</option>
					<option value="<?php echo UPCOMING?>" selected="selected">Up Coming</option>
					<option value="<?php echo GUEST?>">Guest Line</option>
				  <?php
				  }
				  else if ($ongoingValue == GUEST )
				  {
				  ?>
				  	<option value="<?php echo ONGOING?>">On Going</option>
					<option value="<?php echo UPCOMING?>">Up Coming</option>
					<option value="<?php echo GUEST?>" selected="selected">Guest Line</option>
				  <?php
				  }
				  
				  ?>
				  
						
						
					</select>
				  </td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Session_hour:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="session_hour" value="<?php echo $row_eventsRs['session_hour']; ?>" size="32"></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Doors_open:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="doors_open" value="<?php echo $row_eventsRs['doors_open']; ?>" size="32"></td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">Sale_date:</td>

                  <td bgcolor="#EAFFB7"><input type="text" name="sale_date" value="<?php if($row_eventsRs['sale_date']){echo getddate($row_eventsRs['sale_date']);} ?>" size="32" readonly>

                    <a href="javascript:NewCal('sale_date','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>

                </tr>
				<tr valign="baseline">

                  <td align="right" nowrap bgcolor="#CCCCCC">Time Start:</td>

                  <td bgcolor="#EAEAFF"><input type="text" name="time_start" id="time_start" value="<?php echo $row_eventsRs['time_start']; ?>" size="32" class="formField" >
 HH:MM &nbsp;
 <?php $timeStartPart = $row_eventsRs['time_start_part'];?>
 <select name="drpTimeStartPart">
 <?php
 if($timeStartPart == "AM")
 {
 ?>
 	<option value="AM" selected="selected">AM</option>
	<option value="PM">PM</option>
<?php
}
else
{
?>
	<option value="AM">AM</option>
	<option value="PM" selected="selected">PM</option>
<?php
}
?>	
</select>
                    </td>

                </tr>
				<tr valign="baseline">

                  <td align="right" nowrap bgcolor="#CCCCCC">Time End:</td>

                  <td bgcolor="#EAEAFF"><input type="text" name="time_end" id="time_end" value="<?php echo $row_eventsRs['time_end']; ?>" size="32" class="formField" > HH:MM &nbsp;<?php $timeEndPart = $row_eventsRs['time_end_part'];?>
 <select name="drpTimeEndPart">
 <?php
 if($timeEndPart == "AM")
 {
 ?>
 	<option value="AM" selected="selected">AM</option>
	<option value="PM">PM</option>
<?php
}
else
{
?>
	<option value="AM">AM</option>
	<option value="PM" selected="selected">PM</option>
<?php
}
?>	
</select>

                    </td>

                </tr>

                <tr valign="baseline">

                  <td align="right" nowrap bgcolor="#DFFF95">&nbsp;</td>

                  <td bgcolor="#EAFFB7"><input type="submit" value="Update Event"></td>

                </tr>

              </table>

              <input type="hidden" name="tid" value="<?php echo $row_eventsRs['tid']; ?>">

              <input type="hidden" name="MM_update" value="form1">

          </form>

            <p>&nbsp;</p></td>

          <td width="5" valign="top">&nbsp;</td>

          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">

            <tr>

              <td height="25" bgcolor="#333333"><div align="center"><span class="eventHeader">CLASS &amp; PRICES </span></div></td>

            </tr>

          </table>

            <?php  while ($row_priceRs = mysql_fetch_assoc($priceRs)){ ?>

            <form method="post" name="form2" action="<?php echo $editFormAction; ?>">

              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">

          <tr valign="baseline">

                    <td align="right" nowrap bgcolor="#DFFF95">Tittle:</td>

                    <td bgcolor="#EAFFB7"><select name="title" id="title">

                      <?php

do {  

?>

                      <option value="<?php echo $row_alleventsRs['tid']?>"<?php if ((strcmp($row_alleventsRs['tid'], $row_priceRs['tid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_alleventsRs['title']?></option>

                      <?php

} while ($row_alleventsRs = mysql_fetch_assoc($alleventsRs));

  $rows = mysql_num_rows($alleventsRs);

  if($rows > 0) {

      mysql_data_seek($alleventsRs, 0);

	  $row_alleventsRs = mysql_fetch_assoc($alleventsRs);

  }

?>

                      </select>                    </td>

                    <td bgcolor="#EAFFB7">&nbsp;</td>

          <tr>

                <tr valign="baseline">

                    <td align="right" nowrap bgcolor="#DFFF95">Price:</td>

                    <td bgcolor="#EAFFB7"><input type="text" name="price" value="<?php echo $row_priceRs['price']; ?>" size="32"></td>

                    <td bgcolor="#EAFFB7">No or Tickets:

                    <input name="tickets" type="text" id="tickets" value="<?php echo $row_priceRs['tickets']; ?>" size="10" /></td>

                </tr>

                  <tr valign="baseline" class="eventText">

                    <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Child Price:</td>

                    <td bgcolor="#EAEAFF"><input name="cprice" type="text" class="formField" id="cprice" value="<?php echo $row_priceRs['cprice']; ?>" size="32" /></td>

                    <td bgcolor="#EAEAFF">No or Tickets:

                    <input name="ctickets" type="text" id="ctickets" value="<?php echo $row_priceRs['ctickets']; ?>" size="10" /></td>

                  </tr>

                  <tr valign="baseline">

                    <td align="right" nowrap bgcolor="#DFFF95">&nbsp;</td>

                    <td bgcolor="#EAFFB7">&nbsp;</td>

                    <td bgcolor="#EAFFB7">&nbsp;</td>

                  </tr>

                  <tr valign="baseline">

                    <td align="right" nowrap bgcolor="#DFFF95">Currency:</td>

                    <td bgcolor="#EAFFB7"><input type="text" name="currency" value="<?php echo $row_priceRs['currency']; ?>" size="32"></td>

                    <td bgcolor="#EAFFB7">&nbsp;</td>

                  </tr>

                  <tr valign="baseline">

                    <td align="right" nowrap bgcolor="#DFFF95">Stand:</td>

                    <td bgcolor="#EAFFB7"><input type="text" name="stand" value="<?php echo $row_priceRs['stand']; ?>" size="32"></td>

                    <td bgcolor="#EAFFB7">&nbsp;</td>

                  </tr>

                  <tr valign="baseline">

                    <td align="right" nowrap bgcolor="#DFFF95">&nbsp;</td>

                    <td bgcolor="#EAFFB7"><input type="submit" value="Update Price"></td>

                    <td bgcolor="#EAFFB7">&nbsp;</td>

                  </tr>

              </table>

        <input type="hidden" name="pid" value="<?php echo $row_priceRs['pid']; ?>">

                <input type="hidden" name="MM_update" value="form2">

                <input name="tid" type="hidden" id="tid" value="<?php echo $row_priceRs['tid']; ?>" />

            </form>

			  <? 

//$alleventsRs = mysql_query($query_alleventsRs, $eventscon) or die(mysql_error());

//$row_alleventsRs = mysql_fetch_assoc($alleventsRs);

			   ?>

            <?php } ?></td>

        </tr>

    </table></td>

  </tr>

</table>

</body>

</html>

<?php

mysql_free_result($promotersRs);



mysql_free_result($countryRs);



mysql_free_result($eventsRs);



mysql_free_result($priceRs);



mysql_free_result($alleventsRs);

?>

