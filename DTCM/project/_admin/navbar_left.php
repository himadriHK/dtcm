<div class="leftbar leftbar-close clearfix">
  <div class="admin-info clearfix">
    <div class="admin-thumb"> <i class="icon-user"></i> </div>
    <div class="admin-meta">
      <ul>
        <li class="admin-username"><?php echo isset($_SESSION['Username'])?$_SESSION['Username']:""?></li>
        <li>
        	<a href="admin_update.php">Edit Profile </a>
            <a href="logout.php"><i class="icon-lock"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="left-nav clearfix">
    <div class="left-primary-nav">
      <ul id="myTab">
        <li <?php echo (isset($pageName) && ($pageName == "Dashboard"))?'class="active"':''?>><a href="#main" class="icon-desktop" title="Dashboard"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Admin Users"))?'class="active"':''?>><a href="#admins" class="icon-user" title="Admin Users Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Promoters"))?'class="active"':''?>><a href="#promoters" class="icon-umbrella" title="Promoters Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Outlets"))?'class="active"':''?>><a href="#outlets" class="icon-briefcase" title="Outlets Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Guides"))?'class="active"':''?>><a href="#guides" class="icon-road" title="Guides Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Events"))?'class="active"':''?>><a href="#events" class="icon-flag" title="Events Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "News"))?'class="active"':''?>><a href="#news" class="icon-bell-alt" title="News Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Gallery"))?'class="active"':''?>><a href="#gallery" class="icon-picture" title="Gallery Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Partners"))?'class="active"':''?>><a href="#partners" class="icon-magnet" title="Partners Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Newsletter"))?'class="active"':''?>><a href="#newsletter" class="icon-envelope-alt" title="Newsletter Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Venues"))?'class="active"':''?>><a href="#venues" class="icon-building" title="Venues Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Country Rates"))?'class="active"':''?>><a href="#countryrates" class="icon-money" title="Country Rates"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Cities"))?'class="active"':''?>><a href="#cities" class="icon-hospital" title="City Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Header Banners"))?'class="active"':''?>><a href="#headerbanners" class="icon-h-sign" title="Header Banners Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Subscribers"))?'class="active"':''?>><a href="#subscribers" class="icon-envelope" title="Subscribers Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Carousel"))?'class="active"':''?>><a href="#carousel" class="icon-spinner" title="Carousel Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Ticket Orders"))?'class="active"':''?>><a href="#ticketorders" class="icon-shopping-cart" title="Ticket Orders Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Reports"))?'class="active"':''?>><a href="#reports" class="icon-file" title="Reports Management"></a></li>
        <li <?php echo (isset($pageName) && ($pageName == "Settings"))?'class="active"':''?>><a href="#settings" class="icon-cog" title="Site Settings"></a></li>
      </ul>
      <!--<ul>
        <li><a href="chat.html" class="icon-comments" title="Chat"></a></li>
        <li><a href="text-editor.html" class="icon-pencil" title="WYSIWYG editor"></a></li>
      </ul>-->
    </div>
    <div class="responsive-leftbar"> <i class="icon-list"></i> </div>
    <div class="left-secondary-nav tab-content">
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Dashboard"))?'active':''?>" id="main">
        <h4 class="side-head">Dashboard</h4>
        <!--<div class="search-box">
          <div class="input-append input-icon">
            <input class="search-input" placeholder="Search..." type="text">
            <i class=" icon-search"></i>
            <button class="btn" type="button">Go!</button>
          </div>
        </div>-->
        <ul class="metro-sidenav clearfix">
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
          <li><a href="country_rates.php" class="brown"><i class="icon-money"></i><span>Country Rates</span></a></li>
          <li><a href="cities.php" class="green"><i class="icon-hospital"></i><span>Cities</span></a></li>
          <li><a href="header_banners.php" class="bondi-blue"><i class="icon-h-sign"></i><span>Header Banners</span></a></li>
          <li><a href="subscribers.php" class="blue-violate"><i class="icon-envelope"></i><span>Subscribers</span></a></li>
          <li><a href="carousel.php" class=" dark-yellow"><i class="icon-spinner"></i><span>Carousel</span></a></li>
          <li><a href="ticket_orders.php" class="blue-violate"><i class="icon-shopping-cart"></i><span>Ticket Orders</span></a></li>
          <li><a href="reports.php" class="orange"><i class="icon-file"></i><span>Reports</span></a></li>
          <li><a href="config.php" class="brown"><i class="icon-cog"></i><span>Site Settings</span></a></li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Admin Users"))?'active':''?>" id="admins">
        <h4 class="side-head">Admin Users</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Admin Users") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="admins.php"><i class="icon-th-list"></i> List Admin Users </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Admin Users") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="admins.php?f=1"><i class="icon-plus-sign"></i> Add Admin User </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Promoters"))?'active':''?>" id="promoters">
        <h4 class="side-head">Promoters</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Promoters") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="promoters.php"><i class="icon-th-list"></i> List Promoters </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Promoters") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="promoters.php?f=1"><i class="icon-plus-sign"></i> Add a Promoter </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Outlets"))?'active':''?>" id="outlets">
        <h4 class="side-head">Outlets</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Outlets") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="outlets.php"><i class="icon-th-list"></i> List Outlets </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Outlets") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="outlets.php?f=1"><i class="icon-plus-sign"></i> Add an Outlet </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Guides"))?'active':''?>" id="guides">
        <h4 class="side-head">Guides</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Guides") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="guides.php"><i class="icon-th-list"></i> List Guides </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Guides") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="guides.php?f=1"><i class="icon-plus-sign"></i> Add a Guide </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Guides") && ($_GET['f'] == "8" || $_GET['f'] == "9" || $_GET['f'] == "10" || $_GET['f'] == "11"))?'class="active"':''?>>
          	<a href="guides.php?f=8"><i class="icon-list-ul"></i> Guide Categories </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Guides") && ($_GET['f'] == "12" || $_GET['f'] == "13" || $_GET['f'] == "14" || $_GET['f'] == "15"))?'class="active"':''?>>
          	<a href="guides.php?f=12"><i class="icon-list-ul"></i> Guide Sub-categories </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Events"))?'active':''?>" id="events">
        <h4 class="side-head">Events</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Events") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="events.php"><i class="icon-th-list"></i> List Events </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Events") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="events.php?f=1"><i class="icon-plus-sign"></i> Add an Event </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Events") && ($_GET['f'] == "8" || $_GET['f'] == "9" || $_GET['f'] == "10" || $_GET['f'] == "11"))?'class="active"':''?>>
          	<a href="events.php?f=8"><i class="icon-list-ul"></i> Event Categories </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Events") && ($_GET['f'] == "12" || $_GET['f'] == "13" || $_GET['f'] == "14" || $_GET['f'] == "15"))?'class="active"':''?>>
          	<a href="events.php?f=12"><i class="icon-list-ul"></i> Event Seat Types </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Events") && ($_GET['f'] == "16" || $_GET['f'] == "17" || $_GET['f'] == "18"))?'class="active"':''?>>
          	<a href="events.php?f=16"><i class="icon-group"></i> Event Customer Emails </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Events") && ($_GET['f'] == "19" || $_GET['f'] == "20" || $_GET['f'] == "21" || $_GET['f'] == "22"))?'class="active"':''?>>
          	<a href="events.php?f=19"><i class="icon-bullhorn"></i> Event Ads </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "News"))?'active':''?>" id="news">
        <h4 class="side-head">News</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "News") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="news.php"><i class="icon-th-list"></i> List News </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "News") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="news.php?f=1"><i class="icon-plus-sign"></i> Add a News </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Gallery"))?'active':''?>" id="gallery">
        <h4 class="side-head">Gallery</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Gallery") && (!isset($_GET['f']) || ($_GET['f'] == "1") || ($_GET['f'] == "2") || ($_GET['f'] == "3") || ($_GET['f'] == "4") || ($_GET['f'] == "5")))?'class="active"':''?>>
          	<a href="gallery.php"><i class="icon-th-list"></i> Manage Gallery </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Gallery") && ($_GET['f'] == "6" || $_GET['f'] == "7" || $_GET['f'] == "8" || $_GET['f'] == "9"))?'class="active"':''?>>
          	<a href="gallery.php?f=6"><i class="icon-list-ul"></i> Gallery Categories </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Partners"))?'active':''?>" id="partners">
        <h4 class="side-head">Partners</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Partners") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="partners.php"><i class="icon-th-list"></i> List Partners </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "News") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="partners.php?f=1"><i class="icon-plus-sign"></i> Add a Partner </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Newsletter"))?'active':''?>" id="newsletter">
        <h4 class="side-head">Newsletter</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Newsletter") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="newsletter.php"><i class="icon-th-list"></i> List Newsletters </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Newsletter") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="newsletter.php?f=1"><i class="icon-plus-sign"></i> Add a Newsletter </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Newsletter") && ($_GET['f'] == "8" || $_GET['f'] == "9" || $_GET['f'] == "10"))?'class="active"':''?>>
          	<a href="newsletter.php?f=8"><i class="icon-list-ul"></i> Newsletter Emails </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Venues"))?'active':''?>" id="venues">
        <h4 class="side-head">Venues</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Venues") && ($_GET['f'] == "6" || $_GET['f'] == "7" || $_GET['f'] == "8" || $_GET['f'] == "9"))?'class="active"':''?>>
          	<a href="venues.php?f=6"><i class="icon-list-ul"></i> Venue Management </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Venues") && (!isset($_GET['f']) || ($_GET['f'] == "1") || ($_GET['f'] == "2") || ($_GET['f'] == "3") || ($_GET['f'] == "4") || ($_GET['f'] == "5")))?'class="active"':''?>>
          	<a href="venues.php"><i class="icon-th-list"></i> Venue Gallery </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Country Rates"))?'active':''?>" id="countryrates">
        <h4 class="side-head">Country Rates</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Country Rates") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="country_rates.php"><i class="icon-th-list"></i> List Country Rates </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Country Rates") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="country_rates.php?f=1"><i class="icon-plus-sign"></i> Add a Country Rates </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Cities"))?'active':''?>" id="cities">
        <h4 class="side-head">Cities</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Country Rates") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="cities.php"><i class="icon-th-list"></i> List Cities </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Country Rates") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="cities.php?f=1"><i class="icon-plus-sign"></i> Add a City </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Header Banners"))?'active':''?>" id="headerbanners">
        <h4 class="side-head">Header Banners</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Header Banners") && (!isset($_GET['f']) || ($_GET['f'] == "1")))?'class="active"':''?>>
          	<a href="header_banners.php"><i class="icon-th-list"></i> Header Banners </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Header Banners") && (($_GET['f'] == "2") || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="header_banners.php?f=2"><i class="icon-th-list"></i> Header Special Image </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Carousel"))?'active':''?>" id="carousel">
        <h4 class="side-head">Carousel</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Carousel") && (!isset($_GET['f']) || ($_GET['f'] == "3")))?'class="active"':''?>>
          	<a href="carousel.php"><i class="icon-th-list"></i> List Carousel Images </a>
          </li>
          <li <?php echo (isset($pageName) && ($pageName == "Carousel") && ($_GET['f'] == "1"))?'class="active"':''?>>
          	<a href="carousel.php?f=1"><i class="icon-plus-sign"></i> Add a Carousel Image </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Subscribers"))?'active':''?>" id="subscribers">
        <h4 class="side-head">Subscribers</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Subscribers") && (!isset($_GET['f']) || ($_GET['f'] == "3") || ($_GET['f'] == "4") || ($_GET['f'] == "7")))?'class="active"':''?>>
          	<a href="subscribers.php"><i class="icon-th-list"></i> List Subscribers </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Ticket Orders"))?'active':''?>" id="ticketorders">
        <h4 class="side-head">Ticket Orders</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Ticket Orders") && (!isset($_GET['f']) || ($_GET['f'] == "3") || ($_GET['f'] == "4") || ($_GET['f'] == "7")))?'class="active"':''?>>
          	<a href="ticket_orders.php"><i class="icon-th-list"></i> List Ticket Orders </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Reports"))?'active':''?>" id="reports">
        <h4 class="side-head">Reports</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Reports") && (!isset($_GET['f']) || ($_GET['f'] == "3") || ($_GET['f'] == "4") || ($_GET['f'] == "7")))?'class="active"':''?>>
          	<a href="reports.php"><i class="icon-th-list"></i> List Reports </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane <?php echo (isset($pageName) && ($pageName == "Settings"))?'active':''?>" id="settings">
        <h4 class="side-head">Site Settings</h4>
        <ul id="nav" class="accordion-nav">
          <li <?php echo (isset($pageName) && ($pageName == "Settings") && (!isset($_GET['f']) || ($_GET['f'] == "1")))?'class="active"':''?>>
          	<a href="config.php"><i class="icon-cog"></i> Configuration </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
