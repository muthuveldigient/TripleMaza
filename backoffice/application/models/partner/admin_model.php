<?php
class Admin_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	
	public function addAdmin($userData) {
		$browseSQL = $this->db->insert('admin_user', $userData);	
		return $this->db->insert_id();
	}
	
	public function getUsersCount($adminSearchData) {
		$this->db2->select('t1.ADMIN_USER_ID,t1.USERNAME,t1.EMAIL,t1.CITY,t1.STATE,t3.CountryName,t1.PINCODE,t1.ACCOUNT_STATUS')
			->from('admin_user t1');
		$this->db2->join('countries t3','t3.CountryID = t1.COUNTRY', 'left');		
		$this->db2->where('t1.ADMIN_USER_ID !=',$this->session->userdata('adminuserid'));		
		$this->db2->where('t1.FK_PARTNER_ID =',$this->session->userdata('partnerid'));
		if($adminSearchData["USERNAME"]!="")
			$this->db2->like('t1.USERNAME',$adminSearchData["USERNAME"]);	
		if(!empty($adminSearchData["EMAIL"]))
			$this->db2->like('t1.EMAIL',$adminSearchData["EMAIL"]);	
		if(!empty($adminSearchData["ACCOUNT_STATUS"]))
			$this->db2->where('t1.ACCOUNT_STATUS =',$adminSearchData["ACCOUNT_STATUS"]);	
									
        $browseSQL = $this->db2->get();
		return $browseSQL->num_rows();		
	}

	public function getAdminInfo($config, $adminSearchData) {
           // echo "<pre>";print_r($adminSearchData);die;
		if($this->session->userdata('adminSearchData')!="") {
			$adminSearchData = $this->session->userdata('adminSearchData');
		}			
		$limit = $config["per_page"];
		$offset = $config["cur_page"];
				
		$this->db2->select('t1.ADMIN_USER_ID,t1.USERNAME,t1.EMAIL,t1.CITY,t1.STATE,t2.CountryName,t1.PINCODE,t1.ACCOUNT_STATUS')
			->from('admin_user t1');
		$this->db2->join('countries t2','t2.CountryID = t1.COUNTRY', 'left');
		$this->db2->join('partner t3','t3.PARTNER_ID  = t1.FK_PARTNER_ID', 'left');		
		$this->db2->where('ADMIN_USER_ID !=',$this->session->userdata('adminuserid'));		
		if($this->session->userdata('adminuserid')!=1)
			$this->db2->where('t1.FK_PARTNER_ID =',$this->session->userdata('partnerid'));
		else
			$this->db2->where('`USERNAME` NOT IN (SELECT `PARTNER_USERNAME` FROM `partner`)', NULL, FALSE);		

		if(!empty($adminSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db2->where('t3.FK_PARTNER_TYPE_ID', $adminSearchData["FK_PARTNER_TYPE_ID"]);
		if(!empty($adminSearchData["ACCOUNT_STATUS"]))
			$this->db2->where('t1.ACCOUNT_STATUS', $adminSearchData["ACCOUNT_STATUS"]);
		if(!empty($adminSearchData["PARTNER_NAME"]))
			$this->db2->where('t3.PARTNER_ID', $adminSearchData["PARTNER_NAME"]);
		if(!empty($adminSearchData["USERNAME"]))
			$this->db2->like('t1.USERNAME', $adminSearchData["USERNAME"]);
											
		if(!empty($adminSearchData["CREATED_ON"]) && ($adminSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where('DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,"%Y-%m-%d") >=', date('Y-m-d',strtotime($adminSearchData["CREATED_ON"])));
			$this->db2->where('DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,"%Y-%m-%d") <=', date('Y-m-d',strtotime($adminSearchData["CREATED_ON_END_DATE"])));								
		}
		
		$this->db2->limit($limit,$offset);			
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result(); 			
	}
	
	public function viewUserData($userID) {
		$this->db2->select('t1.ADMIN_USER_ID,t1.USERNAME,t1.EMAIL,t1.CITY,t1.STATE,t3.CountryName,t1.PINCODE,t1.ACCOUNT_STATUS')
			->from('admin_user t1');
		//$this->db->join('state t2','t2.StateID = t1.STATE', 'left');
		$this->db2->join('countries t3','t3.CountryID = t1.COUNTRY', 'left');				
		$this->db2->where('t1.ADMIN_USER_ID =',$userID);
        $browseSQL = $this->db2->get();	
		//echo $this->db->last_query();
		return $browseSQL->result();
	}
	
	public function changeAdminStatus($adUserdata) {
		$this->db->where('ADMIN_USER_ID', $adUserdata["ADMIN_USER_ID"]);
		$this->db->update('admin_user', $adUserdata); 	
		return $this->db->affected_rows();
	}	
	
	public function adRoles2Admin($role2AdminData) {
		$browseSQL = $this->db->insert('role_to_admin',$role2AdminData);	
		return $browseSQL->result;
	}	
	
	public function getAdminData($adminID) {
		$this->db2->where('ADMIN_USER_ID',$adminID);
		$browseSQL = $this->db2->get('admin_user');
		return $browseSQL->result();
	}
	
	public function editAdmin($adminData) {
		$this->db->where('ADMIN_USER_ID', $adminData["ADMIN_USER_ID"]);
		$this->db->update('admin_user', $adminData); 
		return $this->db->affected_rows();		
	}
	
	public function getExistingUserRoles($adminUserID) {
		$this->db2->select('ROLE_TO_ADMIN_ID,FK_ROLE_ID')->from('role_to_admin');	
		$this->db2->where('FK_ADMIN_USER_ID =',$adminUserID);	
		$this->db2->order_by('FK_ROLE_ID','asc');		
        $browseSQL = $this->db2->get();
		return $browseSQL->result_array();		
	}	
	
	public function getPartnerTypes($partnerID) {
		if($partnerID!=0)
			$this->db2->where('PARTNER_TYPE_ID !=','3');
			
        $this->db2->order_by('PARTNER_TYPE_ID','asc');		
        $browseSQL = $this->db2->get('partners_type');		
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
	
	public function updateAdminRolesAndPermissions($updateAURData) {
		$this->db->where('FK_ADMIN_USER_ID', $updateAURData["adminUserID"]);
		$this->db->delete('role_to_admin'); 
		foreach($updateAURData["adminRaPermission"] as $adminRPData) {
			$aRolesAndPermissions["FK_ADMIN_USER_ID"] = $updateAURData["adminUserID"];
			$aRolesAndPermissions["FK_ROLE_ID"]       = $adminRPData;	
			$browseSQL = $this->db->insert('role_to_admin',$aRolesAndPermissions);						 			
		}	
		return $this->db->insert_id();	
	}
	/*	BELOW ARE THE FUNCTIONS TO HANDLE THE USER ROLES AND PERMISSIONS */	
				
}
?>