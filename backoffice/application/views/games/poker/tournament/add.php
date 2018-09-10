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

function showReBuyBlock_Old(str){
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
	   document.getElementById("winnerInstruction").innerHTML = '';
   }else if(str == 2){ // 2 MEANS DEFAULT PRIZE STRUCTURE
   	   document.getElementById("prize_field_1").style.display = "none";
	   document.getElementById("prize_additional_fields").style.display = "none";
	   $('#tournament_places_paid').val('');
	   document.getElementById("winnerInstruction").innerHTML = '';
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
	var tournament_type = $('#maingame_tournament_type').val();
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
   if(tournament_type!=2) {
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
	<?php if($isAllowed == 0){ ?>
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

	$.validator.addMethod("checkmaxvsminplayer", function (value, element) {
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
		 "maingame_tournament_type" : {
		 	required: true
		 },
		"tournamet_gamestatus": {
		    required: true
		},
		"tournamet_game_type": {
		    required: true
		},
    "tournament_server": {
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
		"main_tournament" : {
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
			checkmaxvsminplayer: true
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
		    required: true
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
		    required: true,
			digits: true
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
		"maingame_tournament_type" : {
			required: "Select Tournament Type"
		},
		"tournamet_gamestatus": {
		 required: "Select Game Status"
		},
		"tournamet_game_type": {
		 required: "Select Game Type"
		},
    "tournament_server": {
		 required: "Select Tournament Server"
		},

		"tournament_date": {
		required: "Enter Tournament Start Date"
		},
		"tournament_time": {
		required: "Enter Tournament Start Time"
		},
		"main_tournament" : {
			required : "Select Main Tournament"
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
		"tournament_bind_increment_time": {
		required: "Enter Blind Increment Time"
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
   alert(charCode);
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57) && (charCode >= 97 || charCode <= 122))
   	alert("tet");
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
				$('#main_tournament').hide();
				$('#normal_tournament_prize_structure').show();
				$('#satellite_tournament_prize_structure').hide();
				$('#tournament_places_paid').val('');
				$('#prize_pool_str').show();

			}else {
				$('#normal_tournament').hide();
				$('#satellite_tournament').show();
				$('#main_tournament').show();
				$('#normal_tournament_prize_structure').hide();
				$('#satellite_tournament_prize_structure').show();
				$('#tournament_places_paid').val('');
				$('#prize_pool_str').hide();
				$('#prize_additional_fields').hide();
				document.getElementById("winnerInstruction").innerHTML = '';

			}
	  });
  });
</script>
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


</style>
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
	.overlayApp{
	 overflow: hidden;
	 background: none repeat scroll 0px 0px rgb(238, 238, 238);
	 opacity: 0.40;
	}
</style>
    <?php if($isAllowed == 0){ ?>
    <div class="UpdateMsgWrap">
      <table width="100%" class="NoticeMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
          <td width="95%">Tournament Features Are Not Properly Assigned To Your Account. Please Contact Administrator.</td>
        </tr>
      </table>
    </div>
    <?php } ?>
    <?php

	 if($isAllowed == 0){
	  $overlayStyle = 'overlayApp';
	 }else{
	  $overlayStyle = '';
	 }

	   ?>
    <table width="100%" class="PageHdr">
      <tr>
        <td><strong>CREATE TOURNAMENT</strong>
          <table width="50%" align="right">
            <tr>
              <td><div align="right"><a href="#" class="dettxt">Tournament List</a></div></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <?php if($_GET['err']==1){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="SuccessMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
            <td width="95%">Tournament Added Successfully</td>
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
      <?php } ?>
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
                  <?php

				  foreach($getTournamentTypes as $tournamentType){ ?>
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
                  <input name="tournament_name" type="text" class="TextField" id="tournament_name" tabindex="3" maxlength="60" />
                  </label>
                </td>
                <td width="20%"><span class="TextFieldHdr">Tournament Type:</span><span class="mandatory">*</span><br />
                  <label>
                   <select name="maingame_tournament_type" class="ListMenu" id="maingame_tournament_type" tabindex="4">
                    <option value="">Select</option>
                    <option value="1">Normal</option>
                    <option value="2">Satellite</option>
                   </select>
                  </label>
                </td>
                <td width="20%"><span class="TextFieldHdr">Game Type:</span><span class="mandatory">*</span><br />
                  <label>
                   <div id="normal_tournament" style="display:block;">
                      <select name="tournamet_game_type" class="ListMenu" id="tournamet_game_type" tabindex="6">
                        <?php
                                foreach($getTournamentGameTypes as $gaIndex=>$gameType){
                                ?>
                        <option value="<?php echo $gameType->MINIGAMES_TYPE_ID;?>"><?php echo $gameType->GAME_DESCRIPTION;?></option>
                        <?php } ?>
                      </select>
                   </div>
                   <div id="satellite_tournament" style="display:none;">
                      <select name="satellite_tournament_game_type" class="ListMenu" id="satellite_tournament_game_type" tabindex="6">
                        <option value="1">Texas Hold'em</option>
                   		<option value="2">Omaha</option>
                        <option value="3">Texas Hold'em Event</option>
                        <option value="4">Omaha Event</option>
                      </select>
                   </div>
                  </label>
                </td>
                <td width="20%"><span class="TextFieldHdr">Status:</span><span class="mandatory">*</span><br />
                  <label>
                  <select name="tournamet_gamestatus" class="ListMenu" id="tournamet_gamestatus" tabindex="5">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                  </label>
                </td>
                <td width="20%"><span class="TextFieldHdr">Limit:</span><span class="mandatory">*</span><br />
                  <label>
                  <select name="tournamet_limit" class="ListMenu" id="tournamet_limit" tabindex="6">
                    <?php foreach($getTournamentLimits as $limits){ 	?>
                    <option value="<?php echo $limits->TOURNAMENT_LIMIT_ID; ?>"><?php echo $limits->DESCRIPTION; ?></option>
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
                  <option value="<?php echo $server->SERVER_ID; ?>"><?php echo $server->SERVER_NAME; ?></option>
                  <?php } ?>
                  </select>
                </label>
              </td>
              <td width="25%">
               <div id="main_tournament" style="display:none;">
              	 <label><span class="TextFieldHdr">Select Main Tournament:</span><span class="mandatory">*</span><br />
                 	 <select name="main_tournament" class="ListMenu" id="main_tournament" tabindex="7">
                     <option value="">Select</option>
                     <?php foreach($getMainTournamentTypes as $maintournament) { ?>
					 	 <option value="<?php echo $maintournament->TOURNAMENT_ID; ?>"><?php echo $maintournament->TOURNAMENT_NAME; ?></option>
					 <?php } ?>
                     </select>
                 </label>
               </div>
              </td>

            </tr>
            </table>
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Timings</td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
              <input type="hidden" id="currentDate" value="<?php echo date("Y-m-d"); ?>">
              <input type="hidden" id="currentTime" value="<?php echo date("H:i"); ?>">
                <td width="30%"><span class="TextFieldHdr">Registration Start Date:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_reg_start_date" type="text" class="TextField" id="tournament_reg_start_date" tabindex="9" maxlength="50" readonly="readonly" />
                  </label>
                  <a onclick="NewCssCal('tournament_reg_start_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                <td id="sample2" width="20%"><span class="TextFieldHdr">Registration Start Time:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_reg_start_time" type="text" class="TextField" id="tournament_reg_start_time" tabindex="10" maxlength="50" readonly="readonly" />
                  </label>
                </td>

                <td width="30%"><span class="TextFieldHdr">Tournament Start Date:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_date" type="text" class="TextField" id="tournament_date" tabindex="7" maxlength="50" readonly="readonly"/>
                  </label>
                  <a onclick="NewCssCal('tournament_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                <td id="sample1" width="20%"><span   class="TextFieldHdr">Tournament Start Time:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="tournament_time" type="text" class="TextField" id="tournament_time" tabindex="8" maxlength="50" readonly="readonly" />
                  </label>
                </td>

              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%"><span class="TextFieldHdr">Late Registration:</span><br />
                  <label>
                  <input onclick="showRegisterEnds(this.value);" name="tournament_late" type="checkbox" class="TextField" id="tournament_late" tabindex="11" maxlength="50" />
                  </label>
                </td>
                <td id="register_ends_status" style="display:none;" width="25%"><span class="TextFieldHdr">Registration Ends:</span><span class="mandatory">*</span> (min)<br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_reg_ends" type="text" class="TextField" id="tournament_reg_ends" tabindex="12" maxlength="3" />
                  </label><div id="lateRegisErr" style="display:none;"> <font color="#FF0000">Late Registration hours must be less than rebuy-blind increment time</font></div>
                </td>
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
                   <!-- <option value="2">2</option>-->
                    <option value="6">6</option>
                    <option value="9">9</option>
                  </select>
                  </label>
                </td>
              </tr>
              <tr>
                <td width="25%"><span class="TextFieldHdr">Minimum:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_min_players" type="text" class="TextField" id="tournament_min_players" value="" tabindex="14" maxlength="6" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Maximum:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_max_players" type="text" class="TextField" id="tournament_max_players" value="" tabindex="15" maxlength="6" />
                  </label>
                </td>
                <td width="25%"></td>
                <td width="25%"></td>
              </tr>
            </table>
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
                  <input onclick="showLoyaltyFields(this.value);" name="tournament_cash_type" type="radio" id="tournament_cash_type" tabindex="16" value="<?php echo $entryThisValue; ?>" <?php echo $entryStyle; ?> />
                  <?php echo $entryThisName; ?> &nbsp;&nbsp;&nbsp;</label>
                  <?php }
				  } ?>
                </td>
              </tr>
              <tr id="balanceTypeValues"> <td width="55%"><span class="TextFieldHdr">Balance Type:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp; <label><input type="checkbox" name="is_deposit_balance" id="is_deposit_balance" checked="checked"> Deposit</lable> &nbsp;&nbsp;&nbsp; <label><input type="checkbox" name="is_promo_balance" id="is_promo_balance"> Promo</lable>  &nbsp;&nbsp;&nbsp; <label><input type="checkbox" name="is_win_balance" id="is_win_balance" checked="checked"> Win</lable> </td>
              </tr>
              <tr id="balanceErr" style="display:none;"><td><font color="red">Please select balance type</font></td></tr>
            </table>
            <table id="amountFields" width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" onblur="assingToRebuyAmount(this.value);" name="tournament_amount" type="text" class="TextField" id="tournament_amount" tabindex="19" maxlength="8" />
                  </label>
                </td>
                <td id="commision_td"><span class="TextFieldHdr">Commission %:</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_commision" type="text" class="TextField" id="tournament_commision" tabindex="20" maxlength="5" />
                  </label>
                </td>
                <td width="25%"></td>
                <td width="25%"></td>
              </tr>
            </table>
            <table id="loyalty_dates" style="display:none;" width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Start Date:</span><span class="mandatory">*</span><br />
                  <label>
                  <input name="loyalty_start_date" type="text" class="TextField" id="loyalty_start_date" tabindex="21" maxlength="50" readonly="readonly" />
                  </label>
                  <a onclick="NewCssCal('loyalty_start_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                <td width="25%"><span class="TextFieldHdr">End Date:</span><br />
                  <label>
                  <input name="loyalty_end_date" type="text" class="TextField" id="loyalty_end_date" tabindex="22" maxlength="50" readonly="readonly" />
                  </label>
                  <a onclick="NewCssCal('loyalty_end_date','yyyymmdd','arrow',false,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> </td>
                  <td width="15%"></td>
              </tr>
            </table>
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
						  ?>
                    <option value="<?php echo $blinds->TOURNAMENT_LEVEL; ?>"><?php echo $smallB.'/'.$bigB; ?></option>
                    <?php } ?>
                  </select>
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Binds Increment Time:</span>(min)<span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_bind_increment_time" type="text" class="TextField" id="tournament_bind_increment_time" tabindex="24" maxlength="2" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Starting Chips Count:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" onblur="assingToRebuy(this.value);" name="tournament_start_chip_amount" type="text" class="TextField" id="tournament_start_chip_amount" tabindex="25" maxlength="8" />
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
                  <input onkeypress="return checkNumberKey(event)" name="tournament_turn_time" type="text" class="TextField" id="tournament_turn_time" tabindex="26" maxlength="2" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Disconnect Time: (sec)</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_discount_time" type="text" class="TextField" id="tournament_discount_time" tabindex="27" maxlength="2" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Extra Time: (sec)</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_extra_time" type="text" class="TextField" id="tournament_extra_time" tabindex="28" maxlength="2" />
                  </label>
                </td>
                <td width="25%"></td>
              </tr>
              <tr>
                <td width="25%"><span class="TextFieldHdr">Extra Time (Max Cap):(Sec) </span>&nbsp;&nbsp;&nbsp;
                  <label>
        		<input onkeypress="return checkNumberKey(event)" name="tournament_max_cap" type="text" class="TextField" id="tournament_max_cap" tabindex="29" maxlength="2" />
                  </label>
                 </td>
                 <td width="25%"><span class="TextFieldHdr">Extra Time (Blind Levels):</span>&nbsp;&nbsp;&nbsp;
                  <label>
        		<input onkeypress="return checkNumberKey(event)" name="tournament_blind_level" type="text" class="TextField" id="tournament_blind_level" tabindex="30" maxlength="2" />
                  </label>
                 </td>
                  <td width="25%"><span class="TextFieldHdr">Extra Time (Add-on): (Sec)</span>&nbsp;&nbsp;&nbsp;
                  <label>
        		<input onkeypress="return checkNumberKey(event)" name="tournament_add_on" type="text" class="TextField" id="tournament_add_on" tabindex="31" maxlength="2" />
                  </label>
                 </td>
              </tr>
            </table>
             <div id="rebuyChkBlock">
            <table width="100%" class="ContentHdr">
              <tr>
                <td>Additional Features</td>
              </tr>
            </table>
            <!--<table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%"><span class="TextFieldHdr">Re - Buy & Addon Features:</span>
                <label style="position: relative; top: -15px; left: 16px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="checkbox" class="TextField" id="rebuy_setting" tabindex="29" />
                </label>
                </td>

                 <td id="no_need1" width="25%"></td>
                <td id="no_need2" width="25%"></td>
              </tr>
            </table>-->
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="30%"><span class="TextFieldHdr">None</span>
                <label style="position: relative;left: -110px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="radio" class="TextField" value="0" id="rebuy_setting" tabindex="29" checked="checked" />
                </label>
                </td>

                 <td width="30%"><span class="TextFieldHdr">Re - Buy & Addon Features:</span>
                <label style="position: relative; top: -15px; left: 46px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="radio" value="1" class="TextField" id="rebuy_setting" tabindex="29" />
                </label>
                </td>

                 <td width="30%"><span class="TextFieldHdr">Re - Entry Tournament:</span>
                <label style="position: relative; top: -15px; left: 20px;">
                 <input onclick="showReBuyBlock(this.value);" name="rebuy_setting" type="radio" value="2" class="TextField" id="rebuy_setting" tabindex="29" />
                </label>
                </td>

                 <td id="no_need1" width="25%"></td>
                <td id="no_need2" width="25%"></td>
              </tr>
            </table>

           </div>
              <div id="rebuy_setting_block" style="display:none;">
            	<table width="100%" class="ContentHdr">
              <tr>
                <td>Re-Buy Settings</td>
              </tr>
            </table>
            	<table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Chips to be granted:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <input value="" onkeypress="return checkNumberKey(event)" name="rebuy_chips_to_granted" type="text" class="TextField" id="rebuy_chips_to_granted" tabindex="30" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Player Max. Eligible Chips:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="rebuy_eligible_chips" type="text" class="TextField" id="rebuy_eligible_chips" tabindex="31" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Time Period: (Level)</span><span class="mandatory">*</span><br />
                  <label>

                   <select name="rebuy_timeperiod" class="ListMenu" id="rebuy_timeperiod" tabindex="32">
                   <option value="">Select</option>
                   <?php foreach($blindStructure as $blinds){
						   $smallB = $blinds->SMALL_BLIND;
						   $bigB   = $blinds->BIG_BLIND;
						   $level  = $blinds->TOURNAMENT_LEVEL;
 						  ?>
                    <option value="<?php echo $blinds->TOURNAMENT_LEVEL; ?>"><?php echo 'Level'.$level.' - '.$smallB.'/'.$bigB; ?></option>
                    <?php } ?>
                  </select>
                 <!-- <input onkeypress="return checkNumberKey(event)" name="rebuy_timeperiod" type="text" class="TextField" id="rebuy_timeperiod" value="0" tabindex="32" />-->
                  </label>
                </td>
               <td width="25%"><span class="TextFieldHdr">Num. Of Re-Buy</span><span class="mandatory">*</span><br />
                  <label>
                  <select class="TextField" tabindex="33" name="rebuy_num_rebuy" id="rebuy_num_rebuy">
                    <option value="9999">Unlimited</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>

                  </label>
                </td>
              </tr>
              <tr>
              <td width="25%"><span class="TextFieldHdr">Re-Buy Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="" onkeypress="return checkNumberKey(event)" name="rebuy_amount" type="text" class="TextField" id="rebuy_amount" tabindex="34" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Entry Fee:</span><span class="mandatory">*</span><br />
                  <label>
                  <input value="0" onkeypress="return checkNumberKey(event)" name="rebuy_entryfee" type="text" class="TextField" id="rebuy_entryfee" tabindex="35" />
                  </label>
                </td>
                <td width="25%">
                 <div id="double_rebuy_features" style="display:block;">
                  <span class="TextFieldHdr">Double Rebuy:</span>
                  <label>
                  	<input name="double_rebuy" type="checkbox" class="TextField" id="double_rebuy" tabindex="36" style="margin-top:-13px;"/>
                  </label>
                 </div>
               </td>
              </tr>
            </table>
            <!--	<table width="100%" class="ContentHdr">
              <tr>
                <td>Addon Settings</td>
              </tr>
            </table>
            	<table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Chips to be granted:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <input value="" onkeypress="return checkNumberKey(event)" name="addon_chips_to_granted" type="text" class="TextField" id="addon_chips_to_granted" tabindex="36" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Addon Time Interval: (Minutes)</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="addon_timeperiod" type="text" class="TextField" id="addon_timeperiod" value="" tabindex="37" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Addon Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" value="" name="addon_amount" type="text" class="TextField" id="addon_amount" tabindex="37" />
                  </label>
                </td>
               <td width="25%"><span class="TextFieldHdr">Entry Fee:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" value="0" name="addon_entryfee" type="text" class="TextField" id="addon_entryfee" tabindex="38" />
                  </label>
                </td>
              </tr>

            </table>-->
            </div>

               <div id="addon_setting_block" style="display:none;">
            	<table width="100%" class="ContentHdr">
              <tr>
                <td>Addon Settings</td>
              </tr>
            </table>
            	<table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="25%"><span class="TextFieldHdr">Chips to be granted:</span><span class="mandatory">*</span> &nbsp;&nbsp;&nbsp;
                  <label>
                  <input value="" onkeypress="return checkNumberKey(event)" name="addon_chips_to_granted" type="text" class="TextField" id="addon_chips_to_granted" tabindex="36" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Addon Time Interval: (Minutes)</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="addon_timeperiod" type="text" class="TextField" id="addon_timeperiod" value="" tabindex="37" />
                  </label>
                </td>
                <td width="25%"><span class="TextFieldHdr">Addon Amount:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" value="" name="addon_amount" type="text" class="TextField" id="addon_amount" tabindex="37" />
                  </label>
                </td>
               <td width="25%"><span class="TextFieldHdr">Entry Fee:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" value="0" name="addon_entryfee" type="text" class="TextField" id="addon_entryfee" tabindex="38" />
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
                 <textarea name="tournament_description" ondrop="return false;" onpaste="return false;" cols="250" rows="5" maxlength="75" class="TextField"></textarea>
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
                <label><input onclick="prizeStructure(this.value);" id="prize_type" name="prize_type" tabindex="39" type="radio" value="<?php echo $prizeStructureVal->TOURNAMENT_PRIZE_STRUCTURES_ID; ?>" <?php if($prizeStructureVal->TOURNAMENT_PRIZE_STRUCTURES_ID == 2) echo 'checked="checked"'; ?>/><?php echo $prizeStructureVal->PRIZE_STRUCTURE; ?> &nbsp;&nbsp;&nbsp;</label>
                <?php
				 }
				} ?>
              </td>
            </tr>
            <table>



            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                 <td width="25%"><span class="TextFieldHdr">Prize Type:</span><span class="mandatory">*</span><br />
                  <label>
                  <div id="normal_tournament_prize_structure" style="display:block;">
                  <select onchange="showTournamentTicket(this.value);" name="tournamet_prize_type" class="ListMenu" id="tournamet_prize_type" tabindex="40">
                    <?php
								foreach($prizeTypes as $prizeType){
								 if($prizeType->PRIZE_TYPE_ID != 8){
							?>
                    <option value="<?php echo $prizeType->PRIZE_TYPE_ID;?>"><?php echo $prizeType->NAME;?></option>
                    <?php
					  }
					} ?>
                  </select>
                  </div>
                  <div id="satellite_tournament_prize_structure" style="display:none;">
                    <select name="tournament_prize_type_ticket" id="tournament_prize_type_ticket" class="ListMenu">
                      <option value="8">Ticket</option>
                    </select>
                   </div>
                  </label>
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
                  <input type="radio" checked="checked" value="3" tabindex="30" id="prize_balance_type" name="prize_balance_type" checked="checked">
                  Win &nbsp;&nbsp;&nbsp;</label>

                 <label id="prize_balance_type_amt">
                  <input type="radio" value="2" tabindex="41" id="prize_balance_type" name="prize_balance_type">
                  Promo &nbsp;&nbsp;&nbsp;</label>


                                  </td>
              </tr>
            </tbody></table>

            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td id="tour_ticket" style="display:none;" width="25%"><span class="TextFieldHdr">Ticket:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_ticket" type="text" class="TextField" id="tournament_ticket" tabindex="42" maxlength="6" />
                  </label>
                </td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr style="display:none;position: relative; left: -8px;" id="prize_field_1">
                <td width="25%"><span class="TextFieldHdr">No of places paid:</span><span class="mandatory">*</span><br />
                  <label>
                  <input onblur="listWinnersBox(this.value);" onkeypress="return checkNumberKey(event)" name="tournament_places_paid" type="text" class="TextField" id="tournament_places_paid" tabindex="43" maxlength="4" />
                  </label>
                </td>

              </tr>
                  <tr>
            <td width="25%">
               <div id="prize_pool_str" style="display:block;">
                 <span class="TextFieldHdr">Prize Pool: [Guarantee Prize]</span><span class="mandatory">*</span><br />
                  <label>
                  <input onkeypress="return checkNumberKey(event)" name="tournament_prize_pool" type="text" class="TextField" id="tournament_prize_pool" tabindex="44" maxlength="8" />
                  </label>
                </div>
                </td>
                <td width="25%"></td>
                <td width="25%"></td>
                <td width="25%"></td>

              </tr>
            </table>
            <div id="winnerInstruction"></div>
            <div style="display:none;" id="prize_additional_fields"></div>
            <table>
              <tr>
                <td><input type="hidden" name="task" value="createtournament">
                  <br />
                  <input name="submit" type="submit" onClick="return validate();" value="Create" tabindex="45">
                  &nbsp;
                  <input name="submit" type="reset" value="Reset" tabindex="46">
                </td>
              </tr>
              <tr>
                <td width="40%"></td>
                <td width="40%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
              </tr>
            </table>
          </form></td>
      </tr>
    </table>
    </div>
  </div>
</div>
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>
