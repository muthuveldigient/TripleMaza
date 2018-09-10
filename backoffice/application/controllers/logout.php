<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends CI_Controller
{
        
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->library('session');
	}
    
	public function index($err = NULL)
	{
		/** tracking info */
		$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
		$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
		$arrTraking["ACTION_NAME"]  ="Logout";
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM1"]      ='logout';
		$arrTraking["CUSTOM2"]      =1;
		$this->db->insert("tracking",$arrTraking);
		
        $this->session->sess_destroy();
		redirect('login');
	}
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */