<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />

<script>
function showrtplayer(rid)
{
var left = (screen.width/2)-(350/2);
var top = (screen.height/2)-(1100/2);
var targetWin = window.open("<?php echo base_url(); ?>reports/game/oddgroup/?groupid="+rid+"&gameid=OddnEven", "title",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=570,height=700, top='+top+', left='+left);        
}

function showluckynumplayer(rid)
{
var left = (screen.width/2)-(350/2);
var top = (screen.height/2)-(1100/2);
var targetWin = window.open("<?php echo base_url(); ?>reports/game/luckynumgroup/?groupid="+rid+"&gameid=LuckyNumber", "title",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=570,height=700, top='+top+', left='+left);        
}

function showluckplayer(rid)
{
var left = (screen.width/2)-(350/2);
var top = (screen.height/2)-(1100/2);
var targetWin = window.open("<?php echo base_url(); ?>reports/game/luckgroup/?groupid="+rid+"&gameid=Luck", "title",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=570,height=700, top='+top+', left='+left);        
}
</script>
<style>
    .header {
        display:none;
    }
    </style>


    
    
               <?
           $hand_id = $this->uri->segment(4,0);
           $rest = substr("$hand_id",0,3);

          if($rest == "AAA" || $rest == "AAB"){ ?>
      <div class="tableListWrap">
          
        <table width="100%" class="ContentHdr">
          <tr>
              <td>Game Name: <strong><?echo ucfirst($results[0]->GAME_ID); ?></strong></td>
              <td>Hand Id: <strong><?echo ucfirst($results[0]->INTERNAL_REFERENCE_NO); ?></strong></td>
          </tr>
        </table>
          
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Username</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Room Name</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Game Count</td>
            </tr>
          </table></td>

        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Play Position</td>
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
              <td class="NTblHdrTxt">House Collect</td>
            </tr>
          </table></td>          
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">House Loss</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Card Drawn</td>
            </tr>
          </table></td> 
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Play Group Id</td>
            </tr>
          </table></td>          
        <td class="NTblHdrWrap"><table width="100%" align="center" class="Hdr1line">
            <tr>
              <td class="NTblHdrTxt">Start Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">End Date</td>
            </tr>
          </table></td>          
        
      </tr>
      
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
                <? $username =  $this->Account_model->getUserNameById($results[0]->USER_ID); ?>
              <td class=""><?PHP echo ucfirst($username); ?></td>
            </tr>
          </table></td>
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->ROOM_NAME; ?></td>
            </tr>
          </table></td>          
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->GAME_COUNT; ?></td>
            </tr>
          </table></td> 

      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->PLAYER_POSITION; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->STAKE; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->WIN; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->HOUSE_COLLECT; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->HOUSE_LOSE; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class="">
              <?PHP  
              $play = json_decode($results[0]->PLAY_DATA);
              if($rest == "AAA"){
                  $game = $play->oddnEvenResult->card->value;
              }else{
                  $game = $play->luckyNumberResult->card->value;
              }
              if($game == -1){
                  echo "*";
              }elseif($game == -2){
                  echo "**";
              }elseif($game == -3){
                  echo "***";
              }else{
                  echo $game;   
              }?></td>
            </tr>
          </table></td>
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>               
                <?php if($rest == "AAA"){?>
                <td class=""><a href="#" onclick="showrtplayer('<?php echo $results[0]->PLAY_GROUP_ID; ?>')"><?PHP echo $results[0]->PLAY_GROUP_ID; ?></a></td>
                <?php }elseif($rest == "AAB"){ ?>
                <td class=""><a href="#" onclick="showluckynumplayer('<?php echo $results[0]->PLAY_GROUP_ID; ?>')"><?PHP echo $results[0]->PLAY_GROUP_ID; ?></a></td>
                <?php }?>
            </tr>
          </table></td>           
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo date('d/m/Y H:i:s',strtotime($results[0]->STARTED)); ?></td>
            </tr>
          </table></td>
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo date('d/m/Y H:i:s',strtotime($results[0]->ENDED)); ?></td>
            </tr>
          </table></td>          
    </table>
<?if($rest == AAA){ ?>
          <div id="Oddneven_Wrap">
             <? 
           $result1 = json_decode($results[0]->PLAY_DATA);
           $betPlayedOption = count($result1->oddnEvenResult->betPlayedOption);
           $winOption = count($result1->oddnEvenResult->winOption);
           
           
             for($p=0;$p<$betPlayedOption;$p++){
                 
           $bettype = $result1->oddnEvenResult->betPlayedOption[$p]->betType;
           $betamount = $result1->oddnEvenResult->betPlayedOption[$p]->betAmount;
           $betnumber = $result1->oddnEvenResult->betPlayedOption[$p]->betNumber;                 
                 if($bettype == "ODD"){
                    echo '<div class="spotodd">'.$betamount.'</div>';    
                 }
                 if($bettype == "EVEN"){
                    echo '<div class="spoteven">'.$betamount.'</div>';    
                 }
                 if($bettype == "LUCKY"){
                    echo '<div class="spotlucky">'.$betamount.'</div>';    
                 }
                 if($bettype == "LOWNUMBER"){
                     echo '<div class="spot'.$betnumber.'">'.$betamount.'</div>';
                 }
             }
             
             
             for($w=0;$w<$winOption;$w++){
                 if($result1->oddnEvenResult->winOption->EVEN){
                     echo '<div class="spotweven">'."win".'</div>';
                 }
                 if($result1->oddnEvenResult->winOption->ODD){
                     echo '<div class="spotwodd">'."win".'</div>';
                 }
                 if($result1->oddnEvenResult->winOption->LUCKY){
                     echo '<div class="spotwlucky">'."win".'</div>';
                 }
                 if($result1->oddnEvenResult->winOption->LOWNUMBER){
                     $r = $result1->oddnEvenResult->card->lowNumber;
                     echo '<div class="spotw'.$r.'">'."win".'</div>';
                 }
               
             }
             
             if($results[0]->PLAYER_POSITION!="" || $results[0]->PLAYER_POSITION=="0"){
                 $playpos = $results[0]->PLAYER_POSITION;
                 echo '<div class="spotseat'.$playpos.'">'."sit".'</div>';
             }
             
             $cardvalue = $result1->oddnEvenResult->card->value;
             if($cardvalue == -1){
                   echo '<div class="spotcard">*</div>';
              }elseif($cardvalue == -2){
                  echo '<div class="spotcard">**</div>';
              }elseif($cardvalue == -3){
                  echo '<div class="spotcard">***</div>';
              }else{
                  echo '<div class="spotcard">'.$cardvalue.'</div>';  
              }
             
             
             ?>

            
          </div>
          <? }elseif($rest == "AAB"){ ?>
          <div id="LuckyNumber_Wrap">
                  <? 
               $result1 = json_decode($results[0]->PLAY_DATA);
               $betPlayedOption = count($result1->luckyNumberResult->betPlayedOption);
               $winOption = count($result1->luckyNumberResult->winOption);

                for($p=0;$p<$betPlayedOption;$p++){
                 
                $bettype = $result1->luckyNumberResult->betPlayedOption[$p]->betType;
                $betamount = $result1->luckyNumberResult->betPlayedOption[$p]->betAmtPerOption;
                $betnumber = $result1->luckyNumberResult->betPlayedOption[$p]->playedOption;  
                $bnum = $this->report_model->getCardNumbers($betnumber);
                //echo $bnum;
                 if($bettype == "STRAIGHT_BET"){
                    echo '<div class="straight_bet_'.$bnum.'">'.$betamount.'</div>';    
                 }
                 if($bettype == "SPLIT_BET"){
                    echo '<div class="straight_bet_'.$bnum.'">'.$betamount.'</div>';    
                 }
                 if($bettype == "CORNER_BET"){
                    echo '<div class="straight_bet_'.$bnum.'">'.$betamount.'</div>';    
                 }
                 if($bettype == "RBFL_BET"){
                    echo '<div class="rbfl_'.$bnum.'_bet">'.$betamount.'</div>';    
                 }
                 if($bettype == "DECADES_BET"){
                    echo '<div class="decades_bet_'.$bnum.'">'.$betamount.'</div>';    
                 }
                 if($bettype == "LUCKY_BET"){
                     echo '<div class="lucky_bet_'.$bnum.'">'.$betamount.'</div>';
                 }
                 if($bettype == "ANY_LUCKY_BET"){
                     echo '<div class="lucky_bet_123">'.$betamount.'</div>';
                 }
             }

               $winListCount = "";
               
               if(!empty($result1->luckyNumberResult->winOptionList)) {
                   $winListArray = array();
                   $keyIndex="0";
                   foreach($result1->luckyNumberResult->winOptionList as $winList) {
                       $winListArray[$keyIndex]["winFactor"] = $winList->winFactor;
                       $winListArray[$keyIndex]["winOptions"] = $winList->winOptions;
                       $keyIndex++;
                   }
               }

               $win = count($winListArray);

               for($w=0;$w<$win;$w++){
                   $wintype = $winListArray[$w][winOptions];
                   $file = explode("[",$wintype);
                   $bettype=$file[0];
                   $wnum = $this->report_model->getCardNumbers($winListArray[$w][winOptions]);

                 if($bettype == "STRAIGHT_BET"){
                    echo '<div class="straight_w_'.$wnum.'">W</div>';    
                 }
                 if($bettype == "SPLIT_BET"){
                    echo '<div class="straight_w_'.$wnum.'">W</div>';    
                 }
                 if($bettype == "CORNER_BET"){
                    echo '<div class="straight_w_'.$wnum.'">W</div>';    
                 }
                 if($bettype == "RBFL_BET"){
                    echo '<div class="rbfl_w'.$wnum.'_bet">W</div>';    
                 }
                 if($bettype == "DECADES_BET"){
                    echo '<div class="decades_w_'.$wnum.'">W</div>';    
                 }
                 if($bettype == "LUCKY_BET"){
                     echo '<div class="lucky_w_'.$wnum.'">W</div>';
                 }
                 if($bettype == "ANY_LUCKY_BET"){
                     echo '<div class="lucky_w_123">W</div>';
                 }                 
                   
               }
               
               if($results[0]->PLAYER_POSITION!="" || $results[0]->PLAYER_POSITION=="0"){
                 $playpos = $results[0]->PLAYER_POSITION;
                 echo '<div class="seat'.$playpos.'">'."sit".'</div>';
               }
               
               $cardvalue = $result1->luckyNumberResult->card->value;
               if($cardvalue == -1){
                    echo '<div class="luckcard">*</div>';
               }elseif($cardvalue == -2){
                    echo '<div class="luckcard">**</div>';
               }elseif($cardvalue == -3){
                    echo '<div class="luckcard">***</div>';
               }else{
                    echo '<div class="luckcard">'.$cardvalue.'</div>';  
               }
           
               ?>
              </div>
          <? } ?>
      </div>
    <? }elseif($rest == "AAC"){ ?>
    
          <div class="tableListWrap">
          
        <table width="100%" class="ContentHdr">
          <tr>
              <td>Game Name: <strong><?echo ucfirst($results[0]->GAME_ID); ?></strong></td>
              <td>Hand Id: <strong><?echo ucfirst($results[0]->INTERNAL_REFERENCE_NO); ?></strong></td>
          </tr>
        </table>
              
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Username</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Room Name</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Game Count</td>
            </tr>
          </table></td>

        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Play Position</td>
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
              <td class="NTblHdrTxt">Play Group Id</td>
            </tr>
          </table></td>          
        <td class="NTblHdrWrap"><table width="100%" align="center" class="Hdr1line">
            <tr>
              <td class="NTblHdrTxt">Start Date</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">End Date</td>
            </tr>
          </table></td>          
        
      </tr>
      
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
                <? $username =  $this->Account_model->getUserNameById($results[0]->USER_ID); ?>
              <td class=""><?PHP echo ucfirst($username); ?></td>
            </tr>
          </table></td>
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->ROOM_NAME; ?></td>
            </tr>
          </table></td>          
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->GAME_COUNT; ?></td>
            </tr>
          </table></td> 

      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->PLAYER_POSITION; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->STAKE; ?></td>
            </tr>
          </table></td> 
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo $results[0]->WIN; ?></td>
            </tr>
          </table></td> 

      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><a href="#" onclick="showluckplayer('<?php echo $results[0]->PLAY_GROUP_ID; ?>')"><?PHP echo $results[0]->PLAY_GROUP_ID; ?></a></td>
            </tr>
          </table></td>           
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo date('d/m/Y H:i:s',strtotime($results[0]->STARTED)); ?></td>
            </tr>
          </table></td>
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>                
              <td class=""><?PHP echo date('d/m/Y H:i:s',strtotime($results[0]->ENDED)); ?></td>
            </tr>
          </table></td>          
    </table>              
              
              
 <? 
$data = json_decode($results[0]->PLAY_DATA); ?>
             <div id="gameData" style="padding: 10px;">
<?if(($data->luckResult->dealer) == 1){
    echo "<br/>"."<b>DEALER : <font color='red'> YES </font></b>"."<br/>";
}else{
    echo "<br/>"."<b>DEALER :</b> NO"."<br/>";
} ?>
<b>Hand Cards :</b>
<? echo "<br/>"; ?>
<table cellpadding="2" cellspacing="2" >
       <tr>
          <td><table>
             <tr>
             <?$handcard = count($data->luckResult->handCard);
             for($i=0; $i<$handcard; $i++){ 
              $c = $data->luckResult->handCard[$i]->value;
              echo '<img src="'.base_url().'static/images/cards/CardsIcons_00'.$c.'.png"/>';
             } ?>
             </tr>
          </table></td>
       </tr>
</table>

<B>Open Card :</B>
<? echo "<br/>"; ?>
<table cellpadding="2" cellspacing="2" >
       <tr>
          <td><table>
            <tr>
            <? $opencard = $data->luckResult->openCard->value;
               echo '<img src="'.base_url().'static/images/cards/CardsIcons_00'.$opencard.'.png"/>'; ?>          
            </tr>
          </table></td>
       </tr>
</table>

<table cellpadding="2" cellspacing="2" >
  
    <?   $rounds = count($data->luckResult->rounds);
         for($r=0;$r<$rounds;$r++){
             $act = count($data->luckResult->rounds[$r]->discardAction); ?>
    <tr>
    
    <?php 
             for($a=0;$a<$act;$a++){ ?>
      <td>
            <B><?echo '<font color="green">'.$data->luckResult->rounds[$r]->discardAction[$a].'</font>'."<br/><br/>"; ?></B>
            <? $discardcards = $data->luckResult->rounds[$r]->discardCards[$a]->value;
            
             echo '<img src="'.base_url().'static/images/cards/CardsIcons_00'.$discardcards.'.png"/>';       
                // echo "<br/>"; ?>
            </td>
            <?php
           }
        ?>
             
            <td style="border: 1px solid;">
                <table><tr><td ><b style="position: relative; top: 10px; left: 10px;">Round Cards:</b> </td></tr><tr>
                       
          <?php    $hand = count($data->luckResult->rounds[$r]->handCards); ?>
            
             <td style="padding-top:25px;">
            <?php for($j=0;$j<$hand;$j++){ ?>
                &nbsp;
                <?php 
                 $n = $data->luckResult->rounds[$r]->handCards[$j]->value;
                 echo '<img src="'.base_url().'static/images/cards/CardsIcons_00'.$n.'.png"/>';  ?>
                
                 <?php 
             }?>
                </td>
                </tr>
                </table>
                </td>
        <?php  }  
?>    
  </tr>
</table>
</div>
</div>          
  <?  } ?>
