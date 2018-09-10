<link href="<?php echo base_url(); ?>static/css/style_vip36.css" rel="stylesheet" type="text/css" />
  <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:auto">: <?php echo ucfirst(strtolower($gameName));?></div>
      </div>
    </div>
    <div class="Agent_game_Left" style="width:350px;">
      <div class="Agent_game_tit_wrap" style="width:290px;">
        <div class="Agent_game_name">Hand ID</div>
        <div class="Agent_game_val2" style="width:auto">: <?php echo $handId;?></div>
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
              <td class="NTblHdrTxt">Win Slot</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win</td>
            </tr>
          </table></td>
      </tr>
<?PHP  $results = $this->game_model->getmobroulette12PlayDetails($handId);  ?>
      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $results[0]->USERNAME; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->INTERNAL_REFFERENCE_NO; ?></td>
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
	$tot=json_decode($results[0]->PLAY_DATA, true); 
	$playedLinescnt=count($tot['spinResult']['betPlayedOption']);  
	$number=$tot['spinResult']['winSlot']['number'];
	$color=$tot['spinResult']['winSlot']['color'];
	if($number!=''){
		echo $number.",".$color;
	}  ?>
                </table></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $results[0]->WIN; ?></td>
            </tr>
          </table></td>
      </tr>

    </table>
      
      
<div id="Roulette12_Wrap">
<?PHP
$playedLinescnt=count($tot['spinResult']['betPlayedOption']);
$betamtred="";
$betamtblack="";
$betamteven="";
$betamtodd="";
 
$betamtspotS3="";
$betamtspotS2="";
$betamtspotS1="";

$betamtspotc1="";
$betamtspotc2="";
$betamtspotc3="";

$betamtspot0="";
$betamtspot1="";
$betamtspot2="";
$betamtspot3="";
$betamtspot4="";
$betamtspot5="";
$betamtspot6="";
$betamtspot7="";
$betamtspot8="";
$betamtspot9="";
$betamtspot10="";
$betamtspot11="";
$betamtspot12="";

$betamtspot0_1="";
$betamtspot0_2="";
$betamtspot0_3="";
$betamtspot1_2="";
$betamtspot2_3="";
$betamtspot1_4="";
$betamtspot2_5="";
$betamtspot3_6="";
$betamtspot4_5="";
$betamtspot5_6="";
$betamtspot4_7="";
$betamtspot5_8="";
$betamtspot6_9="";
$betamtspot7_8="";
$betamtspot8_9="";
$betamtspot7_10="";
$betamtspot8_11="";
$betamtspot9_12="";
$betamtspot10_11="";
$betamtspot11_12="";

$betamtspot1_2_3_4_5_6="";
$betamtspot4_5_6_7_8_9="";
$betamtspot7_8_9_10_11_12="";

$betamtspot0_1_2="";
$betamtspot0_2_3="";
$betamtspot1_2_3="";
$betamtspot4_5_6="";
$betamtspot7_8_9="";
$betamtspot10_11_12="";

$betamtspot0_1_2_3="";
$betamtspot1_2_4_5="";
$betamtspot2_3_5_6="";
$betamtspot4_5_7_8="";
$betamtspot5_6_8_9="";
$betamtspot7_8_10_11="";
$betamtspot8_9_11_12="";

$number=$tot['spinResult']['winSlot']['number'];
$color=$tot['spinResult']['winSlot']['color'];
$winamount=$WIN;

	for($p=0;$p<$playedLinescnt;$p++){	   
	 $playedLines=$tot['spinResult']['betPlayedOption'][$p]['playedOption'];
       
          if($playedLines=='RBEO_EVENT_BET[_11_9_7_5_3_1_]'){
              $betamtred=$betamtred+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_Red">'.$betamtred.'</div>';
          }
          if($playedLines=='RBEO_EVENT_BET[_12_10_8_6_4_2_]'){
              $betamtblack=$betamtblack+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_Black">'.$betamtblack.'</div>';
          }
         
          if($playedLines=='RBEO_EVENT_BET[_2_4_6_8_10_12_]'){
              $betamteven=$betamteven+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_Even">'.$betamteven.'</div>';
          }
          
          if($playedLines=='RBEO_EVENT_BET[_1_3_5_7_9_11_]'){
              $betamtodd=$betamtodd+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_Odd">'.$betamtodd.'</div>';
          }
          
          if($playedLines=='COLOUMN_DOZEN_BET[_2_5_8_11_]'){
              $betamtspotS3=$betamtspotS3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_c2">'.$betamtspotS3.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_3_6_9_12_]'){
              $betamtspotS2=$betamtspotS2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_c3">'.$betamtspotS2.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_1_4_7_10_]'){
              $betamtspotS1=$betamtspotS1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_c1">'.$betamtspotS1.'</div>';
          }
          
          if($playedLines=='STRAIGHT_BET[_0_]'){
              $betamtspot0=$betamtspot0+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0">'.$betamtspot0.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_1_]'){
              $betamtspot1=$betamtspot1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_1">'.$betamtspot1.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_2_]'){
              $betamtspot2=$betamtspot2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_2">'.$betamtspot2.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_3_]'){
              $betamtspot3=$betamtspot3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_3">'.$betamtspot3.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_4_]'){
              $betamtspot4=$betamtspot4+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_4">'.$betamtspot4.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_5_]'){
              $betamtspot5=$betamtspot5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_5">'.$betamtspot5.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_6_]'){
              $betamtspot6=$betamtspot6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_6">'.$betamtspot6.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_7_]'){
              $betamtspot7=$betamtspot7+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_7">'.$betamtspot7.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_8_]'){
              $betamtspot8=$betamtspot8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_8">'.$betamtspot8.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_9_]'){
              $betamtspot9=$betamtspot9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_9">'.$betamtspot9.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_10_]'){
              $betamtspot10=$betamtspot10+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_10">'.$betamtspot10.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_11_]'){
              $betamtspot11=$betamtspot11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_11">'.$betamtspot11.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_12_]'){
              $betamtspot12=$betamtspot12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_12">'.$betamtspot12.'</div>';
          }
          
          if($playedLines=='SPLIT_BET[_0_1_]'){
              $betamtspot0_1=$betamtspot0_1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0_1">'.$betamtspot0_1.'</div>';
          }
          if($playedLines=='SPLIT_BET[_0_2_]'){
              $betamtspot0_2=$betamtspot0_2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0_2">'.$betamtspot0_2.'</div>';
          }
          if($playedLines=='SPLIT_BET[_0_3_]'){
              $betamtspot0_3=$betamtspot0_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0_3">'.$betamtspot0_3.'</div>';
          }
          if($playedLines=='SPLIT_BET[_1_2_]'){
              $betamtspot1_2=$betamtspot1_2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_1_2">'.$betamtspot1_2.'</div>';
          }
          if($playedLines=='SPLIT_BET[_2_3_]'){
              $betamtspot2_3=$betamtspot2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_2_3">'.$betamtspot2_3.'</div>';
          }
          if($playedLines=='SPLIT_BET[_1_4_]'){
              $betamtspot1_4=$betamtspot1_4+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_1_4">'.$betamtspot1_4.'</div>';
          }
          if($playedLines=='SPLIT_BET[_2_5_]'){
              $betamtspot2_5=$betamtspot2_5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_2_5">'.$betamtspot2_5.'</div>';
          }
          if($playedLines=='SPLIT_BET[_3_6_]'){
              $betamtspot3_6=$betamtspot3_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_3_6">'.$betamtspot3_6.'</div>';
          }
          if($playedLines=='SPLIT_BET[_4_5_]'){
              $betamtspot4_5=$betamtspot4_5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_4_5">'.$betamtspot4_5.'</div>';
          }
          if($playedLines=='SPLIT_BET[_5_6_]'){
              $betamtspot5_6=$betamtspot5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_5_6">'.$betamtspot5_6.'</div>';
          }
          if($playedLines=='SPLIT_BET[_4_7_]'){
              $betamtspot4_7=$betamtspot4_7+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_4_7">'.$betamtspot4_7.'</div>';
          }
          if($playedLines=='SPLIT_BET[_5_8_]'){
              $betamtspot5_8=$betamtspot5_8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_5_8">'.$betamtspot5_8.'</div>';
          }
          if($playedLines=='SPLIT_BET[_6_9_]'){
              $betamtspot6_9=$betamtspot6_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_6_9">'.$betamtspot6_9.'</div>';
          }
          if($playedLines=='SPLIT_BET[_7_8_]'){
              $betamtspot7_8=$betamtspot7_8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_7_8">'.$betamtspot7_8.'</div>';
          }
          if($playedLines=='SPLIT_BET[_8_9_]'){
              $betamtspot8_9=$betamtspot8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_8_9">'.$betamtspot8_9.'</div>';
          }
          if($playedLines=='SPLIT_BET[_7_10_]'){
              $betamtspot7_10=$betamtspot7_10+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_7_10">'.$betamtspot7_10.'</div>';
          }
          if($playedLines=='SPLIT_BET[_8_11_]'){
              $betamtspot8_11=$betamtspot8_11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_8_11">'.$betamtspot8_11.'</div>';
          }
          if($playedLines=='SPLIT_BET[_9_12_]'){
              $betamtspot9_12=$betamtspot9_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_9_12">'.$betamtspot9_12.'</div>';
          }
          if($playedLines=='SPLIT_BET[_10_11_]'){
              $betamtspot10_11=$betamtspot10_11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_10_11">'.$betamtspot10_11.'</div>';
          }
          if($playedLines=='SPLIT_BET[_11_12_]'){
              $betamtspot11_12=$betamtspot11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_11_12">'.$betamtspot11_12.'</div>';
          }
          
          #Street Bet
          if($playedLines=='STREET_BET[_0_1_2_]'){
              $betamtspot0_1_2=$betamtspot0_1_2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0_1_2">'.$betamtspot0_1_2.'</div>';
          }
          if($playedLines=='STREET_BET[_0_2_3_]'){
              $betamtspot0_2_3=$betamtspot0_2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0_2_3">'.$betamtspot0_2_3.'</div>';
          }
          if($playedLines=='STREET_BET[_1_2_3_]'){
              $betamtspot1_2_3=$betamtspot1_2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_1_2_3">'.$betamtspot1_2_3.'</div>';
          }
          if($playedLines=='STREET_BET[_4_5_6_]'){
              $betamtspot4_5_6=$betamtspot4_5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_4_5_6">'.$betamtspot4_5_6.'</div>';
          }
          
          if($playedLines=='STREET_BET[_7_8_9_]'){
              $betamtspot7_8_9=$betamtspot7_8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_7_8_9">'.$betamtspot7_8_9.'</div>';
          }
          
          if($playedLines=='STREET_BET[_10_11_12_]'){
              $betamtspot10_11_12=$betamtspot10_11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_10_11_12">'.$betamtspot10_11_12.'</div>';
          }
          
          #six line bet
          if($playedLines=='SIX_LINE_BET[_1_2_3_4_5_6_]'){
              $betamtspot1_2_3_4_5_6=$betamtspot1_2_3_4_5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_s1">'.$betamtspot1_2_3_4_5_6.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_4_5_6_7_8_9_]'){
              $betamtspot4_5_6_7_8_9=$betamtspot4_5_6_7_8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_s2">'.$betamtspot4_5_6_7_8_9.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_7_8_9_10_11_12_]'){
              $betamtspot7_8_9_10_11_12=$betamtspot7_8_9_10_11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_s3">'.$betamtspot7_8_9_10_11_12.'</div>';
          }
          
          #cornor bet
          
          if($playedLines=='CORNER_BET[_0_1_2_3_]'){
              $betamtspot0_1_2_3=$betamtspot0_1_2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_0_1_2_3">'.$betamtspot0_1_2_3.'</div>';
          }
          if($playedLines=='CORNER_BET[_1_2_4_5_]'){
              $betamtspot1_2_4_5=$betamtspot1_2_4_5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_1_2_4_5">'.$betamtspot1_2_4_5.'</div>';
          }
          if($playedLines=='CORNER_BET[_2_3_5_6_]'){
              $betamtspot2_3_5_6=$betamtspot2_3_5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_2_3_5_6">'.$betamtspot2_3_5_6.'</div>';
          }
          if($playedLines=='CORNER_BET[_4_5_7_8_]'){
              $betamtspot4_5_7_8=$betamtspot4_5_7_8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_4_5_7_8">'.$betamtspot4_5_7_8.'</div>';
          }
          if($playedLines=='CORNER_BET[_5_6_8_9_]'){
              $betamtspot5_6_8_9=$betamtspot5_6_8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_5_6_8_9">'.$betamtspot5_6_8_9.'</div>';
          }
          if($playedLines=='CORNER_BET[_7_8_10_11_]'){
              $betamtspot7_8_10_11=$betamtspot7_8_10_11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_7_8_10_11">'.$betamtspot7_8_10_11.'</div>';
          }
          if($playedLines=='CORNER_BET[_8_9_11_12_]'){
              $betamtspot8_9_11_12=$betamtspot8_9_11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_8_9_11_12">'.$betamtspot8_9_11_12.'</div>';
          }
          
	 if($p!=($playedLinescnt-1)){
	  echo "\n";
	 }											
	}
        
        if($number != ''){
            switch($number){
               case 0:
                   echo '<div class="spot12_Win00">win</div>';
                   break;  
               case 1:
                   echo '<div class="spot12_Win01">win</div>';
                   break;
               case 2:
                   echo '<div class="spot12_Win02">win</div>';
                   break;
               case 3:
                   echo '<div class="spot12_Win03">win</div>';
                   break;
               case 4:
                   echo '<div class="spot12_Win04">win</div>';
                   break;
               case 5:
                   echo '<div class="spot12_Win05">win</div>';
                   break;
               case 6:
                   echo '<div class="spot12_Win06">win</div>';
                   break;
               case 7:
                   echo '<div class="spot12_Win07">win</div>';
                   break;
               case 8:
                   echo '<div class="spot12_Win08">win</div>';
                   break;
               case 9:
                   echo '<div class="spot12_Win09">win</div>';
                   break;
               case 10:
                   echo '<div class="spot12_Win10">win</div>';
                   break;
               case 11:
                   echo '<div class="spot12_Win11">win</div>';
                   break;
               case 12:
                   echo '<div class="spot12_Win12">win</div>';
                   break;
            }
        }
?>
</div>
</div>
