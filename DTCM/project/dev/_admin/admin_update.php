<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Update Admin";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Update Admin Password</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			old_password: {
				required: true,
				minlength: 5
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			}
		},
		messages: {
			old_password: {
				required: "Please provide old password",
				minlength: "Your password must be at least 5 characters long"
			},
			password: {
				required: "Please provide a new password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a new password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			}
		}
	});
});
</script>
</head>
<body>
<div class="layout">
	<?php
    include_once("navbar.php");
	?>
	<div class="main-wrapper">
		<div class="container-fluid">
			<div class="row-fluid ">
				<div class="span12">
					<div class="primary-head">
						<h3 class="page-header">Admin Users Management</h3>
					</div>
					<!--<ul class="breadcrumb">
						<li><a href="index.php" class="icon-home"></a><span class="divider "><i class="icon-angle-right"></i></span></li>
						<li><a href="?f=3"><?php //echo $pageName?></a><span class="divider"><i class="icon-angle-right"></i></span></li>
						<li class="active"><?php //echo $sectionName;?></li>
					</ul>-->
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {
			?>
            	
            <?php
			}
			
			function editRecordForm($id) {
				global $conn;
				
				$qry = "SELECT * FROM event_admin 
						WHERE adminID='".sqlSafe($id)."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$user_name = $row['login'];
				$user_email = $row['email'];
				$user_password = $row['password'];
				$name = $row['name'];
				$phone = $row['phone'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Account</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="1">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        <div class="control-group">
                                            <label class="control-label">User Name</label>
                                            <div class="controls">
                                                <input id="user_name" name="user_name" class="span4" type="text" value="<?php echo $user_name?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">E-Mail</label>
                                            <div class="controls">
                                                <input id="email" name="email" type="text" class="span4" value="<?php echo $user_email?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Old Password</label>
                                            <div class="controls">
                                                <input id="old_password" name="old_password" type="password" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">New Password</label>
                                            <div class="controls">
                                                <input id="password" name="password" type="password" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Confirm Password</label>
                                            <div class="controls">
                                                <input id="confirm_password" name="confirm_password" type="password" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" name="submit" value="Update" class="btn btn-success">Update</button>
                                            <a href="index.php" class="btn">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php	
			}
			
			function listRecords() {
				
			}
			?>
            
            <?php
            switch($f) {
			case 1:
				$qry = "SELECT * FROM event_admin 
						WHERE login = '".sqlSafe($user_name)."' 
						AND password='".sqlSafe(md5($old_password))."' 
						AND adminID='".sqlSafe($id)."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
					$data=array(
						"password"=>sqlSafe(trim(strip_tags(md5($password))))
						);
					editItem("event_admin", $data, $id, "adminID");
				}
				else {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Invalid Username or Password!
					</div>
				<?php	
				}
					
				editRecordForm($id);
			break;		
		  
			default;
				editRecordForm($_SESSION['UserId']);
			break;
			}
			?>
            
            
		</div>
	</div>
	<?php include_once("footer.php")?>
</div>
</body>
</html>