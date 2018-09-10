<?php
/*
  Class Name	: Common_model
  Package Name  : Common
  Purpose       : Handle all the common database functions
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class Common_model extends CI_Model
{

	public function getBalance($data){
		$qry=$this->db2->query("SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID=".addslashes($data['id']));
		$row_wallet=$qry->row();
                if(isset($row_wallet->AMOUNT)){
		$cash=$row_wallet->AMOUNT;
		return $cash;
                }
	}

	public function deactivepartner($partnerid){
        $this->load->database();
		//echo "UPDATE partner SET STATUS='0' where PARTNER_ID='".addslashes($partnerid)."'";
		//exit;
        $res=$this->db->query("UPDATE partner SET STATUS='0' where PARTNER_ID='".addslashes($partnerid)."'");
        if($res)
		echo 'Dectivated';
        }

        public function activepartner($partnerid){
        $this->load->database();
        $res=$this->db->query("UPDATE partner SET STATUS='1' where PARTNER_ID='".addslashes($partnerid)."'");
        if($res)
		echo 'Activated';
        }

	public function getCountriesList(){
            $query = $this->db2->query("select CountryName from countries ");
            return $countryInfo = $query->result();
	}

	public function getStateList(){
            $query = $this->db2->query("select StateName from state order by StateName");
            return $stateInfo = $query->result();
	}


        function buildTree(array $elements, $parentId = 0){
            $branch = array();

            foreach ($elements as $element){
                if ($element['parent_id'] == $parentId) {
                    $children = buildTree($elements, $element['id']);
                    if ($children) {
                        $element['children'] = $children;
                    }
                    $branch[] = $element;
                }
            }

            return $branch;
        }


        function lighttrans($data,$subrole,$loc){
            $cpassword=$_REQUEST['partnertransaction_password'];
            $sub = $subrole;
            $sql_transchk=$this->db2->query("select ADMIN_USER_ID from admin_user where TRANSACTION_PASSWORD='".md5($cpassword)."' and FK_PARTNER_ID='".$this->session->userdata['partnerid']."'");
			$res_transchk = $sql_transchk->row();
        if(count($res_transchk->ADMIN_USER_ID)>0){
            $_SESSION['passwordchecked']="1";
            if($sub == "AdjustPoints"){
            redirect('/user/account/adjust?rid=13', 'refresh');
            }
            exit;
        }else{
            $_SESSION['passwordchecked']="";
            $a = explode("/", $loc);
			$locator = str_replace('&errmsg=404', '', $loc);
            //print_r($a);die;
            //$locator = $a[2]."/".$a[3]."/".str_replace('&errmsg=404', '', $a[4]);
            //echo base_url().$locator.'&errmsg=404';die;
            redirect($locator.'&errmsg=404');

            exit;
            }
        }

        function lighttransaction($data,$subrole,$loc,$uid){
            $cpassword=$_REQUEST['partnertransaction_password'];
            $sub = $subrole;
			$userid = base64_encode($uid);
            $sql_transchk=$this->db2->query("select ADMIN_USER_ID from admin_user where TRANSACTION_PASSWORD='".md5($cpassword)."' and FK_PARTNER_ID='".$this->session->userdata['partnerid']."'");
			$res_transchk = $sql_transchk->row();
        if(count($res_transchk->ADMIN_USER_ID)>0){
            $_SESSION['passwordchecked']="1";
            redirect('/user/account/adjust/'.$userid.'?rid=13', 'refresh');
            exit;
        }else{
            $_SESSION['passwordchecked']="";
            $a = explode("/", $loc);
			$locator = str_replace('&errmsg=404', '', $loc);
            redirect($locator.'&errmsg=404');
            exit;
            }
        }

        function typeOfPartnerId(){
            $typid=$this->session->userdata('partnertypeid');
            $query = $this->db2->query("select PARTNER_TYPE_DESC from partners_type where PARTNER_TYPE_ID='".addslashes($typid)."'");
            $partnerType = $query->row();
            return $partnerType->PARTNER_TYPE_DESC;
        }


        function getParentIdByRoleId($uid){

            $this->load->database();
            $query = $this->db2->query("select FK_ROLE_ID from role where ROLE_ID='".addslashes($uid)."'");
            $parid = $query->row();
		//	echo $this->db->last_query();
            return $parid->FK_ROLE_ID;
        }





	public function generate_menu($data){
        if(isset($data['adminuserid'])){

			 if($data['adminuserid']==1){
					$query="select * from role where STATUS=1 and ONLINE_AGENT_STATUS=1 and FK_ROLE_ID=0 and ONLINE_AGENT_STATUS=1 order by MENU_ORDER";
			 }elseif($data['partnertype'] > 11 && $data['partnertype']<15){
				 $query="select * from role r,role_to_admin a where r.STATUS=1 and ONLINE_AGENT_STATUS=1 and r.ONLINE_AGENT_STATUS = 1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.FK_ROLE_ID=0 and r.ROLE_ID not in(68,80) and r.ROLE_ID=a.FK_ROLE_ID order by MENU_ORDER";
			 }else{
				$query="select * from role r,role_to_admin a where r.STATUS=1 and ONLINE_AGENT_STATUS=1 and r.ONLINE_AGENT_STATUS = 1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.FK_ROLE_ID=0 and r.ROLE_ID not in(80) and r.ROLE_ID=a.FK_ROLE_ID order by MENU_ORDER";
			 }  
			// echo $query;exit;
		$sqlresults=$this->db2->query($query);
		$MenuArray=array();
			$SubmenuArray=array();
			$subsubmenu=array();
		if(is_array($sqlresults->result()) && count($sqlresults->result())>0) {
		foreach($sqlresults->result() as $mmenu){
			   if($data['adminuserid']==1){
			$submenuquery="select * from role where FK_ROLE_ID='".$mmenu->ROLE_ID."' and ROLE_ID not in(55) and STATUS=1 group by role_id order by MENU_ORDER";
			 }else{
					if($data['partnertype']==14){
					$submenuquery="select * from role r,role_to_admin a where r.FK_ROLE_ID='".$mmenu->ROLE_ID."' and r.ONLINE_AGENT_STATUS = 1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.STATUS=1 and r.ROLE_ID=a.FK_ROLE_ID and r.ROLE_ID not in(65,54) group by r.role_id order by MENU_ORDER";
					}elseif($data['partnertype'] > 11 && $data['partnertype']<15){
						$submenuquery="select * from role r,role_to_admin a where r.FK_ROLE_ID='".$mmenu->ROLE_ID."' and r.ONLINE_AGENT_STATUS = 1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.STATUS=1 and r.ROLE_ID=a.FK_ROLE_ID and r.ROLE_ID not in(69,71,81,82,83) group by r.role_id order by MENU_ORDER";
						//echo $submenuquery;exit;
					}else{
					$submenuquery="select * from role r,role_to_admin a where r.FK_ROLE_ID='".$mmenu->ROLE_ID."' and r.ONLINE_AGENT_STATUS = 1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.STATUS=1 and r.ROLE_ID=a.FK_ROLE_ID and r.ROLE_ID not in(81) group by r.role_id order by MENU_ORDER";
					}
			   }
			$SubmenuArray="";
			$subsubmenu="";
		$sqlsubresults=$this->db2->query($submenuquery);


			   if(is_array($sqlsubresults->result()) && count($sqlsubresults)>0){

				foreach($sqlsubresults->result() as $smenu){
				   if($data['adminuserid']==1){
						$subsubmenuquery="select * from role where FK_ROLE_ID='".$smenu->ROLE_ID."' and ONLINE_AGENT_STATUS=1 and STATUS=1 group by role_id order by MENU_ORDER";
				 }else{
						$subsubmenuquery="select * from role r,role_to_admin a where r.FK_ROLE_ID='".$smenu->ROLE_ID."' and ONLINE_AGENT_STATUS=1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.STATUS=1 and r.ROLE_ID=a.FK_ROLE_ID group by r.role_id order by MENU_ORDER";
				   }
				$sqlsubsubresults=$this->db2->query($subsubmenuquery);
																   // echo $this->db->last_query();

				if(is_array($sqlsubsubresults->result()) && count($sqlsubsubresults)>0){

				foreach($sqlsubsubresults->result() as $ssmenu){
					$subsubmenu[]=array("roleid"=>$ssmenu->ROLE_ID,"subrole"=>$ssmenu->ROLE_NAME,"link"=>$ssmenu->LINK);
				}
			   }
			if($smenu->ROLE_NAME != "Transfer Points" && $smenu->ROLE_NAME != 'Activity Summary'){
			$SubmenuArray[]=array("roleid"=>$smenu->ROLE_ID,"subrole"=>$smenu->ROLE_NAME,"link"=>$smenu->LINK);
			}
			}
		   }
				$MenuArray[]=array("roleid"=>$mmenu->ROLE_ID,"role"=>$mmenu->ROLE_NAME,"submenu"=>$SubmenuArray,"subsubmenu"=>$subsubmenu);
			 }
			}
		}
		//echo '<pre>';print_r($MenuArray);exit;
			return $MenuArray;
        }


         public function usermenus($data){
              if(isset($data['adminuserid'])){
                    if($data['adminuserid']==1){
                            $query="select ROLE_ID from role where STATUS=1 and FK_ROLE_ID=0 and ONLINE_AGENT_STATUS=1 order by MENU_ORDER";
                    }else{
                            $query="select ROLE_ID from role r,role_to_admin a where r.STATUS=1 and ONLINE_AGENT_STATUS=1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.ROLE_ID=a.FK_ROLE_ID order by MENU_ORDER";
                    }
                    $sqlresults=$this->db2->query($query);

                    $MenuArray=array();
                    if(is_array($sqlresults->result()) && count($sqlresults->result())>0){
                        foreach($sqlresults->result() as $mmenu){
                        $MenuArray[]=$mmenu->ROLE_ID;
                        }
                    }
             }
             return $MenuArray;
         }

        public function shortenStr ($str, $len) {
		return strlen($str) > $len ?  substr($str, 0, $len)."..." : $str;
	}

	public function getAllCountries(){
	  $query = $this->db2->query("select * from countries order by CountryName");
	  return $stateInfo = $query->result();
	}

		public function getBalanceType(){
	  $query = $this->db2->query("SELECT * FROM balance_type where BALANCE_TYPE_ID<4 ORDER BY BALANCE_TYPE_ID ASC");
	  return $stateInfo = $query->result();
	}

	public function getRevenueHistoricalData() {
		$this->db2->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		//$this->db->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db2->order_by('REVENUE_ID','desc');
		$browseSQL = $this->db2->get('zrevenue_historical_data');
		return $browseSQL->result();
	}

	public function getUsersHistoricalData() {
		$this->db2->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db2->order_by('USER_ID','desc');
		$browseSQL = $this->db2->get('zusers_historical_data');
		return $browseSQL->result();
	}

	public function getXUsersHistoricalData() {
		$this->db2->where('PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->order_by('XUSER_ID','desc');
		$this->db2->limit(1);
		$browseSQL = $this->db2->get('xusers_historical_data');
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function getXWithdrawalHistoricalData() {
		$this->db2->where('PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->order_by('XWITHDRAW_ID','desc');
		$this->db2->limit(1);
		$browseSQL = $this->db2->get('xwithdrawal_historical_data');
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function xGameHistoricalData() {
       /* $this->db->select('ghd.*,minigames_type_id')->from('xgame_historical_data ghd');
		$this->db->join('minigames_type mt', 'mt.MINIGAMES_TYPE_NAME = ghd.GAME_NAME', 'left');
		$this->db->where('ghd.PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db->where("DATE_FORMAT(ghd.CREATED_ON,'%Y-%m-%d') = ",date('Y-m-d',strtotime("-1 day")));
		$this->db->order_by('ghd.GAME_NAME','desc');
		$browseSQL = $this->db->get();
		//echo $this->db->last_query();
		return $browseSQL->result();		 */
		$this->db2->where('PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->where("DATE_FORMAT(CREATED_ON,'%Y-%m-%d') = ",date('Y-m-d'));
		$this->db2->order_by('GAME_NAME','desc');
		$browseSQL = $this->db2->get('xgame_historical_data');
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function xDepositsHistoricalData() {
		$this->db2->where('PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->order_by('XDEPOSIT_ID','desc');
		$browseSQL = $this->db2->get('xdeposits_historical_data');
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function xTicketsHistoricalData() {
		$this->db2->where('PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->order_by('XTICKETS_ID','desc');
		$browseSQL = $this->db2->get('xtickets_historical_data');
		//echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function getCashflowHistoricalData() {
		$this->db2->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db2->order_by('CASHFLOW_ID','desc');
		$browseSQL = $this->db2->get('zcashflow_historical_data');
		return $browseSQL->result();
	}

	public function getPromotionHistoricalData() {
		$this->db2->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db2->order_by('PROMOTION_ID','desc');
		$browseSQL = $this->db2->get('zpromotion_historical_data');
		return $browseSQL->result();
	}

	public function getGamesHistoricalData() {
		$this->db2->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db2->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db2->order_by('GAME_ID','desc');
		$browseSQL = $this->db2->get('zgames_historical_data');
		return $browseSQL->result();
	}


        public function getDetailsInGameSettings($tableName){
		$this->db2->select('CONFIG_ID,KEY_NAME,VALUE')->from($tableName);
		$browseSQL = $this->db2->get();
		$rsResult  = $browseSQL->result();
            return $rsResult;
        }

        public function updateBackOfficeConfigData($settings){
        	$data = array(
		   'VALUE'  => $settings["VALUE"]);
            	$this->db->where('CONFIG_ID', $settings["CONFIG_ID"]);
                $res = $this->db->update('config', $data);
           return $res;

        }

        function errorHandling($errCode){
            //echo $errCode;die;
          switch ($errCode) {
          case "404":
               $errMsg = "Invalid Transaction Password !!!";
               break;

           case "2":
               $errMsg = "Username dosenot exists !!!";
               break;

           case "3":
               $errMsg = "Balance Insufficient !!!";
               break;

           case "4":
               $errMsg = "Special characters are not allowed in points !!!";
               break;

           case "5":
               $errMsg = "Enter the points !!!";
               break;

           case "6":
               $errMsg = "Something went wrong... Please try again !!!";
               break;
							 case "407":
	                 $errMsg = "You do not have permission to view this page";
	                 break;

          }
          $returnString  = '<div class="UpdateMsgWrap"><table width="100%" class="ErrorMsg"><tr><td width="25"><img src="'.base_url().'static/images/icon-error.png" alt="" width="30" height="24" /></td><td width="95%">'.$errMsg.'</td></tr></table></div>';
          return $returnString;
          }
		  
	function sessionStatus(){
		/** tracking info */
		$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
		$arrTraking["USERNAME"]     =$this->session->userdata('partnerusername');
		$arrTraking["SYSTEM_IP"]    =$_SERVER['REMOTE_ADDR'];				
		$arrTraking["REFERRENCE_NO"]=uniqid();
		$arrTraking["STATUS"]       =1;
		$arrTraking["LOGIN_STATUS"] =1;
		$arrTraking["CUSTOM2"]      =1;
		/** tracking info end */

		//check current partners status
		$sessionPartnerId = $this->session->userdata('partnerid');
		$sessionPartnerPassword = $this->session->userdata('partnerpassword');
		//echo $sessionPartnerPassword;exit;
		if($sessionPartnerId != ''){
		  //get the currnet users status
			$loginPartnerStaus = $this->getLoginPartnerStatus();
			 if(!empty($loginPartnerStaus)){//check record exist or not
				$currentStatus = $loginPartnerStaus['ACCOUNT_STATUS'];
				$currentPassword = $loginPartnerStaus['PASSWORD'];
				//check the status: if current status is deactivate then redirect to logout page
				if($currentStatus == 0){
					//insert into log
					$arrTraking["ACTION_NAME"]  ="Logout";
					$arrTraking["CUSTOM1"]      =json_encode(array('failure'=>'Auto logout - Account Deactivated'));
					$this->db->insert("tracking",$arrTraking);
					$this->session->sess_destroy();
					$msg =base64_encode('Account Deactivated');
					redirect('login/index?fm='.$msg);
				}//EO: Status check
				//check password: if current password and session password not same then redirect to logout page
				if($currentPassword != $sessionPartnerPassword){
					//insert into log
					$arrTraking["ACTION_NAME"]  ="Logout";
					$arrTraking["CUSTOM1"]      =json_encode(array('failure'=>'Auto logout - Password Modified'));
					$this->db->insert("tracking",$arrTraking);
					$this->session->sess_destroy();
					$msg =base64_encode('Password Modified Please Login');
					redirect('login/index?fm='.$msg);
				}//EO: Password check
			}//EO: record count check
		}//EO: Sesison Partner Id check
	}
	function getLoginPartnerStatus(){
		$this->db2->where('ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$browseSQL = $this->db2->get('admin_user');
		return $browseSQL->row_array();
	}
	
	function partner_password_validate_success( )
	{
		if($this->session->userdata('password_reset_status') && $this->session->userdata('password_reset_status')==1)
		{
			return TRUE;
		}
		elseif( $this->session->userdata('adminusername')=='' )
		{
			return FALSE;
		}
		else
		{
			redirect('partners/index');	
		}  
	}

	function authendicate()
	{
		#reset password page
		if($this->session->userdata('password_reset_status') && $this->session->userdata('password_reset_status')==1)
		{
			redirect('resetpassword/index');
		}
		#Without session redirect to login
		elseif( $this->session->userdata('adminusername')=='' )
		{
			$this->session->set_flashdata('message', 'Login to access the page');
			redirect();
		}
		else
		{
			return TRUE;
		} 
	}

	public function get_partner_details($partnerId)
	{
		$this->db->select('p.PARTNER_ID,p.PARTNER_NAME,pb.AMOUNT,p.PARTNER_TRANSACTION_PASSWORD,p.PARTNER_PASSWORD,p.FK_PARTNER_ID ,p.FK_PARTNER_TYPE_ID as PARTNER_TYPE_ID,pt.PARTNER_TYPE,pt.PARTNER_TYPE_DESC,p.PARTNER_REVENUE_SHARE,p.PARTNER_COMMISSION_TYPE')
					->from("partner as p")
					->join("partners_type as pt",'pt.PARTNER_TYPE_ID=p.FK_PARTNER_TYPE_ID')
					->join("partners_balance as pb",'pb.PARTNER_ID=p.PARTNER_ID');
		$this->db->where("p.PARTNER_ID",$partnerId);
		$userbrowseSQL = $this->db->get();
		$results = $userbrowseSQL->row();
		return $results;
	}

}
