<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
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
  <div class="tableWrap">
    <div class="TblHdrWrap"> 
      <div class="Hdr1line" style="width: 125px;">Username</div>
      <div class="HdrTxNo" style="width: 155px;">Hand ID</div>
      <div class="Hdr1line" style="width: 125px;">Start Date</div>
      <div class="Hdr1line" style="width: 125px;">End Date</div>
      
      <div class="HdrIDSmall" style="width: 80px;">Stake</div>
      <div class="HdrIDSmall" style="width: 80px;">Win</div>
      <div class="HdrIDSmall" style="width: 80px;">Double Win</div>
      
      <div class="HdrIDSmall" style="width: 80px;">Total Win</div>
    </div>
<?PHP   $results = $this->game_model->getLuckyBingoPlayDetails($handId);  
		$tx = count($results);  
		if($tx>0){  ?>

    <div class="<?PHP if ($i%2=="0") { ?>STblHdrWrap3 <?PHP } else { ?> STblHdrWrap <?PHP } ?>">
      <div class="SHdr1line" style="width: 125px;"><?PHP echo $results[0]->USERNAME; ?></div>
      <div class="SHdrTxNo" style="width: 155px;"><?PHP echo $results[0]->INTERNAL_REFERENCE_NO; ?></div>
      <div class="SHdr1line" style="width: 125px;"><?PHP echo $results[0]->STARTED; ?></div>
      <div class="SHdr1line" style="width: 125px;"><?PHP echo $results[0]->ENDED; ?></div>
      
      <div class="SHdrIDSmallC" style="width: 80px;"><?php echo $results[0]->STAKE;?></div>
      <div class="SHdrIDSmallC" style="width: 80px;"><?PHP echo $results[0]->WIN; ?></div>
      <div class="SHdrIDSmallC" style="width: 80px;"><?PHP echo $results[0]->DOUBLE_WIN; ?></div>
      
      <div class="SHdrIDSmallC" style="width: 80px;"><?PHP echo $results[0]->TOTAL_WIN; ?></div>
    </div>
    <?php 
}else{  ?>
    <div class="STblHdrWrapno">
      <div class="SHdr2lineno">No Records Found.</div>
    </div>
    <?php
}  ?>
    <div  id="myOnPageContent<?php echo $results[0]->INTERNAL_REFERENCE_NO; ?>">
          <div class="BtimeWrap">
            <div class="TicketWrap">
              <?php
                $total=json_decode($results[0]->PLAY_DATA, true);
                  $cnt = count($total['bingoResult']['tickets']);
				  $bawincnt = $total['bingoResult']['reelwinningNumbers']; 
                 // $totalwinamount=$total['bingoResult']['totalWinAmount']; 
                  $doublegameattempts=$total['bingoResult']['doubleGameWin'];
                  $userbutton=$total['bingoResult']['luckyBingoDoubleGameResult']['userChoosedButton'];
                  $wintype=$total['bingoResult']['luckyBingoDoubleGameResult']['winType'];
                  $cardname=$total['bingoResult']['luckyBingoDoubleGameResult']['card']['suitAsString']."_".$total['bingoResult']['luckyBingoDoubleGameResult']['card']['value'].".png";
                  $jackpotgame=$total['bingoResult']['jackpotGame']; 
		for($k=0;$k<$cnt;$k++){
			$ticket_no = $total['bingoResult']['tickets'][$k]['ticketNo'];
			$cnt1= count($total['bingoResult']['tickets'][$k]['ticket']);
                        $betamount= $total['bingoResult']['tickets'][$k]['betAmount'];
                        $winamount=$total['bingoResult']['tickets'][$k]['winAmount'];
                        $winnumbers="";
                        if($total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL1']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL1']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL1']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL1']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL2']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL2']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL2']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL2']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL3']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL3']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL3']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL3']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL4']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL4']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL4']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL4']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL5']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL5']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL5']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['HORIZONTAL5']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['VERTICAL1']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL1']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL1']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL1']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['VERTICAL2']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL2']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL2']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL2']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['VERTICAL3']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL3']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL3']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL3']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['VERTICAL4']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL4']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL4']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL4']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['VERTICAL5']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL5']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL5']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['VERTICAL5']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL1']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL1']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL1']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL1']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL2']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL2']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL2']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['DIAGONAL2']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['CORNER']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['CORNER']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['CORNER']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['CORNER']['winType'];
                        }
                        if($total['bingoResult']['tickets'][$k]['winResult']['CORNERCENTER']['winNumbers']){
                            if(is_array($winnumbers)){
                            $winnumbers=array_merge($winnumbers,$total['bingoResult']['tickets'][$k]['winResult']['CORNERCENTER']['winNumbers']);
                            }else{
                            $winnumbers=$total['bingoResult']['tickets'][$k]['winResult']['CORNERCENTER']['winNumbers'];    
                            }
                            $wintype=$total['bingoResult']['tickets'][$k]['winResult']['CORNERCENTER']['winType'];
                        }                   ?>
<div class="BinTicWrap">
<?php   for($z=0;$z<$cnt1;$z++){
			$cnt2 = count($total['bingoResult']['tickets'][$k]['ticket'][$z]);    
			for($j=0;$j<$cnt2;$j++){
				$id = $total['bingoResult']['tickets'][$k]['ticket'][$z][$j];
			   if(is_array($bawincnt)){
                   if(in_array($id,$bawincnt)){
                       if(is_array($winnumbers)){
                           if(in_array($id,$winnumbers) && $winamount!=''){ 
                           		$classname='BinTckWinNo'; 
                           }else{
                                $classname='BinTckSysWinNo'; 
                           }
                       }else{
                       		$classname='BinTckSysWinNo';         
                       }
                   }else{
                   		$classname='BinTckNo';         
                   }
               }else{
               		$classname='BinTckNo';         
			   }   ?>
                <div class="<?php echo $classname;?>"><?php echo $id;?> </div>
                <?php
  }
}  ?>
                <div class="BinWinAmtWrap">
                  <div class="BinBet">BET: <?php echo $betamount;?></div>
                  <div class="BinWin">WIN:
                    <?php if($winamount){ echo $winamount; }else{ echo "0.00";}?>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <?php
                if($total['bingoResult']['reelwinningNumbers']!=""){
                    $winnos=$total['bingoResult']['reelwinningNumbers'];
                }    ?>
            <div class="BinResWrap">
              <div class="ResultWrap">
                <div class="ResultHdr">RESULT</div>
                <div class="ResultShdr">
                  <?php 
        if(is_array($winnos)){
           foreach($winnos as $winningnumbers){    ?>
                  <div class="ResDisplay"><?php echo $winningnumbers;?></div>
                  <?php 
            }
        }    ?>
                  <div class="ResDisSpl">
                    <?php if($jackpotgame=="true"){echo "J";}else{echo "N";} ?>
                  </div>
                </div>
              </div>
              <div class="ResultWrap02">
                <div class="ResultHdr">DOUBLE GAME</div>
                <div class="ResultShdr">
                  <div class="ResLRWrap">
                    <div class="ResLeft">No. Of Attempts:</div>
                    <div class="ResRight">
                      <?php if($doublegameattempts){ echo $doublegameattempts;}else{ echo "0";} ?>
                    </div>
                    <?php
if($doublegameattempts>0){  ?>
                    <div class="ResLeft">Card:</div>
                    <div class="ResRight">
                      <?php if($cardname){ ?>
                      <span><img src="<?php echo base_url(); ?>static/images/minigame/blackjack/<?php echo $cardname;?>"></span>
                      <?php } ?>
                    </div>
                    <div class="ResLeft">User Choose:</div>
                    <div class="ResRight">
                      <?php if($userbutton){ ?>
                      <span><?php echo ucfirst($userbutton);?></span>
                      <?php } ?>
                    </div>
                    <?php
}  ?>
                  </div>
                </div>
              </div>
              <div class="ResultWrap02">
                <div class="ResultHdr">OVERALL GAME RESULT</div>
                <div class="ResultShdr">
                  <div class="ResLRWrap">
                    <div class="ResLeft">Main Game Win:</div>
                    <div class="ResRight"><?php echo $results[0]->WIN; ?></div>
                  </div>
                  <div class="ResLRWrap">
                    <div class="ResLeft">Double Game Win:</div>
                    <div class="ResRight"><?php echo $results[0]->DOUBLE_WIN; ?></div>
                  </div>
                  <div class="ResLRWrap">
                    <div class="ResLeft">Total Win:</div>
                    <div class="ResRight"><?php echo $results[0]->TOTAL_WIN; ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>  
  </div>
