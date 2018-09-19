/* function submitData(){
	   $('.random_num').removeClass('active');
	   $('.random_number').val('');
		var flag =0;
		//var res = '';
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
			 $("#loading").addClass('overlay');
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
					$("#loading-img").hide();
					$("#buy").removeClass('disabled').prop('disabled', false);
					if(res.msg == "valid"){
						var inputResponse =jQuery.parseJSON(JSON.stringify(res.response));
						inputSent(JSON.stringify(inputResponse));
					}else if(res.msg=="expired") {
						location.reload();
					}else{
						if(res.msg=="error"){//Risk management error display 
							$('#rm_error1').html(res.single);
							$('#rm_error2').html(res.double);
							$('#rm_error3').html(res.triple);
							$('#rm_alert_popup').modal('show');
							$("#loading").removeClass('overlay');
							$("#loading-img").hide();
						}else{
							$("#buy").removeClass('disabled').prop('disabled', false);
							clearInputValue();
							$('#msg').html(res.msg).css({ 'display': "block" });
							setTimeout( function() {
								$("#loading").removeClass('overlay');
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

$(document).ready(function(){
	$("#clear").bind('click touchstart', function() {
		clearInputValue();
	});

	$('#resultchat').bind('click touchstart', function() {
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

function resetValidation() {
	$('#chkResult').val('');
	$('#game_no').html('');
	$('#win_no').html('');
};
/** HANDLES KEYBOARD EVENTS **/