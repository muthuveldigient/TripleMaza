<?php
class Partner_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	
	public function getPartnerTypes($partnerID) {
		if($partnerID!=0)
			$this->db2->where('PARTNER_TYPE_ID !=','3');
			
        $this->db2->order_by('PARTNER_TYPE_ID','asc');		
        $browseSQL = $this->db2->get('partners_type');		
		return $browseSQL->result();			
	}
	
	public function getRoleIDs($moduleIDs) { //param $moduleIDs is to restrict access
		$this->db2->select('ROLE_ID');
		$this->db2->where('ROLE_ID !=','');
        $this->db2->order_by('ROLE_ID','asc');	
		if($moduleIDs) {
			$this->db2->where_not_in('ROLE_ID', $moduleIDs);
			$this->db2->where_not_in('FK_ROLE_ID', $moduleIDs);			
		}
        $browseSQL = $this->db2->get('role');		
		return $browseSQL->result();	
	}
	
	public function adRoles2Admin($role2AdminData) {
		$browseSQL = $this->db->insert('role_to_admin',$role2AdminData);	
		return $browseSQL->result;
	}
	
	public function getCommissionTypes() {
		$this->db2->where('AGENT_COMMISSION_TYPE_ID !=','');
        $this->db2->order_by('AGENT_COMMISSION_TYPE_ID','asc');		
        $browseSQL = $this->db2->get('agent_commission_type');		
		return $browseSQL->result();			
	}
	
	public function getStates() {
		$this->db2->where('StateID !=','');
        $this->db2->order_by('StateName','asc');		
        $browseSQL = $this->db2->get('state');		
		return $browseSQL->result();			
	}
	
	public function getCountries() {
		$this->db2->where('CountryID !=','');
        $this->db2->order_by('CountryName','asc');		
        $browseSQL = $this->db2->get('countries');		
		return $browseSQL->result();			
	}	
	
	public function addPartner($partnerData) {
		$browseSQL = $this->db->insert('partner',$partnerData);
		return $this->db->insert_id();			
	}
	
	public function addPLoginInfo($userLoginInfo) {
		$browseSQL = $this->db->insert('admin_user',$userLoginInfo);
		return $this->db->insert_id();		
	}
	
	public function getPartnerDataCount($partnerSearchData) {
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}	
		
        $this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_EMAIL,t1.PARTNER_STATUS,t1.PARTNER_REVENUE_SHARE,t1.MPARTNER_ID,'.
			't2.PARTNER_TYPE,t3.AGENT_COMMISSION_TYPE')->from('partner t1');
		$this->db2->join('partners_type t2', 't2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');
		$this->db2->join('agent_commission_type t3', 't3.AGENT_COMMISSION_TYPE_ID = t1.PARTNER_COMMISSION_TYPE', 'left');		
		$this->db2->where('t1.PARTNER_ID !=','1');
		if($this->session->userdata('adminuserid')!=1)
			$this->db2->where('t1.MPARTNER_ID =',$this->session->userdata('partnerid'));			
		
		if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db2->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);
		if($partnerSearchData["PARTNER_STATUS"]!="")
			$this->db2->where('t1.PARTNER_STATUS =', $partnerSearchData["PARTNER_STATUS"]);
		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->like('t1.FK_PARTNER_ID', $partnerSearchData["PARTNER_NAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.PARTNER_EMAIL', $partnerSearchData["PARTNER_EMAIL"]);
											
		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where('t1.CREATED_ON >=', date('Y-m-d',strtotime($partnerSearchData["CREATED_ON"])));
			$this->db2->where('t1.CREATED_ON <=', date('Y-m-d',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));								
		}		
        $browseSQL = $this->db2->get();
		return $browseSQL->num_rows();					
	}
	
	public function getPartnerInfo($config,$partnerSearchData) {
            //echo "<pre>";print_r($partnerSearchData);die;
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}				
		$limit = $config["per_page"];
		$offset = $config["cur_page"];
				
        $this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_EMAIL,t1.PARTNER_STATUS,t1.PARTNER_REVENUE_SHARE,t1.MPARTNER_ID,'.
		't2.PARTNER_TYPE,t3.AGENT_COMMISSION_TYPE')->from('partner t1');
		$this->db2->join('partners_type t2', 't2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');
		$this->db2->join('agent_commission_type t3', 't3.AGENT_COMMISSION_TYPE_ID = t1.PARTNER_COMMISSION_TYPE', 'left');		
		$this->db2->where('t1.PARTNER_ID !=','1');
		if($this->session->userdata('adminuserid')!=1)
			$this->db2->where('t1.MPARTNER_ID =',$this->session->userdata('partnerid'));		
		
		if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db2->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);
		if($partnerSearchData["PARTNER_STATUS"]!="")
			$this->db2->where('t1.PARTNER_STATUS =', $partnerSearchData["PARTNER_STATUS"]);
		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->where('t1.PARTNER_ID', $partnerSearchData["PARTNER_NAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.PARTNER_EMAIL', $partnerSearchData["PARTNER_EMAIL"]);
											
		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where('DATE_FORMAT(t1.CREATED_ON,"%Y-%m-%d") >=', date('Y-m-d',strtotime($partnerSearchData["CREATED_ON"])));
			$this->db2->where('DATE_FORMAT(t1.CREATED_ON,"%Y-%m-%d") <=', date('Y-m-d',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));								
		}
		$this->db2->limit($limit,$offset);
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();		
	}
	
	public function viewPartnerInfo($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_EMAIL,t1.PARTNER_ADDRESS1,t1.PARTNER_CITY,t1.PARTNER_PHONE,'.
			't1.PARTNER_REVENUE_SHARE,t1.PARTNER_STATE,t2.PARTNER_TYPE,t3.AGENT_COMMISSION_TYPE')->from('partner t1');
		$this->db2->join('partners_type t2', 't2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');	
		$this->db2->join('agent_commission_type t3', 't3.AGENT_COMMISSION_TYPE_ID = t1.PARTNER_COMMISSION_TYPE', 'left');
		//$this->db->join('state t4', 't4.StateID = t1.PARTNER_STATE', 'left');	
		$this->db2->where('PARTNER_ID =',$partnerID);			
        $browseSQL = $this->db2->get();
		return $browseSQL->result();			
	}
	
	public function chkUserExistence($userName) {
		$this->db2->where('USERNAME =',$userName);
		$browseSQL = $this->db2->get('admin_user');
		return $browseSQL->num_rows();
	}
	
	public function getParentPartnerName($mPartnerID) {
		$this->db2->select('PARTNER_NAME')->from('partner');	
		$this->db2->where('PARTNER_ID =',$mPartnerID);	
        $browseSQL = $this->db2->get();
		return $browseSQL->result();			
	}
	
	public function changePartnerStatus($adUserdata) {
        //change admin user status also
		$this->changeAdminStatus($adUserdata);
		//change partner status 
		$this->db->where('PARTNER_ID', $adUserdata["PARTNER_ID"]);
		$this->db->update('partner', $adUserdata); 
		return $this->db->affected_rows();
	}
	
	
	public function changeAdminStatus($adUserdata) {
		//get partner name
		$partner_name = $this->Agent_model->getPartnerNameById($adUserdata["PARTNER_ID"]);
		$data = array(
               'ACCOUNT_STATUS' => $adUserdata['PARTNER_STATUS'],
            );
	
		$this->db->where('USERNAME', $partner_name);
		$this->db->update('admin_user', $data); 	
	}
	
	
	
	public function getPartnerDetails($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_EMAIL,t1.PARTNER_ADDRESS1,t1.PARTNER_CITY,t1.PARTNER_PHONE,'.
			't1.PARTNER_REVENUE_SHARE,t1.FK_PARTNER_TYPE_ID,t1.PARTNER_COMMISSION_TYPE,t1.PARTNER_EMAIL,t1.PARTNER_DESIGNATION,'.
			't1.PARTNER_CONTACT_PERSON,t1.PARTNER_STATE,t1.PARTNER_COUNTRY,t2.ADMIN_USER_ID,t2.USERNAME,'.
			't2.PINCODE,t2.MOBILE,t2.PASSWORD,t2.TRANSACTION_PASSWORD')
			->from('partner t1');
		$this->db2->join('admin_user t2', 't2.FK_PARTNER_ID = t1.PARTNER_ID');
		$this->db2->where('PARTNER_ID =',$partnerID);			
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();			
	}
	
	public function updatePartnerInfo($partnerInfo) {
		$this->db->where('PARTNER_ID',$partnerInfo["PARTNER_ID"]);	
		$this->db->update('partner', $partnerInfo); 	
		return $this->db->affected_rows();		
	}
	
	public function updateUserInfo($userInfo) {
		$this->db->where('ADMIN_USER_ID',$userInfo["ADMIN_USER_ID"]);	
		$this->db->update('admin_user', $userInfo); 	
		return $this->db->affected_rows();		
	}
	
	/*	BELOW ARE THE FUNCTIONS TO HANDLE THE USER ROLES AND PERMISSIONS */
	public function getMainRoles($noModuleAccess) {
		$this->db2->select('t1.ROLE_ID,t1.ROLE_NAME')->from('role t1');	
		$this->db2->where('t1.FK_ROLE_ID =','0');
		$this->db2->where('t1.STATUS =','1');
		if($noModuleAccess) {
			$this->db2->where_not_in('t1.ROLE_ID', $noModuleAccess);			
		}
		$this->db2->order_by('t1.MENU_ORDER','asc');
		$browseSQL = $this->db2->get();		
		return $browseSQL->result();
	}
	
	public function getChildRoles($roleID) {
		$this->db2->select('t1.ROLE_ID,t1.ROLE_NAME')->from('role t1');	
		$this->db2->where('t1.FK_ROLE_ID =',$roleID);
		$this->db2->where('t1.STATUS =','1');
		$this->db2->order_by('t1.MENU_ORDER','asc');
		$browseSQL = $this->db2->get();		
		return $browseSQL->result();		
	}
	
	public function getExistingUserRoles($adminUserID) {
		$this->db2->select('ROLE_TO_ADMIN_ID,FK_ROLE_ID')->from('role_to_admin');	
		$this->db2->where('FK_ADMIN_USER_ID =',$adminUserID);	
		$this->db2->order_by('FK_ROLE_ID','asc');		
        $browseSQL = $this->db2->get();
		return $browseSQL->result_array();		
	}
	
	public function updateUserRolesAndPermissions($updateURData) {
		$this->db->where('FK_ADMIN_USER_ID', $updateURData["adminUserID"]);
		$this->db->delete('role_to_admin'); 
		foreach($updateURData["userRaPermission"] as $userPData) {
			$uRolesAndPermissions["FK_ADMIN_USER_ID"] = $updateURData["adminUserID"];
			$uRolesAndPermissions["FK_ROLE_ID"]       = $userPData;	
			$browseSQL = $this->db->insert('role_to_admin',$uRolesAndPermissions);						 			
		}
	}
	/*	BELOW ARE THE FUNCTIONS TO HANDLE THE USER ROLES AND PERMISSIONS */
	
	public function getWhitelablePartners() {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_STATUS')->from('partner t1');	
		$this->db2->join('partners_type t2','t2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');
		$this->db2->where('t2.PARTNER_TYPE_ID','3');
		$this->db2->order_by('t1.PARTNER_NAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();		
	}	
	
	public function getOwnPartners($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_STATUS')->from('partner t1');	
		$this->db2->where('t1.PARTNER_STATUS',1);
		$this->db2->where('t1.PARTNER_ID !=',1);
		if($partnerID!=1)		
			$this->db2->where('t1.FK_PARTNER_ID',$partnerID);
		$this->db2->order_by('t1.PARTNER_NAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();			
	}
	
	public function viewPPartnerInfo($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_STATUS')->from('partner t1');	
		$this->db2->where('t1.PARTNER_ID',$partnerID);
		$this->db2->order_by('t1.PARTNER_NAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();		
	}
	
	public function viewPartnerPlayersInfo($partnerID) {
		$this->db2->select('t1.USER_ID,t1.USERNAME,t1.EMAIL_ID,t1.CITY,t1.STATE,t1.COUNTRY,t1.ACCOUNT_STATUS')->from('user t1');	
		$this->db2->where('t1.PARTNER_ID',$partnerID);
		$this->db2->order_by('t1.USERNAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();			
	}
	
	public function viewPartnerAdminsInfo($partnerID) {
		$this->db2->select('t1.ADMIN_USER_ID,t1.USERNAME,t1.EMAIL,t1.CITY,t1.STATE,t2.CountryName,t1.PINCODE,t1.ACCOUNT_STATUS')
			->from('admin_user t1');
		$this->db2->join('countries t2','t2.CountryID = t1.COUNTRY', 'left');
		$this->db2->where('t1.FK_PARTNER_ID',$partnerID);
		$this->db2->where('`USERNAME` NOT IN (SELECT `PARTNER_USERNAME` FROM `partner`)', NULL, FALSE);
		//echo $this->db->last_query();
		$browseSQL = $this->db2->get();
		return $browseSQL->result();				
	}
				
}
?>