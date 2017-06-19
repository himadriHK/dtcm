<?php require_once('header.php');
require_once('model_function.php');
require_once('dtcm_api.php');
$seat_type_arr=get_set_type();
$eventid = $_GET['eid'];
$eventid = "-1";
if (isset($_GET['eid'])) {
$eventid = (get_magic_quotes_gpc()) ? $_GET['eid'] : addslashes($_GET['eid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_eventRs = sprintf("SELECT events.*, promoters.name, promoters.phone, promoters.email, promoters.website FROM events, promoters WHERE events.tid=%s and events.promoter = promoters.spid ", $eventid);
$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());
$row_eventRs = mysql_fetch_assoc($eventRs);
if(isset($row_eventRs['tid']) && $row_eventRs['tid']){
	if(!is_array($_SESSION['viewed_events_count']) || !in_array($row_eventRs['tid'],$_SESSION['viewed_events_count'])){
		$_SESSION['viewed_events_count'][]=$row_eventRs['tid'];
		mysql_query('UPDATE events SET view_count='.($row_eventRs['view_count']+1).' where tid = '.$row_eventRs['tid'], $eventscon);	
	}
	
}
$totalRows_eventRs = mysql_num_rows($eventRs);
$pageSelected = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<!--
  jCarousel library
-->
<script type="text/javascript" src="js/jquery.js"></script>
<!--
  jCarousel skin stylesheet
-->
<style type="text/css">
/**
 * Additional styles for the controls.
 */
.jcarousel-control {
	margin-bottom: 10px;
	text-align: center;
}
.jcarousel-control a {
	font-size: 75%;
	text-decoration: none;
	padding: 0 5px;
	margin: 0 0 5px 0;
	border: 1px solid #fff;
	color: #eee;
	background-color: #4088b8;
	font-weight: bold;
}
.jcarousel-control a:focus, .jcarousel-control a:active {
	outline: none;
}
.jcarousel-scroll {
	margin-top: 10px;
	text-align: center;
}
.jcarousel-scroll form {
	margin: 0;
	padding: 0;
}
.jcarousel-scroll select {
	font-size: 75%;
}
#mycarousel-next, #mycarousel-prev {
	cursor: pointer;
	margin-bottom: -10px;
	text-decoration: underline;
	font-size: 11px;
}
</style>
<script type="text/javascript">
// Ride the carousel...
jQuery(document).ready(function() {
    jQuery("#mycarousel").jcarousel({
        scroll: 1,
		auto:0,
		animation:3000,
		wrap:'circular',
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
});
/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */
function mycarousel_initCallback(carousel) {
    jQuery('.jcarousel-control a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
        return false;
    });
    jQuery('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });
    jQuery('#mycarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });
    jQuery('#mycarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};
</script>
<div class="main-content">
<div class="container">
  <div class="content-left">
    <div class="left_block">
      <h1>Events by Category</h1>
      <div class="list_block">
        <ul>
          <li><a href="ongoing_events.php?cat=all">All</a></li>
          <?php
$query_categoryRs = "SELECT * FROM category";
$categoryRs = mysql_query($query_categoryRs) or die(mysql_error());
while ($category = mysql_fetch_assoc($categoryRs)){ 
	$query_eventCat = "SELECT tid FROM events  WHERE ongoing='".ONGOING."' AND city='{$default_city_id}' AND date_end>='".date('Y-m-d')."'  AND category='".$category['id']."'";
	$catevents = mysql_query($query_eventCat, $eventscon) or die(mysql_error());
	if(mysql_num_rows($catevents)>0) {
?>
          <li><a href="ongoing_events.php?cat=<?php echo $category['ename'];?>">
            <?php if($category['image']!='') 
echo '<img src="upload/category/'.$category['image'].'" alt="'.$category['name'].'" width="25px" />'; ?>
            <?php echo $category['name'];?></a></li>
          <?php } } ?>
        </ul>
      </div>
    </div>
    <?php
$event_id=$row_eventRs['tid'];
$other_sql="select * from events where tid!={$event_id} AND date_end>='".date('Y-m-d')."' AND city='{$default_city_id}' ORDER BY hot, rand() LIMIT 0,5 ";
$other_events_query = mysql_query($other_sql, $eventscon) or die(mysql_error());
$other_events_count=mysql_num_rows($other_events_query);
if($other_events_count>0){
?>
    <div class="left_block">
      <h1>Other Events</h1>
      <div class="imgblock">
        <?php while($rows=mysql_fetch_assoc($other_events_query)){?>
        <a title="<?php echo $rows['title'];?>" href="events_details.php?eid=<?php echo $rows['tid'];?>" ><img src="data/<?php echo $rows['pic'];?>" style="height:172px;"/></a>
        <div class="divider"></div>
        <div class="eventtitle" title="<?php echo $rows['title'];?>"><?php echo substr($rows['title'],0,60);?></div>
        <div class="divider"></div>
        <div class="eventbutton"><a href="events_details.php?eid=<?php echo $rows['tid'];?>" >See Event</a></div>
        <div class="divider"></div>
        <?php }?>
      </div>
    </div>
    <?php }?>
  </div>
  <?php
$city_sql="select * from cities where id='".$row_eventRs['city']."'";
$city_query = mysql_query($city_sql, $eventscon) or die(mysql_error());
$city_details = mysql_fetch_assoc($city_query);
if($city_details)
{
$city_name=$city_details['name'];
}
$sql_promoter="select * from promoters where spid='".$row_eventRs['promoter']."'";
$query_promoter = mysql_query($sql_promoter, $eventscon) or die(mysql_error());
$promoters = mysql_fetch_assoc($query_promoter);
$ticket_available = "false";
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
function gettickets($eventid,$seat_type_arr){
$ticketid_ticketsRs = $eventid;
//echo $ticketid_ticketsRs;
$query_ticketsRs = sprintf("SELECT event_prices.price, event_prices.cprice, event_prices.pid, event_prices.currency, event_prices.stand, event_prices.tickets, event_prices.ctickets FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price desc", $ticketid_ticketsRs);
//echo $query_ticketsRs;
$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());
$row_ticketsRs = mysql_fetch_assoc($ticketsRs);
$totalRows_ticketsRs = mysql_num_rows($ticketsRs);
echo "<table width='100%' border=0 cellpadding=\"1\" cellspacing=\"1\">";
do { 
echo "<tr bgcolor=''><td>".$seat_type_arr[$row_ticketsRs['stand']]."</td>".(($row_ticketsRs['price']>0)?"<td align='right'>Adult Price:</td><td> ".$row_ticketsRs['currency'].". ".$row_ticketsRs['price']."</td>":"").(($row_ticketsRs['cprice']>0)?"<td align='right'>Child Price: </td><td>".$row_ticketsRs['currency'].". ".$row_ticketsRs['cprice']."</td>":"")."</tr>";
} while ($row_ticketsRs = mysql_fetch_assoc($ticketsRs)); 
echo "</table>";
mysql_free_result($ticketsRs);
}
function getdtcmprices($eventcode){
if(isset($_SESSION['access_token']) && (time()-$_SESSION['token_addtime'])<$_SESSION['token_lifetime']){
	$access_token = $_SESSION['access_token'];
} else{
$code_details = Dtcm::get_code();
if($code_details['access_token']!=''){
$access_token=$code_details['access_token'];
$_SESSION['access_token']=$access_token;
$_SESSION['token_lifetime']=$code_details['expires'];
$_SESSION['token_addtime']=time();
}
}
if($access_token){
$prices = Dtcm::get_prices($access_token,$eventcode);
$ticket_prices = json_decode($prices,true);
}
if(!empty($ticket_prices)){
echo "<table width='100%' border=0 cellpadding=\"1\" cellspacing=\"1\">";
foreach ($ticket_prices['PriceCategories'] as $stand){
echo "<tr bgcolor=''><td>".$stand['PriceCategoryName']."</td>";
foreach ($ticket_prices['PriceTypes'] as $priceType){
	if($priceType['PriceTypeCode'] == 'Q'){
		$price_data = get_priceByCatType($stand['PriceCategoryId'],$priceType['PriceTypeId'],$ticket_prices);
		if($price_data !='' && $price_data['PriceNet']>0 ){
			echo "<td align='right'>".$priceType['PriceTypeName'].":</td><td> AED ".$price_data['PriceNet'].'</td>';
		}
	}
}
echo "</tr>";
} 
echo "</table>";
}
}
function get_priceByCatType($catId,$typeId,$ticket_prices) {
	foreach ($ticket_prices['TicketPrices']['Prices'] as $tprice){
		if($tprice['PriceCategoryId']==$catId && $tprice['PriceTypeId']==$typeId ){
			
			return $tprice;
		}
	}
	return '';
}
$query_guidecatRs = "SELECT * FROM `banners`";
$guidecatRs = mysql_query($query_guidecatRs, $eventscon) or die(mysql_error());
$images = mysql_fetch_array($guidecatRs);
?>
  <?php include("functions.php"); ?>
  <div class="conent-right">
    <div class="slider">
      <div class="bannerbg" style="background:#fff;padding-bottom:20px;">
        <div id="wrap">
          <h1><?php echo $row_eventRs['title'];?></h1>
          <div >
            <div style="position: relative; display: block;"  >
              <div style="position: relative;">
                <div class="price_col"> <?php echo date('d/m/Y',strtotime($row_eventRs['date_end']));?> </div>
                <div class="jcarousel-skin-tango">
                  <div style="position: relative; display: block;" id="mycarousel" class="jcarousel-container jcarousel-container-horizontal">
                    <div style="position: relative;" class="jcarousel-clip jcarousel-clip-horizontal">
                      <ul style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; width: 950px;" class="jcarousel-list jcarousel-list-horizontal">
                        <?php $i=1; ?>
                        <li jcarouselindex="<?php echo $i; ?>" style="float: left; list-style: none outside none;" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-<?php echo $i; ?> jcarousel-item-<?php echo $i; ?>-horizontal"> <img src="data/<?php echo $row_eventRs['pic']; ?>" style="width:640px; height:328px;" > </li>
                        <?php 
$img_avail=false;
for($k=1;$k<=5;$k++)
{
	if($row_eventRs['event_pic'.$k]!='')
	{
		$img_avail=true;
	}
}
if($img_avail){
?>
                        <?php 
for($k=1;$k<=5;$k++)
{
	$i++;
	
?>
                        <li jcarouselindex="<?php echo $i; ?>" style="float: left; list-style: none outside none;" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-<?php echo $i; ?> jcarousel-item-<?php echo $i; ?>-horizontal"> <img src="data/<?php echo $row_eventRs['event_pic'.$k]; ?>" style="width:640px;height:328px;" > </li>
                        <?php } 
}?>
                      </ul>
                    </div>
                    <a href="#" id="mycarousel-prev" class="jcarousel-control-prev">« Prev</a> <a href="#" id="mycarousel-next" class="jcarousel-control-next">Next »</a> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="timebar_col" style="position:relative">
            <div class="view_social_icons" style="float: right;position:absolute;right:0px; width:45%;"> <span> <?php echo $row_eventRs['view_count']; ?> Views</span>
              <div class="middle-tweeter-widget" style="float: right;margin-left:20px"> <a href="https://twitter.com/share" class="twitter-share-button" data-via="Ticket Rush" data-lang="en" data-count="horizontal">Tweet</a> 
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
              </div>
              <div class="fb-share-button" data-href="http://www.tktrush.com/event_details.php?eid=<?php echo $eventid;?>" data-layout="button_count" style="float: right;"></div>
            </div>
            <?php if($row_eventRs['ongoing']!='4'){ ?>
            <div class="events_starts">Event Starts in</div>
            <div class="timebar"> <img src="img/bomber.png" />
              <div class="time_zone"> <span class="timebg"> <strong id="disp-Days"></strong> <strong id="disp-Hour"></strong> <strong id="disp-Min"></strong> <strong style="border:none;" id="disp-Sec"></strong></span> <span><strong>Days</strong> <strong>Hrs</strong> <strong>Min</strong> <strong>Sec</strong></span> </div>
            </div>
            <div class="bynow" style="width:115px;">
              <?php } else{?>
              <div class="bynow" style="width:115px;margin-top:25px;">
                <?php }?>
                <?php if($ticket_available == "true"){?>
                <?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?>
                <a href="events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>" >Buy Now</a>
                <?php } else echo '<span class="comingsoon">Coming Soon</span>';?>
                <?php } else {echo '<span class="nobuy">Sold Out</span>';}?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
$diff_time=strtotime($row_eventRs['date_end'])-strtotime($row_eventRs['date_start']);
$kick_time = strtotime($row_eventRs['date_start']) - time();
if(strtotime($row_eventRs['date_start'])<time())
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
      <div class="shows-box">
        <?php 
$category_name=$_GET['cat'];
if(isset($_GET['cat']) && $_GET['cat']!='all')
{
$sql = "select * FROM category where ename='$category_name'";
$category_query = mysql_query($sql, $eventscon) or die(mysql_error());
$category_details=mysql_fetch_assoc($category_query);
}
?>
        <h3 style="border-bottom: 1px dashed #ccc;padding: 0 0 10px;margin: 0 0 20px;">Event Information
          <?php if($row_eventRs['fb_link']!=''){?>
          <span style="float:right;"> <img src="img/fb_icon.gif" style="float:left;margin-right: 10px;"> <a href="<?php echo $row_eventRs['fb_link'];?>" style="  font-family: Georgia, Times, serif; color: #4088b8;" target="_blank" >Event Page</a> </span>
          <?php }?>
        </h3>
        <div class="shows-box-frames">
          <div class="description"><?php echo $row_eventRs['desc'];?></div>
          <h3 style="border-bottom: 1px dashed #ccc;
padding: 40px 0 10px;
margin: 40px 0 20px;
clear: both;
display: block;
width: 100%;
float: left;
border-top: 1px solid #ccc;">Ticket Prices</h3>
          <?php 
if($_SERVER['REMOTE_ADDR']=='103.16.70.143'){
	$row_eventRs['dtcm_approved']='Yes';
	$row_eventRs['dtcm_code'] = 'ETES3EL';
}
if($row_eventRs['dtcm_approved']=='Yes' && $row_eventRs['dtcm_code']!='' )
getdtcmprices($row_eventRs['dtcm_code']); 
else
gettickets($row_eventRs['tid'],$seat_type_arr); ?>
          <?php 
$sponsers=false;
for($k=1;$k<=8;$k++)
{
	if($row_eventRs['sponsor_logo'.$k]!='')
	{
		$sponsers=true;
	}
}
if($sponsers){
?>
          <div class="client_logos">
            <h3 style="border-bottom: 1px dashed #ccc;padding: 0 0 10px;margin: 0 0 20px;">Event Sponsors</h3>
            <ul>
              <?php 
$t=1;
for($k=1;$k<=8;$k++)
{
	if($row_eventRs['sponsor_logo'.$k]!='')
	{
?>
              <li><img src="data/<?php echo $row_eventRs['sponsor_logo'.$k];?>" /></li>
              <?php } ?>
              <?php 
if($t==4)
echo '</ul><ul>';
$t++;
?>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>
          <div class="promotor" style="border-top: 1px solid #ccc;padding: 40px 0 0;">
            <div style=" float:left; width:48%;">
              <h3 style="border-bottom: 1px dashed #ccc;padding: 0 0 10px;margin: 0 0 20px;">Promoter: </h3>
              <div class="info">
                <label>Name:</label>
                <p><?php echo $row_eventRs['name']; ?></p>
              </div>
              <div class="info">
                <label>Phone:</label>
                <p><?php echo $row_eventRs['phone']; ?></p>
              </div>
              <div class="info">
                <label>Email:</label>
                <p> <a href="mailto:<?php echo $row_eventRs['email']; ?>" class="infopage"><?php echo $row_eventRs['email']; ?></a> </p>
              </div>
              <div class="info">
                <label>Website:</label>
                <p>
                  <?php
$url = $row_eventRs['website'];
$urlhttp = substr($url, 0, 7);
if($urlhttp!="http://"){
$url = "http://".$url;
}
?>
                  <a href="<?php echo $url; ?>" class="infopage" target="_blank"><?php echo $row_eventRs['website']; ?></a> </p>
              </div>
            </div>
            <div style="float: right;width: 44%;padding: 0 0 0 20px;border-left: 1px solid #ccc;">
              <h3 style="border-bottom: 1px dashed #ccc;padding: 0 0 10px;margin: 0 0 20px;">Other Info</h3>
              <div class="info">
                <label>Dress:</label>
                <p><?php echo $row_eventRs['dress']; ?></p>
              </div>
              <div class="info">
                <label>Age Limit: </label>
                <p> <?php echo $row_eventRs['age_limit']; ?> </p>
              </div>
              <div class="info">
                <label>Event Start:</label>
                <p><?php echo $row_eventRs['session_hour']; ?></p>
              </div>
              <div class="info">
                <label>Doors Open: </label>
                <p><?php echo $row_eventRs['doors_open']; ?></p>
              </div>
              <div class="info">
                <label>Restaurants:</label>
                <p><?php echo $row_eventRs['restaurant']; ?></p>
              </div>
              <div class="info">
                <label>Restrooms: </label>
                <p><?php echo $row_eventRs['rest_room']; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="shows-box">
        <div class="deal-intro-map"><a name="map_view"></a>
          <iframe name="map_canvas" id="map" style="float:right;border-top-style: none; border-right-style: 0; border-bottom-style: 0; border-left-style: 0; border-width: 0px; padding: 0px; margin: 0px; position:relative; overflow: hidden; line-height: 360px; width: 60%; height: 260px;" scrolling="no" src="getloc.php?location=<?php echo $city_name;?>&venue=<?php echo $row_eventRs['venue'];?>"><?php echo "Your Browser does not support inline frames or is currently configured not to display inline frames";
?> </iframe>
          <div style="float:left;">
            <h3 style="border-bottom: 1px dashed #ccc;
padding: 0 0 10px;
margin: 0 0 20px;">Event Location</h3>
            <p style='padding-left:10px;font-size:12px;cursor:pointer;color:#000'><?php echo $row_eventRs['venue'];?></p>
            <p style='padding-left:10px;font-size:12px;cursor:pointer;color:#000'><?php echo $city_name;?></p>
            <p style='padding-left:10px;font-size:12px;cursor:pointer;color:#000'>Phone: <?php echo $promoters['phone'];?></p>
            <p style='padding-left:10px;font-size:12px;cursor:pointer;color:#000'>Phone: <?php echo $promoters['website'];?></p>
          </div>
          <?php if($row_eventRs['loc_map']){?>
          <div class="locaton-map-img" style="float: right; display: block; margin-top: 16px;"> <img src="data/<?php echo trim($row_eventRs['loc_map']);?>" style="max-width:645px"/> </div>
          <?php }?>
        </div>
      </div>
      <?php if($row_eventRs['floorplan']){?>
      <div class="shows-box">
        <h3 style="border-bottom: 1px dashed #ccc;
padding: 0 0 10px;
margin: 0 0 20px;">Floor Plan</h3>
        <img src="data/<?php echo trim($row_eventRs['floorplan']);?>" style="max-width:645px"/> </div>
      <?php }?>
      <?php if($row_eventRs['audioName'] || $row_eventRs['videoName']){?>
      <div class="shows-box">
        <h3 style="border-bottom: 1px dashed #ccc;
padding: 0 0 10px;
margin: 0 0 20px;">Watch / Listen</h3>
        <?php } ?>
        <?php if($row_eventRs['videoName']){?>
        <iframe src="playVideo.php?fileName=eventVideo/<?php echo $row_eventRs['videoName'];?>&from=video&ispopup=no" width="640px" height="400px" scrolling="no"></iframe>
        <div class="divider"></div>
        <?php }?>
        <?php if($row_eventRs['audioName']){?>
        <audio controls style="width:100%">
          <source src="eventAudio/<?php echo $row_eventRs['audioName'];?>" type="audio/mpeg">
          Your browser does not support the audio element. </audio>
        <div class="divider"></div>
        <!--<iframe src="playVideo.php?fileName=eventAudio/<?php echo $row_eventRs['audioName'];?>&from=audio&ispopup=no" width="640px" height="70px" scrolling="no"></iframe>--> 
      </div>
      <?php }?>
    </div>
  </div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>
