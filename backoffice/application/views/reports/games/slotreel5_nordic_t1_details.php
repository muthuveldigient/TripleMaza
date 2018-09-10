
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
              <td class="NTblHdrTxt">Stake</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Played Lines</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Bonus Win</td>
            </tr>
          </table></td>
         <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Feature Win</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Total Win</td>
            </tr>
          </table></td>
      </tr>
	  <?PHP  $results = $this->game_model->slotreel5_nordic_t1_play($handId,$get);  ?>

      <?PHP
/*  $query="select slotreel5_nordic_t1_play.*,user.USERNAME from slotreel5_nordic_t1_play, user where slotreel5_nordic_t1_play.USER_ID = user.USER_ID AND GAME_ID='slotreel5_nordic_t1' and INTERNAL_REFERENCE_NO='".$refno."'";
$results=mysql_query($query) or die("connection failed");
	if(isset($_REQUEST['page']))
	{
	$i=$startpoint+1;
	}
	else
	{
	$i=1;
	}
while($row=mysql_fetch_array($results))*/
foreach($results as $key=>$val)
{	
	

?>
      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $val->USERNAME; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="300" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->INTERNAL_REFERENCE_NO;  ?></td>
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
              <td><?PHP echo $val->STAKE; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><table border="0" cellpadding="0" cellspacing="0" align="center">
                  <tr>
                  <?php 
					 $tot2=json_decode($val->PLAY_DATA, true);   
					 $winlines2=$tot2['spinResult']['playedLines'];
					 if($winlines2){ 
						  echo implode(",",$winlines2);
					 }
					?>
                   </tr> 
                </table></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->WIN; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->BONUS_WIN; ?></td>
            </tr>
          </table></td>
         <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->FREE_SPIN_WIN; ?></td>
            </tr>
          </table></td>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td><?PHP echo $val->TOTAL_WIN; ?></td>
            </tr>
          </table></td>
        
      </tr>
      
<?php          
}
?>
    </table>
  <?php if($BONUS_WIN != '0.00'){ ?>  
    <table class="" width="50%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="50%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Level</td>
            </tr>
          </table></td>
        <td class="NTblHdrWrap"><table width="50%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Bonus</td>
            </tr>
          </table></td>
      </tr>
      <?PHP
		  $tot=json_decode($val->PLAY_DATA, true);   
		
			$bonusValues=count($tot['bonusResult']); 
			
			for($w=0;$w<$bonusValues;$w++)
			{	   
				$bonusvaluedd=$tot['bonusResult'][$w];
				$level  = $w+1;
				$selectedTarget =  $tot['bonusResult'][$w]["selectedTarget"];
				$bonus  =  $tot['bonusResult'][$w]["targetValues"][$selectedTarget];
				
				?>
               <tr> 
               	<td class="NSTblHdrWrap ">
                	<table width="70px" align="center" class="SHdr1line">
           			 <tr>
              			<td class=""><?php echo $level; ?></td>
            		</tr>
         		 </table>
               </td>
               <td class="NSTblHdrWrap ">
               	<table width="300" align="center" class="NSTblHdrTxt">
            	<tr>
              		<td><?php echo $bonus ; ?></td>
           		 </tr>
         		 </table>
               </td>
             </tr>
				<?php 
			 }
?>
    </table>
    <?php } ?>
    <?php

	  $totFreeSpin=json_decode($val->PLAY_DATA, true);
	  $is_freespin = $totFreeSpin['spinResult']['canFreeSpin'];
	  if($is_freespin == 1){
	  	 $freeSpinResult = $totFreeSpin['freeSpinResult'];
		 $totFreeSpin=count($freeSpinResult); 	    
		?>
          <table>
            <tr><br /><span style="color:#0089CE;font-weight:bold;">Free SPin Results - Total Free Spins (<?php echo $totFreeSpin;?>)</span></tr>
            <tr>
         <?php for($fs=0;$fs<$totFreeSpin;$fs++) { ?>
		  		<td style="border: 1px solid; padding: 4px;">
                <a href="javascript::void(0);" style="font-weight:bold;" onclick="NewWindow2('desktop_freespininfo_cricket_slot.php?refno=<?php echo $INTERNAL_REFERENCE_NO; ?>&spin=<?php echo $fs; ?>','Free Spin Trans','824','700','yes')" href=""><?php echo ($fs+1)."/".$freeSpinResult[$fs]["round"]; ?></a></td>
		 <?php if($fs == 20){ ?>
			 </tr><tr>
		  <?php
		     }
		   } ?>
	      </tr>
          </table>  		
	 <?php } ?> 
    
   <script>
   
   function changeLineImageF(str){
      if(str){
	    var imageREveal = 'images/slot-lineimages/payline_'+str+'.png';
		document.getElementById('lineImageF').innerHTML = "<img src=\"" + imageREveal + "\">";
	 }
   }
   </script>
      <table>
       <tr>
        <td>
          <?php
      		$tot=json_decode($val->PLAY_DATA, true);
		    $betPerLimeAmt  = $tot['spinResult']['betAmtPerLine'];		
			$winlines=$tot['spinResult']['winlines'];
          if($winlines){      
		   
      ?>
                <div   id="myOnPageContent<?php echo $val->INTERNAL_REFERENCE_NO; ?>">
                  <div class="UDpopBg">
                    <div class="UDpopupWrap"> <!-- DOUBLE GAME RESULTS-->
                      <div class="UDpopLeftWrap">
                        <div class="UDFieldtitle">
                          <?PHP 
                                       if($winlines){
									   
                                       if(strstr($winlines,'|')){
                                          $noofresults=explode("|",$winlines); 
                                          
                                        for($tr=0;$tr<count($noofresults);$tr++){  
                                        $resdet=explode(",",$noofresults[$tr]);
										$winAmtCount = count($resdet); 
										
										
                                        $scount=explode("C",$resdet[2]);
                                        $symbol1=explode("S",$resdet[1]);
                                        $symbol2=$symbol1[1];
                                      ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line : <a href="javascript:void(0);" onclick="changeLineImageF('<?php echo $resdet[0]; ?>');"><?php echo $resdet[0];?></a></b> </div>
                          <?php  if($winAmtCount == 4){ 
						    $wacount=str_replace("W","",$resdet[3]);
							$wlamount = $wacount * $betPerLimeAmt;
						  ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line Amount : <?php echo $wlamount;?></b> </div>
                          <?php } ?>
                     
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Count : <?php echo $scount[1];?></b> </div>
                          <div>
                            <?php     
                                        if($scount[1]){
                                            for($s=0;$s<$scount[1];$s++){
                                       ?>
                            <img src="images/minigame/cricketslot/<?php echo $symbol2.".png"?>" height="65" width="65"/>
                            <?php
                                            }
                                        }
                                       ?>
                            <br />
                          </div>
                          <?php
                                       }
                                       }else{
                                           $resdet=explode(",",$winlines);
										   $winAmtCount = count($resdet); 
                                        $scount=explode("C",$resdet[2]);
                                        $symbol1=explode("S",$resdet[1]);
                                        $symbol2=$symbol1[1];
                                           ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line : <a href="javascript:void(0);" onclick="changeLineImageF('<?php echo $resdet[0]; ?>');"><?php echo $resdet[0];?></a></b> </div>
                          <?php  if($winAmtCount == 4){ 
						    $wacount=str_replace("W","",$resdet[3]);
							$wlamount = $wacount * $betPerLimeAmt;
						  ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line Amount : <?php echo $wlamount;?></b> </div>
                          <?php } ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Count : <?php echo $scount[1];?></b> </div>
                          <div class="UDFieldtitle">
                            <?php     
                                        if($scount[1]){
                                            for($s=0;$s<$scount[1];$s++){
                                       ?>
                            <img src="images/minigame/cricketslot/<?php echo $symbol2.".png"?>" height="65" width="65"/>
                            <?php
                                            }
                                        }
                                       ?>
                            <br />
                          </div>
                          <?php
                                       }    
                                      }  
                                       ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
          }
          ?>
        </td>
      <?php
	   $tot=json_decode($val->PLAY_DATA, true);   
  	   $windowcount=count($tot['spinResult']['window']);
 
	   $windowSymbol1  = $tot['spinResult']['window']['reels'][0][0]['id'];
	   $windowSymbol2  = $tot['spinResult']['window']['reels'][1][0]['id'];
	   $windowSymbol3  = $tot['spinResult']['window']['reels'][2][0]['id'];
	   $windowSymbol4  = $tot['spinResult']['window']['reels'][3][0]['id'];
	   $windowSymbol5  = $tot['spinResult']['window']['reels'][4][0]['id'];
	  
	   $windowSymbol6  = $tot['spinResult']['window']['reels'][0][1]['id'];
	   $windowSymbol7  = $tot['spinResult']['window']['reels'][1][1]['id'];
	   $windowSymbol8  = $tot['spinResult']['window']['reels'][2][1]['id'];
	   $windowSymbol9  = $tot['spinResult']['window']['reels'][3][1]['id'];
	   $windowSymbol10 = $tot['spinResult']['window']['reels'][4][1]['id'];
	   
	   $windowSymbol11 = $tot['spinResult']['window']['reels'][0][2]['id'];
	   $windowSymbol12 = $tot['spinResult']['window']['reels'][1][2]['id'];
	   $windowSymbol13 = $tot['spinResult']['window']['reels'][2][2]['id'];
	   $windowSymbol14 = $tot['spinResult']['window']['reels'][3][2]['id'];
	   $windowSymbol15 = $tot['spinResult']['window']['reels'][4][2]['id'];
	  ?>
       <td valign="top">
       <div id="lineImageF" style="position:absolute;"></div>
      <table style="margin-top: 10px; border:1px solid #001f87" width="150">
      <tr>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol1; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol2; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol3; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol4; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol5; ?>.png" width="100" height="100"></td>
      </tr>
      <tr>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol6; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol7; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol8; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol9; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol10; ?>.png" width="100" height="100"></td>
      </tr>
      <tr>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol11; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol12; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol13; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol14; ?>.png" width="100" height="100"></td>
        <td><img src="images/minigame/cricketslot/<?php echo $windowSymbol15; ?>.png" width="100" height="100"></td>
      </tr>
      </table>
        </td>
        </tr>
	</table>
     
  </div>