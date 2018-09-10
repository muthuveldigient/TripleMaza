<?php include_once("include/report_header.php"); 

session_start ();
include_once ("include/DbConnect.php");
include_once ("include/clsLotto.php");
$objLotto = new clsLotto ();
$sesion = $objLotto->userAuthendication ();
$req = array('GAME_ID'=>$arrGameIDs[0],'TERMINAL_ID'=>$_SESSION[SESSION_USERID]);
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


if (!empty( $req['TERMINAL_ID'])){
	$viewTickets = $objLotto->viewTickets ($req);
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

});
</script>
<div id="myacc_1" class="tabcontent ">
        <div class="gamehis">
          <div class="report_head">
            <div class="gamehis_head">Game History</div>
            <div class="tbl_search">
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
			<?php if (!empty( $viewTickets )) { ?>
			<table class="table gamehis_table" id="myTable">
				<thead>
				  <tr>
					<th>Transaction ID</th>
					<th>Game Type</th>
					<!--<th>Name</th>-->
					<th class="bet_no">coupon : Qty No</th>
					<!--<th class="bet_value"></th>-->
					<th>Total</th>
					<th>Total Win</th>
					<th>Win No</th>
					<th>Game Time</th>
					<th>Date</th>
				  </tr>
				</thead>
				<tbody>
				<?php 	$i=1;
					foreach ( $viewTickets as $view ){
						$class = 'eventable';
						if ( ($i%2) == 0){
							$class = 'oddtable';
						}
						$game_type = (!empty($view->BET_TYPE)?constant('BET_TYPE_'.$view->BET_TYPE):'');
						//$game_name = (!empty($view->GAME_TYPE_ID)?constant('GAME_'.$view->GAME_TYPE_ID):'');
						//$gameDiscription = (!empty($view->GAME_TYPE_ID)?constant('GAME_DESCRIPTION_'.$view->GAME_TYPE_ID):'');
						
						if($view->BET_NUMBER == '0'){
							$betValue = $view->BET_NUMBER.'-'.$view->BET_AMOUNT_VALUE;
						}else{
							$betValue = str_replace(':','-',str_replace('"','',str_replace(',','</p><p> ', substr($view->BET_VALUE, 1, -1))));
						}
						$win1 ='---';
						if(!empty($view->DRAW_WINNUMBER)){
							$win1 = $view->DRAW_WINNUMBER;
						}
						if($view->DRAW_STATUS==6){
							$win1 ='CANCELLED';
						}
					?>
				  <tr class="<?= $class ?>">
					<td><?= $view->INTERNAL_REFERENCE_NO; ?></td>
					<td><?=  $game_type; ?></td>
					<td class="bet_no"><div><?=  $betValue; ?></div></td>
					  <!-- <td class="bet_value"><? //=  str_replace(","," ",$view->BET_AMOUNT_VALUE); ?></td>-->
					<td><?= $view->TOTAL_BET; ?></td>
					<td><?= $view->TOTAL_WIN; ?></td>
					<td><?=  $win1; ?></td>
					<td><?= date('d-m-Y h:i A', strtotime($view->DRAW_STARTTIME)); ?></td>
					<td><?= date('d-m-Y h:i:s A', strtotime($view->CREATED_DATE)); ?></td>
				  </tr>
				  <?php 	$i++;}?>
				</tbody>
			  </table>
			  <?php }else { echo '<div class="gamehis_head"><h4 class="text-center">Record not available</h4></div>';}?>
			  </div>
        </div>
      </div>
	  <script>
		$('.tablinks').removeClass('active');
		$('#game').addClass('active');
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