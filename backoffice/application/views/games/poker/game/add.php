<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
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
	float:left;
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
	
	$.validator.addMethod("zeroexist", function (value, element) {
        return value >= ($("#small_blind").val()<1);
    }, 'small blind should be greater than zero');
	
	$.validator.addMethod("minzeroexist", function (value, element) {
        return value >= ($("#min_buyin").val()<1);
    }, 'minimum buyin should be greater than zero');	
	
	$.validator.addMethod("maxzeroexist", function (value, element) {
        return value >= ($("#max_buyin").val()<1);
    }, 'maximum buyin should be greater than zero');	

	$.validator.addMethod("rakezeroexist", function (value, element) {
        return value >= ($("#rake").val()<1);
    }, 'rake should be greater than zero');	
	
	$.validator.addMethod("rake1zeroexist", function (value, element) {
        return value >= ($("#rake1").val()<1);
    }, 'rake headsup should be greater than zero');		
		
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
			digits: true,
			zeroexist: true
		},
		"min_buyin": {
			required: true,
			digits: true,
			minbuyinCheck: true,
			minzeroexist: true
		},
		"max_buyin": {
			required: true,
			digits: true,
			maxbuyinCheck: true,
			maxzeroexist: true
		},
		"rake": {
			required: true,
			number: true,
			rakezeroexist: true,
			rangelength: [0,99]
		},
		"rake1": {
			required: true,
			number: true,
			//rake1zeroexist: true,
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
		"big_blind": {
		 required: "Enter big blind",
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
<table width="100%" class="PageHdr">
  <tr>
    <td><strong>CREATE GAME</strong>
      <table width="50%" align="right">
        <tr>
          <td><div align="right"><a href="<?php echo base_url();?>games/poker/game?rid=51" class="dettxt">Games List</a></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php if($_GET['err']==1){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="SuccessMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
            <td width="95%">Game Added Successfully !!!</td>
          </tr>
        </table>
      </div>
      <?php } ?>
      <?php if(isset($_REQUEST['errmsg'])){ echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>
 <?php if(isset($_REQUEST['err']) && $_REQUEST['err']!="1"){
	   ?>
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
			if($_GET['err']==6) { 
				echo 'Tournament exists already';
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
          <td width="40%"><span class="TextFieldHdr">Game Name:</span><span class="mandatory">*</span><br />
            <label>
            <input name="game_name" type="text" class="TextField" id="game_name" tabindex="1" maxlength="30" />
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Game Type:</span><span class="mandatory">*</span><br />
            <label>
            <select name="game_type" class="ListMenu" id="game_type" tabindex="2">
              <?php foreach($gameTypes as $gametype){ ?>
              <option value="<?php echo $gametype->MINIGAMES_TYPE_ID; ?>"><?php echo $gametype->GAME_DESCRIPTION; ?></option>
              <?php } ?>
            </select>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Currency Type:</span><span class="mandatory">*</span><br />
            <label>
            <select name="currency_type" class="ListMenu" id="currency_type" tabindex="3">
              <?php foreach($currencyTypes as $currencyType){ 
			  if($currencyType->NAME == 'Cash' || $currencyType->NAME == 'Baazi Chips'){ ?>
              <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>"><?php echo $currencyType->NAME; ?></option>
              <?php } 
			  }  ?>
            </select>
            </label></td>
        </tr>

        <tr>
            <td width="40%"><span class="TextFieldHdr">Minimum Players:</span><span class="mandatory">*</span><br />
            <label>
           <select name="minplayers" class="ListMenu" id="minplayers" tabindex="4">
              <option value="2">2</option>
            </select>
            </label></td>            
            
          <td width="40%"><span class="TextFieldHdr">Maximum Players:</span><span class="mandatory">*</span><br />
            <label>
           <select name="maxplayers" class="ListMenu" id="maxplayers" tabindex="5">
              <option value="2">2</option>
              <option value="6">6</option>
              <option value="9">9</option>              
            </select>
             </label></td>
          <td width="40%"><span class="TextFieldHdr">Status:</span><br />
            <label>
            <select name="status" class="ListMenu" id="status" tabindex="6">
              <option value="1">Active</option>
              <option value="0">InActive</option>
            </select>
            </label></td>  
        </tr>
        
        <tr>
          <td width="40%"><span class="TextFieldHdr">Small Blind:</span><span class="mandatory">*</span><br />
            <label>
            <input name="small_blind" type="text" class="TextField" id="small_blind" maxlength="10" onkeydown="calbigblind()" onkeyup="calbigblind()" onblur="calbigblind()" tabindex="7" />
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Big Blind:</span><br />
            <label>
            <input name="big_blind" type="text" class="TextField" id="big_blind" readonly="readonly" maxlength="15" tabindex="8" />
            </label></td>
            <td width="40%"><br />
            <input type="checkbox" name="STRADDLE" id="STRADDLE" value="1">Straddle<br>
            </td>
        </tr>
        
        <tr>
          <td width="40%"><span class="TextFieldHdr">Minimum (Buy-in):</span><span class="mandatory">*</span><br />
            <label>
              <input name="min_buyin" type="text" class="TextField" id="min_buyin" maxlength="10" tabindex="9" />
              </label></td>
          <td width="40%"><span class="TextFieldHdr">Maximum (Buy-in):</span><span class="mandatory">*</span><br />
            <label>
              <input name="max_buyin" type="text" class="TextField" id="max_buyin" maxlength="10" tabindex="10" />
              </label></td>
          <td width="40%"><span class="TextFieldHdr">Limit:</span><br />
            <label>
              <select name="limit" class="ListMenu" id="limit" tabindex="11">
                <?php foreach($gameLimits as $gameLimit){ ?>
                <option value="<?php echo $gameLimit->TOURNAMENT_LIMIT_ID; ?>"><?php echo $gameLimit->DESCRIPTION; ?></option>
                <?php } ?>
                </select>
              </label></td>
          
        </tr>
        
        <tr>
          <td>
            <span class="TextFieldHdr">Rake (%):</span><span class="mandatory">*</span><br />
            <label>
              <input name="rake" type="text" class="TextField" id="rake" maxlength="3" tabindex="12" />
              </label>          
            </td>
          <td>
            <span class="TextFieldHdr">Rake (Heads up%):</span><span class="mandatory">*</span><br />
            <label>
              <input name="rake1" type="text" class="TextField" id="rake1" maxlength="3" tabindex="12" />
              </label>           
            </td>
          <td>
            <span class="TextFieldHdr">Antibanking time:</span><br />
            <label>
              <select name="anti_banking_time" class="ListMenu" id="anti_banking_time" tabindex="13">
                <!--<option value="5">5 mins</option>
                <option value="10">10 mins</option>
                <option value="15">15 mins</option>                                        
                <option value="20">20 mins</option>
                <option value="25">25 mins</option>
                <option value="30">30 mins</option>-->
                 <?php for($n=1;$n<=60;$n++){ ?>
			   <option value="<?php echo $n; ?>"><?php echo $n; ?> mins</option>
			    <?php } ?>
                </select>
              </label>          
            </td>
        </tr>
        <tr>
          <td>
			<span class="TextFieldHdr">Rake Cap(<=3):</span><br />
            <label>
            <input name="rake_cap" type="text" class="TextField" id="rake_cap" maxlength="5" tabindex="12" />
            </label>          
          </td>
          <td>
			<span class="TextFieldHdr">Rake Cap(>3):</span><br />
            <label>
            <input name="rake_cap1" type="text" class="TextField" id="rake_cap1" maxlength="5" tabindex="12" />
            </label>            
          </td>
          <td>
			<span class="TextFieldHdr">Player time:</span><br />
            <label>
            <!--<input name="playertime" type="text" class="TextField" id="playertime" value="20" tabindex="13" />-->
            <select name="playertime" class="ListMenu" id="playertime" tabindex="13">
             <!-- <option value="30">30 sec</option>
              <option value="60">60 sec</option>
              <option value="90">90 sec</option>
              <option value="120">120 sec</option>-->
              <?php for($i=1;$i<=60;$i++){ ?>
			   <option value="<?php echo $i; ?>"><?php echo $i; ?> sec</option>
			 <?php } ?>
              
            </select>
            </label>          
          </td>
        </tr>
        <tr>
          <td>
            <span class="TextFieldHdr">Extra time:</span><br />
            <label>
             <!--<input name="extratime" type="text" class="TextField" id="extratime" value="20" tabindex="14" />-->
             <select name="extratime" class="ListMenu" id="extratime" tabindex="14">
                <!-- <option value="15">15 sec</option>
                <option value="30">30 sec</option>
                <option value="45">45 sec</option>
                <option value="60">60 sec</option>-->
                <?php for($j=1;$j<=60;$j++){ ?>
			   <option value="<?php echo $j; ?>" <?php if($results->EXTRA_TIME == $j) echo 'selected="selected"'; ?>><?php echo $j; ?> sec</option>
			   <?php } ?>
                </select>
              </label>          
            </td>
          <td>
            <span class="TextFieldHdr">Disconnecting time:</span><br />
            <label>
              <!-- <input name="disconnect_time" type="text" class="TextField" id="disconnect_time" value="20" tabindex="15" />-->
              <select name="disconnect_time" class="ListMenu" id="disconnect_time" tabindex="13">
               <!-- <option value="10">10 sec</option>
                <option value="15">15 sec</option>
                <option value="20">20 sec</option>                                        
                <option value="30">30 sec</option>
                <option value="60">60 sec</option>
                <option value="90">90 sec</option>
                <option value="120">120 sec</option>-->
               <?php for($k=1;$k<=60;$k++){ ?>
			   <option value="<?php echo $k; ?>"><?php echo $k; ?> sec</option>
			   <?php } ?>
                </select>
              </label>          
            </td>
          <td>
            <span class="TextFieldHdr">Sit Out Time:</span><br />
            <label>
              <select name="sitouttime" class="ListMenu" id="sitouttime" tabindex="16">
             <!--   <option value="1">1 min</option>
                <option value="2">2 min</option>
                <option value="3">3 min</option>
                <option value="4">4 min</option>
                <option value="5">5 min</option>
                <option value="10">10 min</option>
                <option value="15">15 min</option>
                <option value="20">20 min</option> -->          
                 <?php for($m=1;$m<=60;$m++){ ?>
			   <option value="<?php echo $m; ?>"><?php echo $m; ?> mins</option>
			   <?php } ?>                     
                </select>
              </label>          
            </td>
        </tr>
        <input type="hidden" name="task" value="creategame">
        <tr>
          <td colspan="3"><input name="submit" type="submit" onClick="return validate();" value="Create" tabindex="17">
            &nbsp;
            <input name="submit" type="reset" value="Reset" tabindex="18"></td>
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
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>