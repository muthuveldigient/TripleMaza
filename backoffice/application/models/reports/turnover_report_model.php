<?php
class Turnover_report_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	
	public function getMainAgentTurnover($data){ 
		
		$this->db3->select('MAIN_AGEN_ID as AGENT_ID,MAIN_AGEN_NAME as AGENT_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION');
		if(!empty($data["GAMES_TYPE"] ) ) {
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",unserialize(MOBILE_GAMES));
			}else if($data["GAMES_TYPE"] == 'mobile'){
				$this->db3->where_in("GAME_ID",unserialize(MOBILE_GAMES));
			}
		}
		
		if(!empty( $data["AGENT_LIST"] )) {
			$this->db3->where("MAIN_AGEN_ID",$data["AGENT_LIST"]);
		} 
		
		if(!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$this->db3->where("START_TIME between '".$data["START_DATE_TIME"]."' AND '".$data["END_DATE_TIME"]."'" );
		}
		
		if(!empty( $data["GROUP_BY"] )) {
			$this->db3->group_by($data["GROUP_BY"]);
		}else{
			$this->db3->group_by("MAIN_AGEN_ID");
		}

		$browseSQL = $this->db3->get('ymainagent_game_turn_over_history');
		//echo $this->db3->last_query(); die;
		$results  = $browseSQL->result();
		return $results;
	}
	
	public function getSuperDistributorTurnover($data){
		
		$this->db3->select('SUPERDISTRIBUTOR_ID as AGENT_ID,SUPERDISTRIBUTOR_NAME as AGENT_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION');
		if(!empty($data["GAMES_TYPE"] ) ) {
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",unserialize(MOBILE_GAMES));
			}else if($data["GAMES_TYPE"] == 'mobile'){
				$this->db3->where_in("GAME_ID",unserialize(MOBILE_GAMES));
			}
		}
		
		if(!empty( $data["AGENT_LIST"] )) {
			$this->db3->where("SUPERDISTRIBUTOR_ID",$data["AGENT_LIST"]);
		}

		if(!empty( $data["MAIN_AGEN_ID"] )) {
			//$this->db3->where("MAIN_AGEN_ID",$data["MAIN_AGEN_ID"]);
			$this->db3->where("SUPERDISTRIBUTOR_ID IN( select partner_id from partner where fk_partner_id =".$data["MAIN_AGEN_ID"]." AND fk_partner_type_id=15 )");
		}		
		
		if(!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$this->db3->where("START_TIME between '".$data["START_DATE_TIME"]."' AND '".$data["END_DATE_TIME"]."'" );
		}
		
		if(!empty( $data["GROUP_BY"] )) {
			$this->db3->group_by($data["GROUP_BY"]);
		}else{
			$this->db3->group_by("SUPERDISTRIBUTOR_ID");
		}
		
		$browseSQL = $this->db3->get('ysuperdistributor_game_turn_over_history');
		//echo $this->db3->last_query();exit;
		$results  = $browseSQL->result();
		return $results;
	}
	
	
	public function getDistributorTurnover($data){
		
		$this->db3->select('DISTRIBUTOR_ID as AGENT_ID,DISTRIBUTOR_NAME as AGENT_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION');
		if(!empty($data["GAMES_TYPE"] ) ) {
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",unserialize(MOBILE_GAMES));
			}else if($data["GAMES_TYPE"] == 'mobile'){
				$this->db3->where_in("GAME_ID",unserialize(MOBILE_GAMES));
			}
		}
		
		if(!empty( $data["AGENT_LIST"] )) {
			$this->db3->where("DISTRIBUTOR_ID",$data["AGENT_LIST"]);
		} 
		
		if(!empty( $data["SUPERDISTRIBUTOR_ID"] )) {
			//$this->db3->where("SUPERDISTRIBUTOR_ID",$data["SUPERDISTRIBUTOR_ID"]);
			$this->db3->where("DISTRIBUTOR_ID IN( select partner_id from partner where fk_partner_id =".$data["SUPERDISTRIBUTOR_ID"]." AND fk_partner_type_id=12 )");
		}
		
		if(!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$this->db3->where("START_TIME between '".$data["START_DATE_TIME"]."' AND '".$data["END_DATE_TIME"]."'" );
		}
		
		if(!empty( $data["GROUP_BY"] )) {
			$this->db3->group_by($data["GROUP_BY"]);
		}else{
			$this->db3->group_by("DISTRIBUTOR_ID");
		}
		$browseSQL = $this->db3->get('ydistributor_game_turn_over_history');
		$results  = $browseSQL->result();
		return $results;
	}
	
	public function getSubDistributorTurnover($data){
		
		$this->db3->select('SUBDISTRIBUTOR_ID as AGENT_ID,SUBDISTRIBUTOR_NAME as AGENT_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION');
		if(!empty($data["GAMES_TYPE"] ) ) {
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",unserialize(MOBILE_GAMES));
			}else if($data["GAMES_TYPE"] == 'mobile'){
				$this->db3->where_in("GAME_ID",unserialize(MOBILE_GAMES));
			}
		}
		
		if(!empty( $data["AGENT_LIST"] )) {
			$this->db3->where("SUBDISTRIBUTOR_ID",$data["AGENT_LIST"]);
		} 
		
		if(!empty( $data["DISTRIBUTOR_ID"] )) {
			//$this->db3->where("DISTRIBUTOR_ID",$data["DISTRIBUTOR_ID"]);
			$this->db3->where("SUBDISTRIBUTOR_ID IN( select partner_id from partner where fk_partner_id =".$data["DISTRIBUTOR_ID"]." AND fk_partner_type_id=13 )");
			
		}
		
		if(!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$this->db3->where("START_TIME between '".$data["START_DATE_TIME"]."' AND '".$data["END_DATE_TIME"]."'" );
		}
		
		if(!empty( $data["GROUP_BY"] )) {
			$this->db3->group_by($data["GROUP_BY"]);
		}else{
			$this->db3->group_by("SUBDISTRIBUTOR_ID");
		}

		$browseSQL = $this->db3->get('ysubdistributor_game_turn_over_history');
		$results  = $browseSQL->result();
		return $results;
	}
	
	public function getAgentTurnover($data){
		$this->db3->select('PARTNER_ID as AGENT_ID,PARTNER_NAME as AGENT_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION');
		if(!empty($data["GAMES_TYPE"] ) ) {
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",unserialize(MOBILE_GAMES));
			}else if($data["GAMES_TYPE"] == 'mobile'){
				$this->db3->where_in("GAME_ID",unserialize(MOBILE_GAMES));
			}
		}
		
		if(!empty( $data["AGENT_LIST"] )) {
			$this->db3->where("PARTNER_ID",$data["AGENT_LIST"]);
		} 
		if(!empty( $data["DISTRIBUTOR_ID"] )) {
			$this->db3->where("PARTNER_ID IN( select partner_id from partner where fk_partner_id =".$data["DISTRIBUTOR_ID"]." AND fk_partner_type_id=14 )");
		}
		if(!empty( $data["SUBDISTRIBUTOR_ID"] )) {
			//$this->db3->where("SUBDISTRIBUTOR_ID",$data["SUBDISTRIBUTOR_ID"]);
			$this->db3->where("PARTNER_ID IN( select partner_id from partner where fk_partner_id =".$data["SUBDISTRIBUTOR_ID"]." AND fk_partner_type_id=14 )");
		}
		if(!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$this->db3->where("START_TIME between '".$data["START_DATE_TIME"]."' AND '".$data["END_DATE_TIME"]."'" );
		}
		
		if(!empty( $data["GROUP_BY"] )) {
			$this->db3->group_by($data["GROUP_BY"]);
		}else{
			$this->db3->group_by("PARTNER_ID");
		}
		
		$browseSQL = $this->db3->get('yagent_game_turn_over_history');
		$results  = $browseSQL->result();
		//echo $this->db3->last_query();exit;
		return $results;
	}
	
	public function getUserTurnover($data){
		$this->db3->select('USER_ID,USER_NAME,GAME_ID,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET');
		if(!empty($data["GAMES_TYPE"] ) ) {
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",unserialize(MOBILE_GAMES));
			}else if($data["GAMES_TYPE"] == 'mobile'){
				$this->db3->where_in("GAME_ID",unserialize(MOBILE_GAMES));
			}
		}

		if(!empty( $data["AGENT_LIST"] )) {
			$this->db3->where("USER_ID",$data["AGENT_LIST"]);
		} 
		
		if(!empty( $data["PARTNER_ID"] )) {
			//$this->db3->where_in("USER_ID",$data["PARTNER_ID"]);
			$this->db3->where("USER_ID IN( select user_id from user where partner_id =".$data["PARTNER_ID"]." )");
		}

		if(!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"]) ) {
			$this->db3->where("START_TIME between '".$data["START_DATE_TIME"]."' AND '".$data["END_DATE_TIME"]."'" );
		}
		
		$this->db3->group_by("USER_ID");
		$browseSQL = $this->db3->get('yuser_turnover_history');
		$results  = $browseSQL->result();
		//echo $this->db3->last_query();exit;
		return $results;
	}
	
	public function getPartnerList($partner_type){
		$data=array();
		
		switch($partner_type){
			case 11: // Main agent.
				$data = array("Super Distributor"=>15,"Distributor"=>12,"Sub Distributor"=>13,"Agent"=>14);
				break;
			case 15: // Super Dis.
				$data = array("Distributor"=>12,"Sub Distributor"=>13,"Agent"=>14);
				break;
			case 12: // Distributor.
				$data = array("Sub Distributor"=>13,"Agent"=>14);
				break;
			case 13: // Sub Distributor.
				$data = array();
				break;
			case 14: // Agent.
				$data = array();
				break;
			case 0: // Agent.
				$data = array("Main Agent"=>11,"Super Distributor"=>15,"Distributor"=>12,"Sub Distributor"=>13,"Agent"=>14);
				break;
			default :
				$data = array();
				break;		
		}
		
		return $data;
	}
	
	public function getAGENTlist($partnerTypeId='', $partnerId='',$parentId='') {
		$this->db2->select('PARTNER_ID,PARTNER_USERNAME,FK_PARTNER_TYPE_ID');
		$this->db2->from('partner');
		$this->db2->where('PARTNER_STATUS',1);
		if(!empty($partnerTypeId)){
			$this->db2->where('FK_PARTNER_TYPE_ID',$partnerTypeId);
		}
		if(!empty($partnerId)){
			$this->db2->where('PARTNER_ID',$partnerId);
		}
		if(!empty($parentId)){
			$this->db2->where('FK_PARTNER_ID',$parentId);
		}
		$this->db2->where('PARTNER_ID !=',1);
		$this->db2->order_by('PARTNER_USERNAME', 'asc');
		$all_agent = $this->db2->get();
		$all_agent_result = $all_agent->result_array();
		//echo $this->db2->last_query();exit;
		return $all_agent_result;
	}
	
	public function getPartnerTypeName($partner_type){
		$data=array();
		
		switch($partner_type){
			case 11: // Main agent.
				$data = array("main"=>'Main Agent',"sub"=>'Super Distributor');
				break;
			case 15: // Super Dis.
				$data = array("main"=>'Super Distributor',"sub"=>'Distributor');
				break;
			case 12: // Distributor.
				$data = array("main"=>'Distributor',"sub"=>'Sub Distributor');
				break;
			case 13: // Sub Distributor.
				$data = array("main"=>'Sub Distributor',"sub"=>'Agent');
				break;
			case 14: // Agent.
				$data = array("main"=>'Agent',"sub"=>'User');
				break;
			case 0: // Admin.
				$data = array("main"=>'Admin',"sub"=>'Main Agent');
				break;
			default :
				$data = array();
				break;		
		}
		
		return $data;
	}
	
}
?>
