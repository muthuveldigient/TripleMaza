<?PHP //defined( '_JEXEC' ) or die( 'Restricted access' );?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	/*var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		number: true
	};	*/
	$.validator.addMethod(
		"passwdfun",
	 	function(value, element, regexp) {
			var re = new RegExp(regexp);
		    return this.optional(element) || re.test(value);
	 	}		
	);
	$.validator.addMethod("notEqualTo", function(value, element, param) {
        return this.optional(element) || value != $(param).val();
        }
	);
		
	$('#cpass').validate({
		onkeyup:false,
		onchange:true,	
		rules: {			          
		old_pass: {
      		required: true
    	},
		new_pass: {
      		required: true,
			minlength: 6,
			maxlength:15,
			passwdfun: "((?=(.*[a-zA-Z].*))(?=(.*[0-9].*)))",
			notEqualTo: "#old_pass"
    	},
		cnew_pass: {
      		required: true,
			minlength: 6,
			maxlength:15,
			passwdfun: "((?=(.*[a-zA-Z].*))(?=(.*[0-9].*)))",
			equalTo: "#new_pass"
    	}									
  	},
	messages: {						
		old_pass: {
			required: "Please enter the old password"
		},
		new_pass: {
			required: "Please enter the new password",
			minlength: "New password length 6-15 characters",
			maxlength: "New password length 6-15 characters",						
			passwdfun:"New password must be an alphanumeric!",
			notEqualTo:"Old password and new password is same!"
		},
		cnew_pass: {
			required: "Please enter the confirm new password",
			equalTo: "New password and confirm new password mismatched",
			minlength: "Confirm new password length 6-15 characters",
			maxlength: "Confirm new password length 6-15 characters",
			passwdfun:"Confirm new password must be an alphanumeric!"
		}						
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.text('OK!').addClass('valid')
    	.closest('.control-group').removeClass('error').addClass('success');
  	},
 });
 
 	$('#ctranspass').validate({
		onkeyup:false,
		onchange:true,	
		rules: {			          
		old_trans_pass: {
      		required: true
    	},
		new_trans_pass: {
      		required: true,
			minlength: 6,
			maxlength:15,
			passwdfun: "((?=(.*[a-zA-Z].*))(?=(.*[0-9].*)))",
			notEqualTo: "#old_trans_pass"
    	},
		cnew_trans_pass: {
      		required: true,
			minlength: 6,
			maxlength:15,
			passwdfun: "((?=(.*[a-zA-Z].*))(?=(.*[0-9].*)))",
			equalTo: "#new_trans_pass"
    	}									
  	},
	messages: {						
		old_trans_pass: {
			required: "Please enter the old password"
		},
		new_trans_pass: {
			required: "Please enter the new password",
			minlength: "New password length 6-15 characters",
			maxlength: "New password length 6-15 characters",						
			passwdfun:"New password must be an alphanumeric!",
			notEqualTo:"Old password and new password is same!"
		},
		cnew_trans_pass: {
			required: "Please enter the confirm new password",
			equalTo: "New password and confirm new password mismatched",
			minlength: "Confirm new password length 6-15 characters",
			maxlength: "Confirm new password length 6-15 characters",
			passwdfun:"Confirm new password must be an alphanumeric!"
		}						
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.text('OK!').addClass('valid')
    	.closest('.control-group').removeClass('error').addClass('success');
  	},
 });
 
}); // end document.ready
</script>
<script language="javascript" type="text/javascript">
function clearFrmValues() {
	$('#cpass').each(function() {
	  $('label.error').css({'display': 'none'});
	});	
}
function clearTransFrmValues() {
	$('#ctranspass').each(function() {
	  $('label.error').css({'display': 'none'});
	});	
}
</script>
<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
       <?php if($_GET['msg']==11){ ?>
        <div id="UpdateMsgWrap" class="UpdateMsgWrap">
          <table width="100%" class="SuccessMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
              <td width="95%"><div id="showErrorMsg">Password changed successfully!.</div></td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <?php if($_REQUEST['msg']=="12"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
               Incorrect old password entered!.
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <?php if($_REQUEST['msg']=="13"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
               Old Password and New Password is same!.
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <form  name="cpass" method="post" id="cpass" action="<?php echo base_url(); ?>partners/partners/changePass?rid=56">
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Change Password</strong></td>
            </tr>
          </table>
          <table width="100%" class="searchWrap" bgcolor="#993366">
            <tr>
              <td colspan="3"><table width="100%" class="PageHdr">
                  <tr>
                    <td><strong>Change Password Information</strong></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td colspan="3"><table width="100%" cellpadding="10" cellspacing="10">
                  <tr>
                    <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">Old Password<span class="mandatory">*</span>:</span><br />
                      <input type="password" id="old_pass"  name="old_pass" class="TextField" style="width:20%"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="40%" class="control-group"><span class="TextFieldHdr">New Password<span class="mandatory">*</span>:</span><br />
                      <input type="password" id="new_pass"  name="new_pass" class="TextField" style="width:20%"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="40%" class="control-group"><span class="TextFieldHdr">Confirm New Password<span class="mandatory">*</span>:</span><br />
                      <input type="password" id="cnew_pass"  name="cnew_pass"  class="TextField" style="width:20%"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="33%" class="control-group"><input type="submit" id="submitc"  name="submitc"  class="sub_btn" value="Update"/>
                      &nbsp;&nbsp;
                      <input type="reset" id="reset"  name="reset" class="sub_btn"  value="Reset" onclick="javascript:clearFrmValues();"/>
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form>
        <form  name="ctranspass" method="post" id="ctranspass" action="<?php echo base_url(); ?>partners/partners/changeTransPass?rid=56">
        	<table width="100%" class="searchWrap" bgcolor="#993366">
         
            <tr>
              <td colspan="3"><table width="100%" cellpadding="10" cellspacing="10">
                  <tr>
                    <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">Old Transaction Password<span class="mandatory">*</span>:</span><br />
                      <input type="password" id="old_trans_pass"  name="old_trans_pass" class="TextField" style="width:20%"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="40%" class="control-group"><span class="TextFieldHdr"> New Transaction Password<span class="mandatory">*</span>:</span><br />
                      <input type="password" id="new_trans_pass"  name="new_trans_pass" class="TextField" style="width:20%"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="40%" class="control-group"><span class="TextFieldHdr">Confirm New Transaction Password<span class="mandatory">*</span>:</span><br />
                      <input type="password" id="cnew_trans_pass"  name="cnew_trans_pass"  class="TextField" style="width:20%"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="33%" class="control-group"><input type="submit" id="submitc"  name="submitc"  class="sub_btn" value="Update"/>
                      &nbsp;&nbsp;
                      <input type="reset" id="reset"  name="reset" class="sub_btn"  value="Reset" onclick="javascript:clearTransFrmValues();"/>
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("common/footer"); ?>
