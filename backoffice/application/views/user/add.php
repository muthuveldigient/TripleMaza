<script language="javascript">
function showdistributors(disid){
	 xmlHttp3=GetXmlHttpObject()
    var url='<?php echo base_url()."user/ajax/distributorlist"?>';    
	url=url+"?disid="+disid;
	xmlHttp3.onreadystatechange=Showdis
	xmlHttp3.open("GET",url,true);
    //xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp3.send(null);
    //loader(0);
	return false;
}

function showagents(disid)
{
   xmlHttp3=GetXmlHttpObject()
   var url='<?php echo base_url()."user/ajax/agents"?>';    
   url=url+"?disid="+disid;
   xmlHttp3.onreadystatechange=Showagents
   xmlHttp3.open("GET",url,true);
   xmlHttp3.send(null);
   return false;
}

function showsubagents (disid){
   xmlHttp3=GetXmlHttpObject()
   var url='<?php echo base_url()."user/ajax/subagentlist"?>';    
   url=url+"?disid="+disid;
   xmlHttp3.onreadystatechange=Showsubagent
   xmlHttp3.open("GET",url,true);
   xmlHttp3.send(null);
   return false;
}

function Showagent() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    { 		
            var result=xmlHttp3.responseText;
            
            var disptext='';
            if(trim(result)=='Agentnotexist'){
                disptext='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="ListMenu" tabindex="4"><option value=""></option></select>';
            }else{
                disptext=result;
            }
            document.getElementById("disagents_list").innerHTML=disptext;    
    }

} 

function Showdis() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    { 		
            var result=xmlHttp3.responseText;
            
            var disptext='';
            if(trim(result)=='Agentnotexist'){
                disptext='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="ListMenu" tabindex="4"><option value=""></option></select>';
            }else{
                disptext=result;
            }
            document.getElementById("distributors").innerHTML=disptext;    
    }

} 

function Showagents() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    { 		
            var result=xmlHttp3.responseText;
            
            var disptext='';
            if(trim(result)=='Agentnotexist'){
                disptext='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="ListMenu" tabindex="4"><option value=""></option></select>';
            }else{
                disptext=result;
            }
            document.getElementById("agents").innerHTML=disptext;    
    }

} 

function Showsubagent() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    { 		
            var result=xmlHttp3.responseText;
            
            var disptext='';
            if(trim(result)=='Agentnotexist'){
                disptext='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="ListMenu" tabindex="4"><option value=""></option></select>';
            }else{
                disptext=result;
            }
            document.getElementById("subagents").innerHTML=disptext;    
    }

} 

</script>
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
	$('#regForm').validate({
		rules: {
		USERNAME: ruleSet1,
		EMAIL: ruleSet2,
		PASSWORD: ruleSet1
		
  	},
	messages: {
    	USERNAME: "Enter username ",
		EMAIL: "Enter valid email id",
		PASSWORD: "Enter password"
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
    <div class="tableListWrap">        
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/> <?php } ?>         
    <form name="regForm" id="regForm" method="POST" action="">
      <table width="100%" class="PageHdr">
        <tr>
          <td><strong>Register Player</strong>
            <table width="50%" align="right">
              <tr>
                <td><div align="right"><a class="dettxt" href="<?php echo base_url(); ?>user/account/search">Players List</a></div></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <?php if($_GET['err']==1){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="SuccessMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
            <td width="95%">User Added Successfully !!!</td>
          </tr>
        </table>
      </div>
      <?php } ?>
       
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
            <?PHP if($_GET['err']==5) { ?>
            Mandatory Fields Required
            <?php } ?>
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
      <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td><table width="100%" class="ContentHdr">
              <tr>
                <td><strong>General Information</strong></td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">Player Name:</span><span id="usernamespan" class="mandatory">*</span><br />
                  <label>
                  <input name="USERNAME" type="text" class="TextField" id="USERNAME" tabindex="1" maxlength="30" value="<?php if(isset($this->session->userdata['USERNAME'])) echo $this->session->userdata['USERNAME']; ?>" />	
                   </label></td>
                <td width="40%"><span class="TextFieldHdr">Email:</span><span id="emailspan" class="mandatory">*</span><br />
                  <label>
                  <input name="EMAIL" type="text" class="TextField" id="EMAIL" tabindex="2" maxlength="30" value="<?php if(isset($this->session->userdata['EMAIL'])) echo $this->session->userdata['EMAIL'];  ?>" />
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Password:</span> <span id="passwordspan" class="mandatory">*</span><br />
                  <label>
                  <input name="PASSWORD" type="password" class="TextField" id="PASSWORD" tabindex="3" maxlength="15" value="<?php if(isset($this->session->userdata['PASSWORD'])) echo $this->session->userdata['PASSWORD']; ?>" />
                 </label></td>
              </tr>
              <span id="Showsubagent"></span>
              <?php //need to check role ?>
              
              <tr>
              <td width="40%"><span class="TextFieldHdr">Default Amount:</span><br />
                  <label>
                  <input name="DEFAULT_POINTS" type="text" class="TextField" id="DEFAULT_POINTS" tabindex="6" maxlength="15" value="<?php if(isset($this->session->userdata['DEFAULT_POINTS'])) echo $this->session->userdata['DEFAULT_POINTS']; ?>" />
                  </label></td>
              </tr>
              
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">Country:</span><br />
                  <select name="PARTNER_COUNTRY" class="ListMenu" id="PARTNER_COUNTRY" onchange="showstate(this.value);" tabindex="7" >
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
                  <select name="PARTNER_STATE" id="PARTNER_STATE" class="ListMenu" tabindex="8">
                    <option value=''>------------- Select State -------------</option>
                    <?php
                       $stateList = $this->common_model->getStateList();
                       foreach($stateList as $state){
                       ?>
                    <option <?php if($state->StateName == $PARTNER_STATE) echo 'selected="selected"'; ?>  value="<?php echo $state->StateName;?>"><?php echo ucfirst(strtolower($state->StateName));?></option>
                    <?php
                       }
                       ?>
                  </select>
                </td>
                <td width="40%"><span class="TextFieldHdr">City:</span><br />
                  <label>
                  <input name="PARTNER_CITY" type="text" class="TextField" id="PARTNER_CITY" maxlength="64" tabindex="9" value="<?php if(isset($this->session->userdata['PARTNER_CITY'])) echo $this->session->userdata['PARTNER_CITY']; ?>"  />
                  </label></td>
              </tr>
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">Contact No:</span><br />
                  <label>
                  <input name="PARTNER_CITY" type="text" class="TextField" id="PARTNER_CITY" maxlength="64" tabindex="9" value="<?php if(isset($this->session->userdata['PARTNER_CITY'])) echo $this->session->userdata['PARTNER_CITY']; ?>"  />
                </td>
                <td width="40%"><span class="TextFieldHdr">Zip Code:</span><br />
                   <label>
                  <input name="PARTNER_CITY" type="text" class="TextField" id="PARTNER_CITY" maxlength="64" tabindex="9" value="<?php if(isset($this->session->userdata['PARTNER_CITY'])) echo $this->session->userdata['PARTNER_CITY']; ?>"  />
                </td>
                <td width="40%"><span class="TextFieldHdr">Birthday:</span><br />
                  <label>
                  <input name="PARTNER_CITY" type="text" class="TextField" id="PARTNER_CITY" maxlength="64" tabindex="9" value="<?php if(isset($this->session->userdata['PARTNER_CITY'])) echo $this->session->userdata['PARTNER_CITY']; ?>"  />
                  </label></td>
              </tr>
              <tr>
                <td width="40%"></td>
                <td width="40%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
              </tr>
              <tr>
                <td><input type="submit" name="Submit" id="Submit"  value="Create" tabindex="6"  />
                  &nbsp;
                  <input type="reset" class="button" value="Reset" /></td>
              </tr>
            </table>
        </tr>
      </table>
    </form>
  </div>
</div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>
