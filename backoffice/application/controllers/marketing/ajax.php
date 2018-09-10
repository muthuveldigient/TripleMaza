<?php
//error_reporting(E_ALL);
/*
  Class Name	: Ajax
  Package Name  : Marketing
  Purpose       : Controller all the Ajax functionalitys related to Campaign
  Auther 	    : Arun
  Date of create: Sep 20 2013

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
			$this->load->model('marketing/campaign_model');	
			
			//player model
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		
		//if needed
	}
   
       function generateCode(){
           $formdata = $this->input->get();
           $camp = $formdata['camtype'];           
           $campe=substr($camp,0,3);
           $campf=rand(11111,99999);
           $gen=$campe.'-'.$campf;
           echo $gen;
       }
       
       function generateUrl(){
           $formdata = $this->input->get();

           $base = base_url();
           $sel = $formdata['select'];
           $par = $formdata['partn'];
           $cam = $formdata['camcode'];
           $urlink=$base.$sel.'/'.$par.'/'.$cam;
           echo $urlink;
       } 
        
}?>        