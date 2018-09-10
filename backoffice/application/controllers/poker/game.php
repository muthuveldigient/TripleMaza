<?php
/*
  Class Name	: Game
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Azeem
  Date of create: Aug 02 2013

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
			//player model
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$this->load->view("games/poker/game/search",$data);
	}//EO: index function
	
	
	public function view(){
			
		$searchdata['GAME_NAME'] = $this->input->get_post('gameName',TRUE);
		$searchdata['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
		$searchdata['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['LIMIT_AMOUNT'] = $this->input->get_post('potlimit',TRUE);

		$config = array();
		$config["base_url"] = base_url()."games/poker/game/list";
		$config["per_page"] = 25;
		$config['suffix'] = '?chk=30&gameName='.$searchdata['gameName'].'&game_type='.$searchdata['game_type'].'&currency_type='.$searchdata['currency_type'].'&potlimit='.$searchdata['potlimit'];
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 3;
	 
	   
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$returnvalue = $this->game_model->getGamesCountBySearchCriteria($searchdata);
			$config['total_rows']	=$returnvalue;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			
			$data['results'] = $this->game_model->getGamesBySearchCriteria($searchdata,$config["per_page"], $page);
								
			$data['gameName'] = $this->input->get_post('gameName',TRUE);
			$data['game_type'] = $this->input->get_post('game_type',TRUE);
			$data['currency_type'] = $this->input->get_post('currency_type',TRUE);
			$data['potlimit'] = $this->input->get_post('potlimit',TRUE);
			$data['links'] = $this->pagination->create_links('usersearch');
			$data['rdoSearch']=$searchdata['rdoSearch'];
		
		    $data['gameTypes'] = $this->game_model->getAllGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		
			if(count($data)){
				$this->load->view("games/poker/game/list", $data);
			}   
		}else{
				redirect('games/poker/game');
		}
	
	}
	
	/*
	 Function Name: add
	 Purpose: This method handle the create game job.
	*/
    
	public function add(){
	  	
		$formdata=$this->input->post();
		if($this->input->post('submit',TRUE)){
		//After submit
		 $addGame = $this->game_model->insertGame($formdata);		
  		 $data['msg'] = $addGame;
		}
		
		 $data['gameTypes'] = $this->game_model->getAllGameTypes();
		 $data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		 $data['gameThemes'] = $this->game_model->getAllThemes();
		
		$this->load->view("games/poker/game/add",$data);
	}//EO: add function
	
	/*
	 Function Name: edit
	 Purpose: This method handle the edit works of game
	*/
    
	public function edit(){
		$gameid = $this->uri->segment(4, 0);
		$formdata=$this->input->post();
		if($this->input->post('submit',TRUE)){
			$updateGame = $this->game_model->updateGame($gameid,$formdata);		
			$data['msg'] = $updateGame;
		}
			
		$data['results'] = $this->game_model->getGameById($gameid); 
		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view('games/poker/game/edit',$data);
	}//EO: edit function
	
	/*
	 Function Name: index
	 Purpose: This method handle the delete job of game
	*/
    
	public function delete(){
		$game_id = $this->uri->segment(4, 0);
		if($game_id != ''){
		   $this->game_model->deleteGame($game_id);
		}
		redirect("games/poker/game", 'refresh');	
	}//EO: delete function
    
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */