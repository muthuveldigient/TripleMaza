<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends CI_Controller {

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
		$this->load->model('agent/Agent_model');
				
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
		$data["page_title"]    = "List Partners";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('partnerSearchData');
		}
                
		if($this->input->get('start',TRUE) == 1){
                        $this->session->unset_userdata('partnerSearchData');
		}
		
		
                
		if($this->input->post('frmSearch')) {
			$data["FK_PARTNER_TYPE_ID"]  = $this->input->post('partnertype'); 
			$data["PARTNER_STATUS"]      = $this->input->post('partnerstatus'); 
			$data["PARTNER_NAME"]        = $this->input->post('partnername'); 
			$data["PARTNER_EMAIL"]       = $this->input->post('partneremail'); 
			$data["CREATED_ON"]          = $this->input->post('startdate'); 
			$data["CREATED_ON_END_DATE"] = $this->input->post('enddate'); 
			$this->session->set_userdata(array('partnerSearchData'=>$data));
			$noOfRecords  = $this->partner_model->getPartnerDataCount($data);			
		} else {
			$noOfRecords  = $this->partner_model->getPartnerDataCount();			
		}

		/* Set the config parameters */
		$config['base_url']   = base_url()."partner/index";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit'); 
		$config['cur_page']   = $this->uri->segment(3);
		$config['suffix']     = '?rid=23';		
		
		if($this->uri->segment(3)) {
			$config['order_by']	  = $this->uri->segment(4);
			$config['sort_order'] = $this->uri->segment(5);
		} else {
			$config['order_by']	  = "PARTNER_ID";
			$config['sort_order'] = "asc";			
		}		
		if($this->input->post('frmSearch')) {
			$data["partner_info"] = $this->partner_model->getPartnerInfo($config,$data);
			$data["searchResult"] = 1;		
		} else if($this->session->userdata('partnerSearchData')) {
			$data["partner_info"] = $this->partner_model->getPartnerInfo($config,$data);
			$data["searchResult"] = 1;			
		} else {
			$data["partner_info"] = $this->partner_model->getPartnerInfo($config);
			$data["searchResult"] = "";			
		}		
		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();
				
		$partnerTypeID = $this->session->userdata['partnertypeid'];
		$data["partnerTypes"]   = $this->partner_model->getPartnerTypes($partnerTypeID);	
		$data["getOwnPartners"] = $this->partner_model->getOwnPartners($this->session->userdata['partnerid']);
                //echo "<pre>";print_r($data);die;
		$this->load->view('partner/index',$data);
	}
	
	public function addPartner() {
		if($this->input->post('frmSubmit')) {
			$data["PARTNER_NAME"]      = $this->input->post('partnername');	
			$data["FK_PARTNER_TYPE_ID"]= $this->input->post('partnertype');	 //Type of partner(agent,distributor or sub agent)
			$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid'); //Parent ID				
			$data["PARTNER_USERNAME"]  = $this->input->post('username');	
			$data["PARTNER_PASSWORD"]  = md5($this->input->post('password'));
				if($this->input->post('transactionpassword') != ""){
					$data["PARTNER_TRANSACTION_PASSWORD"] = md5($this->input->post('transactionpassword'));		
				}else{
					$data["PARTNER_TRANSACTION_PASSWORD"] = "";    
				}
			$data["PARTNER_COMMISSION_TYPE"] 	  = $this->input->post('commissiontype');
			$data["PARTNER_REVENUE_SHARE"] 		  = $this->input->post('percentage');
			$data["PARTNER_ADDRESS1"]    = $this->input->post('adderss');
			$data["PARTNER_PHONE"]       = $this->input->post('phone');
			$data["PARTNER_CITY"]        = $this->input->post('city');
			$data["PARTNER_STATE"]       = $this->input->post('state');
			$data["PARTNER_COUNTRY"]     = $this->input->post('country');
			$data["PARTNER_MOBILE"]      = $this->input->post('mobile');			
			$data["PARTNER_EMAIL"]       = $this->input->post('email');
			$data["PARTNER_DESIGNATION"] = $this->input->post('designation');
			$data["PARTNER_CONTACT_PERSON"] = $this->input->post('contactperson');
			$data["PARTNER_ZIP"] 	     = $this->input->post('pincode');
			$data["IS_OWN_PARTNER"] 	 = 0;
			$data["PARTNER_STATUS"] 	 = 1;								
			$data["PARTNER_CREATED_ON"]  = date('Y-m-d h:i:s');
			$data["STATUS"]  			 = 1;			
			$data["MPARTNER_ID"]  		 = $this->session->userdata('partnerid');															
			$data["CREATED_ON"]          = date('Y-m-d h:i:s');			
			
			$addPartnerID = $this->partner_model->addPartner($data);

			/* Add partner login details in the admin_user table*/
			$pLoginInfo["USERNAME"]               = $this->input->post('username');
			$pLoginInfo["PASSWORD"]               = md5($this->input->post('password'));
				if($this->input->post('transactionpassword') != ""){
					$pLoginInfo["TRANSACTION_PASSWORD"]   = md5($this->input->post('transactionpassword'));
				}else{
					$pLoginInfo["TRANSACTION_PASSWORD"]   = "";
				}
			$pLoginInfo["FK_PARTNER_ID"]          = $addPartnerID;
			$pLoginInfo["ACCOUNT_STATUS"]         = 1;
			$pLoginInfo["EMAIL"]                  = $this->input->post('email');
			$pLoginInfo["STATE"]                  = $this->input->post('state');
			$pLoginInfo["COUNTRY"]                = $this->input->post('country');
			$pLoginInfo["PINCODE"] 				  = $this->input->post('pincode');
			$pLoginInfo["REGISTRATION_TIMESTAMP"] = date('Y-m-d h:i:s');
			$addPLoginInfo = $this->partner_model->addPLoginInfo($pLoginInfo);
			
			/* This is to add the roles and the permissions to the created user */
			if($data["FK_PARTNER_TYPE_ID"]==3) { //white label partner, so provide all the access
				$getRoleIDs = $this->partner_model->getRoleIDs();
			} else { //affiliate or marketing partner, so can not create partner
				$moduleIDs  = $this->config->item('moduleAccess'); //modules which is not needed to the user
				$getRoleIDs = $this->partner_model->getRoleIDs($moduleIDs);				
			}
			foreach($getRoleIDs as $roleID) {
				$role2AdminData["FK_ROLE_ID"]       = $roleID->ROLE_ID;
				$role2AdminData["FK_ADMIN_USER_ID"] = $addPLoginInfo;
				$role2AdminData["CREATE_BY"]        = $this->session->userdata['partnerusername'];				
				$role2AdminData["CREATE_DATE"]      = date('Y-m-d h:i:s');
				$adRole2Admin = $this->partner_model->adRoles2Admin($role2AdminData);								
			}
			
			if(!empty($addPLoginInfo)) {
				$this->session->set_flashdata('message', 'Partner created successfully.');
				redirect("partner/addpartner?rid=22");							
			}																										
		} else {
			$partnerTypeID = $this->session->userdata['partnertypeid'];
			$data["partnerTypes"]    = $this->partner_model->getPartnerTypes($partnerTypeID);
			$data["commissionTypes"] = $this->partner_model->getCommissionTypes();	
			//$data["getStates"]		 = $this->partner_model->getStates();
			$data["getCountries"]	 = $this->partner_model->getCountries();
			$this->load->view('partner/addpartner',$data);	
		}
	}
	
	public function viewPartner($partnerID) {
		$getPartnerDetails = $this->partner_model->viewPartnerInfo($partnerID);	
	    //bulild HTML string
	   	$partnerViewData .= "<table style='padding-left: 10px;'>";
		$partnerViewData .= "<tr><td colspan='2'><b><u>Partner Details</u></b></td></tr>";
		$partnerViewData .= "<tr><td><b>Partner Name:</b> </td><td>".$getPartnerDetails[0]->PARTNER_NAME."</td></tr>";
		$partnerViewData .= "<tr><td><b>Partner Type:</b> </td><td>".$getPartnerDetails[0]->PARTNER_TYPE."</td></tr>";
		$partnerViewData .= "<tr><td><b>Commisson Type:</b> </td><td>".$getPartnerDetails[0]->AGENT_COMMISSION_TYPE."</td></tr>";
		$partnerViewData .= "<tr><td><b>Commission (%):</b> </td><td>".$getPartnerDetails[0]->PARTNER_REVENUE_SHARE."</td></tr>";
		$partnerViewData .= "<tr><td><b>Email:</b> </td><td>".$getPartnerDetails[0]->PARTNER_EMAIL."</td></tr>";
		$partnerViewData .= "<tr><td><b>Address:</b> </td><td>".$getPartnerDetails[0]->PARTNER_ADDRESS1."</td></tr>";
		$partnerViewData .= "<tr><td><b>City:</b> </td><td>".$getPartnerDetails[0]->PARTNER_CITY."</td></tr>";
		$partnerViewData .= "<tr><td><b>State:</b> </td><td>".$getPartnerDetails[0]->PARTNER_STATE."</td></tr>";
		$partnerViewData .= "<tr><td><b>Country:</b> </td><td>India</td></tr>";																					
		$partnerViewData .= "<tr><td><b>Phone:</b> </td><td>".$getPartnerDetails[0]->PARTNER_PHONE."</td></tr><table>";		
		echo $partnerViewData;die;
	}
	
	public function chkUserExistence($userName) {
		$getUserExistence = $this->partner_model->chkUserExistence($userName);
		if($getUserExistence==1)
			echo "Username is not available";
		else
			echo "Username is available";
		die;
	}
	
	public function deletePartner($partnerID) {
		redirect('partner/index?rid=23');
	}	
	
	public function getPartnerIDs($partnerTypeID) {
		if($partnerTypeID=="") {
			$partnerIDValues ='<select name="parentpartner" id="parentpartner" class="cmbTextField">';
			$partnerIDValues .='<option value="">-- Select --</option>';												
			$partnerIDValues .='</select>';
			print_r($partnerIDValues);die;						
		}
		
		$partnerIDs = $this->partner_model->getPartnerIDs($partnerTypeID);	
		if(!empty($partnerIDs) && $partnerTypeID!=1) {
			$partnerIDValues ='<select name="parentpartner" id="parentpartner" class="cmbTextField">';
			foreach($partnerIDs as $partnerID) {
				$partnerIDValues .='<option value="'.$partnerID->PARTNER_ID.'">'.$partnerID->PARTNER_USERNAME.'</option>';		
			}
			$partnerIDValues .='</select>';
		} else {
			$partnerIDValues ='<select name="parentpartner" id="parentpartner" class="cmbTextField">';
			$partnerIDValues .='<option value="">-- Select --</option>';												
			$partnerIDValues .='</select>';			
		}
		print_r($partnerIDValues);die;
	}
		
	public function changeActivePartnerStatus($curStatus, $partnerID, $newStatus) {
		$adUserdata["PARTNER_ID"]     = $partnerID;
		$adUserdata["PARTNER_STATUS"] = $newStatus;		
		$changePartnerStatus = 	$this->partner_model->changePartnerStatus($adUserdata);

		if($newStatus==1) {
			$partnerStatusValue = '<a href="#" onclick="javascript:activatedeaUser(1,'.$partnerID.',0)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a>';
		} else {
			$partnerStatusValue = '<a href="#" onclick="javascript:activatedeaUser(0,'.$partnerID.',1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a>';	
		}
		$partnerStatusValue = $partnerStatusValue."_".$partnerID;
		print_r($partnerStatusValue);die;
	}
	
	public function editPartner($partnerID) {
		if($this->input->post('frmSubmit')) {	
			$partnerTable["PARTNER_ID"]          = $this->input->post('PARTNER_ID');
			$partnerTable["PARTNER_NAME"]        = $this->input->post('partnername');	
			$partnerTable["PARTNER_ADDRESS1"]    = $this->input->post('adderss');
			$partnerTable["PARTNER_PHONE"]       = $this->input->post('phone');
			$partnerTable["PARTNER_CITY"]        = $this->input->post('city');
			$partnerTable["PARTNER_STATE"]       = $this->input->post('state');
			$partnerTable["PARTNER_COUNTRY"]     = $this->input->post('country');
			$partnerTable["PARTNER_MOBILE"]      = $this->input->post('mobile');						
			$partnerTable["PARTNER_EMAIL"]       = $this->input->post('email');
			$partnerTable["PARTNER_DESIGNATION"] = $this->input->post('designation');
			$partnerTable["PARTNER_CONTACT_PERSON"] = $this->input->post('contactperson');	
			if($this->input->post('password')!="digient")
				$partnerTable["PARTNER_PASSWORD"]  = md5($this->input->post('password'));				
			if($this->input->post('transactionpassword')!="digient")	
				$partnerTable["PARTNER_TRANSACTION_PASSWORD"] = md5($this->input->post('transactionpassword'));						
			$updatePartnerInfo = $this->partner_model->updatePartnerInfo($partnerTable);
			
			$adminUser["ADMIN_USER_ID"] 		 = $this->input->post('ADMIN_USER_ID');
			if($this->input->post('password')!="digient")
				$adminUser["PASSWORD"]  = md5($this->input->post('password'));				
			if($this->input->post('transactionpassword')!="digient")	
				$adminUser["TRANSACTION_PASSWORD"] = md5($this->input->post('transactionpassword'));
			$adminUser["PINCODE"] 			     = $this->input->post('pincode');			
			$adminUser["EMAIL"]                  = $this->input->post('email');
			$adminUser["STATE"]                  = $this->input->post('state');
			$adminUser["COUNTRY"]                = $this->input->post('country');
			$adminUser["REGISTRATION_TIMESTAMP"] = date('Y-m-d h:i:s');
			$updateUserInfo = $this->partner_model->updateUserInfo($adminUser);	
			
			/* Below are the code to update the user roles and permissions */												
			if($this->input->post('userRoles')) {
				$updateURData["adminUserID"]      = $this->input->post('ADMIN_USER_ID');
				$updateURData["userRaPermission"] = $this->input->post('userRoles');
				$updateUserRaPermissions = $this->partner_model->updateUserRolesAndPermissions($updateURData);
			}
			/* Below are the code to update the user roles and permissions */			
					
			if(!empty($updateUserInfo)) {
				$this->session->set_flashdata('message', 'Partner modified successfully.');
				redirect("partner/editPartner/".$partnerTable["PARTNER_ID"]."?rid=23");							
			}			
		} else {
			$data["partnerTypes"]    = $this->partner_model->getPartnerTypes($partnerTypeID);
			$data["commissionTypes"] = $this->partner_model->getCommissionTypes();	
			//$data["getStates"]		 = $this->partner_model->getStates();
			$data["getCountries"]	 = $this->partner_model->getCountries();		
			$data["parterDetails"]   = $this->partner_model->getPartnerDetails($partnerID);
			$this->load->view('partner/editpartner',$data);	
		}
	}
	
	public function viewPartnerPlayers($partnerID) {
		$viewPPlayers["viewPartnerInfo"] = $this->partner_model->viewPPartnerInfo($partnerID);	
		$viewPPlayers["viewPPlayerInfo"] = $this->partner_model->viewPartnerPlayersInfo($partnerID);		
		$this->load->view('partner/viewPlayers',$viewPPlayers);
	}
	
	public function viewPartnerAdmins($partnerID) {
		$viewPAdmin["viewPartnerInfo"] = $this->partner_model->viewPPartnerInfo($partnerID);
		$viewPAdmin["viewPAdminInfo"]  = $this->partner_model->viewPartnerAdminsInfo($partnerID);
		$this->load->view('partner/viewAdmins',$viewPAdmin);
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */