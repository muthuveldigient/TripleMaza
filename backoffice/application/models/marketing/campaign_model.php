<?php
//error_reporting(E_ALL);
/*
  Class Name	: Campaign_model
  Package Name  : Marketing
  Purpose       : Handle all the database services related to Campaign Creation
  Auther 	    : Arun
  Date of create: Sep 19 2013
*/
class Campaign_Model extends CI_Model
{
   	function unsetUserSession(){
		$this->session->unset_userdata('CAMPAIGNTYPE');
		$this->session->unset_userdata('PARTNERNAME');
		$this->session->unset_userdata('CAMPAIGNNAME');
		$this->session->unset_userdata('CAMPAIGNCODE');
		$this->session->unset_userdata('GETURL');
		$this->session->unset_userdata('CAMPAIGNDESCRIPTION');
		$this->session->unset_userdata('STATUS');
		$this->session->unset_userdata('FROM');
		$this->session->unset_userdata('TO');
	}
        
	function setUserSession($formdata){
		 $this->session->set_userdata('CAMPAIGNTYPE', $formdata['CAMPAIGNTYPE']);
		 $this->session->set_userdata('PARTNERNAME', $formdata['PARTNERNAME']);
		 $this->session->set_userdata('CAMPAIGNNAME', $formdata['CAMPAIGNNAME']);
		 $this->session->set_userdata('CAMPAIGNCODE', $formdata['CAMPAIGNCODE']);
		 $this->session->set_userdata('GETURL', $formdata['GETURL']);
		 $this->session->set_userdata('CAMPAIGNDESCRIPTION', $formdata['CAMPAIGNDESCRIPTION']);
		 $this->session->set_userdata('STATUS', $formdata['STATUS']);
		 $this->session->set_userdata('FROM', $formdata['FROM']);
		 $this->session->set_userdata('TO', $formdata['TO']);
	}
        
        
        
        
}