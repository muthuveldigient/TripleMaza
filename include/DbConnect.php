<?php

error_reporting(0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//QA
$username = 'kheloqa';
$password = 'kheloqa';		
$dbhost = '54.254.155.69';		
$database = 'triplemaza_mstr_qa'; 

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

/** triple maza game details */
define('GAME_ID', '1');
define('GAME_REF_NO', 'AAA');
define('GAME_NAME', 'triplemaza');


$url = 'http://'.$_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='10.0.0.65'){
	$url = 'http://'.$_SERVER['HTTP_HOST'].'/triplemaza';
}

//Local
define('LOGIN_URL', $url.'/login.php');
//define('LOGIN_LANDING_URL', $url.'/home.php');
define('TM_SITE_URL', $url.'/web/');
define('TM_WEB_SOCKET_URL', "ws://192.168.0.164:5862/?encoding=text");//Local Vinoth
//define('TM_WEB_SOCKET_URL', "ws://54.254.155.69:8899/?encoding=text");

?>
