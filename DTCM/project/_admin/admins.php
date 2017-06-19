<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Admin Users";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Admin Users Management</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {
	$("#recordForm").validate({
		rules: {
			full_name: {
				required: true,
				minlength: 2
			},
			user_name: {
				required: true,
				minlength: 2
			},
			email: {
				required: true,
				email: true
			},
			phone: "required",
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			}
		},
		messages: {
			full_name: {
				required: "Please enter user's full name",
				minlength: "Your full name must consist of at least 2 characters"
			},
			user_name: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			email: "Please enter a valid email address",
			phone: "Please enter a valid phone number",
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
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
						<h3 class="page-header">Admin Users Management</h3>
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
                                <h3> Add Admin User</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Full Name</label>
                                            <div class="controls">
                                                <input id="full_name" name="full_name" class="span4" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">User Name</label>
                                            <div class="controls">
                                                <input id="user_name" name="user_name" class="span4" type="text"/>
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
                                                <input id="phone" name="phone" type="text" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Password</label>
                                            <div class="controls">
                                                <input id="password" name="password" type="password" class="span4"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Confirm Password</label>
                                            <div class="controls">
                                                <input id="confirm_password" name="confirm_password" type="password" class="span4"/>
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
				
				$qry = "SELECT * FROM event_admin 
						WHERE adminID='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$full_name = $row['name'];
				$user_name = $row['login'];
				$user_email = $row['email'];
				$user_password = $row['password'];
				$user_phone = $row['phone'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Admin User</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">

                                        <div class="control-group">
                                            <label class="control-label">Full Name</label>
                                            <div class="controls">
                                                <input id="full_name" name="full_name" class="span4" type="text" value="<?php echo $full_name?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">User Name</label>
                                            <div class="controls">
                                                <input id="user_name" name="user_name" class="span4" type="text" value="<?php echo $user_name?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">E-Mail</label>
                                            <div class="controls">
                                                <input id="email" name="email" type="text" class="span4" value="<?php echo $user_email?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Phone No.</label>
                                            <div class="controls">
                                                <input id="phone" name="phone" type="text" class="span4" value="<?php echo $user_phone?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Password</label>
                                            <div class="controls">
                                                <input id="password" name="password" type="password" class="span4" value="<?php echo $user_password?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Confirm Password</label>
                                            <div class="controls">
                                                <input id="confirm_password" name="confirm_password" type="password" class="span4" value="<?php echo $user_password?>"/>
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
				
				$count_qry = "SELECT COUNT(*) FROM event_admin 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM event_admin 
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
                        <h3>List of Admin Users</h3>
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
                                <th> Full Name </th>
                                <th> Email </th>
                                <th> User Name </th>
                                <th> Phone No. </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$user_name = $row['name'];
								$user_email = $row['email'];
								$user_login = $row['login'];
								$user_phone = $row['phone'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $user_name?></td>
                                <td><?php echo $user_email?></td>
                                <td><?php echo $user_login?></td>
                                <td><?php echo $user_phone?></td>
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
				$qry = "SELECT * FROM event_admin 
						WHERE login = '".sqlSafe(strip_tags($user_name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Username "<?php echo $user_name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($full_name))),
						"login"=>sqlSafe(strip_tags($user_name)),
						"email"=>sqlSafe(strip_tags($email)),
						"password"=>sqlSafe(strip_tags(md5($password))),
						"phone"=>$phone
						);
					addItem("event_admin", $data);
					listRecords();
					
				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "event_admin", "adminID");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM event_admin 
						WHERE login = '".sqlSafe(trim(strip_tags($user_name)))."' 
						AND adminID != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0)
					{
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Username "<?php echo $user_name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
					}
				else
					{
					$row = mysqli_fetch_array($res);
					$current_password = $row['password'];
					
					$data=array(
						"name"=>sqlSafe(trim(strip_tags($full_name))),
						"login"=>sqlSafe(trim(strip_tags($user_name))),
						"email"=>sqlSafe(trim(strip_tags($email))),
						"phone"=>$phone
						);
						
					if($password != $current_password) {
						$data["password"] = sqlSafe(trim(strip_tags(md5($password))));	
					}
					
					editItem("event_admin", $data, $id, "adminID");
					listRecords();
					}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "event_admin", "adminID");
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