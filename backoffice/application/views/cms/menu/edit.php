<script>
function validate(){
  var menu_title =  document.getElementById("MENU_TITLE").value;
  var parent_menu =  document.getElementById("PARENT_MENU").value;
  if(menu_title == ''){
  	alert("Menu Title Must Be Required !!!.")
	return false;  
  }else if(parent_menu == ''){
    alert("Parent Menu Must Be Required !!!.")
	return false;  
  }
} 
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
  <form action="" name="regForm" id="regForm" onsubmit="return validate();" method="POST">
 <table width="100%" class="PageHdr">
  <tr>
    <td><strong>Menu</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right"><a href="<?php echo base_url();?>cms/menu" class="dettxt">List Page</a></div></td>
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
              <td><strong>Edit</strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
      <tr>
        <td>
          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="40%"><span class="TextFieldHdr">Menu Title:</span><br />
                <label>
                 <input type="text" name="MENU_TITLE" id="MENU_TITLE" value="<?php echo $menu->PAGE_NAME; ?>" class="TextField">
                <span class="mandatory">*</span></label></td>
             
              <td width="40%"><span class="TextFieldHdr">Parent Menu:</span><br />
                <label>
                  <select class="TextField" id="PARENT_MENU" name="PARENT_MENU">
                   <option value="">Select</option>
                   <option <?php if($menu->PARENT_ID ==0){ echo 'selected="selected"'; } ?> value="0">Top</option>
                   <?php foreach($allmenus as $menus){ ?>
                     <option <?php if($menu->PARENT_ID == $menus->STATIC_PAGE_MASTER_ID){ echo 'selected="selected"'; } ?>  value="<?php echo $menus->STATIC_PAGE_MASTER_ID; ?>"><?php echo $menus->PAGE_NAME; ?></option>
                   <?php } ?>
                 </select>
                <span class="mandatory">*</span></label></td>
                <td>
                </td>
               </tr>
              
          </table>
          <div class="SeachResultWrap2">
            <input type="hidden" name="menu_id" value="<?php echo $menu->STATIC_PAGE_MASTER_ID; ?>">
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