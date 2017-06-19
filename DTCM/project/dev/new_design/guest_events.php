<?php require_once('Connections/eventscon.php'); ?>
<?php include("config.php"); ?>
<?php

require_once('dateclass.php');
$objDate =  new CDate();

mysql_select_db($database_eventscon, $eventscon);

$query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".GUEST."' ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()
//echo $query_eventRs;
$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

$totalRows_eventRs = mysql_num_rows($eventRs);

?>

<?php //include("functions.php"); ?>

<script type="text/JavaScript">

<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0

  window.open(theURL,winName,features);

}

//-->

</script>
<link href="events.css" rel="stylesheet" type="text/css" />
<link href="css/TM_style.css" rel="stylesheet" type="text/css" />




<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <?php 

  if($totalRows_eventRs>0){
$topcount=1;
 do { ?>

    <?php

/* $ticket_available = "false";

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

			if($row_eventRs['hot']=="Yes"){*/

		?>

<!--  <tr>

      <td><img src="data/<?php echo $row_eventRs['pic']; ?>" /></td>
    </tr>

    <tr>

        <?php
     
       if($topcount%2==1){ ?>
      <td style="background:none repeat scroll 0 0 #EEEEEE;">
      <?php }else{ ?>
       <td style="background:none repeat scroll 0 0 #FFFFFF;">
       <?php } ?>
      
      <table style="width:538px;" border="0" cellspacing="10" cellpadding="0" class="border-bottom">
        
        <tr>
          <td><table width="538" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="width:130px;">&nbsp;</td>
              <td style="width:10px;"></td>
              <td style="width:318px;"><b><?php echo $row_eventRs['title']; ?></b><br />
                  <?php echo $row_eventRs['venue']; ?><br />
                  <?php if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";} elseif($row_eventRs['ongoing']==GUEST){ echo "GUEST LIST";} else { ?>
                  <?php echo eventFirstDate($row_eventRs['date_start']); ?>
                  <?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo " to ".eventFirstDate($row_eventRs['date_end']);} ?>
                  <?php echo " ".eventSecondDate($row_eventRs['date_start']); ?>
                  <?php }?>
                <br /><br />
                <a href="javascript:"><img src="images/readmore_button.gif" width="69" height="14" border="0" onclick="MM_openBrWindow('events_details.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a> </td>
              <td style="width:1px; background-color:#666666;"></td>
              <td align="center" style="width:79px;"><?php if($ticket_available == "true"){?>
                  <?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?>
                  <a href="javascript:"><img src="images/buy_now_button.gif" width="59" height="60" border="0" onclick="MM_openBrWindow('events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>
                  <?php } else echo "Coming Soon";?>
                  <?php } else echo "Sold";?></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>-->

    <?php

			 //} else {

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
      
      <table width="100%" border="0" cellspacing="10" cellpadding="0" class="border-bottom">
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
			
		 <?php /*if ($row_eventRs['ongoing']==ONGOING)
				{ 
					echo "Ongoing";
				
				} 
				elseif($row_eventRs['ongoing']==GUEST)
				{ 
					echo "GUEST LIST";
				
				} else {*/ ?>
		 <?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo 'Date Start :'.$row_eventRs['date_start']." <br>Date End : ".$row_eventRs['date_end'];
		if($row_eventRs['time_start'] != "00:00:00" and $row_eventRs['time_end'] != "00:00:00"){echo '<br>Time Start :'.$row_eventRs['time_start'].'&nbsp;'.$timeStartPart;?>
		 <?php echo "<br>Time End :".$row_eventRs['time_end'].'&nbsp;'.$timeEndPart;} 
		 } else { ?>
		 <?php echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start']);?>
		 <?php echo "<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_end']); ?>
		 <?php if($row_eventRs['time_start'] != "00:00:00" and $row_eventRs['time_end'] != "00:00:00"){echo '<br>Time Start :'.$row_eventRs['time_start'].'&nbsp;'.$timeStartPart;?>
		 <?php echo "<br>Time End :".$row_eventRs['time_end'].'&nbsp;'.$timeEndPart;} ?>
                    <?php } /*}?>eventMiddleDate() eventFirstDate() eventSecondDate()*/?>
<br /><br />
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
					<a href="#" onClick="openAudioPlayer('<?php echo $audioName; ?>');"><img src="images/headset-icon.png" title="Listen Audio" border="0" /></a><br/>
					<?php
					}
					?>
<a href="javascript:"><img src="images/readmore_button.png" width="69" height="21" border="0" onclick="MM_openBrWindow('events_details.php?eid=<?php echo $row_eventRs['tid']; ?>','guestdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>		  </td>
          <td width="1"></td>
<!--<td style="width:79px;" align="center"><?php /*if($ticket_available == "true"){?>
                          <?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?>
                        <a href="javascript:"><img src="images/buy_now_button.gif" width="59" height="60" border="0" onclick="MM_openBrWindow('events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>
                        <?php } else echo "Coming Soon";?>
                        <?php } else echo "Sold";*/?>-->
						
<td width="120" align="center">&nbsp;<a href='register.php?tid=<?php echo $row_eventRs['tid']?>'><img border="0" src="images/register.png" /></a></td>
        </tr>
      </table></td>
    </tr>
    

    <?php
    $topcount++;
     }
		while ($row_eventRs = mysql_fetch_assoc($eventRs));
	}
	else
	{
		echo '<tr><td>No records found.</td></tr>';
	} 
	 //} ?>
</table>

<?php

mysql_free_result($eventRs);

?>

