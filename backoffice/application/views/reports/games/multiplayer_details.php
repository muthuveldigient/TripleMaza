<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<?php  
$miniGameName = $this->uri->segment(5);
$playGroupId  = $this->uri->segment(6);

$playTableName = $this->game_model->getGameTableName($miniGameName);
$stakeDetails  = $this->game_model->getSumOfStakePlayGroupId($miniGameName,$playTableName,$playGroupId);  ?>
<div class="SeachResultWrap">
<div class="Agent_Game_Det_wrap">
<div class="Agent_game_Left">
<div class="Agent_game_tit_wrap">
<div class="Agent_game_name">Total Stake</div>
<div class="Agent_game_val">: <?php echo $stakeDetails[0]->totbets;  ?></div>
</div>
</div>
<div class="Agent_game_Left">
<div class="Agent_game_tit_wrap">
<div class="Agent_game_name">Start Date</div>
<div class="Agent_game_val2">: <?php echo $stakeDetails[0]->STARTED;  ?></div>
</div>
</div>
<div class="Agent_game_Left">
<div class="Agent_game_tit_wrap">
<div class="Agent_game_name">End Date</div>
<div class="Agent_game_val2">: <?php echo $stakeDetails[0]->ENDED;  ?></div>
</div>
</div>    
</div>
    
<div class="tableWrap">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
 <tr>
  <td class="NTblHdrTxt">Sno</td>
</tr>
</table>
</td>    
<td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
 <tr>
  <td class="NTblHdrTxt">Username</td>
</tr>
</table>
</td>
  <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
  <tr>
  <td class="NTblHdrTxt">Hand ID</td>
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
<td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
<tr>
<td class="NTblHdrTxt">Game result</td>
</tr>
</table></td>
</tr>

<?PHP
$results = $this->game_model->getMultiPlayerDetails($miniGameName,$playTableName,$playGroupId);
$i=1;
foreach($results as $res){ ?>
  <tr>
<td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>">
  <table width="100%" align="center" class="NSTblHdrTxt">
  <tr>
  <td class=""><?PHP echo $i; ?></td>
</tr>
</table>
</td>   
   
<td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>">
  <table width="100%" align="center" class="SHdr1line">
  <tr>
  <td class=""><?PHP echo $res->USERNAME; ?></td>
</tr>
</table>
</td>
  <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>">
  <table width="300" align="center" class="NSTblHdrTxt">
  <tr>
  <td><?PHP 
  if($miniGameName=='bingotime' || $miniGameName=='triplechancetimer' || $miniGameName=='singlewheeltimer'){
  echo $res->INTERNAL_REFERENCE_NO;
  }else{
  echo $res->INTERNAL_REFFERENCE_NO;    
  }
?></td>
</tr>
</table>
</td>
   

 <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>">
  <table width="100%" align="center" class="NSTblHdrTxt">
  <tr>
  <td><?PHP echo $res->STAKE; ?></td>
</tr>
</table>
</td> 
  
 
  <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>">
  <table width="100%" align="center" class="NSTblHdrTxt">
  <tr>
  <td><?PHP echo $res->WIN; ?></td>
</tr>
</table>
</td>
<td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>">
  <table width="100%" align="center" class="NSTblHdrTxt">
  <tr>
  <td><?PHP  
  if($gameid=='bingotime'){
      $txt = explode(",",$res->ROOM_NAME); if($txt[1] == 1) echo "Game Ended"; else echo "In Progress";
  }else{
      if($res->ENDED){
          echo "Game Ended";
      }else{
          echo "In Progress";
      }    
  }
?></td>
</tr>
</table>
</td>
</tr> 

<?php 
$i++;
}
?>
</table>
</div>                                                                        
</div>
