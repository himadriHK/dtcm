<?php require_once('../Connections/eventscon.php'); 
$id=$_GET['id'];
mysql_select_db($database_eventscon, $eventscon);
$sql = "select * FROM category where id='$id'";
$category_query = mysql_query($sql, $eventscon) or die(mysql_error());
$category=mysql_fetch_assoc($category_query);
unlink('../upload/category/'.$category['image']);
$query_shiplist = "delete FROM category where id='$id'";
mysql_query($query_shiplist, $eventscon) or die(mysql_error());
header('location:view_event_category.php');

?>
