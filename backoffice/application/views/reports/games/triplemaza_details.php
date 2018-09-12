
<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<?php
 $info = $this->game_model->getTripleMazaSumDetails($handId,$gameId); 
?>
<div class="tableWrap">
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
	<div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">User Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php echo ucfirst(strtolower($info->USERNAME));?></div>
      </div>
    </div>
	<div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">TOTAL BET</div>
        <div class="Agent_game_val" style="width:135px">: <?= (!empty($info->TOTALBET)?$info->TOTALBET:'')?></div>
      </div>
    </div>
	<div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">TOTAL WIN</div>
        <div class="Agent_game_val" style="width:135px">: <?= (!empty($info->TOTALWIN)?$info->TOTALWIN:'')?></div>
      </div>
    </div>
  </div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tbody style="text-align: center;">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Game Name</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Ticket No</td>
			  </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Quantity</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Total Bet</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Total Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win No</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Date</td>
            </tr>
          </table></td>
                      
      </tr>
      <?PHP
	
	/* $results1 = $this->game_model->getWinBigBossGameDetails();  
	foreach($results1 as $row1){
		$gameList[$row1->GAMES_ID]['GAMES_NAME'] = $row1->GAMES_NAME;
		$gameList[$row1->GAMES_ID]['DESCRIPTION'] = $row1->DESCRIPTION;
	} */
	
	/** game list*/
	define("GAME_1", 'Dhanlaxmi');
	define("GAME_DESCRIPTION_1", 'Dhanlaxmi');
	define("GAME_2", 'Jay Durga');
	define("GAME_DESCRIPTION_2", 'Jay Durga');
	define("GAME_3", 'Himalaya');
	define("GAME_DESCRIPTION_3", 'Himalaya');

  $results = $this->game_model->getTripleMazaPlayDetails($handId, $gameId);
 $i=1;
foreach($results as $row){	 //echo '<prE>';print_r($row);exit;
//@extract($row);		

	if(!empty($row)){ 
		$betType = '';
		if(!empty($row->BET_TYPE) && $row->BET_TYPE==1 )
			$betType = 'Single';
		if(!empty($row->BET_TYPE) && $row->BET_TYPE==2 )
			$betType = 'Double';
		if(!empty($row->BET_TYPE) && $row->BET_TYPE==3 )
			$betType = 'Triple';

    $gameName = constant('GAME_DESCRIPTION_'.$row->GAME_TYPE_ID);
		//$gameName = ( isset($gameList[$row->GAME_TYPE_ID]) ? $gameList[$row->GAME_TYPE_ID]['GAMES_NAME'] :'' );
?>
      <tr>
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td class="text-center"><?= (!empty($betType)?$betType:'')?></td>
            </tr >
          </table></td>
        
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td style="width: 20em;max-height: 250px;overflow-y: auto;float: left;"><?= (isset($row->BET_NUMBER)?implode(", ",( explode(',',$row->BET_NUMBER))):'--')?></td>
            </tr>
          </table></td>
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td style="width: 20em;max-height: 250px;overflow-y: auto;float: left;"><?= (isset($row->BET_AMOUNT_VALUE)?implode(", ",( explode(',',$row->BET_AMOUNT_VALUE))):'--')?></td>
            </tr>
          </table></td>
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td class="text-right"><?= (!empty($row->TOTAL_BET)?$row->TOTAL_BET:'--')?></td>
            </tr>
          </table></td>
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td class="text-right"><?= (!empty($row->TOTAL_WIN)?$row->TOTAL_WIN:'--')?></td>
            </tr>
          </table></td>
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td class="text-center"><?= (!empty($row->WIN_NUMBER)?$row->WIN_NUMBER:'')?></td>
            </tr>
          </table></td>
        <td class=""><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td ><?= (!empty($row->CREATED_DATE)?date('d-m-Y H:i:s', strtotime($row->CREATED_DATE)):'--:--:--')?></td>
            </tr>
          </table></td>
	<?php }else{
		echo '<tr>
				<td colspan="9" align="center" class="SHdr2lineno">No Records Found</td>
			  </tr>';
} }?>
    </table>
  </div>
 
