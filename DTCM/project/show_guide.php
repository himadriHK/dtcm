<?php require_once('Connections/eventscon.php'); ?>
<?php

/*

mysql_select_db($database_eventscon, $eventscon);

$query_categoryRs = "SELECT * FROM guide_cat ORDER BY name ASC";

$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());

$row_categoryRs = mysql_fetch_assoc($categoryRs);

$totalRows_categoryRs = mysql_num_rows($categoryRs);



$colname_guideRs = "-1";

if (isset($_GET['category'])) {

  $colname_guideRs = (get_magic_quotes_gpc()) ? $_GET['category'] : addslashes($_GET['category']);

$query_guideRs = sprintf("SELECT * FROM guide WHERE catid = %s ORDER BY name ASC", $colname_guideRs);

} else {

$query_guideRs = "SELECT * FROM guide ORDER BY cid, name ASC";

}



//echo $query_guideRs;

mysql_select_db($database_eventscon, $eventscon);

$guideRs = mysql_query($query_guideRs, $eventscon) or die(mysql_error());

$row_guideRs = mysql_fetch_assoc($guideRs);

$totalRows_guideRs = mysql_num_rows($guideRs);

*/

?>

<table border="0" cellspacing="0" cellpadding="0" class="guide_options">
  
  <!--  <tr>

    <td background="images/faselm1n.png" class="eventVenue"><?php

//if($totalRows_sub_categoryRs>0){

?>

        <form id="form1" name="form1" method="post" action="guide.php?category=<?php echo $colname_guideRs ?>">

          <select name="subcatid" onchange="this.form.submit()">

            <option value="">Select Sub Category</option>

            <?php 

//do {  

?>

            <option value="<?php //echo $row_sub_categoryRs['subcatid']?>" ><?php //echo $row_sub_categoryRs['name']?></option>

            <?php

//} while ($row_sub_categoryRs = mysql_fetch_assoc($sub_categoryRs));

?>

          </select>

        </form>

      <?php //} ?>

    </td>

  </tr> -->
  
  <?php if($totalRows_guideRs>0){ do { ?>
  <tr>
    <td align="left" class="dot_line">&nbsp;</td>
  </tr>
  <tr style="background: none repeat scroll 0 0 #555555; color: #FFFFFF; display: block; padding: 5px;">
    <td align="left"><b class="arrow"><?php echo $row_guideRs['name']; ?></b></td>
  </tr>
  <tr style=" background: none repeat scroll 0 0 #F1F1F1;    border-bottom: 1px solid #999999;    float: left;    width: 100%;">
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php

						  if ($row_guideRs['logo']!=""){

						  ?>
                    <tr>
                      <td colspan="2" style="height:5px;"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><table border="0" cellspacing="5" cellpadding="0" bgcolor="#FFFFFF">
                          <tr>
                            <td align="left"><img src="data/<?php echo $row_guideRs['logo']; ?>" /></td>
                          </tr>
                        </table></td>
                    </tr>
                    <?php

							}

							?>
                    <tr>
                      <td colspan="2" style="height:5px;"></td>
                    </tr>
                    <tr>
                      <td style="width:70px;">Address:</td>
                      <td style="width:379px;"><?php echo $row_guideRs['address']; ?></td>
                    </tr>
                    <tr>
                      <td height="18">City:</td>
                      <td><?php echo $row_guideRs['city']; ?></td>
                    </tr>
                    <tr>
                      <td height="18">Phone:</td>
                      <td><?php echo $row_guideRs['phone']; ?></td>
                    </tr>
                    <?php

						  if ($row_guideRs['website']!=""){

						  ?>
                    <tr>
                      <td height="18">Website:</td>
                      <td><a href="http://<?php echo $row_guideRs['website']; ?>" target="_blank"><?php echo $row_guideRs['website']; ?></a></td>
                    </tr>
                    <?php

							}

						  if ($row_guideRs['email']!=""){

						  ?>
                    <tr>
                      <td height="18">Email:</td>
                      <td><a href="mailto:<?php echo $row_guideRs['email']; ?>"><?php echo $row_guideRs['email']; ?></a></td>
                    </tr>
                    <?php

							}

						  if ($row_guideRs['information']!=""){

						  ?>
                    <tr>
                      <td height="18" valign="top">Info:</td>
                      <td><a href="http://<?php echo $row_guideRs['information']; ?>" target="_blank"><?php echo $row_guideRs['information']; ?></a></td>
                    </tr>
                    <?php

							}

						  if ($row_guideRs['pic1']!=""){

						  ?>
                    <tr>
                      <td height="18">More Images:</td>
                      <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                          <tr>
                            <td><a href="show_guide_images.php?guideid=<?php echo $row_guideRs['gid']?>" target="_blank"><img src="images/pictures_button.gif" width="126" height="29" border="0" /></a></td>
                          </tr>
                        </table></td>
                    </tr>
                    <?php

							}

							?>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td background="images/w-dot.gif"><img src="images/w-dot.gif" width="3" height="1" /></td>
        </tr>
      </table></td>
  </tr>
  <?php } while ($row_guideRs = mysql_fetch_assoc($guideRs)); } ?>
</table>
