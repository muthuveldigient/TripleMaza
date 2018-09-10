<script src = "<?php echo base_url(); ?>static/js/registration_datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script language="javascript">
function checkUsername(){
	var ptid=document.getElementById('USERNAME').value;
    xmlHttp=GetXmlHttpObject()

    var url='<?php echo base_url();?>user/ajax/userExists';
	url=url+"?ptid="+ptid;
	xmlHttp.onreadystatechange=Showuser
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
}

function Showuser(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
    	var result=xmlHttp.responseText;
        var disptext='';
        if(trim(result)=='Useralreadyexist'){
          	$("#usercbal").css('display','none');
        } else {
			disptext='User not exists.';
			document.getElementById("usercbal").innerHTML=disptext;
			$("#usercbal").css('display','block');
			$("#usercbal").fadeOut("slow");
			document.getElementById("USERNAME").value="";
			return false;


		}
    }
}

function checkNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
   	return false;

   return true;
}
</script>
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
    padding: 0 9px;
    position: relative;
    top: 3px;
	float:left;
}
</style>

<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){

$("#USERNAME").focus(function(){
  $("#usercbal").css('display','none');
});

 $.validator.addMethod("alphabetsOnly",
   function (value, element) {

   $("#usercbal").css('display','none');
    var alphabetsOnlyRegExp = new RegExp("^[\\a-zA-Z,0-9]+$");

    if (alphabetsOnlyRegExp.test(element.value)) {
   		return true;
    } else {
   		return false;
    }
   }, "Username must contain only letters, numbers" );

	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		email: true
	};

	$('#regForm').validate({

		rules: {
   		  TOURNAMENT_NAME: {
		  	required: true,
		  },
		  USERNAME: {
                required: true
			   // minlength: 4,
				//maxlength: 15,
			   // alphabetsOnly: true
			    //checkUsername: true
		 },
  	},
	messages: {
		USERNAME: {
				required: "Enter Username",
			    minlength: "Username must contain atleast 4 characters",
			    maxlength: "Username must not exceed 15 characters",
   				},

    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.closest('.control-group').removeClass('error').addClass('success');
  	}
 });
}); // end document.ready

function dateValidation(date_val){
	var matches = /(\d{2})[-\/](\d{2})[-\/](\d{4})/.exec(date_val);
	if (matches == null){
		alert("Enter Date of birth in DD-MM-YYYY format");
		document.getElementById('DOB').value="";
    }
}
</script>

<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php }  ?>
    <form name="regForm" id="regForm" method="POST" action="" >

      <table width="100%" class="ContentHdr">
        <tr>
          <td><strong>Add Promotions to User</strong>
<!--            <table width="50%" align="right">
              <tr>
                <td><div align="right"><img style="width: 16px; height: 16px; position: relative; left: -5px; top: 1px;" src="<?php echo base_url();?>static/images/list.png" alt="" /><a class="dettxt" href="<?php echo base_url(); ?>user/account/search?rid=10">Players List</a></div></td>
              </tr>
            </table>--></td>
        </tr>
      </table>
      <?php if($_GET['msg']==3002){ ?>
      <div class="UpdateMsgWrap">
        <table width="100%" class="SuccessMsg">
          <tr>
            <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
            <td width="95%">Promotion Successfully Added!</td>
          </tr>
        </table>
      </div>
      <?php }else if($_GET['msg']==3001 ){  ?>
	    <div class="UpdateMsgWrap">
       <table width="100%" class="ErrorMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
    	    <td width="95%">User Already have this promotions </td>
        </tr>
      </table>
     </div>
	 <?php  }else if($_GET['msg']==3003 ){  ?>
	    <div class="UpdateMsgWrap">
       <table width="100%" class="ErrorMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
    	    <td width="95%">All the fields are required!</td>
        </tr>
      </table>
     </div>
	 <?php  } ?>

       <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
      		<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td><table width="100%" class="PageHdr">
              <tr>
                <td><strong>Add Promotions to user</strong></td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">Select Promotion<span id="usernamespan" class="mandatory">*</span>:</span><br />
                  <label>
									<select id="TOURNAMENT_NAME" name="TOURNAMENT_NAME" class="TextField" >
                     <option value=""> Select </option>
                     <option value="VEGAS100">VEGAS100</option>
										 <option value="GOA100">GOA100</option>
										 <option value="PPL100">PPL100</option>
                   </select>
                   </label></td>
                <td width="40%"><span class="TextFieldHdr">User Name<span id="emailspan" class="mandatory">*</span>:</span><br />
                  <label>
                  <input onchange="javascript:checkUsername();" name="USERNAME" type="text" class="TextField" id="USERNAME" tabindex="2" maxlength="30" value="" />
                  </label><div class="UDFieldTxtFld" style="color: #FF0000;" id="usercbal"></div></td>
                <!--<td width="40%"><span class="TextFieldHdr">Force Register:</span> <br />
                  <label>
                  <input name="FORCE" type="checkbox" class="TextField" id="FORCE" tabindex="3" maxlength="15" value="" />
                 </label></td>-->
              </tr>

            </table>
            </td>
        </tr>

        <tr style="position:relative;left:10px;">

        <td style="padding-bottom: 10px; padding-top: 10px;"><input style="position:relative;left:10px;" type="submit" name="Submit" id="Submit"  value="Add Promotion" tabindex="6"  />
          &nbsp;&nbsp;&nbsp;
          <input type="reset" class="button" value="Reset" />

          </td>
      </tr>

      </table>
           </td>
          </tr>


      </table>
    </form>
  </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>
