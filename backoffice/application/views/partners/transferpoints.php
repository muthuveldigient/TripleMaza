<?PHP //defined( '_JEXEC' ) or die( 'Restricted access' );?>
<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){	
	$('#top-up').validate({			
		rules: {		
		p_amount: {
      		required: true,
			number: true			
    	}											
  	},
	messages: {							
		p_amount: {
			required: "Please enter the amount",
			number: "Please enter the numeric only"
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
	submitHandler: function(form) {
		$("#Submit").attr("disabled", true);
		form.submit();
	}	
 });
}); // end document.ready

</script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
        <?php $ecPatid = base64_encode($pid); ?>
        <form method="post"  id="top-up" name="top-up" class="searchad_form" action="<?php echo base_url(); ?>partners/partners/transferPoints/?pid=<?PHP echo $ecPatid;?>&rid=51">
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Transfer Points</strong> </td>
            </tr>
          </table>
          <?php if($_GET['msg']==6){ ?>
        <div id="UpdateMsgWrap" class="UpdateMsgWrap">
          <table width="100%" class="SuccessMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
              <td width="95%"><div id="showErrorMsg">Points transfered successfully!</div></td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <?php if($_REQUEST['msg']=="7"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
                 Points exceeds your's available balance.
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
         <?php if($_REQUEST['msg']=="50"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
                 Account is deactivated. You cannot transfer points!
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        
         <?php if($_REQUEST['msg']=="51"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
                 Points should be greater than zero!
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap"> 
          <tr> 
            <td><table width="100%" cellpadding="10" cellspacing="10"> 
              <tr>
                <td width="40%" class="control-group">Name : <?php echo $username; ?>
                  <br /><br />
                  <span id="userABalance">Balance : <?php echo $points; ?></span></td>               
              </tr>
              <tr>
                <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">Points<span class="mandatory">*</span>:</span><br />
                  <input type="text"  class="TextField" id="p_amount" name="p_amount" maxlength="10"/>
                </td>
                <!--<td width="40%" class="control-group"><span class="TextFieldHdr">Comments:</span><br />
                  <textarea id="comments" class="TextField" maxlength="15" style="resize:none;" name="comments"></textarea>
                </td>-->
              </tr>
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="submit" type="submit" id="Submit"  value="Transfer" style="float:left;"  />
                    <input name="adjust" type="hidden" id="adjust"  value="Add"/>
                    <input name="pid" type="hidden" id="pid"  value="<?PHP echo $ecPatid;?>"/>
        
        </td>
        <td><input class="reset" type="reset" id="reset" value="Reset" onClick="history.go(0)" />
          </form></td>
        <td>&nbsp;</td>
        </tr>
        </table>
        </td>
        <td width="33%">&nbsp;</td>
        <td width="33%">&nbsp;</td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("common/footer"); ?>