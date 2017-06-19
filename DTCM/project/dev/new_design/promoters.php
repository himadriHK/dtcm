<?php 
require_once('header.php');

 ?>

<div class="main-content">
<div class="container">

<?php require_once('left_content.php'); ?>

<div class="conent-right">
<?php require_once('banner2.php'); ?>

<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php require_once('menu.php'); ?>
<div class="shows-box">

<h1>Promotor <?php if (!$_SESSION['MM_UserId']){echo 'Login';}else{echo "Details";} ?></h1>
<div class="shows-box-frames">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" >

                  <tr>
                    <td align="left"><?php

		if (!$_SESSION['MM_UserId']){

		 include("login.php");

		 } else {

		 include("salesinfo.php");

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
