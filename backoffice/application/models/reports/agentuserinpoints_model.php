<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Author 	    : Sivakumar
*/
class agentuserinpoints_Model extends CI_Model
{

	public function getAllPaymentStatus(){
		$querycnt=$this->db2->query("select * from transaction_status");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function getAllTransactionTypes(){
		$querycnt=$this->db2->query("select * from transaction_type");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function getAllChildPartner($agentid) {
		    $partner_type=$this->getPartnerType($agentid);
			$partnerids=$agentid;

			if($partner_type[0]->FK_PARTNER_TYPE_ID==11){
				$distributorlists=$this->getPartnerList($agentid,12);
				$distids="";
				if(isset($distributorlists)){
					foreach($distributorlists as $key=>$value){
						if($partnerids){
							$partnerids=$partnerids.",".$distributorlists[$key]->PARTNER_ID;
							$distids=$distids.",".$distributorlists[$key]->PARTNER_ID;
						}else{
							$partnerids=$distributorlists[$key]->PARTNER_ID;
							$distids=$distributorlists[$key]->PARTNER_ID;
						}
					}
				}

				if(isset($distids)){
					$subdistributorlists=$this->getPartnerList($distids,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								$subdistids=$distids.",".$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}
						}
					}

					if(isset($subdistids)){
						$subdistagentlist=$this->getPartnerList($subdistids,14);

						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;
								}
							}
						}
					}

					if(isset($distids)){
					$agentslists=$this->getPartnerList($distids,14);
					}

					if(isset($agentslists)){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
				}
			}elseif($partner_type[0]->FK_PARTNER_TYPE_ID==12){
					$subdistributorlists=$this->getPartnerList($agentid,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								$subdistids=$distids.",".$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}
						}
					}

					if($subdistids){
						$subdistagentlist=$this->getPartnerList($subdistids,14);
						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;
								}
							}
						}
					}

					$agentslists==$this->getPartnerList($distids,14);

					if($agentslists){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
			}elseif($partner_type[0]->FK_PARTNER_TYPE_ID==13){
					$subdistagentlist=$this->getPartnerList($agentid,14);
					if($subdistagentlist){
						foreach($subdistagentlist as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistagentlist[$key]->PARTNER_ID;
							}
						}
					}

					if(isset($distids))
					$agentslists=$this->getPartnerList($distids,14);
					else
					$agentslists='';

					if($agentslists){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
			}


			return $partnerids;
	}


	public function getPartnerType($partnerid) {
		$this->db2->select("FK_PARTNER_TYPE_ID")->from("partner");
		$this->db2->where("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getPartnerList($partnerid,$partner_type) {
		$this->db2->select("PARTNER_ID")->from("partner");
		$this->db2->where("FK_PARTNER_ID",$partnerid);
		$this->db2->where("FK_PARTNER_TYPE_ID",$partner_type);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getPartnersNameList($partnerid) {
		$this->db2->select("PARTNER_ID,PARTNER_USERNAME")->from("partner");
		$this->db2->where_in("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		//echo $this->db->last_query();
		return $result->result();
	}

	public function getUserById($userid) {
		$this->db2->select("USERNAME,PARTNER_ID")->from("user");
		$this->db2->where("USER_ID",$userid);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getUserClosingBal($refno) {
		$this->db2->select("CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE")->from("master_transaction_history");
		$this->db2->where("INTERNAL_REFERENCE_NO",$refno);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getPartnerId($partnerid) {
		$this->db2->select("PARTNER_ID,PARTNER_USERNAME,FK_PARTNER_TYPE_ID")->from("partner");
		$this->db2->where("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getPartnerIdByUsername($partnername) {
		$this->db2->select("PARTNER_ID,PARTNER_USERNAME,FK_PARTNER_TYPE_ID")->from("partner");
		$this->db2->where("PARTNER_USERNAME",$partnername);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getAdjustmentDetById($refno,$partnerid) {
		$this->db2->select("ADJUSTMENT_CREATED_BY,ADJUSTMENT_COMMENT")->from("partner_adjustment_transaction");
		$this->db2->where("INTERNAL_REFERENCE_NO",$refno);
		$this->db2->where("FK_PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getAdjustmentDetByRefId($refno) {
		$this->db2->select("ADJUSTMENT_CREATED_BY,ADJUSTMENT_COMMENT")->from("partner_adjustment_transaction");
		$this->db2->where("INTERNAL_REFERENCE_NO",$refno);
		$this->db2->limit(1,1);
		$result=$this->db2->get();
		return $result->result();
	}


	public function getAdjustmentDetByUserId($refno,$userid) {
		$this->db2->select("ADJUSTMENT_CREATED_BY,ADJUSTMENT_COMMENT")->from("adjustment_transaction");
		$this->db2->where("INTERNAL_REFERENCE_NO",$refno);
		$this->db2->where("USER_ID",$userid);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getUserBalance($sdate,$edate,$userid,$processed_by) {
			if($sdate){
                $sdate=date("Y-m-d H:i:s",strtotime($sdate));
            }

            if($edate){
                $edate=date("Y-m-d H:i:s",strtotime($edate));
            }

		$query=$this->db2->query("select sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE from master_transaction_history m,adjustment_transaction a where m.USER_ID=$userid and m.TRANSACTION_STATUS_ID in(103,107,130) and m.TRANSACTION_DATE between '$sdate' and '$edate' and m.INTERNAL_REFERENCE_NO=a.INTERNAL_REFERENCE_NO and a.ADJUSTMENT_CREATED_BY='".$processed_by."'");
		$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getUserBalanceById($refno){
		$query=$this->db2->query("select CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE from master_transaction_history  where INTERNAL_REFERENCE_NO='".$refno."'");
		$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getInpoints($sdate,$edate,$userid,$partnerid,$processed_by) {
			if($sdate){
                $sdate=date("Y-m-d H:i:s",strtotime($sdate));
        	}

            if($edate){
                $edate=date("Y-m-d H:i:s",strtotime($edate));
            }
		$query=$this->db2->query("select sum(AMOUNT) as AMOUNT,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE from partners_transaction_details where USER_ID=$userid and PROCESSED_BY='".$processed_by."' and PARTNER_ID=$partnerid and CREATED_TIMESTAMP BETWEEN  '".$sdate."' AND '".$edate."' and CURRENT_TOT_BALANCE > CLOSING_TOT_BALANCE group by PROCESSED_BY");
		$fetchResults  = $query->result();

	 	return $fetchResults;
	}

	public function getInpointsLess($sdate,$edate,$partnerid,$processed_by) {
		if($sdate){
                $sdate=date("Y-m-d H:i:s",strtotime($sdate));
        	}

            if($edate){
                $edate=date("Y-m-d H:i:s",strtotime($edate));
            }
		$query=$this->db2->query("select sum(AMOUNT) as AMOUNT,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE from partners_transaction_details where PROCESSED_BY='".$processed_by."' and PARTNER_ID=$partnerid and CREATED_TIMESTAMP BETWEEN  '".$sdate."' AND '".$edate."' and CURRENT_TOT_BALANCE < CLOSING_TOT_BALANCE  group by PROCESSED_BY");
		$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getPartnertransBal($partnerid,$refno) {
		if($partnerid!='' && $refno!=''){
		$query=$this->db2->query("select CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,PROCESSED_BY from  partners_transaction_details where PARTNER_ID=$partnerid and INTERNAL_REFERENCE_NO=$refno");
		$fetchResults  = $query->result();
	 	return $fetchResults;
		}
	}


	public function getCumulativeAmount($sdate,$edate,$partnerid,$processed_by) {
		if($sdate){
                $sdate=date("Y-m-d H:i:s",strtotime($sdate));
        	}

            if($edate){
                $edate=date("Y-m-d H:i:s",strtotime($edate));
            }
		$query=$this->db2->query("SELECT sum(AMOUNT) as AMOUNT1  FROM `partners_transaction_details` WHERE `PARTNER_ID` = ".$partnerid." AND `PROCESSED_BY` = '".$processed_by."'  and `CREATED_TIMESTAMP` between '".$sdate."' and '".$edate."' and USER_ID=0 and CURRENT_TOT_BALANCE < CLOSING_TOT_BALANCE");
		$fetchResults  = $query->result();

	 	return $fetchResults;
	}


	public function getAllAgentUserSearchLedger($loggedInPartnersList,$searchdata,$limitend,$limitstart) {
		$session_data=$this->session->all_userdata();

		$partid=$searchdata['partid'];
		$partnerid=$searchdata['partnerid'];

        $uid=base64_decode($searchdata['uid']);

		$conQuery="";
		if($searchdata['agent_list']!='all' && $searchdata['agent_list']!=''){
			if($session_data['partnertypeid']==1 || $session_data['partnertypeid']==2 || $session_data['partnertypeid']==3){
				$partnerids=$this->getAllChildPartner($searchdata['agent_list']);
				if(isset($partnerids)){
					$conQuery=$conQuery." pt.PARTNER_ID in(".$partnerids.")";
				}
			}else{
				$conQuery=$conQuery." pt.PARTNER_ID='".$searchdata['agent_list']."'";
			}
		}

		if($searchdata['sdate']!=''  || $searchdata['edate']!='')
    	{
			if($searchdata['sdate']){
                $sdate=date("Y-m-d H:i:s",strtotime($searchdata['sdate']));
            }

             if($searchdata['edate']){
                $edate=date("Y-m-d H:i:s",strtotime($searchdata['edate']));
             }

			 if($searchdata['sdate']!=$searchdata['edate']){

                    if($searchdata['agent_list']!='all' && $searchdata['agent_list']!=''){
                    $conQuery=$conQuery." AND pt.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";
                    }else{
                    $conQuery=$conQuery."  pt.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";
                    }
			}else{
			  if($searchdata['agent_list']!='all' && $searchdata['agent_list']!=''){
					$conQuery=$conQuery." AND pt.CREATED_TIMESTAMP='".$sdate."'";
			  }else{
					$conQuery=$conQuery."  pt.CREATED_TIMESTAMP='".$sdate."'";
			  }
			}

		}


	    $sql=$conQuery;
		if($sql){
			if($loggedInPartnersList){
			   if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);
					if($searchdata['processed_by']){
						if($partnerid){
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList1.") and pt.USER_ID=$uid and pt.PARTNER_ID=$partnerid and pt.PROCESSED_BY='$processed_by' and pt.TRANSACTION_STATUS_ID in(103,107,130) ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
						}else{
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList1.") and pt.USER_ID=$uid  and pt.PROCESSED_BY='$processed_by' and pt.TRANSACTION_STATUS_ID in(103,107,130) ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
						}
					}else{
						  if($partnerid){
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList1.") and pt.USER_ID=$uid and pt.PARTNER_ID=$partnerid and pt.TRANSACTION_STATUS_ID in(103,107,130) and pt.PARTNER_ID='".$partnerid."' ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
						  }else{
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList1.") and pt.USER_ID=$uid and pt.TRANSACTION_STATUS_ID in(103,107,130) ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
						  }
					}
			  }else{
			  		if($searchdata['processed_by']){
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList.") and pt.USER_ID=$uid and pt.PARTNER_ID=$partnerid and pt.PROCESSED_BY='$processed_by' and pt.TRANSACTION_STATUS_ID in(103,107,130) ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
					}else{
						  if($partnerid){
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList.") and pt.USER_ID=$uid and pt.PARTNER_ID=$partnerid and pt.TRANSACTION_STATUS_ID in(103,107,130) and pt.PARTNER_ID='".$partnerid."' ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
						  }else{
						$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT ,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and pt.PARTNER_ID in (".$loggedInPartnersList.") and pt.USER_ID=$uid and pt.TRANSACTION_STATUS_ID in(103,107,130) ORDER BY pt.PARTNER_TRANSACTION_ID DESC");						  						 }

					}
			  }

			}else{
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt   where $sql  and TRANSACTION_STATUS_ID in(103,107,130) and pt.USER_ID=$uid and pt.PARTNER_ID=$partnerid ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
			}
		}else{
			if($loggedInPartnersList){
			  if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt  where pt.PARTNER_ID in (".$loggedInPartnersList1.") and pt.USER_ID=$uid and pt.TRANSACTION_STATUS_ID in(103,107,130) and pt.PARTNER_ID='".$partnerid."' ORDER BY pt.PARTNER_TRANSACTION_ID DESC");

			  }else{
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt  where pt.PARTNER_ID in (".$loggedInPartnersList.") and pt.USER_ID=$uid and pt.TRANSACTION_STATUS_ID in(103,107,130) and pt.PARTNER_ID='".$partnerid."' ORDER BY pt.PARTNER_TRANSACTION_ID DESC");

			  }
			}else{

		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,pt.SUB_PARTNER_ID from partners_transaction_details pt and TRANSACTION_STATUS_ID in(103,107,130) and pt.USER_ID=$uid and pt.PARTNER_ID=$partnerid ORDER BY pt.PARTNER_TRANSACTION_ID DESC");
			}
		}

		$fetchResults  = $query->result();
		//echo $this->db->last_query();
	 	return $fetchResults;
	}

}
