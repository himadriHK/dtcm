<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Guides";

if(isset($_POST['action']) && ($_POST['action'] == "getGuideSubCat")) {
	$pcid = $_POST['id'];
	
	if($pcid != "" && $pcid != 0) {
		$qry = "SELECT * FROM guide_sub_cat WHERE catid = '".sqlSafe($pcid)."'";
		$res = mysqli_query($conn, $qry);
?>
		<select class="span4" id="sub_category" name="sub_category">
        	<option value=""> - Select - </option>
<?php
		while($row = mysqli_fetch_array($res)) {
?>
			<option value="<?php echo $row['subcatid']?>"><?php echo $row['name']?></option>
<?php
		}
?>
		</select>
<?php
	}
	exit();
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Guides Management</title>
<?php include_once("top.php")?>
<script src="js/bootstrap-fileupload.js"></script>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			category: "required",
			sub_category: "required",
			name: "required",
			image: "required",
			country: "required",
			city: "required",
			address: "required",
			phone: "required",
			email: {
				required: true,
				email: true
			},
			
		},
		messages: {
			category: "Please select a category",
			sub_category: "Please select a sub category",
			name: "Please enter a guide name",
			image: "Please provide guide logo",
			country: "Please select a country",
			city: "Please provide a city",
			address: "Please provide guide address",
			phone: "Please provide a phone number",
			email: "Please enter a valid email address",
			
		}
	});
	
	$("#recordEditForm").validate({
		rules: {
			category: "required",
			sub_category: "required",
			name: "required",
			country: "required",
			city: "required",
			address: "required",
			phone: "required",
			email: {
				required: true,
				email: true
			},
			
		},
		messages: {
			category: "Please select a category",
			sub_category: "Please select a sub category",
			name: "Please enter a guide name",
			country: "Please select a country",
			city: "Please provide a city",
			address: "Please provide guide address",
			phone: "Please provide a phone number",
			email: "Please enter a valid email address",
			
		}
	});
	
	$("#categoryForm").validate({
		rules: {
			name: "required"
			
		},
		messages: {
			name: "Please enter category name"
			
		}
	});
	
	$("#subCategoryForm").validate({
		rules: {
			category: "required",
			name: "required"
			
		},
		messages: {
			category: "Please select main category",
			name: "Please enter category name"
			
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
						<h3 class="page-header">Guides Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Guide"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Guides"><i class="icon-th-list"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {
				global $conn;
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Add a Guide</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
                                        
                                        <fieldset class="default">
										<legend>Guide Detail</legend>
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category" onchange="getGuideSubCat(this.value)">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM guide_cat WHERE name != '' ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['catid']?>"><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Sub Category</label>
                                            <div class="controls" id="subCatContainer"><label class="control-label">Select Main Category First!</label></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Logo</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <select class="span4" id="country" name="country">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM countries ORDER BY country ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['cid']?>"><?php echo $row['country']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">City</label>
                                            <div class="controls">
                                                <input id="city" name="city" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Address</label>
                                            <div class="controls">
                                                <input id="address" name="address" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Phone No.</label>
                                            <div class="controls">
                                                <input id="phone" name="phone" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Email</label>
                                            <div class="controls">
                                                <input id="email" name="email" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Website</label>
                                            <div class="controls">
                                                <input id="website" name="website" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Information</label>
                                            <div class="controls">
                                                <input id="info" name="info" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Guide Pictures</legend>
                                        <div class="control-group">
                                            <label class="control-label">1. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic1"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">2. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic2"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">3. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic3"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">4. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic4"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">5. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic5"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">6. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic6"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">7. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic7"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">8. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic8"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">9. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic9"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">10. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic10"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
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
			
			function editRecordForm($id) {
				global $conn;
				
				$qry = "SELECT * FROM guide 
						WHERE gid='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$cid = $row['cid'];
				$name = $row['name'];
				$logo = $row['logo'];
				$address = $row['address'];
				$city = $row['city'];
				$phone = $row['phone'];
				$catid = $row['catid'];
				$subcatid = $row['subcatid'];
				$website = $row['website'];
				$email = $row['email'];
				$information = $row['information'];
				$pic1 = $row['pic1'];
				$pic2 = $row['pic2'];
				$pic3 = $row['pic3'];
				$pic4 = $row['pic4'];
				$pic5 = $row['pic5'];
				$pic6 = $row['pic6'];
				$pic7 = $row['pic7'];
				$pic8 = $row['pic8'];
				$pic9 = $row['pic9'];
				$pic10 = $row['pic10'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Guide</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        
                                        
                                        <fieldset class="default">
										<legend>Guide Detail</legend>
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category" onchange="getGuideSubCat(this.value)">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM guide_cat WHERE name != '' ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['catid']?>" <?php echo ($catid == $row['catid'])?"selected":""?>><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Sub Category</label>
                                            <div class="controls" id="subCatContainer">
                                            <select class="span4" id="sub_category" name="sub_category">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM guide_sub_cat WHERE catid = '".sqlSafe($catid)."' ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['subcatid']?>" <?php echo ($subcatid == $row['subcatid'])?"selected":""?>><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text" value="<?php echo $name?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Logo</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                                <input name="image_name" type="hidden" value="<?=$logo?>">
                                                <br />
												<?
                                                if($logo != ""){
                                                ?>
                                                	<img src="../data/<?=$logo?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <select class="span4" id="country" name="country">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM countries ORDER BY country ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['cid']?>" <?php echo ($cid == $row['cid'])?"selected":""?>><?php echo $row['country']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">City</label>
                                            <div class="controls">
                                                <input id="city" name="city" type="text" class="span4" value="<?php echo $city?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Address</label>
                                            <div class="controls">
                                                <input id="address" name="address" class="span6" type="text" value="<?php echo $address?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Phone No.</label>
                                            <div class="controls">
                                                <input id="phone" name="phone" type="text" class="span4" value="<?php echo $phone?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Email</label>
                                            <div class="controls">
                                                <input id="email" name="email" type="text" class="span4" value="<?php echo $email?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Website</label>
                                            <div class="controls">
                                                <input id="website" name="website" class="span4" type="text" value="<?php echo $website?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Information</label>
                                            <div class="controls">
                                                <input id="info" name="info" class="span6" type="text" value="<?php echo $information?>"/>
                                            </div>
                                        </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Guide Pictures</legend>
                                        <div class="control-group">
                                            <label class="control-label">1. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic1"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic1_name" type="hidden" value="<?=$pic1?>">
												<?
                                                if($pic1 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic1?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">2. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic2"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic2_name" type="hidden" value="<?=$pic2?>">
												<?
                                                if($pic2 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic2?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">3. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic3"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic3_name" type="hidden" value="<?=$pic3?>">
												<?
                                                if($pic3 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic3?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">4. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic4"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic4_name" type="hidden" value="<?=$pic4?>">
												<?
                                                if($pic4 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic4?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">5. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic5"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic5_name" type="hidden" value="<?=$pic5?>">
												<?
                                                if($pic5 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic5?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">6. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic6"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic6_name" type="hidden" value="<?=$pic6?>">
												<?
                                                if($pic6 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic6?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">7. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic7"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic7_name" type="hidden" value="<?=$pic7?>">
												<?
                                                if($pic7 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic7?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">8. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic8"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic8_name" type="hidden" value="<?=$pic8?>">
												<?
                                                if($pic8 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic8?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">9. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic9"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic9_name" type="hidden" value="<?=$pic9?>">
												<?
                                                if($pic9 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic9?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">10. Picture</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Picture</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="pic10"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pic10_name" type="hidden" value="<?=$pic10?>">
												<?
                                                if($pic10 != ""){
                                                ?>
                                                	<img src="../data/<?=$pic10?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
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
			
			function listRecords() {
				
				global $config, $conn;
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (name LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM guide 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM guide 
						WHERE 1
						".$qry_str_search."
						ORDER BY gid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Guides</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="7">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                            
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="dataTables_filter" id="data-table_filter">
                                <label>Search:
                                  <input type="text" name="searchFilter" aria-controls="data-table">
                                </label>
                                <button class="btn btn-success" title="Search" onClick="form.submit()"><i class="icon-search"></i></button>
                              </div>
                            </div>
                          </div>
  						
                        <?php
						if($res) {
						?>
        
                          <table class="responsive table tbl-serach table-striped table-bordered dataTable" id="data-table">
                            <thead>
                              <tr>
                              	<th><input name="allbox" type="checkbox" onclick="checkAllFields(1);" id="checkAll" /></th>
                                <th> Guide Name </th>
                                <th class="center"> Email </th>
                                <th class="center"> Guide Logo </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['name'];
								$logo = $row['logo'];
								$email = $row['email'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $email?></td>
                                <td class="center"><img src="../data/<?php echo $logo?>" alt="N/A" width="100"></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-info" title="Edit" onClick="location.href='?f=5&id=<?php echo $id?>'">
                                      	<i class="icon-edit"></i>
                                      </button>
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=4&id=<?php echo $id?>'}">
                                      	<i class="icon-remove"></i>
                                      </button>
                                    </div>
                                  </div>
                                </td>
                              </tr>
							<?php
							}
							?>
                            </tbody>
                          </table>
                          <div class="row-fluid">
                            <div class="span6">
                              <div class="dataTables_info" id="data-table_info">
                              	<select name='select_task' id='select_task' onchange="this.form.submit()">
                                    <option value='0'>Please Select a Task</option>
                                    <option value='1'>Remove Selected</option>
                                </select>
                              </div>
                            </div>
                            <div class="span6">
                              <?php echo $pager->renderFullNav()?>
                            </div>
                          </div>
						<?php
						}
						?>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
			}
			
			function listCategoryRecords() {
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets light-gray">
                            <div class="widget-head blue">
                                <h3> Add Guide Category</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="categoryForm" method="post" action="">
                                    	<input type="hidden" name="f" value="9">
                                        <div class="control-group">
                                            <label class="control-label">Category Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
                                            </div>
                                        </div>

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
				global $config, $conn;
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (name LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM guide_cat 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM guide_cat 
						WHERE 1
						".$qry_str_search."
						ORDER BY catid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Guide Categories</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="11">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                            
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="dataTables_filter" id="data-table_filter">
                                <label>Search:
                                  <input type="text" name="searchFilter" aria-controls="data-table">
                                </label>
                                <button class="btn btn-success" title="Search" onClick="form.submit()"><i class="icon-search"></i></button>
                              </div>
                            </div>
                          </div>
  						
                        <?php
						if($res) {
						?>
        
                          <table class="responsive table tbl-serach table-striped table-bordered dataTable" id="data-table">
                            <thead>
                              <tr>
                              	<th><input name="allbox" type="checkbox" onclick="checkAllFields(1);" id="checkAll" /></th>
                                <th> Category Name </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['name'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=10&id=<?php echo $id?>'}">
                                      	<i class="icon-remove"></i>
                                      </button>
                                    </div>
                                  </div>
                                </td>
                              </tr>
							<?php
							}
							?>
                            </tbody>
                          </table>
                          <div class="row-fluid">
                            <div class="span6">
                              <div class="dataTables_info" id="data-table_info">
                              	<select name='select_task' id='select_task' onchange="this.form.submit()">
                                    <option value='0'>Please Select a Task</option>
                                    <option value='1'>Remove Selected</option>
                                </select>
                              </div>
                            </div>
                            <div class="span6">
                              <?php echo $pager->renderFullNav()?>
                            </div>
                          </div>
						<?php
						}
						?>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
			}
			
			function listSubCategoryRecords() {
				global $config, $conn;
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets light-gray">
                            <div class="widget-head blue">
                                <h3> Add Guide Sub-Category</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="subCategoryForm" method="post" action="">
                                    	<input type="hidden" name="f" value="13">
                                        <div class="control-group">
                                            <label class="control-label">Main Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM guide_cat WHERE name != '' ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['catid']?>"><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Sub-Category Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
                                            </div>
                                        </div>

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
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (guide_sub_cat.name LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM guide_sub_cat 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT guide_sub_cat.*, guide_cat.name AS parent_cat 
						FROM guide_sub_cat 
						LEFT JOIN guide_cat ON guide_sub_cat.catid = guide_cat.catid
						WHERE 1
						".$qry_str_search."
						ORDER BY guide_sub_cat.subcatid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Guide Sub-Categories</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="15">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                            
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="dataTables_filter" id="data-table_filter">
                                <label>Search:
                                  <input type="text" name="searchFilter" aria-controls="data-table">
                                </label>
                                <button class="btn btn-success" title="Search" onClick="form.submit()"><i class="icon-search"></i></button>
                              </div>
                            </div>
                          </div>
  						
                        <?php
						if($res) {
						?>
        
                          <table class="responsive table tbl-serach table-striped table-bordered dataTable" id="data-table">
                            <thead>

                              <tr>
                              	<th><input name="allbox" type="checkbox" onclick="checkAllFields(1);" id="checkAll" /></th>
                                <th> Category Name </th>
                                <th> Main Category </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['name'];
								$parent_category = $row['parent_cat'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $parent_category?></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=14&id=<?php echo $id?>'}">
                                      	<i class="icon-remove"></i>
                                      </button>
                                    </div>
                                  </div>
                                </td>
                              </tr>
							<?php
							}
							?>
                            </tbody>
                          </table>
                          <div class="row-fluid">
                            <div class="span6">
                              <div class="dataTables_info" id="data-table_info">
                              	<select name='select_task' id='select_task' onchange="this.form.submit()">
                                    <option value='0'>Please Select a Task</option>
                                    <option value='1'>Remove Selected</option>
                                </select>
                              </div>
                            </div>
                            <div class="span6">
                              <?php echo $pager->renderFullNav()?>
                            </div>
                          </div>
						<?php
						}
						?>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
			}
			?>
            
            <?php
            switch($f) {
			case 1:
				addRecordForm();
			break;
	
			case 2:
			
				$qry = "SELECT * FROM guide 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Guide "<?php echo $name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					$image_name = "";
					$picture_arr = array();
					$error_msg_arr = array();
					
					if(($_FILES["image"]["name"] != "")){
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Logo size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time())."logo";
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								move_uploaded_file($_FILES["image"]["tmp_name"],"../data/$image_name");
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Logo.";	
						}
					}
					
					
					for($i=0; $i<11; $i++) {
						$picture_name = "";
						
						if(($_FILES["pic".$i]["name"] != "")){
							if($_FILES["pic".$i]["type"] == "image/jpg" || $_FILES["pic".$i]["type"] == "image/gif" || $_FILES["pic".$i]["type"] == "image/jpeg" || $_FILES["pic".$i]["type"] == "image/png") {
								if(($_FILES["pic".$i]["size"] / 2048)  > 2048) {
									$error_msg_arr[] = "Picture-".$i." size must not be greater than 2048 KB.";
								}
								else {
									$picture_name = md5(time()).$i;
									$picture_ext = preg_split("/\./", $_FILES["pic".$i]["name"]);
									$picture_ext = $picture_ext[count($picture_ext)-1];
									$picture_name = $picture_name.".".$picture_ext;
									move_uploaded_file($_FILES["pic".$i]["tmp_name"],"../data/$picture_name");
								}
							}
							else {
								$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Picture-".$i.".";	
							}
						}
						
						$picture_arr[$i] = $picture_name;
					}
					
					
					if(!empty($error_msg_arr)) {
						foreach($error_msg_arr as $error_msg) {
						?>
                            <div class="alert">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?=$error_msg?>
                            </div>
						<?php
						}
						
						addRecordForm();
					}
					else {
						$data=array(
							"catid"=>sqlSafe(trim(strip_tags($category))),
							"subcatid"=>sqlSafe(trim(strip_tags($sub_category))),
							"name"=>sqlSafe(trim(strip_tags($name))),
							"logo"=>sqlSafe(trim(strip_tags($image_name))),
							"cid"=>sqlSafe(strip_tags($country)),
							"city"=>sqlSafe(strip_tags($city)),
							"address"=>sqlSafe(strip_tags($address)),
							"phone"=>sqlSafe(strip_tags($phone)),
							"email"=>sqlSafe(strip_tags($email)),
							"website"=>sqlSafe(strip_tags($website)),
							"information"=>sqlSafe(strip_tags($info)),
							"pic1"=>sqlSafe(strip_tags($picture_arr[1])),
							"pic2"=>sqlSafe(strip_tags($picture_arr[2])),
							"pic3"=>sqlSafe(strip_tags($picture_arr[3])),
							"pic4"=>sqlSafe(strip_tags($picture_arr[4])),
							"pic5"=>sqlSafe(strip_tags($picture_arr[5])),
							"pic6"=>sqlSafe(strip_tags($picture_arr[6])),
							"pic7"=>sqlSafe(strip_tags($picture_arr[7])),
							"pic8"=>sqlSafe(strip_tags($picture_arr[8])),
							"pic9"=>sqlSafe(strip_tags($picture_arr[9])),
							"pic10"=>sqlSafe(strip_tags($picture_arr[10]))
							);
						addItem("guide", $data);
						listRecords();
					}

				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "guide", "gid");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM guide 
						WHERE name = '".sqlSafe(trim(strip_tags($name)))."' 
						AND gid != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Guide "<?php echo $name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
				}
				else {
					$old_image_name = $image_name;
					$picture_arr = array();
					$error_msg_arr = array();
					
					if(($_FILES["image"]["name"] != "")) {
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Logo size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time())."logo";
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								
								if(move_uploaded_file($_FILES["image"]["tmp_name"],"../data/$image_name")) {

									$dest = "../data";
									
									if(file_exists($dest.'/'.$old_image_name)) {
										@unlink($dest.'/'.$old_image_name);
									}

								}
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Logo.";	
						}
					}
					
					
					for($i=0; $i<11; $i++) {
						$picture_name = $_POST["pic".$i."_name"];
						$old_picture_name = $picture_name;
						
						if(($_FILES["pic".$i]["name"] != "")){
							if($_FILES["pic".$i]["type"] == "image/jpg" || $_FILES["pic".$i]["type"] == "image/gif" || $_FILES["pic".$i]["type"] == "image/jpeg" || $_FILES["pic".$i]["type"] == "image/png") {
								if(($_FILES["pic".$i]["size"] / 2048)  > 2048) {
									$error_msg_arr[] = "Picture-".$i." size must not be greater than 2048 KB.";
								}
								else {
									$picture_name = md5(time()).$i;
									$picture_ext = preg_split("/\./", $_FILES["pic".$i]["name"]);
									$picture_ext = $picture_ext[count($picture_ext)-1];
									$picture_name = $picture_name.".".$picture_ext;
									if(move_uploaded_file($_FILES["pic".$i]["tmp_name"],"../data/$picture_name")) {
	
										$dest = "../data";
										
										if(file_exists($dest.'/'.$old_picture_name)) {
											@unlink($dest.'/'.$old_picture_name);
										}
	
									}
								}
							}
							else {
								$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Picture-".$i.".";	
							}
						}
						
						$picture_arr[$i] = $picture_name;
					}
					
					
					if(!empty($error_msg_arr)) {
						foreach($error_msg_arr as $error_msg) {
						?>
                            <div class="alert">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?=$error_msg?>
                            </div>
						<?php
						}
						
						editRecordForm($id);
					}
					else {
						$data=array(
							"catid"=>sqlSafe(trim(strip_tags($category))),
							"subcatid"=>sqlSafe(trim(strip_tags($sub_category))),
							"name"=>sqlSafe(trim(strip_tags($name))),
							"logo"=>sqlSafe(trim(strip_tags($image_name))),
							"cid"=>sqlSafe(strip_tags($country)),
							"city"=>sqlSafe(strip_tags($city)),
							"address"=>sqlSafe(strip_tags($address)),
							"phone"=>sqlSafe(strip_tags($phone)),
							"email"=>sqlSafe(strip_tags($email)),
							"website"=>sqlSafe(strip_tags($website)),
							"information"=>sqlSafe(strip_tags($info)),
							"pic1"=>sqlSafe(strip_tags($picture_arr[1])),
							"pic2"=>sqlSafe(strip_tags($picture_arr[2])),
							"pic3"=>sqlSafe(strip_tags($picture_arr[3])),
							"pic4"=>sqlSafe(strip_tags($picture_arr[4])),
							"pic5"=>sqlSafe(strip_tags($picture_arr[5])),
							"pic6"=>sqlSafe(strip_tags($picture_arr[6])),
							"pic7"=>sqlSafe(strip_tags($picture_arr[7])),
							"pic8"=>sqlSafe(strip_tags($picture_arr[8])),
							"pic9"=>sqlSafe(strip_tags($picture_arr[9])),
							"pic10"=>sqlSafe(strip_tags($picture_arr[10]))
							);
						
						editItem("guide", $data, $id, "gid");
						listRecords();
					}
				}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "guide", "gid");
				listRecords();
			break;
			
			case 8;
				listCategoryRecords();
			break;
			
			case 9:
				$qry = "SELECT * FROM guide_cat 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Guide Category "<?php echo $name?>" already exists.
					</div>
				<?php
					listCategoryRecords();
							
				} else {
					
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($name)))
						);
					addItem("guide_cat", $data);
					listCategoryRecords();
					
				}
			break;
			
			case 10;
				deleteListItem($id, "guide_cat", "catid");
				listCategoryRecords();
			break;
			
			case 11;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "guide_cat", "catid");
				listCategoryRecords();
			break;
			
			case 12;
				listSubCategoryRecords();
			break;
			
			case 13:
				$qry = "SELECT * FROM guide_sub_cat 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Guide Category "<?php echo $name?>" already exists.
					</div>
				<?php
					listSubCategoryRecords();
							
				} else {
					
					$data=array(
						"catid"=>sqlSafe(trim(strip_tags($category))),
						"name"=>sqlSafe(trim(strip_tags($name)))
						);
					addItem("guide_sub_cat", $data);
					listSubCategoryRecords();
					
				}
			break;
			
			case 14;
				deleteListItem($id, "guide_sub_cat", "subcatid");
				listSubCategoryRecords();
			break;
			
			case 15;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "guide_sub_cat", "subcatid");
				listSubCategoryRecords();
			break;
		  
			default;
				listRecords();
			break;
			}
			?>
            
            
		</div>
	</div>
	<?php include_once("footer.php")?>
</div>
</body>
</html>