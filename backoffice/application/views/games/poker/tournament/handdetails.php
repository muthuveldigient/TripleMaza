<?php
//echo "<pre>";
//print_r($results[0]->PLAY_DATA);die;
//echo "</pre>"; die;
$potamount=$results[0]->POT_AMOUNT;

$potAmoutDats = json_decode($gameHistoryData[0]->SIDE_POT,true);
?>
<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<style>
*{	margin:0;	padding:0;	font-family:Arial, Helvetica, sans-serif;	}
	li{		list-style:none;		float:left;		}
.container_searchgame{	padding:1px;	border:1px solid #dff4ff;	overflow:hidden;	margin:10px 20px;	min-width:600px;	float:left;	}
.container_searchgame ul {	overflow:hidden;	min-width:600px;	}
.container_searchgame ul li {	border-right:1px solid #71d0ff;	overflow:hidden;	min-width:190px;	}
.cnt_userdetails li{	min-height:105px;	background-color:#d2f0ff;	}
.container_searchgame ul li h3{	margin:0;	line-height:38px;	font-size:13px;	color:#fff;	font-family:Arial, Helvetica, sans-serif;	padding:0 30px;	height:	39px;
	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);	background-repeat:repeat-x;	text-align:center;	}
.searchgame_cardcnt{	overflow:hidden;	background-color:#d2f0ff;	padding:9px;	min-height:90px;	text-align:center;	min-width:101px;	}
.searchgame_cardcnt p{	font-size:13px;	color:#333333;	float:left;	margin-left:5px;	text-align:center;	}
.searchgame_cardcnt p.usrname{	line-height:87px;	}
.userdetail_searchgame{	padding:1px;	border:1px solid #dff4ff;	overflow:hidden;	margin:10px 20px;	min-width:600px;	float:left;	}
.userdetail_searchgame ul {	overflow:hidden;	min-width:600px;	}
.userdetail_searchgame ul li {	border-right:1px solid #71d0ff;	overflow:hidden;	min-width:115px;	}	
.userdetail_searchgame ul li h3{	margin:0;	line-height:38px;	font-size:13px;	color:#fff;	font-family:Arial, Helvetica, sans-serif;	padding:0 30px;
	height:	39px;	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);	background-repeat:repeat-x;	text-align:center;	}
.table_card{	margin: 20px 20px;	overflow:hidden;	}
.table_card h3{	margin:0;	font-size:13px;	font-family:Arial, Helvetica, sans-serif;	}
.cnt_userprofile{	display:table;	}
.cnt_userprofile li{	min-height:135px;	background-color:#d2f0ff;	display:table-cell;	}
.tablecards p{	float:left;	padding-left:10px;	}
.tablecard_cnt{	width:370px;	overflow:hidden;	float:left;	}
.tablecard_cnt h3{	text-align:left;	margin:0 10px 10px 0;	}
.potamount{	width:210px;	overflow:hidden;	float:left;	margin-top:20px;	}
.potamount h3{	text-align:right;	margin-bottom:10px;	float:left;	line-height:20px;	width:100px;	}
.potamount span{	float:left;	line-height:20px;		margin-left:5px;	font-size:13px;	}
.rake{	width:250px;	overflow:hidden;	float:left;	margin-top:20px;	}
.rake h3{	text-align:right;	margin-bottom:10px;	float:left;	line-height:20px;	width:100px;	}
.rake span{	float:left;	line-height:20px;	margin-left:5px;	font-size:13px;		}
</style>
        
        <div class="table_card">
            <div class="tablecard_cnt">
                <h3>Table card:</h3>
                    <div class="tablecards">
                    	<?php
				
						
					if(isset($results)){ 
						if(count($results)>0 && is_array($results)){
							//table cards
							$tableCards = $results[0]->TABLE_CARD;
							if($tableCards != ''){
								$explodeTableCards  = explode(",",$tableCards);
								foreach($explodeTableCards as $tablecard){
								   echo '<p style="padding-left:0;'.$borderstyle.'"><img src="'.base_url().'static/images/minigame/poker/'.$tablecard.'.png"></p>';		
								}
							}
						}
	  			}	
			 
			 ?>
                    </div>
            </div>
        
        	<div class="potamount">
          	<div style="float: left;width: 160px;"><h3>Pot Amount:</h3><span><?php echo $gameHistoryData[0]->TOTAL_POT;?></span></div>
            <div style="float: left;width: 160px;"><h3>Win Amount:</h3><span><?php echo $gameHistoryData[0]->TOTAL_WIN;?></span></div>
            <div style="float: left;width: 160px;"><h3>Revenue:</h3><span><?php echo $gameHistoryData[0]->TOTAL_REVENUE;?></span></div>
            <div style="float: left;width: 160px;"><h3>Main Pot:</h3><span><?php echo $potAmoutDats["potBetOrder"][0];?></span></div>
           <!-- <div style="float: left;width: 160px;"><h3>Rake Cap(<=3):</h3><span><?php echo floor($rake->RAKE_CAP);?></span></div>-->
            </div>    
        
    	   <!--<div class="rake">
            <div style="width:250px;float:left;"> 
            	<h3>Rake:</h3><span><?php echo $rake->RAKE;?> %</span>
             </div>
             <div style="width:250px;float:left;"><h3>Rake(Headsup):</h3><span><?php echo $rake->RAKE1;?> %</span></div>
             <div style="width:250px;float:left;"><h3>Rake Applied:</h3><span>
			 <?php if($gameHistoryData[0]->APP_RAKE_PERCENTAGE=="0.00") echo "0"; else echo $gameHistoryData[0]->APP_RAKE_PERCENTAGE;?> %</span></div>
             <?php if(count($potAmoutDats["potBetOrder"])>1) {?>
             <div style="float: left;width: 160px;">
             	<h3>Side Pot:</h3>
                	<span>
						<?php
							$sPots=1;
							foreach($potAmoutDats["potBetOrder"] as $sPIndex=>$sidePotData) {
								if($sPIndex!=0) {
									if($sPots==1)
										echo $sidePotData;
									else
										echo ",".$sidePotData;
										
									$sPots++;	
								}
							}
						?>
                    </span>
             </div>
             <?php } ?>
             <div style="float: left;width: 160px;"><h3>Rake Cap(>3):</h3><span><?php echo floor($rake->RAKE_CAP1);?></span></div>
           </div>--> 
           <!--<div style="width:250px;float:left;"><h3>Date & Time:</h3><span><?php //echo date('d/m/Y h:i:s',strtotime($gameHistoryData[0]->STARTED));?></span></div>-->   
    	</div>
      
      <div class="container_searchgame">
    	<ul>
        	<li style="min-width:30px"><h3 class="header_searchgame" style="min-width:70px">Player ID</h3></li>
            <li><h3 class="header_searchgame">Hand ID</h3></li>
            <li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Bet</h3></li>
            <li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Status</h3></li>
           <!-- <li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Rake</h3></li>-->
            <li style="min-width:308px;"><h3 class="header_searchgame">Card</h3></li>
        </ul>
    	<?php
		if(isset($results)){ 
  			if(count($results)>0 && is_array($results)){
	  			foreach($results as $resData){
	  	 			 $playerId   = $resData->USER_ID;	
					 $getPlayerName=$this->tournament_model->getPlayerName($resData->USER_ID);				 
					 $playerName = $getPlayerName[0]->USERNAME; 
					 $refNo      = $resData->INTERNAL_REFERENCE_NO;
					 $win		 = $resData->WIN;
					 $revenue    = $resData->REVENUE;
					 $stake		 = $resData->STAKE;
					 $potAmount  = $resData->POT_AMOUNT;
					 $playerCards= $resData->PLAYER_CARD;
					 $tableCards = $resData->TABLE_CARD;
					 $winType    = $resData->WIN_TYPE;
					 $preFlop    = $resData->PRE_FLOP;
					 $flop 		 = $resData->FLOP;
					 $TURN       = $resData->TURN; 
					 $RIVER      = $resData->RIVER; 
					 if($win !='0.00'){ 
					   $status = 'Win';
					 }else{
					   $status = 'Loss';
					 }
		?>    			
    	<ul class="cnt_userdetails">
    <li style="min-height:45px;min-width:131px">
      <div class="searchgame_cardcnt">
        <p class="usrname"><?php echo $playerName; ?></p>
      </div>
    </li>
    <li>
      <div class="searchgame_cardcnt">
        <p class="usrname"><?php echo $refNo; ?></p>
      </div>
    </li>
    <li style="min-height:45px;min-width:135px">
      <div class="searchgame_cardcnt">
        <p class="usrname"><?php echo $stake; ?></p>
      </div>
    </li>
    <li style="min-height:45px;min-width:135px">
      <div class="searchgame_cardcnt">
        <p class="usrname">
        <div style="clear:both">
          <p style="line-height:10px;padding-top:35px;">
            <?php
		  if($status == 'Win'){
		   echo "$status ($win)";
		  }else{
		   echo "$status"; 
		  } ?>
          </p>
        </div>
        <?php if($status == 'Win'){ ?>
        <div style="clear:both">
          <?php if($winType != '' && $winType != 'null'){ ?>
          <p style="line-height:10px;"> <?php echo "<br/>".str_replace("_"," ",$winType); ?> </p>
          <?php } ?>
        </div>
        <?php } ?>
        </p>
      </div>
    </li>
    <!--<li style="min-height:45px;min-width:135px">
      <div class="searchgame_cardcnt">
        <p class="usrname"><?php echo $revenue; ?></p>
      </div>
    </li>-->
    <li style="min-width:308px;">
      <div class="searchgame_cardcnt">
        <?php
		if($playerCards != ''){
			$explodePlayerCards = explode(",",$playerCards);
			foreach($explodePlayerCards as $playercard){
				echo '<p><img src="'.base_url().'static/images/minigame/poker/'.$playercard.'.png"></p>';
			}
		}
 	  ?>
      </div>
    </li>
  </ul>
  		<?php }
		  }
		}
		?>
        
        
          
        </div>
      
	<div style="clear:both;padding-left:20px;">Note: (OTHER) indicates Post BB / Straddle</div>
<div class="userdetail_searchgame">
<ul>
  <li style="min-width:135px">
    <h3 class="header_searchgame">Player ID</h3>
  </li>
  <li style="min-width:190px;">
    <h3 class="header_searchgame">Pre Flop</h3>
  </li>
  <li style="min-width:190px;">
    <h3 class="header_searchgame">Flop</h3>
  </li>
  <li style="min-width:150px;">
    <h3 class="header_searchgame">Turn</h3>
  </li>
  <li style="min-width:150px;">
    <h3 class="header_searchgame">River</h3>
  </li>
</ul>
<?PHP
 if(isset($results)){ 
  	if(count($results)>0 && is_array($results)){
	  foreach($results as $resData2B){
	  	$playerId2B   = $resData2B->USER_ID;
		$getPlayerName2=$this->tournament_model->getPlayerName($resData2B->USER_ID);
		$playerName2B = $getPlayerName2[0]->USERNAME;
		 
		 $preFlop2B    = $resData2B->PRE_FLOP;
		 $flop2B	   = $resData2B->FLOP;
		 $turn2B       = $resData2B->TURN; 
		 $river2B      = $resData2B->RIVER; 
		 
?>
    <ul class="cnt_userprofile" >
      <li style="min-width:135px;">
        <div class="searchgame_cardcnt">
          <p class="usrname"><?php echo $playerName2B; ?></p>
        </div>
      </li>
      <li style="min-width:190px;">
        <div class="searchgame_cardcnt">
          <p class="usrname">
          <div style="clear:both">
            <p style="line-height:20px;">
            <?php 
			 if($preFlop2B != ''){
			   $explodePreFlop2B = explode(",",$preFlop2B);
			   $countPreFlop = count($explodePreFlop2B);
			   if($countPreFlop > 0){
			     foreach($explodePreFlop2B as $preFlopVal){
				 	if($preFlopVal != ''){
					  $explodeInnerValue = explode(":",$preFlopVal);
					  $actionName  = $explodeInnerValue[0];
					  $betAmount   = $explodeInnerValue[1];
					  $curAmount   = $explodeInnerValue[2];
					  
					 if($curAmount != '' && $curAmount != 0)
					  echo $curAmount;
					  if($actionName != '')
					  echo ' ('.getActionNameString($actionName).')';					  
					}
					echo "<br />";
				 }
			   }
			 }
			?> 
           </p>            
          </div>
          </p>
        </div>
      </li>
      <li style="min-width:190px">
        <div class="searchgame_cardcnt">
          <p class="usrname">
          <div>
            <p style="line-height:15px"><?php 
			 if($flop2B != ''){
			   $explodeFlop2B = explode(",",$flop2B);
			   $countFlop = count($explodeFlop2B);
			   if($countFlop > 0){
			     foreach($explodeFlop2B as $flopVal){
				 	if($flopVal != ''){
					  $explodeFlopValue = explode(":",$flopVal);
					  $actionName  = $explodeFlopValue[0];
					  $betAmount   = $explodeFlopValue[1];
					  $curAmount   = $explodeFlopValue[2];
					  
					  if($curAmount != '' && $curAmount != 0)
					  echo $curAmount;
					  if($actionName != '')
					  echo ' ('.getActionNameString($actionName).')';					  
					}
					echo "<br />";
				 }
			   }
			 }
			?> </p>
          </div>
          </p>
        </div>
      </li>
      <li style="min-width:150px;">
        <div class="searchgame_cardcnt">
          <p class="usrname">
          <div>
            <p style="line-height:15px"><?php 
			 if($turn2B != ''){
			   $explodeTurn2B = explode(",",$turn2B);
			   $countTurn = count($explodeTurn2B);
			   if($countTurn > 0){
			     foreach($explodeTurn2B as $turnVal){
				 	if($turnVal != ''){
					  $explodeTurnValue = explode(":",$turnVal);
					  $actionName  = $explodeTurnValue[0];
					  $betAmount   = $explodeTurnValue[1];
					  $curAmount   = $explodeTurnValue[2];
					  
					  if($curAmount != '' && $curAmount != 0)
					  echo $curAmount;
					  if($actionName != '')
					  echo ' ('.getActionNameString($actionName).')';					  
					}
					echo "<br />";
				 }
			   }
			 }
			?>  </p>
          </div>
          </p>
        </div>
      </li>
      <li style="min-width:150px;">
        <div class="searchgame_cardcnt">
          <p class="usrname">
          <div>
            <p style="line-height:15px"> <?php 
			 if($river2B != ''){
			   $explodeRiver2B = explode(",",$river2B);
			   $countRiver = count($explodeRiver2B);
			   if($countRiver > 0){
			     foreach($explodeRiver2B as $riverVal){
				 	if($riverVal != ''){
					  $explodeRiverValue = explode(":",$riverVal);
					  $actionName  = $explodeRiverValue[0];
					  $betAmount   = $explodeRiverValue[1];
					  $curAmount   = $explodeRiverValue[2];
					  
					  if($curAmount != '' && $curAmount != 0)
					  echo $curAmount;
					  if($actionName != '')
					  echo ' ('.getActionNameString($actionName).')';					  
					}
					echo "<br />";
				 }
			   }
			 }
			?>  </p>
          </div>
          </p>
        </div>
      </li>
    </ul>
<?php 
		}
	}
}
	
function getActionNameString($action){
	switch($action){
		case 'CHECKACTION':
			$newaction='CHECK';
		break;
		case 'OTHER_ACTION':
			$newaction='OTHER';
		break;
		case 'FOLDACTION':
			$newaction='FOLD';
		break;
		case 'CALLACTION':
			$newaction='CALL';
		break;
		case 'RAISEDACTION':
			$newaction='RAISED';
		break;
		case 'ALLINACTION':
			$newaction='ALLIN';
		break;
		case 'SITACTION':
			$newaction='SIT';
		break;
		case 'BACKACTION':
			$newaction='BACK';
		break;
		case 'STANDACTION':
			$newaction='STAND';
		break;
		case 'BB_ACTION':
			$newaction='BB';
		break;
		case 'SB_ACTION':
			$newaction='SB';
		break;
	}
	
	return $newaction;
}


?>