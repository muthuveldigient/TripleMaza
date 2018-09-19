 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Partners extends CI_Controller {

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
		$this->load->library(array('form_validation','session','pagination','encrypt'));
		$this->load->model('partners/partner_model');
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		//$USR_STATUS = $_SESSION['partnerstatus'];
		$USR_STATUS = "2";
		//$USR_PAR_ID = $this->session->userdata['partnerid'];
		//$USR_GRP_ID = $this->session->userdata['groupid'];

		/*if($USR_STATUS!=1) {
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
		}	*/
		$this->load->model('common/common_model');
		$this->load->model('user/Account_model');
		$this->load->model('user/cakewalk_model');
		
		if($this->common_model->authendicate() == '' )
    	{
    		$this->session->set_flashdata('message', 'Login to access the page');
    		redirect();
		}
		/*$userdata['USR_ID']    =$USR_ID;
		$userdata['USR_GRP_ID']=$USR_GRP_ID;
		$userdata['USR_STATUS']=$USR_STATUS;*/
		$searchdata['rdoSearch']='';
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);
		$this->load->view("common/header",$amount);
	}

	function authendication() {
		$adminusername = $this->session->userdata('adminusername');
		if($this->uri->uri_string() !== 'login' && !$adminusername) {
			$this->session->set_flashdata('message', 'Please login to access the page.');
        	redirect('login');
    	}
	}

	public function index() {
		$data["page_title"]    = "List Partners";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('partnerSearchData');
		}

		if($this->input->get('start') == 1){
			$this->session->unset_userdata('partnerSearchData');
		}

		if($this->input->post('frmSearch')) {

			$data["FK_PARTNER_TYPE_ID"]  	= $this->input->post('partnertype');
			$data["PARTNER_STATUS"]      	= $this->input->post('partnerstatus');
			$data["PARTNER_NAME"]        	= $this->input->post('partnername');
			$data["PARTNER_EMAIL"]       	= $this->input->post('partneremail');
			$data["CREATED_ON"]          	= $this->input->post('startdate');
			$data["CREATED_ON_END_DATE"] 	= $this->input->post('enddate');
			$data["SEARCH_LIMIT"] 			= $this->input->post('searchlimit');
			$data["PLAYERNAME"]          	= $this->input->post('playername');
			$data["LOGIN_STATUS"]          	= $this->input->post('partnerLstatus');
			$this->session->set_userdata(array('partnerSearchData'=>$data));
		    //echo $this->input->post('partnertype'); exit;
			if($this->input->post('partnertype')==0){
				$noOfRecords  = $this->partner_model->getUserDataCount($data);	//user
				$data["tot_users"]=$noOfRecords;
				$data["active_users"]  =$this->partner_model->getUserCountByStatus($data,1);
				$data["inactive_users"]=$this->partner_model->getUserCountByStatus($data,0);
			}else{
				$noOfRecords  = $this->partner_model->getPartnerDataCount($data);
				$data["tot_users"]=$noOfRecords;
				$data["active_users"]  =$this->partner_model->getPartnersCountByStatus($data,1);
				$data["inactive_users"]=$this->partner_model->getPartnersCountByStatus($data,0);
			}

		} else if($this->session->userdata('partnerSearchData')) {
			if($this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']==0){
				$noOfRecords  = $this->partner_model->getUserDataCount();		//user
			}else{
				$noOfRecords  = $this->partner_model->getPartnerDataCount();
			}
		} else {

			if($this->input->post('partnertype')==0){
				$noOfRecords  = $this->partner_model->getUserDataCount();		//user
			}else{
				$noOfRecords  = $this->partner_model->getPartnerDataCount();
			}
		}

		/* Set the config parameters */
		$config['base_url']   = base_url()."partners/partners/index";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit');
		$config['cur_page']   = $this->uri->segment(4);
		$config['suffix']     = '?rid=51';

			if($this->input->post('partnertype')==0){
				$config['order_by']	  = "USER_ID";
				$config['sort_order'] = "asc";		//user
			}else{
				$config['order_by']	  = "PARTNER_ID";
				$config['sort_order'] = "asc";
		    }


		if($this->input->post('frmSearch')) {
			if($this->input->post('partnertype')==0){
				$data["partner_info"] = $this->partner_model->getUserInfo($config,$data);		//user
			}else{
				$data["partner_info"] = $this->partner_model->getPartnerInfo($config,$data);
			}
				$data["searchResult"] = 1;

		} else if($this->session->userdata('partnerSearchData')) {
			$sesP=$this->session->userdata('partnerSearchData');
				if($sesP["FK_PARTNER_TYPE_ID"]==0){
					$data["partner_info"] = $this->partner_model->getUserInfo($config,$data);		//user
					$data["tot_users"]=$noOfRecords;
					$data["active_users"]  =$this->partner_model->getUserCountByStatus($data,1);
					$data["inactive_users"]=$this->partner_model->getUserCountByStatus($data,0);
				}else{
					$data["partner_info"] = $this->partner_model->getPartnerInfo($config,$data);
					$data["tot_users"]=$noOfRecords;
					$data["active_users"]  =$this->partner_model->getPartnersCountByStatus($data,1);
					$data["inactive_users"]=$this->partner_model->getPartnersCountByStatus($data,0);
				}
				$data["searchResult"] = 1;
		} else {
			$data["partner_info"] = $this->partner_model->getUserInfo($config,$data); //user
			//$data["FK_PARTNER_TYPE_ID"]  = 11;
			//$data["partner_info"] = $this->partner_model->getPartnerInfo($config,$data);
			$data["searchResult"] = "";
		}



		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();

		$partnerTypeID = $this->session->userdata['partnertypeid'];
		$data["partnerTypes"]   = $this->partner_model->getPartnerTypes($partnerTypeID);
		$data["getOwnPartners"] = $this->partner_model->getOwnPartners($this->session->userdata['partnerid']);
// 		echo '<pre>';print_r($data);exit;
		$this->load->view('partners/index',$data);
	}

	public function addPartner() {
		$rid=$this->input->get('rid');
		if($this->input->post('frmSubmit')) {
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Create Partner";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM2"]      =1;
			/** tracking info end */
			
			$session_data=$this->session->all_userdata();			
			$current_user_session_id=$this->input->post('current_user_session_id');
			if($current_user_session_id!=$session_data['session_id']) {		
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again.'));
				$this->db->insert("tracking",$arrTraking);			
				$this->session->set_flashdata('err_msg', 'Please try again.');
				redirect("partners/addpartner?rid=$rid");				
			}
			
			$partnerTypeID = $this->session->userdata['partnertypeid'];
			$adminusername = $this->session->userdata('adminusername');
			$data["PARTNER_NAME"]      = $this->input->post('p_username');
			$data["FK_PARTNER_TYPE_ID"]= $this->input->post('partnertype');	 //Type of partner(agent,distributor or sub agent)
			$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid'); //Parent ID
			//echo '<pre>';print_r($this->session->userdata);
			/* if($this->input->post('partnertype') == ($partnerTypeID + 1)) {
				$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid');
			} else  */
			if($this->input->post('partnertype') == 11) {		//$this->session->userdata['partnertypeid']
				$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid');
			} else if($this->input->post('partnertype') == 12) {
				if($this->input->post('superdistributor') != '')
					$data["FK_PARTNER_ID"]     = $this->input->post('superdistributor');
				else
					$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid');
			}  else if($this->input->post('partnertype') == 13) {
				if($this->input->post('distributor') != '')
					$data["FK_PARTNER_ID"]     = $this->input->post('distributor');
				else 
					$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid');
			} else if($this->input->post('partnertype') == 14) {
				if($this->input->post('subdistributor') != '')
					$data["FK_PARTNER_ID"]     = $this->input->post('subdistributor');
				elseif($this->input->post('distributor'))
					$data["FK_PARTNER_ID"]     = $this->input->post('distributor');
				else
					$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid');
		   } else if($this->input->post('partnertype') == 15) {
				if($this->input->post('masteragent') != '')
					$data["FK_PARTNER_ID"]     = $this->input->post('masteragent');
				else
					$data["FK_PARTNER_ID"]     = $this->session->userdata('partnerid');
			}
		   
			
			$amOUnt = $this->input->post('amount');
			if($amOUnt!=''){
				$res = $this->db->query('SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID='.mysql_real_escape_string($data["FK_PARTNER_ID"] ).'');
				$partner =  $res->row();
				$partner_current_bal = $partner->AMOUNT;
				if($data["FK_PARTNER_TYPE_ID"] !=11 ){#except main agent
					if($partner_current_bal < $amOUnt){
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Insufficient Partner Balance'));
						$this->db->insert("tracking",$arrTraking);
						$this->session->set_flashdata('err_msg', 'Insufficient Partner Balance!');
						redirect ("partners/addpartner?rid=$rid");
					}
				}
			}


			$p_username = $this->input->post('p_username');
			if($p_username!=''){
				$res = $this->db->query('SELECT PARTNER_ID FROM partner WHERE PARTNER_USERNAME="'.mysql_real_escape_string($p_username ).'"');
				$partnerInfo =  $res->row();

				if(!empty($partnerInfo)){
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Username already exists'));
						$this->db->insert("tracking",$arrTraking);
						$this->session->set_flashdata('err_msg', 'Username already exists');
						redirect ("partners/addpartner?rid=$rid");
				}
			}


			$data["PARTNER_USERNAME"]  = $this->input->post('p_username');
			$data["PARTNER_PASSWORD"]  = md5($this->input->post('p_password'));
            if($this->input->post('transactionpassword') != ""){
				$data["PARTNER_TRANSACTION_PASSWORD"] = md5($this->input->post('transactionpassword'));
			}else{
				$data["PARTNER_TRANSACTION_PASSWORD"] = "";
			}
			
			$data["PARTNER_REVENUE_SHARE"] 		  = $this->input->post('percentage');

			if($this->input->post('partnertype') == 11 || $this->input->post('partnertype') == 15){
				$data["PARTNER_COMMISSION_TYPE"] 	  = $this->input->post('commissiontype');
			}else{
				if($data["PARTNER_REVENUE_SHARE"]){
					if(!empty($data["FK_PARTNER_ID"])){
						$info=$this->partner_model->getPartnerDetails($data["FK_PARTNER_ID"]);
						if($info[0]->PARTNER_REVENUE_SHARE >= $data["PARTNER_REVENUE_SHARE"]) {
							$data["PARTNER_COMMISSION_TYPE"] =  $info[0]->PARTNER_COMMISSION_TYPE;
						} else {
							$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Percentage(%) not more then your immediate parent'));
							$this->db->insert("tracking",$arrTraking);
							$this->session->set_flashdata('err_msg', 'Percentage(%) not more then your immediate parent');
							redirect ("partners/addpartner?rid=$rid");
						}
					} 
				}
			}
			$data["IS_OWN_PARTNER"] 	 = 0;
			$data["PARTNER_STATUS"] 	 = 1;
			//$data["PARTNER_CREATED_ON"]  = date('Y-m-d h:i:s');
			$data["STATUS"]  			 = 1;
			$data["MPARTNER_ID"]  		 = $this->session->userdata('partnerid');
			//$data["CREATED_ON"]          = date('Y-m-d h:i:s');

			$data["LC_COMMISSION_TYPE"]     = $this->input->post('lc_commissiontype');
			$data["LC_REVENUE_SHARE"]     = $this->input->post('lc_percentage');
			$data["LC_STATUS"]     = $this->input->post('lc_available');						

			$addPartnerID = $this->partner_model->addPartner($data);
			$category     = $this->input->post('category');
			$gameIDs="";

			if(!empty($category)) {
				foreach($category as $catIndex=>$catIDs) {
						$gameIDs[]=$catIDs;
				}
			}
			
			if(!empty($gameIDs)) {
				$getMinigamesInfo=$this->partner_model->getMinigamesNamesInfo($gameIDs);

				if(!empty($getMinigamesInfo)) {
					foreach($getMinigamesInfo as $gIndex=>$gameInfo) {
						$reveshareInfo["PARTNER_ID"]        =$addPartnerID;
						$reveshareInfo["GAME_ID"]           =$gameInfo->MINIGAMES_NAME;
						$reveshareInfo["GAME_REVENUE_SHARE"]=$data["PARTNER_REVENUE_SHARE"];
						
						$addREVSahre=$this->partner_model->addGameRevenueShare($reveshareInfo);
					}
				}
			}

			/* Add partner login details in the admin_user table*/
			$pLoginInfo["USERNAME"]               = $this->input->post('p_username');
			$pLoginInfo["PASSWORD"]               = md5($this->input->post('p_password'));
			if($this->input->post('transactionpassword') != ""){
				$pLoginInfo["TRANSACTION_PASSWORD"]   = md5($this->input->post('transactionpassword'));
			}else{
				$pLoginInfo["TRANSACTION_PASSWORD"]   = "";
			}
			$pLoginInfo["FK_PARTNER_ID"]          = $addPartnerID;
			$pLoginInfo["ACCOUNT_STATUS"]         = 1;

			//$pLoginInfo["REGISTRATION_TIMESTAMP"] = date('Y-m-d h:i:s');
			$addPLoginInfo = $this->partner_model->addPLoginInfo($pLoginInfo);

			//Add Partner balance
			$pBalanceInfo['PARTNER_ID'] = $addPartnerID;
			$pBalanceInfo['AMOUNT'] = 0;

			//$pBalanceInfo['CREATED_DATE'] = date('Y-m-d h:i:s');
			$internal_ref_no='150'.$addPartnerID.date('d').date('m').date('y').date('H').date('i').date('s');
			$addBalanceInfo = $this->partner_model->addPBalanceInfo($pBalanceInfo);
			if($amOUnt!='' && $amOUnt!=0){
				$partnerBalance = $this->partner_model->BalanceUpdate($addPartnerID,$this->input->post('amount'),$adminusername,'newPartner','add',"",$internal_ref_no);
			}
			//Transaction Table Entries
			if($this->input->post('partnertype') > 11) {
				if($amOUnt!='' && $amOUnt!=0){
					$removepartnerBalance = $this->partner_model->BalanceUpdate($data["FK_PARTNER_ID"],$this->input->post('amount'),$this->input->post('p_username'),'cAgent','remove',"",$internal_ref_no); //Transaction Table Entries
				}
			}


			/* Below are the code to update the user roles and permissions */
			if($this->input->post('userRoles')) {
				$updateURData["adminUserID"]      = $addPLoginInfo;
				$updateURData["userRaPermission"] = $this->input->post('userRoles');
				foreach($updateURData["userRaPermission"] as $userPData) {

					$role2AdminData["FK_ADMIN_USER_ID"] = $updateURData["adminUserID"];
					$role2AdminData["FK_ROLE_ID"]       = $userPData;
					$role2AdminData["CREATE_BY"]        = $this->session->userdata['partnerusername'];
					//$role2AdminData["CREATE_DATE"]      = date('Y-m-d h:i:s');

					$adRole2Admin = $this->partner_model->adRoles2Admin($role2AdminData);

				}
			}
			/* Below are the code to update the user roles and permissions */

			/* This is to add the roles and the permissions to the created user */
			/*if($data["FK_PARTNER_TYPE_ID"]==13) { //white label partner, so provide all the access
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
			}*/

			if(!empty($addPLoginInfo)) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Agent created successfully'));
				$this->db->insert("tracking",$arrTraking);
				$this->session->set_flashdata('message', 'Agent created successfully.');
				redirect("partners/addpartner?rid=$rid");
			}else{
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Agent not created'));
				$this->db->insert("tracking",$arrTraking);
				$this->session->set_flashdata('err_msg', 'Agent not created');
				redirect("partners/addpartner?rid=$rid");
			}
		} else {
			//partnertypeid
			$partnerTypeID = $this->session->userdata['partnertypeid'];
			$data["partnerTypes"]    = $this->partner_model->getPartnerTypes($partnerTypeID);
			$data["commissionTypes"] = $this->partner_model->getCommissionTypes();
			
			if($partnerTypeID > 0) {
				$agames = $this->partner_model->userMinigamesList($this->session->userdata('partnerid'));

				if($agames != NULL || $agames != "" && $partnerTypeID > 0)
					$data["minigamesList"]    = $this->partner_model->minigamesList($agames);
				} else {
					$data["minigamesList"]    = $this->partner_model->minigamesList();
				}

			//$data["getStates"]		 = $this->partner_model->getStates();
			$data["getCountries"]	 = $this->partner_model->getCountries();

			if($partnerTypeID == 0) {
				$moduleIDs  = $this->config->item('moduleAccess'); //modules which is not needed to the user
				$getMainRoles = $this->partner_model->getMainRoles($moduleIDs);
				$partnerMenu = "";
			} else {
				if($partnerTypeID == 11) $modname = 'moduleAccess'; else if($partnerTypeID == 12) $modname = 'moduleAccessForDist'; else if($partnerTypeID == 13) $modname = 'moduleAccessForSubdist'; else if($partnerTypeID == 14) $modname = 'moduleAccessForAgent';
				$partnerID = $this->session->userdata['partnertypeid'];
				$partnerMenu = $this->partner_model->getExistingUserRolesIDs($this->session->userdata('adminuserid'));
				$moduleIDs  = $this->config->item($modname); //modules which is not needed to the user
				$getMainRoles = $this->partner_model->getMainRoles($moduleIDs);
			}

			if(!empty($getMainRoles)) {
				$menuArr = array();
				$i=0;
				$menuArr['maxChild'] = 0;
				foreach($getMainRoles as $mainRole) {
					$menuArr[$i]['ROLE_ID'] = $mainRole->ROLE_ID;
					$menuArr[$i]['ROLE_NAME'] = $mainRole->ROLE_NAME;
					$getChildRoles = $this->partner_model->getChildRoles($mainRole->ROLE_ID,$partnerMenu);
					$menuArr[$i]['ROLE_CHILD'] = $getChildRoles;
					$menuArr[$i]['ROLE_CHILD_CNT'] = count($getChildRoles);
					if($menuArr[$i]['ROLE_CHILD_CNT'] > $menuArr['maxChild'])
						$menuArr['maxChild'] = $menuArr[$i]['ROLE_CHILD_CNT'];
					$i++;
				}

			}
			//echo '<pre>';print_r($menuArr);exit;
			//GET POKER_GAME PERCENTAGE
			/* $data["pokerShare"]	 ='';
			if($partnerTypeID==0){
				$data["pokerShare"]	 =1;
			}else{
				$pgames=$this->partner_model->userMinigamesList($this->session->userdata('partnerid'));
				if(in_array('mobpoker',$pgames)){
					$data["pokerShare"]   = 1;
				}
			} */
			
			
			$data["menuList"]	 = $menuArr;
			$data['rid']	= $rid;


			
			$this->load->view('partners/addpartner',$data);
		}
	}

	public function viewPartner($partnerID) {
		$getPartnerDetails = $this->partner_model->viewPartnerInfo($partnerID);
		
		$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
	     
	     if(!in_array($partnerID, $loggedin_partnerid)){
            redirect("partners/index?rid=51&errmsg=407&start=1");die;
        }
	    //bulild HTML string
	   	$partnerViewData .= "<table style='padding-left: 10px;'>";
		$partnerViewData .= "<tr><td colspan='2'><b><u>Partner Details</u></b></td></tr>";
		$partnerViewData .= "<tr><td><b>Partner Name:</b> </td><td>".$getPartnerDetails[0]->viewPartnerInfo."</td></tr>";
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

	public function chkUserExistence() {
		$getUserExistence = $this->partner_model->chkUserExistence($_GET['p_username']);
		if($getUserExistence==1)
			echo '"Username is alreadyexists"';
		else
			echo 'true';
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
		if(!empty($partnerIDs) && $partnerTypeID!=11) {
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

	public function changeActivePartnerStatus($curStatus, $partnerID, $newStatus,$pType) {
	if($pType==0){
		$userInfo =  $this->partner_model->getUserInformation($partnerID);

		$userPartnerID = (!empty($userInfo[0]->PARTNER_ID)?$userInfo[0]->PARTNER_ID:'');
		$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
	     
	    if(!in_array($userPartnerID, $loggedin_partnerid)){
           redirect("partners/index?rid=51&errmsg=407&start=1");die;
        }
		
		$status = $this->partner_model->getUserPartnerStatus($partnerID);
		$action ='User';
		$adUserdata["USER_ID"]     = $partnerID;
		$adUserdata["ACCOUNT_STATUS"] = $newStatus;
		if($status==1) {
			$changeUserStatus = 	$this->partner_model->changeUserStatus($adUserdata);
		}
	}else {
		$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
	     
	     if(!in_array($partnerID, $loggedin_partnerid)){
            redirect("partners/index?rid=51&errmsg=407&start=1");die;
        }
		$status = $this->partner_model->getAgentPartnerStatus($partnerID);
		$action ='Partner';
		$adUserdata["PARTNER_ID"]     = $partnerID;
		$adUserdata["PARTNER_STATUS"] = $newStatus;
		if($status==1) {
			$changePartnerStatus = 	$this->partner_model->changePartnerStatus($adUserdata);
		}
	}
		if($status==1) {
			if($newStatus==1) {
				$arrTraking["ACTION_NAME"]  = $action." Active";
				$partnerStatusValue = '<a href="#" onclick="javascript:activatedeaUser(1,'.$partnerID.',0,'.$pType.')"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a>';
			} else {
				$arrTraking["ACTION_NAME"]  = $action." Deactive";
				$partnerStatusValue = '<a href="#" onclick="javascript:activatedeaUser(0,'.$partnerID.',1,'.$pType.')"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a>';
			}
		}else{
			$arrTraking["ACTION_NAME"]  = $action." Invalid";
			$partnerStatusValue ='Invalid';
		}
		$partnerStatusValue = $partnerStatusValue."_".$partnerID;
		
		/** tracking info */
		$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
		$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM1"]      =json_encode(array('pType'=>$pType,'Info'=>$adUserdata));
		$arrTraking["CUSTOM2"]      =1;
		$this->db->insert("tracking",$arrTraking);
		/** tracking info end */
			
		print_r($partnerStatusValue);die;
	}

	public function editPartner($partnerID) {
		//$departnerID = $this->encrypt->decode($partnerID);
		$departnerID = base64_decode($partnerID);
		
		if($departnerID){
	     $loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
	     
	     if(!in_array($departnerID, $loggedin_partnerid)){
            redirect("partners/index?rid=51&errmsg=407&start=1");
        }

		$adminuserid_det = $this->partner_model->viewPartnerAdminsInfo($departnerID);
		$adminuserid =$adminuserid_det[0]->ADMIN_USER_ID;
		}

		if($this->input->post('frmSubmit')) {
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Edit Partner";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM2"]      =1;
			/** tracking info end */
			
			$partnerTable["PARTNER_ID"]          = $this->input->post('PARTNER_ID');
			//$partnerTable["PARTNER_NAME"]        = $this->input->post('partnername');
			$partnerTable["PARTNER_ADDRESS1"]    = $this->input->post('adderss');
			$partnerTable["PARTNER_PHONE"]       = $this->input->post('phone');
			$partnerTable["PARTNER_CITY"]        = $this->input->post('city');
			$partnerTable["PARTNER_STATE"]       = $this->input->post('state');
			$partnerTable["PARTNER_COUNTRY"]     = $this->input->post('country');
			$partnerTable["PARTNER_MOBILE"]      = $this->input->post('mobile');
			$partnerTable["PARTNER_EMAIL"]       = $this->input->post('email');
			$partnerTable["PARTNER_DESIGNATION"] = $this->input->post('designation');
			$partnerTable["PARTNER_CONTACT_PERSON"] = $this->input->post('contactperson');
			
			if($this->input->post('password')!="digient"){
				$partnerTable["PARTNER_PASSWORD"]  = md5($this->input->post('password'));
				$partnerTable["PASSWORD_RESET_STATUS"]  = 1;
			}
			if($this->input->post('transactionpassword')!="digient"){
				$partnerTable["PARTNER_TRANSACTION_PASSWORD"] = md5($this->input->post('transactionpassword'));
			}

			#commission type and revenue share only editable main agent and super distributor
			$parter_info = $this->partner_model->getPartnerDetails($partnerTable["PARTNER_ID"]);
			$edit_partner_type= $parter_info[0]->FK_PARTNER_TYPE_ID;
			if($edit_partner_type==11 || $edit_partner_type==15){
				$partnerTable["PARTNER_REVENUE_SHARE"] 		  = $this->input->post('percentage');
				$partnerTable["PARTNER_COMMISSION_TYPE"] 	  = $this->input->post('commissiontype');
			}
		
			//$partnerTable["LC_COMMISSION_TYPE"]     = $this->input->post('lc_commissiontype');
			//$partnerTable["LC_REVENUE_SHARE"]     = $this->input->post('lc_percentage');
			$partnerTable["LC_STATUS"]     = $this->input->post('lc_available');

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
			//Update Minigames
			$this->partner_model->updateUserMinigames($this->input->post('minigamesAll'), $this->input->post('agentgames'), $partnerTable["PARTNER_ID"]);

			if(!empty($updateUserInfo)) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Agent modified successfully'));
				$this->db->insert("tracking",$arrTraking);
				
				$this->session->set_flashdata('message', 'Agent modified successfully.');
				//$encPartnerId = $this->encrypt->encode($partnerTable["PARTNER_ID"]);
				$encPartnerId = base64_encode($partnerTable["PARTNER_ID"]);
				redirect("partners/partners/editPartner/".$encPartnerId."?rid=51");
			}else{
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Agent doesnot modified'));
				$this->db->insert("tracking",$arrTraking);
				$this->session->set_flashdata('message', 'Agent doesnot modified');
				//$encPartnerId = $this->encrypt->encode($partnerTable["PARTNER_ID"]);
				$encPartnerId = base64_encode($partnerTable["PARTNER_ID"]);
				redirect("partners/partners/editPartner/".$encPartnerId."?rid=51");
			}
		} else {
			$partnerTypeID = $this->session->userdata('partnertypeid');
			$data["partnerTypes"]    = $this->partner_model->getPartnerTypes($partnerTypeID);
			$data["commissionTypes"] = $this->partner_model->getCommissionTypes();
			//$data["getStates"]		 = $this->partner_model->getStates();
			$data["getCountries"]	 = $this->partner_model->getCountries();
			$parterDetails = $this->partner_model->getPartnerDetails($departnerID);
			$data["parterDetails"]   = $parterDetails;
			$data["edit_partner_type"]= $parterDetails[0]->FK_PARTNER_TYPE_ID;
			
			//Minigames
			if($parterDetails){
			if($partnerTypeID > 0) $fkPartnerId = $parterDetails[0]->FK_PARTNER_ID; else $fkPartnerId = 0;
			}
			
			/* old code may be use future
			if($fkPartnerId != 0) {
				$uGames = $this->partner_model->partnerBaseMinigamesList($fkPartnerId);
			} else {
				$uGames = array(0);
			}
			$data["minigamesList"]	 = $this->partner_model->minigamesList($uGames);
			
			if(!empty($fkPartnerId)) {
				
				$agames=$this->partner_model->userMinigamesList($fkPartnerId);
				if($agames != NULL || $agames != "")
					$data["minigamesList"]	 =$this->partner_model->minigamesList($agames);
				else
					$data["minigamesList"]	 = array();
			}else{
				$data["minigamesList"]	 =$this->partner_model->minigamesList();
			}
			
			 */

			 
			 $data["minigamesList"]	 = array();
			if(!empty($departnerID)) {
				$agames=$this->partner_model->userMinigamesList($departnerID);
				if($agames != NULL || $agames != "") {
					$data["minigamesList"]	 =$this->partner_model->minigamesList($agames);
				}
			}

			$curAgames = $this->partner_model->partnerMinigamesList($departnerID);
			
			$curAgamesArr = array();
			foreach($curAgames as $cagame) {
				$curAgamesArr[$cagame->GAME_ID] = $cagame->GAME_REVENUE_SHARE;
			}
			
			$data["partnerGameRevenue"]	 = $curAgamesArr;

			//echo '<pre>';print_r($departnerID);exit;
			if($partnerTypeID == 0) {
				$moduleIDs  = $this->config->item('moduleAccess'); //modules which is not needed to the user
				$getMainRoles = $this->partner_model->getMainRoles($moduleIDs);
			} else {
				if($partnerTypeID == 11) $modname = 'moduleAccess'; else if($partnerTypeID == 12) $modname = 'moduleAccessForDist'; else if($partnerTypeID == 13) $modname = 'moduleAccessForSubdist'; else if($partnerTypeID == 14) $modname = 'moduleAccessForAgent';

				$moduleIDs  = $this->config->item($modname); //modules which is not needed to the user
				$getMainRoles = $this->partner_model->getMainRoles($moduleIDs);
			}

			//GET SHAN_GAME PERCENTAGE
			$shanPercent = $this->partner_model->partnerShanMinigamePercent($departnerID);
			$shanShare   = $shanPercent[0]->GAME_REVENUE_SHARE;
			
			//GET POKER_GAME PERCENTAGE
			/* $data["pokerShare"]	 ='';
			if($partnerTypeID==0){ //FOR ADMIN
				$poker1['partner_id']=$departnerID;
				$poker1['game_name']=ONLINE_POKER_GAME_NAME;
				$pokerPercent1 = $this->partner_model->partnerMinigamePercent($poker1);
				$data["pokerShare"]   = (!empty($pokerPercent1[0]->GAME_REVENUE_SHARE)?$pokerPercent1[0]->GAME_REVENUE_SHARE:'valid');
			}
			if(!empty($fkPartnerId)) {
				$pgames=$this->partner_model->userMinigamesList($fkPartnerId);
				/* $data["pokerShare"]	 ='0';
				if($partnerTypeID==11){
					$data["pokerShare"]	 ='valid';
				} */
			/*	if(in_array('mobpoker',$pgames)){
					$poker['partner_id']=$departnerID;
					$poker['game_name']=ONLINE_POKER_GAME_NAME;
					$pokerPercent = $this->partner_model->partnerMinigamePercent($poker);
					$data["pokerShare"]   = (!empty($pokerPercent[0]->GAME_REVENUE_SHARE)?$pokerPercent[0]->GAME_REVENUE_SHARE:'valid');
				}
			} */
			if(!empty($getMainRoles)) {
				$menuArr = array();
				$i=0;
				$menuArr['maxChild'] = 0;
				foreach($getMainRoles as $mainRole) {
					$menuArr[$i]['ROLE_ID'] = $mainRole->ROLE_ID;
					$menuArr[$i]['ROLE_NAME'] = $mainRole->ROLE_NAME;
					$getChildRoles = $this->partner_model->getChildRoles($mainRole->ROLE_ID);
					$menuArr[$i]['ROLE_CHILD'] = $getChildRoles;
					$menuArr[$i]['ROLE_CHILD_CNT'] = count($getChildRoles);
					if($menuArr[$i]['ROLE_CHILD_CNT'] > $menuArr['maxChild'])
						$menuArr['maxChild'] = $menuArr[$i]['ROLE_CHILD_CNT'];
					$i++;
				}

			}
			$data["shanShare"]    = $shanShare;
			$data["exitRole"]    = $this->partner_model->getExistingUserRolesIDs($adminuserid);
			$data["menuList"]	 = $menuArr;


			$this->load->view('partners/editpartner',$data);
		}
	}

	public function viewPartnerPlayers($partnerID) {
		//$viewPPlayers["viewPartnerInfo"] = $this->partner_model->viewPPartnerInfo($partnerID);
		//$dePartnerId = $this->encrypt->decode($partnerID);
		$dePartnerId = base64_decode($partnerID);
		$viewPPlayers["viewPPlayerInfo"] = $this->partner_model->viewPartnerPlayersInfo($dePartnerId);
		$partnername=$this->partner_model->getPartnerNameById($dePartnerId);
		$viewPPlayers["partnername"] = $partnername;
		$this->load->view('partners/viewPlayers',$viewPPlayers);
	}

	/*public function viewPartnerAdmins($partnerID) {
		$viewPAdmin["viewPartnerInfo"] = $this->partner_model->viewPPartnerInfo($partnerID);
		$viewPAdmin["viewPAdminInfo"]  = $this->partner_model->viewPartnerAdminsInfo($partnerID);
		$this->load->view('partner/viewAdmins',$viewPAdmin);
	}*/

	//Thiru

	public function adjust(){
		if(isset($_POST['submit']) && $_POST['p_name']!="") {
		 $departnerID=$this->partner_model->getPartnerIdByName($_POST['p_name']);
		} else {
		 $departnerID = base64_decode($_REQUEST["pid"]);
		}

		$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
		if(!in_array($departnerID, $loggedin_partnerid)){
				redirect("partners/index?rid=51&errmsg=407&start=1");
		}

		$adminusername = $this->session->userdata['adminusername'];
		if(isset($_POST['submit']) && $_POST['p_name']!=""){
			$partnerId = $this->session->userdata['partnerid'];
			$partnerInfoId = $this->partner_model->getPartnerIdByName($_POST['p_name']);
			$partnerfkid = $this->partner_model->getFKPartnerId($partnerInfoId);

			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Transfer Points";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
		//	$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST));
			$arrTraking["CUSTOM2"]      =1;
		//	$this->db->insert("tracking",$arrTraking);
			/** tracking info end */
			
			//$enPartnerId = $this->encrypt->encode($partnerInfoId);
			$enPartnerId = base64_encode($partnerInfoId);
			if($_POST['p_amount']!='' && substr($_POST['p_amount'],0,1)==0){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points should be greater than zero'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/adjust/?pid=".$enPartnerId."&pty=".$_POST['pty']."&rid=51&msg=16");
			}

			$partnerstatus = $this->partner_model->getPStatus($partnerInfoId);
			if($partnerstatus!='1'){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Account is deactivated. You cannot transfer points'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/adjust/?pid=".$enPartnerId."&pty=".$_POST['pty']."&rid=51&msg=15");
			}

			$partnerBalance = $this->partner_model->getmPartnerBalance($partnerfkid);
			$cpartnerBalance = $this->partner_model->getmPartnerBalance($partnerInfoId);
	
			if($partnerInfoId =='')	{
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Username not exists'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/adjust?pty=".$_POST['pty']."&rid=51&msg=10");
			}

			if($_POST['adjust'] == "Add"){
				if($partnerBalance>=$_POST['p_amount'] || $partnerfkid==ADMIN_ID){
					$internal_ref_no='150'.$partnerInfoId.date('d').date('m').date('y').date('H').date('i').date('s');
					$partnerBalance = $this->partner_model->BalanceUpdate($partnerInfoId,$_POST['p_amount'],$adminusername,'cAgent','add',$_POST['comments'],$internal_ref_no);
					if($partnerfkid!=ADMIN_ID)	{
						$partnerBalance1 = $this->partner_model->BalanceUpdate($partnerfkid,$_POST['p_amount'],$_POST['p_name'],'cAgent','remove',$_POST['comments'],$internal_ref_no);
					}
				}else{
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points exceeds yours available balance.'));
					$this->db->insert("tracking",$arrTraking);
					redirect("partners/partners/adjust?pid=".$enPartnerId."&pty=".$_POST['pty']."&rid=51&msg=7&p_name=".base64_encode($_POST['p_name'])."&adj=".base64_encode($_POST['adjust'])."&amt=".base64_encode($_POST['p_amount'])."&uamt=".base64_encode($partnerBalance));
				}
			}else if($_POST['adjust'] == "Remove"){
				if($cpartnerBalance>=$_POST['p_amount'] || $partnerfkid==ADMIN_ID){
				  $internal_ref_no='150'.$partnerInfoId.date('d').date('m').date('y').date('H').date('i').date('s');
				  $partnerBalance = $this->partner_model->BalanceUpdate($partnerInfoId,$_POST['p_amount'],$adminusername,'cAgent','remove',$_POST['comments'],$internal_ref_no);
				  if($partnerfkid!=ADMIN_ID){
				  		$partnerBalance = $this->partner_model->BalanceUpdate($partnerfkid,$_POST['p_amount'],$_POST['p_name'],'cAgent','add',$_POST['comments'],$internal_ref_no);
					}
				}else{
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points exceeds yours available balance.'));
					$this->db->insert("tracking",$arrTraking);
					redirect("partners/partners/adjust?pid=".$enPartnerId."&pty=".$_POST['pty']."&rid=51&msg=7&p_name=".base64_encode($_POST['p_name'])."&adj=".base64_encode($_POST['adjust'])."&amt=".base64_encode($_POST['p_amount'])."&uamt=".base64_encode($partnerBalance));
				}
			}
			
			$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points adjusted successfully'));
			$this->db->insert("tracking",$arrTraking);
			redirect("partners/partners/adjust?pid=".$enPartnerId."&pty=".$_POST['pty']."&rid=51&msg=6");
		}
		$data['users'] = $this->partner_model->getAllMainAgentPartnerIds();
		$this->load->view('partners/adjust',$data,false,true);
	}

	public function userAdjust(){

		$adminusername = $this->session->userdata['adminusername'];
		if(isset($_POST['submit']) && $_POST['p_name']!="")	{
			$pid = $this->partner_model->getPartnerIdByUsername($_POST['p_name']);
			$userid= $this->partner_model->getUserIdByName($_POST['p_name']);
			
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Transfer Points";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			//$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST));
			$arrTraking["CUSTOM2"]      =1;
		//	$this->db->insert("tracking",$arrTraking);
			/** tracking info end */
			
			//if($_POST['p_amount']!='' && substr($_POST['p_amount'],0,1)==0){
      //echo $_POST['p_amount'];
			if($_POST['p_amount'] < 0){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Account is deactivated. You cannot transfer points'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=15".$qvar);
			}
      //die;
      //echo $userid;
			 $userstatus = $this->partner_model->getUStatus($userid);
			if($userstatus!='1'){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Account is deactivated. You cannot transfer points'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=15".$qvar);
			}

			$comments= $_POST['comments'];
		if(isset($pid))	{
			$partnerfkid = $this->partner_model->getFKPartnerId($pid);
			$partnerBalance = $this->partner_model->getmPartnerBalance($pid);

			$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
			$loggedin_partnerid=array();

			if(strstr($loggedin_partnerid,",")){
				$loggedin_partnerid=explode(",",$loggedin_partnerid);
			}else{
				$loggedin_partnerid=$loggedin_partnerid;
			}

			 if($_POST['adjust'] == "Add") { // If add then only need to check the partner balance
			   if($partnerBalance < $_POST['p_amount']){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points exceeds agents available balance'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=7");
			   }
			 }


			//if($partnerBalance>=$_POST['p_amount'])
			//{
				/* BELOW IS THE CODE FOR KHELO API - TRANSFER POINTS TO USER */
				/*
				$ireference=rand(1000000000,9999999999);
				$this->db->trans_begin();
				$sql_agntbal=$this->db->query("select AMOUNT from partners_balance where PARTNER_ID='".$pid."'");
				$row_agntbal=$sql_agntbal->row();
				if($_POST['adjust'] == "Add") {
					$transactionStatusId = "107";
					$transactionTypeId="21";
					$balanceTypeId="2";
					$newagntbal=$row_agntbal->AMOUNT;
					$newagntclosebal=$row_agntbal->AMOUNT-$_POST['p_amount'];
				} else {
					$transactionStatusId = "111";
					$transactionTypeId="21";
					$balanceTypeId="2";
					$newagntbal=$row_agntbal->AMOUNT;
					$newagntclosebal=$row_agntbal->AMOUNT+$_POST['p_amount'];
				}
				$subtractmbaltrans="insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,INTERNAL_REFERENCE_NO,".
								   "CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,USER_ID,PROCESSED_BY)values('".$pid."',".
								   "".$transactionTypeId.",".$transactionStatusId.",'".$_POST['p_amount']."','".$ireference."','".$newagntbal."',".
								   "'".$newagntclosebal."',now(),'".$userid."','".$this->session->userdata['partnerusername']."')";
				$query_pt=$this->db->query($subtractmbaltrans);

				$query_ad=$this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`FK_PARTNER_ID` ,`FK_TRANSACTION_TYPE_ID` ,".
										   "`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION`,".
										   "`ADJUSTMENT_COMMENT`)VALUES(NULL,'".$pid."',".$transactionTypeId.",'$ireference','".$_POST['p_name']."',NOW(),".
										   "'".$_POST['p_amount']."','".$_POST['adjust']."','test')");
				$query_pt2=$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,".
											"INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,PROCESSED_BY".
											")values('".$pid."',".$transactionTypeId.",".$transactionStatusId.",'".$_POST['p_amount']."',".
											"'".$ireference."','".$newagntbal."','".$newagntclosebal."',now(),'".$this->session->userdata['partnerusername']."')");
				if($_POST['adjust'] == "Add") {
					$query_p=$this->db->query("update partners_balance set AMOUNT=AMOUNT-".$_POST['p_amount']." where PARTNER_ID=".$pid."");
				} else {
					$query_p=$this->db->query("update partners_balance set AMOUNT=AMOUNT+".$_POST['p_amount']." where PARTNER_ID=".$pid."");
				}
				*/
				/* BELOW IS THE CODE FOR KHELO API - TRANSFER POINTS TO USER */

				$session_id=$this->session->userdata('session_id');
				$request1='{"action":"balanceSessionAction","sessionid":"'.$session_id.'"}';
				$URL = BALANCE_UPDATE_API."?xmlString=$request1";
				$ch1 = curl_init($URL);
				curl_setopt($ch1, CURLOPT_MUTE, 1);
				curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch1, CURLOPT_POST, 1);
				curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
				curl_setopt($ch1, CURLOPT_POSTFIELDS, $request1);
				curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
				$response1 = curl_exec($ch1);
				curl_close($ch1);
				$dresponse1=json_decode(trim($response1),true);

				if($dresponse1['action']!="error"){
					if($dresponse1['action']=='balanceSessionAction' && $dresponse1['sessionid']==$session_id){
						$transactionid=$dresponse1['transactionid'];
						$ireference='151'.$userid.date('d').date('m').date('y').date('H').date('i').date('s');

					if($_POST['adjust'] == "Add")
					{
						$transactionStatusId = "130";
						$transactionTypeId="22";
						$balanceTypeId="1";
						$partnertransactionStatusId = 131;
						$partnertransactionTypeId = 22;
						$cointypeid=1;
						 $request2=urlencode('{"action":"balupdatereqconf","sessionid":"'.$session_id.'","transactionid":"'.$transactionid.'","userid":"'.$userid.'","amount":'.$_POST['p_amount'].',"type":"add","username":"'.$_POST['p_name'].'","transactionstatusId":"'.$transactionStatusId.'","transactiontypeid":"'.$transactionTypeId.'","balancetypeid":"'.$balanceTypeId.'","ireferno":"'.$ireference.'","partnerid":"'.$pid.'","partnerusername":"'.$this->session->userdata['partnerusername'].'","ptranStatusId":"'.$partnertransactionStatusId.'","ptranTypeId":"'.$partnertransactionTypeId.'","logParId":"'.$this->session->userdata['partnerid'].'","comment":"'.$comments.'","cointypeid":"'.$cointypeid.'"}');
					 }else{
						$transactionStatusId = "131";
						$transactionTypeId="22";
						$balanceTypeId="1";
						$partnertransactionStatusId = 130;
						$partnertransactionTypeId = 22;
						$cointypeid=1;
						 $request2=urlencode('{"action":"balupdatereqconf","sessionid":"'.$session_id.'","transactionid":"'.$transactionid.'","userid":"'.$userid.'","amount":'.$_POST['p_amount'].',"type":"subtract","username":"'.$_POST['p_name'].'","transactionstatusId":"'.$transactionStatusId.'","transactiontypeid":"'.$transactionTypeId.'","balancetypeid":"'.$balanceTypeId.'","ireferno":"'.$ireference.'","partnerid":"'.$pid.'","partnerusername":"'.$this->session->userdata['partnerusername'].'","ptranStatusId":"'.$partnertransactionStatusId.'","ptranTypeId":"'.$partnertransactionTypeId.'","logParId":"'.$this->session->userdata['partnerid'].'","comment":"'.$comments.'","cointypeid":"'.$cointypeid.'"}');
					  }
//echo '{"action":"balupdatereqconf","sessionid":"'.$session_id.'","transactionid":"'.$transactionid.'","userid":"'.$userid.'","amount":'.$_POST['p_amount'].',"type":"subtract","username":"'.$_POST['p_name'].'","transactionstatusId":"'.$transactionStatusId.'","transactiontypeid":"'.$transactionTypeId.'","balancetypeid":"'.$balanceTypeId.'","ireferno":"'.$ireference.'","partnerid":"'.$pid.'","partnerusername":"'.$this->session->userdata['partnerusername'].'","ptranStatusId":"'.$partnertransactionStatusId.'","ptranTypeId":"'.$partnertransactionTypeId.'","logParId":"'.$this->session->userdata['partnerid'].'","comment":"'.$comments.'","cointypeid":"'.$cointypeid.'"}'; die;

						 $URL2 = BALANCE_UPDATE_API."?xmlString=$request2";
						 $ch2 = curl_init($URL2);
						 curl_setopt($ch2, CURLOPT_MUTE, 1);
						 curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
						 curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
						 curl_setopt($ch2, CURLOPT_POST, 1);
						 curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
						 curl_setopt($ch2, CURLOPT_POSTFIELDS, $request2);
						 curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
						 $response2 = curl_exec($ch2);
						 curl_close($ch2);
						 $dresponse2=json_decode(trim($response2),true);
						 $userid1=$dresponse2['userid'];
						 $statusupdate=$dresponse2['status'];
		//die;
						 if($dresponse2['action']=='balupdateresconf' && $dresponse2['sessionid']==$session_id &&  $userid==$userid1 && $statusupdate=="true"){
							$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points transfered successfully'));
							$this->db->insert("tracking",$arrTraking);
						   redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=6");
						 }else{
							 $arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
							$this->db->insert("tracking",$arrTraking);
						   redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=8");
						 }
					}else{
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
							$this->db->insert("tracking",$arrTraking);
					  redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=8");
					}
				}else{
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
					$this->db->insert("tracking",$arrTraking);
				  redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=8");
				}
		   //}else{
		   //		redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=7");
		   //}

		}else{
			$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Username not exists'));
			$this->db->insert("tracking",$arrTraking);
			redirect("partners/partners/details/".base64_encode($userid)."?rid=51&msg=9");
		}

		}

	}

	public function changePass() {
	   if(isset($_POST['old_pass']) && isset($_POST['new_pass'])){
		  
		  /** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Change Password";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM2"]      =1;
			
			$_REQUEST['old_pass']	=md5($_POST['old_pass']);
			$_REQUEST['new_pass']	=md5($_POST['new_pass']);
			$_REQUEST['cnew_pass']	=md5($_POST['cnew_pass']);
			/** tracking info end */
			
			$datapass['old_pass'] = $_POST['old_pass'];
			$datapass['new_pass'] = $_POST['new_pass'];
			$partnerChangepas = $this->partner_model->updateChangePass($datapass);
			if($partnerChangepas==1) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Password changed successfully'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/changePass?rid=56&msg=11");
				die;
			}elseif($partnerChangepas==3) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Old Password and New Password is same'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/changePass?rid=56&msg=13");
				die;
			}else{
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Incorrect old password entered'));
				$this->db->insert("tracking",$arrTraking);
                redirect("partners/partners/changePass?rid=56&msg=12");
				die;
			}
		}
		$this->load->view('partners/changepassword',NULL,false,true);
  }

  public function changeTransPass() {
	   if(isset($_POST['old_trans_pass']) && isset($_POST['new_trans_pass'])){

			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Change Transaction Password";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST));
			$arrTraking["CUSTOM2"]      =1;
			
			$_REQUEST['old_trans_pass']	=md5($_POST['old_trans_pass']);
			$_REQUEST['new_trans_pass']	=md5($_POST['new_trans_pass']);
			$_REQUEST['cnew_trans_pass']=md5($_POST['cnew_trans_pass']);
			$this->db->insert("tracking",$arrTraking);
			/** tracking info end */
			
			$datapass['old_pass'] = $_POST['old_trans_pass'];
			$datapass['new_pass'] = $_POST['new_trans_pass'];
			$partnerChangepas = $this->partner_model->updateChangeTransPass($datapass);
			if($partnerChangepas==1) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Password changed successfully'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/changePass?rid=56&msg=11");
				die;
			} else {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Incorrect old password entered'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/changePass?rid=56&msg=12");
				die;
			}
		}
		$this->load->view('partners/changepassword',NULL,false,true);
  }

  public function viewTypeOfPartners($partnerID,$partnerTypeID) {
  		//$dePartnerId = $this->encrypt->decode($partnerID);
		$dePartnerId = base64_decode($partnerID);
		$viewPartner["viewPartnerInfo"] = $this->partner_model->viewPPartnerInfo($dePartnerId,$partnerTypeID);
		$this->load->view('partners/viewptypes',$viewPartner,false,true);
	}

	public function validateTransactionPass(){

		$pid = $_REQUEST['pid'];

		if($_POST['partnertransaction_password']!=''){
				$checktransExist = $this->partner_model->checkTransPassExist();
				if($checktransExist==1){
					$checktransPass = $this->partner_model->checkTransPass(md5($_REQUEST['partnertransaction_password']));
					if($checktransPass==2){
						redirect("partners/index?start=1&rid=51&errmsg=404");
					}else{
					   redirect("partners/partners/transferPoints/?rid=52&pid=".$pid);
					}
				}
			}else{
				 redirect("partners/index?start=1&rid=51&errmsg=404");
			}
	}

	public function transferPoints_old(){
		$pid=$this->input->get('pid');

		$dpid = $this->encrypt->decode($pid);

		//$pid=base64_decode($pid);


		$adminusername = $this->session->userdata['adminusername'];
		if(isset($_POST['submit']) && $pid!="")
		{
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Transfer Points old";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST));
			$arrTraking["CUSTOM2"]      =1;
			$this->db->insert("tracking",$arrTraking);
			/** tracking info end */
			
			if($_POST['p_amount']!='' && substr($_POST['p_amount'],0,1)==0){
			redirect("partners/partners/transferpoints/?pid=".$pid."&rid=51&msg=51");
			}

			$partnerfkid = $this->partner_model->getFKPartnerId($dpid);
			$partnerBalance = $this->partner_model->getmPartnerBalance($partnerfkid);

			$partnername = $this->partner_model->getPartnerNameById($dpid);
			$partnerstatus = $this->partner_model->getPStatus($dpid);
			if($partnerstatus!='1'){
			redirect("partners/partners/transferpoints/?pid=".$pid."&rid=51&msg=50");
			}


			if($_POST['adjust'] == "Add")
			{
				if($partnerBalance>=$_POST['p_amount'] && $partnerfkid!=ADMIN_ID)
				{
				  $internal_ref_no='150'.$partnerfkid.date('d').date('m').date('y').date('H').date('i').date('s');
				  $this->partner_model->BalanceUpdate($partnerfkid,$_POST['p_amount'],$partnername,'cAgent','remove',"",$internal_ref_no);
				  $this->partner_model->BalanceUpdate($dpid,$_POST['p_amount'],$adminusername,'cAgent','add',"",$internal_ref_no);
				  redirect("partners/partners/transferpoints/?pid=".$pid."&rid=51&msg=6");
				 } elseif($partnerfkid==ADMIN_ID) {
				 	$internal_ref_no='150'.$pid.date('d').date('m').date('y').date('H').date('i').date('s');
					$this->partner_model->BalanceUpdate($dpid,$_POST['p_amount'],$adminusername,'cAgent','add',"",$internal_ref_no);
					 redirect("partners/partners/transferpoints/?pid=".$pid."&rid=51&msg=6");
			     } else {
					redirect("partners/partners/transferpoints/?pid=".$pid."&rid=51&msg=7");
			     }
			}
		}
		$data['username'] = $this->partner_model->getPartnerNameById($dpid);
		$data['points'] = $this->partner_model->getmPartnerBalance($dpid);
		$data['pid'] = $dpid;
		$this->load->view('partners/transferpoints',$data,false,true);
	}

	public function showUserBalance(){  //Advetiser Balance Fetching
			$htmlString='';
			@$partnerInfoId = $this->partner_model->getPartnerIdByName($_GET['p_name']);
			@$partnerBalance = $this->partner_model->getmPartnerBalance($partnerInfoId);
			if(isset($partnerInfoId))
			echo $htmlString .= '<b>Balance:'.$partnerBalance.'</b>';
			else
			echo '<b>Username not exists</b>';
			die;
		}

	public function showBalance(){  //Advetiser Balance Fetching
			$htmlString='';
			@$userId = $this->partner_model->getUserIdByName($_GET['p_name']);
			@$userBalance = $this->partner_model->getUserBalance($userId);
			if(isset($userId))
			echo $htmlString .= '<b>Balance:'.$userBalance.'</b>';
			else
			echo '<b>Username not exists</b>';
			die;
		}

    public function fnTransferPointsAll($userId){
		if(isset($_REQUEST['name']) && $_REQUEST['name']!=''){
			//echo $userId; die;
			$data['userName']=$_REQUEST['name'];
			$data['userId']=$userId;
		}

		$adminusername = $this->session->userdata['adminusername'];
		if(isset($_POST['submit']) && $_POST['p_name'])	{
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Transfer Points";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			//$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST));
			$arrTraking["CUSTOM2"]      =1;
			//$this->db->insert("tracking",$arrTraking);
			/** tracking info end */
			
			$session_data=$this->session->all_userdata();			
			$current_user_session_id=$this->input->post('current_user_session_id');
			if($current_user_session_id!=$session_data['session_id']) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
				$this->db->insert("tracking",$arrTraking);
		 		$this->session->set_flashdata('message', 'Please try again.');
				redirect("partners/partners/index?rid=51");
			}
					
			$pid = $this->partner_model->getPartnerIdByUsername($_POST['p_name']);
			$userid= $this->partner_model->getUserIdByName($_POST['p_name']);
			if($_POST['p_name']!='') {
				$name=base64_encode($_POST['p_name']);
				$qvar="&name=".$name;
			}else{
				$qvar="";
			}
			$userstatus = $this->partner_model->getUStatus($userid);
			if($userstatus!='1'){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Account is deactivated. You cannot transfer the points'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/fnTransferPointsAll/".$userid."?rid=52&msg=50".$qvar);
			}

			if($_POST['p_amount']!='' && substr($_POST['p_amount'],0,1)==0){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points should be greater than zero'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/fnTransferPointsAll/".$userid."?rid=52&msg=51".$qvar);
			}

			if(isset($pid)){
				$partnerfkid = $this->partner_model->getFKPartnerId($pid);
				$partnerBalance = $this->partner_model->getmPartnerBalance($pid);

				$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
				$loggedin_partnerid=array();

				if(strstr($loggedin_partnerid,",")){
					$loggedin_partnerid=explode(",",$loggedin_partnerid);
				}else{
					$loggedin_partnerid=$loggedin_partnerid;
				}

				if($partnerBalance>=$_POST['p_amount'])
				{
					/* BELOW IS THE CODE FOR KHELO API - TRANSFER POINTS TO USER */
					/*
					$ireference=rand(1000000000,9999999999);
			 		$this->db->trans_begin();
					$transactionStatusId = "107";
					$transactionTypeId="21";
					$balanceTypeId="2";

					$sql_agntbal=$this->db->query("select AMOUNT from partners_balance where PARTNER_ID='".$pid."'");
					$row_agntbal=$sql_agntbal->row();

					$newagntbal=$row_agntbal->AMOUNT;
					$newagntclosebal=$row_agntbal->AMOUNT-$_POST['p_amount'];

                    $subtractmbaltrans="insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,INTERNAL_REFERENCE_NO,".
									   "CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,USER_ID,PROCESSED_BY)values('".$pid."',".
									   "'8','103','".$_POST['p_amount']."','".$ireference."','".$newagntbal."','".$newagntclosebal."',now(),".
									   "'".$userid."','".$this->session->userdata['partnerusername']."')";
					$query_pt=$this->db->query($subtractmbaltrans);

					$query_ad=$this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`FK_PARTNER_ID` ,`FK_TRANSACTION_TYPE_ID` ,".
											   "`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION`,".
											   "`ADJUSTMENT_COMMENT`)VALUES(NULL,'".$pid."','8','$ireference','".$_POST['p_name']."',NOW(),".
											   "'".$_POST['p_amount']."','Add','test')");
					$query_pt2=$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,".
												"INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,PROCESSED_BY".
												")values('".$pid."','8','103','".$_POST['p_amount']."','".$ireference."','".$newagntbal."',".
												"'".$newagntclosebal."',now(),'".$this->session->userdata['partnerusername']."')");
					$query_p=$this->db->query("update partners_balance set AMOUNT=AMOUNT-".$_POST['p_amount']." where PARTNER_ID=".$pid."");
					*/
					/* BELOW IS THE CODE FOR KHELO API - TRANSFER POINTS TO USER */

					$session_id=$this->session->userdata('session_id');
					$request1='{"action":"balanceSessionAction","sessionid":"'.$session_id.'"}';
					$URL = BALANCE_UPDATE_API."?xmlString=$request1";
					$ch1 = curl_init($URL);
					curl_setopt($ch1, CURLOPT_MUTE, 1);
					curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch1, CURLOPT_POST, 1);
					curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
					curl_setopt($ch1, CURLOPT_POSTFIELDS, $request1);
					curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
					$response1 = curl_exec($ch1);
					curl_close($ch1);
					$dresponse1=json_decode(trim($response1),true);
					
					if($dresponse1['action']!="error"){
						if($dresponse1['action']=='balanceSessionAction' && $dresponse1['sessionid']==$session_id){
							$transactionid=$dresponse1['transactionid'];
							$ireference='151'.$userid.date('d').date('m').date('y').date('H').date('i').date('s');

							$transactionStatusId = 130;
							$transactionTypeId=22;
							$balanceTypeId=1;
							$cointypeid=1;
							$partnertransactionStatusId = 131;
							$partnertransactionTypeId = 22;

							 $request2=urlencode('{"action":"balupdatereqconf","sessionid":"'.$session_id.'","transactionid":"'.$transactionid.'","userid":"'.$userid.'","amount":'.$_POST['p_amount'].',"type":"add","username":"'.$_POST['p_name'].'","transactionstatusId":"'.$transactionStatusId.'","transactiontypeid":"'.$transactionTypeId.'","balancetypeid":"'.$balanceTypeId.'","ireferno":"'.$ireference.'","partnerid":"'.$pid.'","partnerusername":"'.$this->session->userdata['partnerusername'].'","ptranStatusId":"'.$partnertransactionStatusId.'","ptranTypeId":"'.$partnertransactionTypeId.'","logParId":"'.$this->session->userdata['partnerid'].'","comment":"","cointypeid":"'.$cointypeid.'"}');

							 $URL2 = BALANCE_UPDATE_API."?xmlString=$request2";
							 $ch2 = curl_init($URL2);
							 curl_setopt($ch2, CURLOPT_MUTE, 1);
							 curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
							 curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
							 curl_setopt($ch2, CURLOPT_POST, 1);
							 curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
							 curl_setopt($ch2, CURLOPT_POSTFIELDS, $request2);
							 curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
							 $response2 = curl_exec($ch2);
							 curl_close($ch2);
							 $dresponse2=json_decode(trim($response2),true);
							 $userid1=$dresponse2['userid'];
							 $statusupdate=$dresponse2['status'];

							 if($dresponse2['action']=='balupdateresconf' && $dresponse2['sessionid']==$session_id &&  $userid==$userid1 && $statusupdate=="true"){
								$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points transfered successfully'));
								$this->db->insert("tracking",$arrTraking);								 
								redirect("partners/partners/fnTransferPointsAll/".base64_encode($userid)."?rid=52&msg=6".$qvar);
							 }else{
								$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
								$this->db->insert("tracking",$arrTraking);
							   redirect("partners/partners/fnTransferPointsAll/".base64_encode($userid)."?rid=52&msg=8".$qvar);
							 }
						}else{
							$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
							$this->db->insert("tracking",$arrTraking);
						  redirect("partners/partners/fnTransferPointsAll/".base64_encode($userid)."?rid=52&msg=8".$qvar);
						}
					}else{
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
						$this->db->insert("tracking",$arrTraking);
					  redirect("partners/partners/fnTransferPointsAll/".base64_encode($userid)."?rid=52&msg=8".$qvar);
					}
			   }else{
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points exceeds agents available balance'));
					$this->db->insert("tracking",$arrTraking);
			   		redirect("partners/partners/fnTransferPointsAll/".base64_encode($userid)."?rid=52&msg=7".$qvar);
			   }

		}
		else{
			$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Username not exists'));
			$this->db->insert("tracking",$arrTraking);
			redirect("partners/partners/fnTransferPointsAll/".base64_encode($userid)."?rid=52&msg=9".$qvar);
		}
	  }
	  	if(isset($data))
			$dataSend=$data;
		else
			$dataSend='';
		$this->load->view('partners/transferpointsall',$dataSend,false,true);
	}

	public function transferPointsAll($userId=''){

 
		if($_POST['partnertransaction_password']!=''){

			$checktransExist = $this->partner_model->checkTransPassExist();
			if($checktransExist==1){
				$checktransPass = $this->partner_model->checkTransPass(md5($_POST['partnertransaction_password']));
				if($checktransPass==2){
					redirect("partners/index?start=1&rid=51&errmsg=404");
				}
			}
		}else{
		 	 $sessionTransPass = $this->session->userdata['partnertransaction_password'];
			 if($sessionTransPass != ''){
		   	 	redirect("partners/index?start=1&rid=51&errmsg=404");
			 }
		}


		if(isset($_GET['name']) && $_GET['name']!='')
		{

			$data['userName']=$_GET['name'];
			$data['userId']=$userId;
		}

		$adminusername = $this->session->userdata['adminusername'];
		if(isset($_POST['submit']) && $_POST['p_name'])	{
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Transfer Points";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			//$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST));
			$arrTraking["CUSTOM2"]      =1;
			//$this->db->insert("tracking",$arrTraking);
			/** tracking info end */
			
			$pid = $this->partner_model->getPartnerIdByUsername($_POST['p_name']);
			$userid= $this->partner_model->getUserIdByName($_POST['p_name']);
			if($_POST['p_name']!='') {
				$name=base64_encode($_POST['p_name']);
				$qvar="&name=".$name;
			}else{
				$qvar="";
			}
			$userstatus = $this->partner_model->getUStatus($userid);
			if($userstatus!='1'){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Account is deactivated. You cannot transfer the points'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/transferPointsAll/".$userid."?rid=52&msg=50".$qvar);
			}

			if($_POST['p_amount']!='' && substr($_POST['p_amount'],0,1)==0){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points should be greater than zero'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/transferPointsAll/".$userid."?rid=52&msg=51".$qvar);
			}

			if(isset($pid)){
				$partnerfkid = $this->partner_model->getFKPartnerId($pid);
				$partnerBalance = $this->partner_model->getmPartnerBalance($pid);

				$loggedin_partnerid=$this->partner_model->loggedinPartnerIDs();
				$loggedin_partnerid=array();

				
				if(strstr($loggedin_partnerid,",")){
					$loggedin_partnerid=explode(",",$loggedin_partnerid);
				}else{
					$loggedin_partnerid=$loggedin_partnerid;
				}

				if($partnerBalance>=$_POST['p_amount'])
				{
					$session_id=$this->session->userdata('session_id');
					$request1='{"action":"balanceSessionAction","sessionid":"'.$session_id.'"}';
					$URL = BALANCE_UPDATE_API."?xmlString=$request1";

					$ch1 = curl_init($URL);
					curl_setopt($ch1, CURLOPT_MUTE, 1);
					curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch1, CURLOPT_POST, 1);
					curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
					curl_setopt($ch1, CURLOPT_POSTFIELDS, $request1);
					curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
					$response1 = curl_exec($ch1);
					curl_close($ch1);
					$dresponse1=json_decode(trim($response1),true);

					if($dresponse1['action']!="error"){
						if($dresponse1['action']=='balanceSessionAction' && $dresponse1['sessionid']==$session_id){
							$transactionid=$dresponse1['transactionid'];
							$ireference='151'.$userid.date('d').date('m').date('y').date('H').date('i').date('s');

							$transactionStatusId = 130;
							$transactionTypeId=22;
							$balanceTypeId=1;
						    $cointypeid=1;
							$partnertransactionStatusId = 131;
							$partnertransactionTypeId = 22;


							 $request2=urlencode('{"action":"balupdatereqconf","sessionid":"'.$session_id.'","transactionid":"'.$transactionid.'","userid":"'.$userid.'","amount":'.$_POST['p_amount'].',"type":"add","username":"'.$_POST['p_name'].'","transactionstatusId":"'.$transactionStatusId.'","transactiontypeid":"'.$transactionTypeId.'","balancetypeid":"'.$balanceTypeId.'","ireferno":"'.$ireference.'","partnerid":"'.$pid.'","partnerusername":"'.$this->session->userdata['partnerusername'].'","ptranStatusId":"'.$partnertransactionStatusId.'","ptranTypeId":"'.$partnertransactionTypeId.'","logParId":"'.$this->session->userdata['partnerid'].'","comment":"","cointypeid":"'.$cointypeid.'"}');

							 $URL2 = BALANCE_UPDATE_API."?xmlString=$request2";
							 $ch2 = curl_init($URL2);
							 curl_setopt($ch2, CURLOPT_MUTE, 1);
							 curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
							 curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
							 curl_setopt($ch2, CURLOPT_POST, 1);
							 curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
							 curl_setopt($ch2, CURLOPT_POSTFIELDS, $request2);
							 curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
							 $response2 = curl_exec($ch2);
							 curl_close($ch2);
							 $dresponse2=json_decode(trim($response2),true);
							 $userid1=$dresponse2['userid'];
							 $statusupdate=$dresponse2['status'];


							 if($dresponse2['action']=='balupdateresconf' && $dresponse2['sessionid']==$session_id &&  $userid==$userid1 && $statusupdate=="true"){
								$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points transfered successfully'));
								$this->db->insert("tracking",$arrTraking);
								redirect("partners/partners/transferPointsAll/".base64_encode($userid)."?rid=52&msg=6".$qvar);
							 }else{
								$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
								$this->db->insert("tracking",$arrTraking);
							   redirect("partners/partners/transferPointsAll/".base64_encode($userid)."?rid=52&msg=8".$qvar);
							 }
						}else{
							$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
							$this->db->insert("tracking",$arrTraking);
							redirect("partners/partners/transferPointsAll/".base64_encode($userid)."?rid=52&msg=8".$qvar);
						}
					}else{
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
						$this->db->insert("tracking",$arrTraking);
						redirect("partners/partners/transferPointsAll/".base64_encode($userid)."?rid=52&msg=8".$qvar);
					}
			   }else{
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Points exceeds agents available balance'));
					$this->db->insert("tracking",$arrTraking);
					redirect("partners/partners/transferPointsAll/".base64_encode($userid)."?rid=52&msg=7".$qvar);
			   }
			}else{
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Username not exists'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/partners/transferPointsAll/".base64_encode($userid)."?rid=52&msg=9".$qvar);
			}
		}
	  	if(isset($data))
			$dataSend=$data;
		else
			$dataSend='';
		$this->load->view('partners/transferpointsall',$dataSend,false,true);
	}



	public function details($userId) {
    $session_data=$this->session->all_userdata();
    $deUserId = base64_decode($userId);
    if($session_data['partnerid']!=ADMIN_ID){
      $loggedin_partnerids=$this->partner_model->loggedinPartnerIDs();
      $loggedin_partnerid =  implode(",",$loggedin_partnerids);
      $getLoggedinPartnerUserIds=$this->partner_model->getLoggedinPartnerUserIds($loggedin_partnerids);
      if(!in_array($deUserId, $getLoggedinPartnerUserIds))
        {
        redirect("partners/index?rid=51&errmsg=407&start=1");
        }
      }

	   if(isset($userId) && $userId!=""){
			$data['userDetails'] = $this->partner_model->viewUserInfo($deUserId);
		}
		$this->load->view('partners/details',$data,false,true);
    }

	public function updatepwd($userId) {
	   if(isset($_POST['frmSubmit']) && $_POST['USER_ID']!=""){
		   $arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			/** tracking info */
			$arrTraking["ACTION_NAME"]  ="Update Password";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$_REQUEST["u_password"]= md5($_REQUEST["u_password"]);
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["CUSTOM2"]      =1;
			/** tracking info end */
			
			$loggedin_partnerids=$this->partner_model->loggedinPartnerIDs();
			$loggedin_partnerid =  implode(",",$loggedin_partnerids);
			$getLoggedinPartnerUserIds=$this->partner_model->getLoggedinPartnerUserIds($loggedin_partnerids);

			if(!in_array($_POST['USER_ID'], $getLoggedinPartnerUserIds)){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'Message'=>'User Dont have permission'));
				$this->db->insert("tracking",$arrTraking);
				redirect("partners/index?rid=51&errmsg=407&start=1");
			}
			
			
	   		$datapass['USER_ID'] = $_POST['USER_ID'];
			if($_POST['u_password'] != "digient" && $_POST['USER_ID']!=""){
				$decrypted_pass =base64_decode($_POST['password_hidden']);
				$datapass["PASSWORD"]   = md5($decrypted_pass);
				$datapass["ORI_PASSWORD"]   = $_POST['u_password'];

				$partnerChangepas = $this->partner_model->updatepwd($datapass);
			}

			if($partnerChangepas==1) {
				/** tracking info */
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'Message'=>'Password updated'));
				$this->db->insert("tracking",$arrTraking);
				/** tracking info end */
				redirect("partners/partners/details/".base64_encode($_POST['USER_ID'])."?msg=11&rid=51");
				die;
			} else {
				/** tracking info */
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'Message'=>'Password not updated'));
				$this->db->insert("tracking",$arrTraking);
				/** tracking info end */

				redirect("partners/partners/details/".base64_encode($_POST['USER_ID'])."?rid=51");
				die;
		   }
		}
		$this->load->view('partners/details',NULL,false,true);
    }

	public function createUser() {

		$this->load->library('encrypt');
		$key = 'secret-key-in-config';
		//echo '<pre>';print_r($_POST);exit;
		if(($this->input->post('frmSubmit')=='Create') && ($this->input->post('username'))!="" && ($this->input->post('password'))!="" && ($this->input->post('PARTNER_DISTRIBUTOR'))!="" && ($this->input->post('USERPARTNER_ID'))!="") {
			
			/** tracking info */
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Create User";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM2"]      =1;
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			/** tracking info end */
			
			$pnum = $this->partner_model->usernameAlreadyExist($this->input->post('username'));
			//$num = $this->partner_model->emailAlreadyExist($this->input->post('email'));
			
			if($pnum>0){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Username already exists'));
				$this->db->insert("tracking",$arrTraking);
				
				$this->session->set_flashdata('message', 'Username already exists!');
				redirect("partners/partners/createUser?rid=55");
			}

       		/*  if($num>0){
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Emailid already exists'));
				$this->db->insert("tracking",$arrTraking);
				
				$this->session->set_flashdata('message', 'Emailid already exists!');
				redirect("partners/partners/createUser?rid=55");
			} */
			

			if($this->input->post('amount')!=''){
				$cashcheck="/^[0-9]*$/";
				if(!preg_match($cashcheck,$this->input->post('amount'))){
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Enter Valid Points'));
					$this->db->insert("tracking",$arrTraking);
					$this->session->set_flashdata('message', 'Enter Valid Points!');
					redirect("partners/partners/createUser?rid=55");
				}
			}

			$decrypted_pass =base64_decode($_POST['password_hidden']);
			$data["USERNAME"]  = addslashes(trim($this->input->post('username')));
			$data["PASSWORD"]	= addslashes(trim(md5($decrypted_pass)));
			$plain_password = addslashes(trim($decrypted_pass));
			//$data["EMAIL_ID"]   = addslashes(trim($this->input->post('email')));
			$amount     		= addslashes(trim($this->input->post('amount')));
			$distributor  	    = addslashes(trim($this->input->post('PARTNER_DISTRIBUTOR')));
			$subagents  		= addslashes(trim($this->input->post('SUB_DISTRIBUTOR')));
			$agents  	        = addslashes(trim($this->input->post('USERPARTNER_ID')));
			$data["PARTNER_ID"] = addslashes(trim($this->input->post('USERPARTNER_ID')));
			$data["COUNTRY"]  	= addslashes(trim($this->input->post('PARTNER_COUNTRY')));
			$data["STATE"]  	= addslashes(trim($this->input->post('PARTNER_STATE')));
			$data["CITY"]       = addslashes(trim($this->input->post('city')));
			$data["STREET"]     = addslashes(trim($this->input->post('area')));
			$data["PRINTER"]    = addslashes(trim($this->input->post('printer')));
			$data["REGISTRATION_TIMESTAMP"]  = date('Y-m-d h:i:s');
			$data["ACCOUNT_STATUS"]  	= 1;
			$data["ONLINE_AGENT_STATUS"] = 1;

			$session_data=$this->session->all_userdata();			
			$current_user_session_id=$this->input->post('current_user_session_id');
			if($current_user_session_id!=$session_data['session_id']) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
				$this->db->insert("tracking",$arrTraking);
		 		$this->session->set_flashdata('message', 'Please try again.');
				redirect("partners/partners/createUser?rid=55");
			}

			/*if(isset($subagents) && $subagents != ''){
		   		$partner_id = $subagents;
			}else if(isset($agents) && $agents != ''){
				$partner_id = $agents;
			}else if(isset($distributor) && $distributor != ''){
				$partner_id = $distributor;
			}else if(isset($main_agent) && $main_agent != ''){
				$partner_id = $main_agent;
			}	*/
			
			
			$partnername=$session_data['partnerusername'];	
			
		    $addUserId = $this->partner_model->addPlayer($data,$amount,$plain_password,$partnername);
		   //Add User balance
			//$pBalanceInfo['USER_ID'] = $addUserId;
			//$pBalanceInfo['COIN_TYPE_ID'] = 1;
			//$pBalanceInfo['USER_DEPOSIT_BALANCE'] = 0;
			//$pBalanceInfo['VALUE'] = 0;
			//$pBalanceInfo['USER_TOT_BALANCE']=0;
			//$addUserBalanceInfo = $this->partner_model->addUserBalanceInfo($pBalanceInfo);
			//$userBalance = $this->partner_model->BalanceUpdate($addPartnerID,$this->input->post('amount'),$adminusername,'newUser','add',"");
		 if($addUserId ==1) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'User created successfully'));
				$this->db->insert("tracking",$arrTraking);
				$this->session->set_flashdata('message', 'User created successfully.');
				redirect("partners/partners/createUser?rid=55");
		 }elseif($addUserId==2) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Please try again'));
				$this->db->insert("tracking",$arrTraking);
		 		$this->session->set_flashdata('message', 'Please try again.');
				redirect("partners/partners/createUser?rid=55");
		 }elseif($addUserId==3) {
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Agent has insuffient balance'));
				$this->db->insert("tracking",$arrTraking);
		 		$this->session->set_flashdata('message', 'Agent has insuffient balance.');
				redirect("partners/partners/createUser?rid=55");
		 }
	}

		$this->load->view('partners/createuser');
	}

	public function showAgents() {
		$userid=addslashes($_GET['disid']);
		#check current agent's subagent
		$sel="";
		$sql_agent=$this->db2->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$userid."' and FK_PARTNER_TYPE_ID=14");
		$getSubDistributors = $this->db2->query("SELECT PARTNER_ID,PARTNER_USERNAME FROM partner WHERE FK_PARTNER_ID='".$userid."' AND FK_PARTNER_TYPE_ID=13 ORDER BY PARTNER_NAME ASC");
		if($sql_agent->num_rows()>0){
			$sel="<select id='USERPARTNER_ID'  name='USERPARTNER_ID' class='UDTxtField' tabindex='6'>";
			foreach($sql_agent->result() as $row_agent) { 
			$sel=$sel."<option value='".$row_agent->PARTNER_ID."'>".$row_agent->PARTNER_USERNAME."</option>";
			}
			 $sel=$sel."</select>&nbsp;<span class='mandatory'>*</span>";

			if(!empty($getSubDistributors)) {
				$subDistributor='<select name="SUB_DISTRIBUTOR" id="SUB_DISTRIBUTOR" class="UDTxtField" onchange="showSDAgents(this.value)">';
				$subDistributor.='<option value="999999">Select sub distributor</option>';
				foreach($getSubDistributors->result() as $subDistributors) { 
					$subDistributor.='<option value="'.$subDistributors->PARTNER_ID.'">'.$subDistributors->PARTNER_USERNAME.'</option>';
				}
				$subDistributor.='</select>';
			} else {
				$subDistributor='<select name="SUB_DISTRIBUTOR" id="SUB_DISTRIBUTOR" class="UDTxtField">';
				$subDistributor.='<option value="999999">Select sub distributor</option>';
				$subDistributor.='</select>';
			}
			echo $sel."-".$subDistributor;
			die;
		}else{
		   if(!empty($getSubDistributors)) {
				$subDistributor='<select name="SUB_DISTRIBUTOR" id="SUB_DISTRIBUTOR" class="UDTxtField" onchange="showSDAgents(this.value)">';
				$subDistributor.='<option value="999999">Select sub distributor</option>';
				foreach($getSubDistributors->result() as $subDistributors) { 
					$subDistributor.='<option value="'.$subDistributors->PARTNER_ID.'">'.$subDistributors->PARTNER_USERNAME.'</option>';
				}
				$subDistributor.='</select>';
			} else {
				$subDistributor='<select name="SUB_DISTRIBUTOR" id="SUB_DISTRIBUTOR" class="UDTxtField">';
				$subDistributor.='<option value="999999">Select sub distributor</option>';
				$subDistributor.='</select>';
			}
			$sel = "Agentnotexist";
			echo $sel."-".$subDistributor;
			die;
		}
	}
	
	public function showSupDistAgents() {
		$userid=addslashes($_GET['supdisid']);
		#check current agent's subagent
		$sel="";
		$getSubDistributors = $this->db2->query("SELECT PARTNER_ID,PARTNER_USERNAME FROM partner WHERE FK_PARTNER_ID='".$userid."' AND FK_PARTNER_TYPE_ID=12 ORDER BY PARTNER_NAME ASC");
			if(!empty($getSubDistributors)) {
				$subDistributor='<select name="PARTNER_DISTRIBUTOR" id="PARTNER_DISTRIBUTOR" class="UDTxtField" onchange="showagents(this.value)">';
				$subDistributor.='<option value="999999">Select distributor</option>';
				foreach($getSubDistributors->result() as $subDistributors) {
					$subDistributor.='<option value="'.$subDistributors->PARTNER_ID.'">'.$subDistributors->PARTNER_USERNAME.'</option>';
				}
				$subDistributor.='</select>';
			} else {
				$subDistributor='<select name="PARTNER_DISTRIBUTOR" id="PARTNER_DISTRIBUTOR" class="UDTxtField">';
				$subDistributor.='<option value="999999">Select distributor</option>';
				$subDistributor.='</select>';
			}
			$sel = "Agentnotexist";
			echo $sel."-".$subDistributor;
			die;
	}
	
	public function showSubDistAgents() {
		$userid=addslashes($_GET['sdisid']);
		#check current agent's subagent
		$sel="";
		$sql_agent=$this->db2->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$userid."' and FK_PARTNER_TYPE_ID=14");
		if($sql_agent->num_rows() > 0){
			$sel="<select id='USERPARTNER_ID'  name='USERPARTNER_ID' class='UDTxtField' tabindex='6'>";
			foreach($sql_agent->result() as $row_agent) { 
			$sel=$sel."<option value='".$row_agent->PARTNER_ID."'>".$row_agent->PARTNER_USERNAME."</option>";
			}
			$sel=$sel."</select>";
			echo $sel;
			die;
		}else{
			echo "Agentnotexist";
			die;
		}
	}

	public function chkUserExist() {
		$getUserExistence = $this->partner_model->usernameAlreadyExist($_GET['username']);
		if($getUserExistence==1)
			echo '"Username already exists"';
		else
			echo 'true';
		die;
	}

	public function chkUserEmailExist() {
		$getUserExistence = $this->partner_model->emailAlreadyExist($_GET['email']);
		if($getUserExistence==1)
			echo '"Email already exists"';
		else
			echo 'true';
		die;
	}
	
	
	public function editgame($partnerId) {
		$data = array();
		$pid = base64_decode($partnerId);
		if($session_data['partnerid']!=ADMIN_ID){
			$loggedin_partnerids=$this->partner_model->loggedinPartnerIDs();
			//$loggedin_partnerid =  implode(",",$loggedin_partnerids);
			//$getLoggedinPartnerUserIds=$this->partner_model->getLoggedinPartnerUserIds($loggedin_partnerids);
			
			if(!in_array($pid, $loggedin_partnerids)){
				redirect("partners/index?rid=51&errmsg=407&start=1");
			}
		}
		  
		if(isset($_POST['Submit'])) {
			/** tracking info */
			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]  ="Edit Game";
			$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
			$arrTraking["REFERRENCE_NO"]=uniqid();
			$arrTraking["STATUS"]       =1;
			$arrTraking["LOGIN_STATUS"] =1;
			$arrTraking["CUSTOM2"]      =1;
			/** tracking info end */
			
			$category     = $this->input->post('category');
			$gameIDs="";

			if(!empty($category)) {
				foreach($category as $catIndex=>$catIDs) {
						$gameIDs[]=$catIDs;
				}
			}

			if(!empty($gameIDs)) {
				$getMinigamesInfo=$this->partner_model->getMinigamesNamesInfo($gameIDs);
				$removeREVSahre=$this->partner_model->deleteGameRevenueShare($pid);
				$data=$this->partner_model->getPartnerDetails($pid);
				$defaultRevenue = (!empty($data[0]->PARTNER_REVENUE_SHARE)?$data[0]->PARTNER_REVENUE_SHARE:0);
	//			echo '<prE>';print_r($data[0]->PARTNER_REVENUE_SHARE);exit;
				if(!empty($getMinigamesInfo)) {
					foreach($getMinigamesInfo as $gIndex=>$gameInfo) {
						$reveshareInfo["PARTNER_ID"]        =$pid;
						$reveshareInfo["GAME_ID"]           =$gameInfo->MINIGAMES_NAME;
						$reveshareInfo["GAME_REVENUE_SHARE"]=$defaultRevenue;
						$addREVSahre=$this->partner_model->addGameRevenueShare($reveshareInfo);
					}
				
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'success'));
						$this->db->insert("tracking",$arrTraking);
					
				}else{
					$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'Minigames not availavle'));
					$this->db->insert("tracking",$arrTraking);
				}
			}else{
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>'GameID empty'));
				$this->db->insert("tracking",$arrTraking);
			}
		 }
		 
		 if(!empty($pid)){
			$assignedGameList =$this->partner_model->partnerMinigamesList($pid);
			if(!empty($assignedGameList)){
				foreach($assignedGameList as $list){
					$data['assignedGames'][] = $list->GAME_ID;
				}
			}
			
			$partnerList =$this->partner_model->getParentPartnerName($pid);
			if(!empty($partnerList)){
				foreach($partnerList as $part){
					$data['partnerName'] = $part->PARTNER_USERNAME;
					$data['roleName'] = $this->partner_model->getPartherTypeBasedName($part->FK_PARTNER_TYPE_ID);
					
				}
			}
			$data['pid']=$pid;
		}
		$category = $this->partner_model->getCategoryMiniGames();
		if(!empty($category)){
			foreach($category as $rs ) {
				$data['categoryInfo'][$rs["CATEGORY_NAME"]][] = array("MINIGAMES_NAME"=>$rs["MINIGAMES_NAME"],"MINIGAMES_ID"=>$rs["MINIGAMES_ID"],"DESCRIPTION"=>$rs["DESCRIPTION"]);
			}
		}
		
		 
		$this->load->view('partners/editgame',$data);
	}



	public function userlist(){
		// $partnerslist = $this->partner_model->loggedinPartnerIDs();
		// $partnerslist =implode(",",$partnerslist);
		// echo '<pre>';print_r($partnerslist);exit;
		
		//$status =$this->common_model->sessionStatus();
	}
	
	public function logtracking(){
		if( isset($_REQUEST['date']) ){
			$date = date('Y-m-d',strtotime($_REQUEST['date']));
			$data['tracking'] = $this->partner_model->getTrackingInfo( $date,$_REQUEST['action']);
			$this->load->view('partners/tracking',$data);
		}exit;
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
