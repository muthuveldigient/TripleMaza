<?php
session_start ();
	include_once("include/DbConnect.php");
	include_once("include/clsLotto.php");
	$objLotto =  new clsLotto();
	$ticketNumber = $_REQUEST["ticketNumber"];

	if(!empty($ticketNumber)) {
		$getDrawNumber=$objLotto->getTicketInternalRefInfo($ticketNumber);
		if(!empty($getDrawNumber)){
			if($getDrawNumber[0]->IS_CANCEL!=1 ){
				if($getDrawNumber[0]->IS_PAID!=1){
					$i=1;
					foreach ($getDrawNumber as $result){
						$ticketResponseStr="";
						if($result->DRAW_STATUS>=3) { //success
							//$gameId = $result->GAME_TYPE_ID;
							$drawStatus ='success';
							if($result->DRAW_STATUS==6){
								$drawStatus ='cancelled';
							}
							$winNo = $result->WIN_NUMBER;
							$info[$result->BET_TYPE]['WIN_NUMBER'] = $winNo;
							
							$winAmt = $result->TOTAL_WIN;
							$info[$result->BET_TYPE]['WIN'] = $winAmt;
							$win['TOTAL_WIN'][]= $winAmt;
							
							$totalBet = $result->TOTAL_BET;
							$info[$result->BET_TYPE]['TOTAL_BET'] = $totalBet;
							$win['TOTAL_BET'][]= $totalBet;
							
							$info[$result->BET_TYPE]['TICKET_ID'] = $result->TICKET_ID;
							$info[$result->BET_TYPE]['IS_PAID']	= $result->IS_PAID;
							$info[$result->BET_TYPE]['BET_TYPE'] = $result->BET_TYPE;
							
							$drawNo = substr($result->DRAW_NUMBER,strlen($result->DRAW_NUMBER)-5,5);
							
						} else if($result->DRAW_STATUS<=2) { //3-draw is not complted yet
							$response = array('msg'=>'game is not complted yet');
						} else { //1-invalid ticket number
							$response = array('msg'=>'Invalid coupon number');
						}$i++;
					}
					
				}else{
					$response = array('msg'=>'Coupon amount already paid');
				}
			}else{
					$response = array('msg'=>'Coupon already canceled');
				}
			}else{
					$response = array('msg'=>'Invalid coupon number');
				}
	} else {
		$response = array('msg'=>'Enter the coupon number');
	}

		if(!empty( $info )){
			ksort($info);
			$i=1;
			$content='';
				$header='<tr>
							<th class="claim_tab_head">Game Type</th>
							<th class="claim_tab_head">Total Play</th>
							<th class="claim_tab_head">Win Point</th>
							<th class="claim_tab_head">Action</th>
						</tr>';
					
			foreach ($info as $res){
				$content.='	<tr>
								<td>'.constant("BET_TYPE_".$res["BET_TYPE"]).'</td>
								<td>'.(!empty($res["TOTAL_BET"])?$res["TOTAL_BET"]:'--').'</td>
								<td>'.(!empty($res["WIN"])?$res["WIN"]:'--').'</td>
								<td>--</td>
							</tr>';
			$i++;
			}
			$footer='';
			$totalWin = array_sum($win["TOTAL_WIN"]);
			if($totalWin > 0 || $drawStatus=='cancelled'){
				$buttonText = 'PAY';
				if($drawStatus=='cancelled'){
					$buttonText = 'REFUND';
				}
				$footer='<tr>
							<td> TOTAL </td>
							<td>'.array_sum($win["TOTAL_BET"]).'</td>
							<td> '.$totalWin.' </td>
							<td id="pay_info"><img style="display: none; text-align: center; height: 26px"id="loader_claim" src="images/loader.gif" /><a tabindex="2" id="payButton" href="javascript:updateTicketPAYStatus('."'".$ticketNumber."'".')"><div class="pay_claim">'.$buttonText.'</div></a></td>
						</tr>';
			}
			
			$res = $header.$content.$footer;
			$response=array('gameNo'=>$drawNo,'winNo'=>$winNo,'drawStatus'=>$drawStatus,'result'=>$res,'msg'=>'success');
		}
	//}
	echo json_encode($response);exit;
?>