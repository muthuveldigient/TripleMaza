<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<script src ="<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
   <form action="<?php echo base_url()?>games/poker/tournament/view" method="post" name="tsearchform" id="tsearchform">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Search Tournaments</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Tournament Name:</span><br />
            <label>
            <input type="text" name="tourName" id="tourName" class="TextField" value="" >
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Game Type:</span><br />
            <label>
        
            <select name="game_type" class="ListMenu" id="select2">
              <option value=""></option>
			  <?php foreach($gameTypes as $gametype){ ?>
              <option value="<?php echo $gametype->MINIGAMES_TYPE_ID; ?>"><?php echo $gametype->GAME_DESCRIPTION; ?></option>
              <?php } ?>
            </select>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Currency Type:</span><br />
            <label>
       
             <select name="currency_type" class="ListMenu" id="ctype">
              <option value=""></option>
              <?php foreach($currencyTypes as $currencyType){ ?>
              <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>"><?php echo $currencyType->NAME; ?></option>
              <?php } ?>
            </select>
            </label></td>
        </tr>
          <tr>
          
          <td width="40%"><span class="TextFieldHdr">Tournament Type:</span><br />
            <label>
           <select name="tournamentType" class="ListMenu" id="ctype">
              <option value=""></option>
              <option value="sitngo">Sit N Go</option>
              <option value="schedule">Schedule</option>
            </select>
            </label></td>
           
          <td width="40%"><span class="TextFieldHdr">Fee:</span><br />
            <label>
            <input type="text" name="fee" id="fee" class="TextField" value="" >
            </label></td>
        </tr>
        
        <tr>
          <td width="40%"><span class="TextFieldHdr">Start Data:</span><br />
            <label>
            <input type="text" name="startdate" id="startdate" class="TextField" > <a onclick="NewCssCal('startdate','yyyymmdd','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">End Date:</span><br />
            <label>
            <input type="text" name="enddate" id="enddate" class="TextField"  > <a onclick="NewCssCal('enddate','yyyymmdd','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>
            </label></td>
          <td width="20%">&nbsp;</td>
        </tr>
        
        
        <tr>
         
          <td width="20%">&nbsp;</td>
        </tr>
        
        <tr>
          <td width="33%"><table>
            <tr>
              <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
  </form>
  </td>
  <td><form action="<?php echo base_url();?>games/poker/tournament" method="post" name="clrform" id="clrform">
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
<?php $this->load->view("common/footer"); ?>