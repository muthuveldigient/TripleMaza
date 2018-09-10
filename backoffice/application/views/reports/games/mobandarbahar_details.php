<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
  <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php echo ucfirst(strtolower($dispName));?></div>
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
$results = $this->game_model->getmobAndharBaharPlayDetails($handId,$gameName); 
//echo '<pre>';print_r($results);exit;
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
              <td>
              <?php $housecard = $tot["result"]["houseCard"];  ?>
				<img src="<?php echo base_url();?>/images/cards/<?php echo $housecard.".png"?>" height="45" width="45" align="center" style="margin-left:53px;"/>
				</td>
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
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Type</strong></td><td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bet Area</strong></td><td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bet</strong></td><td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Win</strong></td>
    </tr>
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Single</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		for($k=0;$k<=count($tot["result"]["winOptionList"]);$k++) {
			$winoption = $tot["result"]["winOptionList"][$k]['winOptions'];
			if($winoption=="SINGLE_SERIES") {
				$winvalue = $tot["result"]["winOptionList"][$k]['winFactor'];
			}
		}
		
		$housecard = $tot["result"]["houseCard"];
		if($housecard > 13){
		  $housecardValue  = cardConversion($housecard);
		}else{
		  $housecardValue  = $housecard;
		}
		//$winamount1 = $tot["result"]["betNumber"][$housecard];
		
		foreach($tot["result"]["betNumber"] as $sIndex=>$single) {
		   if($housecardValue ==$sIndex) {
		   		$winamount = $winvalue * $single;
		   }else{
		        $winamount = '-';
		   }
			if(in_array($sIndex,$arrSingle)) {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$sIndex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$single.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	?>  

	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Symbol</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>    
    <?php
		for($a=0;$a<=count($tot["result"]["winOptionList"]);$a++) {
			$winoption = $tot["result"]["winOptionList"][$a]['winOptions'];
			if($winoption=="SPADE") {
				$winvalue = $tot["result"]["winOptionList"][$a]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$a]['winOptions'];
			}else if($winoption=="HEART") {
				$winvalue = $tot["result"]["winOptionList"][$a]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$a]['winOptions'];
			}else if($winoption=="DIAMOND") {
				$winvalue = $tot["result"]["winOptionList"][$a]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$a]['winOptions'];
			}else if($winoption=="CLUB") {
				$winvalue = $tot["result"]["winOptionList"][$a]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$a]['winOptions'];
			} 
		}
		
		foreach($tot["result"]["betNumber"] as $symbolIndex=>$symbol) {
			if(strtolower($winoptions)==$symbolIndex) {
				$winamount = $winvalue * $symbol;  
			}else {
				$winamount = '-';
			}
			
			if(in_array($symbolIndex,$arrSymbol)) {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$symbolIndex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$symbol.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	?>        

	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Even</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		for($a=0;$a<=count($tot["result"]["winOptionList"]);$a++) {
			$winoption = $tot["result"]["winOptionList"][$a]['winOptions'];
			if($winoption=="BLACK") {
				$winvalue = $tot["result"]["winOptionList"][$a]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$a]['winOptions'];
			}else if($winoption=="RED") {
				$winvalue = $tot["result"]["winOptionList"][$a]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$a]['winOptions'];
			}
			
		}
		foreach($tot["result"]["betNumber"] as $eIndex=>$even) {
			if(strtolower($winoptions)==$eIndex) {
				$winamount = $winvalue * $even;  
			}else {
				$winamount = '-';
			}
			if(in_array($eIndex,$arrEven)) {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$eIndex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$even.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
    
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Small Bet</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php 		
		for($k=0;$k<=count($tot["result"]["winOptionList"]);$k++) {
			$winoption = $tot["result"]["winOptionList"][$k]['winOptions'];
			if($winoption=="ATO6") {
				$winvalue = $tot["result"]["winOptionList"][$k]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$k]['winOptions'];
			}
		}
		 foreach($tot["result"]["betNumber"] as $sindex=>$svalue) {
		 	if(strtolower($winoptions)==strtolower($sindex)) {
			   $winamount = $svalue * $winvalue;
			 } else {
				 $winamount = '-';
			 }
			if($sindex=="Ato6") {
				//$winamount = $svalue * $winvalue;
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$sindex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$svalue.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	 
	?>    
 
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Big Bet</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		for($t=0;$t<=count($tot["result"]["winOptionList"]);$t++) {
			$winoption = $tot["result"]["winOptionList"][$t]['winOptions'];
			if($winoption=="ETOK") {
				$winvalue = $tot["result"]["winOptionList"][$t]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$t]['winOptions'];
			}
		}		
		foreach($tot["result"]["betNumber"] as $bindex=>$bvalue) {
			if(strtolower($winoptions)==strtolower($bindex)) {
			   $winamount = $bvalue * $winvalue;
			 } else {
				$winamount = '-'; 
			 }
			if($bindex=="EtoK") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">8toK</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$bvalue.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
 
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Perfect</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		for($k=0;$k<=count($tot["result"]["winOptionList"]);$k++) {
			$winoption = $tot["result"]["winOptionList"][$k]['winOptions'];
			if($winoption=="SEVEN") {
				$winvalue = $tot["result"]["winOptionList"][$t]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$t]['winOptions'];
			}
		}
		foreach($tot["result"]["betNumber"] as $pindex=>$pvalue) {
			if(strtolower($winoptions)==strtolower($bindex)) {
			   $winamount = $bvalue * $winvalue;
			 } else {
				$winamount = '-'; 
			 }			
			if($pindex=="seven") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$pindex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$pvalue.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	?>    
 
	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Andhar</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
	   $no_andhar = 0;
		for($k=0;$k<=count($tot["result"]["winOptionList"]);$k++) {
			$winoption = $tot["result"]["winOptionList"][$k]['winOptions'];
			
			if($winoption=="ANDAR") {
			
				$no_andhar = 1;
				$winvalue = $tot["result"]["winOptionList"][$k]['winFactor'];
				$winoptions = $tot["result"]["winOptionList"][$k]['winOptions'];
				
			}
		}
		
		
		foreach($tot["result"]["betNumber"] as $aindex=>$avalue) {			
			
			if($no_andhar == 1){
				if(strtolower($winoptions)==$aindex) {
					$winamount = $avalue * $winvalue;
				}
			}else{
			    $winamount = '-';
			}
			if($aindex=="andar") {
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$aindex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$avalue.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
	?>    

	<tr style="height:30px;">
    	<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bahar</strong></td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td><td width="20%" style="border:1px solid #ccc;">&nbsp;</td>        
    </tr>
    <?php
		$no_bahar = 0;
		for($q=0;$q<=count($tot["result"]["winOptionList"]);$q++) {
			$winoption = $tot["result"]["winOptionList"][$q]['winOptions'];
		
			if($winoption=="BAHAR") {
				
				$winvalue = $tot["result"]["winOptionList"][$q]['winFactor'];
				$winoptions1 = $tot["result"]["winOptionList"][$q]['winOptions'];
				$no_bahar = 1;
			}
		}
	
		foreach($tot["result"]["betNumber"] as $bindex=>$bvalue) {
			//echo strtolower($winoptions1); die
			if($no_bahar == 1){
			if(strtolower($winoptions1)==$bindex) {
				$winamount = $bvalue * $winvalue;
			}
			}else{
			  $winamount = '-';
			}
			//echo $winamount; die;
			if($bindex=="bahar") {
				//$winamount = $bvalue * $winvalue;
				echo '<tr style="height:30px;">';
					echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">'.$bindex.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$bvalue.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$winamount.'</td>';        
				echo '</tr>';				
			}
		}
		
		echo '<tr style="height:30px;">';
			echo '<td width="20%" style="border:1px solid #ccc;text-align:center;">&nbsp;</td><td width="20%" style="border:1px solid #ccc; text-align:center;">Total</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$results[0]->STAKE.'</td><td width="20%" style="border:1px solid #ccc;text-align:center;">'.$results[0]->WIN.'</td>';        
		echo '</tr>';	
	?>                           
</table>        
</div>
  </div>