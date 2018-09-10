<script type="text/javascript">
 function validate(){
  var banner_pos =  document.getElementById("BANNER_POSITION").value;
  var banner_lan =  document.getElementById("BANNER_LANGUAGE").value;
  var banner_lin =  document.getElementById("BANNER_LINK").value;
  if(banner_pos == ''){
  	alert("Banner Position Must Be Required !!!.")
	return false;  
  }else if(banner_lan == ''){
    alert("Banner Language Must Be Required !!!.")
	return false;  
  }else if(banner_lin == ''){
    alert("Banner Link Must Be Required !!!.")
	return false;  
  }
 
 } 
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
  <form enctype="multipart/form-data" action="" name="regForm" id="regForm" onsubmit="return validate();" method="POST">
 <table width="100%" class="PageHdr">
  <tr>
    <td><strong>News</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right"><a href="<?php echo base_url();?>cms/banner" class="dettxt">List Page</a></div></td>
  </tr>
</table>
    </td>
  </tr>
</table>
     
    <?php if(isset($msg) && $msg!=""){ ?>
    <div class="UpdateMsgWrap">
      <table width="100%" class="SuccessMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
          <td width="95%"><?php echo $msg;?></td>
        </tr>
      </table>
    </div>
    <?php } ?>
    <?php if(isset($error) && $error!=""){ ?>
    <div class="UpdateMsgWrap">
      <table width="100%" class="ErrorMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
          <td width="95%"><?php echo $error;?></td>
        </tr>
      </table>
    </div>
    <?php } ?>
    
     <table>
       <tr>
     	<td style="width:530px;">
     		<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" style="position:relative;top:-35px;" class="searchWrap">
     		 <tr>
        <td><table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Add</strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="40%"><span class="TextFieldHdr">Banner Position:</span><br />
                <label>
                 <select name="BANNER_POSITION" class="TextField" id="BANNER_POSITION">
                  <option value="">Select</option>
                    <?PHP foreach($bannerPositions as $position){ ?>
                     <option <?php if($position->POSITION == $banner->BANNER_POSITION) echo 'selected="selected"'; ?>  value="<?PHP echo $position->POSITION_ID.'-'.$position->POSITION;?>"><?PHP echo $position->POSITION;?></option>
				   <?PHP }  ?>
  				</select>
                <span class="mandatory">*</span></label></td>
           </tr>  
           <tr>
              <td width="40%"><span class="TextFieldHdr">Banner Language:</span><br />
                <label>
                 <select name="BANNER_LANGUAGE" class="TextField" id="BANNER_LANGUAGE">
                  <option value="">Select</option>
                    <?PHP foreach($languages as $language){ ?>
                     <option <?php if($language->LOCALE_CODE == $banner->LOCALE_CODE) echo 'selected="selected"'; ?> value="<?PHP echo $language->LOCALE_CODE;?>"><?PHP echo $language->LOCALE_NAME;?></option>
				   <?PHP }  ?>
  				</select>
                <span class="mandatory">*</span></label></td>
           </tr>
           
              <tr>
              <td width="40%"><span class="TextFieldHdr">Banner Image:</span><br /><br />
                <label>
               <input type="file" name="attachment">
               </label></td>
                <td>
                </td>
              </tr>
            
            <tr>
              <td width="40%"><span class="TextFieldHdr">Banner Link:</span><br />
                <label>
                <input type="text" name="BANNER_LINK" id="BANNER_LINK" value="<?php echo $banner->BANNER_URL; ?>" class="TextField">
                <span class="mandatory">*</span></label></td>
           </tr>  
              
          </table>
          <div class="SeachResultWrap2">
            <input type="hidden" name="banner_id" value="<?php echo $banner->BANNER_MANAGER_ID; ?>">
            <input type="submit" tabindex="28" value="Create" class="button" id="Submit" name="Submit">
            <input type="button" onclick="clearagentdet();" tabindex="29" value="Reset" class="button">
          </div>
      </tr>
   		</table>
         </td>
         <td>
           <img src="<?php echo base_url(); ?>static/uploads/banners/<?php echo $banner->BANNER_IMAGE; ?>">
         </td>
         </tr>
         </table>
  </form>
</div>
</div>
</div>
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>