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
<?php	
		$superdistresults=$dresults['superdist_result'];
		$distresults=$dresults['dist_result'];
	    $resvalues=array();


        if(count($superdistresults)>0 && is_array($superdistresults)){
			for($i=0;$i<count($superdistresults);$i++){
				//get partner name
				$partnername	  = $superdistresults[$i]->SUPERDISTRIBUTOR_NAME;
				$totalbets  = $superdistresults[$i]->totbet;
				$totalwins  = $superdistresults[$i]->totwin;

				if($distresults[$i]->MARGIN)
					$commission=$superdistresults[$i]->MARGIN;
				else
					$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$superdistresults[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['RAKE'] =  $distresults[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;

				if($resvalue){
					$arrs[] = $resvalue;
				} $j++;
			}
        }else{
        	$arrs="";
        }

        if(count($distresults)>0 && is_array($distresults)){
	        for($l=0;$l<count($distresults);$l++){
				//get partner name
				$partnername	  = $distresults[$l]->DISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);

				$totalbets  = $distresults[$l]->totbet;
				$totalwins  = $distresults[$l]->totwin;
				//	$partnershare = $share;

				//	$commission=number_format($totalbets*($partnershare/100),2,'.','');
				//	$net=$totalbets-$totalwins;
				//	$partner_comm=$net-$commission;
				$commission = $distresults[$l]->MARGIN;
				$partner_comm = $distresults[$l]->NET;
				//$presvalue['SNO1']=$k+1;
				$presvalue['PARTNER1']= '<a href="'.base_url().'reports/turnover/userreport/'.$distresults[$l]->PARTNER_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'">'.$partnername.'</a>';
				$presvalue['PLAYPOINTS1'] = $totalbets;
				$resvalue['RAKE1'] =  $subdistresults[$l]->totrake;
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

	if(isset($arrs) && $arrs!=''){
		if($partnertype==11 || $partnertype==0){	 ?>
<style>
.searchWrap1{   background-color: #F8F8F8;    border: 1px solid #EEEEEE;    border-radius: 5px;    float: left;    width: 100%;	margin-top:10px;	font-size:13px; }
</style>

        <div class="tableListWrap">
          <div class="PageHdr"><b>Super Distributor</b></div>
          <div class="data-list">
           <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
             <table id="listsg21"></table>
            <div id="listsg21"></div>
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
jQuery("#listsg21").jqGrid({
   	url:'<?php echo base_url();?>reports/ajax/superdistpokerreport/<?php echo $superdistid;?>?q=1&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search',
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Play Points', 'Win Points','Player Loss', 'Total Rake','Agent Rake','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAYPOINTS',index:'PLAYPOINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
   		{name:'WINPOINTS',index:'WINPOINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
      {name:'PLAYER_LOSS',index:'PLAYER_LOSS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
	  {name:'TOTAL_RAKE',index:'TOTAL_RAKE', width:85, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
   		//{name:'NET',index:'NET', width:115, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
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
		var rowData = $("#listsg21").getRowData(row_id);
		var partner_name = rowData.PARTNER;
		subgrid_table_id = subgrid_id+"_t";
		pager_id = "p_"+subgrid_table_id;
		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
		jQuery("#"+subgrid_table_id).jqGrid({
			url:"<?php echo base_url();?>reports/ajax/poker_subgrid_gamewise_superdistreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Total Rake','Agent Rake','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:180,key:true},
				{name:"PLAY_POINTS",index:"PLAY_POINTS",width:110,align:"right"},
				{name:"WIN_POINTS",index:"WIN_POINTS",width:130,align:"right"},
        		{name:"TOTAL_RAKE",index:"TOTAL_RAKE",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:130,align:"right"},
				//{name:"NET",index:"NET",width:130,align:"right"},
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
	}
});
jQuery("#listsg21").jqGrid('navGrid','#listsg21',{add:false,edit:false,del:false});
</script>

          </div>
        </div>

      <?php if(isset($arrsp) && $arrsp!=''){ ?>

        <div class="tableListWrap">
        <div class="PageHdr"><b>Distributors</b></div>
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
   	url:'<?php echo base_url();?>reports/ajax/poker_superdistreport/<?php echo $superdistid;?>?q=1&START_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>"+'&END_DATE_TIME='+"<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>"+'&keyword=Search',
	datatype: "xml",
	height: '100%',
	width: 1002,
   	colNames:['Partner Name','Play Points', 'Win Points','Player Loss', 'Total Rake','Agent Rake','Company'],
   	colModel:[
   		{name:'PARTNER',index:'PARTNER', width:135,sorttype: "text"},
   		{name:'PLAYPOINTS',index:'PLAYPOINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
   		{name:'WINPOINTS',index:'WINPOINTS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
      {name:'PLAYER_LOSS',index:'PLAYER_LOSS', width:115,sorttype: "float",align:"right",summaryType: 'sum',  formatter: 'float'},
	  {name:'TOTAL_RAKE',index:'TOTAL_RAKE', width:85, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
   		{name:'MARGIN',index:'MARGIN', width:85, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
   		//{name:'NET',index:'NET', width:115, align:"right",sorttype: "float",summaryType: 'sum',  formatter: 'float'},
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
			url:"<?php echo base_url();?>reports/ajax/poker_subgrid_gamewise_distreport?q=2&pname="+partner_name+"&id="+row_id+"&START_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($START_DATE_TIME)); ?>'+"&END_DATE_TIME="+'<?php echo date("Y-m-d H:i:s",strtotime($END_DATE_TIME)); ?>'+'&keyword=Search'+'',
			datatype: "xml",
			colNames: ['Game','Play Points','Win Points','Total Rake','Agent Rake','Margin%','Type'],
			colModel: [
				{name:"GAME_ID",index:"GAME_ID",width:180,key:true},
				{name:"PLAYPOINTS",index:"PLAY_POINTS",width:110,align:"right"},
				{name:"WINPOINTS",index:"WIN_POINTS",width:130,align:"right"},
       			{name:"TOTAL_RAKE",index:"TOTAL_RAKE",width:130,align:"right"},
				{name:"MARGIN",index:"MARGIN",width:130,align:"right"},
				//{name:"NET",index:"NET",width:130,align:"right"},
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
	}
});
jQuery("#listsg12").jqGrid('navGrid','#pagersg12',{add:false,edit:false,del:false});
</script>
          </div>
        </div>

       <?php }  ?>
	<?php
	   }
      } ?>

      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>
