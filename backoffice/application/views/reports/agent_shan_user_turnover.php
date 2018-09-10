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
        <?php
		$agent_results=$agntresults['agnt_result'];
        $user_results=$agntresults['user_result'];
	    $resvalues=array();
 
 		if(count($agent_results)>0 && is_array($agent_results)){
			for($i=0;$i<count($agent_results);$i++){
				//get partner name
				$partnername	  = $agent_results[$i]->PARTNER_NAME;
				$totalbets  = $agent_results[$i]->totbet;
				$totalwins  = $agent_results[$i]->totwin;
				$totalrake  = $agent_results[$i]->TOTAL_RAKE;
				$playerloss = $agent_results[$i]->PLAYER_LOSS;
				$settleamount= $agent_results[$i]->SETTLEMENT_AMOUNT;				
					
				if($agent_results[$i]->MARGIN)
					$commission=$agent_results[$i]->MARGIN; 
				else
					$commission="0.00"; 
						
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_results[$i]->NET;   
													
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

        if(count($user_results)>0 && is_array($user_results)){
	        for($l=0;$l<count($user_results);$l++){
				//get partner name
				$partnername	  = $user_results[$l]->USER_NAME;
				//get partner revenueshare
				//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
				$totalbets  = $user_results[$l]->totbet;
				$totalwins  = $user_results[$l]->totwin;
				$totalrake  = $user_results[$l]->TOTAL_RAKE;
				$playerloss = $user_results[$i]->PLAYER_LOSS;
				$settleamount= $user_results[$i]->SETTLEMENT_AMOUNT;				
				//	$partnershare = $share;
				//	$commission=number_format($totalbets*($partnershare/100),2,'.',''); 
				//	$net=$totalbets-$totalwins;   
				//	$partner_comm=$net-$commission;  
				$partner_comm = $user_results[$l]->NET;						
				//$presvalue['SNO1']=$k+1;
				if($user_results[$l]->GAME_ID=='shan_mp'){
					$presvalue['USER_NAME']= $partnername;//'<a href="'.base_url().'reports/agent_game_history/usergame_history/?rid='.$rid.'&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'&keyword=Search&playerID='.$partnername.'">'.$partnername.'</a>';
				}else{
					$presvalue['USER_NAME']= $partnername;//'<a href="'.base_url().'reports/agent_game_history/usergame_history/?rid='.$rid.'&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'&keyword=Search&playerID='.$partnername.'">'.$partnername.'</a>';
				}
				$presvalue['PLAYPOINTS1'] = $totalbets;
				$presvalue['WINPOINTS1']	= $totalwins;
				$presvalue['TOTAL_RAKE']	= $totalrake;
				$presvalue['NET1'] = $partner_comm;
				$presvalue['PLAYER_LOSS'] = $playerloss;
				$presvalue['SETTLEMENT_AMOUNT'] = $settleamount;					
																
				$allTotPlay  += $totalbets;
				$allTotWin  += $totalwins;
				$allTotRake += $totalrake;
				$allTotpComm  += $partner_comm;
				$allTotpLoss  += $playerloss;
				$allTotpSamt  += $settleamount;				
															
				if($presvalue){
					$arrsp[] = $presvalue;
				}
				$k++;
			}
        }else{
        	$arrsp="";
        }

		if(isset($arrs) && $arrs!=''){
			if($partnertype==15 || $partnertype==11 || $partnertype==12 || $partnertype==13 || $partnertype==0){	 ?>
<style>
.searchWrap1{   background-color: #F8F8F8;    border: 1px solid #EEEEEE;    border-radius: 5px;    float: left;    width: 100%;	margin-top:10px;	font-size:13px; }
</style>
  
        <div class="tableListWrap">
          <div class="PageHdr"><b>Agent</b></div>
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
            <!--<script type="text/javascript">
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
   	url:'<?php echo base_url();?>reports/ajax/agent_shan_userreport/<?php echo $agntid; ?>?q=1&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Play Points', 'Win Points','Player Loss', 'Total Rake','Agent Rake','Company'],
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
		var rowData = $("#listsg11").getRowData(row_id);
		var partner_name = rowData.PARTNER;
		subgrid_table_id = subgrid_id+"_t";
		pager_id = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"<?php echo base_url();?>reports/ajax/subgrid_shangamewise_agentreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Total Rake','Agent Rake','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:130,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:130,align:"right", sorttype: 'float'},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right", sorttype: 'float'},
				{name:"TOTAL_RAKE",index:"TOTAL_RAKE",width:130,align:"right", sorttype: 'float'},
				{name:"MARGIN",index:"MARGIN",width:110,align:"right", sorttype: 'float'},
				//{name:"NET",index:"NET",width:110,align:"right", sorttype: 'float'},
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
jQuery("#listsg11").jqGrid('navGrid','#pagersg11',{add:false,edit:false,del:false});
</script>  
          </div>
        </div>
        
       <?php if(isset($arrsp) && $arrsp!=''){ ?>
      
        <div class="tableListWrap">
        <div class="PageHdr"><b>User</b></div>
          <div class="data-list">
            <table id="list6" class="data">
              <tr>
                <td></td>
              </tr>
            </table>
            <div id="pager6"></div>
            <script type="text/javascript">
                jQuery("#list6").jqGrid({
                    datatype: "local",
					colNames:['Username','Play Poins','Win Points','Total Rake','Net'],
                    colModel:[
						{name:'USER_NAME',index:'USER_NAME', align:"center", width:60},
						{name:'PLAYPOINTS1',index:'PLAYPOINTS1', align:"right", width:50,summaryType: 'sum', sorttype: 'float', formatter: 'float'},
						{name:'WINPOINTS1',index:'WINPOINTS1', align:"right", width:40,summaryType: 'sum', sorttype: 'float', formatter: 'float'},
						{name:'TOTAL_RAKE',index:'TOTAL_RAKE', align:"right", width:40,summaryType: 'sum', sorttype: 'float', formatter: 'float'},
						{name:'NET1',index:'NET1', align:"right", width:60,summaryType: 'sum', sorttype: 'float', formatter: 'float'}
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata1 = <?php echo json_encode($arrsp);?>;
                for(var i=0;i<=mydata1.length;i++)
                    jQuery("#list6").jqGrid('addRowData',i+1,mydata1[i]);
					
                </script>
                <div class="Agent_total_Wrap1" style="width:1000px;">
                <div class="Agent_TotalShdr" style="width:230px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:189px"><div align="right"><?php echo number_format($allTotPlay, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:150px"><div align="right"><?php echo number_format($allTotWin, 2, '.', '');?></div></div>
				<div class="Agent_TotalRShdr" style="width:150px"><div align="right"><?php echo number_format($allTotRake, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:226px"><div align="right"><?php echo number_format($allTotpComm, 2, '.', '');?></div></div>
				</div>
          </div>
        </div>
        
       <?php }
	   }
      } ?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>