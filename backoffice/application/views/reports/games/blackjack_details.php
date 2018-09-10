<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
  <div class="tableWrap">
    <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php echo ucfirst(strtolower($gameName));?></div>
      </div>
    </div>
    <div class="Agent_game_Left" style="width:350px;">
      <div class="Agent_game_tit_wrap" style="width:290px;">
        <div class="Agent_game_name">Hand ID</div>
        <div class="Agent_game_val2" style="width:180px">: <?php echo $handId;?></div>
      </div>
    </div>
  </div>
    <div class="TblHdrWrap">
      <div class="Hdr1line" style="width: 125px;">Username</div>
      <div class="HdrTxNo" style="width: 155px;">Reference No</div>
      <div class="Hdr1line" style="width: 125px;">Start Date</div>
      <div class="Hdr1line" style="width: 125px;">End Date</div>
      
      <div class="HdrIDSmall" style="width: 100px;">Stake</div>
      <div class="HdrIDSmall" style="width: 100px;">Win</div>
      <div class="HdrIDSmall" style="width: 100px;">Game Result</div>
    </div>
<?PHP   $results = $this->game_model->getBlackJackPlayDetails($handId);  
		$tx = count($results);

if($tx>0){  ?>
    <div class="<?PHP if ($i%2=="0") { ?>STblHdrWrap3 <?PHP } else { ?> STblHdrWrap <?PHP } ?>">
      <div class="SHdr1line" style="width: 125px;"><?PHP echo $results[0]->USERNAME; ?></div>
      <div class="SHdrTxNo" style="width: 155px;"><?PHP echo $results[0]->INTERNAL_REFERENCE_NO; ?></div>
      <div class="SHdr1line" style="width: 125px;"><?PHP echo $results[0]->STARTED; ?></div>
      <div class="SHdr1line" style="width: 125px;"><?PHP echo $results[0]->ENDED; ?></div>
      <div class="SHdrIDSmallC" style="width: 100px;"><?php echo $results[0]->STAKE; ?></div>
      <div class="SHdrIDSmallC" style="width: 100px;"><?PHP echo $results[0]->WIN; ?></div>
      <div class="SHdrIDSmallC" style="width: 100px;">
        <?PHP  
        if($results[0]->ROOM_NAME){
            $txt = explode(",",$results[0]->ROOM_NAME); if($txt[1] == 1) echo "Game Ended"; else echo "In Progress"; 
        }else{
            if($results[0]->ENDED){ echo "Game Ended"; }else{ echo "In Progress";}
        } ?>
      </div>
    </div>
<?php  }else{  ?>
    <div class="STblHdrWrapno">
      <div class="SHdr2lineno">No Records Found.</div>
    </div>
    <?php
}  ?>
   <div  id="myOnPageContent<?php echo $results[0]->INTERNAL_REFERENCE_NO; ?>">
          <div class="UDpopBg">
            <div class="UDpopupWrap">
              <div class="UDpopLeftWrap">
                <div class="UDFieldtitle">
                  <div class="UDFieldtitle">
                    <?php
	  $total=json_decode($results[0]->PLAY_DATA, true);
         if($total['playResult']['mainHand'][0]['cardsAsString']){
             $totusercards=explode(",",$total['playResult']['mainHand'][0]['cardsAsString']);
             if($total['playResult']['splitHand'][0]['cardsAsString']){
                 $totusersplitcards=explode(",",$total['playResult']['splitHand'][0]['cardsAsString']);
             }	 ?>
                    <div class="UDFieldtitle"> <span  style=" font-weight:bold">User Cards:</span> </div>
                    <table cellpadding="2" cellspacing="2" >
                      <tr>
                        <td><table>
                            <tr>
<?php     for($uc=0;$uc<count($totusercards);$uc++){ ?>
         <td <?php if($total['playResult']['mainHand'][0]['handOutcome']=='Push' || $total['playResult']['mainHand'][0]['handOutcome']=='Win'){?> style="border: 1px solid #FF0000;" <?php }?>><?php 
            if($totusercards[$uc]){
            echo '<img src="'.base_url().'static/images/minigame/blackjack/'.$totusercards[$uc].'.png">';
            }  ?></td>
<?php   }    ?>
                            </tr>
                            <tr>
                              <td><strong><?php echo $total['playResult']['mainHand'][0]['value'];?></strong></td>
                            </tr>
                            <tr>
                              <td><?php 
            if($total['playResult']['mainHand'][0]['handOutcome']=='Push' || $total['playResult']['mainHand'][0]['handOutcome']=='Win' || $total['playResult']['splitHand'][0]['handOutcome']=='Push' || $total['playResult']['splitHand'][0]['handOutcome']=='Win'){
              echo "<strong>Winner</strong>";  
            }    ?>
            </td>
                            </tr>
                          </table></td>
<?php     if($totusersplitcards){     ?>
                        <td  style="padding-left:40px;"></td>
                        <?php } ?>
                        <td><table>
                            <tr>
<?php   for($us=0;$us<count($totusersplitcards);$us++){  ?>
			<td <?php if($total['playResult']['splitHand'][0]['handOutcome']=='Push' || $total['playResult']['splitHand'][0]['handOutcome']=='Win'){?> style="border: 1px solid #FF0000;" <?php }?>><?php 
            if($totusersplitcards[$us]){
            echo '<img src="'.base_url().'static/images/minigame/blackjack/'.$totusersplitcards[$us].'.png">';
            }  ?>
            </td>
<?php    }   ?>
                            </tr>
                            <tr>
                              <td><strong><?php echo $total['playResult']['splitHand'][0]['value'];?></strong></td>
                            </tr>
                            <tr>
                              <td height="10"></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
<?php     }     ?>
                  </div>
<?php	if($total['playResult']['dealerHand']['cardsAsString']){
                  $totdealercards=explode(",",$total['playResult']['dealerHand']['cardsAsString']);  ?>
                  <br/>
                  <div class="UDFieldtitle" style="padding-top:20px;"> <span  style=" font-weight:bold">Dealer Cards:</span> </div>
                  <div class="UDFieldtitle">
                    <table cellpadding="2" cellspacing="2" >
                      <tr>
<?php  for($dc=0;$dc<count($totdealercards);$dc++){ ?>
		<td <?php if($total['playResult']['mainHand'][0]['handOutcome']=='Push' || $total['playResult']['mainHand'][0]['handOutcome']=='Win' || $total['playResult']['splitHand'][0]['handOutcome']=='Push' || $total['playResult']['splitHand'][0]['handOutcome']=='Win'){ ?> <?php }else{ ?> style="border: 1px solid #FF0000;" <?php } ?>  >
<?php	if($totdealercards[$dc]){
        	echo '<img src="'.base_url().'static/images/minigame/blackjack/'.$totdealercards[$dc].'.png">';
        } ?></td>
<?php   }   ?>
                      </tr>
                      <tr>
                        <td><strong><?php echo $total['playResult']['dealerHand']['value'];?></strong></td>
                      </tr>
                      <tr>
                        <td><?php 
            if($total['playResult']['mainHand'][0]['handOutcome']=='Push' || $total['playResult']['mainHand'][0]['handOutcome']=='Win' || $total['playResult']['splitHand'][0]['handOutcome']=='Push' || $total['playResult']['splitHand'][0]['handOutcome']=='Win'){
              
            }else{
                echo "<strong>Winner</strong>";  
            }     ?>
            </td>
                      </tr>
                    </table>
                  </div>
<?php	}	?>
<?php   if($total['playResult']['mainHand'][0]['insurence']){         ?>
                  <div class="UDFieldtitle" style="padding-top:20px;"> <span  style=" font-weight:bold">Insurance: </span>
                    <?php if($total['playResult']['mainHand'][0]['insurence']=="1"){ echo "yes"; }?>
                  </div>
<?php   }   ?>
                  <div class="UDFieldtitle" style="padding-top:20px;"> <span  style=" font-weight:bold;">Play Point: </span>
<?php      echo $results[0]->STAKE;   ?>
                  </div>
<?php      if($results[0]->WIN){  ?>
                  <div class="UDFieldtitle" style="padding-top:20px;"> <span  style=" font-weight:bold;">Win: </span><?php echo $results[0]->WIN; ?> </div>
                  <?php } ?>
                  <?php if($total['playResult']['mainHand'][0]['doubled']){  ?>
                  <div class="UDFieldtitle" style="padding-top:20px;"> <span  style=" font-weight:bold;">Double: </span>
                    <?php if($total['playResult']['mainHand'][0]['doubled']=="1"){echo "Yes";} ?>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>   
  </div>
