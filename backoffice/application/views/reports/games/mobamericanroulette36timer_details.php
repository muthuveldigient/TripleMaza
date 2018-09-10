<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
  <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:auto;">
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
<?PHP  $results = $this->game_model->getShweVIPTimerDetails($handId);  ?>
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
		if($number !=''){
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
      
      
      <div id="Roulette_Wrap">
<?PHP
$playedLinescnt=count($tot['spinResult']['betPlayedOption']);
$betamtred="";
$betamtblack="";
$betamteven="";
$betamtodd="";
$betamtspothalf1="";
$betamtspothalf2="";
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
$betamtspot13="";
$betamtspot14="";
$betamtspot15="";
$betamtspot16="";
$betamtspot17="";
$betamtspot18="";
$betamtspot19="";
$betamtspot20="";
$betamtspot21="";
$betamtspot22="";
$betamtspot23="";
$betamtspot24="";
$betamtspot25="";
$betamtspot26="";
$betamtspot27="";
$betamtspot28="";
$betamtspot29="";
$betamtspot30="";
$betamtspot31="";
$betamtspot32="";
$betamtspot33="";
$betamtspot34="";
$betamtspot35="";
$betamtspot36="";

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
$betamtspot10_13="";
$betamtspot11_14="";
$betamtspot12_15="";
$betamtspot13_14="";
$betamtspot14_15="";
$betamtspot13_16="";
$betamtspot14_17="";
$betamtspot15_18="";
$betamtspot16_17="";
$betamtspot17_18="";
$betamtspot16_19="";
$betamtspot17_20="";
$betamtspot18_21="";
$betamtspot19_20="";
$betamtspot20_21="";
$betamtspot19_22="";
$betamtspot20_23="";
$betamtspot21_24="";
$betamtspot22_23="";
$betamtspot23_24="";
$betamtspot22_25="";
$betamtspot23_26="";
$betamtspot24_27="";
$betamtspot25_26="";
$betamtspot26_27="";
$betamtspot25_28="";
$betamtspot26_29="";
$betamtspot27_30="";
$betamtspot28_29="";
$betamtspot29_30="";
$betamtspot28_31="";
$betamtspot29_32="";
$betamtspot30_33="";
$betamtspot31_32="";
$betamtspot32_33="";
$betamtspot31_34="";
$betamtspot32_35="";
$betamtspot33_36="";
$betamtspot34_35="";
$betamtspot35_36="";
$betamtspot1_2_3_4_5_6="";
$betamtspot4_5_6_7_8_9="";
$betamtspot7_8_9_10_11_12="";
$betamtspot10_11_12_13_14_15="";
$betamtspot13_14_15_16_17_18="";
$betamtspot16_17_18_19_20_21="";
$betamtspot19_20_21_22_23_24="";
$betamtspot22_23_24_25_26_27="";
$betamtspot25_26_27_28_29_30="";
$betamtspot28_29_30_31_32_33="";
$betamtspot31_32_33_34_35_36="";
$betamtspot0_1_2="";
$betamtspot0_2_3="";
$betamtspot1_2_3="";
$betamtspot4_5_6="";
$betamtspot7_8_9="";
$betamtspot10_11_12="";
$betamtspot13_14_15="";
$betamtspot16_17_18="";
$betamtspot19_20_21="";
$betamtspot22_23_24="";
$betamtspot25_26_27="";
$betamtspot28_29_30="";
$betamtspot31_32_33="";
$betamtspot34_35_36="";
$betamtspot0_1_2_3="";
$betamtspot1_2_4_5="";
$betamtspot2_3_5_6="";
$betamtspot4_5_7_8="";
$betamtspot5_6_8_9="";
$betamtspot7_8_10_11="";
$betamtspot8_9_11_12="";
$betamtspot10_11_13_14="";
$betamtspot11_12_14_15="";
$betamtspot13_14_16_17="";
$betamtspot14_15_17_18="";
$betamtspot16_17_19_20="";
$betamtspot17_18_20_21="";
$betamtspot19_20_22_23="";
$betamtspot20_21_23_24="";
$betamtspot22_23_25_26="";
$betamtspot23_24_26_27="";
$betamtspot25_26_28_29="";
$betamtspot26_27_29_30="";
$betamtspot28_29_31_32="";
$betamtspot29_30_32_33="";
$betamtspot31_32_34_35="";
$betamtspot32_33_35_36="";

$number=$tot['spinResult']['winSlot']['number'];
$color=$tot['spinResult']['winSlot']['color'];
$winamount=$WIN;

	for($p=0;$p<$playedLinescnt;$p++){	   
	 $playedLines=$tot['spinResult']['betPlayedOption'][$p]['playedOption'];
          if($playedLines=='RBEO_EVENT_BET[_1_3_5_7_9_12_14_16_18_19_21_23_25_27_30_32_34_36_]'){
              $betamtred=$betamtred+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotRed">'.$betamtred.'</div>';
          }
          if($playedLines=='RBEO_EVENT_BET[_2_4_6_8_10_11_13_15_17_20_22_24_26_28_29_31_33_35_]'){
              $betamtblack=$betamtblack+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotBlack">'.$betamtblack.'</div>';
          }
          
          if($playedLines=='RBEO_EVENT_BET[_2_4_6_8_10_12_14_16_18_20_22_24_26_28_30_32_34_36_]'){
              $betamteven=$betamteven+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotEven">'.$betamteven.'</div>';
          }
          
          if($playedLines=='RBEO_EVENT_BET[_1_3_5_7_9_11_13_15_17_19_21_23_25_27_29_31_33_35_]'){
              $betamtodd=$betamtodd+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotOdd">'.$betamtodd.'</div>';
          }
          if($playedLines=='RBEO_EVENT_BET[_1_2_3_4_5_6_7_8_9_10_11_12_13_14_15_16_17_18_]'){
              $betamtspothalf1=$betamtspothalf1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spothalf1">'.$betamtspothalf1.'</div>';
          }
          if($playedLines=='RBEO_EVENT_BET[_19_20_21_22_23_24_25_26_27_28_29_30_31_32_33_34_35_36_]'){
              $betamtspothalf2=$betamtspothalf2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spothalf2">'.$betamtspothalf2.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_25_26_27_28_29_30_31_32_33_34_35_36_]'){
              $betamtspotS3=$betamtspotS3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotS3">'.$betamtspotS3.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_13_14_15_16_17_18_19_20_21_22_23_24_]'){
              $betamtspotS2=$betamtspotS2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotS2">'.$betamtspotS2.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_1_2_3_4_5_6_7_8_9_10_11_12_]'){
              $betamtspotS1=$betamtspotS1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotS1">'.$betamtspotS1.'</div>';
          }
          
          if($playedLines=='COLOUMN_DOZEN_BET[_1_4_7_10_13_16_19_22_25_28_31_34_]'){
              $betamtspotc1=$betamtspotc1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotc1">'.$betamtspotc1.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_2_5_8_11_14_17_20_23_26_29_32_35_]'){
              $betamtspotc2=$betamtspotc2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotc2">'.$betamtspotc2.'</div>';
          }
          if($playedLines=='COLOUMN_DOZEN_BET[_3_6_9_12_15_18_21_24_27_30_33_36_]'){
              $betamtspotc3=$betamtspotc3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spotc3">'.$betamtspotc3.'</div>';
          }
          
          if($playedLines=='STRAIGHT_BET[_0_]'){
              $betamtspot0=$betamtspot0+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0">'.$betamtspot0.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_1_]'){
              $betamtspot1=$betamtspot1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot1">'.$betamtspot1.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_2_]'){
              $betamtspot2=$betamtspot2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot2">'.$betamtspot2.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_3_]'){
              $betamtspot3=$betamtspot3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot3">'.$betamtspot3.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_4_]'){
              $betamtspot4=$betamtspot4+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot4">'.$betamtspot4.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_5_]'){
              $betamtspot5=$betamtspot5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot5">'.$betamtspot5.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_6_]'){
              $betamtspot6=$betamtspot6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot6">'.$betamtspot6.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_7_]'){
              $betamtspot7=$betamtspot7+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot7">'.$betamtspot7.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_8_]'){
              $betamtspot8=$betamtspot8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot8">'.$betamtspot8.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_9_]'){
              $betamtspot9=$betamtspot9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot9">'.$betamtspot9.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_10_]'){
              $betamtspot10=$betamtspot10+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot10">'.$betamtspot10.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_11_]'){
              $betamtspot11=$betamtspot11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot11">'.$betamtspot11.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_12_]'){
              $betamtspot12=$betamtspot12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12">'.$betamtspot12.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_13_]'){
              $betamtspot13=$betamtspot13+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot13">'.$betamtspot13.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_14_]'){
              $betamtspot14=$betamtspot14+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot14">'.$betamtspot14.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_15_]'){
              $betamtspot15=$betamtspot15+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot15">'.$betamtspot15.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_16_]'){
              $betamtspot16=$betamtspot16+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot16">'.$betamtspot16.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_17_]'){
              $betamtspot17=$betamtspot17+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot17">'.$betamtspot17.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_18_]'){
              $betamtspot18=$betamtspot18+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot18">'.$betamtspot18.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_19_]'){
              $betamtspot19=$betamtspot19+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot19">'.$betamtspot19.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_20_]'){
              $betamtspot20=$betamtspot20+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot20">'.$betamtspot20.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_21_]'){
              $betamtspot21=$betamtspot21+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot21">'.$betamtspot21.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_22_]'){
              $betamtspot22=$betamtspot22+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot22">'.$betamtspot22.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_23_]'){
              $betamtspot23=$betamtspot23+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot23">'.$betamtspot23.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_24_]'){
              $betamtspot24=$betamtspot24+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot24">'.$betamtspot24.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_25_]'){
              $betamtspot25=$betamtspot25+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot25">'.$betamtspot25.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_26_]'){
              $betamtspot26=$betamtspot26+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot26">'.$betamtspot26.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_27_]'){
              $betamtspot27=$betamtspot27+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot27">'.$betamtspot27.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_28_]'){
              $betamtspot28=$betamtspot28+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot28">'.$betamtspot28.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_29_]'){
              $betamtspot29=$betamtspot29+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot29">'.$betamtspot29.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_30_]'){
              $betamtspot30=$betamtspot30+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot30">'.$betamtspot30.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_31_]'){
              $betamtspot31=$betamtspot31+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot31">'.$betamtspot31.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_32_]'){
              $betamtspot32=$betamtspot32+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot32">'.$betamtspot32.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_33_]'){
              $betamtspot33=$betamtspot33+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot33">'.$betamtspot33.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_34_]'){
              $betamtspot34=$betamtspot34+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot34">'.$betamtspot34.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_35_]'){
              $betamtspot35=$betamtspot35+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot35">'.$betamtspot35.'</div>';
          }
          if($playedLines=='STRAIGHT_BET[_36_]'){
              $betamtspot36=$betamtspot36+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot36">'.$betamtspot36.'</div>';
          }
          
          if($playedLines=='SPLIT_BET[_0_1_]'){
              $betamtspot0_1=$betamtspot0_1+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0_1">'.$betamtspot0_1.'</div>';
          }
          if($playedLines=='SPLIT_BET[_0_2_]'){
              $betamtspot0_2=$betamtspot0_2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0_2">'.$betamtspot0_2.'</div>';
          }
          if($playedLines=='SPLIT_BET[_0_3_]'){
              $betamtspot0_3=$betamtspot0_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0_3">'.$betamtspot0_3.'</div>';
          }
          if($playedLines=='SPLIT_BET[_1_2_]'){
              $betamtspot1_2=$betamtspot1_2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot1_2">'.$betamtspot1_2.'</div>';
          }
          if($playedLines=='SPLIT_BET[_2_3_]'){
              $betamtspot2_3=$betamtspot2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot2_3">'.$betamtspot2_3.'</div>';
          }
          if($playedLines=='SPLIT_BET[_1_4_]'){
              $betamtspot1_4=$betamtspot1_4+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot1_4">'.$betamtspot1_4.'</div>';
          }
          if($playedLines=='SPLIT_BET[_2_5_]'){
              $betamtspot2_5=$betamtspot2_5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot2_5">'.$betamtspot2_5.'</div>';
          }
          if($playedLines=='SPLIT_BET[_3_6_]'){
              $betamtspot3_6=$betamtspot3_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot3_6">'.$betamtspot3_6.'</div>';
          }
          if($playedLines=='SPLIT_BET[_4_5_]'){
              $betamtspot4_5=$betamtspot4_5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot4_5">'.$betamtspot4_5.'</div>';
          }
          if($playedLines=='SPLIT_BET[_5_6_]'){
              $betamtspot5_6=$betamtspot5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot5_6">'.$betamtspot5_6.'</div>';
          }
          if($playedLines=='SPLIT_BET[_4_7_]'){
              $betamtspot4_7=$betamtspot4_7+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot4_7">'.$betamtspot4_7.'</div>';
          }
          if($playedLines=='SPLIT_BET[_5_8_]'){
              $betamtspot5_8=$betamtspot5_8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot5_8">'.$betamtspot5_8.'</div>';
          }
          if($playedLines=='SPLIT_BET[_6_9_]'){
              $betamtspot6_9=$betamtspot6_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot6_9">'.$betamtspot6_9.'</div>';
          }
          if($playedLines=='SPLIT_BET[_7_8_]'){
              $betamtspot7_8=$betamtspot7_8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot7_8">'.$betamtspot7_8.'</div>';
          }
          if($playedLines=='SPLIT_BET[_8_9_]'){
              $betamtspot8_9=$betamtspot8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot8_9">'.$betamtspot8_9.'</div>';
          }
          if($playedLines=='SPLIT_BET[_7_10_]'){
              $betamtspot7_10=$betamtspot7_10+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot7_10">'.$betamtspot7_10.'</div>';
          }
          if($playedLines=='SPLIT_BET[_8_11_]'){
              $betamtspot8_11=$betamtspot8_11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot8_11">'.$betamtspot8_11.'</div>';
          }
          if($playedLines=='SPLIT_BET[_9_12_]'){
              $betamtspot9_12=$betamtspot9_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot9_12">'.$betamtspot9_12.'</div>';
          }
          if($playedLines=='SPLIT_BET[_10_11_]'){
              $betamtspot10_11=$betamtspot10_11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot10_11">'.$betamtspot10_11.'</div>';
          }
          if($playedLines=='SPLIT_BET[_11_12_]'){
              $betamtspot11_12=$betamtspot11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot11_12">'.$betamtspot11_12.'</div>';
          }
          if($playedLines=='SPLIT_BET[_10_13_]'){
              $betamtspot10_13=$betamtspot10_13+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot10_13">'.$betamtspot10_13.'</div>';
          }
          if($playedLines=='SPLIT_BET[_11_14_]'){
              $betamtspot11_14=$betamtspot11_14+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot11_14">'.$betamtspot11_14.'</div>';
          }
          if($playedLines=='SPLIT_BET[_12_15_]'){
              $betamtspot12_15=$betamtspot12_15+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot12_15">'.$betamtspot12_15.'</div>';
          }
          if($playedLines=='SPLIT_BET[_13_14_]'){
              $betamtspot13_14=$betamtspot13_14+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot13_14">'.$betamtspot13_14.'</div>';
          }
          if($playedLines=='SPLIT_BET[_14_15_]'){
              $betamtspot14_15=$betamtspot14_15+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot14_15">'.$betamtspot14_15.'</div>';
          }
          if($playedLines=='SPLIT_BET[_13_16_]'){
              $betamtspot13_16=$betamtspot13_16+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot13_16">'.$betamtspot13_16.'</div>';
          }
          if($playedLines=='SPLIT_BET[_14_17_]'){
              $betamtspot14_17=$betamtspot14_17+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot14_17">'.$betamtspot14_17.'</div>';
          }
          if($playedLines=='SPLIT_BET[_15_18_]'){
              $betamtspot15_18=$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot15_18">'.$betamtspot15_18.'</div>';
          }
          if($playedLines=='SPLIT_BET[_16_17_]'){
              $betamtspot16_17=$betamtspot16_17+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot16_17">'.$betamtspot16_17.'</div>';
          }
          if($playedLines=='SPLIT_BET[_17_18_]'){
              $betamtspot17_18=$betamtspot17_18+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot17_18">'.$betamtspot17_18.'</div>';
          }
          if($playedLines=='SPLIT_BET[_16_19_]'){
              $betamtspot16_19=$betamtspot16_19+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot16_19">'.$betamtspot16_19.'</div>';
          }
          if($playedLines=='SPLIT_BET[_17_20_]'){
              $betamtspot17_20=$betamtspot17_20+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot17_20">'.$betamtspot17_20.'</div>';
          }
          if($playedLines=='SPLIT_BET[_18_21_]'){
              $betamtspot18_21=$betamtspot18_21+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot18_21">'.$betamtspot18_21.'</div>';
          }
          if($playedLines=='SPLIT_BET[_19_20_]'){
              $betamtspot19_20=$betamtspot19_20+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot19_20">'.$betamtspot19_20.'</div>';
          }
          if($playedLines=='SPLIT_BET[_20_21_]'){
              $betamtspot20_21=$betamtspot20_21+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot20_21">'.$betamtspot20_21.'</div>';
          }
          if($playedLines=='SPLIT_BET[_19_22_]'){
              $betamtspot19_22=$betamtspot19_22+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot19_22">'.$betamtspot19_22.'</div>';
          }
          if($playedLines=='SPLIT_BET[_20_23_]'){
              $betamtspot20_23=$betamtspot20_23+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot20_23">'.$betamtspot20_23.'</div>';
          }
          if($playedLines=='SPLIT_BET[_21_24_]'){
              $betamtspot21_24=$betamtspot21_24+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot21_24">'.$betamtspot21_24.'</div>';
          }
          if($playedLines=='SPLIT_BET[_22_23_]'){
              $betamtspot22_23=$betamtspot22_23+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot22_23">'.$betamtspot22_23.'</div>';
          }
          if($playedLines=='SPLIT_BET[_23_24_]'){
              $betamtspot23_24=$betamtspot23_24+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot23_24">'.$betamtspot23_24.'</div>';
          }
          if($playedLines=='SPLIT_BET[_22_25_]'){
              $betamtspot22_25=$betamtspot22_25+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot22_25">'.$betamtspot22_25.'</div>';
          }
          if($playedLines=='SPLIT_BET[_23_26_]'){
              $betamtspot23_26=$betamtspot23_26+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot23_26">'.$betamtspot23_26.'</div>';
          }
          if($playedLines=='SPLIT_BET[_24_27_]'){
              $betamtspot24_27=$betamtspot24_27+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot24_27">'.$betamtspot24_27.'</div>';
          }
          if($playedLines=='SPLIT_BET[_25_26_]'){
              $betamtspot25_26=$betamtspot25_26+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot25_26">'.$betamtspot25_26.'</div>';
          }
          if($playedLines=='SPLIT_BET[_26_27_]'){
              $betamtspot26_27=$betamtspot26_27+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot26_27">'.$betamtspot26_27.'</div>';
          }
          if($playedLines=='SPLIT_BET[_25_28_]'){
              $betamtspot25_28=$betamtspot25_28+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot25_28">'.$betamtspot25_28.'</div>';
          }
          if($playedLines=='SPLIT_BET[_26_29_]'){
              $betamtspot26_29=$betamtspot26_29+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot26_29">'.$betamtspot26_29.'</div>';
          }
          if($playedLines=='SPLIT_BET[_27_30_]'){
              $betamtspot27_30=$betamtspot27_30+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot27_30">'.$betamtspot27_30.'</div>';
          }
          if($playedLines=='SPLIT_BET[_28_29_]'){
              $betamtspot28_29=$betamtspot28_29+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot28_29">'.$betamtspot28_29.'</div>';
          }
          if($playedLines=='SPLIT_BET[_29_30_]'){
              $betamtspot29_30=$betamtspot29_30+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot29_30">'.$betamtspot29_30.'</div>';
          }if($playedLines=='SPLIT_BET[_28_31_]'){
              $betamtspot28_31=$betamtspot28_31+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot28_31">'.$betamtspot28_31.'</div>';
          }
          if($playedLines=='SPLIT_BET[_29_32_]'){
              $betamtspot29_32=$betamtspot29_32+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot29_32">'.$betamtspot29_32.'</div>';
          }
          if($playedLines=='SPLIT_BET[_30_33_]'){
              $betamtspot30_33=$betamtspot30_33+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot30_33">'.$betamtspot30_33.'</div>';
          }
          if($playedLines=='SPLIT_BET[_31_32_]'){
              $betamtspot31_32=$betamtspot31_32+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot31_32">'.$betamtspot31_32.'</div>';
          }
          if($playedLines=='SPLIT_BET[_32_33_]'){
              $betamtspot32_33=$betamtspot32_33+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot32_33">'.$betamtspot32_33.'</div>';
          }
          if($playedLines=='SPLIT_BET[_31_34_]'){
              $betamtspot31_34=$betamtspot31_34+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot31_34">'.$betamtspot31_34.'</div>';
          }
          if($playedLines=='SPLIT_BET[_32_35_]'){
              $betamtspot32_35=$betamtspot32_35+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot32_35">'.$betamtspot32_35.'</div>';
          }
          if($playedLines=='SPLIT_BET[_33_36_]'){
              $betamtspot33_36=$betamtspot33_36+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot33_36">'.$betamtspot33_36.'</div>';
          }
          if($playedLines=='SPLIT_BET[_34_35_]'){
              $betamtspot34_35=$betamtspot34_35+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot34_35">'.$betamtspot34_35.'</div>';
          }
          if($playedLines=='SPLIT_BET[_35_36_]'){
              $betamtspot35_36=$betamtspot35_36+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot35_36">'.$betamtspot35_36.'</div>';
          }
          #six line bet
          if($playedLines=='SIX_LINE_BET[_1_2_3_4_5_6_]'){
              $betamtspot1_2_3_4_5_6=$betamtspot1_2_3_4_5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot1_2_3_4_5_6">'.$betamtspot1_2_3_4_5_6.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_4_5_6_7_8_9_]'){
              $betamtspot4_5_6_7_8_9=$betamtspot4_5_6_7_8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot4_5_6_7_8_9">'.$betamtspot4_5_6_7_8_9.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_7_8_9_10_11_12_]'){
              $betamtspot7_8_9_10_11_12=$betamtspot7_8_9_10_11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot7_8_9_10_11_12">'.$betamtspot7_8_9_10_11_12.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_10_11_12_13_14_15_]'){
              $betamtspot10_11_12_13_14_15=$betamtspot10_11_12_13_14_15+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot10_11_12_13_14_15">'.$betamtspot10_11_12_13_14_15.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_13_14_15_16_17_18_]'){
              $betamtspot13_14_15_16_17_18=$betamtspot13_14_15_16_17_18+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot13_14_15_16_17_18">'.$betamtspot13_14_15_16_17_18.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_16_17_18_19_20_21_]'){
              $betamtspot16_17_18_19_20_21=$betamtspot16_17_18_19_20_21+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot16_17_18_19_20_21">'.$betamtspot16_17_18_19_20_21.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_19_20_21_22_23_24_]'){
              $betamtspot19_20_21_22_23_24=$betamtspot19_20_21_22_23_24+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot19_20_21_22_23_24">'.$betamtspot19_20_21_22_23_24.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_22_23_24_25_26_27_]'){
              $betamtspot22_23_24_25_26_27=$betamtspot22_23_24_25_26_27+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot22_23_24_25_26_27">'.$betamtspot22_23_24_25_26_27.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_25_26_27_28_29_30_]'){
              $betamtspot25_26_27_28_29_30=$betamtspot25_26_27_28_29_30+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot25_26_27_28_29_30">'.$betamtspot25_26_27_28_29_30.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_28_29_30_31_32_33_]'){
              $betamtspot28_29_30_31_32_33=$betamtspot28_29_30_31_32_33+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot28_29_30_31_32_33">'.$betamtspot28_29_30_31_32_33.'</div>';
          }
          if($playedLines=='SIX_LINE_BET[_31_32_33_34_35_36_]'){
              $betamtspot31_32_33_34_35_36=$betamtspot31_32_33_34_35_36+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot31_32_33_34_35_36">'.$betamtspot31_32_33_34_35_36.'</div>';
          }
          
          #Street bet
          if($playedLines=='STREET_BET[_0_1_2_]'){
              $betamtspot0_1_2=$betamtspot0_1_2+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0_1_2">'.$betamtspot0_1_2.'</div>';
          }
          if($playedLines=='STREET_BET[_0_2_3_]'){
              $betamtspot0_2_3=$betamtspot0_2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0_2_3">'.$betamtspot0_2_3.'</div>';
          }
          if($playedLines=='STREET_BET[_1_2_3_]'){
              $betamtspot1_2_3=$betamtspot1_2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot1_2_3">'.$betamtspot1_2_3.'</div>';
          }
          if($playedLines=='STREET_BET[_4_5_6_]'){
              $betamtspot4_5_6=$betamtspot4_5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot4_5_6">'.$betamtspot4_5_6.'</div>';
          }
          if($playedLines=='STREET_BET[_7_8_9_]'){
              $betamtspot7_8_9=$betamtspot7_8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot7_8_9">'.$betamtspot7_8_9.'</div>';
          }
          if($playedLines=='STREET_BET[_10_11_12_]'){
              $betamtspot10_11_12=$betamtspot10_11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot10_11_12">'.$betamtspot10_11_12.'</div>';
          }
          if($playedLines=='STREET_BET[_13_14_15_]'){
              $betamtspot13_14_15=$betamtspot13_14_15+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot13_14_15">'.$betamtspot13_14_15.'</div>';
          }
          if($playedLines=='STREET_BET[_16_17_18_]'){
              $betamtspot16_17_18=$betamtspot16_17_18+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot16_17_18">'.$betamtspot16_17_18.'</div>';
          }
          if($playedLines=='STREET_BET[_19_20_21_]'){
              $betamtspot19_20_21=$betamtspot19_20_21+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot19_20_21">'.$betamtspot19_20_21.'</div>';
          }
          if($playedLines=='STREET_BET[_22_23_24_]'){
              $betamtspot22_23_24=$betamtspot22_23_24+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot22_23_24">'.$betamtspot22_23_24.'</div>';
          }
          if($playedLines=='STREET_BET[_25_26_27_]'){
              $betamtspot25_26_27=$betamtspot25_26_27+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot25_26_27">'.$betamtspot25_26_27.'</div>';
          }
          
          if($playedLines=='STREET_BET[_28_29_30_]'){
              $betamtspot28_29_30=$betamtspot28_29_30+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot28_29_30">'.$betamtspot28_29_30.'</div>';
          }
          
          if($playedLines=='STREET_BET[_31_32_33_]'){
              $betamtspot31_32_33=$betamtspot31_32_33+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot31_32_33">'.$betamtspot31_32_33.'</div>';
          }
          
          if($playedLines=='STREET_BET[_34_35_36_]'){
              $betamtspot34_35_36=$betamtspot34_35_36+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot34_35_36">'.$betamtspot34_35_36.'</div>';
          }
          
          #cornor bet
          
          if($playedLines=='CORNER_BET[_0_1_2_3_]'){
              $betamtspot0_1_2_3=$betamtspot0_1_2_3+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot0_1_2_3">'.$betamtspot0_1_2_3.'</div>';
          }
          if($playedLines=='CORNER_BET[_1_2_4_5_]'){
              $betamtspot1_2_4_5=$betamtspot1_2_4_5+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot1_2_4_5">'.$betamtspot1_2_4_5.'</div>';
          }
          if($playedLines=='CORNER_BET[_2_3_5_6_]'){
              $betamtspot2_3_5_6=$betamtspot2_3_5_6+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot2_3_5_6">'.$betamtspot2_3_5_6.'</div>';
          }
          if($playedLines=='CORNER_BET[_4_5_7_8_]'){
              $betamtspot4_5_7_8=$betamtspot4_5_7_8+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot4_5_7_8">'.$betamtspot4_5_7_8.'</div>';
          }
          if($playedLines=='CORNER_BET[_5_6_8_9_]'){
              $betamtspot5_6_8_9=$betamtspot5_6_8_9+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot5_6_8_9">'.$betamtspot5_6_8_9.'</div>';
          }
          if($playedLines=='CORNER_BET[_7_8_10_11_]'){
              $betamtspot7_8_10_11=$betamtspot7_8_10_11+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot7_8_10_11">'.$betamtspot7_8_10_11.'</div>';
          }
          if($playedLines=='CORNER_BET[_8_9_11_12_]'){
              $betamtspot8_9_11_12=$betamtspot8_9_11_12+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot8_9_11_12">'.$betamtspot8_9_11_12.'</div>';
          }
          if($playedLines=='CORNER_BET[_10_11_13_14_]'){
              $betamtspot10_11_13_14=$betamtspot10_11_13_14+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot10_11_13_14">'.$betamtspot10_11_13_14.'</div>';
          }
          if($playedLines=='CORNER_BET[_11_12_14_15_]'){
              $betamtspot11_12_14_15=$betamtspot11_12_14_15+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot11_12_14_15">'.$betamtspot11_12_14_15.'</div>';
          }
          if($playedLines=='CORNER_BET[_13_14_16_17_]'){
              $betamtspot13_14_16_17=$betamtspot13_14_16_17+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot13_14_16_17">'.$betamtspot13_14_16_17.'</div>';
          }
          if($playedLines=='CORNER_BET[_14_15_17_18_]'){
              $betamtspot14_15_17_18=$betamtspot14_15_17_18+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot14_15_17_18">'.$betamtspot14_15_17_18.'</div>';
          }
          if($playedLines=='CORNER_BET[_16_17_19_20_]'){
              $betamtspot16_17_19_20=$betamtspot16_17_19_20+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot16_17_19_20">'.$betamtspot16_17_19_20.'</div>';
          }
          if($playedLines=='CORNER_BET[_17_18_20_21_]'){
              $betamtspot17_18_20_21=$betamtspot17_18_20_21+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot17_18_20_21">'.$betamtspot17_18_20_21.'</div>';
          }
          if($playedLines=='CORNER_BET[_19_20_22_23_]'){
              $betamtspot19_20_22_23=$betamtspot19_20_22_23+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot19_20_22_23">'.$betamtspot19_20_22_23.'</div>';
          }
          if($playedLines=='CORNER_BET[_20_21_23_24_]'){
              $betamtspot20_21_23_24=$betamtspot20_21_23_24+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot20_21_23_24">'.$betamtspot20_21_23_24.'</div>';
          }
          if($playedLines=='CORNER_BET[_22_23_25_26_]'){
              $betamtspot22_23_25_26=$betamtspot22_23_25_26+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot22_23_25_26">'.$betamtspot22_23_25_26.'</div>';
          }
          if($playedLines=='CORNER_BET[_23_24_26_27_]'){
              $betamtspot23_24_26_27=$betamtspot23_24_26_27+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot23_24_26_27">'.$betamtspot23_24_26_27.'</div>';
          }
          if($playedLines=='CORNER_BET[_25_26_28_29_]'){
              $betamtspot25_26_28_29=$betamtspot25_26_28_29+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot25_26_28_29">'.$betamtspot25_26_28_29.'</div>';
          }
          if($playedLines=='CORNER_BET[_26_27_29_30_]'){
              $betamtspot26_27_29_30=$betamtspot26_27_29_30+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot26_27_29_30">'.$betamtspot26_27_29_30.'</div>';
          }
          if($playedLines=='CORNER_BET[_28_29_31_32_]'){
              $betamtspot28_29_31_32=$betamtspot28_29_31_32+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot28_29_31_32">'.$betamtspot28_29_31_32.'</div>';
          }
          if($playedLines=='CORNER_BET[_29_30_32_33_]'){
              $betamtspot29_30_32_33=$betamtspot29_30_32_33+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot29_30_32_33">'.$betamtspot29_30_32_33.'</div>';
          }
          if($playedLines=='CORNER_BET[_31_32_34_35_]'){
              $betamtspot31_32_34_35=$betamtspot31_32_34_35+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot31_32_34_35">'.$betamtspot31_32_34_35.'</div>';
          }
          if($playedLines=='CORNER_BET[_32_33_35_36_]'){
              $betamtspot32_33_35_36=$betamtspot32_33_35_36+$tot['spinResult']['betPlayedOption'][$p]['betAmtPerOption'];
              echo '<div class="spot32_33_35_36">'.$betamtspot32_33_35_36.'</div>';
          }
          
          
          
          
	 if($p!=($playedLinescnt-1))
	 {
	  echo "\n";
	 }											
	}
        
        if($number != ''){
            switch($number){
               case 0:
                   echo '<div class="spotw0">win</div>';
                   break;  
               case 1:
                   echo '<div class="spotw1">win</div>';
                   break;
               case 2:
                   echo '<div class="spotw2">win</div>';
                   break;
               case 3:
                   echo '<div class="spotw3">win</div>';
                   break;
               case 4:
                   echo '<div class="spotw4">win</div>';
                   break;
               case 5:
                   echo '<div class="spotw5">win</div>';
                   break;
               case 6:
                   echo '<div class="spotw6">win</div>';
                   break;
               case 7:
                   echo '<div class="spotw7">win</div>';
                   break;
               case 8:
                   echo '<div class="spotw8">win</div>';
                   break;
               case 9:
                   echo '<div class="spotw9">win</div>';
                   break;
               case 10:
                   echo '<div class="spotw10">win</div>';
                   break;
               case 11:
                   echo '<div class="spotw11">win</div>';
                   break;
               case 12:
                   echo '<div class="spotw12">win</div>';
                   break;
               case 13:
                   echo '<div class="spotw13">win</div>';
                   break;
               case 14:
                   echo '<div class="spotw14">win</div>';
                   break;
               case 15:
                   echo '<div class="spotw15">win</div>';
                   break;
               case 16:
                   echo '<div class="spotw16">win</div>';
                   break;
               case 17:
                   echo '<div class="spotw17">win</div>';
                   break;
               case 18:
                   echo '<div class="spotw18">win</div>';
                   break;
               case 19:
                   echo '<div class="spotw19">win</div>';
                   break;
               case 20:
                   echo '<div class="spotw20">win</div>';
                   break;
               case 21:
                   echo '<div class="spotw21">win</div>';
                   break;
               case 22:
                   echo '<div class="spotw22">win</div>';
                   break;
               case 23:
                   echo '<div class="spotw23">win</div>';
                   break;
               case 24:
                   echo '<div class="spotw24">win</div>';
                   break;
               case 25:
                   echo '<div class="spotw25">win</div>';
                   break;
               case 26:
                   echo '<div class="spotw26">win</div>';
                   break;
               case 27:
                   echo '<div class="spotw27">win</div>';
                   break;
               case 28:
                   echo '<div class="spotw28">win</div>';
                   break;
               case 29:
                   echo '<div class="spotw29">win</div>';
                   break;
               case 30:
                   echo '<div class="spotw30">win</div>';
                   break;
               case 31:
                   echo '<div class="spotw31">win</div>';
                   break;
               case 32:
                   echo '<div class="spotw32">win</div>';
                   break;
               case 33:
                   echo '<div class="spotw33">win</div>';
                   break;
               case 34:
                   echo '<div class="spotw34">win</div>';
                   break;
               case 35:
                   echo '<div class="spotw35">win</div>';
                   break;
               case 36:
                   echo '<div class="spotw36">win</div>';
                   break;
            }
        }  ?>
</div>
</div>
