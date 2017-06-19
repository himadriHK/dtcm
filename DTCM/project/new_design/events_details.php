<?php require_once('Connections/eventscon.php'); ?>
<?php include("config.php"); ?>
<?php

$eventid = $_GET['eid'];

$eventid = "-1";

if (isset($_GET['eid'])) {

  $eventid = (get_magic_quotes_gpc()) ? $_GET['eid'] : addslashes($_GET['eid']);

}



mysql_select_db($database_eventscon, $eventscon);

$query_eventRs = sprintf("SELECT events.*, promoters.name, promoters.phone, promoters.email, promoters.website FROM events, promoters WHERE events.tid=%s and events.promoter = promoters.spid  ORDER BY hot DESC", $eventid);

$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);

$totalRows_eventRs = mysql_num_rows($eventRs);



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



function gettickets($eventid){

$ticketid_ticketsRs = $eventid;

//echo $ticketid_ticketsRs;

$query_ticketsRs = sprintf("SELECT event_prices.price, event_prices.cprice, event_prices.pid, event_prices.currency, event_prices.stand, event_prices.tickets, event_prices.ctickets FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price desc", $ticketid_ticketsRs);

//echo $query_ticketsRs;

$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());

$row_ticketsRs = mysql_fetch_assoc($ticketsRs);

$totalRows_ticketsRs = mysql_num_rows($ticketsRs);



echo "<table width='100%' border=0 cellpadding=\"1\" cellspacing=\"1\">";

do { 

 echo "<tr bgcolor=''><td>".$row_ticketsRs['stand']."</td><td align='right'>Adult:</td><td> ".$row_ticketsRs['currency'].". ".$row_ticketsRs['price']."</td><td align='right'>Child: </td><td>".$row_ticketsRs['currency'].". ".$row_ticketsRs['cprice']."</td></tr>";

} while ($row_ticketsRs = mysql_fetch_assoc($ticketsRs)); 

echo "</table>";

mysql_free_result($ticketsRs);

}
$query_guidecatRs = "SELECT * FROM `banners`";

$guidecatRs = mysql_query($query_guidecatRs, $eventscon) or die(mysql_error());
$images = mysql_fetch_array($guidecatRs);
?>

<?php include("functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $row_eventRs['title']; ?></title>

<link href="events.css" rel="stylesheet" type="text/css" />

<script type="text/JavaScript">

<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0

  window.open(theURL,winName,features);

}

//-->

</script>

<style type="text/css">

<!--

.infopage {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 14px;

	color: #555555;

}

.infoheading {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 14px;

	color: #FFFFFF;

	font-weight: bold;

}

.style3 {color: #990000; font-weight: bold; }

-->

</style>

</head>

<body>


<div style="background:url(data/<?php echo $row_eventRs['popup_pic']; ?>)  no-repeat scroll center -252px #08090D; position:fixed; width:100%; height:100%; z-index:-1; top:0; left:0;"></div>
<div style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.95);border-radius: 10px 10px 10px 10px;margin: 0 auto;padding: 5px;width: 38%; box-shadow:0 0 10px #888888;">
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">

  <tr style="   background: none repeat scroll 0 0 #F1F1F1;box-shadow: 0 0 5px #CCCCCC inset;color: #006699; font: 18px arial;  text-align: center; ">

    <td height="35"><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="15"></td>

          <td class="eventHeader"><?php echo $row_eventRs['title']; ?></td>

        </tr>

      </table></td>

  </tr>

  <tr>

    <td><table width="500" border="0" align="center" cellpadding="0" cellspacing="0">

        <tr>

          

          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="5">

                    <tr valign="top" class="eventVenue">

                      <td colspan="2" class="eventVenue"><div align="center"><img style="width:470px;" src="data/<?php echo $row_eventRs['pic']; ?>" /></div></td>

                    </tr>

                    <tr>

                      <td height="30" colspan="2" style=" background: none repeat scroll 0 0 rgba(255, 0, 0, 0.2);
    box-shadow: 0 0 5px inset;
    color: #B94444;
    font: 20px arial;
    text-align: center;
    text-shadow: 0 0 5px #EB6C6C;"><?php if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";}#added on dec 24
else if($row_eventRs['ongoing']==GUEST)
{
	#guest events
	echo "Guest";
}
 else { ?>

                        <span class="infoheading"><?php echo eventFirstDate($row_eventRs['date_start']); ?></span>

                        <?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo " to ".eventFirstDate($row_eventRs['date_end']);} ?>

                        <?php echo " ".eventSecondDate($row_eventRs['date_start']); ?>

                        <?php }?></td>

                    </tr>

                    <tr  style=" background:rgba(0,0,0,0.03);">

                      <td valign="top" bgcolor="" class="infopage">Location:</td>

                      <td valign="top" bgcolor="" class="eventText"><span class="infopage"><?php echo $row_eventRs['venue']; ?></span></td>

                    </tr>

                    <tr>

                      <td valign="top" bgcolor="" class="infopage">Descriptions:</td>

                      <td valign="top" bgcolor="" class="eventText"><span class="infopage"><?php echo $row_eventRs['desc']; ?></span></td>

                    </tr>

                    <?php if ($row_eventRs['loc_map']!=""){ ?>

                    <tr   style=" background:rgba(0,0,0,0.03);">

                      <td valign="top" bgcolor="" class="infopage">Location:</td>

                      <td valign="top" bgcolor="" class="eventText"><a href="javascript:" class="infopage" onclick="MM_openBrWindow('data/<?php echo $row_eventRs['loc_map']; ?>','floorplan','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=600,height=500')">Click here for <span class="style3">location Map</span></a></td>

                    </tr>

                    <?php } ?>

                    <?php if($row_eventRs['floorplan']!=""){ ?>

                    <tr  >

                      <td valign="top" bgcolor="" class="infopage">Floor plan: </td>

                      <td valign="top" bgcolor="" class="eventText"><a href="javascript:" class="infopage" onclick="MM_openBrWindow('data/<?php echo $row_eventRs['floorplan']; ?>','floorplan','toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=600,height=500')">Click here for <span class="style3">floor plan</span></a></td>

                    </tr>

                    <?php } ?>

                    <tr   style=" background:rgba(0,0,0,0.03);">

                      <td width="100" valign="top" bgcolor="" class="infopage">Promoter: </td>

                      <td valign="top" bgcolor="" class="infopage"><table width="100%" border="0" cellspacing="1" cellpadding="0">

                          <tr>

                            <td width="80" bgcolor="">Name:</td>

                            <td bgcolor=""><?php echo $row_eventRs['name']; ?></td>

                          </tr>

                          <tr>

                            <td bgcolor="">Phone:</td>

                            <td bgcolor=""><?php echo $row_eventRs['phone']; ?></td>

                          </tr>

                          <tr>

                            <td bgcolor="">Email:</td>

                            <td bgcolor=""><a href="mailto:<?php echo $row_eventRs['email']; ?>" class="infopage"><?php echo $row_eventRs['email']; ?></a></td>

                          </tr>

                          <tr>

                            <td bgcolor="">Website:</td>

                            <td bgcolor=""><?php

						$url = $row_eventRs['website'];

						$urlhttp = substr($url, 0, 7);

						if($urlhttp!="http://"){

							$url = "http://".$url;

						}

						?>

                            <a href="<?php echo $url; ?>" class="infopage" target="_blank"><?php echo $row_eventRs['website']; ?></a></td>

                          </tr>

                        </table></td>

                    </tr>

                    <tr>

                      <td width="100" valign="top" bgcolor="" class="infopage">Dress: </td>

                      <td valign="top" bgcolor="" class="infopage"><?php echo $row_eventRs['dress']; ?></td>

                    </tr>

                    <tr   style=" background:rgba(0,0,0,0.03);">

                      <td width="100" valign="top" bgcolor="" class="infopage">Age Limit: </td>

                      <td valign="top" bgcolor="" class="infopage"><?php echo $row_eventRs['age_limit']; ?></td>

                    </tr>

                    <tr>

                      <td width="100" valign="top" bgcolor="" class="infopage">Tickets: <br /></td>

                      <td valign="top" bgcolor="" class="eventText"><?php gettickets($row_eventRs['tid']); ?></td>

                    </tr>

                    <tr   style=" background:rgba(0,0,0,0.03);">

                      <td width="100" valign="top" bgcolor="" class="infopage">Event Start: </td>

                      <td valign="top" bgcolor="" class="infopage"><?php echo $row_eventRs['session_hour']; ?></td>

                    </tr>

                    <tr>

                      <td width="100" valign="top" bgcolor="" class="infopage">Doors Open: </td>

                      <td valign="top" bgcolor="" class="infopage"><?php echo $row_eventRs['doors_open']; ?></td>

                    </tr>

                    <tr   style=" background:rgba(0,0,0,0.03);">

                      <td width="100" valign="top" bgcolor="" class="infopage">Restaurants: </td>

                      <td valign="top" bgcolor="" class="infopage"><?php echo $row_eventRs['restaurant']; ?></td>

                    </tr>

                    <tr>

                      <td width="100" valign="top" bgcolor="" class="infopage">Restrooms: </td>

                      <td valign="top" bgcolor="" class="infopage"><?php echo $row_eventRs['rest_room']; ?></td>

                    </tr>

                    <tr  >

                      <td valign="top"class="infopage">&nbsp;</td>

                      <td valign="top" class="infopage"><?php if($ticket_available == "true"){?><?php $today = date("Y-m-d"); if($today >= $row_eventRs['sale_date']){?><a href="events_buy.php?eid=<?php echo $row_eventRs['tid']; ?>" style="background: none repeat scroll 0 0 #333333;border-radius: 5px 5px 5px 5px;color: #FFFFFF;margin-left: 93px;padding: 7px 15px;text-decoration: none;}">Buy Now</a><?php } else echo "Coming Soon";?><?php } else {echo "Sold";}?></td>

                    </tr>

                </table></td>

              </tr>

              <tr>

                <td valign="top">&nbsp;</td>

              </tr>

            </table></td>

          

        </tr>

        

      </table></td>

  </tr>

</table>
</div>
<?php

mysql_free_result($eventRs);

?>
<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>

<script type="text/javascript">

try {

var pageTracker = _gat._getTracker("UA-11947961-2");

pageTracker._trackPageview();

} catch(err) {}</script>
</body>

</html>

