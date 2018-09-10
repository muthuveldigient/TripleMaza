<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->authendication();
		$this->load->helper(array('url','form'));			
		$this->load->library(array('form_validation','session','pagination'));
		$this->load->model('partner/admin_model');	
		$this->load->model('partner/partner_model');	
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		//$USR_STATUS = $_SESSION['partnerstatus'];
		$USR_STATUS = "2";
		$USR_PAR_ID = $this->session->userdata['partnerid'];
		$USR_GRP_ID = $this->session->userdata['groupid'];
		
		if($USR_STATUS!=1) {
			$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = $USR_PAR_ID;
		} else {
			$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = 1;
		}
		$this->load->model('user/Account_model');                
		$this->load->model('common/common_model');
		//$this->load->model('agent/Agent_model');
				
		$userdata['USR_ID']    =$USR_ID;
		$userdata['USR_GRP_ID']=$USR_GRP_ID;
		$userdata['USR_STATUS']=$USR_STATUS;
		$searchdata['rdoSearch']='';
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		$this->load->view("common/header",$amount);				
	}
	
	function authendication() {
		$userName = $this->session->userdata('adminusername');
		if($this->uri->uri_string() !== 'login' && !$userName) {
			$this->session->set_flashdata('message', 'Please login to access the page.');
        	redirect('login');
    	}		
	}	
	
	public function index() {
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('adminSearchData');
		}
                
		if($this->input->get('start',TRUE) == 1){
                        $this->session->unset_userdata('adminSearchData');
		}
                
		if($this->input->post('frmSearch')) {
			$data["FK_PARTNER_TYPE_ID"]  = $this->input->post('partnertype'); 
			$data["ACCOUNT_STATUS"]      = $this->input->post('account_status'); 
			$data["PARTNER_NAME"]        = $this->input->post('partnername'); 
			$data["USERNAME"]            = $this->input->post('username'); 
			$data["CREATED_ON"]          = $this->input->post('startdate'); 
			$data["CREATED_ON_END_DATE"] = $this->input->post('enddate'); 
			$this->session->set_userdata(array('adminSearchData'=>$data));
			$noOfRecords  = $this->admin_model->getUsersCount($data);			
		} else {
			$noOfRecords  = $this->admin_model->getUsersCount();			
		}

		/* Set the config parameters */
		$config['base_url']   = base_url()."partner/admin/index";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit'); 
		$config['cur_page']   = $this->uri->segment(4);
		$config['suffix'] = '?rid=23';

		if($this->uri->segment(4)) {
			$config['order_by']	  = $this->uri->segment(5);
			$config['sort_order'] = $this->uri->segment(6);
		} else {
			$config['order_by']	  = "ADMIN_USER_ID";
			$config['sort_order'] = "asc";			
		}		
		if($this->input->post('frmSearch')) {
			$data["getAdminInfo"] = $this->admin_model->getAdminInfo($config,$data);
			$data["searchResult"] = 1;				
		} else if($this->session->userdata('adminSearchData')) {
			$data["getAdminInfo"] = $this->admin_model->getAdminInfo($config,$data);
			$data["searchResult"] = 1;			
		} else {
			$data["getAdminInfo"] = $this->admin_model->getAdminInfo($config);
			$data["searchResult"] = "";				
		}
		$this->pagination->initialize($config);		
		$data['pagination']   = $this->pagination->create_links();
		$partnerTypeID = $this->session->userdata['partnertypeid'];
		$data["partnerTypes"]   = $this->admin_model->getPartnerTypes($partnerTypeID);	
		$data["getOwnPartners"] = $this->admin_model->getOwnPartners($this->session->userdata['partnerid']);		
		$this->load->view("partner/admin_index", $data);
	}
	
	public function addAdmin() {
		if($this->input->post('frmSubmit')) {
			$data["ACCOUNT_STATUS"] = 1;
			$data["FK_PARTNER_ID"]  = $this->session->userdata('partnerid');
			$data["USERNAME"]   = $this->input->post('username');	
			$data["PASSWORD"]	= md5($this->input->post('password'));	
			$data["FIRSTNAME"]  = $this->input->post('firstname');	
			$data["LASTNAME"]   = $this->input->post('lastname');
			$data["EMAIL"]  	= $this->input->post('email');
			$data["MOBILE"]  	= $this->input->post('mobile');
			$data["CITY"]  		= $this->input->post('city');
			$data["STATE"]  	= $this->input->post('state');
			$data["COUNTRY"]  	= $this->input->post('country');
			$data["PINCODE"]  	= $this->input->post('pincode');
			$data["REGISTRATION_TIMESTAMP"] = date('Y-m-d h:i:s');
			$data["TRANSACTION_PASSWORD"]  = md5($this->session->userdata('transactionpassword'));
			$addAdmin = $this->admin_model->addAdmin($data);
			
			$moduleIDs  = $this->config->item('moduleAccessForAdminUsers'); //modules which is not needed to the admin user
			$getRoleIDs = $this->partner_model->getRoleIDs($moduleIDs);	
			foreach($getRoleIDs as $roleID) {
				$role2AdminData["FK_ROLE_ID"]       = $roleID->ROLE_ID;
				$role2AdminData["FK_ADMIN_USER_ID"] = $addAdmin;
				$role2AdminData["CREATE_BY"]        = $this->session->userdata['partnerusername'];				
				$role2AdminData["CREATE_DATE"]      = date('Y-m-d h:i:s');
				$adRole2Admin = $this->admin_model->adRoles2Admin($role2AdminData);								
			}			
							
			if(!empty($addAdmin)) {
				$this->session->set_flashdata('message', 'Admin created successfully.');
				redirect("admin/addadmin?rid=22");							
			}			
		} else {
			$data["getCountries"]	 = $this->partner_model->getCountries();		
			$this->load->view("partner/addadmin", $data);	
		}
	}
	
	public function viewUser($userID) {
		$userData = $this->admin_model->viewUserData($userID);	
	    //bulild HTML string
	   	$userViewData .= "<table style='padding-left: 10px;'>";
		$userViewData .= "<tr><td colspan='2'><b><u>User Details</u></b></td></tr>";
		$userViewData .= "<tr><td><b>User Name</b> </td><td>: ".$userData[0]->USERNAME."</td></tr>";
		$userViewData .= "<tr><td><b>Email</b> </td><td>: ".$userData[0]->EMAIL."</td></tr>";
		$userViewData .= "<tr><td><b>City</b> </td><td>: ".$userData[0]->CITY."</td></tr>";
		$userViewData .= "<tr><td><b>State</b> </td><td>: ".$userData[0]->STATE."</td></tr>";
		$userViewData .= "<tr><td><b>Country</b> </td><td>: ".$userData[0]->CountryName."</td></tr>";
		$userViewData .= "<tr><td><b>Pincode</b> </td><td>: ".$userData[0]->PINCODE."</td></tr>";
		if($userData[0]->ACCOUNT_STATUS==1)
			$userViewData .= "<tr><td><b>Status</b> </td><td>: Active</td></tr><table>";		
		else
			$userViewData .= "<tr><td><b>Status</b> </td><td>: In Active</td></tr><table>";					
		echo $userViewData;die;		
	}
	
	public function changeActiveAdminStatus($curStatus, $adminID, $newStatus) {
		$adUserdata["ADMIN_USER_ID"]  = $adminID;
		$adUserdata["ACCOUNT_STATUS"] = $newStatus;		
		$changeAdminStatus = $this->admin_model->changeAdminStatus($adUserdata);

		if($newStatus==1) {
			$adminStatusValue = '<a href="#" onclick="javascript:activatedeaUser(1,'.$adminID.',0)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a>';
		} else {
			$adminStatusValue = '<a href="#" onclick="javascript:activatedeaUser(0,'.$adminID.',1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a>';	
		}
		$adminStatusValue = $adminStatusValue."_".$adminID;
		print_r($adminStatusValue);die;
	}
	
	public function editAdmin($adminID) {
		if($this->input->post('frmSubmit')) {
			$editAdata["ADMIN_USER_ID"] = $this->input->post('ADMIN_USER_ID');
			if($this->input->post('password')!="digient")
				$editAdata["PASSWORD"]	= md5($this->input->post('password'));
			$editAdata["FIRSTNAME"] = $this->input->post('firstname');	
			$editAdata["LASTNAME"]  = $this->input->post('lastname');
			$editAdata["EMAIL"]  	= $this->input->post('email');
			$editAdata["MOBILE"]  	= $this->input->post('mobile');
			$editAdata["CITY"]  	= $this->input->post('city');
			$editAdata["STATE"]  	= $this->input->post('state');
			$editAdata["COUNTRY"]  	= $this->input->post('country');
			$editAdata["PINCODE"]  	= $this->input->post('pincode');
			$editAdata["REGISTRATION_TIMESTAMP"] = date('Y-m-d h:i:s');			
			if($this->input->post('transactionpassword')!="digient")
				$editAdata["TRANSACTION_PASSWORD"]  = md5($this->session->userdata('transactionpassword'));
			$editAdmin = $this->admin_model->editAdmin($editAdata);	
			
			/* Below are the code to update the user roles and permissions */												
			if($this->input->post('userRoles')) {
				$updateARPData["adminUserID"]       = $this->input->post('ADMIN_USER_ID');
				$updateARPData["adminRaPermission"] = $this->input->post('userRoles');
				$updateAdminRaPermissions = $this->admin_model->updateAdminRolesAndPermissions($updateARPData);
			}
			/* Below are the code to update the user roles and permissions */
												
			if($editAdmin or $updateAdminRaPermissions) {
				$this->session->set_flashdata('message', 'Admin modified successfully.');
				redirect("admin/editAdmin/".$editAdata["ADMIN_USER_ID"]."?rid=23");							
			}			
		} else {
			$editData["getCountries"]	 = $this->partner_model->getCountries();
			$editData["adminData"]		 = $this->admin_model->getAdminData($adminID);			
			$this->load->view("partners/editadmin", $editData);	
		}			
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */