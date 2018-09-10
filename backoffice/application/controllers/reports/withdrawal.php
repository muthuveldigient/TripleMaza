<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdrawal extends CI_Controller {

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
		$this->authendication();
		$this->load->helper(array('url','form'));			
		$this->load->library(array('form_validation','session','pagination'));
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		
		//$USR_STATUS = $_SESSION['partnerstatus'];
		$USR_STATUS = "2";
		$USR_PAR_ID = $this->session->userdata['partnerid'];
		$USR_GRP_ID = $this->session->userdata['groupid'];
		
		if($USR_STATUS!=1) {
			$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = $USR_PAR_ID;
		} else {
			$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = 1;
		}
		$this->load->model('common/common_model');		
		$this->load->model('general/bonus_model');
		$this->load->model('reports/withdrawal_model');		
		$this->load->model('user/Account_model');    	
		$userdata['USR_ID']    =$USR_ID;
		$userdata['USR_GRP_ID']=$USR_GRP_ID;
		$userdata['USR_STATUS']=$USR_STATUS;
		$searchdata['rdoSearch']='';
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		$this->load->view("common/header",$amount);					
	}

	function authendication() {
		$userName = $this->session->userdata('adminusername');
		if($this->uri->uri_string() !== 'login' && !$userName) {
			$this->session->set_flashdata('message', 'Please login to access the page.');
        	redirect('login');
    	}		
	}	
	
	public function index($wDateRange,$wType) {
	//print_r($_POST);die;
		$data["page_title"]    = "List Withdrawal Requests";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('withdrawalSearchData');
		}
		if($this->input->get('start',TRUE) == 1){
		   $this->session->unset_userdata('withdrawalSearchData');
		}

		if(isset($wDateRange) && isset($wType)) {
			if($wDateRange=="cmonth") {
				$data['TRANSACTION_SDATE'] = date('Y-m-01')." 00:00:00";
				$data['TRANSACTION_EDATE'] = date('Y-m-d',strtotime("-1 days"))." 23:59:59";
				if($wType=="paidamt")
					$data["TRANSACTION_STATUS_ID"] = 111;	
				else if($wType=="pendingamt")
					$data["TRANSACTION_STATUS_ID"] = 109;
				else
					$data["TRANSACTION_STATUS_ID"] = "";				
			} else {
				$data['TRANSACTION_SDATE'] = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")))." 00:00:00";
				$data['TRANSACTION_EDATE'] = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")))." 23:59:59";
				if($wType=="paidamt")
					$data["TRANSACTION_STATUS_ID"] = 111;	
				else if($wType=="pendingamt")
					$data["TRANSACTION_STATUS_ID"] = 109;
				else
					$data["TRANSACTION_STATUS_ID"] = "";								
			}	
			$this->session->set_userdata(array('withdrawalSearchData'=>$data));			
		}
		
		if(isset($_REQUEST["userID"]) && $_REQUEST["userID"]!="")
			$userId = $_REQUEST["userID"];
			
		if(isset($_REQUEST["tSID"]) && $_REQUEST["tSID"]!="")
			$data["TRANSACTION_STATUS_ID"] = $_REQUEST["tSID"];	

		if($this->input->post('frmSearch')) {
			$data["USERNAME"] = $this->input->post('username'); 
			$data["INTERNAL_REFERENCE_NO"] = $this->input->post('withdrawid'); 
			$data["TRANSACTION_STATUS_ID"] = $this->input->post('withdrawStatus');			
			$data["TRANSACTION_SDATE"] = $this->input->post('START_DATE_TIME'); 
			$data["TRANSACTION_EDATE"] = $this->input->post('END_DATE_TIME');	
			if(isset($wDateRange) && isset($wType)) {
				$data['TRANSACTION_SDATE'] = $data['TRANSACTION_SDATE'];
				$data['TRANSACTION_EDATE'] = $data['TRANSACTION_EDATE'];	
				if($wType=="paidamt")
					$data["TRANSACTION_STATUS_ID"] = 111;	
				else if($wType=="paidamt")
					$data["TRANSACTION_STATUS_ID"] = 109;
				else
					$data["TRANSACTION_STATUS_ID"] = "";
			} else {
				$data["TRANSACTION_SDATE"] = $this->input->post('START_DATE_TIME'); 
				$data["TRANSACTION_EDATE"] = $this->input->post('END_DATE_TIME');					
			}
			$this->session->set_userdata(array('withdrawalSearchData'=>$data));
			$noOfRecords  = $this->withdrawal_model->getWithdrawRequestsCount($data);	
		}  else if($this->session->userdata('withdrawalSearchData')) {
			$noOfRecords  = $this->withdrawal_model->getWithdrawRequestsCount($this->session->userdata('withdrawalSearchData'));
		} else {
			$noOfRecords  = $this->withdrawal_model->getWithdrawRequestsCount();	
		}

		/* Set the config parameters */
		$config['base_url']   = base_url()."reports/withdrawal/index";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit');
		$config['cur_page']   = $this->uri->segment(4);		
		$config['suffix']     = '?rid=53';

		if($this->uri->segment(4)) {
			$config['order_by']	  = $this->uri->segment(5);
			$config['sort_order'] = $this->uri->segment(6);
		} else {
			$config['order_by']	  = "PAYMENT_TRANSACTION_ID";
			$config['sort_order'] = "asc";			
		}		
				
		/* Set the config parameters */		
		if($this->input->post('frmSearch')) {
			$data["withdrawRequests"] = $this->withdrawal_model->getWithdrawRequests($config,$data);
			$data["searchResult"] = 1;		
		} else if($this->session->userdata('withdrawalSearchData')) {
			$data["withdrawRequests"] = $this->withdrawal_model->getWithdrawRequests($config,$this->session->userdata('withdrawalSearchData'));
			$data["searchResult"] = 1;			
		} else {
			$data["withdrawRequests"] = $this->withdrawal_model->getWithdrawRequests($data);
			$data["searchResult"] = "";			
		}	
		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();			
		$this->load->view('reports/withdrawals',$data);		
	}

	public function withdrawFunctions() {
		if($this->input->post('Approve')) {
			if($this->input->post('wBatch')) {
				foreach($this->input->post('wBatch') as $pIndex=>$paymentTIDs) {
					$this->withdrawal_model->updateWMPaymentTransactionStatus($paymentTIDs); //update requested withdrawal, in master transaction status	
					$this->withdrawal_model->updateWPPaymentTransactionStatus($paymentTIDs); //update requested withdrawal, in master transaction status						
				}
			}
			redirect('reports/withdrawal/index?rid=53');
		}
		if($this->input->post('ApprvoeAndCreateBathch')) {
			echo "bb";die;			
		}
		if($this->input->post('CreateBathch')) {
			echo "ccc";die;			
		}			
			echo "d";die;			
	}
	
}