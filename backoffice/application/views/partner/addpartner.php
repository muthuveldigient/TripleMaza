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

<script language="javascript" type="application/javascript">
$(document).ready(function () {
    var counter = 0;

    $("#addrow").on("click", function () {

        var counter = $('#apTable tr').length;

	    var newRow = $("<tr>");
        var cols = "";

        cols += '<td width="33%"><span class="TextFieldHdr"><label for="Email">Email'+ counter +' :</label></span><input type="text" class="TextField" name="email' + counter + '"/></td>';
		
        cols += '<td width="33%"><span class="TextFieldHdr"><label for="Designation">Designation'+ counter +' :</label></span><input type="text" class="TextField" name="designation' + counter + '"/></td>';

        cols += '<td width="33%"><span class="TextFieldHdr"><label for="Contact">Contact No'+ counter +' :</label></span><input type="text" name="contactno' + counter + '"/>&nbsp;<img id="delrow" src="<?php echo base_url();?>static/images/remove_contact.png" height="33" /></td>';
        newRow.append(cols);

        if (counter == 2) $('#addrow').css('display','none');
        $("table.order-list").append(newRow);
        counter++;
    });
	 
    $("table.order-list").on("click", "#delrow", function (event) {
		var counter2 = $('#apTable tr').length;
        $(this).closest("tr").remove();
		if(counter2 <4) $('#addrow').css('display','block');$('#addrow').css('float','right');$('#addrow').css('padding-right','90px');
    });

});
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
	
	$('#add-partner').validate({
		rules: {
			partnername: {
      		required: true
    	},
		partnertype: ruleSet1,
		username: ruleSet1,
		password: ruleSet1,
		commissiontype: ruleSet1,
		percentage: {
			required: true,
			max: 100,
			number: true	
		},
		email: {
			email: {
        		depends: function(element){
            		return $('#email').val() !== '';
        		}				
			},
		},
		website: {
			url: {
        		depends: function(element){
            		return $('#website').val() !== '';
        		}	
			},
		}
		//phone: ruleSet2
  	},
	messages: {
    	partnername: "Please enter the partner name",
		partnertype: "Please select the partner type",
		username: "Enter the username",
		password: "Enter the password",
		commissiontype: "Select the commission type",
		percentage: "Enter the commission percentage"
		//phone: "Enter the phone number"
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
	$('#add-partner').each(function() {
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
			$attributes = array('id' => 'add-partner');
			echo form_open('partner/partner/addpartner',$attributes);
		?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Create Partner</strong></td>
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
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Entity Name<span class="mandatory">*</span> :', 'EntityName');?>
                                    </span>
                                    <?php
                                        $EntityName = array(
                                              'name'        => 'partnername',
                                              'id'          => 'partnername',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($EntityName);			
                                    ?>                      
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Partner Type<span class="mandatory">*</span> :', 'PartnerType');?>
                                    </span>
                                    <?php
                                        echo '<select name="partnertype" id="PartnerType" class="cmbTextField">';
                                        echo '<option value="" selected="selected">-- Select --</option>';
										foreach($partnerTypes as $partnerType) {
											 echo '<option value="'.$partnerType->PARTNER_TYPE_ID.'">'.$partnerType->PARTNER_TYPE.'</option>';
										}
                                        echo '</select>';
                                    ?>                     
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Website :', 'Website');?>
                                    </span>
                                    <?php
                                        $Website = array(
                                              'name'        => 'website',
                                              'id'          => 'website',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($Website);			
                                    ?>                    	
                                </td>                                        
                            </tr>
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
                                              'maxlength'   => '25'
                                            );		
                                        echo form_input($Password);			
                                    ?>                      
                                </td>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Transaction Password :', 'transactionpassword');?>
                                    </span>
                                    <?php
                                        $Transactionpassword = array(
                                              'name'        => 'transactionpassword',
                                              'id'          => 'transactionpassword',
											  'type'		=> 'password',											  
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '25'
                                            );		
                                        echo form_input($Transactionpassword);			
                                    ?>                     	
                                </td>                                        
                            </tr> 
                            <tr>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Commission Type<span class="mandatory">*</span> :', 'CommissionType');?>
                                    </span>
                                    <?php
                                        echo '<select name="commissiontype" id="CommissionType" class="cmbTextField">';
										echo '<option value="" selected="selected">-- Select --</option>';
										foreach($commissionTypes as $commissionType) {
											 echo '<option value="'.$commissionType->AGENT_COMMISSION_TYPE_ID.'">'.$commissionType->AGENT_COMMISSION_TYPE.'</option>';
										}												
                                        echo '</select>';
                                    ?>                     
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Percentage (%)<span class="mandatory">*</span> :', 'percentage');?>
                                    </span>
                                    <?php
                                        $Percentage = array(
                                              'name'        => 'percentage',
                                              'id'          => 'percentage',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '3'
                                            );		
                                        echo form_input($Percentage);			
                                    ?>                   	
                                </td> 
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Phone :', 'Phone');?>
                                    </span>
                                    <?php
                                        $Phone = array(
                                              'name'        => 'phone',
                                              'id'          => 'phone',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '15'
                                            );		
                                        echo form_input($Phone);			
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
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($State);												
                                        /*echo '<select name="state" id="state" class="cmbTextField">';
										echo '<option value="" selected="selected">-- Select --</option>';
										foreach($getStates as $getState) {
											 echo '<option value="'.$getState->StateID.'">'.$getState->StateName.'</option>';
										}												
                                        echo '</select>';	*/		
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
										//echo '<option value="100" selected="selected">India</option>';											
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
                                              'maxlength'   => '10'
                                            );		
                                        echo form_input($Mobile);			
                                    ?>                   
                                </td>                                                                        
                            </tr>                                                                
                            <tr>
                                <td colspan="3">
                                    <table id="apTable" width="100%" class="order-list">
                                        <tr>
                                            <td width="33%" class="control-group">
                                                <span class="TextFieldHdr">
                                                    <?php echo form_label('Email :', 'Email');?>
                                                </span>
                                                <?php
                                                    $Email = array(
                                                          'name'        => 'email',
                                                          'id'          => 'email',
                                                          'class'		=> 'TextField',												  
                                                          'maxlength'   => '35'
                                                        );		
                                                    echo form_input($Email);			
                                                ?>                              
                                            </td>
                                            <td width="33%">
                                                <span class="TextFieldHdr">
                                                    <?php echo form_label('Designation :', 'Designation');?>
                                                </span>
                                                <?php
                                                    $Designation = array(
                                                          'name'        => 'designation',
                                                          'id'          => 'designation',
                                                          'class'		=> 'TextField',												  
                                                          'maxlength'   => '15'
                                                        );		
                                                    echo form_input($Designation);			
                                                ?>                                
                                            </td>
                                            <td width="33%">
                                                <span class="TextFieldHdr">
                                                    <?php echo form_label('Contact Person :', 'contactperson');?>
                                                </span>
                                                <?php
                                                    $contactperson = array(
                                                          'name'        => 'contactperson',
                                                          'id'          => 'contactperson',
                                                          'maxlength'   => '15'
                                                        );		
                                                    echo form_input($contactperson);			
                                                ?>
                                                <img id="addrow" src="<?php echo base_url();?>static/images/add_contact.jpeg" height="22" />
                                            </td>                                                                
                                        </tr>
                                    </table>
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