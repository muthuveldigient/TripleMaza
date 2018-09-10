<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Resetpassword extends CI_Controller
{
	private $sessionPartnerTypeId;
	private $sessionPartnerId;
        
	function __construct(){
		session_start();
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation','session','pagination','encrypt'));
		$this->sessionPartnerTypeId = $this->session->userdata('partnertypeid');
		$this->sessionPartnerId = $this->session->userdata('partnerid');
		$this->load->model('common/common_model');
		$this->load->model('partners/partner_model');
	}
    
	public function index()
	{	
	
		if($this->common_model->partner_password_validate_success()== false)
		{
			$this->session->set_flashdata('message', 'Login to access the page');
			redirect();
		}   
		$partnerId = $this->session->userdata( 'partnerid' );
		$getPartnerDeatails = $this->common_model->get_partner_details($partnerId);
		$data['trans_pwd'] = $getPartnerDeatails->PARTNER_TRANSACTION_PASSWORD;
		
		$this->load->view('common/force_password',$data);
	}
	
	public function force_update_password()
	{
		if($this->common_model->partner_password_validate_success()=='')
		{
			$this->session->set_flashdata('message', 'Login to access the page');
			redirect();
		}
		$partnerId = $this->session->userdata( 'partnerid' );
		$partnerName = $this->session->userdata( 'partnerusername' );
		
		$getPartnerDeatails = $this->common_model->get_partner_details($partnerId);
		$trans_pwd =$getPartnerDeatails->PARTNER_TRANSACTION_PASSWORD;
		
		$this->form_validation->set_rules( 'OLDPASSWORD', 'old password', 'trim|required|xss_clean|callback_validate_old_password[old]' );
		$this->form_validation->set_rules( 'NEWPASSWORD', 'new password', 'trim|required|xss_clean|callback_validate_new_password[old]' );
		if(!empty($trans_pwd)){
			$this->form_validation->set_rules( 'TRANS_OLDPASSWORD', 'Transaction old password', 'trim|required|xss_clean|callback_validate_old_password[transaction_password]' );
			$this->form_validation->set_rules( 'TRANS_NEWPASSWORD', 'Transaction new password', 'trim|required|xss_clean|callback_validate_new_password[transaction_password]' );
		}
		
		#activity entry start 
		$_REQUEST['OLDPASSWORD'] = md5($this->input->post('OLDPASSWORD'));
		$_REQUEST['NEWPASSWORD'] = md5($this->input->post('NEWPASSWORD'));
		if(!empty($trans_pwd)){
			$_REQUEST['TRANS_OLDPASSWORD'] = md5($this->input->post('TRANS_OLDPASSWORD'));
			$_REQUEST['TRANS_NEWPASSWORD'] = md5($this->input->post('TRANS_NEWPASSWORD'));
		}
		
		$arrTraking["DATE_TIME"] = date('Y-m-d H:i:s');
		$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
		$arrTraking["ACTION_NAME"]  ="Force Password";
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM2"]      =1;
				
		#activity entry end 
		if ( $this->form_validation->run() == true )
		{
			$NEWPASSWORD=md5(addslashes($this->input->post('NEWPASSWORD')));
			// Begin transaction
			$this->db->trans_begin();
			$updateData = array('PARTNER_PASSWORD'=>$NEWPASSWORD,'PASSWORD_RESET_STATUS'=>0);
			$updateData1 = array('PASSWORD'=>$NEWPASSWORD);
			$update = $this->partner_model->update_partner($updateData,$partnerId);
			$update1 = $this->partner_model->update_admin_user($updateData1,$partnerId);
			
			if(!empty($trans_pwd)){
				$TRANS_NEWPASSWORD=md5(addslashes($this->input->post('TRANS_NEWPASSWORD')));
				$updateTransData = array('PARTNER_TRANSACTION_PASSWORD'=>$TRANS_NEWPASSWORD);
				$updateTransData1 = array('TRANSACTION_PASSWORD'=>$TRANS_NEWPASSWORD);
				$update_trans = $this->partner_model->update_partner($updateTransData,$partnerId);
				$update_trans1 = $this->partner_model->update_admin_user($updateTransData1,$partnerId);
			}
			
			
			if ( $this->db->trans_status() === TRUE )
			{
				$this->db->trans_commit();
				$message = 'Updated successfully';
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>$message));
				$this->db->insert("tracking",$arrTraking);
				//$this->session->set_flashdata('message', array('msg'=>$message,'class'=>'danger'));
				redirect("resetpassword/success");
			}
			else
			{
				$this->db->trans_rollback();
				$message = 'Failed to update';
				$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>$message));
				$this->db->insert("tracking",$arrTraking);
				$this->session->set_flashdata('message', array('msg'=>$message,'class'=>'danger'));
				redirect("resetpassword/index");
			}
		}
		else
		{
			$message = validation_errors();
			$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$_REQUEST,'message'=>$message));
			$this->db->insert("tracking",$arrTraking);
			$this->session->set_flashdata('message', array('msg'=>$message,'class'=>'danger'));
			redirect("resetpassword/index");
		}
	}
	
	/* public function validate_new_password( $password)
	{
		if (preg_match('/^[a-zA-Z0-9#%*+=@&!?$]+$/', $password))
		{
			$pattern = '/^(?=.*[#%*+=@&!?$])(?=.*[0-9])(?=.*[A-Z]).{8,15}$/';
			if(preg_match($pattern, $password)){
				return TRUE;
			}
			else
			{
				$message 		= 'Password must be Ex: (eXample@134).';
				$this->form_validation->set_message( 'validate_new_password', $message );
				return FALSE;
			}
		}
		else
		{
			$message 		= 'Password must be Ex: (eXample@134).';
			$this->form_validation->set_message( 'validate_new_password', $message );
			return FALSE;
		}
		
	}
	
	public function validate_old_password( $password )
	{
		$post = $this->input->post();
		$partnerId = $this->session->userdata( 'partnerid' );
		$getPartnerDeatails = $this->common_model->get_partner_details($partnerId);
		if( md5($password)!=$getPartnerDeatails->PARTNER_PASSWORD )
		{
			$message 		= 'Invalid old password';
			$this->form_validation->set_message( 'validate_old_password', $message );
			return FALSE;
		}
		elseif($post['OLDPASSWORD']==$post['NEWPASSWORD'])
		{
			$message 		= 'Old and new password should not be same';
			$this->form_validation->set_message( 'validate_old_password', $message );
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		
	} */
	
	
		
	public function validate_old_password( $password, $type )
	{
		$post = $this->input->post();
		$partnerId = $this->session->userdata( 'partnerid' );
		if($type == 'old')
		{
			$getPartnerDeatails = $this->common_model->get_partner_details($partnerId);
			if( md5($password)!=$getPartnerDeatails->PARTNER_PASSWORD )
			{
				$message 		= 'Invalid old password';
				$this->form_validation->set_message( 'validate_old_password', $message );
				return FALSE;
			}
			elseif($post['OLDPASSWORD']==$post['NEWPASSWORD'])
			{
				$message 		= 'Old and new password should not be same';
				$this->form_validation->set_message( 'validate_old_password', $message );
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		
		if($type == 'transaction_password')
		{
			$getPartnerDeatails = $this->common_model->get_partner_details($partnerId);
			if( md5($password)!=$getPartnerDeatails->PARTNER_TRANSACTION_PASSWORD )
			{
				$message 		= 'Invalid old transaction password';
				$this->form_validation->set_message( 'validate_old_password', $message );
				return FALSE;
			}
			elseif($post['TRANS_OLDPASSWORD']==$post['TRANS_NEWPASSWORD'])
			{
				$message 		= 'Old and new transaction password should not be same';
				$this->form_validation->set_message( 'validate_old_password', $message );
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
	
	public function success()
	{
		$this->session->sess_destroy();
		$this->load->view('common/success');
	}

	
        
	
        
}