<?PHP define("RELEASE_DATE","13-03-2015 09:30:00"); ?>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<script>
function showdaterange(vid){
	if(vid!=''){
	  var sdate='';
	  var edate='';
	  if(vid=="1"){
		  sdate='<?php echo date("d-m-Y 00:00:00");?>';
		  edate='<?php echo date("d-m-Y 23:59:59");?>';
	  }
	  if(vid=="2"){
		  <?php
		  $yesterday=date('d-m-Y',strtotime("-1 days"));?>
		  sdate='<?php echo $yesterday;?>'+' 00:00:00';
		  edate='<?php echo $yesterday;?>'+' 23:59:59';
	  }
	  if(vid=="3"){
		  <?php
		  $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
		  ?>
		  //alert('<?php echo $sweekday;?>');
		  sdate='<?php echo $sweekday;?>'+' 00:00:00';
		  edate='<?php echo date("d-m-Y");?>'+' 23:59:59';
	  }
	  if(vid=="4"){
		 <?php
		  $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
		  $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
		  $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
		  ?>
		  sdate='<?php echo $slastweekday;?>'+' 00:00:00';
		  edate='<?php echo $slastweekeday;?>'+' 23:59:59';
	  }
	  if(vid=="5"){
		  <?php
		  $tmonth=date("m");
		  $tyear=date("Y");
		  $tdate="01-".$tmonth."-".$tyear." 00:00:00";
		  $lday=date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear." 23:59:59";
		  //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
		  ?>
		  sdate='<?php echo $tdate;?>';
		  edate='<?php echo $lday;?>';
	  }
	  if(vid=="6"){
		  <?php
		  $tmonth=date("m");
		  $tyear=date("Y");
		  $tdate=date("01-m-Y", strtotime("-1 month"))." 00:00:00";
		  $lday=date("t-m-Y", strtotime("-1 month"))." 23:59:59";
		  
		  //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
		  ?>
		  sdate='<?php echo $tdate;?>';
		  edate='<?php echo $lday;?>';
	  }
	  document.getElementById("START_DATE_TIME").value=sdate;
	  document.getElementById("END_DATE_TIME").value=edate;
	}
}
</script>
<script language="javascript">
function NewWindow(mypage,myname,w,h,scroll){
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage,myname,settings);
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<?php if(!empty($searchGameData)) {
		foreach($searchGameData as $sIndex=>$gameData) {
			$resValue[$sIndex]['TOURNAMENT_NAME'] = $gameData->TOURNAMENT_NAME;
			$resValue[$sIndex]['GAME_ID']         = $gameData->PLAY_GROUP_ID;
			$resValue[$sIndex]['STAKE']           = $gameData->SMALL_BLIND."/".$gameData->BIG_BLIND;
			$resValue[$sIndex]['POT_AMOUNT']      = $gameData->POT;
			$resValue[$sIndex]['STATUS']          = "Completed";
			$resValue[$sIndex]['DATE']            = date("d/m/Y H:i:s",strtotime($gameData->STARTED));
			$resValue[$sIndex]['REVENUE']         = $gameData->REVENUE;
			//$resValue[$sIndex]['CURRENCY']        = $gameData->CURRENCY_TYPE;
			//$resValue[$sIndex]['REAL_REVENUE']    = $gameData->REAL_REVENUE;
			//$resValue[$sIndex]['REAL_REVENUE']    = ($gameData->TOTAL_REVENUE)-($gameData->BONUS_REVENUE)-($gameData->SERVICE_TAX);
			//$resValue[$sIndex]['BONUS_REVENUE']   = $gameData->BONUS_REVENUE;
			//$resValue[$sIndex]['SERVICE_TAX']     = $gameData->SERVICE_TAX;

			$real_revenue = base64_encode($gameData->REAL_REVENUE);
			$bonus_revenue = base64_encode($gameData->BONUS_REVENUE);

			$releaseDate = RELEASE_DATE;
			$playedDate  = $gameData->STARTED; //from db
			$release_time = strtotime($releaseDate);
			$played_time = strtotime($playedDate);

			if ($played_time >= $release_time) {
			  $resValue[$sIndex]['GAME_DETAILS']    = '<a href="#" onclick="NewWindow(\''.base_url().'games/poker/gamedetails/detailshand/'.$gameData->PLAY_GROUP_ID.'/'.$real_revenue.'/'.$bonus_revenue.'?rid=45\',\'Game Details\',\'1100\',\'900\',\'yes\')"><strong>Details</strong></a>';
			}else{

			 $resValue[$sIndex]['GAME_DETAILS']    = '<a href="#" onclick="NewWindow(\''.base_url().'games/poker/gamedetails/details/'.$gameData->PLAY_GROUP_ID.'/'.$real_revenue.'/'.$bonus_revenue.'?rid=45\',\'Game Details\',\'1100\',\'900\',\'yes\')"><strong>Details</strong></a>';
			}


			//$resValue[$sIndex]['GAME_DETAILS']    = '<a href="#" onclick="NewWindow(\''.base_url().'games/poker/gamedetails/details/'.$gameData->PLAY_GROUP_ID.'?rid=45\',\'Game Details\',\'1100\',\'900\',\'yes\')"><strong>Details</strong></a>';
		}
	}

	$totalSearchStake=""; $totalSearchWin=""; $totalSearchRevenue=""; $totalSearchPotAmount="";
	if(!empty($totalSearchData)) {
		$totalSearchStake    = $totalSearchData[0]->TOTAL_STAKE;
		$totalSearchWin      = $totalSearchData[0]->TOTAL_WIN;
		$totalSearchRevenue  = $totalSearchData[0]->TOTAL_REVENUE;
		$totalSearchPotAmount= $totalSearchData[0]->POT;
		$totalSearchRealRake  = $totalSearchData[0]->REVENUE;
		//$totalSearchRealRake  = ($totalSearchData[0]->TOTAL_REVENUE)-($totalSearchData[0]->TOTAL_BONUS_RAKE)-($totalSearchData[0]->TOTAL_SERVICE_TAX);
		$totalSearchBonusRake = $totalSearchData[0]->TOTAL_BONUS_RAKE;
		$totalServiceTax	  = $totalSearchData[0]->TOTAL_SERVICE_TAX;
	}
?>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
	<div class="RightWrap">
		<div class="content_wrap">
			<div class="tableListWrap">
      			<?php if(isset($_REQUEST['errmsg'])){  echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>
                <table width="100%" class="ContentHdr">
                    <tr>
                        <td><strong>Game Hand History</strong></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="10" cellspacing="10" bgcolor="#993366" class="searchWrap">
                	<form name="frmSearchGames" method="post" action="<?php echo base_url();?>games/poker/game/viewgames?rid=84">
                	<tr>
                        <td width="30%">
                            <span class="TextFieldHdr">Table ID:</span><br />
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['TABLE_ID']))
									$sTableID = $this->session->userdata['searchGameDetails']['TABLE_ID'];
								else
									$sTableID = "";
							?>
                            <label>
                                <input type="text" name="tableID" id="tableID" class="TextField" value="<?php echo $sTableID;?>" tabindex="1" >
                            </label>
                        </td>
                        <td width="30%">
							<span class="TextFieldHdr">Game ID:</span><br />
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['GAME_ID']))
									$sGameID = $this->session->userdata['searchGameDetails']['GAME_ID'];
								else
									$sGameID = "";
							?>
                            <label>
	                            <input type="text" name="gameID" id="gameID" class="TextField" value="<?php echo $sGameID;?>" tabindex="2" >
                            </label>
                        </td>
                        <td width="30%">
							<span class="TextFieldHdr">Game Type:</span><br />
                            <label>
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['GAME_TYPE']))
									$sGameType = $this->session->userdata['searchGameDetails']['GAME_TYPE'];
								else
									$sGameType = "";
							?>
                                <select name="game_type" class="ListMenu" id="game_type" tabindex="3">
                                      <option value="">Select</option>
                                      <?php
                                      foreach($gameTypes as $gametype){
									  	if($sGameType==$gametype->MINIGAMES_TYPE_ID) {
									  ?>
                                      	<option value="<?php echo $gametype->MINIGAMES_TYPE_ID;?>" selected="selected"><?php echo $gametype->GAME_DESCRIPTION; ?></option>
                                      <?php
									  	} else { ?>
										<option value="<?php echo $gametype->MINIGAMES_TYPE_ID;?>"><?php echo $gametype->GAME_DESCRIPTION; ?></option>
										<?php }
									  }
									  ?>
                                </select>
                            </label>
                        </td>
					</tr>
                	<tr>
                        <td width="30%">
                            <span class="TextFieldHdr">Player ID:</span><br />
                            <label>
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['PLAYER_ID']))
									$sPlayerID = $this->session->userdata['searchGameDetails']['PLAYER_ID'];
								else
									$sPlayerID = "";
							?>
                                <input type="text" name="playerID" id="playerID" class="TextField" value="<?php echo $sPlayerID;?>" tabindex="4" >
                            </label>
                        </td>
                        <td width="30%">
							<span class="TextFieldHdr">Hand ID:</span><br />
                            <label>
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['HAND_ID']))
									$sHandID = $this->session->userdata['searchGameDetails']['HAND_ID'];
								else
									$sHandID = "";
							?>
	                             <input type="text" name="handID" id="handID" class="TextField" value="<?php echo $sHandID;?>" tabindex="5" >
                            </label>
                        </td>
                        <td width="30%">&nbsp;</td>
					</tr>
                	<tr>
                        <td width="30%">
							<span class="TextFieldHdr">Stake Amount:</span><br />
                            <label>
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['STAKE']))
									$sStakeAmount = $this->session->userdata['searchGameDetails']['STAKE'];
								else
									$sStakeAmount = "";
							?>
	                             <input type="text" name="stakeAmt" id="stakeAmt" class="TextField" value="<?php echo $sStakeAmount;?>" tabindex="7" >
                            </label>
                        </td>
                        <td width="30%">
							<span class="TextFieldHdr">Status:</span><br />
                            <label>
                                 <select name="status" class="ListMenu" id="status" tabindex="8">
                                    <option value="8" selected="selected">Completed</option>
                                </select>
                            </label>
                        </td>
                        <td width="30%">
                            <?php
							/*
								if(!empty($this->session->userdata['searchGameDetails']['CURRENCY_TYPE']))
									$sCurrencyType = $this->session->userdata['searchGameDetails']['CURRENCY_TYPE'];
								else
									$sCurrencyType = "";
							?>
                                <select name="currency_type" class="ListMenu" id="currency_type" tabindex="3" style="display:none">
                                      <option value="">Select</option>
									  <?php foreach($currencyTypes as $currencyType){
									  	if($sCurrencyType==$currencyType->COIN_TYPE_ID) {
									  ?>
                                      <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>" selected="selected"><?php echo $currencyType->NAME; ?></option>
                                      <?php
										} else { ?>
                                       <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>"><?php echo $currencyType->NAME; ?></option>
                                        <?php

										}
									  }
								*/
									  ?>
                                </select>
                        </td>						
					</tr>
                	<tr>
                        <td width="30%">
                            <span class="TextFieldHdr">From:</span><br />
                            <label>
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['START_DATE_TIME']))
									$sStartDateVal = $this->session->userdata['searchGameDetails']['START_DATE_TIME'];
								else
									$sStartDateVal = date("d-m-Y 00:00:00");
							?>
                                <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?php echo $sStartDateVal;?>" readonly="readonly">
                            </label><a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>
                        </td>
                        <td width="30%">
							<span class="TextFieldHdr">To:</span><br />
                            <label>
                            <?php
								if(!empty($this->session->userdata['searchGameDetails']['END_DATE_TIME']))
									$sEndDateVal = $this->session->userdata['searchGameDetails']['END_DATE_TIME'];
								else
									$sEndDateVal = date("d-m-Y 23:59:59");
							?>
	                            <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?php echo $sEndDateVal;?>" readonly="readonly">
                            </label><a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>
                        </td>
                        <td width="30%">
							<span class="TextFieldHdr">Date Range:</span><br />
                            <label>
                              <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                                <option value="">Select</option>
                                <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                                <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                                <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                                <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                                <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                                <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
                              </select>
                            </label>
                        </td>
					</tr>
                	<tr>
                        <td width="30%" colspan="3">
							<input type="submit" name="frmSearch" id="frmSearch" value="Search" style="float:left;" />&nbsp;
                            <input type="submit" name="frmClear" id="frmClear" value="Clear"  />
                        </td>
					</tr>
                    </form>
                </table>
            	<?php
                if(!empty($searchResult) && !empty($searchGameData)) {
				?>
<style>
	.searchWrap1 {
		background-color: #F8F8F8;
		border: 1px solid #EEEEEE;
		border-radius: 5px;
		float: left;
		width: 100%;
		margin-top:10px;
		font-size:13px;
	}
</style>
<p class="searchWrap1" style="height:40px;;">
    <span style="position:relative;top:5px;left:10px;line-height: 18px;">
        <b> Total Stake: <font color="#FF3300">(<?php echo $totalSearchStake;?>) </font></b> &nbsp;&nbsp;&nbsp;
        <b> Total Win: <font color="green">(<?php echo $totalSearchWin;?>)</font></b> &nbsp;&nbsp;&nbsp;
        <!--<b> Total Gross Rake: <font color="#FF3300">(<?php //echo $totalSearchRevenue;?>)</font></b>&nbsp;&nbsp;&nbsp;
        <b> Total Bonus Rake: <font color="#FF3300">(<?php //echo $totalSearchBonusRake;?>)</font></b>&nbsp;&nbsp;&nbsp;-->
        <b> Total Rake: <font color="#FF3300">(<?php echo $totalSearchRealRake;?>)</font></b>&nbsp;&nbsp;&nbsp;<br/>
		<!--<b> Total Service Tax: <font color="#FF3300">(<?php //echo $totalServiceTax;?>)</font></b>&nbsp;-->

  </span>
</p>
                <?php } ?>
				<div class="tableListWrap">
		      		<div class="data-list">
                    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
                    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            	<?php
                if(!empty($searchResult) && !empty($searchGameData)) {
				?>
                <table id="list2"></table>
                <div id="pager2"></div>
				<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
                <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
                <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
				colNames:['Table ID','Game ID','Stake','Pot Amount','Status','Date & Time','Rake','Game Details'],
			 //colNames:['Table ID','Game ID','Stake','Pot Amount','Status','Date & Time','Gross Rake','Bonus Rake','Service Tax','Net Rake','Currency','Game Details'],
							colModel:[
								{name:'TOURNAMENT_NAME',index:'TOURNAMENT_NAME', align:"center", width:100},
								{name:'GAME_ID',index:'GAME_ID', align:"center", width:90},
								{name:'STAKE',index:'STAKE', align:"center", width:45,sorttype:"number"},
								{name:'POT_AMOUNT',index:'POT_AMOUNT', align:"center", width:65,sorttype:"float"},
								{name:'STATUS',index:'STATUS', align:"center", width:60},
								{name:'DATE',index:'DATE', align:"center", width:110,sorttype: "datetime", datefmt: "d/m/Y H:i:s"},
								{name:'REVENUE',index:'REVENUE', align:"center", width:65,sorttype:"float"},
								//{name:'BONUS_REVENUE',index:'BONUS_REVENUE', align:"center", width:65,sorttype:"float"},
								//{name:'SERVICE_TAX',index:'SERVICE_TAX', align:"center", width:65,sorttype:"float"},
								//{name:'REAL_REVENUE',index:'REAL_REVENUE', align:"center", width:65,sorttype:"float"},
								//{name:'CURRENCY',index:'CURRENCY', align:"center", width:65},
								{name:'GAME_DETAILS',index:'GAME_DETAILS', align:"center", width:90},
							],
                            rowNum:500,
                            width: 1034, height: "100%"
                        });
                        var mydata = <?php echo json_encode($resValue);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);
                </script>
                <div class="page-wrap">
                  <div class="pagination">
                    <?php	echo $pagination; ?>
                  </div>
                </div>
               <?php } else {
               		$message = "Please select the search criteria";
               }
			 if(empty($searchGameData) && !empty($searchResult))
			 	$message = "There is no record to display";
			 if(!empty($message)) {?>
            <table id="list4" class="data">
              <tr>
                <td>
                	<img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span>
                 </td>
              </tr>
            </table>

           	<?php } ?>
            </div>
        </div>

			</div>
		</div>
	</div>
</div>
<?php $this->load->view("common/footer"); ?>