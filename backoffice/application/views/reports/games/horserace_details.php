<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<script>
function tripleChanceTimerWindow(gameName,groupId){
var left = (screen.width/2)-(350/2);
var top = (screen.height/2)-(1100/2);
var targetWin = window.open("<?php echo base_url(); ?>games/shan/gamedetails/multiplayer/"+gameName+"/"+groupId+"", "title",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=640,height=700, top='+top+', left='+left);  
}
</script>
   <div class="Agent_Game_Det_wrap">
    <div class="Agent_game_Left" style="width:300px;">
      <div class="Agent_game_tit_wrap" style="width:260px;">
        <div class="Agent_game_name">Game Name</div>
        <div class="Agent_game_val" style="width:135px">: <?php echo ucfirst(strtolower($dispName));?></div>
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
              <td class="NTblHdrTxt">Play Group Id</td>
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
include_once("xmltoarray.php");
 
$results =$this->game_model->getHorseTimerDetails($handId, $gameName);


/* if($gamename=="horserace"){
	$query="select horserace_play.*,user.USERNAME from horserace_play, user where horserace_play.USER_ID = user.USER_ID AND GAME_ID='horserace' and INTERNAL_REFERENCE_NO='".$refno."'";
}elseif($gamename=="horseracetimer"){
	$query="select horserace_play.*,user.USERNAME from horserace_play, user where horserace_play.USER_ID = user.USER_ID AND GAME_ID='horseracetimer' and INTERNAL_REFERENCE_NO='".$refno."'";
}else{
	$query="select horserace_play.*,user.USERNAME from horserace_play, user where horserace_play.USER_ID = user.USER_ID AND GAME_ID='mobhorseracetimer' and INTERNAL_REFERENCE_NO='".$refno."'";
} */
//$results=mysql_query($query) or die("connection failed");
	 if(isset($_REQUEST['page']))
	{
	$i=$startpoint+1;
	}else{
	$i=1;
	} 
//while($row=mysql_fetch_array($results)){
//@extract($row);

	
	foreach($results as $row){
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
        <?php if($gameName=="horseracetimer"){ ?>
          <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <!--<td><a href="#" onclick="showHrtmplayer('<?php //echo $PLAY_GROUP_ID; ?>')"><?PHP //echo $PLAY_GROUP_ID; ?></a></td>-->
              <td> <?php echo $row->PLAY_GROUP_ID; ?> </td>
            </tr>
          </table></td>
          <?php }else{ ?>
          <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?php echo $row->PLAY_GROUP_ID; ?></td>
            </tr>
          </table></td>
          <?php } ?>          
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->STAKE; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $row->WIN+$row->JACKPOT_WIN; ?></td>
            </tr>
          </table></td>
          
      </tr>
<?php  $i++;
}  ?>
    </table>
<?php  $tot=json_decode($results[0]->PLAY_DATA, true); 
  $totalbets="";
  $single="";
  $ssingle="";
  $ddouble="";
  $ttriple="";
  $totalbets=$tot['horseRaceResult']['betNumbers'];
  $totalwin=$tot['horseRaceResult']['totalWinFactor'];
  $betnumber="";
  $wheel1id=$tot['horseRaceResult']['wheel']['wheel'][0]['id'];
  $wheel2id=$tot['horseRaceResult']['wheel']['wheel'][1]['id'];
  $wheel3id=$tot['horseRaceResult']['wheel']['wheel'][2]['id'];
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
  if($tot['horseRaceResult']['winPositions']){
      if(strstr($tot['horseRaceResult']['winPositions'],",")){
        $totwins=explode(",",$tot['horseRaceResult']['winPositions']);
        for($w=0;$w<count($totwins);$w++){
            $winbetpos=explode("-",$totwins[$w]);
            $arrcnt=count($winbetpos);
            $winpos[]="'".$winbetpos[0]."'";
            $akey=$arrcnt-1;
            $winmat[$winbetpos[0]]=$winbetpos[$akey];
        }    
      }else{
        $winbetpos=explode("-",$tot['horseRaceResult']['winPositions']);
        $arrcnt=count($winbetpos);
        $winpos[]="'".$winbetpos[0]."'";
        $akey=$arrcnt-1;
        $winmat[$winbetpos[0]]=$winbetpos[$akey];
      }
  }
	$win_amount= $tot['horseRaceResult']['wheel']['id'];
	$jackport = $tot['horseRaceResult']['jackpot'];   ?>
<div class="SeachResultWrap">
<div class="TCwrap">
<div class="TC_infoWrap">
<div class="TC_infoWinBet">
<div class="BetColor"></div>
<div class="infoTxt">User Bet</div>
</div>
<div class="TC_infoWinBet">
<div class="WinColor"></div>
<div class="infoTxt">Win Horse</div>
</div>
<?php //if($totalwin){ ?>
<div class="TC_infoWinBet">
    <div class="infoTxt">Win Horse:&nbsp;&nbsp;</div>
<div class="infoTxt"><?php if($win_amount==0)echo 10; else echo $win_amount;?></div>
</div>    
<?php //} ?>    
</div>
<div class="TC_Left_Wrap">
<div class="TC_doubleHdr" style="width:552px;">Play Positions</div>
<div class="TC_DoublesWrap" style="width:550px; height:140px;">


<?php 
ksort($totalbets); $isBetInTen=0;
foreach($totalbets as $hIndex=>$horseData) { 
	if($win_amount==$hIndex) {
		$winStyle="TC_Win_NumberWrap";
	} else {
		$winStyle="TC_NumberWrap";
	}
	if($hIndex==0) {
		$isBetInTen=1;			
	} else {
?>   
<div class="<?php echo $winStyle;?>" style="width:100px; height:60px">
<div class="TC_Number" style="font-size:16px; width:100px;"><?php echo "Horse- ".$hIndex; ?></div>
<div class="TC_Number" style="font-size:16px; width:100px; color:#000099">
<?php 

$path = base_url().'static/xml/horseDetails.xml';
$xmlNode = simplexml_load_file($path);
$arrayData = xmlToArray($xmlNode);  

echo $arrayData['horseDetails']['horse'][$hIndex-1]['name'];
?>
</div>
<div class="TC_BetAmount"style="width:95px;"><?php echo $horseData;?></div>
</div>
<?php 
	}
} 
if($isBetInTen==1) {
	if($win_amount==0) {
		$winStyle="TC_Win_NumberWrap";
	} else {
		$winStyle="TC_NumberWrap";
	}	
?>
<div class="<?php echo $winStyle;?>" style="width:100px; height:60px">
<div class="TC_Number" style="font-size:16px; width:100px;"><?php echo "Horse- 10"; ?></div>
<div class="TC_Number" style="font-size:16px; width:100px; color:#000099">
<?php 
$path = base_url().'static/xml/horseDetails.xml';
$xmlNode = simplexml_load_file($path);
$arrayData = xmlToArray($xmlNode);

echo $arrayData['horseDetails']['horse'][9]['name'];
?>
</div>
<div class="TC_BetAmount"style="width:95px;"><?php echo $tot['horseRaceResult']['betNumbers'][0];?></div>
</div>
<?php } ?>
</div>

</div>
</div>
</div>
  </div>
<?php  ?>

   
