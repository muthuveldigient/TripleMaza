<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account
  Package Name  : User
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account extends CI_Controller{
    
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
			
			/*$USR_ID = $this->session->userdata['partnerusername'];
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
				
			/*if($USR_ID == ''){
					redirect('login');
			 }*/
	
			$this->load->model('agent/Agent_model'); 
			$this->load->model('user/Account_model');                
			$this->load->model('common/common_model');
			$this->load->model('partners/Partner_model');
			
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
	
	function view(){
	       
			$data['id']=base64_decode($this->uri->segment(4));
            $data['typ']=$this->input->get_post('typ',TRUE);
            $data['chk']=$this->input->get_post('chk',TRUE);
            $data['na']=$this->input->get_post('na',TRUE);
            $data['details']=$this->Account_Model->getUsersReport($data);
            $totalpages=$this->Account_Model->getTotalRecords($data);
            $config["base_url"]		= base_url()."admin_home/index/";
            $config['per_page']		= $this->config->item('limit');
            $config["uri_segment"] 	= 3;
            $config['total_rows']	= $totalpages;
			if($this->input->post()){
				$config['suffix'] ='';
			}else{
				$config['suffix'] ='';
			}
            $config['first_url'] = $config['base_url'].$config['suffix'];
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
	        $data['page']=$page;
            $data['result']=$this->Account_Model->getListUsers($config["per_page"],$page,$data);
            $data['links'] = $this->pagination->create_links();
            $this->load->view("user/view",$data);	// p=vusrs View Partner users list
	
	}
	
	function edit(){
		$userid = $this->uri->segment(4, 0);
		$formdata=$this->input->post(); // $_POST;
		//echo "<pre>";print_r($formdata);die;
		if($userid == "")
        {
	        redirect("user/account/search");
        }
        if($this->input->post('Submit',TRUE)){
			$updateGame = $this->Account_model->updateUser($userid,$formdata);
			//$updateBank = $this->Account_model->updateBankDetails($userid,$formdata);		
			$data['msg'] = $updateGame;
			//$data['msg1'] = $updateBank;
		}                
        $data['results'] = $this->Account_model->getUserInfoById($userid);
		//$data['bankDetails'] = $this->Account_model->get_user_BankDetails($userid);
        $this->load->view("user/edit",$data);	//  View Partner users list
	}
	

	function search($userDateRange,$userRepoType){ //$userDateRange-current or last month,$userRepoType-registration or depositor
		//get all the static pages
		if($this->input->get('start',TRUE) == 1 || $_POST['reset'] == 'Clear'){
		   $this->session->unset_userdata('searchUserData');
		}		
		if(isset($userDateRange) && isset($userRepoType)) {
			if($userDateRange=="cmonth") {
				$searchdata['START_DATE_TIME'] = date('Y-m-01')." 00:00:00";
				$searchdata['END_DATE_TIME']   = date('Y-m-d',strtotime("-1 days"))." 23:59:59";
			} else {
				$searchdata['START_DATE_TIME'] = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")))." 00:00:00";
				$searchdata['END_DATE_TIME']   = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")))." 23:59:59";					
			}
			
			if($userRepoType=="reg")
				$searchdata['USER_REPO_TYPE'] = "reg";
			else
				$searchdata['USER_REPO_TYPE'] = "depo";
			
			$this->session->set_userdata('searchUserData',$searchdata);				
		}

		//general configuration
		$this->load->library('pagination');
		$config['base_url']	 = base_url()."user/account/search";
		$config['per_page']  = $this->config->item('limit'); 
		$config['cur_page']  = $this->uri->segment(4);
		$config['suffix']    = '?rid=10';
		
		//get all the partner ids
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata);  

		if($this->input->get_post('keyword',TRUE)=="Search" || $this->session->userdata('searchUserData') != ''){		

				$searchdata['username'] = $this->input->get_post('username',TRUE);
            	$searchdata['email'] = $this->input->get_post('email',TRUE);
				if($this->input->get_post('country') == 'select'){
					$searchdata['country'] = '';
				}else{			
        	        $searchdata['country'] = $this->input->get_post('country',TRUE);
		   		}
                $searchdata['status'] = $this->input->get_post('status',TRUE);
				if(isset($userDateRange) && isset($userRepoType)) {
					$searchdata['START_DATE_TIME'] = $searchdata['START_DATE_TIME'];
					$searchdata['END_DATE_TIME']   = $searchdata['END_DATE_TIME'];					
				} else {
					$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
					$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
				}

				$searchdata['partner'] = $this->input->get_post('partner',TRUE);
				$searchdata['online'] = $this->input->get_post('online',TRUE);
				$totCount = $this->Account_model->getAllSearchPlayesCount($loggedInUsersPartnersId,$searchdata);
				
				$activeCount = $this->Account_model->getCountActiveUsers($loggedInUsersPartnersId,$searchdata);
				$inactiveCount = $this->Account_model->getCountInActiveUsers($loggedInUsersPartnersId,$searchdata);
				
				$config['total_rows'] 	= $totCount;		
				$this->session->set_userdata('searchUserData',$searchdata);
				$data['username']  		= $this->input->get_post('username',TRUE);
				$data['email']      	= $this->input->get_post('email',TRUE);
				$data['countryv']		= $this->input->get_post('country',TRUE);
				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);

				$data['partner']	= $this->input->get_post('partner',TRUE);
				$data['online']	= $this->input->get_post('online',TRUE);
				if(isset($userDateRange) && isset($userRepoType))
					$start = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
				else
	                $start = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
					
				$data['results']	=	$this->Account_model->getAllSearchPlayersInfo($loggedInUsersPartnersId,$searchdata,$config["per_page"],$start);
				$data['active_users'] = $activeCount;
				$data['inactive_users'] = $inactiveCount;
				$data['tot_users'] = $totCount;
				
                $this->pagination->initialize($config);	
				$data['pagination']   = $this->pagination->create_links('view');
		}else{
				
		}
				$data['agents']=$this->commonfunction->get_distributer($this->session->userdata);
				$this->load->view('user/viewplayers',$data);   
	}
	
	

	
	function register(){
		//unset unwanted sessions
		$this->Account_model->unsetUserSession();
		$formdata=$this->input->post();

		if(is_array($formdata) && count($formdata)>0){
		 //After submit
		 //for form re-populate
		 $this->Account_model->setUserSession($formdata);
		 $addUser = $this->Account_model->addUser($formdata,$this->session->userdata);	
		}
		
		$this->load->library('commonfunction');
		$parent_id  =  $this->session->userdata['partnerid'];
		$parentType  = $this->session->userdata['partnertypeid'];
		
		if($parentType == 0){
			$data['mainagent']  = $this->Partner_model->getAllPatrnerInfos($parent_id);
		}else if($parentType == 1){
			$data['distributor']  = $this->Partner_model->getAllPatrnerInfos($parent_id);
		}else if($parentType == 2){
			$data['agent']  = $this->Partner_model->getAllPatrnerInfos($parent_id);
		}else if($parentType == 3){
		   $data['subagent']  = $this->Partner_model->getAllPatrnerInfos($parent_id);
		}
		
		$data['fkpartnerid']=$this->commonfunction->get_fkpartner($this->session->userdata);
		$this->load->view("user/add",$data);	// p=cusr Add user
	 }
	 
	 
	function transfer(){
		//unset unwanted sessions
		$formdata=$this->input->post();
		if(is_array($formdata) && count($formdata)>0){
		 //After submit
		 //for form re-populate
		 $addUser = $this->Account_model->addPoints($formdata,$this->session->userdata);	
		}
		
		$this->load->view("user/transfer",$data);	// p=cusr Add user
	}
	

        public function detail(){
   		$userid = $this->uri->segment(4, 0);
		//get user information
		$data['results'] = $this->Account_model->getUserInfoById($userid);
	        $partner_id      = $this->Account_model->getUserPartnerId($userid);
		$data['partnerName']= $this->Agent_model->getAgentNameById($partner_id);
		//$disId	= $this->Agent_model->getDistributorIdByAgentId($partner_id);
		//$data['disName'] = $this->Agent_model->getDistributorNameById($disId);
		$userInfo = $this->Account_model->getUserPoints($userid);			
		$data['depositBalance'] = $userInfo->USER_DEPOSIT_BALANCE;
		$data['promoBalance'] = $userInfo->USER_PROMO_BALANCE;
		$data['winBalance'] = $userInfo->USER_WIN_BALANCE;	
		$data['totBalance'] = $userInfo->USER_TOT_BALANCE;
		
		$playMoneyInfo = $this->Account_model->getUserChips($userid);
		$data['playDepositBalance'] = $playMoneyInfo->USER_DEPOSIT_BALANCE;
		$data['playPromoBalance'] = $playMoneyInfo->USER_PROMO_BALANCE;
		$data['playWinBalance'] = $playMoneyInfo->USER_WIN_BALANCE;
		$data['playTotBalance'] = $playMoneyInfo->USER_TOT_BALANCE;
		
		$fppBonusInfo = $this->Account_model->getUserBalances($userid,3);
		$data['fppBonusPoints'] = $fppBonusInfo->USER_TOT_BALANCE;
		
		$bluffBonusInfo = $this->Account_model->getUserBalances($userid,4);
		$data['bluffBonusPoints'] = $bluffBonusInfo->USER_TOT_BALANCE;
		
		$tokenBonusInfo = $this->Account_model->getUserBalances($userid,5);
		$data['tokenBonusPoints'] = $tokenBonusInfo->USER_TOT_BALANCE;
		
		$vipChipsBonusInfo = $this->Account_model->getUserBalances($userid,6);
		$data['vipChipsBonusPoints'] = $vipChipsBonusInfo->USER_TOT_BALANCE;
		
		$LoyaltyBonusInfo = $this->Account_model->getUserBalances($userid,7);
		$data['loyaltyBonusPoints'] = $LoyaltyBonusInfo->USER_TOT_BALANCE;								
		
		$data['playpoint'] = $this->Account_model->get_user_playpoints($userid);			
		$data['winpoint'] = $this->Account_model->get_user_winpints($userid);		
		$data['margin']	 = $this->Account_model->get_user_margin($userid);
		
		$BankAccountDetails = $this->Account_model->get_user_BankDetails($userid);
		$data['BankDetailsCount'] = count($BankAccountDetails);
		$data['ActHdlrName']  =  $BankAccountDetails->ACCOUNT_HOLDER_NAME;
		$data['AccntNumber']  =  $BankAccountDetails->ACCOUNT_NUMBER;
		$data['MicrCode']  =  $BankAccountDetails->MICR_CODE;
		$data['IfscCode']  =  $BankAccountDetails->IFSC_CODE;
		$data['BankName']  =  $BankAccountDetails->BANK_NAME;
		$data['BranchName']  =  $BankAccountDetails->BRANCH_NAME;
		
		$pendingWithdrawalRequest = $this->Account_model->get_user_withdrawalCount($userid,10,109);
		$data['WithdrawalPending'] = $pendingWithdrawalRequest->cnt;
		
		$totalWithdrawalAmount = $this->Account_model->get_user_withdrawalDetails($userid,10,111);
		$data['TotalWithdrawal'] = $totalWithdrawalAmount->amount;		
		
		$totalDepositePending = $this->Account_model->get_user_withdrawalCount($userid,8,104);
		$data['DepositPending'] = $totalDepositePending->cnt;
		
		$UserIdType = $this->Account_model->get_user_IdType($userid);
		$data['UserIdType'] = $UserIdType;
		
		$UserIdProof = $this->Account_model->get_user_IdVerification($userid);
		$data['VerifyTypeId'] = $UserIdProof->VERIFICATION_TYPE_ID;
		$data['IdStatus'] = $UserIdProof->STATUS;

		$this->load->view("user/details",$data);
        }	
	
        public function adjust(){
		//unset unwanted sessions
		$formdata=$this->input->post();
		if(is_array($formdata) && count($formdata)>0){
		 //After submit
		 //for form re-populate
		 $addUser = $this->Account_model->adjustPoints($formdata,$this->session->userdata);	
		}

		$formdata['balanceTypes'] = $this->common_model->getBalanceType();
		$partnerIds  = $this->Agent_model->getAllChildIds($this->session->userdata); 
		$formdata['users'] = $this->Account_model->getAllUsersByPartnerIds($partnerIds);
                if($this->input->get_post('submit',TRUE)=="Create"){
						$formdata['USER_ID']         = $this->input->get_post('USER_ID',TRUE);
                        $formdata['BALANCE_TYPE']    = $this->input->get_post('BALANCE_TYPE',TRUE);
						$formdata['ADJUST_TYPE']     = $this->input->get_post('ADJUST_TYPE',TRUE);
                        $formdata['CASH']  			 = $this->input->get_post('CASH',TRUE);
                        $formdata['COMMENTS']        = $this->input->get_post('COMMENTS',TRUE); 
                        $formdata['results']         = $this->Account_model->adjustPoints($formdata,$this->session->userdata);
                }
		$this->load->view("user/adjust",$formdata);	// p=cusr Add user
	}
	
	public function active(){
		$userid = $this->uri->segment(4, 0);
		if($userid != ''){
		   $this->Account_model->activeUser($userid,1);
		}
		redirect("user/account/search", $data);	
	}
	
	public function deactive(){
	  
	 	$userid = $this->uri->segment(4, 0);
		if($userid != ''){
		   $this->Account_model->activeUser($userid,0);
		}
		redirect("user/account/search", $data);	
	
	}
        
        public function activateKey()
        {
            echo $uri = $this->uri->segment(4, 0);
            exit;
            $key = substr($uri, 0, 12);
            $length = strlen($uri);
            
            $len = $length - 12;
            
            $num = 12 + $len;
            $userid  = substr($uri,12,$num);
            
           $this->Account_model->keyActivate($key,$userid);
 
           $this->load->view("user/active");

        }        
	
	
	public function verification(){
		$userid = $this->uri->segment(4, 0); 
		$partner_id = $this->session->userdata('partnerid');
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			
			$data["username"] = $this->input->post('username'); 
			$data["type"]    = $this->input->post('type'); 
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['userid'] = $user_id;
				}else{
				  $data['userid'] = "007";
				}
			}else{
			    $data['userid'] = '';
			}
	
			$data['results'] = $this->Account_model->getUserVerificationInfo($data);			
		} elseif($_REQUEST['key']=="Search") {
			$data['username'] = $_REQUEST['uname'];
			$data['type'] = $_REQUEST['type'];
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['userid'] = $user_id;
				}else{
				  $data['userid'] = "007";
				}
			}else{
			    $data['userid'] = '';
			}
			$data['results'] = $this->Account_model->getUserVerificationInfo($data);						
		} else {
			if($userid != ''){
			    $data["userid"]    = $userid; 
				$data['results'] = $this->Account_model->getUserVerificationInfo($data);
	   		 }
		}
		
		$data['USERNAME'] = $this->input->post('username'); 
		$data['TYPE'] = $this->input->post('type'); 
		
		$data['USER_ID'] = $userid;
		$data['USER_NAME'] = $this->Account_model->getUserNameById($userid);
		$data['verificationTypes'] = $this->Account_model->getAllVerificationTypes();
		$data['childUsers'] = $this->Account_model->getAllUsersByPartnerIds($partner_id);		
		
		$this->load->view("user/verification",$data);
	}
	
	public function addverification(){
	   //prepare insert data
	    $formdata=$this->input->post();
		if(is_array($formdata) && count($formdata)>0){
			
			$addUser = $this->Account_model->addUserVerification($formdata,$this->session->userdata);	
            if($addUser){
			 redirect("user/account/verification?rid=32&uname=".$formdata[uname]."&type=".$formdata[type]."&key=".$formdata[key]."&msg=".'Success'."");	
			}
		}
	  
	}
        
	public function approveverification($uid,$approve,$desc,$verifyid){
            $formdata['userid'] = $uid;
            $formdata['approve'] = $approve;
            $formdata['desc_reason'] = $desc;
			$formdata['verify_id'] = $verifyid;

		if(is_array($formdata) && count($formdata)>0){
			$addUser = $this->Account_model->verifyProof($formdata);	
                if($addUser){ 
				  if($approve == 0)
				   $returnString  = '<font color="red">Rejected</font>';
				  else
				   $returnString  = '<font color="Green">Approved</font>';
				}
		}else{
		   $returnString  = 'empty';
		}
        
		echo $returnString; die;
	  
	}        
	
}

/* End of file distributor.php */
/* Location: ./application/controllers/agent/distributor.php */