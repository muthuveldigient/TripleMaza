<script language="javascript" type="text/javascript">
/* THIS IS TO ACTIVATE & DEACTIVATE USERS */
function activatedeaUser(curStatus,partnerID,newStatus,pType) {	
	if(curStatus == 1){
		if(confirm("Do you really want to unauthenticate this user? If so all the details related to this user will get unauthenticated"))
		{	
			xmlHttp=GetStateXmlHttpObject();
			if(xmlHttp==null) {
				alert ("Your browser does not support AJAX!");
				return;
			} 
			var url="<?php echo base_url();?>partners/partners/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus+"/"+pType;			
			xmlHttp.onreadystatechange=changeActivePartnerStatus;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
  }else{ 
       xmlHttp=GetStateXmlHttpObject();
		if(xmlHttp==null) {
			alert ("Your browser does not support AJAX!");
			return;
		} 
		var url="<?php echo base_url();?>partners/partners/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus+"/"+pType;	
		//alert(url);
		xmlHttp.onreadystatechange=changeActivePartnerStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
  }
}

function changeActivePartnerStatus() { 
	if (xmlHttp.readyState==4) {	  
		var respValue = xmlHttp.responseText.split("_");		
		document.getElementById('activatede_'+respValue[1]).innerHTML=respValue[0];
	}
}

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
</script>
<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
<script language="javascript" type="text/javascript">
/* jQuery.validator.addMethod("passwdfun",function(value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Password must be an alphanumeric!" 
);
 */	
  
$(document).ready(function(){	

 $.validator.addMethod("noSpace", function(value, element) { //Code used for blank space Validation 
		return value.indexOf(" ") < 0 && value != ""; 
    }, "Space not allowed and don't leave it empty"); 
 $.validator.addMethod("passwdfun", function (value) {
	return /[\?\$\!\@\#\%\&\*\+\=]/.test(value) && /[a-z]/.test(value) && /[0-9]/.test(value) && /[A-Z]/.test(value)
});

$.validator.addMethod("passfwd",
	   function (value, element) {
		var alphabetsOnlyRegExp = new RegExp("^[a-zA-Z0-9#%*+=@&!?$]+$");
		if ( alphabetsOnlyRegExp.test(element.value) && /[\?\$\!\@\#\%\&\*\+\=]/.test(element.value) && /[a-z]/.test(element.value) && /[0-9]/.test(element.value) && /[A-Z]/.test(element.value) ) {
	   return true;
		} else {
	   return false;
		}
	   },
	 "Password must be Ex: (Example@2)"
	 );
	 
	$('#view-user').validate({			
		rules: {		
		u_password: {
      		required: true,
			minlength: 8,
			maxlength: 12,
			passfwd: true						
    	}											
  	},
	messages: {							
		u_password: {
			required: "Enter the password",
			passfwd:"Password must be Ex: (Example@2)"		
		}					
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.text('OK!').addClass('valid')
    	.closest('.control-group').removeClass('error').addClass('success');
		var pass = btoa($('#u_password').val());
		$('#password_hidden').val(pass)
  	},
 });
}); // end document.ready


function show() {	
	document.getElementById("hide").style.display="block";
	document.getElementById('show').style.display="none";	    	
}
function hide() {   
	document.getElementById('show').style.display="none";	      
}

function showBalance() {	
	if(document.getElementById('showB').style.display=='none') {
		document.getElementById('showB').style.display="block";	    	
	}else{
		document.getElementById('showB').style.display="none";
	}	
}

function hideBalance() {   
	document.getElementById('showB').style.display="none";	      
}

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
    	},
		comments: {
      		required: true					
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
		},
		comments: "Please enter the comments"					
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
		$("#submit").attr("disabled", true);
		form.submit();
	}	
 });
}); // end document.ready

$(document).ready(function() {
        // Tooltip only Text
        $('.masterTooltip').hover(function(){
                // Hover over code
                var title = $(this).attr('title');
                $(this).data('tipText', title).removeAttr('title');
                $('<p class="tooltip"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function() {
                // Hover out code
                $(this).attr('title', $(this).data('tipText'));
                $('.tooltip').remove();
        }).mousemove(function(e) {
                var mousex = e.pageX + 40; //Get X coordinates
                var mousey = e.pageY + 10; //Get Y coordinates
                $('.tooltip')
                .css({ top: mousey, left: mousex })
        });
});
</script>

<style type="text/css">


.tooltip {
 display:none;
 position:absolute;
 border:1px solid #333;
 background-color:#161616;
 border-radius:5px;
 padding:10px;
 color:#fff;
 font-size:12px Arial;
}
.info{
	padding-left: 5px;
	position: absolute;
}
</style>
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
       
       <?php if($_GET['msg']==15){ ?>
        <div id="UpdateMsgWrap" class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%"><div id="showErrorMsg">Account is deactivated. You cannot transfer points!</div></td>
            </tr>
          </table>
        </div>
        <?php } ?>
        
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Personal Information</strong></td>
          </tr>
        </table>
        <?php if($this->session->flashdata('message')) { ?>
        <table width="100%" class="SuccessMsg">
          <tbody>
            <tr>
              <td width="45"><img width="45" height="34" alt="" src="http://dev.nucasino.com/platform/static/images/icon-success.png"></td>
              <td width="95%"><?php echo $this->session->flashdata('message');?></td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
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
              <td width="95%"><?PHP if($_GET['msg']==7) { ?>
                Points exceeds agent's available balance.
                <?PHP }  ?>
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
              <td width="95%"><?PHP if($_GET['msg']==8) { ?>
                Please try again.
                <?PHP }  ?>
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
              <td width="95%"><?PHP if($_GET['msg']==9) { ?>
                Username not exists.
                <?PHP }  ?>
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <?php 
			$hidden = array('USER_ID'=>$userDetails[0]->USER_ID);
			$attributes = array('id' => 'view-user');
			echo form_open('partners/partners/updatepwd',$attributes,$hidden);
		?>
        <table width="100%" class="searchWrap" bgcolor="#993366">
          <tr>
            <td colspan="3"><table width="100%" cellpadding="12" cellspacing="12">
                <tr>
                  <td width="33%" class="control-group"><span class="TextFieldHdr"> <?php echo form_label('User Name:', 'Username');?> </span>
                    <?php										
                                       echo $userDetails[0]->USERNAME;			
                                    ?>                  </td>
									<?php 
$info = "(၁)passwordကို စာလံုး ၈လံုးမွ ၁၂ အထိထားရပါမယ္

(၂)#,%,*,+,=,@,&,$,?,! တစ္ခုခုပါရပါမယ္

(၃)အဂၤလိပ္စာလံုးအႀကီးတစ္လံုး အနဲဆံုးတစ္ခုပါရပါမယ္

(၄)နံပါတ္ တစ္လံုးအနဲဆံုးပါရပါမယ္

မိမိအေကာင့္လံုျခံဳမွဳသည္ မိမိေပၚတြင္သာ မူတည္ပါသည္";
					?>
                  <td width="33%" ><span class="TextFieldHdr style18 control-group"> <?php echo form_label('Password<span class="mandatory">*</span> <img class="info" src="'.base_url().'static/images/info.png" class="masterTooltip" title="'.$info.'" /> :', 'Password');?> </span>
                   <span id="hide" style="display:none;"> <?php
																		
                                        $Password = array(
                                              'name'        => 'u_password',
                                              'id'          => 'u_password',
											  'type'		=> 'password',
											  'value'		=> 'digient',											 
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '16'
                                            );		
                                        echo form_input($Password);			
                                    ?>
									<input type="hidden" id="password_hidden" name="password_hidden"/>
                                    <?php
                            echo form_submit('frmSubmit', 'Save')."&nbsp;";                           
                        ?></span>
                        <span id="show"><?PHP echo "**********"; ?><a href="javascript:;" onclick="javascript:show()"><img height="16" width="16" src="<?PHP echo base_url();?>static/images/edit-img.png" title="Edit"></a></span>                  </td>
                  <td width="33%" class="control-group"></td>
                </tr>
                <tr>
                  <td width="33%" class="control-group"><span class="TextFieldHdr style2"> <?php echo form_label('Distributor:', 'Distributor');?> </span>
                    <?php									
									 $arr=explode('/',$this->partner_model->getNameOfPartnerIds($userDetails[0]->PARTNER_ID));
									 echo $arr['0'];								      		
                                    ?>                  </td>
                  <td width="33%" class="control-group"><span class="TextFieldHdr style17"> <?php echo form_label('Sub.Distributor:', 'Sub.Distributor');?> </span>
                    <?php
									  echo $arr['1'];								      		
                                    ?>                  </td>
                  <td width="33%"><span class="TextFieldHdr style19"> <?php echo form_label('Agent:', 'Agent');?> </span>
                    <?php
										echo $this->partner_model->getPartnerNameById($userDetails[0]->PARTNER_ID);
                                    ?>                  </td>
                </tr>
                <tr>
                  <td width="33%" id="newUserName" class="control-group"><span class="TextFieldHdr style15"> <?php echo form_label('Registration Date:', 'Registration Date');?> </span>
                    <?php										
                                        echo $userDetails[0]->REGISTRATION_TIMESTAMP;		
                                    ?>
                    <div id="userExtError"></div></td>
                  <td width="33%" class="control-group"><span class="TextFieldHdr style16"> <?php echo form_label('Status:', 'Status');?> </span>
                    <?php																
                                        if($userDetails[0]->ACCOUNT_STATUS==1) 
										echo "Active";
										else
										echo "Deactive"		;
                                    ?>                  </td>
                  <td width="33%"><span class="TextFieldHdr style20"> <?php echo form_label('Manage Status :', 'ManageStatus');?> </span>
                    <?php
									if($userDetails[0]->ACCOUNT_STATUS=="1")
									echo '<span id="activatede_'.$userDetails[0]->USER_ID.'"><a href="#" onclick="javascript:activatedeaUser(1,'.$userDetails[0]->USER_ID.',0,0)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a></span>';	
									else 
									echo '<span id="activatede_'.$userDetails[0]->USER_ID.'"><a href="#" onclick="javascript:activatedeaUser(0,'.$userDetails[0]->USER_ID.',1,0)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a></span>';			
                                    ?>                  </td>
                </tr>
              </table></td>
          </tr>
        </table>
        <?php
              echo form_close();			
			?>
        </td>
        </tr>       
        <tr>
          <td colspan="3"><table width="100%" class="ContentHdr">
              <tr>
                <td><strong>Manage Balance</strong></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="3">
          <table width="100%" id="rolesandPermissions" class="rolesandPermissions">
              <tr>
                <td>Balance: <?PHP echo $userDetails[0]->USER_TOT_BALANCE; ?></td>
                <?php if($this->session->userdata('partnerid')!=1){?>
                <td class="ink">Adjust Balance: <?PHP echo '<a href="javascript:;" onclick="javascript:showBalance();">Manage</a>' ?></td>
                <?php } ?>
              </tr>
            </table>
            <span id="showB" style="display:none;">
          <form method="post"  id="top-up" name="top-up" class="searchad_form" action="<?php echo base_url(); ?>partners/partners/userAdjust?rid=51" >  
          <input type="hidden" value="<?PHP echo $userDetails[0]->USER_ID; ?>" name="userId" id="userId"  />
          <input type="hidden" value="<?PHP echo $userDetails[0]->USERNAME; ?>" name="p_name" id="p_name"  />
               
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong><?PHP echo $type; ?> Balance Adjustment </strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
            <tr>
              <td><table width="100%" cellpadding="10" cellspacing="10">
                  <tr>                    
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
                    <td width="40%" valign="top" class="control-group"><span class="TextFieldHdr">Amount<span class="mandatory">*</span>:</span><br />
                      <input type="text"  class="TextField" id="p_amount" name="p_amount" value="<?PHP echo base64_decode($_GET['amt']); ?>" maxlength="10"/>
                    </td>
                    <td width="40%" class="control-group"><span class="TextFieldHdr">Comments:</span><br />
                      <textarea id="comments" class="TextField" style="resize:none;" name="comments"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td width="33%"><table>
                        <tr>
                          <td><input name="submit" type="submit" id="submit"  value="Adjust" style="float:left;"/>
                          </td>
                          <td><input class="reset" type="button" id="reset" value="Cancel" onclick="javascript:hideBalance();" />
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
        </span>
            </td>
        </tr>
        <tr>
          <td colspan="3"><table width="100%" class="ContentHdr">
              <tr>
                <td><strong>Transaction</strong></td>
              </tr>
            </table></td>
        </tr>
		
		<?php
			$data["USER_ID"]=$userDetails[0]->USER_ID;
			$data["GAME_ID"]=1;	//caino games
			$getCasinoData='';//$this->partner_model->getGameBetWinData($data);
		?>
		<tr>
		   <td colspan="3">
			  <table width="100%" id="rolesandPermissions" class="rolesandPermissions">
				 <tr>
					<td>Play Points:<?php if(!empty($getCasinoData->totalbets)) echo $getCasinoData->totalbets; else echo "0.00";?>
					</td>
					<td class="ink">Win Points:<?php if(!empty($getCasinoData->totalwins)) echo $getCasinoData->totalwins; else echo "0.00";?>
					</td>
				 </tr>
				 <tr>
					<td>Margin:
					<?php
						if(!empty($getCasinoData->totalmargin)) echo $getCasinoData->totalmargin; else echo "0.00";
						$ecUserId = base64_encode($userDetails[0]->USER_ID);
					?>
					</td>
					<td class="ink">
					   <!-- <a href="<?php echo base_url(); ?>reports/agent_ledger/ledgerUserHistory?userid=<?PHP echo $ecUserId; ?>">Ledger</a> -->
					   <!--<a href="<?php echo base_url(); ?>reports/agent_ledger/ledgerhistory/<?PHP //echo $userDetails[0]->USERNAME; ?>?rid=58">Ledger</a>-->
					</td>
				 </tr>
			  </table>
		   </td>
		</tr>
		
		<?php
			$data1["USER_ID"]=$userDetails[0]->USER_ID;
			$data1["GAME_ID"]=0;	//caino games
			$getShanData='';//$this->partner_model->getGameBetWinData($data1);
		?>
<!--		<tr>
		   <td colspan="3">
			  <table width="100%" id="rolesandPermissions" class="rolesandPermissions">
				 <tr>
					<td>Shan Play Points:<?php if(!empty($getShanData->totalbets)) echo $getShanData->totalbets; else echo "0.00";?>
					</td>
					<td class="ink">Shan Win Points:<?php if(!empty($getShanData->totalbets)) echo $getShanData->totalbets; else echo "0.00";?>
					</td>
				 </tr>
				 <tr>
					<td>Shan Margin:
					<?php
						if(!empty($getShanData->totalmargin)) echo $getShanData->totalmargin; else echo "0.00";
						$ecUserId = base64_encode($userDetails[0]->USER_ID);
					?>
					</td>
					<td class="ink">&nbsp;</td>
				 </tr>
			  </table>
		   </td>
		</tr>-->
                
        </table>
        
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("common/footer"); ?>
