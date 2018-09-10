<?php

//error_reporting(E_ALL);
/*
  Class Name	: Payment
  Package Name  : Report
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Turnover extends CI_Controller{
    
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
			//player model
			
			$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			//$USR_STATUS = $_SESSION['partnerstatus'];
			$USR_STATUS = "2";
			$USR_PAR_ID = $this->session->userdata['partnerid'];
			$USR_GRP_ID = $this->session->userdata['groupid'];

			if($USR_STATUS!=1)
			{
                            $CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
                            $CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
                            $CBY = $USR_PAR_ID;
			}else{
                            $CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
                            $CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
                            $CBY = 1;
			}
			
			 $userdata['USR_ID']      =$USR_ID;
			 $userdata['USR_GRP_ID']  =$USR_GRP_ID;
			 $userdata['USR_STATUS']  =$USR_STATUS;
			 $searchdata['rdoSearch'] ='';
				
			if($USR_ID == ''){
                            redirect('login');
			}
			$this->load->model('agent/Agent_model');
			$this->load->model('user/Account_model');
			$this->load->model('common/common_model');
			$this->load->model('reports/report_model');
			$this->load->model('games/casino/game_model');
			
			if($this->common_model->authendicate() == '' )
			{
				$this->session->set_flashdata('message', 'Login to access the page');
				redirect();
			}
			
			$partner_id=$this->session->userdata['partnerid'];
			$data = array("id" => $partner_id);
			$amount['amt']=$this->common_model->getBalance($data);  
					
			$this->load->view("common/header",$amount);
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
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
	
     public function report(){
	   
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
                        $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$noOfRecords  = $this->report_model->getSelfTurnoverCount($data);	
			$nopOfRecords  = $this->report_model->getPartnersTurnoverCount($data);	
			$data["results"] = $this->report_model->getSelfTurnover($data);	
			$data["presults"] = $this->report_model->getPartnersTurnover($data);
		} 
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME'); 
		$data['totCount'] = $noOfRecords;
		$data['totPCount'] = $nopOfRecords;
		
		$this->load->view('reports/turnover',$data);  
	 }
	
	
      public function userreport(){
		 $partner_id = $this->uri->segment(4,0);
                 $self['partner_id'] = $this->uri->segment(4,0);
                 $self['START_DATE_TIME'] = $_REQUEST['sdate'];
                 $self['END_DATE_TIME'] = $_REQUEST['edate'];
                 	
/*		if($this->input->get_post('keyword',TRUE)=="Search"){
			
			$data['username']  	= $this->input->get_post('USERN_NAME',TRUE);
			
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['user_id'] = $user_id;
				}else{
				  $data['user_id'] = '';
				}
			}else{
			    $data['user_id'] = '';
			}
			
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);   
			
			$totCount       = $this->report_model->getAllUserTurnoverCount($partner_id,$data);
			$data['results']	= $this->report_model->getAllUserTurnover($partner_id,$data);
			$data['tot_users']      = $totCount;
		}else{
*/
                        $data['detail'] =  $this->report_model->getSelfPartnerTurnover($self);	
                        //print_r($data['detail']);die;
			$totCount       	= $this->report_model->getAllUserTurnoverCount($partner_id,$self);
			$data['username']  	= $this->input->get_post('USERN_NAME',TRUE);
			
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['user_id'] = $user_id;
				}else{
				  $data['user_id'] = '';
				}
			}else{
			    $data['user_id'] = '';
			}
	
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
			
			$data['results']	= $this->report_model->getAllUserTurnover($partner_id,$self);
			$data['tot_users']      = $totCount;

		// }
		
			$this->load->view('reports/userturnover',$data);   
		//$searchData['rdoSearch'] = "";
		//$this->load->view("user/search_users",$searchData);
            }
			
	 /* public function game(){
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('searchData');
		}
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["GAME_ID"]     	= $this->input->post('gameName'); 
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
                        $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$noOfRecords  = $this->report_model->getAllGameTurnoverCount($data);	
			$data["results"] = $this->report_model->getAllGameTurnover($data);
                        //echo "<pre>";print_r($data);die;
			if(!empty($data["GAME_ID"]))
				$data["partnersList"] = $this->report_model->getPartnersData($data["GAME_ID"],$data['START_DATE_TIME'],$data['END_DATE_TIME']);
		} 
		$data['START_DATE_TIME']= $this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	= $this->input->post('END_DATE_TIME'); 
		$data['totCount']    = $noOfRecords;
		$data['totPCount']   = $nopOfRecords;
		$data['getGamesData']= $this->report_model->getGamesData();

		$this->load->view('reports/gameturnover',$data);  
	 } */
		
			
            
	public function gameHandIdDetails(){
		$hand_id = $this->uri->segment(4,0);

		$data['results'] = $this->report_model->getParticularHandidGameInfo($hand_id);
		$tablerecords    = $this->report_model->getParticularHandidGameInfo($hand_id);
                $decode_playdata = json_decode($tablerecords[0]->PLAY_DATA);
                $data['game'] = $decode_playdata->oddnEvenResult->card->value;
                //print_r($data);die;
		$this->load->view('reports/gamepop',$data);                
            }
			
	
		/*
	Function Name:gameturnover
	Purpose: This method handle with game turnover report
	*/
	
	public function game(){
		$data['gameTypes'] = $this->report_model->getAllGameTypes();
		$data['currencyTypes'] = $this->report_model->getAllCurrencyTypes();
		$data['rid'] = $this->input->get('rid');
		$this->load->view("reports/gameTOSearch",$data);
	}		
	
	
	/*
	Function Name:listgame
	Purpose: This method handle to list all games
	*/
	
	public function listgame(){
		$searchdata['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
		$searchdata['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
		$searchdata['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
		$searchdata['STATUS'] = $this->input->get_post('status',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		
		$config = array();
		$config["base_url"] = base_url()."reports/turnover/listgame";
		$config["per_page"] = 25;
		$config['suffix'] = '?chk=30&tableID='.$searchdata['TABLE_ID'].'&game_type='.$searchdata['GAME_TYPE'].'&currency_type='.$searchdata['CURRENCY_TYPE'].'&stakeAmt='.$searchdata['STAKE'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";	
	 	$config['cur_page']   = $this->uri->segment(4);
	   
		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$returnvalue = $this->report_model->getGamesTOCountBySearchCriteria($searchdata);
			$config['total_rows']=$returnvalue;
			
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$data['results'] = $this->report_model->getGamesTOBySearchCriteria($searchdata,$config["per_page"], $page);
			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['rdoSearch']=$searchdata['rdoSearch'];
			$data['START_DATE_TIME']=$this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']=$this->input->get_post('END_DATE_TIME',TRUE);
		    $data['gameTypes'] = $this->report_model->getAllGameTypes();

			$data['currencyTypes'] = $this->report_model->getAllCurrencyTypes();
			
			$data['rid'] = $this->input->get('rid');
			if(count($data)){
				$this->load->view("reports/gameTO", $data);
			}   
		}else{
				redirect('reports/gameTO?rid=20');
		}
	}
			
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */