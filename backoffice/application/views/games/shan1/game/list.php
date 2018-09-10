<?php error_reporting(0); ?>
<script language="javascript">
function showdaterange(vid)
    {
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

function NewWindow(mypage,myname,w,h,scroll){
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/4 : 0;
	var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage,myname,settings);
}
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function confirmDelete(){
	var agree=confirm("Are you sure you want to delete this file?");
	if(agree)
	    return true;
	else
		return false;
}
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){  echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?> 
    
    <form action="<?php echo base_url()?>games/game/view?rid=<?php echo $rid?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Search Games</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <?php $uname = $this->uri->segment(5); ?>
          <td width="40%"><span class="TextFieldHdr">Player ID:</span><br />
            <label>
         <input type="text" name="playerID" id="playerID" class="TextField" value="<?PHP if(isset($_REQUEST['playerID'])){ echo trim($_REQUEST['playerID']); }elseif(isset($uname)){ echo trim($uname);  }  ?>" tabindex="4" >
            </label>
          </td> 
          <td width="30%"><span class="TextFieldHdr">Game Name:</span><br />
            <label>
            <input type="text" name="gameID" id="gameID" class="TextField" value="<?PHP if(isset($_REQUEST['gameID'])) echo trim($_REQUEST['gameID']); ?>" tabindex="2" >
            </label>
          </td>   
          <td width="40%"><span class="TextFieldHdr">Play Group ID:</span><br />
            <label>
            <input type="text" name="playGroupID" id="playGroupID" class="TextField" value="<?PHP if(isset($_REQUEST['playGroupID'])) echo trim($_REQUEST['playGroupID']); ?>" tabindex="1" >
            </label></td>          
          <td width="30%"></td>
        </tr>
         <tr>

        </tr>
        <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
					if($_REQUEST['START_DATE_TIME'])
						$START_DATE_TIME = $_REQUEST['START_DATE_TIME'];
					else
						$START_DATE_TIME = "";
				  ?>   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; } ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                   <?php
					if($_REQUEST['END_DATE_TIME'])
						$END_DATE_TIME = $_REQUEST['END_DATE_TIME'];
					else
						$END_DATE_TIME = "";
				  ?> 
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
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
                <td width="20%">&nbsp;</td>
        </tr>
        <tr>
          <td width="33%"><table>
            <tr>
              <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
  </form>
  </td>
  <td><form action="<?php echo base_url();?>games/game?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
      <input name="reset" type="submit"  id="reset" value="Clear"  />
    </form></td>
  <td>&nbsp;</td>
  </tr>
  </table>
  </td>
  <td width="33%">&nbsp;</td>
  <td width="33%">&nbsp;</td>
  </tr>
  </table>
  </table>
  </form>
<?php	
if(isset($page)){
	$j=$page;
}else{
	$j=0;
}   
$resvalues=array();
if(isset($results)){ 
	if(count($results)>0 && is_array($results)){
		for($i=0;$i<count($results);$i++){
			//call model to get Tournament Name,currency type.
			$gameName  = $this->game_model->getTournamentNameByID($results[$i]->GAME_ID); 
			if($results[$i]->GAME_NAME)
				$resvalue['GAME_NAME']			= $gameName;
			else
				$resvalue['GAME_NAME']			= '-';
			if($results[$i]->PLAY_GROUP_ID)
				$resvalue['PLAY_GROUP_ID']		= '<a href="#" onclick="NewWindow(\''.base_url().'games/gamedetails/details/'.$results[$i]->PLAY_GROUP_ID.'/'.$results[$i]->GAME_ID.'?rid=45\',\'Game Details\',\'1000\',\'600\',\'yes\')">'.$results[$i]->PLAY_GROUP_ID.'</a>';
			else
				$resvalue['PLAY_GROUP_ID']		= '-';
			if($results[$i]->STARTED)
				$resvalue['STARTED']			= $results[$i]->STARTED;
			else
				$resvalue['STARTED']			= '-';		
			$rakeAmnt = $this->game_model->getRakeAmount($results[$i]->PLAY_GROUP_ID);
			/* $results12 = $this->game_model->gameDetails($results[$i]->PLAY_GROUP_ID);
if($results12){			
	$cntRes1 = count($results12);
	for($i=0;$i<$cntRes1;$i++){
		$playdata1=json_decode($results12[$i]->PLAY_DATA,true);
		$cnt1 = count($playdata1['playResult']['playerHand']);	
		for($j=0;$j<$cnt1;$j++){
			if($playdata1['playResult']['playerHand'][$j]['userName'] == $results12[$i]->USERNAME){
				$playerCards1 = $playdata1['playResult']['playerHand'][$j]['cardsAsString'];
					$openingPotAmount = $results12[$i]->OPENING_POT_AMOUNT;
					$closingPotAmount = $results12[$i]->CLOSING_POT_AMOUNT;				
				$valueInfo1 = $playdata1['playResult']['playerIndex'];
				$handOutCome1 = $playdata1['playResult']['playerHand'][$j]['handOutcome'];
				if($playdata1['playResult']['bankerIndex']==$valueInfo1){
					$Banker = $playdata1['playResult']['playerHand'][$j]['userName'];
				}
			}
		}
	}	
}	*/
			if($results[$i]->OPENING_POT_AMOUNT)
				$resvalue['OPENING_POT_AMOUNT']				= $results[$i]->OPENING_POT_AMOUNT;
			else
				$resvalue['OPENING_POT_AMOUNT']				= '-';
			if($results[$i]->CLOSING_POT_AMOUNT)
				$resvalue['CLOSING_POT_AMOUNT']				= $results[$i]->CLOSING_POT_AMOUNT;
			else
				$resvalue['CLOSING_POT_AMOUNT']				= '-';
			if($rakeAmnt)
				$resvalue['RAKE']				= $rakeAmnt;
			else
				$resvalue['RAKE']				= '-';			
				
			if($resvalue){
				$arrs[] = $resvalue;
			}
			$j++;
			}
		}else{
			$arrs="";
		}
    }
	if(isset($arrs) && $arrs !=''){  
		if($totalrecords){
			$cnt = count($totalrake);
	  		for($i=0;$i<$cnt;$i++){
	  			if($rake){
					$rake = $rake + $totalrake[$i]->RAKE;
				}else{
					$rake = $totalrake[$i]->RAKE;
				}
	  		}

$totalUserRakeValue="";
foreach($totalUserRake as $rIndex=>$rakeValue) {
	$totalUserRakeValue = $totalUserRakeValue + $rakeValue->RAKE;
}
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
    <p class="searchWrap1" style="height:30px;">
    <span style="position:relative;top:8px;left:10px">
<b> Total Game: <font color="#FF3300">(<?php echo number_format($totalrecords);?>) </font></b> &nbsp;&nbsp;&nbsp;
<?php if($_REQUEST['playerID']!=''){ ?><b> User Rake: <font color="#FF3300">(<?php echo number_format($totalUserRakeValue,2,".","");?>) </font></b>&nbsp;&nbsp;&nbsp;<?php } ?>
<?php if($_REQUEST['playerID']==''){ ?><b> Total Rake: <font color="#FF3300">(<?php echo number_format($totalRecordsRake,2,".","");?>) </font></b> &nbsp;&nbsp;&nbsp;<?php } ?>
    <!--<b> Total Win: <font color="green">(<?php //if($total_win) echo number_format($total_win,2,".",""); ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Revenue: <font color="#FF3300">(<?php //if($total_revenue) echo number_format($total_revenue,2,".","");?>)</font></b>
    <b> Total Pot Amount: <font color="#FF3300">(<?php //if($total_potamount) echo number_format($total_potamount,2,".","");?>)</font></b>-->
    </span>
     </p>
    <?php } ?>
    <div class="tableListWrap">
      <div class="data-list">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
        <table id="list4" class="data">
          <tr>
            <td></td>
          </tr>
        </table>
        <div id="pager3"></div>
        <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					colNames:['Game Name','Play Group Id','Opening Pot Amount','Closing Pot Amount','Rake','Date'],
                    colModel:[
						{name:'GAME_NAME',index:'GAME_NAME', align:"center", width:60},
						{name:'PLAY_GROUP_ID',index:'PLAY_GROUP_ID', align:"center", width:60},
						{name:'OPENING_POT_AMOUNT',index:'OPENING_POT_AMOUNT', align:"center", width:60,sorttype:"float"},
						{name:'CLOSING_POT_AMOUNT',index:'CLOSING_POT_AMOUNT', align:"center", width:60,sorttype:"float"},
						{name:'RAKE',index:'RAKE', align:"center", width:40,sorttype:"float"},
						{name:'STARTED',index:'STARTED', align:"center", width:50,sorttype: "datetime"},						
					],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
        <div class="page-wrap">
          <div class="pagination">
            <?php	echo $pagination; ?>
          </div>
        </div>
      </div>
    </div>
<?php }else{ 
		if(empty($_POST) || $_POST['reset'] == 'Clear'){
			$message  = "Please select the search criteria"; 
		}else{
			$message  = "There are currently no games found in this search criteria.";
		} ?> 
<div class="tableListWrap">
	<div class="data-list">
       	<table id="list4" class="data">
       		<tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
            </tr>
        </table>
		</div>
</div>		
<?php	}?>
  </div>
</div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>