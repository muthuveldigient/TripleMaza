<?php 
include("include/DbConnect.php");
include("include/functions.php");
//include_once("include/clsLotto.php");
//include("include/getMobileOTPInfo.php");


$msgInfo = 0;
if (isset($_POST['type']) && !empty($_POST['type']) ){
	//$OTPinfo =  new getMobileOTPInfo($conn1);
	$type	= (!empty($_POST['type'])?$_POST['type']:'');
	$mobile	= (!empty($_POST['mobile'])?$_POST['mobile']:'');
	$otpno	= (!empty($_POST['otpno'])?$_POST['otpno']:'');
	$username	= (!empty($_POST['username'])?$_POST['username']:'');
	$emailid	= (!empty($_POST['emailid'])?$_POST['emailid']:'');
	switch ($type) {
		case 1:
			$msgInfo=1;
			if (!empty( $mobile ) && strlen($mobile)==10 ){
				//$msgInfo = $OTPinfo->getOTP($mobile, $emailid, $username );/** @todo need to remove email id*/
			} 
		break;
		
		case 2:
			if (!empty( $mobile ) && strlen($mobile)==10 && !empty( $otpno ) ){
				//$msgInfo = $OTPinfo->verifyotp($mobile, $otpno);
			}
		break;
		case 3:
			if (!empty( $mobile ) && strlen($mobile)==10 ){
				if(existsRecord("SELECT USER_ID,USERNAME,PASSWORD FROM user WHERE CONTACT='{$mobile}'")==true){
					$msgInfo =1;
				}
			}
			break;
		case 4:
			if (!empty( $username ) && strlen($username)>=4 ){
				if(existsRecord("SELECT USER_ID,USERNAME,PASSWORD FROM user WHERE USERNAME='{$username}'")==true){
					$msgInfo =1;
				}
			}
			break;
		case 5:
			if (!empty( $emailid )){
				if(existsRecord("SELECT USER_ID,USERNAME,PASSWORD FROM user WHERE EMAIL_ID='{$emailid}'")==true){
					$msgInfo =1;
				}
			}
			break;
		case 6:
			if (!empty( $mobile )){
				if(existsRecord("SELECT USER_ID,USERNAME,PASSWORD FROM user WHERE CONTACT='{$mobile}'")==true){
					$msgInfo =1;
				}
			}
			break;
		default:
			$msgInfo=0;
		break;
	}
}
echo $msgInfo;exit;
?>