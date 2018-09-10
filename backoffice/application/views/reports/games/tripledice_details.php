
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
	 $results = $this->game_model->getTripleDicePlayDetails($handId,$gameName);  
	
	 
 $i=1;
foreach($results as $row){	 //echo '<prE>';print_r($row);exit;
//@extract($row);		

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
        <!--<td class="<?PHP if ($i%2=="0"){ ?>NSTb2HdrWrap <?PHP }else{ ?> NSTblHdrWrap <?PHP } ?>"><?PHP
  $tot=json_decode($row->PLAY_DATA, true);   
//  echo "<pre>";
//  print_r($tot);
//  echo "</pre>";
  $playedLinescnt=count($tot['playResult']['betPlayedOptions']);
  if($playedLinescnt!=0)
  {
	
	  
?>
          <?php /*?><a href="#TB_inline?height=500&width=720&inlineId=myOnPageContent<?php echo $INTERNAL_REFFERENCE_NO; ?>" title="Played Options" class="thickbox">
<?php echo "View Played Lines"; ?></a><?php */?>
       
          <?PHP
  
	} 
	else
	{
	//echo "Game Crashed.Money Refunded.";
	}
?></td>-->
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
  </div>
  <?php 
$i=1;
foreach($results as $row){	  
  
  $tot=json_decode($row->PLAY_DATA, true);  
$dice1=$tot['playResult']['diceOne'];
$dice2=$tot['playResult']['diceTwo'];
$dice3=$tot['playResult']['diceThree'];
$dicetotal=$tot['playResult']['diceTotal'];
$totalbet=$row->STAKE; 
$totalwin=$row->WIN;
 
$totcount=count($tot['playResult']['betPlayedOptions']);
$totwinoption=count($tot['playResult']['winOption']);

for($i=0;$i<$totcount;$i++){
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="EVEN"){
    $evenbet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="ODD"){
    $oddbet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="MIX"){
    $mixbet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="LO"){
    $lobet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="MID"){
    $midbet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="HI"){
    $hibet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="K1"){
    $k1bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="K2"){
    $k2bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="K3"){
    $k3bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="K4"){
    $k4bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="K5"){
    $k5bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="K6"){
    $k6bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T4"){
    $t4bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T5"){
    $t5bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T6"){
    $t6bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T7"){
    $t7bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T8"){
    $t8bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T9"){
    $t9bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T10"){
    $t10bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T11"){
    $t11bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T12"){
    $t12bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T13"){
    $t13bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T14"){
    $t14bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T15"){
    $t15bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T16"){
    $t16bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    if($tot['playResult']['betPlayedOptions'][$i]['betType']=="T17"){
    $t17bet=$tot['playResult']['betPlayedOptions'][$i]['betAmount'];
    }
    
}
for($j=0;$j<$totwinoption;$j++){
    if($tot['playResult']['winOption'][$j]['winOptions']=="EVEN"){
    $evenwin=$tot['playResult']['winOption'][$j]['winFactor']*$evenbet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="ODD"){
    $oddwin=$tot['playResult']['winOption'][$j]['winFactor']*$oddbet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="MIX"){
    $mixwin=$tot['playResult']['winOption'][$j]['winFactor']*$mixbet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="LO"){
    $lowin=$tot['playResult']['winOption'][$j]['winFactor']*$lobet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="MID"){
    $midwin=$tot['playResult']['winOption'][$j]['winFactor']*$midbet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="HI"){
    $hiwin=$tot['playResult']['winOption'][$j]['winFactor']*$hibet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="K1"){
    $k1win=$tot['playResult']['winOption'][$j]['winFactor']*$k1bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="K2"){
    $k2win=$tot['playResult']['winOption'][$j]['winFactor']*$k2bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="K3"){
    $k3win=$tot['playResult']['winOption'][$j]['winFactor']*$k3bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="K4"){
    $k4win=$tot['playResult']['winOption'][$j]['winFactor']*$k4bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="K5"){
    $k5win=$tot['playResult']['winOption'][$j]['winFactor']*$k5bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="K6"){
    $k6win=$tot['playResult']['winOption'][$j]['winFactor']*$k6bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T4"){
    $t4win=$tot['playResult']['winOption'][$j]['winFactor']*$t4bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T5"){
    $t5win=$tot['playResult']['winOption'][$j]['winFactor']*$t5bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T6"){
    $t6win=$tot['playResult']['winOption'][$j]['winFactor']*t6bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T7"){
    $t7win=$tot['playResult']['winOption'][$j]['winFactor']*$t7bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T8"){
    $t8win=$tot['playResult']['winOption'][$j]['winFactor']*$t8bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T9"){
    $t9win=$tot['playResult']['winOption'][$j]['winFactor']*$t9bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T10"){
    $t10win=$tot['playResult']['winOption'][$j]['winFactor']*$t10bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T11"){
    $t11win=$tot['playResult']['winOption'][$j]['winFactor']*$t11bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T12"){
    $t12win=$tot['playResult']['winOption'][$j]['winFactor']*$t12bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T13"){
    $t13win=$tot['playResult']['winOption'][$j]['winFactor']*$t13bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T14"){
    $t14win=$tot['playResult']['winOption'][$j]['winFactor']*$t14bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T15"){
    $t15win=$tot['playResult']['winOption'][$j]['winFactor']*$t15bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T16"){
    $t16win=$tot['playResult']['winOption'][$j]['winFactor']*$t16bet;
    }
    if($tot['playResult']['winOption'][$j]['winOptions']=="T17"){
    $t17win=$tot['playResult']['winOption'][$j]['winFactor']*$t17bet;
    }
}
switch($dice1)
{
    case 1:
    $diceimg1='dice-01.png';
    break;
    case 2:
    $diceimg1='dice-02.png';
    break;
    case 3:
    $diceimg1='dice-03.png';
    break;
    case 4:
    $diceimg1='dice-04.png';
    break;
    case 5:
    $diceimg1='dice-05.png';
    break;
    case 6:
    $diceimg1='dice-06.png';
    break;

}

switch($dice2)
{
    case 1:
    $diceimg2='dice-01.png';
    break;
    case 2:
    $diceimg2='dice-02.png';
    break;
    case 3:
    $diceimg2='dice-03.png';
    break;
    case 4:
    $diceimg2='dice-04.png';
    break;
    case 5:
    $diceimg2='dice-05.png';
    break;
    case 6:
    $diceimg2='dice-06.png';
    break;

}

switch($dice3)
{
    case 1:
    $diceimg3='dice-01.png';
    break;
    case 2:
    $diceimg3='dice-02.png';
    break;
    case 3:
    $diceimg3='dice-03.png';
    break;
    case 4:
    $diceimg3='dice-04.png';
    break;
    case 5:
    $diceimg3='dice-05.png';
    break;
    case 6:
    $diceimg3='dice-06.png';
    break;

}

?>    
    
<div class="TriDWrap">
<div class="TriDResWrap">
<div class="TriDResHdr">Result</div>
<div class="TriDDicePos">
<div class="TriDDiceimg">
  <?php
  if($diceimg1){
  ?>    
  <img src="<?php echo base_url();?>/images/<?php echo $diceimg1;?>" width="50" height="50" />
  <?php
  }
  ?>
 </div>
<div class="TriDDiceimg">
  <?php
  if($diceimg2){
  ?>    
  <img src="<?php echo base_url();?>/images/<?php echo $diceimg2;?>" width="50" height="50" />
  <?php
  }
  ?>
 </div>
<div class="TriDDiceimg">
  <?php
  if($diceimg3){
  ?>    
  <img src="<?php echo base_url();?>/images/<?php echo $diceimg3;?>" width="50" height="50" />
  <?php
  }
  ?>
 </div>    
<div class="TriDDiceVal"><?php echo $dicetotal;?></div></div></div>
<div class="TriDResTableWrap">
<div class="TriDTblResHdr">
<div class="TriDHdrPlay">PLAY</div>
<div class="TriDHdrWin">WIN</div></div>
<?php if($evenbet!='' || $oddbet!='' || $mixbet!=''){ ?>
        <div class="TriDSTblResHdr">
        <div class="TriDSHdrPlay">
        <?php if($evenbet){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">EVEN</div>
        <div class="TriDvalSHdr"><?php echo $evenbet;?></div></div>
        <?php } ?>
        <?php if($oddbet){ ?>    
        <div class="TriDValWrap">
        <div class="TriDvalHdr">ODD</div>
        <div class="TriDvalSHdr"><?php echo $oddbet;?></div></div>
        <?php } ?>
        <?php if($mixbet){ ?>        
        <div class="TriDValWrap">
        <div class="TriDvalHdr">MIX</div>
        <div class="TriDvalSHdr"><?php echo $mixbet;?></div></div>
        <?php } ?>
        </div>
        <div class="TriDSHdrWin">
        <?php if($evenwin){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">EVEN</div>
        <div class="TriDvalSHdr"><?php echo $evenwin;?></div></div>
        <?php } ?>
        <?php if($oddwin){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">ODD</div>
        <div class="TriDvalSHdr"><?php echo $oddwin;?></div></div>
        <?php } ?>
        <?php if($mixwin){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">MIX</div>
        <div class="TriDvalSHdr"><?php echo $mixwin;?></div></div>
        <?php } ?>    
        </div></div>
<?php } ?>    
<?php if($lobet!='' || $midbet!='' || $hibet!=''){ ?>
<div class="TriDSTblResHdr">
<div class="TriDSHdrPlay">
<?php if($lobet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">LO</div>
<div class="TriDvalSHdr"><?php echo $lobet;?></div></div>
<?php } ?>
<?php if($midbet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">MID</div>
<div class="TriDvalSHdr"><?php echo $midbet; ?></div></div>
<?php } ?>
<?php if($hibet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">HI</div>
<div class="TriDvalSHdr"><?php echo $hibet; ?></div></div>
<?php } ?>
</div>
<div class="TriDSHdrWin">
<?php if($lowin){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">LO</div>
<div class="TriDvalSHdr"><?php echo $lowin;?></div></div>
<?php } ?>
<?php if($midwin){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">MID</div>
<div class="TriDvalSHdr"><?php echo $midwin;?></div></div>
<?php } ?>    
<?php if($hiwin){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">HI</div>
<div class="TriDvalSHdr"><?php echo $hiwin;?></div></div>
<?php } ?>    
</div></div>
<?php } ?>    
<?php if($k1bet!='' || $k2bet!='' || $k3bet!='' || $k4bet!='' || $k5bet!='' || $k6bet!=''){ ?>    
<div class="TriDSTblResHdr">
<div class="TriDSHdrPlay">
<?php if($k1bet){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K1</div>
<div class="TriDvalSHdr"><?php echo $k1bet;?></div></div>
<?php }?>
<?php if($k2bet){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K2</div>
<div class="TriDvalSHdr"><?php echo $k2bet;?></div></div>
<?php }?>
<?php if($k3bet){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K3</div>
<div class="TriDvalSHdr"><?php echo $k3bet;?></div></div>
<?php }?>
<?php if($k4bet){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K4</div>
<div class="TriDvalSHdr"><?php echo $k4bet;?></div></div>
<?php }?>
<?php if($k5bet){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K5</div>
<div class="TriDvalSHdr"><?php echo $k5bet;?></div></div>
<?php }?>
<?php if($k6bet){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K6</div>
<div class="TriDvalSHdr"><?php echo $k6bet;?></div></div>
<?php }?>
    
</div>
<div class="TriDSHdrWin">
<?php if($k1win){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K1</div>
<div class="TriDvalSHdr"><?php echo $k1win;?> </div></div>
<?php } ?>
<?php if($k2win){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K2</div>
<div class="TriDvalSHdr"><?php echo $k2win;?> </div></div>
<?php } ?>
<?php if($k3win){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K3</div>
<div class="TriDvalSHdr"><?php echo $k3win;?> </div></div>
<?php } ?>
<?php if($k4win){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K4</div>
<div class="TriDvalSHdr"><?php echo $k4win;?> </div></div>
<?php } ?>
<?php if($k5win){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K5</div>
<div class="TriDvalSHdr"><?php echo $k5win;?> </div></div>
<?php } ?>
<?php if($k6win){ ?>    
<div class="TriDValWrap">
<div class="TriDvalHdr">K6</div>
<div class="TriDvalSHdr"><?php echo $k6win;?> </div></div>
<?php } ?>
  
</div></div>
<?php } ?>    
<?php if($t4bet!='' || $t5bet!='' || $t6bet!='' || $t7bet!='' || $t8bet!='' || $t9bet!='' || $t10bet!='' || $t11bet!='' || $t12bet!='' || $t13bet!='' || $t14bet!='' || $t15bet!='' || $t16bet!='' || $t17bet!=''){ ?>      
<div class="TriDSTblResHdr">
<div class="TriDSHdrPlayFill">
<?php if($t4bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T4</div>
<div class="TriDvalSHdr"><?php echo $t4bet;?></div></div>
<?php } ?>
<?php if($t5bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T5</div>
<div class="TriDvalSHdr"><?php echo $t5bet;?></div></div>
<?php } ?>
<?php if($t6bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T6</div>
<div class="TriDvalSHdr"><?php echo $t6bet;?></div></div>
<?php } ?>
<?php if($t7bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T7</div>
<div class="TriDvalSHdr"><?php echo $t7bet;?></div></div>
<?php } ?>
<?php if($t8bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T8</div>
<div class="TriDvalSHdr"><?php echo $t8bet;?></div></div>
<?php } ?>
<?php if($t9bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T9</div>
<div class="TriDvalSHdr"><?php echo $t9bet;?></div></div>
<?php } ?>
<?php if($t10bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T10</div>
<div class="TriDvalSHdr"><?php echo $t10bet;?></div></div>
<?php } ?>
<?php if($t11bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T11</div>
<div class="TriDvalSHdr"><?php echo $t11bet;?></div></div>
<?php } ?>
<?php if($t12bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T12</div>
<div class="TriDvalSHdr"><?php echo $t12bet;?></div></div>
<?php } ?>
<?php if($t13bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T13</div>
<div class="TriDvalSHdr"><?php echo $t13bet;?></div></div>
<?php } ?>
<?php if($t14bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T14</div>
<div class="TriDvalSHdr"><?php echo $t14bet;?></div></div>
<?php } ?>
<?php if($t15bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T15</div>
<div class="TriDvalSHdr"><?php echo $t15bet;?></div></div>
<?php } ?>
<?php if($t16bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T16</div>
<div class="TriDvalSHdr"><?php echo $t16bet;?></div></div>
<?php } ?>
<?php if($t17bet){ ?>
<div class="TriDValWrap">
<div class="TriDvalHdr">T17</div>
<div class="TriDvalSHdr"><?php echo $t17bet;?></div></div>
<?php } ?>
   
</div>
    <div class="TriDSHdrWin">
        <?php if($t4win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T4</div>
        <div class="TriDvalSHdr"><?php echo $t4win;?></div></div>
        <?php } ?>
        <?php if($t5win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T5</div>
        <div class="TriDvalSHdr"><?php echo $t5win;?></div></div>
        <?php } ?>
        <?php if($t6win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T6</div>
        <div class="TriDvalSHdr"><?php echo $t6win;?></div></div>
        <?php } ?>
        <?php if($t7win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T7</div>
        <div class="TriDvalSHdr"><?php echo $t7win;?></div></div>
        <?php } ?>
        <?php if($t8win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T8</div>
        <div class="TriDvalSHdr"><?php echo $t8win;?></div></div>
        <?php } ?>
        <?php if($t9win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T9</div>
        <div class="TriDvalSHdr"><?php echo $t9win;?></div></div>
        <?php } ?>
        <?php if($t10win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T10</div>
        <div class="TriDvalSHdr"><?php echo $t10win;?></div></div>
        <?php } ?>
        <?php if($t11win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T11</div>
        <div class="TriDvalSHdr"><?php echo $t11win;?></div></div>
        <?php } ?>
        <?php if($t12win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T12</div>
        <div class="TriDvalSHdr"><?php echo $t12win;?></div></div>
        <?php } ?>
        <?php if($t13win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T13</div>
        <div class="TriDvalSHdr"><?php echo $t13win;?></div></div>
        <?php } ?>
        <?php if($t14win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T14</div>
        <div class="TriDvalSHdr"><?php echo $t14win;?></div></div>
        <?php } ?>
        <?php if($t15win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T15</div>
        <div class="TriDvalSHdr"><?php echo $t15win;?></div></div>
        <?php } ?>
        <?php if($t16win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T16</div>
        <div class="TriDvalSHdr"><?php echo $t16win;?></div></div>
        <?php } ?>
        <?php if($t17win){ ?>
        <div class="TriDValWrap">
        <div class="TriDvalHdr">T17</div>
        <div class="TriDvalSHdr"><?php echo $t17win;?></div></div>
        <?php } ?>
    </div>
</div>
<?php } ?>    
<div class="TriDSTblResHdrTot">
<div class="TriDSHdrPlay">
<div class="TriDTotals">Totals</div>
<div class="TriDTotals"><?php echo $totalbet;?></div></div>
<div class="TriDSHdrWin">
<div class="TriDTotals"><?php echo $totalwin;?></div></div></div></div>  
</div>
<?php } ?>