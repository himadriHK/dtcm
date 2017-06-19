<?php ob_start(); ?>
<link href="bootstrap.css" rel="stylesheet" />
<style type="text/css">
.menu_tab ul ul {
	display: none;
}
.menu_tab ul li:hover>ul {
	display: block;
}
.menu_tab ul {
	display: inline-table;
	list-style: none outside none;
	position: relative;
}
.menu_tab ul:after {
	content: "";
	clear: both;
	display: block;
}
.menu_tab ul li {
	float: left;
}
.menu_tab ul li:hover a {
	color: #fff;
}
.menu_tab ul li a {
	display: block;
	text-decoration: none;
}
.menu_tab ul ul {
	background: #008dce );
	border-radius: 0px;
	padding: 10px;
	position: absolute;
	top: 100%;
}
.menu_tab ul ul li {
	float: none;
	text-align: left;
	border-bottom: 1px solid rgba(0, 0, 0, 0.25);
	position: relative;
}
.menu_tab ul ul li a {
	padding: 10px 20px;
	color: #fff;
	font-size: 12px;
	width: 150px !important;
	text-transform: capitalize;
}
.menu_tab ul ul li a:hover {
	background: rgba(0, 0, 0, 0.25);
}
.menu_tab ul ul ul {
	position: absolute;
	left: 100%;
	top: 0;
}
</style>
<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/skin.css">
<?php 
//require_once('header.php');

 ?>
<?php require_once('Connections/eventscon.php');?>

<div class="main-content">
<div class="container">

<?php //require_once('left_content.php'); ?>

<div class="conent-right">
<?php //require_once('banner2.php'); ?>

<!--<div class="slider"> <img src="img/slider.jpg" /></div>-->
<?php //require_once('menu.php'); ?>
<div class="shows-box">

<h1>Promotor <?php if (!$_SESSION['MM_UserId']){echo 'Login';}else{echo "Details";} ?></h1>
<div class="shows-box-frames">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" >

                  <tr>
                    <td align="left"><?php

		/*if (!$_SESSION['MM_UserId']){

		 include("login.php");

		 } else {*/

		 include("salesinfo.php");

		 //}

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

<?php //require_once('footer.php'); ?>

</body>
</html>
