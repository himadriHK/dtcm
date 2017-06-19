<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Outlets";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Outlets Management</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			name: "required",
			heading: "required",
			image: "required",
			city1: "required",
			address1: "required"
			
		},
		messages: {
			name: "Please enter outlet name",
			heading: "Please enter outlet heading",
			image: "Please provide outlet logo",
			city1: "Please provide city name",
			address1: "Please provide city address"
			
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
						<h3 class="page-header">Outlets Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Outlets"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Outlets"><i class="icon-th-list"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Add an Outlet</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Outlet Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Outlet Heading</label>
                                            <div class="controls">
                                                <input id="heading" name="heading" type="text" class="span12"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Outlet Logo</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">1. City Name</label>
                                            <div class="controls">
                                                <input id="city1" name="city1" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">1. City Address</label>
                                            <div class="controls">
                                                <input id="address1" name="address1" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">2. City Name</label>
                                            <div class="controls">
                                                <input id="city2" name="city2" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">2. City Address</label>
                                            <div class="controls">
                                                <input id="address2" name="address2" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">3. City Name</label>
                                            <div class="controls">
                                                <input id="city3" name="city3" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">3. City Address</label>
                                            <div class="controls">
                                                <input id="address3" name="address3" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">4. City Name</label>
                                            <div class="controls">
                                                <input id="city4" name="city4" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">4. City Address</label>
                                            <div class="controls">
                                                <input id="address4" name="address4" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">5. City Name</label>
                                            <div class="controls">
                                                <input id="city5" name="city5" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">5. City Address</label>
                                            <div class="controls">
                                                <input id="address5" name="address5" class="span6" type="text"/>
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
			
			function editRecordForm($id) {
				global $conn;
				
				$qry = "SELECT * FROM outlets 
						WHERE outid='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$name = $row['outlet'];
				$heading = $row['heading'];
				$picture = $row['picture'];
				$city1 = $row['city1'];
				$address1 = $row['address1'];
				$city2 = $row['city2'];
				$address2 = $row['address2'];
				$city3 = $row['city3'];
				$address3 = $row['address3'];
				$city4 = $row['city4'];
				$address4 = $row['address4'];
				$city5 = $row['city5'];
				$address5 = $row['address5'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Outlet</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        <div class="control-group">
                                            <label class="control-label">Outlet Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span6" type="text" value="<?php echo $name?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Outlet Heading</label>
                                            <div class="controls">
                                                <input id="heading" name="heading" type="text" class="span12" value="<?php echo $heading?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Outlet Logo</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                                <input name="image_name" type="hidden" value="<?=$picture?>">
                                                <br />
												<?
                                                if($picture != ""){
                                                ?>
                                                	<img src="../data/<?=$picture?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">1. City Name</label>
                                            <div class="controls">
                                                <input id="city1" name="city1" type="text" class="span4" value="<?php echo $city1?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">1. City Address</label>
                                            <div class="controls">
                                                <input id="address1" name="address1" class="span6" type="text" value="<?php echo $address1?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">2. City Name</label>
                                            <div class="controls">
                                                <input id="city2" name="city2" type="text" class="span4" value="<?php echo $city2?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">2. City Address</label>
                                            <div class="controls">
                                                <input id="address2" name="address2" class="span6" type="text" value="<?php echo $address2?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">3. City Name</label>
                                            <div class="controls">
                                                <input id="city3" name="city3" type="text" class="span4" value="<?php echo $city3?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">3. City Address</label>
                                            <div class="controls">
                                                <input id="address3" name="address3" class="span6" type="text" value="<?php echo $address3?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">4. City Name</label>
                                            <div class="controls">
                                                <input id="city4" name="city4" type="text" class="span4" value="<?php echo $city4?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">4. City Address</label>
                                            <div class="controls">
                                                <input id="address4" name="address4" class="span6" type="text" value="<?php echo $address4?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">5. City Name</label>
                                            <div class="controls">
                                                <input id="city5" name="city5" type="text" class="span4" value="<?php echo $city5?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">5. City Address</label>
                                            <div class="controls">
                                                <input id="address5" name="address5" class="span6" type="text" value="<?php echo $address5?>"/>
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
			
			function listRecords() {
				
				global $config, $conn;
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (outlet LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM outlets 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM outlets 
						WHERE 1
						".$qry_str_search."
						ORDER BY outid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Outlets</h3>
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
                                <th> Outlet Name </th>
                                <th class="center"> Outlet Logo </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['outlet'];
								$picture = $row['picture'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td class="center"><img src="../data/<?php echo $picture?>" alt="N/A" width="100"></td>
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
			?>
            
            <?php
            switch($f) {
			case 1:
				addRecordForm();
			break;
	
			case 2:
				$qry = "SELECT * FROM outlets 
						WHERE outlet = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Outlet "<?php echo $name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					$image_name = "";
					$error_msg = "";
					
					if(($_FILES["image"]["name"] != "")){
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg = "Logo size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time());
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								move_uploaded_file($_FILES["image"]["tmp_name"],"../data/$image_name");
							}
						}
						else {
							$error_msg = "Only jpg/jpeg, gif and png images are allowed for Logo.";	
						}
					}
					
					
					if($error_msg != "") {
						?>
                        <div class="alert">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?=$error_msg?>
                        </div>
						<?php
						addRecordForm();
					}
					else {
						$data=array(
							"outlet"=>sqlSafe(trim(strip_tags($name))),
							"heading"=>sqlSafe(trim(strip_tags($heading))),
							"picture"=>sqlSafe(trim(strip_tags($image_name))),
							"city1"=>sqlSafe(strip_tags($city1)),
							"address1"=>sqlSafe(strip_tags($address1)),
							"city2"=>sqlSafe(strip_tags($city2)),
							"address2"=>sqlSafe(strip_tags($address2)),
							"city3"=>sqlSafe(strip_tags($city3)),
							"address3"=>sqlSafe(strip_tags($address3)),
							"city4"=>sqlSafe(strip_tags($city4)),
							"address4"=>sqlSafe(strip_tags($address4)),
							"city5"=>sqlSafe(strip_tags($city5)),
							"address5"=>sqlSafe(strip_tags($address5))
							);
						addItem("outlets", $data);
						listRecords();
					}

				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "outlets", "outid");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM outlets 
						WHERE outlet = '".sqlSafe(trim(strip_tags($name)))."' 
						AND outid != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Outlet "<?php echo $name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
				}
				else {
					$old_image_name = $image_name;
					$error_msg = "";
					
					if(($_FILES["image"]["name"] != "")) {
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg = "Logo size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time());
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
							$error_msg = "Only jpg/jpeg, gif and png images are allowed for Logo.";	
						}
					}
					
					if($error_msg != "") {
						?>
						<div class="alert">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?php echo $error_msg?>
                        </div>
						<?php
						
						editRecordForm($id);
					}
					else {
						$data=array(
							"outlet"=>sqlSafe(trim(strip_tags($name))),
							"heading"=>sqlSafe(trim(strip_tags($heading))),
							"picture"=>sqlSafe(trim(strip_tags($image_name))),
							"city1"=>sqlSafe(strip_tags($city1)),
							"address1"=>sqlSafe(strip_tags($address1)),
							"city2"=>sqlSafe(strip_tags($city2)),
							"address2"=>sqlSafe(strip_tags($address2)),
							"city3"=>sqlSafe(strip_tags($city3)),
							"address3"=>sqlSafe(strip_tags($address3)),
							"city4"=>sqlSafe(strip_tags($city4)),
							"address4"=>sqlSafe(strip_tags($address4)),
							"city5"=>sqlSafe(strip_tags($city5)),
							"address5"=>sqlSafe(strip_tags($address5))
							);
						
						editItem("outlets", $data, $id, "outid");
						listRecords();
					}
				}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "outlets", "outid");
				listRecords();
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