<?php include("config.php"); ?>
<?php

require_once('dateclass.php');
$objDate =  new CDate();

mysql_select_db($database_eventscon, $eventscon);

$query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".ONGOING."' ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()

$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

$totalRows_eventRs = mysql_num_rows($eventRs);

?>

<?php include("functions.php"); ?>

<script type="text/JavaScript">

<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0

  window.open(theURL,winName,features);

}

//-->

</script>

<link href="events.css" rel="stylesheet" type="text/css" />
<link href="css/TM_style.css" rel="stylesheet" type="text/css" />
<table width="100%" " border="0" cellpadding="0" cellspacing="0">

  <?php 

  if($totalRows_eventRs>0){
$count=1;
$topcount=1;
  do { ?>

    <?php

$ticket_available = "false";

$query_ticketsRs = sprintf("SELECT event_prices.* FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price desc", $row_eventRs['tid']);

//echo $query_ticketsRs;

$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());



while ($row_ticketsRs = mysql_fetch_assoc($ticketsRs)){

$query_oticketsRs = sprintf("select sum(tickets) adult, sum(ctickets) child from ticket_orders where tid = %s and ticket_price = '%s'", $row_eventRs['tid'], $row_ticketsRs['pid']);

//echo $query_oticketsRs;

$oticketsRs = mysql_query($query_oticketsRs) or die(mysql_error());

$row_oticketsRs = mysql_fetch_assoc($oticketsRs);

if($row_ticketsRs['tickets']>$row_oticketsRs['adult']) { $ticket_available = "true"; }

if($row_ticketsRs['ctickets']>$row_oticketsRs['child']) { $ticket_available = "true"; }



}

			if($row_eventRs['hot']=="Yes"){

		?>

 <tr>

      <td colspan="5" style="height:22px;" class="dot_line">&nbsp;</td>
    </tr>

    <tr>
    
      <?php
     
       if($topcount%2==1){ ?>
      <td style="background:none repeat scroll 0 0 #EEEEEE;">
      <?php }else{ ?>
       <td style="background:none repeat scroll 0 0 #FFFFFF;">
       <?php } ?>
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="140" valign="top"><img src="data/<?php echo $row_eventRs['pic']; ?>" width="187" height="140" /></td>
          <td width="20" valign="top"></td>
          <td valign="top">
		  <?php
		  $timeStartPart="";
		  if($row_eventRs['time_start_part'] !="")
		  {
		  	$timeStartPart= $row_eventRs['time_start_part'];
		  }
		  $timeEndPart="";
		  if($row_eventRs['time_end_part'] !="")
		  {
		  	$timeEndPart= $row_eventRs['time_end_part'];
		  }
		  $videoName="";
		  if($row_eventRs['videoName'] !="")
		  {
		  	$videoName= $row_eventRs['videoName'];
		  }
		  $audioName="";
		  if($row_eventRs['audioName'] !="")
		  {
		  	$audioName= $row_eventRs['audioName'];
		  }
		  ?>
		  	<b><?php echo $row_eventRs['title']; ?></b><br />
			Location: <?php echo $row_eventRs['venue']; ?><br />
<?php if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";} elseif($row_eventRs['ongoing']==GUEST){ echo "GUEST LINE";} else { ?>
                    <?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_end'])/*." ".eventSecondDate($row_eventRs['date_end'])*/;} else { ?>
                    <?php echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_start']); ?>
                    <?php } }?><br /><br />
					<?php
					if($videoName!="")
					{
					?>
					<a href="#" onClick="openVideoPlayer('<?php echo $videoName; ?>');"><img src="images/Play-icon.png" border="0" title="View Video" /></a>&nbsp;&nbsp;
					<?php
					}
					?>
					<?php
					if($audioName!="")
					{
					?>
			<a href="#" onClick="openAudioPlayer('<?php echo $audioName; ?>');"><img src="images/headset-icon.png" border="0" title="Listen Audio" /></a><br/>
					<?php
					}
					?>
<a href="javascript:"><img src="images/readmore_button.png" width="69" height="21" border="0" onclick="MM_openBrWindow('events_details.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>		  </td>
          <td width="1"></td>
<td width="120" align="center"><?php if($ticket_available == "true"){?>
                          <?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?>
                        <a href="javascript:"><img src="images/buy_now_button.png" width="103" height="42" border="0" onclick="MM_openBrWindow('events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>
                        <?php } else echo "<img border='0' src='images/coming_soon.png' />";?>
                        <?php } else echo "<img border='0' src='images/sold-bot.png' />";?></td>
        </tr>
      </table></td>
    </tr>

    <?php

		 $topcount++;	} else {

		?>

    <tr>

      <td colspan="5" style="height:22px;" class="dot_line">&nbsp;</td>
    </tr>

    <tr>
    <?php if($count%2==0){ ?>
      <td style="background:none repeat scroll 0 0 #FFFFFF;">
      <?php }else{ ?>
       <td style="background:none repeat scroll 0 0 #EEEEEE;">
       <?php } ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="140" valign="top"><img src="data/<?php echo $row_eventRs['pic']; ?>" width="187" height="140" /></td>
          <td width="20" valign="top"></td>
          <td valign="top">
		  <?php
		  $timeStartPart="";
		  if($row_eventRs['time_start_part'] !="")
		  {
		  	$timeStartPart= $row_eventRs['time_start_part'];
		  }
		  $timeEndPart="";
		  if($row_eventRs['time_end_part'] !="")
		  {
		  	$timeEndPart= $row_eventRs['time_end_part'];
		  }
		  $videoName="";
		  if($row_eventRs['videoName'] !="")
		  {
		  	$videoName= $row_eventRs['videoName'];
		  }
		  $audioName="";
		  if($row_eventRs['audioName'] !="")
		  {
		  	$audioName= $row_eventRs['audioName'];
		  }
		  ?>
		  	<b><?php echo $row_eventRs['title']; ?></b><br />
			Location: <?php echo $row_eventRs['venue']; ?><br />
<?php if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";} elseif($row_eventRs['ongoing']==GUEST){ echo "GUEST LINE";} else { ?>
                    <?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_end'])/*." ".eventSecondDate($row_eventRs['date_end'])*/;} else { ?>
                    <?php echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_start']); ?>
                    <?php } }?><br /><br />
					<?php
					if($videoName!="")
					{
					?>
					<a href="#" onClick="openVideoPlayer('<?php echo $videoName; ?>');"><img src="images/Play-icon.png" border="0" title="View Video" /></a>&nbsp;&nbsp;
					<?php
					}
					?>
					<?php
					if($audioName!="")
					{
					?>
			<a href="#" onClick="openAudioPlayer('<?php echo $audioName; ?>');"><img src="images/headset-icon.png" border="0" title="Listen Audio" /></a><br/>
					<?php
					}
					?>
<a href="javascript:"><img src="images/readmore_button.png" width="69" height="21" border="0" onclick="MM_openBrWindow('events_details.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>		  </td>
          <td width="1"></td>
<td width="120" align="center"><?php if($ticket_available == "true"){?>
                          <?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?>
                        <a href="javascript:"><img src="images/buy_now_button.png" width="103" height="42" border="0" onclick="MM_openBrWindow('events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>
                        <?php } else echo "<img border='0' src='images/coming_soon.png' />";?>
                        <?php } else echo "<img border='0' src='images/sold-bot.png' />";?></td>
        </tr>
      </table></td>
    </tr>
    

    <?php }
   $count++;
    } while ($row_eventRs = mysql_fetch_assoc($eventRs)); } ?>
</table>

<?php

mysql_free_result($eventRs);

?>

