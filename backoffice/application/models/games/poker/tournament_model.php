<?php
/*
  Class Name	: Tournament_model
  Package Name  : Poker
  Purpose       : Handle all the database services related to Poker -> Tournament
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/

class Tournament_model extends CI_Model
{

   public function getAllTournamentTypes() {
		$this->db2->where('STATUS',1);
		$browseSQL = $this->db2->get('tournament_type');
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

  public function getRecurrenceParentInformation($parentTournamentId) {
		$this->db2->select("FK_PARENT_TOURNAMENT_ID,BUYIN,ENTRY_FEE");
		$this->db2->where("TOURNAMENT_RECURENCE_ID",$parentTournamentId);
		$browseSQL = $this->db2->get("tournament_recureence");
		$rsResult  = $browseSQL->row();
		$buyin_amount  = $rsResult->BUYIN;
		$totalAmount    = $buyin_amount;
	    return $totalAmount;
	}

function getTounamentBlindData($tournamentID) {
  $this->db2->select('t.TOURNAMENT_ID,t.SMALL_BLIND,t.BIG_BLIND')->from('tournament t');
  $this->db2->where('tournament_id',$tournamentID);
  $browseSQL=$this->db2->get();
  $rsResult  = $browseSQL->result();
  return $rsResult;
 }

function getPlayerName($playerID) {
  $this->db2->select('u.USER_ID,u.USERNAME')->from('user u');
  $this->db2->where('u.USER_ID',$playerID);
  $browseSQL=$this->db2->get();
  $rsResult  = $browseSQL->result();
  return $rsResult;
 }

    public function getPartnerTournamentTypes($partner_id) {
        $rsResult = "";
		//check partner available tournament types
		$partnerTournamentIds = $this->chkPartnerAvailableTournamentTypes($partner_id);
		if($partnerTournamentIds != ''){
			$tourPartnerIds = $this->convertStringToArray($partnerTournamentIds);
			$this->db2->where('STATUS',1);
			$this->db2->where_in('TOURNAMENT_TYPE_ID', $tourPartnerIds);
			$browseSQL = $this->db2->get('tournament_type');
			$rsResult  = $browseSQL->result();
		}

		return $rsResult;
	}

	public function getPartnerPrizeStructure($partner_id){
		$rsResult = "";
		//check partner available tournament types
		$partnerPrizeStructure = $this->chkPartnerAvailablePrizeStructure($partner_id);
		if($partnerPrizeStructure != ''){
			$tourPrizeStructureIds = $this->convertStringToArray($partnerPrizeStructure);
			$this->db2->where_in('TOURNAMENT_PRIZE_STRUCTURES_ID', $tourPrizeStructureIds);
			$browseSQL = $this->db2->get('tournament_prize_structures');
			//echo $this->db->last_query(); die;
			$rsResult  = $browseSQL->result();
		}

		return $rsResult;
	}


	public function getTournamentGameTypes(){
		$this->db2->select("MINIGAMES_ID,MINIGAMES_TYPE_ID,GAME_DESCRIPTION,MINIGAMES_TYPE_NAME");
		$this->db2->where("STATUS",1);
		$browseSQL = $this->db2->get("minigames_type");
		$rsResult  =  $browseSQL->result();
		return $rsResult;
    }
	public function getSatelliteTournamentGameTypes() {
		$satellite_tournament_id = array(5,6,7,8);
		$this->db->select("MINIGAMES_ID,MINIGAMES_TYPE_ID,GAME_DESCRIPTION,MINIGAMES_TYPE_NAME");
		$this->db->where("STATUS",1);
		$this->db->where_not_in("MINIGAMES_TYPE_ID",$satellite_tournament_id);
		$browseSQL = $this->db->get("minigames_type");
		$rsResult  =  $browseSQL->result();
		return $rsResult;

	}
	public function chkPartnerAvailableTournamentTypes($partner_id){
	    $this->db2->where("PARTNER_ID",$partner_id);
	    $browseSQL = $this->db2->get('tournament_partner_features');
		$rsResult  = $browseSQL->row();
		$tournament_types  = $rsResult->TOURNAMENT_TYPES;

		return $tournament_types;
	}

	public function chkPartnerAvailablePrizeStructure($partner_id){
	    $this->db2->where("PARTNER_ID",$partner_id);
	    $browseSQL = $this->db2->get('tournament_partner_features');
		$rsResult  = $browseSQL->row();
		$tournament_prize_structures  = $rsResult->TOURNAMENT_PRIZE_STRUCTURES;

		return $tournament_prize_structures;
	}

	public function getTournamentLimits(){
		$this->db2->select("TOURNAMENT_LIMIT_ID,TOURNAMENT_LIMIT_NAME,DESCRIPTION");
		$browseSQL = $this->db2->get("tournament_limit");
		$rsResult  =  $browseSQL->result();
		return $rsResult;
	}

	public function getTournamentDefaultBlindStructure($partner_id){
	    $this->db2->select("TOURNAMENT_PARTNER_LEVEL_STRUCTURE_ID,TOURNAMENT_LEVEL,SMALL_BLIND,BIG_BLIND,ANTE,TIME_BANK");
		$this->db2->where('PARTNER_ID', $partner_id);
		$browseSQL = $this->db2->get("tournament_partner_level_structure");

		$rsResult  =  $browseSQL->result();

		return $rsResult;
	}

	public function getTournamentPrizeTypes(){
	  $this->db2->select("PRIZE_TYPE_ID,NAME,DESCRIPTION");
	  $this->db2->where("STATUS",1);
	  $browseSQL = $this->db2->get("prize_type");
	  $rsResult  =  $browseSQL->result();
	  return $rsResult;
	}

	public function convertStringToTime($time){
	  return date("H:i", strtotime("$time"));
	}

	public function convertDateIntoNeedFormate($date){
	  return date("Y-m-d", strtotime("$date"));
	}

	public function addTimeToDate($date,$time){
	  $datev = strtotime($date);
	  return date('Y-m-d H:i:s', strtotime("+$time minutes", $datev));
	}

	public function calPercentage($val1, $val2, $precision)
	{
		$res = round( ($val1 / 100) * $val2, $precision );
		return $res;
	}

	public function getSmallBlindByLevel($levelid){
		$this->db2->where("PARTNER_ID",ADMIN_USER_ID);
		$this->db2->where("TOURNAMENT_LEVEL",$levelid);
		$browseSQL = $this->db2->get('tournament_partner_level_structure');
		$rsResult  = $browseSQL->row();
		$smallBlind  = $rsResult->SMALL_BLIND;
		return $smallBlind;
	}

	public function getBigBlindByLevel($levelid){
		$this->db2->where("PARTNER_ID",ADMIN_USER_ID);
		$this->db2->where("TOURNAMENT_LEVEL",$levelid);
		$browseSQL = $this->db2->get('tournament_partner_level_structure');
		$rsResult  = $browseSQL->row();
		$bigBlind  = $rsResult->BIG_BLIND;
		return $bigBlind;
	}

	public function getBlindStructuresAfterLevel($levelid){
	  $this->db2->select("SMALL_BLIND,BIG_BLIND,ANTE,TIME_BANK");
	  $this->db2->where("PARTNER_ID",ADMIN_USER_ID);
	  $this->db2->where("TOURNAMENT_LEVEL >=",$levelid);
	  $browseSQL = $this->db2->get("tournament_partner_level_structure");
	  $rsResult  =  $browseSQL->result();
	  return $rsResult;
	}

	public function getMainTournamentType() {
		$currentdate = date('Y-m-d H:i:s');
		$this->db2->select("TOURNAMENT_NAME,TOURNAMENT_LIMIT_ID,IS_ACTIVE,TOURNAMENT_ID");
		$this->db2->where("TOURNAMENT_TYPE_ID",2);
		$this->db2->where("IS_ACTIVE",1);
		$this->db2->where("TOURNAMENT_START_TIME >=",$currentdate);
	 	$browseSQL = $this->db2->get("tournament");
		$rsResult  =  $browseSQL->result();
	    return $rsResult;
	}
	public function getTournamentType($tournamentID) {
		$this->db2->select("FK_PARENT_TOURNAMENT_ID,TOURNAMENT_TYPE_ID,MINI_GAME_TYPE_ID,IS_ACTIVE,TOURNAMENT_ID,TOURNAMENT_NAME");
		$this->db2->where("TOURNAMENT_ID",$tournamentID);
		$browseSQL = $this->db2->get("tournament");
		$rsResult  =  $browseSQL->result();
	    return $rsResult;
	}
	public function getParentInformation($parentTournamentId) {
		$this->db2->select("FK_PARENT_TOURNAMENT_ID,BUYIN,ENTRY_FEE");
		$this->db2->where("TOURNAMENT_ID",$parentTournamentId);
		$browseSQL = $this->db2->get("tournament");
		$rsResult  = $browseSQL->row();
		$buyin_amount  = $rsResult->BUYIN;
		$totalAmount    = $buyin_amount;
	    return $totalAmount;
	}


	public function insertTournament($data){


	  //post data
	  $tournament_name 				= $data['tournament_name'];
      if($data['maingame_tournament_type']==1) {
      	$tournamet_game_type 			= $data['tournamet_game_type'];
	  }else {
	  	$tournamet_game_type 			= $data['satellite_tournament_game_type'];
	  }

	   if($tournamet_game_type == 1){
	  	$tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
		$tournamet_game_type 		= 1;
	  	$tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
	    $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
	  }else if($tournamet_game_type == 2){
	  	$tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
		$tournamet_game_type 		= 2;
	    $tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
	    $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
	  }else if($tournamet_game_type == 3){
	  	$tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
		$tournamet_game_type 		= 1;
	    $tournament_lobby_id 		= 3;
	    $tournament_lobby_menu_id   = 7;
	  }else if($tournamet_game_type == 4){
	  	$tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
		$tournamet_game_type 		= 2;
	    $tournament_lobby_id 		= 3;
	    $tournament_lobby_menu_id   = 8;
	  }else if($tournamet_game_type == 5){
	  	$tournament_type 			= 2;
		$tournamet_game_type 		= 1;
	  	$tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
	    $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
	  }else if($tournamet_game_type == 6) {
	  	$tournament_type 			= 2;
		$tournamet_game_type 		= 2;
	  	$tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
	  	$tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
	  }else if($tournamet_game_type == 7) {
	  	$tournament_type 			= 2;
		$tournamet_game_type 		= 1;
	  	$tournament_lobby_id 		= 3;
	  	$tournament_lobby_menu_id   = 7;
	  }else if($tournamet_game_type == 8) {
	  	$tournament_type 			= 2;
		$tournamet_game_type 		= 2;
	  	$tournament_lobby_id 		= 3;
	  	$tournament_lobby_menu_id   = 8;
	  }



      $tournamet_gamestatus 		= $data['tournamet_gamestatus'];
	  $tournamet_limit 				= $data['tournamet_limit'];
	  /* EO: Tournament Information Block */

	  /* Timing Information */
	  $tournament_date				= $data['tournament_date'];
	  $tournament_time 				= $data['tournament_time'];
  	  $tournament_reg_start_date	= $data['tournament_reg_start_date'];
	  $tournament_reg_start_time	= $data['tournament_reg_start_time'];
	  $tournament_late				= $data['tournament_late'];
	  $tournament_reg_ends			= $data['tournament_reg_ends'];
	  $convertStringToTime			= $this->convertStringToTime($tournament_time);
	  $convertDateIntoNeedFormate	= $this->convertDateIntoNeedFormate($tournament_date);
	  $registerSTime				= $this->convertStringToTime($tournament_reg_start_time);
	  $registerSDdate 				= $this->convertDateIntoNeedFormate($tournament_reg_start_date);
	  $register_start_time			= $registerSDdate.' '.$registerSTime;
	  $tournament_start_time        = $convertDateIntoNeedFormate.' '.$convertStringToTime;
	  if($tournament_late == 'on'){
	    $register_end_time        = $tournament_start_time;
		//$register_end_time          = $this->addTimeToDate($tournament_start_time,$tournament_reg_ends);
		$late_registration 		    = 1;
	  }else{
	    $register_end_time  		= $tournament_start_time;
		$late_registration 		    = 0;
	  }
	  /* EO: Timing Information*/

      /* Player Section*/
	  $tournament_player_pertable	= $data['tournament_player_pertable'];
	  $tournament_min_players		= $data['tournament_min_players'];
	  $tournament_max_players		= $data['tournament_max_players'];
	  $player_pertable_minimum		= 2;
	  $player_pertable_maximum  	= $tournament_player_pertable;
	  /* EO: Player Section */

	  /* Entry criteria section */
	  $tournament_cash_type			= $data['tournament_cash_type'];

	  if($tournament_cash_type == 8){
	  	$tournament_amount			= 1;
	  	$tournament_commision		= 0;
	  }else if($tournament_cash_type == 7){
	  	$tournament_amount			= $data['tournament_amount'];
	  	$tournament_commision		= 0;
	  }else{
	    $tournament_amount			= $data['tournament_amount'];
	  	$tournament_commision		= $data['tournament_commision'];
	  }



	  $entry_fee					= $this->calPercentage($tournament_commision,$tournament_amount,2);
	  if($tournament_cash_type == 7){
	  	$loyalty_start_date			= $this->convertDateIntoNeedFormate($data['loyalty_start_date']);
	  	$loyalty_end_date			= $this->convertDateIntoNeedFormate($data['loyalty_end_date']);
	  }else{
	    $loyalty_start_date			= "";
	  	$loyalty_end_date			= "";
	  }
	  /* EO: Entry Criteria Section */

	  /* Blind Structure */
	  $tournament_start_blinds		= $data['tournament_start_blinds'];
	  $start_small_blind            = $this->getSmallBlindByLevel($tournament_start_blinds);
	  $start_big_blind				= $this->getBigBlindByLevel($tournament_start_blinds);
	  $tournament_bind_increment_time=$data['tournament_bind_increment_time'];
	  $tournament_start_chip_amount	 = $data['tournament_start_chip_amount'];
	  /*EO Blind Structure */

	  /* Time Settings */
	  $tournament_turn_time			= $data['tournament_turn_time'];
	  $tournament_discount_time		= $data['tournament_discount_time'];
	  $tournament_extra_time		= $data['tournament_extra_time'];
	  $tournament_max_cap			= $data['tournament_max_cap'];
	  $tournament_blind_level		= $data['tournament_blind_level'];
	  $tournament_add_on			= $data['tournament_add_on'];
	  /* EO: Time Settings*/


	  $prize_structure				= $data['prize_type'];
	  if($data['maingame_tournament_type']==2) {
	    // $tournamet_game_type 		= $data['satellite_tournament_game_type'];
	 	 $prize_type				=  8;
		 $tournament_prize_pool		= 0;
		 $parent_tournament_id 		= $data['main_tournament'];
		 $ticket_value   			= $this->getParentInformation($parent_tournament_id);
		 $tournament_prize_pool		= $ticket_value;
		 $tournament_ticket			= $ticket_value;
	  }else {
	  	$prize_type					= $data['tournamet_prize_type'];
		$tournament_prize_pool		= $data['tournament_prize_pool'];
		$tournament_ticket			= $data['tournament_ticket'];
	  }
	  //$prize_type					= $data['tournamet_prize_type'];
	  //$tournament_ticket			= $data['tournament_ticket'];
	  if($prize_structure == 1){
	  	$tournament_places_paid		= $data['tournament_places_paid'];
	  }else{
	    $tournament_places_paid		= 3;
	  }
	 // $tournament_prize_pool		= $data['tournament_prize_pool'];


	  /* Some default values */
	  $is_register_game 			= IS_REGISTER_GAME;
	  $tournament_break_time 		= TOURNAMENT_BREAK_TIME;
	  $break_interval_time			= BREAK_INTERVAL_TIME;
	  $paid_option 					= PAID_OPTION;
	  $allowOfflinePlayers  		= ALLOW_OFFLINE_PLAYERS;
	  $currentLevel 				= CURRENT_LEVEL;
	  $stackLevel                   = STAKE_LEVELS;
	  $tournamentStatus 			= TOURNAMENT_STATUS;
	  $minigame_id					= MINIGAMES_ID;
	  /* EO: default values */


	  $is_active 					= $tournamet_gamestatus;
	  $created_date 				= date("Y-m-d H:i:s");
	  $prizeCoinType  				= $tournament_cash_type;
	  $prizeBalanceType				= $data['prize_balance_type'];

	  //REbuy and Addon settings

	$rebuy_setting			= $data['rebuy_setting'];
	/*
	   * Server side checking for rebuy & addon values...................................
	   * If coin type is VIP = 7 or Ticket = 8 then rebuy/addon features will be disabled
	   * If tounament is freeroll means tournament amount = 0 then rebuy/addon feaures are disabled
	   * If the rebuy-addon setting is not enabled then rebuy/addon features are disabled
	  */
	if($tournament_cash_type == 7 || $tournament_cash_type == 8 ){
		$is_rebuy				= 0;
		$is_addon				= 0;
		$rebuy_chips_to_granted = 0;
		$rebuy_eligible_chips 	= 0;
		$rebuy_timeperiod 		= 0;
		$rebuy_num_rebuy 		= 0;
		$rebuy_amount 			= 0;
		$rebuy_entryfee 		= 0;
		$addon_chips_to_granted = 0;
		$addon_amount 			= 0;
		$addon_entryfee 		= 0;
		$addon_timeperiod 		= 0;
	}else{
		if($tournament_amount > 0){
			if($rebuy_setting == 1){
				$is_rebuy				= 1;
				$is_addon				= 1;
				$rebuy_chips_to_granted = $data['rebuy_chips_to_granted'];
				$rebuy_eligible_chips 	= $data['rebuy_eligible_chips'];
				$rebuy_timeperiod 		= $data['rebuy_timeperiod'];
				$rebuy_num_rebuy 		= $data['rebuy_num_rebuy'];
				$rebuy_amount 			= $data['rebuy_amount'];
				$rebuy_entryfee 		= $data['rebuy_entryfee'];
				if($data['double_rebuy']=='on') {
					$double_rebuy 		= 1;
				}else {
					$double_rebuy 		= '0';
				}
				$addon_chips_to_granted = $data['addon_chips_to_granted'];
				$addon_amount 			= $data['addon_amount'];
				$addon_entryfee 		= $data['addon_entryfee'];
				$addon_timeperiod 		= $data['addon_timeperiod'];
			}else if($rebuy_setting == 2){
			    $is_rebuy				= 1;
				$is_addon				= 0;
				$rebuy_chips_to_granted = $data['rebuy_chips_to_granted'];
				$rebuy_eligible_chips 	= 0;
				$rebuy_timeperiod 		= $data['rebuy_timeperiod'];
				$rebuy_num_rebuy 		= $data['rebuy_num_rebuy'];
				$rebuy_amount 			= $data['rebuy_amount'];
				$rebuy_entryfee 		= $data['rebuy_entryfee'];
				$double_rebuy 			= '0';
				$addon_chips_to_granted = 0;
				$addon_amount 			= 0;
				$addon_entryfee 		= 0;
				$addon_timeperiod 		= 0;
			}else{
				$is_rebuy				= 0;
				$is_addon				= 0;
				$rebuy_chips_to_granted = 0;
				$rebuy_eligible_chips 	= 0;
				$rebuy_timeperiod 		= 0;
				$rebuy_num_rebuy 		= 0;
				$rebuy_amount 			= 0;
				$rebuy_entryfee 		= 0;
				$addon_chips_to_granted = 0;
				$addon_amount 			= 0;
				$addon_entryfee 		= 0;
				$addon_timeperiod 		= 0;
			}
		}else{
				$is_rebuy				= 0;
				$is_addon				= 0;
				$rebuy_chips_to_granted = 0;
				$rebuy_eligible_chips 	= 0;
				$rebuy_timeperiod 		= 0;
				$rebuy_num_rebuy 		= 0;
				$rebuy_amount 			= 0;
				$rebuy_entryfee 		= 0;
				$addon_chips_to_granted = 0;
				$addon_amount 			= 0;
				$addon_entryfee 		= 0;
				$addon_timeperiod 		= 0;
		}
   }

	  $tournament_description           = $data['tournament_description'];
	  if($tournament_description != '')
	  	$tournamentDesc = $tournament_description;
	  else
	  	$tournamentDesc = '';

	 $is_deposit_balance  =  $data['is_deposit_balance'];
	 $is_promo_balance	  =  $data['is_promo_balance'];
	 $is_win_balance 	  =  $data['is_win_balance'];

     if($is_deposit_balance == 'on'){  $isDepositBalance = 1; }else{ $isDepositBalance = 0;	}
	 if($is_promo_balance == 'on'){    $isPromoBalance = 1; }else{ $isPromoBalance = 0;	}
	 if($is_win_balance == 'on'){  $isWinBalance = 1; }else{ $isWinBalance = 0;	}

	  //insert fields
	  if($data['tournament_name'] !='' && $data['tournament_date'] !='' && $data['tournament_reg_start_date'] !='' && $data['tournament_min_players'] !='' && $data['tournament_max_players']!='' && $data['tournament_start_chip_amount'] !=''){

		$tournament_server = $data['tournament_server'];

	  	$insertData = array(
			   'FK_PARENT_TOURNAMENT_ID' => $parent_tournament_id,
			   'TOURNAMENT_TYPE_ID'		=> $tournament_type,
			   'MINIGAMES_ID'        	=> $minigame_id ,
			   'MINI_GAME_TYPE_ID'   	=> $tournamet_game_type,
			   'TOURNAMENT_LIMIT_ID' 	=> $tournamet_limit,
			   'COIN_TYPE_ID'        	=> $tournament_cash_type,
			   'LOBBY_ID'        	 	=> $tournament_lobby_id ,
			   'LOBBY_MENU_ID'       	=> $tournament_lobby_menu_id,
			   'TOURNAMENT_NAME'		=> $tournament_name,
			   'TOURNAMENT_DESC'		=> $tournamentDesc,
			   'T_MIN_PLAYERS'        	=> $tournament_min_players,
			   'T_MAX_PLAYERS'     		=> $tournament_max_players,
			   'MIN_PLAYERS'        	=> $player_pertable_minimum,
			   'MAX_PLAYERS'       		=> $player_pertable_maximum,
			   'PLAYER_PER_TABLE'  		=> $tournament_player_pertable,
			   'SMALL_BLIND'			=> $start_small_blind,
			   'BIG_BLIND'				=> $start_big_blind,
			   'BUYIN'					=> $tournament_amount,
			   'PLAYER_HAND_TIME'		=> $tournament_turn_time,
			   'EXTRA_TIME'				=> $tournament_extra_time,
			   'SITOUT_TIME'			=> SITEOUT_TIME,
			   'TIME_BANK_INTERVAL_TIME'=> TIME_BANK_INTERVAL_TIME,
			   'DISCONNECT_TIME'		=> $tournament_discount_time,
			   'TOURNAMENT_CHIPS'		=> $tournament_start_chip_amount,
			   'ENTRY_FEE'				=> $entry_fee,
			   'TOURNAMENT_COMMISION'	=> $tournament_commision,
			   'IS_REGISTER_GAME'		=> $is_register_game,
			   'REGISTER_START_TIME'	=> $register_start_time,
			   'REGISTER_END_TIME'		=> $register_end_time,
			   'TOURNAMENT_START_TIME'	=> $tournament_start_time,
			   'TOURNAMENT_BREAK_TIME'	=> $tournament_break_time,
			   'BREAK_INTERVAL_TIME'	=> $break_interval_time,
			   'PAID_OPTION'			=> $paid_option,
			   'STAKE_LEVELS'			=> $stackLevel,
			   'NO_OF_WINNERS'			=> $tournament_places_paid,
			   'LATE_REGISTRATION_ALLOW' => $late_registration,
			   'LATE_REGISTRATION_END_TIME'	=> $tournament_reg_ends,
			   'ALLOW_OFFLINE_PLAYERS'	=> $allowOfflinePlayers,
			   'PRIZE_TYPE'				=> $prize_type,
			   'PRIZE_COIN_TYPE_ID'		=> $prize_type,
			   'TICKET_VALUE'			=> $tournament_ticket,
			   'PRIZE_STRUCTURE_ID'		=> $prize_structure,
			   'GUARENTIED_PRIZE'		=> $tournament_prize_pool,
			   'PARTNER_ID'				=> ADMIN_USER_ID,
			   'IS_ACTIVE'        		=> $is_active,
			   'TOURNAMENT_STATUS' 		=> $tournamentStatus,
			   'PRIZE_BALANCE_TYPE'     => $prizeBalanceType,
			   'IS_REBUY'     			=> $is_rebuy,
			   'REBUY_IN'     			=> $rebuy_amount,
			   'REBUY_ENTRY_FEE'     	=> $rebuy_entryfee,
			   'REBUY_COUNT'     		=> $rebuy_num_rebuy,
			   'REBUY_CHIPS'     		=> $rebuy_chips_to_granted,
			   'REBUY_ELIGIBLE_CHIPS'   => $rebuy_eligible_chips,
			   'REBUY_END_TIME'     	=> $rebuy_timeperiod,
			   'IS_ADDON'     			=> $is_addon,
			   'ADDON_AMOUNT'     		=> $addon_amount,
			   'ADDON_COUNT'     		=> 1,
			   'ADDON_CHIPS'     		=> $addon_chips_to_granted,
			   'ADDON_ENTRY_FEE'		=> $addon_entryfee,
			   'ADDON_BREAK_TIME'       => $addon_timeperiod,
			   'DEPOSIT_BALANCE_ALLOW'  => $isDepositBalance,
			   'PROMO_BALANCE_ALLOW'    => $isPromoBalance,
			   'WIN_BALANCE_ALLOW'      => $isWinBalance,
			   'DOUBLE_REBUYIN'			=> $double_rebuy,
			   'ADDITIONAL_EXTRATIME'	=> $tournament_add_on,
			   'ADDITIONAL_EXTRATIME_LEVEL_INTERVAL' => $tournament_blind_level,
			   'PLAYER_MAX_EXTRATIME'	=> $tournament_max_cap,
			   'SERVER_ID'  => $tournament_server

			);


	   $this->db->set('CREATED_DATE', 'NOW()', FALSE);

	   if($tournament_cash_type == 7){
	   	 $this->db->set('LAYALTY_ELIGIBILITY_START_DATE', $loyalty_start_date);
		 $this->db->set('LAYALTY_ELIGIBILITY_END_DATE', $loyalty_end_date.' 23:59:59');
	   }

	  $res = $this->db->insert('tournament', $insertData);
	  $insert_id = $this->db->insert_id();
	  // $insert_id = 73;

	   if($insert_id != ''){
	     //insert blind structure
		 $this->insertTournamentBlindStructures($insert_id,$tournament_start_blinds,$tournament_bind_increment_time,$tournamet_game_type);

		 if($prize_structure == 1){
		    if($tournament_places_paid > 0){
			  for($no_winner=1;$no_winner<=$tournament_places_paid;$no_winner++){
			     $rank  			= $no_winner;
				  if($data['maingame_tournament_type']==2) {
					 $prize_value		= 1;
				   }else {
					 $prize_value 		= $this->calPercentage($data["tournament_prize_$no_winner"],$tournament_prize_pool,0);
			   	   }
				 $winner_percentage = $data["tournament_prize_$no_winner"];
				 $this->db->query("INSERT INTO `tournament_winner_level` (`TOURNAMENT_ID`,`RANK`,`PRIZE_VALUE`,`PRIZE_TYPE`,`WINNER_PERCENTAGE`) VALUES ('$insert_id','$no_winner','$prize_value','$prize_type','$winner_percentage')");
			  }
			}
		 }
	   }

	  }else{
	    redirect('games/poker/tournament/add?err=6&rid=43');
	  }//validation ends

	 // echo "success"; die;
	}

	public function updateTournament($tournament_id,$data){
	  //post data

	   /* Tournament Information Block */
	  $tournament_name 				= $data['tournament_name'];

	  if($data['maingame_tournament_type']==1) {
	     if($data['tournamet_game_type']==5) {
		 	$tournamet_game_type	= 1;
			$tournament_type 		= 2;
		 }else if($data['tournamet_game_type']==6) {
		 	$tournamet_game_type	= 2;
			$tournament_type 		= 2;
		 }else if($data['tournamet_game_type']==7) {
				$tournamet_game_type	= 1;
				$tournament_type 		= 2;
		}else if($data['tournamet_game_type']==8) {
				$tournamet_game_type	= 2;
				$tournament_type 		= 2;
		}else {
		 	 $tournamet_game_type 	= $data['tournamet_game_type'];//normal tournament
			 $tournament_type 		= DEFAULT_SCHEDULED_TOURNAMET_ID;
		 }
		 $prize_type				= $data['tournamet_prize_type'];
		 $tournament_prize_pool		= $data['tournament_prize_pool'];
		 $tournament_ticket			= $data['tournament_ticket'];
	  }else {
	  	 $tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
	  	 $tournamet_game_type 		= $data['tournamet_satellite_game_type'];//satellite tournament
		 $prize_type				= 8;
		 $tournament_prize_pool		= 0;
		 $parent_tournament_id 		= $data['main_tournament'];
		 $ticket_value   			= $this->getParentInformation($parent_tournament_id);
		 $tournament_prize_pool		= $ticket_value;
		 $tournament_ticket			= $ticket_value;
	  }

	  $tournament_lobby_id          = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP

	  if($tournamet_game_type == 1){
	    $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
	  }else if($tournamet_game_type == 2){
	    $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
	  }else if($tournamet_game_type == 3){
	  	 $tournament_lobby_id        = 3;
	  	 $tournament_lobby_menu_id   = 7;
	  }else if($tournamet_game_type == 4) {
	  	 $tournament_lobby_id        = 3;
	  	 $tournament_lobby_menu_id   = 8;
	  }else if($tournamet_game_type == 5) {
	  	$tournament_lobby_id        = TOURNAMENT_LOBBY_ID;
	  	$tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
	 }else if($tournamet_game_type == 6) {
	 	$tournament_lobby_id        = TOURNAMENT_LOBBY_ID;
	    $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
	 }
	  if($data['tournamet_game_type']==7) {
		$tournament_lobby_id 		= 3;
		$tournament_lobby_menu_id   = 7;
	 }else if($data['tournamet_game_type']==8){
		$tournament_lobby_id 		= 3;
		$tournament_lobby_menu_id   = 8;
	 }

	  if($data['tournamet_gamestatus'] != '')
      $tournamet_gamestatus 		= $data['tournamet_gamestatus'];
	  else
	  $tournamet_gamestatus 		= 1;

	  $tournamet_limit 				= $data['tournamet_limit'];
	  /* EO: Tournament Information Block */

	  /* Timing Information */
	  $tournament_date				= $data['tournament_date'];
	  $tournament_time 				= $data['tournament_time'];
  	  $tournament_reg_start_date	= $data['tournament_reg_start_date'];
	  $tournament_reg_start_time	= $data['tournament_reg_start_time'];
	  $tournament_late				= $data['tournament_late'];

	  $convertStringToTime			= $this->convertStringToTime($tournament_time);
	  $convertDateIntoNeedFormate	= $this->convertDateIntoNeedFormate($tournament_date);
	  $registerSTime				= $this->convertStringToTime($tournament_reg_start_time);
	  $registerSDdate 				= $this->convertDateIntoNeedFormate($tournament_reg_start_date);
	  $register_start_time			= $registerSDdate.' '.$registerSTime;
	  $tournament_start_time        = $convertDateIntoNeedFormate.' '.$convertStringToTime;
	  if($tournament_late == 'on'){
	    $register_end_time          = $tournament_start_time;//
		$tournament_reg_ends		= $data['tournament_reg_ends'];
		//$register_end_time          = $this->addTimeToDate($tournament_start_time,$tournament_reg_ends);
		$late_registration 		    = 1;
	  }else{
	    $register_end_time  		= $tournament_start_time;
		$late_registration 		    = 0;
		$tournament_reg_ends		= 0;
	  }
	  /* EO: Timing Information*/

      /* Player Section*/
	  $tournament_player_pertable	= $data['tournament_player_pertable'];
	  $tournament_min_players		= $data['tournament_min_players'];
	  $tournament_max_players		= $data['tournament_max_players'];
	  $player_pertable_minimum		= 2;
	  $player_pertable_maximum  	= $tournament_player_pertable;
	  /* EO: Player Section */

	  /* Entry criteria section */
	  $tournament_cash_type			= $data['tournament_cash_type'];

	  if($tournament_cash_type == 8){
	  	$tournament_amount			= 1;
	  	$tournament_commision		= 0;
	  }else if($tournament_cash_type == 7){
	  	$tournament_amount			= $data['tournament_amount'];
	  	$tournament_commision		= 0;
	  }else{
	    $tournament_amount			= $data['tournament_amount'];
	  	$tournament_commision		= $data['tournament_commision'];
	  }


	  $entry_fee					= $this->calPercentage($tournament_commision,$tournament_amount,2);
	  if($tournament_cash_type == 7){
	  	$loyalty_start_date			= $this->convertDateIntoNeedFormate($data['loyalty_start_date']);
	  	$loyalty_end_date			= $this->convertDateIntoNeedFormate($data['loyalty_end_date']);
	  }else{
	    $loyalty_start_date			= "";
	  	$loyalty_end_date			= "";
	  }
	  /* EO: Entry Criteria Section */

	  /* Blind Structure */
	  $tournament_start_blinds		= $data['tournament_start_blinds'];
	  $start_small_blind            = $this->getSmallBlindByLevel($tournament_start_blinds);
	  $start_big_blind				= $this->getBigBlindByLevel($tournament_start_blinds);
	  $tournament_bind_increment_time=$data['tournament_bind_increment_time'];
	  $tournament_start_chip_amount	 = $data['tournament_start_chip_amount'];
	  /*EO Blind Structure */

	  /* Time Settings */
	  $tournament_turn_time			= $data['tournament_turn_time'];
	  $tournament_discount_time		= $data['tournament_discount_time'];
	  $tournament_extra_time		= $data['tournament_extra_time'];
	  $tournament_max_cap			= $data['tournament_max_cap'];
	  $tournament_blind_level		= $data['tournament_blind_level'];
	  $tournament_add_on			= $data['tournament_add_on'];
	  /* EO: Time Settings*/


	  $prize_structure				= $data['prize_type'];
	  //$prize_type					= $data['tournamet_prize_type'];
	  //$tournament_ticket			= $data['tournament_ticket'];
	  if($prize_structure == 1){
	  	$tournament_places_paid		= $data['tournament_places_paid'];
	  }else{
	    $tournament_places_paid		= 3;
	  }
	 // $tournament_prize_pool		= $data['tournament_prize_pool'];

	  $is_active 					= $tournamet_gamestatus;
	  $created_date 				= date("Y-m-d H:i:s");
	  $prizeCoinType  				= $tournament_cash_type;
	  $prizeBalanceType				= $data['prize_balance_type'];

	  $rebuy_setting			= $data['rebuy_setting'];
	  /*
	   * Server side checking for rebuy & addon values...................................
	   * If coin type is VIP = 7 or Ticket = 8 then rebuy/addon features will be disabled
	   * If tounament is freeroll means tournament amount = 0 then rebuy/addon feaures are disabled
	   * If the rebuy-addon setting is not enabled then rebuy/addon features are disabled
	  */
	if($tournament_cash_type == 7 || $tournament_cash_type == 8 ){
		$is_rebuy				= 0;
		$is_addon				= 0;
		$rebuy_chips_to_granted = 0;
		$rebuy_eligible_chips 	= 0;
		$rebuy_timeperiod 		= 0;
		$rebuy_num_rebuy 		= 0;
		$rebuy_amount 			= 0;
		$rebuy_entryfee 		= 0;
		$addon_chips_to_granted = 0;
		$addon_amount 			= 0;
		$addon_entryfee 		= 0;
		$addon_timeperiod 		= 0;
	}else{
		if($tournament_amount > 0){
			if($rebuy_setting == 1){
				$is_rebuy				= 1;
				$is_addon				= 1;
				$rebuy_chips_to_granted = $data['rebuy_chips_to_granted'];
				$rebuy_eligible_chips 	= $data['rebuy_eligible_chips'];
				$rebuy_timeperiod 		= $data['rebuy_timeperiod'];
				$rebuy_num_rebuy 		= $data['rebuy_num_rebuy'];
				$rebuy_amount 			= $data['rebuy_amount'];
				$rebuy_entryfee 		= $data['rebuy_entryfee'];
				if($data['double_rebuy']=='on') {
					$double_rebuy 		= 1;
				}else {
					$double_rebuy 		= '0';
				}
				$addon_chips_to_granted = $data['addon_chips_to_granted'];
				$addon_amount 			= $data['addon_amount'];
				$addon_entryfee 		= $data['addon_entryfee'];
				$addon_timeperiod 		= $data['addon_timeperiod'];
			}else if($rebuy_setting == 2){
			   $is_rebuy				= 1;
				$is_addon				= 0;
				$rebuy_chips_to_granted = $data['rebuy_chips_to_granted'];
				$rebuy_eligible_chips 	= 0;
				$rebuy_timeperiod 		= $data['rebuy_timeperiod'];
				$rebuy_num_rebuy 		= $data['rebuy_num_rebuy'];
				$rebuy_amount 			= $data['rebuy_amount'];
				$rebuy_entryfee 		= $data['rebuy_entryfee'];
				$double_rebuy 			= '0';
				$addon_chips_to_granted = 0;
				$addon_amount 			= 0;
				$addon_entryfee 		= 0;
				$addon_timeperiod 		= 0;
			}else{
				$is_rebuy				= 0;
				$is_addon				= 0;
				$rebuy_chips_to_granted = 0;
				$rebuy_eligible_chips 	= 0;
				$rebuy_timeperiod 		= 0;
				$rebuy_num_rebuy 		= 0;
				$rebuy_amount 			= 0;
				$rebuy_entryfee 		= 0;
				$addon_chips_to_granted = 0;
				$addon_amount 			= 0;
				$addon_entryfee 		= 0;
				$addon_timeperiod 		= 0;
			}
		}else{
				$is_rebuy				= 0;
				$is_addon				= 0;
				$rebuy_chips_to_granted = 0;
				$rebuy_eligible_chips 	= 0;
				$rebuy_timeperiod 		= 0;
				$rebuy_num_rebuy 		= 0;
				$rebuy_amount 			= 0;
				$rebuy_entryfee 		= 0;
				$addon_chips_to_granted = 0;
				$addon_amount 			= 0;
				$addon_entryfee 		= 0;
				$addon_timeperiod 		= 0;
		}
   }
	  $tournament_description           = $data['tournament_description'];
	  if($tournament_description != '')
	  	$tournamentDesc = $tournament_description;
	  else
	  	$tournamentDesc = '';


	 $is_deposit_balance  =  $data['is_deposit_balance'];
	 $is_promo_balance	  =  $data['is_promo_balance'];
	 $is_win_balance 	  =  $data['is_win_balance'];

     if($is_deposit_balance == 'on'){  $isDepositBalance = 1; }else{ $isDepositBalance = 0;	}
	 if($is_promo_balance == 'on'){    $isPromoBalance = 1; }else{ $isPromoBalance = 0;	}
	 if($is_win_balance == 'on'){  $isWinBalance = 1; }else{ $isWinBalance = 0;	}

	  //insert fields
	  if($tournament_id !='' && $data['tournament_name'] !='' && $data['tournament_date'] !='' && $data['tournament_reg_start_date'] !='' && $data['tournament_min_players'] !='' && $data['tournament_max_players']!='' && $data['tournament_start_chip_amount'] !=''){

	$tournament_server = $data['tournament_server'];

	   if($data['tournament_status'] != 1){
	  	$updateData = array(
			   'FK_PARENT_TOURNAMENT_ID'=> $parent_tournament_id,
			   'TOURNAMENT_TYPE_ID'		=> $tournament_type,
			   'MINI_GAME_TYPE_ID'   	=> $tournamet_game_type,
			   'TOURNAMENT_LIMIT_ID' 	=> $tournamet_limit,
			   'COIN_TYPE_ID'        	=> $tournament_cash_type,
			   'LOBBY_ID'        	 	=> $tournament_lobby_id ,
			   'LOBBY_MENU_ID'       	=> $tournament_lobby_menu_id,
			   'TOURNAMENT_NAME'		=> $tournament_name,
			   'TOURNAMENT_DESC'		=> $tournamentDesc,
			   'T_MIN_PLAYERS'        	=> $tournament_min_players,
			   'T_MAX_PLAYERS'     		=> $tournament_max_players,
			   'MIN_PLAYERS'        	=> $player_pertable_minimum,
			   'MAX_PLAYERS'       		=> $player_pertable_maximum,
			   'PLAYER_PER_TABLE'  		=> $tournament_player_pertable,
			   'SMALL_BLIND'			=> $start_small_blind,
			   'BIG_BLIND'				=> $start_big_blind,
			   'BUYIN'					=> $tournament_amount,
			   'PLAYER_HAND_TIME'		=> $tournament_turn_time,
			   'EXTRA_TIME'				=> $tournament_extra_time,
			   'SITOUT_TIME'			=> SITEOUT_TIME,
			   'TIME_BANK_INTERVAL_TIME'=> TIME_BANK_INTERVAL_TIME,
			   'DISCONNECT_TIME'		=> $tournament_discount_time,
			   'TOURNAMENT_CHIPS'		=> $tournament_start_chip_amount,
			   'ENTRY_FEE'				=> $entry_fee,
			   'TOURNAMENT_COMMISION'	=> $tournament_commision,
			   'REGISTER_START_TIME'	=> $register_start_time,
			   'REGISTER_END_TIME'		=> $register_end_time,
			   'TOURNAMENT_START_TIME'	=> $tournament_start_time,
			   'NO_OF_WINNERS'			=> $tournament_places_paid,
			   'LATE_REGISTRATION_ALLOW' => $late_registration,
			   'LATE_REGISTRATION_END_TIME'	=> $tournament_reg_ends,
			   'PRIZE_TYPE'				=> $prize_type,
			   'PRIZE_COIN_TYPE_ID'		=> $prize_type,
			   'TICKET_VALUE'			=> $tournament_ticket,
			   'PRIZE_STRUCTURE_ID'		=> $prize_structure,
			   'GUARENTIED_PRIZE'		=> $tournament_prize_pool,
			   'PARTNER_ID'				=> ADMIN_USER_ID,
			   'IS_ACTIVE'        		=> $is_active,
			   'PRIZE_BALANCE_TYPE'     => $prizeBalanceType,
			   'IS_REBUY'     			=> $is_rebuy,
			   'REBUY_IN'     			=> $rebuy_amount,
			   'REBUY_ENTRY_FEE'     	=> $rebuy_entryfee,
			   'REBUY_COUNT'     		=> $rebuy_num_rebuy,
			   'REBUY_CHIPS'     		=> $rebuy_chips_to_granted,
			   'REBUY_ELIGIBLE_CHIPS'   => $rebuy_eligible_chips,
			   'REBUY_END_TIME'     	=> $rebuy_timeperiod,
			   'IS_ADDON'     			=> $is_addon,
			   'ADDON_AMOUNT'     		=> $addon_amount,
			   'ADDON_COUNT'     		=> 1,
			   'ADDON_CHIPS'     		=> $addon_chips_to_granted,
			   'ADDON_ENTRY_FEE'		=> $addon_entryfee,
			   'ADDON_BREAK_TIME'       => $addon_timeperiod,
			   'DEPOSIT_BALANCE_ALLOW'  => $isDepositBalance,
			   'PROMO_BALANCE_ALLOW'    => $isPromoBalance,
			   'WIN_BALANCE_ALLOW'      => $isWinBalance,
			   'DOUBLE_REBUYIN'			=> $double_rebuy,
			   'ADDITIONAL_EXTRATIME'	=> $tournament_add_on,
			   'ADDITIONAL_EXTRATIME_LEVEL_INTERVAL' => $tournament_blind_level,
			   'PLAYER_MAX_EXTRATIME'	=> 	$tournament_max_cap,
			   'SERVER_ID'  => $tournament_server
			);
	}else{
			$updateData = array(
			   'FK_PARENT_TOURNAMENT_ID'=> $parent_tournament_id,
			   'TOURNAMENT_TYPE_ID'		=> $tournament_type,
			   'MINI_GAME_TYPE_ID'   	=> $tournamet_game_type,
			   'TOURNAMENT_LIMIT_ID' 	=> $tournamet_limit,
			   'LOBBY_ID'        	 	=> $tournament_lobby_id ,
			   'LOBBY_MENU_ID'       	=> $tournament_lobby_menu_id,
			   'TOURNAMENT_NAME'		=> $tournament_name,
			   'TOURNAMENT_DESC'		=> $tournamentDesc,
			   'T_MIN_PLAYERS'        	=> $tournament_min_players,
			   'T_MAX_PLAYERS'     		=> $tournament_max_players,
			   'MIN_PLAYERS'        	=> $player_pertable_minimum,
			   'MAX_PLAYERS'       		=> $player_pertable_maximum,
			   'PLAYER_PER_TABLE'  		=> $tournament_player_pertable,
			   'SMALL_BLIND'			=> $start_small_blind,
			   'BIG_BLIND'				=> $start_big_blind,
			   'BUYIN'					=> $tournament_amount,
			   'PLAYER_HAND_TIME'		=> $tournament_turn_time,
			   'EXTRA_TIME'				=> $tournament_extra_time,
			   'SITOUT_TIME'			=> SITEOUT_TIME,
			   'TIME_BANK_INTERVAL_TIME'=> TIME_BANK_INTERVAL_TIME,
			   'DISCONNECT_TIME'		=> $tournament_discount_time,
			   'TOURNAMENT_CHIPS'		=> $tournament_start_chip_amount,
			   'REGISTER_START_TIME'	=> $register_start_time,
			   'REGISTER_END_TIME'		=> $register_end_time,
			   'TOURNAMENT_START_TIME'	=> $tournament_start_time,
			   'NO_OF_WINNERS'			=> $tournament_places_paid,
			   'LATE_REGISTRATION_ALLOW' => $late_registration,
			   'LATE_REGISTRATION_END_TIME'	=> $tournament_reg_ends,
			   'PRIZE_TYPE'				=> $prize_type,
			   'PRIZE_COIN_TYPE_ID'		=> $prize_type,
			   'TICKET_VALUE'			=> $tournament_ticket,
			   'PRIZE_STRUCTURE_ID'		=> $prize_structure,
			   'GUARENTIED_PRIZE'		=> $tournament_prize_pool,
			   'PARTNER_ID'				=> ADMIN_USER_ID,
			   'IS_ACTIVE'        		=> $is_active,
			   'PRIZE_BALANCE_TYPE'     => $prizeBalanceType,
			   'IS_REBUY'     			=> $is_rebuy,
			   'REBUY_IN'     			=> $rebuy_amount,
			   'REBUY_ENTRY_FEE'     	=> $rebuy_entryfee,
			   'REBUY_COUNT'     		=> $rebuy_num_rebuy,
			   'REBUY_CHIPS'     		=> $rebuy_chips_to_granted,
			   'REBUY_ELIGIBLE_CHIPS'   => $rebuy_eligible_chips,
			   'REBUY_END_TIME'     	=> $rebuy_timeperiod,
			   'IS_ADDON'     			=> $is_addon,
			   'ADDON_AMOUNT'     		=> $addon_amount,
			   'ADDON_COUNT'     		=> 1,
			   'ADDON_CHIPS'     		=> $addon_chips_to_granted,
			   'ADDON_ENTRY_FEE'		=> $addon_entryfee,
			   'ADDON_BREAK_TIME'       => $addon_timeperiod,
			   'DEPOSIT_BALANCE_ALLOW'  => $isDepositBalance,
			   'PROMO_BALANCE_ALLOW'    => $isPromoBalance,
			   'WIN_BALANCE_ALLOW'      => $isWinBalance,
			   'DOUBLE_REBUYIN'			=> $double_rebuy,
			   'ADDITIONAL_EXTRATIME'	=> $tournament_add_on,
			   'ADDITIONAL_EXTRATIME_LEVEL_INTERVAL' => $tournament_blind_level,
			   'PLAYER_MAX_EXTRATIME'	=> 	$tournament_max_cap,
			   'SERVER_ID'  => $tournament_server
			);
	}

		$this->db->set('UPDATED_DATE', 'NOW()', FALSE);

	   if($tournament_cash_type == 7){
	   	 $this->db->set('LAYALTY_ELIGIBILITY_START_DATE', $loyalty_start_date);
		 $this->db->set('LAYALTY_ELIGIBILITY_END_DATE', $loyalty_end_date.' 23:59:59');
	   }

	 $this->db->where('TOURNAMENT_ID', $tournament_id);
	 $res = $this->db->update('tournament', $updateData);

	 if($res){
			$err  = 1;
			//delete record in blind structure
			$this->deleteTournamentBlindStructures($tournament_id);
			//insert record in blind structure
			$this->insertTournamentBlindStructures($tournament_id,$tournament_start_blinds,$tournament_bind_increment_time,$tournamet_game_type);
			$this->deleteTournamentPrizeStructures($tournament_id);
			 if($prize_structure == 1){
				//delete tournament prize sturcet

				//insert tournament prize structure
				if($tournament_places_paid > 0){
				  for($no_winner=1;$no_winner<=$tournament_places_paid;$no_winner++){
					 $rank  			= $no_winner;
					   if($data['maingame_tournament_type']==2) {
						 $prize_value		=1;
					   }else {
						 $prize_value 		= $this->calPercentage($data["tournament_prize_$no_winner"],$tournament_prize_pool,0);
					   }
					// $prize_value 		= $this->calPercentage($data["tournament_prize_$no_winner"],$tournament_prize_pool,0);
					 $winner_percentage = $data["tournament_prize_$no_winner"];
					 $this->db->query("INSERT INTO `tournament_winner_level` (`TOURNAMENT_ID`,`RANK`,`PRIZE_VALUE`,`PRIZE_TYPE`,`WINNER_PERCENTAGE`) VALUES ('$tournament_id','$no_winner','$prize_value','$prize_type','$winner_percentage')");
				  }
				}
			 }
	   }
	 }else{
	   //if validation wrong
	}
  }



	public function insertTournamentBlindStructures($insert_id,$levelid,$increment_time,$minigames_type_id){
		 $blindInfo  = $this->getBlindStructuresAfterLevel($levelid);
		 $numRow = count($blindInfo);
		 if($numRow > 0){
		   $i = 1;
		   foreach($blindInfo as $levels){

			 $smallBlind  = $levels->SMALL_BLIND;
			 $bigBlind	  = $levels->BIG_BLIND;
			 $ante		  = $levels->ANTE;
			 $timeBank	  = $levels->TIME_BANK;

			 $this->db->query("INSERT INTO `tournament_levels` (`TOURNAMENT_ID`,`MINIGAMES_TYPE_ID`,`STAKE_LEVELS`,`SMALL_BLIND`,`BIG_BLIND`,`ANTE`,`LEVEL_BREAK_TIME`,`TIME_BANK`,`LEVEL_PERIOD`) VALUES ('$insert_id','$minigames_type_id','$i','$smallBlind','$bigBlind','$ante',0,'$timeBank','$increment_time')");
			 $i++;
		   }

		 }
	}

   public function convertStringToArray($string){
	  $convertString = '';
	  if($string != ''){
	     $convertString  = explode(",",$string);
	  }
	  return $convertString;
	}

   public function getTournamentListBySearchCriteria($searchData=array(),$limitend,$limitstart){
	  $this->load->database();
	  if($searchData['GAME_TYPE']=="Texas Hold'em"){
	  		$game_type=1;
	  }elseif($searchData['GAME_TYPE']=="Omaha"){
	  		$game_type=2;
	  }
	  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";

			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$game_type.'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$game_type.'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  	}
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					    $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."'";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
			  if($searchData['STATUS'] == 2){
			    $status = 0;
			  }else{
			     $status = $searchData['STATUS'];
			  }


				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){



					  $conQuery .= "  t.IS_ACTIVE = '".$status."'";
				}else{
					 if($conQuery != ''){
					  $conQuery .= " AND t.IS_ACTIVE = '".$status."'";
					 }else{
					    if($conQuery != ''){
						  $conQuery .= " AND t.IS_ACTIVE = '".$status."'";
						 }else{
						   $conQuery .= " t.IS_ACTIVE = '".$status."'";
						 }
					 }
			    }
			}

			$sql = 	$conQuery;

			//echo "select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.TOURNAMENT_COMMISION,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.IS_ACTIVE,t.RAKE from tournament t,minigames_type m,tournament_limit tl where $sql and t.TOURNAMENT_TYPE_ID IN (3,4) and t.LOBBY_ID=2 and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_ID limit $limitstart,$limitend";

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.LOBBY_ID,t.TOURNAMENT_TYPE_ID,t.COIN_TYPE_ID,t.MINI_GAME_TYPE_ID,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.TOURNAMENT_COMMISION,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.IS_ACTIVE,t.RAKE from tournament t,minigames_type m,tournament_limit tl where $sql and t.TOURNAMENT_TYPE_ID IN (2,3,4) and t.LOBBY_ID IN (2,3) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}else{

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.LOBBY_ID,t.TOURNAMENT_TYPE_ID,t.COIN_TYPE_ID,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.TOURNAMENT_COMMISION,t.IS_ACTIVE,t.RAKE from tournament t,minigames_type m,tournament_limit tl where t.LOBBY_ID IN (2,3) and t.TOURNAMENT_TYPE_ID IN (2,3,4) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}

	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}



	public function getTournamentListCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database();
		if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					  $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
			  if($searchData['STATUS'] == 2){
			    $status = 0;
			  }else{
			     $status = $searchData['STATUS'];
			  }


				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){



					  $conQuery .= "  t.IS_ACTIVE = '".$status."'";
				}else{
					 if($conQuery != ''){
					  $conQuery .= " AND t.IS_ACTIVE = '".$status."'";
					 }else{
					    if($conQuery != ''){
						  $conQuery .= " AND t.IS_ACTIVE = '".$status."'";
						 }else{
						   $conQuery .= " t.IS_ACTIVE = '".$status."'";
						 }
					 }
			    }
			}


			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament t,minigames_type m,tournament_limit tl  where $sql and t.TOURNAMENT_TYPE_ID IN (2,3,4) and t.LOBBY_ID IN (2,3) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");

		}else{
			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament t,minigames_type m,tournament_limit tl where t.LOBBY_ID IN (2,3) and t.TOURNAMENT_TYPE_ID IN (2,3,4) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}

	public function deleteTournamentTable($tournamentID) {
	//echo $tournamentID; exit;
		//delete from tournament winner level
		/*$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_winner_level');
		//delete from tournament_tables
		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_tables');
        //delete from tournament levels
		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_levels');
		//delete from tournament table
		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament');			*/

		$this->db->query("update tournament set IS_ACTIVE = 0 where TOURNAMENT_ID = $tournamentID");

	}

	public function getTournamentById($tournamentID){
		$this->load->database();
        $res=$this->db2->query("Select * from tournament where TOURNAMENT_ID = $tournamentID and TOURNAMENT_TYPE_ID IN (2,3,4)");
        $gameInfo  =  $res->row();
		return $gameInfo;
	}

  	public function getTournamentBlindIncrementTime($tournamentID){
		$this->db2->where('TOURNAMENT_ID', $tournamentID);
	    $browseSQL = $this->db2->get('tournament_levels');
		$rsResult  = $browseSQL->row();
		$blindIncrementValue  = $rsResult->LEVEL_PERIOD;
		return $blindIncrementValue;
	}

	public function convert24Hto12H($time){
	  return date("h:i A",strtotime($time));
	}

	public function getMinutestBetweenDates($tournamentStartDate,$registrationEndsDate){
		$date1Timestamp = strtotime($tournamentStartDate);
		$date2Timestamp = strtotime($registrationEndsDate);
 		if($tournamentStartDate != '' && $registrationEndsDate != ''){
			$difference = $date2Timestamp - $date1Timestamp;
 			$time =  date("H:i:s",$difference);
		}else{
		    $time = 0;
		}
		return $this->hoursToMinutes($time);
	}

	public function hoursToMinutes($hours)
	{
		$minutes = 0;
		if (strpos($hours, ':') !== false)
		{
			list($hours, $minutes) = explode(':', $hours);
		}
		return $hours * 60 + $minutes;
	}

	public function getWinnerPercentageByRank($rank,$tournamentID){
	    $res=$this->db2->query("SELECT * FROM `tournament_winner_level` where tournament_id = $tournamentID and rank = $rank");
        $rankInfo  =  $res->row();
		$percentage = $rankInfo->WINNER_PERCENTAGE;
		return $percentage;
	}

	public function deleteTournamentPrizeStructures($tournamentID){
		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_winner_level');
	}

	public function deleteTournamentBlindStructures($tournamentID){
	    $this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_levels');
	}

  /* Newly added after first iteration */
	public function getAllEntryCriteria() {
		$browseSQL = $this->db2->get('tournament_entry_criteria');
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

	public function getAllPrizeStructures() {
		$browseSQL = $this->db2->get('tournament_prize_structures');
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

	public function getAllExtraModules() {
		$browseSQL = $this->db2->get('tournament_extra_modules');
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

	public function getTournamentStatusName($status_id){
		if($status_id != ''){
			switch ($status_id) {
				case 0:
					$statusName = 'Announced';
					break;
				case 1:
					$statusName = 'Registering';
					break;
				case 2:
					$statusName = 'Seating';
					break;
				case 3:
					$statusName = 'Started';
					break;
				case 4:
					$statusName = 'Breaking';
					break;
				case 5:
					$statusName = 'Finished';
					break;
				case 6:
					$statusName = 'Cancelled';
					break;
				default:
					$statusName = 'Announced';
			}
	    }else{
		  $statusName = '';
		}
		return $statusName;
	}

	public function cancelTournament($formdata){
	  $tournament_id = $formdata['tournament_id'];
	  if($tournament_id != ''){
	  	$desc_reason = $formdata['desc_reason'];
	 	$data = array('CANCEL_REASON' => $desc_reason);
		$whereData = array('TOURNAMENT_ID' => $tournament_id);
	 	$this->db->where($whereData);
	 	$res = $this->db->update('tournament', $data);

	  //call sp_tournament_deactive_and_cancelled(11571);

	   //cancell tournament and all the tables using stored procedure
	   $queryTI = "call sp_tournament_deactive_and_cancelled($tournament_id);";
	   $this->sp_model->executeSPQuery($queryTI);

	  }else{
	    $res = "";
	  }

	  return $res;
	}

	public function cancelTournamentOld($formdata){
		$tournament_id = $formdata['tournament_id'];
		$desc_reason = $formdata['desc_reason'];
		$data = array(
		   'TOURNAMENT_STATUS' => 6,
		   'CANCEL_REASON' => $desc_reason
		);


		$whereData = array('TOURNAMENT_ID' => $tournament_id);
		$this->db->where($whereData);
		$res = $this->db->update('tournament', $data);
		//echo $this->db->last_query();

		return $res;
	}

	public function getTournaemntCancelReason($tournament_id){
		$this->db2->where('TOURNAMENT_ID',$tournament_id);
		$browseSQL = $this->db2->get('tournament');
		return $browseSQL->result();
	}

	public function getPartnerEntryCriteria($partner_id){
		$rsResult = "";
		//check partner available tournament types
		$partnerEnryCriteria = $this->chkPartnerAvailableEntryCriteria($partner_id);
		if($partnerEnryCriteria != ''){
			$tourEntryCriterias = $this->convertStringToArray($partnerEnryCriteria);
			$this->db2->where_in('TOURNAMENT_ENTRY_CRITERIA_ID', $tourEntryCriterias);
			$browseSQL = $this->db2->get('tournament_entry_criteria');
			//echo $this->db->last_query(); die;
			$rsResult  = $browseSQL->result();
		}

		return $rsResult;
	}

	public function chkPartnerAvailableEntryCriteria($partner_id){
	    $this->db2->where("PARTNER_ID",$partner_id);
	    $browseSQL = $this->db2->get('tournament_partner_features');
		$rsResult  = $browseSQL->row();
		$tournament_prize_structures  = $rsResult->TOURNAMENT_ENTRY_CRITERIA;

		return $tournament_prize_structures;
	}

	public function chkPartnerTournamentFeatures($partner_id){
	    $this->db2->where("PARTNER_ID",$partner_id);
	    $browseSQL = $this->db2->get('tournament_partner_features');
		$rsResult  = $browseSQL->row();
		//echo $this->db->last_query();
		$numRows   = count($rsResult);
		if($numRows > 0){
		  $flag = 1;
		}else{
		  $flag = 0;
		}

		return $flag;
	}

	 public function getAllTournamentsByStatus($status) {
		$types = array(2,3,4);
    $lobby_id = array(2,3,5,6,7,8);
		$this->db2->where("TOURNAMENT_STATUS",$status);
		$this->db2->where_in("TOURNAMENT_TYPE_ID",$types);
		$this->db2->where_in("LOBBY_ID",$lobby_id);
		$this->db2->where("IS_ACTIVE",1);

		$browseSQL = $this->db2->get('tournament');
		//echo $this->db2->last_query(); die;
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

	public function chkUserAlreadyRegister($user_id,$tournament_id) {
		$this->db2->where("tournament_id",$tournament_id);
		$this->db2->where("user_id",$user_id);
		$browseSQL = $this->db2->get('tournament_user_ticket');
		$rsResult  = $browseSQL->result();
		$countResult = count($rsResult);
		return $countResult;
	}

  public function getTournamentGameTypeCode($tournament_id){
	 $res=$this->db2->query("select t.mini_game_type_id,t.tournament_id,mt.ref_game_code from tournament t, minigames_type mt where t.tournament_id = $tournament_id and mt.minigames_type_id = t.mini_game_type_id");
     $refCode  =  $res->row();
	 return $refCode;
  }

  public function getAllPlayGroupIds($searchGameData){
		$allPlayGroupIDs ="";
		$this->db3->select("p.PLAY_GROUP_ID")->from('tournament_game_transaction_history p');
		if(!empty($searchGameData["PLAYER_ID"])) {
			$userID = $this->game_model->getUserId($searchGameData['PLAYER_ID']);
			$this->db3->where('p.USER_ID', $userID);
		}
		if(!empty($searchGameData["HAND_ID"]))
			$this->db3->where('p.INTERNAL_REFFERENCE_NO', $searchGameData["HAND_ID"]);

		if(!empty($searchGameData["START_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
		if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

		$browseSQL   = $this->db3->get();
		//echo $this->db3->last_query(); 
		$playGroupIDs= $browseSQL->result();
		$allPlayGroupIDs = "";
		if(!empty($playGroupIDs)) {
			foreach($playGroupIDs as $pIndex=>$playGroupData) {
				$allPlayGroupIDs[] = $playGroupData->PLAY_GROUP_ID;
			}
		}
		return $allPlayGroupIDs;
  }

  public function getSearchTournamentCount($searchGameData) {
		if($this->session->userdata('searchTournamentDetails')!="") {
			$searchGameData = $this->session->userdata('searchTournamentDetails');
		}

		if(!empty($searchGameData["PLAYER_ID"]) || !empty($searchGameData["HAND_ID"])) {
			//get all the playgroup ids
			$allPlayGroupIDs = $this->getAllPlayGroupIds($searchGameData);
			$tournamentID="";
			if(!empty($searchGameData["TABLE_ID"])) {
				$getTournamentID = $this->getTournamentIDByName($searchGameData["TABLE_ID"]);
				if(!empty($getTournamentID))
					$tournamentID = $getTournamentID[0]->tournament_id;
				else
					$tournamentID = "00";
			}

			if(!empty($allPlayGroupIDs)){
				$this->db3->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".
								   "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,".
								   "g.TOURNAMENT_ID")->from('tournament_game_history g');
				//$this->db3->join('tournament_tables tt', 'g.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
				//$this->db3->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
				//$this->db3->where('t.IS_ACTIVE',1);
				//$this->db3->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
				$this->db3->where_in('g.PLAY_GROUP_ID', $allPlayGroupIDs);
				if(!empty($tournamentID))
					$this->db3->where('g.TOURNAMENT_ID', $tournamentID);
				if(!empty($searchGameData["GAME_TYPE"]))
					$this->db3->where('g.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
				if(!empty($searchGameData["GAME_ID"]))
					$this->db3->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
				//if(!empty($searchGameData["CURRENCY_TYPE"]))
				//	$this->db3->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
				if(!empty($searchGameData["STAKE"]))
					$this->db3->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
				if(!empty($searchGameData["START_DATE_TIME"]))
					$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
				if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
					$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

				$browseSQL = $this->db3->get();
				//echo $this->db3->last_query(); die;
				return $browseSQL->num_rows();
		   }else{
		     return '';
		   }
		} else {
      //echo "test"; die;
			$tournamentID="";
			if(!empty($searchGameData["TABLE_ID"])) {
				$getTournamentID = $this->getTournamentIDByName($searchGameData["TABLE_ID"]);
				if(!empty($getTournamentID))
					$tournamentID = $getTournamentID[0]->tournament_id;
				else
					$tournamentID = "00";
			}
      //echo $tournamentID; die;
			$this->db3->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,".
					           "g.TOTAL_WIN,g.TOURNAMENT_ID")->from('tournament_game_history g'); //t.SMALL_BLIND,t.BIG_BLIND
			//$this->db3->join('tournament_tables tt', 'g.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db2->where('t.IS_ACTIVE',1);
			//$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			if(!empty($tournamentID))
				$this->db3->where('g.TOURNAMENT_ID', $tournamentID);
			if(!empty($searchGameData["GAME_TYPE"]))
				$this->db3->where('g.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db3->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			//if(!empty($searchGameData["CURRENCY_TYPE"]))
			//	$this->db2->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db3->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query(); die;
			return $browseSQL->num_rows();
		}
	}

  public function getTournamentIDByName($touranmentName) {
  		$this->db2->select('tournament_id,tournament_name')->from('tournament');
  		$this->db2->where('tournament_name',$touranmentName);
  		$browseSQL=$this->db2->get();
  		$rsResult  = $browseSQL->result();
		//echo $this->db3->last_query();
  		return $rsResult;
  	}
 
  

  public function getSearchTournamentData($config,$searchGameData) {
		if($this->session->userdata('searchTournamentDetails')!="") {
			$searchGameData = $this->session->userdata('searchTournamentDetails');
		}
		$limit = $config["per_page"];
		$offset = $config["cur_page"];



		if(!empty($searchGameData["PLAYER_ID"]) || !empty($searchGameData["HAND_ID"])) {

			$allPlayGroupIDs = $this->getAllPlayGroupIds($searchGameData);
			$tournamentID="";
			if(!empty($searchGameData["TABLE_ID"])) {
				$getTournamentID = $this->getTournamentIDByName($searchGameData["TABLE_ID"]);

				if(!empty($getTournamentID))
					$tournamentID = $getTournamentID[0]->tournament_id;
				else
					$tournamentID = "00";
			}
			if(!empty($allPlayGroupIDs)){
			$this->db3->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".
							   "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,".
							   "g.TOURNAMENT_ID")->from('tournament_game_history g');
			//$this->db3->join('tournament_tables tt', 'g.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db2->where('t.IS_ACTIVE',1);
			//$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			$this->db3->where_in('g.PLAY_GROUP_ID', $allPlayGroupIDs);
			if(!empty($tournamentID))
				$this->db3->where_in('g.TOURNAMENT_ID', $getTournamentID);
			if(!empty($searchGameData["GAME_TYPE"]))
				$this->db3->where('g.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db3->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			//if(!empty($searchGameData["CURRENCY_TYPE"]))
			//	$this->db3->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db3->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db3->order_by('g.GAME_HISTORY_ID','desc');
			$this->db3->limit($limit,$offset);

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();  

			return $browseSQL->result();
			}else
			{
			  return '';
			}
		} else {
			$tournamentID="";
			if(!empty($searchGameData["TABLE_ID"])) {
				$getTournamentID = $this->getTournamentIDByName($searchGameData["TABLE_ID"]);

				if(!empty($getTournamentID))
					$tournamentID = $getTournamentID[0]->tournament_id;
				else
					$tournamentID = "00";
			}
			$this->db3->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".
							   "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,".
							   "g.TOURNAMENT_ID")->from('tournament_game_history g');
			//$this->db3->join('tournament_tables tt', 'g.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db3->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db3->where('t.IS_ACTIVE',1);
			//$this->db3->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			if(!empty($tournamentID))
				$this->db3->where('g.TOURNAMENT_ID', $tournamentID);
			if(!empty($searchGameData["GAME_TYPE"]))
				$this->db3->where('g.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db3->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			//if(!empty($searchGameData["CURRENCY_TYPE"]))
			//	$this->db3->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db3->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db3->order_by('g.GAME_HISTORY_ID','desc');
			$this->db3->limit($limit,$offset);
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();
			
			return $browseSQL->result();
		}
	}

	public function getSearchTournamentData_old($config,$searchGameData) {
		if($this->session->userdata('searchTournamentDetails')!="") {
			$searchGameData = $this->session->userdata('searchTournamentDetails');
		}
		$limit = $config["per_page"];
		$offset = $config["cur_page"];

		if(!empty($searchGameData["PLAYER_ID"]) || !empty($searchGameData["HAND_ID"])) {

			$allPlayGroupIDs = $this->getAllPlayGroupIds($searchGameData);

			if(!empty($allPlayGroupIDs)){
			$this->db2->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".						 			                          "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,tt.TOURNAMENT_NAME,".
							  "t.SMALL_BLIND,t.BIG_BLIND,c.NAME as CURRENCY_TYPE")->from('tournament_game_history g');
			$this->db2->join('tournament_tables tt', 'tt.TOURNAMENT_TABLE_ID = g.TOURNAMENT_TABLE_ID', 'left');
			$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			$this->db2->where_in('g.PLAY_GROUP_ID', $allPlayGroupIDs);
			if(!empty($searchGameData["TABLE_ID"]))
				$this->db2->where('t.TOURNAMENT_NAME', $searchGameData["TABLE_ID"]);
			if(!empty($searchGameData["GAME_TYPE"]))
				$this->db2->where('t.MINI_GAME_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db2->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			if(!empty($searchGameData["CURRENCY_TYPE"]))
				$this->db2->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db2->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db2->order_by('g.GAME_HISTORY_ID','desc');
			$this->db2->limit($limit,$offset);

			$browseSQL = $this->db2->get();
			//echo $this->db->last_query();

			return $browseSQL->result();
			}else
			{
			  return '';
			}
		} else {
			$this->db2->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".						 			                          "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,tt.TOURNAMENT_NAME,".
							  "t.SMALL_BLIND,t.BIG_BLIND,c.NAME as CURRENCY_TYPE")->from('tournament_game_history g');
			$this->db2->join('tournament_tables tt', 'tt.TOURNAMENT_TABLE_ID = g.TOURNAMENT_TABLE_ID', 'left');
			$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			if(!empty($searchGameData["TABLE_ID"]))
				$this->db2->where('t.TOURNAMENT_NAME', $searchGameData["TABLE_ID"]);
			if(!empty($searchGameData["GAME_TYPE"]))
				$this->db2->where('t.MINI_GAME_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db2->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			if(!empty($searchGameData["CURRENCY_TYPE"]))
				$this->db2->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db2->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db2->order_by('g.GAME_HISTORY_ID','desc');
			$this->db2->limit($limit,$offset);
			$browseSQL = $this->db2->get();
			return $browseSQL->result();
		}
	}


	function getMinigamesNameByID($minigameID) {
		$this->db2->select('MINIGAMES_ID,MINIGAMES_NAME')->from('minigames');
		$this->db2->where('MINIGAMES_ID',$minigameID);
		$browseSQL=$this->db2->get();
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

  public function getTotalSearchData() {

		if($this->session->userdata('searchTournamentDetails')!="") {
			$searchGameData = $this->session->userdata('searchTournamentDetails');
		}

		if(!empty($searchGameData["PLAYER_ID"]) || !empty($searchGameData["HAND_ID"])) {
			$tournamentID="";
			if(!empty($searchGameData["TABLE_ID"])) {
				$getTournamentID = $this->getTournamentIDByName($searchGameData["TABLE_ID"]);
				if(!empty($getTournamentID))
					$tournamentID = $getTournamentID[0]->tournament_id;
				else
					$tournamentID = "00";
			}
			$minigamesName="";
			if(!empty($searchGameData["GAME_TYPE"])) {
				$getMinigamesName = $this->getMinigamesNameByID($searchGameData["GAME_TYPE"]);
				if(!empty($getMinigamesName))
					$minigamesName = $getMinigamesName[0]->MINIGAMES_NAME;
				else
					$minigamesName = "00";
			}
			$this->db3->select("tg.USER_ID,tg.PARTNER_ID,tg.MINIGAMES_TYPE_NAME,tt.TOURNAMENT_NAME,tg.STAKE as TOTAL_STAKE,tg.WIN as TOTAL_WIN,tg.ENDED,
tg.PLAY_GROUP_ID,tg.TOURNAMENT_ID,tt.TOURNAMENT_NAME")->from('tournament_game_transaction_history tg');
			$this->db3->join('tournament_tables tt', 'tg.TOURNAMENT_TABLE_ID = tt.TOURNAMENT_TABLE_ID', 'left');
			//$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db2->where('t.IS_ACTIVE',1);
			//$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			$this->db3->where('tg.TOURNAMENT_ID != ' ,0);
			if(!empty($tournamentID))
				$this->db3->where('tg.TOURNAMENT_ID', $tournamentID);
			if(!empty($minigamesName))
				$this->db3->where('tg.MINIGAMES_TYPE_NAME', $minigamesName);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db3->where('tg.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			//if(!empty($searchGameData["CURRENCY_TYPE"]))
			//	$this->db2->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db3->where('tg.STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["PLAYER_ID"])) {
				$userID = $this->game_model->getUserId($searchGameData['PLAYER_ID']);
				$this->db3->where('tg.USER_ID', $userID);
			}
			if(!empty($searchGameData["HAND_ID"]))
				$this->db3->where('tg.INTERNAL_REFFERENCE_NO', $searchGameData["HAND_ID"]);

			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(tg.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(tg.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db3->order_by('tg.GAME_TRANSACTION_ID','desc');

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();
			return $browseSQL->result();
		} else {
			$tournamentID="";
			if(!empty($searchGameData["TABLE_ID"])) {
				$getTournamentID = $this->getTournamentIDByName($searchGameData["TABLE_ID"]);
				if(!empty($getTournamentID))
					$tournamentID = $getTournamentID[0]->tournament_id;
				else
					$tournamentID = "00";
			}
			$this->db3->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".
							   "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,".
							   "g.TOURNAMENT_ID,tt.TOURNAMENT_NAME")->from('tournament_game_history g');
			$this->db3->join('tournament_tables tt', 'g.TOURNAMENT_TABLE_ID = tt.TOURNAMENT_TABLE_ID', 'left');
			//$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			//$this->db2->where('t.IS_ACTIVE',1);
			//$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
			if(!empty($tournamentID))
				$this->db3->where('g.TOURNAMENT_ID', $tournamentID);
			if(!empty($minigamesName))
				$this->db3->where('g.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db3->where('g.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			//if(!empty($searchGameData["CURRENCY_TYPE"]))
			//	$this->db2->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db3->where('g.TOTAL_STAKE', $searchGameData["STAKE"]);
			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db3->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db3->order_by('g.GAME_HISTORY_ID','desc');
			
			//echo $this->db3->last_query(); 
			//$this->db->limit(1);

			$browseSQL14 = $this->db3->get();
			//echo $this->db3->last_query(); die;
			//echo "test"; die;
			$results = $browseSQL14->result();
			

			return $browseSQL14->result();
		}
	}

  public function getTournamentHistoryData($playGruopID) {
    $this->db3->select("g.GAME_HISTORY_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,g.TOTAL_POT,g.TOTAL_REVENUE,".
                      "g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED")->from('tournament_game_history g');
    $this->db3->where('g.PLAY_GROUP_ID',$playGruopID);
    $browseSQL = $this->db3->get();
    return $browseSQL->result();
  }

    public function tournamentHandDetails($id){
		$query = $this->db3->query("select h.PLAY_ID,h.USER_ID,h.PLAY_GROUP_ID,h.TOURNAMENT_ID,h.TOURNAMENT_TABLE_ID,h.INTERNAL_REFERENCE_NO,h.GAME_REFERENCE_NO,h.STAKE,h.WIN,h.REVENUE,h.RAKE,h.POT_AMOUNT,h.TABLE_CARD,h.PLAYER_CARD,h.WIN_TYPE,h.WIN_RESULT_TYPE,h.WIN_HANDS,h.USER_HAND,h.USER_ORDERS,h.PRE_FLOP,h.FLOP,h.TURN,h.RIVER,h.CREATED_DATE from tournament_hand_history as h where h.PLAY_GROUP_ID = '$id'");
		$gameDetailsInfo  =  $query->result();
		return $gameDetailsInfo;
	}

	public function getTournamentListReportBySearchCriteria($searchData=array(),$limitend,$limitstart){
	  $this->load->database();



	  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";

			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					if($searchData['GAME_TYPE']==7) {
						$conQuery .= 't.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==8) {
						$conQuery .= 't.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					}else if($searchData['GAME_TYPE']==5) {
						$conQuery .= 't.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==6) {
						$conQuery .= 't.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					} else {
						$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'" AND t.TOURNAMENT_TYPE_ID =4';
					}
				}else{
					if($searchData['GAME_TYPE']==7) {
						$conQuery .= 'AND t.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==8) {
						$conQuery .= 'AND t.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					}else if($searchData['GAME_TYPE']==5) {
						$conQuery .= 'AND t.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==6) {
						$conQuery .= 'AND t.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					} else {
						$conQuery .= 'AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'" AND t.TOURNAMENT_TYPE_ID =4 ';
					}
					//$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}



			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(t.TOURNAMENT_START_TIME,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND date_format(t.TOURNAMENT_START_TIME,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  $conQuery .= " t.TOURNAMENT_STATUS  = '".$searchData['STATUS']."'";
				}else{
					  $conQuery .= " AND t.TOURNAMENT_STATUS  = '".$searchData['STATUS']."'";
			    }
			}

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_TYPE_ID,t.LOBBY_ID,t.MINI_GAME_TYPE_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.CREATED_DATE,t.TOURNAMENT_COMMISION,t.SMALL_BLIND,t.BIG_BLIND,t.TOURNAMENT_START_TIME,t.TOURNAMENT_END_TIME,t.GUARENTIED_PRIZE,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.IS_ACTIVE,t.RAKE from tournament t,minigames_type m,tournament_limit tl where $sql and t.TOURNAMENT_TYPE_ID IN (2,3,4) and t.LOBBY_ID IN(2,3) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID and t.IS_ACTIVE = 1 group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}else{

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_TYPE_ID,t.LOBBY_ID,t.MINI_GAME_TYPE_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.CREATED_DATE,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.TOURNAMENT_COMMISION,t.IS_ACTIVE,t.RAKE,t.GUARENTIED_PRIZE,t.TOURNAMENT_START_TIME from tournament t,minigames_type m,tournament_limit tl where t.LOBBY_ID IN(2,3) and t.IS_ACTIVE = 1  and t.TOURNAMENT_TYPE_ID IN (2,3,4) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}

	  	$fetchResults  = $query->result();

		//echo $this->db->last_query();
	 	return $fetchResults;
	}



public function getTournamentListReportCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database();
		if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					if($searchData['GAME_TYPE']==7) {
						$conQuery .= 't.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==8) {
						$conQuery .= 't.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					}else if($searchData['GAME_TYPE']==5) {
						$conQuery .= 't.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==6) {
						$conQuery .= 't.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					} else {
						$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'" AND t.TOURNAMENT_TYPE_ID =4';
					}
				}else{
					if($searchData['GAME_TYPE']==7) {
						$conQuery .= 'AND t.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==8) {
						$conQuery .= 'AND t.LOBBY_ID = 3 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					}else if($searchData['GAME_TYPE']==5) {
						$conQuery .= 'AND t.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=1' ;
					}else if($searchData['GAME_TYPE']==6) {
						$conQuery .= 'AND t.LOBBY_ID = 2 AND t.TOURNAMENT_TYPE_ID=2 AND t.MINI_GAME_TYPE_ID=2' ;
					} else {
						$conQuery .= 'AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'" AND t.TOURNAMENT_TYPE_ID =4 ';
					}
					//$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					  $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(t.TOURNAMENT_START_TIME,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(t.TOURNAMENT_START_TIME,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
				}else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
			    }
			}

			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament t,minigames_type m,tournament_limit tl  where $sql and t.TOURNAMENT_TYPE_ID IN (2,3,4) and t.LOBBY_ID IN(2,3) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.IS_ACTIVE = 1 and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");

		}else{
			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament t,minigames_type m,tournament_limit tl where t.LOBBY_ID IN(2,3) and t.TOURNAMENT_TYPE_ID IN (2,3,4) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.IS_ACTIVE = 1 and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}



 	public function getBlindStructureData($tournamentID) {
		$hostName =  $this->db->hostname;
		$username =  $this->db->username;
		$password =  $this->db->password;
		$database =  $this->db->database;
		$mysqli = new mysqli("$hostName", "$username", "$password", "$database");
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$query  = "call sp_fetch_tournament_blind_sturcture('".$tournamentID."')";
		return $mysqli->query($query);
	}

  public function getPrizeStructureData($tournamentID,$data) {
   $hostName =  $this->db3->hostname;
   $username =  $this->db3->username;
   $password =  $this->db3->password;
   $database =  $this->db3->database;
   $mysqli = new mysqli("$hostName", "$username", "$password", "$database");
   if(mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }

   $query  = "call sp_winner_levels('".$tournamentID."','".$data['REGISTRATED_PLAYER_COUNT']."','".$data['TOURNAMENT_STATUS']."','".$data['GUARENTIED_PRIZE']."','".$data['BUYIN']."','".$data['REBUY_IN']."','".$data['IS_ADDON']."','".$data['COIN_TYPE_ID']."','".$data['TOTAL_REBUY_COUNT']."','".$data['TOTAL_ADDON_COUNT']."','".$data['PRIZE_TYPE']."','".$data['TICKET_VALUE']."','".$data['PRIZE_STRUCTURE_ID']."')"; 
   
    echo $query;
  
   return $mysqli->query($query);
  }
 public function getTournamentWinnersData($tournamentID,$data) {
   $hostName =  $this->db3->hostname;
   $username =  $this->db3->username;
   $password =  $this->db3->password;
   $database =  $this->db3->database;
   $mysqli = new mysqli("$hostName", "$username", "$password", "$database");
   if(mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
   }

     $query  = "call sp_rank_prize_details('".$tournamentID."','".$data['REGISTRATED_PLAYER_COUNT']."','".$data['TOURNAMENT_STATUS']."','".$data['GUARENTIED_PRIZE']."','".$data['BUYIN']."','".$data['REBUY_IN']."','".$data['IS_ADDON']."','".$data['COIN_TYPE_ID']."','".$data['TOTAL_REBUY_COUNT']."','".$data['TOTAL_ADDON_COUNT']."','".$data['PRIZE_TYPE']."','".$data['TICKET_VALUE']."','".$data['PRIZE_STRUCTURE_ID']."',2,'".$data['LATE_REGISTRATION_ALLOW']."')";
	echo  $query;
	
   return $mysqli->query($query);
   
  }

 	public function getTournamentNameByID($tournamentID) {
		$this->db2->select('tournament_id,tournament_name')->from('tournament');
		$this->db2->where('tournament_id',$tournamentID);
		$browseSQL=$this->db2->get();
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}

 	public function getNTournamentParticiants($tournamentID) {
		$this->db2->where('tournament_id',$tournamentID);
		$browseSQL=$this->db2->get('tournament_registration');
		return $browseSQL->num_rows();
	}


  public function getAllPartnerIds($partnerid){
	    $this->db2->select('PARTNER_ID')->from('partner');
		$this->db2->where("FK_PARTNER_ID",$partnerid);
        $browseSQL = $this->db2->get();

		$results  = $browseSQL->result();

		foreach($results as $res){
		  $partnerids .= $res->PARTNER_ID.',';
		}


		return trim($partnerids,",");
	}




  	public function viewTournamentParticipants($tournamentID) {
		$this->db2->where('tournament_id',$tournamentID);
		$browseSQL=$this->db2->get('tournament_registration');
		return $browseSQL->result();
		/*$hostName =  $this->db->hostname;
		$username =  $this->db->username;
		$password =  $this->db->password;
		$database =  $this->db->database;
		$mysqli = new mysqli("$hostName", "$username", "$password", "$database");
		if(mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		$query  = "call sp_rank_prize_details('".$tournamentID."',2)";
		return $mysqli->query($query);*/
	}



 	public function getDefaultPrizeStructure() {
		 $browseSQL=$this->db2->query("SELECT pr.PLAYERS_MIN,pr.PLAYERS_MAX,rr.RANK_MIN,rr.RANK_MAX,pp.PRIZE_PERCENTAGE FROM prize_payout pp
INNER JOIN payout_players_range pr on pr.PAYOUT_PLAYERS_RANGE_ID=pp.PAYOUT_PLAYERS_RANGE_ID
and pr.TOURNAMENT_TYPE_ID=pp.TOURNAMENT_TYPE_ID INNER JOIN payout_rank_range rr
on rr.PAYOUT_RANK_RANGE_ID=pp.PAYOUT_RANK_RANGE_ID and rr.TOURNAMENT_TYPE_ID=pp.TOURNAMENT_TYPE_ID
WHERE pp.TOURNAMENT_TYPE_ID=4");
		$results  = $browseSQL->result();
		return $results;
	}


public function getAllTournamentTurnoverCount($partner_id,$data){
        $this->db2->select('tu.TOURNAMENT_ID,tu.PARTNER_ID,sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);


		if(!empty($data["user_id"]))
			$this->db2->where('tu.USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db2->group_by("tu.TOURNAMENT_ID");
        $browseSQL = $this->db2->get();
     //  echo $this->db->last_query();
		$results  = $browseSQL->result();

		return count($results);
	}


	public function getAllTournamentTurnover($partner_id,$data){

	        //echo "<pre>";print_r($data);die;
        $this->db2->select('tu.TOURNAMENT_ID,tu.PARTNER_ID,sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);

		//print_r($data);
		if(!empty($data["user_id"]))
			$this->db2->where('tu.USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db2->group_by("tu.TOURNAMENT_ID");
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();

		$results  = $browseSQL->result();
		return $results;
	}

 	public function getSelfTournamentTurnover($data){
		$partner_id = $data["partner_id"];
		$tournamentID = $data["TOURNAMENT_ID"];


                //echo $partner_id;die;
         $this->db2->select('tu.TOURNAMENT_ID,tu.PARTNER_ID,sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);
		$this->db2->where("tu.TOURNAMENT_ID",$tournamentID);
		//print_r($data);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}

			   $this->db2->group_by("TOURNAMENT_ID");
			     $this->db2->order_by('totentry','desc');
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();

		$results  = $browseSQL->result();
		return $results;
	}

	 public function getSelfTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db2->select('*')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.PARTNER_ID",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();

		$results  = $browseSQL->result();
               // echo $this->db->last_query();
		return count($results);
	}

	public function getSelfTurnover($data){

		$partner_id = $this->session->userdata('partnerid');
        $this->db2->select('sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);

		//print_r($data);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
        $this->db2->group_by('tu.partner_id');
		$this->db2->order_by('totentry','desc');
        $browseSQL = $this->db2->get();
		$results  = $browseSQL->result();
		//echo $this->db->last_query();

		return $results;
	}


	public function getPartnersTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllPartnerIds($partner_id);

		if(count(explode(",",$partner_ids))>0){
        	$this->db2->select('*')->from('tournament_user_game_transaction_history');
			if($partner_ids)
			$this->db2->where_in("partner_id",explode(",",$partner_ids));

				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db2->where('TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db2->where('TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db2->where('TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db2->where('TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db2->group_by("partner_id");
        	$browseSQL = $this->db2->get();
			$results  = $browseSQL->result();
			//echo $this->db->last_query();
			$countval = count($results);
		}else{
		    $countval = 0;
		}

		return $countval;
	}

	public function getPartnersTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllPartnerIds($partner_id);




		if(count(explode(",",$partner_ids))>0){
        	$this->db2->select('sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
			$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where_in("tu.partner_id",explode(",",$partner_ids));
		$this->db2->where("t.IS_ACTIVE",1);



			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}

			$this->db2->group_by("tu.partner_id");
                         $this->db2->order_by('totentry','desc');
        	$browseSQL = $this->db2->get();


			$results  = $browseSQL->result();


			$countval = $results;
		}else{
		    $countval = "";
		}


		return $countval;
	}

	public function getSelfPartnerTurnover($data){
		$partner_id = $data["partner_id"];
                //echo $partner_id;die;
        	$this->db2->select('sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);

		//print_r($data);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
                $this->db2->group_by("tu.partner_id");
				 $this->db2->order_by('totentry','desc');

        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		 //  die;

		$results  = $browseSQL->result();
		return $results;
	}

	public function getAllUserTurnoverCount($partner_id,$data){
        $tournamentId = $data['TOURNAMENT_ID'];
		$this->db2->select('tu.USER_ID,tu.PARTNER_ID,tu.TOURNAMENT_ID,sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);
		$this->db2->where("tu.TOURNAMENT_ID",$tournamentId);

		if(!empty($data["user_id"]))
			$this->db2->where('tu.USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db2->group_by("tu.user_id");
        $browseSQL = $this->db2->get();
     //  echo $this->db->last_query();
		$results  = $browseSQL->result();

		return count($results);
	}


	public function getAllUserTurnover($partner_id,$data){
		$tournamentId = $data['TOURNAMENT_ID'];
        $this->db2->select('tu.USER_ID,tu.PARTNER_ID,tu.TOURNAMENT_ID,sum(tu.ENTRY_FEE) as totentry, sum(tu.BUY_IN) as totbuyin,sum(tu.TOURNAMENT_WIN) as totwin,tu.PARTNER_ID')->from('tournament_user_game_transaction_history tu');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tu.TOURNAMENT_ID', 'left');
		$this->db2->where("tu.partner_id",$partner_id);
		$this->db2->where("t.IS_ACTIVE",1);
		$this->db2->where("tu.TOURNAMENT_ID",$tournamentId);

		//print_r($data);
		if(!empty($data["user_id"]))
			$this->db2->where('tu.USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('tu.TOURNAMENT_END_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('tu.TOURNAMENT_END_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db2->group_by("tu.user_id");
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();

		$results  = $browseSQL->result();
		return $results;
	}

	public function getTournamentLimitNameById($limitId){
		$res=$this->db2->query("Select * from tournament_limit where TOURNAMENT_LIMIT_ID = $limitId");
        $tourInfo  =  $res->row();
		return $tourInfo->TOURNAMENT_LIMIT_NAME;
	}

	public function getTournamentMiniGameTypeName($gameid){
		$res=$this->db2->query("Select * from minigames_type where MINIGAMES_TYPE_ID = $gameid");
        $tourInfo  =  $res->row();
		return $tourInfo->MINIGAMES_TYPE_NAME;
	}

    public function getTournamentEntryTypeName($coin){
		$res=$this->db2->query("Select * from coin_type where COIN_TYPE_ID = $coin");
        $tourInfo  =  $res->row();
		return $tourInfo->NAME;
	}

	 public function getTournamentPrizeTypeName($type){
		$res=$this->db2->query("Select * from prize_type where PRIZE_TYPE_ID = $type");
        $tourInfo  =  $res->row();
		return $tourInfo->NAME;
	}

	public function getTurnoverAllTotalData($searchTournamentTOData) {
		$this->db2->select("t.TOURNAMENT_ID,SUM(tth.ENTRY_FEE) AS TOTAL_ENTRY_FEE,SUM(tth.BUY_IN) AS TOTAL_BUY_IN,".
						  "SUM(tth.TOURNAMENT_WIN) AS TOTAL_WIN")->from('tournament t');
		$this->db2->join('tournament_user_game_transaction_history tth', 'tth.TOURNAMENT_ID = t.TOURNAMENT_ID', 'left');
		$this->db2->where('t.TOURNAMENT_ID !=','');
		$this->db2->where('t.IS_ACTIVE',1);

		if(!empty($searchTournamentTOData["START_DATE_TIME"]))
			$this->db2->where('DATE_FORMAT(t.CREATED_DATE,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchTournamentTOData["START_DATE_TIME"])));
		if(!empty($searchTournamentTOData["START_DATE_TIME"]) && !empty($searchTournamentTOData["END_DATE_TIME"]))
			$this->db2->where('DATE_FORMAT(t.CREATED_DATE,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchTournamentTOData["END_DATE_TIME"])));

		if(!empty($searchTournamentTOData["TABLE_ID"]))
			$this->db2->where('t.TOURNAMENT_NAME =',$searchTournamentTOData["TABLE_ID"]);
		if(!empty($searchTournamentTOData["GAME_TYPE"]))
			$this->db2->where('t.TOURNAMENT_TYPE_ID =',$searchTournamentTOData["GAME_TYPE"]);
		if(!empty($searchTournamentTOData["STATUS"]))
			$this->db2->where('t.TOURNAMENT_STATUS =',$searchTournamentTOData["STATUS"]);

		$browseSQL = $this->db2->get();
		//echo "x=".$this->db->last_query();
		return $browseSQL->result();
	}

	public function getTournamentNames() {
		$tournamentTypeIDs=array(3,4);
		$this->db2->select("t.TOURNAMENT_ID,t.TOURNAMENT_NAME")->from('tournament t');
		$this->db2->join('tournament_user_ticket tt', 'tt.TOURNAMENT_ID = t.TOURNAMENT_ID', 'left');
		$this->db2->where_in('t.TOURNAMENT_TYPE_ID',$tournamentTypeIDs);
        $this->db2->where('t.IS_ACTIVE',1);
		$this->db2->where('t.LOBBY_ID',2);
		$this->db2->where('tt.GENERATED_TICK_MODE',9);
		$this->db2->order_by('t.TOURNAMENT_NAME','asc');
		$this->db2->group_by('t.TOURNAMENT_ID');
		$browseSQL = $this->db2->get();
		//echo "x=".$this->db->last_query();
		return $browseSQL->result();
	}


 /* Recurrency Tournament */

 public function insertRecurrenceTournament($data){
   if(isset($data['tournament_type'])){
     $tournament_type 				= $data['tournament_type'];
   }else{
    $tournament_type 				= DEFAULT_SCHEDULED_TOURNAMET_ID;//DEFAULT SEDULE TOURNAMENT ID COMES FRON CONSTRANTS.PHP;
   }

   /* Tournament Information Block */
   $tournament_name 				= $data['tournament_name'];
     $tournamet_game_type 			= $data['tournamet_game_type'];
   //$tournament_lobby_id          = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP

   if($tournamet_game_type == 1){
     $tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
   $tournamet_game_type 		= 1;
     $tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
   }else if($tournamet_game_type == 2){
     $tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
   $tournamet_game_type 		= 2;
     $tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
   }else if($tournamet_game_type == 3){
     $tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
   $tournamet_game_type 		= 1;
     $tournament_lobby_id 		= 3;
     $tournament_lobby_menu_id   = 7;
   }else if($tournamet_game_type == 4){
     $tournament_type 			= DEFAULT_SCHEDULED_TOURNAMET_ID;
   $tournamet_game_type 		= 2;
     $tournament_lobby_id 		= 3;
     $tournament_lobby_menu_id   = 8;
   }else if($tournamet_game_type == 5){
     $tournament_type 			= 2;
   $tournamet_game_type 		= 1;
     $tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
   }else if($tournamet_game_type == 6) {
     $tournament_type 			= 2;
   $tournamet_game_type 		= 2;
     $tournament_lobby_id        = TOURNAMENT_LOBBY_ID;  //DEFAULT 2 COMES FROM CONSTRANTS.PHP
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
   }else if($tournamet_game_type == 7) {
     $tournament_type 			= 2;
   $tournamet_game_type 		= 1;
     $tournament_lobby_id 		= 3;
     $tournament_lobby_menu_id   = 7;
   }else if($tournamet_game_type == 8) {
     $tournament_type 			= 2;
   $tournamet_game_type 		= 2;
     $tournament_lobby_id 		= 3;
     $tournament_lobby_menu_id   = 8;
   }


   /*if($tournamet_game_type == 1){
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 5
   }else if($tournamet_game_type == 2){
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
   }else if($tournamet_game_type == 3){
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 6
   }else if($tournamet_game_type == 4){
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
   }else if($tournamet_game_type == 5){
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_TEXTA; // 6
   }else if($tournamet_game_type == 6){
     $tournament_lobby_menu_id   = TOURNAMENT_LOBBY_MENU_ID_OMAHA; // 6
   }else if($tournamet_game_type == 7){
     $tournament_lobby_menu_id   = 7; // 6
   }else if($tournamet_game_type == 8){
     $tournament_lobby_menu_id   = 8; // 6
   }*/

     $tournamet_gamestatus 		= $data['tournamet_gamestatus'];
   $tournamet_limit 				= $data['tournamet_limit'];
   /* EO: Tournament Information Block */

   /* Timing Information */
   $tournament_date				= $data['tournament_date'];
   $tournament_time 				= $data['tournament_time'];
     $tournament_reg_start_date	= $data['tournament_reg_start_date'];
   $tournament_reg_start_time	= $data['tournament_reg_start_time'];
   $tournament_late				= $data['tournament_late'];
   $tournament_reg_ends			= $data['tournament_reg_ends'];
   $convertStringToTime			= $this->convertStringToTime($tournament_time);
   $convertDateIntoNeedFormate	= $this->convertDateIntoNeedFormate($tournament_date);
   $registerSTime				= $this->convertStringToTime($tournament_reg_start_time);
   $registerSDdate 				= $this->convertDateIntoNeedFormate($tournament_reg_start_date);
   $register_start_time			= $registerSDdate.' '.$registerSTime;
   $tournament_start_time        = $convertDateIntoNeedFormate.' '.$convertStringToTime;
   if($tournament_late == 'on'){
     $register_end_time          = $tournament_start_time;//$this->addTimeToDate($tournament_start_time,$tournament_reg_ends);
   $late_registration 		    = 1;
   }else{
     $register_end_time  		= $tournament_start_time;
   $late_registration 		    = 0;
   }
   /* EO: Timing Information*/

     /* Player Section*/
   $tournament_player_pertable	= $data['tournament_player_pertable'];
   $tournament_min_players		= $data['tournament_min_players'];
   $tournament_max_players		= $data['tournament_max_players'];
   $player_pertable_minimum		= 2;
   $player_pertable_maximum  	= $tournament_player_pertable;
   /* EO: Player Section */

   /* Entry criteria section */
   $tournament_cash_type			= $data['tournament_cash_type'];

   if($tournament_cash_type == 8){
     $tournament_amount			= 1;
     $tournament_commision		= 0;
   }else if($tournament_cash_type == 7){
     $tournament_amount			= $data['tournament_amount'];
     $tournament_commision		= 0;
   }else{
     $tournament_amount			= $data['tournament_amount'];
     $tournament_commision		= $data['tournament_commision'];
   }



   $entry_fee					= $this->calPercentage($tournament_commision,$tournament_amount,2);
   if($tournament_cash_type == 7){
     $loyalty_start_date			= '';
     $loyalty_end_date			= '';
   $loyalty_days_interval		= $data['loyalty_days_interval'];
   }else{
     $loyalty_start_date			= "";
     $loyalty_end_date			= "";
   $loyalty_days_interval		= "";
   }

   /* EO: Entry Criteria Section */

   /* Blind Structure */
   $tournament_start_blinds		= $data['tournament_start_blinds'];
   $start_small_blind            = $this->getSmallBlindByLevel($tournament_start_blinds);
   $start_big_blind				= $this->getBigBlindByLevel($tournament_start_blinds);
   $tournament_bind_increment_time=$data['tournament_bind_increment_time'];
   $tournament_start_chip_amount	 = $data['tournament_start_chip_amount'];
   /*EO Blind Structure */

   /* Time Settings */
   $tournament_turn_time			= $data['tournament_turn_time'];
   $tournament_discount_time		= $data['tournament_discount_time'];
   $tournament_extra_time		= $data['tournament_extra_time'];
   $player_max_extra_time		= $data['tournament_max_cap'];//maximum players
   $level_interval_extra_time	= $data['tournament_blind_level'];//players level
   $extra_time					= $data['tournament_add_on'];//players addon
   /* EO: Time Settings*/


   $prize_structure				= $data['prize_type'];
   if($data['maingame_tournament_type']==2) {
    $prize_type				=  8;
    $tournament_prize_pool		=  0;
    $parent_tournament_id 		= $data['main_tournament'];
    $ticket_value   			= $this->getRecurrenceParentInformation($parent_tournament_id);
    $tournament_prize_pool		= $ticket_value;
    $tournament_ticket			= $ticket_value;
   }else {
   $prize_type					= $data['tournamet_prize_type'];
   $tournament_prize_pool		= $data['tournament_prize_pool'];
   $tournament_ticket			= $data['tournament_ticket'];
   }

   if($prize_structure == 1){
     $tournament_places_paid		= $data['tournament_places_paid'];
   }else{
     $tournament_places_paid		= 3;
   }
   //$tournament_prize_pool		= $data['tournament_prize_pool'];


   /* Some default values */
   $is_register_game 			= IS_REGISTER_GAME;
   $tournament_break_time 		= TOURNAMENT_BREAK_TIME;
   $break_interval_time			= BREAK_INTERVAL_TIME;
   $paid_option 					= PAID_OPTION;
   $allowOfflinePlayers  		= ALLOW_OFFLINE_PLAYERS;
   $currentLevel 				= CURRENT_LEVEL;
   $stackLevel                   = STAKE_LEVELS;
   $tournamentStatus 			= TOURNAMENT_STATUS;
   $minigame_id					= MINIGAMES_ID;
   /* EO: default values */

   $is_active 					= $tournamet_gamestatus;
   $created_date 				= date("Y-m-d H:i:s");
   $prizeCoinType  				= $tournament_cash_type;
   $prizeBalanceType				= $data['prize_balance_type'];
   //$created                      = NOW();

   //recurrence settings
   $recurrenceType 				= $data['recurrence_type'];



   $tournament_server = $data['tournament_server'];

   //dailyRecurence
   $dailyRecurrenceEvery      	= $data['daily_recurrence_every'];
   $dailyRecurrenceEveryNum      = $data['daily_recurrence_every_num'];
   $weeklyRecurrenceEvery        = $data['weekly_recurrence_every'];
   $weeklyRecurrenceEveryNum     = $data['weekly_recurrence_every_no'];
   $weeklyRecurrenceDay          = $data['weekly_recurrence_day'];
   $countWeekDays                = count($weeklyRecurrenceDay);
   if($countWeekDays > 0){
     foreach($weeklyRecurrenceDay as $weekDays){
     $mergeDays .= $weekDays.',';
   }
   }else{
      $mergeDays = $weeklyRecurrenceDay;
   }

   $weeklyRecurrenceDays = trim($mergeDays,",");


   $monthlyRecurrenceDay         = $data['monthly_reccurence_day'];
   $monthlyRecurrenceDayNO       = $data['monthly_reccurence_day_no'];
   $monthlyRecurrenceEvery       = $data['monthly_reccurence_every'];

   $recurrenceStartDate          = $data['recurrence_range_start_date'];
   $recurrenceStartTime          = $data['recurrence_range_start_time'];
   $recurrenceEndDate            = $data['recurrence_range_end_date'];
   $recurrenceEndTime            = $data['recurrence_range_end_time'];

   //convert date and time into needed formate
   $rconvertStringsToTime	    = $this->convertStringToTime($recurrenceStartTime);
   $rconvertStringeToTime	 	= $this->convertStringToTime($recurrenceEndTime);
   $rSconvertDate            	= $this->convertDateIntoNeedFormate($recurrenceStartDate);
   $rEconvertDate	            = $this->convertDateIntoNeedFormate($recurrenceEndDate);


   $recurrenceStartTime          =  $rSconvertDate.' '.$rconvertStringsToTime;
   $recurrenceEndTime            =  $rEconvertDate.' '.$rconvertStringeToTime;

   if($recurrenceType == 1){
     $dailyEvery    = $dailyRecurrenceEvery;
   $dailyEveryNum = $dailyRecurrenceEveryNum;
   $weeklyEvery   = 0;
   $weeklyEveryNum= 0;
   $weeklyDays    = 0;
   $monthlyDay    = 0;
   $monthlyDayNo  = 0;
   $monthlyEvery  = 0;
  }else if($recurrenceType == 2){
     $dailyEvery    = 0;
   $dailyEveryNum = 0;
   $weeklyEvery   = $weeklyRecurrenceEvery;
   $weeklyEveryNum= $weeklyRecurrenceEveryNum;
   $weeklyDays    = $weeklyRecurrenceDays;
   $monthlyDay    = 0;
   $monthlyDayNo  = 0;
   $monthlyEvery  = 0;
   }else if($recurrenceType == 3){
     $dailyEvery    = 0;
   $dailyEveryNum = 0;
   $weeklyEvery   = 0;
   $weeklyEveryNum= 0;
   $weeklyDays    = 0;
   $monthlyDay    = $monthlyRecurrenceDay;
   $monthlyDayNo  = $monthlyRecurrenceDayNO ;
   $monthlyEvery  = $monthlyRecurrenceEvery;
   }


  if($prize_structure == 1){
   if($tournament_places_paid > 0){
     for($no_winner=1;$no_winner<=$tournament_places_paid;$no_winner++){
      $prize_value 		 = $this->calPercentage($data["tournament_prize_$no_winner"],$tournament_prize_pool,0);
      $winner_percentage  = $data["tournament_prize_$no_winner"];
      $winprizeStruncture .= "$no_winner:$prize_value:$prize_type:$winner_percentage,";

     }
   }
  }

  $prizeValues = trim($prize_value,",");
  $prizeWinnerPercentage = trim($winner_percentage,",");
  $winprizeStruncture = trim($winprizeStruncture,",");
  $registration_starts_in = $data['registration_starts_in'];

  $register_day = $data['registration_starts_in_day'];
  $register_hour = $data['registration_starts_in_hour'];

  $announcement_day = $data['annoncement_starts_in_day'];
  $announcement_hour = $data['annoncement_starts_in_hour'];


   //registration_starsts_in and announcemnte stearts in
  if($register_day != 0){
   $registratin_starts_hour = ($register_day * 24) + $register_hour;
  }else{
     $registratin_starts_hour = $register_hour;
  }

  if($announcement_day != 0){
   $announcement_starts_hour = ($announcement_day * 24) + $announcement_hour;
  }else{
     $announcement_starts_hour = $announcement_hour;
  }


   $rebuy_setting			= $data['rebuy_setting'];

  /*
    * Server side checking for rebuy & addon values...................................
    * If coin type is VIP = 7 or Ticket = 8 then rebuy/addon features will be disabled
    * If tounament is freeroll means tournament amount = 0 then rebuy/addon feaures are disabled
    * If the rebuy-addon setting is not enabled then rebuy/addon features are disabled
   */
   if($tournament_cash_type == 7 || $tournament_cash_type == 8 ){
   $is_rebuy				= 0;
   $is_addon				= 0;
   $rebuy_chips_to_granted = 0;
   $rebuy_eligible_chips 	= 0;
   $rebuy_timeperiod 		= 0;
   $rebuy_num_rebuy 		= 0;
   $rebuy_amount 			= 0;
   $rebuy_entryfee 		= 0;
   $addon_chips_to_granted = 0;
   $addon_amount 			= 0;
   $addon_entryfee 		= 0;
   $addon_timeperiod 		= 0;
 }else{
   if($tournament_amount > 0){
     if($rebuy_setting == 1){
       $is_rebuy				= 1;
       $is_addon				= 1;
       $rebuy_chips_to_granted = $data['rebuy_chips_to_granted'];
       $rebuy_eligible_chips 	= $data['rebuy_eligible_chips'];
       $rebuy_timeperiod 		= $data['rebuy_timeperiod'];
       $rebuy_num_rebuy 		= $data['rebuy_num_rebuy'];
       if($data['double_rebuy']=='on') {
         $double_rebuy 		= 1;
       }else {
         $double_rebuy 		= '0';
       }
       $rebuy_amount 			= $data['rebuy_amount'];
       $rebuy_entryfee 		= $data['rebuy_entryfee'];
       $addon_chips_to_granted = $data['addon_chips_to_granted'];
       $addon_amount 			= $data['addon_amount'];
       $addon_entryfee 		= $data['addon_entryfee'];
       $addon_timeperiod 		= $data['addon_timeperiod'];
     }else if($rebuy_setting == 2){
        $is_rebuy				= 1;
       $is_addon				= 0;
       $rebuy_chips_to_granted = $data['rebuy_chips_to_granted'];
       $rebuy_eligible_chips 	= 0;
       $rebuy_timeperiod 		= $data['rebuy_timeperiod'];
       $rebuy_num_rebuy 		= $data['rebuy_num_rebuy'];
       $double_rebuy 			= '0';
       $rebuy_amount 			= $data['rebuy_amount'];
       $rebuy_entryfee 		= $data['rebuy_entryfee'];
       $addon_chips_to_granted = 0;
       $addon_amount 			= 0;
       $addon_entryfee 		= 0;
       $addon_timeperiod 		= 0;
     }else{
       $is_rebuy				= 0;
       $is_addon				= 0;
       $rebuy_chips_to_granted = 0;
       $rebuy_eligible_chips 	= 0;
       $rebuy_timeperiod 		= 0;
       $rebuy_num_rebuy 		= 0;
       $rebuy_amount 			= 0;
       $rebuy_entryfee 		= 0;
       $addon_chips_to_granted = 0;
       $addon_amount 			= 0;
       $addon_entryfee 		= 0;
       $addon_timeperiod 		= 0;
     }
   }else{
       $is_rebuy				= 0;
       $is_addon				= 0;
       $rebuy_chips_to_granted = 0;
       $rebuy_eligible_chips 	= 0;
       $rebuy_timeperiod 		= 0;
       $rebuy_num_rebuy 		= 0;
       $rebuy_amount 			= 0;
       $rebuy_entryfee 		= 0;
       $addon_chips_to_granted = 0;
       $addon_amount 			= 0;
       $addon_entryfee 		= 0;
       $addon_timeperiod 		= 0;

   }
  }

  $parent_tournament_id	= 0;
  $addon_count			= 1;

  $tournament_description           = $data['tournament_description'];
  if($tournament_description != '')
     $tournamentDesc = $tournament_description;
  else
     $tournamentDesc = '' ;

  $is_deposit_balance  =  $data['is_deposit_balance'];
  $is_promo_balance	  =  $data['is_promo_balance'];
  $is_win_balance 	  =  $data['is_win_balance'];

    if($is_deposit_balance == 'on'){  $isDepositBalance = 1; }else{ $isDepositBalance = 0;	}
  if($is_promo_balance == 'on'){    $isPromoBalance = 1; }else{ $isPromoBalance = 0;	}
  if($is_win_balance == 'on'){  $isWinBalance = 1; }else{ $isWinBalance = 0;	}


    $query = "call sp_tournament_recureence('$tournament_type','$minigame_id','$tournamet_game_type','$tournamet_limit','$tournament_cash_type','$tournament_lobby_id','$tournament_lobby_menu_id','$tournament_name','$tournamentDesc','$tournament_min_players','$tournament_max_players','$player_pertable_minimum','$player_pertable_maximum','$tournament_player_pertable','$start_small_blind','$start_big_blind','$tournament_amount','$tournament_turn_time','$tournament_extra_time',".TIME_BANK_INTERVAL_TIME.",".SITEOUT_TIME.",'$tournament_start_chip_amount','$entry_fee','$tournament_commision','$is_register_game','$registratin_starts_hour','$recurrenceStartTime','$tournament_break_time','$break_interval_time','$tournament_discount_time','$paid_option','$is_rebuy','$rebuy_amount','$rebuy_entryfee','$rebuy_num_rebuy','$rebuy_chips_to_granted','$rebuy_timeperiod','$is_addon','$addon_amount','$addon_count','$addon_chips_to_granted','$is_active','$stackLevel','$tournament_places_paid','$tournamentStatus','".date('Y-m-d H:i:s')."','$late_registration','$tournament_reg_ends','$allowOfflinePlayers','$prize_type','$prizeBalanceType','$prize_type','$tournament_ticket','$prize_structure','$tournament_prize_pool','$loyalty_start_date','$loyalty_end_date',".ADMIN_USER_ID.",'$recurrenceType','$dailyEvery','$dailyEveryNum','$weeklyEveryNum','$weeklyDays','$weeklyEvery','$monthlyDay','$monthlyDayNo','$monthlyEvery','$recurrenceStartTime','$recurrenceEndTime','$winprizeStruncture','$tournament_bind_increment_time','$announcement_starts_hour','$rebuy_eligible_chips','$addon_entryfee','$addon_timeperiod','$loyalty_days_interval',$isDepositBalance,$isPromoBalance,$isWinBalance,'$parent_tournament_id','$double_rebuy','$extra_time','$level_interval_extra_time','$player_max_extra_time','$tournament_server');";


  $this->sp_model->executeSPQuery($query);



 }

  public function getRecurrenceTournamentListBySearchCriteria($searchData=array(),$limitend,$limitstart){
	  $this->load->database();
	  if($searchData['GAME_TYPE']=="Texas Hold'em"){
	  		$game_type=1;
	  }elseif($searchData['GAME_TYPE']=="Omaha"){
	  		$game_type=2;
	  }
	  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";

			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$game_type.'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$game_type.'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  	}
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					    $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."'";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  if($searchData['STATUS']==2){
					  $conQuery .= " t.IS_ACTIVE = 0";
					  }else{
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
					  }
				}else{
					  if($searchData['STATUS']==2){
					  $conQuery .= " AND t.IS_ACTIVE = 0";
					  }else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
					  }
			    }
			}

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_TYPE_ID,t.LOBBY_ID,t.MINI_GAME_TYPE_ID,t.TOURNAMENT_RECURENCE_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.TOURNAMENT_COMMISION,t.SMALL_BLIND,t.BIG_BLIND,t.TOURNAMENT_START_TIME,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.IS_ACTIVE from tournament_recureence t,minigames_type m,tournament_limit tl where $sql and t.TOURNAMENT_TYPE_ID IN (2,3,4,5,6) and t.LOBBY_ID IN(2,3) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID and t.MASTER_ID = 0 and t.DELETE_STATUS = 0 group by t.TOURNAMENT_RECURENCE_ID limit $limitstart,$limitend");
		}else{

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_TYPE_ID,t.LOBBY_ID,t.MINI_GAME_TYPE_ID,t.TOURNAMENT_RECURENCE_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.TOURNAMENT_STATUS,m.GAME_DESCRIPTION as GAME_TYPE,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.BUYIN,t.ENTRY_FEE,t.TOURNAMENT_CHIPS,t.TOURNAMENT_COMMISION,t.IS_ACTIVE,t.TOURNAMENT_START_TIME from tournament_recureence t,minigames_type m,tournament_limit tl where t.LOBBY_ID IN(2,3) and t.TOURNAMENT_TYPE_ID IN (2,3,4,5,6) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.MASTER_ID = 0 and t.DELETE_STATUS = 0 and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_RECURENCE_ID limit $limitstart,$limitend");
		}

	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getRecurrenceTournamentListCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database();
		if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					  $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(t.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
				}else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
			    }
			}

			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament_recureence t,minigames_type m,tournament_limit tl  where $sql and t.TOURNAMENT_TYPE_ID IN (2,3,4,5,6) and t.LOBBY_ID IN (2,3) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.MASTER_ID = 0 and t.DELETE_STATUS = 0 and  t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");

		}else{
			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament_recureence t,minigames_type m,tournament_limit tl where t.LOBBY_ID IN (2,3) and t.TOURNAMENT_TYPE_ID IN (2,3,4,5,6) and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.MASTER_ID = 0 and t.DELETE_STATUS = 0 and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}

	public function deleteRecurrenceTournament($id){
		 if($id != ''){
		     $deleteQuery = "CALL sp_delete_tournament_recureence($id);";
		 	 $this->sp_model->executeSPQuery($deleteQuery);
		 }
	}

	public function getRTournamentById($id){
		$this->load->database();
        $res=$this->db2->query("Select * from tournament_recureence where TOURNAMENT_RECURENCE_ID = $id");
        $gameInfo  =  $res->row();
		return $gameInfo;
	}

	public function registerplayerslist($tournamentID){
	    $browseSQL=$this->db2->query("SELECT t.USER_ID,t.PLAYER_NAME,u.EMAIL_ID,u.CONTACT FROM `tournament_registration` as t,`user` as u where t.tournament_id = $tournamentID and t.USER_ID =u.USER_ID; ");
		$results  = $browseSQL->result();
		return $results;
	}

	public function getAllExportRegisterPlayerInfo($tournamentID){

	    $browseSQL=$this->db2->query("SELECT tt.tournament_name as TOURNAMENT_NAME,t.PLAYER_NAME,u.EMAIL_ID,u.CONTACT FROM `tournament_registration` as t,`user` as u,`tournament` as tt where t.tournament_id = tt.tournament_id and t.tournament_id = $tournamentID and t.USER_ID =u.USER_ID;; ");
		$results  = $browseSQL->result();
		return $results;
	}

	  public function getTournamentServers(){
    $this->load->database();

    $browseSQL=$this->db->query("SELECT * FROM tournament_servers");
    $results  = $browseSQL->result();
    return $results;
  }


  public function insertPromotionToUser($userId,$userName,$promoCode){
		 $this->load->database();
     if($promoCode == 'VEGAS100'){
       //echo "INSERT INTO vegas_leaderboard(USER_ID,USERNAME,PROMO_CODE,CREATED_DATE,PAYMENT_TRANSACTION_CREATED_ON) values ('$userId','$userName','VEGAS100')"; die;

        $this->db->query("INSERT INTO vegas_leaderboard(USER_ID,USERNAME,PROMO_CODE,CREATED_DATE) values ('$userId','$userName','VEGAS100',NOW())");
     }else if($promoCode == 'GOA100'){
        $this->db->query("INSERT INTO goa_leaderboard(USER_ID,USERNAME,PROMO_CODE) values ('$userId','$userName','GOA100')");
     }
	}

  public function selectPromotionToUser($userId,$userName,$promoCode){
    if($promoCode == 'VEGAS100'){
      $browseSQL=$this->db->query("SELECT * FROM vegas_leaderboard where USER_ID = $userId and PROMO_CODE = '$promoCode'");
    }else if($promoCode == 'GOA100'){
      $browseSQL=$this->db->query("SELECT * FROM goa_leaderboard where USER_ID = $userId and PROMO_CODE = '$promoCode'");
    }
   $results  = $browseSQL->result();
   $countResult = count($results);
   return $countResult;
  }

  public function getTournamentInfo($tournamentid) {
  		$this->db2->select('*')->from('tournament');
  		$this->db2->where('tournament_id',$tournamentid);
  		$browseSQL=$this->db2->get();
  		$rsResult  = $browseSQL->result();
		//echo $this->db3->last_query();
  		return $rsResult;
  	}
 public function getTournamentIdInfo($tournamentid) {
  		$this->db2->select('TOURNAMENT_NAME')->from('tournament');
  		$this->db2->where('tournament_id',$tournamentid);
  		$browseSQL=$this->db2->get();
  		$rsResult  = $browseSQL->result();
  		return $rsResult;
  	}	
 
/*public function getTournamentName($tournamentTableId) { 
		$this->db3->select('TOURNAMENT_NAME')->from('tournament_tables');
  		$this->db3->where('TOURNAMENT_TABLE_ID',$tournamentTableId);
  		$browseSQL=$this->db3->get();
  		$rsResult  = $browseSQL->result();
		return $rsResult;
}*/


}
