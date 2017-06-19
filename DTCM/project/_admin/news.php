<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "News";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | News Management</title>
<?php include_once("top.php")?>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
$(function() {
	$(function () {
        $('.onlyDatePicker').datetimepicker({
            pickTime: false
        });
    });
	
	$("#recordForm").validate({
		rules: {
			name: "required",
			image: "required",
			date: "required",
			description: "required"
			
		},
		messages: {
			name: "Please enter news title",
			image: "Please provide news image",
			date: "Please provide news date",
			description: "Please provide news content"
			
		}
	});
	
	$("#recordEditForm").validate({
		rules: {
			name: "required",
			date: "required",
			description: "required"
			
		},
		messages: {
			name: "Please enter news title",
			date: "Please provide news date",
			description: "Please provide news content"
			
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
						<h3 class="page-header">News Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add News"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List News"><i class="icon-th-list"></i></a></li>
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
                                <h3> Add a News</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Title</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Image</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">News Date</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="date" id="date" data-format="dd-MM-yyyy" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Content</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" class="span6" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">URL</label>
                                            <div class="controls">
                                                <input id="url" name="url" class="span6" type="text"/>
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
				
				$qry = "SELECT * FROM tblnews 
						WHERE newsid='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$name = $row['title'];
				$date = $row['date'];
				$month = $row['month'];
				$year = $row['year'];
				$image = $row['image'];
				$description = $row['description'];
				$url = $row['url'];
				$monthNum = date('m', strtotime("$month $date $year"));
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update News</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        <div class="control-group">
                                            <label class="control-label">Title</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text" value="<?php echo $name?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Image</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                                <input name="image_name" type="hidden" value="<?=$image?>">
                                                <br />
												<?
                                                if($image != ""){
                                                ?>
                                                	<img src="../images/<?=$image?>" width="100" alt="" style="vertical-align:text-top;" />
                                                <?
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">News Date</label>
                                            <div class="controls">
                                                <div class="input-append onlyDatePicker">
                                                    <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                                    <input name="date" id="date" data-format="dd-MM-yyyy" type="text" value="<?php echo $date."-".$monthNum."-".$year?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Content</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" class="span6" rows="5"><?php echo $description?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">URL</label>
                                            <div class="controls">
                                                <input id="url" name="url" class="span6" type="text" value="<?php echo $url?>"/>
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
				
				$count_qry = "SELECT COUNT(*) FROM tblnews 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM tblnews 
						WHERE 1
						".$qry_str_search."
						ORDER BY newsid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of News</h3>
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
                                <th> Title </th>
                                <th class="center"> Image </th>
                                <th class="center"> Date </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['title'];
								$image = $row['image'];
								$date = $row['date']." ".$row['month']." ".$row['year'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td class="center"><img src="../images/<?php echo $image?>" alt="N/A" width="100"></td>
                                <td class="center"><?php echo $date?></td>
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
				$qry = "SELECT * FROM  tblnews 
						WHERE title = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> News with title "<?php echo $name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					$image_name = "";
					$error_msg = "";
					
					if(($_FILES["image"]["name"] != "")){
						if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/gif" || $_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/png") {
							if(($_FILES["image"]["size"] / 2048)  > 2048) {
								$error_msg = "Image size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time());
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								move_uploaded_file($_FILES["image"]["tmp_name"],"../images/$image_name");
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
                            <i class="icon-exclamation-sign"></i><strong>Warning!</strong> <?=$error_msg?>
                        </div>
						<?php
						addRecordForm();
					}
					else {
						if(!empty($date)) {
							$date_arr = explode("-", $date);
							$day = $date_arr[0];
							$month = $date_arr[1];
							$year = $date_arr[2];
							
							$month = date('F', mktime(0, 0, 0, $month, 10));
						}
						
						$data=array(
							"title"=>sqlSafe(trim(strip_tags($name))),
							"date"=>sqlSafe(trim(strip_tags($day))),
							"month"=>sqlSafe(strip_tags($month)),
							"year"=>sqlSafe(strip_tags($year)),
							"image"=>sqlSafe(trim(strip_tags($image_name))),
							"description"=>sqlSafe(strip_tags($description)),
							"url"=>sqlSafe(strip_tags($url))
							);
						addItem("tblnews", $data);
						listRecords();
					}

				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "tblnews", "newsid");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM tblnews 
						WHERE title = '".sqlSafe(trim(strip_tags($name)))."' 
						AND newsid != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> News with title "<?php echo $name?>" already exists.
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
								$error_msg = "Image size must not be greater than 2048 KB.";
							}
							else {
								$image_name = md5(time());
								$image_ext = preg_split("/\./", $_FILES["image"]["name"]);
								$image_ext = $image_ext[count($image_ext)-1];
								$image_name = $image_name.".".$image_ext;
								
								if(move_uploaded_file($_FILES["image"]["tmp_name"],"../images/$image_name")) {

									$dest = "../images";
									
									if(file_exists($dest.'/'.$old_image_name)) {
										@unlink($dest.'/'.$old_image_name);
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
						
						editRecordForm($id);
					}
					else {
						if(!empty($date)) {
							$date_arr = explode("-", $date);
							$day = $date_arr[0];
							$month = $date_arr[1];
							$year = $date_arr[2];
							
							$month = date('F', mktime(0, 0, 0, $month, 10));
						}
						
						$data=array(
							"title"=>sqlSafe(trim(strip_tags($name))),
							"date"=>sqlSafe(trim(strip_tags($day))),
							"month"=>sqlSafe(strip_tags($month)),
							"year"=>sqlSafe(strip_tags($year)),
							"image"=>sqlSafe(trim(strip_tags($image_name))),
							"description"=>sqlSafe(strip_tags($description)),
							"url"=>sqlSafe(strip_tags($url))
							);
						
						editItem("tblnews", $data, $id, "newsid");
						listRecords();
					}
				}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "tblnews", "newsid");
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