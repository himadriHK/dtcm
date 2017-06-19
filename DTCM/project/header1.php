<?php require_once('Connections/eventscon.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome</title>
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

//echo $guidecatRs;

//mysql_data_seek($guidecatRs, 0);

//  while($row_guidecatRs = mysql_fetch_array($guidecatRs)){ 

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

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

.headx {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 11px;

	font-weight: bold;

	color: #666666;

}

-->

</style>



<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td background="images/nav-bg.png"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="5" align="center">&nbsp;</td>
        <td width="100" align="center"><a href="index.php" class="contentstext">HOME</a></td>
        <td width="2" align="center" background="images/nav-bg.png"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="profile.php" class="contentstext">PROFILE</a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="outlets.php" class="contentstext">OUTLETS</a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center">
		<a href="guide.php" class="headx"><img src="images/guide_m.gif" name="image1" width="42" height="18" border="0" id="image1" onmouseover="MM_showMenu(window.mm_menu_1007235033_0,-23,11,null,'image1')" onmouseout="MM_startTimeout();" /></a>		</td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="promoters.php" class="contentstext">PROMOTERS</a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="gallery.php" class="contentstext">GALLERY</a><a href="gallery.php"></a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="news.php" class="contentstext">LATEST NEWS</a><a href="news.php"></a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="partners.php" class="contentstext">PARTNER</a><a href="partners.php"></a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td width="100" align="center"><a href="contact.php" class="contentstext">CONTACT US</a></td>
        <td width="2" align="center"><img src="images/faselx.png" width="2" height="51" /></td>
        <td align="center">&nbsp;</td>
        </tr>
    </table>	</td>
  </tr>
</table>

<?php

mysql_free_result($guidecatRs);

?>