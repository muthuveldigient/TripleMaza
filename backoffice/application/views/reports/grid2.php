<?php //echo '<pre>';print_r($arrs1);exit; ?>
<style>
.searchWrap1 { background-color: #F8F8F8;    border: 1px solid #EEEEEE;    border-radius: 5px;    float: left;    width: 100%;	margin-top:10px;	font-size:13px;  }
</style>
  
<div class="tableListWrap">
<div class="PageHdr"><b><?php echo $TITLE2; ?></b></div>
<div class="data-list">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
	<table id="grid2"></table>
	<div id="pager2"></div>
	<script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
	<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
	<!--<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
	<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
	<script type="text/javascript"> 
	
	jQuery("#grid2").jqGrid({
		//url:'<?php echo base_url();?>reports/ajax/subgrid_report?q=1&PARTNER_TYPE='+"<?php echo $PARTNER_TYPE; ?>"+'&GAMES_TYPE='+"<?php echo $GAMES_TYPE; ?>"+'&AGENT_LIST='+"<?php echo $AGENT_LIST; ?>"+'&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search', 
		datatype: "local",
		height: '100%',
		width: 1002,
		colNames:['Partner Name','Play Point', 'Win Point', 'Agent','Company'],
		colModel:[
			{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
			{name:'PLAY_POINTS',index:'PLAY_POINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
			{name:'WIN_POINTS',index:'WIN_POINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
			{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
			{name:'NET',index:'NET', width:115, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},		
		],
		footerrow: true,
		userDataOnFooter: true,
		rowNum:1000,
		viewrecords: true,
		multiselect: false,
		subGrid: true,	
		caption: "",
		loadtext: "Loading",
		subGridRowExpanded: function(subgrid_id, row_id) {
			var subgrid_table_id, pager_id;
			var rowData = $("#grid2").getRowData(row_id);
			var partner_name = rowData.PARTNER;
			subgrid_table_id = subgrid_id+"_t";
			pager_id = "p_"+subgrid_table_id;
			var aurls = '<?php echo base_url()."reports/ajaxgrid/gameinfo?q=2&GAMES_TYPE=$GAMES_TYPE&PARTNER_TYPE=$PARTNER_TYPE2&START_DATE_TIME=$START_DATE_TIME&END_DATE_TIME=$END_DATE_TIME&keyword=Search"?>&AGENT_LIST='+row_id; 
			$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
			jQuery("#"+subgrid_table_id).jqGrid({
				url:aurls,
				datatype: "xml",
				colNames: ['Game','Play Points','Win Points','Agent','Company','Margin%','Type'],
				colModel: [
					{name:"GAME_ID",index:"GAME_ID",width:160,key:true},
					{name:"PLAYPOINTS",index:"PLAYPOINTS",width:130,align:"right"},
					{name:"WINPOINTS",index:"WINPOINTS",width:130,align:"right"},
					{name:"MARGIN_AMT",index:"MARGIN_AMT",width:130,align:"right"},
					{name:"NET_VALUE",index:"NET_VALUE",width:130,align:"right"},
					{name:"MARGIN_PERCENTAGE",index:"MARGIN_PERCENTAGE",width:130,align:"center"},
					{name:"TYPE",index:"TYPE",width:70,align:"left"}				
				],
				sortname: 'num',
				sortorder: "asc",
				loadtext: "Loading",
				height: '100%',
				rowNum:1000
			});
			jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false})
		},
		subGridRowColapsed: function(subgrid_id, row_id) {
		},
		loadComplete: function () {
			var mydata = <?php echo json_encode($arrs1);?>;
			var rowid =0;
			for(var i=0;i< mydata.length;i++) {
				rowid = mydata[i].id;
				jQuery("#grid2").jqGrid('addRowData',rowid,mydata[i]);
			}
			var playpointsSum = jQuery("#grid2").jqGrid('getCol', 'PLAY_POINTS', false, 'sum').toFixed(2);
			var winpointsSum = jQuery("#grid2").jqGrid('getCol', 'WIN_POINTS', false, 'sum').toFixed(2);
			var margin = jQuery("#grid2").jqGrid('getCol', 'MARGIN', false, 'sum').toFixed(2);
			var net = jQuery("#grid2").jqGrid('getCol', 'NET', false, 'sum').toFixed(2);
			jQuery("#grid2").jqGrid('footerData','set', {PARTNER: 'Total:', PLAY_POINTS: playpointsSum,WIN_POINTS:winpointsSum, MARGIN:margin, NET:net    });	
		}
	});

		

	jQuery("#grid2").jqGrid('navGrid','#pagersg11',{add:false,edit:false,del:false});

</script>       
</div>
</div>
        

     