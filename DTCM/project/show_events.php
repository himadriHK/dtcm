<?php
@session_start();
include("config.php"); ?>
<?php
require_once('dateclass.php');
$objDate =  new CDate();
mysql_select_db($database_eventscon, $eventscon);
$query_string='';
if($category_details){
$cat_id=$category_details['id'];
$query_string=" AND category='$cat_id'";
}
//ADDED BY KRANTHI ON 09-05-2015
$pageSelected = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if(strpos($pageSelected, 'out_and_about.php'))
{
    if (!$_SESSION['PP_UserId']){
        $query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".OUTANDABOUT."' AND city='{$default_city_id}' AND date_end>='".date('Y-m-d')."'  $query_string ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()
    } else {
        $query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".OUTANDABOUT."' AND city='{$default_city_id}' AND partner='{$_SESSION['PP_UserId']}' AND date_end>='".date('Y-m-d')."'  $query_string ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()
    }

}
else if(strpos($pageSelected, 'ongoing_events.php'))
{
    if (!@$_SESSION['PP_UserId']){
        $query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".ONGOING."' AND city='{$default_city_id}' AND date_end>='".date('Y-m-d')."'  $query_string ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()
    } else {
        $query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".ONGOING."' AND city='{$default_city_id}' AND partner='{$_SESSION['PP_UserId']}' AND date_end>='".date('Y-m-d')."'  $query_string ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()
    }

}
//ADDED BY  KRANTHI ENDS
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
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
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
$split_date=explode("-",$row_eventRs['date_end']);
$yr 		= 	$split_date[0];
$mm 		= 	$split_date[1];
$dd 		= 	$split_date[2];
// Separate time
//print_r($tt);
$hr 		= 	'23';
$min 		= 	'59';
$sec 		= 	'59';
?>
<tr>
<td colspan="5" style="height:22px;" class="dot_line">&nbsp;</td>
</tr>
<tr>
<?php
if($topcount%2==1){ ?>
<td style="background:none repeat scroll 0 0 #EEEEEE;"><?php }else{ ?>
<td style="background:none repeat scroll 0 0 #FFFFFF;"><?php } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="300" valign="top" style="position:relative;">
<?php if(!strpos($pageSelected, 'out_and_about.php')){ ?><a href="#" class="date" style="right:6px; top:-1px;"><?php echo date('d/m/Y',strtotime($row_eventRs['date_end']));?> </a><?php } ?><img src="data/<?php echo $row_eventRs['pic']; ?>" width="300" height="200" style="height:200px !important;" /></td>


<td width="20" valign="top"></td>
<td valign="top"><?php
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
<?php  if(!strpos($pageSelected, 'out_and_about.php')){ ?>
<?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_end'])/*." ".eventSecondDate($row_eventRs['date_end'])*/;} else { ?>
<?php echo 'Date Start :'.$objDate->getdate_da_mo_year($row_eventRs['date_start'])."<br>Date End :".$objDate->getdate_da_mo_year($row_eventRs['date_start']); ?>
<?php } } }?>
<br />

<?php
if($videoName!="")
{
?>
<!--<a href="#" onClick="openVideoPlayer('<?php //echo $videoName; ?>');"><img src="images/Play-icon.png" border="0" title="View Video" /></a>&nbsp;&nbsp;-->
<?php
}
?>
<?php
if($audioName!="")
{
?>
<!--<a href="#" onClick="openAudioPlayer('<?php //echo $audioName; ?>');"><img src="images/headset-icon.png" border="0" title="Listen Audio" /></a><br/>-->
<?php
}
?>

<?php
// FOR OUT_AND_ABOUT.PHP, the timer will not be viewed.
// CHANGES DONE BY Kranthi  09-05-2015
if(!strpos($pageSelected, 'out_and_about.php'))
{
?>
<div class='innerdate'> <span style="float:left; width:50px; margin:0 20px 0 0;"> <img src="img/bomber.png"></span><span style=" float:left;"> <span style="margin: 0 0 10px;
color: #000;
display: block;
font-weight: bold;
font-size: 13px;"> Event Starts in</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr  id="tot_<?php echo $row_eventRs['tid'];?>" class="tdbg">
<script type="text/javascript" language="javascript">	
callMeFirst('<?php echo $yr; ?>','<?php echo $mm; ?>','<?php echo $dd; ?>','<?php echo $hr; ?>','<?php echo $min; ?>','<?php echo $sec; ?>','<?php echo $row_eventRs['tid'];?>');			
</script>
</tr>
<tr style="color:#000;">
<td><div align="center">Days</div></td>
<td><div align="center">Hrs</div></td>
<td><div align="center">Min</div></td>
<td><div align="center">Sec</div></td>
</tr>
</table></span>
</div>
<?php }
// CHANGES ENDS
 ?>
<a href="events_details.php?eid=<?php echo $row_eventRs['tid']; ?>" class="moreinfo" style="float:right; color:#fff; font-weight:normal; margin:0 0 10px;">More Info</a> <br />
<div style="float:left; width:100%;"> <?php if($ticket_available == "true"){?>
<?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?>
<a href="events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>" class="buybnt" style="float:right; color:#fff;">BUY NOW</a>
<?php } else {echo "<span class='buybnt' style='float: right;width: 72px;'>Coming Soon</span>";?>
<?php }?>
<?php } else echo "<span class='buybnt' style='float: right;width: 72px;'>SOLD</span>";?></div>
</td>
</tr>
</table></td>
</tr>
<?php
$topcount++;	
$count++;
} while ($row_eventRs = mysql_fetch_assoc($eventRs)); } ?>
</table>



          <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
              <td valign="top" align="left"><script type="text/JavaScript">
&lt;!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
window.open(theURL,winName,features);
}
//--&gt;
</script>
<link type="text/css" rel="stylesheet" href="events.css">
<link type="text/css" rel="stylesheet" href="css/TM_style.css">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody><tr>
<td class="dot_line" style="height:22px;" colspan="5">&nbsp;</td>
</tr>
<tr>
<td style="background:none repeat scroll 0 0 #EEEEEE;"><table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody><tr>
<td width="300" valign="top" style="position:relative;">
<a style="right:6px; top:-1px;" class="date" href="#">22/09/2016 </a><img width="300" height="200" style="height:200px !important;" src="data/lara3.jpg"></td>


<td width="20" valign="top"></td>
<td valign="top"><b>Test Event for Dubai Tourism</b><br>
Location: Event Lab Arena<br>
Ongoing<br>


<div class="innerdate"> <span style="float:left; width:50px; margin:0 20px 0 0;"> <img src="img/bomber.png"></span><span style=" float:left;"> <span style="margin: 0 0 10px;
color: #000;
display: block;
font-weight: bold;
font-size: 13px;"> Event Starts in</span>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody><tr class="tdbg" id="tot_163"><td><div align="center">54</div></td>    <td><div align="center">15</div></td>    <td><div align="center">15</div></td>    <td><div align="center">19</div></td></tr>
<tr style="color:#000;">
<td><div align="center">Days</div></td>
<td><div align="center">Hrs</div></td>
<td><div align="center">Min</div></td>
<td><div align="center">Sec</div></td>
</tr>
</tbody></table></span>
</div>
<a style="float:right; color:#fff; font-weight:normal; margin:0 0 10px;" class="moreinfo" href="events_details.php?eid=161">More Info</a> <br>
<div style="float:left; width:100%;"> <a style="float:right; color:#fff;" class="buybnt" href="events_buy.php?eid=161">BUY NOW</a>
</div>
</td>
</tr>
</tbody></table></td>
</tr>
</tbody></table>
</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </tbody></table>
        
<?php
mysql_free_result($eventRs);
?>