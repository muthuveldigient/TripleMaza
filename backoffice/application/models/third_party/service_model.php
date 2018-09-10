<?php
/*
  Class Name	: Cakewalk_model
  Package Name  : CakeWalk Service
  Purpose       : Handle all the web services related to Agent -> Agent
  Auther 		: Azeem
  Date of create: Aug 02 2013
*/
class Service_model extends CI_Model
{

	function createUser($postData,$user_id){

	    //echo json_encode($postData);
		$USERNAME 		= $postData['USERNAME'];
		$EMAIL 			= $postData['EMAIL'];
		$PASSWORD 		= $postData['PASSWORD'];
		$PARTNER_COUNTRY= str_replace("+","",$postData['PARTNER_COUNTRY']);
		$PARTNER_COUNTRY= str_replace(" ","",$postData['PARTNER_COUNTRY']);
		$MOBILE 		= $postData['MOBILE'];
		$TYPE  			= 1;
		$SITE_ID        = 20;
		$POSTAL_CODE    = '123456';


		$request2='{"UserName":"'.$USERNAME.'","Email":"'.$EMAIL.'","Password":"'.$PASSWORD.'","Permanent_Address":"","Resi_address":"","MobileNo":"","Postal_Code":"'.$POSTAL_CODE.'","State":"","City":"","Country":"'.$PARTNER_COUNTRY.'","Type":"'.$TYPE.'","AgentId":"","SiteId":"'.$SITE_ID.'"}';

	    //get url
		$service_url = $this->getServiceURL('createUser');
		$register    = $this->serviceConnectivity($service_url,$request2);

		//insert the response into local database
		$response  = $register["Result"];
		print_r($register); exit;
		if($response != ''){
			if($response == 'UserName exist'){
			  $returnvalue = 'exist';
			}else{
			  $this->insertINTOLocalDB($user_id,$SITE_ID,$response);
			 $returnvalue = 'success';
			}
		}

		return $returnvalue;
	}

	function getAllUsersBySite($site_id){
	 	$urlTemplate  = $this->getServiceURL('siteUsers');
		$serviceURL   = str_replace("{SiteId}",$site_id,$urlTemplate);

	  	$allUserInfos = $this->getWebService($serviceURL);
	}

	function getUserInformation($user_id){

		$serviceId = $this->getUserServiceId($userid);
		$urlTemplate  = $this->getServiceURL('userInfo');
		$serviceURL   = str_replace("{UserId}",$serviceId,$urlTemplate);

	  	$allUserInfos = $this->getWebService($serviceURL);
	}


	function updateUser($userid){
	    $serviceId = $this->getUserServiceId($userid);
		if($serviceId != ''){
		$urlTemplate  = $this->getServiceURL('updateUser');
		$serviceURL   = str_replace("{UserId}",$serviceUserId,$urlTemplate);

		 $request2='{"Permanent_Address":"'.$address1.'","Resi_address":"'.$address2.'","MobileNo":"'.$mobile.'","Postal_Code":"'.$pincode.'","State":"'.$stage.'","City":"'.$city.'","Country":'.$country.'"","Type":"1","AgentId":"","SiteId":"20"}';
		 //update record in webserver
		 $this->updateWebServer($serviceURL,$request2);
		}
	}

	function sendMailToUser($serviceUserId,$subject,$message,$cc,$bcc){
		$urlTemplate  = $this->getServiceURL('sendEmailToUser');
		$serviceURL   = str_replace("{UserId}",$serviceUserId,$urlTemplate);

		$request2    = '{"Subject":"'.$subject.'","CC":"'.$cc.'","BCC":"'.$bcc.'","Body":"'.$message.'"}';
		$registerMail= $this->serviceConnectivity($service_url,$request2);
	}

	function changeEmailAddress($userid,$newemail){
		$serviceId = $this->getUserServiceId($userid);
		if($serviceId != 'err'){
			 $urlTemplate  = $this->getServiceURL('changeEmail');
			 $serviceURL   = str_replace("{UserId}",$serviceId,$urlTemplate);
			 $request2='{"email":"'.$newEmail.'"}';
			 //update record in webserver
			 $this->updateWebServer($serviceURL,$request2);
		}
	}

	function changePassword($userid,$newpassword){
		$serviceId = $this->getUserServiceId($userid);
		if($serviceId != 'err'){
			 $urlTemplate  = $this->getServiceURL('changePassword');
			 $serviceURL   = str_replace("{UserId}",$serviceId,$urlTemplate);
			 $request2='{"password":"'.$newpassword.'"}';
			 //update record in webserver
			 $this->updateWebServer($serviceURL,$request2);
		}
	}

	function getUserServiceId($user_id){
	//echo $user_id;
		$query  = $this->db2->query("SELECT * FROM webservice_info WHERE USER_ID ='".$user_id."' Limit 1");
		$result = $query->row();
		$response = $result->WEBSERVICE_RESPONSE;

		$explode  = explode(" :- ",$response);
		$serviceId = $explode[1];
	    if($serviceId != ''){
		  return $serviceId;
		}else{
		  return 'err';
		}
	}


	function getServiceURL($service_token){

	  switch ($service_token) {
		case 'createSite':
			$serviceURL = WEBSITE;
			break;
		case 'siteUsers':
			$serviceURL = WEBSITE.'/{SiteId}';
			break;
		case 'createUser':
			$serviceURL = USER;
			break;
		case 'userInfo':
			$serviceURL = USER.'/{UserId}';
			break;
		case 'userInfoUsername':
		    $serviceURL = USER.'/{UserName}';
			break;
		case 'updateUser':
			$serviceURL = USER.'/{UserId}';
			break;
		case 'checkAuthorized':
			$serviceURL = USER.'/{UserId}/{Password} ';
			break;
		case 'createAgent':
			$serviceURL = AGENT;
			break;
		case 'agentUsers':
			$serviceURL = AGENT.'/{AgentId}';
			break;
		case 'deleteUsers':
			$serviceURL = AGENT.'/{AgentId}';
			break;
		case 'sendEmailToUsers':
			$serviceURL = SITEEMAIL.'/{SiteId}';
			break;
		case 'sendEmailToUser':
			$serviceURL = USERMAIL.'/{UserId}';
			break;
		case 'sendSMSToUsers':
			$serviceURL = SITESMS.'/{SiteId}';
			break;
		case 'sendSMSToUser':
			$serviceURL = USERSMS.'/{UserId}';
			break;
		case 'changeEmail':
			$serviceURL = CHANGEEMAIL.'/{UserId}';
			break;
		case 'changePassword':
			$serviceURL = CHANGEPASSWORD.'/{UserId}';
			break;
		case 'userLogin':
			$serviceURL = USER.'/{UserName}/{Password}';
			break;


		}

	   return $serviceURL;
	}

	function insertINTOLocalDB($user_id,$site_id,$response){
	  //insertion for local database
	  $sql_service = "insert into webservice_info(SITE_ID,USER_ID,WEBSERVICE_RESPONSE)values('".$site_id."','".$user_id."','".$response."')";
      $this->db->query($sql_service);
	}

	/* New Functions */
	function generateHashKey($username,$password){
	  $hashString = HASHSTRING;
	  $concate    = $hashString.$username.$password;
	  $hashKey    = md5($concate);
	  return $hashKey;
	}

	function checklogin($username,$password){
		$urlTemplate  = $this->getServiceURL('userLogin');
		$serviceURL   = str_replace("{UserName}",$username,$urlTemplate);
		$serviceURL   = str_replace("{Password}",$password,$serviceURL);
	  	$resultValue = $this->getWebService($serviceURL);

	    return $resultValue;
	}

	function checkLocalDB($username,$password=''){
	    if($password != ''){
		   $query  = $this->db2->query("SELECT USER_ID FROM user WHERE USERNAME ='".$username."' and PASSWORD = '".md5($password)."' Limit 1");
		}else{
	    	$query  = $this->db2->query("SELECT USER_ID FROM user WHERE USERNAME ='".$username."' Limit 1");
		}
		$result = $query->row();
		$response = $result->USER_ID;
		if($response != ''){
		 $returnValue = 'true';
		}else{
		 $returnValue = 'false';
		}
		return $returnValue;
	}

	function fetchUserInfoByUsername($username){
		$urlTemplate  = $this->getServiceURL('userInfoUsername');
		$serviceURL   = str_replace("{UserName}",$username,$urlTemplate);
	  	$allUserInfos = $this->getWebService($serviceURL);
		return $allUserInfos;

	}

	function registerLocalDB($data,$amount='0.00'){

		  if($data['PARTNER_ID']){

			$browseSQL = $this->db->query("INSERT INTO `user` (`USERNAME`, `PASSWORD`, `EMAIL_ID`, `PARTNER_ID`, `COUNTRY`, `STREET`, `STATE`, `CITY`, `REGISTRATION_TIMESTAMP`, `ACCOUNT_STATUS`) VALUES ('".$data['USERNAME']."','".$data['PASSWORD']."','',".$data['PARTNER_ID'].", '".$data['COUNTRY']."','".$data['STREET']."','".$data['STATE']."','".$data['CITY']."','".$data['REGISTRATION_TIMESTAMP']."',".$data['ACCOUNT_STATUS'].")");
			$userid=$this->db->insert_id();

			$udata['COIN_TYPE_ID'] =1;
			$udata['USER_ID'] = $userid;
			$udata['VALUE'] =  '';
			$udata['USER_DEPOSIT_BALANCE'] = $amount;
			$udata['USER_TOT_BALANCE'] = $amount;
			$this->db->query("INSERT INTO `user_points` (`COIN_TYPE_ID`, `USER_ID`) VALUES (1,".$userid.")");
		  }

	}

	function getLocalUserInfo($username){
	  	$query  = $this->db2->query("select * from user where USERNAME = '$username'");  
		$result = $query->row();
		return $result;
	}

    /* E0: New Functions */


	function serviceConnectivity($URL2,$request2){

		$ch2 = curl_init($URL2);
		curl_setopt($ch2, CURLOPT_MUTE, 1);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $request2);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		$response2 = curl_exec($ch2);
		curl_close($ch2);
		$dresponse2=json_decode(trim($response2),true);
		return $dresponse2;
	}

	function updateWebServer($URL2,$request2){
	 	$curl = curl_init($URL2);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($curl, CURLOPT_POSTFIELDS,$request2);

		// Make the REST call, returning the result
		$response = curl_exec($curl);
		$dresponse2=json_decode(trim($response),true);
	}

	function getWebService($URL2){
		$ch2 = curl_init($URL2);
		curl_setopt($ch2, CURLOPT_MUTE, 1);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch2, CURLOPT_HTTPGET, 1);
		curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		$response2 = curl_exec($ch2);

		curl_close($ch2);
		$dresponse2=json_decode(trim($response2),true);
		return $dresponse2;
	}


}
?>
