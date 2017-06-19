<?php
/**
 * //License information must not be removed.
 * PHP version 5.2x
 *
 * @category	### Gripsell ###
 * @package		### Advanced ###
 * @arch		### Secured  ###
 * @author 		Development Team, Gripsell Technologies & Consultancy Services
 * @copyright 	Copyright (c) 2010 {@URL http://www.gripsell.com Gripsell Tech}
 * @license		http://www.gripsell.com Clone Portal
 * @version		4.3.3
 * @since 		2011-11-16
 */
require_once('facebook/facebook.php');
require_once('facebook.php');
	

// Create our Application instance.
	$facebook = new FacebookB(array(
  	'appId' => APIKEY,
  	'secret' => SECRET,
  	'cookie' => false,
	));
	
	

// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
	//$session = $facebook->getSession();
$uid = $facebook->getUser();
		$userinfo = null;
		// Session based API call.
		
		if ($uid) {
		  try {
			
			$userinfo = $facebook->api('/me');

		  } catch (FacebookApiException $e) {
			error_log($e);
		  }
		}
// login or logout url will be needed depending on current user state.
		if ($userinfo) {
			if (strpos($_SERVER['PHP_SELF'], "/index.php") > 1) $current_folder = substr($_SERVER['PHP_SELF'], 1, strpos($_SERVER['PHP_SELF'], "/index.php") - 1);
$project_name_url = ltrim(rtrim($current_folder, "/"), "/");
		  $logoutUrl = $facebook->getLogoutUrl();
		  	 $pageURL = 'http';
			 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			 $pageURL .= "://";
			 if ($_SERVER["SERVER_PORT"] != "80") {
			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
			 } else {
			  $pageURL .= $_SERVER["SERVER_NAME"];
			 }
			 if($project_name_url=='')
			$_SESSION['FBCONNECT_LOGOUT_URL'] ='https://www.facebook.com/logout.php?next='.$pageURL.'/signout.php?&access_token='.$facebook->getAccessToken();
			else
			$_SESSION['FBCONNECT_LOGOUT_URL'] ='https://www.facebook.com/logout.php?next='.$pageURL.'/'.$project_name_url.'/signout.php?&access_token='.$facebook->getAccessToken();
		} else {
		  $loginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
		}

	
		
		if($userinfo && empty($_SESSION['Customer'])) {
			
			$api_client = new FacebookRestClient(APIKEY, SECRET, null);
			$user_details = $userinfo;
			$fb_id=$user_details['id'];
			$sql="select * from customers where facebook_uid='$fb_id'";
			$query= mysql_query($sql, $eventscon) or die(mysql_error());
			$userExist= mysql_fetch_array($query);
			
			if($userExist) {
				$user_id=$cust_id = $userExist['cust_id'];
				$sql="SELECT * FROM `customers` where `cust_id`='".$cust_id."'";
				$query=mysql_query($sql,$eventscon);
				$result=mysql_fetch_assoc($query);
				$_SESSION['Customer']=$result;
				$fname=$user_details['first_name'];
				$lname=$user_details['last_name'];
				$sql="update customers set fname='$fname',lname='$lname' where cust_id='$cust_id'";
				mysql_query($sql, $eventscon) or die(mysql_error());
			} else {
				$email=$user_details['email'];
				$sql="select * from customers where email='$email'";
				$query= mysql_query($sql, $eventscon) or die(mysql_error());
				$normalUserExist= mysql_fetch_array($query);
			 
			  if($normalUserExist) {
			    $user_id= $cust_id = $normalUserExist['cust_id'];
				$sql="SELECT * FROM `customers` where `cust_id`='".$cust_id."'";
				$query=mysql_query($sql,$eventscon);
				$result=mysql_fetch_assoc($query);
				$_SESSION['Customer']=$result;
				 $fbid=$user_details['id'];
				 $sql="update customers set facebook_uid='$fbid' where cust_id='$cust_id'";
				 mysql_query($sql, $eventscon) or die(mysql_error());
			  }
			  else{
				 
				$user_row['password'] =  md5(time());
				$user_row['date_added'] = date('Y-m-d H:i:s');
				//$user_row['gender'] = $user_details['gender']=='male' ? 'M' : 'F';
				$user_row['fname'] = $user_details['first_name'];
				$user_row['lname'] = $user_details['last_name'];
				$user_row['facebook_uid'] = $user_details['id'];
				$user_row['email'] 			= $user_details['email'];
				$data='';
				$field_val='';
				foreach($user_row as $key=>$val){
					$field_val.="`".$key."`,";
					$data.="'".$val."',";
				}
				$data=trim($data,',');
				$field_val=trim($field_val,',');
				$sql="insert into customers ($field_val) values ($data)";
				 mysql_query($sql, $eventscon) or die(mysql_error());
				$cust_id=$user_id=mysql_insert_id();
				$sql="SELECT * FROM `customers` where `cust_id`='".$cust_id."'";
				$query=mysql_query($sql,$eventscon);
				$result=mysql_fetch_assoc($query);
				$_SESSION['Customer']=$result;
				
			}
		}
		
	}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/helen');

$strSelectedProfiles	=	@$_REQUEST["selected_profiles"];

?>

<script>
	<?php if($user_id || $strSelectedProfiles || !empty($_SESSION['Customer'])) { ?>
		closefunction();
	<?php } ?>
		
		function closefunction() {
			if (window.opener && !window.opener.closed) {
				window.opener.location.href = 'index.php';
				window.close();
			} 
		}
	
</script>

<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
	FB.init({
	appId : '<?php echo $facebook->getAppId(); ?>',
	session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
	status : true, // check login status
	cookie : true, // enable cookies to allow the server to access the session
	xfbml : true // parse XFBML
	});
	
	// whenever the user logs in, we refresh the page
	FB.Event.subscribe('auth.login', function() {
	window.location.reload();
});
};

(function() {
	var e = document.createElement('script');
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);
	}());
</script>
<script>

function facebookpopup(url){
  var url = url;
  window.open(url,'name','height=411,width=635,left=0,top=0,resizable=yes,scrollbars=yes,toolbar=no,status=yes')
}

</script>

<?php if($userinfo=='') { ?>
	<a style="cursor:pointer;" onClick="facebookpopup('<?php echo $loginUrl; ?>');">
		<img src="img/fb_login.png" class="fblogin" />
	</a>
<?php } ?>