<?php
/*
  Class Name	: Agent_turnover
  Package Name  : Report
  Purpose       : Controller all the Turnover releated details
  Auther 	    : Sivakumar
  Date of create: July 08 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_game_turnover_lists extends CI_Controller{
    
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

			if($USR_STATUS!=1)
			{
					//$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = $USR_PAR_ID;
			}
			else
			{
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
			
			if($this->common_model->authendicate() == '' )
			{
				$this->session->set_flashdata('message', 'Login to access the page');
				redirect();
			}
			$partner_id=$this->session->userdata['partnerid'];
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
            //player model
        }
	
	
	
     public function report(){
	 	
	    $loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["results"] = $this->agentreport_model->getPartnersGameTurnover($data);
		} 
		
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME'); 
		
		switch($partner_type){
			case 1:
			$this->load->view('reports/agent_game_turnover',$data);  
			break;
			case 2:
			
			break;
			case 3:
			
			break;
			case 4:
			
			break;
			default :
			$this->load->view('reports/agent_game_turnover',$data);  
			break;		
		}
	 }
	
	 public function supdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
	 
	 	if($loggedinPartnerIDs)
	 		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	 
	 		if($this->input->get_post('keyword',TRUE)=="Search"){
	 			if($this->input->get_post('START_DATE_TIME',TRUE))
 					$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
 				else
 					$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
	 						
				if($this->input->get_post('END_DATE_TIME',TRUE))
					$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
				else
					$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
						
				//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
				$this->session->set_userdata(array('searchData'=>$data));
				//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
				$data['rid'] = $this->input->get_post('rid',TRUE);
				$data['gameid'] = $this->uri->segment(4,0);
				$data['magntid'] = $this->uri->segment(5,0);
				$data["partnertype"] = $this->session->userdata('partnertypeid');
				$data["dresults"] = $this->agentreport_model->getSuperDistributorGameTurnover($data);
	 		}
	 			
	 		$data['START_DATE_TIME']=	$this->input->get_post('sdate');
	 		$data['END_DATE_TIME']	=	$this->input->get_post('edate');
	 
	 		$this->load->view('reports/agent_dist_game_turnover',$data);
	 }
	 
	 public function supdistreport_details(){
	 
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
	 
	 	if($loggedinPartnerIDs)
	 		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	 
	 		$distid=$this->uri->segment(4,0);
	 		$data['distid']=$distid;
	 
	 		if($this->input->get_post('keyword',TRUE)=="Search"){
	 			if($this->input->get_post('START_DATE_TIME',TRUE))
	 				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
				else
				$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
	 						
				if($this->input->get_post('END_DATE_TIME',TRUE))
					$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
				else
				$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
					
				//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
				$this->session->set_userdata(array('searchData'=>$data));
				//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
					
					
				$data['rid'] = $this->input->get_post('rid',TRUE);
				$data['gameid'] = $this->uri->segment(5,0);
				$data["partnertype"] = $this->session->userdata('partnertypeid');
				
				$data["dresults"] = $this->agentreport_model->getSupDistributorAllGameTurnover($data);
	 		}
	 			
	 		$data['START_DATE_TIME']=	$this->input->get_post('sdate');
	 		$data['END_DATE_TIME']	=	$this->input->get_post('edate');
	 
	 
	 		$this->load->view('reports/agent_dist_all_game_turnover',$data);
	 }
	 
	 public function distreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			if($this->input->get_post('START_DATE_TIME',TRUE))
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			else
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
			
			if($this->input->get_post('END_DATE_TIME',TRUE))
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			else
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
			
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['gameid'] = $this->uri->segment(4,0);
			$data['magntid'] = $this->uri->segment(5,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			//echo "<pre>"; print_r($data); die;
			$data["dresults"] = $this->agentreport_model->getDistributorGameTurnover($data);
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$this->load->view('reports/agent_dist_game_turnover',$data);  
	 }
	 
	 public function distreport_details(){
	 
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		 $distid=$this->uri->segment(4,0);
		 $data['distid']=$distid;
		
		if($this->input->get_post('keyword',TRUE)=="Search"){

		
			if($this->input->get_post('START_DATE_TIME',TRUE))
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			else
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
			
			if($this->input->get_post('END_DATE_TIME',TRUE))
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			else
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
			
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['gameid'] = $this->uri->segment(5,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');

			$data["dresults"] = $this->agentreport_model->getDistributorAllGameTurnover($data);
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		
		$this->load->view('reports/agent_dist_all_game_turnover',$data);  
	 }

     public function subdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		 
		if($this->input->get_post('keyword',TRUE)=="Search"){
			if($this->input->get_post('START_DATE_TIME',TRUE))
				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			else
				$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);
			
			if($this->input->get_post('END_DATE_TIME',TRUE))
            	$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			else
				$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['distid'] = $this->uri->segment(5,0);
			$data['gameid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			//echo "<pre>"; print_r($data); die;
			$data["dresults"] = $this->agentreport_model->getSubDistributorGameTurnover($data);
			//echo $this->db->last_query(); die;
		}
	
		$this->load->view('reports/agent_dist_game_turnover',$data);  
	 }
	 
	 
	 public function subdistreport_details(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		 
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data['gameid'] = $this->uri->segment(5,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getSubDistAgentGameTurnover($data);
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		
		$this->load->view('reports/agent_dist_game_turnover',$data);  
	 }
	 
	 public function agentgamereport_details(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			
			
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data['gameid'] = $this->uri->segment(5,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$data["dresults"] = $this->agentreport_model->getAgentGameDetailsTurnover($data);
		}
		 
		$data['START_DATE_TIME']=	$this->input->get_post('sdate'); 
		$data['END_DATE_TIME']	=	$this->input->get_post('edate'); 
		
		$this->load->view('reports/agent_dist_game_turnover',$data);  
	 }
	 
	 public function agentreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
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
		
		$this->load->view('reports/agent_user_turnover',$data);  
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
			
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */