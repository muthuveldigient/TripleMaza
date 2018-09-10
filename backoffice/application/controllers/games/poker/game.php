<?php

//error_reporting(E_ALL);
/*
  Class Name	: Game
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Sivakumar
  Date of Modify: April 02 2014

*/
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
			$this->load->model('games/poker/game_model');
			$this->load->model('partners/partner_model');

			$USR_ID = $this->session->userdata['partnerusername'];
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


		if($USR_ID == ''){
		 redirect('login');
		}


		$this->load->model('common/common_model');
		$this->load->model('user/Account_model');

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
		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['rid'] = $this->input->get('rid');
		$this->load->view("games/poker/game/search",$data);
	}//EO: index function


	public function viewgames() {
		$data["page_title"]    = "Search Games";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('searchGameDetails');
		}
		if($this->input->get('start',TRUE) == 1){
        	$this->session->unset_userdata('searchGameDetails');
		}



		if($this->input->post('frmSearch')) {
			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			$data['GAME_ID'] = $this->input->get_post('gameID',TRUE);
			$data['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['HAND_ID'] = $this->input->get_post('handID',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchGameDetails'=>$data));
			$noOfRecords  = $this->game_model->getSearchGamesCount($data);
		} else if($this->input->get_post('gameid',TRUE)!="") {
			$data['TABLE_ID']  = $this->input->get_post('gameid',TRUE);
			$data['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
			$data['START_DATE_TIME'] = $this->input->get_post('sdate',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('edate',TRUE);
			$this->session->set_userdata(array('searchGameDetails'=>$data));
			$noOfRecords  = $this->game_model->getSearchGamesCount($data);
		} else if($this->session->userdata('searchGameDetails')) {
   			$noOfRecords  = $this->game_model->getSearchGamesCount($this->session->userdata('searchGameDetails'));
  		} else {
			//$noOfRecords  = $this->game_model->getSearchGamesCount("");
		}

		/* Set the config parameters */
		$config['base_url']   = base_url()."games/poker/game/viewgames";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit');
		$config['cur_page']   = $this->uri->segment(5);
		$config['suffix']     = '?rid=51';

		if($this->uri->segment(5)) {
			$config['order_by']	  = $this->uri->segment(6);
			$config['sort_order'] = $this->uri->segment(7);
		} else {
			$config['order_by']	  = "GAME_HISTORY_ID";
			$config['sort_order'] = "asc";
		}
		if($this->input->post('frmSearch')) {

			$data["searchGameData"] = $this->game_model->getSearchGameData($config,$data);
			$data["totalSearchData"]= $this->game_model->getTotalSearchData();
			$data["searchResult"] = 1;
		} else if($this->input->get_post('gameid',TRUE)!="") {

			$data["searchGameData"] = $this->game_model->getSearchGameData($config);
			$data["totalSearchData"]= $this->game_model->getTotalSearchData();
			$data["searchResult"] = 1;
		} else if($this->session->userdata('searchGameDetails')) {

			$data["searchGameData"] = $this->game_model->getSearchGameData($config,$data);
			$data["totalSearchData"]= $this->game_model->getTotalSearchData();
			$data["searchResult"] = 1;
		} else {
			//$data["searchGameData"] = $this->game_model->getSearchGameData($config,"");

			//$data["totalSearchData"] = $this->game_model->getTotalSearchData();
			//$data["searchResult"] = "";

		}


		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();

		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$this->load->view('games/poker/game/viewgames',$data);
	}

	public function view(){

		$searchdata['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
		$searchdata['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
		$searchdata['GAME_ID'] = $this->input->get_post('gameID',TRUE);
		$searchdata['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
		$searchdata['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['HAND_ID'] = $this->input->get_post('handID',TRUE);
		$searchdata['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
		$searchdata['STATUS'] = $this->input->get_post('status',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		$this->session->set_userdata(array('searchGameDetails'=>$searchdata));
		$tournamentID = $_REQUEST["tID"];

			if(isset($tournamentID) && !empty($tournamentID)) {
				if(empty($searchdata['START_DATE_TIME']) && empty($searchdata['END_DATE_TIME'])){
				$getTTableName = $this->game_model->getGameTournamentTableID($tournamentID);
				$searchdata['TABLE_ID'] = $getTTableName[0]->TOURNAMENT_NAME;
				$searchdata['START_DATE_TIME'] = date('Y-m-01')." 00:00:00";
				$searchdata['END_DATE_TIME']   = date('Y-m-d')." 23:59:59";
				}
			}
		$config = array();
		$config["base_url"] = base_url()."games/poker/game/view";
		$config["per_page"] = $this->config->item('limit');
		$config['suffix'] = '?chk=30&tableID='.$searchdata['TABLE_ID'].'&game_type='.$searchdata['GAME_TYPE'].'&playerID='.$searchdata['PLAYER_ID'].'&currency_type='.$searchdata['CURRENCY_TYPE'].'&handID='.$searchdata['HAND_ID'].'&stakeAmt='.$searchdata['STAKE'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&gameID='.$searchdata['GAME_ID'].'&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";
	 	$config['cur_page']   = $this->uri->segment(5);
		$name = $this->uri->segment(5, 0);
		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search" or isset($tournamentID)){

			$returnvalue = $this->game_model->getGamesCountBySearchCriteria($searchdata);
			$config['total_rows']=$returnvalue;

			if(isset($gameType) && !empty($gameType))
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
			else
				$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

			if($searchdata['TABLE_ID']!='' || $searchdata['PLAYER_ID']!=''){
				$data['totalrecords'] = $this->game_model->getGamesTotalBySearchCriteria($searchdata);
			}

			$data['results'] = $this->game_model->getGamesBySearchCriteria($searchdata,$config["per_page"], $page);
			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			if(isset($tournamentID) && !empty($tournamentID)) {
				$getTTableName1 = $this->game_model->getGameTournamentTableID($tournamentID);
				$data['TABLE_ID'] = $getTTableName1[0]->TOURNAMENT_NAME;
				$data['START_DATE_TIME'] = date('Y-m-01')." 00:00:00";;
				$data['END_DATE_TIME']   = date('Y-m-d')." 23:59:59";
			} else {
				$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			}

			$data['GAME_ID'] = $this->input->get_post('gameID',TRUE);
			$data['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['HAND_ID'] = $this->input->get_post('handID',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['rdoSearch']=$searchdata['rdoSearch'];

		    $data['gameTypes'] = $this->game_model->getAllGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
			$data['rid'] = $this->input->get('rid');
			if(count($data)){
				$this->load->view("games/poker/game/list", $data);
			}
		}elseif($name != ""){
		$data = array();
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
				$data['PLAYER_ID'] = $name;
				$data['playerID'] = $name;
				$config["base_url"] = base_url()."games/poker/game/view/".$name."";
				$config["per_page"] = $this->config->item('limit');
				$config['suffix'] = '?chk=51&rid='.$this->input->get('rid');
				$config['first_url'] = $config['base_url'].$config['suffix'];
				$config["uri_segment"] = 2;
				$config['sort_order'] = "asc";
	 			$config['cur_page']   = $this->uri->segment(6);
				$data['totalrecords'] = $this->game_model->getGamesTotalBySearchCriteria($data);
				$returnvalue = $this->game_model->getGamesCountBySearchCriteria($data);
				$config['total_rows']=$returnvalue;
				$data['results'] = $this->game_model->getGamesBySearchCriteria($data,$config["per_page"], $page);
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
			if(count($data)){
				$this->load->view("games/poker/game/list", $data);
			}
		}else{
				redirect('games/poker/game?rid=51');
		}

	}

	/*
	 Function Name: add
	 Purpose: This method handle the create game job.
	*/

	public function add(){
    $isAdminUserCheck =  $this->session->userdata('isadminuser');
    if($isAdminUserCheck == 1){
       redirect('user/account/welcomeadminuser?rid=10&start=1');
     }
		 $formdata=$this->input->post();
		 $formdata['rid']=$this->input->get('rid');
		 if($this->input->post('submit',TRUE)){
		//After submit
			$tournamentName = $_POST['game_name'];
			$chkTournamentExists = $this->game_model->ChkTournamentExists($tournamentName);
			if(empty($chkTournamentExists)) {
				  $addGame = $this->game_model->insertGame($formdata);
				  $data['err'] = $addGame;
			} else {
				redirect('games/poker/game/add?err=6&rid=50');
			}
		 }

		 $data['gameTypes'] = $this->game_model->getAllGameTypes();
		 $data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		 $data['gameLimits'] = $this->game_model->getGameLimit();
		 $data['rid'] = $this->input->get('rid');
		// $data['gameThemes'] = $this->game_model->getAllThemes();
		 $this->load->view("games/poker/game/add",$data);
	}//EO: add function

	/*
	 Function Name: edit
	 Purpose: This method handle the edit works of game
	*/

	public function edit(){
    $isAdminUserCheck =  $this->session->userdata('isadminuser');
    if($isAdminUserCheck == 1){
       redirect('user/account/welcomeadminuser?rid=10&start=1');
     }

		$gameid = $this->uri->segment(5, 0);
		$formdata=$this->input->post();
		$formdata['rid']=$this->input->get('rid');
		if($this->input->post('submit',TRUE)){
			$updateGame = $this->game_model->updateGame($gameid,$formdata);
			$data['msg'] = $updateGame;
		}

		$data['results'] = $this->game_model->getGameById($gameid);
		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['gameLimits'] = $this->game_model->getGameLimit();
		$data['rid'] = $this->input->get('rid');
		//$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view('games/poker/game/edit',$data);
	}//EO: edit function

	/*
	Function Name:editgame
	Purpose: This method handle with search game and point to edit game
	*/

	public function editgame(){
		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['rid'] = $this->input->get('rid');
		$this->load->view("games/poker/game/editSearch",$data);
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
		$config["base_url"] = base_url()."games/poker/game/listgame";
		$config["per_page"] = $this->config->item('limit');
		$config['suffix'] = '?chk=30&tableID='.$searchdata['TABLE_ID'].'&game_type='.$searchdata['GAME_TYPE'].'&currency_type='.$searchdata['CURRENCY_TYPE'].'&stakeAmt='.$searchdata['STAKE'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";
	 	$config['cur_page']   = $this->uri->segment(5);

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$returnvalue = $this->game_model->getGamesListCountBySearchCriteria($searchdata);
			$config['total_rows']=$returnvalue;
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
 			$data['results'] = $this->game_model->getGamesListBySearchCriteria($searchdata,$config["per_page"], $page);
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
		    $data['gameTypes'] = $this->game_model->getAllGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
			$data['rid'] = $this->input->get('rid');
			if(count($data)){
				$this->load->view("games/poker/game/listGame", $data);
			}
		}elseif($this->input->get('start') == 1){
				redirect('games/poker/game/editgame?rid=52');
		}else{
				redirect('games/poker/game?rid=51');
		}


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
		redirect("games/poker/game", 'refresh');
	}//EO: delete function


	public function deleteGameTable($tournamentID) {
		$deleteGameTable=$this->game_model->deleteGameTable($tournamentID);
		redirect('games/poker/game/editgame?rid=52');
	}


	 public function history(){
	  if($this->input->get('keyword',TRUE)=="Search"){
	   $searchdata['gameID']    = $this->input->get('gameID',TRUE);
	   $searchdata['START_DATE_TIME']  = $this->input->get('START_DATE_TIME',TRUE);
	   $searchdata['END_DATE_TIME']  = $this->input->get('END_DATE_TIME',TRUE);
	  }else{
	   $searchdata['playerID']   = trim($this->input->get_post('playerID',TRUE));
	   $searchdata['gameID']    = $this->input->get_post('gameID',TRUE);
	   $searchdata['START_DATE_TIME']  = $this->input->get_post('START_DATE_TIME',TRUE);
	   $searchdata['END_DATE_TIME']  = $this->input->get_post('END_DATE_TIME',TRUE);
	   $searchdata['SEARCH_LIMIT']  = $this->input->get_post('SEARCH_LIMIT',TRUE);
	  }
	  $searchdata['rid']     = $this->input->get('rid');
	  $config = array();
	  $config["base_url"]  = base_url()."games/poker/game/history";
	  $config["per_page"]  = $this->config->item('limit');;
	  $config['suffix'] = '?chk=20&playerID='.$searchdata['PLAYER_ID'].'&gameID='.$searchdata['gameID'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
	  $config['first_url']  = $config['base_url'].$config['suffix'];
	  $config["uri_segment"]  = 2;
	  $config['sort_order']  = "asc";
	   $config['cur_page']    = $this->uri->segment(5);
	  if($config['cur_page']==""){
	   $page = 0;
	  }else{
	   $page = $config['cur_page'];
	  }
	  $data['rid'] = 20;

	  if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
	   $returnvalue = $this->game_model->getGamesHistoryCountBySearchCriteria($searchdata);
		$data['total'] = $this->game_model->getGamesBetWinEndBySearchCriteria($searchdata);
		$data['results'] = $this->game_model->getUserGameHistoryBySearchCriteria($config,$searchdata,$page);
	   $config['total_rows'] = $returnvalue;
	   $this->pagination->initialize($config);
	   $data['pagination'] = $this->pagination->create_links();
	  }
	  $data['activeGames']  = $this->game_model->getListOfAllActiveGames();
	   $this->load->view("games/poker/game/history",$data);
	 }

	public function exportToExcel(){
	  $query = $this->session->userdata['query'];
	  $this->load->library("excel");
	  $this->excel->setActiveSheetIndex(0);
	  $data1 = $this->game_model->getExportData($query);
	  $DATE = date("dmY");
	  $fileName = "POKERBAAZI_TURNOVER_REPORT_$DATE.xls";
	  $this->excel->stream($fileName,$data1);
      //$this->session->unset_userdata('query');
	}

	public function exportuser(){
		$playerId = $_REQUEST['uid'];
		$sdate = $_REQUEST['sdate'];
		$edate = $_REQUEST['edate'];

		$data1  = $this->game_model->fetchUserPlaydata($playerId,$sdate,$edate);



		$this->load->library("excel");
		$this->excel->setActiveSheetIndex(0);
		$DATE = date("dmY");
		$fileName = "POKERBAAZI_TURNOVER_REPORT_$DATE.xls";
		$this->excel->stream($fileName,$data1);

	}
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */
