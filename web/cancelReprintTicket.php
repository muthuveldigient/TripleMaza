<?php
	session_start();
	include_once("include/DbConnect.php");
	include_once("include/DbPdoConnect.php");
	include_once("include/clsLotto.php");
	include_once("include/functions.php");
	$objLotto =  new clsLotto();

	$getLastTicketInfo=$objLotto->getLastOneTicketInfo($arrGameCodes[0]);
	$lPlayGroupID=$getLastTicketInfo[0]->PLAY_GROUP_ID;
	$getDrawStatus=$objLotto->getDrawStatus($getLastTicketInfo[0]->DRAW_ID);
	$drawStatus=$getDrawStatus[0]->DRAW_STATUS;
	
	$userPwd=$objLotto->getUserByID($_SESSION[SESSION_USERID]);
	
	$newBetData=""; $genAllBetData=""; $newBetIndex=""; $snoData=0;
	if($_REQUEST["action"]=="cancel") {
		if(md5($_REQUEST["userTranspassCancel"])==$userPwd[0]->PASSWORD) {
			//echo'<pre>';print_r($getLastTicketInfo);exit;
			if(!empty($lPlayGroupID) && $getLastTicketInfo[0]->IS_CANCEL==0 && $drawStatus==1 && $getLastTicketInfo[0]->IS_PENDING_STATUS==0) {

				$getTicketInfo=$objLotto->getTicketGroupInfo($lPlayGroupID);
				
				$userWinAmount="";
				foreach($getTicketInfo as $gIndex=>$gInfoData) {
					$userWinAmount=$userWinAmount+$gInfoData->TOTAL_BET;
				}
				
				$lottoUserID  =$getTicketInfo[0]->TERMINAL_ID;
				$lottoUserName=$objLotto->getUserByID($lottoUserID);
				$lottoUserBal =$objLotto->getUserBalanceByID($lottoUserID);
				$newuserpromobal     =$lottoUserBal[0]->USER_PROMO_BALANCE;
				$newuserpromoclosebal=$lottoUserBal[0]->USER_PROMO_BALANCE+$userWinAmount;
				$newusertotbal       =$lottoUserBal[0]->USER_TOT_BALANCE;
				$newusertotclosebal  =$lottoUserBal[0]->USER_TOT_BALANCE+$userWinAmount;
				
				$conn1->beginTransaction();
				$query_pt=$conn1->exec("UPDATE user_points SET USER_PROMO_BALANCE='".$newuserpromoclosebal."', USER_TOT_BALANCE='".$newusertotclosebal."' "."WHERE USER_ID=".$lottoUserID."");
					
				$transactionStatusId = "108";
				$transactionTypeId   = "13";
				$balanceTypeId       = "2";
				$query_pt2=$conn1->exec("INSERT INTO `master_transaction_history`(`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,".
						"`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,".
						"`PARTNER_ID`)VALUES('".$lottoUserID."','$balanceTypeId','$transactionStatusId','$transactionTypeId','$userWinAmount',".
						"NOW(),'".$getTicketInfo[0]->INTERNAL_REFERENCE_NO."','$newusertotbal','$newusertotclosebal','".$getTicketInfo[0]->PARTNER_ID."')");
				
				$rsResult  = $conn1->exec("UPDATE tc_maza_tickets SET IS_PAID=1,IS_CANCEL=1 WHERE PLAY_GROUP_ID='".$getTicketInfo[0]->PLAY_GROUP_ID."'");
				
				if($query_pt!='' && $query_pt2!='' && $rsResult!='') {
					$conn1->commit();
					$res= array('msg'=>'valid','balance'=>$newusertotclosebal.".00");
					echo json_encode($res);exit;
				} else {
					$conn1->rollBack();
					$res= array('msg'=>"Please try again later");
					echo json_encode($res);exit;
					//$statusString = "<span id='ticketcancel_".$getTicketInfo[0]->PLAY_GROUP_ID."'><a href='javascript:updateTicketCANCELStatus(".$getTicketInfo[0]->PLAY_GROUP_ID.")'>CANCEL</a></span>";
				}
				
			} else {
				$res= array('msg'=>'There is no coupon');
				echo json_encode($res);exit;
			}
		}else{
			$res= array('msg'=>'Invalid password');
			echo json_encode($res);exit;
		}
		
	}
	if($_REQUEST["action"]=="reprint") {
		if(md5($_REQUEST["userTranspass"])==$userPwd[0]->PASSWORD) {
			
			if(!empty($lPlayGroupID) && $getLastTicketInfo[0]->IS_CANCEL==0 && $drawStatus==1 && $getLastTicketInfo[0]->IS_PENDING_STATUS==0) {
				$getPlayGroupData=$objLotto->getPlayGroupData($lPlayGroupID);	
			
				foreach($getPlayGroupData as $pIndex=>$playData) {
					
					$game = constant('GAME_'.$playData->GAME_TYPE_ID);
					$userBetType = $playData->BET_TYPE;
					$drawNamePrint= substr($playData->DRAW_NUMBER,8,6);
					$drawDateTimePrint =date('d/m/Y H:i',strtotime($playData->DRAW_STARTTIME));
					$price = $playData->DRAW_PRICE;
					$totelBet =  $playData->TOTAL_BET; 
					$playGroupId = $playData->PLAY_GROUP_ID;
						
						$fSno=1; $fTotalQty=0;
						$betIndexString1=explode(",",$playData->BET_NUMBER);
						$betValueString1=explode(",",$playData->BET_AMOUNT_VALUE);
						foreach($betIndexString1 as $fBetIndex=>$fBetData) {
							if($fSno==1) {
								$fBetsValuesString=$fBetData.":".$betValueString1[$fBetIndex];
							} else {
								$fBetsValuesString=$fBetsValuesString."|".$fBetData.":".$betValueString1[$fBetIndex];
							}
							$fTotalQty=$fTotalQty+$betValueString1[$fBetIndex];
							$fSno++;
						}
					
					
						$printData['result'][$userBetType][$playData->GAME_TYPE_ID]=array(
																						"gameName"=>(string)$game,
																						"betTypeID"=>(string)$userBetType,
																						"intRefNo"=>(string)$playData->INTERNAL_REFERENCE_NO,
																						"drawDetails"=>(string)$drawNamePrint."-/".$drawDateTimePrint,
																						"drawPrice"=>(string)$price,
																						"totalQty"=>(string)(!empty($fTotalQty)?$fTotalQty:''),
																						"totalPrice"=>(string) $totelBet,
																						"buyTime"=>date('d/m/Y H:i:s'),
																						"betData"=>(string)$fBetsValuesString,
																						"pGroupID"=>(string)$playGroupId
																				);
				}
				
				//$objectToFlash=arrayToObject($printData);
				//echo '<pre>';print_r($objectToFlash);exit;
				echo stripcslashes(json_encode(array('msg'=>'valid','result'=>$printData),JSON_UNESCAPED_SLASHES));exit;
	
			} else {
				$res= array('msg'=>'There is no coupon');
				echo json_encode($res);exit;
			}
		}else{
			$res= array('msg'=>'Invalid password');
			echo json_encode($res);exit;
		}
	}
?>