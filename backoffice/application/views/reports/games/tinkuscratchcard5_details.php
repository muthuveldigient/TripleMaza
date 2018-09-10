<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<style>
.SHdrIDSL { float:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:400; color:#333; text-decoration:none; width:80px; text-align:center; border-right:1px solid #ddf4ff; padding:5px; word_wrap:break-word; }

</style>
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
  <div class="tableWrap" style="width:100%">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Username</td>
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
         <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Price per ticket</td>
            </tr>
          </table></td>
          <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Total Tickets</td>
            </tr>
          </table></td>
         
          
      </tr>
	  <?PHP  $results = $this->game_model->scratchcard_play($handId);  ?>
      <?PHP


  $i=1;
foreach($results as $key=>$val){
?>

      <tr>
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $val->USERNAME; ?></td>
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
              <td style="text-align:right;"><?PHP echo $val->STAKE; ?></td>
            </tr>
          </table></td>
        
        
        
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td style="text-align:right;"><?PHP echo $val->WIN; ?></td>
            </tr>
          </table></td>
          
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="right" class="NSTblHdrTxt">
            <tr>
              <td style="text-align:right;"><?PHP echo number_format($val->PRICE,2,".",""); ?></td>
            </tr>
          </table></td>
          
        <td class="<?PHP if ($i%2=="0") { ?>NSTb2HdrWrap <?PHP } else { ?> NSTblHdrWrap <?PHP } ?>"><table width="100%" align="center" class="NSTblHdrTxt">
            <tr>
              <td style="text-align:right;"><?PHP  echo $val->usertickets; ?></td>
            </tr>
          </table></td>  
          
         
      </tr>
      <?php 
$i++;

?>
    </table>
   <?php    
	$usertickets=$val->userticketss;
	$brandname=$val->brandname; 
	$userticketiddetails=$val->userticketiddetails;
	$split_details=$val->split_details;
	$splitid="";
	$batchid="";
	foreach($split_details as $key=>$value){
		
	  $splitdetails=explode("~",$split_details[$key]);
	  if($splitid){
	  $splitid=$splitid.",".$splitdetails[1];
	  }else{
	  $splitid=$splitdetails[1];    
	  }
	  if($batchid){
	   $batchid=$batchid.",".$splitdetails[0];
	  }else{
	   $batchid=$splitdetails[0];   
	  }
	  
	}
  
  foreach($usertickets as $key=>$value){
      
      $userticketno[]=$usertickets[$key]['winNo'];
      $userticket_winamt[]=$usertickets[$key]['winAmt'];
      $userticket_prizepos[]=$usertickets[$key]['prizePos'];  
      $userticketId[]=$userticketiddetails['ticketId'][$key];
    //  echo $userticketiddetails['ticketId'][$key];
   
  }
  
 if($usertickets){
?> 
<div  style="padding-left:10px; ">
<div class="tableWrap">
<div class="TblHdrWrap">
<div class="HdrID" style="width:150px;">Ticket Id</div>
<div class="HdrID">Ticket No</div>
<div class="HdrID">Win Amount</div>
<div class="HdrID">Brand</div>
<div class="HdrID">Batch Id</div>
<div class="HdrID">Split Id</div>
<div class="HdrID">Rank</div>
</div>



<?php 
   for($s=0;$s<count($usertickets);$s++){	
    $usertktno=$userticketno[$s];
    $usertktId=$userticketId[$s];
    $usertktwinamt=$userticket_winamt[$s];
    $usertktwinpos=$userticket_prizepos[$s];
    ?>    
<div class="<?PHP if ($s%2=="0") { ?> STblHdrWrap3 <?php } else { ?> STblHdrWrap<?php } ?>">
<div class="SHdrIDSL" style="border-right-width: 1px; border-right-style: solid; border-right-color: #9DDFFF;width:150px;"><?php echo $usertktId;?></div>    
<div class="SHdrIDSL" style="border-right-width: 1px; border-right-style: solid; border-right-color: #9DDFFF;"><?php echo $usertktno;?></div>
<div class="SHdrIDSL"><?php echo $usertktwinamt;?></div>
<div class="SHdrIDSL"><?php echo $brandname;?></div>
<div class="SHdrIDSL" style="word-wrap:break-word;"><?php echo $batchid;?></div>
<div class="SHdrIDSL" style="word-wrap:break-word;"><?php echo $splitid;?></div>
<div class="SHdrIDSL"><?php echo $usertktwinpos;?></div>
</div>
<?php } ?>
</div>
</div>
<?php } ?>
  </div>
  <?php
 }
?>