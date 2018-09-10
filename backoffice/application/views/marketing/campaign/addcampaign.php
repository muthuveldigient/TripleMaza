<script language="javascript" type="text/javascript">
function getPaymentType(campaignID) { 
	xmlHttp=GetStateXmlHttpObject();
	if(xmlHttp==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var url="<?php echo base_url();?>/marketing/campaign/campaign/getPaymentTypes/"+campaignID;
	if(campaignID=='3') {			
		var nameElem = document.getElementById("promoValue2Class")
		nameElem.classList.add("control-group");

		document.getElementById("promovalue2").readOnly=false;
		document.getElementById("promovalue2").value="";		
	} else {
		var nameElem = document.getElementById("promoValue2Class")
		nameElem.classList.remove("control-group");	
		document.getElementById("promovalue2").value="";	
		document.getElementById("promovalue2").readOnly=true;
	}
	
	//alert(url);
	xmlHttp.onreadystatechange=pTypeChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function pTypeChanged() { 
	if (xmlHttp.readyState==4) { 
		document.getElementById("paymenttype").innerHTML=xmlHttp.responseText;
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

//Below are the functions to get the promo type
function promoChanged() { 
	if (xmlHttpP.readyState==4) { 
		document.getElementById("promotype").innerHTML=xmlHttpP.responseText;
	}
}

function getPromoType(paymentID) {
	xmlHttpP=GetStateXmlHttpObject();
	if(xmlHttpP==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var url="<?php echo base_url();?>/marketing/campaign/campaign/getPromoTypes/"+paymentID;
	if(paymentID==3) { 
		document.getElementById("promominvalue").readOnly=false;
		document.getElementById("promomaxvalue").readOnly=false;		
	} else {
		document.getElementById("promominvalue").readOnly=true;
		document.getElementById("promomaxvalue").readOnly=true;		
	}
				
	//alert(url);
	xmlHttpP.onreadystatechange=promoChanged;
	xmlHttpP.open("GET",url,true);
	xmlHttpP.send(null);	
}

//Below are the functions to generate campaign URL
function getCampaignURL() {
	if (xmlHttpCC.readyState==4) { 
		var cType = document.getElementById("CampaignType").value;
		var cCode = document.getElementById("campaigncode").value;

		if(cCode=="") {
			var campCODEURL = xmlHttpCC.responseText.split(","); 
			document.getElementById("campaigncode").value=campCODEURL[0];
			document.getElementById("campaignurl").value=campCODEURL[1];
		} else {	
			document.getElementById("campaignurl").value=xmlHttpCC.responseText;
		}
	}	
}
function generateCampaignURL() {
	if(document.getElementById('CampaignType').value=="") {
		alert("Please choose the campaign type");	
		return false;
	}
	xmlHttpCC=GetStateXmlHttpObject();
	if(xmlHttpCC==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var cType = document.getElementById("CampaignType").value;
	var cCode = document.getElementById("campaigncode").value;
	var url="<?php echo base_url();?>/marketing/campaign/campaign/getCampaignURL/"+cType+"/"+cCode;
				
	//alert(url);
	xmlHttpCC.onreadystatechange=getCampaignURL;
	xmlHttpCC.open("GET",url,true);
	xmlHttpCC.send(null);
}

function findCostPerUserValue() {
	var cCost = document.getElementById('cost').value;
	var eUser = document.getElementById('expecteduser').value;	
	if(!isNaN(cCost) && !isNaN(eUser)) {
		var cPUserVal = cCost / eUser;
		document.getElementById('costperuser').value=cPUserVal;
	}
}
</script>

<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>    
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	//$("td #promovalue2").addClass('control-group');		
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		number: true
	};
	
	$('#add-campaign').validate({
		rules: {
			campaigntype: {
      		required: true
    	},
		partnername: ruleSet1,
		campaignname: ruleSet1,
		campaigncode: ruleSet1,
		campaignurl: ruleSet1,
		startdate: ruleSet1,
		enddate: ruleSet1,
		paymenttype: ruleSet1,
		promotype: ruleSet1,
		promovalue1: ruleSet2,
		expusermin: ruleSet2,
		expusermax: ruleSet2,
		promovalue2: {
			required: {
        		depends: function(element){
            		return $('#CampaignType').val() === '3';
        		}
    		},
			number: true		
		}
  	},
	messages: {
    	campaigntype: "Please select the campaign type",
		partnername: "Please select the partner",
		campaignname: "Enter the campaign name",
		campaigncode: "Enter the campaign code",
		campaignurl: "Enter the campaign URL",
		startdate: "Select the campaign start date",
		enddate: "Select the campaign end date",
		paymenttype: "Select the payment type",
		promotype: "Select the promo type",
		promovalue1: "Enter the promo value1",
		promovalue2: "Enter the promo value2",
		expusermin: "Expected user minimum total",
		expusermax: "Expected user maximum total"
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.text('OK!').addClass('valid')
    	.closest('.control-group').removeClass('error').addClass('success');
  	}
 });
}); // end document.ready
</script>
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
function clearFrmValues() {
	$('#add-campaign').each(function() {
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
            echo $this->common_model->errorHandling($_REQUEST['errmsg']);?> <br/><br/><br/><br/> <?php } ?>             
        <?php 
			$attributes = array('id' => 'add-campaign');
			echo form_open('marketing/campaign/campaign/addcampaign',$attributes);?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Create Campaign</strong></td>
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
                	<td>
                        <table width="100%" class="PageHdr">
                            <tr>
                                <td><strong>Campaign Settings</strong></td>
                            </tr>
                        </table>                    	
                        <table width="100%" cellpadding="10" cellspacing="10">
                        	<!--  <tr>
                            	<td width="50%">
                                	<span class="TextFieldHdr">
										<?php //echo form_label('Campaign Mode', 'CampaignMode');?>:
                                    </span><br />
                                    <select name="campaignMode" class="TextField">
                                        <option value="">-- Select --</option>
                                        <option value="1">Unique Code</option>
                                        <option value="2">Bulk code</option>                                                                        
                                    </select>                                
                                </td>
                                <td width="50%">&nbsp;</td>
                            </tr> -->
                            <tr>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Campaign Type<span class="mandatory">*</span> :', 'CampaignType');?>
                                    </span>
                                	<?php
										echo '<select name="campaigntype" id="CampaignType" class="cmbTextField" onChange="javascript:getPaymentType(this.value);">';
										echo '<option value="" selected="selected">-- Select --</option>';
										foreach($campaign_types as $campType) {
											 echo '<option value="'.$campType->PROMO_CAMPAIGN_TYPE_ID.'">'.$campType->PROMO_CAMPAIGN_TYPE.'</option>';
										}
										echo '</select>';
									?>                                 
                                </td>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Partner Name<span class="mandatory">*</span> :', 'PartnerName');?>
                                    </span>
                                	<?php
										echo '<select name="partnername" id="PartnerName" class="cmbTextField">';
										echo '<option value="">-- Select --</option>';
										foreach($partner_names as $parterName) {
											 echo '<option value="'.$parterName->PARTNER_ID.'">'.$parterName->PARTNER_NAME.'</option>';
										}
										echo '</select>';
									?>                                    								
                                </td> 
                            </tr>
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Campaign Code<span class="mandatory">*</span> :', 'CampaignCode');?>
                                    </span>
                                    <?php
										$CampaignCode = array(
											  'name'        => 'campaigncode',
											  'id'          => 'campaigncode',
											  'class'		=> 'TextField',												  
											  'maxlength'   => '16'
											);		
										echo form_input($CampaignCode);									
									?>                                                                
                                </td>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Campaign URL<span class="mandatory">*</span> :', 'CampaignURL');?>
                                    </span>
                                    <?php
										$CampaignURL = array(
											  'name'        => 'campaignurl',
											  'id'          => 'campaignurl',
											  'class'		=> 'TextFieldURL',	
											  'maxlength'   => '100'
											);		
										echo form_input($CampaignURL)."&nbsp;";			
										echo form_button('cCodeGenerate', 'Generate', "onclick='javascript:generateCampaignURL()'");								
									?>                              
                                </td> 
                            </tr>
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Campaign Name<span class="mandatory">*</span> :', 'CampaignName');?>
                                    </span>
                                    <?php
										$CampaignName = array(
											  'name'        => 'campaignname',
											  'id'          => 'campaignname',
											  'class'		=> 'TextField',												  
											  'maxlength'   => '55'
											);		
										echo form_input($CampaignName);			
									?> 
                                    
                               		<span class="TextFieldHdr">
										<?php echo form_label('Campaign Status :', 'CampaignStatus');?>
                                    </span> 
                                    <?php
										echo '<select name="campaignstatus" id="campaignstatus" class="cmbTextField">';		
										foreach($campaign_status as $campStatus) {
											 echo '<option value="'.$campStatus->PROMO_STATUS_ID.'">'.$campStatus->PROMO_STATUS_DESC.'</option>';
										}						
										echo '</select>';								
									?>                                                                   
                                </td>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Campaign Description :', 'CampaignDesc');?>
                                    </span> 
                                    <?php
										$CampaignDesc = array(
											  'name'        => 'campaigndesc',
											  'id'          => 'campaigndesc',
											  'class'		=> 'TextField',												  
											  'rows'   => '5',
											  'cols'   => '24'
											);		
										echo form_textarea($CampaignDesc);								
									?>                                 
                                </td>
                            </tr> 
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Start Date :', 'StartDate');?>
                                    </span> 
                                    <?php
										$startDate = array(
											  'name'        => 'startdate',
											  'id'          => 'startdate',
											  'class'		=> 'TextFieldDate',
											  'readonly'	=> true,											  
											  'maxlength'   => '12'			  
											);
										echo form_input($startDate);
									?>
                                    <a onclick="NewCssCal('startdate','ddmmyyyy','arrow',false,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a><span class="mandatory">*</span>                                 
                                </td>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('End Date :', 'EndDate');?>
                                    </span> 
                                    <?php
										$endDate = array(
											  'name'        => 'enddate',
											  'id'          => 'enddate',
											  'class'		=> 'TextFieldDate',	
											  'readonly'	=> true,											  											  
											  'maxlength'   => '12'			  
											);
										echo form_input($endDate);								
									?>
                                    <a onclick="NewCssCal('enddate','ddmmyyyy','arrow',false,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a><span class="mandatory">*</span>                                     
                                </td>
                            </tr>                          
                        </table>
                        <table width="100%" class="PageHdr">
                            <tr>
                                <td colspan="2"><strong>Payment & Rule Settings</strong></td>
                            </tr>
                        </table>
                        <table width="100%" cellpadding="10" cellspacing="10">
                            <tr>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Payment Type<span class="mandatory">*</span> :', 'PaymentType');?>
                                    </span>
                                	<?php
										echo '<select name="paymenttype" id="paymenttype" class="cmbTextField">';		
										echo '<option value="">-- Select Payment Type--</option>';		
										echo '</select>';
									?>                               
                                </td>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Promo Type<span class="mandatory">*</span> :', 'PromoType');?>
                                    </span>
                                	<?php
										echo '<select name="promotype" id="promotype" class="cmbTextField">';		
										echo '<option value="">-- Select Promo Type--</option>';
										echo '<option value="1">CHIPS</option>';
										echo '<option value="2">POINTS</option>';																				
										echo '</select>';
									?>                                  								
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Promo Min Value :', 'PromominValue');?>
                                    </span> 
                                    <?php
										$PromominValue = array(
											  'name'        => 'promominvalue',
											  'id'          => 'promominvalue',
											  'class'		=> 'TextField',												  
											  'maxlength'   => '4'	  
											);		
										echo form_input($PromominValue);								
									?>                              
                                </td>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Promo Max Value :', 'PromomaxValue');?>
                                    </span> 
                                    <?php
										$PromomaxValue = array(
											  'name'        => 'promomaxvalue',
											  'id'          => 'promomaxvalue',
											  'class'		=> 'TextField',												  
											  'maxlength'   => '4'			  
											);		
										echo form_input($PromomaxValue);								
									?>                               
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Promo Value1<span class="mandatory">*</span> :', 'Promovalue1');?>
                                    </span> 
                                    <?php
										$PromoValue1 = array(
											  'name'        => 'promovalue1',
											  'id'          => 'promovalue1',
											  'class'		=> 'TextField',	
											  'maxlength'   => '4',											  											  
											  'maxlength'   => '100'
											);		
										echo form_input($PromoValue1);								
									?>                                
                                </td>
                                <td id="promoValue2Class" width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Promo Value2 :', 'promoValue2');?>
                                    </span> 
                                    <?php
										$PromoValue2 = array(
											  'name'        => 'promovalue2',
											  'id'          => 'promovalue2',
											  'class'		=> 'TextField',	
											  'maxlength'   => '4',	
											  'readonly'	=> true
											);		
										echo form_input($PromoValue2);								
									?>                                 
                                </td>
                            </tr>                                                         
                    </table>
                    <table width="100%" class="PageHdr">
                        <tr>
                            <td colspan="2"><strong>Cost & User Range Settings</strong></td>
                        </tr>
                    </table>
                        <table width="100%" cellpadding="10" cellspacing="10">
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Campaign Cost :', 'Cost');?>
                                    </span> 
                                    <?php
										$Cost = array(
											  'name'        => 'cost',
											  'id'          => 'cost',
											  'class'		=> 'TextField',											  
											  'maxlength'   => '4'
											);		
										echo form_input($Cost);								
									?>                                 
                                </td>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Expected User :', 'ExpectedUser');?>
                                    </span> 
                                    <?php
										$ExpectedUser = array(
											  'name'        => 'expecteduser',
											  'id'          => 'expecteduser',
											  'class'		=> 'TextField',	
											  'onChange'	=> 'javascript:findCostPerUserValue();',										  
											  'maxlength'   => '4'
											);		
										echo form_input($ExpectedUser);								
									?>                                 
                                </td>
                            </tr>
                            <tr>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Cost Per User :', 'CostPerUser');?>
                                    </span> 
                                    <?php
										$CostPerUser = array(
											  'name'        => 'costperuser',
											  'id'          => 'costperuser',
											  'class'		=> 'TextField',											  
											  'maxlength'   => '4'
											);		
										echo form_input($CostPerUser);							
									?>                                 
                                </td>
                                <td width="50%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Expected User Min<span class="mandatory">*</span> :', 'ExpectedUserMin');?>
                                    </span> 
                                    <?php
										$ExpectedUserMin = array(
											  'name'        => 'expusermin',
											  'id'          => 'expusermin',
											  'class'		=> 'TextField',											  
											  'maxlength'   => '4'
											);		
										echo form_input($ExpectedUserMin);							
									?>               
                                </td>
                            	<td width="50%" class="control-group">
                                	<span class="TextFieldHdr">
										<?php echo form_label('Expected User Max<span class="mandatory">*</span> :', 'ExpectedUserMax');?>
                                    </span> 
                                    <?php
										$ExpectedUserMax = array(
											  'name'        => 'expusermax',
											  'id'          => 'expusermax',
											  'class'		=> 'TextField',											  
											  'maxlength'   => '4'
											);		
										echo form_input($ExpectedUserMax);							
									?>                               
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="2">
							<?php
                                echo form_submit('frmSubmit', 'Create')."&nbsp;";
								echo form_button('frmClear', 'Clear', "onclick='javascript:clearFrmValues();'");								
                                echo form_close();
                            ?>               
                                </td>
                            </tr>                                                                                    
                    </table>                                                                                                                 
                    </td>
                </tr>
            </table>  
            
        <?php echo form_close();?>          
        </div>
    </div>
    </div>
</div>
<?php $this->load->view("common/footer"); ?>	