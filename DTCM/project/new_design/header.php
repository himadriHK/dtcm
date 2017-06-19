<?php require_once('Connections/eventscon.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome</title>
<link href="style.css" rel="stylesheet" />
<style type="text/css">

.menu_tab ul ul {
	display: none;
}

	.menu_tab ul li:hover > ul {
		display: block;
	}


.menu_tab ul {
    display: inline-table;
    list-style: none outside none;
    position: relative;
}
	.menu_tab ul:after {
		content: ""; clear: both; display: block;
	}

	.menu_tab ul li {
		float: left;
	}

			.menu_tab ul li:hover a {
				color: #fff;
				
			}
		

.menu_tab ul li a {

    display: block;
    text-decoration: none;
}			
		
	.menu_tab ul ul {
		background:rgba(0,0,0,0.9); border-radius: 0px; padding: 0;
		position: absolute; top: 100%;
	}
		.menu_tab ul ul li {
			float: none;
			text-align:left;
			
			
			border-bottom: 1px solid rgba(0,0,0,0.25); position: relative;
		}
			.menu_tab ul ul li a {
				padding: 10px 20px;
				color: #fff;
				font-size:12px;
				width:150px !important; 
				text-transform:capitalize;
			}	
				.menu_tab ul ul li a:hover {
					background:rgba(0,0,0,0.25);
				}
		
	.menu_tab ul ul ul {
		position: absolute; left: 100%; top:0;
		
	}


</style>
<script src="/new_design/js/jquery-1.8.2.js" type="text/javascript">

</script>
<script language="JavaScript" src="mm_menu.js"></script>
<script type="text/javascript">
$('#nav a')
	.css( {backgroundPosition: "0 0"} )
	.mouseover(function(){
		$(this).stop().animate(
			{backgroundPosition:"(0 -250px)"}, 
			{duration:500})
		})
	.mouseout(function(){
		$(this).stop().animate(
			{backgroundPosition:"(0 0)"}, 
			{duration:500})
		})
</script>
<script>
function openVideoPlayer(videoName)
{
 if(videoName !="")
 {
  file="eventVideo/"+videoName;
 }
 window.open('playVideo.php?fileName='+file+'&from=video','popup','width=450,height=350,scrollbars=yes,resizable=yes,toolbar=no,status=no,left=50,top=0');
}
function openAudioPlayer(audioName)
{
 if(audioName!="")
 {
  file="eventAudio/"+audioName;
 }
 
 window.open('playVideo.php?fileName='+file+'&from=audio','popup','width=450,height=350,scrollbars=yes,resizable=yes,toolbar=no,status=no,left=50,top=0');
}

</script>
<?php

mysql_select_db($database_eventscon, $eventscon);

$query_guidecatRs = "SELECT * FROM `guide_cat` ORDER BY name ASC";

$guidecatRs = mysql_query($query_guidecatRs, $eventscon) or die(mysql_error());

$sql= "SELECT * FROM `banners`";
$query= mysql_query($sql, $eventscon) or die(mysql_error());
$images = mysql_fetch_array($query);

$sql= "SELECT * FROM `banner2`";
$query= mysql_query($sql, $eventscon) or die(mysql_error());
$img= mysql_fetch_array($query);
?>

  <?php 

$cur_catid = "";

$i=0;$k=1;

//echo $query_guidecatRs;

$javafunc2 = '';

$javafunc = '

<script language="JavaScript">

<!--

function mmLoadMenus() {

  if (window.mm_menu_1007235033_0) return;

'; 

//mysql_data_seek($guidecatRs, 0);

  while($row_guidecatRs = mysql_fetch_array($guidecatRs)){ 

  

  $cat_name = '';

  $guidecat = preg_replace('/\s+/', '&nbsp;', $row_guidecatRs['name']);

  //echo $guidecat;

//mysql_select_db($database_eventscon, $eventscon);

$query_sub_guidecatRs = "SELECT * FROM guide_sub_cat where catid=".$row_guidecatRs['catid']." ORDER BY name ASC";

//echo $query_sub_guidecatRs;

if($guidesub_catRs = mysql_query($query_sub_guidecatRs)){



  while($row_guidesub_catRs = mysql_fetch_array($guidesub_catRs)){ 

  //$cat_name = '';

  if($row_guidesub_catRs['catid']!=$cur_catid) {

  $i++;

  

  $javafunc .= 'window.mm_menu_1007235033_0_'.$i.' = new Menu("'.$guidecat.'",180,25,"Arial, Helvetica, sans-serif",10,"#FEFEFE","#FEFEFE","#333333","#666666","left","middle",3,0,1000,-5,7,true,true,true,0,false,false);

  ';

  $cat_name = 'mm_menu_1007235033_0_'.$i;

  } // end if catid check

  

  $guidesub_cat = preg_replace('/\s+/', '&nbsp;', $row_guidesub_catRs['name']);

  

  $javafunc .= 'mm_menu_1007235033_0_'.$i.'.addMenuItem("'.$guidesub_cat.'","location=\'guide.php?category='.$row_guidecatRs['catid'].'&subcat='.$row_guidesub_catRs['subcatid'].'\'");

  ';



  if($row_guidesub_catRs['catid']!=$cur_catid) {

  

  $javafunc .= 'mm_menu_1007235033_0_'.$i.'.fontWeight="bold";

';

  

  $javafunc .= 'mm_menu_1007235033_0_'.$i.'.hideOnMouseOut=true;

   mm_menu_1007235033_0_'.$i.'.bgColor=\'#000000\';

   mm_menu_1007235033_0_'.$i.'.menuBorder=1;

   mm_menu_1007235033_0_'.$i.'.menuLiteBgColor=\'#000000\';

   mm_menu_1007235033_0_'.$i.'.menuBorderBgColor=\'#333333\';

   ';

     

	} // end if catid check

	?>

	<?php

	$cur_catid = $row_guidesub_catRs['catid']; 

	}// end sub_cat while 

	} ?>

  <?php if($k==1){ 

  $javafuncmain = 'window.mm_menu_1007235033_0 = new Menu("root",180,25,"Arial, Helvetica, sans-serif",10,"#FEFEFE","#FEFEFE","#333333","#666666","left","middle",3,0,1000,-5,7,true,true,true,0,false,false);

  ';

   $k=0;} ?>

  <?php 

  //$guidecat = str_replace('&nbsp;', ' ',$row_guidecatRs['name']);

  $guidecat = preg_replace('/\s+/', '&nbsp;', $row_guidecatRs['name']);

  if($cat_name!=""){$guidecat = $cat_name;

  $javafunc2 .= 'mm_menu_1007235033_0.addMenuItem('.$guidecat.',"location=\'guide.php?category='.$row_guidecatRs['catid'].'\'");

  ';

  } else {

  $javafunc2 .= 'mm_menu_1007235033_0.addMenuItem("'.$guidecat.'","location=\'guide.php?category='.$row_guidecatRs['catid'].'\'");

  ';

  }

    }// end cat while 

	

	echo $javafunc;

	echo '

	

	';

	echo $javafuncmain;

	echo '

	

	';

	echo $javafunc2;

	?>
  



   mm_menu_1007235033_0.fontWeight="bold";

   mm_menu_1007235033_0.hideOnMouseOut=true;

   mm_menu_1007235033_0.childMenuIcon="arrows.gif";

   mm_menu_1007235033_0.bgColor='#000000';

   mm_menu_1007235033_0.menuBorder=1;

   mm_menu_1007235033_0.menuLiteBgColor='#000000';

   mm_menu_1007235033_0.menuBorderBgColor='#333333';



mm_menu_1007235033_0.writeMenus();

} // mmLoadMenus()

//-->

</script>

<script language="JavaScript1.2">mmLoadMenus();</script>



</head>

<body>

<div style="background:url(<?php echo $images['b_image']; ?>)  no-repeat scroll center -252px #08090D; position:fixed; width:100%; height:100%;"></div>

<div class="wrapper" style="position:relative;">
<!--<div style="position:absolute; left:42px; top:35px;"><img src="img/slogan.gif" style="width:140px;"></div>-->
<div class="container">
<div class="header">
<div class="logo">
  <a href="#"><img src="img/logo.jpg" width="156" height="78" /></a></div>
<div style="float:right; padding:14px 0 0;">
<marquee direction="left" width="697" height="106">
<?php
if( $images['status']=='ON'){
if($images['h1_status']!='OFF'){
?>
<a href="<?php echo $images['h_url']; ?>" target="_blank">
<img width="697" height="106" src="<?php echo $images['h_image']; ?>" />
</a>
<?php }
if($images['h2_status']!='OFF'){
 ?>
<a href="<?php echo $images['h1_url']; ?>" target="_blank">
<img width="697" height="106" src="<?php echo $images['h1_image']; ?>" />
</a>
<?php }
if($images['h3_status']!='OFF'){
 ?>
<a href="<?php echo $images['h2_url']; ?>" target="_blank">
<img width="697" height="106" src="<?php echo $images['h2_image']; ?>" />
</a>
<?php 
}}
?>
</marquee>
</div>  
<div class="menu_tab">
<ul class="main-nav">



<li><a href="index.php" class="home">Home</a></li>
<li><a href="ongoing_events.php" class="ongoing">Out & About</a></li>
<li><a href="guest_list.php" class="guest">Guest List </a></li>
<li><a href="guide.php" class="guide" id="image1" onmouseover="MM_showMenu1(window.mm_menu_1007235033_0,-23,11,null,'image1')" onmouseout="MM_startTimeout1();">Guide</a>
			<ul>
				<li><a href="#">Bars/Lounge</a>
                	<ul>
						<li><a href="guide.php?category=30&subcat=37">Abu Dhabi</a></li>
						<li><a href="guide.php?category=30&subcat=36">Dubai</a></li>
					</ul>
                </li>
				<li><a href="#">Night Clubs</a>
                	<ul>
						<li><a href="guide.php?category=30&subcat=37">Abu Dhabi</a></li>
						<li><a href="guide.php?category=30&subcat=36">Dubai</a></li>
					</ul>
                </li>
				<li><a href="#">Planning an Event?</a>
					<ul>
						<li><a href="guide.php?category=29&subcat=27">Fencing & Barthrooms</a></li>
						<li><a href="guide.php?category=29&subcat=25">Limo Service</a></li>
                        <li><a href="guide.php?category=29&subcat=31">Magazines</a></li>
                        <li><a href="guide.php?category=29&subcat=33">Party Store & Supplies</a></li>
                        <li><a href="guide.php?category=29&subcat=26">Printing Shops</a></li>
                        <li><a href="guide.php?category=29&subcat=30">Radio Stations</a></li>
                        <li><a href="guide.php?category=29&subcat=29">Securities Companies</a></li>
                        <li><a href="guide.php?category=29&subcat=32">SMS & Email Marketing</a></li>
                        <li><a href="guide.php?category=29&subcat=24">Sound, State & Lights</a></li>
                        <li><a href="guide.php?category=29&subcat=28">Wristbands</a></li>
					</ul>
				</li>
			</ul>
</li>
<li><a href="outlets.php" class="outlets">Outlets </a></li>
<li><a href="profile.php" class="about">About Us</a></li>
<li><a href="sell_with_us.php" class="sell">Sell With Us</a></li>

<li><a href="contact.php" class="contact">Contact us</a></li>

</ul>
</div>
</div>
</div>