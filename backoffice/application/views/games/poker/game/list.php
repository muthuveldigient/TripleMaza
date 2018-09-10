<script language="javascript">
function NewWindow(mypage,myname,w,h,scroll){
var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
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
   		  <form action="<?php echo base_url();?>games/poker/game/view?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Search Games</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Table ID:</span><br />
            <label>
            <input type="text" name="tableID" id="tableID" class="TextField" value="<?PHP if(isset($_REQUEST['tableID'])) echo $_REQUEST['tableID']; ?>" tabindex="1" >
            </label></td>
          <td width="30%"><span class="TextFieldHdr">Game ID:</span><br />
            <label>
            <input type="text" name="gameID" id="gameID" class="TextField" value="<?PHP if(isset($_REQUEST['gameID'])) echo $_REQUEST['gameID']; ?>" tabindex="2" >
            </label>
          </td>  
          <td width="30%"><span class="TextFieldHdr">Game Type:</span><br />
            <label>
            <select name="game_type" class="ListMenu" id="game_type" tabindex="3">
              <option value="">Select</option>
              <?php 
			  $miniGameTypeID = "";
			  if($_REQUEST['game_type'])
			  	$miniGameTypeID	= $_REQUEST['game_type'];
			  else if($GAME_TYPE)
			  	$miniGameTypeID	= $GAME_TYPE;
			  else
			  	$miniGameTypeID	= "";
							  
			  foreach($gameTypes as $gametype){ ?>
              <option value="<?php echo $gametype->MINIGAMES_TYPE_NAME; ?>" <?php if($miniGameTypeID==$gametype->MINIGAMES_TYPE_NAME){ echo "selected"; } ?> ><?php echo $gametype->GAME_DESCRIPTION; ?></option>
              <?php } ?>
            </select>
            </label>
          </td>
          <td width="30%"></td>
        </tr>
         <tr>
          <td width="40%"><span class="TextFieldHdr">Player ID:</span><br />
            <label>
            <input type="text" name="playerID" id="playerID" class="TextField" value="<?PHP if(isset($_REQUEST['playerID'])){  echo $_REQUEST['playerID']; }elseif(isset($playerID)){ echo $playerID; }  ?>" tabindex="4" >
            </label>
          </td>
         
          <td width="30%"><span class="TextFieldHdr">Hand ID:</span><br />
            <label>
            <input type="text" name="handID" id="handID" class="TextField" value="<?PHP if(isset($_REQUEST['handID'])) echo $_REQUEST['handID']; ?>" tabindex="5" >
            </label></td>
        </tr>
          <tr>
          <td width="40%"><span class="TextFieldHdr">Currency Type:</span><br />
            <label>
             <select name="currency_type" class="ListMenu" id="currency_type" tabindex="6">
               <option value="">Select</option>
              <?php foreach($currencyTypes as $currencyType){ ?>
              <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>" <?php if($_REQUEST['currency_type']==$currencyType->COIN_TYPE_ID){ echo "selected"; } ?> ><?php echo $currencyType->NAME; ?></option>
              <?php } ?>
            </select>
            </label></td>
          <td width="30%"><span class="TextFieldHdr">Stake Amount:</span><br />
            <label>
            <input type="text" name="stakeAmt" id="stakeAmt" class="TextField" value="<?PHP if(isset($_REQUEST['stakeAmt'])) echo $_REQUEST['stakeAmt']; ?>" tabindex="7" >
            </label></td>
          <td width="30%"><span class="TextFieldHdr">Status:</span><br />
            <label>
             <select name="status" class="ListMenu" id="status" tabindex="8">
               <option value="">Select</option>
              <option value="8" <?php if($_REQUEST['status']==8){ echo "selected"; } ?> >Completed</option>
              <option value="-1" <?php if($_REQUEST['status']==-1){ echo "selected"; } ?> >Refund</option>
              <option value="2" <?php if($_REQUEST['status']==2){ echo "selected"; } ?> >Interrupted</option>
            </select>
            </label></td>
        </tr>
        <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
				  	$S_START_DATE_TIME="";
					if(!empty($this->session->userdata['searchGameDetails']['START_DATE_TIME']))
						$S_START_DATE_TIME = $this->session->userdata['searchGameDetails']['START_DATE_TIME'];				
					else if(isset($START_DATE_TIME))
						$S_START_DATE_TIME=date('d-m-Y H:i:s',strtotime($START_DATE_TIME));
					else
						$S_START_DATE_TIME = date("d-m-Y 00:00:00");
				  ?>   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($S_START_DATE_TIME !=""){ echo $S_START_DATE_TIME; } ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                    <?php
				  	$E_END_DATE_TIME="";
					if(!empty($this->session->userdata['searchGameDetails']['END_DATE_TIME']))
						$E_END_DATE_TIME = $this->session->userdata['searchGameDetails']['END_DATE_TIME'];					
					else if(isset($END_DATE_TIME))
						$E_END_DATE_TIME=date('d-m-Y H:i:s',strtotime($END_DATE_TIME));					
					else
						$E_END_DATE_TIME = date("d-m-Y 23:59:59");
				  ?>  
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($E_END_DATE_TIME != ""){ echo $E_END_DATE_TIME; }?>">
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
  <td><form action="<?php echo base_url();?>games/poker/game?rid=51" method="post" name="clrform" id="clrform">
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
									
if($totalrecords){
	if(count($totalrecords)>0 && is_array($totalrecords)){
		$total_stakes="";
		$total_win="";	
		$total_potamount="";
		$total_revenue="";
												
		for($k=0;$k<count($totalrecords);$k++){
			$total_stakes=$total_stakes+$totalrecords[$k]->STAKE;
			$total_win=$total_win+$totalrecords[$k]->WIN;
			$total_potamount=$total_potamount+$totalrecords[$k]->POT_AMOUNT;
			$total_revenue=$total_revenue+$totalrecords[$k]->REVENUE;
		}	
	}
}
									
$resvalues=array();
if(isset($results)){ 
	if(count($results)>0 && is_array($results)){
											
		for($i=0;$i<count($results);$i++){
		//call model to get Tournament Name,currency type.
			$tournamentName = $results[$i]->TOURNAMENT_NAME;
			$currencyType	= $this->game_model->getCurrencyNameByID($results[$i]->COIN_TYPE_ID);
			if($results[$i]->STATE==8){
				$status='Completed';
			}elseif($results[$i]->STATE==-1){
				$status='Refund';
			}elseif($results[$i]->STATE){
				$status='Interupted';
			}else{
				$status='';
			}
													
			$resvalue['TOURNAMENT_NAME']	= $tournamentName;
			if($results[$i]->PLAY_GROUP_ID)
				$resvalue['GAME_ID']			= $results[$i]->PLAY_GROUP_ID;
			else
				$resvalue['GAME_ID']			= '-';
			//$resvalue['PLAYER_ID']			= $results[$i]->USERNAME;
			if($results[$i]->SMALL_BLIND)
				$resvalue['STAKE']				= $results[$i]->SMALL_BLIND.'/'.$results[$i]->BIG_BLIND;
			else
				$resvalue['STAKE']				= '-';
													
			if($results[$i]->POT_AMOUNT)
				$resvalue['POT_AMOUNT']			= $results[$i]->POT_AMOUNT;
			else
				$resvalue['POT_AMOUNT']			= '-';
													
			if($status)
				$resvalue['STATUS']				= $status;
			else
				$resvalue['STATUS']				= '-';
													
			$resvalue['DATE']				= date("d/m/Y H:i:s",strtotime($results[$i]->STARTED));
			$resvalue['REVENUE']			= number_format(($results[$i]->REVENUE),2);
			$resvalue['CURRENCY']			= $currencyType;
			$resvalue['GAME_DETAILS']		= '<a href="#" onclick="NewWindow(\''.base_url().'games/poker/gamedetails/detailshand/'.$results[$i]->PLAY_GROUP_ID.'?rid=45\',\'Game Details\',\'955\',\'900\',\'yes\')"><strong>Details</strong></a>';
			/*$resvalue['DELETE']= '<a href="delete/'.$results[$i]->ID.'" onClick="return confirmDelete();"><img src="'.base_url().'static/images/delete.png" alt="Delete"></a>';*/
			if($resvalue){
				$arrs[] = $resvalue;
			}
		$j++;
		}
	}else{
		$arrs="";
	}
}

if(isset($arrs) && $arrs!=''){ 
	if($total_stakes){	?>
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
<?php 
  $reqStartDate = $_REQUEST['START_DATE_TIME'];
  $reqEndDate   = $_REQUEST['END_DATE_TIME'];
  $playerId     = $_REQUEST['playerID']; 
?>
    <p class="searchWrap1" style="height:30px;">
    <span style="position:relative;top:8px;left:10px">
    <b> Total Stake: <font color="#FF3300">(<?php echo number_format($total_stakes,2,".","");?>) </font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Win: <font color="green">(<?php if($total_win) echo number_format($total_win,2,".",""); ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Revenue: <font color="#FF3300">(<?php if($total_revenue) echo number_format($total_revenue,2,".","");?>)</font></b>
    <b> Total Pot Amount: <font color="#FF3300">(<?php if($total_potamount) echo number_format($total_potamount,2,".","");?>)</font></b>
     <b><a style="position: absolute; text-decoration: none; font-weight: bold; font-size: 13px; right: -122px; top: -18px;" href="<?php echo base_url(); ?>games/poker/game/exportToExcel?playerid=<?php echo $playerId; ?>&sdate=<?php echo $reqStartDate; ?>&edate=<?php echo $reqEndDate; ?>"><img style="position: relative; top: 3px; left: -4px;" src="<?php echo base_url(); ?>static/images/excel.png">Export to excel</a></b>
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
					colNames:['Table ID','Game ID','Stake','Pot Amount','Status','Date & Time','Revenue','Currency','Game Details'],
                    colModel:[
						{name:'TOURNAMENT_NAME',index:'TOURNAMENT_NAME', align:"center", width:100},
						{name:'GAME_ID',index:'GAME_ID', align:"center", width:80},
						{name:'STAKE',index:'STAKE', align:"center", width:60,sorttype:"number"},
						{name:'POT_AMOUNT',index:'POT_AMOUNT', align:"center", width:60,sorttype:"float"},
						{name:'STATUS',index:'STATUS', align:"center", width:60},
						{name:'DATE',index:'DATE', align:"center", width:90,sorttype: "datetime", datefmt: "d/m/Y H:i:s"},
						{name:'REVENUE',index:'REVENUE', align:"center", width:70,sorttype:"float"},
						{name:'CURRENCY',index:'CURRENCY', align:"center", width:60},
						{name:'GAME_DETAILS',index:'GAME_DETAILS', align:"center", width:60},
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
    <?php }else{ ?>
	<div class="tableListWrap">
      <div class="data-list">
        <table id="list4" class="data">
          <tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>There are currently no games found in this search criteria.</b></span></td>
          </tr>
        </table>
      </div>
    </div>
	<?php } ?>
  </div>
</div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>