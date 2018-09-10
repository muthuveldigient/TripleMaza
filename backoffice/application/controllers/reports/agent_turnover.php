<?php
/*
  Class Name	: Agent_turnover
  Package Name  : Report
  Purpose       : Controller all the Turnover releated details
  Auther 	    : Sivakumar
  Date of create: July 08 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_turnover extends CI_Controller{
    
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
			$this->load->model('partners/partner_model');
			$this->load->model('reports/agentreport_model');
			$this->load->model('reports/agentledger_model');
			if($this->common_model->authendicate() == '' )
	        {
	            $this->session->set_flashdata('message', 'Login to access the page');
	            redirect();
	        }
			$partner_id=$this->session->userdata['partnerid'];
			$data = array("id" => $partner_id);
			$amount['amt']=$this->common_model->getBalance($data);  
					
			$this->load->view("common/header",$amount);
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
            //player model
        }
	
	
	
     public function report(){
	 	
		$post_partner_type = $_REQUEST["PARTNER_TYPE"];
		$partner_type = $this->session->userdata('partnertypeid'); 
		
	 	switch($partner_type){
			case 11: // Main agent.
				$data['partner_type_array'] = array("SupDis"=>15,"Distributor"=>12,"Sub Distributor"=>13,"Agent"=>14);
				break;
			case 15: // Super Dis.
				$data['partner_type_array'] = array("Distributor"=>12,"Sub Distributor"=>13,"Agent"=>14);
				break;
			case 12: // Distributor.
				$data['partner_type_array'] = array("Sub Distributor"=>13,"Agent"=>14);
				break;
			case 13: // Sub Distributor.
				$data['partner_type_array'] = array();
				break;
			case 14: // Agent.
				$data['partner_type_array'] = array();
				break;
			default :
				$data['partner_type_array'] = array("Main Agent"=>11,"SupDis"=>15,"Distributor"=>12,"Sub Distributor"=>13,"Agent"=>14);
				break;		
		}
	    $loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		//echo $partner_type;
		
		
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		//$data['PARTNER_TYPE'] ='';
		if($this->input->get_post('keyword',TRUE)=="Search"){
			
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['AGENT_LIST']= $this->input->get_post('AGENT_LIST',TRUE);
			$data['GAMES_TYPE']= $this->input->get_post('GAMES_TYPE',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
            $data['PARTNER_TYPE'] 	= $this->input->get_post('PARTNER_TYPE',TRUE);
			
			$this->session->set_userdata(array('searchData'=>$data));
			$data["partnertype"] = $this->session->userdata('partnertypeid');//echo '<prE>';print_r($data);exit;
			$data['partnerid'] = $this->session->userdata('partnerid');
			$data["results"] = $this->agentreport_model->getPartnersTurnover($data);
			
		}
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME'); 
		//$partner_type = $data['PARTNER_TYPE'];
		
 		//echo '<pre>';print_r($data['results']);
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$data['all_agent_result'] = $this->partner_model->getAGENTlist();
		
		if($post_partner_type == ""){
			switch($partner_type){
				case 11:
					$this->load->view('reports/agent_turnover',$data);  
					break;
				case 12:
					$this->load->view('reports/agent_distlogin_turnover',$data);  
					break;
				case 13:
					$this->load->view('reports/agent_subdistlogin_turnover',$data);  
					break;
				case 14:
					$this->load->view('reports/agent_login_turnover',$data);  
					break;
				case 15:  
					$this->load->view('reports/agent_supdistlogin_turnover',$data);
					break;
				default :
					$this->load->view('reports/agent_turnover',$data);  
					break;		
			}
		}else{
			
			if($partner_type == 11){
				
				if($post_partner_type == 13){//echo'<prE>';print_r($data);exit;
					$this->load->view('reports/agent_subdistlogin_turnover',$data); 
				}else{
					$this->load->view('reports/agent_turnover',$data); 
				}
				
			}elseif($partner_type == 15){
				$this->load->view('reports/agent_supdistlogin_turnover',$data);  
			}elseif($partner_type == 12){
				if($post_partner_type == 14){ 
					$this->load->view('reports/agent_login_turnover',$data);
				}else{
					$data['PARTNER_TYPE'] 	='';
					//echo '<pre>';print_r($data);exit;
					$this->load->view('reports/agent_distlogin_turnover',$data);  
				}
			}elseif($partner_type == 13){
				$this->load->view('reports/agent_subdistlogin_turnover',$data);  
			}else{
				$this->load->view('reports/agent_turnover',$data); 
			}
			
		}
	 }
	 
     public function shanreport(){
	    
		$partner_type = $this->session->userdata('partnertypeid'); 
		//echo $partner_type;
			
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data["partnertype"] = $this->session->userdata('partnertypeid');

			$data["results"] = $this->agentreport_model->getPartnersShanTurnover($data);
			$data['partnerid'] = $this->session->userdata('partnerid');
		} 
		
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME'); 
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);

		switch($partner_type){
			case 11:
				$this->load->view('reports/shan_agent_turnover',$data);  
				break;
			case 12:
				$this->load->view('reports/shan_agent_distlogin_turnover',$data);  
				break;
			case 13:
				$this->load->view('reports/shan_agent_subdistlogin_turnover',$data);  
				break;
			case 14:
				$this->load->view('reports/shan_agent_login_turnover',$data);  
				break;
			case 15:
				$this->load->view('reports/shan_supdistlogin_turnover',$data);
				break;
			default :
				$this->load->view('reports/shan_agent_turnover',$data);  
				break;		
		}
	 }

	public function distreport(){
		
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			if($this->uri->segment(4,0)){
				$data['distid'] = $this->uri->segment(4,0);
			}else{
				$data['distid'] = $this->session->userdata('partnerid');
			}
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getDistributorTurnover($data);
		}
		 
		 $loggedinPartnerIDs = $this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$this->load->view('reports/agent_dist_turnover',$data);  
	}
	
	public function distshanreport(){
				
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			if($this->uri->segment(4,0)){
			$data['distid'] = $this->uri->segment(4,0);
			}else{
			$data['distid'] = $this->session->userdata('partnerid');
			}
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getDistributorShanTurnover($data);
		}
		
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$this->load->view('reports/agent_dist_shanturnover',$data);  
	}	

	public function magntreport(){
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['magntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getMgntTurnover($data);
// 			echo '<pre>';print_r($data);exit;
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$this->load->view('reports/agent_magnt_turnover',$data);  
	 }
	 
	 public function supdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
	 
	 	if($this->input->get_post('keyword',TRUE)=="Search"){
	 		$data["partner"]     	= $this->input->post('game');
	 		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
	 		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
	 		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
	 		$this->session->set_userdata(array('searchData'=>$data));
	 		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
	 			
	 		$data['rid'] = $this->input->get_post('rid',TRUE);
	 		$data['supdistid'] = $this->uri->segment(4,0);
	 		$data["partnertype"] = $this->session->userdata('partnertypeid');
	 		$data["dresults"] = $this->agentreport_model->getSupDistTurnover($data);
	 	}
// 	 		echo '<pre>';print_r($data);exit;
	 	$data['START_DATE_TIME']=	$this->input->get_post('sdate');
	 	$data['END_DATE_TIME']	=	$this->input->get_post('edate');
	 
	 	$this->load->view('reports/agent_supdist_turnover',$data);
	 }
	 
	 public function shansupdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
	 
	 	if($this->input->get_post('keyword',TRUE)=="Search"){
	 		$data["partner"]     	= $this->input->post('game');
	 		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
	 		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
	 		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
	 		$this->session->set_userdata(array('searchData'=>$data));
	 		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
	 	 	
	 		$data['rid'] = $this->input->get_post('rid',TRUE);
	 		$data['supdistid'] = $this->uri->segment(4,0);
	 		$data["partnertype"] = $this->session->userdata('partnertypeid');
	 		$data["dresults"] = $this->agentreport_model->getShanSupDistTurnover($data);
// 	 		echo '<pre>';print_r($data);exit;
	 	}
	 	// 	 		echo '<pre>';print_r($data);exit;
	 	$data['START_DATE_TIME']=	$this->input->get_post('sdate');
	 	$data['END_DATE_TIME']	=	$this->input->get_post('edate');
	 
	 	$this->load->view('reports/agent_shan_supdist_turnover',$data);
	 }
	 
	public function magntshanreport(){
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['magntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getMgntShanTurnover($data);
// 			echo '<pre>';print_r($data);exit;
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$this->load->view('reports/agent_magnt_shan_turnover',$data);  
	 }	 
     
	
	public function agentreport(){
		
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			
			if($this->input->get_post('START_DATE_TIME',TRUE)){
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			}else{
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
			}
			
			if($this->input->get_post('END_DATE_TIME',TRUE)){
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			}else{
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
			}
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["agntresults"] = $this->agentreport_model->getAgentTurnover($data);
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$this->load->view('reports/agent_user_turnover',$data);  
	}	
	
	public function agentshanreport(){
	
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			
			if($this->input->get_post('START_DATE_TIME',TRUE)){
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			}else{
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
			}
			
			if($this->input->get_post('END_DATE_TIME',TRUE)){
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			}else{
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
			}
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["agntresults"] = $this->agentreport_model->getShanAgentTurnover($data);
			
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$this->load->view('reports/agent_shan_user_turnover',$data);  
	}	
	
	public function userreport(){
		$partner_id = $this->uri->segment(4,0);
        $self['partner_id'] = $this->uri->segment(4,0);
        $self['START_DATE_TIME'] = $_REQUEST['sdate'];
        $self['END_DATE_TIME'] = $_REQUEST['edate'];
                 	
/*		if($this->input->get_post('keyword',TRUE)=="Search"){
			
			$data['username']  	= $this->input->get_post('USERN_NAME',TRUE);
			
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['user_id'] = $user_id;
				}else{
				  $data['user_id'] = '';
				}
			}else{
			    $data['user_id'] = '';
			}
			
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);   
			
			$totCount       = $this->report_model->getAllUserTurnoverCount($partner_id,$data);
			$data['results']	= $this->report_model->getAllUserTurnover($partner_id,$data);
			$data['tot_users']      = $totCount;
		}else{
*/
		$data['detail'] =  $this->report_model->getSelfPartnerTurnover($self);	
		$totCount       	= $this->report_model->getAllUserTurnoverCount($partner_id,$self);
		$data['username']  	= $this->input->get_post('USERN_NAME',TRUE);
			
		if($data["username"] != ''){
			$user_id = $this->Account_model->getUserIdByName($data['username']);
			if($user_id != ''){
				$data['user_id'] = $user_id;
			}else{
				$data['user_id'] = '';
			}
		}else{
		    $data['user_id'] = '';
		}
	
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
		$data['results']	= $this->report_model->getAllUserTurnover($partner_id,$self);
		$data['tot_users']      = $totCount;
		$this->load->view('reports/userturnover',$data);   
	}
			
	 /* public function game(){
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('searchData');
		}
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["GAME_ID"]     	= $this->input->post('gameName'); 
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
                        $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$noOfRecords  = $this->report_model->getAllGameTurnoverCount($data);	
			$data["results"] = $this->report_model->getAllGameTurnover($data);
                        //echo "<pre>";print_r($data);die;
			if(!empty($data["GAME_ID"]))
				$data["partnersList"] = $this->report_model->getPartnersData($data["GAME_ID"],$data['START_DATE_TIME'],$data['END_DATE_TIME']);
		} 
		$data['START_DATE_TIME']= $this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	= $this->input->post('END_DATE_TIME'); 
		$data['totCount']    = $noOfRecords;
		$data['totPCount']   = $nopOfRecords;
		$data['getGamesData']= $this->report_model->getGamesData();

		$this->load->view('reports/gameturnover',$data);  
	 } */
		
			
            
	public function gameHandIdDetails(){
		$hand_id = $this->uri->segment(4,0);
		$data['results'] = $this->report_model->getParticularHandidGameInfo($hand_id);
		$tablerecords    = $this->report_model->getParticularHandidGameInfo($hand_id);
        $decode_playdata = json_decode($tablerecords[0]->PLAY_DATA);
        $data['game'] = $decode_playdata->oddnEvenResult->card->value;
        //print_r($data);die;
		$this->load->view('reports/gamepop',$data);                
   }
			
	
	/*
	Function Name:gameturnover
	Purpose: This method handle with game turnover report
	*/
	
	public function game(){
		$data['gameTypes'] = $this->agentreport_model->getAllGameTypes();
		$data['currencyTypes'] = $this->agentreport_model->getAllCurrencyTypes();
		$data['rid'] = $this->input->get('rid');
		$this->load->view("reports/agentgameTOSearch",$data);
	}		
	
	
	/*
	Function Name:listgame
	Purpose: This method handle to list all games
	*/
	
	public function listgame(){
		$searchdata['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
		$searchdata['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
		$searchdata['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
		$searchdata['STATUS'] = $this->input->get_post('status',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		
		$config = array();
		$config["base_url"] = base_url()."reports/agent_turnover/listgame";
		$config["per_page"] = 25;
		$config['suffix'] = '?chk=30&tableID='.$searchdata['TABLE_ID'].'&game_type='.$searchdata['GAME_TYPE'].'&currency_type='.$searchdata['CURRENCY_TYPE'].'&stakeAmt='.$searchdata['STAKE'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";	
	 	$config['cur_page']   = $this->uri->segment(4);
		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$returnvalue = $this->agentreport_model->getGamesTOCountBySearchCriteria($searchdata);
			$config['total_rows']=$returnvalue;
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['results'] = $this->agentreport_model->getGamesTOBySearchCriteria($searchdata,$config["per_page"], $page);
			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['rdoSearch']=$searchdata['rdoSearch'];
			$data['START_DATE_TIME']=$this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']=$this->input->get_post('END_DATE_TIME',TRUE);
		    $data['gameTypes'] = $this->agentreport_model->getAllGameTypes();
			$data['currencyTypes'] = $this->agentreport_model->getAllCurrencyTypes();
			$data['rid'] = $this->input->get('rid');
			if(count($data)){
				$this->load->view("reports/agentgameTO", $data);
			} 
			//$this->load->view("reports/gameTOSearch");
		}else{
				redirect('reports/agentgameTO?rid='.$this->input->get('rid'));
		}
	}

     public function pokerreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		//echo $partner_type;

		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){

			$data["partner"]     	= $this->input->post('game');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['agentid'] 	= $this->input->get_post('agent_list',TRUE);
            $data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data["partnertype"] = $this->session->userdata('partnertypeid');

			$data["results"] = $this->agentreport_model->getPartnersPokerTurnover($data);
			//$data["shanResults"] = $this->agentreport_model->getPartnersShanTurnover($data);
			$data['partnerid'] = $this->session->userdata('partnerid');
		}

		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME');
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME');
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		//$data['agent_list']     = $this->agentreport_model->getPartnerDistributors($this->session->userdata('partnerid'),$partner_type);
		$loggedInPartnersList = $this->partner_model->loggedinPartnerIDs($this->session->userdata);
		if($loggedInPartnersList){
			if(count($loggedInPartnersList)==1) {
				$loggedInPartnersList= array($loggedInPartnersList);
			}
			if(!in_array($this->session->userdata['partnerid'],$loggedInPartnersList)) {
				$loggedInPartnersList[]=$this->session->userdata['partnerid'];
			}
		} else {
			$loggedInPartnersList ="-1";
		}
		//$data['agent_list']=$this->agentledger_model->getPokerPartnersNameList($loggedInPartnersList);



		switch($partner_type){
			case 11:
				$this->load->view('reports/poker_agent_turnover',$data);
				break;
			case 12:
				$this->load->view('reports/poker_agent_distlogin_turnover',$data);
				break;
			case 13:
				$this->load->view('reports/poker_agent_subdistlogin_turnover',$data);
				break;
			case 14:
				$this->load->view('reports/poker_agent_login_turnover',$data);
				break;
			case 15:
				$this->load->view('reports/poker_agent_superdistlogin_turnover',$data);
				break;
			default :
				$this->load->view('reports/poker_agent_turnover',$data);
				break;
		}
	 }


     public function category(){
	    
		$partner_type = $this->session->userdata('partnertypeid'); 
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data["partnertype"] = $this->session->userdata('partnertypeid');		
			$data["results"] = $this->agentreport_model->getPartnersTurnoverByCategory($data);		
			$data['partnerid'] = $this->session->userdata('partnerid');
		} 
		
		
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME'); 
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		$this->load->view('reports/agent_turnover_category',$data);
	 }

	public function superdistpokerreport(){
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

			$data['rid'] = $this->input->get_post('rid',TRUE);
			if($this->uri->segment(4,0)){
			$data['superdistid'] = $this->uri->segment(4,0);
			}else{
			$data['superdistid'] = $this->session->userdata('partnerid');
			}
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getSuperDistributorPokerTurnover($data);
		}
		$data['START_DATE_TIME']=	$this->input->get_post('sdate');
		$data['END_DATE_TIME']	=	$this->input->get_post('edate');

		$loggedinPartnerIDs = $this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$this->load->view('reports/agent_superdist_poker_turnover',$data);
	}
	 
	public function distpokerreport(){
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

			$data['rid'] = $this->input->get_post('rid',TRUE);
			if($this->uri->segment(4,0)){
			$data['distid'] = $this->uri->segment(4,0);
			}else{
			$data['distid'] = $this->session->userdata('partnerid');
			}
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getDistributorPokerTurnover($data);
		}
		$data['START_DATE_TIME']=	$this->input->get_post('sdate');
		$data['END_DATE_TIME']	=	$this->input->get_post('edate');

		$loggedinPartnerIDs = $this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$this->load->view('reports/agent_dist_poker_turnover',$data);
	}
	
	public function magntpokerreport(){
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['magntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getMgntPokerTurnover($data);
		}

		$data['START_DATE_TIME']=	$this->input->get_post('sdate');
		$data['END_DATE_TIME']	=	$this->input->get_post('edate');

		$this->load->view('reports/poker_agent_magnt_turnover',$data);
	 }
	 
	public function agentpokerreport(){
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game');

			if($this->input->get_post('START_DATE_TIME',TRUE)){
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			}else{
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
			}

			if($this->input->get_post('END_DATE_TIME',TRUE)){
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			}else{
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
			}
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["agntresults"] = $this->agentreport_model->getAgentPokerTurnover($data);
		}

		$data['START_DATE_TIME']=	$this->input->get_post('sdate');
		$data['END_DATE_TIME']	=	$this->input->get_post('edate');

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$this->load->view('reports/poker_agent_user_turnover',$data);
	}	
			
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */