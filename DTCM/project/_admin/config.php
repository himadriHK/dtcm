<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Settings";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Site Configuration</title>
<?php include_once("top.php")?>
<link href="css/bootstrap-switch.css" rel="stylesheet">
<script src="js/bootstrap-switch.js"></script>
<script type="text/javascript">
$(function() {

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
						<h3 class="page-header">Site Settings</h3>
					</div>
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {}
			
			function editRecordForm() {
				global $conn;
				
				$qry = "SELECT * FROM setting 
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$fbid = $row['id'];
				$fbappid = $row['fbappid'];
				$fbappkey = $row['fbskey'];
				
				$qry = "SELECT * FROM banners 
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$bgid = $row['id'];
				$bgimage = $row['b_image'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Settings</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="1">
          								<input type="hidden" name="fbid" value="<?php echo $fbid?>">
                                        <input type="hidden" name="bgid" value="<?php echo $bgid?>">

                                        <fieldset class="default">
											<legend>Facebook Settings</legend>
                                            <div class="control-group">
                                                <label class="control-label">Facebook App ID</label>
                                                <div class="controls">
                                                    <input id="app_id" name="app_id" class="span6" type="text" value="<?php echo $fbappid?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Facebook App Secret</label>
                                                <div class="controls">
                                                    <input id="app_secret" name="app_secret" class="span6" type="text" value="<?php echo $fbappkey?>"/>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
											<legend>Site Background</legend>
                                            <div class="control-group">
                                                <label class="control-label">Image</label>
                                                <div class="controls">
                                                    <input name="bg_image" type="file" id="bg_image" />
                                                    <input name="bg_image_name" type="hidden" value="<?=$bgimage?>">
                                                    <br />
                                                    <?
                                                    if($bgimage != ""){
                                                    ?>
                                                        <img src="..<?=$bgimage?>" width="150" alt="N/A" style="vertical-align:text-top;" />
                                                    <?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <div class="form-actions">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php	
			}
			
			function listRecords() {}
			?>
            
            <?php
            switch($f) {
	
			case 1:

				$old_image_name = $bg_image_name;
				$error_msg = "";
				
				if(($_FILES["bg_image"]["name"] != "")) {
					if($_FILES["bg_image"]["type"] == "image/jpg" || $_FILES["bg_image"]["type"] == "image/gif" || $_FILES["bg_image"]["type"] == "image/jpeg" || $_FILES["bg_image"]["type"] == "image/png") {
						if(($_FILES["bg_image"]["size"] / 2048)  > 2048) {
							$error_msg = "Background Image size must not be greater than 2048 KB.";
						}
						else {
							$bg_image_name = md5(time())."-1";
							$bg_image_ext = preg_split("/\./", $_FILES["bg_image"]["name"]);
							$bg_image_ext = $bg_image_ext[count($bg_image_ext)-1];
							$bg_image_name = "/background/img/".$bg_image_name.".".$bg_image_ext;
							
							if(move_uploaded_file($_FILES["bg_image"]["tmp_name"],"..$bg_image_name")) {

								$dest = "..";
								
								if(file_exists($dest.$old_image_name)) {
									@unlink($dest.$old_image_name);
								}

							}
						}
					}
					else {
						$error_msg = "Only jpg/jpeg, gif and png images are allowed for Background Image.";	
					}
				}

				if($error_msg != "") {
					?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?php echo $error_msg?>
					</div>
					<?php
				}
				else {
					
					mysqli_query($conn, "UPDATE banners SET b_image = '".sqlSafe($bg_image_name)."' WHERE id = '".sqlSafe($bgid)."'");
					mysqli_query($conn, "UPDATE setting SET fbappid = '".sqlSafe($app_id)."', fbskey = '".sqlSafe($app_secret)."' WHERE id = '".sqlSafe($fbid)."'");
					
				?>
                	<div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <i class="icon-ok-sign"></i><strong>Success!</strong> Settings have been Updated Successfully.
                    </div>
                <?php
				}
				
				editRecordForm();
			break;

			default;
				editRecordForm();
			break;
			}
			?>
            
            
		</div>
	</div>
    <script>
	(function() {
		$("[class='switchButton']").bootstrapSwitch();
	}).call(this);
	</script>
	<?php include_once("footer.php")?>
</div>
</body>
</html>