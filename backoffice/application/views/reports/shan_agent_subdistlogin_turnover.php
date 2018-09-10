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

function activateUser(status,userid,positionid){
   xmlHttp3=GetXmlHttpObject()
   
   if(status == 1){
     var urlstatus = 'deactive';
   }else{
     var urlstatus = 'active';
   }
   var url='<?php echo base_url()."user/ajax/"?>'+urlstatus+'/'+userid;    
 
   //url=url+"?disid="+disid;
   xmlHttp3.onreadystatechange=Showsubagent(userid,status,positionid)
   xmlHttp3.open("GET",url,true);
   xmlHttp3.send(null);
   return false;
}
</script>
<style>
.PageHdr{ width: 94.9%; }
</style>
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
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<?php
	if(isset($_REQUEST["START_DATE_TIME"]))
		$START_DATE_TIME=$_REQUEST["START_DATE_TIME"];
		
	if(isset($_REQUEST["END_DATE_TIME"]))
		$END_DATE_TIME=$_REQUEST["END_DATE_TIME"];		
?>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Shan Turn Over Report</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>reports/agent_turnover/shanreport?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) {echo $_REQUEST['START_DATE_TIME'];}else{ echo date("d-m-Y 00:00:00");} ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) {echo $_REQUEST['END_DATE_TIME'];}else{ echo date("d-m-Y 23:59:59");} ?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
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
        <td><form action="<?php echo base_url();?>reports/agent_turnover/shanreport?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
      
<?php	$self_results 	 = $results['self_results'];
		$agent_results 	 = $results['agent_results'];

		if(count($self_results)>0 && is_array($self_results)){
			for($i=0;$i<count($self_results);$i++){
				//get partner name
				$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
				$totalbets  = $self_results[$i]->totbet;
				$totalwins  = $self_results[$i]->totwin;
				$totalrake  = $self_results[$i]->TOTAL_RAKE;
				$playerloss = $self_results[$i]->PLAYER_LOSS;
				$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;				
				
				if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN; 
				else
					$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$self_results[$i]->NET;   
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['TOTAL_RAKE']	= $totalrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;					
													
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}
            
		if(count($agent_results)>0 && is_array($agent_results)){
			for($l=0;$l<count($agent_results);$l++){
				//get partner name
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/agentreport/'.$agent_results[$l]->PARTNER_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$agent_results[$l]->PARTNER_NAME.'</a>';
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
												
				$totalbets  = $agent_results[$l]->totbet;
				$totalwins  = $agent_results[$l]->totwin;
				$totalrake  = $agent_results[$i]->TOTAL_RAKE;
				$playerloss = $agent_results[$i]->PLAYER_LOSS;
				$settleamount= $agent_results[$i]->SETTLEMENT_AMOUNT;				
				
				if($agent_results[$l]->MARGIN)
					$commission=$agent_results[$l]->MARGIN; 
				else
					$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_results[$l]->NET;   
										
				//$resvalue['SNO']=$j+1;
				$agntvalue['PARTNER1']= $partnername;
				$agntvalue['PLAYPOINTS1'] = $totalbets;
				$agntvalue['WINPOINTS1']	= $totalwins;
				$agntvalue['TOTAL_RAKE']	= $totalrake;
				$agntvalue['MARGIN1'] = $commission;
				$agntvalue['NET1'] = $partner_comm;
				$agntvalue['PLAYER_LOSS'] = $playerloss;
				$agntvalue['SETTLEMENT_AMOUNT'] = $settleamount;					
													
				$allTotPlay  += $totalbets;
				$allTotWin  += $totalwins;
				$allTotComm  += $commission;
				$allTotpComm  += $partner_comm;
				$allTotpLoss  += $playerloss;
				$allTotpSamt  += $settleamount;				
												
				if($agntvalue){
				  $arrsp[] = $agntvalue;
				}
			}
		}else{
			$arrsp="";
		}
						
	if(isset($arrs) && $arrs!=''){
		if($partnertype==13){	 ?>
<style>
.searchWrap1{ background-color: #F8F8F8; border: 1px solid #EEEEEE; border-radius: 5px; float: left; width: 100%; margin-top:10px; font-size:13px; }
</style>
  
        <div class="tableListWrap">
          <div class="PageHdr"><b>Self</b></div>
          <div class="data-list">
             <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="listsg12"></table>
            <div id="pagersg12"></div>
            <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>

             <script type="text/javascript"> 
jQuery("#listsg12").jqGrid({
   	url:'<?php echo base_url();?>reports/ajax/subdistshanreport/<?php echo $partnerid;?>?q=1&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Play Points', 'Win Points','Player Loss','Total Rake', 'Agent Rake','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAY_POINTS',index:'PLAY_POINTS', width:115,sorttype: "float",align:"right"},
   		{name:'WIN_POINTS',index:'WIN_POINTS', width:115,sorttype: "float",align:"right"},
		{name:'PLAYER_LOSS',index:'PLAYER_LOSS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
		{name:'TOTAL_RAKE',index:'TOTAL_RAKE', width:115,sorttype: "float",align:"right"},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float"},
   		//{name:'NET',index:'NET', width:115, align:"right",sorttype: "float"},
		{name:'SETTLEMENT_AMOUNT',index:'SETTLEMENT_AMOUNT', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},		
   	],
   	rowNum:1000,
    viewrecords: true,
	multiselect: false,
	subGrid: true,
	loadtext: "Loading",	
	caption: "",
	subGridRowExpanded: function(subgrid_id, row_id) {
		var subgrid_table_id, pager_id;
		var rowData = $("#listsg12").getRowData(row_id);
		var partner_name = rowData.PARTNER;
		subgrid_table_id = subgrid_id+"_t";
		pager_id = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"<?php echo base_url();?>reports/ajax/subgrid_gamewise_subdistshanreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Total Rake','Agent Rake','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:130,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:130,align:"right"},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right"},
				{name:"TOTAL_RAKE",index:"TOTAL_RAKE",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:110,align:"right"},
				//{name:"NET",index:"NET",width:110,align:"right"},
				{name:"MARGIN_PERCENTAGE",index:"MARGIN_PERCENTAGE",width:100,align:"center"},
				{name:"TYPE",index:"TYPE",width:70,align:"left"}				
			],
		   	sortname: 'num',
		    sortorder: "asc",
			loadtext: "Loading",
		    height: '100%'
		});
		jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false})
	},
	subGridRowColapsed: function(subgrid_id, row_id) {
	}
});
jQuery("#listsg12").jqGrid('navGrid','#pagersg12',{add:false,edit:false,del:false});
</script>    
          </div>
        </div>
        
<?php 	}
	}
	if(isset($arrsp) && $arrsp!=''){ ?>
        <div class="tableListWrap">
        <div class="PageHdr"><b>Agent</b></div>
          <div class="data-list">
            <table id="listsg13"></table>
            <div id="pagersg13"></div>
            <script type="text/javascript"> 
jQuery("#listsg13").jqGrid({
   	url:'<?php echo base_url();?>reports/ajax/agent_shan_report/<?php echo $distid;?>?q=1&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Play Points', 'Win Points','Player Loss','Total Rake', 'Agent Rake','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAY_POINTS',index:'PLAY_POINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum', sorttype: 'number', formatter: 'number'},
   		{name:'WIN_POINTS',index:'WIN_POINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum', sorttype: 'number', formatter: 'number'},
		{name:'PLAYER_LOSS',index:'PLAYER_LOSS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
		{name:'TOTAL_RAKE',index:'TOTAL_RAKE', width:115,sorttype: "float",align:"right",summaryType: 'sum', sorttype: 'number', formatter: 'number'},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float",summaryType: 'sum', sorttype: 'number', formatter: 'number'},
   		//{name:'NET',index:'NET', width:115, align:"right",sorttype: "float",summaryType: 'sum', sorttype: 'number', formatter: 'number'},
		{name:'SETTLEMENT_AMOUNT',index:'SETTLEMENT_AMOUNT', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},		
   	],
	footerrow: true,
   	rowNum:1000,
    viewrecords: true,
	multiselect: false,
	subGrid: true,
	loadtext: "Loading",	
	caption: "",
	subGridRowExpanded: function(subgrid_id, row_id) {
		var subgrid_table_id, pager_id;
		var rowData = $("#listsg13").getRowData(row_id);
		var partner_name = rowData.PARTNER;
		subgrid_table_id = subgrid_id+"_t";
		pager_id = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"<?php echo base_url();?>reports/ajax/subgrid_shangamewise_agentreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'&distid=<?php echo $distid;?>',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Total Rake','Agent Rake','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:130,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:130,align:"right"},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right"},
				{name:"TOTAL_RAKE",index:"TOTAL_RAKE",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:110,align:"right"},
				//{name:"NET",index:"NET",width:110,align:"right"},
				{name:"MARGIN_PERCENTAGE",index:"MARGIN_PERCENTAGE",width:100,align:"center"},
				{name:"TYPE",index:"TYPE",width:70,align:"left"}				
			],
		   	sortname: 'num',
		    sortorder: "asc",
			loadtext: "Loading",
		    height: '100%'
		});
		jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false})
	},
	subGridRowColapsed: function(subgrid_id, row_id) {
	},
	loadComplete: function () {
		var playpointsSum = jQuery("#listsg13").jqGrid('getCol', 'PLAY_POINTS', false, 'sum').toFixed(2);
		var winpointsSum = jQuery("#listsg13").jqGrid('getCol', 'WIN_POINTS', false, 'sum').toFixed(2);
		var totalrakeSum = jQuery("#listsg13").jqGrid('getCol', 'TOTAL_RAKE', false, 'sum').toFixed(2);
		var totalploss = jQuery("#listsg13").jqGrid('getCol', 'PLAYER_LOSS', false, 'sum').toFixed(2);
		var totalsettlement = jQuery("#listsg13").jqGrid('getCol', 'SETTLEMENT_AMOUNT', false, 'sum').toFixed(2);		
		var margin = jQuery("#listsg13").jqGrid('getCol', 'MARGIN', false, 'sum').toFixed(2);
		//var net = jQuery("#listsg13").jqGrid('getCol', 'NET', false, 'sum').toFixed(2);
		jQuery("#listsg13").jqGrid('footerData','set', {PARTNER: 'Total:', PLAY_POINTS: playpointsSum,WIN_POINTS:winpointsSum, PLAYER_LOSS:totalploss,TOTAL_RAKE:totalrakeSum, MARGIN:margin, SETTLEMENT_AMOUNT:totalsettlement    });	
	}
});
jQuery("#listsg13").jqGrid('navGrid','#pagersg13',{add:false,edit:false,del:false});
</script>
          </div>
        </div>
       <?php }  ?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>