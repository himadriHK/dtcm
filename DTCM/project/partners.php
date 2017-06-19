<?php 
require_once('header.php');

 ?>

<div class="main-content">
<div class="container">

<?php require_once('left_content.php'); ?>

<div class="conent-right">
<?php //require_once('banner2.php'); ?>

<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php require_once('menu.php'); ?>
<div class="shows-box" style="padding:20px 10px; width:inherit;">

<h1>Partner <?php if (!$_SESSION['PP_UserId']){echo 'Login';}else{echo "Details";} ?></h1>
<div class="shows-box-frames">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" >

                  <tr>
                    <td align="left"><?php

		if (!$_SESSION['PP_UserId']){

		 include("partner_login.php");

		 } else {

		 //include("salesinfo.php");
            //echo '<pre>'; print_r($_SESSION);
            echo '<center><h2>Welcome '.$_SESSION['PP_Username'].'</h2></center>';

		 }

		  ?></td>
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
