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
		p_amount: {
      		required: true,
			number: true			
    	}											
  	},
	messages: {
	p_name: {
			required: "Please enter the name"			
		},									
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
//	alert(p_name);
	xmlHttp=GetXmlHttpObject()	
	var url='<?php echo base_url();?>partners/partners/showBalance';    	
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
        <?php if($_GET['msg']=="6"){ ?>
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
                Points exceeds agent's available balance.
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
         <?php if($_REQUEST['msg']=="8"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
                Please try again.
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <?php if($_REQUEST['msg']=="9"){ ?>
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
         <?php if($_REQUEST['msg']=="50"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
                 Account is deactivated. You cannot transfer the points.
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
        
        <form method="post"  id="top-up" name="top-up" class="searchad_form" action="<?php echo base_url(); ?>partners/partners/fnTransferPointsAll?rid=52">
		<input type="hidden" name="current_user_session_id" value="<?php echo $this->session->userdata('session_id');?>"  />
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Transfer Points</strong> </td>
            </tr>
          </table>
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap"> 
          <tr> 
            <td><table width="100%" cellpadding="10" cellspacing="10"> 
              <tr>
               <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">To<?PHP if($userName=='') { ?><span class="mandatory">*</span> <?PHP } ?>:</span>
               <?PHP 
			 
			   
			   if($userName!='') {
			   				echo base64_decode($userName);
							
							//echo $userId; die;
							?><br /><br />
                            <input type="hidden" id="p_name" name="p_name" value="<?PHP echo base64_decode($userName); ?>"/>
                            <span><b>Balance: <?PHP echo $this->partner_model->getUserBalance(base64_decode($userId)); ?></b></span> 
                            <?PHP 
						} else {					
			   ?><br />
                 <input type="text"  class="TextField" id="p_name" name="p_name" onchange='showuserbalance();'/><br />               
                 <span id="userABalance"></span>                 
                 <?PHP } ?>
                </td>                              
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
                    <td>
                    <input name="partnertransaction_password" type="hidden" value="<?php echo $_POST['partnertransaction_password']; ?>">
                    <input name="submit" type="submit" id="Submit"  value="Transfer" style="float:left;"  />
                    <input name="adjust" type="hidden" id="adjust"  value="Add"/>
                    <input name="pid" type="hidden" id="pid"  value="<?PHP echo $pid;?>"/>
        
        </td>
        <td><input class="reset" type="reset" id="reset" value="Reset" onClick="history.go(0)"/>
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