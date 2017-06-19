<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Partners";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Partners Management</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	
	$("#recordForm").validate({
		rules: {
			name: "required",
			image: "required",
			url: "required"
			
		},
		messages: {
			name: "Please enter partner name",
			image: "Please provide partner logo",
			url: "Please provide partner url"
			
		}
	});
	
	$("#recordEditForm").validate({
		rules: {
			name: "required",
			url: "required"
			
		},
		messages: {
			name: "Please enter partner name",
			url: "Please provide partner url"
			
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
						<h3 class="page-header">Partners Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Partner"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Partners"><i class="icon-th-list"></i></a></li>
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
                                <h3> Add a Partner</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
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
                                            <label class="control-label">URL</label>
                                            <div class="controls">
                                                <input id="url" name="url" class="span4" type="text"/>
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
				
				$qry = "SELECT * FROM tblpartners 
						WHERE partnerid='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$name = $row['name'];
				$image = $row['image'];
				$url = $row['url'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Partner</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
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
                                                <input name="image_name" type="hidden" value="<?=$image?>">
                                                <br />
												<?
                                                if($image != ""){
                                                ?>
                                                	<img src="../siteimages/<?=$image?>" width="100" alt="N/A" style="vertical-align:text-top;" />
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
				
				$count_qry = "SELECT COUNT(*) FROM tblpartners 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM tblpartners 
						WHERE 1
						".$qry_str_search."
						ORDER BY partnerid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Partners</h3>
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
                                <th> Name </th>
                                <th class="center"> Logo </th>
                                <th class="center"> URL </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['name'];
								$image = $row['image'];
								$url = $row['url'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td class="center"><img src="../siteimages/<?php echo $image?>" alt="N/A" width="100"></td>
                                <td class="center"><?php echo $url?></td>
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
				$qry = "SELECT * FROM  tblpartners 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Partner "<?php echo $name?>" already exists.
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
								move_uploaded_file($_FILES["image"]["tmp_name"],"../siteimages/$image_name");
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
							"name"=>sqlSafe(trim(strip_tags($name))),
							"image"=>sqlSafe(trim(strip_tags($image_name))),
							"url"=>sqlSafe(strip_tags($url))
							);
						addItem(" tblpartners", $data);
						listRecords();
					}

				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, " tblpartners", "partnerid");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM  tblpartners 
						WHERE name = '".sqlSafe(trim(strip_tags($name)))."' 
						AND partnerid != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Partner "<?php echo $name?>" already exists.
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
								
								if(move_uploaded_file($_FILES["image"]["tmp_name"],"../siteimages/$image_name")) {

									$dest = "../siteimages";
									
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
							"name"=>sqlSafe(trim(strip_tags($name))),
							"image"=>sqlSafe(trim(strip_tags($image_name))),
							"url"=>sqlSafe(strip_tags($url))
							);
						
						editItem(" tblpartners", $data, $id, "partnerid");
						listRecords();
					}
				}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, " tblpartners", "partnerid");
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