<?php
/*
  Class Name	: Agent_turnover
  Package Name  : Report
  Purpose       : Controller all the Turnover releated details
  Auther 	    : Sivakumar
  Date of create: July 08 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Turnover_report extends CI_Controller{
    
        function __construct(){
            parent::__construct();
			$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
            $this->load->helper(array('url','form','functions'));	
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');
			//player model
			
			$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			//$USR_STATUS = $_SESSION['partnerstatus'];
			$USR_STATUS = "2";
			$USR_PAR_ID = $this->session->userdata['partnerid'];
			//$USR_GRP_ID = $this->session->userdata['groupid'];

			if($USR_STATUS!=1){
				//$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
				$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
				$CBY = $USR_PAR_ID;
			}else{
				//$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
				$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
				$CBY = 1;
			}
			
			 $userdata['USR_ID']=$USR_ID;
			// $userdata['USR_GRP_ID']=$USR_GRP_ID;
			 $userdata['USR_STATUS']=$USR_STATUS;
			 $searchdata['rdoSearch']='';
				
			if($USR_ID == ''){
					redirect('login');
			}
	
			$this->load->model('common/common_model');
			$this->load->model('reports/turnover_report_manager_model');
			$this->load->model('reports/turnover_report_model');
			$partner_id=$this->session->userdata['partnerid'];
			$data = array("id" => $partner_id);
			$amount['amt']=$this->common_model->getBalance($data);  
					
			$this->load->view("common/header",$amount);
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
            //player model
        }
	
	
	
     public function index(){

		$SESSION_PARTNER_TYPE = $this->session->userdata('partnertypeid'); 
		$SESSION_PARTNER_ID = $this->session->userdata('partnerid'); 
		$data["SESSION_PARTNER_TYPE"] = $SESSION_PARTNER_TYPE;
		$data['PARTNER_ID'] = $SESSION_PARTNER_ID;
  		$data['rid'] = $this->input->get_post('rid',TRUE);
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['AGENT_LIST']		= $this->input->get_post('AGENT_LIST',TRUE);
			$data['GAMES_TYPE']		= $this->input->get_post('GAMES_TYPE',TRUE);
            $data['PARTNER_TYPE'] 	= $this->input->get_post('PARTNER_TYPE',TRUE);
            $data['SEARCH_LIMIT'] 	= $this->input->get_post('SEARCH_LIMIT',TRUE);
			$START_DATE_TIME		= $this->input->get_post('START_DATE_TIME',TRUE);
            $END_DATE_TIME 			= $this->input->get_post('END_DATE_TIME',TRUE);
			
			//$this->session->set_userdata(array('report_searchData'=>$data));
			if(!empty($START_DATE_TIME) && !empty($END_DATE_TIME) ){
				$data['START_DATE_TIME']	= date('Y-m-d H:i:s',strtotime($START_DATE_TIME));
				$data['END_DATE_TIME']		= date('Y-m-d H:i:s',strtotime($END_DATE_TIME));
			}

			switch($SESSION_PARTNER_TYPE){
				case 0: //admin
					$data["results"] = $this->turnover_report_manager_model->managePartnersTurnover($data);
					$data['all_agent_result'] 	= 	$this->turnover_report_model->getAGENTlist(11);
					break;
				case 11://main agent
					$data["MAIN_AGEN_ID"] = $SESSION_PARTNER_ID;
					$data["results"] = $this->turnover_report_manager_model->manageMainAgentTurnover($data);
					$data['all_agent_result'] 	= 	$this->turnover_report_model->getAGENTlist(15,'',$SESSION_PARTNER_ID);
					break;
				case 12://distributor
					$data["DISTRIBUTOR_ID"] = $SESSION_PARTNER_ID;
					$data["results"] = $this->turnover_report_manager_model->manageDistributorTurnover($data);
					/* get agent details */
					$data['TITLE2'] = 'Agent';
					$data["sub_results"]= $this->turnover_report_manager_model->manageAgentTurnover($data);
					$data['all_agent_result'] 	= 	$this->turnover_report_model->getAGENTlist(13,'',$SESSION_PARTNER_ID);
					break;
				case 13://subdistributor
					$data["SUBDISTRIBUTOR_ID"] = $SESSION_PARTNER_ID;
					$data["results"] = $this->turnover_report_manager_model->manageSubDistributorTurnover($data);
					$data['all_agent_result'] 	= 	$this->turnover_report_model->getAGENTlist(14,'',$SESSION_PARTNER_ID);
					break;
				case 14://agent
					$data["AGENT_LIST"] = $SESSION_PARTNER_ID;
					$data["results"] = $this->turnover_report_manager_model->manageAgentTurnover($data);
					$data['all_agent_result'] 	= 	'';
					break;
				case 15: //super distributor
					$data["SUPERDISTRIBUTOR_ID"] = $SESSION_PARTNER_ID;
					$data["results"] = $this->turnover_report_manager_model->manageSuperDistributorTurnover($data);
					$data['all_agent_result'] 	= 	$this->turnover_report_model->getAGENTlist(12,'',$SESSION_PARTNER_ID);
					break;
				default :
					$data["results"] = '';
					break;		
			}
		}
		
		$data['partner_type_array'] = 	$this->turnover_report_model->getPartnerList($SESSION_PARTNER_TYPE);
		
		if(!empty($data["results"])){
			/** get name list for display */
			$SESSION_PARTNER_NAME	=	$this->turnover_report_model->getPartnerTypeName($SESSION_PARTNER_TYPE);
			$data['TITLE1'] = (!empty($SESSION_PARTNER_NAME['sub'])?$SESSION_PARTNER_NAME['sub']:'');
			if(!empty($data['PARTNER_TYPE'])){
				$PARTNER_NAME_LIST = $this->turnover_report_model->getPartnerTypeName($data['PARTNER_TYPE']);
				$data['TITLE1'] = $PARTNER_NAME_LIST['main'];
			}
		}

		
		$this->load->view('reports/turnover_report',$data);
	 }
	 
	 public function partnerdetails($partnerId){
		 if($this->input->get_post('keyword',TRUE)=="Search" && !empty($partnerId)){
			$data["partner"]     	= $this->input->post('game'); 
			$data['AGENT_LIST']		= $this->input->get_post('AGENT_LIST',TRUE);
			$data['GAMES_TYPE']		= $this->input->get_post('GAMES_TYPE',TRUE);
			$START_DATE_TIME		= $this->input->get_post('sdate',TRUE);
            $END_DATE_TIME 			= $this->input->get_post('edate',TRUE);
			
			if(!empty($START_DATE_TIME) && !empty($END_DATE_TIME) ){
				$data['START_DATE_TIME']	= date('Y-m-d H:i:s',strtotime($START_DATE_TIME));
				$data['END_DATE_TIME']		= date('Y-m-d H:i:s',strtotime($END_DATE_TIME));
			}
			$partnerDetails = $this->turnover_report_model->getAGENTlist('',$partnerId);

			 if(!empty($partnerDetails)){
				$PARTNER_TYPE = (!empty($partnerDetails[0]['FK_PARTNER_TYPE_ID'])?$partnerDetails[0]['FK_PARTNER_TYPE_ID']:'');
				switch($PARTNER_TYPE){
					case 11:
						$data['PARTNER_TYPE']	= 11;
						$data['AGENT_LIST']		= $partnerId;
						$data["results"] 		= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['AGENT_LIST']		= '';
						$data['PARTNER_TYPE']	= 15;
						$data["MAIN_AGEN_ID"] 	= $partnerId;
						$data["sub_results"]	= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['TITLE1']	= 'Main Agent';
						$data['TITLE2']	= 'Super Distributor';
						$data['PARTNER_TYPE1']	= 11;
						$data['PARTNER_TYPE2']	= 15;
						
						break;
					case 12:
						$data['PARTNER_TYPE']	= 12;
						$data['AGENT_LIST']		= $partnerId;
						$data["results"] 		= $this->turnover_report_manager_model->managePartnersTurnover($data);

						$data['AGENT_LIST']		= '';
						$data['PARTNER_TYPE']	= 13;
						$data['DISTRIBUTOR_ID'] = $partnerId;
						$data["sub_results"]	= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['PARTNER_TYPE']	= 14;
						$data["sub_sub_results"]= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['TITLE1']	= 'Distributor';
						$data['TITLE2']	= 'Sub Distributor';
						$data['TITLE3']	= 'Agent';
						$data['PARTNER_TYPE1']	= 12;
						$data['PARTNER_TYPE2']	= 13;
						$data['PARTNER_TYPE3']	= 14;
						break;
					case 13:
						$data['PARTNER_TYPE']	= 13;
						$data['AGENT_LIST']		= $partnerId;
						$data["results"]	= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['AGENT_LIST']		= '';
						$data['PARTNER_TYPE']	= 14;
						$data['SUBDISTRIBUTOR_ID'] = $partnerId;
						$data["sub_results"]= $this->turnover_report_manager_model->managePartnersTurnover($data);
						$data['TITLE1']	= 'Sub Distributor';
						$data['TITLE2']	= 'Agent';
						$data['PARTNER_TYPE1']	= 13;
						$data['PARTNER_TYPE2']	= 14;
						break;
					case 14:
						$data['PARTNER_TYPE']	= 14;
						$data['AGENT_LIST']		= $partnerId;
						$data["results"]= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['AGENT_LIST']		='';
						$data['PARTNER_ID']		= $partnerId;
						$data["user_results"]	= $this->turnover_report_model->getUserTurnover($data);
						$data['TITLE1']	= 'Agent';
						$data['TITLE4']	= 'User';
						$data['PARTNER_TYPE1']	= 14;
						break;
					case 15: 
						$data['PARTNER_TYPE']	= 15;
						$data['AGENT_LIST']		= $partnerId;
						$data["results"] 		= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['AGENT_LIST']		='';
						$data['PARTNER_TYPE']	= 12;
						$data["SUPERDISTRIBUTOR_ID"] 	= $partnerId;
						$data["sub_results"]	= $this->turnover_report_manager_model->managePartnersTurnover($data);
						
						$data['TITLE1']	= 'Super Distributor';
						$data['TITLE2']	= 'Distributor';
						$data['PARTNER_TYPE1']	= 15;
						$data['PARTNER_TYPE2']	= 12;
						
						break;
					default :
						$data["results"] = '';
						break;		
				}
			}  
		 }
		// echo '<pre>';print_r($data);exit;
		$this->load->view('reports/partnerDetails.php',$data);  
	 }
	 
     
			
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */