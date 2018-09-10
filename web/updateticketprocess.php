<?php
	session_start();
	include_once("include/DbConnect.php");
	include_once("include/DbPdoConnect.php");
	include_once("include/clsLotto.php");
	$objLotto =  new clsLotto($conn1);
	//$objLotto->userAuthendication();
	$terminalID = $_SESSION[SESSION_USERID];
	$ticketAction=$_POST["ticketAction"];
	if($ticketAction=="updatetransaction") {
		$getPlayGroupID=$_REQUEST["playGroupID"];
		$updateTicketInfo["PLAY_GROUP_ID"]=$getPlayGroupID;
		$updateTicketInfo["TERMINAL_ID"]  =$terminalID;	
		$getGTicketDetails=$objLotto->getGroupTicketDetails($getPlayGroupID,$terminalID);
		$status=0;
		if(!empty($getGTicketDetails)) {
			/** here buy 3 ticket then single insert only do it in master traction history so need discuss someone **/
			/* $totalTicketAmt=0;
			foreach($getGTicketDetails as $tInfo=>$ticketData) {
				$totalTicketAmt=$totalTicketAmt+$ticketData->TOTAL_BET;	
				$updateTicketInfo["INTERNAL_REFERENCE_NO"]  =$ticketData->INTERNAL_REFERENCE_NO;
				$updateTicketInfo["DRAW_ID"]  =$ticketData->DRAW_ID;
			}
			$updateTicketInfo["TOTAL_BET"]  =$totalTicketAmt; */
			
			/** here buy 3 ticket then 3 insert in master traction history **/
			foreach($getGTicketDetails as $tInfo=>$ticketData) {
				$updateTicketInfo["TOTAL_BET"]  = $ticketData->TOTAL_BET;	
				$updateTicketInfo["INTERNAL_REFERENCE_NO"]  =$ticketData->INTERNAL_REFERENCE_NO;
				$updateTicketInfo["DRAW_ID"]  =$ticketData->DRAW_ID;
				$updateTicketTrans=$objLotto->updateTicketTransaction($updateTicketInfo);
				if($updateTicketTrans){
					$status=1;
				}
			}
			
		}
		if(!empty($updateTicketInfo)) {
			//$updateTicketTrans=$objLotto->updateTicketTransaction($updateTicketInfo);	
			if(!empty($status)) {
				$lottoUserBal =$objLotto->getUserBalanceByID($terminalID);
				echo "err1#".$lottoUserBal[0]->USER_TOT_BALANCE."#".$updateTicketInfo["INTERNAL_REFERENCE_NO"];die;	
			} else {
				echo "err0#failed1";	die;
			}
		} else {
			echo "err0#failed2";	die;
		}
	}
	die;
?>