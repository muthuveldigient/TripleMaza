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
	 jQuery.validator.addMethod("usernameRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\._]+$/i.test(value);
    }, "Only allowed letters, numbers, period or underscore.");
	$('#edit-partner').validate({
		rules: {
			partnername: {
      		required: true,
			minlength: 4,
			usernameRegex: true
    	},
		partnertype: ruleSet1,
		username: ruleSet1,
		password: {
			required: true,
			minlength: 4
		},
		transactionpassword: {
			minlength: 4
		},
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
    	partnername: {
		required:"Please enter the partner name"
		},
		partnertype: "Please select the partner type",
		username: "Enter the username",
		password: {required:"Enter the password"},
		commissiontype: "Select the commission type",
		percentage: {required:"Enter the commission percentage",max:"Please enter less or equal 100"}
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
</script>
<style>
td.editgame a, td.editgame a:active {
    color: #f3eeec;
    text-decoration: none;
    font-weight: bold;
    float: right;
}

</style>

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
			echo form_open('partners/partners/editpartner',$attributes,$hidden);
		?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Edit Agent</strong></td>
					<td class="editgame"><a href="<?php echo base_url().'partners/partners/editgame/'.base64_encode($parterDetails[0]->PARTNER_ID).'?rid=51';?>"><button name="frmClear" type="button">Edit games</button></a></td>
				</tr>
            </table>
			<?php if($this->session->flashdata('message')) { ?>
				<table width="100%" class="SuccessMsg">
		          <tbody>
                  <tr>
            		<td width="45"><img width="45" height="34" alt="" src="<?php echo base_url(); ?>/static/images/icon-success.png"></td>
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
                                <!--<td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php //echo form_label('Partner Name<span class="mandatory">*</span> :', 'PartnerName');?>
                                    </span>
                                    <?php
                                      /*  $EntityName = array(
                                              'name'        => 'partnername',
                                              'id'          => 'partnername',
											  'value'		=> $parterDetails[0]->PARTNER_NAME,
                                              'class'		=> 'TextField',
                                              'maxlength'   => '30'
                                            );
                                        echo form_input($EntityName);*/
                                    ?>
                                </td>-->
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
										echo form_hidden('ext_transactionpassword', $parterDetails[0]->TRANSACTION_PASSWORD);
                                        $Transactionpassword = array(
                                              'name'        => 'transactionpassword',
                                              'id'          => 'transactionpassword',
											  'type'		=> 'password',
											  'value'		=> 'digient',
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
                                        <?php echo form_label('Commission Type<span class="mandatory">*</span> :', 'commissiontype');?>
                                    </span>
                                   <?php
										if($edit_partner_type==11 || $edit_partner_type==15){
										
											foreach($commissionTypes as $commissionType) {
												 $optionsCT[$commissionType->AGENT_COMMISSION_TYPE_ID] = $commissionType->AGENT_COMMISSION_TYPE;
											}
											echo form_dropdown('commissiontype', $optionsCT,$parterDetails[0]->PARTNER_COMMISSION_TYPE,'id="commissiontype" class="cmbTextField"');
										}else{
											echo ($parterDetails[0]->PARTNER_COMMISSION_TYPE==1?'Turn over':($parterDetails[0]->PARTNER_COMMISSION_TYPE ==2?'Revenue':'Invalid'));
										}
										
                                    ?>
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Percentage(%)<span class="mandatory">*</span> :', 'percentage');?>
                                    </span>
                                    <?php
										if($edit_partner_type==11 || $edit_partner_type==15){
											$Percentage = array(
												  'name'        => 'percentage',
												  'id'          => 'percentage',
												  'value'		=> $parterDetails[0]->PARTNER_REVENUE_SHARE,
												  'class'		=> 'TextField',
												  'maxlength'   => '3'
												);
											echo form_input($Percentage);
										}else{
											echo $parterDetails[0]->PARTNER_REVENUE_SHARE;
										}
                                    ?>
                                </td>
                                <td width="33%">
                                </td>
                            </tr>
                            <input type="hidden" name="lc_commissiontype" id="lc_commissiontype" value="" />
                            <input type="hidden" name="lc_percentage" id="lc_percentage" value="" />
                            <input type="hidden" name="lc_available" id="lc_available" value="" />
                            <!--<tr>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('LC Commission Type :', 'CommissionType');?>
                                    </span>
                                    <?php
										foreach($commissionTypes as $commissionType) {
											 $optionsCT[$commissionType->AGENT_COMMISSION_TYPE_ID] = $commissionType->AGENT_COMMISSION_TYPE;
										}
										echo form_dropdown('lc_commissiontype', $optionsCT,$parterDetails[0]->LC_COMMISSION_TYPE,'id="lc_commissiontype" class="cmbTextField" disabled');
                                    ?>
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('LC Percentage(%) :', 'lc_percentage');?>
                                    </span>
                                    <?php
                                        $Percentage = array(
                                              'name'        => 'lc_percentage',
                                              'id'          => 'lc_percentage',
											  'readonly'	=> true,
											  'value'		=> $parterDetails[0]->LC_REVENUE_SHARE,
                                              'class'		=> 'TextField',
                                              'maxlength'   => '2'
                                            );
                                        echo form_input($Percentage);
                                    ?>
                                </td>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('LC Availability :', 'lc_available');?>
                                    </span>
                                    <?php
										if($parterDetails[0]->LC_STATUS == 1) $chk = true; else  $chk = false;
										$data = array(
											'name'        => 'lc_available',
											'id'          => 'lc_available',
											'value'       => '1',
											'checked'     => $chk,
											'style'       => 'margin:10px',
											);

										echo form_checkbox($data);
                                    ?>
                                </td>
                            </tr>     -->

                        </table>
                    </td>
                </tr>

               
                <tr>
                	<td colspan="3">
                        <table width="100%" class="PageHdr">
                          	 <tr>
                                <td><strong>Game Settings:</strong></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" id="rolesandPermissions" class="rolesandPermissions">
                                	<?php
										$k=3; $i=1;

										$options = array();
										echo '<tr>';
										foreach($minigamesList as $minigamesL) {
											if(array_key_exists($minigamesL->MINIGAMES_NAME, $partnerGameRevenue)){
												if($partnerGameRevenue[$minigamesL->MINIGAMES_NAME]!='')
													$value = $partnerGameRevenue[$minigamesL->MINIGAMES_NAME];
												else
													$value = 0;
											}else{
												$value = 0;
											}

											if($minigamesL->MINIGAMES_NAME != 'shan_mp' && $minigamesL->MINIGAMES_NAME != 'mobpoker'){
											echo form_hidden('minigamesAll[]', $minigamesL->MINIGAMES_NAME);
											$mgameRevenur = array(
												  'name'        => 'agentgames[]',
												  'id'          => 'agentgames',
												  'value'		=> $value,
												  'maxlength'   => '15'
												);

											echo '<td width="33%" style="line-height:2em;"><strong>'.ucwords(strtolower($minigamesL->DESCRIPTION)).'</strong><br />'.form_input($mgameRevenur).'</td>';
											}

											if($i==$k) {
												echo '</tr><tr>';
												$i=1;
											} else {
												$i++;
											}
										}
									?></tr>
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
                                <td><strong>Manage Balance</strong></td>
                            </tr>
                        </table>
                    </td>
               	</tr>
              	<tr>
                	<td colspan="3">
                    	<table width="100%" id="rolesandPermissions" class="rolesandPermissions">
                        <tr>
                        <td>Balance: <?PHP echo $this->partner_model->getPartnerBalance($parterDetails[0]->PARTNER_ID); ?></td>
                        <?php
						//echo $parterDetails[0]->PARTNER_ID;
						//$encPartnerId = $this->encrypt->encode($parterDetails[0]->PARTNER_ID);
						$encPartnerId = base64_encode($parterDetails[0]->PARTNER_ID);
?>

                        <td class="ink">Adjust Balance: <?PHP echo '<a href="'.base_url().'partners/partners/adjust?pid='.$encPartnerId.'&pty='.base64_encode($parterDetails[0]->FK_PARTNER_TYPE_ID).'&rid=51">Manage</a>' ?></td>
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
                    	<?php echo $this->load->view("partners/ajax_edit_menulist"); ?>
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
