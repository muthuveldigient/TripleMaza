<?php
//error_reporting(E_ALL);
/*
  Class Name	: Account_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class Account_Model extends CI_Model
{
   public function getUsersReport($data){
		if(isset($this->session->userdata['ADMIN_USER_ID'])){
				$partnerids	=	$this->get_parnerlist_mag($data['id'])!=''?$this->get_parnerlist_mag($data['id']):0;
				$totalcnt 	= 	$this->db2->query("select count(USER_ID) as totalonline from user where PARTNER_ID IN(".$partnerids.")")->row()->totalonline; //Total
				$activecnt 	= 	$this->db2->query("select count(USER_ID) as totalactive from user where ACCOUNT_STATUS='1' and PARTNER_ID IN(".$partnerids.")")->row()->totalactive; //Active user
				$inactivecnt=	$this->db2->query("select count(USER_ID) as totalinactive from user where ACCOUNT_STATUS='0' and PARTNER_ID IN(".$partnerids.")")->row()->totalinactive; //Inactive user
		}else{
				$totalcnt 	= 	$this->db2->query("select count(USER_ID) as totalonline from user where PARTNER_ID='".$data['id']."'")->row()->totalonline; //Total User
				$activecnt 	= 	$this->db2->query("select count(USER_ID) as totalactive from user where ACCOUNT_STATUS='1' and PARTNER_ID='".$data['id']."'")->row()->totalactive; //Active user
				$inactivecnt=	$this->db2->query("select count(USER_ID) as totalinactive from user where ACCOUNT_STATUS='0' and PARTNER_ID='".$data['id']."'")->row()->totalinactive; //Inactive user
		}

		$Array['totalcnt']	= 	$totalcnt;
		$Array['activecnt']	=	$activecnt;
		$Array['inactivecnt']=	$inactivecnt;
		return $Array;
	}

	public function getTotalRecords($data){
		$con='';
			if($data['typ'] == "a" )
			{
				if ((isset($data['userName']) && $data['userName']!='') or (isset($data['country']) && $data['country']!='') or (isset($data['gender']) && $data['gender']!='') or (isset($data['emailAdd']) && $data['emailAdd']!='')) {
					$con = " AND ACCOUNT_STATUS='1'";
				} else {
					$con = " WHERE ACCOUNT_STATUS='1' ";
				}
			}
			elseif($data['typ'] == "ia")
			{
				if ((isset($data['userName']) && $data['userName']!='') or (isset($data['country']) && $data['country']!='') or (isset($data['gender']) && $data['gender']!='') or (isset($data['emailAdd']) && $data['emailAdd']!='')) {
					$con = " AND ACCOUNT_STATUS='0'";
				} else {
					$con = " WHERE ACCOUNT_STATUS='0' ";
				}
			}
		if(isset($this->session->userdata['ADMIN_USER_ID'])){
		$partnerids=$this->get_parnerlist_mag($data['id'])!=''?$this->get_parnerlist_mag($data['id']):0;
		if($con){
		$querycnt="select count(*) as cnt from user $con and PARTNER_ID IN(".$partnerids.")";
		}else{
		$querycnt="select count(*) as cnt from user where PARTNER_ID IN(".$partnerids.") ";
		}
		}else{
		if($con){
		$querycnt="select count(*) as cnt from user $con and PARTNER_ID='".$data['id']."' ";
		}else{
		$querycnt="select count(*) as cnt from user where PARTNER_ID='".$data['id']."' ";
		}
		}
		//echo $querycnt;
		$resultscnt=$this->db2->query($querycnt);
		$rowcnt=$resultscnt->row()->cnt;
		return $rowcnt;
	}

	public function getListUsers($limit,$page,$data){
		$con='';
			if($data['typ'] == "a" )
			{
				if ((isset($data['userName']) && $data['userName']!='') or (isset($data['country']) && $data['country']!='') or (isset($data['gender']) && $data['gender']!='') or (isset($data['emailAdd']) && $data['emailAdd']!='')) {
					$con = " AND ACCOUNT_STATUS='1'";
				} else {
					$con = " WHERE ACCOUNT_STATUS='1' ";
				}
			}
			elseif($data['typ'] == "ia")
			{
				if ((isset($data['userName']) && $data['userName']!='') or (isset($data['country']) && $data['country']!='') or (isset($data['gender']) && $data['gender']!='') or (isset($data['emailAdd']) && $data['emailAdd']!='')) {
					$con = " AND ACCOUNT_STATUS='0'";
				} else {
					$con = " WHERE ACCOUNT_STATUS='0' ";
				}
			}
		if(isset($this->session->userdata['ADMIN_USER_ID'])){
		$partnerids=$this->get_parnerlist_mag($data['id'])!=''?$this->get_parnerlist_mag($data['id']):0;
		if($con){
		$querycnt="select count(*) as cnt from user $con and PARTNER_ID IN(".$partnerids.") ";
		}else{
		$querycnt="select count(*) as cnt from user where PARTNER_ID IN(".$partnerids.") ";
		}
		if($con){
		$query="select * from user $con and PARTNER_ID IN(".$partnerids.") order by USER_ID ASC LIMIT $page,$limit";
		}else{
		$query="select * from user where PARTNER_ID IN (".$partnerids.") order by USER_ID ASC LIMIT $page,$limit";
		}
		}
		else{
		if($con){
		$querycnt="select count(*) as cnt from user $con and PARTNER_ID='".$data['id']."' ";
		}else{
		$querycnt="select count(*) as cnt from user where PARTNER_ID='".$data['id']."' ";
		}
		if($con){
		$query="select * from user $con and PARTNER_ID='".$data['id']."' order by USER_ID ASC LIMIT $page,$limit";
		}else{
		$query="select * from user where PARTNER_ID='".$data['id']."' order by USER_ID ASC LIMIT $page,$limit";
		}
		}
		$sqlresults = $this->db2->query($query);
		$resultscnt=$this->db2->query($querycnt);
		$rowcnt=$resultscnt->row();
		if($rowcnt->cnt>0)
			{

				if(is_array($sqlresults->result()) && count($sqlresults->result())>0){
				foreach($sqlresults->result() as $key=>$rows){
				$row[$key]=$rows;
				}

				foreach($row as $key1=>$value){
					if (is_object($value))
					{
						foreach($value as $key=>$val){
						$userarray[$key1][$key]=$value->$key;
						}
					}
				}
				}
			$i=$data['page']+1;

			foreach($userarray as $row)
			{
				@extract($row);
				#Userbalance
				$sql_bal=$this->db2->query("select USER_TOT_BALANCE from user_points where USER_ID='".$USER_ID."'");
				$row_bal=$sql_bal->row();
			if(isset($this->session->userdata['ADMIN_USER_ID'])){
				$resvalue['USERNAME'] = "<a href='".base_url()."cpanel_home/?p=vusrd&userName=".$USERNAME."&id=".base64_encode($USER_ID)."&parid=".base64_encode($PARTNER_ID)."&chk=".$data['chk']."'><b>".$USERNAME."</b></a>";
			}
			else{
				$resvalue['USERNAME'] = "<a href='".base_url()."admin_home/?p=vusrd&userName=".$USERNAME."&id=".base64_encode($USER_ID)."&parid=".base64_encode($PARTNER_ID)."&chk=".$data['chk']."'><b>".$USERNAME."</b></a>";
				}

				$sql_partneruser=$this->db2->query("select PARTNER_USERNAME,FK_PARTNER_ID from partner where PARTNER_ID='".$PARTNER_ID."'");
				$row_partneruser=$sql_partneruser->row();
				$resvalue['PARTNER_USERNAME'] = $row_partneruser->PARTNER_USERNAME;

				if($row_partneruser->FK_PARTNER_ID){
					$sql_distuser=$this->db2->query("select PARTNER_USERNAME from partner where PARTNER_ID='".$row_partneruser->FK_PARTNER_ID."'");
					$row_distuser=$sql_distuser->row();
				}
				$resvalue['PARTNER_USERNAME1'] = $row_distuser->PARTNER_USERNAME;

				if($REGISTRATION_TIMESTAMP){
				$ndate=explode(" ",$REGISTRATION_TIMESTAMP);
				$resvalue['REG_DATE'] =  date("d-m-Y",strtotime($ndate[0]))." ".$ndate[1];
				}

				$resvalue['STATUS'] = "<span id='def".$USER_ID."' style='display:block; text-align:center'>";
				if(isset($this->session->userdata['MAIN_AGENT_IDS'])){

				if($ACCOUNT_STATUS == "1")
				{
					$resvalue['STATUS'] .= "<a href=\"javascript:alert('You Not Have permission');\" title='Acive'><img src='".base_url()."static/images/active.gif' alt='Acive' border='0' /></a>";
				}
				else if($ACCOUNT_STATUS == "2" || $ACCOUNT_STATUS == "0")
				{
					$resvalue['STATUS'] .= '<a href="javascript:alert(\'You Not Have permission\');" title=\'Deactive\'><img src=\''.base_url().'static/images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
				}

				}
				else{
				if($ACCOUNT_STATUS == "1")
				{
					$resvalue['STATUS'] .= "<a href=javascript:openDESCRIPTION_Div(".$USER_ID."); title='Acive'><img src='".base_url()."static/images/active.gif' alt='Acive' border='0' /></a>";
				}
				else if($ACCOUNT_STATUS == "2" || $ACCOUNT_STATUS == "0")
				{
					$resvalue['STATUS'] .= '<a href="javascript:authenticate(\'act'.$USER_ID.'\', \''.$USER_ID.'\', \'status\', \'act\');" title=\'Deactive\'><img src=\''.base_url().'static/images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
				}
				}
				$resvalue['STATUS'] .= "</span>";

				$resvalue['STATUS'] .= "<span id='dact".$USER_ID."' style='display:none; text-align:center'></span>";
				$resvalue['STATUS'] .= "<span id='act".$USER_ID."' style='display:none; text-align:center'></span>";
				$resvalue['SNO'] = $i++;
				$arrs[] = $resvalue;
			}
		}
		else{
		$arrs[]='';
		}
		return $arrs;
	}

   /*
    Function Name: addUser
	Purpose: Add Users
	Affected Tables: user,user_points,master_transaction_history,adjustment_transaction,partners_transaction_details,partner_adjustment_transaction,partners_balance
    Special Case: Using CI Transaction (similar PDO)
    Date: Sep03, 2013
	Author: Azeem
   */
   public function addUser($formdata,$sessionData){
		//Prepare insert data
		$username			= addslashes(trim($formdata['USERNAME']));
        $email  			= addslashes(trim($formdata['EMAIL']));
		$password  			= addslashes(trim($formdata['PASSWORD']));
        $default_points 	= addslashes(trim($formdata['DEFAULT_POINTS']));
		$main_agent     	= addslashes(trim($formdata['MAIN_AGENT']));
		$distributor    	= addslashes(trim($formdata['DISTRIBUTOR']));
		$agents        		= addslashes(trim($formdata['AGENT']));
		$subagents     	 	= addslashes(trim($formdata['SUB_AGENT']));
		$createdby      	= $sessionData['partnerusername'];

		$firstname      	= $formdata['FIRST_NAME'];
		$lastname      		= $formdata['LAST_NAME'];
		$contact      		= $formdata['CONTACT'];
		$country      		= $formdata['PARTNER_COUNTRY'];
		$state      		= $formdata['PARTNER_STATE'];
		$city      			= $formdata['PARTNER_CITY'];
		$street      		= $formdata['PARTNER_STREET'];
		$address      		= $formdata['ADDRESS'];
		$zipcode      		= $formdata['ZIPCODE'];
		$gender      		= $formdata['GENDER'];
		$dob				= $formdata['DOB'];

		if(isset($subagents) && $subagents != ''){
		   $partner_id = $subagents;
		}else if(isset($agents) && $agents != ''){
			$partner_id = $agents;
		}else if(isset($distributor) && $distributor != ''){
			$partner_id = $distributor;
		}else if(isset($main_agent) && $main_agent != ''){
			$partner_id = $main_agent;
		}

	   $appType = $this->config->item('system_type');

		$country 	= addslashes(trim($formdata['PARTNER_COUNTRY']));
		$state		= addslashes(trim($formdata['PARTNER_STATE']));
		$city		= addslashes(trim($formdata['PARTNER_CITY']));
		$register       = date("Y-m-d H:m:i");

		if($partner_id == ''){
		   if($sessionData['partnertypeid'] != 0){
		   		$partner_id = $sessionData['partnerid'];
		   }else{
		   $partner_id = $sessionData['partnerid'];
		   }
    	}

		$pnum = $this->usernameAlreadyExist($username);
        if($email){
			$num = $this->emailAlreadyExist($email);
        }else{
        	$num = '0';
        }

		if($default_points!=''){
        	$cashcheck="/^[0-9]*$/";
        	if(!preg_match($cashcheck,$default_points)){
            	redirect('user/account/register?err=6');
        	}
        }
		//validation before do action
		if($username != '' && $password != '' && $email != '' && $partner_id != ''){
			if($num > 0){ $err = 2; }else{
					if($pnum==0){
						if($appType == 0){
							$partnerBalance = $this->Agent_model->getPartnerBalance($partner_id);
					    }

                        $balanceamount="";
						if($default_points!=''){

						     $balanceamount = $default_points;
							 //$ireference=rand(1000000000,9999999999);
							 $ireference = "111".$user_id.date('dmyhis');
							 //this is similar to PHP:PDO
							 $this->db->trans_begin();
							 //insert into users table
							 $this->db->query("INSERT INTO `user` (`USERNAME` ,`PASSWORD` ,`LEVEL_CONFIG_ID` ,`EMAIL_ID` ,`DATE_OF_BIRTH`,STATE,COUNTRY,CITY,STREET,    REGISTRATION_TIMESTAMP,`MEMBERSHIP_DATE`,LEVEL_POINTS,ACCOUNT_STATUS,PARTNER_ID,CREATED_BY)VALUES ('$username','".addslashes(md5($password))."','2','$email','$dob','$state','$country','$city','',NOW(),NOW(),'1000','1','".$partner_id."','".$createdby."')");
							 //get last insert id
							 $user_id = $this->db->insert_id();
							 //insert into user points table
							 $this->db->query("insert into user_points(COIN_TYPE_ID,USER_ID,VALUE,USER_PROMO_BALANCE,USER_TOT_BALANCE)values('3','".$user_id."','".$default_points."','".$default_points."','".$default_points."')");
							 //insert into master transaction table
							 $this->db->query("insert into master_transaction_history(USER_ID,BALANCE_TYPE_ID,TRANSACTION_STATUS_ID,TRANSACTION_TYPE_ID,TRANSACTION_AMOUNT,TRANSACTION_DATE,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE, CLOSING_TOT_BALANCE,PARTNER_ID )values('".$user_id."','2','107','9','".$default_points."','".date("Y-m-d H:i:s")."','".$ireference."','0','".$default_points."','".$partner_id."')");
							 //for transaction status we use the following params statically
							 $transactionStatusId = "107";
                             $transactionTypeId="21";
                             $balanceTypeId="2";
							 //insert into Transaction adjustment table
							 $this->db->query("INSERT INTO `adjustment_transaction`(`ADJUSTMENT_TRANSACTION_ID`,`USER_ID` ,`TRANSACTION_TYPE_ID` ,   `INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL,'".$user_id."','$transactionTypeId','$ireference','".$sessionData['partnerusername']."',NOW(),'$default_points','Add', '')");
							 //subtract the user balance
							 $newclosebal = $partnerBalance-$default_points;
							 $newcurbal   = $partnerBalance;
							 //insert into Partner transaction details table
							 $this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,           CREATED_TIMESTAMP,USER_ID,PROCESSED_BY)values('".$partner_id."','8','103','".$default_points."','".$ireference."','".$newcurbal."','".$newclosebal."',now(),'".$user_id."','".$sessionData['partnerusername']."')");
							 //insert into Partner Transaction details table again for display purpose
							 $this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT, INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,PROCESSED_BY)values('".$partner_id."','8','103','".$default_points."','".$ireference."','".$newcurbal."','".$newclosebal."',now(),'".$username."')");
							 $pname=$sessionData['partnerusername'];
							 //insert into Partner Adjustment Transaction table for display purpose
							 $this->db->query("INSERT INTO `partner_adjustment_transaction`(`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` , `INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION`,`ADJUSTMENT_PARTNER`)VALUES(NULL,'".$partner_id."','8','$ireference','$username',NOW(),'$balanceamount','Add','".$sessionData['partnerid']."')");
							 //finally insert into partners balance table
							 $this->db->query("update partners_balance set AMOUNT=AMOUNT-'".$default_points."' where PARTNER_ID='".$partner_id."'");
							 if ($this->db->trans_status() === FALSE)
							 {
							 	$err = 11;
							    $this->db->trans_rollback();
							 }else{
							 	$err = 1;
								$this->db->trans_commit();
							 }

						}else{
						  // $ireference="REG_".rand(1000000000,9999999999);
						   //open the mysql transaction functionality
						   $this->db->trans_begin();
						  $this->db->query("INSERT INTO `user` (`USERNAME` ,`PASSWORD` ,`LEVEL_CONFIG_ID` ,".
						  			       "`EMAIL_ID` ,`DATE_OF_BIRTH`,STATE,COUNTRY,REGISTRATION_TIMESTAMP, `MEMBERSHIP_DATE`,LEVEL_POINTS,".
										   "ACCOUNT_STATUS,PARTNER_ID,CREATED_BY,FIRSTNAME,LASTNAME,STREET,GENDER,ADDRESS,ZIPCODE,CONTACT)VALUES ('$username',".
										   "'".addslashes(md5($password))."','2','$email','$dob','$state','$country',NOW(), NOW(),'1000','1',".
										   "'".$partner_id."','".$createdby."','".$firstname."','".$lastname."','".$street."','".$gender."',".
										   "'".$address."','".$zipcode."','".$contact."')");
						   $user_id = $this->db->insert_id();
						   $ireference = "111".$user_id.date('dmyhis');
						   $getCoinTypes = $this->Agent_model->getCoinTypes();
						   $masterTransactionTables = array(1=>"master_transaction_history",2=>"master_transaction_history_playmoney");

						   $promoBalance=""; $totalBalance="";
						   $cTypeID=1;
						   foreach($getCoinTypes as $cTIndex=>$coinTypes) {
								$getBonusValue = $this->Agent_model->getBonusValue($coinTypes->COIN_TYPE_ID,'1');//1=bonus type id for reg
								if(!empty($getBonusValue->VALUE)) {
									$promoBalance = $getBonusValue->VALUE;
								    $totalBalance = $getBonusValue->VALUE;
								}
								$browseSQL = "INSERT INTO user_points(COIN_TYPE_ID,USER_ID,VALUE,USER_PROMO_BALANCE,USER_TOT_BALANCE) VALUES(".
											 "'".$coinTypes->COIN_TYPE_ID."','".$user_id."',".
											 "'".$promoBalance."','".$promoBalance."','".$totalBalance."')";
								$this->db->query($browseSQL);

								/* ADD ENTRY IN THE MASTER TRANSACTION TABLES */
								if(isset($getBonusValue->VALUE) && $getBonusValue->VALUE!="") {
									$tableName = $masterTransactionTables[$cTypeID];
									$this->db->query("INSERT INTO ".$tableName."(USER_ID,BALANCE_TYPE_ID,TRANSACTION_STATUS_ID,".
									"TRANSACTION_TYPE_ID,TRANSACTION_AMOUNT,TRANSACTION_DATE,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE, CLOSING_TOT_BALANCE,".
									"PARTNER_ID )values('".$user_id."','2','107','65','".$totalBalance."','".date("Y-m-d H:i:s")."',".
									"'".$ireference."','0','".$totalBalance."','".$partner_id."')");
								}
								/* ADD ENTRY IN THE MASTER TRANSACTION TABLES */
								$promoBalance=""; $totalBalance="";
								$cTypeID++;
						   }
						   if ($this->db->trans_status() === FALSE)
							 {
							 	$err = 11;
							    $this->db->trans_rollback();
							 }else{
							 	$err = 1;
								$this->db->trans_commit();
							 }
						}
					}else{
						 $err=3;
					}
				}
			}else{
			   $err = 5;
			}
			//redirect the page based on error
			if($err == 1){ redirect('user/account/register?err=1&rid=11'); }
            if($err == 2){ redirect('user/account/register?err=2&rid=11'); }
        	if($err == 3){ redirect('user/account/register?err=3&rid=11'); }
        	if($err == 4){ redirect('user/account/register?err=4&rid=11'); }
        	if($err == 5){ redirect('user/account/register?err=5&rid=11'); }
       		if($err == 11){redirect('user/account/register?err=11&rid=11');}
   }//EO: addUser function



    public function addPoints($formdata,$sessionData){
		//Prepare insert data
		$points=addslashes($formdata['POINTS']);
        $username=addslashes($formdata['TO']);
		$partnername=$sessionData['partnerusername'];
        $pointscheck="/^[0-9.]*$/";
		$allagents = $this->Agent_model->getAllChildIds($this->session->userdata);
		//check point
		if(!preg_match($pointscheck,$points)){
		   redirect('user/account/transfer?err=4');
		 }
		//check user
		$pnum  = $this->Account_model->checkUser($allagents,$username);
		$userInfo  = $this->getAllUserInfoByPartnerIds($allagents,$username);
		$userName  = $userInfo->USERNAME;
		$partnerId = $userInfo->PARTNER_ID;
		$userId    = $userInfo->USER_ID;

		if($points!=''){
      //get user information
      $pnum  = $this->Account_model->checkUser($allagents,$username);
      $partnerUId = $partnerId;
      //get parner balance
      $partnerBalance = $this->Agent_model->getPartnerBalance($partnerUId);
         $balanceamount="";

      if($pnum>0){
           		$balanceamount=$points;
     			$ireference=rand(1000000000,9999999999);
     			$currUsersPoints  = $this->getUserPoints($userId);
     			$newuserpromobal  = $currUsersPoints->USER_PROMO_BALANCE;

                $newuserpromoclosebal= $currUsersPoints->USER_PROMO_BALANCE+$balanceamount;
                $newusertotbal   = $currUsersPoints->USER_TOT_BALANCE;
                $newusertotclosebal  = $currUsersPoints->USER_TOT_BALANCE+$balanceamount;
				$transactionStatusId = "107";
                $transactionTypeId="21";
                $balanceTypeId="2";
     $this->db->trans_begin();
     $cpro = $currUsersPoints->USER_PROMO_BALANCE;
     $cpro = $cpro + $points;
     $cashTot = $currUsersPoints->USER_TOT_BALANCE + $points;
     $currentTotCash = $currUsersPoints->USER_TOT_BALANCE;

     $this->db->query("UPDATE user_points SET VALUE='".$cashTot."',USER_PROMO_BALANCE='".$cpro."', USER_TOT_BALANCE='".$cashTot."' WHERE COIN_TYPE_ID=3 AND USER_ID='$userId'");

     $this->db->query("INSERT INTO `master_transaction_history` (`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`PARTNER_ID`)VALUES ('$userId', '2', '107', '9', '$points', NOW(), '$ireference','$currentTotCash', '$cashTot','1')");
        $this->db->query("INSERT INTO `adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`USER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userId', '21', '$ireference','".$sessionData['partnerusername']."', NOW(), '$points','Add', '')");

     if ($this->db->trans_status() === FALSE)
      {
       $err = 6;
                        $this->db->trans_rollback();
      }else{
       $err = 1;
      $this->db->trans_commit();
      }
     }else{
	    $err=2;
     }
    }else{
   		$err = 5;
    }

    //redirect the page based on error
	if($err == 1){ redirect('user/account/transfer?err=1'); }
	if($err == 2){ redirect('user/account/transfer?err=2'); }
	if($err == 3){ redirect('user/account/transfer?err=3'); }
	if($err == 5){ redirect('user/account/transfer?err=5'); }
	if($err == 6){redirect('user/account/transfer?err=6');}
   }//EO: addUser function


   public function adjustPoints($formdata,$sessiondata){

		$gameId="0";
		$xP="0";
		$goodsKey="0";

		//$internalRefNo=rand(1000000000,9999999999);
		$comment = $formdata['COMMENTS'];
		$calc 	 = $formdata['ADJUST_TYPE'];
		$username = $this->Account_model->getUserIdByName($formdata['USER_ID']);
		$userId	 = $username;
		$cash    = $formdata['CASH'];
		$balanceType = $formdata['BALANCE_TYPE'];
		$internalRefNo="122".$userId.date('dmyhis');
		//fetch user points
		$userPoints  = $this->getUserPoints($userId);
	    $pointscheck="/^[0-9.]*$/";

		  if(!preg_match($pointscheck,$cash)){
		   redirect('user/account/adjust?err=5');
		 }
		if($userId != ''){
		if($cash != 0)
		{
		   if($userPoints->COIN_TYPE_ID == 1)	//CASH
		   {
		      $userInfo  = $this->getUserInfoById($userId);
			  $userName  = $userInfo->USERNAME;
			  $partnerId = $userInfo->PARTNER_ID;
			  $userId    = $userInfo->USER_ID;
			  $partnerUId  = $partnerId;
			  $partnerBalance = $this->Agent_model->getPartnerBalance($partnerUId);
			  $transactionAmount=$cash;
			  $coinTypeId="3";
			  $transactionStatusId = "107";
              $transactionTypeId="21";
			  $newagntbal 	 = $partnerBalance;


					 if($balanceType=="1") //DEPOSIT
					 {

						$utransactionStatusId = "103";
						$utransactionTypeId="22";
						$balanceTypeId="1";
						$cdep = $userPoints->USER_DEPOSIT_BALANCE;
						if($calc == "Add")
						{
							$cdep 	= $cdep + $cash;
							$cashTot= $userPoints->USER_TOT_BALANCE + $cash;
							$newagntclosebal = $partnerBalance-$cash;
							$currentTotCash = $userPoints->USER_TOT_BALANCE;
							$calcSymbol  = '-';
						}
						else
						{
						if($cash > $cdep){
							redirect('user/account/adjust?err=3&rid=13'); exit;
						}
							$cdep 	= $cdep - $cash;
							$cashTot= $userPoints->USER_TOT_BALANCE - $cash;
							$newagntclosebal = $partnerBalance+$cash;
							$currentTotCash = $userPoints->USER_TOT_BALANCE;
							$calcSymbol  = '+';
						}


					$this->db->trans_begin();
				    //do operation in parents table
					/*$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,USER_ID,PROCESSED_BY)values('".$partnerId."','8','103','".$transactionAmount."','".$internalRefNo."','".$newagntbal."','".$newagntclosebal."',now(),'".$userId."','".$sessionData['partnerusername']."')");
					$this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION`,`ADJUSTMENT_PARTNER`)VALUES(NULL,'".$partnerId."','8','$internalRefNo','".$userName."',NOW(),'$transactionAmount','$calc','".$sessionData['partnerid']."')");
					$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,     INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,PROCESSED_BY)values('".$partnerId."','8','103','".$transactionAmount."','".$internalRefNo."','".$newagntbal."','".$newagntclosebal."',now(),'".$sessionData['partnerusername']."')");
					$this->db->query("update partners_balance set AMOUNT=AMOUNT$calcSymbol'".$transactionAmount."' where PARTNER_ID='".$partnerId."'");	*/

				   //do operation in user table

				   $this->db->query("UPDATE user_points SET VALUE='".$cashTot."',USER_DEPOSIT_BALANCE='".$cdep."', USER_TOT_BALANCE='".$cashTot."' WHERE COIN_TYPE_ID=1 AND USER_ID='$userId'");
					$this->db->query("INSERT INTO `master_transaction_history` (`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`PARTNER_ID`)VALUES ('$userId', '$balanceTypeId', '$utransactionStatusId', '$utransactionTypeId', '$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot','$partnerId')");

			    $this->db->query("INSERT INTO `adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`USER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userId', '$utransactionTypeId', '$internalRefNo', 'admin', NOW(), '$transactionAmount','$calc', '$comment')");

					if ($this->db->trans_status() === FALSE)
					{

						$err = 4;
						$this->db->trans_rollback();
					}else{
					    $err = 1;
				  		$this->db->trans_commit();
			    	}

				 }else if($balanceType=="3"){ //WIN
					$utransactionStatusId = "102";
					$utransactionTypeId="23";
					$balanceTypeId="3";

					$cwin = $userPoints->USER_WIN_BALANCE;
					if($calc == "Add")
					{
						$cwin 	= $cwin + $cash;
						$cashTot= $userPoints->USER_TOT_BALANCE + $cash;
						$newagntclosebal = $partnerBalance-$cash;
						$currentTotCash = $userPoints->USER_TOT_BALANCE;
						$calcSymbol  = '-';
					}
					else
					{
						if($cash > $cwin){
							redirect('user/account/adjust?err=3&rid=13'); exit;
						}
						$cwin = $cwin - $cash;
						$cashTot = $userPoints->USER_TOT_BALANCE - $cash;
						$newagntclosebal = $partnerBalance + $cash;
						$currentTotCash  = $userPoints->USER_TOT_BALANCE;
						$calcSymbol  = '+';
					}

					$this->db->trans_begin();
				    //do operation in parents table
					/*$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,USER_ID,PROCESSED_BY)values('".$partnerId."','8','103','".$transactionAmount."','".$internalRefNo."','".$newagntbal."','".$newagntclosebal."',now(),'".$userId."','".$sessionData['partnerusername']."')");
					$this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION`,`ADJUSTMENT_PARTNER`)VALUES(NULL,'".$partnerId."','8','$internalRefNo','".$userName."',NOW(),'$transactionAmount','$calc','".$sessionData['partnerid']."')");
					$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,     INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,PROCESSED_BY)values('".$partnerId."','8','103','".$transactionAmount."','".$internalRefNo."','".$newagntbal."','".$newagntclosebal."',now(),'".$sessionData['partnerusername']."')");
					$this->db->query("update partners_balance set AMOUNT=AMOUNT$calcSymbol'".$transactionAmount."' where PARTNER_ID='".$partnerId."'");	*/

					//do operation for user tables
					$this->db->query("UPDATE user_points SET VALUE='".$cashTot."',USER_WIN_BALANCE='".$cwin."', USER_TOT_BALANCE='".$cashTot."' WHERE COIN_TYPE_ID=1 AND USER_ID='$userId'");

					$this->db->query("INSERT INTO `master_transaction_history` (`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`PARTNER_ID`)VALUES ('$userId', '$balanceTypeId', '$utransactionStatusId', '$utransactionTypeId', '$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot','$partnerId')");

					$this->db->query("INSERT INTO `adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`USER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userId', '$utransactionTypeId', '$internalRefNo', 'admin', NOW(), '$transactionAmount','$calc', '$comment')");
					if ($this->db->trans_status() === FALSE)
					{
				   		$err = 4;
						$this->db->trans_rollback();
					}else{
					    $err = 1;
				  		$this->db->trans_commit();
			    	}
				 }else{ //PROMO
				 	$utransactionStatusId = "107";
					$utransactionTypeId="21";
					$balanceTypeId="2";
					$cpro = $userPoints->USER_PROMO_BALANCE;

					if($calc== "Add")
					{
						$cpro = $cpro + $cash;
						$cashTot = $userPoints->USER_TOT_BALANCE + $cash;
						$newagntclosebal = $partnerBalance-$cash;
						$currentTotCash = $userPoints->USER_TOT_BALANCE;
						$calcSymbol  = '-';
					}else
					{
						if($cash > $cpro){
							redirect('user/account/adjust?err=3&rid=13'); exit;
						}
						$cpro = $cpro - $cash;
						$cashTot = $userPoints->USER_TOT_BALANCE - $cash;
						$newagntclosebal = $partnerBalance+$cash;
						$currentTotCash = $userPoints->USER_TOT_BALANCE;
						$calcSymbol  = '+';

					}


					$this->db->trans_begin();
				    //do operation in parents table
					/*$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,USER_ID,PROCESSED_BY)values('".$partnerId."','8','103','".$transactionAmount."','".$internalRefNo."','".$newagntbal."','".$newagntclosebal."',now(),'".$userId."','".$sessionData['partnerusername']."')");
					$this->db->query("INSERT INTO `partner_adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`PARTNER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION`,`ADJUSTMENT_PARTNER`)VALUES(NULL,'".$partnerId."','8','$internalRefNo','".$userName."',NOW(),'$transactionAmount','$calc','".$sessionData['partnerid']."')");
					$this->db->query("insert into partners_transaction_details(PARTNER_ID,TRANSACTION_TYPE_ID,TRANSACTION_STATUS_ID,AMOUNT,     INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE,CLOSING_TOT_BALANCE,CREATED_TIMESTAMP,PROCESSED_BY)values('".$partnerId."','8','103','".$transactionAmount."','".$internalRefNo."','".$newagntbal."','".$newagntclosebal."',now(),'".$sessionData['partnerusername']."')");
					$this->db->query("update partners_balance set AMOUNT=AMOUNT$calcSymbol'".$transactionAmount."' where PARTNER_ID='".$partnerId."'");	*/

					//do operations for user table
					$this->db->query("UPDATE user_points SET VALUE='".$cashTot."',USER_PROMO_BALANCE='".$cpro."', USER_TOT_BALANCE='".$cashTot."' WHERE COIN_TYPE_ID=1 AND USER_ID='$userId'");



					$this->db->query("INSERT INTO `master_transaction_history` (`USER_ID` ,`BALANCE_TYPE_ID` ,`TRANSACTION_STATUS_ID` ,`TRANSACTION_TYPE_ID` ,`TRANSACTION_AMOUNT` ,`TRANSACTION_DATE` ,`INTERNAL_REFERENCE_NO` ,`CURRENT_TOT_BALANCE` ,`CLOSING_TOT_BALANCE`,`PARTNER_ID`)VALUES ('$userId', '$balanceTypeId', '$utransactionStatusId', '$utransactionTypeId', '$transactionAmount', NOW(), '$internalRefNo','$currentTotCash', '$cashTot','$partnerId')");


				    $this->db->query("INSERT INTO `adjustment_transaction` (`ADJUSTMENT_TRANSACTION_ID` ,`USER_ID` ,`TRANSACTION_TYPE_ID` ,`INTERNAL_REFERENCE_NO` ,`ADJUSTMENT_CREATED_BY` ,`ADJUSTMENT_CREATED_ON` ,`ADJUSTMENT_AMOUNT` ,`ADJUSTMENT_ACTION` ,`ADJUSTMENT_COMMENT`)VALUES (NULL, '$userId', '$utransactionTypeId', '$internalRefNo', 'admin', NOW(), '$transactionAmount','$calc', '$comment')");
					if ($this->db->trans_status() === FALSE)
					{
				   		$err = 4;
						$this->db->trans_rollback();
					}else{
					    $err = 1;
				  		$this->db->trans_commit();
			    	}
				 }

		   }
		}else{
		  $err = 2;
		}
	   }else{
	     $err = 6;
	   }
	//redirection based on error
	if($err == 1){ redirect('user/account/adjust?err=1&rid=13'); }
	if($err == 2){ redirect('user/account/adjust?err=2&rid=13'); }
	if($err == 3){ redirect('user/account/adjust?err=3&rid=13'); }
	if($err == 4){ redirect('user/account/adjust?err=4&rid=13'); }
	if($err == 6){ redirect('user/account/adjust?err=6&rid=13'); }
   }



   public function insertUserPoints($coin_id,$user_id,$bal=0,$promo_bal=0,$tot_bal=0){
	 	$sql_scinsert="insert into user_points(COIN_TYPE_ID,USER_ID,VALUE,USER_PROMO_BALANCE,USER_TOT_BALANCE)values('".$coin_id."','".$user_id."','".$bal."','".$promo_bal."','".$tot_bal."')";
        $this->db->query($sql_scinsert);

	 }

   public function usernameAlreadyExist($USERNAME){
	 	$p_count  = "select * from user where USERNAME='$USERNAME'";
		$p_result = $this->db2->query($p_count);
		return $pnum=$p_result->num_rows();
	 }

	public function emailAlreadyExist($EMAIL){
	 	$p_count  = "select * from user where EMAIL_ID='$EMAIL'";
		$p_result = $this->db2->query($p_count);
		return $pnum=$p_result->num_rows();
	 }


   public function getAllAgentsListByUserId($partid)
   {
		if($partid!=''){
			$sql_agent=$this->db2->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID in(".$partid.")");
			return $sql_agent->result();
		}
	}


	public function getAllSearchPlayesCount($loggedInUsersPartnersId,$searchdata){


		if(!empty($searchdata['username']) || !empty($searchdata['email']) || !empty($searchdata['country']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME']) ||  !empty($searchdata['partner']) || !empty($searchdata['online']) || !empty($searchdata['status']) )
	   {
			$conQuery = "";
			if($searchdata['username']!="")
			{
				$conQuery .= "USERNAME LIKE '%".$searchdata['username']."%' ";
			}

			if($searchdata['email']!="")
			{
				if($searchdata['username'] == ''){
					$conQuery .= " EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}else{
					$conQuery .= " AND EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}
			}

		   if($searchdata['country']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == ''){
					$conQuery .= " COUNTRY LIKE '%".$searchdata['country']."%' ";
				}else{
					$conQuery .= " AND COUNTRY LIKE '%".$searchdata['country']."%' ";
				}
			}

			if($searchdata['partner']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}

			 if($searchdata['online']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == ''){
					$conQuery .= " LOGIN_STATUS = '".$searchdata['online']."' ";
				}else{
					$conQuery .= " AND LOGIN_STATUS = '".$searchdata['online']."' ";
				}
			}
                        if($searchdata['status']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''){
					$conQuery .= " ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}
			}
			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == '' && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == '' && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."' ";
				}else{
					$conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == '' && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }




		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo") {
			$querycnt = $this->db2->query("SELECT p.PAYMENT_TRANSACTION_ID,u.USER_ID,u.USERNAME,u.EMAIL_ID,u.PARTNER_ID,u.LOGIN_STATUS FROM payment_transaction p LEFT JOIN user u ON u.USER_ID=p.USER_ID WHERE DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') >='".$searchdata["START_DATE_TIME"]."' AND DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') <='".$searchdata["END_DATE_TIME"]."' AND (PAYMENT_TRANSACTION_STATUS=103 OR PAYMENT_TRANSACTION_STATUS=125) GROUP BY u.USER_ID");
			//echo $this->db->last_query();
		} else {
			if($conQuery != ""){
			$querycnt=$this->db2->query("select count(*) as cnt from user where $conQuery AND PARTNER_ID IN($loggedInUsersPartnersId)");
			}else{
			  $querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($loggedInUsersPartnersId)");
			}
		}

		}else{

		   $querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($loggedInUsersPartnersId)");
		}
		$rowcnt=$querycnt->result();
		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo")
			$account_property = count($rowcnt);
		else
			$account_property = $rowcnt[0]->cnt;

		return $account_property;
	}


	public function getCountActiveUsers($loggedInUsersPartnersId,$searchdata){


		if(!empty($searchdata['username']) || !empty($searchdata['email']) || !empty($searchdata['country']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME']) ||  !empty($searchdata['partner']) || !empty($searchdata['online']) || !empty($searchdata['status']) )
	   {
			$conQuery = "";
			if($searchdata['username']!="")
			{
				$conQuery .= "USERNAME LIKE '%".$searchdata['username']."%' ";
			}

			if($searchdata['email']!="")
			{
				if($searchdata['username'] == ''){
					$conQuery .= " EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}else{
					$conQuery .= " AND EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}
			}

		   if($searchdata['country']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == ''){
					$conQuery .= " COUNTRY LIKE '%".$searchdata['country']."%' ";
				}else{
					$conQuery .= " AND COUNTRY LIKE '%".$searchdata['country']."%' ";
				}
			}



			if($searchdata['partner']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}
		 if($searchdata['online']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == ''){
					$conQuery .= " LOGIN_STATUS = '".$searchdata['online']."' ";
				}else{
					$conQuery .= " AND LOGIN_STATUS = '".$searchdata['online']."' ";
				}
			}
                        if($searchdata['status']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''){
					$conQuery .= " ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}
			}

			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."' ";
				}else{
					$conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }

		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo") {
			$querycnt = $this->db2->query("SELECT p.PAYMENT_TRANSACTION_ID,u.USERNAME,u.EMAIL_ID,u.PARTNER_ID,u.LOGIN_STATUS FROM payment_transaction p LEFT JOIN user u ON u.USER_ID=p.USER_ID WHERE u.ACCOUNT_STATUS=1 AND DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') >='".$searchdata["START_DATE_TIME"]."' AND DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') <='".$searchdata["END_DATE_TIME"]."' AND PAYMENT_TRANSACTION_STATUS=103 GROUP BY u.USER_ID");
//echo $this->db->last_query();die;
		} else {
				if($conQuery != ""){
				$querycnt=$this->db2->query("select count(*) as cnt from user where $conQuery AND PARTNER_ID IN($loggedInUsersPartnersId) and ACCOUNT_STATUS =1");
				}else{
				  $querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($loggedInUsersPartnersId) and ACCOUNT_STATUS = 1");
				}
		}

		}else{

		   $querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($loggedInUsersPartnersId) and ACCOUNT_STATUS = 1");
		}
		$rowcnt=$querycnt->result();
		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo")
			$account_property = count($rowcnt);
		else
			$account_property = $rowcnt[0]->cnt;

		return $account_property;
	}


		public function getCountInActiveUsers($loggedInUsersPartnersId,$searchdata){


		if(!empty($searchdata['username']) || !empty($searchdata['email']) || !empty($searchdata['country']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME']) ||  !empty($searchdata['partner']) || !empty($searchdata['online']) || !empty($searchdata['status']) )
	   {
			$conQuery = "";
			if($searchdata['username']!="")
			{
				$conQuery .= "USERNAME LIKE '%".$searchdata['username']."%' ";
			}

			if($searchdata['email']!="")
			{
				if($searchdata['username'] == ''){
					$conQuery .= " EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}else{
					$conQuery .= " AND EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}
			}

		   if($searchdata['country']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == ''){
					$conQuery .= " COUNTRY LIKE '%".$searchdata['country']."%' ";
				}else{
					$conQuery .= " AND COUNTRY LIKE '%".$searchdata['country']."%' ";
				}
			}

			 if($searchdata['partner']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}

			 if($searchdata['online']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == ''){
					$conQuery .= " LOGIN_STATUS = '".$searchdata['online']."' ";
				}else{
					$conQuery .= " AND LOGIN_STATUS = '".$searchdata['online']."' ";
				}
			}
                        if($searchdata['status']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''){
					$conQuery .= " ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}
			}

			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."' ";
				}else{
					$conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }

		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo") {
			$querycnt = $this->db2->query("SELECT p.PAYMENT_TRANSACTION_ID,u.USERNAME,u.EMAIL_ID,u.PARTNER_ID,u.LOGIN_STATUS FROM payment_transaction p LEFT JOIN user u ON u.USER_ID=p.USER_ID WHERE u.ACCOUNT_STATUS=0 AND DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') >='".$searchdata["START_DATE_TIME"]."' AND DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') <='".$searchdata["END_DATE_TIME"]."' AND PAYMENT_TRANSACTION_STATUS=103 GROUP BY u.USER_ID");
//echo $this->db->last_query();die;
		} else {
				if($conQuery != ""){
				$querycnt=$this->db2->query("select count(*) as cnt from user where $conQuery AND PARTNER_ID IN($loggedInUsersPartnersId) and ACCOUNT_STATUS =0");
				}else{
				  $querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($loggedInUsersPartnersId) and ACCOUNT_STATUS = 0");
				}
		}

		}else{

		   $querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($loggedInUsersPartnersId) and ACCOUNT_STATUS = 0");
		}

		$rowcnt=$querycnt->result();
		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo")
			$account_property = count($rowcnt);
		else
			$account_property = $rowcnt[0]->cnt;

		return $account_property;
	}

 public function getAllSearchPlayersInfo($loggedInUsersPartnersId,$searchdata,$limit,$start){

	if(!empty($searchdata['username']) || !empty($searchdata['email']) || !empty($searchdata['country']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  || !empty($searchdata['partner']) || !empty($searchdata['online']) || !empty($searchdata['status']) )
	   {
			$conQuery = "";
			if($searchdata['username']!="")
			{
				$conQuery .= "USERNAME LIKE '%".$searchdata['username']."%' ";
			}

			if($searchdata['email']!="")
			{
				if($searchdata['username'] == ''){
					$conQuery .= " EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}else{
					$conQuery .= " AND EMAIL_ID LIKE '%".$searchdata['email']."%' ";
				}
			}

		   if($searchdata['country']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == ''){
					$conQuery .= " COUNTRY LIKE '%".$searchdata['country']."%' ";
				}else{
					$conQuery .= " AND COUNTRY LIKE '%".$searchdata['country']."%' ";
				}
			}

			 if($searchdata['partner']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}

			 if($searchdata['online']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == ''){
					$conQuery .= " LOGIN_STATUS = '".$searchdata['online']."' ";
				}else{
					$conQuery .= " AND LOGIN_STATUS = '".$searchdata['online']."' ";
				}
			}
                        if($searchdata['status']!="")
			{
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''){
					$conQuery .= " ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}else{
					$conQuery .= " AND ACCOUNT_STATUS = '".$searchdata['status']."' ";
				}
			}

			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."' ";
				}else{
					$conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')   <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['username'] == '' && $searchdata['email'] == '' && $searchdata['country'] == '' && $searchdata['partner'] == '' && $searchdata['online'] == ''  && $searchdata['status'] == ''){
				   $conQuery .= " DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}else{
				   $conQuery .= " AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata["START_DATE_TIME"]))."' AND DATE_FORMAT(REGISTRATION_TIMESTAMP,'%Y-%m-%d')  <= '".date('Y-m-d',strtotime($searchdata["END_DATE_TIME"]))."'";
				}
			 }
		$sql = 	$conQuery;
		if(isset($searchdata['USER_REPO_TYPE']) && $searchdata['USER_REPO_TYPE']=="depo") {
			$query = $this->db2->query("SELECT p.PAYMENT_TRANSACTION_ID,u.USER_ID,u.USERNAME,u.EMAIL_ID,u.PARTNER_ID,u.LOGIN_STATUS FROM payment_transaction p LEFT JOIN user u ON u.USER_ID=p.USER_ID WHERE DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') >='".$searchdata["START_DATE_TIME"]."' AND DATE_FORMAT(p.PAYMENT_TRANSACTION_CREATED_ON,'%Y-%m-%d') <='".$searchdata["END_DATE_TIME"]."' AND (PAYMENT_TRANSACTION_STATUS=103 OR PAYMENT_TRANSACTION_STATUS=125) GROUP BY u.USER_ID ORDER BY u.USER_ID ASC LIMIT $start,$limit");
		} else {
			$query = $this->db2->query("SELECT * from user where $sql AND PARTNER_ID IN($loggedInUsersPartnersId) ORDER BY USER_ID ASC LIMIT $start,$limit");
		}

		}else{
		  $query = $this->db2->query("SELECT * from user where PARTNER_ID IN($loggedInUsersPartnersId) ORDER BY USER_ID ASC LIMIT $start,$limit");

		}
		$fetchResults  = $query->result();
		return $fetchResults;


	}

	public function getAllPlayersCount($loggedInUsersPartnersId){

	   $allchildpartnerids = $this->Agent_model->getAllPartnerids($loggedInUsersPartnersId);

		$querycnt=$this->db2->query("select count(*) as cnt from user where PARTNER_ID IN($allchildpartnerids)");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
	}

	public function getAllPlayersInfo($loggedInUsersPartnersId,$limit,$start){

//echo $loggedInUsersPartnersId;
//ECHO $allchildpartnerids = $this->Agent_model->getAllPartnerids(1); EXIT;
               // echo "select * from user where PARTNER_ID IN($allchildpartnerids) order by USER_ID ASC"; exit;//
		$query  = $this->db2->query("select * from user where PARTNER_ID IN($loggedInUsersPartnersId) order by USER_ID ASC LIMIT $start,$limit");
		$result = $query->result();
		return $result;
	}

        public function userEditnameAlreadyExist($USERNAME,$uid){
	 	$p_count  = "select * from user where USERNAME='$USERNAME' && USER_ID!='$uid'";
		$p_result = $this->db2->query($p_count);
		return $pnum=$p_result->num_rows();
        }

        	public function userEditemailAlreadyExist($EMAIL,$uid){
	 	$p_count  = "select * from user where EMAIL_ID='$EMAIL' && USER_ID!='$uid'";
		$p_result = $this->db2->query($p_count);
		return $pnum=$p_result->num_rows();
	 }

	public function getUserInfoById($userid){
		$query  = $this->db2->query("select * from user where USER_ID = $userid");
		$result = $query->row();
		return $result;

	}

	public function updateUser($userid,$data=array()){

	   		$this->load->database();
             $uid = $this->uri->segment(4);
             $username	= addslashes(trim($data['USERNAME']));
             $email  	= addslashes(trim($data['EMAIL']));
             if($username){
                 $pnum = $this->userEditnameAlreadyExist($username,$uid);
             }else{
                 $pnum = '0';
             }

             if($email){
				$num = $this->userEditemailAlreadyExist($email,$uid);
             }else{
        		$num = '0';
             }
			 //contact information
			 $PASSWORD = $data['PASSWORD'];
			 $GENDER   = $data['GENDER'];
			 $PARTNER_STREET   = $data['PARTNER_STREET'];
			 $ADDRESS   = $data['ADDRESS'];
			 $ZIPCODE   = $data['ZIPCODE'];
			 $oriPass   = $data['oriPassword'];

			 if($data['password'] == '123456789'){
			      	$data = array(
					   'USERNAME' => $data['USERNAME'] ,
					   'FIRSTNAME' => $data['FIRST_NAME'] ,
					   'LASTNAME' => $data['LAST_NAME'] ,
					   'EMAIL_ID' => $data['EMAIL'] ,
					   'DATE_OF_BIRTH' => $data['DOB'] ,
					   'COUNTRY' => $data['PARTNER_COUNTRY'] ,
					   'CITY' => $data['PARTNER_CITY'] ,
					   'STATE' => $data['PARTNER_STATE'] ,
					   'CONTACT' => $data['CONTACT'] ,
					   'PASSWORD' => $oriPass,
					   'GENDER' => $GENDER,
					   'STREET' => $PARTNER_STREET,
					   'ADDRESS' => $ADDRESS,
					   'ZIPCODE' => $ZIPCODE
					);
			 }else{
			 	  	$data = array(
					   'USERNAME' => $data['USERNAME'] ,
					   'FIRSTNAME' => $data['FIRST_NAME'] ,
					   'LASTNAME' => $data['LAST_NAME'] ,
					   'EMAIL_ID' => $data['EMAIL'] ,
					   'DATE_OF_BIRTH' => $data['DOB'] ,
					   'COUNTRY' => $data['PARTNER_COUNTRY'] ,
					   'CITY' => $data['PARTNER_CITY'] ,
					   'STATE' => $data['PARTNER_STATE'] ,
					   'CONTACT' => $data['CONTACT'] ,
   					   'PASSWORD' => $PASSWORD,
					   'GENDER' => $GENDER,
					   'STREET' => $PARTNER_STREET,
					   'ADDRESS' => $ADDRESS,
					   'ZIPCODE' => $ZIPCODE
					);
			 }
		if($pnum > 0){
	        $err = 3;
        }elseif($num > 0){
            $err = 2;
        }else{
			$this->db->where('USER_ID', $userid);
			$res = $this->db->update('user', $data);

        if($res)
			$returnMsg  = "Sucessfully Updated";
		else
			$returnMsg  = "Something went wrong in update query";
		return $returnMsg;
        }
               if($err == 3){ redirect('user/account/edit/'.$userid.'?err=3&rid=11'); }
               if($err == 2){ redirect('user/account/edit/'.$userid.'?err=2&rid=11'); }
	}


	public function updateBankDetails($userid,$data=array()){

   		$this->load->database();

 	  	$data = array(
		   'ACCOUNT_HOLDER_NAME' => $data['ACCOUNT_HOLDER_NAME'] ,
		   'ACCOUNT_NUMBER' => $data['ACCOUNT_NUMBER'] ,
		   'MICR_CODE' => $data['MICR_CODE'] ,
		   'IFSC_CODE' => $data['IFSC_CODE'] ,
		   'BANK_NAME' => $data['BANK_NAME'] ,
		   'BRANCH_NAME' => $data['BRANCH_NAME']
			);

		$data1 = array(
		   'USER_ID' => $userid,
		   'ACCOUNT_HOLDER_NAME' => $data['ACCOUNT_HOLDER_NAME'] ,
		   'ACCOUNT_NUMBER' => $data['ACCOUNT_NUMBER'] ,
		   'MICR_CODE' => $data['MICR_CODE'] ,
		   'IFSC_CODE' => $data['IFSC_CODE'] ,
		   'BANK_NAME' => $data['BANK_NAME'] ,
		   'BRANCH_NAME' => $data['BRANCH_NAME']
			);

		$query = $this->db2->query("select USER_ID from user_account_details where USER_ID=$userid");
		$count = $query->num_rows();
		if($count > 0){
			$this->db->where('USER_ID', $userid);
			$res = $this->db->update('user_account_details', $data);
		}elseif($data['ACCOUNT_HOLDER_NAME'] != '' && $data['ACCOUNT_NUMBER'] != '' && $data['MICR_CODE'] != '' && $data['IFSC_CODE'] != '' &&$data['BANK_NAME'] != ''  && $data['BRANCH_NAME'] ){
			$res = $this->db->insert('user_account_details', $data1);
		}else{
			$res = '1';
		}
        if($res)
			$returnMsg  = "Sucessfully Updated";
		else
			$returnMsg  = "Something went wrong in update query";
		return $returnMsg;
	}

	public function activeUser($userId,$status){

	  $updateData = array(
				   'ACCOUNT_STATUS' => $status,
	);

		$this->db->where('USER_ID', $userId);
		$this->db->update('user', $updateData);
		$status = 1;
		return $status;
	}

        public function approveTransaction($refno,$amt,$uid)
        {
			$currentRecord = $this->Account_model->getUserPoints($uid);
            $partner_id = $this->Account_model->getUserPartnerId($uid);

            $depBal = $currentRecord->USER_DEPOSIT_BALANCE;
            $depositBal = $currentRecord->USER_DEPOSIT_BALANCE + $amt;
            $promoBal = $currentRecord->USER_PROMO_BALANCE;
            $winBal = $currentRecord->USER_WIN_BALANCE;
            $totBal = $depositBal + $promoBal + $winBal;

           $this->db->trans_begin();




             $this->db->query("UPDATE `user_points` SET `VALUE`=$totBal, `USER_DEPOSIT_BALANCE`=$depositBal, `USER_PROMO_BALANCE`=$promoBal, `USER_WIN_BALANCE`=$winBal, `USER_TOT_BALANCE`=$totBal  WHERE `USER_ID` ='".$uid."' AND `COIN_TYPE_ID`='1' LIMIT 1 ;");

            //Update into payment transaction
            $this->db->query("UPDATE `payment_transaction` SET `PAYMENT_TRANSACTION_STATUS` = '125' WHERE `INTERNAL_REFERENCE_NO` ='".$refno."' LIMIT 1 ;");

            $this->db->query("insert into master_transaction_history(USER_ID,BALANCE_TYPE_ID,TRANSACTION_STATUS_ID,TRANSACTION_TYPE_ID,TRANSACTION_AMOUNT,TRANSACTION_DATE,INTERNAL_REFERENCE_NO,CURRENT_TOT_BALANCE, CLOSING_TOT_BALANCE,PARTNER_ID )values('".$uid."','2','125','62','".$amt."','".date("Y-m-d H:i:s")."','".$refno."','".$depBal."','".$depositBal."','".$partner_id."')");

            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $return = 0;
            }else{
                $this->db->trans_commit();
                $return = 1;
            }

            return $return;
		}

	public function getUserPoints($userid){

		$query  = $this->db2->query("select * from user_points where USER_ID = $userid AND COIN_TYPE_ID = '1'");
		$result = $query->row();

		return $result;
	}

    public function getUserChips($userid){

		$query  = $this->db2->query("select * from user_points where USER_ID = $userid AND COIN_TYPE_ID = '2'");
		$result = $query->row();

		return $result;
	}


	public function getUserIdByName($username){
	   $query  = $this->db2->query("select USER_ID from user where USERNAME = '$username'");
		$result = $query->row();
		return $result->USER_ID;
	}

	public function getUserNameById($user_id){
	    $query  = $this->db2->query("select USERNAME from user where USER_ID = $user_id");
		$result = $query->row();
		return $result->USERNAME;
	}

		public function getVerificationNameById($verId){
	  	$query  = $this->db2->query("select VERIFICATION from user_verification_type where VERIFICATION_TYPE_ID = $verId");
		$result = $query->row();
		return $result->VERIFICATION;
	}

	public function getAllVerificationTypes(){
		$query  = $this->db2->query("select * from user_verification_type");
		$result = $query->result();
		return $result;
	}

	public function getUserVerificationInfo($data){

	  	$partner_id = $this->session->userdata('partnerid');
        $this->db2->select('*')->from('user_verification');
		if(!empty($data["userid"]))
			$this->db2->where('USER_ID', $data["userid"]);
		if(!empty($data["type"]) && $data["type"] != 'select')
			$this->db2->where('VERIFICATION_TYPE_ID', $data["type"]);
        $browseSQL = $this->db2->get();
		$results  = $browseSQL->result();
		return $results;
	}

     public function getUserIdByNameLike($username){
	   $query  = $this->db2->query("select USER_ID from user where USERNAME LIKE '%$username%' ");
            $totalCount = count($query->result())-1;

            foreach ($query->result() as $key=>$value) {
            if($key == $totalCount)
                 $userIDs .= $value->USER_ID;
            else
                 $userIDs .= $value->USER_ID.",";
            }
	    return $userIDs;
	}

   	function unsetUserSession(){
		$this->session->unset_userdata('USERNAME');
		$this->session->unset_userdata('EMAIL');
		$this->session->unset_userdata('PASSWORD');
		$this->session->unset_userdata('PARTNER_DISTRIBUTOR');
		$this->session->unset_userdata('USERPARTNER_ID');
		$this->session->unset_userdata('DEFAULT_POINTS');
		$this->session->unset_userdata('PARTNER_COUNTRY');
		$this->session->unset_userdata('PARTNER_STATE');
		$this->session->unset_userdata('PARTNER_CITY');

		 $this->session->unset_userdata('GENDER', $formdata['GENDER']);
		 $this->session->unset_userdata('FIRST_NAME', $formdata['FIRST_NAME']);
		 $this->session->unset_userdata('LAST_NAME', $formdata['LAST_NAME']);
		 $this->session->unset_userdata('CONTACT', $formdata['CONTACT']);
		 $this->session->unset_userdata('PARTNER_STREET', $formdata['PARTNER_STREET']);
		 $this->session->unset_userdata('ADDRESS', $formdata['ADDRESS']);
		 $this->session->unset_userdata('ZIPCODE', $formdata['ZIPCODE']);
	}

	function setUserSession($formdata){


		 $this->session->set_userdata('USERNAME', $formdata['USERNAME']);
		 $this->session->set_userdata('EMAIL', $formdata['EMAIL']);
		 $this->session->set_userdata('PASSWORD', $formdata['PASSWORD']);
		 $this->session->set_userdata('PARTNER_DISTRIBUTOR', $formdata['PARTNER_DISTRIBUTOR']);
		 $this->session->set_userdata('USERPARTNER_ID', $formdata['USERPARTNER_ID']);
		 $this->session->set_userdata('DEFAULT_POINTS', $formdata['DEFAULT_POINTS']);
		 $this->session->set_userdata('PARTNER_COUNTRY', $formdata['PARTNER_COUNTRY']);
		 $this->session->set_userdata('PARTNER_STATE', $formdata['PARTNER_STATE']);
		 $this->session->set_userdata('PARTNER_CITY', $formdata['PARTNER_CITY']);

		 $this->session->set_userdata('GENDER', $formdata['GENDER']);
		 $this->session->set_userdata('FIRST_NAME', $formdata['FIRST_NAME']);
		 $this->session->set_userdata('LAST_NAME', $formdata['LAST_NAME']);
		 $this->session->set_userdata('CONTACT', $formdata['CONTACT']);
		 $this->session->set_userdata('PARTNER_STREET', $formdata['PARTNER_STREET']);
		 $this->session->set_userdata('ADDRESS', $formdata['ADDRESS']);
		 $this->session->set_userdata('ZIPCODE', $formdata['ZIPCODE']);

	}

	function getUserPartnerId($userid){
		$querycnt=$this->db2->query("select PARTNER_ID from user where USER_ID='".$userid."'");
		$rowcnt=$querycnt->row();
		return $rowcnt->PARTNER_ID;
	}

	function checkUser($partnersId,$userid){

		$querycnt=$this->db2->query("select count(*) as cnt from user where USERNAME='".$userid."' AND PARTNER_ID IN($partnersId)");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
	}

	function getAllUserInfoByPartnerIds($partnersId,$userid){

		$querycnt=$this->db2->query("select * from user where USERNAME='".$userid."' AND PARTNER_ID IN($partnersId)");
		$rowcnt=$querycnt->row();
		return $rowcnt;
	}


	function getAllUsersByPartnerIds($partnersId){

		$querycnt=$this->db2->query("select * from user where PARTNER_ID IN($partnersId)");
		$rowcnt=$querycnt->result();
		return $rowcnt;
	}

	public function get_user_playpoints($USER_ID){
	    $sql_totalplaypoints=$this->db2->query("select sum(TRANSACTION_AMOUNT) as totalbets from master_transaction_history where USER_ID='".$USER_ID."' and TRANSACTION_TYPE_ID='11'");
   		$row_totalplaypoints=$sql_totalplaypoints->row();
		if(is_object($row_totalplaypoints) && count($row_totalplaypoints)>0){
    		$totalbets=$row_totalplaypoints->totalbets;
    	return $totalbets;
		}else{ return 0;}
}

  public function get_user_winpints($USER_ID){

    $sql_totalwinpoints=$this->db2->query("select sum(TRANSACTION_AMOUNT) as totalwins from master_transaction_history where USER_ID='".$USER_ID."' and TRANSACTION_TYPE_ID='12'");
    $row_totalwinpoints=$sql_totalwinpoints->row();
	if(is_object($row_totalwinpoints) && count($row_totalwinpoints)>0){
    	$totalwins=$row_totalwinpoints->totalwins;
    	return $totalwins;
	}
	else{
		return 0;
	}
  }

  public function get_user_margin($user_id){

	$totalbets=$this->get_user_playpoints($user_id);
	$totalwins=$this->get_user_winpints($user_id);
    if($totalbets){
        return $totalbets-$totalwins;
    }
	else{
	return 0;
	}
   }

   public function deauthendicateUser($userid,$desc){

        $this->db->query("update user set ACCOUNT_STATUS=0 where USER_ID='".$userid."'");

       $selQry = $this->db2->query("SELECT USERNAME FROM user WHERE USER_ID = '".$userid."'");
       $row = $selQry->row();

		$ss = $this->db->query("INSERT INTO `exclude_players` (`USER_ID`,`USERNAME`,`DESCRIPTION`,`ADMIN_USER_ID`,`DATE`)
		VALUES ('".$userid."','".$row->USERNAME."','".$desc."','1',now())");
		if($ss)
			echo 'Description Saved';

    }


    public function authendicateUser($userid){
        $res=$this->db->query("update user set ACCOUNT_STATUS=1 where USER_ID='".$userid."'");
        if($res)
		echo 'Activated';
    }


    public function keyActivate($key,$userid){
        $selQry = $this->db2->query("SELECT * FROM user WHERE ACTIVATION_CODE = '".$key."' and USER_ID = '".$userid."' and ACCOUNT_STATUS = 0");

        if ($selQry->num_rows() > 0){
            $res = $this->db->query("update user set ACCOUNT_STATUS=1 where USER_ID='".$userid."'");

            return $res;
        }else{
            return 0;
        }
    }

		public function addUserVerification($data,$session){

		  $userid =  $data['user_id'];
		  $type   =  $data['proof_type'];
		  $proof  =  $data['proof'];
		  $status = 1;
		  $reason  =  $data['desc_status'];
		  $submittedby = $data['partnerid'];
		  $submitteddate = date("d-m-Y");

		  $targetpath   = $_SERVER['DOCUMENT_ROOT'].'/pokerplatform/static/uploads/proof/';
		  move_uploaded_file($_FILES['proof']['tmp_name'], $targetpath.$_FILES['proof']['name']);

		$this->db->query("INSERT INTO `user_verification` (`USER_ID`, `VERIFICATION_TYPE_ID`, `VERIFICATION_PROOF`, `ADDRESS`, `REASON`, `SUBMITTED_DATE`, `SUBMITTED_BY`, `STATUS`) VALUES ($userid, $type, '".$_FILES['proof']['name']."', '', '$reason', '$submitteddate', '$submittedby', '$status')");
	   return $this->db->insert_id();
	}

        public function verifyProof($data){
            $userid = $data['userid'];
            $approve = $data['approve'];
            $desc_reason = $data['desc_reason'];
			$verifyid = $data['verify_id'];
            $data = array(
               'STATUS' => $approve,
               'REASON' => $desc_reason
            );

			$whereData = array('USER_ID' => $userid , 'USER_VERIFICATION_ID' => $verifyid);
            $this->db->where($whereData);
            $res = $this->db->update('user_verification', $data);
            return $res;
        }

  public function getAllSearchUserinfo(){
            $partnerids  = $this->Agent_model->getAllChildIds();
            $allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
            if($allUserids != ''){
               $allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
               return $allUserNames;
            }else{
               $userids  = "007";
               return $userids;
            }
        }


	public function getAllSearchIpCount($loggedInPartnersUsername,$searchdata) {
		$uname =  "'".str_replace(",","','",$loggedInPartnersUsername)."'";

		$conQuery .= "TRACKING_ID!= ''";
		if($searchdata['USERNAME']!="") {
			$conQuery .= " AND USERNAME LIKE '%".$searchdata['USERNAME']."%'";
		}
		if($searchdata['IPADDRESS']!="") {
			$conQuery .= " AND SYSTEM_IP LIKE '%".$searchdata['IPADDRESS']."%'";
		}
		if($searchdata['select2']!="") {
			$conQuery .= " AND STATUS = '".$searchdata['select2']."'";
		}

		if($searchdata['START_DATE_TIME']!="" && $searchdata['END_DATE_TIME']!="") {
		   $conQuery .= " AND DATE_FORMAT(DATE_TIME,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata['START_DATE_TIME']))."' ".
		   				"AND DATE_FORMAT(DATE_TIME,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($searchdata['END_DATE_TIME']))."'";
		}
		if($conQuery != ""){
			$querycnt=$this->db2->query("select count(*) as cnt from tracking where $conQuery AND USERNAME IN($uname)");
		} else {
			$querycnt=$this->db2->query("select count(*) as cnt from tracking where USERNAME IN($uname)");
		}
		$rowcnt=$querycnt->result();
		$account_property = $rowcnt[0]->cnt;
		return $account_property;
	}


	public function getAllSearchIpInfo($loggedInPartnersUsername,$searchdata,$limit,$start) {
		$uname =  "'".str_replace(",","','",$loggedInPartnersUsername)."'";

		$conQuery .= "TRACKING_ID!= ''";
		if($searchdata['USERNAME']!="") {
			$conQuery .= " AND USERNAME LIKE '%".$searchdata['USERNAME']."%'";
		}
		if($searchdata['IPADDRESS']!="") {
			$conQuery .= " AND SYSTEM_IP LIKE '%".$searchdata['IPADDRESS']."%'";
		}
		if($searchdata['select2']!="") {
			$conQuery .= " AND STATUS = '".$searchdata['select2']."'";
		}

		if($searchdata['START_DATE_TIME']!="" && $searchdata['END_DATE_TIME']!="") {
		   $conQuery .= " AND DATE_FORMAT(DATE_TIME,'%Y-%m-%d')  >= '".date('Y-m-d',strtotime($searchdata['START_DATE_TIME']))."' ".
		   				"AND DATE_FORMAT(DATE_TIME,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($searchdata['END_DATE_TIME']))."'";
		}

		if($conQuery != ""){
			$query=$this->db2->query("select * from tracking where $conQuery AND USERNAME IN($uname) ORDER BY USERNAME ASC LIMIT $start,$limit");
		} else {
			$query=$this->db2->query("select * from tracking where USERNAME IN($uname) ORDER BY USERNAME ASC LIMIT $start,$limit");
		}
      	$fetchResults  = $query->result();
		return $fetchResults;
	}


	public function getAllIpCount($loggedInPartnersUsername){
            $uname =  "'".str_replace(",","','",$loggedInPartnersUsername)."'";

	   $allchildpartnerids = $this->Agent_model->getAllPartnerids($loggedInUsersPartnersId);
		$querycnt=$this->db2->query("select count(*) as cnt from tracking where USERNAME IN($uname)");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
	}

	public function getAllIpInfo($loggedInPartnersUsername,$limit,$start){
            $uname =  "'".str_replace(",","','",$loggedInPartnersUsername)."'";
		$query  = $this->db2->query("select * from tracking where USERNAME IN($uname) order by USERNAME ASC LIMIT $start,$limit");
		$result = $query->result();
		return $result;
	}

  public function activeIpaddress($trackingid,$status,$statusType){
	$query = $this->db2->query("select SYSTEM_IP from tracking where TRACKING_ID ='$trackingid' ");
        $res = $query->result();
        $ipaddress=$res[0]->SYSTEM_IP;
		if($statusType==1) {
			$updateData = array(
				'STATUS' => $status
			);
		} else {
			$updateData = array(
				'LOGIN_STATUS' => $status
			);
		}
		$this->db->where('SYSTEM_IP', $ipaddress);
		$this->db->update('tracking', $updateData);
		$status = 2;
		return $status;
	}

	public function userLoggedInStatus($userID) {
		$this->db2->select('LOGIN_STATUS')->from('user');
		$this->db2->where('USER_ID',$userID);
		$browseSQL = $this->db2->get();
		$rsResult = $browseSQL->row();
		return $rsResult->LOGIN_STATUS;
	}

 /* POKER FUNCTIONS START FROM HERE */

 	public function getUserBalances($userID,$cointTypeID) {
		$query  = $this->db2->query("select * from user_points where USER_ID = $userID AND COIN_TYPE_ID = $cointTypeID");
		$result = $query->row();
		return $result;
	}

	public function get_user_BankDetails($userid){
		$query = $this->db2->query("select * from user_account_details where USER_ID = $userid");
		$result = $query->row();
		return $result;
	}

	public function get_user_withdrawalDetails($userId,$typeid,$status){

		$query  = $this->db2->query("select sum(TRANSACTION_AMOUNT) as amount from master_transaction_history where USER_ID = $userId AND TRANSACTION_TYPE_ID = $typeid AND TRANSACTION_STATUS_ID = $status");
		$result = $query->row();
		return $result;
	}

	public function get_user_withdrawalCount($userId,$typeid,$status){

		$query  = $this->db2->query("select count(*) as cnt from master_transaction_history where USER_ID = $userId AND TRANSACTION_TYPE_ID = $typeid AND TRANSACTION_STATUS_ID = $status");
		$result = $query->row();
		return $result;
	}

	public function get_user_IdType($userid){
		$query  = $this->db2->query("select VERIFICATION_TYPE_ID,VERIFICATION from user_verification_type");
		foreach($query->result() as $key=>$rows){
			$row[$key]=$rows;
		}
		return $row;
	}

	public function get_user_IdVerification($userid){

		$query  = $this->db2->query("select * from user_verification where USER_ID = $userid");
		$result = $query->row();
		return $result;

	}

	public function getVerificationInfo($userid,$verication_id){
		$query  = $this->db2->query("select * from user_verification where USER_ID = $userid AND VERIFICATION_TYPE_ID = $verication_id" );
		$result = $query->row();
		return $result;

	}

 /* POKER FUNCTIONS END HERE */


}
