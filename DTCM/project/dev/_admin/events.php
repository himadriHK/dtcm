<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Events";

if(isset($_POST['action']) && ($_POST['action'] == "getCountryCities")) {
	$cid = $_POST['id'];
	
	if($cid != "" && $cid != 0) {
		$qry = "SELECT * FROM cities WHERE cid = '".sqlSafe($cid)."'";
		$res = mysqli_query($conn, $qry);
?>
		<select class="span4" id="city" name="city">
        	<option value=""> - Select - </option>
<?php
		while($row = mysqli_fetch_array($res)) {
?>
			<option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
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
<title><?php echo $config['SITE_NAME']?> | Events Management</title>
<?php include_once("top.php")?>
<link href="css/bootstrap-switch.css" rel="stylesheet">
<script src="js/bootstrap-switch.js"></script>
<script src="js/bootstrap-fileupload.js"></script>
<script src="js/tiny_mce/jquery.tinymce.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
$(function() {
	$(function() {
		$('textarea.tinymce-simple').tinymce({
			script_url : 'js/tiny_mce/tiny_mce.js',
			theme : "simple"
			});
	});
	
	$(function () {
        $('.onlyTimePicker').datetimepicker({
            pickDate: false
        });
    });
	$(function () {
		$('.onlyTimePicker2').datetimepicker({
			pickDate: false,
			pick12HourFormat: true
		});
	});
    $(function () {
        $('.onlyDatePicker').datetimepicker({
            pickTime: false
        });
    });
		
	$("#recordForm").validate({
		rules: {
			promoter: "required",
			country: "required",
			city: "required",
			category: "required",
			ongoing: "required",
			name: "required",
			desc: "required",
			venue: "required",
			date_start: "required",
			date_end: "required",
			session_hour: "required",
			doors_open: "required",
			sale_date: "required",
			time_start: "required",
			time_end: "required",
			picture: "required"
			
		},
		messages: {
			promoter: "Please select event promoter",
			country: "Please select a country",
			city: "Please select a city",
			category: "Please select a category",
			ongoing: "Please select event type",
			name: "Please provide event name",
			desc: "Please provide event description",
			venue: "Please provide event venue",
			date_start: "Please select a starting date",
			date_end: "Please select an ending date",
			session_hour: "Please select event session hours",
			doors_open: "Please select door open hours",
			sale_date: "Please select sale starting date",
			time_start: "Please select start time",
			time_end: "Please select end time",
			picture: "Please select event main image"
			
		}
	});
	
	$("#recordEditForm").validate({
		rules: {
			promoter: "required",
			country: "required",
			city: "required",
			category: "required",
			ongoing: "required",
			name: "required",
			desc: "required",
			venue: "required",
			date_start: "required",
			date_end: "required",
			session_hour: "required",
			doors_open: "required",
			sale_date: "required",
			time_start: "required",
			time_end: "required"
			
		},
		messages: {
			promoter: "Please select event promoter",
			country: "Please select a country",
			city: "Please select a city",
			category: "Please select a category",
			ongoing: "Please select event type",
			name: "Please provide event name",
			desc: "Please provide event description",
			venue: "Please provide event venue",
			date_start: "Please select a starting date",
			date_end: "Please select an ending date",
			session_hour: "Please select event session hours",
			doors_open: "Please select door open hours",
			sale_date: "Please select sale starting date",
			time_start: "Please select start time",
			time_end: "Please select end time"
			
		}
	});
	
	$("#categoryForm").validate({
		rules: {
			name: "required",
			ename: "required",
			image: "required"
			
		},
		messages: {
			name: "Please enter category name",
			ename: "Please enter category short name",
			image: "Please provide category image"
			
		}
	});
	
	$("#seatTypeForm").validate({
		rules: {
			name: "required"
			
		},
		messages: {
			name: "Please enter a seat type"
			
		}
	});
	
	$("#eventAdForm").validate({
		rules: {
			category: "required"
			
		},
		messages: {
			name: "Please select a category"
			
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
						<h3 class="page-header">Events Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Admin"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Admins"><i class="icon-th-list"></i></a></li>
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
                                <h3> Add an Event</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
                                        
                                        <fieldset class="default">
										<legend>Event Detail</legend>
                                        <div class="control-group">
                                            <label class="control-label">Promoter</label>
                                            <div class="controls">
                                                <select class="span4" id="promoter" name="promoter">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM promoters WHERE 1 ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['spid']?>"><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <select class="span4" id="country" name="country" onchange="getcountryCity(this.value)">
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
                                            <div class="controls" id="countryCityContainer"><label class="control-label">Select Country First!</label></div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM category ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Event Type</label>
                                            <div class="controls">
                                                <select class="span4" id="ongoing" name="ongoing">
                                                    <option value=""> - Select - </option>
                                                    <option value="<?php echo ONGOING?>">On Going</option>
                                                    <option value="<?php echo UPCOMING?>">Up Coming</option>
                                                    <option value="<?php echo GUEST?>">Guest List</option>
                                                    <option value="<?php echo OUTANDABOUT?>">Out & About</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <textarea id="desc" name="desc" rows="8" cols="80" style="width: 70%" class="tinymce-simple">
                                                </textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Venue</label>
                                            <div class="controls">
                                                <input id="venue" name="venue" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Dress</label>
                                            <div class="controls">
                                                <input id="dress" name="dress" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Age Limit</label>
                                            <div class="controls">
                                                <input id="age_limit" name="age_limit" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Facebook Link</label>
                                            <div class="controls">
                                                <input id="fb_link" name="fb_link" class="span4" type="text"/>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Date Starts</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="date_start" id="date_start" data-format="yyyy-MM-dd" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Date Ends</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="date_end" id="date_end" data-format="yyyy-MM-dd" type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Session Hours</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="session_hour" id="session_hour" data-format="hh:mm" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Doors Open</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="doors_open" id="doors_open" data-format="hh:mm" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Sale Starts Date</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="sale_date" id="sale_date" data-format="yyyy-MM-dd" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Time Starts</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker2">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="time_start" id="time_start" data-format="hh:mm:ss PP" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Time Ends</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker2">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="time_end" id="time_end" data-format="hh:mm:ss PP" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Restaurant</label>
                                            <div class="controls">
                                                <input name="restaurant" type="hidden" value="No" />
                                                <input id="restaurant" name="restaurant" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Rest Room</label>
                                            <div class="controls">
                                                <input name="rest_room" type="hidden" value="No" />
                                                <input id="rest_room" name="rest_room" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Hot</label>
                                            <div class="controls">
                                                <input name="hot" type="hidden" value="No" />
                                                <input id="hot" name="hot" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">DTCM Approved</label>
                                            <div class="controls">
                                                <input name="dtcm_approved" type="hidden" value="No" />
                                                <input id="dtcm_approved" name="dtcm_approved" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton" onClick="toggleDTCMCode()">
                                            </div>
                                        </div>
                                        <div class="control-group" id="dtcmCodeContainer" style="display:none;">
                                            <label class="control-label">DTCM Code</label>
                                            <div class="controls">
                                                <input id="dtcm_code" name="dtcm_code" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Event Media Files</legend>
                                        <div class="control-group">
                                            <label class="control-label">1. Event Main Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Main Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="picture" name="picture"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										
                                        <?php
                                        for($i=1; $i<6; $i++) {
										?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo $i+1 ?>. Event Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Event Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="event_pic<?php echo $i ?>" name="event_pic<?php echo $i ?>"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <?php
										}
										?>

                                        <div class="control-group">
                                            <label class="control-label">Background Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Background Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="pupload" name="pupload"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Location Map</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Map Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="locmap" name="locmap"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Floor Plan</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Plan Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="floorplan" name="floorplan"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Voucher Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Voucher Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="voucherimage" name="voucherimage"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Upload Audio</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select .mp3 Audio File</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="file_audio" name="file_audio"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Upload Video</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select .flv Video File</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="file_video" name="file_video"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Sponsor Logos</legend>
                                        <?php
                                        for($i=1; $i<9; $i++) {
										?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo $i?>. Sponsor Logo</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Logo</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="sponsor_logo<?php echo $i?>" id="sponsor_logo<?php echo $i?>"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
										}
										?>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Other Information</legend>
                                        <div class="control-group">
                                            <label class="control-label">Payment Option</label>
                                            <div class="controls">
                                                <select class="span4" id="payment_option" name="payment_option">
                                                    <option value=""> - Select - </option>
                                                    <option value="all">All</option>
                                                    <option value="creditcard">Credit Card</option>
                                                    <option value="cod">Payment on delivery</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Commission Charges</label>
                                            <div class="controls">
                                                <input id="commissionCharges" name="commissionCharges" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">DTCM Charges</label>
                                            <div class="controls">
                                                <input id="dtcm" name="dtcm" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Credit Charges</label>
                                            <div class="controls">
                                                <input id="creditCharge" name="creditCharge" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Service Charges</label>
                                            <div class="controls">
                                                <input id="serviceCharge" name="serviceCharge" class="span4" type="text"/>
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
				
				$qry = "SELECT * FROM events 
						WHERE tid='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$event_row = mysqli_fetch_array($res);
				
				$title = $event_row['title'];
				$desc = $event_row['desc'];
				$pic = $event_row['pic'];
				$popup_pic = $event_row['popup_pic'];
				$date_start = $event_row['date_start'];
				$date_end = $event_row['date_end'];
				$venue = $event_row['venue'];
				$dress = $event_row['dress'];
				$age_limit = $event_row['age_limit'];
				$restaurant = $event_row['restaurant'];
				$rest_room = $event_row['rest_room'];
				$hot = $event_row['hot'];
				$city = $event_row['city'];
				$country = $event_row['country'];
				$promoter = $event_row['promoter'];
				$category = $event_row['category'];
				$loc_map = $event_row['loc_map'];
				$floorplan = $event_row['floorplan'];
				$ongoing = $event_row['ongoing'];
				$session_hour = $event_row['session_hour'];
				$doors_open = $event_row['doors_open'];
				$sale_date = $event_row['sale_date'];
				$time_start = $event_row['time_start'];
				$time_end = $event_row['time_end'];
				$time_start_part = $event_row['time_start_part'];
				$time_end_part = $event_row['time_end_part'];
				$videoName = $event_row['videoName'];
				$audioName = $event_row['audioName'];
				$voucher_image = $event_row['voucher_image'];
				$sponsor_logo1 = $event_row['sponsor_logo1'];
				$sponsor_logo2 = $event_row['sponsor_logo2'];
				$sponsor_logo3 = $event_row['sponsor_logo3'];
				$sponsor_logo4 = $event_row['sponsor_logo4'];
				$sponsor_logo5 = $event_row['sponsor_logo5'];
				$sponsor_logo6 = $event_row['sponsor_logo6'];
				$sponsor_logo7 = $event_row['sponsor_logo7'];
				$sponsor_logo8 = $event_row['sponsor_logo8'];
				$event_pic1 = $event_row['event_pic1'];
				$event_pic2 = $event_row['event_pic2'];
				$event_pic3 = $event_row['event_pic3'];
				$event_pic4 = $event_row['event_pic4'];
				$event_pic5 = $event_row['event_pic5'];
				$commission = $event_row['commission'];
				$dtcm = $event_row['dtcm'];
				$credit_charge = $event_row['credit_charge'];
				$service_charge = $event_row['service_charge'];
				$dtcm_approved = $event_row['dtcm_approved'];
				$dtcm_code = $event_row['dtcm_code'];
				$fb_link = $event_row['fb_link'];
				$payment_option = $event_row['payment_option'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Event</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        
                                        <fieldset class="default">
										<legend>Event Detail</legend>
                                        <div class="control-group">
                                            <label class="control-label">Promoter</label>
                                            <div class="controls">
                                                <select class="span4" id="promoter" name="promoter">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM promoters WHERE 1 ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['spid']?>" <?php echo ($row['spid'] == $promoter)?"selected":""?>><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <select class="span4" id="country" name="country" onchange="getcountryCity(this.value)">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM countries ORDER BY country ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['cid']?>" <?php echo ($row['cid'] == $country)?"selected":""?>><?php echo $row['country']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">City</label>
                                            <div class="controls" id="countryCityContainer">
                                            	<select class="span4" id="city" name="city">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM cities WHERE cid = '".sqlSafe($country)."' ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['id']?>" <?php echo ($row['id'] == $city)?"selected":""?>><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM category ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['id']?>" <?php echo ($row['id'] == $category)?"selected":""?>><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Event Type</label>
                                            <div class="controls">
                                                <select class="span4" id="ongoing" name="ongoing">
                                                    <option value=""> - Select - </option>
                                                    <option value="<?php echo ONGOING?>" <?php echo (ONGOING == $ongoing)?"selected":""?>>On Going</option>
                                                    <option value="<?php echo UPCOMING?>" <?php echo (UPCOMING == $ongoing)?"selected":""?>>Up Coming</option>
                                                    <option value="<?php echo GUEST?>" <?php echo (GUEST == $ongoing)?"selected":""?>>Guest List</option>
                                                    <option value="<?php echo OUTANDABOUT?>" <?php echo (OUTANDABOUT == $ongoing)?"selected":""?>>Out & About</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text" value="<?php echo $title?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <textarea id="desc" name="desc" rows="8" cols="80" style="width: 70%" class="tinymce-simple"><?php echo $desc?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Venue</label>
                                            <div class="controls">
                                                <input id="venue" name="venue" class="span4" type="text" value="<?php echo $venue?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Dress</label>
                                            <div class="controls">
                                                <input id="dress" name="dress" type="text" class="span4" value="<?php echo $dress?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Age Limit</label>
                                            <div class="controls">
                                                <input id="age_limit" name="age_limit" type="text" class="span4" value="<?php echo $age_limit?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Facebook Link</label>
                                            <div class="controls">
                                                <input id="fb_link" name="fb_link" class="span4" type="text" value="<?php echo $fb_link?>"/>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Date Starts</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="date_start" id="date_start" data-format="yyyy-MM-dd" type="text" value="<?php echo $date_start?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Date Ends</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="date_end" id="date_end" data-format="yyyy-MM-dd" type="text" value="<?php echo $date_end?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Session Hours</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="session_hour" id="session_hour" data-format="hh:mm:ss" type="text" value="<?php echo $session_hour?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Doors Open</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="doors_open" id="doors_open" data-format="hh:mm:ss" type="text" value="<?php echo $doors_open?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Sale Starts Date</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="sale_date" id="sale_date" data-format="yyyy-MM-dd" type="text" value="<?php echo $sale_date?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Time Starts</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker2">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="time_start" id="time_start" data-format="hh:mm:ss PP" type="text" value="<?php echo $time_start." ".$time_start_part?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Time Ends</label>
                                            <div class="controls">
                                                <div class="input-append onlyTimePicker2">
                                                	<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="time_end" id="time_end" data-format="hh:mm:ss PP" type="text" value="<?php echo $time_end." ".$time_end_part?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Restaurant</label>
                                            <div class="controls">
                                                <input name="restaurant" type="hidden" value="No" />
                                                <input id="restaurant" name="restaurant" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton" <?php echo ($restaurant == "Yes")?"checked":""?>>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Rest Room</label>
                                            <div class="controls">
                                                <input name="rest_room" type="hidden" value="No" />
                                                <input id="rest_room" name="rest_room" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton" <?php echo ($rest_room == "Yes")?"checked":""?>>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Hot</label>
                                            <div class="controls">
                                                <input name="hot" type="hidden" value="No" />
                                                <input id="hot" name="hot" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton" <?php echo ($hot == "Yes")?"checked":""?>>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">DTCM Approved</label>
                                            <div class="controls">
                                                <input name="dtcm_approved" type="hidden" value="No" />
                                                <input id="dtcm_approved" name="dtcm_approved" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" value="Yes" class="switchButton" onClick="toggleDTCMCode()" <?php echo ($dtcm_approved == "Yes")?"checked":""?>>
                                            </div>
                                        </div>
                                        <div class="control-group" id="dtcmCodeContainer" style="display:<?php echo ($dtcm_approved == "Yes")?"":"none"?>;">
                                            <label class="control-label">DTCM Code</label>
                                            <div class="controls">
                                                <input id="dtcm_code" name="dtcm_code" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Event Media Files</legend>
                                        <div class="control-group">
                                            <label class="control-label">1. Event Main Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Main Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="picture" name="picture"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="picture_name" type="hidden" value="<?php echo $pic?>">
												<?
                                                if($pic != ""){
                                                ?>
                                                	<img src="../data/<?=$pic?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <?php
                                        for($i=1; $i<6; $i++) {
											$event_pic = $event_row['event_pic'.$i];
										?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo $i+1 ?>. Event Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Event Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="event_pic<?php echo $i ?>" name="event_pic<?php echo $i ?>"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="event_pic<?php echo $i ?>_name" type="hidden" value="<?php echo $event_pic?>">
												<?
                                                if($event_pic != ""){
                                                ?>
                                                	<img src="../data/<?=$event_pic?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>

                                        </div>
                                        <?php
										}
										?>

                                        <div class="control-group">
                                            <label class="control-label">Background Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Background Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="pupload" name="pupload"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="pupload_name" type="hidden" value="<?php echo $popup_pic?>">
												<?
                                                if($popup_pic != ""){
                                                ?>
                                                	<img src="../data/<?=$popup_pic?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Location Map</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Map Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="locmap" name="locmap"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="locmap_name" type="hidden" value="<?php echo $loc_map?>">
												<?
                                                if($loc_map != ""){
                                                ?>
                                                	<img src="../data/<?=$loc_map?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Floor Plan</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Plan Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="floorplan" name="floorplan"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="floorplan_name" type="hidden" value="<?php echo $floorplan?>">
												<?
                                                if($floorplan != ""){
                                                ?>
                                                	<img src="../data/<?=$floorplan?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Voucher Image</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Voucher Image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="voucherimage" name="voucherimage"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="voucherimage_name" type="hidden" value="<?php echo $voucher_image?>">
												<?
                                                if($voucher_image != ""){
                                                ?>
                                                	<img src="../data/<?=$voucher_image?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label">Upload Audio</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select .mp3 Audio File</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="file_audio" name="file_audio"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="file_audio_name" type="hidden" value="<?php echo $audioName?>">
												<?
                                                if($audioName != ""){
                                                ?>
                                                	<a href="../eventAudio/<?php echo $audioName; ?>" target="_blank" ><?php echo $audioName; ?></a>
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Upload Video</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select .flv Video File</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="file_video" name="file_video"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="file_video_name" type="hidden" value="<?php echo $videoName?>">
												<?
                                                if($videoName != ""){
                                                ?>
                                                	<a href="../eventVideo/<?php echo $videoName; ?>" target="_blank" ><?php echo $videoName; ?></a>
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Sponsor Logos</legend>
                                        <?php
                                        for($i=1; $i<9; $i++) {
											$sponsor_logo = $event_row['sponsor_logo'.$i];
										?>
                                        <div class="control-group">
                                            <label class="control-label"><?php echo $i?>. Sponsor Logo</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input span3">
                                                            <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                        </div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select Logo</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" name="sponsor_logo<?php echo $i?>" id="sponsor_logo<?php echo $i?>"/>
                                                        </span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                                <input name="sponsor_logo<?php echo $i?>_name" type="hidden" value="<?php echo $sponsor_logo?>">
												<?
                                                if($sponsor_logo != ""){
                                                ?>
                                                	<img src="../data/<?=$sponsor_logo?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
										}
										?>
                                        </fieldset>
                                        
                                        <fieldset class="default">
										<legend>Other Information</legend>
                                        <div class="control-group">
                                            <label class="control-label">Payment Option</label>
                                            <div class="controls">
                                                <select class="span4" id="payment_option" name="payment_option">
                                                    <option value=""> - Select - </option>
                                                    <option value="all" <?php echo ($payment_option == "all")?"selected":""?>>All</option>
                                                    <option value="creditcard" <?php echo ($payment_option == "creditcard")?"selected":""?>>Credit Card</option>
                                                    <option value="cod" <?php echo ($payment_option == "cod")?"selected":""?>>Payment on delivery</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Commission Charges</label>
                                            <div class="controls">
                                                <input id="commissionCharges" name="commissionCharges" class="span4" type="text" value="<?php echo $commission?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">DTCM Charges</label>
                                            <div class="controls">
                                                <input id="dtcm" name="dtcm" class="span4" type="text" value="<?php echo $dtcm?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Credit Charges</label>
                                            <div class="controls">
                                                <input id="creditCharge" name="creditCharge" class="span4" type="text" value="<?php echo $credit_charge?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Service Charges</label>
                                            <div class="controls">
                                                <input id="serviceCharge" name="serviceCharge" class="span4" type="text" value="<?php echo $service_charge?>"/>
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
					$qry_str_search = " AND (title LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM events 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM events 
						WHERE 1
						".$qry_str_search."
						ORDER BY tid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Events</h3>
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
                                <th> Event Name </th>
                                <th> Event Venue </th>
                                <th> Ongoing </th>
                                <th class="center"> Event Image </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['title'];
								$image = $row['pic'];
								$venue = $row['venue'];
								$ongoing = $row['ongoing'];
								$date_start = $row['date_start'];
								$date_end = $row['date_end'];
								
								if($ongoing == ONGOING) {
									$ongoing_text = "Ongoing";	
								} else if($ongoing == GUEST) {
									$ongoing_text = "Guest List";	
								} else {
									$ongoing_text = date("dS M Y", strtotime($date_start));
									
									if($date_end != "") {
										$ongoing_text .= "  to  " . date("dS M Y", strtotime($date_end));	
									}
								}
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $venue?></td>
                                <td><?php echo $ongoing_text?></td>
                                <td class="center"><img src="../data/<?php echo $image?>" alt="N/A" width="100"></td>
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
                                <h3> Add Event Category</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="categoryForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="9">
                                        <div class="control-group">
                                            <label class="control-label">Category Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Category Short Name</label>
                                            <div class="controls">
                                                <input id="ename" name="ename" class="span4" type="text"/>
                                            </div>
                                        </div>
										<div class="control-group">
                                            <label class="control-label">Category Description</label>
                                            <div class="controls">
                                                <input id="desc" name="desc" class="span12" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Category Image</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
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
				
				$count_qry = "SELECT COUNT(*) FROM category 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM category 
						WHERE 1
						".$qry_str_search."
						ORDER BY id DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Event Categories</h3>
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
                                <th class="center"> Category Image </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['name'];
								$image = $row['image'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td class="center"><img src="../upload/category/<?php echo $image?>" alt="N/A" width="30"></td>
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
			
			function listSeatTypeRecords() {
				global $config, $conn;
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets light-gray">
                            <div class="widget-head blue">
                                <h3> Add a Seat Type</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="seatTypeForm" method="post" action="">
                                    	<input type="hidden" name="f" value="13">
                                        
                                        <div class="control-group">
                                            <label class="control-label">Seat Type</label>
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
					$qry_str_search = " AND (seat_type LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM seats 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM seats 
						WHERE 1
						".$qry_str_search."
						ORDER BY id DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Event Seat Types</h3>
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
                                <th> Seat Type </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['seat_type'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
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
			
			function listEventCustomerRecords() {
				global $config, $conn;

				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (event_customer.fname LIKE '%".sqlSafe($_GET['searchFilter'])."%' || event_customer.lname LIKE '%".sqlSafe($_GET['searchFilter'])."%' event_customer.email LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM event_customer 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT event_customer.*, events.title, events.ongoing 
						FROM event_customer 
						LEFT JOIN events ON event_customer.tid = events.tid
						WHERE 1
						".$qry_str_search."
						ORDER BY event_customer.dateAdded DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Event Customers</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="18">
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
                                <th> Customer Name </th>
                                <th> Customer Email </th>
                                <th> Customer Mobile </th>
                                <th> Event Name </th>
                                <th class="center"> No. of Guest </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$customer_name = $row['fname']." ".$row['lname'];
								$customer_email = $row['email'];
								$customer_mobile = $row['mobile'];
								$event_name = $row['title'];
								$event_ongoing = $row['ongoing'];
								$num_of_guest = $row['noGuest'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $customer_name?></td>
                                <td><?php echo $customer_email?></td>
                                <td><?php echo $customer_mobile?></td>
                                <td><?php echo $event_name?></td>
                                <td><?php echo $num_of_guest?></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=17&id=<?php echo $id?>'}">
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
			
			function listEventAdsRecords() {
				global $conn;
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets light-gray">
                            <div class="widget-head blue">
                                <h3> Add Event Ad</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="eventAdForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="20">
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category">
                                                    <option value=""> - Select - </option>
                                                    <option value="all"> All </option>
                                                    <?php
                                                    $qry = "SELECT * FROM category ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Ad Image</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Ad Image Link</label>
                                            <div class="controls">
                                                <input id="link" name="link" class="span4" type="text"/>
                                            </div>
                                        </div>
										<div class="control-group">
                                            <label class="control-label">Ad Video URL</label>
                                            <div class="controls">
                                                <textarea id="video" name="video" class="span6" rows="3"></textarea>
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

				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM  event_adverts 
							  WHERE 1
							  ";
						
				$qry = "SELECT * FROM  event_adverts 
						WHERE 1
						ORDER BY id DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Event Ads</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="22">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                          
                        <?php
						if($res) {
						?>
        
                          <table class="responsive table tbl-serach table-striped table-bordered dataTable" id="data-table">
                            <thead>
                              <tr>
                              	<th><input name="allbox" type="checkbox" onclick="checkAllFields(1);" id="checkAll" /></th>
                                <th> Category Name </th>
                                <th class="center"> Ad Image </th>
                                <th> Ad Image Link </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$category = $row['category'];
								$image = $row['image'];
								$link = $row['link'];
								$video = $row['video'];
								
								if($category == "all") {
									$category_name = "All";	
								} else {
									$qry2 = "SELECT * FROM category WHERE id = '".sqlSafe($category)."' LIMIT 1";
									$res2 = mysqli_query($conn, $qry2);
									$row2 = mysqli_fetch_array($res2);	
									$category_name = $row2['name'];
								}
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $category_name?></td>
                                <td class="center"><img src="../data/advert/<?php echo $image?>" alt="N/A" width="100"></td>
                                <td><?php echo $link?></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=21&id=<?php echo $id?>'}">
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
			
				$qry = "SELECT * FROM events 
						WHERE title = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Event "<?php echo $name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					$image_name = "";
					$bg_image_name = "";
					$map_image_name = "";
					$floor_image_name = "";
					$voucher_image_name = "";
					$audio_file_name = "";
					$video_file_name = "";
					$picture_arr = array();
					$sponsor_logo_arr = array();
					$error_msg_arr = array();
					
					//upload event main image
					if(($_FILES["picture"]["name"] != "")){
						if($_FILES["picture"]["type"] == "image/jpg" || $_FILES["picture"]["type"] == "image/gif" || $_FILES["picture"]["type"] == "image/jpeg" || $_FILES["picture"]["type"] == "image/png") {
							if(($_FILES["picture"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Event Main Image size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time())."-main";
								$image_ext = preg_split("/\./", $_FILES["picture"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								move_uploaded_file($_FILES["picture"]["tmp_name"],"../data/$image_name");
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Event Main Image.";	
						}
					}
					
					//upload event background image
					if(($_FILES["pupload"]["name"] != "")){
						if($_FILES["pupload"]["type"] == "image/jpg" || $_FILES["pupload"]["type"] == "image/gif" || $_FILES["pupload"]["type"] == "image/jpeg" || $_FILES["pupload"]["type"] == "image/png") {
							if(($_FILES["pupload"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Event Background Image size must not be greater than 2048 KB.";
							}
							else {
								$bg_image_name = md5(time())."-bg";
								$bg_image_ext = preg_split("/\./", $_FILES["pupload"]["name"]);
								$bg_image_ext = $bg_image_ext[count($bg_image_ext)-1];
								$bg_image_name = $bg_image_name.".".$bg_image_ext;
								move_uploaded_file($_FILES["pupload"]["tmp_name"],"../data/$bg_image_name");
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Event Background Image.";	
						}
					}
					
					//upload event location map image
					if(($_FILES["locmap"]["name"] != "")){
						if($_FILES["locmap"]["type"] == "image/jpg" || $_FILES["locmap"]["type"] == "image/gif" || $_FILES["locmap"]["type"] == "image/jpeg" || $_FILES["locmap"]["type"] == "image/png") {
							if(($_FILES["locmap"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Location Map Image size must not be greater than 2048 KB.";
							}
							else {
								$map_image_name = md5(time())."-map";
								$map_image_ext = preg_split("/\./", $_FILES["locmap"]["name"]);
								$map_image_ext = $map_image_ext[count($map_image_ext)-1];
								$map_image_name = $map_image_name.".".$map_image_ext;
								move_uploaded_file($_FILES["locmap"]["tmp_name"],"../data/$map_image_name");
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Location Map Image.";	
						}
					}
					
					//upload event floor plan image
					if(($_FILES["floorplan"]["name"] != "")){
						if($_FILES["floorplan"]["type"] == "image/jpg" || $_FILES["floorplan"]["type"] == "image/gif" || $_FILES["floorplan"]["type"] == "image/jpeg" || $_FILES["floorplan"]["type"] == "image/png") {
							if(($_FILES["floorplan"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Floor Plan Image size must not be greater than 2048 KB.";
							}
							else {
								$floor_image_name = md5(time())."-map";
								$floor_image_ext = preg_split("/\./", $_FILES["floorplan"]["name"]);
								$floor_image_ext = $floor_image_ext[count($floor_image_ext)-1];
								$floor_image_name = $floor_image_name.".".$floor_image_ext;
								move_uploaded_file($_FILES["floorplan"]["tmp_name"],"../data/$floor_image_name");
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Floor Plan Image.";	
						}
					}
					
					//upload event voucher image
					if(($_FILES["voucherimage"]["name"] != "")){
						if($_FILES["voucherimage"]["type"] == "image/jpg" || $_FILES["voucherimage"]["type"] == "image/gif" || $_FILES["voucherimage"]["type"] == "image/jpeg" || $_FILES["voucherimage"]["type"] == "image/png") {
							if(($_FILES["voucherimage"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Voucher Image size must not be greater than 2048 KB.";
							}
							else {
								$voucher_image_name = md5(time())."-voucher";
								$voucher_image_ext = preg_split("/\./", $_FILES["voucherimage"]["name"]);
								$voucher_image_ext = $voucher_image_ext[count($voucher_image_ext)-1];
								$voucher_image_name = $voucher_image_name.".".$voucher_image_ext;
								move_uploaded_file($_FILES["voucherimage"]["tmp_name"],"../data/$voucher_image_name");
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Voucher Image.";	
						}
					}
					
					//upload audio file
					if(($_FILES["file_audio"]["name"] != "")){
						if($_FILES["file_audio"]["type"] == "audio/mpeg" || $_FILES["file_audio"]["type"] == "application/mp3" || $_FILES["file_audio"]["type"] == "audio/mpeg3" || $_FILES["file_audio"]["type"] == "audio/x-mpeg-3") {
							/*if(($_FILES["file_audio"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Audio file size must not be greater than 2048 KB.";
							}
							else*/ {
								$audio_file_name = md5(time())."-audio";
								$audio_file_ext = preg_split("/\./", $_FILES["file_audio"]["name"]);
								$audio_file_ext = $audio_file_ext[count($audio_file_ext)-1];
								$audio_file_name = $audio_file_name.".".$audio_file_ext;
								move_uploaded_file($_FILES["file_audio"]["tmp_name"],"../eventAudio/$audio_file_name");
							}
						}
						else {
							$error_msg_arr[] = "only mp3 is allowed for Audio File.";	
						}
					}
					
					//upload video file
					if(($_FILES["file_video"]["name"] != "")){
						if($_FILES["file_video"]["type"] == "video/x-flv") {
							/*if(($_FILES["file_audio"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Audio file size must not be greater than 2048 KB.";
							}
							else*/ {
								$video_file_name = md5(time())."-video";
								$video_file_ext = preg_split("/\./", $_FILES["file_video"]["name"]);
								$video_file_ext = $video_file_ext[count($video_file_ext)-1];
								$video_file_name = $video_file_name.".".$video_file_ext;
								move_uploaded_file($_FILES["file_video"]["tmp_name"],"../eventVideo/$video_file_name");
							}
						}
						else {
							$error_msg_arr[] = "only flv is allowed for Video File.";	
						}
					}
					
					//upload event other images
					for($i=0; $i<6; $i++) {
						$picture_name = "";
						
						if(($_FILES["event_pic".$i]["name"] != "")){
							if($_FILES["event_pic".$i]["type"] == "image/jpg" || $_FILES["event_pic".$i]["type"] == "image/gif" || $_FILES["event_pic".$i]["type"] == "image/jpeg" || $_FILES["event_pic".$i]["type"] == "image/png") {
								if(($_FILES["event_pic".$i]["size"] / 2048)  > 2048) {
									$error_msg_arr[] = "Event Image ".$i." size must not be greater than 2048 KB.";
								}
								else {
									$picture_name = md5(time()).$i;
									$picture_ext = preg_split("/\./", $_FILES["event_pic".$i]["name"]);
									$picture_ext = $picture_ext[count($picture_ext)-1];
									$picture_name = $picture_name.".".$picture_ext;
									move_uploaded_file($_FILES["event_pic".$i]["tmp_name"],"../data/$picture_name");
								}
							}
							else {
								$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Event Image ".$i.".";	
							}
						}
						
						$picture_arr[$i] = $picture_name;
					}
					
					//upload event sponsor logos
					for($i=0; $i<9; $i++) {
						$logo_name = "";
						
						if(($_FILES["sponsor_logo".$i]["name"] != "")){
							if($_FILES["sponsor_logo".$i]["type"] == "image/jpg" || $_FILES["sponsor_logo".$i]["type"] == "image/gif" || $_FILES["sponsor_logo".$i]["type"] == "image/jpeg" || $_FILES["sponsor_logo".$i]["type"] == "image/png") {
								if(($_FILES["sponsor_logo".$i]["size"] / 2048)  > 2048) {
									$error_msg_arr[] = "Sponsor Logo ".$i." size must not be greater than 2048 KB.";
								}
								else {
									$logo_name = md5(time()).$i;
									$logo_ext = preg_split("/\./", $_FILES["sponsor_logo".$i]["name"]);
									$logo_ext = $logo_ext[count($logo_ext)-1];
									$logo_name = $logo_name.".".$logo_ext;
									move_uploaded_file($_FILES["sponsor_logo".$i]["tmp_name"],"../data/$logo_name");
								}
							}
							else {
								$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Sponsor Logo ".$i.".";	
							}
						}
						
						$sponsor_logo_arr[$i] = $logo_name;
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
						if(!empty($time_start)) {
							$time_start_arr = explode(" ",$time_start);
							$time_start_part1 = $time_start_arr[0];
							$time_start_part2 = $time_start_arr[1];	
						} else {
							$time_start_part1 = "";
							$time_start_part2 = "";	
						}
						
						if(!empty($time_end)) {
							$time_end_arr = explode(" ",$time_end);
							$time_end_part1 = $time_end_arr[0];
							$time_end_part2 = $time_end_arr[1];	
						} else {
							$time_end_part1 = "";
							$time_end_part2 = "";	
						}
						
						$data=array(
							"title"=>sqlSafe(trim(strip_tags($name))),
							"`desc`"=>sqlSafe(stripslashes($desc)),
							"thumb"=>sqlSafe(trim(strip_tags($image_name))),
							"pic"=>sqlSafe(trim(strip_tags($image_name))),
							"popup_pic"=>sqlSafe(strip_tags($bg_image_name)),
							"date_start"=>sqlSafe(strip_tags($date_start)),
							"date_end"=>sqlSafe(strip_tags($date_end)),
							"venue"=>sqlSafe(strip_tags($venue)),
							"dress"=>sqlSafe(strip_tags($dress)),
							"age_limit"=>sqlSafe(strip_tags($age_limit)),
							"restaurant"=>sqlSafe(strip_tags($restaurant)),
							"rest_room"=>sqlSafe(strip_tags($rest_room)),
							"hot"=>sqlSafe(strip_tags($hot)),
							"city"=>sqlSafe(strip_tags($city)),
							"country"=>sqlSafe(strip_tags($country)),
							"promoter"=>sqlSafe(strip_tags($promoter)),
							"category"=>sqlSafe(strip_tags($category)),
							"loc_map"=>sqlSafe(strip_tags($map_image_name)),
							"floorplan"=>sqlSafe(strip_tags($floor_image_name)),
							"ongoing"=>sqlSafe(strip_tags($ongoing)),
							"session_hour"=>sqlSafe(strip_tags($session_hour)),
							"doors_open"=>sqlSafe(strip_tags($doors_open)),
							"sale_date"=>sqlSafe(strip_tags($sale_date)),
							"time_start"=>sqlSafe(strip_tags($time_start_part1)),
							"time_end"=>sqlSafe(strip_tags($time_end_part1)),
							"time_start_part"=>sqlSafe(strip_tags($time_start_part2)),
							"time_end_part"=>sqlSafe(strip_tags($time_end_part2)),
							"videoName"=>sqlSafe(strip_tags($video_file_name)),
							"audioName"=>sqlSafe(strip_tags($audio_file_name)),
							"voucher_image"=>sqlSafe(strip_tags($voucher_image_name)),
							"sponsor_logo1"=>sqlSafe(strip_tags($sponsor_logo_arr[1])),
							"sponsor_logo2"=>sqlSafe(strip_tags($sponsor_logo_arr[2])),
							"sponsor_logo3"=>sqlSafe(strip_tags($sponsor_logo_arr[3])),
							"sponsor_logo4"=>sqlSafe(strip_tags($sponsor_logo_arr[4])),
							"sponsor_logo5"=>sqlSafe(strip_tags($sponsor_logo_arr[5])),
							"sponsor_logo6"=>sqlSafe(strip_tags($sponsor_logo_arr[6])),
							"sponsor_logo7"=>sqlSafe(strip_tags($sponsor_logo_arr[7])),
							"sponsor_logo8"=>sqlSafe(strip_tags($sponsor_logo_arr[8])),
							"event_pic1"=>sqlSafe(strip_tags($picture_arr[1])),
							"event_pic2"=>sqlSafe(strip_tags($picture_arr[2])),
							"event_pic3"=>sqlSafe(strip_tags($picture_arr[3])),
							"event_pic4"=>sqlSafe(strip_tags($picture_arr[4])),
							"event_pic5"=>sqlSafe(strip_tags($picture_arr[5])),
							"commission"=>sqlSafe(strip_tags($commissionCharges)),
							"dtcm"=>sqlSafe(strip_tags($dtcm)),
							"credit_charge"=>sqlSafe(strip_tags($creditCharge)),
							"service_charge"=>sqlSafe(strip_tags($serviceCharge)),
							"dtcm_approved"=>sqlSafe(strip_tags($dtcm_approved)),
							"dtcm_code"=>sqlSafe(strip_tags($dtcm_code)),
							"fb_link"=>sqlSafe(strip_tags($fb_link)),
							"payment_option"=>sqlSafe(strip_tags($payment_option))
							);
						addItem("events", $data);
						listRecords();
					}

				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "events", "tid");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM events 
						WHERE title = '".sqlSafe(trim(strip_tags($name)))."' 
						AND tid != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Event!</strong> Event "<?php echo $name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
				}
				else {
					$old_image_name = $picture_name;
					$old_bg_image_name = $pupload_name;
					$old_locmap_name = $locmap_name;
					$old_floorplan_name = $floorplan_name;
					$old_voucherimage_name = $voucherimage_name;
					$old_file_audio_name = $file_audio_name;
					$old_file_video_name = $file_video_name;
					$event_image_arr = array();
					$sponsor_logo_arr = array();
					$error_msg_arr = array();
					
					//upload event main image
					if(($_FILES["picture"]["name"] != "")) {
						if($_FILES["picture"]["type"] == "image/jpg" || $_FILES["picture"]["type"] == "image/gif" || $_FILES["picture"]["type"] == "image/jpeg" || $_FILES["picture"]["type"] == "image/png") {
							if(($_FILES["picture"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Event Main Image size must not be greater than 2048 KB.";
							}
							else {
								$picture_name = md5(time())."-main";
								$picture_ext = preg_split("/\./", $_FILES["picture"]["name"]);
								$picture_ext = $picture_ext[count($picture_ext)-1];
								$picture_name = $picture_name.".".$picture_ext;
								
								if(move_uploaded_file($_FILES["picture"]["tmp_name"],"../data/$picture_name")) {
									
									$dest = "../data";
									
									if(file_exists($dest.'/'.$old_image_name)) {
										@unlink($dest.'/'.$old_image_name);
									}

								}
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Event Main Image.";	
						}
					}
					
					//upload event background image
					if(($_FILES["pupload"]["name"] != "")){
						if($_FILES["pupload"]["type"] == "image/jpg" || $_FILES["pupload"]["type"] == "image/gif" || $_FILES["pupload"]["type"] == "image/jpeg" || $_FILES["pupload"]["type"] == "image/png") {
							if(($_FILES["pupload"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Event Background Image size must not be greater than 2048 KB.";
							}
							else {
								$pupload_name = md5(time())."-bg";
								$pupload_ext = preg_split("/\./", $_FILES["pupload"]["name"]);
								$pupload_ext = $pupload_ext[count($pupload_ext)-1];
								$pupload_name = $pupload_name.".".$pupload_ext;
								
								if(move_uploaded_file($_FILES["pupload"]["tmp_name"],"../data/$pupload_name")) {
									
									$dest = "../data";
									
									if(file_exists($dest.'/'.$old_bg_image_name)) {
										@unlink($dest.'/'.$old_bg_image_name);
									}
									
								}
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Event Background Image.";	
						}
					}
					
					//upload event location map image
					if(($_FILES["locmap"]["name"] != "")){
						if($_FILES["locmap"]["type"] == "image/jpg" || $_FILES["locmap"]["type"] == "image/gif" || $_FILES["locmap"]["type"] == "image/jpeg" || $_FILES["locmap"]["type"] == "image/png") {
							if(($_FILES["locmap"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Location Map Image size must not be greater than 2048 KB.";
							}
							else {
								$locmap_name = md5(time())."-map";
								$locmap_ext = preg_split("/\./", $_FILES["locmap"]["name"]);
								$locmap_ext = $locmap_ext[count($locmap_ext)-1];
								$locmap_name = $locmap_name.".".$locmap_ext;
								
								if(move_uploaded_file($_FILES["locmap"]["tmp_name"],"../data/$locmap_name")) {
									
									$dest = "../data";
									
									if(file_exists($dest.'/'.$old_locmap_name)) {
										@unlink($dest.'/'.$old_locmap_name);
									}
									
								}
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Location Map Image.";	
						}
					}
					
					//upload event floor plan image
					if(($_FILES["floorplan"]["name"] != "")){
						if($_FILES["floorplan"]["type"] == "image/jpg" || $_FILES["floorplan"]["type"] == "image/gif" || $_FILES["floorplan"]["type"] == "image/jpeg" || $_FILES["floorplan"]["type"] == "image/png") {
							if(($_FILES["floorplan"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Floor Plan Image size must not be greater than 2048 KB.";
							}
							else {
								$floorplan_name = md5(time())."-floor";
								$floorplan_ext = preg_split("/\./", $_FILES["floorplan"]["name"]);
								$floorplan_ext = $floorplan_ext[count($floorplan_ext)-1];
								$floorplan_name = $floorplan_name.".".$floorplan_ext;
								
								if(move_uploaded_file($_FILES["floorplan"]["tmp_name"],"../data/$floorplan_name")) {
								
									$dest = "../data";
									
									if(file_exists($dest.'/'.$old_floorplan_name)) {
										@unlink($dest.'/'.$old_floorplan_name);
									}
									
								}
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Floor Plan Image.";	
						}
					}
					
					//upload event voucher image
					if(($_FILES["voucherimage"]["name"] != "")){
						if($_FILES["voucherimage"]["type"] == "image/jpg" || $_FILES["voucherimage"]["type"] == "image/gif" || $_FILES["voucherimage"]["type"] == "image/jpeg" || $_FILES["voucherimage"]["type"] == "image/png") {
							if(($_FILES["voucherimage"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Voucher Image size must not be greater than 2048 KB.";
							}
							else {
								$voucherimage_name = md5(time())."-voucher";
								$voucherimage_ext = preg_split("/\./", $_FILES["voucherimage"]["name"]);
								$voucherimage_ext = $voucherimage_ext[count($voucherimage_ext)-1];
								$voucherimage_name = $voucherimage_name.".".$voucherimage_ext;
								
								if(move_uploaded_file($_FILES["voucherimage"]["tmp_name"],"../data/$voucherimage_name")) {
								
									$dest = "../data";
									
									if(file_exists($dest.'/'.$old_voucherimage_name)) {
										@unlink($dest.'/'.$old_voucherimage_name);
									}
								
								}
							}
						}
						else {
							$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Voucher Image.";	
						}
					}
					
					//upload audio file
					if(($_FILES["file_audio"]["name"] != "")){
						if($_FILES["file_audio"]["type"] == "audio/mpeg" || $_FILES["file_audio"]["type"] == "application/mp3" || $_FILES["file_audio"]["type"] == "audio/mpeg3" || $_FILES["file_audio"]["type"] == "audio/x-mpeg-3") {
							/*if(($_FILES["file_audio"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Audio file size must not be greater than 2048 KB.";
							}
							else*/ {
								$file_audio_name = md5(time())."-audio";
								$file_audio_ext = preg_split("/\./", $_FILES["file_audio"]["name"]);
								$file_audio_ext = $file_audio_ext[count($file_audio_ext)-1];
								$file_audio_name = $file_audio_name.".".$file_audio_ext;
								
								if(move_uploaded_file($_FILES["file_audio"]["tmp_name"],"../eventAudio/$file_audio_name")) {
									
									$dest = "../eventAudio";
									
									if(file_exists($dest.'/'.$old_file_audio_name)) {
										@unlink($dest.'/'.$old_file_audio_name);
									}
										
								}
							}
						}
						else {
							$error_msg_arr[] = "only mp3 is allowed for Audio File.";	
						}
					}
					
					//upload video file
					if(($_FILES["file_video"]["name"] != "")){
						if($_FILES["file_video"]["type"] == "video/x-flv") {
							/*if(($_FILES["file_audio"]["size"] / 2048)  > 2048) {
								$error_msg_arr[] = "Audio file size must not be greater than 2048 KB.";
							}
							else*/ {
								$file_video_name = md5(time())."-video";
								$file_video_ext = preg_split("/\./", $_FILES["file_video"]["name"]);
								$file_video_ext = $file_video_ext[count($file_videoe_ext)-1];
								$file_video_name = $file_video_name.".".$file_video_ext;
								
								if(move_uploaded_file($_FILES["file_video"]["tmp_name"],"../eventVideo/$file_video_name")) {
									
									$dest = "../eventVideo";
									
									if(file_exists($dest.'/'.$old_file_video_name)) {
										@unlink($dest.'/'.$old_file_video_name);
									}
								
								}
							}
						}
						else {
							$error_msg_arr[] = "only flv is allowed for Video File.";	
						}
					}
					
					//upload event other images
					for($i=0; $i<6; $i++) {
						$event_image_name = $_POST["event_pic".$i."_name"];
						$old_event_image_name = $event_image_name;
						
						if(($_FILES["event_pic".$i]["name"] != "")){
							if($_FILES["event_pic".$i]["type"] == "image/jpg" || $_FILES["event_pic".$i]["type"] == "image/gif" || $_FILES["event_pic".$i]["type"] == "image/jpeg" || $_FILES["event_pic".$i]["type"] == "image/png") {
								if(($_FILES["event_pic".$i]["size"] / 2048)  > 2048) {
									$error_msg_arr[] = "Event Image ".$i." size must not be greater than 2048 KB.";
								}
								else {
									$event_image_name = md5(time())."-event".$i;
									$event_image_ext = preg_split("/\./", $_FILES["event_pic".$i]["name"]);
									$event_image_ext = $event_image_ext[count($event_image_ext)-1];
									$event_image_name = $event_image_name.".".$event_image_ext;
									
									if(move_uploaded_file($_FILES["event_pic".$i]["tmp_name"],"../data/$event_image_name")) {
										
										$dest = "../data";
										
										if(file_exists($dest.'/'.$old_event_image_name)) {
											@unlink($dest.'/'.$old_event_image_name);
										}
										
									}
								}
							}
							else {
								$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Event Image ".$i.".";	
							}
						}
						
						$event_image_arr[$i] = $event_image_name;
					}
					
					//upload event sponsor logos
					for($i=0; $i<9; $i++) {
						$logo_name = $_POST["sponsor_logo".$i."_name"];
						$old_logo_name = $logo_name;
						
						if(($_FILES["sponsor_logo".$i]["name"] != "")){
							if($_FILES["sponsor_logo".$i]["type"] == "image/jpg" || $_FILES["sponsor_logo".$i]["type"] == "image/gif" || $_FILES["sponsor_logo".$i]["type"] == "image/jpeg" || $_FILES["sponsor_logo".$i]["type"] == "image/png") {
								if(($_FILES["sponsor_logo".$i]["size"] / 2048)  > 2048) {
									$error_msg_arr[] = "Sponsor Logo ".$i." size must not be greater than 2048 KB.";
								}
								else {
									$logo_name = md5(time())."-logo".$i;
									$logo_ext = preg_split("/\./", $_FILES["sponsor_logo".$i]["name"]);
									$logo_ext = $logo_ext[count($logo_ext)-1];
									$logo_name = $logo_name.".".$logo_ext;
									
									if(move_uploaded_file($_FILES["sponsor_logo".$i]["tmp_name"],"../data/$logo_name")) {
										
										$dest = "../data";
										
										if(file_exists($dest.'/'.$old_logo_name)) {
											@unlink($dest.'/'.$old_logo_name);
										}
										
									}
								}
							}
							else {
								$error_msg_arr[] = "Only jpg/jpeg, gif and png images are allowed for Sponsor Logo ".$i.".";	
							}
						}
						
						$sponsor_logo_arr[$i] = $logo_name;
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
						if(!empty($time_start)) {
							$time_start_arr = explode(" ",$time_start);
							$time_start_part1 = $time_start_arr[0];
							$time_start_part2 = $time_start_arr[1];	
						} else {
							$time_start_part1 = "";
							$time_start_part2 = "";	
						}
						
						if(!empty($time_end)) {
							$time_end_arr = explode(" ",$time_end);
							$time_end_part1 = $time_end_arr[0];
							$time_end_part2 = $time_end_arr[1];	
						} else {
							$time_end_part1 = "";
							$time_end_part2 = "";	
						}
						
						$data=array(
							"title"=>sqlSafe(trim(strip_tags($name))),
							"`desc`"=>sqlSafe(stripslashes($desc)),
							"thumb"=>sqlSafe(trim(strip_tags($image_name))),
							"pic"=>sqlSafe(trim(strip_tags($picture_name))),
							"popup_pic"=>sqlSafe(strip_tags($pupload_name)),
							"date_start"=>sqlSafe(strip_tags($date_start)),
							"date_end"=>sqlSafe(strip_tags($date_end)),
							"venue"=>sqlSafe(strip_tags($venue)),
							"dress"=>sqlSafe(strip_tags($dress)),
							"age_limit"=>sqlSafe(strip_tags($age_limit)),
							"restaurant"=>sqlSafe(strip_tags($restaurant)),
							"rest_room"=>sqlSafe(strip_tags($rest_room)),
							"hot"=>sqlSafe(strip_tags($hot)),
							"city"=>sqlSafe(strip_tags($city)),
							"country"=>sqlSafe(strip_tags($country)),
							"promoter"=>sqlSafe(strip_tags($promoter)),
							"category"=>sqlSafe(strip_tags($category)),
							"loc_map"=>sqlSafe(strip_tags($locmap_name)),
							"floorplan"=>sqlSafe(strip_tags($floorplan_name)),
							"ongoing"=>sqlSafe(strip_tags($ongoing)),
							"session_hour"=>sqlSafe(strip_tags($session_hour)),
							"doors_open"=>sqlSafe(strip_tags($doors_open)),
							"sale_date"=>sqlSafe(strip_tags($sale_date)),
							"time_start"=>sqlSafe(strip_tags($time_start_part1)),
							"time_end"=>sqlSafe(strip_tags($time_end_part1)),
							"time_start_part"=>sqlSafe(strip_tags($time_start_part2)),
							"time_end_part"=>sqlSafe(strip_tags($time_end_part2)),
							"videoName"=>sqlSafe(strip_tags($file_video_name)),
							"audioName"=>sqlSafe(strip_tags($file_audio_name)),
							"voucher_image"=>sqlSafe(strip_tags($voucherimage_name)),
							"sponsor_logo1"=>sqlSafe(strip_tags($sponsor_logo_arr[1])),
							"sponsor_logo2"=>sqlSafe(strip_tags($sponsor_logo_arr[2])),
							"sponsor_logo3"=>sqlSafe(strip_tags($sponsor_logo_arr[3])),
							"sponsor_logo4"=>sqlSafe(strip_tags($sponsor_logo_arr[4])),
							"sponsor_logo5"=>sqlSafe(strip_tags($sponsor_logo_arr[5])),
							"sponsor_logo6"=>sqlSafe(strip_tags($sponsor_logo_arr[6])),
							"sponsor_logo7"=>sqlSafe(strip_tags($sponsor_logo_arr[7])),
							"sponsor_logo8"=>sqlSafe(strip_tags($sponsor_logo_arr[8])),
							"event_pic1"=>sqlSafe(strip_tags($event_image_arr[1])),
							"event_pic2"=>sqlSafe(strip_tags($event_image_arr[2])),
							"event_pic3"=>sqlSafe(strip_tags($event_image_arr[3])),
							"event_pic4"=>sqlSafe(strip_tags($event_image_arr[4])),
							"event_pic5"=>sqlSafe(strip_tags($event_image_arr[5])),
							"commission"=>sqlSafe(strip_tags($commissionCharges)),
							"dtcm"=>sqlSafe(strip_tags($dtcm)),
							"credit_charge"=>sqlSafe(strip_tags($creditCharge)),
							"service_charge"=>sqlSafe(strip_tags($serviceCharge)),
							"dtcm_approved"=>sqlSafe(strip_tags($dtcm_approved)),
							"dtcm_code"=>sqlSafe(strip_tags($dtcm_code)),
							"fb_link"=>sqlSafe(strip_tags($fb_link)),
							"payment_option"=>sqlSafe(strip_tags($payment_option))
							);
						
						editItem("events", $data, $id, "tid");
						listRecords();
					}
				}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "events", "tid");
				listRecords();
			break;
			
			case 8;
				listCategoryRecords();
			break;
			
			case 9:
				$qry = "SELECT * FROM category 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Category "<?php echo $name?>" already exists.
					</div>
				<?php
					listCategoryRecords();
							
				} else {
					
					$image_name = "";
					$error_msg = "";
					
					if(($_FILES["image"]["name"] != "")){
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg = "Category Image size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time());
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								move_uploaded_file($_FILES["image"]["tmp_name"],"../upload/category/$image_name");
								resizeImg("../upload/category/$image_name", 30, 30);
							}
						}
						else {
							$error_msg = "Only jpg/jpeg, gif and png images are allowed for Category Image.";	
						}
					}
					
					if(!empty($error_msg)) {
						?>
                    	<div class="alert">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?=$error_msg?>
                        </div>
						<?php
						
						listCategoryRecords($id);
					} else {
					
						$data=array(
							"name"=>sqlSafe(trim(strip_tags($name))),
							"ename"=>sqlSafe(trim(strip_tags($ename))),
							"`desc`"=>sqlSafe(trim(strip_tags($desc))),
							"image"=>sqlSafe(trim(strip_tags($image_name)))
							);
						addItem("category", $data);
						listCategoryRecords();
					}
				}
			break;
			
			case 10;
				deleteListItem($id, "category", "id");
				listCategoryRecords();
			break;
			
			case 11;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "category", "id");
				listCategoryRecords();
			break;
			
			case 12;
				listSeatTypeRecords();
			break;
			
			case 13:
				$qry = "SELECT * FROM seats 
						WHERE seat_type = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Seat Type "<?php echo $name?>" already exists.
					</div>
				<?php
					listSeatTypeRecords();
							
				} else {
					
					$data=array(
						"seat_type"=>sqlSafe(trim(strip_tags($name)))
						);
					addItem("seats", $data);
					listSeatTypeRecords();
					
				}
			break;
			
			case 14;
				deleteListItem($id, "seats", "id");
				listSeatTypeRecords();
			break;
			
			case 15;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "seats", "id");
				listSeatTypeRecords();
			break;
			
			case 16;
				listEventCustomerRecords();
			break;
			
			case 17;
				deleteListItem($id, "event_customer", "eventCustomerId");
				listEventCustomerRecords();
			break;
			
			case 18;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "event_customer", "eventCustomerId");
				listEventCustomerRecords();
			break;
			
			case 19;
				listEventAdsRecords();
			break;
			
			case 20:
				$qry = "SELECT * FROM event_adverts 
						WHERE category = '".sqlSafe(strip_tags($category))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Ad for Category "<?php echo $name?>" already exists.
					</div>
				<?php
					listEventAdsRecords();
							
				} else {
					
					$image_name = "";
					$error_msg = "";
					
					if(($_FILES["image"]["name"] != "")){
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg = "Ad Image size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time());
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								move_uploaded_file($_FILES["image"]["tmp_name"],"../data/advert/$image_name");
							}
						}
						else {
							$error_msg = "Only jpg/jpeg, gif and png images are allowed for Ad Image.";	
						}
					}
					
					if(!empty($error_msg)) {
						?>
                    	<div class="alert">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?=$error_msg?>
                        </div>
						<?php
						
						listCategoryRecords($id);
					} else {
					
						$data=array(
							"category"=>sqlSafe(trim(strip_tags($category))),
							"image"=>sqlSafe(trim(strip_tags($image_name))),
							"link"=>sqlSafe(trim(strip_tags($link))),
							"video"=>sqlSafe(stripslashes($video))
							);
						addItem("event_adverts", $data);
						listEventAdsRecords();
					}
				}
			break;
			
			case 21;
				deleteListItem($id, "event_adverts", "id");
				listEventAdsRecords();
			break;
			
			case 22;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "event_adverts", "id");
				listEventAdsRecords();
			break;
		  
			default;
				listRecords();
			break;
			}
			?>
            
            
		</div>
	</div>
    <script>
	(function() {
		$("[class='switchButton']").bootstrapSwitch();
	}).call(this);

	$('#dtcm_approved').on('switchChange.bootstrapSwitch', function (event, state) {
		$("#dtcmCodeContainer").toggle(500);
	});
	</script>
	<?php include_once("footer.php")?>
</div>
</body>
</html>