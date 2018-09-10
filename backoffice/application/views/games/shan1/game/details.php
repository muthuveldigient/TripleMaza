<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<?php error_reporting(0); ?>
<style>
*{	margin:0;	padding:0;	font-family:Arial, Helvetica, sans-serif;	}
li{	list-style:none;	float:left;	}
.container_searchgame{	padding:1px;	border:1px solid #dff4ff;	overflow:hidden;	margin:10px 20px;	min-width:600px;	float:left;	}
.container_searchgame ul {	overflow:hidden;	min-width:600px;	}
.container_searchgame ul li {	border-right:1px solid #71d0ff;	overflow:hidden;	min-width:171px;	}
.cnt_userdetails li{	min-height:105px;	background-color:#d2f0ff;	}
.container_searchgame ul li h3{	margin:0;	line-height:38px;	font-size:13px;	color:#fff;	font-family:Arial, Helvetica, sans-serif;	padding:0 30px;
	height:	39px;	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);	background-repeat:repeat-x;	text-align:center;	}
.searchgame_cardcnt{	overflow:hidden;	background-color:#d2f0ff;	padding:9px;	min-height:90px;	text-align:center;	}
.searchgame_cardcnt p{	font-size:13px;	color:#333333;	float:left;	margin-left:5px;	text-align:center;	}
.searchgame_cardcnt p.usrname{	line-height:87px;	}
.userdetail_searchgame{	padding:1px;	border:1px solid #dff4ff;	overflow:hidden;	margin:10px 20px;	min-width:600px;	float:left;	}
.userdetail_searchgame ul {	overflow:hidden;	min-width:600px;	}
.userdetail_searchgame ul li {	border-right:1px solid #71d0ff;	overflow:hidden;  min-width:115px; }	
.userdetail_searchgame ul li h3{	margin:0;	line-height:38px;	font-size:13px;	color:#fff;	font-family:Arial, Helvetica, sans-serif;	padding:0 30px;
	height:	39px;	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);	background-repeat:repeat-x;	text-align:center;	}
.table_card{	margin: 20px 20px;	overflow:hidden; }
.table_card h3{	margin:0;	font-size:13px;	font-family:Arial, Helvetica, sans-serif;	}
.cnt_userprofile{	display:table;	}
.cnt_userprofile li{	min-height:135px;	background-color:#d2f0ff;	display:table-cell;	}
.tablecards p{	float:left;	padding-left:10px;	}
.tablecard_cnt{	width:370px;	overflow:hidden;	float:left;	}
.tablecard_cnt h3{	text-align:left;	margin:0 10px 10px 0;	}
.potamount{	width:400px;	overflow:hidden;	float:left;	margin-top:20px; }
.potamount h3{	text-align:left;	margin-bottom:10px;	float:left;	line-height:20px;	width:150px; }
.potamount span{	float:left;	line-height:20px;	margin-left:5px;	font-size:13px;	}
.rake{	width:400px;	overflow:hidden;	float:left;	margin-top:20px;	}
.rake h3{	text-align:left;	margin-bottom:10px;	float:left;	line-height:20px;	width:150px; }
.rake span{	float:left;	line-height:20px;	margin-left:5px;	font-size:13px;	}
.ContentHdr {    border-radius: 0px !important; }
</style>
<?php 
$playData="";
$id = $results[0]->GAME_ID;
$tournamentInfo = $this->game_model->getTournamentInfoById($id);
for($i=0;$i<count($results);$i++){
	$playData = json_decode($results[$i]->PLAY_DATA);
	$bnkIndex = $playData->playResult->bankerIndex; 
	$plyIndex = $playData->playResult->playerIndex;
	$playerIndex[$playData->playResult->playerIndex] = $results[$i]->USERNAME; 
	if($bnkIndex == $plyIndex){
		$banker = $results[$i]->USERNAME;
	}
	
	$totalRake += $results[$i]->RAKE;
}
	$cntRes1 = count($results);
	for($i=0;$i<$cntRes1;$i++){
		$playdata1=json_decode($results[$i]->PLAY_DATA,true);
		$cnt1 = count($playdata1['playResult']['playerHand']);	
		for($j=0;$j<$cnt1;$j++){
			if($playdata1['playResult']['playerHand'][$j]['userName'] == $results[$i]->USERNAME){
				$playerCards1 = $playdata1['playResult']['playerHand'][$j]['cardsAsString'];
					$opening_pot_amount = $results[$i]->OPENING_POT_AMOUNT;
					$closing_pot_amount = $results[$i]->CLOSING_POT_AMOUNT;				
				$valueInfo1 = $playdata1['playResult']['playerIndex'];
				$handOutCome1 = $playdata1['playResult']['playerHand'][$j]['handOutcome'];
				if($playdata1['playResult']['bankerIndex']==$valueInfo1){
					$Banker = $playdata1['playResult']['playerHand'][$j]['userName'];
				}
			}
		}
	}
	//echo "<pre>";print_r($results); die;
	//echo "<pre>"; print_r($tournamentInfo); die;
$totalHands = count($playData->playResult->playerHand);
$BANKER_AMOUNT  = $tournamentInfo->BANKER;
$MIN_BET  = $tournamentInfo->MIN_BET;
$MAX_BET  = $tournamentInfo->MAX_BET;
$RAKE_PERCENT  = $tournamentInfo->RAKE; ?>
<table width="100%" class="ContentHdr">
       <tr>
          <td><strong>Game Details</strong>
            </td>
        </tr>
     </table>
<div class="table_card">
	<div class="potamount">
		<div style="width:300px;float:left;"><h3>Play Group Id</h3><span><?php echo '<b>: </b>'.$results[0]->PLAY_GROUP_ID; ?></span></div>
		<div style="width:300px;float:left;"><h3>Start Date & Time</h3><span><?php echo '<b>: </b>'.$results[0]->STARTED; ?></span></div>
		<div style="width:300px;float:left;"><h3>Banker</h3><span><?php echo '<b>: </b>'.$Banker; ?></span></div>
        <div style="width:300px;float:left;"><h3>Banker Amount</h3><span><?php echo '<b>: </b>'.$BANKER_AMOUNT; ?></span></div>
        <div style="width:300px;float:left;"><h3>Bet Limit</h3><span><?php echo '<b>: </b>'."( ".$MIN_BET."/".$MAX_BET." )"; ?></span></div>
        <div style="width:300px;float:left;"><h3>Opening Pot Amount</h3><span><?php echo '<b>: </b>'.$opening_pot_amount; ?></span></div>
	</div> 
	<div class="rake">
    	<div style="width:300px;float:left;"> <h3>No of Players</h3><span><?php echo '<b>: </b>'."( ".count($results)."/".$tournamentInfo->MAX_PLAYERS." )"; ?></span></div>
        <div style="width:300px;float:left;"><h3>End Date & Time</h3><span><?php echo '<b>: </b>'.$results[0]->ENDED; ?></span></div>
        <div style="width:300px;float:left;"><h3>Coin Type</h3><span><?php echo '<b>: </b>'.$this->game_model->getCoinNameById($results[0]->COIN_TYPE_ID); ?></span></div>
        <div style="width:300px;float:left;"><h3>Total Rake</h3><span><?php echo '<b>: </b>'.$totalRake; ?></span></div>
        <div style="width:300px;float:left;"><h3>Rake Percentage</h3><span><?php echo '<b>: </b>'.$RAKE_PERCENT; ?></span></div>
        <div style="width:300px;float:left;"><h3>Closing Pot Amount</h3><span><?php echo '<b>: </b>'.$closing_pot_amount; ?></span></div>
    </div>        
</div>
      
    
	<div class="userdetail_searchgame" style=" min-width:750">
		<ul style="max-width:1035px;">
        	<li style="min-width:175px;width:175px;"><h3 class="header_searchgame">Player ID</h3></li>
            <li style="min-width:185px;width:185px;"><h3 class="header_searchgame">Hand ID</h3></li>
              <li style="min-width:311px;width:311px;"><h3 class="header_searchgame">Cards</h3></li>
             <li style="min-width:82px;width:80px;"><h3 class="header_searchgame">Bet</h3></li>
           <li style="min-width:82px;width:80px;"><h3 class="header_searchgame">Forced Bet</h3></li>
            <li style="min-width:92px;width:90px;"><h3 class="header_searchgame">Rake</h3></li>
            <li style="min-width:85px;width:85px;"><h3 class="header_searchgame">Win</h3></li>
        </ul>
<ul class="cnt_userprofile" style="max-width:1035px;">
<?php  //echo "<pre>"; print_r($results); die; 
//echo "<pre>"; print_r($playdata1); die;
	$cntRes = count($results);
	for($i=0;$i<$cntRes;$i++){	 ?>
    	<li style="min-width:175px;width:175px;">
        	<div class="searchgame_cardcnt">
            	<p class="usrname">
				<?php	echo $results[$i]->USERNAME;
						$playdata=json_decode($results[$i]->PLAY_DATA,true);
						$cnt = count($playdata['playResult']['playerHand']);	
						for($j=0;$j<$cnt;$j++){
							if($playdata['playResult']['playerHand'][$j]['userName'] == $results[$i]->USERNAME){
								$cardValue = $playdata['playResult']['playerHand'][$j]['value'];
								$playerCards = $playdata['playResult']['playerHand'][$j]['cardsAsString'];
								$valueInfo = $playdata['playResult']['playerIndex'];
								$handOutCome = $playdata['playResult']['playerHand'][$j]['handOutcome'];
								if($playdata['playResult']['bankerIndex']==$valueInfo){
									echo " (<font color='green'>Banker</font>)";
								}else{
									if($handOutCome=='Win'){
										echo "<img src='".base_url()."static/images/star.png'>";
									}
								}
							}
						}	 ?>
                </p>
            </div>
        </li>
        <li style="min-width:185px;width:185px;">
	        <div class="searchgame_cardcnt">
    	    	<p class="usrname"><?PHP echo $results[$i]->GAME_REFERENCE_NO; ?></p>
            </div>
        </li>
        <li style="min-width:311px;width:311px;">
        	<div class="searchgame_cardcnt">
            	<p class="usrname">
                
					<span><b><?php echo "(".$cardValue.")";?></b></span>
					<?php   $cardValues = explode(',',$playerCards);
							foreach($cardValues as $Value){
								if($Value!=""){
									echo '<p><img src="'.base_url().'static/images/minigame/shan/'.$Value.'.png"></p>';
								}
							}	?>
                </p>
            </div>
        </li>   
        <li style="min-width:82px;width:82px;">
        	<div class="searchgame_cardcnt">
            	<p class="usrname"><?PHP echo $results[$i]->STAKE; ?></p>
            </div>
        </li>
        <li style="min-width:82px;width:82px;">
        	<div class="searchgame_cardcnt">
            	<p class="usrname">
				<?PHP 
					$getForceBetData = $this->game_model->getForceBetData($results[$i]->GAME_REFERENCE_NO);
					if(!empty($getForceBetData))  {
						echo $getForceBetData[0]->FORCED_BET;
					} else {
						echo "0.00";	
					}
				?></p>
            </div>
        </li>        
		<li style="min-width:92px;width:92px;">
        	<div class="searchgame_cardcnt">
            	<p class="usrname"><?PHP 
					if($results[$i]->RAKE!=''){
						echo $results[$i]->RAKE;
					}else{
						echo "0.00";
					}	 ?></p>
            </div>
        </li>     
        <li style="min-width:85px;width:85px;">
        	<div class="searchgame_cardcnt">
        		<p class="usrname"><?PHP
					if($results[$i]->WIN!=''){ 
						echo $results[$i]->WIN;
					}else{
						echo "0.00";
					} ?>
                </p>
 		    </div>
        </li>                 
<?php } ?>
</ul>




