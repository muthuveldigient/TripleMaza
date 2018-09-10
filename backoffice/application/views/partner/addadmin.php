<script language="javascript" type="text/javascript">
function chkUserExistence(userName) {
	xmlHttp=GetStateXmlHttpObject();
	if(xmlHttp==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var url="<?php echo base_url();?>partner/partner/chkUserExistence/"+userName;

	//alert(url);
	xmlHttp.onreadystatechange=chkUserExistenceResult;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);		
}

function chkUserExistenceResult() { 
	if (xmlHttp.readyState==4) { 
		document.getElementById("userExtError").innerHTML="";
		$("#userExtError").removeAttr("style");
		if(xmlHttp.responseText=="Username is not available") {
			document.getElementById("userExtError").innerHTML=xmlHttp.responseText;			
			document.getElementById("username").value="";
			$("tr #newUserName").removeClass("control-group success");
			$("tr #newUserName").addClass("control-group error");			
			$('#userExtError').css("color", "red");
			$('#userExtError').delay(500).fadeOut('slow');
		} else {
			document.getElementById("userExtError").innerHTML=xmlHttp.responseText;			
			$('#userExtError').css("color", "green");
			$('#userExtError').delay(500).fadeOut('slow');						
		}
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
$(document).ready(function(){
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		number: true
	};
	
	$('#add-admin').validate({
		rules: {
			username: {
      		required: true
    	},
		password: ruleSet1,
		email: {
			required: true,
			email: true	
		}
		//mobile: ruleSet2
  	},
	messages: {
		username: "Enter the username",
		password: "Enter the password",
		email: "Enter the email"
		//mobile: "Enter the mobile no"
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
	$('#add-admin').each(function() {
	  this.reset();
	});	
}
</script>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>             
        <?php 
			$attributes = array('id' => 'add-admin');
			echo form_open('partner/admin/addAdmin',$attributes);
		?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Create Admin</strong></td>
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
			<table width="100%" class="searchWrap" bgcolor="#993366">
            	<tr>
                	<td colspan="3">
                        <table width="100%" class="PageHdr">
                            <tr>
                                <td><strong>General Information</strong></td>
                            </tr>
                        </table>                    
                    </td>
               	</tr>
				<tr>
                	<td colspan="3">
						<table width="100%" cellpadding="10" cellspacing="10">
                            <tr>
                                <td width="33%" id="newUserName" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('User Name<span class="mandatory">*</span> :', 'Username');?>
                                    </span>
                                    <?php
                                        $Username = array(
                                              'name'        => 'username',
                                              'id'          => 'username',
											  'onChange'	=> 'javascript:chkUserExistence(this.value)',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '25'
                                            );		
                                        echo form_input($Username);			
                                    ?>
                                    <div id="userExtError"></div>                     
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Password<span class="mandatory">*</span> :', 'Password');?>
                                    </span>
                                    <?php
                                        $Password = array(
                                              'name'        => 'password',
                                              'id'          => 'password',
											  'type'		=> 'password',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '35'
                                            );		
                                        echo form_input($Password);			
                                    ?>                    
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Email<span class="mandatory">*</span> :', 'Email');?>
                                    </span>
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
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Transaction Password :', 'TransactionPassword');?>
                                    </span>
                                    <?php
                                        $TransactionPassword = array(
                                              'name'        => 'transactionpassword',
                                              'id'          => 'transactionpassword',
											  'type'		=> 'password',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '35'
                                            );		
                                        echo form_input($TransactionPassword);			
                                    ?>                                                  
                                </td>                            
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('First Name :', 'FirstName');?>
                                    </span>
                                    <?php
                                        $FirstName = array(
                                              'name'        => 'firstname',
                                              'id'          => 'firstname',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($FirstName);			
                                    ?>                  
                                </td>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Last Name :', 'LastName');?>
                                    </span>
                                    <?php
                                        $LastName = array(
                                              'name'        => 'lastname',
                                              'id'          => 'lastname',											  
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($LastName);			
                                    ?>                    	
                                </td>                                                                        
                            </tr>
                            <tr>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Adderss :', 'Adderss');?>
                                    </span>
                                    <?php
                                        $Adderss = array(
                                              'name'        => 'adderss',
                                              'id'          => 'adderss',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '75'
                                            );		
                                        echo form_input($Adderss);			
                                    ?>                     
                                </td>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('City :', 'City');?>
                                    </span>
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
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('State :', 'State');?>
                                    </span>
                                    <?php
                                        $State = array(
                                              'name'        => 'state',
                                              'id'          => 'state',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '75'
                                            );		
                                        echo form_input($State);			
                                    ?>                     
                                </td>                                                                                                                                      
                            </tr>  
                            <tr>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Country :', 'Country');?>
                                    </span>
                                    <?php
                                        echo '<select name="country" id="country" class="cmbTextField">';
										foreach($getCountries as $getCountry) {
											 echo '<option value="'.$getCountry->CountryID.'">'.$getCountry->CountryName.'</option>';
										}
										echo '<option value="100" selected="selected">India</option>';											
                                        echo '</select>';			
                                    ?>                    	
                                </td>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Pin Code :', 'Pincode');?>
                                    </span>
                                    <?php
                                        $Pincode = array(
                                              'name'        => 'pincode',
                                              'id'          => 'pincode',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '12'
                                            );		
                                        echo form_input($Pincode);			
                                    ?>                   
                                </td>                                
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Mobile :', 'Mobile');?>
                                    </span>
                                    <?php
                                        $Mobile = array(
                                              'name'        => 'mobile',
                                              'id'          => 'mobile',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '15'
                                            );		
                                        echo form_input($Mobile);			
                                    ?>                    
                                </td>                                                                        
                            </tr>                                                                                       
                        </table>
                    </td>
                </tr> 
                <tr>
                	<td colspan="3">
						<?php
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