<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Cities";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | City Management</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			name: "required",
			rate: "required"
		},
		messages: {
			name: "Please enter a country name",
			rate: "Please enter a country rate"
			
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
						<h3 class="page-header">Cities Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add City"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Cities"><i class="icon-th-list"></i></a></li>
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
                                <h3> Add a City</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <select class="span4" id="country" name="country">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM shippingrates ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['countryid']?>"><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">City Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text"/>
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
				
				$qry = "SELECT * FROM cities 
						WHERE id='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$name = $row['name'];
				$cid = $row['cid'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update City</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
										<div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                <select class="span4" id="country" name="country">
                                                    <option value=""> - Select - </option>
                                                    <?php
                                                    $qry = "SELECT * FROM shippingrates ORDER BY name ASC";
													$res = mysqli_query($conn, $qry);
													while($row = mysqli_fetch_array($res)) {
													?>
                                                    	<option value="<?php echo $row['countryid']?>" <?php echo ($cid == $row['countryid'])?"selected":""?>><?php echo $row['name']?></option>
                                                    <?php
													}
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">City Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span4" type="text" value="<?php echo $name?>"/>
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
					$qry_str_search = " AND (cities.name LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM cities 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT cities.*, shippingrates.name AS country_name 
						FROM cities 
						LEFT JOIN shippingrates ON cities.cid = shippingrates.countryid
						WHERE 1
						".$qry_str_search."
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Cities</h3>
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
                                <th> City Name </th>
                                <th> Country </th>
                                <th class="center"> Default </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$city_name = $row['name'];
								$country_name = $row['country_name'];
								$default_city = $row['default_city'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $city_name?></td>
                                <td><?php echo $country_name?></td>
                                <td class="center">
                                <?php 
								if($default_city == "1") {
								?>
                                	<span class="label label-success">Default City</span>
                                <?php
								} else {
								?>
                                	<a href="?f=8&id=<?php echo $id?>&page=<?php echo $page?>">
                                    <span class="label">Set Default</span>
                                    </a>
                                <?php	
								}
								?>
                                </td>
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
				$qry = "SELECT * FROM cities 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> City "<?php echo $user_name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($name))),
						"cid"=>sqlSafe(strip_tags($country))
						);
					addItem("cities", $data);
					listRecords();
					
				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "cities", "id");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM cities 
						WHERE name = '".sqlSafe(trim(strip_tags($name)))."' 
						AND id != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0)
					{
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> City "<?php echo $user_name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
					}
				else
					{
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($name))),
						"cid"=>sqlSafe(trim(strip_tags($country)))
						);
					
					editItem("cities", $data, $id, "id");
					listRecords();
					}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "cities", "id");
				listRecords();
			break;
			
			case 8;
				$qry = "UPDATE cities SET default_city = '1' WHERE id = '".sqlSafe($id)."' ";
				mysqli_query($conn, $qry);
				
				if(mysqli_affected_rows($conn) > 0) {
					$qry2 = "UPDATE cities SET default_city = '0' WHERE id != '".sqlSafe($id)."' ";
					mysqli_query($conn, $qry2);	
				}
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