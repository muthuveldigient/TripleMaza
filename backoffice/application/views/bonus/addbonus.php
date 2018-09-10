<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>   
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#add-bonus').validate({
		rules: {
			bonustype: {
      		required: true
    	},cointype: {
			required: true
		},status: {
			required: true	
		},value: {
			required: true,
			number:true	
		}
  	}
 });
}); // end document.ready
</script> 
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>             
        <?php 
			$attributes = array('id' => 'add-bonus');
			echo form_open('general/bonus/addBonus',$attributes);
		?>
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Create Bonus</strong></td>
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
						<table width="100%" cellpadding="10" cellspacing="10">
                            <tr>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Bonus Type<span class="mandatory">*</span> :', 'BonusType');?>
                                    </span>
                                    <?php
										echo '<select name="bonustype" id="bonustype" class="lstTextField">';
										echo '<option value="" selected="selected">-- Select --</option>';
										foreach($getBonusTypes as $bType) {			
											echo '<option value="'.$bType->BONUS_TYPE_ID.'">'.$bType->NAME.'</option>';
										}
										echo '</select>';
                                    ?>                      
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Coin Type<span class="mandatory">*</span> :', 'PartnerType');?>
                                    </span>
                                    <?php
										echo '<select name="cointype" id="cointype" class="lstTextField">';
										echo '<option value="">-- Select --</option>';
										foreach($getCoinTypes as $cType) {
											echo '<option value="'.$cType->COIN_TYPE_ID.'">'.$cType->NAME.'</option>';
										}
										echo '</select>';	
                                    ?>                     
                                </td>                                       
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
                                        <?php echo form_label('Staus<span class="mandatory">*</span> :', 'Status');?>
                                    </span>
                                    <?php
										echo '<select name="status" id="status" class="lstTextField">';
											echo '<option value="1">Active</option>';
											echo '<option value="2">In Active</option>';
										echo '</select>';
                                    ?>                      
                                </td>
                                <td width="33%" class="control-group">
                                    <span class="TextFieldHdr">
                                        <?php echo form_label('Value<span class="mandatory">*</span> :', 'Value');?>
                                    </span>
                                    <?php
                                        $Value = array(
                                              'name'        => 'value',
                                              'id'          => 'value',
                                              'class'		=> 'TextField',												  
                                              'maxlength'   => '6'
                                            );		
                                        echo form_input($Value);			
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