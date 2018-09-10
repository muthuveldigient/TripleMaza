<script language="javascript">
function password_validate(field,e)
{
    with (field)
	{
            if(trim(OLDPASSWORD.value)=="")
            {
            alert("Enter the old password");
            OLDPASSWORD.focus();
            return false;
            }
            if(trim(NEWPASSWORD.value)=="")
            {
            alert("Enter the new password");
            NEWPASSWORD.focus();
            return false;
            }
        }
}

function transactionpassword_validate(field,e)
{
    with (field)
	{
            if(trim(TRANS_OLDPASSWORD.value)=="")
            {
            alert("Enter the transaction old password");
            TRANS_OLDPASSWORD.focus();
            return false;
            }
            if(trim(TRANS_NEWPASSWORD.value)=="")
            {
            alert("Enter the transaction new password");
            TRANS_NEWPASSWORD.focus();
            return false;
            }
        }
}
</script>    
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
<table width="100%" class="PageHdr">
  <tr>
    <td><strong>Change - Password</strong>
    <table width="50%" align="right">
  
  
</table>
    </td>
  </tr>
</table>    

<?php if(isset($err) && $err==1){ ?>
<div class="UpdateMsgWrap">
  <table width="100%" class="SuccessMsg">
    <tr>
      <td width="45"><img src="<?php echo base_url();?>images/icon-success.png" alt="" width="45" height="34" /></td>
      <td width="95%"><?php echo "Password changed Successfully.";?></td>
      </tr>
  </table>
</div>
   <?php } ?> 
<?php if(isset($err) && $err==2){ ?>
<div class="UpdateMsgWrap">
  <table width="100%" class="ErrorMsg">
    <tr>
      <td width="45"><img src="<?php echo base_url();?>images/icon-error.png" alt="" width="45" height="34" /></td>
      <td width="95%"><?php echo "Old Password mismatched.";?></td>
      </tr>
  </table>
</div>    
<?php } ?>     
<?php if(isset($err) && $err==3){ ?>
<div class="UpdateMsgWrap">
  <table width="100%" class="SuccessMsg">
    <tr>
      <td width="45"><img src="<?php echo base_url();?>images/icon-success.png" alt="" width="45" height="34" /></td>
      <td width="95%"><?php echo "Transaction Password Changed Successfully.";?></td>
      </tr>
  </table>
</div>
   <?php } ?>   
    
<?php if(isset($err) && $err==4){ ?>
<div class="UpdateMsgWrap">
  <table width="100%" class="ErrorMsg">
    <tr>
      <td width="45"><img src="<?php echo base_url();?>images/icon-error.png" alt="" width="45" height="34" /></td>
      <td width="95%"><?php echo "Transaction Old Password mismatched.";?></td>
      </tr>
  </table>
</div> 
   <?php } ?>       
    

    

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <form name="chgpwd" id="chgpwd" method="POST" action="" onsubmit="return password_validate(this,0);">
        <tr>
          <td>
         
        <table width="100%" cellpadding="10" cellspacing="10">
      <tr>
        <td width="40%"><span class="TextFieldHdr">Old Password:</span><br />
          <label>
          <input name="OLDPASSWORD" type="password" class="TextField" id="OLDPASSWORD" tabindex="1" maxlength="15" value="<?php if(isset($_REQUEST['OLDPASSWORD'])) echo $_REQUEST['OLDPASSWORD'];?>" />
          <span class="mandatory">*</span></label></td>
        
        <td width="40%"><span class="TextFieldHdr">New Password:</span><br />
          <label>
          <input name="NEWPASSWORD" type="password" class="TextField" id="NEWPASSWORD" tabindex="2" maxlength="15" value="<?php if(isset($_REQUEST['NEWPASSWORD'])) echo $_REQUEST['NEWPASSWORD'];?>" />
          <span class="mandatory">*</span></label></td>
      </tr>
      <tr>
        <td><input type="submit" name="Submit" id="Submit" class="button" value="Change" tabindex="3"  /></td>
      </tr>
    </table>
          </td>     
      </tr>
    </form>
    
    <form name="tchgpwd" id="tchgpwd" method="POST" action="<?php echo base_url();?>admin_home/change_password/" onsubmit="return transactionpassword_validate(this,0);">
    <tr>
        <td>
        <table width="100%" cellpadding="10" cellspacing="10">
      <tr>
        <td width="40%"><span class="TextFieldHdr">Transaction Old Password:</span><br />
          <label>
          <input name="TRANS_OLDPASSWORD" type="password" class="TextField" id="TRANS_OLDPASSWORD" tabindex="4" value="<?php if(isset($_REQUEST['TRANS_OLDPASSWORD'])) echo $_REQUEST['TRANS_OLDPASSWORD'];?>" maxlength="15" />
          </label></td>
        
        <td width="40%"><span class="TextFieldHdr">Transaction New Password:</span><br />
          <label>
          <input name="TRANS_NEWPASSWORD" type="password" class="TextField" id="TRANS_NEWPASSWORD" tabindex="5" value="<?php if(isset($_REQUEST['TRANS_NEWPASSWORD'])) echo $_REQUEST['TRANS_NEWPASSWORD'];?>" maxlength="15"  />
          </label></td>
      </tr>
      <tr>
        <td><input type="submit" name="Submit1" id="Submit1"  value="Change" tabindex="11"  /></td>
      </tr>
    </table>
          </td> 
    </tr>
    </form>
    
    </table>    
    
    
</div><!-- ContentWrap -->
</div>
</div>
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>