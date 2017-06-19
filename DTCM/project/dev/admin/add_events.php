<?php 
require("access.php");
include("../config.php"); 
require_once('../Connections/eventscon.php'); 
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
if(isset($_GET['getcity'])){
$colname_eventsRs = (get_magic_quotes_gpc()) ? $_GET['getcity'] : addslashes($_GET['getcity']);
mysql_select_db($database_eventscon, $eventscon);
$query_eventsRs = sprintf("SELECT * FROM cities WHERE cid= %s", $colname_eventsRs);
$promotersRs = mysql_query($query_eventsRs, $eventscon) or die(mysql_error());
while($cities = mysql_fetch_assoc($promotersRs)){
echo "<option value='".$cities['id']."'>".$cities['name']."</option>";
}
exit;
}
//require("access.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) 
{
foreach($_POST['stand'] as $key=>$val)
{
$insertSQL = sprintf("INSERT INTO event_prices (tid, price, cprice, currency, stand, tickets, ctickets) VALUES (%s, %s, %s, %s, %s, %s, %s)",
GetSQLValueString($_POST['tid'], "int"),
GetSQLValueString($_POST['price'][$key], "double"),
GetSQLValueString($_POST['cprice'][$key], "double"),
GetSQLValueString($_POST['currency'][$key], "text"),
GetSQLValueString($_POST['stand'][$key], "text"),
GetSQLValueString($_POST['tickets'][$key], "int"),
GetSQLValueString($_POST['ctickets'][$key], "int"));
mysql_select_db($database_eventscon, $eventscon);
$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
require("upload.php");
$picture = "";
$xpic = "picture";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
if ($_POST["hot"]=="Yes"){
uploadimg($xpic, "N", "N", 500, 350, 470, 165);
} else {
uploadimg($xpic, "N", "N", 500, 350, 125, 100);	
}
$picture = $_FILES[$xpic]['name'];
}
//echo 'locmap:'.$locmap;
$locmap = "";
$xpic = "locmap";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350, 0,0);
$locmap = $_FILES[$xpic]['name'];
}
$floorplan = "";
$xpic = "floorplan";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350,0,0);
$floorplan = $_FILES[$xpic]['name'];
}
$voucherimage = "";
$xpic = "voucherimage";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/".$_FILES[$xpic]['name']);
$voucherimage = $_FILES[$xpic]['name'];
}

for($k=1;$k<=8;$k++)
{
	${'sponsor_logo'.$k} = "";
$xpic = "sponsor_logo".$k;
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/".$_FILES[$xpic]['name']);
${'sponsor_logo'.$k} = $_FILES[$xpic]['name'];
}
}

for($m=1;$m<=5;$m++)
{
	${'event_pic'.$m} = "";
$xpic = "event_pic".$m;
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/".$_FILES[$xpic]['name']);
${'event_pic'.$m} = $_FILES[$xpic]['name'];
}
}

for($v=1;$v<=2;$v++)
{
	${'voucher_advert'.$v} = "";
$xpic = "voucher_advert".$v;
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/voucher_advert_".$_FILES[$xpic]['name']);
${'voucher_advert'.$v} = "voucher_advert_".$_FILES[$xpic]['name'];
}
}
include("../functions.php");
if ($_POST['date_start']==""){
$datestart = "";
} else { $datestart = getpdate($_POST['date_start']); }
if ($_POST['date_end']==""){
$dateend = "";
} else {$dateend = getpdate($_POST['date_end']);}
if ($_POST['sale_date']==""){
$saledate = "";
} else {$saledate = getpdate($_POST['sale_date']);}
$eventdesc = str_replace("\n", "<br>", $_POST['desc']);
//-----------------------------Video file upload-------------------------------------------------------
$t = time();
$uploaddir ="../eventVideo/";
$videoName="";
if($_FILES["file_video"]['name']!="")#checks whether there is image to upload
{
#assign values
$videoName=$t."_".$_FILES['file_video']['name'];
$videoSize=$_FILES['file_video']['size'];
$videoType=$_FILES['filefile_videoVideo']['type'];
$videotype=explode('/',$videoType);
$vid=$videotype[1];
#validations
if($videoSize<=0 && $vid!='.flv' && $vid!='.FLV') {
echo "Invalid video file.";
exit;
}
// --------  Code for upload----//	
$uploadVideo = $uploaddir.$videoName;
$uploadVideo = mysql_escape_string($uploadVideo);
if(!move_uploaded_file($_FILES['file_video']['tmp_name'], $uploadVideo)){
echo "Unable to upload video file please try again." ;
exit;
}
}
//-----------------------------Audio file upload-------------------------------------------------------
$t = time();
$uploaddir ="../eventAudio/";
$audioName="";
if($_FILES["file_audio"]['name']!="")#checks whether there is image to upload
{
#assign values
$audioName=$t."_".$_FILES['file_audio']['name'];
$audioSize=$_FILES['file_audio']['size'];
$audioType=$_FILES['file_audio']['type'];
$audiotype=explode('/',$audiotype);
$aid=$audiotype[1];
#validations
if($audioSize<=0 && $aid!='.mp3' && $aid!='.MP3') {
echo "Invalid audio file.";
exit;
}
// --------  Code for upload----//	
$uploadAudio = $uploaddir.$audioName;
$uploadAudio = mysql_escape_string($uploadAudio);
if(!move_uploaded_file($_FILES['file_audio']['tmp_name'], $uploadAudio)){
echo "Unable to upload audio file please try again.";
exit;
}
}
$file_path=$_SERVER['DOCUMENT_ROOT'];
$image = $_FILES['pupload']['type'];

$img_name = '';
if($_FILES["pupload"]['name']!="" && $image=="image/jpeg")
{
	$img_name= time().$_FILES['pupload']['name'];
	$img_path="/data/".$img_name;
//  @unlink($_SERVER['DOCUMENT_ROOT'].$banners['b_image']);
$tmp_path=$_FILES['pupload'][tmp_name];
if(move_uploaded_file($tmp_path,$file_path.$img_path))
{
//echo "upload success";
}  
}
$category_id=$_POST['category'];
$insertSQL = sprintf("INSERT INTO events (promoter,city, country, title, `desc`, thumb, pic,popup_pic, date_start, date_end, venue, dress, age_limit, 
restaurant, rest_room, hot, loc_map, floorplan, ongoing, session_hour, doors_open, sale_date,time_start,time_end,time_start_part,time_end_part,videoName,
audioName,category,voucher_image,sponsor_logo1,sponsor_logo2,sponsor_logo3,sponsor_logo4,sponsor_logo5,sponsor_logo6,sponsor_logo7,sponsor_logo8, 
event_pic1, event_pic2, event_pic3, event_pic4, event_pic5,commission,dtcm,credit_charge,service_charge,dtcm_approved,dtcm_code,fb_link,payment_option,voucher_advert1,voucher_advert2) 
VALUES 
(%s,%s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '".$videoName."', '".$audioName."',
'".$category_id."',%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s,%s,%s)",
GetSQLValueString($_POST['promoter'], "int"),
GetSQLValueString($_POST['city'], "int"),
GetSQLValueString($_POST['country'], "int"),
GetSQLValueString($_POST['title'], "text"),
GetSQLValueString($eventdesc, "text"),
GetSQLValueString("t_".$picture, "text"),
GetSQLValueString($picture, "text"),
GetSQLValueString($img_name, "text"),
GetSQLValueString($datestart, "date"),
GetSQLValueString($dateend, "date"),
GetSQLValueString($_POST['venue'], "text"),
GetSQLValueString($_POST['dress'], "text"),
GetSQLValueString($_POST['age_limit'], "text"),
GetSQLValueString(isset($_POST['restaurant']) ? "true" : "", "defined","'Yes'","'No'"),
GetSQLValueString(isset($_POST['rest_room']) ? "true" : "", "defined","'Yes'","'No'"),
GetSQLValueString(isset($_POST['hot']) ? "true" : "", "defined","'Yes'","'No'"),
GetSQLValueString($locmap, "text"),
GetSQLValueString($floorplan, "text"),
GetSQLValueString($_POST['ongoing'],"int"),# ? "true" : "", "defined","'Yes'","'No'"
GetSQLValueString($_POST['session_hour'].".00", "date"),
GetSQLValueString($_POST['doors_open'].".00", "date"),
GetSQLValueString($saledate, "date"),
GetSQLValueString($_POST['time_start'].".00", "date"),
GetSQLValueString($_POST['time_end'].".00", "date"),
GetSQLValueString($_POST['drpTimeStartPart'], "text"),
GetSQLValueString($_POST['drpTimeEndPart'], "text"),
GetSQLValueString($voucherimage, "text"),
GetSQLValueString($sponsor_logo1, "text"),
GetSQLValueString($sponsor_logo2, "text"),
GetSQLValueString($sponsor_logo3, "text"),
GetSQLValueString($sponsor_logo4, "text"),
GetSQLValueString($sponsor_logo5, "text"),
GetSQLValueString($sponsor_logo6, "text"),
GetSQLValueString($sponsor_logo7, "text"),
GetSQLValueString($sponsor_logo8, "text"),
GetSQLValueString($event_pic1, "text"),
GetSQLValueString($event_pic2, "text"),
GetSQLValueString($event_pic3, "text"),
GetSQLValueString($event_pic4, "text"),
GetSQLValueString($event_pic5, "text"),
GetSQLValueString($_POST['commissionCharges'], "decimal"),
GetSQLValueString($_POST['dtcm'], "decimal"),
GetSQLValueString($_POST['creditCharge'], "decimal"),
GetSQLValueString($_POST['serviceCharge'], "decimal"),
GetSQLValueString(($_POST['dtcm_approved'])?'Yes':'No', "text"),
GetSQLValueString($_POST['dtcm_code'], "text"),
GetSQLValueString($_POST['fb_link'], "text"),
GetSQLValueString($_POST['payment_option'], "text"),
GetSQLValueString($voucher_advert1, "text"),
GetSQLValueString($voucher_advert2, "text")  
);
//echo $_POST['ongoing'].'<br>';echo $insertSQL."<br><br>";exit;
mysql_select_db($database_eventscon, $eventscon);
$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
header('Location: index.php');exit;
}
mysql_select_db($database_eventscon, $eventscon);
$query_promotersRs = "SELECT spid, name FROM promoters ORDER BY name ASC";
$promotersRs = mysql_query($query_promotersRs, $eventscon) or die(mysql_error());
$row_promotersRs = mysql_fetch_assoc($promotersRs);
$totalRows_promotersRs = mysql_num_rows($promotersRs);
mysql_select_db($database_eventscon, $eventscon);
$query_countryRs = "SELECT * FROM shippingrates ORDER BY countryid ASC";
$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
$row_countryRs = mysql_fetch_assoc($countryRs);
$totalRows_countryRs = mysql_num_rows($countryRs);
mysql_select_db($database_eventscon, $eventscon);
$query_eventRs = "SELECT tid, title FROM events ORDER BY title ASC";
$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());
$row_eventRs = mysql_fetch_assoc($eventRs);
$totalRows_eventRs = mysql_num_rows($eventRs);
$sql = "select * FROM category";
$category_query = mysql_query($sql, $eventscon) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="events.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/jquery-1.8.2.js"></script>
<script language="javascript" src="datepicker.js"></script>
<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
tinymce.init({
    selector: "#desc"
 });
</script>
<style type="text/css">
<!--
.headeradmin {color: #C31600}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><?php require("head.php"); ?></td>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="200" valign="top"><?php require("contents.php"); ?></td>
<td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
<td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="60%"><form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">ADD EVENT</span></td>
</tr>
<tr>
<td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText">
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Promoter:</td>
<td bgcolor="#EAEAFF"><select name="promoter" class="formField" style="width:150px">
<?php 
do {  
?>
<option value="<?php echo $row_promotersRs['spid']?>" ><?php echo $row_promotersRs['name']?></option>
<?php
} while ($row_promotersRs = mysql_fetch_assoc($promotersRs));
?>
</select>                  </td>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Country:</td>
<td bgcolor="#EAEAFF">
<script type="text/javascript">
function ajaxcall(v){
$.ajax({
type	: "GET",
cache	: false,
url		: "add_events.php?getcity="+v,
data	: $(this).serializeArray(),
success: function(data) {
document.getElementById("city").innerHTML=data
}
});
}
</script>
<select name="country" class="formField" onchange="ajaxcall(this.value);" style="width:150px">
<option value="0" >Select Country</option>
<?php 
do {  
?>
<option value="<?php echo $row_countryRs['countryid']?>" ><?php echo $row_countryRs['name']?></option>
<?php
} while ($row_countryRs = mysql_fetch_assoc($countryRs));
?>
</select>                  </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">City:</td>
<td bgcolor="#EAEAFF">
<select name="city" id="city" class="formField" style="width:150px">
</select> 
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Event Category:</td>
<td bgcolor="#EAEAFF">
<select name="category" class="formField" style="width:150px">
<option value="0" >Select Category</option>
<?php 
while ($category = mysql_fetch_assoc($category_query)) {  
?>
<option value="<?php echo $category['id']?>" ><?php echo $category['name']?></option>
<?php
} 
?>
</select>  
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Title:</td>
<td bgcolor="#EAEAFF"><input type="text" name="title" value="" size="32" class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" valign="top" nowrap bgcolor="#CCCCCC">Description:</td>
<td bgcolor="#EAEAFF"><textarea name="desc" cols="50" rows="20" id="desc" ></textarea>                  </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Picture:</td>
<td bgcolor="#EAEAFF"><input name="picture" type="file" class="formField" id="picture" />
<a href="administer/data/<?php echo $row_eventsRs['pic']; ?>" target="_blank"></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Background Picture:</td>
<td bgcolor="#EAEAFF"><input name="pupload" type="file" class="formField" id="pupload" />
<a href="administer/data/<?php echo $row_eventsRs['popup_pic']; ?>" target="_blank"></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Date start:</td>
<td bgcolor="#EAEAFF"><input type="text" name="date_start" id="date_start" value="" size="32" class="formField" readonly="readonly">
<a href="javascript:NewCal('date_start','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';"></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Date end:</td>
<td bgcolor="#EAEAFF"><input type="text" name="date_end" id="date_end" value="" size="32" class="formField">
<a href="javascript:NewCal('date_end','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';"></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Venue:</td>
<td bgcolor="#EAEAFF"><input type="text" name="venue" value="" size="32" class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Dress:</td>
<td bgcolor="#EAEAFF"><input type="text" name="dress" value="" size="32" class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Age limit:</td>
<td bgcolor="#EAEAFF"><input type="text" name="age_limit" value="" size="32" class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Restaurant:</td>
<td bgcolor="#EAEAFF"><input type="checkbox" name="restaurant" value="Yes"  class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Rest room:</td>
<td bgcolor="#EAEAFF"><input type="checkbox" name="rest_room" value="Yes"  class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Hot:</td>
<td bgcolor="#EAEAFF"><input type="checkbox" name="hot" value="Yes"  class="formField"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Location map:</td>
<td bgcolor="#EAEAFF"><input name="locmap" type="file" class="formField" id="locmap" /></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Floor plan:</td>
<td bgcolor="#EAEAFF"><input name="floorplan" type="file" class="formField" id="floorplan" />
<a href="administer/data/<?php echo $row_eventsRs['pic']; ?>" target="_blank"></a> <a href="administer/data/<?php echo $row_eventsRs['pic']; ?>" target="_blank"></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Event:</td>
<td bgcolor="#EAEAFF">
<!--<input type="checkbox" name="ongoing" value="Yes"  class="formField">-->
<select name="ongoing" class="formField" >
<option value="<?php echo ONGOING?>">On Going</option>
<option value="<?php echo UPCOMING?>">Up Coming</option>
<option value="<?php echo GUEST?>">Guest List</option>
<option value="<?php echo OUTANDABOUT?>">Out & About</option>
</select>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">DTCM Approved:</td>
<td bgcolor="#EAEAFF">
<input type="checkbox" name="dtcm_approved" id="dtcm_approved" value="Yes"  class="formField" onclick="toggle_code();">

</td>
</tr>
<tr valign="baseline" id="code_block" style="display: none;">
<td align="right" nowrap bgcolor="#CCCCCC">DTCM Code:</td>
<td bgcolor="#EAEAFF"><input type="text" name="dtcm_code" value="" size="32" class="formField">
 </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Session hour:</td>
<td bgcolor="#EAEAFF"><input type="text" name="session_hour" value="" size="32" class="formField">
HH:MM </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Doors open:</td>
<td bgcolor="#EAEAFF"><input type="text" name="doors_open" value="" size="32" class="formField">
HH:MM </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Start Sale date:</td>
<td bgcolor="#EAEAFF"><input type="text" name="sale_date" id="sale_date" value="" size="32" class="formField" readonly="readonly">
<a href="javascript:NewCal('sale_date','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Time Start:</td>
<td bgcolor="#EAEAFF"><input type="text" name="time_start" id="time_start" value="" size="32" class="formField" >
&nbsp;<select name="drpTimeStartPart"><option value="AM">AM</option><option value="PM">PM</option></select>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Time End:</td>
<td bgcolor="#EAEAFF"><input type="text" name="time_end" id="time_end" value="" size="32" class="formField" >
&nbsp;<select name="drpTimeEndPart"><option value="AM">AM</option><option value="PM">PM</option></select>
</td>
</tr>
<tr valign="baseline" >
<td align="right" nowrap bgcolor="#CCCCCC">Facebook Link:</td>
<td bgcolor="#EAEAFF"><input type="text" name="fb_link" value="" size="32" class="formField">
 </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Payment Option:</td>
<td bgcolor="#EAEAFF">
<select name="payment_option" class="formField" >
<option value="all">All</option>
<option value="creditcard">Credit Card</option>
<option value="cod">Payment on delivery</option>
</select>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Upload Video:</td>
<td bgcolor="#EAEAFF"><input type="file" name="file_video" id="file_video"  class="formField" >
&nbsp;(Only .flv extension files)
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Upload Audio:</td>
<td bgcolor="#EAEAFF"><input type="file" name="file_audio" id="file_audio"  class="formField" >
&nbsp;(Only .mp3 extension files)
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Voucher Image:</td>
<td bgcolor="#EAEAFF"><input name="voucherimage" type="file" class="formField" id="voucherimage" />
</td>
</tr>
<tr valign="baseline">
<td align="left" nowrap bgcolor="#EAFFB7" colspan="2" style=" padding-left: 188px; font-weight: bold; height: 25px; vertical-align: middle;">Sponsor Logos</td>
</td>
</tr>
<?php for($i=1;$i<=8;$i++){ ?>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Sponsor Logo<?php echo $i;?>:</td>
<td bgcolor="#EAEAFF"><input name="sponsor_logo<?php echo $i;?>" type="file" class="formField" id="sponsor_logo<?php echo $i;?>" />
</td>
</tr>
<?php } ?>
<tr valign="baseline">
<td align="left" nowrap bgcolor="#EAFFB7" colspan="2" style=" padding-left: 188px; font-weight: bold; height: 25px; vertical-align: middle;">Additional Images</td>
</td>
</tr>
<?php for($i=1;$i<=5;$i++){ ?>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Image<?php echo $i;?>:</td>
<td bgcolor="#EAEAFF"><input name="event_pic<?php echo $i;?>" type="file" class="formField" id="event_pic<?php echo $i;?>" />
</td>
</tr>
<?php } ?>

<tr valign="baseline">
<td align="left" nowrap bgcolor="#EAFFB7" colspan="2" style=" padding-left: 188px; font-weight: bold; height: 25px; vertical-align: middle;">Voucher Adverts</td>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Voucher Advert1:</td>
<td bgcolor="#EAEAFF"><input name="voucher_advert1" type="file" class="formField" id="voucher_advert1" />
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Voucher Advert2:</td>
<td bgcolor="#EAEAFF"><input name="voucher_advert2" type="file" class="formField" id="voucher_advert2" />
</td>
</tr>

<tr valign="baseline">
<td align="left" nowrap bgcolor="#EAEAFF" colspan="2">&nbsp;</td>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Commission charges:</td>
<td bgcolor="#EAEAFF"><input name="commissionCharges" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">DTCM charges:</td>
<td bgcolor="#EAEAFF"><input name="dtcm" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Credit charges:</td>
<td bgcolor="#EAEAFF"><input name="creditCharge" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Service charges:</td>
<td bgcolor="#EAEAFF"><input name="serviceCharge" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#EAEAFF">&nbsp;</td>
<td bgcolor="#EAEAFF"><input type="submit" value="Insert record" class="formField"></td>
</tr>
</table>
<input type="hidden" name="MM_insert" value="form1" class="formField">
</form>
<p>&nbsp;</p></td>
<?php if(false){//##No use of this block in add event page?>
<td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
<td width="40%" valign="top"><form method="post" name="form2" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">ADD EVENT PRICE </span></td>
</tr>
<tr>
<td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
</tr>
</table>
<div id="inputoptions">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText">
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Seat Type:</td>
<td bgcolor="#EAEAFF">
<select name="stand[]">
<option value="">Select Seat Type</option>
<?php foreach($seat_type_arr as $key=>$seat){?>
<option value="<?php echo $key;?>"><?php echo $seat;?></option>
<?php }?>
</select>
</td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline" >
<td align="right" nowrap bgcolor="#CCCCCC">Adult Price:</td>
<td bgcolor="#EAEAFF"><input name="price[]" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">No or Tickets:
<input name="tickets[]" type="text" id="tickets" size="15" /></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Child Price:</td>
<td bgcolor="#EAEAFF"><input name="cprice[]" type="text" class="formField" id="cprice" value="" size="15" /></td>
<td bgcolor="#EAEAFF">No or Tickets: 
<input name="ctickets[]" type="text" id="ctickets" size="15" /></td>
</tr>

<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Currency:</td>
<td bgcolor="#EAEAFF"><input name="currency[]" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
<td bgcolor="#EAEAFF"><input type="submit" value="Add Price"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
</table>
</div>
<input type="button" id="btnAdd" value="Add More Prices" style="background: #069;color: #fff;border: none;padding: 5px 10px;font-size: 14px;margin: 10px 0 0 175px;cursor:pointer;" />
<input type="hidden" name="MM_insert" value="form2">
</form>
</td>
<?php }?>
</tr>
</table></td>
</tr>
</table>
<script type="text/javascript">
function toggle_code(){
	if(document.getElementById('dtcm_approved').checked) {
	    $("#code_block").show();
	} else {
	    $("#code_block").hide();
	}
}
</script>
</body>
</html>
<?php
mysql_free_result($promotersRs);
mysql_free_result($countryRs);
mysql_free_result($eventRs);
?>