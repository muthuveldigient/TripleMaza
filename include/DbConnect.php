<?php

error_reporting(0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


//DEV
/*
$username = 'mab';
$password = 'mab';		
$dbhost = '35.154.86.183';		
$database = 'khelqa'; */
//QA
$username = 'kheloqa';
$password = 'kheloqa';		
$dbhost = '54.254.155.69';		
$database = 'khelqa'; 



mysql_pconnect("$dbhost", "$username", "$password") or die('I cannot connect to the database because: ' . mysql_error());
mysql_select_db("$database") or die('I cannot connect to the database because: ' . mysql_error());

$connection = mysqli_connect("$dbhost", "$username", "$password", "$database", "3306");

/** session Value */
define('SESSION_USERNAME', 'lucky_username');
define('SESSION_USERID', 'lucky_userid');
define('SESSION_PARTNERID', 'lucky_partnerid');
define('SESSION_PARTNERNAME', 'lucky_partnername');
define('SESSIONID', 'lucky_sessionID');
define('SESSION_USEREMAIL', 'lucky_email');
define('SESSION_USERCONTACT', 'lucky_contact');
define('SESSION_USER_TYPE', 'lucky_user_type');
define('SESSION_PRINTER_OPTION', 'lucky_printer_option');

$url = 'http://'.$_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='10.0.0.65'){
	$url = 'http://'.$_SERVER['HTTP_HOST'].'/triplemaza';
}
//Local
define('LOGIN_URL', $url.'/login.php');
define('LOGIN_LANDING_URL', $url.'/home.php');
define('TM_SITE_URL', $url.'/web/');
//define('TM_WEB_SOCKET_URL', "ws://10.0.0.58:8899/?encoding=text");//Local Vinoth
define('TM_WEB_SOCKET_URL', "ws://54.254.155.69:8899/?encoding=text");
define('API_HOST_NAME', 'http://54.254.155.69:8090/Live_tc_API');




?>
