<?php require_once('header.php'); 

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

		$_SESSION['error']='Your email address is not registered.';

	}

	else if($result['password']!==md5($password)){

		$_SESSION['error']='Wrong password entered.';

	}

	else{

		$_SESSION['Customer']=$result;

		if($_SESSION['referer']){

			$referer=$_SESSION['referer'];

			unset($_SESSION['referer']);

			header("location:".$referer);

		}else

		header("location:index.php");

	}

}

$country_sql="SELECT * FROM country ORDER BY id ASC";

$country_query = mysql_query($country_sql, $eventscon) or die(mysql_error());



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

<h1>Sign In</h1>

<div class="shows-box-frames">

 <form action="" method="post" id="validate_signup">

<table width="100%" border="0" cellspacing="1" cellpadding="4">



                      <tbody>



                      <tr>



                        <td width="185" valign="middle" align="left" class="eventVenue">Email:</td>



                        <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="email" class="formField" name="email" style="width:50%;"></td>

                      </tr>



                      <tr>



                        <td width="185" valign="middle" align="left" class="eventVenueWhite">Password:</td>



                        <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="password" id="password" class="formField" name="password"  style="width:50%;"></td>

                      </tr>





                      <tr>



                        <td width="185" valign="middle" align="left" class="eventVenue"><input type="hidden" value="124" id="eid" name="eid"></td>



                        <td width="288" valign="top" align="left" class="eventText">

<input type="submit" style="background: none repeat scroll 0 0 #B13C4F; border: medium none; border-radius: 3px 3px 3px 3px;    color: #FFFFFF;    padding: 5px 20px; cursor:pointer;float:left;" value="Login" id="SubButL" name="SubButL">&nbsp;<a href="forgot_password.php" style="float:left; padding:5px 0; margin-left:5px;font-weight:normal !important;">Forgot Pasword?</a></td>

                      </tr>
					<tr>



                        <td width="185" valign="middle" align="left" class="eventVenue">&nbsp;</td>



                        <td width="288" valign="top" align="left" class="eventText">
						<span style="float:left; padding:5px 0; margin-right:5px;">Not a member?</span>
<a style="background: none repeat scroll 0 0 #B13C4F; border: medium none;border-radius: 3px 3px 3px 3px; color: #FFFFFF;padding: 5px 20px; cursor:pointer;" href="signup.php">Register </a></td>

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

