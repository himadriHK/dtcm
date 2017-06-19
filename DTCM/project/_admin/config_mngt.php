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
<title><?php echo $config['SITE_NAME']?> | Update Configuration Settings</title>
<?php include_once("top.php")?>
<link href="css/bootstrap-switch.css" rel="stylesheet">
<script src="js/bootstrap-switch.js"></script>
<style>
.form-horizontal .control-label {
	width: 200px !important;
}
.form-horizontal .controls {
    margin-left: 230px !important;
}
</style>
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
						<h3 class="page-header">Configuration Settings</h3>
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
			
			function editRecordForm() {
				global $conn;
				$generalConfig = array();
				$sqlConfig = array();
				$sftpConfig = array();
				$controlFileConfig = array();
				$commandFileConfig = array();
				
				$qry = "SELECT * FROM config";
				$res = mysqli_query($conn, $qry);
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Configuration</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="1">
                                        
                                        <?php
										while($row = mysqli_fetch_array($res)) {
											$id = $row['id'];
											$option = $row['option'];
											$value = $row['value'];

											if($option == "SFTP_URL" || $option == "SFTP_USERNAME" || $option == "SFTP_PASSWORD") {
												
												$sftpConfig[] = array("id"=>$id, "option"=>$option, "value"=>$value);
												
											} elseif($option == "SQL_SERVER" || $option == "SQL_DATABASE" || $option == "SQL_USER" || $option == "SQL_PASSWORD") {
												
												$sqlConfig[] = array("id"=>$id, "option"=>$option, "value"=>$value);
												
											} elseif($option == "MERCHANT_CODE" || $option == "MERCHANT_SITE_CODE" || $option == "ENVIRONMENT" 
													|| $option == "WEB_SERVICE_URL" || $option == "SEND_EMAIL_NOTIFICATION" || $option == "EMAIL_NOTIFICATION_TO" 
													|| $option == "EMAIL_NOTIFICATION_CC" || $option == "EMAIL_NOTIFICATION_BCC") {
												
												$controlFileConfig[] = array("id"=>$id, "option"=>$option, "value"=>$value);
												
											} elseif($option == "IMPORT_NEW_PRODUCTS" || $option == "AUTOMATICALLY_ACTIVATE_EXISTING_PRODUCTS"
													 || $option == "AUTOMATICALLY_DEACTIVATE_EXISTING_PRODUCTS" || $option == "UPDATE_STOCK_OF_EXISTING_PRODUCTS") {
												
												$commandFileConfig[] = array("id"=>$id, "option"=>$option, "value"=>$value);
												
											} else {
												
												$generalConfig[] = array("id"=>$id, "option"=>$option, "value"=>$value);
												
											}

										}
										
										if(!empty($generalConfig)) {
										?>
                                        	<fieldset class="default">
                                            	<legend>General Configuration</legend>
                                        <?php
											for($i=0; $i<count($generalConfig); $i++) {
										?>
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo str_replace("_"," ",$generalConfig[$i]['option'])?></label>
                                                    <div class="controls">
                                                        <input id="config[<?php echo $generalConfig[$i]['id']?>]" name="config[<?php echo $generalConfig[$i]['id']?>]" class="span12" type="text" value="<?php echo $generalConfig[$i]['value']?>" />
                                                    </div>
                                                </div>
                                        <?php
											}
										?>
                                        	</fieldset>
                                        <?php	
										}

										if(!empty($sftpConfig)) {
										?>
                                        	<fieldset class="default">
                                            	<legend>SFTP Configuration</legend>
                                        <?php
											for($i=0; $i<count($sftpConfig); $i++) {
										?>
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo str_replace("_"," ",$sftpConfig[$i]['option'])?></label>
                                                    <div class="controls">
                                                        <input id="config[<?php echo $sftpConfig[$i]['id']?>]" name="config[<?php echo $sftpConfig[$i]['id']?>]" class="span12" type="text" value="<?php echo $sftpConfig[$i]['value']?>" />
                                                    </div>
                                                </div>
                                        <?php
											}
										?>
                                        	</fieldset>
                                        <?php	
										}
										
										if(!empty($sqlConfig)) {
										?>
                                        	<fieldset class="default">
                                            	<legend>SQL Configuration</legend>
                                        <?php
											for($i=0; $i<count($sqlConfig); $i++) {
										?>
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo str_replace("_"," ",$sqlConfig[$i]['option'])?></label>
                                                    <div class="controls">
                                                        <input id="config[<?php echo $sqlConfig[$i]['id']?>]" name="config[<?php echo $sqlConfig[$i]['id']?>]" class="span12" type="text" value="<?php echo $sqlConfig[$i]['value']?>" />
                                                    </div>
                                                </div>
                                        <?php
											}
										?>
                                        	</fieldset>
                                        <?php	
										}
										
										if(!empty($controlFileConfig)) {
										?>
                                        	<fieldset class="default">
                                            	<legend>Control File Configuration</legend>
                                        <?php
											for($i=0; $i<count($controlFileConfig); $i++) {
										?>
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo str_replace("_"," ",$controlFileConfig[$i]['option'])?></label>
                                                    <div class="controls">
                                                    <?php
                                                    if($controlFileConfig[$i]['option'] == "ENVIRONMENT") {
													?>
                                                    	<select id="config[<?php echo $controlFileConfig[$i]['id']?>]" name="config[<?php echo $controlFileConfig[$i]['id']?>]" class="span12">
                                                            <option value="review" <?php echo ($controlFileConfig[$i]['value'] == "review")?"selected":""?>>Review</option>
                                                            <!--<option value="staging" <?php echo ($controlFileConfig[$i]['value'] == "staging")?"selected":""?>>Staging</option>-->
                                                            <option value="production" <?php echo ($controlFileConfig[$i]['value'] == "production")?"selected":""?>>Production</option>
                                                        </select>
                                                    <?php
													} elseif($controlFileConfig[$i]['option'] == "SEND_EMAIL_NOTIFICATION") {
													?>
                                                    	<label class="checkbox">
                                                        <input id="config[<?php echo $controlFileConfig[$i]['id']?>]" name="config[<?php echo $controlFileConfig[$i]['id']?>]" type="hidden" value="false" />
                                                        <input id="config[<?php echo $controlFileConfig[$i]['id']?>]" name="config[<?php echo $controlFileConfig[$i]['id']?>]" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" <?php echo ($controlFileConfig[$i]['value'] == "true")?"checked=\"checked\"":""?> value="true" class="switchButton">
                                                        <!--enable email notification-->
                                                        </label>
                                                    <?php
													} else {
													?>
                                                        <input id="config[<?php echo $controlFileConfig[$i]['id']?>]" name="config[<?php echo $controlFileConfig[$i]['id']?>]" class="span12" type="text" value="<?php echo $controlFileConfig[$i]['value']?>" />
                                                        
                                                    <?php
                                                    	if($controlFileConfig[$i]['option'] == "WEB_SERVICE_URL") {
													?>
                                                    		<span class="help-block">Integration Web Service URL will also be changed according to <strong>Environment</strong>.</span>
                                                    <?php
														}    
													?>
                                                        
                                                    <?php
													}
													?>
                                                    </div>
                                                </div>
                                        <?php
											}
										?>
                                        	</fieldset>
                                        <?php	
										}
										
										if(!empty($commandFileConfig)) {
										?>
                                        	<fieldset class="default">
                                            	<legend>Command File Configuration (For Product Import)</legend>
                                        <?php
											for($i=0; $i<count($commandFileConfig); $i++) {
										?>
                                                <div class="control-group">
                                                    <label class="control-label"><?php echo str_replace("_"," ",$commandFileConfig[$i]['option'])?></label>
                                                    <div class="controls">
                                                    	<input id="config[<?php echo $commandFileConfig[$i]['id']?>]" name="config[<?php echo $commandFileConfig[$i]['id']?>]" type="hidden" value="false" />
                                                        <input id="config[<?php echo $commandFileConfig[$i]['id']?>]" name="config[<?php echo $commandFileConfig[$i]['id']?>]" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" <?php echo ($commandFileConfig[$i]['value'] == "true")?"checked=\"checked\"":""?> value="true" class="switchButton">
                                                        
                                                        <?php
                                                        if($commandFileConfig[$i]['option'] == "AUTOMATICALLY_ACTIVATE_EXISTING_PRODUCTS") {
															echo "&nbsp;&nbsp; If Product is activated in JDE it will be automatically activated in Tileshop";	
														}
														elseif($commandFileConfig[$i]['option'] == "AUTOMATICALLY_DEACTIVATE_EXISTING_PRODUCTS") {
															echo "&nbsp;&nbsp; If Product is deactivated in JDE it will be automatically deactivated in Tileshop";	
														}
														?>
                                                        
                                                    </div>
                                                </div>
                                        <?php
											}
										?>
                                        	</fieldset>
                                        <?php	
										}
										?>

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

				foreach ($config as $id => $value) {
					$qry = "UPDATE config 
							SET value = '".sqlSafe($config[$id])."' 
							WHERE id = '".($id)."'
							";
					mysqli_query($conn, $qry);
				}
				
			?>
            	<div class="alert alert-success">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <i class="icon-ok-sign"></i><strong>Success!</strong> Configuration Settings has been updated.
                </div>
            <?php
					
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