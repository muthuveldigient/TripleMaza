<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        session_start();
        parent::__construct();
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
        $this->load->library('session');
    }

    public function index($err = NULL) {
        $this->load->helper("form");
        $this->load->library("form_validation");
        $data['err'] = $err;
        if (!$this->session->userdata('partnerid')) {
            $this->load->view('common/login', $data);
        } else {
            redirect('partners/index?rid=51');
        }
    }

    public function loginprocess() {
        $this->load->helper('url');
        $this->load->model("common/login_model");
        $captchaValue = $this->input->post('captcha');
        $captchaStatus = false;
        if (isset($captchaValue) && $captchaValue != "" && $_SESSION["code"] == $captchaValue) {
            $captchaStatus = true;
        }
        if ($captchaStatus == false) {
            $err = 'Invalid Login.Please try again.';
            $this->index($err);
            die;
        }

        $result = $this->login_model->validate_login();

        if (!$result) {
            $this->session->sess_destroy();
            $err = 'Invalid Login.Please try again.';
            $this->index($err);
        } else {
			if($this->session->userdata('password_reset_status')==1){
                redirect('resetpassword/index');
            }else{
	            $roleAccess["FK_ADMIN_USER_ID"] = $this->session->userdata('adminuserid');
	            $roleAccess["FK_ROLE_ID"] = 1;
	            $dashboardAccess = "";
	            $chkRoles["dashboard"] = $this->login_model->chkDashboardAccess($roleAccess);
	            if (!empty($chkRoles["dashboard"]))
	                $dashboardAccess = 1;

	            $this->session->set_userdata('dashboardAccess', $dashboardAccess);
	            redirect('partners/index?rid=51');
			}
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */