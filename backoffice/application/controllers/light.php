<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Light extends CI_Controller {

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
   		$this->load->helper('url');
   		$this->load->helper('functions');
   		$this->load->library('session');
   		$this->load->database();
   		$this->load->model('common/common_model');
    	$partner_id=$this->session->userdata['partnerid'];
    	$data = array("id" => $partner_id);
    	$amount['amt']=$this->common_model->getBalance($data); 
   	
		$this->load->view("common/header",$amount);
   		$this->load->library('commonfunction');
 	}
 
	function index(){
  		$partnertransaction_password=$_REQUEST['partnertransaction_password'];  
  		echo $this->uri->segment(2);die;
  		$this->common_model->lighttrans($data);
  		$this->load->view('agent/myagent/create');	
  	}
  
	function AdjustPoints(){
  		$loc = $_REQUEST['currentUrl'];
  		$partnertransaction_password=$_REQUEST['partnertransaction_password'];  
  		$subrole = $this->uri->segment(2);
  		if($_GET['userid']==""){
  			$this->common_model->lighttrans($data,$subrole,$loc);
  		}else{
  			$uid = $_GET['userid'];
  			$this->common_model->lighttransaction($data,$subrole,$loc,$uid);
  		}
  	//$this->load->view('agent/myagent/create');	
  	}
  
	function GameHistory(){
  		$loc = $_REQUEST['currentUrl'];
  		$partnertransaction_password=$_REQUEST['partnertransaction_password'];  
  		$subrole = $this->uri->segment(2);
  		$this->common_model->lighttrans($data,$subrole,$loc);
  		//$this->load->view('agent/myagent/create');  
  	}
  
  	public function getBackofficeConfigData() {
		//$getTableData = $this->game_model->getGameTableName($gameID);
		//$data["getGameName"]   = $getTableData->MINIGAMES_NAME;
		$data["gameTableName"] = "config";
    	$data["results"] = $this->common_model->getDetailsInGameSettings($data["gameTableName"]);
    	//$data["mainGameID"]    = $gameID;
		//$data["gamePlayersNow"]= $this->game_model->getCurrentGamePlayers($data["getGameName"]);
		$this->load->view("common/backofficeconfigdata",$data);
  	}
  
    public function updateBackofficeConfigData(){
		if($this->input->post('save')) {
        	$gameConfigData = $this->input->post(); 
			$gameConfigArray= array();
			foreach($gameConfigData as $configKey=>$configData) {
            	$gameSettingsData["CONFIG_ID"] = $configKey;
                $gameSettingsData["VALUE"]     = $configData;
                $this->common_model->updateBackOfficeConfigData($gameSettingsData);
			}//foreach ends here
            $data["gameTableName"] = "config";
            $data["results"] = $this->common_model->getDetailsInGameSettings($data["gameTableName"]);
			$this->session->set_flashdata('message', 'Config saved successfully.');
			redirect("light/getBackofficeConfigData",$data);	
		}
	}
}	?>