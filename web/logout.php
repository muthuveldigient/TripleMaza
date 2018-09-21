<?php
session_start();
include("include/functions.php");
$sessionUpdate = "update user set LOGIN_STATUS=0 where USER_ID='{$_SESSION[SESSION_USERID]}'";
$res = executeQuery($sessionUpdate);
 $mode ='';
/*if($_SESSION[SESSION_MODE]==1){
	$mode = '?mode=1';
} */
unset($_SESSION[SESSION_USERID]);
session_destroy();

header("Location:".LOGIN_URL.$mode);exit();
?>