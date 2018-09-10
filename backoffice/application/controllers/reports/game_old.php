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
class Game extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
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
			}
			else
			{
					$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = 1;
			}
			
			 $userdata['USR_ID']=$USR_ID;
			 $userdata['USR_GRP_ID']=$USR_GRP_ID;
			 $userdata['USR_STATUS']=$USR_STATUS;
			 $searchdata['rdoSearch']='';
				
			if($USR_ID == ''){
					redirect('login');
			 }
			$this->load->model('agent/Agent_model');
			$this->load->model('user/Account_model');
			$this->load->model('common/common_model');
			$this->load->model('reports/report_model');
			$this->load->model('games/casino/game_model');
			
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
	
	public function history(){
	  
		//get all the static pages
		
		//general configuration
		$this->load->library('pagination');
		$config['base_url']	 = base_url()."reports/game/history/";
		$config['per_page']  = $this->config->item('limit'); 
		$start = $this->uri->segment(4,0);
		
		
		//get all the partner ids
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata); 
               
		
		if($this->input->get_post('keyword',TRUE)=="Search"){		
		
				$searchdata['username'] = $this->input->get_post('username',TRUE);
            	$searchdata['game'] = $this->input->get_post('gameName',TRUE);
				$searchdata['hand_id'] = $this->input->get_post('hand_id',TRUE);
				
                $searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		        $searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
				
				$user_id = $this->Account_model->getUserIdByName($searchdata['username']);
		        if($user_id != ''){
				  $searchdata['user_id'] = $user_id;
				}else{
                  $searchdata['user_id'] = '';
				}
				
			
				if($searchdata['game'] != ''){
					$ref_id = $this->game_model->geGameRefNobyGameId($searchdata['game']);
		        if($ref_id != ''){
				  $searchdata['ref_id'] = $ref_id;
				}else{
                  $searchdata['ref_id'] = '';
				}
				}else{
				  $searchdata['ref_id'] = '';
				}
	
		     
				$totCount = $this->report_model->getAllSearchGameCount($loggedInUsersPartnersId,$searchdata);
				
				$totPlayPoint = $this->report_model->getAllSearchGamePointsCount($loggedInUsersPartnersId,$searchdata,"BET_POINTS");
				$totWinPoint = $this->report_model->getAllSearchGamePointsCount($loggedInUsersPartnersId,$searchdata,"WIN_POINTS");
				$totRefundPoint = $this->report_model->getAllSearchGamePointsCount($loggedInUsersPartnersId,$searchdata,"REFUND_POINTS");
				
				$config['total_rows'] 	= $totCount;		
				$config['cur_page']     = $start;
				$this->pagination->initialize($config);	
				$data['username']  		= $this->input->get_post('username',TRUE);
				$data['game']      	= $this->input->get_post('game',TRUE);
				$data['hand_id']		= $this->input->get_post('hand_id',TRUE);
				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
				$data['results']	=	$this->report_model->getAllSearchGameInfo($loggedInUsersPartnersId,$searchdata,$config["per_page"],$start);
				$data['tot_users'] = $totCount;
				$data['totPlayPoint'] = $totPlayPoint;
				$data['totWinPoint'] = $totWinPoint;
				$data['totRefundPoint'] = $totRefundPoint;
				
				$data['pagination']   = $this->pagination->create_links('view');
		}else{
				
		}
		
				$data['games']=$this->game_model->getGamesDropDown();
				
				$this->load->view('reports/gamehistory',$data);   
		
		//$searchData['rdoSearch'] = "";
		//$this->load->view("user/search_users",$searchData);
	
	}
	
	
	public function user(){

		$user_id = base64_decode($this->uri->segment(4,0));
		
		//get all the partner ids
		$loggedInUsersPartnersId = $this->Agent_model->getAllChildIds($this->session->userdata); 
               
		if($this->input->get_post('keyword',TRUE)=="Search"){		
		
				$searchdata['username'] = $this->input->get_post('username',TRUE);
            	$searchdata['game'] = $this->input->get_post('gameName',TRUE);
				$searchdata['hand_id'] = $this->input->get_post('hand_id',TRUE);
				
                $searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		        $searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
				
				$user_id = $this->Account_model->getUserIdByName($searchdata['username']);
		        if($user_id != ''){
				  $searchdata['user_id'] = $user_id;
				}else{
                  $searchdata['user_id'] = '';
				}
				
			
				if($searchdata['game'] != ''){
					$ref_id = $this->game_model->geGameRefNobyGameId($searchdata['game']);
		        if($ref_id != ''){
				  $searchdata['ref_id'] = $ref_id;
				}else{
                  $searchdata['ref_id'] = '';
				}
				}else{
				  $searchdata['ref_id'] = '';
				}
				
			
		     
				$totCount = $this->report_model->getAllSearchUserGameCount($loggedInUsersPartnersId,$searchdata);
				
				$totPlayPoint = $this->report_model->getAllSearchUserGamePointsCount($loggedInUsersPartnersId,$searchdata,"BET_POINTS");
				$totWinPoint = $this->report_model->getAllSearchUserGamePointsCount($loggedInUsersPartnersId,$searchdata,"WIN_POINTS");
				$totRefundPoint = $this->report_model->getAllSearchUserGamePointsCount($loggedInUsersPartnersId,$searchdata,"REFUND_POINTS");
				
				$data['username']  		= $this->input->get_post('username',TRUE);
				$data['game']      	= $this->input->get_post('game',TRUE);
				$data['hand_id']		= $this->input->get_post('hand_id',TRUE);
				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
				$data['results']	=	$this->report_model->getAllSearchUserGameInfo($loggedInUsersPartnersId,$searchdata);
				$data['tot_users'] = $totCount;
				$data['totPlayPoint'] = $totPlayPoint;
				$data['totWinPoint'] = $totWinPoint;
				$data['totRefundPoint'] = $totRefundPoint;
				
		}else{
				
				$totCount = $this->report_model->getAllUserGameCount($user_id);
				
				$totPlayPoint = $this->report_model->getAllUserGamePlaySum($user_id,"BET_POINTS");
				$totWinPoint = $this->report_model->getAllUserGamePlaySum($user_id,"WIN_POINTS");
				$totRefundPoint = $this->report_model->getAllUserGamePlaySum($user_id,"REFUND_POINTS");
				
				$data['username']  		= $this->input->get_post('username',TRUE);
				$data['game']      	= $this->input->get_post('game',TRUE);
				$data['hand_id']		= $this->input->get_post('hand_id',TRUE);
				$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
				$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
				$data['results']	=	$this->report_model->getAllUserGameInfo($user_id);
				$data['tot_users'] = $totCount;
				$data['totPlayPoint'] = $totPlayPoint;
				$data['totWinPoint'] = $totWinPoint;
				$data['totRefundPoint'] = $totRefundPoint;
		}
		
				$data['games']=$this->game_model->getGamesDropDown();
				
				$this->load->view('reports/usergamehistory',$data);   
		
		//$searchData['rdoSearch'] = "";
		//$this->load->view("user/search_users",$searchData);
	
	
	
	}

            public function gameHandIdDetails(){
		$hand_id = $this->uri->segment(4,0);

		$data['results'] = $this->report_model->getParticularHandidGameInfo($hand_id);
		$tablerecords    = $this->report_model->getParticularHandidGameInfo($hand_id);
                $decode_playdata = json_decode($tablerecords[0]->PLAY_DATA);
                $data['game'] = $decode_playdata->oddnEvenResult->card->value;
                //print_r($data);die;
		$this->load->view('reports/gamepop',$data);                
            }
	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */