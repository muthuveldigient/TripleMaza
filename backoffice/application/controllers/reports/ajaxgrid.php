<?php
//error_reporting(E_ALL);

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajaxgrid extends CI_Controller{
    
    function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->helper(array('url','form','functions'));	
		$this->load->library('session');
		$this->load->database();
		$this->load->library('pagination');
		//player model
		
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		//$USR_STATUS = $_SESSION['partnerstatus'];
		$USR_STATUS = "2";
		$USR_PAR_ID = $this->session->userdata['partnerid'];
		//$USR_GRP_ID = $this->session->userdata['groupid'];

		if($USR_STATUS!=1){
			//$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = $USR_PAR_ID;
		}else{
			//$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = 1;
		}
		
		 $userdata['USR_ID']=$USR_ID;
		// $userdata['USR_GRP_ID']=$USR_GRP_ID;
		 $userdata['USR_STATUS']=$USR_STATUS;
		 $searchdata['rdoSearch']='';
			
		if($USR_ID == ''){
				redirect('login');
		}

		$this->load->model('common/common_model');
		$this->load->model('partners/partner_model');
		$this->load->model('reports/turnover_report_manager_model');
		$this->load->model('reports/turnover_report_model');
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
				
		$this->load->view("common/header",$amount);
		$this->load->library('commonfunction');
		$this->load->library('assignroles');
		//player model
	}



 public function gameinfo(){
	
	$SESSION_PARTNER_TYPE = $this->session->userdata('partnertypeid'); 
	$data["SESSION_PARTNER_TYPE"] = $SESSION_PARTNER_TYPE;
	$data['PARTNER_ID'] = $this->session->userdata('partnerid');
	$response = array();
	$data['rid'] = $this->input->get_post('rid',TRUE);
	if($this->input->get_post('keyword',TRUE)=="Search"){
		$data['AGENT_LIST']		= $this->input->get_post('AGENT_LIST',TRUE);
		$data['GAMES_TYPE']		= $this->input->get_post('GAMES_TYPE',TRUE);
		$data['PARTNER_TYPE'] 	= $this->input->get_post('PARTNER_TYPE',TRUE);
		$START_DATE_TIME		= $this->input->get_post('START_DATE_TIME',TRUE);
		$END_DATE_TIME 			= $this->input->get_post('END_DATE_TIME',TRUE);
		
		//$this->session->set_userdata(array('report_searchData'=>$data));
		if(!empty($START_DATE_TIME) && !empty($END_DATE_TIME) ){
			$data['START_DATE_TIME']	= date('Y-m-d H:i:s',strtotime($START_DATE_TIME));
			$data['END_DATE_TIME']		= date('Y-m-d H:i:s',strtotime($END_DATE_TIME));
		}
	}
	$data['GROUP_BY']='GAME_ID';
	
	switch($SESSION_PARTNER_TYPE){
		case 11:
			$response = $this->turnover_report_manager_model->manageMainAgentTurnover($data);
			break;
		case 12:
			$response = $this->turnover_report_manager_model->manageDistributorTurnover($data);
			break;
		case 13:
			$response = $this->turnover_report_manager_model->manageSubDistributorTurnover($data);
			break;
		case 14:
			$response = $this->turnover_report_manager_model->manageAgentTurnover($data);
			break;
		case 15: 
			$response = $this->turnover_report_manager_model->manageSuperDistributorTurnover($data);
			break;
		default :
			$response = $this->turnover_report_manager_model->managePartnersTurnover($data);
			break;		
	}
	
	foreach($response as $key => $row){
		$volume[$key]  = $row->totbet;
	}
	
	$response[]= array_multisort($volume, SORT_DESC, $response);
	array_pop($response);
	@$page = $this->input->get_post('page',TRUE); 
	@$limit = $this->input->get_post('rows',TRUE); 
	
	if(@$this->input->get_post('sord',TRUE)=='asc'){
		@$sord=SORT_ASC;
	}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
		@$sord=SORT_DESC;
	} 
	$sidx = $this->input->get_post('sidx',TRUE); 
	if(!$sidx) $sidx =1; 

	if($sidx!='1'){
		if($this->input->get_post('sord',TRUE)=='asc'){
			//$arrs1 = $this->array_sort($response, $sidx, SORT_ASC);
			$arrs1 = $response;
		}elseif($this->input->get_post('sord',TRUE)=='desc'){
			//$arrs1 = $this->array_sort($response, $sidx, SORT_DESC);
			$arrs1 = $response;
		}
	}else{
		$arrs1 = $response;
	}
	$response = $arrs1;
	$et = ">";
	$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
	$xmlres .= "<rows>";
	$xmlres .= "<page>".$page."</page>";
	$xmlres .= "<total>".@$total_pages."</total>";
	$xmlres .= "<records>".@$count."</records>";
	foreach($response as $res ){
		$xmlres .= "<row id='".(!empty($res->AGENT_ID)?$res->AGENT_ID:'')."'>";			
		$xmlres .= "<cell><![CDATA[". (!empty($res->GAME_DESCRIPTION)?$res->GAME_DESCRIPTION:'')."]]></cell>";
		$xmlres .= "<cell>". (!empty($res->totbet)?$res->totbet:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->totwin)?$res->totwin:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->MARGIN)?$res->MARGIN:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->NET)?$res->NET:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->MARGIN_PERCENTAGE)?$res->MARGIN_PERCENTAGE:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->PARTNER_COMMISSION_TYPE)?$res->PARTNER_COMMISSION_TYPE:'0.00') ."</cell>";
		$xmlres .= "</row>";
	}
	$xmlres .= "</rows>";	
	echo	$xmlres;exit;
	//echo '<pre>';print_r($data);exit;
 }
 
 public function info1(){
	
	$SESSION_PARTNER_TYPE = $this->session->userdata('partnertypeid'); 
	$data["SESSION_PARTNER_TYPE"] = $SESSION_PARTNER_TYPE;
	$data['PARTNER_ID'] = $this->session->userdata('partnerid');
	$response = array();
	$data['rid'] = $this->input->get_post('rid',TRUE);
	if($this->input->get_post('keyword',TRUE)=="Search"){
		$data['AGENT_LIST']		= $this->input->get_post('AGENT_LIST',TRUE);
		$data['GAMES_TYPE']		= $this->input->get_post('GAMES_TYPE',TRUE);
		$data['PARTNER_TYPE'] 	= $this->input->get_post('PARTNER_TYPE',TRUE);
		$START_DATE_TIME		= $this->input->get_post('START_DATE_TIME',TRUE);
		$END_DATE_TIME 			= $this->input->get_post('END_DATE_TIME',TRUE);
		
		//$this->session->set_userdata(array('report_searchData'=>$data));
		if(!empty($START_DATE_TIME) && !empty($END_DATE_TIME) ){
			$data['START_DATE_TIME']	= date('Y-m-d H:i:s',strtotime($START_DATE_TIME));
			$data['END_DATE_TIME']		= date('Y-m-d H:i:s',strtotime($END_DATE_TIME));
		}
	}
	$data['GROUP_BY']='GAME_ID';
	
	switch($SESSION_PARTNER_TYPE){
		case 11:
			$response = $this->turnover_report_manager_model->manageMainAgentTurnover($data);
			break;
		case 12:
			$response = $this->turnover_report_manager_model->manageDistributorTurnover($data);
			break;
		case 13:
			$response = $this->turnover_report_manager_model->manageSubDistributorTurnover($data);
			break;
		case 14:
			$response = $this->turnover_report_manager_model->manageAgentTurnover($data);
			break;
		case 15: 
			$response = $this->turnover_report_manager_model->manageSuperDistributorTurnover($data);
			break;
		default :
			$response = $this->turnover_report_manager_model->managePartnersTurnover($data);
			break;		
	}
	
	foreach($response as $key => $row){
		$volume[$key]  = $row->totbet;
	}
	
	$response[]= array_multisort($volume, SORT_DESC, $response);
	array_pop($response);
	//echo '<pre>';print_r($response);exit;
	@$page = $this->input->get_post('page',TRUE); 
	@$limit = $this->input->get_post('rows',TRUE); 
	
	if(@$this->input->get_post('sord',TRUE)=='asc'){
		@$sord=SORT_ASC;
	}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
		@$sord=SORT_DESC;
	} 
	$sidx = $this->input->get_post('sidx',TRUE); 
	if(!$sidx) $sidx =1; 

	if($sidx!='1'){
		if($this->input->get_post('sord',TRUE)=='asc'){
			//$arrs1 = $this->array_sort($response, $sidx, SORT_ASC);
			$arrs1 = $response;
		}elseif($this->input->get_post('sord',TRUE)=='desc'){
			//$arrs1 = $this->array_sort($response, $sidx, SORT_DESC);
			$arrs1 = $response;
		}
	}else{
		$arrs1 = $response;
	}
	$response = $arrs1;
	
	//echo '<pre>';print_r($response);exit;
	$et = ">";
	$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
	$xmlres .= "<rows>";
	$xmlres .= "<page>".$page."</page>";
	$xmlres .= "<total>".@$total_pages."</total>";
	$xmlres .= "<records>".@$count."</records>";
	foreach($response as $res ){
		$xmlres .= "<row id='".(!empty($res->AGENT_ID)?$res->AGENT_ID:'')."'>";			
		//$xmlres .= "<cell><![CDATA[". (!empty($res->GAME_DESCRIPTION)?$res->GAME_DESCRIPTION:'')."]]></cell>";
		$xmlres .= "<cell>". (!empty($res->totbet)?$res->totbet:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->totwin)?$res->totwin:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->MARGIN)?$res->MARGIN:'0.00')."</cell>";
		$xmlres .= "<cell>". (!empty($res->NET)?$res->NET:'0.00')."</cell>";
		//$xmlres .= "<cell>". (!empty($res->MARGIN_PERCENTAGE)?$res->MARGIN_PERCENTAGE:'0.00')."</cell>";
		//$xmlres .= "<cell>". (!empty($res->PARTNER_COMMISSION_TYPE)?$res->PARTNER_COMMISSION_TYPE:'0.00') ."</cell>";
		$xmlres .= "</row>";
	}
	$xmlres .= "</rows>";	
	echo	$xmlres;exit;
	//echo '<pre>';print_r($data);exit;
 }
	
}