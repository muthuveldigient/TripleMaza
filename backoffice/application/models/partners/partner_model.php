<?php
class Partner_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}

	/* public function getPartnerTypes($partnerID) {
		$this->db2->where('PARTNER_TYPE_ID > ',$partnerID);
		$this->db2->where('ONLINE_AGENT_STATUS',1);
        $this->db2->order_by('PARTNER_TYPE_ID','asc');
        $browseSQL = $this->db2->get('partners_type');
		return $browseSQL->result();
	} */
	
	public function getPartnerTypes($partnerTypeID) {
		 if($partnerTypeID == 15){
			$this->db2->where('PARTNER_TYPE_ID > ',11);
			$this->db2->where('PARTNER_TYPE_ID < ',$partnerTypeID);
		}else{
			$this->db2->where('PARTNER_TYPE_ID > ',$partnerTypeID);
			
			if($partnerTypeID != 11 && $partnerTypeID != 0){
				$this->db2->where_not_in('PARTNER_TYPE_ID',15); //super distributor
			}
		}
		$this->db2->where('ONLINE_AGENT_STATUS',1);
		$this->db2->order_by('PARTNER_ORDER','asc');
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
		$this->db->set('CREATE_DATE', 'NOW()', FALSE);
		$browseSQL = $this->db->insert('role_to_admin',$role2AdminData);
		return $browseSQL->result;
	}

	public function getCommissionTypes() {
		$this->db2->where('AGENT_COMMISSION_TYPE_ID !=','');
        $this->db2->order_by('AGENT_COMMISSION_TYPE_ID','asc');
        $browseSQL = $this->db2->get('agent_commission_type');
		return $browseSQL->result();
	}
	
	public function getUserInformation($userId) {
		$this->db2->where('u.USER_ID',$userId);
        $browseSQL = $this->db2->get('user as u');
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

	public function getPartnerDataCount($partnerSearchData='') {
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}
		$partnerIds="";
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		{
			$partnerIds = $this->loggedinAllPartnerIDs();
		}

        $this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_USERNAME,t1.PARTNER_EMAIL,t1.PARTNER_STATUS,t1.PARTNER_REVENUE_SHARE,t1.MPARTNER_ID,'.
			't2.PARTNER_TYPE,t3.AGENT_COMMISSION_TYPE')->from('partner t1');
		$this->db2->join('partners_type t2', 't2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');
		$this->db2->join('agent_commission_type t3', 't3.AGENT_COMMISSION_TYPE_ID = t1.PARTNER_COMMISSION_TYPE', 'left');
		$this->db2->where('t1.PARTNER_ID !=',ADMIN_ID);

		if($partnerIds)
		{
			$this->db2->where_in('t1.PARTNER_ID', $partnerIds);
		}

		if(!empty($partnerSearchData["PARTNER_STATUS"]))
		 {
			if($partnerSearchData["PARTNER_STATUS"]==1)	{
				$aStatus=$partnerSearchData["PARTNER_STATUS"];
			}else{
			$aStatus=0;
			}
			$this->db2->where('t1.PARTNER_STATUS =', $aStatus);
		 }
		/*if($this->session->userdata('adminuserid')!=1)
			$this->db->where('t1.MPARTNER_ID =',$this->session->userdata('partnerid'));*/

		if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db2->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);
		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->like('t1.PARTNER_NAME', $partnerSearchData["PARTNER_NAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.PARTNER_EMAIL', $partnerSearchData["PARTNER_EMAIL"]);

		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where("(DATE_FORMAT(t1.CREATED_ON,'%Y-%m-%d %H:%i:%s') BETWEEN '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"]))."' AND '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"]))."')");
			//$this->db2->where('t1.CREATED_ON >=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"])));
			//$this->db2->where('t1.CREATED_ON <=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));
		}
        $browseSQL = $this->db2->get();
//         echo '<pre>';print_r($this->db2->last_query());exit;
		return $browseSQL->num_rows();
	}

	public function getPartnersCountByStatus($partnerSearchData='', $status) {
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}
		$partnerIds="";
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		{
			$partnerIds = $this->loggedinAllPartnerIDs();
		}

        $this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_USERNAME,t1.PARTNER_EMAIL,t1.PARTNER_STATUS,t1.PARTNER_REVENUE_SHARE,t1.MPARTNER_ID,'.
			't2.PARTNER_TYPE,t3.AGENT_COMMISSION_TYPE')->from('partner t1');
		$this->db2->join('partners_type t2', 't2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');
		$this->db2->join('agent_commission_type t3', 't3.AGENT_COMMISSION_TYPE_ID = t1.PARTNER_COMMISSION_TYPE', 'left');
		$this->db2->where('t1.PARTNER_ID !=',ADMIN_ID);

		if($partnerIds)
		{
			$this->db2->where_in('t1.PARTNER_ID', $partnerIds);
		}
		if(!empty($partnerSearchData["PARTNER_STATUS"]))
		 {
			if($partnerSearchData["PARTNER_STATUS"]==1)	{
				$aStatus=$partnerSearchData["PARTNER_STATUS"];
			}else{
			$aStatus=0;
			}
			$this->db2->where('t1.PARTNER_STATUS =', $aStatus);
		 }
		$this->db2->where('t1.PARTNER_STATUS =', $status);
		if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db2->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);
		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->like('t1.PARTNER_NAME', $partnerSearchData["PARTNER_NAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.PARTNER_EMAIL', $partnerSearchData["PARTNER_EMAIL"]);

		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where("(DATE_FORMAT(t1.CREATED_ON,'%Y-%m-%d %H:%i:%s') BETWEEN '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"]))."' AND '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"]))."')");
			//$this->db2->where('t1.CREATED_ON >=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"])));
			//$this->db2->where('t1.CREATED_ON <=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));
		}
        $browseSQL = $this->db2->get();
		return $browseSQL->num_rows();
	}

	public function getPartnerInfo($config,$partnerSearchData='') {
            //echo "<pre>";print_r($partnerSearchData);die;
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}
		$limit = $config["per_page"];
		$offset = $config["cur_page"];
		$partnerIds="";
		//echo $this->session->userdata('partnerid');
		//echo ADMIN_ID; die;
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		{
			$partnerIds = $this->loggedinAllPartnerIDs();
		}

        $this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_USERNAME,t1.PARTNER_EMAIL,t1.PARTNER_STATUS,t1.PARTNER_REVENUE_SHARE,t1.MPARTNER_ID,'.
		't2.PARTNER_TYPE,t3.AGENT_COMMISSION_TYPE')->from('partner t1');
		$this->db2->join('partners_type t2', 't2.PARTNER_TYPE_ID = t1.FK_PARTNER_TYPE_ID', 'left');
		$this->db2->join('agent_commission_type t3', 't3.AGENT_COMMISSION_TYPE_ID = t1.PARTNER_COMMISSION_TYPE', 'left');
		$this->db2->where('t1.PARTNER_ID !=',ADMIN_ID);
		if($partnerIds)
		{

			$this->db2->where_in('t1.FK_PARTNER_ID', $partnerIds);
		}

		if(!empty($partnerSearchData["PARTNER_STATUS"]))
		 {
			if($partnerSearchData["PARTNER_STATUS"]==1)	{
				$aStatus=$partnerSearchData["PARTNER_STATUS"];
			}else{
			$aStatus=0;
			}
			$this->db2->where('t1.PARTNER_STATUS =', $aStatus);
		 }

		/*if($this->session->userdata('adminuserid')!=ADMIN_ID)
			$this->db->where('t1.MPARTNER_ID =',$this->session->userdata('partnerid'));*/

		if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db2->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);
		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->like('t1.PARTNER_NAME', $partnerSearchData["PARTNER_NAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.PARTNER_EMAIL', $partnerSearchData["PARTNER_EMAIL"]);

		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			
			$this->db2->where("(DATE_FORMAT(t1.CREATED_ON,'%Y-%m-%d %H:%i:%s') BETWEEN '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"]))."' AND '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"]))."')");
		//	$this->db2->where('DATE_FORMAT(t1.CREATED_ON,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d ',strtotime($partnerSearchData["CREATED_ON"])));
		//	$this->db2->where('DATE_FORMAT(t1.CREATED_ON,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));
		}
		$this->db2->limit($limit,$offset);
        $browseSQL = $this->db2->get();
	//	echo $this->db2->last_query();exit;
		return $browseSQL->result();
	}

	public function getUserCountByStatus($partnerSearchData='', $status) {
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}
		$partnerIds="";
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		{
			$partnerIds = $this->loggedinAllPartnerIDs();
		}


        $this->db2->select('t1.USER_ID,t1.USERNAME,t1.PARTNER_ID,t1.ACCOUNT_STATUS,t1.LOGIN_STATUS,t1.EMAIL_ID,t2.USER_TOT_BALANCE')->from('user t1');
		$this->db2->join('user_points t2', 't1.USER_ID = t2.USER_ID AND t2.COIN_TYPE_ID=1 AND t1.ONLINE_AGENT_STATUS=1', 'left');

		$this->db2->where('t1.ONLINE_AGENT_STATUS', 1);

		if($partnerIds)
		{
			$this->db2->where_in('t1.PARTNER_ID', $partnerIds);

		}
		if(!empty($partnerSearchData["PARTNER_STATUS"]))
		 {
			if($partnerSearchData["PARTNER_STATUS"]==1)	{
				$aStatus=$partnerSearchData["PARTNER_STATUS"];
			}else{
			$aStatus=0;
			}

			$this->db2->where('t1.ACCOUNT_STATUS', $aStatus);
		 }
		$this->db2->where('t1.ACCOUNT_STATUS', $status);

		if(@$partnerSearchData["AFFILIATE"])
		$affpartner=$this->getPartnerIdByAName($partnerSearchData["AFFILIATE"]);


		if(!empty($partnerSearchData["LOGIN_STATUS"])){
			if($partnerSearchData["LOGIN_STATUS"]==1){
			$lstatus=1;
			//$this->db2->where('t1.LOGIN_STATUS', $lstatus);
			//$this->db2->or_where('t1.MOBILE_LOGIN_STATUS', $lstatus);
			$this->db2->where("( t1.LOGIN_STATUS = $lstatus OR t1.MOBILE_LOGIN_STATUS= $lstatus )" );
			}else{
			$lstatus=0;
			$this->db2->where('t1.LOGIN_STATUS', $lstatus);
			$this->db2->where('t1.MOBILE_LOGIN_STATUS', $lstatus);
			}
		}


		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->like('t1.USERNAME', $partnerSearchData["USERNAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.EMAIL_ID', $partnerSearchData["EMAIL_ID"]);
		if(!empty($partnerSearchData["PLAYERNAME"]))
			$this->db2->like('t1.USERNAME', $partnerSearchData["PLAYERNAME"]);


		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where("(DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,'%Y-%m-%d %H:%i:%s') BETWEEN '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"]))."' AND '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"]))."')");
			//$this->db2->where('t1.REGISTRATION_TIMESTAMP >=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"])));
			//$this->db2->where('t1.REGISTRATION_TIMESTAMP <=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));
		}
		//echo $this->db2->last_query();exit;
        $browseSQL = $this->db2->get();
		return $browseSQL->num_rows();
	}

	public function getUserDataCount($partnerSearchData='') {
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}
		$partnerIds="";
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		{
			$partnerIds = $this->loggedinAllPartnerIDs();
		}


        $this->db2->select('t1.USER_ID,t1.USERNAME,t1.PARTNER_ID,t1.ACCOUNT_STATUS,t1.LOGIN_STATUS,t1.EMAIL_ID,t2.USER_TOT_BALANCE')->from('user t1');
		$this->db2->join('user_points t2', 't1.USER_ID = t2.USER_ID AND t2.COIN_TYPE_ID=1 AND t1.ONLINE_AGENT_STATUS=1', 'left');

		$this->db2->where('t1.ONLINE_AGENT_STATUS', 1);

		if($partnerIds)
		{
			$this->db2->where_in('t1.PARTNER_ID', $partnerIds);

		}

		/*if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);*/
		if(!empty($partnerSearchData["PARTNER_STATUS"]))
		 {
			if($partnerSearchData["PARTNER_STATUS"]==1)	{
				$aStatus=$partnerSearchData["PARTNER_STATUS"];
			}else{
			$aStatus=0;
			}

			$this->db2->where('t1.ACCOUNT_STATUS', $aStatus);
		 }


		if(@$partnerSearchData["AFFILIATE"])
		$affpartner=$this->getPartnerIdByAName($partnerSearchData["AFFILIATE"]);


		if(!empty($partnerSearchData["LOGIN_STATUS"])){
			if($partnerSearchData["LOGIN_STATUS"]==1){
				$lstatus=1;
				$this->db2->where("( t1.LOGIN_STATUS = $lstatus OR t1.MOBILE_LOGIN_STATUS= $lstatus )" );
				//$this->db2->or_where('t1.MOBILE_LOGIN_STATUS', $lstatus);
			}else{
				$lstatus=0;
				$this->db2->where('t1.LOGIN_STATUS', $lstatus);
				$this->db2->where('t1.MOBILE_LOGIN_STATUS', $lstatus);
			}
			//$this->db2->where('t1.MOBILE_LOGIN_STATUS', $lstatus);
		}


		if(!empty($partnerSearchData["PARTNER_NAME"]))
			$this->db2->like('t1.USERNAME', $partnerSearchData["USERNAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.EMAIL_ID', $partnerSearchData["EMAIL_ID"]);
		if(!empty($partnerSearchData["PLAYERNAME"]))
			$this->db2->like('t1.USERNAME', $partnerSearchData["PLAYERNAME"]);


		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where("(DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,'%Y-%m-%d %H:%i:%s') BETWEEN '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"]))."' AND '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"]))."')");
		//	$this->db2->where('t1.REGISTRATION_TIMESTAMP >=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"])));
		//	$this->db2->where('t1.REGISTRATION_TIMESTAMP <=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));
		}
        $browseSQL = $this->db2->get();
		return $browseSQL->num_rows();
	}


	public function getUserInfo($config,$partnerSearchData='') {
		if($this->session->userdata('partnerSearchData')!="") {
			$partnerSearchData = $this->session->userdata('partnerSearchData');
		}
		$limit = $config["per_page"];
		$offset = $config["cur_page"];
		$partnerIds="";
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		{
			$partnerIds = $this->loggedinAllPartnerIDs();
		}
        $this->db2->select('t1.USER_ID,t1.USERNAME,t1.PARTNER_ID,t1.ACCOUNT_STATUS,t1.LOGIN_STATUS,t1.MOBILE_LOGIN_STATUS,t2.USER_TOT_BALANCE')->from('user t1');
		$this->db2->join('user_points t2', 't1.USER_ID = t2.USER_ID AND t2.COIN_TYPE_ID=1', 'left');

		$this->db2->where('t1.ONLINE_AGENT_STATUS', 1);

		if($partnerIds){
			$this->db2->where_in('t1.PARTNER_ID', $partnerIds);
		}

		/*if(!empty($partnerSearchData["FK_PARTNER_TYPE_ID"]))
			$this->db->where('t1.FK_PARTNER_TYPE_ID', $partnerSearchData["FK_PARTNER_TYPE_ID"]);*/
		if(!empty($partnerSearchData["PARTNER_STATUS"]))
		 {
			if($partnerSearchData["PARTNER_STATUS"]==1)	{
				$aStatus=$partnerSearchData["PARTNER_STATUS"];
			}else{
			$aStatus=0;
			}
			$this->db2->where('t1.ACCOUNT_STATUS', $aStatus);
		 }

		if(!empty($partnerSearchData["LOGIN_STATUS"])){
			if($partnerSearchData["LOGIN_STATUS"]==1){
			$lstatus=1;
			//$this->db2->where('t1.LOGIN_STATUS', $lstatus);
			//$this->db2->or_where('t1.MOBILE_LOGIN_STATUS', $lstatus);
			$this->db2->where("( t1.LOGIN_STATUS = $lstatus OR t1.MOBILE_LOGIN_STATUS= $lstatus )" );
			}else{
			$lstatus=0;
			$this->db2->where('t1.LOGIN_STATUS', $lstatus);
			$this->db2->where('t1.MOBILE_LOGIN_STATUS', $lstatus);
			}
			//$this->db2->where('t1.MOBILE_LOGIN_STATUS', $lstatus);
		}

		if(!empty($partnerSearchData["PARTNER_NAME"]))
			@$this->db2->like('t1.USERNAME', $partnerSearchData["USERNAME"]);
		if(!empty($partnerSearchData["PARTNER_EMAIL"]))
			$this->db2->like('t1.EMAIL_ID', $partnerSearchData["EMAIL_ID"]);

 		if(!empty($partnerSearchData["PLAYERNAME"]))
   			$this->db2->like('t1.USERNAME', $partnerSearchData["PLAYERNAME"]);

		if(!empty($partnerSearchData["CREATED_ON"]) && ($partnerSearchData["CREATED_ON_END_DATE"])) {
			$this->db2->where("(DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,'%Y-%m-%d %H:%i:%s') BETWEEN '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"]))."' AND '".date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"]))."')");
			//$this->db2->where('DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,"%Y-%m-%d %H:%i:%s") >=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON"])));
			//$this->db2->where('DATE_FORMAT(t1.REGISTRATION_TIMESTAMP,"%Y-%m-%d %H:%i:%s") <=', date('Y-m-d H:i:s',strtotime($partnerSearchData["CREATED_ON_END_DATE"])));
		}
		$this->db2->limit($limit,$offset);
        $browseSQL = $this->db2->get();
		//echo $this->db2->last_query();die;
		return $browseSQL->result();
	}

	public function viewUserInfo($userID) {
		$this->db2->select('t1.USER_ID,t1.USERNAME,t1.PARTNER_ID,t1.ACCOUNT_STATUS,t1.PASSWORD,t1.REGISTRATION_TIMESTAMP,t2.USER_TOT_BALANCE')->from('user t1');
		$this->db2->join('user_points t2', 't2.USER_ID = t1.USER_ID', 'left');
		$this->db2->where('t1.USER_ID =',$userID);
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
		$this->db2->where('PARTNER_USERNAME',$userName);
		$browseSQL = $this->db2->get('partner');

		$this->db2->where('USERNAME',$userName);
		$browseSQLu = $this->db2->get('user');

		if($browseSQL->num_rows()==0 && $browseSQLu->num_rows()==0){
			$status=0;
		}else{
			$status=1;
		}

		return $status;
	}

	public function chkUser($userName) {
		$this->db2->where('USERNAME =',$userName);
		$browseSQL = $this->db2->get('user');
	//	echo $this->db->last_query();
		return $browseSQL->num_rows();
	}

	public function addPlayer($data,$amount,$plain_password,$partnername) {
		if($data['PARTNER_ID']){
				$agentbal = $this->getPartnerBalance($data['PARTNER_ID']);

				if($amount<=$agentbal){
					$this->db->trans_begin();
					
					//$browseSQL1 = $this->db3->insert('user',$data);
					$browseSQL = $this->db->insert('user',$data);
					$userid = $this->db->insert_id();
					if($amount!='' && $amount!=0){
						$this->userBalanceUpdate($userid,$amount,$data['PARTNER_ID'],$data['USERNAME'],$partnername);
					}

					$udata['COIN_TYPE_ID'] =1;
					$udata['USER_ID'] = $userid;
					$udata['VALUE'] =  '';
					$udata['USER_DEPOSIT_BALANCE'] = $amount;
					$udata['USER_TOT_BALANCE'] = $amount;
					$this->db->insert('user_points',$udata);

					/*
					$updata['COIN_TYPE_ID'] =2;
					$updata['USER_ID'] = $userid;
					$updata['VALUE'] =  '';
					$updata['USER_PROMO_BALANCE'] = 0;
					$updata['USER_TOT_BALANCE'] = 0;
					$this->db->insert('user_points',$updata);
					*/

					$arrTraking["USERNAME"]     =$partnername;
					$arrTraking["ACTION_NAME"]  ="Create User";
					$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
					$arrTraking["REFERRENCE_NO"]=uniqid();
					$arrTraking["STATUS"]       =1;
					$arrTraking["LOGIN_STATUS"] =1;
					$arrTraking["DATE_TIME"]     =date('Y-m-d H:i:s');
					$arrTraking["CUSTOM2"]      =1;
					

					$formdata['USERNAME']=$data['USERNAME'];
					$formdata['PASSWORD']=$plain_password;
					$formdata['EMAIL']=$data['EMAIL_ID'];
					$formdata['PARTNER_COUNTRY']=$data['COUNTRY'];
					$formdata['MOBILE']='';

					$cakewalk=$this->cakewalk_model->createUser($formdata,$userid);


					if($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$data,'message'=>'failure'));
						$this->db->insert("tracking",$arrTraking);
						$error=2;
					}else{
						$arrTraking["CUSTOM1"]      =json_encode(array('formData'=>$data,'message'=>'success'));
						$this->db->insert("tracking",$arrTraking);
						$this->db->trans_commit();
						$error=1;
					}
				}else{
					$error=3;
				}
		}
		//echo $this->db->last_query();
		return $error;
	}

	public function getParentPartnerName($mPartnerID) {
		$this->db2->select('PARTNER_NAME,PARTNER_USERNAME,FK_PARTNER_TYPE_ID')->from('partner');
		$this->db2->where('PARTNER_ID =',$mPartnerID);
        $browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	 public function getPartnerNameById($id){
	    $query  = $this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID= '$id'");
		$result = $query->row();
		return @$result->PARTNER_USERNAME;
	}


	public function addCakewalkPlayer($data,$plain_password) {
		if($data['PARTNER_ID']){
			#check partner is agent

	    	$querya  = $this->db2->query("select FK_PARTNER_TYPE_ID from partner where PARTNER_ID=".$data['PARTNER_ID']."");
			$resulta = $querya->row();

			if($resulta->FK_PARTNER_TYPE_ID!=''){
				$this->db->trans_begin();
				$browseSQL = $this->db->insert('user',$data);
				$userid=$this->db->insert_id();
				$amount=0;
				$udata['COIN_TYPE_ID'] =1;
				$udata['USER_ID'] = $userid;
				$udata['VALUE'] =  '';
				$udata['USER_DEPOSIT_BALANCE'] = $amount;
				$udata['USER_TOT_BALANCE'] = $amount;
				$this->db->insert('user_points',$udata);

				$updata['COIN_TYPE_ID'] =2;
				$updata['USER_ID'] = $userid;
				$updata['VALUE'] =  '';
				$updata['USER_PROMOBALANCE_BALANCE'] = 0;
				$updata['USER_TOT_BALANCE'] = 0;
				$this->db->insert('user_points',$updata);

				$formdata['USERNAME']=$data['USERNAME'];
				$formdata['PASSWORD']=$plain_password;
				$formdata['EMAIL']=$data['EMAIL_ID'];
				$formdata['PARTNER_COUNTRY']=$data['COUNTRY'];
				$formdata['MOBILE']='';

				$cakewalk=$this->cakewalk_model->createUser($formdata,$userid);

				if($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					$error=2;
				}else{
					$this->db->trans_commit();
					$error=1;
				}
			}else{
				$error=3;
			}
		}
		return $error;
	}

	public function getPartnerIdByName($name){
		$partnerIds="";

		if($this->session->userdata('partnerid')!=ADMIN_ID)
		$partnerIds = $this->partner_model->loggedinPartnerIDs();




		if(is_array($partnerIds)){
			$partnerIds=implode(",",$partnerIds);
		}

		if($partnerIds)
			$ids=" AND PARTNER_ID IN(".$partnerIds.")";
		else
			$ids='';

	    $query  = $this->db2->query("select PARTNER_ID  from partner where PARTNER_USERNAME= '$name' $ids");

		$result = $query->row();
		return $result->PARTNER_ID;
	}

	public function getPartnerIdByAName($name){

	    $query  = $this->db2->query("select PARTNER_ID  from partner where PARTNER_NAME= '$name'");

		$result = $query->row();
		return $result->PARTNER_ID;
	}

	public function changePartnerStatus($adUserdata) {
		$partner_type=$this->getPartnerId($adUserdata["PARTNER_ID"]);
		//$allpartnerids='';
		$allpartnerids='';
		if($partner_type==11){
			$allpartnerids=$adUserdata["PARTNER_ID"];

			#Get all super distributors list
			$supdistlist=$this->getAllPatrnerInfos($adUserdata["PARTNER_ID"]);
			if($supdistlist){
				foreach($supdistlist as $value_sup){
					if($allpartnerids){
						$allpartnerids=$allpartnerids.",".$value_sup->PARTNER_ID;
					}else{
						$allpartnerids=$value_sup->PARTNER_ID;
					}
					#update all dist list;
					$distlist=$this->getAllPatrnerInfos($value_sup->PARTNER_ID); 
					
					if($distlist){
						foreach($distlist as $valuem){
							if($allpartnerids){
								$allpartnerids=$allpartnerids.",".$valuem->PARTNER_ID;
							}else{
								$allpartnerids=$valuem->PARTNER_ID;
							}
							#update all subdist list;
							$subdists=$this->getAllPatrnerInfos($valuem->PARTNER_ID);
							if($subdists){
								//print_r($subdists);
								foreach($subdists as $value){
									if($allpartnerids){
									$allpartnerids=$allpartnerids.",".$value->PARTNER_ID;
									}else{
									$allpartnerids=$value->PARTNER_ID;
									}

									if($value->FK_PARTNER_TYPE_ID!=0 && $value->FK_PARTNER_TYPE_ID==13){
										$subagnts=$this->getAllPatrnerInfos($value->PARTNER_ID);
										foreach($subagnts as $valueSag){
											if($valueSag->PARTNER_ID){
											//echo "Subagnt".$valueSag->PARTNER_ID."<br/>";
												if($allpartnerids){
												$allpartnerids=$allpartnerids.",".$valueSag->PARTNER_ID;
												}else{
												$allpartnerids=$valueSag->PARTNER_ID;
												}
											}
										}
									}elseif($value->FK_PARTNER_TYPE_ID!=0 && $value->FK_PARTNER_TYPE_ID==14){
										$agnts=$this->getAllPatrnerInfos($value->PARTNER_ID);
										foreach($agnts as $valueAg){
											if($valueAg->PARTNER_ID){
												if($allpartnerids){
												$allpartnerids=$allpartnerids.",".$valueAg->PARTNER_ID;
												}else{
												$allpartnerids=$valueAg->PARTNER_ID;
												}
											}
										}
									}
								}
							}
						}	
					}
				}
			}
		}elseif($partner_type==15){
			$allpartnerids=$adUserdata["PARTNER_ID"];

			#Get all distributors list
			$distlist=$this->getAllPatrnerInfos($adUserdata["PARTNER_ID"]);
			if($distlist){
				foreach($distlist as $valuem){
					if($allpartnerids){
						$allpartnerids=$allpartnerids.",".$valuem->PARTNER_ID;
					}else{
						$allpartnerids=$valuem->PARTNER_ID;
					}
					#update all subdist list;
					$subdists=$this->getAllPatrnerInfos($valuem->PARTNER_ID);
					if($subdists){
						//print_r($subdists);
						foreach($subdists as $value){
							if($allpartnerids){
							$allpartnerids=$allpartnerids.",".$value->PARTNER_ID;
							}else{
							$allpartnerids=$value->PARTNER_ID;
							}

							if($value->FK_PARTNER_TYPE_ID!=0 && $value->FK_PARTNER_TYPE_ID==13){
								$subagnts=$this->getAllPatrnerInfos($value->PARTNER_ID);
								foreach($subagnts as $valueSag){
									if($valueSag->PARTNER_ID){
									//echo "Subagnt".$valueSag->PARTNER_ID."<br/>";
										if($allpartnerids){
										$allpartnerids=$allpartnerids.",".$valueSag->PARTNER_ID;
										}else{
										$allpartnerids=$valueSag->PARTNER_ID;
										}
									}
								}
							}elseif($value->FK_PARTNER_TYPE_ID!=0 && $value->FK_PARTNER_TYPE_ID==14){
								$agnts=$this->getAllPatrnerInfos($value->PARTNER_ID);
								foreach($agnts as $valueAg){
									if($valueAg->PARTNER_ID){
										if($allpartnerids){
										$allpartnerids=$allpartnerids.",".$valueAg->PARTNER_ID;
										}else{
										$allpartnerids=$valueAg->PARTNER_ID;
										}
									}
								}
							}
						}
				}
			}
		  }
		}elseif($partner_type==12){
			$allpartnerids=$adUserdata["PARTNER_ID"];
			#update all subdist list;
			$subdists=$this->getAllPatrnerInfos($adUserdata["PARTNER_ID"]);
			if($subdists){
				//print_r($subdists);
				foreach($subdists as $value){
					if($allpartnerids){
					$allpartnerids=$allpartnerids.",".$value->PARTNER_ID;
					}else{
					$allpartnerids=$value->PARTNER_ID;
					}

					if($value->FK_PARTNER_TYPE_ID!=0 && $value->FK_PARTNER_TYPE_ID==13){
						$subagnts=$this->getAllPatrnerInfos($value->PARTNER_ID);
						foreach($subagnts as $valueSag){
							if($valueSag->PARTNER_ID){
							//echo "Subagnt".$valueSag->PARTNER_ID."<br/>";
								if($allpartnerids){
								$allpartnerids=$allpartnerids.",".$valueSag->PARTNER_ID;
								}else{
								$allpartnerids=$valueSag->PARTNER_ID;
								}
							}
						}
					}elseif($value->FK_PARTNER_TYPE_ID!=0 && $value->FK_PARTNER_TYPE_ID==14){
						$agnts=$this->getAllPatrnerInfos($value->PARTNER_ID);
						foreach($agnts as $valueAg){
							if($valueAg->PARTNER_ID){
								if($allpartnerids){
								$allpartnerids=$allpartnerids.",".$valueAg->PARTNER_ID;
								}else{
								$allpartnerids=$valueAg->PARTNER_ID;
								}
							}
						}
					}
				}
			}
		}elseif($partner_type==13){
			$allpartnerids=$adUserdata["PARTNER_ID"];
			#update all subdist list;
			$subdists=$this->getAllPatrnerInfos($adUserdata["PARTNER_ID"]);
			if($subdists){
				//print_r($subdists);
				foreach($subdists as $value){
					if($allpartnerids){
					$allpartnerids=$allpartnerids.",".$value->PARTNER_ID;
					}else{
					$allpartnerids=$value->PARTNER_ID;
					}
				}
			}
		}elseif($partner_type==14){
			$allpartnerids=$adUserdata["PARTNER_ID"];
		}
		if($allpartnerids){
				if(strstr($allpartnerids,",")){
					$allpartneridsList=explode(",",$allpartnerids);
				}else{
					$allpartneridsList=$allpartnerids;
				}
				$this->db->trans_begin();
				$this->db->set('PARTNER_MODIFIED_ON', 'NOW()', FALSE);
				$this->db->where_in('PARTNER_ID', $allpartneridsList);
				$this->db->update('partner', array('PARTNER_STATUS'=>$adUserdata['PARTNER_STATUS']));
				$result =$this->db->affected_rows();
				//	echo $this->db->last_query();
				//change admin user status also
				$this->changeAdminUserStatus($adUserdata,$allpartnerids);
				$this->changeAgentUserStatus($adUserdata,$allpartnerids);
			    if($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
				}else{
					$this->db->trans_commit();
				//	$this->removeUserGameSide($allpartnerids,$adUserdata['PARTNER_STATUS'],'partner');
				}
		}

		//echo $this->db->last_query();
		return $result;
	}
	
	public function removeUserGameSide($allUserIds, $status, $type){
		//$this->viewPartnerPlayersInfo($allpartnerids);
		if($status ==0 ){ //only deactive then will sent remove partner or user list in Java game side
			$request2=urlencode('{"action":"balupdatereqconf","userid":"'.$allUserIds.'","type":"'.$type.'""}');

			$URL2 = "http://".BALANCE_UPDATE_API."/Digient_casino_API/servlet/GameApiServlet?xmlString=$request2";
			$ch2 = curl_init($URL2);
			curl_setopt($ch2, CURLOPT_MUTE, 1);
			curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch2, CURLOPT_POST, 1);
			curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
			curl_setopt($ch2, CURLOPT_POSTFIELDS, $request2);
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
			$response2 = curl_exec($ch2);
			curl_close($ch2);
			/* $dresponse2=json_decode(trim($response2),true);
			$userid1=$dresponse2['userid'];
			$statusupdate=$dresponse2['status']; */
		}
	}

	public function changeUserStatus($adUserdata) {
		$updateUser=$this->db->query("update user set ACCOUNT_STATUS='".$adUserdata["ACCOUNT_STATUS"]."',UPDATE_ON=now() where USER_ID='".$adUserdata["USER_ID"]."'");
		//$this->removeUserGameSide($adUserdata["USER_ID"],$adUserdata['PARTNER_STATUS'],'user');
		return $this->db->affected_rows();
	}

	function getUserPartnerStatus($userID) {
		$agtPartnerStatus=0;
		if(!empty($userID)) {
			$getPartnerStatus="SELECT a.PARTNER_ID,a.PARTNER_STATUS FROM partner a WHERE a.PARTNER_ID=(SELECT b.PARTNER_ID FROM user b WHERE b.USER_ID=".$userID.")";
			$browseSQL   =$this->db2->query($getPartnerStatus);
			$status = $browseSQL->result();
			if(!empty($status)) {
				$agtPartnerStatus=$status[0]->PARTNER_STATUS;
			}	
		}
		return $agtPartnerStatus;		
	}
	
	function getAgentPartnerStatus($partnerID) {
		$agtPartnerStatus=0;
		if(!empty($partnerID)) {
			$getPartnerStatus="SELECT a.PARTNER_ID,a.PARTNER_STATUS FROM partner a WHERE a.PARTNER_ID=(SELECT b.FK_PARTNER_ID FROM partner b WHERE b.PARTNER_ID=".$partnerID.")";
			$browseSQL   =$this->db2->query($getPartnerStatus);
			$status = $browseSQL->result();
			if(!empty($status)) {
				$agtPartnerStatus=$status[0]->PARTNER_STATUS;
			}
		}
		return $agtPartnerStatus;		
	}




	public function changeAdminStatus($adUserdata) {
		//get partner name
		$partner_name = $this->partner_model->getPartnerNameById($adUserdata["PARTNER_ID"]);
		$data = array(
               'ACCOUNT_STATUS' => $adUserdata['PARTNER_STATUS'],
            );

		$this->db->where('USERNAME', $partner_name);
		$this->db->update('admin_user', $data);
	}


	public function changeAdminUserStatus($adUserdata,$partnerids) {
		//get partner name
		$data = array(
               'ACCOUNT_STATUS' => $adUserdata['PARTNER_STATUS'],
            );
		if(strstr($partnerids,",")){
			$partnerids=explode(",",$partnerids);
		}
		$this->db->where_in('FK_PARTNER_ID', $partnerids);
		$this->db->update('admin_user', $data);

	}

	public function changeAgentUserStatus($adUserdata,$partnerids) {
		$updateUser=$this->db->query("update user set ACCOUNT_STATUS='".$adUserdata["PARTNER_STATUS"]."',UPDATE_ON=now() where PARTNER_ID IN (".$partnerids.")");
		//echo $this->db->last_query();
		return $this->db->affected_rows();
	}

	public function usernameAlreadyExist($USERNAME){

		$this->db2->where('PARTNER_USERNAME',$USERNAME);
		$browseSQL = $this->db2->get('partner');

		$this->db2->where('USERNAME',$USERNAME);
		$browseSQLu = $this->db2->get('user');
		if($browseSQL->num_rows()==0 && $browseSQLu->num_rows()==0){
			$status=0;
		}else{
			$status=1;
		}

		return $status;
	 }

	public function emailAlreadyExist($EMAIL){
	 	$p_count  = "select EMAIL_ID from user where EMAIL_ID='$EMAIL'";
		$p_result = $this->db2->query($p_count);
		return $p_result->num_rows();
	 }

	public function affiliatePartner($partner_id){
	 	$p_count  = "select FK_PARTNER_TYPE_ID from partner where PARTNER_ID=".$partner_id." and fk_partner_type_id =14";
		$p_result = $this->db2->query($p_count);
		return $p_result->num_rows();
	 }

	public function getPartnerDetails($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_EMAIL,t1.PARTNER_ADDRESS1,t1.PARTNER_CITY,t1.PARTNER_PHONE,'.
			't1.PARTNER_REVENUE_SHARE,t1.FK_PARTNER_TYPE_ID,t1.PARTNER_COMMISSION_TYPE,t1.PARTNER_EMAIL,t1.PARTNER_DESIGNATION,'.
			't1.PARTNER_CONTACT_PERSON,t1.PARTNER_STATE,t1.PARTNER_COUNTRY,t1.FK_PARTNER_ID,t2.ADMIN_USER_ID,t2.USERNAME,'.
			't2.PINCODE,t2.MOBILE,t2.PASSWORD,t2.TRANSACTION_PASSWORD')
			->from('partner t1');
		$this->db2->join('admin_user t2', 't2.FK_PARTNER_ID = t1.PARTNER_ID');
		$this->db2->where('t1.PARTNER_ID =',$partnerID);
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function updatePartnerInfo($partnerInfo) {
		$this->db->where('PARTNER_ID',$partnerInfo["PARTNER_ID"]);
		$this->db->update('partner', $partnerInfo);
		//echo $this->db->last_query();
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
		$this->db2->where('t1.ONLINE_AGENT_STATUS =','1');
		if($noModuleAccess) {
			$this->db2->where_not_in('t1.ROLE_ID', $noModuleAccess);
		}
		$this->db2->order_by('t1.MENU_ORDER','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function getChildRoles($roleID,$ModuleAccess='') {
		$this->db2->select('t1.ROLE_ID,t1.ROLE_NAME')->from('role t1');
		$this->db2->where('t1.FK_ROLE_ID =',$roleID);
		$this->db2->where('t1.STATUS =','1');
		$this->db2->where('t1.ONLINE_AGENT_STATUS =','1');
		if($ModuleAccess !='') {
			$this->db2->where_in('t1.ROLE_ID', $ModuleAccess);
		}
		$this->db2->order_by('t1.MENU_ORDER','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db2->last_query();exit;
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
		$this->db->set('CREATE_DATE', 'NOW()', FALSE);
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
		$this->db2->where('t2.PARTNER_TYPE_ID','13');
		$this->db2->order_by('t1.PARTNER_NAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function getOwnPartners($partnerID) {
		$this->db2->select('t1.PARTNER_ID,t1.PARTNER_NAME,t1.PARTNER_STATUS')->from('partner t1');
		$this->db2->where('t1.PARTNER_STATUS',1);
		$this->db2->where('t1.PARTNER_ID !=',ADMIN_ID);
		if($partnerID!=ADMIN_ID)
			$this->db2->where('t1.FK_PARTNER_ID',$partnerID);
		$this->db2->order_by('t1.PARTNER_NAME','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function viewPPartnerInfo($partnerID,$partnerTypeID) {
		$this->db2->select('PARTNER_ID,PARTNER_NAME,PARTNER_USERNAME,PARTNER_STATUS,FK_PARTNER_TYPE_ID,PARTNER_REVENUE_SHARE,PARTNER_CREATED_ON,PARTNER_COMMISSION_TYPE')->from('partner');
		$this->db2->where('FK_PARTNER_ID',$partnerID);
		$this->db2->where('FK_PARTNER_TYPE_ID',$partnerTypeID);
		$this->db2->order_by('PARTNER_NAME','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db2->last_query();exit;
		return $browseSQL->result();
	}

	public function getCommissionIdByName($partnerCId) {
		$res=$this->db2->query("SELECT AGENT_COMMISSION_TYPE FROM agent_commission_type WHERE AGENT_COMMISSION_TYPE_ID = '$partnerCId' LIMIT 1");
       	$partnerCInfo  =  $res->row();
		return $partnerCInfo->AGENT_COMMISSION_TYPE;
	}

	public function viewPartnerPlayersInfo($partnerID) {
		$this->db2->select('t1.USER_ID,t1.USERNAME,t1.EMAIL_ID,t1.CITY,t1.STATE,t1.COUNTRY,t1.ACCOUNT_STATUS')->from('user t1');
		$this->db2->where_in('t1.PARTNER_ID',$partnerID);
		$this->db2->order_by('t1.USERNAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function viewPartnerAdminsInfo($partnerID) {
		$this->db2->select('t1.ADMIN_USER_ID,t1.USERNAME,t1.EMAIL,t1.CITY,t1.STATE,t1.PINCODE,t1.ACCOUNT_STATUS')
			->from('admin_user t1');
		//$this->db->join('countries t2','t2.CountryID = t1.COUNTRY', 'left');
		$this->db2->where('t1.FK_PARTNER_ID',$partnerID);
		//$this->db->where('`USERNAME` NOT IN (SELECT `PARTNER_USERNAME` FROM `partner`)', NULL, FALSE);
		//echo $this->db->last_query();
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}
	//Thiru

	public function addGameRevenueShare($arrRevenueshareData) {
	
		/** report database table */
		/*
		$this->db3->set('CREATED_DATE', 'NOW()', FALSE);
		$browseSQL1 = $this->db3->insert('agent_game_revenueshare',$arrRevenueshareData);
		*/
		$this->db->set('CREATED_DATE', 'NOW()', FALSE);
		$browseSQL = $this->db->insert('agent_game_revenueshare',$arrRevenueshareData);
		
		return $browseSQL->result;	 	
	}
	
	public function deleteGameRevenueShare($pid) {
		$this->db->where('PARTNER_ID', $pid);
		$this->db->delete('agent_game_revenueshare');
		
		/** report database table */
		/*
		$this->db3->where('PARTNER_ID', $pid);
		$this->db3->delete('agent_game_revenueshare');
		*/
		return $this->db->affected_rows();	 	
	}

	public function addPartner($partnerData) {
		$this->db->set('DATE_TIME', 'NOW()', FALSE);
		$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
		$arrTraking["ACTION_NAME"]  ="Create partner";
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM1"]      =$partnerData['PARTNER_USERNAME']." ,processed by ".$this->session->userdata('partnerusername');
		$arrTraking["CUSTOM2"]      =1;
		$this->db->insert("tracking",$arrTraking);
			
		$this->db->set('PARTNER_CREATED_ON', 'NOW()', FALSE);
		$this->db->set('CREATED_ON', 'NOW()', FALSE);
		$this->db->set('ONLINE_AGENT_STATUS', '1');
		$browseSQL = $this->db->insert('partner',$partnerData);
		
		/** report database table */
		/*
		$this->db3->set('PARTNER_CREATED_ON', 'NOW()', FALSE);
		$this->db3->set('CREATED_ON', 'NOW()', FALSE);
		$this->db3->set('ONLINE_AGENT_STATUS', '1');
		$browseSQL1 = $this->db3->insert('partner',$partnerData);
		*/
		return $this->db->insert_id();
	}

	public function addPLoginInfo($userLoginInfo) {
		$this->db->set('REGISTRATION_TIMESTAMP', 'NOW()', FALSE);
		$this->db->set('ONLINE_AGENT_STATUS', '1');
		$browseSQL = $this->db->insert('admin_user',$userLoginInfo);
		return $this->db->insert_id();
	}

	public function getPartnerBalance($partnerId){
		$res=$this->db2->query("SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID = '$partnerId' LIMIT 1");
     	$partnerBalanceInfo  =  $res->row();
		return @$partnerBalanceInfo->AMOUNT;
    }

	public function getUStatus($userid){
  			$res=$this->db2->query("SELECT ACCOUNT_STATUS FROM user WHERE USER_ID = '$userid' LIMIT 1");
       	 	$userInfo  =  $res->row();
			return @$userInfo->ACCOUNT_STATUS;
    }

	public function getPStatus($partnerId){
  			$res=$this->db2->query("SELECT PARTNER_STATUS FROM partner WHERE PARTNER_ID = '$partnerId' LIMIT 1");
       	 	$partnerInfo  =  $res->row();
			return @$partnerInfo->PARTNER_STATUS;
    }

	public function playPoints($userId){
  		$res=$this->db2->query("select sum(TRANSACTION_AMOUNT) as totalbets from master_transaction_history where USER_ID='".$userId."' and TRANSACTION_TYPE_ID='11'");
       	 	$playPointsInfo  =  $res->row();
			return @$playPointsInfo->totalbets;
    }

	public function updatepwd($datapass){
        $this->db2->select('t1.USER_ID,t1.USERNAME,t1.PARTNER_ID,t1.ACCOUNT_STATUS,t1.LOGIN_STATUS')->from('user t1');
		$this->db2->where('t1.USER_ID', $datapass["USER_ID"]);
		$browseSQL = $this->db2->get();
		$rsReqult=$browseSQL->row();
		$passTracking['USER_ID']=$datapass["USER_ID"];
		$passTracking['USERNAME']=$rsReqult->USERNAME;
		$passTracking['PASSWORD']=$datapass["PASSWORD"];
		$passTracking['USER_PARTNER_ID']=$rsReqult->PARTNER_ID;
		$passTracking['UPDATED_PARTNER_ID']=$this->session->userdata('partnerid');
		$passTracking['SYSTEM_IP']=$_SERVER['REMOTE_ADDR'];
		$addPassTracking = $this->db->insert('user_password_tracking',$passTracking);

		//cakewalk password changes
		$cakewalk=$this->cakewalk_model->changePassword($datapass["USER_ID"],$datapass["ORI_PASSWORD"]);

		$updateUser=$this->db->query("update user set PASSWORD='".$datapass["PASSWORD"]."', PASSWORD_UPDATE =0 where USER_ID='".$datapass["USER_ID"]."'");
       	//return $this->db->affected_rows(); 
       	return $updateUser;
    }

	/*
	public function updatepwd($datapass){
		//cakewalk password changes
		$cakewalk=$this->cakewalk_model->changePassword($datapass["USER_ID"],$datapass["ORI_PASSWORD"]);

		$updateUser=$this->db->query("update user set PASSWORD='".$datapass["PASSWORD"]."' where USER_ID='".$datapass["USER_ID"]."'");
       	return $this->db->affected_rows();
    }
	*/
	public function getGameBetWinData($data) {
		if(!empty($data["GAME_ID"]) && $data["GAME_ID"]!=0) { //CASINO GAMES
			$browserSQL=$this->db3->query("SELECT SUM(TOTAL_BETS) AS totalbets,SUM(TOTAL_WINS) AS totalwins,SUM(TOTAL_BETS-TOTAL_WINS) AS totalmargin FROM ".
								          "yuser_turnover_history WHERE USER_ID=".$data["USER_ID"]." AND GAME_TRANSACTION_ID!=0");
			$gameData  =$browserSQL->row();
		} else { //SHAN GAMES
			$browserSQL=$this->db3->query("SELECT SUM(TOTAL_BETS) AS totalbets,SUM(TOTAL_WINS) AS totalwins,SUM(TOTAL_BETS-TOTAL_WINS) AS totalmargin FROM ".
								          "yuser_turnover_history WHERE USER_ID=".$data["USER_ID"]." AND GAME_TRANSACTION_ID=0");
			$gameData  =$browserSQL->row();		
		}	
		return $gameData;
	}
	
		
	public function winPoints($partnerId){
  		$res=$this->db2->query("select sum(TRANSACTION_AMOUNT) as totalwins from master_transaction_history where USER_ID='".$userId."' and TRANSACTION_TYPE_ID='12'");
       	 	$winPointsInfo  =  $res->row();
			return @$winPointsInfo->totalwins;
    }

	public function getPartnerId($partnerId){
		if(!empty($partnerId))
		{
  			$res=$this->db2->query("SELECT FK_PARTNER_TYPE_ID FROM partner WHERE PARTNER_ID = '$partnerId' LIMIT 1");
        	$partnerInfo1  =  $res->row();
			return $partnerInfo1->FK_PARTNER_TYPE_ID;
		}
    }

	public function getFKPartnerId($partnerId){
		if(!empty($partnerId))
		{
  			$res=$this->db2->query("SELECT FK_PARTNER_ID FROM partner WHERE PARTNER_ID = '$partnerId' LIMIT 1");
        	$partnerInfo1  =  $res->row();
			return $partnerInfo1->FK_PARTNER_ID;
		}
    }

	public function getNameOfPartnerIds($partnerId){

		@$res0=$this->db2->query("SELECT FK_PARTNER_ID FROM partner WHERE PARTNER_ID = '$partnerId' LIMIT 1");
        $partnerInfo0  =  $res0->row();

		@$res3=$this->db2->query("SELECT FK_PARTNER_ID,PARTNER_USERNAME FROM partner WHERE PARTNER_ID = '$partnerInfo0->FK_PARTNER_ID' AND FK_PARTNER_TYPE_ID=13 LIMIT 1");
        $partnerInfo3  =  $res3->row();
  
		if((@$partnerInfo3->FK_PARTNER_ID)=="") {
			@$pid=$partnerInfo0->FK_PARTNER_ID;
			$pname1="-";
		} else {
			@$pid=$partnerInfo3->FK_PARTNER_ID;
			@$pname1=$partnerInfo3->PARTNER_USERNAME;
		}

		@$res2=$this->db2->query("SELECT FK_PARTNER_ID,PARTNER_USERNAME FROM partner WHERE PARTNER_ID = '$pid' AND FK_PARTNER_TYPE_ID=12 LIMIT 1");
        @$partnerInfo2  =  $res2->row();
		@$pname2=$partnerInfo2->PARTNER_USERNAME; 

		return $pname2."/".$pname1;
    }

	public function addPBalanceInfo($pBalanceInfo) {
		$this->db->set('CREATED_DATE', 'NOW()', FALSE);
		$browseSQL = $this->db->insert('partners_balance',$pBalanceInfo);
		return $this->db->insert_id();
	}

	public function addUserBalanceInfo($pBalanceInfo) {
		$browseSQL = $this->db->insert('user_points',$pBalanceInfo);
		return $this->db->insert_id();
	}

	public function BalanceUpdate($fromPid,$totalamount,$adminuser,$from="",$action,$comments,$internal_ref_no=''){
		    //$partnerTypeId = $this->partner_model->getPartnerId($partnerId);
			$partnerslist = $this->loggedinPartnerIDs();
			
			if(is_array($partnerslist)){
				$partnerslist=implode(",",$partnerslist);
			}

			if($partnerslist!='' && $this->session->userdata('partnerid')!=ADMIN_ID){
				$res = $this->db->query('SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID='.mysql_real_escape_string($fromPid).' AND PARTNER_ID IN('.$partnerslist.')');
				$partner =  $res->row();
				$partner_current_bal = $partner->AMOUNT;
			}else{
				$res = $this->db->query('SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID='.mysql_real_escape_string($fromPid).'');
				$partner =  $res->row();
				$partner_current_bal = $partner->AMOUNT;
			}
			
		if(isset($partner_current_bal)){
			$this->db->trans_begin();
	
			if($from=='cAgent' && $action=='add')
			{
				$balancetype=1;
				$transtype=22;
				$transstatus=130;
				$update_bal=$this->db->query('update partners_balance SET AMOUNT = AMOUNT + '.$totalamount.', MODIFIED_DATE = now() where PARTNER_ID='.mysql_real_escape_string($fromPid).'');
				$partner_closing_bal=$partner_current_bal+$totalamount;
			}
			elseif($from=='cAgent' && $action=='remove')
			{
				$balancetype=1;
				$transtype=22;
				$transstatus=131;
				$update_bal=$this->db->query('update partners_balance SET AMOUNT = AMOUNT - '.$totalamount.', MODIFIED_DATE = now() where PARTNER_ID='.mysql_real_escape_string($fromPid).'');
				$partner_closing_bal=$partner_current_bal-$totalamount;
			}
			elseif($from=='newPartner' && $action=='add')
			{
				$balancetype=1;
				$transtype=8;
				$transstatus=103;
				$partner_current_bal = 0;
				$update_bal=$this->db->query('update partners_balance SET AMOUNT = AMOUNT + '.$totalamount.', MODIFIED_DATE = now() where PARTNER_ID='.mysql_real_escape_string($fromPid).'');
				$partner_closing_bal=$totalamount;
			}
	
			$data['PARTNER_ID']=$fromPid;
			$data['TRANSACTION_TYPE_ID']=$transtype;
			$data['TRANSACTION_STATUS_ID']=$transstatus;
			$data['AMOUNT']=$totalamount;
			$data['INTERNAL_REFERENCE_NO']=$internal_ref_no;
			$data['CURRENT_TOT_BALANCE']=$partner_current_bal;
			$data['CLOSING_TOT_BALANCE']=$partner_closing_bal;
			$data['PROCESSED_BY']=$adminuser;
	
			if($update_bal){
				$this->db->set('CREATED_TIMESTAMP', 'NOW()', FALSE);
				$insert_partner_trans = $this->db->insert('partners_transaction_details',$data);
				if($insert_partner_trans){
					$adjdata['FK_PARTNER_ID']=$fromPid;
					$adjdata['FK_TRANSACTION_TYPE_ID']=$transtype;
					$adjdata['INTERNAL_REFERENCE_NO']=$internal_ref_no;
					$adjdata['ADJUSTMENT_CREATED_BY']=$adminuser;
					$adjdata['ADJUSTMENT_AMOUNT']=$totalamount;
					$adjdata['ADJUSTMENT_ACTION']=$action;
					$adjdata['ADJUSTMENT_COMMENT']=$comments;
					$this->db->set('ADJUSTMENT_CREATED_ON', 'NOW()', FALSE);
	
					$insert_partner_adjust = $this->db->insert('partner_adjustment_transaction',$adjdata);
					if($insert_partner_adjust){
						$masterdata['FK_PARTNER_ID']=$fromPid;
						$masterdata['FK_BALANCE_TYPE_ID']=$balancetype;
						$masterdata['FK_TRANSACTION_STATUS_ID']=$transstatus;
						$masterdata['FK_TRANSACTION_TYPE_ID']=$transtype;
						$masterdata['TRANSACTION_AMOUNT']=$totalamount;
						$masterdata['INTERNAL_REFERENCE_NO']=$internal_ref_no;
						$masterdata['CURRENT_TOT_BALANCE']=$partner_current_bal;
						$masterdata['CLOSING_TOT_BALANCE']=$partner_closing_bal;
						$this->db->set('TRANSACTION_DATE', 'NOW()', FALSE);
						$insert_partner_master = $this->db->insert('master_transaction_partner_history',$masterdata);
					}
				}
			}
	
			if($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return 2;
			}else{
				$this->db->trans_commit();
				return 1;
			}
	  }else{
	  		return 2;
	  }
	}

	public function userBalanceUpdate($userid,$amount,$partnerid,$username,$partnername) {
		$internal_ref_no='151'.$userid.date('d').date('m').date('y').date('H').date('i').date('s');
		//$session_data=$this->session->all_userdata();
		//$partnername=$session_data['partnerusername'];

		$mdata['USER_ID'] = $userid;
		$mdata['BALANCE_TYPE_ID'] = 1;
		$mdata['TRANSACTION_STATUS_ID'] = 103;
		$mdata['TRANSACTION_TYPE_ID'] = 8;
		$mdata['INTERNAL_REFERENCE_NO'] = $internal_ref_no;
		$mdata['CURRENT_TOT_BALANCE'] = 0 ;
		$mdata['CLOSING_TOT_BALANCE'] = $amount;
		$mdata['TRANSACTION_AMOUNT'] = $amount;
		$mdata['PARTNER_ID'] = $partnerid;
		$this->db->set('TRANSACTION_DATE', 'NOW()', FALSE);
		$this->db->insert('master_transaction_history',$mdata);

		$adata['ADJUSTMENT_TRANSACTION_ID'] = '';
		$adata['USER_ID'] = $userid;
		$adata['COIN_TYPE_ID'] = 1;
		$adata['TRANSACTION_TYPE_ID'] = 8;
		$adata['INTERNAL_REFERENCE_NO'] = $internal_ref_no;
		$adata['ADJUSTMENT_CREATED_BY'] = $partnername;
		$adata['ADJUSTMENT_AMOUNT'] = $amount;
		$adata['ADJUSTMENT_ACTION'] = "Add";
		$adata['ADJUSTMENT_COMMENT'] = '';
		$this->db->set('ADJUSTMENT_CREATED_ON', 'NOW()', FALSE);
		$this->db->insert('adjustment_transaction',$adata);

		$agentbal=$this->getPartnerBalance($partnerid);

		$newcurbal   = $agentbal;
		$newclosebal = $agentbal-$amount;

		$pdata['PARTNER_ID'] = $partnerid;
		$pdata['TRANSACTION_TYPE_ID'] =  8;
		$pdata['TRANSACTION_STATUS_ID'] = 103;
		$pdata['AMOUNT'] = $amount;
		$pdata['INTERNAL_REFERENCE_NO'] = $internal_ref_no;
		$pdata['CURRENT_TOT_BALANCE'] = $newcurbal;
		$pdata['CLOSING_TOT_BALANCE'] = $newclosebal;
		$pdata['USER_ID'] = $userid;
		$pdata['PROCESSED_BY'] =  $partnername;
		$this->db->set('CREATED_TIMESTAMP', 'NOW()', FALSE);
		$this->db->insert('partners_transaction_details',$pdata);

		$psdata['PARTNER_ID'] = $partnerid;
		$psdata['TRANSACTION_TYPE_ID'] =  8;
		$psdata['TRANSACTION_STATUS_ID'] = 131;
		$psdata['AMOUNT'] = $amount;
		$psdata['INTERNAL_REFERENCE_NO'] = $internal_ref_no;
		$psdata['CURRENT_TOT_BALANCE'] = $newcurbal;
		$psdata['CLOSING_TOT_BALANCE'] = $newclosebal;
		$psdata['PROCESSED_BY'] =  $username;
		$this->db->set('CREATED_TIMESTAMP', 'NOW()', FALSE);
		$this->db->insert('partners_transaction_details',$psdata);


		$padata['ADJUSTMENT_TRANSACTION_ID'] = '';
		$padata['FK_PARTNER_ID'] =  $partnerid;
		$padata['FK_TRANSACTION_TYPE_ID'] = 8;
		$padata['INTERNAL_REFERENCE_NO'] = $internal_ref_no;
		$padata['ADJUSTMENT_CREATED_BY'] = $username;
		$padata['ADJUSTMENT_AMOUNT'] = $amount;
		$padata['ADJUSTMENT_ACTION'] = "Add";
		$this->db->set('ADJUSTMENT_CREATED_ON', 'NOW()', FALSE);
		$this->db->insert('partner_adjustment_transaction',$padata);

		$this->db->query('UPDATE partners_balance SET AMOUNT=AMOUNT - '.$amount.' WHERE PARTNER_ID='.$partnerid);

	}


	public function chainPartner($ptype,$pid='') {
		$this->load->database();
		$this->db2->select('PARTNER_ID,PARTNER_NAME,PARTNER_USERNAME')->from('partner');
		$this->db2->where('FK_PARTNER_TYPE_ID',$ptype);
		if($pid > 0)
			$this->db2->where('FK_PARTNER_ID',$pid);

		$browseSQL = $this->db2->get();
		//echo  $this->db2->last_query();
		return $browseSQL->result();
	}

	public function balanceCheck($pid) {
		$this->load->database();

		$get_settings = $this->db2->query("SELECT `AMOUNT` FROM `partners_balance` WHERE `PARTNER_ID`='$pid'");
		$row = $get_settings->row();
		$amt = $get_settings->row()->AMOUNT;
		return $amt;
	}

	public function minigamesList($uGames='') {

/*	   print_r($uGames);
	   if($uGames != '')
		$uGames = explode(',',$uGames);
       else
	    $uGames = '';*/

		$this->load->database();
		$this->db2->select('MINIGAMES_NAME,DESCRIPTION,MINIGAMES_ID')->from('minigames');
		$this->db2->where('STATUS',1);
		//$this->db2->where_not_in('MINIGAMES_ID', 62); 
		if($uGames!='' && !empty($uGames))
			$this->db2->where_in('MINIGAMES_NAME', $uGames);

		$browseSQL = $this->db2->get();
		//echo $this->db2->last_query(); die;
		return $browseSQL->result();
	}

	function getAllMainAgentPartnerIds(){
		$querycnt=$this->db2->query("select PARTNER_ID,PARTNER_USERNAME from partner where PARTNER_STATUS=1 AND FK_PARTNER_TYPE_ID=11");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function getmPartnerBalance($partnerid){
  		$res=$this->db2->query("SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID = '$partnerid' LIMIT 1");
        $partnerBalanceInfo  =  $res->row();
		return @$partnerBalanceInfo->AMOUNT;
    }

	public function getUserBalance($userId){
  		$res=$this->db2->query("SELECT USER_TOT_BALANCE FROM user_points WHERE USER_ID = '$userId' LIMIT 1");
        $userBalanceInfo  =  $res->row();
		return $userBalanceInfo->USER_TOT_BALANCE;
    }

	public function getUserIdByName($name){
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		$partnerIds = $this->loggedinPartnerIDs();

		if($partnerIds!='' && !is_array($partnerIds)){
			$ids=" AND PARTNER_ID IN(".$partnerIds.")";
		}elseif($partnerIds!=''){
			$partnerIds1=implode(",",$partnerIds);
			$ids=" AND PARTNER_ID IN(".$partnerIds1.")";
		}else{
			$ids='';
		}
	    $query  = $this->db2->query("select USER_ID from user where USERNAME= '$name' $ids");
		
		$result = $query->row();
		return @$result->USER_ID;
	}

	public function getPartnerIdByUsername($name){
		$partnerIds="";
		if($this->session->userdata('partnerid')!=ADMIN_ID)
		$partnerIds = $this->loggedinPartnerIDs();

		if($partnerIds!='' && !is_array($partnerIds)){
			$ids=" AND PARTNER_ID IN(".$partnerIds.")";
		}elseif($partnerIds!=''){
			$partnerIds1=implode(",",$partnerIds);
			$ids=" AND PARTNER_ID IN(".$partnerIds1.")";
		}else{
			$ids='';
		}
	    $query  = $this->db2->query("select PARTNER_ID from user where USERNAME= '$name' $ids");
		//echo $this->db2->last_query();exit;
		$result = $query->row();
		return @$result->PARTNER_ID;
	}

	public function addPgamesInfo($pGameInfo) {
		$this->db->set('CREATED_DATE', 'NOW()', FALSE);
		$browseSQL = $this->db->insert('agent_game_revenueshare',$pGameInfo);
		return $this->db->insert_id();
	}

	public function partnerBaseMinigamesList($partnerid) {
		$this->load->database();

		$get_agames = $this->db2->query("SELECT GROUP_CONCAT(`GAME_ID`) AS gameList FROM `agent_game_revenueshare` WHERE `PARTNER_ID`='$partnerid'");
		$row = $get_agames->row();
		$aGamelist = $get_agames->row()->gameList;
		if($aGameList != ''){
		  $gameArray = explode(",",$aGameList);
		}else{
		  $gameArray = '';
		}
		return $gameArray;

	}

	public function partnerMinigamesList($partnerid) {
		$this->load->database();

		$this->db2->select('GAME_ID,GAME_REVENUE_SHARE')->from('agent_game_revenueshare');
		$this->db2->where('PARTNER_ID',$partnerid);

		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function partnerShanMinigamePercent($partnerid) {
		$this->load->database();

		$this->db2->select('GAME_ID,GAME_REVENUE_SHARE')->from('agent_game_revenueshare');
		$this->db2->where('PARTNER_ID',$partnerid);
		$this->db2->where('GAME_ID',ONLINE_GAME_NAME);

		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}
	
	public function partnerMinigamePercent($data) {
		$this->load->database();

		$this->db2->select('GAME_ID,GAME_REVENUE_SHARE')->from('agent_game_revenueshare');
		if(!empty($data['partner_id'])){
			$this->db2->where('PARTNER_ID',$data['partner_id']);
		}
		if(!empty($data['game_name'])){
			$this->db2->where('GAME_ID',$data['game_name']);
		}

		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function getExistingUserRolesIDs($adminUserID) {
		$get_amenu = $this->db2->query("SELECT GROUP_CONCAT(`FK_ROLE_ID`) AS roleID FROM `role_to_admin` WHERE `FK_ADMIN_USER_ID`='$adminUserID'");
		$row = $get_amenu->row();
		$aMenulist = explode(',',$get_amenu->row()->roleID);
		return $aMenulist;
	}
	public function addPSgamesInfo($pGameInfo) {
		$this->db->set('CREATED_DATE', 'NOW()', FALSE);
		$browseSQL = $this->db->insert('agent_game_revenueshare',$pGameInfo);
		return $this->db->insert_id();
	}

	public function updateUserMinigames($gameId, $revenue, $adminUserID) {
		
		//$this->db->where('PARTNER_ID', $adminUserID);
		//$this->db->delete('agent_game_revenueshare');

		$i=0;
		foreach($gameId as $agames){
			//if($revenue[$i] > 0) {
				// $aGamesInfo['PARTNER_ID'] = $adminUserID;
				// $aGamesInfo['GAME_ID'] = $agames;
				$aGamesInfo['GAME_REVENUE_SHARE'] = $revenue[$i];
				$aGamesInfo['CREATED_DATE'] = date('Y-m-d h:i:s');
				
				$this->db->where('PARTNER_ID', $adminUserID);
				$this->db->where('GAME_ID', $agames);
				$addGamesInfo = $this->db->update('agent_game_revenueshare',$aGamesInfo);
				
				/** report database table **/
				/*
				$this->db3->where('PARTNER_ID', $adminUserID);
				$this->db3->where('GAME_ID', $agames);
				$addGamesInfo = $this->db3->update('agent_game_revenueshare',$aGamesInfo);
				*/
		//	}
			$i++;
		}


		/* if($shanGamePer != ''){
		//insert shan game
			$sGamesInfo['PARTNER_ID'] = $adminUserID;
			$sGamesInfo['GAME_ID'] = ONLINE_GAME_NAME;
			$sGamesInfo['GAME_REVENUE_SHARE'] = $shanGamePer;
			$sGamesInfo['CREATED_DATE'] = date('Y-m-d h:i:s');
			$sddGamesInfo = $this->db->insert('agent_game_revenueshare',$sGamesInfo);
		} else {
			$sGamesInfo['PARTNER_ID'] = $adminUserID;
			$sGamesInfo['GAME_ID'] = ONLINE_GAME_NAME;
			$sGamesInfo['GAME_REVENUE_SHARE'] = 0;
			$sGamesInfo['CREATED_DATE'] = date('Y-m-d h:i:s');
			$sddGamesInfo = $this->db->insert('agent_game_revenueshare',$sGamesInfo);
		}
		
		if(!empty($pokerGamePer)){
		//insert poker game
			$pGamesInfo['PARTNER_ID'] = $adminUserID;
			$pGamesInfo['GAME_ID'] = ONLINE_POKER_GAME_NAME;
			$pGamesInfo['GAME_REVENUE_SHARE'] = $pokerGamePer;
			$pGamesInfo['CREATED_DATE'] = date('Y-m-d h:i:s');
			$paddGamesInfo = $this->db->insert('agent_game_revenueshare',$pGamesInfo);
		}  */
	}

	public function updateChangePass($datapass) {
		$OLDPASSWORD = md5($datapass['old_pass']);
    	$NEWPASSWORD = md5($datapass['new_pass']);

		if($OLDPASSWORD){
            #check old password
		    $sql_oldpass=$this->db2->query("select ADMIN_USER_ID,FK_PARTNER_ID from admin_user where PASSWORD='".$OLDPASSWORD."' and FK_PARTNER_ID='".$this->session->userdata('partnerid')."'");
            if($sql_oldpass->num_rows>0){
				if($OLDPASSWORD==$NEWPASSWORD){
					$err=3;
				}else{
					$result = $sql_oldpass->row();
					if($NEWPASSWORD){
						$updateUser=$this->db->query("update admin_user set PASSWORD='".$NEWPASSWORD."' where ADMIN_USER_ID='".$result->ADMIN_USER_ID."'");
						$err=1;
					}
				}
            }else{
                $err=2;
            }
        }
        return $err;
	}

	public function updateChangeTransPass($datapass) {
		$OLDPASSWORD = md5($datapass['old_pass']);
    	$NEWPASSWORD = md5($datapass['new_pass']);

		if($OLDPASSWORD){
            #check old password
		         $sql_oldpass=$this->db2->query("select ADMIN_USER_ID,FK_PARTNER_ID from admin_user where TRANSACTION_PASSWORD='".$OLDPASSWORD."' and FK_PARTNER_ID='".$this->session->userdata('partnerid')."'");
				// echo $this->db->last_query();
            if($sql_oldpass->num_rows>0){
				if($OLDPASSWORD==$NEWPASSWORD){
					$err=3;
				}else{
					$result = $sql_oldpass->row();
					if($NEWPASSWORD){
						$updateUser=$this->db->query("update admin_user set TRANSACTION_PASSWORD='".$NEWPASSWORD."' where ADMIN_USER_ID='".$result->ADMIN_USER_ID."'");
						//echo $this->db->last_query();
						//$updatePartner=$this->db->query("update partner set PARTNER_PASSWORD='".$NEWPASSWORD."' where PARTNER_ID='".$result->FK_PARTNER_ID."'");
						$err=1;
					}
				}
            }else{
                $err=2;
            }
        }
       return $err;
	}

	public function checkTransPass($password) {
		#Check trans password
		$adUserName = $this->session->userdata['adminusername'];
		$sql_transpass=$this->db2->query("select ADMIN_USER_ID from admin_user where USERNAME='".$adUserName."' AND TRANSACTION_PASSWORD='".$password."' AND ONLINE_AGENT_STATUS='1'");
		if($sql_transpass->num_rows>0){
			$err=1;
		}else{
			$err=2;
		}
		return $err;
	}

	public function checkTransPassExist() {
		#Check trans password
		$adUserName = $this->session->userdata['adminusername'];
		$sql_transExist=$this->db2->query("select ADMIN_USER_ID from admin_user where USERNAME='".$adUserName."' AND TRANSACTION_PASSWORD!='' AND ONLINE_AGENT_STATUS='1'");
		if($sql_transExist->num_rows>0){
			$res=1;
		}else{
			$res=2;
		}
		return $res;
	}


	public function userMinigamesList($adminUserID) {
		$get_agame = $this->db2->query("SELECT GROUP_CONCAT(`GAME_ID`) AS gameIds FROM `agent_game_revenueshare` WHERE `PARTNER_ID`='$adminUserID'");
		$row = $get_agame->row();
		$aMenulist = explode(',',$get_agame->row()->gameIds);
		return $aMenulist;
	}

	public function getAllPatrnerInfos($mainAgentId){
  		$res=$this->db2->query("Select PARTNER_ID,PARTNER_USERNAME,FK_PARTNER_TYPE_ID from partner where FK_PARTNER_ID = '$mainAgentId'");
        $partnerInfo  =  $res->result();
		return  $partnerInfo;

  }

	public function loggedinPartnerIDs() {
		$subdistids='';
		$session_data=$this->session->all_userdata();

		$partner_id=$session_data['partnerid'];
		$partner_type_id=$session_data['partnertypeid'];

	  if($session_data['partnerid']!=ADMIN_ID){

		if($partner_type_id=="11"){
			
			#Get all super distributors
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			$this->db2->where("FK_PARTNER_TYPE_ID",15);
			$supdistributorIds = $this->db2->get();
			$supdistributor_result=$supdistributorIds->result();
			
			if($supdistributor_result){
				$partnerids="";
				$supdistributorids="";
				foreach($supdistributor_result as $value){
					if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
						$partnerids=$value->PARTNER_ID;
					}
			
					if($supdistributorids){
						$supdistributorids=$supdistributorids.",".$value->PARTNER_ID;
					}else{
						$supdistributorids=$value->PARTNER_ID;
					}
				}
			}
			
 			#Get all distributors
 			if ($supdistributorids){
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($supdistributorids,",")){
					$supdistributorids1=explode(",",$supdistributorids);
				}else{
					$supdistributorids1=$supdistributorids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$supdistributorids1);
				//$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",12);
				
				$distributorIds = $this->db2->get();
				$distributor_result=$distributorIds->result();
	
				if($distributor_result){
					$distributorids="";
					foreach($distributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}
	
						if($distributorids){
						$distributorids=$distributorids.",".$value->PARTNER_ID;
						}else{
						$distributorids=$value->PARTNER_ID;
						}
					}
				}
 			}
 			//echo '<pre>';print_r($partnerids);exit;

//echo $partnerids;

			if(@$partnerids){
				#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($partnerids,",")){
					$partnerids1=explode(",",$partnerids);
				}else{
					$partnerids1=$partnerids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$partnerids1);
				//$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					//$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($distributorids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($distributorids,",")){
						$distributorids=explode(",",$distributorids);
					}else{
						$distributorids=$distributorids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$distributorids);
					//$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();

					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
            }else{
                $partnerids='';
            }
			

	}elseif($partner_type_id=="15"){
 			#Get all distributors
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			//$this->db2->where("PARTNER_STATUS",1);
			$this->db2->where("FK_PARTNER_TYPE_ID",12);

			$distributorIds = $this->db2->get();
			$distributor_result=$distributorIds->result();

			if($distributor_result){
				$partnerids="";
				$distributorids="";
				foreach($distributor_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}

					if($distributorids){
					$distributorids=$distributorids.",".$value->PARTNER_ID;
					}else{
					$distributorids=$value->PARTNER_ID;
					}
				}
			}


//echo $partnerids;

			if(@$partnerids){
				#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($partnerids,",")){
					$partnerids1=explode(",",$partnerids);
				}else{
					$partnerids1=$partnerids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$partnerids1);
				//$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					//$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($distributorids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($distributorids,",")){
						$distributorids=explode(",",$distributorids);
					}else{
						$distributorids=$distributorids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$distributorids);
					//$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();

					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
            }else{
                $partnerids='';
            }

	}elseif($partner_type_id=="12"){
			$partnerids="";
			#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				$this->db2->where_in("FK_PARTNER_ID",$partner_id);
				//$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					//$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($partner_id){
					$this->db2->select("PARTNER_ID")->from("partner");
					$this->db2->where_in("FK_PARTNER_ID",$partner_id);
					//$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();
					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
	}elseif($partner_type_id=="13"){
			$partnerids="";
				#Get all agents of sub distributor
				$this->db2->select("PARTNER_ID")->from("partner");
				$this->db2->where_in("FK_PARTNER_ID",$partner_id);
				//$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",14);

				$subdistributor_agentIds = $this->db2->get();
				$subdistributor_agentresult=$subdistributor_agentIds->result();

				if($subdistributor_agentresult){
					foreach($subdistributor_agentresult as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}
					}
				}


	}elseif($partner_type_id=="14"){
			$partnerids=$partner_id;
	}

	if(@$partnerids==''){
	  $partnerids=-1;
	}
   }else{
   			$a_partner_ids = array(11,12,13,14,15);
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("PARTNER_ID !=",$partner_id);
			$this->db2->where_in("FK_PARTNER_TYPE_ID",$a_partner_ids);

			//$this->db2->where("PARTNER_STATUS",1);
			$allPartnerIds = $this->db2->get();
			$partnerIds_result=$allPartnerIds->result();
			$partnerids="";
			if($partnerIds_result){
				foreach($partnerIds_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}
				}
			}

   }

   if($partnerids!=''){
   	$partnerids2=$partnerids.",".$partner_id;
   }else{
   	$partnerids2=$partner_id;
   }

   if(strstr($partnerids2,",")){
   		$partnerids2=explode(",",$partnerids2);
   }else{
   		$partnerids2=$partnerids2;
   }


	$this->db2->flush_cache();
    return	$partnerids2;
  }


  public function loggedinPartnerIDList() {
		$session_data=$this->session->all_userdata();

		$partner_id=$session_data['partnerid'];
		$partner_type_id=$session_data['partnertypeid'];

	  if($session_data['partnerid']!=ADMIN_ID){

		if($partner_type_id=="11"){
 			/* #Get all distributors
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			$this->db2->where("PARTNER_STATUS",1);
			$this->db2->where("FK_PARTNER_TYPE_ID",12);

			$distributorIds = $this->db2->get();
			$distributor_result=$distributorIds->result();

			if($distributor_result){
				$partnerids="";
				$distributorids="";
				foreach($distributor_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}

					if($distributorids){
					$distributorids=$distributorids.",".$value->PARTNER_ID;
					}else{
					$distributorids=$value->PARTNER_ID;
					}
				}
			} */


			#Get all super distributors
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			$this->db2->where("PARTNER_STATUS",1);
			$this->db2->where("FK_PARTNER_TYPE_ID",15);
			$supdistributorIds = $this->db2->get();
			$supdistributor_result=$supdistributorIds->result();
			
			if($supdistributor_result){
				$partnerids="";
				$supdistributorids="";
				foreach($supdistributor_result as $value){
					if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
						$partnerids=$value->PARTNER_ID;
					}
			
					if($supdistributorids){
						$supdistributorids=$supdistributorids.",".$value->PARTNER_ID;
					}else{
						$supdistributorids=$value->PARTNER_ID;
					}
				}
			}
			
			#Get all distributors
			if ($supdistributorids){
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($supdistributorids,",")){
					$supdistributorids1=explode(",",$supdistributorids);
				}else{
					$supdistributorids1=$supdistributorids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$supdistributorids1);
				$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",12);
					
				$distributorIds = $this->db2->get();
				$distributor_result=$distributorIds->result();
					
				if($distributor_result){
					$distributorids="";
					foreach($distributor_result as $value){
						if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
							$partnerids=$value->PARTNER_ID;
						}
							
						if($distributorids){
							$distributorids=$distributorids.",".$value->PARTNER_ID;
						}else{
							$distributorids=$value->PARTNER_ID;
						}
					}
				}
			}
//echo $partnerids;

			if(@$partnerids){
				#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($partnerids,",")){
					$partnerids1=explode(",",$partnerids);
				}else{
					$partnerids1=$partnerids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$partnerids1);
				$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($distributorids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($distributorids,",")){
						$distributorids=explode(",",$distributorids);
					}else{
						$distributorids=$distributorids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$distributorids);
					$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();

					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
            }else{
                $partnerids='';
            }

	}if($partner_type_id=="15"){
 			#Get all distributors
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			$this->db2->where("PARTNER_STATUS",1);
			$this->db2->where("FK_PARTNER_TYPE_ID",12);

			$distributorIds = $this->db2->get();
			$distributor_result=$distributorIds->result();

			if($distributor_result){
				$partnerids="";
				$distributorids="";
				foreach($distributor_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}

					if($distributorids){
					$distributorids=$distributorids.",".$value->PARTNER_ID;
					}else{
					$distributorids=$value->PARTNER_ID;
					}
				}
			}


//echo $partnerids;

			if(@$partnerids){
				#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($partnerids,",")){
					$partnerids1=explode(",",$partnerids);
				}else{
					$partnerids1=$partnerids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$partnerids1);
				$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($distributorids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($distributorids,",")){
						$distributorids=explode(",",$distributorids);
					}else{
						$distributorids=$distributorids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$distributorids);
					$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();

					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
            }else{
                $partnerids='';
            }

	}elseif($partner_type_id=="12"){
			$partnerids="";
			#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				$this->db2->where_in("FK_PARTNER_ID",$partner_id);
				$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($partner_id){
					$this->db2->select("PARTNER_ID")->from("partner");
					$this->db2->where_in("FK_PARTNER_ID",$partner_id);
					$this->db2->where("PARTNER_STATUS",1);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();
					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
	}elseif($partner_type_id=="13"){
			$partnerids="";
				#Get all agents of sub distributor
				$this->db2->select("PARTNER_ID")->from("partner");
				$this->db2->where_in("FK_PARTNER_ID",$partner_id);
				$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",14);

				$subdistributor_agentIds = $this->db2->get();
				$subdistributor_agentresult=$subdistributor_agentIds->result();

				if($subdistributor_agentresult){
					foreach($subdistributor_agentresult as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}
					}
				}


	}elseif($partner_type_id=="14"){
			$partnerids=$partner_id;
	}

	if($partnerids==''){
	  $partnerids=-1;
	}
   }else{
   			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("PARTNER_ID !=",$partner_id);
			$this->db2->where("PARTNER_STATUS",1);
			$allPartnerIds = $this->db2->get();
			$partnerIds_result=$allPartnerIds->result();
			$partnerids="";
			if($partnerIds_result){
				foreach($partnerIds_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}
				}
			}

   }

   $partnerids2=$partnerids;

   if(strstr($partnerids2,",")){
   		$partnerids2=explode(",",$partnerids2);
   }else{
   		$partnerids2=$partnerids2;
   }


	$this->db->flush_cache();
	 return	$partnerids2;
  }


  public function loggedinAllPartnerIDs() {
		$session_data=$this->session->all_userdata();

		$partner_id=$session_data['partnerid'];
		$partner_type_id=$session_data['partnertypeid'];

	  if($session_data['partnerid']!=ADMIN_ID){

		if($partner_type_id=="11"){
 			#Get all distributors
			/* $this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			$this->db2->where("FK_PARTNER_TYPE_ID",12);

			$distributorIds = $this->db2->get();
			$distributor_result=$distributorIds->result();

			if($distributor_result){
				$partnerids="";
				$distributorids="";
				foreach($distributor_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}

					if($distributorids){
					$distributorids=$distributorids.",".$value->PARTNER_ID;
					}else{
					$distributorids=$value->PARTNER_ID;
					}
				}
			} */
			
			
			#Get all super distributors
			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("FK_PARTNER_ID",$partner_id);
			$this->db2->where("FK_PARTNER_TYPE_ID",15);
			$supdistributorIds = $this->db2->get();
			$supdistributor_result=$supdistributorIds->result();
				
			if($supdistributor_result){
				$partnerids="";
				$supdistributorids="";
				foreach($supdistributor_result as $value){
					if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
						$partnerids=$value->PARTNER_ID;
					}
						
					if($supdistributorids){
						$supdistributorids=$supdistributorids.",".$value->PARTNER_ID;
					}else{
						$supdistributorids=$value->PARTNER_ID;
					}
				}
			}
				
			#Get all distributors
			if ($supdistributorids){
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($supdistributorids,",")){
					$supdistributorids1=explode(",",$supdistributorids);
				}else{
					$supdistributorids1=$supdistributorids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$supdistributorids1);
				//$this->db2->where("PARTNER_STATUS",1);
				$this->db2->where("FK_PARTNER_TYPE_ID",12);
			
				$distributorIds = $this->db2->get();
				$distributor_result=$distributorIds->result();
			
				if($distributor_result){
					$distributorids="";
					foreach($distributor_result as $value){
						if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
							$partnerids=$value->PARTNER_ID;
						}
			
						if($distributorids){
							$distributorids=$distributorids.",".$value->PARTNER_ID;
						}else{
							$distributorids=$value->PARTNER_ID;
						}
					}
				}
			}


//echo $partnerids;

			if(@$partnerids){
				#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($partnerids,",")){
					$partnerids1=explode(",",$partnerids);
				}else{
					$partnerids1=$partnerids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$partnerids1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($distributorids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($distributorids,",")){
						$distributorids=explode(",",$distributorids);
					}else{
						$distributorids=$distributorids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$distributorids);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();

					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
            }else{
                $partnerids='';
            }

	}elseif($partner_type_id=="15"){
 			#Get all distributors
				$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
				$this->db2->where("FK_PARTNER_ID",$partner_id);
				$this->db2->where("FK_PARTNER_TYPE_ID",12);
	
				$distributorIds = $this->db2->get();
				$distributor_result=$distributorIds->result();
	
				if($distributor_result){
					$partnerids="";
					$distributorids="";
					foreach($distributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}
	
						if($distributorids){
						$distributorids=$distributorids.",".$value->PARTNER_ID;
						}else{
						$distributorids=$value->PARTNER_ID;
						}
					}
				} 
			//echo $partnerids;

			if(@$partnerids){
				#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				if(strstr($partnerids,",")){
					$partnerids1=explode(",",$partnerids);
				}else{
					$partnerids1=$partnerids;
				}
				$this->db2->where_in("FK_PARTNER_ID",$partnerids1);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($distributorids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($distributorids,",")){
						$distributorids=explode(",",$distributorids);
					}else{
						$distributorids=$distributorids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$distributorids);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();

					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
            }else{
                $partnerids='';
            }

	}elseif($partner_type_id=="12"){
			$partnerids="";
			#Get all sub distributors
				$this->db2->select("PARTNER_ID")->from("partner");
				$this->db2->where_in("FK_PARTNER_ID",$partner_id);
				$this->db2->where("FK_PARTNER_TYPE_ID",13);

				$subdistributorIds = $this->db2->get();
				$subdistributor_result=$subdistributorIds->result();

				if($subdistributor_result){

					$subdistids="";
					foreach($subdistributor_result as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}

						if($subdistids){
						$subdistids=$subdistids.",".$value->PARTNER_ID;
						}else{
						$subdistids=$value->PARTNER_ID;
						}
					}
				}


				#Get all agents of sub distributor

				if($subdistids){
					$this->db2->select("PARTNER_ID")->from("partner");
					if(strstr($subdistids,",")){
						$subdistids=explode(",",$subdistids);
					}else{
						$subdistids=$subdistids;
					}
					$this->db2->where_in("FK_PARTNER_ID",$subdistids);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$subdistributor_agentIds = $this->db2->get();
					$subdistributor_agentresult=$subdistributor_agentIds->result();

					if($subdistributor_agentresult){
						foreach($subdistributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}

				#Get all agents of distributor

				if($partner_id){
					$this->db2->select("PARTNER_ID")->from("partner");
					$this->db2->where_in("FK_PARTNER_ID",$partner_id);
					$this->db2->where("FK_PARTNER_TYPE_ID",14);

					$distributor_agentIds = $this->db2->get();
					$distributor_agentresult=$distributor_agentIds->result();

					if($distributor_agentresult){
						foreach($distributor_agentresult as $value){
							if($partnerids){
							$partnerids=$partnerids.",".$value->PARTNER_ID;
							}else{
							$partnerids=$value->PARTNER_ID;
							}
						}
					}
				}
	}elseif($partner_type_id=="13"){
			$partnerids="";
				#Get all agents of sub distributor
				$this->db2->select("PARTNER_ID")->from("partner");
				$this->db2->where_in("FK_PARTNER_ID",$partner_id);
				$this->db2->where("FK_PARTNER_TYPE_ID",14);

				$subdistributor_agentIds = $this->db2->get();
				$subdistributor_agentresult=$subdistributor_agentIds->result();

				if($subdistributor_agentresult){
					foreach($subdistributor_agentresult as $value){
						if($partnerids){
						$partnerids=$partnerids.",".$value->PARTNER_ID;
						}else{
						$partnerids=$value->PARTNER_ID;
						}
					}
				}


	}elseif($partner_type_id=="14"){
			$partnerids=$partner_id;
	}

	if(@$partnerids==''){
	  $partnerids=-1;
	}
   }else{
   			$this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
			$this->db2->where("PARTNER_ID !=",$partner_id);
			$allPartnerIds = $this->db2->get();
			$partnerIds_result=$allPartnerIds->result();
			$partnerids="";
			if($partnerIds_result){
				foreach($partnerIds_result as $value){
					if($partnerids){
					$partnerids=$partnerids.",".$value->PARTNER_ID;
					}else{
					$partnerids=$value->PARTNER_ID;
					}
				}
			}

   }

   if($partnerids!=''){
   	$partnerids2=$partnerids.",".$partner_id;
   }else{
   	$partnerids2=$partner_id;
   }

   if(strstr($partnerids2,",")){
   		$partnerids2=explode(",",$partnerids2);
   }else{
   		$partnerids2=$partnerids2;
   }


	$this->db->flush_cache();

	 return	$partnerids2;
  }

	function getLoggedinPartnerUserIds($loggedin_partnerids) {

		$this->db2->select('t1.USER_ID')->from('user t1');
		$this->db2->where_in('t1.PARTNER_ID',$loggedin_partnerids);
		$allPartnerUserIds = $this->db2->get();
		$partnerUserIds_result=$allPartnerUserIds->result();
		
		$partnerUserids=array();
		if($partnerUserIds_result){
			foreach($partnerUserIds_result as $value){
				$partnerUserids[]=$value->USER_ID;

			}
		}
		return $partnerUserids;
	}

	 public function getPartnerNameById_display($id){
	    $query  = $this->db2->query("select PARTNER_NAME from partner where PARTNER_ID= '$id'");
		$result = $query->row();
		return @$result->PARTNER_NAME;
	}
	
	public function getNameOfPartnerIds_display($partnerId){

		@$res0=$this->db2->query("SELECT FK_PARTNER_ID FROM partner WHERE PARTNER_ID = '$partnerId' LIMIT 1");
        $partnerInfo0  =  $res0->row();

		@$res3=$this->db2->query("SELECT FK_PARTNER_ID,PARTNER_NAME FROM partner WHERE PARTNER_ID = '$partnerInfo0->FK_PARTNER_ID' AND FK_PARTNER_TYPE_ID=13 LIMIT 1");
        $partnerInfo3  =  $res3->row();

		if((@$partnerInfo3->FK_PARTNER_ID)=="") {
			@$pid=$partnerInfo0->FK_PARTNER_ID;
			$pname1="-";
		} else {
			@$pid=$partnerInfo3->FK_PARTNER_ID;
			@$pname1=$partnerInfo3->PARTNER_NAME;
		}

		@$res2=$this->db2->query("SELECT FK_PARTNER_ID,PARTNER_NAME FROM partner WHERE PARTNER_ID = '$pid' AND FK_PARTNER_TYPE_ID=12 LIMIT 1");
        @$partnerInfo2  =  $res2->row();
		@$pname2=$partnerInfo2->PARTNER_NAME;

		return $pname2."/".$pname1;
    }

	public function getParentPartnerNames($partner_id,$partner_type_id,$fk_partner_id) {
            $partnerInfo1   = array();
            if($fk_partner_id == ""){
                $res            = $this->db2->query("SELECT FK_PARTNER_ID FROM partner WHERE PARTNER_ID = '$partner_id' LIMIT 1");
                $partnerInfo0   = $res->row();
                $fk_partner_id  = $partnerInfo0->FK_PARTNER_ID;
            }
            if($partner_type_id == "12") {
                $info                       = $this->getPartnerParentName($fk_partner_id,'15');
                $partnerInfo1['SUP_DIS']    = $info->PARTNER_NAME;
                
                $info1                      = $this->getPartnerParentName($info->FK_PARTNER_ID,'11');
                $partnerInfo1['MAIN_AGENT'] = $info1->PARTNER_NAME;     
            }  else if($partner_type_id == "13") { 
                $info                   = $this->getPartnerParentName($fk_partner_id,'12');
                $partnerInfo1['DIS']    = $info->PARTNER_NAME;
                
                $info1                      = $this->getPartnerParentName($info->FK_PARTNER_ID,'15');
                $partnerInfo1['SUP_DIS']    = $info1->PARTNER_NAME;
                
                $info2                      = $this->getPartnerParentName($info1->FK_PARTNER_ID,'11');
                $partnerInfo1['MAIN_AGENT'] = $info2->PARTNER_NAME;
            } else if($partner_type_id == "14") {
                $info                       = $this->getPartnerParentName($fk_partner_id,'13');
                $partnerInfo1['SUB_DIS']    = $info->PARTNER_NAME;
                
                if($info->PARTNER_NAME == ''){
                    $info1                      = $this->getPartnerParentName($fk_partner_id,'12');
                    $partnerInfo1['SUB_DIS']    = "-";
                    $partnerInfo1['DIS']        = $info1->PARTNER_NAME;
                } else {
                    $info1                      = $this->getPartnerParentName($info->FK_PARTNER_ID,'12');
                    $partnerInfo1['DIS']        = $info1->PARTNER_NAME;
                }
                
                $info2                      = $this->getPartnerParentName($info1->FK_PARTNER_ID,'15');
                $partnerInfo1['SUP_DIS']    = $info2->PARTNER_NAME;
                
                $info3                      = $this->getPartnerParentName($info2->FK_PARTNER_ID,'11');
                $partnerInfo1['MAIN_AGENT'] = $info3->PARTNER_NAME;
            } else if($partner_type_id == "15") {
                $info                       = $this->getPartnerParentName($fk_partner_id,'11');
                $partnerInfo1['MAIN_AGENT'] = $info->PARTNER_NAME;
            }          
            return $partnerInfo1;
	}

       
	public function getPartnerParentName($partner_id, $fk_partner_type_id) {  
		$this->db->select("FK_PARTNER_ID,PARTNER_NAME");
		$query = $this->db->get_where("partner", array("PARTNER_ID" => $partner_id,"FK_PARTNER_TYPE_ID"=>$fk_partner_type_id));
		$p = $query->row_array();
		if( $query->num_rows() == 1 ){  
			return $query->row();
		}
	}

	public function getCategoryInfo() {
		$this->db2->select("CATEGORY_ID")->from("categories_management");
		$this->db2->group_by('CATEGORY_ID');		 
		$category = $this->db2->get()->result();
		$categoryIDs=array();		
		if(!empty($category)) {
			foreach($category as $cIndex=>$categoryData) {
				$categoryIDs[]=$categoryData->CATEGORY_ID;
			}
		}

		$this->db2->select("*")->from("categories");
		$this->db2->where("CATEGORY_STATUS",1);
		$this->db2->where_in("CATEGORY_ID",$categoryIDs);
		$this->db2->order_by('CATEGORY_NAME', 'ASC'); 
		$categoryInfo = $this->db2->get();
		return $categoryInfo->result();		
	}

	public function getCategoryGames($categoryID) {
		$this->db2->select("MINIGAME_ID")->from("categories_management");
		$this->db2->where_in("CATEGORY_ID",$categoryID);		 
		$minigamesInfo = $this->db2->get()->result();
		$minigameIDs=array();		
		if(!empty($minigamesInfo)) {
			foreach($minigamesInfo as $mIndex=>$minigameData) {
				$minigameIDs[]=$minigameData->MINIGAME_ID;
			}
		}		

		$this->db2->select("MINIGAMES_ID,MINIGAMES_NAME,DESCRIPTION")->from("minigames");
		$this->db2->where("STATUS",1);
		$this->db2->where_in("MINIGAMES_ID",$minigameIDs);
		$this->db2->order_by('DESCRIPTION', 'ASC'); 
		$categoryGames = $this->db2->get();
		return $categoryGames->result();				
	}
	
	public function getCategoryBasedMiniGames($partnerID) {
		$this->db2->select("c.CATEGORY_ID, c.CATEGORY_NAME,m.MINIGAMES_ID,m.MINIGAMES_NAME,m.DESCRIPTION")
		->from("minigames AS m")
		->join('agent_game_revenueshare AS ag','ag.GAME_ID=m.MINIGAMES_NAME')
		->join('categories_management AS cm','cm.MINIGAME_ID= m.MINIGAMES_ID')
		->join('categories AS c','c.CATEGORY_ID=cm.CATEGORY_ID');
		if(!empty($partnerID)){
			$this->db2->where_in("ag.PARTNER_ID",$partnerID);		 
		}
		$this->db2->order_by('CATEGORY_NAME', 'ASC'); 
		$categoryGames = $this->db2->get();
		//echo $this->db2->last_query();exit;
		return $categoryGames->result_array();				
	}
	
	public function getCategoryMiniGames() {
		$this->db2->select("c.CATEGORY_ID, c.CATEGORY_NAME,m.MINIGAMES_ID,m.MINIGAMES_NAME,m.DESCRIPTION")
		->from("minigames AS m")
		->join('categories_management AS cm','cm.MINIGAME_ID= m.MINIGAMES_ID')
		->join('categories AS c','c.CATEGORY_ID=cm.CATEGORY_ID');
		$this->db2->order_by('CATEGORY_NAME', 'ASC'); 
		$categoryGames = $this->db2->get();
		return $categoryGames->result_array();				
	}
	
	public function getMinigamesInfo($minigameIDs) {
		$this->db2->select("MINIGAMES_ID,MINIGAMES_NAME,DESCRIPTION")->from("minigames");
		$this->db2->where("STATUS",1);
		$this->db2->where_in("MINIGAMES_ID",$minigameIDs);
		$this->db2->order_by('DESCRIPTION', 'ASC'); 
		$minigamesInfo = $this->db2->get();
		return $minigamesInfo->result();
	}
	
	public function getMinigamesNamesInfo($minigameNames) {
		$this->db2->select("MINIGAMES_ID,MINIGAMES_NAME,DESCRIPTION")->from("minigames");
		$this->db2->where("STATUS",1);
		$this->db2->where_in("MINIGAMES_NAME",$minigameNames);
		$this->db2->order_by('DESCRIPTION', 'ASC'); 
		$minigamesInfo = $this->db2->get();
		return $minigamesInfo->result();
	}
	public function getAGENTlist() {
		$this->db2->select('PARTNER_ID,PARTNER_USERNAME');
		$this->db2->from('partner');
		$this->db2->where('STATUS',1);
		$this->db2->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->where('PARTNER_ID !=',1);
		$this->db2->order_by('PARTNER_USERNAME', 'asc');
		$all_agent = $this->db2->get();
		$all_agent_result = $all_agent->result_array();
		return $all_agent_result;
	}

	 public function getPartherTypeBasedName($typeId){
		$name = 'Invalid';
		if(!empty($typeId)){
			
			switch ($typeId) {
				case 11:
					$name = 'Main Agent';
					break;
				case 12:
					$name = 'Distributor';
					break;
				case 13:
					$name = 'Sub Distributor';
					break;
				case 14:
					$name = 'Agent';
					break;
				case 15:
					$name = 'Super Distributor';
					break;
				default:
					$name = 'Invalid';
			}
		}
		return $name;
		
	}
	
	public function getTrackingInfo($date,$action) {
		$this->db2->select("*")->from("tracking");
		if(!empty($date)){
			$start_date	=	$date.' 00:00:00';
			$end_date	=	$date.' 23:59:59';
			$this->db2->where('DATE_TIME BETWEEN "'. date('Y-m-d H:i:s', strtotime($start_date)). '" and "'. date('Y-m-d H:i:s', strtotime($end_date)).'"');
		}
		
		if(!empty($action)){
			$this->db2->like("ACTION_NAME",$action);
		}
		
		$this->db2->order_by('tracking_id', 'desc'); 
		$resultInfo = $this->db2->get();
		
		return $resultInfo->result();
	}

	public function update_partner( $data, $partnerId )
	{
		if(empty($partnerId) && empty($data)){
			return false;
		}
		$this->db->where_in('PARTNER_ID', $partnerId);
		return $this->db->update( 'partner', $data );
	}
	
	public function update_admin_user( $data, $partnerId )
	{
		if(empty($partnerId) && empty($data)){
			return false;
		}
		$this->db->where_in('FK_PARTNER_ID', $partnerId);
		return $this->db->update( 'admin_user', $data );
	} 

}
?>
