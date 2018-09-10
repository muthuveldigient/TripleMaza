<?php
//error_reporting(E_ALL);
/*
  Class Name	: NuBank
  Package Name  : Report
  Purpose       : Controller all search functionalities of Nubank
  Auther 	    : Arun
  Date of create: Dec 17 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nubank extends CI_Controller{
    
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
			$this->load->model('agent/Agent_model');
			$this->load->model('user/Account_model');
			$this->load->model('common/common_model');
			$this->load->model('reports/report_model');
			$this->load->model('games/casino/game_model');
			
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
        
        public function search(){
		//general configuration
		$this->load->library('pagination');
		$config['base_url']	 = base_url()."reports/nubank/search/";
		$config['per_page']  = $this->config->item('limit'); 
		$start = $this->uri->segment(4,0);
		
		
		//get all the partner ids
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata);  
               
		
		if($this->input->get_post('keyword',TRUE)=="Search"){		
		
				$searchdata['username'] = $this->input->get_post('username',TRUE);
            	$searchdata['email'] = $this->input->get_post('email',TRUE);
				if($this->input->get_post('country') == 'select'){
				 $searchdata['country'] = '';
				}else{			
        	     $searchdata['country'] = $this->input->get_post('country',TRUE);
		   		}
                $searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		        $searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
				$searchdata['partner'] = $this->input->get_post('partner',TRUE);
				$searchdata['online'] = $this->input->get_post('online',TRUE);
			
				$totCount = $this->Account_model->getAllSearchPlayesCount($loggedInUsersPartnersId,$searchdata);
				
				$activeCount = $this->Account_model->getCountActiveUsers($loggedInUsersPartnersId,$searchdata);
				$inactiveCount = $this->Account_model->getCountInActiveUsers($loggedInUsersPartnersId,$searchdata);
				
				$config['total_rows'] 	= $totCount;		
				$config['cur_page']     = $start;
				$this->pagination->initialize($config);	
				$data['username']  		= $this->input->get_post('username',TRUE);
				$data['email']      	= $this->input->get_post('email',TRUE);
				$data['countryv']		= $this->input->get_post('country',TRUE);
				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
				$data['partner']	= $this->input->get_post('partner',TRUE);
				$data['online']	= $this->input->get_post('online',TRUE);
				$data['results']	=	$this->Account_model->getAllSearchPlayersInfo($loggedInUsersPartnersId,$searchdata,$config["per_page"],$start);
				$data['active_users'] = $activeCount;
				$data['inactive_users'] = $inactiveCount;
				$data['tot_users'] = $totCount;
				
				
				$data['pagination']   = $this->pagination->create_links('view');
		}else{
				
		}
		
				$data['agents']=$this->commonfunction->get_distributer($this->session->userdata);
				$this->load->view('user/viewplayers',$data);              
        }
        
	
}