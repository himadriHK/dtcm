<?php include("config.php"); ?>
<?php


require_once('dateclass.php');
$objDate =  new CDate();

mysql_select_db($database_eventscon, $eventscon);

$query_eventRsU = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid AND ongoing=".UPCOMING." ORDER BY date_start ASC, hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()

$eventRsU = mysql_query($query_eventRsU, $eventscon) or die(mysql_error());

$row_eventRsU = mysql_fetch_assoc($eventRsU);

$totalRows_eventRsU = mysql_num_rows($eventRsU);

?>





<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	
  <?php 
	if($totalRows_eventRsU==0)
	{
	?>
<tr><td>No records found.</td></tr>
	<?php	
	}
  if($totalRows_eventRsU>0){
$topcount=1;
  do { ?>

    <?php

$ticket_availableU = "false";

$query_ticketsRsU = sprintf("SELECT event_prices.* FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price desc", $row_eventRsU['tid']);

//echo $query_ticketsRs;

$ticketsRsU = mysql_query($query_ticketsRsU) or die(mysql_error());


$count=0;
while ($row_ticketsRsU = mysql_fetch_assoc($ticketsRsU))
{

$query_oticketsRsU = sprintf("select sum(tickets) adult, sum(ctickets) child from ticket_orders where tid = %s and ticket_price = '%s'", $row_eventRsU['tid'], $row_ticketsRsU['pid']);

//echo $query_oticketsRs;

$oticketsRsU = mysql_query($query_oticketsRsU) or die(mysql_error());

$row_oticketsRsU = mysql_fetch_assoc($oticketsRsU);

if($row_ticketsRsU['tickets']>$row_oticketsRsU['adult']) { $ticket_availableU = "true"; }

if($row_ticketsRsU['ctickets']>$row_oticketsRsU['child']) { $ticket_availableU = "true"; }

$count++;

}
//echo $count.'&nbsp;'.$$row_eventRsU['tid'].'<br>';
			if($row_eventRsU['hot']=="Yes"){

		?>
	 <tr>

      <td colspan="5" style="height:22px;" class="dot_line">&nbsp;</td>
    </tr>
    <tr>

      <td><img src="data/<?php echo $row_eventRsU['pic']; ?>" /></td>
    </tr>

    <tr>

     <?php
     
       if($topcount%2==1){ ?>
      <td style="background:none repeat scroll 0 0 #EEEEEE;">
      <?php }else{ ?>
       <td style="background:none repeat scroll 0 0 #FFFFFF;">
       <?php } ?>
      
      <table width="100%" border="0" cellpadding="0" cellspacing="10" class="border-bottom">
        
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="187">&nbsp;</td>
              <td width="20"></td>
              <td>
			  <?php
		  $timeStartPart="";
		  if($row_eventRsU['time_start_part'] !="")
		  {
		  	$timeStartPart= $row_eventRsU['time_start_part'];
		  }
		  $timeEndPart="";
		  if($row_eventRsU['time_end_part'] !="")
		  {
		  	$timeEndPart= $row_eventRsU['time_end_part'];
		  }
		  $videoName="";
		  if($row_eventRsU['videoName'] !="")
		  {
		  	$videoName= $row_eventRsU['videoName'];
		  }
		  $audioName="";
		  if($row_eventRsU['audioName'] !="")
		  {
		  	$audioName= $row_eventRsU['audioName'];
		  }
		  ?>
			  <b><?php echo $row_eventRsU['title']; ?></b><br />
                  <?php echo $row_eventRsU['venue']; ?><br />
                  <?php if ($row_eventRsU['ongoing']==ONGOING){ echo "Ongoing";} elseif($row_eventRs['ongoing']==GUEST){ echo "GUEST LINE";} else { ?>
                  <?php echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRsU['date_start']);//eventFirstDate() ?>
				  
                  <?php if (($row_eventRsU['date_end']) and ($row_eventRsU['date_end']!="0000-00-00") and ($row_eventRsU['date_end']!=$row_eventRsU['date_start'])){ echo "<br>Date End :".$objDate->getdate_da_mo_year($row_eventRsU['date_end']);//eventFirstDate()
				  } ?>
				  <?php if($row_eventRsU['time_start'] != "00:00:00" and $row_eventRsU['time_end'] != "00:00:00"){echo '<br>Time Start :'.$row_eventRsU['time_start'].'&nbsp;'.$timeStartPart;?>
		 <?php echo "<br>Time End :".$row_eventRsU['time_end'].'&nbsp;'.$timeEndPart;} ?>
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
					<a href="#" onClick="openAudioPlayer('<?php echo $audioName; ?>');"><img src="images/headset-icon.png" border="0"  title="Listen Audio" /></a><br/>
					<?php
					}
					?>
                  <?php }?>
                <br /><br />
                <a href="javascript:"><img src="images/readmore_button.png" width="69" height="21" border="0" onclick="MM_openBrWindow('events_details.php?eid=<?php echo $row_eventRsU['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a> </td>
              <td style="width:1px;"></td>
              <td width="120" align="center" style="width:79px;">
			  <?php if($ticket_availableU == "true")
			     {?>
                  <?php $today = date("Y-m-d");  
				     if($today >= $row_eventRsU['sale_date'])
				    {?>
                  <a href="javascript:"><img src="images/buy_now_button.png" width="103" height="42" border="0" onclick="MM_openBrWindow('events_buy.php?eid=<?php echo $row_eventRsU['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>
                  <?php } 
				      else echo "<img border='0' src='images/coming_soon.png' />";?>
                  <?php 
				  
				  } 
				  else 
				  /*echo "Sold"; modified on december 30*/
				  if($count==0)
				{
					 echo "<img border='0' src='images/coming_soon.png' />";
					echo "<br/><br/>&nbsp;<a href='register.php?tid=".$row_eventRsU['tid']."'> <img border='0' src='images/register.png'></a>";
				}
				else
				{
					echo "Sold";
				}
				  
				  ?>				  </td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
	
    <?php

			} else {

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
          <td width="140"><img src="data/<?php echo $row_eventRsU['pic']; ?>" width="187" height="140" /></td>
          <td width="20"></td>
          <td valign="top">
		  <?php
		  $timeStartPart="";
		  if($row_eventRsU['time_start_part'] !="")
		  {
		  	$timeStartPart= $row_eventRsU['time_start_part'];
		  }
		  $timeEndPart="";
		  if($row_eventRsU['time_end_part'] !="")
		  {
		  	$timeEndPart= $row_eventRsU['time_end_part'];
		  }
		  $videoName="";
		  if($row_eventRsU['videoName'] !="")
		  {
		  	$videoName= $row_eventRsU['videoName'];
		  }
		  $audioName="";
		  if($row_eventRsU['audioName'] !="")
		  {
		  	$audioName= $row_eventRsU['audioName'];
		  }
		  ?>
		  	<b><?php echo $row_eventRsU['title']; ?></b><br />
			Location: <?php echo $row_eventRsU['venue']; ?><br />
<?php if ($row_eventRsU['ongoing']==ONGOING){ echo "Ongoing";} elseif($row_eventRs['ongoing']==GUEST){ echo "GUEST LINE";} else { ?>
                    <?php if (($row_eventRsU['date_end']) and ($row_eventRsU['date_end']!="0000-00-00") and ($row_eventRsU['date_end']!=$row_eventRsU['date_start'])){ echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRsU['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRsU['date_end']);//eventMiddleDate()   eventFirstDate()   eventSecondDate() ." ".$row_eventRsU['date_end']
					if($row_eventRsU['time_start'] != "00:00:00" and $row_eventRsU['time_end'] != "00:00:00"){echo '<br>Time Start :'.$row_eventRsU['time_start'].'&nbsp;'.$timeStartPart;?>
		 <?php echo "<br>Time End :".$row_eventRsU['time_end'].'&nbsp;'.$timeEndPart;} 
					} else { ?>
                    <?php echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRsU['date_start'])."<br>Date End : ".$objDate->getdate_da_mo_year($row_eventRsU['date_start']);
					//eventFirstDate()  eventSecondDate()
					 ?>
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
			<a href="#" onClick="openAudioPlayer('<?php echo $audioName; ?>');"><img src="images/headset-icon.png" border="0"  title="Listen Audio" /></a><br/>
					<?php
					}
					?>
<a href="javascript:"><img src="images/readmore_button.png" width="69" height="21" border="0" onclick="MM_openBrWindow('events_details.php?eid=<?php echo $row_eventRsU['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>		  </td>
          <td style="width:1px;"></td>
          <td width="120" align="center" style="width:79px;">
		  <?php if($ticket_availableU == "true")
		     {?>
                 <?php $today = date("Y-m-d"); 
				 if($today >= $row_eventRsU['sale_date'])
				 {?>
                        <a href="javascript:"><img src="images/buy_now_button.png" width="103" height="42" border="0" onclick="MM_openBrWindow('events_buy.php?eid=<?php echo $row_eventRsU['tid']; ?>','eventdetails','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=518,height=450')" /></a>
                        <?php 
				} 
				else  echo "<img border='0' src='images/coming_soon.png' />";?>
           <?php } 
			else 
			{	
				if($count==0)
				{
					 echo "<img border='0' src='images/coming_soon.png' />";
					echo "<br/><br/>&nbsp;<a href='register.php?tid=".$row_eventRsU['tid']."'><img border='0' src='images/register.png' /></a>";
				}
				else
				{
					echo "Sold";
				}
			}
			?></td>
        </tr>
      </table></td>
    </tr>
    

    <?php
    $topcount++;
     }} while ($row_eventRsU = mysql_fetch_assoc($eventRsU)); 
	
	
	} 
	
	?>
	
</table>

<?php

mysql_free_result($eventRsU);

?>

