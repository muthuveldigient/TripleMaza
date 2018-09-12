
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reset Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/style.css" />
<script src="<?php echo base_url(); ?>static/js/jquery.min_new.js"></script>
<script src="<?php echo base_url(); ?>static/js/validator.min.js" type="text/javascript"></script>
      
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>			
			
</head>

<body>
<!--
<div class="container-fluid">   
<?php
	if($this->session->flashdata('message')){ 
			$msg = $this->session->flashdata('message');
	?>
	<script>
		$(function(){
			$('#msg').show();
			setTimeout(function() {
					$('#msg').hide();
			}, 5000);
		});
	</script>
	<div  id="msg">
		<span class="message"><?php echo $msg['msg'];?></span>
	</div>
<?php } ?>	

<div class="change_password_landing col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
<h2>Password Expired - Change Password</h2>
<p><b>New Password</b></p>
<p>1.Should be between 8 to 15 characters.</p>
<p>2.Example : eXample@134, Allowed only[#%*+=@&!?$]</p>
	<form action="<?php echo base_url().'resetpassword/force_update_password'?>" method="POST" id="force_pwd_form" data-toggle="validator">
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padding">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<div class="form-group col-md-10 col-lg-offset-1 col-lg-8 col-sm-12 col-xs-12" style="padding:0;">
					<div class="col-sm-6 text-right_mobile">     
				 <label for="OLDPASSWORD">Old Password:</label>
				 </div>
				  <div class="col-sm-6">
				  <input type="password" class="form-control" id="OLDPASSWORD" placeholder="Password" name="OLDPASSWORD" data-error="Please enter old password" autocomplete="off" required>
							<div class="help-block with-errors"></div>
				</div>
				</div>
			</div>
		   <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<div class="form-group col-md-10 col-lg-offset-1 col-lg-8 col-sm-12 col-xs-12" style="padding:0;">
				   <div class="col-sm-6 text-right_mobile"><label for="NEWPASSWORD">New Password:</label></div>
					<div class="col-sm-6">
						<input type="password" class="form-control" pattern="^(?=.*[#%*+=@&!?$])(?=.*[0-9])(?=.*[A-Z]).{8,15}$" id="NEWPASSWORD" placeholder="New Password" name="NEWPASSWORD" data-error="Please enter new password" autocomplete="off"  data-maxlength="15" data-minlength="8" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<div class="form-group col-md-10 col-lg-offset-1 col-lg-8 col-sm-12 col-xs-12" style="padding:0;">
					<div class="col-sm-6 text-right_mobile"> <label for="CNFM_PASSWORD">Confirm Password:</label></div>
					<div class="col-sm-6">
						<input type="password" class="form-control" id="CNFM_PASSWORD" placeholder="Confirm Password" data-match="#NEWPASSWORD" data-match-error="Password don't match" name="CNFM_PASSWORD" autocomplete="off"  data-maxlength="15" data-minlength="8" required>
						<div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<div class="form-group col-md-offset-1 col-md-8 col-lg-offset-1 col-lg-8 col-sm-12 col-xs-12" style="padding:0;">
					<div class="col-sm-6 text-right hidden-xs"></div>
					<div class="col-sm-6">
					<input type="submit" class="btn btn-default text-right" id="submit_form1" value="Change" />
					</div>
				</div>
			</div>
	 
		</div>
	</form>

</div>
</div>-->


<div class="container-fluid">
<div class="change_password_landing col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
<?php
	if($this->session->flashdata('message')){ 
				$msg = $this->session->flashdata('message');
	?>
	<script>
		$(function(){
			$('#msg').show();
			setTimeout(function() {
					$('#msg').hide();
			}, 5000);
		});
	</script>
	<div  id="msg">
		<span class="text-center"><div class="alert alert-<?php echo $msg['class'];?>"><?php echo $msg['msg'];?></div></span>
	</div>
<?php } ?>
<h2>Password Expired - Change Password</h2>
<p><b>New Password</b></p>
<p>1.Should be between 8 to 15 characters.</p>
<p>2.Example : eXample@134, Allowed only[#%*+=@&!?$]</p>

	<form action="<?php echo base_url().'resetpassword/force_update_password'?>" method="POST" id="password_form" data-toggle="validator">
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padding">
			<div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
				<label for="OLDPASSWORD">Old Password: <span style="color: #FF3300;">*</span></label>
				<input type="password" class="form-control" id="OLDPASSWORD" placeholder="Password" name="OLDPASSWORD" data-error="Please enter old password" autocomplete="off" required>
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
				<label for="NEWPASSWORD">New Password: <span style="color: #FF3300;">*</span></label>
				<input type="password" class="form-control" pattern="^(?=.*[#%*+=@&!?$])(?=.*[0-9])(?=.*[A-Z]).{8,15}$" id="NEWPASSWORD" placeholder="New Password" name="NEWPASSWORD" data-error="Please enter new password" autocomplete="off"  data-maxlength="15" data-minlength="8" required>
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
				<label for="CFM_PASSWORD">Confirm Password: <span style="color: #FF3300;">*</span></label>
				<input type="password" class="form-control" id="CFM_PASSWORD" placeholder="Confirm Password" data-match="#NEWPASSWORD" data-error="Please enter confirm password" data-match-error="Password don't match" name="CFM_PASSWORD" autocomplete="off"  data-maxlength="15" data-minlength="8" required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<?php if(!empty($trans_pwd)){ ?>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padding">
			<div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
				<label for="TRANS_OLDPASSWORD">Old Trans Password: <span style="color: #FF3300;">*</span></label>
				<input type="password" class="form-control" id="TRANS_OLDPASSWORD" placeholder="Password" name="TRANS_OLDPASSWORD" data-error="Please enter old transaction password" autocomplete="off" required>
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
				<label for="TRANS_NEWPASSWORD">New Trans Password: <span style="color: #FF3300;">*</span></label>
				<input type="password" class="form-control" pattern="^(?=.*[#%*+=@&!?$])(?=.*[0-9])(?=.*[A-Z]).{8,15}$" id="TRANS_NEWPASSWORD" placeholder="New Password" name="TRANS_NEWPASSWORD" data-error="Please enter new transaction password" autocomplete="off"  data-maxlength="15" data-minlength="8" required>
				<div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-md-4 col-lg-4 col-sm-6 col-xs-12">
				<label for="TRANS_CFM_PASSWORD">Confirm Trans Password: <span style="color: #FF3300;">*</span></label>
				<input type="password" class="form-control" id="TRANS_CFM_PASSWORD" placeholder="Confirm Password" data-match="#TRANS_NEWPASSWORD" data-error="Please enter confirm transaction password" data-match-error="Password don't match" name="TRANS_CFM_PASSWORD" autocomplete="off"  data-maxlength="15" data-minlength="8" required>
				<div class="help-block with-errors"></div>
			</div>
		</div>
		<?php } ?>
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padding">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				<input type="submit" class="btn btn-default" id="submit_form" value="Change" />
				<input type="reset" class="btn btn-default" id="reset_form" value="Reset" />
			</div>
		</div>
	</form>
</div>
</div>

<script type="text/javascript">

	$('#password_form').validator();

</script>


<script type="text/javascript">
//$('#force_pwd_form').validator();
</script>
</body>
</html>