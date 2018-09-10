<?php error_reporting(0);
/*------------------------------------------------------------------------
# Webservice.php - this service handle the cakewalk login process
# ------------------------------------------------------------------------
# author    Azeem 
# copyright Copyright (C) 2014 digient.in. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.digient.in
-------------------------------------------------------------------------*/
// no direct access
//defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webservice extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$CI = &get_instance();
   		$this->db2 = $CI->load->database('db2', TRUE);
		$this->db3 = $CI->load->database('db3', TRUE);
		$this->load->model('user/Account_model'); 
		$this->load->model('third_party/service_model');  
	}
	
	


	function call(){
	 
	  $username  = $_REQUEST['username'];
	  $password  = $_REQUEST['password'];
	  $hash      = $_REQUEST['hash'];
	  //GET HASK KEY
	  $hashKey = $this->service_model->generateHashKey($username,$password);
	 
	  if($hashKey == $hash){// if hash is true
  
		 //check login in cakewalk server
		 $statusInfo = $this->service_model->checklogin($username,$password);
	
		
		 if(isset($statusInfo['UserName']) && $statusInfo['UserName'] != '' )
         {
		 
		   //check in our DB
		   $localstatus = $this->service_model->checkLocalDB($username);
		   
		   if($localstatus == 'false'){
			 //post data
			 $postData['USERNAME'] 		= $statusInfo['UserName'];
			 $postData['PASSWORD'] 		= md5(CAKEWALK_PASSWORD);
			 $postData["EMAIL_ID"]   	= "";    
			 $postData["PARTNER_ID"] 	= CAKEWALK_PARTNERID;  
			 $postData['COUNTRY'] 		= $statusInfo['Country'];
			 //$postData['Postal_Code'] 	= $cakeWalkUserInfo[0]['Postal_Code'];
			 $postData['STREET'] 		= $statusInfo['Permanent_Address'];
			 $postData['STATE'] 		= $statusInfo['State'];
			 $postData['CITY'] 			= $statusInfo['City'];
			 $postData["REGISTRATION_TIMESTAMP"]  = date('Y-m-d h:i:s'); 
  			 $postData["ACCOUNT_STATUS"]   = 1;
			 
			 
			 //create account in our database
			 $localstatus = $this->service_model->registerLocalDB($postData);
			 $returnMsg = 'success';
		   }else{
		     $returnMsg = 'success';
		   }
		 }else{// cakewalk login false
		
		   //check in our local database
		   $localstatus = $this->service_model->checkLocalDB($username,$password);
		  
		   if($localstatus == 'true'){	    
			
			 //fethc user databse and register in calkwalk db
			 $userInfo = $this->service_model->getLocalUserInfo($username,$password);
			
			
			 //prepare data
			 $postData['USERNAME'] = $username;
			 $postData['PASSWORD'] = $password;
			 $postData['EMAIL']    = $userInfo->EMAIL_ID;
			 $postData['PARTNER_COUNTRY'] = $userInfo->COUNTRY;
			 $postData['MOBILE'] = $userInfo->MOBILE;
			

			 $insertcake = $this->service_model->createUser($postData);
			 if($insertcake == 'exist'){
			  $returnMsg  = 'username already exists';
			 }else{			 
			   $returnMsg  = 'success';
			 }
		   }else{
		     $returnMsg = 'failed';
		   }
		 } // E0: cakewalk checking
	  }else{
	     $returnMsg = 'hash-failed';	  
	  } // E0: Hash checking
	  echo $returnMsg; exit;
	  return $returnMsg;
	  
	} // E0: function
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */