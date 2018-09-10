<?php
/*
  Class Name	: Banner
  Package Name  : CMS
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner extends CI_Controller{
    
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

		$this->load->model('cms/cms_model');
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
		
		//get all the static pages
		$data['results'] = $this->cms_model->getAllBanners();
		$this->load->view('cms/banner/view',$data);   
	
		//if needed
	}//EO: index function
	
	
	public function add(){
		
			$formdata=$this->input->post();
			
			//load validation libraray
			$this->load->library('form_validation');
			
			//Load Form Helper
			$this->load->helper('form');
			$this->form_validation->set_rules('attachment','lang:attachment_validation','callback_attachment_check');
			
			if($this->form_validation->run())
			{
				$formData['BANNER_POSITION']         = $formdata['BANNER_POSITION'];
				$formData['BANNER_LANGUAGE']         = $formdata['BANNER_LANGUAGE'];
				$formData['bannerImage']  	 		 = $this->data['file']['file_name'];
				$formData['BANNER_LINK']        	 = $formdata['BANNER_LINK'];
				//After submit
				$addbanner = $this->cms_model->insertBanner($formData);		
				$data['msg'] = $addbanner;
			
		   }
		$data['bannerPositions']  = $this->cms_model->getAllBannerPositions();
		
		$data['languages']  	  = $this->cms_model->getAllLanguages();
		

		$this->load->view("cms/banner/add",$data);
	}
	
	public function edit(){
		$bannerId = $this->uri->segment(4, 0);
		$formdata=$this->input->post();
		//load validation libraray
		$this->load->library('form_validation');
		//Load Form Helper
		$this->load->helper('form');
		$this->form_validation->set_rules('attachment','lang:attachment_validation','callback_attachment_check');
		if($this->form_validation->run())
		{
		
				$formData['BANNER_POSITION']         = $formdata['BANNER_POSITION'];
				$formData['BANNER_LANGUAGE']         = $formdata['BANNER_LANGUAGE'];
				$formData['bannerImage']  	 		 = $this->data['file']['file_name'];
				$formData['BANNER_LINK']        	 = $formdata['BANNER_LINK'];
				$formData['banner_id']        	 	 = $formdata['banner_id'];

				
				//After submit
				$addbanner = $this->cms_model->updateBanner($formData);		
				 if($addbanner  == 1){
		 			$data['msg'] = "Sucessfully Updated";
		 		 }
			
		 }

		$data['bannerPositions']  = $this->cms_model->getAllBannerPositions();
		$data['languages']  	  = $this->cms_model->getAllLanguages();
		$data['banner']  = $this->cms_model->getBannerInfoById($bannerId);
		
		$this->load->view("cms/banner/edit",$data);
		
	}
	
	public function active(){
		$ban_id = $this->uri->segment(4, 0);
		if($ban_id != ''){
		   $this->cms_model->activeBanner($ban_id,'Active');
		   $data['msg'] = 'Successfully Deleted';
		}
		redirect("cms/banner", $data);	
	}
	
	public function deactive(){
	  
	 	$ban_id = $this->uri->segment(4, 0);
	 
		if($ban_id != ''){
		   $this->cms_model->activeBanner($ban_id,'Deactive');
		   $data['msg'] = 'Successfully Deleted';
		}
		redirect("cms/banner", $data);	
	
	}
	
	public function delete(){
		$banner_id = $this->uri->segment(4, 0);
		if($banner_id != ''){
		   $this->cms_model->deleteBanner($banner_id);
		   $data['msg'] = 'Successfully Deleted';
		}
		redirect("cms/banner", $data);	
	}//EO: delete function
	
	
	function attachment_check()
	{
		
		if(isset($_FILES) and $_FILES['attachment']['name']=='')				
		return true;
	
		$config['upload_path'] 		='static/uploads/banners/';
		$config['allowed_types'] 	='jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF|zip|ZIP|RAR|rar|doc|DOC|txt|TXT|xls|XLS|ppt|PPT|pdf|PDF|docx|xlsx|pptx';
		$config['max_size'] 		= $this->config->item('max_upload_size');
		$config['encrypt_name'] 	= TRUE;
		$config['remove_spaces'] 	= TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('attachment'))
		{
			$this->data['file'] = $this->upload->data();			
			return true;			
		}else {
	
			$this->form_validation->set_message('attachment_check', $this->upload->display_errors($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag')));
			return false;
		}//If end 
	}//Function attachment_check End
	
	
}

/* End of file pages.php */
/* Location: ./application/controllers/cms/pages.php */