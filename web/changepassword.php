<?php include_once("include/report_header.php"); 
	session_start();
	include_once("include/DbConnect.php");
	include_once("include/DbPdoConnect.php");
	include_once("include/clsLotto.php");
	include_once("include/report_header.php");
	$objLotto =  new clsLotto($conn1);
	$session = $objLotto->userAuthendication();
	
	if (!empty( $session)) {
	 	header('Location: home.php');
	}
	$msgText ='';
	if(isset($_POST["old_password"]) && isset($_POST["password_confirm"])) {
		$msgText="Please enter valid new and old password";
		if(!empty($_POST["old_password"]) && !empty($_POST["password_confirm"])) {
			$arrChangePassword["PASSWORD"]    =md5($_POST["old_password"]);
			$arrChangePassword["USER_ID"]     =$_SESSION['lucky_userid'];
			$arrChangePassword["NEW_PASSWORD"]=md5($_POST["new_password"]);
			$chkOldPassword=$objLotto->chkUserOldPassword($arrChangePassword);		
			if(!empty($chkOldPassword)) {
				$changePassword=$objLotto->chkUserPassword($arrChangePassword);
				$msgText="success";				
			} else {
				$msgText="Invalid old password";	
			}
		} 
	}

?>
<div id="myacc_5" class="tabcontent ">
      <div class="">
        <div class="chg_pwd_sec">
          <div class="report_head report_head1">
            <div class="gamehis_head">Change Password</div>
          </div>
		  <?php if( !empty($msgText)){ if( $msgText=='success'){ ?>
			<script>
				setTimeout(function() {
					$("#success-msg").hide();
				}, 4000); 
			</script>
					<div class="alert alert-success text-center" id="success-msg" align="center"> Password updated..!</div>
			<?php }else{ ?>
			<script>
				setTimeout(function() {
					$("#msg").hide();
				}, 4000);
			</script>
					<div class="alert alert-danger text-center" id="msg" align="center"><?= $msgText ?></div>
			<?php } }?>
		  <div class="change_pwd_sec">
		   <form name="userRegistration" id="userRegistration" class="chg_pwd" method="post">
				<div class="form_input_sec">
					<label>Current Password</label>
					<fieldset>
					<input type="password" class="formTxtfield" name="old_password" id="old_password" style="" maxlength="15">
					</fieldset>
				</div>
				<div class="form_input_sec">
				   <label>New Password</label>
					<fieldset>
					<input type="password" class="formTxtfield" name="new_password" id="new_password" style="" maxlength="15">
					</fieldset>
				</div>
				<div class="form_input_sec">
				   <label>Confirm New Password</label>
					<fieldset>
					<input type="password" class="formTxtfield" name="password_confirm" id="password_confirm" style="" maxlength="15" >
					</fieldset>
				</div>
				<div class="form_input_sec">
					<fieldset>
					<button name="submit" class="form_btn" type="submit">Change Password</button>
					</fieldset>
				</div>
			</form>
			  
		  </div>
        </div>
      </div>
    </div>
	<script>
	$('.chg_pwd').validate({
		rules: {
			 old_password: {
				required: true,
			},
			new_password: {
				required: true,
				minlength: 4,
				maxlength : 15
			},
			password_confirm: {
				required: true,
				minlength: 4,
				maxlength : 15,
				equalTo: "#new_password"
			}
		},
		messages : {
			old_password :{ 
				required : "Please enter your old password",
			},
			new_password : {
				required : "Please provide a  new password"
				//minlength : "Your password must be at least 7 characters long"
			},
			password_confirm : {
				required : "Please provide a  valid password"
				//minlength : "Your password must be at least 7 characters long"
			}
		}
	}); 
		$('.tablinks').removeClass('active');
		$('#pwd').addClass('active');
	</script>
	<?php include_once("include/report_footer.php"); ?>