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
            <td class="NTblHdrTxt">Win</td>
          </tr>
        </table></td>
    </tr>
    <?PHP  $results = $this->game_model->getBaccaratTimerDetails($handId);  ?>
    <tr>
      <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
          <tr>
            <td class=""><?PHP echo $results[0]->USERNAME; ?></td>
          </tr>
        </table></td>
      <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
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
            <td><?PHP echo $results[0]->WIN; ?></td>
          </tr>
        </table></td>
    </tr>
  </table>
	<?php
	$total=json_decode($results[0]->PLAY_DATA, true);
	$playercardtot=$total['baccaratResult']['drawCards']['playerValue'];
	$bankercardtot=$total['baccaratResult']['drawCards']['bankerValue'];
	if($total['baccaratResult']['drawCards']['playerCards']){
		$totusercards=explode(",",$total['baccaratResult']['drawCards']['playerCards']);
	?>
	<div class="UDFieldtitle"> <span  style=" font-weight:bold">Player Cards:</span> </div>
	<table cellpadding="2" cellspacing="2" >
	   <tr>
		  <td>
			 <table>
				<tr>
				   <?php 
					  for($uc=0;$uc<count($totusercards);$uc++)
					  { 
						  $cardname=$totusercards[$uc];
						  $cardval=$totusercards[$uc];
						  ?>
				   <td <?php if($playercardtot==$bankercardtot || $playercardtot>$bankercardtot){?> style="border: 1px solid #FF0000;" <?php }?>><?php 
					  if($cardname){
					  echo '<img src="'.base_url().'static/images/minigame/blackjack/'.$cardname.'.png">';
					  }?></td>
				   <?php
					  }
					  ?>
				</tr>
				<tr>
				   <td><strong><?php echo $total['baccaratResult']['drawCards']['playerValue'];?></strong></td>
				</tr>
			 </table>
		  </td>
	   </tr>
	</table>	
	<?php } ?>	  
	<?php
   	if($total['baccaratResult']['drawCards']['bankerCards']) {
		$totdealercards=explode(",",$total['baccaratResult']['drawCards']['bankerCards']);  
   	?>
	<br/>
	<div class="UDFieldtitle" style="padding-top:20px;"> <span  style=" font-weight:bold">Banker Cards:</span> </div>
	<div class="UDFieldtitle">
	   <table cellpadding="2" cellspacing="2" >
		  <tr>
			 <?php 
				for($dc=0;$dc<count($totdealercards);$dc++)
				{ 
					$cardname1=$totdealercards[$dc];
					$cardval1=$totdealercards[$dc];
					?>
			 <td <?php if($playercardtot==$bankercardtot || $playercardtot<$bankercardtot){ ?> style="border: 1px solid #FF0000;" <?php }else{ ?>  <?php } ?>  ><?php 
				if($cardname1){
				echo '<img src="'.base_url().'static/images/minigame/blackjack/'.$cardname1.'.png">';
				}?></td>
			 <?php
				}
				?>
		  </tr>
		  <tr>
			 <td><strong><?php echo $total['baccaratResult']['drawCards']['bankerValue'];?></strong></td>
		  </tr>
	   </table>
	</div>
	<?php }?>	
	<div class="UDFieldtitle" style="padding-top:20px;">
		<?php                      
		$totplayedoptions=$total['baccaratResult']['betPlayedOptions'];
		$totwinoptions=$total['baccaratResult']['winOptions'];
		for($k=0;$k<count($totplayedoptions);$k++){
		$playedoption[]=$totplayedoptions[$k]['playedOption'];
		$betamount[]=$totplayedoptions[$k]['betAmtPerOption'];
		}
		
		echo "<table width='500' class='UDFieldtitle'><tr><td width='50'><span  style=' font-weight:bold;'>Bet option </span></td><td width='50'><span  style=' font-weight:bold;'>Bet Points </span></td><td width='50'> <span  style=' font-weight:bold;'>Win Points </span></td></tr>";
		for($m=0;$m<count($playedoption);$m++){
		  echo "<tr>";
		  $playedoptions=$playedoption[$m];
		  $betamt=$betamount[$m];
		 if($totwinoptions['winType']==$playedoptions){
			$winfactor=$totwinoptions['winFactor'];
			$winamount=($betamt*$winfactor);
			if($playedoptions=='BANKERHAND'){
				$bankercommission=0.05*$winamount;
				$winamount=$winamount-$bankercommission;
			}
			$winamount=$winamount+$betamt;
		  }else{
				  $winamount="0";
		  }
		  echo "<td><span  style=' font-weight:normal;'>".$playedoptions."</span></td><td><span  style=' font-weight:normal;'>".number_format($betamt,2,".","")."</span></td> <td><span  style=' font-weight:normal;'>".number_format($winamount,2,".","")."</span></td>";
		  echo "</tr>";
		}
		echo "</table>";                     
		?>
	</div>  
</div>