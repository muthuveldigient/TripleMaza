<script type="text/javascript" src="<?php echo base_url(); ?>static/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
	width : 500,
	height: 600
 });

 function validate(){
 
  var page_name =  document.getElementById("PAGE_NAME").value;
  var page_lang =  document.getElementById("PAGE_LANG").value;
  var page_visible =  document.getElementById("PAGE_VISIBLE").value;
  var page_title =  document.getElementById("PATE_TITLE").value;
  var page_content =  document.getElementById("PAGE_CONTENT").value;
  if(page_name == ''){
  	alert("Page Name Must Be Required !!!.")
	return false;  
  }else if(page_lang == ''){
    alert("Language Must Be Required !!!.")
	return false;  
  }else if(page_visible == ''){
    alert("Page Visible Must Be Required !!!.")
	return false;  
  }else if(page_title == ''){
    alert("Page Title Must Be Required !!!.")
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
    <td><strong>Static Page</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right"><a href="<?php echo base_url();?>cms/pages/view" class="dettxt">List Page</a></div></td>
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
              <td><strong>Create</strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="40%"><span class="TextFieldHdr">Page Name:</span><br />
                <label>
                  <select class="TextField" name="PAGE_NAME" id="PAGE_NAME"> 
                   <option value="">-- Select Page --</option>
                   <?php foreach($menus as $menu){ ?>
                   <option value="<?php echo $menu->STATIC_PAGE_MASTER_ID;?>"><?php echo $menu->PAGE_NAME;?></option>
                   <?php } ?>
                 </select>
                <span class="mandatory">*</span></label></td>
             </tr>
             <tr>
              <td width="40%"><span class="TextFieldHdr">Page Language:</span><br />
                <label>
                 <select class="TextField" name="PAGE_LANG" id="PAGE_LANG"> 
                   <option value="">-- Select Language --</option>
                   <?php foreach($langs as $lang){ ?>
                   <option value="<?php echo $lang->LOCALE_ID;?>"><?php echo $lang->LOCALE_NAME;?></option>
                   <?php } ?>
                 </select>
                <span class="mandatory">*</span></label></td>
               </tr>
               <tr>
              <td width="40%"><span class="TextFieldHdr">Page Visible:</span><br />
                <label>
                 <select class="TextField" name="PAGE_VISIBLE" id="PAGE_VISIBLE"> 
                   <option value="">-- Select Visibility --</option>
                   <option value="1">Pre Login</option>
                   <option value="2">Post Login</option>
                 </select>
                <span class="mandatory">*</span> </label></td>
            </tr>
            <tr>
              <td width="40%"><span class="TextFieldHdr">Page Title:</span><br />
                <label>
                <input name="PATE_TITLE" type="text" class="TextField" id="PATE_TITLE" maxlength="15" tabindex="2" value="" />
                <span class="mandatory">*</span></label></td>
               </tr>
               <tr>
                  <td width="40%"><span class="TextFieldHdr">Page Content:</span><br /><br />
                <label>
                <textarea id="PAGE_CONTENT" name="PAGE_CONTENT"></textarea>
               </label></td>
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