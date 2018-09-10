<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.plugin.js"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.countdown.js"></script>
<script>

	$(document).ready(function(){
		$(".UpdateMsgWrap").hide();
		$('.draw_result').on('change', function() {

			if ( confirm( 'Are you sure you want to change streaming status ?' ) ) {

				var draw_value = ( $(this).is(':checked') ) ? 'active' : 'deactive';
				$('#shadowing1').show();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url();?>/admin/draw/streaming_settings',
					data: {'status': draw_value},
					cache: false,
					dataType: 'json',
					success: function(response) {
						if( response.STREAMING_STATUS == 1 ) {
							$('.slider').addClass('radio_blue');
						} else {
							$('.slider').removeClass('radio_blue');
						}
						$(".UpdateMsgWrap").show();
						$('#msg-class').addClass(response.class);
						$('#msg').html(response.message);
						$('#shadowing1').hide();
						window.setTimeout(function() {
							$(".UpdateMsgWrap").hide();
						}, 3000);
					}
				});
			}

		});

	});

</script>

<style>

.curr_draw_div {
    float: left;
    margin-right: 18px;
    /*background-color: #c8181e;*/
    color: #7a5f00;
    border-radius: 5px;
    padding: 15px;
    font-weight: bold;
    font-size: 16px;
	/*width: 209px;*/
	text-align: center;
}

/* Checkbox Slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/*.switch input {display:none;}*/

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #c8181e;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

/*input:checked + .slider {
  background-color: #2196F3;
}
input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
*/
input:focus + .slider {
  box-shadow: 0 0 1px #108604;
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.radio_blue{
	background-color: #108604;
}
.radio_blue::before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

</style>
<div id="shadowing1"></div>
<div class="MainArea">
  <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
		<div class="UpdateMsgWrap ticket_message">
			<table width="100%" class="" id="msg-class">
				<tbody>
					<tr>
						<td width="95%" id="msg"></td>
					</tr>
				</tbody>
			</table>
		</div>
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Streaming Settings</strong></td>
          </tr>
        </table>

        <table width="100%" cellpadding="10" cellspacing="10" class="searchWrap">
			<tr>
				<td>
					<div class="curr_draw_div">STREAMING ON / OFF : </div>
					<div>
						<label class="switch">
							<?php
						  		$class   = !empty( $streamingInfo->STREAMING_STATUS ) ? 'radio_blue' : '';
						  		$checked = !empty( $class ) ? "checked='checked'" : '';
						    ?>
							<input type="checkbox" class="draw_result" <?php echo $checked; ?> >
							<span class="slider round <?php echo $class; ?>"></span>
						</label>
					</div>
				</td>
			</tr>
		</table>
		
      </div>
    </div>
  </div>
</div>

<?php $this->load->view("common/footer"); ?>
