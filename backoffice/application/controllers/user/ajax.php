<?php
//error_reporting(E_ALL);
/*
  Class Name	: Ajax
  Package Name  : User
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{
    
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
			$this->load->model('user/Account_model');	
			$this->load->model('reports/Withdrawal_model');
			$this->load->model('agent/Agent_model');	
			
			//player model
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		
		//if needed
	}//EO: index function
	
	
	public function agentlist(){
	    $str="";
		$formdata=$this->input->get();

		$data['agents']	=	$this->Account_model->getAllAgentsListByUserId($formdata['disid']);
		$str .='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="ListMenu" tabindex="6"><option value="">Select Agent</option>';
		if(!empty($data['agents'])){
			foreach($data['agents'] as $val){
				$str .='<option value="'.$val->PARTNER_ID.'">'.$val->PARTNER_USERNAME.'</option>';
			}
		}
		
		$str .='</select><span class="mandatory">*</span>';
		echo $str;
	
	}
	
	function wthInfo(){

	  $bankname = $_REQUEST['bankname'];
	  $cname = $_REQUEST['cname'];
	  $camount = $_REQUEST['camount'];
	  $acn = $_REQUEST['acn'];
	  $awb = $_REQUEST['awb'];
	  $charges = $_REQUEST['charges'];
	  
	  $trans_id = $_REQUEST['trans_id'];
	  $amount = $_REQUEST['amount'];
	  $acnt_number = $_REQUEST['acnt_number']; 
	  $user_acnt_number = $_REQUEST['user_acnt_number'];
	  $ifsc_code = $_REQUEST['ifsc_code'];
	  $branch = $_REQUEST['branch'];
	  
	  $date = $_REQUEST['date'];
	  $userId  = $_REQUEST['user_id'];
	  $withdraw_id  = $_REQUEST['withdraw_id'];
	  $reference_id = $_REQUEST['reference_id'];
	  $type = $_REQUEST['type'];

	  
	  if($type == 'Cheque'){
	  		$this->db->query("INSERT INTO `withdrawal_information` (`PAYMENT_TRANSACTION_ID` ,`INTERNAL_REFERENCE_NO` ,`TYPE` ,`BANK_NAME` ,`CHEQUE_NO` ,`CHEQUE_AMOUNT` ,`COMP_ACCOUNT_NO` ,`COURIER_NAME`,`AWB_NO`,`CHARGES`,`DATE`)VALUES ('$withdraw_id', '$reference_id', '$type', '$bankname', '$cname', $camount, '$acn','', '$awb','$charges','$date')");
	  }else{
	     	$this->db->query("INSERT INTO `withdrawal_information` (`PAYMENT_TRANSACTION_ID` ,`INTERNAL_REFERENCE_NO` ,`TYPE` ,`TRANSACTION_ID` ,`CHEQUE_AMOUNT` ,`COMP_ACCOUNT_NO` ,`USER_ACCOUNT_NO` ,`IFSC_CODE`,`BRANCH`,`DATE`)VALUES ('$withdraw_id', '$reference_id', '$type', '$trans_id', '$amount', $acnt_number, '$user_acnt_number','$ifsc_code', '$branch','$date')");
	  }
      //UPDTE IN PAYMENT_TRANSACTION
	  $this->db->query("UPDATE payment_transaction SET PAYMENT_TRANSACTION_STATUS=111 WHERE INTERNAL_REFERENCE_NO = '".$reference_id."' AND USER_ID='$userId'");
	  //UPDTE IN MASTER_TRANSACTION_HISTORY
	  $this->db->query("UPDATE master_transaction_history SET TRANSACTION_STATUS_ID=111 WHERE INTERNAL_REFERENCE_NO = '".$reference_id."' AND USER_ID='$userId'");
	  
	}
	
	function agents(){
	   $formdata=$this->input->get();
	   $user_id 	  	= $formdata['disid'];
	   $distributors	=	$this->Account_model->getAllAgentsListByUserId($user_id);
	   
	   $returnString   = '<span class="TextFieldHdr">Agents:</span><br /><label>';
	   $returnString  .= '<select name="AGENT" class="ListMenu" id="AGENT"  tabindex="5" onchange="showsubagents(this.value);">';
	   $returnString  .= '<option value="">Select Agents</option>';
	   foreach($distributors as $dis){
	      $returnString  .= '<option value="'.$dis->PARTNER_ID.'">'.$dis->PARTNER_USERNAME.'</option>';
	   }
	   $returnString  .= '</select>';
	   $returnString  .= '</label>';
	   
	   echo $returnString;
	}
	
	function subagentlist(){
		$formdata=$this->input->get();
	   $user_id 	  	= $formdata['disid'];
	   $distributors	=	$this->Account_model->getAllAgentsListByUserId($user_id);
	   
	   $returnString   = '<span class="TextFieldHdr">Subagents:</span><br /><label>';
	   $returnString  .= '<select name="SUB_AGENT" class="ListMenu" id="SUB_AGENT"  tabindex="4">';
	   $returnString  .= '<option value="">Select Sub Agent</option>';
	   foreach($distributors as $dis){
	      $returnString  .= '<option value="'.$dis->PARTNER_ID.'">'.$dis->PARTNER_USERNAME.'</option>';
	   }
	   $returnString  .= '</select>';
	   $returnString  .= '</label>';
	   
	   echo $returnString;	
	}
	
	function distributorlist(){
	   $formdata=$this->input->get();
	   $user_id 	  	= $formdata['disid'];
	   $distributors	= $this->Account_model->getAllAgentsListByUserId($user_id);
	   
	   $returnString   = '<span class="TextFieldHdr">Distributor:</span><br /><label>';
	   $returnString  .= '<select name="DISTRIBUTOR" class="ListMenu" id="DISTRIBUTOR"  tabindex="4" onchange="showagents(this.value);">';
	   $returnString  .= '<option value="">Select Distributor</option>';
	   foreach($distributors as $dis){
	      $returnString  .= '<option value="'.$dis->PARTNER_ID.'">'.$dis->PARTNER_USERNAME.'</option>';
	   }
	   $returnString  .= '</select>';
	   $returnString  .= '</label>';
	   
	   echo $returnString;
	}
	
	
	public function authendicate(){
		$user_id 	  = $this->uri->segment(4);
		$this->Account_model->authendicateUser($user_id);
		
	}
	
	
	public function deauthendicate(){
		$user_id 	  = $this->uri->segment(4);
		$desc = $this->uri->segment(5); 
		$this->Account_model->deauthendicateUser($user_id,$desc);
	}

	
	public function info(){
	   $user_id = $this->uri->segment(4);
	   $userInfo=	$this->Account_model->getUserInfoById($user_id);
        //echo "<pre>";print_r($userInfo);die;
           $fbid = $userInfo->FB_USER_ID;
	   $username = $userInfo->USERNAME;
	   $firstname = $userInfo->FIRSTNAME;
	   $lastname = $userInfo->LASTNAME;
           if($userInfo->DATE_OF_BIRTH != ""){
                $dob = date('d/m/Y H:i:s',strtotime($userInfo->DATE_OF_BIRTH));
           }else{
                $dob = "";
           }
	   $emailid = $userInfo->EMAIL_ID;
	   $locale = $userInfo->LOCALE;
	   $city = $userInfo->CITY;
	   $state = $userInfo->STATE;
	   $country = $userInfo->COUNTRY;
	   $registerdate =  date('d/m/Y H:i:s',strtotime($userInfo->REGISTRATION_TIMESTAMP));
	   $gender = $userInfo->GENDER;
	   $loginstatus = $userInfo->LOGIN_STATUS;
	   
	   //distributor name
	   $partnerName      = $this->Agent_model->getAgentNameById($userInfo->PARTNER_ID);
	   $distributorId    = $this->Agent_model->getDistributorIdByAgentId($userInfo->PARTNER_ID);
	   $distributorName  = $this->Agent_model->getDistributorNameById($distributorId);
	   //points
	   $userRealMoney    = $this->Account_model->getUserBalances($user_id,1);
       $userPlayMoney    = $this->Account_model->getUserBalances($user_id,2);
	   $userFppBalance   = $this->Account_model->getUserBalances($user_id,3);
	   $userBluffBalance = $this->Account_model->getUserBalances($user_id,4);
	   $userTokenBalance = $this->Account_model->getUserBalances($user_id,5);
	   $userVipChipBalance = $this->Account_model->getUserBalances($user_id,6);
	   $userLoyaltyBalance = $this->Account_model->getUserBalances($user_id,7);
	   
	    //bulild HTML string
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;height:400px'>";
	   $htmlString .= "<tr><b><u>General Info:</u></b></tr>";
           if($fbid != ""){ $htmlString .= "<tr><td><b>Fb Id:</b> </td><td>".$fbid."</tr>";}
	   $htmlString .= "<tr><td><b>User Name:</b> </td><td>".$username."</tr>";
	   $htmlString .= "<tr><td><b>First Name:</b> </td><td>".$firstname."</tr>";
	   $htmlString .= "<tr><td><b>Last Name:</b> </td><td>".$lastname."</tr>";
	   $htmlString .= "<tr><td><b>DOB:</b> </td><td>".$dob."</tr>";
	   $htmlString .= "<tr><td><b>Email Id:</b></td><td> ".$emailid."</tr>";
	   $htmlString .= "<tr><td><b>Locale:</b></td><td> ".$locale."</tr>";
	   $htmlString .= "<tr><td><b>City:</b> </td><td>".$city."</tr>";
	   $htmlString .= "<tr><td><b>State:</b></td><td> ".$state."</tr>";
	   $htmlString .= "<tr><td><b>Country:</b> </td><td>".$country."</tr>";
	   $htmlString .= "<tr><td><b>Register Date:</b> </td><td>".$registerdate."</tr>";
	   $htmlString .= "<tr><td><b>Gender:</b></td><td> ".$gender."</tr>";
	   $htmlString .= "<tr><td><b>Login Status:</b></td><td> ".$loginstatus."</tr>";
           $htmlString .= "<tr><td><b>Partner Name:</b> </td><td> ".$partnerName."</tr>";
	   $htmlString .= "<tr><td><b>Distributor Name:</b> </td><td>".$distributorName."</tr>";
	   $htmlString .= "</table><br />";
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>Real Money Information:</u></b></tr>";
	   $htmlString .= "<tr><td><b>Deposit Balance:</b></td><td>".$userRealMoney->USER_DEPOSIT_BALANCE."</td></tr>";
	   $htmlString .= "<tr><td><b>Promo Balance:</b></td><td>".$userRealMoney->USER_PROMO_BALANCE."</td></tr>";
	   $htmlString .= "<tr><td><b>Win Balance:</b></td><td>".$userRealMoney->USER_WIN_BALANCE."</td></tr>";
	   $htmlString .= "<tr><td><b>Total Balance:</b></td><td>".$userRealMoney->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table><br />";	
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>Play Money Information:</u></b></tr>";
	   //$htmlString .= "<tr><td><b>Deposit Balance:</b></td><td>".$userPointsInfo->USER_DEPOSIT_BALANCE."</td></tr>";
	   $htmlString .= "<tr><td><b>Promo Balance:</b></td><td>".$userPlayMoney->USER_PROMO_BALANCE."</td></tr>";
	   $htmlString .= "<tr><td><b>Win Balance:</b></td><td>".$userPlayMoney->USER_WIN_BALANCE."</td></tr>";
	   $htmlString .= "<tr><td><b>Total Balance:</b></td><td>".$userPlayMoney->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table><br />";	   
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>FPP Balance:</u></b></tr>";
	   $htmlString .= "<tr><td><b>Points:</b></td><td>".$userFppBalance->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table><br />";           
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>Bluff Balance:</u></b></tr>";
	   $htmlString .= "<tr><td><b>Points:</b></td><td>".$userBluffBalance->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table><br />";
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>Token Balance:</u></b></tr>";
	   $htmlString .= "<tr><td><b>Points:</b></td><td>".$userTokenBalance->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table><br />";
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>VIP Chips Balance:</u></b></tr>";
	   $htmlString .= "<tr><td><b>Points:</b></td><td>".$userVipChipBalance->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table><br />";
	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;'>";
	   $htmlString .= "<tr><b><u>Loyalty Balance:</u></b></tr>";
	   $htmlString .= "<tr><td><b>Points:</b></td><td>".$userLoyaltyBalance->USER_TOT_BALANCE."</td></tr>";
           $htmlString .= "</table>";		   		   		   
	   echo $htmlString;
	   exit;
	   
	}
	
	public function balance(){
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata);
		$currentuserid  = $_REQUEST['ptid'];
		//$currentuserid  = $this->Account_model->getUserIdByName($currentusername);
		//check current user is under agent subagent
		$checkUser  = $this->Account_model->checkUser($loggedInUsersPartnersId,$currentuserid);
		if($checkUser >0){
		   //get User balance
		   $userid  = $this->Account_model->getUserIdByName($currentuserid);
		   $userBalance  = $this->Account_model->getUserPoints($userid);
		   $balance      = $userBalance->USER_TOT_BALANCE;
		   //get Users Partner Id
		   $partnerId    = $this->Account_model->getUserPartnerId($userid);
		   //get partner name by id
		   $partnerName    = $this->Agent_model->getAgentNameById($partnerId);
		   //get partner balance by id                                
		   $partnerBalance    = $this->Agent_model->getPartnerBalance($partnerId);
                   $htmlString = '<div class="tableListWrap"><div class="data-list"><table id="list4" style="width:87%" class="data">';
		   $htmlString .= '<tr><td><img src="'.base_url().'static/images/userinfo.png">';
                   if($partnerId !=1)
                   {
		   $htmlString .= '<div style="padding:10px;"><span style="style1"><b>Balance:</b></span>'.$balance.'<br><span style=""style1""><b>Agent:</b></span>'.$partnerName.'<br /><span><b>Agent Balance:</b></span>'.$partnerBalance.'</div></td>';
                   }else{
                   $htmlString .= '<div style="padding:10px;"><span style="style1"><b>Balance:</b></span>'.$balance.'<br><span style=""style1""><b>Partner:</b></span>'.$partnerName.'<br /></div></td>';    
                   }
		   $htmlString .= '</tr></table></div></div>';
		   
		}else{
		   $htmlString = '<div class="tableListWrap"><div class="data-list"><table style="width:87%" id="list4" class="data"><tr><td><img src="'.base_url().'static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>User does not exist!</b></span></td></tr></table></div></div>';
		}
	
		echo $htmlString;
		exit;
	}
	
	
	public function balanceadjust(){
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata);
		//$userid  = $_REQUEST['ptid'];
		//$username  = $this->Account_model->getUserNameById($userid);
		$username  = $_REQUEST['ptid'];
		$userid = $this->Account_model->getUserIdByName($username);
		
		//check current user is under agent subagent
		$checkUser  = $this->Account_model->checkUser($loggedInUsersPartnersId,$username);
		if($checkUser >0){
		   //get User balance
		   $userBalance  = $this->Account_model->getUserPoints($userid);
		   $balance      = $userBalance->USER_TOT_BALANCE;
		   $depositBalance = $userBalance->USER_DEPOSIT_BALANCE;
		   $winBalance     = $userBalance->USER_WIN_BALANCE;
		   $promoBalance   = $userBalance->USER_PROMO_BALANCE;
		   $totBalance     = $userBalance->USER_TOT_BALANCE;
		   //get Users Partner Id
		   $partnerId    = $this->Account_model->getUserPartnerId($userid);
		   $userLoggedInStatus = $this->Account_model->userLoggedInStatus($userid);
		   //get partner name by id
		   $partnerName    = $this->Agent_model->getAgentNameById($partnerId);
		   //get partner balance by id
		   $partnerBalance    = $this->Agent_model->getPartnerBalance($partnerId);
		   $htmlString = '<div class="tableListWrap"><div class="data-list"><table id="list4" style="width:88%" class="data">';
		   $htmlString .= '<tr><td>';
                   /*if($partnerId !=1)
                   {    
		   $htmlString .= '<div style=""><span style="style1"><b>Balance:</b></span>'.$balance.'<br><span style=""style1""><b>Agent:</b></span>'.$partnerName.'<br /><span><b>Agent Balance:</b></span>'.$partnerBalance.'</div></td>';
                   }else{*/
                       $htmlString .= '<div style=""><span style="style1"><b>Promo Balance:</b></span><span id="promo_balance">'.$promoBalance.'</span><br><b>Deposit Balance:</b></span><span id="deposit_balance">'.$depositBalance.'</span><br><b>Win Balance:</b></span><span id="win_balance">'.$winBalance.'</span><br><b>Total Balance:</b></span>'.$balance.'<br><span style=""style1""><b>Partner:</b></span>'.$partnerName.'<br /><span id="userLoggedInStatus" style="display:none;">'.$userLoggedInStatus.'</span></div></td>';
                   //}
		   $htmlString .= '</tr></table></div></div>';
		   
		}else{
		   $htmlString = '<div class="tableListWrap"><div class="data-list"><table style="width:87%" id="list4" class="data"><tr><td><img src="'.base_url().'static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>User does not exist!</b></span></td></tr></table></div></div>';
		}
	
		echo $htmlString;
		exit;
	}
	
        public function refapprove(){
            $refno = $this->uri->segment(4);
            $amt = $this->uri->segment(5);
            $uid = $this->uri->segment(6);		
            if($refno != '' && $amt != '' && $uid != ''){
                $res = $this->Account_model->approveTransaction($refno,$amt,$uid);
                if($res == '1'){
                    echo "Done";
                    exit;
                }else{
                    echo "Failed";
                    exit;
                }
            }
        }
	
	public function active(){
		$userid = $this->uri->segment(4, 0);
		if($userid != ''){
		   $this->Account_model->activeUser($userid,1);
		}
		
		$this->Account_model->getActiveUser();
		
		echo "done"; exit;
		//redirect("user/account/search", $data);	
	}
	
	public function deactive(){
	  
	 	$userid = $this->uri->segment(4, 0);
	 
		if($userid != ''){
		   $this->Account_model->activeUser($userid,0);
		}
		//redirect("user/account/search", $data);	
		echo "done"; exit;
	
	}
	
	public function viewWithdrawInfo($withdrawID){
	
	    $master_id = $this->uri->segment(5, 0);
		$getWithdrawDetil = $this->Withdrawal_model->getWithdrawalInfo($withdrawID,$master_id);
	   
	    //bulild HTML string
/*	   $htmlString .= "<table style='padding-left: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;height:30px;width:300px;'>";
	   $htmlString .= "<tr><b><u>Withdrawal Info:</u></b></tr>";
	   
	   $htmlString .= "<tr><td><b>User Name:</b> </td><td>".$getWithdrawDetil[0]->USERNAME."</td><tr>";
	   $htmlString .= "<tr><td><b>Internal Reference No:</b> </td><td>".$getWithdrawDetil[0]->INTERNAL_REFERENCE_NO."</td></tr>";
	   $htmlString .= "<tr><td><b>Amount:</b> </td><td>".$getWithdrawDetil[0]->TRANSACTION_AMOUNT."</td></tr>";
	   
	   $htmlString .= "<tr><td><b>Status:</b> </td><td>".$getWithdrawDetil[0]->TRANSACTION_STATUS_DESCRIPTION."</td></tr>";
	   $htmlString .= "<tr><td><b>PAN:</b> </td><td>PAN</td></tr>";
	   $htmlString .= "<tr><td><b>Address Proof:</b> </td><td>ADDRESS PROOF</td></tr>";
	   
	   $htmlString .= "<tr><td><b>First Name:</b> </td><td>".$getWithdrawDetil[0]->USERNAME."</td></tr>";
	   $htmlString .= "<tr><td><b>Last Name:</b> </td><td>".$getWithdrawDetil[0]->LASTNAME."</td></tr>";
	   $htmlString .= "<tr><td><b>Bank Detail:</b> </td><td>BANKDETAIL</td></tr>";	   	   
	   
	   $htmlString .= "<tr><td><b>Payment Mode:</b> </td><td>Cheque</td></tr>";
	   $htmlString .= "<tr><td><b>Amount Paid:</b> </td><td>1000</td></tr>";	   
       $htmlString .= "</table>";	*/	
	   
	   $data['withdrawId']=$master_id;
	   $data['getWithdrawDetil']=$getWithdrawDetil;
	  	   
	   $this->load->view("reports/withdrawdetails",$data);
	     		   		   
	   
	}	
	
}
/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */