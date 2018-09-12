<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
// define('BALANCE_UPDATE_API','54.254.155.69:8090');
define('BALANCE_UPDATE_API','http://54.254.155.69:8090/Digient_casino_API_Mazza/servlet/GameApiServlet');

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

// Cakewalk
define('WEBSITE','http://userdb.cakewalk.in/website');
define('USER','http://userdb.cakewalk.in/User');
define('AGENT','http://userdb.cakewalk.in/Agent');
define('SITEEMAIL','http://userdb.cakewalk.in/Email/Site');
define('USERMAIL','http://userdb.cakewalk.in/EMAIL/User');
define('SITESMS','http://userdb.cakewalk.in/SendSms/Site');
define('USERSMS','http://userdb.cakewalk.in/SendSms/User');
define('CHANGEEMAIL','http://userdb.cakewalk.in/User/ChangeEmailId');
define('CHANGEPASSWORD','http://userdb.cakewalk.in/User/ChangePassword');
define('ADMIN_ID',10001);
define('RR_GAME_ID',1);

//define('SITEID',24);
define('SITEID',20);
define('CAKEWALK_PASSWORD','test123');
define('CAKEWALK_PARTNERID',20);
define('HASHSTRING','r2rtoken');
define('ONLINE_GAME_NAME','shan_mp');

define('KHELOJEETO_ID',128);

define('SHAN_GAME_IDS','shan_mp');
define('POKER_GAME_IDS',serialize(array("Texas Hold'em","mobpoker")));
define('CASINO_GAME_IDS',serialize(array("shan_mp","Texas Hold'em","mobpoker"))); //NOT THE CASINO/SHAN GAME
define('ONLINE_POKER_GAME_NAME','mobpoker');
//define('MOBILE_GAMES',"'mobroulette36','mobroulette12','mobroulette12_timer','mobroulette36_timer','mobblackjack','mobbaccarat','mobamerican_roulette36_minitimer','mob_american_roulette36','mobtriplechance','mobtriplechancetimer','mobluckycardtimer','mobluckycard','mobslotreel5_china_t1','mobslotreel5_pharaoh_t1','mobslotreel5_pharaoh_t2','mobslotreel5_nordic_t1','mobslotreel5_nordic_t2','mobandarbahar','mobmegawheel','mobmegawheeltimer','mobandarbaharstraighttimer'");
define('MOBILE_GAMES',serialize(array('mobroulette36','mobroulette12','mobroulette12_timer','mobroulette36_timer','mobblackjack','mobbaccarat','mobamerican_roulette36_minitimer','mob_american_roulette36','mobtriplechance','mobtriplechancetimer','mobluckycardtimer','mobluckycard','mobslotreel5_china_t1','mobslotreel5_pharaoh_t1','mobslotreel5_pharaoh_t2','mobslotreel5_nordic_t1','mobslotreel5_nordic_t2','mobandarbahar','mobmegawheel','mobmegawheeltimer','mobandarbaharstraighttimer')));
