<?php
/*
  Class Name	: Dashboard
  Package Name  : General
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller{
    
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

		$this->load->model('general/general_model');
		$this->load->model('common/common_model');        
        $this->load->model('user/account_model');		
                
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);		
		$amount['amt']=$this->common_model->getBalance($data);  		
		$this->load->view("common/header",$amount);		
		$this->load->library('commonfunction');
		$this->load->library('assignroles');
			
			
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index() {		
						
		$this->load->view("general/dashboard/index",$data);
	}//EO: index function
	
	public function cms(){
		$this->load->view("general/dashboard/cms");
	}

	
}

/* End of file pages.php */
/* Location: ./application/controllers/cms/pages.php */