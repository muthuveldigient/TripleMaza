<?php
/*
  Class Name	: cashier_model
  Package Name  : Agent
  Purpose       : Handle all the database services related to Agent.
  Auther 	: Azeem
  Date of create: Aug 02 2013
*/
class Cashier_model extends CI_Model{
                public function getAgentNameById($partnerid,$userid){
                    //echo $partnerid;die;
                    $res=$this->db2->query("Select PARTNER_NAME, PARTNER_ID from partner where PARTNER_ID = $partnerid");
                    $partnerInfo  =  $res->row();
                    return $partnerInfo->PARTNER_NAME;
                }
                
                
                public function getAllPayinSearchInfo($data){
                $query = $this->db2->query("Select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Deposit' OR TRANSACTION_TYPE_NAME = 'Promo' ")   ;
                $totalCount = count($query->result())-1;
                
                            foreach ($query->result() as $key => $value) {
                              if($key == $totalCount)
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID;
                              else
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID.","; 
                }
                //echo $typeIDs."Hi";  die;

                        //get parter type based on parter ID
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                
                if(!empty($data['USERNAME']) || !empty($data['START_DATE_TIME']) || !empty($data['END_DATE_TIME'])  )
	        {
                        //Time Stramp
                        if($data['START_DATE_TIME']){
                        $sdate=date("Y-m-d H:i:s",strtotime($data['START_DATE_TIME']));
                        }
                        if($data['END_DATE_TIME']){
                        $edate=date("Y-m-d H:i:s",strtotime($data['END_DATE_TIME']));
                        }
                        
                        if($data['USERNAME']!="")
			{
                           $userIDs = $this->Account_model->getUserIdByNameLike($data['USERNAME']);
                          //echo $userIDs."<br/>";die;
                          $conQuery .= "USER_ID IN ($userIDs) AND PARTNER_ID IN ($parid) ";
                        }
                        
			if($data['START_DATE_TIME']!="" and $data['END_DATE_TIME'] =="")
			 {
				
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."'";
				}else{			
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."'";
				}
			 }else if($data['START_DATE_TIME'] =="" and $data['END_DATE_TIME'] !=""){
			   if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  < '".$edate."' ";
				}else{			
					$conQuery .= " AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }else if($data['START_DATE_TIME'] !="" and $data['END_DATE_TIME'] !=""){
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}else{		
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }
                         
                         $sql =	$conQuery; 
                         //echo ("SELECT USER_ID,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID ");die;
                         $query = $this->db2->query("SELECT USER_ID,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID "); 
                    
                }else{
                         //echo "parid".$parid;
                         $query = $this->db2->query("SELECT USER_ID,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID");
                }
                
                    $fetchResults  = $query->result();
                    return $fetchResults;
                
                }
                
                
                
                public function getInPointsUsersDetails($userid){
                $uid = $userid;
                    //echo $uid;die;
                    
                $query = $this->db2->query("Select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Deposit' OR TRANSACTION_TYPE_NAME = 'Promo' ")   ;
                $totalCount = count($query->result())-1;
                
                foreach ($query->result() as $key => $value) {
                              if($key == $totalCount)
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID;
                              else
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID.","; 
                }
                //echo $typeIDs."Hi";  die;
                
                
                        //get parter type based on parter ID
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                        
                    $query = $this->db2->query("SELECT * from master_transaction_history where USER_ID = $uid AND PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ");
                    $fetchResults  = $query->result();
                    return $fetchResults;
                }
                
                public function getInPointsSearchUsersDetail($data){

                $query = $this->db2->query("Select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Deposit' OR TRANSACTION_TYPE_NAME = 'Promo' ")   ;
                $totalCount = count($query->result())-1;
                
                foreach ($query->result() as $key => $value) {
                              if($key == $totalCount)
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID;
                              else
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID.","; 
                }
                //echo $typeIDs."Hi";  die;
                
                
                        //get parter type based on parter ID
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                
                if(!empty($data['USERNAME']) || !empty($data['START_DATE_TIME']) || !empty($data['END_DATE_TIME'])  )
	        {
                        //Time Stramp
                        if($data['START_DATE_TIME']){
                        $sdate=date("Y-m-d H:i:s",strtotime($data['START_DATE_TIME']));
                        }
                        if($data['END_DATE_TIME']){
                        $edate=date("Y-m-d H:i:s",strtotime($data['END_DATE_TIME']));
                        }
                        
                        if($data['USERNAME']!="")
			{
                        $userIDs = $this->Account_model->getUserIdByNameLike($data['USERNAME']);
                         
                          $conQuery .= "USER_ID IN ($userIDs) AND PARTNER_ID IN ($parid) ";
                        }
                        //echo $userIDs."<br/>".$parid;
			if($data['START_DATE_TIME']!="" and $data['END_DATE_TIME'] =="")
			 {
				
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."'";
				}else{			
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."'";
				}
			 }else if($data['START_DATE_TIME'] =="" and $data['END_DATE_TIME'] !=""){
			   if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  < '".$edate."' ";
				}else{			
					$conQuery .= " AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }else if($data['START_DATE_TIME'] !="" and $data['END_DATE_TIME'] !=""){
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}else{		
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }
                         
                         $sql =	$conQuery; 
                   //echo ("SELECT * from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs)");die;
                         $query = $this->db2->query("SELECT * from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) "); 
                   //echo "hi"; print_r($this->db->last_query());die;
                }else{
                  // echo ("SELECT * from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ");die;
                    $query = $this->db2->query("SELECT * from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ");
                }
                
                $fetchResults  = $query->result();
		return $fetchResults;
                
                }


                public function getAllPayoutSearchInfo($data){
                $query = $this->db2->query("Select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Withdraw' ")   ;
                $totalCount = count($query->result())-1;
                
                foreach ($query->result() as $key => $value) {
                              if($key == $totalCount)
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID;
                              else
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID.","; 
                }
                //echo $typeIDs."Hi";  die;
                
                
                        //get parter type based on parter ID
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                
                if(!empty($data['USERNAME']) || !empty($data['START_DATE_TIME']) || !empty($data['END_DATE_TIME'])  )
	        {
                        //Time Stramp
                        if($data['START_DATE_TIME']){
                        $sdate=date("Y-m-d H:i:s",strtotime($data['START_DATE_TIME']));
                        }
                        if($data['END_DATE_TIME']){
                        $edate=date("Y-m-d H:i:s",strtotime($data['END_DATE_TIME']));
                        }
                        
                        if($data['USERNAME']!="")
			{
                        $userIDs = $this->Account_model->getUserIdByNameLike($data['USERNAME']);
                         // echo $userIDs."<br/>".$parid;
                          $conQuery .= "USER_ID IN ($userIDs) AND PARTNER_ID IN ($parid) ";
                        }
                        
			if($data['START_DATE_TIME']!="" and $data['END_DATE_TIME'] =="")
			 {
				
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."'";
				}else{			
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."'";
				}
			 }else if($data['START_DATE_TIME'] =="" and $data['END_DATE_TIME'] !=""){
			   if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  < '".$edate."' ";
				}else{			
					$conQuery .= " AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }else if($data['START_DATE_TIME'] !="" and $data['END_DATE_TIME'] !=""){
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}else{		
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }
                         
                         $sql =	$conQuery; 
                   //echo ("SELECT USER_ID,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID ");die;
                         $query = $this->db2->query("SELECT USER_ID,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID "); 
                    
                }else{
                   // echo("SELECT USER_ID,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID");
                    $query = $this->db2->query("SELECT USER_ID,sum(CURRENT_TOT_BALANCE) as CURRENT_TOT_BALANCE,sum(CLOSING_TOT_BALANCE) as CLOSING_TOT_BALANCE,sum(TRANSACTION_AMOUNT) as TRANSACTION_AMOUNT from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) group by USER_ID");
                }
                
                $fetchResults  = $query->result();
		return $fetchResults;
                                    
                }
                
                public function getOutPointsUsersDetails($userid){
                $uid = $userid;
                    //echo $uid;die;
                    
                $query = $this->db2->query("Select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Withdraw' ")   ;
                $totalCount = count($query->result())-1;
                
                foreach ($query->result() as $key => $value) {
                              if($key == $totalCount)
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID;
                              else
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID.","; 
                }
                //echo $typeIDs."Hi";  die;
                
                
                        //get parter type based on parter ID
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                        
                    $query = $this->db2->query("SELECT * from master_transaction_history where USER_ID = $uid AND PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ");
                    $fetchResults  = $query->result();
                    return $fetchResults;
                }
                
                public function getOutPointsSearchUsersDetail($data){

                    $query = $this->db2->query("Select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Withdraw' ")   ;
                    $totalCount = count($query->result())-1;
                
                    foreach ($query->result() as $key => $value) {
                              if($key == $totalCount)
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID;
                              else
                                  $typeIDs .= $value->TRANSACTION_TYPE_ID.","; 
                    }
                //echo $typeIDs."Hi";  die;
                //get parter type based on parter ID
			$fk_partner_id = $this->Agent_model->getParentId($this->session->userdata[partnerid]); 
			
			$partner_type_id = $this->Agent_model->getParterFKType($fk_partner_id);  
			
			$dataArray  = array();
			$dataArray['partnertypeid'] =  $partner_type_id;
			$dataArray['partnerid'] = $this->session->userdata[partnerid];
			 
                        //All Childs Of Partner
                        $parid = $this->Agent_model->getAllChildIds($dataArray); 
                        //echo $parid."<br/>"; die;
                
                if(!empty($data['USERNAME']) || !empty($data['START_DATE_TIME']) || !empty($data['END_DATE_TIME'])  )
	        {
                        //Time Stramp
                        if($data['START_DATE_TIME']){
                        $sdate=date("Y-m-d H:i:s",strtotime($data['START_DATE_TIME']));
                        }
                        if($data['END_DATE_TIME']){
                        $edate=date("Y-m-d H:i:s",strtotime($data['END_DATE_TIME']));
                        }
                        
                        if($data['USERNAME']!="")
			{
                        $userIDs = $this->Account_model->getUserIdByNameLike($data['USERNAME']);
                         
                          $conQuery .= "USER_ID IN ($userIDs) AND PARTNER_ID IN ($parid) ";
                        }
                        //echo $userIDs."<br/>".$parid;
			if($data['START_DATE_TIME']!="" and $data['END_DATE_TIME'] =="")
			 {
				
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."'";
				}else{			
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."'";
				}
			 }else if($data['START_DATE_TIME'] =="" and $data['END_DATE_TIME'] !=""){
			   if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  < '".$edate."' ";
				}else{			
					$conQuery .= " AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }else if($data['START_DATE_TIME'] !="" and $data['END_DATE_TIME'] !=""){
				if($data['USERNAME'] == ''){
				   $conQuery .= " PARTNER_ID IN ($parid) AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}else{		
				   $conQuery .= " AND TRANSACTION_DATE  > '".$sdate."' AND TRANSACTION_DATE  < '".$edate."'";
				}
			 }
                         
                         $sql =	$conQuery; 
                         //echo ("SELECT * from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs)");die;
                         $query = $this->db2->query("SELECT * from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($typeIDs) "); 
                         //echo "hi"; print_r($this->db->last_query());die;
                }else{
                         // echo ("SELECT * from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ");die;
                         $query = $this->db2->query("SELECT * from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($typeIDs) ");
                }
                
                         $fetchResults  = $query->result();
                         return $fetchResults;
                }   
        
		/*
		  Function name: InPointsTransTypeId
		  Author: Arun
		  Data: 
		  Purpose: 
		*/
		        
                public function InPointsTransTypeId(){
                    $query  = $this->db2->query("select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Deposit' OR TRANSACTION_TYPE_NAME = 'Promo' OR TRANSACTION_TYPE_NAME = 'Adjustment_Promo' OR TRANSACTION_TYPE_NAME = 'Adjustment_Deposit' OR TRANSACTION_TYPE_NAME = 'Adjustment_Win'");  
                    $totalCount = count($query->result())-1;
                
                    foreach ($query->result() as $key => $value) {
                        if($key == $totalCount)
                            $InPointsTypeIDs .= $value->TRANSACTION_TYPE_ID;
                        else
                            $InPointsTypeIDs .= $value->TRANSACTION_TYPE_ID.",";;
                    }
                    return $InPointsTypeIDs;                    
                }
                
                public function OutPointsTransTypeId(){
                    $query  = $this->db2->query("select TRANSACTION_TYPE_ID from transaction_type where TRANSACTION_TYPE_NAME = 'Withdraw' ");  
                    $totalCount = count($query->result())-1;
                
                    foreach ($query->result() as $key => $value) {
                        if($key == $totalCount)
                            $OutPointsTypeIDs .= $value->TRANSACTION_TYPE_ID;
                        else
                            $OutPointsTypeIDs .= $value->TRANSACTION_TYPE_ID.",";;
                    }
                    return $OutPointsTypeIDs;                    
                }                
    
        public function getPayInOutTypeIds(){
                        $inPoints  =  $this->InPointsTransTypeId();
                        $outPoints =  $this->OutPointsTransTypeId();
				
                        $typeIds = $inPoints.','.$outPoints;
                        return $typeIds;
		}
  

        public function getAllLedgerSearchInfo($data){
           	    
			//$typeIDs = $this->getPayInOutTypeIds();
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
						$transTypeIds = $this->config->item('typeId'); 
						foreach($transTypeIds as $value){
							if($TyPeIdS){
								$TyPeIdS = $TyPeIdS.','.$value;
							}else{
								$TyPeIdS = $value;
							}
						}
                        $query = $this->db2->query("SELECT * from master_transaction_history where $sql AND TRANSACTION_TYPE_ID IN ($TyPeIdS) ORDER BY TRANSACTION_DATE DESC "); 
                        $fetchResults  = $query->result();
                    
                }else{
		        if($data["USERNAME"] ==""){
                            $query = $this->db2->query("SELECT * from master_transaction_history where PARTNER_ID IN ($parid) AND TRANSACTION_TYPE_ID IN ($TyPeIdS) ORDER BY TRANSACTION_DATE DESC");
			    $fetchResults  = $query->result();
			}else{
			    $fetchResults  = "";
			}
					  
                }
			return $fetchResults;                    
                }

}