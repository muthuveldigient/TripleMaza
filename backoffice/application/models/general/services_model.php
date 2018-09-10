<?php
class Services_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	
	/* BELOW ARE THE FUNCTIONS TO GENERATE REVENUE HISTORICAL DATA */
	public function getPartnersData() {
		$this->db2->select('t1.PARTNER_ID,t1.FK_PARTNER_TYPE_ID,t1.PARTNER_REVENUE_SHARE')->from('partner t1');
		$this->db2->order_by('t1.PARTNER_ID','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}
	
	public function getSelfPlayersData($partnerID) {
		$this->db2->select('USER_ID')->from('user');
		$this->db2->where('PARTNER_ID',$partnerID);
		$this->db2->order_by('USER_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();
	}
	
	public function betwinAmountData($betwinAmount,$arrData,$betwinAmountTT_ID) {
		$this->db2->select('SUM(TRANSACTION_AMOUNT) as betwinAmount')->from('master_transaction_history');
		$this->db2->where('PARTNER_ID',$arrData["PARTNER_ID"]);
		$this->db2->where('TRANSACTION_TYPE_ID',$betwinAmountTT_ID["tTypeID"]);
		$this->db2->where_in('USER_ID',$arrData["userIDs"]);		
		$this->db2->where("DATE_FORMAT(TRANSACTION_DATE,'%Y-%m-%d') >= ",$betwinAmount["startDate"]);
		$this->db2->where("DATE_FORMAT(TRANSACTION_DATE,'%Y-%m-%d') <= ",$betwinAmount["endDate"]);
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();		
	}
	
	public function getAffiliatePartnersData($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.FK_PARTNER_TYPE_ID,t1.PARTNER_REVENUE_SHARE')->from('partner t1');
		$this->db2->where('t1.FK_PARTNER_ID',$partnerID);
		$this->db2->order_by('t1.PARTNER_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();			
	}
	
	public function getAffiliatePlayersData($affiliatePartnersID) {
		$this->db2->select('USER_ID')->from('user');
		$this->db2->where('PARTNER_ID',$affiliatePartnersID);
		$this->db2->order_by('USER_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();			
	}
	
	public function addRevenueHistoricalData($rHistoricalData) {
		$browseSQL = $this->db->insert('zrevenue_historical_data',$rHistoricalData);	
		return $browseSQL->result;			
	}
	
	public function getAdminUserID($partnerID) {
		$this->db2->select('ADMIN_USER_ID')->from('admin_user');
		$this->db2->where('FK_PARTNER_ID',$partnerID);
		$browseSQL = $this->db2->get();
		return $browseSQL->result();		
	}
	/* BELOW ARE THE FUNCTIONS TO GENERATE REVENUE HISTORICAL DATA */
	
	
	/* BELOW ARE THE FUNCTIONS TO GENERATE CASHFLOW HISTORICAL DATA */
	public function cashINAmountData($cashINcashOUTDate,$arrData,$cashIN_TT_ID) {
		$this->db2->select('SUM(TRANSACTION_AMOUNT) as cashINAmountData')->from('master_transaction_history');
		$this->db2->where('PARTNER_ID',$arrData["PARTNER_ID"]);
		$this->db2->where('TRANSACTION_TYPE_ID',$cashIN_TT_ID["tTypeID1"]);
		$this->db2->or_where('TRANSACTION_TYPE_ID',$cashIN_TT_ID["tTypeID2"]);		
		$this->db2->where_in('USER_ID',$arrData["userIDs"]);		
		$this->db2->where("DATE_FORMAT(TRANSACTION_DATE,'%Y-%m-%d') >= ",$cashINcashOUTDate["startDate"]);
		$this->db2->where("DATE_FORMAT(TRANSACTION_DATE,'%Y-%m-%d') <= ",$cashINcashOUTDate["endDate"]);
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();	
	}
	
	public function cashOUTAmountData($cashINcashOUTDate,$arrData,$cashOUT_TT_ID) {
		$this->db2->select('SUM(TRANSACTION_AMOUNT) as cashOUTAmountData')->from('master_transaction_history');
		$this->db2->where('PARTNER_ID',$arrData["PARTNER_ID"]);
		$this->db2->where('TRANSACTION_TYPE_ID',$cashOUT_TT_ID["tTypeID"]);		
		$this->db2->where_in('USER_ID',$arrData["userIDs"]);		
		$this->db2->where("DATE_FORMAT(TRANSACTION_DATE,'%Y-%m-%d') >= ",$cashINcashOUTDate["startDate"]);
		$this->db2->where("DATE_FORMAT(TRANSACTION_DATE,'%Y-%m-%d') <= ",$cashINcashOUTDate["endDate"]);
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();			
	}
	
	public function addCashflowHistoricalData($cHistoricalData) {
		$browseSQL = $this->db->insert('zcashflow_historical_data',$cHistoricalData);	
		return $browseSQL->result;		
	}
	/* BELOW ARE THE FUNCTIONS TO GENERATE CASHFLOW HISTORICAL DATA */	
	
	/* BELOW ARE THE FUNCTIONS TO GENERATE USERS HISTORICAL DATA */
	public function getSelfPlayersDataCount($partnerID,$userRegisteredDate) {
		$this->db2->select('USER_ID')->from('user');
		$this->db2->where('PARTNER_ID',$partnerID);
		$this->db2->where("DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d') >= ",$userRegisteredDate["startDate"]);
		$this->db2->where("DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d') <= ",$userRegisteredDate["endDate"]);
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}
	
	public function addUsersHistoricalData($uHistoricalData) {
		$browseSQL = $this->db->insert('zusers_historical_data',$uHistoricalData);	
		return $browseSQL->result;			
	}
	/* BELOW ARE THE FUNCTIONS TO GENERATE USERS HISTORICAL DATA */
	
	
	/* BELOW ARE THE FUNCTIONS USED FOR ONLINE SYSTEM - DASHBOARD */
	
	public function getXPartnersData() {
		$this->db2->select('t1.PARTNER_ID')->from('partner t1');
		$this->db2->order_by('t1.PARTNER_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();			
	}
	
	public function getTotRegPlayers($partnerID) {
		$this->db2->select('u1.USER_ID')->from('user u1');
		$this->db2->where('u1.PARTNER_ID',$partnerID);
		$this->db2->order_by('u1.USER_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();		
	}
	
	public function getTotDepPlayers($userIDs) {
		$this->db2->distinct('p.USER_ID')->from('payment_transaction p');
		$this->db2->where_in('p.USER_ID',$userIDs);
		$this->db2->where('PAYMENT_TRANSACTION_STATUS',103);
		$this->db2->or_where('PAYMENT_TRANSACTION_STATUS',125);				
		$this->db2->order_by('p.PAYMENT_TRANSACTION_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;		
		return $browseSQL->result();			
	}
	
	public function getTotRegPlayersMonth($partnerID,$startDate,$endDate) {
		$this->db2->select('u1.USER_ID')->from('user u1');
		$this->db2->where('u1.PARTNER_ID',$partnerID);
		$this->db2->where("DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d') >= ",$startDate);
		$this->db2->where("DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d') <= ",$endDate);		
		$this->db2->order_by('u1.USER_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();		
	}

	public function getTotDepPlayersMonth($userIDs,$startDate,$endDate) {
		$this->db2->distinct('p.USER_ID')->from('payment_transaction p');
		$this->db2->where_in('p.USER_ID',$userIDs);	
		$this->db2->where('PAYMENT_TRANSACTION_STATUS',103);
		$this->db2->or_where('PAYMENT_TRANSACTION_STATUS',125);				
		$this->db2->where("DATE_FORMAT(PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') >= ",$startDate);
		$this->db2->where("DATE_FORMAT(PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') <= ",$endDate);		
		$this->db2->order_by('p.PAYMENT_TRANSACTION_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();		
	}
	
	public function addxUsersHistoricalData($xUserHistoricalData) {	
		$browseSQL = $this->db->insert('xusers_historical_data',$xUserHistoricalData);	
		return $browseSQL->result;			
	}	
	
	/* BELOW ARE THE FUNCTIONS USED FOR ONLINE SYSTEM - DASHBOARD */		
}
?>