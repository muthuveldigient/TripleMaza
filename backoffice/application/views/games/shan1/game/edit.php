<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>

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
    left: -8px;
    margin-top: -5px;
    padding: 0 14px;
    position: relative;
    top: 3px;
}
</style>    
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function showStuff(id, text) {
	if(document.getElementById("IS_ACTIVE").checked == true){
		document.getElementById("START_DATE_TIME").value="";
		document.getElementById("END_DATE_TIME").value="";
		document.getElementById(id).style.visibility="hidden";
		document.getElementById(text).style.visibility="visible";
    	//btn.style.display = 'block';
	}else{
    	document.getElementById(id).style.visibility="visible";
    	document.getElementById(text).style.display = 'none';
    	//btn.style.display = 'none';
	}
}

function chkdatevalue(){
if(trim(document.tsearchform.START_DATE_TIME.value)!='' || trim(document.tsearchform.END_DATE_TIME.value)!=''){ 
	if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false){
        alert("Please enter the valid date");
        return false;
    }else{
        if(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')=="1"){
	        alert("Start date should be greater than end date");
    	    return false;
        }
        return true;
    }
   } 
}
</script>
<script language="javascript" type="text/javascript"> 
/* function calmaxbuy(){
	if(document.getElementById("BANKER").value){
		document.getElementById("MINBUYIN").value = '';
		document.getElementById("MAXBUYIN").value = '';
		document.getElementById("MIN_BET").value = '';
		document.getElementById("MAX_BET").value = '';
	}
}

$(document).ready(function(){
	$.validator.addMethod("maxplayercheck", function (value, element) {
        return value <= ($("#MAX_PLAYERS").val());
    }, 'Min players should be lesser than max players');
	
	$.validator.addMethod("minplayercheck", function (value, element) {
        return value >= ($("#MIN_PLAYERS").val());
    }, 'Max players should be greater than min players');	
	
	$.validator.addMethod("playercheck", function (value, element) {
       	return value >= ($("#maxplayers").val());
    }, 'Players should be greater than or equal to min players');
	
	$.validator.addMethod("playerchecked", function (value, element) {
       	return value <= ($("#minplayers").val());
    }, 'Players should be lesser than or equal to max players');		
	
	$.validator.addMethod("minbuycheck", function (value, element) {
		var bank = document.getElementById("BANKER").value;
		//document.getElementById("max_buyin").value = '';
		var minbuyamt = bank * 5;
       	return value >= minbuyamt;
    }, 'Min-Buyin amount should be 5 times greater than Banker Amount');
	
	$.validator.addMethod("maxbuycheck", function (value, element) {
		var minbuy = document.getElementById("MINBUYIN").value;
		var maxbuyamt = minbuy * 10;
       	return value >= maxbuyamt;
    }, 'Max-Buyin amount should be 10 times greater than Min-Buyin Amount');		
	
	$.validator.addMethod("minbetcheck", function (value, element) {
		var bank = document.getElementById("BANKER").value;
		var minbetamt = bank / 10;
       	return value >= minbetamt;
    }, 'Min-Bet amount should be greater than 10% of Banker Amount');
	
	$.validator.addMethod("minbetvalcheck", function (value, element) {
		var bank = document.getElementById("BANKER").value;
		var minbetval = bank / 2;
       	return value <= minbetval;
    }, 'Min-Bet amount should be lesser than 50% of Banker Amount');	
	
	$.validator.addMethod("maxbetcheck", function (value, element) {
		var banker = document.getElementById("BANKER").value;
		var maxbetamt = banker * 10;
       	return value >= maxbetamt;
    }, 'Max-Bet amount should be 10 times greater than Banker Amount');	
	
	$('#gameForm').validate({
		rules: {
		"GAME_NAME": {
			required: true
		 },
		"BANKER": {
			required: true
		},
		"MIN_PLAYERS": {
			maxplayercheck: true
		},
		"MAX_PLAYERS": {
			minplayercheck: true
		},		
		"MINBUYIN": {
			required: true,
			minbuycheck: true
		},
		"MAXBUYIN": {
			required: true,
			maxbuycheck: true
		},
		"MIN_BET": {
			required: true,
			minbetcheck: true,
			minbetvalcheck: true
		},
		"MAX_BET": {
			required: true,
			maxbetcheck: true
		},		
		"RAKE": {
			required: true,
			number: true,
			rangelength: [0,99]
		}
  	},
	messages: {
    	"GAME_NAME": {
			required:"Enter game name"
		},
		"BANKER": {
			required:"Enter Banker value"
		},
		"MINBUYIN": {
			required: "Enter Minimum Buy-in"
		},
		"MAXBUYIN": {
			required: "Enter Maximum Buy-in"
		},
		"MIN_BET": {
			required: "Enter Minimum bet"
		},
		"MAX_BET": {
			required: "Enter Maximum bet"
		},		
		"RAKE": {
			required: "Enter rake percentage",
			number: "Rake must contain numbers only",
			rangelength: "Rake must have between 1 to 99"
		}
    }
	
 });
}); */// end document.ready

function checkNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
   	return false;
	
   return true;
}
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<table width="100%" class="PageHdr">
  <tr>
    <td><strong>Edit GAME</strong>
      <table width="50%" align="right">
        <tr>
          <td><div align="right"><a href="<?php echo base_url();?>games/game?rid=41" class="dettxt">Games List</a></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php 
  if($_REQUEST['err'] == '1'){  ?>
	 <div class="UpdateMsgWrap">
	  <table width="100%" class="SuccessMsg">
		<tr>
		  <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
		  <td width="95%"><?php echo "Game Updated Successfully"; ?>!!!</td>
		  </tr>
	  </table>
	</div>
<?php } 
	if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } 	
	  if(isset($_REQUEST['err']) && $_REQUEST['err']!="1"){ ?>
      <div class="UpdateMsgWrap">
       <table width="100%" class="ErrorMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
          <td width="95%">
			<?PHP 
			if($_GET['err']==2) { 
             	echo 'Mandatory fields required';
            }   
			if($_GET['err']==3) { 
             	echo 'Minimum (Buy-in) should be five times greater than Banker Amount';
            } 
            if($_GET['err']==4) { 
				echo 'Maximum (Buy-in) should be ten times greater than Min Buy-in';
            }  
			if($_GET['err']==5) { 
				echo 'Please try again';
            }
			if($_GET['err']==6) { 
				echo 'Maximum player should be greater than or equal to Minimum player';
            }
			if($_GET['err']==7) { 
				echo 'Minimum player should be lesser than or equal to Maximum player';
            }	
			if($_GET['err']==8) { 
				echo 'Minimum bet should be greater than or equal 10% of Banker Amount';
            }
			if($_GET['err']==9) { 
				echo 'Minimum bet should be lesser than or equal 50% of Banker Amount';
            }				
			if($_GET['err']==10) { 
				echo 'Maximum bet should be ten times greater than  Banker Amount';
            }
			if($_GET['err']==11) { 
				echo 'Banker Minimum Deposit Amount is 100';
            }
			if($_GET['err']==12) { 
				echo 'Tournament Type Required';
            }					?>
        </td>
        
        </tr>
        
      </table>
      </div>
      <?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
  <tr>
    <td><table width="100%" class="ContentHdr">
        <tr>
          <td>Game Information</td>
        </tr>
      </table>
      <form method="post" name="gameForm" id="gameForm">
       <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
            <td width="40%"><span class="TextFieldHdr">Game Name:</span><span class="mandatory">*</span><br />
            <label>
            <input name="GAME_NAME" type="text" class="TextField" id="GAME_NAME" readonly="readonly" value="<?php echo $results->GAME_NAME; ?>" tabindex="1" maxlength="50" />
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Banker:</span><span class="mandatory">*</span><br />
            <label>
            <input name="BANKER" type="text" class="TextField" id="BANKER" readonly="readonly" value="<?php echo $results->BANKER; ?>" tabindex="1" maxlength="10" onkeypress="return checkNumberKey(event)"  onkeydown="calmaxbuy()" onkeyup="calmaxbuy()" onblur="calmaxbuy()"/>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Currency Type:</span><span class="mandatory">*</span><br />
            <label>
            <select name="CURRENCY_SYMBOL" class="ListMenu" id="CURRENCY_SYMBOL" onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;" tabindex="3">
                <?php foreach($coinTypes as $coinTypes){ ?>
                <option <?php if($results->CURRENCY_SYMBOL == $coinTypes->COIN_TYPE_ID){ echo 'selected="selected"'; } ?> value="<?php echo $coinTypes->COIN_TYPE_ID; ?>" ><?php echo $coinTypes->NAME; ?></option>
              <?php } ?>            
            </select>
            </label></td>
        </tr>
        
        <tr>
            <td width="40%"><span class="TextFieldHdr">Minimum Players:</span><span class="mandatory">*</span><br />
            <label>
           <select name="MIN_PLAYERS" class="ListMenu" id="MIN_PLAYERS" onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;" tabindex="4">
              <option <?php if($results->MIN_PLAYERS == 2) echo 'selected="selected"'; ?> value="2">2</option>
              <!--<option <?php if($results->MIN_PLAYERS == 3) echo 'selected="selected"'; ?> value="3">3</option>
              <option <?php if($results->MIN_PLAYERS == 4) echo 'selected="selected"'; ?> value="4">4</option>
              <option <?php if($results->MIN_PLAYERS == 5) echo 'selected="selected"'; ?> value="5">5</option>
              <option <?php if($results->MIN_PLAYERS == 6) echo 'selected="selected"'; ?> value="6">6</option>
              <option <?php if($results->MIN_PLAYERS == 7) echo 'selected="selected"'; ?> value="7">7</option>
              <option <?php if($results->MIN_PLAYERS == 8) echo 'selected="selected"'; ?> value="8">8</option>-->
            </select>
            </label></td>            
            
          <td width="40%"><span class="TextFieldHdr">Maximum Players:</span><span class="mandatory">*</span><br />
            <label>
           <select name="MAX_PLAYERS" class="ListMenu" id="MAX_PLAYERS" onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;" tabindex="5">
              <!--<option <?php if($results->MAX_PLAYERS == 2) echo 'selected="selected"'; ?> value="2">2</option>
              <option <?php if($results->MAX_PLAYERS == 3) echo 'selected="selected"'; ?> value="3">3</option>
              <option <?php if($results->MAX_PLAYERS == 4) echo 'selected="selected"'; ?> value="4">4</option>
              <option <?php if($results->MAX_PLAYERS == 5) echo 'selected="selected"'; ?> value="5">5</option>
              <option <?php if($results->MAX_PLAYERS == 7) echo 'selected="selected"'; ?> value="7">7</option>-->
              <option <?php if($results->MAX_PLAYERS == 6) echo 'selected="selected"'; ?> value="6">6</option>              
              <option <?php if($results->MAX_PLAYERS == 8) echo 'selected="selected"'; ?> value="8">8</option>
            </select>
             </label></td>
        
          <td width="40%"><span class="TextFieldHdr">Tournament Type:</span><span class="mandatory">*</span><br />
            <label>
           <select name="TOUR_TYPE" class="ListMenu" id="TOUR_TYPE" onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;" tabindex="5">
              <option <?php if($results->TOURNAMENT_TYPE == 1) echo 'selected="selected"'; ?> value="1">Web</option>
              <option <?php if($results->TOURNAMENT_TYPE == 2) echo 'selected="selected"'; ?> value="2">Mobile</option>
              <option <?php if($results->TOURNAMENT_TYPE == 3) echo 'selected="selected"'; ?> value="3">Web & Mobile</option>
            </select>
             </label></td>
        </tr>
                
        <tr>
          <td width="40%"><span class="TextFieldHdr">Minimum (Buy-in):</span><span class="mandatory">*</span><br />
            <label>
            <input name="MINBUYIN" type="text" class="TextField" id="MINBUYIN" readonly="readonly" value="<?php echo $results->MINBUYIN; ?>" maxlength="10" tabindex="9" onkeypress="return checkNumberKey(event)"/>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Maximum (Buy-in):</span><span class="mandatory">*</span><br />
            <label>
            <input name="MAXBUYIN" type="text" class="TextField" id="MAXBUYIN" readonly="readonly" value="<?php echo $results->MAXBUYIN; ?>" maxlength="10" tabindex="10"  />
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Rake:</span><span class="mandatory">*</span><br />
            <label>
            <input name="RAKE" type="text" class="TextField" id="RAKE" readonly="readonly" value="<?php echo $results->RAKE; ?>" maxlength="5" tabindex="12" onkeypress="return checkNumberKey(event)" />
            </label></td>   
        </tr>
        
        <tr>
          <td width="40%"><span class="TextFieldHdr">Minimum Bet:</span><span class="mandatory">*</span><br />
            <label>
            <input name="MIN_BET" type="text" class="TextField" id="MIN_BET" readonly="readonly" value="<?php echo $results->MIN_BET; ?>" maxlength="10" tabindex="9" onkeypress="return checkNumberKey(event)"/>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Maximum Bet:</span><span class="mandatory">*</span><br />
            <label>
            <input name="MAX_BET" type="text" class="TextField" id="MAX_BET" readonly="readonly" value="<?php echo $results->MAX_BET; ?>" maxlength="10" tabindex="10"  />
            </label></td>
            <?php if($results->IS_ACTIVE!='2'){ ?>   
        	<td><span class="TextFieldHdr">Status:</span><span class="mandatory">*</span><br/>
           <select name="IS_ACTIVE" class="ListMenu" id="IS_ACTIVE" tabindex="4">
              <option <?php if($results->IS_ACTIVE == '0') echo 'selected="selected"'; ?> value="0">INACTIVE</option>
              <option <?php if($results->IS_ACTIVE == '1') echo 'selected="selected"'; ?> value="1">ACTIVE</option>
            </select>                
            </td>
            <?php } ?>                     
        </tr>

         <input type="hidden" name="task" value="creategame">
        <tr>
          <td><input name="submit" type="submit" onClick="return validate();" value="Update" style="float:left"></form>
            &nbsp;
            <form action="<?php echo base_url();?>games/game/listgame?rid=42"  method="post" name="backtolist" id="backtolist" style="float:left">	
            <input name="submit" type="button" value="Cancel"  style="float:left;margin-left:5px;" onclick="javascript:history.back(-1);">
            </form>
            </td>
        </tr>
        <tr>
          <td width="40%"></td>
          <td width="40%">&nbsp;</td>
          <td width="40%">&nbsp;</td>
        </tr>
      </table>
     </form>
     </tr>
</table>
</div>
</div>
<?php $this->load->view("common/footer"); ?>