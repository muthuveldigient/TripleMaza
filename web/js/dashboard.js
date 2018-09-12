var drawPrice = $('#drawPrice').val();
$(document).ready(function() {
    $('input[name=qty]').change(function() {
        $qty_val = $(this).val()
        $('.random_sel_blink').each(function(index) {
            $(this).val($qty_val)
        });
    });
    /*  inspect and right click not working */
   document.addEventListener('contextmenu', event => event.preventDefault());
    $(document).keydown(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        //$("#keydownCode").val(keycode);
        //alert(keycode);
        if (keycode == 32 || (keycode >= 112 && keycode <= 123)) {
            event.preventDefault();
        }

        if (keycode == 123) { //F12 Result
            return false;
        }
    }); 
    // Get the element with id="defaultOpen" and click on it
    //document.getElementById("defaultOpen").click();
    /*If no games then here disabld input fields*/

    var drawID = $('#drawID').val();
    if (drawID == '') {
        $('#lock').addClass('game_start');
        $("#disable_inputs :input, #buy,#frmCancelTicket,#frmReprintTicket,#frmResult,#frmWinResults,#repeat,#bet_double,#frmClear,#clear ").prop("disabled", true);
    }
	//$("#bet_double").addClass('disabled').prop('disabled', true); //bet double disabled
	$("#double_up,#frmClear,#clear,#buy").addClass('disabled').prop('disabled', true);//clear, double, buy button disabled
	//$("#clear_single").addClass('disabled').prop('disabled', true);//single clear and double disabled
	//$("#clear_double").addClass('disabled').prop('disabled', true);//double clear and double disabled
	//$("#clear_triple").addClass('disabled').prop('disabled', true);//triple clear and double disabled
	
    $('.form :input').keypress(function(e) { //digits only allowed
        if (e.which != 8 && e.which != 0 && ((e.which < 48) || (e.which > 57))) {
            return false;
        }
    });
	
	$('#clear_single').click(function() {
		clearSingleRow();
	});
	$('#clear_double').click(function() {
		clearDoubleRow();
	});
	$('#clear_triple').click(function() {
		clearTripleRow();
	});
	
	/* $('#bet_double').click(function() {
		betDoubleOverAll();
	}); */
		
	$('#double_up').click(function() {
        doubleup_single();
        doubleup_double();
        doubleup_triple();
    });
    //single
    function doubleup_single(){
        $("#single_default :input").each(function() {
            var value = Number($(this).val());
				
            if (value > 0) {
                var inputVal = value*2;
				if(inputVal > SINGLE_BET_QTY_LIMIT){
					$('#msg').html("Maximum of only "+SINGLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
                }else{
					$(this).val(inputVal);
				}
            }
        })
		singleCalculation();
    }
	//double
	function doubleup_double(){
		$("#two_default :input").each(function() {
            var value = Number($(this).val());
				
            if (value > 0) {
                var inputVal = value*2;
				if(inputVal > DOUBLE_BET_QTY_LIMIT){
					$('#msg').html("Maximum of only "+DOUBLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
                }else{
					$(this).val(inputVal);
				}
            }
        })
		doubleCalculation();
	}
	
	//triple
	function doubleup_triple(){
		$("#triple_default :input").each(function() {
            var value = Number($(this).val());
				
            if (value > 0) {
                var inputVal = value*2;
				if(inputVal > TRIPLE_BET_QTY_LIMIT){
					$('#msg').html("Maximum of only "+TRIPLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
                }else{
					$(this).val(inputVal);
				}
            }
        })
		tripleBetCalculation();
	}
	
	//var res = $('#lastTicket').val();
	var res = lastTicket;
	if(res==''){
		$("#repeat").addClass('disabled').prop('disabled', true);
	}
	
	$('#repeat').click(function() { 
		repeatOverAll();
    });
	
    $('#single_default :input').bind("keyup", function() {
       // var id = $(this).attr("id");
		singleCalculation();
    });
	
    $('#two_default :input').bind("keyup", function() {
       // var id = $(this).attr("id");
        doubleCalculation();
    });

    $('#triple_default :input').bind("keyup", function() {
       // var id = $(this).attr("id");
        var cls = $(this).attr("class");
		if ($(this).hasClass("random_sel_blink")) {
            var val = cls.split(" ");
            cls = val[0];
        }
		tripleCalculation(cls)
    });
	
	$('#tkt_qty1').bind("keyup", function() {//single
		var value = Number($(this).val());
        if (value > 0) {
			if(value > SINGLE_BET_QTY_LIMIT){
				$('#msg').html("Maximum of only "+SINGLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
				$(this).val('');
				setTimeout( function() {
					$('#msg').fadeOut();
				}, 3000 );
				return false;
			}
		}
    });
	
    $('#tkt_qty2').bind("keyup", function() {//double
       var value1 = Number($(this).val());
        if (value1 > 0) {
			if(value1 > DOUBLE_BET_QTY_LIMIT){
				$('#msg').html("Maximum of only "+DOUBLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
				$(this).val('');
				setTimeout( function() {
					$('#msg').fadeOut();
				}, 3000 );
				
				return false;
			}
		}
    });

    $('#tkt_qty').bind("keyup", function() {//triple
       var value2 = Number($(this).val());
        if (value2 > 0) {
			if(value2 > TRIPLE_BET_QTY_LIMIT){
				$('#msg').html("Maximum of only "+TRIPLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
				$(this).val('');
				setTimeout( function() {
					$('#msg').fadeOut();
				}, 3000 );
				return false;
			}
		}
    });
	
	

});

	function betDoubleOverAll(){
		/* $("#triple_default :input,#two_default :input, #single_default :input").each(function() {
            var value = Number($(this).val());
				
            if (value > 0) {
                var inputVal = value*2;
				if(inputVal > 999){
					$('#msg').html("Maximum of only 999 per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
                }else{
					$(this).val(inputVal);
				}
            }
        })
		singleCalculation();
		doubleCalculation();
		tripleBetCalculation();	 */
	}
	function singleCalculation(){
		 var sum = 0;
		 //Sum up
        $(".single_input").each(function() {
            var value = Number($(this).val());
            if (value == 0) {
                $(this).val('');
                //return false;
            }
			if (value > 0) {
				if(value > SINGLE_BET_QTY_LIMIT){
					$(this).val('');
					$('#msg').html("Maximum of only "+SINGLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
				}
			}
            sum += Number($(this).val());
        })
		
        var val = sum * drawPrice;
        $("#single_qty").html(sum);
        $("#single_amt").html(val);
       // $('#single_overall_qty').html(sum);
      //  $('#single_overall_total').html(val);
        totalSingle();
	}
	function doubleCalculation(){
		var sum = 0;

        //Sum up
        $(".two-chance").each(function() {
            var value = Number($(this).val());
            if (value == 0) {
                $(this).val('');
                //return false;
            }
			if (value > 0) {
				if(value > DOUBLE_BET_QTY_LIMIT){
					$(this).val('');
					$('#msg').html("Maximum of only "+DOUBLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
				}
			}
            sum += Number($(this).val());
        })

        var val = sum * drawPrice;
        $("#two_qty").html(sum);
        $("#two_amt").html(val);
        $("#two_overall_qty").html(sum);
        $("#two_overall_total").html(val);
        totalTwo();
	}
	function tripleCalculation(cls){
        var sum = 0;
        //Sum up
        $("." + cls).each(function() {
            var value = Number($(this).val());
            if (value == 0) {
                $(this).val('');
                //return false;
            }
			if (value > 0) {
				if(value > TRIPLE_BET_QTY_LIMIT){
					$(this).val('');
					$('#msg').html("Maximum of only "+TRIPLE_BET_QTY_LIMIT+" per coupon is allowed to buy").fadeIn();
					setTimeout( function() {
						$('#msg').fadeOut();
					}, 3000 );
					return false;
				}
			}
            sum += Number($(this).val());
        })

        var val = sum * drawPrice;
		$("#" + cls + "_qty").html(sum);
		$("#" + cls + "_amt").html(val);
		
		$("#" + cls + "_row").hide();
	//	$('#total_row').hide();
		//$('#triple_qty_amt').hide();
	//	$('.triple_random_num').removeClass('add-blink');
		if(val!='' && val!=0 ){
			$("#" + cls + "_row").show();
		/* 	$('#total_row').show();
		
			$('#triple_qty_amt').show();
			if($('#triple_qty_amt').hasClass('add-blink')){
				setTimeout(function(){ $('.triple_random_num').addClass('add-blink'); }, 1000);
			}else{
				$('#triple_qty_amt').addClass('add-blink');
			} */
			
		}
        totalDouble(cls);
	}

	function repeatOverAll(){
		$("#loading").addClass('overlay');
		$("#loading-img").show();
		$("#repeat").hide();
		$("#repeat_loader").show();
		
		if(lastTicket==''){
			$('#msg').html('No coupon available').fadeIn();
			setTimeout( function() {
				$("#loading").removeClass('overlay');
				$("#loading-img").hide();
				$('#msg').fadeOut();
				$("#repeat").show();
				$("#repeat_loader").hide();
			}, 3000 );
			
			$("#repeat").addClass('disabled').prop('disabled', true);
			return false;
		}
		
		//var response = JSON.parse($('#lastTicket').val());
		var response = lastTicket;
		if(response!=''){
				$.each( JSON.parse(response), function( key, value ) {
				  if(key==1){
					  repeatBetSingle(value.betData);
				  }
				  if(key==2){
					  repeatBetDouble(value.betData);
				  }
				  if(key==3){
					  repeatBetTriple(value.betData);
				  }
				});
		} /* else{
			$('#msg').html(response.msg).fadeIn();
				setTimeout( function() {
					$("#loading").removeClass('overlay');
					$("#loading-img").hide();
				}, 4000 );
		} */
		
		$("#loading").removeClass('overlay');
		$("#loading-img").hide();
		$("#repeat").show();
		$("#repeat_loader").hide();
	}
	
	function repeatBetSingle(data){
		//var single = $.parseJSON( data );
		var single = data;
		$.each( single, function( key, value ) {
			$('#single_row_'+key).val(value);
		}); 
		singleCalculation();
	}
	
	function repeatBetDouble(data){
		//var doublebet = $.parseJSON( data );
		var doublebet = data;
		$.each( doublebet, function( key, value ) {
			$('#two_row_'+key).val(value);
		}); 
		doubleCalculation();
	}
	
	function repeatBetTriple(data){
		//var triple = $.parseJSON( data );
		var triple = data;
		$.each( triple, function( key, value ) {
			if(key<=099){
				if( key <= 9 ){
					$('#sangam_'+key.slice(2)).val(value);
				}else{
					$('#sangam_'+key.slice(1)).val(value);
				}
			}
			if(key>=100 && key<=199){
				if(key<=109){
					$('#chetak_'+key.slice(2)).val(value);
				}else{
					$('#chetak_'+key.slice(1)).val(value);
				}
			}
			
			if(key>=200 && key<=299){
				if(key<=209){
					$('#super_'+key.slice(2)).val(value);
				}else{
					$('#super_'+key.slice(1)).val(value);
				}
			}
			
			if(key>=300 && key<=399){
				if(key<=309){
					$('#deluxe_'+key.slice(2)).val(value);
				}else{
					$('#deluxe_'+key.slice(1)).val(value);
				}
				
			}
			if(key>=400 && key<=499){
				if(key<=409){
					$('#bhagya_'+key.slice(2)).val(value);
				}else{
					$('#bhagya_'+key.slice(1)).val(value);
				}
				
			}
			
			if(key>=500 && key<=599){
				if(key<=509){
					$('#diamond_'+key.slice(2)).val(value);
				}else{
					$('#diamond_'+key.slice(1)).val(value);
				}
				
			}
			
			if(key>=600 && key<=699){
				if(key<=609){
					$('#lucky_'+key.slice(2)).val(value);
				}else{
					$('#lucky_'+key.slice(1)).val(value);
				}
				
			}
			if(key>=700 && key<=799){
				if(key<=709){
					$('#new1_'+key.slice(2)).val(value);
				}else{
					$('#new1_'+key.slice(1)).val(value);
				}
				
			}
			if(key>=800 && key<=899){
				if(key<=809){
					$('#new2_'+key.slice(2)).val(value);
				}else{
					$('#new2_'+key.slice(1)).val(value);
				}
				
			}
			if(key>=900 && key<=999){
				if(key<=909){
					$('#new3_'+key.slice(2)).val(value);
				}else{
					$('#new3_'+key.slice(1)).val(value);
				}
			}
			tripleBetCalculation();
			
		});  
	}
	function tripleBetCalculation(){
		tripleCalculation('sangam');
		tripleCalculation('chetak');
		tripleCalculation('super');
		tripleCalculation('bhagya');
		tripleCalculation('deluxe');
		tripleCalculation('diamond');
		tripleCalculation('lucky');
		tripleCalculation('new1');
		tripleCalculation('new2');
		tripleCalculation('new3');
	}
//var drawPrice = $('#drawPrice').val();
function serverTime() {
    var time = null;
    $.ajax({
        url: 'serverTime.php',
        async: false,
        dataType: 'text',
        success: function(text) {
            //time = new Date(text);
            // create Date object for current location India
            offset = '+5.5';
            d = new Date(text);
            // convert to msec
            // add local time zone offset 
            // get UTC time in msec
            utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            // create new Date object for different city
            // using supplied offset
            time = new Date(utc + (3600000 * offset));
           // console.log(time);
        },
        error: function(http, message, exc) {
            time = new Date();
        }
    });
    return time;
}

/*using clear button*/
function clearInput() {
   clearInputValue()
}

/*using clear submit success*/
function clearInputValue() {
	clearTripleRow();
	clearDoubleRow();
    clearSingleRow();
    $('#qty_2').prop('checked', true);
    $('#double :checked, #triple_tab :checked').prop('checked', false);
	$('#overall_total').html('');
//	$("#bet_double,#frmClear,#clear,#buy").addClass('disabled').prop('disabled', true);
}
function clearSingleRow(){
	$('#single_default :input').removeClass('random_sel_blink');
	$('#single_default input').each(function() {
        $(this).val('');
    })
	$('#single_qty_amt').hide();
	
	$('#single_qty').html('');
    $('#single_amt').html('');
    $('#single_total').html('');
	$('#single_overall_qty').html('');
    $('#single_overall_total').html('');
	
	$('#random_number1').val('');
	$('#tkt_qty1').val('');
	totalSingle();
    
}
function clearDoubleRow(){
	$('#two_default :input').removeClass('random_sel_blink');
	$('#two_default input').each(function() {
        $(this).val('');
    })
	
	$('#double_qty_amt').hide();
	$('#two_qty').html('');
    $('#two_amt').html('');
	
	 $('#random_number2').val('');
	 $('#tkt_qty2').val('');
	 
	$('#two_overall_qty').html('');
    $('#two_overall_total').html('');
	totalTwo();
	 
}
function clearTripleRow(){
	$('#triple_default :input').removeClass('random_sel_blink');
	$('#triple_default input').each(function() {
        $(this).val('');
    })
	
	$('#sangam_row').hide();
	$('#chetak_row').hide();
	$('#super_row').hide();
	$('#deluxe_row').hide();
	$('#bhagya_row').hide();
	$('#diamond_row').hide();
	$('#lucky_row').hide();
	$('#new1_row').hide();
	$('#new2_row').hide();
	$('#new3_row').hide();
	$('#total_row').hide();
	$('#triple_qty_amt').hide();
	
	$('#random_number').val('');
	$('#tkt_qty').val('');
	
	$('#triple_qty').html('');
    $('#triple_amt').html('');
	$('.triple_qty_div').html(0);
    $('.triple_amt_div').html(0);
	totalDouble();
}

function totalSingle() { //single
    var val = sum = 0;
    $(".single_amt_div").each(function() {
        var value = Number($(this).text());
        val += value;
    })

    $(".single_qty_div").each(function() {
        var value1 = Number($(this).text());
        sum += value1;
    })

	$('#single_qty').html(sum);
    $('#single_total').html(val);
    $('#single_overall_qty').html(sum);
    $('#single_overall_total').html(val);
	
	$('#single_qty_amt').hide();
	$('.single_random_num').removeClass('add-blink');
	if(val!='' && val!=0 ){
		$('#single_qty_amt').show();
		if($('#single_qty_amt').hasClass('add-blink')){
			setTimeout(function(){ $('.single_random_num').addClass('add-blink'); }, 1000);
		}else{
			$('#single_qty_amt').addClass('add-blink');
		}
	}
    overallTotal();
}

function totalDouble(cls='') { //triple
    var val = sum = 0;
    $(".triple_amt_div").each(function() {
        var value = Number($(this).text());
        val += value;
    })

    $(".triple_qty_div").each(function() {
        var value1 = Number($(this).text());
        sum += value1;
    })

    $('#triple_qty').html(sum);
    $('#triple_amt').html(val);
	
	$('#triple_qty_amt').hide();
	$('.triple_random_num').removeClass('add-blink');
	if(val!='' && val!=0 ){
		$('#triple_qty_amt').show();
		if($('#triple_qty_amt').hasClass('add-blink')){
			setTimeout(function(){ $('.triple_random_num').addClass('add-blink'); }, 1000);
		}else{
			$('#triple_qty_amt').addClass('add-blink');
		}
	}
    overallTotal();
    //console.log('double qty'+sum);
}

function totalTwo() { //double
    var val = sum = 0;
    $(".two_amt_div").each(function() {
        var value = Number($(this).text());
        val += value;
    })

    $(".two_qty_div").each(function() {
        var value1 = Number($(this).text());
        sum += value1;
    })

	$('#two_qty').html(sum);
    $('#two_total').html(val);
    $("#two_overall_qty").html(sum);
    $("#two_overall_total").html(val);
	
	$('#double_qty_amt').hide();

	$('.double_random_num').removeClass('add-blink');
	if(val!='' && val!=0 ){
		$('#double_qty_amt').show();
		if($('#double_qty_amt').hasClass('add-blink')){
			setTimeout(function(){ $('.double_random_num').addClass('add-blink'); }, 1000);
		}else{
			$('#double_qty_amt').addClass('add-blink');
		}
	}
	
    overallTotal();
}
var overall = 0;
var overall_qty = 0;
function overallTotal() {
    var singleTot = Number($("#single_amt").text());//single
    var doubleTot = Number($("#two_amt").text());//double
    var TripleTot = Number($("#triple_amt").text());//triple
    overall = singleTot + doubleTot + TripleTot;
    
    var single_qty = Number($("#single_qty").text());//single
    var double_qty = Number($("#two_qty").text());//double
    var triple_qty = Number($("#triple_qty").text());//triple
	overall_qty = single_qty + double_qty + triple_qty;
	
	
	$("#double_up,#frmClear,#clear,#buy").addClass('disabled').prop('disabled', true);
	if(overall!='' && overall!=0){
		$("#double_up,#frmClear,#clear,#buy").removeClass('disabled').prop('disabled', false);
	}
	/*$("#clear_single").addClass('disabled').prop('disabled', true);
	if(singleTot!='' && singleTot!==0){
		$("#clear_single").removeClass('disabled').prop('disabled', false);
	}
	$("#clear_double").addClass('disabled').prop('disabled', true);
	if(doubleTot!='' && doubleTot!==0){
		$("#clear_double").removeClass('disabled').prop('disabled', false);
	}
	$("#,#clear_triple").addClass('disabled').prop('disabled', true);
	if(TripleTot!='' && TripleTot!==0){
		$("#clear_triple").removeClass('disabled').prop('disabled', false);
    }*/
	
    $('#overall_total').html(overall);
    $('#overall_qty').html(overall_qty);
}



function ticketQty() {
    var tktQty = $('#tkt_qty').val();
    if (tktQty == '' || tktQty == 0 ) {
		var msg= "Please enter quantity";
        var activeId = $('#activeClass').val();
        var id = activeId.split("_");
        $('#random_number').val('');
        $('#tkt_qty').val('');
        $('.random_num').removeClass('active');
        //$("#" + activeId + " input").val('').removeClass('random_sel_blink');
        $("#" + activeId + " input").removeClass('random_sel_blink');
        $('#msg').html(msg).fadeIn();
        updateDoubleRowTotalQty(id[0]);
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        return 0;
    }
}

function ticket_qty_info() {
    var tktQty = Number($('input[name=qty]:checked').val());
    console.log(tktQty);
    if (tktQty == '' || tktQty == 0 || isNaN(tktQty)) {
		var msg= "Please select quantity";
        $('#msg').html(msg).fadeIn();
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        return 0;
    }
}

function addData() {
    var data = $("#HiddenData").val();
    var inputData = $("#inputData").val();
    $('#' + data).val(inputData);
    $('#loginParentId').show();
    $('#input_container').hide();
}

function genUniqueRandNumbers(start, end, count) {
    var arr = []
    while (arr.length < count) {
        var randomnumber = Math.floor(Math.random() * (end - start+1) + start);
        var found = false;
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] == randomnumber) {
                found = true;
                break
            }
        }
        if (!found) arr[arr.length] = randomnumber;
    }
    return arr;
}

function textLength(value,maxLength) {
    //var maxLength = 2;
    if (value.length > maxLength) { return false; } else { return true; }
}

function randomPick(value) {
    if (ticket_qty_info() == 0) {
        return false;
    }

    var tktQty = Number($('input[name=qty]:checked').val());
    var activeId = $('#activeClass').val();
    var id = activeId.split("_");
    if (value == '' || value == 0 || !textLength(value,2)) {
        $('#msg').html('Please enter random number  1 to 99').fadeIn();
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        $('#random_number').val('');
        $("#" + activeId + " input").val('').removeClass('random_sel_blink');
        updateDoubleRowTotalQty(id[0]);
        return false;
    }

    /*class active */
    $('.random_num').removeClass('active');
    //$(thisIs).addClass('active');
    /*class active end */
    if (textLength(value,2)) {
        var getRandNumbers = genUniqueRandNumbers(0, 99, value);

        $("#" + activeId + " input").val('').removeClass('random_sel_blink');
        if (getRandNumbers != "" && id[0] != "") {
            for (r = 0; r < value; r++) {
                $("#" + id[0] + "_" + Number(getRandNumbers[r]).toString()).val(tktQty);
                $("#" + id[0] + "_" + Number(getRandNumbers[r]).toString()).addClass('random_sel_blink');
            }
            updateDoubleRowTotalQty(id[0]);
        }
    }
}

function randomPickNumber(value, thisIs) {
    $('#random_number').val('');
    if (ticket_qty_info() == 0) {
        return false;
    }
    var tktQty = Number($('input[name=qty]:checked').val());

    /*class active */
    $('.random_num').removeClass('active');
    $(thisIs).addClass('active');
    /*class active end */

    var activeId = $('#activeClass').val();
    $("#" + activeId + " input").val('').removeClass('random_sel_blink');
    var id = activeId.split("_");
    if (id[0] != "") {
        if (value == 'all') {
            for (r = 0; r < 100; r++) {
                $("#" + id[0] + "_" + r).val(tktQty);
                $("#" + id[0] + "_" + r).addClass('random_sel_blink');
            }
        }

        if (value == 'odd') {
            for (r1 = 0; r1 < 100; r1++) {
                if (r1 % 2 != 0) {
                    $("#" + id[0] + "_" + r1).val(tktQty);
                    $("#" + id[0] + "_" + r1).addClass('random_sel_blink');
                }
            }
        }
        if (value == 'even') {
            for (r2 = 0; r2 < 100; r2++) {
                if (r2 % 2 == 0) {
                    $("#" + id[0] + "_" + r2).val(tktQty);
                    $("#" + id[0] + "_" + r2).addClass('random_sel_blink');
                }
            }
        }
        updateDoubleRowTotalQty(id[0]);
    }
}

function randomPickEndedNumber(value, checkbox) {
    if ($(checkbox).is(":checked")==true) {
        if (ticket_qty_info() == 0) {
            $(checkbox).prop('checked', false);
            return false;
        }

        $('#random_number').val('');
        var tktQty = Number($('input[name=qty]:checked').val());
        var activeId = $('#activeClass').val();

        $("#" + activeId + " input").removeClass('random_sel_blink');
        var id = activeId.split("_");
        if (id[0] != "") {
            for (var i = 0; i < 100; i++) {
                var isEndsWithZero = i % 10;
                if (isEndsWithZero == value) {
                    $("#" + id[0] + "_" + i).val(tktQty);
                    $("#" + id[0] + "_" + i).addClass('random_sel_blink');
                }
            }
            updateDoubleRowTotalQty(id[0]);
        }
    } else if ($(checkbox).is(":checked")==false) {
        //$('#random_number').val('');
        var activeId = $('#activeClass').val();
        //		$("#"+activeId+" input").val('').removeClass('random_sel_blink');
        var id = activeId.split("_");
        if (id[0] != "") {
            for (var i = 0; i < 100; i++) {
                var isEndsWithZero = i % 10;
                if (isEndsWithZero == value) {
                    $("#" + id[0] + "_" + i).val('');
                    $("#" + id[0] + "_" + i).removeClass('random_sel_blink');
                }
            }
            updateDoubleRowTotalQty(id[0]);
        }
    }
}

function updateDoubleRowTotalQty(cls) {
    var sum = 0;
    //Sum up
    $("." + cls).each(function() {
        var val = Number($(this).val());
        if (val == 0) {
            $(this).val('');
            //return false;
        }
        sum += Number($(this).val());
    })
    var val1 = sum * drawPrice;
	$("#" + cls + "_qty").html(sum);
	$("#" + cls + "_amt").html(val1);
		
	$("#" + cls + "_row").hide();
	$('#total_row').hide();
	$('#total_row').hide();
	//$('#triple_qty_amt').hide();
	//$('.triple_random_num').removeClass('add-blink');
	if(val1!='' && val1!=0 ){
		$("#" + cls + "_row").show();
		/* $('#total_row').show();
		
		$('#triple_qty_amt').show();
		if($('#triple_qty_amt').hasClass('add-blink')){
			setTimeout(function(){ $('.triple_random_num').addClass('add-blink'); }, 1000);
		}else{
			$('#triple_qty_amt').addClass('add-blink');
		} */

	}
    totalDouble(cls);
}

function tab_active( tab_value ) {
     $('#activeClass').val(tab_value);
}

function randomPickRowNumber(start, end, checkbox) {
    //$('#tkt_qty').val('');
    if ($(checkbox).is(":checked")==true) {
        if (ticket_qty_info() == 0) {
            $(checkbox).prop('checked', false);
            return false;
        }
        var tktQty = Number($('input[name=qty]:checked').val());
        var activeId = $('#activeClass').val();
        var id = activeId.split("_");

        $("#" + activeId + " input").removeClass('random_sel_blink');

        if (id[0] != "") {
            for (var i = start; i <= end; i++) {
                $("#" + id[0] + "_" + i).addClass('random_sel_blink').val(tktQty);
            }
            updateDoubleRowTotalQty(id[0]);
        }
    } else if ($(checkbox).is(":checked")==false) {
        var activeId = $('#activeClass').val();
        var id = activeId.split("_");
        if (id[0] != "") {
            for (var i = start; i <= end; i++) {
                $("#" + id[0] + "_" + i).removeClass('random_sel_blink').val('');
            }
            updateDoubleRowTotalQty(id[0]);
        }
    }
}

/****** single start ****/
function ticketQtySingle() {
    var tktQty = $('#tkt_qty1').val();
    if (tktQty == '' || tktQty == 0 ) {
		var msg= "Please enter quantity";
        $('#random_number1').val('');
        $('#tkt_qty1').val('');
        $('.random_num').removeClass('active');
        //$("#single_1 :input").val('').removeClass('random_sel_blink');
        $("#single_1 :input").removeClass('random_sel_blink');
        $('#msg').html(msg).fadeIn();
        updateSingleRowTotalQty();
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        return 0;
    }
}

function randomPickSingle(value) {
    if (ticket_qty_info() == 0) {
        return false;
    }

    var tktQty = Number($('input[name=qty]:checked').val());
    if (value == '' || value == 0 || !textLength(value,1)) {
        $('#msg').html('Please enter random number 1 to 9').fadeIn();
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        $('#random_number1').val('');
        $(".tab_one_1 :input").val('').removeClass('random_sel_blink');
        updateSingleRowTotalQty();
        return false;
    }

    /*class active */
    $('.random_num').removeClass('active');
    //$(thisIs).addClass('active');
    /*class active end */

    if (textLength(value,1)) {
        var getRandNumbers = genUniqueRandNumbers(0, 9, value);
        $(".tab_one_1 :input").val('').removeClass('random_sel_blink');

        if (getRandNumbers != "") {
            for (r = 0; r < value; r++) {
                $("#single_row_" + Number(getRandNumbers[r]).toString()).val(tktQty);
                $("#single_row_" + Number(getRandNumbers[r]).toString()).addClass('random_sel_blink');
            }
            updateSingleRowTotalQty();
        }
    }
    return false;
}

function randomPickNumberSingle(value, inputId) {
    $('#random_number1').val('');
    if (ticket_qty_info() == 0) {
        return false;
    }
    var tktQty = Number($('input[name=qty]:checked').val());

    /*class active */
    $('.random_num').removeClass('active');
    $("#" + inputId).addClass('active');
    /*class active end */

    $(".tab_one_1 :input").val('').removeClass('random_sel_blink');

    if (value == 'all') {
        for (r = 0; r < 10; r++) {
            $("#single_row_" + r).val(tktQty);
            $("#single_row_" + r).addClass('random_sel_blink');
        }
    }

    if (value == 'odd') {
        for (r1 = 0; r1 < 10; r1++) {
            if (r1 % 2 != 0) {
                $("#single_row_" + r1).val(tktQty);
                $("#single_row_" + r1).addClass('random_sel_blink');
            }
        }
    }
    if (value == 'even') {
        for (r2 = 0; r2 < 10; r2++) {
            if (r2 % 2 == 0) {
                $("#single_row_" + r2).val(tktQty);
                $("#single_row_" + r2).addClass('random_sel_blink');
            }
        }
    }
    updateSingleRowTotalQty();

}

function randomPickEndedNumberSingle(value, inputId) {
    if (ticket_qty_info() == 0) {
        return false;
    }

    $('#random_number1').val('');
    var tktQty = Number($('input[name=qty]:checked').val());
    /*class active */
    $('.random_num').removeClass('active');
    $("#" + inputId).addClass('active');
    /*class active end */

    $(".tab_one_1 :input").val('').removeClass('random_sel_blink');

    $("#single_row_" + value).val(tktQty);
    $("#single_row_" + value).addClass('random_sel_blink');
    updateSingleRowTotalQty();

}

function updateSingleRowTotalQty() {
    var sum = 0;
    //Sum up
    $(".tab_one_1 :input").each(function() {
        var val = Number($(this).val());
        if (val == 0) {
            $(this).val('');
            //return false;
        }
        sum += Number($(this).val());
    })
    var val1 = sum * drawPrice;
    $("#single_qty").html(sum);
    $("#single_amt").html(val1);
    totalSingle();
}
/****** single end ****/

/****** TWO start ****/
function ticketQtyTwo() {
    var tktQty = $('#tkt_qty2').val();
    if (tktQty == '' || tktQty == 0 ) {
		var msg = "Please enter quantity";
		
        $('#random_number2').val('');
        $('#tkt_qty2').val('');
        $('.random_num').removeClass('active');
        //$("#two_default :input").val('').removeClass('random_sel_blink');
        $("#two_default :input").removeClass('random_sel_blink');
        $('#msg').html(msg).fadeIn();
        updateTwoRowTotalQty();
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        return 0;
    }
}

function randomPickTwo(value) {
    if (ticket_qty_info() == 0) {
        return false;
    }

    var tktQty = Number($('input[name=qty]:checked').val());
    if (value == '' || value == 0 || !textLength(value,2)) {
        $('#msg').html('Please enter random number 1 to 99').fadeIn();
        setTimeout(function() {
            $("#msg").fadeOut();
        }, 2000);
        $('#random_number2').val('');
        $("#two_default :input").val('').removeClass('random_sel_blink');
        updateTwoRowTotalQty();
        return false;
    }

    /*class active */
    $('.random_num').removeClass('active');
    //$(thisIs).addClass('active');
    /*class active end */

    if (textLength(value,2)) {
        var getRandNumbers = genUniqueRandNumbers(0, 99, value);
        $("#two_default :input").val('').removeClass('random_sel_blink');
        if (getRandNumbers != "") {
            for (r = 0; r < value; r++) {
				var numb= Number(getRandNumbers[r]).toString();
			if(numb<=9){
				$("#two_row_0" + Number(getRandNumbers[r]).toString()).val(tktQty);
				$("#two_row_0" + Number(getRandNumbers[r]).toString()).addClass('random_sel_blink');
			}else{
				$("#two_row_" + Number(getRandNumbers[r]).toString()).val(tktQty);
				$("#two_row_" + Number(getRandNumbers[r]).toString()).addClass('random_sel_blink');
			}
               // $("#two_row_" + Number(getRandNumbers[r]).toString()).val(tktQty);
               // $("#two_row_" + Number(getRandNumbers[r]).toString()).addClass('random_sel_blink');
            }
            updateTwoRowTotalQty();
        }
    }
    return false;
}

function randomPickNumberTwo(value, inputId) {
    $('#random_number2').val('');
    if (ticket_qty_info() == 0) {
        return false;
    }
    var tktQty = Number($('input[name=qty]:checked').val());

    /*class active */
    $('.random_num').removeClass('active');
    $("#" + inputId).addClass('active');
    /*class active end */

    $("#two_default :input").val('').removeClass('random_sel_blink');

    if (value == 'all') {
        for (r = 0; r < 100; r++) {
			if(r<=9){
				$("#two_row_0" + r).val(tktQty);
				$("#two_row_0" + r).addClass('random_sel_blink');
			}else{
				$("#two_row_" + r).val(tktQty);
				$("#two_row_" + r).addClass('random_sel_blink');
			}
        }
    }

    if (value == 'odd') {
        for (r1 = 0; r1 < 100; r1++) {
            if (r1 % 2 != 0) {
				if(r1<=9){
					$("#two_row_0" + r1).val(tktQty);
					$("#two_row_0" + r1).addClass('random_sel_blink');
				}else{
					$("#two_row_" + r1).val(tktQty);
					$("#two_row_" + r1).addClass('random_sel_blink');
				}
                // $("#two_row_" + r1).val(tktQty);
                // $("#two_row_" + r1).addClass('random_sel_blink');
            }
        }
    }
    if (value == 'even') {
        for (r2 = 0; r2 < 100; r2++) {
            if (r2 % 2 == 0) {
				if(r2<=9){
					$("#two_row_0" + r2).val(tktQty);
					$("#two_row_0" + r2).addClass('random_sel_blink');
				}else{
					$("#two_row_" + r2).val(tktQty);
					$("#two_row_" + r2).addClass('random_sel_blink');
				}
                // $("#two_row_" + r2).val(tktQty);
                // $("#two_row_" + r2).addClass('random_sel_blink');
            }
        }
    }
    updateTwoRowTotalQty();

}

function randomPickEndedNumberTwo(value, checkbox) {
    if ($(checkbox).is(":checked")==true) {
        if (ticket_qty_info() == 0) {
            $(checkbox).prop('checked', false);
            return false;
        }

        var tktQty = Number($('input[name=qty]:checked').val());
        $("#two_default :input").removeClass('random_sel_blink');
        //$("#two_1 input").removeClass('random_sel_blink');
        for (var i = 0; i < 100; i++) {
            var isEndsWithZero = i % 10;
            if (isEndsWithZero == value) {
				if(i<=9){
					$("#two_row_0" + i).val(tktQty);
                    $("#two_row_0" + i).addClass('random_sel_blink');
                    $("#two_row_0" + i).parents('.double_sub_li_div').addClass('selected');
				}else{
					$("#two_row_" + i).val(tktQty);
                    $("#two_row_" + i).addClass('random_sel_blink');
                    $("#two_row_" + i).parents('.double_sub_li_div').addClass('selected');
				}
            }
        }
    } else if ($(checkbox).is(":checked")==false) {
        for (var i = 0; i < 100; i++) {
            var isEndsWithZero = i % 10;
            if (isEndsWithZero == value) {
				if(i<=9){
					$("#two_row_0" + i).val('');
                    $("#two_row_0" + i).removeClass('random_sel_blink');
                    $("#two_row_0" + i).parents('.double_sub_li_div').removeClass('selected');
				}else{
					$("#two_row_" + i).val('');
                    $("#two_row_" + i).removeClass('random_sel_blink');
                    $("#two_row_" + i).parents('.double_sub_li_div').removeClass('selected');
				}
            }
        }
    }
    updateTwoRowTotalQty();
}

function updateTwoRowTotalQty() {
    var sum = 0;
    //Sum up
    $(".two-chance").each(function() {
        var val = Number($(this).val());
        if (val == 0) {
            $(this).val('');
            //return false;
        }
        sum += Number($(this).val());
    })

    var val1 = sum * drawPrice;
    $("#two_qty").html(sum);
    $("#two_amt").html(val1);
    totalTwo();
}

function randomPickRowNumberTwo(start, end, checkbox) {

    if ($(checkbox).is(":checked")==true) {
        // $('#random_number').val('');
         if (ticket_qty_info() == 0) {
             return false;
        }
        var tktQty = Number($('input[name=qty]:checked').val());
        $("#two_default :input").removeClass('random_sel_blink');
		if(start==0 && end==9){
			for (var i = start; i <= end; i++) {
            $("#two_row_0" + i).addClass('random_sel_blink').val(tktQty);
            $("#two_row_0" + i).parents('.double_sub_li_div').addClass('selected');
			}
		}else{
			for (var i = start; i <= end; i++) {
                $("#two_row_" + i).addClass('random_sel_blink').val(tktQty);
                $("#two_row_" + i).parents('.double_sub_li_div').addClass('selected');
			}
		}
    } else if ($(checkbox).is(":checked")==false) {
		if(start==0 && end==9){
			for (var i = start; i <= end; i++) {
                $("#two_row_0" + i).removeClass('random_sel_blink').val('');
                $("#two_row_0" + i).parents('.double_sub_li_div').removeClass('selected');
			}
		}else{
			for (var i = start; i <= end; i++) {
                $("#two_row_" + i).removeClass('random_sel_blink').val('');
                $("#two_row_" + i).parents('.double_sub_li_div').removeClass('selected');
			}
		}
    }
    updateTwoRowTotalQty();
}
/****** TWO end ****/