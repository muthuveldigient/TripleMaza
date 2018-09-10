<?php //error_reporting(0); ?>
<script language="javascript">
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
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>

<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){ echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     
   <form action="<?php echo base_url()?>admin/draw/index?rid=74" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Draw List</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Draw Name:</span><br />
            <label>
         <input type="text" name="draw_name" id="draw_name" class="TextField" value="<?PHP if(isset($_REQUEST['draw_name'])) echo trim($_REQUEST['draw_name']); ?>" tabindex="4" >
            </label>
          </td>
		  
		  
          <td width="30%"><span class="TextFieldHdr">Game Type:</span><br />
            <!--<label>
            <input type="text" name="gameID" id="gameID" class="TextField" value="<?PHP //if(isset($_REQUEST['gameID'])) echo $_REQUEST['gameID']; ?>" tabindex="2" >
            </label>-->
            	<label>
            		<select name="GAME_TYPE" id="GAME_TYPE" class="ListMenu" required>
                    	<?php foreach($activeGames as $gameNames){ ?>
                    	<option  value="<?php echo $gameNames->MINIGAMES_NAME; ?>" <?php if(isset($_REQUEST['GAME_TYPE']) && $_REQUEST['GAME_TYPE']== "$gameNames->MINIGAMES_NAME"){ echo "selected";}?>><?php echo ucfirst(strtolower($gameNames->DESCRIPTION)); ?></option>
                    	<?php } ?>
                    	
                  	</select>
                </label>            
          </td>
		  <td width="30%"><span class="TextFieldHdr">Draw Status:</span><br />
            <!--<label>
            <input type="text" name="gameID" id="gameID" class="TextField" value="<?PHP //if(isset($_REQUEST['gameID'])) echo $_REQUEST['gameID']; ?>" tabindex="2" >
            </label>-->
            	<label>
            		<select name="draw_status" id="draw_status" class="ListMenu">
                		<option value="">Select</option>
						<option value="1">active</option>
						<option value="0">deactive</option>
                    	
                  	</select>
                </label>            
          </td>
          
          <td width="30%"></td>
        </tr>
        <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
					if($_REQUEST['START_DATE_TIME'])
						$START_DATE_TIME = $_REQUEST['START_DATE_TIME'];
					else
						$START_DATE_TIME = date('Y-m-d').' 00:00:00';
				  ?>   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; } ?>" readonly>
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                   <?php
					if($_REQUEST['END_DATE_TIME'])
						$END_DATE_TIME = $_REQUEST['END_DATE_TIME'];
					else
						$END_DATE_TIME = date('Y-m-d').' 23:59:59';
				  ?> 
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }?>" readonly >
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
  <td><form action="<?php echo base_url();?>admin/draw/index?rid=74" method="post" name="clrform" id="clrform">
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
  <script language="javascript">
	function updateDrawStatus(drawID,drawStatus) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				document.getElementById("draw_"+drawID).innerHTML = xhttp.responseText;
			}
		}
		xhttp.open("GET", "<?php echo base_url(); ?>/admin/draw/drawstatus?drawID="+drawID+"&drawStatus="+drawStatus, true);
		xhttp.send();		
	}
</script>
<?php	
if(isset($page)){
	$j=$page;
}else{
	$j=0;
}   
									
$resvalues = array();
//echo "<pre>"; print_r($results); die;
if($results[0]->DRAW_ID!=""){
	if(isset($results)){ 
		if(count($results)>0 && is_array($results)){
			foreach($results as $res ){
				$resvalue['DRAW_NAME'] 		= 'RajaRani';		
				$resvalue['DRAW_ID'] 		= (!empty($res->DRAW_ID)?$res->DRAW_ID:'--');		
				$resvalue['DRAW_DESCRIPTION'] 		= (!empty($res->DRAW_DESCRIPTION)?$res->DRAW_DESCRIPTION:'--');
				$resvalue['DRAW_PRICE'] 	= (!empty($res->DRAW_PRICE)?$res->DRAW_PRICE:'--');
				$resvalue['DRAW_TOTALBET'] 	= (!empty($res->DRAW_TOTALBET)?$res->DRAW_TOTALBET:'--');
				$resvalue['DRAW_TOTALWIN'] 	= (!empty($res->DRAW_TOTALWIN)?$res->DRAW_TOTALWIN:'--');
				$resvalue['DRAW_WINNUMBER'] = (!empty($res->DRAW_WINNUMBER)?$res->DRAW_WINNUMBER:'--');
				$resvalue['DRAW_TIME'] 		= (!empty($res->DRAW_STARTTIME)?date('d-m-Y h:i:s A',strtotime($res->DRAW_STARTTIME)):'--');
				//$resvalue['DRAW_STATUS'] 	= (!empty($res->DRAW_STATUS)?$res->DRAW_STATUS:'--');
				//$resvalue['IS_ACTIVE'] 		= (!empty($res->IS_ACTIVE)?'Active':'--');
				
				if($res->DRAW_STATUS==1)
					$resvalue['DRAW_STATUS'] 	= "NEW";
				else if($res->DRAW_STATUS==2)
					$resvalue['DRAW_STATUS'] 	= "COUNT DOWN STARTED";
				else if($res->DRAW_STATUS==3)
					$resvalue['DRAW_STATUS'] 	= "WIN PUBLISHED";
				else if($res->DRAW_STATUS==4)										
					$resvalue['DRAW_STATUS'] 	= "WIN AMOUNT PROCESS";					
				else if($res->DRAW_STATUS==5)
					$resvalue['DRAW_STATUS'] 	= "COMPLETED";
				else if($res->DRAW_STATUS==6)
					$resvalue['DRAW_STATUS'] 	= "CANCELLED";
				else if($res->DRAW_STATUS==7)
					$resvalue['DRAW_STATUS'] 	= "CANCELLED";//advance cancelled
				else
					$resvalue['DRAW_STATUS'] 	= '---';
						
				if($res->DRAW_STATUS!=1) {
					$resvalue['IS_ACTIVE']   = "-";		
				} else {
					if($res->IS_ACTIVE==1)
						$resvalue['IS_ACTIVE']   = "<span id='draw_".$res->DRAW_ID."'><a href='javascript:updateDrawStatus(".$res->DRAW_ID.",".$res->IS_ACTIVE.")' title='Deactive' class='viewuserActive'>Active</a></span>";//click to deactivate		
					else //DRAW_STATUS=2
						$resvalue['IS_ACTIVE']   = "<span id='draw_".$res->DRAW_ID."'><a href='javascript:updateDrawStatus(".$res->DRAW_ID.",".$res->IS_ACTIVE.");' title='Active' class='viewuserDeactive'>Deactive</a></span>";//click to activate						
				}
					
				
				if($resvalue){
					$arrs[] = $resvalue;
				}$j++;
			}
		}else{
			$arrs = "";
		}
	}
}		

if(isset($arrs) && $arrs !=''){   ?>
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
	<p></p>
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
					colNames:['Game Name','Game Type','Draw number','Price','Date Time','Total Bet','Total Win','Win No','Status'],//,'Action'
                    colModel:[
						{name:'DRAW_NAME',index:'DRAW_NAME', align:"center", width:60},
						{name:'DRAW_DESCRIPTION',index:'DRAW_DESCRIPTION', align:"center", width:60},
						{name:'DRAW_ID',index:'DRAW_ID', align:"right", width:60,sorttype:"float"},
						{name:'DRAW_PRICE',index:'DRAW_PRICE', align:"right", width:30,sorttype:"float"},
						{name:'DRAW_TIME',index:'DRAW_TIME', align:"right", width:80,sorttype:"float"},
						{name:'DRAW_TOTALBET',index:'DRAW_TOTALBET', align:"right", width:60,sorttype:"float"},
						{name:'DRAW_TOTALWIN',index:'DRAW_TOTALWIN', align:"right", width:60,sorttype:"float"},
						{name:'DRAW_WINNUMBER',index:'TOT_END_POINTS', align:"right", width:40},
						{name:'DRAW_STATUS',index:'DRAW_STATUS', align:"right", width:60},
						//{name:'IS_ACTIVE',index:'IS_ACTIVE', align:"right", width:60},
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