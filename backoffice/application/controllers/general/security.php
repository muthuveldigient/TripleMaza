<?php
/*
  Class Name	: Security
  Package Name  : General
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Security extends CI_Controller{
    
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
        
	public function index()
	{
		
		//if needed
	}//EO: index function
	
	
	public function view(){
	  	//get all the static pages
		$totCount = $this->general_model->getTotSecurityItemsCount();
		$start = $this->uri->segment(4,0);
		$this->load->library('pagination');
		$config['base_url'] 	= base_url()."general/security/view";
		$config['total_rows'] 	= $totCount;		
		$config['per_page']     = $this->config->item('limit'); 
		$config['cur_page']     = $start;
		$this->pagination->initialize($config);	
		$data['results']	    = $this->general_model->getAllSecurityItems($config["per_page"],$start);
		$data['pagination']     = $this->pagination->create_links('view');
		$this->load->view('general/security/view',$data);   
		
	
	}
	
	public function create(){
		
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
	
	public function edit(){
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