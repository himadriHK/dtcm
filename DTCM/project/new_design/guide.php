<?php require_once('header.php'); 

$colname_guideRs = "-1";
	if ((!isset($_GET['subcat']))&&(isset($_GET['category']))) {
  		$colname_guideRs = (get_magic_quotes_gpc()) ? $_GET['category'] : addslashes($_GET['category']);
		$query_guideRs = sprintf("SELECT * FROM guide WHERE catid = %s ORDER BY name ASC", $colname_guideRs);
	} elseif ((isset($_GET['subcat']))&&(isset($_GET['category']))) {
  		$colname_guideRs = (get_magic_quotes_gpc()) ? $_GET['category'] : addslashes($_GET['category']);
  		$colnamecat_guideRs = (get_magic_quotes_gpc()) ? $_GET['subcat'] : addslashes($_GET['subcat']);
		$query_guideRs = sprintf("SELECT * FROM guide WHERE catid = %s and subcatid = %s ORDER BY name ASC", $colname_guideRs, $colnamecat_guideRs);

  	} else {

		$query_guideRs = "SELECT * FROM guide ORDER BY cid, name ASC";

	}

//echo "<font color='#000000'>".$query_guideRs."</font>";

mysql_select_db($database_eventscon, $eventscon);
$guideRs = mysql_query($query_guideRs, $eventscon) or die(mysql_error());
$row_guideRs = mysql_fetch_assoc($guideRs);
$totalRows_guideRs = mysql_num_rows($guideRs);



/*

if (isset($_GET['category'])) {

mysql_select_db($database_eventscon, $eventscon);

$query_sub_categoryRs = "SELECT * FROM guide_sub_cat where catid=".$_GET['category']." ORDER BY name ASC";

$sub_categoryRs = mysql_query($query_sub_categoryRs, $eventscon) or die(mysql_error());

$row_sub_categoryRs = mysql_fetch_assoc($sub_categoryRs);

$totalRows_sub_categoryRs = mysql_num_rows($sub_categoryRs);

}

*/

mysql_select_db($database_eventscon, $eventscon);
$query_categoryRs = "SELECT * FROM guide_cat ORDER BY name ASC";
$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());
$row_categoryRs = mysql_fetch_assoc($categoryRs);
$totalRows_categoryRs = mysql_num_rows($categoryRs);

?>

<div class="main-content">
<div class="container">

<?php require_once('left_content.php'); ?>

<div class="conent-right">
<?php require_once('banner2.php'); ?>
<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php require_once('menu.php'); ?>
<div class="shows-box">

<h1>Guide</h1>
<div class="shows-box-frames">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><img src="images/guide-title-pix.png" width="255" height="32" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="center"><? require("show_guide.php");?></td>
                              </tr>
                              <tr>
                                <td align="center"><?php //echo 'number	:'.$totalRows_guideRs;
				  if($totalRows_guideRs==0)
				  { 
				  	echo "No records found.";
				} 
				  ?></td>
                              </tr>
                              <tr>
                                <td align="center">&nbsp;</td>
                              </tr>

                          </table></td>
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

</body>
</html>
