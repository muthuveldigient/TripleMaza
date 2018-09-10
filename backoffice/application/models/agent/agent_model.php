<?php
/*
  Class Name	: Agent_model
  Package Name  : Agent
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	: Azeem
  Date of create: Aug 02 2013
*/
class Agent_model extends CI_Model
{
	
	public function add_agent($formdata,$userdata){

	//$this->load->library('commonfunction');

	$PARTNER_USERNAME=$formdata['PARTNER_USERNAME'];
        $PARTNER_PASSWORD=md5($formdata['PARTNER_PASSWORD']);
        if($formdata['PARTNER_TRANSACTION_PASSWORD']){
        $PARTNER_TRANSACTION_PASSWORD=md5($formdata['PARTNER_TRANSACTION_PASSWORD']);
        }
        $PARTNER_COMMISSION_TYPE=$formdata['PARTNER_COMMISSION_TYPE'];
        $PARTNER_REVENUE_SHARE=$formdata['PARTNER_REVENUE_SHARE'];
        $PARTNER_DEPOSIT=$formdata['PARTNER_DEPOSIT'];
        if($formdata['subagentsid']){
        $PARTNER_ID=$formdata['subagentsid'];
        }else{
        $PARTNER_ID=$this->session->userdata('partnerid');    
        }
        $PARTNER_EMAIL=$formdata['EMAIL'];
        $PARTNER_COUNTRY=$formdata['PARTNER_COUNTRY'];
        $PARTNER_STATE=$formdata['PARTNER_STATE'];
        $PARTNER_AREA=$formdata['PARTNER_ADDRESS1'];
        $PARTNER_PHONE=$formdata['PARTNER_PHONE'];
        $PARTNER_TYPE_ID=$formdata['PARTNER_TYPE_ID'];

        $p_count  = "select * from partner where PARTNER_USERNAME='$PARTNER_USERNAME'";
	$p_result = $this->db2->query($p_count);
	$pnum=$p_result->num_rows();
        $cashcheck="/^[0-9].*$/";
        
        if($PARTNER_DEPOSIT){
        if(!preg_match($cashcheck,$PARTNER_DEPOSIT)){
            $error="Special characters are not allowed in amount";
            return $error;
            exit;
        }
        }
        
        if(!preg_match($cashcheck,$PARTNER_REVENUE_SHARE)){
            $error="Special characters are not allowed in commission";
            return $error;
            exit;
        }
        
        if($PARTNER_REVENUE_SHARE){
            if($PARTNER_REVENUE_SHARE>100){
			$error="Commission percentage is out of range";
            return $error;
            exit;
            }
        }
        
         if($PARTNER_USERNAME!='' && $PARTNER_PASSWORD!='' && $PARTNER_REVENUE_SHARE!='' && $PARTNER_TYPE_ID!=''){
          if($pnum==0){
                #Check available balance
               if($PARTNER_TYPE_ID!=1){
			   
                $selchkbal = $this->db2->query("SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID = '{$PARTNER_ID}'");
				
                $rowchkbal = $this->commonfunction->object2array($selchkbal->result());
                
                #Partner name
                $selpartner=$this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID='".$PARTNER_ID."'");
                $rowpartner=$selpartner->row();
                $partnername=$rowpartner->PARTNER_USERNAME;
                
		if($PARTNER_DEPOSIT<=$rowchkbal['AMOUNT']){
                $content_insert_query="INSERT INTO `partner`(
                                    `PARTNER_NAME`, 
                                     PARTNER_USERNAME,
                                     PARTNER_PASSWORD,
                                     PARTNER_TRANSACTION_PASSWORD,
                                     PARTNER_COMMISSION_TYPE,
                                    `PARTNER_REVENUE_SHARE`,
                                    `IS_OWN_PARTNER`,
                                    `PARTNER_STATUS`,
                                    `PARTNER_CREATED_BY`,
                                    `PARTNER_CREATED_ON`,
                                     STATUS,
                                     FK_PARTNER_ID,
                                     FK_PARTNER_TYPE_ID,
                                     MPARTNER_ID,
                                     PARTNER_EMAIL,
                                     PARTNER_COUNTRY,
                                     PARTNER_STATE,
                                     PARTNER_ADDRESS1,
                                     PARTNER_PHONE,
                                     CREATED_ON   
                                     )VALUES(
                                     '$PARTNER_USERNAME',
                                     '$PARTNER_USERNAME',
                                     '$PARTNER_PASSWORD',
                                     '$PARTNER_TRANSACTION_PASSWORD',
                                     '$PARTNER_COMMISSION_TYPE',
                                     '$PARTNER_REVENUE_SHARE',
                                     '0',   
                                     '1',
                                     '".$partnername."',
                                     now(),
                                     '1',
                                     '".$PARTNER_ID."',
                                     '".$PARTNER_TYPE_ID."',    
                                     '".$userdata['partnerid']."',
                                     '".$PARTNER_EMAIL."',
                                     '".$PARTNER_COUNTRY."',
                                     '".$PARTNER_STATE."',
                                     '".$PARTNER_AREA."',
                                     '".$PARTNER_PHONE."',    
                                     now()
                                     )";
                
            $result = $this->db->query($content_insert_query);
            //echo $this->db->last_query();
            $partnerid=$this->db->insert_id();
            
            
            
            
            if($PARTNER_DEPOSIT==""){
                $PARTNER_DEPOSIT="0";
            }
           
            #Add balance amount
            $addbal="insert into partners_balance(
                     PARTNER_ID,
                     AMOUNT,
                     CREATED_DATE
                     )values(
                     '".$partnerid."',
                     '".$PARTNER_DEPOSIT."',
                     now()
                     )";
            $this->db->query($addbal);
            if($PARTNER_DEPOSIT){
            $ireference=rand(1000000000,9999999999);
            $ttype='8';
            $tstatus='103';
            $pname=$userdata['partnerusername'];
            $addbaltrans="insert into partners_transaction_details(
                     PARTNER_ID,
                     TRANSACTION_TYPE_ID,
                     TRANSACTION_STATUS_ID,
                     AMOUNT,
                     INTERNAL_REFERENCE_NO,
                     CURRENT_TOT_BALANCE,
                     CLOSING_TOT_BALANCE,
                     CREATED_TIMESTAMP,
                     PROCESSED_BY
                     )values(
                     '".$partnerid."',
                     '".$ttype."',
                     '".$tstatus."',    
                     '".$PARTNER_DEPOSIT."',
                     '".$ireference."',
                     '0',
                     '".$PARTNER_DEPOSIT."',
                     now(),
                     '$pname'
                     )";
            $this->db->query($addbaltrans);
            
            $this->db->query("INSERT INTO `partner_adjustment_transaction` (
                       `ADJUSTMENT_TRANSACTION_ID` ,
                       `PARTNER_ID` ,
                       `TRANSACTION_TYPE_ID` ,
                       `INTERNAL_REFERENCE_NO` ,
                       `ADJUSTMENT_CREATED_BY` ,
                       `ADJUSTMENT_CREATED_ON` ,
                       `ADJUSTMENT_AMOUNT` ,
                       `ADJUSTMENT_ACTION`,
                       `ADJUSTMENT_PARTNER`
                       )VALUES (
                        NULL,
                        '".$partnerid."',
                        '8',
                        '$ireference',
                        '$pname',
                        NOW(),
                        '$PARTNER_DEPOSIT',
                        'Add',
                        '".$userdata['partnerid']."'
                        )");
            
            $this->db->query("INSERT INTO `partner_adjustment_transaction` (
                       `ADJUSTMENT_TRANSACTION_ID` ,
                       `PARTNER_ID` ,
                       `TRANSACTION_TYPE_ID` ,
                       `INTERNAL_REFERENCE_NO` ,
                       `ADJUSTMENT_CREATED_BY` ,
                       `ADJUSTMENT_CREATED_ON` ,
                       `ADJUSTMENT_AMOUNT` ,
                       `ADJUSTMENT_ACTION`,
                       `ADJUSTMENT_PARTNER`
                       )VALUES (
                        NULL,
                        '".$userdata['partnerid']."',
                        '8',
                        '$ireference',
                        '$PARTNER_USERNAME',
                        NOW(),
                        '$PARTNER_DEPOSIT',
                        'Add',
                        '".$userdata['partnerid']."'
                        )");

            $sql_curbal=$this->db2->query("select CLOSING_TOT_BALANCE from partners_transaction_details where PARTNER_ID='".$PARTNER_ID."' order by CREATED_TIMESTAMP desc limit 0,1");
            $row_curbal=$this->commonfunction->object2array($sql_curbal->result());
            if($row_curbal['CLOSING_TOT_BALANCE']){
            $newcurbal=$row_curbal['CLOSING_TOT_BALANCE'];
            }else{
            $newcurbal='0';    
            }
			
            if($row_curbal['CLOSING_TOT_BALANCE']){
            $newclosebal=$row_curbal['CLOSING_TOT_BALANCE']-$PARTNER_DEPOSIT;
            }else{
            $newclosebal=$PARTNER_DEPOSIT;    
            }
            
            
            $subtractbaltrans="insert into partners_transaction_details(
                     PARTNER_ID,
                     TRANSACTION_TYPE_ID,
                     TRANSACTION_STATUS_ID,
                     AMOUNT,
                     INTERNAL_REFERENCE_NO,
                     CURRENT_TOT_BALANCE,
                     CLOSING_TOT_BALANCE,
                     CREATED_TIMESTAMP,
                     SUB_PARTNER_ID,
                     PROCESSED_BY
                     )values(
                     '".$PARTNER_ID."',
                     '8',
                     '103',
                     '".$PARTNER_DEPOSIT."',
                     '".$ireference."',
                     '".$newcurbal."',
                     '".$newclosebal."',
                     now(),
                     '".$partnerid."',
                     '$pname'    
                     )";
            $this->db->query($subtractbaltrans);
            
            $this->db->query("INSERT INTO `partner_adjustment_transaction` (
                       `ADJUSTMENT_TRANSACTION_ID` ,
                       `PARTNER_ID` ,
                       `TRANSACTION_TYPE_ID` ,
                       `INTERNAL_REFERENCE_NO` ,
                       `ADJUSTMENT_CREATED_BY` ,
                       `ADJUSTMENT_CREATED_ON` ,
                       `ADJUSTMENT_AMOUNT` ,
                       `ADJUSTMENT_ACTION`,
                       `ADJUSTMENT_PARTNER`
                       )VALUES (
                        NULL,
                        '".$PARTNER_ID."',
                        '8',
                        '$ireference',
                        '$PARTNER_USERNAME',
                        NOW(),
                        '$PARTNER_DEPOSIT',
                        'Add',
                        '".$userdata['partnerid']."'
                        )");
            }
            
            $admin_user_query="INSERT INTO admin_user(
                                USERNAME,
                                PASSWORD,
                                TRANSACTION_PASSWORD,
                                FK_PARTNER_ID,
                                ACCOUNT_STATUS,
                                EMAIL,
                                STATE,
                                COUNTRY,
                                REGISTRATION_TIMESTAMP
                               )VALUES(
                                '$PARTNER_USERNAME',
                                '".$PARTNER_PASSWORD."',
                                '".$PARTNER_TRANSACTION_PASSWORD."',
                                '$partnerid',
                                '1',
                                '$PARTNER_EMAIL',
                                '$PARTNER_STATE',
                                '$PARTNER_COUNTRY',
                                now()
                               )";
                $this->db->query($admin_user_query);
                
                $adminuser_id=$this->db->insert_id();
            
                #Assign roles
             if($adminuser_id){
                        $sql_groupid=$this->db2->query("select ROLE_TO_ADMIN_ID from role_to_admin where FK_ADMIN_USER_ID='".$adminuser_id."'");
                        if($sql_groupid->num_rows()==0){
                           
                           $createby=$userdata['partnerusername'];
                           $crdate=date("Y-m-d");
                           
                           $mdl_id=$formdata['mdl_id'];
                           $mnu_id_pk=$formdata['mnu_id_pk'];
                           $sub_mnu_id_pk=$formdata['sub_mnu_id_pk'];
                           
                           //print_r($mdl_id);
                           for($i=0; $i<count($mdl_id);$i++)
                           {
                                    $mmi = $mdl_id[$i];
                                    $op_query="insert into role_to_admin(FK_ADMIN_USER_ID,FK_ROLE_ID,CREATE_BY,CREATE_DATE) values('".$adminuser_id."','$mmi','$createby',NOW())";
                                    $op_result=$this->db->query($op_query);
                           }

                           for($j=0; $j<count($mnu_id_pk);$j++)
                           {
                                    $smi = $mnu_id_pk[$j];
                                     $op_query1="insert into role_to_admin(FK_ADMIN_USER_ID,FK_ROLE_ID,CREATE_BY,CREATE_DATE) values('".$adminuser_id."','$smi','$createby',NOW())";
                                    $op_result1=$this->db->query($op_query1);
                           }
                           
                           for($k=0; $k<count($sub_mnu_id_pk);$k++) 
                           {
                                    $smoi = $sub_mnu_id_pk[$k];
                                    $op_query2="insert into role_to_admin(FK_ADMIN_USER_ID,FK_ROLE_ID,CREATE_BY,CREATE_DATE) values('".$adminuser_id."','$smoi','$createby',NOW())";
                                    $op_result2=$this->db->query($op_query2);
		           }
                           
                           

                        }else{
                              $querydel="delete from role_to_admin where FK_ADMIN_USER_ID='{$adminuser_id}'";
                              $resultsdel=$this->db->query($querydel);
                        }
                }
            
              
            
            
            #Update balance
            $sql_partnerbal=$this->db->query("update partners_balance set AMOUNT=AMOUNT-'".$PARTNER_DEPOSIT."' where PARTNER_ID='".$PARTNER_ID."'");
         //  echo $this->db->last_query();
                    $error = "";
			return $error;
			exit;
            
                }else{
                    $partnertype=$this->getPartnertype($PARTNER_ID);
                    $error="Top up amount exceeds ".$partnertype."'s available balance";
                    return $error;
                    exit;
                }
            
         }else{
                   $content_insert_query="INSERT INTO `partner`(
                                    `PARTNER_NAME`, 
                                     PARTNER_USERNAME,
                                     PARTNER_PASSWORD,
                                     PARTNER_TRANSACTION_PASSWORD,
                                     PARTNER_COMMISSION_TYPE,
                                    `PARTNER_REVENUE_SHARE`,
                                    `FK_PARTNER_TYPE_ID`,
                                    `PARTNER_STATUS`,
                                    `PARTNER_CREATED_BY`,
                                    `PARTNER_CREATED_ON`,
                                     STATUS,
                                     FK_PARTNER_ID,
                                     MPARTNER_ID,
                                     PARTNER_EMAIL,
                                     PARTNER_COUNTRY,
                                     PARTNER_STATE,
                                     PARTNER_ADDRESS1,
                                     PARTNER_PHONE,
                                     CREATED_ON   
                                     )VALUES(
                                     '$PARTNER_USERNAME',
                                     '$PARTNER_USERNAME',
                                     '$PARTNER_PASSWORD',
                                     '$PARTNER_TRANSACTION_PASSWORD',
                                     '$PARTNER_COMMISSION_TYPE',
                                     '$PARTNER_REVENUE_SHARE',
                                     '$PARTNER_TYPE_ID',   
                                     '1',
                                     '".$partnername."',
                                     now(),
                                     '1',
                                     '".$userdata['partnerid']."',
                                     '".$userdata['partnerid']."',
                                     '".$PARTNER_EMAIL."',
                                     '".$PARTNER_COUNTRY."',
                                     '".$PARTNER_STATE."',
                                     '".$PARTNER_AREA."',
                                     '".$PARTNER_PHONE."',    
                                     now()
                                     )";
                $result = $this->db->query($content_insert_query);
                $partnerid=$this->db->insert_id();

                if($PARTNER_DEPOSIT==""){
                    $PARTNER_DEPOSIT="0";
                }

                #Add balance amount
                $addbal="insert into partners_balance(
                         PARTNER_ID,
                         AMOUNT,
                         CREATED_DATE
                         )values(
                         '".$partnerid."',
                         '".$PARTNER_DEPOSIT."',
                         now()
                         )";
                $this->db->query($addbal);
                if($PARTNER_DEPOSIT){
                $ireference=rand(1000000000,9999999999);
                $ttype='8';
                $tstatus='103';
                $pname=$userdata['partnerusername'];
                $addbaltrans="insert into partners_transaction_details(
                         PARTNER_ID,
                         TRANSACTION_TYPE_ID,
                         TRANSACTION_STATUS_ID,
                         AMOUNT,
                         INTERNAL_REFERENCE_NO,
                         CURRENT_TOT_BALANCE,
                         CLOSING_TOT_BALANCE,
                         CREATED_TIMESTAMP,
                         PROCESSED_BY
                         )values(
                         '".$partnerid."',
                         '".$ttype."',
                         '".$tstatus."',    
                         '".$PARTNER_DEPOSIT."',
                         '".$ireference."',
                         '0',
                         '".$PARTNER_DEPOSIT."',
                         now(),
                         '$pname'
                         )";
                $this->db->query($addbaltrans);

                $this->db->query("INSERT INTO `partner_adjustment_transaction` (
                           `ADJUSTMENT_TRANSACTION_ID` ,
                           `PARTNER_ID` ,
                           `TRANSACTION_TYPE_ID` ,
                           `INTERNAL_REFERENCE_NO` ,
                           `ADJUSTMENT_CREATED_BY` ,
                           `ADJUSTMENT_CREATED_ON` ,
                           `ADJUSTMENT_AMOUNT` ,
                           `ADJUSTMENT_ACTION`,
                           `ADJUSTMENT_PARTNER`
                           )VALUES (
                            NULL,
                            '".$partnerid."',
                            '8',
                            '$ireference',
                            '$pname',
                            NOW(),
                            '$PARTNER_DEPOSIT',
                            'Add',
                            '".$userdata['partnerid']."'
                            )");

                $this->db->query("INSERT INTO `partner_adjustment_transaction` (
                           `ADJUSTMENT_TRANSACTION_ID` ,
                           `PARTNER_ID` ,
                           `TRANSACTION_TYPE_ID` ,
                           `INTERNAL_REFERENCE_NO` ,
                           `ADJUSTMENT_CREATED_BY` ,
                           `ADJUSTMENT_CREATED_ON` ,
                           `ADJUSTMENT_AMOUNT` ,
                           `ADJUSTMENT_ACTION`,
                           `ADJUSTMENT_PARTNER`
                           )VALUES (
                            NULL,
                            '".$userdata['partnerid']."',
                            '8',
                            '$ireference',
                            '$PARTNER_USERNAME',
                            NOW(),
                            '$PARTNER_DEPOSIT',
                            'Add',
                            '".$userdata['partnerid']."'
                            )");

                $sql_curbal=$this->db2->query("select CLOSING_TOT_BALANCE from partners_transaction_details where PARTNER_ID='".$PARTNER_DISTRIBUTOR."' order by CREATED_TIMESTAMP desc limit 0,1");
                $row_curbal=$this->commonfunction->object2array($sql_curbal->result());
                if($row_curbal['CLOSING_TOT_BALANCE']){
                $newcurbal=$row_curbal['CLOSING_TOT_BALANCE'];
                }else{
                $newcurbal='0';    
                }

                if($row_curbal['CLOSING_TOT_BALANCE']){
                $newclosebal=$row_curbal['CLOSING_TOT_BALANCE']-$PARTNER_DEPOSIT;
                }else{
                $newclosebal=$PARTNER_DEPOSIT;    
                }


                $subtractbaltrans="insert into partners_transaction_details(
                         PARTNER_ID,
                         TRANSACTION_TYPE_ID,
                         TRANSACTION_STATUS_ID,
                         AMOUNT,
                         INTERNAL_REFERENCE_NO,
                         CURRENT_TOT_BALANCE,
                         CLOSING_TOT_BALANCE,
                         CREATED_TIMESTAMP,
                         SUB_PARTNER_ID,
                         PROCESSED_BY
                         )values(
                         '".$PARTNER_DISTRIBUTOR."',
                         '8',
                         '103',
                         '".$PARTNER_DEPOSIT."',
                         '".$ireference."',
                         '".$newcurbal."',
                         '".$newclosebal."',
                         now(),
                         '".$partnerid."',
                         '$pname'    
                         )";
                $this->db->query($subtractbaltrans);

                $this->db->query("INSERT INTO `partner_adjustment_transaction` (
                           `ADJUSTMENT_TRANSACTION_ID` ,
                           `PARTNER_ID` ,
                           `TRANSACTION_TYPE_ID` ,
                           `INTERNAL_REFERENCE_NO` ,
                           `ADJUSTMENT_CREATED_BY` ,
                           `ADJUSTMENT_CREATED_ON` ,
                           `ADJUSTMENT_AMOUNT` ,
                           `ADJUSTMENT_ACTION`,
                           `ADJUSTMENT_PARTNER`
                           )VALUES (
                            NULL,
                            '".$PARTNER_DISTRIBUTOR."',
                            '8',
                            '$ireference',
                            '$PARTNER_USERNAME',
                            NOW(),
                            '$PARTNER_DEPOSIT',
                            'Add',
                            '".$userdata['partnerid']."'
                            )");
                }
                
                $admin_user_query="INSERT INTO admin_user(
                                USERNAME,
                                PASSWORD,
                                TRANSACTION_PASSWORD,
                                FK_PARTNER_ID,
                                ACCOUNT_STATUS,
                                EMAIL,
                                STATE,
                                COUNTRY,
                                REGISTRATION_TIMESTAMP
                               )VALUES(
                                '$PARTNER_USERNAME',
                                '$PARTNER_PASSWORD',
                                '$PARTNER_TRANSACTION_PASSWORD',
                                '$partnerid',
                                '1',
                                '$PARTNER_EMAIL',
                                '$PARTNER_STATE',
                                '$PARTNER_COUNTRY',
                                now()
                               )";
                $this->db->query($admin_user_query);
                
                $adminuser_id=$this->db->insert_id();
         }
            #Assign roles
             if($adminuser_id){
                        $sql_groupid=$this->db2->query("select ROLE_TO_ADMIN_ID from role_to_admin where FK_ADMIN_USER_ID='".$adminuser_id."'");
                        if($sql_groupid->num_rows()==0){
                           
                           $createby=$userdata['partnerusername'];
                           $crdate=date("Y-m-d");
                           
                           $mdl_id=$formdata['mdl_id'];
                           $mnu_id_pk=$formdata['mnu_id_pk'];
                           $sub_mnu_id_pk=$formdata['sub_mnu_id_pk'];
                           
                           //print_r($mdl_id);
                           for($i=0; $i<count($mdl_id);$i++)
                           {
                                    $mmi = $mdl_id[$i];
                                    $op_query="insert into role_to_admin(FK_ADMIN_USER_ID,FK_ROLE_ID,CREATE_BY,CREATE_DATE) values('".$adminuser_id."','$mmi','$createby',NOW())";
                                    $op_result=$this->db->query($op_query);
                           }

                           for($j=0; $j<count($mnu_id_pk);$j++)
                           {
                                    $smi = $mnu_id_pk[$j];
                                     $op_query1="insert into role_to_admin(FK_ADMIN_USER_ID,FK_ROLE_ID,CREATE_BY,CREATE_DATE) values('".$adminuser_id."','$smi','$createby',NOW())";
                                    $op_result1=$this->db->query($op_query1);
                           }
                           
                           for($k=0; $k<count($sub_mnu_id_pk);$k++) 
                           {
                                    $smoi = $sub_mnu_id_pk[$k];
                                    $op_query2="insert into role_to_admin(FK_ADMIN_USER_ID,FK_ROLE_ID,CREATE_BY,CREATE_DATE) values('".$adminuser_id."','$smoi','$createby',NOW())";
                                    $op_result2=$this->db->query($op_query2);
		           }
                           
                           

                        }else{
                              $querydel="delete from role_to_admin where FK_ADMIN_USER_ID='{$adminuser_id}'";
                              $resultsdel=$this->db->query($querydel);
                        }
                }
         }else{
                $err="Username already exists";
		return $err;
		exit;
         }
         }else{
			
			if($PARTNER_USERNAME==''){
				$err="Enter the Agent Name.";
				return $err;
				exit;
			} 
			if($PARTNER_PASSWORD==''){
			$err="Enter the Password.";
			return $err;
			exit;
			}
			
			if($PARTNER_REVENUE_SHARE==''){
			$err="Enter the Commission.";
			return $err;
			exit;
			}
			if($PARTNER_TYPE_ID==''){
			$err="Select the Partner Type.";
			return $err;
			exit;
			}
	  } 
}
public function addmainagent($data){
	$PARTNER_NAME=addslashes($data['PARTNER_NAME']);
	$PARTNER_USERNAME=$data['PARTNER_USERNAME'];
    $PARTNER_PASSWORD=$data['PARTNER_PASSWORD'];
    $PARTNER_TRANSACTION_PASSWORD=$data['PARTNER_TRANSACTION_PASSWORD'];
	$PARTNER_COMMISSION_TYPE=$data['PARTNER_COMMISSION_TYPE'];
	$PARTNER_REVENUE_SHARE=$data['PARTNER_REVENUE_SHARE'];
	$IS_OWN_PARTNER='1';
    $PARTNER_DEPOSIT=$data['PARTNER_DEPOSIT'];
    $p_count  = "select PARTNER_ID from partner where PARTNER_USERNAME='$PARTNER_USERNAME'";
	$p_result = $this->db2->query($p_count);
	$pnum=$p_result->num_rows();
          #partnername
          if($pnum==0){
            //$sql_partner=$this->db->query("select PARTNER_NAME from partner where PARTNER_ID=1");  
            //$row_partner=$sql_partner->row();  
            $pname=$this->session->userdata['USERNAME'];
            echo $content_insert_query="INSERT INTO `partner`(
                                    `PARTNER_NAME`, 
                                     PARTNER_USERNAME,
                                     PARTNER_PASSWORD,
                                     PARTNER_TRANSACTION_PASSWORD,
                                     PARTNER_COMMISSION_TYPE,
                                    `PARTNER_REVENUE_SHARE`,
                                    `IS_OWN_PARTNER`,
                                    `PARTNER_STATUS`,
                                    `PARTNER_CREATED_BY`,
                                    `PARTNER_CREATED_ON`,
                                     STATUS,
                                     CREATED_ON   
                                     )VALUES(
                                     '$PARTNER_NAME',
                                     '$PARTNER_USERNAME',
                                     '".md5($PARTNER_PASSWORD)."',
                                     '".md5($PARTNER_TRANSACTION_PASSWORD)."',
                                     '$PARTNER_COMMISSION_TYPE',
                                     '$PARTNER_REVENUE_SHARE',
                                     '$IS_OWN_PARTNER',
                                     '1',
                                     '$pname',
                                     now(),
                                     '1',
                                     now()
                                     )";
            $result = $this->db->query($content_insert_query);
            $partnerid=$this->db->insert_id();
            
            #Add balance amount
            $addbal="insert into partners_balance(
                     PARTNER_ID,
                     AMOUNT,
                     CREATED_DATE
                     )values(
                     '".$partnerid."',
                     '".$PARTNER_DEPOSIT."',
                     now()
                     )";
            $this->db->query($addbal);
            $ireference=rand(1000000000,9999999999);
            $ttype='8';
            $tstatus='103';
            $addbaltrans="insert into partners_transaction_details(
                     PARTNER_ID,
                     TRANSACTION_TYPE_ID,
                     TRANSACTION_STATUS_ID,
                     AMOUNT,
                     INTERNAL_REFERENCE_NO,
                     CURRENT_TOT_BALANCE,
                     CLOSING_TOT_BALANCE,
                     CREATED_TIMESTAMP
                     )values(
                     '".$partnerid."',
                     '".$ttype."',
                     '".$tstatus."',    
                     '".$PARTNER_DEPOSIT."',
                     '".$ireference."',
                     '0',
                     '".$PARTNER_DEPOSIT."',
                     now()
                     )";
            $this->db->query($addbaltrans);
            
            if($partnerid){
                        $sql_groupid=$this->db2->query("select GROUP_ID from group_info where PARTNER_ID='".$partnerid."'");
                           #Add group
                        if($sql_groupid->num_rows==0){
                           $groupname=$PARTNER_USERNAME;
                           $createby=$this->session->userdata['USERNAME'];
                           $crdate=date("Y-m-d");
                           $this->db->query("insert into group_info(PARTNER_ID,GROUP_NAME,STATUS,CREATE_BY,CREATE_DATE)values('".$partnerid."','".$groupname."','1','".$createby."','".$crdate."')"); 
                           $groupid=$this->db->insert_id();
                           $mdl_id=$data['mdl_id'];
                           $mnu_id_pk=$data['mnu_id_pk'];
                           $sub_mnu_id_pk=$data['sub_mnu_id_pk'];
                           
                           for($i=0; $i<count($mdl_id);$i++)
                           {
                                    $mmi = $mdl_id[$i];
                                    $op_query="insert into group_mp_main_menu_info(PARTNER_ID,GROUP_ID,MAIN_MENU_ID,CREATE_BY,CREATE_DATE) values('".$partnerid."','".$groupid."','$mmi','$createby',NOW())";
                                    $op_result=$this->db->query($op_query);
                           }

                           for($j=0; $j<count($mnu_id_pk);$j++)
                           {
                                    $smi = $mnu_id_pk[$j];
                                     $op_query1="insert into group_mp_sub_menu_info(PARTNER_ID,GROUP_ID,SUB_MENU_ID,CREATE_BY,CREATE_DATE) values('".$partnerid."','".$groupid."','$smi','$createby',NOW())";
                                    $op_result1=$this->db->query($op_query1);
                           }
                           
                           for($k=0; $k<count($sub_mnu_id_pk);$k++) 
                           {
                                    $smoi = $sub_mnu_id_pk[$k];
                                    $op_query2="insert into group_mp_sub_menu_option_info(PARTNER_ID,GROUP_ID,SUB_MENU_OP_ID,CREATE_BY,CREATE_DATE) values('".$partnerid."','".$groupid."','$smoi','$createby',NOW())";
                                    $op_result2=$this->db->query($op_query2);
		           }
                           
                           #Update the group id for partner
                           if($groupid!='' && $partnerid!=''){
                             //  echo "update partner set GROUP_ID='".$groupid."' where PARTNER_ID='".$partnerid."'";
                           $this->db->query("update partner set GROUP_ID='".$groupid."' where PARTNER_ID='".$partnerid."'");
                           }
                           
                        }else{

                              $querydel="delete from group_mp_main_menu_info where GROUP_ID='{$partnerid}'";
                              $resultsdel=$this->db->query($querydel) or die("connection failed");
                              $querydel1="delete from group_mp_sub_menu_info where GROUP_ID='{$partnerid}'";
                              $resultsdel1=$this->db->query($querydel1) or die("connection failed");
                              $querydel2="delete from group_mp_sub_menu_option_info where GROUP_ID='{$partnerid}'";
                              $resultsdel2=$this->db->query($querydel2) or die("connection failed");

                               for ($i=0; $i<count($mdl_id);$i++) 
                                    {
                                                    $mmi = $mdl_id[$i];
                                                    $op_query="insert into group_mp_main_menu_info(PARTNER_ID,GROUP_ID,MAIN_MENU_ID,CREATE_BY,CREATE_DATE) values('".$data['MPname']."','".$data['id']."','$mmi','$USR_PAR_ID',NOW())";
                                                    $op_result=$this->db->query($op_query);
                                    }

                               for ($j=0; $j<count($mnu_id_pk);$j++) 
                                    {
                                                    $smi = $mnu_id_pk[$j];
                                                    $op_query1="insert into group_mp_sub_menu_info(PARTNER_ID,GROUP_ID,SUB_MENU_ID,CREATE_BY,CREATE_DATE) values('".$data['MPname']."','".$data['id']."','$smi','$USR_PAR_ID',NOW())";
                                                    $op_result1=$this->db->query($op_query1);
                                    }
                        }
                }
            
            $err = "";
			return $err;
         }else{
             $err="Username already exists";
			 return $err;
			 exit;
         }
        
	}
	
	
	 public function record_count()
    {
        $patid=$this->session->userdata('isownpartner');
        
        if(!$patid){
			if(isset($this->session->userdata['ADMIN_USER_ID'])){
			 if($this->session->userdata['ADMIN_USER_ID']==1){
			 $querycnt=$this->db2->query("select count(*) as cnt from partner where IS_OWN_PARTNER=1 and IS_DISTRIBUTOR=0");
			 }
			 else{
			 $querycnt=$this->db2->query("select count(*) as cnt from partner where IS_OWN_PARTNER=1 and IS_DISTRIBUTOR=0 and PARTNER_CREATED_BY='".$this->session->userdata["USERNAME"]."'");
			 }
			}
			else{
				$querycnt=$this->db2->query("select count(*) as cnt from partner where FK_PARTNER_ID='".$this->session->userdata('partnerid')."' and IS_DISTRIBUTOR=0");
			}
            
            
        }else{ 
            $sql_distpart=$this->db2->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$this->session->userdata('partnerid')."' and IS_DISTRIBUTOR=1");

            foreach($sql_distpart->result() as $row){
                    if($this->distpart){
                        $this->distpart=$this->distpart.",".$row->PARTNER_ID;
                    }else{
                        $this->distpart=$row->PARTNER_ID;
                    }
            }
    
            if($this->distpart==""){
                $this->distpart="-1";
            }
            $querycnt=$this->db2->query("select count(*) as cnt from partner where FK_PARTNER_ID in(".$this->distpart.") and IS_DISTRIBUTOR=0");
        }
        
        $row=$querycnt->row();
      //  return $this->session->userdata('isownpartner');
        return $row->cnt;
    }
	
	public function getAgentsByDistributorId($id,$limit,$start){
	
     	$data1='';  
        $patid=$id;
        
        if(!$patid){
			 if(isset($this->session->userdata['ADMIN_USER_ID'])){
			 if($this->session->userdata['ADMIN_USER_ID']==1){
			 $query=$this->db2->query("SELECT partner.* FROM partner WHERE IS_OWN_PARTNER=1 and IS_DISTRIBUTOR=0 order by PARTNER_ID DESC LIMIT $start,$limit");
			 }
			 else{
			 $query=$this->db2->query("SELECT partner.* FROM partner WHERE IS_OWN_PARTNER=1 and IS_DISTRIBUTOR=0 and PARTNER_CREATED_BY='".$this->session->userdata['USERNAME']."' order by PARTNER_ID DESC LIMIT $start,$limit");
			 }
			 }
			 else{
			$query=$this->db2->query("SELECT partner.* FROM partner WHERE FK_PARTNER_ID ='".$this->session->userdata('partnerid')."' and IS_DISTRIBUTOR=0 order by PARTNER_ID DESC LIMIT $start,$limit");    
			}
        }else{
		
        $sql_distpart=$this->db2->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$patid."' and IS_DISTRIBUTOR=1");
        
            foreach($sql_distpart->result() as $row){
    
		
		            if($this->distpart){
                        $this->distpart=$this->distpart.",".$row->PARTNER_ID;
                    }else{
                        $this->distpart=$row->PARTNER_ID;
                    }
            }
    
            if($this->distpart==""){
                $this->distpart="-1";
            }
		
			
        $query=$this->db2->query("SELECT partner.* FROM partner WHERE FK_PARTNER_ID in(".$this->distpart.") and IS_DISTRIBUTOR=0 order by PARTNER_ID DESC LIMIT $start,$limit");    
        }
        
        foreach($query->result() as $row){
			if(isset($this->session->userdata['ADMIN_USER_ID'])){
			$data1[] ="<a href='".base_url()."cpanel_home/?PARTNER_USERNAME=".$row->PARTNER_USERNAME."&p=vpard&id=".base64_encode($row->PARTNER_ID)."&chk=".$this->input->get_post('chk',TRUE)."&'><b>".$row->PARTNER_USERNAME."</b></a>"; 
			}
			else{
			$data1[] ="<a href='".base_url()."agent/myagent/detail/".base64_encode($row->PARTNER_ID)."/".$row->PARTNER_USERNAME."'><b>".$row->PARTNER_USERNAME."</b></a>"; 
			}

            
            if($row->CREATED_ON){
            $ndate=explode(" ",$row->CREATED_ON);
            $data1[] = date("d-m-Y",strtotime($ndate[0]))." ".$ndate[1];
            }
            if($row->MAC_ID){
            $data1[]=$row->MAC_ID;
            }else{
            $data1[]='-';    
            }
            
            if($row->PARTNER_COMMISSION_TYPE=='1'){
                $data1[] = 'Turn Over';
            }else{
                $data1[] = 'Revenue';
            }
            $data1[] = $row->PARTNER_REVENUE_SHARE;
            
            if($row->FK_PARTNER_ID){
                $sql_distuser=$this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID='".$row->FK_PARTNER_ID."'");
                
                $row_distuser=$sql_distuser->row();
				if(!empty($row_distuser)){
				$rowaname=$row_distuser->PARTNER_USERNAME;
				}
				else{
				$rowaname='';
				}
                $data1[] = $rowaname;
            }
            
            $sql_partner_bal=$this->db2->query("select AMOUNT from partners_balance where PARTNER_ID=$row->PARTNER_ID");
           
            $row_partner_bal=$sql_partner_bal->row();
			if(!empty($row_partner_bal)){
			$rweamnt=$row_partner_bal->AMOUNT;
			}
			else{
			$rweamnt='';
			}
            $data1[] = number_format($rweamnt,2,".","");
            $status ="<span id='def".$row->PARTNER_ID."' style='display:block; text-align:center'>";
            if($row->STATUS == "1"){
                $status .="<a href=javascript:openDESCRIPTION_Div(".$row->PARTNER_ID."); title='Acive'><img src='".base_url()."static/images/active.gif' alt='Acive' border='0' /></a>";
            }else if($row->STATUS == "0"){
                $status .='<a href="javascript:authenticate(\'act'.$row->PARTNER_ID.'\', \''.$row->PARTNER_ID.'\', \'status\', \'act\');" title=\'Deactive\'><img src=\''.base_url().'static/images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
            }
            $status .="</span>";
            $status .="<span id='dact".$row->PARTNER_ID."' style='display:none; text-align:center'></span>";
            $status .="<span id='act".$row->PARTNER_ID."' style='display:none; text-align:center'></span>";
            
            $data1[] = $status;
			if(isset($this->session->userdata['ADMIN_USER_ID'])){
            $data1[] = "<a href='".base_url()."cpanel_home/?p=vspusr&id=".base64_encode($row->PARTNER_ID)."&na=".$row->PARTNER_USERNAME."&chk=".$this->input->get_post('chk',TRUE)."' ><b>View User</b></a>";
			}
			else{
            $data1[] = "<a href=".base_url()."user/account/view/".base64_encode($row->PARTNER_ID)."/".$row->PARTNER_USERNAME."><b>View User</b></a>";
			}

        }
        
       // return "test";
        //return print_r($data1);
		if(is_array($data1)){
        return array_chunk($data1,9); 
		}
		else{
		return $data1; 
		}
	}
    
    public function fetch_partner($limit,$start)
    {
     $data1='';  
        $patid=$this->session->userdata('isownpartner');
        
        if(!$patid){
			 if(isset($this->session->userdata['ADMIN_USER_ID'])){
			 if($this->session->userdata['ADMIN_USER_ID']==1){
			 $query=$this->db2->query("SELECT partner.* FROM partner WHERE IS_OWN_PARTNER=1 and IS_DISTRIBUTOR=0 order by PARTNER_ID DESC LIMIT $start,$limit");
			 }
			 else{
			 $query=$this->db2->query("SELECT partner.* FROM partner WHERE IS_OWN_PARTNER=1 and IS_DISTRIBUTOR=0 and PARTNER_CREATED_BY='".$this->session->userdata['USERNAME']."' order by PARTNER_ID DESC LIMIT $start,$limit");
			 }
			 }
			 else{
			$query=$this->db2->query("SELECT partner.* FROM partner WHERE FK_PARTNER_ID ='".$this->session->userdata('partnerid')."' and IS_DISTRIBUTOR=0 order by PARTNER_ID DESC LIMIT $start,$limit");    
			}
        }else{
        $sql_distpart=$this->db2->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$this->session->userdata('partnerid')."' and IS_DISTRIBUTOR=1");
        
            foreach($sql_distpart->result() as $row){
                    if($this->distpart){
                        $this->distpart=$this->distpart.",".$row->PARTNER_ID;
                    }else{
                        $this->distpart=$row->PARTNER_ID;
                    }
            }
    
            if($this->distpart==""){
                $this->distpart="-1";
            }
        $query=$this->db2->query("SELECT partner.* FROM partner WHERE FK_PARTNER_ID in(".$this->distpart.") and IS_DISTRIBUTOR=0 order by PARTNER_ID DESC LIMIT $start,$limit");    
        }
        
        foreach($query->result() as $row){
			if(isset($this->session->userdata['ADMIN_USER_ID'])){
			$data1[] ="<a href='".base_url()."cpanel_home/?PARTNER_USERNAME=".$row->PARTNER_USERNAME."&p=vpard&id=".base64_encode($row->PARTNER_ID)."&chk=".$this->input->get_post('chk',TRUE)."&'><b>".$row->PARTNER_USERNAME."</b></a>"; 
			}else{
			$data1[] ="<a href='".base_url()."agent/myagent/detail/".base64_encode($row->PARTNER_ID)."/".$row->PARTNER_USERNAME."'><b>".$row->PARTNER_USERNAME."</b></a>"; 
			}

            
            if($row->CREATED_ON){
            $ndate=explode(" ",$row->CREATED_ON);
            $data1[] = date("d-m-Y",strtotime($ndate[0]))." ".$ndate[1];
            }
            if($row->MAC_ID){
            $data1[]=$row->MAC_ID;
            }else{
            $data1[]='-';    
            }
            
            if($row->PARTNER_COMMISSION_TYPE=='1'){
                $data1[] = 'Turn Over';
            }else{
                $data1[] = 'Revenue';
            }
            $data1[] = $row->PARTNER_REVENUE_SHARE;
            
            if($row->FK_PARTNER_ID){
                $sql_distuser=$this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID='".$row->FK_PARTNER_ID."'");
                
                $row_distuser=$sql_distuser->row();
				if(!empty($row_distuser)){
				$rowaname=$row_distuser->PARTNER_USERNAME;
				}
				else{
				$rowaname='';
				}
                $data1[] = $rowaname;
            }
            
            $sql_partner_bal=$this->db2->query("select AMOUNT from partners_balance where PARTNER_ID=$row->PARTNER_ID");
           
            $row_partner_bal=$sql_partner_bal->row();
            
            if(!empty($row_partner_bal)){
            $rweamnt=$row_partner_bal->AMOUNT;
            }else{
            $rweamnt='';
            }
                        
            $data1[] = number_format($rweamnt,2,".","");
            $status ="<span id='def".$row->PARTNER_ID."' style='display:block; text-align:center'>";
            if($row->STATUS == "1"){
                $status .="<a href=javascript:openDESCRIPTION_Div(".$row->PARTNER_ID."); title='Acive'><img src='".base_url()."static/images/active.gif' alt='Acive' border='0' /></a>";
            }else if($row->STATUS == "0"){
                $status .='<a href="javascript:authenticate(\'act'.$row->PARTNER_ID.'\', \''.$row->PARTNER_ID.'\', \'status\', \'act\');" title=\'Deactive\'><img src=\''.base_url().'static/images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
            }
            $status .="</span>";
            $status .="<span id='dact".$row->PARTNER_ID."' style='display:none; text-align:center'></span>";
            $status .="<span id='act".$row->PARTNER_ID."' style='display:none; text-align:center'></span>";
            
            $data1[] = $status;
            
			if(isset($this->session->userdata['ADMIN_USER_ID'])){
            $data1[] = "<a href='".base_url()."cpanel_home/?p=vspusr&id=".base64_encode($row->PARTNER_ID)."&na=".$row->PARTNER_USERNAME."&chk=".$this->input->get_post('chk',TRUE)."' ><b>View Users</b></a>";
			}else{
            $data1[] = "<a href='".base_url()."user/account/view/".base64_encode($row->PARTNER_ID)."/".$row->PARTNER_USERNAME."' ><b>View Users</b></a>";
			}

        }
        
       // return "test";
        //return print_r($data1);
		if(is_array($data1)){
                return array_chunk($data1,9); 
		}else{
		return $data1; 
		}
		
    }
	
	
    public function get_agent_details($data){
	$sqlres=$this->db2->query("SELECT * FROM partner WHERE PARTNER_ID=".addslashes($data['id'])."");
	if(is_array($sqlres->result()) && count($sqlres->result())>0){
            
            foreach($sqlres->result() as $key=>$rows){
            $row[$key]=$rows; 
            }

            foreach($row as $key1=>$value){
                    if(is_object($value))
                    {
                            foreach($value as $key=>$val){
                            $userarray[$key1][$key]=$value->$key;
                            }
                    }
            }
	}
        return $userarray;
    }
    
public function get_groupid($data){
$sql_groupid=$this->db2->query("select GROUP_ID from group_info where PARTNER_ID='".$data['id']."'");
$row_groupid=$sql_groupid->row()->GROUP_ID;
if(isset($this->session->userdata['ADMIN_USER_ID'])){
$sql_magntgroupid=$this->db2->query("select GROUP_ID from group_info where GROUP_ID='".$row_groupid."'");
}
else{
$sql_magntgroupid=$this->db2->query("select GROUP_ID from group_info where GROUP_ID='".$this->session->userdata['groupid']."'");
}
$row_magntgroupid=$sql_magntgroupid->row();	
if(isset($this->session->userdata['ADMIN_USER_ID'])){
if($row_magntgroupid->GROUP_ID){
    $grp_magnt_main_menu_q=$this->db2->query("SELECT
                main_menu_info.MAIN_MENU_NAME
                ,group_mp_main_menu_info.MAIN_MENU_ID
                ,main_menu_info.MAIN_MENU_ID AS Mid
        FROM
                group_mp_main_menu_info
                INNER JOIN main_menu_info 
                        ON (group_mp_main_menu_info.MAIN_MENU_ID = main_menu_info.MAIN_MENU_ID and group_mp_main_menu_info.GROUP_ID ='".$row_groupid."' ) 
        ");
    foreach($grp_magnt_main_menu_q->result() as $row_magnt_main_menu_q){
        $MIDS[]=$row_magnt_main_menu_q->Mid;
    }
}
}
else{
if($row_magntgroupid->GROUP_ID){
    $grp_magnt_main_menu_q=$this->db2->query("SELECT
                main_menu_info.MAIN_MENU_NAME
                ,group_mp_main_menu_info.MAIN_MENU_ID
                ,main_menu_info.MAIN_MENU_ID AS Mid
        FROM
                group_mp_main_menu_info
                INNER JOIN main_menu_info 
                        ON (group_mp_main_menu_info.MAIN_MENU_ID = main_menu_info.MAIN_MENU_ID and group_mp_main_menu_info.GROUP_ID ='".$this->session->userdata['groupid']."' ) 
        ");
    foreach($grp_magnt_main_menu_q->result() as $row_magnt_main_menu_q){
        $MIDS[]=$row_magnt_main_menu_q->Mid;
    }
}
}
$Array['GROUP_ID']=$row_groupid;
$Array['MIDS']=$MIDS;
return $Array;
}

public function edit_agent($data){
$row_groupid=$this->get_groupid($data);
$row=$this->get_agent_details($data);
	if($data['edit_flag']=='w')
	{
            $userid=$data['id'];
			$gameId="0";			
			$xP="0";
			$goodsKey="0";	
			$internalRefNo=rand(1000000000,9999999999);
			$comment = addslashes($data['comment']);
			$calc = addslashes($data['calc']);
            $qry="SELECT * FROM partners_balance WHERE PARTNER_ID=".addslashes($data['id']);
		$results=$this->db2->query($qry);
                $transactionTypeId='8';
                $transactionStatusId='103';
                
                $sqlpartner_name=$this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID='".$row['FK_PARTNER_ID']."'");
                $rowpartner_name=$sqlpartner_name->row();
                $pname=$rowpartner_name->PARTNER_USERNAME;
                $patid=$row['FK_PARTNER_ID'];
		foreach($results->result() as $row_wallet){
			#Check partner balance
                        $sql_partbal=$this->db2->query("select AMOUNT from partners_balance where PARTNER_ID=".$row['FK_PARTNER_ID']);
                        $row_partbal=$sql_partbal->row();
                        if($data['cash']!=0){
                            if($data['calc']=="Add"){
                                if($data['cash']<$row_partbal->AMOUNT){
                                    $transactionAmount=$data['cash'];
                                    $balanceTypeId="1";
                                    $cdep = $row_partbal->AMOUNT;

                                    $cdep = $cdep + $data['cash'];
                                    $cashTot=$row_wallet->AMOUNT + $data['cash'];
                                    $currentTotCash=$row_wallet->AMOUNT;
                                    $mainpartbal=$row_partbal->AMOUNT-$data['cash'];


                                    $query="UPDATE partners_balance SET AMOUNT='".$cashTot."' WHERE PARTNER_ID='{$userid}'";		
                                    $this->db->query($query);
                                    
                                    $query = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`)VALUES ('$userid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot')");
                                    $query1 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','Add', '$comment')");
                                    $query2 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$patid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','Remove', '$comment')");
                                   #Update main partner balance
                                    $querymbal=$this->db->query("UPDATE partners_balance SET AMOUNT=$mainpartbal WHERE PARTNER_ID='{$row['FK_PARTNER_ID']}'");
                                    
                                   #Current balance
                                    $newcurbal=$row_partbal->AMOUNT;
                                    
                                    $newclosebal=$mainpartbal;
                                    
                                    $querymbaldet = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`SUB_PARTNER_ID`)VALUES ('$patid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$newcurbal', '$newclosebal','{$userid}')");
									$error="";
									return $error;
                                }else{
								$error="Deposit amount exceeds your available balance";
								return $error;
                                exit();
                                }
                          }else{
                                 if($data['cash']<$row_wallet->AMOUNT){
                                    $transactionAmount=$data['cash'];
                                            $balanceTypeId="1";
                                            $cdep = $row_wallet->AMOUNT;
                                            $cdep = $cdep - $data['cash'];
                                            $cashTot=$row_wallet->AMOUNT - $data['cash'];
                                            $currentTotCash=$row_wallet->AMOUNT;
                                            $mainpartbal=$row_partbal->AMOUNT+$data['cash'];
                                            $query="UPDATE partners_balance SET AMOUNT='".$cashTot."' WHERE PARTNER_ID='{$userid}'";		
                                            $this->db->query($query);
                                            $query = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`)VALUES ('$userid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot')");
                                            $query1 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','$calc', '$comment')");
                                            $query2 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$patid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','Add', '$comment')");
                                           #Update main partner balance
                                            $querymbal=$this->db->query("UPDATE partners_balance SET AMOUNT=$mainpartbal WHERE PARTNER_ID='{$row['FK_PARTNER_ID']}'");
                                           #Current balance
                                            
                                            $newcurbal=$row_partbal->AMOUNT;
                                            
                                            $newclosebal=$mainpartbal;    
                                            
                                            $querymbaldet = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`SUB_PARTNER_ID`)VALUES ('$patid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$newcurbal', '$newclosebal','{$userid}')");
								$error="";
								return $error;
                                }else{
                                 $error="Withdraw amount exceeds partner's available balance";
								 return $error;
                                 exit; 
                                }
                          }
                     } 
		}
		$error="";
		return $error;
		exit;
	}else{
            $PARTNER_USERNAME=$data['PARTNER_USERNAME'];
            $p_count  = "select PARTNER_ID from partner where PARTNER_USERNAME='$PARTNER_USERNAME' and PARTNER_ID!='{$data['id']}'";
            $p_result = $this->db2->query($p_count);
            $pnum=$p_result->num_rows();
            if($pnum==0){
		$userid=$data['id'];
		//$p_username=$data['p_username'];
		$PARTNER_NAME=$data['PARTNER_USERNAME'];
		$PARTNER_REVENUE_SHARE=$data['PARTNER_REVENUE_SHARE'];
                $PARTNER_COMMISSION_TYPE=$data['PARTNER_COMMISSION_TYPE'];
                $PARTNER_PASSWORD=md5($data['PARTNER_PASSWORD']);
                $PARTNER_TRANSACTION_PASSWORD=md5($data['PARTNER_TRANSACTION_PASSWORD']);
                if($data['PARTNER_PASSWORD']!='1234567890' && $data['PARTNER_TRANSACTION_PASSWORD']!='1234567890'){
                    $query="UPDATE partner SET 
                                   PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                                   PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."',
                                   PARTNER_PASSWORD='".$PARTNER_PASSWORD."',
                                   PARTNER_TRANSACTION_PASSWORD='".$PARTNER_TRANSACTION_PASSWORD."'
                             WHERE PARTNER_ID='{$userid}'";		
                    $this->db->query($query);
                }elseif($data['PARTNER_PASSWORD']!='1234567890'){
                     $query="UPDATE partner SET 
                               PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                               PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."',
                               PARTNER_PASSWORD='".$PARTNER_PASSWORD."'
		 	 WHERE PARTNER_ID='{$userid}'";		
                     $this->db->query($query);
                }elseif($data['PARTNER_TRANSACTION_PASSWORD']!='1234567890'){
                    $query="UPDATE partner SET 
                                   PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                                   PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."',
                                   PARTNER_TRANSACTION_PASSWORD='".$PARTNER_TRANSACTION_PASSWORD."'
                             WHERE PARTNER_ID='{$userid}'";		
                    $this->db->query($query);
                }else{
                    $query="UPDATE partner SET 
                                   PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                                   PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."'
                             WHERE PARTNER_ID='{$userid}'";		
                    $this->db->query($query);
                }
			   if(isset($this->session->userdata['ADMIN_USER_ID'])){
			   $createby=ucfirst($this->session->userdata['USERNAME']);
			   }else{
               $createby=$this->session->userdata['partnerusername'];
			   }
			   
               $crdate=date("Y-m-d");
               $querydel="delete from group_mp_main_menu_info where GROUP_ID='{$row_groupid['GROUP_ID']}'";
               $resultsdel=$this->db->query($querydel);
               $querydel1="delete from group_mp_sub_menu_info where GROUP_ID='{$row_groupid['GROUP_ID']}'";
               $resultsdel1=$this->db->query($querydel1);
               $querydel2="delete from group_mp_sub_menu_option_info where GROUP_ID='{$row_groupid['GROUP_ID']}'";
               $resultsdel2=$this->db->query($querydel2);
               
               
               $mdl_id=$data['mdl_id'];
               $mnu_id_pk=$data['mnu_id_pk'];
               $sub_mnu_id_pk=$data['sub_mnu_id_pk'];

               //print_r($mdl_id);
               for($i=0; $i<count($mdl_id);$i++)
               {
                        $mmi = $mdl_id[$i];
                        $op_query="insert into group_mp_main_menu_info(PARTNER_ID,GROUP_ID,MAIN_MENU_ID,CREATE_BY,CREATE_DATE) values('".$userid."','".$row_groupid['GROUP_ID']."','$mmi','$createby',NOW())";
                        $op_result=$this->db->query($op_query);
               }

               for($j=0; $j<count($mnu_id_pk);$j++)
               {
                        $smi = $mnu_id_pk[$j];
                        $op_query1="insert into group_mp_sub_menu_info(PARTNER_ID,GROUP_ID,SUB_MENU_ID,CREATE_BY,CREATE_DATE) values('".$userid."','".$row_groupid['GROUP_ID']."','$smi','$createby',NOW())";
                        $op_result1=$this->db->query($op_query1);
               }

               for($k=0; $k<count($sub_mnu_id_pk);$k++) 
               {
                        $smoi = $sub_mnu_id_pk[$k];
                        $op_query2="insert into group_mp_sub_menu_option_info(PARTNER_ID,GROUP_ID,SUB_MENU_OP_ID,CREATE_BY,CREATE_DATE) values('".$userid."','".$row_groupid['GROUP_ID']."','$smoi','$createby',NOW())";
                        $op_result2=$this->db->query($op_query2);
               }
                
			$error="";
			return $error;
            }else{
			$error="Username Already Exists";
			return $error;
			exit;
            } 
 	}


}


public function edit_mainagent($data){
$row_groupid=$this->get_groupid($data);
$row=$this->get_agent_details($data);
	if($data['edit_flag']=='w')
	{
            $userid=$data['id'];
			$gameId="0";			
			$xP="0";
			$goodsKey="0";	
			$internalRefNo=rand(1000000000,9999999999);
			$comment = addslashes($data['comment']);
			$calc = addslashes($data['calc']);
            $qry="SELECT * FROM partners_balance WHERE PARTNER_ID=".addslashes($data['id']);
		$results=$this->db2->query($qry);
                $transactionTypeId='8';
                $transactionStatusId='103';
                
                $sqlpartner_name=$this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID='".$row['FK_PARTNER_ID']."'");
                $rowpartner_name=$sqlpartner_name->row();
                $pname=$rowpartner_name->PARTNER_USERNAME;
                $patid=$row['FK_PARTNER_ID'];
		foreach($results->result() as $row_wallet){
			#Check partner balance
                        $sql_partbal=$this->db2->query("select AMOUNT from partners_balance where PARTNER_ID=".$row['FK_PARTNER_ID']);
                        $row_partbal=$sql_partbal->row();
                        if($data['cash']!=0){
                            if($data['calc']=="Add"){
                                if($data['cash']<$row_partbal->AMOUNT){
                                    $transactionAmount=$data['cash'];
                                    $balanceTypeId="1";
                                    $cdep = $row_partbal->AMOUNT;

                                    $cdep = $cdep + $data['cash'];
                                    $cashTot=$row_wallet->AMOUNT + $data['cash'];
                                    $currentTotCash=$row_wallet->AMOUNT;
                                    $mainpartbal=$row_partbal->AMOUNT-$data['cash'];


                                    $query="UPDATE partners_balance SET AMOUNT='".$cashTot."' WHERE PARTNER_ID='{$userid}'";		
                                    $this->db->query($query);
                                    
                                    $query = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`)VALUES ('$userid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot')");
                                    $query1 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','Add', '$comment')");
                                    $query2 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$patid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','Remove', '$comment')");
                                   #Update main partner balance
                                    $querymbal=$this->db->query("UPDATE partners_balance SET AMOUNT=$mainpartbal WHERE PARTNER_ID='{$row['FK_PARTNER_ID']}'");
                                    
                                   #Current balance
                                    $newcurbal=$row_partbal->AMOUNT;
                                    
                                    $newclosebal=$mainpartbal;
                                    
                                    $querymbaldet = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`SUB_PARTNER_ID`)VALUES ('$patid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$newcurbal', '$newclosebal','{$userid}')");
									$error="";
									return $error;
                                }else{
								$error="Deposit amount exceeds your available balance";
								return $error;
                                exit();
                                }
                          }else{
                                 if($data['cash']<$row_wallet->AMOUNT){
                                    $transactionAmount=$data['cash'];
                                            $balanceTypeId="1";
                                            $cdep = $row_wallet->AMOUNT;
                                            $cdep = $cdep - $data['cash'];
                                            $cashTot=$row_wallet->AMOUNT - $data['cash'];
                                            $currentTotCash=$row_wallet->AMOUNT;
                                            $mainpartbal=$row_partbal->AMOUNT+$data['cash'];
                                            $query="UPDATE partners_balance SET AMOUNT='".$cashTot."' WHERE PARTNER_ID='{$userid}'";		
                                            $this->db->query($query);
                                            $query = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`)VALUES ('$userid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot')");
                                            $query1 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','$calc', '$comment')");
                                            $query2 = $this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$patid', '$transactionTypeId', '$internalRefNo', '$pname', NOW(), '$transactionAmount','Add', '$comment')");
                                           #Update main partner balance
                                            $querymbal=$this->db->query("UPDATE partners_balance SET AMOUNT=$mainpartbal WHERE PARTNER_ID='{$row['FK_PARTNER_ID']}'");
                                           #Current balance
                                            
                                            $newcurbal=$row_partbal->AMOUNT;
                                            
                                            $newclosebal=$mainpartbal;    
                                            
                                            $querymbaldet = $this->db->query("INSERT INTO `partners_transaction_details` (`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,TRANSACTION_STATUS_ID,`AMOUNT` ,CREATED_TIMESTAMP,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`SUB_PARTNER_ID`)VALUES ('$patid','$transactionTypeId','$transactionStatusId','$transactionAmount', NOW(), '$internalRefNo','$newcurbal', '$newclosebal','{$userid}')");
								$error="";
								return $error;
                                }else{
                                 $error="Withdraw amount exceeds partner's available balance";
								 return $error;
                                 exit; 
                                }
                          }
                     } 
		}
		$error="";
		return $error;
		exit;
	}else{
            $PARTNER_USERNAME=$data['PARTNER_USERNAME'];
            $p_count  = "select PARTNER_ID from partner where PARTNER_USERNAME='$PARTNER_USERNAME' and PARTNER_ID!='{$data['id']}'";
            
            $p_result = $this->db2->query($p_count);
            $pnum=$p_result->num_rows();
            if($pnum==0){
		$userid=$data['id'];
		//$p_username=$data['p_username'];
		$PARTNER_NAME=$data['PARTNER_USERNAME'];
		$PARTNER_REVENUE_SHARE=$data['PARTNER_REVENUE_SHARE'];
                $PARTNER_COMMISSION_TYPE=$data['PARTNER_COMMISSION_TYPE'];
                $PARTNER_PASSWORD=md5($data['PARTNER_PASSWORD']);
                $PARTNER_TRANSACTION_PASSWORD=md5($data['PARTNER_TRANSACTION_PASSWORD']);
                if($data['PARTNER_PASSWORD']!='1234567890' && $data['PARTNER_TRANSACTION_PASSWORD']!='1234567890'){
                    $query="UPDATE partner SET 
                                   PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                                   PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."',
                                   PARTNER_PASSWORD='".$PARTNER_PASSWORD."',
                                   PARTNER_TRANSACTION_PASSWORD='".$PARTNER_TRANSACTION_PASSWORD."'
                             WHERE PARTNER_ID='{$userid}'";		
                    $this->db->query($query);
                }elseif($data['PARTNER_PASSWORD']!='1234567890'){
                     $query="UPDATE partner SET 
                               PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                               PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."',
                               PARTNER_PASSWORD='".$PARTNER_PASSWORD."'
		 	 WHERE PARTNER_ID='{$userid}'";		
                     $this->db->query($query);
                }elseif($data['PARTNER_TRANSACTION_PASSWORD']!='1234567890'){
                    $query="UPDATE partner SET 
                                   PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                                   PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."',
                                   PARTNER_TRANSACTION_PASSWORD='".$PARTNER_TRANSACTION_PASSWORD."'
                             WHERE PARTNER_ID='{$userid}'";		
                    $this->db->query($query);
                }else{
                    $query="UPDATE partner SET 
                                   PARTNER_REVENUE_SHARE='".$PARTNER_REVENUE_SHARE."',
                                   PARTNER_COMMISSION_TYPE='".$PARTNER_COMMISSION_TYPE."'
                             WHERE PARTNER_ID='{$userid}'";		
                    $this->db->query($query);
                }
               if(isset($this->session->userdata['ADMIN_USER_ID'])){
               $createby=ucfirst($this->session->userdata['USERNAME']);
               }else{
               $createby=$this->session->userdata['partnerusername'];
	       }
			   
               $crdate=date("Y-m-d");
               $querydel="delete from group_mp_main_menu_info where GROUP_ID='{$row_groupid['GROUP_ID']}'";
               $resultsdel=$this->db->query($querydel);
               $querydel1="delete from group_mp_sub_menu_info where GROUP_ID='{$row_groupid['GROUP_ID']}'";
               $resultsdel1=$this->db->query($querydel1);
               $querydel2="delete from group_mp_sub_menu_option_info where GROUP_ID='{$row_groupid['GROUP_ID']}'";
               $resultsdel2=$this->db->query($querydel2);
               
               
               $mdl_id=$data['mdl_id'];
               $mnu_id_pk=$data['mnu_id_pk'];
               $sub_mnu_id_pk=$data['sub_mnu_id_pk'];
               print_r($sub_mnu_id_pk);
               //print_r($mdl_id);
               for($i=0; $i<count($mdl_id);$i++)
               {
                        $mmi = $mdl_id[$i];
                        echo $op_query="insert into group_mp_main_menu_info(PARTNER_ID,GROUP_ID,MAIN_MENU_ID,CREATE_BY,CREATE_DATE) values('".$userid."','".$row_groupid['GROUP_ID']."','$mmi','$createby',NOW())";
                        $op_result=$this->db->query($op_query);
               }

               for($j=0; $j<count($mnu_id_pk);$j++)
               {
                        $smi = $mnu_id_pk[$j];
                        $op_query1="insert into group_mp_sub_menu_info(PARTNER_ID,GROUP_ID,SUB_MENU_ID,CREATE_BY,CREATE_DATE) values('".$userid."','".$row_groupid['GROUP_ID']."','$smi','$createby',NOW())";
                        $op_result1=$this->db->query($op_query1);
               }

               for($k=0; $k<count($sub_mnu_id_pk);$k++) 
               {
                        $smoi = $sub_mnu_id_pk[$k];
                        $op_query2="insert into group_mp_sub_menu_option_info(PARTNER_ID,GROUP_ID,SUB_MENU_OP_ID,CREATE_BY,CREATE_DATE) values('".$userid."','".$row_groupid['GROUP_ID']."','$smoi','$createby',NOW())";
                        $op_result2=$this->db->query($op_query2);
               }
                
			$error="";
			return $error;
            }else{
			$error="Username Already Exists";
			return $error;
			exit;
            } 
 	}


}

	public function changepassword(){
        $this->load->database();
        $OLDPASSWORD = md5($this->security->xss_clean($this->input->post('OLDPASSWORD')));
        $NEWPASSWORD = md5($this->security->xss_clean($this->input->post('NEWPASSWORD')));
        
        #Check partnerid
        if($OLDPASSWORD){
            #check old password
		         $sql_oldpass=$this->db2->query("select PARTNER_ID from partner where PARTNER_PASSWORD='".$OLDPASSWORD."' and PARTNER_ID='".$this->session->userdata('partnerid')."'");
            if($sql_oldpass->num_rows>0){
                if($NEWPASSWORD){
                    $updatepass=$this->db->query("update partner set PARTNER_PASSWORD='".$NEWPASSWORD."' where PARTNER_ID='".$this->session->userdata('partnerid')."'");
                    $err=1;
                }
            }else{
                $err=2;
            }
        }
        return $err;
    }
    
    public function changetransactionpassword(){
        $this->load->database();
        $TRANSACTION_OLDPASSWORD = md5($this->security->xss_clean($this->input->get_post('TRANS_OLDPASSWORD',TRUE)));
        $TRANSACTION_NEWPASSWORD = md5($this->security->xss_clean($this->input->get_post('TRANS_NEWPASSWORD',TRUE)));
        
        #Check partnerid
        if($TRANSACTION_OLDPASSWORD){
           // echo "select PARTNER_ID from partner where PARTNER_TRANSACTION_PASSWORD='".md5($TRANSACTION_OLDPASSWORD)."'";
            $sql_toldpass=$this->db2->query("select PARTNER_ID from partner where PARTNER_TRANSACTION_PASSWORD='".$TRANSACTION_OLDPASSWORD."' and PARTNER_ID='".$this->session->userdata('partnerid')."'");
            if($sql_toldpass->num_rows>0){
                if($TRANSACTION_NEWPASSWORD){
                    $updatepass=$this->db->query("update partner set PARTNER_TRANSACTION_PASSWORD='".$TRANSACTION_NEWPASSWORD."' where PARTNER_ID='".$this->session->userdata('partnerid')."'");
                    $err=3;
                }
            }else{
                $err=4;
            }
        }
        
        return $err;

  
  }
  
  #To get partner types
  public function partnertype($pid){
 
        $sqlres=$this->db2->query("SELECT * FROM partners_type WHERE PARTNER_TYPE_ID > ".$pid."");
        
	if(is_array($sqlres->result()) && count($sqlres->result())>0){
            foreach($sqlres->result() as $rowpartnertype){
               $partnertype[]=array($rowpartnertype->PARTNER_TYPE_ID=>$rowpartnertype->PARTNER_TYPE); 
            }
	}
	
	
        return $partnertype;
  }
  
  #To get all partner ids for a given id and type
  public function partnerlist($ptid,$pid){
      
      $pids=$this->getAllPartnerids($pid);
      
      if($pid==1){
          if($ptid!='0'){
              $sqlpart=$this->db2->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_TYPE_ID=".$ptid." order by PARTNER_USERNAME");
          }
      }else{
          $sqlpart=$this->db2->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_TYPE_ID=".$ptid." and FK_PARTNER_ID in(".$pids.") order by PARTNER_USERNAME");
      }
      
      //$this->db->save_queries = true;
     // echo $this->db->last_query($sqlpart);
      
      
      
      if(is_array($sqlpart->result()) && count($sqlpart->result())>0){
          $partnerlist='<span class="TextFieldHdr">Partner:</span><br/><select name="subagentsid" id="subagentsid" class="ListMenu">';
          foreach($sqlpart->result() as $rowpart){
              
              $partnerlist=$partnerlist.'<option value="'.$rowpart->PARTNER_ID.'">'.$rowpart->PARTNER_USERNAME.'</option>';
              
          }
          $partnerlist=$partnerlist.'</select>';
      }
      
      
      
      return $partnerlist;  
  }
  
  
  public function getAgentNameById($partnerid){
		$res=$this->db2->query("Select PARTNER_NAME from partner where PARTNER_ID = $partnerid");
        $partnerInfo  =  $res->row();
		return $partnerInfo->PARTNER_NAME;
  }
  
  public function getDistributorIdByAgentId($agentid){
  		$res=$this->db2->query("Select FK_PARTNER_ID from partner where PARTNER_ID = $agentid");
        $partnerInfo  =  $res->row();
		return $partnerInfo->FK_PARTNER_ID;
		
  }
  
  public function getPartnerIdByCondition($where=''){
		$res=$this->db2->query("select PARTNER_ID from partner $where");
        $partnerInfo  =  $res->row();
		return $partnerInfo->PARTNER_ID;
  }
  
  public function getDistributorNameById($disId){
        $neededid  = substr($disId,-2);
  		
		$res=$this->db2->query("Select PARTNER_NAME from partner where PARTNER_ID = $neededid");
        $partnerInfo  =  $res->row();
		return $partnerInfo->PARTNER_NAME;
  }
  
  public function getPartnerBalance($partnerid){
 
  		$res=$this->db2->query("SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID = '$partnerid'");
        $partnerInfo  =  $res->row();
		return $partnerInfo->AMOUNT;
  }
  
 
	public function getAllPartnerIdByParentId($mainAgentId){
		$partnerIds='';
		$res=$this->db2->query("Select PARTNER_ID from partner where FK_PARTNER_ID = '$mainAgentId'");
        $partnerInfo  =  $res->result();	
		
		foreach($partnerInfo as $partner){
			$partnerIds .= $partner->PARTNER_ID.',';
		}
		return trim($partnerIds,",");
	}
  
   public function getAllPatrnerInfos($mainAgentId){
  		$res=$this->db2->query("Select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID = '$mainAgentId'");
        $partnerInfo  =  $res->result();	
		
		return  $partnerInfo;
	}
  
  
	public function getAllPartnerIdByParentIds($ids){
      	$partnerIds='';
		$res=$this->db2->query("Select PARTNER_ID from partner where FK_PARTNER_ID IN ($ids)");
		$partnerInfo  =  $res->result();
		foreach($partnerInfo as $partner){
			$partnerIds .= $partner->PARTNER_ID.',';
		}
			return trim($partnerIds,",");
	}
  
  	public function getPartnerIdByName($username){
		$query  = $this->db2->query("select PARTNER_ID from partner where PARTNER_USERNAME= '$username'");  
		$result = $query->row();
		return $result->PARTNER_ID;
	}

  	public function getPartnerNameById($id){
		$query  = $this->db2->query("select PARTNER_NAME from partner where PARTNER_ID= '$id'");  
		$result = $query->row();
	
		return $result->PARTNER_NAME;
	}

        public  function getPartnerNameByChildIds($pid){
            	$query  = $this->db2->query("select PARTNER_ID,PARTNER_NAME from partner where PARTNER_ID IN ($pid)");  
		$partnerInfo = $query->result();
                /*foreach($partnerInfo as $partner){
                   $partnerName .=','.$partner->PARTNER_NAME; 
                }*/
		//return $result->PARTNER_NAME;
                return $partnerInfo;
        }


  function getParentId($partnerid){
     $res=$this->db2->query("Select FK_PARTNER_ID from partner where PARTNER_ID = '$partnerid'");
     $partnerInfo  =  $res->result();	
	 return $partnerInfo[0]->FK_PARTNER_ID;
	 
  }
  
  function getParterFKType($fk_id){
  	 $partnertypeid=$this->db2->query("select FK_PARTNER_TYPE_ID from partner where PARTNER_ID='".$fk_id."'");
     $prow= $partnertypeid->row();
	 return $prow->FK_PARTNER_TYPE_ID;
 }



	function getAllChildIds_kiosk(){
	    //echo "<pre>"; print_r($this->session->userdata); die;
	    $parent_type = $this->session->userdata['partnertypeid'];
	    $parent_id   = $this->session->userdata['partnerid'];
	   
		if($parent_type == 0){ // admin
		   //get all the main agents id of this parent
		   $mainagent  = $this->Agent_model->getAllPartnerIdByParentId($parent_id);
		   //get all the distributors id of this main agents
		  if($mainagent != ''){
		    $superdis  = $this->Agent_model->getAllPartnerIdByParentIds($mainagent);
		   if($superdis!="") {
			   //get all the distributors
			   $dis  = $this->Agent_model->getAllPartnerIdByParentIds($superdis);
		   }
		   //get all the agents id of this main agent
		   if($dis != ''){
		     $agent  = $this->Agent_model->getAllPartnerIdByParentIds($dis);
		     //get all the sub agents id of this agents
	   	     if($agent != ''){
			 	$sub  = $this->Agent_model->getAllPartnerIdByParentIds($agent);
			 }else{
			 	$sub = '';  
			 }
		    }else{
			   $agent =''; $sub = ''; 
			}
          }else{
		     $dis = ''; $agent =''; $sub = '';
		  }
		  
		   $partnerids  = $parent_id.','.$mainagent.','.$superdis.','.$dis.','.$agent.','.$sub;
		}else if($parent_type == 11){ //main agent
		   //get all the super distributors
		   $superdis  = $this->Agent_model->getAllPartnerIdByParentId($parent_id);
		   if($superdis!="") {
			   //get all the distributors
			   $dis  = $this->Agent_model->getAllPartnerIdByParentIds($superdis);
		   }
		   //get all the agent ids
		   if($dis != ''){
		   	$agent  = $this->Agent_model->getAllPartnerIdByParentIds($dis);
		  	if($agent != ''){
				$sub  = $this->Agent_model->getAllPartnerIdByParentIds($agent);
			 }else{
			    $sub = '';
			 }
		    }else{
		     $agent =''; $sub = '';  
		   }
		   
		  $partnerids  = $parent_id.','.$superdis.','.$dis.','.$agent.','.$sub;
		 
		}else if($parent_type == 15){ //main agent
		   //get all the distributors
		   $dis  = $this->Agent_model->getAllPartnerIdByParentId($parent_id);
		   //get all the agent ids
		   if($dis != ''){
		   	$agent  = $this->Agent_model->getAllPartnerIdByParentIds($dis);
		  	if($agent != ''){
				$sub  = $this->Agent_model->getAllPartnerIdByParentIds($agent);
			 }else{
			    $sub = '';
			 }
		    }else{
		     $agent =''; $sub = '';  
		   }
		   
		   $partnerids  = $parent_id.','.$dis.','.$agent.','.$sub;
		 
		}else if($parent_type == 12){ // distributor
		    //get all the agent ids
			$agent  = $this->Agent_model->getAllPartnerIdByParentId($parent_id);
			if($agent != ''){
				$sub  = $this->Agent_model->getAllPartnerIdByParentIds($agent);
			}else{
				$sub = '';
			}
		   
		    $partnerids  = $parent_id.','.$agent.','.$sub;
			
		}else if($parent_type == 13){ // agent
			$sub  = $this->Agent_model->getAllPartnerIdByParentId($parent_id);
			
		    $partnerids  = $parent_id.','.$sub;
		}else if($parent_type == 14){ // sub agent
			$partnerids  = $parent_id;
		}
            
		return trim($partnerids,",");
		
		
	}
	
	public function getAllChildIds(){
	  	
		$partner_id = $this->session->userdata('partnerid');
		$partner_type  = $this->session->userdata('partnertypeid'); 
		
		switch ($partner_type){
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
	
	

  	public function getAllPartnerids($pid){
        $res=$this->db2->query("Select PARTNER_ID from partner where FK_PARTNER_ID = '$pid'");
        $partnerInfo  =  $res->result();	
	
		foreach($partnerInfo as $partner){
			if($partnerIds){
				$partnerIds .= $partner->PARTNER_ID.',';
			}else{
				$partnerIds .=$partner->PARTNER_ID;    
			}
			if($partner->PARTNER_ID){
				$res1=$this->db2->query("Select PARTNER_ID from partner where FK_PARTNER_ID = '$partner->PARTNER_ID'");
				$partnerInfo1=$res1->result();	
				
				foreach($partnerInfo1 as $partner1){
					if($partner1->PARTNER_ID!=''){
						$partnerIds .= $partner1->PARTNER_ID.',';
					}
				}
			}
		}
		return trim($partnerIds.",".$pid,",");        
  	}
  
  	function getAllUsersByPartners($partnersId){
		$querycnt=$this->db2->query("select USER_ID from user where PARTNER_ID IN($partnersId)");  
		$rowcnt=$querycnt->result();
		foreach($rowcnt as $userid){
			$userids .= $userid->USER_ID.',';
		}
		return trim($userids,",");
	}
        
 	function getAllUsersNamesByPartners($partnersId){
		$querycnt=$this->db2->query("select USERNAME from user where PARTNER_ID IN($partnersId)");  
		$rowcnt=$querycnt->result();
		foreach($rowcnt as $userid){
			$userids .= ','.$userid->USERNAME;
		}
		
		return trim($userids,",");
	}		
		
		
	#Get agents partner type
  	public function getPartnertype($pid){
		$sql_res=$this->db2->query("select PARTNER_TYPE_DESC from partners_type pt,partner p where p.FK_PARTNER_TYPE_ID=pt.PARTNER_TYPE_ID and p.PARTNER_ID=".$pid."");
		$partnertype  =  $sql_res->row();
		return $partnertype->PARTNER_TYPE_DESC;
  	}
  
	public function getRevenueShareByPartnerId($partnerid){
		$res=$this->db2->query("Select PARTNER_REVENUE_SHARE from partner where PARTNER_ID = $partnerid");
		$partnerInfo  =  $res->row();
		return $partnerInfo->PARTNER_REVENUE_SHARE;
  	}
  
	/* POKER FUNCTIONS START HERE */
	public function getCoinTypes() {
		$browseSQL = $this->db2->query("SELECT * FROM coin_type WHERE STATUS=1 ORDER BY COIN_TYPE_ID ASC");	
		$rsResult  = $browseSQL->result();
		return $rsResult;
	}
	
	public function getBonusValue($coinTypeID,$bonusTypeID) {
		$browseSQL = $this->db2->query("SELECT VALUE FROM bonus_settings WHERE BONUS_TYPE_ID='".$bonusTypeID."' AND COIN_TYPE_ID='".$coinTypeID."'");	
		$rsResult  = $browseSQL->row();
		return $rsResult;		
	}
	/* POKER FUNCTIONS END HERE*/

}
?>