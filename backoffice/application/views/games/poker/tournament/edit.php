<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/redmond/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>static/tournament/jquery.ptTimeSelect.css" />
    <script type="text/javascript" src="<?php echo base_url();?>static/tournament/jquery.ptTimeSelect.js"></script>
    <script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
    <script language="javascript" type="application/javascript">
function perTablePlayerValues(str){
   document.getElementById('tournament_max_players').value = str;
}


function showRegisterEnds(str){
	if(document.getElementById("tournament_late").checked == true){
	    document.getElementById("register_ends_status").style.display = "block";
		document.getElementById("no_need2").style.display = "none";
		document.getElementById("no_need1").style.display = "none";

	}else{
	 document.getElementById("register_ends_status").style.display = "none";
	 document.getElementById("no_need2").style.display = "block";
	 document.getElementById("no_need1").style.display = "block";
	}
}

function showReBuyBlock_old(str){
  if(document.getElementById("rebuy_setting").checked == true){ // 1 MEANS CUSTOM PRIZE STRUCTURE
       document.getElementById("rebuy_addon_setting_block").style.display = "block";
   }else{ // 2 MEANS DEFAULT PRIZE STRUCTURE
   	   document.getElementById("rebuy_addon_setting_block").style.display = "none";
   }
}

function showReBuyBlock(str){
	if(str == 1){
       document.getElementById("rebuy_setting_block").style.display = "block";
	   document.getElementById("addon_setting_block").style.display = "block";
	   document.getElementById("rebuy_num_rebuy").disabled = false;
	   document.getElementById("rebuy_eligible_chips").value = "";
	   document.getElementById("rebuy_eligible_chips").disabled = false;
	   document.getElementById("double_rebuy_features").style.display = "block";

   }else if(str == 2){
       document.getElementById("rebuy_setting_block").style.display = "block";
	   document.getElementById("addon_setting_block").style.display = "none";
	   //document.getElementById("rebuy_num_rebuy").value = 1;
	   document.getElementById("rebuy_num_rebuy").disabled = false;
	   document.getElementById("rebuy_eligible_chips").value = 0;
	   document.getElementById("rebuy_eligible_chips").disabled = true;
	   document.getElementById("double_rebuy_features").style.display = "none";
   }else if(str == 0){
       document.getElementById("rebuy_setting_block").style.display = "none";
	   document.getElementById("addon_setting_block").style.display = "none";
	   document.getElementById("rebuy_num_rebuy").disabled = false;
	   document.getElementById("rebuy_eligible_chips").value = "";
	   document.getElementById("rebuy_eligible_chips").disabled = false;
	   document.getElementById("double_rebuy_features").style.display = "block";

   }
}


function assingToRebuy(str){
	if(str){
	  	 document.getElementById('rebuy_chips_to_granted').value = str;
		 document.getElementById('addon_chips_to_granted').value = str;
	}
}


function assingToRebuyAmount(str){
	if(str){
		if(parseInt(str) > 0){
		  document.getElementById("rebuyChkBlock").style.display = "block";
		  if(document.getElementById("rebuy_setting").checked == true){
			document.getElementById("rebuy_addon_setting_block").style.display = "block";
		  }
		  document.getElementById('rebuy_amount').value = str;
		  document.getElementById('addon_amount').value = str;
		}else if(str == 0){
		   document.getElementById("rebuyChkBlock").style.display = "none";
		   document.getElementById("rebuy_addon_setting_block").style.display = "none";
		}
	}
}

function prizeStructure(str){
 if(str){
   if(str == 1){ // 1 MEANS CUSTOM PRIZE STRUCTURE
       document.getElementById("prize_field_1").style.display = "block";
	   $('#tournament_places_paid').val('');
   }else if(str == 2){ // 2 MEANS DEFAULT PRIZE STRUCTURE
   	   document.getElementById("prize_field_1").style.display = "none";
	    $('#tournament_places_paid').val('');
	   document.getElementById("prize_additional_fields").style.display = "none";
   }
 }
}

function showTournamentTicket(str){
 if(str){
   if(str == 8){ // 8 IS THE PRIZE TYPE FOR TICKETS
       document.getElementById("tour_ticket").style.display = "block";
	   document.getElementById("prize_balance_type_amt").style.display = "inline";
   }else if(str == 6){
      document.getElementById("tour_ticket").style.display = "none";
	  document.getElementById("prize_balance_type_amt").style.display = "none";

   }else{
   	   document.getElementById("tour_ticket").style.display = "none";
	   document.getElementById("prize_balance_type_amt").style.display = "inline";
   }
 }
}

function showLoyaltyFields(str){
  if(str){
   if(str == 7){ // 7 IS THE COINT TYPE OF LOYALTY
       document.getElementById("balanceTypeValues").style.display = "block";
	   document.getElementById("is_deposit_balance").checked = "";
	   document.getElementById("is_deposit_balance").disabled = true;
	   document.getElementById("is_promo_balance").checked = "";
	   document.getElementById("is_promo_balance").disabled = true;
	   document.getElementById("is_win_balance").checked = "checked";

	   document.getElementById("loyalty_dates").style.display = "block";
	   document.getElementById("amountFields").style.display = "block";
	   document.getElementById("commision_td").style.display = "none";
	   document.getElementById("rebuyChkBlock").style.display = "none";
	   document.getElementById("rebuy_addon_setting_block").style.display = "none";

   }else if(str == 6){ // 7 IS THE COINT TYPE OF LOYALTY
       document.getElementById("balanceTypeValues").style.display = "block";
	   document.getElementById("is_deposit_balance").checked = "";
	   document.getElementById("is_deposit_balance").disabled = true;
	   document.getElementById("is_promo_balance").checked = "";
	   document.getElementById("is_promo_balance").disabled = true;
	   document.getElementById("is_win_balance").checked = "checked";

	   document.getElementById("loyalty_dates").style.display = "none";
	   document.getElementById("amountFields").style.display = "block";
	   document.getElementById("commision_td").style.display = "block";
	   document.getElementById("rebuyChkBlock").style.display = "none";
	   document.getElementById("rebuy_addon_setting_block").style.display = "none";


   }else if(str == 8){
      document.getElementById("balanceTypeValues").style.display = "none";
	  document.getElementById("is_deposit_balance").checked = "";
      document.getElementById("is_deposit_balance").disabled = true;
	  document.getElementById("is_promo_balance").checked = "";
      document.getElementById("is_promo_balance").disabled = true;
	  document.getElementById("is_win_balance").checked = "";
	  document.getElementById("is_win_balance").disabled = true;

	  document.getElementById("amountFields").style.display = "none";
      document.getElementById("loyalty_dates").style.display = "none";
	  document.getElementById("commision_td").style.display = "block";
	  document.getElementById("rebuyChkBlock").style.display = "none";
	  document.getElementById("rebuy_addon_setting_block").style.display = "none";
   }else{
       document.getElementById("balanceTypeValues").style.display = "block";
	   document.getElementById("is_deposit_balance").checked = "checked";
	   document.getElementById("is_promo_balance").checked = "";
	   document.getElementById("is_win_balance").checked = "checked";
	   document.getElementById("is_deposit_balance").disabled = false;
	   document.getElementById("is_promo_balance").disabled = false;
	   document.getElementById("is_win_balance").disabled = false;

	   document.getElementById("amountFields").style.display = "block";
   	   document.getElementById("loyalty_dates").style.display = "none";
	   document.getElementById("commision_td").style.display = "block";
	   document.getElementById("rebuyChkBlock").style.display = "block";
	   if(document.getElementById("rebuy_setting").checked == true){
	   	document.getElementById("rebuy_addon_setting_block").style.display = "block";
	   }
   }
 }
}

function getRadioVal(form, name) {
    var val;
    var radios = form.elements[name];
    for (var i=0, len=radios.length; i<len; i++) {
        if ( radios[i].checked ) { // radio checked?
            val = radios[i].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
    return val; // return value of checked radio or undefined if none checked
}

function listWinnersBox(str){
 var tournament_type = $('#maingame_tournament_type').val();
  if(tournament_type!=2) {
   var tableValue = '';
   if(str > 0){
   for(var i=1;i<=str;i++){
   	tableValue += '<table width="100%" style="position: relative; left: 10px;"><tr><td width="25%"><label>'+i+'.  <input name="tournament_prize_'+i+'" type="text" class="TextField required" onkeypress="return checkNumberKey(event)" id="tournament_prize_'+i+'" tabindex="32" maxlength="5" /> (%)</label></td></tr><tr><td width="25%"></td><td width="25%"></td><td width="25%"></td></tr></table>';
    }
	 document.getElementById("prize_additional_fields").style.display = "block";
     document.getElementById("prize_additional_fields").innerHTML = tableValue;
   }else{
     //if needed
   }
  }
}

function validate(){
    var is_deposit_balance		= document.getElementById('is_deposit_balance');
	var is_promo_balance 	= document.getElementById('is_promo_balance');
	var is_win_balance	= document.getElementById('is_win_balance');
	if (is_deposit_balance.checked || is_promo_balance.checked || is_win_balance.checked ) {
		//have any one checked
	}else{
		 document.getElementById("balanceErr").style.display = "block";
	     //return false;
	}

  /* Check late registration hours and (rebuytimeperiod * blind increment time)
     late registration must be less than (rebuytimeperiod * blind increment time)
  */
  if(document.getElementById("rebuy_setting").checked == true && document.getElementById("tournament_late").checked == true){
  	var registerEndTime		= document.getElementById('tournament_reg_ends').value;
	var rebuyLevelconfig 	= document.getElementById('rebuy_timeperiod').value;
	var blindIncrementTime	= document.getElementById('tournament_bind_increment_time').value;
	var multipleTime		= parseInt(rebuyLevelconfig) * parseInt(blindIncrementTime);
    if(parseInt(registerEndTime) > parseInt(multipleTime)){
	  document.getElementById("lateRegisErr").style.display = "block";
	  return false;
	}else{
	  document.getElementById("lateRegisErr").style.display = "none";
	}
  }else{
    document.getElementById("lateRegisErr").style.display = "none";
  }

 var prizeType = getRadioVal( document.getElementById('frmTournament'), 'prize_type' );
 var noPlaces = document.getElementById('tournament_places_paid').value;
 var sum = 0;
  if (prizeType == 1){
  	if(noPlaces > 0){
	   for(var j=1;j<=noPlaces;j++){
	  	 var winnerTextValue = document.getElementById('tournament_prize_'+j).value;
		 sum += parseFloat(winnerTextValue);
	   }
	}
  }else{
    document.getElementById("winnerInstruction").innerHTML = '';
    return true;
  }

 // alert(parseFloat(sum));
 if (prizeType == 1){
 	if(noPlaces > 0){
	  if(parseFloat(sum).toFixed(2) != 100){
		 document.getElementById("winnerInstruction").innerHTML = '<font color="red" style="position: relative; left: 9px;">Sum of winners percentage must be equal to 100</font>';
		 return false;
	  }else{
		document.getElementById("winnerInstruction").innerHTML = '';
		return true;
	  }
   }
  }
}

function Converttimeformat(str) {
	// var time = $("#starttime").val();
	var time = str;
	var hrs = Number(time.match(/^(\d+)/)[1]);
	var mnts = Number(time.match(/:(\d+)/)[1]);
	var format = time.match(/\s(.*)$/)[1];
	if (format == "PM" && hrs < 12) hrs = hrs + 12;
	if (format == "AM" && hrs == 12) hrs = hrs - 12;
	var hours = hrs.toString();
	var minutes = mnts.toString();
	if (hrs < 10) hours = "0" + hours;
	if (mnts < 10) minutes = "0" + minutes;
	var needFormat = hours + ":" + minutes;
	return needFormat;
}


$(document).ready(function () {
	<?php if($results->TOURNAMENT_STATUS == 2 || $results->TOURNAMENT_STATUS == 3  || $results->TOURNAMENT_STATUS == 6 || $results->TOURNAMENT_STATUS == 5 || $isAllowed == 0){ ?>
	//$("#frmTournament :input").attr('readonly', true);
	$("#frmTournament input, #frmTournament select").attr('disabled',true);
	<?php } ?>
	$.validator.addMethod("zeroexist", function (value, element) {
        	return value >= ($("#tournament_amount").val()<1);
    }, 'Must Be Greater Than Zero');

	$.validator.addMethod("mxzeroexist", function (value, element) {
        	return value >= ($("#tournament_max_players").val()<1);
    }, 'Must Be Greater Than Zero');

	$.validator.addMethod("mizeroexist", function (value, element) {
        	return value >= ($("#tournament_min_players").val()<1);
    }, 'Must Be Greater Than Zero');

	$.validator.addMethod("minplayerCheck", function (value, element) {
	  // alert(value <= 2);
        return value >= 2;
    }, 'Must Be Greater Than 1');

	$.validator.addMethod("checkmaxplayer", function (value, element) {
        return value <= $("#tournament_player_pertable").val();
    }, 'Players should be less than Players per table');

	$.validator.addMethod("checkmaxvsminplayer1", function (value, element) {
       // alert(trim($("#tournament_min_players").val()));
        return parseInt(value) >= (parseInt($("#tournament_min_players").val()));
    }, 'Maximum players should be greater than or equal to minimum player');

	$.validator.addMethod("greaterThanZero", function(value, element) {
   	 return this.optional(element) || (parseFloat(value) > 0);
	}, "Must Be Greater Than Zero");

	$.validator.addMethod("nowinnerzero", function (value, element) {
        	return value >= ($("#tournament_places_paid").val()<1);
    }, 'Must Be Greater Than Zero');

	$.validator.addMethod("prizepoolzero", function (value, element) {
        	return value >= ($("#tournament_prize_pool").val()<1);
    }, 'Must Be Greater Than Zero');

	$.validator.addMethod("alphabetsOnly",
	  function (value, element) {
		  var alphabetsOnlyRegExp = new RegExp("^[\\a-zA-Z,0-9,._ ]+$");

		  if (alphabetsOnlyRegExp.test(element.value)) {
			return true;
		  } else {
			return false;
		  }
	  },
	"Tournament Name Must Contain Only [letters,alphabets,space,_ and .]"
	);

	$.validator.addMethod("checkstarchipvsrebuychips", function (value, element) {
        return parseInt(value) <= (parseInt($("#tournament_start_chip_amount").val()));
    }, 'Player Max. Eligible Chips should be less than or equal to Starting Chips Count');


/*	$.validator.addMethod("greaterThan",
		function(value, element, params) {
			var tournamentDate = new Date(value);
			var registerDate = new Date($(params).val());
			if (registerDate > tournamentDate){
 			   return false;
			}else{
			   return true;
			}

		},'Must be greater than Registration Date.');*/

	$.validator.addMethod("greaterThan",
		function(value, element, params) {
			var tournamentDate = new Date(value);
			var registerDate = new Date($(params).val());
			if (registerDate > tournamentDate){
 			   return false;
			}else if(tournamentDate.getTime() === registerDate.getTime()){
			  var tournamentTime = $("#tournament_time").val();
			  var registrationTime = $("#tournament_reg_start_time").val();
			  if(tournamentTime != '' && registrationTime != ''){
			     var convertTournamentTime   = Converttimeformat(tournamentTime);
				 var convertRegistrationTime = Converttimeformat(registrationTime);
				 if (convertRegistrationTime >= convertTournamentTime){
				   return false;
				 }else{
				   return true;
				 }
			  }else{
			    return true;
			  }
			}else{
			   return true;
			}

		},'Must be greater than Registration Date/Time.');

    $.validator.addMethod("greaterThanLoyalty",
		function(value, element, params) {
			var endDate = new Date(value);
			var startDate = new Date($(params).val());
			if (startDate > endDate){
 			   return false;
			}else{
			   return true;
			}

		},'Must be greater than Start Date.');

	/*$.validator.addMethod("pastDate",
		function(value, element, params) {
			var selectedDate = new Date(value);
			var currentDate = new Date($(params).val());
			if (currentDate > selectedDate){
 			   return false;
			}else{
			   return true;
			}

		},'Past Date Not Allowed');	*/

	$.validator.addMethod("pastDate",
		function(value, element, params) {
			var selectedDate = new Date(value);
			var currentDate = new Date($(params).val());
			if (currentDate > selectedDate){
 			   return false;
			}else if(currentDate.getTime() === selectedDate.getTime()){
			  var currentTime = $("#currentTime").val();
			  var selectedTime = $("#tournament_time").val();
				if(currentTime != '' && selectedTime != ''){
			     var convertCurrentTime1  = currentTime;
				 var convertSelectedTime1 = Converttimeformat(selectedTime);
				 if (convertCurrentTime1 > convertSelectedTime1){
				   return false;
				 }else{
				   return true;
				 }
			  }else{
			    return true;
			  }
			}else{
			   return true;
			}

		},'Past Date/Time Not Allowed');

	$.validator.addMethod("pastDate1",
		function(value, element, params) {
			var selectedDate = new Date(value);
			var currentDate = new Date($(params).val());
			if (currentDate > selectedDate){
 			   return false;
			}else if(currentDate.getTime() === selectedDate.getTime()){
			  var currentTime = $("#currentTime").val();
			  var selectedTime = $("#tournament_reg_start_time").val();
			  if(currentTime != '' && selectedTime != ''){
			     var convertCurrentTime   = currentTime;
				 var convertSelectedTime = Converttimeformat(selectedTime);
				 if (convertCurrentTime > convertSelectedTime){
				   return false;
				 }else{
				   return true;
				 }
			  }else{
			    return true;
			  }
			}else{
			   return true;
			}

		},'Past Date/Time Not Allowed');

	$('#frmTournament').validate({
       //alert(document.getElementById('tournament_places_paid').values);
		rules: {
		"tournament_type": {
			required: true
		 },
		"tournament_name": {
			required: true,
			/*alphabetsOnly: true,*/
			minlength:4
		 },
		"tournamet_gamestatus": {
		    required: true
		},
		"tournamet_game_type": {
		    required: true
		},
		"tournament_date": {
		    required: true,
			greaterThan: "#tournament_reg_start_date",
			pastDate:"#currentDate"
		},
		"tournament_time": {
		    required: true
		},
		"tournament_reg_start_date": {
		    required: true,
			pastDate1:"#currentDate"
		},
		"tournament_reg_start_time": {
		    required: true
		},
		"tournament_reg_ends": {
		    required: true,
			digits: true
		},
		"tournament_player_pertable": {
		    required: true
		},
		"tournament_min_players": {
		    required: true,
			digits: true,
			minplayerCheck: true,
			mizeroexist: true,
			//checkmaxplayer: true

		},
		"tournament_max_players": {
		    required: true,
			digits: true,
			mxzeroexist: true,
			//checkmaxplayer: true,
			checkmaxvsminplayer1: true
		},
		"tournament_cash_type": {
		    required: true
		},
		"tournament_amount": {
		    required: true,
			digits: true
			//zeroexist: true
		},
		"tournament_commision": {
		    required: true,
			number: true
		},
		"loyalty_start_date": {
		    required: true
		},
		"loyalty_end_date": {
		    required: true,
			greaterThanLoyalty: "#loyalty_start_date"
		},
		"tournament_places_paid": {
		    required: true,
			digits: true,
			nowinnerzero: true
		},
		"tournament_prize_pool": {
		    required: true,
			digits: true
			//prizepoolzero: true
		},
		"tournament_start_blinds": {
		    required: true
		},
		"tournament_bind_increment_time": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"tournament_start_chip_amount": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"tournament_turn_time": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"tournament_discount_time": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"tournament_extra_time": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"rebuy_chips_to_granted": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"rebuy_eligible_chips": {
		    required: true,
			digits: true,
			greaterThanZero: true,
			checkstarchipvsrebuychips: true
		},
		"rebuy_timeperiod": {
		    required: true
		},
		"rebuy_num_rebuy": {
		    required: true
		},
		"rebuy_amount": {
		    required: true,
			digits: true,
			greaterThanZero: true

		},
		"rebuy_entryfee": {
		    required: true,
			digits: true
		},
		"addon_chips_to_granted": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"addon_timeperiod": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"addon_amount": {
		    required: true,
			digits: true,
			greaterThanZero: true
		},
		"addon_entryfee": {
		    required: true,
			digits: true
		},
		"prize_type": {
		    required: true
		}

  	},
	messages: {
    	"tournament_type": {
			required:"Select Type"
		},
		"tournament_name": {
			required:"Enter Name"
		},
		"tournamet_gamestatus": {
		 required: "Select Game Status"
		},
		"tournamet_game_type": {
		 required: "Select Game Type"
		},
		"tournament_date": {
		required: "Enter Tournament Start Date"
		},
		"tournament_time": {
		required: "Enter Tournament Start Time"
		},
		"tournament_reg_start_date": {
		required: "Enter Registration Start Date"
		},
		"tournament_reg_start_time": {
		required: "Enter Registration Start Time"
		},
		"tournament_reg_ends": {
		required: "Enter Registration Ends"
		},
		"tournament_player_pertable": {
		required: "Enter Player Per Table"
		},
		"tournament_min_players": {
		required: "Enter Minimum Players"
		},
		"tournament_max_players": {
		required: "Enter Maximum Players"
		},
		"tournament_cash_type": {
		required: "Select Cash Type"
		},
		"tournament_amount": {
		required: "Enter Tournament Amount"
		},
		"tournament_commision": {
		required: "Enter Tournament Commission"
		},
		"loyalty_start_date": {
		required: "Enter Loyalty Start Date"
		},
		"loyalty_end_date": {
		required: "Enter Loyalty End Date"
		},
		"tournament_places_paid": {
		required: "Enter Number Of Places Paid"
		},
		"tournament_prize_pool": {
		    required: "Enter Prize Pool Value"
		},
		"tournament_start_blinds": {
		required: "Select Start Blinds"
		},
		"tournament_bind_increment_time": {
		required: "Enter Blind Increment Time"
		},
		"tournament_start_chip_amount": {
		required: "Enter Start Chip Amount"
		},
		"tournament_turn_time": {
		required: "Enter Turn Time"
		},
		"tournament_discount_time": {
		required: "Enter Disconnect Time"
		},
		"tournament_extra_time": {
		required: "Enter Extra Time"
		},
		"rebuy_chips_to_granted": {
		required: "Enter Rebuy Chips To Be Granted"
		},
		"rebuy_eligible_chips": {
		required: "Enter Rebuy Eligible Chips"
		},
		"rebuy_timeperiod": {
		required: "Enter Rebuy Time Period"
		},
		"rebuy_num_rebuy": {
		required: "Enter Number Of Rebuy"
		},
		"rebuy_amount": {
		required: "Enter Rebuy Amount"
		},
		"rebuy_entryfee": {
		required: "Enter Rebuy Entry Fee"
		},
		"addon_chips_to_granted": {
		required: "Enter Addon Chips To Be Granted"
		},
		"addon_timeperiod": {
		required: "Enter Addon Time Interval"
		},
		"addon_amount": {
		required: "Enter Addon Amount"
		},
		"addon_entryfee": {
		required: "Enter Addon Entry Fee"
		},
		"prize_type": {
		required: "Choose Prize Type"
		}
    }

 });

});

function checkNumberKeyWithOutZero(evt) {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   //alert(charCode);
   if (charCode != 46 && charCode > 31 && (charCode < 49 || charCode > 57))
   	return false;

   return true;
}


function checkNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   //alert(charCode);
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
   	return false;

   return true;
}

function IsAlphaNumeric(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57) && (charCode >= 97 || charCode <= 122))
	return false;

   return true;
}

</script>
<script type="text/javascript">
 $(document).ready(function() {
	  $("#maingame_tournament_type").change(function() {
		 var tournament_type_id = $(this).val();
			if(tournament_type_id==1) {
				$('#normal_tournament').show();
				$('#satellite_tournament').hide();
				$('#main_tournament_normal').hide();
				$('#tournament_prize_normal').show();
				$('#tournament_prize_satellite').hide();
				$('#tournament_places_paid').val('');
				$('#normal_prize_pool').show();
			}else {
				$('#normal_tournament').hide();
				$('#satellite_tournament').show();
				$('#main_tournament_normal').show();
				$('#tournament_prize_normal').hide();
				$('#tournament_prize_satellite').show();
				$('#tournament_places_paid').val('');
				$('#normal_prize_pool').hide();
			}
	  });
  });
</script>
<style>
.NoticeMsg {
    background-color: #f5da81;
    border: 1px solid #ffd7d7;
    border-radius: 5px;
    color: #970000;
    font-size: 14px;
    font-weight: bold;
    padding: 10px;
    text-align: left;
    text-decoration: none;
    width: 100%;
}
</style>
    <script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
    <style>
/* New styles below */
label.valid {
  /*background: url(assets/img/valid.png) center center no-repeat;*/
  display: inline-block;
  text-indent: -9999px;
}
label.error {
	color: #FF0000;
    font-weight: normal;
    left: -14px;
    margin-top: -5px;
    padding: 0 14px;
    position: relative;
    top: 7px;
	float:left;
}
#ptTimeSelectCntr{
  width:15em !important;
}
.overlayApp{
 overflow: hidden;
 background: none repeat scroll 0px 0px rgb(238, 238, 238);
 opacity: 0.40;
}

</style>
<?php //echo "<pre>"; print_r($results); die; ?>
    <?php if($results->TOURNAMENT_STATUS == 2 || $results->TOURNAMENT_STATUS == 3 ){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="NoticeMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
            <td width="95%">Tournament Already Started. You Cannot Edit Tournament Parameters.</td>
          </tr>
        </table>
      </div>
      <?php }else if($results->TOURNAMENT_STATUS == 1){ ?>
	     <div class="UpdateMsgWrap">
        <table width="100%" class="NoticeMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
            <td width="95%">Note: Registration is already started for this tournament.</td>
          </tr>
        </table>
      </div>
	  <?php }else if($results->TOURNAMENT_STATUS == 6){ ?>
	     <div class="UpdateMsgWrap">
        <table width="100%" class="NoticeMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
            <td width="95%">Tournament Already Cancelled. You Cannot Edit Tournament Parameters.</td>
          </tr>
        </table>
      </div>
	  <?php }else if($results->TOURNAMENT_STATUS == 5){ ?>
	     <div class="UpdateMsgWrap">
        <table width="100%" class="NoticeMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
            <td width="95%">Tournament Already Finished. You Cannot Edit Tournament Parameters.</td>
          </tr>
        </table>
      </div>
	  <?php }else if($isAllowed == 0){ ?>
	  <div class="UpdateMsgWrap">
      <table width="100%" class="NoticeMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
          <td width="95%">Tournament Features Are Not Properly Assigned To Your Account. Please Contact Administrator.</td>
        </tr>
      </table>
    </div>
	  <?php } ?>

    <table width="100%" class="PageHdr">
      <tr>
        <td><strong>EDIT TOURNAMENT</strong>
          <table width="50%" align="right">

          </table></td>
      </tr>
    </table>
    <?php if($_GET['err']==1){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="SuccessMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
            <td width="95%">Tournament Updated Successfully</td>
          </tr>
        </table>
      </div>
      <?php } ?>

       <?php if($_GET['err']==6){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="ErrorMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
            <td width="95%">Something Went Wrong.Please Try Again</td>
          </tr>
        </table>
      </div>
      <?php }
	 if($results->TOURNAMENT_STATUS == 2 || $results->TOURNAMENT_STATUS == 3 || $results->TOURNAMENT_STATUS == 6  || $results->TOURNAMENT_STATUS == 5 || $isAllowed == 0){
	  $overlayStyle = 'overlayApp';
	 }else{
	  $overlayStyle = '';
	 }
	   ?>
     <div class="<?php echo $overlayStyle; ?>">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
      <tr>
        <td><table width="100%" class="ContentHdr">
            <tr>
              <td>Tournament Information</td>
            </tr>
          </table>
          <form method="post" name="frmTournament" id="frmTournament">
            <?php
			  if(is_array($getTournamentTypes) && count($getTournamentTypes)){
			    ?>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Type:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <?php foreach($getTournamentTypes as $tournamentType){ ?>
                  <label>
                  <input name="tournament_type" type="radio" id="tournament_type" tabindex="1" value="<?php echo $tournamentType->TOURNAMENT_TYPE_ID; ?>"/>
                  <?php echo $tournamentType->DESCRIPTION; ?> &nbsp;&nbsp;&nbsp;</label>
                  <?php } ?>
                </td>
              </tr>
            </table>
            <?php } ?>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="20%"><span class="TextFieldHdr">Name:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_name" type="text" class="TextField" id="tournament_name" tabindex="3" value="<?php echo $results->TOURNAMENT_NAME; ?>" maxlength="60" readonly="readonly" />
                  </label>
                </td>
                <!--Checking Tournament or Recurrence Tournament-->
             <?php if($results->MASTER_ID=='0') { ?>
                 <td width="20%"><span class="TextFieldHdr">Tournament Type:</span><span class="mandatory">*</span><br />
                  <label>
                   <select name="maingame_tournament_type" class="ListMenu" id="maingame_tournament_type" tabindex="4" disabled="disabled" >
                   	 <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID=='') { ?>
                   			<option value="1" selected="selected">Normal </option>
                            <option value="2" >Satellite </option>
                     <?php }else { ?>
                     		<option value="1">Normal </option>
                            <option value="2" selected="selected">Satellite </option>
                     <?php } ?>
                   </select>
         <input type="hidden" name="maingame_tournament_type" value=<?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID=='') { echo "1";} else { echo "2";  } ?> />

                  </label>
                </td>
              <?php }  ?>

              <td width="20%"><span class="TextFieldHdr">Game Type:</span><span class="mandatory">*</span><br />
                <div id="normal_tournament" <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID!='') { ?> style="display:none;" <?php } ?>>
                  <label>
                  <select name="tournamet_game_type" class="ListMenu" id="tournamet_game_type" tabindex="6">
                  <?php  if($results->TOURNAMENT_TYPE_ID==2 && $results->LOBBY_ID==3 && $results->MINI_GAME_TYPE_ID==1) { ?>
                  		<option value="1">Texas Hold'em</option>
                        <option value="2">Omaha</option>
                        <option value="3">Texas Hold'em Event</option>
                        <option value="4">Omaha Event</option>
					 	<option value="5">Satellite Texas Holdem</option>
                      	<option value="6">Satellite Omaha</option>
                        <option value="7" selected="selected">Satellite Texas Hold'em Event</option>
                        <option value="8">Satellite Omaha Event</option>
                  <?php }else if($results->TOURNAMENT_TYPE_ID==2 && $results->LOBBY_ID==3 && $results->MINI_GAME_TYPE_ID==2) {  ?>
				   		<option value="1">Texas Hold'em</option>
                        <option value="2">Omaha</option>
                        <option value="3">Texas Hold'em Event</option>
                        <option value="4">Omaha Event</option>
					 	<option value="5">Satellite Texas Holdem</option>
                      	<option value="6">Satellite Omaha</option>
                        <option value="7">Satellite Texas Hold'em Event</option>
                        <option value="8" selected="selected">Satellite Omaha Event</option>
                   <?php }else if($results->TOURNAMENT_TYPE_ID==2 && $results->MINI_GAME_TYPE_ID==1) { ?>
                   		<option value="1">Texas Hold'em</option>
                        <option value="2">Omaha</option>
                        <option value="3">Texas Hold'em Event</option>
                        <option value="4">Omaha Event</option>
					 	<option value="5" selected="selected">Satellite Texas Holdem</option>
                        <option value="6">Satellite Omaha</option>
                        <option value="7">Satellite Texas Hold'em Event</option>
                        <option value="8">Satellite Omaha Event</option>
					 <?php } else if($results->TOURNAMENT_TYPE_ID==2 && $results->MINI_GAME_TYPE_ID==2) { ?>
                    	<option value="1">Texas Hold'em</option>
                        <option value="2">Omaha</option>
                        <option value="3">Texas Hold'em Event</option>
                        <option value="4">Omaha Event</option>
					 	<option value="5">Satellite Texas Holdem</option>
                      	<option value="6" selected="selected">Satellite Omaha</option>
                        <option value="7">Satellite Texas Hold'em Event</option>
                        <option value="8">Satellite Omaha Event</option>
                     <?php } else {  ?>
				  <?php foreach($getTournamentGameTypes as $gaIndex=>$gameType){ ?>
                    <option <?PHP if($results->MINI_GAME_TYPE_ID ==  $gameType->MINIGAMES_TYPE_ID) echo 'selected="selected"'; ?> value="<?php echo $gameType->MINIGAMES_TYPE_ID;?>"><?php echo $gameType->GAME_DESCRIPTION;?></option>
                    <?php } ?>
                   <?php } ?>
                  </select>
                  </label>
                  </div>
                 <div id="satellite_tournament" <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID=='') { ?> style="display:none;" <?php } ?>>
                  <label>
                  <select name="tournamet_satellite_game_type" class="ListMenu" id="tournamet_satellite_game_type" tabindex="6">
					<?php foreach($getSatelliteTournamentTypes as $gaIndex=>$gameType){ ?>
                    <option <?PHP if($results->MINI_GAME_TYPE_ID ==  $gameType->MINIGAMES_TYPE_ID) echo 'selected="selected"'; ?> value="<?php echo $gameType->MINIGAMES_TYPE_ID;?>"><?php echo $gameType->GAME_DESCRIPTION;?></option>
                    <?php } ?>
                  </select>
                  </label>
                  </div>
                </td>
               <?php if($results->TOURNAMENT_STATUS == 0){ ?>
                <td width="20%"><span class="TextFieldHdr">Status:</span><span class="mandatory">*</span><br />
                  <label>
                  <select name="tournamet_gamestatus" class="ListMenu" id="tournamet_gamestatus" tabindex="5">
                    <option <?php if($results->IS_ACTIVE == 1) echo 'selected="selected"'; ?> value="1">Active</option>
                    <option <?php if($results->IS_ACTIVE == 0) echo 'selected="selected"'; ?> value="0">Inactive</option>
                  </select>
                  </label>
                </td>
                <?php } ?>
                <td width="20%"><span class="TextFieldHdr">Limit:</span><span class="mandatory">*</span><br />
                  <label>
                  <select name="tournamet_limit" class="ListMenu" id="tournamet_limit" tabindex="6">
                    <?php foreach($getTournamentLimits as $limits){ 	?>
                    <option <?php if($results->TOURNAMENT_LIMIT_ID == $limits->TOURNAMENT_LIMIT_ID) echo 'selected="selected"'; ?> value="<?php echo $limits->TOURNAMENT_LIMIT_ID; ?>"><?php echo $limits->DESCRIPTION; ?></option>
                    <?php } ?>
                  </select>
                  </label>
                </td>
              </tr>
             <tr>
             <td width="20%"><span class="TextFieldHdr">Select Server:</span><span class="mandatory">*</span><br />
               <label>
                <select name="tournament_server" class="ListMenu" id="tournament_server" tabindex="4">
                 <option value="">Select</option>
                 <?php foreach($servers as $server){ ?>
                 <option <?php if($results->SERVER_ID == $server->SERVER_ID) echo 'selected="selected"'; ?>  value="<?php echo $server->SERVER_ID; ?>"><?php echo $server->SERVER_NAME; ?></option>
                 <?php } ?>
                 </select>
               </label>
             </td>
             <?php if($results->MASTER_ID=='0') { ?>
              <td width="25%">
                <div id ="main_tournament_normal" <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID=='') { ?> style="display:none;" <?php } ?>>
              	 <label><span class="TextFieldHdr" id="main_tournament_name">Select Main Tournament:</span><br />
                 	 <select name="main_tournament" class="ListMenu" id="main_tournament" tabindex="7">
                    <?php foreach($getMainTournamentTypes as $mainType){ 	?>
                       <option <?php if($results->FK_PARENT_TOURNAMENT_ID == $mainType->TOURNAMENT_ID) echo 'selected="selected"'; ?> value="<?php echo $mainType->TOURNAMENT_ID; ?>"><?php echo $mainType->TOURNAMENT_NAME; ?></option>
                   <?php }  ?>
                   </select>
                 </label>
                </div>
              </td>
             <?php } else { ?>
              <td width="25%">&nbsp;</td>
             <?php } ?>
             </tr>
            </table>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Timings</td>
              </tr>
            </table>
                <?php if($results->TOURNAMENT_STATUS == 1){
			      $registrationStyle  = 'style="display:none;"';
                }else{
				  $registrationStyle  = 'style="display:block;"';
				} ?>

            <table <?php echo $registrationStyle; ?> width="100%" cellpadding="10" cellspacing="10">
              <tr>
              <input type="hidden" id="currentDate" value="<?php echo date("Y-m-d"); ?>">
              <input type="hidden" id="currentTime" value="<?php echo date("H:i"); ?>">
           	     <?php
				   //dates and time calculation
				   $tournamentStartDate = $this->tournament_model->convertDateIntoNeedFormate($results->TOURNAMENT_START_TIME);
				   $tournamentStartTime = $this->tournament_model->convert24Hto12H(date("H:i:s",strtotime($results->TOURNAMENT_START_TIME)));
				   $tournamentRstartDate= $this->tournament_model->convertDateIntoNeedFormate($results->REGISTER_START_TIME);
				   $tournamentRstartTime= $this->tournament_model->convert24Hto12H(date("H:i:s",strtotime($results->REGISTER_START_TIME)));
				   $tournamentEnds      = $this->tournament_model->getMinutestBetweenDates($results->TOURNAMENT_START_TIME,$results->REGISTER_END_TIME);

				  ?>


           		<td width="32%"><span class="TextFieldHdr">Registration Start Date:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_reg_start_date" type="text" class="TextField" id="tournament_reg_start_date" value="<?php echo $tournamentRstartDate; ?>" tabindex="9" maxlength="50" readonly="readonly" />
                  </label>
                  <a onclick="NewCssCal('tournament_reg_start_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                <td id="sample2" width="20%"><span class="TextFieldHdr">Registration Start Time:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_reg_start_time" type="text" class="TextField" id="tournament_reg_start_time" value="<?php echo $tournamentRstartTime; ?>" tabindex="10" maxlength="50" readonly="readonly" />
                  </label>
                </td>


                <td width="32%"><span class="TextFieldHdr">Tournament Start Date:</span><span class="mandatory">*</span><br />
                  <label>

                  <input name="tournament_date" type="text" class="TextField" id="tournament_date" tabindex="7" maxlength="50" value="<?php echo $tournamentStartDate; ?>" readonly="readonly"/>
                  </label>
                  <a onclick="NewCssCal('tournament_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                <td id="sample1" width="20%"><span   class="TextFieldHdr">Tournament Start Time:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_time" type="text" class="TextField" id="tournament_time" tabindex="8" maxlength="50" value="<?php echo $tournamentStartTime; ?>" readonly="readonly" />
                  </label>
                </td>


              </tr>
            </table>


            <table <?php echo $registrationStyle; ?> width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%"><span class="TextFieldHdr">Late Registration:</span><br />
                  <label>
                  <input <?php if($results->LATE_REGISTRATION_END_TIME > 0) echo 'checked="checked"'; ?> onclick="showRegisterEnds(this.value);" name="tournament_late" type="checkbox" class="TextField" id="tournament_late" tabindex="11" maxlength="50" />
                  </label>
                </td>
                <?php if($results->LATE_REGISTRATION_END_TIME > 0){ ?>
                <td id="register_ends_status"  width="25%"><span class="TextFieldHdr">Registration Ends:</span><span class="mandatory">*</span> (min)<br />
                   <label>
                  <input value="<?php echo $results->LATE_REGISTRATION_END_TIME; ?>" onkeypress="return checkNumberKey(event)" name="tournament_reg_ends" type="text" class="TextField" id="tournament_reg_ends" tabindex="12" maxlength="3" />
                  </label> </td>
                <?php }else{ ?>
                <td id="register_ends_status" style="display:none;" width="25%"><span class="TextFieldHdr">Registration Ends:</span><span class="mandatory">*</span> (min)<br />
                 <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_reg_ends" type="text" class="TextField" id="tournament_reg_ends" tabindex="12" maxlength="3" />
                  </label> <div id="lateRegisErr" style="display:none;"> <font color="#FF0000">Late Registration hours must be less than rebuy-blind increment time</font></div></td>
                <?php } ?>


                 <td id="no_need1" width="25%"></td>
                <td id="no_need2" width="25%"></td>
              </tr>
            </table>
            <script type="text/javascript">
					$(document).ready(function(){
						// find the input fields and apply the time select to them.
						$('#sample1 input').ptTimeSelect();
						$('#sample2 input').ptTimeSelect();
						//$('#sample3 input').ptTimeSelect();
					});
   			 </script>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Players</td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Players per table:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <select name="tournament_player_pertable" class="ListMenu" id="tournament_player_pertable" tabindex="13">
                    <!--<option <?php if($results->PLAYER_PER_TABLE == 2) echo 'selected="selected"'; ?> value="2">2</option>-->
                    <option <?php if($results->PLAYER_PER_TABLE == 6) echo 'selected="selected"'; ?> value="6">6</option>
                    <option <?php if($results->PLAYER_PER_TABLE == 9) echo 'selected="selected"'; ?> value="9">9</option>
                  </select>
                  </label>
                </td>
              </tr>
              <tr>
                <td width="25%"><span class="TextFieldHdr">Minimum:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_min_players" type="text" class="TextField" id="tournament_min_players" value="<?php echo $results->T_MIN_PLAYERS; ?>" tabindex="14" maxlength="6" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Maximum:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_max_players" type="text" class="TextField" id="tournament_max_players" value="<?php echo $results->T_MAX_PLAYERS; ?>" tabindex="15" maxlength="6" />
                  </label>
                </td>
                <td width="25%"></td>
                <td width="25%"></td>
              </tr>
            </table>
			<?php if($results->TOURNAMENT_STATUS == 1){
              $entryStyle  = 'style="display:none;"';
            }else{
              $entryStyle  = 'style="display:block;"';
            } ?>
            <div <?php echo $entryStyle; ?>>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Entry Criteria</td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="55%"><span class="TextFieldHdr">Cash Type:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                 <?php if(is_array($entryCriteria) && count($entryCriteria)){
				 foreach($entryCriteria as $entryCriteriaVal){
				   if($entryCriteriaVal->TOURNAMENT_ENTRY_CRITERIA_ID == 3){
				     $entryThisValue = 7;
				   }else if($entryCriteriaVal->TOURNAMENT_ENTRY_CRITERIA_ID == 4){
				     $entryThisValue = 6;
				   }else if($entryCriteriaVal->TOURNAMENT_ENTRY_CRITERIA_ID == 5){
				     $entryThisValue = 8;
				   }else{
				     $entryThisValue = $entryCriteriaVal->TOURNAMENT_ENTRY_CRITERIA_ID;
				   }

				   if($entryCriteriaVal->TOURNAMENT_ENTRY_CRITERIA_ID == 1){
				     $entryStyle = 'checked="checked"';
				   }else{
				      $entryStyle = '';
				   }

				   $entryThisName = $entryCriteriaVal->ENTRY_CRITERIA;
				 ?>
                 <label>
                  <input onclick="showLoyaltyFields(this.value);" name="tournament_cash_type" type="radio" id="tournament_cash_type" tabindex="16" value="<?php echo $entryThisValue; ?>" <?php if($results->COIN_TYPE_ID == $entryThisValue) echo 'checked="checked" '; ?> />
                  <?php echo $entryThisName; ?> &nbsp;&nbsp;&nbsp;</label>
                  <?php }
				  } ?>



                 <!-- <label>
                  <input <?php if($results->COIN_TYPE_ID == 1) echo 'checked="checked" '; ?> onclick="showLoyaltyFields(this.value);" name="tournament_cash_type" type="radio" id="tournament_cash_type" tabindex="16" value="1" />
                  Real Cash &nbsp;&nbsp;&nbsp;</label>
                  <label>
                  <input <?php if($results->COIN_TYPE_ID == 7) echo 'checked="checked" '; ?> onclick="showLoyaltyFields(this.value);" name="tournament_cash_type" type="radio"  id="tournament_cash_type" tabindex="17" value="7" />
                  Loyalty Points  &nbsp;&nbsp;&nbsp;</label>
                  <label>
                  <input <?php if($results->COIN_TYPE_ID == 2) echo 'checked="checked" '; ?> onclick="showLoyaltyFields(this.value);" name="tournament_cash_type" type="radio"  id="tournament_cash_type" tabindex="18" value="2" />
                  Play Money </label>
                  </label>-->
                </td>
              </tr>

               <tr id="balanceTypeValues"> <td width="55%"><span class="TextFieldHdr">Balance Type:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
               	<label><input type="checkbox" name="is_deposit_balance" id="is_deposit_balance" <?php if($results->DEPOSIT_BALANCE_ALLOW == 1) echo 'checked="checked"'; ?> > Deposit</lable> &nbsp;&nbsp;&nbsp;
               	<label><input type="checkbox" name="is_promo_balance" id="is_promo_balance" <?php if($results->PROMO_BALANCE_ALLOW == 1) echo 'checked="checked"'; ?>> Promo</lable>  &nbsp;&nbsp;&nbsp;
               	<label><input type="checkbox" name="is_win_balance" id="is_win_balance" <?php if($results->WIN_BALANCE_ALLOW == 1) echo 'checked="checked"'; ?>> Win</lable>
               </td>
              </tr>

            </table>
            <?php //if($results->COIN_TYPE_ID != 8){
			if($results->COIN_TYPE_ID == 8){
			   $amountFieldStyle = 'style="display:none;"';
			 }else{
			  $amountFieldStyle = 'style="display:block;"';
			}

			 ?>
            <table id="amountFields" width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo $results->BUYIN; ?>" onkeypress="return checkNumberKey(event)" onblur="assingToRebuyAmount(this.value);" name="tournament_amount" type="text" class="TextField" id="tournament_amount" tabindex="19" maxlength="8" />
                  </label>
                </td>
                <?php if($results->COIN_TYPE_ID != 7){ ?>
                <td id="commision_td"><span class="TextFieldHdr">Commission %:</span><br />
                  <label>
                  <input value="<?php echo str_replace(".00","",$results->TOURNAMENT_COMMISION); ?>" onkeypress="return checkNumberKey(event)" name="tournament_commision" type="text" class="TextField" id="tournament_commision" tabindex="20" maxlength="5" />
                  </label>
                </td>
                 <?php } ?>
                <td width="25%"></td>
                <td width="25%"></td>
              </tr>
            </table>
            <?php //} ?>
            <?php

			if($results->COIN_TYPE_ID == 7){
			  $loyalityStyle = 'style="display:block;"';
			}else{
			  $loyalityStyle = 'style="display:none;"';
			}
			?>

            <table id="loyalty_dates" <?php echo $loyalityStyle; ?> width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Start Date:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo $results->LAYALTY_ELIGIBILITY_START_DATE; ?>" name="loyalty_start_date" type="text" class="TextField" id="loyalty_start_date" tabindex="21" maxlength="50" readonly="readonly" />
                  </label>
                  <a onclick="NewCssCal('loyalty_start_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                <td width="25%"><span class="TextFieldHdr">End Date:</span><br />
                  <label>
                  <input value="<?php echo $results->LAYALTY_ELIGIBILITY_END_DATE; ?>" name="loyalty_end_date" type="text" class="TextField" id="loyalty_end_date" tabindex="22" maxlength="50" readonly="readonly" />
                  </label>
                  <a onclick="NewCssCal('loyalty_end_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                  <td width="15%"></td>
              </tr>
            </table>
           </div>


            <table width="100%" class="ContentHdr">
              <tr>
                <td>Blind Structure</td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Starting Blinds:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <select name="tournament_start_blinds" class="ListMenu" id="tournament_start_blinds" tabindex="23">
                    <?php foreach($blindStructure as $blinds){
						   $smallB = $blinds->SMALL_BLIND;
						   $bigB   = $blinds->BIG_BLIND;
						   $combainString = $smallB.'/'.$bigB;
						   $combainEditString = $results->SMALL_BLIND.'/'.$results->BIG_BLIND;
						  ?>
                    <option <?php if($combainEditString == $combainString) echo 'selected="selected"';?> value="<?php echo $blinds->TOURNAMENT_LEVEL; ?>"><?php echo $smallB.'/'.$bigB; ?></option>
                    <?php } ?>
                  </select>
                  </label>
                </td>
                <?php
				 //get tournament blind increment time
				 $blindIncrement = $this->tournament_model->getTournamentBlindIncrementTime($results->TOURNAMENT_ID);
				?>
                <td width="25%"><span class="TextFieldHdr">Binds Increment Time:</span>(min)<span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_bind_increment_time" type="text" class="TextField" id="tournament_bind_increment_time" tabindex="24" maxlength="2" value="<?php echo $blindIncrement;  ?>" />
                  </label>

                </td>
                <td width="25%"><span class="TextFieldHdr">Starting Chips Count:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo str_replace(".00","",$results->TOURNAMENT_CHIPS); ?>" onkeypress="return checkNumberKey(event)" name="tournament_start_chip_amount" type="text" class="TextField" id="tournament_start_chip_amount" tabindex="25" maxlength="8" onblur="assingToRebuy(this.value);" />
                  </label>
                </td>
                <td width="25%"></td>
              </tr>
            </table>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Time Settings</td>
              </tr>
            </table>

            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Turn Time: (sec)</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <input value="<?php echo $results->PLAYER_HAND_TIME; ?>" onkeypress="return checkNumberKey(event)" name="tournament_turn_time" type="text" class="TextField" id="tournament_turn_time" tabindex="26" maxlength="2" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Disconnect Time: (sec)</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo $results->DISCONNECT_TIME; ?>" onkeypress="return checkNumberKey(event)" name="tournament_discount_time" type="text" class="TextField" id="tournament_discount_time" tabindex="27" maxlength="2" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Extra Time: (sec)</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo $results->EXTRA_TIME; ?>" onkeypress="return checkNumberKey(event)" name="tournament_extra_time" type="text" class="TextField" id="tournament_extra_time" tabindex="28" maxlength="2" />
                  </label>
                </td>
                <td width="25%"></td>
              </tr>
              <tr>
            <td width="25%"><span class="TextFieldHdr">Extra Time: (Max Cap)</span>&nbsp;&nbsp;&nbsp;
              <label>
            <input onkeypress="return checkNumberKey(event)" name="tournament_max_cap" type="text" class="TextField" id="tournament_max_cap" tabindex="29" maxlength="2"  value="<?php echo $results->PLAYER_MAX_EXTRATIME;?>"/>
              </label>
            </td>
            <td width="25%"><span class="TextFieldHdr">Extra Time: (Blind Levels)</span>&nbsp;&nbsp;&nbsp;
              <label>
            <input onkeypress="return checkNumberKey(event)" name="tournament_blind_level" type="text" class="TextField" id="tournament_blind_level" tabindex="30" maxlength="2" value="<?php echo $results->ADDITIONAL_EXTRATIME_LEVEL_INTERVAL;?>" />
              </label>
            </td>
            <td width="25%"><span class="TextFieldHdr">Extra Time: (Add-on)</span>&nbsp;&nbsp;&nbsp;
              <label>
            <input onkeypress="return checkNumberKey(event)" name="tournament_add_on" type="text" class="TextField" id="tournament_add_on" tabindex="31" maxlength="2" value="<?php echo $results->ADDITIONAL_EXTRATIME;?>" />
              </label>
            </td>
           </tr>
          </table>
            <?php
			if($results->COIN_TYPE_ID == 7 || $results->COIN_TYPE_ID == 8 || $results->BUYIN == 0){
			  $rebuyChkBlockStyle = 'style="display:none;"';
			}else{
			  $rebuyChkBlockStyle = 'style="display:block;"';
			}
			?>
            <div id="rebuyChkBlock" <?php echo $rebuyChkBlockStyle; ?>>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Additional Features</td>
              </tr>
            </table>
			 <?php

             if($results->IS_REBUY == 1 && $results->IS_ADDON == 1){
                $rebuySettingStatus = 1;
                $rebuyBlock			 = 'display:block;';
				$addonBlock			 = 'display:block;';
				$double_rebuy_feature = 'display:block;';
				$rebuy_num_rebuy_val = '';
				$rebuy_eligible_chips_val = '';
             }else if($results->IS_REBUY == 1 && $results->IS_ADDON == 0){
			    $rebuySettingStatus = 2;
                $rebuyBlock			 = 'display:block;';
				$addonBlock			 = 'display:none;';
				$double_rebuy_feature = 'display:none;';
				//$rebuy_num_rebuy_val = 'disabled="disabled"';
				$rebuy_eligible_chips_val = 'disabled="disabled"';
			 }else{
               $rebuySettingStatus = 0;
                $rebuyBlock			 = 'display:none;';
				$addonBlock			 = 'display:none;';
				$double_rebuy_feature = 'display:block;';
				$rebuy_num_rebuy_val = '';
				$rebuy_eligible_chips_val = '';
             }
            ?>

            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%"><span class="TextFieldHdr">None</span>
                <label style="position: relative;left: -110px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="radio" class="TextField" value="0" id="rebuy_setting" tabindex="29" <?php if($rebuySettingStatus == 0 ) echo 'checked="checked"'; ?> />
                </label>
                </td>

                 <td width="30%"><span class="TextFieldHdr">Re - Buy & Addon Features:</span>
                <label style="position: relative; top: -15px; left: 46px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="radio" value="1" class="TextField" id="rebuy_setting" tabindex="29" <?php if($rebuySettingStatus == 1 ) echo 'checked="checked"'; ?> />
                </label>
                </td>

                 <td width="30%"><span class="TextFieldHdr">Re - Entry Tournament:</span>
                <label style="position: relative; top: -15px; left: 20px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="radio" value="2" class="TextField" id="rebuy_setting" tabindex="29" <?php if($rebuySettingStatus == 2 ) echo 'checked="checked"'; ?> />
                </label>
                </td>

                 <td id="no_need1" width="25%"></td>
                <td id="no_need2" width="25%"></td>
              </tr>
            </table>




            <!--<table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%"><span class="TextFieldHdr">Re - Buy & Addon Features:</span>
               <label style="position: relative; top: -15px; left: 16px;">

                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="checkbox" class="TextField" id="rebuy_setting" tabindex="29" <?php echo $rebuySettingString; ?> />
                </label>
                </td>

                 <td id="no_need1" width="25%"></td>
                <td id="no_need2" width="25%"></td>
              </tr>
            </table>-->
            </div>

            <div id="rebuy_setting_block" style="<?php echo $rebuyBlock; ?>">
   <table width="100%" class="ContentHdr">
              <tr>
                <td>Re-Buy Settings</td>
              </tr>
            </table>
   <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Chips to be granted:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <input value="<?php if($results->REBUY_CHIPS != 0) echo  str_replace(".00","",$results->REBUY_CHIPS); ?>" onkeypress="return checkNumberKey(event)" name="rebuy_chips_to_granted" type="text" class="TextField" id="rebuy_chips_to_granted" tabindex="30" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Player Max. Eligible Chips:</span><span class="mandatory">*</span><br />
                  <label>
                  <?php //echo $results->REBUY_ELIGIBLE_CHIPS; die; ?>
                  <input value="<?php if($results->REBUY_ELIGIBLE_CHIPS != 0)  echo  str_replace(".00","",$results->REBUY_ELIGIBLE_CHIPS); else echo 0; ?>" onkeypress="return checkNumberKey(event)" name="rebuy_eligible_chips" type="text" class="TextField" id="rebuy_eligible_chips" tabindex="31" <?php echo $rebuy_eligible_chips_val ; ?> />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Time Period: (Level)</span><span class="mandatory">*</span><br />
                  <label>
                   <select name="rebuy_timeperiod" class="ListMenu" id="rebuy_timeperiod" tabindex="32" >
                    <option value="">Select</option>
                    <?php foreach($blindStructure as $blinds){
						   $smallB = $blinds->SMALL_BLIND;
						   $bigB   = $blinds->BIG_BLIND;
						   $level  = $blinds->TOURNAMENT_LEVEL;
 						  ?>
                    <option <?php if($results->REBUY_END_TIME == $blinds->TOURNAMENT_LEVEL) echo 'selected="selected"';?> value="<?php echo $blinds->TOURNAMENT_LEVEL; ?>"><?php echo 'Level'.$level.' - '.$smallB.'/'.$bigB; ?></option>
                    <?php } ?>
                  </select>
                 <!-- <input value="<?php echo $results->REBUY_END_TIME; ?>" onkeypress="return checkNumberKey(event)" name="rebuy_timeperiod" type="text" class="TextField" id="rebuy_timeperiod" tabindex="32" />-->
                  </label>
                </td>
               <td width="25%"><span class="TextFieldHdr">Num. Of Re-Buy</span><span class="mandatory">*</span><br />
                  <label>

                  <select class="TextField" tabindex="33" name="rebuy_num_rebuy" id="rebuy_num_rebuy" <?php echo $rebuy_num_rebuy_val ; ?>>
                    <option <?php if($results->REBUY_COUNT == 9999) echo 'selected="selected"'; ?> value="9999">Unlimited</option>
                    <option <?php if($results->REBUY_COUNT == 1) echo 'selected="selected"'; ?> value="1">1</option>
                    <option <?php if($results->REBUY_COUNT == 2) echo 'selected="selected"'; ?> value="2">2</option>
                    <option <?php if($results->REBUY_COUNT == 3) echo 'selected="selected"'; ?> value="3">3</option>
                    <option <?php if($results->REBUY_COUNT == 4) echo 'selected="selected"'; ?> value="4">4</option>
                    <option <?php if($results->REBUY_COUNT == 5) echo 'selected="selected"'; ?> value="5">5</option>
                  </select>

                  </label>
                </td>
              </tr>
              <tr>
              <td width="25%"><span class="TextFieldHdr">Re-Buy Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php if($results->REBUY_IN != 0) echo  str_replace(".00","",$results->REBUY_IN); ?>" onkeypress="return checkNumberKey(event)" name="rebuy_amount" type="text" class="TextField" id="rebuy_amount" tabindex="34" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Entry Fee:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo  str_replace(".00","",$results->REBUY_ENTRY_FEE); ?>" onkeypress="return checkNumberKey(event)" name="rebuy_entryfee" type="text" class="TextField" id="rebuy_entryfee" tabindex="35" />
                  </label>
                </td>
                <td width="25%">

               <div id="double_rebuy_features" style="<?php echo $double_rebuy_feature;?>">
                  <span class="TextFieldHdr">Double Rebuy:</span><br />

                  <label>
                 <input <?php if($results->DOUBLE_REBUYIN > 0) echo 'checked="checked"'; ?> name="double_rebuy" type="checkbox" class="TextField" id="double_rebuy" tabindex="36" style="margin-top:-13px;"/>
                </label>
                </div>

                </td>
              </tr>
            </table>
 </div>
 			<div id="addon_setting_block" style="<?php echo $addonBlock; ?>">
  <table width="100%" class="ContentHdr">
              <tr>
                <td>Addon Settings</td>
              </tr>
            </table>
  <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Chips to be granted:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <input value="<?php if($results->ADDON_CHIPS != 0) echo str_replace(".00","",$results->ADDON_CHIPS); ?>" onkeypress="return checkNumberKey(event)" name="addon_chips_to_granted" type="text" class="TextField" id="addon_chips_to_granted" tabindex="36" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Addon Time Interval: (Minutes)</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="addon_timeperiod" value="<?php if($results->ADDON_BREAK_TIME != 0)  echo  str_replace(".00","",$results->ADDON_BREAK_TIME); ?>" type="text" class="TextField" id="addon_timeperiod" tabindex="37" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Addon Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" value="<?php if($results->ADDON_AMOUNT != 0)  echo  str_replace(".00","",$results->ADDON_AMOUNT); ?>" name="addon_amount" type="text" class="TextField" id="addon_amount" tabindex="37" />
                  </label>
                </td>
               <td width="25%"><span class="TextFieldHdr">Entry Fee:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" value="<?php echo  str_replace(".00","",$results->ADDON_ENTRY_FEE); ?>" name="addon_entryfee" type="text" class="TextField" id="addon_entryfee" tabindex="38" />
                  </label>
                </td>
              </tr>

            </table>
 </div>

            <script>
			var specialKeys = new Array();
			specialKeys.push(8); //Backspace
			specialKeys.push(9); //Tab
			specialKeys.push(46); //Delete
			specialKeys.push(36); //Home
			specialKeys.push(35); //End
			specialKeys.push(37); //Left
			specialKeys.push(39); //Right
			specialKeys.push(32); //Space Bar

			function IsAlphaNumericTextarea(e) {

				var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;

				var ret = ((keyCode == 32) || (keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
				document.getElementById("error").style.display = ret ? "none" : "inline";
				return ret;
			}
			</script>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Tournament Description</td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%">
                <label>
                 <textarea name="tournament_description" ondrop="return false;" onpaste="return false;" cols="250" rows="5" maxlength="75" class="TextField"><?php echo $results->TOURNAMENT_DESC; ?></textarea>
                </label>
                </td>


                <td id="no_need2" width="25%"><span id="error" style="color: Red; display: none">* Special Characters not allowed</span></td>
              </tr>
            </table>

            <table width="100%" class="ContentHdr">
              <tr>
                <td>Prize Structure</td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="25%"><span class="TextFieldHdr">Type:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                <?php
				 if(is_array($prizeStructure) && count($prizeStructure)){
				  foreach($prizeStructure as $prizeStructureVal){
				    ?>
                <label><input <?php if($results->PRIZE_STRUCTURE_ID == $prizeStructureVal->TOURNAMENT_PRIZE_STRUCTURES_ID)  echo 'checked="checked"';?> onclick="prizeStructure(this.value);" name="prize_type" id="prize_type" tabindex="29" type="radio" value="<?php echo $prizeStructureVal->TOURNAMENT_PRIZE_STRUCTURES_ID; ?>" /><?php echo $prizeStructureVal->PRIZE_STRUCTURE; ?> &nbsp;&nbsp;&nbsp;</label>
                <?php
				 }
				} ?>
              </td>
            </tr>
            <table>

            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                 <td width="25%"><span class="TextFieldHdr">Prize Type:</span><span class="mandatory">*</span><br />
                 <?php if($results->MASTER_ID=='0') { ?>
                 <div id="tournament_prize_normal" <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID!='') { ?> style="display:none;" <?php } ?>>
                  <label>
                  <select onchange="showTournamentTicket(this.value);" name="tournamet_prize_type" class="ListMenu" id="tournamet_prize_type" tabindex="31">
                    <?php
								foreach($prizeTypes as $prizeType){
								 if($prizeType->PRIZE_TYPE_ID != 8){
							?>
                    <option <?php if($results->PRIZE_TYPE == $prizeType->PRIZE_TYPE_ID) echo 'selected="selected"';?> value="<?php echo $prizeType->PRIZE_TYPE_ID;?>"><?php echo $prizeType->NAME;?></option>
                    <?php
					  }
					} ?>
                  </select>
                  </label>
                 </div>
                <div id="tournament_prize_satellite" <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID=='') { ?> style="display:none;" <?php } ?>>
                 <label>
                   <select name="tournament_prize_type_ticket" id="tournament_prize_type_ticket" class="ListMenu">
                   	<option value="8">Ticket</option>
                   </select>
                 </label>
                </div>
                <?php } else { ?><!--Recurrence Tournament-->
                  <label>
                  <select onchange="showTournamentTicket(this.value);" name="tournamet_prize_type" class="ListMenu" id="tournamet_prize_type" tabindex="31">
                    <?php
								foreach($prizeTypes as $prizeType){
								 if($prizeType->PRIZE_TYPE_ID != 8){
							?>
                    <option <?php if($results->PRIZE_TYPE == $prizeType->PRIZE_TYPE_ID) echo 'selected="selected"';?> value="<?php echo $prizeType->PRIZE_TYPE_ID;?>"><?php echo $prizeType->NAME;?></option>
                    <?php
					  }
					} ?>
                  </select>
                  </label>
                <?php } ?>
                </td>
                <td  width="25%"></td>
                <td  width="25%"></td>
                <td  width="25%"></td>
              </tr>
            </table>

            <table width="100%" cellspacing="10" cellpadding="10">
              <tbody><tr>
                <td width="55%"><span class="TextFieldHdr">Prize Balance Type:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;

                 <label>
                  <input type="radio" <?php if($results->PRIZE_BALANCE_TYPE == 3) echo 'checked="checked"'; ?>  value="3" tabindex="30" id="prize_balance_type" name="prize_balance_type" checked="checked">
                  Win &nbsp;&nbsp;&nbsp;</label>
                  <?php if($results->PRIZE_TYPE_ID != 6){ ?>
                 <label id="prize_balance_type_amt">
                  <input type="radio" <?php if($results->PRIZE_BALANCE_TYPE == 2) echo 'checked="checked"'; ?> value="2" tabindex="30" id="prize_balance_type" name="prize_balance_type">
                  Promo &nbsp;&nbsp;&nbsp;</label>
                  <?php } ?>

                                  </td>
              </tr>
            </tbody></table>

            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td id="tour_ticket" style="display:none;" width="25%"><span class="TextFieldHdr">Ticket:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_ticket" type="text" class="TextField" id="tournament_ticket" tabindex="32" maxlength="6" />
                  </label>
                </td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <?php if($results->PRIZE_STRUCTURE_ID == 1){
			    $prizeStructureStyle  = 'style="display:block;position: relative; left: -8px;"';
			   }else{
			    $prizeStructureStyle  = 'style="display:none;position: relative; left: -8px;"';
			   }
			   ?>
              <tr <?php echo $prizeStructureStyle; ?>  id="prize_field_1">
                <td width="25%"><span class="TextFieldHdr">No of places paid:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo $results->NO_OF_WINNERS; ?>" onblur="listWinnersBox(this.value);" onkeypress="return checkNumberKey(event)" name="tournament_places_paid" type="text" class="TextField" id="tournament_places_paid" tabindex="33" maxlength="4" />
                  </label>
                </td>

              </tr>
                  <tr>

               <td width="25%">
               <?php if($results->MASTER_ID=='0') { ?>
                <div id ="normal_prize_pool" <?php if($getTournamentType[0]->FK_PARENT_TOURNAMENT_ID!='') { ?> style="display:none;" <?php } ?>>
                 <span class="TextFieldHdr">Prize Pool: [Guarantee Prize]</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo str_replace(".00","",$results->GUARENTIED_PRIZE); ?>" onkeypress="return checkNumberKey(event)" name="tournament_prize_pool" type="text" class="TextField" id="tournament_prize_pool" tabindex="34" maxlength="8" />
                  </label>
                </div>
                <?php } else { ?>
                  <span class="TextFieldHdr">Prize Pool: [Guarantee Prize]</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="<?php echo str_replace(".00","",$results->GUARENTIED_PRIZE); ?>" onkeypress="return checkNumberKey(event)" name="tournament_prize_pool" type="text" class="TextField" id="tournament_prize_pool" tabindex="34" maxlength="8" />
                  </label>
                <?php } ?>
                </td>
                <td width="25%"></td>
                <td width="25%"></td>
                <td width="25%"></td>

              </tr>
            </table>
            <?php
			 if($results->FK_PARENT_TOURNAMENT_ID!='') {
					$winnerBoxStyle = 'style="display:none;"';
					$results->NO_OF_WINNERS = 0;
		  	 }
			 if($results->NO_OF_WINNERS > 0){
			   $winnerBoxStyle = 'style="display:block;"';
			   $numWinner = $results->NO_OF_WINNERS;
			 }else{
			   $winnerBoxStyle = 'style="display:none;"';
			 }
			?>
             <div id="winnerInstruction"></div>
            <div <?php echo $winnerBoxStyle; ?>  id="prize_additional_fields">
            <?php
			 if($results->PRIZE_STRUCTURE_ID == 1){
			if($results->NO_OF_WINNERS > 0){
				for($j=1;$j<=$numWinner;$j++){
				  //get percentage values
				  $pvalue  = $this->tournament_model->getWinnerPercentageByRank($j,$results->TOURNAMENT_ID);
				  if($pvalue != ''){

				?>
                    <table width="100%" style="position: relative; left: 10px;">
                      <tr>
                        <td width="25%"><label><?php echo $j; ?><input name="tournament_prize_<?php echo $j; ?>" type="text" class="TextField required" onkeypress="return checkNumberKey(event)" id="tournament_prize_<?php echo $j; ?>" tabindex="32" maxlength="5" value="<?php echo str_replace(".00","",$pvalue); ?>" /> (%)</label></td>
                       </tr>
                      <tr>
                        <td width="25%"></td>
                        <td width="25%"></td>
                        <td width="25%"></td>
                      </tr>
                    </table>
            <?php
			   }
			  }
			 }
			}  ?>
            </div>
            <table>
              <tr>
                <td><input type="hidden" name="task" value="edittournament">
                <input type="hidden" name="tournament_status" value="<?php echo $results->TOURNAMENT_STATUS; ?>">
                <input type="hidden" name="tournament_id" value="<?php echo $results->TOURNAMENT_ID; ?>">
                <input type="hidden" name="master_id" value="<?php echo  $results->MASTER_ID; ?>" />
                  <br />
                  <input name="submit" type="submit" onClick="return validate();" value="Update" tabindex="35">
                  &nbsp;
                 </form>

                  <form style="float:right;" action="<?php echo base_url();?>games/poker/tournament/edittournament?rid=44&start=1"  method="post" name="backtolist" id="backtolist" style="float:left">
            <input name="submit" type="submit" value="Cancel">
            </form>
                </td>
              </tr>
              <tr>
                <td width="40%"></td>
                <td width="40%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
              </tr>
            </table>
          </td>
      </tr>
    </table>
    </div>
  </div>
</div>
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>
