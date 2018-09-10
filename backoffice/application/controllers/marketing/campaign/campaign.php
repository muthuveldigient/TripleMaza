<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaign extends CI_Controller {

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
		$this->load->library('table');
		$this->load->model('marketing/campaign/campaign_model');
		
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
		$data["page_title"]    = "List Campaign";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('searchData');
			//echo "<pre>";
			//print_r($this->session->userdata('searchData'));die;
		}
		if($this->input->post('frmSearch')) {
			$data["PROMO_CAMPAIGN_TYPE_ID"] = $this->input->post('campaigntype'); 
			$data["PROMO_CAMPAIGN_NAME"]    = $this->input->post('campaignname'); 
			$data["PROMO_CAMPAIGN_CODE"]    = $this->input->post('campaigncode'); 
			$data["PROMO_STATUS_ID"]        = $this->input->post('campaignstatus'); 
			$data["START_DATE_TIME"]        = $this->input->post('startdate'); 
			$data["END_DATE_TIME"]          = $this->input->post('enddate'); 
			$this->session->set_userdata(array('searchData'=>$data));
			$noOfRecords  = $this->campaign_model->getCampaignDataCount($data);			
		} else {
			$noOfRecords  = $this->campaign_model->getCampaignDataCount();			
		}
		/* Set the config parameters */
		$config['base_url']   = base_url()."marketing/campaign/index";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit'); 
		$config['cur_page']   = $this->uri->segment(4);
		$config['suffix']     = '?rid=37';
		
		if($this->uri->segment(5)) {
			$config['order_by']	  = $this->uri->segment(5);
			$config['sort_order'] = $this->uri->segment(6);
		} else {
			$config['order_by']	  = "PROMO_CAMPAIGN_ID";
			$config['sort_order'] = "asc";			
		}
		if($this->input->post('frmSearch')) {
			$data["campaign_info"] = $this->campaign_model->getCampainInfo($config,$data);	
			$data["searchResult"] = 1;	
		} else if($this->session->userdata('searchData')) {
			$data["campaign_info"] = $this->campaign_model->getCampainInfo($config,$data);
			$data["searchResult"] = 1;			
		} else {
			$data["searchResult"] = "";
			$data["campaign_info"] = $this->campaign_model->getCampainInfo($config);
		}
		
		
		
		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();
		
		$data["campaign_types"] = $this->campaign_model->getCampaignTypes();
		$data["campaign_status"]= $this->campaign_model->getCampaignStatus();						
		$this->load->view('marketing/campaign/index',$data);
	}
	
	public function addcampaign() {
		if($this->input->post('frmSubmit')) {
			$data["PROMO_CAMPAIGN_TYPE_ID"] = $this->input->post('campaigntype'); 
			$data["PARTNER_ID"] 			= $this->input->post('partnername'); 
			$data["PROMO_CAMPAIGN_NAME"]    = $this->input->post('campaignname'); 
			$data["PROMO_CAMPAIGN_CODE"]    = $this->input->post('campaigncode'); 
			$data["PROMO_CAMPAIGN_DESC"]    = $this->input->post('campaigndesc'); 												
			$data["PROMO_STATUS_ID"]        = $this->input->post('campaignstatus');
			$data["START_DATE_TIME"]        = date('Y-m-d',strtotime($this->input->post('startdate'))); 	
			$data["END_DATE_TIME"]          = date('Y-m-d',strtotime($this->input->post('enddate')));			 
			$data["COST"]        			= $this->input->post('cost'); 
			$data["TOTAL_USER_EXPECTED"]    = $this->input->post('expecteduser'); 
			$data["COST_PER_USER"]          = $this->input->post('costperuser'); 
			$data["EXP_USER_MIN"]        	= $this->input->post('expusermin'); 
			$data["EXP_USER_MAX"]        	= $this->input->post('expusermax'); 
			$data["CREATED_ON"]        		= date('Y-m-d'); 
			$data["STATUS"]        			= 1;
			$data["PROMO_CAMPAIGN_URL"]     = $this->input->post('campaignurl');	 															
			$rsResult = $this->campaign_model->addCampaign($data);
			unset($data);
			
			if(!empty($rsResult)) {
				$data["PROMO_CAMPAIGN_ID"]      = $rsResult;
				$data["PROMO_PAYMENT_TYPE_ID"]  = $this->input->post('paymenttype');				 				
				$data["PROMO_TYPE_ID"]        	= $this->input->post('promotype');
				$data["PROMO_MIN_VALUE"]        = $this->input->post('promominvalue');
				$data["PROMO_MAX_VALUE"]        = $this->input->post('promomaxvalue');
				$data["PROMO_VALUE1"]        	= $this->input->post('promovalue1');
				$data["PROMO_VALUE2"]        	= $this->input->post('promovalue2');
				$addCampaign = $this->campaign_model->addCampaignPromoRule($data);
				if(!empty($addCampaign)) {																					
					$this->session->set_flashdata('message', 'Capaign added successfully.');
					redirect("marketing/campaign/addcampaign?rid=36");	
				}
			} else {
				$this->session->set_flashdata('message', 'Capaign add failed.');
				redirect("marketing/campaign");				
			}
		} else {
			$data["page_title"]     = "Add Campaign";
			$data["campaign_types"] = $this->campaign_model->getCampaignTypes();
			$data["partner_names"]  = $this->campaign_model->getPartnerNames();
			$data["campaign_status"]= $this->campaign_model->getCampaignStatus();
			$this->load->view('marketing/campaign/addcampaign',$data);			
		}
	}
	
	public function viewCampaign($campaignID) {
		$viewCampaign = $this->campaign_model->viewCampaign($campaignID);	
	    //bulild HTML string
	   	$campaignViewData .= "<table style='padding-left: 10px;'>";
		$campaignViewData .= "<tr><td colspan='2'><b><u>Campaing Settings</u></b></td></tr>";
		$campaignViewData .= "<tr><td><b>Campaign Type</b> </td><td>: ".$viewCampaign[0]->PROMO_CAMPAIGN_TYPE."</td></tr>";
		$campaignViewData .= "<tr><td><b>Partner Name</b> </td><td>: ".$viewCampaign[0]->PARTNER_NAME."</td></tr>";
		$campaignViewData .= "<tr><td><b>Campaign Name</b> </td><td>: ".$viewCampaign[0]->PROMO_CAMPAIGN_NAME."</td></tr>";
		$campaignViewData .= "<tr><td><b>Campaign Code</b> </td><td>: ".$viewCampaign[0]->PROMO_CAMPAIGN_CODE."</td></tr>";
		$campaignViewData .= "<tr><td><b>Campaign URL</b> </td><td>: ".$viewCampaign[0]->PROMO_CAMPAIGN_URL."</td></tr>";
		if($viewCampaign[0]->PROMO_STATUS_ID==1)
			$campaignViewData .= "<tr><td><b>Campaign Stuats</b> </td><td>: Active</td></tr>";
		else
			$campaignViewData .= "<tr><td><b>Campaign Stuats</b> </td><td>: In Active</td></tr>";					
		$campaignViewData .= "<tr><td><b>Start Date</b> </td><td>: ".date('d-m-Y',strtotime($viewCampaign[0]->START_DATE_TIME))."</td></tr>";
		$campaignViewData .= "<tr><td><b>End Date</b> </td><td>: ".date('d-m-Y',strtotime($viewCampaign[0]->END_DATE_TIME))."</td></tr>";
		$campaignViewData .= "<tr><td colspan='2'>&nbsp;</td></tr>";		
		$campaignViewData .= "<tr><td colspan='2'><b><u>Payment & Rule Settings</u></b></td></tr>";		
		if($viewCampaign[0]->PROMO_PAYMENT_TYPE_ID==1)
			$campaignViewData .= "<tr><td><b>Payment Type</b> </td><td>: Fixed</td></tr>";
		else
			$campaignViewData .= "<tr><td><b>Payment Type</b> </td><td>: Percentage (%)</td></tr>";		
		if($viewCampaign[0]->PROMO_TYPE_ID==1)
			$campaignViewData .= "<tr><td><b>Promo Type</b> </td><td>: CHIPS</td></tr>";
		else
			$campaignViewData .= "<tr><td><b>Promo Type</b> </td><td>: POINTS</td></tr>";		
			
		$campaignViewData .= "<tr><td><b>Promo Value1</b> </td><td>: ".$viewCampaign[0]->PROMO_VALUE1."</td></tr>";
		$campaignViewData .= "<tr><td colspan='2'>&nbsp;</td></tr>";		
		$campaignViewData .= "<tr><td colspan='2'><b><u>Cost & User Range Settings</u></b></td></tr>";				
		$campaignViewData .= "<tr><td><b>Exp User Min</b> </td><td>: ".$viewCampaign[0]->EXP_USER_MIN."</td></tr>";
		$campaignViewData .= "<tr><td><b>Exp User Max</b> </td><td>: ".$viewCampaign[0]->EXP_USER_MAX."</td></tr></table>";						
		echo $campaignViewData;die;
	}
	
	public function deleteCampaign($campaignID) {
		redirect('marketing/campaign/index');
	}
	
	public function getPaymentTypes($campaignID) {
		$data["campaignID"] = $campaignID;
		$this->load->view('marketing/campaign/getPaymentTypes',$data);	
	}
	
	public function getPromoTypes($paymentID) {
		$data["paymentID"] = $paymentID;
		$this->load->view('marketing/campaign/getPromoTypes',$data);			
	}
	
	public function getCampaignURL() {
		$campaignType = $this->uri->segment(5, 0);
		$campaignCode = $this->uri->segment(6, 0);
		if(empty($campaignCode)) { //Generate campaign code and campaign url
			if($campaignType == 1) {
					$txt = "PAY-";
				} elseif($campaignType == 2) {
					$txt = "REG-";
				} elseif($campaignType == 4) {
					$txt = "PROMO-REG-";
				} else {
					$txt = "TAF-";
				}           		
				$intRandom = rand(100000,999999);
				$gcampaignCODE = $txt.$intRandom;         

                if(strstr($gcampaignCODE,'PROMO-REG-')) {    
	                $campaignURL ="http://".$_SERVER['HTTP_HOST']."/qa/promo-register/cc/$gcampaignCODE";            
                } else {
	                $campaignURL ="http://".$_SERVER['HTTP_HOST']."/qa/register/cc/$gcampaignCODE";    
                }
				echo $gcampaignCODE.",".$campaignURL;die;
		} else { //Generate only the campaign url
			$campaignURL ="http://".$_SERVER['HTTP_HOST']."/qa/register/cc/$campaignCode";
			echo $campaignURL;die;
		}
	}
		
	public function changeCampaignStatus($curStatus, $campaignID, $newStatus) {
		$campaignData["PROMO_CAMPAIGN_ID"] = $campaignID;
		$campaignData["PROMO_STATUS_ID"]   = $newStatus;		
		$changeCampaignStatus = $this->campaign_model->changeCampaignStatus($campaignData);

		if($newStatus==1) {
			$campaignStatusValue = '<a href="#" onclick="javascript:activatedeaUser(1,'.$campaignID.',2)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a>';
		} else {
			$campaignStatusValue = '<a href="#" onclick="javascript:activatedeaUser(2,'.$campaignID.',1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a>';	
		}
		$campaignStatusValue = $campaignStatusValue."_".$campaignID;
		print_r($campaignStatusValue);die;		
	}
	
	
	/* BELOW ARE THE FUNCTIONS TO BE USED FROM THE SITE */	

	public function getCampaignIDTYPEonCampaignCode($campaignCODE) {
		$campaignIDTYPE = $this->campaign_model->getCampaignIDTYPE($campaignCODE);	
		echo "<pre>";
		print_r($campaignIDTYPE);die;
	}
	
	public function updateCampaignClicksCount($campaignID) {
		$rsResult = $this->campaign_model->updateCampaignClicksDataCount($campaignID);
	}
	
	public function validateCampaign($campaignID) {
		$getCampaignData = $this->campaign_model->chkCampaignStatus($campaignID);	
		$campaignStatusMessage="";
		$promoValue = $getCampaignData->COST_PER_USER;
		if($getCampaignData->STATUS!="") {
			$campaignStatusMessage = "There is no campaign available with the given code";
			return $campaignStatusMessage;
		}
		
		if($getCampaignData->START_DATE_TIME >= date('Y-m-d') && $getCampaignData->END_DATE_TIME <= date('Y-m-d')) {
			$campaignStatusMessage = "";
		} else {
			$campaignStatusMessage = "The given campaign code is expired already";
			return $campaignStatusMessage;
		}
			
		if(!empty($getCampaignData->EXP_USER_MAX)) {
			$getCampaignUsedCount = $this->campaign_model->getCampaignUsedCount($campaignID);	
			if($getCampaignUsedCount>=$getCampaignData->EXP_USER_MAX) {
				$campaignStatusMessage = "The maximum campaign usage is met already";
				return $campaignStatusMessage;
			}
		}
		if(empty($campaignStatusMessage)) {
			$campaignStatusMessage = "success";
		}
		//if campaign status is success, then add an entry in the user table with the $promoValue given(USER_SKILL_COINS) and an entry in the campaign_to_user
	}
	/* BELOW ARE THE FUNCTIONS TO BE USED FROM THE SITE */	
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */