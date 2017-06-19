<?php
ini_set('display_errors', 0);
define('DEBUG', true);

if ( DEBUG ) {
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors', 1);
}

$config = array();
$config['SITE_NAME'] = "Ticket Master";
$config['ADMIN_RESULTS_PER_PAGE'] = 10;

$DBTYPE = 'mysql';
$DBHOST = '10.168.1.47';
$DBNAME = 'tktrushc_dbase';
$DBUSER = 'tktrushc_user';
$DBPASSWORD = 'LP0q221p';

$conn = mysqli_connect($DBHOST,$DBUSER,$DBPASSWORD,$DBNAME);
if(mysqli_connect_errno()){
	echo "Could not connect to mysql! Please check your database settings! " . mysqli_connect_error();
}

$config['BASE_DIR'] = dirname(dirname(__FILE__));

require_once('include/security.php');
require_once(dirname($config['BASE_DIR']). '/config.php');

session_start();
?>