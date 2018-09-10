<?php
	session_start();
	include_once("include/DbConnect.php");
	include_once("include/DbPdoConnect.php");
	include_once("include/clsLotto.php");
	include_once("include/functions.php");
	$objLotto =  new clsLotto();

	$getLastTicketInfo=$objLotto->getLastOneTicketInfo($arrGameCodes[0]);
	$lPlayGroupID=(!empty($getLastTicketInfo[0]->PLAY_GROUP_ID)?$getLastTicketInfo[0]->PLAY_GROUP_ID:'');
	//$getDrawStatus=$objLotto->getDrawStatus($getLastTicketInfo[0]->DRAW_ID);
	//$drawStatus=$getDrawStatus[0]->DRAW_STATUS;
	
	$userPwd=$objLotto->getUserByID($_SESSION[SESSION_USERID]);
	
	$newBetData=""; $genAllBetData=""; $newBetIndex=""; $snoData=0;
	if($_REQUEST["action"]=="repeat") {
			if(!empty($lPlayGroupID) && $getLastTicketInfo[0]->IS_PENDING_STATUS==0) {
				$getPlayGroupData=$objLotto->getPlayGroupData($lPlayGroupID);	
				foreach($getPlayGroupData as $pIndex=>$playData) {
					$userBetType = $playData->BET_TYPE;
					$totelBet =  $playData->TOTAL_BET; 
					$betvalue =  $playData->BET_VALUE; 
					$fSno=1; $fTotalQty=0;
					
					$repeatBetData[$userBetType]=array(
															"betTypeID"=>(string)$userBetType,
															"betData"=>(string)$betvalue,
															"pGroupID"=>(string)$lPlayGroupID
													);
					}
				
				echo json_encode(array('msg'=>'valid','result'=>$repeatBetData));exit;
				//$object=arrayToObject($repeatBetData);
				//echo stripcslashes(json_encode(array('msg'=>'valid','result'=>$object),JSON_UNESCAPED_SLASHES));exit;
	
			} else {
				$res= array('msg'=>'There is no coupon');
				echo json_encode($res);exit;
			}
	}
?>