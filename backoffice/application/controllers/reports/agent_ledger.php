<?php
//error_reporting(E_ALL);
/*
  Class Name	: Payment
  Package Name  : Report
  Purpose       : Controller for point file
  Auther 	    : Sivakumar
  Date of create: July 02 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_ledger extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
	        $this->load->helper(array('url','form','functions'));	
			$this->load->library(array('form_validation','session','pagination','encrypt'));
			$this->load->database();
			$this->load->library('pagination');
			//player model
			
			$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			//$USR_STATUS = $_SESSION['partnerstatus'];
			$USR_STATUS = "2";
			$USR_PAR_ID = $this->session->userdata['partnerid'];
			//$USR_GRP_ID = $this->session->userdata['groupid'];

			if($USR_STATUS!=1)
			{
					//$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = $USR_PAR_ID;
			}
			else
			{
					//$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = 1;
			}
			
			 $userdata['USR_ID']=$USR_ID;
			// $userdata['USR_GRP_ID']=$USR_GRP_ID;
			 $userdata['USR_STATUS']=$USR_STATUS;
			 $searchdata['rdoSearch']='';
				
			if($USR_ID == ''){
					redirect('login');
			 }
	
			$this->load->model('common/common_model');
			$this->load->model('partners/partner_model');
			$this->load->model('reports/agentledger_model');
			
			$partner_id=$this->session->userdata['partnerid'];
			$data = array("id" => $partner_id);
			$amount['amt']=$this->common_model->getBalance($data);  
					
			$this->load->view("common/header",$amount);
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
			
			//player model
    }
	
	public function ledger() {
		$rid = $this->input->get('rid');
		$loggedInPartnersList = $this->partner_model->loggedinPartnerIDs($this->session->userdata); 
		if($this->input->get_post('keyword',TRUE)=="Search"){		
			$formdata=$this->input->post();
			$searchdata['username']  = $this->input->get_post('username',TRUE);
			$searchdata['agent_list']= $this->input->get_post('agent_list',TRUE);
			$searchdata['sdate'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$searchdata['edate'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$searchdata['processed_by'] = $this->input->get_post('processed_by',TRUE);

			$data['username']  = $this->input->get_post('username',TRUE);
			$data['agent_list']= $this->input->get_post('agent_list',TRUE);
			$data['sdate'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['edate'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$data['processed_by'] = $this->input->get_post('processed_by',TRUE);
						
			$sDate=date('d-m-Y',strtotime($searchdata['sdate']));
			$eDate=date('d-m-Y',strtotime($searchdata['edate']));
			if($sDate==$eDate) {
				$err=0;
			} else {
				if(!empty($searchdata['username']) || !empty($searchdata['agent_list']) || !empty($searchdata['processed_by'])) {
					$err=0;
				} else {
					$err=1;
					$data['errorMsg']="Enter value for Affiliate or User or Processed By field!!";
				}
			}	
			if($err==0) {
				$data['results']		= $this->agentledger_model->getLedgerInfo($loggedInPartnersList,$searchdata,1,1);
			}
		}
		
		if($loggedInPartnersList){
			if(is_array($loggedInPartnersList)){
				$totPartnersList = implode(",",$loggedInPartnersList);
			}else{
				$totPartnersList = explode(",",$loggedInPartnersList);
			}
			$totPartnersList=$loggedInPartnersList;
		}else{
			$totPartnersList ="-1";
		}		
		$data['agent_list'] = $this->input->get_post('agent_list',TRUE);		
		$partners_list=$this->agentledger_model->getPartnersNameList($totPartnersList);
		$data['rid'] = $rid;
		$data['loggedInPartnersList'] = $partners_list;	
		//echo '<pre>';print_r($data);exit;
		
		$this->load->view('reports/ledger',$data);
	}	
	
	public function ledgerhistory(){
	  
		//general configuration
		$this->load->library('pagination');
		$config['base_url']  = base_url()."reports/agent_ledger/ledgerhistory/";
		$config['per_page']  = $this->config->item('limit');
		if(isset($paymentDateRange) && isset($dType))
			$start = $this->uri->segment(6,0);
		else
			$start = $this->uri->segment(4,0);
		
		$rid = $this->input->get('rid');
			
		$config['suffix']     = '?rid='.$rid.'&username='.$this->input->get_post('username',TRUE).'&agent_list='.$this->input->get_post('agent_list',TRUE).'&START_DATE_TIME='.$this->input->get_post('START_DATE_TIME',TRUE).'&END_DATE_TIME='.$this->input->get_post('END_DATE_TIME',TRUE).'&processed_by='.$this->input->get_post('processed_by',TRUE).'&keyword='.$this->input->get_post('keyword',TRUE);
		
		$config['first_url'] = $config['base_url'].$config['suffix'];
		//get all the partner ids
		$loggedInPartnersList = $this->partner_model->loggedinPartnerIDs($this->session->userdata); 
		
		/*if($loggedInPartnersList)
		$nloggedInPartnersList=explode(",",$loggedInPartnersList);
		else
		$nloggedInPartnersList="-1";*/
		
       // $searchdata['agent_list'] = 19;
		//echo "Count".$totCount = $this->agentledger_model->getAllSearchLedgerCount($loggedInPartnersList,$searchdata);
		//$ledger=$this->agentledger_model->getAllSearchLedger($loggedInPartnersList,$searchdata,$config["per_page"],$start);		
		
		//print_r($ledger);
		//die();

		$name = $this->uri->segment(4, 0);
		if($name!= '0' || $name!=""){
			$searchdata['username'] = $name;
			$searchdata['sdate'] = date('d-m-Y 00:00:00');
			$searchdata['edate'] = date('d-m-Y 23:59:59');
							
			$data['username']  		= $name;
			$data['sdate'] 	 = date('d-m-Y 00:00:00');
			$data['edate']   = date('d-m-Y 23:59:59');		
			$data['results'] = $this->agentledger_model->getAllSearchLedger($loggedInPartnersList,$searchdata,$config["per_page"],$start);
		}
		
		if($this->input->get_post('keyword',TRUE)=="Search"){		
			
			$formdata=$this->input->post();

			$searchdata['username'] = $this->input->get_post('username',TRUE);
			$searchdata['agent_list'] = $this->input->get_post('agent_list',TRUE);
			
			if(isset($ledgerSearchdata)){
				$searchdata['sdate'] = $ledgerSearchdata['START_DATE_TIME'];
				$searchdata['edate']   = $ledgerSearchdata['END_DATE_TIME'];					
			}else{
				$searchdata['sdate'] = $this->input->get_post('START_DATE_TIME',TRUE);
				$searchdata['edate'] = $this->input->get_post('END_DATE_TIME',TRUE);
			}
							
			$searchdata['processed_by'] = $this->input->get_post('processed_by',TRUE);
			
			$totCount = $this->agentledger_model->getAllSearchLedgerCount($loggedInPartnersList,$searchdata);
					
			$config['total_rows'] 	= $totCount;		
			$config['cur_page']     = $start;
			
			$this->pagination->initialize($config);	
			
			$data['username']  		= $this->input->get_post('username',TRUE);
			$data['processed_by']	= $this->input->get_post('processed_by',TRUE);
			
			if(isset($ledgerSearchdata)) {
				$data['sdate'] = $searchdata['START_DATE_TIME'];
				$data['edate']   = $searchdata['END_DATE_TIME'];					
			}else{
				$data['sdate']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['edate']	= $this->input->get_post('END_DATE_TIME',TRUE);
			}
								
			$data['results']		= $this->agentledger_model->getAllSearchLedger($loggedInPartnersList,$searchdata,$config["per_page"],$start);
			//echo '<prE>';print_r($data['results']);exit;
			$data['pagination']   	= $this->pagination->create_links('view');
		}
				
		if($loggedInPartnersList){
			if(is_array($loggedInPartnersList)){
			$totPartnersList = implode(",",$loggedInPartnersList);
			}else{
			$totPartnersList = explode(",",$loggedInPartnersList);
			}
			$totPartnersList=$loggedInPartnersList;
		}else{
		$totPartnersList ="-1";
		}		
		$data['agent_list'] = $this->input->get_post('agent_list',TRUE);		
		$partners_list=$this->agentledger_model->getPartnersNameList($totPartnersList);
		$data['rid'] = $rid;
		$data['loggedInPartnersList'] = $partners_list;
		
		
		
		$this->load->view('reports/agent_ledger',$data);   
	
	}
	
	public function ledgerUserHistory(){
	  
		//general configuration
		$this->load->library('pagination');
		$config['base_url']  = base_url()."reports/agent_ledger/ledgerUserHistory/";
		$config['per_page']  = $this->config->item('limit');
		if(isset($paymentDateRange) && isset($dType))
			$start = $this->uri->segment(6,0);
		else
			$start = $this->uri->segment(4,0);
		
		$rid = $this->input->get('rid');
		
		//echo $this->input->get_post('userid',TRUE); 
	    //$dPagUserid = $this->encrypt->decode($this->input->get_post('userid',TRUE));
		$dPagUserid = base64_decode($this->input->get_post('userid',TRUE));
		
		$config['suffix']     = '?rid='.$rid.'&userid='.$dPagUserid.'&START_DATE_TIME='.$this->input->get_post('START_DATE_TIME',TRUE).'&END_DATE_TIME='.$this->input->get_post('END_DATE_TIME',TRUE).'&processed_by='.$this->input->get_post('processed_by',TRUE).'&keyword='.$this->input->get_post('keyword',TRUE);
		
		$config['first_url'] = $config['base_url'].$config['suffix'];
		//get all the partner ids
		$loggedInPartnersList = $this->partner_model->loggedinPartnerIDs($this->session->userdata); 
		
		/*if($loggedInPartnersList)
		$nloggedInPartnersList=explode(",",$loggedInPartnersList);
		else
		$nloggedInPartnersList="-1";*/
		
       // $searchdata['agent_list'] = 19;
		//echo "Count".$totCount = $this->agentledger_model->getAllSearchLedgerCount($loggedInPartnersList,$searchdata);
		//$ledger=$this->agentledger_model->getAllSearchLedger($loggedInPartnersList,$searchdata,$config["per_page"],$start);		
		
		//print_r($ledger);
		//die();
		
		if($this->input->get_post('keyword',TRUE)=="Search"){		
			if($this->input->get_post('userid',TRUE) != ''){
				//$decUserid = $this->encrypt->decode($this->input->get_post('userid',TRUE));
				$decUserid = base64_decode($this->input->get_post('userid',TRUE));
		    }else{
			   $decUserid = '';
			}	
			
			$formdata=$this->input->get_post();
									
			if(isset($ledgerSearchdata)){
				$searchdata['sdate']   = $ledgerSearchdata['START_DATE_TIME'];
				$searchdata['edate']   = $ledgerSearchdata['END_DATE_TIME'];					
			}else{
				$searchdata['sdate'] = $this->input->get_post('START_DATE_TIME',TRUE);
				$searchdata['edate'] = $this->input->get_post('END_DATE_TIME',TRUE);
			}
			$searchdata['userid'] = $decUserid ;				
			$searchdata['processed_by'] = $this->input->get_post('processed_by',TRUE);			
			
			$totCount = $this->agentledger_model->getAllUserSearchLedgerCount($loggedInPartnersList,$searchdata);
					
			$config['total_rows'] 	= $totCount;		
			$config['cur_page']     = $start;
			
			$this->pagination->initialize($config);	
						
			$data['processed_by']	= $this->input->get_post('processed_by',TRUE);
			
			if(isset($ledgerSearchdata)) {
				$data['sdate'] = $searchdata['START_DATE_TIME'];
				$data['edate']   = $searchdata['END_DATE_TIME'];					
			}else{
				$data['sdate']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['edate']	= $this->input->get_post('END_DATE_TIME',TRUE);
			}
			
		
								
			$data['results']		= $this->agentledger_model->getAllUserSearchLedger($loggedInPartnersList,$searchdata,$config["per_page"],$start);			
			
			$data['pagination']   	= $this->pagination->create_links('view');
		}
				
		if($loggedInPartnersList){
			if(is_array($loggedInPartnersList)){
			$totPartnersList = implode(",",$loggedInPartnersList);
			}else{
			$totPartnersList = explode(",",$loggedInPartnersList);
			}
		}else{
		$totPartnersList ="-1";
		}				
		$partners_list=$this->agentledger_model->getPartnersNameList($totPartnersList);
		$data['rid'] = $rid;
		$data['loggedInPartnersList'] = $partners_list;	
		
		$this->load->view('reports/agent_userledger',$data);   
	
	}
	
	
	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */