var wsUri = WEB_SOCKET_URL;
var output;

//function init() {
	connectWebSocket();
//}

function connectWebSocket() {
	websocket = new WebSocket(wsUri);
	websocket.onopen = function (evt) { onOpen(evt) };
	websocket.onclose = function (evt) { onClose(evt) };
	websocket.onmessage = function (evt) { onMessage(evt) };
	websocket.onerror = function (evt) { onError(evt) };
}

function onOpen(evt) {
	writeToScreen("CONNECTED");
	console.log("CONNECTED");
	getDrawUpdatedInfo();
}

function onClose(evt) {
	writeToScreen("DISCONNECTED");
	networkConnection();
	console.log("DISCONNECTED");
}
var servetDateTime = '';
function onMessage(evt) {
	var json = JSON.parse(evt.data);
	//	console.log(json);
	/*if(json.action=="drawresult"){
		$('#preDrawTime').html(json.drawTime);
		$('.preDrawTime').html(json.drawTime);
		$('.preDrawNo').html(json.drawNumber);
		updateUserBalance();
	}*/

	if (json.action == "drawresult") {
			console.log(json);
		/*	var jsonTime = json.drawTime;
			var time = jsonTime.split(':');
			var drawTime = jsonTime + ' AM';
			if (time[0] >= 12) {
				if (time[0] > 12) {
					time1 = (time[0] % 12);
					drawTime = time1 + ':' + time[1] + ' PM';
				} else {
					drawTime = jsonTime + ' PM';
				}
				$('.preDrawTime').html(drawTime);
			}*/
			var win_number = json.winNumber;
			//$('#preDrawTime').html(json.drawTime);
			//$('.preDrawTime').html(json.drawTime);
			//$('.preDrawNo').html(json.drawNumber);
			if(win_number!=''){
				var res = win_number.toString(10).split('');
				$('#result_1').html('<img class="img-responsive" src="images/'+res[0]+'.png" />');
				$('#result_2').html('<img class="img-responsive" src="images/'+res[1]+'.png" />');
				$('#result_3').html('<img class="img-responsive" src="images/'+res[2]+'.png" />');
			}
		startInterval();
	}

	if (json.action == "cancelresult") {
		updateUserBalance();
	}
	
	if (json.action == "claimResponse") {
		//console.log("claimResponse:"+json.balance);
		$('#userBalance').html(json.balance);
		var paidTxt = "-";
		if (json.paid == 1)
			paidTxt = "PAID";
		else
			paidTxt = "FAILED";

		$('#pay_info').html(paidTxt);
	}
	if (json.action == "BetResponse") {
		$('#suc_val1,#suc_val2,#suc_val3').html('');
		$('#serr1,#serr2,#serr3').html('');

		$('#rm_error1,#err_val1,#err1').html('');
		$('#rm_error2,#err_val2,#err2').html('');
		$('#rm_error3,#err_val3,#err3').html('');
		$('#rm_error1,#rm_error2,#rm_error3').css("color", '');
		var errTitle = 'Desired quantity for the selected coupon(s) is not available.Please check below available quantity';
		//Stock availability for remaining selected coupon(s)						
		var successTitle = 'Coupon(s) bought successfully';
		if (json.msg == 'valid') {
			console.log('json valid => ' + JSON.stringify(json));
			$('#userBalance').html(json.balance);
			var err1 = 0;
			if (json.resultError) {
				$.each(json.resultError, function (key, value) {
					if (key == 1) {
						if (value.error == 0) {
							$("#rm_error1").css("color", 'green').html('Coupon(s) bought successfully');
						}
						if (value.error == 1) {
							var val = '';
							if (value.blockRemainTickets != undefined && value.blockRemainTickets != '') {
								var remainTkt = JSON.stringify(value.blockRemainTickets);
								var data = remainTkt.replace(/[\])}[{(]/g, '');
								val = '<p>' + data.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
							}
							var sval = '';
							if (value.purchasedTicket != undefined && value.purchasedTicket != '') {
								var purchasedTkt = JSON.stringify(value.purchasedTicket);
								var tkt = purchasedTkt.replace(/[\])}[{(]/g, '');
								if (tkt != '') {
									sval = '<p>' + tkt.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
								}
							}

							if (value.availabeTicket == 0) {
								$('#rm_error1').css("color", '#f00').html('No coupon is available');
							} else {
								var msgtext = 'coupon is left';
								if (value.availabeTicket > 1) {
									msgtext = 'coupons are left';
								}
								//$('#rm_error1').css("color",'#f00').html('Only '+value.availabeTicket+' '+msgtext);

								if (val != '') {
									$('#err1').html(errTitle);
								}

								if (sval != '') {
									$('#serr1').html(successTitle);
								}
								$('#err_val1').html(val);
								$('#suc_val1').html(sval);
							}
							err1 = 1;
						}
					}
					if (key == 2) {
						if (value.error == 0) {
							//$("#rm_error2").css("color",'##f00');
							$('#rm_error2').css("color", 'green').html('Coupon(s) bought successfully');
						}
						if (value.error == 1) {
							var val1 = '';
							if (value.blockRemainTickets != undefined && value.blockRemainTickets != '') {
								var remainTkt1 = JSON.stringify(value.blockRemainTickets);
								var data1 = remainTkt1.replace(/[\])}[{(]/g, '');
								val1 = '<p>' + data1.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
							}

							var sval1 = '';
							if (value.purchasedTicket != undefined && value.purchasedTicket != '') {
								var purchasedTkt = JSON.stringify(value.purchasedTicket);
								var tkt1 = purchasedTkt.replace(/[\])}[{(]/g, '');
								if (tkt1 != '') {
									sval1 = '<p>' + tkt1.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
								}
							}

							if (value.availabeTicket == 0) {
								$('#rm_error2').css("color", '#f00').html('No coupon is available');
							} else {
								var msgtext = 'coupon is left';
								if (value.availabeTicket > 1) {
									msgtext = 'coupons are left';
								}
								//$('#rm_error2').css("color",'#f00').html('Only '+value.availabeTicket+' '+msgtext);
								if (val1 != '') {
									$('#err2').html(errTitle);
								}
								if (sval1 != '') {
									$('#serr2').html(successTitle);
								}
								$('#err_val2').html(val1);
								$('#suc_val2').html(sval1);
							}
							err1 = 1;
						}
					}
					if (key == 3) {
						if (value.error == 0) {
							$('#rm_error3').css("color", 'green').html('Coupon(s) bought successfully');
						}
						if (value.error == 1) {
							var val2 = '';
							if (value.blockRemainTickets != undefined && value.blockRemainTickets != '') {
								var remainTkt2 = JSON.stringify(value.blockRemainTickets);
								var data2 = remainTkt2.replace(/[\])}[{(]/g, '');
								val2 = '<p>' + data2.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
							}
							var sval2 = '';
							if (value.purchasedTicket != undefined && value.purchasedTicket != '') {
								var purchasedTkt = JSON.stringify(value.purchasedTicket);
								var tkt2 = purchasedTkt.replace(/[\])}[{(]/g, '');
								if (tkt2 != '') {
									sval2 = '<p>' + tkt2.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
								}
							}

							if (value.availabeTicket == 0) {
								$('#rm_error3').css("color", '#f00').html('No coupon is available');
							} else {
								var msgtext = 'coupon is left';
								if (value.availabeTicket > 1) {
									msgtext = 'coupons are left';
								}
								//$('#rm_error3').css("color",'#f00').html('Only '+value.availabeTicket+' '+msgtext);
								if (val2 != '') {
									$('#err3').html(errTitle);
								}
								if (sval2 != '') {
									$('#serr3').html(successTitle);
								}
								$('#err_val3').html(val2);
								$('#suc_val3').html(sval2);
							}
							err1 = 1;
						}
					}
				});

				if (TERMINAL == 1) {
					if (nw != undefined) {
						var url = SITE_URL + '/print.php?pid=' + json.pGroupID + '&action=print';
						nw.Window.open(url, { show: false }, function (win) {
							win.on('loaded', function () {
								win.print({
									"printer": "",
									"marginsType": 2,
									"mediaSize": '{"custom_display_name":"58mm x Receipt (33 Columns)","height_microns":3002900,"vendor_id":"124","width_microns":50800}'
								});
								win.close();
							});
						});
					}
				}

				if (err1 == 1) {
					if (json.result["1"] != undefined) {
						$('#single_result').css('display', 'block');
					} else {
						$('#single_result').css('display', 'none');
					}
					if (json.result["2"] != undefined) {
						$('#double_result').css('display', 'block');
					} else {
						$('#double_result').css('display', 'none');
					}
					if (json.result["3"] != undefined) {
						$('#triple_result').css('display', 'block');
					} else {
						$('#triple_result').css('display', 'none');
					}
					$('#rm_alert_popup').modal('show');
					$("#loading-img").hide();
					$("#loading").removeClass('overlay');
					setTimeout(function () {
						$('#rm_alert_popup').modal('hide');
					}, 20000);
				} else {
					$('#success-msg').html('Coupon(s) bought successfully').fadeIn();
					setTimeout(function () {
						$("#loading").removeClass('overlay');
						$("#loading-img").hide();
						$('#success-msg').fadeOut();
					}, 3000);
				}
			}
			clearInputValue();
			$("#repeat").removeClass('disabled').prop('disabled', false);
			//console.log("socket js =>"+json.result);
			//$('#lastTicket').val(JSON.stringify(json.result));
			lastTicket = JSON.stringify(json.result);
		} else if (json.msg == 'fail') {
			console.log('json fail => ' + JSON.stringify(json));
			// 101 - No ticket Avaliable
			// 102 - Insufficient fund
			// 103 - some Techincal issue. Try Again
			// 104 -  no Internal Ref Number
			// 105	-no bet type available
			// 106 - session not found
			// 107 -  draw id already completed
			var msg = '';
			if (json.errorCode) {
				$('#userBalance').html(json.balance);

				var error = json.errorCode;
				if (error == 101) {
					msg = 'No coupon availble';
				} else if (error == 102) {
					msg = 'You have insufficient balance';
				} else if (error == 103) {
					msg = 'Some techincal issue, Please try again';
				} else if (error == 104) {
					msg = 'Some techincal issue, Please try again';//no Internal Ref Number
				} else if (error == 105) {
					msg = 'Invalid coupon';//no bet type available
				} else if (error == 106) {
					$('#msg').html('Session expired').fadeIn();
					setTimeout(function () {
						//$("#loading").removeClass('overlay');
						//$("#loading-img").hide();
						$('#msg').fadeOut();
						location.reload();
					}, 3000);
					//return false;
				} else if (error == 107) {
					msg = 'The game is finished already';
				}

				$('#msg').html(msg).fadeIn();
				setTimeout(function () {
					$("#loading").removeClass('overlay');
					$("#loading-img").hide();
					$('#msg').fadeOut();
				}, 3000);
			}
			$("#loading").removeClass('overlay');
			$("#loading-img").hide();
			//return false;
		} else {
			console.log('json invalid else=> ' + JSON.stringify(json));
			$('#userBalance').html(json.balance);
			var err1 = 0;
			if (json.resultError) {
				$.each(json.resultError, function (key, value) {
					if (key == 1) {
						var val = '';
						if (value.error == 1) {
							if (value.blockRemainTickets != undefined && value.blockRemainTickets != '') {
								var remainTkt = JSON.stringify(value.blockRemainTickets);
								var data = remainTkt.replace(/[\])}[{(]/g, '');
								val = '<p>' + data.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
							}
							if (value.availabeTicket == 0) {
								$('#rm_error1').css("color", '#f00').html('No coupon is available');
							} else {
								// var msgtext = 'coupon is left';
								// if (value.availabeTicket > 1) {
								// 	msgtext = 'coupons are left';
								// }
								//$('#rm_error1').css("color",'#f00').html('Only '+value.availabeTicket+' '+msgtext);

								if (val != '') {
									$('#err1').html(errTitle);
								}
								$('#err_val1').html(val);
							}
							err1 = 1;
						}
					}
					if (key == 2) {

						if (value.error == 1) {
							var val1 = '';
							if (value.blockRemainTickets != undefined && value.blockRemainTickets != '') {
								var remainTkt1 = JSON.stringify(value.blockRemainTickets);
								var data1 = remainTkt1.replace(/[\])}[{(]/g, '');
								val1 = '<p>' + data1.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
							}


							if (value.availabeTicket == 0) {
								$('#rm_error2').css("color", '#f00').html('No coupon is available');
							} else {
								// var msgtext = 'coupon is left';
								// if (value.availabeTicket > 1) {
								// 	msgtext = 'coupons are left';
								// }
								//$('#rm_error2').css("color",'#f00').html('Only '+value.availabeTicket+' '+msgtext);

								if (val1 != '') {
									$('#err2').html(errTitle);
								}
								$('#err_val2').html(val1);
							}

							err1 = 1;
						}
					}
					if (key == 3) {

						if (value.error == 1) {
							var val2 = '';
							if (value.blockRemainTickets != undefined && value.blockRemainTickets != '') {
								var remainTkt2 = JSON.stringify(value.blockRemainTickets);
								var data2 = remainTkt2.replace(/[\])}[{(]/g, '');
								val2 = '<p>' + data2.replace(/\"/g, "").replace(/\:/g, "-").replace(/\,/g, "</p><p>") + '</p>';
							}
							if (value.availabeTicket == 0) {
								$('#rm_error3').css("color", '#f00').html('No coupon is available');
							} else {
								// var msgtext = 'coupon is left';
								// if (value.availabeTicket > 1) {
								// 	msgtext = 'coupons are left';
								// }
								//$('#rm_error3').css("color",'#f00').html('Only '+value.availabeTicket+' '+msgtext);
								if (val2 != '') {
									$('#err3').html(errTitle);
								}
								$('#err_val3').html(val2);
							}
							err1 = 1;
						}
					}
				});

				if (json.result["1"] != undefined) {
					$('#single_result').css('display', 'block');
				} else {
					$('#single_result').css('display', 'none');
				}
				if (json.result["2"] != undefined) {
					$('#double_result').css('display', 'block');
				} else {
					$('#double_result').css('display', 'none');
				}
				if (json.result["3"] != undefined) {
					$('#triple_result').css('display', 'block');
				} else {
					$('#triple_result').css('display', 'none');
				}
				$('#rm_alert_popup').modal('show');
				$("#loading-img").hide();
				$("#loading").removeClass('overlay');
				setTimeout(function () {
					$('#rm_alert_popup').modal('hide');
				}, 20000);
			}
		}
	}

	//	{"drawTime":{"minute":54,"second":19,"month":5,"year":2018,"hour":6,"date":9},"serverTime":"May 09,2018 18:54:19 +0530","action":"DateTimeAction"}
	if (json.action == 'DateTimeAction') {
		console.log('DateTimeAction => '+JSON.stringify(json));
		servetDateTime = json.serverTime;

		var shortly1 = new Date();
		//'Y,m,d,h,m,s'
		var year = json.drawTime.year;
		var month = json.drawTime.month - 1;
		var date = json.drawTime.date;
		var hour = json.drawTime.hour;
		var min = json.drawTime.minute;
		var sec = json.drawTime.second;
		shortly1 = new Date(year, month, date, hour, min, sec);
		$('#ndrawLeftTime').countdown('option', { until: shortly1, serverSync: setDateTime, timezone: +5.5, format: 'HMS', padZeroes: true, compact: true });
		serverdate = new Date(servetDateTime);
		//console.log("serverdate=>"+serverdate);
	}
	if (json.action == 'LogoutResponse') {
		console.log('Logout=>', json);
		if (json.errorCode == 100) {
			window.location.href = "logout.php";
		}else{
			$("#msg").show().html(json.msg).removeClass('alert-success').addClass('alert-danger');
		}
	}

	if (json.action == 'drawUpdate') {
		console.log('drawUpdate => ' + JSON.stringify(json));
		$('#drawID').val(json.DRAW_ID);
		$('#drawName').val(json.DRAW_NUMBER);
		$('#drawPrice').val(json.DRAW_PRICE);
		$('#drawDateTime').val(json.DRAW_STARTTIME);
		$('#curdrawTime').html(json.CURR_DRAW_TIME);
		servetDateTime = json.serverTime;

		var shortly1 = new Date();
		//'Y,m,d,h,m,s'
		var year = json.drawTime.year;
		var month = json.drawTime.month - 1;
		var date = json.drawTime.date;
		var hour = json.drawTime.hour;
		var min = json.drawTime.minute;
		var sec = json.drawTime.second;
		shortly1 = new Date(year, month, date, hour, min, sec);
		$('#ndrawLeftTime').countdown('option', { until: shortly1, serverSync: setDateTime, timezone: +5.5, format: 'HMS', padZeroes: true, compact: true });
		serverdate = new Date(servetDateTime);
		updateUserBalance();
		//console.log("serverdate=>"+serverdate);
	}

	if (json.action == "AckResponse") {
		//console.log(json.action);
	}
}

function setDateTime() {
	//time = new Date(text);
	// create Date object for current location India
	offset = '+5.5';
	d = new Date(servetDateTime);
	// convert to msec
	// add local time zone offset 
	// get UTC time in msec
	utc = d.getTime() + (d.getTimezoneOffset() * 60000);
	// create new Date object for different city
	// using supplied offset
	servetDateTime = new Date(utc + (3600000 * offset));
	// console.log('servertime =>'+servetDateTime);
	return servetDateTime;
}

function onError(evt) {
	console.log(evt);
}

function doSend(message) {
	websocket.send(message);
	console.log("SENT: " + message);
}

function inputSent(message) {
	websocket.send(message);
	console.log("BUY SENT: " + message);
}

//var count=30;
function writeToScreen(message) {
	if (message == "DISCONNECTED") {
		setTimeout(function () { init(); networkConnection(); }, 1000);
	}
	if (message == "CONNECTED") {
		//alert("CONNECTED");
	}
}


// var drawStart = $('#drawName').val();
// if (drawStart != undefined && drawStart != "") {
// 	window.addEventListener("load", init, false);
// 	setInterval(function () {
// 		activeWS()
// 	}, 3000);
// }

//window.addEventListener("load", init, false);
setInterval(function () {
	activeWS()
}, 3000);

function activeWS() {
	var msg = {action: "AckRequest",serviceType: "tcmazzaservice",userId:userID};
	doSend(JSON.stringify(msg));

}

var count = 10;

function startCounting() {
	setInterval("countDown()", 1000);
}

function countDown() {
	count = count - 1;
	if (count <= 0) {
		window.location.href = "index.php";
		return;
	}
	$("#timer").html(count);
}

var connection = true;
function networkConnection() {
	if (connection == true) {
		connection = false
		$('#confirmation').modal('show');
		startCounting();
	}
}
function getDrawUpdatedInfo() {
	var msg = { action: "drawUpdateRequest", serviceType: "tcmazzaservice", userId: userID };
	doSend(JSON.stringify(msg));
}
function updateUserBalance() {
	//var drawID = $('#future').val();
	//	 var siteUrl = $('#siteUrl').val();
	$.ajax({
		type: "GET",
		//url : "userbalance_update.php?id="+drawID,
		url: "userbalance_update.php",
		dataType: "json",
		success: function (res) {
			if (res.SESSION == 0) {
				location.reload();
				//window.location.href = "index.php";
			} else {
				$('#userBalance').html(res.USER_BAL);
				$('#nxtdrawTime').html(res.nxtDrawTime);
				$('#result_top').html(res.RESULT);
				$('#curdrawTime').html(res.CURR_DRAW_TIME);
				$('#last_result_info').html(res.LAST_RESULT);
			}
		},
		error: function (xhr, textStatus, errorThrown) {
			if (xhr.readyState == 4) {
				if (xhr.status >= 200 && xhr.status < 304) {
					//  	alert("connection exists!");
				}
				else {
					$("#loading").addClass('overlay');
					$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
					location.reload();
				}
			} else if (xhr.readyState == 0) {
				// Network error (i.e. connection refused, access denied due to CORS, etc.)
				$("#loading").addClass('overlay');
				$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
				location.reload();
			}
		}
	});

}

function logout(user_id, session_id) {
	var logout = '{"action": "LogoutRequest","serviceType": "tcmazzaservice","userId":"' + user_id + '","sessionId":"' + session_id + '"}';
	doSend(logout)
}


var countTime =3;
var frameTime =6;
var  interval;
var  interval1;
function startTimeCounting( ) {
	$('#timer1').hide();
	$('#timer2').show();
	updateUserBalance();
	interval=	setInterval("stopCountDown()", 1000);
}

function stopCountDown( ) {
	countTime=countTime-1;
	if (countTime == 0) {
		$('#result_timer').hide();
		$('#timer1').hide();
		$('#timer2').hide();
		countTime =3;
		clearInterval(interval);
		return;
	}
}

function startInterval(){
	$('#timer_frame').attr('src','images/Frame_5.png');
	$('#result_timer').show();
	$('#timer1').show();
	$('#timer2').hide();
	//interval1=	setInterval("frame_change()", 1000);
	 setTimeout(function(){ 
	 	startTimeCounting(); 
	 }, 2000);
}

