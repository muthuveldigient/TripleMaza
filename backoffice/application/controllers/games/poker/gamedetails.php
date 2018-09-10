<?php
/*
  Class Name	: Game
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Sivakumar
  Date of Modify: April 02 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gamedetails extends CI_Controller{

    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
	        $this->load->helper('url');
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->model('games/poker/game_model');
			$this->load->model('common/common_model');
			if($this->common_model->authendicate() == '' )
			{
				$this->session->set_flashdata('message', 'Login to access the page');
				redirect();
			}
    }

	/*
	 Function Name: gamedetails
	 Purpose: This method get game details of a game
	 */
	 
	 
	 

	 public function details(){
	 	$gamerefno = $this->uri->segment(5, 0);
		if($gamerefno !=''){
			$data["gameHistoryData"] = $this->game_model->getGameHistoryData($gamerefno);
			$resultHistory			 = $this->game_model->getGameHistoryData($gamerefno);
			$endedDate = $data["gameHistoryData"][0]->ENDED;
			
			$result=$this->game_model->gameDetails($gamerefno,$endedDate);
			if($result[0]->TOURNAMENT_ID){
				$rake=$this->game_model->gameRake($result[0]->TOURNAMENT_ID);
			}
			$data['results']=$result;
			$data['rake']=$rake;
			
			$this->load->view("games/poker/game/details",$data);
		}
	 }
	 
	 public function detailshand(){
	 	$gamerefno = $this->uri->segment(5, 0);
		if($gamerefno !=''){
			$result=$this->game_model->gameHandDetails($gamerefno);
			if($result[0]->TOURNAMENT_ID){
				$rake=$this->game_model->gameRake($result[0]->TOURNAMENT_ID);
			}
			$data['results']=$result;
			$data['rake']=$rake;
			$data["gameHistoryData"] = $this->game_model->getGameHistoryData($gamerefno);
			$this->load->view("games/poker/game/handdetails",$data);
		}
	 }

	 

}

/* End of file gamedetails.php */
/* Location: ./application/controllers/games/poker/gamedetails.php */