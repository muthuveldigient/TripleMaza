<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />

<style>
    .header {
        display:none;
    }
</style>
<?php// echo "<pre>";print_r($results);?>

 <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     

        <table width="100%" class="ContentHdr">
          <tr>
              <td>Game Name: <strong><?echo ucfirst($results[0]->GAME_ID); ?></strong></td>
              <td>Group Id: <strong><?echo ucfirst($results[0]->PLAY_GROUP_ID); ?></strong></td>
          </tr>
        </table>
     
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">S.No</td>
            </tr>
          </table></td> 

        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Username</td>
            </tr>
          </table></td>          
          
        <td class="NTblHdrWrap"><table width="100%" align="center" class="NTblHdrTxt">
            <tr>
              <td class="NTblHdrTxt">Handid</td>
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

     
     
     <?php $cnt= count($results);
     for($i=0;$i<$cnt;$i++){ ?>
      <tr>        
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $i+1; ?></td>
            </tr>
          </table></td>
          
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
                <? $username =  $this->Account_model->getUserNameById($results[$i]->USER_ID); ?>
              <td class=""><?PHP echo ucfirst($username); ?></td>
            </tr>
          </table></td>    
          
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $results[$i]->INTERNAL_REFERENCE_NO; ?></td>
            </tr>
          </table></td>          
          
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $results[$i]->STAKE; ?></td>
            </tr>
          </table></td> 
          
      <td class="NSTblHdrWrap"><table width="100%" align="center" class="SHdr1line">
            <tr>
              <td class=""><?PHP echo $results[$i]->WIN; ?></td>
            </tr>
          </table></td>  
 </tr>
 
     
        <?php  }  ?>
    
    </table>
 </div>
