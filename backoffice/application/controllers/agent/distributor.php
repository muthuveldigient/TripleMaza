<?php
/*
  Class Name	: Distributor
  Package Name  : Agent
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Distributor extends CI_Controller{
    
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

		
		$this->load->model('agent/distributor_model');
		$this->load->model('common/common_model');
		
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);  
		$this->load->view("common/header",$amount);
		/*
		$data['mainmenu']=$this->common_model->generate_menu($userdata);
		$data['param1']='';
		$data['param']='';
		$this->load->view('common/sidebar',$data);*/
		
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
	
	public function create(){
	   
	   if($this->session->userdata['isownpartner']!=1){
				redirect('general/dashboard'); 
		}
		
	
		
		$data['PARTNER_USERNAME']=$this->input->get_post('PARTNER_USERNAME',TRUE);
		$data['PARTNER_PASSWORD']=$this->input->get_post('PARTNER_PASSWORD',TRUE);
		$data['PARTNER_TRANSACTION_PASSWORD']=$this->input->get_post('PARTNER_TRANSACTION_PASSWORD',TRUE);
		$data['PARTNER_DEPOSIT']=$this->input->get_post('PARTNER_DEPOSIT',TRUE);
		$data['PARTNER_COMMISSION_TYPE']=$this->input->get_post('PARTNER_COMMISSION_TYPE',TRUE);
		$data['PARTNER_REVENUE_SHARE']=$this->input->get_post('PARTNER_REVENUE_SHARE',TRUE);
		$data['commisiontype']=$this->commonfunction->get_commission_type();
		$data['mdl_id']=$this->input->get_post('mdl_id',TRUE);
		$data['mnu_id_pk']=$this->input->get_post('mnu_id_pk',TRUE);
		$data['sub_mnu_id_pk']=$this->input->get_post('sub_mnu_id_pk',TRUE);
		$data['sk_sub']=$this->input->get_post('sk_sub',TRUE);
		$data['sk_main']=$this->input->get_post('sk_main',TRUE);

		if($this->input->post('Submit',TRUE)){
			
		
			$result=$this->create_distributer($data);
			if($result){
				$data['error']=$result;
			}else{
				$data['PARTNER_USERNAME']='';
				$data['PARTNER_PASSWORD']='';
				$data['PARTNER_TRANSACTION_PASSWORD']='';
				$data['PARTNER_DEPOSIT']='';
				$data['PARTNER_COMMISSION_TYPE']='';
				$data['PARTNER_REVENUE_SHARE']='';
				$data['success']="Distributor Added Successfully";
			  }
          }
				
		$data['commisiontype']	= $this->commonfunction->get_commission_type();
		$data['mainmenu']		= $this->assignroles->getmainmenu($this->session->userdata,1);
		$data['USR_ID']=$USR_ID;
		$data['USR_GRP_ID']=$USR_GRP_ID;
		$data['USR_STATUS']=$USR_STATUS;
		
   		foreach($data['mainmenu'] as $mmenu){
			$data['submenu'][$mmenu->Mid]=$this->assignroles->getsubmenu($this->session->userdata,$mmenu->Mid);
			foreach($data['submenu'][$mmenu->Mid] as $sopt){
				$data['suboptmenutotl'][$sopt->Sid]=$this->assignroles->getsubmenuoptlistvalue($sopt->Sid);
				foreach($data['submenu'][$mmenu->Mid] as $sopt){
					$data['suboptmenu'][$sopt->Sid]=$this->assignroles->getsubmenuoptlist($this->session->userdata,$sopt->Sid);
				}
			}
		}							
		
		$this->load->view('agent/distributor/add-distributor',$data);  
	
	}
	
	public function create_distributer($formdata,$result = NULL)
	{
		
		$result	=  $this->distributor_model->addDistributor($formdata,$this->session->userdata);
	 	return $result;
	}
	
	public function view(){
	   		
            $totalpages=$this->distributor_model->getDistributorsCount();
            $config["base_url"] = base_url()."admin_home/index/";
            $config['per_page'] = $this->config->item('limit');
            $config["uri_segment"] = 3;
            $config['total_rows']=$totalpages;
            //$config['suffix'] ='?'.http_build_query($_GET, '', "&");
			if($this->input->post()){
			$config['suffix'] ='?p=vdisl&'.http_build_query($this->input->post(), '', "&");
			}
			else{
			$config['suffix'] ='?p=vdisl&'.http_build_query($this->input->get(), '', "&");
			}
            $config['first_url'] = $config['base_url'].$config['suffix'];
            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $data['page']=$page;
            $data['results'] = $this->distributor_model->getAllDistributors($config["per_page"], $page);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('agent/distributor/viewdistributors',$data);  
	}
	
	
	public function deactive($partnerid){
      
		 $this->common_model->deactivepartner($partnerid);
	}
	
	
	public function active($partnerid){
	
           $this->common_model->activepartner($partnerid);
	}
	
	public function detail(){

		$data['chk']=$this->input->get_post('chk',TRUE);
		$data['id']=base64_decode($this->uri->segment(4));
		
		
		$data['USR_ID']=$USR_ID;
		$data['USR_GRP_ID']=$USR_GRP_ID;
		$data['USR_STATUS']=$USR_STATUS;
		$data['details']=$this->distributor_model->getDistributerDetailsById($data);
		$data['mainmenu']=$this->assignroles->getmainmenu($this->session->userdata,0);
		
		foreach($data['mainmenu'] as $mmenu){
			$data['submenu'][$mmenu->Mid]=$this->assignroles->getsubmenu($this->session->userdata,$mmenu->Mid);
			foreach($data['submenu'][$mmenu->Mid] as $sopt){
				$data['suboptmenutotl'][$sopt->Sid]=$this->assignroles->getsubmenuoptlistvalue($sopt->Sid);
				foreach($data['submenu'][$mmenu->Mid] as $sopt){
					$data['suboptmenu'][$sopt->Sid]=$this->assignroles->getsubmenuoptlist($this->session->userdata,$sopt->Sid);
				}
			}
		}

        $data['commissiontype']=$this->commonfunction->get_commission_type();
        $data['f']=$this->input->get_post('f',TRUE);
        
		$data['cash']=$this->common_model->getBalance($data);
        $this->load->view("agent/distributor/distributor-details",$data);
	
	}
	
	public function edit(){
	
            $data['chk']=$this->input->get_post('chk',TRUE);
            $data['id']=base64_decode($this->uri->segment(5));
            //$data['f']=$this->input->get_post('f',TRUE);
			if($this->session->userdata['isownpartner']!=1){
			$data['error']="You not have Edit permission";
			$data['f']='';
			}
			else{
			$data['f']=$this->uri->segment(4);
			}
            $data['PARTNER_COMMISSION_TYPE']=$this->input->get_post('PARTNER_COMMISSION_TYPE',TRUE);
            if($this->input->post('submit',TRUE)){
			$data['formdata']=$this->input->post();
            $data['PARTNER_USERNAME']=$this->input->get_post('PARTNER_USERNAME',TRUE);
            $data['PARTNER_PASSWORD']=$this->input->get_post('PARTNER_PASSWORD',TRUE);
            $data['PARTNER_TRANSACTION_PASSWORD']=$this->input->get_post('PARTNER_TRANSACTION_PASSWORD',TRUE);
            $data['PARTNER_COMMISSION_TYPE']=$this->input->get_post('PARTNER_COMMISSION_TYPE',TRUE);
            $data['PARTNER_REVENUE_SHARE']=$this->input->get_post('PARTNER_REVENUE_SHARE',TRUE);
            $data['mdl_id']=$this->input->get_post('mdl_id',TRUE);
            $data['mnu_id_pk']=$this->input->get_post('mnu_id_pk',TRUE);
            $data['sub_mnu_id_pk']=$this->input->get_post('sub_mnu_id_pk',TRUE);
            $data['sk_sub']=$this->input->get_post('sk_sub',TRUE);
            $data['sk_main']=$this->input->get_post('sk_main',TRUE);
            $data['PARTNER_ID']=$this->input->get_post('PARTNER_ID',TRUE);
            $data['cash']=$this->input->get_post('cash',TRUE);
            $data['comment']=$this->input->get_post('comment',TRUE);
            $data['edit_flag']=$this->input->get_post('edit_flag',TRUE);
            $retval=$this->distributor_model->edit_distributer($data);
            if($retval){
            $data['error']=$retval;
            }					
            else{
            $data['success']="Successfully Updated";
            }
            $data['f']='';
            }
			$data['USR_ID']=$USR_ID;
			$data['USR_GRP_ID']=$USR_GRP_ID;
			$data['USR_STATUS']=$USR_STATUS;

            $data['details']=$this->distributor_model->getDistributerDetailsById($data);
            $data['mainmenu']=$this->assignroles->getmainmenu($this->session->userdata,0);
            foreach($data['mainmenu'] as $mmenu){
            $data['submenu'][$mmenu->Mid]=$this->assignroles->getsubmenu($this->session->userdata,$mmenu->Mid);
                foreach($data['submenu'][$mmenu->Mid] as $sopt){
                $data['suboptmenutotl'][$sopt->Sid]=$this->assignroles->getsubmenuoptlistvalue($sopt->Sid);
                foreach($data['submenu'][$mmenu->Mid] as $sopt){
                $data['suboptmenu'][$sopt->Sid]=$this->assignroles->getsubmenuoptlist($this->session->userdata,$sopt->Sid);
                }
                }
            }

            $data['commissiontype']=$this->commonfunction->get_commission_type();
            $data['cash']=$this->common_model->getBalance($data);

            $this->load->view("agent/distributor/distributor-details",$data);
	
	}
}

/* End of file distributor.php */
/* Location: ./application/controllers/agent/distributor.php */