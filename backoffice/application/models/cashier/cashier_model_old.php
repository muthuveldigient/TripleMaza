<?php
/*
  Class Name	: cashier_model
  Package Name  : Agent
  Purpose       : Handle all the database services related to Agent.
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class Cashier_model extends CI_Model
{
	public function get_record_count($data){
		$partnerid="";
		$partnerid=$data['parid'];
		$sql="";
		$partid="";
		$patsearch="";
		$queryArray=$this->build_sql_where($data);
		$sql=$queryArray['sql'];
		$patsearch=$queryArray['patsearch'];
		$partid=$queryArray['partid'];
		$sdate=$queryArray['sdate'];
		$edate=$queryArray['edate'];
		$allpartnedids="";
		$allpartnedids=$this->get_allpartners($data);
		$processed_by=$data['PROCESSED_BY'];
		if($sql){
			if($this->session->userdata['isownpartner']=="1" || $this->session->userdata['isdistributor']=="1"){
				if($data['PROCESSED_BY']){
					if($data['AGENT_LIST']!='all' && $data['AGENT_LIST']!='')
					{
		$querycnt="select * from partners_transaction_details where $sql and PROCESSED_BY='$processed_by' and TRANSACTION_STATUS_ID in(103,107,111)   group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";
					}else{
		$querycnt="select * from partners_transaction_details where $sql and PROCESSED_BY='$processed_by' and TRANSACTION_STATUS_ID in(103,107,111)  AND partners_transaction_details.PARTNER_ID in(".$allpartnedids.") group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                
					}
				}else{
					if($partid){
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                        
					}else{
						if($data['AGENT_LIST']!='all' && $data['AGENT_LIST']!='')
						{
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                                        
						}else{
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  AND PARTNER_ID in(".$allpartnedids.")  group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                                                            
						}
					}
				}
			}else{
				if($data['PROCESSED_BY']){
					if($data['AGENT_LIST']!='all' && $data['AGENT_LIST']!='')
					{
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  and PROCESSED_BY='$processed_by' AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";
					}else{
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  and PROCESSED_BY='$processed_by' AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' AND partners_transaction_details.PARTNER_ID in(".$allpartnedids.") group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                
					}
				}else{
					if($partid){
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                    
					}else{
		$querycnt="select * from partners_transaction_details where $sql and TRANSACTION_STATUS_ID in(103,107,111)  AND PARTNER_ID='".$partnerid."'  group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                                    
					}
				}
			}
		}else{
			if($this->session->userdata['isownpartner']=="1" || $this->session->userdata['isdistributor']=="1"){
				if($data['PROCESSED_BY']){
		$querycnt="select * from partners_transaction_details where  partners_transaction_details.PARTNER_ID in(".$allpartnedids.") and TRANSACTION_STATUS_ID in(103,107,111)  and PROCESSED_BY='$processed_by' AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";
				}else{
				  if($partid){  
		$querycnt="select * from partners_transaction_details where SUB_PARTNER_ID='".$partid."' and TRANSACTION_STATUS_ID in(103,107,111)  AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                
				  }else{
		$querycnt="select * from partners_transaction_details where PARTNER_ID in(".$allpartnedids.") and TRANSACTION_STATUS_ID in(103,107,111)  AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                              
				  }  
				}
			}else{
				if($data['PROCESSED_BY']){
		$querycnt="select * from partners_transaction_details where  partners_transaction_details.PARTNER_ID in(".$allpartnedids.") and TRANSACTION_STATUS_ID in(103,107,111)  and PROCESSED_BY='$processed_by' AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";
				}else{
					if($partid){  
		$querycnt="select * from partners_transaction_details where SUB_PARTNER_ID='".$partid."' and TRANSACTION_STATUS_ID in(103,107,111)  AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                        
					}else{
		$querycnt="select * from partners_transaction_details where PARTNER_ID='".$partnerid."' and TRANSACTION_STATUS_ID in(103,107,111)  AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."' group by PROCESSED_BY,PARTNER_ID,USER_ID,SUB_PARTNER_ID";                                        
					}
				}
			}
		}
		
			
		//echo $querycnt;
		$resultscnt=$this->db->query($querycnt);
		$rowcount=$resultscnt->num_rows();
		if(!empty($rowcount)){
		$rowcount=$rowcount;
		}
		else{
		$rowcount=0;
		}
		return $rowcount;
	}

	public function get_date($data){
		$cmonth=date("m");
		$cyear=date("Y");
		$cday=date("d");
		if($data['START_DATE_TIME']!='' || $data['END_DATE_TIME']!=''){
		 if($data['START_DATE_TIME']!='' && $data['END_DATE_TIME']==''){   
			$sdate=$data['START_DATE_TIME'];
			$edate=$cday."-".$cmonth."-".$cyear." 23:59:59";    
		 }elseif($data['START_DATE_TIME']=='' && $data['edate']!=''){
			$sdate=$cday."-".$cmonth."-".$cyear." 00:00:00";
			$edate=$data['END_DATE_TIME'];
		 }else{
			$sdate=$data['START_DATE_TIME'];
			$edate=$data['END_DATE_TIME'];
		 }
		}else{
		$sdate=$cday."-".$cmonth."-".$cyear." 00:00:00";
		$edate=$cday."-".$cmonth."-".$cyear." 23:59:59";
		}
		$Array['sdate']=$sdate;
		$Array['edate']=$edate;
		return $Array; 
	}
	
	public function build_sql_where($data){
		$partnerid="";
		$partnerid=$data['parid'];
		$sql="";
		$partid="";
		$patsearch="";
		$allpartnedids="";
		$allpartnedids=$this->get_allpartners($data);
		$conQuery = "";
		$processed_by ="";
		
		if($data['PROCESSED_BY']){
			$processed_by=$data['PROCESSED_BY'];
		}
		$alldistpartnedids="";
		$sdatearr=$this->get_date($data);
		@extract($sdatearr);
		if($data['searchbutton']=='Search')
		{
			if($data['AGENT_LIST']!="" && $data['AGENT_LIST']!='all')
			{
				if($this->session->userdata['isownpartner']=='1' || $this->session->userdata['isdistributor']=="1"){
					$sql_agentslist=$this->db->query("select IS_OWN_PARTNER,IS_DISTRIBUTOR from partner where PARTNER_ID='".$data['AGENT_LIST']."'");
					$row_agentslist=$sql_agentslist->row();
					if($row_agentslist->IS_OWN_PARTNER){
					
					}elseif($row_agentslist->IS_DISTRIBUTOR){
						$sql_agentslist1=$this->db->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$data['AGENT_LIST']."'");
						
						foreach($sql_agentslist1->result() as $row_agentslist1){
						 if($alldistpartnedids){   
						$alldistpartnedids=$alldistpartnedids.",".$row_agentslist1->PARTNER_ID;
						 }else{
						$alldistpartnedids=$row_agentslist1->PARTNER_ID;     
						 }
						}
						if($alldistpartnedids){
							$alldistpartnedids=$alldistpartnedids;
						}
					  if($alldistpartnedids){  
					$conQuery=$conQuery." partners_transaction_details.PARTNER_ID in(".$alldistpartnedids.")";    
					  }else{
						$conQuery=$conQuery." partners_transaction_details.PARTNER_ID in(-1)";              }  
					
					}else{
					$conQuery=$conQuery." partners_transaction_details.PARTNER_ID='".$data['AGENT_LIST']."'";        
					}
				}  
			}
			
			if($data['START_DATE_TIME']!=''  || $data['END_DATE_TIME']!=''){
						if($sdate){
						$sdate=date("Y-m-d H:i:s",strtotime($sdate));
						}
						if($edate){
						$edate=date("Y-m-d H:i:s",strtotime($edate));
						}
				
						if($sdate!=$edate){
							if($data['AGENT_LIST']!='all' && $data['AGENT_LIST']!=''){
							if($conQuery){
							$conQuery=$conQuery." AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";
							}
							else{
							$conQuery=" partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";
							}
							}else{
							$conQuery=$conQuery."  partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";
							}
						}else{
						  if($data['AGENT_LIST']!='all' && $data['AGENT_LIST']!=''){ 
						$conQuery=$conQuery." AND partners_transaction_details.CREATED_TIMESTAMP='".$sdate."'";    
						  }else{
						$conQuery=$conQuery."  partners_transaction_details.CREATED_TIMESTAMP='".$sdate."'";      
						  }
						}
			}
			
			
			if($data['USERNAME']){
				  #Check username
				  $sql_users=$this->db->query("select USER_ID from user where USERNAME='".$data['USERNAME']."'");
				  $row_users=$sql_users->row();
				  if(!empty($row_users)){
				  $userid=$row_users->USER_ID;  #USER ID
				  }
				  else{
				  $userid="";
				  }
				  
				  $sql_partid=$this->db->query("select PARTNER_ID from partner where PARTNER_USERNAME='".$data['USERNAME']."'");
				  $row_partid=$sql_partid->row();
				  if(!empty($row_partid)){
				  $partid=$row_partid->PARTNER_ID; # PARTNER ID
				  }
				  else{
				  $partid="";
				  }
				  
				  if(($data['AGENT_LIST']!='all' && $data['AGENT_LIST']!='')  || $data['START_DATE_TIME']!=''  || $data['END_DATE_TIME']!=''){
					  if($userid!=''){
				  $conQuery=$conQuery." AND (partners_transaction_details.USER_ID='".$userid."')";
					  }
					  
					  if($partid!=''){
						if($data['PROCESSED_BY']){  
						  $conQuery=$conQuery." AND partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$data['PROCESSED_BY']."'";
						}else{
							if($this->session->userdata['partnerid']!=$partid){
				  $conQuery=$conQuery." AND (partners_transaction_details.PARTNER_ID='".$partid."')";                    
							}else{
				  $conQuery=$conQuery." AND (partners_transaction_details.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                  
							}
						}
					  }
				  }else{
					  if($userid!=''){
				  $conQuery=$conQuery." (partners_transaction_details.USER_ID='".$userid."')";    
					  }
					  if($partid!=''){
						  if($data['PROCESSED_BY']){  
				   $conQuery=$conQuery."  (partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$data['PROCESSED_BY']."')";                             
						  }else{
				  $conQuery=$conQuery." (partners_transaction_details.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                
						  }  
					  }
				  }
				  
				  if($userid=="" && $partid==""){
					  $partid="-1";
				  }
			}
		}else{
			$sdate=date("Y-m-d H:i:s",strtotime($sdate));
			$edate=date("Y-m-d 23:59:59",strtotime($sdate));  
		}  
		
		   $sql=$conQuery;
		   $patsearch="";
			if($data['PROCESSED_BY']){
				$sql_partusername=$this->db->query("select PARTNER_ID,IS_OWN_PARTNER,IS_DISTRIBUTOR from partner where PARTNER_USERNAME='".$data['PROCESSED_BY']."'");
				$row_partusername=$sql_partusername->row();
				if(!empty($row_partusername)){
				$rowpartname=$row_partusername->IS_OWN_PARTNER;
				$rowdispartname=$row_partusername->IS_DISTRIBUTOR;
				}
				else{
				$rowpartname="";
				$rowdispartname="";
				}
				if($rowpartname){
					$patsearch="partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$data['PROCESSED_BY']."'";
				}elseif($rowdispartname){
					$patsearch="partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$data['PROCESSED_BY']."'";
				}elseif(strtolower($data['PROCESSED_BY'])=='admin'){
					$patsearch="partner_adjustment_transaction.ADJUSTMENT_PARTNER='0'";
				}else{
					$patsearch="partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$data['PROCESSED_BY']."'";
				}
			}
		$queryArray=array();
		$queryArray['sql']=$sql;
		$queryArray['patsearch']=$patsearch;
		$queryArray['partid']=$partid;
		$queryArray['sdate']=$sdate;
		$queryArray['edate']=$edate;
		return $queryArray;
	}
	
	public function get_allpartners($data){
	
	}
	 
	 public function fetchrecord($limit,$page,$data){
	 
	        if($_REQUEST['START_DATE_TIME']!=''  || $_REQUEST['END_DATE_TIME']!='')
				{
							if($_REQUEST['START_DATE_TIME']){
							$sdate=date("Y-m-d H:i:s",strtotime($_REQUEST['START_DATE_TIME']));
							}
							if($_REQUEST['END_DATE_TIME']){
							$edate=date("Y-m-d H:i:s",strtotime($_REQUEST['END_DATE_TIME']));
							}
					
							if($_REQUEST['START_DATE_TIME']!=$_REQUEST['END_DATE_TIME']){
								
								if($_REQUEST['AGENT_LIST']!='all' && $_REQUEST['AGENT_LIST']!=''){
								$conQuery=$conQuery." AND partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";
								}else{
								$conQuery=$conQuery."  partners_transaction_details.CREATED_TIMESTAMP  BETWEEN  '".$sdate."' AND '".$edate."'";    
								}    
							}else{
							  if($_REQUEST['AGENT_LIST']!='all' && $_REQUEST['AGENT_LIST']!=''){ 
							$conQuery=$conQuery." AND partners_transaction_details.CREATED_TIMESTAMP='".$sdate."'";    
							  }else{
							$conQuery=$conQuery."  partners_transaction_details.CREATED_TIMESTAMP='".$sdate."'";      
							  }
							}
				}
				
				if($_REQUEST['USERNAME']){
          
					  #Check username
					  $sql_users=mysql_query("select USER_ID from user where USERNAME='".$_REQUEST['USERNAME']."'");
					  $row_users=mysql_fetch_array($sql_users);
					  $userid=$row_users['USER_ID'];
					  
					  $sql_partid=mysql_query("select PARTNER_ID from partner where PARTNER_USERNAME='".$_REQUEST['USERNAME']."'");
					  $row_partid=mysql_fetch_array($sql_partid);
					  $partid=$row_partid['PARTNER_ID'];
					  
					  //echo $_REQUEST['AGENT_LIST'];
					  
					  if(($_REQUEST['AGENT_LIST']!='all' && $_REQUEST['AGENT_LIST']!='')  || $_REQUEST['START_DATE_TIME']!=''  || $_REQUEST['END_DATE_TIME']!=''){
						  if($userid!=''){
					  $conQuery=$conQuery." AND (partners_transaction_details.USER_ID='".$userid."')";
						  }
						  if($partid!=''){
							if($_REQUEST['PROCESSED_BY']){  
				   //   $conQuery=$conQuery." AND (partners_transaction_details.PARTNER_ID='".$partid."')";          
						$conQuery=$conQuery." AND (partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$_REQUEST['PROCESSED_BY']."')";                  
							}else{
								if($_SESSION['partnerid']!=$partid){
					  $conQuery=$conQuery." AND (partners_transaction_details.PARTNER_ID='".$partid."')";                    
								}else{
					  $conQuery=$conQuery." AND (partners_transaction_details.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                  
								}
							}
						  }
					  }else{
						  if($userid!=''){
					  $conQuery=$conQuery." (partners_transaction_details.USER_ID='".$userid."')";    
						  }
						  if($partid!=''){
							  if($_REQUEST['PROCESSED_BY']){  
					  //$conQuery=$conQuery." (partners_transaction_details.PARTNER_ID='".$partid."')";    
					   $conQuery=$conQuery."  (partner_adjustment_transaction.ADJUSTMENT_CREATED_BY='".$_REQUEST['PROCESSED_BY']."')";                             
							  }else{
								  /*if($_SESSION['partnerid']!=$partid){
					  $conQuery=$conQuery." (partners_transaction_details.SUB_PARTNER_ID='".$partid."')";                
								  }else{ */
					  $conQuery=$conQuery." (partners_transaction_details.PARTNER_ID='".$partid."' AND SUB_PARTNER_ID=0)";                                
								 // }
							  }  
						  }
					  }
					  
					  if($userid=="" && $partid==""){
						  $partid="-1";
					  }
    			}
				$sql =$conQuery;
				
				
				
	 }
	 
	 
	 public function getAllLedgerSearchInfo($data){
           	    
			$typeIDs = $this->getPayInOutTypeIds();
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                
                if(!empty($data['USER_ID']) || !empty($data['START_DATE_TIME']) || !empty($data['END_DATE_TIME']) || !empty($data['TRANSID']) )
	      	{
                        //Time Stramp
                        if($data['START_DATE_TIME']){
                        $sdate=date("Y-m-d 00:00:00",strtotime($data['START_DATE_TIME']));
                        }
                        if($data['END_DATE_TIME']){
                        $edate=date("Y-m-d 23:59:59",strtotime($data['END_DATE_TIME']));
                        }
                        
                        if($data['USER_ID']!="")
						{
                          $conQuery .= " USER_ID = ".$data['USER_ID']." AND PARTNER_ID IN ($parid) ";
                        }
                        
                        if($data['TRANSID']!="")
                        {
                            if($data['USER_ID'] == ""){
                                $conQuery .= " INTERNAL_REFERENCE_NO = '".$data['TRANSID']."'";
                            }else{
                                $conQuery .= " AND INTERNAL_REFERENCE_NO = '".$data['TRANSID']."'";
                            }
                           
                        }
                        
			if($data['START_DATE_TIME']!="" and $data['END_DATE_TIME'] =="")
			{
						
                            if($data['USER_ID'] == '' && $data['TRANSID'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."'";
			    }else{			
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."'";
                            }
			}else if($data['START_DATE_TIME'] =="" and $data['END_DATE_TIME'] !=""){
                            if($data['USER_ID'] == '' && $data['TRANSID'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  < '".$edate."' ";
			    }else{			
                                   $conQuery .= " AND TRANSACTION_DATE  < '".$edate."'";
                            }
			}else if($data['START_DATE_TIME'] !="" and $data['END_DATE_TIME'] !=""){
                            if($data['USER_ID'] == '' && $data['TRANSID'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
                            }else{		
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
                            }
			}
                         
                        $sql =	$conQuery; 
                        $query = $this->db->query("SELECT * from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) ORDER BY TRANSACTION_DATE DESC "); 
                        $fetchResults  = $query->result();
                    
                }else{
		        if($data["USERNAME"] ==""){
                            $query = $this->db->query("SELECT * from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ORDER BY TRANSACTION_DATE DESC");
			    $fetchResults  = $query->result();
			}else{
			    $fetchResults  = "";
			}
					  
                }
			return $fetchResults;                    
                }

	 
}