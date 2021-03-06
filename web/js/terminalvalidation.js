/* function sendDataToFlash(){
	$('.random_num').removeClass('active');
	$('.random_number').val('');
	var flag =0;
	var res = '';
		$('#triple_default input, #single_default input, #two_default input').each(function() {
			var input =Number($(this).val());
			if(input !='' && input !=0){
				flag = 1;
			}
		})
		if(flag==0){
			$('#msg').html('Please select coupon').css({ 'display': "block" });
			setTimeout( function() {
				$("#msg").css({ 'display': "none" });
			}, 2000 );
			return false;
		}
		
	if(flag==1){
		//$('#ticketForm').submit();return false;
		//$("#loading").addClass('overlay');
		$("#loading-img").show();
		$('#msg').html('');
		$("#buy").addClass('disabled').prop('disabled', true);
		var pdata2 = $('#ticketForm').serialize();
		$.ajax({
			type: "POST",
			url: "ticketprocess.php",
			data: pdata2,
			dataType: "json",
			success: function(res) {
				if(res.msg == "valid"){
					var inputResponse =jQuery.parseJSON(JSON.stringify(res.response));
					inputSent(JSON.stringify(inputResponse));
				}else if(res.msg=="expired") {
					window.location.href = "index.php";
				}else if(res.msg=="STREAMING_DISABLED") {//streaming disabled.
				
					//streamingOFF();
					//clearInputValue();
				}else{
					if(res.msg=="error"){//Risk management error display 
						$('#rm_error1').html(res.single);
						$('#rm_error2').html(res.double);
						$('#rm_error3').html(res.triple);
						$('#rm_alert_popup').modal('show');
					//	$("#loading").removeClass('overlay');
						$("#loading-img").hide();
						
					}else{
						$("#buy").removeClass('disabled').prop('disabled', false);
						clearInputValue();
						$('#msg').html(res.msg).css({ 'display': "block" });
						setTimeout( function() {
						//	$("#loading").removeClass('overlay');
							$("#loading-img").hide();
							$("#msg").css({ 'display': "none" });
						}, 4000 );
					}
					
				}
					
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				if (XMLHttpRequest.readyState == 4) {
					// HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
					$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
					location.reload();
				}
				else if (XMLHttpRequest.readyState == 0) {
					// Network error (i.e. connection refused, access denied due to CORS, etc.)
					$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
					location.reload();
					
				}
				else {
					$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
					location.reload();
				}
			},
			complete: function() {
				//me2.data('requestRunning', false);
			}
		});
		return false;
	}
} */

	function updateTicketCANCELStatus() {
		$("#tp_btn1").hide();
		$("#loader1").show();
		$.ajax({
			type:"POST",
			url:"cancelReprintTicket.php",
			data: $("#tp_pwd1").serialize(),
			dataType: "json",
			success:function(status) {
				if(status.msg == "valid"){
					$("#frmCancelTicket").addClass("disabled");
					$("#frmReprintTicket").addClass("disabled");
					$('.disabled').prop('disabled', true);
					//$('#tp-msg1').html("Coupon cancelled successfully").css({ 'display': "block" });
					$("#tp-msg1").show().html("Coupon cancelled successfully").removeClass('alert-danger').addClass('alert-success');
					$('#userTranspassCancel').val('');
					$("#loader1").hide();
					$("#tp_btn1").show();
					$("#userBalance").html(status.balance);
					setTimeout(function() {
						$('#fp-dialog1').modal('hide');
						$("#tp-msg1").css({ 'display': "none" });
					}, 4000);
					
				}else{
					$('#userTranspassCancel').val('');
					$("#loader1").hide();
					$("#tp_btn1").show();
					$("#tp-msg1").show().html(status.msg).removeClass('alert-success').addClass('alert-danger');
					//$('#tp-msg1').html(status.msg).css({ 'display': "block" });
					setTimeout( function() {
						$("#tp-msg1").css({ 'display': "none" });
					}, 4000 );
					return false;

				} 
			}
		});
		return false;
	}
	

	function updateTicketREPRINTStatus() {
		$("#tp_btn").hide();
		$("#loader").show();
	//	var rprntTransPass=$('#userTranspass').val();
		$.ajax({
			type:"POST",
			url:"cancelReprintTicket.php",
			data: $("#tp_pwd").serialize(),
			dataType: "json",
			success:function(status) {
				if(status.msg == "valid"){
					$('#userTranspass').val('');
					$("#loader").hide();
					$("#tp_btn").show();
					setTimeout(function() {
						$('#fp-dialog').modal('hide');
					}, 4000);
					
					var url = SITE_URL+'print.php?action=reprint';
				            nw.Window.open(url, {show: false}, function (win) {
				                win.on('loaded', function () {
				                   win.print({
                                       "printer": "",
                                       "marginsType": 2,
                                       "mediaSize": '{"custom_display_name":"58mm x Receipt (33 Columns)","height_microns":3002900,"vendor_id":"124","width_microns":50800}'
                                       });
				                    win.close();
				                });
				            });
							
					/* var printActionToFlashRPrnt = {
					action:"print",
					reprint:true,
					ticketDetails:status.result
					};
					StageWebViewBridge.call('onPhpResponse',null,printActionToFlashRPrnt);  */
				
				}else{
					$('#userTranspass').val('');
					$("#loader").hide();
					$("#tp_btn").show();
					
					$('#tp-msg').html(status.msg).css({ 'display': "block" });
					setTimeout( function() {
						$("#tp-msg").css({ 'display': "none" });
					}, 4000 );
					return false;

				} 
			}
		});
		return false;
	}


		function updateTicketPAYStatus(ticketID) {
				$("#payButton").hide();
				$("#loader_claim").show();
				var claimRequest={"serviceType":"tcmazzaservice","action":"claimRequest","ticketId":ticketID,userId:userID};
				inputSent(JSON.stringify(claimRequest));				
				/*
				var xhttpPay = new XMLHttpRequest();
				xhttpPay.onreadystatechange = function() {
					if (xhttpPay.readyState == 4 && xhttpPay.status == 200) {
						var getResponseString=xhttpPay.responseText.split("##");
						$('#userBalance').html(getResponseString[1]);
						$('#pay_info').html(getResponseString[0]);
					}
				}
				xhttpPay.open("GET", "ticketpay_ajax.php?ticketID="+ticketID, true);
				xhttpPay.send();
				*/
		}
			
	function chkTicketResult(ticketNumber) {
		if(ticketNumber.length=="0") {
			return false;
		}

		$.ajax({
			type:"POST",
			url:"ticketresult_ajax.php?ticketNumber="+ticketNumber,
			dataType: "json",
			success:function(status) {
				if(status.msg == "success"){
					$('#game_no').html(status.gameNo);
					$('#drawStatus').html(status.drawStatus);
					$('#winNumber').html(status.winNo);
					$('#win_no').show().html(status.result);
					 
				}else{
					$('#game_no').html('');
					$('#winNumber').html('');
					$('#drawStatus').html('');
					$('#win_no').show().html('<p style="text-align: center;">'+status.msg+'</p>');
				} 
			}
		});
		return false;
	}

/*  This file contains the common validations */
$(document).ready(function () {
	
	$('#frmReprintTicket').click(function() {
		$('#userTranspass').val('');				
		$('#userTranspass').focus();	
		$('#fp-dialog').modal('show');
	});

	$('#frmCancelTicket').click(function() {
		$('#fp-dialog1').modal('show');
		$('#userTranspassCancel').val('');				
		$('#userTranspassCancel').focus();
		return false;
	});

});


/** HANDLES KEYBOARD EVENTS **/
$(document).ready(function(){
	$(document).keydown(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		//$("#keydownCode").val(keycode);
		//alert(keycode);
		if(keycode==32 || (keycode>=112 && keycode<=123)) {
			event.preventDefault();
		}		
		
		/* if(keycode==115) { //F4 bet DOUBLE
			betDoubleOverAll();
		} */

		if(keycode==116) { //F5 Clear
			clearInputValue(); 
		}
		if(keycode==117) { //F6 Print
			
			sendDataToFlash();
			
			return false;		
		}
		if(keycode==118) { //F7 Repeat
			repeatOverAll();
		}
		if(keycode==119) { //F8 Cancel
			if( !$('#frmCancelTicket').hasClass('disabled')){
				$('#fp-dialog1').modal('show');
				$('#userTranspassCancel').val('');				
				$('#userTranspassCancel').focus();
				return false;			
			}
			return false;
		}
		if(keycode==120) { //F9 Reprint
			if( !$('#frmCancelTicket').hasClass('disabled')){
				$('#fp-dialog').modal('show');
				$('#userTranspass').val('');				
				$('#userTranspass').focus();
				

				return false;
			}
			return false;
		}
		if(keycode==121) { //F10 Claim
			resetValidation();
			$('#small-dialog').modal('show');
		}
		
		if(keycode==123) { //F12 Result
			$("#loading-img").show();
			$.ajax({
				type: "GET",
				url: "previousResult.php",
				success: function(status) {
					$("#loading-img").hide();
					$('#modal_body').html(status);
					$('#small-dialog3').modal('show');
				}
			});
		}
		
		
	});	
	
	
	$("#frmClear").bind('click touchstart', function() {
		clearInputValue();
	});
	
	/*$("#frmFutureDraw").bind('click touchstart', function() {
		getListFutureDraws();
		$('#getResults').css('display','none');	
	});*/
	
	$("#frmResult").bind('click touchstart', function() {
		resetValidation();
		$('#small-dialog').modal('show');
	});

	$('#frmWinResults').bind('click touchstart', function() {
		$("#loading-img").show();
		$.ajax({
			type: "GET",
			url: "previousResult.php",
			success: function(status) {
				$("#loading-img").hide();
				$('#modal_body').html(status);
				$('#small-dialog3').modal('show');
			}
		});
	});
	
	
	
	$("form").attr('autocomplete', 'off'); // Switching form autocomplete attribute to on
	/* allow only number */ 	
	
	
});


/*using clear button*/
/*
function clearInputValue(){
 $('.form :input').removeClass('random_sel_blink');
	$('#single_default input').each(function() {
       $(this).val('');
    })
    $('#triple_default input').each(function() {
        $(this).val('');
    })

	$('#two_default input').each(function() {
		$(this).val('');
	})
	$('#overall_total').html('');
    	clearQty1();
    	clearAmt1();
   // } 
	
}

function clearQty1(){
	
	 //total div set empty 
   $('#single_qty').html(0);
	$('#single_amt').html(0);
	$('#single_total').html(0);
	
	$('#two_qty').html(0);
	$('#two_amt').html(0);
	
	$('#tkt_qty').val('');
	$('#tkt_qty1').val('');
	$('#tkt_qty2').val('');
	
	$('#random_number2').val('');
	$('#random_number1').val('');
	$('#random_number').val('');
	
	$('#double_qty').html(0);
	$('#double_total').html(0);
	

}

function clearAmt1(){
	$('.double_qty_div').html(0);
	$('.double_amt_div').html(0);
	$('#two_overall_qty').html(0);
	$('#two_overall_total').html(0);
	$('#single_overall_qty').html(0);
	$('#single_overall_total').html(0);

}
 */
function resetValidation() {
	$('#chkResult').val('');
	$('#game_no').html('');
	$('#drawStatus').html('');
	$('#winNumber').html('');
	$('#win_no').html('');
};
/**HANDLES KEYBOARD EVENTS -**/