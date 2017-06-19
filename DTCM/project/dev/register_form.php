<?php require_once('Connections/eventscon.php'); ?>
<?php include("config.php"); ?>
<?php

require_once('dateclass.php');
$objDate =  new CDate();

mysql_select_db($database_eventscon, $eventscon);

$query_eventRs = "SELECT events.*, promoters.name, promoters.phone  FROM events, promoters WHERE events.promoter = promoters.spid  AND ongoing='".GUEST."' ORDER BY hot ASC, ongoing DESC, tid DESC";	//and sale_date <= CURDATE()
//echo $query_eventRs;
$eventRs = mysql_query($query_eventRs, $eventscon) or die(mysql_error());

$row_eventRs = mysql_fetch_assoc($eventRs);



?>

<?php //include("functions.php"); ?>

<script type="text/JavaScript">

<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0

  window.open(theURL,winName,features);

}

//-->

</script>
<link href="events.css" rel="stylesheet" type="text/css" />
<link href="css/TM_style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript">

<!--
var emailPat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;//to check email
function funRegister()
{
   if(document.frmRegister.fname.value=="")
   {
	alert("Please enter your first name.");
	document.frmRegister.fname.focus();
	return false;
   }

   if(document.frmRegister.lname.value=="")
   {
	alert("Please enter your last name.");
	document.frmRegister.lname.focus();
	return false;
   }
  if(document.frmRegister.mobile.value=="")
   {
	alert("Please enter your mobile number.");
	document.frmRegister.mobile.focus();
	return false;
   }
  if(document.frmRegister.email.value=="")
   {
	alert("Please enter your email address.");
	document.frmRegister.email.focus();
	return false;
   }
  if(!emailPat.test(document.frmRegister.email.value))
   {
	alert("Invalid email address.");
	document.frmRegister.email.focus();
	return false;
   }

  document.frmRegister.action="register1.php";
  document.frmRegister.submit();
}

//-->

</script>


<form action="register1.php" method="POST" name="frmRegister"  >
 
                                        <table width="53%" border="0" cellpadding="4" cellspacing="0" style="margin-left:53px;" class="form_new">
                                          <tr>
                                            <td height="25" align="left" valign="middle" class="eventVenueWhite" style="width:50%;">First Name:</td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" valign="middle" class="eventVenueWhite"><input name="fname" type="text" class="formField" id="fname" size="50" /></td>
                                          </tr>
                                         
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite">Last Name:</td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite"><input name="lname" type="text" class="formField" id="lname" size="50" /></td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite">Email:</td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite"><input name="email" type="text" class="formField" id="email" size="50" /></td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite">Mobile:</td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite"><input name="mobile" type="text" class="formField" id="mobile" size="50" /></td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" class="eventVenueWhite">Number of Guests:</td>
                                          </tr>
                                          <tr>
                                            <td height="25" align="left" valign="middle" class="eventVenueWhite"><input name="noGuest" type="text" class="formField" id="noGuest" size="20" /></td>
                                          </tr>
                                         
                                          <tr>
                                            <td height="25" align="left" valign="middle" class="eventVenue"><input type="hidden" name="hidTid" value="<?php echo $_GET['tid'];?>" />
                                                <input class="reg_btn" name="SubButL" type="BUTTON" value="Register!" onClick="javascript:funRegister();"/></td>
                                          </tr>
                                        </table>
                                      <input type="hidden" name="MM_insert" value="form1">
                                   

 </form>
<?php

mysql_free_result($eventRs);

?>

