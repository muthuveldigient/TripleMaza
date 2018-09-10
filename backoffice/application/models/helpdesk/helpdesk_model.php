<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class Helpdesk_Model extends CI_Model{

	public function getExcludeUserMsg($userid){
			$sql_agent=$this->db2->query("select DESCRIPTION from exclude_players where USER_ID = $userid order by USER_DEACTIVE_ID desc limit 1");
			$userInfo  = $sql_agent->row();
            return htmlspecialchars($userInfo->DESCRIPTION);
	}
	
	public function getUserDeactivatedDate($userid){
			$sql_agent=$this->db2->query("select DATE from exclude_players where USER_ID = $userid order by USER_DEACTIVE_ID desc limit 1");
			$userInfo  = $sql_agent->row();
            return $userInfo->DATE;
	}
	
	
	public function getAllWalletTransactionCount($data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();

        $this->db3->select('count(*) as cnt')->from('shan_view_transaction_history');
		$this->db3->where_in("PARTNER_ID",$partnerids);

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["amount"]))
			$this->db3->like('TRANSACTION_AMOUNT', $data["amount"]);
		if(!empty($data["playgroupid"]))
			$this->db3->where('PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
				
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results[0]->cnt;
	}
	
	public function getTotalWalletBet($data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
        $this->db3->select('sum(BET_POINTS) as BET')->from('shan_view_transaction_history');
		$this->db3->where_in("PARTNER_ID",str_replace(",","','",$partnerids));

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["playgroupid"]))
			$this->db3->where('PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
				
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results[0]->BET;
	}	
	
	public function getTotalWalletLoss($data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
        $this->db3->select('sum(LOSS) as LOSS')->from('shan_view_transaction_history');
		$this->db3->where_in("PARTNER_ID",str_replace(",","','",$partnerids));

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["playgroupid"]))
			$this->db3->where('PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
				
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results[0]->LOSS;
	}	

	public function getTotalWalletForceBet($data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
        $this->db3->select('sum(FORCED_BET) as FORCED_BET')->from('shan_view_transaction_history');
		$this->db3->where_in("PARTNER_ID",str_replace(",","','",$partnerids));

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["playgroupid"]))
			$this->db3->where('PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
				
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results[0]->FORCED_BET;
	}
	
	public function getTotalWalletWin($data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
        $this->db3->select('sum(WIN_POINTS) as WIN')->from('shan_view_transaction_history');
		$this->db3->where_in("PARTNER_ID",str_replace(",","','",$partnerids));

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["playgroupid"]))
			$this->db3->where('PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
				
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results[0]->WIN;
	}
	
	public function getTotalWalletRake($data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
        $this->db3->select('sum(RAKE) as RAKE')->from('shan_view_transaction_history');
		$this->db3->where_in("PARTNER_ID",str_replace(",","','",$partnerids));

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["playgroupid"]))
			$this->db3->where('PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
				
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results[0]->RAKE;
	}	
	
	public function getAllWalletTransaction($config,$data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
		$this->db3->select('sv.USER_ID, sv.GAME_REFERENCE_NO, sv.PLAY_GROUP_ID, sv.GAME_ID, sv.OPENING_TOT_BALANCE, sv.CLOSING_TOT_BALANCE, sv.BET_POINTS, sv.WIN_POINTS, sv.LOSS, sv.FORCED_BET, sv.RAKE, sv.TRANSACTION_DATE')->from('shan_view_transaction_history sv');
		//$this->db->join('shan_play sp', 'sv.GAME_REFERENCE_NO=sp.GAME_REFERENCE_NO');
		$this->db3->where_in("sv.PARTNER_ID",str_replace(",","','",$partnerids));
		//pagination config values
		$limit = $config["per_page"];
		$offset = $config["cur_page"];

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db3->where('sv.USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db3->like('sv.GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["playgroupid"]))
			$this->db3->like('sv.PLAY_GROUP_ID', $data["playgroupid"]);			
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('DATE_FORMAT(sv.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db3->where('DATE_FORMAT(sv.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db3->where('DATE_FORMAT(sv.TRANSACTION_DATE,"%Y-%m-%d") >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('DATE_FORMAT(sv.TRANSACTION_DATE,"%Y-%m-%d") <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
		
		$this->db3->order_by('sv.VIEW_TRANSACTION_ID', 'desc');
		$this->db3->limit($limit,$offset);			
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results;
	}
	
	public function getWalletSumTransactionAmout($config,$data){
		$partnerids  = $this->partner_model->loggedinPartnerIDs();
		$this->db2->select('SUM(TRANSACTION_AMOUNT) as tot_trans')->from('shan_wallet_transaction');
		$this->db2->where("PARTNER_ID",$partner_id);
		//pagination config values
		$limit = $config["per_page"];
		$offset = $config["cur_page"];

		//transaction type ids
		if($data['trans_type']==''){
			$trans_type = array('11','12','66','67');
		}else{
			$trans_type = $data['trans_type'];
		}

		//search where conditions
		if(!empty($data["user_id"]))
			$this->db2->where('USER_ID', $data["user_id"]);
		if(!empty($data["ref_id"]))
			$this->db2->like('GAME_REFERENCE_NO', $data["ref_id"]);
		if(!empty($data["amount"]))
			$this->db2->where('TRANSACTION_AMOUNT', $data["amount"]);
		if(!empty($trans_type))
			$this->db2->where_in('TRANSACTION_TYPE_ID', $trans_type);	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('CREATED >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
		    $this->db2->where('CREATED <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
		    $this->db2->where('CREATED >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('CREATED <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));		
		}
		$this->db2->order_by($config['order_by'], $config['sort_order']);
		$this->db2->limit($limit,$offset);			
		$browseSQL = $this->db2->get();
		$results  = $browseSQL->result();
		$sumAmount  = $results[0]->tot_trans;
		return $sumAmount;
	}
	
		
}