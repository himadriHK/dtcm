<?php require_once('header.php'); 

mysql_select_db($database_eventscon, $eventscon);
$filters = array();
if(isset($_GET['country']) && $_GET['country']!=''){
	$filters[]="(country1=".$_GET['country']." OR country2=".$_GET['country']." OR country3=".$_GET['country']." OR country4=".$_GET['country']." OR country5=".$_GET['country'].")";
}
if(isset($_GET['city']) && $_GET['city']!=''){
	$filters[]="(city1='".$_GET['city']."' OR city2='".$_GET['country']."' OR city3='".$_GET['city']."' OR city4='".$_GET['city']."' OR city5='".$_GET['city']."')";
}
if(isset($_GET['area']) && $_GET['area']!=''){
	$filters[]="(area1='".$_GET['area']."' OR area2='".$_GET['area']."' OR area3='".$_GET['area']."' OR area4='".$_GET['area']."' OR area5='".$_GET['area']."')";
}
$wh='';
if(!empty($filters)){
	$wh='AND '.implode(' AND ',$filters);
}
$query_outletsRs = "SELECT * FROM outlets WHERE 1 ".$wh." ORDER BY outlet ASC";
$outletsRs = mysql_query($query_outletsRs, $eventscon) or die(mysql_error());
$row_outletsRs = mysql_fetch_assoc($outletsRs);
$totalRows_outletsRs = mysql_num_rows($outletsRs);
?>


<div class="main-content">
<div class="container">

<?php require_once('left_content.php'); ?>

<div class="conent-right">
<?php //require_once('banner2.php'); ?>
<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php //require_once('menu.php'); ?>
<div class="shows-box">

<h1>Our Outlets</h1>
<div class="options">
<span>
<select name="fcountry" id="fcountry">
<option value="">Country</option>
<?php 
$query_countryRs = "SELECT * FROM countries ORDER BY cid ASC";
$countryRs = mysql_query($query_countryRs, $eventscon) or die(mysql_error());
$row_countryRs = mysql_fetch_assoc($countryRs);
do {  
	$query_check_countryRs = "SELECT * FROM outlets where country1 = ".$row_countryRs['cid']." OR country2 = ".$row_countryRs['cid']." OR country3 = ".$row_countryRs['cid']." OR country4 = ".$row_countryRs['cid']." OR country5 = ".$row_countryRs['cid'];
	$check_countryRs = mysql_query($query_check_countryRs, $eventscon) or die(mysql_error());
	if (mysql_num_rows($check_countryRs)>0) {
?>
<option value="<?php echo $row_countryRs['cid']?>" <?php if (isset($_GET['country']) && !(strcmp($row_countryRs['cid'], $_GET['country']))) {echo "SELECTED";} ?>><?php echo $row_countryRs['country']?></option>
<?php
	}
} while ($row_countryRs = mysql_fetch_assoc($countryRs));
?>

</select>
</span>
<span>
<select name="fcity" id="fcity">
<option value="">City</option>
<?php 
$query_cityRs = "SELECT city1,city2,city3,city4,city5 FROM outlets";
$cityRs = mysql_query($query_cityRs, $eventscon) or die(mysql_error());
$cities_arr = array();
while ($row_cityRs = mysql_fetch_assoc($cityRs)){ 
for($i=1;$i<=5;$i++){
	if($row_cityRs['city'.$i]!='' && !in_array($row_cityRs['city'.$i],$cities_arr)){
		$cities_arr[]=$row_cityRs['city'.$i];
		?>
		<option value="<?php echo $row_cityRs['city'.$i]?>" <?php if (isset($_GET['city']) && !(strcmp($row_cityRs['city'.$i], $_GET['city']))) {echo "SELECTED";} ?>><?php echo $row_cityRs['city'.$i]?></option>
		<?php 
	}
}
} 
?>
</select>
</span>
<span>
<select name="farea" id="farea">
<option  value="">Area</option>
<?php 
$query_areaRs = "SELECT area1,area2,area3,area4,area5 FROM outlets";
$areaRs = mysql_query($query_areaRs, $eventscon) or die(mysql_error());
$areas_arr = array();
while ($row_areaRs = mysql_fetch_assoc($areaRs)){  
for($i=1;$i<=5;$i++){
	if($row_areaRs['area'.$i]!='' && !in_array($row_areaRs['area'.$i],$areas_arr)){
		$areas_arr[]=$row_areaRs['area'.$i];
		?>
		<option value="<?php echo $row_areaRs['area'.$i]?>" <?php if (isset($_GET['area']) && !(strcmp($row_areaRs['area'.$i], $_GET['area']))) {echo "SELECTED";} ?>><?php echo $row_areaRs['area'.$i]?></option>
		<?php 
	}
}
} 
?>
</select>
</span>
<span><input type="button" value="Filter" onclick="select_filter()" /></span>
</div>
<div class="shows-box-frames">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <?php if($totalRows_outletsRs>0){ do { ?>
                                  <tr style="background:#fff;">
                                    <td width="90" valign="top" style="padding:10px; background:#fff;"><div align="center">
                                        <?php if ($row_outletsRs['picture']!=""){ ?>
                                        <img src="./data/<?php echo $row_outletsRs['picture']; ?>" width="120" height="120" />
                                        <?php } ?>
                                    </div></td>
                                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><b><?php echo $row_outletsRs['outlet']; ?></b></td>
                                        </tr>
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['heading']; ?></td>
                                        </tr>
                                        <tr>
                                         <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['city1']; ?></td>
                                        </tr>
                                        <tr>
                                         <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['address1']; ?></td>
                                        </tr>
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><? if($row_outletsRs['city2']!=""){ ?>
                                            ,&nbsp;<?php echo $row_outletsRs['city2']; ?></td>
                                        </tr>
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['address2']; ?></td>
                                        </tr>
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><? } ?>
                                              <? if($row_outletsRs['city3']!=""){ ?>
                                              <br />
                                              <?php echo $row_outletsRs['city3']; ?></td>
                                        </tr>
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['address3']; ?></td>
                                        </tr>
                                        <tr>
                                         <td style="padding:10px; background:#fff;"><? } ?>
                                              <? if($row_outletsRs['city4']!=""){ ?>
                                              <br />
                                              <?php echo $row_outletsRs['city4']; ?></td>
                                        </tr>
                                        <tr>
                                          <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['address4']; ?></td>
                                        </tr>
                                        <tr>
                                         <td style="padding:10px; background:#fff;"><? } ?>
                                              <? if($row_outletsRs['city5']!=""){ ?>
                                              <br />
                                              <?php echo $row_outletsRs['city5']; ?></td>
                                        </tr>
                                        <tr>
                                         <td style="padding:10px; background:#fff;"><?php echo $row_outletsRs['address5']; ?></td>
                                        </tr>
                                        <tr>
                                          <td><? } ?>
                                          </td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td colspan="5" style="height:22px;" class="dot_line">&nbsp;</td>
                                  </tr>
                                  <?php } while ($row_outletsRs = mysql_fetch_assoc($outletsRs)); } ?>
                                </table></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
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
<script type="text/javascript">
function select_filter() {
	var filter = new Array();
	var cn_filter=document.getElementById('fcountry').value;
	var ct_filter=document.getElementById('fcity').value;
	var ar_filter=document.getElementById('farea').value;
	if(cn_filter != ''){
		filter.push('country='+cn_filter);
	}
	if(ct_filter != ''){
		filter.push('city='+ct_filter);
	}
	if(ar_filter != ''){
		filter.push('area='+ar_filter);
	}
	var filter_val ='';
	if(filter.length >0){
		var filter_data = filter.join('&');
		filter_val = '?'+filter_data;
	}
	window.location.href='http://www.tktrush.com/outlets.php'+filter_val;
}
</script>
</body>
</html>
