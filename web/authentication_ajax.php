<?php
	session_start();
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	include_once("include/DbConnect.php");
	include_once("include/DbPdoConnect.php");
	include_once("include/clsLotto.php");

	$objLotto =  new clsLotto($conn1);

	if ( !empty( $_REQUEST["authentication"] ) ) {
		$res = $objLotto->userAuthendication();
		echo $res;
	}
?>