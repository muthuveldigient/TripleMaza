<?php
class Showagents extends CI_Model
{
    public function index(){
        
       $this->load->database();
	   
    $alldistlist="";
	$allmainagents='';
	$allpartnedids='';
	 if(isset($this->session->userdata['ADMIN_USER_ID'])){
	 if($this->session->userdata['ADMIN_USER_ID']==1){
		$sql_allmainagents=$this->db->query("select PARTNER_ID from partner where IS_OWN_PARTNER=1");
			foreach($sql_allmainagents->result() as $row_allmainagents){
				if($allmainagents){
				$allmainagents=$allmainagents.",".$row_allmainagents->PARTNER_ID;
				}else{
				$allmainagents=$row_allmainagents->PARTNER_ID;
				}
			}
		}
		else{
			$allmainagents=$this->session->userdata['MAIN_AGENT_IDS'];
			if($allmainagents){
			$allmainagents=$allmainagents;
			}
			else{
			$allmainagents=-1;
			}
		}
		
		$records=$this->db->query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID in(".$allmainagents.") and IS_DISTRIBUTOR=1");
		
		$listdist="<select name='affiliateid' id='affiliateid' class='ListMenu'><option value='all'>all</option>";
       if(isset($records)){
           foreach ($records->result() as $row){ 
           $listdist=$listdist."<option value=".$row->PARTNER_ID.">".$row->PARTNER_USERNAME."</option>";
           } 
           $listdist=$listdist."</select>";
       
           return $listdist;
       	}
	   
	   }
	   else{
    if($this->session->userdata('isownpartner')){
        $this->db->select('PARTNER_ID');
        $this->db->where('FK_PARTNER_ID', $this->session->userdata('partnerid'));
        $this->db->where('IS_DISTRIBUTOR', "1");
    }else{
        $this->db->select('PARTNER_ID');
        $this->db->where('PARTNER_ID', $this->session->userdata('partnerid'));
        $this->db->where('IS_DISTRIBUTOR', "1");
    }
    
    $dist_records = $this->db->get('partner');
    
    
    if($dist_records){
        foreach ($dist_records->result() as $row){ 
            if($alldistlist){
                $alldistlist=$alldistlist.",".$row->PARTNER_ID;
            }else{
                $alldistlist=$row->PARTNER_ID;
            }
        }
    }
    
    
    
       $records = $this->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$alldistlist.') and IS_DISTRIBUTOR=0');
       
      // echo $this->db->last_query();
       $listdist="<select name='affiliateid' id='affiliateid' class='ListMenu'><option value='all'>all</option>";
       
       if($records){
           foreach ($records->result() as $row){ 
           $listdist=$listdist."<option value=".$row->PARTNER_ID.">".$row->PARTNER_USERNAME."</option>";
           } 
           $listdist=$listdist."</select>";
           
       
           return $listdist;
       }
	  }
    }
    
    public function userlist()
    {
        $sql_agentslist=$this->db->query("select USERNAME from user where PARTNER_ID =".$this->session->userdata('partnerid')." order by USERNAME");
        foreach($sql_agentslist->result() as $row_agentslist){
            echo "<option value='".$row_agentslist->USERNAME."'>".$row_agentslist->USERNAME."</option>";
        }
    }
 public function mainagentlist(){
        $records = $this->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where PARTNER_ID in('.$this->session->userdata['MAIN_AGENT_IDS'].') and IS_DISTRIBUTOR=0');
       if($records){
           foreach ($records->result() as $row){ 
           $listdist=$listdist."<option value=".$row->PARTNER_ID.">".$row->PARTNER_USERNAME."</option>";
           } 
           return $listdist;
       }
 }   
}