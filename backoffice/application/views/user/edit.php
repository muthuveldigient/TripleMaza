<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<style>
/* New styles below */
label.valid {
  /*background: url(assets/img/valid.png) center center no-repeat;*/
  display: inline-block;
  text-indent: -9999px;
}
label.error {
	color: #FF0000;
    font-weight: normal;
    left: -8px;
    margin-top: -5px;
    padding: 0 9px;
    position: relative;
    top: 3px;
	float:left;
}
</style>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>    
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		email: true
	};
	$('#EditForm').validate({
		rules: {
		USERNAME: ruleSet1,
		EMAIL: ruleSet2,
		PASSWORD: ruleSet1,
		DOB: ruleSet1
		
  	},
	messages: {
    	USERNAME: "Enter username ",
		EMAIL: "Enter valid email id",
		PASSWORD: "Enter password",
		DOB: "Enter DOB"
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.closest('.control-group').removeClass('error').addClass('success');
  	}
 });
}); // end document.ready
</script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
    <?php $userid = $this->uri->segment(4, 0); ?>
    <form name="EditForm" method="post" id="EditForm" action="<?php echo base_url(); ?>user/account/edit/<?php echo $userid; ?>?rid=10">
      <table width="100%" class="ContentHdr">
        <tr>
          <td><strong>Edit : <span class="style1" style="color:#FFFFFF"><?php echo ucfirst($results->USERNAME); ?></span></strong>
            <table width="50%" align="right">
              <tr>
                <!--<td><div align="right"><a class="dettxt" href="<?php //echo base_url(); ?>user/account/search">Players List</a></div></td>-->
              </tr>
            </table></td>
        </tr>
      </table>
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>        
      <?php if(isset($_REQUEST['err']) && $_REQUEST['err']!="1"){
	  
	   ?>
      <div class="UpdateMsgWrap">
      <table width="100%" class="ErrorMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
          <td width="95%">
			<?PHP if($_GET['err']==2) { ?>
            Email already exists
            <?PHP }  ?>
            <?PHP if($_GET['err']==3) { ?>
            Username already exists
            <?PHP }  ?>
            <?PHP if($_GET['err']==4) { ?>
            Top up amount exceeds available balance
            <?PHP }  ?>
            <?PHP if($_GET['err']==6) { ?>
            Special characters are not allowed in amount
            <?php } ?>
            <?php if($_GET['err']==11){ ?>
            Something went wrong... Please try again.
             <?php }  ?>
            <?PHP if($_GET['err']==7) { ?>
            You Must Need To Select Main Agent.
            <?php } ?>
        </div>
       
        </td>
        
        </tr>
        
      </table>
      </div>
      <?php } ?>        
<?php 
  if($msg != ''){  ?>
	 <div class="UpdateMsgWrap">
	  <table width="100%" class="SuccessMsg">
		<tr>
		  <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
		  <td width="95%"><?php echo "User information updated successfully"; ?>!!!</td>
		  </tr>
	  </table>
	</div>
<?php } ?>

         <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
      		<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td><table width="100%" class="PageHdr">
              <tr>
                <td><strong>Personal Information</strong></td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">Player Name:</span><span id="usernamespan" class="mandatory">*</span><br />
                  <label>
                    <input name="USERNAME" type="text" class="TextField" id="USERNAME" tabindex="1" maxlength="30" value="<?php echo $results->USERNAME; ?>" />
                   </label></td>
                <td width="40%"><span class="TextFieldHdr">Email:</span><span id="emailspan" class="mandatory">*</span><br />
                  <label>
                  <input name="EMAIL" type="text" class="TextField" id="EMAIL" tabindex="2" maxlength="30" value="<?php echo $results->EMAIL_ID; ?>" />
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Password:</span> <span id="passwordspan" class="mandatory">*</span><br />
                  <label>
                  <input name="PASSWORD" type="password" class="TextField" id="PASSWORD" tabindex="3" maxlength="15" value="1234567890" />
                 </label></td>
              </tr>
              <?php //need to check role ?>
              <tr>
                <td width="40%"><span class="TextFieldHdr">Gender:</span><br />
                  <select name="GENDER" class="ListMenu" id="GENDER" onchange="showstate(this.value);" tabindex="4" >
                    <!--<option>------------- Select Gender ------------</option>-->
                    <option <?PHP if($results->GENDER == 'male') echo 'selected="selected"'; ?> value="male">Male</option>
                    <option <?PHP if($results->GENDER == 'female') echo 'selected="selected"'; ?> value="female">Female</option>
                  </select>
                </td>
                <td width="40%"><span class="TextFieldHdr">DOB:</span> <span id="dobspan" class="mandatory">*</span><br />
                  <label>
                  <input name="DOB" type="text" class="TextField" id="DOB" tabindex="3" maxlength="15" value="<?php echo $results->DATE_OF_BIRTH;  ?>" style="float:left" />
                 </label><a onclick="NewCssCal('DOB','ddmmyyyy')" style="float:left;position:absolute;" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>               
              </tr>
            </table>
        </tr>
      </table>
           </td>
          </tr>
          <tr>
          <td>
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td><table width="100%" class="PageHdr">
              <tr>	
                <td><strong>Contact Information</strong></td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">First Name:</span><br />
                  <label>
                  <input name="FIRST_NAME" type="text" class="TextField" id="FIRST_NAME" tabindex="5" maxlength="30" value="<?php if($results->FIRSTNAME != 'none') echo $results->FIRSTNAME; ?>" />
                   </label></td>
                <td width="40%"><span class="TextFieldHdr">Last Name:</span><br />
                  <label>
                  <input name="LAST_NAME" type="text" class="TextField" id="LAST_NAME" tabindex="6" maxlength="30" value="<?php if($results->LASTNAME != 'none') echo $results->LASTNAME; ?>" />
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Contact No:</span> 
                <br />
                  <label>
                  <input name="CONTACT" type="text" class="TextField" id="CONTACT" tabindex="7" maxlength="15" value="<?php  echo $results->CONTACT; ?>" />
                 </label></td>
              </tr>
              <?php //need to check role ?>
    
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">Country:</span><br />
                  <select name="PARTNER_COUNTRY" class="ListMenu" id="PARTNER_COUNTRY" onchange="showstate(this.value);" tabindex="8" >
                    <option>------------- Select Country ------------</option>
                    <?php
                           $countryList = $this->common_model->getCountriesList();
                           foreach($countryList as $country){
                           ?>
                    <option value="<?php echo $country->CountryName;?>" <?php if($country->CountryName=="India"){ echo "selected"; }else{ if($_REQUEST['PARTNER_COUNTRY']==$country->CountryName) echo "selected";}?> ><?php echo $country->CountryName;?></option>
                    <?php
                           }
                           ?>
                  </select>
                </td>
                <td width="40%"><span class="TextFieldHdr">State:</span><br />
                  <select name="PARTNER_STATE" id="PARTNER_STATE" class="ListMenu" tabindex="9">
                    <option value=''>------------- Select State -------------</option>
                    <?php
                       $stateList = $this->common_model->getStateList();
                       foreach($stateList as $state){
                       ?>
                    <option <?php if($state->StateName == $results->STATE) echo 'selected="selected"'; ?>  value="<?php echo $state->StateName;?>"><?php echo ucfirst(strtolower($state->StateName));?></option>
                    <?php
                       }
                       ?>
                  </select>
                </td>
                <td width="40%"><span class="TextFieldHdr">City:</span><br />
                  <label>
                  <input name="PARTNER_CITY" type="text" class="TextField" id="PARTNER_CITY" maxlength="64" tabindex="10" value="<?php if($results->CITY != 'none') echo $results->CITY; ?>"  />
                  </label></td>
              </tr>
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">Street:</span><br />
                  <label>
                  <input name="PARTNER_STREET" type="text" class="TextField" id="PARTNER_STREET" maxlength="64" tabindex="11" value="<?php if($results->STREET != 'none') echo $results->STREET; ?>"  />
                </td>
                <td width="40%"><span class="TextFieldHdr">Address:</span><br />
                   <label>
                  <input name="ADDRESS" type="text" class="TextField" id="ADDRESS" maxlength="64" tabindex="12" value="<?php echo $results->ADDRESS; ?>"  />
                </td>
                <td width="40%"><span class="TextFieldHdr">Zip Code:</span><br />
                  <label>
                  <input name="ZIPCODE" type="text" class="TextField" id="ZIPCODE" maxlength="64" tabindex="13" value="<?php echo $results->ZIPCODE; ?>"  />
                  </label></td>
              </tr>
              <tr>
                <td width="40%"></td>
                <td width="40%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
              </tr>
              <tr>
                <td>
                
                
                  </td>	
              </tr>
            </table>
     
          <table>
               <td> <input type="hidden" name="oriPassword" id="oriPassword"  value="<?php echo $results->PASSWORD; ?>" />
                <input type="submit" name="Submit" id="Submit"  value="Update"/></form></td>
               <td> <form name="CancelForm" method="post" id="CancelForm" action="<?php echo base_url(); ?>user/account/detail/<?php echo $userid; ?>?rid=10">
                  <input type="submit" id="reset" class="button" value="Cancel" /></form></td>
                  <td>&nbsp;</td>
                  </table>
                          </tr>
      </table>
          </td>
          </tr>
        </tr>
      </table>                  
           </td>
          </tr>           
         </table>
  </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>
