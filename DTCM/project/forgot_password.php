<?php require_once('header.php'); 
 include("functions.php"); 
mysql_select_db($database_eventscon, $eventscon);
if(!empty($_SESSION['Customer']))header("location:index.php");
if(!empty($_POST))
{
	foreach($_POST as $key=>$val)
	{
		$_POST[$key]=mysql_real_escape_string($val);
	}
	$email=$_POST['email'];$password=$_POST['password'];
	$sql="SELECT * FROM `customers` where `email`='".$email."'";
	$query=mysql_query($sql,$eventscon);
	$result=mysql_fetch_assoc($query);
	if(empty($result))
	{
		$_SESSION['error']="Email address does not exist!";
		header("location:forgot_password.php");exit;
	}else{
	$password=getRandomCode();
	$body = "Please find below your reset pasword\n";	
	$body .="Account profile password: ".$password."\n";	
	$body .="You can change this password in My Account page\n";
	$to = $_POST['email'];
	$subject = "Account Password";
	$headers = "From: Ticket Masters <nasser@ticketmasters.me>\n";
	$headers .= "Reply-To: Ticket Masters <nasser@ticketmasters.me>\n";
	$headers .= "Cc: Ticket Masters <nasser@ticketmasters.me>\n";
	$headers .= "MIME-Version: 1.0\n";
	$mail_sent = @mail( $to, $subject, $body, $headers );
		if($mail_sent)
		{
			$password=md5($password);
			$sql="UPDATE `customers` SET password='{$password}' where `email`='".$email."'";
			$query=mysql_query($sql,$eventscon);
			$_SESSION['success']="Your password has been reset successfully. Please check your email address for more details.";
			header("location:forgot_password.php");exit;
		}
	}
}

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
<?php if($_SESSION['success']){?><h2 style="color:#006666;font-size: 21px;padding: 14px 0 12px;"><?php echo $_SESSION['success'];unset($_SESSION['success']);?></h2><?php }?>
<?php if($_SESSION['error']){?><h2 style="color:#FF0000;font-size: 21px;padding: 14px 0 12px;"><?php echo $_SESSION['error'];unset($_SESSION['error']);?></h2><?php }?>
<h1>Forgot Password</h1>
<div class="shows-box-frames">
 <form action="" method="post" id="validate_signup">
<table width="100%" border="0" cellspacing="1" cellpadding="4">

                      <tbody>

                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenue">Email:</td>

                        <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="email" class="formField" name="email" style="width:50%;"></td>
                      </tr>


                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenue">&nbsp;</td>

                        <td width="288" valign="top" align="left" class="eventText">
<input type="submit" style="background: none repeat scroll 0 0 #B13C4F; border: medium none;
    border-radius: 3px 3px 3px 3px;    color: #FFFFFF;    padding: 5px 20px; cursor:pointer;" value="Send Password" id="SubButL" name="SubButL"></td>
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
