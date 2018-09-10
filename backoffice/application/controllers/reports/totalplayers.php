<?php
/*
  Class Name	: Game
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Sivakumar
  Date of Modify: April 02 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Totalplayers extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
	        $this->load->helper('url');
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->model('reports/report_model');	
    }
	
	/*
	Function Name: totalplayers
	Purpose: This method handle the total players played in a game
	*/
	
	public function totalplayersDetails(){
		$searchdata['d_tid'] 	  = $this->uri->segment(4, 0);
		$searchdata['start_date'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['end_date']   = $this->input->get_post('END_DATE_TIME',TRUE);

		$data['results']=$this->report_model->getAllPlayers($searchdata);

		$this->load->view("reports/playersList", $data);
		
	}
	 
	  
	
}

/* End of file gamedetails.php */
/* Location: ./application/controllers/games/poker/gamedetails.php */