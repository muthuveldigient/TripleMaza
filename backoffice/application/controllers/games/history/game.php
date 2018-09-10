<?php
/*
  Class Name	: Game
  Package Name  : Shan
  Purpose       : Controlles all the Shan Games related functionalities
  Auther 	    : Arun
  Date of Modify: June 02 2014
*/
error_reporting(0);
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Game extends CI_Controller{
    
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
			$this->load->model('games/shan/game_model');	
			
			$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			//$USR_STATUS = $_SESSION['partnerstatus'];
			$USR_STATUS = "2";
			$USR_PAR_ID = $this->session->userdata['partnerid'];
			//$USR_GRP_ID = $this->session->userdata['groupid'];

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
		 //$userdata['USR_GRP_ID']=$USR_GRP_ID;
		 $userdata['USR_STATUS']=$USR_STATUS;
		 $searchdata['rdoSearch']='';
			
		if($USR_ID == ''){
		 redirect('login');
		}

		$this->load->model('common/common_model');
		$this->load->model('agent/Agent_model');
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
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index(){
		$data['rid'] = $this->input->get('rid');
		$this->load->view("games/shan/game/search",$data);
	}//EO: index function
	
	public function view($gameTypeID=''){	
		$searchdata['PLAY_GROUP_ID'] 			= trim($this->input->get_post('playGroupID',TRUE));
		$searchdata['GAME_ID'] 					= trim($this->input->get_post('gameID',TRUE));
		$searchdata['GAME_REFERENCE_NO'] 		= $this->input->get_post('gameRefNo',TRUE);
		$searchdata['PLAYER_ID'] 				= trim($this->input->get_post('playerID',TRUE));
		$searchdata['INTERNAL_REFERENCE_NO'] 	= $this->input->get_post('handID',TRUE);
		$searchdata['START_DATE_TIME'] 			= $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] 			= $this->input->get_post('END_DATE_TIME',TRUE);

		$config = array();
		$config["base_url"] 	= base_url()."games/history/game/view";
		$config["per_page"] 	= $this->config->item('limit');
		$config['suffix'] 		= '?chk=41&playGroupID='.$searchdata['PLAY_GROUP_ID'].'&gameID='.$searchdata['GAME_ID'].'&playerID='.$searchdata['PLAYER_ID'].'&gameRefNo='.$searchdata['GAME_REFERENCE_NO'].'&handID='.$searchdata['INTERNAL_REFERENCE_NO'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] 	= $config['base_url'].$config['suffix'];
		$config["uri_segment"] 	= 2;
		$config['sort_order'] 	= "asc";	
	 	$config['cur_page']   	= $this->uri->segment(5);
		if($config['cur_page']==""){
			$page = 0;
		}else{
			$page = $config['cur_page'];
		}
		$name = $this->uri->segment(5, 0);

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$returnvalue = $this->game_model->getGamesCountBySearchCriteria($searchdata);

			$config['total_rows']		= $returnvalue;
			$data['totalrecords'] 		= $this->game_model->getGamesTotalBySearchCriteria($searchdata);
			$data['totalUserRake']    	= $this->game_model->getGamesTotalRakeBySearchCriteria($searchdata);
			$data['totalRecordsRake'] 	= $this->game_model->getTotalGameRakeBySearchCriteria($searchdata);
			$data['results'] 			= $this->game_model->getGamesBySearchCriteria($searchdata,$config["per_page"],$page);

			$data['playGroupID'] 		= trim($this->input->get_post('playGroupID',TRUE));			
			$data['gameID'] 			= trim($this->input->get_post('gameID',TRUE));
			$data['gameRefNo'] 			= $this->input->get_post('gameRefNo',TRUE);
			$data['playerID'] 			= trim($this->input->get_post('playerID',TRUE));
			$data['handID'] 			= $this->input->get_post('handID',TRUE);
			$data['START_DATE_TIME'] 	= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] 		= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();

			$data['rdoSearch'] = $searchdata['rdoSearch'];
		    //$data['gameTypes'] = $this->game_model->getAllGameTypes();
			//$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
			$data['rid'] = $this->input->get('rid');	
			if(count($data)){
				$this->load->view("games/shan/game/list", $data);
			}   
		}elseif($name != ""){
		$data = array();
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
				$data['PLAYER_ID'] 			= $name;
				$config["base_url"] 		= base_url()."games/history/game/view/".$name."";
				$config["per_page"] 		= $this->config->item('limit');
				$config['suffix'] 			= '?chk=41&rid='.$this->input->get('rid');
				$config['first_url'] 		= $config['base_url'].$config['suffix'];
				$config["uri_segment"] 		= 2;
				$config['sort_order'] 		= "asc";	
	 			$config['cur_page']			= $this->uri->segment(6);
				$data['totalrecords']		= $this->game_model->getGamesTotalBySearchCriteria($data);
				$data['totalUserRake']		= $this->game_model->getGamesTotalRakeBySearchCriteria($data);
				$data['totalRecordsRake'] 	= $this->game_model->getTotalGameRakeBySearchCriteria($data);				
				$returnvalue 				= $this->game_model->getGamesCountBySearchCriteria($data);
				$config['total_rows']		= $returnvalue;
				$data['results'] 			= $this->game_model->getGamesBySearchCriteria($data,$config["per_page"], $page);
				$this->pagination->initialize($config);
				$data['pagination'] 		= $this->pagination->create_links();
				$data['rid'] 				= $this->input->get('rid');				
			if(count($data)){
				$this->load->view("games/shan/game/list", $data);
			}
		}else{
				redirect('games/history/game?rid=41');
		}
	}
	
	/*
	 Function Name: add
	 Purpose: This method handle the create game job.
	*/
    
	public function add(){
	  	
		 $formdata=$this->input->post();
		 $formdata['rid']	= $this->input->get('rid');
		 if($this->input->post('submit',TRUE)){
		 //After submit
		  $addGame = $this->game_model->insertGame($formdata);		
  		  $data['err'] 		= $addGame;
		 }
		 $data['coinTypes'] = $this->game_model->getAllCoinTypes();
		 $data['rid'] 		= $this->input->get('rid');

		 $this->load->view("games/shan/game/add",$data);
	}//EO: add function
	
	/*
	 Function Name: edit
	 Purpose: This method handle the edit works of game
	*/
    
	public function edit(){
		$gameId 			= $this->uri->segment(5, 0);
		$formdata			= $this->input->post();
		$formdata['rid']	= $this->input->get('rid');
		if($this->input->post('submit',TRUE)){
			$updateGame 	= $this->game_model->updateGame($gameId,$formdata);		
			$data['msg'] 	= $updateGame;
		}
		$data['coinTypes'] 	= $this->game_model->getAllCoinTypes();	
		$data['results'] 	= $this->game_model->getGameById($gameId); 

		//$data['gameTypes'] = $this->game_model->getAllGameTypes();
		//$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		//$data['gameLimits'] = $this->game_model->getGameLimit();
		$data['rid'] 		= $this->input->get('rid');
		//$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view('games/shan/game/edit',$data);
	}//EO: edit function
	
	/*
	Function Name:editgame
	Purpose: This method handle with search game and point to edit game
	*/
	
	public function editgame(){
		$data['coinTypes'] 	= $this->game_model->getAllCoinTypes();
		$data['rid'] 		= $this->input->get('rid');
		$this->load->view("games/shan/game/editSearch",$data);
	}
	
	
	/*
	Function Name:listgame
	Purpose: This method handle to list all games
	*/
	
	public function listgame(){
		$searchdata['GAME_NAME'] 		= $this->input->get_post('gameName',TRUE);
		$searchdata['STATUS'] 			= $this->input->get_post('status',TRUE);
		$searchdata['START_DATE_TIME'] 	= $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		
		$config = array();
		$config["base_url"] 	= base_url()."games/history/game/listgame";
		$config["per_page"] 	= $this->config->item('limit');
		$config['suffix'] = '?chk=42&gameName='.$searchdata['GAME_NAME'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] 	= $config['base_url'].$config['suffix'];
		$config["uri_segment"] 	= 2;
		$config['sort_order'] 	= "asc";	
	 	$config['cur_page']   	= $this->uri->segment(5);
	   
		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			$returnvalue = $this->game_model->getGamesListCountBySearchCriteria($searchdata);
			//echo $this->db->last_query();
			$config['total_rows'] = $returnvalue;			
			$data['results'] 		= $this->game_model->getGamesListBySearchCriteria($searchdata,$config["per_page"], $page);
			//echo $this->db->last_query(); 
			//die;
			$data['gameName'] 		= $this->input->get_post('gameName',TRUE);
			$data['status'] 		= $this->input->get_post('status',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] 	= $this->pagination->create_links();
			$data['rdoSearch'] 		= $this->input->get_post('keyword',TRUE);
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['coinTypes'] 		= $this->game_model->getAllCoinTypes();
			$data['rid'] 			= $this->input->get('rid');
			if(count($data)){
				$this->load->view("games/shan/game/listGame", $data);
			}   
		}elseif($this->input->get('start') == 1){
				redirect('games/history/game/editgame?rid=42');
		}else{
				redirect('games/history/game?rid=41');
		}
	}


	public function dealerapplet(){
		if($this->input->get_post('submit',TRUE)=="Submit"){
			$searchdata['player1'] = $this->input->get_post('player1',TRUE);
			$searchdata['player2'] = $this->input->get_post('player2',TRUE);
			$searchdata['player3'] = $this->input->get_post('player3',TRUE);
			$searchdata['player4'] = $this->input->get_post('player4',TRUE);
			$searchdata['player5'] = $this->input->get_post('player5',TRUE);
			$searchdata['player6'] = $this->input->get_post('player6',TRUE);
			$searchdata['player7'] = $this->input->get_post('player7',TRUE);
			$searchdata['player8'] = $this->input->get_post('player8',TRUE);
			$gameName = $this->game_model->getTournamentNameByID($_POST['gameName']);
			$this->game_model->insertDealerApplet($gameName,$searchdata);
		}
		$data['rid'] = $this->input->get('rid');
		$data['gameNames'] = $this->game_model->getAllTournamentInfo();
		$this->load->view("games/shan/game/dealer",$data);
	}
		
	/*
	 Function Name: index
	 Purpose: This method handle the delete job of game
	*/
    
	public function delete(){
		$game_id = $this->uri->segment(5, 0);
		if($game_id != ''){
		   $this->game_model->deleteGame($game_id);
		}
		redirect("games/shan/game", 'refresh');	
	}//EO: delete function
    
	public function history(){
		if($this->input->get('keyword',TRUE)=="Search"){
			$searchdata['gameID'] 			= $this->input->get('gameID',TRUE);
			$searchdata['START_DATE_TIME'] 	= $this->input->get('START_DATE_TIME',TRUE);
			$searchdata['END_DATE_TIME'] 	= $this->input->get('END_DATE_TIME',TRUE);
			$searchdata['playerID'] 		= trim($this->input->get_post('playerID',TRUE));
		}else{
			$searchdata['playerID'] 		= trim($this->input->get_post('playerID',TRUE));
			$searchdata['gameID'] 			= $this->input->get_post('gameID',TRUE);
			$searchdata['intRefNo'] 		= trim($this->input->get_post('intRefNo',TRUE));
			$searchdata['START_DATE_TIME'] 	= $this->input->get_post('START_DATE_TIME',TRUE);
			$searchdata['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$searchdata['SEARCH_LIMIT'] 	= $this->input->get_post('SEARCH_LIMIT',TRUE);
		}
		$searchdata['rid'] 				= $this->input->get('rid');

		$config = array();
		$config["base_url"] 	= base_url()."games/history/game/history";
		$config["per_page"] 	= $this->config->item('limit');
		$config['suffix'] = '?chk=48&playerID='.$searchdata['playerID'].'&gameID='.$searchdata['gameID'].'&intRefNo='.$searchdata['intRefNo'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] 	= $config['base_url'].$config['suffix'];
		$config["uri_segment"] 	= 2;
		$config['sort_order'] 	= "asc";	
	 	$config['cur_page']   	= $this->uri->segment(5);
		if($config['cur_page']==""){
			$page = 0;
		}else{
			$page = $config['cur_page'];
		}
		$data['rid'] = 72;
				
		$data['activeGames'] 	= $this->game_model->getListOfActiveGames();

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$searchdata['GameRefCode'] = $this->game_model->getGameRefCode($searchdata['gameID']);
			$returnvalue = $this->game_model->getGamesHistoryCountBySearchCriteria($searchdata);
			
			if($searchdata['intRefNo']==''){
				$data['total'] = $this->game_model->getGamesBetWinEndBySearchCriteria($searchdata);
				$data['results'] = $this->game_model->getGamesHistoryBySearchCriteria($config,$searchdata,$page);
			}else{
				$data['results'] = $this->game_model->getUserGameHistoryBySearchCriteria($config,$searchdata,$page);
			}
			$config['total_rows'] = count($returnvalue);
			$data['total_rows'] = count($returnvalue);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
		}
		if($searchdata['intRefNo']!=''){
			$this->load->view("games/shan/game/userhistory", $data);
		}else{
			$this->load->view("games/shan/game/history",$data);
		}
	}	
	
	public function userhistory(){	
		$name = $this->uri->segment(5, 0);

		$searchdata['playerID'] 		= trim($this->input->get_post('playerID',TRUE));
		$searchdata['gameID'] 			= trim($this->input->get_post('gameID',TRUE));
		$searchdata['intRefNo'] 		= trim($this->input->get_post('intRefNo',TRUE));
		$data['GameRefCode'] 			= $this->game_model->getGameRefCode($searchdata['gameID']);
		$searchdata['START_DATE_TIME'] 	= $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		$searchdata['SEARCH_LIMIT'] 	= $this->input->get_post('SEARCH_LIMIT',TRUE);
		
		$config = array();
		$config["base_url"] 	= base_url()."games/history/game/userhistory";
		$config["per_page"] 	= $this->config->item('limit');
		$config['suffix'] = '?chk=48&playerID='.$searchdata['playerID'].'&gameID='.$searchdata['gameID'].'&intRefNo='.$searchdata['intRefNo'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url']	= $config['base_url'].$config['suffix'];
		$config["uri_segment"] 	= 2;
		$config['sort_order'] 	= "asc";	
	 	$config['cur_page']   	= $this->uri->segment(5);
		if($config['cur_page']==""){
			$page = 0;
		}else{
			$page = $config['cur_page'];
		}
		$data['rid'] = 72;		
		$data['activeGames'] = $this->game_model->getListOfActiveGames();

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$data['playerID'] 			= trim($this->input->get_post('playerID',TRUE));
			$data['gameID'] 			= trim($this->input->get_post('gameID',TRUE));
			$data['intRefNo'] 			= trim($this->input->get_post('intRefNo',TRUE));
			$data['START_DATE_TIME'] 	= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] 		= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['SEARCH_LIMIT'] 		= $this->input->get_post('SEARCH_LIMIT',TRUE);		
			$data['GameRefCode'] 		= $this->game_model->getGameRefCode($searchdata['gameID']);
			$returnvalue = $this->game_model->getUserGameHistoryCountBySearchCriteria($data);
			//echo $this->db->last_query(); die;
			$data['totRecords'] = $returnvalue; //$this->game_model->getUserGameHistoryCountBySearchCriteria($data);

			$config['total_rows']=$returnvalue;			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['rid'] 		= $this->input->get('rid');
			$data['totals'] 	= $this->game_model->getUserGameBetWinBySearchCriteria($data);
			$data['results'] 	= $this->game_model->getUserGameHistoryBySearchCriteria($config,$data,$page);

			if(count($data)){
				$this->load->view("games/shan/game/userhistory",$data);
			}
		}elseif($name != ''){
			$data = array();
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
				$data['playerID'] 		= $name;
				if(!empty($_REQUEST['gameid']) || $_REQUEST['gameid'] != 'select'){
					$data['GameRefCode'] = $this->game_model->getGameRefCode($_REQUEST['gameid']);
				}
				if($_REQUEST['sdate'] != ''){
					$data['START_DATE_TIME'] = $_REQUEST['sdate'];
				}
				if($_REQUEST['edate'] != ''){
					$data['END_DATE_TIME']	=	$_REQUEST['edate'];			
				}

				$data['activeGames'] 	= $this->game_model->getListOfActiveGames();
				$config["base_url"] 	= base_url()."games/history/game/userhistory/".$name."";
				$config["per_page"] 	= $this->config->item('limit');
				$config['suffix'] = '?chk=41&gameid='.$_REQUEST['gameid'].'&sdate='.$_REQUEST['sdate'].'&edate='.$_REQUEST['edate'].'&rid='.$this->input->get('rid');
				$config['first_url'] 	= $config['base_url'].$config['suffix'];
				$config["uri_segment"] 	= 2;
				$config['sort_order'] 	= "asc";	
	 			$config['cur_page']   	= $this->uri->segment(6);
				$returnvalue 			= $this->game_model->getUserGameHistoryCountBySearchCriteria($data);
				//echo $this->db->last_query(); die;
				$data['totRecords'] 	= $this->game_model->getUserGameHistoryCountBySearchCriteria($data);
				$config['total_rows']	= $returnvalue;
				$data['totals'] 		= $this->game_model->getUserGameBetWinBySearchCriteria($data);
				$data['results'] 		= $this->game_model->getUserGameHistoryBySearchCriteria($config,$data,$page);
				$this->pagination->initialize($config);
				$data['pagination'] 	= $this->pagination->create_links();
				$data['rid'] 			= $this->input->get('rid');				
			if(count($data)){
				$this->load->view("games/shan/game/userhistory", $data);
			}
		}else{
			$this->load->view("games/shan/game/userhistory", $data);
		}
	}	

	public function deactivateTournament(){
		$data['chklist'] = $_REQUEST['chkarr'];
		$result = $this->game_model->deleteShanTournamentTables($data);
		if($result=='1'){
			echo "success";
		}else{
			echo "fail";
		}
		die;
	}
	
	public function activateTournament($tid){
		$formdata['tourid'] = $tid;

		if($formdata['tourid']!=''){
			$result = $this->game_model->activateShanTournamentTables($formdata);
			if($result){ 
				$returnString  = '<font color="Green">Activated</font>';
				echo $returnString; 
				die;
			}
		}
	}

 public function testReport() {
  $result = $this->game_model->getTestReport();
 }

public function getservertype(){
	 $string='';
	 if(!empty($_POST)){
		 $min = $_POST['BANKER'];
		 $max = $_POST['BANKER'];
		$servers = $this->game_model->getTournamentServers($min, $max);
		if(!empty($servers)){
		  $string.= '<option value="'.$servers[0]->SERVER_ID.'">'. $servers[0]->SERVER_NAME.'</option>';
		}
	 } 
	 echo $string;exit;
 }

}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */