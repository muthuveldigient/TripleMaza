<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
  <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php echo ucfirst(strtolower($gameName)); ?></div>
      </div>
    </div>
    <div class="Agent_game_Left" style="width:350px;">
      <div class="Agent_game_tit_wrap" style="width:290px;">
        <div class="Agent_game_name">Hand ID</div>
        <div class="Agent_game_val2" style="width:auto;">: <?php echo $handId;?></div>
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
<?PHP  $results = $this->game_model->getmobTripleChancePlayDetails($handId);  ?>
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
              <td><?PHP echo $results[0]->TOTAL_WIN; ?></td>
            </tr>
          </table></td>
          
      </tr>
    </table>
<?php  
	$tot=json_decode($results[0]->PLAY_DATA, true); 
    $totalbets="";
	$single="";
	$ssingle="";
	$ddouble="";
	$ttriple="";
	$totalbets=$tot['tripleChanceResult']['betNumbers'];
	$totalwin=$tot['tripleChanceResult']['totalWinFactor'];
	$betnumber="";
	$wheel1id=$tot['tripleChanceResult']['wheel']['wheel'][0]['id'];
	$wheel2id=$tot['tripleChanceResult']['wheel']['wheel'][1]['id'];
	$wheel3id=$tot['tripleChanceResult']['wheel']['wheel'][2]['id'];
	foreach($totalbets as $key=>$value){
		if(strlen($key)==1){
        	$single[$key]=$value;
	        $ssingle[]=$key;
    	}elseif(strlen($key)==2){
        	$double[$key]=$value;
          	$ddouble[]=$key;
      	}elseif(strlen($key)==3){
        	$triple[$key]=$value;
          	$ttriple[]=$key;
      	}
	}
	$winpos="";
	$winmat="";
	$winbetpos="";
    
	if($tot['tripleChanceResult']['winPositions']){
    	if(strstr($tot['tripleChanceResult']['winPositions'],",")){
        	$totwins=explode(",",$tot['tripleChanceResult']['winPositions']);
        	for($w=0;$w<count($totwins);$w++){
            	$winbetpos=explode("-",$totwins[$w]);
            	$arrcnt=count($winbetpos);
            	$winpos[]="'".$winbetpos[0]."'";
            	$akey=$arrcnt-1;
            	$winmat[$winbetpos[0]]=$winbetpos[$akey];
        	}    
      	}else{
        	$winbetpos=explode("-",$tot['tripleChanceResult']['winPositions']);
	        $arrcnt=count($winbetpos);
    	    $winpos[]="'".$winbetpos[0]."'";
        	$akey=$arrcnt-1;
	        $winmat[$winbetpos[0]]=$winbetpos[$akey];
    	}
	}
	$sw="0";
	$dw="0";
	$tw="0";
    if($winmat[$tot['tripleChanceResult']['wheel']['singleWheelNumber']]){
	    $sw= $winmat[$tot['tripleChanceResult']['wheel']['singleWheelNumber']];
    }
    if($winmat[$tot['tripleChanceResult']['wheel']['doubleWheelNumber']]){
	    $dw= $winmat[$tot['tripleChanceResult']['wheel']['doubleWheelNumber']];
    }
    if($winmat[$tot['tripleChanceResult']['wheel']['tripleWheelNumber']]){
	    $tw= $winmat[$tot['tripleChanceResult']['wheel']['tripleWheelNumber']];
    }  ?>
<div class="SeachResultWrap">
	<div class="TCwrap">
		<div class="TC_infoWrap">
			<div class="TC_infoWinBet">
				<div class="BetColor"></div>
				<div class="infoTxt">User Bet</div>
			</div>
			<div class="TC_infoWinBet">
				<div class="WinColor"></div>
				<div class="infoTxt">Win Ticket</div>
			</div>
			<?php if($totalwin){ ?>    
			<div class="TC_infoWinBet">
				<div class="infoTxt">Total Win:&nbsp;&nbsp;</div>
				<div class="infoTxt"><?php echo $totalwin;?></div>
			</div>
			<div class="TC_infoWinBet">
			    <div class="infoTxt">SW:&nbsp;&nbsp;</div>
				<div class="infoTxt"><?php echo $sw;?></div>
			</div>    
			<div class="TC_infoWinBet">
			    <div class="infoTxt">DW:&nbsp;&nbsp;</div>
				<div class="infoTxt"><?php echo $dw;?></div>
			</div>        
			<div class="TC_infoWinBet">
			    <div class="infoTxt">TW:&nbsp;&nbsp;</div>
				<div class="infoTxt"><?php echo $tw;?></div>
			</div>            
			<?php } ?>    
		</div>
	<div class="TC_Left_Wrap">
	<?php if($ssingle){
    	  sort($ssingle);    ?>    
		<div class="TC_doubleHdr">Singles</div>
	<div class="TC_DoublesWrap">
	<?php for($s=0;$s<count($ssingle);$s++){
    		$singelbet=explode("-",$single[$s]);
		    $sbetval="'".$ssingle[$s]."'";
		    $sbetamt=$single[$ssingle[$s]];    ?>    
		<div class="<?php if(in_array($sbetval,$winpos,true)){ echo "TC_Win_NumberWrap"; }else{ echo "TC_NumberWrap";}?>">
			<div class="TC_Number"><?php echo str_replace("'","",$sbetval);?></div>
			<div class="TC_BetAmount"><?php echo $sbetamt;?></div>
		</div>
	<?php } ?>
	</div>
	<?php }
	if($ddouble){
    	sort($ddouble);    ?>    
		<div class="TC_doubleHdr">Doubles</div>
	<div class="TC_DoublesWrap">
	<?php for($d=0;$d<count($ddouble);$d++){
		    $dbetval="'".$ddouble[$d]."'";
		    $dbetamt=$double[$ddouble[$d]];    ?>     
		<div class="<?php if(in_array($dbetval,$winpos,true)){ echo "TC_Win_NumberWrap"; }else{ echo "TC_NumberWrap";}?>">
			<div class="TC_Number"><?php echo str_replace("'","",$dbetval);?></div>
			<div class="TC_BetAmount"><?php echo $dbetamt;?></div>
        </div>
	<?php } ?>
	</div>
	<?php } 
		if($ttriple){
	    sort($ttriple);    ?>
		<div class="TC_doubleHdr">Triples</div>
		<div class="TC_DoublesWrap">
		<?php for($t=0;$t<count($ttriple);$t++){
			    $tbetval="'".$ttriple[$t]."'";
			    $tbetamt=$triple[$ttriple[$t]];    ?>         
			<div class="<?php if(in_array($tbetval,$winpos,true)){ echo "TC_Win_NumberWrap"; }else{ echo "TC_NumberWrap";}?>">
				<div class="TC_Number"><?php echo str_replace("'","",$tbetval);?></div>
				<div class="TC_BetAmount"><?php echo $tbetamt;?></div>
     	   	</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>

<!--<div class="TC_MidWrap">
	<div class="TC_Flash_Display">
    	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="502" height="400"  id="externalInterface">
        	<param name="allowScriptAccess" value="always"/>
            <param name="movie" value="triple_chance_wheel.swf"/>
            <param name="flashvars" value="wheel1id=<?php echo $wheel1id;?>&wheel2id=<?php echo $wheel2id;?>&wheel3id=<?php echo $wheel3id;?>" />
            <param name="quality" value="high" />
            <embed height="400" width="502" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" flashvars="wheel1id=<?php echo $wheel1id;?>&wheel2id=<?php echo $wheel2id;?>&wheel3id=<?php echo $wheel3id;?>" src="<?php echo base_url(); ?>/static/swf/triple_chance_wheel.swf"/> 	
    	</object>   
	</div>
</div>-->

</div>
</div>
</div>
   
