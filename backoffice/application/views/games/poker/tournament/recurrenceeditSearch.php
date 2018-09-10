<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>

<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); 
?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){ echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     
   <form action="<?php echo base_url()?>games/poker/tournament/rlisttournament?rid=<?php echo $rid?>" method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Delete Recurrence Tournament</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Table ID:</span><br />
            <label>
            <input type="text" name="tableID" id="tableID" class="TextField" value="<?PHP if(isset($_REQUEST['tableID'])) echo $_REQUEST['tableID']; ?>" tabindex="1" >
            </label></td>
            
          <td width="30%"><span class="TextFieldHdr">Game Type:</span><br />
            <label>
            
            <select name="game_type" class="ListMenu" id="game_type" tabindex="2">
              <option value="">Select</option>
              <?php foreach($gameTypes as $gametype){ ?>
              <option value="<?php echo $gametype->MINIGAMES_TYPE_ID; ?>" <?php if($_REQUEST['game_type']==$gametype->MINIGAMES_TYPE_ID){ echo "selected"; } ?> ><?php echo $gametype->GAME_DESCRIPTION; ?></option>
              <?php } ?>
            </select>
            </label>
          </td>
         <td width="40%"><span class="TextFieldHdr">Currency Type:</span><br />
            <label>
             <select name="currency_type" class="ListMenu" id="currency_type" tabindex="3">
               <option value="">Select</option>
              <?php foreach($currencyTypes as $currencyType){ ?>
              <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>" <?php if($_REQUEST['currency_type']==$currencyType->COIN_TYPE_ID){ echo "selected"; } ?> ><?php echo $currencyType->NAME; ?></option>
              <?php } ?>
            </select>
            </label></td>
        </tr>
         
          <tr>
         
          
          
        </tr>
        <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
					if($_REQUEST['START_DATE_TIME'])
						$START_DATE_TIME = $_REQUEST['START_DATE_TIME'];
					else
						$START_DATE_TIME = "";
				  ?>   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; } ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                   <?php
					if($_REQUEST['END_DATE_TIME'])
						$END_DATE_TIME = $_REQUEST['END_DATE_TIME'];
					else
						$END_DATE_TIME = "";
				  ?> 
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>
                <td width="20%">&nbsp;</td>
        </tr>
        <tr>
          <td width="33%"><table>
            <tr>
              <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
  </form>
  </td>
  <td><form action="<?php echo base_url();?>games/poker/tournament/edittournament?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
      <input name="reset" type="submit"  id="reset" value="Clear"  />
    </form></td>
  <td>&nbsp;</td>
  </tr>
  </table>
  </td>
  <td width="33%">&nbsp;</td>
  <td width="33%">&nbsp;</td>
  </tr>
  </table>
  </table>
  </form>
</div>
 </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>