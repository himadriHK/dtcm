<?php require_once('../Connections/eventscon.php'); ?>
<?php
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

mysql_select_db($database_eventscon, $eventscon);
if(!empty($_POST))
{
	$data='';
	foreach($_POST['config'] as $key=>$val){
		$data.='`'.$key.'`="'.$val.'",';
	}
	$data=trim($data,',');
	
	if($data!=''){
		$sql="Update `setting` set $data where `id`='1'";
		mysql_query($sql, $eventscon) or die(mysql_error());
	}
}

?>
<?php require("access.php"); ?>
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
</head>
<body>
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
              <th height="35" style="width:334px;" bgcolor="#C31600"><span class="headeradmin">-</span><span class="eventHeader"><h1>Facebook Setting</h1></span></th>
            
            </tr>
           
          </table>
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
            <style>
			.input_filed_50{
				width:45%;
			}
			</style>
              <?php 
              $sql = "SELECT * FROM setting";
              $sqlq= mysql_query($sql, $eventscon) or die(mysql_error());
              $config= mysql_fetch_assoc($sqlq);
		
                ?>
                <form action="" method="post">
                <tr>
                  <td bgcolor="#E9E9E9">Facebook App Id:</td>
                  <td bgcolor="#E9E9E9"><input type="text" class="input_filed_50" name="config[fbappid]" value="<?php echo $config['fbappid'];?>"/></td>
                </tr>
                <tr>
                  <td bgcolor="#E9E9E9">Facebook Secret Key:</td>
                  <td bgcolor="#E9E9E9"><input type="text" class="input_filed_50"  name="config[fbskey]" value="<?php echo $config['fbskey'];?>"/></td>
                </tr>
                <tr><td bgcolor="#E9E9E9"></td>
                  <td bgcolor="#E9E9E9"><input type="submit" name="Save" value="Save"/></td></tr>
               </form>
        </table>         
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($shiplist);
?>
