<?php 
$category_url_name='';
$category_details='';
require_once('header.php'); ?>

<div class="main-content">
  <div class="container">
    <?php require_once('left_content.php'); ?>
    <div class="conent-right">
    <?php if( $images['status']=='ON'){
    $banner_count=0;
    if($images['h1_status']!='OFF'){ $banner_count++; }
    if($images['h2_status']!='OFF'){ $banner_count++; }
    if($images['h3_status']!='OFF'){ $banner_count++; }
    if($banner_count >0){
    	?>
    <div style="float:right;">
    <?php if($banner_count >1){?>
	<marquee direction="left" width="697" height="106">
	<?php }?>
          <?php



if($images['h1_status']!='OFF'){
?>
          <a href="<?php echo $images['h_url']; ?>" target="_blank"> <img width="697" height="106" src="<?php echo $images['h_image']; ?>" /> </a>

          <?php }


if($images['h2_status']!='OFF'){

 ?>
          <a href="<?php echo $images['h1_url']; ?>" target="_blank"> <img width="697" height="106" src="<?php echo $images['h1_image']; ?>" /> </a>
          <?php }

if($images['h3_status']!='OFF'){
 ?>
          <a href="<?php echo $images['h2_url']; ?>" target="_blank"> <img width="697" height="106" src="<?php echo $images['h2_image']; ?>" /> </a>
          <?php 
}
?>
 <?php if($banner_count >1){?>
      </marquee>
<?php }?>
      </div>
      <?php } 
    }?>
      <?php //require_once('banner2.php'); ?>
      <!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
      <?php //require_once('menu.php'); ?>
      <div class="shows-box">
        <?php 



$category_name=@$_GET['cat'];


if(isset($_GET['cat']) && $_GET['cat']!='all')



{



	$sql = "select * FROM category where ename='$category_name'";



$category_query = mysql_query($sql, $eventscon) or die(mysql_error());



$category_details=mysql_fetch_assoc($category_query);

$category_url_name=$category_details['name'];

}

if(@$_GET['cat']=='all')

{

	$category_url_name="all";

}

?>
        <h1 style="background: #3399cc;padding: 10px 20px;margin: -25px -20px 0;border-radius: 5px 5px 0 0;color: #fff;text-align: center;"><?php echo $city_name;?> Events
          <?php if($category_url_name){ echo " &raquo; ".ucfirst($category_url_name);}?>
        </h1>
        <div class="shows-box-frames">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left" valign="top"><?php require("show_events.php"); ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once('footer.php'); ?>
</body></html>