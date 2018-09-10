<?php
//error_reporting(E_ALL);
/*
  Class Name	: Payment
  Package Name  : Report
  Purpose       : Controller for game history
  Auther 	    : Sivakumar
  Date of create: July 07 2014

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_game_history_details extends CI_Controller{
    
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

			if($USR_STATUS!=1)
			{
					//$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = $USR_PAR_ID;
			}
			else
			{
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
			$this->load->model('reports/agentgamehistory_model');
			
			if($this->common_model->authendicate() == '' )
			{
				$this->session->set_flashdata('message', 'Login to access the page');
				redirect();
			}
			$partner_id=$this->session->userdata['partnerid'];
			$data = array("id" => $partner_id);
			$amount['amt']=$this->common_model->getBalance($data);  
					
			$this->load->library('commonfunction');
			$this->load->library('assignroles');
			
			//player model
    }
	 
	 public function view(){
	 	$handId = $this->uri->segment(4, 0);
		$gameName = $this->agentgamehistory_model->getGameNameByMinigamesId($handId);
		$data['handId'] = $handId;
		$data['gameName'] = $gameName;	
		
		//$playGroupIdInfo = $this->agentgamehistory_model->getPlayGroupIdByHandId($handId);
		//$playGroupId     = $playGroupIdInfo[0]->PLAY_GROUP_ID;
		$playGroupId=$handId;
		
		
		
		
		if($playGroupId != '')	
		redirect('games/shan/gamedetails/details/'.$playGroupId.'/shan_mp?rid=45');
		
		/*switch ($gameName) {
    		case 'rummy':
        		$this->load->view("reports/agent_gamehistorydetails",$data);
        		break;
		    case 1:
    		    echo "i equals 1";
        		break;
		    case 2:
    		    echo "i equals 2";
        		break;
			case 'shan_mp':
			
        		$this->load->view("reports/agent_gamehistorydetails",$data);
        		break;	
		}	*/	
	 }
	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */