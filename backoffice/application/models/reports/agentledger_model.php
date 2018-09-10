<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Sivakumar
*/
class agentledger_Model extends CI_Model
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

	public function getLedgerCount($loggedInPartnersList,$searchdata) {
		$userid="";
		if($searchdata['username']) {
			$sql_users=$this->db2->query("select USER_ID from user where USERNAME='".$searchdata['username']."'");
			$row_users=$sql_users->row();
			if(!empty($row_users)) {
				$userid=$row_users->USER_ID;			
			} else {
				$userid=1;
			}
		}
		$this->db2->where('l.LEDGER_ID !=','');
		if($loggedInPartnersList){
			if(is_array($loggedInPartnersList)){
				$loggedInPartnersList1=implode(",",$loggedInPartnersList);	
				$this->db2->where_in('l.PARTNER_ID',$loggedInPartnersList);	
			}
		}		
		if($searchdata['agent_list']!='all' && $searchdata['agent_list']!='') {
			$this->db2->where('l.PARTNER_ID',$searchdata['agent_list']);
		}		
		if($searchdata['sdate']!=''  && $searchdata['edate']!='') {
			$this->db2->where('l.CREATED_TIMESTAMP >=', date("Y-m-d H:i:s",strtotime($searchdata['sdate'])));
			$this->db2->where('l.CREATED_TIMESTAMP <=', date("Y-m-d H:i:s",strtotime($searchdata['edate'])));		
		}
		if(!empty($userid)) {
			$this->db2->where('l.USER_ID',$userid);
		}
		if($searchdata['processed_by']) {
			$this->db2->where('l.PROCESSED_BY',$searchdata['processed_by']);
		}
        $browseSQL = $this->db2->get('ledger l');
		return $browseSQL->num_rows();
	}  

	public function getLedgerInfo($loggedInPartnersList,$searchdata,$limitend,$limitstart) {
		$userid="";
		if($searchdata['username']) {
			$sql_users=$this->db2->query("select USER_ID from user where USERNAME='".$searchdata['username']."'");
			$row_users=$sql_users->row();
			if(!empty($row_users)) {
				$userid=$row_users->USER_ID;			
			} else {
				$userid=1;
			}
		}
		$this->db2->where('l.LEDGER_ID !=','');
		if($loggedInPartnersList){
			if(is_array($loggedInPartnersList)){
				//$loggedInPartnersList1=implode(",",$loggedInPartnersList);
				//$loggedInPartnersList1=str_replace("'",'',$loggedInPartnersList);
				$this->db2->where_in('l.PARTNER_ID',$loggedInPartnersList);	
			}
		}		
		if($searchdata['agent_list']!='all' && $searchdata['agent_list']!='') {
			$this->db2->where('l.PARTNER_ID',$searchdata['agent_list']);
		}		
		if($searchdata['sdate']!=''  && $searchdata['edate']!='') {
			$this->db2->where('l.CREATED_TIMESTAMP >=', date("Y-m-d H:i:s",strtotime($searchdata['sdate'])));
			$this->db2->where('l.CREATED_TIMESTAMP <=', date("Y-m-d H:i:s",strtotime($searchdata['edate'])));		
		}
		if(!empty($userid)) {
			$this->db2->where('l.USER_ID',$userid);
		}
		if($searchdata['processed_by']) {
			$this->db2->where('l.PROCESSED_BY',$searchdata['processed_by']);
		}
		$this->db2->order_by('l.LEDGER_ID','DESC');
        	$browseSQL = $this->db2->get('ledger l');
			//echo $this->db2->last_query();exit;
		return $browseSQL->result();
	}
	
	public function getAllSearchLedgerCount($loggedInPartnersList,$searchdata) {
		$conQuery="";
		if($searchdata['agent_list']!='all' && $searchdata['agent_list']!=''){
			$partnerids=$this->getAllChildPartner($searchdata['agent_list']);
			if(isset($partnerids)){
				$conQuery=$conQuery." pt.PARTNER_ID in(".$partnerids.")";  
			}else{
				$conQuery=$conQuery." pt.PARTNER_ID='".$partnerids."'";
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
		
		
		if($searchdata['username']){
          
          #Check username
          $sql_users=$this->db2->query("select USER_ID from user where USERNAME='".$searchdata['username']."'");
          $row_users=$sql_users->row();
          $userid=$row_users->USER_ID;
          
          $sql_partid=$this->db2->query("select PARTNER_ID,FK_PARTNER_TYPE_ID from partner where PARTNER_USERNAME='".$searchdata['username']."'");
          $row_partid=$sql_partid->row();
          $partid=$row_partid->PARTNER_ID;
          
          //echo $_REQUEST['AGENT_LIST'];
          
          if(($searchdata['agent_list']!='all' && $searchdata['agent_list']!='')  || $searchdata['sdate']!=''  || $searchdata['edate']!=''){
              if($userid!=''){
          			$conQuery=$conQuery." AND (pt.USER_ID='".$userid."')";
              }
			  
              if($partid!=''){
                    if($this->session->userdata['partnerid']!=$partid){
          				$conQuery=$conQuery." AND (pt.PARTNER_ID='".$partid."') AND USER_ID=0";                    
                    }else{
                      if($row_partid['IS_OWN_PARTNER']!="0"){  
          				$conQuery=$conQuery." AND (pt.PARTNER_ID='".$partid."' )";                                  
                      }else{
          				$conQuery=$conQuery." AND (pt.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                                             
                      } 
                   }
              }
			  
          }else{
              if($userid!=''){
		          $conQuery=$conQuery." (pt.USER_ID='".$userid."')";    
              }
              if($partid!=''){
                  if($searchdata['processed_by']){  
           				$conQuery=$conQuery."  (pa.ADJUSTMENT_CREATED_BY='".$searchdata['processed_by']."')";                             
                  }else{
        			  $conQuery=$conQuery." (pt.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                
                  }  
              }
          }
          
          if($userid=="" && $partid==""){
              $partid="-1";
          }
      }
	  
	    $sql=$conQuery;
		if($sql){
			if($loggedInPartnersList){
				if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);
		$querycnt=$this->db2->query("select count(*) as cnt from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where $sql and pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList1.")");
				}else{
		$querycnt=$this->db2->query("select count(*) as cnt from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where $sql and pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList.")");
				}
			}else{
		$querycnt=$this->db2->query("select count(*) as cnt from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where $sql and pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID");	
			}
		}else{
			if($loggedInPartnersList){
				if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);
		$querycnt=$this->db2->query("select count(*) as cnt from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList1.")");
				}else{
		$querycnt=$this->db2->query("select count(*) as cnt from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList.")");
				}
			}else{
		$querycnt=$this->db2->query("select count(*) as cnt from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID");	
			}
		}
		
		$gameInfo  =  $querycnt->row();
		//echo $this->db->last_query();
	  	return $gameInfo->cnt;
	}    
	
	
	public function getAllUserSearchLedgerCount($loggedInPartnersList,$searchdata) {
		$conQuery="";
		$userid=base64_decode($searchdata['userid']);		
		if($searchdata['sdate']!=''  || $searchdata['edate']!='')
    	{
			if($searchdata['sdate']){
                $sdate=date("Y-m-d H:i:s",strtotime($searchdata['sdate']));
            }
			 
             if($searchdata['edate']){
                $edate=date("Y-m-d H:i:s",strtotime($searchdata['edate']));
             }
			 
			 if($searchdata['sdate']!=$searchdata['edate']){            
                    $conQuery=$conQuery."  master_transaction_history.TRANSACTION_DATE  BETWEEN  '".$sdate."' AND '".$edate."'";                           
			}else{			  
					$conQuery=$conQuery."  master_transaction_history.TRANSACTION_DATE='".$sdate."'";      			  
			}		
		}
	  
	    $sql=$conQuery;
		if($sql){
			if($loggedInPartnersList){
				if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);					
		$querycnt=$this->db2->query("select count(*) as cnt from master_transaction_history where $sql AND USER_ID='".$userid."' AND (TRANSACTION_TYPE_ID=8 OR TRANSACTION_TYPE_ID=9 OR TRANSACTION_TYPE_ID=10 OR TRANSACTION_TYPE_ID=22) AND (TRANSACTION_STATUS_ID='103' OR TRANSACTION_STATUS_ID='107' OR TRANSACTION_STATUS_ID='108' OR TRANSACTION_STATUS_ID='111' OR TRANSACTION_STATUS_ID='130' OR TRANSACTION_STATUS_ID='131') AND PARTNER_ID in (".$loggedInPartnersList1.")");
				}else{
		$querycnt=$this->db2->query("select count(*) as cnt from master_transaction_history where $sql AND USER_ID='".$userid."' AND (TRANSACTION_TYPE_ID=8 OR TRANSACTION_TYPE_ID=9 OR TRANSACTION_TYPE_ID=10 OR TRANSACTION_TYPE_ID=22) AND (TRANSACTION_STATUS_ID='103' OR TRANSACTION_STATUS_ID='107' OR TRANSACTION_STATUS_ID='108' OR TRANSACTION_STATUS_ID='111'  OR TRANSACTION_STATUS_ID='130' OR TRANSACTION_STATUS_ID='131') AND PARTNER_ID in (".$loggedInPartnersList1.")");
				}
			}else{
		$querycnt=$this->db2->query("select count(*) as cnt from master_transaction_history where $sql AND USER_ID='".$userid."' AND (TRANSACTION_TYPE_ID=8 OR TRANSACTION_TYPE_ID=9 OR TRANSACTION_TYPE_ID=10 OR TRANSACTION_TYPE_ID=22) AND (TRANSACTION_STATUS_ID='103' OR TRANSACTION_STATUS_ID='107' OR TRANSACTION_STATUS_ID='108' OR TRANSACTION_STATUS_ID='111'  OR TRANSACTION_STATUS_ID='130' OR TRANSACTION_STATUS_ID='131'))");	
			}
		}
		
		$gameInfo  =  $querycnt->row();
		//echo $this->db->last_query();
	  	return $gameInfo->cnt;
	}	
	
	public function getAllUserSearchLedger($loggedInPartnersList,$searchdata,$limitend,$limitstart) {
		$conQuery="";
		$userid=base64_decode($searchdata['userid']);		
		if($searchdata['sdate']!=''  || $searchdata['edate']!='')
    	{
			if($searchdata['sdate']){
                $sdate=date("Y-m-d H:i:s",strtotime($searchdata['sdate']));
            }
			 
             if($searchdata['edate']){
                $edate=date("Y-m-d H:i:s",strtotime($searchdata['edate']));
             }
			 
			 if($searchdata['sdate']!=$searchdata['edate']){            
                    $conQuery=$conQuery."  master_transaction_history.TRANSACTION_DATE  BETWEEN  '".$sdate."' AND '".$edate."'";                           
			}else{			  
					$conQuery=$conQuery."  master_transaction_history.TRANSACTION_DATE='".$sdate."'";      			  
			}		
		}
	  
	    $sql=$conQuery;
		if($sql){
			if($loggedInPartnersList){
				if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);					
		$query=$this->db2->query("select * from master_transaction_history where $sql AND USER_ID='".$userid."' AND (TRANSACTION_TYPE_ID=8 OR TRANSACTION_TYPE_ID=9 OR TRANSACTION_TYPE_ID=10 OR TRANSACTION_TYPE_ID=22) AND (TRANSACTION_STATUS_ID='103' OR TRANSACTION_STATUS_ID='107' OR TRANSACTION_STATUS_ID='108' OR TRANSACTION_STATUS_ID='111' OR TRANSACTION_STATUS_ID='130' OR TRANSACTION_STATUS_ID='131') AND PARTNER_ID in (".$loggedInPartnersList1.") limit $limitstart,$limitend");
				}else{
		$query=$this->db2->query("select * from master_transaction_history where $sql AND USER_ID='".$userid."' AND (TRANSACTION_TYPE_ID=8 OR TRANSACTION_TYPE_ID=9 OR TRANSACTION_TYPE_ID=10 OR TRANSACTION_TYPE_ID=22) AND (TRANSACTION_STATUS_ID='103' OR TRANSACTION_STATUS_ID='107' OR TRANSACTION_STATUS_ID='108' OR TRANSACTION_STATUS_ID='111'  OR TRANSACTION_STATUS_ID='130' OR TRANSACTION_STATUS_ID='131') AND PARTNER_ID in (".$loggedInPartnersList1.") limit $limitstart,$limitend");
				}
			}else{
		$query=$this->db2->query("select * from master_transaction_history where $sql AND USER_ID='".$userid."' AND (TRANSACTION_TYPE_ID=8 OR TRANSACTION_TYPE_ID=9 OR TRANSACTION_TYPE_ID=10 OR TRANSACTION_TYPE_ID=22) AND (TRANSACTION_STATUS_ID='103' OR TRANSACTION_STATUS_ID='107' OR TRANSACTION_STATUS_ID='108' OR TRANSACTION_STATUS_ID='111'  OR TRANSACTION_STATUS_ID='130' OR TRANSACTION_STATUS_ID='131')) limit $limitstart,$limitend");	
			}
		}
		$fetchResults  = $query->result();			
		//echo $this->db->last_query();
	 	return $fetchResults;  	
	}	
	
	
	public function getAllSearchLedger($loggedInPartnersList,$searchdata,$limitend,$limitstart) {
		$conQuery="";
		if($searchdata['agent_list']!='all' && $searchdata['agent_list']!=''){
			$partnerids=$this->getAllChildPartner($searchdata['agent_list']);
			if(isset($partnerids)){
				$conQuery=$conQuery." pt.PARTNER_ID in(".$partnerids.")";  
			}else{
				$conQuery=$conQuery." pt.PARTNER_ID='".$partnerids."'";
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
		
		
		if($searchdata['username']){
          
          #Check username
          $sql_users=$this->db2->query("select USER_ID from user where USERNAME='".$searchdata['username']."'");
          $row_users=$sql_users->row();
          $userid=$row_users->USER_ID;
          
          $sql_partid=$this->db2->query("select PARTNER_ID,FK_PARTNER_TYPE_ID from partner where PARTNER_USERNAME='".$searchdata['username']."'");
          $row_partid=$sql_partid->row();
          $partid=$row_partid->PARTNER_ID;
          
          //echo $_REQUEST['AGENT_LIST'];
          
          if(($searchdata['agent_list']!='all' && $searchdata['agent_list']!='')  || $searchdata['sdate']!=''  || $searchdata['edate']!=''){
              if($userid!=''){
          			$conQuery=$conQuery." AND (pt.USER_ID='".$userid."')";
              }
			  
              if($partid!=''){
                    if($this->session->userdata['partnerid']!=$partid){
          				$conQuery=$conQuery." AND (pt.PARTNER_ID='".$partid."') AND USER_ID=0";                    
                    }else{
                      if($row_partid['IS_OWN_PARTNER']!="0"){  
          				$conQuery=$conQuery." AND (pt.PARTNER_ID='".$partid."' )";                                  
                      }else{
          				$conQuery=$conQuery." AND (pt.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                                             
                      } 
                   }
              }
			  
          }else{
              if($userid!=''){
		          $conQuery=$conQuery." (pt.USER_ID='".$userid."')";    
              }
              if($partid!=''){
                  if($searchdata['processed_by']){  
           				$conQuery=$conQuery."  (pa.ADJUSTMENT_CREATED_BY='".$searchdata['processed_by']."')";                             
                  }else{
        			  $conQuery=$conQuery." (pt.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                
                  }  
              }
          }
          
          if($userid=="" && $partid==""){
              $partid="-1";
          }
      }
	  
	    $sql=$conQuery;
		if($sql){
			if($loggedInPartnersList){
				if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,p.PARTNER_USERNAME from partners_transaction_details pt,partner p,partner_adjustment_transaction pa   where $sql and pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList1.") order by pt.PARTNER_TRANSACTION_ID desc");
				}else{
$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,p.PARTNER_USERNAME from partners_transaction_details pt,partner p,partner_adjustment_transaction pa   where $sql and pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList.") order by pt.PARTNER_TRANSACTION_ID desc");				
				}
			}else{
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,p.PARTNER_USERNAME from partners_transaction_details pt,partner p,partner_adjustment_transaction pa   where $sql and pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID order by pt.PARTNER_TRANSACTION_ID desc");	
			}
		}else{
			if($loggedInPartnersList){
				if(is_array($loggedInPartnersList)){
					$loggedInPartnersList1=implode(",",$loggedInPartnersList);
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,p.PARTNER_USERNAME from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList1.") order by pt.PARTNER_TRANSACTION_ID desc");
				}else{
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,p.PARTNER_USERNAME from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID and pt.PARTNER_ID in (".$loggedInPartnersList.") order by pt.PARTNER_TRANSACTION_ID desc");
				}
			}else{
		$query=$this->db2->query("select pt.PARTNER_ID,pt.TRANSACTION_TYPE_ID,pt.TRANSACTION_STATUS_ID,pt.USER_ID,pt.AMOUNT,pt.INTERNAL_REFERENCE_NO,pt.CURRENT_TOT_BALANCE,pt.CLOSING_TOT_BALANCE,pt.CREATED_TIMESTAMP,pt.PROCESSED_BY,p.PARTNER_USERNAME from partners_transaction_details pt,partner p,partner_adjustment_transaction pa  where pt.PARTNER_ID=p.PARTNER_ID and pt.INTERNAL_REFERENCE_NO=pa.INTERNAL_REFERENCE_NO and pt.PARTNER_ID=pa.FK_PARTNER_ID order by pt.PARTNER_TRANSACTION_ID desc");	
			}
		}
		//echo $this->db2->last_query();
		$fetchResults  = $query->result();	
		
	 	return $fetchResults;
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
					$distids='';
					$subdistids='';
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
					
					$agentslists=$this->getPartnerList($distids,14);
					
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
			}
			
			
			return $partnerids;
	}
	
	
	public function getPartnerType($partnerid) {
		$this->db2->select("FK_PARTNER_TYPE_ID")->from("partner");
		$this->db2->where("PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		return $result->result();
	}

	public function getPokerPartnersNameList($partnerid) {
		$this->db2->select("PARTNER_ID,PARTNER_USERNAME,PARTNER_NAME")->from("partner");
		$this->db2->where_in("FK_PARTNER_ID",$partnerid);
		$result=$this->db2->get();
		//echo $this->db2->last_query();die;
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
		$this->db2->where("PARTNER_ID !=",1);
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
	
}