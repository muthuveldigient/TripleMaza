<?php include_once("include/report_header.php"); 
session_start ();
include_once ("include/DbConnect.php");
include_once ("include/clsLotto.php");
$objLotto = new clsLotto ();
$sesion = $objLotto->userAuthendication ();
$getTerminalBal = $objLotto->getTerminalBalance ( $_SESSION [SESSION_USERID] );
$reg ['user_id'] = $_SESSION ['ter_userid'];
$transaction = $objLotto->getUserTransactionHistroy ( $reg );
?>
<script type="text/javascript">
<?php if (!empty( $sesion)) {?>
	window.location.href = "index.php";
<?php } ?>
</script>
      <div id="myacc_3" class="tabcontent " >
        <div class="gamehis ">
          <div class="report_head">
            <div class="gamehis_head">User Profile</div>
          </div>
          <div class="usr_det_1 table_scroll">
            <table class="table gamehis_table" id="myTable" style="margin-bottom:15px;">
			<thead>
			  <tr>
				<th>UserName</th>
				<th>Email ID</th>
				<!--<th>Contact</th>-->
				<th>Balance</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td><?= (!empty($_SESSION[SESSION_USERNAME])?strtoupper($_SESSION[SESSION_USERNAME]):'--');?></td>
				<td><?= (!empty($_SESSION[SESSION_USEREMAIL])?strtoupper($_SESSION[SESSION_USEREMAIL]):'--');?></td>
				<!--<td><?= (!empty($_SESSION[SESSION_USERCONTACT])?strtoupper($_SESSION[SESSION_USERCONTACT]):'--');?></td>-->
				<td><?php echo (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:'0000');?></td>
			  </tr>

			</tbody>
		  </table>
          </div>
        </div>
      </div>

	  <script>
		$('.tablinks').removeClass('active');
		$('#user').addClass('active');
	</script>
<?php include_once("include/report_footer.php"); ?>