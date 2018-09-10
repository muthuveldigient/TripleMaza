    <link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />


  <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php echo ucfirst(strtolower($gameName));?></div>
      </div>
    </div>
    <div class="Agent_game_Left" style="width:350px;">
      <div class="Agent_game_tit_wrap" style="width:350px;">
        <div class="Agent_game_name">Hand ID</div>
        <div class="Agent_game_val2" style="width:220px;">: <?php echo $handId;?></div>
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
              <td class="NTblHdrTxt" style="width:176px" >House Card</td>
            </tr>
          </table></td>  
		<!--<td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
		<tr>
		  <td class="NTblHdrTxt">Win Hand</td>
		</tr>
	  </table></td>	-->	  
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
	   <?PHP  $results = $this->game_model->andarbahar_play($handId,$get); 
			
		foreach($results as $key=>$val){

			/*function cardConversion($val->houseCard) {
			
				$winCard = 0;
				for ($j=1; $j<4; $j++) {
					if ($val->houseCard > 13) {
						$wincard = $val->houseCard - (13 * ($j));
						if (($wincard > 0) && ($wincard <= 13)) {
							$winCard = $wincard;
						}
					} else {
						$winCard = $val->houseCard;
					}
				}
				return $winCard; 		
			}	*/
	
	$hCard=json_decode($val->PLAY_DATA,true);
	
	$winner = $hCard["andarBaharResult"]["gameResult"]['winPlayer'];
?>
      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $val->USERNAME; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->INTERNAL_REFFERENCE_NO; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->STARTED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->ENDED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td>
              <?php
				$housecard = $hCard["andarBaharResult"]["gameResult"]['houseCard']['value'];  ?>
				<img src="<?php echo base_url();?>images/cards/<?php echo $housecard.".png"?>" height="45" width="45" align="center" style="margin-left:53px;"/>
				<?php /*?><?php echo cardConversion($hCard["result"]["houseCard"]);  ?><?php */?>
              </td>
            </tr>
          </table></td>   
		<!--<td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP //echo $val->winner; ?></td>
            </tr>
          </table></td>	-->	  
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->STAKE; ?></td>
            </tr>
          </table></td>

        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->WIN; ?></td>
            </tr>
          </table></td>
		 
          
      </tr>
      <?php 	  
$i++;
}
?>
    </table>

     
</div>
  </div>
<?php

  
    $tot=json_decode($val->PLAY_DATA,true); 
	//echo '<prE>';print_r($tot["andarBaharResult"]["bet"]);exit;
	$arrSingle=array(1,2,3,4,5,6,7,8,9,10,11,12,13);
	$arrSymbol=array("spade","club","heart","diamond");	
	$arrEven=array("red","black");
	
	
	
  ?>
  
  <table width="60%" cellpadding="0" cellspacing="0" style="margin-top:5px;">
	<tbody><tr style="height:30px;background-color:#ccc;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Play</strong></td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Andar</strong></td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bahar</strong></td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Total Bet</strong></td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Total Win</strong></td>
    </tr>
	<?php //echo '<pre>';print_r($tot);exit;
			//echo '<pre>';print_r($tot);exit;
		if(!empty($tot["andarBaharResult"]["bet"])){
			foreach($tot["andarBaharResult"]["bet"] as $type=>$val){
				
			
		
	?>
			<tr style="height:30px;">
				<td width="20%" style="border:1px solid #ccc;text-align:center;">
					<strong><?= $type;?></strong>
				</td>
				<td width="20%" style="border:1px solid #ccc;text-align: center;"><?= $val['andar'];?></td>
				<td width="20%" style="border:1px solid #ccc; text-align: center;"><?= $val['bahar'];?></td>
				<td width="20%" style="border:1px solid #ccc;text-align: center;"></td>
				</td><td width="20%" style="border:1px solid #ccc;"></td>        
			</tr>
	<?php }?>
	<tr style="height:30px;"><td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td>
		<td width="20%" style="border:1px solid #ccc; text-align:center;">Win Amount</td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;"><?= (!empty($tot['andarBaharResult']['betAmount'])?$tot['andarBaharResult']['betAmount']:'0');?></td>
		<td width="20%" style="border:1px solid #ccc;text-align:center;"><?= (!empty($tot['andarBaharResult']['winAmount'])?$tot['andarBaharResult']['winAmount']:'0');?></td>
	</tr>
<?php	} ?>
</tbody></table>