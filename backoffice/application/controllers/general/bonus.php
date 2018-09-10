<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonus extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->authendication();
		$this->load->helper(array('url','form'));			
		$this->load->library(array('form_validation','session','pagination'));
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		
		//$USR_STATUS = $_SESSION['partnerstatus'];
		$USR_STATUS = "2";
		$USR_PAR_ID = $this->session->userdata['partnerid'];
		$USR_GRP_ID = $this->session->userdata['groupid'];
		
		if($USR_STATUS!=1) {
			$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = $USR_PAR_ID;
		} else {
			$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = 1;
		}
		$this->load->model('common/common_model');		
		$this->load->model('general/bonus_model');			
		$userdata['USR_ID']    =$USR_ID;
		$userdata['USR_GRP_ID']=$USR_GRP_ID;
		$userdata['USR_STATUS']=$USR_STATUS;
		$searchdata['rdoSearch']='';
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		$this->load->view("common/header",$amount);					
	}

	function authendication() {
		$userName = $this->session->userdata('adminusername');
		if($this->uri->uri_string() !== 'login' && !$userName) {
			$this->session->set_flashdata('message', 'Please login to access the page.');
        	redirect('login');
    	}		
	}	
	
	public function index() {

		$data["page_title"]    = "List Bonus Settings";
		if($this->input->post('frmSearch')) {
			$data["BONUS_TYPE_ID"] = $this->input->post('bonustype'); 
			$data["COIN_TYPE_ID"]  = $this->input->post('cointype'); 
			$data["bonusSettings"] = $this->bonus_model->getBonusSettingsData($data);			
			$data["searchResult"] = 1;				
		}	
		$data["getBonusTypes"] = $this->bonus_model->getBonusTypes();	
		$data["getCoinTypes"]  = $this->bonus_model->getCoinTypes();
		$this->load->view('bonus/index',$data);		
	}
	
	public function addBonus() {	
		if($this->input->post('frmSubmit')) {			
			$addBonusInfo["BONUS_TYPE_ID"] = $this->input->post('bonustype');	
			$addBonusInfo["COIN_TYPE_ID"]  = $this->input->post('cointype');
			$addBonusInfo["VALUE"]         = $this->input->post('value');			
			$addBonusInfo["STATUS"]        = $this->input->post('status');
			
			$addBonusInfo = $this->bonus_model->addBonusInfo($addBonusInfo);	
			$this->session->set_flashdata('message', 'Bonus created successfully.');
			redirect("general/bonus/index?rid=46");							
		} else {
			$data["getBonusTypes"] = $this->bonus_model->getBonusTypes();	
			$data["getCoinTypes"]  = $this->bonus_model->getCoinTypes();
			$this->load->view('bonus/addbonus',$data);		
		}		
	}
	
}