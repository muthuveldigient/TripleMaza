<?PHP //defined( '_JEXEC' ) or die( 'Restricted access' );?>
<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){	
	$('#top-up').validate({			
		rules: {
		p_name: {
      		required: true			
    	},
			adjust: {
      		required: true
    	},
		p_amount: {
      		required: true,
			number: true			
    	}											
  	},
	messages: {
	p_name: {
			required: "Please enter the name"			
		},
    	adjust: "Please select the adjust type",						
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
    	//.text('OK!').addClass('valid')
    	.closest('.control-group').removeClass('error').addClass('success');
  	},
	submitHandler: function(form) {
		$("#Submit").attr("disabled", true);
		form.submit();
	}	
 });
}); // end document.ready

function GetStateXmlHttpObject() {
	var xmlHttp=null;
	try {
  		// Firefox, Opera 8.0+, Safari
	    xmlHttp=new XMLHttpRequest();
  	} catch (e) {
		// Internet Explorer
	  	try {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
  	}
	return xmlHttp;
} 

function showuserbalance()
{	
	var p_name=document.getElementById('p_name').value;
	xmlHttp=GetXmlHttpObject()	
	var url='<?php echo base_url();?>partners/partners/showUserBalance';    	
	url=url+"?p_name="+p_name;			
	xmlHttp.onreadystatechange=Showbal;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
} 
function Showbal() 
{
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {       			
			var result=xmlHttp.responseText;            
            document.getElementById("userABalance").innerHTML=result;    
    }
} 
</script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
       
        <form method="post"  id="top-up" name="top-up" class="searchad_form" action="<?php echo base_url(); ?>partners/partners/adjust?rid=52">
          <?PHP 
		$pty=base64_decode($_GET['pty']);
		if($pty=="11") {                           
			$type="Main Agent";						
		} else if($pty=="12") { 					
			$type="Distributor";
		} else if($pty=="13") {
			$type="Sub.Distributor";
		} elseif($pty=="14")  {
			$type="Agent";
		}		
		?>
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong><?PHP echo $type; ?> Balance Adjustment </strong></td>
            </tr>
          </table>
           <?php if($_GET['msg']==6){ ?>
        <div id="UpdateMsgWrap" class="UpdateMsgWrap">
          <table width="100%" class="SuccessMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
              <td width="95%"><div id="showErrorMsg">Points adjusted successfully!</div></td>
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
        <?php if($_REQUEST['msg']=="15"){ ?>
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
        <?php if($_REQUEST['msg']=="16"){ ?>
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
        <?php if($_REQUEST['msg']=="10"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
                Username not exists.
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
            <tr>
              <td><table width="100%" cellpadding="10" cellspacing="10">
                  <tr>
<?php
//$dePartnerId = $this->encrypt->decode($_GET['pid']);
$dePartnerId = base64_decode($_GET['pid']);
?>
                  <?php //$dePartnerId = $this->encrypt->decode($_GET['pid']); ?>
                    <td width="40%" class="control-group"><span class="TextFieldHdr"><?PHP echo $type."&nbsp;Id"; ?> <span class="mandatory">*</span>:</span><br />
                      <input type="hidden"  class="TextField" id="p_name" name="p_name" readonly="readonly" value="<?PHP echo $this->partner_model->getPartnerNameById($dePartnerId); ?>" onchange='showuserbalance();' /> <?PHP echo $this->partner_model->getPartnerNameById($dePartnerId); ?>
                      <br/><br/><span id="userABalance"><b>Balance : <?PHP echo $this->partner_model->getPartnerBalance($dePartnerId); ?></b></span>
                      <input name="pty" type="hidden" id="pty"  value="<?PHP echo $_GET['pty'];?>"/>
                    </td>
                    <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">Adjust Type<span class="mandatory">*</span>:</span><br />
                      <?php $partneradjust =  base64_decode($_GET['adj']) ?>
                      <select class="cmbTextField" id="adjust" name="adjust">
                        <option value="">--Select--</option>
                        <option value="Add" <?php if($partneradjust == 'Add') echo 'selected="selected"'; ?>>Add</option>
                        <option value="Remove" <?php if($partneradjust == 'Remove') echo 'selected="selected"'; ?>>Remove</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">Points<span class="mandatory">*</span>:</span><br />
                      <input type="text"  class="TextField" id="p_amount" name="p_amount" value="<?PHP echo base64_decode($_GET['amt']); ?>" maxlength="10" />
                    </td>
                    <td width="40%" class="control-group"><span class="TextFieldHdr">Comments:</span><br />
                      <textarea id="comments" class="TextField" style="resize:none;" name="comments"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td width="33%"><table>
                        <tr>
                          <td><input name="submit" type="submit" id="Submit"  value="Adjust" style="float:left;"/>
                          </td>
                          <td><input class="reset" type="reset" id="reset" value="Reset" onClick="history.go(0)" />
                          </td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></td>
                    <td width="33%">&nbsp;</td>
                    <td width="33%">&nbsp;</td>
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
