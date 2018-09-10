<?php
//error_reporting(E_ALL);
/*
  Class Name	: Setting_model
  Package Name  : User
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class Setting_model extends CI_Model {

	public function getServerSettings() {
		$this->db->where('DEFAULT_SETTINGS_ID',3);
		$this->db->where('KEY_VALUE','SEVER_SHUTDOWN');		
		$browserSQL=$this->db->get('default_settings');
		return $browserSQL->result();
	}
	
	public function updateServerSettings($updateData) {		
		try {
			$this->db->where('DEFAULT_SETTINGS_ID',3);
			$this->db->where('KEY_VALUE','SEVER_SHUTDOWN');		
			$result =$this->db->update('default_settings', $updateData);			
			//$result =$this->db->affected_rows();
			if(empty($result) || $result<=0) {
				throw new Exception('update failed');
			}
			return $result;
		} catch (Exception $e) {
			//$result =$e->getMessage();
			return;
		}
	}
	 
}