 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Setting extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->authendication();
		$this->load->helper(array('url','form'));
		$this->load->library(array('form_validation','session','pagination','encrypt'));
		$this->load->model('partners/partner_model');
		$USR_ID = $this->session->userdata['partnerusername'];
		$USR_NAME = $this->session->userdata['partnerusername'];
		$USR_STATUS = "2";
		$this->load->model('common/common_model');
		$this->load->model('user/Account_model');
		$this->load->model('user/cakewalk_model');
		$this->load->model('settings/setting_model');
		$searchdata['rdoSearch']='';
		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);
		$this->load->view("common/header",$amount);
	}

	function authendication() {
		if($this->common_model->authendicate() == '' )
        {
            $this->session->set_flashdata('message', 'Login to access the page');
            redirect();
        }
	}

	public function index() { 
		if($this->input->get_post('keyword',TRUE)=="Update") {
			$data['DESCRIPTION'] 	= $this->input->get_post('serverMessage',TRUE);
			$data['ACTUAL_VALUE'] 	= $this->input->get_post('serverStatus',TRUE);
			$updatInfo = $this->setting_model->updateServerSettings($data);				
			if(!empty($updatInfo)) {
				$this->session->set_flashdata('message', 'Settings updated successfully.');
				redirect("settings/setting/index?rid=81");							
			} else {
				$this->session->set_flashdata('message', 'Settings could not be saved.');
				redirect("settings/setting/index?rid=81");										
			}
		}else { 
			$data["serverInfo"]	 = $this->setting_model->getServerSettings();
			$this->load->view('settings/settings',$data);	
		}	
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
