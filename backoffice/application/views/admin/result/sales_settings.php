<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.plugin.js"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.countdown.js"></script>

<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>    
<script language="javascript" type="text/javascript">
    $(document).ready(function(){

        $('#salesForm').validate({
            rules: {
              single: {
                  required: true,
                  digits: true,
              },double: {
                  required: true,
                  digits: true,
              },triple: {
                  required: true,
                  digits: true,
              },
            },
            messages: {
            	single: {
                  required:"Single field is required.",
                  digits:"Single value must be numeric.",
                },double: {
                  required:"Double field is required.",
                  digits:"Double value must be numeric.",
                },triple: {
                  required:"Triple field is required.",
                  digits:"Triple value must be numeric.",
                },
            },
        });
    }); // end document.ready
</script>

<style type="text/css">
	
	.curr_settings_field {
	    margin-right: 18px;
	    color: #7a5f00;
	    border-radius: 5px;
	    padding: 15px;
	    font-weight: bold;
	    font-size: 16px;
	}

</style>
<div id="shadowing1"></div>
<div class="MainArea">
  <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
	  <?php 
	  if(!empty($message)) {?>
		<div class="UpdateMsgWrap ticket_message" style="display:block">
			<table width="100%" class="<?php echo $class; ?>" id="msg-class">
				<tbody>
					<tr>
						<td width="95%" id="msg"><?php echo $message; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php }?>	
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Sales Settings</strong></td>
          </tr>
        </table>

        <table width="100%" cellpadding="10" cellspacing="10" class="searchWrap">
			<tr>
				<td>
					<!-- <div class="curr_settings">Sales Settings : </div> -->
					<?php if(!empty($salesInfo)) { ?>
					<form action="" method="post" name="salesForm" id='salesForm'>
					<div class="curr_settings_field">
						<label class="">Single : </label>
						<input type="text" class="TextField" maxlength="7" style="width:200px" id="single" name="single" value="<?php echo (!empty($salesInfo[0]->SINGLE)?$salesInfo[0]->SINGLE:0); ?>"/>
						
						<label class="">Double : </label>
						<input type="text" class="TextField" maxlength="7" style="width:200px" id="double" name="double" value="<?php echo (!empty($salesInfo[0]->DOUBLE)?$salesInfo[0]->DOUBLE:0); ?>"/>
						
						<label class="">Triple : </label>
						<input type="text" class="TextField" maxlength="7" style="width:200px" id="triple" name="triple" value="<?php echo (!empty($salesInfo[0]->TRIPLE)?$salesInfo[0]->TRIPLE:0); ?>"/>
						<br />
						<input type="submit" class="" id="submit" name="submit" value="Update"/>
					</div>
					<div width="30%" style="font-size: 15px;color: red;font-weight: bold;">Note:After updating the page, you must restart the game server</div>
					</form>
					<?php } ?>
				</td>
			</tr>
		</table>
		
      </div>
    </div>
  </div>
</div>

<?php $this->load->view("common/footer"); ?>
