<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
include("Medoo.php");
ob_start();
use Medoo\Medoo;
@session_start();
$hostname_eventscon = "localhost";
$database_eventscon = "tktrushc_dbase";
$username_eventscon = "root";
$password_eventscon = "root";
$eventscon = @mysql_pconnect($hostname_eventscon, $username_eventscon, $password_eventscon) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_eventscon, $eventscon);
require_once(dirname(dirname(__FILE__)).'/config.php');

 
// Initialize
$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => $database_eventscon,
    'server' => $hostname_eventscon,
    'username' => $username_eventscon,
    'password' => $password_eventscon
]);
global $database;

?>