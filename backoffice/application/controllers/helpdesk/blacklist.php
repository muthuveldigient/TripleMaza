<?php
//error_reporting(E_ALL);

/*
  Class Name	: Blacklist
  Package Name  : Helpdesk
  Purpose       : Controll all the Help related functionalities
  Auther 	: Arun
  Date of create: Sep 24 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blacklist extends CI_Controller{
    
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
                 $this->load->model('agent/Agent_model'); 
                 $this->load->model('common/common_model');
                 $this->load->model('marketing/campaign_model');
                 
                $partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
				
		$this->load->view("common/header",$amount);
                
       		$this->load->library('commonfunction');
		$this->load->library('assignroles');
                 
    }
    
    	public function index()
	{
		//if needed
	}
        
        
	public function searchip() {
		if($this->input->get('start',TRUE) == 1){
		   $this->session->unset_userdata('blacklistsData');
		}
		$config['base_url'] = base_url()."helpdesk/blacklist/searchip/";
		$config['per_page'] = $this->config->item('limit'); 
		$config['suffix']   = '?rid=35';
		$start = $this->uri->segment(4,0);
                
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata);
		$loggedInPartnersUsername = $this->Account_model->getAllSearchUserinfo();
		if($this->input->get_post('keyword',TRUE)=="Search") {		
			$searchdata['IPADDRESS']       = trim($this->input->get_post('IPADDRESS',TRUE));
			$searchdata['USERNAME']        = trim($this->input->get_post('USERNAME',TRUE));
			$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$searchdata['END_DATE_TIME']   = $this->input->get_post('END_DATE_TIME',TRUE);
			$searchdata['select2']         = $this->input->get_post('select2',TRUE);	
			$searchdata['SEARCH_LIMIT']    = $this->input->get_post('SEARCH_LIMIT',TRUE);
			$this->session->set_userdata('blacklistsData',$searchdata);				
			$blacklistsData = $this->session->userdata('blacklistsData');
			$totCount = $this->Account_model->getAllSearchIpCount($loggedInPartnersUsername,$blacklistsData);
			
			$config['total_rows'] = $totCount;		
			$config['cur_page']   = $start;
			$this->pagination->initialize($config);	
						
			$data['results']	= $this->Account_model->getAllSearchIpInfo($loggedInPartnersUsername,$blacklistsData,$config["per_page"],$start);
			$data['pagination'] = $this->pagination->create_links('view');
		} else if($this->session->userdata('blacklistsData')) {
			$blacklistsData = $this->session->userdata('blacklistsData');
			$totCount = $this->Account_model->getAllSearchIpCount($loggedInPartnersUsername,$blacklistsData);
			
			$config['total_rows'] = $totCount;		
			$config['cur_page']   = $start;
			$this->pagination->initialize($config);	
						
			$data['results']	= $this->Account_model->getAllSearchIpInfo($loggedInPartnersUsername,$blacklistsData,$config["per_page"],$start);
			$data['pagination'] = $this->pagination->create_links('view');			
		} else {
			/*$totCount = $this->Account_model->getAllIpCount($loggedInPartnersUsername);
			$config['total_rows'] = $totCount;		
			$config['cur_page']   = $start;
			$this->pagination->initialize($config);	
			$data['results']	= $this->Account_model->getAllIpInfo($loggedInPartnersUsername,$config["per_page"],$start);
			$data['pagination'] = $this->pagination->create_links('view');*/
		}	
        $this->load->view("helpdesk/searchip",$data);
   }
        
        
        
        
}?>
    