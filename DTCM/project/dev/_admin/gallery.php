<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Gallery";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Gallery Management</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			category: "required",
			image: "required"
			
		},
		messages: {
			category: "Please select a category",
			image: "Please provide an image"
			
		}
	});
	
	$("#recordCategoryForm").validate({
		rules: {
			name: "required",
			image: "required"
			
		},
		messages: {
			name: "Please enter category name",
			image: "Please provide an image"
			
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
						<h3 class="page-header">Gallery Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Gallery"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Gallery"><i class="icon-th-list"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {}
			
			function editRecordForm($id) {}
			
			function listRecords() {
				
				global $config, $conn;
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets light-gray">
                            <div class="widget-head blue">
                                <h3> Add a Photo</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
                                            <div class="controls">
                                                <select class="span4" id="category" name="category">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM tblphotocategory ORDER BY category ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['catid']?>"><?php echo $row['category']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Image</label>
                                            <div class="controls">
                                                <input name="image" type="file" id="image" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" class="span6" rows="5"></textarea>
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
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (tblphoto.catid = '".sqlSafe($_GET['searchFilter'])."')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM tblphoto 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT tblphoto.*, tblphotocategory.category
						FROM tblphoto 
						LEFT JOIN tblphotocategory ON tblphoto.catid = tblphotocategory.catid
						WHERE 1
						".$qry_str_search."
						ORDER BY tblphoto.photoid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Gallery Photos</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="5">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                            
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="dataTables_filter" id="data-table_filter">
                                <label>Category:
                                  <select class="span4" id="searchFilter" name="searchFilter" onChange="form.submit()" style="width:250px;">
                                      <option value=""> - All - </option>
                                      <?php
                                      $qry2 = "SELECT * FROM tblphotocategory ORDER BY category ASC";
                                      $res2 = mysqli_query($conn, $qry2);
                                      while($row2 = mysqli_fetch_array($res2)) {
                                      ?>
                                          <option value="<?php echo $row2['catid']?>"><?php echo $row2['category']?></option>
                                      <?php
                                      }
                                      ?>
                                  </select>
                                </label>
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
                                <th class="center"> Image </th>
                                <th class="center"> Category </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$image = $row['image'];
								$category = $row['category'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td class="center"><img src="../photoimages/<?php echo $image?>" alt="N/A" width="100"></td>
                                <td class="center"><?php echo $category?></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
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
				
				global $config, $conn;
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets light-gray">
                            <div class="widget-head blue">
                                <h3> Add a Category</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordCategoryForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="7">
                                        <div class="control-group">
                                            <label class="control-label">Category</label>
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
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (category LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM tblphotocategory 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM tblphotocategory 
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
                        <h3>List of Gallery Categories</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="9">
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
								$image = $row['image'];
								$category = $row['category'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $category?></td>
                                <td class="center"><img src="../photoimages/<?php echo $image?>" alt="N/A" width="100"></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=8&id=<?php echo $id?>'}">
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
				listRecords();
			break;
	
			case 2:
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
							move_uploaded_file($_FILES["image"]["tmp_name"],"../photoimages/$image_name");
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
					listRecords();
				}
				else {
					$data=array(
						"catid"=>sqlSafe(trim(strip_tags($category))),
						"image"=>sqlSafe(trim(strip_tags($image_name))),
						"description"=>sqlSafe(strip_tags($description))
						);
					addItem("tblphoto", $data);
					listRecords();
				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "tblphoto", "photoid");
				listRecords();
			break;
		
			case 5;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "tblphoto", "photoid");
				listRecords();
			break;
			
			case 6:
				listCategoryRecords();
			break;
	
			case 7:
				$qry = "SELECT * FROM  tblphotocategory 
						WHERE category = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Gallery category "<?php echo $name?>" already exists.
					</div>
				<?php
					listCategoryRecords();
							
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
								move_uploaded_file($_FILES["image"]["tmp_name"],"../photoimages/$image_name");
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
						listCategoryRecords();
					}
					else {
						$data=array(
							"category"=>sqlSafe(trim(strip_tags($name))),
							"image"=>sqlSafe(trim(strip_tags($image_name)))
							);
						addItem("tblphotocategory", $data);
						listCategoryRecords();
					}
				}
			break;
	
			case 8;
				deleteListItem($id, "tblphotocategory", "catid");
				listCategoryRecords();
			break;
		
			case 9;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "tblphotocategory", "catid");
				listCategoryRecords();
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