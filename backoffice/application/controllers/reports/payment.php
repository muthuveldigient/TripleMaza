<?php
//error_reporting(E_ALL);
/*
  Class Name	: Payment
  Package Name  : Report
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
	         $this->load->helper('url');
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');
			//player model
			
			$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			//$USR_STATUS = $_SESSION['partnerstatus'];
			$USR_STATUS = "2";
			$USR_PAR_ID = $this->session->userdata['partnerid'];
			$USR_GRP_ID = $this->session->userdata['groupid'];

			if($USR_STATUS!=1)
			{
					$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = $USR_PAR_ID;
			}
			else
			{
					$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = 1;
			}
			
			 $userdata['USR_ID']=$USR_ID;
			 $userdata['USR_GRP_ID']=$USR_GRP_ID;
			 $userdata['USR_STATUS']=$USR_STATUS;
			 $searchdata['rdoSearch']='';
				
			if($USR_ID == ''){
					redirect('login');
			 }
	
			$this->load->model('user/Account_model');                
			$this->load->model('common/common_model');
			$this->load->model('agent/Agent_model');
			$this->load->model('reports/report_model');
			$this->load->model('reports/payment_model');
			
			$partner_id=$this->session->userdata['partnerid'];
			$data = array("id" => $partner_id);
			$amount['amt']=$this->common_model->getBalance($data);  
					
			$this->load->view("common/header",$amount);
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
			
			//player model
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		
		//if needed
	}//EO: index function
	
	public function history($paymentDateRange,$dType){
	  
		//get all the static pages
		if($this->input->get('start',TRUE) == 1 || $_POST['reset'] == 'Clear'){
		   $this->session->unset_userdata('searchUserData');
		}	
		
		if(isset($paymentDateRange) && isset($dType)) {
			if($paymentDateRange=="cmonth") {
				$searchdata['START_DATE_TIME'] = date('Y-m-01')." 00:00:00";
				$searchdata['END_DATE_TIME']   = date('Y-m-d',strtotime("-1 days"))." 23:59:59";
			} else {
				$searchdata['START_DATE_TIME'] = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")))." 00:00:00";
				$searchdata['END_DATE_TIME']   = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")))." 23:59:59";				
			}			
			$this->session->set_userdata('searchUserData',$searchdata);				
		}		
			
		//general configuration
		$this->load->library('pagination');
		$config['base_url']  = base_url()."reports/payment/history/";
		$config['per_page']  = $this->config->item('limit');
		if(isset($paymentDateRange) && isset($dType))
			$start = $this->uri->segment(6,0);
		else
			$start = $this->uri->segment(4,0);
			
		$config['suffix']     = '?rid=18';
		
		//get all the partner ids
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata); 
               
		
		if($this->input->get_post('keyword',TRUE)=="Search" || $this->session->userdata('searchUserData') != ''){		
		
				$searchdata['username'] = $this->input->get_post('username',TRUE);
				if(isset($_REQUEST["sID"]))
					$searchdata['status_id'] = $_REQUEST["sID"];
				else	
	            	$searchdata['status_id'] = $this->input->get_post('status_id',TRUE);
					
				$searchdata['amount'] = $this->input->get_post('amount',TRUE);
				$searchdata['ref_no'] = $this->input->get_post('ref_no',TRUE);
				if($this->input->get_post('payment_mode') == 'select'){
				 $searchdata['payment_mode'] = '';
				}else{			
        	     $searchdata['payment_mode'] = $this->input->get_post('payment_mode',TRUE);
		   		}
				
				if(isset($paymentDateRange) && isset($dType)) {
					$searchdata['START_DATE_TIME'] = $searchdata['START_DATE_TIME'];
					$searchdata['END_DATE_TIME']   = $searchdata['END_DATE_TIME'];					
				} else {
					$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
					$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
				}				

				if($searchdata['username'] != ''){
					$user_id = $this->Account_model->getUserIdByName($searchdata['username']);
		        	if($user_id != ''){
				  		$searchdata['user_id'] = $user_id;
					}else{
                  		$searchdata['user_id'] = '00';
					}
				}else{
					$searchdata['user_id'] = '';
				}
				
				if($searchdata['status_id'] != ''){
				  $searchdata['status_id'] = $searchdata['status_id'];
				}else{
                  $searchdata['status_id'] = '';
				}
		
		        $this->session->set_userdata('searchUserData',$searchdata);
				$totCount = $this->report_model->getAllSearchPaymentCount($loggedInUsersPartnersId,$searchdata);
				$totAmount = $this->report_model->getAllSearchPaymentAmount($loggedInUsersPartnersId,$searchdata);
				//$successCount = $this->report_model->getCountSuccessPayments($loggedInUsersPartnersId,$searchdata);
				//$failedCount = $this->report_model->getCountFailedPayments($loggedInUsersPartnersId,$searchdata);
				//$pendingCount = $this->report_model->getPendingPayments($loggedInUsersPartnersId,$searchdata);

						
				$config['total_rows'] 	= $totCount;		
				$config['cur_page']     = $start;
				$this->pagination->initialize($config);	
				$data['username']  		= $this->input->get_post('username',TRUE);
				$data['email']      	= $this->input->get_post('email',TRUE);
				if(isset($_REQUEST["sID"]))
					$data['status_id'] = $_REQUEST["sID"];
				else
					$data['status_id'] = $this->input->get_post('status_id',TRUE);
				$data['countryv']		= $this->input->get_post('country',TRUE);
				if(isset($paymentDateRange) && isset($dType)) {
					$data['START_DATE_TIME'] = $searchdata['START_DATE_TIME'];
					$data['END_DATE_TIME']   = $searchdata['END_DATE_TIME'];					
				} else {
					$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
					$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
				}					
				$data['results']		= $this->report_model->getAllSearchPaymentInfo($loggedInUsersPartnersId,$searchdata,$config["per_page"],$start);
				//$data['success_payments'] = $successCount;
				//$data['failed_payments'] = $failedCount;
				//$data['pending_payments'] = $pendingCount;
				//$data['tot_users'] = $totCount;
				$data['tot_Amt'] 		= $totAmount;
				$data['pagination']   	= $this->pagination->create_links('view');
		}else{
				
		}
				$data['providers']=$this->payment_model->getAllPaymentProviders();
				$data['paymentstatus']=$this->payment_model->getAllPaymentStatus();
				$this->load->view('reports/paymenthistory',$data);   
		
		//$searchData['rdoSearch'] = "";
		//$this->load->view("user/search_users",$searchData);
	
	}
	
	
	public function approve($uid,$approve,$paymentTransId,$desc,$hid){
            $formdata['userid'] = $uid;
            $formdata['approve'] = $approve;
            $formdata['pay_trans_id'] = $paymentTransId;
			$formdata['desc_reason'] = $desc;


		if(is_array($formdata) && count($formdata)>0){
			$addUser = $this->report_model->PaymentAction($formdata);
                if($addUser){ 
				  if($approve == '2'){
						$returnString  = '<font color="Green">Approved</font>';				   
				  }elseif($approve == '0'){
						$returnString  = '<font color="red">Rejected</font>';
				  }
				}
		}else{
		   $returnString  = 'empty';
		}
		echo $returnString; die;
	  
	}	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */