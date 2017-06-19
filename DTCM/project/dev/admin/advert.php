<?php require_once('../Connections/eventscon.php'); ?>
<?php
if(isset($_GET['cat']) && $_GET['cat'] != '') {
	$cat = $_GET['cat'];
} else {
	$cat = 'all';
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

?>
<?php require("access.php"); ?>
<?php 
$query_categoryRs = "SELECT * FROM category ORDER BY name ASC";

$categoryRs = mysql_query($query_categoryRs, $eventscon) or die(mysql_error());
$query_advertRs = "SELECT * FROM event_adverts where category = '".$cat."'";

$advertRs = mysql_query($query_advertRs, $eventscon) or die(mysql_error());

$row_advertRs = mysql_fetch_assoc($advertRs);
if($_POST !='') {
$error=0;
$xpic = "advertimage";
if (($_FILES[$xpic]['name']<>"none") && ($_FILES[$xpic]['name']<>"") && substr($_FILES[$xpic]['type'],0,5)=='image'){
move_uploaded_file($_FILES[$xpic]["tmp_name"],"../data/advert/".$_FILES[$xpic]['name']);
$advert_image = $_FILES[$xpic]['name'];
}
else {
	$advert_image = $_POST["advertimage"];
}
$advert_link = $_POST['advertlink'];
$advert_video = $_POST['advertvideo'];
if($advert_image == '' || $advertvideo == '' || $advertlink == '') {
	$error=1;
}
if($error == 0 ) {
	if(mysql_num_rows($advertRs) > 0) {
		$updateSQL = sprintf("UPDATE event_adverts SET category='".$cat."', image='".$advert_image."',link='".$advert_link."', video='".$advert_video."'  WHERE id=".$row_advertRs['id']);
		$Result1 = mysql_query($updateSQL, $eventscon) or die(mysql_error());
	} else {
		$insertSQL = sprintf("INSERT INTO event_adverts (id,category, image,link, video) VALUES (null,'".$cat."','".$advert_image."','".$advert_link."','".$advert_video."')");
		$Result1 = mysql_query($insertSQL, $eventscon) or die(mysql_error());
	}
	$query_advertRs = "SELECT * FROM event_adverts where category = '".$cat."'";

$advertRs = mysql_query($query_advertRs, $eventscon) or die(mysql_error());

$row_advertRs = mysql_fetch_assoc($advertRs);
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="events.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.headeradmin {color: #C31600}
-->
</style>
<script src="../js/jquery-1.8.2.js" type="text/javascript">
</script>
<script src="../js/jquery.validate.js" type="text/javascript"></script>
</head>
<body>
 <form action="advert.php?cat=<?php echo $cat;?>" method="post" enctype="multipart/form-data" id="validate_category" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td width="200" valign="top"><?php require("contents.php"); ?></td>
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3" /></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td height="35" style="width:334px;" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader">Advert Image/Video</span></td>
            
              <td height="35" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader"></span></td>
            </tr>
            <tr>
              <td background="../images/w-dot.gif"><img src="../images/w-dot.gif" width="3" height="1" /></td>
            </tr>
          </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
             
                <tr>
                  <td bgcolor="#E9E9E9">Category</td>
                  <td bgcolor="#E9E9E9">
                  	<select name="category" onchange="show_advert(this.value)">
                  		<option value='all'>All</option>
                  		<?php
                  		while($row_categoryRs = mysql_fetch_assoc($categoryRs)) {
                  			echo '<option value="'.$row_categoryRs['id'].'" '.(($row_categoryRs['id']==$cat)?'selected="selected"':'').' >'.$row_categoryRs['name'].'</option>';
						} 
                  		?>
                  	</select>
                  </td>
                </tr>
                 <tr>
                  <td bgcolor="#E9E9E9">Advert Image</td>
                  <td bgcolor="#E9E9E9">
                  <input name="advertimage" type="file" class="formField" id="advertimage" />
                  
                  </td>
                </tr>
                <?php 
                  if(isset($row_advertRs['image']) && $row_advertRs['image']!= '') {
                  	echo '<input type="hidden" name="advertimage" value="'.$row_advertRs['image'].'" />';
                 
                  ?>
                <tr>
                <td>&nbsp;</td>
                <td><img src="../data/advert/<?php echo $row_advertRs['image'];?>" /></td>
                </tr>
                <?php } ?>
                 <tr>
                  <td bgcolor="#E9E9E9">Advert Image Link</td>
                  <td bgcolor="#E9E9E9">
                  <input name="advertlink" type="text" class="formField" id="advertlink" />
                  
                  </td>
                </tr>
                <tr>
                
                  <td bgcolor="#E9E9E9">Advert Video URL</td>
                  <td bgcolor="#E9E9E9"><textarea name="advertvideo" class="required" rows=5 cols=20>
                   <?php 
                  if(isset($row_advertRs['video']) && $row_advertRs['video']!= '') {
                  	echo $row_advertRs['video'];
                  }
                  ?>
                  
                  </textarea></td>
                </tr>
               
                
                <tr>
                  <td bgcolor="#E9E9E9">&nbsp;</td>
                  <td bgcolor="#E9E9E9"><input type="submit" value="Save"/></td>
                </tr>
              
        </table>          </tr>
      </table></td>
  </tr>
</table>
 </form>
<script>
$(document).ready(function(e) {
    $("#validate_category").validate();
});
function show_advert(cat)
{
	if(cat!='')
	{
		window.location.href='advert.php?cat='+cat;
	}
}

</script>
</body>
</html>
<?php
mysql_free_result($shiplist);
?>
