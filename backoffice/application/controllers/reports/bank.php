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
class Bank extends CI_Controller{
    
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
		if($this->input->get_post('keyword',TRUE)=="Search"){
                        $searchdata['id'] = $this->Agent_model->getAllChildIds($this->session->userdata[partnerid]);

                        $searchdata['START_DATE_TIME']       =  $this->input->get_post('START_DATE_TIME',TRUE);
                        $searchdata['END_DATE_TIME'] 	     =  $this->input->get_post('END_DATE_TIME',TRUE);
                        $data["bank"]["regpoints"]           =  $this->report_model->getRegPoints($searchdata);
			$data["bank"]["loginpoints"]         =  $this->report_model->getLoginPoints($searchdata);	
			$data["bank"]["vippoints"]           =  $this->report_model->getVipPoints($searchdata);
                        $data["bank"]["oddnevenpoints"]      =  $this->report_model->getOddnEvenPoints($searchdata);
                        $data["bank"]["luckynumberpoints"]   =  $this->report_model->getLuckyNumberPoints($searchdata);
                        $data["bank"]["luckpoints"]          =  $this->report_model->getLuckPoints($searchdata);
                        //echo "<pre>";print_r($data);die;
                         //echo "<pre>";print_r($data[regpoints][0]->tot);die;                        
                        $data["bank"]["regchips"]            =  $this->report_model->getRegChips($searchdata);
			$data["bank"]["loginchips"]          =  $this->report_model->getLoginChips($searchdata);	
			$data["bank"]["vipchips"]            =  $this->report_model->getVipChips($searchdata);                        
                        $data["bank"]["oddnevenchips"]       =  $this->report_model->getOddnEvenChips($searchdata);
                        $data["bank"]["luckynumberchips"]    =  $this->report_model->getLuckyNumberChips($searchdata);
                        $data["bank"]["luckchips"]           =  $this->report_model->getLuckChips($searchdata);
                        //echo "<pre>";print_r($data);die;
                        $this->load->view('reports/bankreports',$data); 
		}else{ 
                	//echo "<pre>";print_r($data);die;
                        $data["bank"]="";
        		$this->load->view('reports/bankreports',$data);   		
                }
		//if needed
	}//EO: index function

        
	
}