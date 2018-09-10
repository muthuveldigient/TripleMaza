<?php
/*
  Class Name	: Myagent
  Package Name  : Agent
  Purpose       : Controll all the distributor related functionalities
  Auther 	    : Azeem
  Date of create: Aug 20 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Myagent extends CI_Controller{
    
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

		
		$this->load->model('agent/agent_model');
		$this->load->model('common/common_model');
		
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		
		$amount['amt']=$this->common_model->getBalance($data);  
		
		$this->load->view("common/header",$amount);
		/*$data['mainmenu']=$this->common_model->generate_menu($userdata);
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
	   
              

		$data['USR_ID']=$USR_ID;
		$data['USR_GRP_ID']=$USR_GRP_ID;
		$data['USR_STATUS']=$USR_STATUS;
		$data['PARTNER_USERNAME']=$this->input->get_post('PARTNER_USERNAME',TRUE);
		$data['PARTNER_PASSWORD']=$this->input->get_post('PARTNER_PASSWORD',TRUE);
		$data['PARTNER_TRANSACTION_PASSWORD']=$this->input->get_post('PARTNER_TRANSACTION_PASSWORD',TRUE);
		$data['PARTNER_DEPOSIT']=$this->input->get_post('PARTNER_DEPOSIT',TRUE);
		$data['PARTNER_COMMISSION_TYPE']=$this->input->get_post('PARTNER_COMMISSION_TYPE',TRUE);
		$data['PARTNER_REVENUE_SHARE']=$this->input->get_post('PARTNER_REVENUE_SHARE',TRUE);
		$data['PARTNER_TYPE_ID']=$this->input->get_post('PARTNER_TYPE_ID',TRUE);
		$data['EMAIL']=$this->input->get_post('EMAIL',TRUE);
		$data['PARTNER_COUNTRY']=$this->input->get_post('PARTNER_COUNTRY',TRUE);
		$data['PARTNER_STATE']=$this->input->get_post('PARTNER_STATE',TRUE);
		$data['PARTNER_ADDRESS1']=$this->input->get_post('PARTNER_ADDRESS1',TRUE);
		$data['PARTNER_PHONE']=$this->input->get_post('PARTNER_PHONE',TRUE);
                $data=$this->input->post();
                
		$data['commisiontype']=$this->commonfunction->get_commission_type();
		$data['distributer']=$this->commonfunction->get_distributer($this->session->userdata);
		$data['countries']=$this->commonfunction->get_country();
		$data['states']=$this->commonfunction->get_state();
		
		
		if($this->input->post('Submit',TRUE)){
			$result=$this->agent_model->add_agent($data,$this->session->userdata);
			if($result){
				$data['error']=$result;
			}else{
				$data['PARTNER_USERNAME']='';
				$data['PARTNER_PASSWORD']='';
				$data['PARTNER_TRANSACTION_PASSWORD']='';
				$data['PARTNER_DEPOSIT']='';
				$data['PARTNER_COMMISSION_TYPE']='';
				$data['PARTNER_REVENUE_SHARE']='';
				$data['PARTNER_DISTRIBUTOR']='';
				$data['EMAIL']='';
				$data['PARTNER_COUNTRY']='';
				$data['PARTNER_STATE']='';
				$data['PARTNER_ADDRESS1']='';
				$data['PARTNER_PHONE']='';
                                $success=1;
			}
                        redirect('agent/myagent/create?rid='.$this->input->get('rid').'&err='.$result.'&suc='.$success.'');
		}
			
		
                
               $partnertype_id=$this->session->userdata['partnertypeid'];
               $adminuserid=$this->session->userdata['adminuserid'];
               $data['partnertypeid']=$this->agent_model->partnertype($partnertype_id);
               $data['adminUserId'] = $adminuserid;
               $data['partnerId'] =$partner_id;
               
                
                 
              //print_r($data);
               $this->load->view('agent/myagent/add-agent',$data);	
	
	}
	

	public function view(){
	   		
            $totalpages=$this->agent_model->record_count();
            $config["base_url"] 	= base_url()."agent/myagent/view/";
            $config['per_page'] 	= $this->config->item('limit');
            $config["uri_segment"]  = 4;
            $config['total_rows']   = $totalpages;
			if($this->input->post()){
				$config['suffix'] ='?p=vparl&'.http_build_query($this->input->post(), '', "&");
			}else{
				$config['suffix'] ='?p=vparl&'.http_build_query($this->input->get(), '', "&");
			}

            $config['first_url'] = $config['base_url'].$config['suffix'];
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $data['page']=$page;
            $data['results'] = $this->agent_model->fetch_partner($config["per_page"], $page);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('agent/myagent/viewpartner',$data);   
	}
	
	public function deactive($partnerid){
      
		 $this->common_model->deactivepartner($partnerid);
	}
	
	
	public function active($partnerid){
	
           $this->common_model->activepartner($partnerid);
	}
	
	
	public function search(){
	   		
            $totalpages=$this->agent_model->record_count();
			
			$id = base64_decode($this->uri->segment(4));
			$uname = $this->uri->segment(5);
			
            $config["base_url"] 	= base_url()."agent/myagent/list/".$id."/".$uname;
            $config['per_page'] 	= $this->config->item('limit');
            $config["uri_segment"] 	= 6;
            $config['total_rows']	= $totalpages;
	
			if($this->input->post()){
				$config['suffix'] ='?p=vparl&'.http_build_query($this->input->post(), '', "&");
			}else{
				$config['suffix'] ='?p=vparl&'.http_build_query($this->input->get(), '', "&");
			}

            $config['first_url'] = $config['base_url'].$config['suffix'];
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
            $data['page']=$page;
            $data['results'] = $this->agent_model->getAgentsByDistributorId($id,$config["per_page"], $page);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('agent/myagent/viewpartner',$data);   
	}
	
	
	
	public function detail(){
			
		$data['chk']=$this->input->get_post('chk',TRUE);
		$data['id']=base64_decode($this->uri->segment(4));
		$data['USR_ID']=$USR_ID;
		$data['USR_GRP_ID']=$USR_GRP_ID;
		$data['USR_STATUS']=$USR_STATUS;
		$data['details']=$this->agent_model->get_agent_details($data);
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
        $this->load->view("agent/myagent/partner-details",$data);
	
	}
	
	public function edit(){
	

            $data['chk']=$this->input->get_post('chk',TRUE);
            $data['id']=base64_decode($this->input->get_post('id',TRUE));
            if($this->session->userdata['isownpartner']!=1){
            $data['error']="You not have Edit permission";
            $data['f']='';
            }else{
            $data['f']=$this->input->get_post('f',TRUE);
            }
            $data['USR_ID']=$USR_ID;
            $data['USR_GRP_ID']=$USR_GRP_ID;
            $data['USR_STATUS']=$USR_STATUS;

            if($this->input->post('submit',TRUE)){
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
			
            $retval=$this->agent_model->edit_agent($data);
			
            $data['f']='';
            if($retval){
            $data['error']=$retval;
            }					
            else{
            $data['success']="Successfully Updated";
            }
            }							

            $data['details']=$this->agent_model->get_agent_details($data);
            $data['mainmenu']=$this->assignroles->getmainmenu($this->session->userdata,1);
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

            $this->load->view("agent/myagent/partner-details",$data);	// p=vpard View partner details
	
	}
	
	public function password(){
	                
             $partner_id=$this->session->userdata['partnerid'];
                
             $data = array("PARTNER_ID" => $partner_id);
                
              $err = '';  
                
            $this->load->model("agent_model");
            
            if($this->input->get_post('OLDPASSWORD',TRUE)){
			
            $cpdata['OLDPASSWORD'] = $this->input->get_post('OLDPASSWORD',TRUE);
            $cpdata['NEWPASSWORD'] = $this->input->get_post('NEWPASSWORD',TRUE);

            $err = $this->agent_model->changepassword();
            }
            if($this->input->get_post('TRANS_OLDPASSWORD',TRUE)){
            $ctpdata['TRANS_OLDPASSWORD'] = $this->input->get_post('TRANS_OLDPASSWORD',TRUE);
            
            $ctpdata['TRANS_NEWPASSWORD'] = $this->input->get_post('TRANS_NEWPASSWORD',TRUE);

            $err = $this->agent_model->changetransactionpassword();
                
            }
         
            if($err){
                $cpdata['err'] = $err;
                $this->load->view("agent/myagent/changepassword",$cpdata);
            }else{		
			 $this->load->view("agent/myagent/changepassword");
			}
	
	}
        
        /*public function showsubagents()
        {
            
        }*/
}

/* End of file myagent.php */
/* Location: ./application/controllers/agent/myagent.php */