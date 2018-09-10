<?php
/*
  Class Name	: Language
  Package Name  : CMS
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Language extends CI_Controller{
    
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

		
		$this->load->model('cms/cms_model');
		$this->load->model('common/common_model');
		
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
		
		//get all the static pages
		$data['results'] = $this->cms_model->getAllLanguages();
		$this->load->view('cms/language/view',$data);   
	
		//if needed
	}//EO: index function
	
	
	public function add(){
		
		$formdata=$this->input->post();
		if($this->input->post('Submit',TRUE)){
		//After submit
		 $addPage = $this->cms_model->insertLanguage($formdata);		
  		 $data['msg'] = $addPage;
		}

		$this->load->view("cms/language/add",$data);
	}
	
	public function edit(){
		$langId = $this->uri->segment(4, 0);
		$formdata=$this->input->post();
		if($this->input->post('Submit',TRUE)){
		//After submit
		 $updatePage = $this->cms_model->updateLanguage($formdata);		
  		 if($updatePage  == 1){
		 	$data['msg'] = "Sucessfully Updated";
		  }
		}

		$data['lang']  = $this->cms_model->getLangInfoById($langId);
		
		
		$this->load->view("cms/language/edit",$data);
		
	}
	
	public function delete(){
		$lang_id = $this->uri->segment(4, 0);
		if($lang_id != ''){
		   $this->cms_model->deleteLanguage($lang_id);
		   $data['msg'] = 'Successfully Deleted';
		}
		redirect("cms/language", $data);	
	}//EO: delete function
	
}

/* End of file pages.php */
/* Location: ./application/controllers/cms/pages.php */