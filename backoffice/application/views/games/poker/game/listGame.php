				
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

hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function confirmDelete(tID){
var agree=confirm("Are you sure you want to delete this file?");
	if(agree) {
		return true;
	} else {
	
		 return false;
	}
}
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){  echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?> 
    
   		  <form action="<?php echo base_url();?>games/poker/game/listgame?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Edit Game</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Table ID:</span><br />
            <label>
            <input type="text" name="tableID" id="tableID" class="TextField" value="<?PHP if(isset($_REQUEST['tableID'])) echo $_REQUEST['tableID']; ?>" tabindex="1" >
            </label></td>
         
          <td width="30%"><span class="TextFieldHdr">Game Type:</span><br />
            <label>
            <select name="game_type" class="ListMenu" id="game_type" tabindex="2">
              <option value="">Select</option>
              <?php foreach($gameTypes as $gametype){ ?>
              <option value="<?php echo $gametype->MINIGAMES_TYPE_NAME; ?>" <?php if($_REQUEST['game_type']==$gametype->MINIGAMES_TYPE_NAME){ echo "selected"; } ?> ><?php echo $gametype->GAME_DESCRIPTION; ?></option>
              <?php } ?>
            </select>
            </label>
          </td>
          <td width="30%"></td>
        </tr>
         
          <tr>
          <td width="40%"><span class="TextFieldHdr">Currency Type:</span><br />
            <label>
             <select name="currency_type" class="ListMenu" id="currency_type" tabindex="3">
               <option value="">Select</option>
              <?php foreach($currencyTypes as $currencyType){ ?>
              <option value="<?php echo $currencyType->COIN_TYPE_ID; ?>" <?php if($_REQUEST['currency_type']==$currencyType->COIN_TYPE_ID){ echo "selected"; } ?> ><?php echo $currencyType->NAME; ?></option>
              <?php } ?>
            </select>
            </label></td>
          <td width="30%"><span class="TextFieldHdr">Stake (SB/BB):</span><br />
            <label>
            <input type="text" name="stakeAmt" id="stakeAmt" class="TextField" value="<?PHP if(isset($_REQUEST['stakeAmt'])) echo $_REQUEST['stakeAmt']; ?>" tabindex="4" >
            </label></td>
          <td width="30%"><span class="TextFieldHdr">Status:</span><br />
            <label>
             <select name="status" class="ListMenu" id="status" tabindex="5">
               <option value="">Select</option>
              <option value="1" <?php if($_REQUEST['status']==1){ echo "selected"; } ?> >Active</option>
              <option value="0" <?php if($_REQUEST['status']==0 && $_REQUEST['status'] != ''){ echo "selected"; } ?> >In Active</option>
              <option value="2" <?php if($_REQUEST['status']==2){ echo "selected"; } ?> >Delete</option>
            </select>
            </label></td>
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
  <td><form action="<?php echo base_url();?>games/poker/game/editgame?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
			$tournamentName = $results[$i]->TOURNAMENT_NAME;
			$currencyType	= $this->game_model->getCurrencyNameByID($results[$i]->COIN_TYPE_ID);
			if($results[$i]->IS_ACTIVE==1){
				$status='Active';
			}else if($results[$i]->IS_ACTIVE==2){
				$status='Deleted';
			}else{
			    $status='In Active';
			}
													
			$resvalue['TOURNAMENT_NAME']	= '<a href="'.base_url().'games/poker/game/edit/'.$results[$i]->TOURNAMENT_ID.'?rid='.$rid.'">'.$tournamentName.'</a>';
													
			if($results[$i]->SMALL_BLIND)
				$resvalue['STAKE']				= $results[$i]->SMALL_BLIND.'/'.$results[$i]->BIG_BLIND;
			else
				$resvalue['STAKE']				= '-';
													
			if($results[$i]->GAME_TYPE)
				$resvalue['GAME_TYPE']	= $results[$i]->GAME_TYPE;
			else
				$resvalue['GAME_TYPE']	= '-';
													
			if($results[$i]->TOURNAMENT_LIMIT)
				$resvalue['LIMIT']	= $results[$i]->TOURNAMENT_LIMIT;
			else
				$resvalue['LIMIT']	= '-';
													
			if($results[$i]->RAKE)
				$resvalue['RAKE']	= $results[$i]->RAKE;
			else
				$resvalue['RAKE']	= '-';
													
			if($status)
				$resvalue['STATUS']				= $status;
			else	
				$resvalue['STATUS']				= '-';
													
			$resvalue['CURRENCY']			= $currencyType;
			
			$resvalue['ACTION']			= '<a href="'.base_url().'games/poker/game/deleteGameTable/'.$results[$i]->TOURNAMENT_ID.'"><img  src="'.base_url().'static/images/delete.gif"/></a>';
													
			if($resvalue){
				$arrs[] = $resvalue;
			}
		$j++;
		}
	}else{
		$arrs="";
	}
}

if(isset($arrs) && $arrs!=''){ ?>
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
					colNames:['Table ID','Stake','Game Type','Limit','Rake(%)','Currency','Status'],
                    colModel:[
						{name:'TOURNAMENT_NAME',index:'TOURNAMENT_NAME', align:"center", width:100},
						{name:'STAKE',index:'STAKE', align:"center", width:60,sorttype:"number"},
						{name:'GAME_TYPE',index:'GAME_TYPE', align:"center", width:60},
						{name:'LIMIT',index:'LIMIT', align:"center", width:70},
						{name:'RAKE',index:'RAKE', align:"center", width:80,sorttype:"float"},
						{name:'CURRENCY',index:'CURRENCY', align:"center", width:60},
						{name:'STATUS',index:'STATUS', align:"center", width:60},
						
                    ],
                    rowNum:500,
                    width: 1034, height: "100%"
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