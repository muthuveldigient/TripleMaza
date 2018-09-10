<link href="<?php echo base_url(); ?>jsValidation/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url(); ?>static/js/date.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>  
<script src="<?php echo base_url(); ?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>



<script language="javascript" type="text/javascript">

    $(document).ready(function () {
          
          $( "#add-admin" ).validate({
            rules: {
              DRAW_WINNUMBER: {
                required: true,
                maxlength: 3
              }
            },
            messages: {
                DRAW_WINNUMBER: {
                    required: "<li>Please enter a ticket number.</li>",
                    maxlength: "<li>Please enter 3 digits only.</li>"
                }
            }
          });

/*        $('#add_result').on('click', function (e) {
            $('#ticket_error').hide();
            $('.ticket_message').hide();
            e.preventDefault();
            var TICKET_NUMBER = $('#TICKET_NUMBER').val();
//            var DRAW_DATETIME = $('#DRAW_DATETIME').val();
            var DRAW_NUMBER = $('#DRAW_NUMBER').val();
            if (TICKET_NUMBER == '' && DRAW_NUMBER == '') {
                $('#ticket_error').show();
                $('#ticket_error_msg').html('Please fill mandatory fields.');
            } else if (DRAW_NUMBER == '') {
                $('#ticket_error').show();
                $('#ticket_error_msg').html('Please select the date.');
            } else if (TICKET_NUMBER == '') {
                $('#ticket_error').show();
                $('#ticket_error_msg').html('Please enter ticket number.');
            } else if (TICKET_NUMBER > 999) {
                $('#ticket_error').show();
                $('#ticket_error_msg').html('Please enter ticket number less than 999 value.');
            } else {
                $('#add-admin').submit();
            }
        });*/

    });

</script>

<script language="javascript" type="text/javascript">
    function clearFrmValues() {
        $('#add-admin').each(function () {
            this.reset();
        });
    }
</script>

<style>
    .UpdateMsgWrap {
        margin-top: 5px;
    }
</style>

<div class="MainArea">
    <?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
        <div class="content_wrap">
            <div class="tableListWrap">
                <?php
//                if ($_REQUEST["err"] == 1) {
//                    echo '<div class="vbacksucs_box">Draw Created Successfully.</div>';
//                }
//                if ($_REQUEST["err"] == 4) {
//                    echo '<div class="vbackerr_box">Draw could not be created.</div>';
//                }
                ?>

                <?php
                $attributes = array('id' => 'add-admin');
                echo form_open('admin/draw/result', $attributes);
                ?>
                <table width="100%" class="ContentHdr">
                    <tr>
                        <td><strong>Enter Result</strong></td>

                    </tr>
                </table>
                <?php if (!empty($msg_success)) { ?>
				<script type="application/javascript">
					$(".UpdateMsgWrap").show();
					window.setTimeout(function() {
						$(".UpdateMsgWrap").hide();
					}, 4000);
				</script>
                    <div class="UpdateMsgWrap ticket_message">
                        <table width="100%" class="SuccessMsg">
                            <tbody>
                                <tr>
                                    <td width="95%"><?php echo $msg_success; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php if (!empty($msg_error)) { ?>
				<script type="application/javascript">
					$(".UpdateMsgWrap").show();
					window.setTimeout(function() {
						$(".UpdateMsgWrap").hide();
					}, 4000);
				</script>
                    <div class="UpdateMsgWrap ticket_message">
                        <table width="100%" class="ErrorMsg">
                            <tr>
                                <td width="95%"><?php echo $msg_error; ?></td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
                <div class="UpdateMsgWrap" id="ticket_error" style="display:none">
                    <table width="100%" class="ErrorMsg">
                        <tr>
                            <td width="95%"><span id="ticket_error_msg"></span></td>
                        </tr>
                    </table>
                </div>
                <table width="100%" class="searchWrap" bgcolor="#993366">
                    <tr>
                        <td colspan="3">
                            <table width="100%" class="PageHdr">
                                <tr>
                                    <td><strong>Create</strong></td>
                                    <td style="float:right;"><a href="<?php echo base_url(); ?>admin/draw/result_list"><strong>Result List</strong></a></td>
                                </tr>
                            </table>                    
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table width="100%" cellpadding="10" cellspacing="10">
                                <tr>
    <!--                                <td width="33%" class="control-group">
                                        <span class="TextFieldHdr">
                                    <?php //echo form_label('Result Date <span class="mandatory">*</span> :', 'Result Date'); ?>
                                        </span>
                                        <div>
                                    <?php
//                                            $date = array(
//                                                  'name'        => 'DRAW_DATETIME',
//                                                  'id'          => 'DRAW_DATETIME',
//                                                  'class'       => 'TextField',
//                                                  'required'    => 'true'
//                                                );      
//                                            echo form_input($date);         
                                    ?>            
                                             
                                            <a onclick="NewCssCal('DRAW_DATETIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url() ?>static/images/calendar.png" /></a>
    
                                            <label for="DRAW_DATETIME" generated="true" class="error"></label>
                                        </div>
                                    </td> -->
									
									<td width="33%" class="control-group">
                                        <span class="TextFieldHdr">
                                            <?php echo form_label('Draw Name <span class="mandatory">*</span> :', 'Draw Name'); ?>
                                        </span>
                                        <?php
										echo (!empty($drawList[0]->DRAW_DESCRIPTION)?$drawList[0]->DRAW_DESCRIPTION:'--');

										$draw = array(
                                            'name' => 'DRAW_NAME',
                                            'id' => 'DRAW_NAME',
                                            'type' => 'hidden',
                                            'class' => 'TextField',
											'value'=> (!empty($drawList[0]->DRAW_DESCRIPTION)?$drawList[0]->DRAW_DESCRIPTION:'')
                                        );
                                        echo form_input($draw); 
										
                                        ?>                    
                                    </td>
									
                                    <td width="33%" class="control-group">
                                        <span class="TextFieldHdr">
                                            <?php echo form_label('Draw Time <span class="mandatory">*</span> :', 'Draw Time'); ?>
                                        </span>
                                        <?php
											
										/* 	echo (!empty($drawList[0]->DRAW_STARTTIME)?$drawList[0]->DRAW_STARTTIME:'--');
											
                                         $draw = array(
                                            'name' => 'DRAW_ID',
                                            'id' => 'DRAW_ID',
                                            'type' => 'hidden',
                                            'class' => 'TextField',
											'value'=> (!empty($drawList[0]->DRAW_ID)?$drawList[0]->DRAW_ID:'')
                                        ); */
									
										foreach($drawList as $list ){
											$options[$list->DRAW_ID] = date('d-m-Y H:i:s',strtotime($list->DRAW_STARTTIME));
										}
										
                                        echo form_dropdown('DRAW_ID', $options, 'id="DRAW_ID"');;  
                                        ?>                    
                                    </td>
									
									

                                    <td width="33%" class="control-group">
                                        <span class="TextFieldHdr">
                                            <?php echo form_label('Win Number <span class="mandatory">*</span> :', 'Win Number'); ?>
                                        </span>
                                        <?php
                                        $draw = array(
                                            'name' => 'DRAW_WINNUMBER',
                                            'id' => 'DRAW_WINNUMBER',
                                            'type' => 'text',
                                            'class' => 'TextField',
                                            'required' => 'true'
                                        );
                                        echo form_input($draw);
                                        ?>                    
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="3">
                            <?php
                            echo form_submit('', 'Create', 'id=add_result') . "&nbsp;";
                           // echo form_button('frmClear', 'Clear', "onclick='javascript:clearFrmValues();'");
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