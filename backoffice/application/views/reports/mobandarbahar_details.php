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
        <div class="Agent_game_val2" style="width:190px">: <?php echo $handId;?></div>
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
              <td class="NTblHdrTxt" style="width:176px" >Start Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt" style="width:176px" >End Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt" style="width:176px" >House Card</td>
            </tr>
          </table></td>          
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Stake</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt" style="width:60px">Win</td>
            </tr>
          </table></td>
      </tr>
<?PHP
$results = $this->game_model->getmobAndharBaharPlayDetails($handId); 
$tot=json_decode($results[0]->PLAY_DATA,true); 
$arrSingle=array(1,2,3,4,5,6,7,8,9,10,11,12,13);
$arrSymbol=array("spade","club","heart","diamond");	
$arrEven=array("red","black");

function cardConversion($houseCard) {
	$winCard = 0;
	for ($j=1; $j<4; $j++) {
		if ($houseCard > 13) {
			$wincard = $houseCard - (13 * ($j));
			if (($wincard > 0) && ($wincard <= 13)) {
				$winCard = $wincard;
			}
		} else {
			$winCard = $houseCard;
		}
	}
	return $winCard;		
}
?>
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
              <td><?PHP echo $tot["result"]["houseCard"]; ?></td>
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
	
<table width="60%" cellpadding="0" cellspacing="0" style="margin-top:5px;">
	<tr style="height:30px;background-color:#ccc;">
    	<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bet Area</strong></td><td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bet</strong></td>
    </tr>
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Single</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>         
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $sIndex=>$single) {
			if(in_array($sIndex,$arrSingle)) {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$sIndex.'</td><td width="20%" style="border:1px solid #ccc;">'.$single.'</td>';        
				echo '</tr>';				
			}
		}
	?>  

	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Symbol</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>    
    <?php
		foreach($tot["result"]["betNumber"] as $symbolIndex=>$symbol) {
			if(in_array($symbolIndex,$arrSymbol)) {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$symbolIndex.'</td><td width="20%" style="border:1px solid #ccc;">'.$symbol.'</td>';        
				echo '</tr>';				
			}
		}
	?>        

	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Even</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $eIndex=>$even) {
			if(in_array($eIndex,$arrEven)) {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$eIndex.'</td><td width="20%" style="border:1px solid #ccc;">'.$even.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
    
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Small Bet</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $sindex=>$svalue) {
			if($sindex=="Ato6") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$sindex.'</td><td width="20%" style="border:1px solid #ccc;">'.$svalue.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
 
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Big Bet</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $bindex=>$bvalue) {
			if($bindex=="EtoK") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$bindex.'</td><td width="20%" style="border:1px solid #ccc;">'.$bvalue.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
 
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Perfect</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $pindex=>$pvalue) {
			if($pindex=="seven") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$pindex.'</td><td width="20%" style="border:1px solid #ccc;">'.$pvalue.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
 
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Andhar</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $aindex=>$avalue) {
			if($aindex=="andar") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$aindex.'</td><td width="20%" style="border:1px solid #ccc;">'.$avalue.'</td>';        
				echo '</tr>';				
			}
		}
	?>    

	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;"><strong>Bahar</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		foreach($tot["result"]["betNumber"] as $bindex=>$bvalue) {
			if($bindex=="bahar") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$bindex.'</td><td width="20%" style="border:1px solid #ccc;">'.$bvalue.'</td>';        
				echo '</tr>';				
			}
		}
	?>                           
</table>        