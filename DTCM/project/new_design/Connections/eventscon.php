<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
ob_start();
session_start();
$hostname_eventscon = "localhost";
$database_eventscon = "nasserdx_tm";
$username_eventscon = "nasserdx_boss";
$password_eventscon = "12121212";
$eventscon = mysql_pconnect($hostname_eventscon, $username_eventscon, $password_eventscon) or trigger_error(mysql_error(),E_USER_ERROR);
?>
