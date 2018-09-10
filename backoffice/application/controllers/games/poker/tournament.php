<?php //error_reporting(E_ALL);
/*
  Class Name	: Tournament
  Package Name  : Poker
  Purpose       : Controller all the Poker Games related functionalities
  Auther 	    : Azeem
  Date of create: Aug 02 2013

*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include(APPPATH.'mail/SMTPconfig.php');
 include(APPPATH.'mail/class.phpmailer.php');

class Tournament extends CI_Controller{



    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
	        $this->load->helper(array('url','form'));
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');
			$this->load->model('games/poker/game_model');
			$this->load->model('games/poker/tournament_model');
			$this->load->model('user/account_model');
		    $this->load->model('general/sp_model');
			$this->load->model('reports/withdrawal_model');

			//$this->output->enable_profiler(TRUE);

				$USR_ID = $this->session->userdata['partnerusername'];
			$USR_NAME = $this->session->userdata['partnerusername'];
			//$USR_STATUS = $_SESSION['partnerstatus'];
			$USR_STATUS = "2";
			$USR_PAR_ID = $this->session->userdata['partnerid'];
			$USR_GRP_ID = $this->session->userdata['groupid'];

			if($USR_STATUS!=1)
			{
					$CHK = " AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = $USR_PAR_ID;
			}
			else
			{
					$CHK="  AND PARTNER_ID = '".$USR_PAR_ID."'";
					$CREATEBY = " AND CREATE_BY = '".$USR_ID."'";
					$CBY = 1;
			}





		 $userdata['USR_ID']=$USR_ID;
		 $userdata['USR_GRP_ID']=$USR_GRP_ID;
		 $userdata['USR_STATUS']=$USR_STATUS;
		 $searchdata['rdoSearch']='';

		if($USR_ID == ''){
		 		redirect('login');
		 }


		$this->load->model('common/common_model');

		$partner_id=$this->session->userdata['partnerid'];
		$data = array("id" => $partner_id);
		$amount['amt']=$this->common_model->getBalance($data);
		$this->load->view("common/header",$amount);
		$this->load->model('agent/Agent_model');
			//player model
    }

	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/

	public function index()
	{


		$data['gameTypes'] = $this->tournament_model->getTournamentGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$this->load->view("games/poker/tournament/search",$data);
	}//EO: index function

	public function registerplayer(){
	    //get register tournaments
	    $data['tournaments'] = $this->tournament_model->getAllTournamentsByStatus(1);

		if($this->input->get_post('Submit',TRUE)=="Give Promotional Ticket"){
			$data['tournamentId'] = $this->input->get_post('TOURNAMENT_NAME',TRUE);
			$data['username'] = $this->input->get_post('USERNAME',TRUE);
			//chk the username is exist or not
			$userId = $this->account_model->getUserIdByName($data['username']);
			if($userId != ''){
		      //check the user is already register or not
			  $alreadyAvailable = $this->tournament_model->chkUserAlreadyRegister($userId,$data['tournamentId']);
			  if($alreadyAvailable == 1){
			    //redirect with error message
				redirect('games/poker/tournament/registerplayer?rid=70&msg=3001');
			  }else{
				 //get tournament information
				 $tournamentInfo  = $this->tournament_model->getTournamentById($data['tournamentId']);
				 $tournamentName  = $tournamentInfo->TOURNAMENT_NAME;
				 $tournamentEntry = $tournamentInfo->ENTRY_FEE;
				 $tournamentSTime = $tournamentInfo->TOURNAMENT_START_TIME;
				 $tournamentRSTime= $tournamentInfo->REGISTER_START_TIME;
				 $tournamentRETime= $tournamentInfo->REGISTER_END_TIME;
         $tournamentBuyIn = $tournamentInfo->BUYIN;



				 $playerInfo      = $this->account_model->getUserInfoById($userId);
				 $playerEmail     = $playerInfo->EMAIL_ID;


				 //get the game code
				 $getTournamentGameCode = $this->tournament_model->getTournamentGameTypeCode($data['tournamentId']);
				 $gameCode = $getTournamentGameCode->ref_game_code;
				 $tourId   = $data['tournamentId'];
				 $playerId = $userId;
				 //insert into tournament_user_ticket
				  $query    = "call sp_create_user_tournament_ticket('$gameCode',$tourId,$playerId);";
				 $this->sp_model->executeSPQuery($query);
				 //send mail to user
				 // $this->sendTourPromotionalTicketMail($userName,$email,$tournamentName,$tournamentEntry,$tournamentSTime);
				 //send email to user
				 $this->sendTourPromotionalTicketMail($data['username'],$playerEmail,$tournamentName,$tournamentEntry,$tournamentSTime,$tournamentRSTime,$tournamentRETime,$tournamentBuyIn);
				 //redirect with success message
				 redirect('games/poker/tournament/registerplayer?rid=70&msg=3002');
			  }
			}else{
			  //redirect with error message
			  redirect('games/poker/tournament/registerplayer?rid=70&msg=3003');
			}
		}

		$this->load->view("games/poker/tournament/registerplayer",$data);
	}

  public function addpromotionuser(){
	    //get register tournaments
	    $data['tournaments'] = $this->tournament_model->getAllTournamentsByStatus(1);

		if($this->input->get_post('Submit',TRUE)=="Add Promotion"){
			$data['tournamentId'] = $this->input->get_post('TOURNAMENT_NAME',TRUE);
			$data['username'] = $this->input->get_post('USERNAME',TRUE);
			//chk the username is exist or not
			$userId = $this->account_model->getUserIdByName($data['username']);
      $userName = $data['username'];
      $promoCode = $this->input->get_post('TOURNAMENT_NAME',TRUE);
			if($userId != ''){
        if($promoCode != ''){
          //check if the user already used this code
          $resultCode = $this->tournament_model->selectPromotionToUser($userId,$userName,$promoCode);

          if($resultCode == 0){
            $addGame = $this->tournament_model->insertPromotionToUser($userId,$userName,$promoCode);
         }else{
           redirect('games/poker/tournament/addpromotionuser?rid=70&msg=3001');
         }
        }
		    redirect('games/poker/tournament/addpromotionuser?rid=70&msg=3002');

			}else{
			  //redirect with error message
			  redirect('games/poker/tournament/addpromotionuser?rid=70&msg=3003');
			}
		}

		$this->load->view("games/poker/tournament/addpromotions",$data);
	}

	public function view(){


		$searchdata['tourName'] = $this->input->get_post('tourName',TRUE);
		$searchdata['game_type'] = $this->input->get_post('game_type',TRUE);
		$searchdata['currency_type'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['tournamentType'] = $this->input->get_post('tournamentType',TRUE);
		$searchdata['eligibility'] = $this->input->get_post('eligibility',TRUE);
		$searchdata['fee'] = $this->input->get_post('fee',TRUE);
		$searchdata['startdate'] = $this->input->get_post('startdate',TRUE);
		$searchdata['enddate'] = $this->input->get_post('enddate',TRUE);

		$config = array();
		$config["base_url"] = base_url()."games/poker/tournament/list";
		$config["per_page"] = 25;
		$config['suffix'] = '?chk=30&tourName='.$searchdata['tourName'].'&game_type='.$searchdata['game_type'].'&currency_type='.$searchdata['currency_type'].'&tournamentType='.$searchdata['tournamentType'].'&eligibility='.$searchdata['eligibility'].'&fee='.$searchdata['fee'].'&startdate='.$searchdata['startdate'].'&enddate='.$searchdata['enddate'];
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 3;


		if($this->input->get_post('keyword',TRUE)=="Search"){
			$returnvalue = $this->tournament_model->getTournamentCountBySearchCriteria($searchdata);


			$config['total_rows']	=$returnvalue;
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

			$data['results'] = $this->tournament_model->getTournamentBySearchCriteria($searchdata,$config["per_page"], $page);

			$data['tourName'] = $this->input->get_post('tourName',TRUE);
			$data['game_type'] = $this->input->get_post('game_type',TRUE);
			$data['currency_type'] = $this->input->get_post('currency_type',TRUE);
			$data['tournamentType'] = $this->input->get_post('tournamentType',TRUE);
			$data['eligibility'] = $this->input->get_post('eligibility',TRUE);
			$data['fee'] = $this->input->get_post('fee',TRUE);
			$data['startdate'] = $this->input->get_post('startdate',TRUE);
			$data['enddate'] = $this->input->get_post('enddate',TRUE);
			$data['links'] = $this->pagination->create_links('usersearch');
			$data['rdoSearch']=$searchdata['rdoSearch'];

		    $data['gameTypes'] = $this->tournament_model->getTournamentGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();

			if(count($data)){
				$this->load->view("games/poker/tournament/list", $data);
			}
		}else{
				redirect('games/poker/tournament');
		}

	}

	/*
	 Function Name: add
	 Purpose: This method handle the create game job.
	*/

	public function add(){

		$partner_id =  $this->session->userdata['partnerid'];


		$formdata=$this->input->post();
		if($this->input->post('submit',TRUE)){
		//After submit
			$tournamentName = $_POST['game_name'];
			$chkTournamentExists = $this->game_model->ChkTournamentExists($tournamentName);
			if(empty($chkTournamentExists)) {
				  $addGame = $this->tournament_model->insertTournament($formdata);
				  redirect('games/poker/tournament/add?err=1&rid=43');
			} else {
				redirect('games/poker/tournament/add?err=6&rid=43');
			}
		}


		//get partner tournament types
		$data["getTournamentTypes"]		= $this->tournament_model->getPartnerTournamentTypes($partner_id);
		//get main tournament types
		$data["getMainTournamentTypes"]	= $this->tournament_model->getMainTournamentType();
		//get minigames types
		$data["getTournamentGameTypes"] = $this->tournament_model->getTournamentGameTypes();
		//get tournament limits
		$data["getTournamentLimits"]= $this->tournament_model->getTournamentLimits();
		//get partner entry critiria
		//$data["getCurrencyTypes"]  = $this->tournament_model->getCurrencyTypes();
		//get blind structure
		$data["blindStructure"]  = $this->tournament_model->getTournamentDefaultBlindStructure($partner_id);
		//get prize types
		$data["prizeTypes"]  = $this->tournament_model->getTournamentPrizeTypes();
		//get partner prize structures
		$data["prizeStructure"]		= $this->tournament_model->getPartnerPrizeStructure($partner_id);
		//get partner conin types
		$data["entryCriteria"]		= $this->tournament_model->getPartnerEntryCriteria($partner_id);
		//check weather admin assigned tournament features to this partner or not
		$data["isAllowed"]			= $this->tournament_model->chkPartnerTournamentFeatures($partner_id);
		$data["servers"]			= $this->tournament_model->getTournamentServers();
		//$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		//$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view("games/poker/tournament/add",$data);
	}//EO: add function

	public function edittournament(){
		$data['gameTypes'] = $this->tournament_model->getTournamentGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['rid'] = $this->input->get('rid');
		$this->load->view("games/poker/tournament/editSearch",$data);
	}


	/*
	Function Name:listgame
	Purpose: This method handle to list all games
	*/

	public function listtournament(){
		$searchdata['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
		$searchdata['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
		$searchdata['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
		$searchdata['STATUS'] = $this->input->get_post('status',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);

		$config = array();
		$config["base_url"] = base_url()."games/poker/tournament/listtournament";
		$config["per_page"] = $this->config->item('limit');
		$config['suffix'] = '?chk=30&tableID='.$searchdata['TABLE_ID'].'&game_type='.$searchdata['GAME_TYPE'].'&currency_type='.$searchdata['CURRENCY_TYPE'].'&stakeAmt='.$searchdata['STAKE'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";
	 	$config['cur_page']   = $this->uri->segment(5);

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$returnvalue = $this->tournament_model->getTournamentListCountBySearchCriteria($searchdata);
			$config['total_rows']=$returnvalue;
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
 			$data['results'] = $this->tournament_model->getTournamentListBySearchCriteria($searchdata,$config["per_page"], $page);
			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['rdoSearch']=$searchdata['rdoSearch'];
			$data['START_DATE_TIME']=$this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']=$this->input->get_post('END_DATE_TIME',TRUE);
		    $data['gameTypes'] = $this->game_model->getAllGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
			$data['rid'] = $this->input->get('rid');
			if(count($data)){
				$this->load->view("games/poker/tournament/listTournament", $data);
			}
		}elseif($this->input->get('start') == 1){
				redirect('games/poker/tournament/edittournament?rid=44');
		}else{
				redirect('games/poker/tournament?rid=44');
		}


	}

	/*
	 Function Name: edit
	 Purpose: This method handle the edit works of game
	*/

	public function edit(){
		$partner_id =  $this->session->userdata['partnerid'];
		$tournament_id = $this->uri->segment(5, 0);
		$formdata=$this->input->post();
		$formdata['rid']=$this->input->get('rid');
		if($this->input->post('submit',TRUE)){
			$updateGame = $this->tournament_model->updateTournament($tournament_id,$formdata);
			 redirect('games/poker/tournament/edit/'.$tournament_id.'?err=1&rid=44');
		}

		//get tournament information
		$data['results'] = $this->tournament_model->getTournamentById($tournament_id);
		//get tournament type
		$data['getTournamentType'] = $this->tournament_model->getTournamentType($tournament_id);
		//get main tournament types
		$data["getMainTournamentTypes"]	= $this->tournament_model->getMainTournamentType();
		//get partner tournament types
		$data["getTournamentTypes"]		= $this->tournament_model->getPartnerTournamentTypes($partner_id);
		$data["getSatelliteTournamentTypes"] = $this->tournament_model->getSatelliteTournamentGameTypes();
		//get minigames types
		$data["getTournamentGameTypes"] = $this->tournament_model->getTournamentGameTypes();
		//get tournament limits
		$data["getTournamentLimits"]= $this->tournament_model->getTournamentLimits();
		//get blind structure
		$data["blindStructure"]  = $this->tournament_model->getTournamentDefaultBlindStructure($partner_id);
		//get prize types
		$data["prizeTypes"]  = $this->tournament_model->getTournamentPrizeTypes();
		//get partner prize structures
		$data["prizeStructure"]		= $this->tournament_model->getPartnerPrizeStructure($partner_id);
		//get partner conin types
		$data["entryCriteria"]		= $this->tournament_model->getPartnerEntryCriteria($partner_id);
		//check weather admin assigned tournament features to this partner or not
		$data["isAllowed"]			= $this->tournament_model->chkPartnerTournamentFeatures($partner_id);

		$data["servers"]			= $this->tournament_model->getTournamentServers();

		$data['rid'] = $this->input->get('rid');
		//$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view('games/poker/tournament/edit',$data);
	}//EO: edit function

	/*
	 Function Name: index
	 Purpose: This method handle the delete job of game
	*/

	public function deleteTournamentTable($tournamentID) {
		$deleteGameTable = $this->tournament_model->deleteTournamentTable($tournamentID);
		redirect('games/poker/tournament/edittournament?rid=44');
	}

	public function sendTourPromotionalTicketMail($userName,$email,$tournamentName,$tournamentEntry,$starttime,$regstarttime,$regendtime,$tournamentBuyIn){

    //echo $rootArea.'/application/mail/SMTPconfig.php'; die;
	  $mailID = 17;
	  $emailInfo  = $this->withdrawal_model->getEmailTemplates($mailID);

	  $siteURL = "http://www.pokerbaazi.com/";

	  $headerImgURL = $siteURL."images/Home_logo.png";

	  $downArrowImgURL = $siteURL."images/dwnarw.png";
	  $bottomLineImgURL = $siteURL."images/email-bottom.png";

	  $addCashImgURL=$siteURL."images/add_cash.png";
	  $downloadImgURL=$siteURL."images/download_now.png";
	  $playNowImgURL=$siteURL."images/play_now.png";

	  $socialFBImgURL=$siteURL."images/facebook_icon_2.png";
	  $socialTWEETImgURL=$siteURL."images/twitter_icon_2.png";
	  $socialYOUImgURL=$siteURL."images/youtube_icon_2.png";

	  $subject = "Tournament Promotional Ticket";
	  $mailContent    = $emailInfo[0]->description;
	  $mailContent = str_replace( "_USER_NAME_",$userName, $mailContent );
	  $mailContent = str_replace('_HEADER_IMG_URL_',$headerImgURL,$mailContent);
	  $mailContent = str_replace('_DOWN_ARROW_IMG_URL_',$downArrowImgURL,$mailContent);
	  $mailContent = str_replace('_BOTTOM_LINE_URL_',$bottomLineImgURL,$mailContent);

	  $mailContent = str_replace('_ADD_CASH_IMG_URL_',$addCashImgURL,$mailContent);
	  $mailContent = str_replace('_DOWN_IMG_URL_',$downloadImgURL,$mailContent);
	  $mailContent = str_replace('_PLAY_IMG_URL_',$playNowImgURL,$mailContent);

	  $mailContent = str_replace('_SOCIAL_FB_ICON_',$socialFBImgURL,$mailContent);
	  $mailContent = str_replace('_SOCIAL_TWEET_ICON_',$socialTWEETImgURL,$mailContent);
	  $mailContent = str_replace('_SOCIAL_YOU_ICON_',$socialYOUImgURL,$mailContent);


	  $mailContent = str_replace('_TOURNAMENTID_',$tournamentName,$mailContent);
	  $mailContent = str_replace('_ENTRYFEE_',$tournamentEntry,$mailContent);
    $mailContent = str_replace('_BUYIN_',$tournamentBuyIn,$mailContent);

	  $mailContent = str_replace('_TSTARTDTIME_',$starttime,$mailContent);
          $mailContent = str_replace('_RSTARTDTIME_',$regstarttime,$mailContent);
	  $mailContent = str_replace('_RENDTIME_',$regendtime,$mailContent);


    $SmtpServer= $this->config->item('smtpServer');
    $SmtpPort=$this->config->item('smtpPort');
    $SmtpUser=$this->config->item('smtpUser');
    $SmtpPass=$this->config->item('smtpPass');


    $mail = new PHPMailer(true); //New instance, with exceptions enabled

    $body             = $mailContent;//file_get_contents($eurl);
    $mail->IsSMTP();                           // tell the class to use SMTP
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = $SmtpPort;//25;                    // set the SMTP server port
    $mail->Host       = $SmtpServer;//"mail.yourdomain.com"; // SMTP server
    $mail->Username   = $SmtpUser;//"name@domain.com";     // SMTP server username
    $mail->Password   = $SmtpPass;//"password";            // SMTP server password
    $mail->From       = 'support@pokerbaazi.com';
    $mail->FromName   = 'PokerBaazi';
    $to = $email;
    $mail->AddAddress($to);
    $mail->Subject  = $subject;
    //$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->WordWrap   = 80; // set word wrap
    $mail->MsgHTML($body);

    $mail->IsHTML(true); // send as HTML
    $mail->Send();



	}

	public function history(){
		$data["page_title"]    = "Tournament History";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('searchTournamentDetails');
		}
		if($this->input->get('start',TRUE) == 1){
        	$this->session->unset_userdata('searchTournamentDetails');
		}

		$getPlayerId = $this->input->get('playerID',TRUE);

		if($this->input->post('frmSearch')) {

			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			$data['GAME_ID'] = $this->input->get_post('gameID',TRUE);
			$data['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['HAND_ID'] = $this->input->get_post('handID',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$data['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchTournamentDetails'=>$data));

			 $noOfRecords  = $this->tournament_model->getSearchTournamentCount($data); 

		}else if($this->input->get('keyword',TRUE)=="Search"){

			$data['PLAYER_ID'] = $this->input->get('playerID',TRUE);
			$data['START_DATE_TIME'] = $this->input->get('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] = $this->input->get('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchTournamentDetails'=>$data));
			$noOfRecords  = $this->tournament_model->getSearchTournamentCount($data);
		} else if($this->input->get_post('gameid',TRUE)!="") {

			$data['TABLE_ID']  = $this->input->get_post('gameid',TRUE);
			$data['PLAYER_ID'] = $this->input->get_post('playerID',TRUE);
			$data['START_DATE_TIME'] = $this->input->get_post('sdate',TRUE);
			$data['END_DATE_TIME'] = $this->input->get_post('edate',TRUE);
			$this->session->set_userdata(array('searchTournamentDetails'=>$data));
			$noOfRecords  = $this->tournament_model->getSearchTournamentCount($data);
		} else if($this->session->userdata('searchTournamentDetails')) {
			$noOfRecords  = $this->tournament_model->getSearchTournamentCount($data);
		} else {
			$nothing=1;
			//$noOfRecords  = $this->tournament_model->getSearchTournamentCount();
		}

		//echo $noOfRecords;
		/* Set the config parameters */
		$config['base_url']   = base_url()."games/poker/tournament/history";
		$config['total_rows'] = $noOfRecords;
		$config['per_page']   = $this->config->item('limit');
		$config['cur_page']   = $this->uri->segment(5);
		$config['suffix']     = '?rid=73';

		if($this->uri->segment(5)) {
			$config['order_by']	  = $this->uri->segment(6);
			$config['sort_order'] = $this->uri->segment(7);
		} else {
			$config['order_by']	  = "GAME_HISTORY_ID";
			$config['sort_order'] = "asc";
		}

		if($this->input->post('frmSearch')) {
			$data["searchGameData"] = $this->tournament_model->getSearchTournamentData($config,$data);
			$data["totalSearchData"]= $this->tournament_model->getTotalSearchData($config,$data);
			$data["searchResult"] = 1;
		} else if($this->input->get_post('gameid',TRUE)!="") {
			$data["searchGameData"] = $this->tournament_model->getSearchTournamentData($config);
			$data["totalSearchData"]= $this->tournament_model->getTotalSearchData($config,$data);
			$data["searchResult"] = 1;
		}else if($this->input->get('keyword',TRUE)=="Search"){
			$data["searchGameData"] = $this->tournament_model->getSearchTournamentData($config);
			$data["totalSearchData"]= $this->tournament_model->getTotalSearchData($config,$data);
			$data["searchResult"] = 1;
		} else if($this->session->userdata('searchTournamentDetails')) {
			$data["searchGameData"] = $this->tournament_model->getSearchTournamentData($config,$data);
			$data["totalSearchData"]= $this->tournament_model->getTotalSearchData($config,$data);
			$data["searchResult"] = 1;
		} else {
			//$data["searchGameData"] = $this->tournament_model->getSearchTournamentData($config);
			//$data["totalSearchData"]= $this->tournament_model->getTotalSearchData($config,$data);
			//$data["searchResult"] = "";
		}
		$this->pagination->initialize($config);
		$data['pagination']   = $this->pagination->create_links();

		$data['gameTypes'] = $this->game_model->getAllGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();




		$this->load->view('games/poker/tournament/history',$data);

	}


	 public function turnover(){

		if($this->input->get_post('keyword',TRUE)=="Search"){

			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchTTurnoverData'=>$data));

			$noOfRecords  = $this->tournament_model->getSelfTurnoverCount($data);
			//echo $noOfRecords; die;
			$nopOfRecords  = $this->tournament_model->getPartnersTurnoverCount($data);
			$data["results"] = $this->tournament_model->getSelfTurnover($data);
			$data["presults"] = $this->tournament_model->getPartnersTurnover($data);

		}
		$data['START_DATE_TIME']=	$this->input->post('START_DATE_TIME');
		$data['END_DATE_TIME']	=	$this->input->post('END_DATE_TIME');
		$data['totCount'] = $noOfRecords;
		$data['totPCount'] = $nopOfRecords;

		$this->load->view('reports/tournamentturnover',$data);
	 }

	 public function turnamentreport(){
			 $partner_id = $this->uri->segment(5,0);
			 $self['partner_id'] = $this->uri->segment(5,0);
			 $self['START_DATE_TIME'] = $_REQUEST['sdate'];
			 $self['END_DATE_TIME'] = $_REQUEST['edate'];
			 $data['detail'] =  $this->tournament_model->getSelfPartnerTurnover($self);
			 $totCount       	= $this->tournament_model->getAllTournamentTurnoverCount($partner_id,$self);
			 $data['username']  	= $this->input->get_post('USERN_NAME',TRUE);

			 if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['user_id'] = $user_id;
				}else{
				  $data['user_id'] = '';
				}
			 }else{
				$data['user_id'] = '';
			 }

			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['results']	= $this->tournament_model->getAllTournamentTurnover($partner_id,$self);
			$data['tot_users']      = $totCount;

		   $this->load->view('reports/tourturnover',$data);

       }

	 public function userreport(){
			 $partner_id = $this->uri->segment(5,0);
			 $self['partner_id'] = $this->uri->segment(5,0);
			 $self['START_DATE_TIME'] = $_REQUEST['sdate'];
			 $self['END_DATE_TIME'] = $_REQUEST['edate'];
			 $self['TOURNAMENT_ID'] = $_REQUEST['tournamentId'];


			// $data['detail'] =  $this->tournament_model->getSelfPartnerTurnover($self);
			 $data['detail'] =  $this->tournament_model->getSelfTournamentTurnover($self);
			 $totCount       	= $this->tournament_model->getAllUserTurnoverCount($partner_id,$self);
			 $data['username']  	= $this->input->get_post('USERN_NAME',TRUE);

			 if($data["username"] != ''){
				$user_id = $this->Account_model->getUserIdByName($data['username']);
				if($user_id != ''){
				  $data['user_id'] = $user_id;
				}else{
				  $data['user_id'] = '';
				}
			 }else{
				$data['user_id'] = '';
			 }

			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['results']	= $this->tournament_model->getAllUserTurnover($partner_id,$self);
			$data['tot_users']      = $totCount;

		   $this->load->view('reports/tournamentuserturnover',$data);

       }

    public function getregisteredusers() {
		$data["page_title"]    = "List Registed Users";
		if($this->input->post('frmClear')) {
			$this->session->unset_userdata('regusersSearchData');
		}
		if($this->input->get('start',TRUE) == 1){
		   $this->session->unset_userdata('regusersSearchData');
		}

		if($this->input->post('frmSearch')) {
			$arrRegUser["TOURNAMENT_ID"]  =$this->input->post('TOURNAMENT_ID');
			if(!empty($arrRegUser["TOURNAMENT_ID"])) {
				$data["TOURNAMENT_ID"]  =$arrRegUser["TOURNAMENT_ID"];
				$this->session->set_userdata(array('regusersSearchData'=>$data));
				$hostName =  $this->db->hostname;
				$username =  $this->db->username;
				$password =  $this->db->password;
				$database =  $this->db->database;

				$mysqli = new mysqli("$hostName", "$username", "$password", "$database");
				if(mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
				}
				//$query1  = "call sp_show_win_hand_ranking('".$arrRegUser["startdate"]."','".$arrRegUser["enddate"]."','".$arrRegUser["wintype"]."',99999)";
				 $query  = "call sp_show_tournament_user_ticket(".$arrRegUser["TOURNAMENT_ID"].")";
				 $res = $mysqli->multi_query("$query");
				 if( $res ) {
				  $results = 0;
					  do {
						if ($result = $mysqli->store_result()) {
						  while( $row = $result->fetch_row() ) {
									 $newArray[] = $row;
						  }

						  $result->close();

						}
					  } while( $mysqli->next_result() );
					}

				$data["resultData"]=$newArray;
				$data["listregusers"]=$data["resultData"];
				$data["searchResult"]=1;

//print_r($data);
			} else {
				$data["listregusers"]="";
				$data["searchResult"]="";
			}
		}
		$data["tournamentNames"]=$this->tournament_model->getTournamentNames();
		$this->load->view('games/poker/tournament/listregusers',$data);
	}

	public function deleteRecurrenceTournamentTable($recurrenceTournamentId){
		$deleteGameTable = $this->tournament_model->deleteRecurrenceTournament($recurrenceTournamentId);
		redirect('games/poker/tournament/recurrenceedit?rid=82&err=401');
	}

	public function recurrenceadd(){
    $isAdminUserCheck =  $this->session->userdata('isadminuser');
    if($isAdminUserCheck == 1){
       redirect('user/account/welcomeadminuser?rid=10&start=1');
     }
		$partner_id =  $this->session->userdata['partnerid'];


		$formdata=$this->input->post();
		if($this->input->post('submit',TRUE)){
		//After submit

			$tournamentName = $_POST['game_name'];
			$chkTournamentExists = $this->game_model->ChkTournamentExists($tournamentName);
			if(empty($chkTournamentExists)) {
				  $addGame = $this->tournament_model->insertRecurrenceTournament($formdata);
				  redirect('games/poker/tournament/recurrenceadd?err=1&rid=81');
			} else {
				redirect('games/poker/tournament/recurrenceadd?err=6&rid=81');
			}
		}


		//get partner tournament types
		$data["getTournamentTypes"]		= $this->tournament_model->getPartnerTournamentTypes($partner_id);

		//get minigames types
		$data["getTournamentGameTypes"] = $this->tournament_model->getTournamentGameTypes();
		//get tournament limits
		$data["getTournamentLimits"]= $this->tournament_model->getTournamentLimits();
		//get partner entry critiria
		//$data["getCurrencyTypes"]  = $this->tournament_model->getCurrencyTypes();
		//get blind structure
		$data["blindStructure"]  = $this->tournament_model->getTournamentDefaultBlindStructure($partner_id);
		//get prize types
		$data["prizeTypes"]  = $this->tournament_model->getTournamentPrizeTypes();
		//get partner prize structures
		$data["prizeStructure"]		= $this->tournament_model->getPartnerPrizeStructure($partner_id);
		//get partner conin types
		$data["entryCriteria"]		= $this->tournament_model->getPartnerEntryCriteria($partner_id);
		//check weather admin assigned tournament features to this partner or not
		$data["isAllowed"]			= $this->tournament_model->chkPartnerTournamentFeatures($partner_id);
		$data["servers"]			= $this->tournament_model->getTournamentServers();
		//$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		//$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view("games/poker/tournament/recurrenceadd",$data);
	}//EO: add function

	public function recurrenceedit(){
    $isAdminUserCheck =  $this->session->userdata('isadminuser');
    if($isAdminUserCheck == 1){
       redirect('user/account/welcomeadminuser?rid=10&start=1');
     }
		$data['gameTypes'] = $this->tournament_model->getTournamentGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$data['rid'] = $this->input->get('rid');
		$this->load->view("games/poker/tournament/recurrenceeditSearch",$data);
	}

	public function rlisttournament(){
    $isAdminUserCheck =  $this->session->userdata('isadminuser');
    if($isAdminUserCheck == 1){
       redirect('user/account/welcomeadminuser?rid=10&start=1');
     }
		$searchdata['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
		$searchdata['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
		$searchdata['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
		$searchdata['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
		$searchdata['STATUS'] = $this->input->get_post('status',TRUE);
		$searchdata['START_DATE_TIME'] = $this->input->get_post('START_DATE_TIME',TRUE);
		$searchdata['END_DATE_TIME'] = $this->input->get_post('END_DATE_TIME',TRUE);

		$config = array();
		$config["base_url"] = base_url()."games/poker/tournament/rlisttournament";
		$config["per_page"] = $this->config->item('limit');
		$config['suffix'] = '?chk=30&tableID='.$searchdata['TABLE_ID'].'&game_type='.$searchdata['GAME_TYPE'].'&currency_type='.$searchdata['CURRENCY_TYPE'].'&stakeAmt='.$searchdata['STAKE'].'&status='.$searchdata['STATUS'].'&START_DATE_TIME='.$searchdata['START_DATE_TIME'].'&END_DATE_TIME='.$searchdata['END_DATE_TIME'].'&keyword=Search&rid='.$this->input->get('rid');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config["uri_segment"] = 2;
		$config['sort_order'] = "asc";
	 	$config['cur_page']   = $this->uri->segment(5);

		if($this->input->get_post('keyword',TRUE)=="Search" or $this->input->get('keyword',TRUE)=="Search"){
			$returnvalue = $this->tournament_model->getRecurrenceTournamentListCountBySearchCriteria($searchdata);
			$config['total_rows']=$returnvalue;
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
 			$data['results'] = $this->tournament_model->getRecurrenceTournamentListBySearchCriteria($searchdata,$config["per_page"], $page);
			$data['TABLE_ID'] = $this->input->get_post('tableID',TRUE);
			$data['GAME_TYPE'] = $this->input->get_post('game_type',TRUE);
			$data['CURRENCY_TYPE'] = $this->input->get_post('currency_type',TRUE);
			$data['STAKE'] = $this->input->get_post('stakeAmt',TRUE);
			$data['STATUS'] = $this->input->get_post('status',TRUE);
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['rdoSearch']=$searchdata['rdoSearch'];
			$data['START_DATE_TIME']=$this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME']=$this->input->get_post('END_DATE_TIME',TRUE);
		    $data['gameTypes'] = $this->game_model->getAllGameTypes();
			$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
			$data['rid'] = $this->input->get('rid');
			if(count($data)){
				$this->load->view("games/poker/tournament/rlistTournament", $data);
			}
		}elseif($this->input->get('start') == 1){
				redirect('games/poker/tournament/recurrenceedit?rid=44');
		}else{
				redirect('games/poker/tournament/rsearch?rid=44');
		}

	}

	public function rsearch(){
	    $data['gameTypes'] = $this->tournament_model->getTournamentGameTypes();
		$data['currencyTypes'] = $this->game_model->getAllCurrencyTypes();
		$this->load->view("games/poker/tournament/rsearch",$data);
	}

	public function redit(){
		$partner_id =  $this->session->userdata['partnerid'];
		$tournament_id = $this->uri->segment(5, 0);
		$formdata=$this->input->post();
		$formdata['rid']=$this->input->get('rid');
		if($this->input->post('submit',TRUE)){
			$updateGame = $this->tournament_model->updaterTournament($tournament_id,$formdata);
			 redirect('games/poker/tournament/edit/'.$tournament_id.'?err=1&rid=44');
		}

		//get tournament information
		$data['results'] = $this->tournament_model->getTournamentById($tournament_id);
		//get partner tournament types
		$data["getTournamentTypes"]		= $this->tournament_model->getPartnerTournamentTypes($partner_id);
		//get minigames types
		$data["getTournamentGameTypes"] = $this->tournament_model->getTournamentGameTypes();
		//get tournament limits
		$data["getTournamentLimits"]= $this->tournament_model->getTournamentLimits();
		//get blind structure
		$data["blindStructure"]  = $this->tournament_model->getTournamentDefaultBlindStructure($partner_id);
		//get prize types
		$data["prizeTypes"]  = $this->tournament_model->getTournamentPrizeTypes();
		//get partner prize structures
		$data["prizeStructure"]		= $this->tournament_model->getPartnerPrizeStructure($partner_id);
		//get partner conin types
		$data["entryCriteria"]		= $this->tournament_model->getPartnerEntryCriteria($partner_id);
		//check weather admin assigned tournament features to this partner or not
		$data["isAllowed"]			= $this->tournament_model->chkPartnerTournamentFeatures($partner_id);

		$data['rid'] = $this->input->get('rid');
		//$data['gameThemes'] = $this->game_model->getAllThemes();
		$this->load->view('games/poker/tournament/recurrenceedit',$data);
	}//EO: edit function

	public function exportregisterplayer($tournamentId) {
		$this->load->library("excel");
		$this->excel->setActiveSheetIndex(0);
		$data1 = $this->tournament_model->getAllExportRegisterPlayerInfo($tournamentId);

	    $DATE   = date("dmY");
	   	$fileName = "POKERBAAZI_TOURNAMENT_REPORT_$DATE.xls";
		$this->excel->stream($fileName,$data1);
	}

}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */
