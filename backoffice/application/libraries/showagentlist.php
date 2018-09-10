<?php
class Showagentlist extends CI_Model
{
    public function index(){
        
       $this->load->database();
       $allmagentlist="";
	   
       if(isset($this->session->userdata['ADMIN_USER_ID'])){
	   
		   if($this->session->userdata['ADMIN_USER_ID']==1){
			$allmagentlist='';
			$mainagentlist = $this->db->query("select PARTNER_ID from partner where IS_OWN_PARTNER=1");
			
				if($mainagentlist){
				foreach ($mainagentlist->result() as $row){ 
				if($allmagentlist){
					$allmagentlist=$allmagentlist.",".$row->PARTNER_ID;
				}else{
					$allmagentlist=$row->PARTNER_ID;
				}
				}
				}
			if($allmagentlist){
			$allmagentlist=$allmagentlist;
			}	
			else{
			$allmagentlist=-1;
			}
			$distriblist = $this->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$allmagentlist.')');
	
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
		}
		else{
		$allmagentlist=$this->session->userdata['MAIN_AGENT_IDS'];
		if($allmagentlist){
		$allmagentlist=$allmagentlist;
		}
		else{
		$allmagentlist=-1;
		}
			$distriblist = $this->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$allmagentlist.')');
	
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
		}
		if($alldistlist){
		$alldistlist=$alldistlist;
		}
		else{
		$alldistlist=-1;
		}
				
		$records = $this->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$alldistlist.') and IS_DISTRIBUTOR=0');

      // echo $this->db->last_query();
       $listdist="<select name='affiliateid' id='affiliateid' class='ListMenu'><option value='all'>all</option>";
       
       if($records){
           foreach ($records->result() as $row){ 
               if(isset($_REQUEST['affiliateid']) && $_REQUEST['affiliateid']==$row->PARTNER_ID){ 
                   $listdist=$listdist."<option value=".$row->PARTNER_ID." selected >".$row->PARTNER_USERNAME."</option>";
               }else{
                   $listdist=$listdist."<option value=".$row->PARTNER_ID." >".$row->PARTNER_USERNAME."</option>";
               }
           
           } 
           $listdist=$listdist."</select>";
           
       
           return $listdist;
       }
	   
	   }else{
   
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
    $alldistlist='';
    if($dist_records){
        foreach ($dist_records->result() as $row){ 
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
   
       $records = $this->db->query('select PARTNER_ID,PARTNER_USERNAME  from partner where FK_PARTNER_ID in('.$alldistlist.') and IS_DISTRIBUTOR=0');
       
      // echo $this->db->last_query();
       $listdist="<select name='affiliateid' id='affiliateid' class='ListMenu'><option value='all'>all</option>";
       
       if($records){
           foreach ($records->result() as $row){
               if(isset($_REQUEST['affiliateid']) && $_REQUEST['affiliateid']==$row->PARTNER_ID){
                $listdist=$listdist."<option value=".$row->PARTNER_ID." selected>".$row->PARTNER_USERNAME."</option>";
               }else{
                $listdist=$listdist."<option value=".$row->PARTNER_ID.">".$row->PARTNER_USERNAME."</option>";   
               }
           } 
           $listdist=$listdist."</select>";
           
       
           return $listdist;
       }
    }
	}
}