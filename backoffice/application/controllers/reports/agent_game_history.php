<?php
//error_reporting(E_ALL);
/*
  Class Name	: Payment
  Package Name  : Report
  Purpose       : Controller for game history
  Auther 	    : Sivakumar
  Date of create: July 07 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_game_history extends CI_Controller{
    
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
			$this->load->model('reports/agentgamehistory_model');
			
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
	
	
	
	public function gamehistory_old(){
		
	    $loggedInPartnersList = $this->partner_model->loggedinPartnerIDs($this->session->userdata); 
		$searchdata['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
		$searchdata['GAME_ID'] = $this->input->get_post('gameID',TRUE);
		$searchdata['intRefNo'] = $this->input->get_post('intRefNo',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		$searchdata['SEARCH_LIMIT'] = $this->input->get_post('SEARCH_LIMIT',TRUE);
		
		
		$searchdata['loggedInPartnersList'] = $loggedInPartnersList;
		$searchdata['rid'] = $this->input->get('rid');
		$config = array();
		$config["base_url"] = base_url()."reports/agent_game_history/game/gamehistory";
		$config["per_page"] = $this->config->item('limit');
		$config['suffix'] = '?chk=41&playerID='.$searchdata['PLAYER_ID'].'&gameID='.$searchdata['GAME_ID'].'&intRefNo='.$searchdata['intRefNo'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";	
	 	$config['cur_page']   = $this->uri->segment(5);
		if($config['cur_page']==""){
			$page = 0;
		}else{
			$page = $config['cur_page'];
		}
				
		$data['activeGames'] = $this->agentgamehistory_model->getListOfActiveGames();
		$data['rid'] = $this->input->get('rid');
		
		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$searchdata['GameRefCode'] = $this->agentgamehistory_model->getGameRefCode($searchdata['GAME_ID']);
			$data['results'] = $this->agentgamehistory_model->getGamesHistoryBySearchCriteria($config,$searchdata,$page);
		}
	
		if($searchdata['intRefNo']){
		redirect("reports/agent_game_history/usergame_history?rid=".$this->input->get('rid').'&intRefNo='.$searchdata['intRefNo'].'&keyword=Search');
		}else{
		$this->load->view("reports/agent_gamehistory",$data);  
		}
	
	}
	
	public function usergame_history_old(){
		
		$name='';
		$searchdata['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
		$searchdata['GAME_ID'] = $this->input->get_post('gameID',TRUE);
		$searchdata['intRefNo'] = $this->input->get_post('intRefNo',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		$searchdata['SEARCH_LIMIT'] = $this->input->get_post('SEARCH_LIMIT',TRUE);
		$loggedInPartnersList = $this->partner_model->loggedinPartnerIDs($this->session->userdata);
		$searchdata['loggedInPartnersList'] = $loggedInPartnersList; 
		$config = array();
		$config["base_url"] = base_url()."reports/agent_game_history/usergame_history";

		$config["per_page"] = $this->config->item('limit');
		$config['suffix'] = '?chk=41&playerID='.$searchdata['PLAYER_ID'].'&gameID='.$searchdata['GAME_ID'].'&intRefNo='.$searchdata['intRefNo'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";	
	 	$config['cur_page']   = $this->uri->segment(4);
		if($config['cur_page']==""){
			$page = 0;
		}else{
			$page = $config['cur_page'];
		}
			$data = array();	
		$data['activeGames'] = $this->agentgamehistory_model->getListOfActiveGames();

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			
			$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
			$data['playerID'] = $this->input->get_post('playerID',TRUE);
			$data['gameID'] = $this->input->get_post('gameID',TRUE);
			$data['intRefNo'] = $this->input->get_post('intRefNo',TRUE);
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$data['SEARCH_LIMIT'] = $this->input->get_post('SEARCH_LIMIT',TRUE);		
			$data['GameRefCode'] = $this->agentgamehistory_model->getGameRefCode($searchdata['GAME_ID']);
			$data['loggedInPartnersList'] = $loggedInPartnersList;
			$returnvalue = $this->agentgamehistory_model->getUserGameHistoryBySearchCriteriaCount($data);
			
			$config["base_url"] = base_url()."reports/agent_game_history/usergame_history/";
			$config["per_page"] = $this->config->item('limit');
		//	$config['suffix'] = '?chk=41&rid='.$this->input->get('rid');
			$config['first_url'] = $config['base_url'].$config['suffix'];
			$config["uri_segment"] = 2;
			$config['sort_order'] = "asc";	
			$config['cur_page']   = $this->uri->segment(4);
			
			
			$config['total_rows']=$returnvalue;
			$data['rid'] = $this->input->get('rid');
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['results'] = $this->agentgamehistory_model->getUserGameHistoryBySearchCriteria($config,$data,$page);
			
			if(count($data)){
				$this->load->view("reports/agent_user_gamehistory",$data);
			}
		}elseif($name != ''){
				$data = array();
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
				$data['playerID'] = $name;
				$data['activeGames'] = $this->agentgamehistory_model->getListOfActiveGames();
				$config["base_url"] = base_url()."reports/agent_game_history/usergame_history/".$name."";
				$config["per_page"] = $this->config->item('limit');
				//$config['suffix'] = '?chk=41&rid='.$this->input->get('rid');
				$config['first_url'] = $config['base_url'].$config['suffix'];
				$config["uri_segment"] = 2;
				$config['sort_order'] = "asc";	
	 			$config['cur_page']   = $this->uri->segment(6);
				$returnvalue = $this->agentgamehistory_model->getUserGameHistoryBySearchCriteriaCount($data);
				
				$config['total_rows']=$returnvalue;
				
				
				//print_r($config);
				$data['rid'] = $this->input->get('rid');
				$data['results'] = $this->agentgamehistory_model->getUserGameHistoryBySearchCriteria($config,$data,$page);
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				$data['rid'] = $this->input->get('rid');				
			if(count($data)){
				$this->load->view("reports/agent_user_gamehistory", $data);
			}
		}else{
			$this->load->view("reports/agent_user_gamehistory", $data);
		}
	}
	
	
	 
	 public function view(){
	 	$handId = $this->uri->segment(5, 0); 
		$gameName = $this->agentgamehistory_model->getGameNameByMinigamesId($handId);
		$data['handId'] = $handId;
		$data['gameName'] = $gameName;				
		//echo $gameName; exit;
		switch ($gameName) {
    		case 'singlewheel':
        		$this->load->view("reports/agent_user_gamehistory/rummy_playdetails",$data);
        		break;
		    case 1:
    		    echo "i equals 1";
        		break;
		    case 2:
    		    echo "i equals 2";
        		break;
			
		}		
	 }
	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */
