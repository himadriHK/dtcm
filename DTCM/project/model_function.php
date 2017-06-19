<?php 
 require_once('Connections/eventscon.php');
 
 function get_set_type()
 { 
	$sql="select * from seats";
	$result=mysql_query($sql);
	$total=@mysql_num_rows($result);
	if($total)
	{
		while($seat=mysql_fetch_assoc($result)){
		$seat_type_arr[$seat['id']]=$seat['seat_type'];
		}
	}
	return $seat_type_arr;
}
function pr($arr)
{
	echo "<pre/>";
	print_r($arr);
}
 ?>