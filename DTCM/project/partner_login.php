<?php require_once('Connections/eventscon.php'); ?>

<?php

// *** Validate request to login to this site.


$loginFormAction = $_SERVER['PHP_SELF'];

if (isset($_GET['accesscheck'])) {

  $_SESSION['PrevUrl'] = $_GET['accesscheck'];

}



if (isset($_POST['username'])) {

//echo "in the if";

  $loginUsername=$_POST['username'];

  $password=$_POST['ppassword'];

  $MM_fldUserAuthorization = "spid";

  $MM_redirectLoginSuccess = "partners.php";

  $MM_redirectLoginFailed = "partners.php?err=1";

  $MM_redirecttoReferrer = false;

  mysql_select_db($database_eventscon, $eventscon);

  	

  $LoginRS__query=sprintf("SELECT login, spid, email FROM partners WHERE login='%s' AND password='%s' and blockuser = 'No'",

  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 

   //echo $LoginRS__query;

  $LoginRS = mysql_query($LoginRS__query, $eventscon) or die(mysql_error());

  $row_LoginRS = mysql_fetch_assoc($LoginRS);

  $loginFoundUser = mysql_num_rows($LoginRS);

  if ($loginFoundUser) {

    

    $loginStrGroup  = mysql_result($LoginRS,0,'spid');

    

    //declare two session variables and assign them

    $_SESSION['PP_Username'] = $loginUsername;

    $_SESSION['PP_UserGroup'] = $loginStrGroup;

    $_SESSION['PP_UserId'] = $row_LoginRS["spid"];

    $_SESSION['PP_UserEmail'] = $row_LoginRS["email"];



    if (isset($_SESSION['PrevUrl']) && false) {

      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	

    }

	//echo "Loged in ";

    header("Location: " . $MM_redirectLoginSuccess );
     //header("Location:index.php");
  
  }

  else {

    header("Location: ". $MM_redirectLoginFailed );

  }

}

?><style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

-->

</style>

<form id="loginForm" name="LoginForm" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="449" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td style="height:5px;"></td>
    </tr>
    <tr>
      <td>User Name:</td>
    </tr>
    <tr>
      <td style="height:5px;"></td>
    </tr>
    <tr>
      <td><input name="username" type="text" class="formField" id="username" /></td>
    </tr>
    <tr>
      <td style="height:5px;"></td>
    </tr>
    <tr>
      <td>Password:</td>
    </tr>
    <tr>
      <td style="height:5px;"></td>
    </tr>
    <tr>
      <td><input name="ppassword" type="password" class="formField" id="ppassword" /></td>
    </tr>
    <tr>
      <td style="height:5px;"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Login" class="reg_btn" /></td>
    </tr>
  </table>
</form>

