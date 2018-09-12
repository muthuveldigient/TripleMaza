<?php
	session_start();
	include_once("include/DbConnect.php");
	include_once("include/clsLotto.php");
	$objLotto =  new clsLotto();
	$session = $objLotto->userAuthendication();
	$sessionOut=1;
	if (!empty( $session)) {
		$sessionOut=0;
		//header('Location: index.php');
	}
	/* $status = $objLotto->streamingStatus();
	$streaming=0;
	if (!empty( $status ) ) {
		$streaming=1;
	} */
	
	$drawID = (!empty($_GET['id'])?$_GET['id']:0);
	$nxtDrawInfo= $objLotto->getUpcomingDrawData('','',$arrGameIDs[0]);
	$nxtDrawTime =  "--:--";
	if (!empty( $nxtDrawInfo[1]->DRAW_STARTTIME )){
		$nxtDrawTime = date('h:i A',strtotime($nxtDrawInfo[1]->DRAW_STARTTIME));
	}
	
	$futureDraw = $objLotto->getFutureDrawsList($arrGameIDs[0]);//today
	$nextDayDraw = $objLotto->getNextDayDrawsList($arrGameIDs[0]);//Tommorrow
	$draws ='';
	
	
	if ( !empty( $futureDraw ) ) {
			$currentDrawTime =(!empty($futureDraw[0]->DRAW_STARTTIME)?date('h:i A',strtotime($futureDraw[0]->DRAW_STARTTIME)):'--:--'); 
	}else{
		$currentDrawTime = (!empty($nextDayDraw[0]->DRAW_STARTTIME)?date('h:i A',strtotime($nextDayDraw[0]->DRAW_STARTTIME)):'--:--'); 
	}
	
	$getExtDrawResults =$objLotto->getExtDrawResults($arrGameIDs[0]);

	$lastResult ='<div class="last_result_p">
                    <p class="last_result_text">LAST RESULT
                        <span class="time_last_result last_result_time">
                           '.(!empty($getExtDrawResults[0]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[0]->DRAW_STARTTIME)):'--').'
                        </span>
                    </p>
                </div>';
			if(!empty($getExtDrawResults[0]->DRAW_WINNUMBER) && $getExtDrawResults[0]->DRAW_STATUS!=6 ){
              $res = str_split($getExtDrawResults[0]->DRAW_WINNUMBER,1);
              $lastResult .= '<div class="result-page"><div class="last_result_p">
                      <p class="last_result_num">'.$res[0].'</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">'.$res[1].'</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">'.$res[2].'</p>
                    </div></div>';
            }else if($getExtDrawResults[0]->IS_ACTIVE===0 || $getExtDrawResults[0]->DRAW_STATUS==6 || $getExtDrawResults[0]->DRAW_STATUS==7){
              $lastResult .= '<div class="cancelled">cancelled</div>';
            }else{
				$lastResult .= '<div class="result-page"><div class="last_result_p">
                      <p class="last_result_num">-</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">-</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">-</p>
                    </div></div>';
			}
			
	$result = '<div class="time_result_p time_to_result_bg_1"><p class="time_result_text time_border">TIME</p><p class="time_result_text time_border">Result</p></div>';
				if(!empty($getExtDrawResults)) {
					for($l=0;$l<5;$l++) {
					if($l==0){
						$bg = 'time_to_result_bg_1';
						$p = 'time_result_num';
					}else{
						$bg = 'time_to_result_bg_2';
						$p = 'time_result_text';
					}
					if(!empty($getExtDrawResults[$l]->DRAW_WINNUMBER) && $getExtDrawResults[$l]->IS_ACTIVE==1){
						$result .= '<div class="time_result_p '.$bg.'"><p class="'.$p.'">'.(!empty($getExtDrawResults[$l]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[$l]->DRAW_STARTTIME)):'--').'</p><p class="time_result_text">'.(!empty($getExtDrawResults[$l]->DRAW_WINNUMBER)?$getExtDrawResults[$l]->DRAW_WINNUMBER:'--').'</p></div>';
					}else if($getExtDrawResults[$l]->IS_ACTIVE==0 || $getExtDrawResults[$l]->DRAW_STATUS==6 || $getExtDrawResults[$l]->DRAW_STATUS==7){
						$result .= '<div class="time_result_p '.$bg.'"><p class="'.$p.'">'.(!empty($getExtDrawResults[$l]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[$l]->DRAW_STARTTIME)):'--').'</p><p class="time_result_text draw_cancelled">CANCELLED</p></div>';
					}else{
						$result .= '<div class="time_result_p '.$bg.'"><p class="'.$p.'">---</p><p class="time_result_text">---</p></div>';
					}
					}
				}else{
					for($l=0;$l<5;$l++) {
						$result .= '<div class="time_result_p time_to_result_bg_1"><p class="time_result_num">---</p><p class="time_result_text">---</p></div>';
					}
				}
								
	$getTerminalBal=$objLotto->getTerminalBalance($_SESSION[SESSION_USERID]);
	$status= array(	'USER_BAL' 		=> (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:000),
					'SESSION'		=>$sessionOut,
					'nxtDrawTime'	=>$nxtDrawTime,
					'NXT_SEL'		=> $draws,
					'RESULT'		=> $result,
					'CURR_DRAW_TIME'=> $currentDrawTime,
					'LAST_RESULT'	=> $lastResult
					//'STREAMING'		=> $streaming
					);
	echo json_encode($status);exit;
	
?>