<?php

session_start ();
include_once("include/DbConnect.php");
include_once("include/clsLotto.php");
include("include/functions.php");
$objLotto =  new clsLotto();
?>
<script type="text/javascript">
	/* var session_mode = '<?php echo $_SESSION[SESSION_MODE];?>';
	var mode_url ='';
	if(session_mode == 1){
		mode_url ='?mode=1';
	} */
</script>
<?php
$session = $objLotto->userAuthendication();
if (!empty( $session)) { ?>
<script type="text/javascript">
    window.location.href = '<?php echo LOGIN_URL;?>';
</script>
<?php }

/** If this partner have assigned games then play the game else redirect to landing page */
$partnerId = (!empty($_SESSION[SESSION_PARTNERID])?$_SESSION[SESSION_PARTNERID]:'');
$game=0;
if(!empty($partnerId)){
	$res=$objLotto->getPartnerGames($partnerId);
	if(!empty($res)){
		foreach($res as $list){
			if($list->GAME_ID == GAME_NAME){
				$game=1;
			}
		}
	}
}

if(empty($game)){
    echo 'Please assign game';exit;
	//header('Location:'.LOGIN_LANDING_URL);
}
/** assigned games end  */

$futureDraw = $objLotto->getFutureDrawsList($arrGameIDs[0]);//today
$nextDayDraw = $objLotto->getNextDayDrawsList($arrGameIDs[0]);//Tommorrow

$drawID=""; $drawType=""; //NextDraw | Future Draw
if(isset($_REQUEST["drawID"])) {
	$drawID=base64_decode($_REQUEST["drawID"]);
	$drawType="NEXTDRAW";
}
if(isset($_REQUEST["fdrawID"])) {
	$drawID=base64_decode($_REQUEST["fdrawID"]);
	$drawType="FUTUREDRAW";
}

$preDrawInfo = $objLotto->getPreviousDrawData('',$arrGameIDs[0]);

$preDrawTime = '';
$preDrawNo = '';
$preDrawWIn = '';
$preDrawTimeFull ="00:00";;
if (!empty($preDrawInfo )){
	$preDrawTime = date('H:i',strtotime($preDrawInfo[0]->DRAW_STARTTIME));
	$preDrawTimeFull = date('H:i ',strtotime($preDrawInfo[0]->DRAW_STARTTIME));
	$preDrawNo = substr($preDrawInfo[0]->DRAW_NUMBER,strlen($preDrawInfo[0]->DRAW_NUMBER)-5,5);
	$preDrawWIn = (!empty($preDrawInfo[0]->DRAW_WINNUMBER)?json_decode($preDrawInfo[0]->DRAW_WINNUMBER):'');
}

$upcomingDraw= $objLotto->getUpcomingDrawData($drawID,$drawType,$arrGameIDs[0]);

if(!empty($upcomingDraw)) {
	$drawPrice=	(!empty($upcomingDraw[0]->DRAW_PRICE)?explode(",",$upcomingDraw[0]->DRAW_PRICE):0);
	
	$nDrawDate = date('d/m/Y',strtotime(substr($upcomingDraw[0]->DRAW_STARTTIME,0,10)));
	$nDrawTime = date('H:i',strtotime($upcomingDraw[0]->DRAW_STARTTIME));
	
	$nxtDrawInfo= $objLotto->getUpcomingDrawData('','',$arrGameIDs[0]);
	$nxtDrawDate = "00/00/0000";
	$nxtDrawTime =  "--:--";
	if (!empty( $nxtDrawInfo[1]->DRAW_STARTTIME )){
		$nxtDrawDate = date('d/m/Y',strtotime(substr($nxtDrawInfo[1]->DRAW_STARTTIME,0,10)));
		$nxtDrawTime = date('h:i A',strtotime($nxtDrawInfo[1]->DRAW_STARTTIME));
	}
	
	$expDDate1 = date('d-m-Y',strtotime(substr($upcomingDraw[0]->DRAW_STARTTIME,0,10)));
	$expDTime1 = date('H:i:s',strtotime($upcomingDraw[0]->DRAW_STARTTIME));
	
	$expDDate  = explode('-',$expDDate1);
	$expDTime  = explode(':',$expDTime1);
	$drawCountDownTime=$expDDate[2].','.($expDDate[1]-1).','.$expDDate[0].','.$expDTime[0].','.$expDTime[1].','.$expDTime[2];
	$nDrawTimeL="";
	$getExtDrawResults =$objLotto->getExtDrawResults($arrGameIDs[0],$upcomingDraw[0]->DRAW_ID); //the parameter is the next draw id
} else {
	$drawPrice='';
	$nDrawDate = "00/00/0000";
	$nxtDrawTime = "--:--";
	$nxtDrawDate = "00/00/0000";
	$nxtDrawTime = "00:00";
	$drawCountDownTime="";
	$nDrawTimeL= "00:00:00";
	$getExtDrawResults =$objLotto->getExtDrawResults($arrGameIDs[0]);
}

$getTerminalBal=$objLotto->getTerminalBalance($_SESSION[SESSION_USERID]);
$getLastTicketInfo=$objLotto->getLastOneTicketInfo($arrGameCodes[0]);
$buttonDisabled =0;
if (!empty($getLastTicketInfo[0]->IS_CANCEL)){
	$buttonDisabled =1;
}

$lPlayGroupID=(!empty($getLastTicketInfo[0]->PLAY_GROUP_ID)?$getLastTicketInfo[0]->PLAY_GROUP_ID:'');
if(!empty($lPlayGroupID) && $getLastTicketInfo[0]->IS_PENDING_STATUS==0) {
	$getPlayGroupData=$objLotto->getPlayGroupData($lPlayGroupID);	
	foreach($getPlayGroupData as $pIndex=>$playData) {
		$userBetType = $playData->BET_TYPE;
		$totelBet =  $playData->TOTAL_BET; 
		$betvalue =  $playData->BET_VALUE; 
		$fSno=1; $fTotalQty=0;
		
		$repeatBetData[$userBetType]=array(
												"betTypeID"=>$userBetType,
												"betData"=>json_decode($betvalue)
										);
	}
	$lastTicket =  json_encode($repeatBetData,JSON_FORCE_OBJECT);

} else {
	$lastTicket = '';
}
$remainingSingleQty =$remainingDoubleQty =$remainingTripleQty =0;


$vTime = strtotime(date('Y-m-d H:i:s'));
$row=recordSet("SELECT NOW()");
$dbTime = (!empty($row[0])?date("F d, Y H:i:s", strtotime($row[0])):date("F d, Y H:i:s", time()));
$version = 0.7  ;// for cache clear
$singleLength =strlen((string)SINGLE_BET_QTY_LIMIT);
$doubleLength =strlen((string)DOUBLE_BET_QTY_LIMIT);
$tripleLength =strlen((string)TRIPLE_BET_QTY_LIMIT);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Triplemaza</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/style.css?v=<?php echo $version ;?>" />
</head>
<script type="text/javascript">
    var SITE_URL = '<?= TM_SITE_URL;?>';
    var WEB_SOCKET_URL = '<?= TM_WEB_SOCKET_URL;?>';
    var SINGLE_BET_QTY_LIMIT = '<?= SINGLE_BET_QTY_LIMIT;?>';
    var DOUBLE_BET_QTY_LIMIT = '<?= DOUBLE_BET_QTY_LIMIT;?>';
    var TRIPLE_BET_QTY_LIMIT = '<?= TRIPLE_BET_QTY_LIMIT;?>';
    var lastTicket = '<?php echo $lastTicket;?>'
    var userID = <?php echo $_SESSION[SESSION_USERID];?>;
    var TERMINAL = 0;
  <?php if ( $_SESSION[SESSION_PRINTER_OPTION] == 1 ) { ?>
        TERMINAL = 1;
  <?php } ?>
        $(document).ready(function () {
    <?php if ($_SESSION[SESSION_USER_TYPE] == 2) { ?>
      var btnDisabled = '<?php echo $buttonDisabled; ?>';
                if (btnDisabled == 1) {
                    $("#frmCancelTicket").addClass("disabled");
                    $("#frmReprintTicket").addClass("disabled");
                    $('.disabled').prop('disabled', true);
                }
    <?php } ?>
   });

</script>

<body>
    
    <div class="wrapper" id="wrapper">
        <!-- Result animation -->
        <div class="opacity" id="result_timer" style="display:none;">
            <div class="result">
                <div class="result-animation-frame">
                    <div class="result-img-animation" style="display:none;" id="timer1"><img  id="timer_frame" class="img-responsive" src="images/Frame_1.png" />
                        <div id="main-wrapper_result">
                            <div class="result_container">
                                <div class="div1"><img class="img-responsive" src="images/0.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/1.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/2.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/3.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/4.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/5.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/6.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/7.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/8.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/9.png" /></div>
                            </div>

                        </div>
                        <div id="main-wrapper1_result">
                            <div class="result_container">
                                <div class="div1"><img class="img-responsive" src="images/0.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/1.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/2.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/3.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/4.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/5.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/6.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/7.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/8.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/9.png" /></div>
                            </div>

                        </div>
                        <div id="main-wrapper2_result">
                            <div class="result_container">
                                <div class="div1"><img class="img-responsive" src="images/0.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/1.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/2.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/3.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/4.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/5.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/6.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/7.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/8.png" /></div>
                                <div class="div1"><img class="img-responsive" src="images/9.png" /></div>
                            </div>

                        </div>
                    </div>
                    <div class="result-img-animation-stop" id="timer2" style="display:none;">
                        <img class="img-responsive" src="images/Frame_5.png" />
                        <div id="main-wrapper_result">
                            <div class="result_container-stop">
                                <div class="div1-stop" id="result_1"></div>
                            </div>

                        </div>
                        <div id="main-wrapper1_result">
                            <div class="result_container-stop">
                                <div class="div1-stop" id="result_2"></div>
                            </div>

                        </div>
                        <div id="main-wrapper2_result">
                            <div class="result_container-stop">
                                <div class="div1-stop" id="result_3"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Result animation -->

        <div class="modal" id="confirmation" style="display:none;" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog2 modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="margin-bottom: 20px;">
                        <div class="confirm_1">
                            <div class="disconnect_text">Disconnected to internet. Page reloads in <span id="timer"></span></div>
                            <a class="reload_text" id="disconnect_btn" class="btn btn-secondary">Reload</a>
                            <div class="" style="width: 100%;text-align: center;"><img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="disconnect_loader" src="images/loader.gif"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- loading content -->
        <div class="loading" id="load">
			<div class="load">
			  <div class="loader animation-5">
				<div class="shape shape1"></div>
				<div class="shape shape2"></div>
				<div class="shape shape3"></div>
				<div class="shape shape4"></div>
			  </div>
			</div>
		</div>
        <!-- loading content -->
        <!-- success and error msg -->
        <div class='notification_success alert alert-danger' style="display: none;" id="msg"></div>
        <div class='notification_success alert alert-success' style="display: none;" id="success-msg"></div>
<!-- success and error msg -->

        <div class="header">
            <div class="username">
                <div class="username_firstinnerdiv">
                    <div class="username_firstinnerdiv1">
                        <p>USERNAME</p>
                        <p>
                            <?= (!empty($_SESSION[SESSION_USERNAME])?$_SESSION[SESSION_USERNAME]:'--');?>
                        </p>
                    </div>
                </div>
                <div class="username_secondinnerdiv">
                    <div class="username_innerdiv">
                        <p>BALANCE</p>
                        <p>
                            <span id="userBalance">
                                <?= (!empty($getTerminalBal[0]->USER_TOT_BALANCE)?$getTerminalBal[0]->USER_TOT_BALANCE:000);?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="last_result" id="last_result_info">
                <div class="last_result_p">
                    <p class="last_result_text">LAST RESULT
                        <span class="time_last_result last_result_time">
                            <?php echo (!empty($getExtDrawResults[0]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[0]->DRAW_STARTTIME)):'--');?>
                        </span>
                    </p>
                </div>
                <?php	
          
						if(!empty($getExtDrawResults[0]->DRAW_WINNUMBER) && $getExtDrawResults[0]->DRAW_STATUS!=6 ){
              $res = str_split($getExtDrawResults[0]->DRAW_WINNUMBER,1);
              echo '<div class="result-page"><div class="last_result_p">
                      <p class="last_result_num">'.$res[0].'</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">'.$res[1].'</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">'.$res[2].'</p>
                    </div></div>';
            }else if($getExtDrawResults[0]->IS_ACTIVE===0 || $getExtDrawResults[0]->DRAW_STATUS==6 || $getExtDrawResults[0]->DRAW_STATUS==7){
              //echo '<p class="last_result_data drawrescancel">Cancelled</p>';
              echo '<div class="cancelled">cancelled</div>';
            }else{
              echo '<div class="result-page"><div class="last_result_p">
                      <p class="last_result_num">-</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">-</p>
                    </div>
                    <div class="last_result_p">
                      <p class="last_result_num">-</p>
                    </div></div>';
            }
          ?>
            </div>
            <div class="time_to_game">
                <div class="time_to_game_p time_to_game_bg_1">
                    <p class="time_to_game_text">TIME TO GAME</p>
                </div>
                <div class="time_to_game_p time_to_game_bg_2">
                    <p class="time_to_game_num" id="ndrawLeftTime"></p>
                </div>
            </div>
            <div class="time_result" id="result_top">
                <div class="time_result_p time_to_result_bg_1">
                    <p class="time_result_text time_border">TIME</p>
                    <p class="time_result_text time_border">Result</p>
                </div>
                <?php 
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
                        echo '<div class="time_result_p '.$bg.'"><p class="'.$p.'">'.(!empty($getExtDrawResults[$l]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[$l]->DRAW_STARTTIME)):'--').'</p><p class="time_result_text">'.(!empty($getExtDrawResults[$l]->DRAW_WINNUMBER)?$getExtDrawResults[$l]->DRAW_WINNUMBER:'--').'</p></div>';
                      }else if($getExtDrawResults[$l]->IS_ACTIVE==0 || $getExtDrawResults[$l]->DRAW_STATUS==6 || $getExtDrawResults[$l]->DRAW_STATUS==7){
                        echo '<div class="time_result_p '.$bg.'"><p class="'.$p.'">'.(!empty($getExtDrawResults[$l]->DRAW_STARTTIME)?date("h:i A",strtotime($getExtDrawResults[$l]->DRAW_STARTTIME)):'--').'</p><p class="time_result_text draw_cancelled">CANCELLED</p></div>';
                      }else{
                        echo '<div class="time_result_p '.$bg.'"><p class="'.$p.'">---</p><p class="time_result_text">---</p></div>';
                      }
                    }
                  }else{
                    for($l=0;$l<5;$l++) {
                      echo '<div class="time_result_p time_to_result_bg_1"><p class="time_result_num">---</p><p class="time_result_text">---</p></div>';
                    }
                  }
            
            ?>
            </div>
            <div class="logout">
                <div class="logout_firstinnerdiv">
                    <p>
                        <a title="Logout" href="#" onclick="logout('<?php echo $_SESSION[SESSION_USERID];?>', '<?php echo $_SESSION[SESSIONID];?>' )">
                            <span>LOGOUT</span>
                        </a>
                    </p>
                </div>
                <div class="username_secondinnerdiv">
                    <div class="logout_innerdiv">
                        <p>
                            <?PHP echo date("d-m-Y"); ?>
                        </p>
                        <p id="servertime"></p>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="single_remaining_qty" value="<?php echo (!empty($remainingSingleQty)?$remainingSingleQty:0); ?>">
        <input type="hidden" id="double_remaining_qty" value="<?php echo (!empty($remainingDoubleQty)?$remainingDoubleQty:0); ?>">
        <input type="hidden" id="triple_remaining_qty" value="<?php echo (!empty($remainingTripleQty)?$remainingTripleQty:0); ?>">
        <input type="hidden" id="activeClass" value="sangam_cont">
        <input type="hidden" id="siteUrl" value="<?= TM_SITE_URL?>" />
        <div class="wrapper-grid">
        <div class="opacity-wrapper" id="loading-img" style="display:none;">
            <div class="small-loading">
                <div class="load">
                <div class="loader animation-5">
                        <div class="shape shape1"></div>
                        <div class="shape shape2"></div>
                        <div class="shape shape3"></div>
                        <div class="shape shape4"></div>
                    </div>
                </div>
            </div>
        </div>
            <form method="post" id="ticketForm" class="form" action="ticketprocess.php">
                <input type="hidden" name="drawID" id="drawID" value="<?php echo $upcomingDraw[0]->DRAW_ID;?>" />
                <input type="hidden" name="drawName" id="drawName" value="<?php echo $upcomingDraw[0]->DRAW_NUMBER;?>" />
                <input type="hidden" name="drawPrice" id="drawPrice" value="<?php echo (!empty($drawPrice[0])?$drawPrice[0]:0);?>" />
                <input type="hidden" name="drawDateTime" id="drawDateTime" value="<?php echo $upcomingDraw[0]->DRAW_STARTTIME;?>" />
                <div class="middle-container">
                    <div class="middle_wrap" id="disable_inputs">
                        <div class="single" id="single_default">
                            <div class="single_div single_head">
                                <p class="single_div_p">Single</p>
                            </div>
                            <div class="single_div single_first_div centerElem1">
                                <p class="single_div_p_num">0</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_0" name="single[0]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">1</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_1" name="single[1]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">2</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_2" name="single[2]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">3</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_3" name="single[3]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">4</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_4" name="single[4]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">5</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_5" name="single[5]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">6</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_6" name="single[6]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">7</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_7" name="single[7]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div centerElem1">
                                <p class="single_div_p_num">8</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_8" name="single[8]" class="single_input">
                                </p>
                            </div>
                            <div class="single_div single_last_div centerElem1">
                                <p class="single_div_p_num">9</p>
                                <p class="single_div_p_input">
                                    <input type="text" maxlength="<?php echo $singleLength;?>" id="single_row_9" name="single[9]" class="single_input">
                                </p>
                            </div>
                        </div>
                        <div class="double">
                            <ul class="nav nav-tabs double_li" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="double-tab" data-toggle="tab" href="#double" role="tab" aria-controls="double" aria-selected="true">double</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="triple-tab" data-toggle="tab" href="#triple_default" role="tab" aria-controls="triple" aria-selected="false">triple</a>
                                </li>
                                <p class="qty">
                                <span class="qty-text">qty:</span> 
                                <span> 
                                <label class="container_checkbox"><span class="checkbox-number">2</span>
                                <input type="radio" name="qty" id="qty_2" value="2" checked="checked">
                                <span class="checkmark">
                                </span>
                                </label>
                                </span>
                                <span> 
                                <label class="container_checkbox"><span class="checkbox-number">4</span>
                                <input type="radio" name="qty" id="qty_4" value="4">
                                <span class="checkmark">
                                </span>
                                </label>
                                </span>
                                <span> 
                                <label class="container_checkbox"><span class="checkbox-number">5</span>
                                <input type="radio" name="qty" id="qty_5" value="5">
                                <span class="checkmark">
                                </span>
                                </label>
                                </span>
                                <span> 
                                <label class="container_checkbox"><span class="checkbox-number">10</span>
                                <input type="radio"  name="qty" id="qty_10" value="10">
                                <span class="checkmark">
                                </span>
                                </label>
                                </span>
                                <span> 
                                <label class="container_checkbox"><span class="checkbox-number">20</span>
                                <input type="radio" name="qty" id="qty_20" value="20">
                                <span class="checkmark">
                                </span>
                                </label>
                                </span>
                                <span> 
                                <label class="container_checkbox"><span class="checkbox-number">50</span>
                                <input type="radio" name="qty" id="qty_50" value="50" >
                                <span class="checkmark">
                                </span>
                                </label>
                                </span>
                            </p>
                            </ul>
                            <div class="tab-content myTabContent" id="myTabContent">
                                <div class="tab-pane fade show active" id="double" role="tabpanel" aria-labelledby="double-tab">
                                    <div class="double_checkbox_left">
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(0,9,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(10,19,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(20,29,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(30,39,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(40,49,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(50,59,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(60,69,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(70,79,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(80,89,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input_left">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickRowNumberTwo(90,99,this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="double_sub_li_div_main" id="two_default">
                                        <div class="double_sub_li centerElem">
                                            <?php 
                                            $count =$s=0;
                                            for($i=0; $i<=99; $i++) { $count=$count+1?>
                                            <div class="double_sub_li_div">
                                                <div>
                                                    <?php if ($i>=10) {?>
                                                    <p class="double_sub_li_p">
                                                        <?= $i; ?>
                                                    </p>
                                                    <p class="double_sub_li_input">
                                                        <input type="text" maxlength="<?php echo $doubleLength;?>" id="two_row_<?= $i; ?>" name="two[<?= $i; ?>]" class="two-chance">
                                                    </p>
                                                    <?php }else{ ?>
                                                    <p class="double_sub_li_p">
                                                        <?= '0'.$i; ?>
                                                    </p>
                                                    <p class="double_sub_li_input">
                                                        <input type="text" maxlength="<?php echo $doubleLength;?>" id="two_row_0<?= $i; ?>" name="two[0<?= $i; ?>]" class="two-chance">
                                                    </p>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <?php
                                            if($count==10){
                                              if($i!=99){
                                                echo '</div><div class="double_sub_li centerElem">';
                                              }
                                              $s+=$count;
                                              $count=0;
                                            }
                                          } ?>
                                        </div>
                                    </div>
                                    <div class="double_checkbox_below">
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('00',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('01',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('02',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('03',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('04',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('05',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('06',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('07',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('08',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="double_checkbox">
                                            <div class="double_checkbox_input">
                                                <label class="container_checkbox">
                                                    <input type="checkbox" onclick="randomPickEndedNumberTwo('09',this)">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="triple_default" role="tabpanel" aria-labelledby="triple-tab">
                                    <div class="triple_menu">
                                        <ul class="nav nav-tabs triple_li" id="myTab1" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="triple1-tab" data-toggle="tab" href="#triple1" role="tab" aria-controls="triple1" aria-selected="true"
                                                    onClick="tab_active('sangam_cont')">000</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple2-tab" data-toggle="tab" href="#triple2" role="tab" aria-controls="triple2" aria-selected="false"
                                                    onClick="tab_active('chetak_cont')">100</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple3-tab" data-toggle="tab" href="#triple3" role="tab" aria-controls="triple3" aria-selected="false"
                                                    onClick="tab_active('super_cont')">200</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple4-tab" data-toggle="tab" href="#triple4" role="tab" aria-controls="triple4" aria-selected="false"
                                                    onClick="tab_active('deluxe_cont')">300</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple5-tab" data-toggle="tab" href="#triple5" role="tab" aria-controls="triple5" aria-selected="false"
                                                    onClick="tab_active('bhagya_cont')">400</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple6-tab" data-toggle="tab" href="#triple6" role="tab" aria-controls="triple6" aria-selected="false"
                                                    onClick="tab_active('diamond_cont')">500</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple7-tab" data-toggle="tab" href="#triple7" role="tab" aria-controls="triple7" aria-selected="false"
                                                    onClick="tab_active('lucky_cont')">600</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple8-tab" data-toggle="tab" href="#triple8" role="tab" aria-controls="triple8" aria-selected="false"
                                                    onClick="tab_active('new1_cont')">700</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple9-tab" data-toggle="tab" href="#triple9" role="tab" aria-controls="triple9" aria-selected="false"
                                                    onClick="tab_active('new2_cont')">800</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="triple10-tab" data-toggle="tab" href="#triple10" role="tab" aria-controls="triple10" aria-selected="false"
                                                    onClick="tab_active('new3_cont')">900</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content myTabContent triple_checkbox_line" id="triple_tab">
                                        <div class="tab-pane fade show active" id="triple1" role="tabpanel" aria-labelledby="triple1-tab">
                                        <div class="double_checkbox_left">
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="double_checkbox">
                                                <div class="double_checkbox_input_left">
                                                    <label class="container_checkbox">
                                                        <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="double_sub_li_div_main_triple" id="sangam_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                    $count =$s=0;
                                                    for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '0'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="sangam_<?= $i; ?>" name="san[0<?= $i; ?>]" class="sangam">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                              <?= '00'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="sangam_<?= $i; ?>" name="san[00<?= $i; ?>]" class="sangam">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                          if($count==10){
                                                            if($i!=99){
                                                              echo '</div><div class="double_sub_li centerElem">';
                                                            }
                                                            $s+=$count;
                                                            $count=0;
                                                          }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple2" role="tabpanel" aria-labelledby="triple2-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="chetak_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                    $count =$s=0;
                                                    for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
																<p class="double_sub_li_p">
																	<?= '1'.$i; ?>
																</p>
																<p class="double_sub_li_input">
																	<input type="text" maxlength="<?php echo $tripleLength;?>" id="chetak_<?= $i; ?>" name="che[1<?= $i; ?>]" class="chetak">
																</p>
                                                            <?php }else{ ?>
																	<p class="double_sub_li_p">
																		<?= '10'.$i; ?>
																	</p>
																	<p class="double_sub_li_input">
																		<input type="text" maxlength="<?php echo $tripleLength;?>" id="chetak_<?= $i; ?>" name="che[10<?= $i; ?>]" class="chetak">
																	</p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                      if($count==10){
                                                        if($i!=99){
                                                          echo '</div><div class="double_sub_li centerElem">';
                                                        }
                                                        $s+=$count;
                                                        $count=0;
                                                      }
                                                  } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple3" role="tabpanel" aria-labelledby="triple3-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="super_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                      $count =$s=0;
                                                      for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '2'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="super_<?= $i; ?>" name="sup[2<?= $i; ?>]" class="super">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '20'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="super_<?= $i; ?>" name="sup[20<?= $i; ?>]" class="super">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if($count==10){
                                                      if($i!=99){
                                                        echo '</div><div class="double_sub_li centerElem">';
                                                      }
                                                      $s+=$count;
                                                      $count=0;
                                                    }
                                                  } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple4" role="tabpanel" aria-labelledby="triple4-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="deluxe_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                      $count =$s=0;
                                                      for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '3'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="deluxe_<?= $i; ?>" name="del[3<?= $i; ?>]" class="deluxe">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '30'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="deluxe_<?= $i; ?>" name="del[30<?= $i; ?>]" class="deluxe">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        if($count==10){
                                                          if($i!=99){
                                                            echo '</div><div class="double_sub_li centerElem">';
                                                          }
                                                          $s+=$count;
                                                          $count=0;
                                                        }
                                                      } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple5" role="tabpanel" aria-labelledby="triple5-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="bhagya_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                      $count =$s=0;
                                                      for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '4'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="bhagya_<?= $i; ?>" name="bha[4<?= $i; ?>]" class="bhagya">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '40'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="bhagya_<?= $i; ?>" name="bha[40<?= $i; ?>]" class="bhagya">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                      if($count==10){
                                                        if($i!=99){
                                                          echo '</div><div class="double_sub_li centerElem">';
                                                        }
                                                        $s+=$count;
                                                        $count=0;
                                                      }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple6" role="tabpanel" aria-labelledby="triple6-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="diamond_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                  $count =$s=0;
                                                  for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '5'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="diamond_<?= $i; ?>" name="dia[5<?= $i; ?>]" class="diamond">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '50'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="diamond_<?= $i; ?>" name="dia[50<?= $i; ?>]" class="diamond">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                      if($count==10){
                                                        if($i!=99){
                                                          echo '</div><div class="double_sub_li centerElem">';
                                                        }
                                                        $s+=$count;
                                                        $count=0;
                                                      }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple7" role="tabpanel" aria-labelledby="triple7-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="lucky_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                    $count =$s=0;
                                                    for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '6'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="lucky_<?= $i; ?>" name="luk[6<?= $i; ?>]" class="lucky">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '60'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="lucky_<?= $i; ?>" name="luk[60<?= $i; ?>]" class="lucky">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        if($count==10){
                                                          if($i!=99){
                                                            echo '</div><div class="double_sub_li centerElem">';
                                                          }
                                                          $s+=$count;
                                                          $count=0;
                                                        }
                                                      } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple8" role="tabpanel" aria-labelledby="triple8-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="new1_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                      $count =$s=0;
                                                      for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '7'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="new1_<?= $i; ?>" name="new1[7<?= $i; ?>]" class="new1">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '70'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="new1_<?= $i; ?>" name="new1[70<?= $i; ?>]" class="new1">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                      if($count==10){
                                                        if($i!=99){
                                                          echo '</div><div class="double_sub_li centerElem">';
                                                        }
                                                        $s+=$count;
                                                        $count=0;
                                                      }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple9" role="tabpanel" aria-labelledby="triple9-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="new2_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                    $count =$s=0;
                                                    for($i=0; $i<=99; $i++) { $count=$count+1?>

                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '8'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="new2_<?= $i; ?>" name="new2[8<?= $i; ?>]" class="new2">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '80'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="new2_<?= $i; ?>" name="new2[80<?= $i; ?>]" class="new2">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if($count==10){
                                                      if($i!=99){
                                                        echo '</div><div class="double_sub_li centerElem">';
                                                      }
                                                      $s+=$count;
                                                      $count=0;
                                                    }
                                                  } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="triple10" role="tabpanel" aria-labelledby="triple10-tab">
                                            <div class="double_checkbox_left">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(0,9,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(10,19,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(20,29,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(30,39,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(40,49,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(50,59,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(60,69,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(70,79,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(80,89,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input_left">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickRowNumber(90,99,this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="double_sub_li_div_main_triple" id="new3_cont">
                                                <div class="double_sub_li centerElem">
                                                    <?php 
                                                    $count =$s=0;
                                                    for($i=0; $i<=99; $i++) { $count=$count+1?>
                                                    <div class="double_sub_li_div">
                                                        <div>
                                                            <?php if ($i>=10) {?>
                                                            <p class="double_sub_li_p">
                                                                <?= '9'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="new3_<?= $i; ?>" name="new3[9<?= $i; ?>]" class="new3">
                                                            </p>
                                                            <?php }else{ ?>
                                                            <p class="double_sub_li_p">
                                                                <?= '90'.$i; ?>
                                                            </p>
                                                            <p class="double_sub_li_input">
                                                                <input type="text" maxlength="<?php echo $tripleLength;?>" id="new3_<?= $i; ?>" name="new3[90<?= $i; ?>]" class="new3">
                                                            </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                      if($count==10){
                                                        if($i!=99){
                                                          echo '</div><div class="double_sub_li centerElem">';
                                                        }
                                                        $s+=$count;
                                                        $count=0;
                                                      }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="double_checkbox_below">
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('00',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('01',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('02',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('03',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('04',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('05',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('06',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('07',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('08',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="double_checkbox">
                                                    <div class="double_checkbox_input">
                                                        <label class="container_checkbox">
                                                            <input type="checkbox" onclick="randomPickEndedNumber('09',this)">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <?php if( $_SESSION[SESSION_PRINTER_OPTION]==0) {?>
                            <div class="footer_left">
                        
                        <div class="footer_div">
                            <p class="footer_win" id="report">
                                <a id='report_modal' class="" data-toggle="modal">
                                  REPORT
                                </a>
                            </p>
                        </div>
                        <div class="footer_div">
                            <p class="footer_win" id="resultchat" class="" data-toggle="modal">
                            RESULT CHART
                            </p>
                        </div>
                        </div>
                        <div class="footer_right">
                        <div class="footer_div replay" id="clear">
                            <p class="footer_win">
                              CLEAR ALL
                            </p>
                        </div>
                        <div class="footer_div replay" id="repeat">
                            <p class="footer_win">REPEAT
                            </p>
                            <img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="repeat_loader" src="images/loader.gif">
                        </div>
                        <div class="footer_div replay" id="double_up">
                            <p class="footer_win">double up</p>
                        </div>
                        </div>
                        <!-- Report Modal -->
                        <div class="modal" id="myModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog1" role="document">
                                <div class="modal-content">
                                    <div class="modal-header popup_head">
                                        <button type="button" class="close close_btn mfp-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        Report
                                    </div>
                                    <div class="modal-body">
                                        <iframe id="cartoonVideo" width="100%" height="75%" src="<?php echo TM_SITE_URL; ?>gamehistory.php" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>   
                         <!-- Report Modal -->               
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#report_modal').click(function () {
                                    $("#loading-img").show();
                                    $.ajax({
                                        type: "POST",
                                        url: "authentication_ajax.php",
                                        data: { 'authentication': 'authentication' },
                                        cache: false,
                                        success: function (result) {
                                            $("#loading-img").hide();
                                            if (result == 1) {
                                                window.location.href = '<?php echo LOGIN_URL;?>';
                                            } else {
                                                $("#myModal").modal("show");
                                            }
                                        }
                                    });
                                });
                                function reload() {
                                    document.getElementById('cartoonVideo').src += '';
                                } report.onclick = reload;
                            });
                        </script>

                <?php }elseif( $_SESSION[SESSION_PRINTER_OPTION]==1){ ?>
                    <div class="footer_left">
                    <?php //if( $_SESSION[SESSION_MODE]==1){ ?>
                        <div class="footer_div" id="frmReprintTicket">
                            <p class="footer_win">
                                Reprint(F9)
                            </p>
                        </div>
                    <?php //} ?>
                        <div class="footer_div" id="frmCancelTicket">
                            <p class="footer_win">
                                Cancel(F8)
                            </p>
                        </div>
                       
                        <div class="footer_div" id="frmWinResults">
                            <p class="footer_win">
                                Result(F12)
                            </p>
                        </div>
                        <!--<div class="footer_div" id="frmResult">
                            <p class="footer_win">
                                Claim(F10)
                            </p>
                        </div>-->
                        </div>
                        <div class="footer_right">
                        <div class="footer_div replay" id="frmClear">
                            <p class="footer_win">
                                Clear All(F5)
                            </p>
                        </div>
                        <div class="footer_div replay"id="repeat">
                            <p class="footer_win">
                                Repeat(F7)
                            </p>
                            <img style="display: none;text-align: center;height: 26px;margin: 0 auto;" id="repeat_loader" src="images/loader.gif">
                        </div>
                        <div class="footer_div replay" id="double_up">
                            <p class="footer_win">double up</p>
                        </div>
                        </div>
                            
                        <?php } ?>
                    </div>
                </div>
            </form>
            <div class="triple_maza">
            <div class="triple_maza_innerdiv">
                <ul class="nav nav-tabs triple_maza_li" id="myTab2" role="tablist">
                   <!-- <li class="nav-item">
                        <a class="nav-link " id="triple-tab-maza" data-toggle="tab" href="#multiple" role="tab" aria-controls="multiple" aria-selected="true">multiple</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link active" id="tripletabcoupon-tab" data-toggle="tab" href="#tripletabcoupon" role="tab" aria-controls="tripletabcoupon"
                            aria-selected="false">coupon</a>
                    </li>
                </ul>
                <div class="tab-content myTabContent" id="myTabContent2">
                    <div class="tab-pane fade show " id="multiple" role="tabpanel" aria-labelledby="triple-tab-maza">

                        <div class="triple_maza_content">
                            <div class="triple_maza_div">
                            </div>
                            <div class="triple_maza_div_input">
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                                <div class="triple_maza_div_input_outline">

                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv single_active">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>
                                    <div class="triplediv">
                                        <p class="triple_div_p_num">4</p>
                                        <p class="triple_div_p_input">
                                            <input type="text" />
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <div class="triple_maza_div_combo">
                                <label class="container_checkbox">
                                    <span class="combo_text">Exact</span>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container_checkbox">
                                    <span class="combo_text">Any</span>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container_checkbox">
                                    <span class="combo_text">Combo</span>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container_checkbox">
                                    <span class="combo_text">Pair</span>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        <?php if( $_SESSION[SESSION_PRINTER_OPTION]==1){ 
                                   // if( $_SESSION[SESSION_MODE]==1){ ?>  
                                        <div class="buy_btn" id="buy" onClick="sendDataToFlash()">
                                            <p class="buy_btn_confirm">Print(F6)</p>
                                        </div> 
                                <?php /* }else { ?>
                                    <div class="buy_btn" id="buy" onclick="submitData()">
                                        <p class="buy_btn_confirm">buy</p>
                                    </div>
                                <?php } */?>
                        <?php }else { ?>
                            <div class="buy_btn" id="buy" onclick="submitData()">
                                <p class="buy_btn_confirm">buy</p>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="tripletabcoupon" role="tabpanel" aria-labelledby="tripletabcoupon-tab">
                        <div class="ticket_points">
                            <div class="ticket_points_inner_div">
                                <div class="summary_points">
                                    <div class="ticket_single" id="single_qty_amt" style="display:none">
                                        <div class="ticket_points_head_single">
                                            <p class="points_head_single">single</p>
                                            <div class="ticket_qty">
                                                <p class="number">Number</p>
                                                <p class="number">Qty</p>
                                                <p class="number">Point</p>
                                            </div>
                                        </div>
                                        <div class="ticket_info">
                                            <p class="number">0-9</p>
                                            <p class="number single_qty_div" id="single_qty">0</p>
                                            <p class="number single_amt_div" id="single_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                    </div>

                                    <div class="ticket_single" id="double_qty_amt" style="display:none">
                                        <div class="ticket_points_head_single">
                                            <p class="points_head_single">double</p>
                                            <div class="ticket_qty">
                                                <p class="number">Number</p>
                                                <p class="number">Qty</p>
                                                <p class="number">Point</p>
                                            </div>
                                        </div>
                                        <div class="ticket_info">
                                            <p class="number">00-99</p>
                                            <p class="number two_qty_div" id="two_qty">0</p>
                                            <p class="number two_amt_div" id="two_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                    </div>

                                    <div class="ticket_single" id="triple_qty_amt" style="display:none">
                                        <div class="ticket_points_head_single">
                                            <p class="points_head_single">triple</p>
                                            <div class="ticket_qty">
                                                <p class="number">Number</p>
                                                <p class="number">Qty</p>
                                                <p class="number">Point</p>
                                            </div>
                                        </div>
										<div class="triple_ticket_info">
                                        <div class="ticket_info" id="sangam_row" style="display:none">
                                            <p class="number">000-099</p>
                                            <p class="number triple_qty_div" id="sangam_qty">0</p>
                                            <p class="number triple_amt_div" id="sangam_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="chetak_row" style="display:none">
                                            <p class="number">100-199</p>
                                            <p class="number triple_qty_div" id="chetak_qty">0</p>
                                            <p class="number triple_amt_div" id="chetak_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="super_row" style="display:none">
                                            <p class="number">200-299</p>
                                            <p class="number triple_qty_div" id="super_qty">0</p>
                                            <p class="number triple_amt_div" id="super_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="deluxe_row" style="display:none">
                                            <p class="number">300-399</p>
                                            <p class="number triple_qty_div" id="deluxe_qty">0</p>
                                            <p class="number triple_amt_div" id="deluxe_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="bhagya_row" style="display:none">
                                            <p class="number">400-499</p>
                                            <p class="number triple_qty_div" id="bhagya_qty">0</p>
                                            <p class="number triple_amt_div" id="bhagya_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="diamond_row" style="display:none">
                                            <p class="number">500-599</p>
                                            <p class="number triple_qty_div" id="diamond_qty">0</p>
                                            <p class="number triple_amt_div" id="diamond_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="lucky_row" style="display:none">
                                            <p class="number">600-699</p>
                                            <p class="number triple_qty_div" id="lucky_qty">0</p>
                                            <p class="number triple_amt_div" id="lucky_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="new1_row" style="display:none">
                                            <p class="number">700-799</p>
                                            <p class="number triple_qty_div" id="new1_qty">0</p>
                                            <p class="number triple_amt_div" id="new1_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="new2_row" style="display:none">
                                            <p class="number">800-899</p>
                                            <p class="number triple_qty_div" id="new2_qty">0</p>
                                            <p class="number triple_amt_div" id="new2_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="ticket_info" id="new3_row" style="display:none">
                                            <p class="number">900-999</p>
                                            <p class="number triple_qty_div" id="new3_qty">0</p>
                                            <p class="number triple_amt_div" id="new3_amt">0</p>
                                            <!--<i class="fa fa-times-circle" aria-hidden="true"></i>-->
                                        </div>
                                        <div class="total_sel" id="total_row" style="display:none">
                                            <div class="ticket_2">Total</div>
                                            <div class="qty_2" id="triple_qty">0</div>
                                            <div class="value_2" id="triple_amt">0</div>
                                          </div>
										</div>
										  
                                    </div>
                                </div>
                                <div class="quantity_btn">
                                    <p class="quantity_btn_points">Quantity :<span id="overall_qty">0</span> </p>
                                </div>
                                <div class="total-points">
                                    <p class="total-points-btn">Total points</p>
                                    <p class="total-points-btn-value" id="overall_total">0</p>
                                </div>
                            </div>
                            <?php if( $_SESSION[SESSION_PRINTER_OPTION]==1){ 
                                        //if( $_SESSION[SESSION_MODE]==1){ ?>  
                                            <div class="buy_btn" id="buy" onClick="sendDataToFlash()">
                                                <p class="buy_btn_confirm">Print(F6)</p>
                                            </div> 
                                    <?php /*}else { ?>
                                        <div class="buy_btn" id="buy" onclick="submitData()">
                                            <p class="buy_btn_confirm">buy</p>
                                        </div>
                                    <?php } */
                            }else { ?>
                            <div class="buy_btn" id="buy" onclick="submitData()">
                                <p class="buy_btn_confirm">buy</p>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    
    

    <div id="rm_alert_popup" data-backdrop="static" class="modal">
        <div class="rm_popup">
            <div class="modal-dialog3 modal-md balance_popup">
                <div class="modal-content">
                    <div class="modal-header popup_head">
                        <button type="button" class="close close_btn mfp-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        Coupon Availability(Coupon - Quantity)
                    </div>
                    <div class="modal-body">
                        <div class="rm-alert" id="single_result">
                            <div>SINGLE -</div>
                            <div class="alert_msg_1">
                                <div id="rm_error1" style="padding: 8px 0;"></div>
                                <div class="remain_alert" id="serr1"></div>
                                <div class="rem_bal1" id="suc_val1"></div>
                                <div class="remain_alert" id="err1"></div>
                                <div class="rem_bal" id="err_val1"></div>
                            </div>
                        </div>
                        <div class="rm-alert" id="double_result">
                            <div>DOUBLE -</div>
                            <div class="alert_msg_1">
                                <div id="rm_error2" style="padding: 8px 0;"></div>
                                <div class="remain_alert" id="serr2"></div>
                                <div class="rem_bal1" id="suc_val2"></div>
                                <div class="remain_alert" id="err2"></div>
                                <div class="rem_bal" id="err_val2"></div>
                            </div>
                        </div>
                        <div class="rm-alert" id="triple_result">
                            <div>TRIPLE -</div>
                            <div class="alert_msg_1">
                                <div id="rm_error3" style="padding: 8px 0;"></div>
                                <div class="remain_alert" id="serr3"></div>
                                <div class="rem_bal1" id="suc_val3"></div>
                                <div class="remain_alert" id="err3"></div>
                                <div class="rem_bal" id="err_val3"></div>
                            </div>
                        </div>
                        <!--<div class="popup_cls_btn">
                            <button type="button" class="" data-dismiss="modal" aria-hidden="true">close</button>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
		<?php if( $_SESSION[SESSION_PRINTER_OPTION]==1){ ?> 
		<!-- Claim modal -->
		<div class="modal" id="small-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog2 modal-dialog-centered" role="document">
				<div class="modal-content">
				<div class="modal-header popup_head">
					
					<button type="button" class="close close_btn mfp-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>CLAIM
				</div>
				<div class="modal-body">
					<table class="claim_table" style="width: 100%;">
						<tbody>
							<tr>
							<td style="position: relative;">
								<label>Game No:</label>
								<input name="chkResult" id="chkResult" class="InputDraw terminal_input" value="" onchange="chkTicketResult(this.value)" tabindex="2" maxlength="12">
							</td></tr><tr>
							<td> 
								<label>Game No: </label>
								<span class="game_no_1" id="game_no"></span> 
								
								<label>Win No: </label>
								<span class="game_no_1" id="winNumber"></span>
								
								<label>Game Status: </label>
								<span class="game_no_1" id="drawStatus"></span> 
							</td>
							</tr>
							<tr>
							<td>
								<table class="win_no" id="win_no" style="display: none;">
								</table>
							</td>
							</tr>
							<tr>
							</tr>
						</tbody>
					</table>
				</div>
				</div>
			</div>
		</div>
		<!-- Claim modal -->

		<!-- Reprint modal -->
		<div class="modal" id="fp-dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:none">
			<div class="modal-dialog2 modal-dialog-centered terminal1" role="document">
				<div class="modal-content">
				<div class="modal-header popup_head">
					<button type="button" class="close close_btn mfp-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>TERMINAL PASSWORD
				</div>
				<div class="alert alert-danger" style="display: none" id="tp-msg"></div>
					<form action="#" id="tp_pwd">
						<div class="modal-body">
							<input type="password" name="userTranspass" id="userTranspass" class="terminal_input" placeholder="password" required tabindex="6">
							<input type="hidden" name="action" value="reprint">
						</div>
					<div class="modal-footer">
						<div class="footer_div">
							<p class="footer_win">
								<input type="button" value="SUBMIT" id="tp_btn" class="btn btn-primary terminal_submit" onClick="updateTicketREPRINTStatus()">
								<img style="display: none; text-align: center; height: 26px"id="loader" src="images/loader.gif" />
							</p>
						</div>
							
							
						</div>
					</form>
				</div>
			</div>
		</div>

	<!-- Reprint modal -->
	<!-- Cancel modal -->
	<div class="modal" id="fp-dialog1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:none">
		<div class="modal-dialog2 modal-dialog-centered terminal1" role="document">
			<div class="modal-content">
			<div class="modal-header popup_head">
				<button type="button" class="close close_btn mfp-close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>TERMINAL PASSWORD
			</div>
			<div class="alert alert-danger" style="display: none" id="tp-msg1"></div>
				<form action="#" id="tp_pwd1">
					<div class="modal-body">
						<input type="password" name="userTranspassCancel" id="userTranspassCancel" placeholder="password" class="InputDrawPopup terminal_input" value="" required>
						<input type="hidden" name="action" value="cancel">
					</div>
					<div class="modal-footer">
					<div class="footer_div">
							<p class="footer_win">
								  <input type="button" value="SUBMIT" id="tp_btn1" class="btn btn-primary terminal_submit" onClick="updateTicketCANCELStatus()">
						<img style="display: none; text-align: center; height: 26px" id="loader1" src="images/loader.gif" />
					</p>
						</div>
					  </div>
				</form>
			</div>
		</div>
	</div>
	<!-- Cancel modal -->
	<?php } ?>
    <!-- privious result Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="small-dialog3">
        <div class="modal-dialog modal-dialog1" role="document">
            <div class="modal-content">
            <div class="modal-header popup_head">
                <button type="button" class="close close_btn mfp-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>Previous Result
            </div>
            <div class="modal-body previous_body" id="modal_body">
            </div>
            </div>
        </div>
    </div>
    <!--privious result -->
</div>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.countdown.js"></script>
<script src="js/TweenMax.min.js"></script>
<script type="text/javascript">

    /*** date and time display start */
    var currenttime = '<?php echo $dbTime; ?>';
    // var currenttime1 = '<?=  date("Y-m-d H:i:s")?>';
    var montharray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
    var serverdate = new Date(currenttime);
    //console.log(currenttime1);
    //console.log(serverdate);
    function padlength(what) {
        var output = (what.toString().length == 1) ? "0" + what : what
        return output
    }

    function displaytime() {
        var hours = serverdate.getHours();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'

        serverdate.setSeconds(serverdate.getSeconds() + 1)
        var timestring = hours + ":" + padlength(serverdate.getMinutes()) + ":" + padlength(serverdate.getSeconds())
        document.getElementById("servertime").innerHTML = timestring + ' ' + ampm;

        /* serverdate.setSeconds(serverdate.getSeconds()+1)
        var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
        document.getElementById("servertime").innerHTML=timestring; */
    }

    window.onload = function () {
        setInterval("displaytime()", 1000);
    }
    /*** date and time display end** countdown timer start  */
    
    var preloadeOnResize = function (e) {
        var elWidth = 1920;
        var elHeight = 1080;
        var scale;
        var bodyWidth = window.innerWidth || document.documentElement.clientWidth ||
            document.body.clientWidth || document.body.offsetWidth;
        var bodyHeight = window.innerHeight || document.documentElement.clientHeight ||
            document.body.clientHeight || document.body.offsetHeight;
        scale = Math.min(
            bodyWidth / elWidth,
            bodyHeight / elHeight
        );
        document.getElementById("wrapper").style.transform = "translate(-50%, -50%) scale(" + scale + ")";

    };
    preloadeOnResize(null);
    window.addEventListener("resize", preloadeOnResize);


    $(function () {
        $('#ndrawLeftTime').html('00:00:00');
        var timeLeft = '';
        <?php if (!empty($drawCountDownTime)) { ?>
        timeLeft = new Date(<?php echo $drawCountDownTime;?>); //2016,0,06,11,56,01
        //$('#ndrawLeftTime').countdown({until: timeLeft,serverSync: serverTime, format: 'HMS', padZeroes: true, compact: true,onExpiry: liftOff});
        $('#ndrawLeftTime').countdown({
            until: timeLeft,
            serverSync: serverTime,
            format: 'HMS',
            padZeroes: true,
            compact: true,
            timezone: +5.5,
            //onExpiry: liftOff,
            onTick: function (periods) {
                var secs = $.countdown.periodsToSeconds(periods);
                if (secs < 60) {
                    $('#ndrawLeftTime span').addClass('text_blink');
                }
            }
        });
        <?php }?>
    });	

    var container = $(".result_container"),
    div1 = $(".div1"),
    tweenForward, tweenBack;

    TweenMax.set(container, {
        transformStyle: 'preserve-3d'
    });

    $.each(div1, function(index, element) {
        TweenMax.to(element, 0, {
            rotationX: (36 * index),
            transformOrigin: '100% 100% -500px'
        });
    });

    var tweenComplete = function() {
        createNumTween();
    }

    var createNumTween = function() {
        TweenLite.to(container, 0.25, {
            rotationX: '-=500',
            transformOrigin: '100% 100% -500px',
            //delay: 0.01,
            //ease: Power3.easeInOut,
            onComplete: tweenComplete
        });
    };

    // start the whole thing
    TweenLite.delayedCall(0.25, createNumTween);

    $(document).ready(function () {
        $('#load').hide();
        /** triple betting **/
        function navigate(origin, sens) {
            var inputs = $('.centerElem').find('input:enabled');
            var index = inputs.index(origin);
            index += sens;
            if (index < 0) {
                index = inputs.length - 1;
            }
            if (index > inputs.length - 1) {
                index = 0;
            }
            inputs.eq(index).focus();
        }

        $('input').keydown(function (e) {
            if (e.keyCode == 37) {
                navigate(e.target, -1);
            } else if (e.keyCode == 39) {
                navigate(e.target, 1);
            } else if (e.which == 40) { // down arrow
                $(this).closest('div.centerElem').next().find('div:eq(' + $(this).closest('div').index() + ')').find('input[type="text"]').focus();
            } else if (e.which == 38) { // up arrow
                $(this).closest('div.centerElem').prev().find('div:eq(' + $(this).closest('div').index() + ')').find('input[type="text"]').focus();
            }
        });

        /** single beting */
        function navigate1(origin, sens) {
            var inputs = $('.centerElem1').find('input:enabled');
            var index = inputs.index(origin);
            index += sens;
            if (index < 0) {
                index = inputs.length - 1;
            }
            if (index > inputs.length - 1) {
                index = 0;
            }
            inputs.eq(index).focus();
        }

        $('#single_default input').keyup(function (e) {
            if (e.keyCode == 37) {
                navigate1(e.target, -1);
            } else if (e.keyCode == 39) {
                navigate1(e.target, 1);
            } else if (e.which == 40) { // down arrow
                navigate1(e.target, 1);
                //$(this).closest('div.one_sec_1').next().find('div:eq(' + $(this).closest('div').index() + ')').find('input[type="text"]').focus();
            } else if (e.which == 38) { // up arrow
                navigate1(e.target, -1);
                //$(this).closest('div.one_sec_2').prev().find('div:eq(' + $(this).closest('div').index() + ')').find('input[type="text"]').focus();
            }
        });
        /** up, down,right and left key functionality end */
        /** disconnection  */
        $('#disconnect_btn').click(function(){
            $('#disconnect_btn').hide();
            $('#disconnect_loader').show();
            window.location.href = "index.php";
        });
    });
</script>
</body>
<script src="js/dashboard.js?v=<?php echo $version ;?>"></script>
<?php if ($_SESSION[SESSION_PRINTER_OPTION]==1){?>
<script src="js/terminalvalidation.js?v=<?php echo $version ;?>" type="text/javascript"></script>
<?php } else {?>
<script src="js/uservalidation.js??v=<?php echo $version ;?>" type="text/javascript"></script>
<?php }?>
<script src="js/socket.js?v=<?php echo $version ;?>"></script>

</html>