<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class report_Model extends CI_Model
{
	public function getAllSearchPaymentCount($loggedInUsersPartnersId,$searchdata){
		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}
		if($searchdata["status_id"]==1){
			$trans_status = array('101','102','103','107','108','111','125','201','202','203');
		}elseif($searchdata["status_id"]==2){
			$trans_status = array('104','109','205');
		}elseif($searchdata["status_id"]==3){
			$trans_status = array('105','112','206');
		}elseif($searchdata["status_id"]==4){
			$trans_status = array('106','110','207');
		}else{
			$trans_status = array($searchdata["status_id"]);
		}
		$transIDs="";
		foreach($trans_status as $value){
			if($transIDs){
				$transIDs = $transIDs.','.$value;
			}else{
				$transIDs = $value;
			}
		}
		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['status_id']) || !empty($searchdata['amount']) || !empty($searchdata['ref_no']) || !empty($searchdata['payment_mode']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['status_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_STATUS IN (".$transIDs.") ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_STATUS IN (".$transIDs.") ";
				}
			}

		   if($searchdata['amount']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}
			}

			 if($searchdata['ref_no']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}
			}

                        if($searchdata['payment_mode']!="")
                        {
                            if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['ref_no'] == ''){
                                $conQuery .= " PAYMENT_PROVIDER_ID = '".$searchdata['payment_mode']."' ";
                            }else{
                                $conQuery .= " AND PAYMENT_PROVIDER_ID= '".$searchdata['payment_mode']."' ";
                            }
                        }

			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode']=='' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode']=='' && $searchdata['ref_no'] == '' && $searchdata['END_DATE_TIME'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] !="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode']=='' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }

	  if($conQuery != ""){
		$querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where $conQuery and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }else{
			  $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }
		}else{
		   $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		}
		$rowcnt=$querycnt->result();
		$account_property = $rowcnt[0]->cnt;
		return $account_property;
	}


	public function getCountSuccessPayments($loggedInUsersPartnersId,$searchdata){

	 $partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}

			if(!empty($searchdata['user_id']) || !empty($searchdata['staus_id']) || !empty($searchdata['amount']) || !empty($searchdata['ref_no']) || !empty($searchdata['payment_mode']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['staus_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_STATUS ='".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_STATUS = '".$searchdata['status']."' ";
				}
			}

		   if($searchdata['amount']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}
			}

			if($searchdata['ref_no']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}
			}

            if($searchdata['payment_mode']!="")
            {
            	if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['ref_no'] == ''){
	            	$conQuery .= " PAYMENT_PROVIDER_ID = '".$searchdata['payment_mode']."' ";
            	}else{
        	        $conQuery .= " AND PAYMENT_PROVIDER_ID= '".$searchdata['payment_mode']."' ";
    	        }
            }
			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));

			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == '' && $searchdata['END_DATE_TIME'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] !="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }

		  if($conQuery != ""){
			$querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where $conQuery and USER_ID IN ($userids) and PAYMENT_TRANSACTION_STATUS IN (101,102,103,107,108,111,125,201,202,203) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }else{
			  $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where PAYMENT_TRANSACTION_STATUS IN (101,102,103,107,108,111,125,201,202,203) and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }
		}else{
		   $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where PAYMENT_TRANSACTION_STATUS IN (101,102,103,107,108,111,125,201,202,203) and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		}
		$rowcnt=$querycnt->result();
		$account_property = $rowcnt[0]->cnt;

		return $account_property;
	}


		public function getCountFailedPayments($loggedInUsersPartnersId,$searchdata){

		$partnerids  = $this->Agent_model->getAllChildIds();
  		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}

			if(!empty($searchdata['user_id']) || !empty($searchdata['staus_id']) || !empty($searchdata['amount']) || !empty($searchdata['ref_no']) || !empty($searchdata['payment_mode']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['staus_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_STATUS ='".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_STATUS = '".$searchdata['status']."' ";
				}
			}

		   if($searchdata['amount']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}
			}

			 if($searchdata['ref_no']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}
			}

                        if($searchdata['payment_mode']!="")
                        {
                            if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['ref_no'] == ''){
                                $conQuery .= " PAYMENT_PROVIDER_ID = '".$searchdata['payment_mode']."' ";
                            }else{
                                $conQuery .= " AND PAYMENT_PROVIDER_ID= '".$searchdata['payment_mode']."' ";
                            }
                        }

			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == '' && $searchdata['END_DATE_TIME'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] !="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }

		  if($conQuery != ""){
	$querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where $conQuery and PAYMENT_TRANSACTION_STATUS = 204 and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }else{
			  $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where PAYMENT_TRANSACTION_STATUS = 204 and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }
		}else{
		   $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where PAYMENT_TRANSACTION_STATUS = 204 and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		}
		$rowcnt=$querycnt->result();
		$account_property = $rowcnt[0]->cnt;

		return $account_property;
	}


	public function getPendingPayments($loggedInUsersPartnersId,$searchdata){

		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}

			if(!empty($searchdata['user_id']) || !empty($searchdata['staus_id']) || !empty($searchdata['amount']) || !empty($searchdata['ref_no']) || !empty($searchdata['payment_mode']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['staus_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_STATUS ='".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_STATUS = '".$searchdata['status']."' ";
				}
			}

		   if($searchdata['amount']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}
			}

			 if($searchdata['ref_no']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}
			}

            if($searchdata['payment_mode']!="")
            {
	            if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['ref_no'] == ''){
    	            $conQuery .= " PAYMENT_PROVIDER_ID = '".$searchdata['payment_mode']."' ";
                }else{
                    $conQuery .= " AND PAYMENT_PROVIDER_ID= '".$searchdata['payment_mode']."' ";
                }
             }


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == '' && $searchdata['END_DATE_TIME'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] !="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['staus_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }

		  if($conQuery != ""){
			$querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where $conQuery and PAYMENT_TRANSACTION_STATUS IN (104,109,205) and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }else{
			  $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where PAYMENT_TRANSACTION_STATUS IN (104,109,205) and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }

		}else{

		   $querycnt=$this->db2->query("select count(*) as cnt from payment_transaction where PAYMENT_TRANSACTION_STATUS IN (104,109,205) and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		}
		$rowcnt=$querycnt->result();
		$account_property = $rowcnt[0]->cnt;

		return $account_property;
	}


 public function getAllSearchPaymentInfo($loggedInUsersPartnersId,$searchdata,$limit,$start){
		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}
		if($searchdata["status_id"]==1){
			$trans_status = array('101','102','103','107','108','111','125','201','202','203');
		}elseif($searchdata["status_id"]==2){
			$trans_status = array('104','109','205');
		}elseif($searchdata["status_id"]==3){
			$trans_status = array('105','112','206');
		}elseif($searchdata["status_id"]==4){
			$trans_status = array('106','110','207');
		}else{
			$trans_status = array($searchdata["status_id"]);
		}
		$transIDs="";
		foreach($trans_status as $value){
			if($transIDs){
				$transIDs = $transIDs.','.$value;
			}else{
				$transIDs = $value;
			}
		}
		if(!empty($searchdata['user_id']) || !empty($searchdata['status_id']) || !empty($searchdata['amount']) || !empty($searchdata['ref_no']) || !empty($searchdata['payment_mode']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['status_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_STATUS IN (".$transIDs.") ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_STATUS IN (".$transIDs.") ";
				}
			}

		   if($searchdata['amount']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}
			}

			 if($searchdata['ref_no']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}
			}

                        if($searchdata['payment_mode']!="")
                        {
                            if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['ref_no'] == ''){
                                $conQuery .= " PAYMENT_PROVIDER_ID = '".$searchdata['payment_mode']."' ";
                            }else{
                                $conQuery .= " AND PAYMENT_PROVIDER_ID= '".$searchdata['payment_mode']."' ";
                            }
                        }


		$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == '' && $searchdata['END_DATE_TIME'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] !="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode'] == '' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }


		$sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db2->query("SELECT * from payment_transaction where $sql AND USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62) ORDER BY PAYMENT_TRANSACTION_CREATED_ON DESC LIMIT $start,$limit");
	      }else{
		    $query = $this->db2->query("SELECT * from payment_transaction where USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62) ORDER BY PAYMENT_TRANSACTION_CREATED_ON DESC LIMIT $start,$limit");
		  }
		}else{
		  $query = $this->db2->query("SELECT * from payment_transaction where USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62) ORDER BY PAYMENT_TRANSACTION_CREATED_ON DESC LIMIT $start,$limit");

		}
		$fetchResults  = $query->result();
		return $fetchResults;
	}

	public function getAllSearchGameCount($loggedInUsersPartnersId,$searchdata){
		//get userid based on username

		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}


		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}
		   if($searchdata['partner']!="select")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }


		  if($conQuery != ""){
			$querycnt=$this->db3->query("select * from view_transaction_history where $conQuery AND USER_ID IN ($userids) group by USER_ID");
		  }else{
			  $querycnt=$this->db3->query("select * from view_transaction_history where USER_ID IN ($userids) group by USER_ID");
		  }

		}else{

		   $querycnt=$this->db3->query("select * from view_transaction_history where USER_ID IN ($userids) group by USER_ID");
		}
		$rowcnt=$querycnt->result();
		return count($rowcnt);
	}

		public function getAllSearchPaymentAmount($loggedInUsersPartnersId,$searchdata){
		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}
		if($searchdata["status_id"]==1){
			$trans_status = array('101','102','103','107','108','111','125','201','202','203');
		}elseif($searchdata["status_id"]==2){
			$trans_status = array('104','109','205');
		}elseif($searchdata["status_id"]==3){
			$trans_status = array('105','112','206');
		}elseif($searchdata["status_id"]==4){
			$trans_status = array('106','110','207');
		}else{
			$trans_status = array($searchdata["status_id"]);
		}
		$transIDs="";
		foreach($trans_status as $value){
			if($transIDs){
				$transIDs = $transIDs.','.$value;
			}else{
				$transIDs = $value;
			}
		}
		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['status_id']) || !empty($searchdata['amount']) || !empty($searchdata['ref_no']) || !empty($searchdata['payment_mode']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['status_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_STATUS IN (".$transIDs.") ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_STATUS IN (".$transIDs.") ";
				}
			}

		   if($searchdata['amount']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == ''){
					$conQuery .= " PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_AMOUNT = '".$searchdata['amount']."' ";
				}
			}

			 if($searchdata['ref_no']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO = '".$searchdata['ref_no']."' ";
				}
			}

                        if($searchdata['payment_mode']!="")
                        {
                            if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['ref_no'] == ''){
                                $conQuery .= " PAYMENT_PROVIDER_ID = '".$searchdata['payment_mode']."' ";
                            }else{
                                $conQuery .= " AND PAYMENT_PROVIDER_ID= '".$searchdata['payment_mode']."' ";
                            }
                        }

			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode']=='' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode']=='' && $searchdata['ref_no'] == '' && $searchdata['END_DATE_TIME'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] !="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['status_id'] == '' && $searchdata['amount'] == '' && $searchdata['payment_mode']=='' && $searchdata['ref_no'] == ''){
				   $conQuery .= " PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND PAYMENT_TRANSACTION_CREATED_ON  > '".$startdateformate."' AND PAYMENT_TRANSACTION_CREATED_ON  < '".$enddateformate."'";
				}
			 }

	  if($conQuery != ""){
		$querycnt=$this->db2->query("select sum(PAYMENT_TRANSACTION_AMOUNT) as amt from payment_transaction where $conQuery and USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }else{
			  $querycnt=$this->db2->query("select sum(PAYMENT_TRANSACTION_AMOUNT) as amt from payment_transaction where USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		  }
		}else{
		   $querycnt=$this->db2->query("select sum(PAYMENT_TRANSACTION_AMOUNT) as amt from payment_transaction where USER_ID IN ($userids) AND TRANSACTION_TYPE_ID IN (8,61,62)");
		}
		$rowcnt=$querycnt->result();
		$account_property = $rowcnt[0]->amt;
		return $account_property;

		}


	public function getAllSearchGameInfo($loggedInUsersPartnersId,$searchdata,$limit,$start){
		//get userid based on username
		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}


		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}
		   if($searchdata['partner']!="select")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT GAME_TRANSACTION_ID,MASTER_TRANSACTTION_ID,USER_ID,INTERNAL_REFERENCE_NO,TRANSACTION_DATE, sum(BET_POINTS) as totalbets,sum(WIN_POINTS) as totalwins,sum(REFUND_POINTS) as totalrefunds from view_transaction_history where $sql and USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC LIMIT $start,$limit");
	      }else{
		    $query = $this->db3->query("SELECT GAME_TRANSACTION_ID,MASTER_TRANSACTTION_ID,USER_ID,INTERNAL_REFERENCE_NO,TRANSACTION_DATE, sum(BET_POINTS) as totalbets,sum(WIN_POINTS) as totalwins,sum(REFUND_POINTS) as totalrefunds from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC LIMIT $start,$limit");
		  }
		}else{
		  $query = $this->db3->query("SELECT GAME_TRANSACTION_ID,MASTER_TRANSACTTION_ID,USER_ID,INTERNAL_REFERENCE_NO,TRANSACTION_DATE, sum(BET_POINTS) as totalbets,sum(WIN_POINTS) as totalwins,sum(REFUND_POINTS) as totalrefunds from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC LIMIT $start,$limit");

		}
		$fetchResults  = $query->result();
		return $fetchResults;
	}

	public function getAllSearchGamePointsCount($loggedInUsersPartnersId,$searchdata,$point_field){
		//get userid based on username
			 $partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}


		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}

		   if($searchdata['partner']!="select")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}

			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;



		if($sql != ''){
			$query = $this->db3->query("SELECT sum(".$point_field.") as totalbets from view_transaction_history where $sql and USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC ");

		}


		$fetchResults  = $query->result();
		foreach($fetchResults as $points){
			$sum_amount += $points->totalbets;
		}
		return $sum_amount;



	}

	public function getAllUserGameCount($user_id,$sdate,$edate){
         if($sdate != "" || $edate != ""){
             $sdate1 = date("Y-m-d H:i:s",strtotime($sdate));
             $edate1 = date("Y-m-d H:i:s",strtotime($edate));
             	$querycnt=$this->db3->query("select count(*) as cnt from view_transaction_history where USER_ID = $user_id  AND TRANSACTION_DATE >= '$sdate1' AND TRANSACTION_DATE <= '$edate1' ");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
        }else{
		$querycnt=$this->db3->query("select count(*) as cnt from view_transaction_history where USER_ID = $user_id ");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
	}
        }

	public function getAllUserGamePlaySum($user_id,$sdate,$edate,$field_id){
            if($sdate != "" || $edate !=""){
               $sdate1 = date("Y-m-d H:i:s",strtotime($sdate));
               $edate1 = date("Y-m-d H:i:s",strtotime($edate));
                $querycnt=$this->db3->query("select sum($field_id) as tot_play from view_transaction_history where USER_ID = $user_id AND TRANSACTION_DATE >= '$sdate1' AND TRANSACTION_DATE <= '$edate1'");
		$rowcnt=$querycnt->row();
		return $rowcnt->tot_play;
            }else{
		$querycnt=$this->db3->query("select sum($field_id) as tot_play from view_transaction_history where USER_ID = $user_id ");
		$rowcnt=$querycnt->row();
		return $rowcnt->tot_play;
	}
        }


	public function getAllUserGameInfo($user_id,$sdate,$edate){
            if($sdate != "" || $edate !=""){
               $sdate1 = date("Y-m-d H:i:s",strtotime($sdate));
               $edate1 = date("Y-m-d H:i:s",strtotime($edate));
	   	$query  = $this->db3->query("select * from view_transaction_history where USER_ID = $user_id AND TRANSACTION_DATE >= '$sdate1' AND TRANSACTION_DATE <= '$edate1' order by TRANSACTION_DATE DESC");
		$result = $query->result();
		return $result;
            }else{
	   	$query  = $this->db3->query("select * from view_transaction_history where USER_ID = $user_id order by TRANSACTION_DATE DESC");
		$result = $query->result();
		return $result;
	}
        }

	public function getAllSearchUserGameCount($loggedInUsersPartnersId,$searchdata){

		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT count(*) as cnt from view_transaction_history where $sql ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT count(*) as cnt from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT count(*) as cnt from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");

		}
		$rowcnt=$query->row();
		return $rowcnt->cnt;

	}

	public function getAllSearchUserGameInfo($loggedInUsersPartnersId,$searchdata){

		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT * from view_transaction_history where $sql ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT * from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{


		  $query = $this->db3->query("SELECT * from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");

		}

		$fetchResults  = $query->result();
		return $fetchResults;
	}

	public function getAllSearchUserGamePointsCount($loggedInUsersPartnersId,$searchdata,$point_field){
		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT sum(".$point_field.") as totalbets from view_transaction_history where $sql  ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history  ORDER BY TRANSACTION_DATE DESC ");

		}


		$rowcnt=$query->row();
		return $rowcnt->totalbets;



	}

        public function getParticularHandidGameInfo($hand_id){

            //Get Game Info using Handid
                $rest = substr("$hand_id",0,3);

                if($rest == AAA){
                    $query = $this->db2->query("select * from oddneven_play where INTERNAL_REFERENCE_NO = '$hand_id' ");
                    $gameInfo  =  $query->result();
                    return $gameInfo;

                    }elseif($rest == AAB){
                    $query = $this->db2->query("select * from luckynumber_play where INTERNAL_REFERENCE_NO = '$hand_id' ");
                    $gameInfo  =  $query->result();
                    return $gameInfo;

                }elseif($rest == AAC){
                    $query = $this->db2->query("select * from luck_play where INTERNAL_REFERENCE_NO = '$hand_id' ");
                    $gameInfo  =  $query->result();
                    return $gameInfo;

                }

        }



	/*public function getSelfTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db->select('*')->from('game_transaction_history');
		$this->db->where("partner_id",$partner_id);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db->get();

		$results  = $browseSQL->result();

		return count($results);
	}

	public function getSelfTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db->select('sum(stake) as tot, sum(win) as totwin,partner_id')->from('game_transaction_history');
		$this->db->where("partner_id",$partner_id);

		//print_r($data);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
                 $this->db->order_by('tot','desc');
        $browseSQL = $this->db->get();


		$results  = $browseSQL->result();
		return $results;
	} */

	public function getSelfTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db3->select('*')->from('partner_turnover_report_daily');
		$this->db3->where("PARTNER_ID",$partner_id);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db3->get();

		$results  = $browseSQL->result();
               // echo $this->db->last_query();
		return count($results);
	}

	public function getSelfTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db3->select('sum(TOTAL_BETS) as tot, sum(TOTAL_WINS) as totwin,PARTNER_ID,MARGIN,NET')->from('partner_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);

		//print_r($data);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
                 $this->db3->order_by('tot','desc');
        $browseSQL = $this->db3->get();


		$results  = $browseSQL->result();
		//echo $this->db->last_query();

		return $results;
	}


	public function getPartnersTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllPartnerIds($partner_id);

		if(count(explode(",",$partner_ids))>0){
        	$this->db3->select('*')->from('partner_turnover_report_daily');
			if($partner_ids)
			$this->db3->where_in("partner_id",explode(",",$partner_ids));

				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("partner_id");
        	$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
			//echo $this->db->last_query();
			$countval = count($results);
		}else{
		    $countval = 0;
		}

		return $countval;
	}

	public function getPartnersTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllPartnerIds($partner_id);

		if(count(explode(",",$partner_ids))>0){
        	$this->db3->select('sum(TOTAL_BETS) as tot, sum(TOTAL_WINS) as totwin,PARTNER_ID,MARGIN,NET')->from('partner_turnover_report_daily');


			$this->db3->where_in("partner_id",explode(",",$partner_ids));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}

			$this->db3->group_by("partner_id");
                         $this->db3->order_by('tot','desc');
        	$browseSQL = $this->db3->get();


			$results  = $browseSQL->result();


			$countval = $results;
		}else{
		    $countval = "";
		}

		return $countval;
	}

	public function getSelfPartnerTurnover($data){
		$partner_id = $data["partner_id"];
                //echo $partner_id;die;
        $this->db3->select('sum(TOTAL_BETS) as tot, sum(TOTAL_WINS) as totwin,PARTNER_ID,MARGIN,NET')->from('partner_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);

		//print_r($data);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
                 $this->db3->order_by('tot','desc');
        $browseSQL = $this->db3->get();
		//echo $this->db->last_query();

		$results  = $browseSQL->result();
		return $results;
	}

	public function getAllGameTurnoverCount($data){
		//$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllChildIds();

		if(count(explode(",",$partner_ids))>0){
        	$this->db3->select('game_id,sum(stake) as tot, sum(win) as totwin,partner_id,count(*) as cnt')->from('game_transaction_history');
			$this->db3->where_in("partner_id",explode(",",$partner_ids));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}

			if(!empty($data["GAME_ID"]))
				$this->db3->where('GAME_ID',$data["GAME_ID"]);

			$this->db3->group_by("GAME_ID");
        	$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
			$countval = count($results);
		}else{
		    $countval = 0;
		}

		return $countval;
	}


	public function getAllGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllChildIds();

		if(count(explode(",",$partner_ids))>0){
        	$this->db3->select('game_id,sum(stake) as tot, sum(win) as totwin,partner_id,count(*) as cnt')->from('game_transaction_history');
			$this->db3->where_in("partner_id",explode(",",$partner_ids));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if(!empty($data["GAME_ID"]))
				$this->db3->where('GAME_ID',$data["GAME_ID"]);

			$this->db3->group_by("GAME_ID");
        	        $browseSQL = $this->db3->get();
			//echo $this->db->last_query();

			$results  = $browseSQL->result();


			$countval = $results;
		}else{
		    $countval = "";
		}

		return $countval;
	}


	public function getAllPartnerIds($partnerid){
	    $this->db2->select('PARTNER_ID')->from('partner');
		$this->db2->where("FK_PARTNER_ID",$partnerid);
        $browseSQL = $this->db2->get();

		$results  = $browseSQL->result();

		foreach($results as $res){
		  $partnerids .= $res->PARTNER_ID.',';
		}


		return trim($partnerids,",");
	}


	public function getAllChildIds(){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type  = $this->session->userdata('partnertypeid');

		switch ($partner_type)
		{
			case 0:
			  //means admin
			  //get all the whitelabels
			  $partners  = $this->Agent_model->getAllPartnerIdByParentId($partner_id);
			  if($partners != ''){ //getall affliates
			    $affiliates  = $this->Agent_model->getAllPartnerIdByParentIds($partners);
			  }
			  if($partners != ''){

			    $partnerids  = $partner_id.','.$partners.','.$affiliates;
			  }else{
			     $partnerids = $partner_id;
			  }
			  break;
			case 1: // means Affiliate partner
			  $partnerids  = $partner_id;
			  break;
			case 2: // means Marketing partner
			  $partnerids  = $partner_id;
			  break;
			case 3: //means Whitelabel partner

			  $partners  = $this->Agent_model->getAllPartnerIdByParentId($partner_id);
			  if($partners != ''){
			  	$partnerids  = $partner_id.','.$partners;
			  }else{
			    $partnerids  = $partner_id;
			  }
			  break;

		}


        return trim($partnerids,",");





	}

	/*public function getAllUserTurnoverCount($partner_id,$data){
        $this->db->select('sum(stake) as tot, sum(win) as totwin,partner_id,user_id,count(*) as cnt')->from('game_transaction_history');
		$this->db->where("partner_id",$partner_id);

		if(!empty($data["user_id"]))
			$this->db->where('USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db->group_by("user_id");
        $browseSQL = $this->db->get();
        //echo $this->db->last_query();
		$results  = $browseSQL->result();

		return count($results);
	}


	public function getAllUserTurnover($partner_id,$data){
            //echo "<pre>";print_r($data);die;
        $this->db->select('sum(stake) as tot, sum(win) as totwin,partner_id,user_id')->from('game_transaction_history');
		$this->db->where("partner_id",$partner_id);

		//print_r($data);
		if(!empty($data["user_id"]))
			$this->db->where('USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db->group_by("user_id");
        $browseSQL = $this->db->get();
		//echo $this->db->last_query();

		$results  = $browseSQL->result();
		return $results;
	}*/

	public function getAllUserTurnoverCount($partner_id,$data){
        $this->db3->select('sum(total_bets) as tot, sum(total_wins) as totwin,partner_id,user_id,count(*) as cnt')->from('user_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);

		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("user_id");
        $browseSQL = $this->db3->get();
     //  echo $this->db->last_query();
		$results  = $browseSQL->result();

		return count($results);
	}


	public function getAllUserTurnover($partner_id,$data){
            //echo "<pre>";print_r($data);die;
        $this->db3->select('sum(total_bets) as tot, sum(total_wins) as totwin,partner_id,user_id,net')->from('user_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);

		//print_r($data);
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("user_id");
        $browseSQL = $this->db3->get();
		//echo $this->db->last_query();

		$results  = $browseSQL->result();
		return $results;
	}


	public function getGamesData() {
		$this->db2->select('MINIGAMES_ID,MINIGAMES_NAME')->from('minigames');
		$this->db2->where('MINIGAMES_ID !=','');
		$this->db2->order_by('MINIGAMES_NAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function getPartnersData($gameID,$sdate,$edate) {

		$this->db3->select('t1.GAME_TRANSACTION_ID,t1.GAME_ID,SUM(t1.STAKE) as totalBets,SUM(t1.WIN) as totalWins,t1.PARTNER_ID,t2.PARTNER_NAME')->from('game_transaction_history t1');
		$this->db3->join('partner t2','t2.PARTNER_ID = t1.PARTNER_ID');
		$this->db3->where('t1.GAME_ID',$gameID);
                $this->db3->where('t1.STARTED >=',date('Y-m-d H:i:s',strtotime($sdate)));
                $this->db3->where('t1.ENDED <=',date('Y-m-d H:i:s',strtotime($edate)));
		$this->db3->group_by('t1.PARTNER_ID');
		$browseSQL = $this->db3->get();
                //echo $this->db->last_query();
		return $browseSQL->result();
	}

        public function getParticularGroupIdGameInfo($group_id){
            $query = $this->db2->query("select * from oddneven_play where PLAY_GROUP_ID = '$group_id' ");
            $groupInfo  =  $query->result();
            return $groupInfo;
        }

        public function getParticularLuckGroupGameInfo($group_id){
            $query = $this->db2->query("select * from luck_play where PLAY_GROUP_ID = '$group_id' ");
            $groupInfo  =  $query->result();
            return $groupInfo;
        }


        public function getParticularluckynumGroupGameInfo($group_id){
            $query = $this->db2->query("select * from luckynumber_play where PLAY_GROUP_ID = '$group_id' ");
            $groupInfo  =  $query->result();
            return $groupInfo;
        }

        public function getCardNumbers($str){

            $splitString = explode("[",$str);
            $splitAgain = explode("_",$splitString[1]);

            $arrayCount =  count($splitAgain);
            $cardVAlues = '';
            for($i=0;$i<$arrayCount;$i++){
                if($splitAgain[$i] != '' && $splitAgain[$i] != "]"){
                $cardVAlues .= $splitAgain[$i].'_';
                }
            }
            return trim($cardVAlues,'_');
         }

         public function getRegPoints($data){
             //echo "<pre>";print_r($data);die;
                $this->db2->select('sum(TRANSACTION_AMOUNT) as tot')->from('points_transaction_history');
		$this->db2->where("TRANSACTION_TYPE_ID",65);
		$this->db2->where_in('PARTNER_ID', $data["id"]);

		//print_r($data);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;

		$results  = $browseSQL->result();
		return $results;

         }

         public function getLoginPoints($data){
            // echo "<pre>";print_r($data);die;
                $this->db2->select('sum(TRANSACTION_AMOUNT) as tot')->from('points_transaction_history');
		$this->db->where("TRANSACTION_TYPE_ID",64);
                $this->db2->where_in('PARTNER_ID', $data["id"]);

		//print_r($data);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;

		$results  = $browseSQL->result();
		return $results;

         }

         public function getVipPoints($data){
            // echo "<pre>";print_r($data);die;
                $this->db2->select('sum(TRANSACTION_AMOUNT) as tot')->from('points_transaction_history');
		$this->db->where("TRANSACTION_TYPE_ID",61);
                $this->db2->where_in('PARTNER_ID', $data["id"]);

		//print_r($data);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;

		$results  = $browseSQL->result();
		return $results;

         }

         public function getRegChips($data){
            // echo "<pre>";print_r($data);die;
                $this->db2->select('sum(TRANSACTION_AMOUNT) as tot')->from('master_transaction_history');
		$this->db2->where("TRANSACTION_TYPE_ID",65);
                $this->db2->where_in('PARTNER_ID', $data["id"]);

		//print_r($data);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;

		$results  = $browseSQL->result();
		return $results;

         }

         public function getLoginChips($data){
            // echo "<pre>";print_r($data);die;
                $this->db2->select('sum(TRANSACTION_AMOUNT) as tot')->from('master_transaction_history');
		$this->db2->where("TRANSACTION_TYPE_ID",64);
                $this->db2->where_in('PARTNER_ID', $data["id"]);

		//print_r($data);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;

		$results  = $browseSQL->result();
		return $results;

         }

         public function getVipChips($data){
            // echo "<pre>";print_r($data);die;
                $this->db2->select('sum(TRANSACTION_AMOUNT) as tot')->from('master_transaction_history');
		$this->db2->where("TRANSACTION_TYPE_ID",61);
                $this->db2->where_in('PARTNER_ID', $data["id"]);

		//print_r($data);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db2->where('TRANSACTION_DATE >=', date('Y-m-d',strtotime($data["START_DATE_TIME"])));
			$this->db2->where('TRANSACTION_DATE <=', date('Y-m-d',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;

		$results  = $browseSQL->result();
		return $results;

         }

         public function getGameCode($gamename){
                $this->db2->select('REF_GAME_CODE')->from('minigames');
		$this->db2->where("MINIGAMES_NAME",$gamename);
      		$browseSQL = $this->db2->get();
		$result = $browseSQL->row();
                return $result->REF_GAME_CODE;
         }


         public function getOddnEvenChips($data){
             $gamename = oddneven;
             $internalnum = $this->getGameCode($gamename);
             $conQuery .= " AND PARTNER_ID = '".$data['id']."' ";
             	if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}
             $query = $this->db2->query("SELECT sum(TRANSACTION_AMOUNT) as tot from master_transaction_history where SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3) LIKE '%$internalnum' $conQuery");
             return $stateInfo = $query->result();

         }

         public function getLuckyNumberChips($data){
             $gamename = 'luckynumber';
             $internalnum = $this->getGameCode($gamename);
             $conQuery .= " AND PARTNER_ID = '".$data['id']."' ";
             	if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}
             $query = $this->db2->query("SELECT sum(TRANSACTION_AMOUNT) as tot from master_transaction_history where SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3) LIKE '%$internalnum' $conQuery");
             return $stateInfo = $query->result();

         }

         public function getLuckChips($data){
             $gamename = 'luck';
             $internalnum = $this->getGameCode($gamename);
             $conQuery .= " AND PARTNER_ID = '".$data['id']."' ";
             	if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}
             $query = $this->db2->query("SELECT sum(TRANSACTION_AMOUNT) as tot from master_transaction_history where SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3) LIKE '%$internalnum' $conQuery");
             return $stateInfo = $query->result();

         }

         public function getOddnEvenPoints($data){
             $gamename = 'oddneven';
             $internalnum = $this->getGameCode($gamename);
             $conQuery .= " AND PARTNER_ID = '".$data['id']."' ";
             	if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}
             $query = $this->db2->query("SELECT sum(TRANSACTION_AMOUNT) as tot from points_transaction_history where SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3) LIKE '%$internalnum' $conQuery");
             //echo $this->db->last_query();die;
             return $stateInfo = $query->result();
         }

         public function getLuckyNumberPoints($data){
             $gamename = 'luckynumber';
             $internalnum = $this->getGameCode($gamename);
             $conQuery .= " AND PARTNER_ID = '".$data['id']."' ";
             	if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}
             $query = $this->db2->query("SELECT sum(TRANSACTION_AMOUNT) as tot from points_transaction_history where SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3) LIKE '%$internalnum' $conQuery");
             return $stateInfo = $query->result();
         }

         public function getLuckPoints($data){
             $gamename = 'luck';
             $internalnum = $this->getGameCode($gamename);
             $conQuery .= " AND PARTNER_ID = '".$data['id']."' ";
             	if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
                    $conQuery .= " AND TRANSACTION_DATE >= '".date('Y-m-d',strtotime($data["START_DATE_TIME"]))."' ";
                    $conQuery .= " AND TRANSACTION_DATE <= '".date('Y-m-d',strtotime($data["END_DATE_TIME"]))."' ";
		}
             $query = $this->db2->query("SELECT sum(TRANSACTION_AMOUNT) as tot from points_transaction_history where SUBSTRING(`INTERNAL_REFERENCE_NO`,1,3) LIKE '%$internalnum' $conQuery");
             return $stateInfo = $query->result();
         }

		 public function getAllGameTypes(){
			$query = $this->db2->query('select MINIGAMES_ID,MINIGAMES_TYPE_ID,GAME_DESCRIPTION,MINIGAMES_TYPE_NAME from minigames_type where STATUS=1');
			$gameTypesInfo  =  $query->result();
			return $gameTypesInfo;
    	}

		public function getAllCurrencyTypes(){
			$query = $this->db2->query('select NAME,COIN_TYPE_ID from coin_type where STATUS=1');
			$gameCurrencyInfo  =  $query->result();
			return $gameCurrencyInfo;
    	}


		public function getGamesTOBySearchCriteria($searchData=array(),$limitend,$limitstart){


	  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					    $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."'";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  if($searchData['STATUS']==2){
					  $conQuery .= " t.IS_ACTIVE = 0";
					  }else{
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
					  }
				}else{
					  if($searchData['STATUS']==2){
					  $conQuery .= " AND t.IS_ACTIVE = 0";
					  }else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
					  }
			    }
			}



			$sql = 	$conQuery;



			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.SMALL_BLIND,t.BIG_BLIND,t.IS_ACTIVE,sum(th.TOTAL_GAME_PLAYS) as totalgames,sum(th.TOTAL_POT_AMOUNT) as totalpot_amounts,sum(th.TOTAL_REVENUE) as total_revenue,th.DAILY_TOURNAMENT_ID from tournament t left join daily_tournament_table_history th on t.TOURNAMENT_ID=th.TABLE_ID where $sql and t.LOBBY_ID=1 group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}else{

			$sql = 	$conQuery;

			$query = $this->db2->query("select t.TOURNAMENT_ID,t.TOURNAMENT_NAME,t.COIN_TYPE_ID,t.SMALL_BLIND,t.BIG_BLIND,t.IS_ACTIVE,sum(th.TOTAL_GAME_PLAYS) as totalgames,sum(th.TOTAL_POT_AMOUNT) as totalpot_amounts,sum(th.TOTAL_REVENUE) as total_revenue,th.DAILY_TOURNAMENT_ID from tournament t left join daily_tournament_table_history th on t.TOURNAMENT_ID=th.TABLE_ID where t.LOBBY_ID=1 group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}

	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getGamesDailyTOIds($data,$start,$end){

		$query = $this->db2->query("select DAILY_TOURNAMENT_ID from daily_tournament_table_history where TABLE_ID=".$data." and date(CREATED_DATE) between '".date("Y-m-d",strtotime($start))."' and '".date("Y-m-d",strtotime($end))."'");
		$dailytournamentids  =  $query->result();
		return $dailytournamentids;
	}

	public function getGamesTOTotalPlayers($data){

		$query = $this->db2->query("select count(distinct USER_ID) as totalplayers from daily_tournament_table_user_history where DAILY_TOURNAMENT_ID in(".$data.")");
		$totalplayers  =  $query->row();
		return $totalplayers->totalplayers;
	}

	public function getGamesTOCountBySearchCriteria($searchData=array(),$limitend,$limitstart){

		if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) )
		 {
			$conQuery = "";
			if($searchData['TABLE_ID']!="")
			{
				$conQuery .= "t.TOURNAMENT_NAME = '".$searchData['TABLE_ID']."'";
			}

			if($searchData['GAME_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE_ID = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!="")
			{
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					  $conQuery .= " (t.SMALL_BLIND = '".$searchData['STAKE']."' or t.BIG_BLIND = '".$searchData['STAKE']."') ";
				}else{
					  $conQuery .= " AND (t.SMALL_BLIND = '".$searchData['STAKE']."' or t.BIG_BLIND = '".$searchData['STAKE']."')";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
				}else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
			    }
			}

			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from (select t.tournament_id from tournament t left join daily_tournament_table_history th  on t.tournament_id=th.TABLE_ID where $sql and t.LOBBY_ID=1 group by t.TOURNAMENT_ID ) as cnt");

		}else{
			$sql = 	$conQuery;

			$querycnt=$this->db2->query("select count(*) as cnt from (select t.tournament_id from tournament t left join daily_tournament_table_history th  on t.tournament_id=th.TABLE_ID where t.LOBBY_ID=1 group by t.TOURNAMENT_ID) as cnt");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}

	public function getCurrencyNameByID($id){
		$query = $this->db2->query('select NAME from coin_type where COIN_TYPE_ID = '.$id);
		$gameTypesInfo  =  $query->row();
		return $gameTypesInfo->NAME;
	}

	public function getAllPlayers($data){

		if($data['d_tid']){
			$sql=" dth.TABLE_ID='".$data['d_tid']."'";
		}

		if($data['start_date']!='' && $data['end_date']!=''){
			$sql=$sql." AND date_format(dt.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($data['start_date']))."' AND '".date("Y-m-d",strtotime($data['end_date']))."'";
		}

		$query=$this->db2->query("select dt.USER_ID,u.USERNAME,sum(dt.STAKE) as STAKE,sum(dt.WIN) as WIN,sum(dt.RAKE) as RAKE from daily_tournament_table_user_history dt,user u,daily_tournament_table_history dth where $sql and dt.USER_ID=u.USER_ID and dt.DAILY_TOURNAMENT_ID=dth.DAILY_TOURNAMENT_ID group by dt.USER_ID");
		$fetchResults=$query->result();
		return $fetchResults;
	}

        public function PaymentAction($data){
            $userid = $data['userid'];
            $approve = $data['approve'];
			$pay_transid = $data['pay_trans_id'];
            $desc_reason = $data['desc_reason'];
            $data = array(
               'PAYMENT_TRANSACTION_STATUS' => '103'
               //'REASON' => $desc_reason
            );

			$qry = $this->db->query("select PAYMENT_TRANSACTION_AMOUNT from payment_transaction where PAYMENT_TRANSACTION_ID = $pay_transid");
			$row = $qry->result();
			$Amnt = $row[0]->PAYMENT_TRANSACTION_AMOUNT;

			if($approve == '2'){
			$array = array('USER_ID' => $userid, 'PAYMENT_TRANSACTION_ID' => $pay_transid);
			$this->db->where($array);
            $this->db->update('payment_transaction', $data);

			$qryamt = $this->db->query("select USER_DEPOSIT_BALANCE,USER_TOT_BALANCE from user_points where USER_ID = $userid and COIN_TYPE_ID ='1' ");
			$rowamt = $qryamt->result();
			$NewDepositBalance = $rowamt[0]->USER_DEPOSIT_BALANCE + $Amnt;
			$NewTotalBalance = $rowamt[0]->USER_TOT_BALANCE + $Amnt;

			$data1 = array('USER_DEPOSIT_BALANCE' => $NewDepositBalance ,  'USER_TOT_BALANCE' => $NewTotalBalance);
			$array1 = array('USER_ID' => $userid, 'COIN_TYPE_ID' => '1');
			$this->db->where($array1);
			$this->db->update('user_points', $data1);

			$balanceTypeId = '1';
			$utransactionStatusId = '103';
			$utransactionTypeId = '8';
			$internalRefNo = "121".$userid.date('dmyhis');
			$ins_query = $this->db->query("INSERT INTO `master_transaction_history` (`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,".
        			"`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,".
        			"`PARTNER_ID`)VALUES ('$userid', '$balanceTypeId', '$utransactionStatusId', '$utransactionTypeId', ".
        			"'$Amnt', NOW(), '$internalRefNo',"."'".$rowamt[0]->USER_TOT_BALANCE."', '$NewTotalBalance','1');");
			//$this->db->insert($ins_query);

            return 1;
			}elseif($approve == '0'){
            $data2 = array(
               'PAYMENT_TRANSACTION_STATUS' => '105'
               //'REASON' => $desc_reason
            );
				$array2 = array('USER_ID' => $userid, 'PAYMENT_TRANSACTION_ID' => $pay_transid);
				$this->db->where($array2);
           		$this->db->update('payment_transaction', $data2);

				return 3;
			}
        }


}
