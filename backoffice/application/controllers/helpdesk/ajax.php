<?php
//error_reporting(E_ALL);
/*
  Class Name	: Ajax
  Package Name  : Helpdesk
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Arun
  Date of create: DEC 04 2013

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
			$this->load->model('user/Account_model');	
			$this->load->model('agent/Agent_model');	
			
			//player model
    }


	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		
		//if needed
	}//EO: index function


        
    public function active($trackingid,$pageNo,$statusType){
		if($trackingid != ''){
        	$this->Account_model->activeIpaddress($trackingid,1,$statusType);
		}
		echo $pageNo;die;
	}
	
	public function deactive($trackingid,$pageNo,$statusType){
		if($trackingid != ''){
		   $this->Account_model->activeIpaddress($trackingid,2,$statusType);
		}
		echo $pageNo;die;
	}
}	