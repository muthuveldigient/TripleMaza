<?php //error_reporting(E_ALL);
/*
  Class Name	: Game
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Sivakumar
  Date of Modify: April 02 2014

*/
error_reporting(0);
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gamedetails extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->helper('url');
		$this->load->helper('functions');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('games/shan/game_model');
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
		$game_id = $this->uri->segment(6, 0);
		if($gamerefno !='' && $game_id !=''){
			$result=$this->game_model->gameDetails($gamerefno,$game_id);
			$data['results']=$result;
			$this->load->view("games/shan/game/details",$data);
		}
	 }
	 
	public function view(){
		
		$handId = $this->uri->segment(5, 0);
		$result=$this->game_model->getGameDetails($handId);
		$data['handId'] = $handId;
		$gameName = (!empty($result[0]->MINIGAMES_NAME)?$result[0]->MINIGAMES_NAME:'');
		$data['gameName'] = $gameName;
		$data['dispName'] = (!empty($result[0]->DESCRIPTION)?$result[0]->DESCRIPTION:'');
		$data['gameId'] = (!empty($result[0]->MINIGAMES_ID)?$result[0]->MINIGAMES_ID:'');

		switch ($gameName) {
    		case 'singlewheel':
        		$this->load->view("reports/games/singlewheel_details",$data);
        		break;
		    case 'triplechance':
			$this->load->view("reports/games/triplechance_details",$data);
        		break;
		    case 'roulette36':
        		$this->load->view("reports/games/roulette36_details",$data);
        		break;
		    case 'roulette12':
        		$this->load->view("reports/games/roulette12_details",$data);
        		break;
		    case 'slotreel3':
        		$this->load->view("reports/games/slotreel3_details",$data);
        		break;
		    case 'slotreel5':
        		$this->load->view("reports/games/slotreel5_details",$data);
        		break;	
		    case 'luckybingo':
        		$this->load->view("reports/games/luckybingo_details",$data);
        		break;					
		    case 'jacksorbetter':
        		$this->load->view("reports/games/jacksorbetter_details",$data);
        		break;
		    case 'wheel':
        		$this->load->view("reports/games/wheel_details",$data);
        		break;	
		    case 'blackjack':
        		$this->load->view("reports/games/blackjack_details",$data);
        		break;
		    case 'singlewheeltimer':
        		$this->load->view("reports/games/singlewheeltimer_details",$data);
        		break;	
		    case 'roulette36_timer':
        		$this->load->view("reports/games/roulette36_timer_details",$data);
        		break;
		    case 'roulette12_timer':
        		$this->load->view("reports/games/roulette12_timer_details",$data);
        		break;
			case 'andarbahar':
        		$this->load->view("reports/games/mobandarbahar_details",$data);
        		break;
			case 'mobandarbahar':
        		$this->load->view("reports/games/mobandarbahar_details",$data);
        		break;			
		    case 'shan_mp':
				$result=$this->game_model->gameDetails($handId,$gameName);
				$data['results']=$result;
				$this->load->view("games/shan/game/details",$data);
        		break;	
			case 'mobroulette12':
        		$this->load->view("reports/games/mobroulette12_details",$data);
        		break;	
		    case 'mobroulette36':
        		$this->load->view("reports/games/mobroulette36_details",$data);
        		break;	
		    case 'mobtriplechance':
        		$this->load->view("reports/games/mobtriplechance_details",$data);
        		break;	
		    case 'mob_american_roulette36':
        		$this->load->view("reports/games/mobvip36_details",$data);
        		break;
			case 'american_roulette36':
        		$this->load->view("reports/games/mobvip36_details",$data);
        		break;				
		     case 'mobroulette12_timer':
        		$this->load->view("reports/games/mobroulette12timer_details",$data);
        		break;										
		     case 'mobroulette36_timer':
        		$this->load->view("reports/games/mobroulette36timer_details",$data);
        		break;
			case 'mobamerican_roulette36_timer':
        		$this->load->view("reports/games/mobamericanroulette36timer_details",$data);
        		break;	
			case 'mobtriplechancetimer':
				$data['get'] = 'mobtriplechancetimer';
				$this->load->view("reports/games/mobtriplechancetimer_details",$data);
        		break;
			case 'triplechancetimer':
				$data['get'] = 'triplechancetimer';
				$this->load->view("reports/games/mobtriplechancetimer_details",$data);
        		break;
			case 'wintriplechancetimer':
				$data['get'] = 'wintriplechancetimer';
				$this->load->view("reports/games/mobtriplechancetimer_details",$data);
        		break;
			case 'mobslotreel5_china_t1':
			  	$this->load->view("reports/games/mobslotreel5_china_t1_details",$data);
        		break;	
			case 'mobslotreel5_pharaoh_t1':
			  	$this->load->view("reports/games/mobslotreel5_pharaoh_t1_details",$data);
        		break;	
			case 'mobslotreel5_pharaoh_t2':
			  	$this->load->view("reports/games/mobslotreel5_pharaoh_t2_details",$data);
        		break;				
			case 'baccarat':
			  	$this->load->view("reports/games/baccarat_details",$data);
        		break;																																															
			case 'mobbaccarat':
			  	$this->load->view("reports/games/mobbaccarat_details",$data);
        		break;
			case 'baccarattimer':
			  	$this->load->view("reports/games/baccarattimer_details",$data);
        		break;
			case 'mobbaccarattimer':
			  	$this->load->view("reports/games/mobbaccarattimer_details",$data);
        		break;
			case 'tinkuscratchcard5':
			  	$this->load->view("reports/games/tinkuscratchcard5_details",$data);
        		break;
			case 'slotreel5_nordic_t1':
				$data['get'] = 'slotreel5_nordic_t1';
			  	$this->load->view("reports/games/slotreel5_nordic_t1_details",$data);
        		break;
			case 'slotreel5_pharaoh_t2':
				$data['get'] = 'slotreel5_pharaoh_t2';
			  	$this->load->view("reports/games/slotreel5_nordic_t1_details",$data);
        		break;
			case 'horserace':
				$data['get'] = 'horserace';
			  	$this->load->view("reports/games/horserace_details",$data);
        		break;
			case 'horseracetimer':
				$data['get'] = 'horseracetimer';
			  	$this->load->view("reports/games/horserace_details",$data);
        		break;
			case 'mobhorseracetimer':
				$data['get'] = 'mobhorseracetimer';
			  	$this->load->view("reports/games/horserace_details",$data);
        		break;
			case 'mobandarbaharstraighttimer':
				$data['get'] = 'mobandarbaharstraighttimer';
			  	$this->load->view("reports/games/mobandarbaharstraighttimer",$data);
        		break;
			case 'andarbaharstraighttimer':
				$data['get'] = 'andarbaharstraighttimer';
			  	$this->load->view("reports/games/andarbaharstraighttimer",$data);
        		break;
			case 'spin2win_pro':
			  	$this->load->view("reports/games/mobspin2win_pro_details",$data);
        		break;
			case 'spin2win_protimer':
			  	$this->load->view("reports/games/mobspin2win_pro_details",$data);
        		break;
			case 'mobspin2win_pro':
			  	$this->load->view("reports/games/mobspin2win_pro_details",$data);
        		break;
			case 'mobspin2win_protimer':
			  	$this->load->view("reports/games/mobspin2win_pro_details",$data);
        		break;
			case 'mobslotreel5_nordic_t1':
			  	$this->load->view("reports/games/mobslotreel5_nordic_t1_details",$data);
        		break;	
			case 'mobslotreel5_nordic_t2':
			  	$this->load->view("reports/games/mobslotreel5_nordic_t2_details",$data);
        		break;
			case 'mobhorseracetimer':
			  	$this->load->view("reports/games/horseracetimer_details",$data);
        		break;
			case 'triplechanceprotimer':
			  	$this->load->view("reports/games/triplechanceprotimer_details",$data);
        		break;
			case 'tripledice':
			  	$this->load->view("reports/games/tripledice_details",$data);
        		break;
			case 'tripledicetimer':
			  	$this->load->view("reports/games/tripledice_details",$data);
        		break;
			case 'megawheel':
			  	$this->load->view("reports/games/megawheel_details",$data);
        		break;
			case 'megawheeltimer':
			  	$this->load->view("reports/games/megawheel_details",$data);
        		break;
			case 'winbigboss':
			  	$this->load->view("reports/games/winbigboss_details",$data);
        		break;
			case 'mobwinbigboss':
			  	$this->load->view("reports/games/winbigboss_details",$data);
				break;
			case 'triplemaza':
				$this->load->view("reports/games/triplemaza_details",$data);
			  	break;				
		}		
	}
	 
	public function multiplayer(){
		$this->load->view("reports/games/multiplayer_details",$data);
	}
	  
	
}

/* End of file gamedetails.php */
/* Location: ./application/controllers/games/poker/gamedetails.php */