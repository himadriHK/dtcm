<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Header Banners";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Header Banners Management</title>
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
						<h3 class="page-header">Header Banners Management</h3>
					</div>
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {}
			
			function editRecordForm($id) {
				global $conn;
				
				$qry = "SELECT * FROM banners 
						WHERE id='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$h_image = $row['h_image'];
				$h_url = $row['h_url'];
				$h1_image = $row['h1_image'];
				$h1_url = $row['h1_url'];
				$h2_image = $row['h2_image'];
				$h2_url = $row['h2_url'];
				$h1_status = $row['h1_status'];
				$h2_status = $row['h2_status'];
				$h3_status = $row['h3_status'];
				$status = $row['status'];
				$h_time = $row['h_time'];
				$b_image = $row['b_image'];
				$p_image = $row['p_image'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Header Banners</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="1">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Banners Status</label>
                                            <div class="controls">
                                                <input name="banner_status" type="hidden" value="OFF" />
                                                <input id="banner_status" name="banner_status" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="ON" class="switchButton" <?php echo ($status == "ON")?"checked":""?>>
                                            </div>
                                        </div>
                                        
                                        <fieldset class="default">
											<legend>1. Banner Image</legend>
                                            <div class="control-group">
                                                <label class="control-label">Image</label>
                                                <div class="controls">
                                                    <input name="image" type="file" id="image" />
                                                    <input name="image_name" type="hidden" value="<?=$h_image?>">
                                                    <br />
                                                    <?
                                                    if($h_image != ""){
                                                    ?>
                                                        <img src="..<?=$h_image?>" alt="N/A" style="vertical-align:text-top;" />
                                                    <?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">URL</label>
                                                <div class="controls">
                                                    <input id="url" name="url" class="span6" type="text" value="<?php echo $h_url?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <input name="status" type="hidden" value="OFF" />
                                                    <input id="status" name="status" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="ON" class="switchButton" <?php echo ($h1_status == "ON")?"checked":""?>>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
											<legend>2. Banner Image</legend>
                                            <div class="control-group">
                                                <label class="control-label">Image</label>
                                                <div class="controls">
                                                    <input name="image2" type="file" id="image2" />
                                                    <input name="image2_name" type="hidden" value="<?=$h1_image?>">
                                                    <br />
                                                    <?
                                                    if($h1_image != ""){
                                                    ?>
                                                        <img src="..<?=$h1_image?>" alt="N/A" style="vertical-align:text-top;" />
                                                    <?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">URL</label>
                                                <div class="controls">
                                                    <input id="url2" name="url2" class="span6" type="text" value="<?php echo $h1_url?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <input name="status2" type="hidden" value="OFF" />
                                                    <input id="status2" name="status2" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="ON" class="switchButton" <?php echo ($h2_status == "ON")?"checked":""?>>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
											<legend>3. Banner Image</legend>
                                            <div class="control-group">
                                                <label class="control-label">Image</label>
                                                <div class="controls">
                                                    <input name="image3" type="file" id="image3" />
                                                    <input name="image3_name" type="hidden" value="<?=$h2_image?>">
                                                    <br />
                                                    <?
                                                    if($h2_image != ""){
                                                    ?>
                                                        <img src="..<?=$h2_image?>" alt="N/A" style="vertical-align:text-top;" />
                                                    <?
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">URL</label>
                                                <div class="controls">
                                                    <input id="url3" name="url3" class="span6" type="text" value="<?php echo $h2_url?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <input name="status3" type="hidden" value="OFF" />
                                                    <input id="status3" name="status3" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="ON" class="switchButton" <?php echo ($h3_status == "ON")?"checked":""?>>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="form-actions">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success">Submit</button>
                                            <a href="?f=3" class="btn">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php	
			}
			
			function editSpecialImageForm($id) {
				global $conn;
				
				$qry = "SELECT * FROM banner2 
						WHERE id='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$image = $row['image'];
				$url = $row['url'];
				$status = $row['status'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Header Special Image</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="3">
          								<input type="hidden" name="id" value="<?php echo $id?>">

                                        <div class="control-group">
                                            <label class="control-label">Image</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                                <input name="image_name" type="hidden" value="<?=$image?>">
                                                <br />
                                                <?
                                                if($image != ""){
                                                ?>
                                                    <img src="..<?=$image?>" alt="N/A" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">URL</label>
                                            <div class="controls">
                                                <input id="url" name="url" class="span6" type="text" value="<?php echo $url?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Status</label>
                                            <div class="controls">
                                                <input name="status" type="hidden" value="OFF" />
                                                <input id="status" name="status" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="ON" class="switchButton" <?php echo ($status == "ON")?"checked":""?>>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success">Submit</button>
                                            <a href="?f=3" class="btn">Cancel</a>
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

				$old_image_name = $image_name;
				$old_image2_name = $image2_name;
				$old_image3_name = $image3_name;
				$error_msg = "";
				
				if(($_FILES["image"]["name"] != "")) {
					if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
						if(($_FILES["image"]["size"] / 2048)  > 2048) {
							$error_msg = "Image-1 size must not be greater than 2048 KB.";
						}
						else {
							$image_name = md5(time())."-1";
							$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
							$image_ext = $image_ext[count($image_ext)-1];
							$image_name = "/img/".$image_name.".".$image_ext;
							
							if(move_uploaded_file($_FILES["image"]["tmp_name"],"..$image_name")) {

								$dest = "..";
								
								if(file_exists($dest.$old_image_name)) {
									@unlink($dest.$old_image_name);
								}

							}
						}
					}
					else {
						$error_msg = "Only jpg/jpeg, gif and png images are allowed for Image-1.";	
					}
				}
				
				if(($_FILES["image2"]["name"] != "")) {
					if($_FILES["image2"]["type"] == "image/jpg" || $_FILES["image2"]["type"] == "image/gif" || $_FILES["image2"]["type"] == "image/jpeg" || $_FILES["image2"]["type"] == "image/png") {
						if(($_FILES["image2"]["size"] / 2048)  > 2048) {
							$error_msg = "Image-2 size must not be greater than 2048 KB.";
						}
						else {
							$image2_name = md5(time())."-2";
							$image2_ext = preg_split("/\./", $_FILES["image2"]["name"]);
							$image2_ext = $image2_ext[count($image2_ext)-1];
							$image2_name = "/img/".$image2_name.".".$image2_ext;
							
							if(move_uploaded_file($_FILES["image2"]["tmp_name"],"..$image2_name")) {

								$dest = "..";
								
								if(file_exists($dest.$old_image2_name)) {
									@unlink($dest.$old_image2_name);
								}

							}
						}
					}
					else {
						$error_msg = "Only jpg/jpeg, gif and png images are allowed for Image-2.";	
					}
				}
				
				if(($_FILES["image3"]["name"] != "")) {
					if($_FILES["image3"]["type"] == "image/jpg" || $_FILES["image3"]["type"] == "image/gif" || $_FILES["image3"]["type"] == "image/jpeg" || $_FILES["image3"]["type"] == "image/png") {
						if(($_FILES["image3"]["size"] / 2048)  > 2048) {
							$error_msg = "Image-3 size must not be greater than 2048 KB.";
						}
						else {
							$image3_name = md5(time())."-3";
							$image3_ext = preg_split("/\./", $_FILES["image3"]["name"]);
							$image3_ext = $image3_ext[count($image3_ext)-1];
							$image3_name = "/img/".$image3_name.".".$image3_ext;
							
							if(move_uploaded_file($_FILES["image3"]["tmp_name"],"..$image3_name")) {

								$dest = "..";
								
								if(file_exists($dest.$old_image3_name)) {
									@unlink($dest.$old_image3_name);
								}

							}
						}
					}
					else {
						$error_msg = "Only jpg/jpeg, gif and png images are allowed for Image-3.";	
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
					
					$data=array(
						"h_image"=>sqlSafe(trim(strip_tags($image_name))),
						"h_url"=>sqlSafe(trim(strip_tags($url))),
						"h1_status"=>sqlSafe(strip_tags($status)),
						"h1_image"=>sqlSafe(trim(strip_tags($image2_name))),
						"h1_url"=>sqlSafe(trim(strip_tags($url2))),
						"h2_status"=>sqlSafe(strip_tags($status2)),
						"h2_image"=>sqlSafe(trim(strip_tags($image3_name))),
						"h2_url"=>sqlSafe(trim(strip_tags($url3))),
						"h3_status"=>sqlSafe(strip_tags($status3)),
						"status "=>sqlSafe(strip_tags($banner_status))
						);
					
					editItem("banners", $data, $id, "id");
				}
				
				editRecordForm($id);
			break;
			
			case 2:
				$qry = "SELECT * FROM banner2 LIMIT 1";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				editSpecialImageForm($row['id']);
			break;	
			
			case 3:

				$old_image_name = $image_name;
				$error_msg = "";
				
				if(($_FILES["image"]["name"] != "")) {
					if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
						if(($_FILES["image"]["size"] / 2048)  > 2048) {
							$error_msg = "Image size must not be greater than 2048 KB.";
						}
						else {
							$image_name = md5(time());
							$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
							$image_ext = $image_ext[count($image_ext)-1];
							$image_name = "/img/".$image_name.".".$image_ext;
							
							if(move_uploaded_file($_FILES["image"]["tmp_name"],"..$image_name")) {

								$dest = "..";
								
								if(file_exists($dest.$old_image_name)) {
									@unlink($dest.$old_image_name);
								}

							}
						}
					}
					else {
						$error_msg = "Only jpg/jpeg, gif and png images are allowed for Image.";	
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
					
					$data=array(
						"image"=>sqlSafe(trim(strip_tags($image_name))),
						"url"=>sqlSafe(trim(strip_tags($url))),
						"status"=>sqlSafe(strip_tags($status))
						);
					
					editItem("banner2", $data, $id, "id");
				}
				
				editSpecialImageForm($id);
			break;
		
			default;
				$qry = "SELECT * FROM banners LIMIT 1";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				editRecordForm($row['id']);
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