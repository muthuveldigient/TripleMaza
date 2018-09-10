<?php //error_reporting(0);


?>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.plugin.js"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.countdown.js"></script>
<script>

$(document).ready(function(){

	$(function () {
			//$('#ndrawLeftTime').html('00:00:00');
				var timeLeft = '';
				<?php if(!empty( $drawCountDownTime) ){ ?>
					timeLeft = new Date(<?php echo $drawCountDownTime;?>); //2016,0,06,11,56,01
					//$('#ndrawLeftTime').countdown({until: timeLeft,serverSync: serverTime, format: 'HMS', padZeroes: true, compact: true,onExpiry: liftOff});
					$('#ndrawLeftTime').countdown({
						until: timeLeft,
						serverSync: serverTime,
						format: 'HMS',
						//timezone: +5.5,
						padZeroes: true,
						compact: true,
						onExpiry: liftOff,
						onTick: function(periods) {
								var secs = $.countdown.periodsToSeconds(periods);
								if (secs < 120) {
									$('#ndrawLeftTime span').addClass('text_blink');
									$('#curr_draw').addClass('text_blink');
								}
							 }
						});
				<?php }?>
		}); 
	//	startInterval();

$('.form :input').keypress(function (e) { //digits only allowed
	if (e.which != 8 && e.which != 0 && ((e.which < 48) || (e.which > 57))) {
		return false;
	}
});


});

function liftOff() {
	$('#shadowing1').show();
	location.reload();
	/* var curDrawIDNext = $('#drawID').val();
	$('#ndrawLeftTime span').removeClass('text_blink');
	$.ajax({
		type:"POST",
		url:"<?php echo base_url();?>/admin/draw/nextdrawtime/"+curDrawIDNext,
		dataType: "json",
		success:function(response) {
			if(response.status =="available") {
				$('#drawID').val(response.DRAW_ID);
				$('#drawName').val(response.DRAW_NUMBER);
				$('#drawDateTime').val(response.DRAW_STARTTIME);
				$('#nxtdrawTime').html(response.NXT_DRAW_TIME);
				$('#curdrawTime').html(response.CUR_DRAW_TIME);
				$('#nxt_draw_list').html(response.NXT_SEL);
				var drawCountDownTime=response.COUNT_DOWN.split(",");
				var shortly = new Date();
				shortly = new Date(drawCountDownTime[0],drawCountDownTime[1],drawCountDownTime[2],drawCountDownTime[3],drawCountDownTime[4],drawCountDownTime[5]);
				$('#ndrawLeftTime').countdown('option', {until: shortly,serverSync: serverTime, format: 'HMS', padZeroes: true, compact: true,onExpiry: liftOff});
				location.reload();
			} else {
				$('#nxtdrawTime').html("--:--");
//				alert(response.status);
				$('#msg').html(response.status).fadeIn();
				setTimeout( function() {
					$("#msg").fadeOut();
				}, 4000 );
			}
		},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.readyState == 4) {
                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            	//$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');
            }
            else if (XMLHttpRequest.readyState == 0) {
                // Network error (i.e. connection refused, access denied due to CORS, etc.)
            	 $("#loading").addClass('overlay');
            	$("#msg").show().html('Please connect network and reload a page').removeClass('alert-success').addClass('alert-danger');

            
        } 
	});
	return false;}*/
}

function serverTime() {
		var time = null;
		$.ajax({url: '<?php echo base_url();?>/admin/draw/getdbtime',
			async: false, dataType: 'text',
			success: function(text) {
				// create Date object for current location India
				offset = '+5.5';
				d = new Date(text);
				// convert to msec
				// add local time zone offset 
				// get UTC time in msec
				utc = d.getTime() + (d.getTimezoneOffset() * 60000);
				// create new Date object for different city
				// using supplied offset
				time = new Date(utc + (3600000*offset)); 
				//console.log('timer=> '+time);
			}, error: function(http, message, exc) {
				time = new Date();
			}
		});
		return time;
	}
</script>

<style>
.text_blink {
    font-weight: bold;
    animation: changecolor 2s infinite;
    -moz-animation: changecolor 2s infinite;
    -webkit-animation: changecolor 2s infinite;
    -ms-animation: changecolor 2s infinite;
    -o-animation: changecolor 2s infinite;
}
@keyframes changecolor
{
0% {color: red;}
25% {color: yellow;}
50% {color: orange;}
75% {color: white;}
100% {color: green;}
}
/* Mozilla Browser */
@-moz-keyframes changecolor
{
0% {color: red;}
25% {color: yellow;}
50% {color: orange;}
75% {color: white;}
100% {color: green;}
}
/* WebKit browser Safari and Chrome */
@-webkit-keyframes changecolor
{
0% {color: red;}
25% {color: yellow;}
50% {color: orange;}
75% {color: white;}
100% {color: green;}
}
/* IE 9,10*/
@-ms-keyframes changecolor
{
0% {color: red;}
25% {color: yellow;}
50% {color: orange;}
75% {color: white;}
100% {color: green;}
}
/* Opera Browser*/
@-o-keyframes changecolor
{
0% {color: red;}
25% {color: yellow;}
50% {color: orange;}
75% {color: white;}
100% {color: green;}
}
.ttd {
    float: left;
	margin-top: 8px;
}
.timedraw_1 {
    background-color: #c8181e;
    float: left;
    color: #fff;
    border-radius: 5px;
    padding: 8px 5px 8px 10px;
    font-weight: bold;
    font-size: 16px;
}
.runtime_1 {
	float: left;
    margin-left: 10px;
    background-color: #000;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 20px;
    box-shadow: 0px 0px 8px #000 inset;
}
.next_draw_div {
    float: right;
    margin-right: 18px;
    background-color: #c8181e;
    color: #fff;
    border-radius: 5px;
    padding: 15px;
    font-weight: bold;
    font-size: 16px;
	width: 185px;
	text-align: center;
}
.curr_draw_div {
    float: right;
    margin-right: 18px;
    background-color: #c8181e;
    color: #fff;
    border-radius: 5px;
    padding: 15px;
    font-weight: bold;
    font-size: 16px;
	width: 209px;
	text-align: center;
}
.searchWrap1 {
    background-color: #F8F8F8;
    border: 1px solid #EEEEEE;
    border-radius: 5px;
    float: left;
    width: 100%;
	margin-top:10px;
	font-size:13px;
}
.submit_value {
    font-size: 14px !important;
}
.Text-win {
	width: 100px;
    height: 20px;
    font-size: 18px;
    margin: 0 10px;
    background-color: #FFFFFF;
    padding: 5px;
    /*text-align: right;*/
    border: 1px solid #E4E4E4;
    color: #000000;
    border-radius: 3px;
	text-align: center;
}
.error{
	color:red;
}
.data-list thead {
    background-color: #000000;
    color: #fff;
}
.data-list th{
    font-weight: bold;
    font-size: 16px;
	text-transform: uppercase;
    text-align: center;
	padding: 14px 0;
}
.data-list td{
    text-align: center;
}
.prev_draw {
    background-color: #6b6b6b;
    color: #fff;
}
.curr_draw {
     background-color: #c8181e;
    color: #fff;
    border: 2px solid #fff;
}
.curr_draw:hover {
    background-color: #c8181e !important;
}
.future_draw {
    opacity: 0.6;
    cursor: not-allowed;
    background-color: #868686;
}
.create_btn {
    background: linear-gradient(#ffd23c,#f6d053) !important;
    color: #000 !important;
    font-weight: bold;
    text-transform: uppercase;
}
.cancle_btn {
    background: linear-gradient(#ffd23c,#f6d053) !important;
    color: #000 !important;
    font-weight: bold;
    text-transform: uppercase;
	margin: 10px !important;
	font-size: 14px;
}
.data-list tr:hover {
    background-color: #8a8a8a;
}
.win_no {
	height: 50px !important;
    font-size: 22px !important;
    font-weight: bold !important;
	text-transform: uppercase;
}
.result_popup{
display: none;
position: fixed;
top: 33%;
width: 400px;
height: 128px;
padding: 48px;
margin: 0 auto;
border: 1px solid black;
background-color: #F8F8F8;
z-index: 101;
overflow: hidden;
left: 0;
right: 0;
}
.create_popup_head {
    font-size: 18px;
    text-align: center;
    margin-top: 22px;
}
.create_popup_submit {
    margin: 20px 0;
    text-align: center;
}
.close_popup{
	float: right;
	padding: 4px 10px;
	color: #000;
	cursor:pointer;
}
.ContentHdr{
	background-color: #c8181e;	
}

td.win_no {
    text-align: left;
    position: relative;
    left: 17%;
}
.nostream {
    position: absolute;
    height: 99%;
    width: 100%;
    z-index: 9;
    background-color: rgba(0, 0, 0, 0.91);
    color: #fff;
    font-size: 38px;
    left: 0;
    right: 0;
    display: none;
}
p.nostream-text {
    margin-top: 18vh;
    text-align: center;
}

.UpdateMsgWrap.ticket_message {
    box-shadow: 1px 1px 16px #4f4f4f;
    border-radius: 5px;
}
.UpdateMsgWrap.ticket_message td{
text-align: center;
    font-size: 18px;
	}
</style>

<?php
if (empty( $streaming_status ) ) { 
?>
<script type="text/javascript">
$(document).ready(function () {
	//$('#nostream').show();
});
</script>
<?php }

	$message  = '';
	$resValue = array();

	if( !empty( $drawList ) && !empty( $drawList ) ) {

		foreach( $drawList as $index => $list ) {
			$url= base_url().'admin/draw/createdraw_winnumber/'.base64_encode($list->DRAW_ID);
			$drawID = "'".'DRAW_WINNUMBER_'.$list->DRAW_ID."'";
			$drawID1 = 'DRAW_WINNUMBER_'.$list->DRAW_ID;
			$drawIdValue = "'".$list->DRAW_ID."'";
			$err_id ='error_msg_'.$drawID1;
			//$formValue='<form class="form" name="win_update_'.$drawID1.'" id="win_update_'.$drawID1.'" action="'.$url.'" method="post"><div><input type="text"  name="DRAW_WINNUMBER" value="" maxlength="3" id="'.$drawID1.'" class="Text-win" required="true"> <input type="button" class="create_btn" id="submit_value" value="Create" onclick="updateInfoData('.$drawID.')" /> <input type="button" class="cancle_btn" value="Cancel" onclick="canceldraw('.$drawIdValue.')" /></div><div><label for="'.$drawID1.'" generated="true" class="error" id="'.$err_id.'" style="display:none"></label></div></form>';
			$formValue='<form class="form" name="win_update_'.$drawID1.'" id="win_update_'.$drawID1.'" action="'.$url.'" method="post"><div><input type="text"  name="DRAW_WINNUMBER" value="" maxlength="3" id="'.$drawID1.'" class="Text-win" required="true"> <input type="button" class="create_btn submit_value" value="Submit" onclick="updateInfoData('.$drawID.')" /> </div><div><label for="'.$drawID1.'" generated="true" class="error" id="'.$err_id.'" style="display:none"></label></div></form>';
			$resValue[$index]['DRAW_ID']	= $list->DRAW_ID;
			$resValue[$index]['DRAW_DATETIME']	= date('d-m-Y h:i:s A',strtotime($list->DRAW_STARTTIME));
			$drawWinNo = (!empty($list->DRAW_RESULT_WINNUMBER)?$list->DRAW_RESULT_WINNUMBER:'');
			/* if($list->TC_DRAW_STATUS ==2){ //cancelled draw
				$resValue[$index]['TICKET_NUMBER']	= 'Cancelled';
			}elseif(!empty($drawWinNo) && $list->TC_DRAW_STATUS ==1 ){// win number available and approved
				$resValue[$index]['TICKET_NUMBER']	= $drawWinNo;
			}elseif(empty($drawWinNo) && $list->TC_DRAW_STATUS !=2){//submit win number 
				$resValue[$index]['TICKET_NUMBER']	= $formValue;
			}elseif(!empty($drawWinNo) && $list->TC_DRAW_STATUS ==0){//not approved
				$approveForm='<div>'.$drawWinNo.'<input type="button" class="create_btn submit_value" value="Submit" onclick="updateInfoData('.$drawID.')" /> </div>';
				$resValue[$index]['TICKET_NUMBER']	= $approveForm;
			}else{
				$resValue[$index]['TICKET_NUMBER']	= '';
			} */

			$resValue[$index]['DRAW_NAME']		= $list->DRAW_DESCRIPTION;
		}
	}
	// echo '<pre>'; print_r($resValue); exit;
?>

<div id="shadowing1"></div>
<div id="approve_popup" class="result_popup" style="display:none">
	<!--<form id="frmLightbox" method="post" action="" target="_parent">-->
	<div class="SeachResultWrap">
	<div class="Agent_create_wrap">
	<div class="Agent_hdrt" id="boxtitle1"><span class="close_popup" onClick="resultpopupclose()" >X</span></div>
	<div class="create_popup_head">
		<div id="approve_title">Are you sure you want to approve?</div>
		<div>Win No:<span id="app_no"> </span></div>
	</div>
	<form id="approveForm" method="post" action ="">
		<input type="hidden"  id="app_win_no" name="DRAW_WINNUMBER" value="" >
		<input type="hidden"  id="action" name="action" value="" >
	</form>
	<div class="create_popup_submit">
		<input type="button" class="button" value="Yes" onclick="resultapprove()"/>
		<input type="button" class="button" value="No" onClick="resultpopupclose()" />
	</div>
	</div>
	</div>
	<!--</form>-->
</div>

<div id="result_popup" class="result_popup" style="display:none">
	<!--<form id="frmLightbox" method="post" action="" target="_parent">-->
	<div class="SeachResultWrap">
	<div class="Agent_create_wrap">
	<div class="Agent_hdrt" id="boxtitle1"><span class="close_popup" onClick="resultpopupclose()" >X</span></div>
	<div class="create_popup_head">
		<div id="title_popup">Are you sure you want to submit?</div>
		<div>Win No:<span id="number"> </span></div>
	</div>
	<input type="hidden" name="formID" id="formID" value=""/>
	<div class="create_popup_submit">
		<input type="button" class="button" value="Yes" onclick="resultsubmit()"/>
		<input type="button" class="button" value="No" onClick="resultpopupclose()" />
	</div>
	</div>
	</div>
	<!--</form>-->
</div>

<div id="cancel_popup" class="result_popup" style="display:none">
	
	<!--<form id="frmLightbox" method="post" action="" target="_parent">-->
	<div class="SeachResultWrap">
	<div class="Agent_create_wrap">
	<div class="Agent_hdrt" id="boxtitle1"><span class="close_popup" onClick="resultpopupclose()" >X</span></div>
	<div class="create_popup_head">
		<div id="title_popup">Are you sure you want to cancel?</div>
	</div>
	<input type="hidden" name="cancelID" id="cancelID" value=""/>
	<div class="create_popup_submit">
		<input type="button" class="button" value="Yes" onclick="cancelsubmit()"/>
		<input type="button" class="button" value="No" onClick="resultpopupclose()" />
	</div>
	</div>
	</div>
	<!--</form>-->
</div>

	<input type="hidden" name="drawID" id="drawID" value="<?php echo (!empty($upcomingDraw[0]->DRAW_ID)?$upcomingDraw[0]->DRAW_ID:'');?>" />
	<input type="hidden" name="drawName" id="drawName" value="<?php echo (!empty($upcomingDraw[0]->DRAW_NUMBER)?$upcomingDraw[0]->DRAW_NUMBER:'');?>" />
	<input type="hidden" name="drawDateTime" id="drawDateTime" value="<?php echo (!empty($upcomingDraw[0]->DRAW_STARTTIME)?$upcomingDraw[0]->DRAW_STARTTIME:'');?>" />
<div class="MainArea">
  <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Result List</strong></td>
          </tr>
        </table>
		<?php if ($this->session->flashdata('result')!='') {
			$message = $this->session->flashdata('result');
		?>
			<script type="application/javascript">
				$(".UpdateMsgWrap").show();
				window.setTimeout(function() {
				//	$(".UpdateMsgWrap").hide();
				}, 4000);
			</script>
			<div class="UpdateMsgWrap ticket_message">
				<table width="100%" class="<?php echo $message['class'] ?>">
					<tbody>
						<tr>
							<td width="95%"><?php echo $message['message']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
            <table width="100%" cellpadding="10" cellspacing="10" class="searchWrap">
				<!--<tr>
					<td width="40%">
						<span class="TextFieldHdr">Ticket Number:</span><br />
						<label>
							<?php //$userName = ( $this->session->userdata['keywords']['TICKET_NUMBER'] != '' ) ? $this->session->userdata['keywords']['TICKET_NUMBER'] : ''; ?>
							<input type="text" name="TICKET_NUMBER" id="TICKET_NUMBER" class="TextField" value="<?PHP echo $userName; ?>" >
						</label>
					</td>
				</tr>-->
				<tr>
					<td width="40%"><div class="next_draw_div">NEXT DRAW:<span id="nxtdrawTime"><?= $nxtDrawTime; ?></span></div></td>
					<td width="20%"><div class="curr_draw_div">CURRENT DRAW:<span id="curdrawTime"><?= (!empty($resValue[0]['DRAW_DATETIME'])?date('h:i A',strtotime($resValue[0]['DRAW_DATETIME'])):'--:--'); ?></span></div></td>
					<td width="40%">
						<div class="timedraw_1">
						<div class="ttd">TIME TO DRAW</div>
						<div class="runtime_1" id="ndrawLeftTime"><span class="countdown-row countdown-amount text_blink"></span></div>
					</div>
					</td>
				</tr>
				    	</table>


		<div id="can_sub"></div>
        <div class="tableListWrap" style="position:relative;">
		<div class="nostream" id="nostream" style=""><p class="nostream-text" style="">We are encountering technical issue, we will come back soon! </p></div>
          <div class="data-list">
            <?php
           
            ?>
			<table>
			<thead>
			<tr>
			<th>Draw Date Time</th>
			<th>Draw Name</th>
			<th>Win Number</th>
			</tr>
			</thead>
			<tbody id="nxt_draw_list">
			<?php
			 if( !empty( $resValue ) ) {
				foreach($resValue as $res){
					if($i==0){
					?>
					<tr class="curr_draw" title="Current Draw" id="curr_draw">
						<td><?php echo $res['DRAW_DATETIME']; ?><input type="hidden" id="cur_id" value="<?php echo $res['DRAW_ID']; ?>"/></td>
						<td><?php echo $res['DRAW_NAME']; ?></td>
						<td class="win_no">---</td>
					</tr>
			 <?php $i++;} } }
					
			$preDrawTime = '';
			$preDrawNo = '';
			$draws ='';
			if (!empty($preDrawInfo )){
				$preDrawTime = date('h:i A',strtotime($preDrawInfo[0]->DRAW_STARTTIME));
				$preDrawNo = substr($preDrawInfo[0]->DRAW_NUMBER,strlen($preDrawInfo[0]->DRAW_NUMBER)-5,5);

				foreach ($preDrawInfo as $drawList){
					$url= base_url().'admin/draw/createdraw_winnumber/'.base64_encode($drawList->DRAW_ID);
					$drawID = "'".'DRAW_WINNUMBER_'.$drawList->DRAW_ID."'";
					$drawIdValue = "'".$drawList->DRAW_ID."'";
					$drawID1 = 'DRAW_WINNUMBER_'.$drawList->DRAW_ID;
					$err_id ='error_msg_'.$drawID1;
					//$formValue='<form class="form" name="win_update_'.$drawID1.'" id="win_update_'.$drawID1.'" action="'.$url.'" method="post"><div><input type="text"  name="DRAW_WINNUMBER" value="" maxlength="3" id="'.$drawID1.'" class="Text-win" required="true"> <input type="button" class="create_btn submit_value" value="Submit" onclick="updateInfoData('.$drawID.')" /><input type="button" class="cancle_btn"  value="Cancel" onclick="canceldraw('.$drawIdValue.')" /></div><div><label for="'.$drawID1.'" generated="true" class="error" id="'.$err_id.'" style="display:none"></label></div></form>';
					$formValue='<form class="form" name="win_update_'.$drawID1.'" id="win_update_'.$drawID1.'" action="'.$url.'" method="post"><div><input type="text"  name="DRAW_WINNUMBER" value="" maxlength="3" id="'.$drawID1.'" class="Text-win" required="true"> <input type="button" class="create_btn submit_value" value="Submit" onclick="updateInfoData('.$drawID.')" /><div><label for="'.$drawID1.'" generated="true" class="error" id="'.$err_id.'" style="display:none"></label></div></form>';
					/* $draw_win_no = 'Cancelled';
					if($drawList->TC_DRAW_STATUS ==1 || $drawList->TC_DRAW_STATUS ==''){
						$draw_win_no = (!empty($drawList->DRAW_RESULT_WINNUMBER)?$drawList->DRAW_RESULT_WINNUMBER:$formValue);
					} */
					
					$drawWinNo = (!empty($drawList->DRAW_RESULT_WINNUMBER)?$drawList->DRAW_RESULT_WINNUMBER:'');
					$pendingWinNo = (!empty($drawList->PENDING_WINNUMBER)?$drawList->PENDING_WINNUMBER:'');
					
					if($drawList->TC_DRAW_STATUS ==2  || $drawList->DRAW_STATUS ==6 || $drawList->DRAW_STATUS ==7){ //TC_DRAW_STATUS=2 is tc_lotto_draw_result table cancelled ,DRAW_STATUS=6 is cancelled and DRAW_STATUS=7 advance draw cancelled for tc_lotto_draw table
						$draw_win_no	= 'Cancelled';
					}elseif(!empty($drawWinNo) && $drawList->TC_DRAW_STATUS ==1 ){// win number available and approved
						$draw_win_no	= $drawWinNo;
					}elseif(empty($drawWinNo) && empty($pendingWinNo) && $drawList->TC_DRAW_STATUS !=2){//empty win number 
						$draw_win_no	= $formValue;
					}elseif(!empty($pendingWinNo) && empty($drawWinNo) && $drawList->TC_DRAW_STATUS ==0){//not approved
						$cancelForm='<input type="hidden" id="action_value" value="approve"/><input type="button" class="cancle_btn"  value="Cancel" onclick="canceldraw('.$drawIdValue.')" />';
						$approveForm='<div><input type="text"  id="UPDATE_WINNUMBER_'.$drawList->DRAW_ID.'" name="UPDATE_WINNUMBER_'.$drawList->DRAW_ID.'" value="'.$pendingWinNo.'" maxlength="3" class="Text-win" required="true" onblur="editInfo('.$drawList->DRAW_ID.')"> <input type="button" class="create_btn submit_value" id="submit_'.$drawList->DRAW_ID.'" value="Approve" onclick="approveInfo('.$drawIdValue.')" />'.$cancelForm.' </div><div><label for="UPDATE_WINNUMBER_'.$drawList->DRAW_ID.'" generated="true" class="error" id="error_msg_'.$drawList->DRAW_ID.'" style=""></label></div>';
						$draw_win_no	= $approveForm;
					}else{
						$draw_win_no	= '';
					}
					
					$draws.='<tr class="prev_draw" title="Previous Draw"><td>'. date('d-m-Y h:i A',strtotime($drawList->DRAW_STARTTIME)).'</td><td>'.$drawList->DRAW_DESCRIPTION.'</td><td class="win_no">'.$draw_win_no.'</td></tr>';
				}
				echo $draws;
			}
			
			 if( !empty( $resValue ) ) {
				$i=0;
				foreach($resValue as $res){
					if($i==0){
					?>
							
						<?php } else { ?>
						<tr class="future_draw" title="Future Draw">
						<td><?php echo $res['DRAW_DATETIME']; ?></td>
						<td><?php echo $res['DRAW_NAME']; ?></td>
						<td class="win_no">--</td>
					</tr>
				<?php } $i++;} ?>
				</tbody>
				</table>
			<?php }	?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script language="javascript">
function updateInfoData(id){
	var val = $.trim($('#'+id).val());
	$('#error_msg_'+id).html('').hide();
	var valid =1;

	if(val =='' ){
		$('#error_msg_'+id).html('Please enter win number').show();
		alert("Please enter win number");
		valid=0;
		return false;
	}

	if(val.length > 3 ){
		$('#error_msg_'+id).html('Please enter 3 digits only').show();
		valid=0;
		return false;
	}

	if(val.length < 3 ){
		$('#error_msg_'+id).html('Please enter 3 digits win number').show();
		valid=0;
		return false;
	}

	
	var curId =$('#cur_id').val();
	var winId = id.split('_');
	if( curId == winId[2]){
		alert("Current draw can't be given win number");
		valid=0;
		return false;
	}  
	
	if(valid==1){
		$('#result_popup').show();
		$('#shadowing1').show();
		$('#number').html(val);
		$('#formID').val(id)
		return true;
	}
	return false;
}

function resultpopupclose(){
	$('#number').html('');
	$('#result_popup').hide();
	$('#cancel_popup').hide();
	$('#approve_popup').hide();
	$('#shadowing1').hide();
}

function resultsubmit(){
	var id =$('#formID').val();
	var curId =$('#cur_id').val();
	var winId = id.split('_');
	if( curId== winId[2]){
		alert("Current draw can't be given win number");
		return false;
	} 
	
	$("#win_update_"+id).submit();
	$('#number').html('');
	$('#result_popup').hide();
}

function canceldraw(id){
	var curId =$('#cur_id').val();
	if( curId== id){
		alert("Current draw can't cancelled");
		return false;
	} 
	if( curId < id){
		alert("Future draw can't be cancelled");
		return false;
	} 
	$('#cancel_popup').show();
	$('#shadowing1').show();
	$('#cancelID').val(id)
}

function cancelsubmit(){
	var id =$('#cancelID').val();
	var curId =$('#cur_id').val();
	if( curId== id){
		alert("Current draw can't cancelled");
		return false;
	} 
	if( curId < id){
		alert("Future draw can't be cancelled");
		return false;
	} 
	
	var form= '<form id="cancelDrawForm" method="post" action ="<?php echo base_url(); ?>/admin/draw/canceldraw/'+btoa(id)+'"></form>';
	$('#can_sub').html(form);
	$('#cancelDrawForm').submit();
	$('#cancel_popup').hide();
}
function editInfo(id){
	$('#submit_'+id).val('Update');
	$('#action_value').val('update')
}

function approveInfo(id){
	var val = $.trim($('#UPDATE_WINNUMBER_'+id).val());
	$('#error_msg_'+id).html('').hide();
	var action = $('#action_value').val();
	if(action =='update'){
		$('#approve_title').html('Are you sure you want to update?');
	}
	if(action =='approve'){
		$('#approve_title').html('Are you sure you want to approve?');
	}
	var valid =1;

	if(val =='' ){
		$('#error_msg_'+id).html('Please enter win number').show();
		alert("Please enter win number");
		valid=0;
		return false;
	}

	if(val.length > 3 ){
		$('#error_msg_'+id).html('Please enter 3 digits only').show();
		valid=0;
		return false;
	}

	if(val.length < 3 ){
		$('#error_msg_'+id).html('Please enter 3 digits win number').show();
		valid=0;
		return false;
	}


	if(valid==1){
		$('#approve_popup').show();
		$('#shadowing1').show();
		$('#app_no').html(val);
		$('#app_win_no').val(val);
		$('#action').val(action);
		$('#approveForm').attr('action', '<?php echo base_url(); ?>admin/draw/createdraw_winnumber/'+btoa(id));
		return true;
	}
	return false;
	
	
}

function resultapprove(){
	$('#approveForm').submit();
	$('#approve_popup').hide();
}

</script>
<?php $this->load->view("common/footer"); ?>
