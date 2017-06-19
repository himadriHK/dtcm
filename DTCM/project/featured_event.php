<?php



if( $img['status']=='ON'){



?>



<div class="slider" style="margin-bottom:-2px;"> <a href="<?php echo $img['url']; ?>" target="_blank"><img style="height: 364px;width: 745px;" src="<?php echo $img['image']; ?>" /></a></div>



<?php } ?>

<?php



		$date=date('Y-m-d');



		$city_id=$_COOKIE['city_id'];



        $sql= "SELECT * FROM `events` where city='$city_id' and hot='Yes'  and date_end >= '$date' and ongoing='1' order by rand() LIMIT 0,1 ";



		$query= mysql_query($sql, $eventscon) or die(mysql_error());



		$events= mysql_fetch_array($query);



		



		if(empty($events))



		{



			header("location:ongoing_events.php");exit;



		}

$ticket_available = "false";
$eventid=$events['tid'];
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

         ?>

<div class="slider">



<?php if( $images['status']=='ON'){
    $banner_count=0;
    if($images['h1_status']!='OFF'){ $banner_count++; }
    if($images['h2_status']!='OFF'){ $banner_count++; }
    if($images['h3_status']!='OFF'){ $banner_count++; }
    if($banner_count >0){
    	?>
    <div style="float:right; margin-bottom:10px;">
    <?php if($banner_count >1){?>
	<marquee direction="left" width="697" height="106">
	<?php }?>
          <?php



if($images['h1_status']!='OFF'){
?>
          <a href="<?php echo $images['h_url']; ?>" target="_blank"> <img width="697" height="106" src="<?php echo $images['h_image']; ?>" /> </a>

          <?php }


if($images['h2_status']!='OFF'){

 ?>
          <a href="<?php echo $images['h1_url']; ?>" target="_blank"> <img width="697" height="106" src="<?php echo $images['h1_image']; ?>" /> </a>
          <?php }

if($images['h3_status']!='OFF'){
 ?>
          <a href="<?php echo $images['h2_url']; ?>" target="_blank"> <img width="697" height="106" src="<?php echo $images['h2_image']; ?>" /> </a>
          <?php 
}
?>
 <?php if($banner_count >1){?>
      </marquee>
<?php }?>
      </div>
      <?php } 
    }?>

<div class="bannerbg">



<div id="wrap">



<h1><?php echo $events['title'];?></h1>



  <div class="jcarousel-skin-tango">



    <div style="position: relative; display: block;"  >



      <div style="position: relative;">



       <div class="price_col">

       <?php echo date('d/m/Y',strtotime($events['date_end']));?>

</div>

        



         



          <a target="_blank" href="events_details.php?eid=<?php echo $events['tid']; ?>"><img src="data/<?php echo $events['pic']; ?>" style="width:645px;" ></a>



          



      </div>



      



    </div>



  </div>



  <div class="timebar_col">

<div class="events_starts">Event Starts in</div>

  <div class="timebar">



  <img src="img/bomber.png" />



  <div class="time_zone">



<span class="timebg">  <strong id="disp-Days"></strong>        <strong id="disp-Hour"></strong>         <strong id="disp-Min"></strong>        <strong style="border:none;" id="disp-Sec"></strong></span> 



<span><strong>Days</strong> <strong>Hrs</strong> <strong>Min</strong>	<strong>Sec</strong></span>



  </div>



  </div>



  



  <div class="bynow" style="width:115px;">

<?php if($ticket_available == "true"){?><?php $today = date("Y-m-d"); if($today >= $events['sale_date']){?><a href="events_buy.php?eid=<?php echo $events['tid']; ?>" >Buy Now</a><?php } else echo '<span class="comingsoon">Coming Soon</span>';?><?php } else {echo '<span class="nobuy">Sold Out</span>';}?>
  



  </div>



  <div class="morelink"><a href="events_details.php?eid=<?php echo $events['tid'];?>">More Info</a></div>



  </div>



</div>



</div>



</div>



<?php



$diff_time=strtotime($events['date_end'])-strtotime($events['date_start']);



$kick_time = strtotime($events['date_start']) - time();



if(strtotime($events['date_start'])<time())



$time=$diff_time;



else



$time=$kick_time;



?>



<script type="text/javascript">



function vin_cn(start){



window.start = parseFloat(start);



var end = 0 // change this to stop the counter at a higher value



var refresh=1000; // Refresh rate in milli seconds







if(window.start >= end ){



mytime=setTimeout('vin_cnt()',refresh)



}



}







function vin_cnt() {



// Calculate the number of days left



var days=Math.floor(window.start / 86400);







// After deducting the days calculate the number of hours left







var hours = Math.floor((window.start - (days * 86400 ))/3600)



// After days and hours , how many minutes are left







var minutes = Math.floor((window.start - (days * 86400 ) - (hours *3600 ))/60)



// Finally how many seconds left after removing days, hours and minutes.







var secs = Math.floor((window.start - (days * 86400 ) - (hours *3600 ) - (minutes*60)))







var x = window.start + "(" + days + " Days " + hours + " Hours " + minutes + " Minutes and " + secs + " Secondss " + ")";







if (days < 10) { days = '0'+ days;}







if (hours < 10) { hours = '0'+ hours;}







if (minutes < 10) { minutes = '0'+ minutes;}







if (secs < 10) { secs = '0'+ secs;}







document.getElementById('disp-Days').innerHTML = days;







document.getElementById('disp-Hour').innerHTML = hours







document.getElementById('disp-Min').innerHTML = minutes;







document.getElementById('disp-Sec').innerHTML = secs;







window.start= window.start- 1;











tt=vin_cn(window.start);







}



vin_cn(<?php echo $time;?>);







</script>