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
<script src="<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url(); ?>static/js/dw_loader.js" type="text/javascript"></script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Game Turn Over Report</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>reports/agent_game_turnover/report?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
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
				  </tr>
				<tr>
				<td width="40%"><span class="TextFieldHdr">Game Name:</span><br />
                  <label>
                  <select class="ListMenu"  name="gameid" id="gameid">
						<option value="">All</option>
						<?PHP
						foreach($activeGames as $rowcnt){  ?>
							<OPTION value="<?php echo $rowcnt->MINIGAMES_NAME; ?>" <?php if ($rowcnt->MINIGAMES_NAME == $_REQUEST['gameid']) { echo selected; }?>> <?php echo ucfirst(strtolower($rowcnt->DESCRIPTION)); ?> </OPTION> 					
						<?PHP } ?>
					</select>
                  </label>
                </td>
				
                <td width="40%"><span class="TextFieldHdr">Date Range:</span><br />
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
        <td><form action="<?php echo base_url();?>reports/agent_game_turnover/report?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
      
<?php	$results=$results['self_results'];
		$resvalues=array();

        	if(count($results)>0 && is_array($results)){
				for($i=0;$i<count($results);$i++){
					//get partner name
					if($partnertype==0){
						$partnername	  = $results[$i]->MAIN_AGEN_NAME;
					}else{
						$partnername	  = "Self";
					}
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
					$totalbets  = $results[$i]->totbet;
					$totalwins  = $results[$i]->totwin;
					$partnershare = $share;
						
					if($results[$i]->MARGIN)
						$commission=$results[$i]->MARGIN; 
					else
						$commission="0.00"; 
						
					//$net=$totalbets-$totalwins;   
					$partner_comm=$results[$i]->company;   
												
					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['NET'] = $partner_comm;
					$resvalue['MARGIN_PERCENTAGE'] = $results[$i]->MARGIN_PERCENTAGE;
					$resvalue['COMMISSION_TYPE'] = $results[$i]->PARTNER_COMMISSION_TYPE;
					if($partnertype==11){
						$resvalue['GAME_ID'] = '<a href="'.base_url().'reports/agent_game_turnover_lists/supdistreport/'.$results[$i]->GAME_DESCRIPTION.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search" onclick="return dw_Loader.load(this.href)"><strong>'.$results[$i]->GAME_DESCRIPTION.'</strong></a>';
					}elseif($partnertype==15){
						$resvalue['GAME_ID'] = '<a href="'.base_url().'reports/agent_game_turnover_lists/distreport/'.$results[$i]->GAME_DESCRIPTION.'/'.$results[$i]->SUPERDISTRIBUTOR_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search" onclick="return dw_Loader.load(this.href)"><strong>'.$results[$i]->GAME_DESCRIPTION.'</strong></a>';
					}elseif($partnertype==0){
						$resvalue['GAME_ID'] = '<a href="'.base_url().'reports/agent_game_turnover_lists/supdistreport/'.$results[$i]->GAME_DESCRIPTION.'/'.$results[$i]->MAIN_AGEN_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search" onclick="return dw_Loader.load(this.href)"><strong>'.$results[$i]->GAME_DESCRIPTION.'</strong></a>';
					}elseif($partnertype==12){
						$resvalue['GAME_ID'] = '<a href="'.base_url().'reports/agent_game_turnover_lists/subdistreport/'.$results[$i]->GAME_DESCRIPTION.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search" onclick="return dw_Loader.load(this.href)"><strong>'.$results[$i]->GAME_DESCRIPTION.'</strong></a>';
					}elseif($partnertype==13){
						$resvalue['GAME_ID'] = '<a href="'.base_url().'reports/agent_game_turnover_lists/subdistreport_details/'.$results[$i]->SUBDISTRIBUTOR_ID.'/'.$results[$i]->GAME_DESCRIPTION.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search" onclick="return dw_Loader.load(this.href)"><strong>'.$results[$i]->GAME_DESCRIPTION.'</strong></a>';
					}elseif($partnertype==14){
						$resvalue['GAME_ID'] = '<a href="'.base_url().'reports/agent_game_turnover_lists/agentgamereport_details/'.$results[$i]->PARTNER_ID.'/'.$results[$i]->GAME_DESCRIPTION.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search" onclick="return dw_Loader.load(this.href)"><strong>'.$results[$i]->GAME_DESCRIPTION.'</strong></a>';
					}
					$resvalue['TOTAL_GAMES'] = $results[$i]->total_games;
						
					if($totalwins!='' && $totalbets!=''){
						$payout=$results[$i]->PAYOUT;
					}else{
						$payout="0.00";
					}
						
					$resvalue['PAYOUT'] = number_format($payout,2,".","")."%";
																
					$allTotPlay1  += $totalbets;
					$allTotWin1  += $totalwins;
					$allTotComm1  += $commission;
					$allTotpComm1  += $partner_comm;
															
					if($resvalue){
						$arrs[] = $resvalue;
					}
					$j++;
				}
			}else{
            	$arrs="";
            }
             
	if(isset($arrs) && $arrs!=''){
		if($partnertype==15 || $partnertype==11 || $partnertype==12 || $partnertype==13 || $partnertype==14 || $partnertype==0){
		
		
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
	iframe#buffer { position:absolute; visibility:hidden; left:0; top:0; } 
	</style>
  		<div style="float: right; font-family:Arial, Helvetica, sans-serif; font-size:12px; color: green;">
        <?php
			switch($partnertype){
				case 1:
				echo 'Click on the game to view distributor details';
				break;
				case 2:
				echo 'Click on the game to view sub distributor details';
				break;
				case 3:
				echo 'Click on the game to view agent details';
				break;
				case 4:
				echo 'Click on the game to view user details';
				break;
			}
       ?>
        </div>
        <div class="tableListWrap">
          <div class="PageHdr"><b><?php if($partnertype==11){ echo 'Super Distributor'; }elseif($partnertype==0){ echo 'Main Agent';}elseif($partnertype==12){ echo ' Sub Distributor';}elseif($partnertype==13){ echo 'Agent';}elseif($partnertype==14){ echo 'Agent';}elseif($partnertype==15){ echo 'Super distributor';}?></b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list4"></table>
            <div id="pager3"></div>
             <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<!--            <script src="<?php //echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
            <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					//colNames:['S.No','Partner','Total Bets','Total Wins','Margin','House Wins'],
					colNames:['Partner','Total Bets','Total Wins','Margin','Company', 'Margin %','Total Game','Payout%','Game'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:40, sorttype: 'float'},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN',index:'MARGIN', align:"right", width:40, sorttype: 'float'},
						{name:'NET',index:'NET', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN_PERCENTAGE',index:'MARGIN_PERCENTAGE', align:"right", width:40},
						{name:'TOTAL_GAMES',index:'TOTAL_GAMES', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						{name:'GAME_ID',index:'GAME_ID', align:"center", width:70},
						
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%",
					footerrow: true,
					userDataOnFooter: true,
					viewrecords: true,
					gridComplete: function() {
						var $grid = $('#list4');						
						var playpointsSum = $grid.jqGrid('getCol', 'PLAYPOINTS', false, 'sum').toFixed(2);
						var winpointsSum = $grid.jqGrid('getCol', 'WINPOINTS', false, 'sum').toFixed(2);
						var margin = $grid.jqGrid('getCol', 'MARGIN', false, 'sum').toFixed(2);
						var net    = $grid.jqGrid('getCol', 'NET', false, 'sum').toFixed(2);
						var marginpercentage = "-";
						var total_games = $grid.jqGrid('getCol', 'TOTAL_GAMES', false, 'sum');
						var totalpayout1= (winpointsSum/playpointsSum)*100;
						var totalpayout = totalpayout1.toFixed(2)+ "%";
						var totalgame   = "-";							
						$grid.jqGrid('footerData', 'set', {
							PARTNER: 'Total:', 
							PLAYPOINTS: playpointsSum,
							WINPOINTS:winpointsSum, 
							MARGIN:margin, 
							NET:net,
							MARGIN_PERCENTAGE:marginpercentage,
							TOTAL_GAMES:total_games,
							PAYOUT:totalpayout,
							GAME_ID:totalgame						
						});
					}					
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
          </div>
        </div>
        <div id="display"></div>
        <iframe id="buffer" name="buffer" src="" width="300" height="600" onload="dw_Loader.display()"></iframe>
      <?php 
	   }
      }else{ 
		  if(empty($_POST) || $_POST['reset'] == 'Clear'){
		    $message  = "Please select the search criteria"; 
		  }else{
		    $message  = "There are currently no records found in this search criteria.";
		  }
		?>
        <div class="tableListWrap">
          <div class="data-list">
            <table id="list4" class="data">
              <tr>
                <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
              </tr>
            </table>
          </div>
        </div>
        <?php } ?>
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>