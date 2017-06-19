<?php require_once('header.php'); 

mysql_select_db($database_eventscon, $eventscon);

if (isset($_GET['code'])) {
$code = (get_magic_quotes_gpc()) ? $_GET['code'] : addslashes($_GET['code']);
}
else
header("location:index.php");

$code_sql=sprintf("SELECT * FROM ticket_orders where uniquecode='%s' AND downloaded=0 ORDER BY oid DESC",$code);

$code_query = mysql_query($code_sql, $eventscon) or die(mysql_error());
if(mysql_num_rows($code_query)==0)
header("location:index.php");
else
$order_details=mysql_fetch_assoc($code_query);


/*if(!empty($_POST) && $_POST['verifycode']!='')

{
	$verifycode=$_POST['verifycode'];
	
	if(!empty($order_details) && $verifycode==$order_details['verifycode'])

	{

		$_SESSION['success']='You free Voucher has been downloaded';

	}

	else {

		$_SESSION['error']='Invalid Verification code';

	}
	
	header("location:getvoucher.php?code=".$code);exit;

}*/




?>



<div class="main-content">

<div class="container">

<script type="application/javascript">

$(document).ready(function(e) {

    $("#validate_signup").validate();

});



</script>

<?php //require_once('left_content.php'); ?>



<div class="conent-right">

<?php //require_once('banner2.php'); ?>

<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->

<?php //require_once('menu.php'); ?>

<div class="shows-box">

<?php if($_SESSION['success']){?><h2 style="color:#006666;font-size: 21px;padding: 14px 0 12px 175px;"><?php echo $_SESSION['success'];unset($_SESSION['success']);?></h2><?php }?>

<?php if($_SESSION['error']){?><h2 style="color:#FF0000;font-size: 21px;padding: 14px 0 12px 175px;"><?php echo $_SESSION['error'];unset($_SESSION['error']);?></h2><?php }?>

<h1>Free Voucher Download</h1>

<div class="shows-box-frames">

 <form action="voucher_download.php" method="post" id="validate_signup">
<input type="hidden"  name="code" value="<?php echo $code;?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="4">



                      <tbody>



                      <tr>



                        <td width="185" valign="middle" align="left" class="eventVenue">Verification Code:</td>



                        <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="verifycode" class="formField" name="verifycode" style="width:50%;"></td>

                      </tr>


                      <tr>



                        <td width="185" valign="middle" align="left" class="eventVenue">&nbsp;</td>



                        <td width="288" valign="top" align="left" class="eventText">

<input type="submit" style="background: none repeat scroll 0 0 #B13C4F; border: medium none;

    border-radius: 3px 3px 3px 3px;    color: #FFFFFF;    padding: 5px 20px; cursor:pointer;" value="Submit" id="SubButL" name="SubButL"></td>

                      </tr>
					
                    </tbody></table>

 </form>

  </div>

</div>



</div>



</div>

</div>





<?php require_once('footer.php'); ?>



</body>

</html>