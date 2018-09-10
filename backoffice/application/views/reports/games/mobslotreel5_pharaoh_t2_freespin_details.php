<style>
.UDpopBg{
 width: 420px !important;
}
</style>
<?php

 $refno = $_REQUEST['refno'];
 $spin  = $_REQUEST['spin']; 
?> 
<span style="color:#0089CE;font-weight:bold;">Free SPin Results - Spin No: <?php echo $spin; ?></span>
  <div class="tableWrap">
      <table>
       <tr>
        <td>
         <script>
   function changeLineImageF(str){
      if(str){
	     var imageREveal = '<?php echo base_url(); ?>static/images/slot-lineimages/payline_'+str+'.png';
		document.getElementById('lineImageF').innerHTML = "<img src=\"" + imageREveal + "\">";
	 }
   }
   </script>
          <?php
		  $query="select mobslotreel5_pharaoh_t2_play.*,user.USERNAME from mobslotreel5_pharaoh_t2_play, user where mobslotreel5_pharaoh_t2_play.USER_ID = user.USER_ID AND GAME_ID='mobslotreel5_pharaoh_t2' and INTERNAL_REFERENCE_NO='".$refno."'"; 
		  
		  $results=mysql_query($query) or die("connection failed");

while($row=mysql_fetch_array($results))
{	
	@extract($row);		 
		  
          ?>
        	
            <?php
			 $tot=json_decode($PLAY_DATA, true); 
			$winlines  = $tot['freeSpinResultHistory'][$spin]['winlines'];
		
			 ?>
             <div class="UDFieldtitle">
                          <?PHP 
                                       if($winlines){
                                       if(strstr($winlines,'|')){
                                          $noofresults=explode("|",$winlines); 
                                          
                                        for($tr=0;$tr<count($noofresults);$tr++){  
                                        $resdet=explode(",",$noofresults[$tr]);
                                        $scount=explode("C",$resdet[2]);
                                        $symbol1=explode("S",$resdet[1]);
                                        $symbol2=$symbol1[1];
                                      ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line : <a href="javascript:void(0);" onclick="changeLineImageF('<?php echo $resdet[0]; ?>');"><?php echo $resdet[0];?></a></b> </div>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Count : <?php echo $scount[1];?></b> </div>
                          <div>
                            <?php     
                                        if($scount[1]){
                                            for($s=0;$s<$scount[1];$s++){
                                       ?>
                            <img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $symbol2.".png"?>" height="65" width="65"/>
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
                                        $scount=explode("C",$resdet[2]);
                                        $symbol1=explode("S",$resdet[1]);
                                        $symbol2=$symbol1[1];
                                           ?>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Win Line : <a href="javascript:void(0);" onclick="changeLineImageF('<?php echo $resdet[0]; ?>');"><?php echo $resdet[0];?></a></b> </div>
                          <div class="UDFieldtitle" style="padding-bottom:10px;"> <b>Count : <?php echo $scount[1];?></b> </div>
                          <div class="UDFieldtitle">
                            <?php     
                                        if($scount[1]){
                                            for($s=0;$s<$scount[1];$s++){
                                       ?>
                            <img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $symbol2.".png"?>" height="65" width="65"/>
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
        
        </td>
        
      <?php
	    
	
	 
	 
	 
	   $windowSymbol1  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][0][0]['id'];
	   $windowSymbol2  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][1][0]['id'];
	   $windowSymbol3  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][2][0]['id'];
	   $windowSymbol4  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][3][0]['id'];
	   $windowSymbol5  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][4][0]['id'];
	  
	   $windowSymbol6  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][0][1]['id'];
	   $windowSymbol7  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][1][1]['id'];
	   $windowSymbol8  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][2][1]['id'];
	   $windowSymbol9  = $tot['freeSpinResultHistory'][$spin]['window']['reels'][3][1]['id'];
	   $windowSymbol10 = $tot['freeSpinResultHistory'][$spin]['window']['reels'][4][1]['id'];
	   
	   $windowSymbol11 = $tot['freeSpinResultHistory'][$spin]['window']['reels'][0][2]['id'];
	   $windowSymbol12 = $tot['freeSpinResultHistory'][$spin]['window']['reels'][1][2]['id'];
	   $windowSymbol13 = $tot['freeSpinResultHistory'][$spin]['window']['reels'][2][2]['id'];
	   $windowSymbol14 = $tot['freeSpinResultHistory'][$spin]['window']['reels'][3][2]['id'];
	   $windowSymbol15 = $tot['freeSpinResultHistory'][$spin]['window']['reels'][4][2]['id'];
	   
	   
	   
	   
	   
	  ?>
      
       <td valign="top">
       <div id="lineImageF" style="position:absolute;"></div>
      <table style="margin-top: 10px; border:1px solid #001f87" width="150">
      <tr>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol1; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol2; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol3; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol4; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol5; ?>.png" width="100" height="100"></td>
      </tr>
      <tr>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol6; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol7; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol8; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol9; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol10; ?>.png" width="100" height="100"></td>
      </tr>
      <tr>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol11; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol12; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol13; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol14; ?>.png" width="100" height="100"></td>
        <td><img src="<?php echo base_url(); ?>static/images/minigame/junglesafari/<?php echo $windowSymbol15; ?>.png" width="100" height="100"></td>
      </tr>
      </table>
        </td>
        </tr>
	</table>
     
  </div>
  <?php
}
?>

