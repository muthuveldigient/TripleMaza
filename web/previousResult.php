<?php
include("include/DbConnect.php");
include_once("include/clsLotto.php");
$objLotto =  new clsLotto();
$today = $objLotto->getDrawResultsLastOneWeek($arrGameIDs[0]);
if (!empty( $today )) {
	$data .= '<div class="chart_1">
		<div class="chart_head_1">
			<div class="chart_head draw_1">Game Time</div>
			<div class="chart_head san_1">Game No</div>
			<div class="chart_head che_1">Result</div>


		</div>
		<div class="chart_scroll">';
			foreach ( $today as $day ){ 
				$drawNo = substr($day->DRAW_NUMBER,strlen($day->DRAW_NUMBER)-5,5);
				$winNumb1 = '';
				$numb1 = array();
				$win1 ='';
				$time = (!empty($day->DRAW_STARTTIME)?date('d-m-Y h:i A',strtotime($day->DRAW_STARTTIME)):'');
				if(!empty($day->DRAW_WINNUMBER)){
					$win1 = json_decode($day->DRAW_WINNUMBER, true);
				}
				$winNo = (!empty($day->DRAW_WINNUMBER)?$day->DRAW_WINNUMBER:'---');
				if($day->DRAW_STATUS ==6 ){
					$winNo = 'CANCELLED';
				}

		$data .= '<div class="chart_cont_1">
					<div class="chart_cont_2">'.$time.'</div>
					<div class="chart_cont_2">'.$drawNo.'</div>
					<div class="chart_cont_2">'.$winNo.'</div>
				</div>';
			 }
		$data .= '</div>
	</div>';
}else{ $data .= '<div class="chart_1"><div class="chart_head_1"><h2>Result not found</h2></div></div>'; } 
$data .= '<div>';
echo $data ;exit;
?>