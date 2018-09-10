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
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Username</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Hand ID</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Start Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">End Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Stake</td>
            </tr>
          </table></td>
        
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Selected Cards</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Double Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Total Win</td>
            </tr>
          </table></td>
      </tr>
<?PHP  $results = $this->game_model->getJacksorBetterPlayDetails($handId);  ?>      
      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $results[0]->USERNAME; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->INTERNAL_REFERENCE_NO; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->STARTED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->ENDED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->STAKE; ?></td>
            </tr>
          </table></td>
        
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><?PHP
         $tot1=json_decode($results[0]->PLAY_DATA, true);
		 $Doublegams=array_pop($tot1['doubleGameResult']); 
		 $DoublegamRes=count($Doublegams);
         $id=explode(",",$Doublegams['showCards']);
		 $id1=explode(",",$Doublegams['selectedCards']);
		 for($s=0;$s<count($id1);$s++){
		 	if($id1[$s]!=0){
		 			echo  $id[$s];
	 		}
		 }   ?>
         </td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->WIN; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->DOUBLE_WIN; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->TOTAL_WIN; ?></td>
            </tr>
          </table></td>
      </tr>
    </table>
    </td>
    </tr>
    </table>
    <div id="myOnPageContent<?php echo $results[0]->INTERNAL_REFERENCE_NO; ?>">
            <div class="UDpopBg">
              <div class="UDpopupWrap">
                <div class="UDpopLeftWrap">
                  <div class="UDFieldtitleJB">
                    <div class="UDFieldtitleJB"> Deal Cards </div>
                    <?PHP 
         $total=json_decode($results[0]->PLAY_DATA, true);
		 $id=$total['dealResult']['handCardLists'];
         $chids=explode(",",$total['dealResult']['holdCards']);            ?>
   <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[0]['cardClient'] ?>.png" <?php if($chids[0]=="1"){ ?> style="border:2px solid #021a40;border-color:red;" <?php } ?> /> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[1]['cardClient'] ?>.png" <?php if($chids[1]=="1"){ ?> style="border:2px solid #021a40;border-color:red;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[2]['cardClient'] ?>.png"  <?php if($chids[2]=="1"){ ?> style="border:2px solid #021a40;border-color:red;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[3]['cardClient'] ?>.png"  <?php if($chids[3]=="1"){ ?> style="border:2px solid #021a40;border-color:red;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[4]['cardClient'] ?>.png"  <?php if($chids[4]=="1"){ ?> style="border:2px solid #021a40;border-color:red;" <?php } ?>/> </div>
                  <div class="UDFieldtitleJB">
                    <div class="UDFieldtitleJB"> Deal Again Cards </div>
                    <?PHP 
         $total=json_decode($results[0]->PLAY_DATA, true);
		 $id=$total['dealAgainResult']['handCardLists'];
         $dchids=explode(",",$total['dealAgainResult']['holdCards']);            ?>
                    <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[0]['cardClient'] ?>.png" <?php if($dchids[0]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[1]['cardClient'] ?>.png" <?php if($dchids[1]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[2]['cardClient'] ?>.png" <?php if($dchids[2]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[3]['cardClient'] ?>.png" <?php if($dchids[3]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/> <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[4]['cardClient'] ?>.png" <?php if($dchids[4]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/> </div>
                </div>
              </div>
              <?php 
						    $totattttt=json_decode($results[0]->PLAY_DATA, true);
							$test = count($totattttt['doubleGameResult']);
							if($test!=0){	   ?>
              <div class="UDpopupWrap"> <!-- DOUBLE GAME RESULTS-->
                <div class="UDpopLeftWrap">
                  <div class="UDFieldtitleJB">
                    <?PHP 
         $tot=json_decode($results[0]->PLAY_DATA, true);
		 $DealerCard = $tot['doubleDealResult']['dealerCard']; 
                 if(count($tot['doubleGameResult'])>3){
                     $startarr=count($tot['doubleGameResult'])-3;
                     $Doublegam=array_slice($tot['doubleGameResult'],$startarr,count($tot['doubleGameResult'])); 
                 }else{
                     $Doublegam=$tot['doubleGameResult'];
                 }            ?>
                    <div class="UDFieldtitleJB"> Double Game Results </div>
                    <div class="UDFieldtitleJB"> Dealer Card </div>
                    <?php                                                                   
	 	for($pt=0;$pt<count($Doublegam);$pt++){ 
	        $id=explode(",",$Doublegam[$pt]['showCards']);		 
            $dechids=explode(",",$Doublegam[$pt]['selectedCards']);
            $DealerCard = $Doublegam[$pt]['dealerCard'];        ?>
      <img  src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $DealerCard;?>.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[0] ?>.png" <?php if($dechids[0]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/>      
      <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[1] ?>.png" <?php if($dechids[1]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/>
      <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[2] ?>.png" <?php if($dechids[2]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/>			 	  
      <img src="<?php  echo base_url(); ?>static/images/minigame/jacksorbetter/<?PHP echo $id[3] ?>.png" <?php if($dechids[3]=="1"){ ?> style="border:2px solid #021a40;border-color:green;" <?php } ?>/>
                    <?php    } ?>
                  </div>
                </div>
              </div>
              <?php		}		?>
            </div>
          </div>
  </div>
