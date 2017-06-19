<?php require_once('header.php'); ?>







<div class="main-content">



<div class="container">







<?php require_once('left_content.php'); 



 require_once('featured_event.php');

$citysql= "SELECT * FROM `cities` order by `default_city` DESC";



$city_query= mysql_query($citysql, $eventscon) or die(mysql_error());

 
while($citydata=mysql_fetch_assoc($city_query)){


 $event_id=$events['tid'];



 $sql= "SELECT * FROM `events` where city=".$citydata['id']." and  date_end >= '$date' and tid!='$event_id' and ongoing = 1 order by sale_date ASC,hot DESC ";



$event_query= mysql_query($sql, $eventscon) or die(mysql_error());

$count=mysql_num_rows($event_query);
if($count>0)
{

  ?>







<div class="conent-right">





<h1 class="heading_inn"><?php echo $citydata['name'];?> Events</h1>

<div class="leftblock">







<?php 



$ul=1;







while($event=mysql_fetch_assoc($event_query)){

$ticket_available = "false";
$eventid=$event['tid'];
$query_ticketsRs = sprintf("SELECT pid, tickets, ctickets FROM event_prices WHERE tid = %s ORDER BY price desc", $eventid);
//echo $query_ticketsRs;
$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());
while ($row_ticketsRs = mysql_fetch_assoc($ticketsRs)){
$query_oticketsRs = sprintf("select sum(tickets) adult, sum(ctickets) child from ticket_orders where tid = %s and ticket_price = '%s'", $eventid, $row_ticketsRs['pid']);
//echo $query_oticketsRs;
$oticketsRs = mysql_query($query_oticketsRs) or die(mysql_error());
$row_oticketsRs = mysql_fetch_assoc($oticketsRs);
if($row_ticketsRs['tickets']>$row_oticketsRs['adult']) { $ticket_available = "true"; }
if($row_ticketsRs['ctickets']>$row_oticketsRs['child']) { $ticket_available = "true"; }
}

if(($ul%2)==1)echo "<ul>";



?>



<li><a href="#" class="date"><?php echo date('d/m/Y',strtotime($event['date_end']));?> </a><img src="data/<?php echo $event['pic'];?>" style="width:318px; height:239px;"/>



<div class="list_content">



<div class="list_content_left">



<p><?php echo $event['title'];?></p>



<!--<p>Location: <?php //echo $event['venue'];?> 



<?php //if($event['ongoing']==ONGOING) echo 'On Going';?>



<?php //if($event['ongoing']==UPCOMING) echo 'Up Coming';?>



<?php //if($event['ongoing']==GUEST) echo 'Guest';?> </p>-->



</div>



<div class="list_content_right">



<a href="events_details.php?eid=<?php echo $event['tid']; ?>" class="moreinfo">More Info</a>


<?php if($ticket_available == "true"){?>
<?php $today = date("Y-m-d"); if($today >= $event['sale_date']){?>
<a href="events_buy.php?eid=<?php echo $event['tid']; ?>" class="buybnt" style="float:right; color:#fff;">BUY NOW</a>
<?php } else {echo "<span class='buybnt' style='float: right;width: 72px;'>COMING SOON</span>";?>
<?php }?>
<?php } else echo "<span class='buybnt' style='float: right;width: 72px;'>SOLD OUT</span>";?>




</div>



</div>



</li>







<?php 



if(($ul%2)==0)echo "</ul>";



$ul++;



}?>



</div>







<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->



<?php //require_once('menu.php'); ?>



<!--<div class="shows-box">







<h1>Events</h1>



<div class="shows-box-frames">



 <table width="100%" border="0" cellspacing="0" cellpadding="0" >



                  <tr>



                    <td class="heading_events">Upcoming Events</td>



                  </tr>



                  <tr>



                    <td>&nbsp;</td>



                  </tr>



                  <tr>



                    <td align="left" valign="top"><?php //require("upcoming_events.php"); ?></td>



                  </tr>



                  <tr>



                    <td>&nbsp;</td>



                  </tr>



             



                 



                  <tr>



                    <td>&nbsp;</td>



                  </tr>



                                 



                  <tr>



                    <td style="height:10px;"></td>



                  </tr>



                  <tr>



                    <td  class="heading_events">Guest List</td>



                  </tr>



                  <tr>



                    <td>&nbsp;</td>



                  </tr>



                  <tr>



                    <td align="left"><?php //require("guest_events.php"); ?></td>



                  </tr>



                  <tr>



                    <td>&nbsp;</td>







                  </tr>



              </table>



  </div>



</div>-->







</div>

<?php } } ?>





</div>



</div>







<?php require_once('footer.php'); ?>







</body>



</html>



