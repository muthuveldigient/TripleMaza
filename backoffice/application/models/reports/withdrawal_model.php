<?php
//error_reporting(E_ALL);
class Withdrawal_Model extends CI_Model {
	function __construct(){
		$this->load->database();
	}

	public function getWithdrawRequestsCount($withdrawalSearchData) {
		 $this->db2->select('m.USER_ID,m.TRANSACTION_AMOUNT,m.INTERNAL_REFERENCE_NO,m.TRANSACTION_STATUS_ID,m.TRANSACTION_DATE,u.USERNAME,ts.TRANSACTION_STATUS_DESCRIPTION')->from('master_transaction_history m');
		$this->db2->join('user u', 'u.USER_ID = m.USER_ID', 'left');
		$this->db2->join('transaction_status ts', 'ts.TRANSACTION_STATUS_ID = m.TRANSACTION_STATUS_ID', 'left');
		if(!empty($withdrawalSearchData["USERNAME"]))
			$this->db2->where('u.USERNAME',$withdrawalSearchData["USERNAME"]);

		if(!empty($withdrawalSearchData["INTERNAL_REFERENCE_NO"]))
			$this->db2->where('m.INTERNAL_REFERENCE_NO',$withdrawalSearchData["INTERNAL_REFERENCE_NO"]);

		if(!empty($withdrawalSearchData["TRANSACTION_STATUS_ID"]))
			$this->db2->where('m.TRANSACTION_STATUS_ID',$withdrawalSearchData["TRANSACTION_STATUS_ID"]);

		if(!empty($withdrawalSearchData["TRANSACTION_SDATE"]))
			$this->db2->where("DATE_FORMAT(m.TRANSACTION_DATE,'%Y-%m-%d') >= ",date('Y-m-d',strtotime($withdrawalSearchData["TRANSACTION_SDATE"])));

		if(!empty($withdrawalSearchData["TRANSACTION_EDATE"]))
			$this->db2->where("DATE_FORMAT(m.TRANSACTION_DATE,'%Y-%m-%d') <= ",date('Y-m-d',strtotime($withdrawalSearchData["TRANSACTION_EDATE"])));

		$this->db2->where('m.TRANSACTION_TYPE_ID',10);
		//$this->db->where('m.TRANSACTION_STATUS_ID',109);
		$this->db2->order_by('m.MASTER_TRANSACTTION_ID','asc');
        $browseSQL = $this->db2->get();
//echo $this->db->last_query();
		return $browseSQL->num_rows();
	}

	public function getWithdrawRequests($config,$withdrawalSearchData) {
		$limit = $config["per_page"];
		$offset = $config["cur_page"];

		 $this->db2->select('m.MASTER_TRANSACTTION_ID,m.USER_ID,m.TRANSACTION_AMOUNT,m.INTERNAL_REFERENCE_NO,m.TRANSACTION_STATUS_ID,m.TRANSACTION_DATE,u.USERNAME,ts.TRANSACTION_STATUS_DESCRIPTION')->from('master_transaction_history m');
		$this->db2->join('user u', 'u.USER_ID = m.USER_ID', 'left');
		$this->db2->join('transaction_status ts', 'ts.TRANSACTION_STATUS_ID = m.TRANSACTION_STATUS_ID', 'left');
		if(!empty($withdrawalSearchData["USERNAME"]))
			$this->db2->where('u.USERNAME',$withdrawalSearchData["USERNAME"]);

		if(!empty($withdrawalSearchData["INTERNAL_REFERENCE_NO"]))
			$this->db2->where('m.INTERNAL_REFERENCE_NO',$withdrawalSearchData["INTERNAL_REFERENCE_NO"]);

		if(!empty($withdrawalSearchData["TRANSACTION_STATUS_ID"]))
			$this->db2->where('m.TRANSACTION_STATUS_ID',$withdrawalSearchData["TRANSACTION_STATUS_ID"]);

		if(!empty($withdrawalSearchData["TRANSACTION_SDATE"]))
			$this->db2->where("DATE_FORMAT(m.TRANSACTION_DATE,'%Y-%m-%d') >= ",date('Y-m-d',strtotime($withdrawalSearchData["TRANSACTION_SDATE"])));

		if(!empty($withdrawalSearchData["TRANSACTION_EDATE"]))
			$this->db2->where("DATE_FORMAT(m.TRANSACTION_DATE,'%Y-%m-%d') <= ",date('Y-m-d',strtotime($withdrawalSearchData["TRANSACTION_EDATE"])));

		$this->db2->where('m.TRANSACTION_TYPE_ID',10);
		//$this->db->where('m.TRANSACTION_STATUS_ID',109);
		//$this->db->or_where('m.TRANSACTION_STATUS_ID',208);
		//$this->db->or_where('m.TRANSACTION_STATUS_ID',111);
		$this->db2->order_by('m.MASTER_TRANSACTTION_ID','asc');
		$this->db2->limit($limit,$offset);
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function getWithdrawInfo($hand_id){

	   $this->db2->select('INTERNAL_REFERENCE_NO,WITHDRAW_BY,WITHDRAW_TYPE')->from('payment_transaction');
	   $this->db2->where('INTERNAL_REFERENCE_NO',$hand_id);
	   $browseSQL = $this->db2->get();
		   return $browseSQL->result();
	}

	public function getWithdrawalInfo($internalReferenceNo,$master_id) {
		 $this->db2->select('m.USER_ID,u.USERNAME,u.FIRSTNAME,u.LASTNAME,m.TRANSACTION_AMOUNT,m.INTERNAL_REFERENCE_NO,m.TRANSACTION_STATUS_ID,m.TRANSACTION_DATE,u.USERNAME,ts.TRANSACTION_STATUS_DESCRIPTION')->from('master_transaction_history m');
		$this->db2->join('user u', 'u.USER_ID = m.USER_ID', 'left');
		$this->db2->join('transaction_status ts', 'ts.TRANSACTION_STATUS_ID = m.TRANSACTION_STATUS_ID', 'left');
		$this->db2->where('m.INTERNAL_REFERENCE_NO',$internalReferenceNo);
		$this->db2->where('m.MASTER_TRANSACTTION_ID',$master_id);
        $browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function updateWMPaymentTransactionStatus($paymentTransactionID) {
		$umPaymentStatus["TRANSACTION_STATUS_ID"] = 208;
		$this->db->where('INTERNAL_REFERENCE_NO',$paymentTransactionID);
		$this->db->update('master_transaction_history', $umPaymentStatus);
	}

	public function updateWPPaymentTransactionStatus($paymentTransactionID) {
		$upPaymentStatus["PAYMENT_TRANSACTION_STATUS"] = 208;
		$this->db->where('INTERNAL_REFERENCE_NO',$paymentTransactionID);
		$this->db->update('payment_transaction', $upPaymentStatus);
	}

	public function getWithdrawalPaidInfo($internalRefNo,$pay_trans_id){
		$this->db2->select("*")->from("withdrawal_information");
		$this->db2->where('INTERNAL_REFERENCE_NO',$internalRefNo);
		$this->db2->where('PAYMENT_TRANSACTION_ID',$pay_trans_id);
		$ResSql = $this->db2->get();
		return $ResSql->result();
	}

	public function getUserAccountDetails($userId){
		$this->db2->select("*")->from("user_account_details");
		$this->db2->where('USER_ID',$userId);
		$ResSql = $this->db2->get();
		return $ResSql->result();
	}
}
