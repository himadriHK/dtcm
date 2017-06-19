<?php require_once('../Connections/eventscon.php'); ?>
<?php include("../config.php"); ?>
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



if ((isset($_GET['tid'])) && ($_GET['tid'] != "")) {

  $deleteSQL = sprintf("DELETE FROM events WHERE tid=%s",

                       GetSQLValueString($_GET['tid'], "int"));



  mysql_select_db($database_eventscon, $eventscon);

  $Result1 = mysql_query($deleteSQL, $eventscon) or die(mysql_error());

}



mysql_select_db($database_eventscon, $eventscon);

$query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  ORDER BY hot DESC";

$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

$totalRows_eventRs = mysql_num_rows($eventRs);

?>

<? include("../functions.php");?><style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

.faselxxx {color: #C31600}

-->

</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

        <?php if($totalRows_eventRs){ do { ?>

		  

  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

  

  <tr>

    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="2">

              <tr>

                <td height="25" bgcolor="#C31600" class="eventVenue"><span class="eventHeader"><span class="faselxxx">-</span><?php echo $row_eventRs['title']; ?></span></td>

              </tr>

              <tr>

                <td height="20" bgcolor="#CCCCCC" class="eventVenue"><?php echo $row_eventRs['venue']; ?></td>

              </tr>

              <tr>

                <td height="20" bgcolor="#CCCCCC" class="eventText"><?php  if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";} 
else if($row_eventRs['ongoing']==GUEST)
{
	#guest events
	echo "Guest List";
} else { ?><?php echo eventFirstDate($row_eventRs['date_start']); ?><?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="null")){ echo " to ".eventFirstDate($row_eventRs['date_end']);} ?><?php echo " ".eventSecondDate($row_eventRs['date_start']); ?><?php }?></td>

              </tr>

              <tr>

                <td height="20" bgcolor="#FFFF66" class="eventText"><a href="update_events.php?tid=<?php echo $row_eventRs['tid']; ?>" class="eventVenue">Edit</a> | <a href="?tid=<?php echo $row_eventRs['tid']; ?>" onclick="return confirm('Are you sure you want to delete this event?')" class="eventVenue">Delete </a> </td>

              </tr>

              

            </table></td>

        </tr>

      </table></td>

    </tr>

  

</table></td>

  </tr>

          <?php } while ($row_eventRs = mysql_fetch_assoc($eventRs)); } ?>

</table>

<?php

mysql_free_result($eventRs);

?>

