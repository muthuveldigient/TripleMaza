<?php
/*
  Class Name	: General_model
  Package Name  : General
  Purpose       : Handle all the common database functions
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class General_model extends CI_Model
{

	public function getTotSecurityItemsCount(){
	    $numGames = $this->db2->->count_all_results('tracking');
	    return $numGames;
	}

	
	public function getAllSecurityItems($limit,$start){
	
	   $query			 = $this->db2->->query("select * from tracking limit $start,$limit");
	   $pageInfo		 = $query->result();
	   return $pageInfo;
	}
	

}