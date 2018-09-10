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

    public function getGameById($gameId){
		$this->load->database();
        $res=$this->db2->query("Select * from tournament where TOURNAMENT_ID = $gameId");
        $gameInfo  =  $res->row();
		return $gameInfo;
    }

	public function getGamesBySearchCriteria($searchData=array(),$limitend,$limitstart){
	  $this->load->database();
	  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['CURRENCY_TYPE']) or !empty($searchData['EMAIL_ID']) or !empty($searchData['HAND_ID']) or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) or !empty($searchData['GAME_ID'])){
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' p.MINIGAMES_TYPE_NAME = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND p.MINIGAMES_TYPE_NAME = "'.$searchData['GAME_TYPE'].'"';
				}
			}

		   if($searchData['PLAYER_ID']!="")
		   {
		   		$userid=$this->getUserId($searchData['PLAYER_ID']);
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{
					$conQuery .= " AND p.USER_ID = '".$userid."'";
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
			if($searchData['HAND_ID']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == ''){
					  $conQuery .= " p.GAME_REFERENCE_NO = '".$searchData['HAND_ID']."' ";
				}else{
					  $conQuery .= " AND p.GAME_REFERENCE_NO = '".$searchData['HAND_ID']."' ";
			    }
			}

			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == ''){
					  $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']=='' ){
					  if($searchData['STATUS']==2)
					  $conQuery .= " p.STATE = 2 or p.STATE=7";
					  else
					  $conQuery .= " p.STATE = '".$searchData['STATUS']."'";
				}else{
					  if($searchData['STATUS']==2)
					  $conQuery .= " AND p.STATE = 2 or p.STATE = 7";
					  else
					  $conQuery .= " AND p.STATE = '".$searchData['STATUS']."'";
			    }
			}


			if($searchData['GAME_ID']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']=='' && $searchData['STATUS']=='' ){
					  $conQuery .= " p.PLAY_GROUP_ID = '".$searchData['GAME_ID']."'";
				}else{
					  $conQuery .= " AND p.PLAY_GROUP_ID = '".$searchData['GAME_ID']."'";
			    }
			}
			$sql = 	$conQuery;
			$query = $this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.REVENUE) as REVENUE,p.PLAY_GROUP_ID,p.STATE,p.POT_AMOUNT,t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.SMALL_BLIND,t.BIG_BLIND,date_format(p.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED from tournament t left join tournament_tables ta  on t.TOURNAMENT_ID=ta.TOURNAMENT_id left join poker_play p on p.ROOM_ID=ta.TOURNAMENT_TABLE_ID  where $sql and p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id order by p.STARTED desc limit $limitstart,$limitend");

			$exportQuery = "select t.TOURNAMENT_NAME as 'Table ID',p.PLAY_GROUP_ID as 'Game ID',CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) as Stake,p.POT_AMOUNT as 'Pot Amount',(case when p.STATE=1 then 'Refund' when p.STATE=8 then 'Completed' else 'Interupted' end) as 'Status',date_format(p.STARTED,'%d-%m-%Y %H:%i:%s') as 'Date Time',sum(p.REVENUE) as Revenue,'Cash' as 'Currency' from tournament t left join tournament_tables ta  on t.TOURNAMENT_ID=ta.TOURNAMENT_id left join poker_play p on p.ROOM_ID=ta.TOURNAMENT_TABLE_ID  where $sql and p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id order by p.STARTED desc";

		}else{
			$sql = 	$conQuery;
			$query = $this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.REVENUE) as REVENUE,p.PLAY_GROUP_ID,p.STATE,p.POT_AMOUNT,t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.SMALL_BLIND,t.BIG_BLIND,date_format(p.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED from tournament t left join tournament_tables ta  on t.TOURNAMENT_ID=ta.TOURNAMENT_id left join poker_play p on p.ROOM_ID=ta.TOURNAMENT_TABLE_ID  where p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id order by p.STARTED desc limit $limitstart,$limitend");

			$exportQuery = "select t.TOURNAMENT_NAME as 'Table ID',p.PLAY_GROUP_ID as 'Game ID',CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) as Stake,p.POT_AMOUNT as 'Pot Amount',(case when p.STATE=1 then 'Refund' when p.STATE=8 then 'Completed' else 'Interupted' end) as 'Status',date_format(p.STARTED,'%d-%m-%Y %H:%i:%s') as 'Date Time',sum(p.REVENUE) as Revenue,'Cash' as 'Currency' tournament t left join tournament_tables ta  on t.TOURNAMENT_ID=ta.TOURNAMENT_id left join poker_play p on p.ROOM_ID=ta.TOURNAMENT_TABLE_ID  where p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id order by p.STARTED desc";

		}

		$queryData = array('query' => $exportQuery);
        $this->session->set_userdata($queryData);

	  	$fetchResults  = $query->result();
      //echo $this->db->last_query(); die;
	 	return $fetchResults;
	}


	public function getGamesCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
	    $this->load->database();
		 if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['CURRENCY_TYPE']) or !empty($searchData['EMAIL_ID']) or !empty($searchData['HAND_ID']) or !empty($searchData['STAKE']) or !empty($searchData['STATUS']) or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) or !empty($searchData['GAME_ID']) )
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' p.MINIGAMES_TYPE_NAME = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND p.MINIGAMES_TYPE_NAME = "'.$searchData['GAME_TYPE'].'"';
				}
			}



		   if($searchData['PLAYER_ID']!="")
		   {
		   		$userid=$this->getUserId($searchData['PLAYER_ID']);
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{
					$conQuery .= " AND p.USER_ID = '".$userid."'";
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



			if($searchData['HAND_ID']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == ''){
					  $conQuery .= " p.INTERNAL_REFERENCE_NO = '".$searchData['HAND_ID']."' ";
				}else{
					  $conQuery .= " AND p.INTERNAL_REFERENCE_NO = '".$searchData['HAND_ID']."' ";
			  }
			}

			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == ''){
					  $conQuery .= " p.STAKE = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND p.STAKE = '".$searchData['STAKE']."' ";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']=='' ){
					  if($searchData['STATUS']==2)
					  $conQuery .= " p.STATE = 2 or p.STATE=7";
					  else
					  $conQuery .= " p.STATE = '".$searchData['STATUS']."'";
				}else{
					  if($searchData['STATUS']==2)
					  $conQuery .= " AND p.STATE = 2 or p.STATE = 7";
					  else
					  $conQuery .= " AND p.STATE = '".$searchData['STATUS']."'";
			    }
			}

			if($searchData['GAME_ID']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']=='' && $searchData['STATUS']=='' ){
					  $conQuery .= " p.PLAY_GROUP_ID = '".$searchData['GAME_ID']."'";
				}else{
					  $conQuery .= " AND p.PLAY_GROUP_ID = '".$searchData['GAME_ID']."'";
			    }
			}

			$sql = 	$conQuery;
//			$querycnt=$this->db2->query("select count(*) as cnt from tournament left join poker_play where $conQuery and t.TOURNAMENT_TABLE_ID=p.ROOM_ID and p.USER_ID=u.USER_ID");

			$querycnt=$this->db2->query("select count(*) as cnt from (select t.tournament_id from tournament t left join tournament_tables ta  on t.tournament_id=ta.tournament_id left join poker_play p on p.room_id=ta.tournament_table_id  where $conQuery and p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id) as cnt");

		}else{
			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from (select t.tournament_id from tournament t left join tournament_tables ta  on t.tournament_id=ta.tournament_id left join poker_play p on p.room_id=ta.tournament_table_id  where p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id) as cnt");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}


	public function getGamesListBySearchCriteria($searchData=array(),$limitend,$limitstart){
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
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
				}else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
			    }
			}else{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  $conQuery .= " t.IS_ACTIVE != 2";
				}else{
					  $conQuery .= " AND t.IS_ACTIVE !=2";
			    }
			}

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,m.GAME_DESCRIPTION as GAME_TYPE,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.IS_ACTIVE,t.RAKE from tournament t,minigames_type m,tournament_limit tl where $sql and t.LOBBY_ID=1 and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}else{

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,m.GAME_DESCRIPTION as GAME_TYPE,t.SMALL_BLIND,t.BIG_BLIND,tl.DESCRIPTION as TOURNAMENT_LIMIT,t.IS_ACTIVE,t.RAKE from tournament t,minigames_type m,tournament_limit tl where t.LOBBY_ID=1 and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID AND t.IS_ACTIVE !=2 and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}

	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}


	public function getGamesTotalBySearchCriteria($searchData=array(),$limitend,$limitstart){
	  $this->load->database();

	  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['PLAYER_ID']) or !empty($searchData['CURRENCY_TYPE']) or !empty($searchData['EMAIL_ID']) or !empty($searchData['HAND_ID']) or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) or !empty($searchData['GAME_ID']))
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' p.MINIGAMES_TYPE_NAME = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND p.MINIGAMES_TYPE_NAME = "'.$searchData['GAME_TYPE'].'"';
				}
			}

		   if($searchData['PLAYER_ID']!="")
		   {
		   		$userid=$this->getUserId($searchData['PLAYER_ID']);
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == ''){
					$conQuery .= " p.USER_ID = '".$userid."'";
				}else{
					$conQuery .= " AND p.USER_ID = '".$userid."'";
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

			if($searchData['HAND_ID']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == ''){
					  $conQuery .= " p.GAME_REFERENCE_NO = '".$searchData['HAND_ID']."' ";
				}else{
					  $conQuery .= " AND p.GAME_REFERENCE_NO = '".$searchData['HAND_ID']."' ";
			    }
			}

			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == ''){
					  $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " p.STARTED BETWEEN '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND p.STARTED BETWEEN  '".date("Y-m-d H:i:s",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d H:i:s",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']=='' ){
					  if($searchData['STATUS']==2)
					  $conQuery .= " p.STATE = 2 or p.STATE=7";
					  else
					  $conQuery .= " p.STATE = '".$searchData['STATUS']."'";
				}else{
					  if($searchData['STATUS']==2)
					  $conQuery .= " AND p.STATE = 2 or p.STATE = 7";
					  else
					  $conQuery .= " AND p.STATE = '".$searchData['STATUS']."'";
			    }
			}


			if($searchData['GAME_ID']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['EMAIL_ID'] == '' && $searchData['HAND_ID'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']=='' && $searchData['STATUS']=='' ){
					  $conQuery .= " p.PLAY_GROUP_ID = '".$searchData['GAME_ID']."'";
				}else{
					  $conQuery .= " AND p.PLAY_GROUP_ID = '".$searchData['GAME_ID']."'";
			    }
			}


			$sql = 	$conQuery;


			$query = $this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.REVENUE) as REVENUE,p.POT_AMOUNT from tournament t left join tournament_tables ta  on t.TOURNAMENT_ID=ta.TOURNAMENT_id left join poker_play p on p.ROOM_ID=ta.TOURNAMENT_TABLE_ID  where $sql and p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id order by p.STARTED desc");
		}else{

			$sql = 	$conQuery;

			$query = $this->db2->query("select sum(p.STAKE) as STAKE,sum(p.WIN) as WIN,sum(p.REVENUE) as REVENUE,p.POT_AMOUNT from tournament t left join tournament_tables ta  on t.TOURNAMENT_ID=ta.TOURNAMENT_id left join poker_play p on p.ROOM_ID=ta.TOURNAMENT_TABLE_ID  where p.play_group_id is not null and t.LOBBY_ID=1 group by p.play_group_id order by p.STARTED desc");
		}
	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getGamesListCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
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

			$querycnt=$this->db2->query("select count(*) as cnt from tournament t,minigames_type m,tournament_limit tl  where $sql and t.LOBBY_ID=1 and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");

		}else{
			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from tournament t,minigames_type m,tournament_limit tl where t.LOBBY_ID=1 and m.MINIGAMES_TYPE_ID=t.MINI_GAME_TYPE_ID and t.TOURNAMENT_LIMIT_ID=tl.TOURNAMENT_LIMIT_ID");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}





	public function insertGame($data=array()){
	   $this->load->database();

	   if($data['big_blind']<500){
	   		$range=1;
	   }elseif($data['big_blind']>=500 && $data['big_blind']<5000){
	   		$range=2;
	   }elseif($data['big_blind']>=5000){
	   		$range=3;
	   }

	   if($data['big_blind']!=($data['small_blind']*2)){
	   		redirect('games/poker/game/add?err=3');
	   }



	   if($data['game_type'] !='' && $data['limit'] !='' && $data['currency_type'] !='' && $data['game_name'] !='' && $data['minplayers']!='' && $data['maxplayers']!='' && $data['min_buyin'] !='' && $data['max_buyin'] !='' && $data['small_blind'] !='' && $data['big_blind'] !='' && $data['rake'] !='' && $data['playertime'] !='' && $data['extratime'] !='' && $data['sitouttime'] !='' && $data['status'] !=''){
			$minigameid	=$this->getMinigameId($data['game_type']);
			if($data['game_type']==2){
				$lobby_menu_id=2;
			}else{
				$lobby_menu_id=1;
			}
			if(isset($data['STRADDLE'])){
				$straddle = $data['STRADDLE'];
			}else{
				$straddle = 0;
			}

      if(isset($data['anonymus_table'])){
       $anonymus_table = $data['anonymus_table'];
     }else{
       $anonymus_table = 0;
     }

			$insertData = array(
			   'TOURNAMENT_TYPE_ID'		=> 6,
			   'MINIGAMES_ID'        	=> $minigameid ,
			   'MINI_GAME_TYPE_ID'   	=> $data['game_type'] ,
			   'TOURNAMENT_LIMIT_ID' 	=> $data['limit'] ,
			   'COIN_TYPE_ID'        	=> $data['currency_type'] ,
			   'LOBBY_ID'        	 	=> 1 ,
			   'LOBBY_MENU_ID'       	=> $lobby_menu_id ,
			   'TOURNAMENT_NAME'		=> $data['game_name'] ,
			   'TOURNAMENT_DESC'		=> $data['game_name'] ,
			   'MIN_PLAYERS'        	=> $data['minplayers'] ,
			   'MAX_PLAYERS'       		=> $data['maxplayers'] ,
			   'MINBUYIN'       		=> $data['min_buyin'] ,
			   'MAXBUYIN'          		=> $data['max_buyin'] ,
			   'SMALL_BLIND'			=> $data['small_blind'],
			   'BIG_BLIND'				=> $data['big_blind'],
			   'BUYIN'					=> 10,
			   'RAKE'					=> $data['rake'],
			   'RAKE_CAP'				=> $data['rake_cap'],
			   'RAKE1'					=> $data['rake1'],
			   'RAKE_CAP1'				=> $data['rake_cap1'],
			   'PLAYER_HAND_TIME'		=> $data['playertime'],
			   'EXTRA_TIME'				=> $data['extratime'],
			   'SITOUT_TIME'			=> $data['sitouttime'],
			   'ANTI_BANKING_TIME'      => $data['anti_banking_time'],
			   'HIGH_LOW_LEVEL'			=> $range,
			   'STRADDLE'				=> $straddle,
         'ANONYMOUS_TABLE' => $anonymus_table,
			   'DISCONNECT_TIME'		=> $data['disconnect_time'],
			   'IS_GIVE_CHIPS'			=> 1,
			   'TOURNAMENT_CHIPS'		=> 500,
			   'ELIGIBILITY_ID'			=> 1,
			   'ELIGIBILITY'			=> 100,
			   'ENTRY_FEE'				=> 10,
			   'IS_REBUY'				=> 1,
			   'IS_ACTIVE'        		=> $data['status'],
			   'TOURNAMENT_STATUS' 		=> 1
			);
			 $this->db->set('CREATED_DATE', 'NOW()', FALSE);
			$res = $this->db->insert('tournament', $insertData);
			$insert_id = $this->db->insert_id();

			if($res){
				$err  = 1;
				$insertring_table= array(
					'TOURNAMENT_ID'    		=> $insert_id ,
					'TOURNAMENT_NAME'  		=> $data['game_name'] ,
					'MINIGAMES_TYPE_ID'     => $data['game_type'] ,
					'CURRENT_PLAYERS'	    => '{}' ,
					'CURRENT_PLAYERS_COUNT' => 0 ,
					'STATUS'				=> $data['status'],
					'IS_ACTIVE'        		=> $data['status']
				);
				$this->db->insert('tournament_tables',$insertring_table);

				$insertring_tourlevel= array(
					'TOURNAMENT_ID'			=> $insert_id ,
					'STAKE_LEVELS'			=> 1 ,
					'SMALL_BLIND'			=> $data['small_blind'],
					'BIG_BLIND'				=> $data['big_blind']
				);
				$this->db->insert('tournament_levels',$insertring_tourlevel);

			}else{
				$err = 5;
			}
		}else{
		$err = 2;
		}
		$rid=$data['rid'];
		if($err){ redirect('games/poker/game/add?err='.$err.'&rid='.$rid); }

	}

	public function updateGame($gameId,$data=array()){
	   $this->load->database();


	   if($data['big_blind']<500){
	   		$range=1;
	   }elseif($data['big_blind']>=500 && $data['big_blind']<5000){
	   		$range=2;
	   }elseif($data['big_blind']>=5000){
	   		$range=3;
	   }

	   if($data['big_blind']!=($data['small_blind']*2)){
	   		redirect('games/poker/game/edit/'.$gameId.'?err=3');
	   }



	   if($data['game_type'] !='' && $data['limit'] !='' && $data['currency_type'] !='' && $data['game_name'] !='' && $data['minplayers']!='' && $data['maxplayers']!='' && $data['min_buyin'] !='' && $data['max_buyin'] !='' && $data['small_blind'] !='' && $data['big_blind'] !='' && $data['rake'] !='' && $data['playertime'] !='' && $data['extratime'] !='' && $data['sitouttime'] !='' && $data['status'] !=''){
				$minigameid	=$this->getMinigameId($data['game_type']);

				if($data['game_type']==2){
				$lobby_menu_id=2;
				}else{
				$lobby_menu_id=1;
				}
			if(isset($data['STRADDLE'])){
				$straddle = $data['STRADDLE'];
			}else{
				$straddle = 0;
			}

      if(isset($data['anonymus_table'])){
        $anonymus_table = $data['anonymus_table'];
      }else{
        $anonymus_table = 0;
      }

				$data1 = array(
					   'MINIGAMES_ID'        	=> $minigameid ,
					   'MINI_GAME_TYPE_ID'   	=> $data['game_type'] ,
					   'TOURNAMENT_LIMIT_ID' 	=> $data['limit'] ,
					   'COIN_TYPE_ID'        	=> $data['currency_type'] ,
					   'TOURNAMENT_NAME'		=> $data['game_name'] ,
					   'TOURNAMENT_DESC'		=> $data['game_name'] ,
					   'MIN_PLAYERS'        	=> $data['minplayers'] ,
					   'MAX_PLAYERS'       		=> $data['maxplayers'] ,
					   'MINBUYIN'       		=> $data['min_buyin'] ,
					   'MAXBUYIN'          		=> $data['max_buyin'] ,
					   'SMALL_BLIND'			=> $data['small_blind'],
					   'BIG_BLIND'				=> $data['big_blind'],
					   'LOBBY_MENU_ID'       	=> $lobby_menu_id,
					   'RAKE'					=> $data['rake'],
					   'RAKE_CAP'				=> $data['rake_cap'],
					   'RAKE1'					=> $data['rake1'],
					   'RAKE_CAP1'				=> $data['rake_cap1'],
					   'PLAYER_HAND_TIME'		=> $data['playertime'],
					   'DISCONNECT_TIME'		=> $data['disconnect_time'],
					   'EXTRA_TIME'				=> $data['extratime'],
					   'SITOUT_TIME'			=> $data['sitouttime'],
					   'ANTI_BANKING_TIME'      => $data['anti_banking_time'],
					   'HIGH_LOW_LEVEL'			=> $range,
					   'STRADDLE'				=> $straddle,
             'ANONYMOUS_TABLE' => $anonymus_table,
					   'IS_ACTIVE'        		=> $data['status']
				);

				$this->db->where('TOURNAMENT_ID', $gameId);
				$res = $this->db->update('tournament', $data1);
				if($res){
					$err  = 1;
					$updatering_table= array(
					'TOURNAMENT_NAME'  		=> $data['game_name'] ,
					'MINIGAMES_TYPE_ID'     => $data['game_type'] ,
					'CURRENT_PLAYERS'	    => '{}' ,
					'CURRENT_PLAYERS_COUNT' => 0 ,
					'STATUS'				=> $data['status'],
					'IS_ACTIVE'        		=> $data['status']
					);
					//$this->db2->where('TOURNAMENT_TABLE_ID', $data['tournament_id']);
					$this->db->where('TOURNAMENT_ID', $gameId);
					$this->db->update('tournament_tables',$updatering_table);
					$updatering_tourlevel= array(
					'STAKE_LEVELS'			=> 1 ,
					'SMALL_BLIND'			=> $data['small_blind'],
					'BIG_BLIND'				=> $data['big_blind']
					);
					$this->db->where('TOURNAMENT_ID', $gameId);
					$this->db->update('tournament_levels',$updatering_tourlevel);
				}else{
					$err = 5;
				}
	    }else{
			$err = 2;
		}
		if($err){ redirect('games/poker/game/edit/'.$gameId.'?err='.$err.'&rid='.$data['rid']); }
    }


	public function gameDetails($id,$endedDate){
	 $playdate     =  date("Y-m-d",strtotime($endedDate));
	 $played_date  = strtotime($playdate);
	 $current_date = strtotime(date("Y-m-d"));

		$CI = &get_instance();
			//setting the second parameter to TRUE (Boolean) the function will return the database object.
		$this->db2 = $CI->load->database('db2', TRUE);
		$query = $this->db2->query("select p.USER_ID,p.MINIGAMES_TYPE_NAME,p.INTERNAL_REFERENCE_NO,p.GAME_REFERENCE_NO,p.STAKE,p.WIN,p.POT_AMOUNT,p.REVENUE,p.RAKE,
 p.PLAY_DATA,date_format(p.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED from poker_play p where p.PLAY_GROUP_ID = '$id'");
		$gameDetailsInfo  =  $query->result();

		return $gameDetailsInfo;
	}

	public function gameHandDetails($id){
		$this->load->database();
		$CI = &get_instance();
		$this->db3 = $CI->load->database('db3', TRUE);		

		$query = $this->db3->query("select h.PLAY_ID,h.USER_ID,h.PLAY_GROUP_ID,h.TOURNAMENT_ID,h.TOURNAMENT_TABLE_ID,h.INTERNAL_REFERENCE_NO,h.GAME_REFERENCE_NO,h.STAKE,h.WIN,h.REVENUE,h.RAKE,h.POT_AMOUNT,h.TABLE_CARD,h.PLAYER_CARD,h.WIN_TYPE,h.WIN_RESULT_TYPE,h.WIN_HANDS,h.USER_HAND,h.USER_ORDERS,h.PRE_FLOP,h.FLOP,h.TURN,h.RIVER,h.CREATED_DATE,h.REAL_REVENUE,h.BONUS_REVENUE,u.USERNAME,h.CUSTOM1  from hand_history as h,user as u where h.PLAY_GROUP_ID = '$id' and u.USER_ID = h.USER_ID");

		$gameDetailsInfo  =  $query->result();
//echo $this->db3->last_query(); die;
		return $gameDetailsInfo;
	}




	public function gameRake($tid){
		$this->load->database();
		$query = $this->db2->query('select RAKE,RAKE1,RAKE_CAP,RAKE_CAP1 from tournament where TOURNAMENT_ID='.$tid);
		$gameRake = $query->row();
		return $gameRake;
	}

	public function gameTournamentTableId($roomid){
			$CI = &get_instance();
						//setting the second parameter to TRUE (Boolean) the function will return the database object.
		$this->db2 = $CI->load->database('default', TRUE);
			$query = $this->db2->query('select TOURNAMENT_ID from tournament_tables where TOURNAMENT_TABLE_ID='.$roomid);
			$tableInfo = $query->row();
			return $tableInfo;
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
		$query = $this->db2->query('select TOURNAMENT_NAME from tournament_tables where TOURNAMENT_TABLE_ID = '.$id);
		$gameTypesInfo  =  $query->row();
		return $gameTypesInfo->TOURNAMENT_NAME;
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
		return $browseSQL->result();
	}

	public function getUserId($username){
		$this->load->database();
        $res=$this->db2->query("select USER_ID from user where USERNAME = '".$username."'");
        $result  =  $res->row();
		$userid   = $result->USER_ID;
		return $userid;
	}

	public function getUserName($id){
		$CI = &get_instance();
			//setting the second parameter to TRUE (Boolean) the function will return the database object.
		$this->db2 = $CI->load->database('default', TRUE);		//echo "select USERNAME from user where USER_ID = '".$id."'";
        $res=$this->db2->query("select USERNAME from user where USER_ID = '".$id."'");
        $result  =  $res->row();
		$userName   = $result->USERNAME;
		return $userName;
	}

	public function getGameTournamentTableID($tournamentID) {
        $this->db2->select('TOURNAMENT_TABLE_ID,TOURNAMENT_ID,TOURNAMENT_NAME')->from('tournament_tables');
		$this->db2->where('TOURNAMENT_ID',$tournamentID);
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function deleteGameTable($tournamentID) {
		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_tables');

		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament_levels');

		$this->db->where('TOURNAMENT_ID',$tournamentID);
		$this->db->delete('tournament');
	}

    public function ChkTournamentExists($tournamentName){
		$this->load->database();
        $res=$this->db2->query("Select * from tournament where TOURNAMENT_NAME = '".$tournamentName."'");
        $gameInfo  =  $res->row();
		return $gameInfo;
    }

	public function getSearchGamesCount($searchGameData) {
		if($this->session->userdata('searchGameDetails')!="") {
			$searchGameData = $this->session->userdata('searchGameDetails');
		}

		$partnerids  = $this->partner_model->loggedinPartnerIDs();
		$this->db3->where_in("p.PARTNER_ID",str_replace(",","','",$partnerids));
		
		if(!empty($searchGameData["TABLE_ID"]))
			$this->db3->where('p.TOURNAMENT_NAME', $searchGameData["TABLE_ID"]);
		if(!empty($searchGameData["GAME_TYPE"]))
			$this->db3->where('p.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
		if(!empty($searchGameData["GAME_ID"]))
			$this->db3->where('p.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
		if(!empty($searchGameData["STAKE"]))
			$this->db3->where('p.STAKE', $searchGameData["STAKE"]);
		if(!empty($searchGameData["PLAYER_ID"])) {
			$userID = $this->getUserId($searchGameData['PLAYER_ID']);
			$this->db3->where('p.USER_ID', $userID);
		}
		if(!empty($searchGameData["HAND_ID"]))
			$this->db3->where('p.INTERNAL_REFFERENCE_NO', $searchGameData["HAND_ID"]);
	
		if(!empty($searchGameData["START_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
		if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));
	
	  	$this->db3->group_by('p.PLAY_GROUP_ID');
		$browseSQL   = $this->db3->get('poker_game_transaction_history p');
		return $browseSQL->num_rows();
	}

	public function getSearchGameData($config,$searchGameData) {
		if($this->session->userdata('searchGameDetails')!="") {
			$searchGameData = $this->session->userdata('searchGameDetails');
		}
		$limit = $config["per_page"];
		$offset = $config["cur_page"];
	
		$this->db3->select('GAME_TRANSACTION_ID, USER_ID, MINIGAMES_TYPE_NAME, MINIGAMES_TYPE_ID, TOURNAMENT_TABLE_ID, SMALL_BLIND, BIG_BLIND, TOURNAMENT_NAME, PLAY_GROUP_ID, INTERNAL_REFFERENCE_NO, STAKE, WIN, POT, SUM(REVENUE) AS REVENUE, STARTED, ENDED, PARTNER_ID, REAL_REVENUE, BONUS_REVENUE, ACTUAL_REVENUE, SERVICE_TAX')->from('poker_game_transaction_history p');
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
		$this->db3->where_in("p.PARTNER_ID",str_replace(",","','",$partnerids));
		
		if(!empty($searchGameData["TABLE_ID"]))
			$this->db3->where('p.TOURNAMENT_NAME', $searchGameData["TABLE_ID"]);
		if(!empty($searchGameData["GAME_TYPE"]))
			$this->db3->where('p.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
		if(!empty($searchGameData["GAME_ID"]))
			$this->db3->where('p.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
		if(!empty($searchGameData["STAKE"]))
			$this->db3->where('p.STAKE', $searchGameData["STAKE"]);
		if(!empty($searchGameData["PLAYER_ID"])) {
			$userID = $this->getUserId($searchGameData['PLAYER_ID']);
			$this->db3->where('p.USER_ID', $userID);
		}
		if(!empty($searchGameData["HAND_ID"]))
			$this->db3->where('p.INTERNAL_REFFERENCE_NO', $searchGameData["HAND_ID"]);
	
		if(!empty($searchGameData["START_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
		if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));
	
		$this->db3->group_by('p.PLAY_GROUP_ID');
		$this->db3->order_by('p.GAME_TRANSACTION_ID','desc');
		$this->db3->limit($limit,$offset);
		$browseSQL   = $this->db3->get();
		return $browseSQL->result();
	}

	public function fetchUserPlaydata($playerId,$sdate,$edate){

		$this->db2->select("p.PLAY_ID,p.PLAY_GROUP_ID")->from('poker_play p');
		$userID = $this->getUserId($playerId);
		$this->db2->where('p.USER_ID', $userID);
		if(!empty($sdate))
			$this->db2->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %h:%m:%s") >=', date('Y-m-d H:i:s',strtotime($sdate)));
		if(!empty($sdate) && !empty($edate))
			$this->db2->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %h:%m:%s") <=', date('Y-m-d H:i:s',strtotime($edate)));

		$browseSQL   = $this->db2->get();
		$playGroupIDsr= $browseSQL->result();

		$allPlayGroupIDs = "";
		if(!empty($playGroupIDsr)) {
			foreach($playGroupIDsr as $pIndex=>$playGroupData1) {
				$allPlayGroupIDs[] = $playGroupData1->PLAY_GROUP_ID;
			}
		}

		$this->db2->select("g.PLAY_GROUP_ID")->from('game_history g');
		$this->db2->join('tournament_tables tt', 'tt.TOURNAMENT_TABLE_ID = g.TOURNAMENT_TABLE_ID', 'left');
		$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
		$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');
		$this->db2->where_in('g.PLAY_GROUP_ID', $allPlayGroupIDs);

		if(!empty($sdate))
			$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %h:%m:%s") >=', date('Y-m-d H:i:s',strtotime($sdate)));
		if(!empty($sdate) && !empty($edate))
			$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %h:%m:%s") <=', date('Y-m-d H:i:s',strtotime($edate)));

		$this->db2->order_by('g.GAME_HISTORY_ID','desc');
		$browseSQL = $this->db2->get();
		//$this->db2->last_query(); die;
		$allREs = $browseSQL->result();



		if(!empty($playGroupIDsr)) {



			$y=0;
			foreach($allREs as $pIndex=>$playGroupData) {


					$playGroupId =  $playGroupData->PLAY_GROUP_ID;
					//fetch playdate
                                        //$playGroupId = '1423912376036';

					$result = $this->userGameDetails($playGroupId,$userID);


					$minigametype = $result[0]->MINIGAMES_TYPE_NAME;
					$winAmount   = $result[0]->WIN;
					$playdata = $result[0]->PLAY_DATA;
					$playUserId = $result[0]->USER_ID;
					$tournamentName = $result[0]->TOURNAMENT_NAME;
					$stared         = $result[0]->STARTED;
					$pot_amount     = $result[0]->POT_AMOUNT;

					//split play data

					$splitInfo = $this->getTableCards($playdata,$userID);
					$playerCards = $this->getPlayerCards($playdata,$playUserId,$minigametype,$winAmount);

					$preFlopValue  = $this->getRoundInfo($playdata,$playUserId,0);
					$flopValue  = $this->getRoundInfo($playdata,$playUserId,1);
					$turnValue  = $this->getRoundInfo($playdata,$playUserId,2);
					$riverValue  = $this->getRoundInfo($playdata,$playUserId,3);

					$data1[$y]["DATE TIME"] = $stared;
					$data1[$y]["GAME TYPE"] = $minigametype;
					$data1[$y]["TABLE NAME"] = $tournamentName;

					$data1[$y]["WIN AMOUNT"] = $winAmount;
					$data1[$y]["POT AMOUNT"] = $pot_amount;


					$data1[$y]["PREFLOP"] = $preFlopValue;
					$data1[$y]["FLOP"] = $flopValue;
					$data1[$y]["TURN"] = $turnValue;
					$data1[$y]["RIVER"] = $riverValue;

					$tableCards = explode(",",$splitInfo);
					$tableCard1 = $tableCards[0];
					$tableCard2 = $tableCards[1];
					$tableCard3 = $tableCards[2];
					$tableCard4 = $tableCards[3];
					$tableCard5 = $tableCards[4];

					$playerCards = explode(",",$playerCards);
					$playerCard1 = $playerCards[0];
					$playerCard2 = $playerCards[1];
					$playerCard3 = $playerCards[2];
					$playerCard4 = $playerCards[3];

					$data1[$y]["T1"] = $tableCard1;
					$data1[$y]["T2"] = $tableCard2;
					$data1[$y]["T3"] = $tableCard3;
					$data1[$y]["T4"] = $tableCard4;
					$data1[$y]["T5"] = $tableCard5;

					$data1[$y]["P1"] = $playerCard1;
					$data1[$y]["P2"] = $playerCard2;
					$data1[$y]["P3"] = $playerCard3;
					$data1[$y]["P4"] = $playerCard4;



				$y++;
			}
		}

		return $data1;
	}

	public function getRoundInfo($data,$useridp,$roundv){
	  $playdata=json_decode($data,true);

		if(count($playdata['playResult']['userAction'])>0){
			if(count($playdata['playResult']['userAction']['ROUND:'.$roundv])>0){
				for($l=0;$l<count($playdata['playResult']['userAction']['ROUND:'.$roundv]);$l++){
					$round='ROUND:'.$roundv;
						$turn='TURN:'.$l;
							if(count($playdata['playResult']['userAction'][$round][$turn])>0){
								for($m=0;$m<count($playdata['playResult']['userAction'][$round][$turn]);$m++){
									$userid=$playdata['playResult']['userAction'][$round][$turn][$m]['userId'];
									if($userid==$useridp){
										$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
											if($action!=''){
												$betamt=$playdata['playResult']['userAction'][$round][$turn][$m]['currentAmount'];
													if($betamt){
														$sumValue += $betamt;
													}
								 				}
											}
									}
							}
						}
					}
			}

			return $sumValue;

	}

	public function userGameDetails($id,$userID){
		$this->load->database();
		$query = $this->db2->query("select p.USER_ID,u.USERNAME,p.MINIGAMES_TYPE_NAME,p.INTERNAL_REFERENCE_NO,p.GAME_REFERENCE_NO,p.STAKE,p.WIN,p.POT_AMOUNT,p.REVENUE,p.RAKE,
 p.PLAY_DATA,t.TOURNAMENT_NAME,t.TOURNAMENT_ID,date_format(p.STARTED,'%d-%m-%Y %H:%i:%s') as STARTED from poker_play p LEFT JOIN  user u ON u.USER_ID=p.USER_ID
 LEFT JOIN tournament_tables t ON p.ROOM_ID=t.TOURNAMENT_TABLE_ID where p.PLAY_GROUP_ID = '$id' and p.USER_ID = $userID");
		$gameDetailsInfo  =  $query->result();
		return $gameDetailsInfo;
	}


    public function getPlayerCards($data,$useridp,$minigametype,$winAmount){
			  if($winAmount!='0.00'){
			    $winuser_id = $useridp;
			  }else{
			    $winuser_id = 0;
			  }

			  if($data){
					$playdata=json_decode($data,true);


					$wintype=$playdata['playResult']['winType'];
					for($k=0;$k<count($playdata['playResult']['userHandCards']);$k++){
					   if($playdata['playResult']['userDetails'][$k]['userId']==$useridp){
							$smallblind=$playdata['playResult']['userDetails'][$k]['smallBlind'];
							$bigblind=$playdata['playResult']['userDetails'][$k]['bigBlind'];
							$tableindex=$playdata['playResult']['userDetails'][$k]['tableIndex'];
					if($minigametype=='Omaha'){
							$userHands=$playdata['playResult']['userHandCards'][$tableindex][0]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][1]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][2]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][3]['clientCard'];
					}else{
							$userHands=$playdata['playResult']['userHandCards'][$tableindex][0]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][1]['clientCard'];
					}
					   }
					}
		}




		 if($userHands){
							    if(strstr($userHands,",")){
							  		$usercard_details=explode(",",$userHands);

									if($playdata['playResult']['userDetails']){
										for($d=0;$d<count($playdata['playResult']['userDetails']);$d++){
											$userid=$playdata['playResult']['userDetails'][$d]['userId'];
											if($winuser_id==$userid){
												$matchcardslist=explode(",",$playdata['playResult']['userDetails'][$d]['matchCards']);
												for($r=0;$r<count($matchcardslist);$r++){
													if($matchcardslist[$r]!='card_back'){
														$matchcards1[]=$matchcardslist[$r];
													}
												}
											}
										}
								    }

									if(in_array($usercard_details[0],$matchcards1)){
										$borderstyle='border:2px solid #006633;background-color:#006633;';
									}else{
										$borderstyle='';
									}

									if(in_array($usercard_details[1],$matchcards1)){
										$borderstyle1='border:2px solid #006633;background-color:#006633;';
									}else{
										$borderstyle1='';
									}
									if($minigametype=='Omaha'){
										if(in_array($usercard_details[2],$matchcards1)){
											$borderstyle2='border:2px solid #006633;background-color:#006633;';
										}else{
											$borderstyle2='';
										}

										if(in_array($usercard_details[3],$matchcards1)){
											$borderstyle3='border:2px solid #006633;background-color:#006633;';
										}else{
											$borderstyle3='';
										}
									}

									if($winuser_id==$useridp) {

										$userWinHandsData = json_decode($data,true);
										$userWHDUserIDs = $userWinHandsData["playResult"]["winHands"]["userWinHands"][$winuser_id];
										$wHBorderStyle1 = 'border:2px solid #006633;background-color:#006633;';
										$wHBorderStyle = '';


										//if($userWHDUserIDs["0"]["clientCard"]==$usercard_details[0])
											$playUserCard[] = $usercard_details[0];



										//if($userWHDUserIDs["1"]["clientCard"]==$usercard_details[1])
											$playUserCard[] = $usercard_details[1];




									} else {
										$playUserCard[] = $usercard_details[0];
										$playUserCard[] = $usercard_details[1];
									}
									if($minigametype=='Omaha'){

$playUserCard[] = $usercard_details[0];
										$playUserCard[] = $usercard_details[1];

$playUserCard[] = $usercard_details[2];
										$playUserCard[] = $usercard_details[3];
									}
								}else{
									$playUserCard[] = $userHands;
								}
							  }



		$importValue1 = implode(",",$playUserCard);
		return $importValue1;

	}

	public function getTableCards($data,$useridp){
	  if($data){
			$playdata=json_decode($data,true);
			if($playdata['playResult']['dealerHand'][0]){
			  for($i=0;$i<count($playdata['playResult']['dealerHand']);$i++){
				$dealercard=$playdata['playResult']['dealerHand'][$i]['clientCard'];
				if($dealercard){
					$tCards[] = $dealercard;
				}
			  }
			}else{
				$dealercard=$playdata['playResult']['dealerHand']['clientCard'];
				if($dealercard){
					$tCards[] = $dealercard;
				}
			}
		}

		$importValue = implode(",",$tCards);
		return $importValue;


	}

	public function getTotalSearchData($searchGameData) {

		if($this->session->userdata('searchGameDetails')!="") {
			$searchGameData = $this->session->userdata('searchGameDetails');
		}

		$partnerids  = $this->partner_model->loggedinPartnerIDs();
		$this->db3->select("SUM(p.STAKE) AS TOTAL_STAKE,SUM(p.WIN) AS TOTAL_WIN,SUM(p.REVENUE) AS REVENUE")->from('poker_game_transaction_history p');
		$this->db3->where_in("p.PARTNER_ID",str_replace(",","','",$partnerids));
		
		if(!empty($searchGameData["TABLE_ID"]))
			$this->db3->where('p.TOURNAMENT_NAME', $searchGameData["TABLE_ID"]);
		if(!empty($searchGameData["GAME_TYPE"]))
			$this->db3->where('p.MINIGAMES_TYPE_ID', $searchGameData["GAME_TYPE"]);
		if(!empty($searchGameData["GAME_ID"]))
			$this->db3->where('p.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
		if(!empty($searchGameData["STAKE"]))
			$this->db3->where('p.STAKE', $searchGameData["STAKE"]);
		if(!empty($searchGameData["PLAYER_ID"])) {
			$userID = $this->getUserId($searchGameData['PLAYER_ID']);
			$this->db3->where('p.USER_ID', $userID);
		}
		if(!empty($searchGameData["HAND_ID"]))
			$this->db3->where('p.INTERNAL_REFFERENCE_NO', $searchGameData["HAND_ID"]);
	
		if(!empty($searchGameData["START_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %h:%m:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
		if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
			$this->db3->where('DATE_FORMAT(p.STARTED,"%Y-%m-%d %h:%m:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));
	
		$browseSQL = $this->db3->get();
		return $browseSQL->result();
	}


	public function getTotalSearchDataOld() {

		if($this->session->userdata('searchGameDetails')!="") {
			$searchGameData = $this->session->userdata('searchGameDetails');
		}

		if(!empty($searchGameData["PLAYER_ID"]) || !empty($searchGameData["HAND_ID"])) {
			$this->db2->select("utr.USER_TURNOVER_REPORT_ID,utr.USER_ID,utr.GAME_TRANSACTION_ID,utr.PARTNER_ID,utr.MINIGAMES_TYPE_NAME,utr.TOURNAMENT_NAME,".
			                  "utr.TOTAL_BETS AS TOTAL_STAKE,utr.TOTAL_WINS AS TOTAL_WIN,utr.TOTAL_POT,utr.TOTAL_RAKE AS TOTAL_REVENUE,".
			                  "utr.REPORT_DATE AS STARTED,utr.UPDATED_DATE  AS ENDED,gth.PLAY_GROUP_ID,t.SMALL_BLIND,t.BIG_BLIND,".
						      "c.NAME as CURRENCY_TYPE")->from('user_turnover_report_daily utr');
			$this->db2->join('game_transaction_history gth', 'gth.GAME_TRANSACTION_ID = utr.GAME_TRANSACTION_ID', 'left');
			$this->db2->join('tournament_tables tt', 'tt.TOURNAMENT_TABLE_ID = gth.TOURNAMENT_TABLE_ID', 'left');
			$this->db2->join('tournament t', 't.TOURNAMENT_ID = tt.TOURNAMENT_ID', 'left');
			$this->db2->join('coin_type c', 'c.COIN_TYPE_ID = t.COIN_TYPE_ID', 'left');

			//if(!empty($searchGameData["HAND_ID"]))
				//$this->db2->join('poker_play pp', 'pp.PLAY_GROUP_ID = gth.PLAY_GROUP_ID', 'left');

			if(!empty($searchGameData["TABLE_ID"]))
				$this->db2->where('utr.TOURNAMENT_NAME', $searchGameData["TABLE_ID"]);
			if(!empty($searchGameData["GAME_TYPE"]))
				$this->db2->where('t.MINI_GAME_TYPE_ID', $searchGameData["GAME_TYPE"]);
			if(!empty($searchGameData["GAME_ID"]))
				$this->db2->where('gth.PLAY_GROUP_ID', $searchGameData["GAME_ID"]);
			if(!empty($searchGameData["CURRENCY_TYPE"]))
				$this->db2->where('t.COIN_TYPE_ID', $searchGameData["CURRENCY_TYPE"]);
			if(!empty($searchGameData["STAKE"]))
				$this->db2->where('utr.TOTAL_BETS', $searchGameData["STAKE"]);
			if(!empty($searchGameData["PLAYER_ID"])) {
				$userID = $this->getUserId($searchGameData['PLAYER_ID']);
				$this->db2->where('utr.USER_ID', $userID);
			}
			if(!empty($searchGameData["HAND_ID"]))
				$this->db2->where('gth.INTERNAL_REFFERENCE_NO', $searchGameData["HAND_ID"]);

			if(!empty($searchGameData["START_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(utr.REPORT_DATE,"%Y-%m-%d %h:%m:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(utr.REPORT_DATE,"%Y-%m-%d %h:%m:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db2->order_by('utr.USER_TURNOVER_REPORT_ID','desc');
			$browseSQL = $this->db2->get();
			return $browseSQL->result();
		} else {
			$this->db2->select("g.GAME_HISTORY_ID,g.MINIGAMES_TYPE_ID,g.TOURNAMENT_TABLE_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,".						 			                          "g.TOTAL_POT,g.TOTAL_REVENUE,g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED,tt.TOURNAMENT_NAME,".
							  "t.SMALL_BLIND,t.BIG_BLIND,c.NAME as CURRENCY_TYPE")->from('game_history g');
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
				$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %h:%m:%s") >=', date('Y-m-d H:i:s',strtotime($searchGameData["START_DATE_TIME"])));
			if(!empty($searchGameData["START_DATE_TIME"]) && !empty($searchGameData["END_DATE_TIME"]))
				$this->db2->where('DATE_FORMAT(g.STARTED,"%Y-%m-%d %h:%m:%s") <=', date('Y-m-d H:i:s',strtotime($searchGameData["END_DATE_TIME"])));

			$this->db2->order_by('g.GAME_HISTORY_ID','desc');

			$this->db2->limit(1);

			$browseSQL14 = $this->db2->get();
			//echo $this->db2->last_query(); die;
			//echo "test"; die;

			return $browseSQL14->result();
		}
	}

	public function getGameHistoryData($playGruopID) {
 		$this->db3->select("g.GAME_HISTORY_ID,g.PLAY_GROUP_ID,g.TOTAL_PLAYERS,g.TOTAL_STAKE,g.TOTAL_WIN,g.TOTAL_POT,g.TOTAL_REVENUE,".
		                  "g.STA_RAKE_PERCENTAGE,g.APP_RAKE_PERCENTAGE,g.SIDE_POT,g.STARTED,g.ENDED")->from('game_history g');
		$this->db3->where('g.PLAY_GROUP_ID',$playGruopID);

		$browseSQL = $this->db3->get();
//echo $this->db2->last_query(); die;
    return $browseSQL->result();
	}

 public function getListOfAllActiveGames(){
  $res = $this->db2->query("SELECT rtt.TOURNAMENT_TABLE_ID,rtt.tournament_name FROM tournament rt INNER JOIN tournament_tables rtt ON rtt.TOURNAMENT_ID = rt.TOURNAMENT_ID WHERE rt.IS_ACTIVE = 1 AND rt.TOURNAMENT_TYPE_ID=6 AND (rt.COIN_TYPE_ID=1 OR rt.COIN_TYPE_ID=6) order by rt.tournament_name asc");
  $activeGames = $res->result();
  return $activeGames;
 }

 public function getListOfActiveGames(){
  $this->load->database();
  $res = $this->db2->query("select MINIGAMES_NAME,DESCRIPTION from minigames where STATUS=1 AND minigames_id not in (61,62)");
  $activeGames = $res->result();
  return $activeGames;
 }

public function getGameRefCode($gameId){
  $this->load->database();
  $resVal = $this->db2->query("select REF_GAME_CODE from minigames where MINIGAMES_NAME='".$gameId."'");
  $gameCode = $resVal->result();
  return $gameCode[0]->REF_GAME_CODE;
 }
public function getGamesHistoryCountBySearchCriteria($data){
  $this->db2->select('u.USERNAME,sum(vth.TOTAL_BETS) as TOT_BETS,sum(vth.TOTAL_WINS) as TOT_WINS,sum(vth.TOTAL_RAKE) as TOT_REFUNDS')->from('user_turnover_report_daily vth');
  $this->db2->join('user u ', 'vth.USER_ID = u.USER_ID');
  //pagination config values
  $userid = $this->getUserId($data["playerID"]);
  //search where conditions
  if(!empty($data["playerID"]))
   $this->db2->where('vth.USER_ID', $userid);

  if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
   $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
  }else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
      $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
  }else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
      $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
   $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
  }
  $this->db2->group_by('u.USER_ID');
  $browseSQL = $this->db2->get();
  $results  = $browseSQL->result();
  return count($results);
 }
public function getUserGameHistoryBySearchCriteria($config,$data){
  $this->db2->select('u.USERNAME,sum(vth.TOTAL_BETS) as TOT_BETS,sum(vth.TOTAL_WINS) as TOT_WINS,sum(vth.TOTAL_RAKE) as TOTAL_RAKE')->from('user_turnover_report_daily vth');
  $this->db2->join('user u ', 'vth.USER_ID = u.USER_ID');
  //pagination config values
  $limit  = $config["per_page"];
  $offset = $config["cur_page"];
  $userid = $this->getUserId($data["playerID"]);
  //search where conditions
  $this->db2->where('vth.TOURNAMENT_NAME', $data["gameID"]);
  if(!empty($data["playerID"]))
   $this->db2->where('vth.USER_ID', $userid);

  if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
   $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
  }else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
      $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
  }else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
      $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
   $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
  }
  $this->db2->group_by('u.USER_ID');

  $this->db2->limit($limit,$offset);
  $browseSQL = $this->db2->get();
  $results  = $browseSQL->result();
  return $results;
 }
public function getGamesBetWinEndBySearchCriteria($data){
  $this->db2->select('u.USERNAME,sum(vth.TOTAL_BETS) as TOT_BETS,sum(vth.TOTAL_WINS) as TOT_WINS,sum(vth.TOTAL_RAKE) as TOTAL_RAKE')->from('user_turnover_report_daily vth');
  $this->db2->join('user u ', 'vth.USER_ID = u.USER_ID');

  $userid = $this->getUserId($data["playerID"]);
  //search where conditions
  $this->db2->where('vth.TOURNAMENT_NAME', $data["gameID"]);
  if(!empty($data["playerID"]))
   $this->db2->where('vth.USER_ID', $userid);

  if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
   $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
  }else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
      $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
  }else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
      $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
   $this->db2->where('DATE_FORMAT(vth.REPORT_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
  }

  $browseSQL = $this->db2->get();
  $results  = $browseSQL->result();
  return $results;
 }

 public function getExportData($rquery){
 //echo $query; die;
	if($rquery != ''){
	$query = $this->db2->query($rquery);
	 $gameInfo  =  $query->result();
	 return $gameInfo;
	}
 }

}
