<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Newsletter";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Newsletter Management</title>
<?php include_once("top.php")?>
<script src="js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
$(function() {
	$(function() {
		$('textarea.tinymce-simple').tinymce({
			script_url : 'js/tiny_mce/tiny_mce.js',
			theme : "simple"
			});
	});
	
	$("#recordForm").validate({
		rules: {
			name: "required",
			description: "required"
			
		},
		messages: {
			name: "Please enter news title",
			description: "Please provide news content"
			
		}
	});
	
	$("#recordEditForm").validate({
		rules: {
			name: "required",
			description: "required"
			
		},
		messages: {
			name: "Please enter news title",
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
						<h3 class="page-header">Newsletter Management</h3>
						<ul class="top-right-toolbar">
							<li><a href="?f=1" class="green" title="Add Newsletter"><i class=" icon-plus-sign"></i></a></li>
							<li><a href="?f=3" class="bondi-blue" title="List Newsletters"><i class="icon-th-list"></i></a></li>
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
                                <h3> Add a Newsletter</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="2">
                                        <div class="control-group">
                                            <label class="control-label">Title</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span6" type="text"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Content</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" rows="8" cols="80" style="width: 70%" class="tinymce-simple"></textarea>
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
				
				$qry = "SELECT * FROM ticketma_ticketdbff_messages 
						WHERE message_id='".sqlSafe(trim(strip_tags($id)))."'	
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				$row = mysqli_fetch_array($res);
				
				$title = $row['message_title'];
				$description = $row['message_content'];
			?>
            	<div class="row-fluid">
                    <div class="span12">
                        <div class="content-widgets gray">
                            <div class="widget-head orange">
                                <h3> Update Newsletter</h3>
                            </div>
                            <div class="widget-container">
                                <div class="form-container grid-form form-background">
                                    <form class="form-horizontal left-align" id="recordEditForm" method="post" action="" enctype="multipart/form-data">
                                    	<input type="hidden" name="f" value="6">
          								<input type="hidden" name="id" value="<?php echo $id?>">
                                        <div class="control-group">
                                            <label class="control-label">Title</label>
                                            <div class="controls">
                                                <input id="name" name="name" class="span6" type="text" value="<?php echo $title?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Content</label>
                                            <div class="controls">
                                                <textarea id="description" name="description" rows="8" cols="80" style="width: 70%" class="tinymce-simple"><?php echo $description?></textarea>
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
					$qry_str_search = " AND (message_title LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM ticketma_ticketdbff_messages 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM ticketma_ticketdbff_messages 
						WHERE 1
						".$qry_str_search."
						ORDER BY message_id ASC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Newsletters</h3>
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
                                <th class="center"> Date </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$title = $row['message_title'];
								$date = $row['message_date'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $title?></td>
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
			
			function listEmailRecords() {
				
				global $config, $conn;
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (first LIKE '%".sqlSafe($_GET['searchFilter'])."%' || last LIKE '%".sqlSafe($_GET['searchFilter'])."%' || email LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM  ticketma_ticketdbff_emails_table 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM  ticketma_ticketdbff_emails_table 
						WHERE 1
						".$qry_str_search."
						ORDER BY e_date DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Emails</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="10">
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
                                <th> Position </th>
                                <th> Country </th>
                                <th> Company </th>
                                <th class="center"> Phone No. </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$name = $row['first']." ".$row['last'];
								$position = $row['position'];
								$Country = $row['Country'];
								$organization = $row['organization'];
								$phone = $row['tel'];
								$email = $row['email'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $name?></td>
                                <td><?php echo $email?></td>
                                <td><?php echo $position?></td>
                                <td><?php echo $Country?></td>
                                <td><?php echo $organization?></td>
                                <td class="center"><?php echo $phone?></td>
                                <td class="center">
                                  <div class="btn-toolbar row-action">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-danger" title="Delete" onClick="javascript:if(confirm('Are you sure you want to delete this record?')) {location.href='?f=9&id=<?php echo $id?>'}">
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
				$qry = "SELECT * FROM  ticketma_ticketdbff_messages 
						WHERE message_title = '".sqlSafe(strip_tags($name))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
					<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Newsletter with title "<?php echo $name?>" already exists.
					</div>
				<?php
					addRecordForm();
							
				} else {
					
					$data=array(
						"message_title"=>sqlSafe(trim(strip_tags($name))),
						"message_content"=>sqlSafe(stripslashes($description)),
						"message_date"=>sqlSafe(date("Y-m-d"))
						);
					addItem("ticketma_ticketdbff_messages", $data);
					listRecords();


				}
			break;
	
			case 3;
				listRecords();
			break;
	
			case 4;
				deleteListItem($id, "ticketma_ticketdbff_messages", "message_id");
				listRecords();
			break;
	
			case 5:
				editRecordForm($id);
				break;
	
			case 6:
				$qry = "SELECT * FROM ticketma_ticketdbff_messages 
						WHERE message_title = '".sqlSafe(trim(strip_tags($name)))."' 
						AND message_id != '".sqlSafe(trim(strip_tags($id)))."'
						LIMIT 1
						";
				$res = mysqli_query($conn, $qry);
				if(mysqli_num_rows($res) > 0) {
				?>
                	<div class="alert">
						<button data-dismiss="alert" class="close" type="button">×</button>
						<i class="icon-exclamation-sign"></i><strong>Warning!</strong> Newsletter with title "<?php echo $name?>" already exists.
					</div>
				<?php
					editRecordForm($id);		
				}
				else {

					$data=array(
						"message_title"=>sqlSafe(trim(strip_tags($name))),
						"message_content"=>sqlSafe(stripslashes($description)),
						"message_date"=>sqlSafe(date("Y-m-d"))
						);
					
					editItem("ticketma_ticketdbff_messages", $data, $id, "message_id");
					listRecords();

				}
			break;		
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "ticketma_ticketdbff_messages", "message_id");
				listRecords();
			break;
			
			case 8;
				listEmailRecords();
			break;
			
			case 9;
				deleteListItem($id, "ticketma_ticketdbff_emails_table", "e_id");
				listEmailRecords();
			break;
			
			case 10;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "ticketma_ticketdbff_emails_table", "e_id");
				listEmailRecords();
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