<?php
$ptypeID = $this->session->userdata['partnertypeid'];
?>
<script language="javascript" type="application/javascript">
//Chain Select
var ptypeId = '<?php echo $ptypeID; ?>';
var partId = '<?php echo $this->session->userdata['partnerid']; ?>';

$(document).ready(function () {
$("#partnertype").change(function()	{
		
		var id=$(this).val();
		
		if(id > 11) {
			//tdMasteragent tdDistributor tdSubdistributor
			if(id == 12) {
				$('#tdMasteragent').show();
				$('#tdSuperdistributor').show();
				$('#tdDistributor').hide();
				$('#tdSubdistributor').hide();
				$('#distributor').empty();
				$('#subdistributor').empty();
				$('#superdistributor').empty();
/* 				$('#RAP_54').attr('checked', true);
				$('#RAP_54').show(); */
			} else if(id == 13) {
				$('#tdMasteragent').show();
				$('#tdSuperdistributor').show();
				$('#tdDistributor').show();
				$('#tdSubdistributor').hide();
				$('#distributor').empty();
				$('#subdistributor').empty();
				$('#superdistributor').empty();
/* 				$('#RAP_54').attr('checked', true);
				$('#RAP_54').show(); */
			} else if(id == 14) {
				$('#tdMasteragent').show();
				$('#tdSuperdistributor').show();
				$('#tdDistributor').show();
				$('#tdSubdistributor').show();
				$('#distributor').empty();
				$('#subdistributor').empty();
				$('#superdistributor').empty();
/* 				$('#RAP_54').attr('checked', false);
				$('#RAP_54').hide(); */
			}  else if(id == 15) {
				$('#tdMasteragent').show();
				$('#tdDistributor').hide();
				$('#tdSubdistributor').hide();
				$('#tdSuperdistributor').hide();
				$('#distributor').empty();
				$('#subdistributor').empty();
				$('#superdistributor').empty();
/* 				$('#RAP_54').attr('checked', true);
				$('#RAP_54').show(); */
			} 
			
			if(ptypeId == 0)
				selMagent();
			else if(ptypeId == 11)
				selSupDist();
				//selDist();
			else if(ptypeId == 12)
				selSubDist();
			else if(ptypeId == 15)
				selDist();
			
			
		} else {
			selRolesList(id);
			selMinigames(0);
			$('#tdMasteragent').hide();
			$('#tdDistributor').hide();
			$('#tdSubdistributor').hide();
			$('#tdSuperdistributor').hide();
		}
	
	});
	
	
});

function selMagent() {
	$('#distributor').empty();
	$('#subdistributor').empty();
	$('#superdistributor').empty();
	var ptype=$("#partnertype").val();
	var dataString = 'id='+ ptype;
	$.ajax
	({
		type: "POST",
		url: "<? echo base_url(); ?>partners/ajaxcall/",
		data: dataString,
		cache: false,
		success: function(html)
		{
			$("#spanMasteragent").html(html);
			selRolesList(ptype);
		} 
	});
}

function selSupDist() {
	$('#distributor').empty();
	$('#subdistributor').empty();
	var ptype=$("#partnertype").val();
	var id=$("#masteragent").val();

	if(ptype == 15) {
		selMinigames(id);
		return false;
	}
	
	$('#distributor').empty();
	if(id == '') {
		$('#superdistributor').empty();
		return false;
	}

	var dataString = 'pid='+ id;
	$.ajax
	({
		type: "POST",
		url: "<? echo base_url(); ?>partners/ajaxcall/selectSuperDistributor/",
		data: dataString,
		cache: false,
		success: function(html)	{
			$("#spanSuperDistributor").html(html);
			selMinigames(id);
		} 
	});
}

function selDist() {
	$('#subdistributor').empty();
	var ptype=$("#partnertype").val();
	var id=$("#superdistributor").val();
	$('#subdistributor').empty();
	if(id == '') {
		$('#distributor').empty();
		return false;
	}
	var dataString = 'pid='+ id;
	$.ajax
	({
		type: "POST",
		url: "<? echo base_url(); ?>partners/ajaxcall/selectDistributor/",
		data: dataString,
		cache: false,
		success: function(html)
		{
			$("#spanDistributor").html(html);
			selMinigames(id);
		} 
	});
}

function selSubDist() {

	var ptype=$("#partnertype").val();
	var id=$("#distributor").val();
	if(id == '') {
		$('#subdistributor').empty();
		return false;
	}
	var dataString = 'pid='+ id;
	$.ajax
	({
		type: "POST",
		url: "<? echo base_url(); ?>partners/ajaxcall/selectSubDistributor/",
		data: dataString,
		cache: false,
		success: function(html)
		{
			$("#spanSubdistributor").html(html);
			selMinigames(id);
		} 
	});
}

function selMinigames(pid) {
	$('#commission_type').hide();
	$('#percentage').val('');
	$('#part_Id').val(pid); //user for percentage caluculation
	
	var ptype=$("#partnertype").val();
	var dataString = {'ptype': ptype, 'pid': pid};
	$.ajax
	({
		type: "POST",
		url: "<? echo base_url(); ?>partners/ajaxcall/selectMinigames/",
		data: dataString,
		dataType: 'json',
		cache: false,
		success: function(data){
			$("#divMinigames").html(data.form);
			$('#agentgames').empty();
			$("#poker").hide();
			$('input[name^="allgames_"]').change(function() {
				var catID=this.id.split("_");
				console.log(catID);
				if($(this).is(':checked')) {
					$("input[id^='"+catID[1]+"_games']").each(function(i, el) {		
						$("#"+el.id).prop("checked",true);				
					});
				} else {
					$("input[id^='"+catID[1]+"_games']").each(function(i, el) {		
						$("#"+el.id).prop("checked",false);		
					});
				}
			});

			$('input[id*="_games_"]').change(function() {
				if ($("#"+this.id).prop("checked")==false){
					var catID1=this.id.split("_");
					$("#allgames_"+catID1[0]).prop("checked",false);	
				} 
			});
		} 
	});
}

function selRolesList(ptype) {
	
	var dataString = {'ptype': ptype};
	$.ajax
	({
		type: "POST",
		url: "<? echo base_url(); ?>partners/ajaxcall/selectMenuList/",
		data: dataString,
		cache: false,
		success: function(html)
		{
			$("#tdMenulist").html(html);
		} 
	});
}

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
	
	function checkBal(ptype, pid, amt) {
		//var dataString = "ptype="+ptype+"pid="+pid+"amt="+amt;
		//data: 'code='+code+'userid='+userid,
		var dataString = {'ptype': ptype, 'pid': pid, 'amt': amt};
		
		var ret = false;
		$.ajax
		({
			type: "POST",
			url: "<? echo base_url(); ?>partners/ajaxcall/balanceCheck/",
			data: dataString,
			cache: false,
			async: false,
			success: function(html)
			{
				ret = html;
			} 
		});
		return ret;
	}
	
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		number: true
	};
	jQuery.validator.addMethod('mstagent', function (value, element, param) {
        if($('#partnertype').val() == 2 && value !='') {
			return true;
		} else if($('#partnertype').val() > 2 && value !='') {
			return true;
		} else {
			return false;
		}
    }, 'Please select options');
	
	jQuery.validator.addMethod('validAmount', function (value, element, param) {
       	var prtType = $('#partnertype').val(); //ptypeId partId
	    if($('#partnertype').val() == 2 && parseInt(value) > 0) {
			if($('#masteragent').val()) var pid = $('#masteragent').val(); else var pid= partId;
			if(pid > 0) {
				if(checkBal(prtType, pid, value) == 'true')
					return true;
				else
					return false;
			} else {
				return false;
			}
		} else if($('#partnertype').val() == 3 && parseInt(value) > 0) {
			if($('#distributor').val()) var pid = $('#distributor').val(); else var pid= partId;
			if(pid > 0) {
				if(checkBal(prtType, pid, value) == 'true')
					return true;
				else
					return false;
			} else {
				return false;
			}
		} else if($('#partnertype').val() == 4 && parseInt(value) > 0) {
			if($('#subdistributor').val()) var pid = $('#subdistributor').val(); else if($('#distributor').val()) var pid = $('#distributor').val(); else var pid= partId;
			
			if(pid > 0) {
				if(checkBal(prtType, pid, value) == 'true')
					return true;
				else
					return false;
			} else if($('#distributor').val() != '') {
				if(checkBal(prtType, $('#distributor').val(), value) == 'true')
					return true;
				else
					return false;
			} else {
				return false;
			}
		} else {
			return true;
		}
    }, 'Insufficient Balance');
	
	jQuery.validator.addMethod('minigamesRevenue', function (value, element, param) {
		var mgCnt = $("#agentgames option").length;
			if(mgCnt > 0 && parseInt(value) <= 0) {
				return false;
			} else {
				return true;
			}
    }, 'Please enter game commission');
	
	jQuery.validator.addMethod('calculate', function (value, element, param) {
		var ptype =$('#partnertype').val();
		if(ptype==''){
			$('#percentage').val('');
			alert('please select partner type');
			return false;
		}
		var pid =$('#part_Id').val();
		var dataString = {'pt': value, 'ptype': ptype, 'pid': pid};
		var ret=0;
			$.ajax({
				type: "POST",
				url: "<? echo base_url(); ?>partners/ajaxcall/calculate/",
				data: dataString,
				cache: false,
				async: false,
				success: function(status){
					ret = status;
				} 
			}); 
			if(ret == 0){
				$('#commission_type').hide();
				return false;
			}else{
				$('#commission_type').show();
				//$("#com_type").html(ret);
				if(ret =='success'){
					$("#com_type").show();
					$("#com_type1").hide();
				}else{
					$("#com_type").hide();
					$("#com_type1").show().html(ret);
				}
				return true;
			}
			
    }, 'Please enter less then or equal percentage');
	
	 jQuery.validator.addMethod("usernameRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\._]+$/i.test(value);
    }, "Only allowed letters, numbers, period or underscore.");
	
	$('#add-partner').validate({
		rules: {
			partnername: {
      		required: true,
			minlength: 4,
			usernameRegex: true
    	},
		partnertype: ruleSet1,
		masteragent: {
			mstagent: true
		},
		superdistributor: {
			mstagent: true
		},
		distributor: {
			mstagent: true
		},
		p_username: {
			required: true,
			minlength: 4,
			usernameRegex: true,
			remote: '<?php echo base_url();?>partners/partners/chkUserExistence/'
		},
		p_password: {
			required: true,
			minlength: 4
		},
		transactionpassword: {
			minlength: 4
		},	
		amount: {
			number:true,
			validAmount: true
		},
		commissiontype: ruleSet1,
		percentage: {
			required: true,
			max: 100,
			number: true,
			calculate: true
			
		},
		gc_percentage: {
			minigamesRevenue: true
		}
		//phone: ruleSet2
  	},
	messages: {
    	partnername: {
			required:"Please enter the partner name"
		},
		partnertype: "Please select the partner type",
		masteragent: "Please select the master agent",
		masteragent: "Please select the distributor",
		p_username: {
			required: "Enter the username",
			remote: jQuery.format("{0}")
		},
		p_password: {
		required:"Enter the password"
		},
		
		commissiontype: "Select the commission type",
		percentage:{ 
			required: "Enter the commission percentage",
			calculate: "Percentage(%) not more then your immediate parent"
		},
		gc_percentage: "Please enter game commission"
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
<script language="javascript" type="text/javascript">
$(document).ready(function(){
//clicking the parent checkbox should check or uncheck all child checkboxes
	$(".parentCheckBox").click(function() {
		$(this).parents('tr:eq(0)').find('.childCheckBox').attr('checked', this.checked);
	});
//clicking the last unchecked or checked checkbox should check or uncheck the parent checkbox
	$('.childCheckBox').click(function() {
		if ($(this).parents('tr:eq(0)').find('.parentCheckBox').attr('checked') == true && this.checked == false)
		$(this).parents('tr:eq(0)').find('.parentCheckBox').attr('checked', false);
		var flag = false;
		$(this).parents('tr:eq(0)').find('.childCheckBox').each(function() {
			if (this.checked == true)
				flag = true;
		});
		$(this).parents('tr:eq(0)').find('.parentCheckBox').attr('checked', flag);
	});

});

$(document).ready(function() {

	$("#btnAdd").click(function() {
		$("#minigames > option:selected").appendTo("#agentgames");
	});

	$("#btnAddAll").click(function() {
		$("#minigames > option").appendTo("#agentgames");
	});

	$("#btnRemove").click(function() {
		$("#agentgames > option:selected").appendTo("#minigames");
	});

	$("#btnRemoveAll").click(function() {
		$("#agentgames > option").appendTo("#minigames");
	});
	
	$("#frmSubmit").click(function() {
		$("#agentgames option").prop("selected", "selected");
        //$('#agentgames select option').prop('selected', true);
    });
});
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
			echo form_open('partners/partners/addpartner?rid='.$rid,$attributes);
			echo form_hidden('partnerid', ADMIN_ID);
		?>
		<input type="hidden" id="part_Id"/>
		<input type="hidden" name="current_user_session_id" value="<?php echo $this->session->userdata('session_id');?>"  />
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Create Agent</strong></td>
                </tr>
            </table>
			<?php if($this->session->flashdata('message')) { ?>
				<table width="100%" class="SuccessMsg">
		          <tbody>
                  <tr>
            		<td width="45"><img width="45" height="34" alt="" src="<?php echo base_url();?>static/images/icon-success.png"></td>
            		<td width="95%"><?php echo $this->session->flashdata('message');?></td>
          		   </tr>
        		  </tbody>
                 </table>
            <?php }elseif($_REQUEST['msg']=="1"){ ?>
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
                                <!--<td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php //echo form_label('Partner Name<span class="mandatory">*</span> :', 'PartnerName');?>
                                    </span>
                                    <?php
                                      /*  $EntityName = array(
                                              'name'        => 'partnername',
                                              'id'          => 'partnername',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '30'
                                            );		
                                        echo form_input($EntityName); */			
                                    ?>                      
                                </td>-->
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Partner Type<span class="mandatory">*</span> :', 'PartnerType');?>
                                    </span>
                                    <?php
                                    $options[''] = '---- select partner type ----';
										foreach($partnerTypes as $partnerType) {
											 $options[$partnerType->PARTNER_TYPE_ID] = $partnerType->PARTNER_TYPE;
										}
										echo form_dropdown('partnertype', $options,'','id="partnertype" class="cmbTextField"');
                                    ?>                     
                                </td>
                                <?php if($ptypeID < 14 || $ptypeID == 15) { 
	                                 	 if($ptypeID == 0) { ?>
			                                <td width="33%" class="control-group" id="tdMasteragent" style="display:none;">
			                                    <span class="TextFieldHdr">
			                                        <?php echo form_label('Master Agent <span class="mandatory">*</span> :', 'masteragent');?>
			                                    </span>
			                                    <span id="spanMasteragent"></span>
			                                </td>
                               		<?php } 
                                } ?>                                        
                            </tr>
                            <?php if($ptypeID < 14 || $ptypeID == 15) { ?>
                            <tr>
                            <?php if($ptypeID ==11 || $ptypeID ==0) { // super dist showed only main agent and admin login ?> 
                                <td width="33%" class="control-group" id="tdSuperdistributor" style="display:none;">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Super Distributor <span class="mandatory">*</span> :', 'superdistributor');?>
                                    </span>
                                      <span id="spanSuperDistributor"><?php echo form_dropdown('superdistributor', array(''=>'-- Select --'),'','id="superdistributor" class="cmbTextField"'); ?></span>
                                </td>
                          <?php } if($ptypeID < 12 || $ptypeID == 15) { ?> 
                                <td width="33%" class="control-group" id="tdDistributor" style="display:none;">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Distributor <span class="mandatory">*</span> :', 'distributor');?>
                                    </span>
                                    <span id="spanDistributor"><?php echo form_dropdown('distributor', array(''=>'-- Select --'),'','id="distributor" class="cmbTextField"'); ?></span>
                                </td> 
                                <?php } if($ptypeID < 13 || $ptypeID == 15) { ?> 
                                <td width="33%" class="control-group" id="tdSubdistributor" style="display:none;">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Sub Distributor :', 'subdistributor');?>
                                    </span>
                                    <span id="spanSubdistributor"><?php echo form_dropdown('subdistributor', array(''=>'-- Select --'),'','id="subdistributor" class="cmbTextField"'); ?></span>
                                </td>
                                <?php } ?>                                                                    
                            </tr>
                            <?php } ?>
                            <tr>
                                <td width="33%" id="newUserName" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Username<span class="mandatory">*</span> :', 'Username');?>
                                    </span>
                                    <?php
                                        $Username = array(
                                              'name'        => 'p_username',
                                              'id'          => 'p_username',
											  //'onChange'	=> 'javascript:chkUserExistence(this.value)',
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
                                              'name'        => 'p_password',
                                              'id'          => 'p_password',
											  'type'		=> 'password',											  
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '15'
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
                                              'maxlength'   => '15'
                                            );		
                                        echo form_input($Transactionpassword);			
                                    ?>                     	
                                </td>                                        
                            </tr> 
                            <tr>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Amount :', 'amount');?>
                                    </span>
                                    <?php
                                        $amount = array(
                                              'name'        => 'amount',
                                              'id'          => 'amount',
                                              'value'          => '0',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '10'
                                            );		
                                        echo form_input($amount);			
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
                            </tr>
                            <input type="hidden" name="lc_commissiontype" id="lc_commissiontype" value="" />
                            <input type="hidden" name="lc_percentage" id="lc_percentage" value="" />
                            <input type="hidden" name="lc_available" id="lc_available" value="" />
                           <!-- <tr>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('LC Commission Type :', 'lc_commissiontype');?>
                                    </span>
                                    <?php
										$optionsLC[''] = '-- Select --'; 
										foreach($commissionTypes as $commissionType) {
											 $optionsLC[$commissionType->AGENT_COMMISSION_TYPE_ID] = $commissionType->AGENT_COMMISSION_TYPE;
										}
										echo form_dropdown('lc_commissiontype', $optionsLC,'','id="lc_commissiontype" class="cmbTextField"');
                                    ?>                     
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('LC Percentage (%) :', 'lc_percentage');?>
                                    </span>
                                    <?php
                                        $lc_percentage = array(
                                              'name'        => 'lc_percentage',
                                              'id'          => 'lc_percentage',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '3'
                                            );		
                                        echo form_input($lc_percentage);			
                                    ?>                   	
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('LC Availability :', 'lc_available');?>
                                    </span>
                                    <?php
										$data = array(
											'name'        => 'lc_available',
											'id'          => 'lc_available',
											'value'       => '1',
											'checked'     => false,
											'style'       => 'margin:10px',
											);
										
										echo form_checkbox($data);
                                    ?>                   
                                </td>                                                                        
                            </tr> -->                                                       
                                                      
                        </table>
                    </td>
                </tr> 
                
                <tr>
                	<td colspan="3">
                        <table width="100%" class="PageHdr">
                            <tr>
                                <td><strong>Game Settings:</strong></td>
                            </tr>
                        </table>                    
                    </td>
               	</tr>
                <tr>
                	<td colspan="3">
                        <table width="100%" class="PageHdr">
					<tr>
						<td id="divMinigames">
							<?php echo $this->load->view("partners/categoryinfo"); ?>
							
						</td>
					</tr>
                            <tr>
                                <td>
                                    <div style="float:left; width:250px;">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Selected Games Commission in (%) :', 'gc_percentage');?>
                                    </span>
                                    <span class="control-group">
                                    <?php
                                        $lc_percentage = array(
                                              'name'        => 'gc_percentage',
                                              'id'          => 'gc_percentage',
                                              'value'		=> '0',		
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '3'
                                            );		
                                        echo form_input($lc_percentage);			
                                    ?>
                                    </span>
                                    </div>
                                    
                                    <div style="float:left; width:250px;display:none;" id="commission_type">
                                     <span class="TextFieldHdr">
                                        <?php echo form_label('Commission Type<span class="mandatory">*</span> :', 'CommissionType');?>
                                    </span>
                                    <span class="control-group" id="com_type">
                                    <?php
										$optionsCT[''] = '-- Select --'; 
										foreach($commissionTypes as $commissionType) {
											 $optionsCT[$commissionType->AGENT_COMMISSION_TYPE_ID] = $commissionType->AGENT_COMMISSION_TYPE;
										}
										echo form_dropdown('commissiontype', $optionsCT,'','id="commissiontype" class="cmbTextField" required');
									?>   
                                    </span>
									<span class="control-group" id="com_type1">
									</span>
                                    </div>
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
                	<td colspan="3" id="tdMenulist"> 
                 		<?php echo $this->load->view("partners/ajax_menulist"); ?>
                    </td>
                </tr>
                              
                <tr>
                	<td colspan="3">
						<?php
                            echo form_submit('frmSubmit', 'Create',' id="frmSubmit"')."&nbsp;";
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
<script>
$(document).ready(function () {
$('input[name^="allgames_"]').change(function() {
	var catID=this.id.split("_");
	console.log(catID);
	if($(this).is(':checked')) {
		$("input[id^='"+catID[1]+"_games']").each(function(i, el) {		
			$("#"+el.id).prop("checked",true);				
		});
	} else {
		$("input[id^='"+catID[1]+"_games']").each(function(i, el) {		
			$("#"+el.id).prop("checked",false);		
		});
	}
});

$('input[id*="_games_"]').change(function() {
	if ($("#"+this.id).prop("checked")==false){
		var catID1=this.id.split("_");
		$("#allgames_"+catID1[0]).prop("checked",false);	
	} 
});

});

</script>
<?php $this->load->view("common/footer"); ?>	