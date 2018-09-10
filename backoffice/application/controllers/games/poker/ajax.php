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
	        $this->load->helper('url');
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');
			$this->load->model('games/poker/game_model');	
			$this->load->model('games/poker/tournament_model');
$this->load->model('general/sp_model');	
			
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
	
	
	public function tourinfo(){
	   $tourId = $this->uri->segment(5, 0);
	   $tournamentInfo  = $this->tournament_model->getTournamentById($tourId);
	   $typeName = $this->game_model->getGameTypeNameByID($tournamentInfo->GAME_TYPE);
	   $curName  = $this->game_model->getCurrencyNameByID($tournamentInfo->CURRENCY_TYPE);
	   $tLevels  = $this->tournament_model->getTournamentLevels($tourId);
	   $tWins    = $this->tournament_model->getTournamentWinnersAmount($tourId);
	
	   //bulild HTML string
	   $htmlString = "<table>";
	   $htmlString .= "<tr><td><img height='150' src=".base_url()."static/images/poker-cards.png><br /><img height='150' src=".base_url()."static/images/poker-cards1.png><br /><img width='128' height='200'  src=".base_url()."static/images/poker-cards2.png></td>";
	   $htmlString .= "<td>";
	   $htmlString .= "<table style='padding-left: 10px;'>";
	   $htmlString .= "<tr><td><b>Tournament Name:</b> </td><td>".$tournamentInfo->TOURNAMENT_NAME."</tr>";
	   $htmlString .= "<tr><td><b>Game Type:</b> </td><td>".$typeName."</tr>";
	   $htmlString .= "<tr><td><b>Currency Type:</b> </td><td>".$curName."</tr>";
	   $htmlString .= "<tr><td><b>Tournament Type:</b> </td><td>".ucfirst($tournamentInfo->TOURNAMENT_TYPE)."</tr>";
	   $htmlString .= "<tr><td><b>Registration Start Date:</b></td><td> ".$tournamentInfo->RSTART_DATE."</tr>";
	   $htmlString .= "<tr><td><b>Registration End Date:</b></td><td> ".$tournamentInfo->REND_DATE."</tr>";
	   $htmlString .= "<tr><td><b>Tournament Start Date:</b> </td><td>".$tournamentInfo->TSTART_DATE."</tr>";
	   $htmlString .= "<tr><td><b>Tournament End Date:</b></td><td> ".$tournamentInfo->TEND_DATE."</tr>";
	   $htmlString .= "<tr><td><b>Eligibility:</b> </td><td>".$tournamentInfo->ELIGIBILITY."</tr>";
	   $htmlString .= "<tr><td><b>Fee:</b> </td><td>".$tournamentInfo->FEE."</tr>";
	   $htmlString .= "<tr><td><b>Rake:</b></td><td> ".$tournamentInfo->RAKE."</tr>";
	   $htmlString .= "<tr><td><b>Total Amount:</b></td><td> ".$tournamentInfo->TOTAL_AMOUNT."</tr>";
       $htmlString .= "<tr><td><b>Table Type:</b> </td><td> ".$tournamentInfo->TABLE_TYPE."</tr>";
	   $htmlString .= "<tr><td><b>Promo Chips:</b> </td><td>".$tournamentInfo->PROMO_CHIPS."</tr>";
	   $htmlString .= "<tr><td><b>No.of Players:</b> </td><td>".$tournamentInfo->TOTAL_PLAYERS."</tr>";
	   $htmlString .= "<tr><td><b>Small Blind:</b></td><td>".$tournamentInfo->SMALL_BLIND."</tr>";
	   $htmlString .= "<tr><td><b>Big Blind:</b> </td><td>".$tournamentInfo->BIG_BLIND."</tr>";
	   $htmlString .= "<tr><td><b>Prize Amount:</b></td><td> ".$tournamentInfo->PRIZE_AMOUNT."</tr>";
	   $htmlString .= "<tr><td><b>No.of Winners:</b></td><td> ".$tournamentInfo->WINNERS."</tr>";
	   $htmlString .= "<tr><td><b>Theme:</b> </td><td>".$tournamentInfo->THEME_ID."</tr>";
	   $htmlString .= "<tr><td><b>Chat:</b> </td><td>".$tournamentInfo->CHAT."</tr>";
	   $htmlString .= "</table>";
	   $htmlString .= "</td>";
	   $htmlString .= "</tr>";
	   $htmlString .= "</table>";
	   $htmlString .= "<table style='width:450px'>";
	   $htmlString .= "<tr><b>Level information</b><br></tr>";
	   
	   $levCount = count($tLevels);
	   if($levCount >0 && $tournamentInfo->TABLE_TYPE == 'multiple'){
	      $htmlString .= "<tr><td>Level</td><td>Small Blind</td><td>Big Blind</td><td>Players</td><td>Tables</td></tr>";
		  foreach($tLevels as $tLevel){
		    $htmlString .= "<tr><td>".$tLevel->LEVEL."</td><td>".$tLevel->SMALL_BLIND."</td><td>".$tLevel->BIG_BLIND."</td><td>".$tLevel->PLAYERS."</td><td>".$tLevel->TABLES."</td></tr>";	  
		  }
	   
	   }else
	   {
	      $htmlString .= "<tr><td>No levels found for this tournament!!!...</td></tr>";
	   }
	   
	    $htmlString .= "</table>";
	   
	   $winCount = count($tWins);
	   if($winCount > 0){
	      $htmlString .= "<table>";
		  $htmlString .= "<tr><b>Winners Amount Information</b><br></tr>";
		  $htmlString .= "<tr><td>Winner</td><td>Amount</td><td>Token Amount</td></tr>";
		  foreach($tWins as $tWin){
		    $htmlString .= "<tr><td>".$tWin->WINNER."</td><td>".$tWin->AMOUNT."</td><td>".$tWin->TOKEN_AMOUNT."</td></tr>";	  
		  } 
		  $htmlString .= "</table>";
	   }
	   echo $htmlString;
	   exit;
	   
	}
	
	public function winbox(){
	    $winnerCount = $this->uri->segment(5, 0);
		
		$htmlString ='';
		for($i=1; $i<= $winnerCount; $i++){
		   //Built HTML string
		   $htmlString .='<tr>';
		   $htmlString .='<td width="45%">';
		   $htmlString .='<span class="TextFieldHdr">Winner '.$i.':</span><br />';
		   $htmlString .='<span class="TextFieldHdr">Amount:</span><label><input name="winneramount[]" type="text" class="TextField3" id="winner_amount'.$i.'" /><span class="mandatory">*</span> </label>';
		   $htmlString .='&nbsp;&nbsp;<span class="TextFieldHdr">Token Amount:</span><label><input name="winner_token_amount[]" type="text" class="TextField3" id="winner_token_amount'.$i.'" /><span class="mandatory">*</span> </label>&nbsp;&nbsp;';
		   $htmlString .='</td>';
		   $htmlString .='</tr>';
		}
		echo $htmlString;
		exit;
	
	}
	
	public function winners(){
	    echo $tourId = $this->uri->segment(5, 0);
		//$tWinners  = $this->tournament_model->getTournamentWinners($tourId);
		
	}
	
	public function canceltournament(){
	  $tourId = $this->uri->segment(5, 0); 
	  $reason = $this->uri->segment(6, 0);
	  $formdata['tournament_id'] = $tourId;
      $formdata['desc_reason'] = nl2br(str_replace("%20"," ",$reason));
		if(is_array($formdata) && count($formdata)>0){
			$cancelTournament = $this->tournament_model->cancelTournament($formdata);	
                if($cancelTournament){ 
				   $returnString  = 'Cancelled';
				}
		}else{
		   $returnString  = 'empty';
		}
		echo $returnString; die;
	}
	
	public function cancelreason(){
	  $tourId = $this->uri->segment(5, 0); 
	  $returnString  = "<h3 style='border-bottom: 1px solid #cccccc;color: #184d38;'>Cancel Reason:</h3>";
		if($tourId != ''){
		   $results = $this->tournament_model->getTournaemntCancelReason($tourId);
		   if($results[0]->CANCEL_REASON != ''){
		     $returnString .= $results[0]->CANCEL_REASON;
		   }else{
		     $returnString .= "No reason available!!";
		   }
		}else{
		  $returnString .= "No reason available!!";
		}
		echo $returnString; exit;
	}
	
	
}

/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */