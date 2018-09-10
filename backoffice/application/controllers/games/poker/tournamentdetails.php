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
class Tournamentdetails extends CI_Controller{
    
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
			$this->load->model('games/poker/tournament_model');	
			$this->load->model('games/poker/game_model');	
			
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
		
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		//$this->load->view("common/header",$amount);
		
		
		$this->load->library('commonfunction');
		$this->load->library('assignroles');

    }
	
	/*
	 Function Name: gamedetails
	 Purpose: This method get game details of a game
	 */
	 
	public function details(){
		$gamerefno = $this->uri->segment(5, 0);
		if($gamerefno !=''){
			$data["gameHistoryData"] = $this->tournament_model->getTournamentHistoryData($gamerefno);
			$resultHistory			 = $this->tournament_model->getTournamentHistoryData($gamerefno);
			$endedDate = $data["gameHistoryData"][0]->ENDED;
			$result=$this->tournament_model->tournamentHandDetails($gamerefno,$endedDate);
			if($result[0]->TOURNAMENT_ID){
				$rake=$this->game_model->gameRake($result[0]->TOURNAMENT_ID);
			}
			$data['results']=$result;
			$data['rake']=$rake;
			
			$this->load->view("games/poker/tournament/handdetails",$data);
		}
	}
	  
	
}

/* End of file gamedetails.php */
/* Location: ./application/controllers/games/poker/gamedetails.php */