<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxcall extends CI_Controller {

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
		$this->load->database();
		$this->load->helper('form');
		$this->load->model('partners/partner_model'); 
		$this->load->model('user/cakewalk_model');
	}
	
	public function index(){
		$ptype=$this->input->post('id');
		$data=$this->partner_model->chainPartner(11);
		$options[''] = '-- Select --'; 
		foreach($data as $dataR) {
			 $options[$dataR->PARTNER_ID] = $dataR->PARTNER_NAME;
		}
		$js = 'onChange="selSupDist();"';
  		//echo form_dropdown('mrtgCusName', $listCusName, '0', $js);   
		echo form_dropdown('masteragent', $options,'','id="masteragent" class="cmbTextField" '.$js);
	}//EO: index function
	
	public function selectSuperDistributor(){
		$pTypeID = $this->session->userdata['partnertypeid'];
		if($pTypeID == 11)
			$pid=$this->session->userdata['partnerid'];
		else
			$pid=$this->input->post('pid');
			$data=$this->partner_model->chainPartner(15,$pid);
			$options[''] = '-- Select --';
			foreach($data as $dataR) {
			 $options[$dataR->PARTNER_ID] = $dataR->PARTNER_USERNAME;
			}
			$js = 'onChange="selDist();"';
			echo form_dropdown('superdistributor', $options,'','id="superdistributor" class="cmbTextField" '.$js);
	}//EO: selectDistributor function
	
	public function selectDistributor(){
		$pTypeID = $this->session->userdata['partnertypeid'];
		
		if($pTypeID == 15)
			$pid=$this->session->userdata['partnerid'];
		else
			$pid=$this->input->post('pid');
		
		$data=$this->partner_model->chainPartner(12,$pid);
		$options[''] = '-- Select --'; 
		foreach($data as $dataR) {
			 $options[$dataR->PARTNER_ID] = $dataR->PARTNER_USERNAME;
		}
		$js = 'onChange="selSubDist();"';
		echo form_dropdown('distributor', $options,'','id="distributor" class="cmbTextField" '.$js);
	}//EO: selectDistributor function
	
	public function selectSubDistributor(){
		$pTypeID = $this->session->userdata['partnertypeid'];
		if($pTypeID == 12)
			$pid=$this->session->userdata['partnerid'];
		else
			$pid=$this->input->post('pid');
			
		$data=$this->partner_model->chainPartner(13,$pid);
		$options[''] = '-- Select --'; 
		foreach($data as $dataR) {
			 $options[$dataR->PARTNER_ID] = $dataR->PARTNER_USERNAME;
		}
		$js = 'onChange="selMinigames(this.value);"';
		echo form_dropdown('subdistributor', $options,'','id="subdistributor" class="cmbTextField"'.$js);
	}//EO: selectSubDistributor function
	
	public function balanceCheck(){
		$ptype=$this->input->post('ptype');
		$pid=$this->input->post('pid');
		$amt=$this->input->post('amt');
		
		$data=$this->partner_model->balanceCheck($pid);
		if($data >= $amt) {
			echo 'true';
		} else {
			echo 'false';
		}
	}//EO: selectSubDistributor function
	
	public function selectMinigames() {
		$ptype=$this->input->post('ptype');
		$pid=$this->input->post('pid');
		
		if($pid == '')
			$pid=$this->session->userdata['partnerid'];
		
		if($ptype ==11){
			$category = $this->partner_model->getCategoryMiniGames();
		}else{
			$category = $this->partner_model->getCategoryBasedMiniGames($pid);
		}
		
		$sno=1;
		$data = array();
		if(!empty($category)){
			foreach($category as $rs ) {
				$data[$rs["CATEGORY_NAME"]][] = array("MINIGAMES_NAME"=>$rs["MINIGAMES_NAME"],"DESCRIPTION"=>$rs["DESCRIPTION"]
												);
			}
			if(!empty( $data )){
				$selectBox1.='<div class="UDCommonWrap">';
				foreach($data as $key=> $val){
					$categoryName = str_replace(' ', '', $key);
						if($sno==4) {
					$selectBox1.= '</div><div class="UDCommonWrap">';
							$sno=1;
						}

					$selectBox1.='<div class="UDRightWrap" style="width:150px;">
						<div class="UDFieldtitle" style="width:150px;">'.$key.'</div>
						<div class="UDFieldTxtFld" style="width:150px;">
							<div style="height:100px;width:150px;border: 1px solid;background-color: #fff;overflow: auto;line-height: 18px;">
							<div style="padding:1% 2%">
							<label><input type="checkbox" name="allgames_'.$categoryName.'" id="allgames_'.$categoryName.'" style="float:left;margin: 1.5% 3% 1%;" />Select All</label>
							</div>';
							foreach($val as $category){
						$selectBox1.='<div style="padding:1% 2%">
							<label><input type="checkbox" name="category[]" id="'.$categoryName.'_games_'.$category["MINIGAMES_NAME"].'" value="'.$category["MINIGAMES_NAME"].'" style="float:left;margin: 1.5% 3% 1%;" />'.$category["DESCRIPTION"].'</label>
							</div>';
							}
				  $selectBox1.='</div>	  
						</div>
					</div>
					<div class="UDRightWrap" style="width:50px;padding-top:60px;">
						<div class="UDFieldtitle"></div>
						<div class="UDFieldTxtFld" style="width:50px;text-align:center;"></div>
					</div>	';	
						$sno++;
					}
				$selectBox1.='</div>';
			} 
		}
		echo json_encode( array('form'=>$selectBox1));
	}//EO: selectSubDistributor function
	
	public function selectMenuList() {
		$ptype=$this->input->post('ptype');
		if($ptype == 11) $modname = 'moduleAccess'; else if($ptype == 12) $modname = 'moduleAccessForDist'; else if($ptype == 13) $modname = 'moduleAccessForSubdist'; else if($ptype == 14) $modname = 'moduleAccessForAgent'; 
		$moduleIDs  = $this->config->item($modname); //modules which is not needed to the user
		$getMainRoles = $this->partner_model->getMainRoles($moduleIDs);
		$partnerID = $this->session->userdata['partnertypeid'];
		
		if(!empty($getMainRoles)) {
			$menuArr = array();
			$i=0;
			$menuArr['maxChild'] = 0;
			foreach($getMainRoles as $mainRole) {
				$menuArr[$i]['ROLE_ID'] = $mainRole->ROLE_ID;	
				$menuArr[$i]['ROLE_NAME'] = $mainRole->ROLE_NAME;												
				$getChildRoles = $this->partner_model->getChildRoles($mainRole->ROLE_ID);
				$menuArr[$i]['ROLE_CHILD'] = $getChildRoles;
				$menuArr[$i]['ROLE_CHILD_CNT'] = count($getChildRoles);
				if($menuArr[$i]['ROLE_CHILD_CNT'] > $menuArr['maxChild'])
					$menuArr['maxChild'] = $menuArr[$i]['ROLE_CHILD_CNT'];
				$i++;
			}
		}
		$data["menuList"] = $menuArr;
		$this->load->view('partners/ajax_menulist',$data);	
	}//EO: selectSubDistributor function

	public function checkUserExists() {
		$username = $_REQUEST['username'];	
		$pnum = $this->partner_model->usernameAlreadyExist($username);
				
		if($pnum>0){
			$msg = "exists";			
		}else if($pnum == 0){
			$msg = "valid";
		}
			
		echo $msg;
		exit;
	}
	
	public function checkEmailExists() {
		$emailid = $_REQUEST['emailid'];	
		$num = $this->partner_model->emailAlreadyExist($emailid);
				
		if($num>0){
			$msg = "exists";			
		}else if($num == 0){
			$msg = "valid";
		}
			
		echo $msg;
		exit;
	}
	
	public function checkAffiliate() {
		$partner_id = $_REQUEST['partner_id'];	
		
		
		$num = $this->partner_model->affiliatePartner($partner_id);
		if($partner_id != ''){		
			if($num>0){
				$msg = "valid";			
			}else if($num == 0){
				$msg = "wrong";
			}
		}else{
		   $msg = "valid";			
		}
		
			
		echo $msg;
		exit;
	}

	public function createUser() {	

		if(($_REQUEST['username'])!="" && ($_REQUEST['emailid'])!="" && ($_REQUEST['firstname'])!="" && ($_REQUEST['lastname'])!="" && ($_REQUEST['password'])!="") {
		
		
				$pnum = $this->partner_model->usernameAlreadyExist($_REQUEST['username']);
				$num = $this->partner_model->emailAlreadyExist($_REQUEST['emailid']);
				

				if($pnum>0)
				{
					echo "Username already exists";
					die;
				}
							 

				if($num>0)
				{   
					echo "Emailid already exists!";
					die;
				}
				
				
				
				$data["USERNAME"]  = addslashes(trim($_REQUEST['username']));
				$data["PASSWORD"]	= addslashes(trim(md5($_REQUEST['password'])));
				$plain_password = addslashes(trim($_REQUEST['password']));
				$data["EMAIL_ID"]   = addslashes(trim($_REQUEST['emailid']));				
				$data["FIRSTNAME"] = addslashes(trim($_REQUEST['firstname']));			
				$data["LASTNAME"] = addslashes(trim($_REQUEST['lastname']));			
				$data["DATE_OF_BIRTH"]  	= addslashes(trim($_REQUEST['dob1']));			
				$data["MOBILE"]  	= addslashes(trim($_REQUEST['mobile']));
				$data["COUNTRY"]  	= addslashes(trim($_REQUEST['country']));
				$data["REGISTRATION_TIMESTAMP"]  = date('Y-m-d h:i:s');	
				$data["ACCOUNT_STATUS"]  	= 1;	
				$data["PARTNER_ID"] = addslashes(trim($_REQUEST['code']));
				
				if(addslashes(trim($_REQUEST['code'])) ==''){
				  $data["PARTNER_ID"] = ADMIN_ID;
				}
			
				$amount=0;
				$addUserId = $this->partner_model->addCakewalkPlayer($data,$plain_password);		 
				 
			 if($addUserId==1) {
					echo "1001";
					die;
			 }elseif($addUserId==2) {
					echo "1002";
					die;
			 }elseif($addUserId==3) {
					echo "1003";
					die;
			 }	
		}else{
			echo '1004';
			die;
		}
	}
	public function calculate(){
		$ptype=$this->input->post('ptype');
		$partid=$this->input->post('pid');
		$pt=$this->input->post('pt');
		if($ptype !=11 && $ptype !=15){
			$pid = (!empty($partid)?$partid:$this->session->userdata['partnerid']);
			if(!empty($pid)){
				$data=$this->partner_model->getPartnerDetails($pid);
	//			echo '<prE>';print_r($data[0]->PARTNER_REVENUE_SHARE);exit;
				if($data[0]->PARTNER_REVENUE_SHARE >= $pt) {
					
					if($data[0]->PARTNER_COMMISSION_TYPE==1){
						echo 'Turn Over';
					}else{
						echo 'Revenue';
					}
					//echo $data[0]->PARTNER_COMMISSION_TYPE;
				} else {
					echo 0;
				}
			} 
		}else{
			echo 'success';
		}
		exit;
	}
}

/* End of file ajaxcall.php */
/* Location: ./application/controllers/welcome.php */