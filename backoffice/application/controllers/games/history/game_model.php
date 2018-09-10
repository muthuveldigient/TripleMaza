<?php
/*
  Class Name	: Game_model
  Package Name  : Poker
  Purpose       : Handle all the database services related to Poker -> Games
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/

class Game_model extends CI_Model
{

    public function getAllGameTypes(){
		$this->load->database(); 
		$query = $this->db2->query('select MINIGAMES_ID,MINIGAMES_TYPE_ID,GAME_DESCRIPTION,MINIGAMES_TYPE_NAME from minigames_type where STATUS=1');
		$gameTypesInfo  =  $query->result();
		return $gameTypesInfo;
    }
	
	public function getAllCoinTypes(){
		$this->load->database();
		$query = $this->db2->query('select COIN_TYPE_ID,NAME from coin_type where status =1');
		$coinTypeInfo = $query->result();
		return $coinTypeInfo;
	}
	
	public function getGameNameByMinigamesId($handId){
		$gameCode = substr($handId, 0, 3); 
		$this->load->database();
		$query = $this->db2->query('select MINIGAMES_NAME from minigames where REF_GAME_CODE="'.$gameCode.'"');
		$gameNAme = $query->result();
		return $gameNAme[0]->MINIGAMES_NAME;
	}
	
	public function getGameTableName($minGameName){
		$this->load->database();
		$query = $this->db2->query('select GAME_TABLE_NAME from minigames where MINIGAMES_NAME="'.$minGameName.'"');
		$playTableNAme = $query->result();
		return $playTableNAme[0]->GAME_TABLE_NAME;
	}	
	
	public function getSumOfStakePlayGroupId($minGameName,$tableName,$groupid){
		$this->load->database();
		$query = $this->db2->query("select sum(STAKE) as totbets,STARTED,ENDED from ".$tableName." where GAME_ID='".$minGameName."' and PLAY_GROUP_ID=".$groupid."");
		$detail = $query->result();
		return $detail;
	}	
	
	public function getMultiPlayerDetails($minGameName,$tableName,$groupid){
		$this->load->database();
		$query = $this->db2->query("select ".$tableName.".*,user.USERNAME from ".$tableName.", user where ".$tableName.".USER_ID = user.USER_ID and GAME_ID='".$minGameName."' and PLAY_GROUP_ID='".$groupid."'");
		$playDetail = $query->result();
		return $playDetail;
	}		
	
	public function getSingleWheelPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select singlewheel_play.*,user.USERNAME from singlewheel_play, user where singlewheel_play.USER_ID = user.USER_ID AND GAME_ID='singlewheel' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	
	public function getTripleChancePlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select triplechance_play.*,user.USERNAME from triplechance_play, user where triplechance_play.USER_ID = user.USER_ID AND GAME_ID='triplechance' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	
	public function getroulette36PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='roulette36' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getroulette12PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='roulette12' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getmobAndharBaharPlayDetails($handId){
		$this->load->database();
		$query = $this->db2->query("select andarbahar_play.*,user.USERNAME from andarbahar_play, user where andarbahar_play.USER_ID = user.USER_ID AND GAME_ID='mobandarbahar' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		//echo $this->db->last_query();
		return $gamePlay;		
	}

	public function getSlotreel3PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select slotmachine_play.*,user.USERNAME from slotmachine_play, user where slotmachine_play.USER_ID = user.USER_ID AND SLOTGAME_ID='slotreel3' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getSlotreel5PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select slotmachine_play.*,user.USERNAME from slotmachine_play, user where slotmachine_play.USER_ID = user.USER_ID AND SLOTGAME_ID='slotreel5' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getLuckyBingoPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select bingotime_play.*,user.USERNAME from bingotime_play , user where $sql  bingotime_play.USER_ID = user.USER_ID  AND INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	
	public function getJacksorBetterPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select jacksorbetter_play.*,user.USERNAME from jacksorbetter_play , user where $sql  jacksorbetter_play.USER_ID = user.USER_ID  AND INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}		
	
	public function getWheelPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select wheel_play.*,user.USERNAME from wheel_play , user where $sql  wheel_play.USER_ID = user.USER_ID  AND INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getBlackJackPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select blackjack_play.*,user.USERNAME from blackjack_play , user where blackjack_play.USER_ID = user.USER_ID and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getSingleWheelTimerPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select singlewheel_play.*,user.USERNAME from singlewheel_play, user where singlewheel_play.USER_ID = user.USER_ID AND GAME_ID='singlewheeltimer' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getRoulette36TimerPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='roulette36_timer' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getRoulette12TimerPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='roulette12_timer' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	
	public function getCoinNameById($id){
		$this->load->database();
		$query = $this->db2->query('select NAME from coin_type where COIN_TYPE_ID='.$id.'');
		$coinTypeName = $query->result();
		return $coinTypeName[0]->NAME;
	}
	
	public function getAllCurrencyTypes(){
		$this->load->database(); 
		$query = $this->db2->query('select NAME,COIN_TYPE_ID from coin_type where STATUS=1');
		$gameCurrencyInfo  =  $query->result();
		return $gameCurrencyInfo;
    }
	
	public function getAllThemes(){
		$this->load->database(); 
		$query = $this->db2->get('poker_game_theme');
		$gameThemeInfo  =  $query->result();
		return $gameThemeInfo;
    }
	
	public function getAllGames($limitstart,$limitend){
		$this->load->database(); 
		$query = $this->db2->get('poker_game', $limitstart, $limitend);
		$gamesInfo  =  $query->result();
		return $gamesInfo;
    }
	
	public function getGameLimit(){
		$this->load->database();
		$query = $this->db2->query('select TOURNAMENT_LIMIT_ID,TOURNAMENT_LIMIT_NAME,DESCRIPTION from tournament_limit');
		$gameLimit = $query->result();
		return $gameLimit;
	}
	
	public function getTotGamesCount(){
	    $this->load->database();
	    $numGames = $this->db2->count_all_results('poker_game');
	    return $numGames;
	}
	
	public function getAllGamesByGameType($gameTypeId){
		$this->load->database(); 
        $res=$this->db2->query("Select * from poker_game where GAME_TYPE = $gameTypeId");
        $gameInfo  =  $res->result();
		return $gameInfo;
	}
	
	public function getTotGamesCountByGameType($gameTypeId){
		$this->load->database(); 
        $res = $this->db2->query("Select count(*) as cnt from poker_game where GAME_TYPE = $gameTypeId");
        $gameInfo  =  $res->result();
		$num   = $gameInfo->cnt;
		return $num;
	}
	
	public function getAllGamesByCurrencyType($currencyType){
		$this->load->database(); 
        $res=$this->db2->query("Select * from poker_game where CURRENCY_TYPE = $currencyType");
        $gameInfo  =  $query->result();
		return $gameInfo;
	}
	
	public function getTotGamesCountByCurrencyType($currencyType){
		$this->load->database(); 
        $res=$this->db2->query("Select count(*) as cnt from poker_game where CURRENCY_TYPE = $currencyType");
        $gameInfo  =  $res->result();
		$num   = $gameInfo->cnt;
		return $num;
	}
		
    public function getGameById($Id){
		$this->load->database(); 
        $res=$this->db2->query("Select * from shan_tournament_tables where TOURNAMENT_ID = $Id");
        $gameInfo  =  $res->row();
		return $gameInfo;
    }
	
    public function getGameByName($Name){
		$this->load->database(); 
        $res=$this->db2->query("Select * from shan_tournament_tables where GAME_NAME = $Name");
        $gameInfo  =  $res->row();
		return $gameInfo;
    }
	
	public function deleteShanTournamentTables($data){
		$this->load->database();
		$id = explode(",",$data['chklist']);
		$updateData = array('IS_ACTIVE' => '2');
		 
		$this->db->where_in('TOURNAMENT_ID', $id);
		$this->db->update('shan_tournament_tables', $updateData); 
	
		$status = 1;
		return $status; 		
	}
	
	public function activateShanTournamentTables($data){
		$this->load->database();
		$id = $data['tourid'];
		$data = array('IS_ACTIVE' => '1');
		
		$this->db->where('TOURNAMENT_ID', $id);
		$res = $this->db->update('shan_tournament_tables', $data);
		return $res;	
	}
	
	public function getTotalGameRakeBySearchCriteria($searchData=array()){
	  $this->load->database(); 
	  $partnerids  = $this->Agent_model->getAllChildIds();
	  
	  $gameId  = $this->game_model->getTournamentIDByName($searchData['GAME_ID']); 
	  if(!empty($searchData['PLAY_GROUP_ID']) or !empty($searchData['GAME_ID']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['GAME_REFERENCE_NO']) or !empty($searchData['INTERNAL_REFERENCE_NO']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME']))){
			$conQuery = "";
			if($searchData['PLAY_GROUP_ID']!=""){
				$conQuery .= "p.PLAY_GROUP_ID = '".$searchData['PLAY_GROUP_ID']."'";
			}
			
			if($searchData['GAME_ID']!=""){
				if($searchData['PLAY_GROUP_ID'] == ''){
					$conQuery .= ' p.GAME_ID = "'.$gameId.'"';
				}else{			
					$conQuery .= ' AND p.GAME_ID = "'.$gameId.'"';
				}
			}
		
		   if($searchData['PLAYER_ID']!=""){
		   		$userid=$this->getUserId($searchData['PLAYER_ID']);
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{			
					$conQuery .= " AND p.USER_ID = '".$userid."'";
				}
			}
			
			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}			
			
			$sql = 	$conQuery;
			$query = $this->db2->query("select sum(RAKE) as RAKE from shan_play p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");
			if($query->num_rows==0) {
				$query = $this->db2->query("select sum(RAKE) as RAKE from shan_play_backup p,user u where $sql and u.user_id=p.user_id ".
										  "and u.partner_id in ($partnerids) and p.ended is not null ");			
			}
		}else{

			$sql = 	$conQuery;
			$query = $this->db2->query("select sum(RAKE) as RAKE from shan_play p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");
			if($query->num_rows==0) {
				$query = $this->db2->query("select sum(RAKE) as RAKE from shan_play_backup p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");
			}
		}
	  	$fetchResults  = $query->row();	
	 	return $fetchResults->RAKE;
	}	
	
	public function getGamesBySearchCriteria($searchData=array(),$limitend,$limitstart){
	  $this->load->database(); 
	  $partnerids  = $this->Agent_model->getAllChildIds(); 
	  
	  $gameId  = $this->game_model->getTournamentIDByName($searchData['GAME_ID']); 
	  if(!empty($searchData['PLAY_GROUP_ID']) or !empty($searchData['GAME_ID']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['GAME_REFERENCE_NO']) or !empty($searchData['INTERNAL_REFERENCE_NO']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME']))){
			$conQuery = "";
			if($searchData['PLAY_GROUP_ID']!=""){
				$conQuery .= "p.PLAY_GROUP_ID = '".$searchData['PLAY_GROUP_ID']."'";
			}
			
			if($searchData['GAME_ID']!=""){
				if($searchData['PLAY_GROUP_ID'] == ''){
					$conQuery .= ' p.GAME_ID = "'.$gameId.'"';
				}else{			
					$conQuery .= ' AND p.GAME_ID = "'.$gameId.'"';
				}
			}
		
		   if($searchData['PLAYER_ID']!=""){
		   		$userid=$this->getUserId($searchData['PLAYER_ID']);
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{			
					$conQuery .= " AND p.USER_ID = '".$userid."'";
				}
			}
			
			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}			
			
			$sql = 	$conQuery;
			$query = $this->db2->query("select p.GAME_ID, sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE, p.GAME_NAME, p.PLAY_GROUP_ID, p.STARTED, p.OPENING_POT_AMOUNT, p.CLOSING_POT_AMOUNT from shan_play p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID order by p.STARTED desc limit $limitstart,$limitend");
			if($query->num_rows==0) {
$query = $this->db2->query("select p.GAME_ID, sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE, p.GAME_NAME, p.PLAY_GROUP_ID, p.STARTED, p.OPENING_POT_AMOUNT, p.CLOSING_POT_AMOUNT from shan_play_backup p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID order by p.STARTED desc limit $limitstart,$limitend");			
			}			
		}else{

			$sql = 	$conQuery;
			$query = $this->db2->query("select p.GAME_ID, sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE, p.GAME_NAME, p.PLAY_GROUP_ID, p.STARTED,
p.OPENING_POT_AMOUNT, p.CLOSING_POT_AMOUNT from shan_play p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID,p.GAME_ID
order by p.STARTED desc limit $limitstart,$limitend");
			if($query->num_rows==0) {
			$query = $this->db2->query("select p.GAME_ID, sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE, p.GAME_NAME, p.PLAY_GROUP_ID, p.STARTED,
p.OPENING_POT_AMOUNT, p.CLOSING_POT_AMOUNT from shan_play_backup p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID,p.GAME_ID
order by p.STARTED desc limit $limitstart,$limitend");			
			}
		}
	  	$fetchResults  = $query->result();	
	 	return $fetchResults;
	}
	

	public function getGamesCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database(); 
		$partnerids  = $this->Agent_model->getAllChildIds();
		
		$gameId  = $this->game_model->getTournamentIDByName($searchData['GAME_ID']); 
	  		if(!empty($searchData['PLAY_GROUP_ID']) or !empty($searchData['GAME_ID']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['GAME_REFERENCE_NO']) or !empty($searchData['INTERNAL_REFERENCE_NO']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME']))){
			$conQuery = "";
				if($searchData['PLAY_GROUP_ID']!=""){
					$conQuery .= "p.PLAY_GROUP_ID = '".$searchData['PLAY_GROUP_ID']."'";
				}
			
				if($searchData['GAME_ID']!=""){
					if($searchData['PLAY_GROUP_ID'] == ''){
						$conQuery .= ' p.GAME_ID = "'.$gameId.'"';
					}else{			
						$conQuery .= ' AND p.GAME_ID = "'.$gameId.'"';
					}
				}
		
		   		if($searchData['PLAYER_ID']!=""){
		   			$userid=$this->getUserId($searchData['PLAYER_ID']);
					if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == ''){
						$conQuery .= " p.USER_ID = '".$userid."'";
					}else{			
						$conQuery .= " AND p.USER_ID = '".$userid."'";
					}
				}
			
				if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
					if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == '' && $searchData['PLAYER_ID'] == ''){
						$conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
					}else{
						$conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    	}
				}
		
				$sql = 	$conQuery;
				$querycnt=$this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE,p.GAME_ID,p.GAME_NAME,p.PLAY_GROUP_ID,p.STARTED from shan_play p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID");
				if($querycnt->num_rows==0) {
$querycnt=$this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE,p.GAME_ID,p.GAME_NAME,p.PLAY_GROUP_ID,p.STARTED from shan_play_backup p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID");				
				}				
			}else{
				$sql = 	$conQuery;
				$querycnt=$this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE,p.GAME_ID,p.GAME_NAME,p.PLAY_GROUP_ID,p.STARTED from shan_play p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID");
				if($querycnt->num_rows==0) {
$querycnt=$this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.RAKE) as RAKE,p.GAME_ID,p.GAME_NAME,p.PLAY_GROUP_ID,p.STARTED from shan_play_backup p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID");				
				}				  
			}

		$gameInfo  =  $querycnt->result();
	  	$cnt = count($gameInfo);
	  	return $cnt;
	}

public function getGamesListCountBySearchCriteria($searchData=array()){
	    $this->load->database(); 
		$conQuery = '';
		if(!empty($searchData['GAME_NAME']) or $searchData['STATUS'] != '' or !empty($searchData['COIN_TYPE'])  or !empty($searchData['TEXT_LEVEL_FILTER'])  or !empty($searchData['ACTION']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME']))){
			$conQuery = "";

			if($searchData['GAME_NAME']!=""){
				$conQuery .= "GAME_NAME = '".$searchData['GAME_NAME']."'";
			}
			
			if($searchData['STATUS']!=""){
				if($searchData['GAME_NAME'] == ''){
					$conQuery .= ' IS_ACTIVE = "'.$searchData['STATUS'].'"';
				}else{			
					$conQuery .= ' AND IS_ACTIVE = "'.$searchData['STATUS'].'"';
				}
			}
		   
			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['GAME_NAME'] == '' && $searchData['STATUS'] == ''){
  					  $conQuery .= " date_format(CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select count(*) as cnt from shan_tournament_tables where $sql");
		}else{
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select count(*) as cnt from shan_tournament_tables where IS_ACTIVE in(0,1)");  
		}
	  $gameInfos  =  $querycnt->row();
	  return $gameInfos->cnt;
	}	
	
	public function getGamesListBySearchCriteria($searchData=array(),$limitend,$limitstart){
		$this->load->database(); 
		$conQuery = '';
		if(!empty($searchData['GAME_NAME']) or $searchData['STATUS'] != '' or !empty($searchData['COIN_TYPE'])  or !empty($searchData['TEXT_LEVEL_FILTER'])  or !empty($searchData['ACTION']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) ){
			$conQuery = "";

			if($searchData['GAME_NAME']!=""){
				$conQuery .= "GAME_NAME = '".$searchData['GAME_NAME']."'";
			}
			
			if($searchData['STATUS']!=""){
				if($searchData['GAME_NAME'] == ''){
					$conQuery .= ' IS_ACTIVE = "'.$searchData['STATUS'].'"';
				}else{			
					$conQuery .= ' AND IS_ACTIVE = "'.$searchData['STATUS'].'"';
				}
			}
		   
			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['GAME_NAME'] == '' && $searchData['STATUS'] == ''){
					  $conQuery .= " date_format(CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}			

			$sql = 	$conQuery;
			if(!empty($this->session->userdata["partnertypeid"])) 
			{
 				$query=$this->db2->query("select * from shan_tournament_tables where IS_DEMO_TABLE=0 AND $sql limit $limitstart,$limitend");
			} else {
 				$query=$this->db2->query("select * from shan_tournament_tables where $sql limit $limitstart,$limitend");
			}
			}else{

			$sql = 	$conQuery;
			$query=$this->db2->query("select * from shan_tournament_tables where IS_ACTIVE in(0,1) and IS_DEMO_TABLE=0 limit $limitstart,$limitend ");
		}
	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}
	
	public function getGamesTotalBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database(); 
		$partnerids  = $this->Agent_model->getAllChildIds();
		
		 $gameId  = $this->game_model->getTournamentIDByName($searchData['GAME_ID']); 
	  if(!empty($searchData['PLAY_GROUP_ID']) or !empty($searchData['GAME_ID']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['GAME_REFERENCE_NO']) or !empty($searchData['INTERNAL_REFERENCE_NO']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME']))){
			$conQuery = "";
			if($searchData['PLAY_GROUP_ID']!=""){
				$conQuery .= "p.PLAY_GROUP_ID = '".$searchData['PLAY_GROUP_ID']."'";
			}
			
			if($searchData['GAME_ID']!=""){
				if($searchData['PLAY_GROUP_ID'] == ''){
					$conQuery .= ' p.GAME_ID = "'.$gameId.'"';
				}else{			
					$conQuery .= ' AND p.GAME_ID = "'.$gameId.'"';
				}
			}
		
		   if($searchData['PLAYER_ID']!=""){
		   		$userid=$this->getUserId($searchData['PLAYER_ID']);
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{			
					$conQuery .= " AND p.USER_ID = '".$userid."'";
				}
			}
		
			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}
		
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select * from shan_play p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID");
			if($querycnt->num_rows==0) {
$querycnt=$this->db2->query("select * from shan_play_backup p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID");			
			}			
		}else{
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select * from  shan_play p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID"); 
			if($querycnt->num_rows==0) {
$querycnt=$this->db2->query("select * from  shan_play_backup p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null group by p.PLAY_GROUP_ID, p.GAME_ID"); 			
			}			 
		}
	  $gameInfo  =  $querycnt->result();
	  $cnt = count($gameInfo);
	  return $cnt;
	}
	
	public function getGamesTotalRakeBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database(); 
		$partnerids  = $this->Agent_model->getAllChildIds();
		
		 $gameId  = $this->game_model->getTournamentIDByName($searchData['GAME_ID']); 
	  if(!empty($searchData['PLAY_GROUP_ID']) or !empty($searchData['GAME_ID']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['GAME_REFERENCE_NO']) or !empty($searchData['INTERNAL_REFERENCE_NO']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME']))){
			$conQuery = "";
			if($searchData['PLAY_GROUP_ID']!=""){
				$conQuery .= "p.PLAY_GROUP_ID = '".$searchData['PLAY_GROUP_ID']."'";
			}
			
			if($searchData['GAME_ID']!=""){
				if($searchData['PLAY_GROUP_ID'] == ''){
					$conQuery .= ' p.GAME_ID = "'.$gameId.'"';
				}else{			
					$conQuery .= ' AND p.GAME_ID = "'.$gameId.'"';
				}
			}
		
		   if($searchData['PLAYER_ID']!=""){
		   		$userid = $this->getUserId($searchData['PLAYER_ID']);
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{			
					$conQuery .= " AND p.USER_ID = '".$userid."'";
				}
			}
		
			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['PLAY_GROUP_ID'] == '' && $searchData['GAME_ID'] == '' && $searchData['PLAYER_ID']==""){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}
		
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select sum(p.RAKE) as RAKE from shan_play p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");
			if($query->num_rows==0) {
$querycnt=$this->db2->query("select sum(p.RAKE) as RAKE from shan_play_backup p,user u where $sql and u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");			
			}			
		}else{
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select sum(p.RAKE) as RAKE from shan_play p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");
			if($query->num_rows==0) {
$querycnt=$this->db2->query("select sum(p.RAKE) as RAKE from shan_play_backup p,user u where u.user_id=p.user_id and u.partner_id in ($partnerids) and p.ended is not null ");			
			}			 
		}
	  $gameInfo  =  $querycnt->result();
	  return $gameInfo;
	}	
	
	public function insertGame($data=array()){
	   $this->load->database(); 

		$rid=$data['rid'];
		if($data['MINBUYIN'] < ($data['BANKER']*5)){ 
			redirect('games/shan/game/add?rid='.$rid.'&err=3');
	    }
	   
	   if($data['MAXBUYIN'] < ($data['MINBUYIN']*10)){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=4');
	   }
	   
	   if($data['MAX_PLAYERS'] < $data['MIN_PLAYERS']){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=6');
	   }

	   if($data['MIN_PLAYERS'] > $data['MAX_PLAYERS']){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=7');
	   }

	   if($data['MIN_BET'] < ($data['BANKER'])/10){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=8');
	   }
	   
	   if($data['MIN_BET'] > ($data['BANKER'])/2){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=9');
	   }
	   
	   if($data['MAX_BET'] < ($data['BANKER'])*10){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=10');
	   }	   	
	   
	   if($data['BANKER'] < 100){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=11');
	   }   
	   
	   if($data['TOUR_TYPE'] == ''){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=12');
	   }
		if($data['GAME_SERVER'] == ''){
	   		redirect('games/shan/game/add?rid='.$rid.'&err=13');
	   }	   

	   if($data['GAME_NAME'] !='' && $data['BANKER'] !='' && $data['CURRENCY_SYMBOL'] !='' && $data['MIN_PLAYERS'] !='' && $data['MAX_PLAYERS']!='' && $data['TOUR_TYPE']!='' && $data['MINBUYIN'] !='' && $data['MAXBUYIN'] !='' && $data['MIN_BET'] !='' && $data['MAX_BET'] !='' && $data['IS_ACTIVE'] !='' && $data['RAKE'] !=''){

			$insertData = array(
			   'GAME_NAME'				=> $data['GAME_NAME'],
			   'BANKER'   				=> $data['BANKER'] ,
			   'MIN_PLAYERS'        	=> $data['MIN_PLAYERS'] ,
			   'MAX_PLAYERS'        	=> $data['MAX_PLAYERS'] ,
			   'TOURNAMENT_TYPE'		=> $data['TOUR_TYPE'],
			   'PLAYERS'				=> 0,
			   'GAME_ID'				=> 61 ,
			   'MINBUYIN'				=> $data['MINBUYIN'],
			   'MAXBUYIN'				=> $data['MAXBUYIN'],
			   'MIN_BET'				=> $data['MIN_BET'],
			   'MAX_BET'				=> $data['MAX_BET'],
			   'RAKE'					=> $data['RAKE'],
			   'COIN_TYPE'				=> $data['CURRENCY_SYMBOL'] ,			   
			   'IS_ACTIVE'				=> $data['IS_ACTIVE'],
			   'SERVER_ID'				=> $data['GAME_SERVER'],
			   'MODIFIED_BY'			=> $_SERVER['REMOTE_ADDR']."-".$this->session->userdata['partnerid']
			);
				$this->db->set('CREATED_DATE', 'NOW()', FALSE);
				$res = $this->db->insert('shan_tournament_tables', $insertData); 

				$insert_id = $this->db->insert_id();
				$updateData=array(
					'TOURNAMENT_ID'=>$insert_id,
					'CLONE_TOURNAMENT_ID'=>$insert_id
				);
				$this->updateCloneTournamentID($updateData);

				if($res){
					$err  = 1;
				}else{
					$err = 5;
				}
		}else{
			$err = 2;	
		}
		$rid=$data['rid'];
		if($err){ redirect('games/shan/game/add?err='.$err.'&rid='.$rid); }
	
	}

	public function updateCloneTournamentID($arrUpdate) {
		$this->db->where('TOURNAMENT_ID', $arrUpdate["TOURNAMENT_ID"]);
		$res = $this->db->update('shan_tournament_tables', $arrUpdate);		
	}
	
	public function updateGame($gameId,$data=array()){
	   $this->load->database(); 
	   $id = $this->uri->segment(5,0);

		$rid=$data['rid'];
		if($data['MINBUYIN'] < ($data['BANKER']*5)){ 
			redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=3',$data);
	    }
	   
	   if($data['MAXBUYIN'] < ($data['MINBUYIN']*10)){
	   		redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=4',$data);
	   }
	   
	   if($data['MAX_PLAYERS'] < $data['MIN_PLAYERS']){
	   		redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=6',$data);
	   }

	   if($data['MIN_PLAYERS'] > $data['MAX_PLAYERS']){
	   		redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=7',$data);
	   }

	   if($data['MIN_BET'] < ($data['BANKER'])/10){
	   		redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=8',$data);
	   }
	   
	   if($data['MIN_BET'] > ($data['BANKER'])/2){
	   		redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=9',$data);
	   }
	   
	   if($data['MAX_BET'] < ($data['BANKER'])*10){
	   		redirect('games/shan/game/edit/'.$id.'?rid='.$rid.'&err=10',$data);
	   }

	   if($data['GAME_NAME'] !='' && $data['BANKER'] !='' && $data['CURRENCY_SYMBOL'] !='' && $data['MIN_PLAYERS'] !='' && $data['MAX_PLAYERS']!='' && $data['MINBUYIN'] !='' && $data['MAXBUYIN'] !='' && $data['MIN_BET'] !='' && $data['MAX_BET'] !='' && $data['IS_ACTIVE'] !='' && $data['RAKE'] !=''){	
				
			$data1 = array(
			   'GAME_NAME'				=> $data['GAME_NAME'],
			   'BANKER'   				=> $data['BANKER'] ,
			   'MIN_PLAYERS'        	=> $data['MIN_PLAYERS'] ,
			   'MAX_PLAYERS'        	=> $data['MAX_PLAYERS'] ,
			   'TOURNAMENT_TYPE'		=> $data['TOUR_TYPE'],
			   'PLAYERS'				=> 0,
			   'GAME_ID'				=> 61 ,
			   'MINBUYIN'				=> $data['MINBUYIN'],
			   'MAXBUYIN'				=> $data['MAXBUYIN'],
			   'MIN_BET'				=> $data['MIN_BET'],
			   'MAX_BET'				=> $data['MAX_BET'],
			   'RAKE'					=> $data['RAKE'],
			   'COIN_TYPE'				=> $data['CURRENCY_SYMBOL'] ,			   
			   'IS_ACTIVE'				=> $data['IS_ACTIVE'],
			   'MODIFIED_BY'			=> $_SERVER['REMOTE_ADDR']."-".$this->session->userdata['partnerid']
			);
				$this->db->set('UPDATED_ON', 'NOW()', FALSE);
				$this->db->where('TOURNAMENT_ID', $gameId);
				$res = $this->db->update('shan_tournament_tables', $data1); 

				if($res){
					$err  = 1;
				}else{
					$err = 5;
				}
	    }else{
			$err = 2;	
		}
		if($err){ redirect('games/shan/game/edit/'.$gameId.'?err='.$err.'&rid='.$data['rid']); }
    }
	
 public function gameDetails_old($id,$gameId){
  $this->load->database();
  $query = $this->db2->query("select u.USERNAME,s.GAME_ID,s.PLAY_GROUP_ID,s.INTERNAL_REFERENCE_NO,s.GAME_REFERENCE_NO,s.STAKE,s.WIN,s.OPENING_POT_AMOUNT,s.CLOSING_POT_AMOUNT,s.RAKE,s.PLAY_DATA,date_format(s.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED,date_format(s.ENDED,'%d-%m-%Y %H:%i:%s') as ENDED,COIN_TYPE_ID from shan_play s,user u where s.PLAY_GROUP_ID = '".$id."' and  u.USER_ID=s.USER_ID");
  $gameDetailsInfo  =  $query->result();
  if(empty($gameDetailsInfo)) {
  $query = $this->db2->query("select u.USERNAME,s.GAME_ID,s.PLAY_GROUP_ID,s.INTERNAL_REFERENCE_NO,s.GAME_REFERENCE_NO,s.STAKE,s.WIN,s.OPENING_POT_AMOUNT,s.CLOSING_POT_AMOUNT,s.RAKE,s.PLAY_DATA,date_format(s.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED,date_format(s.ENDED,'%d-%m-%Y %H:%i:%s') as ENDED,COIN_TYPE_ID from shan_play_backup s,user u where s.PLAY_GROUP_ID = '".$id."' and  u.USER_ID=s.USER_ID");
  $gameDetailsInfo  =  $query->result();  
  }
  return $gameDetailsInfo;
 }
	
public function gameDetails($id,$gameId){
  $this->load->database(); 
  $gameDetailsInfo = array();
  $dynamicTableID=$this->getDynamicTableID($id);
  $newTabelGameID=$dynamicTableID[0]->GAME_ID;
  $playGroupID   =$dynamicTableID[0]->PLAY_GROUP_ID;
  if(!empty($newTabelGameID) && !empty($playGroupID)){
	  $query = $this->db3->query("select u.USERNAME,s.GAME_ID,s.PLAY_GROUP_ID,s.INTERNAL_REFERENCE_NO,s.GAME_REFERENCE_NO,s.STAKE,s.WIN,".
			  "s.OPENING_POT_AMOUNT,s.CLOSING_POT_AMOUNT,s.RAKE,s.PLAY_DATA,date_format(s.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED,".
			  "date_format(s.ENDED,'%d-%m-%Y %H:%i:%s') as ENDED,COIN_TYPE_ID from shan_play s,user u ".
			  "where s.PLAY_GROUP_ID = '".$playGroupID."' and  u.USER_ID=s.USER_ID and GAME_ID=$newTabelGameID ");
	  $gameDetailsInfo  =  $query->result();
	  if(empty($gameDetailsInfo)) {
		  $query = $this->db3->query("select u.USERNAME,s.GAME_ID,s.PLAY_GROUP_ID,s.INTERNAL_REFERENCE_NO,s.GAME_REFERENCE_NO,s.STAKE,s.WIN,".
				  "s.OPENING_POT_AMOUNT,s.CLOSING_POT_AMOUNT,s.RAKE,s.PLAY_DATA,date_format(s.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED,".
				  "date_format(s.ENDED,'%d-%m-%Y %H:%i:%s') as ENDED,COIN_TYPE_ID from shan_play_backup s,user u ".
				  "where s.PLAY_GROUP_ID = '".$playGroupID."' and  u.USER_ID=s.USER_ID and GAME_ID=$newTabelGameID ");
		  $gameDetailsInfo  =  $query->result();  
	  }
  }
  return $gameDetailsInfo;
 }

 public function getDynamicTableID($intRefNo) {
  $this->load->database(); 
  $gameDetailsInfo  = array();
  if(!empty( $intRefNo )){
	  $query = $this->db3->query("select sp.GAME_ID,sp.PLAY_GROUP_ID from shan_play sp where sp.GAME_REFERENCE_NO = '".$intRefNo."' ");
	  $gameDetailsInfo  =  $query->result();
	  if(empty($gameDetailsInfo)) {
		  $query = $this->db3->query("select sp.GAME_ID,sp.PLAY_GROUP_ID from shan_play_backup sp where sp.GAME_REFERENCE_NO = '".$intRefNo."' ");
		  $gameDetailsInfo  =  $query->result();  
	  }
  }
  return $gameDetailsInfo;  
 }
 

	public function gameRake($tid){
		$this->load->database();
		$query = $this->db2->query('select RAKE from tournament where TOURNAMENT_ID='.$tid);
		$gameRake = $query->row();
		return $gameRake->RAKE;
	}
	
	
	public function deleteGame($gameId){
		$this->load->database(); 
		$res  = $this->db->delete('poker_game', array('id' => $gameId)); 
		if($res)
		$returnMsg  = "Game deleted successfully";
		else
		$returnMsg  = "Something went wrong in delete query";
		
		return $returnMsg;
    }
	
	public function getTournamentNameByID($id){
		$this->load->database(); 
		$query = $this->db2->query('select GAME_NAME from shan_tournament_tables where TOURNAMENT_ID = '.$id);
		$gameTypesInfo  =  $query->row();
		return $gameTypesInfo->GAME_NAME;
	}
	
	public function getTournamentIDByName($name){
		$this->load->database(); 
		$query = $this->db2->query('select TOURNAMENT_ID from shan_tournament_tables where GAME_NAME = "'.$name.'"');
		$gameTypesInfo  =  $query->row();
		return $gameTypesInfo->TOURNAMENT_ID;
	}	
	
	public function getCurrencyNameByID($id){
		$this->load->database(); 
		$query = $this->db2->query('select NAME from coin_type where COIN_TYPE_ID = '.$id);
		$gameTypesInfo  =  $query->row();
		return $gameTypesInfo->NAME;
	}
	
	public function getMinigameId($typeid){
		$this->load->database(); 
        $res=$this->db2->query("Select MINIGAMES_ID from minigames_type where MINIGAMES_TYPE_ID = $typeid");
        $minigameInfo  =  $res->row();
		$minigameid   = $minigameInfo->MINIGAMES_ID;
		return $minigameid;
	}
	
	public function getMiniGameName($gameTypeID) {
        $this->db2->select('MINIGAMES_TYPE_ID,MINIGAMES_TYPE_NAME')->from('minigames_type');
		$this->db2->where('MINIGAMES_TYPE_ID',$gameTypeID);
		$browseSQL = $this->db2->get();	
		//echo $this->db->last_query();		
		return $browseSQL->result();					
	}

	public function getUserName($userid){
		$this->load->database(); 
        $res=$this->db2->query("select USERNAME from user where USER_ID = '".$userid."'");
        $result  =  $res->row();
		$username   = $result->USERNAME;
		return $username;
	}
	
	public function getUserId($username){
		$this->load->database(); 
        $res=$this->db2->query("select USER_ID from user where USERNAME = '".$username."'");
        $result  =  $res->row();
		if(!empty($result)){
			$userid   = $result->USER_ID;
			return $userid;
		}
	}
	
	public function getTournamentInfoById($tid){
		$this->load->database(); 
        $res=$this->db2->query("select * from shan_tournament_tables where TOURNAMENT_ID = '".$tid."'");
        $result  =  $res->row();
		return $result;
	}
	
	public function getAllTournamentInfo(){
		$this->load->database(); 
        $res=$this->db2->query("select TOURNAMENT_ID,GAME_NAME from shan_tournament_tables");
        $details  =  $res->result();
		return $details;
	}	
	
	public function getRakeAmount($groupId){
		$this->load->database(); 
        $res=$this->db2->query("select sum(RAKE) as RAKE from shan_play where PLAY_GROUP_ID='".$groupId."'");
        $rakeAmt  =  $res->row();
		if(empty($rakeAmt)) {
        $res=$this->db2->query("select sum(RAKE) as RAKE from shan_play_backup where PLAY_GROUP_ID='".$groupId."'");
        $rakeAmt  =  $res->row();		
		}
		return $rakeAmt->RAKE;
	}	
	
	public function getListOfActiveGames(){
		$this->load->database();
		$res = $this->db2->query("select MINIGAMES_NAME,DESCRIPTION from minigames where STATUS=1 AND minigames_id not in (61,62)");
		$activeGames = $res->result();
		return $activeGames;
	}
	
	public function getListOfAllActiveGames(){
		$this->load->database();
		$res = $this->db2->query("select MINIGAMES_NAME,DESCRIPTION from minigames where STATUS=1 AND minigames_id not in (62)");
		$activeGames = $res->result();
		return $activeGames;
	}	
	
	public function getGameRefCode($gameId){
		$this->load->database();
		if($gameId!=''){
			$resVal = $this->db2->query("select REF_GAME_CODE from minigames where MINIGAMES_NAME='".$gameId."'");
			$gameCode = $resVal->result();
			if(!empty($gameCode)){
				return $gameCode[0]->REF_GAME_CODE;
			}
		}
	}
	
	public function getGamesHistoryCountBySearchCriteria($data){

		$partnerids  = $this->Agent_model->getAllChildIds_kiosk(); 
		$partnerids = explode(",",$partnerids);
		$this->db3->select('u.USERNAME,sum(vth.BET_POINTS) as TOT_BETS,sum(vth.WIN_POINTS) as TOT_WINS,sum(vth.REFUND_POINTS) as TOT_REFUNDS')->from('view_transaction_history vth');
		$this->db3->join('user u ', 'vth.USER_ID = u.USER_ID');
		$this->db3->where_in("u.PARTNER_ID",$partnerids);
		//pagination config values
		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('vth.USER_ID', $userid);
		if(!empty($data["GameRefCode"]))
			$this->db3->like('vth.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
		$this->db3->group_by('u.USER_ID'); 
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return count($results);
	}

	public function getGamesHistoryBySearchCriteria($config,$data){
		//get partnerids		
		$partnerids  = $this->Agent_model->getAllChildIds_kiosk(); 
		$partnerids = explode(",",$partnerids);
		$this->db3->select('u.USERNAME,sum(vth.BET_POINTS) as TOT_BETS,sum(vth.WIN_POINTS) as TOT_WINS,sum(vth.REFUND_POINTS) as TOT_REFUNDS')->from('view_transaction_history vth');
		$this->db3->join('user u ', 'vth.USER_ID = u.USER_ID');
		$this->db3->where_in("u.PARTNER_ID",$partnerids);
		//pagination config values
		$limit  = $config["per_page"];
		$offset = $config["cur_page"];
		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('vth.USER_ID', $userid);
		if(!empty($data["GameRefCode"]))
			$this->db3->like('vth.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
		$this->db3->group_by('u.USER_ID'); 
		//$this->db->order_by($config['order_by'], $config['sort_order']);
		$this->db3->limit($limit,$offset);			
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results;
	}
	
	public function getGamesBetWinEndBySearchCriteria($data){
		//get partnerids		
		$partnerids  = $this->Agent_model->getAllChildIds_kiosk(); 
		$partnerids = explode(",",$partnerids);
		$this->db3->select('sum(vth.BET_POINTS) as TOT_BETS,sum(vth.WIN_POINTS) as TOT_WINS')->from('view_transaction_history vth');
		$this->db3->join('user u ', 'vth.USER_ID = u.USER_ID');
		$this->db3->where_in("u.PARTNER_ID",$partnerids);
		//pagination config values

		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('vth.USER_ID', $userid);
		if(!empty($data["GameRefCode"]))
			$this->db3->like('vth.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(vth.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results;
	}	

	public function getUserGameHistoryCountBySearchCriteria($data){
		//echo "<pre>"; print_r($data); die;
		//get partnerids		
		$partnerids  = $this->Agent_model->getAllChildIds_kiosk(); 
		$partnerids = explode(",",$partnerids);
		$this->db3->select('USERNAME as USERNAME,t1.INTERNAL_REFERENCE_NO as INTERNAL_REFERENCE_NO,t1.START_WORTH as CURRENT_TOT_BALANCE,t1.BET_POINTS as BET_POINTS,t1.WIN_POINTS as WIN_POINTS,t1.REFUND_POINTS as REFUND_POINTS,t1.TRANSACTION_DATE as TRANSACTION_DATE,t1.END_WORTH as CLOSING_TOT_BALANCE')->from('view_transaction_history t1');
		$this->db3->join('user t3 ', 't1.USER_ID = t3.USER_ID');
		$this->db3->where_in("t3.PARTNER_ID",$partnerids);
		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('t1.USER_ID', $userid);
		if(isset($data["intRefNo"]) || isset($data["GameRefCode"])){
			if($data["intRefNo"] != '' && $data["GameRefCode"] != ''){
				$this->db3->like('t1.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);
				$this->db3->where('t1.INTERNAL_REFERENCE_NO', $data["intRefNo"]);
			}elseif($data["intRefNo"] != '' && $data["GameRefCode"] == ''){
				$this->db3->where('t1.INTERNAL_REFERENCE_NO', $data["intRefNo"]);
			}elseif($data["intRefNo"] == '' && $data["GameRefCode"] != ''){
				$this->db3->like('t1.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);					
			}
		}
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
		
		//$this->db->order_by($config['order_by'], $config['sort_order']);
		//$this->db->limit($limit,$offset);			
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return count($results);
	}
	
	public function getUserGameHistoryBySearchCriteria($config,$data){
		//get partnerids		
		$partnerids  = $this->Agent_model->getAllChildIds_kiosk();
		
		$partnerids = explode(",",$partnerids);
		$this->db3->select('USERNAME as USERNAME,t1.INTERNAL_REFERENCE_NO as INTERNAL_REFERENCE_NO,t1.START_WORTH as CURRENT_TOT_BALANCE,t1.BET_POINTS as BET_POINTS,t1.WIN_POINTS as WIN_POINTS,t1.REFUND_POINTS as REFUND_POINTS,t1.TRANSACTION_DATE as TRANSACTION_DATE,t1.END_WORTH as CLOSING_TOT_BALANCE')->from('view_transaction_history t1');
		$this->db3->join('user t3 ', 't1.USER_ID = t3.USER_ID');
		$this->db3->where_in("t3.PARTNER_ID",$partnerids);
		//pagination config values
		$limit  = $config["per_page"];
		$offset = $config["cur_page"];
		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('t1.USER_ID', $userid);
		if(isset($data["intRefNo"]) || isset($data["GameRefCode"])){
			if($data["intRefNo"] != '' && $data["GameRefCode"] != ''){
				$this->db3->where('t1.INTERNAL_REFERENCE_NO', $data["intRefNo"]);
				$this->db3->like('t1.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);
			}elseif($data["intRefNo"] != '' && $data["GameRefCode"] == ''){
				$this->db3->where('t1.INTERNAL_REFERENCE_NO', $data["intRefNo"]);
			}elseif($data["intRefNo"] == '' && $data["GameRefCode"] != ''){
				$this->db3->like('t1.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);					
			}
		}
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}

		$this->db3->limit($limit,$offset);			
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results;
	}	
	
	public function getUserGameBetWinBySearchCriteria($data){
		//get partnerids		
		$partnerids  = $this->Agent_model->getAllChildIds_kiosk(); 
		$partnerids = explode(",",$partnerids);
		$this->db3->select('sum(t1.BET_POINTS) as BET_POINTS, sum(t1.WIN_POINTS) as WIN_POINTS, sum(t1.REFUND_POINTS) as REFUND_POINTS')->from('view_transaction_history t1');
		$this->db3->join('user t3 ', 't1.USER_ID = t3.USER_ID');
		$this->db3->where_in("t3.PARTNER_ID",$partnerids);

		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('t1.USER_ID', $userid);
		if(isset($data["intRefNo"]) || isset($data["GameRefCode"])){
			if($data["intRefNo"] != '' && $data["GameRefCode"] != ''){
				$this->db3->where('t1.INTERNAL_REFERENCE_NO', $data["intRefNo"]);
				$this->db3->like('t1.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);
			}elseif($data["intRefNo"] != '' && $data["GameRefCode"] == ''){
				$this->db3->where('t1.INTERNAL_REFERENCE_NO', $data["intRefNo"]);
			}elseif($data["intRefNo"] == '' && $data["GameRefCode"] != ''){
				$this->db3->like('t1.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);					
			}
		}
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(t1.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}

		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results;
	}		
		
	public function insertDealerApplet($gname,$search){
		if($gname!='' || $gname!='select'){
			$play1 = explode(',',$search['player1'],3);
			$play2 = explode(',',$search['player2'],3);
			$play3 = explode(',',$search['player3'],3);
			$play4 = explode(',',$search['player4'],3);
			$play5 = explode(',',$search['player5'],3);
			$play6 = explode(',',$search['player6'],3);
			$play7 = explode(',',$search['player7'],3);
			$play8 = explode(',',$search['player8'],3);
			$p11 = $play1[0];
			$p12 = $play1[1];
 			$p13 = $play1[2];
			$p21 = $play2[0];
			$p22 = $play2[1];
 			$p23 = $play2[2];
			$p31 = $play3[0];
			$p32 = $play3[1];
 			$p33 = $play3[2];			
			$p41 = $play4[0];
			$p42 = $play4[1];
 			$p43 = $play4[2];			
			$p51 = $play5[0];
			$p52 = $play5[1];
 			$p53 = $play5[2];	
			$p61 = $play6[0];
			$p62 = $play6[1];
 			$p63 = $play6[2];					
			$p71 = $play7[0];
			$p72 = $play7[1];
 			$p73 = $play7[2];
			$p81 = $play8[0];
			$p82 = $play8[1];
 			$p83 = $play8[2];						
$cards = '{"userHands":[["'.$p11.'","'.$p12.'"],["'.$p21.'","'.$p22.'"],["'.$p31.'","'.$p32.'"],["'.$p41.'","'.$p42.'"],["'.$p51.'","'.$p52.'"],["'.$p61.'","'.$p62.'"],["'.$p71.'","'.$p72.'"],["'.$p81.'","'.$p82.'"]],"userHands1":[["'.$p13.'"],["'.$p23.'"],["'.$p33.'"],["'.$p43.'"],["'.$p53.'"],["'.$p63.'"],["'.$p73.'"],["'.$p83.'"]]}';
			$insertData = array(
			   'GAME_NAME'				=> $gname,
			   'APPLET_VALUES'			=> $cards ,
			   'STATUS'        			=> 0 
			);
				$this->db->set('CREATED', 'NOW()', FALSE);
				$res = $this->db->insert('dealer_applet', $insertData); 
		}
	}		

	public function getBaccaratDetails($handId){
		$this->load->database();		
		$query = $this->db3->query("select baccarat_play.*,user.USERNAME from baccarat_play, user where baccarat_play.USER_ID = user.USER_ID AND GAME_ID='baccarat' and baccarat_play.INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getMobBaccaratDetails($handId){
		$this->load->database();		
		$query = $this->db3->query("select baccarat_play.*,user.USERNAME from baccarat_play, user where baccarat_play.USER_ID = user.USER_ID AND GAME_ID='mobbaccarat' and baccarat_play.INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getBaccaratTimerDetails($handId){
		$this->load->database();		
		$query = $this->db3->query("select baccarat_play.*,user.USERNAME from baccarat_play, user where baccarat_play.USER_ID = user.USER_ID AND GAME_ID='baccarattimer' and baccarat_play.INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getMobBaccaratTimerDetails($handId){
		$this->load->database();		
		$query = $this->db3->query("select baccarat_play.*,user.USERNAME from baccarat_play, user where baccarat_play.USER_ID = user.USER_ID AND GAME_ID='mobbaccarattimer' and baccarat_play.INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}			

	public function getMobEatStreetPlayDetails($handId){
		$this->load->database();
		
		$query = $this->db3->query("select mobslotreel5_china_t1_play.*,user.USERNAME from mobslotreel5_china_t1_play, user where mobslotreel5_china_t1_play.USER_ID = user.USER_ID AND GAME_ID='mobslotreel5_china_t1' and mobslotreel5_china_t1_play.INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	public function getmobroulette12PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='mobroulette12' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getMobForbittenFortunePlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select mobslotreel5_pharaoh_t1_play.*,user.USERNAME from mobslotreel5_pharaoh_t1_play, user where mobslotreel5_pharaoh_t1_play.USER_ID = user.USER_ID AND GAME_ID='mobslotreel5_pharaoh_t1' and INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	public function getmobroulette12TimerPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='mobroulette12_timer' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getmobroulette36PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='mobroulette36' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	public function getmobroulette36TimerPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='mobroulette36_timer' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getShweVIPTimerDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='mobamerican_roulette36_timer' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getMobJungleSafariPlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select mobslotreel5_pharaoh_t2_play.*,user.USERNAME from mobslotreel5_pharaoh_t2_play, user where mobslotreel5_pharaoh_t2_play.USER_ID = user.USER_ID AND GAME_ID='mobslotreel5_pharaoh_t2' and INTERNAL_REFERENCE_NO='".$handId."'");	
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getmobTripleChancePlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select triplechance_play.*,user.USERNAME from triplechance_play, user where triplechance_play.USER_ID = user.USER_ID AND GAME_ID='mobtriplechance' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}	
	public function getmobTripleChanceTimerPlayDetails($handId){
		$this->load->database();
		
		$query = $this->db3->query("select triplechance_play.*,user.USERNAME from triplechance_play, user where triplechance_play.USER_ID = user.USER_ID AND GAME_ID='mobtriplechancetimer' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getmobvip36PlayDetails($handId){
		$this->load->database();
		$query = $this->db3->query("select roulette_play.*,user.USERNAME from roulette_play, user where roulette_play.USER_ID = user.USER_ID AND GAME_ID='mob_american_roulette36' and INTERNAL_REFFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	public function getTripleChanceTimerPlayDetails($handId){
		$this->load->database();
		
		$query = $this->db3->query("select triplechance_play.*,user.USERNAME from triplechance_play, user where triplechance_play.USER_ID = user.USER_ID AND GAME_ID='triplechancetimer' and INTERNAL_REFERENCE_NO='".$handId."'");
		$gamePlay = $query->result();
		return $gamePlay;		
	}
	
	public function getForceBetData($refNo) {
		$this->db3->select('VIEW_TRANSACTION_ID,GAME_REFERENCE_NO,FORCED_BET')->from('shan_view_transaction_history');
		$this->db3->where_in("GAME_REFERENCE_NO",$refNo);
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();			
		return $results;
	}

 public function getTestReport() {
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=report.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

  $this->load->database(); 
  $query = $this->db2->query("SELECT st.GAME_NAME,INTERNAL_REFERENCE_NO,GAME_REFERENCE_NO,t.TRANSACTION_TYPE_NAME,OPENING_TOT_BALANCE,TRANSACTION_AMOUNT,CLOSING_TOT_BALANCE,CREATED 
FROM shan_wallet_transaction s,transaction_type t,shan_tournament_tables st  where st.TOURNAMENT_ID=s.ROOM_ID AND s.TRANSACTION_TYPE_ID=t.TRANSACTION_TYPE_ID and user_id=14462");
  $gamePlay = $query->result();
  $table='<table border="1">';
  foreach($gamePlay as $gIndex=>$gameData) {
   $table.='<tr>';
   $table.='<td>'.$gIndex.'</td>';   
   $table.='<td>'.$gameData->GAME_NAME.'</td>';
   $table.='<td>'.$gameData->INTERNAL_REFERENCE_NO.'</td>';
   $table.='<td>'.$gameData->GAME_REFERENCE_NO.'</td>';
   $table.='<td>'.$gameData->TRANSACTION_TYPE_NAME.'</td>';         
   $table.='<td>'.$gameData->OPENING_TOT_BALANCE.'</td>';         
   $table.='<td>'.$gameData->TRANSACTION_AMOUNT.'</td>';               
   $table.='<td>'.$gameData->OPENING_TOT_BALANCE.'</td>';         
   $table.='<td>'.$gameData->TRANSACTION_AMOUNT.'</td>';               
   $table.='<td>'.$gameData->CLOSING_TOT_BALANCE.'</td>';         
   $table.='<td>'.$gameData->CREATED.'</td>';                     
   $table.='</tr>';   
  }  
  $table.='</table>';
  echo "<pre>";
  print_r($table);
  die;
}
	
	public function getTournamentServers( $min, $max){
		$this->load->database();
		
		$query = $this->db2->query("select SERVER_NAME,SERVER_ID from shan_tournament_servers where MIN_AMOUNT <= $min AND MAX_AMOUNT  >= $max AND status=1");
		$results = $query->result();
		
		/* $this->db->select('*');
		if(!empty($min) && !empty($max) ){
			$this->db->where("MIN_AMOUNT <= ",$min);
			$this->db->where("MAX_AMOUNT  >= ",$max);
		}
		$this->db->where("status",1);
		$browseSQL = $this->db3->get('shan_tournament_servers');
		$results  = $browseSQL->result();	 */
		return $results;
	}
  
}