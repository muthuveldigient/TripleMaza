<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Game History
  Auther 	    : Sivakumar
*/
class agentgamehistory_Model extends CI_Model
{
   
	public function getAllPaymentStatus(){
		$querycnt=$this->db2->query("select * from transaction_status");  
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}
	
	public function getAllTransactionTypes(){
		$querycnt=$this->db2->query("select * from transaction_type");  
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}
	
	
	public function getListOfActiveGames(){
		$res = $this->db2->query("select MINIGAMES_NAME,DESCRIPTION from minigames where STATUS=1");
		$activeGames = $res->result();
		return $activeGames;
	}
	
	public function getGameRefCode($gameId){
		
		$resVal = $this->db2->query("select REF_GAME_CODE from minigames where MINIGAMES_NAME='".$gameId."'");
		if($resVal->num_rows() > 0)
		{
    	$row = $resVal->row();
		$gameCode = $row->REF_GAME_CODE;
		}else{
		$gameCode = '';
		}
		 
		return $gameCode;
	}
	
	public function getGamesHistoryBySearchCriteria($config,$data){
		//echo "<pre>"; print_r($config); die; 
		//get partnerids		
		$partnerids  = $data['loggedInPartnersList']; 
		//$partnerids = explode(",",$partnerids);
		$this->db3->select('u.USERNAME,sum(vth.BET_POINTS) as TOT_BETS,sum(vth.WIN_POINTS) as TOT_WINS,sum(vth.REFUND_POINTS) as TOT_REFUNDS')->from('view_transaction_history vth');
		$this->db3->join('user u ', 'vth.USER_ID = u.USER_ID');
		$this->db3->where_in("u.PARTNER_ID",$partnerids);
		//pagination config values
		$limit  = $config["per_page"];
		$offset = $config["cur_page"];
		$userid = $this->getUserId($data["PLAYER_ID"]);
		//search where conditions
		if(!empty($data["PLAYER_ID"]))
			$this->db3->where('vth.USER_ID', $userid);
		if(!empty($data["GameRefCode"]))
			$this->db3->like('vth.INTERNAL_REFERENCE_NO', $data["GameRefCode"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('vth.TRANSACTION_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('vth.TRANSACTION_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('vth.TRANSACTION_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('vth.TRANSACTION_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
		}
		$this->db3->group_by('vth.USER_ID');
		//$this->db->order_by($config['order_by'], $config['sort_order']);
		$this->db3->limit($limit,$offset);			
		$browseSQL = $this->db3->get();
		
		$results  = $browseSQL->result();
	//	echo $this->db->last_query();
		return $results;
	}
	
	public function getUserGameHistoryBySearchCriteria($config,$data){
		//echo "<pre>"; print_r($data); die; 
		//get partnerids		
		$partnerids  = $data['loggedInPartnersList']; 
	//	$partnerids = explode(",",$partnerids);
		$this->db3->select('USERNAME as USERNAME,t1.GAME_REFERENCE_NO as INTERNAL_REFERENCE_NO,t1.OPENING_TOT_BALANCE as CURRENT_TOT_BALANCE,t1.BET_POINTS + t1.LOSS + t1.FORCED_BET as BET_POINTS,t1.WIN_POINTS as WIN_POINTS,t1.TRANSACTION_DATE as TRANSACTION_DATE,t1.CLOSING_TOT_BALANCE as CLOSING_TOT_BALANCE')->from('shan_view_transaction_history t1');
		$this->db3->join('user t3 ', 't1.USER_ID = t3.USER_ID');
		$this->db3->where_in("t3.PARTNER_ID",$partnerids);
		$this->db3->order_by("t1.TRANSACTION_DATE", "desc"); 
		//pagination config values
		$limit  = $config["per_page"];
		$offset = $config["cur_page"];
		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('t1.USER_ID', $userid);
		if($data["intRefNo"] != '' && $data["GameRefCode"] != ''){
			$this->db3->where('t1.GAME_REFERENCE_NO', $data["intRefNo"]);
		}elseif($data["intRefNo"] != '' && $data["GameRefCode"] == ''){
			$this->db3->where('t1.GAME_REFERENCE_NO', $data["intRefNo"]);
		}elseif($data["intRefNo"] == '' && $data["GameRefCode"] != ''){
			$this->db3->like('t1.GAME_REFERENCE_NO', $data["GameRefCode"]);					
		}
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' && $data["intRefNo"] == '') {
			$this->db3->where('t1.TRANSACTION_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' && $data["intRefNo"] == '') {
		    $this->db3->where('t1.TRANSACTION_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) && $data["intRefNo"] == '') {
		    $this->db3->where('t1.TRANSACTION_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('t1.TRANSACTION_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
		}
		
		//$this->db->order_by($config['order_by'], $config['sort_order']);
		$this->db3->limit($limit,$offset);			
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		//echo $this->db3->last_query();exit;
		return $results;
	}
	
	public function getUserGameHistoryBySearchCriteriaCount($data){
		//echo "<pre>"; print_r($data); die; 
		//get partnerids		
		$partnerids  = $data['loggedInPartnersList']; 
	//	$partnerids = explode(",",$partnerids);
		$this->db3->select('USERNAME as USERNAME,t1.GAME_REFERENCE_NO as INTERNAL_REFERENCE_NO,t1.OPENING_TOT_BALANCE as CURRENT_TOT_BALANCE,t1.BET_POINTS as BET_POINTS,t1.WIN_POINTS as WIN_POINTS,t1.TRANSACTION_DATE as TRANSACTION_DATE,t1.CLOSING_TOT_BALANCE as CLOSING_TOT_BALANCE')->from('shan_view_transaction_history t1');
		$this->db3->join('user t3 ', 't1.USER_ID = t3.USER_ID');
		$this->db3->where_in("t3.PARTNER_ID",$partnerids);
		$this->db3->order_by("t1.TRANSACTION_DATE", "desc"); 
		//pagination config values
		$userid = $this->getUserId($data["playerID"]);
		//search where conditions
		if(!empty($data["playerID"]))
			$this->db3->where('t1.USER_ID', $userid);
		if($data["intRefNo"] != '' && $data["GameRefCode"] != ''){
			$this->db3->where('t1.GAME_REFERENCE_NO', $data["intRefNo"]);
		}elseif($data["intRefNo"] != '' && $data["GameRefCode"] == ''){
			$this->db3->where('t1.GAME_REFERENCE_NO', $data["intRefNo"]);
		}elseif($data["intRefNo"] == '' && $data["GameRefCode"] != ''){
			$this->db3->like('t1.GAME_REFERENCE_NO', $data["GameRefCode"]);					
		}
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' && $data["intRefNo"] == '') {
			$this->db3->where('t1.TRANSACTION_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' && $data["intRefNo"] == '') {
		    $this->db3->where('t1.TRANSACTION_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) && $data["intRefNo"] == '') {
		    $this->db3->where('t1.TRANSACTION_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('t1.TRANSACTION_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
		}
		
		//$this->db->order_by($config['order_by'], $config['sort_order']);
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		$countval = count($results);
		return $countval;
	}
	
	public function getAllChildPartner($agentid) {
		    $partner_type=$this->getPartnerType($agentid);		
			$partnerids=$agentid;
			
			if($partner_type[0]->FK_PARTNER_TYPE_ID==11){
				$distributorlists=$this->getPartnerList($agentid,12);				
				$distids="";
				if(isset($distributorlists)){
					foreach($distributorlists as $key=>$value){
						if($partnerids){
							$partnerids=$partnerids.",".$distributorlists[$key]->PARTNER_ID;
							$distids=$distids.",".$distributorlists[$key]->PARTNER_ID;
						}else{
							$partnerids=$distributorlists[$key]->PARTNER_ID;	
							$distids=$distributorlists[$key]->PARTNER_ID;	
						}	
					}
				}
				
				if(isset($distids)){
					$subdistributorlists=$this->getPartnerList($distids,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								$subdistids=$distids.",".$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;	
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;	
							}	
						}	
					}
					
					if(isset($subdistids)){
						$subdistagentlist=$this->getPartnerList($subdistids,14);
					
						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;	
								}	
							}
						}
					}
					
					if(isset($distids)){
					$agentslists=$this->getPartnerList($distids,14);
					}
					
					if(isset($agentslists)){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;	
							}	
						}
					}
				}
			}elseif($partner_type[0]->FK_PARTNER_TYPE_ID==12){
					$subdistributorlists=$this->getPartnerList($agentid,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								$subdistids=$distids.",".$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;	
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;	
							}	
						}	
					}
					
					if($subdistids){
						$subdistagentlist=$this->getPartnerList($subdistids,14);
						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;	
								}	
							}
						}
					}
					
					$agentslists==$this->getPartnerList($distids,14);
					
					if($agentslists){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;	
							}	
						}
					}
			}elseif($partner_type[0]->FK_PARTNER_TYPE_ID==13){
					$subdistagentlist=$this->getPartnerList($agentid,14);
					if($subdistagentlist){
						foreach($subdistagentlist as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistagentlist[$key]->PARTNER_ID;	
							}	
						}
					}
					
					
					$agentslists==$this->getPartnerList($distids,14);
					
					if($agentslists){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;	
							}	
						}
					}
			}
			
			
			return $partnerids;
	}
	
	
	public function getPartnerType($partnerid) {
		$this->db2->select("FK_PARTNER_TYPE_ID")->from("partner");
		$this->db2->where("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		return $result->result();
	}
	
	public function getPartnerList($partnerid,$partner_type) {
		$this->db2->select("PARTNER_ID")->from("partner");
		$this->db2->where("FK_PARTNER_ID",$partnerid);
		$this->db2->where("FK_PARTNER_TYPE_ID",$partner_type);
		$result=$this->db2->get();
		return $result->result();
	}
	
	public function getPartnersNameList($partnerid) {
		$this->db2->select("PARTNER_ID,PARTNER_USERNAME")->from("partner");
		$this->db2->where_in("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		//echo $this->db->last_query();
		return $result->result();
	}
	
	public function getUserById($userid) {
		$this->db2->select("USERNAME,PARTNER_ID")->from("user");
		$this->db2->where("USER_ID",$userid);
		$result=$this->db2->get();
		return $result->result();
	}
	
	public function getUserClosingBal($refno) {
		$this->db2->select("CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE")->from("master_transaction_history");
		$this->db2->where("INTERNAL_REFERENCE_NO",$refno);
		$result=$this->db2->get();
		return $result->result();
	}
	
	public function getPartnerId($partnerid) {
		$this->db2->select("PARTNER_ID,PARTNER_USERNAME,FK_PARTNER_TYPE_ID")->from("partner");
		$this->db2->where("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		return $result->result();
	}
	
	

	
	
	public function getUserId($username){
        $res=$this->db2->query("select USER_ID from user where USERNAME = '".$username."'");
		if($res->num_rows() >0 ){
        $result  =  $res->row();
		$userid   = $result->USER_ID;
		}else{
		$userid = '';
		}
		return $userid;
	}
	
	public function getGameNameByMinigamesId($handId){
		$gameCode = substr($handId, 0, 3); 
		$query = $this->db2->query('select MINIGAMES_NAME from minigames where REF_GAME_CODE="'.$gameCode.'"');
		if($query->num_rows() >0 ){
        $result  =  $query->row();
		$minigame_name   = $result->MINIGAMES_NAME;
		}else{
		 $minigame_name = ''; 
		}
		//echo $minigame_name; die;
		return $minigame_name;
	}
	
	public function getPlayGroupIdByHandId($handid){
		$this->db2->select("PLAY_GROUP_ID")->from("shan_play");
		$this->db2->where("GAME_REFERENCE_NO",$handid);
		$result=$this->db2->get();
		return $result->result();
	}
	
}