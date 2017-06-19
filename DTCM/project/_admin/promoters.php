<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Promoters";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Promoters Management</title>
<?php include_once("top.php")?>
<link href="css/bootstrap-switch.css" rel="stylesheet">
<script src="js/bootstrap-switch.js"></script>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			name: "required",
			email: {
				required: true,
				email: true
			},
			address: "required",
			login: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			}
		},
		messages: {
			name: "Please enter promoter name",
			email: "Please enter a valid email address",
			address: "Please provide an address",
			login: {
				required: "Please enter a login name",
				minlength: "Your login name must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			}
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
						<h3 class="page-header">Promoters Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Admin"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Admins"><i class="icon-th-list"></i></a></li>
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
                                <h3> Add a Promoter</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">E-Mail</label>
                                            <div class="controls">
                                                <input id="email" name="email" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Phone No.</label>
                                            <div class="controls">
                                                <input id="phone" name="phone" class="span4" type="text"/>
                                            </div>
                                        </div>
                                         <div class="control-group">
                                            <label class="control-label">Fax No.</label>
                                            <div class="controls">
                                                <input id="fax" name="fax" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Address</label>
                                            <div class="controls">
                                                <input id="address" name="address" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Website</label>
                                            <div class="controls">
                                                <input id="website" name="website" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Login Name</label>
                                            <div class="controls">
                                                <input id="login" name="login" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Password</label>
                                            <div class="controls">
                                                <input id="password" name="password" type="password" class="span4"/>
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
				
				$qry = "SELECT * FROM promoters 
						WHERE spid='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$name = $row['name'];
				$address = $row['desc'];
				$phone = $row['phone'];
				$login = $row['login'];
				$password = $row['password'];
				$blockuser = $row['blockuser'];
				$fax = $row['fax'];
				$email = $row['email'];
				$website = $row['website'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Promoter</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        <div class="control-group">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span6" type="text" value="<?php echo $name?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">E-Mail</label>
                                            <div class="controls">
                                                <input id="email" name="email" type="text" class="span4" value="<?php echo $email?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Phone No.</label>
                                            <div class="controls">
                                                <input id="phone" name="phone" class="span4" type="text" value="<?php echo $phone?>"/>
                                            </div>
                                        </div>
                                         <div class="control-group">
                                            <label class="control-label">Fax No.</label>
                                            <div class="controls">
                                                <input id="fax" name="fax" type="text" class="span4" value="<?php echo $fax?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Address</label>
                                            <div class="controls">
                                                <input id="address" name="address" class="span6" type="text" value="<?php echo $address?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Website</label>
                                            <div class="controls">
                                                <input id="website" name="website" class="span4" type="text" value="<?php echo $website?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Login Name</label>
                                            <div class="controls">
                                                <input id="login" name="login" class="span4" type="text" value="<?php echo $login?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Password</label>
                                            <div class="controls">
                                                <input id="password" name="password" type="password" class="span4" value="<?php echo $password?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Block</label>
                                            <div class="controls">
                                                <input id="blockuser" name="blockuser" type="hidden" value="No" />
                                                <input id="blockuser" name="blockuser" type="checkbox" data-on-color="info" data-off-color="warning" data-handle-width="45" <?php echo ($blockuser == "Yes")?"checked=\"checked\"":""?> value="Yes" class="switchButton">
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
					$qry_str_search = " AND (name LIKE '%".sqlSafe($_GET['searchFilter'])."%' || login LIKE '%".sqlSafe($_GET['searchFilter'])."%' || email LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM promoters 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM promoters 
						WHERE 1
						".$qry_str_search."
						 ORDER BY spid DESC";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Promoters</h3>
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
                                <th> Email </th>
                                <th> Address </th>
                                <th> Phone No. </th>
                                <th> Fax No. </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['name'];
								$email = $row['email'];
								$address = $row['desc'];
								$phone = $row['phone'];
								$fax = $row['fax'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $email?></td>
                                <td><?php echo $address?></td>
                                <td><?php echo $phone?></td>
                                <td><?php echo $fax?></td>
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
				$qry = "SELECT * FROM promoters 
						WHERE name = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Promoter "<?php echo $name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($name))),
						"`desc`"=>sqlSafe(trim(strip_tags($address))),
						"phone"=>sqlSafe(trim(strip_tags($phone))),
						"login"=>sqlSafe(strip_tags($login)),
						"password"=>sqlSafe(strip_tags($password)),
						"fax"=>sqlSafe(strip_tags($fax)),
						"email"=>sqlSafe(strip_tags($email)),
						"website"=>sqlSafe(strip_tags($website))
						);
					addItem("promoters", $data);
					listRecords();
					
				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "promoters", "spid");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM promoters 
						WHERE name = '".sqlSafe(trim(strip_tags($name)))."' 
						AND spid != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0)
					{
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Promoter "<?php echo $name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
					}
				else
					{
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($name))),
						"`desc`"=>sqlSafe(trim(strip_tags($address))),
						"phone"=>sqlSafe(trim(strip_tags($phone))),
						"login"=>sqlSafe(strip_tags($login)),
						"password"=>sqlSafe(strip_tags($password)),
						"blockuser"=>sqlSafe(strip_tags($blockuser)),
						"fax"=>sqlSafe(strip_tags($fax)),
						"email"=>sqlSafe(strip_tags($email)),
						"website"=>sqlSafe(strip_tags($website))
						);
					
					editItem("promoters", $data, $id, "spid");
					listRecords();
					}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "promoters", "spid");
				listRecords();
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
	</script>
	<?php include_once("footer.php")?>
</div>
</body>
</html>