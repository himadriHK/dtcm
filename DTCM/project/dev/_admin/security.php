<?php
if(!session_id())session_start();
if(!isset($_SESSION['Username']) || !isset($_SESSION['UserId'])) {
 	header("Location: login.php");
	exit();
}
?>