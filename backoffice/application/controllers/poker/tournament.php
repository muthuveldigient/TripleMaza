<?php
/*
  Class Name	: Tournament
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tournament extends CI_Controller{

  
    
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
			$this->load->model('games/poker/tournament_model');	
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
		$this->load->view("games/poker/tournament/search",$data);
	}//EO: index function
	
	
	public function view(){
		
		$searchdata['tourName'] = $this->input->get_post('tourName',TRUE);
		$searchdata['game_type'] = $this->input->get_post('game_type',TRUE);
		$searchdata['currency_type'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['tournamentType'] = $this->input->get_post('tournamentType',TRUE);
		$searchdata['eligibility'] = $this->input->get_post('eligibility',TRUE);
		$searchdata['fee'] = $this->input->get_post('fee',TRUE);
		$searchdata['startdate'] = $this->input->get_post('startdate',TRUE);
		$searchdata['enddate'] = $this->input->get_post('enddate',TRUE);

		$config = array();
		$config["base_url"] = base_url()."games/poker/tournament/list";
		$config["per_page"] = 25;
		$config['suffix'] = '?chk=30&tourName='.$searchdata['tourName'].'&game_type='.$searchdata['game_type'].'&currency_type='.$searchdata['currency_type'].'&tournamentType='.$searchdata['tournamentType'].'&eligibility='.$searchdata['eligibility'].'&fee='.$searchdata['fee'].'&startdate='.$searchdata['startdate'].'&enddate='.$searchdata['enddate'];
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 3;
	 
	   
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$returnvalue = $this->tournament_model->getTournamentCountBySearchCriteria($searchdata);
			
			
			$config['total_rows']	=$returnvalue;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$data['results'] = $this->tournament_model->getTournamentBySearchCriteria($searchdata,$config["per_page"], $page);
				
			$data['tourName'] = $this->input->get_post('tourName',TRUE);
			$data['game_type'] = $this->input->get_post('game_type',TRUE);
			$data['currency_type'] = $this->input->get_post('currency_type',TRUE);
			$data['tournamentType'] = $this->input->get_post('tournamentType',TRUE);
			$data['eligibility'] = $this->input->get_post('eligibility',TRUE);
			$data['fee'] = $this->input->get_post('fee',TRUE);
			$data['startdate'] = $this->input->get_post('startdate',TRUE);
			$data['enddate'] = $this->input->get_post('enddate',TRUE);
			$data['links'] = $this->pagination->create_links('usersearch');
			$data['rdoSearch']=$searchdata['rdoSearch'];
		
		    $data['gameTypes'] = $this->game_model->getAllGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		
			if(count($data)){
				$this->load->view("games/poker/tournament/list", $data);
			}   
		}else{
				redirect('games/poker/tournament');
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
		 $addGame = $this->tournament_model->insertTournament($formdata);		
  		 $data['msg'] = $addGame;
		}
		
		 $data['gameTypes'] = $this->game_model->getAllGameTypes();
		 $data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		 $data['gameThemes'] = $this->game_model->getAllThemes();
		
		$this->load->view("games/poker/tournament/add",$data);
	}//EO: add function
	
	/*
	 Function Name: edit
	 Purpose: This method handle the edit works of game
	*/
    
	public function edit(){
		$tourId = $this->uri->segment(4, 0);
		$formdata=$this->input->post();
		if($this->input->post('submit',TRUE)){
		    echo "<pre>";
			print_r($formdata);
			exit;
			$updateGame = $this->tournament_model->updateTournament($gameid,$formdata);		
			$data['msg'] = $updateGame;
		}
			
		$data['results'] = $this->tournament_model->getTournamentById($tourId); 
		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['gameThemes'] = $this->game_model->getAllThemes();
		
		
		
		
		
		$this->load->view('games/poker/tournament/edit',$data);
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