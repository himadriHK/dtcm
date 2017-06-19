<?php 
require_once('Connections/eventscon.php'); 



if(!empty($_POST) )

{
	if (isset($_POST['code'])) {
$code = $_POST['code'];
}
else
header("location:index.php");


$code_sql=sprintf("SELECT * FROM ticket_orders where uniquecode='%s' AND downloaded=0 ORDER BY oid DESC",$code);

$code_query = mysql_query($code_sql, $eventscon) or die(mysql_error());
if(mysql_num_rows($code_query)==0)
header("location:index.php");
else
$order_details=mysql_fetch_assoc($code_query);
if($_POST['verifycode']!='')
{
	$verifycode=$_POST['verifycode'];
	
	if(!empty($order_details) && $verifycode==$order_details['verifycode'])

	{

		$_SESSION['success']='You free Voucher has been downloaded';
		$order_update=mysql_query("UPDATE ticket_orders SET downloaded=1 where oid=".$order_details['oid']);
		
		$eventrs=mysql_query("SELECT voucher_image from events where tid=".$order_details['tid']);
		$event_voucher=mysql_fetch_assoc($eventrs);
		$file=dirname(__FILE__).'/data/'.$event_voucher['voucher_image'];
		
		if(ini_get('zlib.output_compression')) 
    ini_set('zlib.output_compression', 'Off'); 



  // File Exists? 
  if( file_exists($file) ){ 
    
    // Parse Info / Get Extension 
     $fsize = filesize($file); 
    $path_parts = pathinfo($file); 
    $ext = strtolower($path_parts["extension"]); 
    header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.urlencode(trim(basename($file))).'"'); 
	header('Content-Transfer-Encoding: binary');
	header('Connection: Keep-Alive');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
    ob_clean(); 
    flush(); 
	//die(file_get_contents($file));exit;
   readfile( $file ); exit;
  }

	}

	else {

		$_SESSION['error']='Invalid Verification code';

	}
	
	


  } 
  else
  {
	  $_SESSION['error']='Invalid Verification code';
  }
  header("location:getvoucher.php?code=".$code);exit;
}