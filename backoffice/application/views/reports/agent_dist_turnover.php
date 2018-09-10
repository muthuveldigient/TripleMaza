
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
.PageHdr{
  width: 94.9%;
}
</style>
<script>
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
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<?php
	if(isset($_REQUEST["START_DATE_TIME"]))
		$START_DATE_TIME=$_REQUEST["START_DATE_TIME"];
		
	if(isset($_REQUEST["END_DATE_TIME"]))
		$END_DATE_TIME=$_REQUEST["END_DATE_TIME"];
	
	if(isset($_REQUEST["GAMES_TYPE"]))
		$GAMES_TYPE=$_REQUEST["GAMES_TYPE"];
	
	if(isset($_REQUEST["AGENT_LIST"]))
		$AGENT_LIST=$_REQUEST["AGENT_LIST"];
?>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Turn Over Report</strong></td>
          </tr>
        </table>
		<!--------------------------------------------------------------------------------------------------------- -->
		<?php if($form == 1){ ?>
		<form action="<?php echo base_url(); ?>reports/agent_turnover/report?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              
              <tr>
                <td width="30%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) {echo $_REQUEST['START_DATE_TIME'];}else{ echo date("d-m-Y 00:00:00");} ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="30%"><span class="TextFieldHdr">To:</span><br />
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
			
			  <td width="20%"><span class="TextFieldHdr">Affiliates:</span><br />
                  <label>
                  <select name="AGENT_LIST" id="AGENT_LIST" class="ListMenu">
					<option value="all">All</option>
                    <?php
					
					foreach($all_agent_result as $key=>$val){       ?>     
					<option value="<?php echo $val['PARTNER_ID'];?>" <?php if($_REQUEST['AGENT_LIST']==$val['PARTNER_ID']){ echo "selected";}?>><?php echo $val['PARTNER_USERNAME'];?></option>     
					<?php      }        ?>
                  </select>
                  </label>
                </td>
				<td width="10%"><span class="TextFieldHdr">Games Type:</span><br />
					<input type="radio" name="GAMES_TYPE" value="all" <?php if($_REQUEST['GAMES_TYPE']=="all" || $_REQUEST['GAMES_TYPE']=="") echo 'checked="checked"'; ?>> All
					<input type="radio" name="GAMES_TYPE" value="pc" <?php if($_REQUEST['GAMES_TYPE']=="pc"){ echo 'checked="checked"';}?>> PC
					<input type="radio" name="GAMES_TYPE" value="mobile" <?php if($_REQUEST['GAMES_TYPE']=="mobile"){ echo 'checked="checked"';}?>> Mobile
                </td>
				<td width="20%"><span class="TextFieldHdr"></span><br />
					<?php foreach($partner_type_array  as $key=>$val){ ?>
					<input type="radio" name="PARTNER_TYPE" value="<?php echo $val; ?>" <?php if($_REQUEST['PARTNER_TYPE']==$val) echo 'checked="checked"'; ?>> <?php echo $key; ?>
					<?php }?>
				</td>
              </tr>
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </form>
        </td>
        <td><form action="<?php echo base_url();?>reports/agent_turnover/report?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
		<?php } ?>
		<!--------------------------------------------------------------------------------------------------------- -->
		
<?php	$distresults=$dresults['dist_result'];
        $subdistresults=$dresults['subdist_result'];
		$distagntresults=$dresults['distagnt_result'];
	    $resvalues=array();
 
        if(count($distresults)>0 && is_array($distresults)){
			for($i=0;$i<count($distresults);$i++){
				//get partner name
				$partnername	  = $distresults[$i]->DISTRIBUTOR_NAME;
				$totalbets  = $distresults[$i]->totbet;
				$totalwins  = $distresults[$i]->totwin;
						
				if($distresults[$i]->MARGIN)
					$commission=$distresults[$i]->MARGIN; 
				else
					$commission="0.00"; 
						
				//$net=$totalbets-$totalwins;   
				$partner_comm=$distresults[$i]->NET;   
													
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
														
				if($resvalue){
					$arrs[] = $resvalue;
				} $j++;
			}
        }else{
        	$arrs="";
        }
              
        if(count($subdistresults)>0 && is_array($subdistresults)){
	        for($l=0;$l<count($subdistresults);$l++){
				//get partner name
				$partnername	  = $subdistresults[$l]->SUBDISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
												
				$totalbets  = $subdistresults[$l]->totbet;
				$totalwins  = $subdistresults[$l]->totwin;
				//	$partnershare = $share;
												
				//	$commission=number_format($totalbets*($partnershare/100),2,'.',''); 
				//	$net=$totalbets-$totalwins;   
				//	$partner_comm=$net-$commission;  
				$commission = $subdistresults[$l]->MARGIN;
				$partner_comm = $subdistresults[$l]->NET;						
				//$presvalue['SNO1']=$k+1; 
				
				$presvalue['PARTNER1']= '<a href="'.base_url().'reports/turnover/userreport/'.$subdistresults[$l]->PARTNER_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&GAMES_TYPE='.$GAMES_TYPE.'&AGENT_LIST='.$AGENT_LIST.'">'.$partnername.'</a>';
				$presvalue['PLAYPOINTS1'] = $totalbets;
				$presvalue['WINPOINTS1']	= $totalwins;
				$presvalue['MARGIN1'] = $commission;
				$presvalue['NET1'] = $partner_comm;
												
                if($presvalue){
	                $arrsp[] = $presvalue;
                }
                $k++;
			}
        }else{
        	$arrsp="";
        }
				 
				  
		if(count($distagntresults)>0 && is_array($distagntresults)){
        	for($l=0;$l<count($distagntresults);$l++){
				//get partner name
				$partnername	  = $distagntresults[$l]->PARTNER_NAME;
				//get partner revenueshare
				//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
												
				$totalbets  = $distagntresults[$l]->totbet;
				$totalwins  = $distagntresults[$l]->totwin;
				//	$partner_comm=$net-$commission;  
				$commission = $distagntresults[$l]->MARGIN;
				$partner_comm = $distagntresults[$l]->NET;						
			
				$agntvalue['PARTNER2']= '<a href="'.base_url().'reports/agent_turnover/agentreport/'.$distagntresults[$l]->PARTNER_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search&GAMES_TYPE='.$GAMES_TYPE.'&AGENT_LIST='.$AGENT_LIST.'"">'.$partnername.'</a>';
				$agntvalue['PLAYPOINTS2'] = $totalbets;
				$agntvalue['WINPOINTS2']	= $totalwins;
				$agntvalue['MARGIN2'] = $commission;
				$agntvalue['NET2'] = $partner_comm;
									 			
				$allTotPlay  += $totalbets;
				$allTotWin  += $totalwins;
				$allTotComm  += $commission;
				$allTotpComm  += $partner_comm;
											
                if($agntvalue){
        	        $arragnt[] = $agntvalue;
                }
            	$k++;
			}
		}else{
        	$arrsp="";
        }	  

	if(isset($arrs) && $arrs!=''){
		if($partnertype==15 || $partnertype==11 || $partnertype==0){	 ?>
<style>
.searchWrap1{   background-color: #F8F8F8;    border: 1px solid #EEEEEE;    border-radius: 5px;    float: left;    width: 100%;	margin-top:10px;	font-size:13px; }
</style>
		
        <div class="tableListWrap">
          <div class="PageHdr"><b>Distributor</b></div>
          <div class="data-list">
           <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
             <table id="listsg11"></table>
            <div id="pagersg11"></div>
            <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<!--            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
           <!-- <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					//colNames:['S.No','Partner','Total Bets','Total Wins','Margin','House Wins'],
					colNames:['Partner','Total Bets','Total Wins','Margin','Net'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40},
						{name:'MARGIN',index:'MARGIN', align:"right", width:60},
						{name:'NET',index:'NET', align:"right", width:40},
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script> -->
            
            <script type="text/javascript"> 
jQuery("#listsg11").jqGrid({
   	url:'<?php echo base_url();?>reports/ajax/distreport/<?php echo $distid;?>?q=1&GAMES_TYPE='+"<?php echo $GAMES_TYPE; ?>"+'&AGENT_LIST='+"<?php echo $AGENT_LIST; ?>"+'&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Total Bets', 'Total Wins', 'Agent','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAY_POINTS',index:'PLAY_POINTS', width:115,sorttype: "float",align:"right"},
   		{name:'WIN_POINTS',index:'WIN_POINTS', width:115,sorttype: "float",align:"right"},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float"},
   		{name:'NET',index:'NET', width:115, align:"right",sorttype: "float"},		
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
		var rowData = $("#listsg11").getRowData(row_id);
		var partner_name = rowData.PARTNER;
		subgrid_table_id = subgrid_id+"_t";
		pager_id = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"<?php echo base_url();?>reports/ajax/subgrid_gamewise_distreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'&GAMES_TYPE='+"<?php echo $GAMES_TYPE; ?>"+'&AGENT_LIST='+"<?php echo $AGENT_LIST; ?>"+'',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Agent','Company','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:160,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:130,align:"right"},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:130,align:"right"},
				{name:"NET",index:"NET",width:130,align:"right"},
				{name:"MARGIN_PERCENTAGE",index:"MARGIN_PERCENTAGE",width:130,align:"center"},
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
		var playpointsSum = jQuery("#listsg11").jqGrid('getCol', 'PLAY_POINTS', false, 'sum').toFixed(2);
		var winpointsSum = jQuery("#listsg11").jqGrid('getCol', 'WIN_POINTS', false, 'sum').toFixed(2);
		var margin = jQuery("#listsg11").jqGrid('getCol', 'MARGIN', false, 'sum').toFixed(2);
		var net = jQuery("#listsg11").jqGrid('getCol', 'NET', false, 'sum').toFixed(2);
		jQuery("#listsg11").jqGrid('footerData','set', {PARTNER: 'Total:', PLAY_POINTS: playpointsSum,WIN_POINTS:winpointsSum, MARGIN:margin, NET:net    });	
	}
});
jQuery("#listsg11").jqGrid('navGrid','#pagersg11',{add:false,edit:false,del:false});
</script>
             
          </div>
        </div>
        
      <?php if(isset($arrsp) && $arrsp!=''){
		if($form != 1){
	  ?>
      
        <div class="tableListWrap">
        <div class="PageHdr"><b>Sub Distributors</b></div>
          <div class="data-list">
            <table id="listsg12"></table>
            <div id="pagersg12"></div>
            <!--<script type="text/javascript">
                jQuery("#list5").jqGrid({
                    datatype: "local",
					colNames:['Partner','Total Bets','Total Wins','Margin','Net'],
                    colModel:[
						{name:'PARTNER1',index:'PARTNER1', align:"center", width:60},
						{name:'PLAYPOINTS1',index:'PLAYPOINTS1', align:"right", width:50},
						{name:'WINPOINTS1',index:'WINPOINTS1', align:"right", width:40},
						{name:'MARGIN1',index:'MARGIN1', align:"right", width:60},
						{name:'NET1',index:'NET1', align:"right", width:40},
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata1 = <?php echo json_encode($arrsp);?>;
                for(var i=0;i<=mydata1.length;i++)
                    jQuery("#list5").jqGrid('addRowData',i+1,mydata1[i]);
					
					
					
                </script> -->
             <script type="text/javascript"> 
jQuery("#listsg12").jqGrid({
   	url:'<?php echo base_url();?>reports/ajax/subdistreport/<?php echo $distid;?>?q=1&GAMES_TYPE='+"<?php echo $GAMES_TYPE; ?>"+'&AGENT_LIST='+"<?php echo $AGENT_LIST; ?>"+'&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Total Bets', 'Total Wins', 'Agent','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAY_POINTS',index:'PLAY_POINTS', width:115,sorttype: "float",align:"right"},
   		{name:'WIN_POINTS',index:'WIN_POINTS', width:115,sorttype: "float",align:"right"},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float"},
   		{name:'NET',index:'NET', width:115, align:"right",sorttype: "float"},		
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
		var rowData = $("#listsg12").getRowData(row_id);
		var partner_name = rowData.PARTNER;
		subgrid_table_id = subgrid_id+"_t";
		pager_id = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"<?php echo base_url();?>reports/ajax/subgrid_gamewise_subdistreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'&GAMES_TYPE='+"<?php echo $GAMES_TYPE; ?>"+'&AGENT_LIST='+"<?php echo $AGENT_LIST; ?>"+'',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Agent','Company','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:160,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:130,align:"right"},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:130,align:"right"},
				{name:"NET",index:"NET",width:130,align:"right"},
				{name:"MARGIN_PERCENTAGE",index:"MARGIN_PERCENTAGE",width:130,align:"center"},
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
		var playpointsSum = jQuery("#listsg12").jqGrid('getCol', 'PLAY_POINTS', false, 'sum').toFixed(2);
		var winpointsSum = jQuery("#listsg12").jqGrid('getCol', 'WIN_POINTS', false, 'sum').toFixed(2);
		var margin = jQuery("#listsg12").jqGrid('getCol', 'MARGIN', false, 'sum').toFixed(2);
		var net = jQuery("#listsg12").jqGrid('getCol', 'NET', false, 'sum').toFixed(2);
		jQuery("#listsg12").jqGrid('footerData','set', {PARTNER: 'Total:', PLAY_POINTS: playpointsSum,WIN_POINTS:winpointsSum, MARGIN:margin, NET:net    });	
	}
});
jQuery("#listsg12").jqGrid('navGrid','#pagersg12',{add:false,edit:false,del:false});
</script>   
          </div>
        </div>
        
	  <?php } } ?>
       
       
       
       <?php if(isset($arragnt) && $arragnt!=''){
		if($form != 1){
	?>
      
        <div class="tableListWrap">
        <div class="PageHdr"><b>Agent</b></div>
          <div class="data-list">
            <table id="listsg13"></table>
            <div id="pagersg13"></div>
            <!--<script type="text/javascript">
                jQuery("#list6").jqGrid({
                    datatype: "local",
					colNames:['Partner','Total Bets','Total Wins','Margin','Net'],
                    colModel:[
						{name:'PARTNER2',index:'PARTNER2', align:"center", width:60},
						{name:'PLAYPOINTS2',index:'PLAYPOINTS2', align:"right", width:50},
						{name:'WINPOINTS2',index:'WINPOINTS2', align:"right", width:40},
						{name:'MARGIN2',index:'MARGIN2', align:"right", width:60},
						{name:'NET2',index:'NET2', align:"right", width:40},
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata1 = <?php echo json_encode($arragnt);?>;
                for(var i=0;i<=mydata1.length;i++)
                    jQuery("#list6").jqGrid('addRowData',i+1,mydata1[i]);
					
					
					
                </script>
                
                <div class="Agent_total_Wrap1" style="width:1000px;">
                <div class="Agent_TotalShdr" style="width:230px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:189px"><div align="right"><?php echo number_format($allTotPlay, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:150px"><div align="right"><?php echo number_format($allTotWin, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:230px"><div align="right"><?php echo number_format($allTotComm, 2, '.', ''); ?></div></div>
                <div class="Agent_TotalRShdr" style="width:146px"><div align="right"><?php echo number_format($allTotpComm, 2, '.', '');?></div></div>

</div> -->

<script type="text/javascript"> 
jQuery("#listsg13").jqGrid({
   	url:'<?php echo base_url();?>reports/ajax/agent_report/<?php echo $distid;?>?q=1&GAMES_TYPE='+"<?php echo $GAMES_TYPE; ?>"+'&AGENT_LIST='+"<?php echo $AGENT_LIST; ?>"+'&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Total Bets', 'Total Wins', 'Agent','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAY_POINTS',index:'PLAY_POINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
   		{name:'WIN_POINTS',index:'WIN_POINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float",summaryType: 'sum', formatter: 'float'},
   		{name:'NET',index:'NET', width:115, align:"right",sorttype: "float",summaryType: 'sum', formatter: 'float'},		
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
			url:"<?php echo base_url();?>reports/ajax/subgrid_gamewise_agentreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'&distid=<?php echo $distid;?>'+'&GAMES_TYPE=<?php echo $GAMES_TYPE;?>'+'&AGENT_LIST=<?php echo $AGENT_LIST;?>',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Agent','Company','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:160,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:130,align:"right"},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:130,align:"right"},
				{name:"NET",index:"NET",width:130,align:"right"},
				{name:"MARGIN_PERCENTAGE",index:"MARGIN_PERCENTAGE",width:130,align:"center"},
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
		var margin = jQuery("#listsg13").jqGrid('getCol', 'MARGIN', false, 'sum').toFixed(2);
		var net = jQuery("#listsg13").jqGrid('getCol', 'NET', false, 'sum').toFixed(2);
		jQuery("#listsg13").jqGrid('footerData','set', {PARTNER: 'Total:', PLAY_POINTS: playpointsSum,WIN_POINTS:winpointsSum, MARGIN:margin, NET:net    });	
	}
});
jQuery("#listsg13").jqGrid('navGrid','#pagersg13',{add:false,edit:false,del:false});
</script>

          </div>
        </div>
        
	  <?php } } ?>
       
       
	<?php   
	   }
      } ?>
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>