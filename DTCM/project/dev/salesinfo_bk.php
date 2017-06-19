<?php require_once('Connections/eventscon.php'); ?>
<?php
$colname_salesRs = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_salesRs = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}

mysql_select_db($database_eventscon, $eventscon);
$query_events = sprintf("SELECT tid, title, dtcm, commission FROM events WHERE promoter = %s ORDER BY title ASC", $_SESSION['MM_UserId']);
//echo $query_events."<br>";
$events = mysql_query($query_events, $eventscon) or die(mysql_error());
$row_events = mysql_fetch_assoc($events);
$totalRows_events = mysql_num_rows($events);
//print_r($row_events);exit;

?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>



<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td height="30" bgcolor="#CCCCCC"><span class="eventHeader">Welcome <? echo $_SESSION['MM_Username']; ?>,</span></td>
  </tr>

</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <?php $a = 0; ?>
  <?php do { ?>
  <?php $tsold=0; $totsales=0; ?>
  <?php if($a==1) { $trbgcolor=" bgcolor='#101010'"; $a--;} else { $trbgcolor=""; $a++;}  ?>
  <?php $commissionDtcmAdd = $row_events['commission']+$row_events['dtcm']; ?> 
    <tr<?php echo $trbgcolor; ?>>
      <td width="150" valign="top" bgcolor="#CCCCCC" class="eventHeader"><?php echo $row_events['title']; ?></td>
      <td>
        <table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid;border-width: 1px 5px 10px 20px solid;border-color:#CCCCCC">
<?php 
$query_priceRs = "SELECT price, tickets, stand FROM event_prices WHERE tid = '".$row_events['tid']."' order by price desc";
//echo $query_priceRs;
$priceRs = mysql_query($query_priceRs, $eventscon) or die(mysql_error());
$row_priceRs = mysql_fetch_assoc($priceRs);
//print_r($row_priceRs);
$totalRows_priceRs = mysql_num_rows($priceRs);

// FOR GENDER PIE DIAGRAM
$datas = array();
$query_gender = sprintf("SELECT customers.gender, COUNT(DISTINCT ticket_orders.cust_id) AS genderCount FROM customers 
INNER JOIN ticket_orders ON customers.cust_id = ticket_orders.cust_id 
where ticket_orders.payment_status='paid' and ticket_orders.tid = %s 
GROUP BY customers.gender ", $row_events['tid']);
//echo $query_gender;
$genderExe = mysql_query($query_gender, $eventscon) or die(mysql_error());
//$row_gender = mysql_fetch_assoc($genderExe);
$data =array();
while ($row = mysql_fetch_assoc($genderExe)) {
     //$dataRows[] = $row;
     $intialData = array('Female Buyers', 'Male Buyers');
     $dataRows = array($row['gender'], (int)$row['genderCount']);
     array_push($data,$intialData,$dataRows);
     unset($data[2]);
     
     
  }
//print_r($data);
//echo $dataRows['']
if(!empty($data))
{
  foreach($data as $key => $genders)
  {
	$dataLikes[] = $genders;
  }
}
else {
   $dataLikes = array();
}

$gender_data =  json_encode($dataLikes);

if($gender_data=='null')
{
	$gender_data = '';
}
else
{
	$gender_data =  substr(json_encode($dataLikes),1,-1);
}
echo $gender_data;
//echo $gender_data.'_'.$row_events['tid'] ;
//echo $gender_data =  substr(json_encode($dataLikes),1,-1);
//print_r($row_gender);

//FOR AGES PIE  DIAGRAM
$getCustIds = "SELECT GROUP_CONCAT(cust_id) as ids FROM `ticket_orders` WHERE `payment_status` = 'paid' and tid = '".$row_events['tid']."'";
$execustIds = mysql_query($getCustIds, $eventscon) or die(mysql_error());
$dataIds = mysql_fetch_assoc($execustIds);
//echo $dataIds['ids'];
if(!empty($dataIds))
{
    $expIds = array_unique(explode(',',$dataIds['ids']));	
	$implodeids = implode("','",$expIds);
}
else {
	$implodeids = '';
}

//print_r($dataIds);
if(!empty($implodeids))
{
$query_priceRs_1 = "SELECT COUNT(cust_id) as firstCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=15 AND age<=25";
$query_priceRs_2 = "SELECT COUNT(cust_id) as secondCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=26 AND age<=35";
$query_priceRs_3 = "SELECT COUNT(cust_id) as thirdCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=36 AND age<=45";
$query_priceRs_4 = "SELECT COUNT(cust_id) as fourthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=46 AND age<=55";
$query_priceRs_5 = "SELECT COUNT(cust_id) as fifthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=56 AND age<=65";
$query_priceRs_6 = "SELECT COUNT(cust_id) as sixthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=66 AND age<=75";
$query_priceRs_7 = "SELECT COUNT(cust_id) as seventhCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=76 AND age<=85";
//echo $query_priceRs_4;
$priceRs_1 = mysql_query($query_priceRs_1, $eventscon) or die(mysql_error());
$priceRs_2 = mysql_query($query_priceRs_2, $eventscon) or die(mysql_error());
$priceRs_3 = mysql_query($query_priceRs_3, $eventscon) or die(mysql_error());
$priceRs_4 = mysql_query($query_priceRs_4, $eventscon) or die(mysql_error());
$priceRs_5 = mysql_query($query_priceRs_5, $eventscon) or die(mysql_error());
$priceRs_6 = mysql_query($query_priceRs_6, $eventscon) or die(mysql_error());
$priceRs_7 = mysql_query($query_priceRs_7, $eventscon) or die(mysql_error());

$ageRange_1 = mysql_fetch_assoc($priceRs_1);
$ageRange_2 = mysql_fetch_assoc($priceRs_2);
$ageRange_3 = mysql_fetch_assoc($priceRs_3);
$ageRange_4 = mysql_fetch_assoc($priceRs_4);
$ageRange_5 = mysql_fetch_assoc($priceRs_5);
$ageRange_6 = mysql_fetch_assoc($priceRs_6);
$ageRange_7 = mysql_fetch_assoc($priceRs_7);
//print_r($ageRange_4);
//echo $ageRange_4['fourthCount'];
//print_r($ageRange_5);
//$totalRows_priceRs = mysql_num_rows($priceRs);
if(!empty($ageRange_1) || !empty($ageRange_2) || !empty($ageRange_3) || !empty($ageRange_4) || !empty($ageRange_5) || !empty($ageRange_6) || !empty($ageRange_7))
{
$ageData = array();
$ageOne = array('15-25', (int)$ageRange_1['firstCount']);
$ageTwo = array('26-35', (int)$ageRange_2['secondCount']);
$ageThree = array('36-45', (int)$ageRange_3['thirdCount']);
$ageFour = array('46-55', (int)$ageRange_4['fourthCount']);
$ageFive = array('56-65', (int)$ageRange_5['fifthCount']);
$ageSix = array('66-75', (int)$ageRange_6['sixthCount']);
$ageSeven = array('76-85', (int)$ageRange_7['seventhCount']);
array_push($ageData,$ageOne,$ageTwo,$ageThree,$ageFour,$ageFive,$ageSix,$ageSeven);
if(!empty($ageData)){ $ageDataPieDiagram = substr(json_encode($ageData),1,-1); } else { $ageDataPieDiagram = array(); }
}
else {
	$ageDataPieDiagram = array();
}
//print_r($ageData);
//echo $ageDataPieDiagram;
}
?>
      <tr>
      	<td height="20" bgcolor="#E8E8E8" class="style1">Ticket Type </td>
        <td height="20" bgcolor="#E8E8E8" class="style1">Ticket Prices </td>
        <td height="20" bgcolor="#E8E8E8"><span class="style1">Total Tickets</span></td>
        <td height="20" bgcolor="#E8E8E8" class="style1">Tickets sold </td>
        <!--<td height="20" bgcolor="#E8E8E8" class="style1">Commission Charges  </td>
        <td height="20" bgcolor="#E8E8E8" class="style1">DTCM Charges </td>-->
        <td height="20" bgcolor="#E8E8E8" class="style1">Total Amount </td>
      </tr>
  <?php while ($row_priceRs = mysql_fetch_assoc($priceRs)) { ?>
      <tr>
      <td height="20" bgcolor="#E8E8E8" class="style1"></td>	
      <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_priceRs['price']; ?></td>
      <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_priceRs['tickets']; ?></td>
<?php 
$query_salesRs = sprintf("SELECT count(tickets) ticketsold FROM ticket_orders WHERE tid=%s and ticket_price=%s ", $row_events['tid'],$row_priceRs['price']);
//echo $query_salesRs;
$salesRs = mysql_query($query_salesRs, $eventscon) or die(mysql_error());
$row_salesRs = mysql_fetch_assoc($salesRs);
$totalRows_salesRs = mysql_num_rows($salesRs);


?>
    <td height="20" bgcolor="#E8E8E8" class="style1"><?php echo $row_salesRs['ticketsold']; $tsold += $row_salesRs['ticketsold']; ?></td>
    <!--<td width="20" bgcolor="#E9E9E9"><?php echo $row_events['commission']; ?></td>
    <td width="20" bgcolor="#E9E9E9"><?php echo $row_events['dtcm'];  ?></td>-->
    <td height="20" bgcolor="#E8E8E8" class="style1"><?php if(!empty($row_salesRs['ticketsold'])){ echo ($row_salesRs['ticketsold']*$row_priceRs['price']);} else { echo $row_salesRs['ticketsold']*$row_priceRs['price']; } $totsales +=$row_salesRs['ticketsold']*$row_priceRs['price']; ?></td>
    </tr>
    <?php } ?>
</table></td>
    </tr>
    <?php echo $commissionDtcmAdd; ?> 
    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Total</div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          <td width="25%" bgcolor="#CCCCCC" class="style1"><?php echo $tsold; ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1"><?php echo $totsales; ?></td>
        </tr>
      </table></td>
    </tr>
    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Commission</div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="50%"  class="style1"><?php echo $row_events['commission']; ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1">DTCM Tax</td>
          <td width="25%" class="style1"><?php echo $row_events['dtcm']; ?></td>
          
        </tr>
      </table></td>
    </tr>
    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Service Charge</div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="50%"  class="style1"><?php echo ''; ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1">C.C Charge</td>
          <td width="25%" class="style1"><?php echo ''; ?></td>
        </tr>
      </table></td>
    </tr>

    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Amount Due To Promoter</div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><?php echo ''; ?></td>
        </tr>
      </table></td>
    </tr>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        
        
        var data = google.visualization.arrayToDataTable([
          <?php //echo $gender_data; ?>
          ['Male Buyers', 'Female Buyers'],
          ['Male Buyers',     11],
          ['Female Buyers',     11],
                    
        ]);
        
        
        var options = {
          title: 'Gender'
        };
        
        var ageoptions = {
          title: 'Age brackets'
        };
        
        var dataAge = google.visualization.arrayToDataTable([
          <?php echo $ageDataPieDiagram; ?>
          
        ]);
        
        var linedata = google.visualization.arrayToDataTable([
          ['Year', 'Sales'],
          ['2004',  1000],
          ['2005',  1170,],
          ['2006',  660,],
          ['2007',  1030,],
        ]);
         var lineoptions = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
        
        var bardata = google.visualization.arrayToDataTable([
        ['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General',
         'Western', 'Literature', { role: 'annotation' } ],
        ['2010', 10, 24, 20, 32, 18, 5, ''],
        ['2020', 16, 22, 23, 30, 16, 9, ''],
        ['2030', 28, 19, 29, 30, 12, 13, '']
      ]);

      var baroptions = {
        width: 500,
        height: 250,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
      };

        
        
        var chart = new google.visualization.PieChart(document.getElementById('gender_<?php echo $row_events['tid']; ?>'));
        var chartAge = new google.visualization.PieChart(document.getElementById('age_<?php echo $row_events['tid']; ?>'));
        
        var linechart = new google.visualization.LineChart(document.getElementById('line_chart_<?php echo $row_events['tid']; ?>'));
        var barchart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_<?php echo $row_events['tid']; ?>"));
        
        
        
        
        chart.draw(data, options);
        chartAge.draw(dataAge, ageoptions);
        linechart.draw(linedata, lineoptions);
        barchart.draw(bardata, baroptions);
        }
    </script>   
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="gender_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="age_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="line_chart_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="columnchart_values_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    <?php } while ($row_events = mysql_fetch_assoc($events)); ?>
</table>
  <?php

//mysql_free_result($salesRs);

//mysql_free_result($priceRs);

//mysql_free_result($events);
?>