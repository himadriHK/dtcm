<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
$pageName = "Login";
$errorCount = 0;
$messageText = "";

if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if(isset($_POST['submit'])) {
	$userName = $_POST['username'];
	$userPassword = md5($_POST['password']);

	if(!empty($userName) && !empty($userPassword)) {
		$qry = "SELECT * FROM event_admin 
				WHERE login='".sqlSafe($userName)."' 
				AND password='".sqlSafe($userPassword)."' 
				LIMIT 1";
			  
		$res = mysqli_query($conn, $qry);
		if(mysqli_num_rows($res) > 0) {
			
			//get user detail and create session
			$row = mysqli_fetch_array($res);
			$_SESSION['Username'] = $userName;
			$_SESSION['UserId'] = $row['adminID'];
			$_SESSION['UserGroup'] = "";
			
			if(isset($_SESSION['PrevUrl']) && !empty($_SESSION['PrevUrl'])) {
				header("LOCATION: ".$_SESSION['PrevUrl']);
			} else {
				header("LOCATION: index.php");
			}
			exit();
			
		} else {
			
			$errorCount++;
			$messageText = '<div class="alert alert-error">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="icon-minus-sign"></i><strong>Warning!</strong> Invalid Username/Password!
							</div>';
				
		}
	
	} else {
		
		$errorCount++;
		$messageText = '<div class="alert alert-error">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<i class="icon-minus-sign"></i><strong>Warning!</strong> Invalid Username/Password!
						</div>';
			
	}
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Login</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	// validate login form on keyup and submit
	$("#loginForm").validate({
		rules: {
			username: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			}
		},
		messages: {
			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			}
		}
	});	
});
</script>
</head>
<body>
<div class="layout">
	<?php include_once("navbar_top.php")?>
	
	<div class="container">
		<form method="post" id="loginForm" class="form-signin">
			<h3 class="form-signin-heading">Please sign in</h3>
			<div class="controls input-icon">
				<i class=" icon-user-md"></i>
				<input type="text" id="username" name="username" class="input-block-level" placeholder="User Name">
			</div>
			<div class="controls input-icon">
				<i class=" icon-key"></i>
                <input type="password" id="password" name="password" class="input-block-level" placeholder="Password">
			</div>
			<button class="btn btn-inverse btn-block" type="submit" id="submit" name="submit">Sign in</button>
		</form>
        
        <div style="width:342px; margin:0 auto;">
        <?php
        if(isset($errorCount) && ($errorCount > 0) && !empty($messageText)) {
			echo $messageText;	
		}
		?>
        </div>
	</div>
</div>
</body>
</html>