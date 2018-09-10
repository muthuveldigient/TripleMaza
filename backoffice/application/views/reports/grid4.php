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
				height: '100%',
				width: 1002,
				colNames:['Username','Total Bets','Total Wins','Net'],
				colModel:[
					{name:'USER_NAME',index:'USER_NAME', align:"center", width:60},
					{name:'PLAYPOINTS1',index:'PLAYPOINTS1', align:"right", width:50,summaryType: 'sum', sorttype: 'float', formatter: 'float'},
					{name:'WINPOINTS1',index:'WINPOINTS1', align:"right", width:40,summaryType: 'sum', sorttype: 'float', formatter: 'float'},
					{name:'NET1',index:'NET1', align:"right", width:60,summaryType: 'sum', sorttype: 'float', formatter: 'float'}
					
				],
				footerrow: true,
				userDataOnFooter: true,
				rowNum:1000,
				viewrecords: true,
				multiselect: false,
			//	subGrid: true,	
				caption: "",
				loadtext: "Loading",
				loadComplete: function () {
					var mydata = <?php echo json_encode($arrsp);?>;
					var rowid =0;
					for(var i=0;i< mydata.length;i++) {
						rowid = mydata[i].id;
						jQuery("#list6").jqGrid('addRowData',rowid,mydata[i]);
					}
			
					var playpointsSum = jQuery("#list6").jqGrid('getCol', 'PLAYPOINTS1', false, 'sum').toFixed(2);
					var winpointsSum = jQuery("#list6").jqGrid('getCol', 'WINPOINTS1', false, 'sum').toFixed(2);
					var net = jQuery("#list6").jqGrid('getCol', 'NET1', false, 'sum').toFixed(2);
					console.log(playpointsSum);
					jQuery("#list6").jqGrid('footerData','set', {USER_NAME: 'Total:', PLAYPOINTS1: playpointsSum,WINPOINTS1:winpointsSum,NET1:net});	
				}
			});
			
			</script>
		<!--<div class="Agent_total_Wrap1" style="width:1000px;">
			<div class="Agent_TotalShdr" style="width:276px;text-align:right;">TOTAL:</div>
			<div class="Agent_TotalRShdr" style="width:227px"><div align="right"><?php echo number_format($allTotPlay, 2, '.', '');?></div></div>
			<div class="Agent_TotalRShdr" style="width:180px"><div align="right"><?php echo number_format($allTotWin, 2, '.', '');?></div></div>
			<div class="Agent_TotalRShdr" style="width:273px"><div align="right"><?php echo number_format($allTotpComm, 2, '.', '');?></div></div>
		</div>-->
	</div>
</div>