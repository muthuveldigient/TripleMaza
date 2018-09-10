<script>
function validate(){
  var lang_name =  document.getElementById("LANGUAGE").value;
  var lang_code =  document.getElementById("LANGUAGE_CODE").value;
  if(lang_name == ''){
  	alert("Language Name Must Be Required !!!.")
	return false;  
  }else if(lang_code == ''){
    alert("Language Code Must Be Required !!!.")
	return false;  
  }
} 
</script>
<style>
.TextField {
    width: 48%;
}
</style>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
  <form action="" name="regForm" id="regForm" onsubmit="return validate();" method="POST">
 <table width="100%" class="PageHdr">
  <tr>
    <td><strong>Language</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right"><a href="<?php echo base_url();?>cms/language" class="dettxt">List Page</a></div></td>
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
      <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
      <tr>
        <td><table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Add</strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="40%"><span class="TextFieldHdr">Language Name:</span><br />
                <label>
                 <input type="text" name="LANGUAGE" id="LANGUAGE" class="TextField">
                <span class="mandatory">*</span></label></td>
             
              <td width="40%"><span class="TextFieldHdr">Language Code:</span><br />
                <label>
                 <input type="text" name="LANGUAGE_CODE" id="LANGUAGE_CODE" class="TextField">
                <span class="mandatory">*</span></label></td>
                <td>
                </td>
               </tr>
              
          </table>
          <div class="SeachResultWrap2">
            <input type="submit" tabindex="28" value="Create" class="button" id="Submit" name="Submit">
            <input type="button" onclick="clearagentdet();" tabindex="29" value="Reset" class="button">
          </div>
      </tr>
    </table>
  </form>
</div>
</div>
</div>
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>