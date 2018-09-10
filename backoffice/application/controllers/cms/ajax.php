<?php
/*
  Class Name	: Ajax
  Package Name  : Poker
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
	        $this->load->helper('url');
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');
			$this->load->model('cms/cms_model');	
			
			//player model
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		
		//if needed
	}//EO: index function
	
	
	public function page(){
	   $pageId = $this->uri->segment(4, 0);
	   $pageInfo  = $this->cms_model->getPageInfoById($pageId);
	   
	   $pageTitle  = $pageInfo->STATIC_PAGE_TITLE;
	   $pageDesc   = $pageInfo->CONTENT_TEXT;
	   $htmlString  = "<div><p><b>".$pageTitle."</b></p>";
	   $htmlString .= "<p>".$pageDesc."</p>";
	   $htmlString .= "</div>";	   
	   echo $htmlString;
	   exit;
	}
	
	public function config(){
	  $configID = $this->uri->segment(4, 0);
	  $configInfo  = $this->cms_model->getConfigInfoById($configID);

	  $htmlString  = "<div><p><b>Change Config Value</b></p>";
	  $htmlString .= "<form method='post' action='".base_url()."cms/ajax/updateconfig'>";
	  $htmlString .= "<table><tr><td>";
	  $htmlString .= "<label>".$configInfo->KEY_NAME."</label>";	   
	  $htmlString .= "</td><td><input type='text' name='configval' value='".$configInfo->VALUE."'>";	   
	  $htmlString .= "<input type='hidden' name='configid' value='".$configInfo->CONFIG_ID."'></td></tr><tr><td></td><td><input type='submit' name='submit' value='Submit'></td></tr></table>";	   	   
	  $htmlString .= "</form>";	   
	  $htmlString .= "</div>";	   
	  
	  echo $htmlString;
	  exit;
	}
	
	public function updateconfig(){
		$formdata = array();
		$formdata['value'] = $_POST['configval']; 
		$formdata['id'] = $_POST['configid']; 
		$updatePage = $this->cms_model->updateConfig($formdata);	
		if($updatePage  == 1){
		 	echo "Updated Successfully";
		}		
		
	}
	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */