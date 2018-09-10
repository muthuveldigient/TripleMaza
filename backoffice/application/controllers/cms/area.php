<?php
/*
  Class Name	: Area
  Package Name  : CMS
  Purpose       : Controll the iframes
  Auther 	: Arun
  Date of create: Oct 31 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Area extends CI_Controller{
    
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
		$this->load->model('cms/cms_model');
		$this->load->model('common/common_model');
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		$this->load->view("common/header",$amount);
		$this->load->library('commonfunction');
		$this->load->library('assignroles');
			
        }
        
	public function index()
	{
		
		$this->load->view('cms/areaview');   
	
	}

}
?>
