<?php 
/*error_reporting(0);
ini_set('display_errors', 1);*/
?>
<?php require_once('../Connections/eventscon.php'); ?>
<?php
$colname_salesRs = "-1";
if (isset($_SESSION['MM_UserId'])) {
  $colname_salesRs = (get_magic_quotes_gpc()) ? $_SESSION['MM_UserId'] : addslashes($_SESSION['MM_UserId']);
}
//echo $_SESSION['MM_UserId'];exit;
mysql_select_db($database_eventscon, $eventscon);
//$query_events = sprintf("SELECT tid, title, dtcm, commission FROM events WHERE promoter = %s ORDER BY title ASC", $_SESSION['MM_UserId']);
//$query_events = "SELECT tid, title, dtcm, commission FROM events WHERE promoter = '".$_SESSION['MM_UserId']."' ORDER BY title ASC";
$query_events = "SELECT tid, title, dtcm,credit_charge,service_charge, commission FROM events ORDER BY title ASC";
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
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
      	function generatePdf()
      	{
      		window.location="http://www.tktrush.com/admin/salesInfoadminPdf.php";
      	}
</script>
<!--<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td height="30" bgcolor="#CCCCCC"><span class="eventHeader">Welcome <? echo $_SESSION['MM_Username']; ?>,</span></td>
  </tr>

</table>-->

<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <?php $a = 0; ?>
  <?php do { ?>
  <?php $tsold=0; $totsales=0; ?>
  <?php if($a==1) { $trbgcolor=" bgcolor='#101010'"; $a--;} else { $trbgcolor=""; $a++;}  ?>
  <?php //$commissionDtcmAdd = $row_events['commission']+$row_events['dtcm']; ?> 
  <tr><td style="height:10px;" colspan="2"></td></tr>
   <tr><td background="../images/w-dot.gif" style="padding:0;" colspan="2"><img src="../images/w-dot.gif" width="3" height="1"></td></tr>
   <tr><td style="height:10px;" colspan="2"></td></tr>
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
$dataLikes = array();
$gender_data = '';
/*$query_gender = sprintf("SELECT customers.gender, COUNT(DISTINCT ticket_orders.cust_id) AS genderCount FROM customers 
INNER JOIN ticket_orders ON customers.cust_id = ticket_orders.cust_id 
where ticket_orders.payment_status='paid' and ticket_orders.tid = %s 
GROUP BY customers.gender ", $row_events['tid']);*/
$query_gender = "SELECT customers.gender, COUNT(DISTINCT ticket_orders.cust_id) AS genderCount FROM customers 
INNER JOIN ticket_orders ON customers.cust_id = ticket_orders.cust_id 
where ticket_orders.payment_status='paid' and ticket_orders.tid = '".$row_events['tid']."' 
GROUP BY customers.gender";
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
//print_r($dataRows);
//echo $dataRows['']
if(!empty($data))
{
  foreach($data as $key => $genders)
  {
	$dataLikes[] = $genders;
  }
}


//echo $gender_data =  json_encode($dataLikes);

/*if($gender_data=='null' || empty($gender_data))
{
	$gender_data = '';
}
else
{
	$gender_data =  substr(json_encode($dataLikes),1,-1);
}*/
//echo $gender_data;
//echo $gender_data.'_'.$row_events['tid'] ;
$gender_data =  substr(json_encode($dataLikes),1,-1);
//print_r($dataLikes);

//FOR AGES PIE  DIAGRAM
$ageDataPieDiagram = '';
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
//echo $implodeids;
//print_r($dataIds);
if(!empty($implodeids))
{
$query_priceRs_1 = "
SELECT COUNT(cust_id) as firstCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=15 AND age<=25
UNION ALL
SELECT COUNT(cust_id) as secondCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=26 AND age<=35
UNION ALL
SELECT COUNT(cust_id) as thirdCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=36 AND age<=45
UNION ALL
SELECT COUNT(cust_id) as fourthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=46 AND age<=55
UNION ALL
SELECT COUNT(cust_id) as fifthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=56 AND age<=65
UNION ALL
SELECT COUNT(cust_id) as sixthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=66 AND age<=75
UNION ALL
SELECT COUNT(cust_id) as seventhCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=76 AND age<=85
";
$keyArr = array('15-25','26-35','36-45','46-55','56-65','66-75','76-85');
$executeagebracketQuery = mysql_query($query_priceRs_1, $eventscon) or die(mysql_error());
/*$totalTicketsSoldArr = mysql_fetch_assoc($executeTotalTicketsSoldQuery);
print_r($totalTickticketSoldetsSoldArr);*/
$customeragebracketdata =array();
while ($ageBracketsRow= mysql_fetch_assoc($executeagebracketQuery)) {
     $b[] = $ageBracketsRow;
     ///$ticketDataHeading = array('Month', 'Tickets Sold');
     //$a = $keyArr;
     //$b = $ageBracketsRow;
     //$c = array_combine($a, $b);
     //$ticketdataRows = array($ticketSoldRow['month'], (int)$ticketSoldRow['total']);
     //array_push($ticketsSolddata,$ticketdataRows);
     //unset($ticketsSolddata[2]);
     
     
     
  }
  //print_r($executeagebracketQuery);
  if(!empty($b))
  {
  	foreach($b as $vals)
	{
		$arrAgeBrackets[] = $vals['firstCount'];
	}
  }
  
  $a = $keyArr;
  $bc = $arrAgeBrackets;
  $n = 7;
  $newArr = array_slice($bc, -$n);
  
  $c = array_combine($a, $newArr);
  //print_r($c);
 /* foreach($c as $keyss => $valss){
  	
	echo $keyss.' '.$valss.'<br>'; 
  }*/
  $ageData = array();
  if(!empty($newArr))
  {
  	foreach($c as $keys => $ageBracketVals)
	{
		$ageBracketCustomerRows = array($keys, (int)$ageBracketVals);
		array_push($ageData,$ageBracketCustomerRows);
		
	}
  }
  //print_r($ageData);
  $ageDataPieDiagram = substr(json_encode($ageData),1,-1);
  
//echo $query_priceRs_1;
/*$query_priceRs_2 = "SELECT COUNT(cust_id) as secondCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=26 AND age<=35";
$query_priceRs_3 = "SELECT COUNT(cust_id) as thirdCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=36 AND age<=45";
$query_priceRs_4 = "SELECT COUNT(cust_id) as fourthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=46 AND age<=55";
$query_priceRs_5 = "SELECT COUNT(cust_id) as fifthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=56 AND age<=65";
$query_priceRs_6 = "SELECT COUNT(cust_id) as sixthCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=66 AND age<=75";
$query_priceRs_7 = "SELECT COUNT(cust_id) as seventhCount FROM `customers` WHERE cust_id IN ('".$implodeids."') AND age>=76 AND age<=85";*/
//echo $query_priceRs_4;
/*$priceRs_1 = mysql_query($query_priceRs_1, $eventscon) or die(mysql_error());
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

	
$ageData = array();
$ageOne = array('15-25', (int)$ageRange_1['firstCount']);
$ageTwo = array('26-35', (int)$ageRange_2['secondCount']);
$ageThree = array('36-45', (int)$ageRange_3['thirdCount']);
$ageFour = array('46-55', (int)$ageRange_4['fourthCount']);
$ageFive = array('56-65', (int)$ageRange_5['fifthCount']);
$ageSix = array('66-75', (int)$ageRange_6['sixthCount']);
$ageSeven = array('76-85', (int)$ageRange_7['seventhCount']);
array_push($ageData,$ageOne,$ageTwo,$ageThree,$ageFour,$ageFive,$ageSix,$ageSeven);
$ageDataPieDiagram = substr(json_encode($ageData),1,-1);*/

}

//TOTAL TICKETS SOLD LINE GRAPH STARTS
$totalTicketsFinalArr = array();
$totalTicketsSoldLineDiagram = '';
$getTotalTicketsSoldMonthWise = "SELECT DATE_FORMAT(`order_date`, '%Y') as 'year',
DATE_FORMAT(`order_date`, '%b') as 'month',
COUNT(`tickets`) as 'total'
FROM ticket_orders WHERE payment_status = 'paid' AND tid = '".$row_events['tid']."'
GROUP BY DATE_FORMAT(`order_date`, '%Y%m')";
$executeTotalTicketsSoldQuery = mysql_query($getTotalTicketsSoldMonthWise, $eventscon) or die(mysql_error());
/*$totalTicketsSoldArr = mysql_fetch_assoc($executeTotalTicketsSoldQuery);
print_r($totalTicketsSoldArr);*/
$ticketsSolddata =array();
while ($ticketSoldRow = mysql_fetch_assoc($executeTotalTicketsSoldQuery)) {
     //$dataRows[] = $row;
     ///$ticketDataHeading = array('Month', 'Tickets Sold');
     $ticketdataRows = array($ticketSoldRow['month'], (int)$ticketSoldRow['total']);
     array_push($ticketsSolddata,$ticketdataRows);
     //unset($ticketsSolddata[2]);
     
     
  }
//print_r($ticketsSolddata);
/*foreach($ticketsSolddata as $valsss){
	echo $valsss[0].' '.$valsss['1'];
}*/
//echo $dataRows['']
if(!empty($ticketsSolddata))
{
  foreach($ticketsSolddata as $key => $ticketsSoldDataPerMonth)
  {
	$totalTicketsFinalArr[] = $ticketsSoldDataPerMonth;
  }
}
$totalTicketsSoldLineDiagram =  substr(json_encode($totalTicketsFinalArr),1,-1);


//LINE DIAGRAM USERS PURCHASED TICKETS FROM DIFFERENT COUNTRIES

$totalCustomersFromCountriesFinalArr = array();
$totalCustomersFromCountriesLineDiagram = '';
$queryCountryBarGraph = "SELECT customers.country, COUNT(ticket_orders.cust_id) AS customersCount FROM customers 
INNER JOIN ticket_orders ON customers.cust_id = ticket_orders.cust_id 
where ticket_orders.payment_status='paid' and ticket_orders.tid = '".$row_events['tid']."' 
GROUP BY customers.country ";
$executeTotalCustomersQuery = mysql_query($queryCountryBarGraph, $eventscon) or die(mysql_error());
/*$totalTicketsSoldArr = mysql_fetch_assoc($executeTotalTicketsSoldQuery);
print_r($totalTicketsSoldArr);*/
$countryCustomersdata =array();
while ($customersRow = mysql_fetch_assoc($executeTotalCustomersQuery)) {
     //$dataRows[] = $row;
     ///$ticketDataHeading = array('Month', 'Tickets Sold');
     $countryCustomersdataRows = array($customersRow['country'], (int)$customersRow['customersCount']);
     array_push($countryCustomersdata,$countryCustomersdataRows);
     //unset($ticketsSolddata[2]);
     
     
  }
//print_r($countryCustomersdata);
//echo $dataRows['']
if(!empty($countryCustomersdata))
{
  foreach($countryCustomersdata as $key => $customersDataFromCountries)
  {
	$totalCustomersFromCountriesFinalArr[] = $customersDataFromCountries;
  }
}
$totalCustomersFromCountriesLineDiagram =  substr(json_encode($totalCustomersFromCountriesFinalArr),1,-1);
?> 
      <tr>
      	<td bgcolor="#E8E8E8" class="style1">Ticket Type </td>
        <td  bgcolor="#E8E8E8" class="style1">Ticket Prices </td>
        <td bgcolor="#E8E8E8"><span class="style1">Total Tickets</span></td>
        <td bgcolor="#E8E8E8" class="style1">Tickets sold </td>
        <!--<td height="20" bgcolor="#E8E8E8" class="style1">Commission Charges  </td>
        <td height="20" bgcolor="#E8E8E8" class="style1">DTCM Charges </td>-->
        <td  bgcolor="#E8E8E8" class="style1">Total Amount </td>
      </tr>
  <?php while ($row_priceRs = mysql_fetch_assoc($priceRs)) { ?>
      <tr>
      <td bgcolor="#E8E8E8" class="style1"></td>	
      <td bgcolor="#E8E8E8" class="style1"><?php echo $row_priceRs['price']; ?></td>
      <td bgcolor="#E8E8E8" class="style1"><?php echo $row_priceRs['tickets']; ?></td>
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
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC; height:50px;">
        <tr>
          <td height="20">&nbsp;</td>
          <td width="25%" bgcolor="#CCCCCC" class="style1"><?php echo $tsold; ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1"><?php echo $totsales; ?></td>
        </tr>
      </table></td>
    </tr>
    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Commission</div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC; height:50px;">
        <tr>
          <td>&nbsp;</td>
          
          <td width="50%"  class="style1"><?php if(!empty($totsales) && !empty($row_events['commission'])){ echo ($row_events['commission']/100)*$totsales; } else { echo $row_events['commission']; }  ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1">DTCM Tax</td>
          <td width="25%" class="style1"><?php if(!empty($totsales) && !empty($row_events['dtcm'])){ echo ($row_events['dtcm']/100)*$totsales; } else { echo $row_events['dtcm']; }  ?></td>
          
        </tr>
      </table></td>
    </tr>
    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Service Charge</div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC; height:50px;">
        <tr>
          <td>&nbsp;</td>
          
          <td width="50%"  class="style1"><?php if(!empty($tsold) && !empty($row_events['service_charge'])){ echo $row_events['service_charge']*$tsold; } else { echo $row_events['service_charge']; }  ?></td>
          <td width="25%" bgcolor="#CCCCCC" class="style1">C.C Charge</td>
          <td width="25%" class="style1"><?php if(!empty($totsales) && !empty($row_events['credit_charge'])){ echo ($row_events['credit_charge']/100)*$totsales; } else { echo $row_events['credit_charge']; }  ?></td>
        </tr>
      </table></td>
    </tr>

    <tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center">Amount Due To Promoter</div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC; height:50px;">
        <tr>
          <td>&nbsp;</td>
          
          <td width="100%"  class="style1"><?php if(!empty($row_events['dtcm']) || !empty($row_events['commission']) || !empty($totsales)){ echo $totsales-(($row_events['dtcm']/100)*$totsales)-(($row_events['commission']/100)*$totsales); } else { echo $totsales; } ?></td>
        </tr>
      </table></td>
    </tr>
	
	
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        
        
        var data = google.visualization.arrayToDataTable([
          <?php echo $gender_data; ?>
                    
        ]);
        
        
        var options = {
          title: 'Gender',
          pieSliceText: 'value-and-percentage'
        };
        
             
       
       var dataAge = google.visualization.arrayToDataTable([
          ['Age Bracket', 'Customers'],
          <?php echo $ageDataPieDiagram; ?>
        ]);
         var ageoptions = {
          title: 'Customer Age Brackets',
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 7,

        };
        
        var linedata = google.visualization.arrayToDataTable([
          ['Month', 'Tickets Sold'],
          <?php echo $totalTicketsSoldLineDiagram; ?>
        ]);
         var lineoptions = {
          title: 'Total Tickets Sold',
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 7,
        };
        
        var countryCustomerdata = google.visualization.arrayToDataTable([
          ['Country', 'Customers'],
          <?php echo $totalCustomersFromCountriesLineDiagram; ?>
        ]);
        
        var countryCustomeroptions = {
          title: 'Customers From Countries',
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 7,
        };
        
        

        
        
        var chart = new google.visualization.PieChart(document.getElementById('gender_<?php echo $row_events['tid']; ?>'));
        var chartAge = new google.visualization.LineChart(document.getElementById('age_<?php echo $row_events['tid']; ?>'));
        
        var linechart = new google.visualization.LineChart(document.getElementById('line_chart_<?php echo $row_events['tid']; ?>'));
        var customerLinechart = new google.visualization.LineChart(document.getElementById("columnchart_values_<?php echo $row_events['tid']; ?>"));
        
        // Wait for the chart to finish drawing before calling the getImageURI() method.
        google.visualization.events.addListener(chart, 'ready', function () {
           document.getElementById('gender_<?php echo $row_events['tid']; ?>').innerHTML = '<img src="' + chart.getImageURI() + '">';
           console.log(document.getElementById('gender_<?php echo $row_events['tid']; ?>').innerHTML);
        });

        
        
        
        
        chart.draw(data, options);
        chartAge.draw(dataAge, ageoptions);
        linechart.draw(linedata, lineoptions);
        customerLinechart.draw(countryCustomerdata, countryCustomeroptions);
        }
    </script>  
    <?php if(!empty($gender_data)){ ?> 
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="gender_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
        
      </table></td>
    </tr>
    <?php } ?>
       
    <?php if(!empty($ageDataPieDiagram)){ ?> 
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="age_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <td height="20" width="20%" >Age</td>
          
          <td class="style1" width="80%">No Of People</div></td>
        </tr>
        <?php foreach($c as $keyss => $valss){ ?>
          <tr>
             <td><?php echo $keyss; ?></td>
             <td><?php echo $valss; ?></td>
          </tr>
          <?php 
		}
        ?>
      </table></td>
    </tr>
    
    
    <?php } ?>
    
    <?php if(!empty($totalTicketsSoldLineDiagram)){ ?>
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="line_chart_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <td height="20" width="20%">Month</td>
          
          <td width="80%"  class="style1">No Of Tickets Sold</td>
        </tr>
        <?php
        foreach($ticketsSolddata as $valsss){
        ?>
        <tr>
        	<td><?php echo $valsss[0]; ?></td>
        	<td><?php echo $valsss[1]; ?></td>
        </tr>
        
       <?php 
	} 
        ?>
      </table></td>
    </tr>
    <?php } ?>
    <?php if(!empty($totalCustomersFromCountriesLineDiagram)){ ?>
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%"  class="style1"><div id="columnchart_values_<?php echo $row_events['tid']; ?>" style="width: 500px; height: 250px;"></div></td>
        </tr>
      </table></td>
    </tr>
    
    <tr>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1"><div align="center"></div></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
        <tr>
          <td height="20" width="20%">Country</td>
          
          <td width="80%"  class="style1">No Of Tickets Sold</td>
        </tr>
        <?php
        foreach($countryCustomersdata as $valssss){
        ?>
        <tr>
        	<td><?php echo $valssss[0]; ?></td>
        	<td><?php echo $valssss[1]; ?></td>
        </tr>
        
       <?php 
	} 
        ?>
      </table></td>
    </tr>
	
	<tr<?php echo $trbgcolor ?>>
      <td width="150" align="right" bgcolor="#CCCCCC" class="style1">
	   <div align="center">
	     <span onclick="generatePdf();" style="background-color: yellow;border-radius:5px;cursor:pointer;">DOWNLOAD PDF</span>
	   </div>
	  </td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC; height:50px;">
        <tr>
          <td>&nbsp;</td>
          
          <td width="100%"  class="style1"></td>
        </tr>
      </table></td>
    </tr>
	
	
	
    <?php } ?>
    <?php } while ($row_events = mysql_fetch_assoc($events)); ?>
       
</table>
<br>
<!--<table width="100%" border="0" cellspacing="1" cellpadding="0" style="border: 1px solid; border-color:#CCCCCC">
        <tr>
          <td height="20">&nbsp;</td>
          
          <td width="100%" align="right" class="style1"><input type="button" onclick="generatePdf();" name="downloadPdf" id="downloadPdf" value="Download PDF"/></td>
        </tr>
      </table>-->
      
  <?php

//mysql_free_result($salesRs);

//mysql_free_result($priceRs);

//mysql_free_result($events);
?>