<?php 
require_once('header.php');
unset($_SESSION['Customer']); 
require_once('facebook/facebook.php');
require_once('facebooklogout.php');
session_destroy();
header('location:index.php');

?>

<?php require_once('footer.php'); ?>

</body>
</html>
