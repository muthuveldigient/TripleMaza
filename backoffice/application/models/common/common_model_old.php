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
		$qry=$this->db->query("SELECT AMOUNT FROM partners_balance WHERE PARTNER_ID=".addslashes($data['id']));
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
            $query = $this->db->query("select CountryName from countries ");
            return $countryInfo = $query->result();
	}
	
	public function getStateList(){
            $query = $this->db->query("select StateName from state order by StateName");
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

        
        function lighttrans($data){
            $cpassword=$_REQUEST['partnertransaction_password'];
            $sql_transchk=mysql_query("select PARTNER_ID from partner where PARTNER_TRANSACTION_PASSWORD='".md5($cpassword)."' and PARTNER_ID='".$this->session->userdata['partnerid']."'");
        if(mysql_num_rows($sql_transchk)>0){
            $_SESSION['passwordchecked']="1";   
            redirect('/agent/myagent/create', 'refresh');
            
            exit;
        }else{
            $_SESSION['passwordchecked']="";   
            redirect('/user/account/search?errmsg=404', 'refresh');
           
            exit;   
            }    
        }
        
        
        function typeOfPartnerId(){
            $typid=$this->session->userdata('partnertypeid');
            $query = $this->db->query("select PARTNER_TYPE_DESC from partners_type where PARTNER_TYPE_ID='".addslashes($typid)."'");
            $partnerType = $query->row();
            return $partnerType->PARTNER_TYPE_DESC;
        }
        
        
        function getParentIdByRoleId($uid){
            $this->load->database(); 
            $query = $this->db->query("select FK_ROLE_ID from role where ROLE_ID='".addslashes($uid)."'");
            $parid = $query->row();
            return $parid->FK_ROLE_ID;
        }
        
        
        
        

	public function generate_menu($data){
                        if(isset($data['adminuserid'])){
                                if($data['adminuserid']==1){
                                        $query="select * from role where STATUS=1 and FK_ROLE_ID=0 order by MENU_ORDER";
                                }else{
                                        $query="select * from role r,role_to_admin a where r.STATUS=1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.FK_ROLE_ID=0 and r.ROLE_ID=a.FK_ROLE_ID order by MENU_ORDER";
                                }
                               //  echo $this->db->last_query($query);
				$sqlresults=$this->db->query($query);
                                
				$MenuArray=array();
                                $SubmenuArray=array();

                                $subsubmenu=array();
				if(is_array($sqlresults->result()) && count($sqlresults->result())>0){
					foreach($sqlresults->result() as $mmenu){
                                               if($data['adminuserid']==1){ 
						$submenuquery="select * from role where FK_ROLE_ID='".$mmenu->ROLE_ID."' and STATUS=1 group by role_id order by MENU_ORDER";
                                               }else{
                                                $submenuquery="select * from role r,role_to_admin a where r.FK_ROLE_ID='".$mmenu->ROLE_ID."' and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.STATUS=1 and r.ROLE_ID=a.FK_ROLE_ID group by r.role_id order by MENU_ORDER";   
                                               }
                                              //echo $this->db->last_query();
                                               $SubmenuArray="";
                                               $subsubmenu=""; 
						$sqlsubresults=$this->db->query($submenuquery);
                                                if(is_array($sqlsubresults->result()) && count($sqlsubresults)>0){
                                                        
							foreach($sqlsubresults->result() as $smenu){
                                                                if($data['adminuserid']==1){ 
                                                                    $subsubmenuquery="select * from role where FK_ROLE_ID='".$smenu->ROLE_ID."' and STATUS=1 group by role_id order by MENU_ORDER";
                                                                }else{
                                                                    $subsubmenuquery="select * from role r,role_to_admin a where r.FK_ROLE_ID='".$smenu->ROLE_ID."' and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.STATUS=1 and r.ROLE_ID=a.FK_ROLE_ID group by r.role_id order by MENU_ORDER";   
                                                                }
                                                                $sqlsubsubresults=$this->db->query($subsubmenuquery);
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
                        
                    
                    return $MenuArray;
        }
 
         public function usermenus($data){
              if(isset($data['adminuserid'])){
                    if($data['adminuserid']==1){
                            $query="select ROLE_ID from role where STATUS=1 and FK_ROLE_ID=0 order by MENU_ORDER";
                    }else{
                            $query="select ROLE_ID from role r,role_to_admin a where r.STATUS=1 and a.FK_ADMIN_USER_ID='".$data['adminuserid']."' and r.ROLE_ID=a.FK_ROLE_ID order by MENU_ORDER";
                    }
                    $sqlresults=$this->db->query($query);
                   
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
	  $query = $this->db->query("select * from countries order by CountryName");
	  return $stateInfo = $query->result();
	}
	
		public function getBalanceType(){
	  $query = $this->db->query("SELECT * FROM balance_type where BALANCE_TYPE_ID<4 ORDER BY BALANCE_TYPE_ID ASC");
	  return $stateInfo = $query->result();
	}
	
	public function getRevenueHistoricalData() {
		$this->db->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		//$this->db->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db->order_by('REVENUE_ID','desc');
		$browseSQL = $this->db->get('zrevenue_historical_data');	
		return $browseSQL->result();
	}

	public function getUsersHistoricalData() {
		$this->db->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db->order_by('USER_ID','desc');
		$browseSQL = $this->db->get('zusers_historical_data');	
		return $browseSQL->result();		
	}

	public function getCashflowHistoricalData() {
		$this->db->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db->order_by('CASHFLOW_ID','desc');
		$browseSQL = $this->db->get('zcashflow_historical_data');	
		return $browseSQL->result();		
	}
	
	public function getPromotionHistoricalData() {
		$this->db->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db->order_by('PROMOTION_ID','desc');
		$browseSQL = $this->db->get('zpromotion_historical_data');	
		return $browseSQL->result();		
	}

	public function getGamesHistoricalData() {
		$this->db->where('FK_PARTNER_ID',$this->session->userdata('partnerid'));
		$this->db->where('FK_ADMIN_USER_ID',$this->session->userdata('adminuserid'));
		$this->db->order_by('GAME_ID','desc');
		$browseSQL = $this->db->get('zgames_historical_data');	
		return $browseSQL->result();		
	}
	
}