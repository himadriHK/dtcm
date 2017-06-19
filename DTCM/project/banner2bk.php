<?php
if( $img['status']=='ON'){
?>
<div class="slider" style="margin-bottom:-2px;"> <a href="<?php echo $img['url']; ?>" target="_blank"><img style="height: 364px;width: 745px;" src="<?php echo $img['image']; ?>" /></a></div>
<?php } ?>
<div class="slider">
<link href="css/style.css" rel="stylesheet" type="text/css">

<!--
  jCarousel library
-->
<script type="text/javascript" src="js/jquery.js"></script>
<!--
  jCarousel skin stylesheet
-->
<link rel="stylesheet" type="text/css" href="css/skin.css">
<style type="text/css">
/**
 * Additional styles for the controls.
 */
.jcarousel-control {
	margin-bottom: 10px;
	text-align: center;
}
.jcarousel-control a {
	font-size: 75%;
	text-decoration: none;
	padding: 0 5px;
	margin: 0 0 5px 0;
	border: 1px solid #fff;
	color: #eee;
	background-color: #4088b8;
	font-weight: bold;
}
.jcarousel-control a:focus, .jcarousel-control a:active {
	outline: none;
}
.jcarousel-scroll {
	margin-top: 10px;
	text-align: center;
}
.jcarousel-scroll form {
	margin: 0;
	padding: 0;
}
.jcarousel-scroll select {
	font-size: 75%;
}
#mycarousel-next, #mycarousel-prev {
	cursor: pointer;
	margin-bottom: -10px;
	text-decoration: underline;
	font-size: 11px;
}
</style>
<script type="text/javascript">
/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */
function mycarousel_initCallback(carousel) {
    jQuery('.jcarousel-control a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
        return false;
    });

    jQuery('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });

    jQuery('#mycarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });

    jQuery('#mycarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};

// Ride the carousel...
jQuery(document).ready(function() {
    jQuery("#mycarousel").jcarousel({
        scroll: 1,
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
});

</script>
<div class="bannerbg">
<div id="wrap">
<h1>AQUAVENTURE PARK AT ATLANTIS HOTEL THE PALM</h1>
  <div class="jcarousel-skin-tango">
    <div style="position: relative; display: block;" id="mycarousel" class="jcarousel-container jcarousel-container-horizontal">
      <div style="position: relative;" class="jcarousel-clip jcarousel-clip-horizontal">
        <ul style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; width: 730px;" class="jcarousel-list jcarousel-list-horizontal">
        <?php
        $i=1;
        $sql= "SELECT * FROM `scroller` order by id desc";
$query= mysql_query($sql, $eventscon) or die(mysql_error());
while($scroller= mysql_fetch_array($query)){
         ?>
          <li jcarouselindex="<?php echo $i; ?>" style="float: left; list-style: none outside none;" class="jcarousel-item jcarousel-item-horizontal jcarousel-item-<?php echo $i; ?> jcarousel-item-<?php echo $i; ?>-horizontal">
          <a target="_blank" href="<?php echo $scroller['url']; ?>"><img src="<?php echo $scroller['image']; ?>" style="width:150px;height:328px;" ></a></li>
          <?php $i++;} ?></ul>
      </div>
      <a href="#" id="mycarousel-prev">« Prev</a> <a href="#" id="mycarousel-next">Next »</a> 
    </div>
  </div>
  <div class="timebar_col">
  <div class="timebar">
  <img src="img/time_icon.png" />
  <div class="time_zone">
<span class="timebg">  <strong>898</strong>        <strong>18</strong>         <strong>04</strong>        <strong style="border:none;">11</strong></span> 
<span><strong>Days</strong> <strong>Hrs</strong> <strong>Min</strong>	<strong>Sec</strong></span>
  </div>
  </div>
  
  <div class="bynow">
 <a href="#"> BUY<br />

Now</a>
  
  </div>
  
  </div>
</div>
</div>
</div>