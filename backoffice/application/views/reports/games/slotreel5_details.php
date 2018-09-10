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
              <td class="NTblHdrTxt">Played Lines</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Bonus Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Total Win</td>
            </tr>
          </table></td>
        
      </tr>
<?PHP  $results = $this->game_model->getSlotreel5PlayDetails($handId);   ?>
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
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><table border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr>
                    <?PHP
  $tot=json_decode($results[0]->SLOTPLAY_DATA, true);   
  $playedLinescnt=count($tot['spinResult']['playedLines']);
	for($p=0;$p<$playedLinescnt;$p++){	   
	 echo $playedLines=$tot['spinResult']['playedLines'][$p];
	 if($p!=($playedLinescnt-1)){
	  echo ",";
	 }											
	}  ?>
                </table></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->WIN; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->BONUS_WIN; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->TOTAL_WIN; ?></td>
            </tr>
          </table></td>
      </tr>
    </table>
      
<?php    $tot=json_decode($results[0]->SLOTPLAY_DATA, true);
         $winlines=$tot['spinResult']['winlines'];
          if($winlines){       ?>
                
                <div   id="myOnPageContent<?php echo $INTERNAL_REFERENCE_NO; ?>">
                  <div class="UDpopBg">
                    <div class="UDpopupWrap"> <!-- DOUBLE GAME RESULTS-->
                      <div class="UDpopLeftWrap">
                        <div class="UDFieldtitle">
                          <?PHP 
                                       if($winlines){
                                       if(strstr($winlines,'|')){
                                          $noofresults=explode("|",$winlines); 
                                          
                                        for($tr=0;$tr<count($noofresults);$tr++){  
                                        $resdet=explode(",",$noofresults[$tr]);
                                        $scount=explode("C",$resdet[2]);
                                        $symbol1=explode("S",$resdet[1]);
                                        $symbol2=$symbol1[1];    ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line : <?php echo $resdet[0];?></b> </div>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Count : <?php echo $scount[1];?></b> </div>
                          <div>
                            <?php     if($scount[1]){
                                            for($s=0;$s<$scount[1];$s++){        ?>
                            <img src="<?php echo base_url(); ?>static/images/minigame/slot5/<?php echo $symbol2.".png"?>" height="65" width="65"/>
                            <?php
                                            }
                                        }     ?>
                            <br />
                          </div>
                          <?php		      }
                                       }else{
                                    	   $resdet=explode(",",$winlines);
                                           $scount=explode("C",$resdet[2]);
                                           $symbol1=explode("S",$resdet[1]);
                                           $symbol2=$symbol1[1];      ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line : <?php echo $resdet[0];?></b> </div>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Count : <?php echo $scount[1];?></b> </div>
                          <div class="UDFieldtitle">
                            <?php     
                                        if($scount[1]){
                                            for($s=0;$s<$scount[1];$s++){   ?>
                            <img src="<?php echo base_url(); ?>static/images/minigame/slot5/<?php echo $symbol2.".png"?>" height="65" width="65"/>
                            <?php
                                            }
                                        }     ?>
                            <br />
                          </div>
                          <?php          }    
                                      }    ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
          }    ?>
  </div>
