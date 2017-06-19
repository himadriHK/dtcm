<?php require_once('header.php'); 

mysql_select_db($database_eventscon, $eventscon);
$query_outletsRs = "SELECT * FROM outlets ORDER BY outlet ASC";
$outletsRs = mysql_query($query_outletsRs, $eventscon) or die(mysql_error());
$row_outletsRs = mysql_fetch_assoc($outletsRs);
$totalRows_outletsRs = mysql_num_rows($outletsRs);
?>


<div class="main-content">
<div class="container">

<?php require_once('left_content.php'); ?>

<div class="conent-right">
<?php require_once('banner2.php'); ?>
<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php require_once('menu.php'); ?>
<div class="shows-box">

<h1>Our Outlets</h1>
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

</body>
</html>
