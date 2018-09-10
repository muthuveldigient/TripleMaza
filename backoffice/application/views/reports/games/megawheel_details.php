<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php if(!empty($dispName)){ echo ucfirst(strtolower($dispName)); }else{ echo ucfirst(strtolower($gameName)); }  ?></div>
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
              <td class="NTblHdrTxt">Stake</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win</td>
            </tr>
          </table></td>
      </tr>
      <?PHP
	  $results = $this->game_model->getMegaWheelPlayDetails($gameName,$handId); 
	//echo '<pre>';print_r('sds');exit;
	$i=1;
	foreach($results as $row) {	
		$tot2=json_decode($row->PLAY_DATA, true);  
		$mBetString=explode(",",$tot2["betString"]);
		$userBetIndex=array();
		foreach($mBetString as $betString) {
			$expBetString=explode("-",$betString);
			$userBetIndex[$expBetString[0]]=$expBetString[1];
		}
		$winSymbol =$tot2["winSymbol"];
		$mWinAmount=$row->WIN;
?>
      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $row->USERNAME; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->INTERNAL_REFERENCE_NO; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->STARTED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->ENDED; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->STAKE; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->WIN; ?></td>
            </tr>
          </table></td>
      </tr>
      <?php 
	$i++;
	}
	?>
    </table>
	<?php
	/*
	echo $tot2["betString"]."<br>";
	echo "<pre>";
	print_r($userBetIndex);
	echo "<br>";
	*/
	$mBetPositions=array("1","2","5","10","20","50K","50J");
	?>
	<table width="60%" cellpadding="0" cellspacing="0" style="margin-top:5px;">
		<tr style="height:30px;background-color:#ccc;">
			<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Position</strong></td>
			<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Bet</strong></td>
			<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong>Win</strong></td>
		</tr>
		<?php
			foreach($mBetPositions as $mIndex=>$mPosition) {
		?>
		<tr style="height:30px;">
			<td width="20%" style="border:1px solid #ccc;text-align:center;"><strong><?php echo $mPosition;?></strong></td>
			<td width="20%" style="border:1px solid #ccc;text-align:center">
			<?php
				if(array_key_exists($mPosition,$userBetIndex)) {
					echo $userBetIndex[$mPosition];
				} else {
					echo "&nbsp;";
				}
			?>
			</td>
			<td width="20%" style="border:1px solid #ccc;text-align:center">
			<?php
				if($mPosition==$winSymbol) echo $mWinAmount; else echo "&nbsp;";
			?>
			</td>        
		</tr>
		<?php } ?>
	</table>	
  </div>