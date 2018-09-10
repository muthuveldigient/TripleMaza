<script type="text/javascript" src="<?php echo base_url(); ?>static/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
	width : 500,
	height: 600
 });

 function validate(){
 
  var news_title =  document.getElementById("NEWS_TITLE").value;
  var news_desc =  document.getElementById("NEWS_DESC").value;
  var active_days =  document.getElementById("ACTIVE_DAYS").value;

  if(news_title == ''){
  	alert("News Title Must Be Required !!!.")
	return false;  
  }else if(active_days == ''){
    alert("Active Days Must Be Required !!!.")
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
    <td><strong>News</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right"><a href="<?php echo base_url();?>cms/news" class="dettxt">List Page</a></div></td>
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
              <td width="40%"><span class="TextFieldHdr">News Title:</span><br />
                <label>
                 <input type="text" name="NEWS_TITLE" id="NEWS_TITLE" class="TextField">
                <span class="mandatory">*</span></label></td>
           </tr>  
              <tr>
              <td width="40%"><span class="TextFieldHdr">News Description:</span><br /><br />
                <label>
                 <textarea id="NEWS_DESC" name="NEWS_DESC"></textarea>
               </label></td>
                <td>
                </td>
              </tr>
            <tr>
              <td width="40%"><span class="TextFieldHdr">Active Days:</span><br />
                <label>
                <select name="ACTIVE_DAYS" class="TextField" id="ACTIVE_DAYS">
                  <option value="">--Day--</option>
                    <?PHP for($i=1; $i<=10; $i++){ ?>
                     <option value="<?PHP  echo $i;?>"><?PHP echo $i;?></option>
				   <?PHP }  ?>
  				</select>
                <span class="mandatory">*</span></label></td>
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