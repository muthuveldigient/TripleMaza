<?php
//error_reporting(E_ALL);
/*
  Class Name	: Pay
  Package Name  : Cashier
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pay extends CI_Controller{
    
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

		$this->load->model('cms/cms_model');
		$this->load->model('common/common_model');
		$this->load->model('cashier/cashier_model');
		$this->load->model('agent/Agent_model');
		$this->load->model('user/Account_model');                
		
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		
		$this->load->view("common/header",$amount);
		$this->load->library('commonfunction');
		$this->load->library('assignroles');
			
			
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		//if needed
	}//EO: index function
	
	public function in_old(){
		//get all the static pages
		 $agentInfo = $this->Account_Model->getAllPartnerIds($this->session->userdata);
	
		
		$this->load->view('cashier/payin',$data);   
	}
	
	public function in(){
                 $data = array();
                if($this->input->get_post('keyword',TRUE)=="Search"){	
                    
			//general configuration
			/* $config['base_url'] 	 = base_url()."cashier/pay/in/";
			$config['per_page']     = $this->config->item('limit'); 
			$start = $this->uri->segment(4,0);
			$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$searchdata['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			$searchdata['PROCESSED_BY'] = $this->input->get_post('PROCESSED_BY',TRUE);                    
			$searchdata['AGENT_LIST'] =  $this->input->get_post('AGENT_LIST',TRUE);
						
			$totCount = $this->cashier_model->get_record_count($searchdata);  */
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$data['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			
                        $data['results'] = $this->cashier_model->getAllPayinSearchInfo($data);

                }
                
                 $this->load->view('cashier/viewledgerinpointsdetails',$data);

	}
        
        public function inpointsdetail(){
   		$userid = $this->uri->segment(4, 0);
		
                $data = array();
                if($this->input->get_post('keyword',TRUE)=="Search"){	
                $data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		$data['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			
                $data['results'] = $this->cashier_model->getInPointsSearchUsersDetail($data);    
                
                $this->load->view("cashier/inpointsdetails",$data);
                }else{
                $data['results'] = $this->cashier_model->getInpointsUsersDetails($userid);
                    
                $this->load->view("cashier/inpointsdetails",$data);
                }
        }
	
	public function out(){
		
                 $data = array();
                if($this->input->get_post('keyword',TRUE)=="Search"){	
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$data['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			
                        $data['results'] = $this->cashier_model->getAllPayoutSearchInfo($data);                    
                }
            $this->load->view('cashier/viewledgeroutpointsdetails',$data);
	}
        
        public function outpointsdetail(){
   		$userid = $this->uri->segment(4, 0);
		
                $data = array();
                if($this->input->get_post('keyword',TRUE)=="Search"){	
                $data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
		$data['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			
                $data['results'] = $this->cashier_model->getOutPointsSearchUsersDetail($data);    
                
                $this->load->view("cashier/outpointsdetails",$data);
                }else{
                $data['results'] = $this->cashier_model->getOutPointsUsersDetails($userid);
                    
                $this->load->view("cashier/outpointsdetails",$data);
                }
        }   
        
	public function ledger(){
		
		 	$data = array();
            	$name = $this->uri->segment(4, 0);
                if($name != '0'){

					$data['USERNAME'] = $name;
                    $data['START_DATE_TIME'] = "";
                    $data['END_DATE_TIME'] = "";
					if($data['USERNAME'] != ''){
						$user_id = $this->Account_model->getUserIdByName($data['USERNAME']);
					if($user_id != ''){
						$data['USER_ID'] = $user_id;
					}else{
						$data['USER_ID'] = '00';
					}
					}			
					$data['results'] = $this->cashier_model->getAllLedgerSearchInfo($data); 
                }
		if($this->input->get_post('keyword',TRUE)=="Search"){	
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$data['USERNAME'] = $this->input->get_post('USERNAME',TRUE);
			$data['TRANSID'] = $this->input->get_post('TRANSID',TRUE);
			
			if($data['USERNAME'] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['USERNAME']);
				if($user_id != ''){
				  $data['USER_ID'] = $user_id;
				}else{
				  $data['USER_ID'] = '00';
				}
			}else{
			    $data['USER_ID'] = '';
			}
			$data['results'] = $this->cashier_model->getAllLedgerSearchInfo($data);      
		}
		$this->load->view('cashier/viewledger',$data);
	}        
	

	public function file(){
		$pageId = $this->uri->segment(4, 0);
		$formdata=$this->input->post();
		if($this->input->post('Submit',TRUE)){
		//After submit
		 $updatePage = $this->cms_model->updatePage($formdata);		
  		 if($updatePage  == 1){
		 	$data['msg'] = "Page Sucessfully Updated";
		  }
		}
		
		$data['langs'] = $this->cms_model->getAllLanguages();
		$data['menus'] = $this->cms_model->getAllMenu();
		$data['page']  = $this->cms_model->getPageInfoById($pageId);
		
		$this->load->view("cms/pages/edit",$data);
		
	}
	
	public function delete(){
		$page_id = $this->uri->segment(4, 0);
		if($page_id != ''){
		   $this->cms_model->deletePage($page_id);
		   $data['msg'] = 'Page Successfully Deleted';
		}
		redirect("cms/pages/view", $data);	
	}//EO: delete function
	
}

/* End of file pages.php */
/* Location: ./application/controllers/cms/pages.php */