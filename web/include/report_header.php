<?php $vTime = strtotime(date('Y-m-d H:i:s')); 
$version = 0.1;// for cache clear
?>
<html>
  <head>
    <title>Triple Maza</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="icon" href="images/favicon.png?v=<?php echo $version ;?>" title="Triple Chance Live" type="image/png">
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<link rel="stylesheet" href="css/report_style.css?v=<?php echo $version ;?>" type="text/css">

<style>
.error{
	color:red;
}
</style>

  </head>
  <body>
  <!--<div class="loading" id="load">
			<div class="load">
			  <div class="loader animation-5">
				<div class="shape shape1"></div>
				<div class="shape shape2"></div>
				<div class="shape shape3"></div>
				<div class="shape shape4"></div>
			  </div>
			</div>
		</div>-->
  <div class="myacc_section">
	
	<!--<div class="myacc_sec_header"> 
	<div class="myacc_logo"><img src="images/logo.png" class=""></div>
	<div class="myacc_logout">
	<div class="logout_sec"><a href="index.php"><div class="back_myacc">Back to game</div></a></div>
	<div class="logout_sec"><a href="logout.php"><div class="logout_myacc">Logout</div></a></div>
	</div>
	
	</div>-->
	
      <div class="tab">
        <div class="tablinks active"  id="game">
         <a href="gamehistory.php"> <div class="myacc_sec_head">Game History</div></a>
        </div>
        <div class="tablinks" id="ledger">
		<a href="ledger.php"><div class="myacc_sec_head">Ledger</div></a>
        </div>
        <div class="tablinks" id="user" >
          <a href="userprofile.php"><div class="myacc_sec_head">User Profile</div></a>
        </div>
        <div class="tablinks" id="draw">
          <a href="drawhistory.php"><div class="myacc_sec_head">Win History</div></a>
        </div>
        <div class="tablinks"  id="pwd">
		 <a href="changepassword.php"><div class="myacc_sec_head">Change Password</div></a>
        </div>
      </div>