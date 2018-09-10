<script language="javascript" type="text/javascript">
/* THIS IS TO SHOW THE SUB DISTRIBUTORS AGENTS */
function showSDAgents(sDistributorID) {
	xmlHttpSagents=GetXmlHttpObject()
	var url='<?php echo base_url();?>partners/partners/showSubDistAgents'; 
	url=url+"?sdisid="+sDistributorID;	
	xmlHttpSagents.onreadystatechange=showSubDistAgents
	xmlHttpSagents.open("GET",url,true);
	xmlHttpSagents.send(null);      
	return false;	
}

function showSubDistAgents() {
	if(xmlHttpSagents.readyState==4 || xmlHttpSagents.readyState=="complete") {
		var result=xmlHttpSagents.responseText;
		var disptext='';
		if(trim(result)=='Agentnotexist') {
			disptext='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="UDTxtField" tabindex="6"><option value=""></option></select>';
			document.getElementById("PARTNER_DISTRIBUTOR").value="";
		} else {
			disptext=result;
		}
		document.getElementById("disagents_list").innerHTML=disptext;		
	}
}
/* THIS IS TO SHOW THE SUB DISTRIBUTORS AGENTS */

function showagents(disid) {
    xmlHttp3=GetXmlHttpObject()
	var url='<?php echo base_url();?>partners/partners/showAgents';            
	url=url+"?disid="+disid;		
	xmlHttp3.onreadystatechange=Showagent
	xmlHttp3.open("GET",url,true);
	xmlHttp3.send(null);       
	return false;
}

function Showagent() {
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete") { 		
		var result=xmlHttp3.responseText.split("-");
		var disptext='';			
		if(trim(result[0])=='Agentnotexist'){
			disptext='<select id="USERPARTNER_ID"  name="USERPARTNER_ID" class="UDTxtField" tabindex="6"><option value=""></option></select>';
			
		}else{
			disptext=result[0];
		}
		document.getElementById("sub_distributors_list").innerHTML=result[1];    						
		document.getElementById("disagents_list").innerHTML=disptext;    
    }
}

function chkuserexists(username) {
	xmlHttp3=GetXmlHttpObject()
	if(trim(username)){
		var url='<?php echo base_url();?>partners/partners/chkUserExist';            
		url=url+"?p_username="+trim(username);
		xmlHttp3.onreadystatechange=Chkuser
		xmlHttp3.open("GET",url,true);
		xmlHttp3.send(null);
	}
	return false;
}

function Chkuser() {
	if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete") { 		
		var result=xmlHttp3.responseText;		
		var disptext='';
		if(trim(result)=='Username already exists'){
			disptext=result;
		}
        document.getElementById("alreadyexists").innerHTML='<b>'+disptext+'</b>';    
	}else{
    	document.getElementById("alreadyexists").innerHTML='<img src="<?php echo base_url();?>/static/images/loading2.gif">';
    }
} 

function GetXmlHttpObject() {
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
$(document).ready(function(){
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		number: true
	};
	 jQuery.validator.addMethod("usernameRegex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\._]+$/i.test(value);
    }, "Only allowed letters, numbers, period or underscore.");
	jQuery.validator.addMethod("passwdfun",function(value, element, regexp) {
			var re = new RegExp(regexp);
		    return this.optional(element) || re.test(value);
	 	},
		"Password must be an alphanumeric!" 
	);
	$('#regForm').validate({
		rules: {
			username: {
      		required: true,
			minlength: 4,
			usernameRegex: true,
			remote: '<?php echo base_url();?>partners/partners/chkUserExist/'
    	},
		password: {
			required: true,
			passwdfun: "((?=(.*[a-zA-Z].*))(?=(.*[0-9].*)))",
			minlength: 4
		},
		email: {
			required: true,
			email: true,
			remote: '<?php echo base_url();?>partners/partners/chkUserEmailExist/'			
		},
		PARTNER_DISTRIBUTOR: ruleSet1
  	},
	messages: {
		username: {
			required: "Enter the username",
			remote: jQuery.format("{0}")
		},
		password: {
			required: "Enter the password"
		},		
		email: {
			required: "Enter the email",
			email: "Enter the valid email",
			remote: jQuery.format("{0}")
		},
		PARTNER_DISTRIBUTOR: "select the distributor"
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
	$('#regForm').each(function() {
	  this.reset();
	});	
}
</script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar");?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
        <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?>
        <br/>
        <br/>
        <br/>
        <br/>
        <?php } ?>
        <?php 
			$attributes = array('id' => 'regForm');
			echo form_open('partners/partners/createUser?rid=55',$attributes);
		?>
		<input type="hidden" name="current_user_session_id" value="<?php echo $this->session->userdata('session_id');?>"  />
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Create User</strong></td>
          </tr>
        </table>
        <?php if($this->session->flashdata('message')=='User created successfully.') { ?>
        <table width="100%" class="SuccessMsg">
          <tbody>
            <tr>
              <td width="45"><img width="45" height="34" alt="" src="<?php echo base_url();?>static/images/icon-success.png"></td>
              <td width="95%"><?php echo $this->session->flashdata('message');?></td>
            </tr>
          </tbody>
        </table>
        <?php }elseif($this->session->flashdata('message')=='Please try again.' || $this->session->flashdata('message')=='Agent has insuffient balance.') {  ?>
        <table width="100%" class="ErrorMsg">
          <tbody>
            <tr>
              <td width="45"><img width="45" height="34" alt="" src="<?php echo base_url();?>static/images/icon-error.png"></td>
              <td width="95%"><?php echo $this->session->flashdata('message');?></td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
        <table width="100%" class="searchWrap" bgcolor="#993366">
          <tr>
            <td colspan="3"><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>General Information</strong></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="33%" id="newUserName" class="control-group"><span class="TextFieldHdr"> <?php echo form_label('User Name<span class="mandatory">*</span> :', 'Username');?> </span>
                    <?php
                                        $Username = array(
                                              'name'        => 'username',
                                              'id'          => 'username',											 
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '16'
                                            );		
                                        echo form_input($Username);			
                                    ?>
                    </td>
                  <td width="33%" class="control-group"><span class="TextFieldHdr"> <?php echo form_label('Password<span class="mandatory">*</span> :', 'Password');?> </span>
                    <?php
                                        $Password = array(
                                              'name'        => 'password',
                                              'id'          => 'password',
											  'type'		=> 'password',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '16'
                                            );		
                                        echo form_input($Password);			
                                    ?>
                  </td>
                  <td width="33%" class="control-group"><span class="TextFieldHdr"> <?php echo form_label('Email<span class="mandatory">*</span> :', 'Email');?> </span>
                    <?php
                                        $Email = array(
                                              'name'        => 'email',
                                              'id'          => 'email',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($Email);			
                                    ?>
                  </td>
                </tr>
                <tr>
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('Amount :', 'Amount');?> </span>
                    <?php
                                        $Amount = array(
                                              'name'        => 'amount',
                                              'id'          => 'amount',
											  'type'		=> 'text',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '10'
                                            );		
                                        echo form_input($Amount);			
                                    ?>
                  </td>              
                  
                  <?php 				 
				   if($this->session->userdata('partnertypeid')=="11" || $this->session->userdata('partnertypeid')=="12"){ ?>
                  <td width="33%" class="control-group"><span class="TextFieldHdr"> <?php echo form_label('Distributor <span class="mandatory">*</span>:', 'Distributor'); ?> </span>
                    <?php if($this->session->userdata('partnertypeid')=="11"){ ?>
                    <select name="PARTNER_DISTRIBUTOR" class="UDTxtField" id="PARTNER_DISTRIBUTOR" onChange="showagents(this.value);">
                      <option value="">--Select distributor--</option>
                      <?php
            $sql_distribut=mysql_query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$this->session->userdata('partnerid')."' and FK_PARTNER_TYPE_ID=12");
            while($row_distribut=mysql_fetch_array($sql_distribut)){
            ?>
                      <option value="<?php echo $row_distribut['PARTNER_ID'];?>"><?php echo $row_distribut['PARTNER_USERNAME'];?></option>
                      <?php } ?>
                    </select>
                  <?php }else{ ?>
                  <select name="PARTNER_DISTRIBUTOR" class="UDTxtField" id="PARTNER_DISTRIBUTOR" onChange="showagents(this.value);">
                    <option value="">--Select distributor--</option>
                    <?php
        $sql_distribut=mysql_query("select PARTNER_ID,PARTNER_USERNAME from partner where PARTNER_ID='".$this->session->userdata('partnerid')."' and FK_PARTNER_TYPE_ID=12");        
        while($row_distribut=mysql_fetch_array($sql_distribut)){ ?>
                    <option value="<?php echo $row_distribut['PARTNER_ID'];?>"><?php echo $row_distribut['PARTNER_USERNAME'];?></option>
                    <?php } ?>
                  </select>
                  <?php } ?>
                  </td>
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('Sub.Distributor:', 'Sub.Distributor:');?> </span> <span id="sub_distributors_list">
                    <select name="SUB_DISTRIBUTOR" id="SUB_DISTRIBUTOR" class="UDTxtField" onBlur="showSDAgents(this.value)">
                      <option value="999999">--Select sub distributor--</option>
                    </select>
                    </span> </td>
                </tr>
                <?php }else{
        $sql_udist=mysql_query("select FK_PARTNER_ID from partner where PARTNER_ID='".$this->session->userdata('partnerid')."'");
        $row_udist=mysql_fetch_array($sql_udist); ?>
                <input type="hidden" name="PARTNER_DISTRIBUTOR" id="PARTNER_DISTRIBUTOR" value="<?php echo $row_udist['FK_PARTNER_ID'];?>">
                <input type="hidden" name="USERPARTNER_ID" id="USERPARTNER_ID" value="<?php echo $this->session->userdata('partnerid');?>">
                <?php } ?>                
                
                <?php if($this->session->userdata('partnertypeid')=="11" || $this->session->userdata('partnertypeid')=="12" || $this->session->userdata('partnertypeid')=="13"){ ?>         <tr>
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('Agent :', 'Agent');?> </span> <span id="disagents_list">
                    <?php
					if($this->session->userdata('partnertypeid')=="11" || $this->session->userdata('partnertypeid')=="12" || $this->session->userdata('partnertypeid')=="13"){ ?>
                    <select id='USERPARTNER_ID'  name='USERPARTNER_ID' class='UDTxtField' tabindex='6'>
                      <?php   
			$sql_agent=mysql_query("select PARTNER_ID,PARTNER_USERNAME from partner where FK_PARTNER_ID='".$this->session->userdata('partnerid')."' AND FK_PARTNER_TYPE_ID=14");   
			if(mysql_num_rows($sql_agent)>0){
				while($row_agent=mysql_fetch_array($sql_agent)){
			?>
                      <option value="<?php echo $row_agent['PARTNER_ID'];?>"><?php echo $row_agent['PARTNER_USERNAME'];?></option>
                      <?php } }else{ ?>
                      <option value="">--select--</option>
                      <?php } ?>
                    </select>
                    <?php } ?>
                    </span> 
                  <?php }else{
        $sql_udist=mysql_query("select FK_PARTNER_ID from partner where PARTNER_ID='".$this->session->userdata('partnerid')."'");
        $row_udist=mysql_fetch_array($sql_udist);
    ?>
                  <input type="hidden" name="PARTNER_DISTRIBUTOR" id="PARTNER_DISTRIBUTOR" value="<?php echo $row_udist['FK_PARTNER_ID'];?>">
                  <input type="hidden" name="USERPARTNER_ID" id="USERPARTNER_ID" value="<?php echo $this->session->userdata('partnerid');?>">
                  <?php } ?>
                  </td>
                  
                  
                  
                  
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('Country :', 'Country');?> </span>
                    <select name="PARTNER_COUNTRY" class="UDTxtField" id="PARTNER_COUNTRY" onChange="showstate(this.value);" tabindex="7" >
                      <option>------------- Select Country ------------</option>
                      <?php
    $sel_country="select CountryName from countries where CountryName='India'";
    $res_country=mysql_query($sel_country);
    while($row_country=mysql_fetch_array($res_country)){
    ?>
                      <option value="<?php echo $row_country['CountryName'];?>" <?php if($row_country['CountryName']=="India"){ echo "selected"; }else{ if($_REQUEST['PARTNER_COUNTRY']==$row_country['CountryName']) echo "selected";}?> ><?php echo $row_country['CountryName'];?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('State :', 'State');?> </span>
                    <select name="PARTNER_STATE" id="PARTNER_STATE" class="UDTxtField" tabindex="8">
                      <option value=''>------------- Select State -------------</option>
                      <?php
        $sel_state="select StateName from state order by StateName";
        $res_state=mysql_query($sel_state);
        while($row_state=mysql_fetch_array($res_state)){
        ?>
                      <option value="<?php echo $row_state['StateName'];?>" <?php if($_GET['str']==$row_state['StateName']) { echo 'selected';} ?> ><?php echo ucfirst(strtolower($row_state['StateName']));?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('City :', 'City');?> </span>
                    <?php
                                        $City = array(
                                              'name'        => 'city',
                                              'id'          => 'city',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($City);			
                                    ?>
                  </td>
                  <td width="33%"><span class="TextFieldHdr"> <?php echo form_label('Area:', 'Area');?> </span>
                    <?php
                                        $Pincode = array(
                                              'name'        => 'area',
                                              'id'          => 'area',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($Pincode);			
                                    ?>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="3"><?php
                            echo form_submit('frmSubmit', 'Create')."&nbsp;";
                            echo form_button('frmClear', 'Clear', "onclick='javascript:clearFrmValues();'");
                        ?>
            </td>
          </tr>
        </table>
        <?php
              echo form_close();			
			?>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("common/footer"); ?>
