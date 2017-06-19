<?php require_once('header.php'); 

mysql_select_db($database_eventscon, $eventscon);
$city_id=$_GET['city'];
$sql = "SELECT * FROM cities where id='$city_id'";
$query=mysql_query($sql,$eventscon);
$result=mysql_fetch_assoc($query);
if(!empty($result))
{
	setcookie('city_id',$city_id,time()+60*60*24*365);
	header('location:'.$_SERVER['HTTP_REFERER']);
}
else
{
	header('location:'.$_SERVER['HTTP_REFERER']);
}

?>
