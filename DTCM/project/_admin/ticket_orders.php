<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Ticket Orders";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Ticket Orders Management</title>
<?php include_once("top.php")?>
<script type="text/javascript">
$(function() {

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
						<h3 class="page-header">Ticket Orders Management</h3>
					</div>
				</div>
			</div>
			
			
            <?php
            function addRecordForm() {}
			
			function editRecordForm($id) {}
			
			function listRecords() {
				
				global $config, $conn;
				
				$url_str = "";
				$page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
				if($page == "" || $page <= 0 ) $page = 1;

				if(isset($_GET['searchFilter']) && ($_GET['searchFilter'] != "")) {
					$qry_str_search = " AND (ticket_orders.order_number LIKE '%".sqlSafe($_GET['searchFilter'])."%')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM ticket_orders 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT ticket_orders.*, 
						customers.fname AS customer_fname, 
						customers.lname AS customer_lname, 
						customers.email AS customer_email,
						events.title AS event_title 
						FROM ticket_orders 
						LEFT JOIN customers ON ticket_orders.cust_id = customers.cust_id
						LEFT JOIN events ON ticket_orders.tid = events.tid
						WHERE 1
						".$qry_str_search."
						ORDER BY ticket_orders.oid DESC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of All Orders</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="7">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                            
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="dataTables_filter" id="data-table_filter">
                                <label>Search Order Number:
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
                                <th> Order Number </th>
                                <th> Customer Name </th>
                                <th> Customer Email </th>
                                <th> Event </th>
                                <th class="center"> Ticket Quantity </th>
                                <th class="center"> Ticket Price </th>
                                <th class="center"> Payment Type </th>
                                <th class="center"> Payment Status </th>
                                <th class="center"> Order Date </th>
                                <th class="center"> Action </th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$order_number = $row['order_number'];
								$customer_name = $row['customer_fname']." ".$row['customer_lname'];
								$customer_email = $row['customer_email'];
								$event_title = $row['event_title'];
								$tickets = $row['tickets'];
								$ticket_price = $row['ticket_price'];
								$payment_type = $row['payment_type'];
								$payment_status = $row['payment_status'];
								$order_date = $row['order_date'];
							?>
                              <tr>
                                <td><input type="checkbox" name="delAnn[]" value="<?php echo $id?>"/></td>
                                <td><?php echo $order_number?></td>
                                <td><?php echo $customer_name?></td>
                                <td><?php echo $customer_email?></td>
                                <td><?php echo $event_title?></td>
                                <td class="center"><?php echo $tickets?></td>
                                <td class="center"><?php echo $ticket_price?></td>
                                <td class="center"><?php echo $payment_type?></td>
                                <td class="center">
                                <?php 
								if($payment_status !== 'paid'){
								?>
                                    <div class="btn-group">
                                        <button class="btn btn-primary"><?php echo ucwords($payment_status)?></button>
                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                            <a href="?f=2&page=<?php echo $page?>&id=<?php echo $id?>&status=unpaid">Unpaid</a>
                                            </li>
                                            <li>
                                            <a href="?f=2&page=<?php echo $page?>&id=<?php echo $id?>&status=paid">Paid</a>
                                            </li>
                                            <li>
                                            <a href="?f=2&page=<?php echo $page?>&id=<?php echo $id?>&status=cancelled">Cancelled</a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php
								} else {
									echo ucwords($payment_status);	
								}
								?>
                                </td>
                                <td class="center"><?php echo $order_date?></td>
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
			?>
            
            <?php
            switch($f) {
			
			case 2;
				if(isset($id) && !empty($id) && isset($status) && !empty($status)) {
					$data=array(
						"payment_status"=>sqlSafe(trim(strip_tags($status)))
						);
					
					editItem(" ticket_orders", $data, $id, "oid");	
				}
				listRecords();
			break;
			
			case 3;
				listRecords();
			break;
			
			case 4;
				deleteListItem($id, "subscribes", "id");
				listRecords();
			break;	
		
			case 7;
				$delAnn = isset($delAnn)?$delAnn:array();
				actionSelected($delAnn, "subscribes", "id");
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