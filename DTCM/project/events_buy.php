<?php include('dtcm_api/api_test.php');
include('dtcm_api/dtcm_api.php'); ?>
<?php include("functions.php"); ?>
<?php include("config.php"); ?>
<?php

//require_once 'softix-ticket-price.php';

//var_dump($_SESSION['softix_token']);
//var_dump($single_price);
//var_dump($ano_price);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style.css" rel="stylesheet" />
<style>
.price_option {
	background: #fff;
	display: block;
	float: left;
	height: auto;
	margin-bottom: 10px;
	margin-right: 9px;
	width: 150px;
	border: 1px solid #d6d6d6;
	border-radius: 4px;
}
.adultbg .full_width select {
	width: 70%;
	border-radius: 4px;
}
.adultbg {
	text-align: center;
	margin: 10px 0 0;
}
.price_option h4 {
	padding: 0 0 0 20px;
	margin: 10px 0;
}
.adult_price,.child_price {
	padding: 0 0 0px 20px;
}
.sold_out {
	display: block;
	color: #f00;
	width: 52px;
	background: #fff;
	padding: 6px;
	border-radius: 4px;
	margin-top: 3px;
}
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/skin.css">
<!--Added by ppatel on 25june2014-->
<script src="js/jquery-1.8.2.js" type="text/javascript"></script>
<script type="text/javascript">
$('#nav a')
	.css( {backgroundPosition: "0 0"} )
	.mouseover(function(){
		$(this).stop().animate(
			{backgroundPosition:"(0 -250px)"}, 
			{duration:500})
		})
	.mouseout(function(){
		$(this).stop().animate(
			{backgroundPosition:"(0 0)"}, 
			{duration:500})
		})
</script>
<script src="js/datepicker.js" type="text/javascript"></script>
<?php
//echo '<pre>'; print_r($_SESSION); exit;
require_once('model_function.php');

if($_COOKIE['city_id']){
	$default_city_id= $_COOKIE['city_id'];
} else {
	$sql="select * from cities";
	$result=mysql_query($sql,$eventscon) or die(mysql_error());
	while($cities=mysql_fetch_assoc($result)){
			
			if($cities['default_city']){
				$default_city_id=$cities['id'];
				setcookie('city_id',$default_city_id,time()+60*60*24*365);
			}
	}
}
$seat_type_arr=get_set_type();

if(empty($_SESSION['Customer']) && empty($_SESSION['PP_UserId']))
{
	$_SESSION['referer']=$_SERVER['REQUEST_URI'];
	header("location:signin.php");exit;
}
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
		case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
	}
	return $theValue;
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
/*
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
}
*/
##Start of javascrpt functions
function gettickets($eventid){
	$ticketid_ticketsRs = $eventid=$_GET['eid'];
	//echo $ticketid_ticketsRs;
	$query_ticketsRs = sprintf("SELECT event_prices.* FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price asc", $ticketid_ticketsRs);
	//echo $query_ticketsRs;
	$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());
	$row_ticketsRs = mysql_fetch_assoc($ticketsRs);
	//$totalRows_ticketsRs = mysql_num_rows($ticketsRs);
	$soption = "";
	$i=0;
        
	echo "<script language='javascript'>\n";
	echo "var pid=new Array();\n";
	echo "var stand=new Array();\n";
	echo "var currency=new Array();\n";
	echo "var price=new Array();\n";
	echo "var cprice=new Array();\n";
	echo "var ticket=new Array();\n";
	echo "var cticket=new Array();\n";
	do {
		$query_oticketsRs = sprintf("select sum(tickets) adult, sum(ctickets) child from ticket_orders where tid = %s and ticket_price = '%s'", $ticketid_ticketsRs,$row_ticketsRs['stand']);
		//echo $query_oticketsRs;
		$oticketsRs = mysql_query($query_oticketsRs) or die(mysql_error());
		$row_oticketsRs = mysql_fetch_assoc($oticketsRs);
                
global $single_price;
global $ano_price;
$row_ticketsRs['price'] = $single_price;
//var_dump($ano_price);
$row_ticketsRs['cprice'] = $ano_price;
		echo "pid[".$i."]='".$row_ticketsRs['pid']."';\n";
		echo "stand[".$i."]='".$row_ticketsRs['stand']."';\n";
		echo "currency[".$i."]='".$row_ticketsRs['currency']."';\n";
		echo "price[".$row_ticketsRs['pid']."]='".$row_ticketsRs['price']."';\n";
		echo "cprice[".$row_ticketsRs['pid']."]='".$row_ticketsRs['cprice']."';\n";
		if ($row_oticketsRs['adult'] < $row_ticketsRs['ticket']){
			echo "ticket[".$i."]='".$row_ticketsRs['ticket']."';\n";
		} else {
			echo "ticket[".$i."]=0;\n";
		}
		if ($row_oticketsRs['child'] < $row_ticketsRs['cticket']){
			echo "cticket[".$i."]='".$row_ticketsRs['cticket']."';\n";
		} else {
			echo "cticket[".$i."]=0;\n";
		}
		$i++;
	} while ($row_ticketsRs = mysql_fetch_assoc($ticketsRs));
	echo "</script>";
	mysql_free_result($ticketsRs);
}
function getdtcmprices($eventcode){
	//if(isset($_SESSION['access_token']) && (time()-$_SESSION['token_addtime'])<$_SESSION['token_lifetime']){
	if(isset($_SESSION['access_token'])){
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
	if($access_token)
	$prices = Dtcm::get_prices($access_token,$eventcode);
	$ticket_prices = json_decode($prices,true);
	
	$soption = "";
	$i=0;
        $price_data['PriceNet'] = $single_price;
	echo "<script language='javascript'>\n";
	echo "var pid=new Array();\n";
	echo "var stand=new Array();\n";
	echo "var currency=new Array();\n";
	echo "var price=new Array();\n";
	echo "var cprice=new Array();\n";
	echo "var ticket=new Array();\n";
	echo "var cticket=new Array();\n";
	foreach ($ticket_prices['PriceCategories'] as $stand){
		foreach ($ticket_prices['PriceTypes'] as $priceType){
		if($priceType['PriceTypeCode'] == 'Q'){
		$price_data = get_priceByCatType($stand['PriceCategoryId'],$priceType['PriceTypeId'],$ticket_prices);
		if($price_data !='' && $price_data['PriceNet']>0 ){
		echo "pid[".$i."]='".$price_data['PriceId']."';\n";
		echo "stand[".$i."]='".$stand['PriceCategoryId']."';\n";
		echo "currency[".$i."]='AED';\n";
		echo "price[".$price_data['PriceId']."]='".$price_data['PriceNet']."';\n";
		
		
			echo "ticket[".$i."]=10;\n";
		
			echo "cticket[".$i."]=0;\n";
		
		$i++;
		}
		}
		}
	} 
	echo "</script>";
	
	
	
}
function get_priceByCatType($catId,$typeId,$ticket_prices) {
	foreach ($ticket_prices['TicketPrices']['Prices'] as $tprice){
		if($tprice['PriceCategoryId']==$catId && $tprice['PriceTypeId']==$typeId ){
			return $tprice;
		}
	}
	return '';
}
##End of javascrpt functions
$colname_eventRS = "-1";
if (isset($_GET['eid'])) {
	$colname_eventRS = (get_magic_quotes_gpc()) ? $_GET['eid'] : addslashes($_GET['eid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_eventRS = sprintf("SELECT * FROM events WHERE tid = %s", $colname_eventRS);
$eventRs = mysql_query($query_eventRS, $eventscon) or die(mysql_error());
$row_eventRs = mysql_fetch_assoc($eventRs);
$totalRows_eventRs = mysql_num_rows($eventRs);
mysql_select_db($database_eventscon, $eventscon);
$query_shiplist = "SELECT * FROM shippingrates ORDER BY name ASC";
$shiplist = mysql_query($query_shiplist, $eventscon) or die(mysql_error());
$row_shiplist = mysql_fetch_assoc($shiplist);
$totalRows_shiplist = mysql_num_rows($shiplist);
##country fetching
$sql_country = "SELECT * FROM country ORDER BY name ASC";
$query_country = mysql_query($sql_country, $eventscon) or die(mysql_error());
##end of country fetching
$buy_date = "<select name='sessiondate' class='formField'>
";
/*if($row_eventRs['ongoing']==ONGOING) {
$buy_date .= "<option value='".ONGOING."'>Ongoing</option>";
}
#added on dec 24
else if($row_eventRs['ongoing']==GUEST)
{
#guest events
$buy_date .= "<option value='".GUEST."'>Guest</option>";
}
else*/
if (($row_eventRs['date_start']!="0000-00-00")&&($row_eventRs['date_end']!="0000-00-00")){
	if($row_eventRs['date_start']>=date('Y-m-d')){
		$start_date=$row_eventRs['date_start'];
	}else
	$start_date=date('Y-m-d');
	list($year, $month, $day, $hour, $minute, $second) = explode('[-: ]', $row_eventRs['date_end']);
	$edate = mktime($hour, $minute, $second, $month, $day, $year);
	list($year, $month, $day, $hour, $minute, $second) = explode('[-: ]', $start_date);
	$sdate = mktime($hour, $minute, $second, $month, $day, $year);
	$date_diff = floor(($edate-$sdate)/86400);
	for($i=0;$i<$date_diff+1;$i++){
		$buy_date .= "<option value='".date("Y-m-d", mktime($hour, $minute, $second, $month, $day, $year))."'>".date("d M Y", mktime($hour, $minute, $second, $month, $day, $year))."</option>";
		$day++;
	}
	//	echo "option2"." - ".$row_eventRs['date_start']." - ".$row_eventRs['date_end'];
} else {
	list($year, $month, $day, $hour, $minute, $second) = split('[-: ]', $row_eventRs['date_start']);
	$sdate = mktime($hour, $minute, $second, $month, $day, $year);
	$buy_date .= "<option value='".date("Y-m-d", mktime($hour, $minute, $second, $month, $day, $year))."'>".date("d M Y", mktime($hour, $minute, $second, $month, $day, $year))."</option>";
	//	echo "option3";
}
$buy_date .= "
</select>";
$query_guidecatRs = "SELECT * FROM `banners`";
$guidecatRs = mysql_query($query_guidecatRs, $eventscon) or die(mysql_error());
$images = mysql_fetch_array($guidecatRs);
?>

<title><?php echo $row_eventRs['title']; ?></title>
<style type="text/css">
.form_bg {
	background: none repeat scroll 0 0 rgba(255, 255, 255, 0.93);
	border: 1px solid rgba(255, 255, 255, 0.59);
	border-radius: 10px 10px 10px 10px;
	box-shadow: 0 0 10px #888888;
	font-family: arial;
	font-size: 13px;
	margin-top: 40px !important;
	padding: 20px;
}
.form_bg input {
}
.full_width {
}
.full_width input {
	width: 76%;
	padding: 5px;
	margin-right: 5px;
	background: #ffffff;
	border: 1px solid #ccc;
}
.full_width textarea {
	width: 76%;
	padding: 5px;
	margin-right: 5px;
	background: #ffffff;
	border: 1px solid #ccc;
}
.full_width select {
	width: 90%;
	padding: 5px;
	margin-right: 0px;
	background: #ffffff;
	border: 1px solid #ccc;
	border-radius: 5px;
}
.full_width_small input {
	width: 80px;
	padding: 5px;
	margin-right: 5px;
	background: #ffffff;
	border: 1px solid #ccc;
}
.adultbg {
	padding: 20px 10px;
	background: #c9c9c7;
	overflow: hidden;
}
</style>
</head>
<body style="margin: 0; padding: 0;">
<?php
$bg_images=$images['p_image'];
if(isset($_GET['eid'])){
	mysql_select_db($database_eventscon, $eventscon);
	$query_bgeventRs = sprintf("SELECT events.popup_pic FROM events WHERE events.tid=%s", $_GET['eid']);
	$bgeventRs = mysql_query($query_bgeventRs, $eventscon) or die(mysql_error());
	$row_bgeventRs = mysql_fetch_assoc($bgeventRs);
	if($row_bgeventRs['popup_pic'] && file_exists($_SERVER['DOCUMENT_ROOT'].'/data/'.$row_bgeventRs['popup_pic']))
	$bg_images="data/".$row_bgeventRs['popup_pic'];
}
?>
<?php require_once('header.php'); ?>
	<div style="background:url('http://www.tktrush.com/data/lara3.jpg')  no-repeat scroll center -252px #08090D; position:fixed; width:100%; height:100%; z-index:-1; top:0; left:0;"></div>
    
    
    
<div class="container">	

<div style="width: 550px; float:left;" class="form_bg">
		<table>
			<tr>
				<td align="center" valign="top"><form action="orderpayment.php"
						method="POST" name="form1" id="form1"
						onsubmit="return YY_checkform('form1','checkbox','#q','1','Please select declaration.','paytype[1]','#q','2','Please select payment type.','fname','#q','0','Please enter your first name.','lname','#q','0','Please enter your last name.','mobile','#q','0','Please enter your mobile.','email','S','2','Please enter your email.','city','#q','0','Please enter your city of residence.');">
						<table width="100%" border="0" cellpadding="4" cellspacing="1">
							<tr align="left" valign="middle">
								<td colspan="2"><b><?php echo $row_eventRs['title']; ?> </b></td>
							</tr>
							<tr align="left" valign="middle">
								<td colspan="2"><img
									src="data/lara3.jpg"
									style="max-width: 483px;" /></b></td>
							</tr>
							<tr align="left" valign="middle">
								<td colspan="2"><?php if ($row_eventRs['ongoing']==ONGOING){ echo "Ongoing";} else if($row_eventRs['ongoing']==GUEST){}
								else { ?> <?php echo eventFirstDate($row_eventRs['date_start']); ?>
								<?php if (($row_eventRs['date_end']) and ($row_eventRs['date_end']!="0000-00-00") and ($row_eventRs['date_end']!=$row_eventRs['date_start'])){ echo " to ".eventFirstDate($row_eventRs['date_end']);} ?>
								<?php echo " ".eventSecondDate($row_eventRs['date_start']); ?> <?php }?>
								</td>
							</tr>
							<tr align="left" valign="middle" class="eventVenue">
								<td colspan="2" class="eventVenueWhite"><?php echo $row_eventRs['venue']; ?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div
										style="background: #444; padding: 10px 0; text-align: center; color: #fff; font-weight: bold; margin: 10px 0 10px; text-transform: uppercase;">Choose
										your tickets</div>
								</td>
							</tr>
							<?php if($row_eventRs['floorplan']){?>
							<tr>
								<td colspan="2">
									<div class="shows-box" style="width:inherit;">
										<h3
											style="border-bottom: 1px dashed #ccc; padding: 0 0 10px; margin: 0 0 20px;">Floor
											Plan</h3>
										<img src="data/<?php echo trim($row_eventRs['floorplan']);?>"
											style="max-width: 485px" />
									</div>
								</td>
							</tr>
							<?php }?>
							<tr>
								<td width="185" align="left" valign="middle" class="eventVenue">Session:
								</td>
								<?php if($row_eventRs['ongoing']=='4'){ ?>
								<td width="288" align="left" valign="top"
									class="eventText full_width"><input type="text"
									name="sale_date" id="sale_date" value="" size="32"
									class="formField" readonly="readonly"> <a
										href="javascript:NewCal('sale_date','mmddyyyy')"><img
											src="images/cal.gif" width="16" height="16" border="0"
											alt="Pick a date" onmouseover="this.style.cursor = 'hand';"
											onmouseout="this.style.cursor = 'default';" /> </a>
								</td>
								<?php }else{ ?>
								<td width="288" align="left" valign="top"
									class="eventText full_width"><?php echo $buy_date; ?></td>
									<?php } ?>
							</tr>
							<tr>
								<td colspan="2" class="eventTextWhite full_width"><?php
								//echo "Here I am";
								//echo $row_eventRs['dtcm_approved'];
								//echo $row_eventRs['dtcm_code'];
								function multidimensional_search($parents, $searched) {
									if (empty($searched) || empty($parents)) {
										return false;
									}
								
									foreach ($parents as $key => $value) {
										$exists = true;
										foreach ($searched as $skey => $svalue) {
											$exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
										}
										if($exists){ return $key; }
									}
								
									return false;
								}

								 //gettickets($row_eventRs['tid'],$seat_type_arr);
								if($row_eventRs['dtcm_approved']=='Yes' && $row_eventRs['dtcm_code']!='' )
									{
										global $dtcm_;
										$eventcode = $row_eventRs['dtcm_code'];
										$ticket_prices=json_decode($dtcm_->get_performance_prices($eventcode),true);
										$available_prices=json_decode($dtcm_->get_performance_availabilities($eventcode),true);
										//var_dump($available_prices);
										//echo "HERE";
										$string = '';
										if(!empty($ticket_prices)){
											foreach ($ticket_prices['PriceCategories'] as $stand){
												//if($available_prices['priceCategoryId'->$stand['PriceCategoryId'])
												//var_dump($stand);
												//var_dump(multidimensional_search($available_prices['PriceCategories'],array('PriceCategoryId'=>$stand['PriceCategoryId'])));
												if($available_prices['PriceCategories'][multidimensional_search($available_prices['PriceCategories'],array('PriceCategoryId'=>$stand['PriceCategoryId']))]['Availability']['SoldOut']=='true')
													continue;
												//if($available_prices['PriceCategories'][multidimensional_search($available_prices['PriceCategories'],array('PriceCategoryId'=>$stand['PriceCategoryId']))]['PriceCategoryName']=='Reserved')
													//continue;
										?>
										<div class="price_option">
										<h4>
										<input type="radio" name="category" value="<?php echo $stand['PriceCategoryCode'];?>" checked='true' onclick='getTotal()'/>
										<?php echo $stand['PriceCategoryName'];?>
										</h4>
										<?php 
											foreach ($ticket_prices['PriceTypes'] as $priceType){
												//var_dump($priceType);
												if($priceType['PriceTypeCode'] == 'A' || $priceType['PriceTypeCode'] == 'Q'|| $priceType['PriceTypeCode'] == 'J'){
													$price_data = get_priceByCatType($stand['PriceCategoryId'],$priceType['PriceTypeId'],$ticket_prices);
													if(($price_data !='' && $price_data['PriceNet']>0 )){ 
													$string .="'".$stand['PriceCategoryCode'].$price_data['PriceTypeCode']."',";
														?>
														<input type="hidden" name="PriceCategoryCode[<?php echo $stand['PriceCategoryCode'];?>]" value="<?php echo $stand['PriceCategoryCode'];?>"/>
														<span class="adult_price"><?php echo $priceType['PriceTypeName'];?></span>:<span class="adult_price" id="price<?php echo $stand['PriceCategoryCode'].$price_data['PriceTypeCode']?>"><?php echo $price_data['PriceNet']/100;?></span>&nbsp;AED<br />
														<input type="hidden" name="price[<?php echo $stand['PriceCategoryCode'].$price_data['PriceTypeCode']?>]" value="<?php echo $price_data['PriceNet']/100;?>"/>
														<input type="hidden" name="pricename[<?php echo $stand['PriceCategoryCode'].$price_data['PriceTypeCode']?>]" value="<?php echo $priceType['PriceTypeName'];?>"/>
										<?php 
														
													}
												}
											}
										?>
										<div class="adultbg">
										<?php 
											foreach ($ticket_prices['PriceTypes'] as $priceType){
												if($priceType['PriceTypeCode'] == 'A' || $priceType['PriceTypeCode'] == 'Q'|| $priceType['PriceTypeCode'] == 'J'){
													$price_data = get_priceByCatType($stand['PriceCategoryId'],$priceType['PriceTypeId'],$ticket_prices);
													if($price_data !='' && $price_data['PriceNet']>0 ){
										?>
											<div style="float: left; width: 48%;">
												<span class="price_qty"><?php echo $priceType['PriceTypeName'];?>
												
												 <select
													name="tickets[<?php echo $stand['PriceCategoryCode'].$price_data['PriceTypeCode'];?>]"
													id="tickets<?php echo $stand['PriceCategoryCode'].$price_data['PriceTypeCode'];?>"
													onchange="getTotal();" >
													<?php for($i=0;$i<=10;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select> 
								
											</div>
											<?php }
											}
											}
											?>
												</div>
										</div>
										<?php 	
										}
										}
										
									} else {
									$string='';
									$query_ticketsRs = sprintf("SELECT event_prices.* FROM event_prices WHERE event_prices.tid = %s ORDER BY event_prices.price asc", $row_eventRs['tid']);
									$ticketsRs = mysql_query($query_ticketsRs) or die(mysql_error());
									$total_prices = mysql_num_rows($ticketsRs);
									if($total_prices>0){?> <?php while($result_set=mysql_fetch_assoc($ticketsRs)){
										$string .=$result_set['pid'].',';
										$prices_sql="select sum(tickets) as ticket_count,sum(ctickets) as cticket_count from ticket_orders where ccapproved='Yes' and payment_status != 'cancelled' and (FIND_IN_SET(".$result_set['pid'].",pid)) ";
										$price_query=mysql_query($prices_sql);
										$total_purchase=mysql_fetch_assoc($price_query);
										$tickets_order=$result_set['tickets']-$total_purchase['ticket_count'];
										$ctickets_order=$result_set['ctickets']-$total_purchase['cticket_count'];
										if($result_set['ticket_per_user']<=$tickets_order){
											$tickets_order=$result_set['ticket_per_user'];
										}
										if($result_set['cticket_per_user']<=$ctickets_order){
											$ctickets_order=$result_set['cticket_per_user'];
										}
										if($tickets_order<1)
										$tickets_order=0;
										if($ctickets_order<1)
										$ctickets_order=0;
										$im_final_currency=  $result_set['currency'];
										if($_GET['eid'] != 161){
                                                                                ?>
									<div class="price_option">
										<h4>
										<?php echo $seat_type_arr[$result_set['stand']];?>
										</h4>
										<?php if($result_set['price']>0){?>
										<span class="adult_price">Adult Price:<?php echo $result_set['price'];?>&nbsp;<?php  echo $result_set['currency'];?>
										</span><br />
										<?php } ?>
										<?php if($result_set['cprice']>0){?>
										<span class="child_price">Child Price:<?php echo $result_set['cprice'];?>&nbsp;<?php echo $result_set['currency'];?>
										</span></br>
										<?php } ?>
										<div class="adultbg">
										<?php if($result_set['tickets']){?>
											<div style="float: left; width: 48%;">
												<span class="price_qty">Adult <?php if($tickets_order){?> <select
													name="tickets[<?php echo $result_set['pid'];?>]"
													id="tickets<?php echo $result_set['pid'];?>"
													onchange="getTotal();">
													<?php for($i=0;$i<=$tickets_order;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select> <?php }else{?> <span class="sold_out">Sold Out</span>
													<input type="hidden"
													name="tickets[<?php echo $result_set['pid'];?>]" value="0"
													id="tickets<?php echo $result_set['pid'];?>" /> <?php }?> </span>
											</div>
											<?php }else{?>
											<input type="hidden"
												name="tickets[<?php echo $result_set['pid'];?>]" value="0"
												id="tickets<?php echo $result_set['pid'];?>" />
												<?php }?>
												<?php if($result_set['ctickets']){?>
											<div style="float: right; width: 48%;">
												<span class="price_qty">Child <?php if($ctickets_order){?> <select
													name="ctickets[<?php echo $result_set['pid'];?>]"
													id="ctickets<?php echo $result_set['pid'];?>"
													onchange="getTotal();">
													<?php for($i=0;$i<=$ctickets_order;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select> <?php }else{?> <span class="sold_out">Sold Out</span>
													<input type="hidden"
													name="ctickets[<?php echo $result_set['pid'];?>]" value="0"
													id="ctickets<?php echo $result_set['pid'];?>" /> <?php }?>
												</span>
											</div>
											<?php }else{?>
											<input type="hidden"
												name="ctickets[<?php echo $result_set['pid'];?>]" value="0"
												id="ctickets<?php echo $result_set['pid'];?>" />
												<?php }?>
										</div>
									</div> <?php 
                                                                                }else{
                                                                                    ?>
                                                                    <div class="price_option">
										<h4>
										<?php echo 'General';?>
										</h4>
										<?php if($single_price>0){?>
										<span class="adult_price">Adult Price:<?php echo $single_price;?>&nbsp;<?php  echo $result_set['currency'];?>
										</span><br />
										<?php } ?>
                                                                                

										<div class="adultbg">
										<?php if($result_set['tickets']){?>
											<div style="float: left; width: 48%;">
												<span class="price_qty"><?php if($tickets_order){?> <select
													name="tickets[<?php echo $result_set['pid'];?>]"
													id="tickets<?php echo $result_set['pid'];?>"
													onchange="getTotal();" class="check_avail">
													<?php for($i=0;$i<=$tickets_order;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select> <?php }else{?> <span class="sold_out">Sold Out</span>
													<input type="hidden"
													name="tickets[<?php echo $result_set['pid'];?>]" value="0"
													id="tickets<?php echo $result_set['pid'];?>" /> <?php }?> </span>
											</div>
											<?php }else{?>
											<input type="hidden"
												name="tickets[<?php echo $result_set['pid'];?>]" value="0"
												id="tickets<?php echo $result_set['pid'];?>" />
												<?php }?>
												
										</div>
									</div>
                                                                    
                                                                    <div class="price_option">
										<h4>
										<?php echo 'General';?>
										</h4>
                                                                                
                                                                                <?php if($ano_price>0){?>
										<span class="child_price">ELAB Price:<?php echo $ano_price;?>&nbsp;<?php echo $result_set['currency'];?>
										</span></br>
										<?php } ?>

										<div class="adultbg">
										<?php if($result_set['tickets']){?>
											<div style="float: left; width: 48%;">
												<span class="price_qty"><?php if($tickets_order){?> <select
													name="ctickets[<?php echo $result_set['pid'];?>]"
													id="ctickets<?php echo $result_set['pid'];?>"
													onchange="getTotal();" class="check_avail">
													<?php for($i=0;$i<=$tickets_order;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select> <?php }else{?> <span class="sold_out">Sold Out</span>
													<input type="hidden"
													name="ctickets[<?php echo $result_set['pid'];?>]" value="0"
													id="ctickets<?php echo $result_set['pid'];?>" /> <?php }?> </span>
											</div>
											<?php }else{?>
											<input type="hidden"
												name="ctickets[<?php echo $result_set['pid'];?>]" value="0"
												id="ctickets<?php echo $result_set['pid'];?>" />
												<?php }?>
												
										</div>
									</div>
                                                                    
                                                                    <!-- comp prizes -->
                                                                    <div class="price_option">
										<h4>
										<?php echo 'Comp C';?>
										</h4>
                                                                                
										<span class="child_price">NO Price: Just Test
										</span></br>

										<div class="adultbg">
										<?php if($result_set['tickets']){?>
											<div style="float: left; width: 48%;">
												<span class="price_qty"> <select
													name="comp_tickets"
													id="comp_tickets"
													 class="check_avail">
													<?php for($i=0;$i<=5;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select>  </span>
											</div>
											<?php }?>
												
										</div>
									</div>
                                                                                                                                        <div class="price_option">
										<h4>
										<?php echo 'Comp Z';?>
										</h4>
                                                                                
										<span class="child_price">NO Price: Just Test
										</span></br>

										<div class="adultbg">
										<?php if($result_set['tickets']){?>
											<div style="float: left; width: 48%;">
												<span class="price_qty"> <select
													name="compz_tickets"
													id="compz_tickets"
													class="check_avail">
													<?php for($i=0;$i<=5;$i++){?>
														<option value="<?php echo $i;?>">
														<?php echo $i;?>
														</option>
														<?php }?>
												</select>  </span>
											</div>
											<?php }?>
												
										</div>
									</div>
                                                                    <?php
                                                                                }
									}
									}
									}
									?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>	
							</tr>
                            <tr>
                            	<td align="left" valign="middle" class="eventVenueWhite">Credit Card Charge:</td>
                                <td><?php  echo $row_eventRs['credit_charge'].' %'; ?>
                                <input type="hidden" id="tkt_credit_charges" value="<?=$row_eventRs['credit_charge']?>">
                                </td>
                            </tr>
                            <tr>
                            	<td align="left" valign="middle" class="eventVenueWhite">Service Charge:</td>
                                <td><?php  echo $row_eventRs['service_charge']?><?php if($row_eventRs['dtcm_approved']=='Yes') echo ' AED'; else echo ' '.$im_final_currency; ?>
                                    <input type="hidden" id="tkt_service_charges" value="<?=$row_eventRs['service_charge']?>">
                                </td>
                            </tr>
                            <?php
									$query_extra_services = sprintf("SELECT * FROM event_services WHERE event_id = %s", $_GET['eid']);
									$extra_services = mysql_query($query_extra_services) or die(mysql_error());
									$totalRows_extra_services= mysql_num_rows($extra_services);
									if($totalRows_extra_services){
								?>
                            <tr>
                            	<td align="left" valign="middle" class="eventVenueWhite">  Extra Services: </td>
                                
                                <td>
                                <select name="extra_services" id="extra_services" onchange="getTotal()">
                                	<option value="">Choose extra services</option>
                                    <?php  while ($row = mysql_fetch_array($extra_services, MYSQL_ASSOC)) {  ?>
                                    <option value="<?php echo $row['id']; ?>" data-price="<?php echo $row['price']; ?>"><?php echo $row['title'].' - '.$row['price'].' '.$im_final_currency; ?></option>
                                    <?php } ?>
                                </select>
                                </td>
                            </tr>
                            <?php } ?>
                            
							<tr>
								<td align="left" valign="middle" class="eventVenueWhite">Delivery
									Region:</td>
								<td align="left" valign="top" class="eventTextWhite full_width">
									<select name="regions" id="regions" onchange="getTotal()">
									<?php
									do {
										if($row_shiplist['name']=="No Delivery / Will Call")
										{
											$selected="selected";
										}
										else
										{
											$selected="";
										}
										?>
										<option value="<?php echo $row_shiplist['rate']?>"
										<?php echo $selected;?>>
											<?php echo $row_shiplist['name']?>
										</option>
										<?php
									} while ($row_shiplist = mysql_fetch_assoc($shiplist));
									$rows = mysql_num_rows($shiplist);
									if($rows > 0) {
										mysql_data_seek($shiplist, 0);
										$row_shiplist = mysql_fetch_assoc($shiplist);
									}
									?>
								</select> <?php if($row_eventRs['ongoing']!='4'){ ?> </br>Delivery
									Charges(Dhs.): <input name="charges" type="text"
									class="formField" id="charges" size="2" onchange="getTotal()" />
									<?php }else{ ?> <input name="charges" type="hidden"
									class="formField" id="charges" value="0" /> <?php }?>
								</td>
							</tr>
							<tr style="background: #fdecb2;">
								<td width="185" align="left" valign="middle"
									class="eventVenueWhite">Total:</td>
								<td width="288" align="left" valign="top"
									class="eventTextWhite full_width"><input name="totalticket"
									type="text" class="formField" id="totalticket" readonly /> <input
									name="vpc_Amount" type="hidden" id="vpc_Amount" />
								</td>
							</tr>
							<tr align="left" valign="middle">
								<td colspan="2" class="eventHeader">&nbsp;</td>
							</tr>
							<tr align="left" valign="middle">
								<td colspan="2" class="eventHeader"><b>Your Details</b></td>
							</tr>
							<tr>
								<td width="185" align="left" valign="middle"
									class="eventVenueWhite ">First Name:</td>
								<td width="288" align="left" valign="top"
									class="eventTextWhite full_width"><input name="fname"
									type="text" class="formField" id="fname"
									value="<?php echo $_SESSION['Customer']['fname'];?>" /></td>
							</tr>
							<tr>
								<td width="185" align="left" valign="middle" class="eventVenue ">Last
									Name:</td>
								<td width="288" align="left" valign="top"
									class="eventText full_width"><input name="lname" type="text"
									class="formField" id="lname"
									value="<?php echo $_SESSION['Customer']['lname'];?>" /></td>
							</tr>
							<tr>
								<td width="185" align="left" valign="middle" class="eventVenue">Address:
								</td>
								<td width="288" align="left" valign="top"
									class="eventText full_width"><textarea name="address" rows="5"
										cols="22">
										<?php echo $_SESSION['Customer']['address'];?>
									</textarea></td>
							</tr>
							<tr>
								<td width="185" align="left" valign="middle"
									class="eventVenueWhite">Mobile:</td>
								<td width="288" align="left" valign="top"
									class="eventTextWhite full_width"><input name="mobile"
									type="text" class="formField" id="mobile"
									value="<?php echo $_SESSION['Customer']['mobile'];?>" /></td>
							</tr>
							<tr>
								<td width="185" align="left" valign="middle" class="eventVenue">Email:</td>
								<td width="288" align="left" valign="top"
									class="eventText full_width">
                                    <?php
                                    $emailValue = '';
                                    $readOnly = 'readonly="readonly"';
                                    if(!empty($_SESSION['PP_UserEmail'])) {
                                        $emailValue = $_SESSION['PP_UserEmail'];
                                        $readOnly = '';

                                    }
                                    if(!empty($_SESSION['Customer']['email'])) {
                                        $emailValue = $_SESSION['Customer']['email'];
                                        $readOnly = 'readonly="readonly"';
                                    }
                                    ?>
                                    <input name="email" type="text"
									class="formField" id="email"
									value="<?php echo $emailValue;?>"
                                    <?php echo $readOnly;?>/></td>
							</tr>
<!--                                                    							<tr>
								<td width="185" align="left" valign="middle" class="eventVenue">Date of Birth:</td>
								<td width="288" align="left" valign="top"
									class="eventText full_width">
                                    <input name="dob" type="text" class="formField" id="dob" value="" /></td>
							</tr>-->
							<tr>
								<td width="185" align="left" valign="middle"
									class="eventVenueWhite">City:</td>
								<td width="288" align="left" valign="top"
									class="eventTextWhite full_width"><input name="city"
									type="text" class="formField" id="city"
									value="<?php echo $_SESSION['Customer']['city'];?>" /></td>
							</tr>
<!--							<tr>
								<td width="185" align="left" valign="middle"
									class="eventVenueWhite">Country:</td>
								<td width="288" align="left" valign="top"
									class="eventTextWhite full_width"><select name="country"
									class="formField" id='con'>
										<option>Select Country</option>
										<?php foreach($c_list as $country => $code){?>
										<option value="<?php echo $code;?>" >
											<?php echo $country;?>
										</option>
										<?php }?>
								</select>
								</td>
							</tr>
                                                    							<tr>
								<td width="185" align="left" valign="middle"
									class="eventVenueWhite">Nationality:</td>
								<td width="288" align="left" valign="top"
									class="eventTextWhite full_width"><select id='nat' name="nationality"
									class="formField">
										<option>Select Nationality</option>
										<?php foreach($c_list as $country => $code){?>
										<option value="<?php echo $code;?>" >
											<?php echo $country;?>
										</option>
										<?php }?>
								</select>
								</td>
							</tr>-->
                            <?php if(empty($_SESSION['PP_UserId'])){ ?>
                                <tr>
                                    <td width="185" align="left" valign="middle" class="eventVenue">Payment
                                        Option:</td>
                                    <td width="288" align="left" valign="top" class="eventText"><p>
                                    <?php if($row_eventRs['payment_option'] == 'all'){ ?>
                                            <label> <input name="paytype" type="radio" checked='checked'
                                                class="formField" value="cc" onclick="getTotal()" /> Credit
                                                Card</label>
                                            <!-- (Soon will be activated)<br />-->
                                            <label> <input name="paytype" type="radio" class="formField"
                                                value="spot" onclick="getTotal()" /> Payment on delivery </label>
                                    <?php } else if($row_eventRs['payment_option'] == 'creditcard'){?>
                                            <label> <input name="paytype" type="radio" checked='checked'
                                                class="formField" value="cc" onclick="getTotal()" /> Credit
                                                Card</label>
                                    <?php } else if($row_eventRs['payment_option'] == 'cod'){?>
                                            <label> <input name="paytype" type="radio" class="formField" checked='checked'
                                                value="spot" onclick="getTotal()" /> Payment on delivery </label>
                                    <?php } ?>
                                        </p></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td align="left" valign="middle" class="eventVenue">&nbsp;</td>
                                    <td align="left" valign="top" class="eventText">
                                        <input name="paytype" type="radio" class="formField" checked='checked'
                                               value="pt_spot" onclick="getTotal()" style="display: none;"/>
                                    </td>
                                </tr>

                                <!--<input name="paytype" type="hidden" class="formField" value="pt_spot" />-->

                            <?php }?>
							<tr>
								<td align="left" valign="middle" class="eventVenueWhite">&nbsp;</td>
								<td align="left" valign="top" class="eventTextWhite"><label> <input
										name="checkbox" type="checkbox" class="eventText"
										value="termsagree" /> I declare having read and agreed on all
										the terms and conditions of Ticket Rush </label></td>
							</tr>
							<tr>
								<td width="185" align="left" valign="middle" class="eventVenue"><input
									name="eid" type="hidden" id="eid"
									value="<?php echo $colname_eventRS; ?>" /></td>
								<td width="288" align="left" valign="top" class="eventText"><input
									name="SubButL" type="submit" id="SubButL" value="Pay Now!"
									style="background: none repeat scroll 0 0 #B13C4F; border: medium none; border-radius: 3px 3px 3px 3px; color: #FFFFFF; padding: 5px 20px; cursor: pointer;" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="MM_insert" value="form1">
					</form></td>
			</tr>
		</table>
	</div>
    
    
    <div class="content-left" style="margin:45px 0 0; ">

<?php require_once('left_content.php'); ?>

</div></div>

<?php require_once('footer.php'); ?>
	<?php
	mysql_free_result($eventRs);
	?>
	<?php 
	if($row_eventRs['dtcm_approved']=='Yes' && $row_eventRs['dtcm_code']!='' )
	getdtcmprices($row_eventRs['dtcm_code']); 
	else
	gettickets(null);?>
        <script type="text/javascript" src="jquery-ui.js" ></script>
        <link rel="stylesheet" href="jquery-ui.css"/>
        <script type="text/javascript">
            $( function() {
    $( "#dob" ).datepicker({ dateFormat: 'm-dd-yy',changeYear:true,yearRange: '1950:2013' });
  } );
        </script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var partnerId = '<?php echo $_SESSION['PP_UserId']; ?>';
        if(partnerId != ''){
            getTotal();
        }
    });
try {
var pageTracker = _gat._getTracker("UA-11947961-2");
pageTracker._trackPageview();
} catch(err) {}
</script>
<script type="text/javascript" language="javascript">

function getTotal(){
//debugger;
//if($("[name='category']").prop('checked')==false) return false;
var cat=$("[name='category']:checked").val();
console.log(cat);
var tottickets;
tottickets = 0;
$.each([ <?php echo trim($string,",");?> ], function( index, value ) {
var k=value;
console.log(k[0]);
if(k[0]!=cat) return;
//var k = document.form1.prices.value;
//document.form1.price.value = price[k];
//document.form1.cprice.value = cprice[k];
//if (price[k]==0){ document.form1.tickets.readOnly = true; }
//if (cprice[k]==0){ document.form1.ctickets.readOnly = true; }
if($("#tickets"+k) && $("#tickets"+k).val()!=0){
tottickets = Number(tottickets) +(Number($("#price"+k).prop('innerText') * $("#tickets"+k).val()));
}

//console.log(tottickets);

//if($("#ctickets"+k) && $("#ctickets"+k).val()!=0){
//    console.log(cprice[k]);
//tottickets =Number(tottickets) + (Number(Number(cprice[k] * $("#ctickets"+k).val())));
//}

//console.log(tottickets);
});
//console.log(tottickets);
var selected_extra_service = $('#extra_services').find('option:selected');
var selected_extra_service_price = selected_extra_service.attr("data-price");
    if(selected_extra_service_price === undefined){
        selected_extra_service_price = 0;
    }
    var serviceCharges = 0;
    var creditCharges = 0;
    if(tottickets > 0){

        if(Number($("#tkt_service_charges").val()) != '0.00'){

            serviceCharges = Number($("#tkt_service_charges").val());
        }

        if(Number($("#tkt_credit_charges").val()) != '0.00'){
            creditCharges = Number(tottickets) * Number($("#tkt_credit_charges").val())/100;
        }
    }

tottickets =Number(tottickets) +(Number(document.form1.regions.value))+ Number(selected_extra_service_price) + Number(serviceCharges) + Number(creditCharges);
console.log(tottickets);
document.form1.charges.value = document.form1.regions.value;
document.form1.totalticket.value = Number(tottickets);
document.form1.vpc_Amount.value = Number(tottickets)*100;
document.getElementById('totalticket').focus();
}
</script>

<!--
$(document).ready(function(){
$('.check_avail').change(function(){
    console.log('change works');
   $.post( "price-avail-check.php").done(function( data ) {
  console.log(data);
  console.log(data.PriceCategories[0]);
  if(data.PriceCategories[0].Availability.SoldOut != false){
      alert('Tickets are sold out');
      $('.check_avail').val(0);
  }
}); 
});
});


	
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
var amt=$("#totalticket").val();
var tkt=0;
$.each([ <?php echo trim($string,",");?> ], function( index, value ) {
	tkt=tkt+Number($("#tickets"+value).val());
	tkt=tkt+Number($("#ctickets"+value).val());
});
if(Number(amt)<1 || tkt<1)
{
	alert("Please select the ticket quantity.");
	return false;
}

//var select_nat = document.getElementById('nat');
//var select_con = document.getElementById('con');
//var text_dob = document.getElementById('dob');
//if(text_dob.value == ''){
//    alert("Please fill date of birth");
//    return false;
//}
//if(!select_con.value || select_con.value == 'Select Country'){
//    alert("Please select Country");
//    return false;
//}
//if(!select_nat.value || select_nat.value == 'Select Nationality'){
//    alert("Please select Nationality");
//    return false;
//}



  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
  if(document.MM_returnValue){
	return true;
  }else{
	  return false;
  }
}
//-->
</script>
</body>
</html>
	<?php
	//mysql_free_result($ticketsRs);
	//mysql_free_result($shiplist);
	?>