<?php
class Bonus_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
		
	public function getBonusTypes() {
		$this->db2->where('STATUS',1);
		$this->db2->order_by('BONUS_TYPE_ID','asc');
		$browseSQL = $this->db2->get('bonus_types');
		//echo $this->db->last_query();die;
		return $browseSQL->result();		
	}
	
	public function getCoinTypes() {
		$this->db2->where('STATUS',1);
		$this->db2->order_by('COIN_TYPE_ID','asc');
		$browseSQL = $this->db2->get('coin_type');
		//echo $this->db->last_query();die;
		return $browseSQL->result();		
	}

	public function getBonusSettingsData($data) {
        $this->db2->select('t1.SETTINGS_ID,t2.NAME as bName,t3.NAME as cName,t1.VALUE,t1.STATUS')->from('bonus_settings t1');
		$this->db2->join('bonus_types t2', 't2.BONUS_TYPE_ID = t1.BONUS_TYPE_ID', 'left');
		$this->db2->join('coin_type t3', 't3.COIN_TYPE_ID = t1.COIN_TYPE_ID', 'left');		
				
		if(!empty($data["BONUS_TYPE_ID"]))
			$this->db2->where('t2.BONUS_TYPE_ID',$data["BONUS_TYPE_ID"]);		
		if(!empty($data["COIN_TYPE_ID"]))
			$this->db2->where('t3.COIN_TYPE_ID',$data["COIN_TYPE_ID"]);				
			
		$this->db2->order_by('t2.BONUS_TYPE_ID','asc');
		$browseSQL = $this->db2->get();
		//echo $this->db->last_query();die;
		return $browseSQL->result();		
	}
	
	public function addBonusInfo($addBonusData) {
		$browseSQL = $this->db->insert('bonus_settings',$addBonusData);	
		return $browseSQL->result;			
	}
			
}
?>