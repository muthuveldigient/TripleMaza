<?php
include("include/DbConnect.php");
include("include/functions.php");
include_once("include/clsLotto.php");
$objLotto =  new clsLotto($conn1);
$email = (!empty($_POST['fgt_email'])?$_POST['fgt_email']:'');
if (!empty( $email )){
	if(existsRecord("SELECT USER_ID,USERNAME,PASSWORD FROM user WHERE EMAIL_ID='{$email}'")==false){
		echo "Invalid email id";exit;
	}
}

/** Mail content start **/
if (!empty( $email )) {
	$string = '0123456789';
	$string_shuffled = str_shuffle($string);
	$fgt_password = substr($string_shuffled,0,7);
	$row=recordSet("SELECT USER_ID,USERNAME,PASSWORD,PARTNER_ID FROM user WHERE EMAIL_ID='{$email}'");
	
	$arrChangePassword["USER_ID"]     =$row['USER_ID'];
	$arrChangePassword["NEW_PASSWORD"]=md5($fgt_password);
	$forgotPassword=$objLotto->chkUserPassword($arrChangePassword);
	if($forgotPassword){
		$to = $email;
		$subject = "Forgot password for Lucy7";
			
		$message = '<h3 class="headings">Hi '.ucwords($row['USERNAME']).',</h3>   
					<h4 class="headings">Your temporary password is : '.$fgt_password.'</h4>';
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
		// More headers
			$headers .= 'From: <support@lucky7.com>' . "\r\n";
		//	$headers .= 'Cc: myboss@example.com' . "\r\n";
		mail($to,$subject,$message,$headers);
		echo 1;exit;
	}else{echo "password doesn't update please try agin";exit;}
}else{echo "please enter email id";exit;}
/** Mail content end **/
	
?>