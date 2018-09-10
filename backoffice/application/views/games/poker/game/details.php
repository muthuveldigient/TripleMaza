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
.container_searchgame ul li {	border-right:1px solid #71d0ff;	overflow:hidden;	min-width:171px;	}
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
					#Get total wins
					for($i=0;$i<count($results);$i++){
						if($results[$i]->WIN!='0.00'){
							if($winners_id){
							$winners_id=$winners_id.",".$results[$i]->USER_ID;
							}else{
							$winners_id=$results[$i]->USER_ID;
							}
						}
						$totalwin=$totalwin+$results[$i]->WIN;
						$totalrevenue=$totalrevenue+$results[$i]->REVENUE;
						if($results[$i]->RAKE!='0.00'){
						$rake_percentage=$results[$i]->RAKE;
						}
					}
					
					$playdata=json_decode($results[0]->PLAY_DATA,true);
					if($winners_id){
						if(strstr($winners_id,",")){
							$users_list=explode(",",$winners_id);
							for($u=0;$u<count($users_list);$u++){
								if($playdata['playResult']['userDetails']){
									for($d=0;$d<count($playdata['playResult']['userDetails']);$d++){
										$userid=$playdata['playResult']['userDetails'][$d]['userId'];
										if(in_array($userid,$users_list)){
											$matchcardslist=explode(",",$playdata['playResult']['userDetails'][$d]['matchCards']);
											for($r=0;$r<count($matchcardslist);$r++){
												if($matchcardslist[$r]!='card_back'){
													$matchcards[]=$matchcardslist[$r];
												}
											}
											
										}			
									}
								}
							}
						}else{
							if($playdata['playResult']['userDetails']){
									for($d=0;$d<count($playdata['playResult']['userDetails']);$d++){
										$userid=$playdata['playResult']['userDetails'][$d]['userId'];
										$users_list=$winners_id;
	
										if($userid==$users_list){
											$matchcardslist=explode(",",$playdata['playResult']['userDetails'][$d]['matchCards']);
											for($r=0;$r<count($matchcardslist);$r++){
												if($matchcardslist[$r]!='card_back'){
													$matchcards[]=$matchcardslist[$r];
												}
											}
										}			
									}
							}
						}
					}
					
					//print_r($matchcards);
					
					if($results[0]->PLAY_DATA){
						$playdata=json_decode($results[0]->PLAY_DATA,true);
						if($playdata['playResult']['dealerHand'][0]){
						  for($i=0;$i<count($playdata['playResult']['dealerHand']);$i++){
						  	$dealercard=$playdata['playResult']['dealerHand'][$i]['clientCard'];
							if($dealercard){
								if(in_array($dealercard,$matchcards)){
									$borderstyle='border:2px solid #006633;background-color:#006633;';
								}else{
									$borderstyle='';
								}
								
								echo '<p style="padding-left:0;'.$borderstyle.'"><img src="'.base_url().'static/images/minigame/poker/'.$dealercard.'.png"></p>';
							}
						  }
						}else{
							$dealercard=$playdata['playResult']['dealerHand']['clientCard'];
							if($dealercard){
								if(in_array($dealercard,$matchcards)){
									$borderstyle='border:2px solid #006633;background-color:#006633;';
								}else{
									$borderstyle='';
								}
								echo '<p style="$borderstyle"><img src="'.base_url().'static/images/minigame/poker/'.$dealercard.'.png"></p>';
							}
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
            <div style="float: left;width: 160px;"><h3>Rake Cap(<=3):</h3><span><?php echo floor($rake->RAKE_CAP);?></span></div>
            </div>    
            
            
    	   <div class="rake">
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
           </div> 
           <!--<div style="width:250px;float:left;"><h3>Date & Time:</h3><span><?php //echo date('d/m/Y h:i:s',strtotime($gameHistoryData[0]->STARTED));?></span></div>-->   
    	</div>
      
      <div class="container_searchgame">
    	<ul>
        	<li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Player ID</h3></li>
            <li><h3 class="header_searchgame">Hand ID</h3></li>
            <li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Bet</h3></li>
            <li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Status</h3></li>
            <li style="min-width:30px"><h3 class="header_searchgame" style="min-width:75px">Rake</h3></li>
            <li style="min-width:308px;"><h3 class="header_searchgame">Card</h3></li>
        </ul>
    			
    	 <?php
	  if(isset($results)){ 
			if(count($results)>0 && is_array($results)){
				for($i=0;$i<count($results);$i++){
					if($results[$i]->PLAY_DATA){
								$playdata=json_decode($results[$i]->PLAY_DATA,true);
								$wintype=$playdata['playResult']['winType'];
								for($k=0;$k<count($playdata['playResult']['userHandCards']);$k++){
								   if($playdata['playResult']['userDetails'][$k]['userId']==$results[$i]->USER_ID){
								   		$smallblind=$playdata['playResult']['userDetails'][$k]['smallBlind'];
										$bigblind=$playdata['playResult']['userDetails'][$k]['bigBlind'];
										$tableindex=$playdata['playResult']['userDetails'][$k]['tableIndex'];
								if($results[0]->MINIGAMES_TYPE_NAME=='Omaha'){
										$userHands=$playdata['playResult']['userHandCards'][$tableindex][0]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][1]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][2]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][3]['clientCard'];
								}else{
										$userHands=$playdata['playResult']['userHandCards'][$tableindex][0]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][1]['clientCard'];
								}
								   }
								}
					}
		?>		
    		<ul class="cnt_userdetails">
                    <li style="min-height:45px;min-width:135px">
                        <div class="searchgame_cardcnt">
                            <p class="usrname"><?PHP
							 //GET USERNAME FROM USERID
							 $playerName  = $this->game_model->getUserName($results[$i]->USER_ID);
							
							 echo $playerName; ?></p>
                        </div>
                    </li>
                    <li>
                    <div class="searchgame_cardcnt">
                    <p class="usrname"><?PHP echo $results[$i]->GAME_REFERENCE_NO; ?></p>
                    </div>
                    </li>
                    <li style="min-height:45px;min-width:135px">
                    <div class="searchgame_cardcnt">
                    <p class="usrname"><?PHP echo $results[$i]->STAKE; ?></p>
                    </div>
                    </li>
                    <li style="min-height:45px;min-width:135px">
                    <div class="searchgame_cardcnt">
					<p class="usrname">
							<?PHP 
							  if($results[$i]->WIN!='0.00'){ 
							  		$winuser_id=$results[$i]->USER_ID;
							  ?>
							   <div style="clear:both">
                                    <p style="line-height:10px;padding-top:35px;">							  
                           				<?php echo "Win (".$results[$i]->WIN.")"; ?>
									</p>
                                </div>    
							<?php	
							    if($wintype){ ?>
                                <div style="clear:both">
                                	<p style="line-height:10px;">
										<?php echo "<br/>".str_replace("_"," ",$wintype); ?>
                                	</p>
								</div>
                            <?php }   
							  }else{
							    echo "Loss";
							  }
							  ?> 
                     </p>
                    </div>
                    </li>
                    <li style="min-height:45px;min-width:135px">
                    <div class="searchgame_cardcnt">
                    	<p class="usrname"><?PHP echo $results[$i]->REVENUE; ?></p>
                    </div>
                    </li>
                    <li style="min-width:308px;">
                          <div class="searchgame_cardcnt">
                          	 <?php
							  if($userHands){
							    if(strstr($userHands,",")){
							  		$usercard_details=explode(",",$userHands); 
									if($playdata['playResult']['userDetails']){
										for($d=0;$d<count($playdata['playResult']['userDetails']);$d++){
											$userid=$playdata['playResult']['userDetails'][$d]['userId'];
											if($winuser_id==$userid){
												$matchcardslist=explode(",",$playdata['playResult']['userDetails'][$d]['matchCards']);
												for($r=0;$r<count($matchcardslist);$r++){
													if($matchcardslist[$r]!='card_back'){
														$matchcards1[]=$matchcardslist[$r];
													}
												}
											}			
										}
								    }
									
									if(in_array($usercard_details[0],$matchcards1)){
										$borderstyle='border:2px solid #006633;background-color:#006633;';
									}else{
										$borderstyle='';
									}
									
									if(in_array($usercard_details[1],$matchcards1)){
										$borderstyle1='border:2px solid #006633;background-color:#006633;';
									}else{
										$borderstyle1='';
									}
									if($results[0]->MINIGAMES_TYPE_NAME=='Omaha'){
										if(in_array($usercard_details[2],$matchcards1)){
											$borderstyle2='border:2px solid #006633;background-color:#006633;';
										}else{
											$borderstyle2='';
										}
									
										if(in_array($usercard_details[3],$matchcards1)){
											$borderstyle3='border:2px solid #006633;background-color:#006633;';
										}else{
											$borderstyle3='';
										}
									}																									
									if($winuser_id==$results[$i]->USER_ID) {
										$userWinHandsData = json_decode($results[0]->PLAY_DATA,true);										
										$userWHDUserIDs = $userWinHandsData["playResult"]["winHands"]["userWinHands"][$winuser_id];
										$wHBorderStyle1 = 'border:2px solid #006633;background-color:#006633;';
										$wHBorderStyle = '';
										
										if($userWHDUserIDs["0"]["clientCard"]==$usercard_details[0])
											echo '<p style="'.$wHBorderStyle1.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[0].'.png"></p>';
										else
											echo '<p style="'.$wHBorderStyle.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[0].'.png"></p>';
										
										if($userWHDUserIDs["1"]["clientCard"]==$usercard_details[1])	
											echo '<p style="'.$wHBorderStyle1.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[1].'.png"></p>';									
										else
											echo '<p style="'.$wHBorderStyle.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[1].'.png"></p>';										
									} else {									
										echo '<p style="'.$borderstyle.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[0].'.png"></p>';
										echo '<p style="'.$borderstyle1.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[1].'.png"></p>';
									}
									if($results[0]->MINIGAMES_TYPE_NAME=='Omaha'){
										echo '<p style="'.$borderstyle2.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[2].'.png"></p>';
										echo '<p style="'.$borderstyle3.'"><img src="'.base_url().'static/images/minigame/poker/'.$usercard_details[3].'.png"></p>';
									}
								}else{
									echo '<p><img src="'.base_url().'static/images/minigame/poker/'.$userHands.'.png"></p>';
								}
							  }
							  ?>
                          </div>
                    </li>
           </ul>
        <?php
	 		}
	   	}
	  }
	 ?>     
        </div>
      
	<div style="clear:both;padding-left:20px;">Note: (OTHER) indicates Post BB / Straddle</div>    
	<div class="userdetail_searchgame">
	<ul>
        	<li style="min-width:135px"><h3 class="header_searchgame">Player ID</h3></li>
            <li style="min-width:190px;"><h3 class="header_searchgame">Pre Flop</h3></li>
            <li style="min-width:190px;"><h3 class="header_searchgame">Flop</h3></li>
            <li style="min-width:150px;"><h3 class="header_searchgame">Turn</h3></li>
            <li style="min-width:150px;"><h3 class="header_searchgame">River</h3></li>	
        </ul>
    
	
      
      <?php
	  if(isset($results)){ 
			if(count($results)>0 && is_array($results)){
				for($i=0;$i<count($results);$i++){
						
						if($results[$i]->PLAY_DATA){
								$playdata=json_decode($results[$i]->PLAY_DATA,true);
								/* echo "<pre>";
								print_r($playdata);
								echo "</pre>"; */
								
								
								for($k=0;$k<count($playdata['playResult']['userDetails']);$k++){
								   if($playdata['playResult']['userDetails'][$k]['userId']==$results[$i]->USER_ID){
								   		$smallblind=$playdata['playResult']['userDetails'][$k]['smallBlind'];
										$bigblind=$playdata['playResult']['userDetails'][$k]['bigBlind'];
										$tableindex=$playdata['playResult']['userDetails'][$k]['tableIndex'];
										
										$userHands=$playdata['playResult']['userHandCards'][$tableindex][0]['clientCard'].",".$playdata['playResult']['userHandCards'][$tableindex][1]['clientCard'];
								   }
								}
						}
			  ?>
              	<ul class="cnt_userprofile" >
                    <li style="min-width:135px;">
                        <div class="searchgame_cardcnt">
                            <p class="usrname"><?PHP 
							$playerName  = $this->game_model->getUserName($results[$i]->USER_ID);
							
							 echo $playerName;
							//echo $results[$i]->USERNAME; ?></p>
                        </div>
                    </li>
                    <li style="min-width:190px;"> 
                    	<div class="searchgame_cardcnt">
                        	<p class="usrname">
                        	<?PHP 
							  if(count($playdata['playResult']['userAction'])>0){
										if(count($playdata['playResult']['userAction']['ROUND:0'])>0){
/*echo "<pre>";
print_r($playdata['playResult']['userAction']['ROUND:0']);die;*/
											for($l=0;$l<count($playdata['playResult']['userAction']['ROUND:0']);$l++){
												$round='ROUND:0';
												$turn='TURN:'.$l;
												if(count($playdata['playResult']['userAction'][$round][$turn])>0){
													for($m=0;$m<count($playdata['playResult']['userAction'][$round][$turn]);$m++){
															
														$userid=$playdata['playResult']['userAction'][$round][$turn][$m]['userId'];
														//$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
														//echo "userid".$userid;
														if($userid==$results[$i]->USER_ID){ ?>
																<div style="clear:both">
                                                            <p style="line-height:20px;">	
                                                            <?php 
															$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
															if($action!=''){
																$betamt=$playdata['playResult']['userAction'][$round][$turn][$m]['currentAmount'];
															    if($betamt){
																	echo $betamt;
																}
															     if($action=='OTHER_ACTION' && $betamt=="") {
																$newaction="";				
															     } else {
															?> ( <?php 
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
															echo $newaction;  ?> )															
													<?php 	} }	?>
                                                            </p>
                                                            </div><?php if(!empty($newaction)) echo "</br>";?>
							<?php                                                            
														}
													}
												}
											}
										}
							  }
							  ?>
                            </p>  
                        </div>        
                    </li>
                    <li style="min-width:190px">
                    	<div class="searchgame_cardcnt">
                        	<p class="usrname">
                        	<?PHP 
							
							  if(count($playdata['playResult']['userAction'])>0){
										if(count($playdata['playResult']['userAction']['ROUND:1'])>0){
											for($mn=0;$mn<count($playdata['playResult']['userAction']['ROUND:1']);$mn++){
												$round='ROUND:1';
												$turn='TURN:'.$mn;
												//echo count($playdata['playResult']['userAction'][$round][$turn]); die;
												if(count($playdata['playResult']['userAction'][$round][$turn])>0){
													for($m=0;$m<count($playdata['playResult']['userAction'][$round][$turn]);$m++){
													
														$userid=$playdata['playResult']['userAction'][$round][$turn][$m]['userId'];
														//$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
														//echo "userid".$userid;
														if($userid==$results[$i]->USER_ID){ ?>
																<div>
                                                            <p style="line-height:15px">	
                                                            <?php 
															$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
															if($action != ''){
																$betamt=$playdata['playResult']['userAction'][$round][$turn][$m]['currentAmount'];
															    if($betamt){
																	echo $betamt;
																}
															     if($action=='OTHER_ACTION' && $betamt=="") {
																$newaction="";				
															     } else {	
															?> ( <?php 			
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
															echo $newaction; ?> )															
													<?php	} }	?>
                                                            </p>
                                                            </div><?php if(!empty($newaction)) echo "</br>";?>

							<?php                                                            
														}
													}
												}
											}
										}
							  }
							  ?>
                            </p>  
                        </div> 
                    </li>
                    <li style="min-width:150px;">
                    	<div class="searchgame_cardcnt">
                        	<p class="usrname">
                        	<?PHP 
							
							  if(count($playdata['playResult']['userAction'])>0){
										if(count($playdata['playResult']['userAction']['ROUND:2'])>0){
											for($l=0;$l<count($playdata['playResult']['userAction']['ROUND:2']);$l++){
												$round='ROUND:2';
												$turn='TURN:'.$l;
												if(count($playdata['playResult']['userAction'][$round][$turn])>0){
													for($m=0;$m<count($playdata['playResult']['userAction'][$round][$turn]);$m++){
															
														$userid=$playdata['playResult']['userAction'][$round][$turn][$m]['userId'];
														//$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
														//echo "userid".$userid;
														if($userid==$results[$i]->USER_ID){ ?>
																<div>
                                                            <p style="line-height:15px">	
                                                            <?php 
															$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
															if($action!=''){
																$betamt=$playdata['playResult']['userAction'][$round][$turn][$m]['currentAmount'];
															    if($betamt){
																	echo $betamt;
																}
															     if($action=='OTHER_ACTION' && $betamt=="") {
																$newaction="";				
															     } else {	
															?> ( <?php 
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
															echo $newaction;  ?> )
													<?php	} }	?>
                                                            </p>
                                                            </div><?php if(!empty($newaction)) echo "</br>";?>

							<?php                                                            
														}
													}
												}
											}
										}
							  }
							  ?>
                            </p>  
                        </div> 
                    </li>
					<li style="min-width:150px;">
                    	<div class="searchgame_cardcnt">
                        	<p class="usrname">
                        	<?PHP 
							
							  if(count($playdata['playResult']['userAction'])>0){
										if(count($playdata['playResult']['userAction']['ROUND:3'])>0){
											for($l=0;$l<count($playdata['playResult']['userAction']['ROUND:3']);$l++){
												$round='ROUND:3';
												$turn='TURN:'.$l;
												if(count($playdata['playResult']['userAction'][$round][$turn])>0){
													for($m=0;$m<count($playdata['playResult']['userAction'][$round][$turn]);$m++){
															
														$userid=$playdata['playResult']['userAction'][$round][$turn][$m]['userId'];
														//$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
														//echo "userid".$userid;
														if($userid==$results[$i]->USER_ID){ ?>
																<div>
                                                            <p style="line-height:15px">	
                                                            <?php 
															$action=$playdata['playResult']['userAction'][$round][$turn][$m]['action'];
															if($action!=''){
																$betamt=$playdata['playResult']['userAction'][$round][$turn][$m]['currentAmount'];
															    if($betamt){
																	echo $betamt;
																}
															     if($action=='OTHER_ACTION' && $betamt=="") {
																$newaction="";				
															     } else {	
															?> ( <?php 
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
															echo $newaction;  ?> ) 															
													<?php 	} }	?>
                                                            </p>
                                                            </div><?php if(!empty($newaction)) echo "</br>";?>

							<?php                                                            
														}
													}
												}
											}
										}
							  }
							  ?>
                            </p>  
                        </div>
                    </li>
           </ul>
     <?php	}
	   	}
	  }	 ?> 