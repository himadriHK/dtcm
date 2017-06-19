<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "$include_dir/pagination.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Reports";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Reports Management</title>
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
						<h3 class="page-header">Reports Management</h3>
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
					$qry_str_search = " AND (promoter = '".sqlSafe($_GET['searchFilter'])."')";
					$url_str .= "&searchFilter=".$_GET['searchFilter'];
				} else {
					$qry_str_search = "";	
				}
				
				if(isset($_GET['f']) && ($_GET['f'] != "")) {
					$url_str .= "&f=".$_GET['f'];	
				} else {
					$url_str .= "&f=3";	
				}
				
				$count_qry = "SELECT COUNT(*) FROM events 
							  WHERE 1
							  ".$qry_str_search;
						
				$qry = "SELECT * FROM events 
						WHERE 1
						".$qry_str_search."
						ORDER BY promoter, title ASC
						";
						
				$pager = new PS_Pagination($count_qry, $qry, $config['ADMIN_RESULTS_PER_PAGE'], 10, $url_str);
				$res = $pager->paginate();
			?>
            	<div class="row-fluid">
                  <div class="span12">
                    <div class="content-widgets light-gray">
                      <div class="widget-head orange">
                        <h3>List of Reports</h3>
                      </div>
                      <div class="widget-container">
                      	<div id="data-table_wrapper" class="dataTables_wrapper form-inline" role="grid">  
                        <form action='' method='get'>
                          <input type="hidden" name="f" value="7">
	  					  <input type="hidden" name="page" value="<?php echo $page?>">
                            
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="dataTables_filter" id="data-table_filter">
                                <label>Promoters:
                                  <select class="span4" id="searchFilter" name="searchFilter" onChange="form.submit()" style="width:250px;">
                                      <option value=""> - All - </option>
                                      <?php
                                      $country_qry = "SELECT spid, name FROM promoters ORDER BY name ASC";
                                      $country_res = mysqli_query($conn, $country_qry);
                                      while($country_row = mysqli_fetch_array($country_res)) {
                                      ?>
                                          <option value="<?php echo $country_row['spid']?>" <?php echo ($_GET['searchFilter'] == $country_row['spid'])?"selected":""?>><?php echo $country_row['name']?></option>
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

							<?php
							while($row = mysqli_fetch_array($res)) {
								$id = $row[0];
								$title = $row['title'];
								$dtcm = $row['dtcm'];
								$commission = $row['commission'];
							?>

                            	<h4 class="widget-header"><?php echo $title?></h4>
                                <table width="99%" class="responsive table table-striped">
                                  <thead>
                                    <tr>
                                      <th class="center"> Ticket Prices </th>
                                      <th class="center"> Total Tickets </th>
                                      <th class="center"> Tickets Sold </th>
                                      <th class="center"> Commission Charges </th>
                                      <th class="center"> DTCM Charges </th>
                                      <th class="center"> Total Amount </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  $qry2 = "SELECT price, tickets FROM event_prices WHERE tid = '".sqlSafe($id)."' ORDER BY price DESC";
								  $res2 = mysqli_query($conn, $qry2);
								  while($row2 = mysqli_fetch_array($res2)) {
									  $ticket_price = $row2['price'];
									  $total_tickets = $row2['tickets'];
									  
									  $qry3 = "SELECT COUNT(tickets) ticketsold FROM ticket_orders WHERE tid = '".sqlSafe($id)."' AND ticket_price = '".sqlSafe($ticket_price)."'";
									  $res3 = mysqli_query($conn, $qry3);
									  $row3 = mysqli_fetch_array($res3);
									  $ticket_sold = $row3['ticketsold'];
									  $total_ticket_sold += $ticket_sold;
									  
									  if(!empty($ticket_sold)){ 
									  	$total_amount = ($ticket_sold * $ticket_price) - ($commission + $dtcm);
									  } else { 
									  	$total_amount =  $ticket_sold * $ticket_price; 
									  } 
									  
									  $total_sales += $ticket_sold * $ticket_price;
								  ?>
                                    <tr class="warning">
                                      <td class="center"> <?php echo $ticket_price?> </td>
                                      <td class="center"> <?php echo $total_tickets?> </td>
                                      <td class="center"> <?php echo $ticket_sold?> </td>
                                      <td class="center"> <?php echo $commission?> </td>
                                      <td class="center"> <?php echo $dtcm?> </td>
                                      <td class="center"> <?php echo $total_amount?> </td>
                                    </tr>
                                  <?php
								  }
								  ?>
                                  	<tr class="success">
                                      <td> <strong>TOTAL</strong> </td>
                                      <td class="center">&nbsp;  </td>
                                      <td class="center"> <strong><?php echo $total_ticket_sold?></strong> </td>
                                      <td class="center">&nbsp;  </td>
                                      <td class="center">&nbsp;  </td>
                                      <td class="center"> <strong><?php echo $total_sales?></strong> </td>
                                    </tr>
                                    
                                  </tbody>
                                </table>
								<br/>
                              
							<?php
							}
							?>

                          <div class="row-fluid">
                            <div class="span12">
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