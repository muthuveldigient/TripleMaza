<?php
//error_reporting(E_ALL);
/*
  Class Name	: Pay
  Package Name  : Cashier
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pay extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
	       
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

		
		$this->load->model('cms/cms_model');
		$this->load->model('common/common_model');
		$this->load->model('cashier/cashier_model');
		
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		
		$amount['amt']=$this->common_model->getBalance($data);  
		
		$this->load->view("common/header",$amount);
		/*$data['mainmenu']=$this->common_model->generate_menu($userdata);
		$data['param1']='';
		$data['param']='';
		$this->load->view('common/sidebar',$data);*/
		
		$this->load->library('commonfunction');
		$this->load->library('assignroles');
			
			
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		//if needed
	}//EO: index function
	
	public function ledger(){
		
		 $data = array();
		if($this->input->get_post('keyword',TRUE)=="Search"){	
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$data['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			$data['TRANSID'] = $this->input->get_post('TRANSID',TRUE);
			
			if($data['USERNAME'] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['USERNAME']);
				if($user_id != ''){
				  $data['USER_ID'] = $user_id;
				}else{
				  $data['USER_ID'] = '';
				}
			}else{
			    $data['USER_ID'] = '';
			}
			
			$data['results'] = $this->cashier_model->getAllLedgerSearchInfo($data);      
			
		
			              
		}
		$this->load->view('cashier/viewledger',$data);
	}  
	
	public function in_old(){
		//get all the static pages
		 $agentInfo = $this->Account_Model->getAllPartnerIds($this->session->userdata);
	
		
		$this->load->view('cashier/payin',$data);   
	}
	
	public function in(){
	
		$this->load->view('cashier/viewledgerinpointsdetails');
	
	}
	
	public function out(){
		
		$formdata=$this->input->post();
		if($this->input->post('Submit',TRUE)){
		//After submit
		 $addPage = $this->cms_model->insertPage($formdata);		
  		 $data['msg'] = $addPage;
		}
		
		$data['langs'] = $this->cms_model->getAllLanguages();
		$data['menus'] = $this->cms_model->getAllMenu();
		$this->load->view("cms/pages/create",$data);
	}
	
	public function file(){
		$pageId = $this->uri->segment(4, 0);
		$formdata=$this->input->post();
		if($this->input->post('Submit',TRUE)){
		//After submit
		 $updatePage = $this->cms_model->updatePage($formdata);		
  		 if($updatePage  == 1){
		 	$data['msg'] = "Page Sucessfully Updated";
		  }
		}
		
		$data['langs'] = $this->cms_model->getAllLanguages();
		$data['menus'] = $this->cms_model->getAllMenu();
		$data['page']  = $this->cms_model->getPageInfoById($pageId);
		
		$this->load->view("cms/pages/edit",$data);
		
	}
	
	public function delete(){
		$page_id = $this->uri->segment(4, 0);
		if($page_id != ''){
		   $this->cms_model->deletePage($page_id);
		   $data['msg'] = 'Page Successfully Deleted';
		}
		redirect("cms/pages/view", $data);	
	}//EO: delete function
	
}

/* End of file pages.php */
/* Location: ./application/controllers/cms/pages.php */