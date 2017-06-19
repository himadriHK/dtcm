<?php
require("access.php");
include("../config.php"); 
require("connection1.php");
$file_path=$_SERVER['DOCUMENT_ROOT'];
	$id= mysql_connect($server,$login,$password);
	mysql_select_db($base,$id);
	
if(isset($_POST['_method']) && $_POST['_method']){
	$popup_id = $_POST['_method'];	
	$query_guidecatRs = "SELECT * FROM `popup` where id = ".$popup_id;
	$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
	while ($row = mysql_fetch_array($guidecatRs, MYSQL_ASSOC)) {
		$popup[] = $row;
	}
	if(count($popup)!==1){
		header('Location: popup.php');exit;		
	}else{
		$popup = reset($popup);	
	}
	$query_guidecatRs = "DELETE FROM `popup` where id = ".$popup_id;
	$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
	if($popup['source'] && $popup['type']==1 && file_exists($file_path.'/popup/'.$popup['source']))
			unlink($file_path.'/popup/'.$popup['source']);
}
		
$query_guidecatRs = "SELECT * FROM `popup`";
$guidecatRs = mysql_query($query_guidecatRs, $id) or die(mysql_error());
while ($row = mysql_fetch_array($guidecatRs, MYSQL_ASSOC)) {
	$popups[] = $row;
}
?>

<html>
<head>
<title><?require"title.php";?></title>
<link href="events.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td width="200" valign="top" bgcolor=<?echo"$contentbg";?>><?php require("contents.php"); ?></td> 
    <td width="1" valign="top" background="../images/up-dot.gif"><img src="../images/up-dot.gif" width="1" height="3">
    <img src="../images/up-dot.gif" width="1" height="3"></td>
    <td align="center" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300">
    <b>Pop-up</b></font><br>
      <table border="0" cellspacing="3" cellpadding="1">
<tr>	</tr>
      </table>
      <br>
   			<a href="popup_add.php" style="float: right;margin-right: 1.5%;margin-bottom: 10px;text-decoration: underline;">Create Popup</a>
      <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F3F3F3">
        <tr bgcolor="#CCCCCC"> 
          <td width="30%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">title</font></b></td>
          <td width="30%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">type</font></b></td>
		  <td width="30%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">source</font></b></td>	
          <td width="30%" height="19"><b><font face="Verdana, Arial, Helvetica, sans-serif" color="#CC3300" size="2">status</font></b></td>	
          <td width="10%" height="19" align="center">Action</td>
          
        </tr>
        <?php  
			if(is_array($popups )){
		foreach($popups as $popup) { ?>
        <tr valign="top"> 
          <td width="30%"><?php echo $popup['title']; ?></td>
          <td valign="middle" width="30%"><?php echo ($popup['type']==1)?'Image':'Video'; ?></td>
          <td valign="middle" width="30%"><?php echo $popup['source']; ?></td>
          <td valign="middle" width="30%"><?php echo ($popup['status']==1)?'Publish':'Unpublish'; ?></td>  
          <td valign="middle" width="10%"><a href="popup_edit.php?e=<?php echo $popup['id']; ?>">Edit</a>
          	<form action="#" name="post_55ecfb9a228c0621590796" id="post_55ecfb9a228c0621590796" style="display:none;" method="post"><input type="hidden" name="_method" value="<?php echo $popup['id']; ?>"></form>
            <a href="#" onclick="if (confirm(&quot;Are you sure you want to delete&quot;)) { document.post_55ecfb9a228c0621590796.submit(); } event.returnValue = false; return false;">Delete</a>
          </td>	
        </tr>
       <?php } }else{  ?>
		   
		   <tr><td align="center" valign="middle" colspan="5">No popups available.</td></tr>
		   
	  <?php  }?>


      </table>
         </td>
  </tr>
</table>
</body>
</html>