<?php include_once("include/report_header.php"); 

session_start ();
include_once ("include/DbConnect.php");
include_once ("include/clsLotto.php");
$objLotto = new clsLotto ();
$sesion = $objLotto->userAuthendication ();
$getTerminalBal = $objLotto->getTerminalBalance ( $_SESSION[SESSION_USERID] );
$req ['user_id'] = $_SESSION[SESSION_USERID];

/** last seven days */
$six = date('Y-m-d', strtotime('-6 days'));
$five = date('Y-m-d', strtotime('-5 days'));
$four = date('Y-m-d', strtotime('-4 days'));
$three = date('Y-m-d', strtotime('-3 days'));
$two = date('Y-m-d', strtotime('-2 days'));
$one = date('Y-m-d', strtotime('-1 days'));
$today = date('d-m-Y');

$req['start'] = $today;
$req['end'] =$today;

if (!empty($_POST['startdate']) && !empty($_POST['enddate'])){
	$req['start'] = $_POST['startdate'];
	$req['end'] = $_POST['enddate'];
}


if(!empty($req ['user_id'])){
	$transaction = $objLotto->getUserTransactionHistroy ( $req );
}
?>
<script type="text/javascript">
<?php if (!empty( $sesion)) {?>
	window.location.href = "index.php";
<?php } ?>

var start = new Date();
$(document).ready(function(){
	<?php if(isset($_POST['active'])){ ?>
		$('.week-date ul > li').removeClass('active');
		$('#<?php echo $_POST['active'];?>').addClass('active');
	<?php } ?>
 /* 
    $("#startdate").datepicker({
		format: "yyyy-mm-dd",
        todayBtn:  1,
		startDate : '2000-01-01',
        autoclose: true,
		endDate   : start
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
    });
    
    $("#enddate").datepicker({
		format: "yyyy-mm-dd",
        todayBtn:  1,
		startDate : '2000-01-01',
		endDate   : start,
        autoclose: true,
	}).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', minDate);
        });*/

});
</script>
      <div id="myacc_2" class="tabcontent ">
        <div class="gamehis">
          <div class="report_head">
            <div class="gamehis_head">Ledger</div>
			<div class="tbl_search">
              <!--<form action="" method="post" name="ledger">
					<div class="date_search" id="fromDate">
						<label for="startDate">From Date</label>
						<input type="text" placehoder="Start Date" id="startdate" name="startdate" value="<?= $req['start'] ?>" readonly/>
					</div>
					<div class="date_search" id="toDate">
						<label for="startDate">To Date</label>
						<input type="text" placehoder="End Date" id="enddate" name="enddate" value="<?= $req['end'] ?>" readonly/>
					</div>
				<div class="date_search"><button name="search" class="search_btn" type="submit">Search</button></div>-->
				<div class="week-date">
					<ul>
					<li id="wk_6"><div class="date_button_1" onclick="autoSubmit('<?php echo $six;?>','wk_6')"><?php echo $six;?></div></li>
					<li id="wk_5"><div class="date_button_1" onclick="autoSubmit('<?php echo $five;?>','wk_5')"><?php echo $five;?></div></li>
					<li id="wk_4"><div class="date_button_1" onclick="autoSubmit('<?php echo $four;?>','wk_4')"><?php echo $four;?></div></li>
					<li id="wk_3"><div class="date_button_1" onclick="autoSubmit('<?php echo $three;?>','wk_3')"><?php echo $three;?></div></li>
					<li id="wk_2"><div class="date_button_1" onclick="autoSubmit('<?php echo $two;?>','wk_2')"><?php echo $two;?></div></li>
					<li id="wk_1"><div class="date_button_1" onclick="autoSubmit('<?php echo $one;?>','wk_1')"><?php echo $one;?></div></li>
					<li class="active" id="wk_0"><div class="date_button_1" onclick="autoSubmit('<?php echo $today;?>','wk_0')">Today</div></li>
					</ul>
				</div>
			<!--</form>-->
            </div>
          </div>
		   <div class="table_scroll">
		   
		  <?php  if (!empty( $transaction )) { ?>
			<table class="table gamehis_table" id="myTable">
				<thead>
				  <tr>
					<th>Transaction ID</th>
					<th>Old Points</th>
					<th>In</th>
					<th>Out</th>
					<th>Current Points</th>
					<th>Date</th>
				  </tr>
				</thead>
				<tbody>
				<?php 	$i = 1;
				foreach ( $transaction as $view ) {
					$class = 'eventable';
					if (($i % 2) == 0) {
						$class = 'oddtable';
					}
					$in = '---';
					$out = '---';
					//11 bet
					/* if (in_array($view->TRANSACTION_TYPE_ID,array(10,11))) {
						$out = $view->TRANSACTION_AMOUNT;
					}
					//12 - win
					if (in_array($view->TRANSACTION_TYPE_ID,array(8,9,12))) {
						$in = $view->TRANSACTION_AMOUNT;
					} */
						
						if ( $view->CURRENT_TOT_BALANCE < $view->CLOSING_TOT_BALANCE ) {
							$in = $view->TRANSACTION_AMOUNT;
						}else{
							$out = $view->TRANSACTION_AMOUNT;
						}
					
						?>
					  <tr class="<?= $class ?>">
						<td><?= $view->INTERNAL_REFERENCE_NO; ?></td>
						<td><?= $view->CURRENT_TOT_BALANCE; ?></td>
						<td><?= $in; ?></td>
						<td><?= $out; ?></td>
						<td><?= $view->CLOSING_TOT_BALANCE; ?></td>
						<td><?= date('d-m-Y h:i A', strtotime($view->TRANSACTION_DATE)); ?></td>
					  </tr>
				  <?php 	$i++;}	?>
				</tbody>
			</table>
			  <?php }else { echo '<div class="gamehis_head"><h4 class="text-center">Record not available</h4></div>';}?>
			    
		  </div>
        </div>
      </div>
	  <script>
		$('.tablinks').removeClass('active');
		$('#ledger').addClass('active');
		function autoSubmit(date,id) {
			var form = document.createElement("form");
			var element1 = document.createElement("input"); 
			var element2 = document.createElement("input");  
			var element3 = document.createElement("input");  

			form.method = "POST";
			form.action = "";   

			element1.value=date;
			element1.name="startdate";
			form.appendChild(element1);  

			element2.value=date;
			element2.name="enddate";
			form.appendChild(element2);
			
			element3.value=id;
			element3.name="active";
			form.appendChild(element3);

			document.body.appendChild(form);

			form.submit();
		}
	</script>
<?php include_once("include/report_footer.php"); ?>