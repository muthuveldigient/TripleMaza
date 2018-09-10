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

<script>
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
	
	$('#edit-partner').validate({
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
	$('#edit-partner').each(function() {
	  this.reset();
	});	
}
</script>

<!-- TREEVIEW INCLUDES HERE -->
<link rel="stylesheet" href="<?php echo base_url();?>jsTreeview/jquery.treeview.css" />
<script src="<?php echo base_url();?>jsTreeview/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});
		})
		
</script>
<script language="javascript" type="text/javascript">
function checkuncheckALL() {
	var table = document.getElementById("mytable");
	var checkbox;
	var columns;
	var mainChkBox;
	var data = [];

	for(var i=0; i<table.rows.length; i++){
    	checkbox = table.rows[i].cells[1].getElementsByTagName("input")[0];
    	checkbox.onchange = function(){
			mainChkBox = this.parentNode.parentNode.cells[1].getElementsByTagName("input")[0].id;
			columns  = this.parentNode.parentNode.cells.length;

			for(k=2; k<columns; k++) {
	        	var others = this.parentNode.parentNode.cells[k].getElementsByTagName("input").length;
				if(others) {
					data.push(this.parentNode.parentNode.cells[k].getElementsByTagName("input")[0].id);
				}
			}

        	for(var j=0; j<data.length; j++){
				if(document.getElementById(mainChkBox).checked)
					document.getElementById(data[j]).checked=true;
				else
					document.getElementById(data[j]).checked=false;
        	}
    	}
	}
}

function chkunchkParent(rowID) {
	var data1 = [];
	var chkedCount=0;
	var chkBoxID;
	var parentID;
	var table1 = document.getElementById("mytable");
	columns1 = table1.rows[rowID].getElementsByTagName("input").length;

	for(g=2; g<columns1; g++) {
		var others1=table1.rows[rowID].cells[g].getElementsByTagName("input")[0].id;
		if(others1) {
			data1.push(table1.rows[rowID].cells[g].getElementsByTagName("input")[0].id);
		}
	}	
	for(var l=0; l<data1.length; l++){
		if(document.getElementById(data1[l]).checked) {
			chkedCount=chkedCount+1;
		}
	}	
	parentID = table1.rows[rowID].cells[1].getElementsByTagName("input")[0].id;	
	if(chkedCount!=0)
		document.getElementById(parentID).checked=true;
	else
		document.getElementById(parentID).checked=false;
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
			$hidden = array('PARTNER_ID'=>$parterDetails[0]->PARTNER_ID,'ADMIN_USER_ID'=>$parterDetails[0]->ADMIN_USER_ID);
			$attributes = array('id' => 'edit-partner');
			echo form_open('partner/partner/editpartner',$attributes,$hidden);
		?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Edit Partner</strong></td>
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
											  'value'		=> $parterDetails[0]->PARTNER_NAME,
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
                                        echo '<select name="partnertype" disabled="disabled" id="PartnerType" class="cmbTextField">';
										foreach($partnerTypes as $partnerType) {
											if($partnerType->PARTNER_TYPE_ID == $parterDetails[0]->FK_PARTNER_TYPE_ID)
												echo '<option selected="selected" value="'.$partnerType->PARTNER_TYPE_ID.'">'.$partnerType->PARTNER_TYPE.'</option>';
											else
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
										echo form_hidden('ext_username', $parterDetails[0]->USERNAME);																	
                                        $Username = array(
                                              'name'        => 'username',
                                              'id'          => 'username',
											  'readonly'	=> true,
											  'value'		=> $parterDetails[0]->USERNAME,
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
										echo form_hidden('ext_password', $parterDetails[0]->PASSWORD);									
                                        $Password = array(
                                              'name'        => 'password',
                                              'id'          => 'password',
											  'type'		=> 'password',
											  'value'		=> 'digient',
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
										echo form_hidden('ext_transactionpassword', $parterDetails[0]->TRANSACTION_PASSWORD);									
                                        $Transactionpassword = array(
                                              'name'        => 'transactionpassword',
                                              'id'          => 'transactionpassword',
											  'type'		=> 'password',
											  'value'		=> 'digient',											  
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
                                        echo '<select name="commissiontype" disabled="disabled" id="CommissionType" class="cmbTextField">';
										foreach($commissionTypes as $commissionType) {
											if($commissionType->AGENT_COMMISSION_TYPE_ID==$parterDetails[0]->PARTNER_COMMISSION_TYPE)
											 	echo '<option selected="selected" value="'.$commissionType->AGENT_COMMISSION_TYPE_ID.'">'.$commissionType->AGENT_COMMISSION_TYPE.'</option>';
											else
												echo '<option value="'.$commissionType->AGENT_COMMISSION_TYPE_ID.'">'.$commissionType->AGENT_COMMISSION_TYPE.'</option>';
										}												
                                        echo '</select>';
                                    ?>                      
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Percentage(%)<span class="mandatory">*</span> :', 'percentage');?>
                                    </span>
                                    <?php
                                        $Percentage = array(
                                              'name'        => 'percentage',
                                              'id'          => 'percentage',
											  'readonly'	=> true,											  
											  'value'		=> $parterDetails[0]->PARTNER_REVENUE_SHARE,
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '2'
                                            );		
                                        echo form_input($Percentage);			
                                    ?>                     	
                                </td>  
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Phone :', 'Phone');?>
                                    </span>
                                    <?php
                                        $Phone = array(
                                              'name'        => 'phone',
                                              'id'          => 'phone',
											  'value'		=> $parterDetails[0]->PARTNER_PHONE,											  
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
											  'value'		=> $parterDetails[0]->PARTNER_ADDRESS1,											  
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
											  'value'		=> $parterDetails[0]->PARTNER_CITY,											  
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
											  'value'		=> $parterDetails[0]->PARTNER_STATE,
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '55'
                                            );		
                                        echo form_input($State);									
                                        /*echo '<select name="state" id="state" class="cmbTextField">';
										foreach($getStates as $getState) {
											if($parterDetails[0]->PARTNER_STATE==$getState->StateID)
												echo '<option selected="selected" value="'.$getState->StateID.'">'.$getState->StateName.'</option>';
											else
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
											if($getCountry->CountryID == $parterDetails[0]->PARTNER_COUNTRY)
												echo '<option value="'.$getCountry->CountryID.'" selected="selected">'.$getCountry->CountryName.'</option>';
											else
												echo '<option value="'.$getCountry->CountryID.'">'.$getCountry->CountryName.'</option>';
										}										
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
											  'value'		=> $parterDetails[0]->PINCODE,												  
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
											  'value'		=> $parterDetails[0]->MOBILE,											  
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
														  'value'		=> $parterDetails[0]->PARTNER_EMAIL,														  
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
														  'value'		=> $parterDetails[0]->PARTNER_DESIGNATION,
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
														  'value'		=> $parterDetails[0]->PARTNER_CONTACT_PERSON,														
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
                        <table width="100%" class="PageHdr">
                            <tr>
                                <td><strong>Roles & Permissions</strong></td>
                            </tr>
                        </table>                    
                    </td>
               	</tr> 
              	<tr>
                	<td colspan="3">
                    	<table width="100%" id="rolesandPermissions" class="rolesandPermissions">
                        	<?php
								$getExtUserRoles = $this->partner_model->getExistingUserRoles($parterDetails[0]->ADMIN_USER_ID);
								
								$currentUserRoles = array();
								if(!empty($getExtUserRoles)) {
									foreach($getExtUserRoles as $index=>$userRoleValue) {
										$currentUserRoles[] = $userRoleValue["FK_ROLE_ID"];													
									}
								}
																	
								if($parterDetails[0]->FK_PARTNER_TYPE_ID=='3') {
									$getMainRoles = $this->partner_model->getMainRoles();
								} else {
									$moduleIDs  = $this->config->item('moduleAccess');
									$getMainRoles = $this->partner_model->getMainRoles($moduleIDs);
								}
											
								$getMAXNoOfChildRoles=0;
								if(!empty($getMainRoles)) {
									foreach($getMainRoles as $mainRole) {														
										$getChildRoles = $this->partner_model->getChildRoles($mainRole->ROLE_ID);
										if(count($getChildRoles) > $getMAXNoOfChildRoles)
											$getMAXNoOfChildRoles = count($getChildRoles);
									}
								}
							?>
                        	<tr>
								<td class="mainRole" width="9%">Role Names</td>
                                <td class="mainRole" width="5%">ALL</td>
                                <td colspan="<?php echo $getMAXNoOfChildRoles;?>"></td>                                                                                 
                            </tr>
							<tr>
                            	<td colspan="<?php echo $getMAXNoOfChildRoles+2?>">
									<table id="mytable" width="100%">
                            <?php
								if(!empty($getMAXNoOfChildRoles)) {
									$rowID=0;
									foreach($getMainRoles as $mainRole) {
										echo '<tr>';
										echo '<td width="8%" class="mainRole">'.$mainRole->ROLE_NAME.'</td>';
										if(!empty($currentUserRoles) && in_array($mainRole->ROLE_ID,$currentUserRoles)) {
											echo '<td><input type="checkbox" name="userRoles[]" id="RAP_'.$mainRole->ROLE_ID.'" checked="checked" value="'.$mainRole->ROLE_ID.'" onclick="javascript:checkuncheckALL()" /> ALL</td>';
										} else {
											echo '<td><input type="checkbox" name="userRoles[]" id="RAP_'.$mainRole->ROLE_ID.'" value="'.$mainRole->ROLE_ID.'" onclick="javascript:checkuncheckALL()" /> ALL</td>';
										}
											
										$getChildRoles = $this->partner_model->getChildRoles($mainRole->ROLE_ID);
										if(!empty($getChildRoles)) {
											foreach($getChildRoles as $index=>$childRole) {	
												echo '<td>';
												if(!empty($currentUserRoles) && in_array($childRole->ROLE_ID,$currentUserRoles))
													echo '<input type="checkbox" name="userRoles[]" id="RAP_'.$childRole->ROLE_ID.'" checked="checked" value="'.$childRole->ROLE_ID.'" onclick="javascript:chkunchkParent('.$rowID.')" /> '.$childRole->ROLE_NAME.'</li>';	
												else
													echo '<input type="checkbox" name="userRoles[]" id="RAP_'.$childRole->ROLE_ID.'" value="'.$childRole->ROLE_ID.'" onclick="javascript:chkunchkParent('.$rowID.')" /> '.$childRole->ROLE_NAME.'</li>';	
												echo '</td>';
											}
										}
										for($i=count($getChildRoles);$i<$getMAXNoOfChildRoles;$i++) {
											echo '<td>&nbsp;</td>';	
										}
										echo '</tr>';	
										$rowID++;										
									}
								}
							?>                                    
                                    </table>
                                </td>
                            </tr>
                        </table>				
                    </td>
                </tr>                                
                <tr>
                	<td colspan="3">
						<?php
                            echo form_submit('frmSubmit', 'Save')."&nbsp;";
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