<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script language="javascript">
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

var specialKeys = new Array();
specialKeys.push(8); //Backspace
specialKeys.push(9); //Tab
specialKeys.push(46); //Delete
specialKeys.push(36); //Home
specialKeys.push(35); //End
specialKeys.push(37); //Left
specialKeys.push(39); //Right
specialKeys.push(32); //Space Bar

function IsAlphaNumeric(e) {
	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
	var ret = ((keyCode == 32) || (keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
	return ret;
}

function NewWindow(mypage,myname,w,h,scroll){
var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
win = window.open(mypage,myname,settings);
}

function openCancelDESC_Div(id,ival){
        document.getElementById('tournament_id').value = id;
		document.getElementById('record_id').value = ival;
		Popup.show('tournament_approve_desc');
}

function verify(){
    xmlHttp3=GetXmlHttpObject()
    var tournament_id      = document.getElementById("tournament_id").value; 
    var desc_reason = document.getElementById("desc_reason").value;
    var form = document.getElementById('descSTATUS'); // if you passed the form, you wouldn't need this line.
     if(trim(desc_reason) == ''){
        document.getElementById("error_message_popup").innerHTML = "<font color='red'><b>Reason Required For Cancel Tournament</b></font>";
		return false;  
     }

    var url='<?php echo base_url()."games/poker/ajax/canceltournament/"?>'+tournament_id+'/'+desc_reason;
    //alert(desc_reason);//return false;
    xmlHttp3.onreadystatechange=ShowAdditions
    xmlHttp3.open("GET",url,true);
    xmlHttp3.send(null);
    return false;

}

function ShowAdditions(){
    var tournament_id123   = document.getElementById("tournament_id").value;
	var ival		= document.getElementById("record_id").value;
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0){ 		
            var result=xmlHttp3.responseText;
			document.getElementById("status_tournament_"+ival).innerHTML='<a  href="<?php echo base_url()?>games/poker/ajax/cancelReason/'+tournament_id123+'" onclick="return hs.htmlExpand(this, { objectType: \'iframe\' } )">'+result+'</a>';
			document.getElementById("status_verify_"+ival).innerHTML='';
			document.getElementById('desc_reason').value = '';
            Popup.hide('tournament_approve_desc');
           // window.opener.location.reload(true);
           // window.refresh();
 	}

}

</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
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
    
   		  <form action="<?php echo base_url();?>games/poker/tournament/listtournament?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Edit Tournament</strong></td>
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
              <option value="2" <?php if($_REQUEST['status']==2){ echo "selected"; } ?> >In Active</option>
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
              <td>
               <input type="hidden" name="record_id" id="record_id" class="TextField" value="" >
              <input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
  </form>
  </td>
  <td><form action="<?php echo base_url();?>games/poker/tournament/edittournament?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
		//echo "<pre>"; print_r($results); die;						
$resvalues=array();
if(isset($results)){ 
	if(count($results)>0 && is_array($results)){
											
		for($i=0;$i<count($results);$i++){
		//call model to get Tournament Name,currency type.
			$tournamentName = $results[$i]->TOURNAMENT_NAME;
			$currencyType	= $this->game_model->getCurrencyNameByID($results[$i]->COIN_TYPE_ID);
			if($results[$i]->IS_ACTIVE==1){
				$status='Active';
			}else{
				$status='In Active';
			}
			
			$tournamentStatusName = $this->tournament_model->getTournamentStatusName($results[$i]->TOURNAMENT_STATUS);
			
													
			$resvalue['TOURNAMENT_NAME']	= '<a href="'.base_url().'games/poker/tournament/edit/'.$results[$i]->TOURNAMENT_ID.'?rid='.$rid.'">'.$tournamentName.'</a>';
													
			if($results[$i]->SMALL_BLIND)
				$resvalue['STAKE']				= $results[$i]->SMALL_BLIND.'/'.$results[$i]->BIG_BLIND;
			else
				$resvalue['STAKE']				= '-';
			
			if($results[$i]->TOURNAMENT_TYPE_ID==2 && $results[$i]->LOBBY_ID==3 && $results[$i]->MINI_GAME_TYPE_ID==1) { 
				$resvalue['GAME_TYPE']	= "Satellite Texas Holdem Event";
			}else if($results[$i]->TOURNAMENT_TYPE_ID==2 && $results[$i]->LOBBY_ID==3 && $results[$i]->MINI_GAME_TYPE_ID==2) { 
				$resvalue['GAME_TYPE']	= "Satellite Omaha Event";
			}else if($results[$i]->TOURNAMENT_TYPE_ID==2 && $results[$i]->MINI_GAME_TYPE_ID==1) {
				$resvalue['GAME_TYPE']	= "Satellite Texas Holdem";
			}else if($results[$i]->TOURNAMENT_TYPE_ID==2 && $results[$i]->MINI_GAME_TYPE_ID==2) {
				$resvalue['GAME_TYPE']	= "Satellite Omaha";
			}else { 	
														
				if($results[$i]->GAME_TYPE)
					$resvalue['GAME_TYPE']	= $results[$i]->GAME_TYPE;
				else
					$resvalue['GAME_TYPE']	= '-';
		    }								
			if($results[$i]->TOURNAMENT_LIMIT)
				$resvalue['LIMIT']	= $results[$i]->TOURNAMENT_LIMIT;
			else
				$resvalue['LIMIT']	= '-';
													
			if($results[$i]->RAKE)
				$resvalue['RAKE']	= $results[$i]->RAKE;
			else
				$resvalue['RAKE']	= '-';
													
			if($tournamentStatusName){
			  if($tournamentStatusName == 'Cancelled'){
			   $resvalue['STATUS'] = '<a  href="'.base_url().'games/poker/ajax/cancelReason/'.$results[$i]->TOURNAMENT_ID.'" onclick="return hs.htmlExpand(this, { objectType: \'iframe\' } )">'.$tournamentStatusName.'</a>';
			  }else{
				$resvalue['STATUS']				= '<span id="status_tournament_'.$i.'">'.$tournamentStatusName.'</span>';
			  }
			}else{	
				$resvalue['STATUS']				= '-';
			}										
			$resvalue['CURRENCY']			= $currencyType;
			
			if($results[$i]->BUYIN != 0){
				$resvalue['ENTRY_FEE']			= $results[$i]->BUYIN."+".$results[$i]->ENTRY_FEE;
			}else{
			   $resvalue['ENTRY_FEE']			= 0;
			}
			
			$resvalue['STARTING_CHIPS'] = $results[$i]->TOURNAMENT_CHIPS;
			$resvalue['COMMISSION'] = $results[$i]->TOURNAMENT_COMMISION;
			
			$notInArray = array(5,6); //cancelled and finished tournaments
			if (!in_array($results[$i]->TOURNAMENT_STATUS, $notInArray)){
			   //if($results[$i]->IS_ACTIVE==1){
			    $resvalue['ACTION']	 = '<div id="status_verify_'.$i.'"><a href="javascript:openCancelDESC_Div('.$results[$i]->TOURNAMENT_ID.','.$i.');"><img src="'.base_url().'static/images/cancel_tournament.png"></a> &nbsp;';
				$resvalue['ACTION']			.= '<a onclick="return confirm(\'Are you sure you want to delete this item?\');" href="'.base_url().'games/poker/tournament/deleteTournamentTable/'.$results[$i]->TOURNAMENT_ID.'"><img  src="'.base_url().'static/images/delete.gif"/></a>';
			  // }else{
			    // $resvalue['ACTION']			=  '-';  
			   //}
			}else{
			   $resvalue['ACTION']			=  '-';
			}		
			
			
			/*$resvalue['ACTION']			= '<a onclick="return confirm(\'Are you sure you want to delete this item?\');" href="'.base_url().'games/poker/tournament/deleteTournamentTable/'.$results[$i]->TOURNAMENT_ID.'"><img  src="'.base_url().'static/images/delete.gif"/></a>';*/
													
			if($resvalue){
				$arrs[] = $resvalue;
			}?>
			<script>
				function closeDiv()
				{
					document.getElementById('desc_reason').value = '';
					document.getElementById("error_message_popup").innerHTML ='';
						window.opener.location.reload(true);
						window.close();
				}   
				function clsDiv()
				{
					document.getElementById('save_desc').innerHTML = '';
					document.getElementById("error_message_popup").innerHTML ='';	
					document.getElementById('desc_reason').value = '';
						//document.getElementById('userid').value = '';
					Popup.hide('tournament_approve_desc');
					window.opener.location.reload();
				}
				</script>
				  <div id="tournament_approve_desc" class="popup" style="width:270px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
					<form enctype="multipart/form-data" action="" name="descSTATUS" id="descSTATUS" method="post" onsubmit="return verify();" >
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="90%" height="50px;" style="font-size:120%;padding-left:10px;">Cancel Tournament</td>
						  <td width="10%" align="right"><img style="cursor:pointer;" src="<?php echo base_url();?>static/images/close.png" alt="close" title="close" border="0" onClick="clsDiv();"/></td>
						</tr>
						<input type="hidden" name="tournament_id" id="tournament_id" value="">
						<tr>
						  <td style="padding:11px;"><b>Reason</b> <br /><textarea onpaste="return false;" ondrop="return false;" onkeypress="return IsAlphaNumeric(event);" maxlength="100" style="position: relative; top: 8px; resize:none;" name="desc_reason" id="desc_reason" cols="26" rows="5" class="TextArea"></textarea>
                          <span id="error_message_popup" style="position: relative; top: 13px; font-size: 11px;"></span>
                          </td>
                          
						</tr>
                        
						<tr>
						  <td style="padding:11px;" height="50px;"><input type="submit" name="submit" id="submit" value="Save" onclick="" />
							&nbsp;
							
							<input type="button" name="close" id="close" value="close" onClick="clsDiv();" />
							<span id="save_desc" style="font-size:90%;"></span></td>
						</tr>
					  </table>
					</form>
				  </div>
            
			<?php 
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
					colNames:['Table ID','Stake','Game Type','Limit','Entry Fee','Comm.(%)','Starting Chips','Currency','Status','Action'],
                    colModel:[
						{name:'TOURNAMENT_NAME',index:'TOURNAMENT_NAME', align:"center", width:120},
						{name:'STAKE',index:'STAKE', align:"center", width:30,sorttype:"number"},
						{name:'GAME_TYPE',index:'GAME_TYPE', align:"center", width:100},
						{name:'LIMIT',index:'LIMIT', align:"center", width:25},
						{name:'ENTRY_FEE',index:'ENTRY_FEE', align:"center", width:60,sorttype:"float"},
						{name:'COMMISSION',index:'COMMISSION', align:"center", width:40},
						{name:'STARTING_CHIPS',index:'STARTING_CHIPS', align:"center", width:70},
						{name:'CURRENCY',index:'CURRENCY', align:"center", width:40},
						{name:'STATUS',index:'STATUS', align:"center", width:50},
						{name:'ACTION',index:'ACTION', align:"center", width:60}
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