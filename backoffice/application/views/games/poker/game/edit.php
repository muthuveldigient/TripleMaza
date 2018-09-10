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
<script language="javascript" type="text/javascript"> 
function calbigblind(){
	if(document.getElementById("small_blind").value){
	var smallblind=document.getElementById("small_blind").value;
	var bigblind=smallblind*2;
	document.getElementById("big_blind").value=bigblind;
	}else{
	document.getElementById("big_blind").value='';
	}
	
}

$(document).ready(function(){
	$.validator.addMethod("minbuyinCheck", function (value, element) {
        return value >= ($("#small_blind").val()*10);
    }, 'Min buy-in should be ten times greater than small blind');
	$.validator.addMethod("maxbuyinCheck", function (value, element) {
        return value >= ($("#big_blind").val()*10);
    }, 'Max buy-in should be ten times greater than big blind');
	$('#gameForm').validate({
		rules: {
		"game_name": {
			required: true,
			minlength:4
		 },
		"game_type": {
			required: true
		 },	
		"currency_type": {
		    required: true
		},
		"small_blind": {
			required: true,
			digits: true
		},
		"min_buyin": {
			required: true,
			digits: true,
			minbuyinCheck: true
		},
		"max_buyin": {
			required: true,
			digits: true,
			maxbuyinCheck: true
		},
		"rake": {
			required: true,
			number: true,
			rangelength: [0,99]
		},
		"rake1": {
			required: true,
			number: true,
			rangelength: [0,99]
		},			
		"rake_cap": {
			number: {
				depends: function(element){ //Missing colon here and no opening braces required
					return ($('#rake_cap').val().length > 0); 
     			}					
			}
		},
		"rake_cap1": {
			number: {
				depends: function(element){ //Missing colon here and no opening braces required
					return ($('#rake_cap1').val().length > 0); 
     			}					
			}
		}				
  	},
	messages: {
    	"game_name": {
			required:"Enter game name"
		},
		"game_type": {
			required:"Select game type"
		},	
		"currency_type": {
			required:"Select currency type"
		},
		"small_blind": {
		 required: "Enter small blind",
		 digits: "Small bind must contain numbers only"	 
		},
		"min_buyin": {
		required: "Enter minimum (Buy-in)",
		 digits: "Minimum (Buy-in) must contain numbers only"
		},
		"max_buyin": {
		required: "Enter maximum (Buy-in)",
		digits: "Maximum (buy-in) must contain numbers only"
		},
		"rake": {
		required: "Enter rake percentage",
		number: "Rake must contain numbers only",
		rangelength: "Rake must have between 1 to 99"
		},
		"rake1": {
		required: "Enter rake headsup percentage",
		number: "Rake headsup must contain numbers only",
		rangelength: "Rake heads up must have between 1 to 99"
		},		
		"rake_cap": {
			number: "Rake cap must contain numbers only"
		},
		"rake_cap1": {
			number: "Rake cap must contain numbers only"
		}		
    }
	
 });
}); // end document.ready
</script>
<?php
//print_r($results);
//echo $results->MINI_GAME_TYPE_ID;
//print_r($gameTypes);
?>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<table width="100%" class="PageHdr">
  <tr>
    <td><strong>Edit GAME</strong>
      <table width="50%" align="right">
        <tr>
          <td><div align="right"><a href="<?php echo base_url();?>games/poker/game?rid=51" class="dettxt">Games List</a></div></td>
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
<?php } ?>
      <?php if(isset($_REQUEST['errmsg'])){ echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>
 <?php if(isset($_REQUEST['err']) && $_REQUEST['err']!="1"){ ?>
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
             	echo 'Big blind should be greater than small blind';
            } 
            if($_GET['err']==4) { 
				echo 'Maximum (Buy-in) should be ten times greater than Big blind';
            }  
			if($_GET['err']==5) { 
				echo 'Please try again';
            }  
			?>
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
          <td width="40%"><span class="TextFieldHdr">Game Name:</span><br />
            <label>
            <input type="hidden" name="tournament_id" id="tournament_id" value="<?php echo $results->TOURNAMENT_ID; ?>"  />
            <input type="hidden" name="game_name" id="game_name" value="<?php echo $results->TOURNAMENT_NAME; ?>"  />
            <input name="game_name" type="text" class="TextField" maxlength="30" id="game_name" value="<?php echo $results->TOURNAMENT_NAME; ?>" tabindex="1" />
            <span class="mandatory">*</span></label></td>
          <td width="40%"><span class="TextFieldHdr">Game Type:</span><br />
        
            <label>
            <select name="game_type" class="ListMenu" id="game_type" tabindex="2">
              <?php foreach($gameTypes as $gametype){ ?>
              <option <?php if($gametype->MINIGAMES_TYPE_ID == $results->MINI_GAME_TYPE_ID) echo 'selected="selected"'; ?> value="<?php echo $gametype->MINIGAMES_TYPE_ID; ?>"><?php echo $gametype->GAME_DESCRIPTION; ?> </option>
              <?php } ?>
            </select>
            <span class="mandatory">*</span></label></td>
          <td width="40%"><span class="TextFieldHdr">Currency Type:</span><br />
            <label>
            <select name="currency_type" class="ListMenu" id="currency_type" tabindex="3">
              <?php foreach($currencyTypes as $currencyType){ 
			  if($currencyType->NAME == 'Cash' || $currencyType->NAME == 'Baazi Chips'){ ?>
              <option <?php if($currencyType->COIN_TYPE_ID == $results->COIN_TYPE_ID) echo 'selected="selected"'; ?> value="<?php echo $currencyType->COIN_TYPE_ID; ?>"><?php echo $currencyType->NAME; ?></option>
              <?php } 
			  }  ?>
            </select>
            <span class="mandatory">*</span> </label></td>
        </tr>

        <tr>
            <td width="40%"><span class="TextFieldHdr">Minimum Players:</span><span class="mandatory">*</span><br />
            <label>
           <select name="minplayers" class="ListMenu" id="minplayers" tabindex="4">
              <option <?php if($results->MIN_PLAYERS == 2) echo 'selected="selected"'; ?> value="2">2</option>
<!--              <option <?php //if($results->MIN_PLAYERS == 3) echo 'selected="selected"'; ?> value="3">3</option>
              <option <?php //if($results->MIN_PLAYERS == 4) echo 'selected="selected"'; ?> value="4">4</option>
              <option <?php //if($results->MIN_PLAYERS == 5) echo 'selected="selected"'; ?> value="5">5</option>
              <option <?php //if($results->MIN_PLAYERS == 6) echo 'selected="selected"'; ?> value="6">6</option>
              <option <?php //if($results->MIN_PLAYERS == 7) echo 'selected="selected"'; ?> value="7">7</option>
              <option <?php //if($results->MIN_PLAYERS == 8) echo 'selected="selected"'; ?> value="8">8</option>-->
            </select>
            </label></td>            
            
          <td width="40%"><span class="TextFieldHdr">Maximum Players:</span><span class="mandatory">*</span><br />
            <label>
           <select name="maxplayers" class="ListMenu" id="maxplayers" tabindex="5">
              <option <?php if($results->MAX_PLAYERS == 2) echo 'selected="selected"'; ?> value="2">2</option>
              <option <?php if($results->MAX_PLAYERS == 6) echo 'selected="selected"'; ?> value="6">6</option>
              <option <?php if($results->MAX_PLAYERS == 9) echo 'selected="selected"'; ?> value="9">9</option>              
            </select>
             </label></td>
          <td width="20%"><span class="TextFieldHdr">Status:</span><br />
            <label>
            <select name="status" class="ListMenu" id="status" tabindex="6">
              <option <?php if($results->IS_ACTIVE == 1) echo 'selected="selected"'; ?> value="1">Active</option>
              <option <?php if($results->IS_ACTIVE == 0 && $results->IS_ACTIVE != '') echo 'selected="selected"'; ?> value="0">InActive</option>
              <option <?php if($results->IS_ACTIVE == 2) echo 'selected="selected"'; ?> value="2">Delete</option>
            </select>
            </label></td>  
        </tr>
        
        <tr>
          <td width="40%"><span class="TextFieldHdr">Small Blind:</span><span class="mandatory">*</span><br />
            <label>
            <input name="small_blind" type="text" class="TextField" id="small_blind" maxlength="10" value="<?php echo $results->SMALL_BLIND; ?>" onkeydown="calbigblind()" onkeyup="calbigblind()" onblur="calbigblind()" tabindex="7" />
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Big Blind:</span><br />
            <label>
            <input name="big_blind" type="text" class="TextField" id="big_blind" readonly="readonly" value="<?php echo $results->BIG_BLIND; ?>" maxlength="15" tabindex="8" />
            </label></td>
            <td width="40%"><br />
            <input type="checkbox" name="STRADDLE" id="STRADDLE" <?php if($results->STRADDLE == '1'){ ?> checked=checked <?php } ?> value="1">Straddle<br>
            </td>            
        </tr>
        
        <tr>
          <td width="40%"><span class="TextFieldHdr">Minimum (Buy-in):</span><span class="mandatory">*</span><br />
            <label>
            <input name="min_buyin" type="text" class="TextField" id="min_buyin" maxlength="10" value="<?php echo $results->MINBUYIN; ?>" tabindex="9" />
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Maximum (Buy-in):</span><span class="mandatory">*</span><br />
            <label>
            <input name="max_buyin" type="text" class="TextField" id="max_buyin" maxlength="10" value="<?php echo $results->MAXBUYIN; ?>" tabindex="10" />
            </label></td>
         <td width="20%"><span class="TextFieldHdr">Limit:</span><br />
            <label>
            <select name="limit" class="ListMenu" id="limit" tabindex="11">
              <?php foreach($gameLimits as $gameLimit){ ?>
              <option value="<?php echo $gameLimit->TOURNAMENT_LIMIT_ID; ?>" <?php if($results->TOURNAMENT_LIMIT_ID == $gameLimit->TOURNAMENT_LIMIT_ID) echo 'selected="selected"'; ?>><?php echo $gameLimit->DESCRIPTION; ?></option>
              <?php } ?>
            </select>
            </label></td>
        </tr>
        <tr>
          <td>
            <span class="TextFieldHdr">Rake (%):</span><span class="mandatory">*</span><br />
            <label>
              <input name="rake" type="text" class="TextField" id="rake" maxlength="3" tabindex="12" value="<?php echo floor($results->RAKE); ?>" />
              </label>          
            </td>
          <td>
            <span class="TextFieldHdr">Rake (Heads up%):</span><span class="mandatory">*</span><br />
            <label>
              <input name="rake1" type="text" class="TextField" id="rake1" maxlength="3" tabindex="12" value="<?php if($results->RAKE1!=0) echo floor($results->RAKE1); ?>" />
              </label>           
            </td>
          <td>
            <span class="TextFieldHdr">Antibanking time:</span><br />
            <label>
              <select name="anti_banking_time" class="ListMenu" id="anti_banking_time" tabindex="13">
                <!--<option value="5" <?php if($results->ANTI_BANKING_TIME == 5) echo 'selected="selected"'; ?>>5 mins</option>
                <option value="10" <?php if($results->ANTI_BANKING_TIME == 10) echo 'selected="selected"'; ?>>10 mins</option>
                <option value="15" <?php if($results->ANTI_BANKING_TIME == 15) echo 'selected="selected"'; ?>>15 mins</option>                                        
                <option value="20" <?php if($results->ANTI_BANKING_TIME == 20) echo 'selected="selected"'; ?>>20 mins</option>
                <option value="25" <?php if($results->ANTI_BANKING_TIME == 25) echo 'selected="selected"'; ?>>25 mins</option>
                <option value="30" <?php if($results->ANTI_BANKING_TIME == 30) echo 'selected="selected"'; ?>>30 mins</option>-->
                
                <?php for($n=1;$n<=60;$n++){ ?>
			   <option value="<?php echo $n; ?>" <?php if($results->ANTI_BANKING_TIME == $n) echo 'selected="selected"'; ?>><?php echo $n; ?> mins</option>
			    <?php } ?>
                
                </select>
              </label>          
            </td>
        </tr>
        <tr>
          <td>
			<span class="TextFieldHdr">Rake Cap(<=3):</span><br />
            <label>
            <input name="rake_cap" type="text" class="TextField" id="rake_cap" maxlength="5" tabindex="12" value="<?php if($results->RAKE_CAP!=0) echo $results->RAKE_CAP; ?>" />
            </label>          
          </td>
          <td>
			<span class="TextFieldHdr">Rake Cap(>3):</span><br />
            <label>
            <input name="rake_cap1" type="text" class="TextField" id="rake_cap1" maxlength="5" tabindex="12" value="<?php if($results->RAKE_CAP1!=0) echo $results->RAKE_CAP1; ?>" />
            </label>            
          </td>
          <td>
			<span class="TextFieldHdr">Player time:</span><br />
            <select name="playertime" class="ListMenu" id="playertime" tabindex="13">
             <?php for($i=1;$i<=60;$i++){ ?>
			   <option value="<?php echo $i; ?>" <?php if($results->PLAYER_HAND_TIME == $i) echo 'selected="selected"'; ?>><?php echo $i; ?> sec</option>
			 <?php } ?>
            </select>
            </label>         
          </td>
        </tr>
        <tr>
          <td>
            <span class="TextFieldHdr">Extra time:</span><br />
            <label>
            <select name="extratime" class="ListMenu" id="extratime" tabindex="14">
             <!-- <option value="15" <?php if($results->EXTRA_TIME == 15) echo 'selected="selected"'; ?>>15 sec</option>
              <option value="30" <?php if($results->EXTRA_TIME == 30) echo 'selected="selected"'; ?>>30 sec</option>
              <option value="45" <?php if($results->EXTRA_TIME == 45) echo 'selected="selected"'; ?>>45 sec</option>
              <option value="60" <?php if($results->EXTRA_TIME == 60) echo 'selected="selected"'; ?>>60 sec</option>-->
               <?php for($j=1;$j<=60;$j++){ ?>
			   <option value="<?php echo $j; ?>" <?php if($results->EXTRA_TIME == $j) echo 'selected="selected"'; ?>><?php echo $j; ?> sec</option>
			   <?php } ?>
            </select>
            </label>          
            </td>
          <td>
            <span class="TextFieldHdr">Disconnecting time:</span><br />
            <label>
            <select name="disconnect_time" class="ListMenu" id="disconnect_time" tabindex="13">
              <!--<option value="30" <?php if($results->DISCONNECT_TIME == 30) echo 'selected="selected"'; ?> >30 sec</option>
              <option value="60" <?php if($results->DISCONNECT_TIME == 60) echo 'selected="selected"'; ?> >60 sec</option>
              <option value="90" <?php if($results->DISCONNECT_TIME == 90) echo 'selected="selected"'; ?> >90 sec</option>
              <option value="120" <?php if($results->DISCONNECT_TIME == 120) echo 'selected="selected"'; ?> >120 sec</option>-->
              <?php for($k=1;$k<=60;$k++){ ?>
			   <option value="<?php echo $k; ?>" <?php if($results->DISCONNECT_TIME == $k) echo 'selected="selected"'; ?>><?php echo $k; ?> sec</option>
			   <?php } ?>
            </select>
            </label>          
            </td>
          <td>
            <span class="TextFieldHdr">Sit Out Time:</span><br />
                <label>
                <select name="sitouttime" class="ListMenu" id="sitouttime" tabindex="15">
                 <!-- <option value="1" <?php if($results->SITOUT_TIME == 1) echo 'selected="selected"'; ?>>1 min</option>
                  <option value="2" <?php if($results->SITOUT_TIME == 2) echo 'selected="selected"'; ?>>2 min</option>
                  <option value="3" <?php if($results->SITOUT_TIME == 3) echo 'selected="selected"'; ?>>3 min</option>
                  <option value="4" <?php if($results->SITOUT_TIME == 4) echo 'selected="selected"'; ?>>4 min</option>
                  <option value="5" <?php if($results->SITOUT_TIME == 5) echo 'selected="selected"'; ?>>5 min</option>              
                  <option value="10" <?php if($results->SITOUT_TIME == 10) echo 'selected="selected"'; ?>>10 min</option>
                  <option value="15" <?php if($results->SITOUT_TIME == 15) echo 'selected="selected"'; ?>>15 min</option>
                  <option value="20" <?php if($results->SITOUT_TIME == 20) echo 'selected="selected"'; ?>>20 min</option>-->
                   <?php for($m=1;$m<=60;$m++){ ?>
			   <option value="<?php echo $m; ?>" <?php if($results->SITOUT_TIME == $m) echo 'selected="selected"'; ?>><?php echo $m; ?> mins</option>
			   <?php } ?>
                </select>
                </label>       
            </td>
        </tr>        
         <input type="hidden" name="task" value="creategame">
        <tr>
          <td><input name="submit" type="submit" onClick="return validate();" value="Update" style="float:left"></form>
            &nbsp;
            <form action="<?php echo base_url();?>games/poker/game/listgame?rid=52&start=1"  method="post" name="backtolist" id="backtolist" style="float:left">	
            <input name="submit" type="submit" value="Cancel"  style="float:left;margin-left:5px;">
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