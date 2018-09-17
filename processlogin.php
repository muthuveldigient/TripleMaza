<?php
	include_once("include/DbConnect.php");
	session_start();
	if(!empty($_POST)){
		$_SESSION[SESSION_USERNAME] 	= $_POST['userName'];
		$_SESSION[SESSION_USERID]   	= $_POST['userId'];
		$_SESSION[SESSION_USEREMAIL]   	= $_POST['emailId'];
		$_SESSION[SESSION_PARTNERID]	= $_POST['partnerId'];
		$_SESSION[SESSION_USER_TYPE]	= $_POST['userType'];
		$_SESSION[SESSION_PRINTER_OPTION]= $_POST['printer'];
		$_SESSION[SESSION_PARTNERNAME] 	= $_POST['partner_name'];
		$_SESSION[SESSIONID] 			= $_POST['sessionId'];
		$_SESSION[SESSION_EXE] 			= $_POST['exe'];
		echo '1';exit;
	}
			
	echo '0';exit;
?>