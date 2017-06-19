<?php require_once('header.php'); 
mysql_select_db($database_eventscon, $eventscon);
if(empty($_SESSION['Customer']))header("location:signin.php");
if(!empty($_POST))
{
	foreach($_POST as $key=>$val)
	{
		$_POST[$key]=mysql_real_escape_string($val);
	}
	
	$fname=$_POST['fname'];$lname=$_POST['lname'];$mobile=$_POST['mobile'];$email=$_POST['email'];$password=md5($_POST['password']);$city=$_POST['city'];
		$country=$_POST['country'];$address=$_POST['address'];
		

	if(($_POST['password']!=$_POST['confirmPassword']) && $_POST['password']!='' && $_POST['confirmPassword']!='')
	{
		$_SESSION['error']='Password does not match with confirm password.';
	}
	else{
		$string='';
		$cust_id=$_SESSION['Customer']['cust_id'];
		$email=$_SESSION['Customer']['email'];
		if($fname!='')$string.=" `fname`='$fname',";
		if($lname!='')$string.=" `lname`='$lname',";
		if($mobile!='')$string.=" `mobile`='$mobile',";
		if($password!='')$string.=" `password`='$password',";
		if($city!='')$string.=" `city`='$city',";
		if($country!='')$string.=" `country`='$country',";
		if($address!='')$string.=" `address`='$address',";
		$string=trim($string,",");
		$sql="UPDATE `customers` set $string where `cust_id`='$cust_id'";
	
		$result=mysql_query($sql,$eventscon);
		if($result){
			$sql="SELECT * FROM `customers` where `email`='".$email."'";
			$query=mysql_query($sql,$eventscon);
			$result=mysql_fetch_assoc($query);
			$_SESSION['Customer']=$result;
		$_SESSION['success']='Profile updated successfully.';
		}
		else
		$_SESSION['error']='Error occured!.';
		
	}
}
$country_sql="SELECT * FROM country ORDER BY id ASC";
$country_query = mysql_query($country_sql, $eventscon) or die(mysql_error());
?>


<div class="main-content">
<div class="container">

<?php //require_once('left_content.php'); ?>

<div class="conent-right">
<?php //require_once('banner2.php'); ?>
<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php //require_once('menu.php'); ?>
<div class="shows-box">
<script type="application/javascript">
$(document).ready(function(e) {
    $("#validate_signup").validate();
});

</script>
<?php if($_SESSION['success']){?><h2 style="color:#006666;font-size: 21px;padding: 14px 0 12px 175px;"><?php echo $_SESSION['success'];unset($_SESSION['success']);?></h2><?php }?>
<?php if($_SESSION['error']){?><h2 style="color:#FF0000;font-size: 21px;padding: 14px 0 12px 175px;"><?php echo $_SESSION['error'];unset($_SESSION['error']);?></h2><?php }?>
<h1>Customer Profile</h1>
<div class="shows-box-frames">
 <form action="" method="post"  id="validate_signup">
<table width="100%" border="0" cellspacing="1" cellpadding="4">

                      <tbody>
					<tr>

                        <td width="185" valign="middle" align="left" class="eventVenue">Email:</td>

                        <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="email" disabled="disabled" class="formField" name="email" value="<?php echo $_SESSION['Customer']['email'];?>"></td>
                      </tr>
                       <tr>

                        <td width="185" valign="middle" align="left" class="eventVenueWhite">Password:</td>

                        <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="password" id="password" class="formField" name="password"></td>
                      </tr>
                       <tr>

                        <td width="185" valign="middle" align="left" class="eventVenueWhite">Confirm Password:</td>

                        <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="password" id="confirmPassword" class="formField" name="confirmPassword"></td>
                      </tr>
                      
                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenueWhite ">First Name: </td>

                        <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="text" id="fname" class="formField required" name="fname" value="<?php echo $_SESSION['Customer']['fname'];?>"></td>
                      </tr>

                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenue ">Last Name: </td>

                        <td width="288" valign="top" align="left" class="eventText full_width"><input type="text" id="lname" class="formField required" name="lname" value="<?php echo $_SESSION['Customer']['lname'];?>"></td>
                      </tr>
					  
					  <tr>

                        <td width="185" valign="middle" align="left" class="eventVenue">Address: </td>

                        <td width="288" valign="top" align="left" class="eventText full_width"><textarea cols="22" rows="5" name="address" class="required"><?php echo $_SESSION['Customer']['address'];?></textarea></td>
                      </tr>

                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenueWhite">Mobile:</td>

                        <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="text" id="mobile" class="formField mobile required" name="mobile" value="<?php echo $_SESSION['Customer']['mobile'];?>"></td>
                      </tr>


                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenueWhite">City:</td>

                        <td width="288" valign="top" align="left" class="eventTextWhite full_width"><input type="text" id="city" class="formField required" name="city" value="<?php echo $_SESSION['Customer']['city'];?>"></td>
                      </tr>

                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenueWhite">Country:</td>

                        <td width="288" valign="top" align="left" class="eventTextWhite full_width">

						<select class="formField required" name="country" style="width: 50%; height: 40px;">
                        <option value="">Select Country</option>
                        <?php while($country=mysql_fetch_assoc($country_query)){?>
                        <option value="<?php echo $country['name'];?>" <?php echo ($_SESSION['Customer']['country']==$country['name'])?"selected":'';?>><?php echo $country['name'];?></option>
                        <?php }?>
                        
                        </select>                       
                         </td>
                      </tr>

                      <tr>

                        <td width="185" valign="middle" align="left" class="eventVenue"><input type="hidden" value="124" id="eid" name="eid"></td>

                        <td width="288" valign="top" align="left" class="eventText" style="padding-top:13px;">
<input type="submit" style="background: none repeat scroll 0 0 #B13C4F; border: medium none;
    border-radius: 3px 3px 3px 3px;    color: #FFFFFF;    padding: 5px 20px; cursor:pointer;" value="Update" id="SubButL" name="SubButL"></td>
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
