<?php
$include_dir = "include"; 
include "$include_dir/config.php";
include "$include_dir/function.php";
include "security.php";
extract($_REQUEST);
extract($_POST);

$pageName = "Dashboard";
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
                            <li><a href="promoters.php" class="magenta"><i class="icon-umbrella"></i><span>Promoters</span></a></li>
                            <li><a href="outlets.php" class="green"><i class="icon-briefcase"></i><span>Outlets</span></a></li>
                            <li><a href="guides.php" class="blue-violate"><i class="icon-road"></i><span>Guides</span></a></li>
                            <li><a href="events.php" class="orange"><i class="icon-flag"></i><span>Events</span></a></li>
                            <li><a href="news.php" class=" magenta"><i class="icon-bell-alt"></i><span>News</span></a></li>
                            <li><a href="gallery.php" class="bondi-blue"><i class="icon-picture"></i><span>Gallery</span></a></li>
                            <li><a href="partners.php" class=" dark-yellow"><i class="icon-magnet"></i><span>Partners</span></a></li>
                            <li><a href="newsletter.php" class="orange"><i class="icon-envelope-alt"></i><span>Newsletter</span></a></li>
                            <li><a href="venues.php" class=" blue"><i class="icon-building"></i><span>Venues</span></a></li>
                            <li><a href="country_rates.php" class="brown"><i class="icon-money"></i><span>Rates</span></a></li>
                            <li><a href="cities.php" class="green"><i class="icon-hospital"></i><span>Cities</span></a></li>
                            <li><a href="header_banners.php" class="bondi-blue"><i class="icon-h-sign"></i><span>Banners</span></a></li>
                            <li><a href="subscribers.php" class="blue-violate"><i class="icon-envelope"></i><span>Subscribers</span></a></li>
                            <li><a href="carousel.php" class=" dark-yellow"><i class="icon-spinner"></i><span>Carousel</span></a></li>
                            <li><a href="ticket_orders.php" class="blue-violate"><i class="icon-shopping-cart"></i><span>Orders</span></a></li>
                            <li><a href="reports.php" class="orange"><i class="icon-file"></i><span>Reports</span></a></li>
                            <li><a href="config.php" class="brown"><i class="icon-cog"></i><span>Settings</span></a></li>
						</ul>
					</div>
				</div>
			</div>

            <div class="row-fluid ">
				<div class="span3">
					<div class="board-widgets brown small-widget">
						<a href="admins.php">
                        	<span class="widget-stat"><?php echo countAdminUsers();?></span>
                            <span class="widget-icon icon-user"></span><span class="widget-label">Total Admin Users</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets blue small-widget">
						<a href="promoters.php">
                        	<span class="widget-stat"><?php echo countPromoters();?></span>
                            <span class="widget-icon icon-umbrella"></span><span class="widget-label">Total Promoters</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets green small-widget">
						<a href="outlets.php">
                        	<span class="widget-stat"><?php echo countOutlets();?></span>
                            <span class="widget-icon icon-briefcase"></span><span class="widget-label">Total Outlets</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets blue-violate small-widget">
						<a href="guides.php">
                        	<span class="widget-stat"><?php echo countGuides();?></span>
                            <span class="widget-icon icon-road"></span><span class="widget-label">Total Guides</span>
                        </a>
					</div>
				</div>
			</div>
            
            <div class="row-fluid ">
				<div class="span3">
					<div class="board-widgets orange small-widget">
						<a href="events.php">
                        	<span class="widget-stat"><?php echo countEvents();?></span>
                            <span class="widget-icon icon-flag"></span><span class="widget-label">Total Events</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets magenta small-widget">
						<a href="news.php">
                        	<span class="widget-stat"><?php echo countNews();?></span>
                            <span class="widget-icon icon-bell-alt"></span><span class="widget-label">Total News</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets bondi-blue small-widget">
						<a href="gallery.php">
                        	<span class="widget-stat"><?php echo countGalleryPhotos();?></span>
                            <span class="widget-icon icon-picture"></span><span class="widget-label">Total Gallery Photos</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets dark-yellow small-widget">
						<a href="partners.php">
                        	<span class="widget-stat"><?php echo countPartners();?></span>
                            <span class="widget-icon icon-magnet"></span><span class="widget-label">Total Partners</span>
                        </a>
					</div>
				</div>
			</div>
            
            <div class="row-fluid ">
				<div class="span3">
					<div class="board-widgets orange small-widget">
						<a href="newsletter.php">
                        	<span class="widget-stat"><?php echo countNewsletter();?></span>
                            <span class="widget-icon icon-envelope-alt"></span><span class="widget-label">Total Newsletters</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets brown small-widget">
						<a href="newsletter.php?f=8">
                        	<span class="widget-stat"><?php echo countNewsletterEmails();?></span>
                            <span class="widget-icon icon-envelope-alt"></span><span class="widget-label">Total Newsletter Emails</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets blue small-widget">
						<a href="venues.php">
                        	<span class="widget-stat"><?php echo countVenues();?></span>
                            <span class="widget-icon icon-building"></span><span class="widget-label">Total Venues</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets green small-widget">
						<a href="cities.php">
                        	<span class="widget-stat"><?php echo countCities();?></span>
                            <span class="widget-icon icon-hospital"></span><span class="widget-label">Total Cities</span>
                        </a>
					</div>
				</div>
			</div>
            
            <div class="row-fluid ">
				<div class="span3">
					<div class="board-widgets brown small-widget">
						<a href="country_rates.php">
                        	<span class="widget-stat"><?php echo countCountryRates();?></span>
                            <span class="widget-icon icon-money"></span><span class="widget-label">Total Country Rates</span>
                        </a>
					</div>
				</div>
                <div class="span3">
					<div class="board-widgets blue-violate small-widget">
						<a href="subscribers.php">
                        	<span class="widget-stat"><?php echo countSubscribers();?></span>
                            <span class="widget-icon icon-envelope"></span><span class="widget-label">Total Subscribers</span>
                        </a>
					</div>
				</div>
				<div class="span3">
					<div class="board-widgets dark-yellow small-widget">
						<a href="ticket_orders.php">
                        	<span class="widget-stat"><?php echo countTicketOrders();?></span>
                            <span class="widget-icon icon-shopping-cart"></span><span class="widget-label">Total Ticket Orders</span>
                        </a>
					</div>
				</div>
                <div class="span3">
					<div class="board-widgets orange small-widget">
						<a href="carousel.php">
                        	<span class="widget-stat"><?php echo countCarouselImages();?></span>
                            <span class="widget-icon icon-spinner"></span><span class="widget-label">Total Carousel Images</span>
                        </a>
					</div>
				</div>
			</div>
            
		</div>
	</div>
	<?php include_once("footer.php")?>
</div>
</body>
</html>