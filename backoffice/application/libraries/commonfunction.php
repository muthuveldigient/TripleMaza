<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class commonfunction{
	private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database(); 
        
    }

	public function get_commission_type(){
	$query_cam_type = "SELECT AGENT_COMMISSION_TYPE_ID,AGENT_COMMISSION_TYPE FROM agent_commission_type ORDER BY AGENT_COMMISSION_TYPE_ID ASC";
	$query=$this->CI->db->query($query_cam_type);
	return $query->result();
	}

	public function get_distributer($userdata){
		if(isset($userdata['ADMIN_USER_ID'])){
			$sql_distributors="select PARTNER_ID,PARTNER_USERNAME from partner where PARTNER_ID IN(".$userdata['MAIN_AGENT_IDS'].") and IS_DISTRIBUTOR=1 order by PARTNER_USERNAME";
		}
		else{
			if($userdata['isdistributor']!="1"){
				$sql_distributors="select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$userdata['partnerid']."' and IS_DISTRIBUTOR=1 order by PARTNER_USERNAME";
		}
		else{
		$sql_distributors="select PARTNER_ID,PARTNER_USERNAME from partner where PARTNER_ID='".$userdata['partnerid']."'";
		}
		}
		$query=$this->CI->db->query($sql_distributors);
		return $query->result();
	}


public function get_lc_commission_type(){
	$query_cam_type = "SELECT AGENT_COMMISSION_TYPE_ID,AGENT_COMMISSION_TYPE FROM agent_commission_type ORDER BY AGENT_COMMISSION_TYPE_ID ASC";
	$query=$this->CI->db->query($query_cam_type);
	return $query->result();
}

public function get_country(){
	$sel_country="select CountryName from countries where CountryName='India'";
	$query=$this->CI->db->query($sel_country);
	return $query->result();
}
public function get_state(){
	$sel_state="select StateName from state order by StateName";
	$query=$this->CI->db->query($sel_state);
	return $query->result();
}

public function object2array($result)
{
    $array = array();
    foreach ($result as $key=>$value)
    {
        if (is_object($value))
        {
            foreach($value as $key=>$val){
			$array[$key]=$value->$key;
			}
        }
    }
    return $array;
}

public function customobjecttoarray($Inputarray){
foreach($Inputarray as $key=>$rows){
$row[$key]=$rows; 
}
foreach($row as $key1=>$value){
if (is_object($value))
{
	foreach($value as $key=>$val){
	$outputarray[$key1][$key]=$value->$key;
	}
}
}
return $outputarray;
}

public function get_agentlist($userdata)
{
	//print_r($userdata);
   if($userdata['isownpartner']==1 || $userdata['isdistributor']==1){
    $sql_agent=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where STATUS='1' and FK_PARTNER_ID='".$userdata['partnerid']."' and PARTNER_ID!=1 order by PARTNER_USERNAME");
    }
    else{
    $sql_agent=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where STATUS='1' and PARTNER_ID!=1 order by PARTNER_USERNAME");
    }
	
    return $sql_agent->result();
}

public function get_fkpartner($userdata){
		if(isset($userdata['ADMIN_USER_ID'])){
		$sql_udist=$this->CI->db->query("select FK_PARTNER_ID from partner where PARTNER_ID='".$userdata['MAIN_AGENT_IDS']."'");
		}
		else{
		$sql_udist=$this->CI->db->query("select FK_PARTNER_ID from partner where PARTNER_ID='".$userdata['partnerid']."'");
	}
	return $this->object2array($sql_udist->result());
}
public function get_gamelist(){
	$sql_udist=$this->CI->db->query("SELECT * FROM minigames WHERE STATUS=1 ORDER BY MINIGAMES_ID ASC");
	return $sql_udist->result();
}

public function get_gameagentlist($userdata){

      if(isset( $userdata['ADMIN_USER_ID'])){
	   	  $adminuserid = $userdata['ADMIN_USER_ID'];
	  }else{
	      $adminuserid = '';
	  }
	  if($adminuserid != ''){
	    $allpartnedids =$userdata['MAIN_AGENT_IDS'];
	  }else{
	    $partnerlist=$this->get_agentlist($userdata);
		if(is_array($partnerlist) && count($partnerlist)>0){
		foreach($partnerlist as $val){
			$partnedids[]=$val->PARTNER_ID;
			}
		}
		if(!empty($partnedids)){
		$allpartnedids=implode(",",$partnedids);
		}
		else{
		$allpartnedids=-1;
		}
	  }
	  
	  
        if((isset($userdata['isownpartner']) && $userdata['isownpartner'] && $userdata['isownpartner']=="1")){
		    $sql_subagents=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID in(".$allpartnedids.") order by PARTNER_USERNAME");
        
		}else if(isset($userdata['ADMIN_USER_ID']) && $userdata['ADMIN_USER_ID'] != ''){
		 $distriblist = $this->CI->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$allpartnedids.')');

			$alldistlist='';
				if($distriblist){
					foreach ($distriblist->result() as $row){ 
						if($alldistlist){
						$alldistlist=$alldistlist.",".$row->PARTNER_ID;
						}else{
						$alldistlist=$row->PARTNER_ID;
						}
					}
				}
				if($alldistlist){
				$alldistlist=$alldistlist;
				}
				else{
				$alldistlist=-1;
				}
		$sql_subagents = $this->CI->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$alldistlist.') and IS_DISTRIBUTOR=0');
		   
		   
		
		}else{	
	    	$sql_subagents=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$userdata['partnerid']."' order by PARTNER_USERNAME");    
        }
		
		
	return $sql_subagents->result();
}

public function get_mainpartnerlist($userdata){
	$sql_agent=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where STATUS='1' and FK_PARTNER_ID='".$userdata."' and PARTNER_ID!=1");
	return $sql_agent->result();
}

public function get_partnerlist($userdata){
if(isset($userdata['ADMIN_USER_ID'])){

}
elseif($userdata['isownpartner']=='1'){
			$sql_agent=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where STATUS='1' and FK_PARTNER_ID='".$userdata['partnerid']."' and PARTNER_ID!=1");
			return $sql_agent->result();
}
}
public function get_affiliate($userdata,$data){
$allpartnedids="";
if(isset($userdata['ADMIN_USER_ID'])){
   $allpartnedids=$userdata['MAIN_AGENT_IDS'];
}
elseif(isset($userdata['isownpartner']) && $userdata['isownpartner']=="1"){
  $sql_alldistributors=$this->CI->db->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$userdata['partnerid']."'");  
  foreach($sql_alldistributors->result() as $row_alldistributors){
      if($allpartnedids){
            $allpartnedids=$allpartnedids.",".$row_alldistributors->PARTNER_ID;
      }else{
            $allpartnedids=$row_alldistributors->PARTNER_ID;    
      }
      #All agents
      $sql_allagents=$this->CI->db->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$row_alldistributors->PARTNER_ID."'");  
      foreach($sql_allagents->result() as $row_allagents){
            if($allpartnedids){
            $allpartnedids=$allpartnedids.",".$row_allagents->PARTNER_ID;
            }else{
            $allpartnedids=$row_allagents->PARTNER_ID;    
            }        
      }
  }  
}elseif(isset($userdata['isdistributor']) && $userdata['isdistributor']=="1"){
  $sql_allagents=$this->CI->db->query("select PARTNER_ID from partner where FK_PARTNER_ID='".$userdata['partnerid']."'");
  foreach($sql_allagents->result() as $row_allagents){
        if($allpartnedids){
        $allpartnedids=$allpartnedids.",".$row_allagents->PARTNER_ID;
        }else{
        $allpartnedids=$row_allagents->PARTNER_ID;    
        }        
  }
}else{
    $allpartnedids=isset($userdata['partnerid'])?$userdata['partnerid']:'';
}

if(isset($userdata['isownpartner']) && $userdata['isownpartner']=="1" || isset($userdata['isdistributor']) && $userdata['isdistributor']=="1"){
    if($allpartnedids){
       $allpartnedids=$allpartnedids.",".$userdata['partnerid'];
    }else{
        $allpartnedids=$userdata['partnerid'];
    }
}

if($allpartnedids==""){
    $allpartnedids="-1";
}
	if(isset($userdata['ADMIN_USER_ID'])){
	$sql_subagents=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where PARTNER_ID in(".$allpartnedids.")");
	}
	elseif(isset($userdata['isownpartner']) && $userdata['isownpartner']=="1" || isset($userdata['isdistributor']) && $userdata['isdistributor']=="1"){
	$sql_subagents=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where PARTNER_ID in(".$allpartnedids.")");
	}else{
	$sql_subagents=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$userdata['partnerid']."'");
	}
return 	$sql_subagents->result();
}

public function get_allagentlist($partid)
{
	if($partid!=''){
    $sql_agent=$this->CI->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID in(".$partid.")");
    return $sql_agent->result();
	}
}

public function check_madjust_message($USERNAME,$calc='')
{
   // echo "select IS_OWN_PARTNER,IS_DISTRIBUTOR from user u,partner p where u.PARTNER_ID=p.PARTNER_ID and u.USERNAME='".$USERNAME."'";
    $sqluserpartner=$this->CI->db->query("select IS_OWN_PARTNER,IS_DISTRIBUTOR from user u,partner p where u.PARTNER_ID=p.PARTNER_ID and u.USERNAME='".$USERNAME."'");
    $rowuserpartner=$sqluserpartner->row();
    if(!empty($rowuserpartner)){
    if($calc=="Add"){
            if($rowuserpartner->IS_OWN_PARTNER=="1" || $rowuserpartner->IS_DISTRIBUTOR=="1"){
                $msg="Amount exceeds agent's available balance";
            }else{ 
                $msg="Amount exceeds distributor's available balance";
            }
    }else{
            if($rowuserpartner->IS_OWN_PARTNER=="1" || $rowuserpartner->IS_DISTRIBUTOR=="1"){
                $msg="Amount exceeds distributor's available balance";
            }else{ 
                $msg="Amount exceeds user's available balance";
            }
    }
    }else{
        $msg="Amount exceeds distributor's available balance";
    }
    return $msg;
}

}

?>