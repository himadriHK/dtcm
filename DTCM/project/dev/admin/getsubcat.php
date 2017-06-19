<?php require_once('../Connections/eventscon.php'); ?>
<?
mysql_select_db($database_eventscon, $eventscon);
$query_sub_categoryRs = "SELECT * FROM guide_sub_cat where catid=".$_GET["q"]." ORDER BY name ASC";
$sub_categoryRs = mysql_query($query_sub_categoryRs, $eventscon) or die(mysql_error());
$row_sub_categoryRs = mysql_fetch_assoc($sub_categoryRs);
$totalRows_sub_categoryRs = mysql_num_rows($sub_categoryRs);
//if ($totalRows_sub_categoryRs < 0){
?>
<select name="subcatid">
      <?php 
do {  
?>
      <option value="<?php echo $row_sub_categoryRs['subcatid']?>" ><?php echo $row_sub_categoryRs['name']?></option>
      <?php
} while ($row_sub_categoryRs = mysql_fetch_assoc($sub_categoryRs));
?>
    </select>
<?
//}
?>