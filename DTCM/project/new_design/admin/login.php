<?php require_once('../Connections/eventscon.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
if(isset( $_SESSION['Username'])){
  header("Location: index.php");
}
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=md5($_POST['ppassword']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_eventscon, $eventscon);
  
  $LoginRS__query=sprintf("SELECT login, password FROM event_admin WHERE login='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $eventscon) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['Username'] = $loginUsername;
    $_SESSION['UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }  
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
  
   $_SESSION['loginerror']='set';
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ticket Master</title>
<link href="../events.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="765" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php require("head.php"); ?></td>
  </tr>
  <tr>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
  </tr>
  <tr>
    <td><table width="765" border="0" cellpadding="0" cellspacing="0" bgcolor="#101010">
      <tr>
        <td width="206" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="../images/g-dot.jpg" width="7" height="7" /></td>
            </tr>
            <tr>
              <td><div align="center"></div></td>
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
        <td><img src="../images/fasel-inbetween.png" width="2" height="3" /></td>
        <td width="353" bgcolor="#222222">
<form id="loginForm" name="LoginForm" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="100%" border="0" cellpadding="3" cellspacing="0" class="eventVenue">
    <tr>
      <td colspan="3" class="eventHeader"><span style="color:#ffffff;">Administrator  Login</span> </td>
    </tr>
    <tr>
      <td width="35%" colspan="3">
      <?php 
      if(isset($_SESSION['loginerror']) && $_SESSION['loginerror']=='set') {
    // unset($_SESSION['loginerror']);
      ?>
      <span style="color:#FF0000;margin-left:109px;">Invalid Username/Password.</span>
      <?php } ?>
      </td>
      
    </tr>
    <tr>
      <td width="35%"><span style="color:#ffffff;">User Name: </span></td>
      <td>&nbsp;</td>
      <td width="65%"><input name="username" type="text" class="formField" id="username" /></td>
    </tr>
    <tr>
      <td width="35%"><span style="color:#ffffff;">Password:</span></td>
      <td>&nbsp;</td>
      <td width="65%"><input name="ppassword" type="password" class="formField" id="ppassword" /></td>
    </tr>
    <tr>
      <td width="35%">&nbsp;</td>
      <td>&nbsp;</td>
      <td width="65%"><input type="submit" name="Submit" value="Login" /></td>
    </tr>
    <tr>
      <td width="35%">&nbsp;</td>
      <td>&nbsp;</td>
      <td width="65%">&nbsp;</td>
    </tr>
  </table>
</form>
		</td>
        <td><img src="../images/fasel-inbetween1.png" width="2" height="3" /></td>
        <td width="206">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="../images/b-dot.png" width="8" height="8" /></td>
  </tr>
  <tr>
    <td><?php require("footer.php"); ?></td>
  </tr>
</table>
</body>
</html>
