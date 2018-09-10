<?php
//error_reporting(E_ALL);
/*
  Class Name	: Payment
  Package Name  : Report
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
error_reporting(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Helpdesk extends CI_Controller{
    
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

		if($USR_STATUS!=1){
			$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
			$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
			$CBY = $USR_PAR_ID;
		}else{
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
	
		$this->load->model('user/Account_model');                
		$this->load->model('common/common_model');
		$this->load->model('partners/partner_model');
		$this->load->model('agent/Agent_model');
		$this->load->model('helpdesk/Helpdesk_Model');
		$this->load->model('reports/payment_Model');
		$this->load->model('games/shan/Game_model');
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
        
	public function index(){
		
		//if needed
	}//EO: index function


	public function shanwallet(){
		if($this->input->get('keyword',TRUE)=="Search"){
			$data["username"] 			=	trim($this->input->get('username')); 
			$data["ref_id"]    			= 	trim($this->input->get('ref_id')); 
			$data["playgroupid"]    	= 	trim($this->input->get('playgroupid'));
			$data["buyinreferrence_no"] = 	trim($this->input->get('buyinreferrence_no'));						
			$data['START_DATE_TIME']	= 	$this->input->get('START_DATE_TIME',TRUE);
		    $data['END_DATE_TIME'] 		= 	$this->input->get('END_DATE_TIME',TRUE);
			$data['SEARCH_LIMIT'] 		= 	$this->input->get('SEARCH_LIMIT',TRUE);
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
					$data['user_id'] = $user_id;
				}else{
					$data['user_id'] = '00';
				}
			}else{
			    $data['user_id'] = '';
			}
			if($data['game'] != ''){
				$this->load->model('games/casino/Game_model');
				$game_id = $this->Game_model->geGameRefNobyGameId($data['game']);
				if($game_id != ''){
					$data['game_id'] = $game_id;
				}else{
					$data['game_id'] = '';
				}
			}else{
			    $data['game_id'] = '';
			}
			$noOfRecords  = $this->Helpdesk_Model->getAllWalletTransactionCount($data);	
		}elseif($this->input->get_post('keyword',TRUE)=="Search"){		
			$data["username"] 			=	trim($this->input->post('username')); 
			$data["ref_id"]    			= 	trim($this->input->post('ref_id')); 
			$data["playgroupid"]    	= 	trim($this->input->post('playgroupid'));
			$data["buyinreferrence_no"] = 	trim($this->input->post('buyinreferrence_no'));
			$data['START_DATE_TIME']	= 	$this->input->get_post('START_DATE_TIME',TRUE);
		    $data['END_DATE_TIME'] 		= 	$this->input->get_post('END_DATE_TIME',TRUE);
			$data['SEARCH_LIMIT'] 		= 	$this->input->get_post('SEARCH_LIMIT',TRUE);			
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
					$data['user_id'] = $user_id;
				}else{
					$data['user_id'] = '00';
				}
			}else{
			    $data['user_id'] = '';
			}
			if($data['game'] != ''){
				$this->load->model('games/casino/Game_model');
				$game_id = $this->Game_model->geGameRefNobyGameId($data['game']);
				if($game_id != ''){
					$data['game_id'] = $game_id;
				}else{
					$data['game_id'] = '';
				}
			}else{
			    $data['game_id'] = '';
			}
			//$this->session->set_userdata(array('searchData'=>$data));
			$noOfRecords  = $this->Helpdesk_Model->getAllWalletTransactionCount($data);			
		}else{
			//$noOfRecords  = $this->Helpdesk_Model->getAllTransactionCount();			
		}
		/* Set the config parameters */
		$config['base_url']   =	base_url()."helpdesk/helpdesk/shanwallet";
		$config['per_page']   = $this->config->item('limit'); 
		$config['cur_page']   = $this->uri->segment(4);
		$config['order_by']	  = "TRANSACTION_DATE";
		$config['sort_order'] = "asc";	
		$config['suffix']     = '?rid=61&username='.$data['username'].'&ref_id='.$data['ref_id'].'&SEARCH_LIMIT='.$data['SEARCH_LIMIT'].'&START_DATE_TIME='.$data['START_DATE_TIME'].'&END_DATE_TIME='.$data['END_DATE_TIME'].'&keyword=Search&playgroupid='.$data['playgroupid'].'&rid='.$this->input->get('rid');
		$config['first_url']  = $config['base_url'].$config['suffix'];

		if($this->input->get('keyword',TRUE)=="Search"){	
			$data['totalbet']	=	$this->Helpdesk_Model->getTotalWalletBet($data);
			$data['totaloss']   = 	$this->Helpdesk_Model->getTotalWalletLoss($data);
			$data['totalforcebet']   = 	$this->Helpdesk_Model->getTotalWalletForceBet($data);				
			$data['totalrake'] 	= 	$this->Helpdesk_Model->getTotalWalletRake($data);
			$data['totalwin'] 	= 	$this->Helpdesk_Model->getTotalWalletWin($data);
			$data["results"] 	= 	$this->Helpdesk_Model->getAllWalletTransaction($config,$data);
			//$data['sum']     	= 	$this->Helpdesk_Model->getWalletSumTransactionAmout($config,$data);	

		}elseif($this->input->get_post('keyword',TRUE)=="Search"){	
			$data['totalbet']	=	$this->Helpdesk_Model->getTotalWalletBet($data);
			$data['totaloss']   = 	$this->Helpdesk_Model->getTotalWalletLoss($data);
			$data['totalforcebet']   = 	$this->Helpdesk_Model->getTotalWalletForceBet($data);				
			$data['totalrake'] 	= 	$this->Helpdesk_Model->getTotalWalletRake($data);
			$data['totalwin'] 	= 	$this->Helpdesk_Model->getTotalWalletWin($data);
			$data["results"] 	= 	$this->Helpdesk_Model->getAllWalletTransaction($config,$data);
			//$data['sum']     	= 	$this->Helpdesk_Model->getWalletSumTransactionAmout($config,$data);	

		}else{
			//$data['results']	=	$this->Helpdesk_Model->getAllTransaction($config);	
			//$data['sum']        =   $this->Helpdesk_Model->getSumTransactionAmout($config);
		}
		$config['total_rows']   	= 	$noOfRecords;
		//$data['username']			=	trim($this->input->post('username')); 
		//$data['ref_id']				=	trim($this->input->post('ref_id'));
		//$data['amount']				=	trim($this->input->post('amount')); 		
		//$data['START_DATE_TIME']	=	$this->input->post('START_DATE_TIME'); 
		//$data['END_DATE_TIME']		=	$this->input->post('END_DATE_TIME'); 
		//get all payment transaction status
		$data['transaction_status'] =	$this->payment_Model->getAllPaymentStatus();
		$data['transaction_type'] 	= 	$this->payment_Model->getAllTransactionTypes();
		$data['totCount'] = $noOfRecords;
		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();
		$this->load->view('helpdesk/shanwallet',$data);  
	}                
	
	public function transactions(){
     
		if($this->input->post('reset')) {
			$this->session->unset_userdata('searchData');
		}
		
		if($this->input->get('start',TRUE) == 1){
			$this->session->unset_userdata('searchData');
		}
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["username"] 		= trim($this->input->post('username')); 
			$data["ref_id"]    		= trim($this->input->post('ref_id')); 
			$data["trans_status"]   = $this->input->post('trans_status'); 
			$data["trans_type"]   	= $this->input->post('trans_type'); 
			$data["trans_mode"]   	= $this->input->post('trans_mode'); 
			$data["game"]   		= $this->input->post('game'); 
			$data["amount"]   		= trim($this->input->post('amount')); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		    $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['SEARCH_LIMIT'] 	= $this->input->get_post('SEARCH_LIMIT',TRUE);
			if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['user_id'] = $user_id;
				}else{
				  $data['user_id'] = '00';
				}
			}else{
			    $data['user_id'] = '';
			}
			
			if($data['game'] != ''){
				$this->load->model('games/casino/Game_model');
				$game_id = $this->Game_model->geGameRefNobyGameId($data['game']);
				if($game_id != ''){
					$data['game_id'] = $game_id;
				}else{
					$data['game_id'] = '';
				}
			}else{
			    $data['game_id'] = '';
			}
			$this->session->set_userdata(array('searchData'=>$data));
			$noOfRecords  = $this->Helpdesk_Model->getAllTransactionCount($data);			
		}else{
			//$noOfRecords  = $this->Helpdesk_Model->getAllTransactionCount();			
		}
		/* Set the config parameters */
		$config['base_url']   = base_url()."helpdesk/helpdesk/transactions";
		$config['per_page']   = $this->config->item('limit'); 
		$config['cur_page']   = $this->uri->segment(4);
		$config['order_by']	  = "TRANSACTION_DATE";
		$config['sort_order'] = "asc";	
		$config['suffix']     = '?rid=86';
		
		if($this->input->get_post('keyword',TRUE)=="Search"){	
			$data["results"] = $this->Helpdesk_Model->getAllTransaction($config,$data);	
			$data['sum']     = $this->Helpdesk_Model->getSumTransactionAmout($config,$data);	
		}else if($this->session->userdata('searchData')) {
			$data = $this->session->userdata('searchData');
			$noOfRecords  = $this->Helpdesk_Model->getAllTransactionCount($data);	
			$data["results"] = $this->Helpdesk_Model->getAllTransaction($config,$data);
			$data['sum']     = $this->Helpdesk_Model->getSumTransactionAmout($config,$data);	
		}else{
			//$data['results']	=	$this->Helpdesk_Model->getAllTransaction($config);	
			//$data['sum']        =   $this->Helpdesk_Model->getSumTransactionAmout($config);
		}
		
		$config['total_rows'] 	= $noOfRecords;
		$data['username']		=	trim($this->input->post('username')); 
		$data['ref_id']			=	trim($this->input->post('ref_id'));
		$data['trans_status']	=	$this->input->post('trans_status');
		$data['trans_type']		=	$this->input->post('trans_type');
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME'); 
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME'); 
		$data['amount']			=	trim($this->input->post('amount')); 
		//get all payment transaction status
		$data['transaction_status'] = $this->payment_Model->getAllPaymentStatus();
		$data['transaction_type'] = $this->payment_Model->getAllTransactionTypes();
		$data['totCount'] = $noOfRecords;
		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();
		$this->load->view('helpdesk/transactions',$data);  
	}

	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */