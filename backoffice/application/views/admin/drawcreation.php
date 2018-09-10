<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/js/date.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>  
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>



<script language="javascript" type="text/javascript">
function chkNumberOfDraws() {
	var sDateTime=$('#START_DATE_TIME').val();
	var eDateTime=$('#END_DATE_TIME').val();
	var intervalT=$('#DRAW_INTERVAL').val();
	$.ajax({
		url: 'drawajax.php?sDate='+sDateTime+'&eDate='+eDateTime+'&iTime='+intervalT,
		type: 'GET',
		success: function(data) {	
			$('#TOTAL_NUMBER_OF_DRAWS').val(data);
		}
	});	
}

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
			DRAW_GAME_ID: {
				required:true
			},
			DRAW_NAME: {
				required: true	
			},
			DRAW_PRICE: {
				required: true	
			},
			START_DATE_TIME: {
				required: true	
			},
			END_DATE_TIME: {
				required: true	
			},
			DRAW_INTERVAL: {
				required: true	
			}
	    }, 
	    messages: {
			DRAW_GAME_ID: {
				required: "Please select the game." 
			},
	    	DRAW_NAME: {
				required: "Please enter draw name." 
			},
	    	DRAW_PRICE: {
				required: "Please select the draw price." 
			},
	    	START_DATE_TIME: {
				required: "Please select the draw start date." 
			},
	    	END_DATE_TIME: {
				required: "Please select the draw end date." 
			},
			DRAW_INTERVAL: {
				required: "Please select the draw interval." 
			}
		},
        submitHandler: function (form) { // for demo 
			var totalNDraw = $('#TOTAL_NUMBER_OF_DRAWS').val();
			document.form.submit();
        }	
 });
});  // end document.ready
</script>

<script language="javascript" type="text/javascript">
function clearFrmValues() {
	$('#add-admin').each(function() {
	  this.reset();
	});	
}
</script>

<style>
.error{color:red;}
.success{color:green;}
</style>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
	   <?php 
			$attributes = array('id' => 'add-admin');
			echo form_open('admin/draw/createdraw',$attributes);
		?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Draw Creation</strong></td>
					
                </tr>
            </table>
			<?php
			if($_REQUEST["err"]==1) {
        		echo '<div class="vbacksucs_box success">Draw Created Successfully.</div>';  
			}
			if($_REQUEST["err"]==2) {
        		echo '<div class="vbackerr_box error">Start date should be greater than now.</div>';  
			}
			if($_REQUEST["err"]==3) {
        		echo '<div class="vbackerr_box error">End date should be greater than now.</div>';  
			}
			if($_REQUEST["err"]==4) {
        		echo '<div class="vbackerr_box error">Draw could not be created.</div>';  
			}
			if($_REQUEST["err"]==5) {
        		echo '<div class="vbackerr_box error">Draw count can not be blank.</div>';  
			}
			if($_REQUEST["err"]==6) {
        		echo '<div class="vbackerr_box error">Invalid input, Draw exists for the given time.</div>';  
			}
			if($_REQUEST["err"]==7) {
        		echo '<div class="vbackerr_box error">Please enter start date and end date.</div>';  
			}			
		 if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?> 
			
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
                                <td><strong>Creation</strong></td>
								<td style="float:right;"><a href="<?php echo base_url();?>admin/draw?rid=74"><strong>Draw List</strong></a></td>
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
                                        <?php echo form_label('Game Name<span class="mandatory">*</span> :', 'GameName');?>
                                    </span>
                                    <?php
                                        echo form_dropdown('DRAW_GAME_ID', $miniGameList, 'large','id="DRAW_GAME_ID" class="cmbTextField"');			
                                    ?>
                                    <div id="userExtError"></div>                     
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Draw Name(Description)<span class="mandatory">*</span> :', 'Draw Name');?>
                                    </span>
                                    <?php
                                        $draw = array(
                                              'name'        => 'DRAW_NAME',
                                              'id'          => 'DRAW_NAME',
											  'type'		=> 'test',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '12'
                                            );		
                                        echo form_input($draw);			
                                    ?>                    
                                </td>
								<td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Price <span class="mandatory">*</span>', 'Price');?>
                                    </span>
                                    <select name="DRAW_PRICE" id="DRAW_PRICE" class="Textselct">
                                	<option value="2">2</option>
                                	<option value="4">4</option>
                                	<option value="6">6</option>
                                	<option value="8">8</option>
                                	<option value="10">10</option>
									<option value="11">11</option>
									</select>         
                                </td>
                                                                       
                            </tr> 
                            <tr>
							<td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Start Date<span class="mandatory">*</span> :', 'Start Date');?>
                                    </span>
									<div>
                                    <?php
                                        $date = array(
                                              'name'        => 'START_DATE_TIME',
                                              'id'          => 'START_DATE_TIME',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '25'
                                            );		
                                        echo form_input($date);			
                                    ?>            
									 
									<a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" />									
                                   </a>
								    <label for="START_DATE_TIME" generated="true" class="error"></label>
								  </div>
								 
                                </td> 
								
                                 <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('End Date<span class="mandatory">*</span> :', 'End Date');?>
                                    </span>
									
                                    <?php
                                        $date = array(
                                              'name'        => 'END_DATE_TIME',
                                              'id'          => 'END_DATE_TIME',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '25'
                                            );		
                                        echo form_input($date);			
                                    ?>             
										<a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" />
                                    </a>
									<label for="END_DATE_TIME" generated="true" class="error"></label>
                                </td>                            
                                
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Draw Interval <span class="mandatory">*</span>', 'Draw Interval');?>
                                    </span>
                                    <select name="DRAW_INTERVAL" id="DRAW_INTERVAL" class="Textselct">
                                	<option value="">-- Select --</option>
                                	<option value="5">05Mins</option>                                    
                                	<option value="10">10Mins</option>
									<option value="15">15Mins</option>
                                	<option value="20">20Mins</option>
                                	<option value="30">30Mins</option>
                                	<option value="40">40Mins</option>
                                	<option value="50">50Mins</option>
                                	<option value="60">60Mins</option>                                                                                                                                                                                    
                                </select>                   	
                                </td>                                                                        
                            </tr>
                            <tr>
                                <td width="33%">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Status :', 'Status');?>
                                    </span>
										<select name="DRAW_STATUS" id="DRAW_STATUS" class="Textselct">
											<option value="1">Active</option>
											<option value="2">In-Active</option>                                                                                                                                                                                 
										</select>&nbsp;<span class="mandatory">*</span>                  
                                </td>
                                <td width="33%">
                                             
                                </td> 
                                <td width="33%">
                                    
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