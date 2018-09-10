<?php

error_reporting(0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


include_once("../include/DbConnect.php");

$arrGameIDs = array(GAME_ID); 
$arrGameCodes = array(GAME_REF_NO); 

define('SD_COMM', 90);
define('AG_COMM', 80);
define('LIMIT_COUNT', 50);

define('BET_TYPE_1', 'Single');
define('BET_TYPE_2', 'Double');
define('BET_TYPE_3', 'Triple');

$sql  = "select * from tc_maza_sales_settings where SETTING_ID=1";
$result = mysql_query($sql) or die (mysql_error());
$num=mysql_num_rows($result);

while($row=mysql_fetch_assoc($result)){
	define("SINGLE_BET_QTY_LIMIT", $row['SINGLE']);
	define("DOUBLE_BET_QTY_LIMIT", $row['DOUBLE']);
	define("TRIPLE_BET_QTY_LIMIT", $row['TRIPLE']);
}

 ?>
