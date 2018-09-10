<?php
class Deactiveuser extends CI_Model
{
    public function index($userID,$desc){
       $this->load->database();
       $selQry = $this->db->query("SELECT USERNAME FROM user WHERE USER_ID = '".$userID."'"); 
       $resQry = $selQry->row();
		
		$ss = $this->db->query("INSERT INTO `exclude_players` (`USER_ID`,`USERNAME`,`DESCRIPTION`,`ADMIN_USER_ID`,`DATE`) 
		VALUES ('".$userID."','".$row->USERNAME."','".$desc."','1',now())");
		if($ss)
			echo 'Description Saved';
    }   
}