<?php
	session_start();
	include("include/functions.php");
	/* if (isset($_SESSION[SESSION_USERNAME]) && !empty($_SESSION[SESSION_USERNAME]) ){
		header('Location: home.php');
	} */

	$username=addslashes(strtolower($_REQUEST['username']));
	$password=addslashes($_REQUEST['password']);
	if(strlen(trim($username))>0){
		if(strlen(trim($password))>0){
//			if(($_REQUEST['captcha'] == $_SESSION['lucky_vercode'])){
				if(existsRecord("SELECT USER_ID,USERNAME,PASSWORD FROM user WHERE USERNAME='{$username}'")==true){
					
					$row=recordSet("SELECT USER_ID,USERNAME,EMAIL_ID,PASSWORD,PARTNER_ID,USER_TYPE,PRINTER FROM user WHERE USERNAME='{$username}'");
					$userpassword=$row['PASSWORD'];
					
					if(strlen(trim($userpassword))>0){
						$qry_chkstatus=mysql_query("SELECT USER_ID,USERNAME,PASSWORD,USER_TYPE,PRINTER FROM user WHERE USERNAME='{$username}' and ACCOUNT_STATUS=1");
						if(mysql_num_rows($qry_chkstatus)>0){
							if(strcmp($userpassword,md5($password))==0){
								$_SESSION[SESSION_USERNAME] 	= $username;
								$_SESSION[SESSION_USERID]   	= $row['USER_ID'];
								$_SESSION[SESSION_USEREMAIL]   	= $row['EMAIL_ID'];
								//$_SESSION[SESSION_USERCONTACT] 	= $row['CONTACT'];
								$_SESSION[SESSION_PARTNERID]	= $row['PARTNER_ID'];
								$_SESSION[SESSION_USER_TYPE]	= $row['USER_TYPE'];
								$_SESSION[SESSION_PRINTER_OPTION]= $row['PRINTER'];
						   // 	$_SESSION['lucky_password']	= $userpassword;
								$getPartnerName=recordSet("SELECT PARTNER_ID,PARTNER_NAME FROM partner WHERE PARTNER_ID='{$row['PARTNER_ID']}'");
								$_SESSION[SESSION_PARTNERNAME] = $getPartnerName['PARTNER_NAME'];
								
								$keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".$username;
								$sessionID = substr(str_shuffle($keyString), 0, 13);
								$sessionUpdate = "update user set SESSION_ID= '{$sessionID}', LOGIN_STATUS=1, USER_LAST_LOGIN=NOW() where USER_ID='{$row['USER_ID']}'";
								$res = executeQuery($sessionUpdate);
								$_SESSION[SESSIONID] = $sessionID;
								echo "1";
							}else{
								echo "2";
							}
						}else{
							echo "2";								
						}
					}else{
						echo "2";
					}
				}else{
					echo "2";
				}
			/* }else{
				echo "4";//capcha
			   }  */
		}else{
			echo "5";
		}
	} else{
		echo "6";
	}
	exit;
?>