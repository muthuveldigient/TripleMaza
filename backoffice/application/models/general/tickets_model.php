<?php
class Tickets_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}

	public function getUserTickets($data) {
		$browseSQL = $this->db2->get("reporting_issue");
		//echo $this->db->last_query();die;
		return $browseSQL->result();		
	}
}
?>