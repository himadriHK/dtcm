<?php 
require("access.php"); 
include("../config.php"); 
include("../functions.php");
require_once('../Connections/eventscon.php'); 
require_once('../model_function.php');
$seat_type_arr=get_set_type();
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

if(isset($_POST['service_name']) && $_POST['service_name']){
	mysql_select_db($database_eventscon, $eventscon);
		
		foreach($_POST['service_name'] as $key=>$service){
			if($_POST['service_name'][$key] && $_POST['service_price'][$key] && !isset($_POST['service_ids'][$key])){
				$insertSQL = sprintf("INSERT INTO event_services (event_id, title,price) VALUES (%s, %s, %s)",
				GetSQLValueString($_GET['tid'], "int"),
				GetSQLValueString($_POST['service_name'][$key], "text"),
				GetSQLValueString($_POST['service_price'][$key], "double"));
				$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
			}else if(isset($_POST['service_ids'][$key]) && $_POST['service_ids'][$key]){
				if($_POST['service_name'][$key] && $_POST['service_price'][$key]){
						$updateSQL = sprintf("UPDATE event_services SET  title=%s, price=%s  WHERE id=%s",
							GetSQLValueString($_POST['service_name'][$key], "text"),
							GetSQLValueString($_POST['service_price'][$key], "double"),
							GetSQLValueString($_POST['service_ids'][$key], "int"));
						$Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
				}
				
			}
		}
	
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
if($_POST['price_id']['update'])
{
foreach($_POST['price_id']['update'] as $key=>$val)
{
$error=0;
if($_POST['price'][$key]==''){$error=1;}
if($_POST['cprice'][$key]==''){$error=1;}
if($_POST['currency'][$key]==''){$error=1;}
if($_POST['stand'][$key]==''){$error=1;}
if($_POST['tickets'][$key]==''){$error=1;}
if($_POST['ctickets'][$key]==''){$error=1;}
if($_POST['ticket_per_user'][$key]==''){$error=1;}
if($_POST['cticket_per_user'][$key]==''){$error=1;}
if($val!='' && !$error)
{
$updateSQL = sprintf("UPDATE event_prices SET  price=%s, cprice=%s, currency=%s, stand=%s, tickets=%s, ctickets=%s,ticket_per_user=%s,cticket_per_user=%s WHERE pid=%s",
GetSQLValueString($_POST['price'][$key], "double"),
GetSQLValueString($_POST['cprice'][$key], "double"),
GetSQLValueString($_POST['currency'][$key], "text"),
GetSQLValueString($_POST['stand'][$key], "text"),
GetSQLValueString($_POST['tickets'][$key], "int"),
GetSQLValueString($_POST['ctickets'][$key], "int"),
GetSQLValueString($_POST['ticket_per_user'][$key], "int"),
GetSQLValueString($_POST['cticket_per_user'][$key], "int"),
GetSQLValueString($val, "int"));
mysql_select_db($database_eventscon, $eventscon);
$Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}
}
}
if($_POST['price_id']['insert'])
{
foreach($_POST['price_id']['insert'] as $key=>$val)
{
$error=0;
if($_POST['price'][$key]==''){$error=1;}
if($_POST['cprice'][$key]==''){$error=1;}
if($_POST['currency'][$key]==''){$error=1;}
if($_POST['stand'][$key]==''){$error=1;}
if($_POST['tickets'][$key]==''){$error=1;}
if($_POST['ctickets'][$key]==''){$error=1;}
if($_POST['ticket_per_user'][$key]==''){$error=1;}
if($_POST['cticket_per_user'][$key]==''){$error=1;}
if(!$error)
{
$insertSQL = sprintf("INSERT INTO event_prices (tid, price, cprice, currency, stand, tickets, ctickets,ticket_per_user,cticket_per_user) VALUES (%s, %s, %s, %s, %s, %s, %s,%s,%s)",
GetSQLValueString($_GET['tid'], "int"),
GetSQLValueString($_POST['price'][$key], "double"),
GetSQLValueString($_POST['cprice'][$key], "double"),
GetSQLValueString($_POST['currency'][$key], "text"),
GetSQLValueString($_POST['stand'][$key], "text"),
GetSQLValueString($_POST['tickets'][$key], "int"),
GetSQLValueString($_POST['ctickets'][$key], "int"),
GetSQLValueString($_POST['ticket_per_user'][$key], "int"),
GetSQLValueString($_POST['cticket_per_user'][$key], "int"));
mysql_select_db($database_eventscon, $eventscon);
$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
}
}
}
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
require("upload.php");
$picture = $_POST["upicture"];
$xpic = "picture";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
if ($_POST["hot"]=="Yes"){
uploadimg($xpic, "N", "N", 500, 350, 470, 165);
} else {
uploadimg($xpic, "N", "N", 500, 350, 125, 100);	
}
$picture = $_FILES[$xpic]['name'];
}
$locmap = $_POST["ulocmap"];
$xpic = "locmap";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350,0,0);
$locmap = $_FILES[$xpic]['name'];
}
$floorplan = $_POST["ufloorplan"];
$xpic = "floorplan";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
uploadimg($xpic, "N", "N", 500, 350,0,0);
$floorplan = $_FILES[$xpic]['name'];
}
$voucherimage = $_POST["uvoucherimage"];
$xpic = "voucherimage";
if (($_FILES[$xpic]['name']<>"none") and ($_FILES[$xpic]['name']<>"")){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/".$_FILES[$xpic]['name']);
$voucherimage = $_FILES[$xpic]['name'];
}
for($k=1;$k<=8;$k++)
{
	${'sponsor_logo'.$k} = $_POST["usponsor_logo".$k];
$xpic = "sponsor_logo".$k;
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/".$_FILES[$xpic]['name']);
 ${'sponsor_logo'.$k} = $_FILES[$xpic]['name'];
}
}


for($m=1;$m<=5;$m++)
{
	${'event_pic'.$m} = $_POST["uevent_pic".$m];
$xpic = "event_pic".$m;
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/".$_FILES[$xpic]['name']);
${'event_pic'.$m} = $_FILES[$xpic]['name'];
}
}

for($k=1;$k<=8;$k++)
{
	${'voucher_advert'.$k} = $_POST["uvoucher_advert".$k];
$xpic = "voucher_advert".$k;
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/voucher_advert_".$_FILES[$xpic]['name']);
 ${'voucher_advert'.$k} = "voucher_advert_".$_FILES[$xpic]['name'];
}
}

if ($_POST['date_start']==""){
$datestart = "";
} else { $datestart = getpdate($_POST['date_start']); }
if ($_POST['date_end']==""){
$dateend = "";
} else {$dateend = getpdate($_POST['date_end']);}
if ($_POST['sale_date']==""){
$saledate = "";
} else {$saledate = getpdate($_POST['sale_date']);}
//-----------------------------Video file upload-------------------------------------------------------
$t = time();
$uploaddir ="../eventVideo/";
$videoName="";
if($_FILES["file_video"]['name']!="")#checks whether there is image to upload
{
if(isset($_POST["hidVideo"]))
{
$existsVideo=$_POST["hidVideo"];
#assign values
$videoName=$t."_".$_FILES['file_video']['name'];
$videoSize=$_FILES['file_video']['size'];
$videoType=$_FILES['file_video']['type'];
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
echo "Unable to upload video file please try again.";
exit;
}
else
{
if($existsVideo!="")
{
#unlink existing video
unlink("../eventVideo/".$existsVideo);
}
}
}
}
else
{
if(isset($_POST["hidVideo"]))
{
$videoName= $_POST["hidVideo"];
}
else
{
$videoName = "";
}
}
//-----------------------------Upload audio files----------------------------------------------------------------------
$t = time();
$uploaddir ="../eventAudio/";
$audioName="";
if($_FILES["file_audio"]['name']!="")#checks whether there is image to upload
{
if(isset($_POST["hidAudio"]))
{
$existsAudio=$_POST["hidAudio"];
#assign values
$audioName=$t."_".$_FILES['file_audio']['name'];
$audioSize=$_FILES['file_audio']['size'];
$audioType=$_FILES['file_audio']['type'];
$audiotype=explode('/',$audioType);
$aud=$audiotype[1];
#validations
if($audioSize<=0) {
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
else
{
if($existsAudio!="")
{
#unlink existing audio
unlink("../eventAudio/".$existsAudio);
}
}
}
}
else
{
if(isset($_POST["hidAudio"]))
{
$audioName = $_POST["hidAudio"];
}
else
{
$audioName= "";
}
}
$colname_eventsRs = "-1";
if (isset($_GET['tid'])) {
$colname_eventsRs = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_eventsRs = sprintf("SELECT * FROM events WHERE tid = %s", $colname_eventsRs);
$eventsRs = mysql_query($query_eventsRs, $eventscon) or die(mysql_error());
$row_eventsRs = mysql_fetch_assoc($eventsRs);
$file_path=$_SERVER['DOCUMENT_ROOT'];
$image = $_FILES['pupload']['type'];
//$img_name= time().$_FILES['pupload']['name'];
//$img_path="/data/$img_name";
$img_name = $row_eventsRs['popup_pic'];
if($_FILES["pupload"]['name']!="" && $image=="image/jpeg")
{
@unlink($_SERVER['DOCUMENT_ROOT'].'/data/'.$row_eventsRs['popup_pic']);
$img_name= time().$_FILES['pupload']['name'];
	$img_path="/data/".$img_name;
$tmp_path=$_FILES['pupload']['tmp_name'];
if(move_uploaded_file($tmp_path,$file_path.$img_path))
{
//echo "upload success";
}  
}
$eventdesc = str_replace("\n", "<br>", $_POST['desc']);
$category_id=$_POST['category'];
$updateSQL = sprintf("UPDATE events SET title=%s, `desc`=%s, thumb=%s, pic=%s,popup_pic=%s, date_start=%s, date_end=%s, venue=%s, dress=%s, age_limit=%s,
 restaurant=%s, rest_room=%s, hot=%s,city=%s, country=%s, promoter=%s, loc_map=%s, floorplan=%s, ongoing=%s, session_hour=%s, doors_open=%s, sale_date=%s,
  time_start=%s, time_end= %s, time_start_part=%s, time_end_part=%s, videoName='".$videoName."', audioName='".$audioName."' , category='".$category_id."',
   voucher_image=%s, sponsor_logo1=%s, sponsor_logo2=%s, sponsor_logo3=%s, sponsor_logo4=%s, sponsor_logo5=%s, sponsor_logo6=%s, sponsor_logo7=%s,
    sponsor_logo8=%s, event_pic1=%s, event_pic2=%s, event_pic3=%s, event_pic4=%s, event_pic5=%s, commission=%s, dtcm=%s,credit_charge=%s,service_charge=%s,partner_commission=%s,
     dtcm_approved=%s, dtcm_code=%s, fb_link=%s, payment_option=%s, voucher_advert1=%s, voucher_advert2=%s, partner=%s  WHERE tid=%s",
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
GetSQLValueString($_POST['city'], "int"),
GetSQLValueString($_POST['country'], "int"),
GetSQLValueString($_POST['promoter'], "int"),
GetSQLValueString($locmap, "text"),
GetSQLValueString($floorplan, "text"),
GetSQLValueString($_POST['ongoing'], "int" ),#? "true" : "", "defined","'Yes'","'No'"
GetSQLValueString($_POST['session_hour'], "date"),
GetSQLValueString($_POST['doors_open'], "date"),
GetSQLValueString($saledate, "date"),
GetSQLValueString($_POST['time_start'], "date"),
GetSQLValueString($_POST['time_end'], "date"),
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
    GetSQLValueString($_POST['partnerCommission'], "decimal"),
GetSQLValueString(($_POST['dtcm_approved'])?'Yes':'No', "text"),
GetSQLValueString($_POST['dtcm_code'], "text"),
GetSQLValueString($_POST['fb_link'], "text"),
GetSQLValueString($_POST['payment_option'], "text"),
GetSQLValueString($voucher_advert1, "text"),
GetSQLValueString($voucher_advert2, "text"),
GetSQLValueString($_POST['partner'], "int"),
GetSQLValueString($_POST['tid'], "int"));
//echo $updateSQL;
mysql_select_db($database_eventscon, $eventscon);
$Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
}
mysql_select_db($database_eventscon, $eventscon);
$query_promotersRs = "SELECT spid, name FROM promoters ORDER BY name ASC";
$promotersRs = mysql_query($query_promotersRs, $eventscon) or die(mysql_error());
$row_promotersRs = mysql_fetch_assoc($promotersRs);
$totalRows_promotersRs = mysql_num_rows($promotersRs);

//functionality for partners
$query_partnersRs = "SELECT spid, name FROM partners ORDER BY name ASC";
$partnersRs = mysql_query($query_partnersRs, $eventscon) or die(mysql_error());
$row_partnersRs = mysql_fetch_assoc($partnersRs);
$totalRows_partnersRs = mysql_num_rows($partnersRs);

mysql_select_db($database_eventscon, $eventscon);
$query_countryRs = "SELECT * FROM shippingrates ORDER BY countryid ASC";
$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
$row_countryRs = mysql_fetch_assoc($countryRs);
$totalRows_countryRs = mysql_num_rows($countryRs);
$colname_eventsRs = "-1";
if (isset($_GET['tid'])) {
$colname_eventsRs = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_eventsRs = sprintf("SELECT * FROM events WHERE tid = %s", $colname_eventsRs);
$eventsRs = mysql_query($query_eventsRs, $eventscon) or die(mysql_error());
$row_eventsRs = mysql_fetch_assoc($eventsRs);
$totalRows_eventsRs = mysql_num_rows($eventsRs);
//cities details
mysql_select_db($database_eventscon, $eventscon);
$query_eventsRs = sprintf("SELECT * FROM cities WHERE id= %s", $row_eventsRs['city']);
$citysql= mysql_query($query_eventsRs, $eventscon) or die(mysql_error());
////////////
$colname_priceRs = "-1";
if (isset($_GET['tid'])) {
$colname_priceRs = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);
}
mysql_select_db($database_eventscon, $eventscon);
$query_priceRs = sprintf("SELECT * FROM event_prices WHERE tid = %s", $colname_priceRs);
$priceRs = mysql_query($query_priceRs, $eventscon) or die(mysql_error());
$totalRows_priceRs = mysql_num_rows($priceRs);
$query_alleventsRs = "SELECT * FROM events ORDER BY title ASC";
$alleventsRs = mysql_query($query_alleventsRs, $eventscon) or die(mysql_error());
$row_alleventsRs = mysql_fetch_assoc($alleventsRs);
$totalRows_alleventsRs = mysql_num_rows($alleventsRs);
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
<script type="text/javascript" src="../js/nano.js"></script>
<script type="text/javascript" src="../js/dtcm_api.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#desc"
 });
</script>
<script type="text/javascript">
var num=<?php echo (isset($pricecount))?$pricecount:0;?>;
$(document).ready(function() {
$('#dtcm_code').blur(
function()
{
	if(validateDTCMcode($('#dtcm_code').val()))
	{
		$('#dtcm_code_valid').val('VALID');
		jQuery('#dtcm_code').css("background-color","lime");
		jQuery('#update_event').removeAttr('disabled');
	}
	else{
		$('#dtcm_code_valid').val('INVALID');
		jQuery('#dtcm_code').css("background-color","red");
		jQuery('#update_event').attr('disabled','disabled');
		
	}
}
);
$('#btnAdd').click(function() {
num=num+1;                      
// create the new element via clone(), and manipulate it's ID using newNum value
var html ='<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText" id="input'+num+'" ><tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Seat Type:</td><td bgcolor="#EAEAFF"><select name="stand[]"><option value="">Select Seat Type</option><?php foreach($seat_type_arr as $key=>$seat){?><option value="<?php echo $key;?>"><?php echo $seat;?></option><?php }?></select></td><td bgcolor="#EAEAFF">&nbsp;</td></tr><tr valign="baseline" ><td align="right" nowrap bgcolor="#CCCCCC">Adult Price:</td><td bgcolor="#EAEAFF"><input name="price[]" type="text" class="formField" value="" size="15"></td><td bgcolor="#EAEAFF">&nbsp;</td></tr><tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Adult Seats Per User:</td><td bgcolor="#EAEAFF"><input name="ticket_per_user[]" type="text" class="formField" id="ticket_per_user" value="" size="15" /></td><td bgcolor="#EAEAFF">No or Tickets:<input name="tickets[]" type="text" id="tickets" size="15" /></td></tr><tr valign="baseline"><td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Child Price:</td><td bgcolor="#EAEAFF"><input name="cprice[]" type="text" class="formField" id="cprice" value="" size="15" /></td><td bgcolor="#EAEAFF">&nbsp;</td></tr><tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Child Seats Per User:</td><td bgcolor="#EAEAFF"><input name="cticket_per_user[]" type="text" class="formField" id="cticket_per_user" value="" size="15" /></td><td bgcolor="#EAEAFF">No or Tickets:<input name="ctickets[]" type="text" id="ctickets" size="15" /></td></tr><tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Currency:</td><td bgcolor="#EAEAFF"><input name="currency[]" type="text" class="formField" value="" size="15"></td><td bgcolor="#EAEAFF">&nbsp;</td></tr><tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td><td bgcolor="#EAEAFF"><input type="submit" value="Add Price"><input type="hidden" name="price_id[insert][]" value=""/>&nbsp;<a href="javascript:void(0)" onclick="removelocation('+num+');">Remove</a></td><td bgcolor="#EAEAFF">&nbsp;</td></tr></table>';
$('#inputoptions').append(html);
});
});
function removelocation(num) {
$('#input' + num).remove();     // remove the last element
}
</script>
<script>
function openVideoPlayer()
{
if(document.form1.hidVideo.value!="")
{
file="eventVideo/"+document.form1.hidVideo.value
}
window.open('../playVideo.php?fileName='+file+'&from=video','popup','width=450,height=350,scrollbars=yes,resizable=yes,toolbar=no,status=no,left=50,top=0');
}
function openAudioPlayer()
{
if(document.form1.hidAudio.value!="")
{
file="eventAudio/"+document.form1.hidAudio.value
}
window.open('../playVideo.php?fileName='+file+'&from=audio','popup','width=450,height=350,scrollbars=yes,resizable=yes,toolbar=no,status=no,left=50,top=0');
}
</script>
<script src="rest.js"></script>
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
<td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="top"><form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td height="25" bgcolor="#333333"><div align="center" class="eventHeader">UPDATE EVENTS</div></td>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText">
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Title:</td>
<td bgcolor="#EAFFB7"><input type="text" name="title" value="<?php echo $row_eventsRs['title']; ?>" size="32"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Desc:</td>
<td bgcolor="#EAFFB7"><textarea name="desc" cols="50" rows="20" id="desc"><?php echo $row_eventsRs['desc']; ?></textarea></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Pic:</td>
<td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['pic']; ?>" target="_blank"><?php echo $row_eventsRs['pic']; ?>
<input name="upicture" type="hidden" id="upicture" value="<?php echo $row_eventsRs['pic']; ?>" />
<br />
<input name="picture" type="file" class="formField" id="picture" />
</a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Background Pic:</td>
<td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['popup_pic']; ?>" target="_blank"><?php echo $row_eventsRs['popup_pic']; ?>
</a>
<br />
<input name="pupload" type="file" class="formField" id="pupload" />
</a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Date_start:</td>
<td bgcolor="#EAFFB7" ><input type="text" name="date_start" id="date_start" value="<?php if($row_eventsRs['date_start']!=""){ echo getddate($row_eventsRs['date_start']); } ?>" size="32" readonly>
<a href="javascript:NewCal('date_start','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Date_end:</td>
<td bgcolor="#EAFFB7"><input type="text" name="date_end" id="date_end" value="<?php if($row_eventsRs['date_end']!=""){ echo getddate($row_eventsRs['date_end']); } ?>" size="32">
<a href="javascript:NewCal('date_end','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Venue:</td>
<td bgcolor="#EAFFB7"><input type="text" name="venue" value="<?php echo $row_eventsRs['venue']; ?>" size="32"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Dress:</td>
<td bgcolor="#EAFFB7"><input type="text" name="dress" value="<?php echo $row_eventsRs['dress']; ?>" size="32"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Age_limit:</td>
<td bgcolor="#EAFFB7"><input type="text" name="age_limit" value="<?php echo $row_eventsRs['age_limit']; ?>" size="32"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Restaurant:</td>
<td bgcolor="#EAFFB7"><input type="checkbox" name="restaurant" value="Yes"  <?php if (!(strcmp($row_eventsRs['restaurant'],"Yes"))) {echo "checked=\"checked\"";} ?>></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Rest_room:</td>
<td bgcolor="#EAFFB7"><input type="checkbox" name="rest_room" value="Yes"  <?php if (!(strcmp($row_eventsRs['rest_room'],"Yes"))) {echo "checked=\"checked\"";} ?>></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Hot:</td>
<td bgcolor="#EAFFB7"><input type="checkbox" name="hot" value="Yes" <?php if (!(strcmp($row_eventsRs['hot'],"Yes"))) {echo "checked=\"checked\"";} ?>></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Country:</td>
<td bgcolor="#EAFFB7">
<script type="text/javascript">
function ajaxcall(v){
$.ajax({
type	: "GET",
cache	: false,
url		: "/admin/add_events.php?getcity="+v,
data	: $(this).serializeArray(),
success: function(data) {
document.getElementById("city").innerHTML=data
}
});
}
</script>
<select name="country" onchange="ajaxcall(this.value);">
<?php 
do {  
?>
<option value="<?php echo $row_countryRs['countryid']?>" <?php if (!(strcmp($row_countryRs['countryid'], $row_eventsRs['country']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['name']?></option>
<?php
} while ($row_countryRs = mysql_fetch_assoc($countryRs));
?>
</select>                  </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">City:</td>
<td bgcolor="#EAFFB7">
<select name="city" id="city">
<?php 
do {  
?>
<option value="<?php echo @$cities['id']?>" <?php if (!(strcmp( @$cities['id'], $row_eventsRs['city']))) {echo "SELECTED";} ?>><?php echo @$cities['name']?></option>
<?php
} while ($cities = mysql_fetch_assoc($citysql));
?>
</select>                  </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Event Category:</td>
<td bgcolor="#EAEAFF">
<select name="category" class="formField" style="width:150px">
<option value="0" >Select Category</option>
<?php 
while ($category = mysql_fetch_assoc($category_query)) {  
?>
<option value="<?php echo $category['id']?>" <?php if($row_eventsRs['category']==$category['id']){echo "selected";}?>><?php echo $category['name']?></option>
<?php
} 
?>
</select>  
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Promoter:</td>
<td bgcolor="#EAFFB7"><select name="promoter">
<?php 
do {  
?>
<option value="<?php echo $row_promotersRs['spid']?>" <?php if (!(strcmp($row_promotersRs['spid'], $row_eventsRs['promoter']))) {echo "SELECTED";} ?>><?php echo $row_promotersRs['name']?></option>
<?php
} while ($row_promotersRs = mysql_fetch_assoc($promotersRs));
?>
</select>
</td>
</tr>

<tr valign="baseline">
    <td align="right" nowrap bgcolor="#DFFF95">Partner:</td>
    <td bgcolor="#EAFFB7"><select name="partner">
            <?php
            do {
                ?>
                <option value="<?php echo $row_partnersRs['spid']?>" <?php if (!(strcmp($row_partnersRs['spid'], $row_eventsRs['partner']))) {echo "SELECTED";} ?>><?php echo $row_partnersRs['name']?></option>
            <?php
            } while ($row_partnersRs = mysql_fetch_assoc($partnersRs));
            ?>
        </select>
    </td>
</tr>

<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Loc_map:</td>
<td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['loc_map']; ?>" target="_blank"><?php echo $row_eventsRs['loc_map']; ?>
<input name="ulocmap" type="hidden" id="ulocmap" value="<?php echo $row_eventsRs['loc_map']; ?>" />
<br />
<input name="locmap" type="file" class="formField" id="locmap" />
</a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Floorplan:</td>
<td bgcolor="#EAFFB7"><a href="../data/<?php echo $row_eventsRs['floorplan']; ?>" target="_blank"><?php echo $row_eventsRs['floorplan']; ?>
<input name="ufloorplan" type="hidden" id="ufloorplan" value="<?php echo $row_eventsRs['floorplan']; ?>" />
<br />
<input name="floorplan" type="file" class="formField" id="floorplan" />
</a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Event:</td>
<td bgcolor="#EAFFB7"><!--<input type="checkbox" name="ongoing" value="Yes"  <?php //if (!(strcmp($row_eventsRs['ongoing'],"Yes"))) {echo "checked=\"checked\"";} ?>>-->
<select name="ongoing" class="formField" >
<?php
$ongoingValue=$row_eventsRs['ongoing'];
if($ongoingValue == ONGOING )
{
?>
<option value="<?php echo ONGOING?>" selected="selected">On Going</option>
<option value="<?php echo UPCOMING?>">Up Coming</option>
<option value="<?php echo GUEST?>">Guest List</option>
<option value="<?php echo OUTANDABOUT?>">Out & About</option>
<?php	
}
else if ($ongoingValue == UPCOMING )
{
?>
<option value="<?php echo ONGOING?>">On Going</option>
<option value="<?php echo UPCOMING?>" selected="selected">Up Coming</option>
<option value="<?php echo GUEST?>">Guest Line</option>
<option value="<?php echo OUTANDABOUT?>">Out & About</option>
<?php
}
else if ($ongoingValue == GUEST )
{
?>
<option value="<?php echo ONGOING?>">On Going</option>
<option value="<?php echo UPCOMING?>">Up Coming</option>
<option value="<?php echo GUEST?>" selected="selected">Guest Line</option>
<option value="<?php echo OUTANDABOUT?>">Out & About</option>
<?php
}
else if ($ongoingValue == OUTANDABOUT)
{
?>
<option value="<?php echo ONGOING?>">On Going</option>
<option value="<?php echo UPCOMING?>">Up Coming</option>
<option value="<?php echo GUEST?>">Guest Line</option>
<option value="<?php echo OUTANDABOUT?>"  selected="selected">Out & About</option>
<?php
}
?>
</select>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">DTCM Approved:</td>
<td bgcolor="#EAEAFF">
<?php 
if($row_eventsRs['dtcm_approved'] == 'Yes') {
	$checked='checked="checked"';	
} else {
	$checked = '';
}?>
<input type="checkbox" name="dtcm_approved" id="dtcm_approved" value="Yes"  class="formField" onclick="toggle_code();" <?php echo $checked;?>>

</td>
</tr>
<?php 
if($row_eventsRs['dtcm_approved'] == 'Yes') {
	$display='display: block;';	
} else {
	$display='display: none;';
}?>
<tr valign="baseline" id="code_block" style="<?php echo $display;?>">
<td align="right" nowrap bgcolor="#CCCCCC">DTCM Code:</td>
<td bgcolor="#EAEAFF"><input type="text" name="dtcm_code" id="dtcm_code" value="" size="32" class="formField">
<input type="text" readonly="readonly" name="dtcm_code_valid" id="dtcm_code_valid" value="Invalid" size="32" class="formField">
 </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Session_hour:</td>
<td bgcolor="#EAFFB7"><input type="text" name="session_hour" value="<?php echo $row_eventsRs['session_hour']; ?>" size="32"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Doors_open:</td>
<td bgcolor="#EAFFB7"><input type="text" name="doors_open" value="<?php echo $row_eventsRs['doors_open']; ?>" size="32"></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">Sale_date:</td>
<td bgcolor="#EAFFB7"><input type="text" name="sale_date" id="sale_date" value="<?php if($row_eventsRs['sale_date']){echo getddate($row_eventsRs['sale_date']);} ?>" size="32" readonly>
<a href="javascript:NewCal('sale_date','mmddyyyy')"><img src="../images/cal.gif" width="16" height="16" border="0" alt="Pick a date" onmouseover="this.style.cursor = 'hand';" onmouseout="this.style.cursor = 'default';" /></a></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Time Start:</td>
<td bgcolor="#EAEAFF"><input type="text" name="time_start" id="time_start" value="<?php echo $row_eventsRs['time_start']; ?>" size="32" class="formField" >
HH:MM &nbsp;
<?php $timeStartPart = $row_eventsRs['time_start_part'];?>
<select name="drpTimeStartPart">
<?php
if($timeStartPart == "AM")
{
?>
<option value="AM" selected="selected">AM</option>
<option value="PM">PM</option>
<?php
}
else
{
?>
<option value="AM">AM</option>
<option value="PM" selected="selected">PM</option>
<?php
}
?>	
</select>
</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Time End:</td>
<td bgcolor="#EAEAFF"><input type="text" name="time_end" id="time_end" value="<?php echo $row_eventsRs['time_end']; ?>" size="32" class="formField" > HH:MM &nbsp;<?php $timeEndPart = $row_eventsRs['time_end_part'];?>
<select name="drpTimeEndPart">
<?php
if($timeEndPart == "AM")
{
?>
<option value="AM" selected="selected">AM</option>
<option value="PM">PM</option>
<?php
}
else
{
?>
<option value="AM">AM</option>
<option value="PM" selected="selected">PM</option>
<?php
}
?>	
</select>
</td>
</tr>
<tr valign="baseline" >
<td align="right" nowrap bgcolor="#CCCCCC">Facebook Link:</td>
<td bgcolor="#EAEAFF"><input type="text" name="fb_link" value="<?php echo $row_eventsRs['fb_link']; ?>" size="32" class="formField">
 </td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Payment Option:</td>
<td bgcolor="#EAEAFF">
<select name="payment_option" class="formField" >
<option value="all" <?php echo ($row_eventsRs['payment_option']=='all')?'selected="selected"':'';?>>All</option>
<option value="creditcard" <?php echo ($row_eventsRs['payment_option']=='creditcard')?'selected="selected"':'';?>>Credit Card</option>
<option value="cod" <?php echo ($row_eventsRs['payment_option']=='cod')?'selected="selected"':'';?>>Payment on delivery</option>
</select>
</td>
</tr>
<?php
$videoName = "";
if($row_eventsRs['videoName'] != "")
{
$videoName= $row_eventsRs['videoName'];
}
$audioName = "";
if($row_eventsRs['audioName'] != "")
{
$audioName= $row_eventsRs['audioName'];
}
?>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Upload Video:</td>
<td bgcolor="#EAEAFF"><input type="file" name="file_video" id="file_video"  class="formField" >
&nbsp;(Only .flv extension files)
<input type="hidden" name="hidVideo" value="<?php echo $videoName; ?>" />
<?php
if($videoName!="")
{
?>
&nbsp;<a href="#" onClick="openVideoPlayer();">View Video</a>
<?php
}
?></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Upload Audio:</td>
<td bgcolor="#EAEAFF"><input type="file" name="file_audio" id="file_audio"  class="formField" >
&nbsp;(Only .mp3 extension files)
<input type="hidden" name="hidAudio" value="<?php echo $audioName; ?>" />
<?php
if($audioName!="")
{
?>
<a href="#" onClick="openAudioPlayer();">Listen Audio</a>
<?php
}
?></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Voucher Image:</td>
<td bgcolor="#EAEAFF">
<a href="../data/<?php echo $row_eventsRs['voucher_image']; ?>" target="_blank" >
<?php echo $row_eventsRs['voucher_image']; ?>
</a>
<input name="uvoucherimage" type="hidden" id="uvoucherimage" value="<?php echo $row_eventsRs['voucher_image']; ?>" />
<br />
<input name="voucherimage" type="file" class="formField" id="voucherimage" />
</td>
</tr>
<tr valign="baseline">
<td align="left" nowrap bgcolor="#EAFFB7" colspan="2" style=" padding-left: 188px; font-weight: bold; height: 25px; vertical-align: middle;">Sponsor Logos</td>
</td>
</tr>
<?php for($i=1;$i<=8;$i++){ ?>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Sponsor Logo<?php echo $i;?>:</td>
<td bgcolor="#EAEAFF">
<a href="../data/<?php echo $row_eventsRs['sponsor_logo'.$i]; ?>" target="_blank" >
<?php echo $row_eventsRs['sponsor_logo'.$i]; ?>
</a>
<input name="usponsor_logo<?php echo $i;?>" type="hidden" id="usponsor_logo<?php echo $i;?>" value="<?php echo $row_eventsRs['sponsor_logo'.$i]; ?>" />
<br />
<input name="sponsor_logo<?php echo $i;?>" type="file" class="formField" id="sponsor_logo<?php echo $i;?>" />
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
<td bgcolor="#EAEAFF">
<a href="../data/<?php echo $row_eventsRs['event_pic'.$i]; ?>" target="_blank" >
<?php echo $row_eventsRs['event_pic'.$i]; ?>
</a>
<input name="uevent_pic<?php echo $i;?>" type="hidden" id="uevent_pic<?php echo $i;?>" value="<?php echo $row_eventsRs['event_pic'.$i]; ?>" />
<br />
<input name="event_pic<?php echo $i;?>" type="file" class="formField" id="event_pic<?php echo $i;?>" />
</td>
</tr>
<?php } ?>
<tr valign="baseline">
<td align="left" nowrap bgcolor="#EAFFB7" colspan="2" style=" padding-left: 188px; font-weight: bold; height: 25px; vertical-align: middle;">Voucher Advert</td>
</td>
</tr>
<?php for($i=1;$i<=2;$i++){ ?>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Voucher Advert<?php echo $i;?>:</td>
<td bgcolor="#EAEAFF">
<a href="../data/<?php echo $row_eventsRs['voucher_advert'.$i]; ?>" target="_blank" >
<?php echo $row_eventsRs['voucher_advert'.$i]; ?>
</a>
<input name="uvoucher_advert<?php echo $i;?>" type="hidden" id="uvoucher_advert<?php echo $i;?>" value="<?php echo $row_eventsRs['voucher_advert'.$i]; ?>" />
<br />
<input name="voucher_advert<?php echo $i;?>" type="file" class="formField" id="voucher_advert<?php echo $i;?>" />
</td>
</tr>
<?php } ?>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Commission charges:</td>
<td bgcolor="#EAEAFF"><input name="commissionCharges" type="text" class="formField" value="<?php if(!empty($row_eventsRs['commission'])){echo $row_eventsRs['commission'];}?>" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">DTCM charges:</td>
<td bgcolor="#EAEAFF"><input name="dtcm" type="text" class="formField" value="<?php if(!empty($row_eventsRs['dtcm'])){echo $row_eventsRs['dtcm'];}?>" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Credit Charges:</td>
<td bgcolor="#EAEAFF"><input name="creditCharge" type="text" class="formField" value="<?php if(!empty($row_eventsRs['credit_charge'])){echo $row_eventsRs['credit_charge'];}?>" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Service Charges:</td>
<td bgcolor="#EAEAFF"><input name="serviceCharge" type="text" class="formField" value="<?php if(!empty($row_eventsRs['service_charge'])){echo $row_eventsRs['service_charge'];}?>" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
    <td align="right" nowrap bgcolor="#CCCCCC">Partner Commission:</td>
    <td bgcolor="#EAEAFF"><input name="partnerCommission" type="text" class="formField" value="<?php if(!empty($row_eventsRs['partner_commission'])){echo $row_eventsRs['partner_commission'];}?>" size="15"></td>
    <td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#DFFF95">&nbsp;</td>
<td bgcolor="#EAFFB7"><input type="submit" value="Update Event" id="update_event"></td>
</tr>
</table>
<input type="hidden" name="tid" value="<?php echo $row_eventsRs['tid']; ?>">
<input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p></td>
<td width="5" valign="top">&nbsp;</td>
<td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
</table>

</td>
</tr>
<tr>

<td  valign="top"><form method="post" name="form2" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td height="35" bgcolor="#C31600">&nbsp;<span class="eventHeader">EVENT PRICE </span></td>
</tr>
<tr>
<td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
</tr>
</table>
<div id="inputoptions">
<?php  if($totalRows_priceRs>0){
while($prices=mysql_fetch_assoc($priceRs)){
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventText">
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Seat Type:</td>
<td bgcolor="#EAEAFF">
<select name="stand[]">
<option value="">Select Seat Type</option>
<?php foreach($seat_type_arr as $key=>$seat){?>
<option value="<?php echo $key;?>" <?php if($key==$prices['stand']){echo "selected";}?>><?php echo $seat;?></option>
<?php }?>
</select>
</td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline" ><td align="right" nowrap bgcolor="#CCCCCC">Adult Price:</td><td bgcolor="#EAEAFF"><input name="price[]" type="text" class="formField" value="<?php echo $prices['price'];?>" size="15"></td><td bgcolor="#EAEAFF">&nbsp;</td></tr>
<tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Adult Seats Per User:</td><td bgcolor="#EAEAFF"><input name="ticket_per_user[]" type="text" class="formField" id="ticket_per_user" value="<?php echo $prices['ticket_per_user'];?>" size="15" /></td><td bgcolor="#EAEAFF">No or Tickets:<input name="tickets[]" type="text" id="tickets" size="15" value="<?php echo $prices['tickets'];?>"/></td></tr>
<tr valign="baseline"><td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Child Price:</td><td bgcolor="#EAEAFF"><input name="cprice[]" type="text" class="formField" id="cprice" value="<?php echo $prices['cprice'];?>" size="15" /></td><td bgcolor="#EAEAFF">&nbsp;</td></tr>
<tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Child Seats Per User:</td><td bgcolor="#EAEAFF"><input name="cticket_per_user[]" type="text" class="formField" id="cticket_per_user" value="<?php echo $prices['cticket_per_user'];?>" size="15" /></td><td bgcolor="#EAEAFF">No or Tickets:<input name="ctickets[]" type="text" id="ctickets" size="15" value="<?php echo $prices['ctickets'];?>" /></td></tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Currency:</td>
<td bgcolor="#EAEAFF"><input name="currency[]" type="text" class="formField" size="15" value="<?php echo $prices['currency'];?>" ></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
<td bgcolor="#EAEAFF"><input type="submit" value="Update Price"><input type="hidden" name="price_id[update][]" value="<?php echo $prices['pid'];?>"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
</table>
<?php  }}else{?>
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
<tr valign="baseline" ><td align="right" nowrap bgcolor="#CCCCCC">Adult Price:</td><td bgcolor="#EAEAFF"><input name="price[]" type="text" class="formField" value="" size="15"></td><td bgcolor="#EAEAFF">&nbsp;</td></tr>
<tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Adult Seats Per User:</td><td bgcolor="#EAEAFF"><input name="ticket_per_user[]" type="text" class="formField" id="ticket_per_user" value="" size="15" /></td><td bgcolor="#EAEAFF">No or Tickets:<input name="tickets[]" type="text" id="tickets" size="15" /></td></tr>
<tr valign="baseline"><td align="right" nowrap="nowrap" bgcolor="#CCCCCC">Child Price:</td><td bgcolor="#EAEAFF"><input name="cprice[]" type="text" class="formField" id="cprice" value="" size="15" /></td><td bgcolor="#EAEAFF">&nbsp;</td></tr>
<tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Child Seats Per User:</td><td bgcolor="#EAEAFF"><input name="cticket_per_user[]" type="text" class="formField" id="cticket_per_user" value="" size="15" /></td><td bgcolor="#EAEAFF">No or Tickets:<input name="ctickets[]" type="text" id="ctickets" size="15" /></td></tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">Currency:</td>
<td bgcolor="#EAEAFF"><input name="currency[]" type="text" class="formField" value="" size="15"></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
<td bgcolor="#EAEAFF"><input type="submit" value="Add Price"><input type="hidden" name="price_id[insert][]" value=""/></td>
<td bgcolor="#EAEAFF">&nbsp;</td>
</tr>
</table>
<?php  }?>
</div>
<input type="button" id="btnAdd" value="Add More Prices" style="background: #069;color: #fff;border: none;padding: 5px 10px;font-size: 14px;margin: 10px 0 0 175px;cursor:pointer;" />
<input type="hidden" name="MM_update" value="form2">
</form>
</td>
</tr>

<?php   
$query_extra_services = sprintf("SELECT * FROM event_services WHERE event_id = %s", $_GET['tid']);
$extra_services = mysql_query($query_extra_services, $eventscon) or die(mysql_error());

?>

<tr>
<td  valign="top"><form method="post" name="form3" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<td height="35" bgcolor="#C31600">&nbsp;<span class="eventHeader">EVENT SERVICES </span></td>
</tr>
<tr>
<td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
</tr>
</table>
<?php 
$services_count= 0;
while ($row = mysql_fetch_array($extra_services, MYSQL_ASSOC)) { 
	$services_count++;
 ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr valign="baseline"  ><td align="right" nowrap bgcolor="#CCCCCC">Service Name:</td><td bgcolor="#EAEAFF">
<input type="hidden" name="service_ids[]" value="<?php echo $row['id']; ?>"  />
<input name="service_name[]" type="text" class="formField" value="<?php echo $row['title']; ?>" size="100"></td></tr>
<tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Service Price:</td><td bgcolor="#EAEAFF"><input name="service_price[]" type="text" class="formField" id="ticket_per_user" value="<?php echo $row['price']; ?>" size="15" /></td></tr>
</table>

	
<?php }?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="eventServicestable">
<tbody class="first">
<tr valign="baseline"  ><td align="right" nowrap bgcolor="#CCCCCC">Service Name:</td><td bgcolor="#EAEAFF"><input name="service_name[]" type="text" class="formField" value="" size="100"></td></tr>
<tr valign="baseline"><td align="right" nowrap bgcolor="#CCCCCC">Service Price:</td><td bgcolor="#EAEAFF"><input name="service_price[]" type="text" class="formField" id="ticket_per_user" value="" size="15" /></td></tr>
</tbody>
<tfoot>
<tr valign="baseline">
<td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
<td bgcolor="#EAEAFF">
<?php if($services_count==0) { ?>
<input type="submit" value="Add Service">
<?php }else{ ?>
<input type="submit" value="Update Services">
<?php } ?>
</td>
</tr>
</tfoot>
</table>
<input type="button" id="btnAddSer" value="Add More Services" style="background: #069;color: #fff;border: none;padding: 5px 10px;font-size: 14px;margin: 10px 0 0 175px;cursor:pointer;" />
</form>
</td>

</tr>



</table></td>
</tr>
</table>
<script type="text/javascript">
$('#btnAddSer').on('click',function(){
	var html = $('.eventServicestable .first').html();
	$('.eventServicestable').append(html);
});
function toggle_code(){
	if(document.getElementById('dtcm_approved').checked) {
	    $("#code_block").show();
		$("#inputoptions").find('*').attr('disabled','disabled');
		$(".eventHeader").text('EVENT PRICE (DTCM Defined)');
		jQuery('#update_event').attr('disabled','disabled');
	} else {
	    $("#code_block").hide();
		$("#inputoptions").find('*').removeAttr('disabled');
		$(".eventHeader").text('EVENT PRICE');
		jQuery('#update_event').removeAttr('disabled');
	}
}
</script>
</body>
</html>
<?php
mysql_free_result($promotersRs);
mysql_free_result($countryRs);
mysql_free_result($eventsRs);
mysql_free_result($priceRs);
mysql_free_result($alleventsRs);
?>