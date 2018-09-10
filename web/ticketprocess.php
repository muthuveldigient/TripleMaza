<?php
session_start();
include_once("include/DbConnect.php");
include_once("include/DbPdoConnect.php");
include_once("include/clsLotto.php");
include_once("include/functions.php");
$objLotto =  new clsLotto($conn1);

$session = $objLotto->userAuthendication();
if (!empty( $session)) {
	$res = array('msg'=>'expired');//session expired
	echo json_encode($res);exit;
}
/* $status = $objLotto->streamingStatus();
if (empty( $status ) ) {
	$res = array('msg'=>'STREAMING_DISABLED');//streaming disabled
	echo json_encode($res);exit;
} */

if(!empty($_POST)) {
	if(!empty($_POST["drawName"]) && !empty($_POST["drawID"])) {
	
		/** validate inputs and set value in bettype based */
		$result= checkInputs($_POST);
		$response =  array("userId"=>$_SESSION[SESSION_USERID],"serviceType"=>"wintcService","action"=>"BetRequest","gameName"=>GAME_NAME,"drawId"=>$_POST["drawID"],"sessionId"=>$_SESSION[SESSIONID],"bets"=>$result);
		$res= array('msg'=>'valid','response'=>$response);
		/** Here set insertion format for lotto_tickets table*/
		
	} else {
		$res = array('msg'=>'Invaild draw');//missing
	}
}else{
	$res = array('msg'=>'please select coupon');//post is empty
}
echo json_encode($res, JSON_FORCE_OBJECT);exit;
?>