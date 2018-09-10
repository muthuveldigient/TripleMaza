<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->model('general/services_model');			
	}
	
	public function getRevenueHistoricalData() {
		$getPartnersData = $this->services_model->getPartnersData();

		if(!empty($getPartnersData)) {
			foreach($getPartnersData as $partnersID) {			
				/* BELOW CODE TO GET THE SELF PLAYERS DATA */
				$getSelfPlayersData = $this->services_model->getSelfPlayersData($partnersID->PARTNER_ID);
				$selfPlayersIDs = "";
				if(!empty($getSelfPlayersData)) {
					foreach($getSelfPlayersData as $sPlayersID) {
						$selfPlayersIDs[] = $sPlayersID->USER_ID;
					}
				}

				if(date('d')!=1)
					$startDate = date("Y-m-01", strtotime("-2 months"));
				else
					$startDate = date("Y-m-01", strtotime("-3 months"));
				$endDate   = date('Y-m-d', strtotime( '-1 days' ) );
			
				$arrData["userIDs"]    = $selfPlayersIDs;
				$arrData["PARTNER_ID"] = $partnersID->PARTNER_ID;				
				$betAmount1="";$winAmount1="";$betAmount2="";$winAmount2="";$betAmount3="";$winAmount3="";
				$betAmountTT_ID["tTypeID"] = 11;
				$winAmountTT_ID["tTypeID"] = 12;
				
				$betwinAmount1["endDate"]   = date('Y-m-d', strtotime( '-1 days' ));
				$betwinAmount1["startDate"] = date('Y-m-01', strtotime($betwinAmount1["endDate"]));				

				$getBetAmount1Data = $this->services_model->betwinAmountData($betwinAmount1,$arrData,$betAmountTT_ID);
				if(!empty($getBetAmount1Data))
					$betAmount1 = $getBetAmount1Data[0]->betwinAmount;
				$getWinAmount1Data = $this->services_model->betwinAmountData($betwinAmount1,$arrData,$winAmountTT_ID);
				if(!empty($getWinAmount1Data))
					$winAmount1 = $getWinAmount1Data[0]->betwinAmount;		

				$betwinAmount2["startDate"] = date('Y-m-01', strtotime( $betwinAmount1["startDate"].'-1 month' ));
				$betwinAmount2["endDate"]   = date('Y-m-t', strtotime($betwinAmount2["startDate"]));
				$getBetAmount2Data = $this->services_model->betwinAmountData($betwinAmount2,$arrData,$betAmountTT_ID);
				if(!empty($getBetAmount2Data))
					$betAmount2 = $getBetAmount2Data[0]->betwinAmount;	
				$getWinAmount2Data = $this->services_model->betwinAmountData($betwinAmount2,$arrData,$winAmountTT_ID);
				if(!empty($getWinAmount2Data))
					$winAmount2 = $getWinAmount2Data[0]->betwinAmount;	
					
				$betwinAmount3["startDate"] = date('Y-m-01', strtotime( $betwinAmount2["startDate"].'-1 month' ));
				$betwinAmount3["endDate"]   = date('Y-m-t', strtotime($betwinAmount3["startDate"]));
				$getBetAmount3Data = $this->services_model->betwinAmountData($betwinAmount3,$arrData,$betAmountTT_ID);	
				if(!empty($getBetAmount3Data))
					$betAmount3 = $getBetAmount3Data[0]->betwinAmount;
				$getWinAmount3Data = $this->services_model->betwinAmountData($betwinAmount3,$arrData,$winAmountTT_ID);
				if(!empty($getWinAmount3Data))
					$winAmount3 = $getWinAmount3Data[0]->betwinAmount;																		
				/* BELOW CODE TO GET THE SELF PLAYERS DATA */
		
				/* BELOW CODE TO GET THE AFFILIATE PLAYERS DATA */
				unset($arrData["userIDs"]);unset($arrData["PARTNER_ID"]);
				$abetAmount1="";$awinAmount1="";$abetAmount2="";$awinAmount2="";$abetAmount3="";$awinAmount3="";
				$getAffiliatePartners    = $this->services_model->getAffiliatePartnersData($partnersID->PARTNER_ID);
				$affiliatePlayersIDs     = "";
				if(!empty($getAffiliatePartners)) {
					foreach($getAffiliatePartners as $affiliatePartnersID) {
						$affiliateUsersData = $this->services_model->getAffiliatePlayersData($affiliatePartnersID->PARTNER_ID);
						if(!empty($affiliateUsersData)) {
							foreach($affiliateUsersData as $aPlayersID) {
								$affiliatePlayersIDs[] = $aPlayersID->USER_ID;
							}							
							$arrData["userIDs"]    = $affiliatePlayersIDs;
							$arrData["PARTNER_ID"] = $affiliatePartnersID->PARTNER_ID;
								
							$agetBetAmount1Data = $this->services_model->betwinAmountData($betwinAmount1,$arrData,$betAmountTT_ID);
							if(!empty($agetBetAmount1Data))
								$abetAmount1 = $abetAmount1 + $agetBetAmount1Data[0]->betwinAmount;	
							$agetWinAmount1Data = $this->services_model->betwinAmountData($betwinAmount1,$arrData,$winAmountTT_ID);
							if(!empty($agetWinAmount1Data))
								$awinAmount1 = $awinAmount1 + $agetWinAmount1Data[0]->betwinAmount;	
								
							$agetBetAmount2Data = $this->services_model->betwinAmountData($betwinAmount2,$arrData,$betAmountTT_ID);
							if(!empty($agetBetAmount2Data))
								$abetAmount2 = $abetAmount2 + $agetBetAmount2Data[0]->betwinAmount;	
							$agetWinAmount2Data = $this->services_model->betwinAmountData($betwinAmount2,$arrData,$winAmountTT_ID);
							if(!empty($agetWinAmount2Data))
								$awinAmount2 = $awinAmount2 + $agetWinAmount2Data[0]->betwinAmount;		
								
							$agetBetAmount3Data = $this->services_model->betwinAmountData($betwinAmount3,$arrData,$betAmountTT_ID);
							if(!empty($agetBetAmount3Data))
								$abetAmount3 = $abetAmount3 + $agetBetAmount3Data[0]->betwinAmount;	
							$agetWinAmount3Data = $this->services_model->betwinAmountData($betwinAmount3,$arrData,$winAmountTT_ID);
							if(!empty($agetWinAmount3Data))
								$awinAmount3 = $awinAmount3 + $agetWinAmount3Data[0]->betwinAmount;																																																		

						} //if ends here
					} //foreach ends here
				}
				/* BELOW CODE TO GET THE AFFILIATE PLAYERS DATA */				
				
				$getAdminUserID = $this->services_model->getAdminUserID($partnersID->PARTNER_ID);
				$rHistoricalData["FK_PARTNER_ID"]      = $partnersID->PARTNER_ID;
				$rHistoricalData["FK_PARTNER_TYPE_ID"] = $partnersID->FK_PARTNER_TYPE_ID;
				$rHistoricalData["FK_ADMIN_USER_ID"]   = $getAdminUserID[0]->ADMIN_USER_ID;
				$rHistoricalData["START_DATE"]         = $startDate;
				$rHistoricalData["END_DATE"]           = $endDate;				
				$rHistoricalData["MONTH1"]             = date("F", strtotime($betwinAmount1["startDate"]));
				$rHistoricalData["MONTH2"]             = date("F", strtotime($betwinAmount2["startDate"]));
				$rHistoricalData["MONTH3"]             = date("F", strtotime($betwinAmount3["startDate"]));
				$rHistoricalData["SELF1_REVENUE"]      = $betAmount1-$winAmount1;
				$rHistoricalData["SELF1_OP_SHARE"]     = $betAmount1-$winAmount1;
				$rHistoricalData["SELF1_SHARE"]        = "";	
				$rHistoricalData["SELF2_REVENUE"]      = $betAmount2-$winAmount2;
				$rHistoricalData["SELF2_OP_SHARE"]     = $betAmount2-$winAmount2;
				$rHistoricalData["SELF2_SHARE"]        = "";
				$rHistoricalData["SELF3_REVENUE"]      = $betAmount3-$winAmount3;
				$rHistoricalData["SELF3_OP_SHARE"]     = $betAmount3-$winAmount3;
				$rHistoricalData["SELF3_SHARE"]        = "";								
				$rHistoricalData["AFFILIATE1_REVENUE"] = $abetAmount1-$awinAmount1;
				$rHistoricalData["AFFILIATE1_SHARE"]   = $rHistoricalData["AFFILIATE1_REVENUE"] / $partnersID->PARTNER_REVENUE_SHARE;
				$rHistoricalData["AFFILIATE1_OP_SHARE"]= $rHistoricalData["AFFILIATE1_REVENUE"] - $rHistoricalData["AFFILIATE1_SHARE"];
				$rHistoricalData["AFFILIATE2_REVENUE"] = $abetAmount2-$awinAmount2;
				$rHistoricalData["AFFILIATE2_SHARE"]   = $rHistoricalData["AFFILIATE2_REVENUE"] / $partnersID->PARTNER_REVENUE_SHARE;
				$rHistoricalData["AFFILIATE2_OP_SHARE"]= $rHistoricalData["AFFILIATE2_REVENUE"] - $rHistoricalData["AFFILIATE2_SHARE"];
				$rHistoricalData["AFFILIATE3_REVENUE"] = $abetAmount3-$awinAmount3;
				$rHistoricalData["AFFILIATE3_SHARE"]   = $rHistoricalData["AFFILIATE3_REVENUE"] / $partnersID->PARTNER_REVENUE_SHARE;				
				$rHistoricalData["AFFILIATE3_OP_SHARE"]= $rHistoricalData["AFFILIATE3_REVENUE"] - $rHistoricalData["AFFILIATE3_SHARE"];															
				$rHistoricalData["STATUS"]             = 1;
				$rHistoricalData["CREATED_ON"]         = date('Y-m-d h:i:s');
				$addRHistoricalData = $this->services_model->addRevenueHistoricalData($rHistoricalData);

			}//foreach ends here
		}
	} //getRevenueHistoricalData function ends here
	
	public function getCashflowHistoricalData() {
		$getPartnersData = $this->services_model->getPartnersData();
		if(!empty($getPartnersData)) {
			foreach($getPartnersData as $partnersID) {
				/* BELOW CODE TO GET THE SELF PLAYERS DATA */
				$getSelfPlayersData = $this->services_model->getSelfPlayersData($partnersID->PARTNER_ID);
				$selfPlayersIDs = "";
				if(!empty($getSelfPlayersData)) {
					foreach($getSelfPlayersData as $sPlayersID) {
						$selfPlayersIDs[] = $sPlayersID->USER_ID;
					}
				}
				
				if(date('d')!=1)
					$startDate = date("Y-m-01", strtotime("-2 months"));
				else
					$startDate = date("Y-m-01", strtotime("-3 months"));
				$endDate   = date('Y-m-d', strtotime( '-1 days' ) );				
				
				$arrData["userIDs"]    = $selfPlayersIDs;
				$arrData["PARTNER_ID"] = $partnersID->PARTNER_ID;
				$cashIN1Amount=""; $cashOUT1Amount=""; $cashIN2Amount=""; $cashOUT2Amount=""; $cashIN3Amount=""; $cashOUT3Amount="";
				
				$cashIN_TT_ID["tTypeID1"] = 8; 
				$cashIN_TT_ID["tTypeID2"] = 9;				
				$cashOUT_TT_ID["tTypeID"] = 10;					
				
				$cashINcashOUT1["endDate"]   = date('Y-m-d', strtotime( '-1 days' ));
				$cashINcashOUT1["startDate"] = date('Y-m-01', strtotime($cashINcashOUT1["endDate"]));							
				$cashIN1Data  = $this->services_model->cashINAmountData($cashINcashOUT1,$arrData,$cashIN_TT_ID);			
				if(!empty($cashIN1Data))
					$cashIN1Amount = $cashIN1Data[0]->cashINAmountData;
				$cashOUT1Data = $this->services_model->cashOUTAmountData($cashINcashOUT1,$arrData,$cashOUT_TT_ID);
				if(!empty($cashOUT1Data))
					$cashOUT1Amount = $cashOUT1Data[0]->cashOUTAmountData;
					
				$cashINcashOUT2["startDate"] = date('Y-m-01', strtotime( $cashINcashOUT1["startDate"].'-1 month' ));				
				$cashINcashOUT2["endDate"]   = date('Y-m-t', strtotime($cashINcashOUT2["startDate"]));
				$cashIN2Data  = $this->services_model->cashINAmountData($cashINcashOUT2,$arrData,$cashIN_TT_ID);
				if(!empty($cashIN2Data))
					$cashIN2Amount = $cashIN2Data[0]->cashINAmountData;
				$cashOUT2Data = $this->services_model->cashOUTAmountData($cashINcashOUT2,$arrData,$cashOUT_TT_ID);
				if(!empty($cashOUT2Data))
					$cashOUT2Amount = $cashOUT2Data[0]->cashOUTAmountData;					
					
				$cashINcashOUT3["startDate"] = date('Y-m-01', strtotime( $cashINcashOUT2["startDate"].'-1 month' ));				
				$cashINcashOUT3["endDate"]   = date('Y-m-t', strtotime($cashINcashOUT3["startDate"]));
				$cashIN3Data  = $this->services_model->cashINAmountData($cashINcashOUT3,$arrData,$cashIN_TT_ID);
				if(!empty($cashIN3Data))
					$cashIN3Amount = $cashIN3Data[0]->cashINAmountData;
				$cashOUT3Data = $this->services_model->cashOUTAmountData($cashINcashOUT3,$arrData,$cashOUT_TT_ID);
				if(!empty($cashOUT3Data))
					$cashOUT3Amount = $cashOUT3Data[0]->cashOUTAmountData;					
				/* BELOW CODE TO GET THE SELF PLAYERS DATA */
								
				/* BELOW CODE TO GET THE AFFILIATE PLAYERS DATA */
				unset($arrData["userIDs"]);unset($arrData["PARTNER_ID"]);
				$acashIN1Amount=""; $acashOUT1Amount=""; $acashIN2Amount=""; $acashOUT2Amount=""; $acashIN3Amount=""; $acashOUT3Amount="";
				$getAffiliatePartners    = $this->services_model->getAffiliatePartnersData($partnersID->PARTNER_ID);
				$affiliatePlayersIDs     = "";	
				if(!empty($getAffiliatePartners)) {
					foreach($getAffiliatePartners as $affiliatePartnersID) {
						$affiliateUsersData = $this->services_model->getAffiliatePlayersData($affiliatePartnersID->PARTNER_ID);
						if(!empty($affiliateUsersData)) {
							foreach($affiliateUsersData as $aPlayersID) {
								$affiliatePlayersIDs[] = $aPlayersID->USER_ID;
							}
							$arrData["userIDs"]    = $affiliatePlayersIDs;
							$arrData["PARTNER_ID"] = $affiliatePartnersID->PARTNER_ID;							
							
							$acashIN1Data  = $this->services_model->cashINAmountData($cashINcashOUT1,$arrData,$cashIN_TT_ID);			
							if(!empty($acashIN1Data))
								$acashIN1Amount = $acashIN1Amount + $acashIN1Data[0]->cashINAmountData;
							$acashOUT1Data = $this->services_model->cashOUTAmountData($cashINcashOUT1,$arrData,$cashOUT_TT_ID);
							if(!empty($acashOUT1Data))
								$acashOUT1Amount = $acashOUT1Amount + $acashOUT1Data[0]->cashOUTAmountData;	
								
							$acashIN2Data  = $this->services_model->cashINAmountData($cashINcashOUT2,$arrData,$cashIN_TT_ID);			
							if(!empty($acashIN2Data))
								$acashIN2Amount = $acashIN2Amount + $acashIN2Data[0]->cashINAmountData;
							$acashOUT2Data = $this->services_model->cashOUTAmountData($cashINcashOUT2,$arrData,$cashOUT_TT_ID);
							if(!empty($acashOUT2Data))
								$acashOUT2Amount = $acashOUT2Amount + $acashOUT2Data[0]->cashOUTAmountData;
								
							$acashIN3Data  = $this->services_model->cashINAmountData($cashINcashOUT3,$arrData,$cashIN_TT_ID);			
							if(!empty($acashIN3Data))
								$acashIN3Amount = $acashIN3Amount + $acashIN3Data[0]->cashINAmountData;
							$acashOUT3Data = $this->services_model->cashOUTAmountData($cashINcashOUT3,$arrData,$cashOUT_TT_ID);
							if(!empty($acashOUT3Data))
								$acashOUT3Amount = $acashOUT3Amount + $acashOUT3Data[0]->cashOUTAmountData;																						
						}
					} //foreach ends here
				}//main if ends here
				/* BELOW CODE TO GET THE AFFILIATE PLAYERS DATA */
								
				$getAdminUserID = $this->services_model->getAdminUserID($partnersID->PARTNER_ID);
				$cHistoricalData["FK_PARTNER_ID"]      = $partnersID->PARTNER_ID;
				$cHistoricalData["FK_PARTNER_TYPE_ID"] = $partnersID->FK_PARTNER_TYPE_ID;
				$cHistoricalData["FK_ADMIN_USER_ID"]   = $getAdminUserID[0]->ADMIN_USER_ID;
				$cHistoricalData["START_DATE"]         = $startDate;
				$cHistoricalData["END_DATE"]           = $endDate;				
				$cHistoricalData["MONTH1"]             = date("F", strtotime($cashINcashOUT1["startDate"]));
				$cHistoricalData["MONTH2"]             = date("F", strtotime($cashINcashOUT2["startDate"]));
				$cHistoricalData["MONTH3"]             = date("F", strtotime($cashINcashOUT3["startDate"]));
				if($cashIN1Amount)
					$cHistoricalData["CASH_IN1_SELF"]      = $cashIN1Amount;				
				if($acashIN1Amount)
					$cHistoricalData["CASH_IN1_AFFILIATE"] = $acashIN1Amount;
				$cHistoricalData["CASH_IN1_TOTAL"]     = $cashIN1Amount + $acashIN1Amount;
				if($cashIN2Amount)
					$cHistoricalData["CASH_IN2_SELF"]  = $cashIN2Amount;				
				if($acashIN2Amount)
					$cHistoricalData["CASH_IN2_AFFILIATE"] = $acashIN2Amount;
				$cHistoricalData["CASH_IN2_TOTAL"]         = $cashIN2Amount + $acashIN2Amount;
				if($cashIN3Amount)
					$cHistoricalData["CASH_IN3_SELF"]      = $cashIN3Amount;				
				if($acashIN3Amount)
					$cHistoricalData["CASH_IN3_AFFILIATE"] = $acashIN3Amount;
				$cHistoricalData["CASH_IN3_TOTAL"]     = $cashIN3Amount + $acashIN3Amount;								
				if($cashOUT1Amount)
					$cHistoricalData["CASH_OUT1_SELF"] = $cashOUT1Amount;
				if($acashOUT1Amount)
					$cHistoricalData["CASH_OUT1_AFFILIATE"]= $acashOUT1Amount;
				$cHistoricalData["CASH_OUT1_TOTAL"]        = $cashOUT1Amount + $acashOUT1Amount;				
				if($cashOUT2Amount)
					$cHistoricalData["CASH_OUT2_SELF"]     = $cashOUT2Amount;
				if($acashOUT2Amount)
					$cHistoricalData["CASH_OUT2_AFFILIATE"]= $acashOUT2Amount;
				$cHistoricalData["CASH_OUT2_TOTAL"]        = $cashOUT2Amount + $acashOUT2Amount;
				if($cashOUT3Amount)
					$cHistoricalData["CASH_OUT3_SELF"]     = $cashOUT3Amount;
				if($acashOU31Amount)
					$cHistoricalData["CASH_OUT3_AFFILIATE"]= $acashOU31Amount;
				$cHistoricalData["CASH_OUT3_TOTAL"]    = $cashOUT3Amount + $acashOUT3Amount;	
				$cHistoricalData["STATUS"]             = 1;
				$cHistoricalData["CREATED_ON"]         = date('Y-m-d h:i:s');

				$addCHistoricalData = $this->services_model->addCashflowHistoricalData($cHistoricalData);
														 										
			}//main foreach ends here
		}
	} //getRevenueHistoricalData function ends here

	public function getUserHistoricalData() {
		$getPartnersData = $this->services_model->getPartnersData();
		if(!empty($getPartnersData)) {
			if(date('d')!=1)
				$startDate = date("Y-m-01", strtotime("-2 months"));
			else
				$startDate = date("Y-m-01", strtotime("-3 months"));
			$endDate   = date('Y-m-d', strtotime( '-1 days' ) );			

			$users1Registered["endDate"]   = date('Y-m-d', strtotime( '-1 days' ));
			$users1Registered["startDate"] = date('Y-m-01', strtotime($users1Registered["endDate"]));	
			$users2Registered["startDate"] = date('Y-m-01', strtotime($users1Registered["startDate"].'-1 month' ));				
			$users2Registered["endDate"]   = date('Y-m-t', strtotime($users2Registered["startDate"]));								
			$users3Registered["startDate"] = date('Y-m-01', strtotime($users2Registered["startDate"].'-1 month' ));				
			$users3Registered["endDate"]   = date('Y-m-t', strtotime($users3Registered["startDate"]));				
			
			$selfPlayers1Count=""; $affPlayers1Count=""; $selfPlayers2Count=""; $affPlayers2Count=""; $selfPlayers3Count=""; $affPlayers3Count="";
			foreach($getPartnersData as $partnersID) {
				$getSelfPlayers1Data = $this->services_model->getSelfPlayersDataCount($partnersID->PARTNER_ID,$users1Registered);
				if(!empty($getSelfPlayers1Data))
					$selfPlayers1Count = count($getSelfPlayers1Data);
				$getSelfPlayers2Data = $this->services_model->getSelfPlayersDataCount($partnersID->PARTNER_ID,$users2Registered);
				if(!empty($getSelfPlayers2Data))
					$selfPlayers2Count = count($getSelfPlayers2Data);
				$getSelfPlayers3Data = $this->services_model->getSelfPlayersDataCount($partnersID->PARTNER_ID,$users3Registered);
				if(!empty($getSelfPlayers3Data))
					$selfPlayers3Count = count($getSelfPlayers3Data);									

				$getAffiliatePartners  = $this->services_model->getAffiliatePartnersData($partnersID->PARTNER_ID);
				$affiliatePlayersIDs   = "";
				if(!empty($getAffiliatePartners)) {
					foreach($getAffiliatePartners as $affiliatePartnersID) {
						$affiliateUsersData = $this->services_model->getAffiliatePlayersData($affiliatePartnersID->PARTNER_ID);
						if(!empty($affiliateUsersData)) {
							$getaffPlayers1Data = $this->services_model->getSelfPlayersDataCount($partnersID->PARTNER_ID,$users1Registered);
							if(!empty($getaffPlayers1Data))
								$affPlayers1Count = $affPlayers1Count + count($getaffPlayers1Data);
							$getaffPlayers2Data = $this->services_model->getSelfPlayersDataCount($partnersID->PARTNER_ID,$users2Registered);
							if(!empty($getaffPlayers2Data))
								$affPlayers2Count = $affPlayers2Count + count($getaffPlayers2Data);
							$getaffPlayers3Data = $this->services_model->getSelfPlayersDataCount($partnersID->PARTNER_ID,$users3Registered);
							if(!empty($getaffPlayers3Data))
								$affPlayers3Count = $affPlayers3Count + count($getaffPlayers3Data);							
						}
					}//foreach ends here
				}
				
				$getAdminUserID = $this->services_model->getAdminUserID($partnersID->PARTNER_ID);
				$uHistoricalData["FK_PARTNER_ID"]      = $partnersID->PARTNER_ID;
				$uHistoricalData["FK_PARTNER_TYPE_ID"] = $partnersID->FK_PARTNER_TYPE_ID;
				$uHistoricalData["FK_ADMIN_USER_ID"]   = $getAdminUserID[0]->ADMIN_USER_ID;
				$uHistoricalData["START_DATE"]         = $startDate;
				$uHistoricalData["END_DATE"]           = $endDate;				
				$uHistoricalData["MONTH1"]             = date("F", strtotime($users1Registered["startDate"]));
				$uHistoricalData["MONTH2"]             = date("F", strtotime($users2Registered["startDate"]));
				$uHistoricalData["MONTH3"]             = date("F", strtotime($users3Registered["startDate"]));
				if($selfPlayers1Count)				
					$uHistoricalData["SELF1_USERS"]    = $selfPlayers1Count;
				if($selfPlayers2Count)
					$uHistoricalData["SELF2_USERS"]    = $selfPlayers2Count;
				if($selfPlayers3Count)
					$uHistoricalData["SELF3_USERS"]    = $selfPlayers3Count;
				if($affPlayers1Count)									
					$uHistoricalData["AFFILIATE1_USERS"]= $affPlayers1Count;
				if($affPlayers2Count)									
					$uHistoricalData["AFFILIATE2_USERS"]= $affPlayers2Count;
				if($affPlayers1Count)									
					$uHistoricalData["AFFILIATE3_USERS"]= $affPlayers3Count;			
				$uHistoricalData["STATUS"]             = 1;
				$uHistoricalData["CREATED_ON"]         = date('Y-m-d h:i:s');				

				$addUHistoricalData = $this->services_model->addUsersHistoricalData($uHistoricalData);
			}//main foreach ends here
		}
	}
	
	/* BELOW ARE THE FUNCTIONS USED FOR ONLINE SYSTEM - DASHBOARD */
	
	public function getXUserHistoricalData() {
		$getXPartnersData = $this->services_model->getXPartnersData();		
		if(!empty($getXPartnersData)) {
			foreach($getXPartnersData as $uIndex=>$userHistoricalData) {
				$xUserHistoricalData["PARTNER_ID"]="";
				$xUserHistoricalData["TOT_REG_PLAYERS"]=""; $xUserHistoricalData["TOT_DEP_PLAYERS"]="";
				$xUserHistoricalData["TOT_REG_PLAYERS_CMONTH"]=""; $xUserHistoricalData["TOT_DEP_PLAYERS_CMONTH"]="";
				$xUserHistoricalData["TOT_REG_PLAYERS_LMONTH"]=""; $xUserHistoricalData["TOT_DEP_PLAYERS_LMONTH"]="";				
				
				$xPartnerID = $userHistoricalData->PARTNER_ID;
				$getTotRegPlayers = $this->services_model->getTotRegPlayers($xPartnerID);
				$xUserHistoricalData["TOT_REG_PLAYERS"] = count($getTotRegPlayers);
				if(!empty($getTotRegPlayers)) {
					$xUserIDs = array();
					foreach($getTotRegPlayers as $tIndex=>$tRegPlayers) {
						$xUserIDs[] = $tRegPlayers->USER_ID;		
					}
					$getTotDepPlayers = $this->services_model->getTotDepPlayers($xUserIDs);
					$xUserHistoricalData["TOT_DEP_PLAYERS"] = count($getTotDepPlayers);
					
					$cStartDate = date('Y-m-01');
					$cEndDate   = date('Y-m-d',strtotime("-1 days"));					
					$getTotRegPlayersCMonth = $this->services_model->getTotRegPlayersMonth($xPartnerID,$cStartDate,$cEndDate);
					$cMPlayers = array();
					if(!empty($getTotRegPlayersCMonth)) {
						foreach($getTotRegPlayersCMonth as $cMIndex=>$cMPlayersData) {
							$cMPlayers[] = $cMPlayersData->USER_ID;		
						}							
					}
					$xUserHistoricalData["TOT_REG_PLAYERS_CMONTH"] = count($getTotRegPlayersCMonth);
					
					$getTotDepPlayersCMonth = $this->services_model->getTotDepPlayersMonth($cPPlayers,$cStartDate,$cEndDate);
					$xUserHistoricalData["TOT_DEP_PLAYERS_CMONTH"] = count($getTotDepPlayersCMonth);				
					
					$lStartDate = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")));
					$lEndDate   = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")));					
					$getTotRegPlayersLMonth = $this->services_model->getTotRegPlayersMonth($xPartnerID,$lStartDate,$lEndDate);
					$lMPlayers = array();
					if(!empty($getTotRegPlayersCMonth)) {
						foreach($getTotRegPlayersCMonth as $lMIndex=>$lMPlayersData) {
							$lMPlayers[] = $lMPlayersData->USER_ID;		
						}							
					}					
					$xUserHistoricalData["TOT_REG_PLAYERS_LMONTH"] = count($getTotRegPlayersLMonth);
					
					$getTotDepPlayerslMonth = $this->services_model->getTotDepPlayersMonth($lMPlayers,$lStartDate,$lEndDate);				
					$xUserHistoricalData["TOT_DEP_PLAYERS_LMONTH"] = count($getTotDepPlayerslMonth);				
					
					$xUserHistoricalData["PARTNER_ID"] = $xPartnerID;
					$xUserHistoricalData["STATUS"]=1;	
					$xUserHistoricalData["CREATED_ON"] = date('Y-m-d h:i:s');			
					$addxUsersHistoricalData = $this->services_model->addxUsersHistoricalData($xUserHistoricalData);
				}				
			} //foreach ends here
		}
	}
	
	
	/* BELOW ARE THE FUNCTIONS USED FOR ONLINE SYSTEM - DASHBOARD */	
}