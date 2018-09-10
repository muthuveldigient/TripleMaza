<?php 
session_start();
	include_once("include/DbConnect.php");
	include_once("include/DbPdoConnect.php");
	include_once("include/clsLotto.php");
	include_once("include/functions.php");
	$objLotto =  new clsLotto();
	$newBetData=""; $genAllBetData=""; $newBetIndex=""; $snoData=0;
	if($_REQUEST["action"]=="print" && !empty($_REQUEST['pid'])) { ?>
	
		<!DOCTYPE html>
		<html>
		   <head> <!--<title>LIVE TC</title>-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0">
			  <style>
				 
				 @font-face {
	font-family: 'IDAHC39M Code 39 Barcode';
	src: url('./fonts/IDAHC39MCode39Barcode.eot');
	src: url('./fonts/IDAHC39MCode39Barcode.eot?#iefix') format('embedded-opentype'),
		url('./fonts/IDAHC39MCode39Barcode.woff') format('woff'),
		url('./fonts/IDAHC39MCode39Barcode.ttf') format('truetype');
	font-weight: normal;
	font-style: normal;
}

				 body{text-align:center;float: right;width: 180px;font-size: 10px;}
				 p{margin:0;}
				 p.serif {font-family: 'IDAHC39M Code 39 Barcode';}
				 p.sansserif {font-family: Arial, Helvetica, sans-serif;}
				 body{text-align:center;}
				 .list_pts{list-style: none;padding: 0;margin: 7px 0;}
				 .list_pts li{display: inline-block;font-size: 10px;margin: 0 10px;font-weight: 600;}
				 .head_top {font-size: 12px;font-weight: 600;}
				 .head_1 {font-size: 16px;font-weight: 600;}
				 .head_2 {font-size: 14px;font-weight: 600;}
				 .barcode_1{font-size:13px;margin: 10px 0;}
				 .barcode_ref{font-size:12px;}
				 .table_1{margin: 0 auto;font-weight: 600;}
				 .table_2{width: 100%;font-weight: 600;}
				 .tab_1 div {width: 15.66%;display: inline-block;}
				 p.game_name {
					font-size: 12px;
					font-weight: bold;
					margin-top: 10px;
					text-decoration: underline;
					font-weight: 600;
				}
				.game_no,.dateInfo{
					  font-weight: 600;
				}
			  </style>
		   </head>
		   <body>
				<!--<p class="head_1">TRIPLE MAZA</p>-->
				<p class="head_top">(For Amusement Only)</p>
				<!-- <div>
				 <p class="serif barcode_1">For Amusement</p>
				</div> -->
				
	<?php	$lPlayGroupID = $_REQUEST['pid'];
		$getPlayGroupData=$objLotto->getPlayGroupData($lPlayGroupID);
		$i=1;
		$j=1;
		$k=1;
		$s=1;
		foreach($getPlayGroupData as $pIndex=>$playData) {
				//$game = constant('GAME_'.$playData->GAME_TYPE_ID);
				$userBetType = $playData->BET_TYPE;
				$drawNamePrint= substr($playData->DRAW_NUMBER,strlen($playData->DRAW_NUMBER)-5,5);
				$drawDateTimePrint =date('d/m/Y h:i A',strtotime($playData->DRAW_STARTTIME));
				$price = $playData->DRAW_PRICE;
				$totelBet =  $playData->TOTAL_BET; 
				$playGroupId = $playData->PLAY_GROUP_ID;
				$refNo= $playData->INTERNAL_REFERENCE_NO;
					if($k==1){
				?>
					
						<div>
						 <p class="serif barcode_1" style="margin-bottom:0;">(<?php echo $refNo;?>)</p>
						</div>
			<?php	}
			if($userBetType==1){
				$fSno=1; $fTotalQty=0;
					$betIndexString1=explode(",",$playData->BET_NUMBER);
					$betValueString1=explode(",",$playData->BET_AMOUNT_VALUE);
				if($s==1){
					$s++;
			?>
				
				<p class="head_2">SINGLE</p>
				<p class="game_no">#<?= $drawNamePrint."-/".$drawDateTimePrint;?></p>
				<!--<div>
				 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
				</div>-->
				<?php } ?>	
			<div class="table_1">
				<div class="tab_1">
					  <div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>| 
					 <?php
					 $countNo2 = count($betIndexString1);
					 
					 $betString = "";
					 if( ( $countNo2%3 )==1){
						 $betString = "|<div>--</div><div>--</div>|<div>--</div><div>--</div>|";
					 }elseif( ( $countNo2%3 )==2){
						  $betString = "|<div>--</div><div>--</div>|";
					 }
					 
					 foreach($betIndexString1 as $fBetIndex=>$fBetData) {
						if($fSno==1) {
							$fBetsValuesString="<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						} else {
							$fBetsValuesString=$fBetsValuesString."|<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						}
						$fTotalQty=$fTotalQty+$betValueString1[$fBetIndex];
						$fSno++;
					}
					echo $fBetsValuesString.$betString;
					?>
					 
				 </div>
			</div>
			  <div>
				 <ul class="list_pts">
					<li>Points:<?= $price; ?></li>
					<li>Qty: <?= $fTotalQty; ?></li>
					<li>Total: <?= $fTotalQty*$price;?> Pts</li>
				 </ul>
			  </div>
	<?php }elseif($userBetType==2){ 
				$fSno=1; $fTotalQty=0;
					$betIndexString1=explode(",",$playData->BET_NUMBER);
					$betValueString1=explode(",",$playData->BET_AMOUNT_VALUE);
				if($i==1){
					$i++;
			?>
				<p class="head_2">DOUBLE</p>
				<p class="game_no">#<?= $drawNamePrint."-/".$drawDateTimePrint;?></p>
				<!--<div>
				 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
				</div>-->
				<?php } ?>	
			<div class="table_1">
				<div class="tab_1">
					  <div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>| 
					 <?php
					 $countNo = count($betIndexString1);
					 
					 $betString = "";
					 if( ( $countNo%3 )==1){
						 $betString = "|<div>--</div><div>--</div>|<div>--</div><div>--</div>|";
					 }elseif( ( $countNo%3 )==2){
						  $betString = "|<div>--</div><div>--</div>|";
					 }
					 
					 foreach($betIndexString1 as $fBetIndex=>$fBetData) {
						if($fSno==1) {
							$fBetsValuesString="<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						} else {
							$fBetsValuesString=$fBetsValuesString."|<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						}
						$fTotalQty=$fTotalQty+$betValueString1[$fBetIndex];
						$fSno++;
					}
					echo $fBetsValuesString.$betString;
					?>
					 
				 </div>
			</div>
			  <div>
				 <ul class="list_pts">
					<li>Points:<?= $price; ?></li>
					<li>Qty: <?= $fTotalQty; ?></li>
					<li>Total: <?= $fTotalQty*$price;?> Pts</li>
				 </ul>
			  </div>
	<?php }elseif($userBetType==3){ 
				$fSno1=1; $fTotalQty1=0;
					$betIndexString2=explode(",",$playData->BET_NUMBER);
					$betValueString2=explode(",",$playData->BET_AMOUNT_VALUE);
				if($j==1){
					$j++;
			?>
				<p class="head_2">TRIPLE</p>
				<p class="game_no">#<?= $drawNamePrint."-/".$drawDateTimePrint;?></p>
				<!--<div>
				 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
				</div>-->
				<?php } ?>	
			<div class="table_1">
				<div class="tab_1">
					  <div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|
					 <?php
					 
					 $countNo1 = count($betIndexString2);
					 $betString1 = "";
					 if( ( $countNo1 %3 )==1){
						 $betString1 = "|<div>--</div><div>--</div>|<div>--</div><div>--</div>|";
					 }elseif(( $countNo1 %3 ) ==2){
						  $betString1 = "|<div>--</div><div>--</div>|";
					 }
					 
					 foreach($betIndexString2 as $fBetIndex1=>$fBetData1) {
						if($fSno1==1) {
							$fBetsValuesString1="<div>".$fBetData1."</div><div>".$betValueString2[$fBetIndex1]."</div>";
						} else {
							$fBetsValuesString1=$fBetsValuesString1."|<div>".$fBetData1."</div><div>".$betValueString2[$fBetIndex1]."</div>";
						}
						$fTotalQty1=$fTotalQty1+$betValueString2[$fBetIndex1];
						$fSno1++;
					}
					echo $fBetsValuesString1.$betString1;
					?>
					 
				 </div>
			</div>
			  <div>
				 <ul class="list_pts">
					<li>Points:<?= $price; ?></li>
					<li>Qty: <?= $fTotalQty1; ?></li>
					<li>Total: <?= $fTotalQty1*$price;?> Pts</li>
				 </ul>
			  </div>
		<?php	}
			$k++;
		}?>
		
		  <p class="dateInfo"><?= date('d/m/Y h:i:s A'); ?></p>
		  <!--<div>
			 <p class="serif barcode_1" style="margin-bottom:0;"><? //= $refNo;?></p>
			 <p class="barcode_ref"><? //= $refNo;?></p>
		  </div>-->
	   </body>
	</html>
		
<?php	}
	if($_REQUEST["action"]=="reprint") {
		$getLastTicketInfo=$objLotto->getLastOneTicketInfo($arrGameCodes[0]);
		$lPlayGroupID=$getLastTicketInfo[0]->PLAY_GROUP_ID;
		$getDrawStatus=$objLotto->getDrawStatus($getLastTicketInfo[0]->DRAW_ID);
		$drawStatus=$getDrawStatus[0]->DRAW_STATUS;
		//echo'<pre>';print_r($getLastTicketInfo);exit;
		?>
			
		<!DOCTYPE html>
		<html>
		   <head> <!--<title>TRIPLE MAZA</title>-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0">
			<style>
				 
				 @font-face {
						font-family: 'IDAHC39M Code 39 Barcode';
						src: url('./fonts/IDAHC39MCode39Barcode.eot');
						src: url('./fonts/IDAHC39MCode39Barcode.eot?#iefix') format('embedded-opentype'),
							url('./fonts/IDAHC39MCode39Barcode.woff') format('woff'),
							url('./fonts/IDAHC39MCode39Barcode.ttf') format('truetype');
						font-weight: normal;
						font-style: normal;
					}

				 body{text-align:center;float: right;width: 180px;font-size: 10px;}
				 p{margin:0;}
				 p.serif {font-family: 'IDAHC39M Code 39 Barcode';}
				 p.sansserif {font-family: Arial, Helvetica, sans-serif;}
				 body{text-align:center;}
				 .list_pts{list-style: none;padding: 0;margin: 7px 0;}
				 .list_pts li{display: inline-block;font-size: 10px;margin: 0 10px;font-weight: 600;}
				 .head_top {font-size: 12px;font-weight: 600;}
				 .head_1 {font-size: 16px;font-weight: 600;}
				 .head_2 {font-size: 14px;font-weight: 600;}
				 .barcode_1{font-size:13px;margin: 10px 0;}
				 .barcode_ref{font-size:12px;}
				 .table_1{margin: 0 auto;font-weight: 600;}
				 .table_2{width: 100%;font-weight: 600;}
				 .tab_1 div {width: 15.66%;display: inline-block;}
				 p.game_name {
					font-size: 12px;
					font-weight: bold;
					margin-top: 10px;
					text-decoration: underline;
					font-weight: 600;
				}
				.game_no,.dateInfo{
					  font-weight: 600;
				}
			  </style>
		   </head>
		   <body>
			<p class="head_1">Copy</p>
				<!--<p class="head_1">LIVE TC</p>-->
				<p class="head_top">(For Amusement Only)</p>
				<!-- <div>
				 <p class="serif barcode_1">For Amusement</p>
				</div> -->
				
	<?php	
		$getPlayGroupData=$objLotto->getPlayGroupData($lPlayGroupID);
		
		$i=1;
		$j=1;
		$k=1;
		$s=1;
		foreach($getPlayGroupData as $pIndex=>$playData) {
				//$game = constant('GAME_'.$playData->GAME_TYPE_ID);
				$userBetType = $playData->BET_TYPE;
				$drawNamePrint= substr($playData->DRAW_NUMBER,strlen($playData->DRAW_NUMBER)-5,5);
				$drawDateTimePrint =date('d/m/Y h:i A',strtotime($playData->DRAW_STARTTIME));
				$price = $playData->DRAW_PRICE;
				$totelBet =  $playData->TOTAL_BET; 
				$playGroupId = $playData->PLAY_GROUP_ID;
				$refNo= $playData->INTERNAL_REFERENCE_NO;
					if($k==1){
				?>
					
						<div>
						 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
						</div>
			<?php	}
			
			
			if($userBetType==1){
				$fSno=1; $fTotalQty=0;
					$betIndexString1=explode(",",$playData->BET_NUMBER);
					$betValueString1=explode(",",$playData->BET_AMOUNT_VALUE);
				if($s==1){
					$s++;
			?>
				<p class="head_2">SINGLE</p>
				<p class="game_no">#<?= $drawNamePrint."-/".$drawDateTimePrint;?></p>
				<!--<div>
				 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
				</div>-->
				<?php } ?>	
			<div class="table_1">
				<div class="tab_1">
					  <div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>| 
					 <?php
					 $countNo2 = count($betIndexString1);
					 
					 $betString = "";
					 if( ( $countNo2%3 )==1){
						 $betString = "|<div>--</div><div>--</div>|<div>--</div><div>--</div>|";
					 }elseif( ( $countNo2%3 )==2){
						  $betString = "|<div>--</div><div>--</div>|";
					 }
					 
					 foreach($betIndexString1 as $fBetIndex=>$fBetData) {
						if($fSno==1) {
							$fBetsValuesString="<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						} else {
							$fBetsValuesString=$fBetsValuesString."|<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						}
						$fTotalQty=$fTotalQty+$betValueString1[$fBetIndex];
						$fSno++;
					}
					echo $fBetsValuesString.$betString;
					?>
					 
				 </div>
			</div>
			  <div>
				 <ul class="list_pts">
					<li>Points:<?= $price; ?></li>
					<li>Qty: <?= $fTotalQty; ?></li>
					<li>Total: <?= $fTotalQty*$price;?> Pts</li>
				 </ul>
			  </div>
	<?php }elseif($userBetType==2){ 
				$fSno=1; $fTotalQty=0;
					$betIndexString1=explode(",",$playData->BET_NUMBER);
					$betValueString1=explode(",",$playData->BET_AMOUNT_VALUE);
				if($i==1){
					$i++;
			?>
				<p class="head_2">DOUBLE</p>
				<p class="game_no">#<?= $drawNamePrint."-/".$drawDateTimePrint;?></p>
				<!--<div>
				 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
				</div>-->
				<?php } ?>	
			<div class="table_1">
				<div class="tab_1">
					  <div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>| 
					 <?php
					 $countNo = count($betIndexString1);
					 
					 $betString = "";
					 if( ( $countNo%3 )==1){
						 $betString = "|<div>--</div><div>--</div>|<div>--</div><div>--</div>|";
					 }elseif( ( $countNo%3 )==2){
						  $betString = "|<div>--</div><div>--</div>|";
					 }
					 
					 foreach($betIndexString1 as $fBetIndex=>$fBetData) {
						if($fSno==1) {
							$fBetsValuesString="<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						} else {
							$fBetsValuesString=$fBetsValuesString."|<div>".$fBetData."</div><div>".$betValueString1[$fBetIndex]."</div>";
						}
						$fTotalQty=$fTotalQty+$betValueString1[$fBetIndex];
						$fSno++;
					}
					echo $fBetsValuesString.$betString;
					?>
					 
				 </div>
			</div>
			  <div>
				 <ul class="list_pts">
					<li>Points:<?= $price; ?></li>
					<li>Qty: <?= $fTotalQty; ?></li>
					<li>Total: <?= $fTotalQty*$price;?> Pts</li>
				 </ul>
			  </div>
	<?php }elseif($userBetType==3){ 
				$fSno1=1; $fTotalQty1=0;
					$betIndexString2=explode(",",$playData->BET_NUMBER);
					$betValueString2=explode(",",$playData->BET_AMOUNT_VALUE);
				if($j==1){
					$j++;
			?>
				<p class="head_2">TRIPLE</p>
				<p class="game_no">#<?= $drawNamePrint."-/".$drawDateTimePrint;?></p>
				<!--<div>
				 <p class="serif barcode_1" style="margin-bottom:0;">(<?=$refNo;?>)</p>
				</div>-->
				<?php } ?>	
			<div class="table_1">
				<div class="tab_1">
					  <div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|<div>Num</div><div>qty</div>|
					 <?php
					 
					 $countNo1 = count($betIndexString2);
					 $betString1 = "";
					 if( ( $countNo1 %3 )==1){
						 $betString1 = "|<div>--</div><div>--</div>|<div>--</div><div>--</div>|";
					 }elseif(( $countNo1 %3 ) ==2){
						  $betString1 = "|<div>--</div><div>--</div>|";
					 }
					 
					 foreach($betIndexString2 as $fBetIndex1=>$fBetData1) {
						if($fSno1==1) {
							$fBetsValuesString1="<div>".$fBetData1."</div><div>".$betValueString2[$fBetIndex1]."</div>";
						} else {
							$fBetsValuesString1=$fBetsValuesString1."|<div>".$fBetData1."</div><div>".$betValueString2[$fBetIndex1]."</div>";
						}
						$fTotalQty1=$fTotalQty1+$betValueString2[$fBetIndex1];
						$fSno1++;
					}
					echo $fBetsValuesString1.$betString1;
					?>
					 
				 </div>
			</div>
			  <div>
				 <ul class="list_pts">
					<li>Points:<?= $price; ?></li>
					<li>Qty: <?= $fTotalQty1; ?></li>
					<li>Total: <?= $fTotalQty1*$price;?> Pts</li>
				 </ul>
			  </div>
		<?php	}
			$k++;
		}?>
		
		  <p class="dateInfo"><?= date('d/m/Y h:i:s A'); ?></p>
		  <!--<div>
			 <p class="serif barcode_1" style="margin-bottom:0;"><? //= $refNo;?></p>
			 <p class="barcode_ref"><? //= $refNo;?></p>
		  </div>-->
	   </body>
	</html>
	<?php
	}
?>