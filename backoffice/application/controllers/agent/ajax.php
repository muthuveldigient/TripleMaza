<?php
/*
  Class Name	: Ajax
  Package Name  : User
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{
    
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
                    $this->load->model('agent/agent_model');	
        }
	
	public function showsubagents()
        {
            $ptid=trim($this->input->get('ptid',TRUE));
            $pid=trim($this->input->get('pid',TRUE));
            $partner_list=$this->agent_model->partnerlist($ptid,$pid);
            echo $partner_list;
        }
}
/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */