<?php
	session_start();
	include_once("include/DbConnect.php");
	include_once("include/clsLotto.php");
	include("include/functions.php");
	$objLotto =  new clsLotto();
	$session = $objLotto->userAuthendication();
	if (!empty( $session)) {
		$res = array('status'=>'expired');//session expired
		echo json_encode($res);exit;
	}
	/* $status = $objLotto->streamingStatus();
	if (empty( $status ) ) {
		$res = array('status'=>'STREAMING_DISABLED');//streaming disabled
		echo json_encode($res);exit;
	} */
	
	if(!empty($_REQUEST["cDrawID"])) {	
		$drawType="NEXTDRAW";	
		$getNextDrawTime = $objLotto->getUpcomingDrawData($_REQUEST["cDrawID"],$drawType,$arrGameIDs[0]);
		$preDrawInfo = $objLotto->getPreviousDrawData('',$arrGameIDs[0]);
		
		$getTerminalBal=$objLotto->getTerminalBalance($_SESSION[SESSION_USERID]);

		$preDrawTime = '';
		$preDrawNo = '';
		if (!empty($preDrawInfo )){
			$preDrawTime = date('h:i A',strtotime($preDrawInfo[0]->DRAW_STARTTIME));
			$preDrawNo = substr($preDrawInfo[0]->DRAW_NUMBER,strlen($preDrawInfo[0]->DRAW_NUMBER)-5,5);
		}
		
		$futureDraw = $objLotto->getFutureDrawsList($arrGameIDs[0]);//today
		$nextDayDraw = $objLotto->getNextDayDrawsList($arrGameIDs[0]);//Tommorrow
		$draws ='';
		/* if (!empty($futureDraw ) ) {
			$k=0;
			foreach ($futureDraw as $draw){
				$nxtDraw = (!empty($draw->DRAW_STARTTIME)?date('h:i A',strtotime($draw->DRAW_STARTTIME)):'00:00');
				if ( $k==0){
					$draws.='<option value="0">Advance Game</option>';
				} else {
					$draws.='<option value="'.$draw->DRAW_ID.'">'.$nxtDraw.'</option>';
				}
				$k++;}
		}
		
		if(!empty($nextDayDraw)){
				$draws.='<option class="futuredraw_day" value=""><b>Next Day</b></option>';
				$k1=0;
				foreach ($nextDayDraw as $next){
					$nxtDraw1 = (!empty($next->DRAW_STARTTIME)?date('h:i A',strtotime($next->DRAW_STARTTIME)):'00:00');
					$draws.='<option class="futuredraw_day" value="'.$next->DRAW_ID.'">'.$nxtDraw1.'</option>';
				$k1++;} 
		} */
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
			
	$result = '<div class="time_result_p time_to_result_bg_1"><p class="time_result_text">TIME</p><p class="time_result_text">Result</p></div>';
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
						$result .= '<div class="time_result_p '.$bg.'"><p class="'.$p.'">'.(!empty($getExtDrawResults[$l]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[$l]->DRAW_STARTTIME)):'--').'</p><p class="time_result_text">CANCELLED</p></div>';
					}else{
						$result .= '<div class="time_result_p '.$bg.'"><p class="'.$p.'">---</p><p class="time_result_text">---</p></div>';
					}
					}
				}else{
					for($l=0;$l<5;$l++) {
						$result .= '<div class="time_result_p time_to_result_bg_1"><p class="time_result_num">---</p><p class="time_result_text">---</p></div>';
					}
				}
				
		
		/** get reaming ticket quantity End */
		if(!empty($getNextDrawTime)) {

			$row=recordSet("SELECT NOW()");
			$dbTime = (!empty($row[0])?date("F d, Y H:i:s", strtotime($row[0])):date("F d, Y H:i:s", time()));

			$nxtDrawDate = (!empty($getNextDrawTime[1]->DRAW_STARTTIME)?date('d/m/Y',strtotime($getNextDrawTime[1]->DRAW_STARTTIME)):'');
			$nxtDrawTime = (!empty($getNextDrawTime[1]->DRAW_STARTTIME)?date('h:i A',strtotime($getNextDrawTime[1]->DRAW_STARTTIME)):'');
			
			$expDDate1 = date('d-m-Y',strtotime(substr($getNextDrawTime[0]->DRAW_STARTTIME,0,10)));
			$expDTime1 = date('H:i:s',strtotime($getNextDrawTime[0]->DRAW_STARTTIME));
			$expDDate  = explode('-',$expDDate1);
			$expDTime  = explode(':',$expDTime1);
			$drawCountDownTime=$expDDate[2].','.($expDDate[1]-1).','.$expDDate[0].','.$expDTime[0].','.$expDTime[1].','.$expDTime[2]; //'Y,m,d,h,m,s'	
			//$price =	(!empty($getNextDrawTime[0]->GAME_TYPE_DRAW_PRICE)?explode(",",$getNextDrawTime[0]->GAME_TYPE_DRAW_PRICE):0);
			$price=	(!empty($getNextDrawTime[0]->DRAW_PRICE)?$getNextDrawTime[0]->DRAW_PRICE:0);
		
			$status= array(	'status'		=> 'available',
							'DRAW_ID'		=> $getNextDrawTime[0]->DRAW_ID,
							'DRAW_NUMBER'	=> $getNextDrawTime[0]->DRAW_NUMBER,
							'GAME_NO'		=> substr($getNextDrawTime[0]->DRAW_NUMBER,strlen($getNextDrawTime[0]->DRAW_NUMBER)-5,5),
							'DRAW_PRICE'	=> (!empty($price)?$price:'0'),
							'DRAW_STARTTIME'=> $getNextDrawTime[0]->DRAW_STARTTIME,
							'COUNT_DOWN'	=> $drawCountDownTime,
							'NXT_DRAW_DATE' => $nxtDrawDate,
							'NXT_DRAW_TIME' => $nxtDrawTime,
							'PREV_DRAW_NO' 	=> $preDrawNo,
							'PREV_DRAW_TIME' => $preDrawTime,
							'USER_BAL'		=> (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:000),
							'NXT_SEL'		=> $draws,
							'RESULT'		=> $result,
							'CURR_DRAW_TIME'=> $currentDrawTime,
							'LAST_RESULT'	=> $lastResult,
							'DB_TIME'		=> $dbTime
							);
			echo json_encode($status);exit;
		} else {
			$status= array(	'status'		=> 'Next draw not available','NXT_SEL'		=> $draws);
			echo json_encode($status);exit;
		}
	} else {
		$status= array(	'status'		=> 'Draw not available','NXT_SEL'		=> $draws);
		echo json_encode($status);exit;
	}
?>