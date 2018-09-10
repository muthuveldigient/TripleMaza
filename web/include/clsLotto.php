<?php
//session_start();
class clsLotto {
	var $dbconn="";
	var $lotto_draw="";
	var $lotto_tickets="";
	var $lotto_user="";
	var $lotto_pdoObj="";
	var $partners_balance="";
	var $user_points;
	var $num_rows=0;

	function clsLotto($conn1) {
		//$this->dbconn       = $dbconn;
		$this->lotto_draw   = "tc_lotto_draw"; 
		$this->lotto_tickets= "tc_lotto_tickets";
		$this->lotto_user   = "user";
		$this->partners_balance="partners_balance";
		$this->master_transaction_history="master_transaction_history";
		$this->user_points  = "user_points";
		$this->lotto_pdoObj = $conn1;
		$this->num_rows     = "num_rows";
		$this->last_inst_id = "last_inst_id";
	}
	
	function userAuthendication() {
		$resultData='';
		if(!empty($_SESSION[SESSION_USERID]) && !empty($_SESSION[SESSIONID])){
			$browseSQL = "SELECT * FROM user WHERE USER_ID=".$_SESSION[SESSION_USERID]." and SESSION_ID='".$_SESSION[SESSIONID]."' AND LOGIN_STATUS=1 ";
			$resultData= $this->fetchArrayObject($browseSQL);
		}
		
		if(empty($resultData)) {
			session_destroy();
			return 1;	
		}
	}
	
	function streamingStatus() {
		$browseSQL = "SELECT STREAMING_STATUS FROM streaming_settings WHERE STREAMING_ID=1";
		$resultData= $this->fetchArrayObject($browseSQL);
		$result=0;
		if(!empty($resultData[0]->STREAMING_STATUS)) {
			$result=1;	
		}
		return $result;
	}
		
	function chkDrawExists($drawData) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_NAME='DRAW_001' ";
		$rsResult  = $this->executeQuery($browseSQL);	
		$this->num_rows = $this->getNumRows($rsResult);
		return $rsResult;
	}
	
	function createDraw($arrDraw) {
		return 1;
	}
	
	function getDrawIDForToday() {
		$browseSQL = "SELECT DRAW_ID,DRAW_NUMBER FROM ".$this->lotto_draw." WHERE DATE_FORMAT(DRAW_STARTTIME,'%Y-%m-%d')=CURDATE() ORDER BY DRAW_ID DESC";
		$resultData= $this->fetchArrayObject($browseSQL); 
		return $resultData;			
	}
	
	function viewDraw($searchArray, $limit,$offset) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_ID!='' ";
		if(!empty($searchArray["DRAW_NAME"]))
			$browseSQL .= "AND DRAW_NUMBER='".$searchArray["DRAW_NAME"]."' ";
		if(!empty($searchArray["DRAW_STATUS"]))
			$browseSQL .= "AND DRAW_STATUS=".$searchArray["DRAW_STATUS"]." ";			
				
		$browseSQL .= "ORDER BY DRAW_ID DESC LIMIT $offset,$limit";
		$rsResult  = $this->executeQuery($browseSQL);
		$this->num_rows = $this->getNumRows($rsResult);	
		$resultData     = $this->fetchArrayObject($browseSQL); 
		return $resultData;
	}
	
	function viewDrawTotal($searchArray) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_ID!='' ";
		if(!empty($searchArray["DRAW_NAME"]))
			$browseSQL .= "AND DRAW_NUMBER='".$searchArray["DRAW_NAME"]."' ";
		if(!empty($searchArray["DRAW_STATUS"]))
			$browseSQL .= "AND DRAW_STATUS=".$searchArray["DRAW_STATUS"]." ";
		
		$browseSQL .= "ORDER BY DRAW_ID DESC";						
		$rsResult  = $this->executeQuery($browseSQL);
		$this->num_rows = $this->getNumRows($rsResult);	
		return $this->num_rows;		
	}
	
	function getExtDrawResults($gameID, $nextDrawID=0) {
		if(!empty($nextDrawID)) {
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID < ".$nextDrawID." and DRAW_STARTTIME < NOW() ORDER BY DRAW_ID DESC LIMIT 7";	
		} else {
			//$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_STARTTIME < '".date('Y-m-d H:i:s')."' AND (DRAW_STATUS>=3) OR IS_ACTIVE=0  ORDER BY DRAW_ID DESC LIMIT 10 ";	
			//$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." and DRAW_STARTTIME < NOW() ORDER BY DRAW_ID DESC LIMIT 7 SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." and DRAW_STARTTIME < NOW() ORDER BY DRAW_ID DESC LIMIT 7 ";	
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." and DRAW_STATUS >=2 ORDER BY DRAW_ID DESC LIMIT 7 ";	
		}
		//echo $browseSQL;exit;
		$rsResult  = $this->executeQuery($browseSQL);		
		$this->num_rows = $this->getNumRows($rsResult);		
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;
	}
	
	function chkDrawStatus($drawID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_ID=".$drawID." AND DRAW_STATUS=1 ";
		$rsResult  = $this->executeQuery($browseSQL);
		$this->num_rows = $this->getNumRows($rsResult);		
		$resultData= $this->fetchArrayObject($browseSQL);	
		return $resultData;
	}
	
	function chkDrawTime($drawID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_ID=".$drawID." AND DRAW_STATUS=1 AND DRAW_STARTTIME > NOW()";
		$rsResult  = $this->executeQuery($browseSQL);
		$this->num_rows = $this->getNumRows($rsResult);		
		return $this->num_rows;
	}

	function chkLottoUserAgentBal($lottoUserID) {
		$getLottoUserPartner = "SELECT USER_ID,PARTNER_ID FROM ".$this->lotto_user." WHERE USER_ID=".$lottoUserID."";
		$lottoUserPartner    = $this->fetchArrayObject($getLottoUserPartner);
		$lottoUserPartnerID  = $lottoUserPartner[0]->PARTNER_ID;   
		
		$getPartnerBalance   = "SELECT * FROM ".$this->partners_balance." WHERE PARTNER_ID=".$lottoUserPartnerID."";
		$lottoUserPartnerBal = $this->fetchArrayObject($getPartnerBalance);
		return $lottoUserPartnerBal;	
	}
	
	function getUserByID($lottoUserID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_user." WHERE USER_ID=".$lottoUserID." ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;			
	}
	
	function getUserBalanceByID($lottoUserID) {
		$browseSQL = "SELECT * FROM ".$this->user_points." WHERE USER_ID=".$lottoUserID." ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;		
	}
	
	function addBetValueInRiskManagement($betValuesArray) {
		$betValueArr=json_decode($betValuesArray["BET_VALUE"]);	
		if(!empty($betValueArr)) {
			foreach($betValueArr as $bvIndex=>$betVData) {
				$risk_TerID =$betValuesArray["TERMINAL_ID"];				
				$risk_DrawID=$betValuesArray["DRAW_ID"];
				$risk_DPrice=$betValuesArray["DRAW_PRICE"];
				$risk_BType =$betValuesArray["BET_TYPE"];
				if($risk_BType==3)
					$risk_BetNo =str_pad($bvIndex,3,"0",STR_PAD_LEFT);
				else if($risk_BType==2)
					$risk_BetNo =str_pad($bvIndex,2,"0",STR_PAD_LEFT);
				else
					$risk_BetNo =$bvIndex;					
				
				$risk_BetAmt=$betVData*$risk_DPrice;	
				$chkBetNoExistis="SELECT RISK_LOTTO_ID FROM tc_risk_lottotest WHERE ".
								 "DRAW_ID=".$risk_DrawID." AND ".
								 "TERMINAL_ID=".$risk_TerID." AND ".
								 "NUMBER='".$risk_BetNo."' ";	
				$rsBetNoExists = mysql_query($chkBetNoExistis);
				$getBetNoExists=mysql_num_rows($rsBetNoExists);
				if(!empty($getBetNoExists)) { //update in the risk management table
					$rbrowseSQL = "UPDATE tc_risk_lottotest SET ".
								  "TOTAL_BET=TOTAL_BET+".$risk_BetAmt." ".
								  "WHERE DRAW_ID=".$risk_DrawID." AND ".
								  "TERMINAL_ID=".$risk_TerID." AND ".
								  "NUMBER='".$risk_BetNo."' ";  
					mysql_query($rbrowseSQL);
				} else { //insert in the risk management table
					$rbrowseSQL = "INSERT INTO tc_risk_lottotest(`RISK_LOTTO_ID`,`DRAW_ID`,`TERMINAL_ID`,`NUMBER`,`TOTAL_BET`,`BETTYPE`,".
								  "`CREATED_ON`) VALUE('',".$risk_DrawID.",".$risk_TerID.",'".$risk_BetNo."',".$risk_BetAmt.",".
								  "".$risk_BType.",NOW())";
					mysql_query($rbrowseSQL);								  
				}
			}
		}
	}
	
	function chkTicketRefNo($ireference) {
		$browseSQL = "SELECT * FROM ".$this->lotto_tickets." WHERE INTERNAL_REFERENCE_NO='".$ireference."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;		
	}
	
	function genRandomRefNo($outputLen) {
		$outputString="";
		$inputString="0123456789";	
		for($i=0;$i<$outputLen;$i++) {
			$rnum = rand(0,9);
			$outputString=$outputString.substr($inputString,$rnum,1);
		}
		return $outputString;
	}
	
	function createNEWTickets($arrTicket) {
		$browseSQL = "INSERT INTO ".$this->lotto_tickets."(`TICKET_ID`,`DRAW_ID`,`BET_TYPE`,`INTERNAL_REFERENCE_NO`,`PARTNER_ID`,`TERMINAL_ID`,`BET_VALUE`,".
					 "`BET_NUMBER`,`BET_AMOUNT_VALUE`,`DRAW_PRICE`,`CREATED_DATE`,".
					 "`UPDATED_DATE`,`STATUS`,`WIN_NUMBER`,`TOTAL_BET`,`TOTAL_WIN`,`PLAY_GROUP_ID`,`IS_PENDING_STATUS`) VALUES('',".$arrTicket["DRAW_ID"].",'".$arrTicket["BET_TYPE"]."','".$arrTicket["INTERNAL_REFERENCE_NO"]."',".
					 "".$arrTicket["PARTNER_ID"].",'".$arrTicket["TERMINAL_ID"]."','".$arrTicket["BET_VALUE"]."','".$arrTicket["BET_NUMBER"]."','".$arrTicket["BET_AMOUNT_VALUE"]."',".
					 "'".$arrTicket["DRAW_PRICE"]."','".$arrTicket["CREATED_DATE"]."','".$arrTicket["UPDATED_DATE"]."',".
					 "".$arrTicket["STATUS"].",'','".$arrTicket["TOTAL_BET"]."','','".$arrTicket["PLAY_GROUP_ID"]."',1)";				 
		$rsResult  = $this->executeQuery($browseSQL);	
		return $rsResult;
	}
	
	function getGroupTicketDetails($playGroupID,$terminalID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_tickets." WHERE PLAY_GROUP_ID='".$playGroupID."' AND TERMINAL_ID='".$terminalID."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;			
	}
	
	function updateTicketTransaction($arrUpdateTicket) {
		$lottoUserID  	= $arrUpdateTicket["TERMINAL_ID"];
		$balanceamount 	= $arrUpdateTicket["TOTAL_BET"];
		$drawId 		= $arrUpdateTicket["DRAW_ID"];
		$playGroupId	= $arrUpdateTicket["PLAY_GROUP_ID"];
		$ireference   	= $arrUpdateTicket["INTERNAL_REFERENCE_NO"];

		//$lottoUserName=$this->getUserByID($lottoUserID);
		//$lottoUserBal =$this->getUserBalanceByID($lottoUserID);
		$transactionStatusId = "101";
		$transactionTypeId   = "11";
		
		
		$partnerID= $_SESSION[SESSION_PARTNERID];
		$userID = $lottoUserID;
		
		$browseSQL= "SELECT * FROM ".$this->user_points." WHERE USER_ID='".$userID."'";
		$rsResult = $this->fetchArrayObject($browseSQL);	
		$pedningDebit=0; $promostatus=0; $depositstatus=0; $winstatus=0;			
			
			if($rsResult[0]->USER_PROMO_BALANCE >= $balanceamount) { // DEBIT ONLY FROM PROMO
				$userTotBalance=$rsResult[0]->USER_TOT_BALANCE;
				$userCloBalance=$rsResult[0]->USER_TOT_BALANCE-($balanceamount);
				$browseSQL1="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
						   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,`CURRENT_TOT_BALANCE`,`CLOSING_TOT_BALANCE`,".
						   "`PARTNER_ID`) ".
						   "VALUES('','".$userID."',2,101,11,".$balanceamount.",NOW(),'".$ireference."',".
						   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";					   			
				$rsResult1 =$this->lotto_pdoObj->exec($browseSQL1);
				$masTransID=$this->lotto_pdoObj->lastInsertId();
				$userNewPromoBal=$rsResult[0]->USER_PROMO_BALANCE-$balanceamount;
				$userNewDepotBal=$rsResult[0]->USER_DEPOSIT_BALANCE;
				$userNewWinBal  =$rsResult[0]->USER_WIN_BALANCE;
				$userNewTotalBal=$userNewPromoBal+$userNewDepotBal+$userNewWinBal;				
				if($rsResult1!='') {
					$promostatus=1; $depositstatus=1; $winstatus=1;
				}
			} else { // DEBIT FROM PROMO AND DEPOSIT
				if($rsResult[0]->USER_PROMO_BALANCE>0) {
					$pedningDebit=$balanceamount-$rsResult[0]->USER_PROMO_BALANCE;
					$userTotBalance=$rsResult[0]->USER_TOT_BALANCE;
					$userCloBalance=$rsResult[0]->USER_TOT_BALANCE-$rsResult[0]->USER_PROMO_BALANCE;				
					$browseSQL2="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
							   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,`CURRENT_TOT_BALANCE`,".
							   "`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
							   "VALUES('','".$userID."',2,101,11,".$rsResult[0]->USER_PROMO_BALANCE.",NOW(),'".$ireference."',".
							   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";	
					$rsResult2 =$this->lotto_pdoObj->exec($browseSQL2);
					$masTransID=$this->lotto_pdoObj->lastInsertId();
					if($rsResult2!='') {
						$promostatus=1;
					}	
					$userNewPromoBal=0;
				} else {
					$userCloBalance=$rsResult[0]->USER_TOT_BALANCE;				
					$pedningDebit=$balanceamount;
					$promostatus=1; $userNewPromoBal=0;
				}							
				if($pedningDebit>0 && $rsResult[0]->USER_DEPOSIT_BALANCE>=$pedningDebit) {					
					$userTotBalance=$userCloBalance;
					$userCloBalance=$userTotBalance-$pedningDebit;				
					$browseSQL3="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
							   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,`CURRENT_TOT_BALANCE`,".
							   "`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
							   "VALUES('','".$userID."',1,101,11,".$pedningDebit.",NOW(),'".$ireference."',".
							   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";	
					$rsResult3 =$this->lotto_pdoObj->exec($browseSQL3);
					$masTransID=$this->lotto_pdoObj->lastInsertId();
					$userNewDepotBal=$rsResult[0]->USER_DEPOSIT_BALANCE-$pedningDebit;
					$userNewWinBal  =$rsResult[0]->USER_WIN_BALANCE;
					$userNewTotalBal=$userNewPromoBal+$userNewDepotBal+$userNewWinBal;					
					if($rsResult!=='') {
						$depositstatus=1; $winstatus=1; $pedningDebit=0;
					}															
				}  else { // DEBIT FROM PROMO AND DEPOSIT AND WIN
					if($rsResult[0]->USER_DEPOSIT_BALANCE>0) {
						$pedningDebit=$pedningDebit-$rsResult[0]->USER_DEPOSIT_BALANCE;
						$userTotBalance=$userCloBalance;
						$userCloBalance=$userTotBalance-$rsResult[0]->USER_DEPOSIT_BALANCE;				
						$browseSQL4="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
								   "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,".
								   "`CURRENT_TOT_BALANCE`,`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
								   "VALUES('','".$userID."',1,101,11,".$rsResult[0]->USER_DEPOSIT_BALANCE.",NOW(),'".$ireference."',".
								   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";	
						$rsResult4 =$this->lotto_pdoObj->exec($browseSQL4);
						$masTransID=$this->lotto_pdoObj->lastInsertId();
						if($rsResult4!='') {
							$depositstatus=1;
						}						
						$userNewDepotBal=0;	
					} else {
						$userCloBalance=$userCloBalance;						
						$depositstatus=1; $userNewDepotBal=0;	
					}		
					if($pedningDebit>0 && $rsResult[0]->USER_WIN_BALANCE>=$pedningDebit) {						
						$userTotBalance=$userCloBalance;
						$userCloBalance=$userTotBalance-$pedningDebit;	
			
						$browseSQL5="INSERT INTO ".$this->master_transaction_history."(`MASTER_TRANSACTTION_ID`,`USER_ID`,`BALANCE_TYPE_ID`,`TRANSACTION_STATUS_ID`,".
							       "`TRANSACTION_TYPE_ID`,`TRANSACTION_AMOUNT`,`TRANSACTION_DATE`,`INTERNAL_REFERENCE_NO`,".
								   "`CURRENT_TOT_BALANCE`,`CLOSING_TOT_BALANCE`,`PARTNER_ID`) ".
								   "VALUES('','".$userID."',3,101,11,".$pedningDebit.",NOW(),'".$ireference."',".
								   "".$userTotBalance.",".$userCloBalance.",".$partnerID.")";	
						$rsResult5 =$this->lotto_pdoObj->exec($browseSQL5);	
						$masTransID=$this->lotto_pdoObj->lastInsertId();
						$userNewWinBal  =$rsResult[0]->USER_WIN_BALANCE-$pedningDebit;
						$userNewTotalBal=$userNewPromoBal+$userNewDepotBal+$userNewWinBal;						
						if($rsResult5!='') {
							$winstatus=1; $pedningDebit=0;
						}												
					} else {
						$pedningDebit=1;
					}
				}
			}
			$browseSQL6 = "UPDATE ".$this->user_points." SET USER_PROMO_BALANCE=".$userNewPromoBal.",".
						  "USER_DEPOSIT_BALANCE=".$userNewDepotBal.",".
						  "USER_WIN_BALANCE=".$userNewWinBal.",".
						  "USER_TOT_BALANCE=".$userNewTotalBal." WHERE USER_ID=".$userID;	
			$rsResult6  = $this->lotto_pdoObj->exec($browseSQL6);	
		
			
	//	$this->lotto_pdoObj->beginTransaction();
		$query_pt3=$this->lotto_pdoObj->exec("UPDATE ".$this->lotto_draw." SET DRAW_TOTALBET=DRAW_TOTALBET+'".$balanceamount."' ".
				"WHERE DRAW_ID=".$drawId."");
		//$query_pt =	$this->lotto_pdoObj->exec("UPDATE user_points SET USER_PROMO_BALANCE=USER_PROMO_BALANCE-'".$balanceamount."', USER_TOT_BALANCE=USER_TOT_BALANCE-'".$balanceamount."' WHERE USER_ID=".$lottoUserID."");

		$query_pt4=$this->lotto_pdoObj->exec("UPDATE $this->lotto_tickets SET IS_PENDING_STATUS = 0 WHERE TERMINAL_ID='".$lottoUserID."' AND PLAY_GROUP_ID='".$playGroupId."'");
		
		if($pedningDebit=="0" && $promostatus==1 && $depositstatus==1 && $winstatus==1 && $rsResult6==1 && $query_pt3!='' && $query_pt4!='' ) {
			//$this->lotto_pdoObj->commit();
			return 1;
		} else {
		//	$this->lotto_pdoObj->rollBack();
			return 0;
		}
	}
	
	function createTicket($arrTicket, $lottoUserID, $ticketBetAmt) {	
		$balanceamount=$ticketBetAmt;
		//$ireference   =rand(1000000000,9999999999);
		$ireference   =$arrTicket["INTERNAL_REFERENCE_NO"];
		$lottoUserName=$this->getUserByID($lottoUserID);
		$lottoUserBal =$this->getUserBalanceByID($lottoUserID);
		$newuserpromobal     =$lottoUserBal[0]->USER_PROMO_BALANCE;
		$newuserpromoclosebal=$lottoUserBal[0]->USER_PROMO_BALANCE-$balanceamount;
		$newusertotbal       =$lottoUserBal[0]->USER_TOT_BALANCE;
		$newusertotclosebal  =$lottoUserBal[0]->USER_TOT_BALANCE-$balanceamount;

		$this->lotto_pdoObj->beginTransaction();
		$query_pt=$this->lotto_pdoObj->exec("UPDATE ".$this->user_points." SET USER_PROMO_BALANCE='".$newuserpromoclosebal."', USER_TOT_BALANCE='".$newusertotclosebal."' ".
								  "WHERE USER_ID=".$lottoUserID."");

		$transactionStatusId = "101";
		$transactionTypeId   = "11";
		$balanceTypeId       = "2";		
								
		$query_pt2=$this->lotto_pdoObj->exec("INSERT INTO `master_transaction_history`(`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,".
				"`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,".
				"`PARTNER_ID`)VALUES('".$lottoUserID."','$balanceTypeId','$transactionStatusId','$transactionTypeId','$balanceamount',".
				"NOW(),'$ireference','$newusertotbal','$newusertotclosebal','".$_SESSION[SESSION_PARTNERID]."')");														
				
		$browseSQL = "INSERT INTO ".$this->lotto_tickets."(`TICKET_ID`,`DRAW_ID`,`BET_TYPE`,`INTERNAL_REFERENCE_NO`,`PARTNER_ID`,`TERMINAL_ID`,`BET_VALUE`,".
					 "`BET_NUMBER`,`BET_AMOUNT_VALUE`,`DRAW_PRICE`,`CREATED_DATE`,".
					 "`UPDATED_DATE`,`STATUS`,`WIN_NUMBER`,`TOTAL_BET`,`TOTAL_WIN`,`PLAY_GROUP_ID`) VALUES('',".$arrTicket["DRAW_ID"].",'".$arrTicket["BET_TYPE"]."','".$arrTicket["INTERNAL_REFERENCE_NO"]."',".
					 "".$arrTicket["PARTNER_ID"].",'".$arrTicket["TERMINAL_ID"]."','".$arrTicket["BET_VALUE"]."','".$arrTicket["BET_NUMBER"]."','".$arrTicket["BET_AMOUNT_VALUE"]."',".
					 "'".$arrTicket["DRAW_PRICE"]."','".$arrTicket["CREATED_DATE"]."','".$arrTicket["UPDATED_DATE"]."',".
					 "".$arrTicket["STATUS"].",'','".$arrTicket["TOTAL_BET"]."','','".$arrTicket["PLAY_GROUP_ID"]."')";				 
		$rsResult  = $this->lotto_pdoObj->exec($browseSQL);	

		$query_pt3=$this->lotto_pdoObj->exec("UPDATE ".$this->lotto_draw." SET DRAW_TOTALBET=DRAW_TOTALBET+'".$arrTicket["TOTAL_BET"]."' ".
								  "WHERE DRAW_ID=".$arrTicket["DRAW_ID"]."");			
		
		if($query_pt!='' && $query_pt2!='' && $rsResult!='' && $query_pt3!='') {
			 $this->lotto_pdoObj->commit();
			 return 1;
		} else {
			$this->lotto_pdoObj->rollBack();
			return 0;	
		}
	}
	
	function viewTickets($searchArray, $limit=50,$offset=0) {
		$browseSQL = "SELECT d.DRAW_STATUS,d.DRAW_WINNUMBER,t.TICKET_ID,d.DRAW_NUMBER,d.DRAW_STARTTIME,t.BET_TYPE,t.BET_VALUE,t.GAME_TYPE_ID,t.INTERNAL_REFERENCE_NO,t.PARTNER_ID,t.BET_NUMBER,t.BET_AMOUNT_VALUE,t.CREATED_DATE,t.UPDATED_DATE,t.STATUS,".
					 "t.WIN_NUMBER,t.TOTAL_BET,t.TOTAL_WIN FROM ".$this->lotto_tickets." t ".
					 "LEFT JOIN ".$this->lotto_draw." d ON t.DRAW_ID=d.DRAW_ID WHERE TICKET_ID!=''";
		if(!empty($searchArray["DRAW_ID"]))
			$browseSQL .= "AND t.DRAW_ID=".$searchArray["DRAW_ID"]." ";
		if(!empty($searchArray["TICKET_NUMBER"]))
			$browseSQL .= "AND t.INTERNAL_REFERENCE_NO='".$searchArray["TICKET_NUMBER"]."' ";
		if(!empty($searchArray["GAME_ID"]))
			$browseSQL .= "AND d.DRAW_GAME_ID='".$searchArray["GAME_ID"]."' ";
		if(!empty($searchArray["TERMINAL_ID"]))
			$browseSQL .= "AND t.TERMINAL_ID='".$searchArray["TERMINAL_ID"]."' ";
		if (!empty($searchArray['start']) && !empty($searchArray['end'])){
			$startDate =date('Y-m-d',strtotime($searchArray['start']));
			$endDate =date('Y-m-d',strtotime($searchArray['end']));
			$browseSQL .=" AND  DATE_FORMAT(t.CREATED_DATE,'%Y-%m-%d') BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY t.TICKET_ID DESC";
		}else{
			$browseSQL .= "ORDER BY t.TICKET_ID DESC LIMIT $offset,$limit";
		}
		//echo $browseSQL;exit;
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function viewTicketsTotal($searchArray) {
		$browseSQL = "SELECT t.TICKET_ID,d.DRAW_NUMBER,t.INTERNAL_REFERENCE_NO,t.PARTNER_ID,t.BET_VALUE,t.CREATED_DATE,t.UPDATED_DATE,t.STATUS,".
					 "t.WIN_NUMBER,SUM(t.TOTAL_BET) AS TOTAL_BET,SUM(t.TOTAL_WIN) AS TOTAL_WIN FROM ".$this->lotto_tickets." t ".
					 "LEFT JOIN ".$this->lotto_draw." d ON t.DRAW_ID=d.DRAW_ID WHERE TICKET_ID!=''";
		if(!empty($searchArray["DRAW_ID"]))
			$browseSQL .= "AND t.DRAW_ID=".$searchArray["DRAW_ID"]." ";
		if(!empty($searchArray["TICKET_NUMBER"]))
			$browseSQL .= "AND t.INTERNAL_REFERENCE_NO='".$searchArray["TICKET_NUMBER"]."' ";
								 
		$browseSQL .= "ORDER BY t.TICKET_ID DESC";						
		
		$rsResult  = $this->executeQuery($browseSQL);
		$this->num_rows = $this->getNumRows($rsResult);	
		return $this->num_rows;
	}
	
	function getUpcomingDrawData($drawID,$drawType,$gameID) {
		if($drawType=="NEXTDRAW" && $drawID!=''){
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID!='' AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,2";
			//$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID>".$drawID." AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,2";
		}elseif($drawType=="FUTUREDRAW" && $drawID!=''){
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID!='' AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,2";
			//$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID>=".$drawID." AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,2";			
		}else{
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID!='' AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,2";
		}
		//echo $browseSQL;exit;
			$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;			
	}
	
	function getPreviousDrawData($drawID,$gameID) {
		if( $drawID!=''){ //previous draw
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID < ".$drawID." AND IS_ACTIVE=1 ORDER BY DRAW_STARTTIME DESC LIMIT 0,1";
		}else{
			$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID!='' AND IS_ACTIVE=1 AND DRAW_STARTTIME < NOW() ORDER BY DRAW_STARTTIME DESC LIMIT 0,1";
		}
//		echo '<pre>';print_r($browseSQL);exit;
		$rsResult  = $this->fetchArrayObject($browseSQL);
		return $rsResult;
	}
	
	function updateDrawStatus($drawDetails) {
		$browseSQL = "UPDATE ".$this->lotto_draw." SET DRAW_STATUS=".$drawDetails["DRAW_STATUS"]." WHERE DRAW_ID=".$drawDetails["DRAW_ID"]." ";	
		$rsResult  = $this->executeQuery($browseSQL);	
		return $rsResult;
	}
	
	function updateTicketStatus($ticketDetail) {
		$browseSQL = "UPDATE ".$this->lotto_tickets." SET STATUS=".$ticketDetail["STATUS"]." WHERE TICKET_ID=".$ticketDetail["TICKET_ID"]." ";	
		$rsResult  = $this->executeQuery($browseSQL);	
		return $rsResult;		
	}
	
	function getDrawNames() {
		$browseSQL = "SELECT DRAW_ID,DRAW_NUMBER FROM ".$this->lotto_draw." WHERE DRAW_ID!='' ORDER BY DRAW_ID DESC";				
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;
	}
	
	function getFutureDrawsList($gameID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID!='' AND DRAW_STARTTIME > NOW() AND DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE() AND DRAW_STATUS=1 ORDER BY DRAW_ID ASC";
		$rsResult  = $this->executeQuery($browseSQL);		
		$this->num_rows = $this->getNumRows($rsResult);		
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;			
	}
	
	function getNextDayDrawsList($gameID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID!='' AND DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE() + INTERVAL 1 DAY AND DRAW_STATUS=1 ORDER BY DRAW_ID ASC";
		$rsResult  = $this->executeQuery($browseSQL);
		$this->num_rows = $this->getNumRows($rsResult);
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;
	}
	
	function chkIsTicketValid($refNo) {
		$browseSQL = "SELECT * FROM ".$this->lotto_tickets." WHERE INTERNAL_REFERENCE_NO='".$refNo."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;			
	}
	
	function getTerminalBalance($terminalID) {
		$browseSQL = "SELECT * FROM ".$this->user_points." WHERE USER_ID='".$terminalID."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;			
	}
	
	function chkTerminalBalance($ticketAmount) {
		$browseSQL = "SELECT * FROM ".$this->user_points." WHERE USER_ID='".$ticketAmount["TERMINAL_ID"]."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;			
	}
	
	function getTicketInfo($ticketID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_tickets." WHERE TICKET_ID='".$ticketID."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;
	}

	function getTicketGroupInfo($ticketGroupID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_tickets." WHERE PLAY_GROUP_ID='".$ticketGroupID."' ";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;
	}
	
	function getTicketInternalRefInfo($ref) {
		$browseSQL = "SELECT lotto_tickets.*,d.DRAW_ID,d.DRAW_NUMBER,d.DRAW_STARTTIME,d.DRAW_STATUS FROM  ".$this->lotto_tickets." as lotto_tickets LEFT JOIN ".$this->lotto_draw." d ON d.DRAW_ID=lotto_tickets.DRAW_ID ".
				"WHERE lotto_tickets.INTERNAL_REFERENCE_NO='".$ref."' AND ".
				"lotto_tickets.TERMINAL_ID='".$_SESSION[SESSION_USERID]."'";
		$resultData= $this->fetchArrayObject($browseSQL);
		return $resultData;
	}
	function getDrawNumberByID($drawID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_ID=".$drawID."";				
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;
	}	
	
	function getNextDrawInfo($cDrawID,$gameID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID>".$cDrawID." AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() LIMIT 0,1";
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function getLastTicketInfo() {
		$browseSQL = "SELECT lotto_tickets.*,d.DRAW_ID,d.DRAW_NUMBER,d.DRAW_PRICE,d.DRAW_STARTTIME FROM ".$this->lotto_tickets." as lotto_tickets LEFT JOIN ".$this->lotto_draw." d ON d.DRAW_ID=lotto_tickets.DRAW_ID ".
					 "WHERE d.DRAW_STATUS=1 AND d.IS_ACTIVE=1 AND lotto_tickets.IS_CANCEL!=1 AND ".
					 "lotto_tickets.TERMINAL_ID='".$_SESSION[SESSION_USERID]."' ORDER BY lotto_tickets.TICKET_ID DESC LIMIT 1";
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;
	}
	
	function getDrawResultsToday($gameID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE() AND (DRAW_STATUS>=3 OR IS_ACTIVE=0) ".
					 "AND DRAW_GAME_ID=".$gameID." ORDER BY DRAW_ID DESC";
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function getDrawResultsLastOneWeek($gameID) {
		//$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')>= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND (DRAW_STATUS>=3 OR IS_ACTIVE=0) AND DRAW_GAME_ID=".$gameID." ORDER BY DRAW_ID DESC";
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_STARTTIME BETWEEN DATE_SUB(NOW(),INTERVAL 1 WEEK) AND NOW()  AND DRAW_GAME_ID=".$gameID." ORDER BY DRAW_ID DESC";
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function getDrawResults($gameID, $start, $end) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DRAW_GAME_ID=".$gameID;
		if (!empty($start) && !empty($end)){
			$startDate = date('Y-m-d',strtotime($start));
			$endDate = date('Y-m-d',strtotime($end));
			$browseSQL .=" AND  DATE_FORMAT(DRAW_STARTTIME,'%Y-%m-%d') BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY DRAW_ID DESC";
		}else{
			$browseSQL .=" AND DRAW_STARTTIME <= NOW() ORDER BY DRAW_ID DESC limit 50";
		}
		$rsResult  = $this->fetchArrayObject($browseSQL);
		return $rsResult;
	}
	
	function getDrawResultsYesterday($gameID) {
		$browseSQL = "SELECT * FROM ".$this->lotto_draw." WHERE DATE_FORMAT(`DRAW_STARTTIME`,'%Y-%m-%d')=SUBDATE(CURDATE(),1) AND (DRAW_STATUS>=3 OR IS_ACTIVE=0) ".
					 "AND DRAW_GAME_ID=".$gameID." ORDER BY DRAW_ID DESC";
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function getLastOneTicketInfo($gameCode) {
		$browseSQL = "SELECT TICKET_ID,DRAW_ID,PLAY_GROUP_ID,IS_CANCEL,IS_PENDING_STATUS FROM $this->lotto_tickets ".
					 "WHERE TERMINAL_ID='".$_SESSION[SESSION_USERID]."' AND SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3)='".$gameCode."' ".
					 "ORDER BY TICKET_ID DESC LIMIT 1";	
// 		echo $browseSQL;exit;
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function getDrawStatus($drawID) {
		$browseSQL = "SELECT DRAW_ID,DRAW_STATUS FROM ".$this->lotto_draw." WHERE DRAW_ID='".$drawID."' LIMIT 1";		
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}
	
	function getPlayGroupData($lPlayGroupID) {
		$browseSQL = "SELECT lotto_tickets.*,d.DRAW_ID,d.DRAW_NUMBER,d.DRAW_STARTTIME FROM  ".$this->lotto_tickets." as lotto_tickets LEFT JOIN ".$this->lotto_draw." d ON d.DRAW_ID=lotto_tickets.DRAW_ID ".
					 "WHERE lotto_tickets.PLAY_GROUP_ID='".$lPlayGroupID."' AND ".
					 "lotto_tickets.TERMINAL_ID='".$_SESSION[SESSION_USERID]."'";
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}

	function chkUserOldPassword($arrChangePassword) {
		$browseSQL = "SELECT * FROM user WHERE USER_ID=".$arrChangePassword["USER_ID"]." AND PASSWORD='".$arrChangePassword["PASSWORD"]."' ";	
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		return $rsResult;		
	}

	function chkUserPassword($arrChangePassword) {
		$browseSQL = "UPDATE ".$this->lotto_user." SET PASSWORD='".$arrChangePassword["NEW_PASSWORD"]."' WHERE USER_ID=".$arrChangePassword["USER_ID"]." ";	
		$rsResult  = $this->executeQuery($browseSQL);	
		return $rsResult;	
	}
	function insertUser($arr) {
		
		$this->lotto_pdoObj->beginTransaction();
		
		$browseSQL = "INSERT INTO ".$this->lotto_user."(`USERNAME`,`PASSWORD`,`EMAIL_ID`,`CONTACT`,ACCOUNT_STATUS,PARTNER_ID,REGISTRATION_TIMESTAMP) VALUES('".$arr['reg_username']."','".md5($arr['reg_password'])."', '".$arr['reg_email']."','".$arr['reg_mobile']."',1,6,now())";
		$rsResult  = $this->lotto_pdoObj->exec($browseSQL);
		$user_id=$this->lotto_pdoObj->lastInsertId();
		
		$sql_scinsert="insert into ".$this->user_points."(COIN_TYPE_ID,USER_ID,VALUE,USER_PROMO_BALANCE,USER_TOT_BALANCE)values('3','".$user_id."','0','0','0')";
		$query_pts=$this->lotto_pdoObj->exec($sql_scinsert);
		
		 if( $user_id!='' && $query_pts!='') {
		 	$this->lotto_pdoObj->commit();
			return 1;
		} else {
			$this->lotto_pdoObj->rollBack();
			return 0;
		}  
	}

	/* public function InPointsTransTypeId(){
			$query  = $this->fetchArrayObject("select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Deposit' OR TRANSACTION_TYPE_NAME = 'Promo' OR TRANSACTION_TYPE_NAME = 'Adjustment_Promo' OR TRANSACTION_TYPE_NAME = 'Adjustment_Deposit' OR TRANSACTION_TYPE_NAME = 'Adjustment_Win'");  
			$totalCount = count($rsResult)-1;
		
			foreach ($rsResult as $key => $value) {
				if($key == $totalCount)
					$InPointsTypeIDs .= $value->TRANSACTION_TYPE_ID;
				else
					$InPointsTypeIDs .= $value->TRANSACTION_TYPE_ID.",";;
			}
			return $InPointsTypeIDs;                    
	}
		
	public function OutPointsTransTypeId(){
		$query  = $this->fetchArrayObject("select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Withdraw' ");  
		$totalCount =  count($rsResult)-1;
	
		foreach ($rsResult as $key => $value) {
			if($key == $totalCount)
				$OutPointsTypeIDs .= $value->TRANSACTION_TYPE_ID;
			else
				$OutPointsTypeIDs .= $value->TRANSACTION_TYPE_ID.",";;
		}
		return $OutPointsTypeIDs;                    
	} */
	
	function getLastTicketData($gameCode,$terminalID) {
		$browseSQL = "SELECT TICKET_ID,DRAW_ID,PLAY_GROUP_ID FROM ".$this->lotto_tickets." WHERE TERMINAL_ID=".$terminalID." AND ".
					 "SUBSTR(INTERNAL_REFERENCE_NO,1,3)='".$gameCode."' AND IS_PENDING_STATUS=0 ORDER BY TICKET_ID DESC LIMIT 1";							 
		$rsResult  = $this->fetchArrayObject($browseSQL); 
		
		$browseSQL1 = "SELECT * FROM ".$this->lotto_tickets." WHERE PLAY_GROUP_ID='".$rsResult[0]->PLAY_GROUP_ID."' ";							 
		$rsResult1  = $this->fetchArrayObject($browseSQL1); 		
		if(!empty($rsResult1)) {
			$printData=array();
			foreach($rsResult1 as $lastIndex=>$lastBetaData) {
				$fSno=1; $fTotalQty=0;
				$betIndexString=json_decode($lastBetaData->BET_VALUE);
				foreach($betIndexString as $fBetIndex=>$fBetData) {				
					if($fSno==1) {
						$fBetsValuesString=$fBetIndex.":".$fBetData;	
					} else {
						$fBetsValuesString=$fBetsValuesString."|".$fBetIndex.":".$fBetData;
					}
					$fTotalQty=$fTotalQty+$fBetData;
					$fSno++;
				}	
				$printData[$lastBetaData->BET_TYPE]=array(
					"betTypeID"=>(string)$lastBetaData->BET_TYPE,
					"intRefNo"=>(string)$lastBetaData->INTERNAL_REFERENCE_NO,
					"betData"=>(string)$fBetsValuesString,
					"pGroupID"=>(string)$lastBetaData->PLAY_GROUP_ID
				);	
			}
			$objectToFlash=$this->arrayToObject($printData);
		}
		return htmlspecialchars(stripslashes(json_encode($objectToFlash, JSON_UNESCAPED_SLASHES)));
	}
	
	function getUserTransactionHistroy($req){
		
		$cond = array();
		$param = array();
		$histroyInfo = array();
		 
		$userId	= (!empty($req['user_id'])?$req['user_id']:'');
		$count		= (!empty( $req['limit'])?$req['limit']:'');
		$startDate	= (!empty( $req['start'])?date('Y-m-d',strtotime($req['start'])):'');
		$endDate	= (!empty( $req['end'])?date('Y-m-d',strtotime($req['start'])):'');
		 
		$sql_query = "SELECT *FROM master_transaction_history as h ";
		
		if(!empty($userId)){
			$cond[] = "h.USER_ID IN ( $userId )";
		}
		if(!empty($startDate) && !empty($endDate)){
			$cond[] ="DATE_FORMAT(h.TRANSACTION_DATE,'%Y-%m-%d') BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY h.MASTER_TRANSACTTION_ID DESC";
		}
		 
		if (count($cond)){
			$sql_query .= ' WHERE  ' . implode(' AND ', $cond);
		}
		
		if (!empty($count)){
			$sql_query .= " ORDER by h.MASTER_TRANSACTTION_ID DESC LIMIT $count";
		}
		$histroyInfo  = $this->fetchArrayObject($sql_query);
		return $histroyInfo;
	}

	function arrayToObject($array) {	
		if (!is_array($array)) {
			return $array;
		}	
		$object = new stdClass();		
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name=>$value) {
				$name = trim($name);
				if (!empty($name)) {
					$object->$name = $this->arrayToObject($value);	
				}
			}
			return $object;
		} else {
			return FALSE;
		}
	}
	
	function updateTicketTransactionDetails($arrUpdateTicket) {
		$lottoUserID  	= $arrUpdateTicket["TERMINAL_ID"];
		$balanceamount 	= $arrUpdateTicket["TOTAL_BET"];
		$drawId 		= $arrUpdateTicket["DRAW_ID"];
		$playGroupId	= $arrUpdateTicket["PLAY_GROUP_ID"];
		$ireference   	= $arrUpdateTicket["INTERNAL_REFERENCE_NO"];
		$SINGLE_QTY		= $arrUpdateTicket["SINGLE_QTY"];
		$DOUBLE_QTY   	= $arrUpdateTicket["DOUBLE_QTY"];
		$TRIPLE_QTY   	= $arrUpdateTicket["TRIPLE_QTY"];
		
		$USERNAME		= $_SESSION[SESSION_USERNAME];
		$PARTNER_ID		= $_SESSION[SESSION_PARTNERID];
		$userID 		= $lottoUserID;
		$partnerusername=$_SESSION[SESSION_PARTNERNAME];
		
		$transactionStatusId = 107;
		$transactionTypeId=21;
		$balanceTypeId=2;
		$cointypeid=1;
		$transfered =0;
		/** activity tracking */
		$activity = array(
			   'action'		=>  'Tc-transfer points',
			   'userid' 	=>  $userID,
			   'username' 	=>  $USERNAME
		);
		/** activity tracking end */
		
		$reqURL1 = '{"action":"balupdatereq","sessionid":"'.session_id().'"}';
		$request1=urlencode($reqURL1);
		$URL = API_HOST_NAME."/servlet/GameApiServlet?xmlString=$request1";
		$ch1 = curl_init($URL);
		curl_setopt($ch1, CURLOPT_MUTE, 1);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $request1);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		$response1 = curl_exec($ch1);
		curl_close($ch1);
		$dresponse1=json_decode(trim($response1),true);
		if($dresponse1['action']!="error"){
			if($dresponse1['action']=='balupdateres' && $dresponse1['sessionid']==session_id()){
				$transactionid=$dresponse1['transactionid'];
				$reqURL2 = '{"action":"withdrawAction","sessionid":"'.session_id().'","transactionid":"'.$transactionid.'","userid":"'.$userID.'","amount":'.$balanceamount.',"username":"'.$USERNAME.'","transactionstatusId":"'.$transactionStatusId.'","transactiontypeid":"'.$transactionTypeId.'","balancetypeid":"'.$balanceTypeId.'","ireferno":"'.$ireference.'","gameName":"wintc_lotto","coinTypeId":"'.$cointypeid.'"}';
				$request2=urlencode($reqURL2);
				$URL2 = API_HOST_NAME."/servlet/GameApiServlet?xmlString=$request2";

				$ch2 = curl_init($URL2);
				curl_setopt($ch2, CURLOPT_MUTE, 1);
				curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch2, CURLOPT_POST, 1);
				curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
				curl_setopt($ch2, CURLOPT_POSTFIELDS, $request2);
				curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
				$response2 = curl_exec($ch2);
				curl_close($ch2);
				$dresponse2=json_decode(trim($response2),true);
				$userid1=$dresponse2['userid'];
				$statusupdate=$dresponse2['status'];

				if($dresponse2['action']=='withdrawAction' && $dresponse2['sessionid']==session_id() &&  $userID==$userid1 && $statusupdate=="true"){
					/** activity tracking */
					$activity['status'] ="Success";
					$activity["jsonData"]=json_encode(array('Response2-success'=>$dresponse2));
					$transfered =1;
				}else{
					/** activity tracking */
					$activity['status'] ="Failed";
					$activity["jsonData"]=json_encode(array('Response2'=>$dresponse2,'TransferURL'=>json_decode(trim($reqURL2),true)));
				}
			}else{
				/** activity tracking */
				$activity['status'] ="Failed";
				$activity["jsonData"]=json_encode(array('Response1'=>$dresponse1,'TransferURL'=>json_decode(trim($reqURL1),true)));
			}
		}else{
			/** activity tracking */
			$activity['status'] ="Failed";
			$activity["jsonData"]=json_encode(array('Response1-Error'=>$dresponse1,'TransferURL'=>json_decode(trim($reqURL1),true)));
		}
		/** activity tracking insert*/
		$insert = $this->eventTracking($activity);
			
		//$query_pt3=$this->lotto_pdoObj->exec("UPDATE ".$this->lotto_draw." SET DRAW_TOTALBET=DRAW_TOTALBET+'".$balanceamount."', SINGLE_TICKET_COUNT=SINGLE_TICKET_COUNT+'".$SINGLE_QTY."',DOUBLE_TICKET_COUNT=DOUBLE_TICKET_COUNT+'".$DOUBLE_QTY."',TRIPLE_TICKET_COUNT=TRIPLE_TICKET_COUNT+'".$TRIPLE_QTY."' WHERE DRAW_ID=".$drawId."");
		$query_pt3=$this->lotto_pdoObj->exec("UPDATE ".$this->lotto_draw." SET DRAW_TOTALBET=DRAW_TOTALBET+'".$balanceamount."' WHERE DRAW_ID=".$drawId."");
		
		$query_pt4=$this->lotto_pdoObj->exec("UPDATE $this->lotto_tickets SET IS_PENDING_STATUS = 0 WHERE TERMINAL_ID='".$lottoUserID."' AND PLAY_GROUP_ID='".$playGroupId."'");

		if($transfered==1 && $query_pt3!='' && $query_pt4!='' ) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Here insert bulk sql records in luckky7_lotto_tickets
	 * max 21 records will be insert into db.
	 * @param string $browseSQL
	 * @return number|unknown
	 */
	function createLucy7LottoTickets($browseSQL) {
// 		$this->lotto_pdoObj->beginTransaction();
			$rsResult  = $this->lotto_pdoObj->exec($browseSQL);
		/* if( $rsResult!='' ) {
			$this->lotto_pdoObj->commit();
			return 1;
		} else {
			$this->lotto_pdoObj->rollBack();
			return 0;
		} */

		return $rsResult;
	}

	function ticketCreationLucky7($qry, $ticketArray){
		//$this->lotto_pdoObj->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
		$this->lotto_pdoObj->beginTransaction();
		//$browseSQL = "SELECT * FROM ".$this->user_points." WHERE USER_ID=".$ticketArray["TERMINAL_ID"]." FOR UPDATE";
		//$resultData= $this->fetchArrayObject($browseSQL);
			
		$createTicket = $this->createLucy7LottoTickets( $qry );
		//$updateMaster = $this->updateTicketTransaction($ticketArray);
		if($createTicket!=''){
			$updateMaster = $this->updateTicketTransactionDetails($ticketArray);
		}
		if( $createTicket!='' && $updateMaster!='') {
			$this->lotto_pdoObj->commit();
		//	$this->lotto_pdoObj->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
			return 1;
		} else {
			$this->lotto_pdoObj->rollBack();
			//$this->lotto_pdoObj->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
			return 0;
		}
	}
	
	function payTicketAmount($refNo){
		$getTicketInfo=$this->chkIsTicketValid($refNo);
		$lottoUserID  =$getTicketInfo[0]->TERMINAL_ID;
		/* $userWinAmount=0;
		if(!empty($getTicketInfo)){
			foreach($getTicketInfo as $tkt){
				$userWinAmount+=$tkt->TOTAL_WIN;
			}
		}
		
		$lottoUserID  =$getTicketInfo[0]->TERMINAL_ID;
		$lottoUserName=$this->getUserByID($lottoUserID);
		$lottoUserBal =$this->getUserBalanceByID($lottoUserID);
		$newuserpromobal     =$lottoUserBal[0]->USER_PROMO_BALANCE;
		$newuserpromoclosebal=$newuserpromobal+$userWinAmount;
		$newusertotbal       =$lottoUserBal[0]->USER_TOT_BALANCE;
		$newusertotclosebal  =$newusertotbal+$userWinAmount; */
		
		$lottoUserBal =$this->getUserBalanceByID($lottoUserID);
		$newusertotbal       =$lottoUserBal[0]->USER_TOT_BALANCE;
		$newusertotclosebal  = $newusertotbal;
		
		if($getTicketInfo[0]->IS_CANCEL!=1 ){ 
			if($getTicketInfo[0]->IS_PAID!=1){
				$this->lotto_pdoObj->beginTransaction();
				
				/* $query_pt=$this->lotto_pdoObj->exec("UPDATE user_points SET USER_PROMO_BALANCE='".$newuserpromoclosebal."', USER_TOT_BALANCE='".$newusertotclosebal."' "."WHERE USER_ID=".$lottoUserID."");
				//echo "UPDATE user_points SET USER_PROMO_BALANCE='".$newuserpromoclosebal."', USER_TOT_BALANCE='".$newusertotclosebal."' "."WHERE USER_ID=".$lottoUserID."";exit;
				$transactionStatusId = "102";
				$transactionTypeId   = "12";
				$balanceTypeId       = "2";									
				$query_pt2=$this->lotto_pdoObj->exec("INSERT INTO `master_transaction_history`(`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,".
						"`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,".
						"`PARTNER_ID`)VALUES('".$lottoUserID."','$balanceTypeId','$transactionStatusId','$transactionTypeId','$userWinAmount',".
						"NOW(),'".$getTicketInfo[0]->INTERNAL_REFERENCE_NO."','$newusertotbal','$newusertotclosebal','".$getTicketInfo[0]->PARTNER_ID."')");							  	 
 */
				$rsResult  = $this->lotto_pdoObj->exec("UPDATE tc_lotto_tickets SET IS_PAID=1 WHERE INTERNAL_REFERENCE_NO='".$refNo."' AND TERMINAL_ID='".$lottoUserID."'");	

				if($rsResult!='') {
					 $this->lotto_pdoObj->commit();
					 $statusString = "PAID";
				} else {
					$this->lotto_pdoObj->rollBack();
					
					$getDrawNumber=$this->getTicketInternalRefInfo($refNo);
					$btnText='PAY';
					if($getDrawNumber[0]->DRAW_STATUS==6){
						$btnText ='REFUND';
					}
					$statusString = '<img style="display: none; text-align: center; height: 26px"id="loader_claim" src="images/loader.gif" /><a tabindex="2" id="payButton" href="javascript:updateTicketPAYStatus('.$refNo.')"><div class="pay_claim">'.$btnText.'</div></a>';	
				}	
			}else{
				$statusString = "PAID";
			}
		}else{
			$statusString = "CANCELLED";
		}
		return $statusString."##".$newusertotclosebal;die;
	}
	
	function getPartnerGames($partnerId) {
		$browseSQL = "SELECT GAME_ID FROM agent_game_revenueshare WHERE PARTNER_ID='{$partnerId}'";
		$rsResult  = $this->fetchArrayObject($browseSQL);
		return $rsResult;
	}

	/* Common Functions Start Here */
	public function eventTracking($data) {
        $result = 0;
        if (empty($data)) {
            return $result;
        }

        $userId = (!empty($data['userid']) ? $data['userid'] : 0);
        $username = (!empty($data['username']) ? $data['username'] : '');
        $action = (!empty($data['action']) ? $data['action'] : '');
        $jsonData = (!empty($data['jsonData']) ? $data['jsonData'] : '');
        $staus	 = (!empty($data['status'])?$data['status']:'');

        $loginDate = date('Y-m-d H:i:s');
        /* $activitydata	= array(
          'USERNAME'		=> $username,
          'USER_ID'		=> $userId,
          'ACTION_NAME'	=> $action,
          'DATE_TIME'		=> $loginDate,
          'SYSTEM_IP' 	=> $this->getRealIpAddr(),
          //'SYSTEM_INFO'	=> json_encode($_SERVER),
          'STATUS' 		=> 1,
          'LOGIN_STATUS' 	=> 4,
          'TRACKING_DATA' => $jsonData,
          ); */


        $result = mysql_query("insert into backoffice_tracking(USERNAME,USER_ID,ACTION_NAME,DATE_TIME,SYSTEM_IP,STATUS,LOGIN_STATUS,TRACKING_DATA)
		values('" . $username . "',$userId,'" . $action . "','" . $loginDate . "','" . $this->getRealIpAddr() . "','".$staus."','4','" . $jsonData . "')") or die (mysql_error());
            $insertId=mysql_insert_id();
        return $insertId;
    }

    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
	function executeQuery($SQL) {
		$rsResult = mysql_query($SQL) or die("Could not run query".mysql_error());
		return $rsResult;
	}
	
	function getLastInsertID() {
		return mysql_insert_id();	
	}
	
	function getNumRows($rsResult) {
		return mysql_num_rows($rsResult);
	}
	
	function insertAndGetAffectedrows() {
		$rsResult = mysql_query($SQL) or die("Could not run query".mysql_error());
		return mysql_affected_rows();
	}
	
	function num_rows() {
		return $this->num_rows;	
	}	
	
	function fetchArrayObject($SQL) {
		$rsResult = mysql_query($SQL) or die("Could not run query".mysql_error());	
		$fIndex=0;
		$fArray =array();
		while($row=mysql_fetch_object($rsResult)) {
			$fArray[$fIndex]=$row;
			$fIndex++;
		}
		return $fArray;
	}
	function execute($conn, $sql) {
		$affected = $conn->exec($sql);
		if ($affected == '') {
			$err = $conn->errorInfo();
			if ($err[0] === '00000' || $err[0] === '01000') {
				return true;
			}
		}
    return $affected;
}
	/* Common Functions End Here */	
	
}
?>