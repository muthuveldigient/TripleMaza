<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/js/date.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>

<script>
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
		  ?>
		  sdate='<?php echo $tdate;?>';
		  edate='<?php echo $lday;?>';
	  }
	  document.getElementById("START_DATE_TIME").value=sdate;
	  document.getElementById("END_DATE_TIME").value=edate;
  }
}
</script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
		echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
		<table width="100%" class="ContentHdr"> 
			<tr>
				<td><strong>Turn Over</strong></td>
			</tr>
		</table>
        <form action="<?php echo base_url(); ?>reports/agent_turnover/category?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
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
        <td><form action="<?php echo base_url();?>reports/agent_turnover/category?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
	if(isset($results) && $results!='') {
		if($partnertype==12){ //distributor login => subdistributor & agent based info
		
			$resvalue[0]['CATEGORYNAME'] = "<a href='".base_url()."reports/agent_turnover/shanreport?rid=62&keyword=Search&START_DATE_TIME=".$START_DATE_TIME."&END_DATE_TIME=".$END_DATE_TIME."''>Shan</a>";
			if(!empty($results["shan_results"][0]->totbet) || !empty($results["shan_results1"][0]->totbet)){
				$shanBet =(!empty($results["shan_results"][0]->totbet)?$results["shan_results"][0]->totbet:0);
				$shanBet1 =(!empty($results["shan_results1"][0]->totbet)?$results["shan_results1"][0]->totbet:0);
				$resvalue[0]['PLAYPOINTS']   = $shanBet+$shanBet1;
			}else{
				$resvalue[0]['PLAYPOINTS']   = "0.00";
			}
			
			if(!empty($results["shan_results"][0]->totwin) || !empty($results["shan_results1"][0]->totwin)){
				$shanTotwin =(!empty($results["shan_results"][0]->totwin)?$results["shan_results"][0]->totwin:0);
				$shanTotwin1 =(!empty($results["shan_results1"][0]->totwin)?$results["shan_results1"][0]->totwin:0);
				$resvalue[0]['WINPOINTS']	 = $shanTotwin+$shanTotwin1;
			}else{
				$resvalue[0]['WINPOINTS']    = "0.00";
			}
			if(!empty($results["shan_results"][0]->margin) || !empty($results["shan_results1"][0]->margin))	{
				$shanMargin =(!empty($results["shan_results"][0]->margin)?$results["shan_results"][0]->margin:0);
				$shanMargin1 =(!empty($results["shan_results1"][0]->margin)?$results["shan_results1"][0]->margin:0);
				$resvalue[0]['MARGIN']	         = $shanMargin+ $shanMargin1;
			}else{
				$resvalue[0]['MARGIN']	         = "0.00";
			}

			if(!empty($results["shan_results"][0]->company) || !empty($results["shan_results1"][0]->company)){
				$shanCompany =(!empty($results["shan_results1"][0]->company)?$results["shan_results1"][0]->company:0);
				$shanCompany1 =(!empty($results["shan_results1"][0]->company)?$results["shan_results1"][0]->company:0);
				$resvalue[0]['NET']	         = $shanCompany+$shanCompany1;
			}else{
				$resvalue[0]['NET']	         = "0.00";
			}
			
			$resvalue[1]['CATEGORYNAME'] = "<a href='".base_url()."reports/agent_turnover/report?rid=62&keyword=Search&START_DATE_TIME=".$START_DATE_TIME."&END_DATE_TIME=".$END_DATE_TIME."'>eGames</a>";
			if(!empty($results["casino_results"][0]->totbet) || !empty($results["casino_results1"][0]->totbet)){
				$casinoTotbet =(!empty($results["casino_results1"][0]->totbet)?$results["casino_results1"][0]->totbet:0);
				$casinoTotbet1 =(!empty($results["casino_results1"][0]->totbet)?$results["casino_results1"][0]->totbet:0);
				$resvalue[1]['PLAYPOINTS']   = $casinoTotbet+$casinoTotbet1;
			}else{
				$resvalue[1]['PLAYPOINTS']   = "0.00";
			}
			
			if(!empty($results["casino_results"][0]->totwin) || !empty($results["casino_results1"][0]->totwin)){
				$casinoTotwin =(!empty($results["casino_results"][0]->totwin)?$results["casino_results"][0]->totwin:0);
				$casinoTotwin1 =(!empty($results["casino_results1"][0]->totwin)?$results["casino_results1"][0]->totwin:0);
				$resvalue[1]['WINPOINTS']	 = $casinoTotwin+$casinoTotwin1;
			}else{
				$resvalue[1]['WINPOINTS']    = "0.00";
			}
				
			if(!empty($results["casino_results"][0]->margin) || !empty($results["casino_results1"][0]->totwin)){
				$casinoMargin =(!empty($results["casino_results"][0]->totwin)?$results["casino_results"][0]->margin:0);
				$casinoMargin1 =(!empty($results["casino_results1"][0]->totwin)?$results["casino_results1"][0]->margin:0);
				$resvalue[1]['MARGIN']	         = $casinoMargin+$casinoMargin1;
			}else{
				$resvalue[1]['MARGIN']	         = "0.00";	
			}
			if(!empty($results["casino_results"][0]->company) || !empty($results["casino_results1"][0]->company)){	
				$casinoCompany =(!empty($results["casino_results"][0]->company)?$results["casino_results"][0]->company:0);
				$casinoCompany1 =(!empty($results["casino_results1"][0]->company)?$results["casino_results1"][0]->company:0);
				$resvalue[1]['NET']	         = $casinoCompany+$casinoCompany1;
			}else{
				$resvalue[1]['NET']	         = "0.00";			
			}
			$resvalue[2]['CATEGORYNAME'] = "<a href='".base_url()."reports/agent_turnover/pokerreport?rid=62&keyword=Search&START_DATE_TIME=".$START_DATE_TIME."&END_DATE_TIME=".$END_DATE_TIME."''>Poker</a>";
			if(!empty($results["poker_results"][0]->totbet) || !empty($results["poker_results1"][0]->totbet)){
				$pokerTotbet =(!empty($results["poker_results"][0]->totbet)?$results["poker_results"][0]->totbet:0);
				$pokerTotbet1 =(!empty($results["poker_results1"][0]->totbet)?$results["poker_results1"][0]->totbet:0);
				$resvalue[2]['PLAYPOINTS']   = $pokerTotbet+$pokerTotbet1;
			}else{
				$resvalue[2]['PLAYPOINTS']   = "0.00";
			}
			
			if(!empty($results["poker_results"][0]->totwin) || !empty($results["poker_results1"][0]->totwin)){
				$pokerTotwin =(!empty($results["poker_results"][0]->totwin)?$results["poker_results"][0]->totwin:0);
				$pokerTotwin1 =(!empty($results["poker_results1"][0]->totwin)?$results["poker_results1"][0]->totwin:0);
				$resvalue[2]['WINPOINTS']	 = $pokerTotwin+$pokerTotwin1;
			}else{
				$resvalue[2]['WINPOINTS']    = "0.00";
			}
			if(!empty($results["poker_results"][0]->margin) || !empty($results["poker_results1"][0]->margin)){
				$pokerMargin =(!empty($results["poker_results"][0]->margin)?$results["poker_results"][0]->margin:0);
				$pokerMargin1 =(!empty($results["poker_results1"][0]->margin)?$results["poker_results1"][0]->margin:0);
				$resvalue[2]['MARGIN']	         = $pokerMargin+$pokerMargin1;
			}else{
				$resvalue[2]['MARGIN']	         = "0.00";
			}
			if(!empty($results["poker_results"][0]->company) || !empty($results["poker_results1"][0]->company))	{
				$pokerCompany =(!empty($results["poker_results"][0]->company)?$results["poker_results"][0]->company:0);
				$pokerCompany1 =(!empty($results["poker_results1"][0]->company)?$results["poker_results1"][0]->company:0);
				$resvalue[2]['NET']	         = $pokerCompany+$pokerCompany1;
			}else{
				$resvalue[2]['NET']	         = "0.00";	
			}
			
		}else{
				$resvalue[0]['CATEGORYNAME'] = "<a href='".base_url()."reports/agent_turnover/shanreport?rid=62&keyword=Search&START_DATE_TIME=".$START_DATE_TIME."&END_DATE_TIME=".$END_DATE_TIME."''>Shan</a>";
			if(!empty($results["shan_results"][0]->totbet)){
				$resvalue[0]['PLAYPOINTS']   = $results["shan_results"][0]->totbet;
			}else{
				$resvalue[0]['PLAYPOINTS']   = "0.00";
			}
			if(!empty($results["shan_results"][0]->totwin)){
				$resvalue[0]['WINPOINTS']	 = $results["shan_results"][0]->totwin;
			}else{
				$resvalue[0]['WINPOINTS']    = "0.00";
			}
				
			if(!empty($results["shan_results"][0]->margin))	{
				$resvalue[0]['MARGIN']	         = $results["shan_results"][0]->margin;
			}else{
				$resvalue[0]['MARGIN']	         = "0.00";
			}

			if(!empty($results["shan_results"][0]->company)){	
				$margin =(!empty($results["shan_results1"][0]->margin)?$results["shan_results1"][0]->margin:0);
				$resvalue[0]['NET']	         = $results["shan_results"][0]->company;
			}else{
				$resvalue[0]['NET']	         = "0.00";
			}
			
			$resvalue[1]['CATEGORYNAME'] = "<a href='".base_url()."reports/agent_turnover/report?rid=62&keyword=Search&START_DATE_TIME=".$START_DATE_TIME."&END_DATE_TIME=".$END_DATE_TIME."'>eGames</a>";
			if(!empty($results["casino_results"][0]->totbet)){
				$resvalue[1]['PLAYPOINTS']   = $results["casino_results"][0]->totbet;
			}else{
				$resvalue[1]['PLAYPOINTS']   = "0.00";
			}
			
			if(!empty($results["casino_results"][0]->totwin)){
				$resvalue[1]['WINPOINTS']	 = $results["casino_results"][0]->totwin;
			}else{
				$resvalue[1]['WINPOINTS']    = "0.00";
			}
				
			if(!empty($results["casino_results"][0]->margin)){
				$resvalue[1]['MARGIN']	         = $results["casino_results"][0]->margin;
			}else{
				$resvalue[1]['MARGIN']	         = "0.00";	
			}

			if(!empty($results["casino_results"][0]->company)){
				$resvalue[1]['NET']	         = $results["casino_results"][0]->company;
			}else{
				$resvalue[1]['NET']	         = "0.00";			
			}
				
			if(!empty($results["poker_results"][0]->totbet)) {
				$resvalue[2]['CATEGORYNAME'] = "<a href='".base_url()."reports/agent_turnover/pokerreport?rid=62&keyword=Search&START_DATE_TIME=".$START_DATE_TIME."&END_DATE_TIME=".$END_DATE_TIME."''>Poker</a>";
				if(!empty($results["poker_results"][0]->totbet)){
					$resvalue[2]['PLAYPOINTS']   = $results["poker_results"][0]->totbet;
				}else{
					$resvalue[2]['PLAYPOINTS']   = "0.00";
				}
				
				if(!empty($results["poker_results"][0]->totwin)){
					$resvalue[2]['WINPOINTS']	 = $results["poker_results"][0]->totwin;
				}else{
					$resvalue[2]['WINPOINTS']    = "0.00";
				}
					
				if(!empty($results["poker_results"][0]->margin)){
					$resvalue[2]['MARGIN']	         = $results["poker_results"][0]->margin;
				}else{
					$resvalue[2]['MARGIN']	         = "0.00";
				}
					
				if(!empty($results["poker_results"][0]->company)){
					$resvalue[2]['NET']	         = $results["poker_results"][0]->company;
				}else{
					$resvalue[2]['NET']	         = "0.00";	
				}
			}	
		}
			
		$totalbet=$results["shan_results"][0]->totbet+$results["casino_results"][0]->totbet+$results["poker_results"][0]->totbet;
		$totalwin=$results["shan_results"][0]->totwin+$results["casino_results"][0]->totwin+$results["poker_results"][0]->totwin;
		$totalmargin=$results["shan_results"][0]->margin+$results["casino_results"][0]->margin+$results["poker_results"][0]->margin;
		$totalcompany=$results["shan_results"][0]->company+$results["casino_results"][0]->company+$results["poker_results"][0]->company;
		if($partnertype==12){
			$totalbet+=$results["shan_results1"][0]->totbet+$results["casino_results1"][0]->totbet+$results["poker_results1"][0]->totbet;
			$totalwin+=$results["shan_results1"][0]->totwin+$results["casino_results1"][0]->totwin+$results["poker_results1"][0]->totwin;
			$totalmargin+=$results["shan_results1"][0]->margin+$results["casino_results1"][0]->margin+$results["poker_results1"][0]->margin;
			$totalcompany+=$results["shan_results1"][0]->company+$results["casino_results1"][0]->company+$results["poker_results1"][0]->company;
		} 
		
	}												
			if(isset($resvalue) && $resvalue!=''){
			?>
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
<p class="searchWrap1" style="height:30px;">
	<span style="position:relative;top:8px;left:10px"> <b> Total Play Points: <font color="#FF3300">(<?php echo number_format($totalbet, 2, '.', ''); ?>) </font></b></span>
	<span style="position:relative;top:8px;left:10px"> <b> Total Win Points: <font color="#FF3300">(<?php echo number_format($totalwin, 2, '.', ''); ?>) </font></b></span>
	<span style="position:relative;top:8px;left:10px"> <b> Total Margin: <font color="#FF3300">(<?php echo number_format($totalmargin, 2, '.', ''); ?>) </font></b></span>	
	<span style="position:relative;top:8px;left:10px"> <b> Total Company: <font color="#FF3300">(<?php echo number_format($totalcompany, 2, '.', ''); ?>) </font></b></span> 
</p>	
			<div class="tableListWrap">
			  <div class="data-list">
				<table id="list2">
				</table>
				<div id="pager2"></div>
				<script type="text/javascript">
					jQuery("#list2").jqGrid({
						datatype: "local",
						colNames:['Category', 'Play Points', 'Win Points','Agent','Company'],
						colModel:[
							{name:'CATEGORYNAME',index:'CATEGORYNAME',align:"left", width:140,sortable:true},
							{name:'PLAYPOINTS',index:'PLAYPOINTS',align:"right", width:90,sortable:true},
							{name:'WINPOINTS',index:'WINPOINTS',align:"right", width:90,sortable:true},
							{name:'MARGIN',index:'MARGIN',align:"right", width:90,sortable:true},
							{name:'NET',index:'NET',align:"right", width:90,sortable:true}														
						],
						rowNum:500,
						width: 999, height: "100%"
					});
					var mydata = <?php echo json_encode($resvalue);?>;
					for(var i=0;i<=mydata.length;i++)
						jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);
				</script>
			  </div>
			</div>        
        
		  <?php   
		  }else{ 
				$message  = "There are currently no records found in this search criteria.";
		 } ?>
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>