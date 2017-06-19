<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Dashboard";
$importLogData = "";

$qry = "SELECT * FROM  feed_import_log 
		WHERE 1
		";
$res = mysqli_query($conn, $qry);
while($row = mysqli_fetch_array($res)) {
	$importLogData .= "[".($row['add_date'] * 1000).", ".$row['total_records']."],";
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $config['SITE_NAME']?> | Admin Dashboard</title>
<?php include_once("top.php")?>
<script src="js/jquery.flot.js"></script>
<script src="js/jquery.flot.selection.js"></script>
<script src="js/excanvas.js"></script>
<script src="js/jquery.flot.pie.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.time.js"></script>
<script src="js/jquery.flot.tooltip.js"></script>
<script src="js/jquery.flot.resize.js"></script>
<script type="text/javascript">
var siteURL = "<?php echo $config['SITE_URL']?>";

    var data7_1 = [
        <?php echo $importLogData?>
    ];

    $(function () {
        $.plot($("#visitors-chart #visitors-container"), [{
            data: data7_1,
            label: "Data Import",
            lines: {
                fill: true
            }
        }
        ],
        {
            series: {
                lines: {
                    show: true,
                    fill: false
                },
                points: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: "#ffffff",
                    symbol: "circle",
                    radius: 5,
                },
                shadowSize: 0,
            },
            grid: {
                hoverable: true,
                clickable: true,
                tickColor: "#f9f9f9",
                borderWidth: 1
            },
            colors: ["#b086c3"],
            tooltip: true,
            tooltipOpts: {
				  shifts: { 
					  x: -100                     //10
				  },
                defaultTheme: false
            },
            xaxis: {
                mode: "time",
				minTickSize: [24, "hour"],
                timeformat: "%d/%m/%y %H:%M"
            },
            yaxes: [{
                /* First y axis */
            }, {
                /* Second y axis */
                position: "right" /* left or right */
            }]
        }
        );
    });
	
	
function syncData() {
	
	var dataString = 'action=manualSyncData';
		
	$.ajax({
	  type: "POST",
	  url: siteURL + "/cron/create_import_files.php",
	  data: dataString,
	  dataType: "json",
	  beforeSend: function() {
	  	$('#manualSyncData').html('<img src="'+siteURL+'/images/loading.gif" alt="" >');
      	},
	  success: function(response) {
		if(response == 1) {
			$('#manualSyncData').html('<i class="icon-refresh"></i>');
			location.reload();
		}
			
	  }//success function ends
	 });
	return false;
};
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
						<h3 class="page-header">Dashboard</h3>
					</div>
					<ul class="breadcrumb">
						<li><a href="index.php" class="icon-home"></a><span class="divider "><i class="icon-angle-right"></i></span></li>
						<li class="active">Dashboard</li>
					</ul>
				</div>
			</div>
			
			<div class="row-fluid">
				<div class="span12">
					<div class="switch-board gray">
						<ul class="clearfix switch-item">
							<li><a href="admins.php" class="brown"><i class="icon-user"></i><span>Admin Users</span></a></li>
							<li><a href="config_mngt.php" class="orange"><i class="icon-cogs"></i><span>Settings</span></a></li>
							<li><a href="import_log_mngt.php" class=" blue-violate"><i class="icon-file"></i><span>Data Log</span></a></li>
							<!--<li><a href="#" class=" magenta"><i class="icon-bar-chart"></i><span>Statistics</span></a></li>
							<li><a href="#" class="green"><i class="icon-shopping-cart"></i><span>Orders</span></a></li>
							<li><a href="#" class=" bondi-blue"><i class="icon-time"></i><span>Events</span></a></li>
							<li><a href="#" class=" dark-yellow"><i class="icon-file-alt"></i><span>Post</span></a></li>
							<li><a href="#" class=" blue"><i class="icon-copy"></i><span>Documents</span></a></li>-->
						</ul>
					</div>
				</div>
			</div>
            
            <div class="row-fluid ">
				<div class="span12">
					<div class="board-widgets gray">
						<div class="board-widgets-head clearfix">
							<h4 class="pull-left">Import Data Statistics</h4>
							<a href="javascript:void(0)" id="manualSyncData" class="widget-settings" onClick="syncData();"><i class="icon-refresh"></i></a>
						</div>
						<div class="board-widgets-content">
							<div class="row-fluid">
								<div class="span12">
									<div class="widget-container">
										<div id="visitors-chart">
											<div id="visitors-container" style="width: 100%;height:400px; text-align: center; margin:0 auto;">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            
		</div>
	</div>
	<?php include_once("footer.php")?>
</div>
</body>
</html>